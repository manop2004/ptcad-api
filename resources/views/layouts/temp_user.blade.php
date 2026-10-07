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

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" type="text/css" />
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

<link rel="stylesheet" href="{{ asset('assets/fontend/styles/fonts.min.css?v=6') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/fontend/styles/custom.min.css?v=42') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/fontend/styles/additional.css?v=31') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/fontend/lightbox2-2.11.5/src/css/lightbox.css') }}">

<link rel="stylesheet" href="{{ asset('assets/fontend/menu-footer.css?o=14') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/fontend/modal.css?o=2') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/fontend/hax_theme/style.css?o=54') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/fontend/navbar-horizontal.css') }}" type="text/css" />
<style>
html, body{
    overflow-x: hidden !important;
    max-width: 100% !important;
}
body *{
    overflow-wrap: break-word !important;
    word-break: break-word !important;
}
</style>
<style>
    *, ::after, ::before {
        box-sizing: unset;
    }
	
	button.button-cart,
	button.button-quotation,
	button.button-model,
	button.button-teal,
	button.button-green,
	button.btn,
	.sm-form-control,
	.sm-form-control::before,
	.sm-form-control::after {
		box-sizing: border-box;
	}

</style>

<!-- ===== PTCAD: Global override สำหรับสีเมนูหลัก (hover/active) จากเขียว -> น้ำเงินธีม ===== -->
<!-- โหลดหลังสุด (ท้าย head) เพื่อให้ specificity ชนะไฟล์ CSS เดิมของธีม -->
<style>
/* Breadcrumb: "หน้าหลัก > ชื่อหน้า" ที่แสดงทุกหน้า */
.breadcrumb a,
.breadcrumb li a,
ol.breadcrumb a{
    color: #0b1f4d !important;
}
.breadcrumb a:hover,
.breadcrumb li a:hover{
    color: #1765ff !important;
}

/* Sidebar เมนูหน้า page/about, page/policy ฯลฯ (เช่น "เกี่ยวกับ PTCAD", "นโยบายความเป็นส่วนตัว")
   class ในโค้ดเดิมสะกดว่า "curent" (ไม่ใช่ current) — สีเขียว #1765ffเดิมของธีม 8baht
   โครงสร้างจริง: <div id="page-menu"><ul class="page-menu"><li><a class="curent">
   ต้องใส่ #page-menu ประกบด้วย เพราะ CSS เดิมของธีมใช้ ID ทำให้ specificity สูงกว่า class เฉยๆ */
#page-menu a.curent,
#page-menu .page-menu a.curent,
#page-menu ul.page-menu a.curent,
#page-menu .page-menu a.curent:link,
#page-menu .page-menu a.curent:visited,
#page-menu .page-menu a.curent:hover,
#page-menu .page-menu a.curent:active,
#page-menu .page-menu li a.curent:hover,
#page-menu ul.page-menu li a.curent:hover,
.page-menu a.curent,
.page-menu a.curent:hover,
.page-menu a.curent:active,
.page-menu li a.curent,
.page-menu li a.curent:hover,
ul.page-menu a.curent,
ul.page-menu a.curent:hover{
    color: #1765ff !important;
}

/* เผื่อลิงก์อื่นๆ ใน sidebar ที่ไม่ใช่ตัว active โดน hover แล้วเขียวด้วย */
#page-menu .page-menu li a:hover,
#page-menu ul.page-menu li a:hover,
.page-menu li a:hover{
    color: #1765ff !important;
}
</style>
<!-- ===== /PTCAD override ===== -->

<!-- popup banner -->
<!--style id="mourning-popup-css">
/* Minimal memorial popup: image only + close over image (top-right) */
:root{
  --mp-z:99999;
  --mp-bg:rgba(0,0,0,.78);
  --mp-mediaMax: 90vh;   /* ความสูงสูงสุดของรูป */
}

.mp-backdrop{
  position:fixed; inset:0; background:var(--mp-bg);
  opacity:0; visibility:hidden; transition:opacity .25s ease,visibility .25s ease; z-index:var(--mp-z);
}

/* กรอบโมดัลโปร่งใส ไม่มีเงา/มุมโค้ง ไม่มี padding */
.mp-modal{
  position:fixed; top:50%; left:50%;
  transform:translate(-50%,-50%) scale(.98);
  background:transparent; border:none; border-radius:0; box-shadow:none; padding:0; margin:0;
  width:auto; max-width:92vw; max-height:94vh;
  opacity:0; visibility:hidden; transition:opacity .25s ease, transform .25s ease, visibility .25s ease;
  z-index:calc(var(--mp-z) + 1);
}

/* แสดงเมื่อเปิด */
.mp-open .mp-backdrop, .mp-open .mp-modal { opacity:1; visibility:visible; }
.mp-open .mp-modal { transform:translate(-50%,-50%) scale(1); }

/* กล่องรูป: ให้เป็นจุดอ้างอิงปุ่มปิด */
.mp-modal__media{
  position:relative;
  line-height:0;          /* กันช่องว่างใต้รูป */
  background:transparent; /* ไม่มีพื้นหลัง */
}

/* รูปเต็มความกว้าง แต่จำกัดความสูง */
.mp-modal__media img{
  display:block;
  width:100%;
  height:auto;
  max-height:var(--mp-mediaMax);
  object-fit:contain;
}

/* ปุ่มปิดทับบนรูป มุมขวาบน */
.mp-close{
  position:absolute;
  top:10px; right:10px;
  width:40px; height:40px; border-radius:50%;
  border:1px solid rgba(255,255,255,.18);
  background:rgba(0,0,0,.35); color:#fff;
  display:grid; place-items:center; cursor:pointer;
  transition:background .2s ease, transform .12s ease;
  z-index:2;
}
.mp-close:hover{ background:rgba(0,0,0,.5); }
.mp-close:active{ transform:scale(.96); }

@media (max-width:768px){
  :root{ --mp-mediaMax: 82vh; }
}

/* โลโก้ขาวดำ (ตามที่ตั้งไว้) */
.w-logo-subhead img,.footer-box-logo img,
.w-logo-subhead picture,.footer-box-logo picture,
.w-logo-subhead svg,.footer-box-logo svg{
  filter:grayscale(100%) contrast(1.05);
  -webkit-filter:grayscale(100%) contrast(1.05);
}
.w-logo-subhead,.footer-box-logo{ filter:grayscale(100%) contrast(1.05); }
</style-->
<!-- popup banner -->

<script type="text/javascript" src="{{ asset('assets/fontend/js/jquery.js') }}"></script>

@yield('css')

@if ($customcode != 0)
@php
    $displayType1 = App\Models\TbCustomcode::where('displayType','1')->where('custom_show',1)->get();
@endphp
@foreach ($displayType1 as $display1){!!$display1->custom_detail!!}@endforeach
@endif
@if(!empty($extension->ext_googleWebmaster))<meta name="google-site-verification" content="{{ $extension->ext_googleWebmaster }}" />@endif
@if(!empty($extension->ext_googleAnalytics))
<script async src="https://www.googletagmanager.com/gtag/js?id={{ $extension->ext_googleAnalytics }}"></script>
<script>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('js', new Date());

gtag('config', '{{ $extension->ext_googleAnalytics }}');
</script>
@endif
@if(!empty($extension->ext_googleAdsense)){!! $extension->ext_googleAdsense !!}@endif
</head>
<body>

    @if ($customcode != 0)
        @php
            $displayType2 = App\Models\TbCustomcode::where('displayType','2')->where('custom_show',1)->get();
        @endphp
        @foreach ($displayType2 as $display2)
            {!!$display2->custom_detail!!}
        @endforeach
    @endif
	
	<div id="menubar">
	@include('layouts.fontend.topbar')
	@include('layouts.fontend.header')
	</div>
	
	@yield('content')
	@include('layouts.fontend.footer')
	
	

<style>
    .cart-popup{
        border-radius:20px !important;
        font-family:'Poppins','Noto Sans Thai',system-ui,sans-serif !important;
    }
    .cart-popup .icon-succress{
        filter:hue-rotate(160deg) saturate(1.4) !important;
    }
    .cart-popup-price{
        color:#1765ff !important;
        font-weight:800 !important;
    }
    .cart-popup-btn{
        display:flex !important;
        gap:12px !important;
    }
    .cart-popup-btn a.btn-goto-cart,
    .cart-popup-btn a.btn-goto-product{
        border-radius:12px !important;
    }
    .cart-popup-btn a.btn-goto-cart{
        background:linear-gradient(135deg,#1765ff,#0d57df) !important;
        border-color:#1765ff !important;
        color:#fff !important;
        font-weight:800 !important;
    }
    .cart-popup-btn a.btn-goto-product{
        background:#12358f !important;
        color:#fff !important;
        border:none !important;
    }
    .cart-popup-close{
        border-radius:999px !important;
    }
</style>


<!-- Custom Live Chat Button (PTCAD theme) แทนที่ปุ่ม default ของ Tawk.to -->
<style>
.pt-chat-btn{
    position: fixed;
    right: 20px;
    bottom: 20px;
    z-index: 99999;
    height: 58px;
    padding: 0 22px 0 12px;
    border-radius: 999px;
    background: linear-gradient(135deg, #1765ff, #0d57df);
    color: #fff;
    display: inline-flex;
    align-items: center;
    gap: 12px;
    border: none;
    cursor: pointer;
    box-shadow: 0 12px 30px rgba(23,101,255,.32);
    animation: ptChatPulse 2.2s infinite;
    transition: transform .2s ease;
    font-family: 'Poppins','Noto Sans Thai',system-ui,sans-serif;
}
.pt-chat-btn:hover{ transform: translateY(-3px); }
.pt-chat-btn .pt-chat-icon{
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: rgba(255,255,255,.18);
    display: flex;
    align-items: center;
    justify-content: center;
    flex: none;
}
.pt-chat-btn svg{ width: 20px; height: 20px; }
.pt-chat-btn .pt-chat-text{
    font-size: 15px;
    font-weight: 700;
    white-space: nowrap;
}

@keyframes ptChatPulse{
    0%   { box-shadow: 0 12px 30px rgba(23,101,255,.28), 0 0 0 0 rgba(23,101,255,.30); }
    70%  { box-shadow: 0 12px 30px rgba(23,101,255,.28), 0 0 0 14px rgba(23,101,255,0); }
    100% { box-shadow: 0 12px 30px rgba(23,101,255,.28), 0 0 0 0 rgba(23,101,255,0); }
}

@media (max-width:575.98px){
    .pt-chat-btn{ right:14px; bottom:14px; height:52px; padding:0 18px 0 10px; }
    .pt-chat-btn .pt-chat-icon{ width:32px; height:32px; }
    .pt-chat-btn svg{ width:18px; height:18px; }
    .pt-chat-btn .pt-chat-text{ font-size:14px; }
}
</style>

@if(optional($setting)->setting_chatbot_status != 2)
<!-- Botnoi Chatbot -->
<div id="bn-root"></div>

<div class="bn-customerchat"
    bot_id="6abf61cffef8a101caa60538"
    bot_logo="https://console.botnoi.ai/assets/botnoi-logo/botnoi.svg"
    bot_name="PTCAD Support"
    theme_color="#1765ff"
    locale="th"
    logged_in_greeting="สวัสดีครับ ยินดีต้อนรับสู่ PTCAD"
    greeting_message="สวัสดีครับ มีอะไรให้เราช่วยเหลือไหมครับ?"
    default_open="false">
</div>

<script src="https://console.botnoi.ai/customerchat/index.js" id="bn-jssdk" onload="if(window.BN){ window.BN.init({ version: '1.0' }); }"></script>
<script>
    (function() {
        function runBN() {
            if (window.BN && typeof window.BN.init === 'function') {
                window.BN.init({ version: '1.0' });
            }
        }
        if (document.readyState === 'complete' || document.readyState === 'interactive') {
            runBN();
        } else {
            window.addEventListener('load', runBN);
        }
    })();
</script>
@endif


<script>
document.addEventListener('DOMContentLoaded', function () {
    var mobileSearchBar = document.querySelector('.mobile-search-bar');
    var mobileSearchPlaceholder = document.querySelector('.mobile-search-placeholder');

    if (!mobileSearchBar || !mobileSearchPlaceholder) return;

    function isMobileWidth() {
        return window.innerWidth <= 991.98;
    }

    function updateMobileSearch() {
        if (!isMobileWidth()) {
            document.body.classList.remove('mobile-search-fixed');
            mobileSearchPlaceholder.style.height = '0px';
            return;
        }

        var barTop = mobileSearchBar.getBoundingClientRect().top + window.scrollY;
        var currentScroll = window.scrollY || window.pageYOffset;
        var barHeight = mobileSearchBar.offsetHeight;

        if (!mobileSearchBar.dataset.initialTop) {
            mobileSearchBar.dataset.initialTop = barTop;
        }

        var initialTop = parseFloat(mobileSearchBar.dataset.initialTop);

        if (currentScroll > initialTop) {
            document.body.classList.add('mobile-search-fixed');
            mobileSearchPlaceholder.style.height = barHeight + 'px';
        } else {
            document.body.classList.remove('mobile-search-fixed');
            mobileSearchPlaceholder.style.height = '0px';
        }
    }

    function resetMobileSearch() {
        document.body.classList.remove('mobile-search-fixed');
        mobileSearchBar.dataset.initialTop = '';
        mobileSearchPlaceholder.style.height = '0px';
        setTimeout(updateMobileSearch, 50);
    }

    updateMobileSearch();

    window.addEventListener('scroll', updateMobileSearch, { passive: true });
    window.addEventListener('resize', resetMobileSearch);
    window.addEventListener('load', resetMobileSearch);
});
</script>

@yield('js')

@if ($customcode != 0)
	@php
		$displayType3 = App\Models\TbCustomcode::where('displayType','3')->where('custom_show',1)->get();
	@endphp
	@foreach ($displayType3 as $display3){!!$display3->custom_detail!!}@endforeach
@endif

<!--script id="mourning-popup-js">
(function () {
  const KEY = "mp_seen_2025_queen_mother";
  const TTL_DAYS = 0; // ปิดแล้วไม่เด้งอีก
  const IMG_URL = "https://phpstack-1646968-6541058.cloudwaysapps.com/assets/fontend/images/queen.webp";

  const now = () => Date.now();
  const days = d => d*24*60*60*1000;
  function hasSeen(){
    try{
      const raw = localStorage.getItem(KEY);
      if(!raw) return false;
      const data = JSON.parse(raw);
      if(!data || typeof data.time!=="number") return false;
      if(TTL_DAYS>0 && (now()-data.time)>days(TTL_DAYS)) return false;
      return true;
    }catch(e){ return false; }
  }
  function markSeen(){ try{ localStorage.setItem(KEY, JSON.stringify({time:now()})); }catch(e){} }

  function openModal(){ document.documentElement.classList.add("mp-open"); }
  function closeModal(){ document.documentElement.classList.remove("mp-open"); markSeen(); }
  function onEsc(e){ if(e.key==="Escape") closeModal(); }

  function build(){
    const backdrop = document.createElement("div");
    backdrop.className = "mp-backdrop"; backdrop.setAttribute("aria-hidden","true");

    const modal = document.createElement("div");
    modal.className = "mp-modal"; modal.setAttribute("role","dialog"); modal.setAttribute("aria-modal","true");

    const media = document.createElement("div");
    media.className = "mp-modal__media";
    media.innerHTML = '<img src="'+IMG_URL+'" alt="banner">';

    const closeBtn = document.createElement("button");
    closeBtn.type="button"; closeBtn.className="mp-close"; closeBtn.setAttribute("aria-label","ปิดหน้าต่าง");
    closeBtn.innerHTML = "<span aria-hidden='true'>&times;</span>";
    media.appendChild(closeBtn);        // ปุ่มอยู่บนรูป

    modal.appendChild(media);
    document.body.appendChild(backdrop);
    document.body.appendChild(modal);

    backdrop.addEventListener("click", closeModal);
    closeBtn.addEventListener("click", closeModal);
    document.addEventListener("keydown", onEsc, {passive:true});

    if(!hasSeen()) openModal();
  }

  if(document.readyState==="loading") document.addEventListener("DOMContentLoaded", build);
  else build();
})();
</script-->
<script src="https://unpkg.com/lucide@latest"></script>
<script>
  // สั่งให้ระบบแปลงแท็ก <i data-lucide="..."> ให้กลายเป็นไอคอนจริง
  lucide.createIcons();
</script>
</body>

<script type="text/javascript" src="{{ asset('assets/fontend/js/menu.min.js?v=10') }}"></script>
<script type="text/javascript" src="{{ asset('assets/fontend/js/plugins.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/fontend/js/functions.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/sweetalert2/dist/sweetalert2.all.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/fontend/js/components/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/fontend/js/components/datepicker.js') }}"></script>

<script type="text/javascript" src="{{ asset('assets/fontend/js/custom.min.js?v=26') }}"></script>
<script type="text/javascript" src="{{ asset('assets/fontend/js/custom_c.js?v=4') }}"></script>
<script type="text/javascript" src="{{ asset('assets/fontend/lightbox2-2.11.5/src/js/lightbox.js') }}"></script>

<script type="text/javascript" src="{{ asset('assets/fontend/hax_theme/script.js?o=8') }}"></script>

</html>