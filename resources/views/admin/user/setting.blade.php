@extends('layouts.temp_admin')
@section('title'){{$title_page}}@endsection

@section('css')
 <!-- select2 -->
 <link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet" />
 <!-- select2-bootstrap4-theme -->
 <link href="{{ asset('vendor/select2-bootstrap4-theme/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">

 <style>
    .jumbotron { padding: 1rem; margin-bottom: 1rem; }
    #cke_1_contents.cke_reset {
        height: 200px !important;
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
                    'route' => 'user.setting.crate',
                    'id'=>'data-form',
                    'method' => 'post',
                    'files' => true
                ])
            }}
        @else
            {{
                Form::model($data, [
                    'novalidate',
                    'route' => ['user.setting.update',[$data->id]],
                    'id'=>'data-form',
                    'method' => 'put',
                    'files' => true
                ])
            }}
        @endif

            <div class="row">
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="jumbotron">
                                <input name="pdpa_status" id="pdpa_status" class="bootstrap-switch" type="checkbox" data-toggle="switch" data-on-label="<i class='nc-icon nc-check-2'></i>" data-off-label="<i class='nc-icon nc-simple-remove'></i>" data-on-color="success" data-off-color="success"
                                @if(!empty($data->pdpa_status))
                                    @if($data->pdpa_status == 1) checked @endif
                                @endif
                                />
                                เปิดใช้งาน PDPA
                            </div>
                            <div class="jumbotron">
                                <input name="business_status" id="business_status" class="bootstrap-switch" type="checkbox" data-toggle="switch" data-on-label="<i class='nc-icon nc-check-2'></i>" data-off-label="<i class='nc-icon nc-simple-remove'></i>" data-on-color="success" data-off-color="success"
                                @if(!empty($data->business_status))
                                    @if($data->business_status == 1) checked @endif
                                @endif
                                />
                                เปิดใช้งานประเภทธุรกิจสำหรับผู้ใช้
                            </div>
                            <div class="jumbotron">
                                <input name="position_status" id="position_status" class="bootstrap-switch" type="checkbox" data-toggle="switch" data-on-label="<i class='nc-icon nc-check-2'></i>" data-off-label="<i class='nc-icon nc-simple-remove'></i>" data-on-color="success" data-off-color="success"
                                @if(!empty($data->position_status))
                                    @if($data->position_status == 1) checked @endif
                                @endif
                                />
                                เปิดใช้งานตำแหน่ง/อาชีพ สำหรับผู้ใช้
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">

                    <div class="card">
                        <div class="card-body">
                            <div class="jumbotron">
                                ตั้งค่าข้อความยิมยอมในการรับข้อมูล (PDPA)
                            </div>
                            <textarea id="editor" name="pdpa_detail">@if(!empty($data->pdpa_detail)){{ $data->pdpa_detail }}@else{{ old('pdpa_detail') }}@endif</textarea>
                            <div class="line"></div>
                            <div class="form-group has-label">
                                @if(!empty($data->created_by))<label>เพิ่มข้อมูลโดย :: {{ $data->created_by}} :: {{ $data->created_at}} </label>@endif
                                @if(!empty($data->updated_by))<br/><label>อัพเดตข้อมูลโดย :: {{ $data->updated_by}} :: {{ $data->updated_at}} </label>@endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3"></div>
                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-6"></div>
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
        CKEDITOR.replace( 'editor');
    </script>
@endsection
