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

use App\Models\TbQuotationSetting;
use App\Models\TbQuotation;

use App\Models\TbSettingProvince;
use App\Models\TbSettingAmphure;
use App\Models\TbSettingDistrict;
use App\Models\User;
use App\Models\TbSettingMonth;
use App\Models\HistoryQuotationStatus;

class QuotationControlle extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $breadcrumb = [
            ['name' => 'ใบเสนอราคา'],
        ];
        $title_page = 'ใบเสนอราคา';
		
		// check access brand
		$current_user = Auth::user();
		$access_brand_id = $current_user->access_brand_id;
		
		if(!empty($access_brand_id)){
			
			if(strpos($access_brand_id, ',')){
				$access_brand_id = explode(',',trim($access_brand_id));
			}else{
				$access_brand_id = [$access_brand_id];
			}
			
			$count = TbQuotation::leftjoin('tb_product_detail','tb_quotation.productSku','tb_product_detail.detail_sku')
								->leftjoin('tb_product','tb_product_detail.proId','tb_product.id')
								->whereIn('tb_product.pro_brand',$access_brand_id)
								->count(DB::raw('DISTINCT tb_quotation.id'));
		}else{
			$count = TbQuotation::count();
		}

        return view('admin.quotation.main', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => '',
            'count' => $count,
        ]);

    }

    public function jsondata()
    {
		// check access brand
		$current_user = Auth::user();
		$access_brand_id = $current_user->access_brand_id;
		
		if(!empty($access_brand_id)){
			
			if(strpos($access_brand_id, ',')){
				$access_brand_id = explode(',',trim($access_brand_id));
			}else{
				$access_brand_id = [$access_brand_id];
			}
			
			$quotation = TbQuotation::select('tb_quotation.*')
								->leftjoin('tb_product_detail','tb_quotation.productSku','tb_product_detail.detail_sku')
								->leftjoin('tb_product','tb_product_detail.proId','tb_product.id')
								->whereIn('tb_product.pro_brand',$access_brand_id)
								->groupBy('tb_quotation.id')
								->get();
		}else{
			$quotation = TbQuotation::get();
		}

        return Datatables::of($quotation)
                ->addColumn('quotationNumber', function ($quotation) {
                    return '<a href="'.route('quotation.preview',$quotation->id).'">'.$quotation->quotationNumber.'</a>';
                })
                ->addColumn('quotationDate', function ($quotation) {
                    return '<div class="c-success">'.$quotation->quotationDate.'</div>';
                })
                ->addColumn('quotationDateExp', function ($quotation) {
                    if(!empty($quotation->quotationDateExp)){
                        return '<div class="required">'.$quotation->quotationDateExp.'</div>';
                    }else{
                        return '<div class="">-</div>';
                    }
                })
                ->addColumn('type', function ($quotation) {
                    if($quotation->type == 1){
                        return '<div class="badge badge-info">บุคคลธรรมดา</div>';
                    }else{
                        return '<div class="badge badge-primary">บริษัท/สำนักงาน/องค์กร</div>';
                    }
                })
                ->addColumn('quotationFullname', function ($quotation) {

                    if($quotation->type == 2){
                        $status = 'บริษัท/สำนักงาน/องค์กร';
                    }else{
                        $status = 'บุคคลธรรมดา';
                    }
                    return $quotation->name.' '.$quotation->lastname.'<br/><small>('.$status.')</small>';
                })
                ->addColumn('quotationContact', function ($quotation) {
                    return $quotation->tel.'<br/>'.$quotation->email;
                })
                ->addColumn('productTotal', function ($quotation) {
                    return number_format($quotation->productTotal,2);
                })
                ->addColumn('quotationStatus', function ($quotation) {
                    if(!empty($quotation->productName)){
                        return 1;
                    }else{
                        return 2;
                    }
                })
                ->escapeColumns([])
                ->make(true);
    }

    public function setting(){

        $breadcrumb = [
            ['name' => 'ตั้งค่าขอใบเสนอราคา'],
        ];
        $title_page = 'ตั้งค่าขอใบเสนอราคา';

        $data    = TbQuotationSetting::first();

        return view('admin.quotation.setting', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => $data,
        ]);

    }

    public function settingCrate(Request $request){

        $request->validate(
            [
                'tax_id' => 'required|max:255',
                'company_name' => 'required|max:255',
                'company_address' => 'required',
                'company_tel' => 'required|max:255',
                'company_fax' => 'max:255',
            ],
            [
                'tax_id.required' => 'กรุณากรอกข้อมูล',
                'tax_id.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'company_name.required' => 'กรุณากรอกข้อมูล',
                'company_name.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'company_address.required' => 'กรุณากรอกข้อมูล',
                'company_tel.required' => 'กรุณากรอกข้อมูล',
                'company_tel.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'company_fax.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
            ]
        );

        if($request->show == 'on'){
            $show = 1;
        }else{
            $show = 2;
        }

        $data = new TbQuotationSetting;
        $data->tax_id                    = $request->tax_id;
        $data->company_name              = $request->company_name;
        $data->company_address           = $request->company_address;
        $data->company_tel               = $request->company_tel;
        $data->company_fax               = $request->company_fax;
        $data->quotation_note            = $request->quotation_note;
        $data->quotation_transfer        = $request->quotation_transfer;
        $data->quotation_payment         = $request->quotation_payment;
        $data->company_vat               = $request->company_vat;
        $data->company_withheld          = $request->company_withheld;
        $data->show                      = $show;
        $data->created_by                = Auth::user()->displayname;
        $data->updated_by                = Auth::user()->displayname;
        $data->created_at                = date('Y-m-d H:i:s');
        $data->updated_at                = date('Y-m-d H:i:s');

        if (!empty($request->logo_company)) {

            if ($request->hasFile('logo_company')) {
                $newFilename = uniqid() . '.' . $request->logo_company->extension();
                $data->logo_company = $newFilename;
                $file = $request->file('logo_company');
                $file->move('storage/setting/', $newFilename);
            }

        }

        $data->save();

        return back()->with('feedback', 'เพิ่มข้อมูลเรียบร้อยแล้ว!');

    }

    public function settingUpdate(Request $request,$id){

        $request->validate(
            [
                'tax_id' => 'required|max:255',
                'company_name' => 'required|max:255',
                'company_address' => 'required',
                'company_tel' => 'required|max:255',
                'company_fax' => 'max:255',
            ],
            [
                'tax_id.required' => 'กรุณากรอกข้อมูล',
                'tax_id.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'company_name.required' => 'กรุณากรอกข้อมูล',
                'company_name.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'company_address.required' => 'กรุณากรอกข้อมูล',
                'company_tel.required' => 'กรุณากรอกข้อมูล',
                'company_tel.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'company_fax.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
            ]
        );

        if($request->show == 'on'){
            $show = 1;
        }else{
            $show = 2;
        }

        $data = TbQuotationSetting::findOrfail($id);
        $data->tax_id                    = $request->tax_id;
        $data->company_name              = $request->company_name;
        $data->company_address           = $request->company_address;
        $data->company_tel               = $request->company_tel;
        $data->company_fax               = $request->company_fax;
        $data->quotation_note            = $request->quotation_note;
        $data->quotation_transfer        = $request->quotation_transfer;
        $data->quotation_payment         = $request->quotation_payment;
        $data->company_vat               = $request->company_vat;
        $data->company_withheld          = $request->company_withheld;
        $data->show                      = $show;
        $data->updated_by                = Auth::user()->displayname;
        $data->updated_at                = date('Y-m-d H:i:s');

        if (!empty($request->logo_company)) {

            if ($request->hasFile('logo_company')) {
                @unlink(Storage::disk('public')->path('setting/') . $request->logo_company_old);

                $newFilename = uniqid() . '.' . $request->logo_company->extension();
                $data->logo_company = $newFilename;
                $file = $request->file('logo_company');
                $file->move('storage/setting/', $newFilename);
            }

        }
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }

    public function preview($id){

        $breadcrumb = [
            ['name' => 'ใบเสนอราคา'],
        ];
        $title_page = 'ใบเสนอราคา';

        $setting    = TbQuotationSetting::first();
        $data       = TbQuotation::with('history_quotations')->findOrFail($id);
        $provinces  = TbSettingProvince::where('id',$data->province)->value('prov_name_th');
        $amphoes    = TbSettingAmphure::where('id',$data->amphures)->value('amp_name_th');
        $district   = TbSettingDistrict::where('id',$data->district)->value('dis_name_th');
		
		$users = User::select(
			'users.level','users.name','users.lastname','users.id',
			'tb_level.number'
		)
		->leftjoin('tb_level','tb_level.id','users.level')
		->whereIn('tb_level.number',array('2','8'))
		->get();

        return view('admin.quotation.preview', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => $data,
            'setting' => $setting,
            'provinces' => $provinces,
            'amphoes' => $amphoes,
            'district' => $district,
            'users' => $users,
        ]);

    }

    public function updateStaff(Request $request,$id){

        $request->validate(
            [
                'staff' => 'required',
            ],
            [
                'staff.required' => 'กรุณาเลือกข้อมูล',
            ]
        );

        $update                         = TbQuotation::findOrFail($id);
        $update->staffId                = $request->staff;
        $update->updated_by             = Auth::user()->displayname;
        $update->updated_at             = date('Y-m-d H:i:s');
        $update->save();

        $users = User::select('users.name','users.lastname')->findOrFail($request->staff);

        $history = new HistoryQuotationStatus();
        $history->quotationId           = $id;
        $history->remark                = 'อัพเดตพนักงานที่รับผิดชอบ : '.$users->name.' '.$users->lastname;
        $history->created_by            = Auth::user()->displayname;
        $history->created_at            = date('Y-m-d H:i:s');
        $history->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }

    public function report(){

        $breadcrumb = [
            ['name' => 'รายงานใบเสนอราคา'],
        ];
        $title_page = 'รายงานใบเสนอราคา';

        $yearNow    = date('Y');
        $monthNow   = date('m');
		
		// check access brand
		$current_user = Auth::user();
		$access_brand_id = $current_user->access_brand_id;
		
		if(!empty($access_brand_id)){
			
			if(strpos($access_brand_id, ',')){
				$access_brand_id = explode(',',trim($access_brand_id));
			}else{
				$access_brand_id = [$access_brand_id];
			}
			
			$count = TbQuotation::leftjoin('tb_product_detail','tb_quotation.productSku','tb_product_detail.detail_sku')
								->leftjoin('tb_product','tb_product_detail.proId','tb_product.id')
								->whereIn('tb_product.pro_brand',$access_brand_id)
								->count(DB::raw('DISTINCT tb_quotation.id'));
			$type1 = TbQuotation::leftjoin('tb_product_detail','tb_quotation.productSku','tb_product_detail.detail_sku')
								->leftjoin('tb_product','tb_product_detail.proId','tb_product.id')
								->whereIn('tb_product.pro_brand',$access_brand_id)
								->where('tb_quotation.type',1)
								->whereYear('tb_quotation.created_at',$yearNow)
								->count(DB::raw('DISTINCT tb_quotation.id'));
			$type2 = TbQuotation::leftjoin('tb_product_detail','tb_quotation.productSku','tb_product_detail.detail_sku')
								->leftjoin('tb_product','tb_product_detail.proId','tb_product.id')
								->whereIn('tb_product.pro_brand',$access_brand_id)
								->where('tb_quotation.type',2)
								->whereYear('tb_quotation.created_at',$yearNow)
								->count(DB::raw('DISTINCT tb_quotation.id'));
			$contact = TbQuotation::leftjoin('tb_product_detail','tb_quotation.productSku','tb_product_detail.detail_sku')
								->leftjoin('tb_product','tb_product_detail.proId','tb_product.id')
								->whereIn('tb_product.pro_brand',$access_brand_id)
								->orWhereNull('tb_quotation.productSku')
								->whereYear('tb_quotation.created_at',$yearNow)
								->count(DB::raw('DISTINCT tb_quotation.id'));
			$dowload = TbQuotation::leftjoin('tb_product_detail','tb_quotation.productSku','tb_product_detail.detail_sku')
								->leftjoin('tb_product','tb_product_detail.proId','tb_product.id')
								->whereIn('tb_product.pro_brand',$access_brand_id)
								->orWhereNotNull('tb_quotation.productSku')
								->whereYear('tb_quotation.created_at',$yearNow)
								->count(DB::raw('DISTINCT tb_quotation.id'));
			$totalYear = TbQuotation::leftjoin('tb_product_detail','tb_quotation.productSku','tb_product_detail.detail_sku')
								->leftjoin('tb_product','tb_product_detail.proId','tb_product.id')
								->whereIn('tb_product.pro_brand',$access_brand_id)
								->whereYear('tb_quotation.created_at',$yearNow)
								->count(DB::raw('DISTINCT tb_quotation.id'));
			$totalMonth = TbQuotation::leftjoin('tb_product_detail','tb_quotation.productSku','tb_product_detail.detail_sku')
								->leftjoin('tb_product','tb_product_detail.proId','tb_product.id')
								->whereIn('tb_product.pro_brand',$access_brand_id)
								->whereMonth('tb_quotation.created_at',$monthNow)
								->whereYear('tb_quotation.created_at',$yearNow)
								->count(DB::raw('DISTINCT tb_quotation.id'));
								
		}else{
			$count      = TbQuotation::count();
			$type1      = TbQuotation::where('type',1)->whereYear('created_at',$yearNow)->count();
			$type2      = TbQuotation::where('type',2)->whereYear('created_at',$yearNow)->count();
			$contact    = TbQuotation::orWhereNull('productSku')->whereYear('created_at',$yearNow)->count();
			$dowload    = TbQuotation::orWhereNotNull('productSku')->whereYear('created_at',$yearNow)->count();
			$totalYear  = TbQuotation::whereYear('created_at',$yearNow)->count();
			$totalMonth = TbQuotation::whereMonth('created_at',$monthNow)->whereYear('created_at',$yearNow)->count();
		}

        return view('admin.quotation.report', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => '',
            'count' => $count,
            'Type1' => $type1,
            'Type2' => $type2,
            'contact' => $contact,
            'dowload' => $dowload,
            'totalYear' => $totalYear,
            'totalMonth' => $totalMonth,
        ]);

    }

    public function jsonaverage(Request $request){

        if(!empty($request)){
            $year = $request->Year;
        }else{
            $year = date('Y');
        }
        $monthNow   = date('m');
		$month = $request->Month ?? null;
		
		// check access brand
		$current_user = Auth::user();
		$access_brand_id = $current_user->access_brand_id;
		
		if(!empty($access_brand_id)){
			
			if(strpos($access_brand_id, ',')){
				$access_brand_id = explode(',',trim($access_brand_id));
			}else{
				$access_brand_id = [$access_brand_id];
			}
			
			$result_01 = TbQuotation::select('tb_quotation.created_at')
								->leftjoin('tb_product_detail','tb_quotation.productSku','tb_product_detail.detail_sku')
								->leftjoin('tb_product','tb_product_detail.proId','tb_product.id')
								->whereIn('tb_product.pro_brand',$access_brand_id)
								->whereMonth('tb_quotation.created_at','01')
								->whereYear('tb_quotation.created_at',$year)
								->count(DB::raw('DISTINCT tb_quotation.id'));
			$result_02 = TbQuotation::select('tb_quotation.created_at')
								->leftjoin('tb_product_detail','tb_quotation.productSku','tb_product_detail.detail_sku')
								->leftjoin('tb_product','tb_product_detail.proId','tb_product.id')
								->whereIn('tb_product.pro_brand',$access_brand_id)
								->whereMonth('tb_quotation.created_at','02')
								->whereYear('tb_quotation.created_at',$year)
								->count(DB::raw('DISTINCT tb_quotation.id'));
			$result_03 = TbQuotation::select('tb_quotation.created_at')
								->leftjoin('tb_product_detail','tb_quotation.productSku','tb_product_detail.detail_sku')
								->leftjoin('tb_product','tb_product_detail.proId','tb_product.id')
								->whereIn('tb_product.pro_brand',$access_brand_id)
								->whereMonth('tb_quotation.created_at','03')
								->whereYear('tb_quotation.created_at',$year)
								->count(DB::raw('DISTINCT tb_quotation.id'));
			$result_04 = TbQuotation::select('tb_quotation.created_at')
								->leftjoin('tb_product_detail','tb_quotation.productSku','tb_product_detail.detail_sku')
								->leftjoin('tb_product','tb_product_detail.proId','tb_product.id')
								->whereIn('tb_product.pro_brand',$access_brand_id)
								->whereMonth('tb_quotation.created_at','04')
								->whereYear('tb_quotation.created_at',$year)
								->count(DB::raw('DISTINCT tb_quotation.id'));
			$result_05 = TbQuotation::select('tb_quotation.created_at')
								->leftjoin('tb_product_detail','tb_quotation.productSku','tb_product_detail.detail_sku')
								->leftjoin('tb_product','tb_product_detail.proId','tb_product.id')
								->whereIn('tb_product.pro_brand',$access_brand_id)
								->whereMonth('tb_quotation.created_at','05')
								->whereYear('tb_quotation.created_at',$year)
								->count(DB::raw('DISTINCT tb_quotation.id'));
			$result_06 = TbQuotation::select('tb_quotation.created_at')
								->leftjoin('tb_product_detail','tb_quotation.productSku','tb_product_detail.detail_sku')
								->leftjoin('tb_product','tb_product_detail.proId','tb_product.id')
								->whereIn('tb_product.pro_brand',$access_brand_id)
								->whereMonth('tb_quotation.created_at','06')
								->whereYear('tb_quotation.created_at',$year)
								->count(DB::raw('DISTINCT tb_quotation.id'));
			$result_07 = TbQuotation::select('tb_quotation.created_at')
								->leftjoin('tb_product_detail','tb_quotation.productSku','tb_product_detail.detail_sku')
								->leftjoin('tb_product','tb_product_detail.proId','tb_product.id')
								->whereIn('tb_product.pro_brand',$access_brand_id)
								->whereMonth('tb_quotation.created_at','07')
								->whereYear('tb_quotation.created_at',$year)
								->count(DB::raw('DISTINCT tb_quotation.id'));
			$result_08 = TbQuotation::select('tb_quotation.created_at')
								->leftjoin('tb_product_detail','tb_quotation.productSku','tb_product_detail.detail_sku')
								->leftjoin('tb_product','tb_product_detail.proId','tb_product.id')
								->whereIn('tb_product.pro_brand',$access_brand_id)
								->whereMonth('tb_quotation.created_at','08')
								->whereYear('tb_quotation.created_at',$year)
								->count(DB::raw('DISTINCT tb_quotation.id'));
			$result_09 = TbQuotation::select('tb_quotation.created_at')
								->leftjoin('tb_product_detail','tb_quotation.productSku','tb_product_detail.detail_sku')
								->leftjoin('tb_product','tb_product_detail.proId','tb_product.id')
								->whereIn('tb_product.pro_brand',$access_brand_id)
								->whereMonth('tb_quotation.created_at','09')
								->whereYear('tb_quotation.created_at',$year)
								->count(DB::raw('DISTINCT tb_quotation.id'));
			$result_10 = TbQuotation::select('tb_quotation.created_at')
								->leftjoin('tb_product_detail','tb_quotation.productSku','tb_product_detail.detail_sku')
								->leftjoin('tb_product','tb_product_detail.proId','tb_product.id')
								->whereIn('tb_product.pro_brand',$access_brand_id)
								->whereMonth('tb_quotation.created_at','10')
								->whereYear('tb_quotation.created_at',$year)
								->count(DB::raw('DISTINCT tb_quotation.id'));
			$result_11 = TbQuotation::select('tb_quotation.created_at')
								->leftjoin('tb_product_detail','tb_quotation.productSku','tb_product_detail.detail_sku')
								->leftjoin('tb_product','tb_product_detail.proId','tb_product.id')
								->whereIn('tb_product.pro_brand',$access_brand_id)
								->whereMonth('tb_quotation.created_at','11')
								->whereYear('tb_quotation.created_at',$year)
								->count(DB::raw('DISTINCT tb_quotation.id'));
			$result_12 = TbQuotation::select('tb_quotation.created_at')
								->leftjoin('tb_product_detail','tb_quotation.productSku','tb_product_detail.detail_sku')
								->leftjoin('tb_product','tb_product_detail.proId','tb_product.id')
								->whereIn('tb_product.pro_brand',$access_brand_id)
								->whereMonth('tb_quotation.created_at','12')
								->whereYear('tb_quotation.created_at',$year)
								->count(DB::raw('DISTINCT tb_quotation.id'));
								
			$total = TbQuotation::select('tb_quotation.created_at')
								->leftjoin('tb_product_detail','tb_quotation.productSku','tb_product_detail.detail_sku')
								->leftjoin('tb_product','tb_product_detail.proId','tb_product.id')
								->whereIn('tb_product.pro_brand',$access_brand_id)
								->whereYear('tb_quotation.created_at',$year)
								->when($month, function($query, $month) {
									return $query->whereMonth('tb_quotation.created_at', $month);
								})
								->count(DB::raw('DISTINCT tb_quotation.id'));
								
			$contact = TbQuotation::leftjoin('tb_product_detail','tb_quotation.productSku','tb_product_detail.detail_sku')
								->leftjoin('tb_product','tb_product_detail.proId','tb_product.id')
								->whereIn('tb_product.pro_brand',$access_brand_id)
								->orWhereNull('tb_quotation.productSku')
								->whereYear('tb_quotation.created_at',$year)
								->when($month, function($query, $month) {
									return $query->whereMonth('tb_quotation.created_at', $month);
								})
								->count(DB::raw('DISTINCT tb_quotation.id'));
								
			$dowload = TbQuotation::leftjoin('tb_product_detail','tb_quotation.productSku','tb_product_detail.detail_sku')
								->leftjoin('tb_product','tb_product_detail.proId','tb_product.id')
								->whereIn('tb_product.pro_brand',$access_brand_id)
								->orWhereNotNull('tb_quotation.productSku')
								->whereYear('tb_quotation.created_at',$year)
								->when($month, function($query, $month) {
									return $query->whereMonth('tb_quotation.created_at', $month);
								})
								->count(DB::raw('DISTINCT tb_quotation.id'));
			
			$totalMonth = TbQuotation::leftjoin('tb_product_detail','tb_quotation.productSku','tb_product_detail.detail_sku')
								->leftjoin('tb_product','tb_product_detail.proId','tb_product.id')
								->whereIn('tb_product.pro_brand',$access_brand_id)
								->whereYear('tb_quotation.created_at',$year)
								->when($month, function($query, $month) {
									return $query->whereMonth('tb_quotation.created_at', $month);
								})
								->count(DB::raw('DISTINCT tb_quotation.id'));
								
			$type1 = TbQuotation::leftjoin('tb_product_detail','tb_quotation.productSku','tb_product_detail.detail_sku')
								->leftjoin('tb_product','tb_product_detail.proId','tb_product.id')
								->whereIn('tb_product.pro_brand',$access_brand_id)
								->where('tb_quotation.type',1)
								->whereYear('tb_quotation.created_at',$year)
								->when($month, function($query, $month) {
									return $query->whereMonth('tb_quotation.created_at', $month);
								})
								->count(DB::raw('DISTINCT tb_quotation.id'));
								
			$type2 = TbQuotation::leftjoin('tb_product_detail','tb_quotation.productSku','tb_product_detail.detail_sku')
								->leftjoin('tb_product','tb_product_detail.proId','tb_product.id')
								->whereIn('tb_product.pro_brand',$access_brand_id)
								->where('tb_quotation.type',2)
								->whereYear('tb_quotation.created_at',$year)
								->when($month, function($query, $month) {
									return $query->whereMonth('tb_quotation.created_at', $month);
								})
								->count(DB::raw('DISTINCT tb_quotation.id'));
								
		}else{
			$result_01 = TbQuotation::select('created_at')->whereMonth('created_at','01')->whereYear('created_at',$year)->count();
			$result_02 = TbQuotation::select('created_at')->whereMonth('created_at','02')->whereYear('created_at',$year)->count();
			$result_03 = TbQuotation::select('created_at')->whereMonth('created_at','03')->whereYear('created_at',$year)->count();
			$result_04 = TbQuotation::select('created_at')->whereMonth('created_at','04')->whereYear('created_at',$year)->count();
			$result_05 = TbQuotation::select('created_at')->whereMonth('created_at','05')->whereYear('created_at',$year)->count();
			$result_06 = TbQuotation::select('created_at')->whereMonth('created_at','06')->whereYear('created_at',$year)->count();
			$result_07 = TbQuotation::select('created_at')->whereMonth('created_at','07')->whereYear('created_at',$year)->count();
			$result_08 = TbQuotation::select('created_at')->whereMonth('created_at','08')->whereYear('created_at',$year)->count();
			$result_09 = TbQuotation::select('created_at')->whereMonth('created_at','09')->whereYear('created_at',$year)->count();
			$result_10 = TbQuotation::select('created_at')->whereMonth('created_at','10')->whereYear('created_at',$year)->count();
			$result_11 = TbQuotation::select('created_at')->whereMonth('created_at','11')->whereYear('created_at',$year)->count();
			$result_12 = TbQuotation::select('created_at')->whereMonth('created_at','12')->whereYear('created_at',$year)->count();

			$total = TbQuotation::select('created_at')->whereYear('created_at',$year)->when($month, function($query, $month){ return $query->whereMonth('created_at', $month); })->count();

			$contact    = TbQuotation::orWhereNull('productSku')->whereYear('created_at',$year)->when($month, function($query, $month){ return $query->whereMonth('created_at', $month); })->count();
			$dowload    = TbQuotation::orWhereNotNull('productSku')->whereYear('created_at',$year)->when($month, function($query, $month){ return $query->whereMonth('created_at', $month); })->count();
			$totalMonth = TbQuotation::whereYear('created_at',$year)->when($month, function($query, $month){ return $query->whereMonth('created_at', $month); })->count();
			$type1      = TbQuotation::where('type',1)->whereYear('created_at',$year)->when($month, function($query, $month){ return $query->whereMonth('created_at', $month); })->count();
			$type2      = TbQuotation::where('type',2)->whereYear('created_at',$year)->when($month, function($query, $month){ return $query->whereMonth('created_at', $month); })->count();
		}

        $response[] = array(
            'result_01'=>number_format($result_01),
            'result_02'=>number_format($result_02),
            'result_03'=>number_format($result_03),
            'result_04'=>number_format($result_04),
            'result_05'=>number_format($result_05),
            'result_06'=>number_format($result_06),
            'result_07'=>number_format($result_07),
            'result_08'=>number_format($result_08),
            'result_09'=>number_format($result_09),
            'result_10'=>number_format($result_10),
            'result_11'=>number_format($result_11),
            'result_12'=>number_format($result_12),
            'total'=>number_format($total),
            'contact'=>number_format($contact),
            'dowload'=>number_format($dowload),
            'totalMonth'=>number_format($totalMonth),
            'type1'=>number_format($type1),
            'type2'=>number_format($type2)
        );
        return $response;

    }

    public function reportProduct(){
        $breadcrumb = [
            ['name' => 'รายงานสินค้าที่ถูกขอใบเสนอราคา'],
        ];
        $title_page = 'รายงานสินค้าที่ถูกขอใบเสนอราคา';
		
		// check access brand
		$current_user = Auth::user();
		$access_brand_id = $current_user->access_brand_id;
		
		if(!empty($access_brand_id)){
			
			if(strpos($access_brand_id, ',')){
				$access_brand_id = explode(',',trim($access_brand_id));
			}else{
				$access_brand_id = [$access_brand_id];
			}
			
			$productTotal 	 = TbQuotation::leftjoin('tb_product_detail','tb_quotation.productSku','tb_product_detail.detail_sku')
								->leftjoin('tb_product','tb_product_detail.proId','tb_product.id')
								->whereIn('tb_product.pro_brand',$access_brand_id)
								->orWhereNotNull('productSku')
								->count(DB::raw('DISTINCT tb_quotation.id'));
		}else{
			$productTotal    = TbQuotation::orWhereNotNull('productSku')->count();
		}

        return view('admin.quotation.maxQuotation', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'productTotal' => $productTotal,
            'data' => '',
        ]);
    }

    public function quotationMaxQuotation(Request $request){

        $month = $request->get('month');
        $year = $request->get('year');

        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search = $request->get('search');
        $order = $request->get('order');

        $columnorder = array(
            'code',
            'fullname',
            'total',
        );

        if (empty($order)) {
            $sort = 'created_at';
            $dir = 'desc';
        } else {
            $sort = $columnorder[$order[0]['column']];
            $dir = $order[0]['dir'];
        }
		
		// check access brand
		$current_user = Auth::user();
		$access_brand_id = $current_user->access_brand_id;
		
		if(!empty($access_brand_id)){
			
			if(strpos($access_brand_id, ',')){
				$access_brand_id = explode(',',trim($access_brand_id));
			}else{
				$access_brand_id = [$access_brand_id];
			}
			
			$data = TbQuotation::select(DB::raw('SUM(tb_quotation.productTotal) as Total', 'tb_quotation.productTotal'),'tb_quotation.created_at','tb_quotation.productSku','tb_quotation.productName')
					->leftjoin('tb_product_detail','tb_quotation.productSku','tb_product_detail.detail_sku')
					->leftjoin('tb_product','tb_product_detail.proId','tb_product.id')
					->whereIn('tb_product.pro_brand',$access_brand_id)
					->when($month, function ($query, $month) {
						if(!empty($month)){
							return $query->whereMonth('tb_quotation.created_at',$month);
						}
					})
					->when($year, function ($query, $year) {
						if(!empty($year)){
							return $query->whereYear('tb_quotation.created_at',$year);
						}
					})
					->groupBy('tb_quotation.productSku')
					->orderBy('Total','desc')
					->get();
					
			$recordsTotal = TbQuotation::select(DB::raw('SUM(tb_quotation.productTotal) as Total', 'tb_quotation.productTotal'),'tb_quotation.created_at','tb_quotation.productSku','tb_quotation.productName')
							->leftjoin('tb_product_detail','tb_quotation.productSku','tb_product_detail.detail_sku')
							->leftjoin('tb_product','tb_product_detail.proId','tb_product.id')
							->whereIn('tb_product.pro_brand',$access_brand_id)
							->when($month, function ($query, $month) {
								if(!empty($month)){
									return $query->whereMonth('tb_quotation.created_at',$month);
								}
							})
							->when($year, function ($query, $year) {
								if(!empty($year)){
									return $query->whereYear('tb_quotation.created_at',$year);
								}
							})
							->groupBy('tb_quotation.productSku')
							->count();
			
			$recordsFiltered = TbQuotation::select(DB::raw('SUM(tb_quotation.productTotal) as Total', 'tb_quotation.productTotal'),'tb_quotation.created_at','tb_quotation.productSku','tb_quotation.productName')
								->leftjoin('tb_product_detail','tb_quotation.productSku','tb_product_detail.detail_sku')
								->leftjoin('tb_product','tb_product_detail.proId','tb_product.id')
								->whereIn('tb_product.pro_brand',$access_brand_id)
								->when($month, function ($query, $month) {
									if(!empty($month)){
										return $query->whereMonth('tb_quotation.created_at',$month);
									}
								})
								->when($year, function ($query, $year) {
									if(!empty($year)){
										return $query->whereYear('tb_quotation.created_at',$year);
									}
								})
								->groupBy('tb_quotation.productSku')
								->count();
			
		}else{
			$data = TbQuotation::select(DB::raw('SUM(productTotal) as Total', 'productTotal'),'created_at','productSku','productName')
					->when($month, function ($query, $month) {
						if(!empty($month)){
							return $query->whereMonth('created_at',$month);
						}
					})
					->when($year, function ($query, $year) {
						if(!empty($year)){
							return $query->whereYear('created_at',$year);
						}
					})
					->groupBy('productSku')
					->orderBy('Total','desc')
					->get();

			$recordsTotal = TbQuotation::select(DB::raw('SUM(productTotal) as Total', 'productTotal'),'created_at','productSku','productName')
							->when($month, function ($query, $month) {
								if(!empty($month)){
									return $query->whereMonth('created_at',$month);
								}
							})
							->when($year, function ($query, $year) {
								if(!empty($year)){
									return $query->whereYear('created_at',$year);
								}
							})
							->groupBy('productSku')
							->count();

			$recordsFiltered = TbQuotation::select(DB::raw('SUM(productTotal) as Total', 'productTotal'),'created_at','productSku','productName')
								->when($month, function ($query, $month) {
									if(!empty($month)){
										return $query->whereMonth('created_at',$month);
									}
								})
								->when($year, function ($query, $year) {
									if(!empty($year)){
										return $query->whereYear('created_at',$year);
									}
								})
								->groupBy('productSku')
								->count();
		}        

        return Datatables::of($data)
            ->addColumn('code', function ($data) {
                return $data->productSku;
            })
            ->addColumn('fullname', function ($data) {
                return $data->productName;
            })
            ->addColumn('total', function ($data) {
                return number_format($data->Total,2);
            })
            ->setTotalRecords($recordsTotal)
            ->setFilteredRecords($recordsFiltered)
            ->escapeColumns([])
            ->skipPaging()
            ->addIndexColumn()
            ->make(true);

    }
}
