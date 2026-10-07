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
    #previewForm .modal-content {
        padding: 3rem
    }
</style>

@if(!empty($settingForm->bgColor))
<style>
    #previewForm .modal-body{
        background: #{{ $settingForm->bgColor }};
    }
</style>
@endif

@if(!empty($settingForm->pdpaColor))
<style>
    #previewForm .modal-body .pdpa a{
        color: #{{ $settingForm->pdpaColor }};
    }
</style>
@endif

@if(!empty($settingForm->fontColor))
<style>
    #previewForm .modal-body .title,
    #previewForm .modal-body .title-sub,
    #previewForm .modal-body .pdpa,
    #previewForm .modal-body label{
        color: #{{ $settingForm->fontColor }};
    }
</style>
@endif

@if(!empty($settingForm->radiusTopright))
@if($settingForm->radiusTopright == 1)<style>#previewForm .modal-body{ border-top-right-radius: {{ $settingForm->radiusForm }}{{ 'px' }}; }</style>@endif
@endif
@if(!empty($settingForm->radiusBottomright))
@if($settingForm->radiusBottomright == 1)<style>#previewForm .modal-body{ border-bottom-right-radius: {{ $settingForm->radiusForm }}{{ 'px' }}; }</style>@endif
@endif
@if(!empty($settingForm->radiusTopleft))
@if($settingForm->radiusTopleft == 1)<style>#previewForm .modal-body{ border-top-left-radius: {{ $settingForm->radiusForm }}{{ 'px' }}; }</style>@endif
@endif
@if(!empty($settingForm->radiusBottomleft))
@if($settingForm->radiusBottomleft == 1)<style>#previewForm .modal-body{ border-bottom-left-radius: {{ $settingForm->radiusForm }}{{ 'px' }}; }</style>@endif
@endif



@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
            {{
                Form::open([
                    'novalidate',
                    'route' => ['onepage.setting.crate',['page'=>$item->id]],
                    'id'=>'data-form',
                    'method' => 'post',
                    'files' => true
                ])
            }}
            <input type="hidden" class="form-control no-max-height" name="onepageId" value="{{ $item->id }}" />
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <a href="{{ route('onepage.setting.form',$item->id) }}" class="btn btn-info"><i class="nc-icon nc-paper"></i> จัดการฟิลด์สำหรับเพิ่มข้อมูล</a>
                                    <button type="button" data-toggle="modal" data-target="#previewForm" class="btn btn-warning"><i class="nc-icon nc-zoom-split"></i> ดูตัวอย่างการจัดรูปแบบ</button>
                                    {{-- <a href="{{ route('onepage.edit',$item->id) }}" class="btn">ย้อนกลับ <i class="nc-icon nc-minimal-right"></i></a> --}}
                                    <hr/>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group has-label">
                                        <label>CRM Campaign Id *</label>
                                        <input class="form-control no-max-height" disabled value="@if(!empty($item->campaignid)){{ $item->campaignid }}@endif" />
                                    </div>
                                    <div class="form-group has-label">
                                        <label>ชื่อหน้าเพจ *</label>
                                        <input class="form-control no-max-height" disabled value="@if(!empty($item->name)){{ $item->name }}@endif" />
                                    </div>
                                    <div class="form-group has-label">
                                        <label>หัวข้อแบบฟอร์ม *</label>
                                        <input class="form-control" id="formName" name="formName" value="@if(!empty($settingForm->formName)){{ $settingForm->formName }}@endif" />
                                        @error('formName')<small class="error-danger-text">{{ $message }}</small><br/>@enderror
                                    </div>
                                    <div class="form-group has-label">
                                        <label>รายละเอียดแบบฟอร์ม </label>
                                        <textarea rows="5" class="form-control" id="formDetail" name="formDetail" >@if(!empty($settingForm->formDetail)){{ $settingForm->formDetail }}@endif</textarea>
                                    </div>
                                    <div class="form-group has-label">
                                        <label>ข้อความยอมรับนโยบายความเป็นส่วนตัว (PDPA)  *</label>
                                        <textarea rows="5" class="form-control" id="formPDPA" name="formPDPA" >@if(!empty($settingForm->formPDPA)){{ $settingForm->formPDPA }}@endif</textarea>
                                        @error('formPDPA')<small class="error-danger-text">{{ $message }}</small><br/>@enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group has-label">
                                        <label>สีพื้นหลังปุ่มยืนยันฟอร์ม</label>
                                        <input id="bgButton" name="bgButton" class="form-control" @if(!empty($settingForm->bgButton)) value="{{ $settingForm->bgButton }}" @else value="rgba(255,160,0,0.5)" @endif  data-jscolor="{preset:'large', position:'right'}">
                                    </div>
                                    <div class="form-group has-label">
                                        <label>สีพื้นหลังตัวอักษรปุ่มยืนยันฟอร์ม</label>
                                        <input id="colorButton" name="colorButton" class="form-control" @if(!empty($settingForm->colorButton)) value="{{ $settingForm->colorButton }}" @else value="rgba(255,160,0,0.5)" @endif  data-jscolor="{preset:'large', position:'right'}">
                                    </div>
                                    <div class="form-group has-label">
                                        <label>คำที่จะแสดงบนปุ่มยืนยันฟอร์ม *</label>
                                        <input class="form-control" id="wordButton" name="wordButton" value="@if(!empty($settingForm->wordButton)){{ $settingForm->wordButton }}@endif" />
                                    </div>
                                    <div class="form-group has-label">
                                        <label>ความกว้างของปุ่ม (%)</label>
                                        <input class="form-control" id="widthButton" name="widthButton" value="@if(!empty($settingForm->widthButton)){{ $settingForm->widthButton }}@endif" />
                                    </div>
                                    <div class="margin-t-20 margin-b-20">
                                        <label>อัพโหลดภาพพื้นหลังปุ่ม</label>
                                        <input type="file" accept="image/*" class="form-control" id="imageButton" name="imageButton" onchange="readURL1(this);">
                                        <p></p><small>ขนาดไฟล์ภาพพื้นหลังปุ่ม คือ 280 X 50 PX</small><br/>
                                        @if(!empty($settingForm->imageButton))
                                            <a href="{{ asset('storage/onepages/'.$settingForm->imageButton) }}" target="_target"><small>{{ asset('storage/onepages/'.$settingForm->imageButton) }}</small></a>
                                            <a href="#" data-toggle="modal" data-target="#deleteImg" onclick="deleteModal(this)" href="#" data-name="{{ $settingForm->imageButton }}" data-id="{{ $settingForm->id }}"><small class="error-danger-text"> x ลบไฟล์</small></a>
                                        @endif
                                    </div>
                                    <div class="form-group has-label">
                                        <label>* หากไม่ต้องการให้แสดงรายละเอียดของ Input</label>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input id="checklabel" name="checklabel" class="form-check-input" type="checkbox"
                                                @if(!empty($settingForm->checklabel))
                                                    @if($settingForm->checklabel == 1) checked @endif
                                                @endif
                                                >
                                                <span class="form-check-sign"></span>
                                                ไม่แสดง Label
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group has-label">
                                        <label>* หากไม่ต้องการให้แสดงช่องสำหรับ Checkbox PDPA</label>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input id="checkpdpa" name="checkpdpa" class="form-check-input" type="checkbox"
                                                @if(!empty($settingForm->checkpdpa))
                                                    @if($settingForm->checkpdpa == '1') checked @endif
                                                @endif
                                                >
                                                <span class="form-check-sign"></span>
                                                ไม่แสดง Checkbox
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group has-label">
                                        <label>สีพื้นหลังแบบฟอร์ม</label>
                                        <input id="bgColor" name="bgColor" class="form-control" @if(!empty($settingForm->bgColor)) value="{{ $settingForm->bgColor }}" @else value="rgba(255,160,0,0.5)" @endif  data-jscolor="{preset:'large', position:'right'}">
                                    </div>
                                    <div class="form-group has-label">
                                        <label>สีตัวอักษร Tag Link ("นโยบายความเป็นส่วนตัว")</label>
                                        <input id="pdpaColor" name="pdpaColor" class="form-control" @if(!empty($settingForm->pdpaColor)) value="{{ $settingForm->pdpaColor }}" @else value="rgba(255,160,0,0.5)" @endif  data-jscolor="{preset:'large', position:'right'}">
                                    </div>
                                    <div class="form-group has-label">
                                        <label>สีตัวอักษรบนฟอร์ม</label>
                                        <input id="fontColor" name="fontColor" class="form-control" @if(!empty($settingForm->fontColor)) value="{{ $settingForm->fontColor }}" @else value="rgba(255,160,0,0.5)" @endif  data-jscolor="{preset:'large', position:'right'}">
                                    </div>
                                    <div class="form-group has-label">
                                        <label>ความโค้งมนของแบบฟอร์ม (.PX)</label>
                                        <input id="radiusForm" name="radiusForm" class="form-control" @if(!empty($settingForm->radiusForm)) value="{{ $settingForm->radiusForm }}" @else value="0" @endif >
                                    </div>
                                    <div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                              <input class="form-check-input" type="checkbox" id="radiusTopright" name="radiusTopright"
                                                @if(!empty($settingForm->radiusTopright))
                                                    @if($settingForm->radiusTopright == '1') checked @endif
                                                @endif
                                              >
                                              <span class="form-check-sign"></span>
                                              ความโค้งมนของมุมบนด้านซ้ายมือ
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                              <input class="form-check-input" type="checkbox" id="radiusBottomright" name="radiusBottomright"
                                              @if(!empty($settingForm->radiusBottomright))
                                                  @if($settingForm->radiusBottomright == '1') checked @endif
                                              @endif
                                            >
                                              <span class="form-check-sign"></span>
                                              ความโค้งมนของมุมล่างด้านซ้ายมือ
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                              <input class="form-check-input" type="checkbox" id="radiusTopleft" name="radiusTopleft"
                                              @if(!empty($settingForm->radiusTopleft))
                                                  @if($settingForm->radiusTopleft == '1') checked @endif
                                              @endif
                                            >
                                              <span class="form-check-sign"></span>
                                              ความโค้งมนของมุมบนด้านขวามือ
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                              <input class="form-check-input" type="checkbox" id="radiusBottomleft" name="radiusBottomleft"
                                              @if(!empty($settingForm->radiusBottomleft))
                                                  @if($settingForm->radiusBottomleft == '1') checked @endif
                                              @endif
                                            >
                                              <span class="form-check-sign"></span>
                                              ความโค้งมนของมุมล่างด้านขวามือ
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                @if(!empty($settingForm->updated_by))
                                <div class="col-md-12">
                                    <div class="line"></div>
                                    <div class="form-group has-label">
                                        <label>อัพเดตข้อมูลโดย :: {{ $settingForm->updated_by}} :: {{ $settingForm->updated_at}} </label>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-6">
                                    <a href="{{ route('onepage.edit',$item->id)}}">
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


<div class="modal fade" id="previewForm" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" >
            <div class="modal-body" >
                <h3 class="title text-center title-up">{{ $settingForm->formName}}</h3>
                <div class="text-center title-sub">{{ $settingForm->formDetail}}</div>
                <hr/>
                <div class="row">
                    @foreach ($data as $p_form)
                        <div class="{{ $p_form->col }} margin-b-10">
                            <div class="form-group">
                                @if($settingForm->checklabel == 2)<label>{{ $p_form->fieldTH }}</label>@endif
                                @if ($p_form->type == 'input')
                                    <input placeholder="{{ $p_form->fieldTH }}" class="form-control"/>
                                @elseif($p_form->type == 'textarea')
                                    <textarea placeholder="{{ $p_form->fieldTH }}" class="form-control"></textarea>
                                @elseif($p_form->type == 'select')
                                    <select class="form-control">
                                        <option > -- กรุณาเลือกข้อมูล{{ $p_form->fieldTH }} --</option>
                                    </select>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                @if(!empty($settingForm->checkpdpa))
                <br/>
                    <div class="form-group pdpa">
                        @if($settingForm->checkpdpa == 2)
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input id="checkpdpa" name="checkpdpa" class="form-check-input" type="checkbox">
                                    <span class="form-check-sign"></span>{!! $settingForm->formPDPA !!}
                                </label>
                            </div>
                        @else
                            <div class="text-center">{!! $settingForm->formPDPA !!}</div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@include('admin.onepage.modal.deleteImage')

@endsection

@section('js')
<script src="{{ asset('assets/backend/js/plugins/bootstrap-tagsinput.js') }}"></script>
<!-- select2 -->
<script src="{{ asset('vendor/select2/select2.min.js') }}"></script>
<!-- select2-bootstrap4-theme -->
<script src="{{ asset('vendor/select2-bootstrap4-theme/docs/script.js') }}"></script>
<!-- jscolor -->
<script src="{{ asset('vendor/jscolor-2.4.6/jscolor.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.select-child').select2();
    });

</script>
@endsection
