@php
    $quotationSetting = App\Models\TbQuotationSetting::value('show');
@endphp
<div class="bg-filter-menu"></div>
<div class="head-home">
	<div class="d-f-txttel">
		<img class="icon-head" src="/assets/fontend/hax_theme/images/icon-phone.webp">
		<div class="txt-phone">โทร <a href="tel:0958857585">095-885-7585</a> </div>
	</div>
	<div class="line-head"></div>
	<!--div class="d-f-txtcounty">
		<img class="icon-head" src="/assets/fontend/hax_theme/images/icon-world.webp">
		<div class="txt-county">ไทย</div>
		<img class="icon-arrow-head" src="/assets/fontend/hax_theme/images/icon-arrow-down-green.webp">
	</div>
	<div class="line-head"></div-->
	<div class="txt-help">
		<a href="mailto:contact@pt-cad.com">
			📧 contact@pt-cad.com
		</a>
	</div>
	<!--div class="txt-contact">
		<a href="{{ route('fronend.quotation') }}@if(!empty($_GET['ref']))?ref={{ $_GET['ref'] }}@endif">
			ขอใบเสนอราคา
		</a>
	</div-->
	@if (Route::has('login'))
    @auth
        @if(Auth::user()->level != 6)
    <div class="txt-contact">
    <a href="{{ route('home') }}" style="display:inline-flex;align-items:center;gap:5px;">
        จัดการหลังบ้าน
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="3"></circle>
            <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
        </svg>
    </a>
</div>
        @endif
    @else
    <div class="txt-contact">
        <a href="{{ route('login') }}">
            Login
        </a>
    </div>
    @endauth
@endif
</div>