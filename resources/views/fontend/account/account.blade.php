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
/* ===== PTCAD: Global override checkbox/radio สีเขียว -> น้ำเงิน (ครอบทุก label variant) ===== */
.checkbox-style:checked + [class*="checkbox-style-"][class*="-label"]:before,
.radio-style:checked + [class*="radio-style-"][class*="-label"]:before{
    background: #1765ff !important;
    border-color: #1765ff !important;
}
</style>
<link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendor/select2-bootstrap4-theme/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/fontend/css/components/radio-checkbox.css') }}" type="text/css" />
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Noto+Sans+Thai:wght@400;500;600;700;800&display=swap');

.acct-wrap{
  --navy:#12358f; --blue:#1765ff; --ink:#0b1f4d; --muted:#667085; --line:#e6edf8;
  --soft:#f6f9ff; --green:#20b26b; --red:#ef4444; --shadow:0 18px 50px rgba(20,53,143,.10);
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

.acct-hero{
  padding:48px 24px;
  background:linear-gradient(105deg,#ffffff 0%,#f4f9ff 60%,#e4f3ff 100%);
  border-radius:24px;
  margin-bottom:28px;
  text-align:center !important;
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
  margin:0 0 8px 0;
  color:var(--navy);
  letter-spacing:-1px;
  text-align:center !important;
  width: 100%;
}
.acct-hero p{
  margin:0 auto !important;
  color:var(--muted);
  font-size:15px;
  max-width:640px;
  line-height:1.6;
  text-align:center !important;
  width: 100%;
}

.acct-portal{display:grid;grid-template-columns:270px 1fr;gap:26px}
.acct-side{position:static;align-self:start;border:1px solid var(--line);border-radius:22px;background:#fff;box-shadow:0 12px 34px rgba(20,53,143,.055);padding:14px}
.acct-side a{height:46px;border-radius:14px;display:flex;align-items:center;gap:12px;padding:0 14px;color:#344054;font-weight:700;font-size:14px}
.acct-side a img{width:18px;height:18px;object-fit:contain}
.acct-side a:hover,.acct-side a.active{background:#eef6ff;color:var(--blue)}
.acct-side a.signout{color:var(--red)}

.acct-main{display:grid;gap:24px}
.acct-card{background:transparent;border:0;padding:0;box-shadow:none}
.acct-card .col_full{margin-bottom:16px !important}
.acct-card label,.acct-card .col-md-3{color:#344054;font-weight:700;font-size:14px}
.acct-card .sm-form-control{border:1px solid var(--line);border-radius:10px;height:42px;padding:0 14px;width:100%;font-size:14px}
.acct-card select.sm-form-control{height:42px}
.acct-card .span-danger{color:var(--red)}

/* Profile: 2-column layout matching mockup */
.profile-header{
  display:flex;align-items:center;gap:18px;
  margin-bottom:24px;padding-bottom:24px;border-bottom:1px solid var(--line);
}
.avatar-wrap{position:relative;flex:none;width:80px;height:80px}
.avatar-wrap img{width:80px;height:80px;border-radius:50%;object-fit:cover;box-shadow:0 12px 28px rgba(23,101,255,.18)}
.avatar-camera-btn{
  position:absolute;right:-2px;bottom:-2px;width:28px;height:28px;border-radius:50%;
  background:#fff;color:#667085;display:flex;align-items:center;justify-content:center;
  border:1.5px solid var(--line);cursor:pointer;box-shadow:0 6px 14px rgba(0,0,0,.08);
}
.avatar-camera-btn:hover{background:var(--soft)}
.avatar-camera-btn input[type="file"]{position:absolute;inset:0;opacity:0;cursor:pointer}
.profile-header-text h3{margin:0;color:#102b76;font-size:18px}
.profile-header-text p{margin:2px 0 0;color:var(--muted);font-size:12.5px}

/* Google connect block — now visually its own separated box, not just a thin hr */
.profile-social-box{
  margin-top:18px;
  padding:16px;
  border:1px solid var(--line);
  border-radius:16px;
  background:var(--soft);
}
.profile-social-box .social-account-row{
  display:flex;align-items:center;gap:8px;justify-content:center;
}
.profile-social-box .social-account-row span{font-weight:800;color:#102b76;font-size:13px}
.profile-social-box .social-account-sub{color:var(--muted);font-size:11px;margin:4px 0 12px}

.profile-form{display:grid;gap:20px;min-width:0}
.form-section{border:1px solid var(--line);border-radius:22px;padding:24px;background:#fff;box-shadow:0 12px 34px rgba(20,53,143,.055)}
.form-section-head{display:flex;align-items:flex-start;justify-content:space-between;gap:18px;margin-bottom:18px}
.form-section-head h4{margin:0;color:#102b76;font-size:18px}
.form-section-head small{display:block;margin-top:4px;color:var(--muted);font-size:12px;font-weight:600;line-height:1.5}

/* Cancel + Save buttons — unified size so they match visually */
.profile-actions{display:flex;justify-content:flex-end;align-items:center;gap:12px;flex-wrap:wrap}
.profile-actions .btn-cancel,
.profile-actions .save-btn-wrap .button.button-green.btn-block,
.profile-actions .save-btn-wrap button.loadding.button.button-green.btn-block{
  box-sizing:border-box!important;
  display:inline-flex!important;
  align-items:center!important;
  justify-content:center!important;
  gap:8px!important;
  width:auto!important;
  min-width:170px!important;
  max-width:170px!important;
  height:46px!important;
  padding:0 22px!important;
  border-radius:12px!important;
  font-weight:800!important;
  font-size:14px!important;
  line-height:1!important;
  flex-shrink:0!important;
}
.btn-cancel{
  border:1.5px solid var(--blue)!important;
  background:#fff!important;
  color:var(--blue)!important;
  cursor:pointer;
}
.btn-cancel:hover{background:var(--soft)!important}
.save-btn-wrap{display:inline-flex}
.save-btn-wrap .button.button-green.btn-block,
.save-btn-wrap button.loadding.button.button-green.btn-block{
  border:0!important;
  background:linear-gradient(135deg,var(--blue),#0d57df)!important;
  color:#fff!important;
  box-shadow:0 12px 24px rgba(23,101,255,.22)!important;
}
.save-btn-wrap .button i{margin-right:0!important}

.social-btn{height:38px;padding:0 18px;border-radius:10px;border:1.5px solid var(--blue);color:var(--blue);font-weight:800;font-size:13px;display:inline-flex;align-items:center;white-space:nowrap}
.social-btn:hover{background:#fff}
.social-btn.unconnect{color:var(--red);border-color:#fecaca}
.social-btn.unconnect:hover{background:#fff5f5}

@media (max-width:600px){
  .profile-header{flex-direction:column;align-items:flex-start;text-align:left}
}
@media (max-width:1000px){
  .acct-portal{grid-template-columns:1fr}
  .acct-side{position:relative;top:0;display:grid;grid-template-columns:repeat(3,1fr)}
}
@media (max-width:640px){
  .acct-side{grid-template-columns:1fr 1fr}
  .profile-actions{justify-content:stretch}
  .profile-actions .btn-cancel,
  .profile-actions .save-btn-wrap .button.button-green.btn-block,
  .profile-actions .save-btn-wrap button.loadding.button.button-green.btn-block{
    min-width:0!important;max-width:none!important;flex:1 1 auto!important;
  }
}
</style>
@endsection

@section('content')

<div class="acct-wrap" style="width:100%;padding:0 28px">

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
    @endif

    <section class="acct-hero">
        <div class="eyebrow"><i data-lucide="user" size="16"></i> MY PTCAD</div>
        <h1>ข้อมูลส่วนตัว</h1>
        <p>แก้ไขข้อมูลโปรไฟล์ ที่อยู่ วันเกิด และการเชื่อมต่อบัญชีโซเชียลของคุณได้ที่นี่</p>
    </section>

    <div class="acct-portal">
        @include('layouts.fontend.account_sidebar')

        <div class="acct-main">
            <section class="acct-card">
                {{
                    Form::model($user, [
                        'novalidate',
                        'route' => ['fronend.account.update',$user->id],
                        'class' => ($errors->any()) ? 'was-validated form-horizontal' : 'needs-validation form-horizontal',
                        'id'=>'user-form',
                        'method' => 'put',
                        'files' => true
                    ])
                }}
                <div class="profile-form">
                    <div class="profile-form">
    @if(session('feedback'))
        <div style="background:#eafff3;border:1px solid #b7f0d0;color:#0f9d58;padding:14px 18px;border-radius:12px;display:flex;align-items:center;gap:10px;font-weight:700;font-size:14px;">
            <i data-lucide="check-circle" size="18"></i> {{ session('feedback') }}
        </div>
    @endif
    <div class="form-section">
        <div class="profile-header">
            <div class="avatar-wrap">
                @if(!empty(Auth::user()->img != ""))
                    <input type="hidden" class="sm-form-control" id="img_old" name="img_old" value="{{ $user->img }}" >
                    <img id="blah1" loading="lazy" class="img-circle img-profile-2 border-1 lazyload" data-src="{{ asset('storage/avatar/'.$user->img) }}" width="300" height="300">
                @else
                    <img id="blah1" loading="lazy" class="img-circle img-profile-2 border-1 lazyload" data-src="{{ asset('images/default-img/default-avatar.png') }}" width="300" height="300">
                @endif
                <label class="avatar-camera-btn" title="เปลี่ยนรูปโปรไฟล์">
                    <i data-lucide="camera" size="14"></i>
                    <input onchange="readURL1(this);" accept="image/jpg,image/jpeg/png" type="file" id="img" name="img">
                </label>
            </div>
            <div class="profile-header-text">
                <h3>{{ $user->displayname }}</h3>
                <p>สมาชิก PTCAD &middot; รองรับไฟล์ JPG/PNG ไม่เกิน 2 MB</p>
            </div>
        </div>

        <input type="hidden" name="user_type" value="{{ $user->user_type }}">
        <div class="col_full">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-9">
                    <span style="display:inline-flex;align-items:center;gap:8px;font-weight:700;color:#102b76;">
                        <i data-lucide="{{ $user->user_type == 2 ? 'building-2' : 'user' }}" size="16"></i>
                        {{ $user->user_type == 2 ? 'บริษัท/สำนักงาน/องค์กร' : 'บุคคลธรรมดา' }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    @if($user->user_type == 2)

        {{-- ===== บัญชีบริษัท: โชว์ข้อมูลบริษัทก่อน ===== --}}
        <div class="form-section">
            <div class="form-section-head">
                <div><h4>ข้อมูลบริษัท/อาชีพ</h4><small>ใช้สำหรับออกใบเสนอราคาและใบกำกับภาษี</small></div>
                <i data-lucide="building-2" size="20"></i>
            </div>
            <div class="col_full">
                <div class="row">
                    <div class="col-md-3">
                        ชื่อบริษัท <span class="span-danger">*</span>
                    </div>
                    <div class="col-md-9">
                        <input type="text" placeholder="ชื่อบริษัท" id="company_name" name="company_name" value="@if(!empty($user->company_name)){{ $user->company_name }}@endif" class="sm-form-control @error('company_name') is-invalid @enderror">
                        @error('company_name')<small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>@enderror
                    </div>
                </div>
            </div>
            <div class="col_full">
                <div class="row">
                    <div class="col-md-3">
                        เลขประจำตัวผู้เสียภาษี
                    </div>
                    <div class="col-md-9">
                        <input type="text" placeholder="เลขประจำตัวผู้เสียภาษี 13 หลัก" id="tax_id" name="tax_id" value="@if(!empty($user->tax_id)){{ $user->tax_id }}@endif" class="sm-form-control">
                    </div>
                </div>
            </div>
            <div class="col_full">
                <div class="row">
                    <div class="col-md-3">
                        สาขา
                    </div>
                    <div class="col-md-9">
                        <input type="text" placeholder="เช่น สำนักงานใหญ่" id="branch" name="branch" value="@if(!empty($user->branch)){{ $user->branch }}@endif" class="sm-form-control">
                    </div>
                </div>
            </div>
            <div class="col_full">
                <div class="row">
                    <div class="col-md-3">
                        ที่อยู่สำหรับออกใบกำกับภาษี
                    </div>
                    <div class="col-md-9">
                        <textarea placeholder="ที่อยู่สำหรับออกใบกำกับภาษี" id="billing_address" name="billing_address" rows="3" class="sm-form-control">@if(!empty($user->billing_address)){{ $user->billing_address }}@endif</textarea>
                    </div>
                </div>
            </div>
            @if(!empty($settingUser) && $settingUser->business_status == 1)
                <div class="col_full">
                    <div class="row">
                        <div class="col-md-3">
                            ประเภทธุรกิจ <span class="span-danger">*</span>
                        </div>
                        <div class="col-md-9">
                            <select id="businessId" name="businessId" class="sm-form-control @error('businessId') is-invalid @enderror">
                                <option value="">กรุณาเลือกข้อมูล</option>
                                @foreach ($business as $categories)
                                    <option value="{{$categories->id}}" @if (!empty($user->businessId) && $user->businessId == $categories->id) selected @endif>{{$categories->business_name}}</option>
                                @endforeach
                            </select>
                            @error('businessId')<small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>@enderror
                        </div>
                    </div>
                </div>
            @endif
        </div>

        {{-- ===== ข้อมูลส่วนตัว (ผู้ติดต่อ) — อยู่หลังข้อมูลบริษัท ===== --}}
        <div class="form-section">
            <div class="form-section-head">
                <div><h4>ข้อมูลผู้ติดต่อ</h4><small>ข้อมูลหลักที่ใช้ระบุตัวตนและติดต่อคุณ</small></div>
                <i data-lucide="user-round" size="20"></i>
            </div>
            <div class="col_full">
                <div class="row">
                    <div class="col-md-3">
                        ชื่อ - สกุล ผู้ติดต่อ <span class="span-danger">*</span>
                    </div>
                    <div class="col-md-4 mg-top-5">
                        <input type="text" placeholder="ชื่อ" id="name" name="name" value="@if(!empty($user->name)){{ $user->name }}@endif" class="sm-form-control @error('name') is-invalid @enderror">
                        @error('name')<small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>@enderror
                    </div>
                    <div class="col-md-5 mg-top-5">
                        <input type="text" placeholder="นามสกุล" id="lastname" name="lastname" value="@if(!empty($user->lastname)){{ $user->lastname }}@endif" class="sm-form-control @error('lastname') is-invalid @enderror">
                        @error('lastname')<small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>@enderror
                    </div>
                </div>
            </div>
            <div class="col_full">
                <div class="row">
                    <div class="col-md-3">
                        เบอร์โทรศัพท์ <span class="span-danger">*</span>
                    </div>
                    <div class="col-md-9">
                        <input type="text" placeholder="เบอร์โทรศัพท์" id="tel" name="tel" value="{{ $user->tel }}" class="sm-form-control">
                        @error('tel')<small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>@enderror
                    </div>
                </div>
            </div>
            <div class="col_full">
                <div class="row">
                    <div class="col-md-3">
                        อีเมล <span class="span-danger">*</span>
                    </div>
                    <div class="col-md-9">
                        <input type="email" placeholder="อีเมล" id="email" name="email" value="{{ $user->email }}" class="sm-form-control @error('email') is-invalid @enderror">
                        @error('email')<small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>@enderror
                        @if(!empty($user->pending_email))
    <small style="display:block;margin-top:6px;color:#b45309;background:#fff7ed;border:1px solid #fed7aa;padding:8px 12px;border-radius:8px;font-weight:600;">
        <i data-lucide="clock" size="13" style="vertical-align:-2px"></i>
        กำลังรอยืนยันการเปลี่ยนเป็น <strong>{{ $user->pending_email }}</strong> — กรุณาตรวจสอบกล่องจดหมาย (ลิงก์หมดอายุใน 24 ชม.)
    </small>
@endif
                    </div>
                </div>
            </div>
        </div>
        <div class="form-section">
    <div class="form-section-head">
        <div><h4>ผู้ติดต่อเพิ่มเติม</h4><small>เพิ่มผู้ติดต่อของบริษัทได้สูงสุด 10 คน</small></div>
        <i data-lucide="users" size="20"></i>
    </div>

    <div id="contact-list" style="display:flex;flex-direction:column;gap:10px;margin-bottom:16px;">
        @foreach($contacts as $contact)
        <div class="contact-row" data-id="{{ $contact->id }}" style="display:flex;align-items:center;justify-content:space-between;border:1px solid #e6edf8;border-radius:10px;padding:12px 16px;">
            <div>
                <div style="font-weight:700;color:#102b76;">{{ $contact->name }} {{ $contact->lastname }}</div>
                <div style="color:#667085;font-size:13px;">{{ $contact->tel }} @if($contact->tel && $contact->email) &middot; @endif {{ $contact->email }}</div>
            </div>
            <button type="button" class="btn-remove-contact" data-id="{{ $contact->id }}" style="border:0;background:none;color:#ef4444;cursor:pointer;">
                <i data-lucide="trash-2" size="16"></i>
            </button>
        </div>
        @endforeach
    </div>

    <div id="contact-empty-msg" style="@if($contacts->count() > 0) display:none; @endif color:#98a2b3;font-size:13px;margin-bottom:16px;">ยังไม่มีผู้ติดต่อเพิ่มเติม</div>

    <div id="contact-form-box" style="display:none;border:1px solid #e6edf8;border-radius:12px;padding:16px;margin-bottom:12px;background:#f6f9ff;">
        <div class="row">
            <div class="col-md-6"><input type="text" id="c_name" placeholder="ชื่อ" class="sm-form-control"></div>
            <div class="col-md-6"><input type="text" id="c_lastname" placeholder="นามสกุล" class="sm-form-control"></div>
        </div>
        <div class="row" style="margin-top:10px;">
            <div class="col-md-6"><input type="text" id="c_tel" placeholder="เบอร์โทรศัพท์" class="sm-form-control"></div>
            <div class="col-md-6"><input type="email" id="c_email" placeholder="อีเมล" class="sm-form-control"></div>
        </div>
        <div style="margin-top:12px;display:flex;gap:8px;">
            <button type="button" id="btn-save-contact" class="social-btn">บันทึก</button>
            <button type="button" id="btn-cancel-contact" class="social-btn unconnect">ยกเลิก</button>
        </div>
        <div id="contact-error" style="color:#ef4444;font-size:13px;margin-top:8px;"></div>
    </div>

    <button type="button" id="btn-add-contact" class="social-btn">
        <i data-lucide="plus" size="14"></i> เพิ่มผู้ติดต่อ
    </button>
</div>

    @else

        {{-- ===== บุคคลธรรมดา: โชว์ข้อมูลส่วนตัวก่อนเหมือนเดิม ===== --}}
        <div class="form-section">
            <div class="form-section-head">
                <div><h4>ข้อมูลส่วนตัว</h4><small>ข้อมูลหลักที่ใช้ระบุตัวตนและติดต่อคุณ</small></div>
                <i data-lucide="user-round" size="20"></i>
            </div>
            <div class="col_full">
                <div class="row">
                    <div class="col-md-3">
                        ชื่อ - สกุล <span class="span-danger">*</span>
                    </div>
                    <div class="col-md-4 mg-top-5">
                        <input type="text" placeholder="ชื่อ" id="name" name="name" value="@if(!empty($user->name)){{ $user->name }}@endif" class="sm-form-control @error('name') is-invalid @enderror">
                        @error('name')<small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>@enderror
                    </div>
                    <div class="col-md-5 mg-top-5">
                        <input type="text" placeholder="นามสกุล" id="lastname" name="lastname" value="@if(!empty($user->lastname)){{ $user->lastname }}@endif" class="sm-form-control @error('lastname') is-invalid @enderror">
                        @error('lastname')<small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>@enderror
                    </div>
                </div>
            </div>
            <div class="col_full">
                <div class="row">
                    <div class="col-md-3">
                        เบอร์โทรศัพท์ <span class="span-danger">*</span>
                    </div>
                    <div class="col-md-9">
                        <input type="text" placeholder="เบอร์โทรศัพท์" id="tel" name="tel" value="{{ $user->tel }}" class="sm-form-control">
                        @error('tel')<small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>@enderror
                    </div>
                </div>
            </div>
            <div class="col_full">
                <div class="row">
                    <div class="col-md-3">
                        อีเมล <span class="span-danger">*</span>
                    </div>
                    <div class="col-md-9">
                        <input type="email" placeholder="อีเมล" id="email" name="email" value="{{ $user->email }}" class="sm-form-control @error('email') is-invalid @enderror">
                        @error('email')<small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>@enderror
                        @if(!empty($user->pending_email))
    <small style="display:block;margin-top:6px;color:#b45309;background:#fff7ed;border:1px solid #fed7aa;padding:8px 12px;border-radius:8px;font-weight:600;">
        <i data-lucide="clock" size="13" style="vertical-align:-2px"></i>
        กำลังรอยืนยันการเปลี่ยนเป็น <strong>{{ $user->pending_email }}</strong> — กรุณาตรวจสอบกล่องจดหมาย (ลิงก์หมดอายุใน 24 ชม.)
    </small>
@endif
                    </div>
                </div>
            </div>
        </div>

        <div class="form-section">
            <div class="form-section-head">
                <div><h4>ข้อมูลอาชีพ</h4><small>ใช้สำหรับข้อมูลเพิ่มเติมของคุณ (ไม่บังคับ)</small></div>
                <i data-lucide="briefcase" size="20"></i>
            </div>
            @if(!empty($settingUser) && $settingUser->position_status == 1)
                <div class="col_full">
                    <div class="row">
                        <div class="col-md-3">
                            ตำแหน่ง/ อาชีพ <span class="span-danger">*</span>
                        </div>
                        <div class="col-md-9">
                            <select id="positionId" name="positionId" class="sm-form-control @error('positionId') is-invalid @enderror">
                                <option value="">กรุณาเลือกข้อมูล</option>
                                @foreach ($position as $categories)
                                    <option value="{{$categories->id}}" @if (!empty($user->positionId) && $user->positionId == $categories->id) selected @endif>{{$categories->position_name}}</option>
                                @endforeach
                            </select>
                            @error('positionId')<small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>@enderror
                        </div>
                    </div>
                </div>
            @endif
        </div>

    @endif

                        
                        <div class="form-section">
                            <div class="form-section-head">
                                <div><h4>บัญชีที่เชื่อมต่อ</h4><small>เชื่อมบัญชี Google เพื่อเข้าสู่ระบบได้เร็วขึ้น</small></div>
                                <i data-lucide="link-2" size="20"></i>
                            </div>
                            <div style="display:flex;align-items:center;justify-content:space-between;gap:16px;flex-wrap:wrap">
                                <div style="display:flex;align-items:center;gap:12px">
                                    <img loading="lazy" class="lazyload" data-src="{{ asset('icon/social/google.webp') }}" alt="Google" style="width:26px;height:26px;object-fit:contain">
                                    <div>
                                        <div style="font-weight:800;color:#102b76;font-size:14px">บัญชี Google</div>
                                        <div style="color:var(--muted);font-size:12px;font-weight:600;margin-top:2px">เชื่อมไว้เพื่อเข้าสู่ระบบได้เร็วขึ้น</div>
                                    </div>
                                </div>
                                @if(!empty($user->google_id))
                                    <a href="{{ route('google.unconnect') }}" class="social-btn unconnect">ยกเลิกการผูกบัญชี</a>
                                @else
                                    <a href="/auth/google" class="social-btn">ผูกบัญชี</a>
                                @endif
                            </div>
                        </div>


                        <div class="profile-actions">
                            <button class="btn-cancel" type="reset">ยกเลิกการแก้ไข</button>
                            <span class="save-btn-wrap">@include('layouts.fontend.button.save')</span>
                        </div>
                    </div>
                </div>

                </form>
            </section>
        </div>
    </div>

    {{-- ===== Modal ยืนยันลบผู้ติดต่อ (อยู่ในหน้า content แต่นอกฟอร์มหลัก) ===== --}}
    <div id="contact-delete-modal" style="display:none;position:fixed;inset:0;background:rgba(11,31,77,.45);z-index:9999;align-items:center;justify-content:center;">
        <div style="background:#fff;border-radius:16px;padding:28px;max-width:360px;width:90%;text-align:center;box-shadow:0 20px 60px rgba(0,0,0,.2);">
            <div style="width:52px;height:52px;border-radius:50%;background:#fef2f2;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
                <i data-lucide="trash-2" size="24" style="color:#ef4444"></i>
            </div>
            <h4 style="color:#102b76;margin:0 0 8px;">ลบผู้ติดต่อนี้?</h4>
            <p style="color:#667085;font-size:14px;margin:0 0 20px;">ต้องการลบ <strong id="contact-delete-name"></strong> ออกจากรายชื่อผู้ติดต่อใช่ไหม</p>
            <div style="display:flex;gap:10px;justify-content:center;">
                <button type="button" id="contact-delete-cancel" class="btn-cancel" style="min-width:120px;">ยกเลิก</button>
                <button type="button" id="contact-delete-confirm" style="min-width:120px;height:46px;border-radius:12px;border:0;background:#ef4444;color:#fff;font-weight:800;cursor:pointer;">ลบเลย</button>
            </div>
        </div>
    </div>

</div>

@endsection
@section('js')
 <script src="{{ asset('vendor/select2/select2.min.js') }}"></script>
 <script src="{{ asset('vendor/select2-bootstrap4-theme/docs/script.js') }}"></script>
 <script>
$(document).ready(function(){
    $('#btn-add-contact').on('click', function(){
        $('#contact-form-box').show();
        $(this).hide();
    });
    $('#btn-cancel-contact').on('click', function(){
        $('#contact-form-box').hide();
        $('#btn-add-contact').show();
        $('#c_name, #c_lastname, #c_tel, #c_email').val('');
        $('#contact-error').text('');
    });

    // กัน Enter ไปโดน submit ฟอร์มหลักทั้งหน้า
    $('#c_name, #c_lastname, #c_tel, #c_email').on('keydown', function(e){
        if (e.key === 'Enter') {
            e.preventDefault();
            $('#btn-save-contact').click();
        }
    });

    $('#btn-save-contact').on('click', function(){
        $('#contact-error').text('');
        $.ajax({
            url: '{{ route("fronend.account.contact.store") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                name: $('#c_name').val(),
                lastname: $('#c_lastname').val(),
                tel: $('#c_tel').val(),
                email: $('#c_email').val(),
            },
            success: function(res){
                if(res.success){
                    var c = res.contact;
                    var sep = (c.tel && c.email) ? ' &middot; ' : '';
                    var row = '<div class="contact-row" data-id="'+c.id+'" style="display:flex;align-items:center;justify-content:space-between;border:1px solid #e6edf8;border-radius:10px;padding:12px 16px;">' +
                        '<div><div style="font-weight:700;color:#102b76;">'+c.name+' '+c.lastname+'</div>' +
                        '<div style="color:#667085;font-size:13px;">'+(c.tel||'')+sep+(c.email||'')+'</div></div>' +
                        '<button type="button" class="btn-remove-contact" data-id="'+c.id+'" style="border:0;background:none;color:#ef4444;cursor:pointer;"><i data-lucide="trash-2" size="16"></i></button></div>';
                    $('#contact-list').append(row);
                    $('#contact-empty-msg').hide();
                    if (window.lucide) { lucide.createIcons(); }
                    $('#c_name, #c_lastname, #c_tel, #c_email').val('');
                    $('#contact-form-box').hide();
                    $('#btn-add-contact').show();
                    showContactSuccess(res.message);
                }
            },
            error: function(xhr){
                if(xhr.responseJSON && xhr.responseJSON.message){
                    $('#contact-error').text(xhr.responseJSON.message);
                } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                    $('#contact-error').text(Object.values(xhr.responseJSON.errors).flat().join(' '));
                }
            }
        });
    });

    // ===== ปุ่มลบ -> เปิด Modal ยืนยันตรงกลางจอ (แทนของเดิมที่เป็นลิงก์ในแถว) =====
    var pendingDeleteRow = null;
    var pendingDeleteId = null;

    $(document).on('click', '.btn-remove-contact', function(){
        pendingDeleteRow = $(this).closest('.contact-row');
        pendingDeleteId = $(this).data('id');
        var contactName = pendingDeleteRow.find('div div').first().text();
        $('#contact-delete-name').text(contactName);
        $('#contact-delete-modal').css('display', 'flex');
    });

    $('#contact-delete-cancel').on('click', function(){
        $('#contact-delete-modal').hide();
        pendingDeleteRow = null;
        pendingDeleteId = null;
    });

    $('#contact-delete-confirm').on('click', function(){
        if (!pendingDeleteId) return;
        $.ajax({
            url: "{{ route('fronend.account.contact.delete', ['id' => 'ID_PLACEHOLDER']) }}".replace('ID_PLACEHOLDER', pendingDeleteId),
            method: 'DELETE',
            data: { _token: '{{ csrf_token() }}' },
            success: function(res){
                if(res.success){
                    pendingDeleteRow.fadeOut(200, function(){
                        pendingDeleteRow.remove();
                        if($('#contact-list').children().length === 0){
                            $('#contact-empty-msg').show();
                        }
                    });
                }
                $('#contact-delete-modal').hide();
                pendingDeleteRow = null;
                pendingDeleteId = null;
            }
        });
    });
});

function showContactSuccess(message) {
    var box = $('<div style="background:#eafff3;border:1px solid #b7f0d0;color:#0f9d58;padding:10px 16px;border-radius:10px;display:flex;align-items:center;gap:8px;font-weight:600;font-size:13px;margin-bottom:12px;"><i data-lucide="check-circle" size="16"></i> ' + message + '</div>');
    $('#contact-list').before(box);
    if (window.lucide) { lucide.createIcons(); }
    setTimeout(function(){ box.fadeOut(300, function(){ box.remove(); }); }, 3000);
}
</script>
@endsection