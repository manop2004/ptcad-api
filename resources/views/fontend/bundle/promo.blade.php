@extends('layouts.temp_user')

@section('title')โปรโมชั่น Bundle PTCAD x Civil ProMax |@endsection
@section('og_title')โปรโมชั่น Bundle PTCAD x Civil ProMax@endsection
@section('og_description')โปรโมชั่น Civil ProMax มาพร้อมกับ License PTCAD ราคาพิเศษ@endsection

@section('css')
<style>
.pt-bundle-page{
  font-family:'Poppins','Noto Sans Thai',system-ui,sans-serif;
  max-width:1140px;
  margin:32px auto 60px;
  padding:0 24px;
  box-sizing:border-box;
}
.pt-bundle-page *{box-sizing:border-box}
.pt-bundle-page .badge-row{
  display:flex;align-items:center;justify-content:center;gap:8px;
  margin-bottom:8px;font-size:13px;color:#667085;
}
.pt-bundle-page .badge-row .official{
  background:#e6f1fb;color:#0c447c;font-size:11px;padding:2px 10px;border-radius:6px;font-weight:600;
}
.pt-bundle-page h1{
  text-align:center;font-size:26px;color:#12358f;margin:0 0 6px;font-weight:800;
}
.pt-bundle-page .sub{
  text-align:center;color:#7f8da8;font-size:14px;margin:0 0 28px;
}
.pt-bundle-page .cards{
  display:grid;grid-template-columns:repeat(3,1fr);gap:18px;
}
@media(max-width:900px){
  .pt-bundle-page .cards{grid-template-columns:1fr;}
}
.pt-bundle-page .card{
  border:1.5px solid #e6edf8;border-radius:16px;padding:22px 20px;background:#fff;
  display:flex;flex-direction:column;
  box-shadow:0 10px 25px rgba(20,53,143,.06);
}
.pt-bundle-page .tag{
  display:inline-block;font-size:11px;font-weight:700;padding:3px 10px;border-radius:6px;
  background:#e6f1fb;color:#0c447c;margin-bottom:10px;width:fit-content;
}
.pt-bundle-page .tag.sub-type{background:#eaf3de;color:#27500a;}
.pt-bundle-page .name{
  font-size:16px;font-weight:800;color:#12358f;margin:0 0 14px;line-height:1.4;min-height:44px;
}
.pt-bundle-page .price-row{
  display:flex;align-items:baseline;gap:8px;margin-bottom:16px;
}
.pt-bundle-page .old-price{
  font-size:13px;color:#9ba7ba;text-decoration:line-through;
}
.pt-bundle-page .new-price{
  font-size:24px;font-weight:800;color:#1765ff;
}
.pt-bundle-page form{margin-top:auto;}
.pt-bundle-page .buy-btn{
  width:100%;height:46px;border:none;border-radius:10px;
  background:linear-gradient(135deg,#1765ff,#0d57df);color:#fff;
  font-weight:800;font-size:14px;cursor:pointer;
  box-shadow:0 12px 24px rgba(23,101,255,.20);
}
.pt-bundle-page .buy-btn:hover{transform:translateY(-1px)}
.pt-bundle-page .vat-note{
  text-align:center;color:#9ba7ba;font-size:12px;margin-top:24px;
}
.pt-bundle-page .error-box{
  background:#fdecea;color:#a32d2d;border-radius:10px;padding:12px 16px;margin-bottom:20px;font-size:14px;text-align:center;
}
</style>
@endsection

@section('content')

<div class="pt-bundle-page">

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

  <div class="badge-row">
    <span>PTCAD Thailand</span>
    <span>×</span>
    <span>Civil ProMax</span>
    <span class="official">Official partner</span>
  </div>
  <h1>โปรโมชั่น Civil ProMax มาพร้อมกับ License PTCAD</h1>
  <p class="sub">เลือกแพ็กเกจที่เหมาะกับงานของคุณ ราคาถูกลงเมื่อซื้อคู่กัน</p>

  @if(session('bundle_error'))
    <div class="error-box">{{ session('bundle_error') }}</div>
  @endif

  <div class="cards">

    <div class="card">
      <span class="tag">Perpetual</span>
      <div class="name">PTCAD Perpetual PLUS + Civil ProMax 1Y</div>
      <div class="price-row">
        <span class="old-price">฿20,247.66</span>
        <span class="new-price">฿17,500</span>
      </div>
      <form method="POST" action="{{ route('fronend.cart.addBundle') }}">
        @csrf
        <input type="hidden" name="bundle" value="plus">
        <button type="submit" class="buy-btn">ซื้อเลย</button>
      </form>
    </div>

    <div class="card">
      <span class="tag">Perpetual</span>
      <div class="name">PTCAD Perpetual STD + Civil ProMax 1Y</div>
      <div class="price-row">
        <span class="old-price">฿17,247.66</span>
        <span class="new-price">฿14,500</span>
      </div>
      <form method="POST" action="{{ route('fronend.cart.addBundle') }}">
        @csrf
        <input type="hidden" name="bundle" value="std">
        <button type="submit" class="buy-btn">ซื้อเลย</button>
      </form>
    </div>

    <div class="card">
      <span class="tag sub-type">Subscription</span>
      <div class="name">PTCAD Lite Annual + Civil ProMax 1Y</div>
      <div class="price-row">
        <span class="old-price">฿6,397.66</span>
        <span class="new-price">฿3,650</span>
      </div>
      <form method="POST" action="{{ route('fronend.cart.addBundle') }}">
        @csrf
        <input type="hidden" name="bundle" value="lite">
        <button type="submit" class="buy-btn">ซื้อเลย</button>
      </form>
    </div>

  </div>

  <p class="vat-note">*ราคายังไม่รวม VAT 7%</p>

</div>
@endsection