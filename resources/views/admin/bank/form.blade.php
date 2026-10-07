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
                    'route' => 'bank.crate',
                    'id'=>'data-form',
                    'method' => 'post',
                    'files' => true
                ])
            }}
        @else
            {{
                Form::model($data, [
                    'novalidate',
                    'route' => ['bank.update',[$data->id]],
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
                                <label>บัญชีธนาคาร *</label>
                                <select id="bankId" name="bankId" class="form-control" data-placeholder="เลือกธนาคาร">
                                    <option></option>
                                    @foreach ( $banks as $bank)
                                        <option value="{{ $bank->id }}" @if(!empty($data->bankId)) @if($data->bankId == $bank->id ) selected @endif @else @if(old('bankId') == $bank->id ) selected @endif @endif>{{ $bank->bank_name  }}</option>
                                    @endforeach
                                </select>
                                @error('bankId')<small class="error-danger-text">{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group has-label">
                                <label>ชื่อบัญชี *</label>
                                <input class="form-control no-max-height" id="bank_name" name="bank_name" value="@if(!empty($data->bank_name)){{ $data->bank_name }}@else{{ old('bank_name') }}@endif" />
                                @error('bank_name')<small class="error-danger-text">{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group has-label">
                                <label>เลขที่บัญชี *</label>
                                <input class="form-control no-max-height" id="bank_number" name="bank_number" value="@if(!empty($data->bank_number)){{ $data->bank_number }}@else{{ old('bank_number') }}@endif" />
                                @error('bank_number')<small class="error-danger-text">{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group has-label">
                                <label>สาขา *</label>
                                <input class="form-control no-max-height" id="bank_branch" name="bank_branch" value="@if(!empty($data->bank_branch)){{ $data->bank_branch }}@else{{ old('bank_branch') }}@endif" />
                                @error('bank_branch')<small class="error-danger-text">{{ $message }}</small> @enderror
                            </div>
                            @if(!empty($data->updated_by))
                            <div class="line"></div>
                            <div class="form-group has-label">
                                <label>อัพเดตข้อมูลโดย :: {{ $data->updated_by}} :: {{ $data->updated_at}} </label>
                            </div>
                            @endif
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
                                <input name="bank_show" id="bank_show" class="bootstrap-switch" type="checkbox" data-toggle="switch" data-on-label="<i class='nc-icon nc-check-2'></i>" data-off-label="<i class='nc-icon nc-simple-remove'></i>" data-on-color="success" data-off-color="success"
                                @if(!empty($data->bank_show))
                                    @if($data->bank_show == 1) checked @endif
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
                                    <a href="{{ route('bank.index')}}">
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

@endsection
