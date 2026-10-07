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

.pt-cart-wrap{
  --navy:#12358f; --blue:#1765ff; --ink:#0b1f4d; --muted:#667085; --line:#e6edf8;
  --soft:#f6f9ff; --red:#ef4444; --shadow:0 18px 50px rgba(20,53,143,.10);
  font-family:'Poppins','Noto Sans Thai',system-ui,sans-serif; color:var(--ink);
}
.pt-cart-wrap *{box-sizing:border-box}
.pt-cart-wrap a{text-decoration:none;color:inherit}

.pt-cart-hero{padding:48px 8px;background:linear-gradient(105deg,#ffffff 0%,#f4f9ff 60%,#e4f3ff 100%);border-radius:24px;margin-bottom:28px}
.pt-cart-hero h1{font-size:34px;margin:0 0 8px;color:var(--navy);letter-spacing:-1px}
.pt-cart-hero p{margin:0;color:var(--muted);font-size:15px;max-width:640px;line-height:1.6}

.pt-cart-grid{display:grid;grid-template-columns:1fr .55fr;gap:24px}
.pt-cart-card{background:#fff;border:1px solid var(--line);border-radius:24px;padding:26px;box-shadow:0 12px 34px rgba(20,53,143,.055)}
.pt-cart-card h2{font-size:20px;margin:0 0 18px;color:#102b76}

.pt-cart-item{display:flex;gap:14px;align-items:center;padding:16px 0;border-bottom:1px solid var(--line)}
.pt-cart-item:last-child{border-bottom:none}
.pt-cart-item img{width:64px;height:64px;object-fit:cover;border-radius:10px;border:1px solid var(--line)}
.pt-cart-item-name{flex:1;min-width:0;font-size:14px;color:#344054;line-height:1.5;overflow-wrap:break-word}
.pt-cart-item-name small{display:block;color:var(--muted);font-size:12px}
.pt-cart-item-price{text-align:right;min-width:90px;font-weight:800;color:var(--blue);font-size:14px}
.pt-cart-remove{color:var(--red);width:32px;text-align:center}

.pt-cart-wrap .quantity{display:flex;border:1px solid var(--line);border-radius:10px;overflow:hidden;background:#fff}
.pt-cart-wrap .quantity input.minus,.pt-cart-wrap .quantity input.plus{width:32px;height:32px;border:none;background:var(--soft);color:var(--blue);font-weight:800;cursor:pointer}
.pt-cart-wrap .quantity input.qty{width:40px;height:32px;border:none;text-align:center;font-weight:700}

.pt-cart-summary-row{display:flex;justify-content:space-between;border-bottom:1px solid var(--line);padding:12px 0;color:#344054;font-size:14px}
.pt-cart-summary-row:last-child{border-bottom:none}
.pt-cart-summary-row.total{font-weight:800;font-size:16px;color:var(--navy)}
.pt-cart-actions{display:flex;flex-direction:column;gap:10px;margin-top:18px}
.pt-cart-btn{height:46px;border-radius:12px;font-weight:800;font-size:14px;display:flex;align-items:center;justify-content:center;gap:8px}
.pt-cart-btn.primary{background:linear-gradient(135deg,var(--blue),#0d57df);color:#fff;box-shadow:0 12px 24px rgba(23,101,255,.22)}
.pt-cart-btn.secondary{background:#fff;color:var(--blue);border:1.5px solid var(--blue)}
.pt-cart-coupon-link{color:var(--blue);font-weight:700;font-size:14px;display:inline-flex;align-items:center;gap:6px;margin-bottom:14px}

.pt-cart-empty{text-align:center;padding:60px 20px;color:var(--muted)}
.pt-cart-empty h2{color:var(--navy);margin-bottom:8px}

@media (max-width:900px){
  .pt-cart-grid{grid-template-columns:1fr}
}

/* =====================================================================
   [แก้ใหม่] Mobile fix: ชื่อสินค้าตัวอักษรตกลงมาทีละตัว (แนวตั้ง)
   สาเหตุ: แถวสินค้าเป็น flex แนวนอนทั้งหมด (ปุ่มลบ+รูป+ชื่อ+จำนวน+ราคา)
   รวมความกว้างคงที่ของ sibling ทำให้เหลือพื้นที่ให้ชื่อสินค้าแคบมาก
   วิธีแก้: จัดชื่อสินค้าให้ขึ้นบรรทัดใหม่เต็มความกว้างบนจอแคบ
   ===================================================================== */
@media (max-width:600px){
  .pt-cart-wrap{
    padding:0 16px !important;
    margin:20px auto !important;
    width:100% !important;
    max-width:100% !important;
    box-sizing:border-box !important;
    overflow-x:hidden;
  }
  .pt-cart-item{
    flex-wrap:wrap;
    justify-content:space-between;
    gap:10px 12px;
  }
  .pt-cart-item .pt-cart-remove{order:1}
  .pt-cart-item > a:not(.pt-cart-item-name):not(.pt-cart-remove){order:2}
  .pt-cart-item-name{
    order:3;
    flex:1 1 100%;
    font-size:13.5px;
  }
  .pt-cart-wrap .quantity{order:4}
  .pt-cart-item-price{order:5;text-align:right;min-width:0}
}
.pt-cart-limit-warning{
  background:#fff8ee; border:1.5px solid #fde3c0; border-radius:14px;
  padding:14px 18px; margin-bottom:18px; display:flex; align-items:flex-start; gap:12px;
  color:#b45309; font-size:13.5px; line-height:1.6;
}
.pt-cart-limit-warning i{flex:none; margin-top:2px}
.pt-cart-limit-warning b{color:#92400e}
</style>
@endsection

@section('content')

<div class="pt-cart-wrap" style="width:100%;padding:0 28px;max-width:1400px;margin:32px auto">

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

    <div class="pt-cart-hero">
        <h1>ตะกร้าสินค้า</h1>
        <p>ตรวจสอบรายการสินค้าก่อนเข้าสู่ขั้นตอนชำระเงิน</p>
    </div>

    @if (count($data) != 0)
    <div class="pt-cart-grid">
        <div class="pt-cart-card">
            @if(!empty($licenseOverLimit))
            <div class="pt-cart-limit-warning">
                <i data-lucide="alert-triangle" size="18"></i>
                <span>
                    <b>คำเตือน:</b> คุณมีสินค้ารวม {{ $totalLicenseQty }} License ในตะกร้า แต่ 1 ออเดอร์สามารถออก License ได้สูงสุด <b>{{ $maxLicensePerOrder }} License</b> เท่านั้น
                    หากดำเนินการต่อ ระบบจะสร้าง License ให้เพียง {{ $maxLicensePerOrder }} ตัวแรกเท่านั้น กรุณาแยกคำสั่งซื้อหากต้องการมากกว่านี้
                </span>
            </div>
            @endif
            <h2>รายการสินค้า</h2>

            @foreach ($data as $product)
                @php
                    $productDetail = \App\Models\TbProductDetail::where('detail_sku', $product->attributes->sku)->first();

                    $detail_check_stock_status = 0;
                    $detail_stock = 0;
                    $detail_status = 0;

                    $min_order = 1;
                    $max_order = null;

                    if (!empty($productDetail)) {
                        $detail_check_stock_status = (int) ($productDetail->detail_check_stock_status ?? 0);
                        $detail_stock = (int) ($productDetail->detail_stock ?? 0);
                        $detail_status = (int) ($productDetail->detail_status ?? 0);

                        $min_order = (int) ($productDetail->min_order ?? 1);
                        if ($min_order < 1) $min_order = 1;

                        $max_order_val = (int) ($productDetail->max_order ?? 0);
                        $max_order = ($max_order_val > 0) ? $max_order_val : null;
                    }
                @endphp

                @if ($detail_status != 2)
                <div class="pt-cart-item">
                    <a href="{{ route('cart.delete', $product->id) }}" class="pt-cart-remove" title="Remove this item">
                        <i data-lucide="trash-2" size="16"></i>
                    </a>

                    <a href="{{ route('fronend.product.content', $product->attributes->permalink) }}">
                        <img src="{{ $product->attributes->image }}" alt="{{ $product->name }}">
                    </a>

                    <a href="{{ route('fronend.product.content', $product->attributes->permalink) }}" class="pt-cart-item-name">
                        @if ($product->attributes->detail_name != 'null')
                            {{ $product->name }} ({{ $product->attributes->detail_name }})
                            @if ($product->attributes->detail_other != 'null') <br/> {{ $product->attributes->detail_other }} @endif
                        @else
                            {{ $product->name }}
                        @endif
                        <small>SKU: {{ $product->attributes->sku }}</small>
                    </a>

                    <div class="quantity clearfix">
                        <input type="button" value="-" class="minus" data-id="{{ $product->id }}">
                        <input
                            type="text"
                            id="quantity-{{ $product->id }}"
                            data-id="{{ $product->id }}"
                            name="quantity"
                            class="qty"
                            value="{{ (int)$product->quantity }}"
                        />
                        <input type="button" value="+" class="plus" data-id="{{ $product->id }}">

                        <input type="hidden" id="detail_check_stock_status-{{ $product->id }}" value="{{ $detail_check_stock_status }}">
                        <input type="hidden" id="detail_stock-{{ $product->id }}" value="{{ $detail_stock }}">
                        <input type="hidden" id="min_order-{{ $product->id }}" value="{{ $min_order }}">
                        <input type="hidden" id="max_order-{{ $product->id }}" value="{{ $max_order ?? '' }}">
                    </div>

                    <div class="pt-cart-item-price">
                        @if ($product->attributes->pricesale != 0 && number_format($product->attributes->price) != number_format($product->price))
                            <small style="display:block;color:var(--muted);text-decoration:line-through">{{ number_format($product->attributes->price, 2) }}</small>
                        @endif
                        ฿{{ number_format($product->price * $product->quantity, 2) }}
                    </div>
                </div>
                <div id="div_alert_stock_{{ $product->id }}" style="display:none;padding:0 0 8px 90px">
                    <small style="color:var(--red)"></small>
                </div>
                @endif
            @endforeach

            <a href="{{ route('fronend.category.all') }}" class="pt-cart-btn secondary" style="display:inline-flex;padding:0 22px;width:auto;height:40px;margin-top:16px">
                <i data-lucide="plus" size="16"></i> เลือกสินค้าเพิ่ม
            </a>

            <div style="margin-top:16px">
                <a href="{{ route('fronend.cart.coupon') }}" class="pt-cart-coupon-link" style="margin-top:0">
                    <i data-lucide="tag" size="16"></i> เลือกโค้ดส่วนลด
                </a>
            </div>
        </div>

        <div class="pt-cart-card">
            <h2>สรุปคำสั่งซื้อ</h2>

            @if (!empty($total['totaldiscount']))
    @if (count($dataCondition) != 0 || $total['vat'] != 0)
        <div class="pt-cart-summary-row">
            <span>ราคาสุทธิสินค้า</span>
            <b id="sumTotal_n">฿{{ number_format($total['totaldiscount'], 2) }}</b>
        </div>
    @endif
@endif

@if (count($dataCondition) != 0)
    @foreach ($dataCondition as $condition)
        <div class="pt-cart-summary-row" style="color:#f1c40f">
            <span>ส่วนลด<br><small>{{ $condition->getName() }}</small></span>
            <b>
                @if ($condition->getType() == 1)
                    -฿{{ number_format($condition->getValue(), 2) }}
                @else
                    -{{ $condition->getValue() }}%
                @endif
            </b>
        </div>
    @endforeach
@endif

@if (!empty($total['vat']) && $total['vat'] != 0)
    <div class="pt-cart-summary-row" id="tdcartVat">
        <span>ภาษีมูลค่าเพิ่ม</span>
        <b id="cartVat">฿{{ number_format($total['vat'], 2) }}</b>
    </div>
@endif

@if (!empty($total['nettotal']))
    <div class="pt-cart-summary-row" id="cartNettotal">
        <span>ยอดรวมสุทธิ</span>
        <b>฿{{ number_format($total['nettotal'], 2) }}</b>
    </div>
@endif

            @if (!empty($total['withholding']))
                <div class="pt-cart-summary-row">
                    <span>หัก ภาษี ณ ที่จ่าย</span>
                    <b id="cartWithholding">฿{{ number_format($total['withholding'], 2) }}</b>
                </div>
            @endif

            <div class="pt-cart-summary-row">
                <span>การจัดส่ง</span>
                <b>จัดส่งฟรี</b>
            </div>

            <div class="pt-cart-summary-row total">
                <span>จำนวนเงินที่ต้องชำระ</span>
                <b id="totalCart">฿{{ number_format($total['total'], 2) }}</b>
            </div>

            <div class="pt-cart-actions">
                <a href="{{ route('fronend.cart.confirm') }}" class="pt-cart-btn primary">
                    <i data-lucide="credit-card" size="18"></i> ไปชำระเงิน
                </a>
                <a href="{{ route('fronend.cart') }}" class="pt-cart-btn secondary">
                    <i data-lucide="refresh-ccw" size="18"></i> อัพเดตตะกร้าสินค้า
                </a>
            </div>
        </div>
    </div>

    @else
    <div class="pt-cart-card pt-cart-empty">
        <i data-lucide="shopping-cart" size="40" style="color:var(--muted);margin-bottom:12px"></i>
        <h2>ไม่มีสินค้าในตะกร้า</h2>
        <p>เลือกซอฟต์แวร์ที่ต้องการแล้วกลับมาที่นี่อีกครั้ง</p>
        <br>
        <a href="{{ route('fronend.category.all') }}" class="pt-cart-btn primary" style="display:inline-flex;padding:0 28px;width:auto">เลือกซื้อสินค้า</a>
    </div>
    @endif

</div>

@endsection

@section('js')
<script>
$(document).ready(function() {

    function intVal(v){
        v = parseInt(v, 10);
        return isNaN(v) ? null : v;
    }

    // [แก้ใหม่] ใช้ attribute selector [id='...'] แทน #id ตรงๆ
    // เพราะ id สินค้าบางตัวมีเครื่องหมาย + ปนอยู่ (เช่น 355_Civil+Pro+MAX_00_PRO)
    // ซึ่ง jQuery ตีความ + ใน #id selector ผิดเพี้ยนไป (เป็นอักขระพิเศษของ CSS selector)
    function $byId(prefix, id){
        return $("[id='" + prefix + id + "']");
    }

    function getMin(id){
        var v = intVal($byId("min_order-", id).val());
        if (v === null || v < 1) return 1;
        return v;
    }

    function getMax(id){
        var v = intVal($byId("max_order-", id).val());
        if (v === null || v < 1) return null;
        return v;
    }

    function getStockUpper(id){
        var checkStock = intVal($byId("detail_check_stock_status-", id).val()) || 0;
        var stock = intVal($byId("detail_stock-", id).val());
        if (checkStock === 1 && stock !== null && stock > 0) return stock;
        return null;
    }

    function getUpper(id){
        var maxO = getMax(id);
        var stock = getStockUpper(id);
        if (maxO === null && stock === null) return null;
        if (maxO === null) return stock;
        if (stock === null) return maxO;
        return Math.min(maxO, stock);
    }

    function setAlert(id, msg){
        var $div = $byId("div_alert_stock_", id);
        if (!msg){
            $div.hide();
            return;
        }
        $div.find("small").text(msg);
        $div.show();
    }

    function syncByServer(id, wantQty){
        return $.ajax({
            dataType: "json",
            method: "get",
            url: "/cart/update",
            data: { rowId: id, quantity: wantQty },
            headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
            cache: false,
            success: function (res) {
                if (res && res.removed) {
                    window.location.href = "{{ route('fronend.cart') }}";
                    return;
                }

                if (res && typeof res.quantity_final !== "undefined") {
                    $byId("quantity-", id).val(res.quantity_final);

                    var minO = getMin(id);
                    var upper = getUpper(id);

                    if (res.quantity_final < minO) {
                        setAlert(id, "สินค้านี้สั่งขั้นต่ำ " + minO + " ชิ้น");
                    } else if (upper !== null && res.quantity_final >= upper && wantQty > upper) {
                        var maxO = getMax(id);
                        var stockU = getStockUpper(id);
                        if (stockU !== null && upper === stockU) {
                            setAlert(id, "คุณได้เพิ่มสินค้าครบตามจำนวนสต็อกแล้ว (" + upper + " ชิ้น)");
                        } else if (maxO !== null && upper === maxO) {
                            setAlert(id, "สินค้านี้สั่งได้สูงสุด " + upper + " ชิ้น");
                        } else {
                            setAlert(id, "จำนวนถูกปรับตามเงื่อนไขสินค้า");
                        }
                    } else {
                        setAlert(id, "");
                    }
                }
            }
        });
    }

    $(".pt-cart-wrap .minus").click(function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        var current = intVal($byId("quantity-", id).val());
        if (current === null) current = getMin(id);

        var minO = getMin(id);
        var next = current - 1;

        if (next < minO) {
            next = minO;
            setAlert(id, "สินค้านี้สั่งขั้นต่ำ " + minO + " ชิ้น");
        }

        syncByServer(id, next);
    });

    $(".pt-cart-wrap .plus").click(function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        var current = intVal($byId("quantity-", id).val());
        if (current === null) current = getMin(id);

        var upper = getUpper(id);
        var next = current + 1;

        if (upper !== null && next > upper) {
            next = upper;

            var maxO = getMax(id);
            var stockU = getStockUpper(id);
            if (stockU !== null && upper === stockU) {
                setAlert(id, "คุณได้เพิ่มสินค้าครบตามจำนวนสต็อกแล้ว (" + upper + " ชิ้น)");
            } else if (maxO !== null && upper === maxO) {
                setAlert(id, "สินค้านี้สั่งได้สูงสุด " + upper + " ชิ้น");
            } else {
                setAlert(id, "จำนวนถูกปรับตามเงื่อนไขสินค้า");
            }
        }

        syncByServer(id, next);
    });

    $(".pt-cart-wrap .qty").blur(function () {
        var id = $(this).data('id');

        var v = intVal($(this).val());
        var minO = getMin(id);
        var upper = getUpper(id);

        if (v === null || v <= 0) v = minO;
        if (v < minO) v = minO;
        if (upper !== null && v > upper) v = upper;

        syncByServer(id, v);
    });

});
</script>

@if(session('invalid'))
    @php
        $msgs = [
            1 => 'คุณมีคูปองนี้ในระบบแล้ว.',
            2 => 'คูปองนี้หมดอายุแล้ว ไม่สามารถใช้งานได้.',
            3 => 'คูปองนี้ไม่สามารถใช้งานได้ เนื่องจากมีผู้ใช้ครบจำนวนที่กำหนดไว้แล้ว.',
            4 => 'ไม่สามารถใช้คูปองได้ เนื่องจากมีการใช้ครบตามจำนวนที่กำหนดแล้ว.',
            5 => 'ไม่สามารถใช้คูปองได้ เนื่องจากราคาสินค้าน้อยกว่าที่กำหนด.',
            6 => 'ไม่สามารถใช้คูปองได้ เนื่องจากราคาสินค้ามากกว่าที่กำหนด.',
            7 => 'ไม่สามารถใช้คูปองได้ เนื่องจากสินค้าไม่ได้เข้าร่วมกับส่วนลดนี้.',
            8 => 'ไม่สามารถใช้คูปองได้ เนื่องจากสินค้าในหมวดหมู่ไม่ได้เข้าร่วมกับส่วนลดนี้.',
            9 => 'ไม่สามารถใช้คูปองได้ เนื่องจากยังไม่มีสินค้าในตะกร้าสินค้า.',
            10 => 'ไม่สามารถใช้คูปองได้ เนื่องจากคูปองนี่ไม่สามารถใช้ร่วมกับสินค้าลดราคาได้.',
        ];
        $code = session('invalid');
    @endphp
    <script>
        alert(@json($msgs[$code]));
    </script>
@endif

@endsection