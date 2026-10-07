<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use App\Models\TbOrder;
use App\Models\TbSoftware;
use App\Models\TbSoftwareNotify;
use App\Models\User;

/**
 * เชื่อมต่อ PTCAD License API (สร้าง License อัตโนมัติตอนลูกค้าจ่ายเงินสำเร็จ)
 * แทนที่ขั้นตอนเดิมที่แอดมินต้องมากรอกฟอร์ม "เพิ่มซอฟต์แวร์" ด้วยมือทุกครั้ง
 *
 * เรียกใช้จาก 2 จุด:
 *   1) OmiseController::omise_webhook()  — ตอนบัตร/พร้อมเพย์/ผ่อนชำระ จ่ายสำเร็จอัตโนมัติ
 *   2) OrderController::updateStatus()   — ตอนแอดมินกดยืนยันสลิปโอนธนาคารเอง (status=7)
 */
class PtcadLicenseService
{
    /**
     * แปลง product_sku (ชื่อสินค้าในออเดอร์ เช่น "PTCAD Lite") -> edition ของ API
     *
     * ⚠️ TODO [รอ IT ยืนยัน]: "Civil Pro Max" ยังไม่รู้ code จริง ตั้งเป็น null ไว้ก่อน
     * ถ้า product_sku ไหน map ไม่เจอ (null) ระบบจะ "ข้าม" รายการนั้นไป ไม่ยิง API ให้
     * (ไม่ทำให้ทั้งออเดอร์พัง ถ้าออเดอร์มีสินค้าอื่นที่ map ได้ปนอยู่)
     */private const MAX_LICENSE_PER_ORDER = 5;
    private $editionMap = [
        'PTCAD Lite'      => 'LT',
        'PTCAD Standard'  => 'ST',
        'PTCAD Pro'       => 'PS',
        'PTCAD- Lite'     => 'LT',
        'PTCAD- Standard' => 'ST',
        'PTCAD- Pro'      => 'PS',
        'Civil Pro Max'   => null, // TODO: รอ IT ตอบเรื่อง product code ของ Civil Pro Max

        // [เพิ่มใหม่] Bundle SKU
    'BUNDLE-PLUS-CIVIL1Y' => 'PS',
    'BUNDLE-STD-CIVIL1Y'  => 'ST',
    'BUNDLE-LITE-CIVIL1Y' => 'LT',
    ];

    /**
     * แปลง vendor_sku ("Annual Subscription" / "Perpetual License")
     * -> product code + periodcode ของ API
     */
    private function mapProductAndPeriod($vendorSku, string $edition = '')
    {
        if (stripos((string) $vendorSku, 'perpetual') !== false) {
            return ['product' => 'PTC26', 'periodcode' => 'pt'];
        }
 
        // [เพิ่มใหม่] Lite (edition = LT) ใช้ product code แยกต่างหาก ไม่ปนกับ Standard
        if ($edition === 'LT') {
            return ['product' => 'PTCADL', 'periodcode' => '1y'];
        }
 
        // ค่า default ถ้าไม่เจอคำว่า perpetual และไม่ใช่ Lite = Standard/Plus รายปี
        return ['product' => 'PTCAD', 'periodcode' => '1y'];
    }

    /**
     * จุดเริ่มต้นหลัก — เรียกตอนยืนยันว่า order นี้จ่ายเงินสำเร็จแล้วจริง (status=7)
     * สร้าง License ผ่าน API แล้วบันทึกผลลัพธ์ลง tb_software / tb_software_notify ให้ครบ
     *
     * @return array ['success'=>bool, 'created'=>array, 'skipped'=>array, 'error'=>string]
     */
    public function createLicenseForOrder(TbOrder $order)
    {
        // ป้องกันยิงซ้ำ: ถ้า order นี้มี record ใน tb_software_notify อยู่แล้ว (สร้างไปแล้ว/เป็นการต่ออายุ) ไม่ต้องยิงซ้ำ
        $already = TbSoftwareNotify::where('orderId', $order->id)->exists();
        if ($already) {
            Log::info('PtcadLicenseService: skip, order already has software_notify', ['orderId' => $order->id]);
            return ['success' => false, 'error' => 'Order นี้มี License อยู่แล้ว (ข้ามการยิง API ซ้ำ)'];
        }

        $user = User::where('user_code', $order->userCode)->first();
        if (empty($user)) {
            Log::error('PtcadLicenseService: user not found', ['orderId' => $order->id, 'userCode' => $order->userCode]);
            return ['success' => false, 'error' => 'ไม่พบผู้ใช้งานของ order นี้'];
        }

        $totalSeatsRequested = $order->tb_order_details->sum(function ($d) {
            return (int) ($d->product_unit ?: 1);
        });

        if ($totalSeatsRequested > self::MAX_LICENSE_PER_ORDER) {
            Log::warning('PtcadLicenseService: order exceeds max license limit, capping', [
                'orderId'   => $order->id,
                'requested' => $totalSeatsRequested,
                'max'       => self::MAX_LICENSE_PER_ORDER,
            ]);
        }

        $seatsRemaining = self::MAX_LICENSE_PER_ORDER;
        $skipped = [];
        $created = [];

        foreach ($order->tb_order_details as $detail) {

            // [เพิ่มใหม่] ถ้าโควตา 5 License หมดแล้ว ข้ามรายการที่เหลือทั้งหมด
            if ($seatsRemaining <= 0) {
                Log::warning('PtcadLicenseService: license quota exhausted, skipping remaining items', [
                    'orderId' => $order->id, 'product_sku' => $detail->product_sku,
                ]);
                $skipped[] = $detail->product_sku . ' (เกินโควตา 5 License/ออเดอร์)';
                continue;
            }

            $edition = $this->editionMap[$detail->product_sku] ?? null;

            if (empty($edition)) {
                // [ข้ามรายการนี้] ยังไม่รู้จัก product_sku นี้ หรือยังไม่มี code (เช่น Civil Pro Max ตอนนี้)
                Log::warning('PtcadLicenseService: skip unknown product_sku (no edition mapping)', [
                    'orderId'     => $order->id,
                    'product_sku' => $detail->product_sku,
                ]);
                $skipped[] = $detail->product_sku;
                continue;
            }

            $requestedSeats = (int) ($detail->product_unit ?: 1);
            $seatsToCreate  = min($requestedSeats, $seatsRemaining);

            $result = $this->createLicenseForDetail($order, $user, $detail, $edition, $seatsToCreate);

            if ($result['success']) {
                $created = array_merge($created, $result['created']);
                $seatsRemaining -= $seatsToCreate;

                if ($seatsToCreate < $requestedSeats) {
                    $skipped[] = $detail->product_sku . " (สร้างแค่ {$seatsToCreate}/{$requestedSeats} ตัว — เกินโควตา 5 License/ออเดอร์)";
                }
            } else {
                // รายการนี้ยิงไม่สำเร็จ (rate limit / API error) แต่ไม่ทำให้รายการอื่นในออเดอร์เดียวกันพังไปด้วย
                $skipped[] = $detail->product_sku . ' (error: ' . $result['error'] . ')';
            }
        }

        if (empty($created)) {
            return ['success' => false, 'error' => 'ไม่มี License ที่สร้างสำเร็จเลยในออเดอร์นี้', 'skipped' => $skipped];
        }

        return ['success' => true, 'created' => $created, 'skipped' => $skipped];
    }

    /**
     * ยิง API สร้าง License ให้สินค้า 1 รายการ (1 แถวใน tb_order_detail)
     * แยกยิงทีละรายการ (ไม่รวม items หลายตัวในคำขอเดียว) เพื่อให้ map ผลลัพธ์ที่ได้กลับมา
     * กับ product_sku ของรายการนั้นได้ถูกต้อง 100% — สำคัญมาก เพราะ productCode ที่บันทึกไว้
     * ต้องตรงกับ detail_sku ของ tb_product_detail เป๊ะ ไม่งั้นหน้า "My Products" จะ join ไม่เจอ
     */
    private function createLicenseForDetail(TbOrder $order, User $user, $detail, string $edition, int $seats)
    {
        // [FIX] Town/City (อำเภอ) และ State/Country (จังหวัด) เดิมส่งเป็นค่าว่างเปล่าไปเลย
        // ทำให้ API ตอบ "Town/City is required" / "State/Country is required"
        // ต้อง load relation มาดึงชื่อจริงก่อน (ถ้ายังไม่ถูก eager-load มาจากจุดที่เรียก service)
        if (!$order->relationLoaded('tb_setting_province') || !$order->relationLoaded('tb_setting_amphure')) {
            $order->load(['tb_setting_province', 'tb_setting_amphure']);
        }
        $provinceName = optional($order->tb_setting_province)->prov_name_th ?? '';
        $amphureName  = optional($order->tb_setting_amphure)->amp_name_th ?? '';

        $pp = $this->mapProductAndPeriod($detail->vendor_sku, $edition);    

        $payload = [
            'external_user_id'  => (string) $user->id,
            'user_email'        => $user->email ?? '',
            'firstname_th'      => '',
            'lastname_th'       => '',
            'firstname_en'      => $order->residence_name ?? '',
            'lastname_en'       => $order->residence_lastname ?? '',
            'phone'             => $order->residence_tel ?? '',
            'Steet_address_th'  => '',
            'street_address_en' => $order->residence_address ?? '',
            'Town/City'         => $amphureName,
            'State/Country'     => $provinceName,
            'Postal cod zip'    => $order->residence_zipcode ?? '',
            'Country'           => 'TH',
            'remark'            => 'Order: ' . $order->orderNumber . ' / detail#' . $detail->id,
            // idempotency_key ผูกกับ detail id + เวลาที่ยิงจริง กันไม่ให้ API มองว่าเป็นคำขอซ้ำ
            // ถ้าต้องยิงซ้ำ (เช่น retry หลัง validation error รอบก่อนไม่ผ่าน) — การกันสร้างซ้ำจริงๆ
            // ทำอยู่แล้วในโค้ดเราเอง (เช็ค tb_software_notify ก่อนเรียก service) ไม่ต้องพึ่ง key ตายตัว
            'idempotency_key'   => 'order-' . $order->id . '-detail-' . $detail->id . '-' . uniqid(),
            'items'             => [[
                'product'    => $pp['product'],
                'edition'    => $edition,
                'periodcode' => $pp['periodcode'],
                'type'       => 'd', // d = default (ซื้อจริง) ไม่ใช่ trial
                'seats'      => $seats, // [แก้ใหม่] ใช้จำนวนที่ถูกตัดโควตาแล้ว ไม่ใช่จำนวนที่ลูกค้าสั่งตรงๆ
                // ⚠️ [TEST MODE] เปลี่ยนเป็น true ชั่วคราวตามที่พี่เขาขอให้ทดสอบ
                // ถ้าจะกลับไปใช้แบบเดิม (License ยังไม่เริ่มนับอายุจนกว่าจะ Activate) ให้เปลี่ยนกลับเป็น false
                'startnow'   => false,
            ]],
        ];

        $apiUrl = env('ptcad_api');
        $apiKey = env('api_keys');

        if (empty($apiUrl) || empty($apiKey)) {
            Log::error('PtcadLicenseService: missing ptcad_api / api_keys in .env');
            return ['success' => false, 'created' => [], 'error' => 'ยังไม่ได้ตั้งค่า ptcad_api / api_keys ใน .env'];
        }

        $limitCheck = $this->checkRateLimit((string) $user->id);
        if (!$limitCheck['ok']) {
            Log::warning('PtcadLicenseService: self rate-limit triggered, skip calling API', [
                'orderId' => $order->id,
                'detailId'=> $detail->id,
                'reason'  => $limitCheck['reason'],
            ]);
            return ['success' => false, 'created' => [], 'error' => $limitCheck['reason']];
        }

        try {
            $response = Http::timeout(20)
                ->withToken($apiKey) // ส่งเป็น Authorization: Bearer {api_keys}
                ->post($apiUrl, $payload);

            if ($response->status() === 429) {
                Log::error('PtcadLicenseService: API rate-limited (HTTP 429)', [
                    'orderId' => $order->id, 'detailId' => $detail->id, 'body' => $response->body(),
                ]);
                return ['success' => false, 'created' => [], 'error' => 'ถูกจำกัดการยิง API (rate limit)'];
            }

            if (!$response->successful()) {
                Log::error('PtcadLicenseService: API call failed', [
                    'orderId' => $order->id, 'detailId' => $detail->id,
                    'status'  => $response->status(), 'body' => $response->body(),
                ]);
                return ['success' => false, 'created' => [], 'error' => 'API ตอบกลับผิดพลาด (HTTP ' . $response->status() . ')'];
            }

            $result = $response->json();

            if (empty($result['success']) || empty($result['inserted'])) {
                Log::error('PtcadLicenseService: API returned success=false or no inserted items', [
                    'orderId' => $order->id, 'detailId' => $detail->id, 'body' => $result,
                ]);
                return ['success' => false, 'created' => [], 'error' => $result['message'] ?? 'API สร้าง License ไม่สำเร็จ'];
            }

            $created = [];
            foreach ($result['inserted'] as $license) {
                $created[] = $this->saveLicenseToDb($order, $user, $detail, $license, $pp['periodcode']);
            }

            return ['success' => true, 'created' => $created, 'error' => ''];

        } catch (\Exception $e) {
            Log::error('PtcadLicenseService: Exception while calling API', [
                'orderId' => $order->id, 'detailId' => $detail->id, 'message' => $e->getMessage(),
            ]);
            return ['success' => false, 'created' => [], 'error' => $e->getMessage()];
        }
    }

    /**
     * เอาผลลัพธ์ 1 license จาก API response -> บันทึกลง tb_software + tb_software_notify
     * (โครงสร้างเดียวกับที่ SoftwareController@crate ทำตอนแอดมินกรอกฟอร์มมือ)
     *
     * ⚠️ สำคัญ: productCode ต้องเก็บเป็น product_sku ของ order detail นั้น (ไม่ใช่ product/edition
     * ของ PTCAD API) เพราะหน้า "My Products" (AccountController::software) join กับตาราง
     * tb_product_detail ผ่าน detail_sku = productCode — ถ้าเก็บผิดค่า หน้านั้นจะหาสินค้าไม่เจอ
     */
    private function saveLicenseToDb(TbOrder $order, User $user, $detail, array $license, string $periodcode)
    {
        // license_type: 1 = Perpetual, 2 = Annual (ตามที่ใช้อยู่แล้วใน SoftwareController::jsondata())
        $licenseType = ($periodcode === 'pt') ? 1 : 2;

        $dateStart = !empty($license['timestart']) ? date('Y-m-d', strtotime($license['timestart'])) : date('Y-m-d');

        // [FIX] เดิมถ้า API ยังไม่ส่ง timeexpire มา (License ยังไม่ถูก activate บนเครื่องจริง — เป็นปกติ
        // ตอนสร้างใหม่ เพราะ startnow=false) โค้ดจะปล่อยเป็น null แล้วพัง date() กลายเป็น 1970-01-01
        // ตอนนี้คำนวณวันหมดอายุ "คร่าวๆ" เองจาก periodcode ที่รู้อยู่แล้วแทน (นับจากวันนี้)
        // - Perpetual (pt): ไม่มีวันหมดอายุจริง แต่ระบบเดิมบังคับต้องมีค่า (validate required ตอนแอดมินกรอกมือ)
        //   ตั้งเป็นอีก 100 ปีข้างหน้าแทน (สัญลักษณ์ว่า "ไม่มีวันหมดอายุ")
        // - Xy (1-5 ปี): +X ปีจากวันนี้
        // เมื่อลูกค้า activate จริงแล้ว ค่านี้ควรถูกอัปเดตใหม่จาก API อีกที (TODO ถ้ามี endpoint แจ้งอัปเดตสถานะ activate)
        if (!empty($license['timeexpire'])) {
            $dateExp = date('Y-m-d', strtotime($license['timeexpire']));
        } elseif ($periodcode === 'pt') {
            $dateExp = date('Y-m-d', strtotime('+100 years', strtotime($dateStart)));
        } else {
            $years = (int) filter_var($periodcode, FILTER_SANITIZE_NUMBER_INT); // '1y' -> 1, '2y' -> 2 ...
            $years = $years > 0 ? $years : 1;
            $dateExp = date('Y-m-d', strtotime("+{$years} years", strtotime($dateStart)));
        }

        $productCode = $detail->product_sku; // ต้องตรงกับ tb_product_detail.detail_sku เป๊ะ

        $software = new TbSoftware;
        $software->userId        = $user->id;
        $software->productCode   = $productCode;
        $software->serial_number = $license['serialnumber'] ?? '';
        $software->license_type  = $licenseType;
        $software->date_start    = $dateStart;
        $software->date_exp      = $dateExp;
        $software->price         = $detail->product_price_total ?? '';
        $software->note          = 'สร้างจาก License API อัตโนมัติ (Order: ' . $order->orderNumber . ')';
        $software->show          = 1;
        $software->created_by    = 'SYSTEM (License API)';
        $software->updated_by    = 'SYSTEM (License API)';
        $software->created_at    = date('Y-m-d H:i:s');
        $software->updated_at    = date('Y-m-d H:i:s');
        $software->save();

        $notify = new TbSoftwareNotify;
        $notify->userId          = $user->id;
        $notify->softwareId      = $software->id;
        $notify->orderId         = $order->id;
        $notify->serial_number   = $license['serialnumber'] ?? '';
        $notify->productCode     = $productCode;
        $notify->date_start      = $dateStart;
        $notify->date_exp        = $dateExp;
        $notify->license_type    = $licenseType;
        $notify->price           = $detail->product_price_total ?? '';
        $notify->note            = 'สร้างจาก License API อัตโนมัติ';
        $notify->show            = 1;
        $notify->status          = 2;
        $notify->created_by      = 'SYSTEM (License API)';
        $notify->updated_by      = 'SYSTEM (License API)';
        $notify->created_at      = date('Y-m-d H:i:s');
        $notify->updated_at      = date('Y-m-d H:i:s');
        $notify->save();

        return [
            'serialnumber' => $license['serialnumber'] ?? '',
            'softwareId'   => $software->id,
            'productCode'  => $productCode,
        ];
    }

    /**
     * [Rate limit guard] เช็คก่อนยิง API ทุกครั้ง กันเกิน 6 ครั้ง/นาที/user และ 300 ครั้ง/นาที/เซิร์ฟเวอร์
     * ใช้ fixed-window นับต่อนาที ผ่าน Cache (เขียนแบบง่าย ไม่ต้องพึ่งตารางฐานข้อมูลเพิ่ม)
     *
     * @return array ['ok' => bool, 'reason' => string]
     */
    private function checkRateLimit(string $userKey)
    {
        $window = now()->format('YmdHi'); // เปลี่ยนทุกนาที = fixed window ต่อนาที

        $userCacheKey   = "ptcad_api_rl_user_{$userKey}_{$window}";
        $globalCacheKey = "ptcad_api_rl_global_{$window}";

        $userCount   = Cache::get($userCacheKey, 0);
        $globalCount = Cache::get($globalCacheKey, 0);

        if ($userCount >= 6) {
            return ['ok' => false, 'reason' => "ผู้ใช้นี้ยิง API เกิน 6 ครั้ง/นาทีแล้ว (ตาม limit ของ IT) กรุณารอในนาทีถัดไป"];
        }
        if ($globalCount >= 300) {
            return ['ok' => false, 'reason' => "เซิร์ฟเวอร์ยิง API เกิน 300 ครั้ง/นาทีแล้ว (ตาม limit ของ IT) กรุณารอในนาทีถัดไป"];
        }

        // นับเพิ่มก่อนยิงจริง (กัน race condition แบบหยาบๆ) เก็บไว้ 65 วินาทีพอสำหรับ 1 window
        Cache::put($userCacheKey, $userCount + 1, 65);
        Cache::put($globalCacheKey, $globalCount + 1, 65);

        return ['ok' => true, 'reason' => ''];
    }

    /**
     * API 2: ดู License ทั้งหมดของ user คนหนึ่ง (ค้นด้วย external_user_id)
     * GET {ptcad_api}?external_user_id={value}
     */
    public function getLicensesByExternalUserId(string $externalUserId)
    {
        return $this->callGetApi(env('ptcad_api'), ['external_user_id' => $externalUserId]);
    }

    /**
     * API 3: ดู License ทั้งหมดของ user คนหนึ่ง (ค้นด้วยอีเมล)
     * GET {ptcad_api}?user_email={value}&external_user_id={value}
     *
     * [อัปเดตจากพี่เขา] ทุก GET request ต้องแนบ external_user_id เพิ่มเข้าไปด้วยเสมอ
     */
    /**
     * API 3: ดู License ทั้งหมดของ user คนหนึ่ง (ค้นด้วยอีเมล)
     * GET {ptcad_api}?user_email={value}[&external_user_id={value}]
     *
     * [อัปเดตจากพี่เขา] ปกติ GET ทุกตัวต้องแนบ external_user_id ด้วย แต่กรณีนี้พี่เขา
     * ยืนยันแล้วว่าส่งแค่ user_email อย่างเดียวก็พอ — ใช้เพื่อดึง License ที่อาจถูกสร้าง
     * นอกเว็บเรา (เช่น ทีม Sale สร้างตรงในระบบ PTCAD) ซึ่งเราไม่มี external_user_id ให้ match แน่นอน
     */
    /**
     * API 3: ดู License ทั้งหมดของ user คนหนึ่ง (ค้นด้วยอีเมล)
     * GET {ptcad_api}?user_email={value}&external_user_id={value}
     *
     * ⚠️ [กลับมาบังคับอีกครั้งตามที่พี่เขายืนยันล่าสุด] เดิมทำเป็น optional เพราะ
     * ต้องการหา License ที่ Sale สร้างตรงในระบบ PTCAD (ไม่ผ่านเว็บเรา จึงไม่มี external_user_id
     * ของเว็บเราให้ match) — ถ้า API เช็คว่า email+external_user_id ต้องตรงกันทั้งคู่ การค้นแบบนี้
     * อาจจะหา License ของ Sale ไม่เจอเลย (เพราะ Sale ไม่รู้ external_user_id ของเว็บเรา)
     * ต้องทดสอบจริงเพื่อยืนยันว่า API ยังหาเจอ License ของ Sale ได้อยู่ไหม
     */
    public function getLicensesByEmail(string $email, string $externalUserId)
    {
        return $this->callGetApi(env('ptcad_api'), [
            'user_email'       => $email,
            'external_user_id' => $externalUserId,
        ]);
    }

    /**
     * API 4: ดูรายละเอียด License 1 ตัวจาก serial number
     * GET {ptcad_api}/{serial_number}?external_user_id={value}
     *
     * [อัปเดตจากพี่เขา] ทุก GET request ต้องแนบ external_user_id เพิ่มเข้าไปด้วยเสมอ
     */
    public function getLicenseBySerialNumber(string $serialNumber, string $externalUserId)
    {
        $base = rtrim((string) env('ptcad_api'), '/');
        return $this->callGetApi($base . '/' . $serialNumber, [
            'external_user_id' => $externalUserId,
        ]);
    }

    /**
     * API 5: ดู License ทั้งหมดใน Order เดียว (ใช้ base URL คนละตัว: ptcad_api_order)
     * GET {ptcad_api_order}/{order_number}?external_user_id={value}
     *
     * [อัปเดตจากพี่เขา] ทุก GET request ต้องแนบ external_user_id เพิ่มเข้าไปด้วยเสมอ
     */
    public function getLicensesByOrderNumber(string $orderNumber, string $externalUserId)
    {
        $base = rtrim((string) env('ptcad_api_order'), '/');
        return $this->callGetApi($base . '/' . $orderNumber, [
            'external_user_id' => $externalUserId,
        ]);
    }

    /**
     * ตัวกลางสำหรับยิง GET ทั้ง 4 endpoint ด้านบน — มี rate-limit guard + จับ 429 เหมือนกันหมด
     *
     * @return array ['success'=>bool, 'data'=>array|null, 'error'=>string]
     */
    private function callGetApi(string $url, array $query = [])
    {
        $apiKey = env('api_keys');

        if (empty($url) || empty($apiKey)) {
            return ['success' => false, 'data' => null, 'error' => 'ยังไม่ได้ตั้งค่า ptcad_api / ptcad_api_order / api_keys ใน .env'];
        }

        // ใช้ url เป็น key แทน user id เพราะ endpoint พวกนี้เรียกจากฝั่ง staff/ระบบ ไม่ผูกกับ user รายบุคคลเสมอไป
        $limitCheck = $this->checkRateLimit(md5($url . json_encode($query)));
        if (!$limitCheck['ok']) {
            Log::warning('PtcadLicenseService: self rate-limit triggered on GET', ['url' => $url, 'query' => $query]);
            return ['success' => false, 'data' => null, 'error' => $limitCheck['reason']];
        }

        try {
            $response = Http::timeout(20)
                ->withToken($apiKey)
                ->get($url, $query);

            if ($response->status() === 429) {
                Log::error('PtcadLicenseService: GET API rate-limited (HTTP 429)', ['url' => $url, 'query' => $query]);
                return ['success' => false, 'data' => null, 'error' => 'ถูกจำกัดการยิง API (rate limit) กรุณารอสักครู่แล้วลองใหม่'];
            }

            if (!$response->successful()) {
                Log::error('PtcadLicenseService: GET API call failed', [
                    'url'    => $url,
                    'query'  => $query,
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);
                return ['success' => false, 'data' => null, 'error' => 'API ตอบกลับผิดพลาด (HTTP ' . $response->status() . ')'];
            }

            $result = $response->json();

            if (empty($result['success'])) {
                return ['success' => false, 'data' => null, 'error' => $result['message'] ?? 'ไม่พบข้อมูล'];
            }

            return ['success' => true, 'data' => $result, 'error' => ''];

        } catch (\Exception $e) {
            Log::error('PtcadLicenseService: Exception on GET API', ['url' => $url, 'message' => $e->getMessage()]);
            return ['success' => false, 'data' => null, 'error' => $e->getMessage()];
        }
    }
        /**
     * API 6: ต่ออายุ License (เรียกตอน Stripe ตัดเงินรอบต่ออายุสำเร็จ)
     * POST link_extend_api
     */
    public function extendLicense(string $serialNumber, string $externalUserId = '')
    {
        $url = env('PTCAD_API_EXTEND');
        $apiKey = env('api_keys');

        if (empty($url) || empty($apiKey)) {
            return ['success' => false, 'data' => null, 'error' => 'ยังไม่ได้ตั้งค่า PTCAD_API_EXTEND / api_keys ใน .env'];
        }

        try {
            $response = Http::timeout(20)
                ->withToken($apiKey)
                ->post($url, [
                    'external_user_id' => $externalUserId,
                    'serialnumber'     => $serialNumber,
                ]);

            if (!$response->successful()) {
                Log::error('PtcadLicenseService: Extend API failed', [
                    'serial' => $serialNumber, 'status' => $response->status(), 'body' => $response->body(),
                ]);
                return ['success' => false, 'data' => null, 'error' => 'API ตอบกลับผิดพลาด (HTTP ' . $response->status() . ')'];
            }

            $result = $response->json();

            if (empty($result['success'])) {
                return ['success' => false, 'data' => null, 'error' => $result['message'] ?? 'Extend License ไม่สำเร็จ'];
            }

            return ['success' => true, 'data' => $result, 'error' => ''];

        } catch (\Exception $e) {
            Log::error('PtcadLicenseService: Exception on Extend API', ['serial' => $serialNumber, 'message' => $e->getMessage()]);
            return ['success' => false, 'data' => null, 'error' => $e->getMessage()];
        }
    }
}