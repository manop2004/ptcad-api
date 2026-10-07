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
                    'route' => 'popup.crate',
                    'id'=>'data-form',
                    'method' => 'post',
                    'files' => true
                ])
            }}
        @else
            {{
                Form::model($data, [
                    'novalidate',
                    'route' => ['popup.update',[$data->id]],
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
                                <div class="col-md-6">
                                    <div class="form-group has-label">
                                        <label>รูปแบบการอัพโหลด <span class="text-danger">*</span></label>
                                        <select id="popup_type" name="popup_type" class="form-control" onchange="typePopup(this.value)">
                                            <option value="1" @if(!empty($data->popup_type)) @if($data->popup_type== 1) selected @endif @else selected  @endif>กล่องข้อความ</option>
                                            <option value="2" @if(!empty($data->popup_type)) @if($data->popup_type== 2) selected @endif @endif>อัพโหลดไฟล์ภาพ</option>
                                        </select>
                                    </div>
                                </div>
                                <div id="popup_content" class="col-md-12 @if(!empty($data->popup_type)) @if($data->popup_type== 2) hidden @endif  @endif">
                                    <div class="form-group" >
                                        <textarea id="editor" name="popup_detail">@if(!empty($data->popup_detail)){{ $data->popup_detail }}@else{{ old('popup_detail') }}@endif</textarea>
                                    </div>
                                </div>
                                <div id="popup_upload" class="col-md-12 @if(!empty($data->popup_type)) @if($data->popup_type== 1) hidden @endif @else hidden  @endif">
                                    <br/>
                                    <input type="file" accept="image/*" class="form-control" id="popup_img" name="popup_img" onchange="readURL1(this);">
                                    <small class="error-danger-text">* หากไฟล์ภาพมีขนาดไม่เท่ากับที่กำหนด ไฟล์จะบีบอัดอัตโนมัติเพื่อให้ได้ขนาดที่ต้องการ (อาจทำให้ภาพยืดหรือหดได้)</small><br/>
                                    <br/>
                                    <div class="text-align-center">
                                        @isset($data->popup_img)
                                            <input type="hidden" class="form-control" id="popup_img_old" name="popup_img_old" value="{{ $data->popup_img }}">
                                            <img id="blah1" src="{{ asset('storage/popup/' . $data->popup_img) }}" alt="" class="full-width" rel="nofollow">
                                        @else
                                            <img id="blah1" src="{{ asset('images/default-img/no-img.jpg')}}" alt="..." class="full-width" rel="nofollow">
                                        @endisset
                                    </div>
                                    <br/>
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
                                <input name="popup_show" id="popup_show" class="bootstrap-switch" type="checkbox" data-toggle="switch" data-on-label="<i class='nc-icon nc-check-2'></i>" data-off-label="<i class='nc-icon nc-simple-remove'></i>" data-on-color="success" data-off-color="success"
                                @if(!empty($data->popup_show))
                                    @if($data->popup_show == 1) checked @endif
                                @else checked @endif
                                />
                            </div>
                            <hr/>
                            <div class="jumbotron">
                                การแสดงผล
                            </div>
                            <div class="form-group">
                                <div class="form-check-radio">
                                    <label class="form-check-label">
                                      <input class="form-check-input" type="radio" name="sizeModel" id="sizeModel1" value="1" @if(!empty($data->sizeModel)) @if($data->sizeModel == 1) checked @endif @else checked @endif> ขนาดเล็ก
                                      <span class="form-check-sign"></span>
                                    </label>
                                </div>
                                <div class="form-check-radio">
                                    <label class="form-check-label">
                                      <input class="form-check-input" type="radio" name="sizeModel" id="sizeModel2" value="2" @if(!empty($data->sizeModel)) @if($data->sizeModel == 2) checked @endif @endif> ขนาดกลาง
                                      <span class="form-check-sign"></span>
                                    </label>
                                </div>
                                <div class="form-check-radio">
                                    <label class="form-check-label">
                                      <input class="form-check-input" type="radio" name="sizeModel" id="sizeModel3" value="3" @if(!empty($data->sizeModel)) @if($data->sizeModel == 3) checked @endif @endif> ขนาดใหญ่
                                      <span class="form-check-sign"></span>
                                    </label>
                                </div>
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
                </div>
            </div>

        </form>
    </div>
</div>

@endsection

@section('js')

<!-- ckeditor 4 -->
<script src="{{ asset('vendor/ckeditor4/ckeditor.js?v=4') }}"></script>
<script>
    CKEDITOR.replace( 'editor');
</script>
@endsection
