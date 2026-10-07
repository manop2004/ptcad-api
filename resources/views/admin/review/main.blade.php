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
            <h4 class="card-title transform-capitalize">Reviews ({{ $count_review }})</h4>
        </div>
        <div class="card-body">
          <div class="toolbar"></div>
          <table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>หมายเลขคำสั่งซื้อ</th>
                <th>ชื่อ-สกุล</th>
                <th>ชื่อสินค้า</th>
                <th>คะแนน</th>
                <th>สถานะ</th>
                <th class="disabled-sorting text-center">Actions</th>
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

<!-- Modal สำหรับแสดงรายละเอียดรีวิว -->
<div class="modal fade" id="reviewDetailModal" tabindex="-1" aria-labelledby="reviewDetailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
       <div class="modal-header">
          <h5 class="modal-title" id="reviewDetailModalLabel">รายละเอียดรีวิว</h5>
       </div>
       <div class="modal-body">
          <!-- Hidden field สำหรับเก็บ review id -->
          <input type="hidden" id="modalReviewId" value="">
          <p><strong>หมายเลขคำสั่งซื้อ:</strong> <span id="modalOrderNumber"></span></p>
          <p><strong>ชื่อ-สกุล:</strong> <span id="modalBuyerName"></span></p>
          <p><strong>ชื่อสินค้า:</strong> <span id="modalProductName"></span></p>
          <p><strong>คะแนน:</strong> <span id="modalRating"></span></p>
          <p><strong>รีวิว:</strong> <span id="modalReviewText"></span></p>
          
          <div class="row">
			<div class="col-md-6" id="imageReview"></div>
			<div class="col-md-6" id="videoReview"></div>
		  </div>
		  <br>
		  <div class="row">
			<div class="col-md-4 text-left" id="modalCreated"></div>
			<div class="col-md-8 text-right" id="modalApprover"></div>
		  </div>
       </div>
       <div class="modal-footer" style="margin: 20px;">
            <button type="button" class="btn btn-success" id="btnApprove">Approved</button>
            <button type="button" class="btn btn-danger" id="btnReject">Reject</button>
       </div>
    </div>
  </div>
</div>



@include('admin.review.modal.delete')
@endsection

@section('js')

<!--  DataTables.net Plugin, full documentation here: https://datatables.net/    -->
<script src="{{ asset('assets/backend/js/plugins/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/backend/js/plugins/dataTables.buttons.min.js') }}"></script>

<script>
// เปิด Modal เมื่อคลิกที่ไอคอน 🔎
$(document).on('click', '.review-detail', function(e) {
    e.preventDefault();
    var $this = $(this);
    var reviewId = $this.data('id');
    var order   = $this.data('order');
    var buyer   = $this.data('buyer');
    var product = $this.data('product');
    var rating  = $this.data('rating');
    var review  = $this.data('review');
    var image   = $this.data('image');
    var video   = $this.data('video');
    var createdtime		= $this.data('createdtime');
    var approver		= $this.data('approver');
    var lastapproved	= $this.data('lastapproved');
	
	// กำหนดค่าใน modal
    $('#modalReviewId').val('');
    $('#modalOrderNumber').html('');
    $('#modalBuyerName').html('');
    $('#modalProductName').html('');
    $('#modalRating').html('');
    $('#modalReviewText').html('');
	$('#modalCreated').html('');
	$('#modalApprover').html('');

    // กำหนดค่าใน modal
    $('#modalReviewId').val(reviewId);
    $('#modalOrderNumber').text(order);
    $('#modalBuyerName').text(buyer);
    $('#modalProductName').text(product);
    $('#modalRating').text(rating);
    $('#modalReviewText').text(review);
    $('#modalCreated').text('Created Time : '+createdtime);
	
	if(approver && approver.trim() !== ''){
		$('#modalApprover').text('Updated By : '+approver+' @ '+lastapproved);
	}

    // แสดงรูปภาพหรือวิดีโอ หากมี
    var imageReview = $('#imageReview');
    imageReview.html(''); // เคลียร์เนื้อหาเก่า
    if (image && image.trim() !== '' && image != '/') {
        imageReview.append('<img src="'+image+'" alt="Review Image" class="img-fluid">');
    }
	var videoReview = $('#videoReview');
    videoReview.html(''); // เคลียร์เนื้อหาเก่า
    if (video && video.trim() !== '' && video != '/') {
        videoReview.append('<video controls class="img-fluid"><source src="'+video+'" type="video/mp4">Your browser does not support the video tag.</video>');
    }
    
    // แสดง modal
    var modal = new bootstrap.Modal(document.getElementById('reviewDetailModal'));
    modal.show();
});

$('#btnApprove, #btnReject').on('click', function(e) {
    e.preventDefault();
    var status = $(this).attr('id') === 'btnApprove' ? 'approved' : 'rejected';
    var reviewId = $('#modalReviewId').val();

    $.ajax({
        url: '{{ route("order.review.updateStatus") }}',
        type: 'POST',
        data: {
            review_id: reviewId,
            status: status,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
			// ซ่อน modal ด้วย jQuery
			$('#reviewDetailModal').modal('hide');

			// แสดง SweetAlert2 แจ้งเตือนความสำเร็จ
			Swal.fire({
				icon: 'success',
				title: 'สำเร็จ',
				text: response.message,
				timer: 2000,
				showConfirmButton: false
			});

			// รีเฟรช DataTable
			$('#datatable').DataTable().ajax.reload();
		},
        error: function(xhr) {
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด',
                text: xhr.responseJSON.message || 'ไม่สามารถอัปเดตสถานะได้ในขณะนี้',
            });
        }
    });
});

</script>

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
            buttons: [],
            ajax: {
                url: '{!! route('order.review.jsondata') !!}'
            },
            order: [[ 4, "desc" ]],
            columnDefs: [
                {
                    'targets': [0,4,5],
                    'className': 'text-center',
                },
            ],
            columns: [
                {data: 'orderNumber'},
                {data: 'review_by'},
                {data: 'product_name'},
                {data: 'rating'},
				{data: 'review_approved',
                    render: function(data){
                        let review_approved
                        if(data == 'pending'){
                            review_approved = '<span class="text-warning">Pending</span>'
                        }else if(data == 'approved'){
                            review_approved = '<span class="badge text-success">Approved</span>'
                        }else if(data == 'rejected'){
                            review_approved = '<span class="badge text-danger">Rejected</span>'
                        }
                        return review_approved
                    }
                },
                {data: 'actions'},
            ]
        });
    });

</script>
@endsection
