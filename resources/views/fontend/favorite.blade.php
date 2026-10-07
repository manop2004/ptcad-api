@extends('layouts.temp_user')

@section('title'){{ $og_title }} |@endsection
@section('og_site_name'){{ $og_site_name }}@endsection
@section('og_keywords'){{ $og_keywords }}@endsection
@section('og_title'){{ $og_title }}@endsection
@section('og_description'){{ $og_description }}@endsection
@section('og_url'){{ $og_url }}@endsection
@section('og_image'){{ $og_image }}@endsection

@section('css')

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
            <div id="favorites-show" class="topmargin-lg bottommargin-lg hidden" >
                <div class="table-responsive">
                    <table class="table cart favorites">
                        <thead>
                            <tr>
                                <th class="cart-product-remove">&nbsp;</th>
                                <th class="cart-product-thumbnail">&nbsp;</th>
                                <th class="cart-product-name">สินค้า</th>
                                <th class="cart-product-subtotal text-right">ราคา</th>
                            </tr>
                        </thead>
                        <tbody id="favorites_table"></tbody>
                    </table>
                </div>
            </div>
            <div id="favorites-normal" class="topmargin-lg bottommargin-lg hidden" >
                <div class="center">
                    <h3>ยังไม่มีรายการโปรด</h3>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

