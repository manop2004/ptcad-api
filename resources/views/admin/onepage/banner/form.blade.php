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
                    'route' => ['onepage.setting.banner.crate',['page'=>$item->id]],
                    'id'=>'data-form',
                    'method' => 'post',
                    'files' => true
                ])
            }}
        @else
            {{
                Form::model($data, [
                    'novalidate',
                    'route' => ['onepage.setting.banner.update',['page'=>$item->id,'id'=>$data->id]],
                    'id'=>'data-form',
                    'method' => 'put',
                    'files' => true
                ])
            }}
        @endif
            <input type="hidden" id="onepageId" name="onepageId" value="{{ $item->id }}" />
            <input type="hidden" id="section" name="section" value="banner" />
            <input type="hidden" id="name" name="name" value="bannerSetting"/>
            <div class="row">
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group" >
                                        <textarea id="editor" name="detail">@if(!empty($data->detail)){{ $data->detail }}@else{{ old('detail') }}@endif</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="line"></div>
                            <div class="form-group has-label">
                                @if(!empty($data->created_by))<label>เพิ่มข้อมูลโดย :: {{ $data->created_by}} :: {{ $data->created_at}} </label>@endif
                                @if(!empty($data->updated_by))<br/><label>อัพเดตข้อมูลโดย :: {{ $data->updated_by}} :: {{ $data->updated_at}} </label>@endif
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
                            @if(!empty($data->images))
                            <a href="#" class="remove-logo" data-toggle="modal" data-target="#deleteImg" onclick="deleteModal(this)" href="#" data-id="{{ $data->id }}" data-name="{{ $data->images }}">
                                <button class="btn btn-icon btn-round btn-google" type="button">
                                    <i class="fa fa-times"></i>
                                </button>
                            </a>
                            @endisset
                            <div class="text-align-center">
                                @isset($data->images)
                                    <input type="hidden" class="form-control" id="images_old" name="images_old" value="{{ $data->images }}">
                                    <img id="blah1" src="{{ asset('storage/onepages/' . $data->images) }}" alt="" class="full-width" rel="nofollow">
                                @else
                                    <img id="blah1" src="{{ asset('images/default-img/no-img.jpg')}}" alt="..." class="full-width" rel="nofollow">
                                @endisset
                            </div>
                            <br/>
                            <div class="jumbotron">
                                ภาพพื้นหลัง Cover
                            </div>
                            <input type="file" accept="image/*" class="form-control" id="images" name="images" onchange="readURL1(this);">
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-6">
                                    <a href="{{ route('onepage.setting.page',$item->id)}}">
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

@include('admin.onepage.banner.modal.deleteImage')

@endsection

@section('js')
<!-- jscolor -->
<script src="{{ asset('vendor/jscolor-2.4.6/jscolor.js') }}"></script>
<!-- ckeditor 4 -->
<script src="{{ asset('vendor/ckeditor4/ckeditor.js?v=4') }}"></script>
<script>CKEDITOR.replace( 'editor');</script>
@endsection
