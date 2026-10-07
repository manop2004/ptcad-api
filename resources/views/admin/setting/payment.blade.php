@extends('layouts.temp_admin')
@section('title'){{$title_page}}@endsection

@section('css')

<!-- select2 -->
<link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet" />
<!-- select2-bootstrap4-theme -->
<link href="{{ asset('vendor/select2-bootstrap4-theme/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">

 <style>
    .jumbotron {
        padding: 1rem;
        margin-bottom: 1rem;
    }
 </style>

@endsection

@section('content')

@if(empty($data))
    {{
        Form::open([
            'novalidate',
            'route' => 'setting.cratePayment',
            'id'=>'data-form',
            'method' => 'post',
            'files' => true
        ])
    }}
@else
    {{
        Form::model($data, [
            'novalidate',
            'route' => ['setting.updatePayment',[$data->id]],
            'id'=>'data-form',
            'method' => 'put',
            'files' => true
        ])
    }}
@endif

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <div class="jumbotron">
                            <input name="bank_transfer_status" id="bank_transfer_status" class="bootstrap-switch" type="checkbox" data-toggle="switch" data-on-label="<i class='nc-icon nc-check-2'></i>" data-off-label="<i class='nc-icon nc-simple-remove'></i>" data-on-color="success" data-off-color="success"
                            @if(!empty($data->bank_transfer_status))
                                @if($data->bank_transfer_status == 1) checked @endif
                            @endif
                            />
                            เปิดใช้การชำระเงินผ่านบัญชีธนาคาร
                        </div>
                        <div class="jumbotron">
                            <input name="credit_card_status" id="credit_card_status" class="bootstrap-switch" type="checkbox" data-toggle="switch" data-on-label="<i class='nc-icon nc-check-2'></i>" data-off-label="<i class='nc-icon nc-simple-remove'></i>" data-on-color="success" data-off-color="success"
                            @if(!empty($data->credit_card_status))
                                @if($data->credit_card_status == 1) checked @endif
                            @endif
                            />
                            เปิดใช้การชำระเงินผ่านบัตรเครดิต
                        </div>
                        <div class="jumbotron">
                            <input name="installment_status" id="installment_status" class="bootstrap-switch" type="checkbox" data-toggle="switch" data-on-label="<i class='nc-icon nc-check-2'></i>" data-off-label="<i class='nc-icon nc-simple-remove'></i>" data-on-color="success" data-off-color="success"
                            @if(!empty($data->installment_status))
                                @if($data->installment_status == 1) checked @endif
                            @endif
                            />
                            เปิดใช้การผ่อนชำระ
                        </div>
						
						<div class="jumbotron">
                            <input name="promtpay_status" id="promtpay_status" class="bootstrap-switch" type="checkbox" data-toggle="switch" data-on-label="<i class='nc-icon nc-check-2'></i>" data-off-label="<i class='nc-icon nc-simple-remove'></i>" data-on-color="success" data-off-color="success"
                            @if(!empty($data->promtpay_status))
                                @if($data->promtpay_status == 1) checked @endif
                            @endif
                            />
                            เปิดใช้พร้อมเพย์
                        </div>
						<div class="jumbotron">
                            <input name="mobile_banking_status" id="mobile_banking_status" class="bootstrap-switch" type="checkbox" data-toggle="switch" data-on-label="<i class='nc-icon nc-check-2'></i>" data-off-label="<i class='nc-icon nc-simple-remove'></i>" data-on-color="success" data-off-color="success"
                            @if(!empty($data->mobile_banking_status))
                                @if($data->mobile_banking_status == 1) checked @endif
                            @endif
                            />
                            เปิดใช้โมบายแบงก์กิ้ง
                        </div>
						<div class="jumbotron">
                            <input name="truemoney_status" id="truemoney_status" class="bootstrap-switch" type="checkbox" data-toggle="switch" data-on-label="<i class='nc-icon nc-check-2'></i>" data-off-label="<i class='nc-icon nc-simple-remove'></i>" data-on-color="success" data-off-color="success"
                            @if(!empty($data->truemoney_status))
                                @if($data->truemoney_status == 1) checked @endif
                            @endif
                            />
                            เปิดใช้ทรูมันนี่วอลเล็ท
                        </div>
						
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <div class="jumbotron">
                            เชื่อมข้อมูลการผ่อนชำระกับเงื่อนไขบริการ
                        </div>
                        <select id="conditionId" name="conditionId" class="form-control" >
                            <option value="">กรุณาเลือกข้อมูล</option>
                            @foreach ($conditions as $condition)
                                <option value="{{ $condition->id }}" @if(!empty($data->conditionId)) @if($data->conditionId == $condition->id) selected @endif @endif>{{ $condition->condition_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="jumbotron">
                        ตั้งค่าระบบชำระเงิน OMISE <small class="error-danger-text">*</small>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <br/>
                                <div class="form-group">
                                    <div class="form-check-radio display-inline-block">
                                        <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="omise_status" id="omise_status1" value="1"  @if(!empty($data->omise_status)) @if($data->omise_status == 1) checked @endif @endif> ปิดใช้งาน
                                        <span class="form-check-sign"></span>
                                        </label>
                                    </div>
                                    <div class="form-check-radio display-inline-block">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="omise_status" id="omise_status2" value="2" @if(!empty($data->omise_status)) @if($data->omise_status == 2) checked @endif @endif> เปิดใช้งาน
                                            <span class="form-check-sign"></span>
                                        </label>
                                    </div>
                                    <div class="form-check-radio display-inline-block">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="omise_status" id="omise_status3" value="3"  @if(!empty($data->omise_status)) @if($data->omise_status == 3) checked @endif @else checked @endif> เปิดโหมดทดสอบ
                                            <span class="form-check-sign"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Public key for live</label>
                                <input class="form-control" id="omise_public_key_for_live" name="omise_public_key_for_live" value="@isset($data->omise_public_key_for_live){{ $data->omise_public_key_for_live }}@endisset" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Secret key for live</label>
                                <input class="form-control" id="omise_secret_key_for_live" name="omise_secret_key_for_live" value="@isset($data->omise_secret_key_for_live){{ $data->omise_secret_key_for_live }}@endisset" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Public key for test</label>
                                <input class="form-control" id="omise_public_key_for_test" name="omise_public_key_for_test" value="@isset($data->omise_public_key_for_test){{ $data->omise_public_key_for_test }}@endisset" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Secret key for test</label>
                                <input class="form-control" id="omise_secret_key_for_test" name="omise_secret_key_for_test" value="@isset($data->omise_secret_key_for_test){{ $data->omise_secret_key_for_test }}@endisset" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if(!empty($data->updated_by))
                <div class="card">
                    <div class="card-body">
                        <label>อัพเดตข้อมูลโดย :: {{ $data->updated_by}} :: {{ $data->updated_at}} </label>
                    </div>
                </div>
            @endif
            <div class="card">
                <div class="card-footer">
                    <div class="right">
                        @include('layouts.admin._button.submit')
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

@endsection
