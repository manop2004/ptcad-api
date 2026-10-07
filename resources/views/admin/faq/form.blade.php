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
                {{ Form::open(['route' => 'faq.crate', 'files' => true]) }}
            @else
                {{ Form::model($data, ['route' => ['faq.update',$data->id], 'method' => 'put', 'files' => true]) }}
            @endif

                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label>ชื่อหัวข้อ <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('faq_title') is-invalid @enderror" name="faq_title" value="@if(!empty($data->faq_title)){{ $data->faq_title }}@else{{ old('faq_title') }}@endif">
                            @error('faq_title')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>ลำดับการแสดงผล</label>
                            <input type="number" class="form-control" name="faq_order" value="@if(!empty($data->faq_order)){{ $data->faq_order }}@else{{ 0 }}@endif">
                            <small class="text-muted">เลขน้อยแสดงก่อน</small>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Permalink (ลิงก์สำหรับส่งให้ลูกค้า)</label>
                            <input type="text" class="form-control @error('faq_parmalink') is-invalid @enderror" name="faq_parmalink" value="@if(!empty($data->faq_parmalink)){{ $data->faq_parmalink }}@else{{ old('faq_parmalink') }}@endif" placeholder="ถ้าไม่กรอก ระบบจะสร้างจากชื่อหัวข้อให้อัตโนมัติ">
                            @error('faq_parmalink')<small class="text-danger">{{ $message }}</small>@enderror
                            @if(!empty($data->faq_parmalink))
                                <br/>
                                <small class="text-muted">ลิงก์: {{ route('faq.view',$data->faq_parmalink) }}</small>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="form-group">
                            <label>ไฟล์ PDF @if(empty($data))<span class="text-danger">*</span>@endif</label>
                            <br/>
                            <label class="btn btn-outline-primary" style="position:relative; overflow:hidden; display:inline-flex; align-items:center; gap:8px; cursor:pointer; padding:10px 18px; border:2px dashed #007bff; border-radius:6px; background:#f0f8ff;">
                                <i class="fa fa-upload"></i> คลิกเพื่อเลือกไฟล์ PDF
                                <input type="file" name="faq_file" accept="application/pdf" onchange="document.getElementById('faqFileName').innerText = this.files[0] ? this.files[0].name : 'ยังไม่ได้เลือกไฟล์';" style="position:absolute; left:0; top:0; width:100%; height:100%; opacity:0; cursor:pointer;">
                            </label>
                            <div id="faqFileName" style="margin-top:8px; color:#666; font-size:13px;">ยังไม่ได้เลือกไฟล์</div>
                            @error('faq_file')<small class="text-danger">{{ $message }}</small>@enderror
                            @if(!empty($data->faq_file))
                                <br/>
                                <a href="{{ asset('storage/faq_files/'.$data->faq_file) }}" target="_blank">
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
                                <input type="checkbox" name="faq_show" @if(empty($data) || $data->faq_show == 1) checked @endif> เปิดใช้งาน (แสดงในหน้าเว็บ)
                            </label>
                        </div>
                    </div>
                </div>

                <div class="line"></div>
                <button type="submit" class="btn btn-primary">บันทึกข้อมูล</button>
                <a href="{{ route('faq.index') }}" class="btn btn-secondary">ยกเลิก</a>

            {{ Form::close() }}

        </div>
      </div>
    </div>
</div>

@endsection

@section('js')
@endsection