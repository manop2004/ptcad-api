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
<link rel="stylesheet" href="{{ asset('assets/fontend/css/components/radio-checkbox.css') }}" type="text/css" /><!-- Date & Time Picker CSS -->
<link rel="stylesheet" href="{{ asset('vendor/datepicker/jquery-ui.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/fontend/css/components/timepicker.css') }}" type="text/css" />
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Noto+Sans+Thai:wght@400;500;600;700;800&display=swap');

.pt-success-wrap{
  font-family:'Poppins','Noto Sans Thai',system-ui,sans-serif;
  color:#0b1f4d;
}
.pt-success-wrap .alert{
  border:none !important;
  border-radius:24px !important;
  padding:48px !important;
  box-shadow:0 18px 50px rgba(20,53,143,.10) !important;
}
.pt-success-wrap .alert-success{
  background:linear-gradient(105deg,#ffffff 0%,#f3f8ff 62%,#dbefff 100%) !important;
  color:#0b1f4d !important;
}
.pt-success-wrap .alert-warning{
  background:linear-gradient(105deg,#fffaf5 0%,#fff3e6 100%) !important;
  color:#0b1f4d !important;
}
.pt-success-wrap h3{
  font-size:28px !important;color:#12358f !important;font-weight:800 !important;letter-spacing:-.6px;
}
.pt-success-wrap .alert-link{
  color:#1765ff !important;font-weight:800 !important;
}
.pt-success-wrap .icon-succeed{
  width:64px;height:64px;object-fit:contain;margin-bottom:8px;
  filter: brightness(0) saturate(100%) invert(29%) sepia(94%) saturate(1955%) hue-rotate(212deg) brightness(101%) contrast(101%);
}
.pt-success-wrap .icon-fail{
  width:64px;height:64px;object-fit:contain;margin-bottom:8px;
}
</style>
@endsection

@section('content')
<section id="content">
    <div class="content-wrap">
        <div class="container pt-success-wrap">
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
            <br/>
            @if(!empty($order))

               @if($order->payment_status == 7)
    <div class="alert alert-success topmargin-lg bottommargin-lg center">
        <img class="icon-succeed" src="{{ asset('icon/succeed.png') }}" />
        <h3 class="topmargin-sm">คำสั่งซื้อเลขที่ {{ $order->orderNumber }}</h3><br/>
        <div>ชำระเงินผ่านบัตรเครดิตสำเร็จแล้ว</div>
        <div>License Key ของคุณกำลังถูกจัดเตรียม ตรวจสอบได้ที่หน้า "สินค้าของฉัน"</div>
        <div>คุณสามารถดูสถานะและรายละเอียดได้ที่นี่ <a href="{{ route('fronend.account.order.detail',$order->id) }}" class="alert-link">คลิก!</a></div>
    </div>
@elseif($order->payment_status == 2)
    <div class="alert alert-success topmargin-lg bottommargin-lg center">
        <img class="icon-succeed" src="{{ asset('icon/succeed.png') }}" />
        <h3 class="topmargin-sm">คำสั่งซื้อเลขที่ {{ $order->orderNumber }}</h3><br/>
        <div>คุณแจ้งชำระเงินสำหรับคำสั่งซื้อนี้แล้ว</div>
        <div>เจ้าหน้าที่จะตรวจสอบความถูกต้องและจัดส่ง License Key ให้คุณทางอีเมล</div>
        <div>คุณสามารถดูสถานะและรายละเอียดได้ที่นี่ <a href="{{ route('fronend.account.order.detail',$order->id) }}" class="alert-link">คลิก!</a></div>
    </div>
@else

                    <div class="alert alert-warning topmargin-lg bottommargin-lg center">
                        <img class="icon-fail" src="{{ asset('icon/fail.png') }}" />
                        <h3 class="topmargin-sm">คำสั่งซื้อเลขที่ {{ $order->orderNumber }}</h3><br/>
                        <div>ชำระเงินไม่สำเร็จ</div>
                        <div>กรุณาตรวจสอบข้อมูล และทำการสั่งซื้ออีกครั้ง</div>
                        <div>ไปยังหน้าคำสั่งซื้อรายการนี้ <a href="{{ route('fronend.account.order.detail',$order->id) }}"  class="alert-link">คลิก!</a></div>
                    </div>

                @endif
            @else
                <div class="topmargin-lg bottommargin-lg center pt-success-wrap">
                    <div class="bottommargin-xs">ไม่พบรายการคำสั่งซื้อนี้</div>
                    <a href="{{ route('fronend.cart') }}">ไปยัง "ตะกร้าสินค้า"</a>
                </div>
            @endif
        </div>
    </div>
</section>

@endsection
@section('js')
 <script src="{{ asset('vendor/select2/select2.min.js') }}"></script>
 <script src="{{ asset('vendor/select2-bootstrap4-theme/docs/script.js') }}"></script>
  <!-- Date & Time Picker JS -->
  <script type="text/javascript" src="{{ asset('assets/fontend/js/components/moment.js') }}"></script>
  <script type="text/javascript" src="{{ asset('assets/fontend/js/components/timepicker.js') }}"></script>
  <script type="text/javascript" src="{{ asset('vendor/datepicker/jquery-ui.js') }}"></script>
 
  <script>
     $(function() {
         $('.datepicker').datepicker({
             autoclose: true,
             dateFormat: "dd-mm-yy",
         });
         $('.datetimepicker1').datetimepicker({
             format: 'LT',
             showClose: true
         });
     });
  </script>
  
@if(!empty($order))
<script>
	$(window).load(function(){
		gtag("event", "purchase_success", {
			transaction_id: "{{ $order->orderNumber }}",
			value: "{{ number_format($order->totalCart, 2, '.', '') }}",
			currency: "THB",
			items: [
				@foreach ($order->tb_order_details as $product)
				{
					item_id: "{{ $product->product_sku }}",
					item_name: "{{ $product->product_name }}",
					item_brand: "",
					price: "{{ number_format(($product->product_price), 2, '.', '') }}",
					quantity: "{{ $product->product_unit }}"
				},
				@endforeach
			]
		});
	});
</script>
@endif

<?php
	$is_sketchup = '';
	if(!empty($order)){
		
		foreach($order->tb_order_details as $pd){
			if(strpos(strtolower($pd['product_name']), 'sketch') !== FALSE){
				if($is_sketchup == ''){
?>
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
<?php
					$is_sketchup = 'Sketchup';
				}
			}
		}
		
?>
<script>
fbq('track', 'Purchase', {
	contents: [
<?php
		$linepd = 1;
		foreach($order->tb_order_details as $pd2){
?>
	{
		id:"<?php echo $pd2['product_sku']; ?>"
		,quantity:"<?php echo $pd2['product_unit']; ?>"
		,brand:"<?php echo $is_sketchup; ?>"
		,name:"<?php echo $pd2['product_name']; ?>"
		,item_price:"<?php echo number_format(($pd2->product_price), 2, '.', ''); ?>"
	}
<?php
			if($linepd != 1){
				echo ',';
			}
			$linepd++;
		}
?>
	],
	currency: "THB",
	value: "<?php echo number_format($order->totalCart, 2, '.', ''); ?>"
});
</script>
<?php
	}
?>
	  
  
 @endsection