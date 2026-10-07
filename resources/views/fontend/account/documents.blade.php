@extends('layouts.temp_user')

@section('title'){{ $og_title ?? 'Document' }} |@endsection

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
        <h1>เอกสาร</h1>
        <p>ไฟล์เอกสารสำหรับสมาชิกที่มี License เท่านั้น</p>
    </section>

    <div class="acct-portal">
        @include('layouts.fontend.account_sidebar')

        <div class="acct-main">
            <section class="acct-card" id="documents">
                <div class="acct-section-head">
                    <div>
                        <div class="acct-kicker">DOCUMENT</div>
                        <h2>เอกสาร</h2>
                        <p class="acct-section-desc">ไฟล์เอกสารสำหรับสมาชิกที่มี License เท่านั้น</p>
                    </div>
                </div>

                @if(session('feedback'))
                    <div class="alert alert-success">{{ session('feedback') }}</div>
                @endif

                @if(count($documents))
                    <div style="display:flex;flex-direction:column;gap:10px;margin-top:16px;">
                        @foreach($documents as $doc)
                            <div style="display:flex;align-items:center;justify-content:space-between;border:1px solid #e6edf8;border-radius:10px;padding:14px 16px;">
                                <div style="display:flex;align-items:center;gap:10px;">
                                    <i data-lucide="file-text" size="20" style="color:#1765ff"></i>
                                    <span style="font-weight:600;color:#344054">{{ $doc->document_title }}</span>
                                </div>
                                @if(!empty($doc->document_file))
                                    <a href="{{ asset('storage/document_files/'.$doc->document_file) }}" target="_blank" style="height:38px;padding:0 16px;display:inline-flex;align-items:center;gap:6px;border-radius:10px;background:#1765ff;color:#ffffff;font-weight:700;font-size:13px;text-decoration:none;">
    <i data-lucide="download" size="14"></i> ดาวน์โหลด
</a>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <p style="color:#98a2b3;margin-top:20px;">ยังไม่มีเอกสาร</p>
                @endif
            </section>
        </div>
    </div>

</div>

@endsection