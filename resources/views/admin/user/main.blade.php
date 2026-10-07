@extends('layouts.temp_admin')
@section('title'){{$title_page}}@endsection

@section('css')

<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css">

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
                    <div class="col-md-8">
                        <div class="form-group">
                            <input class="form-control" id="search" name="search" placeholder="ค้นหาข้อมูล" onkeyup="loadFilter(this)"/>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <select id="type" name="type" class="form-control" onchange="loadFilter(this)">
								<option value="">--สิทธิ์การใช้งานทั้งหมด--</option>

								@foreach($levels as $level)
									<option value="{{ $level->id }}">
										{{ $level->name }}
									</option>
								@endforeach
							</select>
                        </div>
                    </div>
                    @if(!empty($UserLevel))
                        @if($UserLevel->l_user_Action == 1)
                            <div class="col-md-12">
                                <a href="{{ route('user.add') }}">
                                    <button class="btn btn-outline-primary notopmargin" type="button"><span><i class="fa fa-plus"></i>  เพิ่มข้อมูล</span></button>
                                </a>
                                @include('layouts.admin._button.reload')
                            </div>
                        @endif
                    @endif
                </div>
            </div>
          <table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th style="width: 15px" class="disabled-sorting text-right"></th>
                <th>รหัสผู้ใช้</th>
                <th>ชื่อ - นามสกุล</th>
                <th>ชื่อที่ใช้แสดง</th>
                <th>เบอร์โทรศัพท์</th>
                <th>อีเมล</th>
                <th style="width: 150px">สิทธิ์การใช้งาน</th>
                <th style="width: 120px">เข้าใช้งานล่าสุด</th>
                <th style="width: 80px">สถานะ</th>
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
</div>

@include('admin.user.modal.delete')
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

        let type = $("#type").val();
        let search = $("#search").val();

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
        ajax: {
            url: '{!! route('user.jsondata') !!}',
            dataType: 'json',
            type: "GET",
            data: function(d) {
                d.type = $('#type').val();
                d.search = $('#search').val();
            },
        },
        order: [[ 1, "desc" ]],
        columnDefs: [
            {
                'targets': [0,7,8,9],
                'className': 'text-center',
            },
        ],
        columns: [
            {data: 'DT_RowIndex'},
            {data: 'code'},
            {data: 'name'},
            {data: 'author'},
            {data: 'tel'},
            {data: 'email'},
            {data: 'level'},
            {data: 'lastlogin'},
            {data: 'status',
                render: function(data){
                    let status
                    if(data == 0){
                        status = '<span class="badge badge-danger">ปิดใช้งาน</span>'
                    }else if(data == 1){
                        status = '<span class="badge badge-success">เปิดใช้งาน</span>'
                    }
                    return status
                }
            },
            {data: 'actions'},
        ]
    });

</script>
@endsection
