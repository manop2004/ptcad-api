<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LicenseApiController extends Controller
{
    public function create(Request $request)
    {
        $expected = env('api_keys');
        $token = $request->bearerToken();
        if (empty($expected) || !$token || !hash_equals($expected, $token)) {
            return response()->json(['success' => false, 'error' => 'unauthorized'], 401);
        }

        $item = $request->input('items.0');
        $product = $item['product'] ?? null;
        $period = $item['periodcode'] ?? null;
        $seats = max(1, (int) ($item['seats'] ?? 1));

        if (!$product || !$period) {
            return response()->json(['success' => false, 'error' => 'product and periodcode are required'], 422);
        }

        $orderRef = Str::limit((string) $request->input('remark', ''), 50, '');

        $serial = DB::transaction(function () use ($product, $period, $orderRef) {
            $row = DB::table('license_stock')
                ->where('product', $product)
                ->where('periodcode', $period)
                ->where('status', 'available')
                ->orderBy('id')
                ->lockForUpdate()
                ->first();

            if (!$row) {
                return null;
            }

            DB::table('license_stock')->where('id', $row->id)->update([
                'status'         => 'used',
                'used_for_order' => $orderRef,
                'used_at'        => now(),
                'updated_at'     => now(),
            ]);

            return $row->serial_number;
        });

        if (!$serial) {
            return response()->json(['success' => false, 'error' => 'out of stock'], 409);
        }

        return response()->json([
            'success'  => true,
            'message'  => 'ok',
            'inserted' => [[
                'serialnumber' => $serial,
                'product'      => $product,
                'periodcode'   => $period,
                'seats'        => $seats,
            ]],
        ]);
    }
}