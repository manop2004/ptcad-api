<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Providers\RouteServiceProvider;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use PDF;
use App\Models\TbSettingPaymentStatus;
use App\Models\TbOrder;
use App\Models\User;
use App\Models\HistoryOrderStatus;
use App\Models\TbSettingTransport;
use App\Models\TbSetting;
use App\Models\HistorySendMail;
use App\Models\TbPagesMap;
use App\Models\TbSoftware;
use App\Models\TbSoftwareNotify;
use App\Mail\orderNotify;
use App\Mail\orderToStaff;

class OrderController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $breadcrumb = [
            ['name' => 'ออเดอร์'],
        ];
        $title_page = 'ออเดอร์';
		
		$users = User::select(
            'users.level','users.name','users.lastname','users.id',
            'tb_level.number'
        )
        ->leftjoin('tb_level','tb_level.id','users.level')
        ->whereIn('tb_level.number',array('2','8'))
        ->get();
		
		// check access brand
		$current_user = Auth::user();
		$access_brand_id = $current_user->access_brand_id;
		
		if(!empty($access_brand_id)){
			
			if(strpos($access_brand_id, ',')){
				$access_brand_id = explode(',',trim($access_brand_id));
			}else{
				$access_brand_id = [$access_brand_id];
			}
			
			$count = TbOrder::leftjoin('tb_order_detail','tb_order.id','tb_order_detail.orderId')
							->leftjoin('tb_product_detail','tb_order_detail.product_sku','tb_product_detail.detail_sku')
							->leftjoin('tb_product','tb_product_detail.proId','tb_product.id')
							->whereIn('tb_product.pro_brand',$access_brand_id)
							->count(DB::raw('DISTINCT tb_order.id'));
		}else{
			$count = TbOrder::count();
		}

        $pageMaps = TbPagesMap::first();
        $statusPayments = TbSettingPaymentStatus::where('show',1)->get();

        return view('admin.order.main', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'count' => $count,
            'users' => $users,
            'pageMaps' => $pageMaps,
            'statusPayments' => $statusPayments,
            'data' => '',
        ]);

    }

    public function report() {

		$breadcrumb = [
			['name' => 'รายงานออเดอร์'],
		];
		$title_page = 'รายงานออเดอร์';

		$current_user = Auth::user();
		$access_brand_id = $current_user->access_brand_id;

		if(!empty($access_brand_id)){

			if(strpos($access_brand_id, ',')){
				$access_brand_id = explode(',',trim($access_brand_id));
			}else{
				$access_brand_id = [$access_brand_id];
			}

			// ======= ยอดขายวันนี้ =======
			$orderToday = TbOrder::leftjoin('tb_order_detail','tb_order.id','tb_order_detail.orderId')
				->leftjoin('tb_product_detail','tb_order_detail.product_sku','tb_product_detail.detail_sku')
				->leftjoin('tb_product','tb_product_detail.proId','tb_product.id')
				->leftjoin('tb_order_payment','tb_order_payment.orderId','tb_order.id')
				->leftjoin('tb_setting_payment_status', 'tb_setting_payment_status.id', '=', 'tb_order.payment_status')
				->whereIn('tb_product.pro_brand', $access_brand_id)
				->where('tb_setting_payment_status.status_value', 1)
				->whereDate('tb_order.created_at', Carbon::today())
				->sum('tb_order.totalCart');

			// ======= ชำระเงินแล้ว (Paid) =======
			$orderWait = TbOrder::leftjoin('tb_order_detail','tb_order.id','tb_order_detail.orderId')
				->leftjoin('tb_product_detail','tb_order_detail.product_sku','tb_product_detail.detail_sku')
				->leftjoin('tb_product','tb_product_detail.proId','tb_product.id')
				->leftjoin('tb_setting_payment_status', 'tb_setting_payment_status.id', '=', 'tb_order.payment_status')
				->whereIn('tb_product.pro_brand', $access_brand_id)
				->where('tb_setting_payment_status.status_value', 1)
				->sum('tb_order.totalCart');

			// ======= ค้างชำระ (Pending) =======
			$orderList = TbOrder::leftjoin('tb_order_detail','tb_order.id','tb_order_detail.orderId')
				->leftjoin('tb_product_detail','tb_order_detail.product_sku','tb_product_detail.detail_sku')
				->leftjoin('tb_product','tb_product_detail.proId','tb_product.id')
				->leftjoin('tb_setting_payment_status', 'tb_setting_payment_status.id', '=', 'tb_order.payment_status')
				->whereIn('tb_product.pro_brand', $access_brand_id)
				->where('tb_setting_payment_status.status_value', 2)
				->sum('tb_order.totalCart');

			// ======= ยอดขายสำเร็จทั้งหมด =======
			$orderAll = TbOrder::leftjoin('tb_order_detail','tb_order.id','tb_order_detail.orderId')
				->leftjoin('tb_product_detail','tb_order_detail.product_sku','tb_product_detail.detail_sku')
				->leftjoin('tb_product','tb_product_detail.proId','tb_product.id')
				->whereIn('tb_product.pro_brand', $access_brand_id)
				->sum('tb_order.totalCart');

			// ======= นับจำนวนออเดอร์ทั้งหมด (distinct id) =======
			$order = TbOrder::leftjoin('tb_order_detail','tb_order.id','tb_order_detail.orderId')
				->leftjoin('tb_product_detail','tb_order_detail.product_sku','tb_product_detail.detail_sku')
				->leftjoin('tb_product','tb_product_detail.proId','tb_product.id')
				->whereIn('tb_product.pro_brand', $access_brand_id)
				->count(DB::raw('DISTINCT tb_order.id'));
		} else {
			$orderToday = TbOrder::leftjoin('tb_order_payment','tb_order_payment.orderId','tb_order.id')
				->leftjoin('tb_setting_payment_status', 'tb_setting_payment_status.id', '=', 'tb_order.payment_status')
				->where('tb_setting_payment_status.status_value', 1)
				->whereDate('tb_order.created_at', Carbon::today())
				->sum('tb_order.totalCart');
			$orderWait = TbOrder::leftjoin('tb_setting_payment_status', 'tb_setting_payment_status.id', '=', 'tb_order.payment_status')
				->where('tb_setting_payment_status.status_value', 1)
				->sum('tb_order.totalCart');
			$orderList = TbOrder::leftjoin('tb_setting_payment_status', 'tb_setting_payment_status.id', '=', 'tb_order.payment_status')
				->where('tb_setting_payment_status.status_value', 2)
				->sum('tb_order.totalCart');
			$orderAll = TbOrder::whereNotNull('id')->sum('totalCart');
			$order = TbOrder::count();
		}

		return view('admin.order.report', [
			'breadcrumb' => $breadcrumb,
			'title_page' => $title_page,
			'orderToday' => $orderToday,
			'orderWait'  => $orderWait,
			'orderList'  => $orderList,
			'orderAll'   => $orderAll,
			'order'      => $order,
		]);
	}


    public function orderPayment(Request $request){
		
		$month = $request->input('month');
		$year  = $request->input('year');

		// check access brand
		$current_user = Auth::user();
		$access_brand_id = $current_user->access_brand_id;

		// function สำหรับเพิ่ม whereMonth / whereYear เฉพาะเวลามีค่า
		$addDateFilter = function($query) use ($month, $year) {
			if (!empty($year))  $query->whereYear('tb_order.created_at', $year);
			if (!empty($month)) $query->whereMonth('tb_order.created_at', $month);
			return $query;
		};

		if(!empty($access_brand_id)){
			if(strpos($access_brand_id, ',')){
				$access_brand_id = explode(',',trim($access_brand_id));
			}else{
				$access_brand_id = [$access_brand_id];
			}

			$queryBase = function($type) use ($access_brand_id, $addDateFilter) {
				$query = TbOrder::select('payment_type')
					->leftjoin('tb_order_detail','tb_order.id','tb_order_detail.orderId')
					->leftjoin('tb_product_detail','tb_order_detail.product_sku','tb_product_detail.detail_sku')
					->leftjoin('tb_product','tb_product_detail.proId','tb_product.id')
					->whereIn('tb_product.pro_brand',$access_brand_id)
					->where('payment_type',$type);
				return $addDateFilter($query);
			};

			$p_type1 = $queryBase(1)->count(DB::raw('DISTINCT tb_order.id'));
			$p_type2 = $queryBase(2)->count(DB::raw('DISTINCT tb_order.id'));
			$p_type3 = $queryBase(3)->count(DB::raw('DISTINCT tb_order.id'));
			$p_type4 = $queryBase(4)->count(DB::raw('DISTINCT tb_order.id'));
			$p_type5 = $queryBase(5)->count(DB::raw('DISTINCT tb_order.id'));
			$p_type6 = $queryBase(6)->count(DB::raw('DISTINCT tb_order.id'));

			$response = [
				'p_type1' => $p_type1,
				'p_type2' => $p_type2,
				'p_type3' => $p_type3,
				'p_type4' => $p_type4,
				'p_type5' => $p_type5,
				'p_type6' => $p_type6,
				'd_type1' => 'บัญชีธนาคาร : '.number_format($p_type1).' รายการ',
				'd_type2' => 'ผ่อนชำระ : '.number_format($p_type2).' รายการ',
				'd_type3' => 'บัตรเครดิต : '.number_format($p_type3).' รายการ',
				'd_type4' => 'พร้อมเพย์ : '.number_format($p_type4).' รายการ',
				'd_type5' => 'โมบายแบงค์กิ้ง : '.number_format($p_type5).' รายการ',
				'd_type6' => 'ทรูมันนี่ : '.number_format($p_type6).' รายการ',
			];
		} else {
			$queryBase = function($type) use ($addDateFilter) {
				$query = TbOrder::select('payment_type')->where('payment_type', $type);
				return $addDateFilter($query);
			};

			$p_type1 = $queryBase(1)->count();
			$p_type2 = $queryBase(2)->count();
			$p_type3 = $queryBase(3)->count();
			$p_type4 = $queryBase(4)->count();
			$p_type5 = $queryBase(5)->count();
			$p_type6 = $queryBase(6)->count();

			$response = [
				'p_type1' => $p_type1,
				'p_type2' => $p_type2,
				'p_type3' => $p_type3,
				'p_type4' => $p_type4,
				'p_type5' => $p_type5,
				'p_type6' => $p_type6,
				'd_type1' => 'บัญชีธนาคาร : '.number_format($p_type1).' รายการ',
				'd_type2' => 'ผ่อนชำระ : '.number_format($p_type2).' รายการ',
				'd_type3' => 'บัตรเครดิต : '.number_format($p_type3).' รายการ',
				'd_type4' => 'พร้อมเพย์ : '.number_format($p_type4).' รายการ',
				'd_type5' => 'โมบายแบงค์กิ้ง : '.number_format($p_type5).' รายการ',
				'd_type6' => 'ทรูมันนี่ : '.number_format($p_type6).' รายการ',
			];
		}
		return $response;
	}


    public function view($id)
    {

        $breadcrumb = [
            ['name' => 'ออเดอร์'],
        ];

        $data  = TbOrder::with(
            'tb_setting_payment_status',
            'tb_order_payments',
            'tb_order_details',
            'tb_setting_province',
            'tb_setting_amphure',
            'tb_setting_district',
            'tb_receipt_province',
            'tb_receipt_amphures',
            'tb_receipt_district'
        )
        ->findOrFail($id);
		
		$usersOrder = User::where('user_code',$data->userCode)->first();

        $users = User::select(
            'users.level','users.name','users.lastname','users.id',
            'tb_level.number'
        )
        ->leftjoin('tb_level','tb_level.id','users.level')
        ->whereIn('tb_level.number',array('2','8'))
        ->get();

        $orderStatus = TbSettingPaymentStatus::where('show',1)->orderBy('rank','asc')->get();
        $orderTransport = TbSettingTransport::where('transport_show',1)->get();
        $historys = HistoryOrderStatus::where('orderNumber',$data->orderNumber)->orderBy('updated_at','desc')->limit(3)->get();

        $title_page = $data->orderNumber;

        return view('admin.order.view', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => $data,
            'users' => $users,
            'orderStatus' => $orderStatus,
            'orderTransport' => $orderTransport,
            'historys' => $historys,
			'usersOrder' => $usersOrder,
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

        $update                         = TbOrder::findOrFail($id);
        $update->staffOf                = $request->staff;
        $update->staff_updated_by       = Auth::user()->displayname;
        $update->staff_updated_at       = date('Y-m-d H:i:s');
        $update->save();

        $users = User::select('users.name','users.lastname')->findOrFail($request->staff);

        $history = new HistoryOrderStatus();
        $history->orderNumber           = $update->orderNumber;
        $history->order_status          = 'อัพเดตพนักงานที่รับผิดชอบ';
        $history->order_message         = $users->name.' '.$users->lastname;
        $history->updated_by            = Auth::user()->displayname;
        $history->updated_at            = date('Y-m-d H:i:s');
        $history->created_by            = Auth::user()->displayname;
        $history->created_at            = date('Y-m-d H:i:s');
        $history->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }

    public function updateStatus(Request $request,$id){

        $request->validate(
            [
                'status' => 'required',
            ],
            [
                'status.required' => 'กรุณาเลือกข้อมูล',
            ]
        );
        $status = TbSettingPaymentStatus::findOrFail($request->status);

        $update                         = TbOrder::findOrFail($id);
        $update->payment_status         = $request->status;
        $update->orderSuccessful        = $status->status_value;
        $update->staff_updated_by       = Auth::user()->displayname;
        $update->staff_updated_at       = date('Y-m-d H:i:s');
        $update->save();

        if($request->status == 7){

            $check = TbSoftwareNotify::where('orderId',$update->id)->first();

            if(!empty($check)){
                $software = TbSoftware::findOrFail($check->softwareId);
                $software->date_exp         = date("Y-m-d", strtotime("+365 day", strtotime($check->date_exp)));
                $software->updated_by       = 'SYSTEM';
                $software->updated_at       = date('Y-m-d H:i:s');
                $software->save();

                $crate = TbSoftwareNotify::findOrFail($check->id);
                $crate->userId                   = $check->userId;
                $crate->softwareId               = $check->softwareId;
                $crate->productCode              = $check->productCode;
                $crate->serial_number            = $check->serial_number;
                $crate->date_start               = date("Y-m-d",strtotime($check->date_start));
                $crate->date_exp                 = date("Y-m-d", strtotime("+365 day", strtotime($check->date_exp)));
                $crate->price                    = $check->price;
                $crate->note                     = $check->note;
                $crate->show                     = 1;
                $crate->status                   = 2;
                $crate->created_by               = 'SYSTEM';
                $crate->updated_by               = 'SYSTEM';
                $crate->created_at               = date('Y-m-d H:i:s');
                $crate->updated_at               = date('Y-m-d H:i:s');
                $crate->save();
            } else {
                // [PTCAD] ซื้อใหม่ (ไม่มี record เดิม) -> เรียก License API สร้าง License ให้อัตโนมัติ
                $orderForLicense = TbOrder::with('tb_order_details')->find($update->id);
                if (!empty($orderForLicense)) {
                    app(\App\Services\PtcadLicenseService::class)->createLicenseForOrder($orderForLicense);
                }
            }
        }

        $history = new HistoryOrderStatus();
        $history->orderNumber           = $update->orderNumber;
        $history->order_status          = 'อัพเดตสถานะคำสั่งซื้อ';
        $history->order_message         = $status->status_name;
        $history->updated_by            = Auth::user()->displayname;
        $history->updated_at            = date('Y-m-d H:i:s');
        $history->created_by            = Auth::user()->displayname;
        $history->created_at            = date('Y-m-d H:i:s');
        $history->save();

        $this->send_mail_order_Touser($id);
        $this->send_mail_order_Tostaff($id);

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }
	
	public function sendmail($id){

        $this->send_mail_order_Tostaff($id);

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }

    public function updateTransport(Request $request,$id){

        $request->validate(
            [
                'transportId' => 'required',
                'tracking' => 'required|max:255',
                'tracking_remark' => 'max:255',
            ],
            [
                'transportId.required' => 'กรุณาเลือกข้อมูล',
                'tracking.required' => 'กรุณากรอกข้อมูล',
                'tracking.max' => 'รอกข้อมูลได้ไม่เกิน 255 ตัวอักษร',
                'tracking_remark.max' => 'กรอกข้อมูลได้ไม่เกิน 255 ตัวอักษร',
            ]
        );

        $transport = TbSettingTransport::findOrFail($request->transportId);

        $update                             = TbOrder::findOrFail($id);
        $update->payment_status             = 5;
        $update->transportId                = $request->transportId;
        $update->tracking                   = $request->tracking;
        $update->transport_link             = $transport->transport_link;
        $update->tracking_remark            = $request->tracking_remark;
        $update->tracking_updated_by        = Auth::user()->displayname;
        $update->tracking_updated_at        = date('Y-m-d H:i:s');
        $update->save();

        $history = new HistoryOrderStatus();
        $history->orderNumber           = $update->orderNumber;
        $history->order_status          = 'อัพเดตผู้ให้บริการขนส่ง';
        $history->order_message         = $transport->transport_name.' หมายเลขพัสดุ :'.$request->tracking.' หมายเหตุ : '.$request->tracking_remark;
        $history->updated_by            = Auth::user()->displayname;
        $history->updated_at            = date('Y-m-d H:i:s');
        $history->created_by            = Auth::user()->displayname;
        $history->created_at            = date('Y-m-d H:i:s');
        $history->save();

        $this->send_mail_order_Touser($id);
        $this->send_mail_order_Tostaff($id);

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }

    public function jsondata(Request $request)
    {

        $search         = $request->get('search');
        $staff          = $request->get('staff');
        $payment        = $request->get('payment');
        $draw           = $request->get('draw');
        $start          = $request->get('start');
        $length         = $request->get('length');
        $search         = $request->get('search');
        $order          = $request->get('order');

        $columnorder = array(
            'orderNumber',
            'fullName',
            'price',
            'crated',
            'receipt',
            'status',
            'staff',
        );
		
		// check access brand
		$current_user = Auth::user();
		$access_brand_id = $current_user->access_brand_id;
		
		if(!empty($access_brand_id)){
			
			if(strpos($access_brand_id, ',')){
				$access_brand_id = explode(',',trim($access_brand_id));
			}else{
				$access_brand_id = [$access_brand_id];
			}
							
			$data = TbOrder::select('tb_order.*')->with('user')
							->leftjoin('tb_order_detail','tb_order.id','tb_order_detail.orderId')
							->leftjoin('tb_product_detail','tb_order_detail.product_sku','tb_product_detail.detail_sku')
							->leftjoin('tb_product','tb_product_detail.proId','tb_product.id')
							->whereIn('tb_product.pro_brand',$access_brand_id)
							->when($search, function ($query, $search) {
								return $query->where(function ($query) use ($search) {
									$query->orWhere('orderNumber', 'LIKE', '%' . $search . '%')
									->orWhere('residence_name', 'LIKE', '%' . $search . '%')
									->orWhere('residence_lastname', 'LIKE', '%' . $search . '%')
									->orWhere('residence_tel', 'LIKE', '%' . $search . '%');
								});
							})
							->when($payment, function ($query, $payment) {
								if(!empty($payment)){
									return $query->where('payment_status',$payment);
								}
							})
							->when($staff, function ($query, $staff) {
								if(!empty($staff)){
									return $query->where('staffOf',$staff);
								}
							})
							->orderBy('tb_order.created_at','desc')
							->get();

			$recordsTotal = TbOrder::select('tb_order.*')->with('user')
									->leftjoin('tb_order_detail','tb_order.id','tb_order_detail.orderId')
									->leftjoin('tb_product_detail','tb_order_detail.product_sku','tb_product_detail.detail_sku')
									->leftjoin('tb_product','tb_product_detail.proId','tb_product.id')
									->whereIn('tb_product.pro_brand',$access_brand_id)
									->when($search, function ($query, $search) {
										return $query->where(function ($query) use ($search) {
											$query->orWhere('orderNumber', 'LIKE', '%' . $search . '%')
											->orWhere('residence_name', 'LIKE', '%' . $search . '%')
											->orWhere('residence_lastname', 'LIKE', '%' . $search . '%')
											->orWhere('residence_tel', 'LIKE', '%' . $search . '%');
										});
									})
									->when($payment, function ($query, $payment) {
										if(!empty($payment)){
											return $query->where('payment_status',$payment);
										}
									})
									->when($staff, function ($query, $staff) {
										if(!empty($staff)){
											return $query->where('staffOf',$staff);
										}
									})
									->orderBy('tb_order.created_at','desc')
									->count();

			$recordsFiltered = TbOrder::select('tb_order.*')->with('user')
										->leftjoin('tb_order_detail','tb_order.id','tb_order_detail.orderId')
										->leftjoin('tb_product_detail','tb_order_detail.product_sku','tb_product_detail.detail_sku')
										->leftjoin('tb_product','tb_product_detail.proId','tb_product.id')
										->whereIn('tb_product.pro_brand',$access_brand_id)
										->when($search, function ($query, $search) {
											return $query->where(function ($query) use ($search) {
												$query->orWhere('orderNumber', 'LIKE', '%' . $search . '%')
												->orWhere('residence_name', 'LIKE', '%' . $search . '%')
												->orWhere('residence_lastname', 'LIKE', '%' . $search . '%')
												->orWhere('residence_tel', 'LIKE', '%' . $search . '%');
											});
										})
										->when($payment, function ($query, $payment) {
											if(!empty($payment)){
												return $query->where('payment_status',$payment);
											}
										})
										->when($staff, function ($query, $staff) {
											if(!empty($staff)){
												return $query->where('staffOf',$staff);
											}
										})
										->orderBy('tb_order.created_at','desc')
										->count();
		}else{
			$data = TbOrder::with('user')
							->when($search, function ($query, $search) {
								return $query->where(function ($query) use ($search) {
									$query->orWhere('orderNumber', 'LIKE', '%' . $search . '%')
									->orWhere('residence_name', 'LIKE', '%' . $search . '%')
									->orWhere('residence_lastname', 'LIKE', '%' . $search . '%')
									->orWhere('residence_tel', 'LIKE', '%' . $search . '%');
								});
							})
							->when($payment, function ($query, $payment) {
								if(!empty($payment)){
									return $query->where('payment_status',$payment);
								}
							})
							->when($staff, function ($query, $staff) {
								if(!empty($staff)){
									return $query->where('staffOf',$staff);
								}
							})
							->orderBy('created_at','desc')
							->get();

			$recordsTotal = TbOrder::with('user')
									->when($search, function ($query, $search) {
										return $query->where(function ($query) use ($search) {
											$query->orWhere('orderNumber', 'LIKE', '%' . $search . '%')
											->orWhere('residence_name', 'LIKE', '%' . $search . '%')
											->orWhere('residence_lastname', 'LIKE', '%' . $search . '%')
											->orWhere('residence_tel', 'LIKE', '%' . $search . '%');
										});
									})
									->when($payment, function ($query, $payment) {
										if(!empty($payment)){
											return $query->where('payment_status',$payment);
										}
									})
									->when($staff, function ($query, $staff) {
										if(!empty($staff)){
											return $query->where('staffOf',$staff);
										}
									})
									->orderBy('created_at','desc')
									->count();

			$recordsFiltered = TbOrder::with('user')
										->when($search, function ($query, $search) {
											return $query->where(function ($query) use ($search) {
												$query->orWhere('orderNumber', 'LIKE', '%' . $search . '%')
												->orWhere('residence_name', 'LIKE', '%' . $search . '%')
												->orWhere('residence_lastname', 'LIKE', '%' . $search . '%')
												->orWhere('residence_tel', 'LIKE', '%' . $search . '%');
											});
										})
										->when($payment, function ($query, $payment) {
											if(!empty($payment)){
												return $query->where('payment_status',$payment);
											}
										})
										->when($staff, function ($query, $staff) {
											if(!empty($staff)){
												return $query->where('staffOf',$staff);
											}
										})
										->orderBy('created_at','desc')
										->count();
		}

        return Datatables::of($data)
                ->addColumn('orderNumber', function ($data) {
                    return '<a href="'.route('order.view',$data->id).'">'.$data->orderNumber.'</a>';
                })
                ->addColumn('fullName', function ($data) {
                    return $data->residence_name.' '.$data->residence_lastname;
                })
                ->addColumn('price', function ($data) {
                    return number_format($data->totalCart,2);
                })
                ->addColumn('crated', function ($data) {
                    return date('Y-m-d H:i',strtotime($data->created_at));
                })
                ->addColumn('receipt', function ($data) {
                    if($data->statusReceipts == 2){
                        return '<span class="badge badge-danger">ไม่ต้องการ</span>';
                    }else if($data->statusReceipts == 1){
                        return '<span class="badge badge-success">ต้องการ</span>';
                    }
                })
                ->addColumn('status', function ($data) {

                    $payment = TbSettingPaymentStatus::findOrFail($data->payment_status);
                    return '<span class="badge" style="width: 150px;background:'.$payment->status_color.'">'.$payment->status_name.'</span>';
                })
                ->addColumn('staff', function ($data) {
                    if(!empty($data->staffOf)){
                        return '<small>'.$data->user->name.' '.$data->user->lastname.'</small>';
                    }else{
                        return '<small><span class="text-danger">ยังไม่มีผู้รับผิดชอบ</span></small>';
                    }
                })
                ->setTotalRecords($recordsTotal)
                ->setFilteredRecords($recordsFiltered)
                ->escapeColumns([])
                ->make(true);
    }

    public function generatorPDF(Request $request , $id){

        $data  = TbOrder::with(
            'tb_setting_payment_status',
            'tb_order_payments',
            'tb_order_details',
            'tb_setting_province',
            'tb_setting_amphure',
            'tb_setting_district',
            'tb_receipt_province',
            'tb_receipt_amphures',
            'tb_receipt_district'
        )
        ->findOrFail($id);

        $setting = TbSetting::first();


        $history = new HistoryOrderStatus();
        $history->orderNumber           = $data->orderNumber;
        $history->order_status          = 'ดาวน์โหลดเอกสาร PDF';
        $history->order_message         = '';
        $history->updated_by            = Auth::user()->displayname;
        $history->updated_at            = date('Y-m-d H:i:s');
        $history->created_by            = Auth::user()->displayname;
        $history->created_at            = date('Y-m-d H:i:s');
        $history->save();

        $pdf = PDF::loadView('admin.order.pdf', [
            'order' => $data,
            'setting' => $setting,
        ]);

        //Download
        return $pdf->download('คำสั่งซื้อใหม่_'.$data->orderNumber.'.pdf');

    }

		public function orderMaxOrder(Request $request)
		{
			$month  = $request->get('month');
			$year   = $request->get('year');

			$draw   = $request->get('draw');
			$start  = $request->get('start');
			$length = $request->get('length');
			$search = $request->get('search');
			$order  = $request->get('order');

			$columnorder = array('code', 'fullname', 'total');

			$sort = isset($order[0]) ? $columnorder[$order[0]['column']] : 'created_at';
			$dir  = isset($order[0]) ? $order[0]['dir'] : 'desc';

			$current_user     = Auth::user();
			$access_brand_id  = $current_user->access_brand_id;

			// ฟังก์ชันช่วย filter เดือน/ปี
			$filterDate = function($query) use ($month, $year) {
				if ($month) $query->whereMonth('tb_order.created_at', $month);
				if ($year)  $query->whereYear('tb_order.created_at',  $year);
				return $query;
			};

			// --- Base query: SUM แบบไม่ซ้ำ order โดยตัดการ JOIN รายการสินค้าออก ---
			$baseQuery = TbOrder::query()
				->selectRaw('SUM(tb_order.totalCart) as Total')
				->addSelect(
					'tb_order.userCode',
					'tb_order.residence_name',
					'tb_order.residence_lastname'
				)
				// สถานะการจ่ายเงิน: ใช้ JOIN ตรง ๆ ได้ เพราะ 1:1 กับ order
				->join('tb_setting_payment_status', 'tb_setting_payment_status.id', '=', 'tb_order.payment_status')
				->where('tb_setting_payment_status.status_value', 1);

			// กรองเดือน/ปี
			$baseQuery = $filterDate($baseQuery);

			// กรองแบรนด์ด้วย WHERE EXISTS เพื่อกันยอดซ้ำจากการ JOIN
			if (!empty($access_brand_id)) {
				// แปลงสตริงคอมมาให้เป็นอาเรย์ และกรองช่องว่าง/ค่าว่าง
				if (strpos($access_brand_id, ',') !== false) {
					$access_brand_id = array_values(array_filter(array_map('trim', explode(',', $access_brand_id)), function($v){
						return $v !== '';
					}));
				} else {
					$access_brand_id = [trim($access_brand_id)];
				}

				if (!empty($access_brand_id)) {
					$baseQuery->whereExists(function($q) use ($access_brand_id) {
						$q->from('tb_order_detail as od')
						  ->join('tb_product_detail as pd', 'od.product_sku', '=', 'pd.detail_sku')
						  ->join('tb_product as p', 'pd.proId', '=', 'p.id')
						  ->whereColumn('od.orderId', 'tb_order.id')
						  ->whereIn('p.pro_brand', $access_brand_id)
						  ->selectRaw('1');
					});
				}
			}

			// group by ผู้ใช้ (ผลรวมต่อ user)
			$baseQuery->groupBy('tb_order.userCode');

			// ทั้งหมดก่อน paginate (จำนวนกลุ่มหลัง GROUP BY)
			$recordsTotal    = (clone $baseQuery)->get()->count();
			$recordsFiltered = $recordsTotal;

			// Top 10 ตามยอดรวมสูงสุด (คงพฤติกรรมเดิม)
			$data = (clone $baseQuery)
				->orderBy('Total', 'desc')
				->limit(10)
				->get();

			return Datatables::of($data)
				->addColumn('code', function ($data) {
					return $data->userCode;
				})
				->addColumn('fullname', function ($data) {
					return '<a href="#" target="_blank">' . e($data->residence_name) . ' ' . e($data->residence_lastname) . '</a>';
				})
				->addColumn('total', function ($data) {
					return number_format($data->Total, 2);
				})
				->setTotalRecords($recordsTotal)
				->setFilteredRecords($recordsFiltered)
				->escapeColumns([]) // เรา render HTML ใน fullname อยู่แล้ว
				->skipPaging()
				->addIndexColumn()
				->make(true);
		}



    public function statusOrder(Request $request){

		$month = $request->input('month');
		$year  = $request->input('year');

		$payment_status = TbSettingPaymentStatus::get();
		
		$current_user = Auth::user();
		$access_brand_id = $current_user->access_brand_id;

		// Helper function สำหรับเติม whereMonth/whereYear
		$addDateFilter = function($query) use ($month, $year) {
			if (!empty($year))  $query->whereYear('tb_order.created_at', $year);
			if (!empty($month)) $query->whereMonth('tb_order.created_at', $month);
			return $query;
		};

		$response = [];

		if (!empty($access_brand_id)) {
			if (strpos($access_brand_id, ',')) {
				$access_brand_id = explode(',', trim($access_brand_id));
			} else {
				$access_brand_id = [$access_brand_id];
			}

			foreach ($payment_status as $status) {
				// ตัวแปรนับจำนวน
				$queryCount = TbOrder::select('payment_status')
					->leftjoin('tb_order_detail', 'tb_order.id', 'tb_order_detail.orderId')
					->leftjoin('tb_product_detail', 'tb_order_detail.product_sku', 'tb_product_detail.detail_sku')
					->leftjoin('tb_product', 'tb_product_detail.proId', 'tb_product.id')
					->whereIn('tb_product.pro_brand', $access_brand_id)
					->where('payment_status', $status->id);

				$queryCount = $addDateFilter($queryCount);
				$count = $queryCount->count(DB::raw('DISTINCT tb_order.id'));

				$response[] = [
					'status_count_'   => $count,
					'status_name_'    => $status->status_name,
					'display_status_' => '<li>'.$status->status_name.' : '.number_format($count).' รายการ</li>',
				];
			}
		} else {
			foreach ($payment_status as $status) {
				$queryCount = TbOrder::select('payment_status')
					->where('payment_status', $status->id);
				$queryCount = $addDateFilter($queryCount);
				$count = $queryCount->count();

				$response[] = [
					'status_count_'   => $count,
					'status_name_'    => $status->status_name,
					'display_status_' => '<li>'.$status->status_name.' : '.number_format($count).' รายการ</li>',
				];
			}
		}

		return $response;
	}


    public function updateRemark(Request $request,$id){

        $update                         = TbOrder::findOrFail($id);
        $update->staff_remark           = $request->staff_remark;
        $update->staff_updated_by       = Auth::user()->displayname;
        $update->staff_updated_at       = date('Y-m-d H:i:s');
        $update->save();

        $history = new HistoryOrderStatus();
        $history->orderNumber           = $update->orderNumber;
        $history->order_status          = 'Remark';
        $history->order_message         = $request->staff_remark;
        $history->updated_by            = Auth::user()->displayname;
        $history->updated_at            = date('Y-m-d H:i:s');
        $history->created_by            = Auth::user()->displayname;
        $history->created_at            = date('Y-m-d H:i:s');
        $history->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');
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
        if(!empty($ref)){
            //ค้นหาข้อมูลพนักงานที่ดูแล ข้อมูลของผู้แนะนำ
            $staff = User::select('id','name','lastname')->where('id',$ref->staffId)->first();
        }else{
            //ค้นหาข้อมูลพนักงานที่ดูแล ข้อมูลของผู้แนะนำ
            $staff = '';
        }

        $data = new \stdClass();
        $data->setting_nameWeb = $setting->setting_nameWeb;
        $data->setting_logoWeb = $setting->setting_logoWeb;
        $data->order = $order;
        $data->page = $page;
        $data->user = $user;
        $data->staff = $staff;

        $mail_bcc = explode(",",$setting->setting_email_bcc);
		
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
        $history->created_by                = 'SYSTEM';
        $history->created_at                = date('Y-m-d H:i:s');
        $history->updated_at                = date('Y-m-d H:i:s');
        $history->save();

    }
	
	public function orderSummary(Request $request) {
		$month = $request->input('month');
		$year = $request->input('year');

		$current_user = Auth::user();
		$access_brand_id = $current_user->access_brand_id;

		// ช่วยเติม prefix ทุกจุด!
		$dateFilter = function($query) use ($month, $year) {
			if (!empty($year)) $query->whereYear('tb_order.created_at', $year);
			if (!empty($month)) $query->whereMonth('tb_order.created_at', $month);
			return $query;
		};

		if(!empty($access_brand_id)){
			if(strpos($access_brand_id, ',')){
				$access_brand_id = explode(',', trim($access_brand_id));
			} else {
				$access_brand_id = [$access_brand_id];
			}

			$today = Carbon::today();
			$todayYear = $year ?: $today->year;
			$todayMonth = $month ?: $today->month;
			$todayDay = $today->day;

			// ============== ยอดขายวันนี้ ==============
			$orderTodayQuery = TbOrder::leftjoin('tb_order_detail','tb_order.id','tb_order_detail.orderId')
				->leftjoin('tb_product_detail','tb_order_detail.product_sku','tb_product_detail.detail_sku')
				->leftjoin('tb_product','tb_product_detail.proId','tb_product.id')
				->leftjoin('tb_order_payment','tb_order_payment.orderId','tb_order.id')
				->leftjoin('tb_setting_payment_status', 'tb_setting_payment_status.id', '=', 'tb_order.payment_status')
				->whereIn('tb_product.pro_brand', $access_brand_id)
				->where('tb_setting_payment_status.status_value', 1)
				->whereDate('tb_order.created_at', Carbon::today());
			$orderToday = $orderTodayQuery->sum('tb_order.totalCart');

			// ============== ชำระเงินแล้ว (filter) ==============
			$orderWait = TbOrder::leftjoin('tb_order_detail','tb_order.id','tb_order_detail.orderId')
				->leftjoin('tb_product_detail','tb_order_detail.product_sku','tb_product_detail.detail_sku')
				->leftjoin('tb_product','tb_product_detail.proId','tb_product.id')
				->leftjoin('tb_setting_payment_status', 'tb_setting_payment_status.id', '=', 'tb_order.payment_status')
				->whereIn('tb_product.pro_brand', $access_brand_id)
				->where('tb_setting_payment_status.status_value', 1);
			$orderWait = $dateFilter($orderWait)->sum('tb_order.totalCart');

			// ============== ค้างชำระ (filter) ==============
			$orderList = TbOrder::leftjoin('tb_order_detail','tb_order.id','tb_order_detail.orderId')
				->leftjoin('tb_product_detail','tb_order_detail.product_sku','tb_product_detail.detail_sku')
				->leftjoin('tb_product','tb_product_detail.proId','tb_product.id')
				->leftjoin('tb_setting_payment_status', 'tb_setting_payment_status.id', '=', 'tb_order.payment_status')
				->whereIn('tb_product.pro_brand', $access_brand_id)
				->where('tb_setting_payment_status.status_value', 2);
			$orderList = $dateFilter($orderList)->sum('tb_order.totalCart');

			// ============== ยอดขายสำเร็จ (filter) ==============
			$orderAll = TbOrder::leftjoin('tb_order_detail','tb_order.id','tb_order_detail.orderId')
				->leftjoin('tb_product_detail','tb_order_detail.product_sku','tb_product_detail.detail_sku')
				->leftjoin('tb_product','tb_product_detail.proId','tb_product.id')
				->whereIn('tb_product.pro_brand', $access_brand_id);
			$orderAll = $dateFilter($orderAll)->sum('tb_order.totalCart');

		} else {
			$today = Carbon::today();
			$todayYear = $year ?: $today->year;
			$todayMonth = $month ?: $today->month;
			$todayDay = $today->day;

			$orderTodayQuery = TbOrder::leftjoin('tb_order_payment','tb_order_payment.orderId','tb_order.id')
				->leftjoin('tb_setting_payment_status', 'tb_setting_payment_status.id', '=', 'tb_order.payment_status')
				->where('tb_setting_payment_status.status_value', 1)
				->whereDate('tb_order.created_at', Carbon::today());
			$orderToday = $orderTodayQuery->sum('tb_order.totalCart');

			$orderWait = TbOrder::leftjoin('tb_setting_payment_status', 'tb_setting_payment_status.id', '=', 'tb_order.payment_status')
				->where('tb_setting_payment_status.status_value', 1);
			$orderList = TbOrder::leftjoin('tb_setting_payment_status', 'tb_setting_payment_status.id', '=', 'tb_order.payment_status')
				->where('tb_setting_payment_status.status_value', 2);
			$orderAll = TbOrder::whereNotNull('id');

			if (!empty($year)) {
				$orderWait->whereYear('tb_order.created_at', $year);
				$orderList->whereYear('tb_order.created_at', $year);
				$orderAll->whereYear('tb_order.created_at', $year);
			}
			if (!empty($month)) {
				$orderWait->whereMonth('tb_order.created_at', $month);
				$orderList->whereMonth('tb_order.created_at', $month);
				$orderAll->whereMonth('tb_order.created_at', $month);
			}
			$orderWait = $orderWait->sum('tb_order.totalCart');
			$orderList = $orderList->sum('tb_order.totalCart');
			$orderAll = $orderAll->sum('tb_order.totalCart');
		}

		return response()->json([
			'orderToday' => number_format($orderToday),
			'orderWait'  => number_format($orderWait),
			'orderList'  => number_format($orderList),
			'orderAll'   => number_format($orderAll),
		]);
	}



}
