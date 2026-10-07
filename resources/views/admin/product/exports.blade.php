<table>
    <thead>
        <tr>
            @if($exportType === 'promotion')
                <th style="width: 150px; text-align: left">sku_product</th>
                <th style="width: 150px; text-align: left">sku_promotion</th>
                <th style="width: 350px; text-align: left">name_product_main</th>
                <th style="width: 350px; text-align: left">name_product_sub</th>
                <th style="width: 120px; text-align: right">price_promotion</th>
                <th style="width: 120px; text-align: center">price_promotion_start</th>
                <th style="width: 120px; text-align: center">price_promotion_end</th>
                <th style="width: 100px; text-align: center">hide_cart</th>
                <th style="width: 250px; text-align: left">promotion_detial</th>
            @elseif($exportType === 'main')
                <th style="width: 150px; text-align: left">sku_product</th>
                <th style="width: 150px; text-align: left">new_sku_product</th>
                <th style="width: 350px; text-align: left">name_product_main</th>
                <th style="width: 350px; text-align: left">name_product_sub</th>
                <th style="width: 120px; text-align: right">price_product</th>
            @else
                <th style="width: 150px; text-align: left">sku_product</th>
                <th style="width: 150px; text-align: left">new_sku_product</th>
                <th style="width: 150px; text-align: left">sku_promotion</th>
                <th style="width: 350px; text-align: left">name_product_main</th>
                <th style="width: 350px; text-align: left">name_product_sub</th>
                <th style="width: 120px; text-align: right">price_product</th>
                <th style="width: 120px; text-align: right">price_promotion</th>
                <th style="width: 120px; text-align: center">price_promotion_start</th>
                <th style="width: 120px; text-align: center">price_promotion_end</th>
                <th style="width: 100px; text-align: center">hide_cart</th>
                <th style="width: 250px; text-align: left">promotion_detial</th>
            @endif
        </tr>
    </thead>
    <tbody>
       @foreach ($products as $detail)
            <tr>
                @if($exportType === 'promotion')
                    <td style="text-align: left">{{ $detail->detail_sku }}</td>
                    <td style="text-align: left">{{ $detail->vendor_sku }}</td>
                    <td style="text-align: left">{{ $detail->pro_name }}</td>
                    <td style="text-align: left">{{ $detail->detail_name }}</td>
                    <td style="text-align: right">
                        @if($detail->detail_price_sale_status == 1)
                            {{ $detail->detail_price_sale }}
                        @endif
                    </td>
                    <td style="text-align: center">
                        @if($detail->detail_price_sale_status == 1)
                            {{ $detail->detail_sale_date_start }}
                        @endif
                    </td>
                    <td style="text-align: center">
                        @if($detail->detail_price_sale_status == 1)
                            {{ $detail->detail_sale_date_end }}
                        @endif
                    </td>
                    <td style="text-align: center">
						@if($detail->hide_addtocart_status == 1)
                            yes
                        @endif
                    </td>
                    <td style="text-align: left">{{ $detail->detail_other }}</td>

                @elseif($exportType === 'main')
                    <td style="text-align: left">{{ $detail->detail_sku }}</td>
                    <td style="text-align: left"></td>
                    <td style="text-align: left">{{ $detail->pro_name }}</td>
                    <td style="text-align: left">{{ $detail->detail_name }}</td>
                    <td style="text-align: right">
                        @if(!empty($detail->detail_price))
                            {{ $detail->detail_price }}
                        @endif
                    </td>

                @else
                    <td style="text-align: left">{{ $detail->detail_sku }}</td>
                    <td style="text-align: left"></td>
                    <td style="text-align: left">{{ $detail->vendor_sku }}</td>
                    <td style="text-align: left">{{ $detail->pro_name }}</td>
                    <td style="text-align: left">{{ $detail->detail_name }}</td>
                    <td style="text-align: right">
                        @if(!empty($detail->detail_price))
                            {{ $detail->detail_price }}
                        @endif
                    </td>
                    <td style="text-align: right">
                        @if($detail->detail_price_sale_status == 1)
                            {{ $detail->detail_price_sale }}
                        @endif
                    </td>
                    <td style="text-align: center">
                        @if($detail->detail_price_sale_status == 1)
                            {{ $detail->detail_sale_date_start }}
                        @endif
                    </td>
                    <td style="text-align: center">
                        @if($detail->detail_price_sale_status == 1)
                            {{ $detail->detail_sale_date_end }}
                        @endif
                    </td>
                    <td style="text-align: center">
						@if($detail->hide_addtocart_status == 1)
                            yes
                        @endif
					</td>
                    <td style="text-align: left">{{ $detail->detail_other }}</td>
                @endif
            </tr>
       @endforeach
    </tbody>
</table>