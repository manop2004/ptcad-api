@extends('layouts.temp_user')

@section('title'){{ $og_title }} |@endsection
@section('og_site_name'){{ $og_site_name }}@endsection
@section('og_keywords'){{ $og_keywords }}@endsection
@section('og_title'){{ $og_title }}@endsection
@section('og_description'){{ $og_description }}@endsection
@section('og_url'){{ $og_url }}@endsection
@section('og_image'){{ $og_image }}@endsection

@section('css')
<link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendor/select2-bootstrap4-theme/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/fontend/css/components/radio-checkbox.css') }}" type="text/css" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

<style>
/* ---------- CSS Variables (PTCAD Theme) ---------- */
:root {
  --ptcad-primary: #2563eb;
  --ptcad-primary-hover: #1d4ed8;
  --ptcad-bg-light: #f8fafc;
  --ptcad-chip-bg: #f0f6ff;
  --ptcad-chip-border: #dbeafe;
  --ptcad-chip-text: #1e40af;
}

/* ---------- Base tweaks ---------- */
.radio-style-2-label{ margin:0 }
.container-xs{ max-width: 880px; margin: 0 auto; }

/* ---------- Status card ---------- */
.status-card{
  background:#fff;
  border:1px solid #e2e8f0;
  border-radius:16px;
  box-shadow:0 10px 25px -5px rgba(37, 99, 235, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.01);
  padding:28px 24px;
}
.status-head{
  display:flex;
  align-items:center;
  gap:16px;
  justify-content:center;
  text-align:left;
}
.status-icon-blue{
  font-size: 52px;
  color: var(--ptcad-primary);
  line-height: 1;
  display: flex;
  align-items: center;
  justify-content: center;
}
.status-title{
  margin:0;
  font-weight:700;
  letter-spacing:-0.2px;
  color: #0f172a;
  font-size: 1.35rem;
}
.status-sub{color:#64748b; margin-top:4px; font-size: 0.95rem;}

/* ---------- Meta row ---------- */
.meta-row{
  display:flex; flex-wrap:wrap; gap:10px; justify-content:center; margin:20px 0 0
}
.meta-chip{
  background: var(--ptcad-chip-bg);
  border: 1px solid var(--ptcad-chip-border);
  color: var(--ptcad-chip-text);
  border-radius: 999px;
  padding: 6px 16px;
  font-size: 13.5px;
  font-weight: 500;
  display: inline-flex;
  gap: 8px;
  align-items: center;
}
.meta-chip .bi{ font-size: 15px; color: var(--ptcad-primary); }

/* ---------- Toolbar (sticky) ---------- */
.pdf-toolbar{
  position:sticky; top:62px; z-index:8;
  display:flex; flex-wrap:wrap; gap:10px; justify-content:center;
  background:rgba(255,255,255,.95); backdrop-filter:saturate(1.2) blur(8px);
  border:1px solid #e2e8f0; border-radius:12px; padding:12px;
  margin:16px auto 14px; max-width:880px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.03);
}
.pdf-toolbar .btn-ptcad{
  margin:0;
  border-radius: 8px;
  padding: 8px 18px;
  font-size: 14px;
  font-weight: 500;
  display: inline-flex;
  align-items: center;
  gap: 6px;
  transition: all 0.2s ease;
  border: 1px solid var(--ptcad-primary);
  color: var(--ptcad-primary);
  background: #fff;
  text-decoration: none;
  cursor: pointer;
}
.pdf-toolbar .btn-ptcad:hover{
  background: var(--ptcad-primary);
  color: #fff;
}
.pdf-toolbar .btn-ptcad-primary{
  background: var(--ptcad-primary);
  color: #fff;
}
.pdf-toolbar .btn-ptcad-primary:hover{
  background: var(--ptcad-primary-hover);
  border-color: var(--ptcad-primary-hover);
}

/* ---------- PDF preview ---------- */
.pdf-frame-wrap{
  width:100%;
  min-height:60vh;
  height:80vh;
  position:relative;
  border:1px solid #e2e8f0;
  border-radius:14px;
  overflow:hidden;
  background:#fff;
  box-shadow:0 8px 24px rgba(0,0,0,.06);
}
@media (max-width: 767.98px){
  .pdf-frame-wrap{ height:75vh }
  .status-head{ flex-direction: column; text-align: center; }
}
.pdf-frame,.pdf-object{
  position:absolute;inset:0;width:100%;height:100%;border:none
}

/* ---------- Empty / waiting ---------- */
.empty{
  text-align:center;padding:32px 18px;border:1px dashed #cbd5e1;border-radius:16px;background:#f8fafc
}
.empty .bi{font-size:36px;color: var(--ptcad-primary)}
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

      <div class="container-xs topmargin-sm bottommargin-sm">
        @if($quotation)
          <div class="status-card">
            <div class="status-head">
              {{-- ใช้ไอคอน Bootstrap สไตล์สีน้ำเงิน --}}
              <div class="status-icon-blue">
                <i class="bi bi-check-circle-fill"></i>
              </div>
              <div>
                <h3 class="status-title">คำขอใบเสนอราคาของคุณสำเร็จแล้ว</h3>
                <div class="status-sub">เราได้ทำการจัดส่ง ใบเสนอราคา ไปตามอีเมลที่ระบุ (หากไม่พบกรุณาตรวจสอบที่ Junk E-Mail)</div>
              </div>
            </div>

            {{-- meta chips --}}
            <div class="meta-row">
              @if(!empty($quotation->quotationNumber))
                <span class="meta-chip"><i class="bi bi-hash"></i> เลขที่: {{ $quotation->quotationNumber }}</span>
              @endif
              @if(!empty($quotation->productName))
                <span class="meta-chip"><i class="bi bi-box-seam"></i> สินค้า: {{ $quotation->productName }}</span>
              @endif
              @if(isset($quotation->productUnit))
                <span class="meta-chip"><i class="bi bi-layers"></i> จำนวน: {{ $quotation->productUnit }}</span>
              @endif
              @if(isset($quotation->productTotal))
                <span class="meta-chip"><i class="bi bi-currency-dollar"></i> มูลค่า: {{ number_format($quotation->productTotal, 2) }} THB</span>
              @endif
            </div>
          </div>

          @if($hasFile && !empty($fileUrl))
            {{-- Toolbar --}}
            <div class="pdf-toolbar">
              <a href="{{ $fileUrl }}" class="btn-ptcad btn-ptcad-primary" download>
                <i class="bi bi-download"></i> ดาวน์โหลดเอกสาร
              </a>
              <button type="button" class="btn-ptcad" id="btnPrintPdf">
                <i class="bi bi-printer"></i> พิมพ์เอกสาร
              </button>
            </div>

            {{-- Preview PDF --}}
            <div class="pdf-frame-wrap">
              <iframe
                id="pdfFrame"
                class="pdf-frame"
                src="{{ $fileUrl }}#view=FitH&zoom=page-width&toolbar=1&navpanes=0&scrollbar=1"
                title="Quotation Preview"
                loading="lazy"
              ></iframe>

              {{-- Fallback --}}
              <object data="{{ $fileUrl }}" type="application/pdf" class="pdf-object" aria-label="PDF object fallback">
                ไม่สามารถแสดงตัวอย่างไฟล์ได้
                <a href="{{ $fileUrl }}" target="_blank" rel="noopener">คลิกเพื่อเปิดไฟล์</a>
              </object>
            </div>

            {{-- GA Event --}}
            <script>
              gtag("event", "quotation", {
                transaction_id: "{{ $quotation->quotationNumber }}",
                value: "{{ number_format($quotation->productTotal, 2, '.', '') }}",
                currency: "THB",
                item_id: "{{ $quotation->productSku }}",
                item_name: "{{ $quotation->productName }}",
                item_brand: "",
                price: "{{ number_format(($quotation->productPrice), 2, '.', '') }}",
                quantity: "{{ $quotation->productUnit }}"
              });
            </script>
          @else
            <div class="empty">
              <div><i class="bi bi-hourglass-split"></i></div>
              <h4 class="topmargin-sm" style="color: #1e293b; font-weight: 600;">กำลังจัดเตรียมเอกสาร</h4>
              <div class="status-sub">กรุณารอเจ้าหน้าที่ติดต่อกลับ หรือรีเฟรชเพจในภายหลัง</div>
            </div>
          @endif

        @else
          <div class="status-card">
            <div class="status-head">
              <div class="status-icon-blue" style="color: #ef4444;">
                <i class="bi bi-x-circle-fill"></i>
              </div>
              <div>
                <h3 class="status-title">คำขอใบเสนอราคาไม่สำเร็จ</h3>
                <div class="status-sub">กรุณาลองใหม่อีกครั้ง หรือติดต่อเจ้าหน้าที่เพื่อความช่วยเหลือ</div>
              </div>
            </div>
            <div class="text-center topmargin-sm">
              <a href="{{ route('fronend.quotation') }}" class="btn-ptcad btn-ptcad-primary" style="padding: 10px 24px;">
                กลับหน้าขอใบเสนอราคา
              </a>
            </div>
          </div>
        @endif
      </div>

    </div>
  </div>
</section>
@endsection

@section('js')
<script src="{{ asset('vendor/select2/select2.min.js') }}"></script>
<script src="{{ asset('vendor/select2-bootstrap4-theme/docs/script.js') }}"></script>
<script>
// พิมพ์ไฟล์จาก iframe
document.getElementById('btnPrintPdf')?.addEventListener('click', function () {
  const frame = document.getElementById('pdfFrame');
  try {
    frame.contentWindow.focus();
    frame.contentWindow.print();
  } catch (e) {
    const altUrl = document.getElementById('btnCopyLink')?.dataset?.url || '';
    if (altUrl) window.open(altUrl, '_blank');
  }
});

// คัดลอกลิงก์ไฟล์
document.getElementById('btnCopyLink')?.addEventListener('click', async function () {
  const url = this.dataset.url || window.location.href;
  try {
    await navigator.clipboard.writeText(url);
    this.innerHTML = '<i class="bi bi-check2-circle"></i> คัดลอกแล้ว';
    setTimeout(() => this.innerHTML = '<i class="bi bi-link-45deg"></i> คัดลอกลิงก์', 1500);
  } catch (_) {
    const tmp = document.createElement('input');
    tmp.value = url; document.body.appendChild(tmp); tmp.select(); document.execCommand('copy'); tmp.remove();
    this.innerHTML = '<i class="bi bi-check2-circle"></i> คัดลอกแล้ว';
    setTimeout(() => this.innerHTML = '<i class="bi bi-link-45deg"></i> คัดลอกลิงก์', 1500);
  }
});
</script>
@endsection