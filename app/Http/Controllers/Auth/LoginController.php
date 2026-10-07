<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

use App\Rules\checkStatusUser;
use App\Models\User;
use App\Models\TbSetting;
use App\Models\TbExtension;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers {
        logout as performLogout;
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::ACCOUNT;
    protected $loginPath = '/login';
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => ['required','email','exists:users', new checkStatusUser()],
            'password' => 'required',
        ],
        [
            $this->username().'.required' => 'รูปแบบอีเมลไม่ถูกต้อง กรุณาตรวจสอบข้อมูลอีกครั้ง!',
            $this->username().'.email' => 'รูปแบบอีเมลไม่ถูกต้อง กรุณาตรวจสอบข้อมูลอีกครั้ง!',
            $this->username().'.exists' => 'ไม่พบบัญชีผู้ใช้ของคุณ กรุณาตรวจสอบข้อมูลอีเมลอีกครั้ง!',
            'password.required' => 'รหัสผ่านไม่ถูกต้อง กรุณาตรวจสอบข้อมูลอีกครั้ง!',
        ]);
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => [trans('ไม่สามารถเข้าสู่ระบบได้ กรุณาตรวจสอบข้อมูลอีกครั้ง!')],
        ]);
    }

    protected function credentials(Request $request)
    {
        return ['email' => $request->{$this->username()}, 'password' => $request->password, 'status' => 1];
    }

   protected function authenticated(Request $request, $user)
{
    $user = User::findOrFail(Auth::user()->id);

    // [ปิดชั่วคราว] จนกว่าจะแก้ปัญหาหน้า /register/pending เสร็จ — ให้ Login ได้ปกติไปก่อน
    
    if (empty($user->email_verified_at)) {
        session(['pending_verify_email' => $user->email]);
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('fronend.register.pending')
            ->with('feedback-er', 'กรุณายืนยันอีเมลของคุณก่อนเข้าใช้งาน เราส่งลิงก์ยืนยันไปที่ ' . $user->email . ' แล้ว');
    }
    

    $user->lastlogin = date('Y-m-d H:i:s');
    $user->save();
}

    public function showLoginForm()
    {
        $setting = TbSetting::first();
        $extension = TbExtension::select('ext_captcha_status','ext_captcha','ext_google_status','ext_facebook_status')->first();
        $page_name = 'เข้าสู่ระบบ';

        //title share
        if(!empty($page_name)){ $og_site_name = $page_name; }else{ $og_site_name = $page_name;}
        if(!empty($page_name)){ $og_title = $page_name; }else{ $og_title = $og_site_name = $page_name;}
        if(!empty($setting->setting_keyword)){ $og_keywords = $setting->setting_keyword; }else{ $og_keywords = "";}
        if(!empty($setting->setting_detail)){ $og_description = $setting->setting_detail; }else{ $og_description = "";}
        if(!empty($setting->setting_coverShare)){ $og_image = asset('storage/setting/'.$setting->setting_coverShare); }else{ $og_image = "";}
        if(!empty($page)){ $og_url = route('login'); }else{ $og_url = route('fronend.home');}

        return view('auth.login',[
            'og_site_name' => $og_site_name,
            'og_keywords' => $og_keywords,
            'og_title' => $og_title,
            'og_description' => $og_description,
            'og_url' => $og_url,
            'og_image' => $og_image,
            'page_name' => $page_name,
            'extension' => $extension,
        ]);

    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function logout(Request $request)
    {
        $this->performLogout($request);
        return redirect()->route('login');
    }
}
