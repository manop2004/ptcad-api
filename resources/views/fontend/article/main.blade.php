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
.lux8-news{--n-navy:#12358f;--n-blue:#1765ff;--n-ink:#0b1f4d;--n-muted:#667085;--n-line:#e6edf8;font-family:'Poppins','Noto Sans Thai',inherit;color:var(--n-ink)}
.lux8-news .lux8-hero{padding:56px 40px;background:radial-gradient(circle at 82% 30%,rgba(143,211,255,.35),transparent 27%),linear-gradient(105deg,#fff 0%,#f3f8ff 58%,#e3f3ff 100%);border-radius:26px;margin-bottom:28px}
.lux8-news .lux8-eyebrow{display:inline-block;color:var(--n-blue);font-weight:800;font-size:14px;margin-bottom:12px;letter-spacing:.5px}
.lux8-news .lux8-hero h1{font-size:40px;line-height:1.15;margin:0 0 12px;color:var(--n-navy);letter-spacing:-1px;font-weight:800}
.lux8-news .lux8-hero p{max-width:760px;color:var(--n-muted);font-size:16px;line-height:1.7;margin:0}
.lux8-news .lux8-search{height:56px;max-width:640px;border:1px solid var(--n-line);border-radius:18px;background:#fff;display:flex;align-items:center;gap:12px;padding:0 8px 0 20px;box-shadow:0 12px 30px rgba(20,53,143,.06);margin-top:24px}
.lux8-news .lux8-search input{flex:1;width:100%;border:0;outline:0;background:transparent;font-size:15px;color:var(--n-ink);font-family:inherit}
.lux8-news .lux8-search button{border:0;background:var(--n-blue);color:#fff;height:40px;padding:0 20px;border-radius:12px;font-weight:700;font-size:14px;cursor:pointer;white-space:nowrap}

/* [ใหม่] ครอบทั้งสองแถวปุ่มกรอง (หมวดหมู่ + keyword) ไว้ในกล่องเดียว ให้แต่ละแถวมี label เล็กๆ กำกับ ไม่ให้งงว่าอันไหนคืออันไหน */
.lux8-news .lux8-filter-group{margin-bottom:22px}
.lux8-news .lux8-filter-label{font-size:12px;font-weight:800;color:var(--n-muted);text-transform:uppercase;letter-spacing:.4px;margin:0 0 8px 2px}
.lux8-news .lux8-filters{display:flex;gap:10px;flex-wrap:wrap;margin-bottom:14px}
.lux8-news .lux8-filters:last-child{margin-bottom:0}
.lux8-news .lux8-pill{height:42px;border-radius:999px;border:1px solid var(--n-line);background:#fff;padding:0 17px;display:inline-flex;align-items:center;font-weight:700;font-size:14px;color:#344054;text-decoration:none}
.lux8-news .lux8-pill:hover{border-color:#bdd4ff;color:var(--n-blue)}
.lux8-news .lux8-pill.active{background:var(--n-blue);color:#fff;border-color:var(--n-blue)}
/* แถวหมวดหมู่ (คงที่ 2 ปุ่ม) ให้เด่นกว่าอีกแถวนิดหน่อยด้วยตัวหนา/พื้นหลังต่าง */
.lux8-news .lux8-filters.lux8-filters-cat .lux8-pill{border-width:1.5px}
.lux8-news .lux8-filters.lux8-filters-cat .lux8-pill.active{box-shadow:0 8px 18px rgba(23,101,255,.22)}
/* แถว keyword ให้เล็กลงนิดหน่อย ดูเป็นแท็กรอง ไม่แย่งความสำคัญจากแถวหมวดหมู่ */
.lux8-news .lux8-filters.lux8-filters-tag .lux8-pill{height:36px;font-size:12.5px;padding:0 14px;color:var(--n-muted)}
.lux8-news .lux8-filters.lux8-filters-tag .lux8-pill.active{color:#fff}

.lux8-news .lux8-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:22px}
.lux8-news .lux8-card{background:#fff;border:1px solid var(--n-line);border-radius:22px;overflow:hidden;box-shadow:0 12px 34px rgba(20,53,143,.055);transition:.2s;display:block}
.lux8-news .lux8-card:hover{transform:translateY(-4px);box-shadow:0 18px 42px rgba(20,53,143,.1)}
.lux8-news .lux8-card-media{height:174px;overflow:hidden;background:linear-gradient(135deg,#eef6ff,#dbeeff)}
.lux8-news .lux8-card-media img{width:100%;height:100%;object-fit:cover}
.lux8-news .lux8-card-body{padding:20px}
.lux8-news .lux8-card-body h4{font-size:19px;line-height:1.4;color:#102b76;margin:0 0 8px;font-weight:800}
.lux8-news .lux8-card-body .lux8-desc{color:var(--n-muted);font-size:14px;line-height:1.6;margin:0}
/* [แก้ใหม่] แถวล่างการ์ด: วันที่ชิดซ้าย, ปุ่มอ่านต่อชิดขวา */
.lux8-news .lux8-card-footer{display:flex;align-items:center;justify-content:space-between;margin-top:12px}
.lux8-news .lux8-card-body .lux8-meta{color:#98a2b3;font-size:12px;font-weight:600;margin:0}
.lux8-news .lux8-card-link{display:inline-flex;align-items:center;gap:6px;color:var(--n-blue);font-weight:800;font-size:14px;margin:0}
.lux8-news .lux8-empty{text-align:center;padding:54px 20px;border:1px dashed #c9d8f2;border-radius:22px;background:#fbfdff;color:var(--n-muted)}
.lux8-news .lux8-pagi{margin-top:38px}
/* [แก้ใหม่] จัดปุ่ม pagination ให้อยู่กึ่งกลาง */
.lux8-news .lux8-pagi nav{display:flex!important;justify-content:center!important;background:transparent!important;background-color:transparent!important;padding:0!important;width:auto!important}
.lux8-news .lux8-pagi nav > div:nth-child(2){display:none!important}
.lux8-news .lux8-pagi nav > div:nth-child(1){display:flex!important;gap:10px!important;flex:none!important}
.lux8-news .lux8-pagi nav > div:nth-child(1) a,
.lux8-news .lux8-pagi nav > div:nth-child(1) span{
  display:inline-flex!important;align-items:center!important;justify-content:center!important;
  padding:9px 22px!important;background:#fff!important;border:1px solid var(--n-line)!important;
  border-radius:10px!important;color:var(--n-navy)!important;font-weight:700!important;
  font-size:14px!important;text-decoration:none!important;
}
.lux8-news .lux8-pagi nav > div:nth-child(1) a:hover{border-color:var(--n-blue)!important;color:var(--n-blue)!important}
.lux8-news .lux8-pagi nav > div:nth-child(1) span{opacity:.4!important;cursor:default!important}
.lux8-news .lux8-pagi nav a:hover{border-color:var(--n-blue)!important;color:var(--n-blue)!important}
.lux8-news .lux8-pagi nav [aria-current="page"] span{background:var(--n-blue)!important;border-color:var(--n-blue)!important;color:#fff!important}
.lux8-news .lux8-pagi nav .sr-only{position:absolute!important;width:1px!important;height:1px!important;overflow:hidden!important}
@media(max-width:1024px){.lux8-news .lux8-grid{grid-template-columns:repeat(2,1fr)}}
@media(max-width:640px){.lux8-news .lux8-grid{grid-template-columns:1fr}.lux8-news .lux8-hero{padding:36px 22px}.lux8-news .lux8-hero h1{font-size:28px}}
</style>
@endsection

@section('content')

<section id="content">
    <div class="content-wrap">
        <div class="container lux8-news">
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
                <span class="lux8-eyebrow">NEWS &amp; TIPS</span>
                <h1>{{ $og_title }}</h1>
                <p>อัปเดตข่าวสาร เทคนิคการใช้งาน และสาระดี ๆ เพื่อให้เริ่มต้นง่ายและทำงานได้คล่องขึ้น</p>
                <form action="{{ route('fronend.article.search') }}" method="GET" class="lux8-search">
                    <input type="text" name="search_artlicle" placeholder="ค้นหาบทความ..." value="{{ request('search_artlicle') }}">
                    <button type="submit">ค้นหา</button>
                </form>
            </div>

            {{-- ===================================================================
                 [ใหม่] แถวที่ 1: หมวดหมู่คงที่ (art_cat) — "ทั้งหมด / ข่าวสาร / Tips & Tricks"
                 คนละระบบกับแถว keyword tag ด้านล่าง ใช้ route fronend.article.category
            =================================================================== --}}
            @if(!empty($artCats))
                <div class="lux8-filter-group">
                    <div class="lux8-filter-label">หมวดหมู่</div>
                    <div class="lux8-filters lux8-filters-cat">
                        <a href="{{ route('fronend.article.main') }}" class="lux8-pill {{ empty($activeCat) ? 'active' : '' }}">ทั้งหมด</a>
                        @foreach($artCats as $cat)
                            <a href="{{ route('fronend.article.category', $cat) }}" class="lux8-pill {{ (!empty($activeCat) && $activeCat === $cat) ? 'active' : '' }}">{{ $cat }}</a>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- แถวที่ 2: keyword tag เดิม (ระบบเดิมที่ใช้อยู่แล้ว ไม่ได้แตะ logic) --}}
            @if(!empty($categories))
                <div class="lux8-filter-group">
                    <div class="lux8-filter-label">แท็กยอดนิยม</div>
                    <div class="lux8-filters lux8-filters-tag">
                        @foreach($categories as $cat)
                            <a href="{{ route('fronend.article.searchtag', $cat) }}" class="lux8-pill {{ (!empty($activeTag) && $activeTag === $cat) ? 'active' : '' }}">{{ $cat }}</a>
                        @endforeach
                    </div>
                </div>
            @endif

            @if (count($articles) != 0)
                <div class="lux8-grid">
                    @foreach ($articles as $article)
                        <a href="{{ route('fronend.article.content',$article->art_parmalink) }}" class="lux8-card">
                            <div class="lux8-card-media">
                                @if(!empty($article->art_thumb))
                                    <img width="310" height="172" class="lazyload" loading="lazy" data-src="{{ asset('storage/article/' . $article->art_thumb) }}" alt="{{ $article->art_name }}">
                                @else
                                    <img width="310" height="172" class="lazyload" loading="lazy" data-src="{{ asset('images/default-img/no-image-available-article.webp') }}" alt="{{ $article->art_name }}">
                                @endif
                            </div>
                            <div class="lux8-card-body">
                                <h4>{{ $article->art_name }}</h4>
                                <p class="lux8-desc">{{ \Illuminate\Support\Str::limit(strip_tags($article->art_seo_detail), 90) }}</p>
                                <div class="lux8-card-footer">
                                    <div class="lux8-meta">{{ date("d/m/Y", strtotime($article->created_at)) }}</div>
                                    <div class="lux8-card-link">อ่านต่อ &gt;</div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="clear"></div>
                <div class="lux8-pagi">{!! $articles->links() !!}</div>
            @else
                <div class="lux8-empty">
                    <h4>ไม่พบข้อมูล</h4>
                    
                </div>
            @endif
        </div>
    </div>
</section>
@endsection