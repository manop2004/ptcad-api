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

.acct-wrap{
  --navy:#12358f; --blue:#1765ff; --ink:#0b1f4d; --muted:#667085; --line:#e6edf8;
  --soft:#f6f9ff; --red:#ef4444; --shadow:0 18px 50px rgba(20,53,143,.10);
  font-family:'Poppins','Noto Sans Thai',system-ui,sans-serif; color:var(--ink);
  width: 100% !important;
  max-width: 1320px !important;
  margin: 0 auto 60px auto !important;
  padding: 0 16px !important;
  box-sizing: border-box !important;
  overflow-x: hidden !important;
}
.acct-wrap *{box-sizing:border-box}
.acct-wrap a{text-decoration:none;color:inherit}

/* จัดส่วนหัวให้อยู่ตรงกลาง */
.acct-hero{
  padding:48px 24px;
  background:linear-gradient(105deg,#ffffff 0%,#f4f9ff 60%,#e4f3ff 100%);
  border-radius:24px;
  margin-bottom:28px;
  text-align: center !important;
  display: flex !important;
  flex-direction: column !important;
  align-items: center !important;
  justify-content: center !important;
}
.acct-hero .eyebrow{
  display:inline-flex;
  align-items:center;
  justify-content:center;
  gap:8px;
  color:var(--blue);
  font-weight:800;
  font-size:13px;
  margin-bottom:10px;
  width: 100%;
}
.acct-hero h1{
  font-size:34px;
  margin:0 0 8px;
  color:var(--navy);
  letter-spacing:-1px;
  text-align: center !important;
  width: 100%;
}
.acct-hero p{
  margin:0 auto !important;
  color:var(--muted);
  font-size:15px;
  max-width:640px;
  line-height:1.6;
  text-align: center !important;
  width: 100%;
}

/* จัด Breadcrumb ให้อยู่ตรงกลาง */
#page-title.page-title-center-custom {
  text-align: center !important;
  margin-bottom: 15px;
}
#page-title.page-title-center-custom .breadcrumb {
  display: inline-flex !important;
  justify-content: center !important;
  float: none !important;
  margin: 0 auto !important;
  padding: 0 !important;
  background: transparent !important;
}

.acct-portal{display:grid;grid-template-columns:270px 1fr;gap:26px}
.acct-side{position:sticky;top:100px;align-self:start;border:1px solid var(--line);border-radius:22px;background:#fff;box-shadow:0 12px 34px rgba(20,53,143,.055);padding:14px}
.acct-side a{height:46px;border-radius:14px;display:flex;align-items:center;gap:12px;padding:0 14px;color:#344054;font-weight:700;font-size:14px}
.acct-side a img{width:18px;height:18px;object-fit:contain}
.acct-side a:hover,.acct-side a.active{background:#eef6ff;color:var(--blue)}
.acct-side a.signout{color:var(--red)}

.acct-main{display:grid;gap:24px;width:100%}
.acct-card{background:#fff;border:1px solid var(--line);border-radius:24px;padding:32px;box-shadow:0 12px 34px rgba(20,53,143,.055)}
.acct-card h4{font-size:19px;color:#102b76;margin:0 0 18px}
.acct-card hr{border-color:var(--line);margin:18px 0}
.acct-card .col_full{margin-bottom:16px !important}
.acct-card label,.acct-card .col-md-3{color:#344054;font-weight:700;font-size:14px}
.acct-card .sm-form-control{border:1px solid var(--line);border-radius:10px;height:42px;padding:0 14px;width:100%;font-size:14px}
.acct-card .span-danger{color:var(--red)}

/* ปุ่มบันทึกข้อมูล */
.acct-card .button.button-green{
  background: linear-gradient(135deg, var(--blue), #0d57df) !important;
  border: 0 !important;
  border-radius: 999px !important;
  color: #fff !important;
  font-weight: 800 !important;
  font-size: 15px !important;
  height: 48px !important;
  line-height: 48px !important;
  padding: 0 28px !important;
  box-shadow: 0 12px 24px rgba(23,101,255,.22) !important;
  transition: .2s ease !important;
}
.acct-card .button.button-green:hover{
  background: linear-gradient(135deg, #0d57df, var(--navy)) !important;
  box-shadow: 0 14px 30px rgba(23,101,255,.30) !important;
  transform: translateY(-1px);
}
.acct-card .button.button-green i{margin-right:8px}

@media (max-width:1000px){
  .acct-portal{grid-template-columns:1fr}
  .acct-side{position:relative;top:0;display:grid;grid-template-columns:repeat(3,1fr)}
  .acct-card{padding:22px}
}
@media (max-width:640px){
  .acct-side{grid-template-columns:1fr 1fr}
}
</style>
@endsection

@section('content')

<div class="acct-wrap" style="width:100%;padding:0 28px">

    @if (!empty($breadcrumb))
    <section id="page-title" class="page-title-mini page-title-center-custom">
        <div class="clearfix">
            <ol class="breadcrumb">
                @foreach ($breadcrumb as $index => $item)
                    @if($index !== count($breadcrumb) - 1)
                        <li><a href="{{ $item['route'] }}">{{ $item['name'] }}</a></li>
                    @else
                        <li class="active">{{ $item['name'] }}</li>
                    @endif
                @endforeach
            </ol>
        </div>
    </section>
    @endif

    <section class="acct-hero">
        <div class="eyebrow"><i data-lucide="lock" size="16"></i> MY PTCAD</div>
        <h1>เปลี่ยนรหัสผ่าน</h1>
        <p>เพื่อความปลอดภัย กรุณาตั้งรหัสผ่านใหม่ที่คาดเดายาก และไม่ใช้ซ้ำกับบัญชีอื่น</p>
    </section>

    <div class="acct-portal">
        @include('layouts.fontend.account_sidebar')

        <div class="acct-main">
            <section class="acct-card">
                {{
                    Form::model($user, [
                        'novalidate',
                        'route' => ['fronend.account.changepassword.update',$user->id],
                        'class' => ($errors->any()) ? 'was-validated form-horizontal' : 'needs-validation form-horizontal',
                        'id'=>'user-form',
                        'method' => 'put',
                        'files' => true
                    ])
                }}
                    <h4>เปลี่ยนรหัสผ่าน</h4>
                    <hr/>
                    <div class="col_full">
                        <div class="row">
                            <div class="col-md-3">
                                อีเมลปัจจุบัน
                            </div>
                            <div class="col-md-9">
                                {{ Auth::user()->email }}
                            </div>
                        </div>
                    </div>
                    <div class="col_full">
                        <div class="row">
                            <div class="col-md-3">
                                รหัสผ่านปัจจุบัน <span class="span-danger">*</span>
                            </div>
                            <div class="col-md-9">
                                <input type="password" placeholder="รหัสผ่านปัจจุบัน" id="password" name="password" class="sm-form-control">
                                @error('password')<small class="invalid-feedback">{{ $message }}</small> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col_full">
                        <div class="row">
                            <div class="col-md-3">
                                รหัสผ่านใหม่ <span class="span-danger">*</span>
                            </div>
                            <div class="col-md-9">
                                <input type="password" placeholder="รหัสผ่านใหม่" id="password_new" name="password_new" class="sm-form-control">
                                @error('password_new')<small class="invalid-feedback">{{ $message }}</small> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col_full">
                        <div class="row">
                            <div class="col-md-3">
                                ยืนยันรหัสผ่านใหม่ <span class="span-danger">*</span>
                            </div>
                            <div class="col-md-9">
                                <input type="password" placeholder="ยืนยันรหัสผ่านใหม่" id="password_confirmation" name="password_confirmation" class="sm-form-control">
                                @error('password_confirmation')<small class="invalid-feedback">{{ $message }}</small> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col_full">
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-9">
                                <a href="{{ route('fronend.account.forgotpassword') }}"><i class="icon-key mg-right-10"></i>ลืมรหัสผ่าน ?</a>
                            </div>
                        </div>
                    </div>
                    <div class="col_full">
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-9">
                                @include('layouts.fontend.button.save')
                            </div>
                        </div>
                    </div>
                </form>
            </section>
        </div>
    </div>

</div>

@endsection