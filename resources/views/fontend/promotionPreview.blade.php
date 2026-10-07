<!DOCTYPE html>
<html>
<link rel="icon" href="{{ asset('storage/setting/' . $setting->setting_iconWeb) }}" type ="image/x-icon">
<title>{{ $promotion->promo_name }} | {{ $setting->setting_nameWeb}}</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

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
<script src="https://kit.fontawesome.com/1dcd8bb6e7.js" crossorigin="anonymous"></script>
<!-- font -->
<link rel="stylesheet" href="{{ asset('assets/fonts/stylesheet.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('assets/fontend/css/fonts.css?v=11') }}" type="text/css"/>

<!-- custom css -->
<link rel="stylesheet" href="{{ asset('assets/fontend/styles/styles.min.css') }}" type="text/css"/>
<link rel="stylesheet" href="{{ asset('assets/fontend/css/custom.css?v=24') }}" type="text/css"/>
<link rel="stylesheet" href="{{ asset('assets/fontend/css/ckediter.css') }}" type="text/css"/>

<style>
    .block-crm-detail{
        max-width: 400px;
        padding: 10px;
        background: #fff;
        line-height: 1.8;
        margin: 4rem auto auto auto;
    }
    table{
        margin-left: auto;
        margin-right: auto;
        margin-top: 2rem;
        margin-bottom: 2rem;
        background: #fff;
    }
    .padding-table{
        padding-top: 10px;
        padding-bottom: 10px;
        padding-left: 20px;
        padding-right: 20px;
    }
    .paddingbottom-15{
        padding-bottom: 15px;
    }
    .button-block{
        width: 100% !important;
    }
    .content-wrap {
        padding: 80px 0 !important;
    }
</style>
<body class="stretched">
    <section id="content">

        <div class="content-wrap">

            <div class="container clearfix">
                <div class="row">
                    @if(!empty($promotion->promo_img))
                        <div class="col-lg-5 bottommargin-sm">
                            <div class="entry-image nobottommargin">
                                @if(!empty($promotion->promo_img))
                                    <img loading="lazy" class="lazyload full-width" data-src="{{ asset('storage/promotion/'.$promotion->promo_img) }}" alt="{{ $promotion->promo_name }}">
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-7">
                    @else
                        <div class="col-lg-12">
                    @endif
                        @if(!empty($promotion->promo_name))
                            <h2>{{ $promotion->promo_name }}</h2>
                        @endif
                        @if(!empty($promotion->promo_start_date) && !empty($promotion->promo_end_date) )
                            วันที่เริ่มโปรโมชั่น : {{ date("d-m-Y",strtotime($promotion->promo_start_date)).' - '.date("d-m-Y",strtotime($promotion->promo_end_date)) }}
                        @endif

                        @if(!empty($promotion->promo_start_date) && empty($promotion->promo_end_date) )
                            วันที่เริ่มโปรโมชั่น : {{ date("d-m-Y",strtotime($promotion->promo_start_date)) }}
                        @endif

                        @if(empty($promotion->promo_start_date) && !empty($promotion->promo_end_date) )
                           วันที่สิ้นสุดโปรโมชั่น : {{ date("d-m-Y",strtotime($promotion->promo_start_date)) }}
                        @endif
                        @if(!empty($promotion->promo_note))
                            <div id="ck_editer" class="entry-content topmargin-sm">{!! $promotion->promo_note !!}</div>
                        @endif
                        @if(!empty($promotion->promo_link))
                            <br/>
                            <a href="{{ $promotion->promo_link }}" target="_bank">Link Promotion Click!</a>
                        @endif
                        <hr/>
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-4 bottommargin-sm">
                                @if (Route::has('login'))
                                    @auth

                                        @if(Auth::user()->level != 6)
                                            <a href="{{ route('promotion.calendar') }}">
                                                <button type="submit" class="loadding button button-3d button-rounded button-black nomargin button-block">
                                                    <i class="icon-calendar2"></i> กลับหน้าปฏิทิน
                                                </button>
                                            </a>
                                        @endif

                                    @endauth
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </section>
</body>

<!-- canvas js -->
<script type="text/javascript" src="{{ asset('assets/fontend/js/jquery.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/fontend/js/plugins.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/fontend/js/functions.js') }}"></script>
<!-- custom js -->
<script type="text/javascript" src="{{ asset('assets/fontend/js/custom.js?v=22') }}"></script>

</html>
