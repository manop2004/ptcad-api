# Lead API — คู่มือการใช้งาน

## ภาพรวม

Lead API เป็น REST API สำหรับรับข้อมูลจากฟอร์มบนเว็บภายนอกและสร้าง Lead ใน Vtiger CRM
โดย URL ของ CRM จะถูกซ่อนอยู่ฝั่ง backend ไม่เปิดเผยสู่ผู้ใช้งาน

```
[เว็บภายนอก] → POST /api/v1/leads → [Lead API] → [Vtiger CRM]
```

---

## Base URL

```
https://api.your-domain.com
```

---

## การตั้งค่าเริ่มต้น

### 1. Copy config file

```bash
cp config.example.php config.php
```

แก้ไข `config.php`:

| Key | คำอธิบาย |
|---|---|
| `crm_url` | URL ภายในของ Vtiger CRM |
| `crm_user` | Username ของ API User ใน CRM |
| `crm_access_key` | Access Key จาก CRM → My Preferences → Access Key |
| `crm_owner_id` | `{tabid}x{userid}` เช่น `19x5` (ดูจาก URL ของ User ใน CRM) |
| `recaptcha_secret` | Secret Key จาก Google reCAPTCHA Admin Console |
| `recaptcha_min_score` | คะแนนต่ำสุด (0.0–1.0, แนะนำ 0.5) |
| `api_key` | Key สุ่มสำหรับยืนยัน client (สร้างด้วย `openssl rand -hex 32`) |
| `rate_limit_max` | จำนวน request สูงสุดต่อ window |
| `rate_limit_window` | ขนาด window เป็นวินาที |
| `allowed_origins` | รายการ domain ที่อนุญาต CORS |

### 2. สร้าง API User ใน CRM

1. ไปที่ Admin → Users → สร้าง User ใหม่
2. ตั้งชื่อ `api_leads`
3. กำหนด Role ที่มีสิทธิ์เฉพาะ Create Leads
4. ไปที่ My Preferences → คัดลอก Access Key

### 3. ตั้งค่า Google reCAPTCHA v3

1. ไปที่ https://www.google.com/recaptcha/admin
2. เลือก reCAPTCHA v3
3. ใส่ domain ของเว็บภายนอก
4. คัดลอก Site Key (สำหรับ frontend) และ Secret Key (สำหรับ config.php)

### 4. ตรวจสอบ Storage Permission

```bash
chmod 700 storage/
chmod 700 storage/rate_limit/
```

---

## Authentication

### API Key (X-API-Key Header)

ทุก request ต้องแนบ API Key ใน header (ถ้าตั้งค่าไว้ใน config)

```
X-API-Key: your-api-key-here
```

**หมายเหตุ**: สำหรับ request จาก JavaScript frontend (browser) API Key จะปรากฏใน source code
ซึ่งเป็นเรื่องปกติ — ความปลอดภัยหลักมาจาก reCAPTCHA + CORS + Rate Limiting

สำหรับ server-to-server (backend → API) ควรเก็บ API Key ใน environment variable

---

## Endpoints

### GET /api/v1/health

ตรวจสอบสถานะของ API

**Authentication**: ไม่ต้องการ

**Request**
```
GET /api/v1/health
```

**Response 200**
```json
{
    "status": "ok",
    "timestamp": "2026-06-08T10:00:00+07:00",
    "version": "1.0.0"
}
```

---

### POST /api/v1/leads

สร้าง Lead ใหม่ใน Vtiger CRM

**Authentication**: X-API-Key header (ถ้าตั้งค่าไว้)

**Content-Type**: `application/json` หรือ `application/x-www-form-urlencoded`

#### Request Body

| Field | Type | Required | คำอธิบาย |
|---|---|---|---|
| `recaptcha_token` | string | **Yes** | Token จาก `grecaptcha.execute()` |
| `lastname` | string | **Yes** | นามสกุล (max 100 ตัวอักษร) |
| `firstname` | string | No | ชื่อ (max 100 ตัวอักษร) |
| `email` | string | No | อีเมล (ต้องเป็น format ที่ถูกต้อง) |
| `phone` | string | No | เบอร์โทรศัพท์ (7–30 ตัวอักษร) |
| `mobile` | string | No | มือถือ |
| `company` | string | No | บริษัท/องค์กร |
| `designation` | string | No | ตำแหน่งงาน |
| `department` | string | No | แผนก |
| `website` | string | No | URL เว็บไซต์ (ต้องเป็น URL ที่ถูกต้อง) |
| `message` | string | No | ข้อความ/รายละเอียด (max 2000 ตัวอักษร) |
| `leadsource` | string | No | แหล่งที่มา (default: `Web Site`) |
| `campaign_id` | integer | No | ID ของ Campaign ใน CRM — Lead จะถูก link เข้า Campaign นั้น |
| `assigned_user_id` | string | No | กำหนดผู้รับผิดชอบ Lead format `{tabid}x{userid}` เช่น `19x5` — override ทุกค่าอื่น |
| `pool` | string | No | ชื่อ pool ของ Round Robin (ดูหัวข้อ [Round Robin Assignment](#round-robin-assignment)) default: `default` |

**ลำดับความสำคัญของ assigned_user_id:**
1. `assigned_user_id` ที่ส่งมาใน request (สูงสุด)
2. Round Robin จาก pool ที่ระบุ (ถ้าเปิดใช้ใน config)
3. ผู้รับผิดชอบของ Campaign (ถ้าระบุ `campaign_id`)
4. `crm_owner_id` ใน config.php (ค่า default)

---

### Standard Fields Reference

API รับ **ทุก field** ที่ Leads module มี ไม่จำกัดเฉพาะในตาราง ด้านล่างนี้คือ field มาตรฐานที่ใช้บ่อย:

**ข้อมูลพื้นฐาน**

| Field | คำอธิบาย | ตัวอย่าง |
|---|---|---|
| `salutation` | คำนำหน้า | `Mr.`, `Mrs.`, `Ms.`, `Dr.`, `Prof.` |
| `firstname` | ชื่อ | `John` |
| `lastname` ⭐ | นามสกุล (**required**) | `Smith` |
| `email` | อีเมลหลัก | `john@example.com` |
| `secondaryemail` | อีเมลสำรอง | |
| `phone` | โทรศัพท์ | `021234567` |
| `mobile` | มือถือ | `0812345678` |
| `fax` | แฟกซ์ | |
| `company` | บริษัท/องค์กร | `ACME Co.` |
| `designation` | ตำแหน่งงาน | `Sales Manager` |
| `department` | แผนก | `Sales` |
| `website` | เว็บไซต์ | `https://acme.com` |

**ที่อยู่**

| Field | คำอธิบาย |
|---|---|
| `lane` | ที่อยู่บรรทัด 1 |
| `city` | เมือง/อำเภอ |
| `state` | จังหวัด/รัฐ |
| `country` | ประเทศ |
| `zip` | รหัสไปรษณีย์ |

**ข้อมูลธุรกิจ**

| Field | คำอธิบาย | ตัวอย่าง |
|---|---|---|
| `leadsource` | แหล่งที่มา | ดูตาราง leadsource ด้านล่าง |
| `lead_source_description` | รายละเอียดแหล่งที่มา | |
| `industry` | อุตสาหกรรม | `Technology`, `Finance`, `Healthcare` |
| `annualrevenue` | รายได้ต่อปี | `5000000` |
| `no_of_employees` | จำนวนพนักงาน | `50` |
| `rating` | ระดับ Lead | `Hot`, `Warm`, `Cold` |
| `description` | หมายเหตุ/รายละเอียด | |

**Custom Fields** — ส่งได้ตรงๆ โดยใช้ field name จาก CRM:

| Field | คำอธิบาย |
|---|---|
| `cf_xxxxx` | Custom field ใดๆ ที่สร้างใน CRM — ใช้ field name ตามที่ปรากฏใน CRM |

> **วิธีดู field name ของ custom field**: ไปที่ Admin → Studio → Leads → Fields → ดูคอลัมน์ "Field Name"

---

**ค่า leadsource ที่ Vtiger รองรับ**:
`Cold Call`, `Existing Customer`, `Self Generated`, `Employee`, `Partner`,
`Public Relations`, `Direct Mail`, `Conference`, `Trade Show`, `Web Site`,
`Word of mouth`, `Other`

#### Response

**201 Created — สำเร็จ**
```json
{
    "success": true,
    "message": "Lead created successfully",
    "lead": {
        "id": "7x123",
        "lead_no": "LEA1001",
        "salutation": "",
        "firstname": "John",
        "lastname": "Smith",
        "email": "john@example.com",
        "phone": "0812345678",
        "mobile": "",
        "company": "ACME Co.",
        "designation": "Manager",
        "department": "Sales",
        "website": "https://acme.com",
        "description": "Interested in product A",
        "leadsource": "Web Site",
        "city": "Bangkok",
        "state": "Bangkok",
        "country": "Thailand",
        "zip": "10110",
        "lane": "123 Sukhumvit Rd",
        "industry": "Technology",
        "annualrevenue": "",
        "rating": "",
        "no_of_employees": "",
        "assigned_user_id": "19x5",
        "createdtime": "2026-06-08 10:00:00",
        "modifiedtime": "2026-06-08 10:00:00",
        "cf_1234": "custom value",
        "...": "ทุก field ที่ Lead record มี"
    }
}
```

> **หมายเหตุ**: ค่า `lead.id` คือ WebService ID format `{tabid}x{recordid}` เช่น `7x123`
> ถ้าต้องการ numeric ID อย่างเดียว ใช้ `lead.id.split('x')[1]`

**400 Bad Request**
```json
{
    "error": "Bad Request",
    "message": "..."
}
```

**401 Unauthorized — API Key ไม่ถูกต้อง**
```json
{
    "error": "Unauthorized",
    "message": "Invalid or missing X-API-Key header"
}
```

**404 Not Found — Route ไม่มีอยู่**
```json
{
    "error": "Not Found",
    "message": "Route POST /api/v1/wrong does not exist"
}
```

**422 Unprocessable Entity — Validation ไม่ผ่าน**
```json
{
    "error": "Validation Failed",
    "errors": {
        "lastname": "Last name is required",
        "email": "Invalid email format"
    }
}
```

**422 — CAPTCHA ไม่ผ่าน**
```json
{
    "error": "CAPTCHA Failed",
    "message": "CAPTCHA verification failed. Please try again."
}
```

**429 Too Many Requests — Rate limit เกิน**
```json
{
    "error": "Too Many Requests",
    "message": "Rate limit exceeded. Please try again later.",
    "retry_after": 347
}
```
Header: `Retry-After: 347`

**500 Internal Server Error**
```json
{
    "error": "Internal Server Error",
    "message": "Failed to create lead. Please try again."
}
```

---

## ตัวอย่างการเรียกใช้

### JavaScript (Frontend)

```html
<!-- โหลด reCAPTCHA v3 -->
<script src="https://www.google.com/recaptcha/api.js?render=YOUR_SITE_KEY"></script>

<form id="lead-form">
    <input name="firstname"   placeholder="First Name">
    <input name="lastname"    placeholder="Last Name *" required>
    <input name="email"       placeholder="Email" type="email">
    <input name="phone"       placeholder="Phone">
    <input name="company"     placeholder="Company">
    <textarea name="message"  placeholder="Message"></textarea>
    <button type="submit" id="submit-btn">Submit</button>
    <p id="form-msg" style="display:none"></p>
</form>

<script>
const API_URL = 'https://api.your-domain.com';
const API_KEY = 'your-api-key';
const RECAPTCHA_SITE_KEY = 'your-site-key';

document.getElementById('lead-form').addEventListener('submit', async (e) => {
    e.preventDefault();

    const btn = document.getElementById('submit-btn');
    const msg = document.getElementById('form-msg');
    btn.disabled = true;
    btn.textContent = 'Sending...';
    msg.style.display = 'none';

    try {
        // ขอ reCAPTCHA token
        const token = await grecaptcha.execute(RECAPTCHA_SITE_KEY, {
            action: 'submit_lead'
        });

        const formData = Object.fromEntries(new FormData(e.target));
        formData.recaptcha_token = token;

        // ตัวอย่าง: ฝัง campaign_id ไว้ใน hidden field หรือกำหนดตรงนี้
        // formData.campaign_id = '12';
        // formData.assigned_user_id = '19x5';  // optional override

        const res = await fetch(`${API_URL}/api/v1/leads`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-API-Key': API_KEY,
            },
            body: JSON.stringify(formData),
        });

        const data = await res.json();

        if (res.ok && data.success) {
            const lead = data.lead;

            // ใช้ข้อมูล lead ที่ได้กลับมาสำหรับแสดงผลหรือแจ้งเตือน
            msg.style.color = 'green';
            msg.innerHTML = `
                Thank you, <strong>${lead.firstname} ${lead.lastname}</strong>!<br>
                Your enquiry has been received (Ref: ${lead.lead_no}).<br>
                Our team will contact you at ${lead.email || lead.phone} shortly.
            `;

            // ตัวอย่าง: ส่ง event ไปยัง Google Analytics
            // gtag('event', 'generate_lead', { lead_no: lead.lead_no });

            // ตัวอย่าง: redirect พร้อม lead_no
            // window.location.href = `/thank-you?ref=${lead.lead_no}`;

            e.target.reset();
        } else if (res.status === 429) {
            const mins = Math.ceil(data.retry_after / 60);
            msg.style.color = 'red';
            msg.textContent = `Too many attempts. Please wait ${mins} minute(s).`;
        } else if (res.status === 422 && data.errors) {
            const errList = Object.values(data.errors).join(', ');
            msg.style.color = 'red';
            msg.textContent = errList;
        } else {
            msg.style.color = 'red';
            msg.textContent = data.message || 'Submission failed. Please try again.';
        }
    } catch (err) {
        msg.style.color = 'red';
        msg.textContent = 'Network error. Please check your connection.';
    } finally {
        btn.disabled = false;
        btn.textContent = 'Submit';
        msg.style.display = 'block';
    }
});
</script>
```

---

### cURL (Testing)

```bash
# Health check
curl https://api.your-domain.com/api/v1/health

# Health check
curl https://api.your-domain.com/api/v1/health

# สร้าง Lead — field มาตรฐาน
curl -X POST https://api.your-domain.com/api/v1/leads \
  -H "Content-Type: application/json" \
  -H "X-API-Key: your-api-key" \
  -d '{
    "lastname": "Smith",
    "firstname": "John",
    "email": "john@example.com",
    "phone": "0812345678",
    "mobile": "0891234567",
    "company": "ACME Co.",
    "designation": "Sales Manager",
    "city": "Bangkok",
    "state": "Bangkok",
    "country": "Thailand",
    "description": "Interested in product A",
    "leadsource": "Web Site",
    "recaptcha_token": "TOKEN_FROM_BROWSER"
  }'

# สร้าง Lead — พร้อม custom fields + link campaign
curl -X POST https://api.your-domain.com/api/v1/leads \
  -H "Content-Type: application/json" \
  -H "X-API-Key: your-api-key" \
  -d '{
    "lastname": "Smith",
    "firstname": "John",
    "email": "john@example.com",
    "campaign_id": "12",
    "cf_1234": "value for custom field",
    "cf_5678": "another custom field",
    "recaptcha_token": "TOKEN_FROM_BROWSER"
  }'
```

---

### PHP (Server-to-Server)

```php
<?php
// เรียกจาก backend อื่น (ไม่ต้องใช้ reCAPTCHA ถ้าเป็น server-to-server)
// หรือใช้ reCAPTCHA Enterprise สำหรับ non-browser calls

$data = [
    'lastname'        => 'Smith',
    'firstname'       => 'John',
    'email'           => 'john@example.com',
    'phone'           => '0812345678',
    'company'         => 'ACME Co.',
    'message'         => 'Interested in your product',
    'recaptcha_token' => 'bypass-token',  // ต้องปรับ logic ถ้าเป็น server-to-server
];

$ch = curl_init('https://api.your-domain.com/api/v1/leads');
curl_setopt_array($ch, [
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => json_encode($data),
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER     => [
        'Content-Type: application/json',
        'X-API-Key: your-api-key',
    ],
]);
$res  = curl_exec($ch);
$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

$result = json_decode($res, true);
if ($code === 201 && $result['success']) {
    echo "Lead created!";
} else {
    echo "Error: " . ($result['message'] ?? 'Unknown');
}
```

---

### Python (requests)

```python
import requests

url     = "https://api.your-domain.com/api/v1/leads"
headers = {
    "Content-Type": "application/json",
    "X-API-Key":    "your-api-key",
}
payload = {
    "lastname":        "Smith",
    "firstname":       "John",
    "email":           "john@example.com",
    "phone":           "0812345678",
    "company":         "ACME Co.",
    "message":         "Interested in your product",
    "recaptcha_token": "TOKEN",
}

res  = requests.post(url, json=payload, headers=headers, timeout=10)
data = res.json()

if res.status_code == 201 and data.get("success"):
    print("Lead created!")
elif res.status_code == 422:
    print("Validation errors:", data.get("errors"))
elif res.status_code == 429:
    print(f"Rate limited. Retry after {data['retry_after']}s")
else:
    print("Error:", data.get("message"))
```

---

## Rate Limiting

| Header | คำอธิบาย |
|---|---|
| `Retry-After` | จำนวนวินาทีที่ต้องรอ (เมื่อ 429) |

**Default**: 5 requests ต่อ 10 นาที ต่อ IP

ปรับใน `config.php`:
```php
'rate_limit_max'    => 5,    // จำนวนครั้ง
'rate_limit_window' => 600,  // วินาที
```

---

## Round Robin Assignment

กระจาย Lead ให้ทีม sales หมุนเวียนตามลำดับ (คนที่ 1 → คนที่ 2 → คนที่ 3 → คนที่ 1 → ...)

รองรับ 2 แบบ: กำหนด user โดยตรง (`type=users`) หรือกำหนดด้วย Role ของ CRM (`type=role`)

### แบบที่ 1: กำหนด User โดยตรง (`type=users`)

```php
'round_robin' => [
    'enabled' => true,
    'pools'   => [
        'default' => [
            'type'     => 'users',
            'user_ids' => ['19x5', '19x11', '19x15'],
        ],
    ],
],
```

**วิธีหา user_id**: CRM → Settings → Users → คลิกที่ User → ดู URL `?record=5` → ใส่ `19x5`

### แบบที่ 2: กำหนดด้วย Role (`type=role`)

ระบุ Role ID แทน — user ที่เพิ่มเข้า Role ในภายหลังจะถูกดึงเข้า pool อัตโนมัติ ไม่ต้องแก้ config

```php
'round_robin' => [
    'enabled'        => true,
    'user_cache_ttl' => 300,  // refresh list จาก CRM ทุก 5 นาที
    'pools'          => [
        'default' => [
            'type'     => 'role',
            'role_ids' => ['H5'],        // Sales Person
        ],
        'all_sales' => [
            'type'     => 'role',
            'role_ids' => ['H4', 'H5'], // Manager + Sales Person
        ],
    ],
],
```

**วิธีหา Role ID**: CRM → Settings → Roles → คลิกที่ Role → ดู URL `?record=H5` → ใส่ `H5`

ระบบ query users ผ่าน Vtiger WS API (session เดิม ไม่ต้อง config เพิ่ม) และ cache ผลลัพธ์ไว้ใน `storage/rr_cache_{pool}.json` ตามเวลา `user_cache_ttl`

### หลาย Pool (สำหรับหลายฟอร์ม)

ฟอร์มแต่ละตัวส่ง field `pool` ใน request เพื่อเลือกทีม:

```json
{
    "lastname": "Smith",
    "pool": "all_sales",
    "recaptcha_token": "..."
}
```

ถ้าไม่ส่ง `pool` ระบบใช้ pool ชื่อ `default` อัตโนมัติ สามารถผสม `type=users` และ `type=role` ใน pools เดียวกันได้

### Storage Files

| ไฟล์ | เนื้อหา |
|---|---|
| `storage/rr_state_{pool}.json` | `{"index": 2}` — index วนปัจจุบัน |
| `storage/rr_cache_{pool}.json` | users list + expires (เฉพาะ `type=role`) |

สร้างอัตโนมัติเมื่อมี request แรก ไม่ต้องสร้างเอง

---

## Error Code Reference

| HTTP Status | Error | สาเหตุ |
|---|---|---|
| 401 | Unauthorized | X-API-Key ไม่ถูกต้องหรือไม่ส่งมา |
| 404 | Not Found | Route ไม่มีอยู่ |
| 405 | Method Not Allowed | ใช้ HTTP method ไม่ถูก |
| 422 | CAPTCHA Failed | CAPTCHA token ไม่ถูกต้องหรือ score ต่ำ |
| 422 | Validation Failed | ข้อมูลที่ส่งมาไม่ถูกต้อง |
| 429 | Too Many Requests | เกิน rate limit |
| 500 | Internal Server Error | ระบบภายในผิดพลาด |

---

## โครงสร้างไฟล์

```
lead-api/
├── index.php              ← Entry point + Router + Handlers
├── config.php             ← Config จริง (gitignored)
├── config.example.php     ← Template สำหรับ copy
├── src/
│   ├── VtigerClient.php   ← CRM client + session cache
│   ├── RateLimit.php      ← IP rate limiter
│   ├── Captcha.php        ← reCAPTCHA v3 verifier
│   └── RoundRobin.php     ← Round robin user assignment
├── storage/               ← Auto-created, gitignored
│   ├── vtiger_session     ← Cache session name
│   ├── rate_limit/        ← IP hit counters
│   ├── rr_state_*.json    ← Round robin index per pool
│   └── rr_cache_*.json    ← Users cache per role-based pool
├── .htaccess              ← URL rewrite + security
├── .gitignore
└── DOCS.md                ← คู่มือนี้
```

---

## Deployment Checklist

- [ ] Copy `config.example.php` → `config.php` และใส่ค่าจริง
- [ ] ตั้งค่า `crm_owner_id` ให้ถูกต้อง (`tabid x userid`)
- [ ] สร้าง `api_leads` user ใน CRM พร้อมจำกัดสิทธิ์
- [ ] ลงทะเบียน domain ใน Google reCAPTCHA Admin Console
- [ ] ตั้งค่า `allowed_origins` ให้ตรงกับ domain เว็บจริง
- [ ] ตรวจสอบ `storage/` มี write permission
- [ ] ทดสอบ `GET /api/v1/health` คืน `{"status":"ok"}`
- [ ] ทดสอบ `POST /api/v1/leads` กับ token จริงจาก browser
- [ ] ตรวจสอบ `config.php` ไม่สามารถเข้าถึงผ่าน browser (ควรได้ 403)

---

## Security Notes

1. **config.php** ต้องไม่ถูก commit ลง git และไม่สามารถเข้าถึงผ่าน URL ได้
2. **storage/** ต้องอยู่นอก document root หรือปิดด้วย .htaccess
3. **API Key** ใน JavaScript frontend จะ visible ใน source — รับได้ เพราะ CAPTCHA + CORS ป้องกันการใช้งาน unauthorized อยู่แล้ว
4. ควร deploy ผ่าน HTTPS เสมอ
5. Log errors ใน PHP error log แต่ไม่แสดงรายละเอียด error ภายในให้ client เห็น
