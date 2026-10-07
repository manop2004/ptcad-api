@extends('layouts.temp_user')

@section('og_site_name'){{ $og_site_name }}@endsection
@section('og_keywords'){{ $og_keywords }}@endsection
@section('og_title'){{ $og_title }}@endsection
@section('title'){{ $og_title }} |@endsection
@section('og_description'){{ $og_description }}@endsection
@section('og_url'){{ $og_url }}@endsection
@section('og_image'){{ $og_image }}@endsection

@section('css')
<style>
    
.lux8-tut{--navy:#12358f;--blue:#1765ff;--sky:#8fd3ff;--ink:#0b1f4d;--muted:#667085;--line:#e6edf8;--soft:#f6f9ff;font-family:'Poppins','Noto Sans Thai',inherit;color:var(--ink)}
.lux8-tut .lux8-hero{padding:56px 40px;background:radial-gradient(circle at 82% 30%,rgba(143,211,255,.35),transparent 27%),linear-gradient(105deg,#fff 0%,#f3f8ff 58%,#e3f3ff 100%);border-radius:26px;margin-bottom:28px}
.lux8-tut .lux8-eyebrow{display:inline-flex;align-items:center;gap:8px;color:var(--blue);font-weight:800;font-size:14px;margin-bottom:12px}
.lux8-tut .lux8-hero h1{font-size:40px;line-height:1.15;margin:0 0 12px;color:var(--navy);letter-spacing:-1px;font-weight:800}
.lux8-tut .lux8-hero p{max-width:760px;color:var(--muted);font-size:16px;line-height:1.7;margin:0}
.lux8-tut .lux8-search{height:56px;max-width:640px;border:1px solid var(--line);border-radius:18px;background:#fff;display:flex;align-items:center;gap:12px;padding:0 8px 0 20px;box-shadow:0 12px 30px rgba(20,53,143,.06);margin-top:24px}
.lux8-tut .lux8-search input{flex:1;width:100%;border:0;outline:0;background:transparent;font-size:15px;color:var(--ink);font-family:inherit}
.lux8-tut .lux8-search button{border:0;background:var(--blue);color:#fff;height:40px;padding:0 20px;border-radius:12px;font-weight:700;font-size:14px;cursor:pointer;white-space:nowrap}
.lux8-tut .lux8-filters{display:flex;gap:10px;flex-wrap:wrap;margin-bottom:28px}
.lux8-tut .lux8-pill{height:42px;border-radius:999px;border:1px solid var(--line);background:#fff;padding:0 17px;display:inline-flex;align-items:center;font-weight:700;font-size:14px;color:#344054;text-decoration:none}
.lux8-tut .lux8-pill:hover{border-color:#bdd4ff;color:var(--blue)}
.lux8-tut .lux8-pill.active{background:var(--blue);color:#fff;border-color:var(--blue)}
.lux8-tut .lux8-featured{display:grid;grid-template-columns:1.15fr .85fr;gap:26px;padding:24px;border:1px solid var(--line);border-radius:26px;background:#fff;box-shadow:0 14px 40px rgba(20,53,143,.07);margin-bottom:34px}
.lux8-tut .lux8-fmedia{min-height:280px;border-radius:22px;background:linear-gradient(135deg,#09286f,#1765ff);display:flex;align-items:center;justify-content:center;color:#fff;position:relative;overflow:hidden;text-decoration:none}
.lux8-tut .lux8-play-big{width:76px;height:76px;border-radius:50%;display:flex;align-items:center;justify-content:center;background:rgba(255,255,255,.18);border:1px solid rgba(255,255,255,.35)}
.lux8-tut .lux8-play-big:before{content:'';border-left:20px solid #fff;border-top:12px solid transparent;border-bottom:12px solid transparent;margin-left:5px}
.lux8-tut .lux8-fduration{position:absolute;right:16px;bottom:16px;padding:6px 10px;border-radius:9px;background:rgba(6,20,54,.78);font-size:12px;font-weight:800}
.lux8-tut .lux8-fbody{padding:16px 10px}
.lux8-tut .lux8-tag{display:inline-flex;padding:7px 11px;border-radius:999px;background:#eaf3ff;color:var(--blue);font-size:12px;font-weight:900}
.lux8-tut .lux8-fbody h2{font-size:28px;line-height:1.25;margin:16px 0 10px;color:#102b76}
.lux8-tut .lux8-fbody p{color:var(--muted);line-height:1.75;margin:0}
.lux8-tut .lux8-fmeta{display:flex;gap:16px;flex-wrap:wrap;color:#667085;font-size:13px;font-weight:700;margin:18px 0}
.lux8-tut .lux8-progress-line{height:8px;border-radius:999px;background:#edf2fb;overflow:hidden;margin-bottom:20px}
.lux8-tut .lux8-progress-line span{display:block;height:100%;background:linear-gradient(90deg,var(--blue),var(--sky))}
.lux8-tut .lux8-primary-btn{height:46px;padding:0 24px;border-radius:12px;background:linear-gradient(135deg,var(--blue),#0d57df);color:#fff;font-weight:800;display:inline-flex;align-items:center;justify-content:center;gap:10px;box-shadow:0 12px 24px rgba(23,101,255,.22);text-decoration:none}
.lux8-tut .lux8-section-head{display:flex;justify-content:space-between;align-items:flex-end;gap:20px;margin:0 0 20px}
.lux8-tut .lux8-section-head h2{font-size:26px;color:#102b76;margin:0}
.lux8-tut .lux8-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:20px}
.lux8-tut .lux8-vcard{border:1px solid var(--line);border-radius:22px;background:#fff;overflow:hidden;transition:.2s;box-shadow:0 12px 34px rgba(20,53,143,.055);display:block}
.lux8-tut .lux8-vcard:hover{transform:translateY(-4px);box-shadow:0 18px 42px rgba(20,53,143,.1)}
.lux8-tut .lux8-thumb{height:170px;background:linear-gradient(135deg,#eef6ff,#dbeeff);display:flex;align-items:center;justify-content:center;color:var(--blue);position:relative}
.lux8-tut .lux8-thumb img{width:100%;height:100%;object-fit:cover;position:absolute;inset:0}
.lux8-tut .lux8-thumb .lux8-play{width:52px;height:52px;border-radius:50%;background:#fff;display:flex;align-items:center;justify-content:center;box-shadow:0 12px 30px rgba(20,53,143,.15);z-index:1}
.lux8-tut .lux8-thumb .lux8-play:before{content:'';border-left:16px solid var(--blue);border-top:10px solid transparent;border-bottom:10px solid transparent;margin-left:4px}
.lux8-tut .lux8-thumb .lux8-duration{position:absolute;right:12px;bottom:12px;padding:5px 9px;border-radius:8px;background:rgba(6,20,54,.78);color:#fff;font-size:12px;font-weight:800;z-index:1}
.lux8-tut .lux8-vbody{padding:19px}
.lux8-tut .lux8-vbody h3{font-size:18px;line-height:1.45;color:#102b76;margin:11px 0 7px;font-weight:800}
.lux8-tut .lux8-vbody p{font-size:13px;color:var(--muted);line-height:1.6;margin:0}
.lux8-tut .lux8-card-meta{display:flex;justify-content:space-between;gap:12px;margin-top:15px;color:#667085;font-size:12px;font-weight:700}
.lux8-tut .lux8-mini-progress{height:6px;border-radius:999px;background:#edf2fb;overflow:hidden;margin-top:14px}
.lux8-tut .lux8-mini-progress span{display:block;height:100%;background:var(--blue)}
.lux8-tut .lux8-empty{text-align:center;padding:54px 20px;border:1px dashed #c9d8f2;border-radius:22px;background:#fbfdff;color:var(--muted)}
.lux8-tut .lux8-pagi{margin-top:34px;display:flex;justify-content:center}
@media(max-width:1024px){.lux8-tut .lux8-grid{grid-template-columns:repeat(2,1fr)}.lux8-tut .lux8-featured{grid-template-columns:1fr}}
@media(max-width:640px){.lux8-tut .lux8-grid{grid-template-columns:1fr}.lux8-tut .lux8-hero h1{font-size:28px}}
/* ===================================================
   [FIX] แก้ไข Pagination ของ Tailwind + ลบแถบสีดำ (.lux8-pagi)
   =================================================== */

/* 1. ล้างแถบสีดำและพื้นหลังตัวคุมทั้งหมด */
.lux8-tut .lux8-pagi,
.lux8-tut .lux8-pagi nav,
.lux8-tut .lux8-pagi nav > div,
.lux8-tut .lux8-pagi nav .flex,
.lux8-tut .lux8-pagi nav .inline-flex {
  background-color: transparent !important;
  background: transparent !important;
  box-shadow: none !important;
  border-color: transparent !important;
}

/* 2. จัดตำแหน่ง Pagination ให้อยู่ตรงกลาง */
.lux8-tut .lux8-pagi {
  margin-top: 34px !important;
  display: flex !important;
  justify-content: center !important;
  align-items: center !important;
  width: 100% !important;
}

.lux8-tut .lux8-pagi nav {
  display: flex !important;
  justify-content: center !important;
  align-items: center !important;
  gap: 8px !important;
}

.lux8-tut .lux8-pagi nav > div {
  display: flex !important;
  align-items: center !important;
  gap: 6px !important;
  background: transparent !important;
}

/* 3. ซ่อนข้อความส่วนเกินของ Tailwind (เช่น Showing 1 to 10...) ถ้ามี */
.lux8-tut .lux8-pagi nav p.text-sm,
.lux8-tut .lux8-pagi nav .hidden.sm\:flex-1 {
  display: none !important;
}

/* 4. แต่งปุ่มกดทั้งหมด (ก่อนหน้า, ถัดไป, ตัวเลข) */
.lux8-tut .lux8-pagi nav a,
.lux8-tut .lux8-pagi nav span[aria-current="page"],
.lux8-tut .lux8-pagi nav span[aria-disabled="true"],
nav[aria-label="Pagination Navigation"] a,
nav[aria-label="Pagination Navigation"] span {
  display: inline-flex !important;
  align-items: center !important;
  justify-content: center !important;
  min-width: 38px !important;
  height: 38px !important;
  padding: 0 16px !important;
  border-radius: 10px !important;
  border: 1.5px solid #e6edf8 !important;
  background-color: #ffffff !important;
  background: #ffffff !important;
  color: #344054 !important;
  font-weight: 700 !important;
  font-size: 13px !important;
  text-decoration: none !important;
  transition: all .2s ease !important;
  box-shadow: 0 2px 4px rgba(20, 53, 143, 0.04) !important;
  margin: 0 !important;
}

/* 5. สถานะ Hover */
.lux8-tut .lux8-pagi nav a:hover,
nav[aria-label="Pagination Navigation"] a:hover {
  border-color: #1765ff !important;
  color: #1765ff !important;
  background-color: #f4f9ff !important;
  background: #f4f9ff !important;
}

/* 6. สถานะ Active (หน้าปัจจุบัน) */
.lux8-tut .lux8-pagi nav span[aria-current="page"] > span,
.lux8-tut .lux8-pagi nav span[aria-current="page"],
nav[aria-label="Pagination Navigation"] span[aria-current="page"] span {
  background-color: #1765ff !important;
  background: #1765ff !important;
  border-color: #1765ff !important;
  color: #ffffff !important;
}

/* 7. สถานะ Disabled (ปุ่มกดไม่ได้) */
.lux8-tut .lux8-pagi nav span[aria-disabled="true"] > span,
.lux8-tut .lux8-pagi nav span[aria-disabled="true"] {
  background-color: #f8fafc !important;
  background: #f8fafc !important;
  color: #c1c9d6 !important;
  border-color: #eef1f6 !important;
  cursor: not-allowed !important;
}
</style>
@endsection

@section('content')

<section id="content">
    <div class="content-wrap">
        <div class="container lux8-tut">
            @if (!empty($breadcrumb))
            <section id="page-title" class="page-title-mini">
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

            <div class="lux8-hero">
                <span class="lux8-eyebrow">LEARNING CENTER</span>
                <h1>{{ $og_title }}</h1>
                <p>เรียนรู้การใช้งานตั้งแต่เริ่มต้น การติดตั้ง คำสั่งพื้นฐาน ไปจนถึง Workflow สำหรับงานจริง</p>
                <form action="{{ route('fronend.tutorial.main') }}" method="GET" class="lux8-search">
                    <input type="text" name="search" placeholder="ค้นหาวิดีโอ หัวข้อ หรือคำสั่ง...">
                    <button type="submit">ค้นหา</button>
                </form>
            </div>

            @if(!empty($categories))
                <div class="lux8-filters">
                    <a href="{{ route('fronend.tutorial.main') }}" class="lux8-pill {{ empty($activeTag) ? 'active' : '' }}">ทั้งหมด</a>
                    @foreach($categories as $cat)
                        <a href="{{ route('fronend.tutorial.searchtag', $cat) }}" class="lux8-pill {{ (!empty($activeTag) && $activeTag === $cat) ? 'active' : '' }}">{{ $cat }}</a>
                    @endforeach
                </div>
            @endif
            <div class="lux8-filters" style="margin-top:8px">
    <a href="{{ route('fronend.tutorial.main') }}" class="lux8-pill {{ empty(request('group')) ? 'active' : '' }}">ทุกกลุ่ม</a>
    <a href="{{ route('fronend.tutorial.main', ['group' => 'Install 2025']) }}" class="lux8-pill {{ request('group') == 'Install 2025' ? 'active' : '' }}">Install 2025</a>
    <a href="{{ route('fronend.tutorial.main', ['group' => 'Install 2026']) }}" class="lux8-pill {{ request('group') == 'Install 2026' ? 'active' : '' }}">Install 2026</a>
    <a href="{{ route('fronend.tutorial.main', ['group' => 'PTCAD 2024']) }}" class="lux8-pill {{ request('group') == 'PTCAD 2024' ? 'active' : '' }}">PTCAD 2024</a>
    <a href="{{ route('fronend.tutorial.main', ['group' => 'PTCAD 2025']) }}" class="lux8-pill {{ request('group') == 'PTCAD 2025' ? 'active' : '' }}">PTCAD 2025</a>
    <a href="{{ route('fronend.tutorial.main', ['group' => 'PTCAD 2026']) }}" class="lux8-pill {{ request('group') == 'PTCAD 2026' ? 'active' : '' }}">PTCAD 2026</a>
</div>

            @if(!empty($continueTutorial))
                <article class="lux8-featured">
                    <a class="lux8-fmedia" href="{{ route('fronend.tutorial.content', $continueTutorial->tut_parmalink) }}">
                        <span class="lux8-play-big"></span>
                        @if(!empty($continueTutorial->tut_duration))
                            <span class="lux8-fduration">{{ $continueTutorial->tut_duration }}</span>
                        @endif
                    </a>
                    <div class="lux8-fbody">
                        <span class="lux8-tag">ดูต่อจากเดิม</span>
                        <h2>{{ $continueTutorial->tut_name }}</h2>
                        <p>{{ \Illuminate\Support\Str::limit(strip_tags($continueTutorial->tut_seo_detail), 140) }}</p>
                        <div class="lux8-fmeta">
                            @if(!empty($continueTutorial->tut_duration))<span>{{ $continueTutorial->tut_duration }}</span>@endif
                            <span>ดูแล้ว {{ $continueRow->percent }}%</span>
                        </div>
                        <div class="lux8-progress-line"><span style="width:{{ $continueRow->percent }}%"></span></div>
                        <a class="lux8-primary-btn" href="{{ route('fronend.tutorial.content', $continueTutorial->tut_parmalink) }}">ดูต่อจากเดิม</a>
                    </div>
                </article>
            @endif

            <div class="lux8-section-head">
                <div><h2>วิดีโอทั้งหมด</h2></div>
            </div>

            @if (count($tutorials) != 0)
                <div class="lux8-grid">
                    @foreach ($tutorials as $tutorial)
                        <a href="{{ route('fronend.tutorial.content', $tutorial->tut_parmalink) }}" class="lux8-vcard">
                            <div class="lux8-thumb">
                                @if(!empty($tutorial->tut_thumb))
                                    <img class="lazyload" loading="lazy" data-src="{{ asset('storage/tutorial/' . $tutorial->tut_thumb) }}" alt="{{ $tutorial->tut_name }}">
                                @endif
                                <span class="lux8-play"></span>
                                @if(!empty($tutorial->tut_duration))
                                    <span class="lux8-duration">{{ $tutorial->tut_duration }}</span>
                                @endif
                            </div>
                            <div class="lux8-vbody">
                                <h3>{{ $tutorial->tut_name }}</h3>
                                <p>{{ \Illuminate\Support\Str::limit(strip_tags($tutorial->tut_seo_detail), 90) }}</p>
                                <div class="lux8-card-meta">
                                    <span>{{ date("d/m/Y", strtotime($tutorial->created_at)) }}</span>
                                    @if(isset($progressMap[$tutorial->id]))
                                        @if($progressMap[$tutorial->id]['completed'] == 1)
                                            <span>เรียนจบแล้ว</span>
                                        @else
                                            <span>ดูแล้ว {{ $progressMap[$tutorial->id]['percent'] }}%</span>
                                        @endif
                                    @else
                                        <span>ยังไม่ได้ดู</span>
                                    @endif
                                </div>
                                <div class="lux8-mini-progress">
                                    <span style="width:{{ isset($progressMap[$tutorial->id]) ? $progressMap[$tutorial->id]['percent'] : 0 }}%"></span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
                <div class="lux8-pagi">{!! $tutorials->links() !!}</div>
            @else
                <div class="lux8-empty">
                    <h4>ยังไม่มีวิดีโอ Tutorial</h4>
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
