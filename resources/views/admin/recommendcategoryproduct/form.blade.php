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

<div class="row">
    <div class="col-md-12">
        @if(empty($data))
            {{
                Form::open([
                    'novalidate',
                    'route' => 'recommend.category.product.crate',
                    'id'=>'data-form',
                    'method' => 'post',
                    'files' => true
                ])
            }}
        @else
            {{
                Form::model($data, [
                    'novalidate',
                    'route' => ['recommend.category.product.update',[$data->id]],
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
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <div class="form-check-radio display-inline-block">
                                            <label class="form-check-label">
                                            <input class="form-check-input" data-value="1" type="radio" name="option_type" id="recommendType1" @if(!empty($data->option_type)) @if($data->option_type == 1) checked @endif @else checked @endif> หมวดหมู่สินค้าหลัก
                                            <span class="form-check-sign"></span>
                                            </label>
                                        </div>
                                        <div class="form-check-radio display-inline-block">
                                            <label class="form-check-label">
                                            <input class="form-check-input" data-value="1" type="radio" name="option_type" id="recommendType2"  @if(!empty($data->option_type)) @if($data->option_type == 2) checked @endif @endif> หมวดหมู่สินค้าย่อย
                                            <span class="form-check-sign"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>หมวดหมู่สินค้า</label>
                                        <select id="categoryId" name="categoryId" class="form-control" data-placeholder="กรุณาเลือกข้อมูล" ></select>
                                        @error('categoryId')<small class="error-danger-text">{{ $message }}</small> @enderror
                                        <input type="hidden" name="old_cat" id="old_cat" value="@if(!empty($data->categoryId)){{ $data->categoryId }}@endif" >
                                        <input type="hidden" name="old_option_type" id="old_option_type" value="@if(!empty($data->option_type)){{ $data->option_type }}@else{{ '1' }}@endif" >
                                        <input type="hidden" name="old_recommend_product" id="old_recommend_product" value="@if(!empty($data->recommend_product)){{ $data->recommend_product }}@endif" >
                                    </div>
                                    <div class="form-group">
                                        <label>เลือกสินค้าแนะนำ 4 รายการเพื่อแสดงในหมวดหมู่นี้</label>
                                        <select id="recommend_product_category" name="recommend_product_category[]" data-placeholder="กรุณาเลือกข้อมูล" class="form-control select-multiple" multiple="multiple" > </select>
                                        @error('recommend_product_category')<small class="error-danger-text">{{ $message }}</small> @enderror
                                    </div>
                                    <div >
                                        <label>ภาพสินค้า</label>
                                        <input type="file" accept="image/*" class="form-control" id="thumb" name="thumb" onchange="readURL1(this);">
                                        <br/>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    @if(!empty($data->thumb))
                                    <a href="#" class="remove-logo" data-toggle="modal" data-target="#deleteThump" onclick="deleteModal(this)" href="#" data-id="{{ $data->id }}" data-name="{{ $data->thumb }}">
                                        <button class="btn btn-icon btn-round btn-google" type="button">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </a>
                                    @endisset
                                    <div class="text-align-center">
                                        @isset($data->thumb)
                                            <input type="hidden" class="form-control" id="thumb_old" name="thumb_old" value="{{ $data->thumb }}">
                                            <img id="blah1" src="{{ asset('storage/recommendProduct/'.$data->thumb) }}" alt="" class="full-width" rel="nofollow">
                                        @else
                                            <img id="blah1" src="{{ asset('images/default-img/default-img_421_683.png')}}" alt="..." class="full-width" rel="nofollow">
                                        @endisset
                                    </div>
                                    <p></p><small>ขนาดภาพแนะนำ 421 X 683 PX</small><br/>
                                    <small class="error-danger-text">* หากไฟล์ภาพมีขนาดไม่เท่ากับที่กำหนด ไฟล์จะบีบอัดอัตโนมัติเพื่อให้ได้ขนาดที่ต้องการ (อาจทำให้ภาพยืดหรือหดได้)</small><br/>
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
                            <hr/>
                            <div class="jumbotron">
                                ลำดับการแสดงผล
                            </div>
                            <div class="form-group">
                                <input class="form-control no-max-height" id="sort" name="sort" placeholder="0" value="@if(!empty($data->sort)){{ $data->sort }}@else @if(!empty(old('sort'))) {{ old('sort') }} @else @if(!empty($sort)){{ $sort->sort+1 }}@else{{ "1" }}@endif @endif @endif" />
                                <p><small class="error-danger-text">* เรียงลำดับโดยตัวเลขมากที่สุดขึ้นก่อน</small></p>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-6">
                                    <a href="{{ route('recommend.category.product.index')}}">
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
</div>

@include('admin.recommendcategoryproduct.modal.deleteThumb')

@endsection

@section('js')
<!-- select2 -->
<script src="{{ asset('vendor/select2/select2.min.js') }}"></script>
<!-- select2-bootstrap4-theme -->
<script src="{{ asset('vendor/select2-bootstrap4-theme/docs/script.js') }}"></script>

<script>
$(document).ready(function() {
    var recommendType1  = $('#old_option_type').val();
    var recommendType2  = '';
    var old_cat         = $('#old_cat').val();
    var select_recommend_product = $('#old_recommend_product').val();

    $.ajax({
        type: "GET",
        url: '/recommend/category/product/jsonGet',
        data: { catId: recommendType1, subcatId: recommendType2, old_cat:old_cat},
        cache: false,
        beforeSend: function () {},
        success: function (response) {

            $("#categoryId").html('<option value=""></option>');
            $("#recommend_product_category").html('<option value=""></option>');
            if(response != ""){

                $.each(response, function (index, item) {
                    $("#categoryId").append(
                        '<option value="' + item.id + '" ' + item.selected + '>' + item.category_name + "</option>"
                    );
                });
            }else{
                $("#categoryId").append(
                    '<option value="">ไม่มีข้อมูล</option>'
                );
            }

        },
        failure: function (errMsg) {
            alert(errMsg);
        }
    });

    if (select_recommend_product.length != 0) {
        $.ajax({
            type: "GET",
            url: '/recommend/category/product/jsonproductGet',
            data: {
                type: recommendType1,
                categoryId: old_cat,
                recommend_product:select_recommend_product
            },
            cache: false,
            beforeSend: function () {},
            success: function (response) {

                $("#recommend_product_category").html('<option value=""></option>');

                if(response != ""){
                    var selected = "";
                    $.each(response, function (index, item) {

                        $("#recommend_product_category").append(
                            '<option value="' + item.id + '" ' + item.selected + '>' + item.pro_name + "</option>"
                        );
                    });
                }else{
                    $("#recommend_product_category").append(
                        '<option value="">ไม่มีข้อมูล</option>'
                    );
                }

            },
            failure: function (errMsg) {
                alert(errMsg);
            }
        });
    }

    
});
</script>
@endsection
