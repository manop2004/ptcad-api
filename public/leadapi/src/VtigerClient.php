<?php
declare(strict_types=1);

class VtigerClient
{
    private array  $cfg;
    private string $sessionFile;

    // Fields ที่เป็น internal ของ API — ห้ามส่งผ่านไป CRM โดยตรง
    private const RESERVED_FIELDS = ['campaign_id', 'recaptcha_token', 'pool'];

    public  ?array  $lastCampaignError = null;
    private ?string $campaignTabId     = null;

    public function __construct(array $cfg)
    {
        $this->cfg         = $cfg;
        $this->sessionFile = rtrim($cfg['storage_dir'], '/') . '/vtiger_session';
    }

    /**
     * สร้าง Lead ใน Vtiger CRM
     *
     * รองรับทุก field ที่ Leads module มี รวมถึง cf_* custom fields
     *
     * $data รองรับ:
     *   - ทุก field มาตรฐานของ Leads: lastname, firstname, email, phone, mobile,
     *     company, designation, department, website, description, leadsource,
     *     lead_source_description, annualrevenue, industry, rating, no_of_employees,
     *     salutation, secondaryemail, fax, city, state, country, zip, lane, ...
     *   - Custom fields: cf_xxx ใดๆ ที่สร้างไว้ใน CRM
     *   - campaign_id    (int)    numeric ID ของ Campaign — link lead + ดึง owner เป็น default
     *   - assigned_user_id (string) format "19x5" — override ค่าจาก campaign/config
     *
     * คืน:
     *   ['success' => true,  'lead_id' => '7x123', 'lead' => [...full record...]]
     *   ['success' => false, 'error'   => '...']
     */
    public function createLead(array $data): array
    {
        $session = $this->getSession();
        if (!$session) {
            return ['success' => false, 'error' => 'CRM authentication failed'];
        }

        // ── Campaign lookup ──────────────────────────────────────────────────
        $campaignWsId    = null;
        $campaignOwnerId = null;
        $campaignId      = isset($data['campaign_id']) ? (int)$data['campaign_id'] : 0;

        if ($campaignId > 0) {
            $campaign = $this->getCampaign($session, $campaignId);
            if ($campaign) {
                $campaignWsId    = $campaign['id'];
                $campaignOwnerId = $campaign['assigned_user_id'];
            } else {
                // Campaigns module ไม่ accessible ผ่าน REST API
                // ลอง build WS ID จาก config tabid เพื่อ set_relationship
                $fallbackTabId = $this->cfg['campaigns_tabid'] ?? null;
                if ($fallbackTabId) {
                    $campaignWsId = "{$fallbackTabId}x{$campaignId}";
                }
                // ไม่ได้ campaign owner → ใช้ config default (ไม่ fail)
                error_log("[VtigerClient] Campaign lookup failed, proceeding without campaign owner. Error: " . json_encode($this->lastCampaignError));
            }
        }

        // ── กำหนด assigned_user_id ───────────────────────────────────────────
        // Priority: 1) request  2) round robin  3) campaign owner  4) config default
        $poolName = trim($data['pool'] ?? 'default');
        if (trim($data['assigned_user_id'] ?? '') !== '') {
            $assignedUserId = trim($data['assigned_user_id']);
        } elseif (!empty($this->cfg['round_robin']['enabled'])) {
            $rr = new RoundRobin($this->cfg['round_robin'], $this->cfg['storage_dir'], $this);
            $assignedUserId = $rr->next($poolName) ?? $campaignOwnerId ?? $this->cfg['crm_owner_id'];
        } elseif ($campaignOwnerId !== null) {
            $assignedUserId = $campaignOwnerId;
        } else {
            $assignedUserId = $this->cfg['crm_owner_id'];
        }

        // ── Build element — dynamic: ส่งผ่านทุก field ─────────────────────────
        $element = $this->buildElement($data, $assignedUserId, $campaignWsId);

        // ── Create Lead ───────────────────────────────────────────────────────
        $result = $this->callCreate($session, $element);
        \error_log('[VtigerClient DEBUG] CRM raw response: ' . json_encode($result));

        // Session หมดอายุกลางคัน → login ใหม่แล้วลองอีกครั้ง
        if (
            !$result['success'] &&
            isset($result['error']['code']) &&
            in_array($result['error']['code'], ['AUTHENTICATION_REQUIRED', 'INVALID_SESSION_ID'], true)
        ) {
            $this->clearSession();
            $session = $this->getSession();
            if ($session) {
                $result = $this->callCreate($session, $element);
            }
        }

        if (!$result['success']) {
            return ['success' => false, 'error' => $result['error']['message'] ?? 'CRM create failed'];
        }

        return [
            'success' => true,
            'lead_id' => $result['result']['id'] ?? null,
            'lead'    => $result['result'],
        ];
    }

    // ────────────────────────────────────────────────────────────────────────
    // Public helpers (used by RoundRobin)
    // ────────────────────────────────────────────────────────────────────────

    /**
     * คืน WS user IDs ทั้งหมดที่ active และอยู่ใน role นั้น
     * เช่น ['19x5', '19x11', '19x15']
     */
    public function queryUserIdsByRole(string $roleId): array
    {
        $session = $this->getSession();
        if (!$session) {
            return [];
        }

        // Vtiger WS ไม่รองรับ WHERE roleid='H4' (INVALID_ID_ATTRIBUTE)
        // → ดึง users ทั้งหมดแล้ว filter ด้วย PHP แทน
        $res = $this->httpGet('webservice.php', [
            'operation'   => 'query',
            'sessionName' => $session,
            'query'       => "SELECT id, roleid FROM Users WHERE status='Active';",
        ]);

        if (!$res || empty($res['success']) || !is_array($res['result'] ?? null)) {
            error_log("[VtigerClient] queryUserIdsByRole({$roleId}) failed: " . json_encode($res));
            return [];
        }

        return array_column(
            array_filter($res['result'], fn($u) => ($u['roleid'] ?? '') === $roleId),
            'id'
        );
    }

    // ────────────────────────────────────────────────────────────────────────
    // Private Methods
    // ────────────────────────────────────────────────────────────────────────

    /**
     * สร้าง element array สำหรับส่งไป CRM
     * ส่งผ่านทุก field ใน $data ยกเว้น RESERVED_FIELDS
     * รองรับ cf_* และ field มาตรฐานทุกตัว
     */
    private function buildElement(array $data, string $assignedUserId, ?string $campaignWsId = null): array
    {
        $element = [];

        foreach ($data as $key => $value) {
            // ข้าม reserved fields
            if (in_array($key, self::RESERVED_FIELDS, true)) {
                continue;
            }
            // ข้าม null/empty string (ให้ CRM ใช้ default)
            if ($value === null || $value === '') {
                continue;
            }
            // Sanitize: trim string values
            $element[$key] = is_string($value) ? trim($value) : $value;
        }

        // Force assigned_user_id (อาจ override ค่าที่ user ส่งมาด้วย priority ที่คำนวณแล้ว)
        $element['assigned_user_id'] = $assignedUserId;

        // Set campaignid (WS format เช่น "8x27") — CRM แปลงเป็น numeric เอง
        // CampaignLeadsHandler จัดการ vtiger_campaignleadrel ให้อัตโนมัติ
        if ($campaignWsId !== null) {
            $element['campaignid'] = $campaignWsId;
        }

        // Default leadsource ถ้าไม่ส่งมา
        if (empty($element['leadsource'])) {
            $element['leadsource'] = 'Web Site';
        }

        return $element;
    }

    /**
     * ดึงข้อมูล Campaign จาก CRM โดยใช้ retrieve (ไม่ใช้ query เพราะ Campaigns module บล็อก VQL)
     * ต้องรู้ tabId ก่อน → ใช้ describe เพื่อดึง idPrefix
     */
    private function getCampaign(string $session, int $campaignId): ?array
    {
        // ดึง tabId ของ Campaigns module (cache ไว้ใน property)
        $tabId = $this->getCampaignTabId($session);
        if (!$tabId) {
            $this->lastCampaignError = ['reason' => 'Cannot determine Campaigns tabId via describe'];
            return null;
        }

        // retrieve ด้วย WS ID format: {tabId}x{campaignId}
        $wsId = "{$tabId}x{$campaignId}";
        $res  = $this->httpPost('webservice.php', [
            'operation'   => 'retrieve',
            'sessionName' => $session,
            'id'          => $wsId,
        ]);

        if (!$res || empty($res['success'])) {
            error_log("[VtigerClient] getCampaign({$campaignId}) retrieve failed. wsId={$wsId} Response: " . json_encode($res));
            $this->lastCampaignError = $res;
            return null;
        }

        return $res['result'];
    }

    /**
     * ดึง idPrefix (tabId) ของ Campaigns module ผ่าน describe
     * Cache ไว้ใน property เพื่อไม่ต้อง call ซ้ำ
     */
    private function getCampaignTabId(string $session): ?string
    {
        if ($this->campaignTabId !== null) {
            return $this->campaignTabId;
        }

        $res = $this->httpPost('webservice.php', [
            'operation'   => 'describe',
            'sessionName' => $session,
            'elementType' => 'Campaigns',
        ]);

        if ($res && !empty($res['success']) && isset($res['result']['idPrefix'])) {
            $this->campaignTabId = (string)$res['result']['idPrefix'];
        } else {
            error_log("[VtigerClient] describe Campaigns failed: " . json_encode($res));
        }

        return $this->campaignTabId;
    }

    private function callCreate(string $session, array $element): array
    {
        return $this->httpPost('webservice.php', [
            'operation'   => 'create',
            'sessionName' => $session,
            'elementType' => 'Leads',
            'element'     => json_encode($element),
        ]) ?? ['success' => false, 'error' => ['message' => 'No response from CRM']];
    }

    private function getSession(): ?string
    {
        if (file_exists($this->sessionFile)) {
            $cache = json_decode(file_get_contents($this->sessionFile), true);
            if (is_array($cache) && !empty($cache['sessionName']) && $cache['expires'] > time()) {
                return $cache['sessionName'];
            }
        }
        return $this->login();
    }

    private function login(): ?string
    {
        $res = $this->httpGet('webservice.php', [
            'operation' => 'getchallenge',
            'username'  => $this->cfg['crm_user'],
        ]);
        if (!$res || empty($res['success'])) {
            error_log('[VtigerClient] getchallenge failed: ' . json_encode($res));
            return null;
        }

        $token      = $res['result']['token'];
        $expireTime = (int)($res['result']['expireTime'] ?? time() + 3600);
        $accessKey  = md5($token . $this->cfg['crm_access_key']);

        $res = $this->httpPost('webservice.php', [
            'operation' => 'login',
            'username'  => $this->cfg['crm_user'],
            'accessKey' => $accessKey,
        ]);
        if (!$res || empty($res['success'])) {
            error_log('[VtigerClient] login failed: ' . json_encode($res));
            return null;
        }

        $sessionName = $res['result']['sessionName'];
        $cacheExpiry = min($expireTime - 60, time() + 3540);

        file_put_contents($this->sessionFile, json_encode([
            'sessionName' => $sessionName,
            'expires'     => $cacheExpiry,
        ]));
        @chmod($this->sessionFile, 0600);

        return $sessionName;
    }

    private function clearSession(): void
    {
        if (file_exists($this->sessionFile)) {
            unlink($this->sessionFile);
        }
    }

    private function httpGet(string $path, array $params): ?array
    {
        $url = rtrim($this->cfg['crm_url'], '/') . '/' . $path . '?' . http_build_query($params);
        $ctx = stream_context_create(['http' => ['timeout' => 10]]);
        $res = @file_get_contents($url, false, $ctx);
        return $res ? json_decode($res, true) : null;
    }

    private function httpPost(string $path, array $params): ?array
    {
        return $this->httpPostRaw($path, $params)['json'];
    }

    private function httpPostRaw(string $path, array $params): array
    {
        $url = rtrim($this->cfg['crm_url'], '/') . '/' . $path;
        $ch  = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => http_build_query($params),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 10,
            CURLOPT_HTTPHEADER     => ['Content-Type: application/x-www-form-urlencoded'],
        ]);
        $body      = curl_exec($ch);
        $curlError = curl_errno($ch) ? curl_error($ch) : null;
        $httpCode  = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($curlError) {
            error_log('[VtigerClient] curl error: ' . $curlError);
        }
        curl_close($ch);
        return [
            'body'       => $body ?: '',
            'json'       => ($body ? json_decode($body, true) : null),
            'curl_error' => $curlError,
            'http_code'  => $httpCode,
        ];
    }
}
