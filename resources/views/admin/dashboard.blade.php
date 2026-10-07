@extends('layouts.temp_admin')
@section('title'){{$title_page}}@endsection

@section('css')
 <!-- select2 -->
 <link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet" />
 <!-- select2-bootstrap4-theme -->
 <link href="{{ asset('vendor/select2-bootstrap4-theme/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-6">
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
                <p class="card-title">{{ number_format($orderToday)}}
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
    <div class="col-lg-4 col-md-4 col-sm-6">
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
                <p class="card-title">{{ number_format($orderWait)}}
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
    <div class="col-lg-4 col-md-4 col-sm-6">
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
                <p class="card-title">{{ number_format($orderList)}}<p>
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
    <div class="col-md-4">
      <div class="card card-chart">
        <div class="card-header">
            <h5 class="card-title">ประเภทการขอใบเสนอราคา ({{ $quotation }} )</h5>
        </div>
        <div class="card-body">
            <canvas id="chartQuotation"></canvas>
        </div>
      </div>
    </div>
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-xl-6 col-lg-12 col-md-12 vertical-bottom">
                    <h4 class="m-0 font-weight-bold text-primary align-bottom" >สินค้าขายดี 10 อันดับ</h4>
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
                                    if($i == $lastYear){ $select = 'selected';}else{ $select = '';}
                                    echo '<option value='.$i.' '.$select.'>ประจำปี '.($i).'</option>';
                                }
                            @endphp
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="table" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th class="bg-table-head" style="width: 180px">รหัสสินค้า</th>
                        <th class="bg-table-head" style="min-width: 400px">ชื่อสินค้า</th>
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
<!-- Chart JS -->
<script src="{{ asset('assets/backend/js/plugins/chartjs.min.js') }}"></script>
<script src="{{ asset('assets/backend/demo/demo.js') }}"></script>
<script>

  var filtering = function() {
      DataTable.ajax.reload();
  }

  function loadFilter(e) {
      let month = $("#month").val();
      let year = $("#year").val();
      filtering();
  }

  function callChange(e) {
      loadFilter();
  }

  var DataTable = $('#table').DataTable({
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
          url: '{!! route('product.json.beatseller') !!}',
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
          {data: 'sku'},
          {data: 'name'},
          {data: 'total'},
      ]
  });

</script>

<script>
  $.ajax({
      type: "GET",
      url: '{!! route('home.quotation.json') !!}',
      cache: false,
      beforeSend: function () { },
      success: function (response2) {

        if(response2 != false){
            var type1 = [];
            var type2 = [];

            $.each(response2, function (index, item) {

              type1 = item.type1;
              type2 = item.type2;

            });

          var chartQuotation = document.getElementById("chartQuotation");
          new Chart(chartQuotation, {
              type: 'bar',
              data: {
                labels: ["บุคคลธรรมดา", "บริษัท/องค์กร/สำนักงาน"],
                datasets: [
                  {
                    label: ["บุคคลธรรมดา", "บริษัท/องค์กร/สำนักงาน"],
                    borderColor: ['#0abde3','#ff9f43'],
                    fill: true,
                    backgroundColor: ['#48dbfb', '#feca57'],
                    hoverBackgroundColor: ['#0abde3','#ff9f43'],
                    borderWidth: 1,
                    data: [type1, type2],
                  }
                ],
              },
              options: {
                
                tooltips: {
                  tooltipFillColor: "rgba(0,0,0,0.5)",
                  tooltipFontFamily: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
                  tooltipFontSize: 14,
                  tooltipFontStyle: "normal",
                  tooltipFontColor: "#fff",
                  tooltipTitleFontFamily: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
                  tooltipTitleFontSize: 14,
                  tooltipTitleFontStyle: "bold",
                  tooltipTitleFontColor: "#fff",
                  tooltipYPadding: 6,
                  tooltipXPadding: 6,
                  tooltipCaretSize: 8,
                  tooltipCornerRadius: 6,
                  tooltipXOffset: 10,
                },
                legend: {
                  display: false
                },
                scales: {
                  yAxes: [{
                      ticks: {
                        fontColor: "#9f9f9f",
                        fontStyle: "bold",
                        beginAtZero: true,
                        maxTicksLimit: 5,
                        padding: 20
                      },
                      gridLines: {
                        zeroLineColor: "transparent",
                        display: true,
                        drawBorder: true,
                        color: '#9f9f9f',
                      }
                  }],
                  xAxes: [{
                      barPercentage: 1,
                      gridLines: {
                        zeroLineColor: "white",
                        display: false,
                        drawBorder: true,
                        color: 'transparent',
                      },
                      ticks: {
                        padding: 20,
                        fontColor: "#9f9f9f",
                        fontStyle: "bold"
                      }
                  }],
                },
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
