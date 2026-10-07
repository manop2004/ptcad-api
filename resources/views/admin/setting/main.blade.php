@extends('layouts.temp_admin')
@section('title'){{$title_page}}@endsection

@section('css')

 <style>
    .jumbotron {
        padding: 1rem;
        margin-bottom: 1rem;
    }
 </style>

@endsection

@section('content')

{{
    Form::model($data, [
        'novalidate',
        'route' => ['setting.updateSeting',$data->id],
        'id'=>'data-form',
        'method' => 'put',
        'files' => true
    ])
}}

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="jumbotron">
                        Logo Desktop <small class="error-danger-text">*</small>
                    </div>
                    @if(!empty($data->setting_logoWeb))
                    <a href="#" class="remove-logo" data-toggle="modal" data-target="#myDeletelogo" onclick="deleteModal(this)" href="#" data-id="{{ $data->id }}" data-name="{{ $data->setting_logoWeb }}">
                        <button class="btn btn-icon btn-round btn-google" type="button">
                            <i class="fa fa-times"></i>
                        </button>
                    </a>
                    @endisset
                    <div class="text-align-center">
                        @isset($data->setting_logoWeb)
                            <input type="hidden" class="form-control" id="setting_logoWeb_old" name="setting_logoWeb_old" value="{{ $data->setting_logoWeb }}">
                            <img id="blah1" src="{{ asset('storage/setting/' . $data->setting_logoWeb) }}" alt="" class="logo-wight bg-img" rel="nofollow">
                        @else
                            <img id="blah1" src="{{ asset('images/default-img/default-logo-200-100.png')}}" alt="..." class="logo-wight bg-img" rel="nofollow">
                        @endisset
                    </div>
                    <br/>
                    <br/>
                    <input type="file" accept="image/*" class="form-control" id="setting_logoWeb" name="setting_logoWeb" onchange="readURL1(this);">
                    <p></p><small>ขนาดไฟล์ Logo คือ 200 X 100 PX</small><br/>
                    <small class="error-danger-text">* เว้นระยะขอบบนและขอบล่างเล็กน้อยเพื่อความสวยงาม</small><br/>
                    <small class="error-danger-text">* หากไฟล์ภาพมีขนาดไม่เท่ากับที่กำหนด ไฟล์จะบีบอัดอัตโนมัติเพื่อให้ได้ขนาดที่ต้องการ (อาจทำให้ภาพยืดหรือหดได้)</small><br/>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="jumbotron">
                        Logo Mobile <small class="error-danger-text">*</small>
                    </div>
                    @if(!empty($data->setting_logoWeb_mobile))
                    <a href="#" class="remove-logo" data-toggle="modal" data-target="#myDeletelogoMobile" onclick="deleteModal3(this)" href="#" data-id="{{ $data->id }}" data-name="{{ $data->setting_logoWeb_mobile }}">
                        <button class="btn btn-icon btn-round btn-google" type="button">
                            <i class="fa fa-times"></i>
                        </button>
                    </a>
                    @endisset
                    <div class="text-align-center">
                        @isset($data->setting_logoWeb_mobile)
                            <input type="hidden" class="form-control" id="setting_logoWeb_mobile_old" name="setting_logoWeb_mobile_old" value="{{ $data->setting_logoWeb_mobile }}">
                            <img id="blah3" src="{{ asset('storage/setting/' . $data->setting_logoWeb_mobile) }}" alt="" class="logo-wight bg-img" rel="nofollow">
                        @else
                            <img id="blah3" src="{{ asset('images/default-img/default-logo-200-100.png')}}" alt="..." class="logo-wight bg-img" rel="nofollow">
                        @endisset
                    </div>
                    <br/>
                    <br/>
                    <input type="file" accept="image/*" class="form-control" id="setting_logoWeb_mobile" name="setting_logoWeb_mobile" onchange="readURL3(this);">
                    <p></p><small>ขนาดไฟล์ Logo คือ 200 X 100 PX</small><br/>
                    <small class="error-danger-text">* เว้นระยะขอบบนและขอบล่างเล็กน้อยเพื่อความสวยงาม</small><br/>
                    <small class="error-danger-text">* หากไฟล์ภาพมีขนาดไม่เท่ากับที่กำหนด ไฟล์จะบีบอัดอัตโนมัติเพื่อให้ได้ขนาดที่ต้องการ (อาจทำให้ภาพยืดหรือหดได้)</small><br/>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    @if(!empty($data->setting_iconWeb))
                    <a href="#" class="remove-logo" data-toggle="modal" data-target="#myDeleteicon" onclick="deleteModal2(this)" href="#" data-id="{{ $data->id }}" data-name="{{ $data->setting_iconWeb }}">
                        <button class="btn btn-icon btn-round btn-google" type="button">
                            <i class="fa fa-times"></i>
                        </button>
                    </a>
                    @endisset
                    <div class="text-align-center">
                        @isset($data->setting_iconWeb)
                            <input type="hidden" class="form-control" id="setting_iconWeb_old" name="setting_iconWeb_old" value="{{ $data->setting_iconWeb }}">
                            <img id="blah2" src="{{ asset('storage/setting/' . $data->setting_iconWeb) }}" alt="" class="icon-width" rel="nofollow">
                        @else
                            <img id="blah2" src="{{ asset('images/default-img/no-img.jpg')}}" alt="..." class="icon-width" rel="nofollow">
                        @endisset
                    </div>
                    <br/>
                    <br/>
                    <input type="file" accept="image/*" class="form-control" id="setting_iconWeb" name="setting_iconWeb" onchange="readURL2(this);">
                    <p></p><small>ขนาดไฟล์ icon คือ 60 X 60 PX</small><br/>
                    <small class="error-danger-text">* หากไฟล์ภาพมีขนาดไม่เท่ากับที่กำหนด ไฟล์จะบีบอัดอัตโนมัติเพื่อให้ได้ขนาดที่ต้องการ (อาจทำให้ภาพยืดหรือหดได้)</small><br/>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    @if(!empty($data->setting_coverShare))
                    <a href="#" class="remove-logo" data-toggle="modal" data-target="#myDeleteicon" onclick="deleteModal2(this)" href="#" data-id="{{ $data->id }}" data-name="{{ $data->setting_coverShare }}">
                        <button class="btn btn-icon btn-round btn-google" type="button">
                            <i class="fa fa-times"></i>
                        </button>
                    </a>
                    @endisset
                    <div class="text-align-center">
                        @isset($data->setting_coverShare)
                            <input type="hidden" class="form-control" id="setting_coverShare_old" name="setting_coverShare_old" value="{{ $data->setting_coverShare }}">
                            <img id="blah4" src="{{ asset('storage/setting/' . $data->setting_coverShare) }}" alt="" class="full-width" rel="nofollow">
                        @else
                            <img id="blah4" src="{{ asset('images/default-img/no-img.jpg')}}" alt="..." class="full-width" rel="nofollow">
                        @endisset
                    </div>
                    <br/>
                    <br/>
                    <input type="file" accept="image/*" class="form-control" id="setting_coverShare" name="setting_coverShare" onchange="readURL4(this);">
                    <small class="error-danger-text">* หากไฟล์ภาพมีขนาดไม่เท่ากับที่กำหนด ไฟล์จะบีบอัดอัตโนมัติเพื่อให้ได้ขนาดที่ต้องการ (อาจทำให้ภาพยืดหรือหดได้)</small><br/>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <div class="jumbotron">
                            ชื่อเว็บไซต์ <small class="error-danger-text">*</small>
                        </div>
                        <input class="form-control" id="setting_nameWeb" name="setting_nameWeb" value="@isset($data->setting_nameWeb){{ $data->setting_nameWeb }}@endisset" />
                        @error('setting_nameWeb')<small class="error-danger-text">{{ $message }}</small> @enderror
                    </div>
                    <div class="form-group">
                        <div class="jumbotron">
                            รายละเอียดเว็บไซต์
                            <br/>
                            (คือ คำอธิบายที่เกี่ยวกับ Website จะไม่แสดงในเว็บไซต์ แต่จะแสดงที่หน้าการแสดงผลการค้นหาของ Google)
                        </div>
                        <textarea rows="6" class="form-control" id="setting_detail" name="setting_detail">@isset($data->setting_detail){{ $data->setting_detail }}@endisset</textarea>
                        @error('setting_detail')<small class="error-danger-text">{{ $message }}</small> @enderror
                    </div>
                    <div class="form-group">
                        <div class="jumbotron">
                            คีย์เวิร์ด
                            <br/>
                            (คือ คีย์เวิร์ดที่เกี่ยวข้องเว็บไซต์ สำหรับเพิ่มการค้นหาใน Google ประมาณ 10 คีย์เวิร์ด และใช้เครื่องหมายคอมม่า (,) คั่นระหว่างคีย์เวิร์ดแต่ละคำ โดยไม่ต้องเว้นวรรคข้างหลังคอมม่า)
                        </div>
                        <input class="form-control" id="setting_keyword" name="setting_keyword" value="@isset($data->setting_keyword){{ $data->setting_keyword }}@endisset" />
                        @error('setting_keyword')<small class="error-danger-text">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <div class="jumbotron">
                            DBD Registered หรือ DBD Verified (Source Code)
                        </div>
                        <textarea rows="3" class="form-control" id="setting_DBD" name="setting_DBD">@isset($data->setting_DBD){{ $data->setting_DBD }}@endisset</textarea>
                        @error('setting_DBD')<small class="error-danger-text">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <div class="jumbotron">
                            Email สำหรับรับข้อมูลการเเจ้งเตือนต่างๆ เช่น สถานะการสั่งซื้อของออเดอร์, การแนะนำสมาชิก ฯลฯ (BCC TO)
                        </div>
                        <input class="form-control" id="setting_email_bcc" name="setting_email_bcc" value="@isset($data->setting_email_bcc){{ $data->setting_email_bcc }}@endisset"/>
                        @error('setting_email_bcc')<small class="error-danger-text">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <div class="jumbotron">
                            Email สำหรับรับข้อมูลบริการลูกค้า / บริการช่วยเหลือ (Support)
                        </div>
                        <input class="form-control" id="setting_email_support" name="setting_email_support" value="@isset($data->setting_email_support){{ $data->setting_email_support }}@endisset"/>
                        @error('setting_email_support')<small class="error-danger-text">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        {{-- <div class="jumbotron">
                            <input name="setting_birthday" id="setting_birthday" class="bootstrap-switch" type="checkbox" data-toggle="switch" data-on-label="<i class='nc-icon nc-check-2'></i>" data-off-label="<i class='nc-icon nc-simple-remove'></i>" data-on-color="success" data-off-color="success"
                            @if(!empty($data->setting_birthday))
                                @if($data->setting_birthday == 1) checked @endif
                            @endif
                            />
                            เปิดใช้งานระบบวันเกิด
                        </div> --}}
                        <div class="jumbotron">
                            <input name="setting_ssl" id="setting_ssl" class="bootstrap-switch" type="checkbox" data-toggle="switch" data-on-label="<i class='nc-icon nc-check-2'></i>" data-off-label="<i class='nc-icon nc-simple-remove'></i>" data-on-color="success" data-off-color="success"
                            @if(!empty($data->setting_ssl))
                                @if($data->setting_ssl == 1) checked @endif
                            @endif
                            />
                            เว็บไซต์ติดตั้ง SSL
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

@include('admin.setting.modal.deleteLogo')
@include('admin.setting.modal.deleteLogoMobile')
@include('admin.setting.modal.deleteIcon')
@endsection

@section('js')


@endsection
