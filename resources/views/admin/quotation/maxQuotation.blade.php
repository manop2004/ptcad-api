@extends('layouts.temp_admin')
@section('title'){{$title_page}}@endsection

@section('css')
<!-- select2 -->
<link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet" />
<!-- select2-bootstrap4-theme -->
<link href="{{ asset('vendor/select2-bootstrap4-theme/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('content')

<div class="content">
    <div class="row">
        <div class="col-sm-12">
            <a href="{{ route('quotation.report') }}">
                <button class="btn">
                    รายงานใบเสนอราคา
                    <span class="btn-label btn-label-right ">
                      <i class="nc-icon nc-minimal-right"></i>
                    </span>
                </button>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <br/>
                    <div class="row">
                        <div class="col-xl-6 col-lg-12 col-md-12 vertical-bottom">
                            <div class="form-group">
                            <h4 class="m-0 font-weight-bold text-primary align-bottom" >รายงานสินค้าที่ถูกขอใบเสนอ</h4>
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
                        <table class="table table-bordered table-striped" id="maxQuotation" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th class="bg-table-head" style="width: 1ถ0px">รหัสสินค้า</th>
                                <th class="bg-table-head" style="min-width: 400px">ชื่อสินค้า</th>
                                <th class="bg-table-head" style="width: 200px">ยอดขอใบเสนอราคารวมทั้งสิ้น</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
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
    <script src="{{ asset('assets/backend/js/plugins/jquery.dataTables.min.js') }}"></script>
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
        var DataTable = $('#maxQuotation').DataTable({
            autoWidth: false,
            lengthChange: false,
            responsive: true,
            processing: true,
            serverSide: true,
            destroy: true,
            paging: false,
            searching: false,
            bInfo : false,
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
                url: '{!! route('quotation.json.maxquotation') !!}',
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
    </script>
@endsection