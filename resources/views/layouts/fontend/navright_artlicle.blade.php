<div class="widget clearfix">
    <form action="{{ route('fronend.article.search') }}">
        @csrf
        <input name="search_artlicle" id="search_artlicle" placeholder="ค้นหาบทความ" class="form-search-content" />
    </form>
</div>
@if(!empty($article_randoms))
<div class="widget clearfix">
    <h4>เลือกหัวข้อที่คุณสนใจ</h4>

    <div id="popular-post-list-sidebar">

        @foreach ($article_randoms as $randoms)
        <div class="spost clearfix">
            <div class="entry-image">
                @if (!empty($randoms->art_thumb))
                    <a href="{{ route('fronend.article.content',$randoms->art_parmalink) }}" class="nobg">
                        <img width="100" height="100" class="img-circle lazyload cata-img border"  src="{{ asset('storage/article/' . $randoms->art_thumb) }}" alt="{{ $randoms->art_name }}">
                    </a>
                @else
                    <img width="100" height="100" class="img-circle lazyload cata-img border"  src="{{ asset('images/default-img/no-image-available-article.webp') }}" alt="{{ $randoms->art_name }}">
                @endif

            </div>
            <div class="entry-c">
                <div class="entry-title">
                    <h4><a href="{{ route('fronend.article.content',$randoms->art_parmalink) }}">{{ $randoms->art_name}}</a></h4>
                </div>
            </div>
        </div>
        @endforeach

    </div>
</div>
@endif
