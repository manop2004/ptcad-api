<?php

namespace App\Imports;

use App\Models\TbProduct;
use App\Models\TbProductDetail;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class ProductImport implements ToCollection, WithHeadingRow, WithValidation, WithChunkReading, WithBatchInserts
{
    use Importable;

    /**
     * นับจำนวน "แถว" ที่ถูกอ่านจริง (ไม่ใช่จำนวน chunk)
     */
    private int $rows = 0;

    /**
     * map SKU เดิม -> SKU ใหม่ ภายในไฟล์เดียวกัน
     * เพื่อป้องกันแถวถัดไปยังอ้าง old sku แล้วหา record ไม่เจอ
     */
    private array $skuMap = [];

    /**
     * กัน new sku ซ้ำกันภายในไฟล์เดียวกัน (ในรอบ import)
     */
    private array $newSkuUsed = [];

    public function collection(Collection $rows)
    {
        // นับแถวจริง
        $this->rows += $rows->count();

        $arr_status = [
            'สินค้าพร้อมส่ง'      => '1',
            'สินค้าหมด'           => '2',
            'สินค้าพรีออเดอร์'     => '3',
            'Training'            => '4',
        ];

        foreach ($rows as $row) {

            // กัน key ไม่ครบ
            $oldSkuRaw = $row['sku_product'] ?? null;
            $oldSku = trim((string) $oldSkuRaw);
            if ($oldSku === '') {
                continue;
            }

            // ถ้า sku เดิมเคยถูกเปลี่ยนไปแล้วในไฟล์เดียวกัน ให้ lookup ด้วย sku ใหม่
            $lookupSku = $this->skuMap[$oldSku] ?? $oldSku;

            // Find Product Detail with 'SKU'
            $importData = TbProductDetail::where('detail_sku', $lookupSku)->first();
            if (!$importData) {
                continue;
            }

            /**
             * อัปเดต detail_sku จาก new_sku_product (ถ้ามี)
             */
            $newSku = trim((string) ($row['new_sku_product'] ?? ''));
            if ($newSku !== '') {

                // กัน new sku ซ้ำในไฟล์เดียวกัน
                if (isset($this->newSkuUsed[$newSku])) {
                    continue;
                }

                // กัน new sku ซ้ำกับของเดิมใน DB (ยกเว้นกรณีมันคือ sku ของ record นี้อยู่แล้ว)
                $exists = TbProductDetail::where('detail_sku', $newSku)
                    ->where('id', '!=', $importData->id)
                    ->exists();

                if ($exists) {
                    continue;
                }

                // เปลี่ยน SKU
                $importData->detail_sku = $newSku;

                // จำ mapping เผื่อแถวอื่นยังอ้าง sku เดิม
                $this->skuMap[$oldSku] = $newSku;

                // กันซ้ำในไฟล์
                $this->newSkuUsed[$newSku] = true;
            }

            /**
             * sku_promotion => tb_product_detail.vendor_sku
             * ถ้าไม่มีข้อมูล ไม่ต้องอัปเดต
             */
            $vendorSku = trim((string) ($row['sku_promotion'] ?? ''));
            if ($vendorSku !== '') {
                $importData->vendor_sku = $vendorSku;
            }

            /**
             * promotion_detial => tb_product_detail.detail_other
             * ถ้ามีค่านำมาอัปเดตได้เลย
             */
            if (array_key_exists('promotion_detial', $row->toArray())) {
                $importData->detail_other = $row['promotion_detial'];
            }

            /**
             * hide_cart => tb_product_detail.hide_addtocart_status
             * ถ้าไม่มีข้อมูล ไม่ต้องอัปเดต
             *
             * รองรับค่าหลายรูปแบบ เช่น:
             * 1, 2, yes, no, true, false, on, off, hide, show
             */
            $hideAddToCartRaw = trim((string) ($row['hide_cart'] ?? ''));
            if ($hideAddToCartRaw !== '') {
                $hideAddToCart = $this->normalizeHideAddToCart($hideAddToCartRaw);
                if ($hideAddToCart !== null) {
                    $importData->hide_addtocart_status = $hideAddToCart;
                }
            }

            // name_product_sub
            if (isset($row['name_product_sub']) && !empty($row['name_product_sub'])) {
                $importData->detail_name = $row['name_product_sub'];
            }

            // check_stock
            if (isset($row['check_stock'])) {
                $importData->detail_check_stock_status = null;

                if (!empty($row['check_stock'])) {
                    if (strtolower(trim((string) $row['check_stock'])) === 'yes') {
                        $importData->detail_check_stock_status = 1;
                    }
                }
            }

            // stock
            if (isset($row['stock'])) {
                $importData->detail_stock = null;
                if (!empty($row['stock'])) {
                    $importData->detail_stock = $row['stock'];
                }
            }

            // price_product
            if (isset($row['price_product'])) {
                if (!empty($row['price_product'])) {
                    $importData->detail_product_contact_sale_status = 2;
                    $importData->detail_price = $this->rewrite_number($row['price_product']);
                }
            }

            // price_promotion
            if (isset($row['price_promotion'])) {
                if (!empty($row['price_promotion'])) {
                    $importData->detail_price_sale_status = 1;
                    $importData->detail_price_sale = $this->rewrite_number($row['price_promotion']);
                    $importData->detail_price_sale_status_date = 2; // ไม่กำหนดเวลา
                } else {
                    $importData->detail_price_sale_status = 2;
                    $importData->detail_price_sale = null;
                }
            }

            // price_promotion_start / price_promotion_end
            if (isset($row['price_promotion_start']) && isset($row['price_promotion_end'])) {
                if (!empty($row['price_promotion_start']) && !empty($row['price_promotion_end'])) {
                    $importData->detail_price_sale_status_date = 1; // กำหนดเวลา
                    $importData->detail_sale_date_start = $row['price_promotion_start'];
                    $importData->detail_sale_date_end = $row['price_promotion_end'];
                } else {
                    $importData->detail_sale_date_start = null;
                    $importData->detail_sale_date_end = null;
                }
            }

            // status
            if (isset($row['status']) && !empty($row['status'])) {
                $statusKey = trim((string) $row['status']);
                $status = $arr_status[$statusKey] ?? $statusKey;
                $importData->detail_status = $status;
            }

            // preorder_day
            if (isset($row['preorder_day'])) {
                $importData->detail_preorder_day = null;
                if (!empty($row['preorder_day'])) {
                    $importData->detail_preorder_day = $this->rewrite_number($row['preorder_day']);
                }
            }

            $importData->updated_by = Auth::user()->displayname;
            $importData->updated_at = date('Y-m-d H:i:s');
            $importData->save();

            // tb_product : name_product_main
            if (isset($row['name_product_main']) && !empty($row['name_product_main'])) {
                $update = TbProduct::find($importData->proId);
                if ($update) {
                    $update->pro_name = $row['name_product_main'];
                    $update->save();
                }
            }
        }
    }

    public function rules(): array
    {
        return [
            '*.sku_product' => 'required',

            // sku_product ต้องมีอยู่จริงใน DB
            '*.sku_product' => function ($attribute, $value, $onFailure) {
                $detail_sku = trim((string) $value);
                if ($detail_sku === '') {
                    $onFailure('กรุณากรอกรหัสสินค้า (sku_product)');
                    return;
                }

                $exists = TbProductDetail::where('detail_sku', $detail_sku)->exists();
                if (!$exists) {
                    $onFailure('รหัสสินค้า "' . $detail_sku . '" ไม่พบข้อมูลที่ตรงกันในฐานข้อมูล! กรุณาตรวจสอบข้อมูลอีกครั้ง');
                }
            },

            // new_sku_product ถ้ามี ต้องไม่ซ้ำกับ SKU อื่นในระบบ
            '*.new_sku_product' => function ($attribute, $value, $onFailure) {
                if ($value === null) {
                    return;
                }

                $newSku = trim((string) $value);
                if ($newSku === '') {
                    return;
                }

                $exists = TbProductDetail::where('detail_sku', $newSku)->exists();
                if ($exists) {
                    $onFailure('new_sku_product "' . $newSku . '" ซ้ำกับ SKU ที่มีอยู่แล้วในระบบ!');
                }
            },

            // sku_promotion ถ้ามี ไม่ต้องว่างล้วน
            '*.sku_promotion' => function ($attribute, $value, $onFailure) {
                if ($value === null) {
                    return;
                }

                $vendorSku = trim((string) $value);
                if ($vendorSku === '') {
                    return;
                }
            },

            // promotion_detial ถ้ามี ไม่ต้อง validate อะไรเป็นพิเศษ
            '*.promotion_detial' => function ($attribute, $value, $onFailure) {
                if ($value === null) {
                    return;
                }
            },

            // hide_cart ถ้ามี ต้องเป็นค่าที่ระบบรู้จัก
            '*.hide_cart' => function ($attribute, $value, $onFailure) {
                if ($value === null) {
                    return;
                }

                $raw = trim((string) $value);
                if ($raw === '') {
                    return;
                }

                $normalized = $this->normalizeHideAddToCart($raw);
                if ($normalized === null) {
                    $onFailure('hide_cart "' . $raw . '" ไม่ถูกต้อง กรุณาใช้ค่าเช่น 1, 2, yes, no, true, false, on, off, hide, show');
                }
            },
        ];
    }

    public function customValidationMessages(): array
    {
        return [
            '*.sku_product.required' => '":attribute" กรุณากรอกรหัสสินค้า.',
        ];
    }

    public function headingRow(): int
    {
        return 1;
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function getRowCount(): int
    {
        return $this->rows;
    }

    /**
     * เดิม: ลบทุกอย่างเหลือแต่ตัวเลขกับ -
     * คง behavior เดิมไว้เพื่อไม่กระทบระบบ
     */
    private function rewrite_number($number)
    {
        $str_replace = strtolower(str_replace(" ", "", (string) $number));
        $data = preg_replace('/[^0-9\-]/', '', $str_replace);
        return $data;
    }

    /**
     * แปลงค่า hide_cart ให้เป็น status ที่จะบันทึกลง DB
     * ตอนนี้ตีความเป็น:
     * 1 = ซ่อนปุ่ม Add to cart
     * 2 = แสดงปุ่ม Add to cart
     */
    private function normalizeHideAddToCart(string $value): ?int
    {
        $value = strtolower(trim($value));

        $hideValues = ['1', 'yes', 'true', 'on', 'hide', 'hidden'];
        $showValues = ['2', 'no', 'false', 'off', 'show', 'visible'];

        if (in_array($value, $hideValues, true)) {
            return 1;
        }

        if (in_array($value, $showValues, true)) {
            return 2;
        }

        return null;
    }
}