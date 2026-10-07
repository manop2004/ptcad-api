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
.lux8-tut-d{--navy:#12358f;--blue:#1765ff;--ink:#0b1f4d;--muted:#667085;--line:#e6edf8;font-family:'Poppins','Noto Sans Thai',inherit;color:var(--ink);max-width:820px;margin:0 auto}
.lux8-tut-d h1.lux8-td-title{font-size:32px;line-height:1.2;color:#102b76;margin:0 0 14px;font-weight:800}
.lux8-tut-d .lux8-td-meta{display:flex;gap:16px;flex-wrap:wrap;color:var(--muted);font-size:13px;font-weight:600;margin-bottom:22px}

/* เปลี่ยนชื่อคลาสใหม่ทั้งหมดเพื่อแก้ปัญหาเบราว์เซอร์จำ Cache ตัวเก่า */
.lux8-tut-d .lux8-video-card{max-width:720px;margin:0 auto 26px;border-radius:22px;overflow:hidden;background:#000;box-shadow:0 14px 40px rgba(20,53,143,.1)}
.lux8-tut-d .lux8-video-card .video-aspect-16-9{position:relative;width:100%;padding-top:56.25% !important;display:block !important;height:0 !important;overflow:hidden !important}

/* บังคับเฉพาะ iframe ให้กว้าง-สูงเต็มกรอบแบบสัดส่วนปกติ (Contain) ไม่ซูม ไม่ล้นเฟรมเด็ดขาด */
.lux8-tut-d .lux8-video-container {
    position: absolute !important;
    top: 0 !important;
    left: 0 !important;
    width: 100% !important;
    height: 100% !important;
}
.lux8-tut-d .lux8-video-container iframe {
    position: absolute !important;
    top: 0 !important;
    left: 0 !important;
    width: 100% !important;
    height: 100% !important;
    min-width: 100% !important;
    min-height: 100% !important;
    max-width: 100% !important;
    max-height: 100% !important;
    object-fit: contain !important; 
    border: 0 !important;
}

.lux8-tut-d .lux8-td-copy{background:#fff;border:1px solid var(--line);border-radius:22px;padding:30px;box-shadow:0 12px 34px rgba(20,53,143,.055)}
.lux8-tut-d .lux8-td-copy p,.lux8-tut-d .lux8-td-copy li{color:#4f5d75;line-height:1.85;font-size:15px}
.lux8-tut-d .lux8-td-tags{margin-top:20px}
.lux8-tut-d .lux8-td-tags a{display:inline-block;border:1px solid var(--line);border-radius:999px;padding:6px 14px;font-size:12px;color:var(--blue);margin:0 6px 6px 0;text-decoration:none}

/* แถบ progress bar */
.lux8-tut-d .lux8-td-progress{max-width:720px;margin:0 auto 20px}
.lux8-tut-d .lux8-td-progress .bar{height:8px;border-radius:999px;background:#edf2fb;overflow:hidden}
.lux8-tut-d .lux8-td-progress .bar span{display:block;height:100%;background:var(--blue)}
.lux8-tut-d .lux8-td-progress small{color:var(--muted);font-weight:700}
</style>
@endsection

@section('content')
<section id="content">
    <div class="content-wrap">
        <div class="container lux8-tut-d">
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

            @if(!empty($tutorial))
                <h1 class="lux8-td-title">{{ $tutorial->tut_name }}</h1>
                <div class="lux8-td-meta">
                    <span><i class="icon-calendar3"></i> {{ date("d-m-Y",strtotime($tutorial->created_at)) }}</span>
                    @if(!empty($tutorial->tut_duration))<span><i class="icon-clock"></i> {{ $tutorial->tut_duration }}</span>@endif
                    <span><i class="icon-eye"></i> {{ number_format($tutorial->tut_view) }}</span>
                </div>

                @if(!empty($tutorial->tut_video))
                    <!-- อัปเดตโครงสร้างคลาสใหม่เพื่อเลี่ยงแคชเดิม -->
                    <div class="lux8-video-card">
                        <div class="video-aspect-16-9">
                            <div class="lux8-video-container">
                                <iframe id="lux8TutIframe" src="{{ $tutorial->tut_video }}?enablejsapi=1" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="lux8-td-progress">
                    <div class="bar"><span id="lux8ProgressBar" style="width:{{ !empty($progress) ? $progress->percent : 0 }}%"></span></div>
                    <small id="lux8ProgressText">ดูแล้ว {{ !empty($progress) ? $progress->percent : 0 }}%</small>
                </div>

                <div class="lux8-td-copy">
                    @if(!empty($tutorial->tut_detail))
                        {!! $tutorial->tut_detail !!}
                    @else
                        <p>{{ $tutorial->tut_seo_detail }}</p>
                    @endif

                    @if(!empty($tutorial->tut_keyword))
                        @php
                            $tags = explode(",",$tutorial->tut_keyword);
                        @endphp
                        <div class="lux8-td-tags">
                            @foreach ( $tags as $tag )
                                <a href="{{ route('fronend.tutorial.searchtag',$tag) }}" rel="tag">{{ $tag }}</a>
                            @endforeach
                        </div>
                    @endif
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
@if(!empty($tutorial) && !empty($tutorial->tut_video))
<script src="https://www.youtube.com/iframe_api"></script>
<script>
var lux8Player;
var lux8TutorialId = {{ $tutorial->id }};
var lux8SaveTimer = null;

function onYouTubeIframeAPIReady() {
    lux8Player = new YT.Player('lux8TutIframe', {
        events: {
            'onReady': function () {
                if (lux8SaveTimer) clearInterval(lux8SaveTimer);
                lux8SaveTimer = setInterval(lux8SaveProgress, 10000); // เซฟทุก 10 วิ
            }
        }
    });
}

function lux8SaveProgress() {
    if (!lux8Player || typeof lux8Player.getCurrentTime !== 'function') return;
    var watched = Math.floor(lux8Player.getCurrentTime());
    var duration = Math.floor(lux8Player.getDuration());
    if (!duration) return;

    fetch('{{ route("fronend.tutorial.progress.save") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            tutorialId: lux8TutorialId,
            watched_seconds: watched,
            duration_seconds: duration
        })
    })
    .then(function (res) { return res.json(); })
    .then(function (data) {
        if (data.status === 'ok') {
            document.getElementById('lux8ProgressBar').style.width = data.percent + '%';
            document.getElementById('lux8ProgressText').textContent = 'ดูแล้ว ' + data.percent + '%';
        }
    })
    .catch(function () {});
}

window.addEventListener('beforeunload', function () {
    if (lux8SaveTimer) lux8SaveProgress();
});
</script>
@endif
@endsection