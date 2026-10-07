@extends('layouts.temp_user')

@section('title'){{ $og_title }} |@endsection
@section('og_site_name'){{ $og_site_name }}@endsection
@section('og_keywords'){{ $og_keywords }}@endsection
@section('og_title'){{ $og_title }}@endsection
@section('og_description'){{ $og_description }}@endsection
@section('og_url'){{ $og_url }}@endsection
@section('og_image'){{ $og_image }}@endsection

@section('css')
@php
    $countB = App\Models\TbBanner::select('banner_show')->where('banner_show',1)->count();
@endphp
@if($countB == 1)
<style>
    .flex-direction-nav{
        display: none !important;
    }
</style>
@endif

<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Noto+Sans+Thai:wght@400;500;600;700;800&display=swap');

.acct-wrap{
  --navy:#12358f; --blue:#1765ff; --ink:#0b1f4d; --muted:#667085; --line:#e6edf8;
  --soft:#f6f9ff; --red:#ef4444; --shadow:0 18px 50px rgba(20,53,143,.10);
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

/* จัดส่วนหัวให้อยู่ตรงกลาง */
.acct-hero{
  padding:48px 24px;
  background:linear-gradient(105deg,#ffffff 0%,#f4f9ff 60%,#e4f3ff 100%);
  border-radius:24px;
  margin-bottom:28px;
  text-align: center !important;
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
  margin:0 0 8px;
  color:var(--navy);
  letter-spacing:-1px;
  text-align: center !important;
  width: 100%;
}
.acct-hero p{
  margin:0 auto !important;
  color:var(--muted);
  font-size:15px;
  max-width:640px;
  line-height:1.6;
  text-align: center !important;
  width: 100%;
}

/* จัด Breadcrumb ให้อยู่ตรงกลาง */
#page-title.page-title-center-custom {
  text-align: center !important;
  margin-bottom: 15px;
}
#page-title.page-title-center-custom .breadcrumb {
  display: inline-flex !important;
  justify-content: center !important;
  float: none !important;
  margin: 0 auto !important;
  padding: 0 !important;
  background: transparent !important;
}

.acct-portal{display:grid;grid-template-columns:270px 1fr;gap:26px}
.acct-side{position:sticky;top:100px;align-self:start;border:1px solid var(--line);border-radius:22px;background:#fff;box-shadow:0 12px 34px rgba(20,53,143,.055);padding:14px}
.acct-side a{height:46px;border-radius:14px;display:flex;align-items:center;gap:12px;padding:0 14px;color:#344054;font-weight:700;font-size:14px}
.acct-side a img{width:18px;height:18px;object-fit:contain}
.acct-side a:hover,.acct-side a.active{background:#eef6ff;color:var(--blue)}
.acct-side a.signout{color:var(--red)}

.acct-main{display:grid;gap:24px;width:100%}
.acct-card{background:#fff;border:1px solid var(--line);border-radius:24px;padding:26px;box-shadow:0 12px 34px rgba(20,53,143,.055)}
.acct-card h3{font-size:18px;color:#102b76;margin:0 0 4px}
.acct-card hr{border-color:var(--line);margin:14px 0 20px}
.acct-add-coupon{background:var(--soft);border-radius:16px;padding:18px;display:flex;gap:10px;align-items:flex-start;flex-wrap:wrap}
.acct-add-coupon input{flex:1;min-width:200px;border:1px solid var(--line);border-radius:10px;height:42px;padding:0 14px;font-size:14px}
.acct-add-coupon button{height:42px;padding:0 20px;border-radius:10px;border:none;background:var(--blue);color:#fff;font-weight:800}
.invalid-feedback{color:var(--red);display:block;margin-top:6px;font-size:13px}

.acct-coupon-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:16px;margin-top:20px}
.acct-coupon-card{position:relative;border:1px solid var(--line);border-radius:18px;overflow:hidden;background:#fff}
.acct-coupon-card .b_img{width:100%;display:block}
.acct-coupon-card .b_dis{padding:16px}
.acct-coupon-card h5{margin:0 0 8px;color:#102b76;font-size:16px}
.acct-coupon-card .b_coupon_a{
  display:block;
  text-align:center;
  background:var(--blue);
  color:#fff;
  font-weight:800;
  font-size:16px;
  padding:14px 18px;
  border-radius:12px;
  margin:12px 0;
  transition:.2s ease;
}
.acct-coupon-card .b_coupon_a:hover{
  background:#0d57df;
  transform:translateY(-1px);
}
.acct-coupon-card .b_dis_sub small{color:var(--muted);font-size:12px}
.acct-coupon-card .condition{display:inline-block;margin-top:10px;color:var(--blue) !important;font-size:13px;font-weight:700}
.acct-coupon-card .limit{position:absolute;top:10px;right:10px;background:#fff3e0;color:#b45309;font-size:11px;font-weight:800;padding:4px 10px;border-radius:999px}

@media (max-width:1000px){
  .acct-portal{grid-template-columns:1fr}
  .acct-side{position:relative;top:0;display:grid;grid-template-columns:repeat(3,1fr)}
}
@media (max-width:640px){
  .acct-side{grid-template-columns:1fr 1fr}
}
</style>
@endsection

@section('content')

<div class="acct-wrap" style="width:100%;padding:0 28px">

    @if (!empty($breadcrumb))
    <section id="page-title" class="page-title-mini page-title-center-custom">
        <div class="clearfix">
            <ol class="breadcrumb">
                @foreach ($breadcrumb as $index => $item)
                    @if($index !== count($breadcrumb) - 1)
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
        <div class="eyebrow"><i data-lucide="ticket" size="16"></i> MY PTCAD</div>
        <h1>โค้ดส่วนลดของฉัน</h1>
        <p>เก็บโค้ดส่วนลดไว้ใช้ตอนเช็คเอาต์ หรือกด "ใช้" บนคูปองที่เก็บไว้แล้วเพื่อนำไปใช้ทันที</p>
    </section>

    <div class="acct-portal">
        @include('layouts.fontend.account_sidebar')

        <div class="acct-main">
            <section class="acct-card">
                {{
                    Form::model($user, [
                        'novalidate',
                        'route' => ['fronend.account.coupon.crate',$user->id],
                        'class' => ($errors->any()) ? 'was-validated form-horizontal' : 'needs-validation form-horizontal',
                        'id'=>'user-form',
                        'method' => 'post',
                        'files' => true
                    ])
                }}
                    <div class="col_margin_5">
                        <h3>โค้ดส่วนลดของฉัน</h3>
                        <hr/>
                    </div>
                    <div class="acct-add-coupon">
                        <input id="coupon_code" name="coupon_code" type="text" placeholder="ใส่โค้ดส่วนลด" maxlength="255" value="">
                        <button type="submit">เก็บโค้ดส่วนลด</button>
                        @error('coupon_code')<small class="invalid-feedback">{{ $message }}</small> @enderror
                        @if(!empty(session('invalid')))
                            @if(session('invalid') == 1)
                                <small class="invalid-feedback">คุณมีคูปองนี้ในระบบแล้ว.</small>
                            @elseif (session('invalid') == 2)
                                <small class="invalid-feedback">คูปองนี้หมดอายุแล้ว ไม่สามารถใช้งานได้.</small>
                            @elseif (session('invalid') == 3)
                                <small class="invalid-feedback">คูปองนี้ไม่สามารถใช้งานได้ เนื่องจากมีผู้ใช้ครบจำนวนที่กำหนดไว้แล้ว.</small>
                            @elseif (session('invalid') == 4)
                                <small class="invalid-feedback">ไม่สามารถใช้คูปองได้ เนื่องจากมีการใช้ครบตามจำนวนที่กำหนดแล้ว.</small>
                            @elseif (session('invalid') == 5)
                                <small class="invalid-feedback">ไม่สามารถใช้คูปองได้ เนื่องจากราคาสินค้าน้อยกว่าที่กำหนด.</small>
                            @elseif (session('invalid') == 6)
                                <small class="invalid-feedback">ไม่สามารถใช้คูปองได้ เนื่องจากราคาสินค้ามากกว่าที่กำหนด.</small>
                            @elseif (session('invalid') == 7)
                                <small class="invalid-feedback">ไม่สามารถใช้คูปองได้ เนื่องจากสินค้าไม่ได้เข้าร่วมกับส่วนลดนี้.</small>
                            @elseif (session('invalid') == 8)
                                <small class="invalid-feedback">ไม่สามารถใช้คูปองได้ เนื่องจากสินค้าในหมวดหมู่ไม่ได้เข้าร่วมกับส่วนลดนี้.</small>
                            @elseif (session('invalid') == 9)
                                <small class="invalid-feedback">ไม่สามารถใช้คูปองได้ เนื่องจากยังไม่มีสินค้าในตะกร้าสินค้า.</small>
                            @endif
                        @endif
                    </div>

                    @if(!empty($coupons))
                        <div class="acct-coupon-grid">
                            @foreach ($coupons as $coupon)
                                @if(!empty($coupon['coupon_code']))
                                    <div class="acct-coupon-card">
                                        @if(!empty($coupon['coupon_limit']))
                                            <div class="limit">จำกัด</div>
                                        @endif
                                        <a href="{{ route('fronend.cart.add.condition',$coupon['coupon_code']) }}">
                                            @isset($coupon['coupon_img'])
                                                <img src="{{ asset('storage/coupon/'.$coupon['coupon_img']) }}" alt="{{ $coupon['coupon_img'] }}" class="b_img" rel="nofollow">
                                            @else
                                                <img src="{{ asset('images/default-img/default-banner-900-1050.jpg')}}" alt="..." class="b_img" rel="nofollow">
                                            @endisset
                                        </a>
                                        <div class="b_dis">
                                            <h5>{{ $coupon['coupon_name'] }}</h5>
                                            <a class="b_coupon_a" href="{{ route('fronend.cart.add.condition',$coupon['coupon_code']) }}">ใช้</a>
                                            <div class="b_dis_sub">
                                                @if(!empty($coupon['min_order_amount']))
                                                    <small>ขั้นต่ำ {{ number_format($coupon['min_order_amount']) }} บาท (ไม่รวม VAT)</small>
                                                @endif
                                                @if (!empty($coupon['coupon_date_exp']))
                                                    <br/>
                                                    <small class="co-F78300">ใช้ได้ก่อน : {{ $coupon['coupon_date_exp'] }}</small>
                                                @endif
                                            </div>
                                            <a href="{{ route('fronend.cart.coupon.codition',['id'=>$coupon['id'],'page'=>'account']) }}" class="condition">เงื่อนไข</a>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </form>
            </section>
        </div>
    </div>

</div>

@endsection