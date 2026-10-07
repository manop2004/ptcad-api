<?php
declare(strict_types=1);

class RoundRobin
{
    private array         $pools;
    private string        $storageDir;
    private int           $cacheTtl;
    private ?VtigerClient $client;

    public function __construct(array $rrCfg, string $storageDir, ?VtigerClient $client = null)
    {
        $this->pools      = $rrCfg['pools'] ?? [];
        $this->storageDir = rtrim($storageDir, '/\\');
        $this->cacheTtl   = (int)($rrCfg['user_cache_ttl'] ?? 300);
        $this->client     = $client;
    }

    /**
     * คืน assigned_user_id (Vtiger WS format เช่น '19x5')
     * หรือ null ถ้า pool ไม่พบ / ว่างเปล่า
     */
    public function next(string $poolName = 'default'): ?string
    {
        $pool  = $this->pools[$poolName] ?? $this->pools['default'] ?? null;
        $users = $this->resolveUsers($pool, $poolName);

        if (empty($users)) {
            return null;
        }

        return $this->advanceIndex($poolName, $users);
    }

    private function resolveUsers(?array $pool, string $poolName): array
    {
        if (!$pool) {
            return [];
        }

        // type=users: ใช้ user_ids ตรงๆ ไม่ต้อง query WS
        if (($pool['type'] ?? 'users') === 'users') {
            return array_values(array_filter($pool['user_ids'] ?? []));
        }

        // type=role: ตรวจ cache ก่อน
        $cacheFile = $this->cacheFilePath($poolName);
        if (file_exists($cacheFile)) {
            $cached = json_decode(file_get_contents($cacheFile), true);
            if (!empty($cached['users']) && ($cached['expires'] ?? 0) > time()) {
                return $cached['users'];
            }
        }

        // Cache หมดอายุ → query ผ่าน Vtiger WS
        if (!$this->client) {
            return [];
        }

        $roleIds = $pool['role_ids'] ?? [];
        $users   = [];
        foreach ($roleIds as $roleId) {
            foreach ($this->client->queryUserIdsByRole($roleId) as $uid) {
                if (!in_array($uid, $users, true)) {
                    $users[] = $uid;
                }
            }
        }
        sort($users); // เรียงให้ consistent ทุกครั้ง

        if (!empty($users)) {
            file_put_contents($cacheFile, json_encode([
                'users'   => $users,
                'expires' => time() + $this->cacheTtl,
            ]));
        }

        return $users;
    }

    private function advanceIndex(string $poolName, array $users): string
    {
        $stateFile = $this->stateFilePath($poolName);

        $fp = fopen($stateFile, 'c+');
        if (!$fp) {
            return $users[0];
        }

        flock($fp, LOCK_EX);

        $contents = stream_get_contents($fp);
        $state    = ($contents !== '') ? json_decode($contents, true) : [];
        $index    = (int)($state['index'] ?? 0) % count($users);
        $userId   = $users[$index];

        ftruncate($fp, 0);
        rewind($fp);
        fwrite($fp, json_encode(['index' => ($index + 1) % count($users)]));

        flock($fp, LOCK_UN);
        fclose($fp);

        return $userId;
    }

    private function safeName(string $poolName): string
    {
        return preg_replace('/[^a-z0-9_]/i', '_', $poolName);
    }

    private function stateFilePath(string $poolName): string
    {
        return $this->storageDir . '/rr_state_' . $this->safeName($poolName) . '.json';
    }

    private function cacheFilePath(string $poolName): string
    {
        return $this->storageDir . '/rr_cache_' . $this->safeName($poolName) . '.json';
    }
}
