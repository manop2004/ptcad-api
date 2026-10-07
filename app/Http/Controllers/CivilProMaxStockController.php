<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LicenseKeyStock;
use App\Models\TbProductDetail;
use Illuminate\Http\Request;

class CivilProMaxStockController extends Controller
{
    private array $columnSkuMap = [
        '3 เดือน'  => 'CIVILPROMAX-3M',
        '6 เดือน'  => 'CIVILPROMAX-6M',
        '12 เดือน' => 'CIVILPROMAX-1Y',
    ];

    public function importForm()
    {
        $stockSummary = LicenseKeyStock::selectRaw('detail_sku, count(*) as total')
            ->where('status', LicenseKeyStock::STATUS_AVAILABLE)
            ->whereIn('detail_sku', array_values($this->columnSkuMap))
            ->groupBy('detail_sku')
            ->pluck('total', 'detail_sku');

        return view('admin.civilpromax.import', compact('stockSummary'));
    }

    public function importStore(Request $request)
    {
        $request->validate(['stock_file' => 'required|file|mimes:csv,txt']);

        $handle = fopen($request->file('stock_file')->getRealPath(), 'r');
        $header = fgetcsv($handle);
        $header = array_map(fn($h) => trim(str_replace("\xEF\xBB\xBF", '', $h)), $header);

        $columnIndexMap = [];
        foreach ($this->columnSkuMap as $columnName => $sku) {
            $idx = array_search($columnName, $header, true);
            if ($idx !== false) {
                $columnIndexMap[$idx] = $sku;
            }
        }

        if (empty($columnIndexMap)) {
            fclose($handle);
            return back()->with('import_error', 'ไม่พบคอลัมน์ "3 เดือน" / "6 เดือน" / "12 เดือน" ในไฟล์');
        }

        $imported = 0;
        $duplicated = 0;

        while (($row = fgetcsv($handle)) !== false) {
            foreach ($columnIndexMap as $colIdx => $sku) {
                $key = trim($row[$colIdx] ?? '');
                if ($key === '') continue;

                if (LicenseKeyStock::where('license_key', $key)->exists()) {
                    $duplicated++;
                    continue;
                }

                LicenseKeyStock::create([
                    'detail_sku'  => $sku,
                    'license_key' => $key,
                    'status'      => LicenseKeyStock::STATUS_AVAILABLE,
                    'created_by'  => auth()->user()->displayname ?? 'ADMIN',
                ]);
                $imported++;
            }
        }
        fclose($handle);

        foreach (array_unique($columnIndexMap) as $sku) {
            $remaining = LicenseKeyStock::where('detail_sku', $sku)
                ->where('status', LicenseKeyStock::STATUS_AVAILABLE)->count();

            TbProductDetail::where('detail_sku', $sku)->update([
                'detail_stock' => $remaining,
                'updated_at'   => now(),
            ]);
        }

        return back()->with('import_success', "นำเข้าสำเร็จ {$imported} คีย์ — ข้ามคีย์ซ้ำ {$duplicated} รายการ");
    }
}