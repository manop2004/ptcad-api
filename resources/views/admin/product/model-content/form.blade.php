@extends('layouts.temp_admin')
@section('title'){{$title_page}}@endsection

@section('css')
<!-- select2 -->
<link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet" />
<!-- select2-bootstrap4-theme -->
<link href="{{ asset('vendor/select2-bootstrap4-theme/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">

<style>
    .jumbotron { padding: 1rem; margin-bottom: 1rem; }
 </style>
@endsection

@section('content')

@if(empty($detail))
    {{
        Form::open([
            'novalidate',
            'route' => 'product.detail.crate',
            'id'=>'data-form',
            'method' => 'post',
            'files' => true
        ])
    }}
@else
    {{
        Form::model($detail, [
            'novalidate',
            'route' => ['product.detail.updateModel',[$detail->id]],
            'id'=>'data-form',
            'method' => 'put',
            'files' => true
        ])
    }}
@endif

    <div class="row">
        @include('admin.product.model-content.content')
        <div class="col-md-9">
            <div class="card">
                <div class="card-footer">
                    <div class="row">
                        <div class="col-6">
                            <a href="{{ route('product.edit',['tab'=>4,'id'=>$id])}}">
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
        <div class="col-md-3"></div>
    </div>

</form>


@include('admin.product.modal.deleteThumbdetail')

@endsection

@section('js')
<!-- select2 -->
<script src="{{ asset('vendor/select2/select2.min.js') }}"></script>
<!-- select2-bootstrap4-theme -->
<script src="{{ asset('vendor/select2-bootstrap4-theme/docs/script.js') }}"></script>

<script>
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

    function keepOnlyInteger(value) {
        return String(value || '').replace(/\D/g, '');
    }

    function bindOnlyIntegerInput(selector) {
        $(document).on('input', selector, function () {
            const cleaned = keepOnlyInteger($(this).val());
            if ($(this).val() !== cleaned) {
                $(this).val(cleaned);
            }
        });

        $(document).on('paste', selector, function (e) {
            e.preventDefault();
            const pasted = (e.originalEvent || e).clipboardData.getData('text');
            document.execCommand('insertText', false, keepOnlyInteger(pasted));
        });

        $(document).on('drop', selector, function (e) {
            e.preventDefault();
            const dropped = (e.originalEvent || e).dataTransfer.getData('text');
            $(this).val(keepOnlyInteger(dropped));
        });

        $(document).on('keypress', selector, function (e) {
            const charCode = e.which ? e.which : e.keyCode;

            if (
                charCode === 8 ||
                charCode === 9 ||
                charCode === 13 ||
                charCode === 27
            ) {
                return true;
            }

            if (charCode < 48 || charCode > 57) {
                e.preventDefault();
                return false;
            }
        });
    }

    $(document).ready(function () {
        bindOnlyIntegerInput('.only-integer');

        $('.only-integer').each(function () {
            $(this).val(keepOnlyInteger($(this).val()));
        });
    });
</script>
@endsection
