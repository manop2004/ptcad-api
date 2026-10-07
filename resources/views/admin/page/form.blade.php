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
                    'route' => 'page.crate',
                    'id'=>'data-form',
                    'method' => 'post',
                    'files' => true
                ])
            }}
        @else
            {{
                Form::model($data, [
                    'novalidate',
                    'route' => ['page.update',[$data->id]],
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
                            <div class="form-group">
                                <label>ประเภทลิงค์หน้าเพจ</label>
                                <br/>
                                <div class="form-check-radio display-inline-block nobottommargin">
                                    <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="pages_type" id="pages_type1" value="1"  @if(!empty($data->pages_type)) @if($data->pages_type == 1) checked @endif @else checked @endif> Permalink
                                    <span class="form-check-sign"></span>
                                    </label>
                                </div>
                                <div class="form-check-radio display-inline-block nobottommargin">
                                    <label class="form-check-label">
                                      <input class="form-check-input" type="radio" name="pages_type" id="pages_type2" value="2" @if(!empty($data->pages_type)) @if($data->pages_type == 2) checked @endif @endif> URL
                                      <span class="form-check-sign"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group has-label">
                                <label>ชื่อหน้าเพจ *</label>
                               <input class="form-control" id="pages_name" name="pages_name" value="@if(!empty($data->pages_name)){{ $data->pages_name }}@else{{ old('pages_name') }}@endif" />
                                @error('pages_name')<small class="error-danger-text">{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group has-label">
                                <label>Permalink / URL *</label>
                                <input onkeyup="ChkEng();" class="form-control no-max-height" id="page_parmalink" name="page_parmalink" value="@if(!empty($data->page_parmalink)){{ $data->page_parmalink }}@else{{ old('page_parmalink') }}@endif" />
                                @if(!empty($data->page_parmalink))
                                    @if($data->pages_type == 1)
                                        <a href="{{ route('page.preview',$data->page_parmalink) }}" target="_bank">{{ route('fronend.page.content',$data->page_parmalink) }}</a>
                                        <br/>
                                    @else
                                        <a href="{{ $data->page_parmalink }}" target="_bank">{{ $data->page_parmalink }}</a>
                                        <br/>
                                    @endif
                                @endif
                                @error('page_parmalink')<small class="error-danger-text">{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group" >
                                <textarea id="editor" name="page_detail">@if(!empty($data->page_detail)){{ $data->page_detail }}@else{{ old('page_detail') }}@endif</textarea>
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
                                <input name="page_show" id="page_show" class="bootstrap-switch" type="checkbox" data-toggle="switch" data-on-label="<i class='nc-icon nc-check-2'></i>" data-off-label="<i class='nc-icon nc-simple-remove'></i>" data-on-color="success" data-off-color="success"
                                @if(!empty($data->page_show))
                                    @if($data->page_show == 1)
                                        checked
                                    @endif
                                @else
                                    checked
                                @endif
                                 />
                            </div>
                            <hr/>
                            <div class="jumbotron">
                                แนะนำหน้าเพจ
                            </div>
                            <div class="form-group">
                                <input name="page_recommend" id="page_recommend" class="bootstrap-switch" type="checkbox" data-toggle="switch" data-on-label="<i class='nc-icon nc-check-2'></i>" data-off-label="<i class='nc-icon nc-simple-remove'></i>" data-on-color="success" data-off-color="success"
                                @if(!empty($data->page_recommend))
                                    @if($data->page_recommend == 1)
                                        checked
                                    @endif
                                @else
                                    checked
                                @endif
                                 />
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="jumbotron">
                                SEO Description
                            </div>
                            <div class="form-group">
                                <textarea onkeyup="ChkLength();" rows="5" id="remainLength" name="page_seo_detail" rows="4" class="form-control" placeholder="อธิบายเกี่ยวกับหน้าเพจไม่เกิน 150 - 170 ตัวอักษร" maxlength="170" >@if(!empty($data->page_seo_detail)){{ $data->page_seo_detail }}@else{{ old('page_seo_detail') }}@endif</textarea>
                                <p id="showNumber_ChkLength" class="error-danger-text"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-6">
                                    <a href="{{ route('page.index')}}">
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

            $("#art_keyword").select2({
                tags: true,
                tokenSeparators: [',', ' ']
            })
            var old_tag = $('#old_art_keyword').val();
            var old_tag = old_tag.split(",");

            $.ajax({
                type: "GET",
                url: '{!! route('logtag.json') !!}',
                cache: false,
                beforeSend: function () { },
                success: function (response) {

                    if(response.length != 0){

                        $("#art_keyword").html('');
                        var addTag = [];
                        var selected = '';
                        $.each(response, function (index, item) {

                            var tagJson = item.split(",");
                            tagJson.forEach(function (Item) {

                                if(old_tag.indexOf(Item) != -1){
                                    selected = 'selected';
                                }else{
                                    selected = '';
                                }

                                addTag +='<option value="' + Item + '" '+selected+' >' + Item + "</option>"


                            })

                            $("#art_keyword").append(addTag);


                        });

                    }else{
                        $("#art_keyword").html('');
                    }

                },
                failure: function (errMsg) {
                    alert(errMsg);
                }
            });
        });

    </script>

@endsection
