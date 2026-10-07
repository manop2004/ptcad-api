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
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card card-stats">
            <div class="card-body ">
                <div class="row">
                    <div class="col-5 col-md-4">
                    <div class="icon-big text-center icon-warning">
                        <i class="nc-icon nc-badge text-warning"></i>
                    </div>
                    </div>
                    <div class="col-7 col-md-8">
                    <div class="numbers">
                        <p class="card-category">แบรนด์สินค้าทั้งหมด</p>
                        <p class="card-title">{{ number_format($brand)}}
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
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card card-stats">
            <div class="card-body ">
                <div class="row">
                    <div class="col-5 col-md-4">
                    <div class="icon-big text-center incon-success">
                        <i class="nc-icon nc-box text-success"></i>
                    </div>
                    </div>
                    <div class="col-7 col-md-8">
                    <div class="numbers">
                        <p class="card-category">จำนวนสินค้าทั้งหมด</p>
                        <p class="card-title">{{ number_format($product)}}
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
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card card-stats">
            <div class="card-body ">
                <div class="row">
                    <div class="col-5 col-md-4">
                    <div class="icon-big text-center icon-danger">
                        <i class="nc-icon nc-tile-56 text-danger"></i>
                    </div>
                    </div>
                    <div class="col-7 col-md-8">
                    <div class="numbers">
                        <p class="card-category">จำนวนหมวดหมู่หลัก</p>
                        <p class="card-title">{{ number_format($category)}}
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
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card card-stats">
            <div class="card-body ">
                <div class="row">
                    <div class="col-5 col-md-4">
                    <div class="icon-big text-center icon-primary">
                        <i class="nc-icon nc-bullet-list-67 text-primary"></i>
                    </div>
                    </div>
                    <div class="col-7 col-md-8">
                    <div class="numbers">
                        <p class="card-category">จำนวนหมวดหมู่ย่อย</p>
                        <p class="card-title">{{ number_format($subcategory)}}
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
</div>
<div class="row">
    <div class="col-lg-4 col-md-12 col-mg">
        <div class="card card-stats">
            <div class="card-body ">
                <h5 class="card-title">จำแนกตามประเภทสินค้า</h5>
                <p class="card-category">(คำนวณจากจำนวนรวมของแต่ละประเภทของสินค้า)</p>
                <br/>
                <div class="row">
                    <div class="col-xl-12">
                        <canvas id="productType"></canvas>
                    </div>
                    <div class="col-xl-12">
                        <br/>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ประเภท</th>
                                    <th class="right" style="width: 10%">จำนวน</th>
                                </tr>
                            </thead>
                            <tbody id="table_in_type"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8 col-md-12 col-mg">
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
<script src="{{ asset('assets/backend/js/plugins/dataTables.buttons.min.js') }}"></script>
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
@include('admin.product.report.Chart.productType')

@endsection
