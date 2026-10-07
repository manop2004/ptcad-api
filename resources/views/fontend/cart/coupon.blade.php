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
/* ==========================================
   Shopee Style Coupon UI - Custom CSS
========================================== */
.shopee-coupon-section {
  padding: 10px 0 40px;
}

/* ส่วนกล่องกรอกโค้ดส่วนลด */
.shopee-search-bar {
  background: #ffffff;
  border-radius: 12px;
  padding: 20px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
  border: 1px solid #eef2f6;
  margin-bottom: 25px;
}

.shopee-search-bar .title-head {
  font-size: 18px;
  font-weight: 700;
  color: #0b1f4d;
  margin-bottom: 12px;
}

.shopee-input-group {
  display: flex;
  gap: 10px;
  align-items: center;
}

.shopee-input-group input[type=text] {
  flex: 1;
  height: 46px;
  padding: 0 16px;
  border: 1.5px solid #e2e8f0;
  border-radius: 8px;
  font-size: 14px;
  outline: none;
  background-color: #f8fafc;
  transition: all 0.2s ease;
}

.shopee-input-group input[type=text]:focus {
  background-color: #ffffff;
  border-color: #1765ff;
  box-shadow: 0 0 0 3px rgba(23, 101, 255, 0.15);
}

.shopee-input-group .btn-apply {
  height: 46px;
  padding: 0 24px;
  background: #1765ff;
  color: #ffffff;
  font-weight: 700;
  font-size: 14px;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  white-space: nowrap;
  transition: background 0.2s ease, transform 0.1s ease;
}

.shopee-input-group .btn-apply:hover {
  background: #0d57df;
  transform: translateY(-1px);
}

.coupon-feedback {
  display: block;
  margin-top: 8px;
  font-size: 13px;
  color: #ef4444;
}

/* การจัดเลย์เอาต์การ์ดคูปอง */
.shopee-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
  gap: 18px;
}

/* การ์ดคูปองสไตล์ Shopee Ticket */
.shopee-ticket {
  display: flex;
  background: #ffffff;
  border-radius: 12px;
  box-shadow: 0 4px 14px rgba(0, 0, 0, 0.06);
  border: 1px solid #e2e8f0;
  position: relative;
  overflow: hidden;
  min-height: 120px;
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.shopee-ticket:hover {
  transform: translateY(-3px);
  box-shadow: 0 8px 22px rgba(23, 101, 255, 0.12);
}

/* รอยเว้าทรงตั๋วแบบ Shopee (ด้านซ้ายและขวาตรงกลาง) */
.shopee-ticket::before,
.shopee-ticket::after {
  content: "";
  position: absolute;
  top: 50%;
  width: 14px;
  height: 14px;
  background-color: #f8fafc; /* เปลี่ยนตาม Background หน้ารวม */
  border-radius: 50%;
  transform: translateY(-50%);
  z-index: 2;
}

.shopee-ticket::before {
  left: -7px;
  border-right: 1px solid #cbd5e1;
}

.shopee-ticket::after {
  right: -7px;
  border-left: 1px solid #cbd5e1;
}

/* ฝั่งซ้าย: รูปภาพหรือโลโก้ */
.shopee-ticket-left {
  width: 110px;
  background: #f1f5f9;
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
  border-right: 1px dashed #cbd5e1;
  padding: 8px;
  flex-shrink: 0;
}

.shopee-ticket-left img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  border-radius: 6px;
}

/* Badge จำกัดจำนวน */
.shopee-ticket .limit-tag {
  position: absolute;
  top: 6px;
  left: 6px;
  background: #ff4d4f;
  color: #ffffff;
  font-size: 10px;
  font-weight: 700;
  padding: 2px 6px;
  border-radius: 4px;
  z-index: 3;
}

/* ฝั่งขวา: รายละเอียดคูปอง */
.shopee-ticket-right {
  flex: 1;
  padding: 12px 14px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}

.shopee-ticket-title {
  font-size: 15px;
  font-weight: 700;
  color: #0f172a;
  margin: 0 0 4px 0;
  line-height: 1.3;
}

.shopee-ticket-info {
  font-size: 12px;
  color: #64748b;
  margin-bottom: 8px;
}

.shopee-ticket-exp {
  font-size: 11px;
  color: #f97316;
  font-weight: 600;
}

.shopee-ticket-footer {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-top: 6px;
}

/* ลิงก์เงื่อนไข */
.shopee-ticket-footer .btn-condition {
  font-size: 12px;
  color: #1765ff;
  font-weight: 600;
  text-decoration: none;
}

.shopee-ticket-footer .btn-condition:hover {
  text-decoration: underline;
}

/* ปุ่ม "ใช้" แบบ Shopee */
.shopee-ticket-footer .btn-use {
  background: #1765ff;
  color: #ffffff !important;
  font-weight: 700;
  font-size: 13px;
  padding: 6px 18px;
  border-radius: 20px;
  text-decoration: none !important;
  box-shadow: 0 2px 8px rgba(23, 101, 255, 0.25);
  transition: all 0.2s ease;
}

.shopee-ticket-footer .btn-use:hover {
  background: #0d57df;
  transform: scale(1.05);
}

@media (max-width: 640px) {
  .shopee-input-group {
    flex-direction: column;
    align-items: stretch;
  }
  .shopee-grid {
    grid-template-columns: 1fr;
  }
}
</style>
@endsection

@section('content')
<section id="content" class="shopee-coupon-section">
    <div class="content-wrap">
        <div class="container">
            @if (!empty($breadcrumb))
                <section id="page-title" class="page-title-mini page-title-right" style="margin-bottom: 20px;">
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

            @if(!empty($user))
                <!-- Section กล่องกรอกโค้ด -->
                <div class="shopee-search-bar">
                    <div class="title-head">โค้ดส่วนลดของฉัน</div>
                    {{
                        Form::model($user, [
                            'novalidate',
                            'route' => ['fronend.account.coupon.crate',$user->id],
                            'class' => ($errors->any()) ? 'was-validated' : 'needs-validation',
                            'id'=>'user-form',
                            'method' => 'post',
                            'files' => true
                        ])
                    }}
                        <div class="shopee-input-group">
                            <input
                                id="coupon_code"
                                name="coupon_code"
                                type="text"
                                maxlength="255"
                                placeholder="กรอกโค้ดส่วนลดที่นี่..."
                                class="@error('coupon_code') is-invalid @enderror"
                                value="{{ old('coupon_code') }}"
                            >
                            <button type="submit" class="btn-apply">เก็บโค้ดส่วนลด</button>
                        </div>

                        @error('coupon_code')
                            <small class="coupon-feedback">{{ $message }}</small>
                        @enderror

                        @if(!empty(session('invalid')))
                            @if(session('invalid') == 1)
                              <small class="coupon-feedback">คุณมีคูปองนี้ในระบบแล้ว.</small>
                            @elseif (session('invalid') == 2)
                              <small class="coupon-feedback">คูปองนี้หมดอายุแล้ว ไม่สามารถใช้งานได้.</small>
                            @elseif (session('invalid') == 3)
                              <small class="coupon-feedback">คูปองนี้ไม่สามารถใช้งานได้ เนื่องจากมีผู้ใช้ครบจำนวนที่กำหนดไว้แล้ว.</small>
                            @elseif (session('invalid') == 4)
                              <small class="coupon-feedback">ไม่สามารถใช้คูปองได้ เนื่องจากมีการใช้ครบตามจำนวนที่กำหนดแล้ว.</small>
                            @elseif (session('invalid') == 5)
                              <small class="coupon-feedback">ไม่สามารถใช้คูปองได้ เนื่องจากราคาสินค้าน้อยกว่าที่กำหนด.</small>
                            @elseif (session('invalid') == 6)
                              <small class="coupon-feedback">ไม่สามารถใช้คูปองได้ เนื่องจากราคาสินค้ามากกว่าที่กำหนด.</small>
                            @elseif (session('invalid') == 7)
                              <small class="coupon-feedback">ไม่สามารถใช้คูปองได้ เนื่องจากสินค้าไม่ได้เข้าร่วมกับส่วนลดนี้.</small>
                            @elseif (session('invalid') == 8)
                              <small class="coupon-feedback">ไม่สามารถใช้คูปองได้ เนื่องจากสินค้าในหมวดหมู่ไม่ได้เข้าร่วมกับส่วนลดนี้.</small>
                            @elseif (session('invalid') == 9)
                              <small class="coupon-feedback">ไม่สามารถใช้คูปองได้ เนื่องจากยังไม่มีสินค้าในตะกร้าสินค้า.</small>
                            @elseif (session('invalid') == 10)
                              <small class="coupon-feedback">ไม่สามารถใช้คูปองได้ เนื่องจากคูปองนี่ไม่สามารถใช้ร่วมกับสินค้าลดราคาได้</small>
                            @endif
                        @endif
                    </form>
                </div>

                <!-- Section แสดงรายการคูปองสไตล์ Shopee Grid -->
                @if(!empty($coupons))
                    <div class="shopee-grid">
                        @foreach ($coupons as $coupon)
                            @if(!empty($coupon['coupon_code']))
                                <div class="shopee-ticket">
                                    @if(!empty($coupon['coupon_limit']))
                                        <span class="limit-tag">จำกัด</span>
                                    @endif

                                    <!-- ฝั่งซ้าย: รูปคูปอง -->
                                    <div class="shopee-ticket-left">
                                        <a href="{{ route('fronend.cart.add.condition',$coupon['coupon_code']) }}" style="display:block; width:100%; height:100%;">
                                            @isset($coupon['coupon_img'])
                                                <img src="{{ asset('storage/coupon/'.$coupon['coupon_img']) }}" alt="{{ $coupon['coupon_img'] }}" rel="nofollow">
                                            @else
                                                <img src="{{ asset('images/default-img/default-banner-900-1050.jpg')}}" alt="..." rel="nofollow">
                                            @endisset
                                        </a>
                                    </div>

                                    <!-- ฝั่งขวา: ข้อความและปุ่มกด -->
                                    <div class="shopee-ticket-right">
                                        <div>
                                            <h5 class="shopee-ticket-title">{{ $coupon['coupon_name'] }}</h5>
                                            <div class="shopee-ticket-info">
                                                @if(!empty($coupon['min_order_amount']))
                                                    <div>ขั้นต่ำ {{ number_format($coupon['min_order_amount']) }} บาท (ไม่รวม VAT)</div>
                                                @endif
                                                @if (!empty($coupon['coupon_date_exp']))
                                                    <div class="shopee-ticket-exp">ใช้ได้ถึง : {{ $coupon['coupon_date_exp'] }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="shopee-ticket-footer">
                                            <a href="{{ route('fronend.cart.coupon.codition',['id'=>$coupon['id'],'page'=>'cart']) }}" class="btn-condition">เงื่อนไข</a>
                                            <a class="btn-use" href="{{ route('fronend.cart.add.condition',$coupon['coupon_code']) }}">ใช้โค้ด</a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
            @else
                <div class="topmargin-sm bottommargin-sm center">
                    <h4>ไม่พบข้อมูล</h4>
                </div>
            @endif
        </div>
    </div>
</section>
@endsection