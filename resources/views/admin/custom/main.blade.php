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
              <h4 class="card-title transform-capitalize">Custom Code {{ $type }} ({{ $count }})</h4>
        </div>
        <div class="card-body">
          <div class="toolbar">
            <!--        Here you can write extra buttons/actions for the toolbar              -->
          </div>
          <table id="datatable" data-create="{{ route('custom.add',['code' => $type]) }}" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th style="width: 15px" class="disabled-sorting text-right"></th>
                <th>ชื่อ</th>
                <th style="width: 80px">การแสดงผล</th>
                <th style="width: 80px">สถานะ</th>
                <th style="width: 150px">วันที่อัพเดต</th>
                <th style="width: 150px" class="disabled-sorting text-right">Actions</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
        <!-- end content-->
      </div>
      <!--  end card  -->
    </div>
    <!-- end col-md-12 -->
  </div>

  @include('admin.custom.modal.delete')
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
                url: '{!! route('custom.jsondata',['code'=> $type]) !!}'
            },
            order: [[ 4, "desc" ]],
            columnDefs: [
                {
                    'targets': [0,2,3,5],
                    'className': 'text-center',
                },
            ],
            columns: [
                {data: 'DT_RowIndex'},
                {data: 'title'},
                {data: 'display',
                    render: function(data){
                        let display
                        if(data == 3){
                            display = '<span class="badge badge-info wh-60">FOOTER</span>'
                        }else if(data == 2){
                            display = '<span class="badge badge-primary wh-60">BODY</span>'
                        }else{
                            display = '<span class="badge badge-warning wh-60">HEAD</span>'
                        }
                        return display
                    }
                },
                {data: 'status',
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
                {data: 'created_at'},
                {data: 'actions'},
            ]
        });
    });

</script>
@endsection
