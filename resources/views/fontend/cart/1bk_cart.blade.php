@extends('layouts.temp_user')

@section('title'){{ $og_title }} |@endsection
@section('og_site_name'){{ $og_site_name }}@endsection
@section('og_keywords'){{ $og_keywords }}@endsection
@section('og_title'){{ $og_title }}@endsection
@section('og_description'){{ $og_description }}@endsection
@section('og_url'){{ $og_url }}@endsection
@section('og_image'){{ $og_image }}@endsection

@section('css')

@endsection

@section('content')
<section id="content">
    <div class="content-wrap">
        <div class="container">
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

            @if (count($data) != 0)
                <div class="table-responsive">
                    <table class="table cart">
                        <thead>
                            <tr>
                                <th class="cart-product-remove">&nbsp;</th>
                                <th class="cart-product-thumbnail">&nbsp;</th>
                                <th class="cart-product-name">สินค้า</th>
                                <th class="cart-product-price text-right">ราคาสินค้า/ชิ้น</th>
                                <th class="cart-product-quantity">จำนวน</th>
                                <th class="cart-product-subtotal text-right">ราคา</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $update_cart = '';
                            @endphp
                            @foreach ($data as $product)
                                @php
                                    $productDetail = \App\Models\TbProductDetail::where('detail_sku', $product->attributes->sku)->first();
                                    $detail_check_stock_status = 0;
                                    $detail_stock = 0;
                                    $detail_status = 0;
                                    if (!empty($productDetail)) {
                                        $detail_check_stock_status = $productDetail->detail_check_stock_status;
                                        $detail_stock = $productDetail->detail_stock;
                                        $detail_status = $productDetail->detail_status;
                                        
										// สินค้าหมด
                                        if ($detail_status == 2) {
                                            \Cart::remove($product->id);
                                            $update_cart .= 1;
                                        }
                                    }
									
									if($detail_check_stock_status == 1){
										
										if($product->quantity > $detail_stock){
											$product->quantity = $detail_stock;
											
											\Cart::update($product->id,['quantity' => $product->quantity]);
											$update_cart .= 1;
											
										}
										
									}
									
									// สินค้าหมด
									if ($product->quantity == 0 || $product->quantity == '') {
										\Cart::remove($product->id);
										$update_cart .= 1;
									}
									
                                @endphp
                                @if ($detail_status != 2)
                                <tr class="cart_item">
                                    <td class="cart-product-remove">
                                        <a href="{{ route('cart.delete', $product->id) }}" class="remove" title="Remove this item"><i class="icon-trash2"></i></a>
                                    </td>
                                    <td class="cart-product-thumbnail">
                                        <a href="{{ route('fronend.product.content', $product->attributes->permalink) }}"><img width="64" height="64" src="{{ $product->attributes->image }}" alt="{{ $product->name }}"></a>
                                    </td>
                                    <td class="cart-product-name">
                                        <a href="{{ route('fronend.product.content', $product->attributes->permalink) }}">
                                            SKU : {{ $product->attributes->sku }}<br/>
                                            @if ($product->attributes->detail_name != 'null')
                                                {{ $product->name }} ({{ $product->attributes->detail_name }})
                                                @if ($product->attributes->detail_other != 'null') <br/> {{ $product->attributes->detail_other }} @endif
                                            @else
                                                {{ $product->name }}
                                            @endif
                                        </a>
                                    </td>
                                    <td class="cart-product-price text-right">
                                        @if ($product->attributes->pricesale != 0 && number_format($product->attributes->price) != number_format($product->price))
                                            <span class="amount-sale co-red">{{ number_format($product->attributes->price, 2) }}</span>
                                        @endif
                                        <span class="amount">{{ number_format($product->price, 2) }}</span>
										
                                    </td>
                                    <td class="cart-product-quantity b-quantity">
                                        <div class="quantity clearfix">
                                            <input type="button" value="-" class="minus" data-id="{{ $product->id }}">
                                            <input type="text" id="quantity-{{ $product->id }}" data-id="{{ $product->id }}" name="quantity" class="qty" value="{{ $product->quantity }}" />
                                            <input type="button" value="+" class="plus" data-id="{{ $product->id }}">
                                            <input type="hidden" id="detail_check_stock_status-{{ $product->id }}" value="{{ $detail_check_stock_status }}">
                                            <input type="hidden" id="detail_stock-{{ $product->id }}" value="{{ $detail_stock }}">
                                        </div>
										<div id="div_alert_stock_{{ $product->id }}" style="display: none;">
											<small class="text-danger">คุณได้เพิ่มสินค้าครบตามจำนวนสต็อกแล้ว</small>
										</div>
                                    </td>
                                    <td class="cart-product-subtotal text-right">
                                        <span class="amount">{{ number_format($product->price * $product->quantity, 2) }}</span>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                            @if ($update_cart != '')
                                <script>
                                    window.location.reload();
                                </script>
                            @endif
                            <tr class="cart_item">
                                <td colspan="5" class="text-right">รวม</td>
                                <td class="text-right">{{ number_format($total['subtotal'], 2) }}.-</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div>
                    <div class="row clearfix">
                        <div class="col-md-7 col-xs-12">
                            <a href="{{ route('fronend.cart.coupon') }}">เลือกโค้ดส่วนลด ></a>
                        </div>
                        <div class="col-md-5 col-xs-12">
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-7"><a href="{{ route('fronend.cart') }}" class="btn button button-3d btn-block b_cart">อัพเดตตะกร้าสินค้า</a></div>
                                <div class="col-xs-12 col-sm-6 col-md-5"><a href="{{ route('fronend.cart.confirm') }}" class="btn button button-3d btn-block b_cart">สั่งซื้อสินค้า</a></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-7"></div>
                    <div class="col-md-5">
                        <br>
                        <div class="table-responsive">
                            <h4>ยอดรวมสินค้า</h4>
                            <table class="table cart">
                                <tbody>
                                    @if (count($dataCondition) != 0)
                                        @foreach ($dataCondition as $condition)
                                            <tr class="cart_item">
                                                <td class="cart-product-name co-f1c40f">
                                                    <strong>ส่วนลดรวม <br/><small>{{ $condition->getName() }}</small></strong>
                                                </td>
                                                <td class="cart-total-name co-f1c40f">
                                                    @if ($condition->getType() == 1)
                                                        <span class="amount-condition">{{ number_format($condition->getValue(), 2) }}.-</span>
                                                    @else
                                                        <span class="amount-condition">{{ $condition->getValue() }}%</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    @if (!empty($total['totaldiscount']))
                                        @if (count($dataCondition) != 0 || $total['vat'] != 0)
                                            <tr class="cart_item">
                                                <td class="cart-product-name">
                                                    <strong>ราคาสุทธิสินค้า</strong>
                                                </td>
                                                <td class="cart-total-name">
                                                    <span id="sumTotal_n" class="amount">{{ number_format($total['totaldiscount'], 2) }}.-</span>
                                                </td>
                                            </tr>
                                        @endif
                                    @endif
                                    @if (!empty($total['vat']))
                                        @if ($total['vat'] != 0)
                                            <tr class="cart_item" id="tdcartVat">
                                                <td class="cart-product-name">
                                                    <strong>ภาษีมูลค่าเพิ่ม</strong>
                                                </td>
                                                <td class="cart-total-name">
                                                    <span id="cartVat" class="amount">{{ number_format($total['vat'], 2) }}.-</span>
                                                </td>
                                            </tr>
                                        @endif
                                    @endif
                                    @if (!empty($total['nettotal']))
                                    <tr class="cart_item" id="cartNettotal">
                                        <td class="cart-product-name">
                                            <strong>ยอดรวมสุทธิ</strong>
                                        </td>
                                        <td class="cart-total-name">
                                            <span id="cartNettotal" class="amount">{{ number_format($total['nettotal'], 2) }}.-</span>
                                        </td>
                                    </tr>
                                    @endif
                                    @if (!empty($total['withholding']))
                                    <tr class="cart_item" id="tdcartVat">
                                        <td class="cart-product-name">
                                            <strong>หัก ภาษี ณ ที่จ่าย</strong>
                                        </td>
                                        <td class="cart-total-name">
                                            <span id="cartWithholding" class="amount">{{ number_format($total['withholding'], 2) }}.-</span>
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
                                            <span id="totalCart" class="amount color lead"><strong>{{ number_format($total['total'], 2) }}.-</strong></span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            @else
                <div class="topmargin-lg bottommargin-lg text-center">
                    <h2>ไม่มีสินค้าในตะกร้า</h2>
                </div>
            @endif

        </div>
    </div>
</section>
@endsection

@section('js')
<script>
	
    $(document).ready(function() {
        function updateQuantity(id, delta) {
            var quantityInput = $("#quantity-" + id);
            var currentVal = parseInt(quantityInput.val());
            var checkStock = parseInt($("#detail_check_stock_status-" + id).val());
            var stock = parseInt($("#detail_stock-" + id).val());

            if (!isNaN(currentVal) && ((delta < 0 && currentVal > 1) || (delta > 0 && (checkStock === 0 || currentVal < stock)))) {
                currentVal += delta;
                quantityInput.val(currentVal);
                $("#_productUnit").val(currentVal);
                $("#div_alert_stock_"+id).hide();
                return currentVal;
            } else if (delta > 0 && checkStock === 1 && currentVal >= stock) {
                $("#div_alert_stock_"+id).show();
            }else{
				currentVal += delta;
                quantityInput.val(currentVal);
                $("#_productUnit").val(currentVal);
                $("#div_alert_stock_"+id).hide();
                return currentVal;
			}
            return null;
        }

        $(".cart .minus").click(function () {
            var id = $(this).data('id');
            var newQuantity = updateQuantity(id, -1);
            if (newQuantity !== null) {
                $.ajax({
                    dataType: "json",
                    method: "get",
                    url: "/cart/update",
                    data: { rowId: id, quantity: newQuantity },
                    headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
                    cache: !1,
                    beforeSend: function () {},
                    success: function (e) {},
                    failure: function (e) {
                        alert(e);
                    },
                });
            }
        });

        $(".cart .plus").click(function () {
            var id = $(this).data('id');
            var newQuantity = updateQuantity(id, 1);
            if (newQuantity !== null) {
                $.ajax({
                    dataType: "json",
                    method: "get",
                    url: "/cart/update",
                    data: { rowId: id, quantity: newQuantity },
                    headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
                    cache: !1,
                    beforeSend: function () {},
                    success: function (e) {},
                    failure: function (e) {
                        alert(e);
                    },
                });
            }
        });

        $(".cart .qty").blur(function () {
            var id = $(this).data('id');
            var currentVal = parseInt($(this).val());
            var checkStock = parseInt($("#detail_check_stock_status-" + id).val());
            var stock = parseInt($("#detail_stock-" + id).val());

            if (isNaN(currentVal) || currentVal < 1) {
                $(this).val(1);
                $("#div_alert_stock_"+id).hide();
            } else if (checkStock === 1 && currentVal > stock) {
                $(this).val(stock);
                $("#div_alert_stock_"+id).show();
            } else {
                $("#div_alert_stock_"+id).hide();
            }

            var newQuantity = $(this).val();
            $.ajax({
                dataType: "json",
                method: "get",
                url: "/cart/update",
                data: { rowId: id, quantity: newQuantity },
                headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
                cache: !1,
                beforeSend: function () {},
                success: function (e) {},
                failure: function (e) {
                    alert(e);
                },
            });
        });
    });
</script>
@endsection
