@extends('layouts.temp_admin')
@section('title'){{$title_page}}@endsection

@section('css')
<style>
    #datatable td,
    #datatable th {
        vertical-align: middle !important;
    }
</style>
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
            <h4 class="card-title transform-capitalize">{{$title_page}} ({{$count}})</h4>
        </div>
        <div class="card-body">

            @if(session('feedback'))
                <div class="alert alert-success">{{ session('feedback') }}</div>
            @endif

            <p class="text-muted">
                การ์ดที่โชว์ในหน้าแรก เรียงตาม "ลำดับ" จากน้อยไปมาก — การ์ดที่ "ปิด" จะไม่แสดงบนหน้าเว็บ
            </p>

            <div class="toolbar">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <input class="form-control" id="search" name="search" placeholder="ค้นหาชื่อสินค้า" onkeyup="loadFilter(this)"/>
                        </div>
                    </div>
                </div>

                <a href="{{ route('productcategory.add') }}">
                    <button class="btn btn-outline-primary notopmargin" type="button">
                        <span><i class="fa fa-plus"></i> เพิ่มการ์ดใหม่</span>
                    </button>
                </a>

                @include('layouts.admin._button.reload')
            </div>

            <table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th style="width: 70px" class="disabled-sorting">รูป</th>
                    <th>ชื่อสินค้า</th>
                    <th style="width: 130px" class="text-right">ราคา</th>
                    <th style="width: 70px">ลำดับ</th>
                    <th style="width: 80px" class="disabled-sorting">เด่น</th>
                    <th style="width: 90px" class="disabled-sorting">สถานะ</th>
                    <th style="width: 150px">อัพเดตข้อมูล</th>
                    <th style="width: 100px" class="disabled-sorting">Actions</th>
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
<script src="{{ asset('assets/backend/js/plugins/jquery.dataTables.min.js') }}"></script>
<script>
    var csrfToken = '{{ csrf_token() }}';

    function loadFilter(e) {
        DataTable.ajax.reload(null, false);
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
        order: [[3, 'asc']],
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
            url: '{!! route('productcategory.jsondata') !!}',
            dataType: 'json',
            type: "GET",
            data: function(d) {
                d.search = $('#search').val();
            },
        },
        columnDefs: [
            {
                'targets': [0, 4, 5],
                'className': 'text-center',
            },
            {
                'targets': [2],
                'className': 'text-right',
            },
        ],
        columns: [
            {data: 'img'},
            {data: 'title'},
            {data: 'price'},
            {data: 'sort_order'},
            {data: 'featured'},
            {data: 'status'},
            {data: 'updated'},
            {data: 'actions'},
        ],
    });

    // ===== สลับสถานะเปิด/ปิด =====
    $('#datatable').on('click', '.btn-toggle-status', function(){
        var id = $(this).data('id');
        var btn = $(this);

        $.ajax({
            url: '/productcategory/toggle-status/' + id,
            method: 'POST',
            data: { _token: csrfToken },
            success: function(res){
                DataTable.ajax.reload(null, false);
            },
            error: function(){
                alert('เกิดข้อผิดพลาด ลองใหม่อีกครั้ง');
            }
        });
    });

    // ===== ลบการ์ด =====
    $('#datatable').on('click', '.btn-delete-card', function(){
        var id = $(this).data('id');
        if (!confirm('ลบการ์ดนี้ถาวร แน่ใจไหม?')) return;

        $.ajax({
            url: '/productcategory/' + id,
            method: 'DELETE',
            data: { _token: csrfToken },
            success: function(res){
                DataTable.ajax.reload(null, false);
            },
            error: function(){
                alert('เกิดข้อผิดพลาด ลองใหม่อีกครั้ง');
            }
        });
    });
</script>
@endsection
