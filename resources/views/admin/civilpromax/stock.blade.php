@extends('layouts.temp_admin')
@section('title')Civil ProMax - สต็อกคีย์ทั้งหมด@endsection

@section('content')
<div class="row">
    <div class="col-md-12">

        {{-- สรุปสต็อกแยกตามระยะเวลาและสถานะ --}}
        <div class="row mb-3">
            @php
                $skuLabels = ['CIVILPROMAX-3M' => '3 เดือน', 'CIVILPROMAX-6M' => '6 เดือน', 'CIVILPROMAX-1Y' => '1 ปี'];
            @endphp
            @foreach($skuLabels as $sku => $label)
                @php
                    $available = $summary->where('detail_sku', $sku)->where('status', 1)->first()->total ?? 0;
                    $used = $summary->where('detail_sku', $sku)->where('status', 2)->first()->total ?? 0;
                @endphp
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5>{{ $label }}</h5>
                            <p class="mb-1">✅ ว่าง: <strong>{{ $available }}</strong> คีย์</p>
                            <p class="mb-0">🔒 ใช้แล้ว: <strong>{{ $used }}</strong> คีย์</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">รายการคีย์ทั้งหมด</h4>
                <a href="{{ route('admin.civilpromax.import') }}" class="btn btn-primary btn-sm">+ นำเข้าคีย์เพิ่ม</a>
            </div>
            <div class="card-body">

                {{-- ฟิลเตอร์ --}}
                <form method="GET" class="row g-2 mb-3">
                    <div class="col-auto">
                        <select name="sku" class="form-control" onchange="this.form.submit()">
                            <option value="all">ทุกระยะเวลา</option>
                            @foreach($skuLabels as $sku => $label)
                                <option value="{{ $sku }}" @selected(request('sku')==$sku)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-auto">
                        <select name="status" class="form-control" onchange="this.form.submit()">
                            <option value="all">ทุกสถานะ</option>
                            <option value="1" @selected(request('status')=='1')>ว่าง</option>
                            <option value="2" @selected(request('status')=='2')>ใช้แล้ว</option>
                        </select>
                    </div>
                    <div class="col-auto">
                        <input type="text" name="search" class="form-control" placeholder="ค้นหาคีย์..." value="{{ request('search') }}">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-outline-secondary">ค้นหา</button>
                    </div>
                </form>

                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>License Key</th>
                            <th>ระยะเวลา</th>
                            <th>สถานะ</th>
                            <th>Order</th>
                            <th>ใช้เมื่อ</th>
                            <th>เพิ่มเข้าระบบเมื่อ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($keys as $key)
                        <tr>
                            <td><code>{{ $key->license_key }}</code></td>
                            <td>{{ $skuLabels[$key->detail_sku] ?? $key->detail_sku }}</td>
                            <td>
                                @if($key->status == 1)
                                    <span class="badge badge-success">ว่าง</span>
                                @else
                                    <span class="badge badge-secondary">ใช้แล้ว</span>
                                @endif
                            </td>
                            <td>
                                @if($key->orderNumber)
                                    <a href="{{ route('order.view', $key->orderId) }}">{{ $key->orderNumber }}</a>
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $key->used_at ? \Carbon\Carbon::parse($key->used_at)->format('d/m/Y H:i') : '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($key->created_at)->format('d/m/Y H:i') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center">ไม่พบข้อมูล</td></tr>
                        @endforelse
                    </tbody>
                </table>

                {{ $keys->links() }}
            </div>
        </div>
    </div>
</div>
@endsection