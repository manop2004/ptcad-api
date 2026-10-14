<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TbOrder;
use App\Models\TbSoftwareNotify;
use App\Models\LicenseKeyStock;
use Carbon\Carbon;

class BotnoiLicenseController extends Controller
{
    /**
     * API สำหรับให้ Botnoi Chatbot เรียกเพื่อตรวจสอบข้อมูล License ของผู้ใช้
     * รองรับทั้ง GET และ POST
     * พารามิเตอร์ค้นหา: search, email, tel, phone, serial, order_number
     */
    public function checkLicense(Request $request)
    {
        \Log::info('Botnoi checkLicense called', [
            'all' => $request->all(),
            'search' => $request->input('search'),
            'ip' => $request->ip(),
            'method' => $request->method(),
        ]);

        $inputSearch = trim($request->input('search') ?? '');
        $inputTel = trim($request->input('tel') ?? $request->input('phone') ?? '');
        $inputEmail = trim($request->input('email') ?? '');

        // กรณีเป็นตัวแปร template หรือค่าว่าง
        if (empty($inputSearch) && empty($inputTel) && empty($inputEmail)) {
            return response()->json([
                'status'  => 'ready',
                'found'   => false,
                'count'   => 0,
                'message' => 'กรุณากรอกทั้งเบอร์โทรศัพท์และอีเมลที่ใช้สั่งซื้อ เพื่อตรวจสอบข้อมูล License ครับ',
                'licenses' => [],
            ], 200, ['Content-Type' => 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
        }

        // ดึง Email และ Phone จาก input
        $email = $inputEmail;
        $phone = $inputTel;

        // แยก Email และ Phone จาก search query ถ้าไม่ได้แยกส่งมา
        if (!empty($inputSearch) && (empty($email) || empty($phone))) {
            // ค้นหา email ด้วย regex
            if (preg_match('/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/', $inputSearch, $matches)) {
                $email = $matches[0];
            }
            // ค้นหาเบอร์โทร 9-10 หลัก
            if (preg_match('/(0[0-9]{8,9})/', preg_replace('/[^0-9]/', '', $inputSearch), $matchesPhone)) {
                $phone = $matchesPhone[0];
            }
        }

        // ตรวจสอบความปลอดภัย: ต้องมีทั้งเบอร์โทรและอีเมล
        if (empty($email) || empty($phone)) {
            if (empty($email) && !empty($phone)) {
                $msg = "ระบบได้รับเบอร์โทรศัพท์ ({$phone}) แล้วครับ\n🔒 เพื่อความปลอดภัย กรุณาพิมพ์:\n\nเช็ค license {$phone} อีเมลของคุณ\n\n(ตัวอย่างเช่น: เช็ค license {$phone} user@gmail.com)";
            } elseif (!empty($email) && empty($phone)) {
                $msg = "ระบบได้รับอีเมล ({$email}) แล้วครับ\n🔒 เพื่อความปลอดภัย กรุณาพิมพ์:\n\nเช็ค license เบอร์โทรของคุณ {$email}\n\n(ตัวอย่างเช่น: เช็ค license 08XXXXXXXX {$email})";
            } else {
                $msg = "🔒 เพื่อความปลอดภัย กรุณาพิมพ์ทั้งเบอร์โทรศัพท์และอีเมลคู่กันครับ\n\n(ตัวอย่างเช่น: เช็ค license 0998889999 user@gmail.com)";
            }

            return response()->json([
                'status'  => 'incomplete_info',
                'found'   => false,
                'count'   => 0,
                'message' => $msg,
                'licenses' => [],
            ], 200, ['Content-Type' => 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
        }

        // คลีนเบอร์โทร
        $cleanPhone = preg_replace('/[^0-9]/', '', $phone);
        if (str_starts_with($cleanPhone, '66') && strlen($cleanPhone) == 11) {
            $cleanPhone = '0' . substr($cleanPhone, 2);
        }

        // 1. ค้นหา User ที่ตรง "ทั้งอีเมลและเบอร์โทร" พร้อมกันเท่านั้น
        $users = User::where('email', $email)
            ->where(function ($q) use ($cleanPhone, $phone) {
                $q->where('tel', $phone)
                  ->orWhere('tel', $cleanPhone)
                  ->orWhereRaw("REPLACE(REPLACE(REPLACE(tel, '-', ''), ' ', ''), '+66', '0') = ?", [$cleanPhone]);
            })
            ->get();

        if ($users->isEmpty()) {
            return response()->json([
                'status'   => 'not_found',
                'found'    => false,
                'count'    => 0,
                'message'  => "ไม่พบข้อมูลผู้ใช้งานที่ตรงกับทั้งเบอร์โทร {$phone} และอีเมล {$email}\nกรุณาตรวจสอบความถูกต้องอีกครั้งครับ",
                'licenses' => [],
            ], 200, ['Content-Type' => 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
        }

        $userIds = $users->pluck('id')->toArray();
        $userCodes = $users->pluck('user_code')->toArray();

        // 2. ดึง License จาก TbSoftwareNotify (PTCAD License)
        $softwares = TbSoftwareNotify::query()
            ->leftJoin('tb_product_detail', 'tb_product_detail.detail_sku', '=', 'tb_software_notify.productCode')
            ->leftJoin('tb_product', 'tb_product.id', '=', 'tb_product_detail.proId')
            ->select(
                'tb_software_notify.*',
                'tb_product.pro_name',
                'tb_product.pro_download',
                'tb_product.pro_installer',
                'tb_product.pro_activation_guide'
            )
            ->where('tb_software_notify.show', 1)
            ->whereIn('tb_software_notify.userId', $userIds)
            ->get();

        // 3. ดึง License จาก LicenseKeyStock (Civil ProMax)
        $civilLicenses = LicenseKeyStock::query()
            ->join('tb_order', 'tb_order.id', '=', 'tb_license_key_stock.orderId')
            ->leftJoin('tb_product_detail', 'tb_product_detail.detail_sku', '=', 'tb_license_key_stock.detail_sku')
            ->leftJoin('tb_product', 'tb_product.id', '=', 'tb_product_detail.proId')
            ->select(
                'tb_license_key_stock.*',
                'tb_product.pro_name',
                'tb_product.pro_download',
                'tb_product.pro_installer',
                'tb_product.pro_activation_guide'
            )
            ->where('tb_license_key_stock.status', LicenseKeyStock::STATUS_USED)
            ->whereIn('tb_order.userCode', $userCodes)
            ->get();

        // 4. รวบรวมข้อมูล License ทั้งหมด
        $licenseList = [];

        foreach ($softwares as $sw) {
            $dateStart = $sw->date_start ? Carbon::parse($sw->date_start)->format('d-m-Y') : '-';
            $dateExp = $sw->date_exp ? Carbon::parse($sw->date_exp)->format('d-m-Y') : '-';
            $isExpired = $sw->date_exp && Carbon::parse($sw->date_exp)->isPast();

            $licenseList[] = [
                'type'             => 'PTCAD',
                'product_name'     => $sw->pro_name ?? $sw->productCode ?? 'PTCAD License',
                'serial_number'    => $sw->serial_number,
                'status'           => $isExpired ? 'Expired' : ($sw->status == 2 ? 'Active' : 'Pending'),
                'status_th'        => $isExpired ? 'หมดอายุแล้ว' : ($sw->status == 2 ? 'ใช้งานได้' : 'รอดำเนินการ'),
                'date_start'       => $dateStart,
                'date_exp'         => $dateExp,
                'download_url'     => $sw->pro_installer ? asset('storage/product/' . $sw->pro_installer) : null,
                'guide_url'        => $sw->pro_activation_guide ? asset('storage/product/' . $sw->pro_activation_guide) : null,
            ];
        }

        foreach ($civilLicenses as $civil) {
            $months = match (true) {
                str_ends_with((string)$civil->detail_sku, '-3M') => 3,
                str_ends_with((string)$civil->detail_sku, '-6M') => 6,
                str_ends_with((string)$civil->detail_sku, '-1Y') => 12,
                default => 12,
            };
            $start = $civil->used_at ? Carbon::parse($civil->used_at) : Carbon::now();
            $exp = $start->copy()->addMonths($months);
            $isExpired = $exp->isPast();

            $licenseList[] = [
                'type'             => 'Civil ProMax',
                'product_name'     => $civil->pro_name ?? $civil->detail_sku ?? 'Civil ProMax',
                'serial_number'    => $civil->license_key,
                'status'           => $isExpired ? 'Expired' : 'Active',
                'status_th'        => $isExpired ? 'หมดอายุแล้ว' : 'ใช้งานได้',
                'date_start'       => $start->format('d-m-Y'),
                'date_exp'         => $exp->format('d-m-Y'),
                'download_url'     => $civil->pro_installer ? asset('storage/product/' . $civil->pro_installer) : null,
                'guide_url'        => $civil->pro_activation_guide ? asset('storage/product/' . $civil->pro_activation_guide) : null,
            ];
        }

        $count = count($licenseList);

        if ($count === 0) {
            return response()->json([
                'status'   => 'not_found',
                'found'    => false,
                'count'    => 0,
                'message'  => "ไม่พบข้อมูล License สำหรับเบอร์ {$phone} และอีเมล {$email}\nกรุณาตรวจสอบว่าข้อมูลทั้งสองถูกต้องตรงกับที่ใช้สั่งซื้อหรือไม่ครับ",
                'licenses' => [],
            ], 200, ['Content-Type' => 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
        }

        // ลิงก์หน้าดู License ตรงโปรดักที่ซื้อแล้ว (My Products / ซอฟต์แวร์ของฉัน)
        $baseUrl = env('SITE_URL', env('APP_URL', 'http://localhost:8000'));
        if (str_contains($baseUrl, 'Ptcad-.test')) {
            $baseUrl = 'http://localhost:8000';
        }
        $myProductUrl = rtrim($baseUrl, '/') . '/account/software';

        // จัดรูปแบบข้อความสรุปสำหรับแชทบอทตอบลูกค้า
        $summaryLines = ["พบ License ทั้งหมด {$count} รายการ:"];
        foreach ($licenseList as $index => $item) {
            $no = $index + 1;
            $line = "{$no}. {$item['product_name']}\n   • Serial: {$item['serial_number']}\n   • สถานะ: {$item['status_th']}\n   • วันหมดอายุ: {$item['date_exp']}";
            if (!empty($item['download_url'])) {
                $line .= "\n   • ลิงก์ดาวน์โหลด: {$item['download_url']}";
            }
            $summaryLines[] = $line;
        }

        $summaryLines[] = "👉 แนะนำ: คุณสามารถคลิกดูรายละเอียด License ทั้งหมดและดาวน์โหลดโปรแกรมได้ที่หน้า My Products (ซอฟต์แวร์ของฉัน):\n🔗 {$myProductUrl}";

        $botMessage = implode("\n\n", $summaryLines);

        $matchedUser = $users->first();

        return response()->json([
            'status'         => 'success',
            'found'          => true,
            'count'          => $count,
            'my_product_url' => $myProductUrl,
            'user'           => $matchedUser ? [
                'name'  => trim(($matchedUser->name ?? '') . ' ' . ($matchedUser->lastname ?? '')),
                'email' => $matchedUser->email,
                'tel'   => $matchedUser->tel,
            ] : null,
            'message'        => $botMessage,
            'licenses'       => $licenseList,
        ], 200, ['Content-Type' => 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
    }

    /**
     * หน้าแสดงรายละเอียดและปุ่มก็อปปี้ API สำหรับนำไปใส่ใน Botnoi Chatbot
     */
    public function docs(Request $request)
    {
        $host = $request->getSchemeAndHttpHost();
        $testUrl = $host . '/api/botnoi/license?search=0998889999';
        $prodUrl = $host . '/api/botnoi/license?search={user_input}';

        return view('developer.api_docs', compact('host', 'testUrl', 'prodUrl'));
    }
}

