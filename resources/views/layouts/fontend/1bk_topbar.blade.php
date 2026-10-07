@php
    $quotationSetting = App\Models\TbQuotationSetting::value('show');
@endphp
<div id="top-bar" class="hidden-mobile-md bg-black">
    <div class="container clearfix">
        <div class="col_half nobottommargin">
            @if(!empty($setting->setting_telContact))
                <p class="nobottommargin">
                    <strong>สอบถามข้อมูลเพิ่มเติมโทร </strong><a href="tel:{{ $setting->setting_telContact}}">{{ $setting->setting_telContact}}</a>
                    @if(!empty($setting->setting_telContact) && !empty($setting->setting_hotlineContact)){{ ", " }}@endif
                    @if(!empty($setting->setting_hotlineContact))<a href="tel:{{ $setting->setting_hotlineContact}}">{{ $setting->setting_hotlineContact}}</a>@endif
                    @if(!empty($setting->setting_idLine))
                        <a class="btn btn-line-head" href="{{$setting->setting_idLine}}" target="_bank">
                            <img  src="{{ asset('icon/social/social-line-2.webp') }}" class="mgr-5 icon-xs lazyload" width="20" height="20" alt="line" /> คุยกับเรา
                        </a>
                    @endif
                </p>
            @endif
        </div>
		<!--div class="col_one_third nobottommargin">
			<center class="nobottommargin" style="color: yellow;">
				สมาชิกใหม่ กรอกโค้ด <span class="badge" style="background-color: #E10000;">NEWMEMBER</span> ลดทันที 388 บาท
			</center>
        </div-->
        <div class="col_half col_last fright nobottommargin">
            <div class="top-links">
                <ul class="sf-js-enabled clearfix">
                    @if (Route::has('login'))
                        @auth
                            @if($quotationSetting == 1)
                            <li>
                                <a class="float-left top-link-a" href="{{ route('fronend.quotation') }}@if(!empty($_GET['ref']))?ref={{ $_GET['ref'] }}@endif">
                                    <button class="btn-quotation-tob-bar link-quotation-topbar">ขอใบเสนอราคา</button>
                                </a>
                            </li>
                            @endif
                            <li>
                                <a href="{{ route('fronend.help.index') }}@if(!empty($_GET['ref']))?ref={{ $_GET['ref'] }}@endif" class="float-left top-link-a link-help" >
                                    บริการช่วยเหลือ
                                </a>
                            </li>
                            @if(Auth::user()->level != 6)
                            <li>
                                <a href="{{ route('home') }}@if(!empty($_GET['ref']))?ref={{ $_GET['ref'] }}@endif" class="float-left top-link-a">
                                    จัดการหลังบ้าน
                                </a>
                            </li>
                            @endif
                        @else
                            @if($quotationSetting == 1)
                                <li>
                                    <a class="float-left top-link-a" href="{{ route('fronend.quotation') }}@if(!empty($_GET['ref']))?ref={{ $_GET['ref'] }}@endif">
                                        <button class="btn-quotation-tob-bar link-quotation-topbar">ขอใบเสนอราคา</button>
                                    </a>
                                </li>
                            @endif
                            <li>
                                <a class="float-left top-link-a link-register" href="{{ route('register') }}@if(!empty($_GET['ref']))?ref={{ $_GET['ref'] }}@endif">
                                    สมัครสมาชิกใหม่
                                </a>
                            </li>
                            <li>
                                <a class="float-left top-link-a link-login" href="{{ route('login') }}">
                                    เข้าสู่ระบบ
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('fronend.help.index') }}@if(!empty($_GET['ref']))?ref={{ $_GET['ref'] }}@endif" class="float-left top-link-a link-help">
                                    บริการช่วยเหลือ
                                </a>
                            </li>
                        @endauth
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
