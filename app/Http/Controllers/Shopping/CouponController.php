<?php

namespace App\Http\Controllers\Shopping;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\UsersCoupon;
use App\Models\TbPromotionCoupon;
use App\Models\TbSetting;
use App\Models\User;
use App\Models\TbProduct;
use App\Models\TbProductDetail;
use App\Models\TbExtension;
use App\Models\TbSettingUser;
use App\Models\TbSettingCompanyBusiness;
use App\Models\TbSettingCompanyPosition;


class CouponController extends Controller
{

    // รหัส invalid
    // 1 = คุณมีคูปองนี้ในระบบแล้ว.
    // 2 = คูปองนี้หมดอายุแล้ว ไม่สามารถใช้งานได้.
    // 3 = คูปองนี้ไม่สามารถใช้งานได้ เนื่องจากมีผู้ใช้ครบจำนวนที่กำหนดไว้แล้ว.
    // 4 = ไม่สามารถใช้คูปองได้ เนื่องจากมีการใช้ครบตามจำนวนที่กำหนดแล้ว.
    // 5 = ไม่สามารถใช้คูปองได้ เนื่องจากราคาสินค้าน้อยกว่าที่กำหนด.
    // 6 = ไม่สามารถใช้คูปองได้ เนื่องจากราคาสินค้ามากกว่าที่กำหนด.
    // 7 = ไม่สามารถใช้คูปองได้ เนื่องจากสินค้าไม่ได้เข้าร่วมกับส่วนลดนี้.
    // 8 = ไม่สามารถใช้คูปองได้ เนื่องจากสินค้าในหมวดหมู่ไม่ได้เข้าร่วมกับส่วนลดนี้.
    // 9 = ไม่สามารถใช้คูปองได้ เนื่องจากยังไม่มีสินค้าในตะกร้าสินค้า.

    public function cartCoupon(){
        $setting = TbSetting::first();
        if(!empty(Auth::user()->id)){
            $user = User::where('id',Auth::user()->id)->first();
            $coupons = $this->couponGet();
        }else{
            $user = "";
            $coupons = '';
        }
        $page_url = route('fronend.cart.coupon');

        $breadcrumb = [
            ['route' => route('fronend.home'), 'name' => 'หน้าหลัก'],
            ['route' => '', 'name' => 'โค้ดส่วนลดของฉัน'],
        ];

        //title share
        if(!empty($page_name)){ $og_site_name = $page_name; }else{ $og_site_name = "โค้ดส่วนลดของฉัน";}
        if(!empty($page_name)){ $og_title = $page_name; }else{ $og_title = $og_site_name = "โค้ดส่วนลดของฉัน";}
        if(!empty($setting->setting_keyword)){ $og_keywords = $setting->setting_keyword; }else{ $og_keywords = "";}
        if(!empty($setting->setting_detail)){ $og_description = $setting->setting_detail; }else{ $og_description = "";}
        if(!empty($setting->setting_coverShare)){ $og_image = asset('storage/setting/'.$setting->setting_coverShare); }else{ $og_image = asset('storage/setting/'.$setting->setting_coverShare);}
        if(!empty($og_url)){ $og_url = route('fronend.cart'); }else{ $og_url = route('fronend.home');}

        return view('fontend.cart.coupon',[
            'breadcrumb' => $breadcrumb,
            'og_site_name' => $og_site_name,
            'og_keywords' => $og_keywords,
            'og_title' => $og_title,
            'og_description' => $og_description,
            'og_url' => $og_url,
            'og_image' => $og_image,
            'user' => $user,
            'coupons' => $coupons,
            'page' => $page_url,
            'page_name' => 'ตะกร้าสินค้า',
        ]);
    }

    public function CouponCodition($id,$page){

        $setting = TbSetting::first();
        $coupon = TbPromotionCoupon::findOrfail($id);
        $page_name = 'โค้ดส่วนลดของฉัน';

        if($page == 'cart'){
            $page = route('fronend.cart.coupon');
        }else{
            $page = route('fronend.account.coupon');
        }

        return view('fontend.cart.couponCodition',[
            'setting' => $setting,
            'coupon' => $coupon,
            'page' => $page,
            'page_name' => $page_name,
        ]);
    }

    public function couponAccount(){

        $setting = TbSetting::first();
        $extension = TbExtension::select('ext_captcha_status','ext_captcha')->first();
        $user = User::where('id',Auth::user()->id)->first();
        $settingUser = TbSettingUser::first();
        $extension = TbExtension::select('ext_captcha_status','ext_captcha')->first();
        $business = TbSettingCompanyBusiness::where('business_show',1)->orderBy('business_name','asc')->get();
        $position = TbSettingCompanyPosition::where('position_show',1)->orderBy('position_name','asc')->get();
        $coupons = $this->couponGet();
        $page_name = 'โค้ดส่วนลดของฉัน';

        $breadcrumb = [
            ['route' => route('fronend.home'), 'name' => 'หน้าหลัก'],
            ['route' => '', 'name' => $page_name],
        ];

        //title share
        if(!empty($page_name)){ $og_site_name = $page_name; }else{ $og_site_name = $page_name;}
        if(!empty($page_name)){ $og_title = $page_name; }else{ $og_title = $og_site_name = $page_name;}
        if(!empty($setting->setting_keyword)){ $og_keywords = $setting->setting_keyword; }else{ $og_keywords = "";}
        if(!empty($setting->setting_detail)){ $og_description = $setting->setting_detail; }else{ $og_description = "";}
        if(!empty($setting->setting_coverShare)){ $og_image = asset('storage/setting/'.$setting->setting_coverShare); }else{ $og_image = "";}
        if(!empty($page)){ $og_url = route('login'); }else{ $og_url = route('fronend.home');}

        return view('fontend.account.coupon',[
            'breadcrumb' => $breadcrumb,
            'og_site_name' => $og_site_name,
            'og_keywords' => $og_keywords,
            'og_title' => $og_title,
            'og_description' => $og_description,
            'og_url' => $og_url,
            'og_image' => $og_image,
            'page_name' => $page_name,
            'extension' => $extension,
            'user' => $user,
            'settingUser' => $settingUser,
            'business' => $business,
            'position' => $position,
            'coupons' => $coupons,
        ]);

    }

    public function couponAddCondition($code){

        $products = \Cart::getContent();

        if(count($products) == 0){
            return redirect()->back()->with('invalid', '9');
        }else{
            //เช็คคูปองว่าหมดอายุหรือยัง
            // 1 = หมดอายุ
            // 0 = ยังไม่หมดอายุ
            $check_dateExp = $this->check_couponExp($code);
            if($check_dateExp == 1){

                //คูปองนี้หมดอายุแล้ว ไม่สามารถใช้งานได้
                return redirect()->back()->with('invalid', '2');
            }

            //เช็คลิมิตการใช้คูปองว่ามีการลิมิตการใช้ไหม
            // 1 = มีการลิมิต
            // 0 = ไม่มีการลิมิต
            $check_couponLimit = $this->check_couponLimit($code);
            if($check_couponLimit == 1){

                //คูปองนี้หมดอายุแล้ว ไม่สามารถใช้งานได้
                return redirect()->back()->with('invalid', '3');

            }

            //เช็คลิมิตการใช้คูปองว่ามีการลิมิตการใช้ต่อคนไหม ถ้ามี user ใช้จนถึง limit หรือยัง
            // 1 = มีการลิมิตจำนวนต่อ user
            // 0 = ไม่มีการลิมิตจำนวนต่อ user
            $check_couponLimit_people = $this->couponLimit_people($code);
            if($check_couponLimit_people == 1){

                //ไม่สามารถใช้คูปองได้ เนื่องจากมีการใช้ครบตามจำนวนที่กำหนดแล้ว
                return redirect()->back()->with('invalid', '4');

            }

            //เช็คยอดสั้งซื้อขั้นต่ำ สำหรับสินค้าในตะกร้า
            // 1 = มีการกำหนดยอดขั้นต่ำ
            // 0 = ไม่มีการกำหนดยอดขั้นต่ำ
            $check_minOrder = $this->minOrder($code);
            if($check_minOrder == 1){

                //ไม่สามารถใช้คูปองได้ เนื่องจากราคาสินค้าน้อยกว่าที่กำหนด.
                return redirect()->back()->with('invalid', '5');

            }

            //เช็คยอดสั้งซื้อสูงสุด สำหรับสินค้าในตะกร้า
            // 1 = มีการกำหนดยอดสูงสุด
            // 0 = ไม่มีการกำหนดยอดสูงสุด
            $check_maxOrder = $this->maxOrder($code);
            if($check_maxOrder == 1){

                //ไม่สามารถใช้คูปองได้ เนื่องจากราคาสินค้ามากกว่าที่กำหนด.
                return redirect()->back()->with('invalid', '6');

            }

            //เช็คว่าใช้ได้กับสินค้าที่กำหนดเท่านั้น
            // 1 = กำหนด
            // 0 = ไม่กำหนด
            $check_productSpecially = $this->productSpecially($code);
            if($check_productSpecially == 1){

                //เช็คสินค้าที่กำหนดว่าตรงหรือไม่
                // 1 = ไม่ตรงกับที่กำหนด
                // 0 = ตรงกับที่กำหนด
                $check_productSpecially_onCart = $this->productSpecially_onCart($code);
                if($check_productSpecially_onCart == 1){

                    //ไม่สามารถใช้คูปองได้ เนื่องจากสินค้าไม่ได้เข้าร่วมกับส่วนลดนี้.
                    return redirect()->back()->with('invalid', '7');

                }

            }

            // เช็คสินค้าที่ไม่ร่วมรายการ
            // 1 = กำหนด
            // 0 = ไม่กำหนด
            $check_productNon_Participating = $this->productNon_Participating($code);
            if($check_productNon_Participating == 1){

                $check_productNon_Participating_onCart = $this->productNon_Participating_onCart($code);
                if($check_productNon_Participating_onCart == 1){

                    //ไม่สามารถใช้คูปองได้ เนื่องจากสินค้าไม่ได้เข้าร่วมกับส่วนลดนี้.
                    return redirect()->back()->with('invalid', '7');

                }

            }

            // เช็คเฉพาะหมวดหมู่สินค้า
            // 1 = กำหนด
            // 0 = ไม่กำหนด
            $check_categorie_Participating = $this->categorie_Participating($code);
            if($check_categorie_Participating == 1){

                //เช็คว่ามีหมวดหมู่สินค้าตรงตามกำหนดไหม
                // 1 = ไม่ร่วมรายการลด
                // 0 = ร่วมรายการลด
                $check_categorie_Participating_onCart = $this->categorie_Participating_onCart($code);
                if($check_categorie_Participating_onCart == 1){

                    //ไม่สามารถใช้คูปองได้ เนื่องจากสินค้าในหมวดหมู่ไม่ได้เข้าร่วมกับส่วนลดนี้.
                    return redirect()->back()->with('invalid', '8');

                }

            }

            //เช็คหมวดหมู่ที่ไม่ร่วมรายการ
            // 1 = กำหนด
            // 0 = ไม่กำหนด
            $check_categorieNon_Participating = $this->categorieNon_Participating($code);
            if($check_categorieNon_Participating == 1){

                //เช็คว่ามีหมวดหมู่สินค้าตรงตามกำหนดไหม
                // 1 = ไม่ร่วมรายการลด
                // 0 = ร่วมรายการลด
                $check_categorieNon_Participating_onCart = $this->categorieNon_Participating_onCart($code);
                if($check_categorieNon_Participating_onCart == 1){

                    //ไม่สามารถใช้คูปองได้ เนื่องจากสินค้าในหมวดหมู่ไม่ได้เข้าร่วมกับส่วนลดนี้.
                    return redirect()->back()->with('invalid', '8');

                }

            }


            //เช็คว่าไม่รวมสินค้าลดราคาหรือไม่
            // 1 = ร่วมกับสินค้าลดรายการ
            // 0 = ไม่ร่วมสินค้าลดรายการ
            $check_productSale = $this->productSale($code);
            if($check_productSale == 1){

                //เช็คว่ามีสินค้าตรงตามกำหนดไหม
                // 1 = ไม่ร่วมรายการลด
                // 0 = ร่วมรายการลด
                $check_productSale_onCart = $this->productSale_onCart($code);
                if($check_productSale_onCart == 1){

                    //ไม่สามารถใช้คูปองได้ เนื่องจากสินค้าในหมวดหมู่ไม่ได้เข้าร่วมกับส่วนลดนี้.
                    return redirect()->back()->with('invalid', '10');

                }
            }

            //เพิ่มคูปองลงในรายการส่วนลด
            $couponList = TbPromotionCoupon::select('coupon_code','coupon_type','coupon_discount')->where('coupon_code',$code)->first();
            $condition = new \Darryldecode\Cart\CartCondition(array(
                'name'      => $code,
                'type'      => $couponList->coupon_type,
                'target'    => 'total',
                'value'     => $couponList->coupon_discount,
            ));

            \Cart::clearCartConditions();
            \Cart::condition($condition);

            return redirect()->route('fronend.cart')->with('feedback', 'เพิ่มคูปองสำหรับลดราคาเรียบร้อยแล้ว!');
        }

    }

    public function couponCrate(Request $request,$userId){

        $coupon_code = $request->coupon_code;

        //check coupon
        if(!empty($coupon_code)){

            //เช็คว่า user นี้เคยมีคูปองนี้หรือยัง
            // 0 = ไม่เคยมีคูปองนี้
            // 1 = มีคูปองนี้อยู่แล้ว
            $ck_user_coupon = $this->check_userCoupon($coupon_code,$userId);
            if($ck_user_coupon == 1){

                //คุณมีคูปองนี้ในระบบแล้ว
                return redirect()->back()->with('invalid', '1');

            }else{

                //เช็คว่าคูปองนี้หมดอายุไปหรือยัง
                // 0 = ยังไม่หมดอายุ
                // 1 = หมดอายุแล้ว
                $ck_coupon_exp = $this->check_couponExp($coupon_code);
                if($ck_coupon_exp == 1){

                    //คูปองนี้หมดอายุแล้ว ไม่สามารถใช้งานได้
                    return redirect()->back()->with('invalid', '2');

                }else{

                    //เช็คว่าคูปองมีการลิมิตจำนวนไว้ไหม
                    // 0 = ไม่มีลิมิต
                    // 1 = มีลิมิต
                    $check_coupon_limit = $this->check_couponLimit($coupon_code);
                    if($check_coupon_limit == 1){

                        //คูปองนี้ไม่สามารถใช้งานได้ เนื่องจากมีผู้ใช้ครบจำนวนที่กำหนดไว้แล้ว.
                        return redirect()->back()->with('invalid', '3');

                    }else{

                        $data = new UsersCoupon;
                        $data->coupon_code                  = $request->coupon_code;
                        $data->userId                       = $userId;
                        $data->coupon_use                   = 0;
                        $data->created_by                   = Auth::user()->displayname;
                        $data->updated_by                   = Auth::user()->displayname;
                        $data->updated_at                   = now();
                        $data->created_at                   = now();
                        $data->save();

                        return redirect()->back()->with('feedback', 'เพิ่มข้อมูลเรียบร้อยแล้ว!');

                    }

                }

            }
            return $ck_user_coupon;

        }else{

            $request->validate(
                [
                    'coupon_code' => ['required','max:255'],
                ],
                [
                    'coupon_code.required' => 'กรุณากรอกข้อมูล',
                    'coupon_code.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                ]
            );

            return redirect()->back();

        }

    }

    private function check_userCoupon($coupon_code,$userId){

        $result = UsersCoupon::where('coupon_code',$coupon_code)->where('userId',$userId)->count();

        if($result == 0){
            return  0;
        }else{
            return 1;
        }

    }

    private function check_couponExp($coupon_code){

        $coupon = TbPromotionCoupon::where('coupon_code',$coupon_code)->first();

        if(!empty($coupon->coupon_date_exp)){

            if($coupon->coupon_date_exp >= date('Y-m-d') ){
                return 0;
            }else{
                return 1;
            }

        }else{
            return 0;
        }

    }

    private function check_couponLimit($coupon_code){

        $coupon = TbPromotionCoupon::where('coupon_code',$coupon_code)->first();
        if(!empty($coupon->coupon_limit)){
            //เช็คว่ามีการเพิ่มไว้จนถึง limit หรือยัง
            $userCoupon = UsersCoupon::where('coupon_code',$coupon_code)->where('coupon_use',1)->count();
            if($userCoupon >= $coupon->coupon_limit){
                return 1;
            }else{
                return 0;
            }

        }else{
            return 0;
        }
    }

    private function couponLimit_people($coupon_code){

        $userId         = Auth::user()->id;
        $couponLimit    = TbPromotionCoupon::where('coupon_code',$coupon_code)->value('coupon_limit_people');
        $userCoupon     = UsersCoupon::where('coupon_code',$coupon_code)->where('userId',$userId)->value('coupon_use');

        if(!empty($couponLimit)){

            if($userCoupon >= $couponLimit){
                return 1;
            }else{
                return 0;
            }

        }else{
            return 0;
        }

    }

    private function minOrder($coupon_code){

        $couponLimit    = TbPromotionCoupon::where('coupon_code',$coupon_code)->value('min_order_amount');
        //เช็คยอดสินค้าใน cart
        $totalCart      = $this->checkTotalCart();

        if(!empty($couponLimit)){
            if($totalCart >= $couponLimit){
                return 0;
            }else{
                return 1;
            }
        }else{
            return 0;
        }


    }

    private function maxOrder($coupon_code){

        $couponLimit    = TbPromotionCoupon::where('coupon_code',$coupon_code)->value('max_order_amount');
        //เช็คยอดสินค้าใน cart
        $totalCart      = $this->checkTotalCart();

        if(!empty($couponLimit)){
            if($totalCart >= $couponLimit){
                return 1;
            }else{
                return 0;
            }
        }else{
            return 0;
        }

    }

    private function productSpecially($coupon_code){

        $coupon    = TbPromotionCoupon::where('coupon_code',$coupon_code)->value('participating_products');
        if(!empty($coupon )){
            return 1;
        }else{
            return 0;
        }

    }

    private function productNon_Participating($coupon_code){

        $coupon    = TbPromotionCoupon::where('coupon_code',$coupon_code)->value('non_participating_products');
        if(!empty($coupon )){
            return 1;
        }else{
            return 0;
        }

    }

    private function categorie_Participating($coupon_code){

        $coupon    = TbPromotionCoupon::where('coupon_code',$coupon_code)->value('participating_categorie');
        if(!empty($coupon)){
            return 1;
        }else{
            return 0;
        }

    }

    private function categorieNon_Participating($coupon_code){

        $coupon    = TbPromotionCoupon::where('coupon_code',$coupon_code)->value('non_participating_categorie');
        if(!empty($coupon)){
            return 1;
        }else{
            return 0;
        }

    }

    private function productSale($coupon_code){

        $coupon    = TbPromotionCoupon::where('coupon_code',$coupon_code)->where('status_product_not_sale',1)->value('status_product_not_sale');
        if(!empty($coupon)){
            return 1;
        }else{
            return 0;
        }

    }

    private function checkTotalCart(){

        $data = \Cart::getContent();

        $subtotal = 0;
        $total = 0;
        foreach($data as $product){

            $setData[] = array(
                'id' => $product->id,
                'price' => $product->price*$product->quantity,
            );
        }

        foreach($setData as $get){

            $subtotal += $get['price'];
        }

        //ราคาสินค้าก่อน VAT
        $total = $subtotal;

        return $total;

    }

    private function productSpecially_onCart($coupon_code){

        $coupon = TbPromotionCoupon::where('coupon_code',$coupon_code)->value('participating_products');
        $proId = explode(",",$coupon);

        $products = \Cart::getContent();

        $response = array();
        foreach($products as $product){
            $detail = TbProductDetail::select('tb_product.id','tb_product.pro_catId','tb_product.pro_catsubId','tb_product_detail.proId','tb_product_detail.detail_sku')
                ->leftjoin('tb_product','tb_product.id','tb_product_detail.proId')
                ->where('tb_product_detail.detail_sku',$product->attributes->sku)
                ->whereIn('tb_product_detail.proId',$proId)
                ->first();

            if(!empty($detail)){
                array_push($response, $detail);
            }
        }

        if(!empty($response)){
            return 0;
        }else{
            return 1;
        }

    }

    private function productNon_Participating_onCart($coupon_code){

        $coupon = TbPromotionCoupon::where('coupon_code',$coupon_code)->value('non_participating_products');
        $proId = explode(",",$coupon);

        $products = \Cart::getContent();

        $response = array();
        foreach($products as $product){
            $detail = TbProductDetail::select('tb_product.id','tb_product.pro_catId','tb_product.pro_catsubId','tb_product_detail.proId','tb_product_detail.detail_sku')
                ->leftjoin('tb_product','tb_product.id','tb_product_detail.proId')
                ->where('tb_product_detail.detail_sku',$product->attributes->sku)
                ->whereIn('tb_product_detail.proId',$proId)
                ->first();

            if(!empty($detail)){
                array_push($response, $detail);
            }
        }

        if(!empty($response)){
            return 1;
        }else{
            return 0;
        }

    }

    private function categorie_Participating_onCart($coupon_code){

        $coupon = TbPromotionCoupon::where('coupon_code',$coupon_code)->first();
        $categorieId = explode(",",$coupon->participating_categorie);

        $products = \Cart::getContent();

        $response = array();
        foreach($products as $product){

            if($coupon->participating_categorie_type == 1){
                $detail = TbProductDetail::select('tb_product.id','tb_product.pro_catId','tb_product.pro_catsubId','tb_product_detail.proId','tb_product_detail.detail_sku')
                ->leftjoin('tb_product','tb_product.id','tb_product_detail.proId')
                ->where('tb_product_detail.detail_sku',$product->attributes->sku)
                ->whereIn('tb_product.pro_catId',$categorieId)
                ->first();

            }else{
                $detail = TbProductDetail::select('tb_product.id','tb_product.pro_catId','tb_product.pro_catsubId','tb_product_detail.proId','tb_product_detail.detail_sku')
                ->leftjoin('tb_product','tb_product.id','tb_product_detail.proId')
                ->where('tb_product_detail.detail_sku',$product->attributes->sku)
                ->whereIn('tb_product.pro_catsubId',$categorieId)
                ->first();
            }

            if(!empty($detail)){
                array_push($response, $detail);
            }

        }

        if(!empty($response)){
            return 0;
        }else{
            return 1;
        }

    }

    private function categorieNon_Participating_onCart($coupon_code){

        $coupon = TbPromotionCoupon::where('coupon_code',$coupon_code)->first();
        $categorieId = explode(",",$coupon->non_participating_categorie);

        $products = \Cart::getContent();

        $response = array();
        foreach($products as $product){

            if($coupon->non_participating_categorie_type == 1){
                $detail = TbProductDetail::select('tb_product.id','tb_product.pro_catId','tb_product.pro_catsubId','tb_product_detail.proId','tb_product_detail.detail_sku')
                ->leftjoin('tb_product','tb_product.id','tb_product_detail.proId')
                ->where('tb_product_detail.detail_sku',$product->attributes->sku)
                ->whereIn('tb_product.pro_catId',$categorieId)
                ->first();

            }else{
                $detail = TbProductDetail::select('tb_product.id','tb_product.pro_catId','tb_product.pro_catsubId','tb_product_detail.proId','tb_product_detail.detail_sku')
                ->leftjoin('tb_product','tb_product.id','tb_product_detail.proId')
                ->where('tb_product_detail.detail_sku',$product->attributes->sku)
                ->whereIn('tb_product.pro_catsubId',$categorieId)
                ->first();
            }

            if(!empty($detail)){
                array_push($response, $detail);
            }

        }

        if(!empty($response)){
            return 1;
        }else{
            return 0;
        }

    }

    private function productSale_onCart(){

        $cart = \Cart::getContent();

        $product = [];
        foreach($cart as $item){

            if(!empty($item->attributes['pricesale'])){

                $product[] = array(
                    'sku' => $item->attributes['sku'],
                    'price' => $item->attributes['price'],
                    'pricesale' => $item->attributes['pricesale'],
                );

            }

        }

        if(!empty($product)){
            return 1;
        }else{
            return 0;
        }
    }

    private function getTotalCart(){

        $data = \Cart::getContent();

        $subtotal = 0;
        $totalVat = 0;
        $totalWithholding = 0;
        $total = 0;
        foreach($data as $product){

            $check = TbProduct::select(
                'tb_product.id','tb_product.pro_name','tb_product.pro_catId',
                'tb_category.id','tb_category.category_type',
                'tb_type.id','tb_type.type_vat','tb_type.type_withholding'
            )
            ->leftjoin('tb_category','tb_category.id','tb_product.pro_catId')
            ->leftjoin('tb_type','tb_type.id','tb_category.category_type')
            ->where('tb_product.pro_show',1)
            ->findOrFail($product->id);

            $setData[] = array(
                'id' => $product->id,
                'price' => $product->price*$product->quantity,
                'vat' => $check->type_vat,
                'withholding' => $check->type_withholding,
            );
        }

        foreach($setData as $get){

            $subtotal += $get['price'];
            $totalVat += ($get['price'] * $get['vat'])/100;
            $totalWithholding += ($get['price'] * $get['withholding'])/100;
        }

        $total = ($subtotal + $totalVat) - $totalWithholding;

        $response = array(
            'subtotal' => $subtotal,
            'vat' => $totalVat,
            'withholding' => $totalWithholding,
            'total' => $total,
        );

        return $response;

    }

    private function couponGet(){

        $userId = Auth::user()->id;
        $this->check_statusCoupon($userId);

        $response = array();

        $userCoupon   = UsersCoupon::leftJoin('tb_promotion_coupon','tb_promotion_coupon.coupon_code','users_coupon.coupon_code')
        ->where('userId',$userId)
        ->where('users_coupon.show',1)
        ->get();

        foreach($userCoupon as $coupon){

            //check ว่าวันหมดอายุว่างไหม
            if(!empty($coupon->coupon_date_exp)){

                //check วันที่ตั้งค่าไว้ มากกว่าวันที่ปัจจุบัน
                if($coupon->coupon_date_exp >= date('Y-m-d') ){

                    $response[] = array(
                        'id' => $coupon->id,
                        'coupon_code' => $coupon->coupon_code,
                        'coupon_name' => $coupon->coupon_name,
                        'coupon_name' => $coupon->coupon_name,
                        'coupon_img' => $coupon->coupon_img,
                        'coupon_des' => $coupon->coupon_des,
                        'coupon_type' => $coupon->coupon_type,
                        'coupon_discount' => $coupon->coupon_discount,
                        'coupon_date_exp' => $coupon->coupon_date_exp,
                        'min_order_amount' => $coupon->min_order_amount,
                        'max_order_amount' => $coupon->max_order_amount,
                        'status_product_not_sale' => $coupon->status_product_not_sale,
                        'participating_products' => $coupon->participating_products,
                        'non_participating_products' => $coupon->non_participating_products,
                        'participating_categorie_type' => $coupon->participating_categorie_type,
                        'participating_categorie' => $coupon->participating_categorie,
                        'non_participating_categorie_type' => $coupon->non_participating_categorie_type,
                        'non_participating_categorie' => $coupon->non_participating_categorie,
                        'coupon_limit' => $coupon->coupon_limit,
                        'coupon_limit_people' => $coupon->coupon_limit_people,
                    );
                }

            }else{

                //ไม่ได้กำหนดวันหมออายุ
                $response[] = array(
                    'id' => $coupon->id,
                    'coupon_code' => $coupon->coupon_code,
                    'coupon_name' => $coupon->coupon_name,
                    'coupon_name' => $coupon->coupon_name,
                    'coupon_img' => $coupon->coupon_img,
                    'coupon_des' => $coupon->coupon_des,
                    'coupon_type' => $coupon->coupon_type,
                    'coupon_discount' => $coupon->coupon_discount,
                    'coupon_date_exp' => $coupon->coupon_date_exp,
                    'min_order_amount' => $coupon->min_order_amount,
                    'max_order_amount' => $coupon->max_order_amount,
                    'status_product_not_sale' => $coupon->status_product_not_sale,
                    'participating_products' => $coupon->participating_products,
                    'non_participating_products' => $coupon->non_participating_products,
                    'participating_categorie_type' => $coupon->participating_categorie_type,
                    'participating_categorie' => $coupon->participating_categorie,
                    'non_participating_categorie_type' => $coupon->non_participating_categorie_type,
                    'non_participating_categorie' => $coupon->non_participating_categorie,
                    'coupon_limit' => $coupon->coupon_limit,
                    'coupon_limit_people' => $coupon->coupon_limit_people,
                );
            }
        }

        return $response;

    }

    private function check_statusCoupon($userId){

        $checkCoupon   = UsersCoupon::leftJoin('tb_promotion_coupon','tb_promotion_coupon.coupon_code','users_coupon.coupon_code')
        ->where('userId',$userId)
        ->where('users_coupon.show',1)
        ->get();


        foreach($checkCoupon as $check){

            //check ว่าวันหมดอายุว่างไหม
            if(!empty($check->coupon_date_exp)){

                //check วันที่ตั้งค่าไว้ มากกว่าวันที่ปัจจุบัน
                if($check->coupon_date_exp >= date('Y-m-d') ){

                    //เช็คว่าคูปองมีการลิมิตจำนวนไว้ไหม
                    // 0 = ไม่มีลิมิต
                    // 1 = มีลิมิต
                    $check_coupon_limit = $this->check_couponLimit($check->coupon_code);
                    if($check_coupon_limit == 1){

                        //คูปองนี้ไม่สามารถใช้งานได้ เนื่องจากมีผู้ใช้ครบจำนวนที่กำหนดไว้แล้ว.
                        $limitCoupon = UsersCoupon::where('coupon_code',$check->coupon_code)->first();
                        $limitCoupon->show = 2;
                        $limitCoupon->save();

                        \Cart::clearCartConditions();

                    }

                    //เช็คจำนวนลิมิตต่อคนใช้
                    $check_couponLimit_people = $this->couponLimit_people($check->coupon_code);
                    if($check_couponLimit_people == 1){

                        //ไม่สามารถใช้คูปองได้ เนื่องจากมีการใช้ครบตามจำนวนที่กำหนดแล้ว
                        $limitCoupon = UsersCoupon::where('coupon_code',$check->coupon_code)->first();
                        $limitCoupon->show = 2;
                        $limitCoupon->save();

                        \Cart::clearCartConditions();

                    }

                }else{
                    //คูปองหมดอายุแล้ว ให้ลบออก
                    $couponExp = UsersCoupon::where('coupon_code',$check->coupon_code)->where('userId',$userId)->where('show',1)->get();
                    foreach($couponExp as $coupon){
                        UsersCoupon::where('id', $coupon->id)->delete();
                    }
                    \Cart::clearCartConditions();
                }

            }else{

                //เช็คว่าคูปองมีการลิมิตจำนวนไว้ไหม
                // 0 = ไม่มีลิมิต
                // 1 = มีลิมิต
                $check_coupon_limit = $this->check_couponLimit($check->coupon_code);
                if($check_coupon_limit == 1){

                    //คูปองนี้ไม่สามารถใช้งานได้ เนื่องจากมีผู้ใช้ครบจำนวนที่กำหนดไว้แล้ว.
                    $limitCoupon = UsersCoupon::where('coupon_code',$check->coupon_code)->first();
                    $limitCoupon->show = 2;
                    $limitCoupon->save();

                    \Cart::clearCartConditions();

                }

                //เช็คจำนวนลิมิตต่อคนใช้
                $check_couponLimit_people = $this->couponLimit_people($check->coupon_code);
                if($check_couponLimit_people == 1){

                    //ไม่สามารถใช้คูปองได้ เนื่องจากมีการใช้ครบตามจำนวนที่กำหนดแล้ว
                    $limitCoupon = UsersCoupon::where('coupon_code',$check->coupon_code)->first();
                    $limitCoupon->show = 2;
                    $limitCoupon->save();

                    \Cart::clearCartConditions();

                }
            }
        }
        

    }
	
	public function validateCouponForCart(string $code): int
    {
        $products = \Cart::getContent();
        if (count($products) == 0) {
            return 9;
        }
        if ($this->check_couponExp($code) == 1) {
            return 2;
        }
        if ($this->check_couponLimit($code) == 1) {
            return 3;
        }
        if ($this->couponLimit_people($code) == 1) {
            return 4;
        }
        if ($this->minOrder($code) == 1) {
            return 5;
        }
        if ($this->maxOrder($code) == 1) {
            return 6;
        }
        if ($this->productSpecially($code) == 1
            && $this->productSpecially_onCart($code) == 1
        ) {
            return 7;
        }
        if ($this->productNon_Participating($code) == 1
            && $this->productNon_Participating_onCart($code) == 1
        ) {
            return 7;
        }
        if ($this->categorie_Participating($code) == 1
            && $this->categorie_Participating_onCart($code) == 1
        ) {
            return 8;
        }
        if ($this->categorieNon_Participating($code) == 1
            && $this->categorieNon_Participating_onCart($code) == 1
        ) {
            return 8;
        }
        if ($this->productSale($code) == 1
            && $this->productSale_onCart($code) == 1
        ) {
            return 10;
        }

        // ถ้าผ่านทุกเงื่อนไข
        return 0;
    }

}
