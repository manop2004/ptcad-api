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


</style>
@endsection

@section('content')
<section id="content">
    <div class="content-wrap">
        <div class="container">
            <div class="nav-page-grid-two topmargin-sm">
                <div class="page-border-right bottommargin-sm" id="page-menu">
                    <ul class="page-menu">
                        @foreach ($page_recommend as $recommend)
                            <li>
                                <a class="@if($recommend->page_parmalink == $permalink){{ "curent" }}@endif" href="@if($recommend->pages_type == 1){{ route('fronend.page.content',$recommend->page_parmalink) }}@else{{$recommend->page_parmalink}}@endif">
                                    {{ $recommend->pages_name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div>
                    @if(!empty($page))
                        <div class="entry clearfix">

                            <div class="entry-content notopmargin">

                                {!! $page->page_detail !!}

                            </div>
                        </div>
                    @else
                        <div class="topmargin-lg bottommargin-lg center">
                            <h3>ไม่พบข้อมูล</h3>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('js')
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/th_TH/sdk.js#xfbml=1&version=v12.0&appId=1190234624660031&autoLogAppEvents=1" nonce="h8yjg5hD"></script>
<script src="https://d.line-scdn.net/r/web/social-plugin/js/thirdparty/loader.min.js" async="async" defer="defer"></script>
@endsection
