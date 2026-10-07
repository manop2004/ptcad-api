<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class SecretTestController extends Controller
{
    // Product ID ของสินค้าทดสอบ (ราคา 1 บาท ซ่อนไว้ ไม่โชว์หน้าเว็บปกติ)
    private const PRODUCT_ID = 359;

    public function show()
    {
        $product = DB::table('tb_product')->where('id', self::PRODUCT_ID)->first();
        $detail  = DB::table('tb_product_detail')->where('proId', self::PRODUCT_ID)->first();

        if (empty($product) || empty($detail)) {
            abort(404, 'ไม่พบสินค้าทดสอบ ID ' . self::PRODUCT_ID);
        }

        $price = !empty($detail->detail_price_sale) ? (float) $detail->detail_price_sale : (float) $detail->detail_price;

        return view('fontend.secret_test_buy', compact('product', 'detail', 'price'));
    }

    public function buy()
    {
        $product = DB::table('tb_product')->where('id', self::PRODUCT_ID)->first();
        $detail  = DB::table('tb_product_detail')->where('proId', self::PRODUCT_ID)->first();

        if (empty($product) || empty($detail)) {
            abort(404, 'ไม่พบสินค้าทดสอบ ID ' . self::PRODUCT_ID);
        }

        $price = !empty($detail->detail_price_sale) ? (float) $detail->detail_price_sale : (float) $detail->detail_price;

        $picture = DB::table('tb_product_picture')
            ->where('proId', $product->id)
            ->where('picture_status', 1)
            ->first();
        $image = !empty($picture) ? asset('storage/product/' . $picture->picture_name) : asset('images/default-img/no-img.jpg');

        $rowId = $product->id . '_' . $detail->detail_sku . '_00_PRO';
        $cartGet = \Cart::get($rowId);

        $attributes = array(
            'sku' => $detail->detail_sku,
            'image' => $image,
            'permalink' => $product->pro_permalink,
            'detail_name' => $detail->detail_name ?? 'null',
            'detail_other' => $detail->detail_other ?? 'null',
            'price' => $price,
            'pricesale' => '',
        );

        if (!empty($cartGet)) {
            \Cart::update($rowId, [
                'quantity' => 1,
                'attributes' => $attributes,
            ]);
        } else {
            \Cart::add(array(
                'id' => $rowId,
                'name' => $product->pro_name,
                'price' => $price,
                'quantity' => 1,
                'attributes' => $attributes,
            ));
        }

        return redirect()->route('fronend.cart');
    }
}