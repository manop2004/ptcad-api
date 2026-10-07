@extends('layouts.temp_user')

@section('title'){{ $og_title }} |@endsection
@section('og_site_name'){{ $og_site_name }}@endsection
@section('og_keywords'){{ $og_keywords }}@endsection
@section('og_title'){{ $og_title }}@endsection
@section('og_description'){{ $og_description }}@endsection
@section('og_url'){{ $og_url }}@endsection
@section('og_image'){{ $og_image }}@endsection

@section('css')
@php
    $countB = App\Models\TbBanner::select('banner_show')->where('banner_show',1)->count();
@endphp
@if($countB == 1)
<style>
    .flex-direction-nav{
        display: none !important;
    }
</style>
@endif

<style>
    /* @media only screen and (min-width: 1500px){
        .container {
            width: 100%;
            padding-left: 10rem;
            padding-right: 10rem;
        }
    } */
</style>
@endsection


@section('content')

@include('layouts.fontend.slider')

<section id="content">
    <div class="content-wrap">
        @if(count($brands) != 0)
            <div id="content-brand" class="container bottommargin-sm clearfix">
                <div class="slider-desktop">
                    <div class="grid-brand">
                        @foreach ($brands as $brand)
                            <a class="border-brand" href="{{ route('fronend.brand',$brand->brand_permalink) }}@if(!empty($_GET['ref']))?ref={{ $_GET['ref'] }}@endif"><img width="187" height="60" class="full-width lazyload"  src="{{asset('storage/brand/'.$brand->brand_img) }}" alt="{{ $brand->brand_img }}"></a>
                        @endforeach
                    </div>
                </div>
                <div class="slider-mobile">
                    <div id="oc-clients-full" class="owl-carousel owl-carousel-full image-carousel carousel-widget" data-margin="0" data-loop="false" data-nav="false" data-autoplay="3000" data-pagi="false"data-items-xxs="2" data-items-xs="3" data-items-sm="5" data-items-md="5" data-items-lg="6">
                        @foreach ($brands as $brand_m)
                        <div class="oc-item border-brand">
                            <a href="{{ route('fronend.brand',$brand_m->brand_permalink) }}@if(!empty($_GET['ref']))?ref={{ $_GET['ref'] }}@endif"><img width="122" height="39" class="full-width lazyload"  src="{{asset('storage/brand/'.$brand_m->brand_img) }}" alt="{{ $brand_m->brand_img }}"></a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
        @if(count($recommendPromotion) != 0)
            <div id="content-recommend-category" class="container bottommargin-sm clearfix">
                <div id="oc-clients-full" class="owl-carousel owl-carousel-full image-carousel carousel-widget" data-margin="5" data-loop="false" data-nav="false" data-pagi="false" data-items-xxs="2" data-items-xs="2" data-items-sm="3" data-items-md="3" data-items-lg="3">
                    @foreach ($recommendPromotion as $r_promotion)
                    <div class="oc-item">
                        @if(!empty($r_promotion->recommend_link))
                            <a href="{{ $r_promotion->recommend_link }}" >
                        @endif
                            <img width="500" height="268" class="full-width lazyload"  src="{{asset('storage/recommend/'.$r_promotion->recommend_thumb) }}" alt="{{ $r_promotion->recommend_note }}">
                        @if(!empty($r_promotion->recommend_link))
                        </a>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        @endif
        @if(count($recommendProduct) != 0)
            <div id="content-recommend-product" class="clearfix">
                <div class="tabs tabs-bb clearfix hidden-sm hidden-xs" >
                    <div class="container">
                        <ul class="tab-nav clearfix  ">
                            @foreach ( $recommendProduct as $r_product)
                                <li><a href="#tabs-{{ $r_product['id']}}" class="f-30">{{ $r_product['name']}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="tab-container container">
                        @foreach ( $recommendProduct as $rp_product)
                            <div class="tab-content clearfix" id="tabs-{{ $rp_product['id']}}">
                                <div class="grid-product-list product-recommend">
                                    @foreach ($rp_product['product'] as $prl_product)
                                        <div class="recommend_prooduct co-f7f7f7 blinking clearfix">
                                            <div class="product_img">
                                                <a href="{{ route('fronend.product.content',$prl_product['pro_permalink']) }}@if(!empty($_GET['ref']))?ref={{ $_GET['ref'] }}@endif">
                                                    <img width="310" height="310" class="lazyload"  src="{{ $prl_product['cover'] }}" alt="{{ $prl_product['pro_name'] }}" >
                                                </a>
                                            </div>
                                            <div class="product_title">
                                                <a href="{{ route('fronend.product.content',$prl_product['pro_permalink']) }}@if(!empty($_GET['ref']))?ref={{ $_GET['ref'] }}@endif">{{ shortStr($prl_product['pro_name'],60) }}</a>
                                            </div>
                                            <div class="product_price">{!! $prl_product['price'] !!}</div>
                                            <div class="product_title_sub">ราคาไม่รวม VAT</div>
                                            <div class="product_button">
                                                <a href="{{ route('fronend.product.content',$prl_product['pro_permalink']) }}@if(!empty($_GET['ref']))?ref={{ $_GET['ref'] }}@endif">
                                                    <button id="b-readmore" class="button-readmore choose" ></button>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="container hidden-lg hidden-md bottommargin-sm ">
                    <div class="accordion nobottommargin clearfix" data-state="open" >
                        @foreach ( $recommendProduct as $rm_product)
                            <div class="acctitle">{{ $rm_product['name'] }}</div>
                            <div class="acc_content clearfix">
                                <div class="slider-mobile">
                                    <div id="oc-recommend-product-full" class="owl-carousel owl-carousel-full image-carousel carousel-widget " data-margin="5" data-loop="false" data-pagi="true" data-autoplay="7000" data-nav="true" data-items-xxs="2" data-items-xs="2" data-items-sm="3" data-items-md="3" data-items-lg="4">
                                        @foreach ($rm_product['product'] as $prm_product)
                                            <div class="oc-item border-brand oc-product-recommend">
                                                <div id="product_b" class="co-f7f7f7 blinking clearfix">
                                                    <div class="product_img">
                                                        <a href="{{ route('fronend.product.content',$prm_product['pro_permalink']) }}@if(!empty($_GET['ref']))?ref={{ $_GET['ref'] }}@endif">
                                                            <img width="172" height="172" class="lazyload"  src="{{ $prm_product['cover'] }}" alt="{{ $prm_product['pro_name'] }}" >
                                                        </a>
                                                    </div>
                                                    <div class="product_title">
                                                        <a href="{{ route('fronend.product.content',$prm_product['pro_permalink']) }}@if(!empty($_GET['ref']))?ref={{ $_GET['ref'] }}@endif">{{ shortStr($prm_product['pro_name'],60) }}</a>
                                                    </div>
                                                    <div class="product_price">{!! $prm_product['price'] !!}</div>
                                                    <div class="product_title_sub">ราคาไม่รวม VAT</div>
                                                    <div class="product_button">
                                                        <a href="{{ route('fronend.product.content',$prm_product['pro_permalink']) }}@if(!empty($_GET['ref']))?ref={{ $_GET['ref'] }}@endif">
                                                            <button id="b-readmore" class="button-readmore choose" ></button>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
        @if(count($recommendProductAndCategory) != 0)
            <div id="recommend-product-category" class="container bottommargin-sm clearfix">
                @foreach ($recommendProductAndCategory as $key=> $product_and_category )
                    @if (!empty($product_and_category['name']))
                        <h1>{{ $product_and_category['name'] }}</h1>
                    @endif
                    <div class="row bottommargin-sm">
                        <div class="col-lg-3 bg-transparent hidden-md hidden-sm hidden-xs">
                            @if (!empty($product_and_category['thumb']))
                                <img width="262" height="425" class="thumb lazyload"  src="{{ $product_and_category['thumb'] }}" alt="{{ $product_and_category['thumb'] }}" >
                            @endif
                        </div>
                        <div class="col-lg-9 col-12 ">
                            @if(count($product_and_category['product']) != 0)
                                <div id="" class="owl-carousel owl-carousel-full image-carousel carousel-widget" data-margin="5" data-loop="false" data-pagi="true" data-autoplay="7000" data-nav="true" data-items-xxs="2" data-items-xs="2" data-items-sm="3" data-items-md="3" data-items-lg="3"  >
                                    @foreach ($product_and_category['product'] as $product_and_category_list )
                                        <div class="oc-item">
                                            <div id="product_b" class="clearfix co-f7f7f7 blinking">
                                                <div class="product_img">
                                                    <a href="{{ route('fronend.product.content',$product_and_category_list['pro_permalink']) }}@if(!empty($_GET['ref']))?ref={{ $_GET['ref'] }}@endif">
                                                        <img width="180" height="180" class="lazyload"  src="{{ $product_and_category_list['cover'] }}" alt="{{ $product_and_category_list['pro_name'] }}" >
                                                    </a>
                                                </div>
                                                <div class="product_title">
                                                    <a href="{{ route('fronend.product.content',$product_and_category_list['pro_permalink']) }}@if(!empty($_GET['ref']))?ref={{ $_GET['ref'] }}@endif">{{ shortStr($product_and_category_list['pro_name'],60) }}</a>
                                                </div>
                                                <div class="product_price">{!! $product_and_category_list['price'] !!}</div>
                                                <div class="product_title_sub">ราคาไม่รวม VAT</div>
                                                <div class="product_button">
                                                    <a href="{{ route('fronend.product.content',$product_and_category_list['pro_permalink']) }}@if(!empty($_GET['ref']))?ref={{ $_GET['ref'] }}@endif">
                                                        <button id="b-readmore" class="button-readmore choose" ></button>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
        @if(count($articles) != 0)
            <div id="content-article" class="container clearfix bottommargin-sm ">
                <h1 class="nobottommargin relative">ข่าวสารด้านซอฟต์แวร์และรีวิว
                    <a href="{{ route('fronend.article.main') }}@if(!empty($_GET['ref']))?ref={{ $_GET['ref'] }}@endif" class="link-view-all"><small class="f-20">ดูทั้งหมด ></small></a>
                </h1>
                <div class="line notopmargin bottommargin-sm"></div>
                <div id="oc-clients-full" class="owl-carousel owl-carousel-full image-carousel carousel-widget" data-margin="20" data-loop="false" data-nav="false" data-pagi="false"data-items-xxs="1" data-items-xs="2" data-items-sm="2" data-items-md="4" data-items-lg="4">
                    @foreach ($articles as $article_m)
                    <div class="oc-item block-article">
                        <a href="{{ route('fronend.article.content',$article_m->art_parmalink) }}@if(!empty($_GET['ref']))?ref={{ $_GET['ref'] }}@endif" >
                            <div class="art-img">
                                @if(!empty($article_m->art_thumb))
                                <img width="370" height="186" class="border full-width lazyload"  src="{{asset('storage/article/'.$article_m->art_thumb) }}" alt="{{ $article_m->art_thumb }}">
                                @else
                                <img width="370" height="186" class="border full-width lazyload"  src="{{asset('images/default-img/no-image-available-article.webp') }}" alt="{{ $article_m->art_thumb }}">
                                @endif
                            </div>
                            <div class="art-title co-back"><small>{{$article_m->art_name}}</small></div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>
@include('layouts.fontend.service')
@endsection

