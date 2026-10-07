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
.lux8-article{--a-navy:#12358f;--a-blue:#1765ff;--a-ink:#0b1f4d;--a-muted:#667085;--a-line:#e6edf8;font-family:'Poppins','Noto Sans Thai',inherit;color:var(--a-ink)}
.lux8-article h1.lux8-a-title{font-size:34px;line-height:1.2;color:#102b76;margin:0 0 14px;letter-spacing:-0.5px;font-weight:800}
.lux8-article .lux8-a-meta{display:flex;gap:16px;flex-wrap:wrap;color:var(--a-muted);font-size:13px;font-weight:600;margin-bottom:22px}
.lux8-article .lux8-a-meta span,.lux8-article .lux8-a-meta a{display:inline-flex;align-items:center;gap:6px;color:var(--a-muted)}
.lux8-article .lux8-a-cover{border-radius:22px;overflow:hidden;margin-bottom:30px}
.lux8-article .lux8-a-cover img{width:100%;display:block}
.lux8-article .lux8-a-layout{display:grid;grid-template-columns:minmax(0,1fr) 280px;gap:30px;align-items:start}
.lux8-article .lux8-a-copy{background:#fff;border:1px solid var(--a-line);border-radius:22px;padding:32px;box-shadow:0 12px 34px rgba(20,53,143,.055)}
.lux8-article .lux8-a-copy h2{font-size:26px;color:#102b76;margin:34px 0 12px;scroll-margin-top:110px}
.lux8-article .lux8-a-copy h2:first-child{margin-top:0}
.lux8-article .lux8-a-copy h3{font-size:20px;color:#163886;margin:22px 0 10px;scroll-margin-top:110px}
.lux8-article .lux8-a-copy p,.lux8-article .lux8-a-copy li{color:#4f5d75;line-height:1.85;font-size:16px}
.lux8-article .lux8-a-copy img{max-width:100%;height:auto;border-radius:16px;border:1px solid var(--a-line);margin:16px 0}
.lux8-article .lux8-a-copy table{width:100%;border-collapse:collapse}
.lux8-article .lux8-a-copy th,.lux8-article .lux8-a-copy td{padding:12px 14px;border:1px solid var(--a-line);text-align:left}
.lux8-article .lux8-a-copy th{background:#f2f7ff;color:#12358f}
.lux8-article .lux8-a-toc{position:sticky;top:100px;background:#fff;border:1px solid var(--a-line);border-radius:20px;padding:20px;box-shadow:0 12px 34px rgba(20,53,143,.055)}
.lux8-article .lux8-a-toc h3{margin:0 0 12px;color:#102b76;font-size:16px}
.lux8-article .lux8-a-toc a{display:block;padding:9px 0;color:var(--a-muted);font-size:13px;border-bottom:1px solid var(--a-line);text-decoration:none}
.lux8-article .lux8-a-toc a:last-child{border:0}
.lux8-article .lux8-a-toc a:hover{color:var(--a-blue)}
.lux8-article .lux8-a-toc.lux8-hide{display:none}
.lux8-article .lux8-a-tags{margin-top:22px}
.lux8-article .lux8-a-tags a{display:inline-block;border:1px solid var(--a-line);border-radius:999px;padding:6px 14px;font-size:12px;color:var(--a-blue);margin:0 6px 6px 0;text-decoration:none}
.lux8-article .lux8-a-share{display:flex;align-items:center;gap:10px;margin-top:24px}
@media(max-width:992px){.lux8-article .lux8-a-layout{grid-template-columns:1fr}.lux8-article .lux8-a-toc{position:static}}
</style>
@endsection

@section('content')

<section id="content">
    <div class="content-wrap">
        <div class="container lux8-article">
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

            @if(!empty($articles))
                <div class="entry clearfix">
                    <h1 class="lux8-a-title">{{ $articles->art_name }}</h1>

                    <div class="lux8-a-meta">
                        <span><i class="icon-calendar3"></i> {{ date("d-m-Y",strtotime($articles->created_at)) }}</span>
                        <a href="#"><i class="icon-user"></i> {{ (!empty($articles->displayname) ? $articles->displayname : $articles->created_by) }}</a>
                        <a href="#"><i class="icon-eye"></i> {{ number_format($articles->art_view) }}</a>
                        @if (Route::has('administrator'))
                            @auth
                                @php
                                    $UserLevel = App\Models\UsersLevel::select('l_artlicle','UserId')->where('UserId',Auth::user()->id)->value('l_artlicle');
                                    if($UserLevel == 1){
                                        echo '<a href="'.route('artlicle.edit',['id' => $articles->id]).'" class="co_337ab7"><i class="icon-edit"></i> แก้ไขบทความ</a>';
                                    }
                                @endphp
                            @endauth
                        @endif
                    </div>

                    @if (!empty($articles->art_thumb))
                        <div class="lux8-a-cover">
                            <img class="lazyload" loading="lazy" data-src="{{ asset('storage/article/'.$articles->art_thumb) }}" alt="{{ $articles->art_name }}">
                        </div>
                    @endif

                    <div class="lux8-a-layout">
                        <div class="lux8-a-copy" id="lux8ArticleContent">
                            {!! $articles->art_detail !!}

                            @if(!empty($articles->art_keyword))
                                @php
                                    $tags = explode(",",$articles->art_keyword);
                                    asort($tags);
                                @endphp
                                <div class="lux8-a-tags">
                                    @foreach ( $tags as $tag )
                                        <a href="{{ route('fronend.article.searchtag',$tag) }}" rel="tag">{{ $tag }}</a>
                                    @endforeach
                                </div>
                            @endif

                            <div class="lux8-a-share">
                                <div>แบ่งปัน:</div>
                                <a href="http://www.facebook.com/sharer.php?u={{ route('fronend.article.content',$articles->art_parmalink) }}" target="_blank" class="social-icon si-small si-colored si-facebook">
                                    <i class="icon-facebook"></i>
                                    <i class="icon-facebook"></i>
                                </a>
                                <a href="http://twitter.com/share?url={{ route('fronend.article.content',$articles->art_parmalink) }}" target="_blank" class="social-icon si-small si-colored si-twitter">
                                    <i class="icon-twitter"></i>
                                    <i class="icon-twitter"></i>
                                </a>
                                <a href="https://social-plugins.line.me/lineit/share?url={{ route('fronend.article.content',$articles->art_parmalink) }}" target="_blank" class="social-icon si-small si-colored si-ebay">
                                    <i><img width="30" height="30" class="lazyload" loading="lazy" data-src="{{ asset('icon/social/icon-line-covered.webp') }}" alt="line"></i>
                                    <i><img width="30" height="30" class="lazyload" loading="lazy" data-src="{{ asset('icon/social/icon-line-covered.webp') }}" alt="line"></i>
                                </a>
                            </div>

                            @if (!empty($author))
                                @if($articles->art_author == 1)
                                <div class="ling-content"></div>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">โพสต์โดย :: {{ $author->penname }}</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="author-image">
                                            @if(!empty($author->img))
                                                <img src="{{ asset('storage/avatar/' . $author->img) }}" class="img-circle" alt="{{ $author->penname }}">
                                            @else
                                                <img src="{{ asset('assets/fontend/images/noImg/no-01.jpg') }}" class="img-circle" alt="{{ $author->penname }}">
                                            @endif
                                        </div>
                                        {{ $author->aboutme }}
                                    </div>
                                </div>
                                @endif
                            @endif
                        </div>

                        <aside class="lux8-a-toc lux8-hide" id="lux8Toc">
                            <h3>สารบัญ</h3>
                            <div id="lux8TocLinks"></div>
                        </aside>
                    </div>
                </div>
            @else
                <div class="topmargin-lg bottommargin-lg center">
                    <h3>ไม่พบข้อมูล</h3>
                </div>
            @endif
        </div>
    </div>
</section>
@endsection

@section('js')
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/th_TH/sdk.js#xfbml=1&version=v12.0&appId=1190234624660031&autoLogAppEvents=1" nonce="h8yjg5hD"></script>
<script src="https://d.line-scdn.net/r/web/social-plugin/js/thirdparty/loader.min.js" async="async" defer="defer"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var content = document.getElementById('lux8ArticleContent');
    var headings = content ? content.querySelectorAll('h2, h3') : [];
    var toc = document.getElementById('lux8Toc');
    var linksBox = document.getElementById('lux8TocLinks');
    if (headings.length > 1) {
        headings.forEach(function (h, i) {
            if (!h.id) { h.id = 'lux8-h-' + i; }
            var a = document.createElement('a');
            a.href = '#' + h.id;
            a.textContent = h.textContent;
            if (h.tagName === 'H3') { a.style.paddingLeft = '14px'; a.style.fontSize = '12px'; }
            linksBox.appendChild(a);
        });
        toc.classList.remove('lux8-hide');
    }
});
</script>
@endsection