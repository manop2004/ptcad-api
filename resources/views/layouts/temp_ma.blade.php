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
<title>@yield('title') @if(!empty($setting->setting_nameWeb)){{$setting->setting_nameWeb}}@endif</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta property="og:site_name" content="@yield('og_site_name')"/>
<meta name="keywords" content="@yield('og_keywords')">
<meta name="description" content="@yield('og_description')">
<meta name="language" content="TH">
<meta name="revisit-after" content="1 day" />
<meta name='copyright' content='{{ $_SERVER['SERVER_NAME'] }}'>

<meta property="og:locale" content="TH" />
<meta property="og:site_name" content="@yield('og_site_name')" />
<meta property="og:type" content=""/>
<meta property="og:title" content="@yield('og_title')" />
<meta property="og:description" content="@yield('og_description')" />
<meta property="og:url" content="@yield('og_url')" />
<meta property="og:image" content="@yield('og_image')" />

@yield('og:id')
@yield('product:brand')
@yield('product:availability')
@yield('product:condition')
@yield('product:price:amount')
@yield('product:price:currency')

<link rel="stylesheet" href="{{ asset('assets/fontend/css/bootstrap.min.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/fontend/style.min.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/fontend/css/swiper.min.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/fontend/css/dark.min.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/fontend/css/font-icons.min.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/fontend/css/animate.min.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/fontend/css/magnific-popup.min.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/fontend/css/responsive.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/fontend/css/components/datepicker.min.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/fontend/css/components/timepicker.min.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/fontend/styles/colors.min.css?v=2') }}" type="text/css" />

<link rel="stylesheet" href="{{ asset('assets/fontend/styles/fonts.min.css?v=2') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/fontend/styles/custom.min.css?v=9') }}" type="text/css" />

@yield('css')

@if ($customcode != 0)
@php
    $displayType1 = App\Models\TbCustomcode::where('displayType','1')->where('custom_show',1)->get();
@endphp
@foreach ($displayType1 as $display1){!!$display1->custom_detail!!}@endforeach
@endif
@if(!empty($extension->ext_googleWebmaster))<meta name="google-site-verification" content="{{ $extension->ext_googleWebmaster }}" />@endif
<?php
/*
@if(!empty($extension->ext_googleAnalytics))
<script async src="https://www.googletagmanager.com/gtag/js?id={{ $extension->ext_googleAnalytics }}"></script>
<script>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('js', new Date());

gtag('config', '{{ $extension->ext_googleAnalytics }}');
</script>
@endif
*/
?>
@if(!empty($extension->ext_googleAdsense)){!! $extension->ext_googleAdsense !!}@endif
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
    @if ($customcode != 0)
        @php
            $displayType2 = App\Models\TbCustomcode::where('displayType','2')->where('custom_show',1)->get();
        @endphp
        @foreach ($displayType2 as $display2)
            {!!$display2->custom_detail!!}
        @endforeach
    @endif
    <div id="wrapper" class="clearfix">
        @yield('content')

        <div id="popup_cart" class="relative">

        </div>
    </div>
	
<!-- Modal -->
<div class="modal fade" id="ModalPage" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div id="Modal_Body" class="modal-body">
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="{{ asset('assets/fontend/js/jquery.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/fontend/js/menu.min.js?v=8') }}"></script>
{{-- <script type="text/javascript" src="{{ asset('assets/fontend/js/menu.js?v=9') }}"></script> --}}
<script type="text/javascript" src="{{ asset('assets/fontend/js/plugins.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/fontend/js/functions.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/sweetalert2/dist/sweetalert2.all.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/fontend/js/components/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/fontend/js/components/datepicker.js') }}"></script>

<script type="text/javascript" src="{{ asset('assets/fontend/js/custom.min.js?v=8') }}"></script>
<script type="text/javascript" src="{{ asset('assets/fontend/js/custom_c.js?v=4') }}"></script>

@yield('js')

@if ($customcode != 0)
@php
    $displayType3 = App\Models\TbCustomcode::where('displayType','3')->where('custom_show',1)->get();
@endphp
@foreach ($displayType3 as $display3){!!$display3->custom_detail!!}@endforeach
@endif

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

@if(session('feedback-er'))
<script>

    Swal.fire({
        title: "{{ session('feedback-er') }}",
        text: "{{ session('text-er') }}",
        icon: 'error',
        confirmButtonText: 'ตกลง',
        timer: 5000
    })

</script>
@endif

</body>
</html>
