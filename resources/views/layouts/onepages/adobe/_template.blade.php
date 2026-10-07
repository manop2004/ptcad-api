<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head  >
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" href="@yield('icon')" type ="image/x-icon">
<title>Adobe - 8BAHT.COM</title>

<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="robots" content="index, follow" />
<meta http-equiv="Content-Language" content="th">
<meta name="author" content="Adobe - 8BAHT.COM" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5" />

<meta property="og:site_name" content="Adobe - 8BAHT.COM"/>
<meta name="keywords" content="adobe,8baht,ซื้อ adobe,รวมโปรแกรม adobe ฟรี,Adobe download,Adobe Creative Cloud,adobe รายเดือน,adobe คืออะไร,ซื้อโปรแกรม adobe ถาวร,adobe cloud; download">
<meta name="description" content="Adobe Creative Cloud for teams รวมทุกอย่างเข้าไว้ด้วยกันสำหรับการทำงานในองค์กรหรือการทำงานเป็นทีม รวมทุกอย่าง ทุกเครื่องมือ ที่ทีมของคุณต้องมี ในการสร้างสรรค์งานที่เหมาะสมกับทุกความต้องการ...">
<meta name="language" content="TH">
<meta name="revisit-after" content="1 day" />
<meta name='copyright' content='8BAHT.COM'>

<!-- facebook -->
<meta property="og:locale" content="TH" />
<meta property="og:site_name" content="8BAHT.COM" />
<meta property="og:type" content="article"/>

<!-- template css -->
<link rel="stylesheet" href="{{ asset('assets/fontend/styles/loadding.min.css') }}" type="text/css"/>
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
<link rel="stylesheet" href="{{ asset('fonts/stylesheet.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('assets/fontend/css/fonts.css?v=1') }}" type="text/css"/>

<!-- custom css -->
<link rel="stylesheet" href="{{ asset('onepages/adobe/css/styles.min.css') }}" type="text/css"/>
<link rel="stylesheet" href="{{ asset('onepages/adobe/css/custom.css?v=13') }}" type="text/css"/>

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

        @include('layouts.onepages.adobe.headder')
        <section id="content">

            @yield('content')

        </section>
        <footer id="footer">
            @include('layouts.onepages.adobe.footer')
        </footer>
    </div>

<div id="gotoTop" class="icon-angle-up"></div>
<!-- canvas js -->
<script type="text/javascript" src="{{ asset('assets/fontend/js/jquery.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/fontend/js/plugins.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/fontend/js/functions.js') }}"></script>

<script type="text/javascript" src="{{ asset('onepages/adobe/js/custom.js') }}"></script>

</body>
</html>
