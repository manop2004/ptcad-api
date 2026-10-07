@extends('layouts.temp_admin')
@section('title'){{ $title_page }}@endsection

@section('css')
 <!-- select2 -->
 <link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet" />
 <!-- select2-bootstrap4-theme -->
 <link href="{{ asset('vendor/select2-bootstrap4-theme/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">

 <style>
    .jumbotron { padding: 1rem; margin-bottom: 1rem; }
    .nav-tabs-navigation {
        text-align: left !important;
    }
 </style>
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        @if(empty($data))
            {{
                Form::open([
                    'novalidate',
                    'route' => 'promotion.coupon.crate',
                    'id'=>'data-form',
                    'method' => 'post',
                    'files' => true
                ])
            }}
        @else
            {{
                Form::model($data, [
                    'novalidate',
                    'route' => ['promotion.coupon.update',[$data->id]],
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
                                    <label>รหัสคูปอง *</label>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input name="coupon_code" id="coupon_code" type="text" class="form-control" @if(!empty($data->coupon_code)) disabled value="{{ $data->coupon_code }}" @else @if(!empty(old('coupon_code'))) value="{{ old('coupon_code') }}" @endif @endif >
                                        @error('coupon_code')<small class="error-danger-text">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    @if(empty($data->coupon_code))
                                    <div class="form-group">
                                        <button class="btn btn-primary nomargin" type="button" onclick="generateCodeCoupon()">Gennerate coupon code</button>
                                    </div>
                                    @endif
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>ชื่อคูปอง *</label>
                                        <input name="coupon_name" id="coupon_name" type="text" class="form-control" @if(!empty($data->coupon_name)) value="{{ $data->coupon_name }}" @else @if(!empty(old('coupon_name'))) value="{{ old('coupon_name') }}" @endif @endif>
                                        <small><label>*ชื่อคูปองจะถูกแสดงให้สมาชิกเห็นใน "โค้ดส่วนลดของฉัน"</label></small>
                                        @error('coupon_name')<br/><small class="error-danger-text">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label>ภาพคูปอง</label>
                                    <input type="file" class="form-control" name="coupon_img" id="coupon_img" onchange="readURL1(this);" accept="image/*">
                                    <input type="hidden" name="coupon_img_old" id="coupon_img_old" @if(!empty($data->coupon_img)) value="{{ $data->coupon_img }}" @else @if(!empty(old('coupon_img'))) value="{{ old('coupon_img') }}" @endif @endif>
                                    <div class="form-group">
                                        <small><label>*ขนาดภาพ 300 X 300 PX</label></small>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>คำอธิบาย (ถ้ามี)</label>
                                        <textarea  name="coupon_des" id="coupon_des" class="form-control" >@if(!empty($data->coupon_des)){{ $data->coupon_des }}@else @if(!empty(old('coupon_des'))){{ old('coupon_des') }}@endif @endif</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="nav-tabs-navigation">
                                <div class="nav-tabs-wrapper">
                                    <ul id="tabs" class="nav nav-tabs" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active show" data-toggle="tab" href="#home" role="tab" aria-expanded="true" aria-selected="false">ทั่วไป</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#condition" role="tab" aria-expanded="false" aria-selected="false">เงื่อนไขการใช้คูปอง</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#limit" role="tab" aria-expanded="false" aria-selected="true">ลิมิตจำนวนการใช้</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div id="my-tab-content" class="tab-content">
                                <div class="tab-pane active show" id="home" role="tabpanel" aria-expanded="true">
                                    <div class="row">
                                        <div class="col-md-2 text-right">
                                            <div class="form-group">
                                                ประเภทส่วนลด *
                                            </div>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="form-group">
                                                <select name="coupon_type" id="coupon_type" type="text" class="form-control">
                                                    <option value="1" @if(!empty($data->coupon_type)) @if($data->coupon_type == 1) selected @endif @else @if(!empty(old('coupon_des')))  @if(old('coupon_des') == 1) selected @endif @endif @endif>ส่วนลดคงที่</option>
                                                    <option value="2" @if(!empty($data->coupon_type)) @if($data->coupon_type == 2) selected @endif @else @if(!empty(old('coupon_des')))  @if(old('coupon_des') == 2) selected @endif @endif @endif>เปอร์เซ็นส่วนลด</option>
                                                </select>
                                                @error('coupon_type')<small class="error-danger-text">{{ $message }}</small> @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2 text-right">
                                            <div class="form-group">
                                               จำนวนส่วนลด *
                                            </div>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="form-group">
                                                <input name="coupon_discount" id="coupon_discount" type="text" class="form-control number" @if(!empty($data->coupon_discount)) value="{{ $data->coupon_discount }}" @else @if(!empty(old('coupon_discount'))) value="{{ old('coupon_discount') }}" @endif @endif>
                                                @error('coupon_discount')<small class="error-danger-text">{{ $message }}</small> @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2 text-right">
                                            <div class="form-group">
                                                วันที่คูปองหมดอายุ *
                                            </div>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="form-group">
                                                <input name="coupon_date_exp" id="coupon_date_exp" type="text" class="form-control datepicker" @if(!empty($data->coupon_date_exp)) value="{{ date("d-m-Y",strtotime($data->coupon_date_exp)) }}" @endif>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="condition" role="tabpanel" aria-expanded="false">
                                    <div class="row">
                                        <div class="col-md-2 text-right">
                                            <div class="form-group">
                                                ยอดสั่งซื้อขั้นต่ำ
                                            </div>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="form-group">
                                                <input name="min_order_amount" id="min_order_amount" type="text" class="form-control number" @if(!empty($data->min_order_amount)) value="{{ $data->min_order_amount }}" @else @if(!empty(old('min_order_amount'))) value="{{ old('min_order_amount') }}" @endif @endif>
                                                @error('min_order_amount')<small class="error-danger-text">{{ $message }}</small> @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2 text-right">
                                            <div class="form-group">
                                                ยอดสั่งซื้อสูงสุด
                                            </div>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="form-group">
                                                <input name="max_order_amount" id="max_order_amount" type="text" class="form-control number" @if(!empty($data->max_order_amount)) value="{{ $data->max_order_amount }}" @else @if(!empty(old('max_order_amount'))) value="{{ old('max_order_amount') }}" @endif @endif>
                                                @error('max_order_amount')<small class="error-danger-text">{{ $message }}</small> @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2 text-right">
                                            <div class="form-group">
                                                ไม่รวมสินค้าลดราคา
                                            </div>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="form-group">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                      <input name="status_product_not_sale" id="status_product_not_sale" class="form-check-input" type="checkbox" value="1" @if(!empty($data->status_product_not_sale)) @if($data->status_product_not_sale == 1) checked @endif @else @if(!empty(old('status_product_not_sale'))) @if(old('status_product_not_sale') == 1) checked @endif @endif @endif>
                                                      <span class="form-check-sign"></span>
                                                      เลือก หากคูปองไม่สามารถใช้ร่วมกับสินค้าลดราคาได้
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr/>
                                    <div class="row">
                                        <div class="col-md-2 text-right">
                                            <div class="form-group">
                                                เฉพาะสินค้า
                                            </div>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="form-group">
                                                @if (!empty($data->participating_products))
                                                    @php
                                                        $participating_products = explode(",",$data->participating_products);
                                                    @endphp
                                                    <select id="participating_products" name="participating_products[]" class="form-control select-multiple" multiple="multiple" >
                                                        @foreach ( $products as $product)
                                                        <option value="{{ $product->id }}" @foreach($participating_products as $key => $special_participatingId) @if($product->id == $special_participatingId) selected @endif  @endforeach >{{ $product->pro_name }}</option>
                                                        @endforeach
                                                    </select>
                                                @else
                                                    <select id="participating_products" name="participating_products[]" class="form-control select-multiple" multiple="multiple" >
                                                        @foreach ( $products as $product)
                                                            <option value="{{ $product->id }}" >{{ $product->pro_name }}</option>
                                                        @endforeach
                                                    </select>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2 text-right">
                                            <div class="form-group">
                                                สินค้าที่ไม่ร่วมรายการ
                                            </div>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="form-group">
                                                @if (!empty($data->non_participating_products))
                                                    @php
                                                        $non_participating_products = explode(",",$data->non_participating_products);
                                                    @endphp
                                                    <select id="non_participating_products" name="non_participating_products[]" class="form-control select-multiple" multiple="multiple" >
                                                        @foreach ( $products as $product)
                                                        <option value="{{ $product->id }}"@foreach ( $non_participating_products as $key => $special) @if($product->id == $special) selected @endif  @endforeach >{{ $product->pro_name }}</option>
                                                        @endforeach
                                                    </select>
                                                @else
                                                    <select id="non_participating_products" name="non_participating_products[]" class="form-control select-multiple" multiple="multiple" >
                                                        @foreach ( $products as $product)
                                                            <option value="{{ $product->id }}" >{{ $product->pro_name }}</option>
                                                        @endforeach
                                                    </select>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <hr/>
                                    <div class="row">
                                        <div class="col-md-2 text-right">
                                            <div class="form-group">
                                                เฉพาะหมวดหมู่สินค้า
                                            </div>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="form-group">
                                                <div class="form-check-radio display-inline-block">
                                                    <label class="form-check-label">
                                                      <input class="form-check-input" onclick="participatingCategorie(this)" type="radio" name="participating_categorie_type" id="participating_categorie_type1" value="1" @if(!empty($data->participating_categorie_type)) @if($data->participating_categorie_type == 1) checked @endif @else @if(!empty(old('participating_categorie_type'))) @if(old('participating_categorie_type') == 1) checked @endif @else checked @endif @endif> หมวดหมู่หลัก
                                                      <span class="form-check-sign"></span>
                                                    </label>
                                                </div>
                                                <div class="form-check-radio display-inline-block">
                                                    <label class="form-check-label">
                                                      <input class="form-check-input" onclick="participatingCategorie(this)" type="radio" name="participating_categorie_type" id="participating_categorie_type2" value="2" @if(!empty($data->participating_categorie_type)) @if($data->participating_categorie_type == 2) checked @endif @else @if(!empty(old('participating_categorie_type'))) @if(old('participating_categorie_type') == 2) checked @endif @endif @endif> หมวดหมู่ย่อย
                                                      <span class="form-check-sign"></span>
                                                    </label>
                                                </div>
                                                <input type="hidden" name="hidden_participating_categorie_type" id="hidden_participating_categorie_type" value="@if(!empty($data->participating_categorie_type)){{ $data->participating_categorie_type }}@else{{ '1' }}@endif">

                                                <select name="participating_categorie[]" id="participating_categorie" type="text" class="form-control select-multiple" multiple="multiple">
                                                </select>
                                                <input type="hidden" name="hidden_participating_categorie" id="hidden_participating_categorie" value="@if(!empty($data->participating_categorie)){{ $data->participating_categorie }}@endif">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2 text-right">
                                            <div class="form-group">
                                                หมวดหมู่ที่ไม่ร่วมรายการ
                                            </div>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="form-group">
                                                <div class="form-check-radio display-inline-block">
                                                    <label class="form-check-label">
                                                      <input class="form-check-input" onclick="participatingCategorieNone(this)" type="radio" name="non_participating_categorie_type" id="non_participating_categorie1" value="1" @if(!empty($data->non_participating_categorie_type)) @if($data->non_participating_categorie_type == 1) checked @endif @else @if(!empty(old('non_participating_categorie_type'))) @if(old('non_participating_categorie_type') == 1) checked @endif @else checked @endif  @endif> หมวดหมู่หลัก
                                                      <span class="form-check-sign"></span>
                                                    </label>
                                                </div>
                                                <div class="form-check-radio display-inline-block">
                                                    <label class="form-check-label">
                                                      <input class="form-check-input" onclick="participatingCategorieNone(this)" type="radio" name="non_participating_categorie_type" id="non_participating_categorie2" value="2" @if(!empty($data->non_participating_categorie_type)) @if($data->non_participating_categorie_type == 2) checked @endif @else @if(!empty(old('non_participating_categorie_type'))) @if(old('non_participating_categorie_type') == 2) checked @endif @endif @endif> หมวดหมู่ย่อย
                                                      <span class="form-check-sign"></span>
                                                    </label>
                                                </div>
                                                <input type="hidden" name="hidden_non_participating_categorie_type" id="hidden_non_participating_categorie_type" value="@if(!empty($data->non_participating_categorie_type)){{ $data->non_participating_categorie_type }}@else{{ '1' }}@endif">

                                                <select name="non_participating_categorie[]" id="non_participating_categorie" type="text" class="form-control select-multiple" multiple="multiple">
                                                </select>
                                                <input type="hidden" name="hidden_non_participating_categorie" id="hidden_non_participating_categorie" value="@if(!empty($data->non_participating_categorie)){{ $data->non_participating_categorie }}@endif">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="limit" role="tabpanel" aria-expanded="false">
                                    <div class="row">
                                        <div class="col-md-2 text-right">
                                            <div class="form-group">
                                                ลิมิตต่อคูปอง
                                            </div>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="form-group">
                                                <input name="coupon_limit" id="coupon_limit" type="text" class="form-control number" @if(!empty($data->coupon_limit)) value="{{ $data->coupon_limit }}" @else @if(!empty(old('coupon_limit'))) value="{{ old('coupon_limit') }}" @endif @endif>
                                                @error('coupon_limit')<small class="error-danger-text">{{ $message }}</small> @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2 text-right">
                                            <div class="form-group">
                                                ลิมิตต่อคน
                                            </div>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="form-group">
                                                <input name="coupon_limit_people" id="coupon_limit_people" type="text" class="form-control number" @if(!empty($data->coupon_limit_people)) value="{{ $data->coupon_limit_people }}" @else @if(!empty(old('coupon_limit_people'))) value="{{ old('coupon_limit_people') }}" @endif @endif>
                                                @error('coupon_limit_people')<small class="error-danger-text">{{ $message }}</small> @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                                    @if($data->show == 1)
                                        checked
                                    @endif
                                @else
                                    checked
                                @endif
                                 />
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group text-align-center">
                                @isset($data->coupon_img)
                                    <input type="hidden" class="form-control" id="coupon_img_old" name="coupon_img_old" value="{{ $data->coupon_img }}">
                                    <img id="blah1" src="{{ asset('storage/coupon/'.$data->coupon_img) }}" alt="" class="full-width-coupon border_img" rel="nofollow">
                                @else
                                    <img id="blah1" src="{{ asset('images/default-img/default-banner-900-1050.jpg')}}" alt="..." class="full-width-coupon border_img" rel="nofollow">
                                @endisset
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-6">
                                    <a href="{{ route('promotion.coupon.index')}}">
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

@endsection


@section('js')
    <!-- select2 -->
    <script src="{{ asset('vendor/select2/select2.min.js') }}"></script>
    <!-- select2-bootstrap4-theme -->
    <script src="{{ asset('vendor/select2-bootstrap4-theme/docs/script.js') }}"></script>
@endsection
