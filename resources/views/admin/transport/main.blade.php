@extends('layouts.temp_admin')
@section('title'){{$title_page}}@endsection

@section('css')

<link rel="stylesheet" href="{{ asset('assets/backend/js/plugins/buttons.dataTables.min.css') }}">

@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
            <h4 class="card-title transform-capitalize">ผู้ให้บริการขนส่ง</h4>
        </div>
        <div class="card-body">
          <div class="toolbar"></div>
          <table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th style="width: 200px;">โลโก้</th>
                    <th>บริการขนส่ง</th>
                    <th style="width: 120px;">อัพเดตล่าสุด</th>
                    <th style="width: 100px;">จัดการ</th>
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
                url: '{!! route('transport.jsondata') !!}'
            },
            order: [[ 1, "desc" ]],
            columnDefs: [
                {
                    'targets': [0,2,3],
                    'className': 'text-center',
                },
            ],
            columns: [
                {data: 'transport_img'},
                {data: 'transport_name'},
                {data: 'transport_updateby'},
                {data: 'actions'},
            ]
        });
    });

</script>
@endsection
