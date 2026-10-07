<div bgcolor="#EFEFEF" text="#808080" style="margin:0px;background-color:#efefef;font-family:Arial,helvetica,sans-serif;line-height:100%;font-size:16px;color:#808080;padding:0px">

    <table align="center" valign="top" style="width: 100%;">
        <tbody>
            <tr>
                <td align="center" valign="top">

                    <table align="center" valign="top" style="width: 600px; background-color:#ffffff;">
                        <tbody>
                            <tr style="background-color:#12358f;">
    <td width="100%" style="background-color:#12358f; width:100%; text-align:center; padding: 20px;">
        @if(!empty($data->setting_logoWeb))
            <img style="max-width:180px; height:auto;" src="{{ asset('storage/setting/' . $data->setting_logoWeb) }}" alt="{{ $data->setting_nameWeb }}">
        @else
            <span style="color:#fff; font-size:22px; font-weight:bold;">{{ $data->setting_nameWeb }}</span>
        @endif
    </td>
</tr>
                            <tr>
                                <td align="center" valign="top" style="padding:30px;">
                                    <table style="width:100%;font-family:Arial,helvetica,sans-serif;font-size:16px;">
                                        <tbody>
                                            <tr>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td style="color:#000;">
                                                    <br/>
                                                    <p style="color:#000;">เรียน คุณ{{ $data->ticket->name}}</p>
                                                    <p style="color:#000; line-height: 25px;">ขอขอบคุณที่ติดต่อฝ่ายบริการลูกค้าของเรา เราได้รับเรื่องของคุณแล้วและได้สร้าง Service Ticket ไปยังฝ่ายบริการลูกค้าของเราเรียบร้อย</p>
                                                    <br/>
                                                    <p style="color:#000;">Ticket ID : {{ $data->ticket->code}}</p>
                                                    @if(!empty($data->ticket->program))
                                                    <p style="color:#000;">โปรแกรมที่ขอใช้บริการ : {{ $data->ticket->program}}</p>
                                                    @endif
                                                    <p style="color:#000;">Email : {{ $data->ticket->email}}</p>
                                                    <p style="color:#000;">เบอร์โทรศัพท์ : {{ $data->ticket->tel}}</p>
                                                    <p style="color:#000;">รายละเอียด :</p>
                                                    <p style="color:#000;">{!! $data->ticket->message !!}</p>
                                                    <br/>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td ></td>
                                            </tr>
                                            <tr>
                                                <td style="color:#000; line-height: 25px; text-indent: 30px;">
                                                    หากท่านมีคำถามเพิ่มเติม สามารถ Reply อีเมลนี่ หรือ ส่งอีเมลมาที่ <a href="mailto:contact@pt-cad.com">contact@pt-cad.com</a> โดยระบุ Ticket ID: <strong style="color: #118a00;">{{ $data->ticket->code}}</strong> ให้กับเจ้าหน้าที่ของเรา เพื่อความสะดวกและรวดเร็วในการให้บริการ ทีมงานของเรายินดีให้บริการ
                                                </td>
                                            </tr>
											<tr>
                                                <td style="color:#000; line-height: 25px;">
													<br><strong>เวลาทำการ สำนักงานใหญ่: </strong> วันจันทร์ - วันศุกร์ เวลา 09:00 - 17:00 น.
                                                </td>
                                            </tr>
											<tr>
                                                <td style="color:#000;">
													<br><br>
													<p style="color:#000;">ขอขอบคุณที่ให้ความไว้วางใจเรา</p>
													<p style="color:#000;"><strong>ทีมงานฝ่ายบริการลูกค้า {{ $data->setting_nameWeb }}</strong></p>
													<p style="color:#000;"><a href="https://pt-cad.com" target="_blank">pt-cad.com</a></p>
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
