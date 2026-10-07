@extends('layouts.temp_admin')
@section('title'){{$title_page}}@endsection

@section('css')
<!-- select2 -->
<link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet" />
<!-- select2-bootstrap4-theme -->
<link href="{{ asset('vendor/select2-bootstrap4-theme/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">
<!--  DataTables.net Plugin, full documentation here: https://datatables.net/    -->
<link rel="stylesheet" href="{{ asset('assets/backend/js/plugins/buttons.dataTables.min.css') }}">
<link href="{{ asset('vendor/Bootstrap-4-Tag-Input/tagsinput.css') }}" rel="stylesheet">
<style>
    .jumbotron { padding: 1rem; margin-bottom: 1rem; }
    .nav-tabs-navigation {
        text-align: left !important;
        border-bottom: transparent;
        margin-bottom: 0px !important;
    }
    .nav-tabs-navigation.verical-navs {
        border-right: none !important;
        padding: 0px !important;
    }
    .bootstrap-tagsinput{
        padding: 8px !important;
        border: 1px solid#DDDDDD!important;
    }
    .bootstrap-tagsinput .badge {
        margin-bottom: 5px !important;
    }
</style>
@endsection

@section('content')

@php
if($tab == 1){
    $active1 = 'active';
    $active2 = '';
    $active3 = '';
    $active4 = '';
    $active5 = '';
}else if($tab == 2){
    $active1 = '';
    $active2 = 'active';
    $active3 = '';
    $active4 = '';
    $active5 = '';
}else if($tab == 3){
    $active1 = '';
    $active2 = '';
    $active3 = 'active';
    $active4 = '';
    $active5 = '';
}else if($tab == 4){
    $active1 = '';
    $active2 = '';
    $active3 = '';
    $active4 = 'active';
    $active5 = '';
}else if($tab == 5){
    $active1 = '';
    $active2 = '';
    $active3 = '';
    $active4 = '';
    $active5 = 'active';
}else{
    $active1 = 'active';
    $active2 = '';
    $active3 = '';
    $active4 = '';
    $active5 = '';
}
@endphp

    <div class="nav-tabs-navigation">
        <div class="nav-tabs-wrapper">
            <ul id="tabs" class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link {{ $active1}}" data-toggle="tab" href="#information" role="tab" aria-expanded="true">ข้อมูลทั่วไปสินค้า</a>
                </li>
                @if (!empty($data))
                    <li class="nav-item">
                        <a class="nav-link {{ $active2}}" data-toggle="tab" href="#content" role="tab" aria-expanded="false">รายละเอียดสินค้า</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $active3}}" data-toggle="tab" href="#specification" role="tab" aria-expanded="false">สเปกสินค้า</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $active4}}" data-toggle="tab" href="#model" role="tab" aria-expanded="false">รูปแบบสินค้า</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $active5}}" data-toggle="tab" href="#pictures" role="tab" aria-expanded="false">รูปภาพสินค้า</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
    <div id="my-tab-content" class="tab-content">
        <div class="tab-pane {{ $active1}}" id="information" role="tabpanel" aria-expanded="true">
            @include('admin.product.tab-content.information')
        </div>
        @if (!empty($data))
        <div class="tab-pane {{ $active2}}" id="content" role="tabpanel" aria-expanded="false">
            @include('admin.product.tab-content.content')
        </div>
        <div class="tab-pane {{ $active3}}" id="specification" role="tabpanel" aria-expanded="false">
            @include('admin.product.tab-content.specification')
        </div>
        <div class="tab-pane {{ $active4}}" id="model" role="tabpanel" aria-expanded="false">
            @include('admin.product.tab-content.model')
        </div>
        <div class="tab-pane {{ $active5}}" id="pictures" role="tabpanel" aria-expanded="false">
            @include('admin.product.tab-content.pictures')
        </div>
        @endif
    </div>

@include('admin.product.modal.deleteThumb')
@include('admin.product.modal.deleteThumbdetail')
@include('admin.product.modal.deleteFile')
@include('admin.product.modal.deleteFile')
@include('admin.product.modal.deleteSpec')
@include('admin.product.modal.deleteSpecall')
@include('admin.product.modal.deleteDetail')

@endsection

@section('js')

<!--  DataTables.net Plugin, full documentation here: https://datatables.net/    -->
<script src="{{ asset('assets/backend/js/plugins/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/backend/js/plugins/dataTables.buttons.min.js') }}"></script>
<!-- ckeditor 4 -->
<script src="{{ asset('vendor/ckeditor4/ckeditor.js?v=5') }}"></script>
<!-- select2 -->
<script src="{{ asset('vendor/select2/select2.min.js') }}"></script>
<!-- select2-bootstrap4-theme -->
<script src="{{ asset('vendor/select2-bootstrap4-theme/docs/script.js') }}"></script>
<script src="{{ asset('assets/backend/js/plugins/bootstrap-tagsinput.js') }}"></script>

@if(!empty($data))
<script>
	CKEDITOR.replace('editor_highlight', {
		filebrowserBrowseUrl: '/elfinder/ckeditor', 
		filebrowserImageBrowseUrl: '/elfinder/ckeditor?type=Images',
		filebrowserUploadUrl: '/elfinder/connector?command=QuickUpload&type=Files',
		filebrowserImageUploadUrl: '/elfinder/connector?command=QuickUpload&type=Images'
	});
	CKEDITOR.replace('editor_contentpro', {
		filebrowserBrowseUrl: '/elfinder/ckeditor', 
		filebrowserImageBrowseUrl: '/elfinder/ckeditor?type=Images',
		filebrowserUploadUrl: '/elfinder/connector?command=QuickUpload&type=Files',
		filebrowserImageUploadUrl: '/elfinder/connector?command=QuickUpload&type=Images'
	});
	CKEDITOR.replace('editor_feature', {
		filebrowserBrowseUrl: '/elfinder/ckeditor', 
		filebrowserImageBrowseUrl: '/elfinder/ckeditor?type=Images',
		filebrowserUploadUrl: '/elfinder/connector?command=QuickUpload&type=Files',
		filebrowserImageUploadUrl: '/elfinder/connector?command=QuickUpload&type=Images'
	});
	CKEDITOR.replace('editor_gift', {
		filebrowserBrowseUrl: '/elfinder/ckeditor', 
		filebrowserImageBrowseUrl: '/elfinder/ckeditor?type=Images',
		filebrowserUploadUrl: '/elfinder/connector?command=QuickUpload&type=Files',
		filebrowserImageUploadUrl: '/elfinder/connector?command=QuickUpload&type=Images'
	});
</script>
@endif
<script>
    $('.select-multiple').select2();

    if($('#hidden_pro_catsubId').val().length != 0){
        var categoryId_edit        = $('#pro_catId').val();
        var categorysubId_edit     = $('#hidden_pro_catsubId').val();

        $.ajax({
            type: "GET",
            url: '{!! route('product.jsonCatsub') !!}',
            data: { categoryId: categoryId_edit },
            cache: false,
            beforeSend: function () {
            },
            success: function (response) {

                if(response != ""){
                    $("#pro_catsubId").append('<option></option>');
                    $.each(response, function (index, item) {

                        if(categorysubId_edit == item.id){
                            var select = 'selected';
                        }else{
                            var select = '';
                        }
                        $("#pro_catsubId").append(
                            '<option value="' + item.id + '" '+select+'>' + item.categorysub_name + "</option>"
                        );
                    });
                }else{
                    $("#pro_catsubId").append(
                        '<option value="">ไม่มีข้อมูล</option>'
                    );
                }

            },
            failure: function (errMsg) {
                alert(errMsg);
            }
        });
    }

    $('#datatable_spec').DataTable({
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
            url: $('#datatable_spec').attr('data-url'),
        },
        order: [[ 2, "desc" ]],
        columnDefs: [
            {
                'targets': [2],
                'className': 'text-center',
            },
        ],
        columns: [
            {data: 'name'},
            {data: 'detail'},
            {data: 'actions'},
        ]
    });


    if ($("#detail_status").length != 0) {
        var id     = $('#detail_status').val();
        var url    = $('#detail_status').data('url');

        $.ajax({
            type: "GET",
            url: url,
            data: { id: id },
            cache: false,
            beforeSend: function () {
            },
            success: function (response) {

                if(response != ""){
                    $.each(response, function (index, item) {
                        if(item.stu_preorder == 1){
                            document.getElementById("block_hidden").classList.remove("hidden");
                        }else{
                            document.getElementById("block_hidden").classList.add("hidden");
                        }
                    });
                }

            },
            failure: function (errMsg) {
                alert(errMsg);
            }
        });
    };
</script>

<script>
    $(document).ready(function () {
        $('#datatableDetail').DataTable({
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
            buttons: [
                {
                    text: '<i class="nc-icon nc-minimal-left"></i>&nbsp;&nbsp;ย้อนกลับ',
                    className: 'btn  btn-outline-danger',
                    init: function(api, node, config) {
                        $(node).removeClass('dt-button')
                    },
                    action: function(e, dt, node, config) {
                        location.href = $('#datatableDetail').attr('data-back');
                    }
                },
                {
                    text: '<i class="fa fa-plus"></i>&nbsp;&nbsp;เพิ่มข้อมูล',
                    className: 'btn  btn-outline-primary',
                    init: function(api, node, config) {
                        $(node).removeClass('dt-button')
                    },
                    action: function(e, dt, node, config) {
                        location.href = $('#datatableDetail').attr('data-create');
                    }
                }
            ],
            ajax: {
                url: $('#datatableDetail').attr('data-json'),
            },
            order: [[ 5, "asc" ]],
            columnDefs: [
                {
                    'targets': [0,1,5,7,9],
                    'className': 'text-center',
                },
                {
                    'targets': [4],
                    'className': 'text-right',
                },
            ],
            columns: [
                {data: 'DT_RowIndex'},
                {data: 'img'},
                {data: 'sku'},
                {data: 'name'},
                {data: 'price'},
                {data: 'detail_stock'},
                {data: 'status'},
                {data: 'show',
                    render: function(data){
                        let show
                        if(data == 2){
                            show = '<span class="badge badge-danger">ปิดใช้งาน</span>'
                        }else if(data == 1){
                            show = '<span class="badge badge-success">เปิดใช้งาน</span>'
                        }
                        return show
                    }
                },
                {data: 'updated'},
                {data: 'actions'},
            ]
        });
    });

</script>

@endsection
