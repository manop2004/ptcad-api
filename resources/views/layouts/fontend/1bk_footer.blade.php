@php
    $footer = App\Models\TbSetting::first();
    $pageMaps = App\Models\TbPagesMap::first();
@endphp
<footer id="footer" >
    <div class="container hidden-md hidden-sm hidden-xs">
        <div class="footer-widgets-wrap clearfix nobottompadding">
            <div class="col_two_fifth">
                @if(!empty($footer->setting_logoWeb)) <img width="200" height="100" src="{{ asset('storage/setting/' . $footer->setting_logoWeb) }}" alt="logo" /> @endif
                @if(!empty($footer->setting_detail))<p>{{ $footer->setting_detail }}</p>@endif
            </div>
            <div class="col_three_fifth col_last">
                <div class="col_one_third">
                    <h4>เกี่ยวกับเรา</h4>
                    <ul class="ul-footer">
                        @if (!empty($pageMaps->page_about))
                        <li>
                            @php
                                $p_about = App\Models\TbPage::select('id','page_show','page_parmalink','pages_type')->where('page_show',1)->findOrFail($pageMaps->page_about);
                            @endphp
                            @if (!empty($p_about))
                            <a href="@if($p_about->pages_type == 1){{ route('fronend.page.content',$p_about->page_parmalink) }}@else{{$p_about->page_parmalink}}@endif">เกี่ยวกับแปดบาท ออนไลน์</a>
                            @endif
                        </li>
                        @endif
                        @if (!empty($pageMaps->page_privacy_policy))
                        <li>
                            @php
                                $p_privacy_policy = App\Models\TbPage::select('id','page_show','page_parmalink','pages_type')->where('page_show',1)->findOrFail($pageMaps->page_privacy_policy);
                            @endphp
                            @if (!empty($p_privacy_policy))
                            <a href="@if($p_privacy_policy->pages_type == 1){{ route('fronend.page.content',$p_privacy_policy->page_parmalink) }}@else{{$p_privacy_policy->page_parmalink}}@endif">นโยบายความเป็นส่วนตัว</a>
                            @endif
                        </li>
                        @endif
                        @if (!empty($pageMaps->page_business_policy))
                        <li>
                            @php
                                $p_business_policy = App\Models\TbPage::select('id','page_show','page_parmalink','pages_type')->where('page_show',1)->findOrFail($pageMaps->page_business_policy);
                            @endphp
                            @if (!empty($p_business_policy))
                            <a href="@if($p_business_policy->pages_type == 1){{ route('fronend.page.content',$p_business_policy->page_parmalink) }}@else{{$p_business_policy->page_parmalink}}@endif">นโยบายทางธุรกิจ</a>
                            @endif
                        </li>
                        @endif
                        @if (!empty($pageMaps->page_refund_policy))
                        <li>
                            @php
                                $p_refund_policy = App\Models\TbPage::select('id','page_show','page_parmalink','pages_type')->where('page_show',1)->findOrFail($pageMaps->page_refund_policy);
                            @endphp
                            @if (!empty($p_refund_policy))
                            <a href="@if($p_refund_policy->pages_type == 1){{ route('fronend.page.content',$p_refund_policy->page_parmalink) }}@else{{$p_refund_policy->page_parmalink}}@endif">นโยบายการคืนสินค้า</a>
                            @endif
                        </li>
                        @endif
                        @if (!empty($pageMaps->page_return_policy))
                        <li>
                            @php
                                $p_return_policy = App\Models\TbPage::select('id','page_show','page_parmalink','pages_type')->where('page_show',1)->findOrFail($pageMaps->page_return_policy);
                            @endphp
                            @if (!empty($p_return_policy))
                            <a href="@if($p_return_policy->pages_type == 1){{ route('fronend.page.content',$p_return_policy->page_parmalink) }}@else{{$p_return_policy->page_parmalink}}@endif">นโยบายการคืนเงิน</a>
                            @endif
                        </li>
                        @endif
                        @if (!empty($pageMaps->page_warranty_policy))
                        <li>
                            @php
                                $p_warranty_policy = App\Models\TbPage::select('id','page_show','page_parmalink','pages_type')->where('page_show',1)->findOrFail($pageMaps->page_warranty_policy);
                            @endphp
                            @if (!empty($p_warranty_policy))
                            <a href="@if($p_warranty_policy->pages_type == 1){{ route('fronend.page.content',$p_warranty_policy->page_parmalink) }}@else{{$p_warranty_policy->page_parmalink}}@endif">นโยบายการรับประกันสินค้า</a>
                            @endif
                        </li>
                        @endif
                    </ul>
                </div>
                <div class="col_one_third">
                    <h4>บริการลูกค้า</h4>
                    <ul class="ul-footer">
                        @if (!empty($pageMaps->page_membership))
                        <li>
                            @php
                                $p_page_membership = App\Models\TbPage::select('id','page_show','page_parmalink','pages_type')->where('page_show',1)->findOrFail($pageMaps->page_membership);
                            @endphp
                            @if (!empty($p_page_membership))
                            <a href="@if($p_page_membership->pages_type == 1){{ route('fronend.page.content',$p_page_membership->page_parmalink) }}@else{{$p_page_membership->page_parmalink}}@endif">สิทธิประโยชน์ของสมาชิก</a>
                            @endif
                        </li>
                        @endif
                        @if (!empty($pageMaps->pages_check_delivery))
                        <li>
                            @php
                                $p_check_delivery = App\Models\TbPage::select('id','page_show','page_parmalink','pages_type')->where('page_show',1)->findOrFail($pageMaps->pages_check_delivery);
                            @endphp
                            @if (!empty($p_check_delivery))
                            <a href="@if($p_check_delivery->pages_type == 1){{ route('fronend.page.content',$p_check_delivery->page_parmalink) }}@else{{$p_check_delivery->page_parmalink}}@endif">ตรวจสอบสถานะจัดส่ง</a>
                            @endif
                        </li>
                        @endif
                        @if (!empty($pageMaps->page_howto_register))
                        <li>
                            @php
                                $p_howto_register = App\Models\TbPage::select('id','page_show','page_parmalink','pages_type')->where('page_show',1)->findOrFail($pageMaps->page_howto_register);
                            @endphp
                            @if (!empty($p_howto_register))
                            <a href="@if($p_howto_register->pages_type == 1){{ route('fronend.page.content',$p_howto_register->page_parmalink) }}@else{{$p_howto_register->page_parmalink}}@endif">วิธีการสมัครสมาชิก</a>
                            @endif
                        </li>
                        @endif
                        @if (!empty($pageMaps->page_howto_shopping))
                        <li>
                            @php
                                $p_howto_shopping = App\Models\TbPage::select('id','page_show','page_parmalink','pages_type')->where('page_show',1)->findOrFail($pageMaps->page_howto_shopping);
                            @endphp
                            @if (!empty($p_howto_shopping))
                            <a href="@if($p_howto_shopping->pages_type == 1){{ route('fronend.page.content',$p_howto_shopping->page_parmalink) }}@else{{$p_howto_shopping->page_parmalink}}@endif">วิธีการสั่งซื้อสินค้า</a>
                            @endif
                        </li>
                        @endif
                        @if (!empty($pageMaps->pages_contact_support))
                        <li>
                            @php
                                $p_contact_support = App\Models\TbPage::select('id','page_show','page_parmalink','pages_type')->where('page_show',1)->findOrFail($pageMaps->pages_contact_support);
                            @endphp
                            @if (!empty($p_contact_support))
                            <a href="@if($p_contact_support->pages_type == 1){{ route('fronend.page.content',$p_contact_support->page_parmalink) }}@else{{$p_contact_support->page_parmalink}}@endif">ติดต่อทีมงานซัพพอร์ต</a>
                            @endif
                        </li>
                        @endif
                        @if (!empty($pageMaps->pages_payment))
                        <li>
                            @php
                                $p_payment = App\Models\TbPage::select('id','page_show','page_parmalink','pages_type')->where('page_show',1)->findOrFail($pageMaps->pages_payment);
                            @endphp
                            @if (!empty($p_payment))
                            <a href="@if($p_payment->pages_type == 1){{ route('fronend.page.content',$p_payment->page_parmalink) }}@else{{$p_payment->page_parmalink}}@endif">ช่องทางการชำระเงิน/แจ้งชำระเงิน</a>
                            @endif
                        </li>
                        @endif
                        <li><a href="{{ route('fronend.article.main') }}">ข่าวสารด้านซอฟต์แวร์</a></li>
                    </ul>
                </div>
                <div class="col_one_third col_last">
                    <h4>ข้อมูลติดต่อ</h4>
                    @if(!empty($footer->setting_address))<p>{{ $footer->setting_address }}</p>@endif
                    <h5>เวลาทำการ</h5>
                    @if(!empty($footer->setting_detail))<small>สำนักงานใหญ่ : {{ $footer->setting_companyTime}}</small><br/>@endif
                    @if(!empty($footer->setting_detail))<small>ช่องทางออนไลน์ : {{ $footer->setting_websiteTime}}</small><br/>@endif
                    @if(!empty($footer->setting_telContact))<small>เบอร์โทร : <a href="tel:{{ $footer->setting_telContact}}">{{ $footer->setting_telContact}}</a>, @if(!empty($setting->setting_hotlineContact)) <a href="tel:{{ $setting->setting_hotlineContact}}">{{ $setting->setting_hotlineContact}}</a> @endif</small>@endif
                </div>
            </div>
        </div>
    </div>
    <div class="container hidden-lg">
        <div class="footer-widgets-wrap clearfix nobottompadding">
            <div class="accordion accordion-border nobottommargin clearfix" data-state="closed">

                <div class="acctitle"><i class="acc-closed icon-angle-down"></i><i class="acc-open icon-angle-up"></i>เกี่ยวกับเรา</div>
                <div class="acc_content clearfix">
                    <ul class="ul-footer nobottommargin">
                        @if (!empty($pageMaps->page_about))
                        <li>
                            @php
                                $p_about = App\Models\TbPage::select('id','page_show','page_parmalink','pages_type')->where('page_show',1)->findOrFail($pageMaps->page_about);
                            @endphp
                            @if (!empty($p_about))
                            <a href="@if($p_about->pages_type == 1){{ route('fronend.page.content',$p_about->page_parmalink) }}@else{{$p_about->page_parmalink}}@endif">เกี่ยวกับแปดบาท ออนไลน์</a>
                            @endif
                        </li>
                        @endif
                        @if (!empty($pageMaps->page_privacy_policy))
                        <li>
                            @php
                                $p_privacy_policy = App\Models\TbPage::select('id','page_show','page_parmalink','pages_type')->where('page_show',1)->findOrFail($pageMaps->page_privacy_policy);
                            @endphp
                            @if (!empty($p_privacy_policy))
                            <a href="@if($p_privacy_policy->pages_type == 1){{ route('fronend.page.content',$p_privacy_policy->page_parmalink) }}@else{{$p_privacy_policy->page_parmalink}}@endif">นโยบายความเป็นส่วนตัว</a>
                            @endif
                        </li>
                        @endif
                        @if (!empty($pageMaps->page_business_policy))
                        <li>
                            @php
                                $p_business_policy = App\Models\TbPage::select('id','page_show','page_parmalink','pages_type')->where('page_show',1)->findOrFail($pageMaps->page_business_policy);
                            @endphp
                            @if (!empty($p_business_policy))
                            <a href="@if($p_business_policy->pages_type == 1){{ route('fronend.page.content',$p_business_policy->page_parmalink) }}@else{{$p_business_policy->page_parmalink}}@endif">นโยบายทางธุรกิจ</a>
                            @endif
                        </li>
                        @endif
                        @if (!empty($pageMaps->page_refund_policy))
                        <li>
                            @php
                                $p_refund_policy = App\Models\TbPage::select('id','page_show','page_parmalink','pages_type')->where('page_show',1)->findOrFail($pageMaps->page_refund_policy);
                            @endphp
                            @if (!empty($p_refund_policy))
                            <a href="@if($p_refund_policy->pages_type == 1){{ route('fronend.page.content',$p_refund_policy->page_parmalink) }}@else{{$p_refund_policy->page_parmalink}}@endif">นโยบายการคืนสินค้า</a>
                            @endif
                        </li>
                        @endif
                        @if (!empty($pageMaps->page_return_policy))
                        <li>
                            @php
                                $p_return_policy = App\Models\TbPage::select('id','page_show','page_parmalink','pages_type')->where('page_show',1)->findOrFail($pageMaps->page_return_policy);
                            @endphp
                            @if (!empty($p_return_policy))
                            <a href="@if($p_return_policy->pages_type == 1){{ route('fronend.page.content',$p_return_policy->page_parmalink) }}@else{{$p_return_policy->page_parmalink}}@endif">นโยบายการคืนเงิน</a>
                            @endif
                        </li>
                        @endif
                        @if (!empty($pageMaps->page_warranty_policy))
                        <li>
                            @php
                                $p_warranty_policy = App\Models\TbPage::select('id','page_show','page_parmalink','pages_type')->where('page_show',1)->findOrFail($pageMaps->page_warranty_policy);
                            @endphp
                            @if (!empty($p_warranty_policy))
                            <a href="@if($p_warranty_policy->pages_type == 1){{ route('fronend.page.content',$p_warranty_policy->page_parmalink) }}@else{{$p_warranty_policy->page_parmalink}}@endif">นโยบายการรับประกันสินค้า</a>
                            @endif
                        </li>
                        @endif
                    </ul>
                </div>

                <div class="acctitle"><i class="acc-closed icon-angle-down"></i><i class="acc-open icon-angle-up"></i>บริการลูกค้า</div>
                <div class="acc_content clearfix">
                    <ul class="ul-footer nobottommargin">
                        @if (!empty($pageMaps->page_membership))
                        <li>
                            @php
                                $p_page_membership = App\Models\TbPage::select('id','page_show','page_parmalink','pages_type')->where('page_show',1)->findOrFail($pageMaps->page_membership);
                            @endphp
                            @if (!empty($p_page_membership))
                            <a href="@if($p_page_membership->pages_type == 1){{ route('fronend.page.content',$p_page_membership->page_parmalink) }}@else{{$p_page_membership->page_parmalink}}@endif">สิทธิประโยชน์ของสมาชิก</a>
                            @endif
                        </li>
                        @endif
                        @if (!empty($pageMaps->pages_check_delivery))
                        <li>
                            @php
                                $p_check_delivery = App\Models\TbPage::select('id','page_show','page_parmalink','pages_type')->where('page_show',1)->findOrFail($pageMaps->pages_check_delivery);
                            @endphp
                            @if (!empty($p_check_delivery))
                            <a href="@if($p_check_delivery->pages_type == 1){{ route('fronend.page.content',$p_check_delivery->page_parmalink) }}@else{{$p_check_delivery->page_parmalink}}@endif">ตรวจสอบสถานะจัดส่ง</a>
                            @endif
                        </li>
                        @endif
                        @if (!empty($pageMaps->page_howto_register))
                        <li>
                            @php
                                $p_howto_register = App\Models\TbPage::select('id','page_show','page_parmalink','pages_type')->where('page_show',1)->findOrFail($pageMaps->page_howto_register);
                            @endphp
                            @if (!empty($p_howto_register))
                            <a href="@if($p_howto_register->pages_type == 1){{ route('fronend.page.content',$p_howto_register->page_parmalink) }}@else{{$p_howto_register->page_parmalink}}@endif">วิธีการสมัครสมาชิก</a>
                            @endif
                        </li>
                        @endif
                        @if (!empty($pageMaps->page_howto_shopping))
                        <li>
                            @php
                                $p_howto_shopping = App\Models\TbPage::select('id','page_show','page_parmalink','pages_type')->where('page_show',1)->findOrFail($pageMaps->page_howto_shopping);
                            @endphp
                            @if (!empty($p_howto_shopping))
                            <a href="@if($p_howto_shopping->pages_type == 1){{ route('fronend.page.content',$p_howto_shopping->page_parmalink) }}@else{{$p_howto_shopping->page_parmalink}}@endif">วิธีการสั่งซื้อสินค้า</a>
                            @endif
                        </li>
                        @endif
                        @if (!empty($pageMaps->pages_contact_support))
                        <li>
                            @php
                                $p_contact_support = App\Models\TbPage::select('id','page_show','page_parmalink','pages_type')->where('page_show',1)->findOrFail($pageMaps->pages_contact_support);
                            @endphp
                            @if (!empty($p_contact_support))
                            <a href="@if($p_contact_support->pages_type == 1){{ route('fronend.page.content',$p_contact_support->page_parmalink) }}@else{{$p_contact_support->page_parmalink}}@endif">ติดต่อทีมงานซัพพอร์ต</a>
                            @endif
                        </li>
                        @endif
                        @if (!empty($pageMaps->pages_payment))
                        <li>
                            @php
                                $p_payment = App\Models\TbPage::select('id','page_show','page_parmalink','pages_type')->where('page_show',1)->findOrFail($pageMaps->pages_payment);
                            @endphp
                            @if (!empty($p_payment))
                            <a href="@if($p_payment->pages_type == 1){{ route('fronend.page.content',$p_payment->page_parmalink) }}@else{{$p_payment->page_parmalink}}@endif">ช่องทางการชำระเงิน/แจ้งชำระเงิน</a>
                            @endif
                        </li>
                        @endif
                        <li><a href="{{ route('fronend.article.main') }}">ข่าวสารด้านซอฟต์แวร์</a></li>
                    </ul>
                </div>

                <div class="acctitle"><i class="acc-closed icon-angle-down"></i><i class="acc-open icon-angle-up"></i>ข้อมูลติดต่อ</div>
                <div class="acc_content clearfix">
                    @if(!empty($footer->setting_address))<p>{{ $footer->setting_address }}</p>@endif
                    <h5>เวลาทำการ</h5>
                    @if(!empty($footer->setting_detail))<small>สำนักงานใหญ่ : {{ $footer->setting_companyTime}}</small><br/>@endif
                    @if(!empty($footer->setting_detail))<small>ช่องทางออนไลน์ : {{ $footer->setting_websiteTime}}</small><br/>@endif
                    @if(!empty($footer->setting_telContact))<small>เบอร์โทร : <a href="tel:{{ $footer->setting_telContact}}">{{ $footer->setting_telContact}}</a>, @if(!empty($setting->setting_hotlineContact)) <a href="tel:{{ $setting->setting_hotlineContact}}">{{ $setting->setting_hotlineContact}}</a> @endif</small>@endif
                </div>

            </div>
        </div>
    </div>
    <div class="container bottommargin-sm">
        <div class="clearfix">
            <div class="grid-footer-seca">
                <div class="grid-social">
                    @if(!empty($footer->setting_LinkFacebook))
                    <a href="{{$footer->setting_LinkFacebook}}" target="_bank">
                        <img src="{{ asset('icon/social/social-facebook.webp') }}" class="mgr-5 icon-xs lazyload" width="40" height="40" alt="facebook" />
                    </a>
                    @endif
                    @if(!empty($footer->setting_LinkFacebook))
                    <a href="https://m.me/{{ str_replace('https://www.facebook.com/', '', $footer->setting_LinkFacebook) }}">
                        <img src="{{ asset('icon/social/social-massage.webp') }}" class="mgr-5 icon-xs lazyload" width="40" height="40" alt="massage" />
                    </a>
                    @endif
                    @if(!empty($footer->setting_LinkTwitter))
                    <a href="{{$footer->setting_LinkTwitter}}" target="_bank">
                        <img src="{{ asset('icon/social/social-twitter.webp') }}" class="mgr-5 icon-xs lazyload" width="40" height="40" alt="twitter" />
                    </a>
                    @endif
                    @if(!empty($footer->setting_LinkYoutube))
                    <a href="{{$footer->setting_LinkYoutube}}" target="_bank">
                        <img src="{{ asset('icon/social/social-youtube.webp') }}" class="mgr-5 icon-xs lazyload" width="40" height="40" alt="youtube" />
                    </a>
                    @endif
                    @if(!empty($footer->setting_LinkInstagram))
                    <a href="{{$footer->setting_LinkInstagram}}" target="_bank">
                        <img src="{{ asset('icon/social/social-instagram.webp') }}" class="mgr-5 icon-xs lazyload" width="40" height="40" alt="instagram" />
                    </a>
                    @endif
                    @if(!empty($footer->setting_idLine))
                    <a href="{{$footer->setting_idLine}}" target="_bank" >
                        <img src="{{ asset('icon/social/social-line-2.webp') }}" class="mgr-5 icon-xs lazyload" width="40" height="40" alt="line" />
                    </a>
                    @endif
                </div>
                <div class="grid-footer-bank">
                    <img src="{{ asset('icon/payment/business-visa.webp') }}" class="footer-img lazyload" width="69" height="47" alt="visa" />
                    <img src="{{ asset('icon/payment/business-mastercard.webp') }}" class="footer-img lazyload" width="69" height="47" alt="mastercard" />
                    <img src="{{ asset('icon/payment/business-payment-bank.webp') }}" class="footer-img lazyload" width="69" height="47" alt="bank" />
                </div>
				<?php
				/*
                @if(!empty($footer->setting_DBD))
                    <div class="center">
                        {!! $footer->setting_DBD !!}
                        <br/><small>ธุรกิจที่ได้รับความไว้วางใจ<br/>มีการจดทะเบียนนิติบุคคล</small>
                    </div>
                @endif
				*/
				?>
                @if(!empty($footer->setting_ssl))
                    @if($footer->setting_ssl == 1)
                    <div class="grid-ssl">
                        <div>
                            <img src="{{ asset('icon/others/ssl.webp') }}" class="footer-img-ssl lazyload" width="50" height="50" alt="ssl" />
                        </div>
                        <div>
                            <small>ใช้งานอย่างปลอดภัย <br/>ได้รับการยืนยันจาก Google</small>
                        </div>
                    </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
    <div id="copyrights">
        <div class="col_full clearfix nobottommargin">
            <small>© สงวนลิขสิทธิ์ {{ date('Y') }} | แปดบาทดอทคอม</small>
        </div>
    </div>
</footer>
