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
                    'route' => 'banner.crate',
                    'id'=>'data-form',
                    'method' => 'post',
                    'files' => true
                ])
            }}
        @else
            {{
                Form::model($data, [
                    'novalidate',
                    'route' => ['banner.update',[$data->id]],
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
                                <div class="col-md-12">
                                    <div class="form-group has-label">
                                        <label>Link url</label>
                                        <input class="form-control no-max-height" id="banner_link" name="banner_link" value="@if(!empty($data->banner_link)){{ $data->banner_link }}@else{{ old('banner_link') }}@endif" />
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group has-label">
                                        <label>คำอธิบายภาพ <span class="text-danger">*</span></label>
                                        <input class="form-control no-max-height" id="banner_note" name="banner_note" value="@if(!empty($data->banner_note)){{ $data->banner_note }}@else{{ old('banner_note') }}@endif" />
                                        @error('banner_note')<small class="error-danger-text">{{ $message }}</small><br/>@enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group has-label">
                                        <label>วันที่เริ่มโปรโมท</label>
                                        <input class="form-control no-max-height datepicker" id="banner_start_date" name="banner_start_date" value="@if(!empty($data->banner_start_date)){{ date("d-m-Y",strtotime($data->banner_start_date)) }}@else{{ old('banner_start_date') }}@endif" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group has-label">
                                        <label>วันที่สิ้นสุดการโปรโมท</label>
                                        <input class="form-control no-max-height datepicker" id="banner_end_date" name="banner_end_date" value="@if(!empty($data->banner_end_date)){{ date("d-m-Y",strtotime($data->banner_end_date)) }}@else{{ old('banner_end_date') }}@endif" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="has-label">
                                        <label>รูปภาพสำหรับ (Desktop) <span class="text-danger">*</span></label>
                                        <input type="file" accept="image/*" class="form-control" id="banner_img_desktop" name="banner_img_desktop" onchange="readURL1(this);">
                                        @error('banner_img_desktop')<small class="error-danger-text">{{ $message }}</small><br/>@enderror
                                        <small>ขนาดไฟล์ คือ 2048 X 587 PX</small><br/>
                                        <small class="error-danger-text">* หากไฟล์ภาพมีขนาดไม่เท่ากับที่กำหนด ไฟล์จะบีบอัดอัตโนมัติเพื่อให้ได้ขนาดที่ต้องการ (อาจทำให้ภาพยืดหรือหดได้)</small>
                                        <br/>
                                        <br/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="has-label">
                                        <label>รูปภาพสำหรับ (Mobile) <span class="text-danger">*</span></label>
                                        <input type="file" accept="image/*" class="form-control" id="banner_img_mobile" name="banner_img_mobile" onchange="readURL2(this);">
                                        @error('banner_img_mobile')<small class="error-danger-text">{{ $message }}</small><br/>@enderror
                                        <small>ขนาดไฟล์ คือ 900 X 1050 PX</small><br/>
                                        <small class="error-danger-text">* หากไฟล์ภาพมีขนาดไม่เท่ากับที่กำหนด ไฟล์จะบีบอัดอัตโนมัติเพื่อให้ได้ขนาดที่ต้องการ (อาจทำให้ภาพยืดหรือหดได้)</small>
                                        <br/>
                                        <br/>
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
                                <input name="banner_show" id="banner_show" class="bootstrap-switch" type="checkbox" data-toggle="switch" data-on-label="<i class='nc-icon nc-check-2'></i>" data-off-label="<i class='nc-icon nc-simple-remove'></i>" data-on-color="success" data-off-color="success"
                                @if(!empty($data->banner_show))
                                    @if($data->banner_show == 1) checked @endif
                                @else checked @endif
                                />
                            </div>
                            <hr/>
                            <div class="jumbotron">
                                ลำดับการแสดงผล
                            </div>
                            <div class="form-group">
                                <input class="form-control no-max-height" id="banner_sort" name="banner_sort" placeholder="0" value="@if(!empty($data->banner_sort)){{ $data->banner_sort }}@else @if(!empty(old('banner_sort'))) {{ old('banner_sort') }} @else @if(!empty($sort)) {{ $sort->banner_sort+1 }} @else 1 @endif  @endif @endif" />
                                <p><small class="error-danger-text">* เรียงลำดับโดยตัวเลขมากที่สุดขึ้นก่อน</small></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-6">
                                    <a href="{{ route('banner.index')}}">
                                        @include('layouts.admin._button.back')
                                    </a>
                                </div>
                                <div class="col-6 right">
                                    @include('layouts.admin._button.submit')
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group text-align-center">
                                        @if(!empty($data->banner_img_desktop))
                                        <a href="#" class="remove-logo" data-toggle="modal" data-target="#deleteDesktop" onclick="deleteModal(this)" href="#" data-id="{{ $data->id }}" data-name="{{ $data->banner_img_desktop }}">
                                            <button class="btn btn-icon btn-round btn-google" type="button">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </a>
                                        @endisset
                                        @isset($data->banner_img_desktop)
                                            <input type="hidden" class="form-control" id="banner_img_desktop_old" name="banner_img_desktop_old" value="{{ $data->banner_img_desktop }}">
                                            <img id="blah1" src="{{ asset('storage/banner/'.$data->banner_img_desktop) }}" alt="" class="full-width border_img" rel="nofollow">
                                        @else
                                            <img id="blah1" src="{{ asset('images/default-img/default-banner_2048_587.jpg')}}" alt="..." class="full-width border_img" rel="nofollow">
                                        @endisset
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group text-align-center">
                                        @if(!empty($data->banner_img_mobile))
                                        <a href="#" class="remove-logo" data-toggle="modal" data-target="#deleteMobile" onclick="deleteModal2(this)" href="#" data-id="{{ $data->id }}" data-name="{{ $data->banner_img_mobile }}">
                                            <button class="btn btn-icon btn-round btn-google" type="button">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </a>
                                        @endisset
                                        @isset($data->banner_img_mobile)
                                            <input type="hidden" class="form-control" id="banner_img_mobile_old" name="banner_img_mobile_old" value="{{ $data->banner_img_mobile }}">
                                            <img id="blah2" src="{{ asset('storage/banner/'.$data->banner_img_mobile) }}" alt="" class="full-width border_img" rel="nofollow">
                                        @else
                                            <img id="blah2" src="{{ asset('images/default-img/default-banner-900-1050.jpg')}}" alt="..." class="full-width border_img" rel="nofollow">
                                        @endisset
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>


@include('admin.banner.modal.deleteDesktop')
@include('admin.banner.modal.deleteMobile')

@endsection

@section('js')


@endsection
