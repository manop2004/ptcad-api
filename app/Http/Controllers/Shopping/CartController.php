<?php

namespace App\Http\Controllers\Shopping;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Models\TbSetting;
use App\Models\TbTypeSetting;
use App\Models\TbProduct;
use App\Models\TbProductPicture;
use App\Models\TbSettingProvince;
use App\Models\TbSettingPayment;
use App\Models\TbSettingInstallment;
use App\Models\UsersAddress;
use App\Models\UsersAddressReceipt;
use App\Http\Controllers\Shopping\CouponController;


class CartController extends Controller
{
    public function cart(){

		$setting = TbSetting::first();

		$breadcrumb = [
			['route' => route('fronend.home'), 'name' => 'หน้าหลัก'],
			['route' => '', 'name' => 'ตะกร้าสินค้า'],
		];

		//title share
		if(!empty($page_name)){ $og_site_name = $page_name; }else{ $og_site_name = "ตะกร้าสินค้า";}
		if(!empty($page_name)){ $og_title = $page_name; }else{ $og_title = $og_site_name = "ตะกร้าสินค้า";}
		if(!empty($setting->setting_keyword)){ $og_keywords = $setting->setting_keyword; }else{ $og_keywords = "";}
		if(!empty($setting->setting_detail)){ $og_description = $setting->setting_detail; }else{ $og_description = "";}
		if(!empty($setting->setting_coverShare)){ $og_image = asset('storage/setting/'.$setting->setting_coverShare); }else{ $og_image = asset('storage/setting/'.$setting->setting_coverShare);}
		if(!empty($page)){ $og_url = route('fronend.cart'); }else{ $og_url = route('fronend.home');}

		$data = \Cart::getContent();
		$dataCondition = \Cart::getConditions();

		// ✅ validate coupon เหมือนเดิม
		$couponCtrl = app(CouponController::class);
		foreach ($dataCondition as $condition) {
			$code    = $condition->getName();
			$invalid = $couponCtrl->validateCouponForCart($code);

			if ($invalid !== 0) {
				\Cart::clearCartConditions();
				return redirect()
					->route('fronend.cart')
					->with('invalid', $invalid);
			}
		}

		// ✅ sanitize quantity ตาม min/max/stock 1 รอบ (กัน refresh แล้วเด้งผิด)
		$changed = false;

		foreach ($data as $item) {

			$rowId = (string) $item->id;
			$sku   = $item->attributes->sku ?? null;

			if (!$sku) continue;

			$pd = \App\Models\TbProductDetail::where('detail_sku', $sku)->first();

			// ถ้าไม่เจอ productDetail ก็ไม่บังคับ min/max/stock
			if (!$pd) continue;

			$detail_status = (int) ($pd->detail_status ?? 0);
			$checkStock    = (int) ($pd->detail_check_stock_status ?? 0);
			$stock         = (int) ($pd->detail_stock ?? 0);

			$min_order = (int) ($pd->min_order ?? 1);
			if ($min_order < 1) $min_order = 1;

			$max_order_val = (int) ($pd->max_order ?? 0);
			$max_order = ($max_order_val > 0) ? $max_order_val : null;

			$qty = (int) ($item->quantity ?? 0);

			// สินค้าหมด (status=2) -> remove
			if ($detail_status === 2) {
				\Cart::remove($rowId);
				$changed = true;
				continue;
			}

			// qty <=0 -> remove
			if ($qty <= 0) {
				\Cart::remove($rowId);
				$changed = true;
				continue;
			}

			// เพดานบน = min(max_order, stock) ถ้าเปิดเช็ค stock
			$upper = null;
			if ($max_order !== null) $upper = $max_order;
			if ($checkStock === 1) {
				if ($stock <= 0) {
					\Cart::remove($rowId);
					$changed = true;
					continue;
				}
				$upper = ($upper === null) ? $stock : min($upper, $stock);
			}

			// กฎ min
			if ($qty < $min_order) $qty = $min_order;

			// กฎ max/stock
			if ($upper !== null && $qty > $upper) $qty = $upper;

			// update เฉพาะถ้าต่างจริง
			if ($qty !== (int)$item->quantity) {
				\Cart::update($rowId, [
					'quantity' => [
						'relative' => false,
						'value' => $qty,
					],
				]);
				$changed = true;
			}
		}

		// ✅ ถ้ามีการปรับ/ลบ ให้ redirect เพื่อ refresh totals แบบ clean (ไม่ใช้ window.reload)
		if ($changed) {
			return redirect()->route('fronend.cart');
		}

		if(count($data) != 0){
			$total = $this->getTotalCart($data);
		}else{
			$total = "";
		}

		// [เพิ่มใหม่] นับจำนวน License รวมทั้งตะกร้า (ไม่เกิน 5 ต่อออเดอร์ ตามที่ IT กำหนด)
		$maxLicensePerOrder = 5;
		$totalLicenseQty = 0;
		foreach ($data as $item) {
			$totalLicenseQty += (int) ($item->quantity ?? 0);
		}
		$licenseOverLimit = $totalLicenseQty > $maxLicensePerOrder;

		return view('fontend.cart.cart',[
			'breadcrumb' => $breadcrumb,
			'og_site_name' => $og_site_name,
			'og_keywords' => $og_keywords,
			'og_title' => $og_title,
			'og_description' => $og_description,
			'og_url' => $og_url,
			'og_image' => $og_image,
			'page_name' => 'ตะกร้าสินค้า',
			'data' => $data,
			'total' => $total,
			'dataCondition' => $dataCondition,
			'totalLicenseQty' => $totalLicenseQty,
			'maxLicensePerOrder' => $maxLicensePerOrder,
			'licenseOverLimit' => $licenseOverLimit,
		]);

	}
	
	public function cart2(){

        $setting = TbSetting::first();

        $breadcrumb = [
            ['route' => route('fronend.home'), 'name' => 'หน้าหลัก'],
            ['route' => '', 'name' => 'ตะกร้าสินค้า'],
        ];

        //title share
        if(!empty($page_name)){ $og_site_name = $page_name; }else{ $og_site_name = "ตะกร้าสินค้า";}
        if(!empty($page_name)){ $og_title = $page_name; }else{ $og_title = $og_site_name = "ตะกร้าสินค้า";}
        if(!empty($setting->setting_keyword)){ $og_keywords = $setting->setting_keyword; }else{ $og_keywords = "";}
        if(!empty($setting->setting_detail)){ $og_description = $setting->setting_detail; }else{ $og_description = "";}
        if(!empty($setting->setting_coverShare)){ $og_image = asset('storage/setting/'.$setting->setting_coverShare); }else{ $og_image = asset('storage/setting/'.$setting->setting_coverShare);}
        if(!empty($page)){ $og_url = route('fronend.cart2'); }else{ $og_url = route('fronend.home');}

        $data = \Cart::getContent();
        $dataCondition = \Cart::getConditions();

        if(count($data) != 0){
            $total = $this->getTotalCart($data);
        }else{
            $total = "";
        }

        // \Cart::clearCartConditions();
        // return $total;

        return view('fontend.cart.cart2',[
            'breadcrumb' => $breadcrumb,
            'og_site_name' => $og_site_name,
            'og_keywords' => $og_keywords,
            'og_title' => $og_title,
            'og_description' => $og_description,
            'og_url' => $og_url,
            'og_image' => $og_image,
            'page_name' => 'ตะกร้าสินค้า',
            'data' => $data,
            'total' => $total,
            'dataCondition' => $dataCondition,
        ]);

    }

    public function addTocart_One(Request $request){

        $proId = $request->proId;
        $quantityItem = $request->quantity;
        $ref = $request->ref;

        if(!empty($proId) && !empty($quantityItem)){

            $products = $this->productGet_one($proId);

            foreach($products as $product){

                if(!empty($product['pricesale'])){
                    $price = $product['pricesale'];
                }else{
                    $price = $product['price'];
                }

                if($product['detail_name'] != 'null'){
                    $pro_name = $product['detail_name'];
                }else{
                    $pro_name = $product['pro_name'];
                }

                $rowId = $product['id'].'_'.$product['detail_sku'].'_00_PRO';
                $cartGet = \Cart::get($rowId);

                if(!empty($cartGet)){
					
					if($ref == '' && $cartGet->ref){
						$ref = $cartGet->ref;
					}

                    \Cart::update($rowId,[
                        'name' => $pro_name,
                        'price' => $price,
                        'quantity' => $quantityItem,
                        'ref' => $ref,
                        'attributes' => array(
                            'sku' => $product['detail_sku'],
                            'image' => $product['picture_name'],
                            'permalink' => $product['pro_permalink'],
                            'detail_name' => $product['detail_name'],
                            'detail_other' => $product['detail_other'],
                            'price' => $product['price'],
                            'pricesale' => $product['pricesale'],
                        ),
                    ]);

                }else{

                    \Cart::add(array(
                        'id' => $rowId,
                        'name' => $pro_name,
                        'price' => $price,
                        'quantity' => $quantityItem,
                        'ref' => $ref,
                        'attributes' => array(
                            'sku' => $product['detail_sku'],
                            'image' => $product['picture_name'],
                            'permalink' => $product['pro_permalink'],
                            'detail_name' => $product['detail_name'],
                            'detail_other' => $product['detail_other'],
                            'price' => $product['price'],
                            'pricesale' => $product['pricesale'],
                        ),
                    ));

                }

                $TotalQuantity = \Cart::getTotalQuantity();

                $response[] = array(
                    'id' => $product['id'],
                    'pro_name' => $product['pro_name'],
                    'pro_permalink' => $product['pro_permalink'],
                    'detail_sku' => $product['detail_sku'],
                    'detail_name' => $product['detail_name'],
                    'detail_other' => $product['detail_other'],
                    'picture_name' => $product['picture_name'],
                    'price' => $product['price'],
                    'pricesale' => $product['pricesale'],
                    'TotalQuantity' => $TotalQuantity
                );

                return $response;
            }

        }else{
            return 'false';
        }

    }

    public function addTocart_Two(Request $request){

        $proId = $request->proId;
        $detailId = $request->detailId;
        $quantityItem = $request->quantity;
        $ref = $request->ref;

        if(!empty($proId) && !empty($detailId) && !empty($quantityItem)){

            $products = $this->productGet_two($proId,$detailId);

            foreach($products as $product){

                if(!empty($product['pricesale'])){
                    $price = $product['pricesale'];
                }else{
                    $price = $product['price'];
                }

                $pro_name = $product['pro_name'];

                $rowId = $product['id'].'_'.$product['detail_sku'].'_00_PRO';
                $cartGet = \Cart::get($rowId);;

                if(!empty($cartGet)){

                    \Cart::update($rowId,[
                        'name' => $pro_name,
                        'price' => $price,
                        'quantity' => $quantityItem,
                        'ref' => $ref,
                        'attributes' => array(
                            'sku' => $product['detail_sku'],
                            'image' => $product['picture_name'],
                            'permalink' => $product['pro_permalink'],
                            'detail_name' => $product['detail_name'],
                            'detail_other' => $product['detail_other'],
                            'price' => $product['price'],
                            'pricesale' => $product['pricesale'],
                        ),
                    ]);

                }else{

                    \Cart::add(array(
                        'id' => $rowId,
                        'name' => $pro_name,
                        'price' => $price,
                        'quantity' => $quantityItem,
                        'ref' => $ref,
                        'attributes' => array(
                            'sku' => $product['detail_sku'],
                            'image' => $product['picture_name'],
                            'permalink' => $product['pro_permalink'],
                            'detail_name' => $product['detail_name'],
                            'detail_other' => $product['detail_other'],
                            'price' => $product['price'],
                            'pricesale' => $product['pricesale'],
                        ),
                    ));

                }

                $TotalQuantity = \Cart::getTotalQuantity();
                $response[] = array(
                    'id' => $product['id'],
                    'pro_name' => $product['pro_name'],
                    'pro_permalink' => $product['pro_permalink'],
                    'detail_sku' => $product['detail_sku'],
                    'detail_name' => $product['detail_name'],
                    'detail_other' => $product['detail_other'],
                    'picture_name' => $product['picture_name'],
                    'price' => $product['price'],
                    'pricesale' => $product['pricesale'],
                    'TotalQuantity' => $TotalQuantity,
                );

                return $response;
            }

        }else{
            return 'false';
        }


    }

    public function cartUpdate(Request $request){

		$rowId = (string) $request->rowId;
		$qtyReq = (int) $request->quantity;

		$item = \Cart::get($rowId);
		if (!$item) {
			return response()->json([
				'ok' => false,
				'message' => 'Cart item not found',
			], 404);
		}

		$sku = $item->attributes->sku ?? null;
		if (!$sku) {
			// ถ้าไม่มี sku ก็ update แบบตรง ๆ แต่กันค่าติดลบ
			$qtyFinal = max(1, $qtyReq);
			\Cart::update($rowId, [
				'quantity' => ['relative' => false, 'value' => $qtyFinal],
			]);

			return response()->json([
				'ok' => true,
				'quantity_final' => $qtyFinal,
			]);
		}

		$pd = \App\Models\TbProductDetail::where('detail_sku', $sku)->first();

		// ถ้าไม่เจอ productDetail -> ไม่ enforce min/max/stock (กันพัง)
		if (!$pd) {
			$qtyFinal = max(1, $qtyReq);
			\Cart::update($rowId, [
				'quantity' => ['relative' => false, 'value' => $qtyFinal],
			]);

			return response()->json([
				'ok' => true,
				'quantity_final' => $qtyFinal,
			]);
		}

		$detail_status = (int) ($pd->detail_status ?? 0);
		$checkStock    = (int) ($pd->detail_check_stock_status ?? 0);
		$stock         = (int) ($pd->detail_stock ?? 0);

		$min_order = (int) ($pd->min_order ?? 1);
		if ($min_order < 1) $min_order = 1;

		$max_order_val = (int) ($pd->max_order ?? 0);
		$max_order = ($max_order_val > 0) ? $max_order_val : null;

		// สินค้าหมด
		if ($detail_status === 2) {
			\Cart::remove($rowId);
			return response()->json([
				'ok' => true,
				'removed' => true,
				'reason' => 'status_out',
			]);
		}

		// qtyReq ถ้าต่ำกว่า 0/ว่าง ให้ treat เป็น min_order (ตามกฎ)
		$qtyFinal = $qtyReq;
		if ($qtyFinal <= 0) $qtyFinal = $min_order;

		// เพดานบน (max + stock)
		$upper = null;
		if ($max_order !== null) $upper = $max_order;

		if ($checkStock === 1) {
			if ($stock <= 0) {
				\Cart::remove($rowId);
				return response()->json([
					'ok' => true,
					'removed' => true,
					'reason' => 'out_of_stock',
				]);
			}
			$upper = ($upper === null) ? $stock : min($upper, $stock);
		}

		// clamp min
		if ($qtyFinal < $min_order) $qtyFinal = $min_order;

		// clamp upper
		if ($upper !== null && $qtyFinal > $upper) $qtyFinal = $upper;

		\Cart::update($rowId, [
			'quantity' => [
				'relative' => false,
				'value' => $qtyFinal
			],
		]);

		return response()->json([
			'ok' => true,
			'quantity_final' => $qtyFinal,
			'min_order' => $min_order,
			'max_order' => $max_order,
			'stock' => ($checkStock === 1) ? $stock : null,
			'upper' => $upper,
		]);

	}
	
	public function cartConfirm(){
		$setting = TbSetting::first();
		$provinces = TbSettingProvince::get();
		$settingPayment = TbSettingPayment::first();
		$settingInstallment = TbSettingInstallment::get();
		$usersAddress = UsersAddress::where('userId',Auth::user()->id)->first();
		$usersReceipt = UsersAddressReceipt::where('userId',Auth::user()->id)->first();

		$breadcrumb = [
			['route' => route('fronend.home'), 'name' => 'หน้าหลัก'],
			['route' => '', 'name' => 'ชำระเงิน'],
		];

		if(!empty($page_name)){ $og_site_name = $page_name; }else{ $og_site_name = "ชำระเงิน";}
		if(!empty($page_name)){ $og_title = $page_name; }else{ $og_title = $og_site_name = "ชำระเงิน";}
		if(!empty($setting->setting_keyword)){ $og_keywords = $setting->setting_keyword; }else{ $og_keywords = "";}
		if(!empty($setting->setting_detail)){ $og_description = $setting->setting_detail; }else{ $og_description = "";}
		if(!empty($setting->setting_coverShare)){ $og_image = asset('storage/setting/'.$setting->setting_coverShare); }else{ $og_image = asset('storage/setting/'.$setting->setting_coverShare);}
		if(!empty($og_url)){ $og_url = route('fronend.cart'); }else{ $og_url = route('fronend.home');}

		$data = \Cart::getContent();

		// persona ที่เลือกในฟอร์ม (1=บุคคล, 2=บริษัท)
		$personaType = (int) (request('receipt_persona_type') ?? old('receipt_persona_type') ?? 1);

		// user เลือกหัก WHT หรือไม่ (0/1)
		$applyWht = (request('withholding_apply') ?? old('withholding_apply') ?? '0') === '1';

		$ref = '';
		if(count($data) != 0){

			// ชุดบุคคล
			$total_person_no_wht   = $this->getTotalCart($data, false, 1);
			$total_person_with_wht = $this->getTotalCart($data, true,  1);

			// ชุดบริษัท
			$total_company_no_wht   = $this->getTotalCart($data, false, 2);
			$total_company_with_wht = $this->getTotalCart($data, true,  2);

			// total ที่แสดงตอนแรก จะให้เป็นบุคคล/ไม่หัก ก็ได้ตาม UI เดิม
			$total = $total_person_no_wht;

			foreach($data as $product){
				if($product->ref != ''){
					$ref .= ','.$product->ref;
				}
			}
			$ref = substr($ref,1);
			$ref = str_replace('?ref=','',$ref);
			$ref = str_replace('?','',$ref);
			$ref = str_replace('&','',$ref);
			$ref = str_replace('ref=','',$ref);

		}else{
    $empty = ['total'=>0,'withholding'=>0,'vat'=>0,'subtotal'=>0,'nettotal'=>0,'totaldiscount'=>0];

    $total = $empty;
    $total_person_no_wht = $empty;
    $total_person_with_wht = $empty;
    $total_company_no_wht = $empty;
    $total_company_with_wht = $empty;
}

		$dataCondition = \Cart::getConditions();

		$couponCtrl = app(CouponController::class);
		foreach ($dataCondition as $condition) {
			$code    = $condition->getName();
			$invalid = $couponCtrl->validateCouponForCart($code);

			if ($invalid !== 0) {
				\Cart::clearCartConditions();
				return redirect()
					->route('fronend.cart.confirm')
					->with('invalid', $invalid);
			}
		}

		return view('fontend.cart.orderConfirm',[
			'breadcrumb' => $breadcrumb,
			'og_site_name' => $og_site_name,
			'og_keywords' => $og_keywords,
			'og_title' => $og_title,
			'og_description' => $og_description,
			'og_url' => $og_url,
			'og_image' => $og_image,
			'setting' => $setting,
			'page_name' => 'ชำระเงิน',
			'data' => $data,
			'total' => $total,
			'dataCondition' => $dataCondition,
			'provinces' => $provinces,
			'settingPayment' => $settingPayment,
			'settingInstallment' => $settingInstallment,
			'usersAddress' => $usersAddress,
			'usersReceipt' => $usersReceipt,
			'ref' => $ref,

			'total_person_no_wht' => $total_person_no_wht,
			'total_person_with_wht' => $total_person_with_wht,
			'total_company_no_wht' => $total_company_no_wht,
			'total_company_with_wht' => $total_company_with_wht,

		]);
	}


    public function cartDelete($id){
        \Cart::remove($id);

        return back();
    }

    public function cartClear(){

        \Cart::clear();
        \Cart::clear();

    }

    private function productGet_one($proId){

        $data = TbProduct::select(
            'tb_product.id','tb_product.pro_name','tb_product.pro_permalink',
            'tb_product_detail.id','tb_product_detail.proId','tb_product_detail.detail_sku','tb_product_detail.detail_name',
            'tb_product_detail.detail_other','tb_product_detail.detail_product_contact_sale_status','tb_product_detail.detail_price',
            'tb_product_detail.detail_price_sale_status','tb_product_detail.detail_price_sale','tb_product_detail.detail_price_sale_status_date',
            'tb_product_detail.detail_sale_date_start','tb_product_detail.detail_sale_date_end','tb_product_detail.detail_show',
            'tb_product_picture.proId','tb_product_picture.picture_status','tb_product_picture.picture_name',
        )
        ->leftjoin('tb_product_detail','tb_product_detail.proId','tb_product.id')
        ->leftjoin('tb_product_picture','tb_product_picture.proId','tb_product.id')
        ->where('tb_product_picture.picture_status',1)
        ->where('tb_product.pro_show',1)
        ->where('tb_product.id',$proId)
        ->first();

        $dateToday = date('Y-m-d');

        if ($data->detail_product_contact_sale_status == 2){
            if ($data->detail_price_sale_status == 1){
                if ($data->detail_price_sale_status_date == 1){
                    if (!empty($data->detail_sale_date_start) && !empty($data->detail_sale_date_end)){
                            $startdate = $this->compareDate($dateToday, date("Y-m-d",strtotime($data->detail_sale_date_start)));
                            $enddate = $this->compareDate($dateToday, date("Y-m-d",strtotime($data->detail_sale_date_end)));

                        if ($startdate != 2 && $enddate != 0){
                            $price = $data->detail_price;
                            $pricesale = $data->detail_price_sale;
                        }else{
                            $price = $data->detail_price;
                            $pricesale = '';
                        }

                    }else if(!empty($data->detail_sale_date_start) && empty($data->detail_sale_date_end)){
                        $startdate = $this->compareDate($dateToday, date("Y-m-d",strtotime($data->detail_sale_date_start)));

                        if ($startdate != 2){
                            $price = $data->detail_price;
                            $pricesale = $data->detail_price_sale;
                        }else{
                            $price = $data->detail_price;
                            $pricesale = '';
                        }

                    }elseif (empty($data->detail_sale_date_start) && !empty($data->detail_sale_date_end)){
                        $enddate = $this->compareDate($dateToday, date("Y-m-d",strtotime($data->detail_sale_date_end)));

                        if ($enddate != 0){
                            $price = $data->detail_price;
                            $pricesale = $data->detail_price_sale;
                        }else{
                            $price = $data->detail_price;
                            $pricesale = '';
                        }

                    }else{
                        $price = $data->detail_price;
                        $pricesale = $data->detail_price_sale;
                    }
                }else{
                    $price = $data->detail_price;
                    $pricesale = $data->detail_price_sale;
                }
            }else{
                $price = $data->detail_price;
                $pricesale = '';
            }
        }else{
            $price = '0';
            $pricesale = '';
        }

        if(!empty($data->picture_name)){
            $image = asset('storage/product/'.$data->picture_name);
        }else{
            $image = asset('images/default-img/no-img.jpg');
        }

        $product[] = array(
            'id' => $data->proId,
            'pro_name' => $data->pro_name,
            'pro_permalink' => $data->pro_permalink,
            'detail_sku' => $data->detail_sku,
            'detail_name' => 'null',
            'detail_other' => 'null',
            'picture_name' => $image,
            'price' => $price,
            'pricesale' => $pricesale,
        );

        return $product;

    }

    private function productGet_two($proId,$detailId){

        $data = TbProduct::select(
            'tb_product.id','tb_product.pro_name','tb_product.pro_permalink',
            'tb_product_detail.id','tb_product_detail.proId','tb_product_detail.detail_sku','tb_product_detail.detail_name',
            'tb_product_detail.detail_other','tb_product_detail.detail_product_contact_sale_status','tb_product_detail.detail_price',
            'tb_product_detail.detail_price_sale_status','tb_product_detail.detail_price_sale','tb_product_detail.detail_price_sale_status_date',
            'tb_product_detail.detail_sale_date_start','tb_product_detail.detail_sale_date_end','tb_product_detail.detail_show',
            'tb_product_picture.detailId','tb_product_picture.picture_name',
        )
        ->leftjoin('tb_product_detail','tb_product_detail.proId','tb_product.id')
        ->leftjoin('tb_product_picture','tb_product_picture.detailId','tb_product_detail.id')
        ->where('tb_product.pro_show',1)
        ->where('tb_product_detail.id',$detailId)
        ->where('tb_product.id',$proId)
        ->first();

        $dateToday = date('Y-m-d');;

        if ($data->detail_product_contact_sale_status == 2){
            if ($data->detail_price_sale_status == 1){
                if ($data->detail_price_sale_status_date == 1){
                    if (!empty($data->detail_sale_date_start) && !empty($data->detail_sale_date_end)){
                            $startdate = $this->compareDate($dateToday, date("Y-m-d",strtotime($data->detail_sale_date_start)));
                            $enddate = $this->compareDate($dateToday, date("Y-m-d",strtotime($data->detail_sale_date_end)));

                        if ($startdate != 2 && $enddate != 0){
                            $price = $data->detail_price;
                            $pricesale = $data->detail_price_sale;
                        }else{
                            $price = $data->detail_price;
                            $pricesale = '';
                        }

                    }else if(!empty($data->detail_sale_date_start) && empty($data->detail_sale_date_end)){
                        $startdate = $this->compareDate($dateToday, date("Y-m-d",strtotime($data->detail_sale_date_start)));

                        if ($startdate != 2){
                            $price = $data->detail_price;
                            $pricesale = $data->detail_price_sale;
                        }else{
                            $price = $data->detail_price;
                            $pricesale = '';
                        }

                    }elseif (empty($data->detail_sale_date_start) && !empty($data->detail_sale_date_end)){
                        $enddate = $this->compareDate($dateToday, date("Y-m-d",strtotime($data->detail_sale_date_end)));

                        if ($enddate != 0){
                            $price = $data->detail_price;
                            $pricesale = $data->detail_price_sale;
                        }else{
                            $price = $data->detail_price;
                            $pricesale = '';
                        }

                    }else{
                        $price = $data->detail_price;
                        $pricesale = $data->detail_price_sale;
                    }
                }else{
                    $price = $data->detail_price;
                    $pricesale = $data->detail_price_sale;
                }
            }else{
                $price = $data->detail_price;
                $pricesale = '';
            }
        }else{
            $price = '0';
            $pricesale = '';
        }

        if(!empty($data->picture_name)){
            $image = asset('storage/product/'.$data->picture_name);
        }else{

            $picture_name = TbProductPicture::where('proId',$data->proId)->value('picture_name');
            $image = asset('storage/product/'.$picture_name);
        }

        $product[] = array(
            'id' => $data->proId,
            'pro_name' => $data->pro_name,
            'pro_permalink' => $data->pro_permalink,
            'detail_sku' => $data->detail_sku,
            'detail_name' => $data->detail_name,
            'detail_other' => $data->detail_other,
            'picture_name' => $image,
            'price' => $price,
            'pricesale' => $pricesale,
        );

        return $product;

    }

    private function getTotalCart($data, bool $applyWht = true, ?int $personaType = null){

		$subtotal = 0;
		$totalVat = 0;
		$totalWithholding = 0;
		$totalPrice = 0;
		$subtotal_discount = 0;

		$typeSetting = TbTypeSetting::first();
		$dataCondition = \Cart::getConditions();

		// ถ้าไม่ได้ส่ง personaType มา ให้ fallback จาก user_type (เดิม)
		if ($personaType === null) {
			$personaType = (int) (Auth::user()->user_type ?? 1);
		}

		// WHT คิดได้เฉพาะ persona บริษัท (2) และ user เลือก applyWht
		$canWht = ($personaType === 2) && $applyWht;

		// ------------------------------
		// CASE A: ไม่มีคูปอง
		// ------------------------------
		if(count($dataCondition) == 0){

			$setData = [];

			foreach($data as $product){

				// ดึง tb_product.id จาก rowId เช่น "123_SW-xxx_00_PRO"
				$proId = (int) explode('_', (string)$product->id)[0];

				$check = TbProduct::select(
					'tb_product.id','tb_product.pro_name','tb_product.pro_catId',
					'tb_category.id','tb_category.category_type',
					'tb_type.id','tb_type.type_vat','tb_type.type_withholding'
				)
				->leftjoin('tb_category','tb_category.id','tb_product.pro_catId')
				->leftjoin('tb_type','tb_type.id','tb_category.category_type')
				->where('tb_product.pro_show',1)
				->where('tb_product.id', $proId)
				->firstOrFail();

				$p_subtotal = $product->price * $product->quantity;

				// VAT
				if(!empty($typeSetting) && $typeSetting->show == 1){
					$p_totalVat = ($p_subtotal * $check->type_vat) / 100;
				}else{
					$p_totalVat = 0;
				}

				// WHT
				if($canWht && (float)$check->type_withholding != 0){
					$p_totalWithholding = ($p_subtotal * $check->type_withholding) / 100;
				}else{
					$p_totalWithholding = 0;
				}

				$p_total = ($p_subtotal + $p_totalVat) - $p_totalWithholding;

				$setData[] = [
					'id'                => $product->id,
					'vat'               => $check->type_vat,
					'withholding'       => $check->type_withholding,
					'subtotal'          => $p_subtotal,
					'totalVat'          => $p_totalVat,
					'totalWithholding'  => $p_totalWithholding,
					'total'             => $p_total,
				];
			}

			foreach($setData as $get){
				$subtotal           += $get['subtotal'];
				$totalVat           += $get['totalVat'];
				$totalWithholding   += $get['totalWithholding'];
				$totalPrice         += $get['total'];
			}

			$nettotal = $subtotal + $totalVat;
			$total    = $totalPrice;

			return [
				'subtotal'      => $subtotal,
				'totaldiscount' => $subtotal,
				'vat'           => $totalVat,
				'nettotal'      => $nettotal,
				'withholding'   => $totalWithholding,
				'total'         => $total,
			];
		}

		// ------------------------------
		// CASE B: มีคูปอง (cart conditions)
		// ------------------------------

		$setData = [];

		foreach($data as $product){

			// ดึง tb_product.id จาก rowId เช่น "123_SW-xxx_00_PRO"
			$proId = (int) explode('_', (string)$product->id)[0];

			$check = TbProduct::select(
				'tb_product.id','tb_product.pro_name','tb_product.pro_catId',
				'tb_category.id','tb_category.category_type',
				'tb_type.id','tb_type.type_vat','tb_type.type_withholding'
			)
			->leftjoin('tb_category','tb_category.id','tb_product.pro_catId')
			->leftjoin('tb_type','tb_type.id','tb_category.category_type')
			->where('tb_product.pro_show',1)
			->where('tb_product.id', $proId)
			->firstOrFail();

			$p_subtotal = $product->price * $product->quantity;

			// (เดิม) VAT ต่อชิ้นยังคงไว้ แต่สุดท้ายคุณคิด vat ใหม่แบบรวมทั้งบิลอยู่แล้ว
			if(!empty($typeSetting) && $typeSetting->show == 1){
				$p_totalVat = ($p_subtotal * $check->type_vat) / 100;
			}else{
				$p_totalVat = 0;
			}

			// WHT ต่อชิ้น (ยังไม่หักส่วนลดในขั้นนี้)
			if($canWht && (float)$check->type_withholding != 0){
				$p_totalWithholding = ($p_subtotal * $check->type_withholding) / 100;
			}else{
				$p_totalWithholding = 0;
			}

			$p_total = ($p_subtotal + $p_totalVat) - $p_totalWithholding;

			$setData[] = [
				'id'                => $product->id,
				'withholding'       => $check->type_withholding,
				'subtotal'          => $p_subtotal,
				'totalVat'          => $p_totalVat,
				'totalWithholding'  => $p_totalWithholding,
				'total'             => $p_total,
			];
		}

		// ดึงคูปอง (ในระบบคุณเหมือนใช้ตัวเดียว)
		$conditiontype = 1;
		$conditiontotal = 0;
		foreach($dataCondition as $condition){
			$conditiontype = $condition->getType();
			$conditiontotal = $condition->getValue();
		}

		// รวมราคาสินค้าก่อนส่วนลด
		foreach($setData as $get){
			$subtotal_discount += $get['subtotal'];
		}

		// คิดส่วนลด
		if($conditiontype == 1){
			$conditionPrice = (float)$conditiontotal;
		}else{
			$conditionPrice = ($subtotal_discount * (float)$conditiontotal) / 100;
		}

		// ราคารวมหลังหักส่วนลด (ก่อน VAT/WHT)
		$nettotal_before_tax = $subtotal_discount - $conditionPrice;
		if ($nettotal_before_tax < 0) $nettotal_before_tax = 0;

		// VAT (ของเดิมคุณใช้ $typeSetting->vat แบบรวมทั้งบิล)
		if(!empty($typeSetting) && $typeSetting->show == 1){
			$totalVat = ($nettotal_before_tax * (float)$typeSetting->vat) / 100;
		}else{
			$totalVat = 0;
		}

		// ✅ ปรับ WHT ตามสัดส่วนส่วนลด (กันคิดจากยอดก่อนลด)
		// ratio = ยอดหลังลด / ยอดก่อนลด
		$ratio = ($subtotal_discount > 0) ? ($nettotal_before_tax / $subtotal_discount) : 0;

		$rawWithholding = 0;
		foreach($setData as $get2){
			$subtotal += $get2['subtotal'];
			$rawWithholding += $get2['totalWithholding'];
		}

		$totalWithholding = $rawWithholding * $ratio;

		// ยอดสุทธิ (คุณโชว์ nettotal เป็นรวม VAT แล้ว)
		$nettotal = $nettotal_before_tax + $totalVat;

		// ยอดที่ต้องชำระ = (หลังลด + VAT) - WHT
		$total = $nettotal - $totalWithholding;

		return [
			'subtotal'      => $subtotal,
			'totaldiscount' => $subtotal,
			'vat'           => $totalVat,
			'nettotal'      => $nettotal,
			'withholding'   => $totalWithholding,
			'total'         => $total,
		];
	}


    private function compareDate($date1,$date2) {
        $arrDate1 = explode("-",$date1);
        $arrDate2 = explode("-",$date2);
        $timStmp1 = mktime(0,0,0,$arrDate1[1],$arrDate1[2],$arrDate1[0]);
        $timStmp2 = mktime(0,0,0,$arrDate2[1],$arrDate2[2],$arrDate2[0]);

        if ($timStmp1 == $timStmp2) {
            return 1;
        } else if ($timStmp1 > $timStmp2) {
            return 0;
        } else if ($timStmp1 < $timStmp2) {
            return 2;
        }
    }
	
	public function ajaxValidateCoupon(): JsonResponse
    {
        $msgs = [
            1 => 'คุณมีคูปองนี้ในระบบแล้ว.',
            2 => 'คูปองนี้หมดอายุแล้ว ไม่สามารถใช้งานได้.',
            3 => 'คูปองนี้ไม่สามารถใช้งานได้ เนื่องจากมีผู้ใช้ครบจำนวนที่กำหนดไว้แล้ว.',
            4 => 'ไม่สามารถใช้คูปองได้ เนื่องจากมีการใช้ครบตามจำนวนที่กำหนดแล้ว.',
            5 => 'ไม่สามารถใช้คูปองได้ เนื่องจากราคาสินค้าน้อยกว่าที่กำหนด.',
            6 => 'ไม่สามารถใช้คูปองได้ เนื่องจากราคาสินค้ามากกว่าที่กำหนด.',
            7 => 'ไม่สามารถใช้คูปองได้ เนื่องจากสินค้าไม่ได้เข้าร่วมกับส่วนลดนี้.',
            8 => 'ไม่สามารถใช้คูปองได้ เนื่องจากสินค้าในหมวดหมู่ไม่ได้เข้าร่วมกับส่วนลดนี้.',
            9 => 'ไม่สามารถใช้คูปองได้ เนื่องจากยังไม่มีสินค้าในตะกร้าสินค้า.',
            10=> 'ไม่สามารถใช้คูปองได้ เนื่องจากคูปองนี่ไม่สามารถใช้ร่วมกับสินค้าลดราคาได้.',
        ];

        $couponCtrl    = app(CouponController::class);
        $dataCondition = \Cart::getConditions();
        foreach ($dataCondition as $condition) {
            $invalid = $couponCtrl->validateCouponForCart($condition->getName());
            if ($invalid !== 0) {
                \Cart::clearCartConditions();
                return response()->json([
                    'invalid' => $invalid,
                    'msg'     => $msgs[$invalid] ?? 'คูปองไม่ถูกต้อง.'
                ]);
            }
        }

        return response()->json(['invalid' => 0]);
    }	

}
