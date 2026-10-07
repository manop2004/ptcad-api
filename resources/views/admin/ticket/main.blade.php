@extends('layouts.temp_admin')
@section('title'){{$title_page}}@endsection

@section('css')

<link rel="stylesheet" href="{{ asset('assets/backend/js/plugins/buttons.dataTables.min.css') }}">
<style>
    .badge.badge-secondary, .badge.badge-success, .badge.badge-warning, .badge.badge-dark {
        width: 100%;
    }
	.badge-secondary {
		color: #fff;
		background-color: #6c757d;
	}
	.badge-dark {
		color: #fff;
		background-color: #343a40;
	}
 </style>
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
            <h4 class="card-title transform-capitalize">{{ $title_page }} ({{ number_format($count) }})</h4>
        </div>
        <div class="card-body">
          <div class="toolbar"></div>
          <table id="datatable" data-create="{{ route('ticket.add') }}"  class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>Ticket Id</th>
                <th>สถานะ</th>
                <th>บริษัท</th>
                <th>ชื่อผู้รับเรื่อง</th>
                <th>เพิ่มข้อมูล</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
        <!-- end content-->
      </div>
    </div>
</div>

@include('admin.ticket.modal.delete')
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
		  deferRender: true,
		  searchDelay: 500,
		  paging: true,
		  pageLength: 10,
		  language: { /* เดิม */ },
		  dom: "<'row'<'col-sm-6 col-md-6'Bl><'col-sm-6 col-md-6'f>>" +
			   "<'row'<'col-sm-12'tr>>" +
			   "<'row'<'col-sm-6 col-md-6'i><'col-sm-6 col-md-6'p>>",
		  buttons: [/* เดิม */],
		  ajax: {
			url: '{!! route('ticket.jsondata',$search_ticket) !!}',
			type: 'GET'
		  },
		  order: [[4, 'desc']], // ✅ เรียง created_at ล่าสุดก่อน
		  columnDefs: [
			{ targets: [0,1,3], className: 'text-center' },
			{ targets: [1], orderable: false } // ✅ ปิดเฉพาะคอล status (HTML), ไม่ปิดคอล 4
		  ],
		  columns: [
			{ data: 'code',            name: 'ticket.code' },
			{ data: 'status',          name: 'ticket.status' }, // แม้ปิด order ที่ columnDefs แล้ว ok
			{ data: 'company',         name: 'ticket.company' },
			{ data: 'staffname',       name: 'users.name' },    // ✅ แก้ user.name -> users.name
			{ data: 'created_at_text', name: 'ticket.created_at' } // ✅ ให้ชื่อคอลัมน์นี้ชี้ field ดิบสำหรับ sort
		  ]
		});

    });

</script>
@endsection
