<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head  >
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" href="{{ asset('onepages/lumion/images/icon-lumion.png') }}" type ="image/x-icon">
<title>Lumion - 8BAHT.COM</title>

<meta http-equiv="Content-Language" content="th">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Cache-control" content="public" max-age="604800">

<meta name="robots" content="index, follow" />
<meta name="author" content="GstartCAD - 8BAHT.COM" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5" />

<meta property="og:site_name" content="GstartCAD - 8BAHT.COM"/>
<meta name="keywords" content="Lumion,8baht,Lumion ดาวน์โหลดฟรี,Lumion,Lumion download,Lumion ทดลองใช้,Lumion ราคา">
<meta name="description" content="Lumion เป็นซอฟต์แวร์สำหรับเรนเดอร์ แบบสแตนด์อโลน ซึ่งช่วยให้การออกแบบได้ถูกถ่ายทอดออกไปอย่างสมบูรณ์">
<meta name="language" content="TH">
<meta name="revisit-after" content="1 day" />
<meta name='copyright' content='8BAHT.COM'>

<!-- facebook -->
<meta property="og:locale" content="TH" />
<meta property="og:site_name" content="8BAHT.COM" />
<meta property="og:type" content="article"/>

<!-- template css -->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/fontend/css/bootstrap.css') }}" type="text/css"/>
<link rel="stylesheet" href="{{ asset('onepages/gstarcad/style.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/fontend/css/dark.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/fontend/css/font-icons.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/fontend/css/animate.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/fontend/css/magnific-popup.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/fontend/css/responsive.css') }}" type="text/css" />
<!-- custom css -->
<link rel="stylesheet" href="{{ asset('fonts/stylesheet.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('assets/fontend/css/fonts.css?v=01') }}" type="text/css"/>
<link rel="stylesheet" href="{{ asset('onepages/gstarcad/custom.css?v=03') }}" type="text/css"/>
<link rel="stylesheet" href="{{ asset('onepages/gstarcad/colors.css?v=01') }}" type="text/css"/>
<link rel="stylesheet" href="{{ asset('assets/fontend/styles/loadding.min.css') }}" type="text/css"/>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css" />
<link rel="stylesheet" href="{{ asset('onepages/lumion/custom.css?v=000003') }}" type="text/css"/>
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

        <header id="header">

			<div id="header-wrap">

				<div class="container clearfix">
                    <div id="primary-menu-trigger"><i class="icon-reorder"></i></div>

                    <div id="logo">
                        <a href="{{ route('onepage.lumion.index') }}" class="standard-logo" data-dark-logo="{{ asset('onepages/lumion/images/LUMION-logo.webp') }}"><img src="{{ asset('onepages/lumion/images/LUMION-logo.webp') }}" alt="logo lumion"></a>
                        <a href="{{ route('onepage.lumion.index') }}" class="retina-logo" data-dark-logo="{{ asset('onepages/lumion/images/LUMION-logo.webp') }}"><img src="{{ asset('onepages/lumion/images/LUMION-logo.webp') }}" alt="logo lumion"></a>
                    </div>

                </div>

            </div>

        </header>

        <section id="content">
            <div class="content-wrap">
				<div class="clearfix">
                    <div id="section-content-1" class="content-block">
                        <div class="heading-block center" style="margin-bottom:0;">
                            <h1>กรอกฟอร์มเพื่อขอทดลองใช้งาน Lumion Trial Version</h1>
                        </div>
                    </div>
                    <div id="section-content-2" class="content-block">
						<div class="row">
							<div class="col-md-2 hidden-sm"></div>
							<div class="col-md-8 col-sm-12">
								<div class="bg-quotation">
									<h3 class="co-white">กรุณา กรอกข้อมูล เป็นภาษาอังกฤษ เท่านั้น</h3>
										<form id="request-quotation" name="request-quotation" method="get" action="{{ route('onepage.lumion.crate') }}" style="margin-bottom: 0px;">
										@csrf
										<div class="row">
											<div class="col-md-6 col-sm-6">
												<div class="form-group text-left">
													<small class="co-white " >Firstname *</small>
													<input type="text" class="form-control" placeholder="Firstname" id="firstname" name="firstname" value="{{ old('firstname') }}">
													@error('firstname')
														<small class="co-white" role="alert"><strong>{{ $message }}</strong></small>
													@enderror
												</div>
											</div>
											<div class="col-md-6 col-sm-6">
												<div class="form-group text-left">
													<small class="co-white " >Lastname *</small>
													<input type="text" class="form-control" placeholder="Lastname" id="lastname" name="lastname" value="{{ old('lastname') }}">
													@error('lastname')
														<small class="co-white" role="alert"><strong>{{ $message }}</strong></small>
													@enderror
												</div>
											</div>
											
											<div class="col-md-12 col-sm-12">
												<div class="form-group  text-left">
													<small class="co-white">Company *</small>
													<input type="text" class="form-control" placeholder="Company (Please fill in english only!)" id="company" name="company" value="{{ old('company') }}">
												</div>
											</div>
											<div class="col-md-6 col-sm-6">
												<div class="form-group  text-left">
													<small class="co-white ">Mobile *</small>
													<input type="tel" class="form-control" placeholder="Mobile" id="phone" name="mobile" value="{{ old('mobile') }}" >
													@error('mobile')
														<small class="co-white" role="alert"><strong>{{ $message }}</strong></small>
													@enderror
												</div>
											</div>
											<div class="col-md-6 col-sm-6">
												<div class="form-group  text-left">
													<small class="co-white">Email *</small>
													<input type="text" class="form-control" placeholder="Email" id="email" name="email" value="{{ old('email') }}">
													@error('email')
														<small class="co-white" role="alert"><strong>{{ $message }}</strong></small>
													@enderror
												</div>
											</div>
											
											<div class="col-md-12 col-sm-12">
												<div class="form-group  text-left">
													<small class="co-white" >Address</small>
													<textarea class="form-control" placeholder="Address" icols="40" rows="2" id="lane" name="lane" >{{ old('lane') }}</textarea>
												</div>
											</div>
											
											<div class="col-md-6 col-sm-6">
												<div class="form-group  text-left">
													<small class="co-white ">Tambon/Sub-District *</small>
													<div class="autocomplete">
														<input type="text" id="subdistrict" name="subdistrict" class="form-control" placeholder="Tambon/Sub-District" value="{{ old('subdistrict') }}" />
														@error('subdistrict')
															<small class="co-white" role="alert"><strong>{{ $message }}</strong></small>
														@enderror
														<div id="matchList"></div>
													</div>
												</div>
											</div>
											<div class="col-md-6 col-sm-6">
												<div class="form-group  text-left">
													<small class="co-white">Amphoe/District</small>
													<input type="text" class="form-control" placeholder="Amphoe/District" id="city" name="city" value="{{ old('city') }}" >
												</div>
											</div>
											<div class="col-md-6 col-sm-6">
												<div class="form-group  text-left">
													<small class="co-white">Province *</small>
													<input type="text" class="form-control" placeholder="Province" id="province" name="province" value="{{ old('province') }}" >
													@error('province')
														<small class="co-white" role="alert"><strong>{{ $message }}</strong></small>
													@enderror
												</div>
											</div>
											<div class="col-md-6 col-sm-6">
												<div class="form-group  text-left">
													<small class="co-white">Postal Code</small>
													<input type="text" class="form-control" placeholder="Postal Code" id="code" name="code" value="{{ old('code') }}" >
												</div>
											</div>
											<div class="col-md-12">
												<div class="form-group" style="text-align: left;">
													<input class="checkbox-style" type="checkbox" name="description[pdpa-consent]" id="select-all"  value="checked">
													<label class="co-white" for="select-all" style="font-weight: normal; margin-left:10px; text-align:left;">
														<small>ยินดีรับข้อมูลข่าวสารจากเรา และบริษัทในเครือ <span>(รายละเอียดเพิ่มเติม <a href="https://phpstack-1646968-6541058.cloudwaysapps.com/page/privacy-policy/" target="_blank">Privacy Policy</a>)</span></small>
													</label>
												</div>
											</div>
											<div class="col-md-12 mt-20">
												<div class="form-group title-center">
													<input type="hidden" name="campaignid" value="1790451" />
													<input type="hidden" name="mailtoteam" value="8BAHT_Lumion_Request_Trial" />
													<input type="hidden" name="regis_type" value="download"/>
													<input type="hidden" name="pages" value="lumion" />
													<input type="hidden" name="checkemail" value="true" />
													<input type="hidden" name="assigned" value="446" />
													<input  type="hidden" name="url_path" value="{{ "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" }}" />
													<input type="hidden" name="redirect" value="{{ 'https://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] }}"/>
													<input type="hidden" name="og_keywords" value="Lumion,8baht,Lumion ดาวน์โหลดฟรี,Lumion,Lumion download,Lumion ทดลองใช้,Lumion ราคา" />
													<input type="hidden" name="og_description" value="Lumion เป็นซอฟต์แวร์สำหรับเรนเดอร์ แบบสแตนด์อโลน ซึ่งช่วยให้การออกแบบได้ถูกถ่ายทอดออกไปอย่างสมบูรณ์" />
													<input type="hidden" name="og_image" value="{{ asset('onepages/lumion/images/LUMION-logo.webp') }}" />
													<input  type="hidden" name="urlreference" @if(!empty($_GET["ref"]))value="{{ $_GET["ref"] }}"@endif >
													
													<script src="https://www.google.com/recaptcha/api.js"></script>
													<button class="bth btn-lg btn-submit btn-quotation g-recaptcha" data-sitekey="6Le53ssZAAAAAPL3FAcWOt6CxB-AKPe6xKovHqHD" data-callback='onSubmit' data-action='submit' >
														<img src="{{ asset('onepages/gstarcad/images/items/cursor-hand-click-line.png') }}" style="margin-right: 10px; width:20px"/>
														Submit
													</button>
												</div>
											</div>
											
											
										</div>
									</form>
								</div>
							</div>
							<div class="col-md-2 hidden-sm"></div>
						</div>
                    </div>
                    
                    <!--div id="section-content-11"  class="content-block-contact">
                        <a href="{{ route('onepage.gstarcad.dowload') }}?ref=LDP_lower">
                            <img class="item-dowload-btn" src="{{ asset('onepages/gstarcad/images/items/slider-items-btn.png') }}" alt="item gstarcad" />
                        </a>
                        <div class="hd-item-contact-mobile">
                            <br/>
                            <h2 style="margin-bottom:0px">ต้องการคำแนะนำ<br/>ติดต่อเจ้าหน้าที่ของเรา</h2>
                        </div>
                    </div>
                    <div id="section-content-12" class="content-bule" >
                        <div class="grid-recommend">
                            <div class="hd-item-contact-desktop">
                                <h2 style="margin-bottom:0px" class="co-white">ต้องการคำแนะนำ<br/>ติดต่อเจ้าหน้าที่ของเรา</h2>
                            </div>
                            <div>
                                <a href="https://lin.ee/S9eyleh" target="_bank">
                                    <img class="item-contact-line" src="{{ asset('onepages/gstarcad/images/icons/logo-01@3x.png') }}" alt="add line">
                                </a>
                            </div>
                            <div style="position: relative;">
                                <img class="item-img-contact" src="{{ asset('onepages/gstarcad/images/items/artwork-3@3x.png') }}" alt="add line">
                            </div>
                        </div>
                    </div-->
                </div>
            </div>
        </section>

        <footer id="footer" class="font-12 center">
            © สงวนลิขสิทธิ์ 2023 บริษัท แอพพลิแคด จำกัด (มหาชน)
        </footer>
    </div>

    <!-- canvas js -->
    <script type="text/javascript" src="{{ asset('assets/fontend/js/jquery.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/fontend/js/plugins.js') }}"></script>
    <script type="text/javascript" src="{{ asset('onepages/gstarcad/functions.js') }}"></script>
    <!-- custom js -->
    <script type="text/javascript" src="{{ asset('onepages/gstarcad/custom.js?v=01') }}"></script>
    <script type="text/javascript" src="{{ asset('onepages/lumion/custom.js?v=000006') }}"></script>
	<script>
		function onSubmit(token) {
			loadding();
			document.getElementById("request-quotation").submit();
		}
	</script>
</body>
</html>
