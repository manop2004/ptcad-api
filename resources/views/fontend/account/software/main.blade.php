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

/* ส่วนหลักของ Account Account */
.acct-wrap{
  --navy:#12358f; --blue:#1765ff; --ink:#0b1f4d; --muted:#667085; --line:#e6edf8;
  --soft:#f6f9ff; --green:#20b26b; --red:#ef4444; --orange:#b45309; --shadow:0 18px 50px rgba(20,53,143,.10);
  font-family:'Poppins','Noto Sans Thai',system-ui,sans-serif; color:var(--ink);
  width: 100% !important;
  max-width: 1320px !important;
  margin: 0 auto 60px auto !important;
  padding: 0 16px !important;
  box-sizing: border-box !important;
  overflow-x: hidden !important;
}
.acct-wrap *{box-sizing:border-box}
.acct-wrap a{text-decoration:none;color:inherit}

/* Hero Section */
.acct-hero{
  padding:48px 24px;
  background:linear-gradient(105deg,#ffffff 0%,#f4f9ff 60%,#e4f3ff 100%);
  border-radius:24px;
  margin-bottom:28px;
  text-align:center !important;
  display: flex !important;
  flex-direction: column !important;
  align-items: center !important;
  justify-content: center !important;
}
.acct-hero .eyebrow{
  display:inline-flex;
  align-items:center;
  justify-content:center;
  gap:8px;
  color:var(--blue);
  font-weight:800;
  font-size:13px;
  margin-bottom:10px;
  width: 100%;
}
.acct-hero h1{
  font-size:34px;
  margin:0 0 8px 0;
  color:var(--navy);
  letter-spacing:-1px;
  text-align:center !important;
  width: 100%;
}
.acct-hero p{
  margin:0 auto !important;
  color:var(--muted);
  font-size:15px;
  max-width:640px;
  line-height:1.6;
  text-align:center !important;
  width: 100%;
}

/* Portal Layout */
.acct-portal{display:grid;grid-template-columns:270px 1fr;gap:26px}
.acct-side{position:sticky;top:100px;align-self:start;border:1px solid var(--line);border-radius:22px;background:#fff;box-shadow:0 12px 34px rgba(20,53,143,.055);padding:14px}
.acct-side a{height:46px;border-radius:14px;display:flex;align-items:center;gap:12px;padding:0 14px;color:#344054;font-weight:700;font-size:14px}
.acct-side a img{width:18px;height:18px;object-fit:contain}
.acct-side a:hover,.acct-side a.active{background:#eef6ff;color:var(--blue)}
.acct-side a.signout{color:var(--red)}

.acct-main{display:grid;gap:24px}

/* Product Card */
.acct-card{background:#fff;border:1px solid var(--line);border-radius:24px;padding:26px;box-shadow:0 12px 34px rgba(20,53,143,.055)}
.acct-section-head{display:flex;align-items:flex-end;justify-content:space-between;gap:20px;margin-bottom:18px;flex-wrap:wrap}
.acct-kicker{font-weight:800;color:var(--blue);font-size:12px;margin-bottom:4px}
.acct-section-head h2{font-size:24px;margin:0;color:#102b76}
.acct-section-desc{margin:6px 0 0;color:var(--muted);font-size:13px;line-height:1.6}

/* Product Grid inside My Products */
.acct-product-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:16px}
.acct-product-card{border:1px solid var(--line);border-radius:18px;padding:20px;background:linear-gradient(180deg,#fff,#fbfdff)}
.acct-product-card h3{margin:0 0 6px;font-size:17px;color:#102b76}
.acct-product-card p{margin:0;color:var(--muted);font-size:13px;line-height:1.55}
.acct-product-price{margin:12px 0;font-weight:800;color:var(--blue);font-size:15px}
.acct-badge{display:inline-block;border-radius:999px;padding:4px 10px;font-size:11px;font-weight:800;margin-bottom:8px}
.acct-badge.paid{background:#eafff3;color:var(--green)}
.acct-badge.pending{background:#fff3e0;color:#b45309}
.acct-actions{margin-top:14px; display:flex;gap:8px;flex-wrap:wrap}

.acct-btn{height:38px;border-radius:10px;display:inline-flex;align-items:center;justify-content:center;gap:8px;padding:0 16px;font-weight:800;font-size:13px;background:var(--blue);color:#fff;border:1px solid transparent;cursor:pointer;transition:.15s ease}
.acct-btn:hover{filter:brightness(1.06)}
.acct-btn.outline{background:#fff;color:var(--blue);border:1px solid var(--line)}
.acct-btn.outline:hover{background:var(--soft);border-color:#bcd8ff}

/* [ปรับปรุงใหม่] ปุ่ม Manage */
.acct-manage-btn.is-open{
  background:var(--blue) !important;
  color:#fff !important;
  border-color:var(--blue) !important;
}
.acct-manage-btn .acct-manage-chevron{
  transition:transform .2s ease;
  display:inline-flex;
}
.acct-manage-btn.is-open .acct-manage-chevron{
  transform:rotate(180deg);
}

/* ===================================================================
   Workspace Section: จัดวาง 3 หัวข้อ (rule เดิม — จะถูก override ด้านล่างสุด
   ให้เรียงแนวตั้งเสมอในการ์ดสินค้า เพื่อไม่ให้เบียดกันตอนมี License เยอะ)
   =================================================================== */
.acct-workspace{
  max-height:0;
  opacity:0;
  overflow:hidden;
  margin-top:0;
  border-top:none;
  padding-top:0;
  transition:max-height .35s ease, opacity .25s ease, margin-top .25s ease, padding-top .25s ease;
}
.acct-workspace.open{
  max-height:1200px;
  opacity:1;
  margin-top:22px;
  border-top:1px solid var(--line);
  padding-top:20px;
}

/* คอนเทนเนอร์หลักสำหรับจัดวางแบบแนวนอน */
.acct-ws-horizontal-row {
    display: flex;
    flex-wrap: wrap;
    gap: 16px;
    align-items: center;
}

/* กล่อง Workspace แต่ละอัน */
.acct-ws-box {
    border: 1px solid var(--line);
    border-radius: 16px;
    padding: 16px 20px;
    background: #fff;
    flex: auto;
    display: flex;
    flex-direction: row;
    align-items: center;
    gap: 16px;
    overflow-x: auto;
    max-width: 100%;
}

.acct-ws-box h4{
    margin:0;
    font-size:15px;
    color:#102b76;
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:8px;
    flex: none;
}

.acct-ws-status{font-size:11px;font-weight:800;padding:3px 10px;border-radius:999px;background:#eafff3;color:var(--green);white-space:nowrap}
.acct-ws-sub{color:var(--muted);font-size:12px;margin-bottom:10px}

.acct-ws-box-body {
    display: flex;
    flex-direction: column;
    gap: 6px;
    width: 100%;
}

.acct-ws-content-item {
    display: flex;
    align-items: center;
    gap: 10px;
}

.acct-ws-content-item::after {
    content: '•';
    color: var(--muted);
    font-size: 10px;
}

.acct-ws-content-item:last-child::after {
    content: '';
}

/* กุญแจ/Serial Number */
.acct-ws-key {
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:8px;
    background:var(--soft);
    border:1px dashed var(--line);
    border-radius:10px;
    padding:6px 10px;
    font-family:monospace;
    font-weight:700;
    font-size:13px;
    margin-bottom:0;
    width: auto;
    flex: none;
}
.acct-ws-key span{overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
.acct-ws-key button{border:none;background:none;color:var(--blue);font-weight:800;font-size:12px;cursor:pointer;flex:none}

.acct-ws-meta{color:var(--muted);font-size:12px;line-height:1.7}

/* Downloads */
.acct-ws-dl-row {
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:10px;
    padding:6px 0;
    border-bottom:1px solid var(--line);
    font-size:13px;
}
.acct-ws-dl-row:last-child{border-bottom:none}
.acct-ws-dl-row a{color:var(--blue);font-weight:800;white-space:nowrap}

/* Hardware Reset */
.acct-btn-warning {
    background:#fff8ee !important;color:var(--orange) !important;
    border:1px solid #fde3c0 !important;
    width: auto;
    flex: none;
}
.acct-btn-warning:hover{background:#fff3e0 !important}
.acct-hw-note{color:var(--muted);font-size:11.5px;margin-top:0;line-height:1.6}

/* ===================================================================
   ส่วน Modal และ Toast แจ้งผล (เหมือนเดิม)
   =================================================================== */
.acct-modal-overlay{
  position:fixed;inset:0;background:rgba(11,31,77,.45);
  display:flex;align-items:center;justify-content:center;
  z-index:9999;opacity:0;pointer-events:none;transition:opacity .2s ease;padding:20px;
}
.acct-modal-overlay.open{opacity:1;pointer-events:auto}
.acct-modal{
  background:#fff;border-radius:20px;padding:26px;max-width:420px;width:100%;
  box-shadow:0 24px 60px rgba(20,53,143,.25);transform:translateY(10px);transition:transform .2s ease;
}
.acct-modal-overlay.open .acct-modal{transform:translateY(0)}
.acct-modal h3{margin:0 0 10px;color:var(--navy);font-size:18px;display:flex;align-items:center;gap:8px}
.acct-modal p{margin:0 0 20px;color:var(--muted);font-size:13.5px;line-height:1.65}
.acct-modal p b{color:var(--ink)}
.acct-modal-actions{display:flex;gap:10px;justify-content:flex-end}
.acct-btn-danger{background:#ef4444 !important;color:#fff !important}
.acct-btn-danger:disabled{opacity:.6;cursor:not-allowed;filter:none}

.acct-toast{
  position:fixed;bottom:30px;left:50%;transform:translate(-50%,20px);
  background:#0b1f4d;color:#fff;padding:14px 22px;border-radius:14px;
  font-size:13.5px;font-weight:600;box-shadow:0 14px 34px rgba(11,31,77,.3);
  opacity:0;transition:opacity .3s ease, transform .3s ease;z-index:10000;
  max-width:90%;text-align:center;display:flex;align-items:center;gap:8px;
}
.acct-toast.show{opacity:1;transform:translate(-50%,0)}

.acct-empty{color:var(--muted);font-size:14px;padding:20px 0}

/* Responsive Portal Layout */
@media (max-width:1000px){
  .acct-portal{grid-template-columns:1fr}
  .acct-side{position:relative;top:0;display:grid;grid-template-columns:repeat(3,1fr)}
}
@media (max-width:640px){
  .acct-side{grid-template-columns:1fr 1fr}
  .acct-product-grid{grid-template-columns:1fr}
}
/* ===================================================
   ซ่อนปุ่มผีส่วนเกิน + ปิด Scrollbar ที่ License
   =================================================== */
.acct-product-card .acct-ws-box button:not([class*="acct-"]) {
  display: none !important;
}

.acct-product-card .acct-ws-box .acct-btn,
.acct-product-card .acct-ws-box button[class*="acct-"],
.acct-product-card .acct-btn-warning {
  white-space: nowrap !important;
  width: auto !important;
  min-width: max-content !important;
  padding: 6px 14px !important;
  display: inline-flex !important;
  align-items: center !important;
  justify-content: center !important;
  gap: 6px !important;
}

.acct-product-card .acct-ws-box {
  overflow-x: hidden !important;
}

.acct-product-card .acct-ws-box:has(.acct-btn-warning),
.acct-product-card .acct-ws-box:last-child {
  overflow-x: auto !important;
}

/* ===================================================
   ดันหน้าจอให้กลับมาสมดุล ป้องกันล้นขวาบนมือถือ
   =================================================== */
@media (max-width: 768px) {
  .acct-ws-horizontal-row {
    flex-direction: column !important;
    align-items: stretch !important;
  }

  .acct-ws-box {
    flex-direction: column !important;
    align-items: flex-start !important;
    width: 100% !important;
    max-width: 100% !important;
    box-sizing: border-box !important;
  }

  .acct-ws-box h4 {
    width: 100% !important;
  }

  .acct-ws-key {
    width: 100% !important;
    max-width: 100% !important;
    box-sizing: border-box !important;
  }

  .acct-ws-key span {
    display: block;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
  }

  .acct-product-card .acct-ws-box .acct-btn,
  .acct-product-card .acct-ws-box button[class*="acct-"],
  .acct-product-card .acct-btn-warning {
    min-width: 0 !important;
    white-space: normal !important;
  }
}

.acct-product-card,
.acct-ws-box,
.acct-card {
  max-width: 100% !important;
  word-break: break-word !important;
  overflow-wrap: anywhere !important;
}

/* ===================================================================
   [แก้ไขล่าสุด] จัด Workspace ในการ์ดสินค้าใหม่ทั้งหมด
   ปัญหาเดิม: การ์ดสินค้ากว้างจำกัด (grid auto-fit) แต่บังคับให้ License /
   Downloads / Hardware เรียงแนวนอนในกล่องเดียว พอมีหลาย License การ์ด
   แต่ละใบเลยแคบลง ทำให้ทุกอย่างเบียดกัน ปุ่มตกขอบ ข้อความล้น
   ทางแก้: บังคับให้ 3 ส่วนเรียง "แนวตั้ง" เสมอ ทั้งบนคอมและมือถือ
   เพราะพื้นที่ในการ์ดแคบกว่าพื้นที่หน้าจอทั้งหน้าเสมอ
   =================================================================== */
.acct-product-card .acct-ws-horizontal-row{
  flex-direction: column !important;
  align-items: stretch !important;
  flex-wrap: nowrap !important;
  gap: 14px !important;
}

.acct-product-card .acct-ws-box{
  flex-direction: column !important;
  align-items: stretch !important;
  width: 100% !important;
  gap: 10px !important;
  overflow-x: hidden !important;
}

.acct-product-card .acct-ws-box h4{
  width: 100%;
  flex: initial;
}

.acct-product-card .acct-ws-key{
  width: 100%;
  flex: initial;
}

/* กล่อง Hardware: ให้ label, ปุ่ม, ลิงก์, หมายเหตุ เรียงลงมาเป็นระเบียบ */
.acct-product-card .acct-ws-box[data-hw-serial] .acct-ws-box-body{
  align-items: stretch;
}
.acct-product-card .acct-ws-box[data-hw-serial] .acct-btn,
.acct-product-card .acct-ws-box[data-hw-serial] a.acct-btn.outline{
  width: 100% !important;
  min-width: 0 !important;
}
.acct-product-card .acct-ws-box[data-hw-serial] .acct-hw-note{
  margin-top: 2px;
}
.acct-product-card .acct-ws-box[data-hw-serial] img[data-ptcad-signature]{
  max-width: 100% !important;
}

/* Downloads: ให้ปุ่ม Download/View ไม่หลุดขอบเวลาชื่อไฟล์ยาว */
.acct-product-card .acct-ws-dl-row{
  flex-wrap: wrap;
  row-gap: 4px;
}
.acct-product-card .acct-ws-dl-row span{
  flex: 1 1 auto;
  min-width: 0;
}

/* ให้แต่ละกล่อง (License/Downloads/Hardware) มีพื้นหลังอ่อนๆ แยกจากกันชัดขึ้น */
.acct-product-card .acct-ws-box{
  background: var(--soft);
}
/* ===================================================
   [TAILWIND PAGINATION FIX] ดักจับ Tailwind Utility Classes
   =================================================== */

/* 1. ลบพื้นหลังสีดำของ Wrapper และตัวคุม Nav ทั้งหมด */
.acct-card nav[role="navigation"],
.acct-card nav[role="navigation"] > div,
.acct-card nav[role="navigation"] .flex,
.acct-card nav[role="navigation"] .inline-flex {
  background-color: transparent !important;
  background: transparent !important;
  box-shadow: none !important;
  border-color: transparent !important;
}

/* 2. จัดระเบียบ Layout ให้ปุ่มอยู่ตรงกลาง */
.acct-card nav[role="navigation"] {
  display: flex !important;
  justify-content: center !important;
  align-items: center !important;
  margin-top: 24px !important;
  width: 100% !important;
}

.acct-card nav[role="navigation"] > div {
  display: flex !important;
  justify-content: center !important;
  align-items: center !important;
  gap: 6px !important;
}

/* 3. ซ่อนส่วนซ้ำซ้อนของ Tailwind (เช่น ส่วนแสดงข้อความ "Showing 1 to 10...") ถ้าไม่ต้องการ */
.acct-card nav[role="navigation"] .hidden.sm\:flex-1,
.acct-card nav[role="navigation"] p.text-sm {
  display: none !important;
}

/* 4. แต่งปุ่มกดทั้งหมด (ทั้งปุ่มเลข, ปุ่มก่อนหน้า, ปุ่มถัดไป) */
.acct-card nav[role="navigation"] a,
.acct-card nav[role="navigation"] span[aria-current="page"],
.acct-card nav[role="navigation"] span[aria-disabled="true"] {
  display: inline-flex !important;
  align-items: center !important;
  justify-content: center !important;
  min-width: 38px !important;
  height: 38px !important;
  padding: 0 14px !important;
  border-radius: 10px !important;
  border: 1.5px solid #e6edf8 !important;
  background-color: #ffffff !important;
  background: #ffffff !important;
  color: #344054 !important;
  font-weight: 700 !important;
  font-size: 13px !important;
  text-decoration: none !important;
  transition: all 0.2s ease !important;
  box-shadow: 0 2px 4px rgba(20, 53, 143, 0.04) !important;
  margin: 0 !important;
}

/* 5. สถานะ Hover */
.acct-card nav[role="navigation"] a:hover {
  border-color: #1765ff !important;
  color: #1765ff !important;
  background-color: #f4f9ff !important;
  background: #f4f9ff !important;
}

/* 6. สถานะ Active (หน้าปัจจุบัน) */
.acct-card nav[role="navigation"] span[aria-current="page"] > span,
.acct-card nav[role="navigation"] span[aria-current="page"] {
  background-color: #1765ff !important;
  background: #1765ff !important;
  border-color: #1765ff !important;
  color: #ffffff !important;
}

/* 7. สถานะ Disabled (ปุ่มที่กดไม่ได้) */
.acct-card nav[role="navigation"] span[aria-disabled="true"] > span,
.acct-card nav[role="navigation"] span[aria-disabled="true"] {
  background-color: #f8fafc !important;
  background: #f8fafc !important;
  color: #c1c9d6 !important;
  border-color: #eef1f6 !important;
  cursor: not-allowed !important;
}


</style>
@endsection

@section('content')

<div class="acct-wrap" style="width:100%;padding:0 28px">

    @if (!empty($breadcrumb))
    <section id="page-title" class="page-title-mini page-title-right">
        <div class="clearfix">
            <ol class="breadcrumb">
                @foreach ($breadcrumb as $index => $item)
                    @if($index !== count($breadcrumb) -1 )
                        <li><a href="{{ $item['route'] }}">{{ $item['name'] }}</a></li>
                    @else
                        <li class="active">{{ $item['name'] }}</li>
                    @endif
                @endforeach
            </ol>
        </div>
    </section>
    @endif

    <section class="acct-hero">
        <div class="eyebrow"><i data-lucide="badge-check" size="16"></i> MY PTCAD</div>
        <h1>ซอฟต์แวร์ของฉัน</h1>
        <p>คุณสามารถแจ้งเจ้าหน้าที่เพื่อขอรับการแจ้งเตือนหากรายการของคุณกำลังจะหมดอายุ เราจะส่งอีเมลแจ้งเตือนถึงคุณก่อนการหมดอายุ 7 วัน</p>
    </section>

    <div class="acct-portal">
        @include('layouts.fontend.account_sidebar')

        <div class="acct-main">
            <section class="acct-card" id="my-products">
                <div class="acct-section-head">
    <div>
        <div class="acct-kicker">MY PRODUCTS</div>
        <h2>สินค้าที่คุณมี</h2>
        <p class="acct-section-desc">ทุกโปรแกรมที่ซื้อแล้วจะอยู่ตรงนี้</p>
    </div>
</div>

<form method="GET" action="{{ route('fronend.account.software') }}" style="display:flex;gap:10px;flex-wrap:wrap;margin-bottom:20px;">
    <select name="version" onchange="this.form.submit()" style="border:1px solid #e6edf8;border-radius:10px;padding:8px 12px;font-size:13px;font-weight:700;color:#344054">
    <option value="all">ทุกเวอร์ชัน</option>
    <option value="Lite" @if(request('version')=='Lite') selected @endif>Lite</option>
    <option value="Standard" @if(request('version')=='Standard') selected @endif>Standard</option>
    <option value="Plus" @if(request('version')=='Plus') selected @endif>Plus</option>
    <option value="Civil ProMax 3 เดือน" @if(request('version')=='Civil ProMax 3 เดือน') selected @endif>Civil ProMax - 3 เดือน</option>
    <option value="Civil ProMax 6 เดือน" @if(request('version')=='Civil ProMax 6 เดือน') selected @endif>Civil ProMax - 6 เดือน</option>
    <option value="Civil ProMax 1 ปี" @if(request('version')=='Civil ProMax 1 ปี') selected @endif>Civil ProMax - 1 ปี</option>
</select>

    <select name="type" onchange="this.form.submit()" style="border:1px solid #e6edf8;border-radius:10px;padding:8px 12px;font-size:13px;font-weight:700;color:#344054">
        <option value="all">ทุกประเภท</option>
        <option value="Subscription" @if(request('type')=='Subscription') selected @endif>รายปี (Subscription)</option>
        <option value="Perpetual" @if(request('type')=='Perpetual') selected @endif>ซื้อขาด (Perpetual)</option>
    </select>

    <select name="sort" onchange="this.form.submit()" style="border:1px solid #e6edf8;border-radius:10px;padding:8px 12px;font-size:13px;font-weight:700;color:#344054">
        <option value="updated_desc" @if(request('sort','updated_desc')=='updated_desc') selected @endif>อัปเดตล่าสุด</option>
        <option value="exp_asc" @if(request('sort')=='exp_asc') selected @endif>ใกล้หมดอายุก่อน</option>
        <option value="exp_desc" @if(request('sort')=='exp_desc') selected @endif>หมดอายุช้าสุดก่อน</option>
    </select>
</form>

                @if(count($softwares))
                <div class="acct-product-grid">
                    @foreach ($softwares as $software)
                        <div class="acct-product-card">
                            @if(!empty($software->orderId))
                                @if ($software->status == 2)
                                    <span class="acct-badge paid">ชำระเงินแล้ว</span>
                                @else
                                    <span class="acct-badge pending">รอต่ออายุ</span>
                                @endif
                            @else
    {{-- Perpetual ไม่มีวันถึงกำหนดชำระเลย ไม่ต้องโชว์ป้ายนี้ / License อื่นโชว์เฉพาะตอนยังไม่หมดอายุ --}}
    @if($software->type_label != 'Perpetual' && strtotime($software->date_exp) >= strtotime(date('Y-m-d')))
        <span class="acct-badge pending">ยังไม่ถึงกำหนดชำระ</span>
    @endif
@endif
                            @if(!empty($software->type_label))
    <span class="acct-badge" style="background:#1765ff;color:#fff;margin-left:6px;">{{ $software->type_label }}</span>
@endif

                            @if ($software->pro_option == 1)
                                <h3>{{ $software->pro_name }}</h3>
                            @else
                                <h3>{{ $software->detail_name }}</h3>
                            @endif
                            <p>serial number: {{ $software->serial_number }}</p>
                            <p>เริ่มใช้: {{ date("d-m-Y",strtotime($software->date_start)) }} • หมดอายุ: {{ $software->date_exp == 'perpetual' ? 'ตลอดชีพ' : date("d-m-Y",strtotime($software->date_exp)) }}</p>
                            {{-- [ซ่อนตามคำขอ] ราคาไม่ต้องโชว์ในหน้า My Product แล้ว --}}
{{-- <div class="acct-product-price">{{ number_format($software->price,2) }} บาท</div> --}}

                            <div class="acct-actions">
                                @if(!empty($software->orderId) && $software->status != 2)
                                    <a href="{{ route('fronend.account.order.detail',$software->orderId) }}" class="acct-btn">
                                        <i data-lucide="refresh-ccw" size="14"></i> ต่ออายุ
                                    </a>
                                @endif
                                {{-- [เพิ่มใหม่] ปุ่มต่ออายุ — โชว์เมื่อเหลือเวลาใช้งาน <= 30 วัน --}}
@if(!empty($software->show_renew_button))
    <a href="{{ route('fronend.account.software.renew', $software->id) }}" class="acct-btn" style="background:#f5a623;height:38px;padding:0 16px;">
        <i data-lucide="refresh-ccw" size="14"></i> ต่ออายุ (เหลือ {{ $software->days_remaining }} วัน)
    </a>
@endif
                                <button type="button" class="acct-btn outline acct-manage-btn" onclick="toggleWorkspace(this,'ws-{{ $software->id }}')">
                                    <i data-lucide="settings" size="14"></i>
                                    <span class="acct-manage-label">Manage</span>
                                    <i data-lucide="chevron-down" size="14" class="acct-manage-chevron"></i>
                                </button>
                            </div>

                            <div class="acct-workspace" id="ws-{{ $software->id }}">
                                <div class="acct-ws-horizontal-row">

                                    <!-- License Section -->
                                    <div class="acct-ws-box">
                                        <h4>License
    @if($software->date_exp == 'perpetual' || strtotime($software->date_exp) >= strtotime(date('Y-m-d')))
        <span class="acct-ws-status">Active</span>
    @else
        <span class="acct-ws-status" style="background:#fff3e0;color:#b45309">Expired</span>
    @endif
</h4>
                                        <div class="acct-ws-box-body">
                                            <div class="acct-ws-sub">Serial Number สำหรับเปิดใช้งาน</div>
                                            <div class="acct-ws-key">
                                                <span>{{ $software->serial_number }}</span>
                                                <button type="button" onclick="navigator.clipboard.writeText('{{ $software->serial_number }}')">Copy</button>
                                            </div>
                                            <div class="acct-ws-meta">
    เริ่มใช้: {{ date("d M Y",strtotime($software->date_start)) }} • หมดอายุ: {{ $software->date_exp == 'perpetual' ? 'ตลอดชีพ' : date("d M Y",strtotime($software->date_exp)) }}
</div>
                                        </div>
                                    </div>

                                    <!-- Downloads Section -->
<!-- Downloads Section -->
<div class="acct-ws-box">
    <h4>Downloads</h4>
    <div class="acct-ws-box-body">
        @php
            $dlItems = [];
            if(!empty($software->pro_download)) $dlItems[] = ['label'=>'เอกสาร/โบรชัวร์สินค้า','sub'=>'','url'=>asset('storage/product_dowloads/'.$software->pro_download),'download'=>true];
            if(!empty($software->pro_installer)) $dlItems[] = ['label'=>'PTCAD Installer','sub'=>'Windows • Latest Version','url'=>asset('storage/product_dowloads/'.$software->pro_installer),'download'=>true];
            if(!empty($software->pro_activation_guide)) $dlItems[] = ['label'=>'Offline Activation Guide','sub'=>'PDF Manual','url'=>asset('storage/product_dowloads/'.$software->pro_activation_guide),'download'=>true];

            $downloadOptions = [];
            if(!empty($software->api_downloadlink)) {
                $apiLinks = $software->api_downloadlink;

                if (is_array($apiLinks) && isset($apiLinks[0]) && (is_array($apiLinks[0]) || is_object($apiLinks[0]))) {
                    foreach ($apiLinks as $link) {
                        $link = (array) $link;
                        $url  = $link['linkaddress'] ?? null;
                        $name = $link['linkname'] ?? ($software->api_download_label ?: 'ดาวน์โหลดโปรแกรม');
                        if (is_string($url) && $url !== '') {
                            preg_match('/(\d{4})/', $name, $m);
                            $year = isset($m[1]) ? (int) $m[1] : 0;
                            $downloadOptions[] = ['label' => $name, 'url' => $url, 'year' => $year];
                        }
                    }
                    usort($downloadOptions, function ($a, $b) {
                        return $b['year'] <=> $a['year'];
                    });
                } elseif (is_string($apiLinks) && $apiLinks !== '') {
                    $downloadOptions[] = [
                        'label' => $software->api_download_label ?: 'ดาวน์โหลดโปรแกรม',
                        'url'   => $apiLinks,
                        'year'  => 0,
                    ];
                }
            }
        @endphp

        @forelse($dlItems as $dl)
            <div class="acct-ws-dl-row">
                <span>{{ $dl['label'] }}@if(!empty($dl['sub']))<br><small class="acct-ws-sub" style="margin:0">{{ $dl['sub'] }}</small>@endif</span>
                <a href="{{ $dl['url'] }}" @if($dl['download']) download @else target="_blank" @endif style="display:inline-flex;align-items:center;gap:4px;">
                    <i data-lucide="arrow-down" size="13"></i> Download
                </a>
            </div>
        @empty
        @endforelse

        @if(count($downloadOptions))
            @if(($software->type_label ?? '') === 'Perpetual')
                <div class="acct-ws-dl-row">
                    <span>{{ $downloadOptions[0]['label'] }}</span>
                    <a href="{{ $downloadOptions[0]['url'] }}" target="_blank" style="display:inline-flex;align-items:center;gap:4px;">
                        <i data-lucide="arrow-down" size="13"></i> Download
                    </a>
                </div>
            @else
                <div class="acct-ws-dl-row" style="flex-direction:column;align-items:stretch;gap:8px">
                    <span>โปรแกรมติดตั้ง</span>
                    <div style="display:flex;gap:8px;flex-wrap:wrap;align-items:center">
                        <select
                            id="dlver-{{ $software->id }}"
                            onchange="document.getElementById('dlbtn-{{ $software->id }}').setAttribute('href', this.value)"
                            style="flex:1;min-width:160px;border:1px solid #e6edf8;border-radius:10px;padding:6px 10px;font-size:13px;font-weight:700;color:#344054"
                        >
                            @foreach($downloadOptions as $i => $opt)
                                <option value="{{ $opt['url'] }}" @if($i === 0) selected @endif>{{ $opt['label'] }}</option>
                            @endforeach
                        </select>
                        <a id="dlbtn-{{ $software->id }}" href="{{ $downloadOptions[0]['url'] }}" target="_blank" style="display:inline-flex;align-items:center;gap:4px;white-space:nowrap;">
                            <i data-lucide="arrow-down" size="13"></i> Download
                        </a>
                    </div>
                </div>
            @endif
        @endif

        @if(empty($dlItems) && empty($downloadOptions))
            <p class="acct-ws-sub" style="margin-top:0">ยังไม่มีไฟล์ดาวน์โหลด — ติดต่อทีมงาน</p>
        @endif
    </div>
</div>

                                    <!-- Hardware Section (เฉพาะ PTCAD เท่านั้น — Civil ProMax ไม่มี Widget นี้) -->
@if(empty($software->is_civilpromax))
<div class="acct-ws-box" data-hw-serial="{{ $software->serial_number }}">
    <h4>Hardware</h4>
    <div class="acct-ws-box-body acct-ws-horizontal-row" style="gap:10px">
        <p class="acct-ws-sub" style="margin-bottom:0">ผูกกับคอมพิวเตอร์ปัจจุบัน</p>

        <button type="button" class="acct-btn acct-btn-warning acct-btn-warning-row" onclick="ptcadConfirmThenReset('{{ $software->serial_number }}')">
            <i data-lucide="refresh-cw" size="14"></i> Reset
        </button>

        <button type="button"
            id="ptcadRealResetBtn-{{ $software->serial_number }}"
            data-ptcad-reset
            data-serialnumber="{{ $software->serial_number }}"
            data-proxy-url="/api/ptcad/reset-proxy"
            data-loading-text="กำลังดำเนินการ..."
            style="display:none">Reset</button>

        <a data-ptcad-status
           data-serialnumber="{{ $software->serial_number }}"
           data-proxy-url="/api/ptcad/reset-proxy"
           class="acct-btn outline"
           style="display:none"
           target="_blank">📋 ประวัติการ reset ล่าสุด</a>

    </div>

    <img data-ptcad-signature
         data-serialnumber="{{ $software->serial_number }}"
         data-proxy-url="/api/ptcad/reset-proxy"
         style="display:none;max-width:220px;border:2px dashed #e6edf8;border-radius:8px;margin-top:10px"
         alt="ลายเซ็นคำขอ Reset">
</div>
@endif

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @else
                    <p class="acct-empty">คุณยังไม่มีซอฟต์แวร์ในบัญชี</p>
                @endif

                <div style="margin-top:18px">{!! $softwares->links() !!}</div>
            </section>

        </div>
    </div>

    <div class="acct-modal-overlay" id="resetHardwareModal">
        <div class="acct-modal">
            <h3><i data-lucide="alert-triangle" size="18" style="color:#b45309"></i> รีเซ็ตฮาร์ดแวร์</h3>
            <p>License <b id="resetHardwareSerial">-</b> — กดยืนยันแล้วระบบจะเปิดหน้าเว็บของ PTCAD ในแท็บใหม่ ให้คุณลงนามยืนยันตัวตนเพื่อดำเนินการต่อ (ยังไม่รีเซ็ตทันที จนกว่าจะลงนามเสร็จ) หลังลงนามแล้ว เครื่องเดิมจะถูกปลดออก และเปิดใช้งานบนเครื่องใหม่ได้</p>
            <div class="acct-modal-actions">
                <button type="button" class="acct-btn outline" onclick="closeResetHardwareModal()">ยกเลิก</button>
                <button type="button" class="acct-btn acct-btn-danger" id="confirmResetHardwareBtn" onclick="confirmResetHardware()">ยืนยันรีเซ็ต</button>
            </div>
        </div>
    </div>

</div>

@endsection

@section('js')
<script>
function toggleWorkspace(btn, id){
    var el = document.getElementById(id);
    if(!el) return;
    var isOpen = el.classList.toggle('open');
    if (btn) {
        btn.classList.toggle('is-open', isOpen);
        var label = btn.querySelector('.acct-manage-label');
        if (label) label.textContent = isOpen ? 'ซ่อน' : 'Manage';
    }
}

var _resetHardwareTarget = null;

function ptcadConfirmThenReset(serial){
    _resetHardwareTarget = serial;
    var serialEl = document.getElementById('resetHardwareSerial');
    if (serialEl) serialEl.textContent = serial;
    document.getElementById('resetHardwareModal').classList.add('open');
}

function openResetHardwareModal(serial){ ptcadConfirmThenReset(serial); }

function closeResetHardwareModal(){
    document.getElementById('resetHardwareModal').classList.remove('open');
    _resetHardwareTarget = null;
}

function confirmResetHardware(){
    var serial = _resetHardwareTarget;
    closeResetHardwareModal();

    var realBtn = document.getElementById('ptcadRealResetBtn-' + serial);
    if (realBtn) {
        realBtn.click();
    } else {
        showAcctToast('⚠️ ไม่พบปุ่ม Reset ของ License นี้ (ตรวจสอบว่า Widget โหลดสำเร็จหรือยัง)');
    }
}

function showAcctToast(msg){
    var old = document.getElementById('acct-toast');
    if (old) old.remove();

    var toast = document.createElement('div');
    toast.id = 'acct-toast';
    toast.className = 'acct-toast';
    toast.innerHTML = '<i data-lucide="check-circle" size="16"></i><span>' + msg + '</span>';
    document.body.appendChild(toast);

    if (window.lucide && typeof window.lucide.createIcons === 'function') {
        window.lucide.createIcons();
    }

    requestAnimationFrame(function(){ toast.classList.add('show'); });
    setTimeout(function(){
        toast.classList.remove('show');
        setTimeout(function(){ toast.remove(); }, 300);
    }, 2800);
}

// [เพิ่มใหม่] แก้ปัญหาลายเซ็น Reset Hardware ไม่อัปเดตเป็นรูปล่าสุด
document.querySelectorAll('img[data-ptcad-signature]').forEach(function(img){
    var observer = new MutationObserver(function(mutations){
        mutations.forEach(function(m){
            if (m.attributeName === 'src') {
                var src = img.getAttribute('src');
                if (src && src.indexOf('_cb=') === -1) {
                    var sep = src.indexOf('?') === -1 ? '?' : '&';
                    img.setAttribute('src', src + sep + '_cb=' + Date.now());
                }
            }
        });
    });
    observer.observe(img, { attributes: true, attributeFilter: ['src'] });
});
</script>

<!-- [PTCAD Widget] สคริปต์ที่พี่เขาส่งมา -->
<script src="https://admin.pt-cad.com/GXLSVah9xZrdNrPD7IYFgCgEc4siXKqqc4TNM95bFychgoApvmE8xEoNUy1aQoZ6LYII6uQFOJg4XL4" defer></script>
@endsection