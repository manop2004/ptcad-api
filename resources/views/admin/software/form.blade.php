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

@if(empty($data))
    {{
        Form::open([
            'novalidate',
            'route' => 'software.crate',
            'id'=>'data-form',
            'method' => 'post',
            'files' => true
        ])
    }}
@else
    {{
        Form::model($data, [
            'novalidate',
            'route' => ['software.update',[$data->id]],
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
                                <label>ชื่อผู้ใช้งาน<span class="text-danger">*</span></label>
                                <select id="userId" name="userId" class="form-control">
                                    <option value="">--เลือกข้อมูล--</option>
                                    @foreach ($users as $user )
                                        <option value="{{ $user->id }}" @if(!empty($data->userId)) @if($user->id == $data->userId) selected @endif @endif>{{ $user->name }} {{ $user->lastname }}</option>
                                    @endforeach
                                </select>
                                @error('userId')<small class="error-danger-text">{{ $message }}</small>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group has-label">
                                <label>ประเภท License<span class="text-danger">*</span></label>
                                <select id="license_type" name="license_type" class="form-control">
                                    <option value="1" @if(!empty($data->license_type)) @if($data->license_type == 1) selected @endif @else selected @endif>Perpetual (ซื้อขาด)</option>
                                    <option value="2" @if(!empty($data->license_type)) @if($data->license_type == 2) selected @endif @endif>Annual (รายปี)</option>
                                </select>
                                <small class="text-warning">* เลือก Annual ระบบจะคำนวณ "วันที่หมดอายุ" ให้อัตโนมัติ (เริ่มใช้งาน + 365 วัน) แก้ไขเองได้หลังคำนวณ</small>
                                @error('license_type')<br/><small class="error-danger-text">{{ $message }}</small>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group has-label">
                                <label>รหัสสินค้า<span class="text-danger">*</span></label>
                                <input class="form-control no-max-height" id="name" name="productCode" value="@if(!empty($data->productCode)){{ $data->productCode }}@else{{ old('productCode') }}@endif" />
                                <small class="text-warning">* กรุณากรอกรหัสสินค้า เพื่อให้เชื่อมโยงกับสินค้าในระบบ</small>
                                @error('productCode')<br/><small class="error-danger-text">{{ $message }}</small>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group has-label">
                                <label>Serial number<span class="text-danger">*</span></label>
                                <input class="form-control no-max-height" id="serial_number" name="serial_number" value="@if(!empty($data->serial_number)){{ $data->serial_number }}@else{{ old('serial_number') }}@endif" />
                                @error('serial_number')<small class="error-danger-text">{{ $message }}</small>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group has-label">
                                <label>วันที่เริ่มใช้งาน<span class="text-danger">*</span></label>
                                <input class="form-control no-max-height datepicker" id="date_start" name="date_start" value="@if(!empty($data->date_start)){{ date("d-m-Y",strtotime($data->date_start)) }}@else{{ old('date_start') }}@endif" />
                                @error('date_start')<small class="error-danger-text">{{ $message }}</small>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group has-label">
                                <label>วันที่หมดอายุ<span class="text-danger">*</span></label>
                                <input class="form-control no-max-height datepicker" id="date_exp" name="date_exp" value="@if(!empty($data->date_exp)){{ date("d-m-Y",strtotime($data->date_exp)) }}@else{{ old('date_exp') }}@endif" />
                                <small id="date_exp_hint" class="text-muted"></small>
                                @error('date_exp')<small class="error-danger-text">{{ $message }}</small>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group has-label">
                                <label>ราคา<span class="text-danger">*</span></label>
                                <input class="form-control no-max-height" id="price" name="price" value="@if(!empty($data->price)){{ $data->price }}@else{{ old('price') }}@endif" />
                                @error('price')<small class="error-danger-text">{{ $message }}</small>@enderror
                            </div>
                        </div>
                        <div class="col-md-6"></div>
                        <div class="col-md-12">
                            <div class="form-group has-label">
                                <label>รายละเอียดเพิ่มเติม</label>
                                <textarea id="editor" rows="5" class="form-control" name="note">@if(!empty($data->note)){{ $data->note }}@else{{ old('note') }}@endif</textarea>
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
                        <input name="show" id="show" class="bootstrap-switch" type="checkbox" data-toggle="switch" data-on-label="<i class='nc-icon nc-check-2'></i>" data-off-label="<i class='nc-icon nc-simple-remove'></i>" data-on-color="success" data-off-color="success"
                        @if(!empty($data->show))
                            @if($data->show == 1) checked @endif
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
                            <a href="{{ route('software.index')}}">
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

@endsection

@section('js')
<!-- select2 -->
<script src="{{ asset('vendor/select2/select2.min.js') }}"></script>
<!-- select2-bootstrap4-theme -->
<script src="{{ asset('vendor/select2-bootstrap4-theme/docs/script.js') }}"></script>

<script>
    // ==========================================================================
    // Auto-calculate "วันที่หมดอายุ" เมื่อเลือกประเภท License = Annual (365 วัน)
    // ไม่ยุ่งกับ datepicker plugin เดิม แค่ set ค่า .val() เข้า input ตรงๆ
    // ==========================================================================
    (function(){
        function parseDMY(str){
            // รับรูปแบบ dd-mm-yyyy
            if(!str) return null;
            var parts = str.split('-');
            if(parts.length !== 3) return null;
            var d = parseInt(parts[0], 10);
            var m = parseInt(parts[1], 10) - 1;
            var y = parseInt(parts[2], 10);
            var dt = new Date(y, m, d);
            if(isNaN(dt.getTime())) return null;
            return dt;
        }

        function formatDMY(dt){
            var d = String(dt.getDate()).padStart(2,'0');
            var m = String(dt.getMonth()+1).padStart(2,'0');
            var y = dt.getFullYear();
            return d + '-' + m + '-' + y;
        }

        function recalcExpiry(){
            var licenseType = document.getElementById('license_type').value;
            var hint = document.getElementById('date_exp_hint');

            if(licenseType == '2'){ // Annual
                var startVal = document.getElementById('date_start').value;
                var startDate = parseDMY(startVal);

                if(startDate){
                    var expDate = new Date(startDate.getTime());
                    expDate.setDate(expDate.getDate() + 365);
                    document.getElementById('date_exp').value = formatDMY(expDate);
                    hint.textContent = 'คำนวณอัตโนมัติจากวันที่เริ่มใช้งาน + 365 วัน (แก้ไขเองได้)';
                } else {
                    hint.textContent = 'กรุณากรอก "วันที่เริ่มใช้งาน" ก่อน เพื่อให้คำนวณวันหมดอายุอัตโนมัติ';
                }
            } else { // Perpetual
                hint.textContent = 'Perpetual — กรุณากำหนดวันหมดอายุเอง (เช่นวันที่ไกลๆ หรือตามนโยบายบริษัท)';
            }
        }

        document.addEventListener('DOMContentLoaded', function(){
            var licenseTypeEl = document.getElementById('license_type');
            var dateStartEl = document.getElementById('date_start');

            licenseTypeEl.addEventListener('change', recalcExpiry);

            // ครอบคลุมทั้ง native change และ event ที่ datepicker plugin มักยิงออกมา
            ['change','dp.change','changeDate','blur'].forEach(function(evt){
                dateStartEl.addEventListener(evt, recalcExpiry);
            });

            // เผื่อกรณีแก้ไขข้อมูลเดิมที่เป็น Annual อยู่แล้ว โชว์ hint ตั้งต้นให้ตรงสถานะ
            recalcExpiry();
        });
    })();
</script>
@endsection