<?php
ob_start();
error_reporting(0);
header('Content-type:application/json;charset=utf-8');
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
?>
<h4 class="text-right">
	<button type="button" class="btn btn-light"><img src="https://phpstack-1646968-6541058.cloudwaysapps.com/assets/fontend/images/clear-filters.png" width="30"> &nbsp; Clear Filter</button>
	<br><br>
	Material <strong class="text-danger"><?php echo count($data); ?></strong> Item(s)
</h4>
<?php

if(count($data) != 0){
	foreach($data as $product){
?>
	<div class="col-6 col-sm-3">
		<div class="category_page clearfix">
		
			<div class="product_img">
				<a href="javascript:void(0);" onClick="detailView('{{ $product['permalink'] }}');">
				@isset($product['pictureName'])
					<img width="150" height="150" src="{{ $product['pictureName'] }}" alt="{{ $product['name']}}" >
				@else
					<img width="150" height="150" src="{{ asset('images/default-img/no-img.jpg')}}" alt="{{ $product['name'] }}" >
				@endisset
				</a>
			</div>
			
			<div class="product_name" style="height : 60px;">
				{{ shortStr($product['name'], 60) }}
			</div>
		
			<div class="product_button">
				<button type="button" class="btn btn-success" onClick="detailView('{{ $product['permalink'] }}');"><i class="fa fa-search"></i> ดูรายละเอียด</button>
			</div>
		</div>
	</div>
<?php
	}
}else{
?>
<div class="title">
	ไม่พบข้อมูล
</div>
<?php
}
?>