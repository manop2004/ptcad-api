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
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Noto+Sans+Thai:wght@400;500;600;700;800&display=swap');

ul.small li {
    margin-left: 20px;
    font-size: 12px;
}

/* Modern Radio & Option Wrapper (mobile banking app picker) */
.wrapper {
    background: transparent;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: space-evenly;
    border-radius: 5px;
    gap: 10px;
    flex-wrap: wrap;
}
.wrapper .option {
    background: #fff;
    display: flex;
    align-items: center;
    justify-content: space-evenly;
    border-radius: 12px;
    cursor: pointer;
    padding: 15px 5px;
    border: 2px solid #e6edf8;
    transition: all 0.3s ease;
    width: 100%;
}
.wrapper .option .dot {
    height: 20px;
    width: 20px;
    background: #d9d9d9;
    border-radius: 50%;
    position: relative;
}
.wrapper .option .dot::before {
    position: absolute;
    content: "";
    top: 4px;
    left: 4px;
    width: 12px;
    height: 12px;
    background: #1765ff;
    border-radius: 50%;
    opacity: 0;
    transform: scale(1.5);
    transition: all 0.3s ease;
}
input[type="radio"] {
    display: none;
}

/* Checked States */
#option-1:checked ~ .option-1,
#option-2:checked ~ .option-2,
#option-3:checked ~ .option-3,
#option-4:checked ~ .option-4 {
    border-color: #1765ff;
    background: linear-gradient(135deg,#1765ff,#0d57df);
}
#option-1:checked ~ .option-1 .dot,
#option-2:checked ~ .option-2 .dot,
#option-3:checked ~ .option-3 .dot,
#option-4:checked ~ .option-4 .dot {
    background: #fff;
}
#option-1:checked ~ .option-1 .dot::before,
#option-2:checked ~ .option-2 .dot::before,
#option-3:checked ~ .option-3 .dot::before,
#option-4:checked ~ .option-4 .dot::before {
    opacity: 1;
    transform: scale(1);
}
.wrapper .option span {
    font-size: 14px;
    color: #808080;
}
#option-1:checked ~ .option-1 span,
#option-2:checked ~ .option-2 span,
#option-3:checked ~ .option-3 span,
#option-4:checked ~ .option-4 span {
    color: #fff;
}

/* Custom Helpers */
.span-danger { color: #ef4444; }
.co-red { color: #ef4444; }
.bg_eee { background-color: #f6f9ff; }

/* ==========================================================================
   PTCAD Checkout Theme
   ========================================================================== */
.pt-checkout{
  --navy:#12358f; --blue:#1765ff; --ink:#0b1f4d; --muted:#667085; --line:#e6edf8;
  --soft:#f6f9ff; --green:#20b26b; --red:#ef4444;
  font-family:'Poppins','Noto Sans Thai',system-ui,sans-serif;
  color:var(--ink);
}
.pt-checkout *{box-sizing:border-box}

.pt-checkout-title{
  text-align:center;
  font-size:clamp(24px,4vw,32px);
  color:var(--navy);
  font-weight:800;
  letter-spacing:-.5px;
  margin:6px 0 28px;
}

.pt-checkout-card{
  background:#fff;
  border:1px solid var(--line);
  border-radius:20px;
  padding:26px;
  box-shadow:0 12px 34px rgba(20,53,143,.05);
  margin-bottom:20px;
}

/* Field labels (plain text labels used throughout the form) */
.pt-field-label{
  display:block;
  font-weight:700;
  font-size:13.5px;
  color:#344054;
  margin-bottom:6px;
}

/* Tabs header */
.pt-checkout-card .tab-nav{
  list-style:none;margin:0 0 22px;padding:0 0 14px;
}
.pt-checkout-card .tab-nav li a,
#tab-9.tabs-bb .tab-nav li a,
#tab-9 .tab-nav > li > a{
  display:inline-flex;align-items:center;gap:8px;
  font-weight:800;font-size:16px;color:var(--navy) !important;
  padding-bottom:12px;
  border-bottom:2px solid var(--blue) !important;
  border-bottom-color:var(--blue) !important;
}

/* Inputs */
.pt-checkout .sm-form-control{
  border:1px solid var(--line) !important;
  border-radius:10px !important;
  margin-bottom:14px;
}
.pt-checkout textarea.sm-form-control{ min-height:90px; }
.pt-checkout small.invalid-feedback{ color:var(--red); display:block; margin-top:-10px; margin-bottom:10px; }
.pt-checkout small{ color:var(--muted); }

/* Tax receipt checkbox */
.pt-checkout .checkbox-style-3-label{
  font-weight:700;font-size:13.5px;color:#344054;
}
.pt-checkout .checkbox-style:checked + .checkbox-style-3-label:before{
  background:var(--blue) !important;
}
.pt-checkout .radio-style-2-label{
  font-weight:700;font-size:13.5px;color:#344054;
}

/* Order summary card */
.pt-summary-card{
  background:#fff;border:1px solid var(--line);border-radius:20px;padding:24px;
  box-shadow:0 12px 34px rgba(20,53,143,.05);margin-bottom:20px;
  position:sticky;top:100px;
}
.pt-summary-card h4{
  margin:0 0 16px;font-size:16px;font-weight:800;color:var(--navy);
  display:flex;align-items:center;gap:8px;
}
.pt-summary-card table{ width:100%; }
.pt-summary-card table td{
  border:none !important;padding:10px 0;font-size:13.5px;color:#344054;
  vertical-align:top;
}
.pt-summary-card tr:not(:last-child) td{ border-bottom:1px dashed var(--line) !important; }
.pt-summary-card tr:last-child td{
  background:var(--soft) !important;border-radius:12px;
  font-size:16px;font-weight:800;color:var(--navy);
  padding:14px 12px;
}
.pt-summary-card tr:last-child td .amount,
.pt-summary-card tr:last-child td .amount.color,
.pt-summary-card tr:last-child td .amount.lead,
.pt-summary-card tr:last-child td .color,
.pt-summary-card tr:last-child td .lead{
  color:var(--blue) !important;
  font-size:18px;
}
.pt-summary-card .co-f1c40f{ color:#f59e0b !important; }

/* Payment method options */
.pt-pay-card{
  background:#fff;border:1px solid var(--line);border-radius:20px;padding:22px;
  box-shadow:0 12px 34px rgba(20,53,143,.05);
}
.pt-pay-card > h4{
  margin:0 0 16px;font-size:16px;font-weight:800;color:var(--navy);
  display:flex;align-items:center;gap:8px;
}
.pt-pay-option{
  border:1px solid var(--line);border-radius:14px;padding:16px;margin-bottom:12px;
  transition:border-color .2s ease;
}
.pt-pay-option:hover{ border-color:#c7d7fb; }
.pt-pay-body{ margin-top:12px;padding-top:12px;border-top:1px dashed var(--line); }
.pt-pay-body .bottommargin-sm{ font-size:13px;color:var(--muted);line-height:1.7;margin-bottom:14px; }

/* Unified pay buttons — ทุกวิธีชำระเงินใช้สีเดียวกันหมด (น้ำเงิน-ฟ้า) ไม่แยกสีตามวิธี */
.pt-pay-body .button{
  height:48px !important;border-radius:12px !important;border:none !important;
  font-weight:800 !important;font-size:14.5px !important;
  display:flex;align-items:center;justify-content:center;gap:8px;
  box-shadow:0 10px 20px rgba(23,101,255,.22) !important;
  background:linear-gradient(135deg,#1765ff,#0d57df) !important;
  color:#fff !important;
}
.pt-pay-body .button-green,
.pt-pay-body .button-blue,
.pt-pay-body .button-aqua,
.pt-pay-body .button-pink,
.pt-pay-body .button-amber{
  background:linear-gradient(135deg,#1765ff,#0d57df) !important;
  color:#fff !important;
}

.pt-pay-body .payment-2c2p-card label{
  font-size:12.5px;font-weight:700;color:#344054;margin-bottom:4px;display:block;
}

@media (max-width:991px){
  .pt-summary-card{ position:relative; top:0; }
}
</style>
@endsection

@section('content')
<section id="content">
    <div class="content-wrap">
        <div class="container pt-checkout">

            {{-- Breadcrumb Section --}}
            @if (!empty($breadcrumb))
            <section id="page-title" class="page-title-mini page-title-right">
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

            {{-- Main Form Section --}}
            @if (!empty($data))
                <br/>
                <div class="pt-checkout-title">ชำระเงิน</div>

                {{ Form::open([
                    'novalidate',
                    'route' => ['fronend.cart.confirm.update', $data->id],
                    'id' => 'paymentForm',
                    'method' => 'put',
                    'files' => true
                ]) }}

                    <div class="row">
                        {{-- Left Column: Form Details --}}
                        <div class="col-md-7">

                            {{-- Global Error Alerts --}}
                            <div class="col_full bottommargin-xs">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="small">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>

                            <div class="pt-checkout-card">

                                {{-- Shipping Address Tab Section --}}
                                <div class="col_full">
                                    <div class="tabs tabs-bb tabs-cart-confirm clearfix" id="tab-9">
                                        <ul class="tab-nav clearfix">
                                            <li id="cart-tabs-residence"><a href="#tabs-residence"><i data-lucide="truck" size="16"></i> ที่อยู่สำหรับจัดส่งสินค้า</a></li>
                                        </ul>
                                        <div class="tab-container">
                                            <div class="tab-content clearfix" id="tabs-residence">

                                                <div class="col_full bottommargin-xs">
                                                    <span class="pt-field-label">ชื่อ - สกุล <span class="span-danger">*</span></span>
                                                </div>
                                                <div class="col_half">
                                                    <input type="text" placeholder="ชื่อ" id="residence_name" name="residence_name" class="sm-form-control @error('residence_name') invalid @enderror" value="{{ old('residence_name', $data->residence_name ?? '') }}">
                                                    @error('residence_name')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                                </div>
                                                <div class="col_half col_last">
                                                    <input type="text" placeholder="นามสกุล" id="residence_lastname" name="residence_lastname" class="sm-form-control @error('residence_lastname') invalid @enderror" value="{{ old('residence_lastname', $data->residence_lastname ?? '') }}">
                                                    @error('residence_lastname')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                                </div>

                                                <div class="col_full">
                                                    <span class="pt-field-label">เบอร์โทรศัพท์ <span class="span-danger">*</span></span>
                                                    <input type="text" placeholder="เบอร์โทรศัพท์" id="residence_tel" name="residence_tel" class="sm-form-control @error('residence_tel') invalid @enderror" value="{{ old('residence_tel', $data->residence_tel ?? '') }}">
                                                    @error('residence_tel')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                                </div>

                                                <div class="col_full">
                                                    <span class="pt-field-label">บ้านเลขที่ ถนน ซอย <span class="span-danger">*</span></span>
                                                    <textarea placeholder="บ้านเลขที่ ถนน ซอย" id="residence_address" name="residence_address" class="sm-form-control @error('residence_address') invalid @enderror">{{ old('residence_address', $data->residence_address ?? '') }}</textarea>
                                                    @error('residence_address')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                                </div>

                                                <div class="col_half">
                                                    <span class="pt-field-label">จังหวัด <span class="span-danger">*</span></span>
                                                    <select id="province" name="province" data-placeholder="กรุณาเลือกจังหวัด" class="sm-form-control @error('province') invalid @enderror" onchange="amphuresAddress()">
                                                        <option></option>
                                                        @foreach ($provinces as $province)
                                                            <option value="{{ $province->id }}" @if(!empty($data->residence_province) && $province->id == $data->residence_province) selected @endif>{{ $province->prov_name_th }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('province')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                                    <input id="address_province" name="address_province" type="hidden" value="{{ $data->residence_province ?? '' }}">
                                                </div>

                                                <div class="col_half col_last">
                                                    <span class="pt-field-label">เขต/อำเภอ <span class="span-danger">*</span></span>
                                                    <select id="amphures" name="amphures" data-placeholder="กรุณาเลือกเขต/อำเภอ" class="sm-form-control @error('amphures') invalid @enderror" onchange="districtAddress()">
                                                        <option></option>
                                                    </select>
                                                    @error('amphures')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                                    <input id="address_amphures" name="address_amphures" type="hidden" value="{{ $data->residence_amphures ?? '' }}">
                                                </div>

                                                <div class="col_half">
                                                    <span class="pt-field-label">แขวง/ตำบล <span class="span-danger">*</span></span>
                                                    <select id="district" name="district" data-placeholder="กรุณาเลือกแขวง / ตำบล" class="sm-form-control @error('district') invalid @enderror" onchange="zipcodeAddress()">
                                                        <option></option>
                                                    </select>
                                                    @error('district')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                                    <input id="address_district" name="address_district" type="hidden" value="{{ $data->residence_district ?? '' }}">
                                                </div>

                                                <div class="col_half col_last">
                                                    <span class="pt-field-label">รหัสไปรษณีย์ <span class="span-danger">*</span></span>
                                                    <input id="zipcode" name="zipcode" placeholder="กรุณากรอกรหัสไปรษณีย์" class="sm-form-control @error('zipcode') invalid @enderror" value="" />
                                                    @error('zipcode')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                                    <input id="address_zipcode" name="address_zipcode" type="hidden" value="{{ $data->residence_zipcode ?? '' }}">
                                                </div>

                                                <div class="col_full">
                                                    <span class="pt-field-label">ข้อความถึงผู้ขาย <span class="span-danger">*</span></span>
                                                    <textarea rows="5" placeholder="ข้อความถึงผู้ขาย" id="residence_massage" name="residence_massage" class="sm-form-control">{{ old('residence_massage', $data->residence_massage ?? '') }}</textarea>
                                                    <small>*ลูกค้าที่ต่ออายุ สามารถระบุ Serial number และ วันหมดอายุ ได้ที่ "ข้อความถึงผู้ขาย"</small>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Tax Receipt Checkbox Option --}}
                                <div class="col_full bottommargin-xs">
                                    <div>
                                        <input id="chkReceipt" class="checkbox-style" name="chkReceipt" type="checkbox" @if(old('chkReceipt') == 'on') checked @endif>
                                        <label for="chkReceipt" class="checkbox-style-3-label">ต้องการใบกำกับภาษีเต็มรูปแบบหรือไม่?</label>
                                    </div>
                                    <small class="co-red">* หากต้องการใบกำกับภาษีเต็มรูปแบบกรุณากรอกที่อยู่สำหรับจัดส่งใบเสร็จรับเงิน</small>
                                </div>

                                {{-- Tax Receipt Section --}}
                                <div class="col_full" id="cart-tabs-receipts" @if(old('chkReceipt') == 'on') style="display:block;" @else style="display:none;" @endif>
                                    <div class="col_full">
                                        <div class="inline">
                                            <input id="receipt_persona_type_1" class="radio-style" name="receipt_persona_type" type="radio" value="1" @if(($data->receipt_type ?? 1) == 1) checked @endif>
                                            <label for="receipt_persona_type_1" class="radio-style-2-label">บุคคลธรรมดา</label>
                                        </div>
                                        <div class="inline">
                                            <input id="receipt_persona_type_2" class="radio-style" name="receipt_persona_type" type="radio" value="2" @if(($data->receipt_type ?? 0) == 2) checked @endif>
                                            <label for="receipt_persona_type_2" class="radio-style-2-label">บริษัท/สำนักงาน/องค์กร</label>
                                        </div>
                                    </div>

                                    <div class="col_full">
                                        <span class="pt-field-label">เลขประจำตัวผู้เสียภาษี <span class="span-danger">*</span></span>
                                        <input type="text" placeholder="เลขประจำตัวผู้เสียภาษี" id="receipt_tax" name="receipt_tax" class="sm-form-control @error('receipt_tax') invalid @enderror" value="{{ old('receipt_tax', $data->receipt_tax ?? '') }}">
                                        @error('receipt_tax')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                    </div>

                                    <div class="col_half">
                                        <span class="pt-field-label">ชื่อบริษัท</span>
                                        <input type="text" placeholder="ชื่อบริษัท" id="receipt_company" name="receipt_company" class="sm-form-control @error('receipt_company') invalid @enderror" value="{{ old('receipt_company', $data->receipt_company ?? '') }}">
                                        @error('receipt_company')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                    </div>

                                    <div class="col_half col_last">
                                        <span class="pt-field-label">สาขา (ถ้ามี)</span>
                                        <input type="text" placeholder="สาขา (ถ้ามี)" id="receipt_branch" name="receipt_branch" class="sm-form-control" value="{{ old('receipt_branch', $data->receipt_branch ?? '') }}">
                                    </div>

                                    <div class="col_full bottommargin-xs">
                                        <span class="pt-field-label">ชื่อ - สกุล <span class="span-danger">*</span></span>
                                    </div>

                                    <div class="col_half">
                                        <input type="text" placeholder="ชื่อ" id="receipt_name" name="receipt_name" class="sm-form-control @error('receipt_name') invalid @enderror" value="{{ old('receipt_name', $data->receipt_name ?? '') }}">
                                        @error('receipt_name')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                    </div>

                                    <div class="col_half col_last">
                                        <input type="text" placeholder="นามสกุล" id="receipt_lastname" name="receipt_lastname" class="sm-form-control @error('receipt_lastname') invalid @enderror" value="{{ old('receipt_lastname', $data->receipt_lastname ?? '') }}">
                                        @error('receipt_lastname')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                    </div>

                                    <div class="col_full">
                                        <span class="pt-field-label">เบอร์โทรศัพท์ <span class="span-danger">*</span></span>
                                        <input type="text" placeholder="เบอร์โทรศัพท์" id="receipt_tel" name="receipt_tel" class="sm-form-control @error('receipt_tel') invalid @enderror" value="{{ old('receipt_tel', $data->receipt_tel ?? '') }}">
                                        @error('receipt_tel')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                    </div>

                                    <div class="col_full">
                                        <span class="pt-field-label">บ้านเลขที่ ถนน ซอย <span class="span-danger">*</span></span>
                                        <textarea placeholder="บ้านเลขที่ ถนน ซอย" id="receipt_address" name="receipt_address" class="sm-form-control @error('receipt_address') invalid @enderror">{{ old('receipt_address', $data->receipt_address ?? '') }}</textarea>
                                        @error('receipt_address')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                    </div>

                                    <div class="col_half">
                                        <span class="pt-field-label">จังหวัด <span class="span-danger">*</span></span>
                                        <select id="receipt_province" name="receipt_province" data-placeholder="กรุณาเลือกจังหวัด" class="sm-form-control @error('receipt_province') invalid @enderror" onchange="amphuresReceipt()">
                                            <option></option>
                                            @foreach ($provinces as $province)
                                                <option value="{{ $province->id }}" @if(!empty($data->receipt_province) && $data->receipt_province == $province->id) selected @endif>{{ $province->prov_name_th }}</option>
                                            @endforeach
                                        </select>
                                        @error('receipt_province')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                        <input id="receipt_hd_province" name="receipt_hd_province" type="hidden" value="{{ $data->receipt_province ?? '' }}">
                                    </div>

                                    <div class="col_half col_last">
                                        <span class="pt-field-label">เขต/อำเภอ <span class="span-danger">*</span></span>
                                        <select id="receipt_amphures" name="receipt_amphures" data-placeholder="กรุณาเลือกเขต/อำเภอ" class="sm-form-control @error('receipt_amphures') invalid @enderror" onchange="districtReceipt()">
                                            <option></option>
                                        </select>
                                        @error('receipt_amphures')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                        <input id="receipt_hd_amphures" name="receipt_hd_amphures" type="hidden" value="{{ $data->receipt_amphures ?? '' }}">
                                    </div>

                                    <div class="col_half">
                                        <span class="pt-field-label">แขวง/ตำบล <span class="span-danger">*</span></span>
                                        <select id="receipt_district" name="receipt_district" data-placeholder="กรุณาเลือกแขวง / ตำบล" class="sm-form-control @error('receipt_district') invalid @enderror" onchange="zipcodeReceipt()">
                                            <option></option>
                                        </select>
                                        @error('receipt_district')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                        <input id="receipt_hd_district" name="receipt_hd_district" type="hidden" value="{{ $data->receipt_district ?? '' }}">
                                    </div>

                                    <div class="col_half col_last">
                                        <span class="pt-field-label">รหัสไปรษณีย์ <span class="span-danger">*</span></span>
                                        <input id="receipt_zipcode" name="receipt_zipcode" placeholder="กรุณากรอกรหัสไปรษณีย์" class="sm-form-control @error('receipt_zipcode') invalid @enderror" value="" />
                                        @error('receipt_zipcode')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                        <input id="receipt_hd_zipcode" name="receipt_hd_zipcode" type="hidden" value="{{ $data->receipt_zipcode ?? '' }}">
                                    </div>
                                </div>

                            </div>
                        </div>

                        {{-- Right Column: Cart Summary & Payment Method --}}
                        <div class="col-md-5">
                            <div class="pt-summary-card">
                                <div id="b_checkout">
                                    <h4><i data-lucide="receipt" size="16"></i> ยอดรวม</h4>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                                @foreach ($data->tb_order_details as $product)
                                                    <tr>
                                                        <td>
                                                            @if ($product->product_name != 'null')
                                                                {{ $product->product_name }}
                                                                @if ($product->product_detail != 'null') <br/> {{ $product->product_detail }} @endif
                                                            @else
                                                                {{ $product->product_name }}
                                                            @endif
                                                        </td>
                                                        <td class="text-right">
                                                            @if($product->product_price_sale != 0)
                                                                <span class="amount-sale" style="text-decoration: line-through;">{{ number_format($product->product_price) }}</span> {{ number_format($product->product_price_sale, 2) }}
                                                            @else
                                                                <span class="amount">{{ number_format($product->product_price, 2) }}</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach

                                                {{-- Discount --}}
                                                @if(!empty($data->conditionName))
                                                    <tr class="cart_item">
                                                        <td class="cart-product-name co-f1c40f">
                                                            <strong>ส่วนลดรวม <br/><small>{{ $data->conditionName }}</small></strong>
                                                        </td>
                                                        <td class="cart-total-name co-f1c40f text-right">
                                                            @if ($data->conditionType == 1)
                                                                <span class="amount-condition">{{ number_format($data->conditionValue, 2) }}.-</span>
                                                            @else
                                                                <span class="amount-condition">{{ $data->conditionValue }}%</span>
                                                            @endif
                                                            <input type="hidden" name="conditionType" id="conditionType" value="{{ $data->conditionType }}" />
                                                            <input type="hidden" name="conditionName" id="conditionName" value="{{ $data->conditionName }}" />
                                                            <input type="hidden" name="conditionValue" id="conditionValue" value="{{ $data->conditionValue }}" />
                                                        </td>
                                                    </tr>
                                                @endif

                                                {{-- Net Total Discount --}}
                                                @if(!empty($data->totaldiscount) && (!empty($data->conditionValue) || $data->priceVAT != 0))
                                                    <tr class="cart_item">
                                                        <td class="cart-product-name"><strong>ราคาสุทธิสินค้า</strong></td>
                                                        <td class="cart-total-name text-right">
                                                            <span id="sumTotal_n" class="amount">{{ number_format($data->totaldiscount, 2) }}.-</span>
                                                            <input type="hidden" name="totaldiscount" id="totaldiscount" value="{{ $data->totaldiscount }}" />
                                                        </td>
                                                    </tr>
                                                @endif

                                                {{-- VAT --}}
                                                @if(!empty($data->priceVAT) && $data->priceVAT != 0)
                                                    <tr class="cart_item" id="tdcartVat">
                                                        <td class="cart-product-name"><strong>ภาษีมูลค่าเพิ่ม</strong></td>
                                                        <td class="cart-total-name text-right">
                                                            <span id="cartVat" class="amount">{{ number_format($data->priceVAT, 2) }}.-</span>
                                                            <input type="hidden" name="priceVAT" id="priceVAT" value="{{ $data->priceVAT }}" />
                                                        </td>
                                                    </tr>
                                                @endif

                                                {{-- Price Net Total --}}
                                                @if(!empty($data->priceNettotal))
                                                    <tr class="cart_item" id="cartNettotal">
                                                        <td class="cart-product-name"><strong>ยอดรวมสุทธิ</strong></td>
                                                        <td class="cart-total-name text-right">
                                                            <span id="cartNettotal" class="amount">{{ number_format($data->priceNettotal, 2) }}.-</span>
                                                            <input type="hidden" name="priceNettotal" id="priceNettotal" value="{{ $data->priceNettotal }}" />
                                                        </td>
                                                    </tr>
                                                @endif

                                                {{-- Withholding Tax --}}
                                                @if(!empty($data->priceWithholding))
                                                    <tr class="cart_item">
                                                        <td class="cart-product-name"><strong>หัก ภาษี ณ ที่จ่าย</strong></td>
                                                        <td class="cart-total-name text-right">
                                                            <span id="cartWithholding" class="amount">{{ number_format($data->priceWithholding, 2) }}.-</span>
                                                            <input type="hidden" name="priceWithholding" id="priceWithholding" value="{{ $data->priceWithholding }}" />
                                                        </td>
                                                    </tr>
                                                @endif

                                                {{-- Shipping --}}
                                                <tr class="cart_item">
                                                    <td class="cart-product-name"><strong>การจัดส่ง</strong></td>
                                                    <td class="cart-total-name text-right"><span class="amount">จัดส่งฟรี</span></td>
                                                </tr>

                                                {{-- Final Total --}}
                                                <tr class="cart_item">
                                                    <td class="cart-product-name bg_eee"><strong>จำนวนเงินที่ต้องชำระ</strong></td>
                                                    <td class="cart-total-name bg_eee text-right">
                                                        <span id="totalCart" class="amount color lead"><strong>{{ number_format($data->totalCart, 2) }}.-</strong></span>
                                                        <input type="hidden" name="totalCart" id="totalCart" value="{{ $data->totalCart }}" />
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            {{-- Payment Gateway Options --}}
                            @if (!empty($settingPayment))
                                <div class="pt-pay-card">
                                    <h4><i data-lucide="credit-card" size="16"></i> เลือกวิธีชำระเงิน</h4>

                                    @if($settingPayment->bank_transfer_status == 1)
                                        <div class="pt-pay-option">
                                            <div>
                                                <input id="radio-bank" class="radio-style" name="radio_payment_type" value="1" type="radio" checked>
                                                <label for="radio-bank" class="radio-style-2-label">โอนผ่านบัญชีธนาคาร</label>
                                            </div>
                                            <div id="content-bank" class="pt-pay-body">
                                                <div class="bottommargin-sm">
                                                    ชำระเงินโดยโอนเงินเข้าบัญชีธนาคาร (เลขที่บัญชีธนาคารจะแสดงหลังจากกดปุ่ม “ชำระเงิน”) โดยหลังการชำระเงิน กรุณาส่งหลักฐานการยืนยันพร้อมเลขที่ใบสั่งซื้อ เพื่อทางเราจะได้ดำเนินการตรวจสอบต่อไป
                                                </div>
                                                <button id="btn_bank" type="submit" class="loading button button-green btn-block btn-bank nomargin">
                                                    <i class="icon-money"></i> “ชำระเงิน”
                                                </button>
                                            </div>
                                        </div>
                                    @endif

                                    @if($settingPayment->promtpay_status == 1)
                                        <div class="pt-pay-option">
                                            <div>
                                                <input id="radio-promptpay" class="radio-style" name="radio_payment_type" value="4" type="radio">
                                                <label for="radio-promptpay" class="radio-style-2-label">พร้อมเพย์</label>
                                            </div>
                                            <div id="content-promptpay" class="pt-pay-body">
                                                <div class="bottommargin-sm">แสกนจ่ายผ่านคิวอาร์โค้ด (QR Code) รองรับทุกธนาคาร เมื่อชำระสำเร็จ รายการคำสั่งซื้อจะได้รับการอนุมัติทันที</div>
                                                <button id="btn_promptpay" type="submit" class="button button-blue btn-block btn-promptpay nomargin">
    <i class="icon-qrcode"></i> ชำระเงิน
</button>
                                            </div>
                                        </div>
                                    @endif

                                    @if($settingPayment->mobile_banking_status == 1)
    <div class="pt-pay-option" style="display:none !important">
                                            <div>
                                                <input id="radio-mobile_banking" class="radio-style" name="radio_payment_type" value="5" type="radio">
                                                <label for="radio-mobile_banking" class="radio-style-2-label">โมบายแบงก์กิ้ง</label>
                                            </div>
                                            <div id="content-mobile_banking" class="pt-pay-body">
                                                <div class="bottommargin-sm">
                                                    เลือกแอพพลิแคชั่นธนาคารสำหรับการชำระเงิน
                                                    <br>
                                                    <br>

                                                    <div class="wrapper">
                                                        <input type="radio" name="radio_mobile_banking_name" id="option-1" value="mobile_banking_kbank">
                                                        <input type="radio" name="radio_mobile_banking_name" id="option-2" value="mobile_banking_scb">
                                                        <input type="radio" name="radio_mobile_banking_name" id="option-3" value="mobile_banking_bay">
                                                        <input type="radio" name="radio_mobile_banking_name" id="option-4" value="mobile_banking_bbl">
                                                        <label for="option-1" class="option option-1 col-xs-6 col-md-3 col-form-label">
                                                            <center>
                                                                <img src="../../storage/mobile_banking/mkplus.webp" alt="Kasikorn Bank">
                                                                <br>
                                                                <span>K PLUS</span>
                                                            </center>
                                                        </label>
                                                        <label for="option-2" class="option option-2 col-xs-6 col-md-3 col-form-label">
                                                            <center>
                                                                <img src="../../storage/mobile_banking/mscb.webp" alt="Siam Commercial Bank">
                                                                <br>
                                                                <span>SCB EASY</span>
                                                            </center>
                                                        </label>
                                                        <label for="option-3" class="option option-3 col-xs-6 col-md-3 col-form-label">
                                                            <center>
                                                                <img src="../../storage/mobile_banking/mbay.webp" alt="Bank of Ayudhya (Krungsri)">
                                                                <br>
                                                                <span>KMA</span>
                                                            </center>
                                                        </label>
                                                        <label for="option-4" class="option option-4 col-xs-6 col-md-3 col-form-label">
                                                            <center>
                                                                <img src="../../storage/mobile_banking/mbbl.webp" alt="Bangkok Bank">
                                                                <br>
                                                                <span>Bualuang</span>
                                                            </center>
                                                        </label>
                                                    </div>
                                                    <div id="mb_errors" class="alert"></div>
                                                </div>
                                                <button id="btn_mobile_banking" class="button button-aqua btn-block btn-mobile_banking nomargin" onClick="return MB_CheckOut();">
                                                    ชำระเงิน
                                                </button>
                                            </div>
                                        </div>
                                    @endif

                                    @if($settingPayment->installment_status == 1)
    <div class="pt-pay-option" style="display:none !important">
                                            <div>
                                                <input id="radio-installment" class="radio-style" name="radio_payment_type" value="2" type="radio">
                                                <label for="radio-installment" class="radio-style-2-label">ผ่อนชำระ</label>
                                            </div>
                                            <div id="content-installment" class="pt-pay-body">
                                                <div class="bottommargin-sm">
                                                    เงื่อนไขการผ่อนชำระ:
                                                    <ul>
                                                        <li>ยอดชำระขั้นต่ำต้องไม่น้อยกว่า 3,000 บาท</li>
                                                        <li>ยอดชำระสูงสุดที่ผ่อนได้ต้องไม่เกิน 150,000 บาท</li>
                                                        <li>ลูกค้ารับภาระดอกเบี้ยในการผ่อนชำระ</li>
                                                    </ul>
                                                </div>
                                                <button id="btn_installment" class="button button-pink btn-block btn-installment nomargin">
                                                    เลือกธนาคารสำหรับผ่อนชำระ
                                                </button>
                                            </div>
                                        </div>
                                    @endif
                                    @if($settingPayment->credit_card_status == 1)
                                        <div class="pt-pay-option">
                                            <div>
                                                <input id="radio-creditcard" class="radio-style" name="radio_payment_type" value="3" type="radio">
                                                <label for="radio-creditcard" class="radio-style-2-label">บัตรเครดิต</label>
                                            </div>
                                            <div id="content-creditcard" class="pt-pay-body">
                                                <div class="bottommargin-sm">กรอกข้อมูลบัตรอย่างปลอดภัยในขั้นตอนถัดไป รองรับ Visa, Mastercard, JCB</div>
                                                <button id="btn_creditcard" type="submit" class="button button-green btn-block btn-bank nomargin">
                                                    <i class="icon-save"></i> ยืนยันการสั่งซื้อ
                                                </button>
                                            </div>
                                        </div>
                                    @endif

                                    @if($settingPayment->truemoney_status == 1)
    <div class="pt-pay-option" style="display:none !important">
                                            <div>
                                                <input id="radio-truemoney" class="radio-style" name="radio_payment_type" value="6" type="radio">
                                                <label for="radio-truemoney" class="radio-style-2-label">ทรูมันนี่ วอลเล็ท</label>
                                            </div>
                                            <div id="content-truemoney" class="pt-pay-body">
                                                <div class="bottommargin-sm">
                                                    ชำระเงินผ่าน TrueMoney Wallet
                                                </div>
                                                <button id="btn_truemoney" class="button button-amber btn-block btn-truemoney nomargin">
                                                    ชำระเงิน
                                                </button>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>

                    <script>
                        function MB_CheckOut(){

                            // required
                            var payment_type = $('input[name="radio_mobile_banking_name"]:checked').val();
                            if(payment_type == '' || payment_type == null || payment_type === undefined){
                                $("#mb_errors").addClass('alert-danger').html('กรุณาเลือกแอพธนาคารเพื่อชำระเงิน');
                                return false;
                            }

                            var os = getMobileOperatingSystem();
                            if(os != 'ANDROID' && os != 'IOS'){
                                $("#mb_errors").addClass('alert-danger').html('สำหรับการใช้งานบน Android และ ios เท่านั้น กรุณาเลือกช่องทางการชำระเงินประเภทอื่น');
                                return false;
                            }

                            Omise.setPublicKey("@if($settingPayment->omise_status == 3){{ $settingPayment->omise_public_key_for_test }}@else{{$settingPayment->omise_public_key_for_live}}@endif");

                            Omise.createSource(payment_type, {
                              "amount": "{{ round($data->totalCart,2)*100 }}",
                              "currency": "THB",
                              "platform_type": os
                            }, function(statusCode, response) {
                              if (response.object == "error") {
                                  $("#mb_errors").html(response.message);
                                  $("#btn_mobile_banking").prop("disabled", false);
                              }else{
                                  $("#omiseSource").val(response.id);
                                  $("#btn_mobile_banking").prop("disabled", true);

                                  $("#paymentForm").submit();
                              }
                            });

                            return false;
                        }

                        function getMobileOperatingSystem(){
                            var userAgent = navigator.userAgent || navigator.vendor || window.opera;
                            if (/windows phone/i.test(userAgent)) {
                                return "WINDOWS PHONE";
                            }
                            if (/android/i.test(userAgent)) {
                                return "ANDROID";
                            }
                            if (/iPad|iPhone|iPod/.test(userAgent) && !window.MSStream) {
                                return "IOS";
                            }
                            return "unknown";
                        }
                    </script>
                {{ Form::close() }}
            @else
                <div class="topmargin-lg bottommargin-lg text-center">
                    <h2>ไม่มีสินค้าในตะกร้า</h2>
                </div>
            @endif

        </div>
    </div>
</section>
@endsection
@section('js')
 <script src="{{ asset('vendor/select2/select2.min.js') }}"></script>
 <script src="{{ asset('vendor/select2-bootstrap4-theme/docs/script.js') }}"></script>
 @endsection