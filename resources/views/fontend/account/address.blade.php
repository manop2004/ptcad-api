@extends('layouts.temp_user')

@section('title'){{ $og_title }} | @endsection
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
button[type="submit"]{margin:0 !important}

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

/* ปรับส่วนหัวให้จัดตรงกลาง Flexbox ครบถ้วน */
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

/* ปรับ Breadcrumb ให้ตรงกลางด้วย */
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

.acct-main{display:grid;gap:24px}
.acct-card{background:#fff;border:1px solid var(--line);border-radius:24px;padding:32px;box-shadow:0 12px 34px rgba(20,53,143,.055)}

/* หัวข้อย่อยในการ์ด เช่น "ข้อมูลผู้รับ" / "ที่อยู่จัดส่ง" */
.acct-subhead{display:flex;align-items:center;gap:10px;margin:0 0 20px;padding-bottom:14px;border-bottom:1px solid var(--line)}
.acct-subhead:not(:first-child){margin-top:8px}
.acct-subhead .ico{width:34px;height:34px;border-radius:10px;background:#eef6ff;color:var(--blue);display:grid;place-items:center;flex:none}
.acct-subhead span{font-weight:800;font-size:15px;color:#102b76}

.acct-card .form-group{margin-bottom:18px}
.acct-card label{color:#344054;font-weight:700;font-size:13.5px;display:block;margin-bottom:7px}
.acct-card .sm-form-control{
  border:1.5px solid var(--line);border-radius:12px;height:44px;padding:0 15px;width:100%;
  font-size:14px;font-family:inherit;color:var(--ink);transition:.15s ease;background:#fbfcff;
}
.acct-card .sm-form-control:focus{
  outline:none;border-color:var(--blue);background:#fff;box-shadow:0 0 0 4px rgba(23,101,255,.10);
}
.acct-card textarea.sm-form-control{height:auto;padding:12px 15px;min-height:96px;line-height:1.6}
.acct-card select.sm-form-control{height:44px}
.acct-card .text-danger{color:var(--red)}
.acct-card .invalid-feedback{color:var(--red);font-size:12.5px;margin-top:4px;display:block}
.acct-card .alert-danger{
  background:#fff1f1;border:1px solid #ffd4d4;color:#b42318;border-radius:14px;
  padding:14px 18px;font-size:13.5px;font-weight:600;margin-bottom:22px;
}

/* select2 ให้เข้าธีมเดียวกับ input */
.acct-card .select2-container .select2-selection--single{
  height:44px !important;border:1.5px solid var(--line) !important;border-radius:12px !important;background:#fbfcff;
}
.acct-card .select2-container .select2-selection--single .select2-selection__rendered{line-height:44px !important;padding-left:15px !important;font-size:14px;color:var(--ink)}
.acct-card .select2-container .select2-selection--single .select2-selection__arrow{height:42px !important;right:10px}
.acct-card .select2-container--open .select2-selection--single{border-color:var(--blue) !important;box-shadow:0 0 0 4px rgba(23,101,255,.10)}
.select2-results__option--highlighted{background:var(--blue) !important}

/* radio การ์ดเลือกประเภทผู้ซื้อ */
.acct-radio-group{display:flex;gap:14px;flex-wrap:wrap;margin-bottom:6px}
.acct-radio-group .inline{
  display:flex;align-items:center;gap:8px;border:1.5px solid var(--line);border-radius:12px;
  padding:11px 18px;cursor:pointer;transition:.15s ease;background:#fbfcff;
}
.acct-radio-group .inline:has(input:checked){border-color:var(--blue);background:#eef6ff}
.acct-radio-group label{margin:0;cursor:pointer;font-size:13.5px}

/* ปุ่มบันทึก ให้เหมือนปุ่มหลักของหน้าอื่นในเว็บ */
.acct-card .btn-save,
.acct-card button[type="submit"],
.acct-card input[type="submit"]{
  height:46px !important;padding:0 32px !important;border-radius:12px !important;border:none !important;
  background:linear-gradient(135deg,var(--blue),#0d57df) !important;color:#fff !important;
  font-weight:800 !important;font-size:15px !important;cursor:pointer;
  box-shadow:0 12px 24px rgba(23,101,255,.24);transition:.15s ease;
  display:inline-flex;align-items:center;justify-content:center;gap:8px;
}
.acct-card .btn-save:hover,
.acct-card button[type="submit"]:hover,
.acct-card input[type="submit"]:hover{
  transform:translateY(-2px);box-shadow:0 16px 30px rgba(23,101,255,.30);
}

/* แถบแท็บ ให้ดูเป็นปุ่ม pill เหมือนหน้าอื่น */
.acct-tab-nav{display:flex;gap:10px;margin-bottom:24px;flex-wrap:wrap;border-bottom:1px solid var(--line);padding-bottom:0}
.acct-tab-nav a{
  padding:12px 20px;border-radius:12px 12px 0 0;background:transparent;color:var(--muted);
  font-weight:800;font-size:14px;position:relative;bottom:-1px;border-bottom:2.5px solid transparent;
  transition:.15s ease;
}
.acct-tab-nav a:hover{color:var(--blue)}

/* แก้ไขสถานะ Tab active */
.acct-tab-nav a.tab-active,
.acct-tab-nav li.ui-tabs-active > a,
.acct-tab-nav li.ui-state-active > a,
.acct-tab-nav li.ui-state-default.ui-corner-top.ui-tabs-active.ui-state-active > a.ui-tabs-anchor{
    color:#1765ff !important;
    border-bottom-color:#1765ff !important;
}

@media (max-width:1000px){
  .acct-portal{grid-template-columns:1fr}
  .acct-side{position:relative;top:0;display:grid;grid-template-columns:repeat(3,1fr)}
  .acct-card{padding:22px}
}
@media (max-width:640px){
  .acct-side{grid-template-columns:1fr 1fr}
  .acct-radio-group{flex-direction:column}
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
        <div class="eyebrow"><i data-lucide="map-pin" size="16"></i> MY PTCAD</div>
        <h1>ที่อยู่จัดส่ง</h1>
        <p>จัดการที่อยู่สำหรับจัดส่งสินค้าและที่อยู่สำหรับออกใบเสร็จรับเงิน</p>
    </section>

    <div class="acct-portal">
        @include('layouts.fontend.account_sidebar')

        <div class="acct-main">
            <div class="tabs clearfix" id="tab-3">
                <ul class="tab-nav tab-nav2 clearfix acct-tab-nav">
                    <li><a href="#tabs-address">ที่อยู่สำหรับจัดส่งสินค้า</a></li>
                    <li><a href="#tabs-receipt">ที่อยู่สำหรับจัดส่งใบเสร็จรับเงิน</a></li>
                </ul>
                <div class="tab-container">
                    
                    {{-- TAB 1: Shipping Address --}}
                    <div class="tab-content clearfix" id="tabs-address">
                        <section class="acct-card">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    ข้อมูลไม่ถูกต้อง กรุณาตรวจสอบข้อมูลก่อนบันทึกอีกครั้ง!!
                                </div>
                            @endif

                            @if(empty($usersAddress))
                                {!! Form::open([
                                    'novalidate',
                                    'route' => 'fronend.account.address.crate',
                                    'id'=>'address-form',
                                    'method' => 'post',
                                    'files' => true
                                ]) !!}
                            @else
                                {!! Form::model($usersAddress, [
                                    'novalidate',
                                    'route' => ['fronend.account.address.update', [$usersAddress->id]],
                                    'id'=>'address-form',
                                    'method' => 'put',
                                    'files' => true
                                ]) !!}
                            @endif

                            @if(!empty($usersAddress))
                                <input id="address_province" name="address_province" type="hidden" value="{{ $usersAddress->province }}">
                                <input id="address_amphures" name="address_amphures" type="hidden" value="{{ $usersAddress->amphures }}">
                                <input id="address_district" name="address_district" type="hidden" value="{{ $usersAddress->district }}">
                                <input id="address_zipcode" name="address_zipcode" type="hidden" value="{{ $usersAddress->zipcode }}">
                            @endif

                            <div class="acct-subhead">
                                <span class="ico"><i data-lucide="user" size="16"></i></span>
                                <span>ข้อมูลผู้รับ</span>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>ชื่อ <span class="text-danger">*</span></label>
                                        <input id="userId" name="userId" type="hidden" value="{{ Auth::user()->id }}">
                                        <input id="name" name="name" type="text" class="sm-form-control" value="{{ !empty($usersAddress->name) ? $usersAddress->name : old('name') }}">
                                        @error('name')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>สกุล <span class="text-danger">*</span></label>
                                        <input id="lastname" name="lastname" type="text" class="sm-form-control" value="{{ !empty($usersAddress->lastname) ? $usersAddress->lastname : old('lastname') }}">
                                        @error('lastname')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>เบอร์โทรศัพท์ <span class="text-danger">*</span></label>
                                        <input id="tel" name="tel" type="text" class="sm-form-control" value="{{ !empty($usersAddress->tel) ? $usersAddress->tel : old('tel') }}">
                                        @error('tel')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="acct-subhead" style="margin-top:8px">
                                <span class="ico"><i data-lucide="map-pin" size="16"></i></span>
                                <span>ที่อยู่จัดส่ง</span>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>บ้านเลขที่ ถนน ซอย <span class="text-danger">*</span></label>
                                        <textarea id="address" name="address" class="sm-form-control">{{ !empty($usersAddress->address) ? $usersAddress->address : old('address') }}</textarea>
                                        @error('address')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>จังหวัด <span class="text-danger">*</span></label>
                                        <select id="province" name="province" data-placeholder="กรุณาเลือกจังหวัด" class="sm-form-control" onchange="amphuresAddress()">
                                            <option></option>
                                            @foreach ($provinces as $province)
                                                <option value="{{ $province->id }}" 
                                                    @if(!empty($usersAddress->province) && $province->id == $usersAddress->province) 
                                                        selected 
                                                    @elseif(old('province') == $province->id) 
                                                        selected 
                                                    @endif>
                                                    {{ $province->prov_name_th }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('province')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>เขต/อำเภอ <span class="text-danger">*</span></label>
                                        <select id="amphures" name="amphures" data-placeholder="กรุณาเลือกเขต/อำเภอ" class="sm-form-control" onchange="districtAddress()">
                                            <option></option>
                                        </select>
                                        @error('amphures')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>แขวง / ตำบล <span class="text-danger">*</span></label>
                                        <select id="district" name="district" data-placeholder="กรุณาเลือกแขวง / ตำบล" class="sm-form-control" onchange="zipcodeAddress()">
                                            <option></option>
                                        </select>
                                        @error('district')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>รหัสไปรษณีย์ <span class="text-danger">*</span></label>
                                        <input id="zipcode" name="zipcode" placeholder="กรุณากรอกรหัสไปรษณีย์" class="sm-form-control" value="" />
                                        @error('zipcode')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>ข้อความถึงผู้ขาย </label>
                                        <textarea id="message" name="message" class="sm-form-control">{{ !empty($usersAddress->message) ? $usersAddress->message : old('message') }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        @include('layouts.fontend.button.save')
                                    </div>
                                </div>
                            </div>
                            
                            {!! Form::close() !!}
                        </section>
                    </div>

                    {{-- TAB 2: Receipt / Invoice --}}
                    <div class="tab-content clearfix" id="tabs-receipt">
                        <section class="acct-card">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    ข้อมูลไม่ถูกต้อง กรุณาตรวจสอบข้อมูลก่อนบันทึกอีกครั้ง!!
                                </div>
                            @endif
                            
                            @if(empty($usersReceipt))
                                {!! Form::open([
                                    'novalidate',
                                    'route' => 'fronend.account.receipt.crate',
                                    'id'=>'receipt-form',
                                    'method' => 'post',
                                    'files' => true
                                ]) !!}
                            @else
                                {!! Form::model($usersReceipt, [
                                    'novalidate',
                                    'route' => ['fronend.account.receipt.update', [$usersReceipt->id]],
                                    'id'=>'receipt-form',
                                    'method' => 'put',
                                    'files' => true
                                ]) !!}
                            @endif

                            <input id="receipt_hd_province" name="receipt_hd_province" type="hidden" value="{{ !empty($usersReceipt->province) ? $usersReceipt->province : '' }}">
                            <input id="receipt_hd_amphures" name="receipt_hd_amphures" type="hidden" value="{{ !empty($usersReceipt->amphures) ? $usersReceipt->amphures : '' }}">
                            <input id="receipt_hd_district" name="receipt_hd_district" type="hidden" value="{{ !empty($usersReceipt->district) ? $usersReceipt->district : '' }}">
                            <input id="receipt_hd_zipcode" name="receipt_hd_zipcode" type="hidden" value="{{ !empty($usersReceipt->zipcode) ? $usersReceipt->zipcode : '' }}">

                            <div class="acct-subhead">
                                <span class="ico"><i data-lucide="file-text" size="16"></i></span>
                                <span>ประเภทผู้ขอใบเสร็จ</span>
                            </div>

                            {{-- ประเภทผู้ขอใบเสร็จผูกกับประเภทบัญชีที่ Login เข้ามา ไม่ให้เลือกเองอีกต่อไป --}}
                            <input id="receipt_persona_type" name="receipt_persona_type" type="hidden" value="{{ Auth::user()->user_type == 2 ? 2 : 1 }}">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <span style="display:inline-flex;align-items:center;gap:8px;font-weight:700;color:#102b76;">
                                            <i data-lucide="{{ Auth::user()->user_type == 2 ? 'building-2' : 'user' }}" size="16"></i>
                                            {{ Auth::user()->user_type == 2 ? 'บริษัท/สำนักงาน/องค์กร' : 'บุคคลธรรมดา' }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="acct-subhead" style="margin-top:8px">
                                <span class="ico"><i data-lucide="building-2" size="16"></i></span>
                                <span>ข้อมูลใบกำกับภาษี</span>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>เลขประจำตัวผู้เสียภาษี <span class="text-danger">*</span></label>
                                        <input id="receipt_taxid" name="receipt_taxid" type="text" class="sm-form-control" value="{{ old('receipt_taxid', !empty($usersReceipt->taxid) ? $usersReceipt->taxid : '') }}">
                                        @error('receipt_taxid')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>บริษัท </label>
                                        <input id="receipt_company" name="receipt_company" type="text" class="sm-form-control" value="{{ old('receipt_company', !empty($usersReceipt->company) ? $usersReceipt->company : '') }}">
                                        @error('receipt_company')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>สาขา (ถ้ามี)</label>
                                        <input id="receipt_branch" name="receipt_branch" type="text" class="sm-form-control" value="{{ old('receipt_branch', !empty($usersReceipt->branch) ? $usersReceipt->branch : '') }}">
                                        @error('receipt_branch')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="acct-subhead" style="margin-top:8px">
                                <span class="ico"><i data-lucide="user" size="16"></i></span>
                                <span>ข้อมูลผู้ติดต่อ</span>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>ชื่อ <span class="text-danger">*</span></label>
                                        <input id="receipt_userId" name="receipt_userId" type="hidden" value="{{ Auth::user()->id }}">
                                        <input id="receipt_name" name="receipt_name" type="text" class="sm-form-control" value="{{ old('receipt_name', !empty($usersReceipt->name) ? $usersReceipt->name : '') }}">
                                        @error('receipt_name')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>สกุล <span class="text-danger">*</span></label>
                                        <input id="receipt_lastname" name="receipt_lastname" type="text" class="sm-form-control" value="{{ old('receipt_lastname', !empty($usersReceipt->lastname) ? $usersReceipt->lastname : '') }}">
                                        @error('receipt_lastname')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>เบอร์โทรศัพท์ <span class="text-danger">*</span></label>
                                        <input id="receipt_tel" name="receipt_tel" type="text" class="sm-form-control" value="{{ old('receipt_tel', !empty($usersReceipt->tel) ? $usersReceipt->tel : '') }}">
                                        @error('receipt_tel')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="acct-subhead" style="margin-top:8px">
                                <span class="ico"><i data-lucide="map-pin" size="16"></i></span>
                                <span>ที่อยู่ออกใบกำกับภาษี</span>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>บ้านเลขที่ ถนน ซอย <span class="text-danger">*</span></label>
                                        <textarea id="receipt_address" name="receipt_address" class="sm-form-control">{{ !empty($usersReceipt->address) ? $usersReceipt->address : old('receipt_address') }}</textarea>
                                        @error('receipt_address')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>จังหวัด <span class="text-danger">*</span></label>
                                        <select id="receipt_province" name="receipt_province" data-placeholder="กรุณาเลือกจังหวัด" class="sm-form-control" onchange="amphuresReceipt()">
                                            <option></option>
                                            @foreach ($provinces as $province)
                                                <option value="{{ $province->id }}" 
                                                    @if(!empty($usersReceipt->province) && $usersReceipt->province == $province->id) 
                                                        selected 
                                                    @elseif(old('receipt_province') == $province->id) 
                                                        selected 
                                                    @endif>
                                                    {{ $province->prov_name_th }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('receipt_province')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>เขต/อำเภอ <span class="text-danger">*</span></label>
                                        <select id="receipt_amphures" name="receipt_amphures" data-placeholder="กรุณาเลือกเขต/อำเภอ" class="sm-form-control" onchange="districtReceipt()">
                                            <option></option>
                                        </select>
                                        @error('receipt_amphures')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>แขวง / ตำบล <span class="text-danger">*</span></label>
                                        <select id="receipt_district" name="receipt_district" data-placeholder="กรุณาเลือกแขวง / ตำบล" class="sm-form-control" onchange="zipcodeReceipt()">
                                            <option></option>
                                        </select>
                                        @error('receipt_district')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>รหัสไปรษณีย์ <span class="text-danger">*</span></label>
                                        <input id="receipt_zipcode" name="receipt_zipcode" placeholder="กรุณากรอกรหัสไปรษณีย์" class="sm-form-control" value="" />
                                        @error('receipt_zipcode')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>ข้อความถึงผู้ขาย </label>
                                        <textarea id="receipt_message" name="message" class="sm-form-control">{{ !empty($usersReceipt->message) ? $usersReceipt->message : old('message') }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        @include('layouts.fontend.button.save')
                                    </div>
                                </div>
                            </div>

                            {!! Form::close() !!}
                        </section>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@section('js')
<script src="{{ asset('vendor/select2/select2.min.js') }}"></script>
@endsection