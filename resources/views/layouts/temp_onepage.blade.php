
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>

	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title>{{ $data->name }} - 8BAHT.COM</title>

	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="robots" content="index, follow" />
	<meta http-equiv="Content-Language" content="th">
	<meta name="author" content="{{ $data->name }} - 8BAHT.COM" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5" />

	<meta property="og:site_name" content="{{ $data->name }} - 8BAHT.COM"/>
	<meta name="keywords" content="{{ $data->og_keywords }}">
	<meta name="description" content="{{ $data->og_description }}">
	<meta name="language" content="TH">
	<meta name="revisit-after" content="1 day" />
	<meta name='copyright' content='8BAHT.COM'>

    <meta property="og:locale" content="TH" />
    <meta property="og:site_name" content="{{ $data->name }}" />
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="{{ $data->name }}" />
    <meta property="og:description" content="{{ $data->og_description }}" />
    <meta property="og:url" content="{{ route('onepages',$parmalink) }}" />
    <meta property="og:image" content="{{ $og_image }}" />

    <link rel="icon" href="@if(!empty($setting->setting_iconWeb)){{ asset('storage/setting/'.$setting->setting_iconWeb) }}@endif" type ="image/x-icon">
    <link rel="shortcut icon" href="@if(!empty($setting->setting_iconWeb)){{ asset('storage/setting/'.$setting->setting_iconWeb) }}@endif" type="image/x-icon">

    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/fontend/css/bootstrap.min.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/fontend/style.min.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/fontend/styles/loadding.min.css') }}" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('assets/fontend/css/swiper.min.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/fontend/css/dark.min.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/fontend/css/font-icons.min.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/fontend/css/animate.min.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/fontend/css/magnific-popup.min.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/fontend/css/responsive.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/fontend/css/components/datepicker.min.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/fontend/css/components/timepicker.min.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/fontend/css/colors.min.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('vendor/select2/select2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/select2-bootstrap4-theme/dist/select2-bootstrap4.min.css') }}">

	<link rel="stylesheet" href="{{ asset('assets/fontend/css/components/radio-checkbox.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/fontend/css/fonts.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/fontend/css/custom.css?v=10') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/fontend/css/padding.css?v=10') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/fontend/css/margin.css?v=10') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/fontend/onepage.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('vendor/ckeditor4/contents.css') }}" type="text/css" />

    @if(!empty($settingPage->bgColor))<style>#quotationBlock{ background: #{{ $settingPage->bgColor }}; }</style>@endif
    @if(!empty($settingPage->pdpaColor))<style>#quotationBlock .pdpa a{ color: #{{ $settingPage->pdpaColor }}; }</style>@endif
    @if(!empty($settingPage->fontColor))<style>#quotationBlock .title,#quotationBlock .title-sub,#quotationBlock .pdpa,#quotationBlock label{color: #{{ $settingPage->fontColor }};}</style>@endif
    @if(!empty($settingPage->radiusTopright)) @if($settingPage->radiusTopright == 1)<style>@media (max-width:991px){#quotationBlock{ border-radius: {{ $settingPage->radiusForm }}{{ 'px'}}; }}</style>@endif @endif
    @if(!empty($settingPage->radiusTopright)) @if($settingPage->radiusTopright == 1)<style>#quotationBlock{ border-top-right-radius: {{ $settingPage->radiusForm }}{{ 'px'}}; }</style>@endif @endif
    @if(!empty($settingPage->radiusBottomright))@if($settingPage->radiusBottomright == 1)<style>#quotationBlock{ border-bottom-right-radius: {{ $settingPage->radiusForm }}{{ 'px'}}; }</style>@endif @endif
    @if(!empty($settingPage->radiusTopleft))@if($settingPage->radiusTopleft == 1)<style>#quotationBlock{ border-top-left-radius: {{ $settingPage->radiusForm }}{{ 'px'}}; }</style>@endif @endif
    @if(!empty($settingPage->radiusBottomleft))@if($settingPage->radiusBottomleft == 1)<style>#quotationBlock{ border-bottom-left-radius: {{ $settingPage->radiusForm }}{{ 'px'}}; }</style>@endif @endif
    @if(!empty($settingPage->imageButton))
       <style>.btn-submit{ background-image: url({{ asset('storage/onepages/'.$settingPage->imageButton) }}); {{ '!important' }}; }</style>
    @else
        @if(!empty($settingPage->widthButton))<style>.btn-submit{ width: {{ $settingPage->widthButton }}{{ '!important' }}; }</style>@endif
        @if(!empty($settingPage->bgButton))<style>.btn-submit{ background-color: {{ $settingPage->bgButton }}{{ '!important' }}; }</style>@endif
        @if(!empty($settingPage->colorButton))<style>.btn-submit{ color: {{ $settingPage->colorButton }}{{ '!important' }}; }</style>@endif
    @endif

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
        @if(!empty($settingBanner))
        <div id="block-slider" style="background-image: url({{ asset('storage/onepages/'.$settingBanner->images) }});">
            <div class="container clearfix">
                <div class="entry-content">
                   {!! $settingBanner->detail !!}
                </div>
            </div>
        </div>
        @endif
        <section id="content">
            <div class="content-wrap">
                @foreach ($settingSection as $section)
                    @if($section->section == 'section')
                        <div id="section-{{ $section->id }}" class="padding-t-50 padding-l-30 padding-r-30" @if(!empty($section->bgColor)) style="background: {{ $section->bgColor }}" @endif>
                            <div class="container entry-content notopmargin">{!! $section->detail !!}</div>
                        </div>
                    @endif
                    @if($section->section == 'tab')
                        <div id="section-{{ $section->id }}" class="padding-t-50 padding-l-30 padding-r-30" @if(!empty($section->bgColor)) style="background: {{ $section->bgColor }}" @endif>
                            @php
                                $viewTab = App\Models\TbPromotionOnepagesSection::where('section','tab')->where('show',1)->orderBy('sort','asc')->get()
                            @endphp
                            <div class="tabs tabs-bb clearfix nobottommargin" id="tab-9">
                                <div class="container notopmargin display-flex-center">
                                    <ul class="tab-nav clearfix">
                                        @foreach ($viewTab as $tab_nav)
                                            <li><a href="#tabs-{{ $tab_nav->id }}"> {{ $tab_nav->name }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="tab-container margin-t-20">
                                    @foreach ($viewTab as $tab_content)
                                        <div class="tab-content clearfix" id="tabs-{{ $tab_content->id }}">
                                            <div class="container entry-content notopmargin">
                                                {!! $tab_content->detail !!}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
                <div class="container padding-t-50 padding-l-30 padding-r-30">
                    <div class="row">
                        <div class="col-md-5"></div>
                        <div class="col-md-7">
                            <div id="quotationBlock" class="padding-t-50 padding-b-50 padding-l-30 padding-r-30">
                                <div class="text-center">
                                    @if(!empty($settingPage->formName ))<h1 class="title margin-b-10">{{ $settingPage->formName }}</h1>@endif
                                    @if(!empty($settingPage->formDetail ))<div class="title-sub">{{ $settingPage->formDetail }}</div>@endif
                                </div>
                                <div class="row margin-t-30">
                                    @foreach ($settingForm as $form)
                                        <div class="{{ $form->col }} margin-b-10">
                                            <div class="form-group">
                                                @if($settingPage->checklabel == 2)<label class="margin-b-0">{{ $form->fieldTH }}</label>@endif
                                                @if ($form->type == 'input')
                                                    <input placeholder="{{ $form->fieldTH }}" class="sm-form-control"/>
                                                @elseif($form->type == 'textarea')
                                                    <textarea placeholder="{{ $form->fieldTH }}" class="sm-form-control"></textarea>
                                                @elseif($form->type == 'select')
                                                    <select class="sm-form-control">
                                                        <option > -- กรุณาเลือกข้อมูล{{ $form->fieldTH }} --</option>
                                                    </select>
                                                @endif
                                                @error($form->field)<small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>@enderror
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @if(!empty($settingPage->checkpdpa))
                                    @if($settingPage->checkpdpa == 2)
                                        <div class="form-group pdpa margin-t-10 margin-b-30">
                                            <div class="pdpa-wb">
                                                <input type="checkbox" id="pdpa_wording1" name="pdpa_wording1" value="1" class="checkbox-style">
                                                <label for="pdpa_wording1" class="checkbox-style-3-label f-22"><p>{!! $settingPage->formPDPA !!}</label>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                                <div class="form-group ">
                                    <input type="hidden" name="campaignid" value="{{ $data->campaignid }}" />
                                    <input type="hidden" name="mailtoteam" value="{{ $data->mailtoteam }}" />
                                    <input type="hidden" name="regis_type" value="{{ $data->regis_type }}" />
                                    <input type="hidden" name="checkemail" value="{{ $data->checkemail }}" />
                                    <input type="hidden" name="assigned" value="{{ $data->assigned }}" />
                                    <input type="hidden" name="url_path" value="{{ "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" }}" />
                                    <input type="hidden" name="redirect" value="{{ 'https://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] }}"/>
                                    <input type="hidden" name="og_keywords" value="{{ $data->og_keywords }}" />
                                    <input type="hidden" name="og_description" value="{{ $data->og_description }}" />
                                    <input type="hidden" name="og_image" value="{{ asset('storage/onepages/' . $data->og_image) }}" />
                                    <input  type="hidden" name="urlreference" @if(!empty($_GET["ref"]))value="{{ $_GET["ref"] }}"@endif >
                                    <button id="btn-submit" type="submit" class="margin-l-auto margin-r-auto margin-t-20 loadding bth btn-submit btn-lg btn-block f-26" name="submit" >
                                        @if(empty($settingPage->imageButton))
                                            @if(!empty($settingPage->wordButton))
                                                {!! $settingPage->wordButton !!}
                                            @else
                                                <i class="icon-hand-right"></i> คลิก! ขอใบเสนอราคา
                                            @endif
                                        @endif
                                    </button>
                                </div>
                                @if(!empty($settingPage->checkpdpa))
                                    @if($settingPage->checkpdpa == 1)
                                        <div class="form-group pdpa">
                                            <div class="text-center f-22">{!! $settingPage->formPDPA !!}</div>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @if(!empty($settingFooter))
            <footer id="footer" @if(!empty($settingFooter->bgColor)) style="background: {{ $settingFooter->bgColor }}!important;" @endif>
                <div class="container">
                    <div class="entry-content">
                        {!! $settingFooter->detail !!}
                    </div>
                </div>
            </footer>
        @endif
    </div>

    <script type="text/javascript" src="{{ asset('assets/fontend/js/jquery.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/fontend/js/plugins.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/fontend/js/functions.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/sweetalert2/dist/sweetalert2.all.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/fontend/js/components/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/fontend/js/components/datepicker.js') }}"></script>

    <script type="text/javascript" src="{{ asset('assets/fontend/js/custom.js?v=4') }}"></script>
    <script src="{{ asset('vendor/select2/select2.min.js') }}"></script>
    <script src="{{ asset('vendor/select2-bootstrap4-theme/docs/script.js') }}"></script>

    @if ($customcode != 0)
        @php
            $displayType3 = App\Models\TbCustomcode::where('displayType','3')->where('custom_show',1)->get();
        @endphp
        @foreach ($displayType3 as $display3){!!$display3->custom_detail!!}@endforeach
    @endif

</body>
</html>
