<?php
/**
 * Lead API — Configuration Template
 * Copy this file to config.php and fill in your values.
 * config.php must NOT be committed to git.
 */
return [

    // ── Vtiger CRM ──────────────────────────────────────────────────────────
    // Internal URL ของ CRM (ไม่เปิดเผยสู่ภายนอก)
    'crm_url'        => 'http://192.168.1.10/',
    'crm_user'       => 'api_leads',
    'crm_access_key' => 'REPLACE_WITH_ACCESS_KEY',  // My Preferences → Access Key
    'crm_owner_id'   => '19x1',                     // assigned_user_id: tabid x userid

    // ── Google reCAPTCHA v3 ─────────────────────────────────────────────────
    'recaptcha_secret'    => 'REPLACE_WITH_SECRET_KEY',
    'recaptcha_min_score' => 0.5,   // 0.0 = bot, 1.0 = human

    // ── API Key (X-API-Key header) ──────────────────────────────────────────
    // ใส่ค่าใดก็ได้ที่เดาไม่ออก เช่น: bin2hex(random_bytes(32))
    // เว้นว่างเพื่อปิดการตรวจสอบ (ไม่แนะนำบน production)
    'api_key' => 'REPLACE_WITH_RANDOM_STRING',

    // ── Rate Limiting ───────────────────────────────────────────────────────
    'rate_limit_max'    => 5,    // จำนวนครั้งสูงสุด
    'rate_limit_window' => 600,  // ต่อกี่วินาที (600 = 10 นาที)

    // ── CORS ────────────────────────────────────────────────────────────────
    // ใส่ domain เว็บภายนอกที่อนุญาต (ไม่มี trailing slash)
    // ใส่หลาย domain ได้: ['https://site-a.com', 'https://site-b.com']
    'allowed_origins' => ['https://your-website.com'],

    // ── Storage ─────────────────────────────────────────────────────────────
    'storage_dir' => __DIR__ . '/storage',

    // ── Campaigns Module ────────────────────────────────────────────────────
    // vtiger_ws_entity.id ของ Campaigns (ไม่ใช่ tabid ของ vtiger_tab)
    // ดูค่าจริงด้วย SQL: SELECT id FROM vtiger_ws_entity WHERE name='Campaigns'
    'campaigns_tabid' => '8',

    // ── Round Robin Assignment ──────────────────────────────────────────────
    // เปิดใช้เพื่อแจก Lead ให้ user หมุนเวียนตามลำดับ (0→1→2→0→...)
    //
    // pool คือกลุ่ม user สำหรับแต่ละฟอร์ม — ฟอร์มส่ง field "pool" มาใน request
    // ถ้าไม่ส่ง pool ระบบใช้ 'default' อัตโนมัติ
    //
    // type=users : ระบุ user_ids ตรงๆ (format '19x{userid}')
    //              ดู userid: CRM → Settings → Users → คลิก User → ดู URL ?record=N → '19xN'
    //
    // type=role  : ดึง users จาก Vtiger role ผ่าน WS อัตโนมัติ (ไม่ต้อง config DB)
    //              user_cache_ttl = ระยะเวลา cache (วินาที) — user ใหม่ที่เพิ่มเข้า role
    //              จะถูกดึงเข้า pool หลัง cache หมดอายุ
    //              ดู role ID: CRM → Settings → Roles → คลิก Role → ดู URL ?record=H5
    //
    // ลำดับความสำคัญ: assigned_user_id (request) > round robin > campaign owner > crm_owner_id
    'round_robin' => [
        'enabled'        => false,
        'user_cache_ttl' => 300,  // วินาที (ใช้กับ type=role)
        'pools'          => [
            'default' => [
                'type'     => 'users',
                'user_ids' => [], // เช่น ['19x5', '19x11', '19x15']
            ],
            // ตัวอย่าง type=role: ดึง users จาก Vtiger role อัตโนมัติ
            // 'sales_team' => [
            //     'type'     => 'role',
            //     'role_ids' => ['H5'],           // Sales Person
            // ],
            // 'all_sales' => [
            //     'type'     => 'role',
            //     'role_ids' => ['H4', 'H5'],     // Manager + Sales Person
            // ],
        ],
    ],

    // ── Development Only ────────────────────────────────────────────────────
    // ตั้งเป็น true เพื่อข้าม CAPTCHA (ใช้ทดสอบ Postman เท่านั้น)
    // ห้ามเปิดบน Production เด็ดขาด
    'skip_captcha' => false,

];
