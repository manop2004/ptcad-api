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
  --soft:#f6f9ff; --green:#20b26b; --red:#ef4444; --shadow:0 18px 50px rgba(20,53,143,.10);
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
  padding:36px 28px;
  background:linear-gradient(105deg,#ffffff 0%,#f4f9ff 60%,#e4f3ff 100%);
  border-radius:24px;margin-bottom:28px;
  border:1px solid var(--line);
  box-shadow:0 10px 30px rgba(20,53,143,.03);
}
.acct-hero .eyebrow{display:inline-flex;align-items:center;gap:8px;color:var(--blue);font-weight:800;font-size:13px;margin-bottom:10px}
.acct-hero h1{font-size:clamp(22px,4vw,32px);margin:0 0 8px;color:var(--navy);letter-spacing:-.5px}
.acct-hero p{margin:0;color:var(--muted);font-size:14.5px;max-width:640px;line-height:1.6}

.acct-portal{display:grid;grid-template-columns:270px 1fr;gap:26px}
.acct-side{position:sticky;top:100px;align-self:start;border:1px solid var(--line);border-radius:22px;background:#fff;box-shadow:0 12px 34px rgba(20,53,143,.055);padding:14px}
.acct-side a{height:46px;border-radius:14px;display:flex;align-items:center;gap:12px;padding:0 14px;color:#344054;font-weight:700;font-size:14px}
.acct-side a img{width:18px;height:18px;object-fit:contain}
.acct-side a:hover,.acct-side a.active{background:#eef6ff;color:var(--blue)}
.acct-side a.signout{color:var(--red)}

.acct-main{display:grid;gap:24px;min-width:0}
.acct-card{background:#fff;border:1px solid var(--line);border-radius:24px;padding:26px;box-shadow:0 12px 34px rgba(20,53,143,.055)}

/* ===== Order status bar ===== */
.od-status-bar{
  display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;
  padding:16px 20px;background:var(--soft);border-radius:14px;margin-bottom:24px;
}
.od-status-badge{
  display:inline-flex;align-items:center;padding:6px 14px;border-radius:999px;
  font-size:12px;font-weight:800;color:#fff;
}
.od-order-number{font-size:14px;font-weight:800;color:var(--navy)}

/* ===== Address info cards ===== */
.od-info-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:18px;margin-bottom:24px}
.od-info-box{background:#fbfdff;border:1px solid var(--line);border-radius:16px;padding:18px 20px}
.od-info-box h4{margin:0 0 10px;font-size:14px;color:var(--navy);font-weight:800;display:flex;align-items:center;gap:8px}
.od-info-box .body{font-size:13.5px;color:#344054;line-height:1.8}

/* ===== Order items ===== */
.od-items{border:1px solid var(--line);border-radius:16px;overflow:hidden;margin-bottom:24px}
.od-item-row{display:flex;align-items:center;gap:16px;padding:14px 18px;border-bottom:1px solid var(--line)}
.od-item-row:last-child{border-bottom:none}
.od-item-thumb{width:60px;height:60px;border-radius:12px;object-fit:cover;border:1px solid var(--line);background:#fbfdff;flex-shrink:0}
.od-item-info{flex:1;min-width:0}
.od-item-info small{color:var(--muted);font-size:12px}
.od-item-info .name{font-weight:700;font-size:13.5px;color:#102b76;margin:3px 0;word-break:break-word}
.od-item-price{text-align:right;font-weight:800;color:#102b76;font-size:14px;white-space:nowrap;flex-shrink:0}
.od-item-price .old{text-decoration:line-through;color:var(--muted);font-weight:500;font-size:12px;margin-right:6px}

/* ===== Payment + Summary ===== */
.od-summary-grid{display:grid;grid-template-columns:1fr 1fr;gap:18px}
@media (max-width:760px){.od-summary-grid{grid-template-columns:1fr}}
.od-payment-box,.od-total-box{background:#fbfdff;border:1px solid var(--line);border-radius:16px;padding:18px 20px}
.od-payment-box h4,.od-total-box h4{margin:0 0 12px;font-size:14px;color:var(--navy);font-weight:800}
.od-payment-box .body{font-size:13.5px;color:#344054;line-height:1.8}
.od-payment-box .body a{color:var(--blue);font-weight:700}
.od-total-row{display:flex;justify-content:space-between;padding:9px 0;border-bottom:1px dashed var(--line);font-size:13.5px;color:#344054}
.od-total-row:last-child{border-bottom:none}
.od-total-row.grand{padding-top:14px;font-size:16px;font-weight:800;color:var(--navy)}
.od-total-row.grand .amt{color:var(--blue)}
.od-discount-label{color:#f59e0b;font-weight:700;font-size:12px}
.od-amount-sale{color:var(--muted);text-decoration:line-through;font-size:12px;margin-right:4px}

/* ===== Action buttons ===== */
.od-actions{
  display:flex;
  justify-content:flex-end;
  align-items:center;
  gap:12px;
  flex-wrap:wrap;
  margin-top:24px
}
.cancel-form{
  margin:0 !important;
  display:inline-flex;
  align-items:center;
}

.od-btn{
  height:46px;
  padding:0 24px;
  border-radius:12px;
  font-weight:700;
  font-size:14px;
  display:inline-flex;
  align-items:center;
  justify-content:center;
  gap:8px;
  border:none;
  cursor:pointer;
  transition:all .2s ease;
  line-height:1;
}
.od-btn:hover{transform:translateY(-2px)}

/* ปุ่มแจ้งชำระเงิน (สีฟ้า - น้ำเงิน) */
.od-btn.primary{
  background:linear-gradient(135deg, var(--blue) 0%, var(--navy) 100%);
  color:#fff;
  box-shadow:0 8px 20px rgba(23,101,255,.25);
}
.od-btn.primary:hover{
  box-shadow:0 12px 24px rgba(23,101,255,.35);
}

/* ปุ่มยกเลิก (สีแดง มีสไตล์สอดคล้องกัน) */
.od-btn.danger, 
.cancel-form button, 
.cancel-form input[type="submit"]{
  height:46px;
  padding:0 24px;
  border-radius:12px;
  font-weight:700;
  font-size:14px;
  display:inline-flex;
  align-items:center;
  justify-content:center;
  gap:8px;
  border:1.5px solid #fecdd3;
  background:#fff;
  color:var(--red);
  box-shadow:0 4px 12px rgba(239,68,68,.05);
  cursor:pointer;
  transition:all .2s ease;
  line-height:1;
}
.od-btn.danger:hover, 
.cancel-form button:hover, 
.cancel-form input[type="submit"]:hover{
  background:#fef2f2;
  border-color:var(--red);
  color:var(--red);
  transform:translateY(-2px);
}

@media (max-width:1000px){
  .acct-portal{grid-template-columns:1fr}
  .acct-side{position:relative;top:0;display:grid;grid-template-columns:repeat(3,1fr)}
}
@media (max-width:640px){
  .acct-side{grid-template-columns:1fr 1fr}
  .od-actions{justify-content:stretch}
  .od-btn, .cancel-form, .cancel-form button{width:100%;flex:1 1 auto;justify-content:center}
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
        <h1>รายละเอียดคำสั่งซื้อ</h1>
        <p>หมายเลขคำสั่งซื้อ {{ $data->orderNumber }}</p>
    </section>

    <div class="acct-portal">
        @include('layouts.fontend.account_sidebar')

        <div class="acct-main">
            <section class="acct-card">

                {{-- ===== สถานะคำสั่งซื้อ ===== --}}
                <div class="od-status-bar">
                    <span class="od-status-badge" style="background: {{ $data->tb_setting_payment_status->status_color}}">{{ $data->tb_setting_payment_status->status_name}}</span>
                    <span class="od-order-number">หมายเลขคำสั่งซื้อ : {{ $data->orderNumber }}</span>
                </div>

                {{-- ===== ที่อยู่จัดส่ง / ใบเสร็จ ===== --}}
                <div class="od-info-grid">
                    <div class="od-info-box">
                        <h4><i data-lucide="truck" size="16"></i> ที่อยู่ในการจัดส่งสินค้า</h4>
                        <div class="body">
                            @if(!empty($data->residence_name) && $data->residence_lastname){{ $data->residence_name }} {{ $data->residence_lastname }}<br/>@endif
                            @if(!empty($data->residence_tel))Tel. {{ $data->residence_tel }}<br/>@endif
                            @if(!empty($data->residence_address)){{ $data->residence_address }}<br/>@endif
                            @if(!empty($data->residence_province)){{ $data->tb_setting_province->prov_name_th }} @endif
                            @if(!empty($data->residence_amphures)){{ $data->tb_setting_amphure->amp_name_th }} @endif
                            @if(!empty($data->residence_district)){{ $data->tb_setting_district->dis_name_th }} @endif
                            @if(!empty($data->residence_zipcode)){{ $data->tb_setting_district->dis_code }}@endif
                            @if(!empty($data->residence_massage))<br/>Note. {{ $data->residence_massage }}@endif
                        </div>
                    </div>
                    @if($data->statusReceipts == 1)
                    <div class="od-info-box">
                        <h4><i data-lucide="receipt" size="16"></i> ที่อยู่ในการจัดส่งใบเสร็จรับเงิน</h4>
                        <div class="body">
                            @if(!empty($data->receipt_tax))Tax. {{ $data->receipt_tax }}<br/>@endif
                            @if(!empty($data->receipt_company))บริษัท {{ $data->receipt_company }}<br/>@endif
                            @if(!empty($data->receipt_branch))สาขา {{ $data->receipt_branch }}<br/>@endif
                            @if(!empty($data->receipt_name) && $data->receipt_lastname){{ $data->receipt_name }} {{ $data->receipt_lastname }}<br/>@endif
                            @if(!empty($data->receipt_tel))Tel. {{ $data->receipt_tel }}<br/>@endif
                            @if(!empty($data->receipt_address)){{ $data->receipt_address }}<br/>@endif
                            @if(!empty($data->receipt_province)){{ $data->tb_receipt_province->prov_name_th }} @endif
                            @if(!empty($data->receipt_amphures)){{ $data->tb_receipt_amphures->amp_name_th }} @endif
                            @if(!empty($data->receipt_district)){{ $data->tb_receipt_district->dis_name_th }} @endif
                            @if(!empty($data->receipt_zipcode)){{ $data->tb_receipt_district->dis_code }}@endif
                        </div>
                    </div>
                    @endif
                </div>

                {{-- ===== รายการสินค้า ===== --}}
                <div class="od-items">
                    @foreach ($data->tb_order_details as $detail)
                        <div class="od-item-row">
                            <img src="{{ $detail->product_img }}" class="od-item-thumb" />
                            <div class="od-item-info">
                                <small>SKU : {{ $detail->product_sku }}</small>
                                <div class="name">
                                    @if (!empty($detail->product_detail))
                                        @if ($detail->product_detail != 'null')
                                            {{ $detail->product_detail }}
                                        @else
                                            {{ $detail->product_name }}
                                        @endif
                                    @else
                                        {{ $detail->product_name }}
                                    @endif
                                </div>
                                <small>X{{ $detail->product_unit}}</small>
                            </div>
                            <div class="od-item-price">
                                @if (!empty($detail->product_price_sale))
                                    <span class="old">{{ number_format($detail->product_price_sale) }}</span> {{ number_format($detail->product_price,2) }}
                                @else
                                    {{ number_format($detail->product_price,2) }}
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- ===== วิธีชำระเงิน + สรุปยอด ===== --}}
                <div class="od-summary-grid">
                    <div class="od-payment-box">
                        <h4><i data-lucide="credit-card" size="16"></i> ช่องทางการชำระเงิน</h4>
                        <div class="body">
                            @if ($data->payment_type == 1)
                                โอนผ่านบัญชีธนาคาร
                            @elseif($data->payment_type == 2)
                                ผ่อนชำระ
                            @elseif($data->payment_type == 3)
                                บัตรเครดิต
                            @elseif($data->payment_type == 4)
                                พร้อมเพย์
                            @elseif($data->payment_type == 5)
                                โมบายแบงก์กิ้ง
                            @elseif($data->payment_type == 6)
                                ทรูมันนี่ วอลเล็ท
                            @else
                                บัตรเครดิต
                            @endif

                            @if(!empty($data->payment_massage))
                                <br/><br/>
                                <strong>รายละเอียดการชำระเงิน</strong><br/>
                                {!! $data->payment_massage !!}
                            @endif

                            @if(count($data->tb_order_payments) != 0)
                                @foreach ( $data->tb_order_payments as $payment)
                                    <br/>
                                    <a href="{{ asset('storage/orderSlip/'.$payment->payment_slip) }}" target="_bank">สลิปการชำระเงิน</a>
                                @endforeach
                            @endif
                            @if (!empty($data->installmentType))
                                <br/>
                                @if ($data->installmentType == 'installment_bay' || $data->installmentType == 'mobile_banking_bay')
                                    ธนาคารกรุงศรี
                                @elseif ($data->installmentType == 'installment_bbl' || $data->installmentType == 'mobile_banking_bbl')
                                    ธนาคารกรุงเทพ
                                @elseif ($data->installmentType == 'installment_first_choice')
                                    กรุงศรีเฟิร์สช้อยส์
                                @elseif ($data->installmentType == 'installment_kbank' || $data->installmentType == 'mobile_banking_kbank')
                                    ธนาคารกสิกร
                                @elseif ($data->installmentType == 'installment_ktc' || $data->installmentType == 'mobile_banking_ktc')
                                    ธนาคารกรุงไทย
                                @elseif ($data->installmentType == 'installment_scb' || $data->installmentType == 'mobile_banking_scb')
                                    ธนาคารไทยพาณิชย์
                                @endif
                            @endif
                            @if(!empty($data->installmentTerm))
                                / {{ $data->installmentTerm }} เดือน
                            @endif
                        </div>
                    </div>

                    <div class="od-total-box">
                        <h4><i data-lucide="calculator" size="16"></i> สรุปยอดคำสั่งซื้อ</h4>

                        @if(!empty($data->subtotal))
                            <div class="od-total-row">
                                <span>รวม</span>
                                <span>{{ number_format($data->subtotal,2) }}</span>
                            </div>
                        @endif
                        @if(!empty($data->conditionValue))
                            <div class="od-total-row">
                                <span class="od-discount-label">ส่วนลดรวม<br/>{{ $data->conditionName }}</span>
                                <span>
                                    @if ($data->conditionType == 1)
                                        {{ number_format($data->conditionValue,2) }}
                                    @else
                                        {{ $data->conditionValue }}%
                                    @endif
                                </span>
                            </div>
                        @endif
                        @if(!empty($data->totaldiscount) && !empty($data->conditionValue))
                            <div class="od-total-row">
                                <span>ราคาสุทธิสินค้า</span>
                                <span id="sumTotal_n">{{ number_format($data->totaldiscount,2) }}</span>
                            </div>
                        @endif
                        @if(!empty($data->priceVAT))
                            <div class="od-total-row">
                                <span>ภาษีมูลค่าเพิ่ม</span>
                                <span id="cartVat">{{ number_format($data->priceVAT,2) }}</span>
                            </div>
                        @endif
                        @if(!empty($data->priceNettotal))
                            <div class="od-total-row">
                                <span>ยอดรวมสุทธิ</span>
                                <span id="cartNettotal">{{ number_format($data->priceNettotal,2) }}</span>
                            </div>
                        @endif
                        @if(!empty($data->priceWithholding))
                            <div class="od-total-row">
                                <span>หัก ภาษี ณ ที่จ่าย</span>
                                <span id="cartWithholding">{{ number_format($data->priceWithholding,2) }}</span>
                            </div>
                        @endif
                        <div class="od-total-row">
                            <span>การจัดส่ง</span>
                            <span>จัดส่งฟรี</span>
                        </div>
                        <div class="od-total-row grand">
                            <span>จำนวนเงินที่ต้องชำระ</span>
                            <span id="totalCart" class="amt">{{ number_format($data->totalCart,2) }}</span>
                        </div>
                    </div>
                </div>

                {{-- ===== ปุ่มดำเนินการ ===== --}}
                @if($data->payment_status == 1)
                <div class="od-actions">
                    <a href="{{ route('fronend.cart.repeat',$data->id) }}">
                        <button type="button" class="od-btn primary">
                            <i data-lucide="banknote" size="18"></i> แจ้งชำระเงิน
                        </button>
                    </a>
                    
                    {{
                        Form::model($data, [
                            'novalidate',
                            'route' => ['fronend.order.cancel',$data->id],
                            'class' => 'cancel-form ' . (($errors->any()) ? 'was-validated' : 'needs-validation'),
                            'id'=>'cancel-order',
                            'method' => 'put',
                            'files' => true
                        ])
                    }}
                        @include('layouts.fontend.button.cartCancle')
                    </form>
                </div>
                @endif
            </section>
        </div>
    </div>

</div>

@endsection

@section('js')

@endsection