<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="csrf-token" content="{{ csrf_token() }}" />
		<title>Material | 8Baht</title>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
		<script src="https://kit.fontawesome.com/4492e5df9e.js" crossorigin="anonymous"></script>
		
		<link href="https://phpstack-1646968-6541058.cloudwaysapps.com/assets/fontend/styles/macustom.css" rel="stylesheet" type="text/css" />
		
		<style id="fit-vids-style">
			.fluid-width-video-wrapper{width:100%;position:relative;padding:0;}.fluid-width-video-wrapper iframe,.fluid-width-video-wrapper object,.fluid-width-video-wrapper embed {position:absolute;top:0;left:0;width:100%;height:100%;}
		</style>
		
	</head>
	<body>
	
		<?php
			$arr_machine = array('ultimaker'=>'https://phpstack-1646968-6541058.cloudwaysapps.com/images/vendorlogo/ultimaker.png'
									,'raise3d'=>'https://phpstack-1646968-6541058.cloudwaysapps.com/images/vendorlogo/raise3d.png'
									,'bcn3d'=>'https://phpstack-1646968-6541058.cloudwaysapps.com/images/vendorlogo/bcn3d.png'
									,'intamsys'=>'https://phpstack-1646968-6541058.cloudwaysapps.com/images/vendorlogo/intamsys.png'
									,'prusa'=>'https://phpstack-1646968-6541058.cloudwaysapps.com/images/vendorlogo/prusa.png'
									,'bambulab'=>'https://phpstack-1646968-6541058.cloudwaysapps.com/images/vendorlogo/bambulab.png'
									,'lulzbot'=>'https://phpstack-1646968-6541058.cloudwaysapps.com/images/vendorlogo/lulzbot.png'
									,'bigrep'=>'https://phpstack-1646968-6541058.cloudwaysapps.com/images/vendorlogo/bigrep.png');
			$arr_application = array('car'=>'Automotive','plug-circle-bolt'=>'Electronic','plane-departure'=>'Aerospace','receipt'=>'Prototype','robot'=>'Machine Build','puzzle-piece'=>'Jig Fixture','gears'=>'Spare Parts','circle-question'=>'Other');
			$arr_material_character = array('Engineering Material','Metal','ESD','Support Material','Food Contact','Bio Compatible','Hi Strength','Hi Temp','Flexible');
			$arr_sustainable_check = array('Bio-Derived','Recycled Packaging','Generally recyclable');
		?>
		<div class="container-fluid">
		
			<div class="title">
				Step 1 - Choose Machine Compatible
			</div>

			<div class="row align-items-start">
			
				<?php
					$maline = 0;
					foreach($arr_machine as $value => $img){
				?>
				<div class="col-6 col-sm-3">
					<label class="option_item">
						<input type="checkbox" class="checkbox" id="machine_<?php echo $maline++; ?>" name="machine" value="<?php echo $value; ?>" onClick="searchMa('app_part');">
						<div class="option_inner ggreen">
							<div class="tickmark"></div>
							<div class="icon"><img src="<?php echo $img; ?>" width="170"></div>
						</div>
					</label>
				</div>
				<?php
					}
				?>
				
			</div>
			
			<div class="title mt-60" id="app_part">
				Step 2 - Choose application
			</div>

			<div class="row align-items-start">
			
				<?php
					$appline = 0;
					foreach($arr_application as $icon => $app){
				?>
				<div class="col-6 col-sm-3">
					<label class="option_item">
						<input type="checkbox" class="checkbox" id="application_<?php echo $appline++; ?>" name="spec" value="<?php echo $app; ?>" onClick="searchMa('mc_part');">
						<div class="option_inner ggreen">
							<div class="tickmark"></div>
							<div class="icon"><i class="fa-solid fa-<?php echo $icon; ?>"></i></div>
							<div class="name"><?php echo $app; ?></div>
						</div>
					</label>
				</div>
				<?php
					}
				?>
				
			</div>
			
			<div class="title mt-60" id="mc_part">
				Step 3 - Choose Material Character
			</div>
			
			<div class="row">
				<ul class="ks-cboxtags">
					<?php
						$maline = 1;
						foreach($arr_material_character as $ma){
					?>
					<li><input type="checkbox" id="material_character_<?php echo $maline; ?>"  name="spec" value="<?php echo $ma; ?>" onClick="searchMa('sc_part');"><label for="material_character_<?php echo $maline; ?>"><?php echo $ma; ?></label></li>
					<?php
							$maline++;
						}
					?>
				</ul>

			</div>
			
			<div class="title mt-60" id="sc_part">
				Step 4 - Choose Sustainable Check
			</div>
			
			<div class="row">
				<ul class="ks-cboxtags">
					<?php
						$susline = 1;
						foreach($arr_sustainable_check as $sus){
					?>
					<li><input type="checkbox" id="sustainable_check_<?php echo $susline; ?>" name="spec" value="<?php echo $sus; ?>" onClick="searchMa('result_ma');"><label for="sustainable_check_<?php echo $susline; ?>"><?php echo $sus; ?></label></li>
					<?php
							$susline++;
						}
					?>
				</ul>
			</div>
			
			
			<!-- Results -->
			<div id="result_ma" class="row mt-60">
			
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
			</div>
			
		</div>
		
		<!-- Modal -->
		<div class="modal fade" id="modal8baht" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
				<div class="modal-content">
					
					<div class="modal-body">
						<div class="row text-right">
							<div class="col-12">
								<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
							</div>
						</div>
						<div id="modal_content"></div>
					</div>
					
				</div>
			</div>
		</div>

		<script type="text/javascript" src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
		<script type="text/javascript">
			function detailView(permalink){
				
				$.ajax({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					type: "GET",
					url: "{{ route('fronend.material.product', '') }}",
					data: {"permalink": permalink, "_token": "{{ csrf_token() }}"},
					cache: false,
					success: function(response){
						
						$('#modal_content').html(response);
						$('#modal8baht').modal('show');
						
					}
				});
				
			}
			
			function searchMa(div_id){
				
				$(document.body).css({'cursor' : 'wait'});
				
				const arr_spec = new Array();
				$("input:checkbox[name=spec]:checked").each(function(){
					arr_spec.push($(this).val());
				});
				
				const arr_machine = new Array();
				$("input:checkbox[name=machine]:checked").each(function(){
					arr_machine.push($(this).val());
				});
				
				$.ajax({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					type: "GET",
					url: "{{ route('fronend.material.list', '') }}",
					data: {"arr_spec": arr_spec, "arr_machine": arr_machine, "_token": "{{ csrf_token() }}"},
					cache: false,
					success: function(response){
						
						$(document.body).css({'cursor' : 'default'});
						
						$('#result_ma').html(response);

						
						$('html, body').animate({
							scrollTop: $("#"+div_id).offset().top
						}, 500);
						
					}
				});
				
			}
		</script>
	
	</body>
</html>