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
                    'route' => 'category.crate',
                    'id'=>'data-form',
                    'method' => 'post',
                    'files' => true
                ])
            }}
        @else
            {{
                Form::model($data, [
                    'novalidate',
                    'route' => ['category.update',[$data->id]],
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
                                        <label>ชื่อหมวดหมู่สินค้า<span class="text-danger">*</span></label>
                                        <input class="form-control no-max-height" id="category_name" name="category_name" value="@if(!empty($data->category_name)){{ $data->category_name }}@else{{ old('category_name') }}@endif" />
                                        @error('category_name')<small class="error-danger-text">{{ $message }}</small><br/>@enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group has-label">
                                        <label>Permalink<span class="text-danger">*</span></label>
                                        <input class="form-control no-max-height" id="category_permalink" name="category_permalink" value="@if(!empty($data->category_permalink)){{ $data->category_permalink }}@else{{ old('category_permalink') }}@endif" />
                                        @error('category_permalink')<small class="error-danger-text">{{ $message }}</small><br/>@enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group has-label">
                                        <label>ประเภทหมวดหมู่<span class="text-danger">*</span></label>
                                        <select id="category_type" name="category_type" class="form-control"  >
                                            <option value="">กรุณาเลือกข้อมูล</option>
                                            @foreach ($types as $type )
                                                <option value="{{$type->id}}" @if(!empty($data->category_type)) @if($data->category_type == $type->id) selected @endif  @endif>{{$type->type_name}}</option> 
                                            @endforeach
                                        </select>
                                        @error('category_type')<small class="error-danger-text">{{ $message }}</small><br/>@enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group has-label">
                                        <label>คำอธิบายหมวดหมู่</label>
                                        <textarea rows="5" class="form-control no-max-height" id="category_note" name="category_note">@if(!empty($data->category_note)){{ $data->category_note }}@else{{ old('category_note') }}@endif</textarea>
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
                                <input name="category_show" id="category_show" class="bootstrap-switch" type="checkbox" data-toggle="switch" data-on-label="<i class='nc-icon nc-check-2'></i>" data-off-label="<i class='nc-icon nc-simple-remove'></i>" data-on-color="success" data-off-color="success"
                                @if(!empty($data->category_show))
                                    @if($data->category_show == 1) checked @endif
                                @else checked @endif
                                />
                            </div>
                            <hr/>
                            <div class="jumbotron">
                                ลำดับการแสดงผล
                            </div>
                            <div class="form-group">
                                <input name="category_sort" id="category_sort" class="form-control no-max-height" type="text" value="@if(!empty($data->category_sort)){{ $data->category_sort }}@else @if(!empty(old('category_sort'))) {{ old('category_sort') }} @else @if(!empty($sort)) {{ $sort->category_sort+1 }} @else 1 @endif  @endif @endif" />
                            </div>
                            <hr/>
                            <div class="jumbotron">
                                การแสดงผลสำหรับตัวเลือกสินค้าหลายรูปแบบ
                            </div>
                            <div class="form-group">
                                <div class="form-check-radio display-inline-block nobottommargin">
                                    <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="category_option" id="category_option1" value="1" @if(!empty($data->category_option)) @if($data->category_option == 1) checked @endif @else @if(!empty(old('category_option'))) @if(old('category_option') == 1 ) checked @endif @else checked @endif @endif> Select
                                    <span class="form-check-sign"></span>
                                    </label>
                                </div>
                                <div class="form-check-radio display-inline-block nobottommargin">
                                    <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="category_option" id="category_option2" value="2" @if(!empty($data->category_option)) @if($data->category_option == 2) checked @endif @else @if(!empty(old('category_option'))) @if(old('category_option') == 2 ) checked @endif @endif @endif> Option
                                    <span class="form-check-sign"></span>
                                    </label>
                                </div>
                            </div><hr/>
                            <div class="jumbotron">
                                แสดงสถานะสินค้าในหน้าแสดงข้อมูลสินค้า
                            </div>
                            <div class="form-group">
                                <div class="form-check-radio display-inline-block nobottommargin">
                                    <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="category_display_status" id="category_display_status1" value="1"  @if(!empty($data->category_display_status)) @if($data->category_display_status == 1) checked @endif @else checked @endif> แสดง
                                    <span class="form-check-sign"></span>
                                    </label>
                                </div>
                                <div class="form-check-radio display-inline-block nobottommargin">
                                    <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="category_display_status" id="category_display_status2" value="2" @if(!empty($data->category_display_status)) @if($data->category_display_status == 2) checked @endif @endif> ไม่แสดง
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
                                    <a href="{{ route('category.index')}}">
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
