<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\TbSetting;
use App\Models\TbExtension;
use App\Models\TbSettingUser;
use App\Models\TbSettingCompanyBusiness;
use App\Models\TbSettingCompanyPosition;
use App\Models\UserGetmember;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::CONFIRMATION;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */

    protected function validator(array $data)
    {
        if($data['user_type'] == 2){

            return Validator::make($data, [
                'user_company_name' => ['required', 'max:255'],
                'name_contact' => ['required',  'max:255'],
                'lastname_contact' => ['required',  'max:255'],
                'email' => ['required', 'email', 'max:255', 'unique:users'],
                'user_tel' => ['required',  'max:255'],
                'password' => ['required', 'min:8', 'confirmed'],
            ],
            [

                'user_company_name.required' => 'กรุณากรอกข้อมูล',
                'user_company_name.max' => 'กรอกข้อมูลได้ไม่เกิน 255 ตัวอักษร',
                'name_contact.required' => 'กรุณากรอกข้อมูล',
                'name_contact.max' => 'กรอกข้อมูลได้ไม่เกิน 255 ตัวอักษร',
                'lastname_contact.required' => 'กรุณากรอกข้อมูล',
                'lastname_contact.max' => 'กรอกข้อมูลได้ไม่เกิน 255 ตัวอักษร',
                'user_tel.required' => 'กรุณากรอกข้อมูล',
                'user_tel.max' => 'กรอกข้อมูลได้ไม่เกิน 255 ตัวอักษร',
                'email.required' => 'กรุณากรอกข้อมูล',
                'email.email' => 'รูปแบบอีเมลไม่ถูกต้อง กรุณาตรวจสอบข้อมูล',
                'email.max' => 'กรอกข้อมูลได้ไม่เกิน 255 ตัวอักษร',
                'email.unique' => 'อีเมลนี้มีการใช้งานอยู่แล้ว กรุณาตรวจสอบข้อมูลอีกครั้ง',
                'password.required' => 'กรุณากรอกข้อมูล',
                'password.min' => 'รหัสผ่านต้องไม่น้อยกว่า 8 ตัวอักษร',
                'password.confirmed' => 'รหัสผ่านไม่ตรงกัน กรุณาตรวจสอบข้อมูล',
            ]);
        }else{
    return Validator::make($data, [
        'name' => ['required',  'max:255'],
        'lastname' => ['required',  'max:255'],
        'user_tel' => ['required',  'max:255'],
        'email' => ['required', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'min:8', 'confirmed'],
    ],
    [
        'name.required' => 'กรุณากรอกข้อมูล',
        'name.max' => 'กรอกข้อมูลได้ไม่เกิน 255 ตัวอักษร',
        'lastname.required' => 'กรุณากรอกข้อมูล',
        'lastname.max' => 'กรอกข้อมูลได้ไม่เกิน 255 ตัวอักษร',
        'user_tel.required' => 'กรุณากรอกข้อมูล',
        'user_tel.max' => 'กรอกข้อมูลได้ไม่เกิน 255 ตัวอักษร',
        'email.required' => 'กรุณากรอกข้อมูล',
        'email.email' => 'รูปแบบอีเมลไม่ถูกต้อง กรุณาตรวจสอบข้อมูล',
        'email.max' => 'กรอกข้อมูลได้ไม่เกิน 255 ตัวอักษร',
        'email.unique' => 'อีเมลนี้มีการใช้งานอยู่แล้ว กรุณาตรวจสอบข้อมูลอีกครั้ง',
        'password.required' => 'กรุณากรอกข้อมูล',
        'password.min' => 'รหัสผ่านต้องไม่น้อยกว่า 8 ตัวอักษร',
        'password.confirmed' => 'รหัสผ่านไม่ตรงกัน กรุณาตรวจสอบข้อมูล',
    ]);
}
    }
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        // [เพิ่มใหม่] สร้าง "ชื่อที่ใช้แสดง" อัตโนมัติ — ไม่ต้องให้ผู้ใช้กรอกเองแล้ว
    if ($data['user_type'] == 2) {
        $data['displayname'] = trim($data['user_company_name'] ?? '');
    } else {
        $data['displayname'] = trim(($data['name'] ?? '') . ' ' . ($data['lastname'] ?? ''));
    }
		# Block Bot -- only run this check when reCAPTCHA is actually enabled AND has valid keys configured
		$extensionCaptcha = TbExtension::select('ext_captcha_status', 'ext_captcha')->first();
		if(!empty($extensionCaptcha) && $extensionCaptcha->ext_captcha_status == 1 && !empty($extensionCaptcha->ext_captcha) && !empty(env('RECAPTCHA_SECRET_KEY'))){
			if(isset($data['g-recaptcha-response'])) {
				// Build POST request:
				$recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
				$recaptcha_secret = env('RECAPTCHA_SECRET_KEY');
				$recaptcha_response = $data['g-recaptcha-response'];

				// Make and decode POST request:
				$recaptcha = @file_get_contents($recaptcha_url.'?secret='.$recaptcha_secret.'&response='.$recaptcha_response);
				$recaptcha = json_decode($recaptcha);

				// Take action based on the score returned:
				if (!empty($recaptcha->score) && $recaptcha->score >= 0.5) {
					// Verified
				} else {
					abort(403, 'reCAPTCHA verification failed');
				}
			}
		}

        $user_code = $this->generateRandomString();

        if(!empty($data['pdpa_wording1']) == 1){
            $pdpa_news = '1';
            $pdpa_article = '1';
            $pdpa_product = '1';
        }else{
            $pdpa_news = '2';
            $pdpa_article = '2';
            $pdpa_product = '2';
        }

        if($data['user_type'] == 2){
            $name = $data['name_contact'];
            $lastname = $data['lastname_contact'];
        }else{
            $name = $data['name'];
            $lastname = $data['lastname'];
        }

        if(!empty($data['businessId'])){
            $businessId = $data['businessId'];
        }else{
            $businessId = null;
        }

        if(!empty($data['positionId'])){
            $positionId = $data['positionId'];
        }else{
            $positionId = null;
        }
        if(!empty($data['user_code_friend'])){
            $user_code_friend = $data['user_code_friend'];

            $checkUser = User::select('user_code','staffId')->where('user_code',$user_code_friend)->first();
            if(!empty($checkUser)){
                $checkStaff = User::select('id','name','lastname')->where('id',$checkUser->staffId)->first();
				
				if($checkStaff) {
					$staff = $checkStaff->name.' '.$checkStaff->lastname;
				} else {
					$staff = 'ยังไม่มีผู้รับผิดชอบ';
				}
            }else{
                $staff = 'ยังไม่มีผู้รับผิดชอบ';
            }
        }else{
            $user_code_friend = null;
            $staff = 'ยังไม่มีผู้รับผิดชอบ';
        }

        if(!empty($data['user_code_friend'])){
            $user_code_friend_status = 2;
        }else{
            $user_code_friend_status = null;
        }

        if(!empty($data['user_code_friend'])){
            $getmember                  = new UserGetmember;
            $getmember->userCode        = $user_code;
            $getmember->userCode_Ref    = $user_code_friend;
            $getmember->status          = $user_code_friend_status;
            $getmember->created_by      = $data['displayname'];
            $getmember->created_at      = date('Y-m-d H:i:s');
            $getmember->save();
        }

        $extension = TbExtension::first();
        if(!empty($extension)){
            if($extension->ext_lineNotify_status == 1){
                if(!empty($extension->ext_lineNotify)){

                    $Token = 'Bearer '.$extension->ext_lineNotify;
                    $Message = "\n----------------------------------\nสมาชิกใหม่!!.\nรหัสผู้ใช้ $user_code\nชื่อ - นามสกุล : $name $lastname\nผู้รับผิดชอบ : $staff\n\n----------------------------------\nกรุณาตรวจสอบข้อมูล\nเพื่อดำเนินการต่อไป\n----------------------------------\nคลิกดูรายละเอียด ".route('user.edit',['id'=>$user_code]);
                    $this->notify_message($Message, $Token);
                }
            }

        }

        return User::create([
            'user_code_friend' => $user_code_friend,
            'user_code_friend_status' => $user_code_friend_status,
            'user_type' => $data['user_type'],
            'user_code' => $user_code,
            'tel' => $data['user_tel'],
            'displayname' => $data['displayname'],
            'name' => $name,
            'lastname' => $lastname,
            'company_name' => $data['user_company_name'],
            'sex' => '3',
            //'hbd_day' => $data['hbd_day'],
            //'hbd_month' => $data['hbd_month'],
            //'hbd_year' => $data['hbd_year'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'level' => 6,
            'businessId' => $businessId,
            'positionId' => $positionId,
            'pdpa_news' => $pdpa_news,
            'pdpa_article' => $pdpa_article,
            'pdpa_product' => $pdpa_product,
        ]);
    }
    /**
 * [เพิ่มใหม่] Hook ที่ Laravel เรียกอัตโนมัติหลังสมัครสำเร็จ + Login แล้ว
 * ใช้แทรกส่งอีเมลยืนยัน + บังคับ Logout จนกว่าจะยืนยัน
 */
protected function registered(Request $request, $user)
{
    $token = bin2hex(random_bytes(32));
    $user->email_verify_token = $token;
    $user->email_verify_token_expires_at = now()->addHours(24);
    $user->save();

    try {
        \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\verifyEmailChangeMail([
            'displayname' => $user->displayname,
            'new_email'   => $user->email,
            'verify_url'  => route('fronend.account.verifyEmail', $token),
            'context'     => 'register',
        ]));
    } catch (\Exception $e) {
        \Log::warning('RegisterController - ส่งอีเมลยืนยันไม่สำเร็จ', ['userId' => $user->id, 'message' => $e->getMessage()]);
    }

    session(['pending_verify_email' => $user->email]);
    \Illuminate\Support\Facades\Auth::logout();

    return redirect()->route('fronend.register.pending')->with('feedback', 'สมัครสมาชิกสำเร็จ! เราส่งอีเมลยืนยันไปที่ ' . $user->email . ' กรุณายืนยันก่อนเข้าใช้งาน');
}

    public function showRegistrationForm(Request $request)
    {
        $setting = TbSetting::first();
        $settingUser = TbSettingUser::first();
        $extension = TbExtension::select('ext_captcha_status','ext_captcha','ext_google_status')->first();
        $business = TbSettingCompanyBusiness::where('business_show',1)->orderBy('business_name','asc')->get();
        $position = TbSettingCompanyPosition::where('position_show',1)->orderBy('position_name','asc')->get();
        $page_name = 'สมัครสมาชิก';

        //title share
        if(!empty($page_name)){ $og_site_name = $page_name; }else{ $og_site_name = $page_name;}
        if(!empty($page_name)){ $og_title = $page_name; }else{ $og_title = $og_site_name = $page_name;}
        if(!empty($setting->setting_keyword)){ $og_keywords = $setting->setting_keyword; }else{ $og_keywords = "";}
        if(!empty($setting->setting_detail)){ $og_description = $setting->setting_detail; }else{ $og_description = "";}
        if(!empty($setting->setting_coverShare)){ $og_image = asset('storage/setting/'.$setting->setting_coverShare); }else{ $og_image = "";}
        if(!empty($page)){ $og_url = route('login'); }else{ $og_url = route('fronend.home');}

        return view('auth.register',[
            'og_site_name' => $og_site_name,
            'og_keywords' => $og_keywords,
            'og_title' => $og_title,
            'og_description' => $og_description,
            'og_url' => $og_url,
            'og_image' => $og_image,
            'page_name' => $page_name,
            'extension' => $extension,
            'settingUser' => $settingUser,
            'business' => $business,
            'position' => $position,
        ]);

    }
    public function showPending()
{
    $email = session('pending_verify_email');
    return view('auth.registerPending', ['email' => $email]);
}

public function resendVerification(Request $request)
{
    $email = session('pending_verify_email') ?? $request->input('email');

    if (empty($email)) {
        return redirect()->route('login')->with('feedback-er', 'ไม่พบข้อมูลอีเมล กรุณาสมัครสมาชิกหรือเข้าสู่ระบบใหม่อีกครั้ง');
    }

    $user = User::where('email', $email)->first();

    if (empty($user)) {
        return back()->with('feedback-er', 'ไม่พบบัญชีนี้ในระบบ');
    }

    if (!empty($user->email_verified_at)) {
        return redirect()->route('login')->with('feedback', 'อีเมลนี้ยืนยันแล้ว กรุณาเข้าสู่ระบบได้เลย');
    }

    // กันสแปมกดรัวๆ — ให้ส่งซ้ำได้ทุก 60 วินาที
    $lastSent = session('resend_verification_last_sent');
    if (!empty($lastSent) && now()->diffInSeconds($lastSent) < 60) {
        return back()->with('feedback-er', 'กรุณารอสักครู่ก่อนขอส่งอีเมลอีกครั้ง');
    }
    session(['resend_verification_last_sent' => now()]);

    $token = bin2hex(random_bytes(32));
    $user->email_verify_token = $token;
    $user->email_verify_token_expires_at = now()->addHours(24);
    $user->save();

    try {
        \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\verifyEmailChangeMail([
            'displayname' => $user->displayname,
            'new_email'   => $user->email,
            'verify_url'  => route('fronend.account.verifyEmail', $token),
        ]));
    } catch (\Exception $e) {
        \Log::warning('resendVerification - ส่งอีเมลไม่สำเร็จ', ['userId' => $user->id, 'message' => $e->getMessage()]);
    }

    return back()->with('feedback', 'ส่งอีเมลยืนยันอีกครั้งไปที่ ' . $user->email . ' แล้ว กรุณาตรวจสอบกล่องจดหมาย');
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

    private function notify_message($Message, $Token) {

        $chOne = curl_init();
        curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
        curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt( $chOne, CURLOPT_POST, 1);
        curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=".$Message);
        $headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: '.$Token.'', );
        curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
        curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec( $chOne );

        //Result error
        if(curl_error($chOne))
        {
            echo 'error:' . curl_error($chOne);
        }
        else {
            $result_ = json_decode($result, true);
            echo "status : ".$result_['status']; echo "message : ". $result_['message'];
        }
        curl_close( $chOne );

        return $chOne;
    }
}