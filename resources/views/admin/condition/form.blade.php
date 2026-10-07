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
                    'route' => 'condition.crate',
                    'id'=>'data-form',
                    'method' => 'post',
                    'files' => true
                ])
            }}
        @else
            {{
                Form::model($data, [
                    'novalidate',
                    'route' => ['condition.update',[$data->id]],
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
                                <div class="col-md-9">
                                    <div class="form-group has-label">
                                        <label>ชื่อเงื่อนไขการบริการ<span class="text-danger">*</span></label>
                                        <input class="form-control no-max-height" id="condition_name" name="condition_name" value="@if(!empty($data->condition_name)){{ $data->condition_name }}@else{{ old('condition_name') }}@endif" />
                                        @error('condition_name')<small class="error-danger-text">{{ $message }}</small><br/>@enderror
                                    </div>
                                    <div class="form-group has-label">
                                        <label>คำอธิบายเพิ่มเติม</label>
                                        <input class="form-control no-max-height" id="condition_des" name="condition_des" value="@if(!empty($data->condition_des)){{ $data->condition_des }}@else{{ old('condition_des') }}@endif" />
                                    </div>
                                    <div class="has-label">
                                        <label>โลโก้เงื่อนไขการบริการ<span class="text-danger">*</span></label>
                                        <input type="file" accept="image/*" class="form-control" id="condition_img" name="condition_img" onchange="readURL1(this);">
                                        @error('condition_img')<small class="error-danger-text">{{ $message }}</small><br/>@enderror
                                        <small>ขนาดไฟล์ คือ 80 X 80 PX</small><br/>
                                        <small class="error-danger-text">* หากไฟล์ภาพมีขนาดไม่เท่ากับที่กำหนด ไฟล์จะบีบอัดอัตโนมัติเพื่อให้ได้ขนาดที่ต้องการ (อาจทำให้ภาพยืดหรือหดได้)</small>
                                        <br/>
                                        <br/>
                                    </div>
                                    
                                </div>
                                <div class="col-md-3">
                                    <br/>
                                    <div class="form-group relative-condition">
                                        @if(!empty($data->condition_img))
                                        <a href="#" class="remove-logo" data-toggle="modal" data-target="#deleteImg" onclick="deleteModal(this)" href="#" data-id="{{ $data->id }}" data-name="{{ $data->condition_img }}">
                                            <button class="btn btn-icon btn-round btn-google" type="button">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </a>
                                        @endisset
                                        @if(!empty($data->condition_img))
                                            <input type="hidden" class="form-control" id="condition_img_old" name="condition_img_old" value="{{ $data->condition_img }}">
                                            <img id="blah1" src="{{ asset('storage/condition/'.$data->condition_img) }}" alt="" class="condition-width border_img" rel="nofollow">
                                        @else
                                            <img id="blah1" src="{{ asset('images/default-img/default-banner_2048_587.jpg')}}" alt="..." class="condition-width border_img" rel="nofollow">
                                        @endisset
                                    </div>
                                </div>
                                @if(!empty($data->updated_by))
                                    <div class="col-md-12">
                                        <div class="line"></div>
                                        <div class="form-group has-label">
                                            <label>อัพเดตข้อมูลโดย :: {{ $data->updated_by}} :: {{ $data->updated_at}} </label>
                                        </div>
                                    </div>
                                @endif
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
                                <input name="condition_show" id="condition_show" class="bootstrap-switch" type="checkbox" data-toggle="switch" data-on-label="<i class='nc-icon nc-check-2'></i>" data-off-label="<i class='nc-icon nc-simple-remove'></i>" data-on-color="success" data-off-color="success"
                                @if(!empty($data->condition_show))
                                    @if($data->condition_show == 1) checked @endif
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
                                    <a href="{{ route('condition.index')}}">
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


@include('admin.condition.modal.deleteImg')

@endsection

@section('js')


@endsection
