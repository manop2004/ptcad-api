@extends('layouts.temp_admin')
@section('title'){{$title_page}}@endsection

@section('css')

 <!-- select2 -->
 <link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet" />
 <!-- select2-bootstrap4-theme -->
 <link href="{{ asset('vendor/select2-bootstrap4-theme/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">

 <link href="{{ asset('assets/backend/css/paper-dashboard.css') }}" rel="stylesheet" />

 <style>
    .card-user .image { height: 80px; }
 </style>
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        @if(empty($data))
            {{
                Form::open([
                    'novalidate',
                    'route' => 'user.address.crate',
                    'id'=>'data-form',
                    'method' => 'post',
                    'files' => true
                ])
            }}
        @else
            {{
                Form::model($data, [
                    'novalidate',
                    'route' => ['user.address.update',[$data->id]],
                    'id'=>'data-form',
                    'method' => 'put',
                    'files' => true
                ])
            }}
        @endif


            <div class="row">
                <div class="col-md-4">
                    <div class="card card-user card-wizard active">
                        <div class="image"></div>
                        <div class="card-body">
                            <div class="author">
                                <div class="picture-container">
                                    <div class="picture">
                                        @isset($user->img)
                                            <input type="hidden" class="form-control" id="img_old" name="img_old" value="{{ $user->img }}">
                                            <img class="picture-src" src="{{ asset('storage/avatar/'.$user->img) }}" alt="..." id="wizardPicturePreview"  />
                                        @else
                                            <img class="picture-src" src="{{ asset('images/default-img/default-avatar.png') }}" alt="..." id="wizardPicturePreview"  />
                                        @endisset
                                    </div>
                                </div>
                                <a href="#" style="text-decoration: none">
                                    <h5 class="title">
                                        @if(!empty($user->displayname)){{ $user->displayname }} @else ชื่อที่จะแสดง @endif
                                    </h5>
                                </a>
                            </div>
                        </div>
                        <div class="card-footer">
                            <hr>
                            <div class="button-container">
                            <div class="row">
                                <div class="@if(!empty($user)) col-lg-4 @else col-lg-12 @endif ml-auto">
                                <h5>@if(!empty($articleCount)){{ number_format($articleCount) }}@else 0 @endif
                                    <br>
                                    <small>คำสั่งซื้อ</small>
                                </h5>
                                </div>

                                @if(!empty($user))
                                    <div class="col-lg-4 ml-auto">
                                        <h5>
                                            <i class="nc-icon nc-lock-circle-open"></i>
                                            <br>
                                            <a href="{{ route('user.changpassword', ['id'=> $user->id]) }}" style="text-decoration: none">
                                                <small>รหัสผ่าน</small>
                                            </a>
                                        </h5>
                                    </div>
                                    <div class="col-lg-4 ml-auto">
                                        <h5 >
                                            <i class="nc-icon nc-settings-gear-65"></i>
                                            <br>
                                            <a style="text-decoration: none" href="{{ route('user.level',['id'=>$user->id]) }}">
                                                <small>สิทธิ์ใช้งาน</small>
                                            </a>
                                        </h5>
                                    </div>
                                @endif
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="table-full-width table-responsive">
                                <table class="table nomargin">
                                    <tbody>
                                        <tr>
                                            <td class="text-left noborder">ข้อมูลส่วนตัว</td>
                                            <td class="td-actions text-right noborder">
                                                <a href="{{ route('user.edit',$user->id) }}">
                                                    <button type="button" rel="tooltip" title="" class="btn btn-info btn-round btn-icon btn-icon-mini btn-neutral" data-original-title="อัพเดตข้อมูล">
                                                    <i class="nc-icon nc-ruler-pencil"></i>
                                                    </button>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-left">ที่อยู่สำหรับจัดส่งสินค้า</td>
                                            <td class="td-actions text-right">
                                                <a href="{{ route('user.address',$user->id) }}">
                                                    <button type="button" rel="tooltip" title="" class="btn btn-info btn-round btn-icon btn-icon-mini btn-neutral" data-original-title="อัพเดตข้อมูล">
                                                    <i class="nc-icon nc-ruler-pencil"></i>
                                                    </button>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-left">ที่อยู่สำหรับจัดส่งใบเสร็จรับเงิน</td>
                                            <td class="td-actions text-right">
                                                <a href="{{ route('user.receipt',$user->id) }}">
                                                    <button type="button" rel="tooltip" title="" class="btn btn-info btn-round btn-icon btn-icon-mini btn-neutral" data-original-title="อัพเดตข้อมูล">
                                                    <i class="nc-icon nc-ruler-pencil"></i>
                                                    </button>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                              </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="title">ที่อยู่สำหรับจัดส่งสินค้า</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>ชื่อ <span class="text-danger">*</span></label>
                                        <input id="userId" name="userId" type="hidden" class="form-control" placeholder="" value="@if(!empty($user->id)){{ $user->id}}@else{{ old('userId') }}@endif">
                                        <input id="name" name="name" type="text" class="form-control" placeholder="" value="@if(!empty($data->name)){{ $data->name }}@else{{ old('name') }}@endif">
                                        @error('name')<small class="error-danger-text">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>สกุล <span class="text-danger">*</span></label>
                                        <input id="lastname" name="lastname" type="text" class="form-control" value="@if(!empty($data->lastname)){{ $data->lastname }}@else{{ old('lastname') }}@endif">
                                        @error('lastname')<small class="error-danger-text">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>เบอร์โทรศัพท์ <span class="text-danger">*</span></label>
                                        <input id="tel" name="tel" type="text" class="form-control" value="@if(!empty($data->tel)){{ $data->tel }}@else{{ old('tel') }}@endif">
                                        @error('tel')<small class="error-danger-text">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>บ้านเลขที่ ถนน ซอย <span class="text-danger">*</span></label>
                                        <textarea id="address" name="address" type="text" class="form-control" placeholder="" >@if(!empty($data->address)){{ $data->address }}@else{{ old('address') }}@endif</textarea>
                                        @error('address')<small class="error-danger-text">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                            </div>
                            @include('admin.user.api.form')
                            @if(!empty($data))
                                <input id="hd_province" name="hd_province" type="hidden" value="@if(!empty($data->province)){{ $data->province }}@endif">
                                <input id="hd_amphures" name="hd_amphures" type="hidden" value="@if(!empty($data->tel)){{ $data->amphures }}@endif">
                                <input id="hd_district" name="hd_district" type="hidden" value="@if(!empty($data->tel)){{ $data->district }}@endif">
                                <input id="hd_zipcode" name="hd_zipcode" type="hidden" value="@if(!empty($data->zipcode)){{ $data->zipcode }}@endif">
                            @endif
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>ข้อความถึงผู้ขาย </label>
                                        <textarea id="message" name="message" type="text" class="form-control" placeholder="" >@if(!empty($data->message)){{ $data->message }}@else{{ old('message') }}@endif</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(!empty($data->update_by))
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group has-label">
                                <label>อัพเดตข้อมูลโดย :: {{ $data->update_by}} :: {{ $data->updated_at}} </label>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="card">
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-6">
                                    <a href="{{ route('user.index')}}">
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


@if(!empty($data))
    @include('admin.user._load.amphoes.special')
    @include('admin.user._load.district.special')
@endif

@include('admin.user._load.amphoes.normal')
@include('admin.user._load.district.normal')
@include('admin.user._load.zipcode.normal')

@endsection
