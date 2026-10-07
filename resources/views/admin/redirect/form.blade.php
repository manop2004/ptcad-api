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
                    'route' => 'redirect.crate',
                    'id'=>'data-form',
                    'method' => 'post',
                    'files' => true
                ])
            }}
        @else
            {{
                Form::model($data, [
                    'novalidate',
                    'route' => ['redirect.update',[$data->id]],
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
                                <label>URL ที่ต้องการตั้งค่าให้เปลี่ยนหน้า *</label>
                               <input class="form-control" id="redirect_old" name="redirect_old" value="@if(!empty($data->redirect_old)){{ $data->redirect_old }}@else{{ old('redirect_old') }}@endif" />
                                @error('redirect_old')<small class="error-danger-text">{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group has-label">
                                <label>URL ที่ต้องการให้ Rredirect ไป *</label>
                                <input class="form-control no-max-height" id="redirect_new" name="redirect_new" value="@if(!empty($data->redirect_new)){{ $data->redirect_new }}@else{{ old('redirect_new') }}@endif" />
                                @error('redirect_new')<small class="error-danger-text">{{ $message }}</small> @enderror
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
                                <input name="redirect_show" id="redirect_show" class="bootstrap-switch" type="checkbox" data-toggle="switch" data-on-label="<i class='nc-icon nc-check-2'></i>" data-off-label="<i class='nc-icon nc-simple-remove'></i>" data-on-color="success" data-off-color="success"
                                @if(!empty($data->redirect_show))
                                    @if($data->redirect_show == 1) checked @endif
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
                                    <a href="{{ route('redirect.index')}}">
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
