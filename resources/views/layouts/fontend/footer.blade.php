@php
    $footer = App\Models\TbSetting::first();
    $pageMaps = App\Models\TbPagesMap::first();
@endphp
<footer class="pt-footer">
    <div class="pt-footer-brand">
        <div class="pt-footer-logo">
    @if(!empty($footer->setting_logoWeb))
        <img src="{{ asset('storage/setting/'.$footer->setting_logoWeb) }}" alt="{{ $footer->setting_nameWeb }}" class="pt-footer-logo-img">
    @else
        <img src="/assets/fontend/hax_theme/images/logo-footer.webp" alt="" class="pt-footer-logo-img">
    @endif
</div>
        <p class="pt-footer-desc">รวมลิงก์สำคัญของ PTCAD สำหรับผลิตภัณฑ์ แหล่งความรู้ และช่องทางติดตามข่าวสารไว้ในส่วนท้ายของหน้าอย่างเป็นระเบียบ</p>

        <p class="pt-footer-title">ศูนย์บริการลูกค้า</p>
        <p class="pt-footer-text"><i data-lucide="clock" size="15"></i> ออนไลน์ @if(!empty($footer->setting_websiteTime)){{ $footer->setting_websiteTime }}@else วันจันทร์ - วันศุกร์ : 09.00 - 17.00 น.@endif</p>
        <p class="pt-footer-text"><i data-lucide="phone" size="15"></i> โทรศัพท์ : 095-885-7585, @if(!empty($footer->setting_companyTime)){{ $footer->setting_companyTime }}@else 09.00 - 17.00 น.@endif</p>
        <p class="pt-footer-text">
            <i data-lucide="mail" size="15"></i> อีเมล :
            @if(!empty($footer->setting_email_bcc))
                {{ $footer->setting_email_bcc }}
            @endif
        </p>

        <div class="pt-footer-social">
            @if(!empty($footer->setting_LinkFacebook))
            <a href="{{ $footer->setting_LinkFacebook }}" target="_blank"><img src="/assets/fontend/hax_theme/images/facebook-g.webp" class="pt-footer-social-icon"></a>
            <a href="https://m.me/{{ str_replace('https://www.facebook.com/', '', $footer->setting_LinkFacebook) }}" target="_blank"><img src="/assets/fontend/hax_theme/images/mss-g.webp" class="pt-footer-social-icon"></a>
            @endif
            @if(!empty($footer->setting_LinkInstagram))
            <a href="{{ $footer->setting_LinkInstagram }}" target="_blank"><img src="/assets/fontend/hax_theme/images/ig-g.webp" class="pt-footer-social-icon"></a>
            @endif
            @if(!empty($footer->setting_LinkYoutube))
            <a href="{{ $footer->setting_LinkYoutube }}" target="_blank"><img src="/assets/fontend/hax_theme/images/youtube-g.webp" class="pt-footer-social-icon"></a>
            @endif
            @if(!empty($footer->setting_idLine))
            <a href="{{ $footer->setting_idLine }}" target="_blank"><img src="/assets/fontend/hax_theme/images/line-g.webp" class="pt-footer-social-icon"></a>
            @endif
        </div>
    </div>

    <div class="pt-footer-col">
        <h4>เกี่ยวกับเรา</h4>
        @if (!empty($pageMaps->page_about))
            @php $p_about = App\Models\TbPage::select('id','page_show','page_parmalink','pages_type')->where('page_show',1)->findOrFail($pageMaps->page_about); @endphp
            @if (!empty($p_about))
            <a href="@if($p_about->pages_type == 1){{ route('fronend.page.content',$p_about->page_parmalink) }}@else{{ $p_about->page_parmalink }}@endif"><p class="pt-footer-text">เกี่ยวกับ PTCAD</p></a>
            @endif
        @endif
        @if (!empty($pageMaps->page_privacy_policy))
            @php $p_privacy_policy = App\Models\TbPage::select('id','page_show','page_parmalink','pages_type')->where('page_show',1)->findOrFail($pageMaps->page_privacy_policy); @endphp
            @if (!empty($p_privacy_policy))
            <a href="@if($p_privacy_policy->pages_type == 1){{ route('fronend.page.content',$p_privacy_policy->page_parmalink) }}@else{{ $p_privacy_policy->page_parmalink }}@endif"><p class="pt-footer-text">นโยบายความเป็นส่วนตัว</p></a>
            @endif
        @endif
        @if (!empty($pageMaps->page_business_policy))
            @php $p_business_policy = App\Models\TbPage::select('id','page_show','page_parmalink','pages_type')->where('page_show',1)->findOrFail($pageMaps->page_business_policy); @endphp
            @if (!empty($p_business_policy))
            <a href="@if($p_business_policy->pages_type == 1){{ route('fronend.page.content',$p_business_policy->page_parmalink) }}@else{{ $p_business_policy->page_parmalink }}@endif"><p class="pt-footer-text">นโยบายทางธุรกิจ</p></a>
            @endif
        @endif
        @if (!empty($pageMaps->page_refund_policy))
            @php $p_refund_policy = App\Models\TbPage::select('id','page_show','page_parmalink','pages_type')->where('page_show',1)->findOrFail($pageMaps->page_refund_policy); @endphp
            @if (!empty($p_refund_policy))
            <a href="@if($p_refund_policy->pages_type == 1){{ route('fronend.page.content',$p_refund_policy->page_parmalink) }}@else{{ $p_refund_policy->page_parmalink }}@endif"><p class="pt-footer-text">นโยบายการคืนสินค้า</p></a>
            @endif
        @endif
        @if (!empty($pageMaps->page_warranty_policy))
            @php $p_warranty_policy = App\Models\TbPage::select('id','page_show','page_parmalink','pages_type')->where('page_show',1)->findOrFail($pageMaps->page_warranty_policy); @endphp
            @if (!empty($p_warranty_policy))
            <a href="@if($p_warranty_policy->pages_type == 1){{ route('fronend.page.content',$p_warranty_policy->page_parmalink) }}@else{{ $p_warranty_policy->page_parmalink }}@endif"><p class="pt-footer-text">นโยบายการรับประกันสินค้า</p></a>
            @endif
        @endif
    </div>

    <div class="pt-footer-col">
        <h4>บริการลูกค้า</h4>
        @if (!empty($pageMaps->page_membership))
            @php $p_page_membership = App\Models\TbPage::select('id','page_show','page_parmalink','pages_type')->where('page_show',1)->findOrFail($pageMaps->page_membership); @endphp
            @if (!empty($p_page_membership))
            <a href="@if($p_page_membership->pages_type == 1){{ route('fronend.page.content',$p_page_membership->page_parmalink) }}@else{{ $p_page_membership->page_parmalink }}@endif"><p class="pt-footer-text">สิทธิประโยชน์ของสมาชิก</p></a>
            @endif
        @endif
        @if (!empty($pageMaps->pages_check_delivery))
            @php $p_check_delivery = App\Models\TbPage::select('id','page_show','page_parmalink','pages_type')->where('page_show',1)->findOrFail($pageMaps->pages_check_delivery); @endphp
            @if (!empty($p_check_delivery))
            <a href="@if($p_check_delivery->pages_type == 1){{ route('fronend.page.content',$p_check_delivery->page_parmalink) }}@else{{ $p_check_delivery->page_parmalink }}@endif"><p class="pt-footer-text">ตรวจสอบสถานะจัดส่ง</p></a>
            @endif
        @endif
        @if (!empty($pageMaps->page_howto_register))
            @php $p_howto_register = App\Models\TbPage::select('id','page_show','page_parmalink','pages_type')->where('page_show',1)->findOrFail($pageMaps->page_howto_register); @endphp
            @if (!empty($p_howto_register))
            <a href="@if($p_howto_register->pages_type == 1){{ route('fronend.page.content',$p_howto_register->page_parmalink) }}@else{{ $p_howto_register->page_parmalink }}@endif"><p class="pt-footer-text">วิธีการสมัครสมาชิก</p></a>
            @endif
        @endif
        @if (!empty($pageMaps->page_howto_shopping))
            @php $p_howto_shopping = App\Models\TbPage::select('id','page_show','page_parmalink','pages_type')->where('page_show',1)->findOrFail($pageMaps->page_howto_shopping); @endphp
            @if (!empty($p_howto_shopping))
            <a href="@if($p_howto_shopping->pages_type == 1){{ route('fronend.page.content',$p_howto_shopping->page_parmalink) }}@else{{ $p_howto_shopping->page_parmalink }}@endif"><p class="pt-footer-text">วิธีการสั่งซื้อสินค้า</p></a>
            @endif
        @endif
        @if (!empty($pageMaps->pages_contact_support))
            @php $p_contact_support = App\Models\TbPage::select('id','page_show','page_parmalink','pages_type')->where('page_show',1)->findOrFail($pageMaps->pages_contact_support); @endphp
            @if (!empty($p_contact_support))
            <a href="@if($p_contact_support->pages_type == 1){{ route('fronend.page.content',$p_contact_support->page_parmalink) }}@else{{ $p_contact_support->page_parmalink }}@endif"><p class="pt-footer-text">ติดต่อทีมงานซัพพอร์ต</p></a>
            @endif
        @endif
        @if (!empty($pageMaps->pages_payment))
            @php $p_payment = App\Models\TbPage::select('id','page_show','page_parmalink','pages_type')->where('page_show',1)->findOrFail($pageMaps->pages_payment); @endphp
            @if (!empty($p_payment))
            <a href="@if($p_payment->pages_type == 1){{ route('fronend.page.content',$p_payment->page_parmalink) }}@else{{ $p_payment->page_parmalink }}@endif"><p class="pt-footer-text">ช่องทางการชำระเงิน/แจ้งชำระเงิน</p></a>
            @endif
        @endif
        <a href="{{ route('fronend.article.main') }}"><p class="pt-footer-text">ข่าวสารด้านซอฟต์แวร์</p></a>
    </div>

    {{-- [เพิ่มใหม่] คอลัมน์ที่ 4: แหล่งความรู้ — ยังไม่มีลิงก์จริง รอกำหนดทีหลัง --}}
    <div class="pt-footer-col">
    <h4>แหล่งความรู้</h4>
    <a href="{{ route('fronend.help.index') }}"><p class="pt-footer-text">คำถามที่ถูกถามบ่อย</p></a>
    <a href="{{ route('fronend.tutorial.main') }}"><p class="pt-footer-text">คู่มือการติดตั้ง</p></a>
    <a href="{{ route('fronend.article.main') }}"><p class="pt-footer-text">บทความ</p></a>
    <a href="{{ route('fronend.tutorial.main') }}"><p class="pt-footer-text">สัมมนาออนไลน์</p></a>
</div>
</footer>

{{-- แถว Privacy Policy | Term of Service — อยู่นอก footer เป็นแถวเต็มความกว้าง ไม่ลอยปนกับคอลัมน์ --}}
<div class="pt-footer-policy-links" style="width:100%; text-align:center; padding: 20px 0; color:#8a94a6; background:#102B76;">
    @php
        $privacyLink = '#';
        if (!empty($pageMaps->page_privacy_policy)) {
            $p_privacy = App\Models\TbPage::where('id', $pageMaps->page_privacy_policy)->where('page_show',1)->first();
            if (!empty($p_privacy)) {
                $privacyLink = ($p_privacy->pages_type == 1) ? route('fronend.page.content', $p_privacy->page_parmalink) : $p_privacy->page_parmalink;
            }
        }
    @endphp
    <a href="{{ $privacyLink }}" style="color:#8a94a6; text-decoration:none;">Privacy Policy</a>
    &nbsp;&nbsp;|&nbsp;&nbsp;
    <a href="{{ route('fronend.page.content', 'terms-and-conditions') }}" style="color:#8a94a6; text-decoration:none;">Term of Service</a>
</div>

<div class="pt-footer-copyright">
    © 2023 · PTCAD · All rights reserved
</div>

<div id="popup_cart" class="relative"></div>

<div class="modal fade" id="ModalPage" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div id="Modal_Body" class="modal-body"></div>
        </div>
    </div>
</div>