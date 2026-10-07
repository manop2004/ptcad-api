@extends('layouts.temp_admin')
@section('title'){{$title_page}}@endsection

@section('css')
 <!-- select2 -->
 <link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet" />
 <!-- select2-bootstrap4-theme -->
 <link href="{{ asset('vendor/select2-bootstrap4-theme/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">

 <link href="{{ asset('assets/backend/css/paper-dashboard.css') }}" rel="stylesheet" />

 <style>
    .card-user .image { height: 80px; }
    .jumbotron {
        padding: 1rem;
        margin-bottom: 1rem;
    }
 </style>
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">

        @if(empty($data))
            {{
                Form::open([
                    'novalidate',
                    'route' => 'getmember.crate',
                    'id'=>'data-form',
                    'method' => 'post',
                    'files' => true
                ])
            }}
        @else
            {{
                Form::model($data, [
                    'novalidate',
                    'route' => ['getmember.setting.update',[$data->id]],
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
                        <div class="has-label">
                            <label>รูปภาพเชิญชวนให้แนะนำสมาชิก <span class="text-danger">*</span></label>
                            <input type="file" accept="image/*" class="form-control" id="getmember_thumb" name="getmember_thumb" onchange="readURL1(this);">
                            <small class="error-danger-text">* หากไฟล์ภาพมีขนาดไม่เท่ากับที่กำหนด ไฟล์จะบีบอัดอัตโนมัติเพื่อให้ได้ขนาดที่ต้องการ (อาจทำให้ภาพยืดหรือหดได้)</small>
                            <br/>
                            <br/>
                        </div>
                        <div class="form-group has-label">
                            <label >สิ่งที่ผู้แนะนำจะได้รับ <span class="text-danger">*</span></label>
                            <input type="hidden" id="getmember_ref" name="getmember_ref" value="1" />
                            <select onchange="getmember_ref_Change(this.value)" class="form-control" id="getmember_ref_type" name="getmember_ref_type" >
                                <option value="1" @if(!empty($data->getmember_ref_type)) @if($data->getmember_ref_type==1) selected @endif @else @if(!empty(old('getmember_ref_type'))) @if(old('getmember_ref_type') == 1) selected @endif @else selected @endif @endif>Cash Card</option>
                                <option value="2" @if(!empty($data->getmember_ref_type)) @if($data->getmember_ref_type==2) selected @endif @else @if(!empty(old('getmember_ref_type'))) @if(old('getmember_ref_type') == 2) selected @endif @endif @endif>คูปอง</option>
                            </select>
                        </div>
                        <div id="b_getmember_ref_cashcard" class="form-group has-label @if(!empty($data->getmember_ref_type)) @if($data->getmember_ref_type==2) hidden @endif @else @if(old('getmember_ref_type') == 2) hidden @endif @endif">
                            <label>รายละเอียด <span class="text-danger">*</span></label>
                            <textarea  class="form-control" id="getmember_ref_detail" name="getmember_ref_detail" >@if(!empty($data->getmember_ref_detail)){{ $data->getmember_ref_detail}}@else @if(!empty(old('getmember_ref_detail'))){{old('getmember_ref_detail')}}@endif @endif</textarea>
                        </div>
                        <div id="b_getmember_ref_coupon" class="form-group has-label @if(!empty($data->getmember_ref_type)) @if($data->getmember_ref_type==1) hidden @endif @else @if(!empty(old('getmember_ref_type'))) @if(old('getmember_ref_type') == 1) hidden @endif @else hidden @endif @endif">
                            <label>รหัสคูปอง <span class="text-danger">*</span></label>
                            <input  class="form-control" id="getmember_ref_coupon" name="getmember_ref_coupon" value="@if(!empty($data->getmember_ref_coupon)){{ $data->getmember_ref_coupon}}@else @if(!empty(old('getmember_ref_coupon'))){{old('getmember_ref_coupon')}}@endif @endif" />
                            @error('getmember_ref_coupon')<small class="error-danger-text">{{ $message }}</small><br/>@enderror
                        </div>
                        <hr/>
                        <div class="form-group has-label">
                            <label>สิ่งที่ผู้ถูกแนะนำจะได้รับ <span class="text-danger">*</span></label>
                            <input type="hidden" id="getmember_recommender" name="getmember_recommender" value="2">
                            <select onchange="getmember_recommender_type_Change(this.value)" class="form-control" id="getmember_recommender_type" name="getmember_recommender_type" >
                                <option value="1" @if(!empty($data->getmember_recommender_type)) @if($data->getmember_recommender_type==1) selected @endif @else @if(!empty(old('getmember_recommender_type'))) @if(old('getmember_recommender_type') == 1) selected @endif @else selected @endif @endif>Cash Card</option>
                                <option value="2" @if(!empty($data->getmember_recommender_type)) @if($data->getmember_recommender_type==2) selected @endif @else @if(!empty(old('getmember_recommender_type'))) @if(old('getmember_recommender_type') == 2) selected @endif @endif @endif>คูปอง</option>
                            </select>
                        </div>
                        <div id="b_getmember_recommender_cashcard" class="form-group has-label @if(!empty($data->getmember_recommender_type)) @if($data->getmember_recommender_type==2) hidden @endif @else @if(old('getmember_recommender_type') == 2) hidden @endif @endif">
                            <label>รายละเอียด <span class="text-danger">*</span></label>
                            <textarea  class="form-control" id="getmember_recommender_detail" name="getmember_recommender_detail" >@if(!empty($data->getmember_recommender_detail)){{ $data->getmember_recommender_detail}}@else @if(!empty(old('getmember_recommender_detail'))){{old('getmember_recommender_detail')}}@endif @endif</textarea>
                        </div>
                        <div id="b_getmember_recommender_coupon" class="form-group has-label @if(!empty($data->getmember_recommender_type)) @if($data->getmember_recommender_type==1) hidden @endif @else @if(!empty(old('getmember_recommender_type'))) @if(old('getmember_recommender_type') == 1) hidden @endif @else hidden @endif @endif">
                            <label>รหัสคูปอง <span class="text-danger">*</span></label>
                            <input  class="form-control" id="getmember_recommender_coupon" name="getmember_recommender_coupon" value="@if(!empty($data->getmember_recommender_coupon)){{ $data->getmember_recommender_coupon}}@else @if(!empty(old('getmember_recommender_coupon'))){{old('getmember_recommender_coupon')}}@endif @endif"/>
                            @error('getmember_recommender_coupon')<small class="error-danger-text">{{ $message }}</small><br/>@enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group text-align-center">
                            @if(!empty($data->getmember_thumb))
                            <a href="#" class="remove-logo" data-toggle="modal" data-target="#deleteImg" onclick="deleteModal(this)" href="#" data-id="{{ $data->id }}" data-name="{{ $data->getmember_thumb }}">
                                <button class="btn btn-icon btn-round btn-google" type="button">
                                    <i class="fa fa-times"></i>
                                </button>
                            </a>
                            @endisset
                            @isset($data->getmember_thumb)
                                <input type="hidden" class="form-control" id="getmember_thumb_old" name="getmember_thumb_old" value="{{ $data->getmember_thumb }}">
                                <img id="blah1" src="{{ asset('storage/getmember/'.$data->getmember_thumb) }}" alt="" class="full-width border_img" rel="nofollow">
                            @else
                                <img id="blah1" src="{{ asset('images/default-img/default-banner_2048_587.jpg')}}" alt="..." class="full-width border_img" rel="nofollow">
                            @endisset
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="jumbotron">
                            เปิดใช้งานระบบแนะนำสมาชิก
                        </div>
                        <div class="form-group">
                            <input name="getmember_show" id="getmember_show" class="bootstrap-switch" type="checkbox" data-toggle="switch" data-on-label="<i class='nc-icon nc-check-2'></i>" data-off-label="<i class='nc-icon nc-simple-remove'></i>" data-on-color="success" data-off-color="success"
                            @if(!empty($data->getmember_show))
                                @if($data->getmember_show == 1) checked @endif
                            @endif
                            />
                        </div>
                    </div>
                </div>
            </div>
            @if(!empty($data->updated_by))
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <label>อัพเดตข้อมูลโดย :: {{ $data->updated_by}} :: {{ $data->updated_at}} </label>
                    </div>
                </div>
            </div>
            @endif
            <div class="col-md-9">
                <div class="card">
                    <div class="card-footer">
                        <div class="right">
                            @include('layouts.admin._button.submit')
                        </div>
                    </div>
                </div>
            </div>
        </div>

        </form>
    </div>
</div>

@include('admin.getmember.modal.deleteImg')
@endsection

@section('js')

@endsection
