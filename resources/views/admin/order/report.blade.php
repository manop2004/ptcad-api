@extends('layouts.temp_admin')
@section('title'){{$title_page}}@endsection

@section('css')

<link rel="stylesheet" href="{{ asset('assets/backend/js/plugins/buttons.dataTables.min.css') }}">
 <!-- select2 -->
 <link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet" />
 <!-- select2-bootstrap4-theme -->
 <link href="{{ asset('vendor/select2-bootstrap4-theme/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="card card-stats">
        <div class="card-body ">
          <div class="row">
            <div class="col-5 col-md-4">
              <div class="icon-big text-center icon-warning">
                <i class="nc-icon nc-calendar-60 text-warning"></i>
              </div>
            </div>
            <div class="col-7 col-md-8">
              <div class="numbers">
                <p class="card-category">ยอดขายวันนี้</p>
                <p class="card-title" id="orderToday">{{ number_format($orderToday)}}
                  <p>
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer ">
          <hr>
          <div class="stats"></div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="card card-stats">
        <div class="card-body ">
          <div class="row">
            <div class="col-5 col-md-4">
              <div class="icon-big text-center icon-warning">
                <i class="nc-icon nc-money-coins text-success"></i>
              </div>
            </div>
            <div class="col-7 col-md-8">
              <div class="numbers">
                <p class="card-category">ชำระเงินแล้ว</p>
                <p class="card-title" id="orderWait">{{ number_format($orderWait)}}
                  <p>
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer ">
          <hr>
          <div class="stats"></div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="card card-stats">
        <div class="card-body ">
          <div class="row">
            <div class="col-5 col-md-4">
              <div class="icon-big text-center icon-warning">
                <i class="nc-icon nc-paper text-danger"></i>
              </div>
            </div>
            <div class="col-7 col-md-8">
              <div class="numbers">
                <p class="card-category">รายการขาย (ค้างชำระ)</p>
                <p class="card-title" id="orderList">{{ number_format($orderList)}}<p>
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer ">
          <hr>
          <div class="stats"></div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="card card-stats">
        <div class="card-body ">
          <div class="row">
            <div class="col-5 col-md-4">
              <div class="icon-big text-center icon-warning">
                <i class="nc-icon nc-credit-card text-info"></i>
              </div>
            </div>
            <div class="col-7 col-md-8">
              <div class="numbers">
                <p class="card-category">ยอดขายทั้งสิ้น (ยอดรวม)</p>
                <p class="card-title" id="orderAll">{{ number_format($orderAll)}}<p>
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer ">
          <hr>
          <div class="stats"></div>
        </div>
      </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-4 col-md-6 col-sm-6">
        <div class="card card-chart">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-info">ช่องทางการชำระเงิน</h6>
                    </div>
                    <div class="col-md-6">
                        <div class="wh-10 op_m_1 nline-block"></div><small id="op_m_1"></small><br/>
                        <div class="wh-10 op_m_2 nline-block"></div><small id="op_m_2"></small><br/>
                        <div class="wh-10 op_m_3 nline-block"></div><small id="op_m_3"></small><br/>
						<div class="wh-10 op_m_4 nline-block"></div><small id="op_m_4"></small><br/>
                        <div class="wh-10 op_m_5 nline-block"></div><small id="op_m_5"></small><br/>
                        <div class="wh-10 op_m_6 nline-block"></div><small id="op_m_6"></small><br/>
                    </div>
                    <div class="col-12 p-t-20">
                        @if ($order != 0)
							<div style="height: 150px; width: 100%;">
								<canvas id="orderPayment" height="150"></canvas>
							</div>
                        @else
                            <center>
                                <br/>
                                <h5>ยังไม่มีข้อมูลการสั่งซื้อ</h5>
                                <br/>
                            </center>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-chart">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <h6 class="text-info">สถานะการสั่งซื้อ</h6>
                        <br/>
                    </div>
                    <div class="col-md-12">
						<div style="height: 160px; width: 100%;">
							<canvas id="business" height="160"></canvas>
						</div>
                    </div>
                    <div class="col-md-12">
                        <br/>
                        <ul id="displayStatusOrder"></ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="col-lg-8 col-md-6 col-sm-6">
        <div class="card shadow mb-4">
            <div class="card-header">
                <br/>
                <div class="row">
                    <div class="col-xl-6 col-lg-12 col-md-12 vertical-bottom">
                        <div class="form-group">
                        <h4 class="m-0 font-weight-bold text-primary align-bottom" >ยอดสะสมการสั่งซื้อสูงสุด 10 อันดับแรก</h4>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <div class="form-group">
                            <select id="month" name="month" class="form-control" onchange="callChange(this)">
                                <option value="">-- เลือกเดือน --</option>
                                <option value="01">มกราคม</option>
                                <option value="02">กุมภาพันธ์</option>
                                <option value="03">มีนาคม</option>
                                <option value="04">เมษายน</option>
                                <option value="05">พฤษภาคม</option>
                                <option value="06">มิถุนายน</option>
                                <option value="07">กรกฏาคม</option>
                                <option value="08">สิงหาคม</option>
                                <option value="09">กันยายน</option>
                                <option value="10">ตุลาคม</option>
                                <option value="11">พฤศจิกายน</option>
                                <option value="12">ธันวาคม</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <div class="form-group">
                            <select id="year" name="year" class="form-control" onchange="callChange(this)">
                                <option value="">-- เลือกปี --</option>
                                @php
                                    $firstYear = (int)date('Y')-4;
                                    $lastYear = date('Y');
                                    for($i=$firstYear;$i<=$lastYear;$i++)
                                    {
                                        echo '<option value='.$i.'>'.($i).'</option>';
                                    }
                                @endphp
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="userOrder" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th class="bg-table-head" style="width: 120px">รหัสลูกค้า</th>
                            <th class="bg-table-head" style="min-width: 400px">ชื่อ - นามสกุล</th>
                            <th class="bg-table-head" style="width: 200px">ยอดสั่งซื้อรวมทั้งสิ้น</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<!-- select2 -->
<script src="{{ asset('vendor/select2/select2.min.js') }}"></script>
<!-- select2-bootstrap4-theme -->
<script src="{{ asset('vendor/select2-bootstrap4-theme/docs/script.js') }}"></script>
<!--  DataTables.net Plugin, full documentation here: https://datatables.net/    -->
<script src="{{ asset('assets/backend/js/plugins/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/backend/js/plugins/dataTables.buttons.min.js') }}"></script>
<!-- Chart JS -->
<script src="{{ asset('assets/backend/js/plugins/chartjs.min.js') }}"></script>
<script src="{{ asset('assets/backend/demo/demo.js') }}"></script>
<script>

	var paymentChart = null;
	var statusChart = null;
	
	function callChange() {
		
		let month = $("#month").val();
		let year = $("#year").val();

		reloadOrderSummaryCards(month, year);
		reloadOrderPaymentChart(month, year);
		reloadOrderStatusChart(month, year);
		$('#userOrder').DataTable().ajax.reload();
		
	}
	
	// 1. อัปเดต Card ตัวเลขหลัก (ยอดขายวันนี้/ทั้งหมด ฯลฯ)
	function reloadOrderSummaryCards(month, year) {
		$.ajax({
			type: "GET",
			url: "{{ route('order.report.summary') }}",
			data: { month: month, year: year },
			success: function(res) {
				$("#orderToday").text(res.orderToday);
				$("#orderWait").text(res.orderWait);
				$("#orderList").text(res.orderList);
				$("#orderAll").text(res.orderAll);
			}
		});
	}
	
	// 2. อัปเดตกราฟช่องทางการชำระเงิน
	var repeatPurchaseChart = null;
	function reloadOrderPaymentChart(month, year) {
		$.ajax({
			type: "GET",
			url: "{!! route('order.report.orderpayment') !!}",
			data: {month: month, year: year},
			success: function (response) {

				if(response != false){

					$('#op_m_1').html(response.d_type1);
					$('#op_m_2').html(response.d_type2);
					$('#op_m_3').html(response.d_type3);
					$('#op_m_4').html(response.d_type4);
					$('#op_m_5').html(response.d_type5);
					$('#op_m_6').html(response.d_type6);

					$('#orderPayment').replaceWith('<canvas id="orderPayment"></canvas>');
					var ctx = document.getElementById('orderPayment').getContext('2d');
					ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height);
					
					if (repeatPurchaseChart) {
						repeatPurchaseChart.destroy();
					}
					
					repeatPurchaseChart = new Chart(ctx, {
						type: 'bar',
						data: {
							labels: ["บัญชีธนาคาร", "บัตรเครดิต", "ผ่อนชำระ", "พร้อมเพย์", "โมบายแบงค์กิ้ง", "ทรูมันนี่"],
							datasets: [{
								data: [response.p_type1,response.p_type2,response.p_type3,response.p_type4,response.p_type5,response.p_type6],
								backgroundColor: ['#0abde3','#ff9f43','#833471','#00b894','#e17055','#6c5ce7'],
								hoverBackgroundColor: ['#0abde3','#ff9f43','#833471','#00b894','#e17055','#6c5ce7'],
								hoverBorderColor: "rgba(234, 236, 244, 1)",
							}],
						},
						options: {
							scales: {
								yAxes: [{
									display: true,
									ticks: {
										beginAtZero: true,
										min: 0
									}
								}]
							},
							maintainAspectRatio: false,
							tooltips: {
								backgroundColor: "#000",
								bodyFontColor: "#FFF",
								borderColor: '#dddfeb',
								borderWidth: 1,
								xPadding: 15,
								yPadding: 15,
								displayColors: false,
								caretPadding: 10,
							},
							legend: {
								display: false
							},
							cutoutPercentage: 0,
						},
					});
				}

			},
			failure: function (errMsg) {
				alert(errMsg);
			}
		});
	}
	
	// 3. อัปเดตกราฟสถานะออเดอร์
	var repeatStatusChart = null;
	function reloadOrderStatusChart(month, year) {
		$.ajax({
			type: "GET",
			url: "{!! route('order.report.json.statusOrder') !!}",
			data: {month: month, year: year},
			success: function (response) {

				if(response != false){
					var typeName        = [];
					var typeValue       = [];
					var typeDisplay     = [];

					$.each(response, function (index, item) {

						typeName.push(item.status_name_);
						typeValue.push(item.status_count_);
						typeDisplay.push(item.display_status_);

					});

					$('#displayStatusOrder').html(typeDisplay);

					console.log(typeDisplay);
					
					$('#business').replaceWith('<canvas id="business"></canvas>');
					var business = document.getElementById('business').getContext('2d');
					business.clearRect(0, 0, business.canvas.width, business.canvas.height);
										
					if (repeatStatusChart) {
						repeatStatusChart.destroy();
					}

					repeatStatusChart = new Chart(business, {
						type: 'line',
						data: {
							labels: typeName,
							datasets: [
							{
								label: " จำนวน/คน ",
								fill: true,
								borderColor: "#7f8c8d",
								backgroundColor: "#bdc3c7",
								borderWidth: 1,
								data: typeValue,
							}
							]
						},
						options: {
							tooltips: {
								display: true
							},
							legend: {
								display: false
							},
							scales: {
								yAxes: [{
									ticks: {
										fontColor: "#9f9f9f",
										beginAtZero: true,
										maxTicksLimit: 5,
									},
									gridLines: {
										drawBorder: false,
										borderDash: [8, 5],
										zeroLineColor: "transparent",
										color: '#9f9f9f'
									}
								}],
								xAxes: [{
									offset: 10,
									ticks: {
										display: false,
									},
									gridLines: {
										drawBorder: false,
										borderDash: [8, 5],
										zeroLineColor: "transparent",
										color: '#9f9f9f'
									}
								}]
							}
						}
					});

				}

			},
			failure: function (errMsg) {
				alert(errMsg);
			}
		});
	}
	
	function numberWithCommas(x) {
		if(x === undefined || x === null) return "0";
		return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}

    var DataTable = $('#userOrder').DataTable({
        autoWidth: false,
        lengthChange: false,
        responsive: true,
        processing: true,
        serverSide: true,
        destroy: true,
        paging: true,
        searching: false,
        pageLength: 10,
        language: {
            search: 'ค้นหา',
            processing: '<i class="fa fa-spinner fa-spin fa-lg"></i><span class="ml-2">กำลังโหลดข้อมูล...</span> ',
            info: "แสดง หน้า _PAGE_ จาก _PAGES_",
            infoEmpty: "",
            zeroRecords: "ไม่พบข้อมูล",
            infoFiltered: "(ค้นหา จาก _MAX_ รายการ)",
            paginate: {
                first: 'หน้าแรก',
                last: 'หน้าสุดท้าย',
                next: 'ต่อไป',
                previous: 'ก่อนหน้า'
            },
        },
        ajax: {
            url: '{!! route('order.report.json.maxOrder') !!}',
            dataType: 'json',
            type: "GET",
            data: function(d) {
                d.month = $('#month').val();
                d.year = $('#year').val();
            },
        },
        order: [],
        columnDefs: [
            {
                'targets': [2],
                'className': 'text-right',
            },
        ],
        columns: [
            {data: 'code'},
            {data: 'fullname'},
            {data: 'total'},
        ]
    });

    $.ajax({
        type: "GET",
        url: '{!! route('order.report.orderpayment') !!}',
        cache: false,
        beforeSend: function () { },
        success: function (response) {

            if(response != false){

                $('#op_m_1').html(response.d_type1);
				$('#op_m_2').html(response.d_type2);
				$('#op_m_3').html(response.d_type3);
				$('#op_m_4').html(response.d_type4);
				$('#op_m_5').html(response.d_type5);
				$('#op_m_6').html(response.d_type6);

                var ctx = document.getElementById("orderPayment");
                var repeatPurchase = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ["บัญชีธนาคาร", "บัตรเครดิต", "ผ่อนชำระ", "พร้อมเพย์", "โมบายแบงค์กิ้ง", "ทรูมันนี่"],
						datasets: [{
							data: [response.p_type1,response.p_type2,response.p_type3,response.p_type4,response.p_type5,response.p_type6],
							backgroundColor: ['#0abde3','#ff9f43','#833471','#00b894','#e17055','#6c5ce7'],
							hoverBackgroundColor: ['#0abde3','#ff9f43','#833471','#00b894','#e17055','#6c5ce7'],
							hoverBorderColor: "rgba(234, 236, 244, 1)",
						}],
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                display: true,
                                ticks: {
                                    beginAtZero: true,
                                    min: 0
                                }
                            }]
                        },
                        maintainAspectRatio: false,
                        tooltips: {
                            backgroundColor: "#000",
                            bodyFontColor: "#FFF",
                            borderColor: '#dddfeb',
                            borderWidth: 1,
                            xPadding: 15,
                            yPadding: 15,
                            displayColors: false,
                            caretPadding: 10,
                        },
                        legend: {
                            display: false
                        },
                        cutoutPercentage: 0,
                    },
                });
            }

        },
        failure: function (errMsg) {
            alert(errMsg);
        }
    });

    $.ajax({
        type: "GET",
        url: '{!! route('order.report.json.statusOrder') !!}',
        cache: false,
        beforeSend: function () {
        },
        success: function (response) {

            if(response != false){
                var typeName        = [];
                var typeValue       = [];
                var typeDisplay     = [];

                $.each(response, function (index, item) {

                    typeName.push(item.status_name_);
                    typeValue.push(item.status_count_);
                    typeDisplay.push(item.display_status_);

                });

                $('#displayStatusOrder').html(typeDisplay);

                console.log(typeDisplay);
                var business = document.getElementById("business");

                new Chart(business, {
                    type: 'line',
                    data: {
                        labels: typeName,
                        datasets: [
                        {
                            label: " จำนวน/คน ",
                            fill: true,
                            borderColor: "#7f8c8d",
                            backgroundColor: "#bdc3c7",
                            borderWidth: 1,
                            data: typeValue,
                        }
                        ]
                    },
                    options: {
    responsive: true,
    maintainAspectRatio: false,
    tooltips: {
        display: true
    },
    legend: {
        display: false
    },
    scales: {
                            yAxes: [{
                                ticks: {
                                    fontColor: "#9f9f9f",
                                    beginAtZero: true,
                                    maxTicksLimit: 5,
                                },
                                gridLines: {
                                    drawBorder: false,
                                    borderDash: [8, 5],
                                    zeroLineColor: "transparent",
                                    color: '#9f9f9f'
                                }
                            }],
                            xAxes: [{
                                offset: 10,
                                ticks: {
                                    display: false,
                                },
                                gridLines: {
                                    drawBorder: false,
                                    borderDash: [8, 5],
                                    zeroLineColor: "transparent",
                                    color: '#9f9f9f'
                                }
                            }]
                        }
                    }
                });

            }

        },
        failure: function (errMsg) {
            alert(errMsg);
        }
    });
</script>
@endsection
