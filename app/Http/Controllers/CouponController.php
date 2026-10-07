<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Providers\RouteServiceProvider;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

use App\Models\TbPromotionCoupon;
use App\Models\TbProduct;
use App\Models\TbCategory;
use App\Models\TbCategorySub;
use App\Models\TbOrder;
use App\Models\TbSettingMonth;

class CouponController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $breadcrumb = [
            ['name' => 'คูปอง'],
        ];
        $title_page = 'คูปอง';
        $count = TbPromotionCoupon::count();

        return view('admin.coupon.main', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'count' => $count,
            'data' => '',
        ]);

    }

    public function add(){

        $breadcrumb = [
            ['name' => 'เพิ่ม คูปอง'],
        ];
        $title_page = 'เพิ่ม คูปอง';
        $products = TbProduct::select('id','pro_name','pro_show')->where('pro_show',1)->get();

        return view('admin.coupon.form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => '',
            'products' => $products,
        ]);

    }

    public function crate(Request $request){

        $request->validate(
            [
                'coupon_code' => 'required|max:255',
                'coupon_name' => 'required|max:255',
                'coupon_type' => 'required',
                'coupon_discount' => 'required|numeric',
                'min_order_amount' => 'max:255',
                'max_order_amount' => 'max:255',
                'coupon_limit' => 'max:255',
                'coupon_limit_people' => 'max:255',
            ],
            [
                'coupon_code.required' => 'กรุณากรอกข้อมูล',
                'coupon_code.max' => 'ตัวอักษรเกินกำหนดที่ตั้งไว้ กรุณาตรวจสอบข้อมูล',
                'coupon_name.required' => 'กรุณากรอกข้อมูล',
                'coupon_name.max' => 'ตัวอักษรเกินกำหนดที่ตั้งไว้ กรุณาตรวจสอบข้อมูล',
                'coupon_type.required' => 'กรุณาเลือกข้อมูล',
                'coupon_discount.required' => 'กรุณาเลือกข้อมูล',
                'coupon_discount.numeric' => 'กรอกเฉพาะตัวเลช',
                'min_order_amount.max' => 'ตัวอักษรเกินกำหนดที่ตั้งไว้ กรุณาตรวจสอบข้อมูล',
                'min_order_amount.numeric' => 'กรอกเฉพาะตัวเลช',
                'max_order_amount.max' => 'ตัวอักษรเกินกำหนดที่ตั้งไว้ กรุณาตรวจสอบข้อมูล',
                'max_order_amount.numeric' => 'กรอกเฉพาะตัวเลช',
                'coupon_limit.max' => 'ตัวอักษรเกินกำหนดที่ตั้งไว้ กรุณาตรวจสอบข้อมูล',
                'coupon_limit.numeric' => 'กรอกเฉพาะตัวเลช',
                'coupon_limit_people.max' => 'ตัวอักษรเกินกำหนดที่ตั้งไว้ กรุณาตรวจสอบข้อมูล',
                'coupon_limit_people.numeric' => 'กรอกเฉพาะตัวเลช',
            ]
        );

        if($request->show == 'on'){
            $show = 1;
        }else{
            $show = 2;
        }

        if(!empty($request->status_product_not_sale)){
            $status_product_not_sale = 1;
        }else{
            $status_product_not_sale = 2;
        }

        if($request->participating_products != ''){
			$participating_products = implode(",", $request->participating_products);
		} else {
			$participating_products = '';
		}

        if($request->non_participating_products != ''){
			$non_participating_products = implode(",", $request->non_participating_products);
		} else {
			$non_participating_products = '';
		}

        $data = new TbPromotionCoupon;
        $data->coupon_code                          = $request->coupon_code;
        $data->coupon_name                          = $request->coupon_name;
        $data->coupon_des                           = $request->coupon_des;
        $data->coupon_type                          = $request->coupon_type;
        $data->coupon_discount                      = $request->coupon_discount;
        if(!empty($request->coupon_date_exp)){
            $data->coupon_date_exp                  = date("Y-m-d",strtotime($request->coupon_date_exp));
        }
        $data->min_order_amount                     = $request->min_order_amount;
        $data->max_order_amount                     = $request->max_order_amount;
        $data->status_product_not_sale              = $status_product_not_sale;
        $data->participating_products               = $participating_products;
        $data->non_participating_products           = $non_participating_products;
        if(!empty($request->participating_categorie_type)){
            $data->participating_categorie_type     = $request->participating_categorie_type;
        }
        if(!empty($request->participating_categorie)){
            $data->participating_categorie          = $request->participating_categorie;
        }
        if(!empty($request->non_participating_categorie_type)){
            $data->non_participating_categorie_type = $request->non_participating_categorie_type;
        }
        if(!empty($request->non_participating_categorie)){
            $data->non_participating_categorie      = $request->non_participating_categorie;
        }
        $data->coupon_limit                         = $request->coupon_limit;
        $data->coupon_limit_people                  = $request->coupon_limit_people;
        $data->show                                 = $show;
        $data->created_by                           = Auth::user()->displayname;
        $data->updated_by                           = Auth::user()->displayname;
        $data->created_at                           = date('Y-m-d H:i:s');
        $data->updated_at                           = date('Y-m-d H:i:s');

        if (!empty($request->coupon_img)) {

            if ($request->hasFile('coupon_img')) {
                @unlink(Storage::disk('public')->path('coupon/') . $request->coupon_img_old);

                $newFilename = uniqid() . '.' . $request->coupon_img->extension();
                $data->coupon_img = $newFilename;
                $file = $request->file('coupon_img');
                $file->move('storage/coupon/', $newFilename);
            }

        }

        $data->save();

        return redirect()->route('promotion.coupon.edit',[$data->id])->with('feedback', 'เพิ่มข้อมูลเรียบร้อยแล้ว!');

    }

    public function edit($id)
    {
        $breadcrumb = [
            ['name' => 'อัพเดต คูปอง'],
        ];
        $title_page = 'อัพเดต คูปอง';

        $data = TbPromotionCoupon::findOrFail($id);
        $products = TbProduct::select('id','pro_name','pro_show')->where('pro_show',1)->get();

        return view('admin.coupon.form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => $data,
            'products' => $products,
        ]);
    }

    public function update(Request $request,$id){

        $request->validate(
            [
                'coupon_name' => 'required|max:255',
                'coupon_type' => 'required',
                'coupon_discount' => 'required|numeric',
                'min_order_amount' => 'max:255',
                'max_order_amount' => 'max:255',
                'coupon_limit' => 'max:255',
                'coupon_limit_people' => 'max:255',
            ],
            [
                'coupon_name.required' => 'กรุณากรอกข้อมูล',
                'coupon_name.max' => 'ตัวอักษรเกินกำหนดที่ตั้งไว้ กรุณาตรวจสอบข้อมูล',
                'coupon_type.required' => 'กรุณาเลือกข้อมูล',
                'coupon_discount.required' => 'กรุณาเลือกข้อมูล',
                'coupon_discount.numeric' => 'กรอกเฉพาะตัวเลช',
                'min_order_amount.max' => 'ตัวอักษรเกินกำหนดที่ตั้งไว้ กรุณาตรวจสอบข้อมูล',
                'min_order_amount.numeric' => 'กรอกเฉพาะตัวเลช',
                'max_order_amount.max' => 'ตัวอักษรเกินกำหนดที่ตั้งไว้ กรุณาตรวจสอบข้อมูล',
                'max_order_amount.numeric' => 'กรอกเฉพาะตัวเลช',
                'coupon_limit.max' => 'ตัวอักษรเกินกำหนดที่ตั้งไว้ กรุณาตรวจสอบข้อมูล',
                'coupon_limit.numeric' => 'กรอกเฉพาะตัวเลช',
                'coupon_limit_people.max' => 'ตัวอักษรเกินกำหนดที่ตั้งไว้ กรุณาตรวจสอบข้อมูล',
                'coupon_limit_people.numeric' => 'กรอกเฉพาะตัวเลช',
            ]
        );

        if($request->show == 'on'){
            $show = 1;
        }else{
            $show = 2;
        }

        if(!empty($request->status_product_not_sale)){
            $status_product_not_sale = 1;
        }else{
            $status_product_not_sale = 2;
        }

        if($request->participating_products != ''){
			$participating_products = implode(",", $request->participating_products);
		} else {
			$participating_products = '';
		}

        if($request->non_participating_products != ''){
			$non_participating_products = implode(",", $request->non_participating_products);
		} else {
			$non_participating_products = '';
		}

        if($request->participating_categorie != ''){
			$participating_categorie = implode(",", $request->participating_categorie);
		} else {
			$participating_categorie = '';
		}

        if($request->non_participating_categorie != ''){
			$non_participating_categorie = implode(",", $request->non_participating_categorie);
		} else {
			$non_participating_categorie = '';
		}


        $data = TbPromotionCoupon::findOrFail($id);
        $data->coupon_name                          = $request->coupon_name;
        $data->coupon_des                           = $request->coupon_des;
        $data->coupon_type                          = $request->coupon_type;
        $data->coupon_discount                      = $request->coupon_discount;
        if(!empty($request->coupon_date_exp)){
            $data->coupon_date_exp                  = date("Y-m-d",strtotime($request->coupon_date_exp));
        }else{
            $data->coupon_date_exp                  = null;
        }
        $data->min_order_amount                     = $request->min_order_amount;
        $data->max_order_amount                     = $request->max_order_amount;
        $data->status_product_not_sale              = $status_product_not_sale;
        $data->participating_products               = $participating_products;
        $data->non_participating_products           = $non_participating_products;
        if(!empty($request->participating_categorie_type)){
            $data->participating_categorie_type         = $request->participating_categorie_type;
        }
        $data->participating_categorie              = $participating_categorie;
        if(!empty($request->non_participating_categorie_type)){
            $data->non_participating_categorie_type     = $request->non_participating_categorie_type;
        }
        $data->non_participating_categorie          = $non_participating_categorie;
        $data->coupon_limit                         = $request->coupon_limit;
        $data->coupon_limit_people                  = $request->coupon_limit_people;
        $data->show                                 = $show;
        $data->updated_by                           = Auth::user()->displayname;
        $data->updated_at                           = date('Y-m-d H:i:s');

        if (!empty($request->coupon_img)) {

            if ($request->hasFile('coupon_img')) {
                @unlink(Storage::disk('public')->path('coupon/') . $request->coupon_img_old);

                $newFilename = uniqid() . '.' . $request->coupon_img->extension();
                $data->coupon_img = $newFilename;
                $file = $request->file('coupon_img');
                $file->move('storage/coupon/', $newFilename);
            }

        }

        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }

    public function status($id){

        $data = TbPromotionCoupon::findOrFail($id);

        if($data->show == 2){
            $status = 1;
        }elseif($data->show == 1) {
            $status = 2;
        }

        $data->show                         = $status;
        $data->updated_by                   = Auth::user()->displayname;
        $data->updated_at                   = date('Y-m-d H:i:s');
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');
    }

    public function delete(Request $request){

        TbPromotionCoupon::where('id', $request->deleteId)->delete();
        return back()->with('feedback', 'ลบข้อมูลเรียบร้อยแล้ว!');
    }

    public function jsondata()
    {

        $data = TbPromotionCoupon::get();

        return Datatables::of($data)
                ->addColumn('coupon_code', function ($data) {
                    return $data->coupon_code;
                })
                ->addColumn('coupon_name', function ($data) {

                    if(!empty($data->coupon_des)){
                        $coupon_des = '<br/>'.'<small>'.$data->coupon_des.'</small>';
                    }else{
                        $coupon_des = '';
                    }

                    return $data->coupon_name.''.$coupon_des;
                })
                ->addColumn('show', function ($data) {
                    return $data->show;
                })
                ->addColumn('updated', function ($data) {
                    return $data->created_at.'<br/><small><i class="fa fa-user"></i> '.$data->created_by.'</small>';
                })
                ->addColumn('actions', function ($data) {
                    $id = $data->id;
                    $status = $data->show;
                    $name = $data->coupon_code;
                    return view('admin.coupon.button', compact('id','status','name'));
                })
                ->escapeColumns([])
                ->addIndexColumn()
                ->make(true);
    }

    public function jsoncategorie(Request $request){

        $type = $request->type;
        $categorie = $request->categorie;

        if($type == 2){

            $categoryId = explode(",",$categorie);
            asort($categoryId);

            $data = TbCategorySub::select('id','categorysub_name','categorysub_show','categorysub_sort')->where('categorysub_show',1)->orderby('categorysub_sort','desc')->get();
            foreach($data as $category){

                $categorys[] = array(
                    'id' => $category->id,
                    'category_name' => $category->categorysub_name,
                    'selected' => $this->selectedCategory($category->id, $categoryId),
                );

            }

        }else{

            $categoryId = explode(",",$categorie);
            asort($categoryId);

            $data = TbCategory::select('id','category_name','category_show','category_sort')->where('category_show',1)->orderby('category_sort','desc')->get();
            foreach($data as $category){

                $categorys[] = array(
                    'id' => $category->id,
                    'category_name' => $category->category_name,
                    'selected' => $this->selectedCategory($category->id, $categoryId),
                );

            }

        }

        return $categorys;
    }

    private function selectedCategory($category,$categoryId){

        $key = in_array($category, $categoryId);
        if($key == true){
            $selected= 'selected';
        }else{
            $selected= '';
        }
        return $selected;

    }

    public function report($id){

        $breadcrumb = [
            ['name' => 'รายงานคูปอง'],
        ];
        $title_page = 'รายงานคูปอง';

        $data = TbPromotionCoupon::findOrFail($id);
        $month = TbSettingMonth::get();
        //จำนวนรวมที่มีการใช้คูปอง
        $totalCoupon = TbOrder::where('conditionName',$data->coupon_code)->count();
        
        return view('admin.coupon.report', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => $data,
            'totalCoupon' => $totalCoupon,
            'months' => $month,
        ]);


    }

    public function reportJson(Request $request)
    {

        $year = $request->Year;
        $coupon = $request->Coupon;

        $data = array(
            'countTotal' => number_format(TbOrder::select('conditionName','created_at')->where('conditionName',$coupon)->whereYear('created_at',$year)->count()),
            'month_01' => number_format(TbOrder::select('conditionName','created_at')->where('conditionName',$coupon)->whereMonth('created_at','01')->whereYear('created_at',$year)->count()),
            'month_02' => number_format(TbOrder::select('conditionName','created_at')->where('conditionName',$coupon)->whereMonth('created_at','02')->whereYear('created_at',$year)->count()),
            'month_03' => number_format(TbOrder::select('conditionName','created_at')->where('conditionName',$coupon)->whereMonth('created_at','03')->whereYear('created_at',$year)->count()),
            'month_04' => number_format(TbOrder::select('conditionName','created_at')->where('conditionName',$coupon)->whereMonth('created_at','04')->whereYear('created_at',$year)->count()),
            'month_05' => number_format(TbOrder::select('conditionName','created_at')->where('conditionName',$coupon)->whereMonth('created_at','05')->whereYear('created_at',$year)->count()),
            'month_06' => number_format(TbOrder::select('conditionName','created_at')->where('conditionName',$coupon)->whereMonth('created_at','06')->whereYear('created_at',$year)->count()),
            'month_07' => number_format(TbOrder::select('conditionName','created_at')->where('conditionName',$coupon)->whereMonth('created_at','07')->whereYear('created_at',$year)->count()),
            'month_08' => number_format(TbOrder::select('conditionName','created_at')->where('conditionName',$coupon)->whereMonth('created_at','08')->whereYear('created_at',$year)->count()),
            'month_09' => number_format(TbOrder::select('conditionName','created_at')->where('conditionName',$coupon)->whereMonth('created_at','09')->whereYear('created_at',$year)->count()),
            'month_10' => number_format(TbOrder::select('conditionName','created_at')->where('conditionName',$coupon)->whereMonth('created_at','10')->whereYear('created_at',$year)->count()),
            'month_11' => number_format(TbOrder::select('conditionName','created_at')->where('conditionName',$coupon)->whereMonth('created_at','11')->whereYear('created_at',$year)->count()),
            'month_12' => number_format(TbOrder::select('conditionName','created_at')->where('conditionName',$coupon)->whereMonth('created_at','12')->whereYear('created_at',$year)->count()),
        );

        return $data;
    }

}
