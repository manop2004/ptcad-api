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
                    'route' => 'type.crate',
                    'id'=>'data-form',
                    'method' => 'post',
                    'files' => true
                ])
            }}
        @else
            {{
                Form::model($data, [
                    'novalidate',
                    'route' => ['type.update',[$data->id]],
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
                                    <div class="form-group has-label">
                                        <label>ชื่อประเภทสินค้า</label>
                                        <input class="form-control no-max-height" id="type_name" name="type_name" value="@if(!empty($data->type_name)){{ $data->type_name }}@else{{ old('type_name') }}@endif" />
                                        @error('type_name')<small class="error-danger-text">{{ $message }}</small><br/>@enderror
                                    </div>
                                </div>
                                @if(!empty($settingVat))
                                <div class="col-md-6">
                                    <div class="form-group has-label">
                                        <label>ภาษีมูลค่าเพิ่ม (%)</label>
                                        @if($settingVat->show == 1)
                                            <input disabled class="form-control no-max-height" value="@if(!empty($settingVat->vat)){{ $settingVat->vat }}@else{{ '0' }}@endif" />
                                            <input type="hidden" class="form-control no-max-height" id="type_vat" name="type_vat" value="@if(!empty($settingVat->vat)){{ $settingVat->vat }}@else{{ '0' }}@endif" />
                                        @else
                                            <input disabled class="form-control no-max-height" value="0" />
                                            <input type="hidden" class="form-control no-max-height" id="type_vat" name="type_vat" value="0" />
                                        @endif
                                    </div>
                                </div>
                                @endif
                                <div class="col-md-6">
                                    <div class="form-group has-label">
                                        <label>หัก ณ ที่จ่าย (%)</label>
                                        <input class="form-control no-max-height" id="type_withholding" name="type_withholding" value="@if(!empty($data->type_withholding)){{ $data->type_withholding }}@else{{ old('type_withholding') }}@endif" />
                                        <small class="error-danger-text">* หากไม่มีการหัก ณ ที่จ่าย ให้ใส่ 0 ไว้</small><br/>
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
                                <input name="type_show" id="type_show" class="bootstrap-switch" type="checkbox" data-toggle="switch" data-on-label="<i class='nc-icon nc-check-2'></i>" data-off-label="<i class='nc-icon nc-simple-remove'></i>" data-on-color="success" data-off-color="success"
                                @if(!empty($data->type_show))
                                    @if($data->type_show == 1) checked @endif
                                @else checked @endif
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
                                    <a href="{{ route('type.index')}}">
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


@endsection
