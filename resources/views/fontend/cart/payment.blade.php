@extends('layouts.temp_user')

@section('title'){{ $og_title }} |@endsection
@section('og_site_name'){{ $og_site_name }}@endsection
@section('og_keywords'){{ $og_keywords }}@endsection
@section('og_title'){{ $og_title }}@endsection
@section('og_description'){{ $og_description }}@endsection
@section('og_url'){{ $og_url }}@endsection
@section('og_image'){{ $og_image }}@endsection

@section('css')
<link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendor/select2-bootstrap4-theme/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/fontend/css/components/radio-checkbox.css') }}" type="text/css" /><!-- Date & Time Picker CSS -->
<link rel="stylesheet" href="{{ asset('vendor/datepicker/jquery-ui.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/fontend/css/components/timepicker.css') }}" type="text/css" />
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Noto+Sans+Thai:wght@400;500;600;700;800&display=swap');

.span-danger, .label-red { color: #ef4444; }
.co-red { color: #ef4444; }
.bg_eee { background-color: #f6f9ff; }

/* ==========================================================================
   PTCAD Checkout Theme (เหมือนหน้า repeat.blade.php)
   ========================================================================== */
.pt-checkout{
  --navy:#12358f; --blue:#1765ff; --ink:#0b1f4d; --muted:#667085; --line:#e6edf8;
  --soft:#f6f9ff; --green:#20b26b; --red:#ef4444;
  font-family:'Poppins','Noto Sans Thai',system-ui,sans-serif;
  color:var(--ink);
}
.pt-checkout *{box-sizing:border-box}

.pt-checkout-title{
  text-align:center;
  font-size:clamp(22px,4vw,28px);
  color:var(--navy);
  font-weight:800;
  letter-spacing:-.5px;
  margin:6px 0 28px;
}

.pt-checkout-card{
  background:#fff;
  border:1px solid var(--line);
  border-radius:20px;
  padding:26px;
  box-shadow:0 12px 34px rgba(20,53,143,.05);
  margin-bottom:20px;
}

.pt-field-label{
  display:block;
  font-weight:700;
  font-size:13.5px;
  color:#344054;
  margin-bottom:6px;
}

.pt-checkout .sm-form-control{
  border:1px solid var(--line) !important;
  border-radius:10px !important;
  margin-bottom:4px;
}
.pt-checkout small.invalid-feedback{ color:var(--red); display:block; margin-top:4px; margin-bottom:10px; }
.pt-checkout input[type="file"].sm-form-control{
  padding:8px 10px !important;
  background:#fbfdff;
}
.pt-checkout .input-group{ position:relative; }
.pt-checkout .input-group .input-group-addon{
  position:absolute;
  right:10px;
  top:50%;
  transform:translateY(-50%);
  color:var(--muted);
  padding:0 !important;
  background:none !important;
  border:none !important;
}
.pt-checkout .input-group input.sm-form-control{
  padding-right:38px;
}

/* Order summary card (ฝั่งซ้าย) */
.pt-summary-card{
  background:#fff;border:1px solid var(--line);border-radius:20px;padding:24px;
  box-shadow:0 12px 34px rgba(20,53,143,.05);margin-bottom:20px;
  position:sticky;top:100px;
}
.pt-summary-card h4{
  margin:0 0 16px;font-size:15px;font-weight:800;color:var(--navy);
  display:flex;align-items:center;gap:8px;word-break:break-word;
}
.pt-summary-card table{ width:100%; }
.pt-summary-card table td{
  border:none !important;padding:10px 0;font-size:13.5px;color:#344054;
  vertical-align:top;
}
.pt-summary-card tr:not(:last-child) td{ border-bottom:1px dashed var(--line) !important; }
.pt-summary-card tr:last-child td{
  background:var(--soft) !important;border-radius:12px;
  font-size:16px;font-weight:800;color:var(--navy);
  padding:14px 12px;
}
.pt-summary-card tr:last-child td .amount,
.pt-summary-card tr:last-child td .amount.color,
.pt-summary-card tr:last-child td .amount.lead,
.pt-summary-card tr:last-child td .color,
.pt-summary-card tr:last-child td .lead{
  color:var(--blue) !important;
  font-size:18px;
}
.pt-summary-card .co-f1c40f{ color:#f59e0b !important; }

/* Bank radio options — เหมือน pt-pay-option ของหน้า repeat */
.pt-bank-option{
  border:1px solid var(--line);border-radius:14px;padding:14px 16px;margin-bottom:10px;
  transition:border-color .2s ease;
}
.pt-bank-option:hover{ border-color:#c7d7fb; }
.pt-checkout .radio-style-2-label{
  font-weight:700;font-size:13.5px;color:#344054;
  display:flex !important;
  align-items:center;
  gap:10px;
}
.pt-checkout .radio-style-2-label img{
  border-radius:6px;
  flex-shrink:0;
}

@media (max-width:991px){
  .pt-summary-card{ position:relative; top:0; }
}

/* ===== แก้ปุ่ม "แจ้งชำระเงิน" (มาจาก component cartPayment ที่ include เข้ามา) เขียว -> น้ำเงิน ===== */
.pt-checkout .button-green,
.pt-checkout .btn-bank,
.pt-checkout button[type="submit"],
.pt-checkout .loading,
.pt-checkout .loadding,
.pt-checkout input[type="submit"]{
    background: linear-gradient(135deg,#1765ff,#0d57df) !important;
    border-color: #1765ff !important;
    color: #fff !important;
    border: none !important;
    border-radius: 12px !important;
    font-weight: 800 !important;
    box-shadow: 0 10px 20px rgba(23,101,255,.22) !important;
}
</style>
@endsection

@section('content')
<section id="content">
    <div class="content-wrap">
        <div class="container pt-checkout">
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
            <br/>
            <div class="pt-checkout-title">แจ้งชำระเงิน</div>
            @if(!empty($order))
                <div class="row">
                    <div class="col-md-4">
                        <div class="pt-summary-card">
                            <div id="b_checkout">
                                <h4><i data-lucide="receipt" size="16"></i> หมายเลขคำสั่งซื้อ :: {{ $order->orderNumber}}</h4>
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                            @foreach ($order->tb_order_details as $product)
                                                <tr>
                                                    <td>
                                                        @if ($product->product_detail!= 'null')
                                                            {{ $product->product_name }}
                                                            <br/> {{ $product->product_detail }}
                                                        @else
                                                            {{ $product->product_name }}
                                                        @endif
                                                    </td>
                                                    <td class="text-right">
                                                        @if (!empty($product->product_price_sale))
                                                            <span class="amount-sale">{{ number_format($product->product_price_sale) }}</span> {{ number_format($product->product_price,2) }}
                                                        @else
                                                            {{ number_format($product->product_price,2) }}
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                            @if(!empty($order->conditionValue))
                                                <tr class="cart_item">
                                                    <td class="cart-product-name co-f1c40f">
                                                        <strong>ส่วนลดรวม <br/><small>{{ $order->conditionName }}</small></strong>
                                                    </td>
                                                    <td class="cart-total-name co-f1c40f">
                                                        @if ($order->conditionType == 1)
                                                            <span class="amount-condition">{{ number_format($order->conditionValue,2) }}.-</span>
                                                        @else
                                                            <span class="amount-condition">{{ $order->conditionValue }}%</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endif
                                            @if(!empty($order->totaldiscount))
                                                @if(!empty($order->conditionValue) || $order->priceVAT != 0)
                                                    <tr class="cart_item">
                                                        <td class="cart-product-name ">
                                                            <strong>ราคาสุทธิสินค้า</strong>
                                                        </td>
                                                        <td class="cart-total-name ">
                                                            <span id="sumTotal_n" class="amount">{{ number_format($order->totaldiscount,2) }}.-</span>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endif
                                            @if(!empty($order->priceVAT))
                                                @if($order->priceVAT != 0)
                                                    <tr class="cart_item" id="tdcartVat">
                                                        <td class="cart-product-name">
                                                            <strong>ภาษีมูลค่าเพิ่ม</strong>
                                                        </td>
                                                        <td class="cart-total-name">
                                                            <span id="cartVat" class="amount">{{ number_format($order->priceVAT,2) }}.-</span>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endif
                                            @if(!empty($order->priceNettotal))
                                                <tr class="cart_item" id="cartNettotal">
                                                    <td class="cart-product-name">
                                                        <strong>ยอดรวมสุทธิ</strong>
                                                    </td>
                                                    <td class="cart-total-name">
                                                        <span id="cartNettotal" class="amount">{{ number_format($order->priceNettotal,2) }}.-</span>
                                                    </td>
                                                </tr>
                                            @endif
                                            @if(!empty($order->priceWithholding))
                                                <tr class="cart_item" id="tdcartVat">
                                                    <td class="cart-product-name">
                                                        <strong>หัก ภาษี ณ ที่จ่าย</strong>
                                                    </td>
                                                    <td class="cart-total-name">
                                                        <span id="cartWithholding" class="amount">{{ number_format($order->priceWithholding,2) }}.-</span>
                                                    </td>
                                                </tr>
                                            @endif
                                            <tr class="cart_item">
                                                <td class="cart-product-name">
                                                    <strong>การจัดส่ง</strong>
                                                </td>

                                                <td class="cart-total-name">
                                                    <span class="amount">จัดส่งฟรี</span>
                                                </td>
                                            </tr>
                                            <tr class="cart_item">
                                                <td class="cart-product-name bg_eee"><strong>จำนวนเงินที่ต้องชำระ</strong></td>
                                                <td class="cart-total-name bg_eee">
                                                    <span id="totalCart" class="amount color lead"><strong>{{ number_format($order->totalCart,2) }}.-</strong></span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="pt-checkout-card">
                            {{
                                Form::open([
                                    'novalidate',
                                    'route' => ['fronend.cart.payment.confirm'],
                                    'class' => ($errors->any()) ? 'was-validated form-horizontal' : 'needs-validation form-horizontal',
                                    'id'=>'user-form',
                                    'method' => 'post',
                                    'files' => true
                                ])
                            }}
                                <div class="col_full bottommargin-xs">
                                    <span class="pt-field-label">หมายเลขคำสั่งซื้อ <span class="label-red">*</span></span>
                                    <input type="text" placeholder="หมายเลขคำสั่งซื้อ" value="{{ $order->orderNumber }}" class="sm-form-control" disabled>
                                    <input type="hidden" id="order_id" name="order_id" value="{{ $order->id }}"  >
                                </div>
                                <div class="col_full bottommargin-xs">
                                    <span class="pt-field-label">หลักฐานการโอนเงิน <span class="label-red">*</span></span>
                                    <input type="file" accept="image/*" id="order_slip" name="order_slip" class="sm-form-control">
                                    @error('order_slip')<small class="invalid-feedback" role="alert">{{ $message }}</small> @enderror
                                </div>
                                <div class="col_full bottommargin-xs">
                                    <span class="pt-field-label">บัญชีธนาคาร <span class="label-red">*</span></span>
                                    @foreach ($banks as $bank )
                                        <div class="pt-bank-option">
                                            <input id="radio-{{ $bank->id }}" class="radio-style" name="order_bank" type="radio" value="{{ $bank->id }}">
                                            <label for="radio-{{ $bank->id }}" class="radio-style-2-label">
                                                <img style="width: 100%; max-width: 50px" src="{{ asset('icon/bank/'.$bank->tb_setting_bank['bank_logo']) }}" /> เลขบัญชี : {{ $bank->bank_number }}
                                            </label>
                                        </div>
                                    @endforeach
                                    @error('order_bank')<small class="invalid-feedback" role="alert">{{ $message }}</small> @enderror
                                </div>
                                <div class="col_half bottommargin-xs">
                                    <span class="pt-field-label">วันที่โอน <span class="label-red">*</span></span>
                                    <div class="input-group">
                                        <input type="text" id="order_payment_date" name="order_payment_date" value="{{ old('order_payment_date') }}" class="sm-form-control tleft datepicker" placeholder="DD-MM-YYYY">
                                        <span class="input-group-addon">
                                            <i class="icon-calendar2"></i>
                                        </span>
                                    </div>
                                    @error('order_payment_date')<small class="invalid-feedback" role="alert">{{ $message }}</small> @enderror
                                </div>
                                <div class="col_half col_last bottommargin-xs">
                                    <span class="pt-field-label">เวลาที่โอน <span class="label-red">*</span></span>
                                    <div class="input-group date">
                                        <input type="text" id="order_payment_time" name="order_payment_time" value="{{ old('order_payment_time') }}" class="tleft sm-form-control " placeholder="00:00">
                                        <span class="input-group-addon">
                                            <span class="icon-clock"></span>
                                        </span>
                                    </div>
                                    @error('order_payment_time')<small class="invalid-feedback" role="alert">{{ $message }}</small> @enderror
                                </div>
                                <div class="col_half bottommargin-xs">
                                    <span class="pt-field-label">จำนวนเงิน <span class="label-red">*</span></span>
                                    <div class="input-daterange travel-date-group">
                                        <input OnKeyPress="return chkNumber(this)" type="text" value="{{ old('order_total') }}" id="order_total" name="order_total"class="sm-form-control tleft" placeholder="ตัวอย่างยอดชำระ {{ number_format($order->totalCart,2) }}">
                                    </div>
                                    @error('order_total')<small class="invalid-feedback" role="alert">{{ $message }}</small> @enderror
                                </div>
                                <div class="col_full bottommargin-xs">
                                    @include('layouts.fontend.button.cartPayment')
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <div class="topmargin-lg bottommargin-lg center">
                    <div class="bottommargin-xs">ไม่พบรายการคำสั่งซื้อนี้</div>
                    <a href="{{ route('fronend.cart') }}">ไปยัง "ตะกร้าสินค้า"</a>
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
@section('js')
 <script src="{{ asset('vendor/select2/select2.min.js') }}"></script>
 <script src="{{ asset('vendor/select2-bootstrap4-theme/docs/script.js') }}"></script>
  <!-- Date & Time Picker JS -->
  <script type="text/javascript" src="{{ asset('assets/fontend/js/components/moment.js') }}"></script>
  <script type="text/javascript" src="{{ asset('assets/fontend/js/components/timepicker.js') }}"></script>
  <script type="text/javascript" src="{{ asset('vendor/datepicker/jquery-ui.js') }}"></script>
  <script>
     $(function() {
         $('.datepicker').datepicker({
             autoclose: true,
             dateFormat: "dd-mm-yy",
         });
         $('.datetimepicker1').datetimepicker({
             format: 'LT',
             showClose: true
         });
     });
  </script>
 @endsection