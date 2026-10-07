@extends('layouts.temp_admin')
@section('title'){{$title_page}}@endsection

@section('css')
	
	<style>
        .card-status {
            text-align: center;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 8px;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .card-status h5 {
            font-size: 0.9rem;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .count-order {
            font-size: 1.5rem;
            color: #333;
            font-weight: bold;
            flex-grow: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .total-price {
            font-size: 0.8rem;
            color: #6c757d;
            align-self: flex-end;
        }
        .chart-table-container {
            display: flex;
            flex-direction: column;
        }
        @media (min-width: 768px) {
            .chart-table-container {
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
            }
        }
        .chart-container, .table-container {
            width: 100%;
			height: 500px;
        }
        .table-container table {
            font-size: 0.8rem;
        }
    </style>
@endsection

@section('content')

	<div class="row mt-3">
		<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 mb-4">
			<div class="row">
				<div class="col-12">
					<div class="card card-stats">
						<div class="card-body">
							<div class="row">
								<div class="col-5 col-md-4">
									<div class="icon-big icon-warning pl-3">
										<i class="nc-icon nc-money-coins text-success"></i>
									</div>
								</div>
								<div class="col-7 col-md-8">
									<div class="numbers">
									<p class="card-category text-success font-weight-bold">ออเดอร์วันนี้</p>
									<p class="card-title">{{ !empty($orderToday) ? number_format($orderToday->order_today) : 0 }}</p>
									</div>
								</div>
							</div>
						</div>
						<div class="card-footer">
						<hr>
						<div class="stats text-right">฿{{ !empty($orderToday) ? number_format($orderToday->value_today) : 0 }}</div>
						</div>
					</div>
				</div>
				<div class="col-12">
					<div class="card card-stats">
						<div class="card-body ">
							<div class="row">
								<div class="col-5 col-md-4">
									<div class="icon-big icon-warning pl-3">
										<i class="nc-icon nc-paper text-danger"></i>
									</div>
								</div>
								<div class="col-7 col-md-8">
									<div class="numbers">
									<p class="card-category text-danger font-weight-bold">ใบเสนอราคาวันนี้</p>
									<p class="card-title">{{ !empty($quotationToday) ? number_format($quotationToday->q_today) : 0 }}</p>
									</div>
								</div>
							</div>
						</div>
						<div class="card-footer">
						<hr>
						<div class="stats text-right">฿{{ !empty($quotationToday) ? number_format($quotationToday->q_value_today) : 0 }}</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-8 col-md-8 col-sm-6 col-xs-6 mb-4">
			<div class="row">
			<?php
				foreach ($orderStatus as $odStatus) {
					echo '<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 mb-4">';
					echo '  <div class="card card-status">';
					echo '    <h5>'.$odStatus->status_name.'</h5>';
					echo '    <div class="count-order">'.$odStatus->count_order.'</div>';
					echo '    <div class="total-price">฿'.number_format($odStatus->total_price).'</div>';
					echo '  </div>';
					echo '</div>';
				}
				?>
			</div>
		</div>
	</div>

		<!-- Monthly Sales Report by Value -->
		<div class="card mb-4">
			<div class="card-body">
				<h5 class="card-title">ยอดขายรายเดือน</h5>
				<div class="chart-container">
					<canvas id="salesValueChart"></canvas>
				</div>
				<div class="table-container mt-4">
					<table class="table table-bordered">
						<thead class="table-primary">
							<tr align="center">
								<th>&nbsp;</th>
								@php
									$arr_month = ["ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."];
								@endphp
								@foreach($arr_month as $month_name)
								<th>{{ $month_name }}</th>
								@endforeach
								<th>รวม</th>
							</tr>
						</thead>
						<tbody>
							<tr align="right" class="font-weight-bold">
								<td align="center">{{ date('Y') }}</td>
								@foreach($monthlySalesCurrent as $value)
								<td>{{ number_format($value) }}</td> <!-- เอาทศนิยมออก -->
								@endforeach
								<td>{{ number_format($totalSalesCurrent) }}</td>
							</tr>
							<tr align="right" class="text-secondary">
								<td align="center" class="font-weight-bold">{{ (date('Y')-1) }}</td>
								@foreach($monthlySalesPrevious as $value)
								<td>{{ number_format($value) }}</td> <!-- เอาทศนิยมออก -->
								@endforeach
								<td>{{ number_format($totalSalesPrevious) }}</td>
							</tr>
							<tr class="font-weight-bold" align="right">
								<td align="center">% G</td>
								@foreach($monthlyGrowth as $growth)
									@if($growth >= 0)
								<td class="text-success">▲ {{ $growth !== null ? number_format($growth) . '%' : 'N/A' }}</td> <!-- เอาทศนิยมออก -->
									@else
								<td class="text-danger">▼ {{ $growth !== null ? number_format($growth) . '%' : 'N/A' }}</td> <!-- เอาทศนิยมออก -->
									@endif
								@endforeach
								@if($totalGrowth >= 0)
								<td class="text-success">▲ {{ $totalGrowth !== null ? number_format($totalGrowth) . '%' : 'N/A' }}</td> <!-- รวมเปอร์เซ็นต์ Growth -->
								@else
								<td class="text-danger">▼ {{ $totalGrowth !== null ? number_format($totalGrowth) . '%' : 'N/A' }}</td> <!-- รวมเปอร์เซ็นต์ Growth -->
								@endif
							</tr>
						</tbody>
					</table>
				</div>

			</div>
		</div>

		<!-- Monthly Sales Report by Order -->
		<div class="card mb-4">
			<div class="card-body">
				<h5 class="card-title">ออเดอร์รายเดือน</h5>
				<div class="chart-container">
					<canvas id="orderChart"></canvas>
				</div>
				<div class="table-container mt-4">
					<table class="table table-bordered">
						<thead class="table-warning">
							<tr align="center">
								<th>&nbsp;</th>
								@foreach($arr_month as $month_name)
								<th>{{ $month_name }}</th>
								@endforeach
								<th>รวม</th>
							</tr>
						</thead>
						<tbody>
							<tr align="right" class="font-weight-bold">
								<td align="center">{{ date('Y') }}</td>
								@foreach($monthlyOrderCurrent as $value)
								<td>{{ number_format($value) }}</td> <!-- เอาทศนิยมออก -->
								@endforeach
								<td>{{ number_format($totalOrderCurrent) }}</td>
							</tr>
							<tr align="right" class="text-secondary">
								<td align="center" class="font-weight-bold">{{ (date('Y')-1) }}</td>
								@foreach($monthlyOrderPrevious as $value)
								<td>{{ number_format($value) }}</td> <!-- เอาทศนิยมออก -->
								@endforeach
								<td>{{ number_format($totalOrderPrevious) }}</td>
							</tr>
							<tr class="font-weight-bold" align="right">
								<td align="center">% G</td>
								@foreach($monthlyOrderGrowth as $growth)
									@if($growth >= 0)
								<td class="text-success">▲ {{ $growth !== null ? number_format($growth) . '%' : 'N/A' }}</td> <!-- เอาทศนิยมออก -->
									@else
								<td class="text-danger">▼ {{ $growth !== null ? number_format($growth) . '%' : 'N/A' }}</td> <!-- เอาทศนิยมออก -->
									@endif
								@endforeach
								@if($totalOrderGrowth >= 0)
								<td class="text-success">▲ {{ $totalOrderGrowth !== null ? number_format($totalOrderGrowth) . '%' : 'N/A' }}</td> <!-- รวมเปอร์เซ็นต์ Growth -->
								@else
								<td class="text-danger">▼ {{ $totalOrderGrowth !== null ? number_format($totalOrderGrowth) . '%' : 'N/A' }}</td> <!-- รวมเปอร์เซ็นต์ Growth -->
								@endif
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<!-- Top 10 Products by Quantity Sold -->
		<div class="card mb-4">
			<div class="card-body">
				<h5 class="card-title">10 อันดับ สินค้าขายดี</h5>
				<div class="chart-table-container">
					<div class="chart-container">
						<canvas id="topQuantityChart"></canvas>
					</div>
					<div class="table-container">
						<table class="table table-striped table-bordered">
							<thead class="table-dark">
								<tr>
									<th>SKU Name</th>
									<th align="right">จำนวน</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($topProducts as $top_product)
								<tr>
									<td>{{ $top_product->product_name }}</td>
									<td align="right">{{ number_format($top_product->count_qty) }}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>

		<!-- Top 10 Products by Total Sales -->
		<div class="card mb-4">
			<div class="card-body">
				<h5 class="card-title">10 อันดับ สินค้ายอดขายสูงสุด</h5>
				<div class="chart-table-container">
					<div class="table-container">
						<table class="table table-striped table-bordered">
							<thead class="table-dark">
								<tr>
									<th>SKU Name</th>
									<th align="right">ราคารวม</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($topSellingProducts as $top_sell_product)
								<tr>
									<td>{{ $top_sell_product->product_name }}</td>
									<td align="right">{{ number_format($top_sell_product->sum_product_price_total) }}</td>
								</tr>
								@endforeach
							</tbody>
						</table>

					</div>
					<div class="chart-container">
						<canvas id="topSalesChart"></canvas>
					</div>
				</div>
			</div>
		</div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <script>
		const monthlySalesCurrent = @json($monthlySalesCurrent);
		const monthlySalesPrevious = @json($monthlySalesPrevious);
		
		const monthlyOrderCurrent = @json($monthlyOrderCurrent);
		const monthlyOrderPrevious = @json($monthlyOrderPrevious);
		
		const topProductNames = @json($topProducts->pluck('product_name')->map(function ($name) {
			return \Illuminate\Support\Str::limit($name, 25, '...'); // ตัดชื่อให้เหลือ 30 ตัวอักษร
		}));
		const topQuantities = @json($topProducts->pluck('count_qty')); // จำนวนขาย
		
		const topSellProductNames = @json($topSellingProducts->pluck('product_name')->map(function ($name) {
			return \Illuminate\Support\Str::limit($name, 25, '...'); // ตัดชื่อให้เหลือ 30 ตัวอักษร
		}));
		const topSellPrice = @json($topSellingProducts->pluck('sum_product_price_total')); // จำนวนขาย
		
	
        document.addEventListener("DOMContentLoaded", function() {
			
            const ctxSalesValue = document.getElementById('salesValueChart').getContext('2d');

			new Chart(ctxSalesValue, {
				type: 'line',
				data: {
					labels: @json($arr_month), // ชื่อเดือน
					datasets: [
						{
							label: '{{ date('Y') }}', // ปีปัจจุบัน
							data: @json($monthlySalesCurrent), // ข้อมูลปีปัจจุบัน
							borderColor: '#80bdff', // สีเส้นปีปัจจุบัน
							backgroundColor: 'rgba(106, 178, 255, 0.2)', // สีพื้นหลัง
							fill: true, // เติมสีพื้นหลัง
						},
						{
							label: '{{ date('Y')-1 }}', // ปีที่แล้ว
							data: @json($monthlySalesPrevious), // ข้อมูลปีที่แล้ว
							borderColor: '#d1d1d1', // สีเส้นปีที่แล้ว
							backgroundColor: 'rgba(209, 209, 209, 0.2)', // สีพื้นหลังโปร่งใส
							fill: false, // ไม่เติมสีพื้นหลัง
							borderDash: [5, 5], // เส้นประ
						}
					]
				},
				options: {
					responsive: true,
					maintainAspectRatio: false,
					plugins: {
						datalabels: {
							display: (context) => {
								// แสดง datalabels เฉพาะปีปัจจุบัน (datasetIndex === 0)
								return context.datasetIndex === 0;
							},
							color: (context) => {
								// แยกสี datalabels ตาม dataset
								return context.datasetIndex === 0 ? '#007aff' : '#808080';
							},
							backgroundColor: '#ffffe6', // สีพื้นหลัง
							borderRadius: 5, // ความโค้งของมุม
							padding: 1, // ระยะขอบด้านในของ label
							font: {
								weight: 'bold', // ตัวหนา
							},
							align: (context) => {
								return context.datasetIndex === 0 ? 'top' : 'bottom'; // ปีปัจจุบันอยู่ด้านบน ปีที่แล้วอยู่ด้านล่าง
							},
							anchor: (context) => {
								return context.datasetIndex === 0 ? 'end' : 'start'; // จุดยึดตำแหน่ง
							},
							formatter: (value) => Math.round(value).toLocaleString(),
						},
						legend: {
							position: 'top', // ตำแหน่ง Legend
						}
					},
					scales: {
						x: {
							title: {
								display: true,
								text: 'เดือน', // ชื่อแกน X
								font: {
									size: 14,
									weight: 'bold',
								}
							}
						},
						y: {
							title: {
								display: true,
								text: 'ยอดขาย (฿)', // ชื่อแกน Y
								font: {
									size: 14,
									weight: 'bold',
								}
							},
							beginAtZero: true, // เริ่มจากศูนย์
						}
					}
				},
				plugins: [ChartDataLabels]
			});


            const ctxOrder = document.getElementById('orderChart').getContext('2d');
            new Chart(ctxOrder, {
				type: 'line',
				data: {
					labels: @json($arr_month), // ชื่อเดือน
					datasets: [
						{
							label: '{{ date('Y') }}', // ปีปัจจุบัน
							data: @json($monthlyOrderCurrent), // ข้อมูลปีปัจจุบัน
							borderColor: '#fffd80', // สีเส้นปีปัจจุบัน
							backgroundColor: 'rgba(255, 254, 200, 0.2)', // สีพื้นหลัง
							fill: true, // เติมสีพื้นหลัง
						},
						{
							label: '{{ date('Y')-1 }}', // ปีที่แล้ว
							data: @json($monthlyOrderPrevious), // ข้อมูลปีที่แล้ว
							borderColor: '#d1d1d1', // สีเส้นปีที่แล้ว
							backgroundColor: 'rgba(209, 209, 209, 0.2)', // สีพื้นหลังโปร่งใส
							fill: false, // ไม่เติมสีพื้นหลัง
							borderDash: [5, 5], // เส้นประ
						}
					]
				},
				options: {
					responsive: true,
					plugins: {
						datalabels: {
							display: (context) => {
								// แสดง datalabels เฉพาะปีปัจจุบัน (datasetIndex === 0)
								return context.datasetIndex === 0;
							},
							color: (context) => {
								// แยกสี datalabels ตาม dataset
								return context.datasetIndex === 0 ? '#b4b100' : '#808080';
							},
							backgroundColor: '#fceeff', // สีพื้นหลัง
							borderRadius: 5, // ความโค้งของมุม
							padding: 1, // ระยะขอบด้านในของ label
							font: {
								weight: 'bold', // ตัวหนา
							},
							align: (context) => {
								return context.datasetIndex === 0 ? 'top' : 'bottom'; // ปีปัจจุบันอยู่ด้านบน ปีที่แล้วอยู่ด้านล่าง
							},
							anchor: (context) => {
								return context.datasetIndex === 0 ? 'end' : 'start'; // จุดยึดตำแหน่ง
							},
							formatter: (value) => Math.round(value).toLocaleString(),
						},
						legend: {
							position: 'top', // ตำแหน่ง Legend
						}
					},
					scales: {
						x: {
							title: {
								display: true,
								text: 'เดือน', // ชื่อแกน X
								font: {
									size: 14,
									weight: 'bold',
								}
							}
						},
						y: {
							title: {
								display: true,
								text: 'จำนวนออเดอร์', // ชื่อแกน Y
								font: {
									size: 14,
									weight: 'bold',
								}
							},
							beginAtZero: true, // เริ่มจากศูนย์
						}
					}
				},
				plugins: [ChartDataLabels]
			});

            const ctxTopQuantity = document.getElementById('topQuantityChart').getContext('2d');
			new Chart(ctxTopQuantity, {
				type: 'doughnut',
				data: {
					labels: topProductNames, // ชื่อสินค้า
					datasets: [{
						label: 'Quantity Sold',
						data: topQuantities, // จำนวนขาย
						backgroundColor: [
							'#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', 
							'#9966FF', '#FF9F40', '#FF6384', '#36A2EB', 
							'#FFCE56', '#4BC0C0'
						]
					}]
				},
				options: {
					responsive: true,
					plugins: {
						datalabels: {
							color: '#fff',
							formatter: (value) => Math.round(value).toLocaleString(),
							font: { weight: 'bold' }
						}
					}
				},
				plugins: [ChartDataLabels]
			});

            const ctxTopSales = document.getElementById('topSalesChart').getContext('2d');
            new Chart(ctxTopSales, {
				type: 'doughnut',
				data: {
					labels: topSellProductNames, // ชื่อสินค้า
					datasets: [{
						label: 'Total Sales',
						data: topSellPrice, // จำนวนขาย
						backgroundColor: [
							'#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', 
							'#9966FF', '#FF9F40', '#FF6384', '#36A2EB', 
							'#FFCE56', '#4BC0C0'
						]
					}]
				},
				options: {
					responsive: true,
					plugins: {
						datalabels: {
							color: '#fff',
							formatter: (value) => Math.round(value).toLocaleString(),
							font: { weight: 'bold' }
						}
					}
				},
				plugins: [ChartDataLabels]
			});
        });
    </script>
@endsection
