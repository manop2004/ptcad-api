<div bgcolor="#EFEFEF" text="#808080" style="margin:0px;background-color:#efefef;font-family:Arial,helvetica,sans-serif;line-height:100%;font-size:16px;color:#808080;padding:0px">

    <table align="center" valign="top" style="width: 100%;">
        <tbody>
            <tr>
                <td align="center" valign="top">

                    <table align="center" valign="top" style="width: 600px; background-color:#ffffff;">
                        <tbody>
                            <tr style="background-color:#000000;">
								<td width="100%" style="background-color:#000000; width:100%; text-align:center">
									<img style="width:100%" src="{{ asset('onepages/8baht-email-header3.jpg?v=1') }}"></a>
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
                                                    <p style="color:#000; line-height: 25px;">
													ตามที่ทางฝ่ายบริการหลังการขาย ของแอพพลิแคดได้ให้บริการคุณลูกค้าที่ผ่านมา
													เพื่อเป็นการปรับปรุงและพัฒนาการให้บริการ จึงขอเรียนเชิญให้คะแนนความพึงพอใจในการในบริการดังกล่าว จากคะแนนเต็ม 10 คะแนน
													</p>
													
													<?php
														if($data->sendCustomer == 'yes'){
													?>
													<br/>
													<table width="100%" cellspacing="0" cellpadding="0" align="center">
													  <tr>
														  <td>
															  <table cellspacing="4" cellpadding="2" align="center">
																  <tr>
																		<?php
																			for($score=1; $score<=10; $score++){
																		?>
																	  <td style="border-radius: 2px;" bgcolor="#ED2939" align="center">
																		  <a href="https://phpstack-1646968-6541058.cloudwaysapps.com/help/review/<?php echo $data->ticket->secret_code; ?>/<?php echo $score; ?>" target="_blank" style="padding: 8px 12px; border: 1px solid #ED2939;border-radius: 2px;font-family: Helvetica, Arial, sans-serif;font-size: 14px; color: #ffffff;text-decoration: none;font-weight:bold;display: inline-block;">
																			  <?php echo $score; ?>
																		  </a>
																	  </td>
																		<?php
																			}
																		?>
																  </tr>
															  </table>
														  </td>
													  </tr>
													</table>
													<?php
														}
													?>
													
													<br/>
                                                    <p style="color:#000;">Ticket ID : {{ $data->ticket->code}}</p>
                                                    @if(!empty($data->ticket->program))
                                                    <p style="color:#000;">โปรแกรมที่ขอใช้บริการ : {{ $data->ticket->program}}</p>
                                                    @endif
                                                    <p style="color:#000;">รายละเอียด :</p>
                                                    <p style="color:#000;">{!! $data->ticket->message !!}</p>
													<br/>
													<p style="color:#000; line-height: 25px;">
													หากลูกค้ามีความประสงค์ต้องการสอบถามรายละเอียดเพิ่มเติม สามารถติดต่อสอบถามได้ที่ อีเมล <a href="mail:support8baht@applicadthai.com">support8baht@applicadthai.com</a>
													ทางบริษัท แอพพลิแคด ขอขอบคุณที่ลูกค้าได้ให้ความไว้วางใจให้ทางทีมงานของแอพพลิแคดรับใช้ท่านในครั้งนี้</p>
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
