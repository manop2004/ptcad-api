<div bgcolor="#EFEFEF" text="#808080" style="margin:0px;background-color:#efefef;font-family:Arial,helvetica,sans-serif;line-height:100%;font-size:16px;color:#808080;padding:0px">

    <table align="center" valign="top" style="width: 100%;">
        <tbody>
            <tr>
                <td align="center" valign="top">

                    <table align="center" valign="top" style="width: 600px; background-color:#ffffff;">
                        <tbody>
                            <tr>
                                <td align="center" valign="top" style="padding:10px;border-bottom:1px solid #f3f3f3;">
                                    <table style="width:100%;font-family:Arial,helvetica,sans-serif;line-height:100%;font-size:12px;">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <img style="width: 100%; max-width:200px;" src="{{ asset('/storage/setting/'.$data->setting_logoWeb) }}"/>
                                                </td>
                                                <td style="text-align: right" valign="botom">
                                                    <span style="font-size: 14px; background: {{$data->order->tb_setting_payment_status->status_color}}; color:#fff; padding:10px;">
                                                        &nbsp;&nbsp;{{$data->order->tb_setting_payment_status->status_name}}&nbsp;&nbsp;
                                                    </span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td valign="top" style="padding:10px;">
                                    <br/>
                                    <div style="font-size: 14px;font-weight: 600;">หมายเลขคำสั่งซื้อ : {{$data->order->orderNumber}}</div>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" valign="top" style="padding:10px;font-size:14px;">
                                    <table style="width: 100%" >
                                        <tbody >
                                            <tr>
                                                <td colspan="2" style="text-align:center;font-size:14px;color: #141414;border: 1px solid #ccc;padding: 5px; background: #353434; color:#fff;">ชื่อสินค้า</td>
                                                <td style="font-size:14px;color: #141414;border: 1px solid #ccc;text-align: right;padding: 5px; background: #353434; color:#fff;">จำนวน</td>
                                            </tr>
                                            @foreach ($data->order->tb_order_details as $detail )
                                                <tr>
                                                    <td style="text-align:center;font-size:14px;color: #141414;border: 1px solid #ccc;padding: 5px; width: 50px;">
                                                        <img width="50" style="width: 50px!important;" src="{{ $detail->product_img }}" />
                                                    </td>
                                                    <td valign="top" style="font-size:14px;color: #141414;border: 1px solid #ccc;padding: 5px;">
                                                        SKU : {{ $detail->product_sku }}<br/>
                                                        {{ $detail->product_name }}
                                                        @if(!empty($detail->product_detail))
                                                            @if($detail->product_detail != 'null')
                                                            <br/>{{ $detail->product_detail }}
                                                            @endif
                                                        @endif
                                                    </td>
                                                    <td valign="top" style="font-size:14px;color: #141414;border: 1px solid #ccc;text-align:right;padding: 5px;">{{ $detail->product_unit }}</td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td ></td>
                                                <td style="text-align: right;padding: 5px;">มูลค่า</td>
                                                <td style="border: 1px solid #ccc;padding: 5px;text-align: right;">{{ number_format($data->order->subtotal,2) }}</td>
                                            </tr>
                                            @if(!empty($data->order->conditionValue))
                                                <tr>
                                                    <td ></td>
                                                    <td style="text-align: right;padding: 5px;">ส่วนลดรวม</td>
                                                    <td style="border: 1px solid #ccc;padding: 5px;text-align: right;">{{ number_format($data->order->conditionValue,2) }}</td>
                                                </tr>
                                            @endif
                                            @if(!empty($data->order->totaldiscount) && !empty($data->order->conditionValue))
                                                <tr>
                                                    <td ></td>
                                                    <td style="text-align: right;padding: 5px;">ราคาสุทธิสินค้า</td>
                                                    <td style="border: 1px solid #ccc;padding: 5px;text-align: right;">{{ number_format($data->order->totaldiscount,2) }}</td>
                                                </tr>
                                            @endif
                                            @if (!empty($data->order->priceVAT))
                                                <tr>
                                                    <td ></td>
                                                    <td style="text-align: right;padding: 5px;">ภาษีมูลค่าเพิ่ม</td>
                                                    <td style="border: 1px solid #ccc;padding: 5px;text-align: right;">{{ number_format($data->order->priceVAT,2) }}</td>
                                                </tr>
                                            @endif
                                            @if(!empty($data->order->priceNettotal))
                                            <tr>
                                                <td ></td>
                                                <td style="text-align: right;padding: 5px;">ยอดรวมสุทธิ</td>
                                                <td style="border: 1px solid #ccc;padding: 5px;text-align: right;">{{ number_format($data->order->priceNettotal,2) }}</td>
                                            </tr>
                                            @endif
                                            @if (!empty($data->order->priceWithholding))
                                            <tr>
                                                <td ></td>
                                                <td style="text-align: right;padding: 5px;">หักภาษี ณ ที่จ่าย</td>
                                                <td style="border: 1px solid #ccc;padding: 5px;text-align: right;">{{ number_format($data->order->priceWithholding,2) }}</td>
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
                                                <td style="border: 1px solid #ccc;padding: 5px;text-align: right;">{{ number_format($data->order->totalCart,2) }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td align="left" valign="top" style="padding:10px;">
                                    <hr/><br/>
                                    <p style="color: #141414;font-size:14px; font-weight: 600; margin-bottom:10px;">หมายเหตุ</p>
                                    <ul style="line-height: 1.5;">
                                        <li  style="font-size: 14px;color: #141414;">ซอฟต์แวร์ของคุณกำลังจะหมดอายุวันที่ :: {{ date("d-m-Y",strtotime($data->softwares->date_exp)) }}</li>
                                        <li  style="font-size: 14px;color: #141414;">กรุณาต่ออายุก่อนที่ซอฟต์แวร์ของคุณจะหมดอายุ เพื่อความต่อเนื่องในการใช้งาน</li>
                                    </ul>
                                    <br/>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" valign="top" style="border-top:1px solid #f3f3f3;">

                                    <table align="center" valign="top" style="width:100%;font-family:Arial,helvetica,sans-serif;line-height:100%;font-size:12px;">
                                        <tbody>
                                            <tr>
                                                <td align="center" valign="top">
                                                    <br/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="center" valign="top" style="padding: 10px;color:#000;">
                                                    อีเมลฉบับนี้เป็นการแจ้งข้อมูลจากระบบอัตโนมัติ กรุณาอย่าตอบกลับอีเมลนี้
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="center" valign="top">
                                                    @if (!empty($data->page->page_about))
                                                        @php
                                                            $about = App\Models\TbPage::where('id',$data->page->page_about)->first();
                                                            if($about->pages_type == 1){
                                                                $aboutLink = route('fronend.page.content',$about->page_parmalink);
                                                            }else {
                                                                $aboutLink = $about->page_parmalink;
                                                            }
                                                        @endphp
                                                        <a href="{{ $aboutLink }}" style="color:#007c89;font-weight:500;text-decoration:none" target="_blank">เกี่ยวกับเรา</a>
                                                        <span>&nbsp;&nbsp;•&nbsp;&nbsp;</span>
                                                    @endif
                                                    @if (!empty($data->page->page_privacy_policy))
                                                        @php
                                                            $privacy_policy = App\Models\TbPage::where('id',$data->page->page_privacy_policy)->first();
                                                            if($privacy_policy->pages_type == 1){
                                                                $privacy_policyLink = route('fronend.page.content',$privacy_policy->page_parmalink);
                                                            }else {
                                                                $privacy_policyLink = $privacy_policy->page_parmalink;
                                                            }
                                                        @endphp
                                                        <a href="{{ $privacy_policyLink }}" style="color:#007c89;font-weight:500;text-decoration:none" target="_blank">นโยบายความเป็นส่วนตัว</a>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="center" valign="top" style="padding: 10px;color:#000;">
                                                    <div style="max-width: 400px; line-height: 1.5;">{{ $data->setting_nameWeb }}</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="center" valign="top">
                                                    <br/>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </td>
                            </tr>
                        </tbody>
                    </table>

                </td>
            </tr>
        </tbody>
    </table>

</div>
