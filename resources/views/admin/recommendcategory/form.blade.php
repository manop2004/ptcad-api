@extends('layouts.temp_admin')
@section('title'){{$title_page}}@endsection

@section('css')
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
                    'route' => 'recommend.category.crate',
                    'id'=>'data-form',
                    'method' => 'post',
                    'files' => true
                ])
            }}
        @else
            {{
                Form::model($data, [
                    'novalidate',
                    'route' => ['recommend.category.update',[$data->id]],
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
                                    <div class="form-group has-label">
                                        <label>Link url</label>
                                        <input class="form-control no-max-height" id="recommend_link" name="recommend_link" value="@if(!empty($data->recommend_link)){{ $data->recommend_link }}@else{{ old('recommend_link') }}@endif" />
                                    </div>
                                    <div class="form-group has-label">
                                        <label>คำอธิบายภาพ</label>
                                        <textarea class="form-control no-max-height" id="recommend_note" name="recommend_note">@if(!empty($data->recommend_note)){{ $data->recommend_note }}@else{{ old('recommend_note') }}@endif</textarea>
                                    </div>
                                    <div class="has-label">
                                        <br/>
                                        <input type="file" accept="image/*" class="form-control" id="recommend_thumb" name="recommend_thumb" onchange="readURL1(this);">
                                        @error('recommend_thumb')<small class="error-danger-text">{{ $message }}</small><br/>@enderror
                                        <p></p><small>ขนาดไฟล์ภาพหน้าปก คือ 550 X 294 PX</small><br/>
                                        <small class="error-danger-text">* หากไฟล์ภาพมีขนาดไม่เท่ากับที่กำหนด ไฟล์จะบีบอัดอัตโนมัติเพื่อให้ได้ขนาดที่ต้องการ (อาจทำให้ภาพยืดหรือหดได้)</small><br/>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    @if(!empty($data->recommend_thumb))
                                    <a href="#" class="remove-logo" data-toggle="modal" data-target="#deleteImg" onclick="deleteModal(this)" href="#" data-id="{{ $data->id }}" data-name="{{ $data->recommend_thumb }}">
                                        <button class="btn btn-icon btn-round btn-google" type="button">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </a>
                                    @endisset
                                    <div class="text-align-center">
                                        @isset($data->recommend_thumb)
                                            <input type="hidden" class="form-control" id="recommend_thumb_old" name="recommend_thumb_old" value="{{ $data->recommend_thumb }}">
                                            <img id="blah1" src="{{ asset('storage/recommend/' . $data->recommend_thumb) }}" alt="" class="full-width" rel="nofollow">
                                        @else
                                            <img id="blah1" src="{{ asset('images/default-img/no-img.jpg')}}" alt="..." class="full-width" rel="nofollow">
                                        @endisset
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
                                    @if($data->show == 1) checked @endif
                                @else checked @endif
                                />
                            </div>
                            <hr/>
                            <div class="jumbotron">
                                ลำดับการแสดงผล
                            </div>
                            <div class="form-group">
                                <input class="form-control no-max-height" id="recommend_sort" name="recommend_sort" placeholder="0" value="@if(!empty($data->recommend_sort)){{ $data->recommend_sort }}@else @if(!empty(old('recommend_sort'))) {{ old('recommend_sort') }} @else @if(!empty($sort)){{ $sort->recommend_sort+1 }}@else{{ "1" }}@endif @endif @endif" />
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
                                    <a href="{{ route('recommend.category.index')}}">
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


@include('admin.recommendcategory.modal.deleteImg')

@endsection

@section('js')

<!-- jscolor-2.4.6 -->
<script src="{{ asset('vendor/jscolor-2.4.6/jscolor.min.js') }}"></script>

@endsection
