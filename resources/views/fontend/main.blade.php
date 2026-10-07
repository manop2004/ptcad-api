@extends('layouts.temp_user')

@section('title'){{ $og_title }} |@endsection
@section('og_site_name'){{ $og_site_name }}@endsection
@section('og_keywords'){{ $og_keywords }}@endsection
@section('og_title'){{ $og_title }}@endsection
@section('og_description'){{ $og_description }}@endsection
@section('og_url'){{ $og_url }}@endsection
@section('og_image'){{ $og_image }}@endsection

@section('css')
@php
    $countB = App\Models\TbBanner::select('banner_show')->where('banner_show',1)->count();
@endphp
@if($countB == 1)
<style>
    .flex-direction-nav{
        display: none !important;
    }
</style>
@endif

<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Noto+Sans+Thai:wght@400;500;600;700;800&display=swap');

.pt-wrap{
  --navy:#12358f; --blue:#1765ff; --blue-2:#3d8cff; --sky:#8fd3ff;
  --ink:#0b1f4d; --muted:#667085; --line:#e6edf8; --soft:#f6f9ff;
  --shadow:0 18px 50px rgba(20,53,143,.10);
  font-family:'Poppins','Noto Sans Thai',system-ui,sans-serif;
  color:var(--ink);
  
  width: 100%;
  max-width: 1360px;
  margin: 0 auto;
  padding: 0 24px;
  box-sizing: border-box;
}
.pt-wrap *{box-sizing:border-box}
.pt-wrap a{text-decoration:none;color:inherit}

.pt-wrap .pt-hero{
  position:relative; display:grid; grid-template-columns:minmax(0,1fr) minmax(0,.94fr); min-height:520px;
  background:radial-gradient(circle at 80% 42%,rgba(143,211,255,.55),transparent 30%),
             linear-gradient(105deg,#ffffff 0%,#f3f8ff 52%,#dbefff 100%);
  overflow:hidden; border-radius:28px; margin-bottom:60px;
}
.pt-wrap .pt-hero:after{
  content:"";position:absolute;right:-120px;bottom:-170px;width:680px;height:420px;
  background:linear-gradient(145deg,rgba(23,101,255,.08),rgba(143,211,255,.35));
  border-radius:55% 45% 0 0;transform:rotate(-8deg);
}
.pt-wrap .pt-hero-left{position:relative;z-index:2;padding:72px 48px 60px 64px}
.pt-wrap .pt-eyebrow{display:inline-flex;align-items:center;gap:8px;color:var(--blue);font-weight:800;font-size:14px;margin-bottom:22px}
.pt-wrap .pt-h1{font-size:52px;line-height:1.15;margin:0 0 14px;color:var(--navy);letter-spacing:-1.5px;font-weight:800}
.pt-wrap .pt-price-line{font-size:20px;font-weight:700;color:#163a90;margin:8px 0 30px}
.pt-wrap .pt-price-line strong{font-size:30px;color:var(--blue);letter-spacing:-1px}
.pt-wrap .pt-bullets{display:grid;grid-template-columns:repeat(2,minmax(170px,1fr));gap:16px 30px;margin:0 0 34px;max-width:560px}
.pt-wrap .pt-bullet{display:flex;align-items:center;gap:10px;color:#344054;font-weight:600;font-size:15px}
.pt-wrap .pt-check{width:22px;height:22px;border-radius:50%;display:grid;place-items:center;background:var(--blue);color:#fff;flex:none}
.pt-wrap .pt-hero-actions{display:flex;gap:16px;align-items:center;flex-wrap:wrap}
.pt-wrap .pt-primary-btn{
  height:46px;padding:0 28px;border-radius:12px;border:none;
  background:linear-gradient(135deg,var(--blue),#0d57df);color:white;font-weight:800;font-size:15px;
  display:inline-flex;align-items:center;justify-content:center;gap:10px;
  box-shadow:0 12px 24px rgba(23,101,255,.24);
  cursor: pointer;
}
.pt-wrap .pt-secondary-btn{
  height:46px;padding:0 28px;border-radius:12px;border:1.5px solid var(--blue);
  background:#fff;color:var(--blue);font-weight:800;font-size:15px;
  display:inline-flex;align-items:center;justify-content:center;gap:10px;
  cursor: pointer;
}
.pt-wrap .pt-hero-art{position:relative;z-index:2;display:flex;align-items:center;justify-content:center;padding:40px 50px}
.pt-wrap .pt-mockup{position:relative;width:100%;max-width:520px;height:320px}
.pt-wrap .pt-box{
  position:absolute;left:0;bottom:12px;width:160px;height:230px;border-radius:18px;
  background:linear-gradient(160deg,#fff 0%,#edf6ff 40%,#0f3d9c 41%,#1765ff 100%);
  box-shadow:0 24px 48px rgba(12,45,126,.18);
  display:flex;flex-direction:column;justify-content:flex-end;padding:22px;color:white;overflow:hidden;
}
.pt-wrap .pt-box b{font-size:22px;line-height:1.15;z-index:1;letter-spacing:-.5px}
.pt-wrap .pt-box span{font-size:11px;opacity:.8;z-index:1;margin-top:6px}
.pt-wrap .pt-laptop{
  position:absolute;right:0;bottom:0;width:420px;height:270px;border-radius:18px 18px 8px 8px;
  background:#1c2433;padding:10px 10px 24px;box-shadow:0 26px 60px rgba(10,31,77,.24);
}
.pt-wrap .pt-screen{height:220px;border-radius:10px;background:#f8fbff;overflow:hidden;border:1px solid #d9e3f2;position:relative}
.pt-wrap .pt-screen:before{content:"";display:block;height:20px;background:#eef3fb;border-bottom:1px solid #d9e3f2}
.pt-wrap .pt-cad-lines{position:absolute;inset:36px 30px 24px;border:2px solid #a8b5c9;background:linear-gradient(90deg,transparent 49%,#d8e0ea 50%,transparent 51%),linear-gradient(0deg,transparent 49%,#d8e0ea 50%,transparent 51%);background-size:42px 42px}
.pt-wrap .pt-base{position:absolute;left:40px;right:36px;bottom:-18px;height:20px;border-radius:0 0 22px 22px;background:#b8c3d4}

.pt-wrap .pt-section{padding:60px 0}
.pt-wrap .pt-section-head{display:flex;align-items:flex-end;justify-content:space-between;gap:30px;margin-bottom:40px;flex-wrap:wrap}
.pt-wrap .pt-kicker{font-weight:800;color:var(--blue);font-size:14px;margin-bottom:8px}
.pt-wrap .pt-h2{margin:0;font-size:30px;line-height:1.2;color:#102b76;letter-spacing:-.6px}
.pt-wrap .pt-section-desc{color:var(--muted);font-size:15px;line-height:1.65;max-width:620px;margin:10px 0 0}
.pt-wrap .pt-view-all{display:inline-flex;align-items:center;gap:8px;color:var(--blue);font-weight:800;font-size:15px;white-space:nowrap}
.pt-wrap .pt-view-all:hover{color:var(--navy)}

.pt-wrap .pt-trust-grid{display:grid;grid-template-columns:repeat(4, minmax(0, 1fr));gap:24px}
.pt-wrap .pt-trust-card{background:#fff;border:1px solid var(--line);border-radius:22px;padding:30px 24px;box-shadow:0 12px 34px rgba(20,53,143,.06);display:flex;flex-direction:column;align-items:center;text-align:center;height:100%;transition:transform .25s ease, box-shadow .25s ease, border-color .25s ease}
.pt-wrap .pt-trust-card:hover{transform:translateY(-4px) scale(1.02);border-color:var(--blue);box-shadow:0 20px 40px rgba(23,101,255,.18)}
.pt-wrap .pt-trust-icon{width:52px;height:52px;border-radius:16px;display:grid;place-items:center;background:#eef6ff;color:var(--blue);margin-bottom:20px;flex-shrink:0}
.pt-wrap .pt-trust-card h3{margin:0 0 10px;font-size:19px;color:#102b76}
.pt-wrap .pt-trust-card p{margin:0;color:var(--muted);line-height:1.7;font-size:14px}

.pt-wrap .pt-edition-grid{display:grid;grid-template-columns:repeat(3, minmax(0, 1fr));gap:24px}
.pt-wrap .pt-edition-card{
  position:relative;display:flex;flex-direction:column;background:#fff;
  border:1px solid #e2e8f0;border-radius:20px;padding:28px 24px;
  box-shadow:0 6px 20px rgba(0,0,0,.03);transition:.25s ease;cursor:pointer;height:100%;
}
.pt-wrap .pt-edition-card:hover{transform:translateY(-4px);box-shadow:0 16px 36px rgba(20,53,143,.10);border-color:var(--blue)}
.pt-wrap .pt-edition-card.featured{border:2px solid var(--blue);box-shadow:0 12px 32px rgba(23,101,255,.12)}

.pt-wrap .pt-edition-badge{
  position:absolute;right:20px;top:-12px;z-index:2;
  background:linear-gradient(135deg,var(--blue),#0d57df);color:#fff;
  border-radius:999px;padding:4px 14px;font-weight:700;font-size:12px;
  box-shadow:0 6px 14px rgba(23,101,255,.25);
}

.pt-wrap .pt-card-header-flex {
  display: flex;
  align-items: center;
  gap: 16px;
  margin-bottom: 20px;
}
.pt-wrap .pt-edition-image{
  width: 76px;
  height: 90px;
  flex-shrink: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  background: transparent;
  padding: 0;
  border-radius: 0;
}
.pt-wrap .pt-edition-image img{
  width: 100%;
  height: 100%;
  object-fit: contain;
}
.pt-wrap .pt-card-header-info {
  display: flex;
  flex-direction: column;
}
.pt-wrap .pt-card-header-info h3{
  margin:0 0 4px 0;
  font-size:20px;
  font-weight:800;
  color:#1e293b;
  line-height:1.2;
}
.pt-wrap .pt-edition-sub{
  color:#64748b;
  font-size:13.5px;
  margin:0;
  line-height:1.4;
  font-weight:500;
}

.pt-wrap .pt-card-highlight {
  font-size: 15px;
  font-weight: 700;
  color: #0f172a;
  margin-bottom: 8px;
  line-height: 1.4;
}

.pt-wrap .pt-clean{list-style:none;padding:0;margin:12px 0 20px;display:grid;gap:10px}
.pt-wrap .pt-clean li{display:flex;gap:10px;align-items:flex-start;color:#475569;font-size:13.5px;line-height:1.55}
.pt-wrap .pt-mini-check{width:16px;height:16px;border-radius:50%;background:#eef6ff;color:var(--blue);display:grid;place-items:center;flex:none;margin-top:2px}

.pt-wrap .pt-edition-bottom{display:flex;align-items:flex-end;justify-content:space-between;gap:14px;margin-top:auto;padding-top:12px;border-top:1px dashed #e2e8f0}
.pt-wrap .pt-edition-price{font-size:24px;font-weight:800;color:var(--blue);text-align:right;white-space:nowrap}
.pt-wrap .pt-edition-price small{display:block;font-size:12px;color:var(--muted);font-weight:600;text-align:right}
.pt-wrap .pt-edition-card .pt-primary-btn{margin-top:16px;width:100%}

.pt-wrap .pt-review-grid{display:grid;grid-template-columns:repeat(3, minmax(0, 1fr));gap:24px}
.pt-wrap .pt-review-card{background:#fff;border:1px solid var(--line);border-radius:22px;padding:30px 26px;box-shadow:0 12px 34px rgba(20,53,143,.06)}
.pt-wrap .pt-stars{color:#f5a400;font-weight:800;letter-spacing:2px;margin-bottom:16px}
.pt-wrap .pt-review-card p{margin:0;color:var(--muted);line-height:1.7;font-size:14px}

.pt-wrap .pt-plugin-grid{display:grid;grid-template-columns:1.2fr 1fr 1fr;gap:24px}
.pt-wrap .pt-plugin-card{background:#fff;border:1px solid var(--line);border-radius:22px;padding:30px 26px;box-shadow:0 12px 34px rgba(20,53,143,.06);display:flex;flex-direction:column;justify-content:space-between}
.pt-wrap .pt-plugin-card h3{margin:0 0 10px;font-size:19px;color:#102b76}
.pt-wrap .pt-plugin-card p{margin:0;color:var(--muted);line-height:1.7;font-size:14px}
.pt-wrap .pt-plugin-large{background:linear-gradient(135deg,#0c2c82,#1765ff);color:white;overflow:hidden;position:relative}
.pt-wrap .pt-plugin-large h3,.pt-wrap .pt-plugin-large p{color:white}
.pt-wrap .pt-plugin-large:after{content:"";position:absolute;right:-40px;bottom:-60px;width:220px;height:220px;border-radius:50%;background:rgba(255,255,255,.12)}

.pt-wrap .pt-learn-grid{display:grid;grid-template-columns:1.1fr .9fr;gap:24px;align-items:stretch}
.pt-wrap .pt-learn-card{background:#fff;border:1px solid var(--line);border-radius:22px;padding:30px 26px;box-shadow:0 12px 34px rgba(20,53,143,.06)}
.pt-wrap .pt-learn-card h3{margin:0 0 10px;font-size:19px;color:#102b76}
.pt-wrap .pt-learn-card p{margin:0;color:var(--muted);line-height:1.7;font-size:14px}
.pt-wrap .pt-learn-hero{display:grid;grid-template-columns:1fr 160px;gap:28px;align-items:center}
.pt-wrap .pt-video-lock{height:120px;border-radius:20px;background:linear-gradient(135deg,#eef6ff,#dbeeff);display:grid;place-items:center;color:var(--blue)}

.pt-wrap .pt-faq-wrap {
    display: grid;
    grid-template-columns: 1.25fr 0.85fr;
    gap: 32px;
    align-items: start;
}

.pt-wrap .pt-faq-list {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.pt-wrap .pt-faq-item {
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 20px 24px;
    background: #ffffff;
    cursor: pointer;
    transition: all 0.25s ease;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.02);
}

.pt-wrap .pt-faq-item:hover {
    border-color: #cbd5e1;
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.04);
}

.pt-wrap .pt-faq-item .faq-q {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 16px;
    font-weight: 700;
    color: #0b1f4d;
}

.pt-wrap .pt-faq-item .faq-q i {
    transition: transform 0.3s ease;
    color: #1765ff;
    flex-shrink: 0;
}

.pt-wrap .pt-faq-item.open .faq-q i {
    transform: rotate(180deg);
}

.pt-wrap .pt-faq-item .faq-a {
    max-height: 0;
    overflow: hidden;
    color: #64748b;
    font-size: 14px;
    line-height: 1.7;
    transition: max-height 0.3s ease, margin-top 0.3s ease;
    margin-top: 0;
}

.pt-wrap .pt-faq-item.open .faq-a {
    max-height: 300px;
    margin-top: 14px;
}

.pt-wrap .pt-trial-card {
    background: #ffffff;
    border: 1px solid #f1f5f9;
    border-radius: 24px;
    padding: 40px 36px;
    box-shadow: 0 20px 40px rgba(18, 53, 143, 0.05);
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}

.pt-wrap .pt-trial-icon-box {
    width: 56px;
    height: 56px;
    border-radius: 16px;
    background: #eef6ff;
    color: #1765ff;
    display: grid;
    place-items: center;
    margin-bottom: 24px;
}

.pt-wrap .pt-trial-card h3 {
    margin: 0 0 8px 0;
    font-size: 22px;
    font-weight: 800;
    color: #0b1f4d;
}

.pt-wrap .pt-trial-card p {
    margin: 0 0 28px 0;
    color: #94a3b8;
    font-size: 14px;
    line-height: 1.6;
}

.pt-wrap .pt-trial-btn {
    height: 48px;
    padding: 0 32px;
    border-radius: 12px;
    background: linear-gradient(135deg, #1765ff, #0d57df);
    color: #ffffff !important;
    font-weight: 700;
    font-size: 15px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    box-shadow: 0 10px 20px rgba(23, 101, 255, 0.3);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    text-decoration: none;
}

.pt-wrap .pt-trial-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 14px 26px rgba(23, 101, 255, 0.4);
}

.pt-wrap .pt-support-grid{display:grid;grid-template-columns:repeat(4, minmax(0, 1fr));gap:24px}
.pt-wrap .pt-support-card{background:#fff;border:1px solid var(--line);border-radius:22px;padding:30px 24px;box-shadow:0 12px 34px rgba(20,53,143,.06);text-align:left;height:100%}
.pt-wrap .pt-support-link{display:block;cursor:pointer;transition:.2s ease}
.pt-wrap .pt-support-link:hover{transform:translateY(-5px);box-shadow:0 18px 40px rgba(20,53,143,.12);border-color:var(--blue)}

.pt-wrap .pt-b2b-card{
  display:flex;align-items:center;justify-content:space-between;gap:30px;flex-wrap:wrap;
  background:#fff;border:1px solid var(--line);border-radius:24px;padding:34px 36px;
  box-shadow:0 14px 40px rgba(20,53,143,.07);position:relative;overflow:hidden;
}
.pt-wrap .pt-b2b-card:after{content:"";position:absolute;right:-60px;bottom:-90px;width:220px;height:220px;border-radius:50%;background:radial-gradient(circle,rgba(23,101,255,.08),transparent 70%)}
.pt-wrap .pt-b2b-left{max-width:680px;position:relative;z-index:1;min-width:0}
.pt-wrap .pt-b2b-card h2{margin:10px 0 10px;font-size:24px;color:#102b76;letter-spacing:-.4px}
.pt-wrap .pt-b2b-card p{margin:0 0 18px;color:var(--muted);font-size:14px;line-height:1.7}
.pt-wrap .pt-b2b-checks{display:flex;gap:22px;flex-wrap:wrap}
.pt-wrap .pt-b2b-checks span{display:flex;align-items:center;gap:6px;color:#344054;font-weight:700;font-size:13px}
.pt-wrap .pt-b2b-checks i{color:var(--blue)}
.pt-wrap .pt-b2b-card .pt-primary-btn{flex-shrink:0;position:relative;z-index:1}

@media (max-width:1100px){
  .pt-wrap .pt-hero{grid-template-columns:1fr}
  .pt-wrap .pt-trust-grid{grid-template-columns:repeat(2, 1fr)}
  .pt-wrap .pt-edition-grid{grid-template-columns:repeat(2, 1fr)}
  .pt-wrap .pt-review-grid{grid-template-columns:repeat(2, 1fr)}
  .pt-wrap .pt-plugin-grid, .pt-wrap .pt-learn-grid, .pt-wrap .pt-faq-wrap{grid-template-columns:1fr}
  .pt-wrap .pt-support-grid{grid-template-columns:repeat(2, 1fr)}
}

@media (max-width:720px){
  .pt-wrap{padding: 0 16px;}
  .pt-wrap .pt-hero-left{padding:36px 20px}
  .pt-wrap .pt-h1{font-size:32px}
  .pt-wrap .pt-bullets{grid-template-columns:1fr}
  .pt-wrap .pt-hero-art{display:none}
  
  .pt-wrap .pt-trust-grid,
  .pt-wrap .pt-edition-grid,
  .pt-wrap .pt-review-grid,
  .pt-wrap .pt-support-grid {
      grid-template-columns: 1fr;
  }
  .pt-wrap .pt-learn-hero{grid-template-columns:1fr}
  .pt-wrap .pt-video-lock{order:-1; height:160px}
  .pt-wrap .pt-b2b-card{flex-direction:column;align-items:flex-start}
  .pt-wrap .pt-b2b-card .pt-primary-btn{width:100%;justify-content:center}
}
/* ==========================================
   [FIX] แสดงรูปสินค้า Hero บนจอมือถือ
   ========================================== */
@media (max-width: 720px) {
  /* 1. ยกเลิกการซ่อนรูปฝั่งขวา ให้แสดงผลต่อ */
  .pt-wrap .pt-hero-art {
    display: flex !important;
    padding: 20px 16px 36px 16px !important;
    justify-content: center !important;
    align-items: center !important;
    width: 100% !important;
    max-width: 100% !important;
    box-sizing: border-box !important;
  }

  /* 2. ถ้าข้างในใช้รูปภาพ <img> ให้ปรับขนาดให้พอดีจอมือถือ ไม่ล้นขอบ */
  .pt-wrap .pt-hero-art img {
    max-width: 100% !important;
    height: auto !important;
    max-height: 280px !important; /* ปรับความสูงรูปให้พอดีจอมือถือ */
    object-fit: contain !important;
  }

  /* 3. ปรับระยะเว้นของฝั่งซ้ายให้กระชับขึ้น */
  .pt-wrap .pt-hero-left {
    padding: 32px 20px 16px 20px !important;
    text-align: center !important;
  }

  /* 4. จัดปุ่มกดให้อยู่ตรงกลางบนมือถือ */
  .pt-wrap .pt-hero-actions {
    justify-content: center !important;
  }
}
</style>
@endsection

@section('content')

<div class="pt-wrap">

    @php
        $hero = App\Models\TbHeroBanner::first();
        $setting = App\Models\TbSetting::first();
    @endphp
    @if(!empty($hero->hero_mode) && $hero->hero_mode == 2)
        {{-- ===== โหมดรูปเดียว/หลายรูป — ใช้ slider ของ TbBanner ที่มีอยู่แล้ว (รองรับหลายรูป+ลิงก์+วันหมดอายุ+จัดลำดับ) ===== --}}
        <div style="border-radius:28px;overflow:hidden;margin-bottom:60px">
            @include('layouts.fontend.slider')
        </div>
    @else
    <section class="pt-hero" @if(!empty($hero->hero_bg_image)) style="background:url('{{ asset('storage/setting/'.$hero->hero_bg_image) }}') center/cover no-repeat;" @endif>
        <div class="pt-hero-left">
            <div class="pt-eyebrow">
                <i data-lucide="badge-check" size="18"></i> CAD ถูกลิขสิทธิ์ ซื้อออนไลน์ได้ทันที
            </div>
            <h1 class="pt-h1">{{ !empty($hero->hero_title) ? $hero->hero_title : 'PTCAD โปรแกรมเขียนแบบ 2D' }}</h1>
            @if(!empty($hero->hero_price))
            <p class="pt-price-line">เริ่มต้นเพียง <strong>{{ $hero->hero_price }}</strong> {{ $hero->hero_price_unit }}</p>
            @endif
            <div class="pt-bullets">
                @if(!empty($hero->hero_bullet1))<div class="pt-bullet"><span class="pt-check"><i data-lucide="check" size="14"></i></span>{{ $hero->hero_bullet1 }}</div>@endif
                @if(!empty($hero->hero_bullet2))<div class="pt-bullet"><span class="pt-check"><i data-lucide="check" size="14"></i></span>{{ $hero->hero_bullet2 }}</div>@endif
                @if(!empty($hero->hero_bullet3))<div class="pt-bullet"><span class="pt-check"><i data-lucide="check" size="14"></i></span>{{ $hero->hero_bullet3 }}</div>@endif
                @if(!empty($hero->hero_bullet4))<div class="pt-bullet"><span class="pt-check"><i data-lucide="check" size="14"></i></span>{{ $hero->hero_bullet4 }}</div>@endif
            </div>
            <div class="pt-hero-actions">
                @if(empty($hero) || $hero->hero_btn1_status == 1)
                <a class="pt-primary-btn" href="{{ !empty($hero->hero_btn1_link) ? $hero->hero_btn1_link : route('fronend.category.all') }}">{{ !empty($hero->hero_btn1_text) ? $hero->hero_btn1_text : 'ซื้อเลย' }}</a>
                @endif
                @if(empty($hero) || $hero->hero_btn2_status == 1)
                <a class="pt-secondary-btn" href="{{ !empty($hero->hero_btn2_link) ? $hero->hero_btn2_link : route('fronend.help.index') }}">{{ !empty($hero->hero_btn2_text) ? $hero->hero_btn2_text : 'ทดลองใช้ฟรี' }}</a>
                @endif
            </div>
        </div>
        <div class="pt-hero-art" aria-hidden="true">
            @if(!empty($hero->hero_image))
                <img src="{{ asset('storage/setting/'.$hero->hero_image) }}" style="max-width:100%;max-height:420px;object-fit:contain" alt="{{ !empty($hero->hero_title) ? $hero->hero_title : 'PTCAD' }}">
            @else
            <div class="pt-mockup">
                <div class="pt-box"><b>PTCAD</b><span>SOFTWARE STORE</span></div>
                <div class="pt-laptop">
                    <div class="pt-screen"><div class="pt-cad-lines"></div></div>
                    <div class="pt-base"></div>
                </div>
            </div>
            @endif
        </div>
    </section>
    @endif

    <section class="pt-section" style="text-align: center;">
        <div style="margin-bottom: 40px;">
            <div class="pt-kicker" style="margin-bottom: 12px;">WHY BUY FROM PTCAD</div>
            <h2 class="pt-h2" style="font-size: 36px; margin-bottom: 16px;">ทำไมต้องซื้อกับเรา?</h2>
            <p class="pt-section-desc" style="margin: 0 auto; max-width: 700px;">ออกแบบสำหรับลูกค้าที่ต้องการซื้อ ใช้งาน และรับเอกสารได้รวดเร็วในขั้นตอนเดียว</p>
        </div>
        
        <div class="pt-trust-grid">
            <div class="pt-trust-card">
                <div class="pt-trust-icon"><i data-lucide="shopping-cart"></i></div>
                <h3>ซื้อออนไลน์</h3>
                <p>เลือกแพ็กเกจและสั่งซื้อผ่านเว็บไซต์ได้ทันที</p>
            </div>
            <div class="pt-trust-card">
                <div class="pt-trust-icon"><i data-lucide="key-round"></i></div>
                <h3>คีย์ภายใน 5 นาที</h3>
                <p>ระบบส่ง License Key อัตโนมัติหลังชำระเงิน</p>
            </div>
            <div class="pt-trust-card">
                <div class="pt-trust-icon"><i data-lucide="credit-card"></i></div>
                <h3>ชำระเงินออนไลน์</h3>
                <p>รองรับบัตรและโอนเงินตามระบบที่กำหนด</p>
            </div>
            <div class="pt-trust-card">
                <div class="pt-trust-icon"><i data-lucide="file-text"></i></div>
                <h3>ออกใบกำกับภาษี</h3>
                <p>รองรับทั้งบุคคลและบริษัท ใช้เป็นเอกสารบัญชีได้</p>
            </div>
        </div>
    </section>

    @php
        $productCards = App\Models\TbHomeProductCategory::where('status', 1)->orderBy('sort_order', 'asc')->get();
    @endphp
    @if(count($productCards) != 0)
    <section class="pt-section">
        <div class="pt-section-head">
            <div>
                <div class="pt-kicker">PRODUCT CATEGORY</div>
                <h2 class="pt-h2">เลือกซอฟต์แวร์ที่เหมาะกับคุณ</h2>
                <p class="pt-section-desc">ราคาและฟีเจอร์จัดแบบเข้าใจง่าย เหมาะสำหรับผู้เริ่มต้น ธุรกิจขนาดเล็ก และงานประจำวัน</p>
            </div>
            <a class="pt-view-all" href="{{ route('fronend.category.all') }}">
                ดูผลิตภัณฑ์ทั้งหมด <i data-lucide="arrow-right" size="18"></i>
            </a>
        </div>
        <div class="pt-edition-grid">
            @foreach($productCards as $card)
            <a class="pt-edition-card @if($card->is_featured == 1) featured @endif" href="{{ !empty($card->link) ? $card->link : route('fronend.category.all') }}">
                @if(!empty($card->badge_text))
                <span class="pt-edition-badge">{{ $card->badge_text }}</span>
                @endif
                <div class="pt-card-header-flex">
                    @if(!empty($card->image))
                    <div class="pt-edition-image">
                        <img src="{{ asset('storage/setting/'.$card->image) }}" alt="{{ $card->title }}">
                    </div>
                    @endif
                    <div class="pt-card-header-info">
                        <h3>{{ $card->title }}</h3>
                        @if(!empty($card->subtitle))<p class="pt-edition-sub">{{ $card->subtitle }}</p>@endif
                    </div>
                </div>

                @if(!empty($card->highlight))
                <div class="pt-card-highlight">{{ $card->highlight }}</div>
                @endif

                @if(!empty($card->feature1) || !empty($card->feature2) || !empty($card->feature3))
                <ul class="pt-clean">
                    @if(!empty($card->feature1))<li><span class="pt-mini-check"><i data-lucide="check" size="12"></i></span>{{ $card->feature1 }}</li>@endif
                    @if(!empty($card->feature2))<li><span class="pt-mini-check"><i data-lucide="check" size="12"></i></span>{{ $card->feature2 }}</li>@endif
                    @if(!empty($card->feature3))<li><span class="pt-mini-check"><i data-lucide="check" size="12"></i></span>{{ $card->feature3 }}</li>@endif
                </ul>
                @endif

                <div class="pt-edition-bottom">
                    <div></div>
                    @if(!empty($card->price))
                    <div class="pt-edition-price">{{ $card->price }} <small>{{ $card->price_unit }}</small></div>
                    @endif
                </div>
                <span class="pt-primary-btn">
                    {{ !empty($card->button_text) ? $card->button_text : 'ดูรายละเอียด' }}
                </span>
            </a>
            @endforeach
        </div>
    </section>
    @endif
{{--
    <section class="pt-section">
        <div class="pt-section-head">
            <div>
                <div class="pt-kicker">WORKS WITH PTCAD</div>
                <h2 class="pt-h2">ขยายความสามารถให้ซอฟต์แวร์ของคุณ</h2>
                <p class="pt-section-desc">เพิ่มเครื่องมือเสริมสำหรับงานเฉพาะทาง เช่น งานโยธา เทมเพลตไทย และเครื่องมือ AI ในอนาคต</p>
            </div>
        </div>
        <div class="pt-plugin-grid">
    <article class="pt-plugin-card pt-plugin-large">
        <div>
             <div class="pt-trust-icon" style="background:rgba(255,255,255,.16);color:#fff"><i data-lucide="building-2"></i></div>
             <h3>Civil Promax</h3>
             <p>เครื่องมือเสริมสำหรับงานโยธา ช่วยให้การทำงานร่วมกับซอฟต์แวร์หลักสะดวกขึ้น</p>
        </div>
        <br><a class="pt-secondary-btn" href="/product/civil-promax" style="background:white; color:var(--navy); margin-top:15px;">ดูรายละเอียด</a>
    </article>
</div>
    </section>

    <section class="pt-section" style="background:#f7faff;border-radius:22px; padding:40px 24px;">
        <div class="pt-section-head">
            <div>
                <div class="pt-kicker">MEMBER ACCESS</div>
                <h2 class="pt-h2">วิดีโอสอนใช้งานสำหรับสมาชิก</h2>
                <p class="pt-section-desc">สมัครสมาชิกหรือเข้าสู่ระบบเพื่อเข้าดูวิดีโอ Tutorial คู่มือเริ่มต้น และเนื้อหาช่วยใช้งาน</p>
            </div>
        </div>
        <div class="pt-learn-grid">
            <article class="pt-learn-card pt-learn-hero">
                <div>
                    <div class="pt-trust-icon"><i data-lucide="play-circle"></i></div>
                    <h3>Learning Center</h3>
                    <p>รวมวิดีโอเริ่มต้นใช้งาน การติดตั้ง การ Activate และ Tips การเขียนแบบ</p>
                    <br>
                    <a class="pt-primary-btn" href="{{ !empty($hero->member_access_link) ? $hero->member_access_link : route('login') }}">สมัครสมาชิกเพื่อดูวิดีโอ</a>
                </div>
                <div class="pt-video-lock"><i data-lucide="lock-keyhole" size="50"></i></div>
            </article>
            <article class="pt-learn-card">
                <div class="pt-trust-icon"><i data-lucide="download"></i></div>
                <h3>ดาวน์โหลดและคู่มือ</h3>
                <p>หลังสมัครสมาชิก สามารถเข้าถึงไฟล์ดาวน์โหลด คู่มือ และเอกสารประกอบการใช้งานได้จากบัญชีของคุณ</p>
                <br><a class="pt-secondary-btn" href="{{ route('fronend.account') }}">ไปที่ดาวน์โหลด</a>
            </article>
        </div>
    </section>--}}

    <section class="pt-section" id="reviews">
        <div class="pt-section-head">
            <div>
                <div class="pt-kicker">CUSTOMER REVIEWS</div>
                <h2 class="pt-h2">เสียงจากผู้ใช้งานจริง</h2>
            </div>
        </div>
        @if(!empty($homeReviews) && count($homeReviews) > 0)
        <div class="pt-review-grid">
            @foreach($homeReviews as $review)
            <article class="pt-review-card">
                <div class="pt-stars">
                    @for ($i = 0; $i < $review->rating; $i++)★@endfor
                    @for ($i = 0; $i < 5 - $review->rating; $i++)☆@endfor
                </div>
                <p>"{{ Str::limit($review->review_text, 120) }}"</p>
            </article>
            @endforeach
        </div>
        @else
        <div class="pt-review-grid">
            <article class="pt-review-card">
                <div class="pt-stars">★★★★★</div>
                <p>"ราคาเข้าถึงง่าย ซื้อแล้วได้คีย์เร็ว เหมาะกับบริษัทเล็กที่ต้องการซอฟต์แวร์ถูกลิขสิทธิ์"</p>
            </article>
            <article class="pt-review-card">
                <div class="pt-stars">★★★★★</div>
                <p>"เปิดไฟล์ DWG ได้ ใช้งานไม่ยาก ทีมซัพพอร์ตตอบภาษาไทยสะดวกมาก"</p>
            </article>
            <article class="pt-review-card">
                <div class="pt-stars">★★★★★</div>
                <p>"เหมาะกับงานเขียนแบบทั่วไป ไม่ต้องรอใบเสนอราคาหลายวัน ซื้อแล้วเริ่มใช้ได้เลย"</p>
            </article>
        </div>
        @endif
    </section>

    <section class="pt-section" id="download">
        <div class="pt-section-head">
            <div>
                <div class="pt-kicker">FAQ & DOWNLOAD</div>
                <h2 class="pt-h2" style="font-size: 36px; font-weight: 800; color: #0b1f4d;">คำถามที่พบบ่อย</h2>
            </div>
        </div>
        
        <div class="pt-faq-wrap">
            <!-- ฝั่ง FAQ Accordion -->
            <div class="pt-faq-list">
                <div class="pt-faq-item" onclick="toggleFaq(this)">
                    <div class="faq-q">
                        <span>PTCAD รองรับไฟล์ DWG ไหม</span>
                        <i data-lucide="chevron-down"></i>
                    </div>
                    <div class="faq-a">
                        รองรับครับ เปิด แก้ไข และบันทึกไฟล์ DWG ได้ตรงเวอร์ชันมาตรฐานอุตสาหกรรม ใช้งานร่วมกับโปรแกรม CAD อื่นได้ปกติ
                    </div>
                </div>

                <div class="pt-faq-item" onclick="toggleFaq(this)">
                    <div class="faq-q">
                        <span>ซื้อแล้วได้รับ License Key อย่างไร</span>
                        <i data-lucide="chevron-down"></i>
                    </div>
                    <div class="faq-a">
                        หลังชำระเงินสำเร็จ ระบบจะส่ง License Key ไปยังอีเมลที่ลงทะเบียนไว้ภายใน 5 นาที พร้อมดูได้จากหน้า "ซอฟต์แวร์ของฉัน" ในบัญชีของคุณ
                    </div>
                </div>

                <div class="pt-faq-item" onclick="toggleFaq(this)">
                    <div class="faq-q">
                        <span>ออกใบกำกับภาษีได้ไหม</span>
                        <i data-lucide="chevron-down"></i>
                    </div>
                    <div class="faq-a">
                        ออกได้ทั้งในนามบุคคลและนิติบุคคล กรอกข้อมูลใบกำกับภาษีตอนชำระเงิน หรือแก้ไขภายหลังได้ที่หน้าที่อยู่จัดส่ง
                    </div>
                </div>

                <div class="pt-faq-item" onclick="toggleFaq(this)">
                    <div class="faq-q">
                        <span>เปลี่ยนเครื่องหรือติดตั้งใหม่ได้ไหม</span>
                        <i data-lucide="chevron-down"></i>
                    </div>
                    <div class="faq-a">
                        ได้ครับ ติดต่อทีมซัพพอร์ตผ่าน LINE หรือช่องทางติดต่อ เพื่อปลดล็อกเครื่องเดิมและเปิดใช้งานบนเครื่องใหม่ให้
                    </div>
                </div>
            </div>

            <!-- ฝั่ง Trial Card -->
            <article class="pt-trial-card">
                <div class="pt-trial-icon-box">
                    <i data-lucide="download-cloud" size="28"></i>
                </div>
                <h3>ทดลองใช้ PTCAD</h3>
                <p>ดาวน์โหลด Trial เพื่อทดลองใช้งานก่อนตัดสินใจซื้อ</p>
                <a class="pt-trial-btn" href="{{ !empty($hero->trial_download_link) ? $hero->trial_download_link : route('fronend.help.index') }}">
                    ดาวน์โหลด Trial
                </a>
            </article>
        </div>
    </section>

    <section class="pt-section" style="background:#f7faff;border-radius:22px; padding:40px 24px;">
        <div class="pt-b2b-card">
            <div class="pt-b2b-left">
                <div class="pt-trust-icon"><i data-lucide="building-2"></i></div>
                <div class="pt-kicker" style="margin-top:14px">FOR BUSINESS</div>
                <h2>สำหรับองค์กรหรือซื้อหลาย License?</h2>
                <p>รับใบเสนอราคาอย่างเป็นทางการ พร้อมคำแนะนำการเลือก License ที่เหมาะกับจำนวนผู้ใช้งานและรูปแบบการทำงานของทีมคุณ</p>
                <div class="pt-b2b-checks">
                    <span><i data-lucide="check-circle" size="16"></i> ซื้อหลาย License</span>
                    <span><i data-lucide="check-circle" size="16"></i> ออกใบเสนอราคาในนามบริษัท</span>
                    <span><i data-lucide="check-circle" size="16"></i> มีทีมงานช่วยแนะนำ</span>
                </div>
            </div>
            <a href="{{ !empty($hero->business_quote_link) ? $hero->business_quote_link : route('fronend.quotation') }}" class="pt-primary-btn"><i data-lucide="file-text" size="16"></i> ขอใบเสนอราคา</a>
        </div>
    </section>

    <section class="pt-section" id="support">
        <div class="pt-section-head">
            <div>
                <div class="pt-kicker">SUPPORT</div>
                <h2 class="pt-h2">มีทีมช่วยเหลือภาษาไทย</h2>
            </div>
        </div>
        <div class="pt-support-grid">
            <a href="{{ !empty($setting->setting_idLine) ? $setting->setting_idLine : 'https://lin.ee/pCT4DqS' }}" target="_blank" rel="noopener noreferrer" class="pt-support-card pt-support-link">
                <div class="pt-trust-icon"><i data-lucide="message-circle"></i></div>
                <h3>LINE</h3>
                <p>ติดต่อทีมซัพพอร์ตผ่าน LINE Official</p>
            </a>
            <a href="tel:{{ !empty($setting->setting_telContact) ? $setting->setting_telContact : '0958857585' }}" class="pt-support-card pt-support-link">
                <div class="pt-trust-icon"><i data-lucide="phone"></i></div>
                <h3>โทรศัพท์</h3>
                <p>สอบถามข้อมูลสินค้าและการใช้งาน</p>
            </a>
            <a href="{{ !empty($setting->setting_remoteLink) ? $setting->setting_remoteLink : 'https://lin.ee/pCT4DqS' }}" target="_blank" rel="noopener noreferrer" class="pt-support-card pt-support-link">
    <div class="pt-trust-icon"><i data-lucide="monitor-up"></i></div>
    <h3>Remote</h3>
    <p>ช่วยตรวจสอบปัญหาการติดตั้งผ่านรีโมต</p>
</a>
            <a href="mailto:{{ !empty($setting->setting_emailContact) ? $setting->setting_emailContact : 'contact@pt-cad.com' }}" class="pt-support-card pt-support-link">
                <div class="pt-trust-icon"><i data-lucide="mail"></i></div>
                <h3>Email</h3>
                <p>ส่งคำถามหรือเอกสารให้ทีมงานตรวจสอบ</p>
            </a>
        </div>
    </section>

</div>

<script>
function toggleFaq(el) {
    el.classList.toggle('open');
}
</script>

@endsection