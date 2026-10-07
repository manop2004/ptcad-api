<?php

namespace App\Http\Controllers\Shopping;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

use OmiseCharge;



use App\Models\TbSetting;
use App\Models\TbSettingPayment;
use App\Models\TbSettingProvince;
use App\Models\TbOrder;
use App\Models\TbOrderDetail;
use App\Models\TbOrderPayment;
use App\Models\UsersCoupon;
use App\Models\HistoryOrderStatus;
use App\Models\TbPaymentBank;
use App\Models\HistorySendMail;
use App\Models\User;
use App\Models\TbPagesMap;
use App\Models\TbProduct;
use App\Models\TbProductDetail;
use App\Models\TbTypeSetting;

use App\Mail\orderNotify;
use App\Mail\orderToStaff;


class PaymentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    private function omisePublicKey(){

        //1 ปิดใช้งาน
        //2 เปิดใช้งาน
        //3 ทดสอบการใช้งาน

        $omise = TbSettingPayment::first();
        if($omise->omise_status == 3){
            $public_key_omise = $omise->omise_public_key_for_test;
        }else{
            $public_key_omise = $omise->omise_public_key_for_live;
        }

        return define('OMISE_PUBLIC_KEY', $public_key_omise);
    }

    private function omiseSecretKey(){

        //1 ปิดใช้งาน
        //2 เปิดใช้งาน
        //3 ทดสอบการใช้งาน

        $omise = TbSettingPayment::first();
        if($omise->omise_status == 3){
            $secret_key_omise = $omise->omise_secret_key_for_test;
        }else{
            $secret_key_omise = $omise->omise_secret_key_for_live;
        }

        return define('OMISE_SECRET_KEY', $secret_key_omise);
    }
    public function stripeCheckout($id)
    {
        $order = TbOrder::with('tb_order_details')->findOrFail($id);
        return $this->createStripeCheckoutRedirect($order, ['card']);
    }

    /**
     * สร้าง Stripe Checkout Session แล้ว redirect ไปหน้าจ่ายเงินของ Stripe
     * ใช้ร่วมกันทั้งจากปุ่มในหน้า "แจ้งชำระเงิน" (โอนเงิน) และหน้า "ยืนยันคำสั่งซื้อ" หลัก
     *
     * @param TbOrder $order
     * @param array $paymentMethodTypes เช่น ['card'] หรือ ['promptpay']
     */
    private function createStripeCheckoutRedirect(TbOrder $order, array $paymentMethodTypes)
    {
        $amountInSatang = (int) round($order->totalCart * 100);

        $response = Http::asForm()
            ->withToken(env('STRIPE_SECRET_KEY'))
            ->post('https://api.stripe.com/v1/checkout/sessions', [
                'payment_method_types' => $paymentMethodTypes,
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => 'thb',
                            'product_data' => [
                                'name' => 'คำสั่งซื้อ ' . $order->orderNumber,
                            ],
                            'unit_amount' => $amountInSatang,
                        ],
                        'quantity' => 1,
                    ],
                ],
                'mode' => 'payment',
                'success_url' => route('fronend.cart.payment.stripe.success', $order->id),
                'cancel_url' => route('fronend.cart.payment.stripe.cancel', $order->id),
                'metadata' => [
                    'orderId' => $order->id,
                    'orderNumber' => $order->orderNumber,
                ],
            ]);

        if ($response->failed()) {
            \Log::error('Stripe checkout session creation failed', [
                'response' => $response->body(),
                'orderId' => $order->id,
                'payment_method_types' => $paymentMethodTypes,
            ]);
            return redirect()->route('fronend.cart.payment', $order->id)
                ->with('stripe_error', 'ไม่สามารถเชื่อมต่อ Stripe ได้ กรุณาลองใหม่ หรือใช้วิธีโอนเงินแทนไปก่อน');
        }

        $session = $response->json();

        return redirect($session['url']);
    }

public function stripeSuccess($id)
{
    return redirect()->route('fronend.cart.payment.notify', $id)
        ->with('stripe_message', 'กำลังตรวจสอบผลการชำระเงิน กรุณารอสักครู่แล้วรีเฟรชหน้านี้');
}

public function stripeCancel($id)
{
    return redirect()->route('fronend.cart.payment', $id)
        ->with('stripe_cancelled', 'คุณยกเลิกการชำระเงินผ่านบัตรเครดิต');
}

    public function orderConfirmCrate(Request $request)
	{
		$ck_cart = $this->checkCart_Product();
		if ($ck_cart == 0) {
			return redirect()->route('fronend.cart');
		}

		// -----------------------------
		// Validate
		// -----------------------------
		if ($request->chkReceipt == 'on') {
			$request->validate(
				[
					'residence_name' => 'required|max:255|regex:/^[A-Za-z\s\.\'\-]+$/',
					'residence_lastname' => 'required|max:255|regex:/^[A-Za-z\s\.\'\-]+$/',
					'residence_tel' => 'required|max:255',
					'residence_address' => 'required|regex:/^[A-Za-z0-9\s\.,\/\-#]+$/',
					'province' => 'required',
					'amphures' => 'required',
					'district' => 'required',
					'zipcode' => 'required',

					'receipt_tax' => 'required|max:255',
					'receipt_company' => 'max:255',
					'receipt_name' => 'required|max:255',
					'receipt_lastname' => 'required|max:255',
					'receipt_tel' => 'required|max:255',
					'receipt_address' => 'required',
					'receipt_province' => 'required',
					'receipt_amphures' => 'required',
					'receipt_district' => 'required',
					'receipt_zipcode' => 'required',

					// optional but recommended
					'receipt_persona_type' => 'nullable|in:1,2',  // 1=บุคคล, 2=บริษัท
					'withholding_apply' => 'nullable|in:0,1',     // 1=หัก, 0=ไม่หัก
				],
				[
					'residence_name.required' => 'กรุณากรอกชื่อสำหรับจัดส่งสินค้า',
					'residence_name.max' => 'กรุณากรอกชื่อสำหรับจัดส่งสินค้าไม่เกิน 255 ตัวอักษร',
					'residence_name.regex' => 'ชื่อสำหรับจัดส่งสินค้าต้องเป็นภาษาอังกฤษเท่านั้น',
					'residence_lastname.required' => 'กรุณากรอกนามสกุลสำหรับจัดส่งสินค้า',
					'residence_lastname.max' => 'กรุณากรอกนามสกุลสำหรับจัดส่งสินค้าไม่เกิน 255 ตัวอักษร',
					'residence_lastname.regex' => 'นามสกุลสำหรับจัดส่งสินค้าต้องเป็นภาษาอังกฤษเท่านั้น',
					'residence_tel.required' => 'กรุณากรอกเบอร์โทรศัพท์สำหรับจัดส่งสินค้า',
					'residence_tel.max' => 'กรุณากรอกเบอร์โทรศัพท์สำหรับจัดส่งสินค้าไม่เกิน 255 ตัวอักษร',
					'residence_address.required' => 'กรุณากรอกที่อยู่สำหรับจัดส่งสินค้า',
					'residence_address.regex' => 'ที่อยู่สำหรับจัดส่งสินค้าต้องเป็นภาษาอังกฤษเท่านั้น (ตัวอักษร A-Z, ตัวเลข, และเครื่องหมาย , . / - # เท่านั้น)',
					'province.required' => 'กรุณาเลือกจังหวัดสำหรับจัดส่งสินค้า',
					'amphures.required' => 'กรุณาเลือกอำเภอสำหรับจัดส่งสินค้า',
					'district.required' => 'กรุณาเลือกตำบลสำหรับจัดส่งสินค้า',
					'zipcode.required' => 'กรุณากรอกรหัสไปรษณีย์สำหรับจัดส่งสินค้า',

					'receipt_tax.required' => 'กรุณากรอกเลขประจำตัวผู้เสียภาษีสำหรับจัดส่งใบเสร็จรับเงิน',
					'receipt_tax.max' => 'กรุณากรอกเลขประจำตัวผู้เสียภาษีสำหรับจัดส่งใบเสร็จรับเงินไม่เกิน 255 ตัวอักษร',
					'receipt_company.max' => 'กรุณากรอกชื่อบริษัทสำหรับจัดส่งใบเสร็จรับเงินไม่เกิน 255 ตัวอักษร',
					'receipt_name.required' => 'กรุณากรอกชื่อสำหรับจัดส่งใบเสร็จรับเงิน',
					'receipt_name.max' => 'กรุณากรอกชื่อสำหรับจัดส่งใบเสร็จรับเงินไม่เกิน 255 ตัวอักษร',
					'receipt_lastname.required' => 'กรุณากรอกนามสกุลสำหรับจัดส่งใบเสร็จรับเงิน',
					'receipt_lastname.max' => 'กรุณากรอกนามสกุลสำหรับจัดส่งใบเสร็จรับเงินไม่เกิน 255 ตัวอักษร',
					'receipt_tel.required' => 'กรุณากรอกเบอร์โทรศัพท์สำหรับจัดส่งใบเสร็จรับเงิน',
					'receipt_tel.max' => 'กรุณากรอกเบอร์โทรศัพท์สำหรับจัดส่งใบเสร็จรับเงินไม่เกิน 255 ตัวอักษร',
					'receipt_address.required' => 'กรุณากรอกที่อยู่สำหรับจัดส่งใบเสร็จรับเงิน',
					'receipt_province.required' => 'กรุณาเลือกจังหวัดสำหรับจัดส่งใบเสร็จรับเงิน',
					'receipt_amphures.required' => 'กรุณาเลือกอำเภอสำหรับจัดส่งใบเสร็จรับเงิน',
					'receipt_district.required' => 'กรุณาเลือกตำบลสำหรับจัดส่งใบเสร็จรับเงิน',
					'receipt_zipcode.required' => 'กรุณากรอกรหัสไปรษณีย์สำหรับจัดส่งใบเสร็จรับเงิน',
				]
			);
		} else {
			$request->validate(
				[
					'residence_name' => 'required|max:255|regex:/^[A-Za-z\s\.\'\-]+$/',
					'residence_lastname' => 'required|max:255|regex:/^[A-Za-z\s\.\'\-]+$/',
					'residence_tel' => 'required|max:255',
					'residence_address' => 'required|regex:/^[A-Za-z0-9\s\.,\/\-#]+$/',
					'province' => 'required',
					'amphures' => 'required',
					'district' => 'required',
					'zipcode' => 'required',
				],
				[
					'residence_name.required' => 'กรุณากรอกชื่อสำหรับจัดส่งสินค้า',
					'residence_name.max' => 'กรุณากรอกชื่อสำหรับจัดส่งสินค้าไม่เกิน 255 ตัวอักษร',
					'residence_name.regex' => 'ชื่อสำหรับจัดส่งสินค้าต้องเป็นภาษาอังกฤษเท่านั้น',
					'residence_lastname.required' => 'กรุณากรอกนามสกุลสำหรับจัดส่งสินค้า',
					'residence_lastname.max' => 'กรุณากรอกนามสกุลสำหรับจัดส่งสินค้าไม่เกิน 255 ตัวอักษร',
					'residence_lastname.regex' => 'นามสกุลสำหรับจัดส่งสินค้าต้องเป็นภาษาอังกฤษเท่านั้น',
					'residence_tel.required' => 'กรุณากรอกเบอร์โทรศัพท์สำหรับจัดส่งสินค้า',
					'residence_tel.max' => 'กรุณากรอกเบอร์โทรศัพท์สำหรับจัดส่งสินค้าไม่เกิน 255 ตัวอักษร',
					'residence_address.required' => 'กรุณากรอกที่อยู่สำหรับจัดส่งสินค้า',
					'residence_address.regex' => 'ที่อยู่สำหรับจัดส่งสินค้าต้องเป็นภาษาอังกฤษเท่านั้น (ตัวอักษร A-Z, ตัวเลข, และเครื่องหมาย , . / - # เท่านั้น)',
					'province.required' => 'กรุณาเลือกจังหวัดสำหรับจัดส่งสินค้า',
					'amphures.required' => 'กรุณาเลือกอำเภอสำหรับจัดส่งสินค้า',
					'district.required' => 'กรุณาเลือกตำบลสำหรับจัดส่งสินค้า',
					'zipcode.required' => 'กรุณากรอกรหัสไปรษณีย์สำหรับจัดส่งสินค้า',
				]
			);
		}

		// -----------------------------
		// WHT decision + totals (SERVER-SIDE)
		// -----------------------------
		$personaType = (int) ($request->receipt_persona_type ?? 1); // 1=บุคคล, 2=บริษัท
		$applyWht = ($request->withholding_apply === '1');

		$whtEnabled = ($request->chkReceipt === 'on') && ($personaType === 2) && $applyWht;

		// คำนวณยอดจากตะกร้าจริง (ไม่เชื่อ hidden input)
		$totals = $this->calcTotalsFromCart($whtEnabled, $personaType);

		// -----------------------------
		// Create order
		// -----------------------------
		$orderNumber = $this->generateOrderNumber();

		$data = new TbOrder();
		$data->staffOf = $this->check_staff_IN_user();
		$data->staff_updated_by = 'SYSTEM';
		$data->staff_updated_at = date('Y-m-d H:i:s');
		$data->userCode = Auth::user()->user_code;
		$data->orderNumber = 'ORD-' . $orderNumber;

		$data->residence_name = $request->residence_name;
		$data->residence_lastname = $request->residence_lastname;
		$data->residence_tel = $request->residence_tel;
		$data->residence_address = $request->residence_address;
		$data->residence_province = $request->province;
		$data->residence_amphures = $request->amphures;
		$data->residence_district = $request->district;
		$data->residence_zipcode = $request->zipcode;
		$data->residence_massage = $request->residence_massage;
		$data->ref = $request->ref;

		// statusReceipts
		$data->statusReceipts = ($request->chkReceipt == 'on') ? 1 : 2;

		// receipt info
		if ($request->chkReceipt == 'on') {
			// ✅ สำคัญ: เดิมคุณใช้ $request->receipt_type แต่ฟอร์มจริงเป็น receipt_persona_type
			$data->receipt_type = $personaType;

			$data->receipt_tax = $request->receipt_tax;
			$data->receipt_company = $request->receipt_company;
			$data->receipt_branch = $request->receipt_branch;
			$data->receipt_name = $request->receipt_name;
			$data->receipt_lastname = $request->receipt_lastname;
			$data->receipt_tel = $request->receipt_tel;
			$data->receipt_address = $request->receipt_address;
			$data->receipt_province = $request->receipt_province;
			$data->receipt_amphures = $request->receipt_amphures;
			$data->receipt_district = $request->receipt_district;
			$data->receipt_zipcode = $request->receipt_zipcode;
		}

		// -----------------------------
		// Save totals (fix empty(0) bug)
		// -----------------------------
		$data->subtotal = (float) ($totals['subtotal'] ?? 0);
		$data->priceVAT = (float) ($totals['vat'] ?? 0);
		$data->priceWithholding = (float) ($totals['withholding'] ?? 0); // ✅ 0 ก็เซฟ
		$data->priceNettotal = (float) ($totals['nettotal'] ?? 0);
		$data->totalCart = (float) ($totals['total'] ?? 0);

		// coupon conditions (ยังใช้จาก request ได้)
		if (!empty($request->conditionType)) {
			$data->conditionType = $request->conditionType;
		}
		if (!empty($request->conditionName)) {
			$data->conditionName = $request->conditionName;
		}
		if (!empty($request->conditionValue)) {
			$data->conditionValue = $request->conditionValue;
		}

		// totaldiscount: ใช้ค่าคำนวณฝั่ง server ก่อน ถ้าอยากให้ตรงระบบเดิม
		$data->totaldiscount = (float) ($totals['totaldiscount'] ?? 0);

		// ✅ ฟิลด์ใหม่: wht_request
		// ถ้าหัก ณ ที่จ่าย = 1, ถ้าไม่หัก = 0 (ถ้าคุณต้องการ NULL เปลี่ยน 0 เป็น null ได้)
		$data->wht_request = $whtEnabled ? 1 : 0;

		$data->payment_type = $request->radio_payment_type;
		$data->payment_status = 1;
		$data->payment_massage = null;
		$data->created_at = date('Y-m-d H:i:s');
		$data->updated_at = date('Y-m-d H:i:s');
		$data->save();

		// -----------------------------
		// Save order details + stock
		// -----------------------------
		$products = \Cart::getContent();
		foreach ($products as $product) {

			$detail = new TbOrderDetail;
			$detail->orderId = $data->id;
			$detail->product_sku = $product->attributes->sku;

			// ✅ เพิ่ม: ดึง vendor_sku จาก tb_product_detail
			$product_detail = TbProductDetail::where('detail_sku', $detail->product_sku)->first();
			if (!empty($product_detail)) {
				$detail->vendor_sku = $product_detail->vendor_sku;
			}

			if ($product->attributes->detail_name != 'null') {
				$detail->product_name = $product->name . ' (' . $product->attributes->detail_name . ')';
			} else {
				$detail->product_name = $product->name;
			}

			$detail->product_detail = $product->attributes->detail_other;
			$detail->product_img = $product->attributes->image;
			$detail->product_price = $product->price;

			if ($product->attributes->pricesale != 0) {
				$detail->product_price_sale = $product->attributes->price;
			} else {
				$detail->product_price_sale = null;
			}

			$detail->product_unit = $product->quantity;
			$detail->product_price_total = $product->price * $product->quantity;

			if ($product->ref != '') {
				$ref = $product->ref;
				$ref = str_replace('?ref=', '', $ref);
				$ref = str_replace('?', '', $ref);
				$ref = str_replace('&', '', $ref);
				$ref = str_replace('ref=', '', $ref);

				$detail->ref = $ref;
			} else {
				$detail->ref = null;
			}

			$detail->save();

			// ใช้ตัวเดิมที่ query มาแล้วต่อเลย
			if (!empty($product_detail)) {
				if ($product_detail->detail_check_stock_status == 1) {
					$old_stock = $product_detail->detail_stock;
					$now_stock = ($old_stock - $detail->product_unit);

					$product_detail->detail_stock = $now_stock;
					if ($now_stock < 1) {
						$product_detail->detail_status = 2;
					}
					$product_detail->updated_at = date('Y-m-d H:i:s');
					$product_detail->save();
				}
			}
		}

		// ถ้ามีการใช้คูปองให้ไปอัพเดตจำนวนการใช้งานด้วย
		$userCoupon = UsersCoupon::where('coupon_code', $data->conditionName)
			->where('userId', Auth::user()->id)
			->first();

		if (!empty($userCoupon)) {
			$updateCoupon = UsersCoupon::where('coupon_code', $data->conditionName)
				->where('userId', Auth::user()->id)
				->first();

			$updateCoupon->coupon_use = $userCoupon->coupon_use + 1;
			$updateCoupon->updated_by = Auth::user()->displayname;
			$updateCoupon->updated_at = date('Y-m-d H:i:s');
			$updateCoupon->save();
		}

		$history = new HistoryOrderStatus();
		$history->orderNumber = $data->orderNumber;
		$history->order_status = 'รอการชำระเงิน';
		$history->order_message = null;
		$history->updated_by = Auth::user()->displayname;
		$history->updated_at = date('Y-m-d H:i:s');
		$history->created_by = Auth::user()->displayname;
		$history->created_at = date('Y-m-d H:i:s');
		$history->save();

		\Cart::clear();
		\Cart::clearCartConditions();
		

		// -----------------------------
		// Redirect by payment type
		// -----------------------------
		if ($request->radio_payment_type == 1) {
			// โอนผ่านบัญชีธนาคาร
			return redirect()->route('fronend.cart.payment', $data->id);

		} elseif ($request->radio_payment_type == 3) {
			// บัตรเครดิต — ผ่าน Stripe
			return $this->createStripeCheckoutRedirect($data, ['card']);

		} elseif ($request->radio_payment_type == 4) {
			// พร้อมเพย์ — ผ่าน Stripe
			return $this->createStripeCheckoutRedirect($data, ['promptpay']);

		} else {
			// [ปิดใช้ชั่วคราว] ผ่อนชำระ/โมบายแบงก์กิ้ง/ทรูมันนี่ ถูกซ่อนไว้ในหน้าเว็บแล้ว
			// เผื่อมีการยิง request แปลกๆ เข้ามาตรงๆ ให้กลับไปหน้าโอนเงินแทน ไม่ปล่อยผ่านเงียบๆ
			return redirect()->route('fronend.cart.payment', $data->id);
		}
    }

    public function orderConfirmUpdate(Request $request,$id){

        if(empty($id)){
            return redirect()->route('fronend.account.order');
        }else{

            if($request->chkReceipt == 'on'){
                $request->validate(
                    [
                        'residence_name' => 'required|max:255|regex:/^[A-Za-z\s\.\'\-]+$/',
                        'residence_lastname' => 'required|max:255|regex:/^[A-Za-z\s\.\'\-]+$/',
                        'residence_tel' => 'required|max:255',
                        'residence_address' => 'required|regex:/^[A-Za-z0-9\s\.,\/\-#]+$/',
                        'province' => 'required',
                        'amphures' => 'required',
                        'district' => 'required',
                        'zipcode' => 'required',
                        'receipt_tax' => 'required|max:255',
                        'receipt_company' => 'max:255',
                        'receipt_name' => 'required|max:255',
                        'receipt_lastname' => 'required|max:255',
                        'receipt_tel' => 'required|max:255',
                        'receipt_address' => 'required',
                        'receipt_province' => 'required',
                        'receipt_amphures' => 'required',
                        'receipt_district' => 'required',
                        'receipt_zipcode' => 'required',
                    ],
                    [
                        'residence_name.required' => 'กรุณากรอกชื่อสำหรับจัดส่งสินค้า',
                        'residence_name.max' => 'กรุณากรอกชื่อสำหรับจัดส่งสินค้าไม่เกิน 255 ตัวอักษร',
                        'residence_name.regex' => 'ชื่อสำหรับจัดส่งสินค้าต้องเป็นภาษาอังกฤษเท่านั้น',
                        'residence_lastname.required' => 'กรุณากรอกนามสกุลสำหรับจัดส่งสินค้า',
                        'residence_lastname.max' => 'กรุณากรอกนามสกุลสำหรับจัดส่งสินค้าไม่เกิน 255 ตัวอักษร',
                        'residence_lastname.regex' => 'นามสกุลสำหรับจัดส่งสินค้าต้องเป็นภาษาอังกฤษเท่านั้น',
                        'residence_tel.required' => 'กรุณากรอกเบอร์โทรศัพท์สำหรับจัดส่งสินค้า',
                        'residence_tel.max' => 'กรุณากรอกเบอร์โทรศัพท์สำหรับจัดส่งสินค้าไม่เกิน 255 ตัวอักษร',
                        'residence_address.required' => 'กรุณากรอกที่อยู่สำหรับจัดส่งสินค้า',
                        'residence_address.regex' => 'ที่อยู่สำหรับจัดส่งสินค้าต้องเป็นภาษาอังกฤษเท่านั้น (ตัวอักษร A-Z, ตัวเลข, และเครื่องหมาย , . / - # เท่านั้น)',
                        'province.required' => 'กรุณาเลือกจังหวัดสำหรับจัดส่งสินค้า',
                        'amphures.required' => 'กรุณาเลือกอำเภอสำหรับจัดส่งสินค้า',
                        'district.required' => 'กรุณาเลือกตำบลสำหรับจัดส่งสินค้า',
                        'zipcode.required' => 'กรุณากรอกรหัสไปรษณีย์สำหรับจัดส่งสินค้า',
                        'receipt_tax.required' => 'กรุณากรอกเลขประจำตัวผู้เสียภาษีสำหรับจัดส่งใบเสร็จรับเงิน',
                        'receipt_tax.max' => 'กรุณากรอกเลขประจำตัวผู้เสียภาษีสำหรับจัดส่งใบเสร็จรับเงินไม่เกิน 255 ตัวอักษร',
                        'receipt_company.max' => 'กรุณากรอกชื่อบริษัทสำหรับจัดส่งใบเสร็จรับเงินไม่เกิน 255 ตัวอักษร',
                        'receipt_name.required' => 'กรุณากรอกชื่อสำหรับจัดส่งใบเสร็จรับเงิน',
                        'receipt_name.max' => 'กรุณากรอกชื่อสำหรับจัดส่งใบเสร็จรับเงินไม่เกิน 255 ตัวอักษร',
                        'receipt_lastname.required' => 'กรุณากรอกนามสกุลสำหรับจัดส่งใบเสร็จรับเงิน',
                        'receipt_lastname.max' => 'กรุณากรอกนามสกุลสำหรับจัดส่งใบเสร็จรับเงินไม่เกิน 255 ตัวอักษร',
                        'receipt_tel.required' => 'กรุณากรอกเบอร์โทรศัพท์สำหรับจัดส่งใบเสร็จรับเงิน',
                        'receipt_tel.max' => 'กรุณากรอกเบอร์โทรศัพท์สำหรับจัดส่งใบเสร็จรับเงินไม่เกิน 255 ตัวอักษร',
                        'receipt_address.required' => 'กรุณากรอกที่อยู่สำหรับจัดส่งใบเสร็จรับเงิน',
                        'receipt_province.required' => 'กรุณาเลือกจังหวัดสำหรับจัดส่งใบเสร็จรับเงิน',
                        'receipt_amphures.required' => 'กรุณาเลือกอำเภอสำหรับจัดส่งใบเสร็จรับเงิน',
                        'receipt_district.required' => 'กรุณาเลือกตำบลสำหรับจัดส่งใบเสร็จรับเงิน',
                        'receipt_zipcode.required' => 'กรุณากรอกรหัสไปรษณีย์สำหรับจัดส่งใบเสร็จรับเงิน',
                    ]
                );
            }else{
                $request->validate(
                    [
                        'residence_name' => 'required|max:255|regex:/^[A-Za-z\s\.\'\-]+$/',
                        'residence_lastname' => 'required|max:255|regex:/^[A-Za-z\s\.\'\-]+$/',
                        'residence_tel' => 'required|max:255',
                        'residence_address' => 'required|regex:/^[A-Za-z0-9\s\.,\/\-#]+$/',
                        'province' => 'required',
                        'amphures' => 'required',
                        'district' => 'required',
                        'zipcode' => 'required',
                    ],
                    [
                        'residence_name.required' => 'กรุณากรอกชื่อสำหรับจัดส่งสินค้า',
                        'residence_name.max' => 'กรุณากรอกชื่อสำหรับจัดส่งสินค้าไม่เกิน 255 ตัวอักษร',
                        'residence_name.regex' => 'ชื่อสำหรับจัดส่งสินค้าต้องเป็นภาษาอังกฤษเท่านั้น',
                        'residence_lastname.required' => 'กรุณากรอกนามสกุลสำหรับจัดส่งสินค้า',
                        'residence_lastname.max' => 'กรุณากรอกนามสกุลสำหรับจัดส่งสินค้าไม่เกิน 255 ตัวอักษร',
                        'residence_lastname.regex' => 'นามสกุลสำหรับจัดส่งสินค้าต้องเป็นภาษาอังกฤษเท่านั้น',
                        'residence_tel.required' => 'กรุณากรอกเบอร์โทรศัพท์สำหรับจัดส่งสินค้า',
                        'residence_tel.max' => 'กรุณากรอกเบอร์โทรศัพท์สำหรับจัดส่งสินค้าไม่เกิน 255 ตัวอักษร',
                        'residence_address.required' => 'กรุณากรอกที่อยู่สำหรับจัดส่งสินค้า',
                        'residence_address.regex' => 'ที่อยู่สำหรับจัดส่งสินค้าต้องเป็นภาษาอังกฤษเท่านั้น (ตัวอักษร A-Z, ตัวเลข, และเครื่องหมาย , . / - # เท่านั้น)',
                        'province.required' => 'กรุณาเลือกจังหวัดสำหรับจัดส่งสินค้า',
                        'amphures.required' => 'กรุณาเลือกอำเภอสำหรับจัดส่งสินค้า',
                        'district.required' => 'กรุณาเลือกตำบลสำหรับจัดส่งสินค้า',
                        'zipcode.required' => 'กรุณากรอกรหัสไปรษณีย์สำหรับจัดส่งสินค้า',
                    ]
                );
            }

            $data                           = TbOrder::findOrFail($id);
            $data->staffOf	                = $this->check_staff_IN_user();
            $data->staff_updated_by	        = 'SYSTEM';
            $data->staff_updated_at	        = date('Y-m-d H:i:s');
            $data->residence_name           = $request->residence_name;
            $data->residence_lastname       = $request->residence_lastname;
            $data->residence_tel            = $request->residence_tel;
            $data->residence_address        = $request->residence_address;
            $data->residence_province       = $request->province;
            $data->residence_amphures       = $request->amphures;
            $data->residence_district       = $request->district;
            $data->residence_zipcode        = $request->zipcode;
            $data->residence_massage        = $request->residence_massage;
            //add status ว่าต้องการใบเสร็จรับเงินไหม
            if($request->chkReceipt == 'on'){
                $data->statusReceipts       = 1;
            }else{
                $data->statusReceipts       = 2;
            }
            if($request->chkReceipt == 'on'){
                $data->receipt_type         = $request->receipt_type;
                $data->receipt_tax          = $request->receipt_tax;
                $data->receipt_company      = $request->receipt_company;
                $data->receipt_branch       = $request->receipt_branch;
                $data->receipt_name         = $request->receipt_name;
                $data->receipt_lastname     = $request->receipt_lastname;
                $data->receipt_tel          = $request->receipt_tel;
                $data->receipt_address      = $request->receipt_address;
                $data->receipt_province     = $request->receipt_province;
                $data->receipt_amphures     = $request->receipt_amphures;
                $data->receipt_district     = $request->receipt_district;
                $data->receipt_zipcode      = $request->receipt_zipcode;
            }
            $data->payment_type             = $request->radio_payment_type;
            $data->payment_status           = 1;
            $data->payment_massage          = null;
            $data->updated_at               = date('Y-m-d H:i:s');
            $data->save();

            $history = new HistoryOrderStatus();
            $history->orderNumber           = $data->orderNumber;
            $history->order_status          = 'แจ้งชำระเงินใหม่อีกครั้ง';
            $history->order_message         = null;
            $history->updated_by            = Auth::user()->displayname;
            $history->updated_at            = date('Y-m-d H:i:s');
            $history->created_by            = Auth::user()->displayname;
            $history->created_at            = date('Y-m-d H:i:s');
            $history->save();

            if($request->radio_payment_type == 1){
                //โอนผ่านบัญชีธนาคาร
                return redirect()->route('fronend.cart.payment',$data->id);

            }else if($request->radio_payment_type == 3){
                //บัตรเครดิต — ผ่าน Stripe
                return $this->createStripeCheckoutRedirect($data, ['card']);

            }else if($request->radio_payment_type == 4){
                //พร้อมเพย์ — ผ่าน Stripe
                return $this->createStripeCheckoutRedirect($data, ['promptpay']);

            }else{
                // [ปิดใช้ชั่วคราว] ผ่อนชำระ/โมบายแบงก์กิ้ง/ทรูมันนี่ ถูกซ่อนไว้ในหน้าเว็บแล้ว
                return redirect()->route('fronend.cart.payment', $data->id);
            }
        }
    }

    public function orderPayment($id){

        $setting = TbSetting::first();
        $order = TbOrder::with('tb_order_details')->findOrFail($id);
        $banks = TbPaymentBank::with('tb_setting_bank')->where('bank_show',1)->get();

        $breadcrumb = [
            ['route' => route('fronend.home'), 'name' => 'หน้าหลัก'],
            ['route' => '', 'name' => 'การชำระเงิน'],
        ];

        //title share
        if(!empty($page_name)){ $og_site_name = $page_name; }else{ $og_site_name = "การชำระเงิน";}
        if(!empty($page_name)){ $og_title = $page_name; }else{ $og_title = $og_site_name = "การชำระเงิน";}
        if(!empty($setting->setting_keyword)){ $og_keywords = $setting->setting_keyword; }else{ $og_keywords = "";}
        if(!empty($setting->setting_detail)){ $og_description = $setting->setting_detail; }else{ $og_description = "";}
        if(!empty($setting->setting_coverShare)){ $og_image = asset('storage/setting/'.$setting->setting_coverShare); }else{ $og_image = asset('storage/setting/'.$setting->setting_coverShare);}
        if(!empty($page)){ $og_url = route('fronend.cart'); }else{ $og_url = route('fronend.home');}

        return view('fontend.cart.payment',[
            'breadcrumb' => $breadcrumb,
            'og_site_name' => $og_site_name,
            'og_keywords' => $og_keywords,
            'og_title' => $og_title,
            'og_description' => $og_description,
            'og_url' => $og_url,
            'og_image' => $og_image,
            'page_name' => 'การชำระเงิน',
            'order' => $order,
            'banks' => $banks,
        ]);

    }

    public function orderPaymentConfirm(Request $request){
/*
        $ck_cart = $this->checkCart_Product();
        if($ck_cart == 0){
            return redirect()->back();
        }else{
*/
            $request->validate(
                [
                    'order_id' => 'required|max:255',
                    'order_slip' => 'required',
                    'order_payment_date' => 'required|max:255',
                    'order_payment_time' => 'required|max:255',
                    'order_total' => 'required|max:255',
                    'order_bank' => 'required',
                ],
                [
                    'order_id.required' => 'กรุณากรอกข้อมูล',
                    'order_id.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                    'order_slip.required' => 'กรุณาเลือกไฟล์ภาพสลิปการชำระเงิน',
                    'order_payment_date.required' => 'กรุณากรอกข้อมูล',
                    'order_payment_date.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                    'order_payment_time.required' => 'กรุณากรอกข้อมูล',
                    'order_payment_time.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                    'order_total.required' => 'กรุณากรอกข้อมูล',
                    'order_total.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                    'order_bank.required' => 'กรุณาเลือกบัญชีธนาคาร',
                ]
            );

            $bank = TbPaymentBank::with('tb_setting_bank')->findOrFail($request->order_bank);
            $check_order_id = TbOrderPayment::where('orderId',$request->order_id)->first();

            if(empty($check_order_id)){

                $payment = new TbOrderPayment;
                $payment->orderId                 = $request->order_id;
                $payment->payment_bank            = $bank->bankId;
                $payment->payment_bank_number     = $bank->bank_number;
                $payment->payment_date            = date("Y-m-d",strtotime($request->order_payment_date));
                $payment->payment_time            = $request->order_payment_time;
                $payment->payment_total           = $this->rewrite_price($request->order_total);

                if (!empty($request->order_slip)) {

                    if ($request->hasFile('order_slip')) {
                        $newFilename = uniqid() . '.' . $request->order_slip->extension();
                        $payment->payment_slip = $newFilename;
                        $file = $request->file('order_slip');
                        $file->move('storage/orderSlip/', $newFilename);
                    }

                }

                $payment->created_by              = Auth::user()->displayname;
                $payment->created_at              = date('Y-m-d H:i:s');
                $payment->save();

                $order = TbOrder::findOrFail($request->order_id);
                $order->payment_status          = 2;
                $order->payment_massage         = $bank->tb_setting_bank->bank_name.'<br/>ชื่อบัญชีธนาคาร: '.$bank->bank_name.'<br/>เลขบัญชีธนาคาร: '.$bank->bank_number;
                $order->save();

                $history = new HistoryOrderStatus();
                $history->orderNumber           = $order->orderNumber;
                $history->order_status          = 'แจ้งชำระเงิน';
                $history->order_message         = asset('storage/orderSlip/'.$order->payment_slip);
                $history->updated_by            = Auth::user()->displayname;
                $history->updated_at            = date('Y-m-d H:i:s');
                $history->save();
				

                $this->send_mail_order_Touser($request->order_id);
                $this->send_mail_order_Tostaff($request->order_id);

                return redirect()->route('fronend.cart.payment.notify',$request->order_id);

            }else{

                return redirect()->route('fronend.cart.payment.notify',$request->order_id);

            }
        //}

    }

    public function orderPaymentUpdate($id){

        $this->omisePublicKey();
        $this->omiseSecretKey();

        $order = TbOrder::where('id',$id)->first();

        $charge = OmiseCharge::retrieve($order->chargeId);

        if($charge['status'] == 'successful'){

            $updateOrder                    = TbOrder::findOrFail($id);
            $updateOrder->payment_status    = 2;
            $updateOrder->statusCode        = $charge['statusCode'];
            $updateOrder->payment_massage   = $charge['statusMessage'];
            $updateOrder->save();

            $history = new HistoryOrderStatus();
            $history->orderNumber           = $updateOrder->orderNumber;
            $history->order_status          = 'ชำระเงินสำเร็จ';
            $history->updated_by            = Auth::user()->displayname;
            $history->updated_at            = date('Y-m-d H:i:s');
            $history->save();

        }else if($charge['status'] == 'pending'){

            $updateOrder                    = TbOrder::findOrFail($id);
            $updateOrder->payment_status    = 1;
            $updateOrder->statusCode        = $charge['statusCode'];
            $updateOrder->payment_massage   = $charge['statusMessage'];
            $updateOrder->save();

            $history = new HistoryOrderStatus();
            $history->orderNumber           = $updateOrder->orderNumber;
            $history->order_status          = 'รอการชำระเงิน';
            $history->updated_by            = Auth::user()->displayname;
            $history->updated_at            = date('Y-m-d H:i:s');
            $history->save();

        }else if($charge['status'] == 'failed'){

            $updateOrder                    = TbOrder::findOrFail($id);
            $updateOrder->payment_status    = 4;
            $updateOrder->statusCode        = $charge['failure_code'];
            $updateOrder->payment_massage   = $charge['statusMessage'];;
            $updateOrder->save();

            $history = new HistoryOrderStatus();
            $history->orderNumber           = $updateOrder->orderNumber;
            $history->order_status          = 'ชำระเงินไม่สำเร็จ';
            $history->updated_by            = Auth::user()->displayname;
            $history->updated_at            = date('Y-m-d H:i:s');
            $history->save();

        }

        //send mail
        $this->send_mail_order_Touser($id);
        $this->send_mail_order_Tostaff($id);

        return redirect()->route('fronend.cart.payment.notify', $id);

    }

    public function orderPaymentNotify($id){

        $setting = TbSetting::first();
        $order = TbOrder::with('tb_order_details')->findOrFail($id);

        $breadcrumb = [
            ['route' => route('fronend.home'), 'name' => 'หน้าหลัก'],
            ['route' => '', 'name' => 'การชำระเงิน'],
        ];

        //title share
        if(!empty($page_name)){ $og_site_name = $page_name; }else{ $og_site_name = "การชำระเงิน";}
        if(!empty($page_name)){ $og_title = $page_name; }else{ $og_title = $og_site_name = "การชำระเงิน";}
        if(!empty($setting->setting_keyword)){ $og_keywords = $setting->setting_keyword; }else{ $og_keywords = "";}
        if(!empty($setting->setting_detail)){ $og_description = $setting->setting_detail; }else{ $og_description = "";}
        if(!empty($setting->setting_coverShare)){ $og_image = asset('storage/setting/'.$setting->setting_coverShare); }else{ $og_image = asset('storage/setting/'.$setting->setting_coverShare);}
        if(!empty($page)){ $og_url = route('fronend.cart'); }else{ $og_url = route('fronend.home');}

        return view('fontend.cart.paymentNotify',[
            'breadcrumb' => $breadcrumb,
            'og_site_name' => $og_site_name,
            'og_keywords' => $og_keywords,
            'og_title' => $og_title,
            'og_description' => $og_description,
            'og_url' => $og_url,
            'og_image' => $og_image,
            'page_name' => 'การชำระเงิน',
            'order' => $order,
        ]);

    }

    public function orderRepeat($id){
        $setting = TbSetting::first();
        $provinces = TbSettingProvince::get();
        $settingPayment = TbSettingPayment::first();
        $order = TbOrder::with('tb_order_details')->findOrFail($id);
        $banks = TbPaymentBank::with('tb_setting_bank')->where('bank_show',1)->get();

        $breadcrumb = [
            ['route' => route('fronend.home'), 'name' => 'หน้าหลัก'],
            ['route' => '', 'name' => 'ชำระเงิน'],
        ];

        //title share
        if(!empty($page_name)){ $og_site_name = $page_name; }else{ $og_site_name = "ชำระเงิน";}
        if(!empty($page_name)){ $og_title = $page_name; }else{ $og_title = $og_site_name = "ชำระเงิน";}
        if(!empty($setting->setting_keyword)){ $og_keywords = $setting->setting_keyword; }else{ $og_keywords = "";}
        if(!empty($setting->setting_detail)){ $og_description = $setting->setting_detail; }else{ $og_description = "";}
        if(!empty($setting->setting_coverShare)){ $og_image = asset('storage/setting/'.$setting->setting_coverShare); }else{ $og_image = asset('storage/setting/'.$setting->setting_coverShare);}
        if(!empty($og_url)){ $og_url = route('fronend.cart'); }else{ $og_url = route('fronend.home');}

        return view('fontend.cart.orderRepeat',[
            'breadcrumb' => $breadcrumb,
            'og_site_name' => $og_site_name,
            'og_keywords' => $og_keywords,
            'og_title' => $og_title,
            'og_description' => $og_description,
            'og_url' => $og_url,
            'og_image' => $og_image,
            'setting' => $setting,
            'page_name' => 'ชำระเงิน',
            'data' => $order,
            'provinces' => $provinces,
            'settingPayment' => $settingPayment,
            'banks' => $banks,
        ]);
    }

    private function cardOmise($totalOrder,$orderId,$omise_token,$order_number,$fullName){

        $this->omisePublicKey();
        $this->omiseSecretKey();

        $charge = OmiseCharge::create(array(
            'amount'      => $totalOrder,
            'currency'    => 'thb',
            'card'        => $omise_token,
            'description' => 'หมายเลขคำสั่งซื้อ : '.$order_number.' ชื่อผู้สั่งซื้อ : '.$fullName,
            'return_uri' => route('fronend.cart.payment.update',$orderId),
        ));

        if($charge['status'] == 'successful'){
            $updateOrder                    = TbOrder::findOrFail($orderId);
            $updateOrder->chargeId          = $charge['id'];
            $updateOrder->payment_status    = 2;
            $updateOrder->statusCode        = $charge['statusCode'];
            $updateOrder->payment_massage   = $charge['statusMessage'];
            $updateOrder->save();


        }else if($charge['status'] == 'pending'){

            $updateOrder                    = TbOrder::findOrFail($orderId);
            $updateOrder->chargeId          = $charge['id'];
            $updateOrder->payment_status    = 1;
            $updateOrder->statusCode        = $charge['statusCode'];
            $updateOrder->payment_massage   = $charge['statusMessage'];
            $updateOrder->save();


        }else if($charge['status'] == 'failed'){

            $updateOrder                    = TbOrder::findOrFail($orderId);
            $updateOrder->chargeId          = $charge['id'];
            $updateOrder->payment_status    = 4;
            $updateOrder->statusCode        = $charge['statusCode'];
            $updateOrder->payment_massage   = $charge['statusMessage'];
            $updateOrder->save();

        }

        return $charge;
    }

    private function installmentOmise($totalOrder,$orderId,$omiseSource,$order_number,$fullName){

        $this->omisePublicKey();
        $this->omiseSecretKey();

        $charge = OmiseCharge::create(array(
            'amount' =>$totalOrder,
            'currency' => 'THB',
            'description' => 'หมายเลขคำสั่งซื้อ : '.$order_number.' ชื่อผู้สั่งซื้อ : '.$fullName,
            'source' => $omiseSource,
            'return_uri' => route('fronend.cart.payment.update',$orderId),
        ));

        if($charge['status'] == 'successful'){
            $updateOrder                    = TbOrder::findOrFail($orderId);
            $updateOrder->chargeId          = $charge['id'];
            $updateOrder->installmentType   = $charge['source']['type'];
            $updateOrder->installmentTerm   = $charge['source']['installment_term'];
            $updateOrder->payment_status    = 2;
            $updateOrder->statusCode        = $charge['statusCode'];
            $updateOrder->payment_massage   = $charge['statusMessage'];
            $updateOrder->save();

            $history = new HistoryOrderStatus();
            $history->orderNumber           = $updateOrder->orderNumber;
            $history->order_status          = 'ชำระเงินเรียบร้อย';
            $history->updated_by            = Auth::user()->displayname;
            $history->updated_at            = date('Y-m-d H:i:s');
            $history->save();

        }else if($charge['status'] == 'pending'){

            $updateOrder                    = TbOrder::findOrFail($orderId);
            $updateOrder->chargeId          = $charge['id'];
            $updateOrder->installmentType   = $charge['source']['type'];
            $updateOrder->installmentTerm   = $charge['source']['installment_term'];
            $updateOrder->payment_status    = 1;
            $updateOrder->statusCode        = $charge['statusCode'];
            $updateOrder->payment_massage   = $charge['statusMessage'];
            $updateOrder->save();

            $history = new HistoryOrderStatus();
            $history->orderNumber           = $updateOrder->orderNumber;
            $history->order_status          = 'รอการชำระเงิน';
            $history->updated_by            = Auth::user()->displayname;
            $history->updated_at            = date('Y-m-d H:i:s');
            $history->save();

        }else if($charge['status'] == 'failed'){

            $updateOrder                    = TbOrder::findOrFail($orderId);
            $updateOrder->chargeId          = $charge['id'];
            $updateOrder->installmentType   = $charge['source']['type'];
            $updateOrder->installmentTerm   = $charge['source']['installment_term'];
            $updateOrder->payment_status    = 4;
            $updateOrder->statusCode        = $charge['statusCode'];
            $updateOrder->payment_massage   = $charge['statusMessage'];
            $updateOrder->save();

            $history = new HistoryOrderStatus();
            $history->orderNumber           = $updateOrder->orderNumber;
            $history->order_status          = 'ชำระเงินไม่สำเร็จ';
            $history->updated_by            = Auth::user()->displayname;
            $history->updated_at            = date('Y-m-d H:i:s');
            $history->save();

        }

        return $charge;
    }

    private function generateOrderNumber($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    private function check_staff_IN_user(){
        $user = User::select('id','staffId')->findOrFail(Auth::user()->id);

        if(!empty($user->staffId)){

            $response = $user->staffId;
        }else{
            $response = NULL;
        }

        return $response ;
    }

    private function send_mail_order_Touser($orderId){

        $setting = TbSetting::first();
        $page = TbPagesMap::first();
        $order = TbOrder::with(
            'tb_setting_payment_status',
            'tb_order_payments',
            'tb_order_details',
            'tb_setting_province',
            'tb_setting_amphure',
            'tb_setting_district',
            'tb_receipt_province',
            'tb_receipt_amphures',
            'tb_receipt_district',
            'tb_setting_transport'
        )
        ->findOrFail($orderId);
        $user = User::where('user_code',$order->userCode)->first();

        $data = new \stdClass();
        $data->setting_nameWeb = $setting->setting_nameWeb;
        $data->setting_logoWeb = $setting->setting_logoWeb;
        $data->order = $order;
        $data->page = $page;

		try{
			Mail::to($user->email)->later(now()->addMinutes(5), new orderNotify($data));

			if(Mail::failures()) { $mailStatus = 'ล้มเหลว'; }else{ $mailStatus = 'สำเร็จ'; }
		}catch(\Exception $e){
			// Never reached
			$mailStatus = 'ล้มเหลว';
		}

        $history                            = new HistorySendMail();
        $history->userId                    = $user->id;
        $history->remark                    = "อัพเดตสถานะ ".$order->orderNumber;
        $history->status                    = $mailStatus;
        $history->created_by                = 'SYSTEM';
        $history->created_at                = date('Y-m-d H:i:s');
        $history->updated_at                = date('Y-m-d H:i:s');
        $history->save();

    }

    private function send_mail_order_Tostaff($orderId){

        $setting = TbSetting::first();
        $page = TbPagesMap::first();
        $order = TbOrder::with(
            'tb_setting_payment_status',
            'tb_order_payments',
            'tb_order_details',
            'tb_setting_province',
            'tb_setting_amphure',
            'tb_setting_district',
            'tb_receipt_province',
            'tb_receipt_amphures',
            'tb_receipt_district',
            'tb_setting_transport'
        )
        ->findOrFail($orderId);
        //ค้นหาข้อมูลผู้สั่งซื้อสินค้า
        $user = User::where('user_code',$order->userCode)->first();
        //ค้นหาข้อมูลผู้แนะนำ
        $ref = User::select('id','user_code','staffId')->where('user_code',$user->user_code_friend)->first();
        //ค้นหาข้อมูลพนักงานที่ดูแล ข้อมูลของผู้แนะนำ
        if(!empty($ref)){
            $staff = User::select('id','name','lastname')->where('id',$ref->staffId)->first();
        }else{
            $staff = 'ยังไม่มีผู้รับผิดชอบ';
        }
				
		# เช็คว่ามาจาก แบรนด์สินค้าที่ขายโดย ทีม ดิจิตอล MI มั้ย
		$brand_digital = '50,1,51,24';	// 3DConnexions , BASF , Formlabs, Untimaker
		$brand_digital = explode(',',$brand_digital);
		
		$count_digital_product = TbOrder::select('tb_product.pro_brand')
											->leftjoin('tb_order_detail','tb_order.id','tb_order_detail.orderId')
											->leftjoin('tb_product_detail','tb_order_detail.product_sku','tb_product_detail.detail_sku')
											->leftjoin('tb_product','tb_product_detail.proId','tb_product.id')
											->where('tb_order.id',$orderId)
											->whereIn('tb_product.pro_brand',$brand_digital)
											->count();
											
        $data = new \stdClass();
        $data->setting_nameWeb = $setting->setting_nameWeb;
        $data->setting_logoWeb = $setting->setting_logoWeb;
        $data->order = $order;
        $data->page = $page;
        $data->user = $user;
        $data->staff = $staff;

        if(!empty($setting->setting_email_bcc)){
            
			if(!empty($count_digital_product)){
				$mail_bcc = 'soliddigital@applicadthai.com';	// Mail to Digital Team
			}else{
				if(strpos($setting->setting_email_bcc,',')){
					$mail_bcc = explode(",",$setting->setting_email_bcc);
				}else{
					$mail_bcc = $setting->setting_email_bcc;
				}
			}
			
			try{
				Mail::to($mail_bcc)->later(now()->addMinutes(5), new orderToStaff($data));

				if(Mail::failures()) { $mailStatus = 'ล้มเหลว'; }else{ $mailStatus = 'สำเร็จ'; }
			}catch(\Exception $e){
				// Never reached
				$mailStatus = 'ล้มเหลว';
			}
			
            $history                            = new HistorySendMail();
            $history->userId                    = $user->id;
            $history->remark                    = "อัพเดตสถานะ ".$order->orderNumber;
            $history->status                    = $mailStatus;
            $history->created_by               	 = 'SYSTEM';
            $history->created_at                = date('Y-m-d H:i:s');
            $history->updated_at                = date('Y-m-d H:i:s');
            $history->save();
        }

    }

    private function rewrite_price($url){
        $str_replace = strtolower(str_replace(" ","-",$url));
        $data = preg_replace('/[^0-9]/', '', $str_replace);
        return $data ;
    }

    private function checkCart_Product(){
        $products = \Cart::getContent();

        if(count($products) == 0){
            return 0;
        }else{
            return 1;
        }
    }

	private function calcTotalsFromCart(bool $applyWht, int $personaType): array
	{
		$data = \Cart::getContent();
		$dataCondition = \Cart::getConditions();

		$subtotal = 0;
		$totalVat = 0;
		$totalWithholding = 0;
		$totalPrice = 0;
		$subtotal_discount = 0;

		$typeSetting = TbTypeSetting::first();

		// WHT คิดได้เฉพาะ persona บริษัท (2) และ user เลือก applyWht
		$canWht = ($personaType === 2) && $applyWht;

		// ------------------------------
		// CASE A: ไม่มีคูปอง
		// ------------------------------
		if (count($dataCondition) == 0) {

			$setData = [];

			foreach ($data as $product) {

				$proId = (int) explode('_', (string)$product->id)[0];

				$check = TbProduct::select(
					'tb_product.id','tb_product.pro_catId',
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
				if(!empty($typeSetting) && (int)$typeSetting->show === 1){
					$p_totalVat = ($p_subtotal * (float)$check->type_vat) / 100;
				} else {
					$p_totalVat = 0;
				}

				// WHT
				if($canWht && (float)$check->type_withholding != 0){
					$p_totalWithholding = ($p_subtotal * (float)$check->type_withholding) / 100;
				} else {
					$p_totalWithholding = 0;
				}

				$p_total = ($p_subtotal + $p_totalVat) - $p_totalWithholding;

				$setData[] = [
					'subtotal' => $p_subtotal,
					'totalVat' => $p_totalVat,
					'totalWithholding' => $p_totalWithholding,
					'total' => $p_total,
				];
			}

			foreach ($setData as $get) {
				$subtotal += $get['subtotal'];
				$totalVat += $get['totalVat'];
				$totalWithholding += $get['totalWithholding'];
				$totalPrice += $get['total'];
			}

			$nettotal = $subtotal + $totalVat;
			$total    = $totalPrice;

			return [
				'subtotal' => $subtotal,
				'totaldiscount' => $subtotal,      // ตามโค้ดเดิมคุณใช้ชื่อนี้
				'vat' => $totalVat,
				'nettotal' => $nettotal,
				'withholding' => $totalWithholding,
				'total' => $total,
			];
		}

		// ------------------------------
		// CASE B: มีคูปอง
		// ------------------------------
		$setData = [];

		foreach ($data as $product) {

			$proId = (int) explode('_', (string)$product->id)[0];

			$check = TbProduct::select(
				'tb_product.id','tb_product.pro_catId',
				'tb_category.id','tb_category.category_type',
				'tb_type.id','tb_type.type_vat','tb_type.type_withholding'
			)
			->leftjoin('tb_category','tb_category.id','tb_product.pro_catId')
			->leftjoin('tb_type','tb_type.id','tb_category.category_type')
			->where('tb_product.pro_show',1)
			->where('tb_product.id', $proId)
			->firstOrFail();

			$p_subtotal = $product->price * $product->quantity;

			// VAT ต่อชิ้น (จะมี/ไม่มี ไม่สำคัญ เพราะท้ายสุดคิด vat รวมทั้งบิลอยู่แล้ว)
			if(!empty($typeSetting) && (int)$typeSetting->show === 1){
				$p_totalVat = ($p_subtotal * (float)$check->type_vat) / 100;
			} else {
				$p_totalVat = 0;
			}

			// WHT ต่อชิ้น (ก่อนหักส่วนลด)
			if($canWht && (float)$check->type_withholding != 0){
				$p_totalWithholding = ($p_subtotal * (float)$check->type_withholding) / 100;
			} else {
				$p_totalWithholding = 0;
			}

			$p_total = ($p_subtotal + $p_totalVat) - $p_totalWithholding;

			$setData[] = [
				'subtotal' => $p_subtotal,
				'totalWithholding' => $p_totalWithholding,
				'total' => $p_total,
			];
		}

		// ดึงคูปอง (ในระบบคุณเหมือนใช้ตัวเดียว)
		$conditiontype = 1;
		$conditiontotal = 0;
		foreach($dataCondition as $condition){
			$conditiontype = $condition->getType();
			$conditiontotal = $condition->getValue();
		}

		foreach($setData as $get){
			$subtotal_discount += $get['subtotal'];
		}

		// ส่วนลด
		if($conditiontype == 1){
			$conditionPrice = (float)$conditiontotal;
		} else {
			$conditionPrice = ($subtotal_discount * (float)$conditiontotal) / 100;
		}

		$nettotal_before_tax = $subtotal_discount - $conditionPrice;
		if ($nettotal_before_tax < 0) $nettotal_before_tax = 0;

		// VAT รวมทั้งบิล
		if(!empty($typeSetting) && (int)$typeSetting->show === 1){
			$totalVat = ($nettotal_before_tax * (float)$typeSetting->vat) / 100;
		} else {
			$totalVat = 0;
		}

		// WHT ปรับตามสัดส่วนส่วนลด
		$ratio = ($subtotal_discount > 0) ? ($nettotal_before_tax / $subtotal_discount) : 0;

		$rawWithholding = 0;
		foreach($setData as $get2){
			$subtotal += $get2['subtotal'];
			$rawWithholding += $get2['totalWithholding'];
		}
		$totalWithholding = $rawWithholding * $ratio;

		$nettotal = $nettotal_before_tax + $totalVat;
		$total    = $nettotal - $totalWithholding;

		return [
			'subtotal' => $subtotal,
			'totaldiscount' => $subtotal_discount, // อันนี้ควรเป็น “ยอดก่อน VAT หลังส่วนลด” แต่ระบบเดิมคุณอาจใช้ชื่อสับสน
			'vat' => $totalVat,
			'nettotal' => $nettotal,
			'withholding' => $totalWithholding,
			'total' => $total,
		];
	}

}