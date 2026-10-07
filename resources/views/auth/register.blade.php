@extends('layouts.temp_user')

@section('title'){{ $og_title }} |@endsection
@section('og_site_name'){{ $og_site_name }}@endsection
@section('og_keywords'){{ $og_keywords }}@endsection
@section('og_title'){{ $og_title }}@endsection
@section('og_description'){{ $og_description }}@endsection
@section('og_url'){{ $og_url }}@endsection
@section('og_image'){{ $og_image }}@endsection

@section('css')
<link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendor/select2-bootstrap4-theme/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/fontend/css/components/radio-checkbox.css') }}" type="text/css" />
<style>
.pt-register-wrap{
  font-family:'Poppins','Noto Sans Thai',system-ui,sans-serif;
  color:#0b1f4d;
}
.pt-register-wrap .regis-wh{
  background:linear-gradient(105deg,#ffffff 0%,#f3f8ff 62%,#dbefff 100%);
  border:1px solid #e6edf8;border-radius:24px;padding:44px 40px;
  box-shadow:0 18px 50px rgba(20,53,143,.10);
  max-width:820px;margin:0 auto;
}
.pt-register-wrap .regis-wh > h1{
  font-size:30px !important;color:#12358f !important;font-weight:800 !important;letter-spacing:-.6px;
  margin-bottom:8px !important;
}
.pt-register-wrap .regis-sub{
  text-align:center;color:#667085;font-size:14px;margin-bottom:28px;
}
form .col_full {
    margin-bottom: 16px !important;
}
.fpb{
    display: none;
}
.pt-register-wrap .col-md-3{color:#344054;font-weight:700;font-size:14px}
.pt-register-wrap .sm-form-control{
  border:1px solid #e6edf8 !important;border-radius:10px !important;height:44px;
}
.pt-register-wrap select.sm-form-control{height:44px}
.pt-register-wrap .span-danger{color:#ef4444 !important}
.pt-register-wrap .btn-outline-register{
  height:48px;width:100%;border-radius:12px;border:none;
  background:linear-gradient(135deg,#1765ff,#0d57df) !important;
  color:#fff !important;font-weight:800 !important;font-size:15px;
  box-shadow:0 12px 24px rgba(23,101,255,.24);
}
.pt-register-wrap .pdpa-wb{background:#f6f9ff;border:1px solid #e6edf8;border-radius:14px;padding:16px 18px;font-size:13px;color:#667085;line-height:1.6}

/* ===== แก้ 2 จุด: สี checkbox + ข้อความล้นกรอบ ===== */
.pt-register-wrap .pdpa-wb{
  display:flex;
  align-items:flex-start;
  gap:10px;
  flex-wrap:nowrap;
  box-sizing:border-box;
}
.pt-register-wrap .pdpa-wb input.checkbox-style{
  flex-shrink:0;
}
.pt-register-wrap .pdpa-wb label.checkbox-style-3-label{
  display:block;
  flex:1 1 auto;
  min-width:0;
  max-width:100%;
  box-sizing:border-box;
  white-space:normal !important;
  overflow-wrap:break-word;
  word-break:break-word;
  margin:0 !important;
  padding-right:20px;
}
/* สีเขียวจริงมาจาก radio-checkbox.css: .checkbox-style:checked + .checkbox-style-3-label:before { background:#59BA41 } */
/* override เฉพาะหน้านี้ให้เป็นน้ำเงินธีม PTCAD แทน */
.pt-register-wrap .checkbox-style:checked + .checkbox-style-3-label:before{
  background:#1765ff !important;
}
.pt-register-wrap .checkbox-style-3-label:before{
  border-color:#c7d7fb !important;
}
</style>
@endsection

@section('content')

<section id="content">
    <div class="content-wrap">
        <div class="container">
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
            <div class="clearfux"></div>
            @endif
            <div class="regis-wh bottommargin-lg pt-register-wrap">
                <h1 class="center">สมัครสมาชิก PTCAD</h1>
                <p class="regis-sub">กรอกข้อมูลเพื่อสร้างบัญชีและเริ่มใช้งาน</p>
                @if(!empty($extension) && $extension->ext_google_status == 1)
<div style="margin-bottom:28px;">
    <a href="{{ route('google.login') }}" style="display:flex;align-items:center;justify-content:center;gap:10px;width:100%;height:52px;border:1.5px solid #e6edf8;border-radius:14px;text-decoration:none;color:#344054;font-weight:700;font-size:15px;background:#fff;box-sizing:border-box;">
        <img loading="lazy" class="lazyload" data-src="{{ asset('icon/social/google.webp') }}" style="width:22px;height:22px;"/>
        สมัครสมาชิกด้วย Google
    </a>
    <div style="display:flex;align-items:center;gap:12px;margin-top:22px;">
        <div style="flex:1;height:1px;background:#e6edf8;"></div>
        <span style="color:#9aa5b8;font-size:12.5px;white-space:nowrap;">หรือสมัครด้วยอีเมล</span>
        <div style="flex:1;height:1px;background:#e6edf8;"></div>
    </div>
</div>
@endif

                <form id="form-register" method="POST" action="{{ route('register') }}">
                    @csrf
                    @if (!empty($_GET['u_code']))
                    <input id="user_code_friend" name="user_code_friend" type="hidden" value="{{ $_GET['u_code'] }}">
                    @endif
                    <div class="col_full">
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-9">
                                <div class="form-check form-check-inline">
                                    <input id="user_type1" class="radio-style ckUser" name="user_type" type="radio" value="1" @if(!empty(old('user_type'))) @if(old('user_type')==1) checked @endif @else checked @endif>
                                    <label for="user_type1" class="radio-style-2-label no-mg radio-small">บุคคลธรรมดา</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input id="user_type2" class="radio-style ckCompany" name="user_type" type="radio" value="2" @if(!empty(old('user_type'))) @if(old('user_type')==2) checked @endif @endif>
                                    <label for="user_type2" class="radio-style-2-label no-mg radio-small">บริษัท/สำนักงาน/องค์กร</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div id="show-user" @if(!empty(old('user_type'))) @if(old('user_type')==1) style="display: block" @else style="display: none" @endif @else style="display: block" @endif>
                        <div class="col_full">
                            <div class="row">
                                <div class="col-md-3">
                                    ชื่อ - สกุล <span class="span-danger">*</span>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" placeholder="ชื่อ" id="name" name="name" value="{{ old('name') }}" class="sm-form-control @error('name') is-invalid @enderror">
                                    @error('name')<small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>@enderror
                                </div>
                                <div class="col-md-5">
                                    <input type="text" placeholder="นามสกุล" id="lastname" name="lastname" value="{{ old('lastname') }}" class="sm-form-control @error('lastname') is-invalid @enderror">
                                    @error('lastname')<small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>@enderror
                                </div>
                            </div>
                        </div>
                        @if(!empty($settingUser))
                        @if($settingUser->position_status == 1)
                        <div class="col_full">
                            <div class="row">
                                <div class="col-md-3">
                                ตำแหน่ง/อาชีพ
</div>
<div class="col-md-9">
    <select id="positionId" name="positionId" class="sm-form-control @error('positionId') is-invalid @enderror">
        <option value="" selected>ไม่ระบุ</option>
        @foreach ($position as $position)
        <option value="{{$position->id}}">{{$position->position_name}}</option>
        @endforeach
    </select>
                                    @error('positionId')<small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>@enderror
                                </div>
                            </div>
                        </div>
                        @endif
                        @endif
                    </div>
                    <div id="show-company" @if(!empty(old('user_type'))) @if(old('user_type')==2) style="display: block" @else style="display: none" @endif @else style="display: none" @endif>
                        <div class="col_full">
                            <div class="row">
                                <div class="col-md-3">
                                    ชื่อบริษัท <span class="span-danger">*</span>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" placeholder="ชื่อบริษัท" id="user_company_name" name="user_company_name" value="{{ old('user_company_name') }}" class="sm-form-control @error('user_company_name') is-invalid @enderror">
                                    @error('user_company_name')<small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>@enderror
                                </div>
                            </div>
                        </div>
                        @if(!empty($settingUser))
                        @if($settingUser->business_status == 1)
                        <div class="col_full">
                            <div class="row">
                                <div class="col-md-3">
    ประเภทธุรกิจ
</div>
<div class="col-md-9">
    <select id="businessId" name="businessId" class="sm-form-control @error('businessId') is-invalid @enderror">
        <option value="" selected>ไม่ระบุ</option>
        @foreach ($business as $categories)
        <option value="{{$categories->id}}">{{$categories->business_name}}</option>
        @endforeach
    </select>
                                    @error('businessId')<small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>@enderror
                                </div>
                            </div>
                        </div>
                        @endif
                        @endif
                        <div class="col_full">
                            <div class="row">
                                <div class="col-md-3">
                                    ชื่อผู้ติดต่อ <span class="span-danger">*</span>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" placeholder="ชื่อ" id="name_contact" name="name_contact" value="{{ old('name_contact') }}" class="sm-form-control @error('name_contact') is-invalid @enderror">
                                    @error('name_contact')<small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>@enderror
                                </div>
                                <div class="col-md-5">
                                    <input type="text" placeholder="นามสกุล" id="lastname_contact" name="lastname_contact" value="{{ old('lastname_contect') }}" class="sm-form-control @error('lastname_contect') is-invalid @enderror">
                                    @error('lastname_contact')<small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>@enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col_full">
                        <div class="row">
                            <div class="col-md-3">
                                เบอร์โทรศัพท์ <span class="span-danger">*</span>
                            </div>
                            <div class="col-md-9">
                               <input placeholder="เบอร์โทรศัพท์" id="user_tel" type="text" class="sm-form-control n_tel @error('user_tel') is-invalid @enderror" name="user_tel" value="{{ old('user_tel') }}" oninput="limitPhoneLength(this)">
                                @error('user_tel')<small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="col_full">
                        <div class="row">
                            <div class="col-md-3">
                                อีเมล <span class="span-danger">*</span>
                            </div>
                            <div class="col-md-9">
                                <input placeholder="อีเมล" id="email" type="text" class="sm-form-control c_email @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}">
                                @error('email')<small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="col_full">
                        <div class="row">
                            <div class="col-md-3">
                                รหัสผ่าน <span class="span-danger">*</span>
                            </div>
                            <div class="col-md-9">
                                <input type="password" placeholder="รหัสผ่านไม่น้อยกว่า 8 ตัวอักษร" id="password" name="password" value="" class="sm-form-control @error('password') is-invalid @enderror" autocomplete="new-password">
                                @error('password')<small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="col_full">
                        <div class="row">
                            <div class="col-md-3">
                                ยืนยันรหัสผ่าน
                            </div>
                            <div class="col-md-9">
                                <input id="password-confirm" name="password_confirmation" placeholder="ยืนยันรหัสผ่าน" type="password" class="sm-form-control" autocomplete="new-password">
                            </div>
                        </div>
                    </div>
                    @if(!empty($settingUser))
                    @if($settingUser->pdpa_status == 1)
                    <div class="col_full">
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-9">
                                <div class="pdpa-wb">
                                    <input type="checkbox" id="pdpa_wording1" name="pdpa_wording1" value="1" class="checkbox-style" @if (!empty(old('pdpa_wording1'))) checked @endif>
                                    <label for="pdpa_wording1" class="checkbox-style-3-label">{!! $settingUser->pdpa_detail !!}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @endif
                    <div class="col_full">
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-9">
								<!--input type="text" id="nickname" name="nickname" class="fpb"-->
								{{  Form::hidden('url',URL::previous())  }}
                                @if(!empty($extension) && $extension->ext_captcha_status == 1 && !empty($extension->ext_captcha))
                                <button class="loadding btn btn-outline-register g-recaptcha" data-sitekey="{{$extension->ext_captcha}}" data-callback='onSubmit' data-action='submit'>
                                @else
                                <button type="submit" class="loadding btn btn-outline-register">
                                @endif
                                            สมัครสมาชิก
                                        </button>
                            </div>
                        </div>
                    </div>

                </form>
                <div class="clearfux"></div>
            </div>
        </div>
</section>

@endsection

@section('js')
<script src="https://www.google.com/recaptcha/api.js"></script>
<script src="{{ asset('vendor/select2/select2.min.js') }}"></script>
<script src="{{ asset('vendor/select2-bootstrap4-theme/docs/script.js') }}"></script>
<script>
    $('.select-multiple').select2();
	
	function onSubmit(token) {
		document.getElementById("form-register").submit();
	}
    function limitPhoneLength(input) {
    var digits = input.value.replace(/[^0-9]/g, '');
    var maxLen = digits.startsWith('02') ? 9 : 10;
    if (digits.length > maxLen) {
        digits = digits.substring(0, maxLen);
    }
    input.value = digits;
}
</script>
@endsection