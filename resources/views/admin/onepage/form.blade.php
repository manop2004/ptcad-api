@extends('layouts.temp_admin')
@section('title'){{$title_page}}@endsection

@section('css')
<!-- select2 -->
<link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet" />
<!-- select2-bootstrap4-theme -->
<link href="{{ asset('vendor/select2-bootstrap4-theme/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendor/Bootstrap-4-Tag-Input/tagsinput.css') }}" rel="stylesheet">
<style>
    .jumbotron { padding: 1rem; margin-bottom: 1rem; }
    .bootstrap-tagsinput{
        padding: 8px !important;
        border: 1px solid#DDDDDD!important;
    }
    .bootstrap-tagsinput .badge {
        margin-bottom: 0 !important;
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
                    'route' => 'onepage.crate',
                    'id'=>'data-form',
                    'method' => 'post',
                    'files' => true
                ])
            }}
        @else
            {{
                Form::model($data, [
                    'novalidate',
                    'route' => ['onepage.update',[$data->id]],
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
                            @if(!empty($data))
                            <div class="row">
                                <div class="col-md-12">
                                    <a href="{{ route('onepage.setting',$data->id) }}" class="btn"><i class="nc-icon nc-settings-gear-65"></i>&nbsp;&nbsp;ตั้งค่าแบบฟอร์มลงทะเบียน</a>
                                    <a href="{{ route('onepage.setting.page',$data->id) }}" class="btn"><i class="nc-icon nc-tv-2"></i>&nbsp;&nbsp;ข้อมูลหน้าเพจ</a>
                                </div>
                            </div>
                            <hr/>
                            @endif
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group has-label">
                                        <label>CRM Campaign Id *</label>
                                        <input class="form-control no-max-height" id="campaignid" name="campaignid" value="@if(!empty($data->campaignid)){{ $data->campaignid }}@else{{ old('campaignid') }}@endif" />
                                        @error('campaignid')<small class="error-danger-text">{{ $message }}</small><br/>@enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group has-label">
                                        <label>ชื่อหน้าเพจ *</label>
                                        <input class="form-control no-max-height" id="name" name="name" value="@if(!empty($data->name)){{ $data->name }}@else{{ old('name') }}@endif" />
                                        @error('name')<small class="error-danger-text">{{ $message }}</small><br/>@enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group has-label">
                                        <label>Permalink *</label>
                                        <input onkeyup="ChkEng();" class="form-control no-max-height" id="parmalink" name="parmalink" value="@if(!empty($data->parmalink)){{ $data->parmalink }}@else{{ old('parmalink') }}@endif" />
                                        @if(!empty($data))<a href="{{ route('onepages',$data->parmalink) }}" target="_bank">{{ route('onepages',$data->parmalink) }}</a><br/>@endif
                                        @error('parmalink')<small class="error-danger-text">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group has-label">
                                        <label>Mail To *</label>
                                        <input placeholder="email1@exsample.com,email2@exsample.com" class="form-control no-max-height" id="mailtoteam" name="mailtoteam" value="@if(!empty($data->mailtoteam)){{ $data->mailtoteam }}@else{{ old('mailtoteam') }}@endif" />
                                        @error('mailtoteam')<small class="error-danger-text">{{ $message }}</small><br/>@enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group has-label">
                                        <label>ประเภทหน้า *</label>
                                        <select id="regis_type" name="regis_type" class="form-control">
                                            <option value="">--เลือกข้อมูล--</option>
                                            <option @if(!empty($data->regis_type)) @if($data->regis_type == 'download') selected @endif @endif value="download">Download</option>
                                            <option @if(!empty($data->regis_type)) @if($data->regis_type == 'quotation') selected @endif @endif value="quotation">Quotation</option>
                                        </select>
                                        @error('regis_type')<small class="error-danger-text">{{ $message }}</small><br/>@enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group has-label">
                                        <label>* หากไม่ต้องการให้มีการลงทะเบียนซ้ำโดยใช้อีเมลเดิม</label>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input id="checkemail" name="checkemail" class="form-check-input" type="checkbox"
                                                @if(!empty($data->checkemail))
                                                    @if($data->checkemail == 'true') checked @endif
                                                @endif
                                                >
                                                <span class="form-check-sign"></span>
                                                ห้ามไม่ให้ลงทะเบียนอีเมลซ้ำ
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group has-label">
                                        <label>Keyword</label>
                                        <input data-role="tagsinput" type="text" name="og_keywords" id="og_keywords" class="form-control form-tag" value="@if(!empty($data->og_keywords)){{ $data->og_keywords }}@else{{ old('og_keywords') }}@endif"/>
                                        @error('og_keywords')<small class="error-danger-text">{{ $message }}</small><br/>@enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group has-label">
                                        <label>Seo Description</label>
                                        <textarea onkeyup="ChkLength();" rows="5" class="form-control no-max-height" id="remainLength" name="og_description">@if(!empty($data->og_description)){{ $data->og_description }}@else{{ old('og_description') }}@endif</textarea>
                                        @error('og_description')<small class="error-danger-text">{{ $message }}</small><br/>@enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
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
                            <label>Image Cover Share</label>
                            @if(!empty($data->og_image))
                            <a href="#" class="remove-logo" data-toggle="modal" data-target="#deleteImg" onclick="deleteModal(this)" href="#" data-id="{{ $data->id }}" data-name="{{ $data->og_image }}">
                                <button class="btn btn-icon btn-round btn-google" type="button">
                                    <i class="fa fa-times"></i>
                                </button>
                            </a>
                            @endisset
                            <div class="text-align-center">
                                @isset($data->og_image)
                                    <input type="hidden" class="form-control" id="og_image_old" name="og_image_old" value="{{ $data->og_image }}">
                                    <img id="blah1" src="{{ asset('storage/onepages/' . $data->og_image) }}" alt="" class="full-width" rel="nofollow">
                                @else
                                    <img id="blah1" src="{{ asset('images/default-img/no-img.jpg')}}" alt="..." class="full-width" rel="nofollow">
                                @endisset
                            </div>
                            <br/>
                            <input type="file" accept="image/*" class="form-control" id="og_image" name="og_image" onchange="readURL1(this);">
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-6">
                                    <a href="{{ route('onepage.index')}}">
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

@include('admin.onepage.modal.deleteCover')

@endsection

@section('js')
<script src="{{ asset('assets/backend/js/plugins/bootstrap-tagsinput.js') }}"></script>
<!-- select2 -->
<script src="{{ asset('vendor/select2/select2.min.js') }}"></script>
<!-- select2-bootstrap4-theme -->
<script src="{{ asset('vendor/select2-bootstrap4-theme/docs/script.js') }}"></script>

<script>
    $(document).ready(function() {
        $('.select-multiple').select2();
    });

</script>
@endsection
