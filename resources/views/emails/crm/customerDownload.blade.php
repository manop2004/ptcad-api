<table width="780" border="0" align="center" cellpadding="0" cellspacing="0" style="border:2px solid #CCCCCC;">
    <tr>
        <td valign="top">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td bgcolor="#EEEEEE"><a href="#"><img style="width:100%" src="{{ asset('onepages/8baht-email-header3.jpg') }}"></a></td>
                </tr>
                <tr>
                    <td bgcolor="#EEEEEE">
                        <table width="700" border="0" align="center" cellpadding="5" cellspacing="5" style=" background:#EEEEEE;-webkit-border-radius: 10px; -moz-border-radius: 10px; border-radius: 10px;">
                            <tr>
                                <td>
                                    <div style="background:#EEEEEE; padding:20px;">
                                        <b>เรียนคุณ {{ $data->name }}</b>
                                        @if(!empty($data->detail_th ))<p><strong>{{ $data->detail_th }}</strong></p>@endif
                                        @if(!empty($data->downloaddes ))<p>{{$data->downloaddes }}</p>@endif
                                        @if(!empty($data->downloadlink ))<p><a href="{{ $data->downloadlink }}">Click</a></p>@endif
                                        <p>ทางบริษัทแอพพลิแคดขอขอบคุณที่ท่านให้ความสนใจในผลิตภัณฑ์ของเรา</p>
                                        <p>ขอบคุณค่ะ</p>

                                        <br><br>

                                        <b>Dear {{ $data->name }}</b>
                                        @if(!empty($data->detail_en ))<p><strong>{{ $data->detail_en }}</strong></p>@endif
                                        @if(!empty($data->downloaddes ))<p>{{$data->downloaddes }}</p>@endif
                                        @if(!empty($data->downloadlink ))<p><a href="{{ $data->downloadlink }}">Click</a></p>@endif
                                        <p>AppliCAD would like to thank you for your interest in our products.</p>
                                        <p>Thank You very much.</p>

                                        <p><hr></p>
                                        <p><strong>phpstack-1646968-6541058.cloudwaysapps.com</strong> power by Applicad Public Company Limited<br>
                                            DESIGN & ENGINEERING INNOVATION STORE <br>ศูนย์รวม IT ด้านงานออกแบบ<br>
                                            Tel. 0 2-744-9397, Fax 0 2-744-9602<br>
                                            <a href="https://phpstack-1646968-6541058.cloudwaysapps.com">www.8baht.com</a> <br>
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td bgcolor="#EEEEEE">&nbsp;</td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<div align="center"><p style="font-size:12px;">* This email was sent automatically from system. You can not reply to this email.</p></div>
