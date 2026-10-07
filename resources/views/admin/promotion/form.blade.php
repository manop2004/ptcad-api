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
                    'route' => 'promotion.crate',
                    'id'=>'data-form',
                    'method' => 'post',
                    'files' => true
                ])
            }}
        @else
            {{
                Form::model($data, [
                    'novalidate',
                    'route' => ['promotion.update',[$data->id]],
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
                                    <div class="form-check">
                                        <label class="form-check-label" style="margin-top:30px">
                                            <input data-block="date_end_block" onclick="checkBlockToggle(this)" name="promo_type" class="form-check-input" type="checkbox" value="2" @if(!empty($data->promo_type)) @if($data->promo_type == 2) checked @endif  @endif>
                                            <span class="form-check-sign"></span>
                                            แจ้งเตือนข่าวสารทั่วไป
                                        </label>
                                    </div>
                                    <hr/>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group has-label">
                                        <label>ชื่อโปรโมชั่น</label>
                                        <input class="form-control no-max-height" id="promo_name" name="promo_name" value="@if(!empty($data->promo_name)){{ $data->promo_name }}@else{{ old('promo_name') }}@endif" />
                                        @error('promo_name')<small class="error-danger-text">{{ $message }}</small><br/>@enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group has-label">
                                        <label>Link url</label>
                                        <input class="form-control no-max-height" id="promo_link" name="promo_link" value="@if(!empty($data->promo_link)){{ $data->promo_link }}@else{{ old('promo_link') }}@endif" />
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label>รูปภาพ</label>
                                    <input type="file" accept="image/*" class="form-control" id="promo_img" name="promo_img" onchange="readURL1(this);">
                                    @error('promo_img')<small class="error-danger-text">{{ $message }}</small><br/>@enderror
                                    <br/>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group has-label">
                                        <label>เลือกสี</label>
                                        <select id="promo_color" name="promo_color" class="form-control" >
                                            <option value="event-blue" @if(!empty($data->promo_color)) @if($data->promo_color== 'event-blue') selected @endif  @endif>สีฟ้า (event-blue)</option>
                                            <option value="event-purple" @if(!empty($data->promo_color)) @if($data->promo_color== 'event-purple') selected @endif  @endif>สีม่วง (event-purple)</option>
                                            <option value="event-green" @if(!empty($data->promo_color)) @if($data->promo_color== 'event-green') selected @endif  @endif>สีเขียว (event-green)</option>
                                            <option value="event-orange" @if(!empty($data->promo_color)) @if($data->promo_color== 'event-orange') selected @endif  @endif>สีส้ม (event-orange)</option>
                                            <option value="event-red" @if(!empty($data->promo_color)) @if($data->promo_color== 'event-red') selected @endif  @endif>สีแดง (event-red)</option>
                                            <option value="event-pink" @if(!empty($data->promo_color)) @if($data->promo_color== 'event-pink') selected @endif  @endif>สีชมพู (event-pink)</option>
                                            <option value="event-yellow" @if(!empty($data->promo_color)) @if($data->promo_color== 'event-yellow') selected @endif  @endif>สีเหลือง (event-yellow)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6"></div>
                                <div id="date_end_block" class="col-md-12 @if(!empty($data->promo_type)) @if($data->promo_type == 2) hidden @endif @endif">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group has-label">
                                                <label>วันที่เริ่มโปรโมชั่น</label>
                                                <input class="form-control no-max-height datepicker" id="promo_start_date" name="promo_start_date" value="@if(!empty($data->promo_start_date)){{ date("d-m-Y",strtotime($data->promo_start_date)) }}@else{{ date("d-m-Y") }}@endif" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group has-label">
                                                <label>วันที่สิ้นสุดโปรโมชั่น</label>
                                                <input class="form-control no-max-height datepicker" id="promo_end_date" name="promo_end_date" value="@if(!empty($data->promo_end_date)){{ date("d-m-Y",strtotime($data->promo_end_date)) }}@else{{ date("d-m-Y") }}@endif" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group has-label">
                                        <label>คำอธิบายภาพ <span class="text-danger">*</span></label>
                                        <textarea id="editor" name="promo_note">@if(!empty($data->promo_note)){{ $data->promo_note }}@else{{ old('promo_note') }}@endif</textarea>
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
                                <input name="promo_show" id="promo_show" class="bootstrap-switch" type="checkbox" data-toggle="switch" data-on-label="<i class='nc-icon nc-check-2'></i>" data-off-label="<i class='nc-icon nc-simple-remove'></i>" data-on-color="success" data-off-color="success"
                                @if(!empty($data->promo_show))
                                    @if($data->promo_show == 1) checked @endif
                                @else checked @endif
                                />
                            </div>
                        </div>
                    </div>


                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <div class="jumbotron">
                                    การแจ้งเตือนผ่าน Line Notify
                                </div>
                                <div >
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input name="line_notify_group1" class="form-check-input" type="checkbox" value="1" @if(!empty($data->line_notify_group1)) @if($data->line_notify_group1 == 1) checked @endif  @endif>
                                            <span class="form-check-sign"></span>
                                            Group PTCAD
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input name="line_notify_group2" class="form-check-input" type="checkbox" value="1" @if(!empty($data->line_notify_group2)) @if($data->line_notify_group2 == 1) checked @endif @endif>
                                            <span class="form-check-sign"></span>
                                            Group Gstarcad
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="card">
                        <div class="card-body">
                            @if(!empty($data->promo_img))
                            <a href="#" class="remove-logo" data-toggle="modal" data-target="#deleteImg" onclick="deleteModal(this)" href="#" data-id="{{ $data->id }}" data-name="{{ $data->promo_img }}">
                                <button class="btn btn-icon btn-round btn-google" type="button">
                                    <i class="fa fa-times"></i>
                                </button>
                            </a>
                            @endisset
                            <div class="text-align-center">
                                @isset($data->promo_img)
                                    <input type="hidden" class="form-control" id="promo_img_old" name="promo_img_old" value="{{ $data->promo_img }}">
                                    <img id="blah1" src="{{ asset('storage/promotion/' . $data->promo_img) }}" alt="" class="full-width" rel="nofollow">
                                @else
                                    <img id="blah1" src="{{ asset('images/default-img/no-img.jpg')}}" alt="..." class="full-width" rel="nofollow">
                                @endisset
                            </div>
                            <br/>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-6">
                                    <a href="{{ route('promotion.index')}}">
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


@include('admin.promotion.modal.deleteImg')

@endsection

@section('js')
<!-- select2 -->
<script src="{{ asset('vendor/select2/select2.min.js') }}"></script>
<!-- select2-bootstrap4-theme -->
<script src="{{ asset('vendor/select2-bootstrap4-theme/docs/script.js') }}"></script>
<!-- jscolor-2.4.6 -->
<script src="{{ asset('vendor/jscolor-2.4.6/jscolor.min.js') }}"></script>
<!-- ckeditor 4 -->
<script src="{{ asset('vendor/ckeditor4/ckeditor.js?v=4') }}"></script>

<script>
    CKEDITOR.replace( 'editor');
</script>

@endsection
