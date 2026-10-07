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
        @if(empty($customcode))
            {{
                Form::open([
                    'novalidate',
                    'route' => 'custom.crate',
                    'id'=>'customcode-form',
                    'method' => 'post',
                    'files' => true
                ])
            }}
        @else
            {{
                Form::model($customcode, [
                    'novalidate',
                    'route' => ['custom.update',[$customcode->id]],
                    'id'=>'customcode-form',
                    'method' => 'put',
                    'files' => true
                ])
            }}
        @endif

            <input class="form-control" id="txt_type" name="txt_type" value="{{ $type }}" type="hidden" >

            <div class="row">
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group has-label">
                                <label>หัวข้อ *</label>
                               <input class="form-control" id="txt_title" name="txt_title" value="@if(!empty($customcode->custom_title)) {{ $customcode->custom_title }} @endif" />
                                @error('txt_title')<small class="error-danger-text">{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group has-label">
                                <textarea rows="10" class="form-control no-max-height" id="txt_detail" name="txt_detail" >@if(!empty($customcode->custom_detail)) {{ $customcode->custom_detail }} @endif</textarea>
                                @error('txt_detail')<small class="error-danger-text">{{ $message }}</small> @enderror
                            </div>
                            @if(!empty($customcode->updated_by))
                            <div class="line"></div>
                            <div class="form-group has-label">
                                <label>อัพเดตข้อมูลโดย :: {{ $customcode->updated_by}} :: {{ $customcode->updated_at}} </label>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <div class="jumbotron">
                                    บันทึกแบบร่าง / เผยแพร่
                                </div>
                                <div class="form-group">
                                    <input name="txt_show" id="txt_show" class="bootstrap-switch" type="checkbox" data-toggle="switch" data-on-label="<i class='nc-icon nc-check-2'></i>" data-off-label="<i class='nc-icon nc-simple-remove'></i>" data-on-color="success" data-off-color="success"
                                    @if(!empty($customcode->custom_show))
                                        @if($customcode->custom_show == 1) checked @endif
                                    @else checked @endif
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <div class="jumbotron">
                                    การแสดงผล
                                </div>
                                <div >
                                    <div class="form-check-radio">
                                        <label class="form-check-label">
                                          <input class="form-check-input" @if(!empty($customcode->displayType)) @if($customcode->displayType == 1) checked @endif @else checked @endif type="radio" name="displayType" id="displayType1" value="1"> HEAD
                                          <span class="form-check-sign"></span>
                                        </label>
                                    </div>
                                    <div class="form-check-radio">
                                        <label class="form-check-label">
                                          <input class="form-check-input" @if(!empty($customcode->displayType)) @if($customcode->displayType == 2) checked @endif @endif type="radio" name="displayType" id="displayType2" value="2"> BODY
                                          <span class="form-check-sign"></span>
                                        </label>
                                    </div>
                                    <div class="form-check-radio">
                                        <label class="form-check-label">
                                          <input class="form-check-input" @if(!empty($customcode->displayType)) @if($customcode->displayType == 3) checked @endif @endif type="radio" name="displayType" id="displayType3" value="3"> FOOTER
                                          <span class="form-check-sign"></span>
                                        </label>
                                    </div>
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
                                    <a href="{{ route('custom.index', ['code'=> $type ])}}">
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
