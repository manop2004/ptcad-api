<!DOCTYPE html>
<html lang="th">
<head>
  <title>{{ $order->orderNumber }}</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>


  <style>
    @font-face {
        font-family: 'Sukhumvit Set';
        font-style: normal;
        font-weight: normal;
        src: url("{{ public_path('fonts/SukhumvitSet-Text.ttf') }}") format('truetype');
    }
    @page { size: A4 portrait; width:21cm; height:29.7cm;  }
    body,table,thead,th,td,strong,small{
        font-family: 'Sukhumvit Set' !important;
        line-height: 0.9;
        color: #4d4c4c;
    }
    table{ width: 100%;}
    .logo-web{
        /* background-image: url('storage/uploads/orderslip/'); */
        background-repeat: no-repeat, repeat;
        height: 80px;
        width:auto;
        background-repeat: no-repeat; /* Do not repeat the image */
        background-size: cover;
    }
    .page_break_before { page-break-before: always; }
    .page_break_after { page-break-after: always; }
  </style>

</head>
<body>

    <div class="pagesize ">
        <table>
            <tr>
                <td>
                    <div style="font-size: 24px;color: #141414;">หมายเลขคำสั่งซื้อ :: {{ $order->orderNumber }}</div>
                    <div >วันที่สั่งซื้อ :: {{ $order->created_at }}</div>
                </td>
                <td style="text-align: right !important;">
                    <img style="width: 180px" src="{{ asset("storage/setting/".$setting->setting_logoWeb) }}" alt="logo" />
                </td>
            </tr>
        </table>
        <hr/>
        <div style="color: #141414;">ต้องการใบกำกับภาษีเต็มรูปแบบหรือไม่?
            @if ($order->statusReceipts == 1)
                <span style="color: #ff0000">ต้องการ</span></div>
                @if (!empty($order->receipt_type))
                    @if ($order->receipt_type == 1)
                        <br/><span style="color: #141414;">ประเภท :</span> บุคคลธรรมดา
                    @else
                        <br/><span style="color: #141414;">ประเภท :</span> บริษัท/สำนักงาน/องค์กร
                    @endif
                @endif
                @if (!empty($order->receipt_tax)) <br/><span style="color: #141414;">เลขประจำตัวผู้เสียภาษี :</span> {{ $order->receipt_tax}} @endif
                @if (!empty($order->receipt_company)) <br/><span style="color: #141414;">ชื่อบริษัท :</span> {{ $order->receipt_company}} @endif @if (!empty($order->receipt_branch)) (สาขา. {{ $order->receipt_branch}})@endif
                @if (!empty($order->receipt_name) && !empty($order->receipt_lastname)) <br/><span style="color: #141414;">ชื่อ-นามสกุล :</span> {{ $order->receipt_name}} {{ $order->receipt_lastname}}@endif
                @if (!empty($order->receipt_address)) <br/><span style="color: #141414;">ที่อยู่ :</span>  {{ $order->receipt_address}} @endif
                @if (!empty($order->receipt_district)) {{ $order->tb_setting_district->dis_name_th }} @endif
                @if (!empty($order->receipt_amphures)) {{ $order->tb_setting_amphure->amp_name_th }} @endif
                @if (!empty($order->receipt_province)) {{ $order->tb_setting_province->prov_name_th }} @endif
                @if (!empty($order->receipt_zipcode)) {{ $order->receipt_zipcode }}@endif
                @if (!empty($order->receipt_tel)) <br/><span style="color: #141414;">เบอร์โทรศัพท์ :</span> {{ $order->receipt_tel}}@endif

            @else
                <span style="color: #ff0000">ไม่ต้องการ</span></div>
            @endif
        <hr/>
        <hr/>
        <div style="color: #141414;">รายละเอียดสินค้า</div>
        <br/>
        <table style="" >
            <tbody >
                <tr>
                    <td style="border: 1px solid #ccc;text-align: left;padding: 5px; background: #353434; color:#fff;">รหัสสินค้า</td>
                    <td style="border: 1px solid #ccc;padding: 5px; background: #353434; color:#fff;">ชื่อสินค้า</td>
                    <td style="border: 1px solid #ccc;text-align: right;padding: 5px; background: #353434; color:#fff;">จำนวน</td>
                </tr>
                @foreach ($order->tb_order_details as $detail )
                    <tr>
                        <td style="border: 1px solid #ccc;padding: 5px;">{{ $detail->product_sku }} @if (!empty($detail->vendor_sku)) <br><strong class="text-danger">Vendor SKU : {{ $detail->vendor_sku }} @endif</strong></td>
                        <td style="border: 1px solid #ccc;padding: 5px;">
                            {{ $detail->product_name }}
                            @if(!empty($detail->product_detail))
                                @if($detail->product_detail != 'null')
                                <br/>{{ $detail->product_detail }}
                                @endif
                            @endif
                        </td>
                        <td style="border: 1px solid #ccc;text-align:right;padding: 5px;">{{ $detail->product_unit }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td ></td>
                    <td style="text-align: right;padding: 5px;">มูลค่า</td>
                    <td style="border: 1px solid #ccc;padding: 5px;text-align: right;">{{ number_format($order->subtotal,2) }}</td>
                </tr>
                @if(!empty($order->conditionValue))
                    <tr>
                        <td ></td>
                        <td style="text-align: right;padding: 5px;">ส่วนลดรวม</td>
                        <td style="border: 1px solid #ccc;padding: 5px;text-align: right;">{{ number_format($order->conditionValue,2) }}</td>
                    </tr>
                @endif
                @if(!empty($order->totaldiscount) && !empty($order->conditionValue))
                    <tr>
                        <td ></td>
                        <td style="text-align: right;padding: 5px;">ราคาสุทธิสินค้า</td>
                        <td style="border: 1px solid #ccc;padding: 5px;text-align: right;">{{ number_format($order->totaldiscount,2) }}</td>
                    </tr>
                @endif
                @if (!empty($order->priceVAT))
                    <tr>
                        <td ></td>
                        <td style="text-align: right;padding: 5px;">ภาษีมูลค่าเพิ่ม</td>
                        <td style="border: 1px solid #ccc;padding: 5px;text-align: right;">{{ number_format($order->priceVAT,2) }}</td>
                    </tr>
                @endif
                @if(!empty($order->priceNettotal))
                <tr>
                    <td ></td>
                    <td style="text-align: right;padding: 5px;">ยอดรวมสุทธิ</td>
                    <td style="border: 1px solid #ccc;padding: 5px;text-align: right;">{{ number_format($order->priceNettotal,2) }}</td>
                </tr>
                @endif
                @if (!empty($order->priceWithholding))
                <tr>
                    <td ></td>
                    <td style="text-align: right;padding: 5px;">หักภาษี ณ ที่จ่าย</td>
                    <td style="border: 1px solid #ccc;padding: 5px;text-align: right;">{{ number_format($order->priceWithholding,2) }}</td>
                </tr>
                @endif
                <tr>
                    <td ></td>
                    <td style="text-align: right;padding: 5px;">การจัดส่ง</td>
                    <td style="border: 1px solid #ccc;padding: 5px;text-align: right;">จัดส่งฟรี</td>
                </tr>
                <tr>
                    <td ></td>
                    <td style="text-align: right;padding: 5px;">ราคารวม</td>
                    <td style="border: 1px solid #ccc;padding: 5px;text-align: right;">{{ number_format($order->totalCart,2) }}</td>
                </tr>
            </tbody>
        </table>
        <hr/>

        <span   div style="color: #141414;">หมายเหตุ : </span><br/>
        <ul>
            @if (!empty($items))
            <li style="font-size: 14px">ซื้อสินค้าโดยอ้างอิงใบเสนอราคาเลขที่ {{ $items->orderNumber}}</li>
            @endif
            <li  style="font-size: 14px">วันที่สั่งซื้อ :: {{ $order->created_at }}</li>
            @if ( $order->payment_type != 1)
                <li  style="font-size: 14px">
                    @if (!empty($order->installmentType))
                        <br/>
                        @if ($order->installmentType == 'installment_bay')
                            <small>ธนาคารกรุงศรี</small>
                        @elseif ($order->installmentType == 'installment_bbl')
                            <small>ธนาคารกรุงเทพ</small>
                        @elseif ($order->installmentType == 'installment_first_choice')
                            <small>กรุงศรีเฟิร์สช้อยส์</small>
                        @elseif ($order->installmentType == 'installment_kbank')
                            <small>ธนาคารกสิกร</small>
                        @elseif ($order->installmentType == 'installment_ktc')
                            <small>ธนาคารกรุงไทย</small>
                        @elseif ($order->installmentType == 'installment_scb')
                            <small>ธนาคารไทยพาณิชย์</small>
                        @endif
                    @endif
                    / ระยะเวลาที่ผ่อน{{ $order->installmentTerm }} เดือน
                    ( ผู้ให้บริการ OMISE )
                </li>
            @endif
        </ul>
    </div>

    @if ( $order->payment_type == 1)
        <div class="pagesize page_break_before">
            <table>
                <tr>
                    <td>
                        <div style="font-size: 24px;color: #141414;">หมายเลขคำสั่งซื้อ :: {{ $order->orderNumber }}</div>
                        <div >วันที่สั่งซื้อ :: {{ $order->created_at }}</div>
                    </td>
                    <td style="text-align: right !important;">
                        <img style="width: 180px" src="{{ asset("storage/setting/".$setting->setting_logoWeb) }}" alt="logo" />
                    </td>
                </tr>
            </table>
            <hr/>
            <span   div style="color: #141414;">หมายเหตุ : </span> ซื้อสินค้าโดยอ้างอิงใบเสนอราคาเลขที่ {{ $order->orderNumber}}<br/>
            <div style="color: #141414;">ข้อมูลการชำระเงิน</div>
            <hr/>
            <span style="color: #141414;">ช่องทางการชำระเงิน ::</span>
            โอนผ่านบัญชีธนาคาร<br/>
            @if (count($order->tb_order_payments) != 0)
            <table style="width: 100%">
                <tbody>
                    @foreach ($order->tb_order_payments as $payment)
                    <tr>
                        <td style="vertical-align: top; width: 50%;">
                            รายละเอียดเพิ่มเติม<br/>
                            - บัญชีที่โอน : {{ App\Models\TbSettingBank::where('id',$payment->payment_bank)->value('bank_name');}}<br/>
                            - หมายเลขบัญชี : {{ $payment->payment_bank_number}}<br/>
                            - วันที่โอน : {{ $payment->payment_date}}<br/>
                            - เวลาที่โอน : {{ $payment->payment_time}}<br/>
                            - จำนวนเงินที่โอน : {{ $payment->payment_total}} บาท<br/>
                            - วันที่แจ้งโอนเงิน ::  {{ $payment->created_at}}

                        </td>
                        <td style="vertical-align: top;">
                            <img style="border:1px solid #ccc; max-width: 300px;width: 100% !important; height:auto !important;" src="{{ asset('storage/orderSlip/'.$payment->payment_slip) }}" alt="logo" />
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif

        </div>
    @endif

    <div class="pagesize page_break_before">
        <table style="width: 100%">
            <tbody>
                <tr>
                    <td style="text-align: left; padding: 10px; vertical-align: bottom;"><img style="width: 180px;" src="{{ asset("storage/setting/".$setting->setting_logoWeb) }}" alt="logo" /></td>
                    <td style="text-align: right; padding: 10px; vertical-align: bottom;"><small style="font-size:10px; text-align: right;">ใบสำหรับแปะหน้ากล่องพัสดุ</small></td>
                </tr>
            </tbody>
        </table>
        <table style="width:100%">
            <tbody>
                <tr>
                    <td style="width:50%;border: 2px solid #141414;text-align: left;padding: 10px;vertical-align: top;">

                        <div style="font-size: 18px;color: #141414;">ชื่อที่อยู่ผู้ฝากส่ง / Sender</div>
                        <hr/>
                        <div style="margin-top:20px"></div>
                        {{ $setting->setting_address}} <br/>
                        เบอร์โทรศัพท์. {{ $setting->setting_telContact}} <br/><br/>

                    </td>
                    <td style="width:50%;border: 2px solid #141414;text-align: left;padding: 10px; vertical-align: top;">

                        <div style="font-size: 18px;color: #141414;">ชื่อที่อยู่ผู้รับ / Address</div>
                        <hr/>
                        <div style="margin-top:20px"></div>
                        @if(!empty($order->residence_name) && !empty($order->residence_lastname)){{ $order->residence_name}} {{ $order->residence_lastname}}<br/>@endif
                        @if(!empty($order->residence_address)){{ $order->residence_address}}<br/>@endif
                        @if(!empty($order->residence_district)){{ $order->tb_setting_district->dis_name_th }} @endif
                        @if(!empty($order->residence_amphures)){{ $order->tb_setting_amphure->amp_name_th }} @endif
                        @if(!empty($order->residence_province)){{ $order->tb_setting_province->prov_name_th }} @endif
                        @if(!empty($order->residence_zipcode)){{ $order->residence_zipcode}}<br/>@endif
                        @if(!empty($order->residence_tel))เบอร์โทรศัพท์. {{ $order->residence_tel}}<br/><br/>@endif

                    </td>
                </tr>
            </tbody>
        </table>
        <br/>
        <table style="width:100%" >
            <tbody >
                <tr>
                    <td style="border: 2px solid #141414;text-align: left;padding: 10px; background:#ccc">รหัสสินค้า</td>
                    <td style="border: 2px solid #141414;padding: 10px; background:#ccc">ชื่อสินค้า</td>
                    <td style="border: 2px solid #141414;text-align: right;padding: 10px; background:#ccc">จำนวน</td>
                </tr>
                @foreach ($order->tb_order_details as $detail )
                    <tr>
                        <td style="width:120px;border: 2px solid #141414;padding: 10px;">{{ $detail->product_sku }} @if (!empty($detail->vendor_sku)) <br><strong class="text-danger">Vendor SKU : {{ $detail->vendor_sku }} @endif</td>
                        <td style="border: 2px solid #141414;padding: 10px;">
                            {{ $detail->product_name }}
                            @if(!empty($detail->product_detail))
                                @if($detail->product_detail != 'null')
                                <br/>{{ $detail->product_detail }}
                                @endif
                            @endif
                        </td>
                        <td style="width: 80px; border: 2px solid #141414;text-align:right;padding: 10px;">{{ $detail->product_unit }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <br/>
        <table >
            <tr>
                <td style="width: 50%; border: 2px solid #141414;text-align: left;padding: 10px; vertical-align: top;">
                    <span style="color: #141414;">หมายเลขคำสั่งซื้อ ::</span> {{ $order->orderNumber }} <br/>
                    <span style="color: #141414;">เพิ่มเติม ::</span> {{ $order->residence_massage }}
                </td>
            </tr>
        </table>
        <br/>
        <br/>
        <br/>
        <div style="text-align: center;">ขอบคุณที่ไว้วางใจสั่งซื้อสินค้ากับเรา (Thank you)</div>
        <br/>
        <br/>
        <br/>
        <div style="width: 100%; border-bottom: 1px dotted #ccc;"></div>
    </div>

</body>
</html>
