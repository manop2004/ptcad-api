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
                                                <td style="color:#000;">
                                                    <br/>
                                                    <p style="color:#000;">เรียน คุณ {{ $data->order->residence_name }} {{ $data->order->residence_lastname }}</p>
                                                    <p style="color:#000; line-height: 35px;">ทางบริษัทขอขอบพระคุณที่เลือกซื้อสินค้ากับ {{ $data->setting_nameWeb }} 💚</p>
													<p style="color:#000;">เราหวังว่าคุณจะได้รับสินค้าและประสบการณ์ที่ดีจากการซื้อสินค้ากับเรา</p>
													<br>
													<p>
														@foreach($data->products as $product)
														<table width="100%" border="0" cellpadding="10" cellspacing="0" style="border: 1px solid #ddd; border-radius: 8px;">
															<tr>
																<td align="center" width="20%">
																	<img src="{{ $product->product_img }}" width="100%" alt="{{ $product->product_name }}">
																</td>
																<td width="80%">
																	<strong>{{ $product->product_name }}</strong>
																	<p>{{ $product->detail_name }}</p>
																</td>
															</tr>
														</table>
														@endforeach
													</p>
													<br>
													<p style="color:#000;">❤️ รีวิวของคุณมีค่ายิ่ง เพื่อพัฒนาการให้บริการ และเป็นประโยชน์ต่อลูกค้าท่านอื่น</p>
													<p style="color:#000;">🙏 ขอเชิญคุณร่วมแชร์ประสบการณ์ ให้คะแนน ⭐⭐⭐⭐⭐ สินค้าและบริการ</p>
													<br>
													<p style="color:#000;">
														<center>
															<a href="https://{{ $data->setting_nameWeb }}/order/review/{{ $data->order->orderNumber }}" target="_blank" style="display: inline-block;
																								background: #4cb86e;
																								color: #ffffff;
																								padding: 12px 18px;
																								text-decoration: none;
																								font-size: 14px;
																								font-weight: bold;
																								text-align: center;
																								border-radius: 5px;
																								border: 2px solid #4cb86e;">
																📝 ให้คะแนน & รีวิวสินค้า
															</a>
														</center>
													</p>
													<br>
													<p style="color:#000;">หากคุณมีข้อเสนอแนะเพิ่มเติม หรือพบปัญหาใด ๆ</p>
													<p style="color:#000;">สามารถติดต่อทีมงานของเราได้ที่</p>
													<p style="color:#000;">Line : <a href="{{ $data->setting->setting_idLine }}" target="_blank">{{ $data->setting->setting_idLine }}</a></p>
													<p style="color:#000;">เบอร์โทร <a href="tel:{{ $data->setting->setting_telContact }}" target="_blank">{{ $data->setting->setting_telContact }}</a></p>
													<br>
													<p style="color:#000;">ขอขอบคุณอีกครั้งที่ไว้วางใจเรา</p>
													<p style="color:#000;">เราหวังว่าจะได้ให้บริการคุณอีกในอนาคตค่ะ</p>
													<br>
													<p style="color:#000;"><strong>ด้วยความเคารพ,</strong></p>
													<p style="color:#000;"><strong>ทีมงาน {{ $data->setting_nameWeb }}</strong></p>
													<p style="color:#000;">📞 <a href="tel:{{ $data->setting->setting_telContact }}" target="_blank">{{ $data->setting->setting_telContact }}</a></p>
													<p style="color:#000;">✉&nbsp;&nbsp;<a href="mailto:{{ $data->setting->setting_email_support }}" target="_blank">{{ $data->setting->setting_email_support }}</a></p>
													<p style="color:#000;">🌐 <a href="https://{{ $data->setting_nameWeb }}" target="_blank">https://{{ $data->setting_nameWeb }}</a></p>
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
