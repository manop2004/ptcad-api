<header id="header">

    <div id="header-wrap">

        <div class="container clearfix">

            <div id="primary-menu-trigger"><i class="icon-reorder"></i></div>

            <div id="logo">
                <a href="{{ route('onepage.extraxion.index') }}" class="standard-logo" data-dark-logo="@if(!empty($setting->setting_logoWeb)){{ asset('storage/setting/'.$setting->setting_logoWeb) }}@endif"><img src="@if(!empty($setting->setting_logoWeb)){{ asset('storage/setting/'.$setting->setting_logoWeb) }}@endif" alt="@if(!empty($setting->setting_nameWeb)){{ $setting->setting_nameWeb }}@endif"></a>
                <a href="{{ route('onepage.extraxion.index') }}" class="retina-logo" data-dark-logo="@if(!empty($setting->setting_logoWeb)){{ asset('storage/setting/'.$setting->setting_logoWeb) }}@endif"><img src="@if(!empty($setting->setting_logoWeb)){{ asset('storage/setting/'.$setting->setting_logoWeb) }}@endif" alt="@if(!empty($setting->setting_nameWeb)){{ $setting->setting_nameWeb }}@endif"></a>
            </div>

            <nav id="primary-menu" class="style-2">

                <ul class="one-page-menu">
                    <li><a href="#" class="co-0391df">โปรแกรมประมาณราคา แม่นยำ รวดเร็ว รองรับไฟล์หลากหลาย</a></li>
                    <li><a href="#" data-href="#block-02">ขอใบเสนอราคา  คลิก <i class="fa fa-sort-desc" aria-hidden="true"></i></li>
                </ul>
                <div class="block-menu-tel">
                    <a href="tel:02-744-9397" class="icon-tel-menu"><img class="full-width" src="{{ asset('onepages/extraxion/images/icons/bxs-phone-call.png') }}" /></a>
                    <div class="content-tel-menu"><div class="hidden-md hidden-sm hidden-xs"><a href="tel:02-744-9397" class="co-737373">ติดต่อฝ่ายบริการลูกค้าโทร: 02-744-9397</a></div></div>
                </div>

            </nav>

        </div>

    </div>

</header>