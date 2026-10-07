<?php
declare(strict_types=1);

/**
 * Lead API — Entry Point & Router
 *
 * Document root should point here (or to this directory).
 * All requests are routed through this file via .htaccess.
 */

// ── Autoload ─────────────────────────────────────────────────────────────────
spl_autoload_register(function (string $class) {
    $file = __DIR__ . '/src/' . $class . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

// ── Config ───────────────────────────────────────────────────────────────────
$configFile = __DIR__ . '/config.php';
if (!file_exists($configFile)) {
    http_response_code(500);
    header('Content-Type: application/json');
    exit(json_encode(['error' => 'Server configuration missing']));
}
$cfg = require $configFile;

// ── CORS ─────────────────────────────────────────────────────────────────────
$origin  = $_SERVER['HTTP_ORIGIN'] ?? '';
$allowed = (array)($cfg['allowed_origins'] ?? []);

if (in_array($origin, $allowed, true)) {
    header('Access-Control-Allow-Origin: ' . $origin);
    header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, X-API-Key');
    header('Access-Control-Max-Age: 86400');
    header('Vary: Origin');
}

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');

// ── Router ───────────────────────────────────────────────────────────────────
$method  = $_SERVER['REQUEST_METHOD'];
$fullUri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';

// [แก้ใหม่] หา "/api/v1/" ในพาธแทนการพึ่งพา SCRIPT_NAME
// (บาง server config เช่น Nginx+PHP-FPM คำนวณ SCRIPT_NAME ผิดตอนอยู่ subdirectory)
$apiPos = strpos($fullUri, '/api/v1/');
if ($apiPos !== false) {
    $uri = substr($fullUri, $apiPos);
} else {
    $uri = '/' . trim($fullUri, '/');
}
$uri = rtrim($uri, '/');
if ($uri === '') { $uri = '/'; }

// Routes
$routes = [
    'GET:/api/v1/health' => 'handleHealth',
    'POST:/api/v1/leads' => 'handleCreateLead',
];

$key = $method . ':' . $uri;

if (!isset($routes[$key])) {
    http_response_code(404);
    exit(json_encode([
        'error' => 'Not Found',
        'message' => "Route {$method} {$uri} does not exist",
    ]));
}

call_user_func($routes[$key], $cfg);
exit;


// ────────────────────────────────────────────────────────────────────────────
// Handlers
// ────────────────────────────────────────────────────────────────────────────

function handleHealth(array $cfg): void
{
    echo json_encode([
        'status'    => 'ok',
        'timestamp' => date('c'),
        'version'   => '1.0.0',
    ]);
}


function handleCreateLead(array $cfg): void
{
    // ── API Key ───────────────────────────────────────────────────────────────
    $apiKey = trim($cfg['api_key'] ?? '');
    if ($apiKey !== '') {
        $provided = trim($_SERVER['HTTP_X_API_KEY'] ?? '');
        if (!hash_equals($apiKey, $provided)) {
            http_response_code(401);
            exit(json_encode([
                'error'   => 'Unauthorized',
                'message' => 'Invalid or missing X-API-Key header',
            ]));
        }
    }

    // ── Rate Limiting ─────────────────────────────────────────────────────────
    $ip        = getClientIp();
    $rateLimit = new RateLimit(
        (int)($cfg['rate_limit_max']    ?? 5),
        (int)($cfg['rate_limit_window'] ?? 600),
        $cfg['storage_dir']
    );

    if (!$rateLimit->check($ip)) {
        $retryAfter = $rateLimit->retryAfter($ip);
        http_response_code(429);
        header('Retry-After: ' . $retryAfter);
        exit(json_encode([
            'error'       => 'Too Many Requests',
            'message'     => 'Rate limit exceeded. Please try again later.',
            'retry_after' => $retryAfter,
        ]));
    }

    // ── Parse Body ────────────────────────────────────────────────────────────
    $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
    if (str_contains($contentType, 'application/json')) {
        $input = json_decode(file_get_contents('php://input'), true) ?? [];
    } else {
        $input = $_POST;
    }

    // ── CAPTCHA (หรือข้ามถ้ามี Backend Secret ที่ถูกต้อง) ────────────────────
    $backendSecret   = trim($cfg['backend_secret'] ?? '');
    $providedSecret  = trim($_SERVER['HTTP_X_BACKEND_SECRET'] ?? '');
    $isTrustedBackend = $backendSecret !== '' && hash_equals($backendSecret, $providedSecret);

    $captchaToken = trim($input['recaptcha_token'] ?? '');
    $captcha      = new Captcha(
        (string)($cfg['recaptcha_secret']    ?? ''),
        (float) ($cfg['recaptcha_min_score'] ?? 0.5)
    );

    $skipCaptcha = !empty($cfg['skip_captcha']) || $isTrustedBackend;
    if (!$skipCaptcha) {
        $captchaResult = $captcha->verify($captchaToken, $ip);
        if (!$captchaResult['valid']) {
            http_response_code(422);
            exit(json_encode([
                'error'   => 'CAPTCHA Failed',
                'message' => 'CAPTCHA verification failed. Please try again.',
            ]));
        }
    }

    // ── Validate ──────────────────────────────────────────────────────────────
    $errors = validateLeadInput($input);
    if (!empty($errors)) {
        http_response_code(422);
        exit(json_encode([
            'error'   => 'Validation Failed',
            'errors'  => $errors,
        ]));
    }

    // ── Build Lead Data — ส่งผ่านทุก field ยกเว้น recaptcha_token ────────────
    // VtigerClient จะกรอง reserved fields (campaign_id, recaptcha_token) เอง
    $leadData = [];
    foreach ($input as $key => $value) {
        if ($key === 'recaptcha_token') continue;
        $leadData[$key] = is_string($value) ? trim($value) : $value;
    }

    // ── Create Lead ───────────────────────────────────────────────────────────
    $client = new VtigerClient($cfg);
    $result = $client->createLead($leadData);

    if ($result['success']) {
        http_response_code(201);
        $body = [
            'success' => true,
            'message' => 'Lead created successfully',
            'lead'    => $result['lead'] ?? null,
        ];
        if (!empty($cfg['skip_captcha']) && isset($result['debug_campaign_link'])) {
            $body['debug_campaign_link'] = $result['debug_campaign_link'];
        }
        echo json_encode($body);
    } else {
        error_log('[lead-api] createLead failed: ' . json_encode($result));

        // Campaign not found → 422 ไม่ใช่ 500
        $isCampaignError = str_contains($result['error'] ?? '', 'Campaign ID');
        http_response_code($isCampaignError ? 422 : 500);
        $errBody = [
            'error'   => $isCampaignError ? 'Validation Failed' : 'Internal Server Error',
            'message' => $result['error'] ?? 'Failed to create lead. Please try again.',
        ];
        // แสดง raw CRM response ตอน dev เพื่อ debug
        if (!empty($cfg['skip_captcha']) && isset($result['crm_response'])) {
            $errBody['debug_crm_response'] = $result['crm_response'];
        }
        echo json_encode($errBody);
    }
}


// ────────────────────────────────────────────────────────────────────────────
// Helpers
// ────────────────────────────────────────────────────────────────────────────

function validateLeadInput(array $input): array
{
    $errors = [];

    $lastname = trim($input['lastname'] ?? '');
    if ($lastname === '') {
        $errors['lastname'] = 'Last name is required';
    } elseif (mb_strlen($lastname) > 100) {
        $errors['lastname'] = 'Last name must not exceed 100 characters';
    }

    $firstname = trim($input['firstname'] ?? '');
    if ($firstname !== '' && mb_strlen($firstname) > 100) {
        $errors['firstname'] = 'First name must not exceed 100 characters';
    }

    $email = trim($input['email'] ?? '');
    if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email format';
    }

    $phone = trim($input['phone'] ?? '');
    if ($phone !== '' && !preg_match('/^[0-9+\-\s().]{7,30}$/', $phone)) {
        $errors['phone'] = 'Invalid phone format';
    }

    $website = trim($input['website'] ?? '');
    if ($website !== '' && !filter_var($website, FILTER_VALIDATE_URL)) {
        $errors['website'] = 'Invalid website URL';
    }

    $message = trim($input['message'] ?? '');
    if ($message !== '' && mb_strlen($message) > 2000) {
        $errors['message'] = 'Message must not exceed 2000 characters';
    }

    $campaignId = trim((string)($input['campaign_id'] ?? ''));
    if ($campaignId !== '' && (!ctype_digit($campaignId) || (int)$campaignId <= 0)) {
        $errors['campaign_id'] = 'campaign_id must be a positive integer';
    }

    $assignedUserId = trim((string)($input['assigned_user_id'] ?? ''));
    if ($assignedUserId !== '' && !preg_match('/^\d+x\d+$/', $assignedUserId)) {
        $errors['assigned_user_id'] = 'assigned_user_id must be in format {tabid}x{userid} e.g. 19x5';
    }

    return $errors;
}

function getClientIp(): string
{
    // รองรับ reverse proxy (Nginx, Cloudflare)
    foreach (['HTTP_CF_CONNECTING_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_REAL_IP'] as $header) {
        if (!empty($_SERVER[$header])) {
            $ip = trim(explode(',', $_SERVER[$header])[0]);
            if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
                return $ip;
            }
        }
    }
    return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
}
