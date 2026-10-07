@extends('layouts.temp_admin')
@section('title'){{ $title_page }}@endsection

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
                    'route' => 'promotion.emailtemplate.crate',
                    'id'=>'data-form',
                    'method' => 'post',
                    'files' => true
                ])
            }}
        @else
            {{
                Form::model($data, [
                    'novalidate',
                    'route' => ['promotion.emailtemplate.update',[$data->id]],
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
                                <label>ชื่อ Email Template *</label>
                               <input class="form-control" id="email_title" name="email_title" value="@if(!empty($data->email_title)){{ $data->email_title }}@else{{ old('email_title') }}@endif" />
                               @if(!empty($data->email_link))<a href="{{ route('fronend.emailtemplate',$data->email_link) }}" target="_bank">{{ route('fronend.emailtemplate',$data->email_link) }}</a><br/>@endif 
                               @error('email_title')<small class="error-danger-text">{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group" >
                                <textarea id="editor" name="email_content">@if(!empty($data->email_content)){{ $data->email_content }}@else{{ old('email_content') }}@endif</textarea>
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
                                    @if($data->show == 1)
                                        checked
                                    @endif
                                @else
                                    checked
                                @endif
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
                                    <a href="{{ route('promotion.emailtemplate.index')}}">
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
@include('admin.promotion.emailtemplate.modal.deleteCover')
@endif
@endsection


@section('js')
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
