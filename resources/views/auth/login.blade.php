@extends('layouts.temp_user')

@section('title'){{ $og_title }} |@endsection
@section('og_site_name'){{ $og_site_name }}@endsection
@section('og_keywords'){{ $og_keywords }}@endsection
@section('og_title'){{ $og_title }}@endsection
@section('og_description'){{ $og_description }}@endsection
@section('og_url'){{ $og_url }}@endsection
@section('og_image'){{ $og_image }}@endsection

@section('css')
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Noto+Sans+Thai:wght@400;500;600;700;800&display=swap');

.pt-login-wrap{
  font-family:'Poppins','Noto Sans Thai',system-ui,sans-serif;
  color:#0b1f4d;
}
.pt-login-wrap .login-grid{
  display:grid;
  grid-template-columns:1fr .8fr;
  gap:24px;
  align-items:stretch;
}
.pt-login-wrap .login{
  background:linear-gradient(105deg,#ffffff 0%,#f3f8ff 62%,#dbefff 100%);
  border:1px solid #e6edf8;border-radius:24px;padding:44px 36px;
  box-shadow:0 18px 50px rgba(20,53,143,.10);
}
.pt-login-wrap .login h1{
  font-size:32px !important;color:#12358f !important;font-weight:800 !important;letter-spacing:-.6px;margin-bottom:6px;
}
.pt-login-wrap .login > div{color:#667085;font-size:14px}
.pt-login-wrap .sm-form-control{
  border:1px solid #e6edf8 !important;border-radius:10px !important;
}
.pt-login-wrap label{font-weight:700;font-size:14px;color:#344054}
.pt-login-wrap .btn-outline-login{
  height:46px;width:100%;border-radius:12px;border:none;
  background:linear-gradient(135deg,#1765ff,#0d57df) !important;
  color:#fff !important;font-weight:800 !important;font-size:15px;
  box-shadow:0 12px 24px rgba(23,101,255,.24);
}
.pt-login-wrap .register{
  background:#fff;border:1px solid #e6edf8;border-radius:24px;padding:44px 36px;
  box-shadow:0 12px 34px rgba(20,53,143,.06);display:flex;flex-direction:column;justify-content:center;
}
.pt-login-wrap .register h2{
  font-size:22px;color:#102b76;font-weight:800;margin-bottom:10px;
}
.pt-login-wrap .register > div{color:#667085;font-size:14px;line-height:1.7}
.pt-login-wrap .register hr{border-color:#e6edf8;margin:20px 0}
.pt-login-wrap .register .button{
  background:#fff !important;color:#1765ff !important;border:1.5px solid #1765ff !important;
  border-radius:12px !important;font-weight:800 !important;
}
@media (max-width:900px){
  .pt-login-wrap .login-grid{grid-template-columns:1fr}
}

/* ===== Mobile responsive: แก้การ์ดชิดขวา/กว้างเกินจอ ===== */
@media (max-width:600px){
  .pt-login-wrap{
    width:100%;
    overflow-x:hidden;
  }
  .pt-login-wrap .login-grid{
    width:100%;
    margin:0 !important;
    gap:16px;
  }
  .pt-login-wrap .login-line{
    width:100% !important;
    margin:0 !important;
    max-width:100% !important;
  }
  .pt-login-wrap .login,
  .pt-login-wrap .register{
    width:100%;
    box-sizing:border-box;
    padding:28px 20px;
    border-radius:18px;
  }
  .pt-login-wrap .login h1{
    font-size:24px !important;
  }
}

/* ===== แก้สีลิงก์ "ลืมรหัสผ่าน?" ที่เดิมเป็นสีเขียวจาก theme หลัก ===== */
.pt-login-wrap .pt-forgot-link{
  color:#667085 !important;
  font-size:13px;
  font-weight:600;
  text-decoration:none;
}
.pt-login-wrap .pt-forgot-link:hover{
  color:#1765ff !important;
  text-decoration:underline;
}
.pt-login-wrap .pt-forgot-link .icon-key{
  color:inherit !important;
}
</style>
@endsection

@section('content')

<section id="content">
    <div class="content-wrap">
		<div class="container pt-login-wrap">
		@if (!empty($breadcrumb))
		<section id="page-title" class="page-title-mini page-title-right">
			<div class="clearfix">
				<ol class="breadcrumb">
					@foreach ($breadcrumb as $index => $item)
						@if($index !== count($breadcrumb) -1 )
							<li><a href="{{ $item['route'] }}">{{ $item['name'] }}</a></li>
						@else
							<li class="active">{{ $item['name'] }}</li>
						@endif
					@endforeach
				</ol>
			</div>
		</section>
		<div class="clearfix"></div>
		@endif
		<div class="login-grid topmargin-lg bottommargin-lg">
			<div class="text-center login-line ">
				<div class="login">
					<h1>เข้าสู่ระบบ</h1>
					<div>ยินดีต้อนรับสู่ PTCAD ออนไลน์ ศูนย์รวมไอทีด้านงานออกแบบ</div>
					<br/>
					<form id="form-auth" method="POST" action="{{ route('login') }}" class="login100-form validate-form">
						@csrf
						<div class="col_full bottommargin-xs text-left">
							<label>อีเมล <span class="co-red">*</span></label>
							<input type="text" id="email" name="email" class="sm-form-control" placeholder="อีเมล">
							@error('email')<small class="co-red">{{ $message }}</small> @enderror
						</div>
						<div class="col_full bottommargin-xs text-left">
							<label>รหัสผ่าน <span class="co-red">*</span></label>
							<input type="password" id="password" name="password" class="sm-form-control" placeholder="รหัสผ่าน">
							@error('password')<small class="co-red">{{ $message }}</small> @enderror
						</div>
						<div class="col_full bottommargin-sm text-left">
							<a href="{{ route('fronend.forgotpassword') }}" class="pt-forgot-link"><i class="icon-key"></i> ลืมรหัสผ่าน?</a>
						</div>
						<div class="col_full bottommargin-xs text-left">
							@if(!empty($extension) && $extension->ext_captcha_status == 1 && !empty($extension->ext_captcha))
						        	<button class="btn btn-outline-login g-recaptcha" data-sitekey="{{$extension->ext_captcha}}" data-callback='onSubmit' data-action='submit'>
							@else
								<button type="submit" class="btn btn-outline-login">
							@endif
							เข้าสู่ระบบ</button>
						</div>
					</form>
					@if(!empty($extension))
						@if(($extension->ext_google_status == 1) || ($extension->ext_facebook_status == 1) )
							<div class="col_full bottommargin-xs text-center">
								หรือเข้าสู่ระบบผ่าน
							</div>
							<div class="col_full bottommargin-xs text-center">
								@if($extension->ext_facebook_status == 1 )
									<a href="{{ route('facebook.login') }}" class="socialite-icon-mar"  >
										<img loading="lazy" class="lazyload socialite-icon" data-src="{{ asset('icon/social/facebook.webp') }}"/>
									</a>
								@endif
								@if($extension->ext_google_status == 1)
									<a href="{{ route('google.login') }}" class="socialite-icon-mar">
										<img  loading="lazy" class="lazyload socialite-icon" data-src="{{ asset('icon/social/google.webp') }}"/>
									</a>
								@endif
							</div>
						@endif
					@endif
				</div>
			</div>
			<div class="register">
				<h2>คุณยังไม่มีบัญชีใช่ไหม?</h2>
				<div>
					ลูกค้าสามารถสั่งสมาชิกได้เลย พร้อมรับสิทธิ์ประโยชน์และโปรโมชั่นก่อนใคร และอัพเดทข้อมูลข่าวสารด้านงานซอฟต์แวร์ ตอบรับทั้งลูกค้าส่วนบุคคล และ ลูกค้านิติบุคคล
				</div>
				<hr/>
				<a href="{{ route('register') }}" class="button button-border button-rounded button-blue">สมัครสมาชิกใหม่</a>
			</div>
		</div>
    </div>
</section>

@endsection