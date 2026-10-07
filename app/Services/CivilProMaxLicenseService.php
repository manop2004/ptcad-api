<?php

namespace App\Services;

use App\Models\TbOrder;
use App\Models\TbProductDetail;
use App\Models\LicenseKeyStock;
use App\Models\User;
use App\Mail\civilProMaxLicenseNotify;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CivilProMaxLicenseService
{
    private array $civilProMaxSkus = [
        'CIVILPROMAX-3M',
        'CIVILPROMAX-6M',
        'CIVILPROMAX-1Y',
    ];

    // [เพิ่มใหม่] Bundle SKU -> Civil ProMax SKU จริงที่ต้องไปดึงสต็อกคีย์มาให้
    // เพิ่ม Bundle ใหม่ในอนาคต แค่เพิ่มบรรทัดในนี้ ไม่ต้องแก้ที่อื่นในไฟล์นี้เลย
    private array $bundleCivilSkuMap = [
        'BUNDLE-PLUS-CIVIL1Y' => 'CIVILPROMAX-1Y',
        'BUNDLE-STD-CIVIL1Y'  => 'CIVILPROMAX-1Y',
        'BUNDLE-LITE-CIVIL1Y' => 'CIVILPROMAX-1Y',
    ];

    public function createLicenseForOrder(TbOrder $order): array
    {
        $already = LicenseKeyStock::where('orderId', $order->id)->exists();
        if ($already) {
            Log::info('CivilProMaxLicenseService: skip, order already has license key', ['orderId' => $order->id]);
            return ['success' => false, 'error' => 'Order นี้มี License Key อยู่แล้ว (ข้ามการจ่ายคีย์ซ้ำ)'];
        }

        $user = User::where('user_code', $order->userCode)->first();
        if (empty($user)) {
            Log::error('CivilProMaxLicenseService: user not found', ['orderId' => $order->id, 'userCode' => $order->userCode]);
            return ['success' => false, 'error' => 'ไม่พบผู้ใช้งานของ order นี้'];
        }

        $created = [];
        $skipped = [];

        foreach ($order->tb_order_details as $detail) {

            // [เพิ่มใหม่] เช็คว่าเป็น Civil ProMax ตรงๆ หรือเป็น Bundle ที่มี Civil ProMax ซ่อนอยู่
            $stockSku = null;
            if (in_array($detail->product_sku, $this->civilProMaxSkus, true)) {
                $stockSku = $detail->product_sku;
            } elseif (isset($this->bundleCivilSkuMap[$detail->product_sku])) {
                $stockSku = $this->bundleCivilSkuMap[$detail->product_sku];
            }

            if (empty($stockSku)) {
                continue; // ไม่ใช่ Civil ProMax หรือ Bundle ที่รู้จัก ปล่อยให้ PtcadLicenseService จัดการ
            }

            $result = $this->assignKeyForDetail($order, $user, $detail, $stockSku);

            if ($result['success']) {
                $created[] = $result['data'];
            } else {
                $skipped[] = $detail->product_sku . ' (error: ' . $result['error'] . ')';
            }
        }

        if (empty($created) && empty($skipped)) {
            return ['success' => true, 'created' => [], 'skipped' => [], 'note' => 'ไม่มีสินค้า Civil ProMax ในออเดอร์นี้'];
        }

        if (empty($created)) {
            Log::error('CivilProMaxLicenseService: no key assigned in this order', ['orderId' => $order->id, 'skipped' => $skipped]);
            return ['success' => false, 'error' => 'ไม่สามารถจ่ายคีย์ Civil ProMax ได้เลยในออเดอร์นี้', 'skipped' => $skipped];
        }

        $this->sendLicenseMail($order, $user, $created);

        return ['success' => true, 'created' => $created, 'skipped' => $skipped];
    }

    /**
     * @param string $stockSku SKU จริงที่ใช้ค้นหาคีย์ในสต็อก (ต่างจาก $detail->product_sku
     *                          ได้ในกรณีที่ $detail เป็น Bundle SKU - ดู $bundleCivilSkuMap ด้านบน)
     */
    private function assignKeyForDetail(TbOrder $order, User $user, $detail, string $stockSku): array
    {
        $qty = (int) ($detail->product_unit ?: 1);
        $assignedKeys = [];

        try {
            DB::transaction(function () use ($detail, $order, $qty, $stockSku, &$assignedKeys) {
                for ($i = 0; $i < $qty; $i++) {

                    $keyRow = LicenseKeyStock::where('detail_sku', $stockSku)
                        ->where('status', LicenseKeyStock::STATUS_AVAILABLE)
                        ->lockForUpdate()
                        ->first();

                    if (empty($keyRow)) {
                        Log::critical('CivilProMaxLicenseService: STOCK EMPTY mid-transaction', [
                            'orderId' => $order->id,
                            'detail_sku' => $detail->product_sku,
                            'stock_sku' => $stockSku,
                        ]);
                        throw new \RuntimeException('สต็อกคีย์ของ ' . $stockSku . ' หมดกะทันหัน');
                    }

                    $keyRow->status  = LicenseKeyStock::STATUS_USED;
                    $keyRow->orderId = $order->id;
                    $keyRow->used_at = now();
                    $keyRow->updated_by = 'SYSTEM (Stripe Webhook)';
                    $keyRow->save();

                    $assignedKeys[] = $keyRow;
                }

                $remaining = LicenseKeyStock::where('detail_sku', $stockSku)
                    ->where('status', LicenseKeyStock::STATUS_AVAILABLE)
                    ->count();

                TbProductDetail::where('detail_sku', $stockSku)
                    ->update([
                        'detail_stock' => $remaining,
                        'updated_at'   => now(),
                    ]);
            });

        } catch (\Exception $e) {
            Log::error('CivilProMaxLicenseService: Exception while assigning key', [
                'orderId' => $order->id,
                'detail_sku' => $detail->product_sku,
                'stock_sku' => $stockSku,
                'message' => $e->getMessage(),
            ]);
            return ['success' => false, 'error' => $e->getMessage()];
        }

        return [
            'success' => true,
            'data' => [
                'product_sku' => $detail->product_sku,
                'product_name' => $detail->product_name,
                'keys' => array_map(fn($k) => $k->license_key, $assignedKeys),
            ],
        ];
    }

    private function sendLicenseMail(TbOrder $order, User $user, array $createdItems): void
    {
        try {
            $setting = \App\Models\TbSetting::first();
            $page = \App\Models\TbPagesMap::first();

            $data = new \stdClass();
            $data->setting_nameWeb = $setting->setting_nameWeb ?? '';
            $data->setting_logoWeb = $setting->setting_logoWeb ?? '';
            $data->order = $order;
            $data->page = $page;
            $data->createdItems = $createdItems;
            $data->customerName = trim(($order->residence_name ?? '') . ' ' . ($order->residence_lastname ?? ''));

            Mail::to($user->email)->later(now()->addMinutes(2), new civilProMaxLicenseNotify($data));
        } catch (\Exception $e) {
            Log::error('CivilProMaxLicenseService: failed to send license mail', [
                'orderId' => $order->id,
                'message' => $e->getMessage(),
            ]);
        }
    }
}