<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Providers\RouteServiceProvider;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Storage;

use App\Models\TbSetting;
use App\Models\TbExtension;
use App\Models\LogTag;
use App\Models\TbSettingPayment;
use App\Models\TbProductCondition;
use App\Models\TbHeroBanner;
use App\Models\TbBanner;

class SettingController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $breadcrumb = [
            ['name' => 'ตั้งค่าเว็บไซต์'],
        ];
        $title_page = 'ตั้งค่าเว็บไซต์';


        $seting = TbSetting::first();

        return view('admin.setting.main', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => $seting,
        ]);
    }

    public function contact()
    {

        $breadcrumb = [
            ['name' => 'ข้อมูลติดต่อเรา'],
        ];
        $title_page = 'ข้อมูลติดต่อเรา';

        $contact = TbSetting::first();

        return view('admin.setting.contact', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => $contact,
        ]);
    }

    public function extensions(){

        $breadcrumb = [
            ['name' => 'ตั้งค่าเพิ่มเติม'],
        ];
        $title_page = 'ตั้งค่าเพิ่มเติม';


        $seting = TbExtension::first();

        return view('admin.setting.extensions', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => $seting,
        ]);

    }

    public function updateSeting(Request $request,$id){

        if($request->setting_birthday == 'on'){
            $setting_birthday = 1;
        }else{
            $setting_birthday = 2;
        }
        if($request->setting_ssl == 'on'){
            $setting_ssl = 1;
        }else{
            $setting_ssl = 2;
        }

        $data = TbSetting::findOrFail($id);

        $data->setting_nameWeb              = $request->setting_nameWeb;
        $data->setting_detail               = $request->setting_detail;
        $data->setting_keyword              = $request->setting_keyword;
        $data->setting_birthday             = $setting_birthday;
        $data->setting_DBD                  = $request->setting_DBD;
        $data->setting_ssl                  = $setting_ssl;
        $data->setting_email_bcc            = $request->setting_email_bcc;
        $data->setting_email_support        = $request->setting_email_support;
        $data->updated_by                   = Auth::user()->displayname;
        $data->updated_at                   = date('Y-m-d H:i:s');

        if (!empty($request->setting_logoWeb)) {

            if ($request->hasFile('setting_logoWeb')) {
                @unlink(Storage::disk('public')->path('setting/') . $request->setting_logoWeb_old);

                $newFilename = uniqid() . '.' . $request->setting_logoWeb->extension();
                $data->setting_logoWeb = $newFilename;
                $file = $request->file('setting_logoWeb');
                $file->move('storage/setting/', $newFilename);
            }

        }

        if (!empty($request->setting_logoWeb_mobile)) {

            if ($request->hasFile('setting_logoWeb_mobile')) {
                @unlink(Storage::disk('public')->path('setting/') . $request->setting_logoWeb_mobile_old);

                $newFilename = uniqid() . '.' . $request->setting_logoWeb_mobile->extension();
                $data->setting_logoWeb_mobile = $newFilename;
                $file = $request->file('setting_logoWeb_mobile');
                $file->move('storage/setting/', $newFilename);
            }

        }

        if (!empty($request->setting_iconWeb)) {

            if ($request->hasFile('setting_iconWeb')) {
                @unlink(Storage::disk('public')->path('setting/') . $request->setting_iconWeb_old);

                $newFilename = uniqid() . '.' . $request->setting_iconWeb->extension();
                $data->setting_iconWeb = $newFilename;
                $file = $request->file('setting_iconWeb');
                $file->move('storage/setting/', $newFilename);
            }

        }

        if (!empty($request->setting_coverShare)) {

            if ($request->hasFile('setting_coverShare')) {
                @unlink(Storage::disk('public')->path('setting/') . $request->setting_coverShare_old);

                $newFilename = uniqid() . '.' . $request->setting_coverShare->extension();
                $data->setting_coverShare = $newFilename;
                $file = $request->file('setting_coverShare');
                $file->move('storage/setting/', $newFilename);
            }

        }

        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }

    public function deleteLogo(Request $request){

        $check = TbSetting::first();
        if (!empty($check->setting_logoWeb)) {
            @unlink(Storage::disk('public')->path('setting/').$check->setting_logoWeb);
        }

        $data = TbSetting::first();
        $data->setting_logoWeb              = null;
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }

    public function deleteLogoMobile(Request $request){

        $check = TbSetting::first();
        if (!empty($check->setting_logoWeb_mobile)) {
            @unlink(Storage::disk('public')->path('setting/').$check->setting_logoWeb_mobile);
        }

        $data = TbSetting::first();
        $data->setting_logoWeb_mobile              = null;
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }

    public function deleteIcon(Request $request){

        $check = TbSetting::first();
        if (!empty($check->setting_iconWeb)) {
            @unlink(Storage::disk('public')->path('setting/').$check->setting_iconWeb);
        }

        $data = TbSetting::first();
        $data->setting_iconWeb              = null;
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }

    public function deleteCover(Request $request){

        $check = TbSetting::first();
        if (!empty($check->setting_coverShare)) {
            @unlink(Storage::disk('public')->path('setting/').$check->setting_coverShare);
        }

        $data = TbSetting::first();
        $data->setting_coverShare              = null;
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }

    public function updateContact(Request $request,$id){

        $data = TbSetting::findOrFail($id);

        $data->setting_telContact                   = $request->setting_telContact;
        $data->setting_hotlineContact               = $request->setting_hotlineContact;
        $data->setting_faxContact                   = $request->setting_faxContact;
        $data->setting_emailContact                 = $request->setting_emailContact;
        $data->setting_idLine                       = $request->setting_idLine;
        $data->setting_remoteLink                   = $request->setting_remoteLink;
        $data->setting_LinkYoutube                  = $request->setting_LinkYoutube;
        $data->setting_LinkTwitter                  = $request->setting_LinkTwitter;
        $data->setting_LinkInstagram                = $request->setting_LinkInstagram;
        $data->setting_LinkFacebook                 = $request->setting_LinkFacebook;
        $data->setting_address                      = $request->setting_address;
        $data->setting_companyTime                  = $request->setting_companyTime;
        $data->setting_websiteTime                  = $request->setting_websiteTime;
        $data->updated_by                           = Auth::user()->displayname;
        $data->updated_at                           = date('Y-m-d H:i:s');
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }

    public function crateExtensions(Request $request){

        if($request->ext_captcha_status == 'on'){
            $show = 1;
        }else{
            $show = 2;
        }

        if($request->ext_lineNotify_status == 'on'){
            $ext_lineNotify_status = 1;
        }else{
            $ext_lineNotify_status = 2;
        }


        if($request->ext_google_status == 'on'){
            $ext_google_status = 1;
        }else{
            $ext_google_status = 2;
        }


        if($request->ext_facebook_status == 'on'){
            $ext_facebook_status = 1;
        }else{
            $ext_facebook_status = 2;
        }

        $data = new TbExtension;
        $data->ext_googleWebmaster       = $request->ext_googleWebmaster;
        $data->ext_googleAnalytics       = $request->txt_detail;
        $data->ext_googleAdsense         = $request->ext_googleAdsense_txt;
        $data->ext_histats               = $request->ext_histats;
        $data->ext_captcha_status        = $show;
        $data->ext_captcha               = $request->ext_histats;
        $data->ext_lineNotify_status     = $ext_lineNotify_status;
        $data->ext_lineNotify            = $request->ext_lineNotify;
        $data->ext_google_status         = $ext_google_status;
        $data->ext_google_clientId       = $request->ext_google_clientId;
        $data->ext_google_clientSecret   = $request->ext_google_clientSecret;
        $data->ext_facebook_status       = $ext_facebook_status;
        $data->ext_facebook_clientId     = $request->ext_lineNotify;
        $data->ext_facebook_clientSecret = $request->ext_facebook_clientSecret;
        $data->created_by                = Auth::user()->displayname;
        $data->created_at                = date('Y-m-d H:i:s');
        $data->updated_by                = Auth::user()->displayname;
        $data->updated_at                = date('Y-m-d H:i:s');
        $data->save();

        return back()->with('feedback', 'เพิ่มข้อมูลเรียบร้อยแล้ว!');


    }

    public function updateExtensions(Request $request,$id){

        if($request->ext_captcha_status == 'on'){
            $show = 1;
        }else{
            $show = 2;
        }

        if($request->ext_lineNotify_status == 'on'){
            $ext_lineNotify_status = 1;
        }else{
            $ext_lineNotify_status = 2;
        }

        if($request->ext_google_status == 'on'){
            $ext_google_status = 1;
        }else{
            $ext_google_status = 2;
        }


        if($request->ext_facebook_status == 'on'){
            $ext_facebook_status = 1;
        }else{
            $ext_facebook_status = 2;
        }

        $data = TbExtension::findOrFail($id);
        $data->ext_googleWebmaster       = $request->ext_googleWebmaster;
        $data->ext_googleAnalytics       = $request->ext_googleAnalytics;
        $data->ext_googleAdsense         = $request->ext_googleAdsense;
        $data->ext_histats               = $request->ext_histats;
        $data->ext_captcha_status        = $show;
        $data->ext_captcha               = $request->ext_captcha;
        $data->ext_lineNotify_status     = $ext_lineNotify_status;
        $data->ext_lineNotify            = $request->ext_lineNotify;
        $data->ext_google_status         = $ext_google_status;
        $data->ext_google_clientId       = $request->ext_google_clientId;
        $data->ext_google_clientSecret   = $request->ext_google_clientSecret;
        $data->ext_facebook_status       = $ext_facebook_status;
        $data->ext_facebook_clientId     = $request->ext_lineNotify;
        $data->ext_facebook_clientSecret = $request->ext_facebook_clientSecret;
        $data->updated_by                = Auth::user()->displayname;
        $data->updated_at                = date('Y-m-d H:i:s');
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }

    public function logtag(){
        $breadcrumb = [
            ['name' => 'Tag Manager'],
        ];
        $title_page = 'Tag Manager';

        $logtags = LogTag::first();


        return view('admin.setting.logtag', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'tag' => $logtags->value,
            'logtags' => $logtags,
        ]);
    }

    public function logtagUpdate(Request $request){


        $data = LogTag::findOrFail(1);
        $data->value        = $request->logTag;
        $data->updated_by   = Auth::user()->displayname;
        $data->updated_at   = date('Y-m-d H:i:s');
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }

    public function payment()
    {

        $breadcrumb = [
            ['name' => 'ตั้งค่าการชำระเงิน'],
        ];
        $title_page = 'ตั้งค่าการชำระเงิน';

        $data = TbSettingPayment::first();
        $conditions = TbProductCondition::where('condition_show',1)->get();

        return view('admin.setting.payment', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'conditions' => $conditions,
            'data' => $data,
        ]);
    }

    public function cratePayment(Request $request){

        if($request->bank_transfer_status == 'on'){
            $bank_transfer_status = 1;
        }else{
            $bank_transfer_status = 2;
        }

        if($request->credit_card_status == 'on'){
            $credit_card_status = 1;
        }else{
            $credit_card_status = 2;
        }

        if($request->installment_status == 'on'){
            $installment_status = 1;
        }else{
            $installment_status = 2;
        }
		
		if($request->promtpay_status == 'on'){
            $promtpay_status = 1;
        }else{
            $promtpay_status = 2;
        }
		
		if($request->mobile_banking_status == 'on'){
            $mobile_banking_status = 1;
        }else{
            $mobile_banking_status = 2;
        }
		
		if($request->truemoney_status == 'on'){
            $truemoney_status = 1;
        }else{
            $truemoney_status = 2;
        }

        $data = new TbSettingPayment;
        $data->bank_transfer_status             = $bank_transfer_status;
        $data->credit_card_status               = $credit_card_status;
        $data->installment_status               = $installment_status;
		$data->promtpay_status             		= $promtpay_status;
        $data->mobile_banking_status            = $mobile_banking_status;
        $data->truemoney_status               	= $truemoney_status;
        $data->conditionId                      = $request->conditionId;
        $data->omise_status                     = $request->omise_status;
        $data->omise_public_key_for_live        = $request->omise_public_key_for_live;
        $data->omise_secret_key_for_live        = $request->omise_secret_key_for_live;
        $data->omise_public_key_for_test        = $request->omise_public_key_for_test;
        $data->omise_secret_key_for_test        = $request->omise_secret_key_for_test;
        $data->created_by                       = Auth::user()->displayname;
        $data->created_at                       = date('Y-m-d H:i:s');
        $data->updated_by                       = Auth::user()->displayname;
        $data->updated_at                       = date('Y-m-d H:i:s');
        $data->save();

        return back()->with('feedback', 'เพิ่มข้อมูลเรียบร้อยแล้ว!');
    }

    public function updatePayment(Request $request){

        if($request->bank_transfer_status == 'on'){
            $bank_transfer_status = 1;
        }else{
            $bank_transfer_status = 2;
        }

        if($request->credit_card_status == 'on'){
            $credit_card_status = 1;
        }else{
            $credit_card_status = 2;
        }

        if($request->installment_status == 'on'){
            $installment_status = 1;
        }else{
            $installment_status = 2;
        }
		
		if($request->promtpay_status == 'on'){
            $promtpay_status = 1;
        }else{
            $promtpay_status = 2;
        }
		
		if($request->mobile_banking_status == 'on'){
            $mobile_banking_status = 1;
        }else{
            $mobile_banking_status = 2;
        }
		
		if($request->truemoney_status == 'on'){
            $truemoney_status = 1;
        }else{
            $truemoney_status = 2;
        }

        $data = TbSettingPayment::findOrFail(1);
        $data->bank_transfer_status             = $bank_transfer_status;
        $data->credit_card_status               = $credit_card_status;
        $data->installment_status               = $installment_status;
		$data->promtpay_status             		= $promtpay_status;
        $data->mobile_banking_status            = $mobile_banking_status;
        $data->truemoney_status               	= $truemoney_status;
        $data->conditionId                      = $request->conditionId;
        $data->omise_status                     = $request->omise_status;
        $data->omise_public_key_for_live        = $request->omise_public_key_for_live;
        $data->omise_secret_key_for_live        = $request->omise_secret_key_for_live;
        $data->omise_public_key_for_test        = $request->omise_public_key_for_test;
        $data->omise_secret_key_for_test        = $request->omise_secret_key_for_test;
        $data->updated_by                       = Auth::user()->displayname;
        $data->updated_at                       = date('Y-m-d H:i:s');
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }
     public function heroBanner(Request $request)
    {
        $breadcrumb = [
            ['name' => 'Hero Banner หน้าแรก'],
        ];
        $title_page = 'Hero Banner หน้าแรก';
 
        $data = TbHeroBanner::first();
        $banners = TbBanner::orderBy('banner_sort','desc')->get();

        // ถ้ามี ?edit_id=xx แนบมา ให้โหลดข้อมูลแบนเนอร์นั้นมาเติมในฟอร์มแก้ไข (ฟอร์มเดียวกับฟอร์มเพิ่ม)
        $editingBanner = null;
        if (!empty($request->edit_id)) {
            $editingBanner = TbBanner::find($request->edit_id);
        }

        $sort = TbBanner::orderBy('banner_sort','desc')->first();
 
        return view('admin.setting.herobanner', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => $data,
            'banners' => $banners,
            'editingBanner' => $editingBanner,
            'sort' => $sort,
        ]);
    }
 
    /**
     * บันทึกแค่ hero_mode ทันทีที่สลับ radio (เรียกผ่าน AJAX)
     * แยกจาก updateHeroBanner() เพื่อไม่ต้องกรอก/ยืนยันฟิลด์อื่นก่อนสลับโหมดได้
     */
    public function updateHeroMode(Request $request, $id)
    {
        $data = TbHeroBanner::findOrFail($id);
        $data->hero_mode = !empty($request->hero_mode) ? $request->hero_mode : 1;
        $data->save();

        return response()->json(['status' => 'success']);
    }

    public function updateHeroBanner(Request $request, $id)
    {
        if ($request->hero_btn1_status == 'on') {
            $btn1_status = 1;
        } else {
            $btn1_status = 2;
        }
 
        if ($request->hero_btn2_status == 'on') {
            $btn2_status = 1;
        } else {
            $btn2_status = 2;
        }
 
        $data = TbHeroBanner::findOrFail($id);
        $data->hero_mode             = !empty($request->hero_mode) ? $request->hero_mode : 1;
        $data->hero_full_image_link  = $request->hero_full_image_link;
        $data->hero_title           = $request->hero_title;
        $data->hero_price           = $request->hero_price;
        $data->hero_price_unit      = $request->hero_price_unit;
        $data->hero_bullet1         = $request->hero_bullet1;
        $data->hero_bullet2         = $request->hero_bullet2;
        $data->hero_bullet3         = $request->hero_bullet3;
        $data->hero_bullet4         = $request->hero_bullet4;
        $data->hero_btn1_text       = $request->hero_btn1_text;
        $data->hero_btn1_link       = $request->hero_btn1_link;
        $data->hero_btn1_status     = $btn1_status;
        $data->hero_btn2_text       = $request->hero_btn2_text;
        $data->hero_btn2_link       = $request->hero_btn2_link;
        $data->hero_btn2_status     = $btn2_status;
        $data->member_access_link   = $request->member_access_link;
        $data->trial_download_link  = $request->trial_download_link;
        $data->business_quote_link  = $request->business_quote_link;
        $data->updated_by           = Auth::user()->displayname;
        $data->updated_at           = date('Y-m-d H:i:s');
 
        if (!empty($request->hero_image)) {
            if ($request->hasFile('hero_image')) {
                @unlink(Storage::disk('public')->path('setting/') . $request->hero_image_old);
 
                $newFilename = uniqid() . '.' . $request->hero_image->extension();
                $data->hero_image = $newFilename;
                $file = $request->file('hero_image');
                $file->move('storage/setting/', $newFilename);
            }
        }
 
        if (!empty($request->hero_bg_image)) {
            if ($request->hasFile('hero_bg_image')) {
                @unlink(Storage::disk('public')->path('setting/') . $request->hero_bg_image_old);
 
                $newFilename = uniqid() . '.' . $request->hero_bg_image->extension();
                $data->hero_bg_image = $newFilename;
                $file = $request->file('hero_bg_image');
                $file->move('storage/setting/', $newFilename);
            }
        }

        if (!empty($request->hero_full_image)) {
            if ($request->hasFile('hero_full_image')) {
                @unlink(Storage::disk('public')->path('setting/') . $request->hero_full_image_old);

                $newFilename = uniqid() . '.' . $request->hero_full_image->extension();
                $data->hero_full_image = $newFilename;
                $file = $request->file('hero_full_image');
                $file->move('storage/setting/', $newFilename);
            }
        }
 
        $data->save();
 
        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');
    }

    public function deleteHeroFullImage(Request $request)
    {
        $check = TbHeroBanner::first();
        if (!empty($check->hero_full_image)) {
            @unlink(Storage::disk('public')->path('setting/') . $check->hero_full_image);
        }

        $data = TbHeroBanner::first();
        $data->hero_full_image = null;
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');
    }
 
    public function deleteHeroImage(Request $request)
    {
        $check = TbHeroBanner::first();
        if (!empty($check->hero_image)) {
            @unlink(Storage::disk('public')->path('setting/') . $check->hero_image);
        }
 
        $data = TbHeroBanner::first();
        $data->hero_image = null;
        $data->save();
 
        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');
    }
 
    public function deleteHeroBgImage(Request $request)
    {
        $check = TbHeroBanner::first();
        if (!empty($check->hero_bg_image)) {
            @unlink(Storage::disk('public')->path('setting/') . $check->hero_bg_image);
        }
 
        $data = TbHeroBanner::first();
        $data->hero_bg_image = null;
        $data->save();
 
        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');
    }


}