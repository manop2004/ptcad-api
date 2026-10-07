<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<style>
@font-face {
    font-family: 'Kanit';
    src: url('{{ public_path('fonts/Kanit/Kanit-Regular.ttf') }}') format('truetype');
    font-weight: normal;
    font-style: normal;
}
@font-face {
    font-family: 'Kanit';
    src: url('{{ public_path('fonts/Kanit/Kanit-SemiBold.ttf') }}') format('truetype');
    font-weight: bold;
    font-style: normal;
}

* { box-sizing: border-box; }

body{
    font-family: 'Kanit', sans-serif;
    font-size: 12px;
    color: #20324a;
    margin: 0;
    padding: 0;
    background: #eef5fb;
}

.doc-wrap{ padding: 15px; }

.card{
    width: 100%;
    background: #ffffff;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(50,83,126,.12);
}

.header-band{
    width: 100%;
    background: linear-gradient(135deg,#f7fbff,#e7f2ff);
    border-bottom: 1px solid #dfebf7;
    padding: 20px;
}

.header-table{
    width: 100%;
    border-collapse: collapse;
}

.header-table td{ vertical-align: top; }

.logo-img{ max-height: 40px; }
.logo-text-fallback{ font-size: 22px; font-weight: bold; color: #295db7; }
.tagline{ font-size: 10.5px; color: #295db7; font-weight: 700; margin-top: 4px; }

/* ถอยจากขอบขวามาทางซ้ายอีกนิด (40px) */
.invoice-title{
    font-size: 15px;
    font-weight: bold;
    color: #172941;
    text-align: right;
    padding-right: 40px;
}

.invoice-no{
    font-size: 10.5px;
    color: #8292a8;
    text-align: right;
    margin-top: 4px;
    line-height: 1.5;
    padding-right: 40px;
}

.status-badge{
    display: inline-block;
    font-size: 10px;
    font-weight: bold;
    padding: 3px 10px;
    border-radius: 10px;
    color: #fff;
    background: #20b26b;
    margin-top: 4px;
}

.content-wrap{ padding: 24px; }

.addr-table{ width: 100%; margin-bottom: 20px; border-collapse: collapse; }
.addr-table td{ vertical-align: top; width: 50%; padding-right: 12px; }
.addr-label{
    font-size: 10px; color: #ffffff; font-weight: bold; text-transform: uppercase;
    margin-bottom: 6px; background: #3564c6; display: inline-block; padding: 3px 10px; border-radius: 8px;
}
.addr-body{ font-size: 12px; line-height: 1.6; color: #3f5169; }

table.items{ width: 100%; border-collapse: collapse; margin-bottom: 20px; border-radius: 10px; overflow: hidden; }
table.items th{
    background: #172941; color: #ffffff; font-size: 11px; text-align: left;
    padding: 9px 12px;
}
table.items td{ padding: 9px 12px; border-bottom: 1px solid #e9eef5; font-size: 12px; color: #3f5169; }
table.items tr:nth-child(even) td{ background: #f7fbff; }
table.items .num{ text-align: right; }

table.totals{ width: 100%; margin-top: 10px; }
table.totals td{ padding: 4px 0; font-size: 12px; color: #52647c; }
table.totals .label{ text-align: right; padding-right: 16px; }
table.totals .value{ text-align: right; width: 130px; }
table.totals .grand{ background: #f4f8fd; }
table.totals .grand td{
    font-size: 15px; font-weight: bold; color: #172941;
    padding: 10px 14px; border-top: 2px solid #3564c6;
}
table.totals .grand .label{ color: #172941; }

.footer-band{
    width: 100%; background: #f4f8fd; padding: 14px 24px;
    border-top: 1px solid #e9eef5;
}
.footer-note{ font-size: 10.5px; color: #8292a8; text-align: center; }
</style>
</head>
<body>

<div class="doc-wrap">
<div class="card">

    <div class="header-band">
        <table class="header-table">
            <tr>
                <td style="width:40%;">
                    @if(!empty($setting->setting_logoWeb))
                        <img class="logo-img" src="{{ public_path('storage/setting/'.$setting->setting_logoWeb) }}">
                    @else
                        <div class="logo-text-fallback">PTCAD</div>
                    @endif
                    <div class="tagline">ใช้งานง่าย · คุ้มค่า · พร้อมช่วยเหลือ</div>
                </td>
                <td style="width:60%;">
                    <div class="invoice-title">ใบเสร็จรับเงิน / Invoice</div>
                    <div class="invoice-no">
                        เลขที่: {{ $data->orderNumber }}<br>
                        วันที่: {{ date("d-m-Y", strtotime($data->created_at)) }}<br>
                        <span class="status-badge">
                            {{ $data->tb_setting_payment_status->status_name ?? 'ชำระเงินสำเร็จ' }}
                        </span>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="content-wrap">

        <table class="addr-table">
            <tr>
                <td>
                    <div class="addr-label">ที่อยู่จัดส่ง / ผู้สั่งซื้อ</div>
                    <div class="addr-body">
                        @if(!empty($data->residence_name)){{ $data->residence_name }} {{ $data->residence_lastname }}<br>@endif
                        @if(!empty($data->residence_tel))Tel. {{ $data->residence_tel }}<br>@endif
                        @if(!empty($data->residence_address)){{ $data->residence_address }}<br>@endif
                        @if(!empty($data->tb_setting_province)){{ $data->tb_setting_province->prov_name_th ?? '' }} @endif
                        @if(!empty($data->tb_setting_amphure)){{ $data->tb_setting_amphure->amp_name_th ?? '' }} @endif
                        @if(!empty($data->tb_setting_district)){{ $data->tb_setting_district->dis_name_th ?? '' }} {{ $data->tb_setting_district->dis_code ?? '' }}@endif
                    </div>
                </td>
                <td>
                    @if($data->statusReceipts == 1)
                    <div class="addr-label">ที่อยู่ออกใบเสร็จ / ผู้เสียภาษี</div>
                    <div class="addr-body">
                        @if(!empty($data->receipt_tax))เลขประจำตัวผู้เสียภาษี: {{ $data->receipt_tax }}<br>@endif
                        @if(!empty($data->receipt_company))บริษัท {{ $data->receipt_company }}<br>@endif
                        @if(!empty($data->receipt_branch))สาขา {{ $data->receipt_branch }}<br>@endif
                        @if(!empty($data->receipt_name)){{ $data->receipt_name }} {{ $data->receipt_lastname }}<br>@endif
                        @if(!empty($data->receipt_address)){{ $data->receipt_address }}<br>@endif
                        @if(!empty($data->tb_receipt_province)){{ $data->tb_receipt_province->prov_name_th ?? '' }} @endif
                        @if(!empty($data->tb_receipt_amphures)){{ $data->tb_receipt_amphures->amp_name_th ?? '' }} @endif
                        @if(!empty($data->tb_receipt_district)){{ $data->tb_receipt_district->dis_name_th ?? '' }} {{ $data->tb_receipt_district->dis_code ?? '' }}@endif
                    </div>
                    @endif
                </td>
            </tr>
        </table>

        <table class="items">
            <thead>
                <tr>
                    <th>รายการ</th>
                    <th>SKU</th>
                    <th class="num">จำนวน</th>
                    <th class="num">ราคา/หน่วย</th>
                    <th class="num">รวม</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data->tb_order_details as $detail)
                @php
                    $unitPrice = !empty($detail->product_price_sale) ? $detail->product_price_sale : $detail->product_price;
                    $lineTotal = $unitPrice * $detail->product_unit;
                @endphp
                <tr>
                    <td>
                        @if (!empty($detail->product_detail) && $detail->product_detail != 'null')
                            {{ $detail->product_detail }}
                        @else
                            {{ $detail->product_name }}
                        @endif
                    </td>
                    <td>{{ $detail->product_sku }}</td>
                    <td class="num">{{ $detail->product_unit }}</td>
                    <td class="num">{{ number_format($unitPrice,2) }}</td>
                    <td class="num">{{ number_format($lineTotal,2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <table class="totals">
            @if(!empty($data->subtotal))
            <tr><td class="label">รวม</td><td class="value">{{ number_format($data->subtotal,2) }}</td></tr>
            @endif
            @if(!empty($data->conditionValue))
            <tr>
                <td class="label">ส่วนลด {{ $data->conditionName }}</td>
                <td class="value">
                    @if ($data->conditionType == 1)
                        -{{ number_format($data->conditionValue,2) }}
                    @else
                        -{{ $data->conditionValue }}%
                    @endif
                </td>
            </tr>
            @endif
            @if(!empty($data->priceVAT))
            <tr><td class="label">ภาษีมูลค่าเพิ่ม</td><td class="value">{{ number_format($data->priceVAT,2) }}</td></tr>
            @endif
            @if(!empty($data->priceWithholding))
            <tr><td class="label">หัก ภาษี ณ ที่จ่าย</td><td class="value">-{{ number_format($data->priceWithholding,2) }}</td></tr>
            @endif
            <tr class="grand">
                <td class="label">ยอดรวมสุทธิ</td>
                <td class="value">{{ number_format($data->totalCart,2) }} บาท</td>
            </tr>
        </table>

    </div>

    <div class="footer-band">
        <div class="footer-note">
            เอกสารนี้สร้างจากระบบอัตโนมัติของ PTCAD — หากมีข้อสงสัยเกี่ยวกับใบเสร็จนี้ กรุณาติดต่อทีมงาน
        </div>
    </div>

</div>
</div>

</body>
</html>