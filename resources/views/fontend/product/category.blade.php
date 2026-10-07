@extends('layouts.temp_user')

@section('title'){{ $og_title }} |@endsection
@section('og_site_name'){{ $og_site_name }}@endsection
@section('og_keywords'){{ $og_keywords }}@endsection
@section('og_title'){{ $og_title }}@endsection
@section('og_description'){{ $og_description }}@endsection
@section('og_url'){{ $og_url }}@endsection
@section('og_image'){{ $og_image }}@endsection

@section('css')
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Noto+Sans+Thai:wght@400;500;600;700;800&display=swap');

.pt-cat-wrap{
  --navy:#12358f; --blue:#1765ff; --ink:#0b1f4d; --muted:#667085; --line:#e6edf8;
  font-family:'Poppins','Noto Sans Thai',system-ui,sans-serif;
  color:var(--ink);
}
.pt-cat-wrap *{box-sizing:border-box}
.pt-cat-wrap a{text-decoration:none;color:inherit}

.pt-cat-hero{
    background:linear-gradient(180deg,#eaf1ff 0%,#ffffff 100%);
    border-radius:24px;
    padding:40px;
    margin-bottom:32px;
}
.pt-cat-hero-inner{display:grid;grid-template-columns:1.1fr .9fr;gap:32px;align-items:center}
.pt-cat-kicker{color:var(--blue);font-weight:800;font-size:13px;margin-bottom:8px;display:flex;align-items:center;gap:8px}
.pt-cat-title{font-size:28px;font-weight:800;color:var(--navy);margin:0 0 8px}
.pt-cat-desc{color:var(--muted);font-size:14px;max-width:600px;margin:0 0 20px}
.pt-cat-search{
    display:flex;align-items:center;gap:10px;
    background:#fff;border:1px solid var(--line);border-radius:999px;
    padding:0 18px;height:48px;max-width:420px;
}
.pt-cat-search input{border:none;outline:none;font-size:14px;width:100%;font-family:inherit}
.pt-cat-hero-panel{background:#fff;border-radius:18px;padding:8px 20px;box-shadow:0 12px 34px rgba(20,53,143,.08)}
.pt-cat-hero-panel-row{display:flex;align-items:center;gap:14px;padding:16px 0;border-bottom:1px solid var(--line)}
.pt-cat-hero-panel-row:last-child{border-bottom:none}
.pt-cat-hero-panel-icon{width:42px;height:42px;min-width:42px;border-radius:12px;background:#eef6ff;color:var(--blue);display:flex;align-items:center;justify-content:center}
.pt-cat-hero-panel-row b{display:block;color:var(--navy);font-size:14px}
.pt-cat-hero-panel-row span{display:block;color:var(--muted);font-size:12px;margin-top:2px}

.pt-cat-band{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:32px}
.pt-cat-band-card{display:flex;align-items:center;gap:14px;background:#fff;border:1px solid var(--line);border-radius:18px;padding:18px 20px;color:var(--blue)}
.pt-cat-band-card b{display:block;color:var(--navy);font-size:15px}
.pt-cat-band-card span{display:block;color:var(--muted);font-size:12px;font-weight:400}

.pt-cat-toolbar{display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;margin-bottom:24px}
.pt-cat-filters{display:flex;gap:10px;flex-wrap:wrap}
.pt-cat-pill{
    padding:8px 18px;border-radius:999px;border:1px solid var(--line);
    background:#fff;color:#344054;font-size:14px;font-weight:600;cursor:pointer;
}
.pt-cat-pill.active{background:var(--blue);color:#fff;border-color:var(--blue)}
.pt-cat-note{color:var(--muted);font-size:13px}

.pt-cat-section{margin-bottom:40px}
.pt-cat-section-head{display:flex;justify-content:space-between;align-items:center;gap:16px;margin-bottom:18px;flex-wrap:wrap}
.pt-cat-section-title{display:flex;align-items:center;gap:12px}
.pt-cat-section-title h3{margin:0;font-size:19px;color:var(--navy)}
.pt-cat-section-title p{margin:2px 0 0;color:var(--muted);font-size:13px}

/* ==========================================================================
   โครงสร้างการ์ด และ เอฟเฟกต์ Hover Overlay
   ========================================================================== */
.pt-cat-row{display:grid;grid-template-columns:repeat(auto-fill,minmax(250px,1fr));gap:24px}

.pt-cat-card{
    background:#fff;
    border:1px solid var(--line);
    border-radius:20px;
    position:relative;
    display:flex;
    flex-direction:column;
    transition:transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
    box-shadow:0 6px 16px rgba(20,53,143,.04);
}

.pt-cat-card:hover {
    transform: translateY(-4px) scale(1.02);
    border-color: var(--blue);
    box-shadow: 0 20px 40px rgba(23,101,255,0.18);
    z-index: 10;
}

.pt-cat-card-img{
    background:linear-gradient(135deg,#eef3ff,#f7f9ff);
    height:160px;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:16px;
    border-radius:20px 20px 0 0;
}
.pt-cat-card-img img{max-width:100%;max-height:100%;object-fit:contain}
.pt-cat-card-body{
    padding:20px;
    display:flex;
    flex-direction:column;
    flex-grow:1;
}
.pt-cat-brand{color:var(--blue);font-weight:700;font-size:12px}
.pt-cat-name{font-size:16px;font-weight:700;color:var(--navy);margin:4px 0;line-height:1.3;min-height:42px}

/* เช็คลิสต์รายการฟีเจอร์ */
.pt-cat-features{
    list-style:none;
    padding:0;
    margin:12px 0 16px;
    border-top: 1px dashed var(--line);
    padding-top:12px;
}
.pt-cat-features li{
    display:flex;
    align-items:flex-start;
    gap:8px;
    font-size:12px;
    color:#475467;
    margin-bottom:8px;
    line-height:1.4;
}
.pt-cat-features li i{
    color:var(--blue);
    min-width:14px;
    margin-top:2px;
}

.pt-cat-price-box {
    margin-top:auto;
    padding-top:10px;
}
.pt-cat-price{font-size:22px;font-weight:800;color:var(--blue);line-height:1}
.pt-cat-vat{font-size:11px;color:var(--muted);margin-top:4px;margin-bottom:14px}

/* ปุ่มแบบคู่ (ซื้อเลย + รายละเอียด) */
.pt-cat-btn-group {
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:8px;
}
.pt-cat-buy{
    display:flex;
    align-items:center;
    justify-content:center;
    width:100%;
    background:#fff;
    color:var(--blue);
    padding:10px 4px;
    border-radius:10px;
    font-weight:700;
    font-size:13px;
    text-align:center;
    border:1px solid var(--line);
    transition: background 0.2s, border-color 0.2s;
}
.pt-cat-buy:hover{
    background:#eef6ff;
    border-color:var(--blue);
}
.pt-cat-btn-outline{
    background:#fff !important;
    color:var(--blue) !important;
    border:1px solid var(--line);
}
.pt-cat-btn-outline:hover{
    background:#eef6ff !important;
    border-color:var(--blue);
}

.pt-cat-cta{
    background:linear-gradient(135deg,#0c2c82,#1765ff);color:#fff;border-radius:26px;
    padding:34px;display:flex;align-items:center;justify-content:space-between;gap:24px;
    flex-wrap:wrap;margin-bottom:32px;
}
.pt-cat-cta-btn{padding:12px 26px;border-radius:12px;font-weight:800;font-size:14px;display:inline-block}

@media (max-width: 991px) {
    .pt-cat-hero-inner { grid-template-columns: 1fr; gap: 24px; }
    .pt-cat-hero { padding: 24px; }
    .pt-cat-search { max-width: 100%; }
}
@media (max-width:900px){
    .pt-cat-band{grid-template-columns:1fr}
}
</style>
@endsection

@section('content')

<div class="pt-cat-wrap" style="max-width:1400px;margin:32px auto;padding:0 24px">

    @if (!empty($breadcrumb))
    <div style="margin-bottom:16px;font-size:13px;color:var(--muted)">
        @foreach ($breadcrumb as $index => $item)
            @if($index !== count($breadcrumb) -1 )
                <a href="{{ $item['route'] }}" style="color:var(--blue)">{{ $item['name'] }}</a> /
            @else
                <span>{{ $item['name'] }}</span>
            @endif
        @endforeach
    </div>
    @endif

    <div class="pt-cat-hero">
        <div class="pt-cat-hero-inner">
            <div>
                <div class="pt-cat-kicker"><i data-lucide="shopping-bag" size="16"></i> PTCAD PRODUCTS</div>
                <h1 class="pt-cat-title">เลือก CAD Solution ที่เหมาะกับงานของคุณ</h1>
                <p class="pt-cat-desc">รวมซอฟต์แวร์ PTCAD, Plug-ins และเครื่องมือเสริมสำหรับงานเขียนแบบ ซื้อออนไลน์ได้ทันที และต่อยอดการใช้งานผ่านบัญชีสมาชิก</p>
                <form class="pt-cat-search" action="{{ route('fronend.search') }}">
                    <i data-lucide="search" size="18"></i>
                    <input type="text" name="search" placeholder="ค้นหาอะไรก็ได้ เช่น PTCAD, Civil Promax, AI, DWG...">
                </form>
            </div>
            <div class="pt-cat-hero-panel">
                <div class="pt-cat-hero-panel-row">
                    <div class="pt-cat-hero-panel-icon"><i data-lucide="key-round"></i></div>
                    <div><b>License ส่งอัตโนมัติ</b><span>ซื้อแล้วรับคีย์ภายใน 5 นาที</span></div>
                </div>
                <div class="pt-cat-hero-panel-row">
                    <div class="pt-cat-hero-panel-icon"><i data-lucide="download-cloud"></i></div>
                    <div><b>ดาวน์โหลดได้ทันที</b><span>ไฟล์ติดตั้งและคู่มืออยู่ในบัญชีสมาชิก</span></div>
                </div>
                <div class="pt-cat-hero-panel-row">
                    <div class="pt-cat-hero-panel-icon"><i data-lucide="play-circle"></i></div>
                    <div><b>Learning Center</b><span>วิดีโอ Tutorial สำหรับสมาชิกเท่านั้น</span></div>
                </div>
            </div>
        </div>
    </div>

    @php
        $groups = collect($data->items())->groupBy(function($p){
            return !empty($p['catName']) ? $p['catName'] : 'สินค้าอื่นๆ';
        });

        // ===== PTCAD: ให้หมวด "CAD Software" ขึ้นมาแสดงก่อนหมวดอื่นเสมอ (เช่น Plug ins/Civil Promax) =====
        $groups = $groups->sortBy(function($items, $catName){
            return $catName === 'CAD Software' ? 0 : 1;
        });
    @endphp

    
    <div class="pt-cat-toolbar">
        <div class="pt-cat-filters">
            <button type="button" class="pt-cat-pill active" data-filter="all">ทั้งหมด</button>
            @foreach ($groups as $catName => $items)
            <button type="button" class="pt-cat-pill" data-filter="cat-{{ \Illuminate\Support\Str::slug($catName) }}">{{ $catName }}</button>
            @endforeach
        </div>
        <div class="pt-cat-note">แสดง {{ count($groups) }} หมวดสินค้า</div>
    </div>

    @if (!empty($data) && count($data) != 0)
        @foreach ($groups as $catName => $items)
        <div class="pt-cat-section" id="cat-{{ \Illuminate\Support\Str::slug($catName) }}" data-cat="cat-{{ \Illuminate\Support\Str::slug($catName) }}">
            <div class="pt-cat-section-head">
                <div class="pt-cat-section-title">
                    <div>
                        <h3>{{ $catName }}</h3>
                        <p>@if ($catName === 'CAD Software') PTCAD Editions สำหรับงานเขียนแบบ 2D/3D @else {{ count($items) }} รายการในหมวดนี้ @endif</p>
                    </div>
                </div>
                <a href="#cat-{{ \Illuminate\Support\Str::slug($catName) }}" style="color:var(--blue);font-weight:700;font-size:14px;display:flex;align-items:center;gap:6px">ดูทั้งหมด <i data-lucide="arrow-right" size="16"></i></a>
            </div>
            <div class="pt-cat-row">
                @foreach ($items as $product)
                
                @if ($catName === 'Plug-ins')
                <div class="pt-cat-card">
                    <div class="pt-cat-card-img" style="position:relative">
                        <span style="position:absolute;top:10px;left:10px;background:#fff;color:var(--blue);font-size:11px;font-weight:800;padding:4px 10px;border-radius:999px">Plug-in</span>
                        <i data-lucide="building-2" size="40"></i>
                    </div>
                    <div class="pt-cat-card-body">
                        <span class="pt-cat-brand">{{ $catName }}</span>
                        <div class="pt-cat-name">{{ $product['name'] }}</div>

                        <ul class="pt-cat-features">
                            <li><i data-lucide="check-circle-2" size="16"></i> <span>คำสั่งเฉพาะทาง เขียนแบบไวขึ้น</span></li>
                            <li><i data-lucide="check-circle-2" size="16"></i> <span>ใช้งานร่วมกับ PTCAD ได้สมบูรณ์</span></li>
                        </ul>

                        <div class="pt-cat-price-box">
                            <div class="pt-cat-price" style="font-size:16px">ดูราคาในหน้าสินค้า</div>
                            <div class="pt-cat-vat" style="visibility:hidden">.</div>
                        </div>

                        <div class="pt-cat-btn-group">
                            <a href="{{ route('fronend.product.content',$product['permalink']) }}" class="pt-cat-buy">
                                รายละเอียด
                            </a>
                            <a href="{{ route('fronend.help.index') }}" class="pt-cat-buy pt-cat-btn-outline">
                                ขอข้อมูล
                            </a>
                        </div>
                    </div>
                </div>
                @else
                <div class="pt-cat-card">
                    <a href="{{ route('fronend.product.content',$product['permalink']) }}" class="pt-cat-card-img" style="position:relative">
                        @php
                            $badge = null;
if (stripos($product['name'],'lite') !== false) $badge = 'เริ่มต้น';
elseif (stripos($product['name'],'standard') !== false) $badge = 'ขายดีที่สุด';
elseif (stripos($product['name'],'civil') === false && stripos($product['name'],'pro') !== false) $badge = 'ซื้อขาด';
                        @endphp
                        @if ($badge)
                        <span style="position:absolute;top:10px;left:10px;background:#eaf3ff;color:var(--blue);font-size:11px;font-weight:800;padding:4px 10px;border-radius:999px">{{ $badge }}</span>
                        @endif
                        <img src="{{ $product['pictureName'] }}" alt="{{ $product['name'] }}">
                    </a>
                    <div class="pt-cat-card-body">
                        @if($product['brand'])
                        <a href="{{ route('fronend.brand',$product['brand_permalink']) }}" class="pt-cat-brand">
                            {{ $product['brand'] }}
                        </a>
                        @else
                        <span class="pt-cat-brand">PTCAD</span>
                        @endif
                        <div class="pt-cat-name">{{ $product['name'] }}</div>

                        <!-- ฟีเจอร์แสดงผลสไตล์รูปภาพที่ส่งมา -->
                        <!-- ฟีเจอร์แสดงผลสไตล์รูปภาพที่ส่งมา -->
<ul class="pt-cat-features">
    @if (stripos($product['name'],'lite') !== false)
    <li><i data-lucide="check-circle-2" size="16"></i> <span>เพิ่มชุดคำสั่งเฉพาะทาง ทั้ง 2D</span></li>
    <li><i data-lucide="check-circle-2" size="16"></i> <span>ระบบอัตโนมัติช่วยลดเวลาทำงาน</span></li>
@elseif (stripos($product['name'],'civil') !== false)
    <li><i data-lucide="check-circle-2" size="16"></i> <span>เชื่อมต่อกับ PTCAD ได้ทันที</span></li>
    <li><i data-lucide="check-circle-2" size="16"></i> <span>คำสั่งเฉพาะทางงานโยธาโดยตรง</span></li>
    <li><i data-lucide="check-circle-2" size="16"></i> <span>ลดขั้นตอนการทำงานซ้ำซ้อน</span></li>
@else
    <li><i data-lucide="check-circle-2" size="16"></i> <span>เพิ่มชุดคำสั่งเฉพาะทาง ทั้ง 2D/3D</span></li>
    <li><i data-lucide="check-circle-2" size="16"></i> <span>ระบบอัตโนมัติช่วยลดเวลาทำงาน</span></li>
    <li><i data-lucide="check-circle-2" size="16"></i> <span>รองรับการเชื่อมต่อ Plug-in</span></li>
@endif
</ul>

                        <div class="pt-cat-price-box">
                            <div class="pt-cat-price">{!! $product['price'] !!}</div>
                            <div class="pt-cat-vat">*ราคาไม่รวม VAT</div>
                        </div>

                        <!-- ปุ่มซื้อเลย และ ปุ่มรายละเอียด ข้างๆ กัน -->
                        <div class="pt-cat-btn-group">
                            <a href="{{ route('fronend.product.content',$product['permalink']) }}" class="pt-cat-buy">
                                ซื้อเลย
                            </a>
                            <a href="{{ route('fronend.product.content',$product['permalink']) }}" class="pt-cat-buy pt-cat-btn-outline">
                                รายละเอียด
                            </a>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
        </div>
        @endforeach
    @else
        <p style="color:var(--muted)">ไม่พบสินค้าในขณะนี้</p>
    @endif

    @guest
<div class="pt-cat-cta">
    <div>
        <div class="pt-cat-kicker" style="color:#8fd3ff">MEMBER ACCESS</div>
        <h2 style="color:#fff;margin:0 0 8px;font-size:24px">ซื้อแล้วใช้งานต่อผ่านบัญชีสมาชิก</h2>
        <p style="color:rgba(255,255,255,.8);margin:0;font-size:14px;line-height:1.6">ดู License, ดาวน์โหลดไฟล์ติดตั้ง, เข้าถึงวิดีโอ Tutorial และจัดการคำสั่งซื้อได้ในที่เดียว</p>
    </div>
    <div style="display:flex;gap:14px;flex-wrap:wrap">
        <a href="{{ route('register') }}" class="pt-cat-cta-btn" style="background:#fff;color:var(--blue)">สมัครสมาชิก</a>
        <a href="{{ route('login') }}" class="pt-cat-cta-btn" style="background:transparent;color:#fff;border:1.5px solid rgba(255,255,255,.6)">เข้าสู่ระบบ</a>
    </div>
</div>
@endguest

    <div style="margin-top:32px">
        {{ $data->links() }}
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var pills = document.querySelectorAll('.pt-cat-pill');
    var sections = document.querySelectorAll('.pt-cat-section');
    pills.forEach(function (pill) {
        pill.addEventListener('click', function () {
            pills.forEach(function (p) { p.classList.remove('active'); });
            pill.classList.add('active');
            var filter = pill.getAttribute('data-filter');
            sections.forEach(function (section) {
                if (filter === 'all' || section.getAttribute('data-cat') === filter) {
                    section.style.display = '';
                } else {
                    section.style.display = 'none';
                }
            });
        });
    });

    function gtag_event(eventname, ele){
        const pid = $(ele).attr("data-id");
        const pro_sku = $("#pro_sku_"+pid).val();
        const pro_name = $("#pro_name_"+pid).val();
        const pro_brand = $("#pro_brand_"+pid).val();
        const pro_price = $("#pro_price_"+pid).val();

        gtag("event", eventname, {
            currency: "THB",
            value: pro_price,
            items: [
                {
                    item_id: pro_sku,
                    item_name: pro_name,
                    item_brand: pro_brand,
                    price: pro_price,
                    quantity: 1
                }
            ]
        });

        fbq('track', 'AddToCart', {
            contents: [{id:pro_sku,quantity:1,brand:pro_brand,name:pro_name,item_price:pro_price}],
            content_type: "product",
            content_category: pro_brand,
            content_name: pro_name,
            currency: "THB",
            value: pro_price
        });
    }
    window.gtag_event = gtag_event;
});
</script>
@endsection