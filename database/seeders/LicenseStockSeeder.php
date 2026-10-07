<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LicenseStockSeeder extends Seeder
{
    public function run()
    {
        $rows = [];
        foreach ([['PTCAD', '1y'], ['PTCADL', '1y'], ['PTC26', 'pt']] as [$product, $period]) {
            for ($i = 1; $i <= 200; $i++) {
                $rows[] = [
                    'product'       => $product,
                    'periodcode'    => $period,
                    'serial_number' => sprintf('%s-%s-TEST-%04d', $product, strtoupper($period), $i),
                    'status'        => 'available',
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ];
            }
        }
        DB::table('license_stock')->insertOrIgnore($rows);
    }
}