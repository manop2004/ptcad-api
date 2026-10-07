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
                    'route' => 'artlicle.crate',
                    'id'=>'data-form',
                    'method' => 'post',
                    'files' => true
                ])
            }}
        @else
            {{
                Form::model($data, [
                    'novalidate',
                    'route' => ['artlicle.update',[$data->id]],
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
                            <div class="form-group has-label">
                                <label>ชื่อบทความ *</label>
                               <input class="form-control" id="art_name" name="art_name" value="@if(!empty($data->art_name)){{ $data->art_name }}@else{{ old('art_name') }}@endif" />
                                @error('art_name')<small class="error-danger-text">{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group has-label">
                                <label>Permalink *</label>
                                <input onkeyup="ChkEng();" class="form-control no-max-height" id="art_parmalink" name="art_parmalink" value="@if(!empty($data->art_parmalink)){{ $data->art_parmalink }}@else{{ old('art_parmalink') }}@endif" />
                                @if(!empty($data->art_parmalink))<a href="{{ route('fronend.article.content',$data->art_parmalink) }}" target="_bank">{{ route('fronend.article.content',$data->art_parmalink) }}</a><br/>@endif
                                @error('art_parmalink')<small class="error-danger-text">{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group has-label">
                                <label>Keyword</label>
                                <input data-role="tagsinput"  type="text" name="art_keyword[]" id="art_keyword" class="form-control form-tag" value="@if(!empty($data->art_keyword)){{ $data->art_keyword }}@else{{ old('old_art_keyword') }}@endif"/>
                            </div>
                            <br/>
                            <div class="form-group" >
                                <textarea id="editor" name="art_detail">@if(!empty($data->art_detail)){{ $data->art_detail }}@else{{ old('art_detail') }}@endif</textarea>
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
                                <input name="art_show" id="art_show" class="bootstrap-switch" type="checkbox" data-toggle="switch" data-on-label="<i class='nc-icon nc-check-2'></i>" data-off-label="<i class='nc-icon nc-simple-remove'></i>" data-on-color="success" data-off-color="success"
                                @if(!empty($data->art_show))
                                    @if($data->art_show == 1)
                                        checked
                                    @endif
                                @else
                                    checked
                                @endif
                                 />
                            </div>
                            <hr/>
                            <div class="jumbotron">
                                หมวดหมู่บทความ *
                            </div>
                            <div class="form-group">
                                <select id="art_cat" name="art_cat" class="form-control">
                                    <option value="">-- เลือกหมวดหมู่ --</option>
                                    <option value="ข่าวสาร" @if(!empty($data->art_cat) && $data->art_cat == 'ข่าวสาร') selected="selected" @endif>ข่าวสาร</option>
                                    <option value="Tips & Tricks" @if(!empty($data->art_cat) && $data->art_cat == 'Tips & Tricks') selected="selected" @endif>Tips & Tricks</option>
                                </select>
                                @error('art_cat')<small class="error-danger-text">{{ $message }}</small> @enderror
                            </div>
                            <hr/>
                            <div class="jumbotron">
                                แสดงข้อมูลผู้เขียนบทความ
                            </div>
                            <div class="form-group">
                                <input name="art_author" id="art_author" class="bootstrap-switch" type="checkbox" data-toggle="switch" data-on-label="<i class='nc-icon nc-check-2'></i>" data-off-label="<i class='nc-icon nc-simple-remove'></i>" data-on-color="success" data-off-color="success"
                                @if(!empty($data->art_author))
                                    @if($data->art_author == 1)
                                        checked
                                    @endif
                                @else
                                    checked
                                @endif
                                 />
                            </div>
							<hr>
							<div class="jumbotron">
                                ผู้เขียนบทความ
                            </div>
                            <div class="form-group">
                                <select id="user_id" name="user_id" class="form-control">
					<option value=""></option>
					@foreach ($usersStaff as $users)
						<option value="{{ $users->id }}" @if($users->id == $staffId)selected="selected"@endif>{{ $users->name.' '.$users->lastname }}</option>
					@endforeach
				</select>
                            </div>
							
                        </div>
                    </div>
					
                    <div class="card">
                        <div class="card-body">
                            <div class="jumbotron">
                                SEO Description
                            </div>
                            <div class="form-group">
                                <textarea onkeyup="ChkLength();" rows="5" id="remainLength" name="art_seo_detail" rows="4" class="form-control" placeholder="อธิบายเกี่ยวกับบทความไม่เกิน 150 - 170 ตัวอักษร" maxlength="170" >@if(!empty($data->art_seo_detail)){{ $data->art_seo_detail }}@else{{ old('art_seo_detail') }}@endif</textarea>
                                <p id="showNumber_ChkLength" class="error-danger-text"></p>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            @if(!empty($data->art_thumb))
                            <a href="#" class="remove-logo" data-toggle="modal" data-target="#myDelete" onclick="deleteModal(this)" href="#" data-id="{{ $data->id }}" data-name="{{ $data->art_thumb }}">
                                <button class="btn btn-icon btn-round btn-google" type="button">
                                    <i class="fa fa-times"></i>
                                </button>
                            </a>
                            @endisset
                            <div class="text-align-center">
                                @isset($data->art_thumb)
                                    <input type="hidden" class="form-control" id="art_thumb_old" name="art_thumb_old" value="{{ $data->art_thumb }}">
                                    <img id="blah1" src="{{ asset('storage/article/' . $data->art_thumb) }}" alt="" class="full-width" rel="nofollow">
                                @else
                                    <img id="blah1" src="{{ asset('images/default-img/no-img.jpg')}}" alt="..." class="full-width" rel="nofollow">
                                @endisset
                            </div>
                            <br/>
                            <input type="file" accept="image/*" class="form-control" id="art_thumb" name="art_thumb" onchange="readURL1(this);">
                            <p></p><small>ขนาดไฟล์ภาพหน้าปก คือ 810 X 450 PX</small><br/>
                            <small class="error-danger-text">* หากไฟล์ภาพมีขนาดไม่เท่ากับที่กำหนด ไฟล์จะบีบอัดอัตโนมัติเพื่อให้ได้ขนาดที่ต้องการ (อาจทำให้ภาพยืดหรือหดได้)</small><br/>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-6">
                                    <a href="{{ route('artlicle.index')}}">
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

@if(!empty($data->art_thumb))
@include('admin.artlicle.modal.deleteCover')
@endif
@endsection


@section('js')
    <script src="{{ asset('assets/backend/js/plugins/bootstrap-tagsinput.js') }}"></script>
    <!-- select2 -->
    <script src="{{ asset('vendor/select2/select2.min.js') }}"></script>
    <!-- select2-bootstrap4-theme -->
    <script src="{{ asset('vendor/select2-bootstrap4-theme/docs/script.js') }}"></script>
    <!-- ckeditor 4 -->
    <script src="{{ asset('vendor/ckeditor4/ckeditor.js?v=4') }}"></script>

    <script>
        CKEDITOR.replace('editor', {
			filebrowserBrowseUrl: '/elfinder/ckeditor', 
			filebrowserImageBrowseUrl: '/elfinder/ckeditor?type=Images',
			filebrowserUploadUrl: '/elfinder/connector?command=QuickUpload&type=Files',
			filebrowserImageUploadUrl: '/elfinder/connector?command=QuickUpload&type=Images'
		});
    </script>

    <script>
        $(document).ready(function() {
            $('.select-multiple').select2();
        });

    </script>

@endsection