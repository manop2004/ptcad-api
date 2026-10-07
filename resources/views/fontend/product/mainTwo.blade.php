@extends('layouts.temp_user')

@section('og_site_name'){{ $og_site_name }}@endsection
@section('og_keywords'){{ $og_keywords }}@endsection
@section('og_title'){{ $og_title }}@endsection
@section('title'){{ $og_title }} |@endsection
@section('og_description'){{ $og_description }}@endsection
@section('og_url'){{ $og_url }}@endsection
@section('og_image'){{ $og_image }}@endsection

@section('og:id')<meta property="product:id" content="{{ $data['pro_sku'] }}">@endsection
@section('product:brand')<meta property="product:brand" content="{{ $data['pro_brand'] }}">@endsection
@section('product:availability')<meta property="product:availability" content="{{ $data['availability'] }}">@endsection
@section('product:condition')<meta property="product:condition" content="new">@endsection
@section('product:price:amount')<meta property="product:price:amount" content="{{ $data['og_price'] }}">@endsection
@section('product:price:currency')<meta property="product:price:currency" content="THB">@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('assets/fontend/hax_theme/product.css?v=2') }}" type="text/css" />
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Noto+Sans+Thai:wght@400;500;600;700;800&display=swap');

/* ===================================================================
   PTCAD THEME OVERLAY v2 — product detail page (multi-option variant)
   Scoped to .pt-pd-wrap; overrides EXISTING class names via !important.
   NOTHING in the HTML/JS is renamed or moved — same overlay-only rule
   as the rest of the site (JS reads .js-thumb/.js-main/.btn-option/
   #b-cart/#b-cart-m by exact class/id, so structure stays untouched).
   =================================================================== */
.pt-pd-wrap{
  --navy:#12358f; --blue:#1765ff; --ink:#0b1f4d; --muted:#667085; --line:#e6edf8;
  --soft:#f6f9ff; --green:#20b26b; --shadow:0 18px 50px rgba(20,53,143,.10);
  font-family:'Poppins','Noto Sans Thai',system-ui,sans-serif;
  color:var(--ink);
  max-width:1400px;margin:24px auto 60px;padding:0 24px;
}
.pt-pd-wrap *{box-sizing:border-box}
.pt-pd-wrap .cover-contentpddetail{background:transparent}

.txt-path-page{max-width:1400px;margin:18px auto 0;padding:0 24px !important;font-size:13px;color:var(--muted)!important}
.txt-path-page a.mg-r-txtpage{color:var(--muted)!important}
.txt-path-page a.mg-r-txtpage:hover{color:var(--blue)!important}
.txt-path-page .mg-r-txtpage-active{color:var(--navy)!important;font-weight:700}

.pt-pd-wrap .sub-top-contentpddetail{
  display:grid !important;
  grid-template-columns: 420px minmax(0,1fr) 340px !important;
  gap:28px !important;
  align-items:start !important;
  background:radial-gradient(circle at 85% 15%,rgba(143,211,255,.30),transparent 32%),
             linear-gradient(105deg,#ffffff 0%,#f6f9ff 55%,#eaf3ff 100%) !important;
  border-radius:28px !important;
  padding:32px !important;
  box-shadow:var(--shadow) !important;
  float:none !important;
}
.pt-pd-wrap .sub-top-contentpddetail0-left,
.pt-pd-wrap .sub-top-contentpddetail0-cent,
.pt-pd-wrap .sub-top-contentpddetail0-right{
  float:none !important;width:auto !important;
}

.pt-pd-wrap .sub-contentleft0003{
  border:1px solid var(--line);border-radius:22px;background:#fff;overflow:hidden;
  box-shadow:0 12px 30px rgba(20,53,143,.08);display:flex;align-items:center;justify-content:center;
  min-height:340px;
}
.pt-pd-wrap .sub-contentleft0003 img{max-width:100%;max-height:340px;object-fit:contain}
.pt-pd-wrap .sub-contentleft0001{display:flex !important;gap:10px !important;margin-top:14px !important;flex-wrap:wrap}
.pt-pd-wrap .cardimg-small{
  border:1.5px solid var(--line)!important;border-radius:14px!important;background:#fff!important;
  overflow:hidden;width:64px;height:64px;display:flex;align-items:center;justify-content:center;cursor:pointer;
  transition:.15s ease;float:none!important;
}
.pt-pd-wrap .cardimg-small img{max-width:100%;max-height:100%;object-fit:contain}
.pt-pd-wrap .cardimg-small:hover{border-color:#bcd8ff!important}
.pt-pd-wrap .cardimg-small-active,.pt-pd-wrap .cardimg-small.cardimg-small-active{border:2px solid var(--blue)!important}

.pt-pd-wrap .sub-contentleft000401{color:var(--blue)!important;font-weight:800!important;font-size:13px!important;text-transform:uppercase;letter-spacing:.4px;margin-bottom:6px}
.pt-pd-wrap .sub-contentleft000403{font-size:26px!important;font-weight:800!important;color:var(--navy)!important;letter-spacing:-.5px;line-height:1.3}
.pt-pd-wrap .sub-contentleft000404{display:inline-block;vertical-align:middle}
.pt-pd-wrap .sub-contentleft000406{width:26px;height:26px}
.pt-pd-wrap .sub-contentleft000407{color:var(--muted)!important;font-size:13px!important;margin-top:8px}
.pt-pd-wrap .flex-discount{margin-top:0}
.pt-pd-wrap .sub-contentleft000408{font-size:30px!important;font-weight:800!important;color:var(--blue)!important;letter-spacing:-.5px}
.pt-pd-wrap .mini-head-sub{display:flex;align-items:center;gap:10px;margin-top:10px;flex-wrap:wrap}
.pt-pd-wrap .btn_none_vat{background:#fff!important;color:var(--muted)!important;border-radius:999px!important;padding:5px 13px!important;font-size:12px!important;display:inline-block;border:1px solid var(--line)!important}

/* ===== กล่อง highlight ครอบราคา+VAT — ให้ดูเป็น "กล่องราคา" แยกจากข้อความรอบๆ ไม่ใช่แค่บรรทัดเรียงต่อกัน ===== */
.pt-pd-wrap .pt-price-box{
  background:linear-gradient(135deg,var(--soft),#eaf3ff)!important;
  border:1px solid #dbeafe!important;
  border-radius:16px!important;
  padding:16px 20px!important;
  margin-top:12px!important;
  display:inline-block;
  width:100%;
}
.pt-pd-wrap .btn_status_p{border-radius:999px!important;padding:5px 13px!important;font-size:12px!important;font-weight:700!important;color:#fff!important;display:inline-block}
.pt-pd-wrap .btn_edit{background:var(--soft)!important;color:var(--blue)!important;border-radius:999px!important;padding:5px 13px!important;font-size:12px!important;font-weight:700!important}

.pt-pd-wrap .sub-contentleft0005{margin-top:24px}
.pt-pd-wrap .coverboxwithline,.pt-pd-wrap .coverboxwithhountline{border-top:1px solid var(--line)!important;padding:16px 0!important;float:none!important}
.pt-pd-wrap .txt-hdboxwithline{font-weight:800!important;color:var(--navy)!important;font-size:14px!important;margin-bottom:8px}
.pt-pd-wrap .txt-subboxnoline{color:var(--muted)!important;font-size:14px!important;line-height:1.75!important;max-height:66px;overflow:hidden;transition:max-height .25s ease}
.pt-pd-wrap .txt-subboxnoline.expanded{max-height:2000px}
.pt-pd-wrap .txt-subboxwithline{color:var(--blue)!important;font-weight:700!important;font-size:13px!important;margin-top:8px!important;cursor:pointer;display:inline-flex;align-items:center;gap:4px}
.pt-pd-wrap .coverboxwithline a{color:var(--blue)!important;font-weight:700!important;font-size:13px!important}
.pt-pd-wrap .btu-boxwithline{
  display:flex!important;align-items:center;justify-content:space-between;gap:10px;
  border:1px solid var(--line)!important;border-radius:14px!important;padding:12px 16px!important;
  background:#fff!important;margin-top:8px;text-decoration:none;
}
.pt-pd-wrap .sub-contentleft000501{color:var(--navy)!important;font-weight:700!important;font-size:13.5px!important}
.pt-pd-wrap .sub-contentleft000503{width:16px;height:16px}

.pt-pd-wrap .covercard-rightwh{
  background:#fff!important;border:1px solid var(--line)!important;border-radius:22px!important;
  padding:24px!important;box-shadow:0 14px 36px rgba(20,53,143,.10)!important;float:none!important;
}
.pt-pd-wrap .covertop-rightktwh{border-bottom:1px dashed var(--line)!important;padding-bottom:18px!important;margin-bottom:18px}
.pt-pd-wrap .sub-contentleft0006{font-weight:800!important;color:var(--navy)!important;font-size:15px!important;margin-bottom:12px!important}

.pt-pd-wrap .btn-option{
  border:1.5px solid var(--line)!important;
  color:#344054!important;
  border-radius:999px!important;
  padding:9px 18px!important;
  margin:0 8px 8px 0!important;
  background:#fff!important;
  font-weight:700!important;
  font-size:13.5px!important;
  cursor:pointer;
  transition:.15s ease;
  float:none!important;
}
.pt-pd-wrap .btn-option:hover{border-color:#bcd8ff!important}
.pt-pd-wrap .btn-option[style*="rgb(23, 101, 255)"]{
  border-color:var(--blue)!important;
  color:#fff!important;
  background:linear-gradient(135deg,var(--blue),#0d57df)!important;
}
.pt-pd-wrap .option-product-input{color:var(--ink)!important;font-size:13.5px!important;margin-top:14px!important;line-height:1.7;background:var(--soft)!important;padding:10px 14px!important;border-radius:10px!important}
.pt-pd-wrap .option-product-subtitle{color:var(--navy)!important;font-weight:700!important}

/* ===== License card แบบใหม่ (มีคำอธิบาย + radio indicator ทางขวา) ===== */
.pt-pd-wrap .pt-license-list{display:flex;flex-direction:column;gap:12px}
.pt-pd-wrap .pt-license-card{
  display:flex!important;align-items:center;justify-content:space-between;gap:12px;
  border:1.5px solid var(--line)!important;border-radius:14px!important;padding:14px 16px!important;
  cursor:pointer;transition:.15s ease;background:#fff!important;position:relative;
}
.pt-pd-wrap .pt-license-card:hover{border-color:#bcd8ff!important}
.pt-pd-wrap .pt-license-card-text{display:flex;flex-direction:column;gap:3px}
.pt-pd-wrap .pt-license-card-text strong{color:var(--navy)!important;font-size:14.5px!important;font-weight:800!important}
.pt-pd-wrap .pt-license-card-text span{color:var(--muted)!important;font-size:12px!important;line-height:1.5}

/* input ตัวจริงยังคลิกได้เหมือนเดิม แค่ย่อให้เป็นวงกลม radio ทางขวา */
.pt-pd-wrap .pt-license-input{
  -webkit-appearance:none;appearance:none;
  width:20px!important;height:20px!important;border-radius:50%!important;
  border:2px solid var(--line)!important;background:#fff!important;flex:none!important;
  padding:0!important;margin:0!important;font-size:0!important;cursor:pointer;
}
.pt-pd-wrap .pt-license-input:hover{border-color:#bcd8ff!important}

/* เลือกอยู่ (เช็คจาก inline style ที่ JS ตั้งไว้ ผ่าน :has — ครอบทั้ง card ให้ขอบ+พื้นเปลี่ยนด้วย) */
.pt-pd-wrap .pt-license-card:has(.pt-license-input[style*="rgb(23, 101, 255)"]){
  border-color:var(--blue)!important;background:var(--soft)!important;
}
.pt-pd-wrap .pt-license-input[style*="rgb(23, 101, 255)"]{
  border-color:var(--blue)!important;background:var(--blue)!important;
  box-shadow:inset 0 0 0 3px #fff!important;
}

/* ===== [แก้ใหม่] ซ่อน div เปล่าๆ ที่คั่นระหว่างตัวเลือกกับช่องจำนวน (มือถือ) ===== */
/* ปัญหา: มี <div class="sub-contentleft0007"></div> ว่างๆ 2 อัน ทำให้เกิดพื้นที่ขาวเยอะเกินไป */
/* ใช้ :empty เจาะเฉพาะตัวที่ไม่มีเนื้อหาข้างใน ไม่กระทบตัวที่มีช่องจำนวนจริงอยู่ */
.pt-pd-wrap .sub-contentleft0007:empty{
  display:none !important;
  margin:0 !important;
}

.pt-pd-wrap .sub-contentleft0007{margin-top:18px}
.pt-pd-wrap .sub-contentleft000701{color:var(--muted)!important;font-size:13px!important;font-weight:700!important;margin-bottom:10px!important}
.pt-pd-wrap .quantity{
  border:1px solid var(--line)!important;border-radius:12px!important;overflow:hidden!important;
  display:inline-flex!important;align-items:center!important;background:#fff!important;float:none!important;
}
.pt-pd-wrap .quantity .qty{border:none!important;text-align:center!important;width:52px!important;font-weight:800!important;color:var(--ink)!important;background:transparent!important}
.pt-pd-wrap .minus,.pt-pd-wrap .plus{background:#fff!important;border:none!important;width:40px!important;height:40px!important;cursor:pointer}
.pt-pd-wrap .minus:hover,.pt-pd-wrap .plus:hover{background:var(--soft)!important}

.pt-pd-wrap .sub-contentleft0008{margin-top:20px;display:flex;flex-direction:column;gap:10px}
.pt-pd-wrap .sub-contentleft000801,.pt-pd-wrap .b-cart-one,.pt-pd-wrap .b-carttwo{
  background:linear-gradient(135deg,var(--blue),#0d57df)!important;color:#fff!important;border:none!important;
  border-radius:12px!important;font-weight:800!important;box-shadow:0 12px 24px rgba(23,101,255,.24)!important;
  height:50px!important;display:flex!important;align-items:center!important;justify-content:center!important;gap:10px!important;
  width:100%!important;cursor:pointer;transition:.15s ease;float:none!important;
}
.pt-pd-wrap .sub-contentleft000801:hover,.pt-pd-wrap .b-cart-one:hover,.pt-pd-wrap .b-carttwo:hover{
  transform:translateY(-2px);box-shadow:0 16px 30px rgba(23,101,255,.32)!important;
}
.pt-pd-wrap .sub-contentleft000802{width:20px;height:20px;filter:brightness(0) invert(1)}
.pt-pd-wrap .sub-contentleft000803{color:#fff!important;font-weight:800!important;font-size:15px!important}
.pt-pd-wrap .sub-contentleft000804{
  border:1.5px solid var(--blue)!important;color:var(--blue)!important;border-radius:12px!important;font-weight:800!important;
  text-align:center!important;background:#fff!important;cursor:pointer;height:50px!important;
  display:flex!important;align-items:center!important;justify-content:center!important;transition:.15s ease;width:100%!important;
}
.pt-pd-wrap .sub-contentleft000804:hover{background:var(--soft)!important}

.order-hint{
  margin-top:10px!important;margin-bottom:0!important;padding:12px 14px!important;
  border:1px dashed #bcd8ff!important;background:var(--soft)!important;border-radius:12px!important;
  font-size:12.5px!important;line-height:1.55!important;color:var(--navy)!important;
}
.order-hint a{color:var(--blue)!important;font-weight:700!important;text-decoration:underline}
.order-hint .max{margin-top:6px!important;color:#b42318!important;font-weight:700!important}

.pt-pd-wrap .sub-mid-contentpddetail{margin-top:36px}
.pt-pd-wrap .coverdex3box{
  display:flex!important;justify-content:flex-start!important;gap:8px!important;flex-wrap:wrap!important;border-bottom:1px solid var(--line)!important;
  margin-bottom:24px!important;padding-bottom:0!important;margin-left:0!important;width:100%!important;
}
.pt-pd-wrap .desbox00{
  padding:11px 20px!important;color:var(--muted)!important;font-weight:700!important;font-size:14px!important;
  cursor:pointer;border-radius:999px 999px 0 0!important;border-bottom:3px solid transparent!important;
  background:transparent!important;transition:.15s ease;
}
.pt-pd-wrap .desbox00:hover{color:var(--blue)!important}
.pt-pd-wrap .desbox00.txtgreenactive{color:var(--blue)!important;border-bottom-color:var(--blue)!important;background:var(--soft)!important}
.pt-pd-wrap .destxtbox00{font-size:20px!important;font-weight:800!important;color:var(--navy)!important;margin-bottom:16px!important}
.pt-pd-wrap .des-pddetail01{background:#fff!important;border:1px solid var(--line)!important;border-radius:22px!important;padding:28px!important;box-shadow:var(--shadow)!important}
.pt-pd-wrap .subdes-pddetail0101{color:#344054;line-height:1.8;font-size:14.5px}
.pt-pd-wrap .subdes-pddetail0103{margin-top:14px}
.pt-pd-wrap .destxtbox00{font-size:20px!important;font-weight:800!important;color:var(--navy)!important;margin-bottom:16px!important;text-align:left!important}
.pt-pd-wrap .subdes-pddetail0101{text-align:left!important}
.pt-pd-wrap .subdes-pddetail0101 *{text-align:left!important}
/* [แก้ใหม่] ไม่ต้องมีปุ่ม "แสดงเพิ่มเติม/ย่อ" อีกแล้ว โชว์เนื้อหาเต็มตลอด — ซ่อนปุ่มด้วย CSS
   (ไม่ลบ HTML/JS ออก เพื่อไม่กระทบ event listener เดิม แค่ทำให้กดไม่ได้และไม่โชว์ให้เห็น) */
.pt-pd-wrap .subdes-pddetail0103{display:none!important}
.pt-pd-wrap .table-responsive table{border-radius:14px;overflow:hidden}
.pt-pd-wrap .table-head{background:var(--soft)!important;color:var(--navy)!important;font-weight:700!important;width:220px}
.pt-pd-wrap .table-detail{color:#344054}

.pt-pd-wrap .review-summary{
  display:flex!important;gap:34px!important;align-items:center!important;flex-wrap:wrap!important;
  margin-bottom:24px!important;background:var(--soft)!important;border-radius:20px!important;padding:24px!important;
}
.pt-pd-wrap .rating-score h2{color:var(--navy)!important;margin:0 0 6px!important;font-size:28px!important}
.pt-pd-wrap .rating-score p{color:var(--muted)!important;font-size:13px!important;margin:6px 0 0}
.pt-pd-wrap .full-star,.pt-pd-wrap .half-star{color:#f5a400!important}
.pt-pd-wrap .empty-star{color:#d8dee8!important}
.pt-pd-wrap .review-distribution{flex:1;min-width:220px;display:grid;gap:6px}
.pt-pd-wrap .review-bar{display:flex;align-items:center;gap:10px;font-size:12.5px;color:var(--muted)}
.pt-pd-wrap .review-bar .bar{flex:1;height:8px;background:#e6edf8;border-radius:999px;overflow:hidden}
.pt-pd-wrap .review-bar .fill{height:100%;background:var(--blue);border-radius:999px}
.pt-pd-wrap .review-item{
  border:1px solid var(--line)!important;border-radius:18px!important;box-shadow:none!important;
  padding:18px!important;background:#fff!important;
}
.pt-pd-wrap .review-header strong{color:var(--navy)}
.pt-pd-wrap .review-thumbnail{border-radius:12px}

.pt-pd-wrap .dg-listpd-extart{margin-top:48px}
.pt-pd-wrap .boxheadname{margin-bottom:18px}
.pt-pd-wrap .txt-head-pd{font-size:22px!important;font-weight:800!important;color:var(--navy)!important;letter-spacing:-.3px}
.pt-pd-wrap .dg-listpd{
  display:grid!important;grid-template-columns:repeat(4,minmax(0,1fr))!important;gap:20px!important;
}
.pt-pd-wrap .boxproduct{
  background:#fff!important;border:1px solid var(--line)!important;border-radius:20px!important;overflow:hidden!important;
  box-shadow:0 10px 28px rgba(20,53,143,.06)!important;padding-bottom:16px!important;float:none!important;
  transition:.2s ease;
}
.pt-pd-wrap .boxproduct:hover{transform:translateY(-4px);box-shadow:0 18px 40px rgba(20,53,143,.12)!important}
.pt-pd-wrap .h-pic-product{display:flex;align-items:center;justify-content:center;background:var(--soft);height:160px;overflow:hidden}
.pt-pd-wrap .size-product{max-width:100%;max-height:100%;object-fit:contain}
.pt-pd-wrap .h-pic-product{display:flex;align-items:center;justify-content:center;background:var(--soft);height:200px;overflow:hidden;max-width:220px;margin:0 auto}
.pt-pd-wrap .text-green-product{color:var(--blue)!important;font-size:12px!important;font-weight:700!important;padding:0 14px;display:block;margin-top:12px}
.pt-pd-wrap .name-product{color:var(--navy)!important;font-weight:700!important;font-size:14.5px!important;padding:0 14px;line-height:1.4}
.pt-pd-wrap .price-group-bottom{padding:0 14px;margin-top:6px}
.pt-pd-wrap .price-product{color:var(--blue)!important;font-weight:800!important;font-size:19px!important}
.pt-pd-wrap .discript-product{color:var(--muted)!important;font-size:11.5px!important;margin-top:2px}
.pt-pd-wrap .btn-buy{
  display:flex!important;align-items:center!important;justify-content:center!important;
  text-align:center!important;margin:12px 0 0!important;height:42px!important;
  background:linear-gradient(135deg,var(--blue),#0d57df)!important;color:#fff!important;padding:0 11px!important;
  border-radius:10px!important;font-weight:700!important;font-size:13.5px!important;line-height:1!important;
  transition:.15s ease;box-sizing:border-box!important;
}
.pt-pd-wrap .btn-buy:hover{transform:translateY(-1px)}

@media (max-width:1100px){
  .pt-pd-wrap .sub-top-contentpddetail{grid-template-columns:1fr !important}
  .pt-pd-wrap .dg-listpd{grid-template-columns:repeat(2,minmax(0,1fr))!important}
}
@media (max-width:900px){
  .pt-pd-wrap{padding:0 16px}
}
/* ===== [แก้ใหม่] จอมือถือแคบมาก: การ์ดสินค้าที่เกี่ยวข้องเรียง 1 คอลัมน์ ไม่ให้บี้แน่นเกินไป ===== */
@media (max-width:480px){
  .pt-pd-wrap .dg-listpd{grid-template-columns:1fr !important}
}
/* ===================================================================
   PTCAD: รีดีไซน์ Tab "รายละเอียดสินค้า / คุณสมบัติ / รีวิว" ให้ทันสมัยแบบ Shopee
   (ใช้สี hex ตรงๆ ไม่พึ่ง var(--blue) เพราะ section นี้อาจอยู่นอกขอบเขต .pt-pd-wrap)
=================================================================== */
.cover-contentpddetail{
    max-width:1400px;margin:0 auto 60px;padding:0 24px;box-sizing:border-box;
    font-family:'Poppins','Noto Sans Thai',system-ui,sans-serif;
}
.coverdex3box{
    display:flex !important;gap:8px;border-bottom:1px solid #e6edf8 !important;
    margin-bottom:0 !important;background:transparent !important;overflow-x:auto;
}
.desbox00{
    padding:16px 22px !important;font-weight:700 !important;font-size:15px !important;
    color:#667085 !important;cursor:pointer;white-space:nowrap;
    border:none !important;background:transparent !important;
    border-bottom:3px solid transparent !important;transition:.15s ease;
}
.desbox00:hover{color:#1765ff !important}
.desbox00.txtgreenactive{
    color:#1765ff !important;border-bottom-color:#1765ff !important;background:transparent !important;
}
.coverdes-pddetail01{
    background:#fff;border:1px solid #e6edf8;border-radius:0 0 16px 16px;padding:28px;
    box-shadow:0 12px 34px rgba(20,53,143,.05);
}
.destxtbox00{
    font-size:18px !important;font-weight:800 !important;color:#12358f !important;
    margin-bottom:16px !important;padding-bottom:0 !important;border-bottom:none !important;
}

/* สรุปคะแนนรีวิว */
.review-summary{
    display:flex;gap:40px;align-items:center;flex-wrap:wrap;
    background:#f6f9ff;border-radius:16px;padding:24px;margin-bottom:24px;
}
.rating-score{text-align:center;flex:none}
.rating-score h2{font-size:36px;font-weight:800;color:#1765ff;margin:0 0 6px}
.rating-score .stars i{color:#f5a400;font-size:16px;margin:0 1px}
.rating-score p{color:#667085;font-size:13px;margin:8px 0 0}
.review-distribution{flex:1;min-width:220px;display:flex;flex-direction:column;gap:6px}
.review-bar{display:flex;align-items:center;gap:10px;font-size:13px;color:#344054}
.review-bar .bar{flex:1;height:8px;background:#e6edf8;border-radius:999px;overflow:hidden}
.review-bar .bar .fill{height:100%;background:#1765ff;border-radius:999px}

/* รายการรีวิวแต่ละอัน */
.review-item{
    border:1px solid #e6edf8 !important;border-radius:14px !important;
    box-shadow:0 6px 18px rgba(20,53,143,.04) !important;padding:18px !important;
}
.review-header strong{color:#12358f;font-weight:700;font-size:14px}
.review-stars i{font-size:13px}
.review-text{color:#344054;font-size:14px;line-height:1.7;margin:10px 0}
.review-thumbnail{border-radius:10px;width:80px;height:80px;object-fit:cover}

/* [PATCH v4] คืนค่าการกดสลับแท็บแบบปกติ (ไม่ซ่อน .coverdex3box แล้ว) */

.coverdes-pddetail01{
    background:transparent !important;border:none !important;box-shadow:none !important;padding:0 !important;
    margin-bottom:24px !important;
}
.des-pddetail01{
    background:#fff !important;border:1px solid #e6edf8 !important;border-radius:18px !important;
    padding:28px !important;box-shadow:0 10px 28px rgba(20,53,143,.06) !important;
    border-left:4px solid #1765ff !important;
}
.destxtbox00{
    font-size:17px !important;font-weight:800 !important;color:#12358f !important;
    margin-bottom:14px !important;display:flex !important;align-items:center;gap:10px;
}
.destxtbox00:before{
    content:'';width:8px;height:8px;border-radius:50%;background:#1765ff;flex:none;
}
@media (max-width:600px){
    .desbox00{padding:12px 14px !important;font-size:13px !important}
    .coverdes-pddetail01{padding:18px}
    .review-summary{gap:20px}
}

/* ===== ปุ่ม "ซื้อเลย" ===== */
.pt-buynow-btn img{display:none !important} /* ไม่มีไอคอนตะกร้า ใช้แค่ข้อความ */

/* ===================================================================
   PTCAD THEME OVERLAY v3 — จัดหน้าใหม่ให้เป็น 2 คอลัมน์แบบเดียวกับ
   ดีไซน์อ้างอิง: รูปสินค้าอยู่ซ้าย / ข้อมูล+ตัวเลือก+ปุ่ม ไหลเป็นคอลัมน์
   เดียวทางขวา (ไม่มีกล่องการ์ดแยก, ราคาแสดงตรงๆ ไม่มีกล่อง)
   ยังคง overlay-only: ไม่แตะ/เปลี่ยนชื่อ class หรือ JS ใดๆ เลย
   =================================================================== */
.pt-pd-wrap .sub-top-contentpddetail{
  background:
    radial-gradient(circle at 88% 8%,rgba(23,101,255,.16),transparent 40%),
    linear-gradient(160deg,#ffffff 0%,#f6f9ff 60%,#eef4ff 100%) !important;
  border-radius:28px !important;
  box-shadow:0 20px 46px rgba(20,53,143,.12) !important;
}
@media (min-width:1101px){
  .pt-pd-wrap .sub-top-contentpddetail{
    grid-template-columns: 460px minmax(0,1fr) !important;
    grid-template-areas: "left cent" "left right" !important;
    row-gap:0 !important;
  }
  .pt-pd-wrap .sub-top-contentpddetail0-left{grid-area:left !important}
  .pt-pd-wrap .sub-top-contentpddetail0-cent{grid-area:cent !important}
  .pt-pd-wrap .sub-top-contentpddetail0-right{grid-area:right !important;align-self:start !important}
}
@media (max-width:1100px){
  .pt-pd-wrap .sub-top-contentpddetail{
    grid-template-areas:"cent" "right" "left" !important;
    padding:24px 20px !important;
  }
  .pt-pd-wrap .sub-top-contentpddetail0-cent{margin-top:0 !important}
  .pt-pd-wrap .sub-top-contentpddetail0-right{margin-top:22px !important}
  .pt-pd-wrap .sub-top-contentpddetail0-left{margin-top:22px !important}
}

/* กรอบรูปสินค้าหลัก: ให้มีพื้นหลังฟ้าอ่อนคลุมอยู่เสมอ ไม่ใช่แค่กรอบขาวเฉยๆ */
.pt-pd-wrap .sub-contentleft0003{
  background:radial-gradient(circle at 50% 30%,#eaf3ff,#f6f9ff) !important;
  border-color:#dbeafe !important;
}
.pt-pd-wrap .sub-contentleft0001{margin-top:16px !important}

/* badge เหนือชื่อสินค้า เช่น "Digital License · CAD Software" แทนที่แบรนด์เดิม */
.pt-pd-wrap .sub-contentleft000401{
  display:inline-flex!important;align-items:center;gap:6px;
  text-transform:none!important;letter-spacing:0!important;
  background:var(--soft)!important;color:var(--blue)!important;
  border-radius:999px!important;padding:5px 12px!important;font-size:12.5px!important;
  margin-bottom:14px!important;
}
.pt-pd-wrap .sub-contentleft000401:not(:empty)::before{content:"\2713";font-weight:800}

.pt-pd-wrap .sub-contentleft000403{font-size:34px!important;line-height:1.2!important;margin-bottom:6px}

/* ป้าย feature/condition สั้นๆ (pro_codition) แบบ pill สีอ่อน */
.pt-pd-wrap .pt-feature-pills{display:flex;flex-wrap:wrap;gap:8px;margin:14px 0 20px}
.pt-pd-wrap .pt-feature-pill{
  background:var(--soft)!important;color:var(--navy)!important;font-weight:700!important;
  font-size:12.5px!important;padding:6px 14px!important;border-radius:999px!important;
}

/* ราคาแบบ flat ไม่มีกล่อง ให้เหมือนดีไซน์อ้างอิง */
.pt-pd-wrap .pt-price-box{
  background:transparent!important;border:none!important;padding:0!important;
  margin-top:4px!important;width:auto;display:block;
}
.pt-pd-wrap .sub-contentleft000408{font-size:34px!important}
.pt-pd-wrap .mini-head-sub{margin-top:6px!important}
.pt-pd-wrap .btn_none_vat{background:transparent!important;border:none!important;padding:0!important;font-size:12.5px!important}

/* คำอธิบายสั้นใต้ชื่อสินค้า: ซ่อนหัวข้อ/เส้นคั่น/ปุ่มแสดงเพิ่มเติม แสดงแค่ 2 บรรทัดสั้นๆ */
.pt-pd-wrap .sub-contentleft0005 .coverboxwithline:first-child{
  border-top:none!important;padding-top:0!important;padding-bottom:0!important;order:-1;
}
.pt-pd-wrap .sub-contentleft0005 .coverboxwithline:first-child .txt-hdboxwithline{display:none!important}
.pt-pd-wrap .sub-contentleft0005 .coverboxwithline:first-child .txt-subboxwithline{display:none!important}
.pt-pd-wrap .sub-contentleft0005 .coverboxwithline:first-child .txt-subboxnoline{
  max-height:none!important;overflow:visible!important;
  display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden!important;
  font-size:15px!important;color:var(--muted)!important;margin-bottom:18px!important;
}
.pt-pd-wrap .sub-contentleft0005{display:flex;flex-direction:column;margin-top:0!important}

/* กล่องขวา (เลือก license / จำนวน / ปุ่ม) ไหลเป็นเนื้อเดียวกับคอลัมน์ ไม่มีกรอบการ์ดซ้อน */
.pt-pd-wrap .covercard-rightwh{
  background:transparent!important;border:none!important;box-shadow:none!important;padding:0!important;
  margin-top:8px!important;
}
.pt-pd-wrap .covertop-rightktwh{border-bottom:none!important;padding-bottom:0!important;margin-bottom:0!important}
.pt-pd-wrap .sub-contentleft0006{font-size:13.5px!important;color:var(--muted)!important;text-transform:uppercase;letter-spacing:.3px;margin-bottom:14px!important}

/* จำนวน License: label ซ้าย + ตัวปรับจำนวนขวา อยู่แถวเดียวกัน */
.pt-pd-wrap .sub-contentleft0007{
  display:flex!important;align-items:center!important;justify-content:space-between!important;
  margin-top:22px!important;padding-top:18px!important;border-top:1px solid var(--line)!important;
}
.pt-pd-wrap .sub-contentleft000701{margin-bottom:0!important}

/* แถวปุ่มด้านล่าง: ตะกร้า/ซื้อเลย ขึ้นแถวเต็มความกว้างเสมอ (เป็น action หลัก)
   ส่วนปุ่ม "ขอใบเสนอราคา" เป็น secondary วางแถวเดียวกับปุ่มก่อนหน้าถ้าที่พอ */
.pt-pd-wrap .sub-contentleft0008{
  display:grid!important;grid-template-columns:1fr 1fr!important;gap:10px!important;margin-top:18px!important;
}
.pt-pd-wrap .sub-contentleft0008 > button{min-width:0!important}
.pt-pd-wrap .sub-contentleft0008 > div.sub-contentleft000804{
  grid-column:1 / -1!important;min-width:0!important;
}
.pt-pd-wrap .sub-contentleft000801,.pt-pd-wrap .b-cart-one,.pt-pd-wrap .b-carttwo{height:52px!important;border-radius:12px!important}
.pt-pd-wrap .sub-contentleft000804{height:48px!important;border-radius:12px!important;font-size:14px!important}

/* ===================================================================
   PTCAD PATCH v4 — compact license pills, Shopee-style action buttons,
   installment moved up next to the price, real click-tabs restored
   =================================================================== */

/* [PATCH v6] License กลับไปเป็นการ์ดเต็มความกว้าง + วงกลม radio ทางขวา ตามดีไซน์ต้นฉบับ
   (ยกเลิกการบีบเป็นปุ่มพิลล์ของ v4 ทั้งหมด — ใช้ .pt-license-card/.pt-license-input
   ที่นิยามไว้ใน "License card แบบใหม่" ด้านบนตามเดิม ไม่ต้อง override อะไรเพิ่ม) */

/* --- installment: small pill badge next to the price, instead of its own full-width row --- */
.pt-pd-wrap .pt-installment-badge{
  display:inline-flex!important;align-items:center;gap:5px;
  background:var(--soft)!important;color:var(--blue)!important;font-weight:700!important;
  font-size:12px!important;padding:5px 12px!important;border-radius:999px!important;
  text-decoration:none!important;border:1px solid #dbeafe!important;cursor:pointer;
}
.pt-pd-wrap .pt-installment-badge:hover{background:#eaf3ff!important}

/* --- 3 action buttons: cart = outline, buy now = solid, quote = ghost link (tighter, Shopee-style) --- */
.pt-pd-wrap .sub-contentleft0008{gap:8px!important}
.pt-pd-wrap .sub-contentleft000801,.pt-pd-wrap .b-cart-one,.pt-pd-wrap .b-carttwo{
  height:46px!important;border-radius:10px!important;
  background:#fff!important;color:var(--blue)!important;
  border:1.5px solid var(--blue)!important;box-shadow:none!important;font-size:13.5px!important;
}
.pt-pd-wrap .sub-contentleft000801:hover,.pt-pd-wrap .b-cart-one:hover,.pt-pd-wrap .b-carttwo:hover{
  background:var(--soft)!important;box-shadow:none!important;transform:none!important;
}
.pt-pd-wrap .sub-contentleft000802{filter:none!important}
.pt-pd-wrap .sub-contentleft000803{color:var(--blue)!important;font-size:13.5px!important;font-weight:800!important}
.pt-pd-wrap .pt-buynow-btn{
  height:46px!important;border-radius:10px!important;
  background:linear-gradient(135deg,var(--blue),#0d57df)!important;border:none!important;
  box-shadow:0 10px 20px rgba(23,101,255,.24)!important;
}
.pt-pd-wrap .pt-buynow-btn .sub-contentleft000803{color:#fff!important}
.pt-pd-wrap .sub-contentleft000804{height:40px!important;font-size:13px!important;border-radius:10px!important}

/* --- restore real clickable tabs at the bottom (รายละเอียดสินค้า / คุณสมบัติ / รีวิว) --- */
.coverdex3box{display:flex!important}

/* ===================================================================
   PTCAD PATCH v5
   - ปุ่ม "เพิ่มลงตะกร้า" กลับไปเป็นสีน้ำเงินปกติเหมือนปุ่มอื่นๆ (ไม่เอา outline สีขาวแล้ว)
   - แถว "จำนวน" ให้ label กับตัวปรับจำนวนอยู่ชิดกัน แบบช้อปปี้ ไม่กระจายเต็มแถว
   =================================================================== */
.pt-pd-wrap .sub-contentleft000801,.pt-pd-wrap .b-cart-one,.pt-pd-wrap .b-carttwo{
  background:linear-gradient(135deg,var(--blue),#0d57df)!important;
  color:#fff!important;border:none!important;
  box-shadow:0 10px 20px rgba(23,101,255,.24)!important;
}
.pt-pd-wrap .sub-contentleft000801:hover,.pt-pd-wrap .b-cart-one:hover,.pt-pd-wrap .b-carttwo:hover{
  background:linear-gradient(135deg,#0d57df,var(--blue))!important;
}
.pt-pd-wrap .sub-contentleft000802{filter:brightness(0) invert(1)!important}
.pt-pd-wrap .sub-contentleft000803{color:#fff!important}

.pt-pd-wrap .sub-contentleft0007{
  justify-content:flex-start!important;gap:14px!important;
}
.pt-pd-wrap .quantity .qty{width:38px!important}
.pt-pd-wrap .minus,.pt-pd-wrap .plus{width:34px!important;height:34px!important}

/* ===================================================================
   PTCAD PATCH v8
   - "รายละเอียดสินค้า" ด้านล่าง (รวมคุณสมบัติเข้าไปแล้ว) เอากรอบ/เงาออก [คงไว้จาก v7]
   - ยกเลิกดาวในการ์ด "สินค้าที่เกี่ยวข้อง" (เอาออกแล้วย้ายไปไว้ใต้ชื่อสินค้าหลักแทน)
   - คืนค่ากริดการ์ด "สินค้าที่เกี่ยวข้อง" กลับไปเป็นแบบเดิม (4 คอลัมน์คงที่) ไม่ยืดเต็มแถวแล้ว
   - ป้าย "รีวิวสินค้า ★★★★★" ใต้ชื่อสินค้าหลัก (บนสุด ไม่ใช่ในการ์ดที่เกี่ยวข้อง)
   - ถ้าเหลือแท็บเดียว (บางสินค้าไม่มีสเปก/ของแถม) ให้ซ่อนแถบแท็บ โชว์เนื้อหาตรงๆ ไม่ต้องมีปุ่มแท็บลอยเดี่ยวๆ
   =================================================================== */
#des-pdda01 .coverdes-pddetail01.pt-noframe{
  background:transparent!important;border:none!important;box-shadow:none!important;
  border-radius:0!important;padding:0!important;
}
#des-pdda01 .pt-noframe .des-pddetail01{
  background:transparent!important;border:none!important;box-shadow:none!important;
  border-radius:0!important;padding:0!important;
}


.pt-pd-wrap .pt-product-rating{
  display:flex!important;align-items:center;gap:6px;
  font-size:12.5px!important;color:var(--muted)!important;margin:4px 0 2px!important;
}
.pt-pd-wrap .pt-product-rating .pt-stars{color:#f5a400!important;letter-spacing:1px;font-size:12px}

.coverdex3box:has(.desbox00:only-child){display:none!important}

/* ==========================================
   CSS แก้ไขปัญหากรอบล้นบนหน้าจอมือถือ
   ========================================== */
@media (max-width: 768px) {
  /* 1. ป้องกันไม่ให้ Main Wrapper ขยายล้นจอ */
  .pt-pd-wrap, 
  .cover-contentpddetail {
    padding: 0 12px !important;
    overflow-x: hidden !important;
  }

  /* 2. บีบ Padding ของกล่องใหญ่บนมือถือ */
  .pt-pd-wrap .sub-top-contentpddetail {
    padding: 16px !important;
    border-radius: 18px !important;
  }

  /* 3. ปรับการ์ดทางขวาไม่ให้ดันล้นขอบ */
  .pt-pd-wrap .covercard-rightwh {
    padding: 16px !important;
    max-width: 100% !important;
  }

  /* 4. ปรับรูปสินค้าให้ยืดหยุ่นตามหน้าจอ */
  .pt-pd-wrap .sub-contentleft0003 {
    min-height: 240px !important;
    max-width: 100% !important;
  }

  /* 5. ปรับแต่งปุ่ม Floating "ติดต่อสอบถาม" ด้านล่างไม่ให้ล้นออกขวา */
  .pt-pd-wrap [class*="contact"],
  div[class*="fixed"] {
    max-width: calc(100% - 32px) !important;
  }
}
/* ==========================================
   ล็อกเลย์เอาต์มือถือขั้นเด็ดขาด (ป้องกันจอสไลด์ซ้าย-ขวา / กรอบล้น)
   ========================================== */
@media (max-width: 768px) {
    /* 1. ล็อก Body ไม่ให้หน้าจอเลื่อนแนวนอนได้ */
    html, body {
        overflow-x: hidden !important;
        max-width: 100vw !important;
    }

    /* 2. จัดระเบียบ Wrapper หลักให้ขอบซ้าย-ขวาเท่ากัน */
    .pt-pd-wrap {
        padding: 0 16px !important;
        width: 100% !important;
        max-width: 100% !important;
        box-sizing: border-box !important;
        margin: 16px auto !important;
    }

    /* 3. บังคับกล่องสีฟ้าให้เป็น Flex แนวตั้ง (แก้ปัญหา Grid ถ่างขอบ) */
    .pt-pd-wrap .sub-top-contentpddetail {
        display: flex !important;
        flex-direction: column !important;
        width: 100% !important;
        max-width: 100% !important;
        padding: 20px 16px !important; /* ลด padding ให้พอดีจอมือถือ */
        margin: 0 !important;
        box-sizing: border-box !important;
        gap: 16px !important;
    }

    /* 4. เคลียร์ความกว้างของทุกกล่องด้านในให้หดตามจอ */
    .pt-pd-wrap .sub-top-contentpddetail0-left,
    .pt-pd-wrap .sub-top-contentpddetail0-cent,
    .pt-pd-wrap .sub-top-contentpddetail0-right,
    .pt-pd-wrap .covercard-rightwh {
        width: 100% !important;
        max-width: 100% !important;
        min-width: 0 !important; /* บังคับให้เนื้อหาข้างในหดตาม ห้ามดันกรอบ */
        box-sizing: border-box !important;
        padding-left: 16px !important;
        padding-right: 16px !important;
        float: none !important;
    }

    /* 5. ปรับรูปภาพสินค้าให้เล็กลงนิดหน่อย ไม่กินพื้นที่ขอบ */
    .pt-pd-wrap .sub-contentleft0003 {
        min-height: auto !important;
        width: 100% !important;
        max-width: 100% !important;
        padding: 16px !important;
        box-sizing: border-box !important;
    }
    .pt-pd-wrap .sub-contentleft0003 img {
        max-width: 100% !important;
        height: auto !important;
        max-height: 250px !important;
    }
    
    /* 6. ตัวเลือก License ไม่ให้ดันขอบ */
    .pt-pd-wrap .pt-license-card,
    .pt-pd-wrap .sub-contentleft000801,
    .pt-pd-wrap .sub-contentleft000804 {
        width: 100% !important;
        max-width: 100% !important;
        box-sizing: border-box !important;
    }
}
</style>

@endsection

@section('content')

@if (!empty($breadcrumb))
<div class="txt-path-page" style="padding-left: 20px;">
	@foreach ($breadcrumb as $index => $item)
		@if($index !== count($breadcrumb) -1 )
			<a class="mg-r-txtpage" href="{{ $item['route'] }}">{{ $item['name'] }} / </a>
		@else
			<span class="mg-r-txtpage-active">{{ $item['name'] }}</span>
		@endif
	@endforeach
</div>
@endif
@if(!empty($data))
<div class="container-pd-detil pt-pd-wrap">
	<input type="hidden" id="quantity" name="quantity" value="1">
	<input type="hidden" id="min_order" value="{{ !empty($data['min_order']) ? (int)$data['min_order'] : '' }}">
	<input type="hidden" id="max_order" value="{{ !empty($data['max_order']) ? (int)$data['max_order'] : '' }}">
	<input type="hidden" id="detail_check_stock_status" value="{{ $data['detail_check_stock_status'] }}">
	<input type="hidden" id="detail_stock" value="{{ $data['detail_stock'] }}">
	<input id="p_id" name="p_id" type="hidden" value="{{ $data['pro_id'] }}" />
	<input id="p_option" name="p_option" type="hidden" value="2" />
	<input id="p_id_d" name="p_id_d" type="hidden" value="{{ $data['detailId'] }}" />
	<form action="{{ route('fronend.quotation') }}" method="get" class="no-mg" id="quotation-form">
		<input type="hidden" id="_productId" name="productId" value="{{ $data['pro_id'] }}" />
		<input type="hidden" id="_productSku" name="productSku" value="{{ $data['detailSku'] }}" />
		<input type="hidden" id="_productUnit" name="productUnit" value="1" />
		<input type="hidden" id="_ref" name="_ref" @if (!empty($_GET['ref'])) value="{{ $_GET['ref'] }}" @else value="" @endif>
	</form>
	<div class="cover-contentpddetail">
		<div id="swipedivwebsite">
			<div  class="sub-top-contentpddetail" >
				<div class="sub-top-contentpddetail0-left">
					<div class="sub-contentleft0001">
						<div class="cardimg-small cardimg-small-active">
							<img src="{{ $data['pro_cover'] }}" class="sub-contentleft000img js-thumb" alt="Thumbnail">
						</div>
					@if(count($data['pro_image']) > 1)
						@foreach(array_slice($data['pro_image'], 0, 4) as $picture)
						<div class="cardimg-small">
							<img src="{{ $picture['images'] }}" class="sub-contentleft000img js-thumb" alt="Thumbnail">
						</div>
						@endforeach
					@endif
					</div>
					<div class="sub-contentleft0002">
						<div class="sub-contentleft0003">
							<img id="preview-item" src="{{ $data['pro_cover'] }}" class="sub-contentleft000img js-main" alt="Main Image">
						</div>
					</div>
				</div>
				<div class="sub-top-contentpddetail0-cent">
					<div class="sub-contentleft0004">
						<div class="sub-contentleft000401">@if(!empty($data['pro_brand'])){{ $data['pro_brand'] }}@endif</div>
						<div class="sub-contentleft000402">
								<div class="sub-contentleft000403">{{ $data['pro_name'] }}</div>
								<div class="sub-contentleft000404 ">
									<div class="sub-contentleft000405 favheart">
										<input id="local-favourite" type="hidden" value="{{ $data['pro_id'] }}" />
										<button id="b-favorite" class="button-favorite add-favorite choose" data-price='{!! $data['detailPrice'] !!}' data-id="{{ $data['pro_id'] }}" data-name="{{ $data['pro_name'] }}" data-img="{{ $data['pro_cover'] }}" data-parmalink="{{ route('fronend.product.content',$data['pro_permalink']) }}" >
											<img class="sub-contentleft000406" src="{{ asset('icon/ecom/heart2.webp')}}" alt="favorite" >
										</button>
										<button id="n-favorite" class="button-favorite remove-favorite choose hidden" data-id="{{ $data['pro_id'] }}">
											<img class="sub-contentleft000406" src="{{ asset('icon/ecom/heart1.webp')}}" alt="favorite" >
										</button>
									</div>
								</div>
						</div>
						<div class="pt-product-rating">รีวิวสินค้า <span class="pt-stars">★★★★★</span></div>
						<div class="sub-contentleft000407">รหัสสินค้า: @if(!empty($data['pro_sku'])) {{ $data['pro_sku'] }} @else -@endif</div>
						<div class="pt-price-box">
						<div class="flex-discount">
							<div class="sub-contentleft000408">{!! $data['detailPrice'] !!}</div>
						</div>
						<div class="mini-head-sub">
							<span class="btn btn_none_vat" >ราคาไม่รวม VAT</span>
							@if(!empty($data['proInstallment']))
							<a href="javascript:void(0)" data-toggle="modal" data-target="#installment" class="pt-installment-badge">ผ่อนสูงสุด 36 ด. &middot; ดูรายละเอียด</a>
							@endif
							@if(!empty($data['detailStatus']))
								@if(!empty($data['detailStatus']->stu_name))
									<span class="btn btn_status_p" style="background-color: {{ $data['detailStatus']->stu_color }}">
										{{ $data['detailStatus']->stu_name }} @if($data['detailStatus']->stu_preorder == 1) @if(!empty($data['detailStatus']->detail_preorder_day)) ({{ $data['detailStatus']->detail_preorder_day }} วัน) @endif @endif
									</span>
								@endif
							@endif
							@if (Route::has('administrator'))
								@auth
									@php
										$UserLevel = App\Models\UsersLevel::select('l_product_Action','UserId')->where('UserId',Auth::user()->id)->value('l_product_Action');
										if($UserLevel == 1){
											echo '<a href="'.route('product.edit',['tab'=>1,'id' => $data['pro_id']]).'"><span class="btn btn_edit"><i class="icon-edit"></i>  แก้ไขสินค้า</span></a>';
										}
									@endphp
								@endauth
							@endif
						</div>
						</div>
					</div>
					<div class="sub-contentleft0005 ">
						@if(!empty($data['pro_highlight']))
						<div class="coverboxwithline">
							<div class="txt-hdboxwithline" >รายละเอียดสินค้า :</div>
							<div class="des-boxwithline">
							  <div class="txt-subboxnoline">
								  {!! $data['pro_highlight'] !!}
							  </div>
							  <div class="txt-subboxwithline">แสดงเพิ่มเติม</div>
							</div>
						</div>
						@endif
						@if(!empty($data['pro_codition']) || !empty($data['pro_download']))
						<div class="coverboxwithhountline">
							<div class="txt-hdboxwithline">อื่นๆ :</div>
								@if(count($data['pro_codition']) != 0)
									<div class="pt-feature-pills">
									@foreach ($data['pro_codition'] as $item)
										@php
											$conditionLabel = is_array($item) ? ($item['name'] ?? $item['title'] ?? '') : ($item->name ?? $item->title ?? '');
										@endphp
										@if(!empty($conditionLabel))
											<span class="pt-feature-pill">{{ $conditionLabel }}</span>
										@endif
									@endforeach
									</div>
								@endif
								@if(!empty($data['pro_download']))
								<a class="btu-boxwithline" href="{{ asset('storage/product_dowloads/'.$data['pro_download']) }}" download>
									<div class="sub-contentleft000501">ดาวน์โหลดโบว์ชัวร์</div>
									<div class="sub-contentleft000502">
										<img src="/assets/fontend/hax_theme/images/btulinkout.webp" class="sub-contentleft000503" >
									</div>
								</a>
								@endif
						</div>
						@endif
					</div>
				</div>
				<div class="sub-top-contentpddetail0-right">
					<div class="covercard-rightwh">
							<div class="covertop-rightktwh" >
								<div class="sub-contentleft0006">เลือกประเภท License</div>
								<div class="pt-license-list">
									@foreach ($data['proDetail'] as $detail)
										@php
											$licenseDesc = '';
											if (stripos($detail['name'], 'annual') !== false || stripos($detail['name'], 'subscription') !== false) {
												$licenseDesc = 'ใช้งานรายปี เหมาะสำหรับเริ่มต้นและควบคุมงบประมาณ';
											} elseif (stripos($detail['name'], 'perpetual') !== false) {
												$licenseDesc = 'ซื้อขาด เหมาะสำหรับการใช้งานระยะยาว';
											}
										@endphp
										<label class="pt-license-card" for="option_select_{{ $detail['id'] }}">
											<div class="pt-license-card-text">
												<strong>{{ $detail['name'] }}</strong>
												@if(!empty($licenseDesc))<span>{{ $licenseDesc }}</span>@endif
											</div>
											<input type="button" class="btn btn-option option-{{ $detail['id'] }} pt-license-input" name="option_select" id="option_select_{{ $detail['id'] }}" data-id="{{ $detail['id'] }}" value="{{ $detail['name'] }}"  />
										</label>
									@endforeach
								</div>
								<div class="option-product-input">
									@if(!empty($data['detailOther']))
										<span class="option-product-subtitle">รายละเอียด:</span>
										<div id="option-product-detailOther">{{ $data['detailOther'] }}</div>
									@else
										<span class="option-product-subtitle">รายละเอียด:</span>
										<div id="option-product-detailOther">{{ $data['detailName'] }}</div>
									@endif
								</div>
							</div>
							<div class="sub-contentleft0007">
								<div class="sub-contentleft000701">จำนวน :</div>
								<div class="b-quantity">
									<div class="quantity clearfix">
										<button class="minus"><img class="sizeminus" src="/assets/fontend/hax_theme/images/minus.webp"></button>
										<input type="text" id="quantity_desktop" value="1" class="qty">
										<button class="plus"><img class="sizeplus" src="/assets/fontend/hax_theme/images/plus.webp"></button>
									</div>
								</div>
							</div>
							<div id="div_alert_stock_desktop" style="display: none;">
								<span class="text-danger">คุณได้เพิ่มสินค้าครบตามจำนวนสต็อกแล้ว</span>
							</div>
							<div id="order_hint_desktop" class="order-hint" style="display:none;"></div>
							<div class=" sub-contentleft0008">
								<input type="hidden" id="ref" name="ref" @if (!empty($_GET['ref'])) value="{{ $_GET['ref'] }}" @else value="" @endif>
								@php
									$hideAddToCartOnLoad = false;
									if (
										!empty($data['hide_addtocart_status']) &&
										(int)$data['hide_addtocart_status'] === 1 &&
										!empty($data['detail_price_sale_status']) &&
										(int)$data['detail_price_sale_status'] === 1
									) {
										if (!empty($data['detail_price_sale_status_date']) && (int)$data['detail_price_sale_status_date'] === 2) {
											$hideAddToCartOnLoad = true;
										}
										if (
											!empty($data['detail_price_sale_status_date']) &&
											(int)$data['detail_price_sale_status_date'] === 1 &&
											!empty($data['detail_sale_date_start']) &&
											!empty($data['detail_sale_date_end'])
										) {
											try {
												$today = \Carbon\Carbon::today();
												$start = \Carbon\Carbon::createFromFormat('d-m-Y', trim($data['detail_sale_date_start']))->startOfDay();
												$end = \Carbon\Carbon::createFromFormat('d-m-Y', trim($data['detail_sale_date_end']))->endOfDay();
												if ($today->between($start, $end)) {
													$hideAddToCartOnLoad = true;
												}
											} catch (\Exception $e) {
												$hideAddToCartOnLoad = false;
											}
										}
									}
								@endphp
								@if ($data['detailContact'] == 2)
									<button class="sub-contentleft000801 b-carttwo" id="b-cart" data-id="{{ $data['pro_id'] }}" @if ($data['detailStatus'] == 1 || $hideAddToCartOnLoad) style="display:none" @endif>
                                        <img class="sub-contentleft000802" src="/assets/fontend/hax_theme/images/cartaddon.webp">
                                        <div class="sub-contentleft000803">เพิ่มลงตะกร้า</div>
                                    </button>
									<button class="sub-contentleft000801 b-buynow-two pt-buynow-btn" @if ($data['detailStatus'] == 1 || $hideAddToCartOnLoad) style="display:none" @endif>
                                        <div class="sub-contentleft000803">ซื้อเลย</div>
                                    </button>
									@if($quotationSetting == 1)
										<div id="b-quotation" class="sub-contentleft000804" onclick="submitQuotationForm();">ขอใบเสนอราคา</div>
									@endif
								@else
									@if($quotationSetting == 1)
										<div id="b-quotation" class="sub-contentleft000804" onclick="submitQuotationForm();">ขอใบเสนอราคา</div>
									@endif
								@endif
							</div>
					</div>
				</div>
			</div>
		</div>
		<div id="swipedivmobile" >
			<div class="sub-top-contentpddetail">
				<div class="sub-top-contentpddetail0-left">
				  <div class="sub-contentleft0002">
					<div class="sub-contentleft0003">
					  <img src="{{ $data['pro_cover'] }}" class="sub-contentleft000img js-main" alt="Main Image">
					</div>
				  </div>
				  <div class="sub-contentleft0001">
					<div class="cardimg-small cardimg-small-active">
					  <img src="{{ $data['pro_cover'] }}" class="sub-contentleft000img js-thumb" alt="Thumbnail 1">
					</div>
					@if(count($data['pro_image']) > 1)
					  @foreach(array_slice($data['pro_image'], 0, 4) as $picture)
						<div class="cardimg-small">
						  <img src="{{ $picture['images'] }}" class="sub-contentleft000img js-thumb" alt="Thumbnail {{ $loop->iteration + 1 }}">
						</div>
					  @endforeach
					@endif
				  </div>
				</div>
				<div class="sub-top-contentpddetail0-cent">
					<div class="sub-contentleft0004">
							<div class="sub-contentleft000401">@if(!empty($data['pro_brand'])){{ $data['pro_brand'] }}@endif</div>
							<div class="sub-contentleft000402">
									<div class="sub-contentleft000403">{{ $data['pro_name'] }}</div>
									<div class="sub-contentleft000404 ">
										<div class="sub-contentleft000405 favheart ">
											<img src="/assets/fontend/hax_theme/images/fve-heart.webp" class="sub-contentleft000406">
										</div>
									</div>
							</div>
							<div class="pt-product-rating">รีวิวสินค้า <span class="pt-stars">★★★★★</span></div>
						<div class="sub-contentleft000407 mini-head-sku"><span>รหัสสินค้า: @if(!empty($data['pro_sku'])){{ $data['pro_sku'] }}@else-@endif</span></div>
							<div class="pt-price-box">
							<div class="flex-discount">
								<div class="sub-contentleft000408">{!! $data['detailPrice'] !!}</div>
							</div>
							
							@if(!empty($data['proInstallment']))
							<div class="mini-head-sub">
								<a href="javascript:void(0)" data-toggle="modal" data-target="#installment" class="pt-installment-badge">ผ่อนสูงสุด 36 ด. &middot; ดูรายละเอียด</a>
							</div>
							@endif
							</div>
					</div>
					<div class="sub-contentleft0005 ">
						@if(!empty($data['pro_highlight']))
						<div class="coverboxwithline">
							<div class="txt-hdboxwithline" >รายละเอียดสินค้า :</div>
							<div class="des-boxwithline">
							  <div class="txt-subboxnoline">
								  {!! $data['pro_highlight'] !!}
							  </div>
							  <div class="txt-subboxwithline">แสดงเพิ่มเติม</div>
							</div>
						</div>
						@endif
						@if(!empty($data['pro_codition']) || !empty($data['pro_download']))
						<div class="coverboxwithhountline">
							<div class="txt-hdboxwithline">อื่นๆ :</div>
							<div class="btu-boxwithline">
								@if(count($data['pro_codition']) != 0)
										<div class="pt-feature-pills">
										@foreach ($data['pro_codition'] as $item)
											@php
												$conditionLabelM = is_array($item) ? ($item['name'] ?? $item['title'] ?? '') : ($item->name ?? $item->title ?? '');
											@endphp
											@if(!empty($conditionLabelM))
												<span class="pt-feature-pill">{{ $conditionLabelM }}</span>
											@endif
										@endforeach
										</div>
									@endif
									@if(!empty($data['pro_download']))
									<a class="btu-boxwithline" href="{{ asset('storage/product_dowloads/'.$data['pro_download']) }}" download>
										<div class="sub-contentleft000501">ดาวน์โหลดโบว์ชัวร์</div>
										<div class="sub-contentleft000502">
											<img src="/assets/fontend/hax_theme/images/btulinkout.webp" class="sub-contentleft000503" >
										</div>
									</a>
									@endif
							</div>
						</div>
						@endif
					</div>
				</div>
				<div class="sub-top-contentpddetail0-right">
					<div class="covercard-rightwh">
							<div class="sub-contentleft0006">ตัวเลือก</div>
							<div class="pt-license-list">
								@foreach ($data['proDetail'] as $detail)
									@php
										$licenseDescM = '';
										if (stripos($detail['name'], 'annual') !== false || stripos($detail['name'], 'subscription') !== false) {
											$licenseDescM = 'ใช้งานรายปี เหมาะสำหรับเริ่มต้นและควบคุมงบประมาณ';
										} elseif (stripos($detail['name'], 'perpetual') !== false) {
											$licenseDescM = 'ซื้อขาด เหมาะสำหรับการใช้งานระยะยาว';
										}
									@endphp
									<label class="pt-license-card" for="option_select_m_{{ $detail['id'] }}">
										<div class="pt-license-card-text">
											<strong>{{ $detail['name'] }}</strong>
											@if(!empty($licenseDescM))<span>{{ $licenseDescM }}</span>@endif
										</div>
										<input type="button" class="btn btn-option option-{{ $detail['id'] }} pt-license-input" name="option_select" id="option_select_m_{{ $detail['id'] }}" data-id="{{ $detail['id'] }}" value="{{ $detail['name'] }}"  />
									</label>
								@endforeach
							</div>
							<div class="sub-contentleft0007"></div>
							<div class="sub-contentleft0007"></div>
							<div class="sub-contentleft0007">
								<div class="sub-contentleft000701">จำนวน :</div>
								<div class="b-quantity">
									<div class="quantity clearfix">
										<button class="minus mobile"><img class="sizeminus" src="/assets/fontend/hax_theme/images/minus.webp"></button>
										<input type="text" id="quantity_mobile" value="1" class="qty">
										<button class="plus mobile"><img class="sizeplus" src="/assets/fontend/hax_theme/images/plus.webp"></button>
									</div>
								</div>
							</div>
							<div id="div_alert_stock_mobile" style="display: none;">
								<span class="text-danger">คุณได้เพิ่มสินค้าครบตามจำนวนสต็อกแล้ว</span>
							</div>
							<div id="order_hint_mobile" class="order-hint" style="display:none;"></div>
							<div class=" sub-contentleft0008">
								@if ($data['detailContact'] == 2)
									<button class="sub-contentleft000801 b-cart-one" id="b-cart-m" data-id="{{ $data['pro_id'] }}" @if ($data['detailStatus'] == 1 || $hideAddToCartOnLoad) style="display:none" @endif>
                                        <img class="sub-contentleft000802" src="/assets/fontend/hax_theme/images/cartaddon.webp">
                                        <div class="sub-contentleft000803">เพิ่มลงตะกร้า</div>
                                    </button>
									<button class="sub-contentleft000801 b-buynow-one pt-buynow-btn" data-id="{{ $data['pro_id'] }}" @if ($data['detailStatus'] == 1 || $hideAddToCartOnLoad) style="display:none" @endif>
                                        <div class="sub-contentleft000803">ซื้อเลย</div>
                                    </button>
									@if($quotationSetting == 1)
										<div id="b-quotation-m" class="sub-contentleft000804" onclick="submitQuotationForm();">ขอใบเสนอราคา</div>
									@endif
								@else
									@if($quotationSetting == 1)
										<div id="b-quotation-m" class="sub-contentleft000804" onclick="submitQuotationForm();">ขอใบเสนอราคา</div>
									@endif
								@endif
							</div>
					</div>
				</div>
			</div>
		</div>
	 </div>
         <div class="cover-contentpddetail">
            <div class="sub-mid-contentpddetail">
               <div class="coverdex3box">
					@if(!empty($data['pro_content']) || !empty($data['pro_feature']))<div id="btu-pdda01" onclick="showtabpdde(1)" class="desbox00 txtgreenactive">รายละเอียดสินค้า</div>@endif
					@if(!empty($data['pro_specification']))<div id="btu-pdda02"onclick="showtabpdde(2)" class="desbox00">สเปกสินค้า</div>@endif
					@if(!empty($data['pro_gift']))<div id="btu-pdda04"onclick="showtabpdde(4)" class="desbox00">ของแถมและสิทธิพิเศษ</div>@endif
               </div>
			   @if(!empty($data['pro_content']) || !empty($data['pro_feature']))
               <div id="des-pdda01">
				  <div class="coverdes-pddetail01 pt-noframe">
					<div class="des-pddetail01">
					  <div class="subdes-pddetail0101">
						@if(!empty($data['pro_content']))
						<div class="destxtbox00">รายละเอียดสินค้า</div>
						{!! $data['pro_content'] !!}
						@endif
						@if(!empty($data['pro_feature']))
						{!! $data['pro_feature'] !!}
						@endif
					  </div>
					  <div class="subdes-pddetail0103">
						<div class="btupddetail0103">แสดงเพิ่มเติม</div>
					  </div>
					</div>
				  </div>
				</div>
				@endif
				@if(!empty($data['pro_specification']))
				<div id="des-pdda02" style="display:none;">
				  <div class="coverdes-pddetail01">
					<div class="des-pddetail01">
					  <div class="subdes-pddetail0101">
						<div class="destxtbox00">สเปกสินค้า</div>
						<div class="table-responsive">
							<table class="table table-bordered table-striped">
								<tbody>
									@foreach ($data['pro_specification'] as $spec)
									<tr>
										<td class="table-head">{{ $spec['spec_name']}}</td>
										<td class="table-detail"><div>{!! $spec['spec_detail'] !!}</div></td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					  </div>
					</div>
				  </div>
				</div>
				@endif
				@if(!empty($data['pro_gift']))
				<div id="des-pdda04" style="display:none;">
				  <div class="coverdes-pddetail01">
					<div class="des-pddetail01">
					  <div class="subdes-pddetail0101">
						<div class="destxtbox00">ของแถมและสิทธิพิเศษ</div>
						{!! $data['pro_gift'] !!}
					  </div>
					</div>
				  </div>
				</div>
				@endif
            </div>
         </div>
         <div class=" dg-listpd-extart" >
            <div class="boxheadname">
                <div class="boxtxt-head-pd">
                    <div class="txt-head-pd">สินค้าที่เกี่ยวข้อง</div>
                </div>
            </div>
			<div class="dg-listpd category">
				@foreach ($data['pro_related'] as $related)
				<div class="boxproduct">
					<a class="h-pic-product" href="{{ route('fronend.product.content',['permalink'=>$related['permalink']]) }}@if(!empty($_GET['ref']))?ref={{ $_GET['ref'] }}@endif">
						<img class="size-product" src="{{ asset('storage/product/'.$related['picture']) }}" alt="{{ $related['name'] }}">
					</a>
					@if($related['brand'])
					<a class="text-green-product" href="{{ route('fronend.brand',$related['brand_permalink']) }}@if(!empty($_GET['ref']))?ref={{ $_GET['ref'] }}@endif">
						{{ $related['brand'] }}
					</a>
					@else
					<a class="text-green-product" href="#">
						No Brand
					</a>
					@endif
					<div class="name-product">
						{{ $related['name'] }}
					</div>
					<br>
					<div class="price-group-bottom">
						<div class="df-price">
							<div class="price-product">{!! $related['price'] !!}</div>
						</div>
						<div class="discript-product">*ราคาไม่รวม VAT</div>
						<a class="btn-buy" href="{{ route('fronend.product.content',$related['permalink']) }}@if(!empty($_GET['ref']))?ref={{ $_GET['ref'] }}@endif">
							ดูรายละเอียด
						</a>
					</div>
				</div>
				@endforeach
			</div>
         </div>
    </div>
	@if (!empty($data['proInstallment']))
	<div class="modal fade" id="installment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
		<div class="modal-dialog">
			<div class="modal-body">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h4 class="modal-title" id="myModalLabel">การผ่อนชำระ</h4>
					</div>
					<div class="modal-body">
						@foreach ($settingInstallment as $installment)
						<div class="row b-installment">
							<div class="col-lg-2 col-md-2 col-sm-2 col-xs-3">
								<img width="42" height="42" class="lazyload"  src="{{ asset('storage/installment/'.$installment->installment_img) }}" alt="{{ $installment->installment_name }}">
							</div>
							<div class="col-lg-10 col-md-10 col-sm-10 col-xs-9">{{ $installment->installment_name }}<br/><small>{{ $installment->installment_detail }}</small><br/><small>อัตราดอกเบี้ย <b style="color: red;">{{ $installment->interest_detail }}</b></small></div>
						</div>
						@endforeach
						<center style="color: red; font-size: 75%;">** อัตราดอกเบี้ยอาจมีการเปลี่ยนแปลงได้ ทั้งนี้ขึ้นอยู่กับโปรโมชั่นของธนาคารในแต่ละช่วง</center>
					</div>
				</div>
			</div>
		</div>
	</div>
    @endif
@endif

<div itemscope itemtype="http://schema.org/Product">
	<meta itemprop="brand" content="{{ $data['pro_brand'] }}">
	<meta itemprop="name" content="{{ $data['pro_name'] }}">
	<meta itemprop="description" content="{{ $data['pro_seo_detail'] }}">
	<meta itemprop="productID" content="{{ $data['pro_sku'] }}">
	<meta itemprop="url" content="{{ route('fronend.product.content',$data['pro_permalink']) }}">
	<meta itemprop="image" content="{{ asset('storage/product/'.$data['pro_cover']) }}">
	<div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
		<link itemprop="availability" href="http://schema.org/{{ $data['availability']}}">
		<link itemprop="itemCondition" href="http://schema.org/new">
		<meta itemprop="price" content="{{ $data['og_price'] }}">
		<meta itemprop="priceCurrency" content="THB">
    </div>
</div>

@endsection

@section('js')
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/th_TH/sdk.js#xfbml=1&version=v12.0&appId=1190234624660031&autoLogAppEvents=1" nonce="h8yjg5hD"></script>
<script src="https://d.line-scdn.net/r/web/social-plugin/js/thirdparty/loader.min.js" async="async" defer="defer"></script>
<script type="application/ld+json">
    {
        "@context":"https://schema.org",
        "@type":"Product",
        "productID":"{{ $data['pro_sku'] }}",
        "name":"{{ $data['pro_name']}}",
        "description":"{{ $data['pro_seo_detail'] }}",
        "url":"{{ route('fronend.product.content',$data['pro_permalink']) }}",
        "image":"{{ $data['pro_cover'] }}",
        "brand":"{{ $data['pro_brand'] }}",
        "offers": [
            {
            "@type": "Offer",
            "price": "{{ $data['og_price'] }}",
            "priceCurrency": "THB",
            "itemCondition": "https://schema.org/new",
            "availability": "https://schema.org/{{ $data['availability'] }}"
            }
        ],
		"aggregateRating": {
			"@type": "AggregateRating",
			"ratingValue": "{{ number_format($rating['avg_rating']) }}",
			"reviewCount": "{{ number_format($rating['count_review']) }}"
		}
    }
</script>

@if(!empty($data['pro_brand']) && $data['pro_brand'] == 'Sketchup')
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '<?php echo env('FACEBOOK_PIXEL_ID'); ?>');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=<?php echo env('FACEBOOK_PIXEL_ID'); ?>&ev=PageView&noscript=1"/></noscript>
@endif

<script>
$(document).ready(function() {
	var products = @json($arr_sku_stock);

	function getMinOrderRaw() {
		var v = parseInt($('#min_order').val(), 10);
		if (isNaN(v) || v < 1) return null;
		return v;
	}
	function getMinOrder() {
		var raw = getMinOrderRaw();
		return raw !== null ? raw : 1;
	}
	function getMaxOrder() {
		var v = parseInt($('#max_order').val(), 10);
		if (isNaN(v) || v < 1) return null;
		return v;
	}

	function clampQty(qty) {
		var minO = getMinOrder();
		var maxO = getMaxOrder();
		qty = parseInt(qty, 10);
		if (isNaN(qty)) qty = minO;
		if (qty < minO) qty = minO;
		if (maxO !== null && qty > maxO) qty = maxO;
		var stock = parseInt($("#detail_stock").val());
		var check_stock = parseInt($("#detail_check_stock_status").val());
		if (check_stock === 1 && !isNaN(stock) && stock >= 0 && qty > stock) {
			qty = stock;
		}
		return qty;
	}

	function syncQuantity(qty) {
		qty = clampQty(qty);
		$("#quantity").val(qty);
		$("#quantity_desktop").val(qty);
		$("#quantity_mobile").val(qty);
		$("#_productUnit").val(qty);
		var stock = parseInt($("#detail_stock").val());
		var check_stock = parseInt($("#detail_check_stock_status").val());
		if (check_stock === 1 && !isNaN(stock) && stock > 0 && qty === stock) {
			$("#div_alert_stock_desktop").show();
			$("#div_alert_stock_mobile").show();
		} else {
			$("#div_alert_stock_desktop").hide();
			$("#div_alert_stock_mobile").hide();
		}
	}

	function renderOrderHint(){
		var minRaw = getMinOrderRaw();
		var maxO = getMaxOrder();
		var parts = [];
		if (minRaw !== null && minRaw > 0) {
			parts.push(
				`สั่งซื้อขั้นต่ำ ${minRaw} Seats <br>
				กรณีสั่งซื้อน้อยกว่าจำนวนขั้นต่ำ กรุณาติดต่อ Line ID : <a href="https://page.line.me/8BAHT" target="_blank">@8baht</a>`
			);
		}
		if (maxO !== null && maxO > 0) {
			parts.push(`<div class="max">จำกัดจำนวนสั่งซื้อสูงสุด ${maxO}</div>`);
		}
		var html = parts.join('');
		if (html.trim() !== '') {
			$('#order_hint_desktop, #order_hint_mobile').html(html).show();
		} else {
			$('#order_hint_desktop, #order_hint_mobile').hide().html('');
		}
	}

	function updateHiddenFields(selectedSku) {
		var product = products.find(p => p.sku === selectedSku);
		if (product) {
			$('#detail_check_stock_status').val(product.detail_check_stock_status ? product.detail_check_stock_status : 0);
			$('#detail_stock').val(product.detail_stock ? product.detail_stock : 0);
		} else {
		}
	}

	$(".btn-option").click(function() {
		var selectedSku = $(this).data("id");
		$.ajax({
			dataType: "json",
			method: "get",
			url: "/api/jsonDetail",
			data: { detailId: selectedSku },
			cache: false,
			beforeSend: function () {},
			success: function (t) {
				$(".sub-contentleft000407").html("รหัสสินค้า: " + t.sku);
				$(".mini-head-sub .btn_status_p").html(t.status);
				$(".sub-contentleft000408").html(t.price);
				$("#option-product-detailOther").html(t.detail);
				$("#p_id_d").val(selectedSku);
				$("#_productSku").val(t.sku);

				for (var a = $(".mini-head-sub .btn_status_p"), n = 0; n < a.length; n++) {
					a[n].style.backgroundColor = t.background;
				}

				var i = $(".btn-option");
				for (n = 0; n < i.length; n++) {
					i[n].style.borderColor = "#707070";
					i[n].style.color = "#707070";
				}

				var o = $(".option-" + selectedSku);
				for (n = 0; n < o.length; n++) {
					o[n].style.borderColor = "#1765ff";
					o[n].style.color = "#1765ff";
				}

				if (t.image.length != 0) {
					document.getElementById("preview-item").src = t.image;
					var l = 0.1,
						c = document.getElementById("preview-item"),
						r = setInterval(function () {
							l >= 1 && clearInterval(r);
							c.style.opacity = l;
							c.style.filter = "alpha(opacity=" + 100 * l + ")";
							l += 0.1 * l;
						}, 30);
				} else {
					if (document.getElementById("preview-item").src != t.picture) {
						document.getElementById("preview-item").src = t.picture;
						l = 0.1;
						c = document.getElementById("preview-item");
						r = setInterval(function () {
							l >= 1 && clearInterval(r);
							c.style.opacity = l;
							c.style.filter = "alpha(opacity=" + 100 * l + ")";
							l += 0.1 * l;
						}, 30);
					}
				}

				if (parseInt(t.display, 10) === 1 || parseInt(t.hide_addtocart_button, 10) === 1) {
					$("#b-cart, #b-cart-m").css("display", "none");
				} else {
					$("#b-cart, #b-cart-m").css("display", "flex");
				}

				$('#detail_check_stock_status').val(
					(t.detail_check_stock_status !== undefined && t.detail_check_stock_status !== null)
						? parseInt(t.detail_check_stock_status, 10)
						: 0
				);

				$('#detail_stock').val(
					(t.detail_stock !== undefined && t.detail_stock !== null)
						? parseInt(t.detail_stock, 10)
						: 0
				);

				$('#min_order').val((t.min_order !== null && t.min_order !== undefined) ? parseInt(t.min_order,10) : '');
				$('#max_order').val((t.max_order !== null && t.max_order !== undefined) ? parseInt(t.max_order,10) : '');

				renderOrderHint();
				syncQuantity(getMinOrder());

				$("#div_alert_stock_desktop").hide();
				$("#div_alert_stock_mobile").hide();
			},
			failure: function (e) {
				alert(e);
			},
		});
	});

	$(".minus").click(function (e) {
		e.preventDefault();
		syncQuantity(parseInt($("#quantity").val(), 10) - 1);
	});

	$(".plus").click(function (e) {
		e.preventDefault();
		syncQuantity(parseInt($("#quantity").val(), 10) + 1);
	});

	$("#quantity_desktop, #quantity_mobile").on('input', function () {
		syncQuantity($(this).val());
	});

	renderOrderHint();
	syncQuantity(getMinOrder());

	// [แก้บั๊ก] ตอนโหลดหน้าครั้งแรก ตัวเลือก License ตัวแรกดูเหมือนถูกเลือกไว้แล้ว (สีน้ำเงิน)
	// แต่ราคาที่โชว์ยังเป็นของตัวเลือกอื่น เพราะไม่เคยยิง AJAX sync ราคาให้ตรงกับตัวที่โชว์ว่าเลือกอยู่
	// แก้โดยเรียก .click() ให้ตัวเลือกแรกอัตโนมัติ ใช้ logic เดิมเป๊ะ ไม่ต้องเขียนใหม่
	var $firstLicenseOption = $(".pt-license-input").first();
	if ($firstLicenseOption.length) {
		$firstLicenseOption.trigger("click");
	}
});
</script>
<script type="text/javascript" src="{{ asset('assets/fontend/js/product-review.js') }}"></script>
<script>
 function showtabpdde(id){
    $('#btu-pdda01').removeClass('txtgreenactive')
    $('#btu-pdda02').removeClass('txtgreenactive')
	$('#btu-pdda04').removeClass('txtgreenactive')
    $('#des-pdda01').css('display','none')
    $('#des-pdda02').css('display','none')
	$('#des-pdda04').css('display','none')

    if(id == 1){
        $('#btu-pdda01').addClass('txtgreenactive')
        $('#des-pdda01').css('display','block')
    }
    if(id == 2){
        $('#btu-pdda02').addClass('txtgreenactive')
        $('#des-pdda02').css('display','block')
    }
	if(id == 4){
        $('#btu-pdda04').addClass('txtgreenactive')
        $('#des-pdda04').css('display','block')
    }
 }
</script>

<script>
document.addEventListener('DOMContentLoaded', function(){
  document.querySelectorAll('.sub-top-contentpddetail0-left').forEach(container => {
    container.querySelector('.sub-contentleft0001').addEventListener('click', function(e){
      const thumb = e.target.closest('.js-thumb');
      if (!thumb) return;
      e.preventDefault();

      const mainImg = container.querySelector('.js-main');
      mainImg.src = thumb.src;

      container.querySelectorAll('.cardimg-small').forEach(div => {
        div.classList.remove('cardimg-small-active');
      });
      thumb.closest('.cardimg-small').classList.add('cardimg-small-active');
    });
  });
});

document.addEventListener('DOMContentLoaded', function(){
  document.querySelectorAll('.des-boxwithline').forEach(box => {
	const content = box.querySelector('.txt-subboxnoline');
	const toggle  = box.querySelector('.txt-subboxwithline');

	toggle.addEventListener('click', function(){
	  const isExpanded = content.classList.toggle('expanded');
	  toggle.textContent = isExpanded ? 'ย่อ' : 'แสดงเพิ่มเติม';
	});
  });
});

function submitQuotationForm() {
	const form = document.getElementById('quotation-form');
	if (form) {
	  form.submit();
	} else {
	  console.error('Form with id "quotation-form" not found');
	}
}

document.addEventListener('DOMContentLoaded', function(){
  const content = document.querySelector('.subdes-pddetail0101');
  const trigger = document.querySelector('.btupddetail0103');

  trigger.addEventListener('click', function(){
    const isExpanded = content.classList.toggle('expanded');
    trigger.textContent = isExpanded ? 'ย่อ' : 'แสดงเพิ่มเติม';
  });
});

</script>
@endsection