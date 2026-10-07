<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head  >
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ExtrAXION - 8BAHT.COM</title>
<link rel="icon" href="@if(!empty($setting->setting_iconWeb)){{ asset('storage/setting/'.$setting->setting_iconWeb) }}@endif" type ="image/x-icon">
<link rel="shortcut icon" href="@if(!empty($setting->setting_iconWeb)){{ asset('storage/setting/'.$setting->setting_iconWeb) }}@endif" type="image/x-icon">

<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="robots" content="index, follow" />
<meta http-equiv="Content-Language" content="th">
<meta name="author" content="ExtrAXION - 8BAHT.COM" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5" />

<meta name="keywords" content="โปรแกรมถอดแบบ,ExtrAXION,ประมาณราคา">
<meta name="description" content="โปรแกรมถอดแบบ ประมาณราคา แม่นยำ รวดเร็ว รองรับไฟล์รูปภาพ, PDF และ CAD หมดปัญหา ทำข้อมูล เพื่อประมูลงานไม่ทัน หรือ ประมาณราคาผิดพลาด เช่น เผื่อมากไป ไม่ได้งาน หรือ เผื่อน้อยไป กำไรน้อย/ขาดทุน...">
<meta name="language" content="TH">
<meta name="revisit-after" content="1 day" />
<meta name='copyright' content='8BAHT.COM'>

<!-- facebook -->
<meta property="og:site_name" content="ExtrAXION - 8BAHT.COM"/>
<meta property="og:description" content="โปรแกรมถอดแบบ ประมาณราคา แม่นยำ รวดเร็ว รองรับไฟล์รูปภาพ, PDF และ CAD หมดปัญหา ทำข้อมูล เพื่อประมูลงานไม่ทัน หรือ ประมาณราคาผิดพลาด เช่น เผื่อมากไป ไม่ได้งาน หรือ เผื่อน้อยไป กำไรน้อย/ขาดทุน..." />
<meta property="og:locale" content="TH" />
<meta property="og:type" content="article"/>
<meta property="og:image" content="{{ asset('onepages/extraxion/images/slider-2.webp') }}" />

<!-- template css -->
<link rel="stylesheet" href="{{ asset('assets/fontend/styles/loadding.min.css') }}" type="text/css"/>
<link rel="stylesheet" href="{{ asset('assets/fontend/css/bootstrap.css') }}" type="text/css"/>
<link rel="stylesheet" href="{{ asset('assets/fontend/style.min.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/fontend/css/dark.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/fontend/css/font-icons.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/fontend/css/animate.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/fontend/css/colors.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/fontend/css/responsive.css') }}" type="text/css" />
<script src="https://use.fontawesome.com/66003f8bae.js"></script>

<!-- font -->
<link rel="stylesheet" href="{{ asset('fonts/stylesheet.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('assets/fontend/css/fonts.css?v=1') }}" type="text/css"/>

<!-- custom css -->
<link rel="stylesheet" href="{{ asset('onepages/extraxion/css/custom.css?v=8') }}" type="text/css"/>

<style>
    .invalid-feedback{
        color: #fcc841 !important;
    }
</style>

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

        @include('layouts.onepages.extraxion.headder')
        <section id="content">
            @yield('content')
        </section>
        <footer id="footer">
            @include('layouts.onepages.extraxion.footer')
        </footer>
    </div>

<div id="gotoTop" class="icon-angle-up"></div>

<!-- canvas js -->
<script type="text/javascript" src="{{ asset('assets/fontend/js/jquery.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/fontend/js/plugins.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/fontend/js/functions.js') }}"></script>

<script type="text/javascript" src="{{ asset('onepages/extraxion/js/custom.js') }}"></script>

<noscript><img height="1" width="1" style="display:none" alt="fbpx" src="https://www.facebook.com/tr?id=369567287667786&ev=PageView&noscript=1" data-pagespeed-url-hash="40980458"/></noscript> 

{{-- <script src="https://www.google.com/recaptcha/api.js"></script> --}}
{{-- <script>
    function onSubmit(token) {
        document.getElementById("request-quotation").submit();
    }
</script> --}}

</body>
</html>
