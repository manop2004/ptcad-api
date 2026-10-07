@extends('layouts.temp_admin')
@section('title'){{$title_page}}@endsection

@section('css')
    <style>
        .jumbotron{
            padding: 1rem 1rem !important;
            margin-bottom: 1rem;
            min-height: 188px
        }
    </style>
@endsection

@section('content')

    @if(empty($data))
        {{
            Form::open([
                'novalidate',
                'route' => 'setting.crateExtensions',
                'id'=>'data-form',
                'method' => 'post',
                'files' => true
            ])
        }}
    @else
        {{
            Form::model($data, [
                'novalidate',
                'route' => ['setting.updateExtensions',[$data->id]],
                'id'=>'data-form',
                'method' => 'put',
                'files' => true
            ])
        }}
    @endif

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <div class="jumbotron">
                            <h4>Google Webmaster tools</h4>
                            <p>คือ บริการฟรีจาก Google ซึ่งเป็นเครื่องมือสำหรับช่วยเหลือผู้ใช้งานทั่วๆ ไปเพื่อเพิ่มโอกาสในการแสดงผลที่ดีขึ้น ในผลการค้นหาของ Google</p>
                        </div>
                        <input class="form-control" id="ext_googleWebmaster" name="ext_googleWebmaster" value="@isset($data->ext_googleWebmaster){{ $data->ext_googleWebmaster }}@endisset" />
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <div class="jumbotron">
                            <h4>Google Analytics</h4>
                            <p>คือ บริการฟรีจาก Google ที่ช่วยในการเก็บข้อมูลผู้เยี่ยมชมเว็บไซต์ เพื่อที่จะนำข้อมูลไปวิเคราะห์ปรับปรุงในส่วนงานต่างๆ ไม่ว่าจะเป็นการทำการตลาด การซื้อโฆษณา การปรับเปลี่ยนเว็บไซต์ เป็นต้น</p>
                        </div>
                        <input class="form-control" id="ext_googleAnalytics" name="ext_googleAnalytics" value="@isset($data->ext_googleAnalytics){{ $data->ext_googleAnalytics }}@endisset" />
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <div class="jumbotron">
                            <h4>Google Adsense</h4>
                            <p>คือ บริการจาก Google ที่เปิดโอกาสให้ผู้ที่มีเว็บไซต์สามารถหารายได้จาก Google โดยการนำเว็บไซต์ของตนเองไปสมัครเป็นสมาชิก หลังจากนั้น Google จะเป็นผู้กำหนดและส่งโฆษณาที่มีเนื้อหาเกี่ยวข้องกับเว็บไซต์มาให้</p>
                        </div>
                        <textarea class="form-control" id="ext_googleAdsense" name="ext_googleAdsense">@isset($data->ext_googleAdsense){{ $data->ext_googleAdsense }}@endisset</textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <div class="jumbotron">
                            <h4>Histats</h4>
                            <p>คือ เครื่องสำหรับใช้เก็บสถิติการเข้าชมเว็บไซต์ ซึ่งสามารถเลือกการแสดงรายงานเป็นรายวัน รายเดือน รายปี ก็ได้ ตามที่ผู้ใช้ต้องการ</p>
                        </div>
                        <textarea class="form-control" id="ext_histats" name="ext_histats"  >@isset($data->ext_histats){{ $data->ext_histats }}@endisset</textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <div class="jumbotron">
                            <h4>reCAPTCHA - Google</h4>
                            คือ เทคนิคที่ใช้ในการทดสอบผู้ใช้บริการว่าเป็นมนุษย์จริงๆ ไม่ใช่โปรแกรมอัตโนมัติ (bot) โดยเวอร์ชั่นที่ต้องการใช้งานคือ เวอร์ชั่น 3 <a href="https://www.google.com/recaptcha/about/" target="_bank" style="color: #000; text-decoration: underline;">คลิก!! เพื่อไปยัง reCAPTCHA - Google</a>
                        </div>
                        <div class="form-group has-label">
                            <input name="ext_captcha_status" id="ext_captcha_status" class="bootstrap-switch" type="checkbox" data-toggle="switch" data-on-label="<i class='nc-icon nc-check-2'></i>" data-off-label="<i class='nc-icon nc-simple-remove'></i>" data-on-color="success" data-off-color="success"
                            @if(!empty($data->ext_captcha_status))
                                @if($data->ext_captcha_status == 1)
                                    checked
                                @endif
                           @endif
                             />
                             เปิดใช้งาน reCAPTCHA - Google
                        </div>
                        <hr/>
                        <input class="form-control" id="ext_captcha" name="ext_captcha" value="@isset($data->ext_captcha){{ $data->ext_captcha }}@endisset" placeholder="คีย์ของเว็บไซต์" />
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <div class="jumbotron">
                            <h4>การแจ้งเตือน Line Notify</h4>
                            คือ การส่งการแจ้งเตือนผ่านทาง Line Notify <a href="https://notify-bot.line.me/th/" target="_bank" style="color: #000; text-decoration: underline;">สร้าง token คลิกที่นี่</a>
                        </div>
                        <div class="form-group has-label">
                            <input name="ext_lineNotify_status" id="ext_lineNotify_status" class="bootstrap-switch" type="checkbox" data-toggle="switch" data-on-label="<i class='nc-icon nc-check-2'></i>" data-off-label="<i class='nc-icon nc-simple-remove'></i>" data-on-color="success" data-off-color="success"
                            @if(!empty($data->ext_lineNotify_status))
                                @if($data->ext_lineNotify_status == 1)
                                    checked
                                @endif
                            @endif
                             />
                             เปิดการใช้งาน Line Notify
                        </div>
                        <hr/>
                        <input class="form-control" id="ext_lineNotify" name="ext_lineNotify" value="@isset($data->ext_lineNotify){{ $data->ext_lineNotify }}@endisset" placeholder="Token" />
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <div class="jumbotron">
                            <h4>เข้าสู่ระบบด้วยบัญชี Google</h4>
                            คือ การเข้าสู่ระบบโดยการใช้บัญชีของ Google
                        </div>
                        <div class="form-group has-label">
                            <input name="ext_google_status" id="ext_google_status" class="bootstrap-switch" type="checkbox" data-toggle="switch" data-on-label="<i class='nc-icon nc-check-2'></i>" data-off-label="<i class='nc-icon nc-simple-remove'></i>" data-on-color="success" data-off-color="success"
                            @if(!empty($data->ext_google_status))
                                @if($data->ext_google_status == 1)
                                    checked
                                @endif
                            @endif
                             />
                             เปิดการใช้งาน Line Notify
                        </div>
                        <hr/>
                        <input class="form-control" id="ext_google_clientId" name="ext_google_clientId" value="@isset($data->ext_google_clientId){{ $data->ext_google_clientId }}@endisset" placeholder="Google Client Id" />
                        <br/>
                        <input class="form-control" id="ext_google_clientSecret" name="ext_google_clientSecret" value="@isset($data->ext_google_clientSecret){{ $data->ext_google_clientSecret }}@endisset" placeholder="Google Client Secret" />
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <div class="jumbotron">
                            <h4>เข้าสู่ระบบด้วยบัญชี Facebook</h4>
                            คือ การเข้าสู่ระบบโดยการใช้บัญชีของ Facebook
                        </div>
                        <div class="form-group has-label">
                            <input name="ext_facebook_status" id="ext_facebook_status" class="bootstrap-switch" type="checkbox" data-toggle="switch" data-on-label="<i class='nc-icon nc-check-2'></i>" data-off-label="<i class='nc-icon nc-simple-remove'></i>" data-on-color="success" data-off-color="success"
                            @if(!empty($data->ext_facebook_status))
                                @if($data->ext_facebook_status == 1)
                                    checked
                                @endif
                            @endif
                                />
                                เปิดการใช้งาน Line Notify
                        </div>
                        <hr/>
                        <input class="form-control" id="ext_facebook_clientId" name="ext_facebook_clientId" value="@isset($data->ext_facebook_clientId){{ $data->ext_facebook_clientId }}@endisset" placeholder="Facebook Client Id" />
                        <br/>
                        <input class="form-control" id="ext_facebook_clientSecret" name="ext_facebook_clientSecret" value="@isset($data->ext_facebook_clientSecret){{ $data->ext_facebook_clientSecret }}@endisset" placeholder="Facebook Client Secret" />
                    </div>
                </div>
            </div>
        </div> --}}
        @if(!empty($data->updated_by))
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <label>อัพเดตข้อมูลโดย :: {{ $data->updated_by}} :: {{ $data->updated_at}} </label>
                </div>
            </div>
        </div>
        @endif
        <div class="col-md-12">
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



@endsection
