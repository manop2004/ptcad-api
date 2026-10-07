<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta name="robots" content="index, follow" />
<meta http-equiv="Content-Language" content="th">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="author" content="@if(!empty($setting->setting_nameWeb)){{ $setting->setting_nameWeb }}@endif" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5" />
@php
    $setting = App\Models\TbSetting::first();
    $extension = App\Models\TbExtension::first();
    $customcode = App\Models\TbCustomcode::count();
@endphp

<link rel="icon" href="@if(!empty($setting->setting_iconWeb)){{ asset('storage/setting/'.$setting->setting_iconWeb) }}@endif" type ="image/x-icon">
<link rel="shortcut icon" href="@if(!empty($setting->setting_iconWeb)){{ asset('storage/setting/'.$setting->setting_iconWeb) }}@endif" type="image/x-icon">
<title>ปฏิทินโปรโมชั่น @if(!empty($setting->setting_nameWeb))| {{$setting->setting_nameWeb}}@endif</title>
<meta name="csrf-token" content="{{ csrf_token() }}">

<meta property="og:locale" content="TH" />
<meta property="og:site_name" content="8Baht" />
<meta property="og:type" content=""/>
<meta property="og:title" content="ปฏิทินโปรโมชั่น @if(!empty($setting->setting_nameWeb))| {{$setting->setting_nameWeb}}@endif" />
<meta property="og:description" content="ปฏิทินโปรโมชั่น" />
<meta property="og:url" content="{{ route('fronend.promotion.event') }}" />
<meta property="og:image" content="@if(!empty($setting->setting_coverShare)){{ asset('storage/setting/'.$setting->setting_coverShare) }}@endif" />

<link rel="stylesheet" href="{{ asset('assets/fontend/css/bootstrap.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/fontend/style.min.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/fontend/css/swiper.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/fontend/css/dark.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/fontend/css/font-icons.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/fontend/css/animate.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/fontend/css/magnific-popup.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/fontend/css/responsive.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/fontend/css/components/datepicker.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/fontend/css/components/timepicker.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/fontend/styles/custom.min.css?v=5') }}" type="text/css" />

</head>
<body class="stretched">
    <div id="displayLoagging" class="display-none">
        <div id="containerLoadding">
            <div class="divider" aria-hidden="true"></div>
            <p class="loading-text" aria-label="Loading">
            <span class="letter" aria-hidden="true">L</span>
            <span class="letter" aria-hidden="true">o</span>
            <span class="letter" aria-hidden="true">a</span>
            <span class="letter" aria-hidden="true">d</span>
            <span class="letter" aria-hidden="true">i</span>
            <span class="letter" aria-hidden="true">n</span>
            <span class="letter" aria-hidden="true">g</span>
            </p>
        </div>
    </div>
    <div id="wrapper" class="clearfix">
        <section id="content">

			<div class="content-wrap">
                <section id="page-title">
                    <div class="container clearfix">
                        <h1>ปฏิทินโปรโมชั่น 8Baht</h1>
                        <ol class="breadcrumb">
                            <li><a href="{{ route('fronend.home') }}">หน้าหลัก</a></li>
                            <li class="active">ปฏิทินโปรโมชั่น 8Baht</li>
                        </ol>
                    </div>
                </section>
				<div class="container clearfix">

                    @if(count($promotions) != 0)
                        <div id="posts" class="events small-thumbs">
                            @foreach ($promotions as $promotion)
                                <div class="entry clearfix">
                                    @if(!empty($promotion->promo_img))
                                        <div class="entry-image">
                                            <a href="{{ $promotion->promo_link}}">
                                                <img src="{{ asset('storage/promotion/'.$promotion->promo_img) }}" alt="{{ $promotion->promo_name }}">
                                            </a>
                                        </div>
                                    @endif
                                    <div class="entry-c">
                                        <div class="entry-title">
                                            <h2><a href="{{ $promotion->promo_link}}">{{ $promotion->promo_name }}</a></h2>
                                        </div>
                                        <div class="entry-content">
                                            <div>วันที่เริ่มโปรโมชั่น : {{ date("d-m-Y",strtotime($promotion->promo_start_date)) }}</div>
                                            <div>วันที่หมดโปรโมชั่น : {{ date("d-m-Y",strtotime($promotion->promo_end_date)) }}</div>
                                            <br/>
                                            <div id="ck_editer" class="entry-content notopmargin">{!! $promotion->promo_note !!}</div>
                                            @if(!empty($promotion->promo_link))
                                                <br/>
                                                <a href="{{ $promotion->promo_link }}" target="_bank">Link Promotion Click!</a>
                                            @endif
                                            {{-- <a href="{{ route('fronend.preview.promotion',$promotion->id) }}" class="btn btn-danger">เพิ่มเติม...</a> --}}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="clear"></div>
                            <br/>
                            <div class="nav-link-entry">{!! $promotions->links() !!}</div>
                            <br/>
                            <br/>
                            <div class="clear"></div>
                        </div>
                    @else
                        <div class="topmargin bottommargin center">
                            <h4 class="">ไม่พบข้อมูล</h4>
                        </div>
                    @endif

				</div>

			</div>

		</section>
    </div>

    <script type="text/javascript" src="{{ asset('assets/fontend/js/jquery.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/fontend/js/plugins.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/fontend/js/functions.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/sweetalert2/dist/sweetalert2.all.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/fontend/js/components/moment.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/fontend/js/components/datepicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/fontend/js/custom.min.js?v=2') }}"></script>

</body>
</html>
