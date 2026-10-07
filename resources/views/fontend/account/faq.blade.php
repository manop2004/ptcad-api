@extends('layouts.temp_user')

@section('title')FAQ - คำถามที่พบบ่อย |@endsection

@section('css')
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Noto+Sans+Thai:wght@400;500;600;700;800&display=swap');

.acct-wrap {
  --navy: #12358f;
  --blue: #1765ff;
  --ink: #0b1f4d;
  --muted: #667085;
  --line: #e6edf8;
  --soft: #f6f9ff;
  --red: #ef4444;
  --shadow: 0 18px 50px rgba(20,53,143,.10);

  font-family: 'Poppins', 'Noto Sans Thai', system-ui, sans-serif;
  color: var(--ink);
  width: 100% !important;
  max-width: 900px !important; /* บีบความกว้างสูงสุดลงมาไม่ให้กว้างเกะกะ */
  margin: 0 auto 60px auto !important;
  padding: 0 16px !important;
  box-sizing: border-box !important;
  overflow-x: hidden !important;
}

.acct-wrap * { box-sizing: border-box; }
.acct-wrap a { text-decoration: none; color: inherit; }

#page-title {
  padding: 12px 0;
  background: transparent;
}
#page-title .breadcrumb {
  margin: 0;
  padding: 0;
  background: transparent;
  display: flex;
  flex-wrap: wrap;
}

.acct-hero {
  padding: 32px 24px;
  background: linear-gradient(105deg, #ffffff 0%, #f4f9ff 60%, #e4f3ff 100%);
  border-radius: 20px;
  margin-bottom: 24px;
  border: 1px solid var(--line);
  box-shadow: 0 10px 30px rgba(20,53,143,.03);
  text-align: center;
}
.acct-hero .eyebrow {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  color: var(--blue);
  font-weight: 800;
  font-size: 13px;
  margin-bottom: 8px;
  width: 100%;
}
.acct-hero h1 {
  font-size: clamp(20px, 4vw, 28px);
  margin: 0 0 8px;
  color: var(--navy);
  letter-spacing: -.5px;
  word-break: break-word;
}
.acct-hero p {
  margin: 0 auto;
  color: var(--muted);
  font-size: 14px;
  max-width: 600px;
  line-height: 1.6;
}

.acct-main { display: grid; gap: 24px; min-width: 0; }
.acct-card {
  background: #fff;
  border: 1px solid var(--line);
  border-radius: 16px;
  padding: 20px;
  box-shadow: 0 10px 30px rgba(20,53,143,.04);
}

/* ==================== FAQ Accordion ==================== */
.faq-list{ display:flex; flex-direction:column; gap:10px; }
.faq-item{
    border:1px solid var(--line);
    border-radius:12px;
    overflow:hidden;
    background:#fff;
    transition: border-color .2s ease;
}
.faq-item:hover {
    border-color: #bcd8ff;
}
.faq-item-head{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:14px;
    padding:14px 18px;
    cursor:pointer;
    user-select:none;
}
.faq-item-head:hover{ background:var(--soft); }

.faq-item-left {
    display: flex;
    align-items: center;
    gap: 12px;
    flex: 1;
    min-width: 0;
}
.faq-item-title{
    font-weight:700;
    color:#102b76;
    font-size:15px;
    line-height: 1.4;
}
.faq-toggle-icon{
    width:26px; height:26px; min-width:26px;
    border-radius:50%;
    background:#eef6ff;
    color:var(--blue);
    display:flex;
    align-items:center;
    justify-content:center;
    transition:transform .2s ease;
}
.faq-item.open .faq-toggle-icon{ transform:rotate(45deg); }
.faq-item-actions{ display:flex; align-items:center; gap:8px; flex:none; }
.faq-copy-btn{
    display:inline-flex; align-items:center; justify-content:center; gap:6px;
    height:32px; padding:0 12px; border-radius:8px;
    border:1px solid var(--line); background:#fff; color:#344054;
    font-size:12.5px; font-weight:600; cursor:pointer;
    transition: all .15s ease;
}
.faq-copy-btn:hover{ background:#f4f9ff; border-color:#bcd8ff; color:var(--blue); }
.faq-item-body{
    max-height:0;
    overflow:hidden;
    transition:max-height .3s ease;
    border-top:1px solid transparent;
}
.faq-item.open .faq-item-body{
    border-top:1px solid var(--line);
}
.faq-item-body-inner{ padding:16px; }
.faq-pdf-frame{ width:100%; height:70vh; border:1px solid var(--line); border-radius:8px; }
.faq-empty{ color:var(--muted); padding:30px 0; text-align:center; }

/* ==================== Adjustments for Mobile (ทศ) ==================== */
@media (max-width: 600px) {
  .acct-wrap { padding: 0 12px !important; margin-bottom: 90px !important; }
  .acct-hero { padding: 24px 16px; border-radius: 16px; }
  .acct-card { padding: 12px; border-radius: 14px; }
  
  .faq-item-head {
    flex-direction: column;
    align-items: stretch;
    gap: 12px;
    padding: 14px 14px;
  }

  .faq-item-left {
    width: 100%;
  }

  .faq-item-actions {
    width: 100%;
    display: grid;
    grid-template-columns: 1fr 1fr; /* แบ่งปุ่ม Open และ Copy Link เท่ากัน 50/50 เต็มความกว้าง */
    gap: 8px;
  }

  .faq-copy-btn {
    width: 100%;
    height: 36px; /* ขยายความสูงเล็กน้อยให้แตะบนมือถือง่ายขึ้น */
  }

  .faq-pdf-frame {
    height: 50vh; /* ปรับความสูงกรอบ PDF ให้พอดีจอมือถือ */
  }
}

/* ==================== Back to Top Button ==================== */
.faq-backtotop{
    position:fixed;
    right:24px;
    bottom:24px;
    width:48px;
    height:48px;
    border-radius:50%;
    background:#5b9bf7;
    color:#fff;
    display:flex;
    align-items:center;
    justify-content:center;
    box-shadow:0 10px 25px rgba(91,155,247,.35);
    cursor:pointer;
    border:none;
    opacity:0;
    visibility:hidden;
    transform:translateY(12px);
    transition:opacity .25s ease, transform .25s ease, visibility .25s ease;
    z-index:9999;
}
.faq-backtotop.show{
    opacity:1;
    visibility:visible;
    transform:translateY(0);
}
.faq-backtotop:hover{ filter:brightness(1.08); }
@media (max-width:600px){
    .faq-backtotop{ right:16px; bottom:16px; width:44px; height:44px; }
}
</style>
@endsection

@section('content')

<div class="acct-wrap">

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
        <div class="eyebrow"><i data-lucide="help-circle" size="16"></i> FAQ</div>
        <h1>คำถามที่พบบ่อย</h1>
        <p>คลิกที่หัวข้อเพื่อดูเอกสาร PDF หรือกดปุ่ม Open หรือ Copy Link  เพื่อเปิดดูเลยหรือคัดลอกลิงก์ส่งต่อได้ทันที</p>
    </section>

    <div class="acct-main">
        <section class="acct-card">

            @if(count($faqs))
            <div class="faq-list">
                @foreach($faqs as $item)
                <div class="faq-item" id="faq-item-{{ $item->id }}">
                    <div class="faq-item-head" onclick="toggleFaqItem({{ $item->id }})">
                        <div class="faq-item-left">
                            <span class="faq-toggle-icon"><i data-lucide="plus" size="16"></i></span>
                            <span class="faq-item-title">{{ $item->faq_title }}</span>
                        </div>
                        <div class="faq-item-actions">
                            @if(!empty($item->faq_parmalink))
<a href="{{ route('faq.view',$item->faq_parmalink) }}" target="_blank" class="faq-copy-btn" onclick="event.stopPropagation();">
    <i data-lucide="external-link" size="14"></i> Open
</a>
<button type="button" class="faq-copy-btn" onclick="event.stopPropagation(); copyFaqLink('{{ route('faq.view',$item->faq_parmalink) }}')">
    <i data-lucide="copy" size="14"></i> Copy Link
</button>
@endif
                        </div>
                    </div>
                    <div class="faq-item-body" id="faq-body-{{ $item->id }}">
                        <div class="faq-item-body-inner">
                            @if(!empty($item->faq_file))
                                <iframe class="faq-pdf-frame" data-src="{{ asset('storage/faq_files/'.$item->faq_file) }}" src="about:blank"></iframe>
                            @else
                                <p class="text-muted" style="margin:0">ยังไม่มีไฟล์แนบสำหรับหัวข้อนี้</p>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
                <p class="faq-empty">ยังไม่มีหัวข้อ FAQ ในขณะนี้</p>
            @endif

        </section>
    </div>

    <button type="button" class="faq-backtotop" id="faqBackToTop" onclick="window.scrollTo({top:0, behavior:'smooth'})" aria-label="เลื่อนขึ้นบนสุด">
        <i data-lucide="arrow-up" size="20"></i>
    </button>
</div>

@endsection

@section('js')
<script>
function toggleFaqItem(id){
    var item = document.getElementById('faq-item-' + id);
    var body = document.getElementById('faq-body-' + id);
    if (!item || !body) return;

    var isOpen = item.classList.contains('open');

    if (isOpen) {
        body.style.maxHeight = null;
        item.classList.remove('open');
    } else {
        item.classList.add('open');
        var frame = body.querySelector('iframe.faq-pdf-frame');
        if (frame && frame.getAttribute('src') === 'about:blank') {
            frame.setAttribute('src', frame.getAttribute('data-src'));
        }
        body.style.maxHeight = body.scrollHeight + 100 + 'px';
    }
}

function copyFaqLink(link){
    navigator.clipboard.writeText(link).then(function(){
        showFaqToast('คัดลอกลิงก์เรียบร้อยแล้ว');
    });
}

function showFaqToast(msg){
    var old = document.getElementById('faq-toast');
    if (old) old.remove();

    var toast = document.createElement('div');
    toast.id = 'faq-toast';
    toast.textContent = msg;
    toast.style.cssText = 'position:fixed;bottom:30px;left:50%;transform:translate(-50%,20px);background:#0b1f4d;color:#fff;padding:14px 22px;border-radius:14px;font-size:13.5px;font-weight:600;box-shadow:0 14px 34px rgba(11,31,77,.3);opacity:0;transition:opacity .3s ease, transform .3s ease;z-index:10000;max-width:90%;text-align:center;';
    document.body.appendChild(toast);

    requestAnimationFrame(function(){
        toast.style.opacity = '1';
        toast.style.transform = 'translate(-50%,0)';
    });

    setTimeout(function(){
        toast.style.opacity = '0';
        toast.style.transform = 'translate(-50%,20px)';
        setTimeout(function(){ toast.remove(); }, 300);
    }, 2500);
}

// ==================== Back to Top ====================
(function(){
    var btn = document.getElementById('faqBackToTop');
    if (!btn) return;
    window.addEventListener('scroll', function(){
        if (window.scrollY > 300) {
            btn.classList.add('show');
        } else {
            btn.classList.remove('show');
        }
    });
})();
</script>
@endsection