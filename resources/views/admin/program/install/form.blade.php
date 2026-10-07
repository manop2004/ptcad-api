@extends('layouts.temp_admin')
@section('title'){{$title_page}}@endsection

@section('css')

<style>
    .jumbotron { padding: 1rem; margin-bottom: 1rem; }
</style>
@endsection

@section('content')

    @if(empty($data))
        {{
            Form::open([
                'novalidate',
                'route' => ['program.install.crate',[$p]],
                'id'=>'data-form',
                'method' => 'post',
                'files' => true
            ])
        }}
    @else
        {{
            Form::model($data, [
                'novalidate',
                'route' => ['program.install.update',['p'=>$p,'id'=>$data->id]],
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
                                    <label>ชื่อโปรแกรมติดตั้ง<span class="text-danger">*</span></label>
                                    <input class="form-control no-max-height" id="install_name" name="install_name" value="@if(!empty($data->install_name)){{ $data->install_name }}@else{{ old('install_name') }}@endif" />
                                    @error('install_name')<small class="error-danger-text">{{ $message }}</small><br/>@enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="has-label">
                                    <label>ไฟล์ติดตั้ง</label>
                                    <input type="file" accept="image/*" class="form-control" id="install_file" name="install_file">
                                    @if(!empty($data->install_file))
                                        <a href="{{ asset('storage/installProgram/'.$data->install_file)}}" download="">{{$data->install_file}}</a>
                                        <br/>
                                        <a href="#" data-toggle="modal" data-target="#deleteFile" onclick="deleteModal2(this)" class="text-danger" data-id="{{ $data->id }}" data-name="{{ $data->install_file }}"><i class="fa fa-times"></i> ลบไฟล์</a>
                                    @endif
                                    @error('install_file')<br/><small class="error-danger-text">{{ $message }}</small><br/>@enderror
                                    <br/>
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
                                <a href="{{ route('program.edit',['id'=>$p,'tab'=>'tab2'])}}">
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

    @include('admin.program.install.modal.deleteFile')
@endsection

@section('js')

@endsection
