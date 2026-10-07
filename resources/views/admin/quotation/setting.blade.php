@extends('layouts.temp_admin')
@section('title'){{$title_page}}@endsection

@section('css')
 <!-- select2 -->
 <link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet" />
 <!-- select2-bootstrap4-theme -->
 <link href="{{ asset('vendor/select2-bootstrap4-theme/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">

 <style>
    .jumbotron { padding: 1rem; margin-bottom: 1rem; }
 </style>
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        @if(empty($data))
            {{
                Form::open([
                    'novalidate',
                    'route' => 'quotation.setting.crate',
                    'id'=>'data-form',
                    'method' => 'post',
                    'files' => true
                ])
            }}
        @else
            {{
                Form::model($data, [
                    'novalidate',
                    'route' => ['quotation.setting.update',[$data->id]],
                    'id'=>'data-form',
                    'method' => 'put',
                    'files' => true
                ])
            }}
        @endif

            <div class="row">
                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>TAX ID<span class="text-danger">*</span></label>
                                        <input class="form-control" id="tax_id" name="tax_id" value="@if(!empty($data->tax_id)){{ $data->tax_id }}@else{{ old('tax_id') }}@endif" />
                                        @error('tax_id')<small class="error-danger-text">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>ชื่อบริษัท<span class="text-danger">*</span></label>
                                        <input class="form-control" id="company_name" name="company_name" value="@if(!empty($data->company_name)){{ $data->company_name }}@else{{ old('company_name') }}@endif" />
                                        @error('company_name')<small class="error-danger-text">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>ที่อยู่ <span class="text-danger">*</span></label>
                                        <textarea class="form-control" id="company_address" name="company_address" >@if(!empty($data->company_address)){{ $data->company_address }}@else{{ old('company_address') }}@endif</textarea>
                                        @error('company_address')<small class="error-danger-text">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>เบอร์โทรศัพท์<span class="text-danger">*</span></label>
                                        <input class="form-control" id="company_tel" name="company_tel" value="@if(!empty($data->company_tel)){{ $data->company_tel }}@else{{ old('company_tel') }}@endif" />
                                        @error('company_tel')<small class="error-danger-text">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>FAX</label>
                                        <input class="form-control" id="company_fax" name="company_fax" value="@if(!empty($data->company_fax)){{ $data->company_fax }}@else{{ old('company_fax') }}@endif" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>ภาษีมูลค่าเพิ่ม <span class="text-danger">*ใส่เฉพาะตัวเลข</span></label>
                                        <input class="form-control" id="company_vat" name="company_vat" value="@if(!empty($data->company_vat)){{ $data->company_vat }}@else{{ old('company_vat') }}@endif" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>หักภาษี ณ ที่จ่าย <span class="text-danger">*ใส่เฉพาะตัวเลข</span></label>
                                        <input class="form-control" id="company_withheld" name="company_withheld" value="@if(!empty($data->company_withheld)){{ $data->company_withheld }}@else{{ old('company_withheld') }}@endif" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>หมายเหตุ</label>
                                        <textarea class="form-control" id="quotation_note" name="quotation_note" >@if(!empty($data->quotation_note)){{ $data->quotation_note }}@else{{ old('quotation_note') }}@endif</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>ระยะเวลาการจัดส่ง</label>
                                        <textarea class="form-control" id="quotation_transfer" name="quotation_transfer" >@if(!empty($data->quotation_transfer)){{ $data->quotation_transfer }}@else{{ old('quotation_transfer') }}@endif</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>เงื่อนไขการชำระเงิน</label>
                                        <textarea class="form-control" id="quotation_payment" name="quotation_payment" >@if(!empty($data->quotation_payment)){{ $data->quotation_payment }}@else{{ old('quotation_payment') }}@endif</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="line"></div>
                            <div class="form-group has-label">
                                @if(!empty($data->created_by))<label>เพิ่มข้อมูลโดย :: {{ $data->created_by}} :: {{ $data->created_at}} </label>@endif
                                @if(!empty($data->updated_by))<br/><label>อัพเดตข้อมูลโดย :: {{ $data->updated_by}} :: {{ $data->updated_at}} </label>@endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="jumbotron">
                                บันทึกแบบร่าง / เผยแพร่
                            </div>
                            <div class="form-group">
                                <input name="show" id="show" class="bootstrap-switch" type="checkbox" data-toggle="switch" data-on-label="<i class='nc-icon nc-check-2'></i>" data-off-label="<i class='nc-icon nc-simple-remove'></i>" data-on-color="success" data-off-color="success"
                                @if(!empty($data->show))
                                    @if($data->show == 1) checked @endif
                                @else checked @endif
                                />
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    @if(!empty($data->logo_company))
                                    <a href="#" class="remove-logo" data-toggle="modal" data-target="#deleteThump_pro" onclick="deleteModal4(this)" href="#" data-id="{{ $data->id }}" data-name="{{ $data->logo_company }}">
                                        <button class="btn btn-icon btn-round btn-google" type="button">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </a>
                                    @endisset
                                    <div class="text-align-center">
                                        @isset($data->logo_company)
                                            <input type="hidden" class="form-control" id="logo_company_old" name="logo_company_old" value="{{ $data->logo_company }}">
                                            <img id="blah1" src="{{ asset('storage/setting/'.$data->logo_company) }}" alt="" class="full-width" rel="nofollow">
                                        @else
                                            <img id="blah1" src="{{ asset('images/default-img/no-img.jpg')}}" alt="..." class="full-width" rel="nofollow">
                                        @endisset
                                    </div>
                                    <br/>
                                    <label>โลโก้บริษัท</label>
                                    <input type="file" accept="image/*" class="form-control" id="logo_company" name="logo_company" onchange="readURL1(this);">
                                    <small>ขนาดภาพแนะนำ 300 X 300 PX</small><br/>
                                    <small class="error-danger-text">* หากไฟล์ภาพมีขนาดไม่เท่ากับที่กำหนด ไฟล์จะบีบอัดอัตโนมัติเพื่อให้ได้ขนาดที่ต้องการ (อาจทำให้ภาพยืดหรือหดได้)</small><br/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-6"></div>
                                <div class="col-6 right">
                                    @include('layouts.admin._button.submit')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>

@endsection


@section('js')
    <!-- select2 -->
    <script src="{{ asset('vendor/select2/select2.min.js') }}"></script>
    <!-- select2-bootstrap4-theme -->
    <script src="{{ asset('vendor/select2-bootstrap4-theme/docs/script.js') }}"></script>

@endsection
