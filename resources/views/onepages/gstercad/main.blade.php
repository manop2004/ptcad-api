<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head  >
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" href="{{ asset('onepages/gstarcad/images/logo/logo-gstar-cad-011.png') }}" type ="image/x-icon">
<title>GstarCAD - 8BAHT.COM</title>

<meta http-equiv="Content-Language" content="th">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Cache-control" content="public" max-age="604800">

<meta name="robots" content="index, follow" />
<meta name="author" content="GstartCAD - 8BAHT.COM" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5" />

<meta property="og:site_name" content="GstartCAD - 8BAHT.COM"/>
<meta name="keywords" content="gstarcad,8baht,gstarcad ดาวน์โหลดฟรี,GstarCAD,GstarCAD download,gstarcad ทดลองใช้,GstarCAD ราคา">
<meta name="description" content="โปรแกรมเขียนแบบที่มีประสิทธิภาพ ใช้งานเทียบเท่า ออโตแคด เป็น Licenseแบบถาวร GstarCAD จัดเก็บไฟล์เป็นนามสกุล .DWG แบบเดียวกัน ซึ่งสามารถเปิดไฟล์งานจาก AutoCAD (R14 ถึงรุ่นล่าสุด)...">
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
                        <a href="{{ route('onepage.gstarcad.index') }}" class="standard-logo" data-dark-logo="{{ asset('onepages/gstarcad/images/logo/logo-gstar-cad-011.png') }}"><img src="{{ asset('onepages/gstarcad/images/logo/logo-gstar-cad-011.png') }}" alt="logo gstarcad"></a>
                        <a href="{{ route('onepage.gstarcad.index') }}" class="retina-logo" data-dark-logo="{{ asset('onepages/gstarcad/images/logo/logo-gstar-cad-011.png') }}"><img src="{{ asset('onepages/gstarcad/images/logo/logo-gstar-cad-011.png') }}" alt="logo gstarcad"></a>
                    </div>

                    <div class="top-links">
                        <ul class="hd-primary-menu-contact-desktop">
                            <li><a href="tel:+6627449397"><div><img class="icon-bar" src="{{ asset('onepages/gstarcad/images/icons/call@3x.png') }}" alt="Logo"></div></a></li>
                            <li><a href="https://lin.ee/S9eyleh"><div><img class="icon-bar" src="{{ asset('onepages/gstarcad/images/icons/btn-press@3x.png') }}" alt="Logo"></div></a></li>
                        </ul>
                    </div>

                    <nav id="primary-menu">
						<ul class="one-page-menu">
                            <li class="hd-primary-menu-contact-mobile">
                                <div class="grid-contact-two-bar">
                                    <a href="tel:+6627449397"><img class="icon-bar" src="{{ asset('onepages/gstarcad/images/icons/call@3x.png') }}" alt="Logo"></a>
                                    <a href="https://lin.ee/S9eyleh"><img class="icon-bar" src="{{ asset('onepages/gstarcad/images/icons/btn-press@3x.png') }}" alt="Logo"></a>
                                </div>
                            </li>
							<li class="current"><a href="#" data-href="#section-content-2"><div>ขอใบเสนอราคา <i class="material-icons font-24">arrow_drop_down</i></div></a></li>
							<li class="current"><a href="#" data-href="#section-content-3"><div>ทำไมควรเลือก GstarCAD <i class="material-icons font-24">arrow_drop_down</i></div></a></li>
							<li><a href="#" data-href="#section-content-10"><div>คำถามที่พบบ่อย <i class="material-icons font-24">arrow_drop_down</i></div></a></li>
						</ul>

					</nav>

                </div>

            </div>

        </header>

        <section id="content">
            <div class="content-wrap">
				<div class="clearfix">
                    <div id="section-home" class="bg-section-home">
                        <div class="row">
                            <div class="col-md-6 text-center"><a  href="#" data-scrollto="#section-content-2" data-offset="100" class="hd-plan-desktop" ><img class="item-home-1" src="{{ asset('onepages/gstarcad/images/items/cad-item-1_2.png') }}" alt="item gstarcad"></a></div>
                            <div class="col-md-6 text-center"><img class="item-home-2"  src="{{ asset('onepages/gstarcad/images/items/GstarCAD2025-box.png') }}" alt="item gstarcad"></div>
                        </div>
                    </div>
                    <div id="section-home-mini" class="bg-section-home-mini">
                        <div class="row">
                            <div class="col-lg-3 col-md-6 col-sm-6 line-238-1 text-center">
                                <img class="icon-home-mini" src="{{ asset('onepages/gstarcad/images/items/save-money.png') }}" alt="item gstarcad">
                                <div class="co-white block-home-mini">ลดค่าใช้จ่ายด้านซอฟต์แวร์ ไม่ต้องจ่ายรายปี ลิขสิทธิ์แบบซื้อขาด</div>
                                <p class="co-white">จ่ายครั้งเดียว</p>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 line-238-2 text-center">
                                <img class="icon-home-mini"  src="{{ asset('onepages/gstarcad/images/items/flip.png') }}" alt="item gstarcad">
                                <div class="co-white block-home-mini">เพียง 15 นาทีเท่านั้น ที่คุณจะพบว่าคุณคุ้นเคยกับ GstarCAD เริ่มงานของคุณได้ทันที!</div>
                                <p class="co-white">เหมือน AutoCAD</p>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 line-238-3 text-center">
                                <img class="icon-home-mini"  src="{{ asset('onepages/gstarcad/images/items/transfer.png') }}" alt="item gstarcad">
                                <div class="co-white block-home-mini">เพิ่มความสะดวก ในการทำงานร่วมกันสามารถแลกเปลี่ยนไฟล์กับซอฟต์แวร์ CAD  ตัวอื่นๆ ได้ รวมถึง AutoCAD*</div>
                                <p class="co-white">รองรับไฟล์ AutoCAD</p>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 line-238-4 text-center">
                                <img class="icon-home-mini"  src="{{ asset('onepages/gstarcad/images/items/technical-support.png') }}" alt="item gstarcad">
                                <div class="co-white block-home-mini">Technical Suport พร้อมช่วยเหลือ เมื่อเกิดปัญหาบริการ Onsite Service**</div>
                                <p class="co-white">ทีมผู้เชี่ยวชาญดูแล</p>
                            </div>
                        </div>
                    </div>
                    <div id="section-content-1" class="content-block">
                        <div class="heading-block center">
                            <h1>GstarCAD โปรแกรมเขียนแบบ เพื่อธุรกิจของคุณ</h1>
                        </div>
                        <div>
                            GstarCAD คือ โปรแกรมเขียนแบบ 2D/3D เป็นซอฟแวร์ CAD ที่มีประสิทธิภาพ ทำงานได้รวดเร็วและมีฟังก์ชั่นครบครัน รองรับทุกสายงาน ไม่ว่าจะเป็นเขียนแบบบ้าน ชิ้นส่วนอุปกรณ์ แผนผัง รวมถึงเขียนแบบไฟฟ้าในราคาที่คุ้มค่า พร้อมทั้งฟังก์ชั่นการทำงานอีกมากมาย ที่ช่วยการทำงานของคุณเต็มประสิทธิภาพยิ่งขึ้น
                        </div>
                    </div>
                    <div id="section-content-2" class="content-block">
                        <div class="grid-quotation">
                            <div>
                                <div class="center">
                                    <h3>ซื้อ GstarCAD กับเรา<br/>พร้อมของแถมสุดพิเศษ</h3>
                                    <img class="item-content-quotation-free" src="{{ asset('onepages/gstarcad/images/items/quotation-free.png') }}" alt="quotation-free" >
                                </div>
                            </div>
                            <div>
                                <div class="bg-quotation">
                                    <h3 class="co-white">รับข้อเสนอสุดพิเศษ</h3>
                                    <form id="request-quotation" name="request-quotation" method="post" action="{{ route('onepage.gstarcad.crate') }}" style="margin-bottom: 0px;" onsubmit="return validateForm(event)">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6">
                                                <div class="form-group text-left">
                                                    <small class="co-white " >ชื่อผู้ติดต่อ *</small>
                                                    <input type="text" class="form-control" placeholder="ชื่อผู้ติดต่อ" id="firstname" name="firstname" value="{{ old('firstname') }}">
                                                    @error('firstname')
                                                        <small class="co-white" role="alert"><strong>{{ $message }}</strong></small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="form-group  text-left">
                                                    <small class="co-white ">ตำแหน่ง *</small>
                                                    <input type="text" class="form-control" placeholder="ตำแหน่ง" id="designation" name="designation" value="{{ old('designation') }}">
                                                    @error('designation')
                                                        <small class="co-white" role="alert"><strong>{{ $message }}</strong></small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-sm-12">
                                                <div class="form-group  text-left">
                                                    <small class="co-white">ชื่อบริษัท (ถ้ามี)</small>
                                                    <input type="text" class="form-control" placeholder="ชื่อบริษัท (ถ้ามีกรอกเป็นภาษาอังกฤษเท่านั้น!)" id="company" name="company" value="{{ old('company') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="form-group  text-left">
                                                    <small class="co-white ">เบอร์มือถือ *</small>
                                                    <input type="tel" class="form-control" placeholder="เบอร์มือถือ *" id="phone" name="mobile" value="{{ old('mobile') }}" >
                                                    @error('mobile')
                                                        <small class="co-white" role="alert"><strong>{{ $message }}</strong></small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="form-group  text-left">
                                                    <small class="co-white">อีเมล์ *</small>
                                                    <input type="text" class="form-control" placeholder="อีเมล์ (สำหรับส่งใบเสนอราคา) *" id="email" name="email" value="{{ old('email') }}">
                                                    @error('email')
                                                        <small class="co-white" role="alert"><strong>{{ $message }}</strong></small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group  text-left">
                                                    <div class="co-fcc841" style="margin-bottom: 20px; margin-top:10px">บอกเราหน่อย! เพื่อให้เราเสนอราคาที่ดีที่สุดให้</div>
                                                    <div class="grid-quotation-radio text-left">
                                                        <div>
                                                            <input id="check_01"  class="form-check-input" name="description[checked-detail-old]" type="checkbox" value="มีใช้งานอยู่แล้ว แต่อยากหาตัวที่คุ้มค่า">
                                                            <label for="check_01" class="form-check-label co-white" style="font-weight: unset;    text-transform: unset; letter-spacing: 0;">มีใช้งานอยู่แล้ว แต่อยากหาตัวที่คุ้มค่า</label>
                                                        </div>
                                                        <div>
                                                            <input id="check_02" class="form-check-input" name="description[checked-detail-new]" type="checkbox" value="ซื้อใหม่ มองหาโปรแกรมเขียน CAD">
                                                            <label for="check_02" class="form-check-label co-white" style="font-weight: unset;    text-transform: unset; letter-spacing: 0;">ซื้อใหม่ มองหาโปรแกรมเขียน CAD</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group  text-left">
                                                    <small class="co-white" >ข้อความถึงเรา (ถ้ามี)</small>
                                                    <textarea class="form-control" placeholder="สนใจแบบซื้อขาด ใช้งาน 2 เครื่อง" icols="40" rows="2" id="comment" name="description[message]" >{{ old('description[message]') }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group title-center">
                                                    <input type="hidden" name="campaignid" value="1067707" />
                                                    <input type="hidden" name="mailtoteam" value="LDP_GstarCAD_on_8baht" />
                                                    <input type="hidden" name="regis_type" value="quotation" />
                                                    <input type="hidden" name="pages" value="gstarcad" />
                                                    <input type="hidden" name="checkemail" value="" />
                                                    <input type="hidden" name="assigned" value="725" />
                                                    <input  type="hidden" name="url_path" value="{{ "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" }}" />
                                                    <input type="hidden" name="redirect" value="{{ 'https://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] }}"/>
                                                    <input type="hidden" name="og_keywords" value="gstarcad,8baht,gstarcad ดาวน์โหลดฟรี,GstarCAD,GstarCAD download,gstarcad ทดลองใช้,GstarCAD ราคา" />
                                                    <input type="hidden" name="og_description" value="โปรแกรมเขียนแบบที่มีประสิทธิภาพ ใช้งานเทียบเท่า ออโตแคด เป็น Licenseแบบถาวร GstarCAD จัดเก็บไฟล์เป็นนามสกุล .DWG แบบเดียวกัน ซึ่งสามารถเปิดไฟล์งานจาก AutoCAD (R14 ถึงรุ่นล่าสุด)..." />
                                                    <input type="hidden" name="og_image" value="{{ asset('onepages/gstarcad/images/items/GstarCAD2025-box.png') }}" />
                                                    <input  type="hidden" name="urlreference" @if(!empty($_GET["ref"]))value="{{ $_GET["ref"] }}"@endif >
                                                    <button id="btn-submit" onclick="loadding()" type="submit" class="bth btn-lg btn-submit btn-quotation" name="submit" >
                                                        <img src="{{ asset('onepages/gstarcad/images/items/cursor-hand-click-line.png') }}" style="margin-right: 10px; width:20px"/>
                                                        คลิก! ให้เราส่งรายละเอียด
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div>
                                                        <input type="hidden" name="description[pdpa-consent]" id="select-all"  value="checked" checked>
                                                        <div class="co-white center">
                                                            <small>เมื่อท่านส่งข้อมูลผ่านฟอร์ม จะถือว่าท่านยอมรับใน <a href="https://phpstack-1646968-6541058.cloudwaysapps.com/page/privacy-policy/" class="co-fcc841">นโยบายความเป็นส่วนตัว</a> ของเรา</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="section-content-3" class="content-block">
                        <h1 class="center">Interface และคำสั่งที่คุ้นเคย</h1>
                        <div>
                            GstarCAD มีหน้าตาที่คล้ายกับ AutoCAD มี Interface ให้เลือกตามความเหมาะสมกับการใช้งาน ผู้ใช้สามารถสลับไปมาระหว่าง Ribbon interface และ Classic interface สำหรับผู้ที่ใช้งาน AutoCAD อยู่แล้ว สามารถสลับเปลี่ยนมาใช้งาน GstarCAD ได้ทันที โดยไม่ต้องเรียนรู้การใช้งานใหม่
                        </div>
                        <br/>
                        <img class="item-content-Interface" src="{{ asset('onepages/gstarcad/images/items/45999-converted-01@3x.png') }}" alt="content" />
                    </div>
                    <div id="section-content-4" class="content-block">
                        <h1>ทำงานร่วมกับผู้อื่นได้เหมือนเดิม</h1>
                        <div>
                            ใช้แทน CAD ตัวเดิมของคุณได้ทันที รองรับไฟล์งาน ได้เหมือน AutoCAD (R14 ถึง รุ่นล่าสุด) ไม่จำเป็นต้องทำการแปลงไฟล์ก่อนเปิดใช้งาน โดย นำเข้าและส่งออกไฟล์ DWG, DXF and SCR (script) files
                        </div>
                        <br/>
                        <img style="max-width: 600px;width:100%" src="{{ asset('onepages/gstarcad/images/items/vspic-07@3x.png') }}" alt="content" />
                    </div>
                    <div id="section-content-5" class="content-gray">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 center">
                                <img src="{{ asset('onepages/gstarcad/images/items/cad2020-icon9.png') }}" alt="content" />
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <button class="button button-circle btn-blue" >เครื่องมือเฉพาะ</button>
                                <br/>
                                <br/>
                                <h4>คำสั่งเครื่องมือ<span class="co-fcc841" >ที่มีเฉพาะใน GstarCAD เท่านั้น </span>กว่า 100 คำสั่งเมนู ที่ช่วยให้คุณทำงานได้เร็วยิ่งขึ้น เช่น "แสดงตารางพื้นที่" "เลเยอร์อัตโนมัติ" "วิวพอร์ตไปยังเค้าโครง"</h4>
                            </div>
                        </div>
                    </div>
                    <div id="section-content-architecture" class="content-block center">
                        <h1 class="mg-b-0">GstarCAD Architecture</h1>
                        <h2>สถาปัตยกรรม เขียนแบบก่อสร้าง</h2>
                        <div class="grid-architecture center">
                            <div class="center">
                                <div class="video-play-1" >
                                    <video class="video-flex-1" controls>
                                        <source src="{{ asset('onepages/gstarcad/mp4/GstarCAD_Architecture2021_.mp4') }}" type="video/mp4">
                                    </video>
                                </div>
                                <img src="{{ asset('onepages/gstarcad/images/items/notebook-mockup.png') }}" alt="content" />
                            </div>
                            <div class="text-left">
                                GstarCAD สำหรับงานด้านสถาปัตยกรรม มีฟังก์ชันระดับมืออาชีพและ นวัตกรรมสำหรับการเขียนแบบก่อสร้าง เช่น การเชื่อมต่อบนผนัง หน้าต่างเบย์การจัดการสถิติวัตถุมิติข้อมูลและพิกัด
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 center">
                                        <img class="icon-architecture" src="{{ asset('onepages/gstarcad/images/items/Architecture-Objects.png') }}" alt="content" />
                                    </div>
                                    <div class="col-md-6 col-sm-6 center">
                                        <img class="icon-architecture" src="{{ asset('onepages/gstarcad/images/items/Innovative-Function.png') }}" alt="content" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="section-content-mechanical" class="content-block center">
                        <h1 class="mg-b-0">GstarCAD Mechanical</h1>
                        <h2>เครื่องกล แปลนไฟฟ้า Electrical Drawing</h2>
                        <div >
                            ครอบคลุมทุกสาขาของการออกแบบไม่ว่าจะเขียนเครื่องกล หรือ แปลนไฟฟฟ้า GstarCAD  รองรับการออกแบบและวาดภาพระดับมืออาชีพ ที่สร้างขึ้นเป็นพิเศษ ไม่ว่าคุณจะเผชิญกับงานออกแบบประเภทใด  GstarCAD จะช่วยเติมเต็มไอเดียของคุณให้สมบูรณ์แบบ
                        </div>
                        <br/>
                        <div class="grid-mechanical">
                            <div class="video-play-2" >
                                <video class="video-flex-2" controls>
                                    <source src="{{ asset('onepages/gstarcad/mp4/GstarCAD_Mechanical_overview.mp4') }}" type="video/mp4">
                                </video>
                            </div>
                            <img class="img-width-mechanical" src="{{ asset('onepages/gstarcad/images/items/mechanical-icon-3.png') }}" alt="content" />
                        </div>
                    </div>
                    <div id="section-content-6" class="content-block center">
                        <img src="{{ asset('onepages/gstarcad/images/items/item-promo-head.png') }}" alt="item gstarcad" />
                        <a  href="#" data-scrollto="#section-content-2" data-offset="100" class="hd-plan-desktop" >
                            <img class="item-plan" src="{{ asset('onepages/gstarcad/images/items/priceGstarCad_2025_full.jpg') }}" alt="content" />
                        </a>
                        <a  href="#" data-scrollto="#section-content-2" data-offset="100" class="hd-plan-mobile" >
                            <img class="item-plan" src="{{ asset('onepages/gstarcad/images/items/gstarcad2025-h.png') }}" alt="content" />
                            <img class="item-plan" src="{{ asset('onepages/gstarcad/images/items/gstarcad2025-h-m1.png') }}" alt="content" />
                            <img class="item-plan" src="{{ asset('onepages/gstarcad/images/items/gstarcad2025-h-m2.png') }}" alt="content" />
                        </a>
                        <div class="center"><small>ราคานี้ยังไม่รวมภาษีมูลค่าเพิ่ม 7%  หากคุณมีข้อสงสัยใดๆ กรุณาติดต่อเรา</small></div>
                        <br/>
                        <div  class="center" style="max-width: 800px; margin:auto">
                            <div class="grid-promotuon-codition">
                                <div class="text-left" ><small>เงื่อนไขโปรโมชั่นลิขสิทธิ์ซื้อขาด</small></div>
                                <div class="text-left" >
                                    <div class="grid-icon-condition">
                                        <div><span class="icon-condition"></span><small>ได้รับ SN จริง เมื่อชำระเงินครบถ้วน (ช่วงนี้ได้เป็น Temp SN)</small> </div>
                                        <div><span class="icon-condition"></span><small>สั่งจ่ายเป็น PDC 60 วันนับจากวันที่ส่ง PO</small> </div>
                                        <div><span class="icon-condition"></span><small>เงื่อนไขเป็นไปตามที่บริษัทกำหนดฯ</small> </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="section-content-7" class="bg-section-7 content-section-7">
                        <h1 class="center">CAD ทางเลือก เหตุผลที่คุณต้องเป็นเจ้าของ</h1>
                        <div class="row hd-img-11-res-desktop">
                            <div class="col-md-4 col-sm-6 title-center">
                                <img class="item-cad-icon" src="{{ asset('onepages/gstarcad/images/items/icon-01@3x.png') }}" alt="icon" >
                                <h4 class="nobottommargin">แทน CAD ตัวเดิมของคุณได้ทันที</h4>
                                <div class="width-block-content-4">รูปแบบการทำงาน และ คำสั่งต่างๆ ใกล้เคียงกับ AutoCAD ไม่เสียเวลา และ ค่าใช้จ่ายในการเรียนรู้</div>
                            </div>
                            <div class="col-md-4 col-sm-6 title-center">
                                <img class="item-cad-icon" src="{{ asset('onepages/gstarcad/images/items/icon-05@3x.png') }}" alt="icon" >
                                <h4 class="nobottommargin">ทำงานร่วมกับผู้อื่นได้เหมือนเดิม</h4>
                                <div class="width-block-content-4">รองรับไฟล์งานเก่า จาก AutoCAD ไม่จำเป็นต้องทำการแปลงไฟล์ใดๆ ทั้งสิ้น สะดวกในการทำงานร่วมกับผู้อื่น</div>
                            </div>
                            <div class="col-md-4 col-sm-6 title-center">
                                <img class="item-cad-icon" src="{{ asset('onepages/gstarcad/images/items/icon-03@3x.png') }}" alt="icon" >
                                <h4 class="nobottommargin">ช่วย ลดค่าใช้จ่าย</h4>
                                <div class="width-block-content-4">เป็นซอฟต์แวร์ลิขสิทธิ์ ประเภทซื้อขาดจ่ายครั้งเดียวตลอดชีพ ไม่ต้องเสียรายปี</div>
                            </div>
                        </div>
                        <div class="row hd-img-11-res-desktop">
                            <div class="col-md-2 col-sm-2"></div>
                            <div class="col-md-4 col-sm-4 title-center">
                                <img class="item-cad-icon" src="{{ asset('onepages/gstarcad/images/items/icon-04@3x.png') }}" alt="icon" >
                                <h4 class="nobottommargin">รองรับขนาดไฟล์งานทุกระดับ</h4>
                                <div class="width-block-content-4">สามารถทำงานได้กับไฟล์ทุกขนาดทำให้ไม่มีปัญหาหากต้องเปิดไฟล์ใหญ่</div>
                            </div>
                            <div class="col-md-4 col-sm-4 title-center">
                                <img class="item-cad-icon" src="{{ asset('onepages/gstarcad/images/items/icon-02@3x.png') }}" alt="icon" >
                                <h4 class="nobottommargin">รองรับการทำงานหลายเครื่อง</h4>
                                <div class="width-block-content-4">เหมาะสำหรับผู้ใช้งานหลายคน ในองค์กรขนาดใหญ่ (เฉพาะ license ประเภท Network*)</div>
                            </div>
                            <div class="col-md-2 col-sm-2"></div>
                        </div>
                        <div class="row hd-img-11-res-mobile">
                            <div class="col-sm-12 title-center">
                                <div id="hd-show-pid" style="display: block;">
                                    <div class="col-md-12 title-center">
                                        <img class="item-cad-icon" src="{{ asset('onepages/gstarcad/images/items/icon-01@3x.png') }}" alt="icon" >
                                        <h4 class="nobottommargin">แทน CAD ตัวเดิมของคุณได้ทันที</h4>
                                        <div class="width-block-content-4">รูปแบบการทำงาน และ คำสั่งต่างๆ ใกล้เคียงกับ AutoCAD ไม่เสียเวลา และ ค่าใช้จ่ายในการเรียนรู้</div>
                                        <br/>
                                        <button onclick="clickHide()" class="co-bule button-hd-psi"><img style="width:10px; height: 10px;" class="item-cad-icon" src="{{ asset('onepages/gstarcad/images/items/plus-circle.png') }}" alt="icon" > ดูเพิ่มเติม</button>
                                    </div>
                                </div>
                                <div id="hd-show-pid-w" style="display: none;">
                                    <div class="col-md-12 title-center">
                                        <img class="item-cad-icon" src="{{ asset('onepages/gstarcad/images/items/icon-01@3x.png') }}" alt="icon" >
                                        <h4 class="nobottommargin">แทน CAD ตัวเดิมของคุณได้ทันที</h4>
                                        <div class="width-block-content-4">รูปแบบการทำงาน และ คำสั่งต่างๆ ใกล้เคียงกับ AutoCAD ไม่เสียเวลา และ ค่าใช้จ่ายในการเรียนรู้</div>
                                    </div>
                                    <div class="col-md-12 title-center">
                                        <img class="item-cad-icon" src="{{ asset('onepages/gstarcad/images/items/icon-05@3x.png') }}" alt="icon" >
                                        <h4 class="nobottommargin">ทำงานร่วมกับผู้อื่นได้เหมือนเดิม</h4>
                                        <div class="width-block-content-4">รองรับไฟล์งานเก่า จาก AutoCAD ไม่จำเป็นต้องทำการแปลงไฟล์ใดๆ ทั้งสิ้น สะดวกในการทำงานร่วมกับผู้อื่น</div>
                                    </div>
                                    <div class="col-md-12 title-center">
                                        <img class="item-cad-icon" src="{{ asset('onepages/gstarcad/images/items/icon-03@3x.png') }}" alt="icon" >
                                        <h4 class="nobottommargin">ช่วย ลดค่าใช้จ่าย</h4>
                                        <div class="width-block-content-4">เป็นซอฟต์แวร์ลิขสิทธิ์ ประเภทซื้อขาดจ่ายครั้งเดียวตลอดชีพ ไม่ต้องเสียรายปี</div>
                                    </div>
                                    <div class="col-md-12 title-center">
                                        <img class="item-cad-icon" src="{{ asset('onepages/gstarcad/images/items/icon-04@3x.png') }}" alt="icon" >
                                        <h4 class="nobottommargin">รองรับขนาดไฟล์งานทุกระดับ</h4>
                                        <div class="width-block-content-4">สามารถทำงานได้กับไฟล์ทุกขนาดทำให้ไม่มีปัญหาหากต้องเปิดไฟล์ใหญ่</div>
                                    </div>
                                    <div class="col-md-12title-center">
                                        <img class="item-cad-icon" src="{{ asset('onepages/gstarcad/images/items/icon-02@3x.png') }}" alt="icon" >
                                        <h4 class="nobottommargin">รองรับการทำงานหลายเครื่อง</h4>
                                        <div class="width-block-content-4">เหมาะสำหรับผู้ใช้งานหลายคน ในองค์กรขนาดใหญ่ (เฉพาะ license ประเภท Network*)</div>
                                    </div>
                                    <br/>
                                    <button onclick="clickHide()" class="co-bule button-hd-psi"> <i class="icon-angle-up"></i> ปิด</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div id="section-content-8" class="content-section-8">
                        <h1 class="center">ตัวอย่างบริษัทต่างๆ ที่ได้นำ GstarCAD ไปใช้งาน ↓</h1>
                        <div class="fslider" data-easing="easeInQuad">
                            <div class="flexslider">
                                <div class="slider-wrap">
                                    <div class="slide">
                                        <div class="slide-block center">
                                            « ทีมเราใช้ GstarCAD อยู่ในช่วงของการเตรียมแบบสำหรับการก่อสร้างพื้นโพสเทนชั่น เราต้องมีแบบรายละเอียด ประกอบก่อนว่าพื้นมีความหนาเท่าไหร่ วัสดุที่ใช้มีอะไร จำนวนเท่าไร จะต้องอยู่ตำแหน่งตรงไหนของแบบรายละเอียด GstarCAD จะเข้ามาช่วยในเรื่องของการสร้างรายละเอียดของแบบเหล่านี้ และส่งข้อมูลต่อไปยังโรงงาน และอีกส่วนหนึ่งจะถูกส่งไปที่หน้างานเพื่อใช้ในการประกอบติดตั้ง »
                                            <br/>
                                            <br/>
                                           <b>บริษัทผลิตภัณฑ์และวัตถุก่อสร้าง จำกัด (CPAC) ในเครือซิเมนต์ไทย</b>
                                        </div>
                                    </div>
                                    <div class="slide">
                                        <div class="slide-block center">
                                            « เหตุที่ใช้ GstarCAD เพราะเป็นซอฟท์แวร์ลิขสิทธิ์ราคาประหยัด จึงทำให้ต้นทุนเราไม่สูง และผู้ใช้งานเราก็บอกเลยว่าใช้งานง่าย หากแค่พอมีพื้นฐานอยู่ก็สามารถใช้งานได้เลย ไม่ยุ่งยากอะไร สามารถเอาไปประยุกต์ใช้กับงานแต่ละส่วนที่เค้าใช้งานได้ เรียกได้ว่า คุณภาพคับแก้วราคาโดนใจครับ »
                                            <br/>
                                            <br/>
                                           <b>คุณภูษิต เดชะกุล ผู้จัดการโรงงาน บริษัท Summa N.K. Contracting</b>
                                        </div>
                                    </div>
                                    <div class="slide">
                                        <div class="slide-block center">
                                            « จากเท่าที่สัมผัสมาก็พึงพอใจมาก คือทั้ง 2D และ 3D GstarCAD รองรับได้หมดเลย ถ้าเป็น CAD ตัวอื่น ไฟล์ที่เป็น 3D ก็ต้องซื้อ 3D มาใช้ แต่ GstarCAD ไม่ต้อง แล้วฟังก์ชั่นในการทำงานต่างๆ สามารถรองรับไฟล์ CAD อื่นได้ »
                                            <br/>
                                            <br/>
                                           <b>คุณกิติชัย วิจิตรสุขุม หัวหน้าฝ่ายงานออกแบบ บริษัท SECOM</b>
                                        </div>
                                    </div>
                                    <div class="slide">
                                        <div class="slide-block center">
                                            « “We are Professional in Construction” เราเน้นย้ำการใช้ซอฟต์แวร์ลิขสิทธิ์ทั้งหมด 100 % ข้อดีมันต้องมีอยู่แล้ว คือเราจะทำงานด้วยความสบายใจขึ้นเยอะ ไม่ต้องมาพะวง ระแวดระวังเรื่องจะมีคนเข้ามาตรวจจับอะไรแบบนี้ ตัดปัญหาตรงนี้ไปเลย »
                                            <br/>
                                            <br/>
                                           <b>คุณฐานะ IT Manager บริษัท สยาม มัลติ คอน จำกัด</b>
                                        </div>
                                    </div>
                                    <div class="slide">
                                        <div class="slide-block center">
                                            « กระบวนการเลือกง่ายๆ เราเลือกซอฟต์แวร์ CAD ที่ให้ทดลองใช้ในท้องตลาด นำแต่ละตัวมาติดตั้ง เพื่อทดสอบดูว่า CAD ตัวไหนสามารถรองรับการทำงานของเราได้ดีที่สุด ซึ่ง GstarCAD เป็นตัวเดียวที่สามารถทำตามคำสั่งของเราได้ครบทุกคำสั่ง โดยที่ไม่มี Error ครับ »
                                            <br/>
                                            <br/>
                                           <b>บริษัท ซี-โพส จำกัด โดยทีมงานวิศวกร</b>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <div id="section-content-9" class="content-block center">
                            <h1 class="center">ภาพตัวอย่างโปรแกรม</h1>
                            <div class="boxed-slider">
                                <div class="clearfix">

                                    <div class="fslider" data-easing="easeInQuad">
                                        <div class="flexslider">
                                            <div class="slider-wrap">
                                                <div class="slide" data-thumb="{{ asset('onepages/gstarcad/images/slider/Rapid Dist-1.png') }}">
                                                    <img src="{{ asset('onepages/gstarcad/images/slider/Rapid Dist-1.png') }}" alt="Rapid Dist">
                                                </div>
                                                <div class="slide" data-thumb="{{ asset('onepages/gstarcad/images/slider/GstarCAD 3D Pipe.png') }}">
                                                    <img src="{{ asset('onepages/gstarcad/images/slider/GstarCAD 3D Pipe.png') }}" alt="GstarCAD 3D Pipe">
                                                </div>
                                                <div class="slide" data-thumb="{{ asset('onepages/gstarcad/images/slider/3D Model 6.png') }}">
                                                    <img src="{{ asset('onepages/gstarcad/images/slider/3D Model 6.png') }}" alt="3D Model">
                                                </div>
                                                <div class="slide" data-thumb="{{ asset('onepages/gstarcad/images/slider/3D Model 5.png') }}">
                                                    <img src="{{ asset('onepages/gstarcad/images/slider/3D Model 5.png') }}" alt="3D Model">
                                                </div>
                                                <div class="slide" data-thumb="{{ asset('onepages/gstarcad/images/slider/3D Mash.png') }}">
                                                    <img src="{{ asset('onepages/gstarcad/images/slider/3D Mash.png') }}" alt="3D Mash">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="section-content-10"  class="content-block">
                        <h1 class="center">GstarCAD คำถามที่พบบ่อย</h1>
                        <div class="clearfix">

                            <div class="accordion clearfix" data-state="closed">

                                <div class="acctitle"><i class="acc-closed icon-plus"></i><i class="acc-open icon-minus"></i>GstarCAD สิทธิ์ใช้ได้กี่เครื่อง</div>
                                <div class="acc_content clearfix">1 License ใช้งานได้ 1 เครื่อง หากมีการใช้งานหลายเครื่อง ทางเราขอแนะนำ แบบเครือข่าย (Network License)</div>

                                <div class="acctitle"><i class="acc-closed icon-plus"></i><i class="acc-open icon-minus"></i>สามารถอัพเดทเมื่อมีเวอร์ชั่นใหม่ได้หรือไม่</div>
                                <div class="acc_content clearfix">สามารถอัพเกรด เมื่อมีเวอร์ชั่นใหม่ได้ฟรี 1 ปี  โปรแกรมจะมีการอัพเกรดเวอร์ชั่นใหม่ 3-4 ปี</div>

                                <div class="acctitle"><i class="acc-closed icon-plus"></i><i class="acc-open icon-minus"></i>รองรับไฟล์อะไรบ้าง</div>
                                <div class="acc_content clearfix">นำเข้า และส่งออกไฟล์ DWG, DXF and SCR (script) files ได้เหมือน AutoCAD ทำงานร่วมกับผู้อื่นได้เหมือนเดิม</div>

                                <div class="acctitle" style="border-bottom: 1px solid #ccc !important;"><i class="acc-closed icon-plus"></i><i class="acc-open icon-minus"></i>มีเจ้าหน้าที่่ซัพพอร์ตหลังการขายหรือไม่</div>
                                <div class="acc_content clearfix">มีบริการหลังการขาย ด้วยเจ้าหน้าที่ผู้เชี่ยวชาญกว่า 250 คน  ด้วยทีมงานของ บจก. แอพพลิแคด เปิดดำเนินการตั้งแต่ปี พศ. 2537 จะช่วยดูแลคุณอย่างดีที่สุด</div>

                            </div>
                        </div>
                    </div>
                    <div id="section-content-11"  class="content-block-contact">
                        <a href="{{ route('onepage.gstarcad.dowload') }}?ref=@if(!empty($_GET["ref"])){{ $_GET["ref"] }}@else{{ 'LDP' }}@endif">
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
                    </div>
                </div>
            </div>
        </section>

        <footer id="footer" class="font-12 center">
            © สงวนลิขสิทธิ์ 2021 บริษัท แอพพลิแคด จำกัด (มหาชน)
        </footer>
    </div>

    <!-- canvas js -->
    <script type="text/javascript" src="{{ asset('assets/fontend/js/jquery.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/fontend/js/plugins.js') }}"></script>
    <script type="text/javascript" src="{{ asset('onepages/gstarcad/functions.js') }}"></script>
    <!-- custom js -->
    <script type="text/javascript" src="{{ asset('onepages/gstarcad/custom.js?v=01') }}"></script>


</body>
</html>
