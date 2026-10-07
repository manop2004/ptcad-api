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
            <h4 class="card-title transform-capitalize">{{$title_page}} ({{ $count }})</h4>
        </div>
        <div class="card-body">
          <div class="toolbar">
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <input class="form-control" id="search" name="search" placeholder="ค้นหาข้อมูล" onkeyup="loadFilter(this)"/>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <select id="status" name="status" class="form-control" onchange="callChange(this)">
                            <option value="">--ค้นหาจากสถานะ--</option>
                            <option value="1">จัดส่งของขวัญแล้ว</option>
                            <option value="2">ยังไม่จัดส่งของขวัญ</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <a id="btn-export" href="{{ route("getmember.export.excel") }}">
                            @include('layouts.admin._button.export')
                        </a>
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="form-group">
                        @include('layouts.admin._button.reload')
                    </div>
                </div>
            </div>
          </div>
          <table id="datatable" data-create="{{ route('promotion.emailtemplate.add') }}" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th style="width: 15px" class="disabled-sorting text-right"></th>
                <th >ชื่อ - นามสกุลผู้แนะนำ</th>
                <th>อีเมล</th>
                <th>เบอร์โทรศัพท์</th>
                <th style="width: 130px">วันที่แนะนำสมาชิก</th>
                <th style="width: 120px">สถานะ</th>
                <th style="width: 130px" class="disabled-sorting text-right">Actions</th>
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

@include('admin.emailtemplate.modal.delete')
@endsection

@section('js')

<!--  DataTables.net Plugin, full documentation here: https://datatables.net/    -->
<script src="{{ asset('assets/backend/js/plugins/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/backend/js/plugins/dataTables.buttons.min.js') }}"></script>

<script>
    var filtering = function() {
        DataTable.ajax.reload();
    }

    function loadFilter(e) {

        let search = $("#search").val();
        let status = $("#status").val();

        let url = '{!! route("getmember.export.excel") !!}?search=:search&status=:status';
        url = url.replace(':search', search);
        url = url.replace(':status', status);
        $('#btn-export').attr("href", url);

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
            // dom: "<'row'<'col-sm-6 col-md-6'Bl><'col-sm-6 col-md-6'f>>" +
            //     "<'row'<'col-sm-12'tr>>" +
            //     "<'row'<'col-sm-6 col-md-6'i><'col-sm-6 col-md-6'p>>",
            // buttons: [{
            //     text: '<i class="fa fa-plus"></i>&nbsp;&nbsp;เพิ่มข้อมูล',
            //     className: 'btn  btn-outline-primary',
            //     init: function(api, node, config) {
            //         $(node).removeClass('dt-button')
            //     },
            //     action: function(e, dt, node, config) {
            //         location.href = $('#datatable').attr('data-create');
            //     }
            // }],
            ajax: {
                url: '{!! route('getmember.jsondata') !!}',
                dataType: 'json',
                type: "GET",
                data: function(d) {
                    d.search = $('#search').val();
                    d.status = $('#status').val();
                },
            },
            order: [[ 4, "desc" ]],
            columnDefs: [
                {
                    'targets': [0,4,5,6],
                    'className': 'text-center',
                },
            ],
            columns: [
                {data: 'DT_RowIndex'},
                {data: 'Fullname'},
                {data: 'Email'},
                {data: 'Tel'},
                {data: 'Date'},
                {data: 'status',
                    render: function(data){
                        let status
                        if(data == 2){
                            status = '<span class="badge badge-danger">ยังไม่มีการจัดส่งของขวัญ</span>'
                        }else if(data == 1){
                            status = '<span class="badge badge-success">จัดส่งของขวัญแล้ว</span>'
                        }
                        return status
                    }
                },
                {data: 'actions'},
            ]
        });

</script>
@endsection
