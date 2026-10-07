@extends('layouts.temp_admin')
@section('title'){{$title_page}}@endsection

@section('css')
 <!-- select2 -->
 <link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet" />
 <!-- select2-bootstrap4-theme -->
 <link href="{{ asset('vendor/select2-bootstrap4-theme/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">

 <link href="{{ asset('assets/backend/css/paper-dashboard.css') }}" rel="stylesheet" />

@endsection

@section('js')

@endsection
@section('content')

<div class="row">
    <div class="col-md-12">

        {{
            Form::model($data, [
                'novalidate',
                'route' => ['user.changpasswordUpdate',[$data->id]],
                'id'=>'data-form',
                'method' => 'put',
                'files' => true
            ])
        }}

            <div class="row">
                <div class="col-md-1"></div>

                <div class="col-md-4">
                    <div class="card card-user card-wizard active">
                        <div class="image"></div>
                        <div class="card-body">
                            <div class="author">
                                <div class="picture-container">
                                    <div class="picture">
                                        @isset($data->img)
                                            <img class="picture-src" src="{{ asset('storage/avatar/'.$data->img) }}" alt="..." id="wizardPicturePreview"  />
                                        @else
                                            <img class="picture-src" src="{{ asset('images/default-img/default-avatar.png') }}" alt="..." id="wizardPicturePreview"  />
                                        @endisset
                                    </div>
                                </div>
                                <a href="#" style="text-decoration: none">
                                    <h5 class="title">
                                        @if(!empty($data->displayname)){{ $data->displayname }} @else ชื่อที่จะแสดง @endif
                                    </h5>
                                </a>
                            </div>
                        </div>
                        <div class="card-footer">
                          <hr>
                            <div class="button-container">
                                <div class="row">
                                    <div class="col-lg-12 ml-auto">
                                        {{ $data->email }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="title">เปลี่ยนรหัสผ่าน</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>รหัสผ่านใหม่</label>
                                        <input id="password" name="password" type="password" class="form-control" placeholder="" value="">
                                        @error('password')<small class="error-danger-text">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>ยืนยันรหัสผ่าน</label>
                                        <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" >
                                        @error('password_confirmation')<small class="error-danger-text">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <a href="{{ route('user.edit',['id' => $data->id]) }}">
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
                <div class="col-md-1"></div>
            </div>

        </form>
    </div>
</div>

@endsection

@section('js')


@endsection
