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

        $search = trim($request->input('search') ?? $request->input('email') ?? $request->input('tel') ?? $request->input('phone') ?? $request->input('serial') ?? $request->input('order_number') ?? '');

        if (empty($search)) {
            return response()->json([
                'status'  => 'ready',
                'found'   => false,
                'count'   => 0,
                'message' => 'กรุณาระบุอีเมล เบอร์โทรศัพท์ หรือ Serial Number ที่ต้องการค้นหา',
                'licenses' => [],
            ], 200, ['Content-Type' => 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
        }

        // 1. ค้นหา User จาก Email, Tel หรือ user_code
        $users = User::where('email', $search)
            ->orWhere('tel', $search)
            ->orWhere('user_code', $search)
            ->get();

        $userIds = $users->pluck('id')->toArray();
        $userCodes = $users->pluck('user_code')->toArray();

        // 2. ดึง License จาก TbSoftwareNotify (PTCAD License)
        $softwareQuery = TbSoftwareNotify::query()
            ->leftJoin('tb_product_detail', 'tb_product_detail.detail_sku', '=', 'tb_software_notify.productCode')
            ->leftJoin('tb_product', 'tb_product.id', '=', 'tb_product_detail.proId')
            ->select(
                'tb_software_notify.*',
                'tb_product.pro_name',
                'tb_product.pro_download',
                'tb_product.pro_installer',
                'tb_product.pro_activation_guide'
            )
            ->where('tb_software_notify.show', 1);

        if (!empty($userIds)) {
            $softwareQuery->where(function($q) use ($userIds, $search) {
                $q->whereIn('tb_software_notify.userId', $userIds)
                  ->orWhere('tb_software_notify.serial_number', $search);
            });
        } else {
            $softwareQuery->where('tb_software_notify.serial_number', $search);
        }

        $softwares = $softwareQuery->get();

        // 3. ดึง License จาก LicenseKeyStock (Civil ProMax)
        $civilQuery = LicenseKeyStock::query()
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
            ->where('tb_license_key_stock.status', LicenseKeyStock::STATUS_USED);

        if (!empty($userCodes)) {
            $civilQuery->where(function($q) use ($userCodes, $search) {
                $q->whereIn('tb_order.userCode', $userCodes)
                  ->orWhere('tb_license_key_stock.license_key', $search)
                  ->orWhere('tb_order.orderNumber', $search);
            });
        } else {
            $civilQuery->where(function($q) use ($search) {
                $q->where('tb_license_key_stock.license_key', $search)
                  ->orWhere('tb_order.orderNumber', $search);
            });
        }

        $civilLicenses = $civilQuery->get();

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
                'message'  => "ไม่พบข้อมูล License สำหรับ \"{$search}\" กรุณาตรวจสอบอีเมลหรือเบอร์โทรศัพท์ที่ใช้สั่งซื้ออีกครั้งครับ",
                'licenses' => [],
            ], 200);
        }

        // จัดรูปแบบข้อความสรุปสำหรับแชทบอทตอบลูกค้า
        $summaryLines = ["พบ License ทั้งหมด {$count} รายการ:"];
        foreach ($licenseList as $index => $item) {
            $no = $index + 1;
            $summaryLines[] = "{$no}. {$item['product_name']}\n   • Serial: {$item['serial_number']}\n   • สถานะ: {$item['status_th']}\n   • วันหมดอายุ: {$item['date_exp']}";
        }

        $botMessage = implode("\n\n", $summaryLines);

        $matchedUser = $users->first();

        return response()->json([
            'status'   => 'success',
            'found'    => true,
            'count'    => $count,
            'user'     => $matchedUser ? [
                'name'  => trim(($matchedUser->name ?? '') . ' ' . ($matchedUser->lastname ?? '')),
                'email' => $matchedUser->email,
                'tel'   => $matchedUser->tel,
            ] : null,
            'message'  => $botMessage,
            'licenses' => $licenseList,
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

