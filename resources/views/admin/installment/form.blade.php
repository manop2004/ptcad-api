@extends('layouts.temp_admin')
@section('title'){{$title_page}}@endsection

@section('css')
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
                    'route' => 'installment.crate',
                    'id'=>'data-form',
                    'method' => 'post',
                    'files' => true
                ])
            }}
        @else
            {{
                Form::model($data, [
                    'novalidate',
                    'route' => ['installment.update',[$data->id]],
                    'id'=>'data-form',
                    'method' => 'put',
                    'files' => true
                ])
            }}
        @endif

            <div class="row">
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="form-group has-label">
                                        <label>ชื่อธนาคาร<span class="text-danger">*</span></label>
                                        <input class="form-control no-max-height" id="installment_name" name="installment_name" value="@if(!empty($data->installment_name)){{ $data->installment_name }}@else{{ old('installment_name') }}@endif" />
                                        @error('installment_name')<small class="error-danger-text">{{ $message }}</small><br/>@enderror
                                    </div>
                                    <div class="form-group has-label">
                                        <label>รายละเอียดการผ่อนชำระ<span class="text-danger">*</span></label>
                                        <input class="form-control no-max-height" id="installment_detail" name="installment_detail" value="@if(!empty($data->installment_detail)){{ $data->installment_detail }}@else{{ old('installment_detail') }}@endif" />
                                        @error('installment_detail')<small class="error-danger-text">{{ $message }}</small><br/>@enderror
                                    </div>
									<div class="form-group has-label">
                                        <label>อัตราดอกเบี้ยที่ผู้ซื้อรับภาระ<span class="text-danger">*</span></label>
                                        <input class="form-control no-max-height" id="interest_detail" name="interest_detail" value="@if(!empty($data->interest_detail)){{ $data->interest_detail }}@else{{ old('interest_detail') }}@endif" />
                                        @error('interest_detail')<small class="error-danger-text">{{ $message }}</small><br/>@enderror
                                    </div>
                                    <div class="has-label">
                                        <label>โลโก้ข้อมูลการผ่อนชำระ<span class="text-danger">*</span></label>
                                        <input type="file" accept="image/*" class="form-control" id="installment_img" name="installment_img" onchange="readURL1(this);">
                                        @error('installment_img')<small class="error-danger-text">{{ $message }}</small><br/>@enderror
                                        <small>ขนาดไฟล์ คือ 300 X 300 PX</small><br/>
                                        <small class="error-danger-text">* หากไฟล์ภาพมีขนาดไม่เท่ากับที่กำหนด ไฟล์จะบีบอัดอัตโนมัติเพื่อให้ได้ขนาดที่ต้องการ (อาจทำให้ภาพยืดหรือหดได้)</small>
                                        <br/>
                                        <br/>
                                    </div>
                                    @if(!empty($data->updated_by))
                                        <div class="line"></div>
                                        <div class="form-group has-label">
                                            <label>อัพเดตข้อมูลโดย :: {{ $data->updated_by}} :: {{ $data->updated_at}} </label>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-5">
                                    <br/>
                                    <div class="form-group text-align-center">
                                        @if(!empty($data->installment_img))
                                        <a href="#" class="remove-logo" data-toggle="modal" data-target="#deleteImg" onclick="deleteModal(this)" href="#" data-id="{{ $data->id }}" data-name="{{ $data->installment_img }}">
                                            <button class="btn btn-icon btn-round btn-google" type="button">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </a>
                                        @endisset
                                        @if(!empty($data->installment_img))
                                            <input type="hidden" class="form-control" id="installment_img_old" name="installment_img_old" value="{{ $data->installment_img }}">
                                            <img id="blah1" src="{{ asset('storage/installment/'.$data->installment_img) }}" alt="" class="full-width border_img" rel="nofollow">
                                        @else
                                            <img id="blah1" src="{{ asset('images/default-img/default-banner_2048_587.jpg')}}" alt="..." class="full-width border_img" rel="nofollow">
                                        @endisset
                                    </div>
                                </div>
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
                                <input name="installment_show" id="installment_show" class="bootstrap-switch" type="checkbox" data-toggle="switch" data-on-label="<i class='nc-icon nc-check-2'></i>" data-off-label="<i class='nc-icon nc-simple-remove'></i>" data-on-color="success" data-off-color="success"
                                @if(!empty($data->installment_show))
                                    @if($data->installment_show == 1) checked @endif
                                @else checked @endif
                                />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-6">
                                    <a href="{{ route('installment.index')}}">
                                        @include('layouts.admin._button.back')
                                    </a>
                                </div>
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


@include('admin.installment.modal.deleteImg')

@endsection

@section('js')


@endsection
