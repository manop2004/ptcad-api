@php
    $UserLevel = App\Models\UsersLevel::where('UserId',Auth::user()->id)->first();
@endphp
@extends('layouts.temp_admin')
@section('title'){{$title_page}}@endsection

@section('css')

<link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendor/select2-bootstrap4-theme/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">

<style>
    #datatable td,
    #datatable th {
        vertical-align: middle !important;
    }

    #datatable thead th:first-child,
    #datatable tbody td:first-child {
        text-align: center;
        width: 15px;
        white-space: nowrap;
    }

    .select-summary {
        margin-top: 8px;
        margin-bottom: 10px;
        font-size: 13px;
    }

    .select-summary span {
        display: inline-block;
        padding: 3px 8px;
        border-radius: 12px;
        background: #f1f3f5;
    }

    .selection-actions {
        margin-bottom: 10px;
    }

    .selection-actions .btn {
        margin-right: 6px;
        margin-bottom: 6px;
    }

    .row-checkbox,
    #check-all-visible {
        cursor: pointer;
    }
</style>
<style>
    #datatable td,
    #datatable th {
        vertical-align: middle !important;
    }

    #datatable thead th:first-child,
    #datatable tbody td:first-child {
        text-align: center;
        width: 15px;
        white-space: nowrap;
    }

    .select-summary {
        margin-top: 8px;
        margin-bottom: 10px;
        font-size: 13px;
    }

    .select-summary span {
        display: inline-block;
        padding: 3px 8px;
        border-radius: 12px;
        background: #f1f3f5;
    }

    .selection-actions {
        margin-bottom: 10px;
    }

    .selection-actions .btn {
        margin-right: 6px;
        margin-bottom: 6px;
    }

    .row-checkbox,
    #check-all-visible {
        cursor: pointer;
    }

    /* ===== fix ปุ่ม import / export ให้เท่ากัน ===== */
    .toolbar .form-group {
        margin-bottom: 1rem;
    }

    .toolbar .btn-toolbar-equal,
    .toolbar .btn-toolbar-equal.btn,
    .toolbar .btn-toolbar-equal > .btn {
        width: 100%;
        min-height: 46px;
        height: 46px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: .25rem;
        font-weight: 600;
        padding: .375rem .75rem;
        line-height: 1.2;
    }

    .toolbar .dropdown {
        width: 100%;
    }

    .toolbar .dropdown .dropdown-toggle {
        width: 100%;
        min-height: 46px;
        height: 46px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: .25rem;
        font-weight: 600;
        padding: .375rem .75rem;
        line-height: 1.2;
    }

    .toolbar .dropdown-menu {
        width: 100%;
        min-width: 100%;
    }

    /* ===== export สีเหลือง ===== */
    .btn-export-yellow {
        background-color: #f4c542;
        border-color: #f4c542;
        color: #ffffff !important;
    }

    .btn-export-yellow:hover,
    .btn-export-yellow:focus,
    .btn-export-yellow:active,
    .show > .btn-export-yellow.dropdown-toggle {
        background-color: #e0b22d;
        border-color: #e0b22d;
        color: #ffffff !important;
    }

    .btn-export-yellow::after {
        margin-left: .55rem;
    }
	.toolbar a.btn-toolbar-equal > .btn,
	.toolbar a.btn-toolbar-equal button {
		width: 100%;
		min-height: 46px;
		height: 46px;
		display: inline-flex;
		align-items: center;
		justify-content: center;
	}
	.toolbar .row > div {
		display: flex;
		flex-direction: column;
	}

	.toolbar .row > div .form-group {
		flex: 1;
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
            <div class="toolbar">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <input class="form-control" id="searchSKU" name="searchSKU" placeholder="ค้นหาข้อมูลรหัสสินค้า" onkeyup="loadFilter(this)"/>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <input class="form-control" id="search" name="search" placeholder="ค้นหาข้อมูลชื่อสินค้า" onkeyup="loadFilter(this)"/>
                        </div>
                    </div>
                    @if($UserLevel->l_product_Import == 1)
					<div class="col-md-3">
						<div class="form-group">
							<a href="#" data-toggle="modal" data-target="#importProduct" class="d-block btn-toolbar-equal">
								@include('layouts.admin._button.import')
							</a>
						</div>
					</div>
					@endif
                    @if($UserLevel->l_product_Export == 1)
					<div class="col-md-3">
						<div class="form-group">
							<div class="dropdown w-100">
								<button class="btn btn-export-yellow dropdown-toggle btn-toolbar-equal" type="button" id="exportDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<i class="fa fa-file-excel-o mr-1"></i> Export
								</button>
								<div class="dropdown-menu" aria-labelledby="exportDropdown">
									<a class="dropdown-item btn-export-type" href="javascript:void(0);" data-export-type="promotion">
										Export สำหรับแก้ไขโปรโมชั่น
									</a>
									<a class="dropdown-item btn-export-type" href="javascript:void(0);" data-export-type="main">
										Export สำหรับแก้ไขข้อมูลหลัก
									</a>
									<a class="dropdown-item btn-export-type" href="javascript:void(0);" data-export-type="all">
										Export ข้อมูลทั้งหมด
									</a>
								</div>
							</div>
						</div>
					</div>
					@endif
                </div>

                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="form-group">
                            <select id="pro_catId" name="pro_catId" class="form-control" data-url="{{ route('product.jsonCatsub')}}" onchange="callChange(this)">
                                <option value="">--เลือกหมวดหมู่สินค้า--</option>
                                @foreach ($categorys as $category)
                                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="form-group">
                            <select id="pro_catsubId" name="pro_catsubId" class="form-control" onchange="loadFilter(this)">
                                <option value="">--เลือกหมวดหมู่ย่อยสินค้า--</option>
                            </select>
                        </div>
                    </div>
                </div>

                

                @if($UserLevel->l_product_Action == 1)
                    <a href="{{ route('product.add') }}">
                        <button class="btn btn-outline-primary notopmargin" type="button">
                            <span><i class="fa fa-plus"></i> เพิ่มข้อมูล</span>
                        </button>
                    </a>
                @endif

                @include('layouts.admin._button.reload')
				
				@if($UserLevel->l_product_Export == 1)
                <div class="selection-actions">
                    <button type="button" class="btn btn-sm btn-outline-primary" id="btn-select-page">เลือกทั้งหมดในหน้าปัจจุบัน</button>
                    <button type="button" class="btn btn-sm btn-outline-success" id="btn-select-all-filtered">เลือกทั้งหมดตามผลการค้นหา</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" id="btn-clear-selection">ล้างรายการที่เลือก</button>
                </div>

                <div class="select-summary">
                    <span id="selection-status-text">เลือกแล้ว <strong id="selected-count">0</strong> รายการ</span>
                </div>
                @endif

                @if ($errors->any())
                    <br/>
                    <div class="alert alert-danger" role="alert">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif
            </div>

            <table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th style="width: 15px" class="disabled-sorting">
                        <input type="checkbox" id="check-all-visible">
                    </th>
                    <th style="width: 80px" class="disabled-sorting"></th>
                    <th style="width: 140px" class="disabled-sorting">SKU</th>
                    <th class="disabled-sorting">ชื่อสินค้า</th>
                    <th style="width: 120px" class="disabled-sorting text-right">ราคาสินค้า</th>
                    <th style="width: 80px">สถานะ</th>
                    <th style="width: 120px">อัพเดตข้อมูล</th>
                    <th style="width: 130px" class="disabled-sorting">Actions</th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>

            @if($UserLevel->l_product_Export == 1)
            <form id="export-form" action="{{ route('product.export.excel') }}" method="POST" style="display:none;">
				@csrf
				<input type="hidden" name="mode" id="export_mode" value="selected">
				<input type="hidden" name="export_type" id="export_type" value="all">
				<input type="hidden" name="category" id="export_category">
				<input type="hidden" name="subcategory" id="export_subcategory">
				<input type="hidden" name="search" id="export_search">
				<input type="hidden" name="searchSKU" id="export_searchSKU">
				<div id="selected-products-container"></div>
				<div id="excluded-products-container"></div>
			</form>
            @endif
        </div>
      </div>
    </div>
</div>

@include('admin.product.modal.delete')

<div class="modal fade" id="importProduct" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                  <i class="nc-icon nc-simple-remove"></i>
                </button>
                <h5 class="modal-title" id="myModalLabel">นำเข้าไฟล์สินค้า</h5>
            </div>
            <div class="modal-body">
                {{
                    Form::open([
                        'novalidate',
                        'route' => 'product.import.excel',
                        'class' => ($errors->any()) ? 'was-validated form-horizontal' : 'needs-validation form-horizontal',
                        'id'=>'import-form',
                        'method' => 'post',
                        'files' => true
                    ])
                }}
                    นำเข้าไฟล์ .xls, .xlsx, .csv สำหรับอัพเดตราคาสินค้า โดยอ้างอิงจากรหัสสินค้า
                    <hr/>
                    หากต้องการกำหนดสถานะสินค้าโดยการนำเข้าไฟล์ จะต้องอ้างอิงรหัสด้านล่าง
                    @foreach ($statuss as $status)
                        <div>{{$status->id}} = {{$status->stu_name}}</div>
                    @endforeach
                    <p class="text-danger">หากต้องการกำหนดวันที่พรีออเดอร์ ให้ใส่เฉพาะจำนวนวันเท่านั้น</p>
                    <div class="alert alert-danger alert-dismissible show" role="alert">
                        หมายเหตุ : การอัพเดตราคาสินค้าจะต้องอ้างอิงรหัสสินค้า หากไม่เคยมีประวัติสินค้าในระบบจะไม่สามารถอัพเดตราคาได้ กรุณาตรวจสอบข้อมูลก่อนการอัพเดตราคาทุกครั้ง!!
                    </div>
                    <input accept="file/.xls,.xlsx,.csv" type="file" id="import" name="import" class="form-control" />
                    <br/>
                    <div class="form-group">
                        <textarea id="import_note" name="import_note" class="form-control" placeholder=" รายละเอียดการอัพเดตข้อมูล "></textarea>
                    </div>
                    <a href="{{ asset('assets/backend/files/template_import_product_price.xlsx?v=202603') }}" download="">ดาวน์โหลดไฟล์ Template</a>
                    <div class="row">
                        <div class="col-6"></div>
                        <div class="col-6 right">
                            @include('layouts.admin._button.submit')
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script src="{{ asset('vendor/select2/select2.min.js') }}"></script>
<script src="{{ asset('vendor/select2-bootstrap4-theme/docs/script.js') }}"></script>
<script src="{{ asset('assets/backend/js/plugins/jquery.dataTables.min.js') }}"></script>

<script>
    let selectedIds = new Set();
    let excludedIds = new Set();
    let isSelectAllFiltered = false;

    var filtering = function() {
        DataTable.ajax.reload(null, false);
    }

    function updateSelectedCount() {
        if (isSelectAllFiltered) {
            $('#selection-status-text').html('เลือกทั้งหมดตามผลการค้นหา <strong>ยกเว้น ' + excludedIds.size + ' รายการ</strong>');
        } else {
            $('#selection-status-text').html('เลือกแล้ว <strong id="selected-count">' + selectedIds.size + '</strong> รายการ');
        }
    }

    function isRowChecked(id) {
        id = String(id);

        if (isSelectAllFiltered) {
            return !excludedIds.has(id);
        }

        return selectedIds.has(id);
    }

    function syncCheckboxState() {
        $('.row-checkbox').each(function () {
            let id = String($(this).data('id'));
            $(this).prop('checked', isRowChecked(id));
        });

        let allVisible = $('.row-checkbox').length;
        let checkedVisible = $('.row-checkbox:checked').length;

        $('#check-all-visible').prop('checked', allVisible > 0 && allVisible === checkedVisible);

        updateSelectedCount();
    }

    function clearSelection() {
        selectedIds.clear();
        excludedIds.clear();
        isSelectAllFiltered = false;
        syncCheckboxState();
    }

    function loadFilter(e) {
        filtering();
    }

    function callChange(e) {
        getSubcat(e);
        loadFilter();
    }

    function getSubcat(e) {
        var categoryId = $(e).val();
        var url = $(e).data('url');

        $.ajax({
            type: "GET",
            url: url,
            data: { categoryId: categoryId },
            cache: false,
            beforeSend: function () {},
            success: function (response) {
                if (response.length != 0) {
                    $("#pro_catsubId").html('');
                    $("#pro_catsubId").html('<option value="">เลือกหมวดหมู่ย่อย</option>');
                    $.each(response, function (index, item) {
                        $("#pro_catsubId").append('<option value="' + item.id + '">' + item.categorysub_name + "</option>");
                    });
                } else {
                    $("#pro_catsubId").html('');
                    $("#pro_catsubId").append('<option value="">ไม่มีหมวดหมู่ย่อย</option>');
                }
            },
            failure: function (errMsg) {
                alert(errMsg);
            }
        });
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
            url: '{!! route('product.jsondata') !!}',
            dataType: 'json',
            type: "GET",
            data: function(d) {
                d.category = $('#pro_catId').val();
                d.subcategory = $('#pro_catsubId').val();
                d.search = $('#search').val();
                d.searchSKU = $('#searchSKU').val();
            },
        },
        columnDefs: [
            {
                'targets': [0,1,5,7],
                'className': 'text-center',
            },
            {
                'targets': [4],
                'className': 'text-right',
            },
        ],
        columns: [
            {
                data: 'checkbox',
                orderable: false,
                searchable: false,
            },
            {data: 'img'},
            {data: 'sku'},
            {data: 'name'},
            {data: 'price'},
            {
                data: 'show',
                render: function(data){
                    let status = '';
                    if(data == 2){
                        status = '<span class="badge badge-danger">ปิดใช้งาน</span>';
                    }else if(data == 1){
                        status = '<span class="badge badge-success">เปิดใช้งาน</span>';
                    }
                    return status;
                }
            },
            {data: 'updated'},
            {data: 'actions'},
        ],
        drawCallback: function() {
            syncCheckboxState();
        }
    });

    $('#datatable').on('change', '.row-checkbox', function () {
        let id = String($(this).data('id'));
        let checked = $(this).is(':checked');

        if (isSelectAllFiltered) {
            if (checked) {
                excludedIds.delete(id);
            } else {
                excludedIds.add(id);
            }
        } else {
            if (checked) {
                selectedIds.add(id);
            } else {
                selectedIds.delete(id);
            }
        }

        syncCheckboxState();
    });

    $('#check-all-visible').on('change', function () {
        let isChecked = $(this).is(':checked');

        $('.row-checkbox').each(function () {
            let id = String($(this).data('id'));

            if (isSelectAllFiltered) {
                if (isChecked) {
                    excludedIds.delete(id);
                    $(this).prop('checked', true);
                } else {
                    excludedIds.add(id);
                    $(this).prop('checked', false);
                }
            } else {
                if (isChecked) {
                    selectedIds.add(id);
                    $(this).prop('checked', true);
                } else {
                    selectedIds.delete(id);
                    $(this).prop('checked', false);
                }
            }
        });

        syncCheckboxState();
    });

    $('#btn-select-page').on('click', function () {
        isSelectAllFiltered = false;
        $('.row-checkbox').each(function () {
            let id = String($(this).data('id'));
            selectedIds.add(id);
        });
        syncCheckboxState();
    });

    $('#btn-select-all-filtered').on('click', function () {
        isSelectAllFiltered = true;
        selectedIds.clear();
        excludedIds.clear();
        syncCheckboxState();
    });

    $('#btn-clear-selection').on('click', function () {
        clearSelection();
    });

    $(document).on('click', '.btn-export-type', function (e) {
		e.preventDefault();

		let exportType = $(this).data('export-type') || 'all';

		if (!isSelectAllFiltered && selectedIds.size === 0) {
			alert('กรุณาเลือกรายการสินค้าก่อน Export');
			return false;
		}

		$('#export_mode').val(isSelectAllFiltered ? 'all_filtered' : 'selected');
		$('#export_type').val(exportType);
		$('#export_category').val($('#pro_catId').val());
		$('#export_subcategory').val($('#pro_catsubId').val());
		$('#export_search').val($('#search').val());
		$('#export_searchSKU').val($('#searchSKU').val());

		$('#selected-products-container').html('');
		$('#excluded-products-container').html('');

		if (isSelectAllFiltered) {
			Array.from(excludedIds).forEach(function (id) {
				$('#excluded-products-container').append(
					'<input type="hidden" name="excluded_ids[]" value="' + id + '">'
				);
			});
		} else {
			Array.from(selectedIds).forEach(function (id) {
				$('#selected-products-container').append(
					'<input type="hidden" name="selected_ids[]" value="' + id + '">'
				);
			});
		}

		$('#export-form').submit();
	});

    updateSelectedCount();
</script>
@endsection