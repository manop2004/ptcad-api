@extends('layouts.temp_admin')
@section('title'){{$title_page}}@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">จัดการสิทธิ์เริ่มต้นตาม Role</h4>
                <p class="text-muted mb-0">เลือก Role ที่ต้องการตั้งค่า — สิทธิ์นี้จะเป็นค่าเริ่มต้นให้เลือก "โหลดจาก Role" ในหน้าตั้งค่าสิทธิ์รายบุคคลได้</p>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th style="width: 60px">#</th>
                            <th>Role</th>
                            <th style="width: 150px" class="text-right">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($levels as $index => $level)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $level->name }}</td>
                            <td class="text-right">
                                <a href="{{ route('levelmenu.edit', $level->id) }}" class="btn btn-info btn-sm">
                                    <i class="nc-icon nc-settings-gear-65"></i> ตั้งค่าสิทธิ์
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection