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
                    'route' => 'tutorial.crate',
                    'id'=>'data-form',
                    'method' => 'post',
                    'files' => true
                ])
            }}
        @else
            {{
                Form::model($data, [
                    'novalidate',
                    'route' => ['tutorial.update',[$data->id]],
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
                                <label>ชื่อ Tutorial *</label>
                               <input class="form-control" id="tut_name" name="tut_name" value="@if(!empty($data->tut_name)){{ $data->tut_name }}@else{{ old('tut_name') }}@endif" />
                                @error('tut_name')<small class="error-danger-text">{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group has-label">
                                <label>Permalink *</label>
                                <input onkeyup="ChkEng();" class="form-control no-max-height" id="tut_parmalink" name="tut_parmalink" value="@if(!empty($data->tut_parmalink)){{ $data->tut_parmalink }}@else{{ old('tut_parmalink') }}@endif" />
                                @if(!empty($data->tut_parmalink))<a href="{{ route('fronend.tutorial.content',$data->tut_parmalink) }}" target="_bank">{{ route('fronend.tutorial.content',$data->tut_parmalink) }}</a><br/>@endif
                                @error('tut_parmalink')<small class="error-danger-text">{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group has-label">
                                <label>Keyword / หมวดหมู่</label>
                                <input data-role="tagsinput"  type="text" name="tut_keyword[]" id="tut_keyword" class="form-control form-tag" value="@if(!empty($data->tut_keyword)){{ $data->tut_keyword }}@else{{ old('old_tut_keyword') }}@endif"/>
                            </div>
                            <div class="form-group has-label">
                                <label>ลิงก์วิดีโอ (YouTube / Vimeo) *</label>
                                <input class="form-control" id="tut_video" name="tut_video" placeholder="เช่น https://www.youtube.com/embed/xxxxxxxxxxx" value="@if(!empty($data->tut_video)){{ $data->tut_video }}@else{{ old('tut_video') }}@endif" />
                                <small>แนะนำให้ใช้ลิงก์แบบ embed (youtube.com/embed/...) จะฝังเล่นในหน้าเว็บได้พอดี</small>
                                @error('tut_video')<small class="error-danger-text">{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group has-label">
    <label>ระยะเวลาวิดีโอ</label>
    <input class="form-control" id="tut_duration" name="tut_duration" placeholder="เช่น 12:48" value="@if(!empty($data->tut_duration)){{ $data->tut_duration }}@else{{ old('tut_duration') }}@endif" />
    <small>ระบบจะดึงระยะเวลาให้อัตโนมัติเมื่อวางลิงก์วิดีโอด้านบน (หรือกรอกเองก็ได้)</small>
    <input type="hidden" name="tut_thumb_auto" id="tut_thumb_auto" value="">
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group has-label">
            <label>กลุ่มหมวดหมู่ <span class="text-danger">*</span></label>
            <select class="form-control" name="tut_group" required>
                <option value="">-- เลือกกลุ่ม --</option>
                <option value="Install 2025" @if(!empty($data->tut_group) && $data->tut_group=='Install 2025') selected @endif>Install 2025</option>
                <option value="Install 2026" @if(!empty($data->tut_group) && $data->tut_group=='Install 2026') selected @endif>Install 2026</option>
                <option value="PTCAD 2024" @if(!empty($data->tut_group) && $data->tut_group=='PTCAD 2024') selected @endif>PTCAD 2024</option>
                <option value="PTCAD 2025" @if(!empty($data->tut_group) && $data->tut_group=='PTCAD 2025') selected @endif>PTCAD 2025</option>
                <option value="PTCAD 2026" @if(!empty($data->tut_group) && $data->tut_group=='PTCAD 2026') selected @endif>PTCAD 2026</option>
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group has-label">
            <label>ลำดับการแสดงผล <span class="text-danger">*</span></label>
            <input type="number" class="form-control" name="tut_sort_order" min="1" placeholder="เช่น 1, 2, 3..." value="{{ !empty($data->tut_sort_order) ? $data->tut_sort_order : old('tut_sort_order', 1) }}" />
            <small>ตัวเลขน้อยแสดงก่อน (EP1=1, EP2=2, EP3=3...)</small>
        </div>
    </div>
</div>
                            <br/>
                            <div class="form-group" >
                                <label>คำอธิบายเพิ่มเติม (ถ้ามี)</label>
                                <textarea id="editor" name="tut_detail">@if(!empty($data->tut_detail)){{ $data->tut_detail }}@else{{ old('tut_detail') }}@endif</textarea>
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
                                <input name="tut_show" id="tut_show" class="bootstrap-switch" type="checkbox" data-toggle="switch" data-on-label="<i class='nc-icon nc-check-2'></i>" data-off-label="<i class='nc-icon nc-simple-remove'></i>" data-on-color="success" data-off-color="success"
                                @if(!empty($data->tut_show))
                                    @if($data->tut_show == 1)
                                        checked
                                    @endif
                                @else
                                    checked
                                @endif
                                 />
                            </div>
							<hr>
							<div class="jumbotron">
                                ผู้เพิ่ม Tutorial
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
                                <textarea onkeyup="ChkLength();" rows="5" id="remainLength" name="tut_seo_detail" rows="4" class="form-control" placeholder="อธิบายเกี่ยวกับ Tutorial ไม่เกิน 150 - 170 ตัวอักษร" maxlength="170" >@if(!empty($data->tut_seo_detail)){{ $data->tut_seo_detail }}@else{{ old('tut_seo_detail') }}@endif</textarea>
                                <p id="showNumber_ChkLength" class="error-danger-text"></p>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            @if(!empty($data->tut_thumb))
                            <a href="#" class="remove-logo" data-toggle="modal" data-target="#myDelete" onclick="deleteModal(this)" href="#" data-id="{{ $data->id }}" data-name="{{ $data->tut_thumb }}">
                                <button class="btn btn-icon btn-round btn-google" type="button">
                                    <i class="fa fa-times"></i>
                                </button>
                            </a>
                            @endisset
                            <div class="text-align-center">
                                @isset($data->tut_thumb)
                                    <input type="hidden" class="form-control" id="tut_thumb_old" name="tut_thumb_old" value="{{ $data->tut_thumb }}">
                                    <img id="blah1" src="{{ asset('storage/tutorial/' . $data->tut_thumb) }}" alt="" class="full-width" rel="nofollow">
                                @else
                                    <img id="blah1" src="{{ asset('images/default-img/no-img.jpg')}}" alt="..." class="full-width" rel="nofollow">
                                @endisset
                            </div>
                            <br/>
                            <input type="file" accept="image/*" class="form-control" id="tut_thumb" name="tut_thumb" onchange="readURL1(this);">
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
                                    <a href="{{ route('tutorial.index')}}">
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

@if(!empty($data->tut_thumb))
@include('admin.tutorial.modal.deleteCover')
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

<script>
document.addEventListener('DOMContentLoaded', function(){
    var videoInput = document.getElementById('tut_video');
    var durationInput = document.getElementById('tut_duration');
    var thumbAutoInput = document.getElementById('tut_thumb_auto');
    var previewImg = document.getElementById('blah1');

    if (!videoInput) return;

    videoInput.addEventListener('blur', function(){
        var url = this.value.trim();
        if (url === '') return;

        fetch('{{ route("tutorial.fetchVideoInfo") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ video_url: url })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                if (durationInput) durationInput.value = data.duration;
                if (thumbAutoInput) thumbAutoInput.value = data.thumb_filename;
                if (previewImg && data.thumb_preview_url) previewImg.src = data.thumb_preview_url;
            } else {
                alert('ไม่สามารถดึงข้อมูลวิดีโอได้: ' + (data.message || 'กรุณาตรวจสอบลิงก์'));
            }
        })
        .catch(err => {
            console.error(err);
        });
    });
});
</script>

@endsection
