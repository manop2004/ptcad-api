@extends('layouts.temp_admin')
@section('title', 'Import Civil ProMax License Key')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Import Civil ProMax License Key</h4>
            </div>
            <div class="card-body">

                @if(session('import_success'))
                    <div class="alert alert-success">{{ session('import_success') }}</div>
                @endif
                @if(session('import_error'))
                    <div class="alert alert-danger">{{ session('import_error') }}</div>
                @endif

                <div class="mb-4">
                    <strong>สต็อกคงเหลือปัจจุบัน:</strong>
                    <ul>
                        <li>3 เดือน: {{ $stockSummary['CIVILPROMAX-3M'] ?? 0 }} คีย์
                            @if(($stockSummary['CIVILPROMAX-3M'] ?? 0) < 10)<span class="text-danger">(ใกล้หมด!)</span>@endif
                        </li>
                        <li>6 เดือน: {{ $stockSummary['CIVILPROMAX-6M'] ?? 0 }} คีย์
                            @if(($stockSummary['CIVILPROMAX-6M'] ?? 0) < 10)<span class="text-danger">(ใกล้หมด!)</span>@endif
                        </li>
                        <li>1 ปี: {{ $stockSummary['CIVILPROMAX-1Y'] ?? 0 }} คีย์
                            @if(($stockSummary['CIVILPROMAX-1Y'] ?? 0) < 10)<span class="text-danger">(ใกล้หมด!)</span>@endif
                        </li>
                    </ul>
                </div>

                <form action="{{ route('admin.civilpromax.import.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <a href="{{ asset('templates/civilpromax_stock_template.csv') }}" class="btn btn-outline-primary btn-sm mb-3" download> <i class="fa fa-download"></i> ดาวน์โหลด Template ก่อนนำเข้า </a>
                        <div class="alert alert-warning py-2 px-3" style="font-size:13px;">
    <strong>หมายเหตุ:</strong> ไฟล์ต้องเป็น .csv เท่านั้น<br>
    - ถ้าได้ไฟล์ Google Sheets มา &rarr; กด <strong>ไฟล์ &gt; ดาวน์โหลด &gt; .csv</strong><br>
    - ถ้ากรอกจาก Template (Excel) &rarr; ต้องกด <strong>Save As</strong> เลือก <strong>CSV</strong> (กด Save ธรรมดาไม่ได้ ไฟล์จะยังเป็น .xlsx)
</div>
                        <input type="file" name="stock_file" accept=".csv" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">นำเข้าคีย์</button>
                </form>
                <p class="text-muted mt-3">ไฟล์ต้องเป็น .csv คอลัมน์: No. | 3 เดือน | 6 เดือน | 12 เดือน</p>

            </div>
        </div>
    </div>
</div>
@endsection