@extends($layout ?? 'layouts.temp_user')

@section('title')ทดลองใช้ PTCAD ฟรี 30 วัน |@endsection
@section('og_title')ทดลองใช้ PTCAD ฟรี 30 วัน@endsection
@section('og_description')ทดลองใช้ PTCAD ที่ไม่ยุ่งยากเป็นเวลา 30 วัน@endsection

@section('css')
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Noto+Sans+Thai:wght@400;500;600;700;800&display=swap');

.trial-wrap{
  --navy:#12358f; --blue:#1765ff; --ink:#0b1f4d; --muted:#667085; --line:#e6edf8; --soft:#f6f9ff;
  --dark:#12358f; --dark2:#1e1b4b; --orange:#f5a623;
  font-family:'Poppins','Noto Sans Thai',system-ui,sans-serif; color:var(--ink);
  max-width:1140px; margin:0 auto 60px; padding:0 24px; box-sizing:border-box;
}
.trial-wrap *{box-sizing:border-box}

/* Grid Layout ยืดฝั่งซ้ายและขวาให้สูงเท่ากันเสมอ */
.trial-grid{
  display:grid; 
  grid-template-columns: 1fr 1.15fr; 
  gap:0;
  background:#fff; 
  border-radius:28px;
  box-shadow:0 20px 50px rgba(20,53,143,.10);
  align-items: stretch;
}

/* ===== แผงซ้าย (ปรับ CSS ใหม่ให้สว่างและโมเดิร์นแบบ Tech Style) ===== */
.trial-left{
  background: radial-gradient(circle at 10% 10%, rgba(255, 255, 255, 0.12) 0%, transparent 40%),
              linear-gradient(145deg, #12358f 0%, #1e40af 50%, #1e1b4b 100%);
  color:#fff; 
  padding:44px 40px; 
  border-radius:28px 0 0 28px;
  height: 100%;
  position: relative;
  overflow: hidden;
}

/* เอฟเฟกต์แสง Ambient Glow ด้านหลัง */
.trial-left::before {
  content: '';
  position: absolute;
  top: -60px;
  right: -60px;
  width: 220px;
  height: 220px;
  background: rgba(23, 101, 255, 0.35);
  filter: blur(60px);
  border-radius: 50%;
  pointer-events: none;
}

.trial-left::after {
  content: '';
  position: absolute;
  bottom: -40px;
  left: -40px;
  width: 200px;
  height: 200px;
  background: rgba(245, 166, 35, 0.18);
  filter: blur(55px);
  border-radius: 50%;
  pointer-events: none;
}

/* Container ด้านในแผงซ้าย ( Sticky ลอยค้างกลางจอเวลากรอกฟอร์ม ) */
.trial-left-inner{
  position: relative;
  z-index: 1;
  position: sticky;
  top: 30px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  max-height: calc(100vh - 60px);
}

.trial-logo{
  display:inline-flex; align-items:center; gap:10px; margin-bottom:32px;
  background:rgba(255, 255, 255, 0.95); padding:12px 20px; border-radius:16px;
  box-shadow:0 10px 25px rgba(0,0,0,.12), inset 0 0 0 1px rgba(255,255,255,0.5);
  backdrop-filter: blur(8px);
}
.trial-logo img{height:34px; width:auto; display:block}
.trial-logo-fallback{display:inline-flex; align-items:center; gap:10px;}
.trial-logo-fallback .logo-badge{
  width:34px; height:34px; border:2px solid var(--navy); border-radius:8px;
  display:flex; align-items:center; justify-content:center; font-weight:800; font-size:13px;
  color:var(--navy);
}
.trial-logo-fallback .logo-text{font-weight:800; font-size:17px; letter-spacing:.5px; color:var(--navy)}

.trial-left .trial-tagline{margin:0}
.trial-left .trial-tagline h1{
  font-size:30px; 
  line-height:1.25; 
  margin:0 0 14px; 
  font-weight:800;
  letter-spacing: -0.5px;
  color: #ffffff;
  text-shadow: 0 2px 10px rgba(0,0,0,0.15);
}
.trial-left .trial-tagline h1 .accent{
  color:#ffb703;
  background: linear-gradient(135deg, #ffd166, #ffb703);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}
.trial-left .trial-tagline p{
  color:rgba(238, 242, 255, 0.85); 
  font-size:14px; 
  line-height:1.7; 
  margin:0; 
  max-width:320px;
  font-weight: 400;
}

.trial-illustration{
  display:flex; justify-content:center; align-items:flex-end;
  padding:20px 0 0;
  margin-top:20px;
  filter: drop-shadow(0 15px 25px rgba(0,0,0,0.2));
}
.trial-illustration svg{width:100%; max-width:280px; height:auto}

/* ===== แผงขวา (ฟอร์ม) ===== */
.trial-right{
  padding:44px 40px 40px; 
  border-radius:0 28px 28px 0;
}

.trial-right h2{font-size:22px; margin:0 0 24px; color:var(--navy); font-weight:800; line-height:1.35}

.trial-form .fl-group{position:relative; margin-bottom:16px}
.trial-form .fl-group input,
.trial-form .fl-group select{
  width:100%; border:1.5px solid var(--line); border-radius:10px;
  padding:12px 14px; font-size:14px; color:var(--ink); font-weight:500;
  transition:.2s ease;
}
.trial-form .fl-group input:focus,
.trial-form .fl-group select:focus{
  outline:none; border-color:var(--blue); box-shadow:0 0 0 4px rgba(23,101,255,.08);
}
.trial-form label{display:block; font-size:13px; font-weight:700; color:#344054; margin-bottom:6px}
.trial-form .row-2{display:grid; grid-template-columns:1fr 1fr; gap:14px}
.trial-form .invalid-feedback{color:#ef4444; font-size:12px; margin-top:4px; display:block}

.trial-note{
  background:#fffaeb; border:1px solid #ffe4a3; border-radius:10px;
  padding:12px 14px; font-size:12.5px; color:#8a6116; line-height:1.6; margin:16px 0;
}

/* ===== ตัวเลือกเวอร์ชันโปรแกรม ===== */
.trial-product-picker{margin:20px 0 6px}
.trial-product-picker > label{display:block; font-size:13px; font-weight:700; color:#344054; margin-bottom:10px}
.trial-product-grid{display:grid; grid-template-columns:repeat(3,1fr); gap:10px}
.trial-product-card{
  position:relative; border:1.5px solid var(--line); border-radius:12px; padding:14px 8px 12px;
  text-align:center; cursor:pointer; transition:.2s ease; background:#fff;
}
.trial-product-card:hover{border-color:#bcd8ff}
.trial-product-card.active{border-color:var(--blue); box-shadow:0 0 0 3px rgba(23,101,255,.08)}
.trial-product-card .check-box{
  position:absolute; top:8px; left:8px; width:16px; height:16px; border-radius:4px;
  border:2px solid #cbd5e1; background:#fff; display:flex; align-items:center; justify-content:center;
}
.trial-product-card.active .check-box{background:var(--blue); border-color:var(--blue)}
.trial-product-card.active .check-box::after{
  content:''; width:5px; height:8px; border:solid #fff; border-width:0 2px 2px 0; transform:rotate(45deg) translate(-1px,-1px);
}
.trial-product-card img{width:46px; height:auto; margin:6px auto 8px; display:block}
.trial-product-card .p-icon-fallback{
  width:46px;height:46px;margin:6px auto 8px;border-radius:10px;background:var(--soft);
  display:flex;align-items:center;justify-content:center;
}
.trial-product-card .p-name{font-size:12.5px; font-weight:800; color:var(--navy)}
.trial-product-card .p-release{font-size:10.5px; color:var(--blue); margin-top:5px; display:inline-flex; align-items:center; gap:3px}

.trial-download-btn{
  width:100%; height:50px; border-radius:10px; border:none;
  background:linear-gradient(135deg,var(--blue),#0d57df); color:#fff;
  font-weight:800; font-size:15px; cursor:pointer; margin-top:16px;
  display:flex; align-items:center; justify-content:center; gap:10px;
  box-shadow:0 12px 24px rgba(23,101,255,.24); transition:.2s ease;
}
.trial-download-btn:hover{transform:translateY(-2px)}

.trial-success-box{
  text-align:center; padding:60px 24px; background:#fff; border-radius:28px;
  box-shadow:0 20px 50px rgba(20,53,143,.10);
}
.trial-success-box .icon{
  width:72px; height:72px; border-radius:50%; background:#eaf1ff; color:#1765ff;
  display:grid; place-items:center; margin:0 auto 20px; font-size:32px;
}
.trial-success-box h2{color:var(--navy); font-size:24px; margin:0 0 10px}
.trial-success-box p{color:var(--muted); font-size:14.5px; line-height:1.7}

/* Responsive สำหรับมือถือ/แท็บเล็ต */
@media (max-width:900px){
  .trial-grid{grid-template-columns:1fr}
  .trial-left{
    padding:28px; 
    border-radius:28px 28px 0 0;
  }
  .trial-left-inner{
    position:static;
    max-height:none;
  }
  .trial-illustration{display:none}
  .trial-right{padding:32px 24px; border-radius:0 0 28px 28px}
  .trial-form .row-2{grid-template-columns:1fr}
}

@media (max-width:600px){
  .trial-product-grid{grid-template-columns:1fr 1fr 1fr; gap:8px}
  .trial-product-card{padding:10px 4px}
  .trial-product-card img,
  .trial-product-card .p-icon-fallback{width:36px;height:36px}
  .trial-product-card .p-name{font-size:11px}
}
.rn-modal-overlay{
  display:none; position:fixed; inset:0; background:rgba(11,31,77,.55);
  z-index:9999; align-items:center; justify-content:center; padding:20px;
}
.rn-modal-overlay.show{display:flex}
.rn-modal-box{
  background:#fff; border-radius:16px; max-width:560px; width:100%;
  max-height:80vh; display:flex; flex-direction:column;
  box-shadow:0 20px 60px rgba(0,0,0,.25);
}
.rn-modal-header{
  display:flex; align-items:center; justify-content:space-between;
  padding:18px 22px; border-bottom:1px solid var(--line); font-weight:800; color:var(--navy);
}
.rn-modal-close{
  background:none; border:none; font-size:24px; line-height:1; cursor:pointer; color:var(--muted);
}
.rn-modal-body{
  padding:20px 22px; overflow-y:auto; font-size:13px; line-height:1.7;
  color:#344054; white-space:pre-line;
}
</style>
@endsection

@section('content')

<div class="trial-wrap" style="margin-top:32px">

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

    @if(session('trial_success'))
        <div class="trial-success-box">
            <div class="icon"><i data-lucide="check" size="36"></i></div>
            <h2>ส่งคำขอทดลองใช้สำเร็จแล้ว!</h2>
            <p>ทีมงาน PTCAD จะติดต่อกลับพร้อมลิงก์ดาวน์โหลดโปรแกรมทดลองใช้<br>ไปยังอีเมลที่คุณระบุไว้เร็วที่สุด</p>
        </div>
    @else
        <div class="trial-grid">
            <div class="trial-left">
                <div class="trial-left-inner">
                    <div>
                        {{-- โลโก้ --}}
                        @if(isset($setting) && !empty($setting->setting_logoWeb))
                            <div class="trial-logo">
                                <img src="{{ asset('storage/setting/'.$setting->setting_logoWeb) }}" alt="PTCAD">
                            </div>
                        @else
                            <div class="trial-logo trial-logo-fallback">
                                <span class="logo-badge">PT</span>
                                <span class="logo-text">PTCAD</span>
                            </div>
                        @endif

                        <div class="trial-tagline">
                            <h1>Your CAD,<br><span class="accent">Start NOW</span></h1>
                            <p>ทดลองใช้งานโปรแกรมเขียนแบบ 2D/3D ที่ไม่ยุ่งยาก รองรับไฟล์ DWG ใช้งานง่าย เรียนรู้เร็ว เหมาะสำหรับทุกธุรกิจ</p>
                        </div>
                    </div>

                    {{-- ภาพประกอบ --}}
                    <div class="trial-illustration">
                        <svg viewBox="0 0 300 240" xmlns="http://www.w3.org/2000/svg">
                            <!-- cloud -->
                            <ellipse cx="200" cy="55" rx="55" ry="30" fill="#3a5a99" opacity="0.55"/>
                            <text x="200" y="61" text-anchor="middle" fill="#ffffff" font-size="13" font-weight="700" font-family="Poppins,sans-serif">PTCAD</text>

                            <!-- connecting lines -->
                            <line x1="150" y1="120" x2="180" y2="70" stroke="#5b7bc4" stroke-width="2" stroke-dasharray="3 4"/>
                            <line x1="150" y1="120" x2="90" y2="90" stroke="#5b7bc4" stroke-width="2" stroke-dasharray="3 4"/>

                            <!-- DWG file icon -->
                            <rect x="60" y="70" width="46" height="56" rx="6" fill="#ffffff"/>
                            <rect x="60" y="70" width="46" height="16" rx="6" fill="#2e5fd6"/>
                            <text x="83" y="82" text-anchor="middle" fill="#ffffff" font-size="8" font-weight="700" font-family="Poppins,sans-serif">DWG</text>
                            <line x1="68" y1="100" x2="98" y2="100" stroke="#dbe4f7" stroke-width="3"/>
                            <line x1="68" y1="110" x2="98" y2="110" stroke="#dbe4f7" stroke-width="3"/>
                            <line x1="68" y1="120" x2="88" y2="120" stroke="#dbe4f7" stroke-width="3"/>

                            <!-- person -->
                            <circle cx="150" cy="105" r="16" fill="#f5c28e"/>
                            <path d="M124 175 Q124 128 150 128 Q176 128 176 175 Z" fill="#f5a623"/>
                            <rect x="140" y="150" width="20" height="28" rx="6" fill="#fff" opacity=".18"/>
                            <path d="M176 150 Q195 150 200 130" stroke="#f5c28e" stroke-width="9" stroke-linecap="round" fill="none"/>

                            <!-- gears -->
                            <circle cx="95" cy="185" r="13" fill="none" stroke="#5b7bc4" stroke-width="6"/>
                            <circle cx="120" cy="200" r="9" fill="none" stroke="#5b7bc4" stroke-width="5"/>

                            <!-- download box -->
                            <rect x="195" y="165" width="60" height="46" rx="8" fill="#ffffff"/>
                            <path d="M215 178 v14 m0 0 l-6-6 m6 6 l6-6" stroke="#2e5fd6" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                            <line x1="205" y1="200" x2="245" y2="200" stroke="#2e5fd6" stroke-width="3" stroke-linecap="round"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="trial-right">
                <h2>ทดลองใช้ PTCAD ที่ไม่ยุ่งยากเป็นเวลา 30 วันเลยตอนนี้</h2>

                <form class="trial-form" method="POST" action="{{ route('fronend.trial.store') }}">
                    @csrf
                    <input type="hidden" name="ref" value="{{ $ref ?? request('ref') }}">

                    {{-- UTM Tracking: URL รับค่ามาตรฐาน utm_* แต่ lead-api ต้องการ cf_utm_* โดยตรง --}}
                    <input type="hidden" name="cf_utm_source" value="{{ old('cf_utm_source', request('utm_source', request('cf_utm_source'))) }}">
                    <input type="hidden" name="cf_utm_medium" value="{{ old('cf_utm_medium', request('utm_medium', request('cf_utm_medium'))) }}">
                    <input type="hidden" name="cf_utm_campaign" value="{{ old('cf_utm_campaign', request('utm_campaign', request('cf_utm_campaign'))) }}">
                    <input type="hidden" name="cf_utm_term" value="{{ old('cf_utm_term', request('utm_term', request('cf_utm_term'))) }}">
                    <input type="hidden" name="cf_utm_content" value="{{ old('cf_utm_content', request('utm_content', request('cf_utm_content'))) }}">

                    <div class="row-2">
                        <div class="fl-group">
                            <label>ชื่อ <span style="color:#ef4444">*</span></label>
                            <input type="text" name="firstname" value="{{ old('firstname') }}">
                            @error('firstname')<small class="invalid-feedback">{{ $message }}</small>@enderror
                        </div>
                        <div class="fl-group">
                            <label>นามสกุล <span style="color:#ef4444">*</span></label>
                            <input type="text" name="lastname" value="{{ old('lastname') }}">
                            @error('lastname')<small class="invalid-feedback">{{ $message }}</small>@enderror
                        </div>
                    </div>

                    <div class="fl-group">
                        <label>ชื่อบริษัท <span style="color:#ef4444">*</span></label>
                        <input type="text" name="company" value="{{ old('company') }}">
                        @error('company')<small class="invalid-feedback">{{ $message }}</small>@enderror
                    </div>

                    <div class="fl-group">
                        <label>อีเมล (กรุณากรอกอีเมลที่สามารถติดต่อได้) <span style="color:#ef4444">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}">
                        @error('email')<small class="invalid-feedback">{{ $message }}</small>@enderror
                    </div>

                    <div class="fl-group">
                        <label>เบอร์โทรศัพท์ <span style="color:#ef4444">*</span></label>
                        <input type="text" name="phone" value="{{ old('phone') }}">
                        @error('phone')<small class="invalid-feedback">{{ $message }}</small>@enderror
                    </div>

                    <div class="row-2">
                        <div class="fl-group">
                            <label>Line ID (สามารถไม่ระบุได้)</label>
                            <input type="text" name="line_id" value="{{ old('line_id') }}">
                        </div>
                        <div class="fl-group">
                            <label>จังหวัด <span style="color:#ef4444">*</span></label>
                            <select name="province">
                                <option value="">-- กรุณาเลือกจังหวัด --</option>
                                @foreach($provinces as $p)
                                    <option value="{{ $p->id }}" {{ old('province') == $p->id ? 'selected' : '' }}>{{ $p->prov_name_th }}</option>
                                @endforeach
                            </select>
                            @error('province')<small class="invalid-feedback">{{ $message }}</small>@enderror
                        </div>
                    </div>

                    <div class="trial-note">
                        ลิงก์สำหรับดาวน์โหลดโปรแกรมจะถูกส่งไปทางอีเมล กรุณาตรวจสอบให้แน่ใจว่าอีเมลของคุณถูกต้อง
                    </div>

                    <div class="trial-product-picker">
                        <label>เลือกเวอร์ชันที่ต้องการทดลองใช้ <span style="color:#ef4444">*</span></label>
                        <div class="trial-product-grid">
                            @foreach(['ptcad-lite' => 'LITE', 'ptcad-standard' => 'Standard', 'ptcad-plus' => 'Plus'] as $slug => $label)
                                @php $p = $trialProducts[$slug] ?? null; @endphp
                                <label class="trial-product-card" data-slug="{{ $slug }}">
                                    <span class="check-box"></span>
                                    <input type="radio" name="product_slug" value="{{ $slug }}" style="display:none" {{ old('product_slug', 'ptcad-plus') == $slug ? 'checked' : '' }}>
                                    @if($p && !empty($p->cover_image))
                                        <img src="{{ $p->cover_image }}" alt="PTCAD {{ $label }}">
                                    @else
                                        <div class="p-icon-fallback">
                                            <i data-lucide="box" size="22" style="color:var(--blue)"></i>
                                        </div>
                                    @endif
                                    <div class="p-name">PTCAD {{ $label }}</div>
                                    @if($p && !empty($p->pro_release_notes))
                                        <button type="button" class="p-release" onclick="event.stopPropagation(); openReleaseNote('{{ $label }}', {{ json_encode($p->pro_release_notes) }})">
                                            <i data-lucide="info" size="11"></i> Release Note
                                        </button>
                                    @endif
                                </label>
                            @endforeach
                        </div>
                        @error('product_slug')<small class="invalid-feedback">{{ $message }}</small>@enderror
                    </div>

                    <button type="submit" class="trial-download-btn" id="trialSubmitBtn">
    <i data-lucide="download" size="18"></i> ดาวน์โหลด
</button>
                </form>

                <div id="release-note-modal" class="rn-modal-overlay" onclick="if(event.target===this) closeReleaseNote()">
                    <div class="rn-modal-box">
                        <div class="rn-modal-header">
                            <span id="rn-modal-title">PTCAD Release Notes</span>
                            <button type="button" class="rn-modal-close" onclick="closeReleaseNote()">&times;</button>
                        </div>
                        <div class="rn-modal-body" id="rn-modal-body"></div>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
<script>
/* ฟังก์ชัน modal ของ Release Note — อยู่นอก DOMContentLoaded โดยตั้งใจ
   เพราะปุ่มใช้ inline onclick="" ซึ่งหาฟังก์ชันจาก global scope เท่านั้น
   ถ้าฟังก์ชันถูกประกาศอยู่ข้างในฟังก์ชันอื่น (local scope) inline onclick จะหาไม่เจอ
   และจะขึ้น error "openReleaseNote is not defined" ใน console */
function openReleaseNote(label, content){
    document.getElementById('rn-modal-title').textContent = 'PTCAD ' + label + ' - Release Notes';
    document.getElementById('rn-modal-body').textContent = content;
    document.getElementById('release-note-modal').classList.add('show');
}
function closeReleaseNote(){
    document.getElementById('release-note-modal').classList.remove('show');
}

document.addEventListener('DOMContentLoaded', function(){
    var cards = document.querySelectorAll('.trial-product-card');
    function setActive(){
        cards.forEach(function(c){
            var input = c.querySelector('input[type="radio"]');
            c.classList.toggle('active', input.checked);
        });
    }
    cards.forEach(function(card){
        card.addEventListener('click', function(){
            var input = card.querySelector('input[type="radio"]');
            input.checked = true;
            setActive();
        });
    });
    setActive();
});
// [เพิ่มใหม่] กันลูกค้ากดปุ่มดาวน์โหลดซ้ำหลายครั้ง
document.querySelector('.trial-form').addEventListener('submit', function () {
    var btn = document.getElementById('trialSubmitBtn');
    if (btn) {
        btn.disabled = true;
        btn.style.opacity = '0.6';
        btn.style.cursor = 'not-allowed';
        btn.innerHTML = '<i data-lucide="loader" size="18"></i> กำลังส่ง...';
    }
});
</script>
@endsection