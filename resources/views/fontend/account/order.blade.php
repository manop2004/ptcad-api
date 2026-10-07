@extends('layouts.temp_user')

@section('title'){{ $og_title }} |@endsection
@section('og_site_name'){{ $og_site_name }}@endsection
@section('og_keywords'){{ $og_keywords }}@endsection
@section('og_title'){{ $og_title }}@endsection
@section('og_description'){{ $og_description }}@endsection
@section('og_url'){{ $og_url }}@endsection
@section('og_image'){{ $og_image }}@endsection

@section('css')
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Noto+Sans+Thai:wght@400;500;600;700;800&display=swap');

.acct-wrap{
  --navy:#12358f; --blue:#1765ff; --ink:#0b1f4d; --muted:#667085; --line:#e6edf8;
  --soft:#f6f9ff; --green:#20b26b; --orange:#b45309; --red:#ef4444; --shadow:0 18px 50px rgba(20,53,143,.10);
  font-family:'Poppins','Noto Sans Thai',system-ui,sans-serif; color:var(--ink);
  width: 100% !important;
  max-width: 1320px !important;
  margin: 0 auto 60px auto !important;
  padding: 0 16px !important;
  box-sizing: border-box !important;
  overflow-x: hidden !important;
}
.acct-wrap *{box-sizing:border-box}
.acct-wrap a{text-decoration:none;color:inherit}

.acct-hero{
  padding:48px 24px;
  background:linear-gradient(105deg,#ffffff 0%,#f4f9ff 60%,#e4f3ff 100%);
  border-radius:24px;
  margin-bottom:28px;
  text-align:center !important;
  display: flex !important;
  flex-direction: column !important;
  align-items: center !important;
  justify-content: center !important;
}
.acct-hero .eyebrow{
  display:inline-flex;
  align-items:center;
  justify-content:center;
  gap:8px;
  color:var(--blue);
  font-weight:800;
  font-size:13px;
  margin-bottom:10px;
  width: 100%;
}
.acct-hero h1{
  font-size:34px;
  margin:0 0 8px 0;
  color:var(--navy);
  letter-spacing:-1px;
  text-align:center !important;
  width: 100%;
}
.acct-hero p{
  margin:0 auto !important;
  color:var(--muted);
  font-size:15px;
  max-width:640px;
  line-height:1.6;
  text-align:center !important;
  width: 100%;
}

.acct-portal{display:grid;grid-template-columns:270px 1fr;gap:26px}
.acct-side{position:sticky;top:100px;align-self:start;border:1px solid var(--line);border-radius:22px;background:#fff;box-shadow:0 12px 34px rgba(20,53,143,.055);padding:14px}
.acct-side a{height:46px;border-radius:14px;display:flex;align-items:center;gap:12px;padding:0 14px;color:#344054;font-weight:700;font-size:14px}
.acct-side a img{width:18px;height:18px;object-fit:contain}
.acct-side a:hover,.acct-side a.active{background:#eef6ff;color:var(--blue)}
.acct-side a.signout{color:var(--red)}

.acct-main{display:grid;gap:24px}
.acct-card{background:#fff;border:1px solid var(--line);border-radius:24px;padding:26px;box-shadow:0 12px 34px rgba(20,53,143,.055)}
.acct-section-head{display:flex;align-items:flex-end;justify-content:space-between;gap:20px;margin-bottom:18px;flex-wrap:wrap}
.acct-kicker{font-weight:800;color:var(--blue);font-size:12px;margin-bottom:4px}
.acct-section-head h2{font-size:24px;margin:0;color:#102b76}

.acct-order{border:1px solid var(--line);border-radius:18px;padding:20px;margin-bottom:16px}
.acct-order-top{display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px;margin-bottom:12px}
.acct-order-number{font-weight:800;color:#102b76}
.acct-status{display:inline-block;border-radius:999px;padding:5px 12px;font-size:12px;font-weight:800;color:#fff}
.acct-order-item{display:flex;gap:14px;align-items:center;padding:10px 0;border-top:1px solid var(--line)}
.acct-order-item img{width:48px;height:48px;object-fit:cover;border-radius:10px;border:1px solid var(--line)}
.acct-order-item-name{flex:1;font-size:14px;color:#344054}
.acct-order-item-name small{display:block;color:var(--muted)}
.acct-order-item-price{font-weight:800;color:var(--blue);font-size:14px;white-space:nowrap}
.acct-order-foot{display:flex;justify-content:space-between;align-items:center;margin-top:14px;padding-top:14px;border-top:1px solid var(--line);flex-wrap:wrap;gap:8px}
.acct-order-foot .total{font-weight:800;color:var(--blue);font-size:16px}
.acct-empty{color:var(--muted);font-size:14px;padding:20px 0}

@media (max-width:1000px){
  .acct-portal{grid-template-columns:1fr}
  .acct-side{position:relative;top:0;display:grid;grid-template-columns:repeat(3,1fr)}
}
/* ===================================================
   [TAILWIND PAGINATION FIX] ดักจับ Tailwind Utility Classes
   =================================================== */
.acct-card nav[role="navigation"],
.acct-card nav[role="navigation"] > div,
.acct-card nav[role="navigation"] .flex,
.acct-card nav[role="navigation"] .inline-flex {
  background-color: transparent !important;
  background: transparent !important;
  box-shadow: none !important;
  border-color: transparent !important;
}

.acct-card nav[role="navigation"] {
  display: flex !important;
  justify-content: center !important;
  align-items: center !important;
  margin-top: 24px !important;
  width: 100% !important;
}

.acct-card nav[role="navigation"] > div {
  display: flex !important;
  justify-content: center !important;
  align-items: center !important;
  gap: 6px !important;
}

.acct-card nav[role="navigation"] .hidden.sm\:flex-1,
.acct-card nav[role="navigation"] p.text-sm {
  display: none !important;
}

.acct-card nav[role="navigation"] a,
.acct-card nav[role="navigation"] span[aria-current="page"],
.acct-card nav[role="navigation"] span[aria-disabled="true"] {
  display: inline-flex !important;
  align-items: center !important;
  justify-content: center !important;
  min-width: 38px !important;
  height: 38px !important;
  padding: 0 14px !important;
  border-radius: 10px !important;
  border: 1.5px solid #e6edf8 !important;
  background-color: #ffffff !important;
  background: #ffffff !important;
  color: #344054 !important;
  font-weight: 700 !important;
  font-size: 13px !important;
  text-decoration: none !important;
  transition: all 0.2s ease !important;
  box-shadow: 0 2px 4px rgba(20, 53, 143, 0.04) !important;
  margin: 0 !important;
}

.acct-card nav[role="navigation"] a:hover {
  border-color: #1765ff !important;
  color: #1765ff !important;
  background-color: #f4f9ff !important;
  background: #f4f9ff !important;
}

.acct-card nav[role="navigation"] span[aria-current="page"] > span,
.acct-card nav[role="navigation"] span[aria-current="page"] {
  background-color: #1765ff !important;
  background: #1765ff !important;
  border-color: #1765ff !important;
  color: #ffffff !important;
}

.acct-card nav[role="navigation"] span[aria-disabled="true"] > span,
.acct-card nav[role="navigation"] span[aria-disabled="true"] {
  background-color: #f8fafc !important;
  background: #f8fafc !important;
  color: #c1c9d6 !important;
  border-color: #eef1f6 !important;
  cursor: not-allowed !important;
}
@media (max-width:640px){
  .acct-side{grid-template-columns:1fr 1fr}
}
</style>
@endsection

@section('content')

<div class="acct-wrap" style="width:100%;padding:0 28px">

    @if (!empty($breadcrumb))
    <section id="page-title" class="page-title-mini page-title-right">
        <div class="clearfix">
            <ol class="breadcrumb">
                @foreach ($breadcrumb as $index => $item)
                    @if($index !== count($breadcrumb) -1 )
                        <li><a href="{{ $item['route'] }}">{{ $item['name'] }}</a></li>
                    @else
                        <li class="active">{{ $item['name'] }}</li>
                    @endif
                @endforeach
            </ol>
        </div>
    </section>
    @endif

    <section class="acct-hero">
        <div class="eyebrow"><i data-lucide="receipt" size="16"></i> MY PTCAD</div>
        <h1>{{ $page_name }}</h1>
        <p>ประวัติคำสั่งซื้อทั้งหมดของคุณ ตรวจสอบสถานะและรายละเอียดสินค้าในแต่ละออเดอร์ได้ที่นี่</p>
    </section>

    <div class="acct-portal">
        @include('layouts.fontend.account_sidebar')

        <div class="acct-main">
            <section class="acct-card" id="orders">
                <div class="acct-section-head">
                    <div>
                        <div class="acct-kicker">ORDERS & INVOICES</div>
                        <h2>คำสั่งซื้อของฉัน</h2>
                    </div>
                </div>

                @if(count($data) != 0)
                    @foreach ($data as $order)
                        <div class="acct-order">
                            <div class="acct-order-top">
                                <a class="acct-order-number" href="{{ route('fronend.account.order.detail',$order->id) }}">
                                    หมายเลขคำสั่งซื้อ :: {{ $order->orderNumber }}
                                </a>
                                <span class="acct-status" style="background: {{ $order->tb_setting_payment_status->status_color }}">
                                    {{ $order->tb_setting_payment_status->status_name }}
                                </span>
                            </div>

                            @foreach ($order->tb_order_details as $detail)
                                <div class="acct-order-item">
                                    <img src="{{ $detail->product_img }}">
                                    <div class="acct-order-item-name">
                                        @if (!empty($detail->product_detail) && $detail->product_detail != 'null')
                                            {{ $detail->product_detail }}
                                        @else
                                            {{ $detail->product_name }}
                                        @endif
                                        <small>SKU: {{ $detail->product_sku }} • x{{ $detail->product_unit }}</small>
                                    </div>
                                    <div class="acct-order-item-price">
                                        @if (!empty($detail->product_price_sale))
                                            {{ number_format($detail->product_price_sale) }}
                                        @else
                                            {{ number_format($detail->product_price,2) }}
                                        @endif
                                    </div>
                                </div>
                            @endforeach

                            <div class="acct-order-foot">
                                <span style="color:var(--muted);font-size:13px">วันที่สั่งซื้อ: {{ date("d-m-Y H:i:s",strtotime($order->created_at)) }}</span>

                                <div style="display:flex;align-items:center;gap:16px">
                                    <span class="total">ยอดรวม: {{ number_format($order->totalCart,2) }} บาท</span>

    <a href="{{ route('fronend.account.order.detail',$order->id) }}" style="color:var(--muted);font-weight:700;font-size:13px">
    ดูรายละเอียด
</a>
@if(in_array($order->payment_status, [2, 7]))
    <a href="{{ route('fronend.account.order.invoice',$order->id) }}" style="color:var(--blue);font-weight:700;font-size:13px">
        ดาวน์โหลดใบเสร็จ
    </a>
@endif
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div style="margin-top:18px">{!! $data->links() !!}</div>
                @else
                    <p class="acct-empty">ยังไม่มีคำสั่งซื้อ</p>
                @endif
            </section>
        </div>
    </div>

</div>

@endsection

@section('js')

@endsection