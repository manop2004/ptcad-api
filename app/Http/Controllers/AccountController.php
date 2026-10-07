<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\UsersAddress;
use App\Models\UsersAddressReceipt;
use App\Models\UsersCoupon;
use App\Models\TbSetting;
use App\Models\TbExtension;
use App\Models\TbSettingUser;
use App\Models\TbSettingCompanyBusiness;
use App\Models\TbSettingCompanyPosition;
use App\Models\HistoryChangeDisplay;
use App\Models\TbPagesMap;
use App\Models\TbSettingProvince;
use App\Models\TbSettingGetmember;
use App\Models\TbOrder;
use App\Models\HistoryOrderStatus;
use App\Models\HistorySendMail;
use App\Models\TbSoftwareNotify;
use App\Models\TbQuotation;
use App\Mail\orderNotify;
use App\Mail\forgotMail;
use App\Mail\orderToStaff;
use Barryvdh\DomPDF\Facade as PDF;

class AccountController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['verifyEmailChange']);
    }

    public function quotation(){

        $setting = TbSetting::first();
        $data = TbQuotation::with('history_quotations')->where('userId',Auth::user()->id)->orderBy('created_at','desc')->paginate(10);

        $page_name = 'ขอใบเสนอราคา';

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

        return view('fontend.account.quotation.main',[
            'breadcrumb' => $breadcrumb,
            'og_site_name' => $og_site_name,
            'og_keywords' => $og_keywords,
            'og_title' => $og_title,
            'og_description' => $og_description,
            'og_url' => $og_url,
            'og_image' => $og_image,
            'page_name' => $page_name,
            'data' => $data,
        ]);

    }

    public function quotationDetail($id){

        $setting            = TbSetting::first();
        $quotation          = TbQuotation::with('history_quotations')->findOrFail($id);
        if(!empty($quotation->quotationDateExp)){
            $dateTaday          = date('Y-m-d');
            $dateExp            = $this->compareDate($dateTaday,$quotation->quotationDateExp);
        }else{
            $dateExp            = '';
        }

        $page_name = $quotation->quotationNumber;

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

        return view('fontend.account.quotation.detail',[
            'breadcrumb' => $breadcrumb,
            'og_site_name' => $og_site_name,
            'og_keywords' => $og_keywords,
            'og_title' => $og_title,
            'og_description' => $og_description,
            'og_url' => $og_url,
            'og_image' => $og_image,
            'page_name' => $page_name,
            'quotation' => $quotation,
            'dateExp' => $dateExp,
        ]);

    }

    public function accountMenu(){

        $setting = TbSetting::first();
        $extension = TbExtension::select('ext_captcha_status','ext_captcha')->first();
        $user = User::where('id',Auth::user()->id)->first();
        $settingUser = TbSettingUser::first();
        $extension = TbExtension::select('ext_captcha_status','ext_captcha')->first();
        $business = TbSettingCompanyBusiness::where('business_show',1)->orderBy('business_name','asc')->get();
        $position = TbSettingCompanyPosition::where('position_show',1)->orderBy('position_name','asc')->get();
        $getmember = TbSettingGetmember::first();

        // Dashboard quick-stats (added — reuses the same filters as software()/order())
$softwareCount = TbSoftwareNotify::where('userId',Auth::user()->id)->where('show',1)->count();

// [เพิ่มใหม่] นับ License Civil ProMax ของ user นี้ด้วย (ครอบ try-catch กันพัง ไม่กระทบตัวเลข PTCAD เดิม)
$civilProMaxCount = 0;
try {
    $civilProMaxCount = \App\Models\LicenseKeyStock::join('tb_order', 'tb_order.id', 'tb_license_key_stock.orderId')
        ->where('tb_license_key_stock.status', \App\Models\LicenseKeyStock::STATUS_USED)
        ->where('tb_order.userCode', Auth::user()->user_code)
        ->count();
} catch (\Exception $e) {
    \Log::warning('AccountController::accountMenu - ไม่สามารถนับ License Civil ProMax ได้', [
        'userId' => Auth::user()->id,
        'message' => $e->getMessage(),
    ]);
}

$softwareCount = $softwareCount + $civilProMaxCount;

$orderCount = TbOrder::where('userCode',Auth::user()->user_code)->count();

        $page_name = 'บัญชีผู้ใช้';

        //title share
        if(!empty($page_name)){ $og_site_name = $page_name; }else{ $og_site_name = $page_name;}
        if(!empty($page_name)){ $og_title = $page_name; }else{ $og_title = $og_site_name = $page_name;}
        if(!empty($setting->setting_keyword)){ $og_keywords = $setting->setting_keyword; }else{ $og_keywords = "";}
        if(!empty($setting->setting_detail)){ $og_description = $setting->setting_detail; }else{ $og_description = "";}
        if(!empty($setting->setting_coverShare)){ $og_image = asset('storage/setting/'.$setting->setting_coverShare); }else{ $og_image = "";}
        if(!empty($page)){ $og_url = route('login'); }else{ $og_url = route('fronend.home');}

        return view('fontend.account.menuMain',[
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
            'getmember' => $getmember,
            'softwareCount' => $softwareCount,
            'orderCount' => $orderCount,
        ]);

    }

    public function account(){

        $setting = TbSetting::first();
        $extension = TbExtension::select('ext_captcha_status','ext_captcha')->first();
        $user = User::where('id',Auth::user()->id)->first();
        $settingUser = TbSettingUser::first();
        $extension = TbExtension::select('ext_captcha_status','ext_captcha')->first();
        $business = TbSettingCompanyBusiness::where('business_show',1)->orderBy('business_name','asc')->get();
        $position = TbSettingCompanyPosition::where('position_show',1)->orderBy('position_name','asc')->get();
        $getmember = TbSettingGetmember::first();
        $pageMaps = TbPagesMap::select('page_membership')->first();
        $contacts = \App\Models\UserContact::where('user_id', $user->id)->orderBy('id','asc')->get(); // [เพิ่มใหม่]

        $page_name = 'บัญชีผู้ใช้';

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

        return view('fontend.account.account',[
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
            'getmember' => $getmember,
            'pageMaps' => $pageMaps,
            'contacts' => $contacts, // [เพิ่มใหม่]
        ]);

    }

    public function accountUpdate(Request $request,$id){

        $request->validate(
    [
        'name' => 'required|max:255',
        'lastname' => 'required|max:255',
        'email' => 'required|email|max:255|unique:users,email,'.$id,
    ],
    [
        'name.required' => 'กรุณากรอกข้อมูล',
        'name.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
        'lastname.required' => 'กรุณากรอกข้อมูล',
        'lastname.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
        'email.required' => 'กรุณากรอกข้อมูล',
        'email.email' => 'รูปแบบอีเมลไม่ถูกต้อง',
        'email.unique' => 'อีเมลนี้มีการใช้งานอยู่แล้ว',
    ]
);

// [เพิ่มใหม่] สร้าง "ชื่อที่ใช้แสดง" อัตโนมัติแทนที่ผู้ใช้กรอกเอง
if ($request->user_type == 2) {
    $newDisplayname = trim($request->company_name ?? '');
} else {
    $newDisplayname = trim(($request->name ?? '') . ' ' . ($request->lastname ?? ''));
}



        if(!empty($request->businessId)){
            $businessId = $request->businessId;
        }else{
            $businessId = null;
        }

        if(!empty($request->positionId)){
            $positionId = $request->positionId;
        }else{
            $positionId = null;
        }

        $data = User::findOrFail($id);

        if(empty($data->user_code)){
        $data->user_code                    = $this->generateRandomString();
        }
        $data->displayname                  = $newDisplayname;
        $data->name                         = $request->name;
        $data->lastname                     = $request->lastname;
        $data->tel                          = $request->tel;
        $data->user_type                    = $request->user_type;
        $data->company_name                 = $request->company_name;
        $data->businessId                   = $businessId;
        $data->positionId                   = $positionId;
        // ✅ เพิ่ม 4 field ใหม่
        $data->tax_id                       = $request->tax_id;
        $data->branch                       = $request->branch;
        $data->billing_address              = $request->billing_address;
        $data->language                     = $request->language;
        $data->update_by                    = Auth::user()->displayname;
        $data->updated_at                   = now();

        if (!empty($request->img)) {

            if ($request->hasFile('img')) {
                @unlink(Storage::disk('public')->path('avatar/') . $request->img_old);

                $newFilename = uniqid() . '.' . $request->img->extension();
                $data->img = $newFilename;
                $file = $request->file('img');
                $file->move('storage/avatar/', $newFilename);
            }

        }

        // [เพิ่มใหม่] เช็คว่ามีการเปลี่ยนอีเมลไหม — ไม่เขียนทับอีเมลจริงทันที ต้องยืนยันก่อน
$emailChanged = strcasecmp(trim($request->email), trim($data->email)) !== 0;
$feedback = 'อัพเดตข้อมูลเรียบร้อยแล้ว!';

if ($emailChanged) {
    $token = bin2hex(random_bytes(32));
    $data->pending_email = $request->email;
    $data->email_verify_token = $token;
    $data->email_verify_token_expires_at = now()->addHours(24);
    $data->save();

    try {
        Mail::to($request->email)->later(now()->addMinutes(1), new \App\Mail\verifyEmailChangeMail([
            'displayname' => $data->displayname,
            'new_email'   => $request->email,
            'verify_url'  => route('fronend.account.verifyEmail', $token),
        ]));
    } catch (\Exception $e) {
        \Log::warning('accountUpdate - ส่งอีเมลยืนยันไม่สำเร็จ', ['userId' => $data->id, 'message' => $e->getMessage()]);
    }

    $feedback = 'บันทึกข้อมูลเรียบร้อยแล้ว! เราส่งอีเมลยืนยันไปที่ ' . $request->email . ' กรุณาตรวจสอบกล่องจดหมาย (ลิงก์หมดอายุใน 24 ชม.) อีเมลเดิมของคุณยังใช้เข้าสู่ระบบได้ตามปกติจนกว่าจะยืนยันสำเร็จ';
} else {
    $data->save();
}

return back()->with('feedback', $feedback);

    }
    public function contactStore(Request $request)
{
    $request->validate([
        'name' => 'required|max:255',
        'lastname' => 'required|max:255',
        'tel' => 'nullable|max:50',
        'email' => 'nullable|email|max:255',
    ], [
        'name.required' => 'กรุณากรอกชื่อ',
        'lastname.required' => 'กรุณากรอกนามสกุล',
        'email.email' => 'รูปแบบอีเมลไม่ถูกต้อง',
    ]);

    $count = \App\Models\UserContact::where('user_id', Auth::user()->id)->count();

    if ($count >= 10) {
        return response()->json(['success' => false, 'message' => 'เพิ่มผู้ติดต่อได้สูงสุด 10 คนเท่านั้น'], 422);
    }

    $contact = \App\Models\UserContact::create([
        'user_id'  => Auth::user()->id,
        'name'     => $request->name,
        'lastname' => $request->lastname,
        'tel'      => $request->tel,
        'email'    => $request->email,
    ]);

    return response()->json([
        'success' => true,
        'message' => 'เพิ่มผู้ติดต่อเรียบร้อยแล้ว',
        'contact' => $contact,
    ]);
}

public function contactDestroy($id)
{
    $contact = \App\Models\UserContact::where('id', $id)
        ->where('user_id', Auth::user()->id)
        ->first();

    if (empty($contact)) {
        return response()->json(['success' => false, 'message' => 'ไม่พบข้อมูลผู้ติดต่อนี้'], 404);
    }

    $contact->delete();

    return response()->json(['success' => true, 'message' => 'ลบผู้ติดต่อเรียบร้อยแล้ว']);
}

    public function address(){

        $setting = TbSetting::first();
        $extension = TbExtension::select('ext_captcha_status','ext_captcha')->first();
        $user = User::where('id',Auth::user()->id)->first();
        $usersAddress = UsersAddress::where('userId',Auth::user()->id)->first();
        $usersReceipt = UsersAddressReceipt::where('userId',Auth::user()->id)->first();
        $settingUser = TbSettingUser::first();
        $extension = TbExtension::select('ext_captcha_status','ext_captcha')->first();
        $business = TbSettingCompanyBusiness::where('business_show',1)->orderBy('business_name','asc')->get();
        $position = TbSettingCompanyPosition::where('position_show',1)->orderBy('position_name','asc')->get();
        $provinces = TbSettingProvince::get();
        $page_name = 'ที่อยู่จัดส่ง';

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

        return view('fontend.account.address',[
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
            'provinces' => $provinces,
            'usersAddress' => $usersAddress,
            'usersReceipt' => $usersReceipt,
        ]);

    }
	
	public function address2(){

        $setting = TbSetting::first();
        $extension = TbExtension::select('ext_captcha_status','ext_captcha')->first();
        $user = User::where('id',Auth::user()->id)->first();
        $usersAddress = UsersAddress::where('userId',Auth::user()->id)->first();
        $usersReceipt = UsersAddressReceipt::where('userId',Auth::user()->id)->first();
        $settingUser = TbSettingUser::first();
        $extension = TbExtension::select('ext_captcha_status','ext_captcha')->first();
        $business = TbSettingCompanyBusiness::where('business_show',1)->orderBy('business_name','asc')->get();
        $position = TbSettingCompanyPosition::where('position_show',1)->orderBy('position_name','asc')->get();
        $provinces = TbSettingProvince::get();
        $page_name = 'ที่อยู่จัดส่ง';

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

        return view('fontend.account.address2',[
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
            'provinces' => $provinces,
            'usersAddress' => $usersAddress,
            'usersReceipt' => $usersReceipt,
        ]);

    }

    public function addressCrate(Request $request){

        $request->validate(
            [
                'name' => 'required|max:255',
                'lastname' => 'required|max:255',
                'tel' => 'required|max:255',
                'address' => 'required',
                'province' => 'required',
                'amphures' => 'required',
                'district' => 'required',
                'zipcode' => 'required',
            ],
            [
                'name.required' => 'กรุณากรอกข้อมูล',
                'name.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'lastname.required' => 'กรุณากรอกข้อมูล',
                'lastname.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'address.required' => 'กรุณากรอกข้อมูล',
                'tel.required' => 'กรุณากรอกข้อมูล',
                'tel.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'province.required' => 'กรุณาเลือกข้อมูล',
                'amphures.required' => 'กรุณาเลือกข้อมูล',
                'district.required' => 'กรุณาเลือกข้อมูล',
                'zipcode.required' => 'กรุณากรอกข้อมูล',
            ]
        );

        $data = new UsersAddress;
        $data->userId                       = $request->userId;
        $data->name                         = $request->name;
        $data->lastname                     = $request->lastname;
        $data->tel                          = $request->tel;
        $data->address                      = $request->address;
        $data->province                     = $request->province;
        $data->amphures                     = $request->amphures;
        $data->district                     = $request->district;
        $data->zipcode                      = $request->zipcode;
        $data->message                      = $request->message;
        $data->created_by                   = Auth::user()->displayname;
        $data->updated_by                   = Auth::user()->displayname;
        $data->updated_at                   = now();
        $data->created_at                   = now();
        $data->save();

        return redirect()->back()->with('feedback', 'เพิ่มข้อมูลเรียบร้อยแล้ว!');

    }

    public function addressUpdate(Request $request,$id){

        $request->validate(
            [
                'name' => 'required|max:255',
                'lastname' => 'required|max:255',
                'tel' => 'required|max:255',
                'address' => 'required',
                'province' => 'required',
                'amphures' => 'required',
                'district' => 'required',
                'zipcode' => 'required',
            ],
            [
                'name.required' => 'กรุณากรอกข้อมูล',
                'name.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'lastname.required' => 'กรุณากรอกข้อมูล',
                'lastname.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'address.required' => 'กรุณากรอกข้อมูล',
                'tel.required' => 'กรุณากรอกข้อมูล',
                'tel.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'province.required' => 'กรุณาเลือกข้อมูล',
                'amphures.required' => 'กรุณาเลือกข้อมูล',
                'district.required' => 'กรุณาเลือกข้อมูล',
                'zipcode.required' => 'กรุณากรอกข้อมูล',
            ]
        );

        $data = UsersAddress::findOrfail($id);
        $data->userId                       = $request->userId;
        $data->name                         = $request->name;
        $data->lastname                     = $request->lastname;
        $data->tel                          = $request->tel;
        $data->address                      = $request->address;
        $data->province                     = $request->province;
        $data->amphures                     = $request->amphures;
        $data->district                     = $request->district;
        $data->zipcode                      = $request->zipcode;
        $data->message                      = $request->message;
        $data->updated_by                   = Auth::user()->displayname;
        $data->updated_at                   = now();
        $data->save();

        return redirect()->back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }

    public function receiptCrate(Request $request){

        $request->validate(
            [
                'receipt_name' => 'required|max:255',
                'receipt_lastname' => 'required|max:255',
                'receipt_tel' => 'required|max:255',
                'receipt_address' => 'required',
                'receipt_province' => 'required',
                'receipt_amphures' => 'required',
                'receipt_district' => 'required',
                'receipt_zipcode' => 'required',
                'receipt_taxid' => 'required',
            ],
            [
                'receipt_name.required' => 'กรุณากรอกข้อมูล',
                'receipt_name.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'receipt_lastname.required' => 'กรุณากรอกข้อมูล',
                'receipt_lastname.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'receipt_address.required' => 'กรุณากรอกข้อมูล',
                'receipt_tel.required' => 'กรุณากรอกข้อมูล',
                'receipt_tel.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'province.required' => 'กรุณาเลือกข้อมูล',
                'receipt_amphures.required' => 'กรุณาเลือกข้อมูล',
                'receipt_district.required' => 'กรุณาเลือกข้อมูล',
                'receipt_zipcode.required' => 'กรุณากรอกข้อมูล',
                'receipt_taxid.required' => 'กรุณากรอกข้อมูล',
            ]
        );

        $data = new UsersAddressReceipt;
        $data->type                         = $request->receipt_persona_type;
        $data->taxid                        = $request->receipt_taxid;
        $data->company                      = $request->receipt_company;
        $data->branch                       = $request->receipt_branch;
        $data->userId                       = $request->receipt_userId;
        $data->name                         = $request->receipt_name;
        $data->lastname                     = $request->receipt_lastname;
        $data->tel                          = $request->receipt_tel;
        $data->address                      = $request->receipt_address;
        $data->province                     = $request->receipt_province;
        $data->amphures                     = $request->receipt_amphures;
        $data->district                     = $request->receipt_district;
        $data->zipcode                      = $request->receipt_zipcode;
        $data->created_by                   = Auth::user()->displayname;
        $data->updated_by                   = Auth::user()->displayname;
        $data->updated_at                   = now();
        $data->created_at                   = now();
        $data->save();
		
        return redirect()->back()->with('feedback', 'เพิ่มข้อมูลเรียบร้อยแล้ว!');

    }

    public function receiptUpdate(Request $request,$id){

        $request->validate(
            [
                'receipt_name' => 'required|max:255',
                'receipt_lastname' => 'required|max:255',
                'receipt_tel' => 'required|max:255',
                'receipt_address' => 'required',
                'receipt_province' => 'required',
                'receipt_amphures' => 'required',
                'receipt_district' => 'required',
                'receipt_zipcode' => 'required',
                'receipt_taxid' => 'required',
            ],
            [
                'receipt_name.required' => 'กรุณากรอกข้อมูล',
                'receipt_name.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'receipt_lastname.required' => 'กรุณากรอกข้อมูล',
                'receipt_lastname.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'receipt_address.required' => 'กรุณากรอกข้อมูล',
                'receipt_tel.required' => 'กรุณากรอกข้อมูล',
                'tel.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'receipt_province.required' => 'กรุณาเลือกข้อมูล',
                'receipt_amphures.required' => 'กรุณาเลือกข้อมูล',
                'receipt_district.required' => 'กรุณาเลือกข้อมูล',
                'receipt_zipcode.required' => 'กรุณากรอกข้อมูล',
                'receipt_taxid.required' => 'กรุณากรอกข้อมูล',
            ]
        );

        $data = UsersCoupon::findOrfail($id);
        $data->type                         = $request->receipt_persona_type;
        $data->taxid                        = $request->receipt_taxid;
        $data->company                      = $request->receipt_company;
        $data->branch                       = $request->receipt_branch;
        $data->userId                       = $request->receipt_userId;
        $data->name                         = $request->receipt_name;
        $data->lastname                     = $request->receipt_lastname;
        $data->tel                          = $request->receipt_tel;
        $data->address                      = $request->receipt_address;
        $data->province                     = $request->receipt_province;
        $data->amphures                     = $request->receipt_amphures;
        $data->district                     = $request->receipt_district;
        $data->zipcode                      = $request->receipt_zipcode;
        $data->updated_by                   = Auth::user()->displayname;
        $data->updated_at                   = now();
        $data->save();

        return redirect()->back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }

    public function changepassword(){

        $setting = TbSetting::first();
        $extension = TbExtension::select('ext_captcha_status','ext_captcha')->first();
        $user = User::where('id',Auth::user()->id)->first();
        $settingUser = TbSettingUser::first();
        $extension = TbExtension::select('ext_captcha_status','ext_captcha')->first();
        $business = TbSettingCompanyBusiness::where('business_show',1)->orderBy('business_name','asc')->get();
        $position = TbSettingCompanyPosition::where('position_show',1)->orderBy('position_name','asc')->get();
        $page_name = 'เปลี่ยนรหัสผ่าน';

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

        return view('fontend.account.changepassword',[
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
        ]);


    }

    public function changepasswordUpdate(Request $request){

        if(!empty( $request->_token)){
            $request->validate(
                [
                    '_token' => 'required',
                    'password_new' => 'required|min:8',
                    'password_confirmation' => 'required|same:password_new',
                ],
                [
                    '_token.required' => '',
                    'password.required' => 'กรุณากรอกรหัสผ่านปัจจุบัน',
                    'password_new.required' => 'กรุณากรอกรหัสผ่านใหม่',
                    'password_new.min' => 'กรุณากรอกรหัสผ่านอย่างน้อย 8 อักษร',
                    'password_confirmation.required' => 'กรุณายืนยันรหัสผ่าน',
                    'password_confirmation.same' => 'รหัสผ่านไม่ตรงกัน กรุณาตรวจสอบข้อมูล',
                ]
            );

            $user = User::select('id','password')->findOrFail(Auth::user()->id);

            if (Hash::check( $request->password, $user->password))
            {
                $user = User::findOrFail(Auth::user()->id);

                $user->password                = Hash::make($request->password_new);
                $user->update_by               = Auth::user()->name;
                $user->updated_at              = date('Y-m-d H:i:s');
                $user->save();

                Auth::logout();
                return redirect()->route('login');

            }else{
                $request->validate(
                    [
                        'password' => 'different:password',
                    ],
                    [
                        'password.different' => 'รหัสผ่านปัจจุบันไม่ถูกต้อง กรุณาตรวจสอบข้อมูล',
                    ]
                );
            }

        }else{
            return redirect('fronend.home');
        }

    }

    public function forgotpassword(Request $request){

        $setting = TbSetting::first();
        $extension = TbExtension::select('ext_captcha_status','ext_captcha')->first();
        $user = User::where('id',Auth::user()->id)->first();
        $settingUser = TbSettingUser::first();
        $extension = TbExtension::select('ext_captcha_status','ext_captcha')->first();
        $business = TbSettingCompanyBusiness::where('business_show',1)->orderBy('business_name','asc')->get();
        $position = TbSettingCompanyPosition::where('position_show',1)->orderBy('position_name','asc')->get();
        $page_name = 'ลืมรหัสผ่าน';

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

        return view('fontend.account.forgotpassword',[
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
        ]);

    }

    public function forgotpasswordUpdate(Request $request,$id){
        
            // [เพิ่มใหม่ - แก้ช่องโหว่ความปลอดภัย] ต้องแก้ไขได้แค่บัญชีตัวเองเท่านั้น
            if ((int) $id !== (int) Auth::user()->id) {
            abort(403, 'ไม่มีสิทธิ์เข้าถึงข้อมูลนี้');
    }
            $request->validate(
                [
                    'email' => 'required|max:255|email',
                ],
                [
                    'email.required' => 'กรุณากรอกข้อมูลอีเมล',
                    'email.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                    'email.email' => 'รูปแบบอีเมลไม่ถูกต้องกรุณาตรวจสอบอีกครั้ง',
                ]
            );

            $user = User::findOrFail($id);

            $user->email                   = $request->email;
            $user->update_by               = Auth::user()->name;
            $user->updated_at              = date('Y-m-d H:i:s');
            $user->save();

            $statusMail = $this->forgotPasswordSendmail($id);

            if($statusMail == 'ล้มเหลว') {
                return redirect()->route('login')->with('feedback-er', 'ส่งอีเมลไม่สำเร็จ!! กรุณาลองใหม่อีกครั้ง!');
            }else{
                return redirect()->route('fronend.account.forgotpassword.sent');
            }

    }
    public function forgotpasswordSent()
{
    $setting = TbSetting::first();
    $page_name = 'ส่งอีเมลสำเร็จ';

    $breadcrumb = [
        ['route' => route('fronend.home'), 'name' => 'หน้าหลัก'],
        ['route' => '', 'name' => $page_name],
    ];

    if(!empty($setting->setting_keyword)){ $og_keywords = $setting->setting_keyword; }else{ $og_keywords = "";}
    if(!empty($setting->setting_detail)){ $og_description = $setting->setting_detail; }else{ $og_description = "";}
    if(!empty($setting->setting_coverShare)){ $og_image = asset('storage/setting/'.$setting->setting_coverShare); }else{ $og_image = "";}

    return view('fontend.account.forgotpasswordSent', [
        'breadcrumb' => $breadcrumb,
        'og_site_name' => $page_name,
        'og_keywords' => $og_keywords,
        'og_title' => $page_name,
        'og_description' => $og_description,
        'og_url' => route('fronend.home'),
        'og_image' => $og_image,
        'page_name' => $page_name,
    ]);
}

    public function pdpa(){

        $setting = TbSetting::first();
        $extension = TbExtension::select('ext_captcha_status','ext_captcha')->first();
        $user = User::where('id',Auth::user()->id)->first();
        $settingUser = TbSettingUser::first();
        $extension = TbExtension::select('ext_captcha_status','ext_captcha')->first();
        $business = TbSettingCompanyBusiness::where('business_show',1)->orderBy('business_name','asc')->get();
        $position = TbSettingCompanyPosition::where('position_show',1)->orderBy('position_name','asc')->get();
        $privacyPolicy = TbPagesMap::first();

        $page_name = 'รับข้อมูลข่าวสารและบัญชี';

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

        return view('fontend.account.pdpa',[
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
            'privacyPolicy' => $privacyPolicy,
        ]);

    }

    public function pdpaUpdate(Request $request,$id){

        if($request->pdpa_news == 'on'){
            $pdpa_news = 1;
        }else{
            $pdpa_news = 2;
        }

        if($request->pdpa_article == 'on'){
            $pdpa_article = 1;
        }else{
            $pdpa_article = 2;
        }

        if($request->pdpa_product == 'on'){
            $pdpa_product = 1;
        }else{
            $pdpa_product = 2;
        }

        $data = User::findOrFail($id);
        $data->pdpa_news                    = $pdpa_news;
        $data->pdpa_article                 = $pdpa_article;
        $data->pdpa_product                 = $pdpa_product;
        $data->update_by                    = Auth::user()->displayname;
        $data->updated_at                   = date('Y-m-d H:i:s');
        $data->save();
        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }

    public function removeUser(Request $request,$id){

        $check = User::findOrFail($request->id);
        if(!empty($check)){
            @unlink(Storage::disk('public')->path('avatar/').$check->img);
        }
        User::where('id', $request->id)->delete();

        return redirect()->route('user.logout');

    }

    public function order(){

        $setting = TbSetting::first();
        $data = TbOrder::with('tb_setting_payment_status','tb_order_details')
        ->where('userCode',Auth::user()->user_code)
        ->orderBy('tb_order.created_at', 'desc')
        ->paginate(10);

        $page_name = 'คำสั่งซื้อ';

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

        return view('fontend.account.order',[
            'breadcrumb' => $breadcrumb,
            'og_site_name' => $og_site_name,
            'og_keywords' => $og_keywords,
            'og_title' => $og_title,
            'og_description' => $og_description,
            'og_url' => $og_url,
            'og_image' => $og_image,
            'page_name' => $page_name,
            'data' => $data,
        ]);

    }

    public function orderDetail($id){

        $setting = TbSetting::first();
        $data = TbOrder::with(
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
        ->orderBy('created_at', 'desc')
        ->findOrFail($id);

        $page_name = 'คำสั่งซื้อเลขที่: '.$data->orderNumber;

        $breadcrumb = [
            ['route' => route('fronend.home'), 'name' => 'หน้าหลัก'],
            ['route' => route('fronend.account.order'), 'name' => 'คำสั่งซื้อ'],
            ['route' => '', 'name' => 'คำสั่งซื้อเลขที่: '.$data->orderNumber],
        ];

        //title share
        if(!empty($page_name)){ $og_site_name = $page_name; }else{ $og_site_name = $page_name;}
        if(!empty($page_name)){ $og_title = $page_name; }else{ $og_title = $og_site_name = $page_name;}
        if(!empty($setting->setting_keyword)){ $og_keywords = $setting->setting_keyword; }else{ $og_keywords = "";}
        if(!empty($setting->setting_detail)){ $og_description = $setting->setting_detail; }else{ $og_description = "";}
        if(!empty($setting->setting_coverShare)){ $og_image = asset('storage/setting/'.$setting->setting_coverShare); }else{ $og_image = "";}
        if(!empty($page)){ $og_url = route('login'); }else{ $og_url = route('fronend.home');}

        return view('fontend.account.orderDetail',[
            'breadcrumb' => $breadcrumb,
            'og_site_name' => $og_site_name,
            'og_keywords' => $og_keywords,
            'og_title' => $og_title,
            'og_description' => $og_description,
            'og_url' => $og_url,
            'og_image' => $og_image,
            'page_name' => $page_name,
            'data' => $data,
        ]);

    }

    /**
     * ดาวน์โหลดใบเสร็จ/Invoice เป็น PDF ของคำสั่งซื้อ $id
     * ใช้ข้อมูลจริงจาก DB เดียวกับหน้า orderDetail() — ไม่มี mock
     * ต้องติดตั้งแพ็กเกจก่อน: composer require barryvdh/laravel-dompdf
     */
    public function invoiceDownload($id){

        $setting = TbSetting::first();

        $data = TbOrder::with(
            'tb_setting_payment_status',
            'tb_order_details',
            'tb_setting_province',
            'tb_setting_amphure',
            'tb_setting_district',
            'tb_receipt_province',
            'tb_receipt_amphures',
            'tb_receipt_district'
            )
        ->where('userCode', Auth::user()->user_code) // กันไม่ให้ user คนอื่นเดา id แล้วดาวน์โหลดใบเสร็จของคนอื่นได้
        ->findOrFail($id);

        $pdf = PDF::loadView('fontend.account.invoice_pdf', [
            'data' => $data,
            'setting' => $setting,
        ])->setPaper('a4', 'portrait');

        return $pdf->download('PTCAD-Invoice-'.$data->orderNumber.'.pdf');
    }

    public function orderCancel($id){

        $order = TbOrder::findOrFail($id);
        $order->payment_status      = 3;
        $order->save();

        $history = new HistoryOrderStatus();
        $history->orderNumber           = $order->orderNumber;
        $history->order_status          = 'ยกเลิกคำสั่งซื้อ';
        $history->updated_by            = Auth::user()->displayname;
        $history->updated_at            = date('Y-m-d H:i:s');
        $history->save();

        $this->send_mail_order_Touser($id);
        $this->send_mail_order_Tostaff($id);

        return back()->with('feedback', 'ยกเลิกคำสั่งซื้อเรียบร้อยแล้ว!');

    }

    public function software(Request $request){

        $setting = TbSetting::first();

        // ดึงข้อมูลทั้งหมดจาก DB ก่อน (ไม่ paginate ตรงนี้แล้ว เพราะต้องรวมกับ License API ก่อนค่อยแบ่งหน้า)
        $softwaresAll = TbSoftwareNotify::select(
            'tb_software_notify.id','tb_software_notify.userId','tb_software_notify.serial_number','tb_software_notify.productCode',
            'tb_software_notify.date_start','tb_software_notify.date_exp','tb_software_notify.price','tb_software_notify.show',
            'tb_software_notify.orderId','tb_software_notify.status','tb_software_notify.updated_at',
            'tb_product.pro_name','tb_product.pro_option','tb_product.pro_download',
            'tb_product.pro_installer','tb_product.pro_activation_guide','tb_product.pro_release_notes',
            'tb_product_detail.proId','tb_product_detail.detail_sku','tb_product_detail.detail_name'
        )
        ->leftjoin('tb_product_detail','tb_product_detail.detail_sku','tb_software_notify.productCode')
        ->leftjoin('tb_product','tb_product.id','tb_product_detail.proId')
        ->where('tb_software_notify.userId',Auth::user()->id)
        ->where('tb_software_notify.show',1)
        ->get();

        // ===================================================================
        // [PTCAD] เช็ค License จากระบบ PTCAD ตรงๆด้วย (ไม่ใช่แค่ DB เว็บเราอย่างเดียว)
        // เผื่อกรณี Sale สร้าง License ให้ตรงในระบบ PTCAD โดยไม่ผ่านเว็บเรา
        // จะไม่มี record ใน tb_software_notify เลย ต้องไปถาม PTCAD ตรงๆด้วย user_email
        // ===================================================================
        $userAuth = Auth::user();
        $remoteOnly = collect();

        $ptcadDownloadMap = []; // [เพิ่มใหม่] ย้ายมาไว้ตรงนี้ นอก try — กันไม่ให้ตัวแปรหายถ้า API error

try {
    $ptcadService = app(\App\Services\PtcadLicenseService::class);
    $remoteResult = $ptcadService->getLicensesByEmail($userAuth->email, (string) $userAuth->id);
} catch (\Exception $e) {
    \Log::warning('AccountController::software - ไม่สามารถเช็ค License จาก PTCAD ได้', [
        'userId' => $userAuth->id ?? null,
        'message' => $e->getMessage(),
    ]);
    $remoteResult = [];
}

    if (!empty($remoteResult['success']) && !empty($remoteResult['data']['licenses'])) {
        
        $localSerials = $softwaresAll->pluck('serial_number')->filter()->values()->toArray();

        foreach ($remoteResult['data']['licenses'] as $lic) {
            $serial = $lic['serialnumber'] ?? null;

            if (empty($serial)) {
                continue;
            }

            // [เพิ่มใหม่] เก็บไว้ก่อน continue ตัดออก — ใช้ได้ทั้ง License ที่มีอยู่ในเว็บเราแล้วและไม่มี
            $ptcadDownloadMap[$serial] = [
                'downloadlink' => $lic['downloadlink'] ?? null,
                'label'        => trim(($lic['product'] ?? '') . ' ' . ($lic['edition'] ?? '')),
            ];

            if (in_array($serial, $localSerials)) {
                continue;
            }



                    $remoteOnly->push((object) [
                        'id'                   => 'remote-' . preg_replace('/[^A-Za-z0-9]/', '', $serial),
                        'userId'               => $userAuth->id,
                        'serial_number'        => $serial,
                        'productCode'          => null,
                        'date_start'           => !empty($lic['timestart']) ? $lic['timestart'] : date('Y-m-d'),
                        'date_exp'             => !empty($lic['timeexpire']) ? $lic['timeexpire'] : date('Y-m-d', strtotime('+100 years')),
                        'price'                => 0,
                        'show'                 => 1,
                        'orderId'              => null,
                        'status'               => 2,
                        'updated_at'           => now(),
                        'pro_name'             => trim(($lic['product'] ?? '') . ' ' . ($lic['edition'] ?? '')),
                        'pro_option'           => 1,
                        'pro_download'         => null,
                        'pro_installer'        => null,
                        'pro_activation_guide' => null,
                        'pro_release_notes'    => null,
                        'proId'                => null,
                        'detail_sku'           => null,
                        'detail_name'          => null,
                    ]);
                }
            }
// ===================================================================
// [Civil ProMax] ดึง License Key ที่ลูกค้าคนนี้ซื้อไปแล้ว จาก tb_license_key_stock
// ===================================================================
$civilProMaxLicenses = \App\Models\LicenseKeyStock::select(
        'tb_license_key_stock.id','tb_license_key_stock.license_key','tb_license_key_stock.detail_sku',
        'tb_license_key_stock.used_at','tb_license_key_stock.orderId',
        'tb_product.pro_name','tb_product.pro_option','tb_product.pro_download',
        'tb_product.pro_installer','tb_product.pro_activation_guide','tb_product.pro_release_notes',
        'tb_product_detail.proId','tb_product_detail.detail_name',
        'tb_order_detail.product_price'   // [เพิ่มใหม่] ราคาจริงที่ลูกค้าจ่าย
    )
    ->join('tb_order', 'tb_order.id', 'tb_license_key_stock.orderId')
    ->leftjoin('tb_product_detail', 'tb_product_detail.detail_sku', 'tb_license_key_stock.detail_sku')
    ->leftjoin('tb_product', 'tb_product.id', 'tb_product_detail.proId')
    ->leftjoin('tb_order_detail', function($join) {
        $join->on('tb_order_detail.orderId', '=', 'tb_license_key_stock.orderId')
             ->on('tb_order_detail.product_sku', '=', 'tb_license_key_stock.detail_sku');
    })
    ->where('tb_license_key_stock.status', \App\Models\LicenseKeyStock::STATUS_USED)
    ->where('tb_order.userCode', $userAuth->user_code)
    ->get()
    ->map(function ($lic) {

        // คำนวณวันหมดอายุจาก used_at + ระยะเวลาตาม sku
        $months = match (true) {
            str_ends_with($lic->detail_sku, '-3M') => 3,
            str_ends_with($lic->detail_sku, '-6M') => 6,
            str_ends_with($lic->detail_sku, '-1Y') => 12,
            default => 12,
        };
        $dateStart = $lic->used_at ? \Carbon\Carbon::parse($lic->used_at) : now();
        $dateExp   = $dateStart->copy()->addMonths($months);

        return (object) [
            'id'                   => 'civilpromax-' . $lic->id,
            'userId'               => null,
            'serial_number'        => $lic->license_key,
            'productCode'          => $lic->detail_sku,
            'date_start'           => $dateStart->format('Y-m-d'),
            'date_exp'             => $dateExp->format('Y-m-d'),
            'price'                => $lic->product_price ?? 0,
            'show'                 => 1,
            'orderId'              => $lic->orderId,
            'status'               => 2,
            'updated_at'           => $dateStart,
            'pro_name'             => $lic->pro_name,
            'pro_option'           => $lic->pro_option,
            'pro_download'         => $lic->pro_download,
            'pro_installer'        => $lic->pro_installer,
            'pro_activation_guide' => $lic->pro_activation_guide,
            'pro_release_notes'    => $lic->pro_release_notes,
            'proId'                => $lic->proId,
            'detail_sku'           => $lic->detail_sku,
            'detail_name'          => $lic->detail_name,
            'is_civilpromax'       => true,   // [สำคัญ] ตัวบอก Blade ว่าไม่ต้องโชว์ Reset Hardware
        ];
    });
        $merged = $softwaresAll->concat($remoteOnly)->concat($civilProMaxLicenses);

        $merged = $merged->map(function($item) use ($ptcadDownloadMap) {
    // [เพิ่มใหม่] แนบลิงก์ดาวน์โหลดจาก PTCAD API เข้ากับทุก License ที่ตรง serial number
    $item->api_downloadlink = $ptcadDownloadMap[$item->serial_number]['downloadlink'] ?? null;
    $item->api_download_label = $ptcadDownloadMap[$item->serial_number]['label'] ?? null;

    $searchName = trim(($item->pro_name ?? '') . ' ' . ($item->detail_name ?? ''));

    // [เพิ่มใหม่] เช็ค Civil ProMax ก่อน — จาก detail_sku ตรงๆ ไม่ต้องเดาจากชื่อ
    if (!empty($item->detail_sku) && str_starts_with($item->detail_sku, 'CIVILPROMAX-')) {
        $item->version_label = match($item->detail_sku) {
            'CIVILPROMAX-3M' => 'Civil ProMax 3 เดือน',
            'CIVILPROMAX-6M' => 'Civil ProMax 6 เดือน',
            'CIVILPROMAX-1Y' => 'Civil ProMax 1 ปี',
            default => 'Civil ProMax',
        };
    } elseif (stripos($searchName, 'lite') !== false) {
        $item->version_label = 'Lite';
    } elseif (stripos($searchName, 'plus') !== false) {
        $item->version_label = 'Plus';
    } elseif (stripos($searchName, 'standard') !== false) {
        $item->version_label = 'Standard';
    } else {
        $item->version_label = 'Other';
    }

    // ตรวจจับ "ประเภท" จาก date_exp (case-insensitive + ตัดช่องว่างกันพลาด)
    // [แก้ใหม่] ตรวจจับ "ประเภท" จาก 2 ทาง: ทั้ง date_exp ตรงตัว และชื่อสินค้า
// เพราะบาง record เก็บ perpetual เป็นวันที่ไกลๆ ในอนาคต (เช่น +100 ปี) แทนคำว่า "perpetual" ตรงๆ
$expValue = strtolower(trim($item->date_exp ?? ''));
$isPerpetualByDate = ($expValue === 'perpetual');
$isPerpetualByName = (stripos($searchName, 'perpetual') !== false);
$item->type_label = ($isPerpetualByDate || $isPerpetualByName) ? 'Perpetual' : 'Subscription';

        // ค่าตัวเลขไว้ใช้ sort วันหมดอายุ (perpetual = ไกลสุด/ไม่มีวันหมด)
    $item->exp_sort_value = ($expValue === 'perpetual')
        ? PHP_INT_MAX
        : strtotime($item->date_exp);

        // [เพิ่มใหม่] เช็ควันที่เหลือ ≤ 30 วัน เพื่อโชว์ปุ่ม "ต่ออายุ"
    // Perpetual ไม่มีวันหมดอายุ ไม่ต้องโชว์ปุ่มนี้เลย
    // [แก้ไข] เพิ่มเงื่อนไข is_numeric($item->id) — โชว์ปุ่มเฉพาะ License ที่ซื้อผ่านเว็บเราเท่านั้น
    // (License จาก PTCAD ตรง/Civil ProMax ไม่มีราคาที่เชื่อถือได้ให้ต่ออายุ)
    if (!$isPerpetualByDate && !$isPerpetualByName && is_numeric($item->id)) {
        $daysRemaining = (int) ceil((strtotime($item->date_exp) - strtotime(date('Y-m-d'))) / 86400);
        $item->days_remaining = $daysRemaining;
        $item->show_renew_button = $daysRemaining <= 30;
    } else {
        $item->days_remaining = null;
        $item->show_renew_button = false;
    }

    return $item;
});

        if ($request->filled('version') && $request->version !== 'all') {
            $merged = $merged->filter(fn($item) => $item->version_label === $request->version);
        }
        if ($request->filled('type') && $request->type !== 'all') {
            $merged = $merged->filter(fn($item) => $item->type_label === $request->type);
        }

        $sort = $request->get('sort', 'updated_desc');
        switch ($sort) {
            case 'exp_asc':
                $merged = $merged->sortBy('exp_sort_value');
                break;
            case 'exp_desc':
                $merged = $merged->sortByDesc('exp_sort_value');
                break;
            default:
                $merged = $merged->sortByDesc('updated_at');
                break;
        }
        $merged = $merged->values();

        $perPage = 10;
        $currentPage = \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPage();
        $pagedItems = $merged->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $softwares = new \Illuminate\Pagination\LengthAwarePaginator(
            $pagedItems,
            $merged->count(),
            $perPage,
            $currentPage,
            [
                'path'  => \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPath(),
                'query' => $request->query(),
            ]
        );

        $page_name = 'ซอฟต์แวร์ของฉัน';

        $breadcrumb = [
            ['route' => route('fronend.home'), 'name' => 'หน้าหลัก'],
            ['route' => '', 'name' => $page_name],
        ];

        if(!empty($page_name)){ $og_site_name = $page_name; }else{ $og_site_name = $page_name;}
        if(!empty($page_name)){ $og_title = $page_name; }else{ $og_title = $og_site_name = $page_name;}
        if(!empty($setting->setting_keyword)){ $og_keywords = $setting->setting_keyword; }else{ $og_keywords = "";}
        if(!empty($setting->setting_detail)){ $og_description = $setting->setting_detail; }else{ $og_description = "";}
        if(!empty($setting->setting_coverShare)){ $og_image = asset('storage/setting/'.$setting->setting_coverShare); }else{ $og_image = "";}
        if(!empty($page)){ $og_url = route('login'); }else{ $og_url = route('fronend.home');}

        return view('fontend.account.software.main',[
            'breadcrumb' => $breadcrumb,
            'og_site_name' => $og_site_name,
            'og_keywords' => $og_keywords,
            'og_title' => $og_title,
            'og_description' => $og_description,
            'og_url' => $og_url,
            'og_image' => $og_image,
            'page_name' => $page_name,
            'softwares' => $softwares,
        ]);

    }

    private function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
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

        $data = new \stdClass();
        $data->setting_nameWeb = $setting->setting_nameWeb;
        $data->setting_logoWeb = $setting->setting_logoWeb;
        $data->order = $order;
        $data->page = $page;
        $data->user = $user;
        $data->staff = $staff;

        if(!empty($setting->setting_email_bcc)){
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

    }

    private function forgotPasswordSendmail($id){

        $user = User::findOrFail($id);
        $setting = TbSetting::first();
        $page = TbPagesMap::first();

        $data = new \stdClass();
        $data->page                     = $page;
        $data->setting_nameWeb          = $setting->setting_nameWeb;
        $data->setting_logoWeb          = $setting->setting_logoWeb;
        $data->id                       =  $user->id;
        $data->user_code                = $user->user_code;
        $data->sender                   = 'กู้รหัสผ่านบัญชีผู้ใช้ '.$setting->setting_nameWeb.' ของคุณ';
		
		try{
			Mail::to($user->email)->later(now()->addMinutes(5), new forgotMail($data));
			
			if(Mail::failures()) { $mailStatus = 'ล้มเหลว'; }else{ $mailStatus = 'สำเร็จ'; }
		}catch(\Exception $e){
			// Never reached
			$mailStatus = 'ล้มเหลว';
		}

        $history                            = new HistorySendMail();
        $history->userId                    = $user->id;
        $history->remark                    = "ลืมรหัสผ่าน";
        $history->status                    = $mailStatus;
        $history->created_by                = 'SYSTEM';
        $history->created_at                = date('Y-m-d H:i:s');
        $history->updated_at                = date('Y-m-d H:i:s');
        $history->save();

        return $mailStatus;
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
        /**
     * สร้าง Stripe Checkout Session สำหรับ "ต่ออายุ License" — จ่ายตรงทันที ไม่ผ่านตะกร้า
     * ใช้ราคาเดิมตอนซื้อครั้งแรก (tb_software_notify.price)
     */
    public function renewCheckout($id)
    {
        $notify = \App\Models\TbSoftwareNotify::where('id', $id)
            ->where('userId', Auth::user()->id)
            ->first();

        if (empty($notify)) {
            return redirect()->route('fronend.account.software')
                ->with('feedback-er', 'ไม่พบ License นี้ในบัญชีของคุณ');
        }

        $amountInSatang = (int) round(((float) $notify->price) * 100);

        if ($amountInSatang <= 0) {
            return redirect()->route('fronend.account.software')
                ->with('feedback-er', 'ไม่พบราคาสำหรับต่ออายุ License นี้ กรุณาติดต่อเจ้าหน้าที่');
        }

        $response = \Illuminate\Support\Facades\Http::asForm()
            ->withToken(env('STRIPE_SECRET_KEY'))
            ->post('https://api.stripe.com/v1/checkout/sessions', [
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'thb',
                        'product_data' => [
                            'name' => 'ต่ออายุ License: ' . $notify->productCode,
                        ],
                        'unit_amount' => $amountInSatang,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('fronend.account.software') . '?renew=success',
                'cancel_url'  => route('fronend.account.software') . '?renew=cancel',
                'metadata' => [
                    'type' => 'renew_license',
                    'renewSoftwareNotifyId' => (string) $notify->id,
                ],
            ]);

        if ($response->failed()) {
            \Log::error('Stripe renew checkout session creation failed', [
                'response' => $response->body(),
                'notifyId' => $notify->id,
            ]);
            return redirect()->route('fronend.account.software')
                ->with('feedback-er', 'ไม่สามารถเชื่อมต่อ Stripe ได้ กรุณาลองใหม่');
        }

        $session = $response->json();
        return redirect($session['url']);
    }
    public function verifyEmailChange($token)
{
    $user = User::where('email_verify_token', $token)->first();

    if (empty($user)) {
        return redirect()->route('login')->with('feedback-er', 'ลิงก์ยืนยันไม่ถูกต้อง หรือถูกใช้ไปแล้ว');
    }

    if (empty($user->email_verify_token_expires_at) || now()->greaterThan($user->email_verify_token_expires_at)) {
        return redirect()->route('login')->with('feedback-er', 'ลิงก์ยืนยันหมดอายุแล้ว กรุณาขอลิงก์ใหม่อีกครั้ง');
    }

    // ===== เคสที่ 1: ยืนยันตอนเปลี่ยนอีเมล (มี pending_email) =====
    if (!empty($user->pending_email)) {
        $emailTaken = User::where('email', $user->pending_email)->where('id', '!=', $user->id)->exists();
        if ($emailTaken) {
            $user->pending_email = null;
            $user->email_verify_token = null;
            $user->email_verify_token_expires_at = null;
            $user->save();
            return redirect()->route('login')->with('feedback-er', 'อีเมลนี้ถูกใช้งานโดยบัญชีอื่นไปแล้ว');
        }

        $user->email = $user->pending_email;
        $user->pending_email = null;
        $user->email_verify_token = null;
        $user->email_verify_token_expires_at = null;
        $user->email_verified_at = now(); // ถือว่ายืนยันแล้วไปด้วยเลย
        $user->save();

        if (Auth::check() && Auth::id() == $user->id) {
            return redirect()->route('fronend.account')->with('feedback', 'เปลี่ยนอีเมลสำเร็จแล้ว!');
        }
        return redirect()->route('login')->with('feedback', 'เปลี่ยนอีเมลสำเร็จแล้ว! กรุณาเข้าสู่ระบบด้วยอีเมลใหม่');
    }

    // ===== เคสที่ 2: ยืนยันตอนสมัครสมาชิก (ไม่มี pending_email) =====
$user->email_verify_token = null;
$user->email_verify_token_expires_at = null;
$user->email_verified_at = now();
$user->save();

Auth::login($user);

return redirect()->route('fronend.account')->with('feedback', 'ยืนยันอีเมลสำเร็จแล้ว! ยินดีต้อนรับเข้าสู่ PTCAD');
}
}