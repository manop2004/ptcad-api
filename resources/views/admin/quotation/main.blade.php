@extends('layouts.temp_admin')
@section('title'){{$title_page}}@endsection

@section('css')

<link rel="stylesheet" href="{{ asset('assets/backend/js/plugins/buttons.dataTables.min.css') }}">
<style>
    .badge,.badge.badge-danger, .badge.badge-success {
        width: 118px;
    }
</style>
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
            <h4 class="card-title transform-capitalize">{{$title_page}} ({{ number_format($count) }})</h4>
        </div>
        <div class="card-body">
          <div class="toolbar"></div>
          <table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th style="width: 170px">เลขที่เอกสาร</th>
                    <th style="width: 160px">วันที่ทำรายการ</th>
                    <th style="width: 160px">เอกสารหมดอายุ</th>
                    <th style="width: 100px">ประเภท</th>
                    <th style="width: 200px">ชื่อ-นามสกุล</th>
                    <th style="width: 150px;">ข้อมูลการติดต่อ</th>
                    <th style="width: 130px;">ราคา</th>
                    <th style="width: 130px;">สถานะ</th>
                </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
        <!-- end content-->
      </div>
      <!--  end card  -->
    </div>
</div>

@endsection

@section('js')

<!--  DataTables.net Plugin, full documentation here: https://datatables.net/    -->
<script src="{{ asset('assets/backend/js/plugins/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/backend/js/plugins/dataTables.buttons.min.js') }}"></script>

<script>
    $(document).ready(function () {
        $('#datatable').DataTable({
            autoWidth: false,
            lengthChange: false,
            responsive: true,
            processing: true,
            serverSide: true,
            destroy: true,
            paging: true,
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
                url: '{!! route('quotation.jsondata') !!}'
            },
            order: [[ 1, "desc" ]],
            columnDefs: [
                {
                    'targets': [6],
                    'className': 'text-right',
                },
                {
                    'targets': [1,2,7],
                    'className': 'text-center',
                },
            ],
            columns: [
                {data: 'quotationNumber'},
                {data: 'quotationDate'},
                {data: 'quotationDateExp'},
                {data: 'type'},
                {data: 'quotationFullname'},
                {data: 'quotationContact'},
                {data: 'productTotal'},
                {data: 'quotationStatus',
                    render: function(data){
                        let status
                        if(data == 2){
                            status = '<span class="badge badge-danger">ติดต่อกลับ</span>'
                        }else {
                            status = '<span class="badge badge-success">ดาวน์โหลด PDF</span>'
                        }
                        return status
                    }
                },
            ]
        });
    });

</script>
@endsection
