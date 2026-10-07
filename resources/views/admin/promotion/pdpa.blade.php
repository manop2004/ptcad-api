@extends('layouts.temp_admin')
@section('title'){{$title_page}}@endsection

@section('css')

@endsection

@section('content')

<div class="card">
    <div class="card-body">
        <div class="nav-tabs-navigation text-left">
            <div class="nav-tabs-wrapper">
                <ul id="tabs" class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#home" role="tab" aria-expanded="true">กราฟ PDPA</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#profile" role="tab" aria-expanded="false">รายชื่อที่อนุญาตให้ใช้ข้อมูล PDPA</a>
                    </li>
                </ul>
            </div>
        </div>
        <div id="my-tab-content" class="tab-content">
            <div class="tab-pane active" id="home" role="tabpanel" aria-expanded="true">
                <div class="row">
                    <div class="col-md-4">
                        <b>คำอธิบายรายชื่อที่อนุญาติให้ใช้ข้อมูล (PDPA)</b>
                        <hr/>
                        <ul>
                            <li>รับข้อมูลข่าวสารและประชาสัมพันธ์ <span id="d_news"></span> คน</li>
                            <li>รับข้อมูลข่าวสารเกี่ยวกับบริษัท/บทความ <span id="d_article"></span> คน</li>
                            <li>รับข้อมูลข่าวสารเกี่ยวกับสินค้าและบริการของบริษัท <span id="d_product"></span> คน</li>
                            <li>รับข้อมูลข่าวสารทั้งหมด <span id="d_all_"></span> คน</li>
                        </ul>
                    </div>
                    <div class="col-md-8">
                        <h5 class="card-title">กราฟ PDPA</h5>
                        <p class="card-category">(คำนวณจากจำนวนรวมของแต่ละประเภท ที่มีการลงทะเบียนไว้)</p>
                        <br/>
                        <div class="card card-chart">
                            <div class="card-body">
                                <canvas id="business"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="profile" role="tabpanel" aria-expanded="false">
                <div class="toolbar">
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-mg">
                            <div class="form-group">
                                <select id="type" name="type" class="form-control" onchange="loadFilter(this)">
                                    <option value="4">รับข้อมูลข่าวสารทั้งหมด</option>
                                    <option value="1">รับข้อมูลข่าวสารและประชาสัมพันธ์</option>
                                    <option value="2">รับข้อมูลข่าวสารเกี่ยวกับบริษัท/บทความ</option>
                                    <option value="3">รับข้อมูลข่าวสารเกี่ยวกับสินค้าและบริการของบริษัท</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-mg">
                            @include('layouts.admin._button.reloadMain')
                        </div>
                        <div class="col-lg-2 col-md-2 col-mg">
                            <a id="btn-export" href="{{ route("promotion.pdpa.export") }}">
                                @include('layouts.admin._button.export')
                            </a>
                        </div>
                    </div>
                </div>

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="width: 5%"></th>
                            <th>ชื่อ-นามสกุล</th>
                            <th style="width: 15%">เบอร์โทรศัพท์</th>
                            <th>อีเมล</th>
                            <th style="width: 10%">ข่าวสาร/ประชาสัมพันธ์</th>
                            <th style="width: 10%">สินค้าและบริการ</th>
                            <th style="width: 10%">ข่าวสารเกี่ยวกับบริษัท/บทความ</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')

<!--  DataTables.net Plugin, full documentation here: https://datatables.net/    -->
<script src="{{ asset('assets/backend/js/plugins/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/backend/js/plugins/dataTables.buttons.min.js') }}"></script>
<!-- Chart JS -->
<script src="{{ asset('assets/backend/js/plugins/chartjs.min.js') }}"></script>
<script src="{{ asset('assets/backend/demo/demo.js') }}"></script>
<script>

    $.ajax({
        type: "GET",
        url: '{!! route('promotion.pdpa.jsondata') !!}',
        cache: false,
        beforeSend: function () {
        },
        success: function (response) {

            if(response != false){
                var typeName = [];
                var typeValue = [];

                $.each(response, function (index, item) {

                    $('#d_news').html(item.d_news);
                    $('#d_article').html(item.d_article);
                    $('#d_product').html(item.d_product);
                    $('#d_all_').html(item.d_all_);
                    typeName.push('ข่าวสาร/ประชาสัมพันธ์','ข่าวสารเกี่ยวกับบริษัท/บทความ','สินค้าและบริการ','รับข้อมูลทั้งหมด');
                    typeValue.push(item.news,item.article,item.product,item.all_);

                });

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

<script>

    var filtering = function() {
        DataTable.ajax.reload();
    }

    function loadFilter(e) {
        let type = $("#type").val();

        let url = '{!! route("promotion.pdpa.export") !!}?type=:type';
        url = url.replace(':type', type);
        $('#btn-export').attr("href", url);

        filtering();
    }

    function callChange(e) {
        loadFilter();
    }

    var DataTable = $('#dataTable').DataTable({
        autoWidth: false,
        lengthChange: false,
        responsive: true,
        processing: true,
        serverSide: true,
        destroy: true,
        paging: true,
        pageLength: 10,
        searching: false,
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
            url: '{!! route('promotion.pdpa.jsonTable') !!}',
            dataType: 'json',
            type: "GET",
            data: function(d) {
                d.type = $('#type').val();
            },
        },
        // order: [[ 1, "asc" ]],
        columnDefs: [
            {
                'targets': [0,4,5,6],
                'className': 'text-center',
            },
        ],
        columns: [
            {data: 'DT_RowIndex'},
            {data: 'fullname'},
            {data: 'tel'},
            {data: 'email'},
            {data: 'news'},
            {data: 'product'},
            {data: 'article'},
        ]
    });

</script>
@endsection
