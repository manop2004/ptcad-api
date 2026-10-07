@extends('layouts.temp_user')

@section('title'){{ $og_title }} |@endsection
@section('og_site_name'){{ $og_site_name }}@endsection
@section('og_keywords'){{ $og_keywords }}@endsection
@section('og_title'){{ $og_title }}@endsection
@section('og_description'){{ $og_description }}@endsection
@section('og_url'){{ $og_url }}@endsection
@section('og_image'){{ $og_image }}@endsection

@section('css')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
<link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendor/select2-bootstrap4-theme/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/fontend/css/components/radio-checkbox.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/fontend/css/custom_quotation.css') }}" type="text/css" />

<style>
/* ======================================================
   THEME VARIABLES (คุมโทนสีน้ำเงินคราม ทันสมัย)
   ====================================================== */
:root {
  --navy: #12358f;
  --blue: #1765ff;
  --ink: #0b1f4d;
  --muted: #667085;
  --line: #e6edf8;
  --soft-blue: #f4f9ff;
  --shadow: 0 12px 34px rgba(20,53,143,.055);
}

/* ======================================================
   TYPE PICKER (การ์ดเลือกประเภท บุคคล / บริษัท)
   ====================================================== */
.quote-type-scope .type-picker {
  margin-bottom: 25px;
}

.quote-type-scope .type-card {
  width: 100% !important;
  display: flex !important; 
  flex-direction: column !important; 
  align-items: center !important; 
  justify-content: center !important;
  gap: 12px !important; 
  padding: 24px 16px !important;
  background: #ffffff !important; 
  border: 1.5px solid var(--line) !important; 
  border-radius: 16px !important;
  box-sizing: border-box !important;
  transition: all .25s ease !important;
  cursor: pointer !important; 
  min-height: 120px !important;
  box-shadow: 0 4px 12px rgba(20,53,143,.02) !important;
  outline: none !important;
}

.quote-type-scope .type-card i { 
  font-size: 36px !important; 
  line-height: 1 !important; 
  color: var(--muted) !important;
  transition: all .25s ease !important;
}

.quote-type-scope .type-card .t-muted { 
  font-size: 12px !important; 
  color: var(--muted) !important; 
  margin-bottom: 2px;
}

.quote-type-scope .type-card strong { 
  font-size: 15px !important; 
  font-weight: 700 !important;
  color: var(--ink) !important;
  transition: all .25s ease !important;
}

/* Hover State */
.quote-type-scope .type-card:hover { 
  transform: translateY(-3px) !important; 
  box-shadow: 0 12px 24px rgba(20,53,143,.08) !important; 
  border-color: #cbd5e1 !important; 
}

/* Active State (เมื่อถูกเลือก) */
.quote-type-scope .type-card.active { 
  border-color: var(--blue) !important; 
  background: var(--soft-blue) !important;
  box-shadow: 0 0 0 5px rgba(23,101,255,.12) !important; 
}
.quote-type-scope .type-card.active i {
  color: var(--blue) !important;
}
.quote-type-scope .type-card.active strong {
  color: var(--navy) !important;
}

/* ======================================================
   FLOATING LABEL INPUTS (กล่องกรอกข้อมูลหรูหราพร้อมป้ายลอยตัว)
   ====================================================== */
.form-scope .fl-group { 
  position: relative !important; 
  margin-bottom: 20px !important; 
}

/* คุมสไตล์กล่องอินพุตทั้งหมด */
.form-scope .fl-group input,
.form-scope .fl-group select,
.form-scope .fl-group textarea {
  width: 100% !important;
  border: 1.5px solid var(--line) !important; 
  border-radius: 12px !important;
  padding: 22px 16px 8px !important; 
  background: #ffffff !important; 
  font-size: 14.5px !important;
  color: var(--ink) !important;
  font-weight: 500 !important;
  box-sizing: border-box !important;
  transition: all .2s ease !important;
  box-shadow: none !important;
  height: 54px !important;
}

/* ปรับแต่งความสูงแยกต่างหากสำหรับ Textarea */
.form-scope .fl-group textarea {
  height: 120px !important;
  padding-top: 24px !important;
  resize: vertical !important;
}

/* ค่าเริ่มต้นของป้ายข้อความกำกับ (Label) */
.form-scope .fl-group label {
  position: absolute !important; 
  top: 50% !important; 
  left: 16px !important; 
  transform: translateY(-50%) !important;
  font-size: 14px !important; 
  color: var(--muted) !important;
  pointer-events: none !important; 
  transition: all .2s cubic-bezier(0.4, 0, 0.2, 1) !important; 
  margin: 0 !important;
  font-weight: 500 !important;
}

/* บังคับดันป้าย Label ลอยขึ้นเมื่อช่องนั้นถูกเลือกหรือมีข้อความอยู่ */
.form-scope .fl-group:focus-within label,
.form-scope .fl-group input:not(:placeholder-shown) ~ label,
.form-scope .fl-group textarea:not(:placeholder-shown) ~ label,
.form-scope .fl-group select:focus ~ label,
.form-scope .fl-group select:not([value=""]) ~ label {
  top: 14px !important;
  transform: translateY(-50%) scale(.8) !important;
  transform-origin: left top !important;
  color: var(--blue) !important;
  font-weight: 700 !important;
}

/* ปรับแต่ง Label เฉพาะของ Textarea ตอนลอยตัว */
.form-scope .fl-group textarea:focus ~ label,
.form-scope .fl-group textarea:not(:placeholder-shown) ~ label {
  top: 16px !important;
}

/* Focus State ของช่องกรอกข้อมูล */
.form-scope .fl-group input:focus,
.form-scope .fl-group select:focus,
.form-scope .fl-group textarea:focus {
  border-color: var(--blue) !important;
  outline: none !important;
  box-shadow: 0 0 0 4px rgba(23,101,255,.08) !important;
  background: #ffffff !important;
}

/* ======================================================
   SUBMIT BUTTON (ปุ่มส่งขอใบเสนอราคาสีน้ำเงินคราม)
   ====================================================== */
.btn-outline-quotation {
  background: linear-gradient(135deg, var(--blue), #0d57df) !important;
  color: #ffffff !important;
  border: none !important;
  border-radius: 12px !important;
  height: 52px !important;
  width: 100% !important;
  font-weight: 700 !important;
  font-size: 16px !important;
  transition: all 0.25s ease !important;
  box-shadow: 0 10px 20px rgba(23, 101, 255, 0.15) !important;
  cursor: pointer !important;
  display: flex !important;
  align-items: center !important;
  justify-content: center !important;
}

.btn-outline-quotation:hover {
  color: #ffffff !important;
  transform: translateY(-2px) !important;
  box-shadow: 0 14px 28px rgba(23, 101, 255, 0.25) !important;
}

.btn-outline-quotation:active {
  transform: translateY(0) !important;
}

/* ===== PDPA checkbox + ลิงก์ "นโยบายส่วนบุคคล" ที่ดึงมาจาก DB — แก้เขียว -> น้ำเงินธีม PTCAD ===== */
.pdpa-wb-quotation .checkbox-style:checked + .checkbox-style-3-label:before{
  background: #1765ff !important;
}
.pdpa-wb-quotation .checkbox-style-3-label a{
  color: #1765ff !important;
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
            @endif
           <div class="container-xs topmargin-sm">
                <h1 class="text-center">ขอใบเสนอราคา</h1>
                <div class="text-center">กรุณากรอกข้อมูลการติดต่อให้ครบถ้วน เพื่อให้ทาง PTCAD  ได้นำข้อมูลส่วนนี้ไปทำใบเสนอราคาของคุณ</div>
                <hr/>
                @if (Route::has('login'))
                    @auth
                
                    @else
                    
                    @endauth
                @endif
                
                @php
                  // Login แล้ว: ผูกประเภทตามบัญชี (ห้ามเลือกเอง) / ยังไม่ Login: ให้เลือกเองเหมือนเดิม
                  $prefType = Auth::check()
                      ? (Auth::user()->user_type == 2 ? 2 : 1)
                      : ($data['userAddress']['userType'] ?? old('type'));
                  $showForm = Auth::check() || !empty($prefType) || $errors->any();
                @endphp

                <div class="quote-type-scope">
                  @guest
                    <div class="type-picker row topmargin-sm" id="quote-type-picker" aria-label="เลือกประเภทผู้ขอใบเสนอราคา">
                      <div class="col-sm-6">
                        <button type="button" class="type-card @if($prefType==1) active @endif" data-type="1" aria-controls="form-quotation">
                          <i class="bi bi-person-circle" aria-hidden="true"></i>
                          <div>
                            <div class="t-muted">ขอใบเสนอราคาในนาม</div>
                            <strong>บุคคลธรรมดา</strong>
                          </div>
                        </button>
                      </div>
                      <div class="col-sm-6">
                        <button type="button" class="type-card @if($prefType==2) active @endif" data-type="2" aria-controls="form-quotation">
                          <i class="bi bi-buildings-fill" aria-hidden="true"></i>
                          <div>
                            <div class="t-muted">ขอใบเสนอราคาในนาม</div>
                            <strong>บริษัท/สำนักงาน/องค์กร</strong>
                          </div>
                        </button>
                      </div>
                    </div>
                  @else
                    {{-- Login แล้ว: โชว์แค่ป้ายประเภทตามบัญชี ไม่ให้เลือกเอง --}}
                    <div class="row topmargin-sm">
                      <div class="col-12">
                        <span style="display:inline-flex;align-items:center;gap:8px;font-weight:700;color:#102b76;">
                          <i class="bi {{ Auth::user()->user_type == 2 ? 'bi-buildings-fill' : 'bi-person-circle' }}" aria-hidden="true"></i>
                          ขอใบเสนอราคาในนาม {{ Auth::user()->user_type == 2 ? 'บริษัท/สำนักงาน/องค์กร' : 'บุคคลธรรมดา' }}
                        </span>
                      </div>
                    </div>
                  @endguest
                </div>

                <div class="row topmargin-sm" id="quote-form-wrap" @if(!$showForm) style="display:none" @endif>

                  <div class="form-scope">
                    <form id="form-quotation" method="POST" action="{{ route('fronend.quotation.crate') }}">
                      @csrf
                      <input type="hidden" id="type" name="type" value="{{ $prefType ?? '' }}">

                        {{-- ซ่อนค่าอัตโนมัติเดิม --}}
                        @if(!empty($data['userAddress']))
                          <input id="address_province" name="address_province" type="hidden" value="{{-- $data['userAddress']['userProvince'] --}}">
                          <input id="address_amphures" name="address_amphures" type="hidden" value="{{-- $data['userAddress']['userAmphures'] --}}">
                          <input id="address_district" name="address_district" type="hidden" value="{{-- $data['userAddress']['userDistrict'] --}}">
                          <input id="address_zipcode" name="address_zipcode" type="hidden" value="{{-- $data['userAddress']['userZipcode'] --}}">
                        @endif
                        <input id="ref" name="ref" type="hidden" @if (!empty($_GET['_ref'])) value="{{ $_GET['_ref'] }}" @else value="" @endif>
                        @if ($errors->has('recaptcha') || $errors->has('too_many'))
    <div class="col-12" style="margin-bottom: 20px;">
        <div style="background:#fff5f5; border:1.5px solid #ffe3e3; color:#dc3545; padding:14px 18px; border-radius:10px; font-size:14px; font-weight:600;">
            @error('recaptcha'){{ $message }}@enderror
            @error('too_many'){{ $message }}@enderror
        </div>
    </div>
@endif

                        {{-- ---- เริ่มฟิลด์เรียงใหม่ ---- --}}

                        <div class="row g-3">

                          {{-- company --}}
                          <div class="col-md-6">
                            <div class="fl-group @error('company') is-invalid @enderror">
                              <input
                                  type="text"
                                  id="company"
                                  name="company"
                                  placeholder=" "
                                  required
                                  autocomplete="organization"
                                  spellcheck="false"
                                  lang="en"
                                  inputmode="text"
                                  pattern="[A-Za-z0-9\s\.\,&'’\-\(\)\/]+"
                                  title="กรอกเป็นภาษาอังกฤษเท่านั้น"
                                  value="{{ $data['userAddress']['userCompany'] ?? old('company') }}"
                                >

                              <label for="company">ชื่อบริษัท/องค์กร <span class="span-danger">*</span></label>
                            </div>
                            @error('company')<small class="invalid-feedback"><strong>{{ $message }}</strong></small>@enderror
                          </div>


                          {{-- tax --}}
<div class="col-md-6">
  <div class="fl-group @error('tax') is-invalid @enderror">
    <input
        type="text"
        id="tax"
        name="tax"
        placeholder=" "
        inputmode="numeric"
        maxlength="13"
        value="{{ old('tax') }}"
      >
    <label for="tax">เลขประจำตัวผู้เสียภาษี <span class="t-muted" style="font-size:12px;">(จำเป็นสำหรับนิติบุคคล)</span></label>
  </div>
  @error('tax')<small class="invalid-feedback"><strong>{{ $message }}</strong></small>@enderror
</div>

                          {{-- fullname --}}
                          <div class="col-md-6">
                            <div class="fl-group @error('fullname') is-invalid @enderror">
                              <input type="text" id="fullname" name="fullname" placeholder=" " value="@if(old('fullname')){{ old('fullname') }}@elseif(!empty($data['userAddress']['userName']) || !empty($data['userAddress']['userLastname'])){{ trim(($data['userAddress']['userName'] ?? '').' '.($data['userAddress']['userLastname'] ?? '')) }}@endif">
                              <label for="fullname">ชื่อ-สกุล ผู้ติดต่อ <span class="span-danger">*</span></label>
                            </div>
                            @error('fullname')<small class="invalid-feedback"><strong>{{ $message }}</strong></small>@enderror
                          </div>

                          {{-- tel --}}
                          <div class="col-md-6">
                            <div class="fl-group @error('tel') is-invalid @enderror">
                              <input type="text" id="tel" name="tel" class="n_tel" placeholder=" "
                                value="{{ $data['userAddress']['userTel'] ?? old('tel') }}">
                              <label for="tel">เบอร์โทรศัพท์ <span class="span-danger">*</span></label>
                            </div>
                            @error('tel')<small class="invalid-feedback"><strong>{{ $message }}</strong></small>@enderror
                          </div>

                          {{-- email --}}
                          <div class="col-md-6">
                            <div class="fl-group @error('email') is-invalid @enderror">
                              <input type="text" id="email" name="email" class="c_email" placeholder=" "
                                value="{{ $data['userAddress']['userEmail'] ?? old('email') }}">
                              <label for="email">อีเมล <span class="span-danger">*</span></label>
                            </div>
                            @error('email')<small class="invalid-feedback"><strong>{{ $message }}</strong></small>@enderror
                          </div>

                          {{-- address --}}
                          <div class="col-md-6">
                            <div class="fl-group @error('address') is-invalid @enderror">
                              <input type="text" id="address" name="address" placeholder=" "
                                value="{{ $data['userAddress']['userAddress'] ?? old('address') }}">
                              <label for="address">บ้านเลขที่ ถนน ซอย <span class="span-danger">*</span></label>
                            </div>
                            @error('address')<small class="invalid-feedback"><strong>{{ $message }}</strong></small>@enderror
                          </div>

                          {{-- province --}}
                          <div class="col-md-6">
                            <div class="fl-group @error('province') is-invalid @enderror">
                              <select id="province" name="province" onchange="amphuresAddress()">
                                <option value=""></option>
                                @foreach ($provinces as $province)
                                    <?php /* <option value="{{ $province->id }}" {{ old('province', $data['userAddress']['userProvince'] ?? null) == $province->id ? 'selected' : '' }}> */ ?>
                                    <option value="{{ $province->id }}">
                                      {{ $province->prov_name_th }}
                                    </option>
                                @endforeach
                              </select>
                              <label for="province">จังหวัด <span class="span-danger">*</span></label>
                            </div>
                            @error('province')<small class="invalid-feedback"><strong>{{ $message }}</strong></small>@enderror
                          </div>

                          {{-- amphures --}}
                          <div class="col-md-6">
                            <div class="fl-group @error('amphures') is-invalid @enderror">
                              <select id="amphures" name="amphures" onchange="districtAddress()">
                                <option value=""></option>
                              </select>
                              <label for="amphures">เขต / อำเภอ <span class="span-danger">*</span></label>
                            </div>
                            @error('amphures')<small class="invalid-feedback"><strong>{{ $message }}</strong></small>@enderror
                          </div>

                          {{-- district --}}
                          <div class="col-md-6">
                            <div class="fl-group @error('district') is-invalid @enderror">
                              <select id="district" name="district" onchange="zipcodeAddress()">
                                <option value=""></option>
                              </select>
                              <label for="district">แขวง / ตำบล <span class="span-danger">*</span></label>
                            </div>
                            @error('district')<small class="invalid-feedback"><strong>{{ $message }}</strong></small>@enderror
                          </div>

                          {{-- zipcode --}}
                          <div class="col-md-6">
                            <div class="fl-group @error('zipcode') is-invalid @enderror">
                              <input type="text" id="zipcode" name="zipcode" placeholder=" "
                                value="{{ $data['userAddress']['userZipcode'] ?? old('zipcode') }}">
                              <label for="zipcode">รหัสไปรษณีย์ <span class="span-danger">*</span></label>
                            </div>
                            @error('zipcode')<small class="invalid-feedback"><strong>{{ $message }}</strong></small>@enderror
                          </div>

                          {{-- message (เต็มความกว้าง) --}}
                          <div class="col-12">
                            <div class="fl-group @error('message') is-invalid @enderror">
                              <textarea id="message" name="message" placeholder=" " rows="3">{{ old('message') }}</textarea>
                              <label for="message">ข้อความถึงผู้ขาย (ตัวอย่าง: สนใจโปรแกรม Adobe Photoshop 10 license)</label>
                            </div>
                            @error('message')<small class="invalid-feedback"><strong>{{ $message }}</strong></small>@enderror
                          </div>

                        </div>

                        {{-- ---- จบฟิลด์เรียงใหม่ ---- --}}

                        @if(!empty($data['productDetail']))
                        <input type="hidden" id="productImg" name="productImg" value="{{ $data['productDetail']['image'] }}" />
                        <input type="hidden" id="productSku" name="productSku" value="{{ $data['productDetail']['sku'] }}" />
                        <input type="hidden" id="productVendorSku" name="productVendorSku" value="{{ $data['productDetail']['vendor_sku'] ?? '' }}" />
                        <input type="hidden" id="productName" name="productName" value="{{ $data['productDetail']['name'] }}" />
                        <input type="hidden" id="productDetail" name="productDetail" value="{{ $data['productDetail']['detail_name'] }}" />
                        <input type="hidden" id="productPrice" name="productPrice" value="{{ $data['productDetail']['detailPrice'] }}" />
                        <input type="hidden" id="productPricesale" name="productPricesale" value="{{ $data['productDetail']['detailPriceSale'] }}" />

                        <div class="col_full">
                            <div class="table-responsive">
                                <table class="table cart cart-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>รายละเอียดสินค้า</th>
                                            <th class="text-center" style="width:160px;">จำนวน</th>
                                            <th class="text-right">ราคา</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $unitPrice = !empty($data['productDetail']['detailPriceSale'])
                                                ? $data['productDetail']['detailPriceSale']
                                                : ($data['productDetail']['detailPrice'] ?? 0);
                                            $qty = (int)($data['productDetail']['unit'] ?? 1);
                                            $rowId = $data['productDetail']['id'];
                                        @endphp

                                        <tr class="cart-row" data-row-id="{{ $rowId }}">
                                            <td class="cart-cell" data-label="#">
                                                <img src="{{ $data['productDetail']['image'] }}" class="order-img-xs" />
                                            </td>

                                            <td class="cart-cell" data-label="รายละเอียดสินค้า">
                                                <small>SKU : {{ $data['productDetail']['sku'] }}</small>
                                                @if(!empty($data['productDetail']['detail_other']))
                                                    <br/>{{ $data['productDetail']['detail_name'] }}
                                                    <br/>{{ $data['productDetail']['detail_other'] }}
                                                @else
                                                    @if($data['productDetail']['name'] != $data['productDetail']['detail_name'])
                                                        <br/>{{ $data['productDetail']['name'] }}
                                                        <br/>{{ $data['productDetail']['detail_name'] }}
                                                    @else
                                                        <br/>{{ $data['productDetail']['name'] }}
                                                    @endif
                                                @endif
                                            </td>

                                            <td class="cart-cell text-center" data-label="จำนวน">
                                                <div class="quantity qty-inline qty-naked">
                                                    <button type="button" class="minus" data-id="{{ $rowId }}" aria-label="ลดจำนวน">−</button>
                                                    <input type="text"
                                                           id="quantity-{{ $rowId }}"
                                                           data-id="{{ $rowId }}"
                                                           name="productUnit"
                                                           class="qty"
                                                           value="{{ $qty }}"
                                                           min="1" step="1" inputmode="numeric" />
                                                    <button type="button" class="plus" data-id="{{ $rowId }}" aria-label="เพิ่มจำนวน">+</button>
                                                </div>
                                            </td>

                                            <td class="cart-cell text-right cart-product-price"
                                                data-label="ราคา"
                                                data-unit-price="{{ $unitPrice }}">
                                                @if (!empty($data['productDetail']['detailPriceSale']) && ($data['productDetail']['detailPriceSale'] < $data['productDetail']['detailPrice']))
                                                    <span class="amount-sale">{{ number_format($data['productDetail']['detailPrice']) }}</span>
                                                    {{ number_format($unitPrice, 2) }}
                                                @else
                                                    {{ number_format($unitPrice, 2) }}
                                                @endif
                                                <span class="currency">บาท</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="cart-summary">
                                <div class="summary-row">
                                    <div class="label">ยอดรวมทั้งหมด</div>
                                    <div class="value"><span id="grand-total">{{ number_format($unitPrice * $qty, 2) }}</span> <span class="currency">บาท</span></div>
                                </div>
                            </div>
                        </div>
                    @endif
                        @if(!empty($settingUser))
                            @if($settingUser->pdpa_status == 1)
                                <div class="col_full">
                                    <div class="pdpa-wb-quotation">
                                        <input type="checkbox"  id="pdpa_wording" name="pdpa_wording" value="1" class="checkbox-style" @if (!empty(old('pdpa_wording1'))) checked @endif>
                                        <label for="pdpa_wording" class="checkbox-style-3-label">{!! $settingUser->pdpa_detail !!}</label>
                                    </div>
                                </div>
                            @endif
                        @endif
                        <div class="col_full">
                            @if(!empty($extension))
                                @if($extension->ext_captcha_status == 1)
                                    <script src="https://www.google.com/recaptcha/api.js"></script>
                                    <button class="loadding btn btn-outline-quotation g-recaptcha" data-sitekey="{{$extension->ext_captcha}}" data-callback='onSubmit' data-action='submit'>
                                @else
                                    <button class="loadding btn btn-outline-quotation" >
                                @endif
                            @else
                                <button class="loadding btn btn-outline-quotation" >
                            @endif
                                <span class="btn-text">ส่งข้อมูลขอใบเสนอราคา</span>
                            </button>
                        </div>
                    </form>
                  </div>

                </div>
            </div>
            
            <!-- Overlay ขณะกำลังส่งฟอร์ม -->
            <div id="submit-overlay" hidden aria-live="polite" aria-busy="true">
              <div class="submit-box">
                <div class="h5" style="margin:0 0 6px;">
                  <span class="submit-spinner" aria-hidden="true"></span>
                  โปรดรอสักครู่...
                </div>
                <div class="lead">
                  ระบบกำลังดำเนินการออกใบเสนอราคาให้ท่าน<br>
                  กรุณาอย่าปิดหน้าต่างหรือกดซ้ำ
                </div>
              </div>
            </div>

        </div>
    </div>
</section>

@endsection

@section('js')
<script src="{{ asset('vendor/select2/select2.min.js') }}"></script>
<script src="{{ asset('vendor/select2-bootstrap4-theme/docs/script.js') }}"></script>
<script src="{{ asset('assets/fontend/js/custom_quotation.js?v=2') }}"></script>

<script>
/* =========================================================
 * 8Baht Quotation – Clean JS (single block)
 * =======================================================*/

/* 0) reCAPTCHA submit */
function onSubmit(){ document.getElementById('form-quotation').submit(); }

</script>

@endsection