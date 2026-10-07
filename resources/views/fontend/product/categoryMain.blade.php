@extends('layouts.temp_user')

@section('title'){{ $og_title }} |@endsection
@section('og_site_name'){{ $og_site_name }}@endsection
@section('og_keywords'){{ $og_keywords }}@endsection
@section('og_title'){{ $og_title }}@endsection
@section('og_description'){{ $og_description }}@endsection
@section('og_url'){{ $og_url }}@endsection
@section('og_image'){{ $og_image }}@endsection

@section('css')

<style>

</style>

@endsection

@section('content')

<div class="pd-section">
	@if (!empty($breadcrumb))
	<div class="txt-path-page">
		@foreach ($breadcrumb as $index => $item)
			@if($index !== count($breadcrumb) -1 )
				<a class="mg-r-txtpage" href="{{ $item['route'] }}">{{ $item['name'] }} / </a>
			@else
				<span class="mg-r-txtpage">{{ $item['name'] }}</span>
			@endif
		@endforeach
	</div>
	@endif

    <div class="section-content">
		<div class="section-left">
			<!-- filter2 -->
			<div class="box-filter">
				<div class="head-filter">
					<div class="txt-fileter">หมวดหมู่สินค้า</div>
					<!--div class="txt-reset">รีเซ็ต</div-->
				</div>
			
				<div class="category-sidebar">
				@php
					$category = App\Models\TbCategory::where('category_show',1)->orderBy('category_sort','desc')->get();
				@endphp							
				@foreach ($category as $cat)
					@php
						$subcategory = App\Models\TbCategorySub::where('category_id', $cat->id)->where('categorysub_show',1)->orderBy('categorysub_sort','desc')->get();
						$productCount = App\Models\TbProduct::where('pro_catId', $cat->id)->where('pro_show',1)->count();
					@endphp

					<div class="category-panel">
						@if($subcategory->count())
						<div class="category-header has-sub" onclick="toggleCategory(this)">
							<span>{{ $cat->category_name }}</span>
							<i class="icon-toggle"></i>
						</div>
						<div class="category-sub shown-by-default">
							<ul>
							@foreach ($subcategory as $sub)
								@php
									$subCount = App\Models\TbProduct::where('pro_catsubId', $sub->id)->where('pro_show',1)->count();
								@endphp
							<li>
								<a href="{{ route('fronend.category', $sub->categorysub_permalink) }}@if(!empty($_GET['ref']))?ref={{ $_GET['ref'] }}@endif">
								{{ $sub->categorysub_name }} 
								</a>
							</li>
							@endforeach
							</ul>
						</div>
						@else
						<div class="category-header">
							<a href="{{ route('fronend.category', $cat->category_permalink) }}@if(!empty($_GET['ref']))?ref={{ $_GET['ref'] }}@endif">
								{{ $cat->category_name }}
							</a>
						</div>
						@endif
					</div>
				@endforeach
				</div>

			</div>
		</div>
		<div class="section-right">
			<div class="box-discription">
				<div class="box-discription-h">
					<img class="picicon-discription" src="/assets/fontend/hax_theme/images/icon-3d.webp">
					<div class="txt-boxdiscription">{{ $page_name }}</div>
				</div>
				<div class="content-discription">
					<div class="mg-bt-content-discription">
						@if(!empty($page_detail))
						<div class="txt-black-h">{{ $page_name }}</div>
						<div class="txt-gray-title">{{ $page_detail }}</div>
						@endif
					</div>
				</div>
			</div>
			
			<div class="tab-list-product">
				<div class="df-tablistproduct">
				@php
					$category = App\Models\TbCategory::where('category_show',1)->orderBy('category_sort','desc')->get();
				@endphp							
				@foreach ($category as $index => $cat)
					<a class="btn-home-select w-tablistpd-1 @if($index==0) active-tapselect @endif" href="{{ route('fronend.category',$cat['category_permalink']) }}@if(!empty($_GET['ref']))?ref={{ $_GET['ref'] }}@endif">
						{{ $cat->category_name }}
					</a>
				@endforeach
				</div>
			</div>
		
			@if(count($arr_product) != 0)
				@foreach ($arr_product as $data_product)
					@if(!empty($data_product['item']))
			<div id="taplistproduct-data-1" style=" width: 100%;">
				<!-- 1 -->
				<div class="boxbenner-pd">
					<div class="text-overlay-banner">{{ $data_product['categorysub_name'] }}</div>
					<img class="sizebannerproduct" src="/assets/fontend/hax_theme/images/banner-cat.webp">
				</div>
				<div class="dg-listpd category">
					@foreach ($data_product['item'] as $product_item)
					
					<div class="boxproduct">
						<a class="h-pic-product" href="{{ route('fronend.product.content',$product_item['permalink']) }}@if(!empty($_GET['ref']))?ref={{ $_GET['ref'] }}@endif">
							<img class="size-product" src="{{ $product_item['pictureName'] }}" alt="{{ $product_item['name'] }}">
						</a>
						@if($product_item['brand'])
						<a class="text-green-product" href="{{ route('fronend.brand',$product_item['brand_permalink']) }}@if(!empty($_GET['ref']))?ref={{ $_GET['ref'] }}@endif">
							{{ $product_item['brand'] }}
						</a>
						@else
						<a class="text-green-product" href="#">
							No Brand
						</a>
						@endif
						<div class="name-product">
							{{ $product_item['name'] }}
						</div>
						<!--div class="priceold-product">
							{!! $product_item['price'] !!}
						</div-->
						<br>
						<div class="price-group-bottom">
							<div class="df-price">
								<div class="price-product">{!! $product_item['price'] !!}</div>
								<!--div class="price-discount">
									-฿1,500
								</div-->
							</div>
							<div class="discript-product">*ราคาไม่รวม VAT</div>
							<a class="btn-buy" href="{{ route('fronend.product.content',$product_item['permalink']) }}@if(!empty($_GET['ref']))?ref={{ $_GET['ref'] }}@endif">
								ซื้อเลย
							</a>
						</div>
					</div>
					@endforeach
				</div>
				
			</div>
				@endif
			@endforeach
		@endif

		</div>

    </div>
</div>

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

