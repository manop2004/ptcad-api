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
                    'route' => 'promotion.setting.linetify.crate',
                    'id'=>'data-form',
                    'method' => 'post',
                    'files' => true
                ])
            }}
        @else
            {{
                Form::model($data, [
                    'novalidate',
                    'route' => ['promotion.setting.linetify.update',[$data->id]],
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
                                        <label>ชื่อกลุ่ม</label>
                                        <input class="form-control no-max-height" id="groupname" name="groupname" value="@if(!empty($data->groupname)){{ $data->groupname }}@else{{ old('groupname') }}@endif" />
                                        @error('groupname')<small class="error-danger-text">{{ $message }}</small><br/>@enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group has-label">
                                        <label>Token Line Notify</label>
                                        <input class="form-control no-max-height" id="token_linenotify" name="token_linenotify" value="@if(!empty($data->token_linenotify)){{ $data->token_linenotify }}@else{{ old('token_linenotify') }}@endif" />
                                        @error('token_linenotify')<small class="error-danger-text">{{ $message }}</small><br/>@enderror
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
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <div class="jumbotron">
                                    การแจ้งเตือนผ่าน Line Notify
                                </div>
                                <div >
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input name="grouptype1" class="form-check-input" type="checkbox" value="1" @if(!empty($data->grouptype1)) @if($data->grouptype1 == 1) checked @endif  @endif>
                                            <span class="form-check-sign"></span>
                                            Group PTCAD
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input name="grouptype2" class="form-check-input" type="checkbox" value="1" @if(!empty($data->grouptype2)) @if($data->grouptype2 == 1) checked @endif @endif>
                                            <span class="form-check-sign"></span>
                                            Group Gstarcad
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
                                    <a href="{{ route('promotion.setting.linetify.index')}}">
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


@include('admin.promotion.modal.deleteImg')

@endsection

@section('js')

<!-- jscolor-2.4.6 -->
<script src="{{ asset('vendor/jscolor-2.4.6/jscolor.min.js') }}"></script>

@endsection
