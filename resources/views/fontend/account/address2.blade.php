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
    button[type="submit"]{
        margin: 0 !important
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
                <div class="section-nav-account topmargin-sm bottommargin-sm">
                    <div class="nav-account hidden-sm hidden-xs">
                        <div class="list-group">
                            <a href="{{ route('fronend.account') }}" class="list-group-item"><img class="icon-left-profile" src="{{ asset('icons/profile/user-1.png') }}" /> ข้อมูลส่วนตัว</a></a>
                            <a href="{{ route('fronend.account.order') }}" class="list-group-item"><img class="icon-left-profile" src="{{ asset('icons/profile/cart-1.png') }}" />คำสั่งซื้อ</a></a>
                            <a href="{{ route('fronend.account.software') }}" class="list-group-item"><img class="icon-left-profile" src="{{ asset('icons/profile/software-1.png') }}" />ซอฟต์แวร์ของฉัน</a></a>
                            <a href="{{ route('fronend.account.coupon') }}" class="list-group-item"><img class="icon-left-profile" src="{{ asset('icons/profile/discount-1.png') }}" />โค้ดส่วนลดของฉัน</a></a>
                            <a href="{{ route('fronend.account.quotation') }}" class="list-group-item"><img class="icon-left-profile" src="/icons/profile/quotation-1.png" />ใบเสนอราคา</a></a>
                            <a href="{{ route('fronend.account.address') }}" class="list-group-item"><img class="icon-left-profile" src="{{ asset('icons/profile/map-2.png') }}" />ที่อยู่จัดส่ง</a></a>
                            <a href="{{ route('fronend.account.changepassword') }}" class="list-group-item"><img class="icon-left-profile" src="{{ asset('icons/profile/password-1.png') }}" />เปลี่ยนรหัสผ่าน</a></a>
                            <a href="{{ route('fronend.account.pdpa') }}" class="list-group-item"><img class="icon-left-profile" src="{{ asset('icons/profile/letter-1.png') }}" />รับข้อมูลข่าวสารและบัญชี</a></a>
                            <a href="{{ route('user.logout') }}" class="list-group-item"><img class="icon-left-profile" src="{{ asset('icons/profile/exit.png') }}" />ออกจากระบบ</a></a>
                        </div>
                    </div>
                    <div class="account-content">
                        <div class="hidden-lg hidden-md backTomenu_account">
                            <a href="{{ route('fronend.account.menu') }}">
                                <img class="icon-left-profile" src="{{ asset('icons/icon-left-black.png') }}" />
                                กลับเมนูหลัก
                            </a>
                        </div>
                        <div>
                            <div class="tabs clearfix" id="tab-3">
                                <ul class="tab-nav tab-nav2 clearfix">
                                    <li><a href="#tabs-address">ที่อยู่สำหรับจัดส่งสินค้า </a></li>
                                    <li><a href="#tabs-receipt">ที่อยู่สำหรับจัดส่งใบเสร็จรับเงิน</a></li>
                                </ul>
                                <div class="tab-container">
                                    <div class="tab-content clearfix" id="tabs-address">

                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                ข้อมูลไม่ถูกต้อง กรุณาตรวจสอบข้อมูลก่อนบันทึกอีกครั้ง!!
                                            </div>
                                        @endif

                                        @if(empty($usersAddress))
                                            {{
                                                Form::open([
                                                    'novalidate',
                                                    'route' => 'fronend.account.address.crate',
                                                    'id'=>'address-form',
                                                    'method' => 'post',
                                                    'files' => true
                                                ])
                                            }}
                                        @else
                                            {{
                                                Form::model($usersAddress, [
                                                    'novalidate',
                                                    'route' => ['fronend.account.address.update',[$usersAddress->id]],
                                                    'id'=>'address-form',
                                                    'method' => 'put',
                                                    'files' => true
                                                ])
                                            }}
                                        @endif
										
										<div class="b_order">
											<div class="row">
												<div class="col-md-6">
													<span class="label label-success"><i class="icon-ok-circle"></i> ที่อยู่หลัก</span>
													
												</div>
												<div class="col-md-6 text-right">
													<h5><i class="icon-edit"></i> แก้ไขที่อยู่</h5>
												</div>
											</div>
											<div class="row">
												<div class="col-md-12">
													บริษัท แอพพลิแคด จำกัด (มหาชน) เลขที่ 69 ซอยสุขุมวิท 68 ถนนสุขุมวิท แขวงบางนาเหนือ เขตบางนา กรุงเทพฯ 10260
												</div>
											</div>
										</div>
										
										
										
                                            @if(!empty($usersAddress))
                                                <input id="address_province" name="address_province" type="hidden" value="{{ $usersAddress->province }}">
                                                <input id="address_amphures" name="address_amphures" type="hidden" value="{{ $usersAddress->amphures }}">
                                                <input id="address_district" name="address_district" type="hidden" value="{{ $usersAddress->district }}">
                                                <input id="address_zipcode" name="address_zipcode" type="hidden" value="{{ $usersAddress->zipcode }}">
                                            @endif
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>ชื่อ <span class="text-danger">*</span></label>
                                                        <input id="userId" name="userId" type="hidden" class="sm-form-control" placeholder="" value="{{ Auth::user()->id }}">
                                                        <input id="name" name="name" type="text" class="sm-form-control" placeholder="" value="@if(!empty($usersAddress->name)){{ $usersAddress->name }}@else{{ old('name') }}@endif">
                                                        @error('name')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>สกุล <span class="text-danger">*</span></label>
                                                        <input id="lastname" name="lastname" type="text" class="sm-form-control" value="@if(!empty($usersAddress->lastname)){{ $usersAddress->lastname }}@else{{ old('lastname') }}@endif">
                                                        @error('lastname')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>เบอร์โทรศัพท์ <span class="text-danger">*</span></label>
                                                        <input id="tel" name="tel" type="text" class="sm-form-control" value="@if(!empty($usersAddress->tel)){{ $usersAddress->tel }}@else{{ old('tel') }}@endif">
                                                        @error('tel')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>บ้านเลขที่ ถนน ซอย <span class="text-danger">*</span></label>
                                                        <textarea id="address" name="address" type="text" class="sm-form-control" placeholder="" >@if(!empty($usersAddress->address)){{ $usersAddress->address }}@else{{ old('address') }}@endif</textarea>
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
                                                            @foreach ( $provinces as $province)
                                                                <option value="{{ $province->id }}" @if(!empty($usersAddress->province)) @if($province->id ==  $usersAddress->province) selected @endif @else @if(old('province') == $province->id ) selected @endif @endif>{{ $province->prov_name_th  }}</option>
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
                                                        <textarea id="message" name="message" type="text" class="sm-form-control" placeholder="" >@if(!empty($usersAddress->message)){{ $usersAddress->message }}@else{{ old('message') }}@endif</textarea>
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
                                        </form>
                                    </div>
                                    <div class="tab-content clearfix" id="tabs-receipt">

                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                ข้อมูลไม่ถูกต้อง กรุณาตรวจสอบข้อมูลก่อนบันทึกอีกครั้ง!!
                                            </div>
                                        @endif
                                        
                                        @if(empty($usersReceipt))
                                            {{
                                                Form::open([
                                                    'novalidate',
                                                    'route' => 'fronend.account.receipt.crate',
                                                    'id'=>'receipt-form',
                                                    'method' => 'post',
                                                    'files' => true
                                                ])
                                            }}
                                        @else
                                            {{
                                                Form::model($usersReceipt, [
                                                    'novalidate',
                                                    'route' => ['fronend.account.receipt.update',[$usersReceipt->id]],
                                                    'id'=>'receipt-form',
                                                    'method' => 'put',
                                                    'files' => true
                                                ])
                                            }}
                                        @endif
                                            <input id="receipt_hd_province" name="receipt_hd_province" type="hidden" value="@if(!empty($usersReceipt->province)){{ $usersReceipt->province }}@endif">
                                            <input id="receipt_hd_amphures" name="receipt_hd_amphures" type="hidden" value="@if(!empty($usersReceipt->amphures)){{ $usersReceipt->amphures }}@endif">
                                            <input id="receipt_hd_district" name="receipt_hd_district" type="hidden" value="@if(!empty($usersReceipt->district)){{ $usersReceipt->district }}@endif">
                                            <input id="receipt_hd_zipcode" name="receipt_hd_zipcode" type="hidden" value="@if(!empty($usersReceipt->zipcode)){{ $usersReceipt->zipcode }}@endif">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="inline">
                                                            <input id="receipt_persona_type_1" class="radio-style " name="receipt_persona_type" type="radio" value="1" @if(!empty($type)) @if($type == 1) checked @endif @else checked @endif>
                                                            <label for="receipt_persona_type_1" class="radio-style-1-label radio-small noleftmargin">บุคคลธรรมดา</label>
                                                        </div>
                                                        <div class="inline">
                                                            <input id="receipt_persona_type_2" class="radio-style " name="receipt_persona_type" type="radio" value="2" @if(!empty($type)) @if($type == 2) checked @endif @endif>
                                                            <label for="receipt_persona_type_2" class="radio-style-1-label radio-small noleftmargin">บริษัท/สำนักงาน/องค์กร</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>เลขประจำตัวผู้เสียภาษี <span class="text-danger">*</span></label>
                                                        <input id="receipt_taxid" name="receipt_taxid" type="text" class="sm-form-control" placeholder="" @if(!empty(old('receipt_taxid'))) value="{{ old('receipt_taxid') }}" @else @if(!empty($usersReceipt->taxid)) value="{{ $usersReceipt->taxid}}" @endif @endif>
                                                        @error('receipt_taxid')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>บริษัท </label>
                                                        <input id="receipt_company" name="receipt_company" type="text" class="sm-form-control" placeholder="" @if(!empty(old('receipt_company'))) value="{{ old('receipt_company') }}" @else @if(!empty($usersReceipt->company)) value="{{ $usersReceipt->company}}" @endif @endif>
                                                        @error('receipt_company')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>สาขา (ถ้ามี)</label>
                                                        <input id="receipt_branch" name="receipt_branch" type="text" class="sm-form-control" @if(!empty(old('receipt_branch'))) value="{{ old('receipt_branch') }}" @else @if(!empty($usersReceipt->branch)) value="{{ $usersReceipt->branch }}" @endif @endif>
                                                        @error('receipt_branch')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>ชื่อ <span class="text-danger">*</span></label>
                                                        <input id="receipt_userId" name="receipt_userId" type="hidden" class="sm-form-control" placeholder="" value="{{ Auth::user()->id }}">
                                                        <input id="receipt_name" name="receipt_name" type="text" class="sm-form-control" placeholder="" @if(!empty(old('receipt_name'))) value="{{ old('receipt_name') }}" @else @if(!empty($usersReceipt->name)) value="{{ $usersReceipt->name }}" @endif @endif>
                                                        @error('receipt_name')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>สกุล <span class="text-danger">*</span></label>
                                                        <input id="receipt_lastname" name="receipt_lastname" type="text" class="sm-form-control" @if(!empty(old('receipt_lastname'))) value="{{ old('receipt_lastname') }}" @else @if(!empty($usersReceipt->lastname)) value="{{ $usersReceipt->lastname }}" @endif @endif >
                                                        @error('receipt_lastname')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>เบอร์โทรศัพท์ <span class="text-danger">*</span></label>
                                                        <input id="receipt_tel" name="receipt_tel" type="text" class="sm-form-control" @if(!empty(old('receipt_tel'))) value="{{ old('receipt_tel') }}" @else @if(!empty($usersReceipt->tel)) value="{{ $usersReceipt->tel }}" @endif @endif>
                                                        @error('receipt_tel')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>บ้านเลขที่ ถนน ซอย <span class="text-danger">*</span></label>
                                                        <textarea id="receipt_address" name="receipt_address" type="text" class="sm-form-control" placeholder="" >@if(!empty($usersReceipt->address)){{ $usersReceipt->address }}@else{{ old('receipt_address') }}@endif</textarea>
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
                                                            @foreach ( $provinces as $province)
                                                                <option value="{{ $province->id }}" @if(!empty($usersReceipt->province)) @if($usersReceipt->province == $province->id ) selected @endif @else @if(old('receipt_province') == $province->id ) selected @endif @endif>{{ $province->prov_name_th  }}</option>
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
                                                        <textarea id="message" name="message" type="text" class="sm-form-control" placeholder="" >@if(!empty($usersReceipt->message)){{ $usersReceipt->message }}@else{{ old('message') }}@endif</textarea>
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
                                        </form>
                                    </div>
                                </div>
                            </div>
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


@endsection

