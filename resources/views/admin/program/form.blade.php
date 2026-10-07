@extends('layouts.temp_admin')
@section('title'){{$title_page}}@endsection

@section('css')
<!-- select2 -->
<link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet" />
<!-- select2-bootstrap4-theme -->
<link href="{{ asset('vendor/select2-bootstrap4-theme/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">
<!--  DataTables.net Plugin, full documentation here: https://datatables.net/    -->
<link rel="stylesheet" href="{{ asset('assets/backend/js/plugins/buttons.dataTables.min.css') }}">
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
</style>
@endsection

@section('content')

@php
if($tab == 'tab1'){
    $active1 = 'active';
    $active2 = '';
}else if($tab == 'tab2'){
    $active1 = '';
    $active2 = 'active';
}else{
    $active1 = 'active';
    $active2 = '';
}
@endphp

<div class="nav-tabs-navigation nomargin">
    <div class="nav-tabs-wrapper">
        <ul id="tabs" class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link {{ $active1 }}" data-toggle="tab" href="#tab1" role="tab" aria-expanded="true">ข้อมูลโปรแกรม</a>
            </li>
            @if (!empty($data))
                <li class="nav-item">
                    <a class="nav-link {{ $active2 }}" data-toggle="tab" href="#tab2" role="tab" aria-expanded="true">ตัวติดตั้งโปรแกรม</a>
                </li>
            @endif
        </ul>
    </div>
</div>
<div id="my-tab-content" class="tab-content">
    <div class="tab-pane {{ $active1 }}" id="tab1" role="tabpanel" aria-expanded="true">
        @if(empty($data))
            {{
                Form::open([
                    'novalidate',
                    'route' => 'program.crate',
                    'id'=>'data-form',
                    'method' => 'post',
                    'files' => true
                ])
            }}
        @else
            {{
                Form::model($data, [
                    'novalidate',
                    'route' => ['program.update',['id'=>$data->id,'tab'=>'tab1']],
                    'id'=>'data-form',
                    'method' => 'put',
                    'files' => true
                ])
            }}
        @endif
            <div class="row">
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group has-label">
                                        <label>ชื่อโปรแกรม<span class="text-danger">*</span></label>
                                        <input class="form-control no-max-height" id="program_name" name="program_name" value="@if(!empty($data->program_name)){{ $data->program_name }}@else{{ old('program_name') }}@endif" />
                                        @error('program_name')<small class="error-danger-text">{{ $message }}</small><br/>@enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group has-label">
                                        <label>คำอธิบายโปรแกรม</label>
                                        <textarea id="editor"  class="form-control" name="program_note">@if(!empty($data->program_note)){{ $data->program_note }}@else{{ old('program_note') }}@endif</textarea>
                                    </div>
                                </div>
                                @if(!empty($data->updated_by))
                                <div class="col-md-12">
                                    <div class="line"></div>
                                    <div class="form-group has-label">
                                        <label>อัพเดตข้อมูลโดย :: {{ $data->updated_by}} :: {{ $data->updated_at}} </label>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="jumbotron">
                                บันทึกแบบร่าง / เผยแพร่
                            </div>
                            <div class="form-group">
                                <input name="show" id="show" class="bootstrap-switch" type="checkbox" data-toggle="switch" data-on-label="<i class='nc-icon nc-check-2'></i>" data-off-label="<i class='nc-icon nc-simple-remove'></i>" data-on-color="success" data-off-color="success"
                                @if(!empty($data->show))
                                    @if($data->show == 1) checked @endif
                                @else checked @endif
                                />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-6">
                                    <a href="{{ route('program.index')}}">
                                        @include('layouts.admin._button.back')
                                    </a>
                                </div>
                                <div class="col-6 right">
                                    @include('layouts.admin._button.submit')
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>
    @if (!empty($data))
    <div class="tab-pane {{ $active2 }}" id="tab2" role="tabpanel" aria-expanded="true">
        <div class="card">
            <div class="card-body">
                <div class="toolbar"></div>
                <table id="datatable" data-json="{{ route('program.install.jsondata',['p'=>$data->id]) }}" data-create="{{ route('program.install.add',$data->id) }}" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th style="width: 15px" class="disabled-sorting text-right"></th>
                        <th >ชื่อตัวติดตั้งโปรแกรม</th>
                        <th style="width: 120px">สถานะ</th>
                        <th style="width: 120px">อัพเดตข้อมูล</th>
                        <th style="width: 170px" class="disabled-sorting text-right">Actions</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
</div>



@include('admin.program.modal.deleteInstall')

@endsection

@section('js')
<!-- select2 -->
<script src="{{ asset('vendor/select2/select2.min.js') }}"></script>
<!-- select2-bootstrap4-theme -->
<script src="{{ asset('vendor/select2-bootstrap4-theme/docs/script.js') }}"></script>
<!-- ckeditor 4 -->
<script src="{{ asset('vendor/ckeditor4/ckeditor.js?v=4') }}"></script>
<!--  DataTables.net Plugin, full documentation here: https://datatables.net/    -->
<script src="{{ asset('assets/backend/js/plugins/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/backend/js/plugins/dataTables.buttons.min.js') }}"></script>

<script>
    CKEDITOR.replace('editor', {
		filebrowserBrowseUrl: '/elfinder/ckeditor', 
		filebrowserImageBrowseUrl: '/elfinder/ckeditor?type=Images',
		filebrowserUploadUrl: '/elfinder/connector?command=QuickUpload&type=Files',
		filebrowserImageUploadUrl: '/elfinder/connector?command=QuickUpload&type=Images'
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
                url: $('#datatable').attr('data-json'),
            },
            order: [[ 1, "desc" ]],
            columnDefs: [
                {
                    'targets': [0,2,4],
                    'className': 'text-center',
                },
            ],
            columns: [
                {data: 'DT_RowIndex'},
                {data: 'name'},
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
                {data: 'actions'},
            ]
        });
    });

</script>

@endsection
