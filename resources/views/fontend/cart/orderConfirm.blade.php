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
<link rel="stylesheet" href="{{ asset('assets/fontend/css/components/radio-checkbox.css') }}?v=2" type="text/css" />
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Noto+Sans+Thai:wght@400;500;600;700;800&display=swap');

.pt-checkout-wrap{
  font-family:'Poppins','Noto Sans Thai',system-ui,sans-serif;
  color:#0b1f4d;
}
.pt-checkout-wrap h1{
  font-size:32px !important;color:#12358f !important;font-weight:800 !important;letter-spacing:-.6px;
}
.pt-checkout-wrap .col_full,
.pt-checkout-wrap .col_half{
  margin-bottom:14px !important;
}
.pt-checkout-wrap .sm-form-control{
  border:1px solid #e6edf8 !important;border-radius:10px !important;
}
.pt-checkout-wrap .tabs-cart-confirm{
  background:#fff;border:1px solid #e6edf8;border-radius:22px;padding:26px;box-shadow:0 12px 34px rgba(20,53,143,.06);margin-bottom:20px;
}
/* underline color fix: green -> blue (same as repeat.blade.php) */
.pt-checkout-wrap .tabs-cart-confirm .tab-nav li a,
.pt-checkout-wrap #tab-9.tabs-bb .tab-nav li a,
.pt-checkout-wrap #tab-9 .tab-nav > li > a{
  color:#1765ff !important;
  font-weight:800 !important;
  border-bottom:2px solid #1765ff !important;
  border-bottom-color:#1765ff !important;
}
.pt-checkout-wrap .span-danger{color:#ef4444 !important}

.pt-checkout-wrap .wrapper .option{
  border-radius:14px !important;border-color:#e6edf8 !important;
}
.pt-checkout-wrap #option-1:checked ~ .option-1,
.pt-checkout-wrap #option-2:checked ~ .option-2,
.pt-checkout-wrap #option-3:checked ~ .option-3,
.pt-checkout-wrap #option-4:checked ~ .option-4{
  border-color:#1765ff !important;background:#1765ff !important;
}
.pt-checkout-wrap .dot::before{background:#1765ff !important}

.pt-checkout-wrap span#totalCart,
.pt-checkout-wrap .amount.color.lead{
  color:#1765ff !important;font-weight:800 !important;
}
.pt-checkout-wrap button.button-green{
  background:linear-gradient(135deg,#1765ff,#0d57df) !important;
  border-color:#1765ff !important;
  border-radius:12px !important;
  font-weight:800 !important;
}
.pt-checkout-wrap .alert-danger{
  border-radius:12px !important;
}

/* ===================================================================
   PTCAD PATCH — unify style of all "Pay" buttons across payment methods
   =================================================================== */
.pt-checkout-wrap button.button-blue,
.pt-checkout-wrap button.button-aqua,
.pt-checkout-wrap button.button-pink,
.pt-checkout-wrap button.button-amber{
  background:linear-gradient(135deg,#1765ff,#0d57df) !important;
  border-color:#1765ff !important;
  border-radius:12px !important;
  font-weight:800 !important;
  color:#fff !important;
}
.pt-checkout-wrap button.button-green:hover,
.pt-checkout-wrap button.button-blue:hover,
.pt-checkout-wrap button.button-aqua:hover,
.pt-checkout-wrap button.button-pink:hover,
.pt-checkout-wrap button.button-amber:hover{
  filter:brightness(1.08) !important;
  color:#fff !important;
}
</style>
<style>
ul.small li{
    margin-left: 20px;
    font-size: 12px;
}
.wrapper{
	background: transparent;
	width: 100%;
	align-items: center;
	justify-content: space-evenly;
	border-radius: 5px;
}
.wrapper .option{
	background: #fff;
	display: flex;
	align-items: center;
	justify-content: space-evenly;
	border-radius: 5px;
	cursor: pointer;
	padding: 15px 5px;
	border: 2px solid lightgrey;
	transition: all 0.3s ease;
}
.wrapper .option .dot{
	height: 20px;
	width: 20px;
	background: #d9d9d9;
	border-radius: 50%;
	position: relative;
}
.wrapper .option .dot::before{
	position: absolute;
	content: "";
	top: 4px;
	left: 4px;
	width: 12px;
	height: 12px;
	background: #0069d9;
	border-radius: 50%;
	opacity: 0;
	transform: scale(1.5);
	transition: all 0.3s ease;
}
input[type="radio"]{
	display: none;
}
#option-1:checked:checked ~ .option-1,
#option-2:checked:checked ~ .option-2,
#option-3:checked:checked ~ .option-3,
#option-4:checked:checked ~ .option-4{
	border-color: #0069d9;
	background: #0069d9;
}
#option-1:checked:checked ~ .option-1 .dot,
#option-2:checked:checked ~ .option-2 .dot,
#option-3:checked:checked ~ .option-3 .dot,
#option-4:checked:checked ~ .option-4 .dot{
	background: #fff;
}
#option-1:checked:checked ~ .option-1 .dot::before,
#option-2:checked:checked ~ .option-2 .dot::before,
#option-3:checked:checked ~ .option-3 .dot::before,
#option-4:checked:checked ~ .option-4 .dot::before{
	opacity: 1;
	transform: scale(1);
}
.wrapper .option span{
	font-size: 14px;
	color: #808080;
}
#option-1:checked:checked ~ .option-1 span,
#option-2:checked:checked ~ .option-2 span,
#option-3:checked:checked ~ .option-3 span,
#option-4:checked:checked ~ .option-4 span{
	color: #fff;
}
*, ::after, ::before {
	box-sizing: border-box;
}
.boxmenu-padding1
,.boxmenu-padding2
,.boxmenu-padding3
,.input-search-frame
,.btn-login{
	padding: 20px;
}
</style>
@endsection

@section('content')
<section id="content">
    <div class="content-wrap">
        <div class="container pt-checkout-wrap">
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

            @if (count($data) != 0)
                <br/>
                <div class="center"><h1>Payment</h1></div>
                {{
                    Form::open([
                        'novalidate',
                        'route' => 'fronend.cart.confirm.crate',
                        'id'=>'paymentForm',
                        'method' => 'post',
                        'files' => true
                    ])
                }}
                    <div class="row">
                        <div class="col-md-7">
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
                            <div class="col_full nobottommargin">
                                <div class="tabs tabs-bb tabs-cart-confirm clearfix nobottommargin" id="tab-9">
                                    <ul class="tab-nav clearfix">
                                        <li id="cart-tabs-residence"><a href="#tabs-residence">Billing Address</a></li>
                                    </ul>
                                    <div class="tab-container">
                                        <div class="tab-content clearfix" id="tabs-residence">
                                            <div class="col_full bottommargin-xs">
                                                First Name - Last Name <span class="span-danger">*</span>
                                            </div>
                                            <div class="col_half">
                                                <input type="text" placeholder="First Name" id="residence_name" name="residence_name" class="sm-form-control @error('residence_name') invalid @enderror" @if(!empty($usersAddress->name)) value="{{ $usersAddress->name }}" @else @if(!empty(old('residence_name'))) value="{{ old('residence_name') }}" @endif @endif>
                                                @error('residence_name')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                            </div>
                                            <div class="col_half col_last">
                                                <input type="text" placeholder="Last Name" id="residence_lastname" name="residence_lastname" class="sm-form-control @error('residence_lastname') invalid @enderror" @if(!empty($usersAddress->lastname)) value="{{ $usersAddress->lastname }}" @else @if(!empty(old('residence_lastname'))) value="{{ old('residence_lastname') }}" @endif @endif>
                                                @error('residence_lastname')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                            </div>
                                            <div class="col_full">
                                                Phone Number <span class="span-danger">*</span>
                                                <input type="text" placeholder="Phone Number" id="residence_tel" name="residence_tel" class="sm-form-control @error('residence_tel') invalid @enderror" @if(!empty($usersAddress->tel)) value="{{ $usersAddress->tel }}" @else @if(!empty(old('residence_tel'))) value="{{ old('residence_tel') }}" @endif @endif>
                                                @error('residence_tel')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                            </div>
                                            <div class="col_full">
                                                House No., Street, Soi/Lane <span class="span-danger">*</span>
                                                <textarea placeholder="House No., Street, Soi/Lane" id="residence_address" name="residence_address" class="sm-form-control @error('residence_address') invalid @enderror">@if(!empty($usersAddress->address)){{ $usersAddress->address }}@else @if(!empty(old('residence_address'))){{ old('residence_address') }}@endif @endif</textarea>
                                                @error('residence_address')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                            </div>
                                            <div class="col_half">
                                                Province <span class="span-danger">*</span>
                                                <select id="province" name="province" data-placeholder="Please select province" class="sm-form-control @error('province') invalid @enderror" onchange="amphuresAddress()">
                                                    <option></option>
                                                    @foreach ( $provinces as $province)
                                                        <option value="{{ $province->id }}" @if(!empty($usersAddress->province)) @if($province->id ==  $usersAddress->province) selected @endif @else @if(old('province') == $province->id ) selected @endif @endif>{{ $province->prov_name_th  }}</option>
                                                    @endforeach
                                                </select>
                                                @error('province')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                                <input id="address_province" name="address_province" type="hidden" value="@if(!empty($usersAddress->province)){{ $usersAddress->province }}@endif">
                                            </div>
                                            <div class="col_half col_last">
                                                District/Amphoe <span class="span-danger">*</span>
                                                <select id="amphures" name="amphures" data-placeholder="Please select district/amphoe" class="sm-form-control @error('amphures') invalid @enderror" onchange="districtAddress()">
                                                    <option></option>
                                                </select>
                                                @error('amphures')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                                <input id="address_amphures" name="address_amphures" type="hidden" value="@if(!empty($usersAddress->amphures)){{ $usersAddress->amphures }}@endif">
                                            </div>
                                            <div class="col_half">
                                                Subdistrict/Tambon <span class="span-danger">*</span>
                                                <select id="district" name="district" data-placeholder="Please select subdistrict/tambon" class="sm-form-control @error('district') invalid @enderror" onchange="zipcodeAddress()">
                                                    <option></option>
                                                </select>
                                                @error('district')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                                <input id="address_district" name="address_district" type="hidden" value="@if(!empty($usersAddress->district)){{ $usersAddress->district }}@endif">
                                            </div>
                                            <div class="col_half col_last">
                                                Postal Code <span class="span-danger">*</span>
                                                <input id="zipcode" name="zipcode" placeholder="Please enter postal code" class="sm-form-control @error('zipcode') invalid @enderror" value="" />
                                                @error('zipcode')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                                <input id="address_zipcode" name="address_zipcode" type="hidden" value="@if(!empty($usersAddress->zipcode)){{ $usersAddress->zipcode }}@endif">
                                            </div>
                                            <div class="col_full">
                                                Message to Seller <span class="span-danger">*</span>
                                                <textarea rows="5" placeholder="Message to seller" id="residence_massage" name="residence_massage" class="sm-form-control">@if(!empty($usersAddress->message)){{ $usersAddress->message }}@else @if(!empty(old('residence_massage'))){{ old('residence_massage') }}@endif @endif</textarea>
                                                <small>*For renewal customers, please specify the Serial Number and expiry date in the "Message to Seller" field</small>
												<input type="hidden" id="ref" name="ref" @if (!empty($ref)) value="{{ $ref }}" @else value="" @endif>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col_full">
                                <div>
                                    <input id="chkReceipt" class="checkbox-style" name="chkReceipt" type="checkbox" @if(!empty(old('chkReceipt'))) @if(old('chkReceipt') == 'on') checked @endif @endif>
                                    <label for="chkReceipt" class="checkbox-style-3-label">Need a full tax invoice</label>
                                </div>
                                <small class="co-red">* If you need a full tax invoice, please fill in the address for receipt delivery</small>
                            </div>
                            <div class="col_full" id="cart-tabs-receipts"  @if(!empty(old('chkReceipt'))) @if(old('chkReceipt') == 'on') style="display:unset" @endif @endif>
                                <div class="col_full">
                                    <div class="inline">
                                        <input id="receipt_persona_type_1" class="radio-style" name="receipt_persona_type" type="radio" value="1" @if(!empty($type)) @if($type == 1) checked @endif @else checked @endif>
                                        <label for="receipt_persona_type_1" class="radio-style-2-label">Individual</label>
                                    </div>
                                    <div class="inline">
                                        <input id="receipt_persona_type_2" class="radio-style" name="receipt_persona_type" type="radio" value="2" @if(!empty($type)) @if($type == 2) checked @endif @endif>
                                        <label for="receipt_persona_type_2" class="radio-style-2-label">Company/Office/Organization</label>
                                    </div>
                                </div>
                                <div class="col_full">
                                    Tax ID <span class="span-danger">*</span>
                                    <input type="text" placeholder="Tax ID" id="receipt_tax" name="receipt_tax" class="sm-form-control @error('receipt_tax') invalid @enderror" @if(!empty($usersReceipt->taxid)) value="{{ $usersReceipt->taxid }}" @else @if(!empty(old('receipt_tax'))) value="{{ old('receipt_tax') }}" @endif @endif>
                                    @error('receipt_tax')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                </div>
								
								{{-- WHT Toggle: shown only when tax invoice is checked + persona is Company --}}
								<div class="col_full" id="wht_block" style="display:none;">
									<div class="bottommargin-xs"><b>Withholding Tax</b></div>

									<div class="inline">
										<input id="withholding_apply_0" class="radio-style" name="withholding_apply" type="radio" value="0" checked>
										<label for="withholding_apply_0" class="radio-style-2-label">No withholding tax</label>
									</div>

									<div class="inline">
										<input id="withholding_apply_1" class="radio-style" name="withholding_apply" type="radio" value="1"
											@if(!empty(old('withholding_apply')) && old('withholding_apply')=='1') checked @endif
										>
										<label for="withholding_apply_1" class="radio-style-2-label">Withhold tax</label>
									</div>

									<div class="small co-red" style="margin-top:6px;">
										*If withholding tax applies, please send the withholding tax certificate to the company afterwards.<br>
										Address for sending the original withholding tax certificate:<br><br>

										Finance Department (Withholding Tax)<br>
										Applicad Public Company Limited, Head Office Branch<br>
										Tax ID 0107561000471<br>
										69 Soi Sukhumvit 68, Sukhumvit Road, Bangna Nuea, Bangna, Bangkok 10260
									</div>
								</div>
								
                                <div class="col_half ">
                                    Company Name
                                    <input type="text" placeholder="Company Name" id="receipt_company" name="receipt_company" class="sm-form-control @error('receipt_company') invalid @enderror" @if(!empty($usersReceipt->company)) value="{{ $usersReceipt->company }}" @else @if(!empty(old('receipt_company'))) value="{{ old('receipt_company') }}" @endif @endif>
                                    @error('receipt_company')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                </div>
                                <div class="col_half col_last">
                                    Branch (if any)
                                    <input type="text" placeholder="Branch (if any)" id="receipt_branch" name="receipt_branch" class="sm-form-control" @if(!empty($usersReceipt->branch)) value="{{ $usersReceipt->branch }}" @else @if(!empty(old('receipt_branch'))) value="{{ old('receipt_branch') }}" @endif @endif>
                                </div>
                                <div class="col_full bottommargin-xs">
                                    First Name - Last Name <span class="span-danger">*</span>
                                </div>
                                <div class="col_half">
                                    <input type="text" placeholder="First Name" id="receipt_name" name="receipt_name" class="sm-form-control @error('receipt_name') invalid @enderror" @if(!empty($usersReceipt->name)) value="{{ $usersReceipt->name }}" @else @if(!empty(old('receipt_name'))) value="{{ old('receipt_name') }}" @endif @endif>
                                    @error('receipt_name')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                </div>
                                <div class="col_half col_last">
                                    <input type="text" placeholder="Last Name" id="receipt_lastname" name="receipt_lastname" class="sm-form-control @error('receipt_lastname') invalid @enderror" @if(!empty($usersReceipt->lastname)) value="{{ $usersReceipt->lastname }}" @else @if(!empty(old('receipt_lastname'))) value="{{ old('receipt_lastname') }}" @endif @endif>
                                    @error('receipt_lastname')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                </div>
                                <div class="col_full">
                                    Phone Number <span class="span-danger">*</span>
                                    <input type="text" placeholder="Phone Number" id="receipt_tel" name="receipt_tel" class="sm-form-control @error('receipt_tel') invalid @enderror" @if(!empty($usersReceipt->tel)) value="{{ $usersReceipt->tel }}" @else @if(!empty(old('receipt_tel'))) value="{{ old('receipt_tel') }}" @endif @endif>
                                    @error('receipt_tel')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                </div>
                                <div class="col_full">
                                    House No., Street, Soi/Lane <span class="span-danger">*</span>
                                    <textarea placeholder="House No., Street, Soi/Lane" id="receipt_address" name="receipt_address" class="sm-form-control @error('receipt_address') invalid @enderror">@if(!empty($usersReceipt->address)){{ $usersReceipt->address }}@else @if(!empty(old('receipt_address'))){{ old('receipt_address') }}@endif @endif</textarea>
                                    @error('receipt_address')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                </div>
                                <div class="col_half">
                                    Province <span class="span-danger">*</span>
                                    <select id="receipt_province" name="receipt_province" data-placeholder="Please select province" class="sm-form-control @error('receipt_province') invalid @enderror" onchange="amphuresReceipt()">
                                        <option></option>
                                        @foreach ( $provinces as $province)
                                            <option value="{{ $province->id }}" @if(!empty($usersReceipt->province)) @if($usersReceipt->province == $province->id ) selected @endif @else @if(old('receipt_province') == $province->id ) selected @endif @endif>{{ $province->prov_name_th  }}</option>
                                        @endforeach
                                    </select>
                                    @error('receipt_province')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                    <input id="receipt_hd_province" name="receipt_hd_province" type="hidden" value="@if(!empty($usersReceipt->province)){{ $usersReceipt->province }}@endif">
                                </div>
                                <div class="col_half col_last">
                                    District/Amphoe <span class="span-danger">*</span>
                                    <select id="receipt_amphures" name="receipt_amphures" data-placeholder="Please select district/amphoe" class="sm-form-control @error('receipt_amphures') invalid @enderror" onchange="districtReceipt()">
                                        <option></option>
                                    </select>
                                    @error('receipt_amphures')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                    <input id="receipt_hd_amphures" name="receipt_hd_amphures" type="hidden" value="@if(!empty($usersReceipt->amphures)){{ $usersReceipt->amphures }}@endif">
                                </div>
                                <div class="col_half">
                                    Subdistrict/Tambon <span class="span-danger">*</span>
                                    <select id="receipt_district" name="receipt_district" data-placeholder="Please select subdistrict/tambon" class="sm-form-control @error('receipt_district') invalid @enderror" onchange="zipcodeReceipt()">
                                        <option></option>
                                    </select>
                                    @error('receipt_district')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                    <input id="receipt_hd_district" name="receipt_hd_district" type="hidden" value="@if(!empty($usersReceipt->district)){{ $usersReceipt->district }}@endif">
                                </div>
                                <div class="col_half col_last">
                                    Postal Code <span class="span-danger">*</span>
                                    <input id="receipt_zipcode" name="receipt_zipcode" placeholder="Please enter postal code" class="sm-form-control @error('receipt_zipcode') invalid @enderror" value="" />
                                    @error('receipt_zipcode')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                    <input id="receipt_hd_zipcode" name="receipt_hd_zipcode" type="hidden" value="@if(!empty($usersReceipt->zipcode)){{ $usersReceipt->zipcode }}@endif">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            @if(!empty($total['subtotal']))
                                <input type="hidden" name="subtotal" id="subtotal" value="{{ $total['subtotal'] }}" />
                            @endif
                            <div id="b_checkout">
                                <h4>Order Summary</h4>
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                            @foreach ($data as $product)
                                                <tr>
                                                    <td>
                                                        @if ($product->attributes->detail_name != 'null')
                                                            {{ $product->name }} ({{ $product->attributes->detail_name }})
                                                            @if ($product->attributes->detail_other != 'null') <br/> {{ $product->attributes->detail_other }} @endif
                                                        @else
                                                            {{ $product->name }}
                                                        @endif
														
														<span class="small co-red">
															(
																@if($product->attributes->pricesale != 0 and $product->attributes->price != $product->price and $product->price < $product->attributes->price)
																	<span class="amount-sale co-red">{{ number_format($product->attributes->price) }}</span> 
																@endif
															{{ number_format($product->price) }} x {{ $product->quantity }}
															)
														</span>
														 
                                                    </td>
                                                    <td class="text-right">
                                                        <span class="amount">{{ number_format(($product->price*$product->quantity),2) }}.-</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            @if(count($dataCondition) != 0)
                                                @foreach($dataCondition as $condition)
                                                    <tr class="cart_item">
                                                        <td class="cart-product-name co-f1c40f">
                                                            <strong>Total Discount <br/><small>{{ $condition->getName() }}</small></strong>
                                                        </td>

                                                        <td class="cart-total-name co-f1c40f">
                                                            @if ($condition->getType() == 1)
                                                                <span class="amount-condition">{{ number_format($condition->getValue(),2) }}.-</span>
                                                            @else
                                                                <span class="amount-condition">{{ $condition->getValue() }}%</span>
                                                            @endif
                                                            <input type="hidden" name="conditionType" id="conditionType" value="{{ $condition->getType() }}" />
                                                            <input type="hidden" name="conditionName" id="conditionName" value="{{ $condition->getName() }}" />
                                                            <input type="hidden" name="conditionValue" id="conditionValue" value="{{ $condition->getValue() }}" />
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
											<tr><td colspan="2">&nbsp;</td></tr>
                                            @if(!empty($total['totaldiscount']))
                                                @if(count($dataCondition) != 0 || $total['vat'] != 0)
                                                    <tr class="cart_item">
                                                        <td class="cart-product-name" style="border-top: none;">
                                                            <strong>Net Product Price</strong>
                                                        </td>
                                                        <td class="cart-total-name" style="border-top: none;">
                                                            <span id="sumTotal_n" class="amount">{{ number_format($total['totaldiscount'],2) }}.-</span>
                                                            <input type="hidden" name="totaldiscount" id="totaldiscount" value="{{ $total['totaldiscount'] }}" />
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endif
                                            @if(!empty($total['vat']))
                                                @if($total['vat'] != 0)
                                                    <tr class="cart_item" id="tdcartVat">
                                                        <td class="cart-product-name">
                                                            <strong>VAT</strong>
                                                        </td>
                                                        <td class="cart-total-name">
                                                            <span id="cartVat" class="amount">{{ number_format($total['vat'],2) }}.-</span>
                                                            <input type="hidden" name="priceVAT" id="priceVAT" value="{{ $total['vat'] }}" />
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endif
                                            @if(!empty($total['nettotal']))
                                                <tr class="cart_item" id="cartNettotal">
                                                    <td class="cart-product-name">
                                                        <strong>Net Total</strong>
                                                    </td>
                                                    <td class="cart-total-name">
                                                        <span id="cartNettotal" class="amount">{{ number_format($total['nettotal'],2) }}.-</span>
                                                        <input type="hidden" name="priceNettotal" id="priceNettotal" value="{{ $total['nettotal'] }}" />
                                                    </td>
                                                </tr>
                                            @endif
											
												{{-- Individual --}}
												<input type="hidden" id="person_total_no_wht" value="{{ $total_person_no_wht['total'] }}">
												<input type="hidden" id="person_total_with_wht" value="{{ $total_person_with_wht['total'] }}">
												<input type="hidden" id="person_wht_amount" value="{{ $total_person_with_wht['withholding'] }}">

												{{-- Company --}}
												<input type="hidden" id="company_total_no_wht" value="{{ $total_company_no_wht['total'] }}">
												<input type="hidden" id="company_total_with_wht" value="{{ $total_company_with_wht['total'] }}">
												<input type="hidden" id="company_wht_amount" value="{{ $total_company_with_wht['withholding'] }}">

												<tr class="cart_item" id="rowWithholding" style="display:none;">
													<td class="cart-product-name">
														<strong>Withholding Tax Deduction</strong>
													</td>
													<td class="cart-total-name">
														<span id="cartWithholding" class="amount">0.00.-</span>
														<input type="hidden" name="priceWithholding" id="priceWithholding" value="0" />
													</td>
												</tr>

                                            <tr class="cart_item">
                                                <td class="cart-product-name">
                                                    <strong>Shipping</strong>
                                                </td>

                                                <td class="cart-total-name">
                                                    <span class="amount">Free Shipping</span>
                                                </td>
                                            </tr>
                                            <tr class="cart_item">
    <td class="cart-product-name bg_eee" style="white-space:nowrap;"><strong>Amount Due</strong></td>

    <td class="cart-total-name bg_eee" style="white-space:nowrap; text-align:right;">
        <span id="totalCart" class="amount color lead"><strong>{{ number_format($total['total'],2) }}.-</strong></span>
        <input type="hidden" name="totalCart" id="totalCart" value="{{ $total['total'] }}" />
    </td>
</tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @if (!empty($settingPayment))
                                <div>
										<div id="omise_errors"></div>
                                    <div style="display:none !important">
    <div>
        <input id="radio-bank" class="radio-style" name="radio_payment_type" value="1" type="radio">
        <label for="radio-bank" class="radio-style-2-label">Bank Transfer</label>
    </div>
    <div id="content-bank">
        <div class="bottommargin-sm">Pay by transferring to our bank account (the account number will be shown after clicking "Pay"). After payment, please send proof of payment along with your order number so we can verify it.</div>
        <button id="btn_bank" type="submit" class="loadding button button-green btn-block btn-bank nomargin">
            </i> Pay
        </button>
    </div>
</div>

@if($settingPayment->promtpay_status == 1)
    <div>
        <input id="radio-promptpay" class="radio-style" name="radio_payment_type" value="4" type="radio" checked="">
        <label for="radio-promptpay" class="radio-style-2-label">PromptPay</label>
    </div>
    <div id="content-promptpay">
        <div class="bottommargin-sm">Scan to pay via QR Code, supports all banks. Once payment is successful, your order will be approved immediately.</div>
        <button id="btn_promptpay" type="submit" class="button button-blue btn-block btn-promptpay nomargin">
            <i class="icon-qrcode"></i> Pay
        </button>
    </div>
@endif
<script>
$(function(){
    var $checkedRadio = $('input[name="radio_payment_type"]:checked');
    if ($checkedRadio.length) {
        $checkedRadio.trigger('click');
    }
});
</script>
										
									{{-- [Temporarily disabled] Hidden with CSS instead of removing HTML, because custom.js references this element — removing it would break the JS for other options --}}
@if($settingPayment->mobile_banking_status == 1)
<div style="display:none !important">
										<div>
                                            <input id="radio-mobile_banking" class="radio-style" name="radio_payment_type" value="5" type="radio">
                                            <label for="radio-mobile_banking" class="radio-style-2-label">Mobile Banking</label>
                                        </div>
                                        <div id="content-mobile_banking">
											<div class="bottommargin-sm">
												Select your banking app for payment
												<br>
												<br>
												
												<div class="wrapper">
													<input type="radio" name="radio_mobile_banking_name" id="option-1" value="mobile_banking_kbank">
													<input type="radio" name="radio_mobile_banking_name" id="option-2" value="mobile_banking_scb">
													<input type="radio" name="radio_mobile_banking_name" id="option-3" value="mobile_banking_bay">
													<input type="radio" name="radio_mobile_banking_name" id="option-4" value="mobile_banking_bbl">
													<label for="option-1" class="option option-1 col-xs-6 col-md-3 col-form-label">
														<center>
															<img src="../storage/mobile_banking/mkplus.webp" alt="Kasikorn Bank">
															<br>
															<span>K PLUS</span>
														</center>
													</label>
													<label for="option-2" class="option option-2 col-xs-6 col-md-3 col-form-label">
														<center>
															<img src="../storage/mobile_banking/mscb.webp" alt="Siam Commercial Bank">
															<br>
															<span>SCB EASY</span>
														</center>
													</label>
													<label for="option-3" class="option option-3 col-xs-6 col-md-3 col-form-label">
														<center>
															<img src="../storage/mobile_banking/mbay.webp" alt="Bank of Ayudhya (Krungsri)">
															<br>
															<span>KMA</span>
														</center>
													</label>
													<label for="option-4" class="option option-4 col-xs-6 col-md-3 col-form-label">
														<center>
															<img src="../storage/mobile_banking/mbbl.webp" alt="Bangkok Bank">
															<br>
															<span>Bualuang</span>
														</center>
													</label>
												</div>
												<div id="mb_errors" class="alert"></div>
											</div>
											<button id="btn_mobile_banking" class="button button-aqua btn-block btn-mobile_banking nomargin" onClick="return MB_CheckOut();">
												Pay
                                            </button>
                                        </div>
                                        </div>
									@endif
									
                                  @if($settingPayment->installment_status == 1)
<div style="display:none !important">
                                        <div>
                                            <input id="radio-installment" class="radio-style" name="radio_payment_type" value="2" type="radio">
                                            <label for="radio-installment" class="radio-style-2-label">Installment</label>
                                        </div>
                                        <div id="content-installment">
											<div class="bottommargin-sm">
												Installment terms:
												<ul>
													<li>Minimum payment amount must not be less than 3,000 THB</li>
													<li>Maximum installment amount must not exceed 150,000 THB</li>
													<li>Customer is responsible for installment interest</li>
												</ul>
												@foreach ($settingInstallment as $installment)
												<div class="row b-installment">
													<div class="col-lg-2 col-md-2 col-sm-2 col-xs-3">
														<img width="42" height="42" class="lazyload" loading="lazy" data-src="{{ asset('storage/installment/'.$installment->installment_img) }}" alt="{{ $installment->installment_name }}" style="margin-top:10px; max-width: none;">
													</div>
													<div class="col-lg-10 col-md-10 col-sm-10 col-xs-9">{{ $installment->installment_name }}<br/><small>Duration: {{ $installment->installment_detail }}</small><br/><small>Interest Rate: <b style="color: red;">{{ $installment->interest_detail }}</b></small></div>
												</div>
												@endforeach
												<small style="color: red;">** Interest rates are subject to change depending on each bank's promotions</small>
											</div>
											<button id="btn_installment" class="button button-pink btn-block btn-installment nomargin">
												Select bank for installment
                                            </button>
                                        </div>
                                    </div>
                                    @endif
                                    @if($settingPayment->credit_card_status == 1)
    <div>
        <input id="radio-creditcard" class="radio-style" name="radio_payment_type" value="3" type="radio">
        <label for="radio-creditcard" class="radio-style-2-label">Credit Card</label>
    </div>
    <div id="content-creditcard">
        <div class="bottommargin-sm">Enter your card details securely in the next step. Supports Visa, Mastercard, JCB.</div>
        <button id="btn_creditcard" type="submit" class="button button-green btn-block btn-bank nomargin">
            <i class="icon-save"></i> Confirm Order
        </button>
    </div>
@endif
									
									@if($settingPayment->truemoney_status == 1)
<div style="display:none !important">
<div>
    <input id="radio-truemoney" class="radio-style" name="radio_payment_type" value="6" type="radio">
    <label for="radio-truemoney" class="radio-style-2-label">TrueMoney Wallet</label>
</div>
										<div id="content-truemoney">
											<div class="bottommargin-sm">
												Pay via TrueMoney Wallet
											</div>
											<button id="btn_truemoney" class="button button-amber btn-block btn-truemoney nomargin">
												Pay
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
							var payment_type = $('input[name="radio_mobile_banking_name"]:checked').val();
							if(payment_type == '' || payment_type == null || payment_type === undefined){
								$("#mb_errors").addClass('alert-danger').html('Please select a banking app to make payment');
								return false;
							}
							var os = getMobileOperatingSystem();
							if(os != 'ANDROID' && os != 'IOS'){
								$("#mb_errors").addClass('alert-danger').html('Available for Android and iOS only. Please select another payment method.');
								return false;
							}
							Omise.setPublicKey("@if($settingPayment->omise_status == 3){{ $settingPayment->omise_public_key_for_test }}@else{{$settingPayment->omise_public_key_for_live}}@endif");
							Omise.createSource(payment_type, {
							  "amount": "{{ round($total['total'],2)*100 }}",
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
							if (/windows phone/i.test(userAgent)) { return "WINDOWS PHONE"; }
							if (/android/i.test(userAgent)) { return "ANDROID"; }
							if (/iPad|iPhone|iPod/.test(userAgent) && !window.MSStream) { return "IOS"; }
							return "unknown";
						}
					</script>
                </form>
            @else
                <div class="topmargin-lg bottommargin-lg text-center">
                    <h2>No items in cart</h2>
                </div>
            @endif

        </div>
    </div>

</section>
@endsection
@section('js')
 <script src="{{ asset('vendor/select2/select2.min.js') }}"></script>
 <script src="{{ asset('vendor/select2-bootstrap4-theme/docs/script.js') }}"></script>
 <script>
	gtag("event", "begin_checkout", {
		currency: "THB",
		value: "{{ number_format($total['total'], 2, '.', '') }}",
		items: [
			@foreach ($data as $product)
			{
				item_id: "{{ $product->attributes->sku }}",
				item_name: "{{ $product->name }}",
				item_brand: "",
				price: "{{ number_format(($product->price), 2, '.', '') }}",
				quantity: "{{ $product->quantity }}"
			},
			@endforeach
		]
	});
</script>
@if(session('invalid'))
    @php
        $msgs = [
            1 => 'You already have this coupon in the system.',
            2 => 'This coupon has expired and can no longer be used.',
            3 => 'This coupon can no longer be used because it has reached its usage limit.',
            4 => 'This coupon cannot be used because it has reached the maximum number of uses.',
            5 => 'This coupon cannot be used because the order total is below the minimum required.',
            6 => 'This coupon cannot be used because the order total exceeds the maximum allowed.',
            7 => 'This coupon cannot be used because the product is not eligible for this discount.',
            8 => 'This coupon cannot be used because the product category is not eligible for this discount.',
            9 => 'This coupon cannot be used because your cart is empty.',
            10 => 'This coupon cannot be used together with discounted products.',
        ];
        $code = session('invalid');
    @endphp
    <script>
        alert(@json($msgs[$code]));
    </script>
@endif

<script>
(function(){
  const selectors = [
    '#btn_truemoney',
    '#btn_creditcard',
    '#btn_installment',
    '#btn_mobile_banking',
    '#btn_promptpay',
    '#btn_bank'
  ].join(',');

  document.querySelectorAll(selectors).forEach(btn => {
    btn.addEventListener('click', function _handler(e) {
      e.preventDefault();
      const $btn = this;

      fetch("{{ route('cart.validateCoupon') }}", {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
          'Accept':       'application/json',
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({})
      })
      .then(res => res.json())
      .then(json => {
        if (json.invalid && json.invalid !== 0) {
          alert(json.msg);
          window.location.href = "{{ route('fronend.cart') }}";
        } else {
          $btn.removeEventListener('click', _handler);
          $btn.click();
        }
      })
      .catch(() => {
        $btn.removeEventListener('click', _handler);
        $btn.click();
      });
    });
  });
})();
</script>

<script>
(function(){
  const $chkReceipt = document.querySelector('#chkReceipt');
  const $whtBlock = document.querySelector('#wht_block');
  const $rowWht = document.querySelector('#rowWithholding');
  const $totalSpan = document.querySelector('span#totalCart');
  const $totalInput = document.querySelector('input#totalCart');
  const $priceWithholdingInput = document.querySelector('#priceWithholding');

  function isCompanySelected(){
    const persona = document.querySelector('input[name="receipt_persona_type"]:checked');
    return persona && persona.value === '2';
  }
  function isReceiptEnabled(){
    return $chkReceipt && $chkReceipt.checked;
  }
  function updateWhtUI(){
    const showWht = isReceiptEnabled() && isCompanySelected();
    if ($whtBlock) $whtBlock.style.display = showWht ? '' : 'none';
    if (!showWht) {
      const no = document.querySelector('#withholding_apply_0');
      if (no) no.checked = true;
    }
    updateTotals();
  }
  function getTotalsByPersona(){
	const isCompany = isCompanySelected();
	const totalNoWht   = parseFloat(document.querySelector(isCompany ? '#company_total_no_wht'   : '#person_total_no_wht')?.value || '0');
	const totalWithWht = parseFloat(document.querySelector(isCompany ? '#company_total_with_wht' : '#person_total_with_wht')?.value || '0');
	const whtAmount    = parseFloat(document.querySelector(isCompany ? '#company_wht_amount'    : '#person_wht_amount')?.value || '0');
	return { totalNoWht, totalWithWht, whtAmount };
  }
  function updateTotals(){
	const showWht = isReceiptEnabled() && isCompanySelected();
	const apply = showWht && document.querySelector('input[name="withholding_apply"]:checked')?.value === '1';
	const t = getTotalsByPersona();
	const total = apply ? t.totalWithWht : t.totalNoWht;
	const wht   = apply ? t.whtAmount : 0;
	if ($rowWht) $rowWht.style.display = apply ? '' : 'none';
	if ($priceWithholdingInput) $priceWithholdingInput.value = wht.toFixed(2);
	if ($totalSpan) $totalSpan.innerHTML =
	'<strong>' + total.toLocaleString(undefined,{minimumFractionDigits:2, maximumFractionDigits:2}) + '.-</strong>';
	if ($totalInput) $totalInput.value = total.toFixed(2);
	const $whtText = document.querySelector('#cartWithholding');
	if ($whtText) $whtText.textContent = wht.toLocaleString(undefined,{minimumFractionDigits:2, maximumFractionDigits:2}) + '.-';
  }
  if ($chkReceipt) $chkReceipt.addEventListener('change', updateWhtUI);
  document.querySelectorAll('input[name="receipt_persona_type"]').forEach(el => el.addEventListener('change', updateWhtUI));
  document.querySelectorAll('input[name="withholding_apply"]').forEach(el => el.addEventListener('change', updateTotals));
  updateWhtUI();
})();
</script>

 @endsection