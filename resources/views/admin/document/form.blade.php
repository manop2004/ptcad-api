@extends('layouts.temp_admin')
@section('title'){{$title_page}}@endsection
@section('css')
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
            <h4 class="card-title">{{ $title_page }}</h4>
        </div>
        <div class="card-body">

            @if(empty($data))
                {{ Form::open(['route' => 'document.crate', 'files' => true]) }}
            @else
                {{ Form::model($data, ['route' => ['document.update',$data->id], 'method' => 'put', 'files' => true]) }}
            @endif

                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label>ชื่อหัวข้อ <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('document_title') is-invalid @enderror" name="document_title" value="@if(!empty($data->document_title)){{ $data->document_title }}@else{{ old('document_title') }}@endif">
                            @error('document_title')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>ลำดับการแสดงผล</label>
                            <input type="number" class="form-control" name="document_order" value="@if(!empty($data->document_order)){{ $data->document_order }}@else{{ 0 }}@endif">
                            <small class="text-muted">เลขน้อยแสดงก่อน</small>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="form-group">
                            <label>ไฟล์ PDF @if(empty($data))<span class="text-danger">*</span>@endif</label>
                            <br/>
                            <label class="btn btn-outline-primary" style="position:relative; overflow:hidden; display:inline-flex; align-items:center; gap:8px; cursor:pointer; padding:10px 18px; border:2px dashed #007bff; border-radius:6px; background:#f0f8ff;">
                                <i class="fa fa-upload"></i> คลิกเพื่อเลือกไฟล์ PDF
                                <input type="file" name="document_file" accept="application/pdf" onchange="document.getElementById('documentFileName').innerText = this.files[0] ? this.files[0].name : 'ยังไม่ได้เลือกไฟล์';" style="position:absolute; left:0; top:0; width:100%; height:100%; opacity:0; cursor:pointer;">
                            </label>
                            <div id="documentFileName" style="margin-top:8px; color:#666; font-size:13px;">ยังไม่ได้เลือกไฟล์</div>
                            @error('document_file')<small class="text-danger">{{ $message }}</small>@enderror
                            @if(!empty($data->document_file))
                                <br/>
                                <a href="{{ asset('storage/document_files/'.$data->document_file) }}" target="_blank">
                                    <i class="fa fa-file-pdf-o"></i> ดูไฟล์ปัจจุบัน
                                </a>
                                <br/>
                                <small class="text-muted">อัปโหลดไฟล์ใหม่เพื่อแทนที่ไฟล์เดิม</small>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="checkbox-inline">
                                <input type="checkbox" name="document_show" @if(empty($data) || $data->document_show == 1) checked @endif> เปิดใช้งาน (แสดงในหน้าเว็บ)
                            </label>
                        </div>
                    </div>
                </div>

                <div class="line"></div>
                <button type="submit" class="btn btn-primary">บันทึกข้อมูล</button>
                <a href="{{ route('document.index') }}" class="btn btn-secondary">ยกเลิก</a>

            {{ Form::close() }}

        </div>
      </div>
    </div>
</div>

@endsection

@section('js')
@endsection