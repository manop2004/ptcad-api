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
                    'route' => 'brand.crate',
                    'id'=>'data-form',
                    'method' => 'post',
                    'files' => true
                ])
            }}
        @else
            {{
                Form::model($data, [
                    'novalidate',
                    'route' => ['brand.update',[$data->id]],
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
                                        <label>ชื่อแบรนด์สินค้า<span class="text-danger">*</span></label>
                                        <input class="form-control no-max-height" id="brand_name" name="brand_name" value="@if(!empty($data->brand_name)){{ $data->brand_name }}@else{{ old('brand_name') }}@endif" />
                                        @error('brand_name')<small class="error-danger-text">{{ $message }}</small><br/>@enderror
                                    </div>
                                    <div class="form-group has-label">
                                        <label>Permalink</label>
                                        <input class="form-control no-max-height" id="brand_permalink" name="brand_permalink" value="@if(!empty($data->brand_permalink)){{ $data->brand_permalink }}@else{{ old('brand_permalink') }}@endif" />
                                    </div>
                                    <div class="has-label">
                                        <label>โลโก้แบรนด์สินค้า<span class="text-danger">*</span></label>
                                        <input type="file" accept="image/*" class="form-control" id="brand_img" name="brand_img" onchange="readURL1(this);">
                                        @error('brand_img')<small class="error-danger-text">{{ $message }}</small><br/>@enderror
                                        <small>ขนาดไฟล์ คือ 416 X 133 PX</small><br/>
                                        <small class="error-danger-text">* หากไฟล์ภาพมีขนาดไม่เท่ากับที่กำหนด ไฟล์จะบีบอัดอัตโนมัติเพื่อให้ได้ขนาดที่ต้องการ (อาจทำให้ภาพยืดหรือหดได้)</small>
                                        <br/>
                                        <br/>
                                    </div>
                                    <div class="form-group has-label">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input name="brand_recommend" id="brand_recommend" class="form-check-input" type="checkbox" value="1" @if(!empty($data->brand_recommend)) @if($data->brand_recommend == 1) checked @endif @endif>
                                                <span class="form-check-sign"></span>
                                                แนะนำแบรนด์สินค้า
                                            </label>
                                        </div>
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
                                        @if(!empty($data->brand_img))
                                        <a href="#" class="remove-logo" data-toggle="modal" data-target="#deleteImg" onclick="deleteModal(this)" href="#" data-id="{{ $data->id }}" data-name="{{ $data->brand_img }}">
                                            <button class="btn btn-icon btn-round btn-google" type="button">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </a>
                                        @endisset
                                        @if(!empty($data->brand_img))
                                            <input type="hidden" class="form-control" id="brand_img_old" name="brand_img_old" value="{{ $data->brand_img }}">
                                            <img id="blah1" src="{{ asset('storage/brand/'.$data->brand_img) }}" alt="" class="full-width border_img" rel="nofollow">
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
                                <input name="brand_show" id="brand_show" class="bootstrap-switch" type="checkbox" data-toggle="switch" data-on-label="<i class='nc-icon nc-check-2'></i>" data-off-label="<i class='nc-icon nc-simple-remove'></i>" data-on-color="success" data-off-color="success"
                                @if(!empty($data->brand_show))
                                    @if($data->brand_show == 1) checked @endif
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
                                    <a href="{{ route('brand.index')}}">
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


@include('admin.brand.modal.deleteImg')

@endsection

@section('js')


@endsection
