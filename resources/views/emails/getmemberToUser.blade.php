<div bgcolor="#EFEFEF" text="#808080" style="margin:0px;background-color:#efefef;font-family:Arial,helvetica,sans-serif;line-height:100%;font-size:16px;color:#808080;padding:0px">

    <table align="center" valign="top" style="width: 100%;">
        <tbody>
            <tr>
                <td align="center" valign="top">
                    <br/>
                    <br/>
                    <a href="{{ asset('') }}">
                        <img width="800" style="width: 100%; max-width:800px;" src="{{ asset('images/membergetmember/userCode_Ref.jpeg') }}"/>
                    </a>
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

</div>
