<div bgcolor="#EFEFEF" text="#808080" style="margin:0px;background-color:#efefef;font-family:Arial,helvetica,sans-serif;line-height:100%;font-size:16px;color:#808080;padding:0px">

    <table align="center" valign="top" style="width: 100%;">
        <tbody>
            <tr>
                <td align="center" valign="top">

                    <table align="center" valign="top" style="width: 1200px; background-color:#ffffff;">
                        <tbody>
                            <tr>
                                <td align="center" valign="top" style="padding:30px;border-bottom:1px solid #f3f3f3;">
                                    <img style="width: 100%; max-width:300px;" src="{{ asset('/storage/setting/'.$data->setting_logoWeb) }}"/>
                                </td>
                            </tr>
                            <tr>
                                <td valign="top" style="padding:30px;">
                                    <br/>
                                    <div style="font-size: 18px;font-weight: 600;">รายงานการแจ้งเตือนของออเดอร์ ในวันที่ {{ date('d-m-Y') }}</div>
                                </td>
                            </tr>
                            <tr>
                                <td valign="top" style="padding:30px;">
                                    <table style="width: 100%">
                                        <thead>
                                            <th align="left" style="background-color:#efefef; padding:10px; border:1px solid #444" >#</th>
                                            <th align="left" style="background-color:#efefef; padding:10px; border:1px solid #444"  >หมายเลขคำสั่งซื้อ</th>
                                            <th align="left" style="background-color:#efefef; padding:10px; border:1px solid #444"  >รายละเอียด</th>
                                        </thead>
                                        <tbody>
                                            @foreach ($data->logs as $log)
                                                <tr>
                                                    <td align="left" style="padding:10px; border:1px solid #444" valign="top">{{ $data->i++}}</td>
                                                    <td align="left" style="padding:10px; border:1px solid #444" valign="top">{{ $log->orderNumber}}</td>
                                                    <td align="left" style="padding:10px; border:1px solid #444" valign="top">{!! $log->orderMessage!!}<br/></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
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
