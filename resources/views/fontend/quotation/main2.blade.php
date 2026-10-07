@extends('layouts.temp_user')

@section('title'){{ $og_title }} |@endsection
@section('og_site_name'){{ $og_site_name }}@endsection
@section('og_keywords'){{ $og_keywords }}@endsection
@section('og_title'){{ $og_title }}@endsection
@section('og_description'){{ $og_description }}@endsection
@section('og_url'){{ $og_url }}@endsection
@section('og_image'){{ $og_image }}@endsection

@section('css')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
<link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendor/select2-bootstrap4-theme/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/fontend/css/components/radio-checkbox.css') }}" type="text/css" />
<style>
/* ======================================================
   GLOBAL / UTILITIES
   - คุมความกว้างภายใน, กันล้น, เกลี่ย spacing
====================================================== */
.radio-style-2-label{ margin:0 }

.quote-type-scope,
.form-scope{
  width:100%;
  margin:0 auto;
  padding:10px 12px 0;     /* pt=10 ตามที่ขอ + px=12 กันชิดขอบ */
  overflow-x:hidden;       /* กันองค์ประกอบภายในล้นแนวนอน */
  box-sizing:border-box;
}
@media (min-width:1200px){
  .quote-type-scope{ max-width:800px; }
  .form-scope{ max-width:800px; }
}

/* ปิด negative gutter ของ .row ภายใน scope นี้ */
.quote-type-scope .row,
.form-scope .row{ margin-left:0 !important; margin-right:0 !important; }

/* จำลอง gutter ด้วย padding ที่คอลัมน์ */
.quote-type-scope [class^="col-"], .quote-type-scope [class*=" col-"],
.form-scope [class^="col-"], .form-scope [class*=" col-"]{
  padding-left:8px; padding-right:8px; box-sizing:border-box;
}

/* ให้ select2/คอมโพเนนต์ที่มัก fix width ขยายตามคอลัมน์ */
.form-scope .select2-container{ width:100% !important; max-width:100%; }

/* ======================================================
   TYPE PICKER
====================================================== */
.type-picker.row{ flex-wrap:nowrap !important; margin-left:-6px; margin-right:-6px; }
.type-picker .col-sm-6{ padding-left:6px; padding-right:6px; flex:0 0 50% !important; max-width:50% !important; }

.type-picker .type-card{
  width:100%;
  display:flex; flex-direction:column; align-items:center; justify-content:center;
  gap:6px; padding:14px 10px;
  background:#f6f7f9; border:1px solid #e3e6ea; border-radius:12px;
  box-sizing:border-box;
  transition:transform .12s ease, box-shadow .12s ease, border-color .12s ease;
  cursor:pointer; min-height:96px;
}
.type-picker .type-card i{ font-size:28px; line-height:1 }
.type-picker .type-card .t-muted{ font-size:12px; color:#6b7280 }
.type-picker .type-card strong{ font-size:13px }
.type-picker .type-card:hover{ transform:translateY(-1px); box-shadow:0 6px 16px rgba(0,0,0,.05); border-color:#d1d5db }
.type-picker .type-card.active{ border-color:#0d6efd; box-shadow:0 0 0 3px rgba(13,110,253,.12) }

@media (max-width:420px){
  .type-picker .type-card{ padding:10px 8px; min-height:86px; }
  .type-picker .type-card i{ font-size:24px; }
  .type-picker .type-card .t-muted{ font-size:11px; }
  .type-picker .type-card strong{ font-size:12px; }
}

/* ======================================================
   FLOATING LABEL INPUTS
====================================================== */
.fl-group{ position:relative; margin-bottom:18px }
.fl-group input,
.fl-group textarea,
.fl-group select{
  width:100%;
  border:1px solid #ced4da; border-radius:6px;
  padding:16px 12px 12px; background:#fff; font-size:14px;
  box-sizing:border-box;
}
.fl-group textarea{ min-height:120px; resize:vertical }

.fl-group label{
  position:absolute; top:14px; left:12px; font-size:14px; color:#6c757d;
  pointer-events:none; transition:all .18s ease; background:#fff; padding:0 6px; z-index:1;
}
.fl-group:focus-within label,
.fl-group.filled label,
.fl-group input:not(:placeholder-shown)+label,
.fl-group textarea:not(:placeholder-shown)+label{
  transform:translateY(-20px) scale(.86);
  color:#0d6efd;
}
/* error states */
.fl-group.is-invalid input,
.fl-group.is-invalid textarea,
.fl-group.is-invalid select{ border-color:#dc3545 }
.invalid-feedback{ display:block; color:#dc3545; margin-top:4px }

@media (min-width:1200px){
  /* ย่อขนาดบน desktop ให้กระชับกว่า mobile นิดหน่อย */
  .form-scope .fl-group input,
  .form-scope .fl-group textarea,
  .form-scope .fl-group select{
    padding:10px 12px 8px; font-size:13px;
  }
}

/* ======================================================
   CART TABLE (ไม่มีคอลัมน์ “รวม”)
====================================================== */
.cart-table th, .cart-table td{ vertical-align:middle; }
.order-img-xs{ max-width:80px; height:auto; border-radius:8px; }
.amount-sale{ color:#e11d48; }  /* สีแดงนุ่มกว่าหน่อย */

/* ---------- Mobile: แปลงเป็น card-mode, ห้ามล้น --------- */
@media (max-width:767.98px){
  /* ไม่บังคับให้เกิดสกรอลล์แนวนอน */
  .table-responsive{ overflow-x:visible; }

  .cart-table{
    width:100% !important;
    table-layout:fixed;           /* บังคับห่อคำยาว/SKU */
  }

  .cart-table thead{ display:none; }

  .cart-table tr{
    display:block;
    border:1px solid #e3e6ea; border-radius:12px;
    padding:12px; margin-bottom:12px; background:#fff;
  }

  .cart-table td{
    display:grid;                 /* ใช้ grid เพื่อไม่ดันล้นเหมือน flex */
    grid-template-columns:1fr;
    align-items:start;
    gap:6px;
    padding:8px 0 !important;
    border:0 !important;
    width:100%; max-width:100%;
    overflow:hidden;
    word-break:break-word;
    overflow-wrap:anywhere;
  }
  .cart-table td::before{
    content:attr(data-label);
    font-weight:600; color:#6b7280; line-height:1.3;
    display:block; margin-bottom:2px;
  }

  .order-img-xs{ max-width:100px; }

  /* ราคาอยู่บรรทัดใหม่และชิดซ้าย */
  .cart-table .cart-product-price,
  .cart-table .text-right{ text-align:left !important; }

  /* จำนวน: ปุ่มสัมผัสง่าย ไม่ล้น */
  .cart-table [data-label="จำนวน"] .quantity{
    margin-left:0; justify-content:flex-start; width:100%;
  }
}

/* ======================================================
   QUANTITY (เวอร์ชันไร้กรอบ)
====================================================== */
.qty-inline{ display:inline-flex; align-items:center; gap:6px; }
.qty-inline.qty-naked{ border:none; padding:0; gap:10px; }
.qty-inline.qty-naked .minus,
.qty-inline.qty-naked .plus{
  appearance:none; border:none; background:transparent;
  width:28px; height:28px; line-height:28px;
  text-align:center; border-radius:6px; font-size:18px; cursor:pointer;
}
.qty-inline.qty-naked .minus:hover,
.qty-inline.qty-naked .plus:hover{ background:#f5f6f7; }
.qty-inline.qty-naked .qty{
  border:none; background:transparent; width:40px; min-width:40px;
  padding:0; border-radius:0; box-shadow:none;
  text-align:center; font-size:16px;
}
@media (max-width:767.98px){
  .qty-inline.qty-naked{ gap:8px; }
  .qty-inline.qty-naked .qty{ width:48px; min-width:48px; }
  .qty-inline.qty-naked .minus,
  .qty-inline.qty-naked .plus{ width:32px; height:32px; line-height:32px; }
}

/* ======================================================
   CART SUMMARY
====================================================== */
.cart-summary{
  display:flex; justify-content:flex-end; margin-top:16px;
}
.cart-summary .summary-row{
  display:flex; gap:18px; align-items:center;
  padding:12px 16px;
  border:1px solid #e3e6ea; border-radius:10px; background:#fafbfc;
}
.cart-summary .label{ color:#6b7280; }
.cart-summary .value{ font-weight:600; }

@media (max-width:767.98px){
  .cart-summary{ justify-content:stretch; }
  .cart-summary .summary-row{ width:100%; justify-content:space-between; }
}

/* กันเคสองค์ประกอบบางตัวตั้ง min-width เองจนดันล้น */
.cart-table img,
.cart-table input,
.cart-table select,
.cart-table button{ max-width:100%; }

.is-hidden{ display:none !important; }

/* === Push text baseline down a bit (ไม่ชน label) === */
.form-scope .fl-group input,
.form-scope .fl-group select{
  /* เดิมที่เพิ่งตั้งไว้: 17px 12px 14px */
  padding-top: 20px;   /* ↓ ดันตัวอักษรลงอีก ~3px */
  padding-bottom: 12px;
}

/* ยก label ตอนลอยให้สูงขึ้นอีกนิด เพื่อเว้นช่องไฟระหว่าง label กับข้อความ */
.form-scope .fl-group:focus-within label,
.form-scope .fl-group.filled label,
.form-scope .fl-group input:not(:placeholder-shown)+label,
.form-scope .fl-group textarea:not(:placeholder-shown)+label{
  transform: translateY(-24px) scale(.84); /* เดิม -20px scale(.86) */
}

/* Desktop ก็ขยับลงเล็กน้อยให้บาลานซ์ */
@media (min-width:1200px){
  .form-scope .fl-group input,
  .form-scope .fl-group select{
    /* เดิม: 11px 12px 10px */
    padding-top: 14px;  /* ↓ ลงอีก ~3px */
    padding-bottom: 10px;
  }

  .form-scope .fl-group:focus-within label,
  .form-scope .fl-group.filled label,
  .form-scope .fl-group input:not(:placeholder-shown)+label,
  .form-scope .fl-group textarea:not(:placeholder-shown)+label{
    transform: translateY(-22px) scale(.84);
  }
}

/* (ถ้าใช้ Select2) ขยับตำแหน่งข้อความในกล่องเลือกให้ลงตามด้วย */
.form-scope .select2-container--default .select2-selection--single{
  height: auto;                /* ให้สูงตาม padding */
  padding: 10px 12px;          /* ระยะในกล่อง select2 */
  border-radius: 6px;
  border: 1px solid #ced4da;
  background: #fff;
}
.form-scope .select2-container--default .select2-selection--single .select2-selection__rendered{
  padding-left: 0;             /* ใช้ padding ของกล่องแทน */
  margin-top: 2px;             /* ดัน baseline ลงอีกนิด */
}
.form-scope .select2-container--default .select2-selection--single .select2-selection__arrow{
  height: 100%;
}

/* ลอย label เมื่อ select2 โฟกัสหรือเปิด dropdown */
.form-scope .fl-group .select2-container--focus ~ label,
.form-scope .fl-group .select2-container--open  ~ label,
.form-scope .fl-group.filled label{
  transform: translateY(-24px) scale(.84); /* ลอยสูงกว่าปกติเล็กน้อย กันชน */
  color:#0d6efd;
}

/* สูงของกล่อง select2 + baseline ตัวอักษรให้เหมือน input */
.form-scope .select2-container--default .select2-selection--single{
  min-height: 44px;               /* ให้พอ ๆ กับ input ที่เราเพิ่ม padding */
  border:1px solid #ced4da;
  border-radius:6px;
  padding: 10px 36px 10px 12px;   /* ชิดซ้ายพอดี และเผื่อพื้นที่ลูกศรด้านขวา */
  background:#fff;
  box-sizing: border-box;
}
.form-scope .select2-container--default
.select2-selection--single .select2-selection__rendered{
  line-height: 22px;              /* baseline สบายตา ไม่ชน label */
  padding-left: 0;                /* ใช้ padding ของกล่องแทน */
  margin-top: 2px;
}
.form-scope .select2-container--default
.select2-selection--single .select2-selection__arrow{
  height: 100%;
  right: 8px;
}
/* === Select2: make height match text inputs (floating-label friendly) === */

/* ค่าพื้นฐานเดียวกับ input ทั่วไป (อยากปรับความสูงรวม เปลี่ยน padding ได้ตรงนี้) */
:root{
  --fld-pad-y: 16px;   /* top/bottom ของมือถือ */
  --fld-pad-x: 12px;
  --fld-pad-y-desktop: 10px; /* desktop กระชับลง */
}

/* กล่อง select2 เดียวกับ input */
.form-scope .select2-container--default .select2-selection--single{
  min-height: calc((var(--fld-pad-y) * 2) + 20px); /* 20px ≈ line-height เนื้อหา */
  padding: var(--fld-pad-y) calc(var(--fld-pad-x) + 24px) var(--fld-pad-y) var(--fld-pad-x);
  /*         ^ เผื่อพื้นที่ลูกศร +24px                              ^ ขอบซ้าย */
  border: 1px solid #ced4da;
  border-radius: 6px;
  background: #fff;
  box-sizing: border-box;
}

/* ข้อความที่แสดงผลให้กดลงมาหน่อย จะไม่ชน label */
.form-scope .select2-container--default
.select2-selection--single .select2-selection__rendered{
  margin: 0;               /* รีเซ็ต margin เดิมของธีม */
  line-height: 20px;       /* คุม baseline ให้คงที่ */
  padding-left: 0;         /* ใช้ padding ของกล่องแทน */
}

/* ลูกศรชิดขวา และสูงเต็มกล่อง */
.form-scope .select2-container--default
.select2-selection--single .select2-selection__arrow{
  height: 100%;
  right: 8px;
}

/* โฟกัส */
.form-scope .select2-container--default.select2-container--focus
.select2-selection--single{
  outline: 0;
  border-color: #86b7fe;
  box-shadow: 0 0 0 3px rgba(13,110,253,.12);
}

/* Desktop ให้สูงเท่าช่องกรอกฝั่ง desktop ของคุณ */
@media (min-width:1200px){
  .form-scope .select2-container--default .select2-selection--single{
    min-height: calc((var(--fld-pad-y-desktop) * 2) + 20px);
    padding-top: var(--fld-pad-y-desktop);
    padding-bottom: var(--fld-pad-y-desktop);
  }
}

/* ให้ label ลอยเมื่อ select2 โฟกัส/เปิด หรือมีค่า (เข้ากับระบบ .filled ที่คุณทำไว้) */
.form-scope .fl-group .select2-container--open  ~ label,
.form-scope .fl-group .select2-container--focus ~ label,
.form-scope .fl-group.filled label{
  transform: translateY(-24px) scale(.84);
  color:#0d6efd;
}
/* Force the selection box to match our inputs using flex centering */
.form-scope .select2-container--default .select2-selection--single{
  display:flex; align-items:center;           /* align text vertically */
  padding:0 36px 0 12px;                      /* เผื่อพื้นที่ลูกศรขวา */
  border:1px solid #ced4da; border-radius:6px;
  background:#fff; box-sizing:border-box;
}
.form-scope .select2-container--default
.select2-selection--single .select2-selection__rendered{
  padding:0; margin:0; line-height:normal;    /* ไม่ให้ line-height ไปดันความสูง */
}
.form-scope .select2-container--default
.select2-selection--single .select2-selection__arrow{
  height:100%; right:8px;
}

/* Floating label when Select2 is focused/open/has value */
.form-scope .fl-group .select2-container--open  ~ label,
.form-scope .fl-group .select2-container--focus ~ label,
.form-scope .fl-group.filled label{
  transform: translateY(-24px) scale(.84);
  color:#0d6efd;
}
/* ===== Unified field height (mobile/desktop) ===== */
:root{
  --fld-h: 48px;            /* ความสูงรวมบนมือถือ */
  --fld-h-desktop: 44px;    /* ความสูงรวมบน desktop */
  --fld-pad-x: 12px;        /* padding ซ้าย/ขวา */
}

/* ให้ input/select ธรรมดาอย่างน้อยสูงเท่านี้ (ยังคง floating-label เดิมได้) */
.form-scope .fl-group input,
.form-scope .fl-group select:not(.select2-hidden-accessible){
  min-height: var(--fld-h);
  box-sizing: border-box;
}

/* ---- Select2: บังคับเท่าช่องกรอกทุกประการ ---- */
.form-scope .fl-group .select2-container--default .select2-selection--single{
  height: var(--fld-h) !important;
  min-height: var(--fld-h) !important;
  box-sizing: border-box;
  display: flex; align-items: center;
  padding: 0 calc(var(--fld-pad-x) + 24px) 0 var(--fld-pad-x); /* เว้นที่ลูกศร */
  border: 1px solid #ced4da; border-radius: 6px; background: #fff;
  font-size: 14px; line-height: 1.4;
}
.form-scope .fl-group .select2-container--default
.select2-selection--single .select2-selection__rendered{
  margin: 0 !important; padding: 0 !important; line-height: 1.4 !important;
}
.form-scope .fl-group .select2-container--default
.select2-selection--single .select2-selection__arrow{
  height: 100% !important; right: 8px; /* ติดขอบขวาพอดี */
}

/* Floating label ของ select2 (เข้ากับระบบ .filled เดิม) */
.form-scope .fl-group .select2-container--open  ~ label,
.form-scope .fl-group .select2-container--focus ~ label,
.form-scope .fl-group.filled label{
  transform: translateY(-24px) scale(.84);
  color:#0d6efd;
}

/* Desktop: ลดความสูงลงตามตัวแปร */
@media (min-width:1200px){
  .form-scope .fl-group input,
  .form-scope .fl-group select:not(.select2-hidden-accessible){
    min-height: var(--fld-h-desktop);
  }
  .form-scope .fl-group .select2-container--default .select2-selection--single{
    height: var(--fld-h-desktop) !important;
    min-height: var(--fld-h-desktop) !important;
  }
}
/* === Force input text height = 40px (all devices) + keep floating label lift === */

/* กำหนด target เฉพาะ input ประเภทข้อความ ไม่ยุ่ง checkbox/radio/file/date ฯลฯ */
.form-scope .fl-group input:not([type="checkbox"]):not([type="radio"]):not([type="file"]):not([type="range"]):not([type="color"]):not([type="date"]):not([type="datetime-local"]):not([type="month"]):not([type="time"]):not([type="week"]) {
  height: 43px !important;     /* ความสูงรวมเท่ากันทุกอุปกรณ์ */
  min-height: 43px !important;
  padding: 12px 12px 10px;      /* เว้นระยะด้านบนพอให้ label ซ้อนแล้วอ่านง่าย */
  box-sizing: border-box;
}

.form-scope .fl-group select:not(.select2-hidden-accessible) {
  height: 43px !important;
  min-height: 43px !important;
  padding: 8px 12px;            /* ปรับ padding ให้พอดี 40px */
  box-sizing: border-box;
}

/* Select2 ให้สูง 40px ให้ตรงกับ input ด้วย */
.form-scope .fl-group .select2-container--default .select2-selection--single{
  height: 43px !important;
  min-height: 43px !important;
  display: flex; align-items: center;
  padding: 0 36px 0 12px;       /* เว้นลูกศรด้านขวา */
  box-sizing: border-box;
}
.form-scope .fl-group .select2-container--default
.select2-selection--single .select2-selection__rendered{
  margin: 0 !important;
  padding: 0 !important;
  line-height: 1.4 !important;
}

/* ยก label ตอนลอยเพิ่ม +3px จากเดิม (เช่น -24px → -27px) */
.form-scope .fl-group:focus-within label,
.form-scope .fl-group.filled label,
.form-scope .fl-group input:not(:placeholder-shown)+label,
.form-scope .fl-group textarea:not(:placeholder-shown)+label{
  transform: translateY(-27px) scale(.84);
}

/* กรณี Select2 โฟกัส/เปิด/มีค่า ก็ยกเท่ากัน */
.form-scope .fl-group .select2-container--open  ~ label,
.form-scope .fl-group .select2-container--focus ~ label,
.form-scope .fl-group.filled label{
  transform: translateY(-27px) scale(.84);
}
.is-hidden{ display:none !important; }

/* ========== CART: Mobile card layout (XS only) ========== */
@media (max-width: 575.98px){ /* ต่ำกว่า sm ของ Bootstrap */
  /* ปิดหัวตาราง และกัน overflow */
  .cart-table thead{ display:none; }
  .table-responsive{ overflow-x: visible; }

  /* ทำแถวตารางให้เป็นการ์ด */
  .cart-table tr{
    display: grid;
    grid-template-columns: 84px 1fr;               /* ซ้าย=รูป ขวา=ข้อมูล */
    grid-template-areas:
      "thumb info"
      "qty   qty"
      "price price";
    gap: 10px 12px;
    padding: 12px;
    margin-bottom: 12px;
    border: 1px solid #e3e6ea;
    border-radius: 12px;
    background: #fff;
  }
  .cart-table td{
    padding: 0 !important;
    border: 0 !important;
    width: 100%;
    max-width: 100%;
    overflow-wrap: anywhere;
  }

  /* ไม่ต้องโชว์หัวคอลัมน์จำลอง */
  .cart-table td::before{ display:none; }

  /* map พื้นที่ */
  .cart-table td[data-label="#"]{ grid-area: thumb; }
  .cart-table td[data-label="รายละเอียดสินค้า"]{ grid-area: info; }
  .cart-table td[data-label="จำนวน"]{
    grid-area: qty;
    padding-top: 6px !important;
    margin-top: 2px;
    border-top: 1px solid #eef1f4 !important;
  }
  .cart-table td[data-label="ราคา"],
  .cart-table .cart-product-price{
    grid-area: price;
    text-align: right !important;
    padding-top: 4px !important;
    border-top: 1px solid #eef1f4 !important;
    font-weight: 600;
  }

  /* รูปสินค้า */
  .order-img-xs{
    width: 84px;
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    display: block;
  }

  /* ข้อความรายละเอียดกระชับ และไม่ล้น */
  .cart-table td[data-label="รายละเอียดสินค้า"] small{
    color:#6b7280; display:block; margin-bottom:4px;
    word-break: break-word;
  }
  .cart-table td[data-label="รายละเอียดสินค้า"] br{ display:none; } /* ให้เป็นย่อหน้าเดียว */
  .cart-table td[data-label="รายละเอียดสินค้า"]{
    line-height: 1.35;
  }

  /* จำนวน: ปุ่มสัมผัสง่าย ไม่กระเด็น */
  .qty-inline.qty-naked{
    justify-content: space-between; gap: 10px;
    width: 100%;
  }
  .qty-inline.qty-naked .minus,
  .qty-inline.qty-naked .plus{
    width: 36px; height: 36px; line-height: 36px; font-size: 18px;
    border-radius: 8px;
  }
  .qty-inline.qty-naked .qty{
    width: 56px; min-width:56px; font-size: 16px;
  }

  /* ราคา: ให้สกุลเงินขึ้นบรรทัดเดียวกัน สบายตา */
  .cart-table .cart-product-price .currency{ margin-left: 4px; color:#6b7280; font-weight: 500; }

  /* กันองค์ประกอบภายในตั้ง min-width เองจนดันล้น */
  .cart-table img,
  .cart-table input,
  .cart-table select,
  .cart-table button{ max-width:100%; }
}
/* Mobile: keep - [qty] + on one row (no wrap) */
@media (max-width: 575.98px){
  /* กล่องจำนวนให้เป็นแนวนอน ชิดกลาง แถวเดียว */
  .cart-table td[data-label="จำนวน"] .quantity,
  .qty-inline.qty-naked{
    display: inline-flex;
    flex-wrap: nowrap;
    align-items: center;
    justify-content: center;   /* เปลี่ยนเป็น flex-start ถ้าอยากชิดซ้าย */
    gap: 10px;
    width: 100%;
  }

  /* ปุ่ม - / + แตะง่ายพอดีมือ */
  .qty-inline.qty-naked .minus,
  .qty-inline.qty-naked .plus{
    width: 36px; height: 36px; line-height: 36px; font-size: 18px;
    border-radius: 8px;
  }

  /* ช่องจำนวนให้กว้าง 80px และ (ตามที่ขอก่อนหน้า) ตัวเลขชิดขวา */
  .qty-inline .qty,
  .qty-inline.qty-naked .qty{
    width: 80px !important;
    min-width: 80px !important;
    text-align: center !important;   /* เปลี่ยนเป็น center ถ้าชอบกึ่งกลาง */
    margin: 0;
  }
  table.cart .quantity .qty{
	  border-top: 0;
	  border-bottom: 0;
  }
  table.cart .quantity .qty, table.cart .quantity .plus, table.cart .quantity .minus{
	  width: auto;
  }
}
/* ===== Submit Lock & Overlay ===== */
.btn[disabled], .button[disabled]{
  opacity:.7; cursor:not-allowed !important; filter:saturate(.6);
}

.btn.is-loading, .button.is-loading{
  position:relative; pointer-events:none;
}
.btn.is-loading .btn-text, .button.is-loading .btn-text{ visibility:hidden; }
.btn.is-loading::after, .button.is-loading::after{
  content:""; position:absolute; inset:0; margin:auto;
  width:18px; height:18px; border-radius:50%;
  border:2px solid currentColor; border-right-color:transparent;
  animation:spin .8s linear infinite;
}
@keyframes spin { to { transform:rotate(360deg) } }

/* Full-screen overlay while submitting */
#submit-overlay[hidden]{ display:none !important; }
#submit-overlay{
  position:fixed; inset:0; z-index:9999;
  background:rgba(255,255,255,.85); backdrop-filter:blur(3px) saturate(1.2);
  display:flex; align-items:center; justify-content:center; text-align:center;
  padding:24px;
}
.submit-box{
  max-width:560px; width:100%;
  background:#fff; border:1px solid #eef1f4; border-radius:16px;
  padding:22px 18px; box-shadow:0 12px 30px rgba(0,0,0,.08);
}
.submit-box .lead{
  margin-top:10px; color:#4b5563; line-height:1.55;
}
.submit-spinner{
  display:inline-block; width:28px; height:28px; vertical-align:middle;
  border-radius:50%; border:3px solid #111; border-right-color:transparent;
  animation:spin .9s linear infinite; margin-right:8px;
}
/* ระหว่างส่งฟอร์ม: บล็อกการคลิก โดยไม่ตัดค่าฟิลด์ออกจากการ submit */
.form-scope.is-busy { pointer-events: none; }
.form-scope.is-busy input,
.form-scope.is-busy select,
.form-scope.is-busy textarea { caret-color: transparent; }

/* ===== PDPA checkbox (ยินยอมข้อมูลส่วนบุคคล) — แก้เขียว -> น้ำเงินธีม PTCAD ===== */
.pdpa-wb-quotation .checkbox-style:checked + .checkbox-style-3-label:before{
  background: #1765ff !important;
}
.pdpa-wb-quotation .checkbox-style-3-label a{
  color: #1765ff !important;
}

</style>
@endsection



@section('content')

<section id="content">
    <div class="content-wrap">
        <div class="container">
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
           <div class="container-xs topmargin-sm">
                <h1 class="text-center">ขอใบเสนอราคา</h1>
                <div class="text-center">กรุณากรอกข้อมูลการติดต่อให้ครบถ้วน เพื่อให้ทาง PTCAD ได้นำข้อมูลส่วนนี้ไปทำใบเสนอราคาของคุณ</div>
                <hr/>
				@if (Route::has('login'))
					@auth
				
				@else
					<!--div class="b_order" style="border: 1px solid #1265a8;">
						<div class="row">
							<div class="col-md-12">
								สมัครสมาชิกเพื่อรับสิทธิพิเศษเฉพาะลูกค้าใหม่
							</div>
						</div>
						<div class="row">
							<div class="col-md-12" style="padding: 15px;">
								<a href="{{ route('register') }}" class="button button-border button-rounded button-blue" style="margin-right: 30px;">สมัครสมาชิกใหม่</a>
								@if(!empty($extension))
									@if($extension->ext_facebook_status == 1 )
										<a href="{{ route('facebook.login') }}" class="socialite-icon-mar"  >
											<img loading="lazy" class="lazyload socialite-icon" data-src="{{ asset('icon/social/facebook.webp') }}"/>
										</a>
									@endif
									@if($extension->ext_google_status == 1)
										<a href="{{ route('google.login') }}" class="socialite-icon-mar">
											<img  loading="lazy" class="lazyload socialite-icon" data-src="{{ asset('icon/social/google.webp') }}"/>
										</a>
									@endif
								@endif
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								หรือกรอกรายละเอียดด้านล่าง
							</div>
						</div>
					</div-->
					@endauth
				@endif
				
				@php
				  $prefType = $data['userAddress']['userType'] ?? old('type');
				  $showForm = !empty($prefType) || $errors->any();
				@endphp

				<div class="quote-type-scope">
				  <div class="type-picker row topmargin-sm" id="quote-type-picker" aria-label="เลือกประเภทผู้ขอใบเสนอราคา">
					<div class="col-sm-6">
					  <button type="button" class="type-card @if($prefType==1) active @endif" data-type="1" aria-controls="form-quotation">
						<i class="bi bi-person-circle" aria-hidden="true"></i>
						<div>
						  <div class="t-muted">ขอใบเสนอราคาในนาม</div>
						  <strong>บุคคลธรรมดา</strong>
						</div>
					  </button>
					</div>
					<div class="col-sm-6">
					  <button type="button" class="type-card @if($prefType==2) active @endif" data-type="2" aria-controls="form-quotation">
						<i class="bi bi-buildings-fill" aria-hidden="true"></i>
						<div>
						  <div class="t-muted">ขอใบเสนอราคาในนาม</div>
						  <strong>บริษัท/สำนักงาน/องค์กร</strong>
						</div>
					  </button>
					</div>
				  </div>
				</div>

				<div class="row topmargin-sm" id="quote-form-wrap" @if(!$showForm) style="display:none" @endif>

				  <div class="form-scope">
					<form id="form-quotation" method="POST" action="{{ route('fronend.quotation.crate2') }}">
					  @csrf
					  <input type="hidden" id="type" name="type" value="{{ $prefType ?? '' }}">

						{{-- ซ่อนค่าอัตโนมัติเดิม --}}
						@if(!empty($data['userAddress']))
						  <input id="address_province" name="address_province" type="hidden" value="{{-- $data['userAddress']['userProvince'] --}}">
						  <input id="address_amphures" name="address_amphures" type="hidden" value="{{-- $data['userAddress']['userAmphures'] --}}">
						  <input id="address_district" name="address_district" type="hidden" value="{{-- $data['userAddress']['userDistrict'] --}}">
						  <input id="address_zipcode" name="address_zipcode" type="hidden" value="{{-- $data['userAddress']['userZipcode'] --}}">
						@endif
						<input id="ref" name="ref" type="hidden" @if (!empty($_GET['_ref'])) value="{{ $_GET['_ref'] }}" @else value="" @endif>

						{{-- ---- เริ่มฟิลด์เรียงใหม่ ---- --}}

						<div class="row g-3">

						  {{-- company --}}
						  <div class="col-md-6">
							<div class="fl-group @error('company') is-invalid @enderror">
							  <input type="text" id="company" name="company" placeholder=" "
								value="{{ $data['userAddress']['userCompany'] ?? old('company') }}">
							  <label for="company">ชื่อบริษัท/องค์กร <span class="span-danger">*</span></label>
							</div>
							@error('company')<small class="invalid-feedback"><strong>{{ $message }}</strong></small>@enderror
						  </div>

						  {{-- fullname --}}
						  <div class="col-md-6">
							<div class="fl-group @error('fullname') is-invalid @enderror">
							  <input type="text" id="fullname" name="fullname" placeholder="" value="@if(old('fullname')){{ old('fullname') }}@elseif(!empty($data['userAddress']['userName']) || !empty($data['userAddress']['userLastname'])){{ trim(($data['userAddress']['userName'] ?? '').' '.($data['userAddress']['userLastname'] ?? '')) }}@endif">
							  <label for="fullname">ชื่อ-สกุล ผู้ติดต่อ <span class="span-danger">*</span></label>
							</div>
							@error('fullname')<small class="invalid-feedback"><strong>{{ $message }}</strong></small>@enderror
						  </div>

						  {{-- tel --}}
						  <div class="col-md-6">
							<div class="fl-group @error('tel') is-invalid @enderror">
							  <input type="text" id="tel" name="tel" class="n_tel" placeholder=" "
								value="{{ $data['userAddress']['userTel'] ?? old('tel') }}">
							  <label for="tel">เบอร์โทรศัพท์ <span class="span-danger">*</span></label>
							</div>
							@error('tel')<small class="invalid-feedback"><strong>{{ $message }}</strong></small>@enderror
						  </div>

						  {{-- email --}}
						  <div class="col-md-6">
							<div class="fl-group @error('email') is-invalid @enderror">
							  <input type="text" id="email" name="email" class="c_email" placeholder=" "
								value="{{ $data['userAddress']['userEmail'] ?? old('email') }}">
							  <label for="email">อีเมล <span class="span-danger">*</span></label>
							</div>
							@error('email')<small class="invalid-feedback"><strong>{{ $message }}</strong></small>@enderror
						  </div>

						  {{-- address --}}
						  <div class="col-md-6">
							<div class="fl-group @error('address') is-invalid @enderror">
							  <input type="text" id="address" name="address" placeholder=" "
								value="{{ $data['userAddress']['userAddress'] ?? old('address') }}">
							  <label for="address">บ้านเลขที่ ถนน ซอย <span class="span-danger">*</span></label>
							</div>
							@error('address')<small class="invalid-feedback"><strong>{{ $message }}</strong></small>@enderror
						  </div>

						  {{-- province --}}
						  <div class="col-md-6">
							<div class="fl-group @error('province') is-invalid @enderror">
							  <select id="province" name="province" onchange="amphuresAddress()">
								<option value=""></option>
								@foreach ($provinces as $province)
									<?php /* <option value="{{ $province->id }}" {{ old('province', $data['userAddress']['userProvince'] ?? null) == $province->id ? 'selected' : '' }}> */ ?>
									<option value="{{ $province->id }}">
									  {{ $province->prov_name_th }}
									</option>
								@endforeach
							  </select>
							  <label for="province">จังหวัด <span class="span-danger">*</span></label>
							</div>
							@error('province')<small class="invalid-feedback"><strong>{{ $message }}</strong></small>@enderror
						  </div>

						  {{-- amphures --}}
						  <div class="col-md-6">
							<div class="fl-group @error('amphures') is-invalid @enderror">
							  <select id="amphures" name="amphures" onchange="districtAddress()">
								<option value=""></option>
							  </select>
							  <label for="amphures">เขต / อำเภอ <span class="span-danger">*</span></label>
							</div>
							@error('amphures')<small class="invalid-feedback"><strong>{{ $message }}</strong></small>@enderror
						  </div>

						  {{-- district --}}
						  <div class="col-md-6">
							<div class="fl-group @error('district') is-invalid @enderror">
							  <select id="district" name="district" onchange="zipcodeAddress()">
								<option value=""></option>
							  </select>
							  <label for="district">แขวง / ตำบล <span class="span-danger">*</span></label>
							</div>
							@error('district')<small class="invalid-feedback"><strong>{{ $message }}</strong></small>@enderror
						  </div>

						  {{-- zipcode --}}
						  <div class="col-md-6">
							<div class="fl-group @error('zipcode') is-invalid @enderror">
							  <input type="text" id="zipcode" name="zipcode" placeholder=" "
								value="{{ $data['userAddress']['userZipcode'] ?? old('zipcode') }}">
							  <label for="zipcode">รหัสไปรษณีย์ <span class="span-danger">*</span></label>
							</div>
							@error('zipcode')<small class="invalid-feedback"><strong>{{ $message }}</strong></small>@enderror
						  </div>

						  {{-- message (เต็มความกว้าง) --}}
						  <div class="col-12">
							<div class="fl-group @error('message') is-invalid @enderror">
							  <textarea id="message" name="message" placeholder=" " rows="3">{{ old('message') }}</textarea>
							  <label for="message">ข้อความถึงผู้ขาย (ตัวอย่าง: สนใจโปรแกรม Adobe Photoshop 10 license)</label>
							</div>
							@error('message')<small class="invalid-feedback"><strong>{{ $message }}</strong></small>@enderror
						  </div>

						</div>

						{{-- ---- จบฟิลด์เรียงใหม่ ---- --}}

						@if(!empty($data['productDetail']))
							<input type="hidden" id="productImg" name="productImg" value="{{ $data['productDetail']['image'] }}" />
							<input type="hidden" id="productSku" name="productSku" value="{{ $data['productDetail']['sku'] }}" />
							<input type="hidden" id="productName" name="productName" value="{{ $data['productDetail']['name'] }}" />
							<input type="hidden" id="productDetail" name="productDetail" value="{{ $data['productDetail']['detail_name'] }}" />
							<input type="hidden" id="productPrice" name="productPrice" value="{{ $data['productDetail']['detailPrice'] }}" />
							<input type="hidden" id="productPricesale" name="productPricesale" value="{{ $data['productDetail']['detailPriceSale'] }}" />
							<div class="col_full">
								<div class="table-responsive">
								  <table class="table cart cart-table">
									<thead>
									  <tr>
										<th>#</th>
										<th>รายละเอียดสินค้า</th>
										<th class="text-center" style="width:160px;">จำนวน</th>
										<th class="text-right">ราคา</th>
									  </tr>
									</thead>
									<tbody>
									  @php
										$unitPrice = !empty($data['productDetail']['detailPriceSale'])
													  ? $data['productDetail']['detailPriceSale']
													  : ($data['productDetail']['detailPrice'] ?? 0);
										$qty = (int)($data['productDetail']['unit'] ?? 1);
										$rowId = $data['productDetail']['id'];
									  @endphp

									  <tr class="cart-row" data-row-id="{{ $rowId }}">
										<td class="cart-cell" data-label="#">
										  <img src="{{ $data['productDetail']['image'] }}" class="order-img-xs" />
										</td>

										<td class="cart-cell" data-label="รายละเอียดสินค้า">
										  <small>SKU : {{ $data['productDetail']['sku'] }}</small>
										  @if(!empty($data['productDetail']['detail_other']))
											<br/>{{ $data['productDetail']['detail_name'] }}
											<br/>{{ $data['productDetail']['detail_other'] }}
										  @else
											@if($data['productDetail']['name'] != $data['productDetail']['detail_name'])
											  <br/>{{ $data['productDetail']['name'] }}
											  <br/>{{ $data['productDetail']['detail_name'] }}
											@else
											  <br/>{{ $data['productDetail']['name'] }}
											@endif
										  @endif
										</td>
										
										{{-- จำนวน --}}
										<td class="cart-cell text-center" data-label="จำนวน">
										  <div class="quantity qty-inline qty-naked">
											<button type="button" class="minus" data-id="{{ $rowId }}" aria-label="ลดจำนวน">−</button>
											<input type="text"
												   id="quantity-{{ $rowId }}"
												   data-id="{{ $rowId }}"
												   name="productUnit"
												   class="qty"
												   value="{{ $qty }}"
												   min="1" step="1" inputmode="numeric" />
											<button type="button" class="plus" data-id="{{ $rowId }}" aria-label="เพิ่มจำนวน">+</button>
										  </div>
										</td>

										{{-- ราคา/หน่วย: เก็บตัวเลขไว้ใน data-unit-price --}}
										<td class="cart-cell text-right cart-product-price"
											data-label="ราคา"
											data-unit-price="{{ $unitPrice }}">
										  @if (!empty($data['productDetail']['detailPriceSale']) && ($data['productDetail']['detailPriceSale'] < $data['productDetail']['detailPrice']))
											<span class="amount-sale">{{ number_format($data['productDetail']['detailPrice']) }}</span>
											{{ number_format($unitPrice, 2) }}
										  @else
											{{ number_format($unitPrice, 2) }}
										  @endif
										  <span class="currency">บาท</span>
										</td>

										
									  </tr>
									</tbody>
								  </table>
								</div>

								{{-- ✅ ยอดรวมทั้งหมด (คงเดิม) --}}
								<div class="cart-summary">
								  <div class="summary-row">
									<div class="label">ยอดรวมทั้งหมด</div>
									<div class="value"><span id="grand-total">{{ number_format($unitPrice * $qty, 2) }}</span> <span class="currency">บาท</span></div>
								  </div>
								</div>

							</div>
						@endif
						@if(!empty($settingUser))
							@if($settingUser->pdpa_status == 1)
								<div class="col_full">
									<div class="pdpa-wb-quotation">
										<input type="checkbox"  id="pdpa_wording" name="pdpa_wording" value="1" class="checkbox-style" @if (!empty(old('pdpa_wording1'))) checked @endif>
										<label for="pdpa_wording" class="checkbox-style-3-label">{!! $settingUser->pdpa_detail !!}</label>
									</div>
								</div>
							@endif
						@endif
						<div class="col_full">
							@if(!empty($extension))
								@if($extension->ext_captcha_status == 1)
									<script src="https://www.google.com/recaptcha/api.js"></script>
									<button class="loadding btn btn-outline-quotation g-recaptcha" data-sitekey="{{$extension->ext_captcha}}" data-callback='onSubmit' data-action='submit'>
								@else
									<button class="loadding btn btn-outline-quotation" >
								@endif
							@else
								<button class="loadding btn btn-outline-quotation" >
							@endif
								<span class="btn-text">ส่งข้อมูลขอใบเสนอราคา</span>
							</button>
						</div>
					</form>
				  </div>

				</div>
            </div>
			
			<!-- Overlay ขณะกำลังส่งฟอร์ม -->
			<div id="submit-overlay" hidden aria-live="polite" aria-busy="true">
			  <div class="submit-box">
				<div class="h5" style="margin:0 0 6px;">
				  <span class="submit-spinner" aria-hidden="true"></span>
				  โปรดรอสักครู่...
				</div>
				<div class="lead">
				  ระบบกำลังดำเนินการออกใบเสนอราคาให้ท่าน<br>
				  กรุณาอย่าปิดหน้าต่างหรือกดซ้ำ
				</div>
			  </div>
			</div>

        </div>
    </div>
</section>

@endsection

@section('js')
<script src="{{ asset('vendor/select2/select2.min.js') }}"></script>
<script src="{{ asset('vendor/select2-bootstrap4-theme/docs/script.js') }}"></script>

<script>
/* =========================================================
 * PTCAD Quotation – Clean JS (single block)
 * =======================================================*/

/* 0) reCAPTCHA submit */
function onSubmit(){ document.getElementById('form-quotation').submit(); }

document.addEventListener('DOMContentLoaded', function () {
  const $ = window.jQuery;

  /* ---------- helpers ---------- */
  const q  = (sel, root=document) => root.querySelector(sel);
  const qa = (sel, root=document) => Array.from(root.querySelectorAll(sel));
  const fireChange = el => el && el.dispatchEvent(new Event('change', { bubbles:true }));
  const hasOption  = (sel, v) => !!sel && Array.prototype.some.call(sel.options, o => String(o.value) === String(v));
  const markFilled = el => el?.closest('.fl-group')?.classList.add('filled');
  const hasValue   = el => !!(el && String(el.value || '').trim() !== '');

  /* =======================================================
   * 1) Type picker (บุคคล/บริษัท) + toggle company field
   * =====================================================*/
  (function TypePicker(){
    const picker = q('#quote-type-picker');
    const typeInput = q('#type');
    const formWrap = q('#quote-form-wrap');
    const companyInput = q('#company');

    function companyWrapper(){
      if(!companyInput) return null;
      return companyInput.closest('.col-md-6') || companyInput.closest('.fl-group') || companyInput.parentElement;
    }
    function toggleCompany(typeVal){
      const wrap = companyWrapper(); if(!wrap) return;
      const isPersonal = String(typeVal) === '1';
      if(isPersonal){
        wrap.classList.add('is-hidden');
        companyInput.dataset.prevRequired = companyInput.required ? 'true' : 'false';
        companyInput.required = false; companyInput.disabled = true;
      }else{
        wrap.classList.remove('is-hidden');
        companyInput.disabled = false;
        if(companyInput.dataset.prevRequired === 'true') companyInput.required = true;
      }
    }

    if(picker){
      const cards = qa('.type-card', picker);
      cards.forEach(btn=>{
        btn.addEventListener('click', ()=>{
          const t = btn.dataset.type;
          if(typeInput) typeInput.value = t;
          cards.forEach(b=>b.classList.remove('active'));
          btn.classList.add('active');
          if(formWrap){ formWrap.style.display='block'; formWrap.scrollIntoView({behavior:'smooth', block:'start'}); }
          toggleCompany(t);
        });
      });
    }
    if(typeInput && typeInput.value){
      formWrap && (formWrap.style.display = 'block');
      picker?.querySelector(`.type-card[data-type="${typeInput.value}"]`)?.classList.add('active');
      toggleCompany(typeInput.value);
    }
  })();

  /* =======================================================
   * 2) Floating label (inputs, textareas, selects)
   * =====================================================*/
  (function FloatingLabels(){
    const els = qa('.form-scope .fl-group input, .form-scope .fl-group textarea, .form-scope .fl-group select');
    els.forEach(el=>{
      const wrap = el.closest('.fl-group');
      const toggle = () => wrap && wrap.classList.toggle('filled', hasValue(el));
      toggle(); // on load (support default/autofill)
      el.addEventListener('input',  toggle);
      el.addEventListener('change', toggle);
    });
  })();

  /* =======================================================
   * 3) Init Select2 (once) + match height with inputs
   * =====================================================*/
  (function Select2Init(){
    if ($ && $.fn && $.fn.select2) {
      $('.form-scope .fl-group select').each(function(){
        if (!$(this).data('select2')) $(this).select2({ theme:'bootstrap4', width:'100%' });
      });
      // float label while open / after clear
      $('.form-scope .fl-group select')
        .on('select2:open', function(){ markFilled(this); })
        .on('select2:close select2:select select2:unselect select2:clear change', function(){
          this.closest('.fl-group')?.classList.toggle('filled', hasValue(this));
        });
    }

    function equalizeSelect2Height(){
      const probe = q('.form-scope .fl-group input, .form-scope .fl-group textarea');
      const targetH = probe ? Math.ceil(probe.getBoundingClientRect().height) : 44;
      qa('.form-scope .select2-container .select2-selection--single').forEach(el=>{
        el.style.height = el.style.minHeight = targetH + 'px';
      });
    }
    equalizeSelect2Height();
    window.addEventListener('resize', equalizeSelect2Height);
    document.addEventListener('select2:open',  equalizeSelect2Height, true);
    document.addEventListener('select2:close', equalizeSelect2Height, true);
    setTimeout(equalizeSelect2Height, 0);
  })();

  /* =======================================================
   * 4) Qty +/- & Grand Total
   * =====================================================*/
  (function CartQtyAndSum(){
    const fmt = new Intl.NumberFormat('th-TH', { minimumFractionDigits:2, maximumFractionDigits:2 });

    function getQtyInput(btn){ return btn.closest('.quantity')?.querySelector('.qty'); }
    function parseMeta(input){
      const step = parseFloat(input.getAttribute('step')) || 1;
      const min  = parseFloat(input.getAttribute('min'))  || 1;
      const max  = input.getAttribute('max') ? parseFloat(input.getAttribute('max')) : Infinity;
      let val = parseFloat((input.value||'').toString().replace(/[^\d.-]/g,'')) || 0;
      return { val, step, min, max };
    }
    function rowUnitPrice(row){
      const el = row.querySelector('.cart-product-price');
      const n  = el ? parseFloat(el.getAttribute('data-unit-price')) : 0;
      return isNaN(n) ? 0 : n;
    }
    function rowQty(row){
      const input = row.querySelector('.qty');
      const v = parseInt((input && input.value) ? input.value.replace(/[^\d]/g,'') : '1', 10);
      return isNaN(v) || v < 1 ? 1 : v;
    }
    function updateGrand(){
      let sum = 0;
      qa('.cart-row').forEach(row => sum += rowUnitPrice(row) * rowQty(row));
      const g = q('#grand-total'); if(g) g.textContent = fmt.format(sum);
    }

    document.addEventListener('click', function(e){
      const t = e.target;
      if(!(t.classList && (t.classList.contains('plus') || t.classList.contains('minus')))) return;
      e.preventDefault();
      const input = getQtyInput(t); if(!input) return;
      const meta = parseMeta(input);
      let next = t.classList.contains('plus') ? meta.val + meta.step : meta.val - meta.step;
      if(next < meta.min) next = meta.min;
      if(next > meta.max) next = meta.max;
      input.value = String(Math.round(next));
      fireChange(input);
      updateGrand();
    });
    document.addEventListener('input',  e => { if(e.target.classList?.contains('qty')){ e.target.value = e.target.value.replace(/[^\d]/g,''); }});
    document.addEventListener('change', e => { if(e.target.classList?.contains('qty')){ let v=parseInt(e.target.value||'0',10); if(isNaN(v)||v<1)v=1; e.target.value=String(v); updateGrand(); }});
    updateGrand();
  })();

  /* =======================================================
   * 5) Address cascade – keep defaults & float labels
   *    province -> amphures -> district (async safe)
   * =====================================================*/
  (async function AddressCascade(){
    const S = {
      province: q('#province'),
      amphures: q('#amphures'),
      district: q('#district'),
      hidProv:  q('#address_province'),
      hidAmph:  q('#address_amphures'),
      hidDist:  q('#address_district'),
    };
    const def = {
      prov: (S.hidProv?.value  || '').trim(),
      amph: (S.hidAmph?.value  || '').trim(),
      dist: (S.hidDist?.value  || '').trim(),
    };

    // ใช้ค่า default เฉพาะตอน select ยังว่างเท่านั้น (ไม่ทับ old())
    if(S.province && !hasValue(S.province) && def.prov && hasOption(S.province, def.prov)){
      S.province.value = def.prov;
      if ($ && $.fn?.select2 && $(S.province).data('select2')) $(S.province).val(def.prov).trigger('change.select2');
      markFilled(S.province); fireChange(S.province); // ให้โหลด amphures
    }

    // รอ amphures ถูกเติม แล้วตั้งค่า
    await new Promise(resolve=>{
      if(!S.amphures || !def.amph){ resolve(); return; }
      if(hasOption(S.amphures, def.amph)){ resolve(); return; }
      const obs = new MutationObserver(()=>{ if(hasOption(S.amphures, def.amph)){ obs.disconnect(); resolve(); } });
      obs.observe(S.amphures, { childList:true, subtree:true });
      setTimeout(()=>{ obs.disconnect(); resolve(); }, 8000);
    });
    if(S.amphures && !hasValue(S.amphures) && def.amph){
      S.amphures.value = def.amph;
      if ($ && $.fn?.select2 && $(S.amphures).data('select2')) $(S.amphures).val(def.amph).trigger('change.select2');
      markFilled(S.amphures); fireChange(S.amphures); // ไปโหลด district
    }

    // รอ district แล้วตั้งค่า
    await new Promise(resolve=>{
      if(!S.district || !def.dist){ resolve(); return; }
      if(hasOption(S.district, def.dist)){ resolve(); return; }
      const obs = new MutationObserver(()=>{ if(hasOption(S.district, def.dist)){ obs.disconnect(); resolve(); } });
      obs.observe(S.district, { childList:true, subtree:true });
      setTimeout(()=>{ obs.disconnect(); resolve(); }, 8000);
    });
    if(S.district && !hasValue(S.district) && def.dist){
      S.district.value = def.dist;
      if ($ && $.fn?.select2 && $(S.district).data('select2')) $(S.district).val(def.dist).trigger('change.select2');
      markFilled(S.district); fireChange(S.district); // ให้ flow คำนวณ zipcode ต่อได้
    }
  })();

});
</script>
<script>
(function(){
  const form  = document.getElementById('form-quotation');
  const btn   = document.querySelector('#form-quotation .loadding');
  const mask  = document.getElementById('submit-overlay');
  let locked  = false;

  function showOverlay(active){
	  if (!mask) return;
	  // active = true => โชว์ | active = false => ซ่อน
	  mask.hidden = !active;
	}


  function lockFormUI(){
    if (locked) return;
    locked = true;

    // 1) ปุ่มโหลด + disable แค่ปุ่ม
    if (btn){
      btn.classList.add('is-loading');
      btn.setAttribute('disabled', 'disabled');
    }

    // 2) บล็อกการคลิกทั้งฟอร์ม (แต่ "ไม่" disabled ฟิลด์)
    const scope = form.closest('.form-scope');
    if (scope) scope.classList.add('is-busy');

    // 3) โชว์ overlay
    showOverlay(true);

    // 4) กันกดซ้ำ
    form.dataset.submitting = "1";
  }

  function unlockFormUI(){
    locked = false;

    if (btn){
      btn.classList.remove('is-loading');
      btn.removeAttribute('disabled');
    }
    const scope = form.closest('.form-scope');
    if (scope) scope.classList.remove('is-busy');

    showOverlay(false);
    delete form.dataset.submitting;
  }

  // Hook submit ปกติ
  if (form){
    form.addEventListener('submit', function(e){
      if (form.dataset.submitting === "1"){ e.preventDefault(); return false; }
      lockFormUI(); // แล้วปล่อยให้เบราว์เซอร์ submit ตามปกติ
    });
  }

  // reCAPTCHA callback (ถ้ามี)
  window.onSubmit = function(){
    if (!form) return;
    if (form.dataset.submitting === "1") return false;
    lockFormUI();
    form.submit();
  };

  // ==== สถานะตอนโหลดหน้าใหม่ ====
  // 1) ซ่อน overlay เป็นค่าเริ่มต้นทุกครั้ง
  showOverlay(false);

  // 2) ถ้ามี validation error จาก server -> ปลดล็อกทันทีให้กรอกต่อได้
  const hasErrors = !!document.querySelector('.invalid-feedback strong');
  if (hasErrors) unlockFormUI();

  // 3) หน้ามาจาก bfcache (กด back) -> ปลดล็อก
  window.addEventListener('pageshow', function(ev){
    if (ev.persisted) unlockFormUI();
  });

  // กันคลิกซ้ำที่ปุ่ม (บางธีมมี handler ซ้ำ)
  if (btn){
    btn.addEventListener('click', function(e){
      if (form.dataset.submitting === "1"){ e.preventDefault(); return false; }
    });
  }
})();
</script>


@endsection