@extends('layouts.temp_admin')
@section('title'){{$title_page}}@endsection

@section('css')
<style>
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
                    'route' => ['onepage.setting.form.crate',['page'=>$item->id]],
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
                            <div class="form-group has-label">
                                <button id="addMore_Form" type="button" class="btn btn-info">+ เพิ่มข้อมูล</button>
                                <button type="button" data-toggle="modal" data-target="#previewForm" class="btn btn-warning"><i class="nc-icon nc-zoom-split"></i> ดูตัวอย่างการจัดรูปแบบ</button>
                                {{-- <a href="{{ route('onepage.setting',$item->id) }}" class="btn"><i class="nc-icon nc-paper"></i> ย้อนกลับ <i class="nc-icon nc-minimal-right"></i></a> --}}
                            </div>
                            <div class="form-group has-label">
                                <small>** การเพิ่ม/ลบ/แก้ไข ข้อมูลทุกครั้งต้องกด "บันทึกข้อมูล" เสมอ</small>
                            </div>
                            <hr/>
                            @if(count($data) == 0)
                                <div class="row child_div">
                                    <div class="col-md-2">
                                        <div class="form-group has-label">
                                            <label>ฟิลด์สำหรับกรอกฟอร์ม</label>
                                            <select name="field[]" class="form-control">
                                                <option value="">-- กรุณาเลือกข้อมูล --</option>
                                                <option value="firstname">ชื่อ</option>
                                                <option value="lastname">นามสกุล</option>
                                                <option value="company">บริษัท</option>
                                                <option value="designation">ตำแหน่ง</option>
                                                <option value="department">แผนก</option>
                                                <option value="website">ชื่อเว็บไซต์</option>
                                                <option value="industry">ประเภทอุตสาหกรรม</option>
                                                <option value="email">อีเมล</option>
                                                <option value="phone">เบอร์โทรศัพท์</option>
                                                <option value="mobile">เบอร์มือถือ</option>
                                                <option value="fax">แฟกซ์</option>
                                                <option value="description">ข้อความ</option>
                                                <option value="address">ที่อยู่</option>
                                                <option value="province">จังหวัด</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group has-label">
                                            <label>คำอธิบาย *</label>
                                            <input type="text" class="form-control no-max-height" name="fieldTH[]"  />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group has-label">
                                            <label>การแสดงผล</label>
                                            <select name="col[]" class="form-control">
                                                <option value="col-md-12">col-md-12</option>
                                                <option value="col-md-6">col-md-6</option>
                                                <option value="col-md-4">col-md-4</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-10">
                                        <div class="form-group has-label">
                                            <label>ลำดับการแสดงผล *</label>
                                            <input type="number" class="form-control no-max-height" name="sort[]" value="" />
                                        </div>
                                    </div>
                                    <div class="col-md-1 col-2">
                                        <div class="form-group has-label deleteSettingForm">
                                            <button onclick="deleteChild(this)" type="button" class="btn btn-danger btn-icon btn-sm"><i class="fa fa-times"></i></button>
                                        </div>
                                    </div>
                                </div>
                            @else
                                @foreach ($data as $field)
                                    <div id="block-@if(!empty($field->id)){{ $field->id }}@endif"  class="row">
                                        <div class="col-md-2">
                                            <div class="form-group has-label">
                                                <label>ฟิลด์สำหรับกรอกฟอร์ม</label>
                                                <select name="field[]" class="form-control">
                                                    <option value="">-- กรุณาเลือกข้อมูล --</option>
                                                    <option @if(!empty($field)) @if($field->field == 'firstname') selected @endif  @endif value="firstname">ชื่อ</option>
                                                    <option @if(!empty($field)) @if($field->field == 'lastname') selected @endif  @endif value="lastname">นามสกุล</option>
                                                    <option @if(!empty($field)) @if($field->field == 'company') selected @endif  @endif value="company">บริษัท</option>
                                                    <option @if(!empty($field)) @if($field->field == 'designation') selected @endif  @endif value="designation">ตำแหน่ง</option>
                                                    <option @if(!empty($field)) @if($field->field == 'department') selected @endif  @endif value="department">แผนก</option>
                                                    <option @if(!empty($field)) @if($field->field == 'website') selected @endif  @endif value="website">ชื่อเว็บไซต์</option>
                                                    <option @if(!empty($field)) @if($field->field == 'industry') selected @endif  @endif value="industry">ประเภทอุตสาหกรรม</option>
                                                    <option @if(!empty($field)) @if($field->field == 'email') selected @endif  @endif value="email">อีเมล</option>
                                                    <option @if(!empty($field)) @if($field->field == 'phone') selected @endif  @endif value="phone">เบอร์โทรศัพท์</option>
                                                    <option @if(!empty($field)) @if($field->field == 'mobile') selected @endif  @endif value="mobile">เบอร์มือถือ</option>
                                                    <option @if(!empty($field)) @if($field->field == 'fax') selected @endif  @endif value="fax">แฟกซ์</option>
                                                    <option @if(!empty($field)) @if($field->field == 'description') selected @endif  @endif value="description">ข้อความ</option>
                                                    <option @if(!empty($field)) @if($field->field == 'address') selected @endif  @endif value="address">ที่อยู่</option>
                                                    <option @if(!empty($field)) @if($field->field == 'province') selected @endif  @endif value="province">จังหวัด</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group has-label">
                                                <label>คำอธิบาย *</label>
                                                <input type="text" class="form-control no-max-height" name="fieldTH[]"  value="@if(!empty($field->fieldTH)){{ $field->fieldTH }}@endif"/>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group has-label">
                                                <label>การแสดงผล</label>
                                                <select name="col[]" class="form-control">
                                                    <option @if(!empty($field)) @if($field->col == 'col-md-12') selected @endif  @endif value="col-md-12">col-md-12</option>
                                                    <option @if(!empty($field)) @if($field->col == 'col-md-6') selected @endif  @endif value="col-md-6">col-md-6</option>
                                                    <option @if(!empty($field)) @if($field->col == 'col-md-4') selected @endif  @endif value="col-md-4">col-md-4</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-1">
                                            <div class="form-group has-label">
                                                <label>ลำดับการแสดงผล *</label>
                                                <input type="number" class="form-control no-max-height" name="sort[]" value="@if(!empty($field->sort)){{ $field->sort }}@endif" />
                                            </div>
                                        </div>
                                        <div class="col-md-1 col-2">
                                            <div class="form-group has-label margin-t-15">
                                                <a class="btn btn-danger btn-icon btn-sm btn-delete-settingForm" href="#" data-id="{{ $field->id }}" data-name="{{ $field->fieldTH }}"><i class="fa fa-times"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            <div id="settingForm"></div>
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
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-6">
                                    <a href="{{ route('onepage.setting',$item->id) }}">
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

@endsection

@section('js')

@endsection
