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
  max-width: 1320px !important;
  margin: 0 auto 60px auto !important;
  padding: 0 16px !important;
  box-sizing: border-box !important;
  overflow-x: hidden !important; /* ป้องกันขอบล้นจอแนวนอน */
}

.acct-wrap * { box-sizing: border-box; }
.acct-wrap a { text-decoration: none; color: inherit; }

/* Breadcrumb Layout */
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

/* Hero Section */
.acct-hero {
  padding: 36px 28px;
  background: linear-gradient(105deg, #ffffff 0%, #f4f9ff 60%, #e4f3ff 100%);
  border-radius: 24px;
  margin-bottom: 24px;
  border: 1px solid var(--line);
  box-shadow: 0 10px 30px rgba(20,53,143,.03);
}
/* เฉพาะข้อความ+ปุ่มด้านบนย้ายไปขวา ส่วน stats ด้านล่างอยู่ซ้ายเหมือนเดิม */
.acct-hero-top {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  text-align: center;
  margin-bottom: 24px;
}
.acct-hero-content {
  width: 100%;
  max-width: 640px;
  margin: 0 auto;
}
.acct-hero .eyebrow {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  color: var(--blue);
  font-weight: 800;
  font-size: 13px;
  margin-bottom: 10px;
}
.acct-hero h1 {
  font-size: clamp(22px, 4vw, 32px);
  margin: 0 0 8px;
  color: var(--navy);
  letter-spacing: -.5px;
  word-break: break-word;
}
.acct-hero p {
  margin: 0 0 24px;
  color: var(--muted);
  font-size: 14.5px;
  max-width: 640px;
  line-height: 1.6;
}
.acct-hero-actions {
  display: flex;
  gap: 12px;
  flex-wrap: wrap;
  margin-bottom: 28px;
  justify-content: center;
}
.acct-hero-btn {
  height: 46px;
  padding: 0 20px;
  border-radius: 12px;
  font-weight: 700;
  font-size: 14px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  transition: all .2s ease;
}
.acct-hero-btn.primary {
  background: linear-gradient(135deg, var(--blue), #0d57df);
  color: #fff;
  box-shadow: 0 10px 20px rgba(23,101,255,.2);
}
.acct-hero-btn.secondary {
  background: #fff;
  color: var(--blue);
  border: 1.5px solid var(--blue);
}

/* Stats Section */
.acct-quick-stats {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 16px;
}
.acct-stat {
  background: #fff;
  border: 1px solid var(--line);
  border-radius: 18px;
  padding: 18px 20px;
  box-shadow: 0 8px 20px rgba(20,53,143,.04);
}
.acct-stat i { color: var(--blue); margin-bottom: 10px; }
.acct-stat b { display: block; font-size: 24px; color: #102b76; line-height: 1.2; }
.acct-stat span { font-size: 13px; color: var(--muted); font-weight: 700; }

/* Main Portal Grid */
.acct-portal {
  display: grid;
  grid-template-columns: 260px minmax(0, 1fr);
  gap: 24px;
  align-items: start;
}
.acct-side {
  position: sticky;
  top: 90px;
  align-self: start;
  border: 1px solid var(--line);
  border-radius: 20px;
  background: #fff;
  box-shadow: 0 10px 30px rgba(20,53,143,.04);
  padding: 12px;
}
.acct-side a {
  height: 44px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 0 14px;
  color: #344054;
  font-weight: 700;
  font-size: 13.5px;
  transition: background .15s ease;
}
.acct-side a img { width: 18px; height: 18px; object-fit: contain; }
.acct-side a:hover, .acct-side a.active { background: #eef6ff; color: var(--blue); }
.acct-side a.signout { color: var(--red); }

/* Content Cards */
.acct-main { display: grid; gap: 24px; min-width: 0; }
.acct-card {
  background: #fff;
  border: 1px solid var(--line);
  border-radius: 20px;
  padding: 24px;
  box-shadow: 0 10px 30px rgba(20,53,143,.04);
}
.acct-card h2 { font-size: 20px; margin: 0 0 4px; color: #102b76; font-weight: 800; }
.acct-card p { margin: 0; color: var(--muted); font-size: 13.5px; }

/* Quick Links Grid */
.acct-quicklinks {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
  gap: 12px;
  margin-top: 20px;
}
.acct-quicklink {
  border: 1px solid var(--line);
  border-radius: 14px;
  padding: 16px 10px;
  text-align: center;
  background: #fbfdff;
  transition: all .2s ease;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}
.acct-quicklink img { width: 32px; height: 32px; object-fit: contain; margin-bottom: 8px; }
.acct-quicklink div { font-weight: 700; font-size: 12.5px; color: #344054; word-break: break-word; }
.acct-quicklink:hover { border-color: var(--blue); background: var(--soft); transform: translateY(-2px); }

/* Learning Center */
.lc-head { display: flex; justify-content: space-between; align-items: flex-start; gap: 16px; margin-bottom: 18px; }
.lc-eyebrow { display: inline-block; color: var(--blue); font-weight: 800; font-size: 12px; letter-spacing: .5px; margin-bottom: 4px; }
.lc-head h2 { margin: 0 0 4px; color: #102b76; font-size: 20px; font-weight: 800; }
.lc-head p { margin: 0; color: var(--muted); font-size: 13px; }
.lc-viewall {
  height: 38px;
  padding: 0 16px;
  border-radius: 10px;
  border: 1.5px solid var(--blue);
  color: var(--blue);
  font-weight: 700;
  font-size: 13px;
  display: inline-flex;
  align-items: center;
  white-space: nowrap;
}
.lc-viewall:hover { background: var(--soft); }

.lc-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px; }
.lc-card {
  display: block;
  border: 1px solid var(--line);
  border-radius: 16px;
  overflow: hidden;
  background: #fff;
  transition: transform .2s ease, box-shadow .2s ease;
}
.lc-card:hover { transform: translateY(-3px); box-shadow: 0 12px 24px rgba(20,53,143,.08); }
.lc-thumb { height: 130px; background: linear-gradient(135deg, #12358f, #1765ff); display: flex; align-items: center; justify-content: center; position: relative; }
.lc-thumb img { width: 100%; height: 100%; object-fit: cover; position: absolute; inset: 0; }
.lc-play {
  width: 38px;
  height: 38px;
  border-radius: 50%;
  background: rgba(255,255,255,.25);
  border: 1px solid rgba(255,255,255,.5);
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
  z-index: 1;
}
.lc-play:before { content: ''; border-left: 10px solid #fff; border-top: 6px solid transparent; border-bottom: 6px solid transparent; margin-left: 2px; }
.lc-cardbody { padding: 14px; }
.lc-cardbody h4 { margin: 0 0 4px; font-size: 13.5px; color: #102b76; font-weight: 700; line-height: 1.4; }
.lc-cardbody span { color: var(--muted); font-size: 11.5px; }

/* Support CTA Card */
.acct-help-card {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 20px;
  padding: 24px;
}
.acct-help-eyebrow { display: block; color: var(--blue); font-weight: 800; font-size: 12px; letter-spacing: .5px; margin-bottom: 6px; }
.acct-help-card h2 { margin: 0 0 6px; font-size: 22px; color: #102b76; line-height: 1.25; }
.acct-help-card p { margin: 0; color: var(--muted); font-size: 13.5px; }
.acct-help-actions { display: flex; flex-direction: column; gap: 10px; flex-shrink: 0; width: auto; }
.acct-help-btn {
  height: 44px;
  padding: 0 22px;
  border-radius: 12px;
  font-weight: 700;
  font-size: 13.5px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  white-space: nowrap;
}
.acct-help-btn.primary { background: linear-gradient(135deg, var(--blue), #0d57df); color: #fff; box-shadow: 0 10px 20px rgba(23,101,255,.2); }
.acct-help-btn.secondary { background: #fff; color: var(--blue); border: 1.5px solid var(--blue); }

/* ==========================================================================
   Responsive Breakpoints
   ========================================================================== */
@media (max-width: 991px) {
  .acct-portal { grid-template-columns: 1fr; }
  .acct-side { position: static; margin-bottom: 8px; }
  .acct-help-card { flex-direction: column; align-items: flex-start; }
  .acct-help-actions { width: 100%; }
  .acct-help-btn { width: 100%; }
}

@media (max-width: 600px) {
  .acct-wrap { padding: 0 12px !important; margin-bottom: 90px !important; }
  .acct-hero { padding: 24px 16px; border-radius: 18px; }
  .acct-hero-content { max-width: 100%; }
  .acct-hero-actions { flex-direction: column; }
  .acct-hero-btn { width: 100%; }
  .acct-quick-stats { grid-template-columns: 1fr 1fr; gap: 10px; }
  .acct-stat { padding: 14px; }
  .acct-stat b { font-size: 20px; }
  
  .acct-quicklinks { grid-template-columns: repeat(2, 1fr); gap: 10px; }
  .acct-card { padding: 18px; border-radius: 16px; }
  
  .lc-head { flex-direction: column; align-items: flex-start; gap: 10px; }
  .lc-grid { grid-template-columns: 1fr; }
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
        <div class="acct-hero-top">
            <div class="acct-hero-content">
                <div class="eyebrow"><i data-lucide="badge-check" size="16"></i> MY PTCAD</div>
                <h1>สวัสดี @if(!empty($user->displayname)){{ $user->displayname }}@else{{ $user->name }}@endif</h1>
                <p>จัดการซอฟต์แวร์ คำสั่งซื้อ โค้ดส่วนลด ใบเสนอราคา และข้อมูลบัญชีของคุณได้ในที่เดียว</p>

                <div class="acct-hero-actions">
                    <a href="{{ route('fronend.account.software') }}" class="acct-hero-btn primary"><i data-lucide="box" size="18"></i> ซอฟต์แวร์ของฉัน</a>
                    <a href="{{ route('fronend.help.index') }}" class="acct-hero-btn secondary"><i data-lucide="message-circle" size="18"></i> ติดต่อ Support</a>
                </div>
            </div>
        </div>

        <div class="acct-quick-stats">
            <div class="acct-stat"><i data-lucide="box" size="22"></i><b>{{ $softwareCount }}</b><span>Products Owned</span></div>
            <div class="acct-stat"><i data-lucide="receipt" size="22"></i><b>{{ $orderCount }}</b><span>Orders & Invoices</span></div>
        </div>
    </section>

    <div class="acct-portal">
        @include('layouts.fontend.account_sidebar')

        <div class="acct-main">
            <section class="acct-card">
                <h2>เมนูบัญชีของคุณ</h2>
                <p>เลือกรายการที่ต้องการจัดการ</p>
                <div class="acct-quicklinks">
                    <a href="{{ route('fronend.account') }}" class="acct-quicklink">
                        <img src="{{ asset('icon/profile/user-1.png') }}"><div>ข้อมูลส่วนตัว</div>
                    </a>
                    <a href="{{ route('fronend.account.order') }}" class="acct-quicklink">
                        <img src="{{ asset('icon/profile/cart-1.png') }}"><div>คำสั่งซื้อ</div>
                    </a>
                    <a href="{{ route('fronend.account.software') }}" class="acct-quicklink">
                        <img src="{{ asset('icon/profile/software-1.png') }}"><div>ซอฟต์แวร์ของฉัน</div>
                    </a>
                    <a href="{{ route('fronend.account.coupon') }}" class="acct-quicklink">
                        <img src="{{ asset('icon/profile/discount-1.png') }}"><div>โค้ดส่วนลด</div>
                    </a>
                    <a href="{{ route('fronend.account.quotation') }}" class="acct-quicklink">
                        <img src="/icon/profile/quotation-1.png"><div>ใบเสนอราคา</div>
                    </a>
                    <a href="{{ route('fronend.account.address') }}" class="acct-quicklink">
                        <img src="{{ asset('icon/profile/map-1.png') }}"><div>ที่อยู่จัดส่ง</div>
                    </a>
                    <a href="{{ route('fronend.account.changepassword') }}" class="acct-quicklink">
                        <img src="{{ asset('icon/profile/password-1.png') }}"><div>เปลี่ยนรหัสผ่าน</div>
                    </a>
                    <a href="{{ route('fronend.account.pdpa') }}" class="acct-quicklink">
                        <img src="{{ asset('icon/profile/letter-1.png') }}"><div>รับข่าวสาร</div>
                    </a>
                </div>
            </section>

            <section class="acct-card" id="learning-center">
                <div class="lc-head">
                    <div>
                        <span class="lc-eyebrow">LEARNING CENTER</span>
                        <h2>วิดีโอ Tutorial สำหรับสมาชิก</h2>
                        <p>ดูได้เฉพาะผู้ที่สมัครสมาชิกหรือมีสินค้าในบัญชี</p>
                    </div>
                    <a href="{{ route('fronend.tutorial.main') }}" class="lc-viewall">ดูทั้งหมด</a>
                </div>

                @php
                    $lcTutorials = App\Models\TbTutorial::select('tut_name','tut_parmalink','tut_thumb','tut_duration','tut_keyword')
                        ->where('tut_show', 1)
                        ->orderBy('created_at','desc')
                        ->limit(3)
                        ->get();
                @endphp

                @if(count($lcTutorials) != 0)
                    <div class="lc-grid">
                        @foreach($lcTutorials as $lc)
                            <a href="{{ route('fronend.tutorial.content', $lc->tut_parmalink) }}" class="lc-card">
                                <div class="lc-thumb">
                                    @if(!empty($lc->tut_thumb))
                                        <img src="{{ asset('storage/tutorial/'.$lc->tut_thumb) }}" alt="{{ $lc->tut_name }}">
                                    @endif
                                    <span class="lc-play"></span>
                                </div>
                                <div class="lc-cardbody">
                                    <h4>{{ $lc->tut_name }}</h4>
                                    <span>{{ !empty($lc->tut_duration) ? $lc->tut_duration : '' }}@if(!empty($lc->tut_keyword)) • {{ explode(',', $lc->tut_keyword)[0] }}@endif</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <p style="color:var(--muted);font-size:13px">ยังไม่มีวิดีโอ Tutorial</p>
                @endif
            </section>

            <section class="acct-card acct-help-card">
                <div>
                    <span class="acct-help-eyebrow">SUPPORT</span>
                    <h2>ต้องการความช่วยเหลือ?</h2>
                    <p>เปิด Ticket หรือทักทีมซัพพอร์ตภาษาไทยได้เลย</p>
                </div>
                <div class="acct-help-actions">
                    <a href="{{ route('fronend.help.index') }}" class="acct-help-btn primary"><i data-lucide="message-circle" size="18"></i> ติดต่อ Support</a>
                    <a href="https://lin.ee/pCT4DqS" target="_blank" rel="noopener" class="acct-help-btn secondary"><i data-lucide="monitor-up" size="18"></i> Remote Support</a>
                </div>
            </section>
        </div>
    </div>

</div>

@endsection