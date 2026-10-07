@extends('layouts.temp_admin')
@section('title'){{$title_page}}@endsection

@section('css')
<!-- select2 -->
<link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet" />
<!-- select2-bootstrap4-theme -->
<link href="{{ asset('vendor/select2-bootstrap4-theme/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">

<link rel="stylesheet" href="{{ asset('assets/backend/js/plugins/buttons.dataTables.min.css') }}">

@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title transform-capitalize">{{ $title_page }} ({{ $count }})</h4>
            </div>
            <div class="card-body">
                <div class="toolbar">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-lightslategray alert-dismissible fade show f-12" >
                                @if (!empty($pageMaps->page_return_policy))
                                    @php
                                        $p_return_policy = App\Models\TbPage::select('id','page_show','page_parmalink','pages_type')->where('page_show',1)->findOrFail($pageMaps->page_return_policy);
                                    @endphp
                                    @if (!empty($p_return_policy))
                                    <b><a class="co-white" href="@if($p_return_policy->pages_type == 1){{ route('fronend.page.content',$p_return_policy->page_parmalink) }}@else{{$p_return_policy->page_parmalink}}@endif">นโยบายการคืนเงิน</a></b><br/>
                                    @endif
                                @endif
                                สำหรับออเดอร์ที่มีการชำระเงินผ่าน "บัตรเครดิต" หรือ "ผ่อนชำระ" หากต้องการยกเลิกออเดอร์/คืนเงิน ติดต่อที่
                                <a class="co-white" href="mailto:arada@applicadthai.com">arada@applicadthai.com</a>
                                โดยแจ้งหมายเลขคำสั่งซื้อ, วันที่ชำระเงิน, ยอดเงินที่ชำระและสาเหตุที่ต้องการยกเลิก เพื่อดำเนินการต่อไป
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group">
                                <input class="form-control" id="search" name="search" placeholder="ค้นหาข้อมูล" onkeyup="loadFilter(this)"/>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <select id="payment" name="payment" class="form-control" onchange="callChange(this)">
                                    <option value="">--ค้นหาจากสถานะคำสั่งซื้อ--</option>
                                    @foreach ($statusPayments as $payment )
                                        <option value="{{ $payment->id }}">{{ $payment->status_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <select id="staff" name="staff" class="form-control" onchange="callChange(this)">
                                    <option value="">--ค้นหาจากชื่อพนักงานที่รับผิดชอบ--</option>
                                    @foreach ($users as $user )
                                        <option value="{{ $user->id }}">{{ $user->name }} {{ $user->lastname }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th  style="width: 150px">หมายเลขคำสั่งซื้อ</th>
                        <th>ชื่อ - สกุล</th>
                        <th>ราคา</th>
                        <th style="width: 180px">วันที่สั่งซื้อ</th>
                        <th style="width: 100px">ใบเสร็จรับเงิน</th>
                        <th style="width: 150px">สถานะคำสั่งซื้อ</th>
                        <th style="width: 140px">พนักงานที่รับผิดชอบ</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@include('admin.order.modal.delete')
@endsection

@section('js')
<!-- select2 -->
<script src="{{ asset('vendor/select2/select2.min.js') }}"></script>
<!-- select2-bootstrap4-theme -->
<script src="{{ asset('vendor/select2-bootstrap4-theme/docs/script.js') }}"></script>
<!--  DataTables.net Plugin, full documentation here: https://datatables.net/    -->
<script src="{{ asset('assets/backend/js/plugins/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/backend/js/plugins/dataTables.buttons.min.js') }}"></script>

<script>
    $('.select-multiple').select2();

    var filtering = function() {
        DataTable.ajax.reload();
    }

    function loadFilter(e) {

        let search = $("#search").val();
        let staff = $("#staff").val();
        let payment = $("#payment").val();
        filtering();

    }

    function callChange(e) {
        loadFilter();
    }

    var DataTable = $('#datatable').DataTable({
        autoWidth: false,
        lengthChange: false,
        responsive: true,
        processing: true,
        serverSide: true,
        destroy: true,
        paging: true,
        searching: false,
        pageLength: 15,
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
            url: '{!! route('order.jsondata') !!}',
            dataType: 'json',
            type: "GET",
            data: function(d) {
                d.search = $('#search').val();
                d.staff = $('#staff').val();
                d.payment = $('#payment').val();
            },
        },
        order: [[ 3, "desc" ]],
        columnDefs: [
            {
                'targets': [3,4,5],
                'className': 'text-center',
            },
            {
                'targets': [2],
                'className': 'text-right',
            },
        ],
        columns: [
            {data: 'orderNumber'},
            {data: 'fullName'},
            {data: 'price'},
            {data: 'crated'},
            {data: 'receipt'},
            {data: 'status'},
            {data: 'staff'},
        ]
    });

</script>
@endsection
