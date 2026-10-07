<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login | จัดการระบบหลังบ้าน</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
	<link rel="stylesheet" type="text/css" href="{{ asset('Login_v15/vendor/bootstrap/css/bootstrap.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('Login_v15/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('Login_v15/fonts/Linearicons-Free-v1.0.0/icon-font.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('Login_v15/vendor/animate/animate.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('Login_v15/vendor/css-hamburgers/hamburgers.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('Login_v15/vendor/animsition/css/animsition.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('Login_v15/vendor/select2/select2.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('Login_v15/vendor/daterangepicker/daterangepicker.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('Login_v15/css/util.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('Login_v15/css/main.css') }}">

    <style>
        .invalid-feedback{ display: block}
    </style>
    @php
        $extension = App\Models\TbExtension::select('ext_captcha_status','ext_captcha')->first();
        $setting = App\Models\TbSetting::select('setting_logoWeb_mobile','setting_nameWeb')->first();
    @endphp
</head>
<body>

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-form-title" style="background-image: url(Login_v15/images/bg-01.jpg);">
					<span class="login100-form-title-1">
						@if(!empty($setting->setting_logoWeb_mobile))
							<div class="center">
								<img src="{{ asset('/storage/setting/'.$setting->setting_logoWeb_mobile) }}"/>
							</div>
						@endif
					</span>
				</div>

                <form id="form-auth" method="POST" action="{{ route('administrator') }}" class="login100-form validate-form">
                    @csrf
					<div class="wrap-input100 validate-input m-b-18" data-validate="กรุณากรอกชื่อผู้ใช้">
						<span class="label-input100">ชื่อผู้ใช้</span>
						<input class="input100" type="text" id="email" name="email" placeholder="Enter username" value="{{ old('email') }}">
						<span class="focus-input100"></span>
					</div>
                    @error('email')
                        <span class="invalid-feedback m-b-26" role="alert">
                            <strong>ข้อมูลไม่ถูกต้อง กรุณาตรวจสอบชื่อบัญชีผู้ใช้ของคุณอีกครั้ง!</strong>
                        </span>
                    @enderror

					<div class="wrap-input100 validate-input m-b-18" data-validate = "กรุณากรอกรหัสผ่าน">
						<span class="label-input100">รหัสผ่าน</span>
						<input class="input100" type="password" id="password" name="password" placeholder="Enter password">
						<span class="focus-input100"></span>

                        @error('password')
                            <span class="invalid-feedback m-b-18" role="alert">
                                <strong>ข้อมูลไม่ถูกต้อง กรุณาตรวจสอบรหัสผ่านของคุณอีกครั้ง!</strong>
                            </span>
                        @enderror
					</div>

					<div class="container-login100-form-btn">
                        @if(!empty($extension))
                            @if($extension->ext_captcha_status == 1)
						        <button class="login100-form-btn g-recaptcha" data-sitekey="{{$extension->ext_captcha}}" data-callback='onSubmit' data-action='submit'>
                            @else
                                <button class="login100-form-btn" >
                            @endif
                        @else
                            <button class="login100-form-btn" >
                        @endif
                            เข้าสู่ระบบ
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<script src="{{ asset('Login_v15/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
	<script src="{{ asset('Login_v15/vendor/animsition/js/animsition.min.js') }}"></script>
	<script src="{{ asset('Login_v15/vendor/bootstrap/js/popper.js') }}"></script>
	<script src="{{ asset('Login_v15/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('Login_v15/vendor/select2/select2.min.js') }}"></script>
	<script src="{{ asset('Login_v15/vendor/daterangepicker/moment.min.js') }}"></script>
	<script src="{{ asset('Login_v15/vendor/daterangepicker/daterangepicker.js') }}"></script>
	<script src="{{ asset('Login_v15/vendor/countdowntime/countdowntime.js') }}"></script>
	<script src="{{ asset('Login_v15/js/main.js') }}"></script>
    @if(!empty($extension))
        @if($extension->ext_captcha_status == 1)
        <script src="https://www.google.com/recaptcha/api.js"></script>
        <script>
            function onSubmit(token) {
            document.getElementById("form-auth").submit();
            }
        </script>
        @endif
    @endif
</body>
</html>
