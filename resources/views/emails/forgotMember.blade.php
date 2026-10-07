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
                                                <td style="background-color:#ffffff; text-align:center">
                                                    <img width="200" style="background:#fff" src="https://ptcadthailand.com/storage/setting/6a74435077561.png"/>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" valign="top" style="padding:30px;">
                                    <table style="width:100%;font-family:Arial,helvetica,sans-serif;font-size:16px;">
                                        <tbody>
                                            <tr>
                                                <td><br/><br/></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div style="font-family:Arial,helvetica,sans-serif;font-size: 16px;font-style: normal;line-height: 2; color:#000; text-align:center;">
                                                        <div style="font-size: 20px;">รีเซ็ตรหัสผ่านบัญชีผู้ใช้ของคุณ</div><br/>
                                                        ท่านสามารถคลิกที่ "ตั้งรหัสผ่าน" เพื่อจัดการรหัสผ่านใหม่
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><br/><br/></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div style="font-family:Arial,helvetica,sans-serif;font-size: 16px;font-style: normal;line-height: 2; color:#000; text-align:center;">
                                                        <table align="center" cellpadding="0" cellspacing="0" border="0">
                                                            <tbody>
                                                                <tr>
                                                                    <td align="center" bgcolor="#1a56c4" style="border-radius:6px;">
                                                                        <a href="{{ asset('/forgot/'.$data->id.'/'.$data->user_code.'/mail') }}" target="_blank" style="display:inline-block;padding:12px 40px;font-family:Arial,helvetica,sans-serif;font-size:16px;font-weight:bold;color:#ffffff;text-decoration:none;border-radius:6px;">
                                                                            ตั้งรหัสผ่าน
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><br/><br/></td>
                                            </tr>
                                            <tr>
                                                <td style="font-family:Arial,helvetica,sans-serif;font-size: 16px;font-style: normal;line-height: 2; color:#000; text-align:center;">
                                                    ทางบริษัทขอขอบคุณลูกค้าทุกท่าน<br/>
                                                    ที่ให้ความไว้วางใจและเชื่อมั่นในบริการของเรามาโดยตลอด
                                                </td>
                                            </tr>
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