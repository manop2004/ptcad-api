@extends('layouts.temp_user')

@section('title'){{ $og_title }} |@endsection
@section('og_site_name'){{ $og_site_name }}@endsection
@section('og_keywords'){{ $og_keywords }}@endsection
@section('og_title'){{ $og_title }}@endsection
@section('og_description'){{ $og_description }}@endsection
@section('og_url'){{ $og_url }}@endsection
@section('og_image'){{ $og_image }}@endsection

@section('css')
<link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendor/select2-bootstrap4-theme/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/fontend/css/components/radio-checkbox.css') }}" type="text/css" />
<style>
    .radio-style-2-label{
        margin: 0px
    }
</style>
@endsection

@section('content')

<section id="content">
    <div class="content-wrap">
        <div class="container">
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
			
			@if ($save_status == 1)
			
           <div class="container-xs topmargin-sm bottommargin-sm text-center">
                <img class="icon-succeed" src="{{ asset('icons/succeed.png') }}" />
                <h4 class="topmargin-sm">ขอบคุณสำหรับการให้คะแนน</h4>
                <h3 class="topmargin-sm">ทางเราจะนำข้อมูลไปปรับปรุงและพัฒนาการให้บริการต่อไป</h3>
            </div>
			@else
			<div class="container-xs topmargin-sm bottommargin-sm text-center">
                <img class="icon-succeed" src="{{ asset('icons/fail.png') }}" />
                <h4 class="topmargin-sm">เกิดข้อผิดพลาด</h4>
                <h3 class="topmargin-sm">หมดเวลาการให้คะแนนแล้วค่ะ</h3>
            </div>
			
			@endif
        </div>
    </div>
</section>

@endsection

@section('js')
 <script src="{{ asset('vendor/select2/select2.min.js') }}"></script>
 <script src="{{ asset('vendor/select2-bootstrap4-theme/docs/script.js') }}"></script>
 @endsection
