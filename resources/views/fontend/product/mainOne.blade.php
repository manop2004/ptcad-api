@extends('layouts.temp_user')

@section('og_site_name'){{ $og_site_name }}@endsection
@section('og_keywords'){{ $og_keywords }}@endsection
@section('og_title'){{ $og_title }}@endsection
@section('title'){{ $og_title }} |@endsection
@section('og_description'){{ $og_description }}@endsection
@section('og_url'){{ $og_url }}@endsection
@section('og_image'){{ $og_image }}@endsection

@section('og:id')<meta property="product:id" content="{{ $data['pro_sku'] }}">@endsection
@section('product:brand')<meta property="product:brand" content="{{ $data['pro_brand'] }}">@endsection
@section('product:availability')<meta property="product:availability" content="{{ $data['availability'] }}">@endsection
@section('product:condition')<meta property="product:condition" content="new">@endsection
@section('product:price:amount')<meta property="product:price:amount" content="{{ $data['og_price'] }}">@endsection
@section('product:price:currency')<meta property="product:price:currency" content="THB">@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('assets/fontend/hax_theme/product.css?v=2') }}" type="text/css" />
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Noto+Sans+Thai:wght@400;500;600;700;800&display=swap');

/* ===== PTCAD theme overlay for product detail page ===== */
/* Scoped to .pt-pd-wrap; targets EXISTING class names only — nothing renamed, nothing moved */
.pt-pd-wrap{
  --navy:#12358f; --blue:#1765ff; --ink:#0b1f4d; --muted:#667085; --line:#e6edf8;
  --soft:#f6f9ff; --green:#20b26b; --shadow:0 18px 50px rgba(20,53,143,.10);
  font-family:'Poppins','Noto Sans Thai',system-ui,sans-serif;
  color:var(--ink);
  max-width:1400px;margin:24px auto;padding:0 24px;
}
.pt-pd-wrap .cover-contentpddetail{background:transparent}

/* Gallery thumbs + main image */
.pt-pd-wrap .cardimg-small{border:1px solid var(--line);border-radius:14px;background:#fff;overflow:hidden}
.pt-pd-wrap .cardimg-small-active,.pt-pd-wrap .cardimg-small.cardimg-small-active{border:2px solid var(--blue)}
.pt-pd-wrap .sub-contentleft0003{border:1px solid var(--line);border-radius:24px;background:linear-gradient(135deg,#fff,#eef7ff);overflow:hidden;box-shadow:var(--shadow)}

/* Brand / name / price block */
.pt-pd-wrap .sub-contentleft000401{color:var(--blue);font-weight:800;font-size:13px;text-transform:uppercase;letter-spacing:.3px}
.pt-pd-wrap .sub-contentleft000403{font-size:30px;font-weight:800;color:var(--navy);letter-spacing:-.6px}
.pt-pd-wrap .sub-contentleft000407{color:var(--muted);font-size:13px}
.pt-pd-wrap .sub-contentleft000408{font-size:32px;font-weight:800;color:var(--blue)}
.pt-pd-wrap .btn_none_vat{background:var(--soft);color:var(--muted);border-radius:999px;padding:4px 12px;font-size:12px;display:inline-block}
.pt-pd-wrap .btn_status_p{border-radius:999px;padding:4px 12px;font-size:12px;font-weight:700;color:#fff;display:inline-block}

/* Description / installment / other boxes */
.pt-pd-wrap .coverboxwithline,.pt-pd-wrap .coverboxwithhountline{border-top:1px solid var(--line);padding:16px 0}
.pt-pd-wrap .txt-hdboxwithline{font-weight:700;color:var(--navy);font-size:14px;margin-bottom:6px}
.pt-pd-wrap .txt-subboxnoline{color:var(--muted);font-size:14px;line-height:1.7}
.pt-pd-wrap .txt-subboxwithline{color:var(--blue);font-weight:700;font-size:13px;margin-top:6px;cursor:pointer}

/* Right-side buy box */
.pt-pd-wrap .covercard-rightwh{background:#fff;border:1px solid var(--line);border-radius:22px;padding:22px;box-shadow:var(--shadow)}
.pt-pd-wrap .sub-contentleft0006{font-weight:800;color:var(--navy);font-size:16px;margin-bottom:10px}
.pt-pd-wrap .sub-contentleft000701{color:var(--muted);font-size:13px;font-weight:700;margin-bottom:8px}
.pt-pd-wrap .quantity{border:1px solid var(--line);border-radius:12px;overflow:hidden;display:inline-flex;align-items:center;background:#fff}
.pt-pd-wrap .quantity .qty{border:none;text-align:center;width:48px;font-weight:800}
.pt-pd-wrap .minus,.pt-pd-wrap .plus{background:#fff;border:none;width:38px;height:38px}
.pt-pd-wrap .sub-contentleft000801,.pt-pd-wrap .b-cart-one{
  background:linear-gradient(135deg,var(--blue),#0d57df);color:#fff!important;border:none;border-radius:12px;
  font-weight:800;box-shadow:0 12px 24px rgba(23,101,255,.24);
}
.pt-pd-wrap .sub-contentleft000803{color:#fff!important;font-weight:800}
.pt-pd-wrap .sub-contentleft000804{
  border:1.5px solid var(--blue);color:var(--blue);border-radius:12px;font-weight:800;text-align:center;
  background:#fff;cursor:pointer;
}

/* Tabs (รายละเอียด/สเปก/ฟีเจอร์/รีวิว) */
.pt-pd-wrap .coverdex3box{display:flex;gap:10px;flex-wrap:wrap;border-bottom:1px solid var(--line);margin-bottom:24px}
.pt-pd-wrap .desbox00{padding:12px 18px;color:var(--muted);font-weight:700;font-size:14px;cursor:pointer;border-bottom:3px solid transparent}
.pt-pd-wrap .desbox00.txtgreenactive{color:var(--blue);border-bottom-color:var(--blue)}
.pt-pd-wrap .destxtbox00{font-size:20px;font-weight:800;color:var(--navy);margin-bottom:14px}
.pt-pd-wrap .des-pddetail01{background:#fff;border:1px solid var(--line);border-radius:22px;padding:26px;box-shadow:var(--shadow)}

/* New: side-by-side layout for description + info card (brand-new class, no legacy CSS collision) */
.pt-pd-tab-grid{display:flex;gap:24px;align-items:flex-start;flex-wrap:wrap;width:100%}
.pt-pd-tab-grid .des-pddetail01{flex:1 1 480px !important;width:auto !important;min-width:0 !important;max-width:100%}
.pt-pd-info-card{flex:0 0 280px;background:#fff;border:1px solid var(--line);border-radius:22px;padding:24px;box-shadow:var(--shadow)}
.pt-pd-wrap .subdes-pddetail0103{position:static !important;height:auto !important;background:none !important;padding-top:16px}
.pt-pd-wrap .subdes-pddetail0101{line-height:1.75;color:#344054}
.pt-pd-info-card h3{margin:0 0 14px;color:#102b76;font-size:17px}
.pt-pd-info-card ul{list-style:none;margin:0 0 16px;padding:0;display:grid;gap:10px}
.pt-pd-info-card ul li{display:flex;align-items:center;gap:8px;color:#344054;font-weight:600;font-size:14px}
.pt-pd-info-card ul li i{color:var(--blue)}
.pt-pd-spec-row{display:flex;justify-content:space-between;gap:12px;border-top:1px solid var(--line);padding:10px 0;color:var(--muted);font-size:13px}
.pt-pd-spec-row b{color:#102b76}
@media (max-width:900px){.pt-pd-info-card{flex-basis:100%}}

/* Review summary */
.pt-pd-wrap .review-summary{display:flex;gap:30px;align-items:center;flex-wrap:wrap;margin-bottom:20px;background:var(--soft);border-radius:18px;padding:20px}
.pt-pd-wrap .rating-score h2{color:var(--navy);margin:0}
.pt-pd-wrap .review-item{border:1px solid var(--line)!important;border-radius:16px!important;box-shadow:none!important}

/* Related products */
.pt-pd-wrap .dg-listpd-extart{margin-top:40px}
.pt-pd-wrap .txt-head-pd{font-size:22px;font-weight:800;color:var(--navy);margin-bottom:16px}
.pt-pd-wrap .boxproduct{background:#fff;border:1px solid var(--line);border-radius:18px;overflow:hidden;box-shadow:0 8px 24px rgba(20,53,143,.06);padding-bottom:14px}
.pt-pd-wrap .price-product{color:var(--blue);font-weight:800;font-size:18px}
.pt-pd-wrap .btn-buy{
  display:block;text-align:center;margin:0 14px;background:linear-gradient(135deg,var(--blue),#0d57df);
  color:#fff!important;padding:10px;border-radius:10px;font-weight:700;font-size:14px;
}

/* Extra marketing badges + notes list (visual only, matches mockup) */
.pt-pd-badges{display:flex;gap:10px;flex-wrap:wrap;margin:10px 0 4px}
.pt-pd-badges span{background:#eaf3ff;color:var(--blue);border-radius:999px;padding:6px 13px;font-weight:800;font-size:12px;border:1px solid #d9eaff}
.pt-pd-notes{display:grid;grid-template-columns:repeat(2,1fr);gap:10px;margin-top:16px}
.pt-pd-notes div{display:flex;align-items:center;gap:8px;color:#344054;font-weight:600;font-size:13px}
.pt-pd-notes i{color:var(--blue)}
@media (max-width:640px){.pt-pd-notes{grid-template-columns:1fr}}

@media (max-width:900px){
  .pt-pd-wrap{padding:0 16px}
}
</style>
<style>
.order-hint{
  margin-top: 10px;
  margin-bottom: 10px;
  padding: 10px 12px;
  border: 1px dashed #f0ad4e;
  background: #fff8e6;
  border-radius: 8px;
  font-size: 13px;
  line-height: 1.45;
  color: #8a5a00;
}
.order-hint a{
  color: #2d7f2d;
  font-weight: 600;
  text-decoration: underline;
}
.order-hint .max{
  margin-top: 6px;
  color: #a94442;
  font-weight: 600;
}
</style>
@endsection

@section('content')

@if (!empty($breadcrumb))
<div class="txt-path-page" style="padding-left: 20px;">
	@foreach ($breadcrumb as $index => $item)
		@if($index !== count($breadcrumb) -1 )
			<a class="mg-r-txtpage" href="{{ $item['route'] }}">{{ $item['name'] }} / </a>
		@else
			<span class="mg-r-txtpage-active">{{ $item['name'] }}</span>
		@endif
	@endforeach
</div>
@endif
@php
    $hideAddToCartOnLoad = false;

    if (
        !empty($data['hide_addtocart_status']) &&
        (int)$data['hide_addtocart_status'] === 1 &&
        !empty($data['detail_price_sale_status']) &&
        (int)$data['detail_price_sale_status'] === 1
    ) {
        // กรณีไม่กำหนดเวลา
        if (
            !empty($data['detail_price_sale_status_date']) &&
            (int)$data['detail_price_sale_status_date'] === 2
        ) {
            $hideAddToCartOnLoad = true;
        }

        // กรณีกำหนดเวลา และวันนี้อยู่ในช่วงวันลดราคา
        if (
            !empty($data['detail_price_sale_status_date']) &&
            (int)$data['detail_price_sale_status_date'] === 1 &&
            !empty($data['detail_sale_date_start']) &&
            !empty($data['detail_sale_date_end'])
        ) {
            try {
                $today = \Carbon\Carbon::today();
                $start = \Carbon\Carbon::createFromFormat('d-m-Y', trim($data['detail_sale_date_start']))->startOfDay();
                $end = \Carbon\Carbon::createFromFormat('d-m-Y', trim($data['detail_sale_date_end']))->endOfDay();

                if ($today->between($start, $end)) {
                    $hideAddToCartOnLoad = true;
                }
            } catch (\Exception $e) {
                $hideAddToCartOnLoad = false;
            }
        }
    }
@endphp
@if(!empty($data))
<div class="container-pd-detil pt-pd-wrap">
	<input type="hidden" id="quantity" name="quantity" value="1">

	{{-- ✅ min/max order from DB --}}
	<input type="hidden" id="min_order" value="{{ !empty($data['min_order']) ? (int)$data['min_order'] : '' }}">
	<input type="hidden" id="max_order" value="{{ !empty($data['max_order']) ? (int)$data['max_order'] : '' }}">
	
	<form action="{{ route('fronend.quotation') }}" method="get" class="no-mg" id="quotation-form">
		<input type="hidden" id="_productId" name="productId" value="{{ $data['pro_id'] }}" />
		<input type="hidden" id="_productSku" name="productSku" value="{{ $data['detailSku'] }}" />
		<input type="hidden" id="_productUnit" name="productUnit" value="1" />
		<input type="hidden" id="_ref" name="_ref" @if (!empty($_GET['ref'])) value="{{ $_GET['ref'] }}" @else value="" @endif>
	</form>
	<div class="cover-contentpddetail">
		<!-- website  -->
		<div id="swipedivwebsite">
			<div  class="sub-top-contentpddetail" >
				<div class="sub-top-contentpddetail0-left">
					<div class="sub-contentleft0001">
						<div class="cardimg-small cardimg-small-active">
							<img src="{{ $data['pro_cover'] }}" class="sub-contentleft000img js-thumb" alt="Thumbnail">
						</div>
					@if(count($data['pro_image']) > 1)
						@foreach(array_slice($data['pro_image'], 0, 4) as $picture)
						<div class="cardimg-small">
							<img src="{{ $picture['images'] }}" class="sub-contentleft000img js-thumb" alt="Thumbnail">
						</div>
						@endforeach
					@endif
					</div>
					
					<div class="sub-contentleft0002">
						<div class="sub-contentleft0003">
							<img src="{{ $data['pro_cover'] }}" class="sub-contentleft000img js-main" alt="Main Image">
						</div>
					</div>
				</div>
				<div class="sub-top-contentpddetail0-cent">
					<div class="sub-contentleft0004">
						<div class="sub-contentleft000401">@if(!empty($data['pro_brand'])){{ $data['pro_brand'] }}@endif</div>
						<div class="sub-contentleft000402">
								<div class="sub-contentleft000403">{{ $data['pro_name'] }}</div>
								<div class="sub-contentleft000404 ">
									<div class="sub-contentleft000405 favheart">
										<input id="local-favourite" type="hidden" value="{{ $data['pro_id'] }}" />
										<button id="b-favorite" class="button-favorite add-favorite choose" data-price='{!! $data['detailPrice'] !!}' data-id="{{ $data['pro_id'] }}" data-name="{{ $data['pro_name'] }}" data-img="{{ $data['pro_cover'] }}" data-parmalink="{{ route('fronend.product.content',$data['pro_permalink']) }}" >
											<img class="sub-contentleft000406" src="{{ asset('icon/ecom/heart2.webp')}}" alt="favorite" >
										</button>
										<button id="n-favorite" class="button-favorite remove-favorite choose hidden" data-id="{{ $data['pro_id'] }}">
											<img class="sub-contentleft000406" src="{{ asset('icon/ecom/heart1.webp')}}" alt="favorite" >
										</button>
									</div>
								</div>
						</div>
						<div class="sub-contentleft000407">รหัสสินค้า: @if(!empty($data['pro_sku'])) {{ $data['pro_sku'] }} @else -@endif</div>
						<div class="pt-pd-badges">
							<span>คีย์ภายใน 5 นาที</span>
							<span>Support ไทย</span>
						</div>
						<div class="flex-discount">
							<div class="sub-contentleft000408">{!! $data['detailPrice'] !!}</div>
						</div>
						<div class="mini-head-sub">
							<span class="btn btn_none_vat" >ราคาไม่รวม VAT</span>
							@if(!empty($data['detailStatus']))
								@if(!empty($data['detailStatus']->stu_name))
									<span class="btn btn_status_p" style="background-color: {{ $data['detailStatus']->stu_color }}">
										{{ $data['detailStatus']->stu_name }} @if($data['detailStatus']->stu_preorder == 1) @if(!empty($data['detailStatus']->detail_preorder_day)) ({{ $data['detailStatus']->detail_preorder_day }} วัน) @endif @endif
									</span>
								@endif
							@endif
							@if (Route::has('administrator'))
								@auth
									@php
										$UserLevel = App\Models\UsersLevel::select('l_product_Action','UserId')->where('UserId',Auth::user()->id)->value('l_product_Action');
										if($UserLevel == 1){
											echo '<a href="'.route('product.edit',['tab'=>1,'id' => $data['pro_id']]).'"><span class="btn btn_edit"><i class="icon-edit"></i>  แก้ไขสินค้า</span></a>';
										}
									@endphp
								@endauth
							@endif
						</div>
					</div>
					<div class="sub-contentleft0005 ">
						<div class="coverboxwithline">
							<div class="txt-hdboxwithline" >รายละเอียดสินค้า :</div>
							<div class="des-boxwithline">
							  <div class="txt-subboxnoline">
								@if(!empty($data['pro_highlight']))
								  {!! $data['pro_highlight'] !!}
								@endif
							  </div>
							  <div class="txt-subboxwithline">แสดงเพิ่มเติม</div>
							</div>
						</div>
						<div class="coverboxwithline">
							   <div class="txt-hdboxwithline">ผ่อนชำระสูงสุด 36 เดือน  :</div>
								@if(!empty($data['proInstallment']))
								<a href="javascript:void(0)" data-toggle="modal" data-target="#installment">
									รายละเอียด
								</a>
								@endif
						</div>
						<div class="coverboxwithhountline">
							<div class="txt-hdboxwithline">อื่นๆ :</div>
							
							@if(!empty($data['pro_codition']) || !empty($data['pro_download']))
								
								@if(count($data['pro_codition']) != 0)
									@foreach ($data['pro_codition'] as $item)
								<!--div class="condition-p">
									<img width="30" height="30" class="lazyload"  src="{{ asset('storage/condition/'.$item['img']) }}" alt="{{ $item['name'] }}">
									<div class="display-center">
										{{ $item['name'] }}
										<span>{{ $item['des'] }}</span>
									</div>
								</div-->
									@endforeach
								@endif
								
								@if(!empty($data['pro_download']))
								<a class="btu-boxwithline" href="{{ asset('storage/product_dowloads/'.$data['pro_download']) }}" download>
									<div class="sub-contentleft000501">ดาวน์โหลดโบว์ชัวร์</div>
									<div class="sub-contentleft000502">
										<img src="/assets/fontend/hax_theme/images/btulinkout.webp" class="sub-contentleft000503" >
									</div>
								</a>
								@endif
							
							
							@endif
							
						</div>
					</div>
				</div>
				<div class="sub-top-contentpddetail0-right">
					<div class="covercard-rightwh">
							<div class="covertop-rightktwh" >
								<div class="sub-contentleft0006">ตัวเลือก</div>
								
							</div>
							<div class="sub-contentleft0007">
								<div class="sub-contentleft000701">จำนวน :</div>
								
								<div class="b-quantity">
									<div class="quantity clearfix">
										<button class="minus"><img class="sizeminus" src="/assets/fontend/hax_theme/images/minus.webp"></button>
										<input type="text" id="quantity_desktop" value="1" class="qty">
										<button class="plus"><img class="sizeplus" src="/assets/fontend/hax_theme/images/plus.webp"></button>
									</div>
								</div>
								
							</div>
							<div id="div_alert_stock_desktop" style="display: none;">
								<span class="text-danger">คุณได้เพิ่มสินค้าครบตามจำนวนสต็อกแล้ว</span>
							</div>
							{{-- ✅ Order constraints hint (Desktop) --}}
							<div id="order_hint_desktop" class="order-hint" style="display:none;"></div>
							<div class=" sub-contentleft0008">
								
								<input type="hidden" id="ref" name="ref" @if (!empty($_GET['ref'])) value="{{ $_GET['ref'] }}" @else value="" @endif>
								@if ($data['detailContact'] == 2)
									
									<button class="sub-contentleft000801 b-cart-one" id="b-cart" data-id="{{ $data['pro_id'] }}" @if ($data['detailStatus'] == 1 || $hideAddToCartOnLoad) style="display:none" @endif>
                                        <img class="sub-contentleft000802" src="/assets/fontend/hax_theme/images/cartaddon.webp">
                                        <div class="sub-contentleft000803">เพิ่มลงตะกร้า</div>
                                    </button>
									
									@if($quotationSetting == 1)
										<div id="b-quotation" class="sub-contentleft000804" onclick="submitQuotationForm();">ขอใบเสนอราคา</div>
									@endif
								@else
									@if($quotationSetting == 1)
										<div id="b-quotation" class="sub-contentleft000804" onclick="submitQuotationForm();">ขอใบเสนอราคา</div>
									@endif
								@endif
							</div>
					</div>
					<div class="pt-pd-notes">
						<div><i data-lucide="key-round" size="18"></i> รับคีย์อัตโนมัติภายใน 5 นาที</div>
						<div><i data-lucide="file-text" size="18"></i> ออกใบกำกับภาษีได้</div>
						<div><i data-lucide="monitor" size="18"></i> รองรับไฟล์ DWG</div>
						<div><i data-lucide="message-circle" size="18"></i> ซัพพอร์ตภาษาไทย</div>
					</div>
					
				</div>
			</div>
		</div>
		<!-- mobile  -->
		<div id="swipedivmobile" >
			<div class="sub-top-contentpddetail">
				<div class="sub-top-contentpddetail0-left">
				  <div class="sub-contentleft0002">
					<div class="sub-contentleft0003">
					  <img 
						src="{{ $data['pro_cover'] }}" 
						class="sub-contentleft000img js-main" 
						alt="Main Image"
					  >
					</div>
				  </div>
				  <div class="sub-contentleft0001">
					<div class="cardimg-small cardimg-small-active">
					  <img 
						src="{{ $data['pro_cover'] }}" 
						class="sub-contentleft000img js-thumb" 
						alt="Thumbnail 1"
					  >
					</div>
					@if(count($data['pro_image']) > 1)
					  @foreach(array_slice($data['pro_image'], 0, 4) as $picture)
						<div class="cardimg-small">
						  <img 
							src="{{ $picture['images'] }}" 
							class="sub-contentleft000img js-thumb" 
							alt="Thumbnail {{ $loop->iteration + 1 }}"
						  >
						</div>
					  @endforeach
					@endif
				  </div>
				</div>
				<div class="sub-top-contentpddetail0-cent">
					<div class="sub-contentleft0004">
							<div class="sub-contentleft000401">@if(!empty($data['pro_brand'])){{ $data['pro_brand'] }}@endif</div>
							<div class="sub-contentleft000402">
									<div class="sub-contentleft000403">{{ $data['pro_name'] }}</div>
									<div class="sub-contentleft000404 ">
										<div class="sub-contentleft000405 favheart ">
											<img src="/assets/fontend/hax_theme/images/fve-heart.webp" class="sub-contentleft000406">
										</div>
									</div>
							</div>
							<div class="sub-contentleft000407">รหัสสินค้า: @if(!empty($data['pro_sku'])){{ $data['pro_sku'] }}@else-@endif</div>
							<div class="flex-discount">
								<div class="sub-contentleft000408">{!! $data['detailPrice'] !!}</div>
							</div>
					</div>
					<div class="sub-contentleft0005 ">
						<div class="coverboxwithline">
							<div class="txt-hdboxwithline" >รายละเอียดสินค้า :</div>
							
							<div class="des-boxwithline">
							  <div class="txt-subboxnoline">
								@if(!empty($data['pro_highlight']))
								  {!! $data['pro_highlight'] !!}
								@endif
							  </div>
							  <div class="txt-subboxwithline">แสดงเพิ่มเติม</div>
							</div>
						</div>
						<div class="coverboxwithline">
							   <div class="txt-hdboxwithline">ผ่อนชำระสูงสุด 36 เดือน  :</div>
								@if(!empty($data['proInstallment']))
								<a href="javascript:void(0)" data-toggle="modal" data-target="#installment">
									รายละเอียด
								</a>
								@endif
						</div>
						
						<div class="coverboxwithhountline">
							<div class="txt-hdboxwithline">อื่นๆ :</div>
							<div class="btu-boxwithline">
								@if(!empty($data['pro_codition']) || !empty($data['pro_download']))
								
									@if(count($data['pro_codition']) != 0)
										@foreach ($data['pro_codition'] as $item)
									<!--div class="condition-p">
										<img width="30" height="30" class="lazyload"  src="{{ asset('storage/condition/'.$item['img']) }}" alt="{{ $item['name'] }}">
										<div class="display-center">
											{{ $item['name'] }}
											<span>{{ $item['des'] }}</span>
										</div>
									</div-->
										@endforeach
									@endif
									
									@if(!empty($data['pro_download']))
									<a class="btu-boxwithline" href="{{ asset('storage/product_dowloads/'.$data['pro_download']) }}" download>
										<div class="sub-contentleft000501">ดาวน์โหลดโบว์ชัวร์</div>
										<div class="sub-contentleft000502">
											<img src="/assets/fontend/hax_theme/images/btulinkout.webp" class="sub-contentleft000503" >
										</div>
									</a>
									@endif
								
								
								@endif
							</div>
						</div>
					</div>
				</div>
				<div class="sub-top-contentpddetail0-right">
					<div class="covercard-rightwh">
							
							<div class="sub-contentleft0007">
								<div class="sub-contentleft000701">จำนวน :</div>
								
								<div class="b-quantity">
									<div class="quantity clearfix">
										<button class="minus mobile"><img class="sizeminus" src="/assets/fontend/hax_theme/images/minus.webp"></button>
										<input type="text" id="quantity_mobile" value="1" class="qty">
										<button class="plus mobile"><img class="sizeplus" src="/assets/fontend/hax_theme/images/plus.webp"></button>
									</div>
								</div>
								
							</div>
							<div id="div_alert_stock_mobile" style="display: none;">
								<span class="text-danger">คุณได้เพิ่มสินค้าครบตามจำนวนสต็อกแล้ว</span>
							</div>
							{{-- ✅ Order constraints hint (Mobile) --}}
							<div id="order_hint_mobile" class="order-hint" style="display:none;"></div>
							<div class=" sub-contentleft0008">
							
								@if ($data['detailContact'] == 2)
									
									<button class="sub-contentleft000801 b-cart-one" id="b-cart-m" data-id="{{ $data['pro_id'] }}" @if ($data['detailStatus'] == 1 || $hideAddToCartOnLoad) style="display:none" @endif>
                                        <img class="sub-contentleft000802" src="/assets/fontend/hax_theme/images/cartaddon.webp">
                                        <div class="sub-contentleft000803">เพิ่มลงตะกร้า</div>
                                    </button>
									
									@if($quotationSetting == 1)
										<div id="b-quotation-m" class="sub-contentleft000804" onclick="submitQuotationForm();">ขอใบเสนอราคา</div>
									@endif
								@else
									@if($quotationSetting == 1)
										<div id="b-quotation-m" class="sub-contentleft000804" onclick="submitQuotationForm();">ขอใบเสนอราคา</div>
									@endif
								@endif
							
							</div>
					</div>
					
				</div>
			</div>
		</div>
	 </div>
         <div class="cover-contentpddetail">
            <div class="sub-mid-contentpddetail">
               <div class="coverdex3box">
					@if(!empty($data['pro_content']))<div id="btu-pdda01" onclick="showtabpdde(1)" class="desbox00 txtgreenactive">รายละเอียดสินค้า</div>@endif
					@if(!empty($data['pro_specification']))<div id="btu-pdda02"onclick="showtabpdde(2)" class="desbox00">สเปกสินค้า</div>@endif
					@if(!empty($data['pro_feature']))<div id="btu-pdda03"onclick="showtabpdde(3)" class="desbox00">คุณสมบัติ</div>@endif
					@if(!empty($data['pro_gift']))<div id="btu-pdda04"onclick="showtabpdde(4)" class="desbox00">ของแถมและสิทธิพิเศษ</div>@endif
                    <div id="btu-pdda05" onclick="showtabpdde(5)"class="desbox00">รีวิวจากผู้ใช้งาน</div>
               </div>
               <!-- tab des -->
			   @if(!empty($data['pro_content']))
               <div id="des-pdda01">
				  <div class="coverdes-pddetail01">
					<div class="pt-pd-tab-grid">
					<div class="des-pddetail01">
					  <div class="subdes-pddetail0101">
						<div class="destxtbox00">รายละเอียดสินค้า</div>
						{!! $data['pro_content'] !!}
					  </div>
					  <div class="subdes-pddetail0103">
						<div class="btupddetail0103">แสดงเพิ่มเติม</div>
					  </div>
					</div>
					<aside class="pt-pd-info-card">
						<h3>ข้อมูลสำคัญ</h3>
						<ul>
							<li><i data-lucide="check-circle" size="18"></i> Digital License</li>
							<li><i data-lucide="check-circle" size="18"></i> Windows Compatible</li>
							<li><i data-lucide="check-circle" size="18"></i> Online Payment</li>
							<li><i data-lucide="check-circle" size="18"></i> Member Download</li>
						</ul>
						<div class="pt-pd-spec-row"><span>Delivery</span><b>Auto Key</b></div>
						@if(!empty($data['pro_download']))
						<div class="pt-pd-spec-row"><span>Brochure</span><a href="{{ asset('storage/product_dowloads/'.$data['pro_download']) }}" download><b>PDF Download</b></a></div>
						@endif
					</aside>
					</div>
				  </div>
				</div>
				@endif
				
				@if(!empty($data['pro_specification']))
				<div id="des-pdda02" style="display:none;">
				  <div class="coverdes-pddetail01">
					<div class="des-pddetail01">
					  <div class="subdes-pddetail0101">
						<div class="destxtbox00">สเปกสินค้า</div>
						
						<div class="table-responsive">
							<table class="table table-bordered table-striped">
								<tbody>
									@foreach ($data['pro_specification'] as $spec)
									<tr>
										<td class="table-head">{{ $spec['spec_name']}}</td>

										<td class="table-detail"><div>{!! $spec['spec_detail'] !!}</div></td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
						
					  </div>
					  
					</div>
				  </div>
				</div>
				@endif
			   
				@if(!empty($data['pro_feature']))
				<div id="des-pdda03" style="display:none;">
				  <div class="coverdes-pddetail01">
					<div class="des-pddetail01">
					  <div class="subdes-pddetail0101">
						<div class="destxtbox00">คุณสมบัติ</div>
						
						{!! $data['pro_feature'] !!}
						
					  </div>
					  
					</div>
				  </div>
				</div>
				@endif
				
				@if(!empty($data['pro_gift']))
				<div id="des-pdda04" style="display:none;">
				  <div class="coverdes-pddetail01">
					<div class="des-pddetail01">
					  <div class="subdes-pddetail0101">
						<div class="destxtbox00">ของแถมและสิทธิพิเศษ</div>
						
						{!! $data['pro_gift'] !!}
						
					  </div>
					  
					</div>
				  </div>
				</div>
				@endif
				
				<div id="des-pdda05" style="display:none;">
				  <div class="coverdes-pddetail01">
					<div class="des-pddetail01">
					  <div class="subdes-pddetail0101">
						<div class="destxtbox00">รีวิวจากผู้ใช้งาน</div>
						
							@if(!empty($rating) && !empty($rating['avg_rating']))
							<div class="review-summary">
								<div class="rating-score">
									<h2>{{ number_format($rating['avg_rating'], 1) }} / 5</h2>
									<div class="stars">
										@php
											$fullStars = floor($rating['avg_rating']);
											$halfStar = ($rating['avg_rating'] - $fullStars) >= 0.5 ? 1 : 0;
											$emptyStars = 5 - ($fullStars + $halfStar);
										@endphp
										@for ($i = 0; $i < $fullStars; $i++)
											<i class="fas fa-star full-star"></i>
										@endfor
										@if ($halfStar)
											<i class="fas fa-star-half-alt half-star"></i>
										@endif
										@for ($i = 0; $i < $emptyStars; $i++)
											<i class="far fa-star empty-star"></i>
										@endfor
									</div>
									<p>จาก {{ $rating['count_review'] }} รีวิว</p>
								</div>

								<div class="review-distribution">
									@php
										$totalReviews = $rating['count_review'];
										$ratingsBreakdown = [5 => $rating['count_5']
															, 4 => $rating['count_4']
															, 3 => $rating['count_3']
															, 2 => $rating['count_2'],
															1 => $rating['count_1']];
									@endphp

									@foreach ($ratingsBreakdown as $star => $count)
										<div class="review-bar">
											<span>{{ $star }} ดาว</span>
											<div class="bar">
												<div class="fill" style="width: {{ ($count / $totalReviews) * 100 }}%;"></div>
											</div>
											<span>{{ $count }}</span>
										</div>
									@endforeach
								</div>
							</div>
						@endif
						
						@if(!empty($reviews) && count($reviews) > 0)
							<div id="review-comment">
								@foreach ($reviews as $review)
									<div class="review-item card shadow-sm p-3 mb-3">
										<div class="review-header d-flex justify-content-between">
											<strong>{{ mb_substr($review->name, 0, 1) }}{{ str_repeat('*', mb_strlen($review->name) - 1) }} 
												{{ mb_substr($review->lastname, 0, 1) }}{{ str_repeat('*', mb_strlen($review->lastname) - 1) }}
											</strong>
											<small class="review-date text-muted">({{ $review->created_at->diffForHumans() }})</small>
										</div>
										
										<div class="review-stars">
											@for ($i = 0; $i < $review->rating; $i++)
												<i class="fas fa-star full-star text-warning"></i>
											@endfor
											@for ($i = $review->rating; $i < 5; $i++)
												<i class="far fa-star empty-star text-secondary"></i>
											@endfor
										</div>
										
										<p class="review-text">{{ $review->review_text }}</p>
										
										<!-- Video Section (Thumbnail & Popup) -->
										<div class="review-media d-flex flex-wrap">
										@if(!empty($review->video_url))
											<div class="review-video">
												<a href="#" data-toggle="modal" data-target="#videoModal-{{ $review->id }}" class="video-wrapper">
													<video class="review-thumbnail" muted>
														<source src="{{ asset('/'.$review->video_url) }}" type="video/mp4">
														<source src="{{ asset('/'.$review->video_url) }}" type="video/ogg">
														<source src="{{ asset('/'.$review->video_url) }}" type="video/webm">
														วิดีโอไม่สามารถเล่นได้
													</video>
													<img src="{{ asset('/assets/fontend/images/icons/play-video.png') }}" alt="Play Video" class="play-icon">
												</a>
											</div>


											<!-- Video Popup Modal -->
											<div class="modal fade" id="videoModal-{{ $review->id }}" tabindex="-1" role="dialog" aria-hidden="true">
												<div class="modal-dialog modal-dialog-centered">
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal">&times;</button>
														</div>
														<div class="modal-body text-center">
															<video controls class="review-video-player">
																<source src="{{ asset('/'.$review->video_url) }}" type="video/mp4">
																<source src="{{ asset('/'.$review->video_url) }}" type="video/ogg">
																<source src="{{ asset('/'.$review->video_url) }}" type="video/webm">
																เบราว์เซอร์ของคุณไม่รองรับการเล่นวิดีโอ
															</video>
														</div>
													</div>
												</div>
											</div>
										@endif

										<!-- Image Section (Thumbnail & Popup) -->
										@if(!empty($review->image_url))
											<div class="review-images">
												<a href="#" data-toggle="modal" data-target="#imageModal-{{ $review->id }}">
													<img src="{{ asset('/'.$review->image_url) }}" alt="Review Image" class="img-thumbnail review-thumbnail">
												</a>
											</div>

											<!-- Image Modal -->
											<div class="modal fade" id="imageModal-{{ $review->id }}" tabindex="-1" role="dialog" aria-hidden="true">
												<div class="modal-dialog modal-dialog-centered">
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal">&times;</button>
														</div>
														<div class="modal-body text-center">
															<img src="{{ asset('/'.$review->image_url) }}" alt="Review Image" class="img-fluid">
														</div>
													</div>
												</div>
											</div>
										@endif
										</div>
										
									</div>
								@endforeach

								<!-- Pagination -->
								<div class="review-pagination">
									{{ $reviews->appends(request()->except('page'))->links('vendor.pagination.custom') }}
								</div>
							</div>



						@else
							<div class="text-center">- ยังไม่มีรีวิว -</div>
						@endif
						
					  </div>
					  
					</div>
				  </div>
				</div>
				
            </div>
            
         </div>
         
         
		 <div class=" dg-listpd-extart" >
            <div class="boxheadname">
                <div class="boxtxt-head-pd">
                    <div class="txt-head-pd">สินค้าที่เกี่ยวข้อง</div>
                </div>
            </div>
            
			<div class="dg-listpd category">
				@foreach ($data['pro_related'] as $related)
				<div class="boxproduct">
					<a class="h-pic-product" href="{{ route('fronend.product.content',['permalink'=>$related['permalink']]) }}@if(!empty($_GET['ref']))?ref={{ $_GET['ref'] }}@endif">
						<img class="size-product" src="{{ asset('storage/product/'.$related['picture']) }}" alt="{{ $related['name'] }}">
					</a>
					@if($related['brand'])
					<a class="text-green-product" href="{{ route('fronend.brand',$related['brand_permalink']) }}@if(!empty($_GET['ref']))?ref={{ $_GET['ref'] }}@endif">
						{{ $related['brand'] }}
					</a>
					@else
					<a class="text-green-product" href="#">
						No Brand
					</a>
					@endif
					<div class="name-product">
						{{ $related['name'] }}
					</div>
					<br>
					<div class="price-group-bottom">
						<div class="df-price">
							<div class="price-product">{!! $related['price'] !!}</div>
							<!--div class="price-discount">
								-฿1,500
							</div-->
						</div>
						<div class="discript-product">*ราคาไม่รวม VAT</div>
						<a class="btn-buy" href="{{ route('fronend.product.content',$related['permalink']) }}@if(!empty($_GET['ref']))?ref={{ $_GET['ref'] }}@endif">
							ดูรายละเอียด
						</a>
					</div>
				</div>
				@endforeach
			</div>
         </div>
    </div>
	
	@if (!empty($data['proInstallment']))
	<div class="modal fade" id="installment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
		<div class="modal-dialog">
			<div class="modal-body">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h4 class="modal-title" id="myModalLabel">การผ่อนชำระ</h4>
					</div>
					<div class="modal-body">
						@foreach ($settingInstallment as $installment)
						<div class="row b-installment">
							<div class="col-lg-2 col-md-2 col-sm-2 col-xs-3">
								<img width="42" height="42" class="lazyload"  src="{{ asset('storage/installment/'.$installment->installment_img) }}" alt="{{ $installment->installment_name }}">
							</div>
							<div class="col-lg-10 col-md-10 col-sm-10 col-xs-9">{{ $installment->installment_name }}<br/><small>{{ $installment->installment_detail }}</small><br/><small>อัตราดอกเบี้ย <b style="color: red;">{{ $installment->interest_detail }}</b></small></div>
						</div>
						@endforeach
						<center style="color: red; font-size: 75%;">** อัตราดอกเบี้ยอาจมีการเปลี่ยนแปลงได้ ทั้งนี้ขึ้นอยู่กับโปรโมชั่นของธนาคารในแต่ละช่วง</center>
					</div>
				</div>
			</div>
		</div>
	</div>
    @endif
@endif

<div itemscope itemtype="http://schema.org/Product">
    <meta itemprop="brand" content="{{ $data['pro_brand'] }}">
    <meta itemprop="name" content="{{ $data['pro_name'] }}">
    <meta itemprop="description" content="{{ $data['pro_seo_detail'] }}">
    <meta itemprop="productID" content="{{ $data['pro_sku'] }}">
    <meta itemprop="url" content="{{ route('fronend.product.content',$data['pro_permalink']) }}">
    <meta itemprop="image" content="{{ asset('storage/product/'.$data['pro_cover']) }}">
    <div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
      <link itemprop="availability" href="http://schema.org/{{ $data['availability']}}">
      <link itemprop="itemCondition" href="http://schema.org/new">
      <meta itemprop="price" content="{{ $data['og_price'] }}">
      <meta itemprop="priceCurrency" content="THB">
    </div>
</div>

@endsection

@section('js')
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/th_TH/sdk.js#xfbml=1&version=v12.0&appId=1190234624660031&autoLogAppEvents=1" nonce="h8yjg5hD"></script>
<script src="https://d.line-scdn.net/r/web/social-plugin/js/thirdparty/loader.min.js" async="async" defer="defer"></script>
<script type="application/ld+json">
    {
        "@context":"https://schema.org",
        "@type":"Product",
        "productID":"{{ $data['pro_sku'] }}",
        "name":"{{ $data['pro_name']}}",
        "description":"{{ $data['pro_seo_detail'] }}",
        "url":"{{ route('fronend.product.content',$data['pro_permalink']) }}",
        "image":"{{ $data['pro_cover'] }}",
        "brand":"{{ $data['pro_brand'] }}",
        "offers": [
            {
            "@type": "Offer",
            "price": "{{ $data['og_price'] }}",
            "priceCurrency": "THB",
            "itemCondition": "https://schema.org/new",
            "availability": "https://schema.org/{{ $data['availability'] }}"
            }
        ],
		"aggregateRating": {
			"@type": "AggregateRating",
			"ratingValue": "{{ number_format($rating['avg_rating']) }}",
			"reviewCount": "{{ number_format($rating['count_review']) }}"
		}
    }
</script>

@if(!empty($data['pro_brand']) && $data['pro_brand'] == 'Sketchup')
<!-- Facebook Pixel Code for Supplier (Sketchup) -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '<?php echo env('FACEBOOK_PIXEL_ID'); ?>');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=<?php echo env('FACEBOOK_PIXEL_ID'); ?>&ev=PageView&noscript=1"/></noscript>
<!-- End Facebook Pixel Code for Supplier (Sketchup) --> 
@endif

<script>
/*
gtag("event", "view_item", {
	currency: "THB",
	value: "{{ $data['og_price'] }}",
	items: [
		{
			item_id: "{{ $data['pro_sku'] }}",
			item_name: "{{ $data['pro_name'] }}",
			item_brand: "{{ $data['pro_brand'] }}",
			price: "{{ $data['og_price'] }}",
			quantity: 1
		}
	]
});

fbq('track', 'ViewContent', {
	contents: [{id:"{{ $data['pro_sku'] }}",quantity:1,brand:"{{ $data['pro_brand'] }}",name:"{{ $data['pro_name'] }}",item_price:"{{ $data['og_price'] }}"}],
	content_type: "product",
	content_category: "{{ $data['pro_brand'] }}",
	content_name: "{{ $data['pro_name'] }}",
	currency: "THB",
	value: "{{ $data['og_price'] }}"
});

$("#b-cart").click(function(){
	
	var qty = $("#quantity").val();
	var og_price = "{{ $data['og_price'] }}";
	var totalPrice = qty*og_price;
	
	gtag("event", "add_to_cart", {
		currency: "THB",
		value: totalPrice,
		items: [
			{
				item_id: "{{ $data['pro_sku'] }}",
				item_name: "{{ $data['pro_name'] }}",
				item_brand: "{{ $data['pro_brand'] }}",
				price: og_price,
				quantity: qty
			}
		]
	});
	
	fbq('track', 'AddToCart', {
		contents: [{id:"{{ $data['pro_sku'] }}",quantity:qty,brand:"{{ $data['pro_brand'] }}",name:"{{ $data['pro_name'] }}",item_price:"{{ $data['og_price'] }}"}],
		content_type: "product",
		content_category: "{{ $data['pro_brand'] }}",
		content_name: "{{ $data['pro_name'] }}",
		currency: "THB",
		value: totalPrice
	});
	
});

$("#b-quotation").click(function(){
	
	var qty = $("#quantity").val();
	var og_price = "{{ $data['og_price'] }}";
	var totalPrice = qty*og_price;
	
	gtag("event", "add_to_quote", {
		currency: "THB",
		value: totalPrice,
		item_id: "{{ $data['pro_sku'] }}",
		item_name: "{{ $data['pro_name'] }}",
		item_brand: "{{ $data['pro_brand'] }}",
		price: og_price,
		quantity: qty
	});
	
});
*/

$(document).ready(function() {
    var stock = parseInt("{{ $data['detail_stock'] }}", 10);
    var check_stock = "{{ $data['detail_check_stock_status'] }}";

    var min_order_raw = parseInt($('#min_order').val(), 10);
    var max_order = parseInt($('#max_order').val(), 10);

    if (isNaN(max_order) || max_order < 1) max_order = null;
	if (isNaN(min_order_raw) || min_order_raw < 1) min_order_raw = null;

	var min_order = (min_order_raw !== null) ? min_order_raw : 1;

    function clampQty(qty) {
        qty = parseInt(qty, 10);
        if (isNaN(qty)) qty = min_order;

        if (qty < min_order) qty = min_order;

        if (max_order !== null && qty > max_order) qty = max_order;

        if (check_stock === "1") {
            if (!isNaN(stock) && stock >= 0 && qty > stock) qty = stock;
        }

        return qty;
    }

    function syncQuantity(qty) {
        qty = clampQty(qty);

        if (check_stock === "1") {
            if (!isNaN(stock) && stock >= 0 && qty >= stock) {
                if (stock > 0 && qty === stock) {
                    $('#div_alert_stock_desktop, #div_alert_stock_mobile').show();
                } else {
                    $('#div_alert_stock_desktop, #div_alert_stock_mobile').hide();
                }
            } else {
                $('#div_alert_stock_desktop, #div_alert_stock_mobile').hide();
            }
        } else {
            $('#div_alert_stock_desktop, #div_alert_stock_mobile').hide();
        }

        $('#quantity').val(qty);
        $('#quantity_desktop, #quantity_mobile, #_productUnit').val(qty);
    }
	
	function renderOrderHint(min_order_raw, max_order){
		let parts = [];

		if (min_order_raw !== null && min_order_raw > 0) {
			parts.push(
				`สั่งซื้อขั้นต่ำ ${min_order_raw} Seats <br>
				กรณีสั่งซื้อน้อยกว่าจำนวนขั้นต่ำ กรุณาติดต่อ Line ID : <a href="https://page.line.me/8BAHT" target="_blank">@8baht</a>`
			);
		}

		if (max_order !== null && max_order > 0) {
			parts.push(`<div class="max">จำกัดจำนวนสั่งซื้อสูงสุด ${max_order}</div>`);
		}

		const html = parts.join('');
		if (html.trim() !== '') {
			$('#order_hint_desktop, #order_hint_mobile').html(html).show();
		} else {
			$('#order_hint_desktop, #order_hint_mobile').hide().html('');
		}
	}

    $('.minus').on('click', function(e) {
        e.preventDefault();
        var current = parseInt($('#quantity').val(), 10);
        syncQuantity(current - 1);
    });

    $('.plus').on('click', function(e) {
        e.preventDefault();
        var current = parseInt($('#quantity').val(), 10);
        syncQuantity(current + 1);
    });

    $('#quantity, #quantity_desktop, #quantity_mobile').on('input', function() {
        syncQuantity($(this).val());
    });

	renderOrderHint(min_order_raw, max_order);

	syncQuantity(min_order);
	
});


</script>
<script type="text/javascript" src="{{ asset('assets/fontend/js/product-review.js') }}"></script>
<script>
 function showtabpdde(id){
    $('#btu-pdda01').removeClass('txtgreenactive')
    $('#btu-pdda02').removeClass('txtgreenactive')
    $('#btu-pdda03').removeClass('txtgreenactive')
	$('#btu-pdda04').removeClass('txtgreenactive')
    $('#btu-pdda05').removeClass('txtgreenactive')
    $('#des-pdda01').css('display','none')
    $('#des-pdda02').css('display','none')
    $('#des-pdda03').css('display','none')
	$('#des-pdda04').css('display','none')
    $('#des-pdda05').css('display','none')

    if(id == 1){
        $('#btu-pdda01').addClass('txtgreenactive')
        $('#des-pdda01').css('display','block')
    }
    if(id == 2){
        $('#btu-pdda02').addClass('txtgreenactive')
        $('#des-pdda02').css('display','block')
    }
    if(id == 3){
        $('#btu-pdda03').addClass('txtgreenactive')
        $('#des-pdda03').css('display','block')
    }
	if(id == 4){
        $('#btu-pdda04').addClass('txtgreenactive')
        $('#des-pdda04').css('display','block')
    }
	if(id == 5){
        $('#btu-pdda05').addClass('txtgreenactive')
        $('#des-pdda05').css('display','block')
    }
 }
</script>
<!-- Number Incrementers start -->
<!--script>
document.querySelectorAll(".quantity").forEach(quantityContainer => {
  const minusBtn = quantityContainer.querySelector(".minus");
  const plusBtn = quantityContainer.querySelector(".plus");
  const inputBox = quantityContainer.querySelector(".input-box");

  updateButtonStates();

  quantityContainer.addEventListener("click", handleButtonClick);
  inputBox.addEventListener("input", handleQuantityChange);

  function updateButtonStates() {
	const value = parseInt(inputBox.value);
	minusBtn.disabled = value <= 1;
	plusBtn.disabled = isNaN(value);
  }

  function handleButtonClick(event) {
	if (event.target.classList.contains("minus")) {
	  decreaseValue();
	} else if (event.target.classList.contains("plus")) {
	  increaseValue();
	}
  }

  function decreaseValue() {
	let value = parseInt(inputBox.value);
	value = isNaN(value) ? 1 : Math.max(value - 1, 1);
	inputBox.value = value;
	updateButtonStates();
	handleQuantityChange();
  }

  function increaseValue() {
	let value = parseInt(inputBox.value);
	value = isNaN(value) ? 1 : value + 1;
	inputBox.value = value;
	updateButtonStates();
	handleQuantityChange();
  }

  function handleQuantityChange() {
	let value = parseInt(inputBox.value);
	value = isNaN(value) ? 1 : value;

	console.log("Quantity changed:", value);
  }
});
</script-->
<script>
document.addEventListener('DOMContentLoaded', function(){
  // หา container ทุกอัน (ทั้งเว็บและมือถือ)
  document.querySelectorAll('.sub-top-contentpddetail0-left').forEach(container => {
    // ฟัง event เดียวบน parent แทน bind ทีละรูป
    container.querySelector('.sub-contentleft0001').addEventListener('click', function(e){
      const thumb = e.target.closest('.js-thumb');
      if (!thumb) return;       // กดไม่ใช่รูป ก็ข้าม
      e.preventDefault();

      // เปลี่ยน src ของรูปหลักภายใน container เดียวกัน
      const mainImg = container.querySelector('.js-main');
      mainImg.src = thumb.src;

      // จัดการ active class ภายใน container เดียวกัน
      container.querySelectorAll('.cardimg-small').forEach(div => {
        div.classList.remove('cardimg-small-active');
      });
      thumb.closest('.cardimg-small').classList.add('cardimg-small-active');
    });
  });
});

document.addEventListener('DOMContentLoaded', function(){
  document.querySelectorAll('.des-boxwithline').forEach(box => {
	const content = box.querySelector('.txt-subboxnoline');
	const toggle  = box.querySelector('.txt-subboxwithline');

	toggle.addEventListener('click', function(){
	  const isExpanded = content.classList.toggle('expanded');
	  toggle.textContent = isExpanded ? 'ย่อ' : 'แสดงเพิ่มเติม';
	});
  });
});

function submitQuotationForm() {
	const form = document.getElementById('quotation-form');
	if (form) {
	  form.submit();
	} else {
	  console.error('Form with id "quotation-form" not found');
	}
}

document.addEventListener('DOMContentLoaded', function(){
  const content = document.querySelector('.subdes-pddetail0101');
  const trigger = document.querySelector('.btupddetail0103');

  trigger.addEventListener('click', function(){
    const isExpanded = content.classList.toggle('expanded');
    trigger.textContent = isExpanded ? 'ย่อ' : 'แสดงเพิ่มเติม';
  });
});

</script>
@endsection