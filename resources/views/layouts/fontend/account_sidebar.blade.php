<style>
/* Hero Section Styles */
.acct-hero { padding: 16px 8px !important; margin-bottom: 14px !important; }
.acct-hero h1 { font-size: 22px !important; margin: 0 0 2px !important; }
.acct-hero p { font-size: 12px !important; margin: 0 !important; }
.acct-hero-actions { margin: 10px 0 12px !important; }
.acct-hero-btn { height: 38px !important; padding: 0 16px !important; font-size: 13px !important; }
.acct-quick-stats { margin-top: 0 !important; gap: 10px !important; }
.acct-stat { padding: 12px !important; }
.acct-stat i { margin-bottom: 4px !important; }
.acct-stat b { font-size: 18px !important; }

/* Menu Base Styles (Desktop) */
.acct-side a {
    font-weight: 500 !important;
    color: #667085 !important;
    transition: .15s ease;
}
.acct-side a:hover {
    color: #1765ff !important;
}
.acct-side a.active {
    font-weight: 800 !important;
    color: #1765ff !important;
    background: #eef6ff !important;
}
.acct-side a.signout {
    color: #ef4444 !important;
    font-weight: 600 !important;
}
.acct-side a.signout:hover {
    color: #dc2626 !important;
}

/* Mobile Responsive Menu Fix */
@media (max-width: 1000px) {
    .acct-side {
        display: flex !important;
        flex-wrap: nowrap !important;
        overflow-x: auto !important;
        gap: 8px !important;
        padding: 10px !important;
        border-radius: 16px !important;
        position: relative !important;
        top: 0 !important;
        background: #ffffff !important;
        border: 1px solid #e6edf8 !important;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none; /* Hide scrollbar Firefox */
    }
    
    .acct-side::-webkit-scrollbar {
        display: none; /* Hide scrollbar Chrome/Safari */
    }

    .acct-side a {
        flex: 0 0 auto !important;
        white-space: nowrap !important;
        height: 40px !important;
        padding: 0 14px !important;
        font-size: 13px !important;
        border-radius: 10px !important;
        border: 1px solid #e6edf8 !important;
    }

    /* ซ่อนเส้น divider เมื่ออยู่บนมือถือเพื่อไม่ให้ดันขอบขวา */
    .acct-side-divider {
        display: none !important;
    }
}
</style>

<aside class="acct-side">
    <a href="{{ route('fronend.account.menu') }}" class="{{ request()->routeIs('fronend.account.menu') ? 'active' : '' }}"><i data-lucide="layout-dashboard" size="18" style="margin-right:4px"></i> Dashboard</a>
    <a href="{{ route('fronend.account.software') }}" class="{{ request()->routeIs('fronend.account.software') ? 'active' : '' }}"><i data-lucide="box" size="18" style="margin-right:4px"></i> My Products</a>
    <a href="{{ route('fronend.account.menu') }}#learning-center" class="{{ request()->routeIs('fronend.account.menu') ? 'active' : '' }}"><i data-lucide="play-circle" size="18" style="margin-right:4px"></i> Tutorial</a>
    <a href="{{ route('fronend.account.order') }}" class="{{ request()->routeIs('fronend.account.order') || request()->routeIs('fronend.account.order.detail') ? 'active' : '' }}"><i data-lucide="receipt" size="18" style="margin-right:4px"></i> Orders & Invoices</a>
    @php
    $cacheKey = 'has_license_check';
    $cacheTimeKey = 'has_license_check_time';
    $cacheStillFresh = session()->has($cacheKey) && (time() - session($cacheTimeKey, 0)) < 30; // 30วินาที

    if ($cacheStillFresh) {
        $hasLicenseTab = session($cacheKey);
    } else {
        $hasLicenseTab = \App\Models\TbSoftwareNotify::where('userId', Auth::id())->where('show', 1)->exists()
            || \App\Models\LicenseKeyStock::join('tb_order', 'tb_order.id', 'tb_license_key_stock.orderId')
                ->where('tb_order.userCode', Auth::user()->user_code)
                ->where('tb_license_key_stock.status', \App\Models\LicenseKeyStock::STATUS_USED)
                ->exists();

        if (!$hasLicenseTab) {
            try {
                $ptcadService = app(\App\Services\PtcadLicenseService::class);
                $remoteResult = $ptcadService->getLicensesByEmail(Auth::user()->email, (string) Auth::id());
                $hasLicenseTab = !empty($remoteResult['success']) && !empty($remoteResult['data']['licenses']);
            } catch (\Exception $e) {
                $hasLicenseTab = false;
            }
        }

        session([$cacheKey => $hasLicenseTab, $cacheTimeKey => time()]);
    }
@endphp
    @if($hasLicenseTab)
    <a href="{{ route('fronend.account.documents') }}" class="{{ request()->routeIs('fronend.account.documents') ? 'active' : '' }}"><i data-lucide="file-text" size="18" style="margin-right:4px"></i> Document</a>
    @endif
    

    <div class="acct-side-divider" style="height:1px;background:#e6edf8;margin:10px 0"></div>

    <a href="{{ route('fronend.account') }}" class="{{ request()->routeIs('fronend.account') ? 'active' : '' }}"><i data-lucide="user" size="18" style="margin-right:4px"></i> Profile</a>
    <a href="{{ route('fronend.account.changepassword') }}" class="{{ request()->routeIs('fronend.account.changepassword') ? 'active' : '' }}"><i data-lucide="shield" size="18" style="margin-right:4px"></i> change password</a>

    <div class="acct-side-divider" style="height:1px;background:#e6edf8;margin:10px 0"></div>

    <a href="{{ route('fronend.account.coupon') }}" class="{{ request()->routeIs('fronend.account.coupon') ? 'active' : '' }}"><i data-lucide="ticket" size="18" style="margin-right:4px"></i> โค้ดส่วนลดของฉัน</a>
    <a href="{{ route('fronend.account.address') }}" class="{{ request()->routeIs('fronend.account.address') ? 'active' : '' }}"><i data-lucide="map-pin" size="18" style="margin-right:4px"></i> ที่อยู่จัดส่ง</a>
    <a href="{{ route('fronend.account.pdpa') }}" class="{{ request()->routeIs('fronend.account.pdpa') ? 'active' : '' }}"><i data-lucide="mail" size="18" style="margin-right:4px"></i> รับข้อมูลข่าวสาร</a>

    <div class="acct-side-divider" style="height:1px;background:#e6edf8;margin:10px 0"></div>

    <a class="signout" href="{{ route('user.logout') }}"><i data-lucide="log-out" size="18" style="margin-right:4px"></i> Sign Out</a>
</aside>