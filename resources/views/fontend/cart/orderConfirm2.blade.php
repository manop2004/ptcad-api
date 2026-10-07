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
ul.small li{
    margin-left: 20px;
    font-size: 12px;
}
/* Radio Button */
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

            @if (count($data) != 0)
                <br/>
                <div class="center"><h1>ชำระเงิน</h1></div>
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
                                        <li id="cart-tabs-residence"><a href="#tabs-residence">ที่อยู่สำหรับจัดส่งสินค้า</a></li>
                                    </ul>
                                    <div class="tab-container">
                                        <div class="tab-content clearfix" id="tabs-residence">
                                            <div class="col_full bottommargin-xs">
                                                ชื่อ - สกุล <span class="span-danger">*</span>
                                            </div>
                                            <div class="col_half">
                                                <input type="text" placeholder="ชื่อ" id="residence_name" name="residence_name" class="sm-form-control @error('residence_name') invalid @enderror" @if(!empty($usersAddress->name)) value="{{ $usersAddress->name }}" @else @if(!empty(old('residence_name'))) value="{{ old('residence_name') }}" @endif @endif>
                                                @error('residence_name')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                            </div>
                                            <div class="col_half col_last">
                                                <input type="text" placeholder="นามสกุล" id="residence_lastname" name="residence_lastname" class="sm-form-control @error('residence_lastname') invalid @enderror" @if(!empty($usersAddress->lastname)) value="{{ $usersAddress->lastname }}" @else @if(!empty(old('residence_lastname'))) value="{{ old('residence_lastname') }}" @endif @endif>
                                                @error('residence_lastname')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                            </div>
                                            <div class="col_full">
                                                เบอร์โทรศัพท์ <span class="span-danger">*</span>
                                                <input type="text" placeholder="เบอร์โทรศัพท์" id="residence_tel" name="residence_tel" class="sm-form-control @error('residence_tel') invalid @enderror" @if(!empty($usersAddress->tel)) value="{{ $usersAddress->tel }}" @else @if(!empty(old('residence_tel'))) value="{{ old('residence_tel') }}" @endif @endif>
                                                @error('residence_tel')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                            </div>
                                            <div class="col_full">
                                                บ้านเลขที่ ถนน ซอย <span class="span-danger">*</span>
                                                <textarea placeholder="บ้านเลขที่ ถนน ซอย" id="residence_address" name="residence_address" class="sm-form-control @error('residence_address') invalid @enderror">@if(!empty($usersAddress->address)){{ $usersAddress->address }}@else @if(!empty(old('residence_address'))){{ old('residence_address') }}@endif @endif</textarea>
                                                @error('residence_address')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                            </div>
                                            <div class="col_half">
                                                จังหวัด <span class="span-danger">*</span>
                                                <select id="province" name="province" data-placeholder="กรุณาเลือกจังหวัด" class="sm-form-control @error('province') invalid @enderror" onchange="amphuresAddress()">
                                                    <option></option>
                                                    @foreach ( $provinces as $province)
                                                        <option value="{{ $province->id }}" @if(!empty($usersAddress->province)) @if($province->id ==  $usersAddress->province) selected @endif @else @if(old('province') == $province->id ) selected @endif @endif>{{ $province->prov_name_th  }}</option>
                                                    @endforeach
                                                </select>
                                                @error('province')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                                <input id="address_province" name="address_province" type="hidden" value="@if(!empty($usersAddress->province)){{ $usersAddress->province }}@endif">
                                            </div>
                                            <div class="col_half col_last">
                                                เขต/อำเภอ <span class="span-danger">*</span>
                                                <select id="amphures" name="amphures" data-placeholder="กรุณาเลือกเขต/อำเภอ" class="sm-form-control @error('amphures') invalid @enderror" onchange="districtAddress()">
                                                    <option></option>
                                                </select>
                                                @error('amphures')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                                <input id="address_amphures" name="address_amphures" type="hidden" value="@if(!empty($usersAddress->amphures)){{ $usersAddress->amphures }}@endif">
                                            </div>
                                            <div class="col_half">
                                                แขวง/ตำบล <span class="span-danger">*</span>
                                                <select id="district" name="district" data-placeholder="กรุณาเลือกแขวง / ตำบล" class="sm-form-control @error('district') invalid @enderror" onchange="zipcodeAddress()">
                                                    <option></option>
                                                </select>
                                                @error('district')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                                <input id="address_district" name="address_district" type="hidden" value="@if(!empty($usersAddress->district)){{ $usersAddress->district }}@endif">
                                            </div>
                                            <div class="col_half col_last">
                                                รหัสไปรษณีย์ <span class="span-danger">*</span>
                                                <input id="zipcode" name="zipcode" placeholder="กรุณากรอกรหัสไปรษณีย์" class="sm-form-control @error('zipcode') invalid @enderror" value="" />
                                                @error('zipcode')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                                <input id="address_zipcode" name="address_zipcode" type="hidden" value="@if(!empty($usersAddress->zipcode)){{ $usersAddress->zipcode }}@endif">
                                            </div>
                                            <div class="col_full">
                                                ข้อความถึงผู้ขาย <span class="span-danger">*</span>
                                                <textarea rows="5" placeholder="ข้อความถึงผู้ขาย" id="residence_massage" name="residence_massage" class="sm-form-control">@if(!empty($usersAddress->message)){{ $usersAddress->message }}@else @if(!empty(old('residence_massage'))){{ old('residence_massage') }}@endif @endif</textarea>
                                                <small>*ลูกค้าที่ต่ออายุ สามารถระบุ Serial number และ วันหมดอายุ ได้ที่ "ข้อความถึงผู้ขาย"</small>
												<input type="hidden" id="ref" name="ref" @if (!empty($ref)) value="{{ $ref }}" @else value="" @endif>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col_full">
                                <div>
                                    <input id="chkReceipt" class="checkbox-style" name="chkReceipt" type="checkbox" @if(!empty(old('chkReceipt'))) @if(old('chkReceipt') == 'on') checked @endif @endif>
                                    <label for="chkReceipt" class="checkbox-style-3-label">ต้องการใบกำกับภาษีเต็มรูปแบบหรือไม่?</label>
                                </div>
                                <small class="co-red">* หากต้องการใบกำกับภาษีเต็มรูปแบบกรุณากรอกที่อยู่สำหรับจัดส่งใบเสร็จรับเงิน</small>
                            </div>
                            <div class="col_full" id="cart-tabs-receipts"  @if(!empty(old('chkReceipt'))) @if(old('chkReceipt') == 'on') style="display:unset" @endif @endif>
                                <div class="col_full">
                                    <div class="inline">
                                        <input id="receipt_persona_type_1" class="radio-style" name="receipt_persona_type" type="radio" value="1" @if(!empty($type)) @if($type == 1) checked @endif @else checked @endif>
                                        <label for="receipt_persona_type_1" class="radio-style-2-label">บุคคลธรรมดา</label>
                                    </div>
                                    <div class="inline">
                                        <input id="receipt_persona_type_2" class="radio-style" name="receipt_persona_type" type="radio" value="2" @if(!empty($type)) @if($type == 2) checked @endif @endif>
                                        <label for="receipt_persona_type_2" class="radio-style-2-label">บริษัท/สำนักงาน/องค์กร</label>
                                    </div>
                                </div>
                                <div class="col_full">
                                    เลขประจำตัวผู้เสียภาษี <span class="span-danger">*</span>
                                    <input type="text" placeholder="เลขประจำตัวผู้เสียภาษี" id="receipt_tax" name="receipt_tax" class="sm-form-control @error('receipt_tax') invalid @enderror" @if(!empty($usersReceipt->taxid)) value="{{ $usersReceipt->taxid }}" @else @if(!empty(old('receipt_tax'))) value="{{ old('receipt_tax') }}" @endif @endif>
                                    @error('receipt_tax')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                </div>
								
								{{-- WHT Toggle: แสดงเฉพาะกรณีติ๊กใบกำกับ + persona เป็นบริษัท --}}
								<div class="col_full" id="wht_block" style="display:none;">
									<div class="bottommargin-xs"><b>ภาษี ณ ที่จ่าย</b></div>

									<div class="inline">
										<input id="withholding_apply_0" class="radio-style" name="withholding_apply" type="radio" value="0" checked>
										<label for="withholding_apply_0" class="radio-style-2-label">ไม่หักภาษี ณ ที่จ่าย</label>
									</div>

									<div class="inline">
										<input id="withholding_apply_1" class="radio-style" name="withholding_apply" type="radio" value="1"
											@if(!empty(old('withholding_apply')) && old('withholding_apply')=='1') checked @endif
										>
										<label for="withholding_apply_1" class="radio-style-2-label">หักภาษี ณ ที่จ่าย</label>
									</div>

									<div class="small co-red" style="margin-top:6px;">
										*กรณีหักภาษี ณ ที่จ่าย กรุณาจัดส่งหนังสือรับรองการหัก ณ ที่จ่ายให้บริษัทภายหลัง<br>
										ที่อยู่สำหรับจัดส่งเอกสารหนังสือรับรองการหักภาษี ณ ที่จ่ายตัวจริง<br><br>

										แผนกการเงิน (ภาษี ณ ที่จ่าย)<br>
										บริษัท แอพพลิแคด จำกัด (มหาชน) สาขาสำนักงานใหญ่<br>
										เลขประจำตัวผู้เสียภาษีอากร 0107561000471<br>
										เลขที่ 69 ซอยสุขุมวิท 68 ถนนสุขุมวิท แขวงบางนาเหนือ เขตบางนา กรุงเทพมหานคร 10260
									</div>
								</div>
								
                                <div class="col_half ">
                                    ชื่อบริษัท
                                    <input type="text" placeholder="ชื่อบริษัท" id="receipt_company" name="receipt_company" class="sm-form-control @error('receipt_company') invalid @enderror" @if(!empty($usersReceipt->company)) value="{{ $usersReceipt->company }}" @else @if(!empty(old('receipt_company'))) value="{{ old('receipt_company') }}" @endif @endif>
                                    @error('receipt_company')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                </div>
                                <div class="col_half col_last">
                                    สาขา (ถ้ามี)
                                    <input type="text" placeholder="สาขา (ถ้ามี)" id="receipt_branch" name="receipt_branch" class="sm-form-control" @if(!empty($usersReceipt->branch)) value="{{ $usersReceipt->branch }}" @else @if(!empty(old('receipt_branch'))) value="{{ old('receipt_branch') }}" @endif @endif>
                                </div>
                                <div class="col_full bottommargin-xs">
                                    ชื่อ - สกุล <span class="span-danger">*</span>
                                </div>
                                <div class="col_half">
                                    <input type="text" placeholder="ชื่อ" id="receipt_name" name="receipt_name" class="sm-form-control @error('receipt_name') invalid @enderror" @if(!empty($usersReceipt->name)) value="{{ $usersReceipt->name }}" @else @if(!empty(old('receipt_name'))) value="{{ old('receipt_name') }}" @endif @endif>
                                    @error('receipt_name')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                </div>
                                <div class="col_half col_last">
                                    <input type="text" placeholder="นามสกุล" id="receipt_lastname" name="receipt_lastname" class="sm-form-control @error('receipt_lastname') invalid @enderror" @if(!empty($usersReceipt->lastname)) value="{{ $usersReceipt->lastname }}" @else @if(!empty(old('receipt_lastname'))) value="{{ old('receipt_lastname') }}" @endif @endif>
                                    @error('receipt_lastname')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                </div>
                                <div class="col_full">
                                    เบอร์โทรศัพท์ <span class="span-danger">*</span>
                                    <input type="text" placeholder="เบอร์โทรศัพท์" id="receipt_tel" name="receipt_tel" class="sm-form-control @error('receipt_tel') invalid @enderror" @if(!empty($usersReceipt->tel)) value="{{ $usersReceipt->tel }}" @else @if(!empty(old('receipt_tel'))) value="{{ old('receipt_tel') }}" @endif @endif>
                                    @error('receipt_tel')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                </div>
                                <div class="col_full">
                                    บ้านเลขที่ ถนน ซอย <span class="span-danger">*</span>
                                    <textarea placeholder="บ้านเลขที่ ถนน ซอย" id="receipt_address" name="receipt_address" class="sm-form-control @error('receipt_address') invalid @enderror">@if(!empty($usersReceipt->address)){{ $usersReceipt->address }}@else @if(!empty(old('receipt_address'))){{ old('receipt_address') }}@endif @endif</textarea>
                                    @error('receipt_address')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                </div>
                                <div class="col_half">
                                    จังหวัด <span class="span-danger">*</span>
                                    <select id="receipt_province" name="receipt_province" data-placeholder="กรุณาเลือกจังหวัด" class="sm-form-control @error('receipt_province') invalid @enderror" onchange="amphuresReceipt()">
                                        <option></option>
                                        @foreach ( $provinces as $province)
                                            <option value="{{ $province->id }}" @if(!empty($usersReceipt->province)) @if($usersReceipt->province == $province->id ) selected @endif @else @if(old('receipt_province') == $province->id ) selected @endif @endif>{{ $province->prov_name_th  }}</option>
                                        @endforeach
                                    </select>
                                    @error('receipt_province')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                    <input id="receipt_hd_province" name="receipt_hd_province" type="hidden" value="@if(!empty($usersReceipt->province)){{ $usersReceipt->province }}@endif">
                                </div>
                                <div class="col_half col_last">
                                    เขต/อำเภอ <span class="span-danger">*</span>
                                    <select id="receipt_amphures" name="receipt_amphures" data-placeholder="กรุณาเลือกเขต/อำเภอ" class="sm-form-control @error('receipt_amphures') invalid @enderror" onchange="districtReceipt()">
                                        <option></option>
                                    </select>
                                    @error('receipt_amphures')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                    <input id="receipt_hd_amphures" name="receipt_hd_amphures" type="hidden" value="@if(!empty($usersReceipt->amphures)){{ $usersReceipt->amphures }}@endif">
                                </div>
                                <div class="col_half">
                                    แขวง/ตำบล <span class="span-danger">*</span>
                                    <select id="receipt_district" name="receipt_district" data-placeholder="กรุณาเลือกแขวง / ตำบล" class="sm-form-control @error('receipt_district') invalid @enderror" onchange="zipcodeReceipt()">
                                        <option></option>
                                    </select>
                                    @error('receipt_district')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                    <input id="receipt_hd_district" name="receipt_hd_district" type="hidden" value="@if(!empty($usersReceipt->district)){{ $usersReceipt->district }}@endif">
                                </div>
                                <div class="col_half col_last">
                                    รหัสไปรษณีย์ <span class="span-danger">*</span>
                                    <input id="receipt_zipcode" name="receipt_zipcode" placeholder="กรุณากรอกรหัสไปรษณีย์" class="sm-form-control @error('receipt_zipcode') invalid @enderror" value="" />
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
                                <h4>ยอดรวม</h4>
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
                                                            <strong>ส่วนลดรวม <br/><small>{{ $condition->getName() }}</small></strong>
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
                                                            <strong>ราคาสุทธิสินค้า</strong>
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
                                                            <strong>ภาษีมูลค่าเพิ่ม</strong>
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
                                                        <strong>ยอดรวมสุทธิ</strong>
                                                    </td>
                                                    <td class="cart-total-name">
                                                        <span id="cartNettotal" class="amount">{{ number_format($total['nettotal'],2) }}.-</span>
                                                        <input type="hidden" name="priceNettotal" id="priceNettotal" value="{{ $total['nettotal'] }}" />
                                                    </td>
                                                </tr>
                                            @endif
											
												{{-- บุคคล --}}
												<input type="hidden" id="person_total_no_wht" value="{{ $total_person_no_wht['total'] }}">
												<input type="hidden" id="person_total_with_wht" value="{{ $total_person_with_wht['total'] }}">
												<input type="hidden" id="person_wht_amount" value="{{ $total_person_with_wht['withholding'] }}">

												{{-- บริษัท --}}
												<input type="hidden" id="company_total_no_wht" value="{{ $total_company_no_wht['total'] }}">
												<input type="hidden" id="company_total_with_wht" value="{{ $total_company_with_wht['total'] }}">
												<input type="hidden" id="company_wht_amount" value="{{ $total_company_with_wht['withholding'] }}">

												<tr class="cart_item" id="rowWithholding" style="display:none;">
													<td class="cart-product-name">
														<strong>หัก ภาษี ณ ที่จ่าย</strong>
													</td>
													<td class="cart-total-name">
														<span id="cartWithholding" class="amount">0.00.-</span>
														<input type="hidden" name="priceWithholding" id="priceWithholding" value="0" />
													</td>
												</tr>

                                            <tr class="cart_item">
                                                <td class="cart-product-name">
                                                    <strong>การจัดส่ง</strong>
                                                </td>

                                                <td class="cart-total-name">
                                                    <span class="amount">จัดส่งฟรี</span>
                                                </td>
                                            </tr>
                                            <tr class="cart_item">
                                                <td class="cart-product-name bg_eee"><strong>จำนวนเงินที่ต้องชำระ</strong></td>

                                                <td class="cart-total-name bg_eee">
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
                                    @if($settingPayment->bank_transfer_status == 1)
                                        <div>
                                            <input id="radio-bank" class="radio-style" name="radio_payment_type" value="1" type="radio" checked="">
                                            <label for="radio-bank" class="radio-style-2-label">โอนผ่านบัญชีธนาคาร</label>
                                        </div>
                                        <div id="content-bank">
                                            <div class="bottommargin-sm">ชำระเงินโดยโอนเงินเข้าบัญชีธนาคาร (เลขที่บัญชีธนาคารจะแสดงหลังจากกดปุ่ม “ชำระเงิน”) โดยหลังการชำระเงิน กรุณาส่งหลักฐานการยืนยันพร้อมเลขที่ใบสั่งซื้อ เพื่อทางเราจะได้ดำเนินการตรวจสอบต่อไป</div>
                                            <button id="btn_bank" type="submit" class="loadding button button-green btn-block btn-bank nomargin">
                                                <i class="icon-money"></i> “ชำระเงิน”
                                            </button>
                                        </div>
                                    @endif
									
									@if($settingPayment->promtpay_status == 1)
                                        <div>
                                            <input id="radio-promptpay" class="radio-style" name="radio_payment_type" value="4" type="radio">
                                            <label for="radio-promptpay" class="radio-style-2-label">พร้อมเพย์</label>
                                        </div>
                                        <div id="content-promptpay">
                                            <div class="bottommargin-sm">แสกนจ่ายผ่านคิวอาร์โค้ด (QR Code) รองรับทุกธนาคาร เมื่อชำระสำเร็จ รายการคำสั่งซื้อจะได้รับการอนุมัติทันที</div>
											<button id="btn_promptpay" class="button button-blue btn-block btn-promptpay nomargin">
                                                <i class="icon-qrcode"></i> ชำระเงิน
                                            </button>
                                        </div>
									@endif
										
									@if($settingPayment->mobile_banking_status == 1)
										<div>
                                            <input id="radio-mobile_banking" class="radio-style" name="radio_payment_type" value="5" type="radio">
                                            <label for="radio-mobile_banking" class="radio-style-2-label">โมบายแบงก์กิ้ง</label>
                                        </div>
                                        <div id="content-mobile_banking">
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
												ชำระเงิน
                                            </button>
                                        </div>
									@endif
									
                                    @if($settingPayment->installment_status == 1)
                                        <div>
                                            <input id="radio-installment" class="radio-style" name="radio_payment_type" value="2" type="radio">
                                            <label for="radio-installment" class="radio-style-2-label">ผ่อนชำระ</label>
                                        </div>
                                        <div id="content-installment">
											<div class="bottommargin-sm">
												เงื่อนไขการผ่อนชำระ:
												<ul>
													<li>ยอดชำระขั้นต่ำต้องไม่น้อยกว่า 3,000 บาท</li>
													<li>ยอดชำระสูงสุดที่ผ่อนได้ต้องไม่เกิน 150,000 บาท</li>
													<li>ลูกค้ารับภาระดอกเบี้ยในการผ่อนชำระ</li>
												</ul>
												@foreach ($settingInstallment as $installment)
												<div class="row b-installment">
													<div class="col-lg-2 col-md-2 col-sm-2 col-xs-3">
														<img width="42" height="42" class="lazyload" loading="lazy" data-src="{{ asset('storage/installment/'.$installment->installment_img) }}" alt="{{ $installment->installment_name }}" style="margin-top:10px; max-width: none;">
													</div>
													<div class="col-lg-10 col-md-10 col-sm-10 col-xs-9">{{ $installment->installment_name }}<br/><small>ระยะเวลา {{ $installment->installment_detail }}</small><br/><small>อัตราดอกเบี้ย <b style="color: red;">{{ $installment->interest_detail }}</b></small></div>
												</div>
												@endforeach
												<small style="color: red;">** อัตราดอกเบี้ยอาจมีการเปลี่ยนแปลงได้ ทั้งนี้ขึ้นอยู่กับโปรโมชั่นของธนาคารในแต่ละช่วง</small>
											</div>
											<button id="btn_installment" class="button button-pink btn-block btn-installment nomargin">
												เลือกธนาคารสำหรับผ่อนชำระ
                                            </button>
											<!--
                                            @if($settingPayment->omise_status == 3)
                                                <script type="text/javascript" src="https://cdn.omise.co/omise.js"
                                                    data-key="{{ $settingPayment->omise_public_key_for_test }}"
                                                    data-amount="{{ round($total['total'],2)*100 }}"
                                                    data-currency="THB"
                                                    data-zero_interest_installments="false"
                                                    data-default-payment-method="installment"
                                                    @if (!empty($setting->setting_iconWeb))
                                                    data-image="{{ asset('/storage/setting/' . $setting->setting_iconWeb) }}"
                                                    @endif
                                                    data-button-label="เลือกธนาคารสำหรับผ่อนชำระ"
                                                    data-frame-label="{{ $setting->setting_nameWeb }}"
                                                    data-submit-label="ยืนยัน"
                                                    >
                                                </script>
                                            @else
                                                <script type="text/javascript" src="https://cdn.omise.co/omise.js"
                                                    data-key="{{ $settingPayment->omise_public_key_for_live }}"
                                                    data-amount="{{ round($total['total'],2)*100 }}"
                                                    data-currency="THB"
                                                    data-zero_interest_installments="false"
                                                    data-default-payment-method="installment"
                                                    @if (!empty($setting->setting_iconWeb))
                                                    data-image="{{ asset('/storage/setting/' . $setting->setting_iconWeb) }}"
                                                    @endif
                                                    data-button-label="เลือกธนาคารสำหรับผ่อนชำระ"
                                                    data-frame-label="{{ $setting->setting_nameWeb }}"
                                                    data-submit-label="ยืนยัน"
                                                    >
                                                </script>
                                            @endif
											-->
                                        </div>
                                    @endif
                                    @if($settingPayment->credit_card_status == 1)
                                        <div>
                                            <input id="radio-creditcard" class="radio-style" name="radio_payment_type" value="3" type="radio">
                                            <label for="radio-creditcard" class="radio-style-2-label">บัตรเครดิต</label>
                                        </div>
                                        <div id="content-creditcard">
                                            <div class="payment-2c2p-card nomargin">
                                                <input type="hidden" id="public_key_omise" name="public_key_omise" value="@if($settingPayment->omise_status == 3){{ $settingPayment->omise_public_key_for_test }}@else{{$settingPayment->omise_public_key_for_live}}@endif" />
                                                <input type="hidden" name="omise_token">
                                                <div class="col_full">
                                                    <label>Card Holder Name :</label>
                                                    <input type="text"  class="sm-form-control" data-omise="holder_name" value="">
                                                </div>
                                                <div class="col_full">
                                                    <label>Credit Card Number :</label>
                                                    <input type="text"  class="sm-form-control" data-omise="number" value="">
                                                </div>
                                                <div class="col_half">
                                                    <label>month :</label>
                                                    <input type="text"  class="sm-form-control" data-omise="expiration_month" size="4" value="">
                                                </div>
                                                <div class="col_half col_last">
                                                    <label>year :</label>
                                                    <input type="text"  class="sm-form-control" data-omise="expiration_year" size="8" value="">
                                                </div>
                                                <div class="col_full">
                                                    <label>Security code :</label>
                                                    <input type="text"  class="sm-form-control" data-omise="security_code" size="8" value="">
                                                </div>
                                                <div id="token_errors"></div>
                                            </div>
                                            <br/>
                                            <button id="btn_creditcard" onclick="OmiseSubmit()" type="submit" class="button button-green btn-block btn-bank nomargin">
                                                <i class="icon-save"></i> ยืนยันการสั่งซื้อ
                                            </button>
                                        </div>

                                    @endif
									
									@if($settingPayment->truemoney_status == 1)
										<div>
											<input id="radio-truemoney" class="radio-style" name="radio_payment_type" value="6" type="radio">
											<label for="radio-truemoney" class="radio-style-2-label">ทรูมันนี่ วอลเล็ท</label>
										</div>
										<div id="content-truemoney">
											<div class="bottommargin-sm">
												ชำระเงินผ่าน TrueMoney Wallet
											</div>
											<button id="btn_truemoney" class="button button-amber btn-block btn-truemoney nomargin">
												ชำระเงิน
                                            </button>
										</div>
									@endif
                                </div>
                            @endif
                        </div>
                    </div>
					
					<!-- Insert Script In Form -->
					<script type="text/javascript" src="https://cdn.omise.co/omise.js"></script>
				    <script type="text/javascript">
					
						//var public_key_omise = $('#public_key_omise').val();
					
						// Set default parameters
						OmiseCard.configure({
							publicKey: "@if($settingPayment->omise_status == 3){{ $settingPayment->omise_public_key_for_test }}@else{{$settingPayment->omise_public_key_for_live}}@endif",
							@if (!empty($setting->setting_iconWeb))
							image: "{{ asset('/storage/setting/' . $setting->setting_iconWeb) }}",
							@endif
							frameLabel: '{{ $setting->setting_nameWeb }}',
							zero_interest_installments: false,
						});
						
						var form = document.querySelector("#paymentForm");
						
						@if($settingPayment->promtpay_status == 1)
						btn_omise('btn_promptpay', 'promptpay');
						@endif
						
						@if($settingPayment->installment_status == 1)
						btn_omise('btn_installment', 'installment');
						@endif
						
						@if($settingPayment->truemoney_status == 1)
						btn_omise('btn_truemoney', 'truemoney');
						@endif
						
						function btn_omise(btn_id, paymentmethod){
							
							var button = document.querySelector("#"+btn_id);

							button.addEventListener("click", (event) => {
								
								event.preventDefault();
								
								OmiseCard.open({
									amount: "{{ round($total['total'],2)*100 }}",
									currency: "THB",
									locale: "TH",
									defaultPaymentMethod: paymentmethod,
									onCreateTokenSuccess: (nonce) => {
										if(nonce.startsWith("tokn_")){
											form.omiseToken.value = nonce;
										}else{
											form.omiseSource.value = nonce;
										};
										form.submit();
									}
								});
							});
						}
					</script>
					<input type="hidden" id="omiseToken" name="omiseToken">
					<input type="hidden" id="omiseSource" name="omiseSource"> 
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
                </form>
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
            1 => 'คุณมีคูปองนี้ในระบบแล้ว.',
            2 => 'คูปองนี้หมดอายุแล้ว ไม่สามารถใช้งานได้.',
            3 => 'คูปองนี้ไม่สามารถใช้งานได้ เนื่องจากมีผู้ใช้ครบจำนวนที่กำหนดไว้แล้ว.',
            4 => 'ไม่สามารถใช้คูปองได้ เนื่องจากมีการใช้ครบตามจำนวนที่กำหนดแล้ว.',
            5 => 'ไม่สามารถใช้คูปองได้ เนื่องจากราคาสินค้าน้อยกว่าที่กำหนด.',
            6 => 'ไม่สามารถใช้คูปองได้ เนื่องจากราคาสินค้ามากกว่าที่กำหนด.',
            7 => 'ไม่สามารถใช้คูปองได้ เนื่องจากสินค้าไม่ได้เข้าร่วมกับส่วนลดนี้.',
            8 => 'ไม่สามารถใช้คูปองได้ เนื่องจากสินค้าในหมวดหมู่ไม่ได้เข้าร่วมกับส่วนลดนี้.',
            9 => 'ไม่สามารถใช้คูปองได้ เนื่องจากยังไม่มีสินค้าในตะกร้าสินค้า.',
            10 => 'ไม่สามารถใช้คูปองได้ เนื่องจากคูปองนี่ไม่สามารถใช้ร่วมกับสินค้าลดราคาได้.',
        ];
        $code = session('invalid');
    @endphp
    {{-- แจ้งด้วย alert() --}}
    <script>
        alert(@json($msgs[$code]));
    </script>
@endif

<script>
(function(){
  // ปุ่มทั้งหมดที่ต้องการเช็ค
  const selectors = [
    '#btn_truemoney',
    '#btn_creditcard',
    '#btn_installment',
    '#btn_mobile_banking',
    '#btn_promptpay',
    '#btn_bank'
  ].join(',');

  // ดักคลิก ด้วย namespace "validateCoupon"
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
          // กลับไปหน้า cart เพื่อให้ user เลือกคูปองใหม่
          window.location.href = "{{ route('fronend.cart') }}";
        } else {
          // ลบ handler ตัวนี้ออกก่อน แล้วคืนค่าคลิกเดิม
          $btn.removeEventListener('click', _handler);
          $btn.click();
        }
      })
      .catch(() => {
        // ถ้า AJAX ล้มเหลว: ปล่อยให้คลิกปกติ
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

  const $personaCompany = document.querySelector('#receipt_persona_type_2');
  const $personaPerson  = document.querySelector('#receipt_persona_type_1');

  const $rowWht = document.querySelector('#rowWithholding');

  const $totalSpan = document.querySelector('span#totalCart');     // span
  const $totalInput = document.querySelector('input#totalCart');   // input (ในโค้ดคุณซ้ำ id)

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

    // โชว์/ซ่อนบล็อกปุ่ม
    if ($whtBlock) $whtBlock.style.display = showWht ? '' : 'none';

    // ถ้าไม่เข้าเงื่อนไข ให้บังคับเป็น "ไม่หัก"
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


  // bind events
  if ($chkReceipt) $chkReceipt.addEventListener('change', updateWhtUI);
  document.querySelectorAll('input[name="receipt_persona_type"]').forEach(el => el.addEventListener('change', updateWhtUI));
  document.querySelectorAll('input[name="withholding_apply"]').forEach(el => el.addEventListener('change', updateTotals));

  // initial
  updateWhtUI();
})();
</script>

 @endsection

