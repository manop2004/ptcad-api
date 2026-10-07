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
                    'route' => 'recommend.product.crate',
                    'id'=>'data-form',
                    'method' => 'post',
                    'files' => true
                ])
            }}
        @else
            {{
                Form::model($data, [
                    'novalidate',
                    'route' => ['recommend.product.update',[$data->id]],
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
                                        <label>ชื่อรายการแนะนำสินค้า</label>
                                        <input class="form-control no-max-height" id="recommend_name" name="recommend_name" value="@if(!empty($data->recommend_name)){{ $data->recommend_name }}@else{{ old('recommend_name') }}@endif" />
                                        @error('recommend_name')<small class="error-danger-text">{{ $message }}</small><br/>@enderror
                                    </div>
                                    <div class="form-group">
                                        <label>เลือกสินค้าแนะนำ 4 รายการเพื่อแสดงในหมวดหมู่นี้</label>
                                        @if (!empty($data->recommend_product))
                                            @php
                                                $proRelated = explode(",",$data->recommend_product);
                                            @endphp
                                            <select id="recommend_product" name="recommend_product[]" class="form-control select-multiple" multiple="multiple" >
                                                @foreach ( $products as $product)
                                                <option value="{{ $product->id }}"@foreach ( $proRelated as $key => $related) @if($product->id == $related) selected @endif  @endforeach >{{ $product->pro_name }}</option>
                                                @endforeach
                                            </select>
                                        @else
                                            <select id="recommend_product" name="recommend_product[]" class="form-control select-multiple" multiple="multiple" >
                                                @foreach ( $products as $product)
                                                    <option value="{{ $product->id }}" >{{ $product->pro_name }}</option>
                                                @endforeach
                                            </select>
                                        @endif
                                        @error('recommend_product')<small class="error-danger-text">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label>ลำดับการแสดงผล</label>
                                    <div class="form-group">
                                        <input class="form-control no-max-height" id="sort" name="sort" placeholder="0" value="@if(!empty($data->sort)){{ $data->sort }}@else @if(!empty(old('sort'))) {{ old('sort') }} @else @if(!empty($sort)){{ $sort->sort+1 }}@else{{ "1" }}@endif @endif @endif" />
                                        <p><small class="error-danger-text">* เรียงลำดับโดยตัวเลขมากที่สุดขึ้นก่อน</small></p>
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
                                    <a href="{{ route('recommend.product.index')}}">
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
