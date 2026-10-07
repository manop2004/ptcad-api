<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head  >
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="{{ asset('/storage/setting/' . $setting->setting_iconWeb) }}" type ="image/x-icon">
        <title>ตั้งค่ารหัสผ่านใหม่ของคุณ | ลืมรหัสผ่าน</title>

        <meta http-equiv="Content-Language" content="th">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta http-equiv="Cache-control" content="public" max-age="604800">

        <!-- template css -->
        <link rel="stylesheet" href="{{ asset('assets/fontend/css/loadding.css') }}" type="text/css"/>
        <link rel="stylesheet" href="{{ asset('assets/fontend/css/bootstrap.css') }}" type="text/css"/>
        <link rel="stylesheet" href="{{ asset('assets/fontend/style.min.css') }}" type="text/css" />
        <link rel="stylesheet" href="{{ asset('assets/fontend/css/swiper.css') }}" type="text/css" />
        <link rel="stylesheet" href="{{ asset('assets/fontend/css/dark.css') }}" type="text/css" />
        <link rel="stylesheet" href="{{ asset('assets/fontend/css/font-icons.css') }}" type="text/css" />
        <link rel="stylesheet" href="{{ asset('assets/fontend/css/animate.css') }}" type="text/css" />
        <link rel="stylesheet" href="{{ asset('assets/fontend/css/magnific-popup.css') }}" type="text/css" />
        <link rel="stylesheet" href="{{ asset('assets/fontend/css/colors.css') }}" type="text/css" />
        <link rel="stylesheet" href="{{ asset('assets/fontend/css/responsive.css') }}" type="text/css" />
        <!-- font -->
        <link rel="stylesheet" href="{{ asset('assets/fonts/sarabun/stylesheet.css') }}" type="text/css">
        <link rel="stylesheet" href="{{ asset('assets/fontend/css/fonts.css?v=11') }}" type="text/css"/>

        <style>
            .stretched,#wrapper,#content{
                background: #efefef;
            }
            .max-page{

                max-width: 600px !important;
                margin-left: auto !important;
                margin-right: auto !important;
                margin-top: 15rem !important;
                background: #fff !important;
                padding: 2rem !important;
            }
            .max-logo{
                width: 100% !important;
                max-width: 200px;
            }
            .invalid-feedback{
                color: red;
            }
        </style>
    </head>
    <body class="stretched">

        <div id="wrapper" class="clearfix">
            <section id="content">
                <div class="content-wrap max-page">
                    <div class="center">
                        <img class="max-logo" src="{{ asset('/storage/setting/'.$setting->setting_logoWeb) }}" />
                    </div>
                    {{
                        Form::model($user, [
                            'novalidate',
                            'route' => ['fronend.forgot.password.update',$user->id],
                            'class' => ($errors->any()) ? 'was-validated form-horizontal' : 'needs-validation form-horizontal',
                            'id'=>'user-form',
                            'method' => 'put',
                            'files' => true
                        ])
                    }}

                            <br/>
                            <br/>
                            <h4>เปลี่ยนรหัสผ่านใหม่สำหรับบัญชีผู้ใช้ของคุณ</h4>
                            <div class="row">
                                <div class="col-md-12">
                                    รหัสผ่านใหม่ <span class="span-danger">*</span>
                                </div>
                                <div class="col-md-12">
                                    <input type="password" placeholder="รหัสผ่านใหม่" id="password" name="password" class="form-control">
                                    @error('password')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                </div>
                            </div>
                            <br/>
                            <div class="row ">
                                <div class="col-md-12">
                                    ยืนยันรหัสผ่านใหม่ <span class="span-danger">*</span>
                                </div>
                                <div class="col-md-12">
                                    <input type="password" placeholder="ยืนยันรหัสผ่านใหม่" id="password_confirmation" name="password_confirmation" class="form-control">
                                    @error('password_confirmation')<small class="invalid-feedback">{{ $message }}</small> @enderror
                                </div>
                            </div>
                            <br/>
                            <div class="row ">
                                <div class="col-md-12">
                                    <a href="{{ route('login') }}" style="color:#1a56c4;">⇒ ไปยังหน้าเข้าสู่ระบบ</a>
                                </div>
                            </div>
                            <br/>
                            <div class="pd-top-10 row">
                                <div class="col-md-12">
                                    <button class="nomargin button button-3d button-rounded button-green btn-block no-mg" type="submit" onclick="loadding();" style="background-color:#1a56c4 !important;border-color:#1a56c4 !important;">
                                        <span class="icon text-white-50">
                                            <i class="far fa-plus-square"></i>
                                        </span>
                                        <span class="text">ยืนยันการเปลี่ยนรหัสผ่าน</span>
                                    </button>

                                </div>
                            </div>
                    </form>
                </div>
            </section>


        </div>
        <!-- canvas js -->
        <script type="text/javascript" src="{{ asset('assets/fontend/js/jquery.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/fontend/js/plugins.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/fontend/js/functions.js') }}"></script>
        <script type="text/javascript" src="{{ asset('vendor/sweetalert2/dist/sweetalert2.all.min.js') }}"></script>
        <!-- custom js -->
        <script type="text/javascript" src="{{ asset('assets/fontend/js/custom.js?v=10') }}"></script>

        @if(session('feedback'))
            <script>

                Swal.fire({
                    title: "{{ session('feedback') }}",
                    text: '',
                    icon: 'success',
                    confirmButtonText: 'ตกลง',
                    timer: 2000
                })

            </script>
        @endif

    </body>
</html>