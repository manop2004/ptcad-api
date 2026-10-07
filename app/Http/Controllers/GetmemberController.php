<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Providers\RouteServiceProvider;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Mail;

use App\Models\TbSettingGetmember;
use App\Models\User;
use App\Models\UserGetmember;
use App\Models\TbSettingMonth;
use App\Models\TbSettingProvince;
use App\Models\UsersAddress;
use App\Models\TbSettingAmphure;
use App\Models\TbSettingDistrict;
use App\Models\HistoryMembergetmember;
use App\Models\HistorySendMail;
use App\Models\TbSetting;

use App\Exports\UserMemberGetMember;
use App\Mail\getmemberToUser;

class GetmemberController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    //setting
    public function setting(){

        $breadcrumb = [
            ['name' => 'ตั้งค่าระบบแนะนำสมาชิก'],
        ];
        $title_page = 'ตั้งค่าระบบแนะนำสมาชิก';
        $data       = TbSettingGetmember::first();

        return view('admin.getmember.setting', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => $data,
        ]);

    }

    public function crate(Request $request){

        if($request->getmember_ref_type == 2 && $request->getmember_recommender_type == 2 ){
            $request->validate(
                [
                    'getmember_ref_coupon' => 'required|max:255',
                    'getmember_recommender_coupon' => 'required|max:255',
                ],
                [
                    'getmember_ref_coupon.required' => 'กรุณากรอกข้อมูล',
                    'getmember_recommender_coupon.required' => 'กรุณากรอกข้อมูล',
                ]
            );
        }else if($request->getmember_ref_type == 1 || $request->getmember_recommender_type == 2 ){
            $request->validate(
                [
                    'getmember_recommender_coupon' => 'required|max:255',
                ],
                [
                    'getmember_recommender_coupon.required' => 'กรุณากรอกข้อมูล',
                ]
            );
        }else {
            $request->validate(
                [
                    'getmember_ref_coupon' => 'required|max:255',
                ],
                [
                    'getmember_ref_coupon.required' => 'กรุณากรอกข้อมูล',
                ]
            );
        }

        if($request->getmember_show == 'on'){
            $show = 1;
        }else{
            $show = 2;
        }

        $data = new TbSettingGetmember;
        $data->getmember_ref_type               = $request->getmember_ref;
        $data->getmember_ref_detail             = $request->getmember_ref_detail;
        $data->getmember_ref_coupon             = $request->getmember_ref_coupon;
        $data->getmember_recommender_type       = $request->getmember_recommender;
        $data->getmember_recommender_detail     = $request->getmember_recommender_detail;
        $data->getmember_recommender_coupon     = $request->getmember_recommender_coupon;
        $data->getmember_show                   = $show;
        $data->created_by                       = Auth::user()->displayname;
        $data->updated_by                       = Auth::user()->displayname;
        $data->created_at                       = date('Y-m-d H:i:s');
        $data->updated_at                       = date('Y-m-d H:i:s');

        if (!empty($request->getmember_thumb)) {

            if ($request->hasFile('getmember_thumb')) {
                @unlink(Storage::disk('public')->path('getmember/') . $request->getmember_thumb_old);

                $newFilename = uniqid() . '.' . $request->getmember_thumb->extension();
                $data->getmember_thumb = $newFilename;
                $file = $request->file('getmember_thumb');
                $file->move('storage/getmember/', $newFilename);
            }

        }

        $data->save();

        return back()->with('feedback', 'เพิ่มข้อมูลเรียบร้อยแล้ว!');

    }

    public function updateSetting(Request $request,$id){

        if($request->getmember_ref_type == 2 && $request->getmember_recommender_type == 2 ){
            $request->validate(
                [
                    'getmember_ref_coupon' => 'required|max:255',
                    'getmember_recommender_coupon' => 'required|max:255',
                ],
                [
                    'getmember_ref_coupon.required' => 'กรุณากรอกข้อมูล',
                    'getmember_recommender_coupon.required' => 'กรุณากรอกข้อมูล',
                ]
            );
        }else if($request->getmember_ref_type == 1 || $request->getmember_recommender_type == 2 ){
            $request->validate(
                [
                    'getmember_recommender_coupon' => 'required|max:255',
                ],
                [
                    'getmember_recommender_coupon.required' => 'กรุณากรอกข้อมูล',
                ]
            );
        }else {
            $request->validate(
                [
                    'getmember_ref_coupon' => 'required|max:255',
                ],
                [
                    'getmember_ref_coupon.required' => 'กรุณากรอกข้อมูล',
                ]
            );
        }

        if($request->getmember_show == 'on'){
            $show = 1;
        }else{
            $show = 2;
        }

        $data = TbSettingGetmember::findOrfail($id);
        $data->getmember_ref_type               = $request->getmember_ref;
        $data->getmember_ref_detail             = $request->getmember_ref_detail;
        $data->getmember_ref_coupon             = $request->getmember_ref_coupon;
        $data->getmember_recommender_type       = $request->getmember_recommender;
        $data->getmember_recommender_detail     = $request->getmember_recommender_detail;
        $data->getmember_recommender_coupon     = $request->getmember_recommender_coupon;
        $data->getmember_show                   = $show;
        $data->updated_by                       = Auth::user()->displayname;
        $data->updated_at                       = date('Y-m-d H:i:s');

        if (!empty($request->getmember_thumb)) {

            if ($request->hasFile('getmember_thumb')) {
                @unlink(Storage::disk('public')->path('getmember/') . $request->getmember_thumb_old);

                $newFilename = uniqid() . '.' . $request->getmember_thumb->extension();
                $data->getmember_thumb = $newFilename;
                $file = $request->file('getmember_thumb');
                $file->move('storage/getmember/', $newFilename);
            }

        }

        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }

    public function deleteImg(Request $request){

        $check = TbSettingGetmember::findOrfail($request->deleteId);
        if (!empty($check->getmember_thumb)) {
            @unlink(Storage::disk('public')->path('promo/').$check->getmember_thumb);
        }

        $data = TbSettingGetmember::findOrfail($request->deleteId);
        $data->getmember_thumb              = null;
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }

    //index
    public function index()
    {

        $breadcrumb = [
            ['name' => 'ข้อมูลผู้ใช้ที่ได้มีการแนะนำสมาชิก'],
        ];
        $title_page = 'ข้อมูลผู้ใช้ที่ได้มีการแนะนำสมาชิก';
        $count = UserGetmember::where('conditionStatus',1)->count();

        return view('admin.getmember.main', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => '',
            'count' => $count,
        ]);

    }

    public function edit($id){

        $breadcrumb = [
            ['name' => 'ข้อมูลผู้ใช้ที่ได้มีการแนะนำสมาชิก'],
        ];
        $title_page = 'ข้อมูลผู้ใช้ที่ได้มีการแนะนำสมาชิก';
        $data               = User::findOrFail($id);
        $userGetmember      = UserGetmember::where('userCode_Ref',$data->user_code)->first();
        $months             = TbSettingMonth::get();
        $provinces          = TbSettingProvince::get();
        $amphures           = TbSettingAmphure::get();
        $districts          = TbSettingDistrict::get();
        $settingGetmember   = TbSettingGetmember::first();
        $address            = UsersAddress::where('userId',$id)->first();
        $historys           = HistoryMembergetmember::where('getmemberId',$userGetmember->id)->limit('5')->orderBy('created_at','desc')->get();

        
        return view('admin.getmember.form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => $data,
            'months' => $months,
            'address' => $address,
            'provinces' => $provinces,
            'amphures' => $amphures,
            'districts' => $districts,
            'settingGetmember' => $settingGetmember,
            'userGetmember' => $userGetmember,
            'historys' => $historys,
        ]);

    }

    public function jsondata(Request $request)
    {

        $search         = $request->get('search');
        $status         = $request->get('status');
        $staff          = $request->get('staff');
        $draw           = $request->get('draw');
        $start          = $request->get('start');
        $length         = $request->get('length');
        $search         = $request->get('search');
        $order          = $request->get('order');

        $columnorder = array(
            'Fullname',
            'Email',
            'Tel',
            'Date',
            'status',
            'actions',
        );

        $data = UserGetmember::select(
            'users.user_code','users.name','users.lastname','users.email','users.tel','users.status','users.id',
            'user_getmember.userCode','user_getmember.userCode_Ref','user_getmember.status','user_getmember.conditionStatus','user_getmember.created_at'
        )
        ->leftjoin('users','users.user_code','user_getmember.userCode_Ref')
        ->when($search, function ($query, $search) {
            return $query->where(function ($query) use ($search) {
                $query->orWhere('users.name', 'LIKE', '%' . $search . '%')
                ->orWhere('users.lastname', 'LIKE', '%' . $search . '%')
                ->orWhere('users.email', 'LIKE', '%' . $search . '%')
                ->orWhere('users.tel', 'LIKE', '%' . $search . '%');
            });
        })
        ->when($status, function ($query, $status) {
            if(!empty($status)){
                return $query->where('user_getmember.status',$status);
            }
        })
        ->where('user_getmember.conditionStatus',1)
        ->orderBy('user_getmember.created_at','desc')
        ->get();

        $recordsTotal = UserGetmember::select(
            'users.user_code','users.name','users.lastname','users.email','users.tel','users.status','users.id',
            'user_getmember.userCode','user_getmember.userCode_Ref','user_getmember.status','user_getmember.conditionStatus','user_getmember.created_at'
        )
        ->leftjoin('users','users.user_code','user_getmember.userCode_Ref')
        ->when($search, function ($query, $search) {
            return $query->where(function ($query) use ($search) {
                $query->orWhere('users.name', 'LIKE', '%' . $search . '%')
                ->orWhere('users.lastname', 'LIKE', '%' . $search . '%')
                ->orWhere('users.email', 'LIKE', '%' . $search . '%')
                ->orWhere('users.tel', 'LIKE', '%' . $search . '%');
            });
        })
        ->when($status, function ($query, $status) {
            if(!empty($status)){
                return $query->where('user_getmember.status',$status);
            }
        })
        ->where('user_getmember.conditionStatus',1)
        ->orderBy('user_getmember.created_at','desc')
        ->count();

        $recordsFiltered = UserGetmember::select(
            'users.user_code','users.name','users.lastname','users.email','users.tel','users.status','users.id',
            'user_getmember.userCode','user_getmember.userCode_Ref','user_getmember.status','user_getmember.conditionStatus','user_getmember.created_at'
        )
        ->leftjoin('users','users.user_code','user_getmember.userCode_Ref')
        ->when($search, function ($query, $search) {
            return $query->where(function ($query) use ($search) {
                $query->orWhere('users.name', 'LIKE', '%' . $search . '%')
                ->orWhere('users.lastname', 'LIKE', '%' . $search . '%')
                ->orWhere('users.email', 'LIKE', '%' . $search . '%')
                ->orWhere('users.tel', 'LIKE', '%' . $search . '%');
            });
        })
        ->when($status, function ($query, $status) {
            if(!empty($status)){
                return $query->where('user_getmember.status',$status);
            }
        })
        ->where('user_getmember.conditionStatus',1)
        ->orderBy('user_getmember.created_at','desc')
        ->count();

        return Datatables::of($data)
                ->addColumn('Fullname', function ($data) {
                    return $data->name.' '.$data->lastname;
                })
                ->addColumn('Email', function ($data) {
                    return $data->email;
                })
                ->addColumn('Tel', function ($data) {
                    return $data->tel;
                })
                ->addColumn('Date', function ($data) {
                    $date = User::select('created_at')->where('user_code',$data->user_code)->first();
                    return $date->created_at;
                })
                ->addColumn('status', function ($data) {
                    return $data->status;
                })
                ->addColumn('actions', function ($data) {
                    $id = $data->id;
                    $name = $data->name.' '.$data->lastname;
                    return view('admin.getmember.button', compact('id','name'));
                })
                ->setTotalRecords($recordsTotal)
                ->setFilteredRecords($recordsFiltered)
                ->escapeColumns([])
                ->addIndexColumn()
                ->make(true);
    }

    public function updateStatus(Request $request, $id){

        $data = UserGetmember::findOrfail($id);
        $data->status                           = $request->status;
        $data->remark                           = $request->remark;
        $data->updated_by                       = Auth::user()->displayname;
        $data->updated_at                       = date('Y-m-d H:i:s');
        $data->save();

        if($request->status == 1){
            $status = 'จัดส่งของขวัญแล้ว';
        }else{
            $status = 'ยังไม่มีการจัดส่งของขวัญ';
        }

        $history = new HistoryMembergetmember;
        $history->getmemberId                      = $id;
        $history->status                           = $status;
        $history->remark                           = $request->remark;
        $history->created_by                       = Auth::user()->displayname;
        $history->created_at                       = date('Y-m-d H:i:s');
        $history->save();

        $this->send_mail($data->userCode_Ref,$status);

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }

    public function Export(Request $request)
    {
        $search = $request->search;
        $status = $request->status;

        $history = new HistoryMembergetmember;
        $history->getmemberId                      = Auth::user()->id;
        $history->status                           = 'Export รายชื่อ';
        $history->remark                           = null;
        $history->created_by                       = Auth::user()->displayname;
        $history->created_at                       = date('Y-m-d H:i:s');
        $history->save();

        return Excel::download(new UserMemberGetMember($status, $search,), 'user_getmember_'.date('Y-m-d_H:i:s').'.xlsx');

    }

    private function send_mail($code,$status){

        $setting = TbSetting::first();
        $user = User::where('user_code',$code)->first();

        $data = new \stdClass();
        $data->setting_nameWeb = $setting->setting_nameWeb;
        $data->setting_logoWeb = $setting->setting_logoWeb;

        $mail_bcc = explode(",",$setting->setting_email_bcc);

        if(!empty($setting->setting_email_bcc)){
            
			try{
				Mail::to($user->email)->bcc($mail_bcc)->later(now()->addMinutes(5), new getmemberToUser($data));
				
				if(Mail::failures()) { $mailStatus = 'ล้มเหลว'; }else{ $mailStatus = 'สำเร็จ'; }
			}catch(\Exception $e){
				// Never reached
				$mailStatus = 'ล้มเหลว';
			}
        }else{
            
			try{
				Mail::to($user->email)->later(now()->addMinutes(5), new getmemberToUser($data));
				
				if(Mail::failures()) { $mailStatus = 'ล้มเหลว'; }else{ $mailStatus = 'สำเร็จ'; }
			}catch(\Exception $e){
				// Never reached
				$mailStatus = 'ล้มเหลว';
			}
        }

        

        $history                            = new HistorySendMail();
        $history->userId                    = $user->id;
        $history->remark                    = "อัพเดตสถานะ การจัดส่งของขวัญ | ".$status;
        $history->status                    = $mailStatus;
        $history->created_by                = 'SYSTEM';
        $history->created_at                = date('Y-m-d H:i:s');
        $history->updated_at                = date('Y-m-d H:i:s');
        $history->save();

    }

}
