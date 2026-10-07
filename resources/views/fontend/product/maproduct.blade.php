@php
	ob_start();
	error_reporting(0);
	header('Content-type:application/json;charset=utf-8');
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Access-Control-Allow-Origin: *");
@endphp
<div class="row bg-info">
	<div class="col-12 col-sm-12">
		<img src="{{ $data['brand_logo'] }}" width="200">
		<span class="align-middle ms-1 fs-5 text-white fw-bold">{{ $data['name'] }}</span>
	</div>
</div>

<div class="row mt-2">
	<div class="col-12 col-sm-4 text-center">
		<img src="{{ $data['pictureName'] }}" width="100%">
	</div>
	<div class="col-12 col-sm-8 ps-2">
		<span class="align-middle ">
			{!! $data['pro_highlight'] !!}
			<center>
				<a href="https://phpstack-1646968-6541058.cloudwaysapps.com/product/{{ $data['permalink'] }}?ref=applicad" target="_blank"><button type="button" class="btn btn-danger"><i class="fa fa-file-invoice"></i> &nbsp; ขอใบเสนอราคา</button></a>
				<a href="https://phpstack-1646968-6541058.cloudwaysapps.com/product/{{ $data['permalink'] }}?ref=applicad" target="_blank"><img src="https://phpstack-1646968-6541058.cloudwaysapps.com/assets/fontend/images/line-button.png" height="45"></a>
			</center>
		</span>
	</div>
</div>

<div class="row mt-3">
	<div class="col-12 col-sm-12">
		{!! $data['pro_content'] !!}
	</div>
</div>
