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
            
            <div class="row bottommargin-sm">
                <div class="col-lg-3 hidden-md hidden-sm hidden-xs">
				
					@if (!empty($breadcrumb))
						<section id="page-title" class="page-title-mini page-title-right bottommargin-sm">
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
					
                    <div class="border me-ca-b">
                        <div class="menu-primery-page">
                            <h3>สินค้าทั้งหมด ({{ number_format(App\Models\TbProduct::where('pro_show',1)->count()) }})</h3>
                        </div>
                        <div class="panel-group nobottommargin" id="accordion">
							<div class="panel panel-category">
								<div class="panel-heading">
									<a href="/sale" aria-expanded="false" class="collapsed co-red">
										<strong>สินค้าลดราคา</strong>
									</a>
								</div>
							</div>
                            @php
                                $category = App\Models\TbCategory::where('category_show',1)->orderBy('category_sort','desc')->get();
                            @endphp
                            @foreach ($category as $index => $cat)
                                @php
                                    $subcategory = App\Models\TbCategorySub::where('category_id', $cat['id'])->where('categorysub_show','1')->orderby('categorysub_sort','desc')->get();
                                @endphp
                                @if(count($subcategory) != 0)
                                    <div class="panel panel-category">
                                        <div class="panel-heading limi-ic">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#c-{{$cat->id}}" aria-expanded="false" class="collapsed c-4d ">
                                                {{ $cat['category_name'] }} <small class="c-4d">({{ App\Models\TbProduct::where('pro_catId', $cat['id'])->where('pro_show',1)->count()}})</small>
                                            </a>
                                            <i class="icon-angle-down"></i>
                                        </div>
                                        <div id="c-{{$cat->id}}" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                                            <div class="panel-body">
                                                <ul class="nomargin">
                                                    @foreach ($subcategory as $index2 => $subcat)
                                                        @if($subcat['category_id'] == $cat['id'])
                                                        <li >
                                                            <a href="{{ route('fronend.category',$subcat['categorysub_permalink']) }}@if(!empty($_GET['ref']))?ref={{ $_GET['ref'] }}@endif" class="c-4d">
                                                                <i class="icon-caret-right"></i>  {{ $subcat['categorysub_name'] }} <small class="c-4d">({{ $countPro = App\Models\TbProduct::where('pro_catsubId', $subcat['id'])->where('pro_show',1)->count() }})</small>
                                                            </a>
                                                        </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="panel panel-category">
                                        <div class="panel-heading">
                                            <a  href="{{ route('fronend.category',$cat['category_permalink']) }}@if(!empty($_GET['ref']))?ref={{ $_GET['ref'] }}@endif" aria-expanded="false" class="collapsed c-4d">
                                                {{ $cat['category_name'] }} <small class="c-4d">({{ App\Models\TbProduct::where('pro_catId', $cat['id'])->where('pro_show',1)->count() }})</small>
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                    </div>
                </div>
				
                <div class="col-lg-9 col-12">
				
					@include('layouts.fontend.slider_category')
				
                    @if(!empty($page_detail))
                        <h1 class="page_name nomargin text-success">{{ $page_name }}</h1>
                        <small>{{ $page_detail }}</small>
                    @else
                        <h1 class="page_name text-success">{{ $page_name }}</h1>
                    @endif
                    
					@if(count($arr_product) != 0)
						@foreach ($arr_product as $data_product)
							@if(!empty($data_product['item']))
								<div class="row bottommargin-sm topmargin-sm">
									<div class="col-lg-6 col-xs-6"><h2 class="badge bg-red"><strong>{{ $data_product['categorysub_name'] }}</strong></h2></div>
									<div class="col-lg-6 col-xs-6 text-right"><a href="{{ route('fronend.category',$data_product['categorysub_permalink']) }}@if(!empty($_GET['ref']))?ref={{ $_GET['ref'] }}@endif">ดูทั้งหมด</a></div>
									<div class="col-lg-12 col-xs-12">
										
										<div id="recommend-product-category">
											<div id="" class="owl-carousel owl-carousel-full image-carousel carousel-widget" data-margin="5" data-loop="false" data-pagi="false" data-autoplay="5000" data-nav="true" data-items-xxs="2" data-items-xs="2" data-items-sm="3" data-items-md="3" data-items-lg="3" >
												@foreach ($data_product['item'] as $product_item)
													<div class="oc-item">
														<div id="product_b" class="clearfix co-f7f7f7">
															<div class="product_img">
																<a href="{{ route('fronend.product.content',$product_item['permalink']) }}@if(!empty($_GET['ref']))?ref={{ $_GET['ref'] }}@endif">
																	<img width="180" height="180" class="lazyload"  src="{{ $product_item['pictureName'] }}" alt="{{ $product_item['name'] }}" >
																</a>
															</div>
															<div class="product_title">
																<a href="{{ route('fronend.product.content',$product_item['permalink']) }}@if(!empty($_GET['ref']))?ref={{ $_GET['ref'] }}@endif">{{ shortStr($product_item['name'],60) }}</a>
															</div>
															<div class="product_price">{!! $product_item['price'] !!}</div>
															<div class="product_title_sub">ราคาไม่รวม VAT</div>
															<div class="product_button">
																<input type="hidden" id="ref" name="ref" @if (!empty($_GET['ref'])) value="{{ $_GET['ref'] }}" @else value="" @endif>
																@if ($product_item['priceStatus'] == 1)
																	<a href="{{ route('fronend.quotation',['productId' => $product_item['id']]) }}">
																		<button id="b-quotation" class="button-quotation"></button>
																	</a>
																@else
																	@if ($product_item['option'] == 1)
																		<button id="b-cart" class="button-cart choose b-cart-one" data-id="{{ $product_item['id'] }}" onClick="gtag_event('add_to_cart', this);"></button>
																		<input type="hidden" id="pro_name_{{ $product_item['id'] }}" value="{{ $product_item['name'] }}">
																		<input type="hidden" id="pro_price_{{ $product_item['id'] }}" value="{{ number_format(preg_replace('/[^0-9.]/', '', $product_item['price']), 0, '', '') }}">
																		<input type="hidden" id="pro_sku_{{ $product_item['id'] }}" value="{{ $product_item['sku'] }}">
																		<input type="hidden" id="pro_brand_{{ $product_item['id'] }}" value="{{ $product_item['brand'] }}">
																		
																	@else
																		<a href="{{ route('fronend.product.content',$product_item['permalink']) }}@if(!empty($_GET['ref']))?ref={{ $_GET['ref'] }}@endif">
																			<button id="b-cart" class="button-model choose"></button>
																		</a>
																	@endif
																@endif
															</div>
														</div>
													</div>
												@endforeach
											</div>
										</div>
									</div>
								</div>
							@endif
						@endforeach
					@endif
                </div>
            </div>
        </div>
    </div>
    @include('layouts.fontend.service')
</section>
<script>
	function gtag_event(eventname, ele){
		const pid = $(ele).attr("data-id");
		const pro_sku = $("#pro_sku_"+pid).val();
		const pro_name = $("#pro_name_"+pid).val();
		const pro_brand = $("#pro_brand_"+pid).val();
		const pro_price = $("#pro_price_"+pid).val();
		
		gtag("event", eventname, {
			currency: "THB",
			value: pro_price,
			items: [
				{
					item_id: pro_sku,
					item_name: pro_name,
					item_brand: pro_brand,
					price: pro_price,
					quantity: 1
				}
			]
		});
		
		fbq('track', 'AddToCart', {
			contents: [{id:pro_sku,quantity:1,brand:pro_brand,name:pro_name,item_price:pro_price}],
			content_type: "product",
			content_category: pro_brand,
			content_name: pro_name,
			currency: "THB",
			value: pro_price
		});
		
	}
		
	
</script>
@endsection

