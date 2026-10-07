@extends('layouts.temp_user')

@section('og_site_name'){{ $og_site_name }}@endsection
@section('og_keywords'){{ $og_keywords }}@endsection
@section('og_title'){{ $og_title }}@endsection
@section('title'){{ $og_title }} |@endsection
@section('og_description'){{ $og_description }}@endsection
@section('og_url'){{ $og_url }}@endsection
@section('og_image'){{ $og_image }}@endsection

@section('css')

@endsection

@section('content')

<section id="content">
    <div class="content-wrap">
        <div class="container">
           {{-- [เพิ่มใหม่] Hero Banner สีม่วง แสดงชื่อหน้าตัวใหญ่ --}}
@if(!empty($page->pages_name))
<div style="background: #6C3CE9; padding: 60px 20px; text-align: center;">
    <h1 style="color: #ffffff; font-size: 48px; font-weight: 800; margin: 0;">{{ $page->pages_name }}</h1>
</div>
@endif

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
</section>
@endsection

@section('js')

@endsection
