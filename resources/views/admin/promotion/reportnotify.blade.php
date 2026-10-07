@extends('layouts.temp_admin')
@section('title'){{$title_page}}@endsection

@section('css')

<link rel="stylesheet" href="{{ asset('assets/backend/js/plugins/buttons.dataTables.min.css') }}">
<style>
    .status-badge{ width: 120px !important; }
    .table { font-size: 12px !important; }
</style>
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
            <h4 class="card-title transform-capitalize">{{$title_page}} ({{ $count }})</h4>
            <p>เพิ่มเติม : ลำดับการแสดงผลจะเรียงจากวันที่เพิ่มล่าสุด</p>
        </div>
        <div class="card-body">
          <div class="toolbar"></div>
          <table id="datatable" data-setting="{{ route('promotion.setting.linetify.index') }}" data-calendar="{{ route('promotion.calendar') }}" data-promotion="{{ route('promotion.index') }}" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th >ชื่อโปรโมชั่น</th>
                <th >กลุ่มที่แแจ้งเตือน</th>
                <th style="width: 125px" >แจ้งวันที่เริ่มต้น</th>
                <th>หมายเหตุ</th>
                <th style="width: 125px" >แจ้งวันที่เสร็จสิ้น</th>
                <th >หมายเหตุ</th>
                <th style="width: 80px">สถานะ</th>
                <th style="width: 120px">อัพเดตข้อมูล</th>
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

@include('admin.promotion.modal.delete')
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
                text: '<i class="nc-icon nc-layout-11"></i>&nbsp;&nbsp;โปรโมชั่น',
                className: 'btn  btn-outline-info',
                init: function(api, node, config) {
                    $(node).removeClass('dt-button')
                },
                action: function(e, dt, node, config) {
                    location.href = $('#datatable').attr('data-promotion');
                }
            },
            {
                text: '<i class="nc-icon nc-settings-gear-65"></i>&nbsp;&nbsp;ตั้งค่าการแจ้งเตือน Line Notify',
                className: 'btn  btn-outline-success',
                init: function(api, node, config) {
                    $(node).removeClass('dt-button')
                },
                action: function(e, dt, node, config) {
                    location.href = $('#datatable').attr('data-setting');
                }
            },
            {
                text: '<i class="fa fa-calendar"></i>&nbsp;&nbsp;ปฎิทินโปรโมชั่น',
                className: 'btn  btn-outline-defalut',
                init: function(api, node, config) {
                    $(node).removeClass('dt-button')
                },
                action: function(e, dt, node, config) {
                    location.href = $('#datatable').attr('data-calendar');
                }
            }],
            ajax: {
                url: '{!! route('promotion.report.notify.jsondata') !!}'
            },
            order: [[ 7, "desc" ]],
            columnDefs: [
                {
                    'targets': [2,4,6,7],
                    'className': 'text-center',
                },
            ],
            columns: [
                {data: 'promo_name'},
                {data: 'groupName'},
                {data: 'send_status_startDate',
                    render: function(data){
                        let status
                        if(data == 2){
                            status = '<span class="badge badge-danger status-badge">ยังไม่มีการส่งแจ้งเตือน</span>'
                        }else if(data == 1){
                            status = '<span class="badge badge-success status-badge">ส่งแจ้งเตือนสำเร็จ</span>'
                        }
                        return status
                    }
                },
                {data: 'send_message_startDate'},
                {data: 'send_status_EndDate',
                    render: function(data){
                        let status
                        if(data == 2){
                            status = '<span class="badge badge-danger status-badge">ยังไม่มีการส่งแจ้งเตือน</span>'
                        }else if(data == 1){
                            status = '<span class="badge badge-success status-badge">ส่งแจ้งเตือนสำเร็จ</span>'
                        }
                        return status
                    }
                },
                {data: 'send_message_EndDate'},
                {data: 'show',
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
                {data: 'updated'},
            ]
        });
    });

</script>
@endsection
