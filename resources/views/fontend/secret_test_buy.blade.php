@extends('layouts.embed_bare')

@section('title', 'หน้าทดสอบซื้อสินค้า')

@section('content')
<div style="max-width:420px;margin:60px auto;padding:0 20px;font-family:'Poppins','Noto Sans Thai',system-ui,sans-serif;">
    <div style="border:1.5px solid #e6edf8;border-radius:16px;padding:24px;text-align:center;">
        <p style="font-size:12px;color:#9ba7ba;margin:0 0 8px;">🔒 หน้าทดสอบภายใน ไม่เปิดให้ลูกค้าเข้าถึง</p>
        <h2 style="font-size:18px;color:#12358f;margin:0 0 4px;">{{ $product->pro_name }}</h2>
        <p style="font-size:28px;font-weight:800;color:#1765ff;margin:8px 0 20px;">฿{{ number_format($price, 2) }}</p>

        <form method="POST" action="{{ route('internal.testbuy.store') }}">
            @csrf
            <button type="submit" style="width:100%;height:46px;border:none;border-radius:10px;background:linear-gradient(135deg,#1765ff,#0d57df);color:#fff;font-weight:800;font-size:14px;cursor:pointer;">
                ซื้อทดสอบ
            </button>
        </form>
    </div>
</div>
@endsection