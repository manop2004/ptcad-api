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
                    'route' => 'categorysub.crate',
                    'id'=>'data-form',
                    'method' => 'post',
                    'files' => true
                ])
            }}
        @else
            {{
                Form::model($data, [
                    'novalidate',
                    'route' => ['categorysub.update',['categoryId'=>$categoryId,'subId'=>$data->id]],
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
                                        <label>ชื่อหมวดหมู่สินค้าหลัก<span class="text-danger">*</span></label>
                                        <input class="form-control no-max-height" disabled value="@if(!empty($category->category_name)){{ $category->category_name }}@endif" />
                                        <input type="hidden" id="category_id" name="category_id" value="@if(!empty($category->id)){{ $category->id }}@endif" />
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group has-label">
                                        <label>ชื่อหมวดหมู่สินค้าย่อย<span class="text-danger">*</span></label>
                                        <input class="form-control no-max-height" id="categorysub_name" name="categorysub_name" value="@if(!empty($data->categorysub_name)){{ $data->categorysub_name }}@else{{ old('categorysub_name') }}@endif" />
                                        @error('categorysub_name')<small class="error-danger-text">{{ $message }}</small><br/>@enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group has-label">
                                        <label>Permalink<span class="text-danger">*</span></label>
                                        <input class="form-control no-max-height" id="categorysub_permalink" name="categorysub_permalink" value="@if(!empty($data->categorysub_permalink)){{ $data->categorysub_permalink }}@else{{ old('categorysub_permalink') }}@endif" />
                                        @error('categorysub_permalink')<small class="error-danger-text">{{ $message }}</small><br/>@enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group has-label">
                                        <label>คำอธิบายหมวดหมู่</label>
                                        <textarea rows="5" class="form-control no-max-height" id="categorysub_note" name="categorysub_note">@if(!empty($data->categorysub_note)){{ $data->categorysub_note }}@else{{ old('categorysub_note') }}@endif</textarea>
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
                                <input name="categorysub_show" id="categorysub_show" class="bootstrap-switch" type="checkbox" data-toggle="switch" data-on-label="<i class='nc-icon nc-check-2'></i>" data-off-label="<i class='nc-icon nc-simple-remove'></i>" data-on-color="success" data-off-color="success"
                                @if(!empty($data->categorysub_show))
                                    @if($data->categorysub_show == 1) checked @endif
                                @else checked @endif
                                />
                            </div>
                            <hr/>
                            <div class="jumbotron">
                                ลำดับการแสดงผล
                            </div>
                            <div class="form-group">
                                <input name="categorysub_sort" id="categorysub_sort" class="form-control no-max-height" type="text" value="@if(!empty($data->categorysub_sort)){{ $data->categorysub_sort }}@else @if(!empty(old('categorysub_sort'))) {{ old('categorysub_sort') }} @else @if(!empty($sort)) {{ $sort->categorysub_sort+1 }} @else 1 @endif  @endif @endif" />
                            </div>
                            <hr/>
                            <div class="jumbotron">
                                การแสดงผลสำหรับตัวเลือกสินค้าหลายรูปแบบ
                            </div>
                            <div class="form-group">
                                <div class="form-check-radio">
                                    <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="categorysub_option" id="categorysub_option1" value="1" @if(!empty($data->categorysub_option)) @if($data->categorysub_option == 1) checked @endif @else @if(!empty(old('categorysub_option'))) @if(old('categorysub_option') == 1 ) checked @endif  @else checked @endif @endif> Select
                                    <span class="form-check-sign"></span>
                                    </label>
                                </div>
                                <div class="form-check-radio">
                                    <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="categorysub_option" id="categorysub_option2" value="2" @if(!empty($data->categorysub_option)) @if($data->categorysub_option == 2) checked @endif @else @if(!empty(old('categorysub_option')))  @if(old('categorysub_option') == 2 ) checked @endif @endif @endif> Option
                                    <span class="form-check-sign"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-6">
                                    <a href="{{ route('categorysub.index',['categoryId' => $categoryId])}}">
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
