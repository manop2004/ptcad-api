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
            <h4 class="card-title transform-capitalize">Document - เอกสาร ({{ number_format($document) }})</h4>
        </div>
        <div class="card-body">
          <div class="toolbar"></div>
          <table id="datatable" data-create="{{ route('document.add') }}" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th style="width: 15px" class="disabled-sorting text-right">#</th>
                <th>ชื่อหัวข้อ</th>
                <th style="width: 100px">ไฟล์ PDF</th>
                <th style="width: 80px">สถานะ</th>
                <th style="width: 150px">เพิ่มข้อมูล</th>
                <th style="width: 120px" class="disabled-sorting text-right">Actions</th>
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

@include('admin.document.modal.delete')
@endsection

@section('js')

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
            dom: "<'row'<'col-sm-6 col-md-6'Bl><'col-sm-6 col-md-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-6 col-md-6'i><'col-sm-6 col-md-6'p>>",
            buttons: [{
                text: '<i class="fa fa-plus"></i>&nbsp;&nbsp;เพิ่มข้อมูล',
                className: 'btn  btn-outline-primary',
                init: function(api, node, config) {
                    $(node).removeClass('dt-button')
                },
                action: function(e, dt, node, config) {
                    location.href = $('#datatable').attr('data-create');
                }
            }],
            ajax: {
                url: '{!! route('document.jsondata') !!}'
            },
            order: [[ 4, "desc" ]],
            columnDefs: [
                {
                    'targets': [0,3,5],
                    'className': 'text-center',
                },
            ],
            columns: [
                {data: 'DT_RowIndex'},
                {data: 'document_title'},
                {data: 'document_file'},
                {data: 'document_show',
                    render: function(data){
                        let status
                        if(data == 2){
                            status = '<span class="badge badge-danger">ปิดใช้งาน</span>'
                        }else if(data == 1){
                            status = '<span class="badge badge-success">เปิดใช้งาน</span>'
                        }
                        return status
                    }
                },
                {data: 'crated'},
                {data: 'actions'},
            ]
        });
    });
</script>
@endsection