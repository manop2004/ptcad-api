<!doctype html>
<html lang="th">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>PTCAD Email</title>
</head>
<body style="margin:0;padding:0;background:#eef5fb;font-family:'DB Heavent','Noto Sans Thai',Arial,sans-serif;color:#20324a;">
<table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background:#eef5fb;padding:26px 10px;">
<tr><td align="center">
<table role="presentation" width="640" cellspacing="0" cellpadding="0" border="0" style="width:100%;max-width:640px;background:#ffffff;border-radius:24px;overflow:hidden;box-shadow:0 18px 50px rgba(50,83,126,.12);">

<tr><td style="padding:34px 32px 26px;text-align:center;background:linear-gradient(135deg,#f7fbff,#e7f2ff);border-bottom:1px solid #dfebf7;">
@if(!empty($data->setting_logoWeb))
<img src="{{ asset('storage/setting/'.$data->setting_logoWeb) }}" width="82" alt="{{ $data->setting_nameWeb }}" style="display:block;margin:0 auto 12px;width:82px;height:auto;">
@endif
<div style="font-size:18px;font-weight:700;color:#295db7;letter-spacing:.2px;">ใช้งานง่าย · คุ้มค่า · พร้อมช่วยเหลือ</div>
</td></tr>

<tr><td style="padding:34px 36px 10px;font-size:18px;line-height:1.68;">
<p style="margin:0 0 10px;font-weight:700;color:#14243c;">เรียน คุณ{{ $data->order->residence_name }} {{ $data->order->residence_lastname }}</p>
<p style="margin:0 0 16px;">ขอบคุณที่สั่งซื้อสินค้ากับ {{ $data->setting_nameWeb }} ค่ะ ทางเราได้รับคำสั่งซื้อของท่านเรียบร้อยแล้ว โดยมีรายละเอียดดังต่อไปนี้</p>
</td></tr>

<tr><td style="padding:6px 36px 4px;">
<table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background:#f4f8fd;border:1px solid #e3edf8;border-radius:18px;">
<tr><td style="padding:22px 22px 8px;font-size:20px;font-weight:700;color:#17396f;">
    หมายเลขคำสั่งซื้อ :: {{ $data->order->orderNumber }}
    <div style="display:inline-block;font-size:12px;font-weight:700;color:#20b26b;background:#e8f7ee;border-radius:20px;padding:5px 12px;margin-left:8px;vertical-align:middle;">
        {{ $data->order->tb_setting_payment_status->status_name ?? 'อัปเดตสถานะ' }}
    </div>
</td></tr>
<tr><td style="padding:0 22px 22px;">
<table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="font-size:16px;line-height:1.55;color:#3f5169;">
@foreach($data->order->tb_order_details as $detail)
<tr>
    <td valign="top" width="60" style="padding:7px 12px 7px 0;border-bottom:1px solid #e9eef5;">
    @if(!empty($detail->product_img))
    <img src="{{ $detail->product_img }}" width="50" height="50" style="border-radius:8px;object-fit:cover;display:block;">
    @endif
</td>
    <td valign="top" style="padding:7px 12px 7px 0;border-bottom:1px solid #e9eef5;">
        {{ $detail->product_name }}
        @if(!empty($detail->product_detail) && $detail->product_detail != 'null')
            <br><span style="font-size:13px;color:#8292a8;">{{ $detail->product_detail }}</span>
        @endif
    </td>
    <td valign="top" style="padding:7px 0;text-align:right;border-bottom:1px solid #e9eef5;">
        x{{ $detail->product_unit }}
    </td>
</tr>
@endforeach
</table>
</td></tr></table>
</td></tr>

<tr><td style="padding:30px 24px 8px;">
<div style="font-size:24px;font-weight:700;text-align:center;color:#172941;margin-bottom:6px;">สรุปยอดชำระเงิน</div>
<table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="padding:0 12px;font-size:16px;color:#52647c;">
@if(!empty($data->order->subtotal))
<tr><td style="padding:6px 0;">มูลค่า</td><td style="padding:6px 0;text-align:right;">{{ number_format($data->order->subtotal,2) }} บาท</td></tr>
@endif
@if(!empty($data->order->priceVAT))
<tr><td style="padding:6px 0;">ภาษีมูลค่าเพิ่ม</td><td style="padding:6px 0;text-align:right;">{{ number_format($data->order->priceVAT,2) }} บาท</td></tr>
@endif
<tr><td style="padding:6px 0;">การจัดส่ง</td><td style="padding:6px 0;text-align:right;">จัดส่งฟรี</td></tr>
<tr><td style="padding:14px 0 0;border-top:1px solid #e9eef5;font-size:19px;font-weight:700;color:#172941;">ยอดรวมสุทธิ</td><td style="padding:14px 0 0;border-top:1px solid #e9eef5;text-align:right;font-size:19px;font-weight:700;color:#3564c6;">{{ number_format($data->order->totalCart,2) }} บาท</td></tr>
</table>
</td></tr>

<tr><td style="padding:28px 36px 8px;font-size:18px;line-height:1.65;">
<table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center"><tr>
<td style="padding:5px;"><a href="{{ route('fronend.account.order.detail', $data->order->id) }}" style="display:inline-block;background:linear-gradient(135deg,#2454b7,#5895f6);color:#ffffff;text-decoration:none;font-weight:700;padding:13px 22px;border-radius:12px;">ดูรายละเอียดคำสั่งซื้อ</a></td>
</tr></table>
</td></tr>

<tr><td style="padding:24px 36px 36px;font-size:18px;line-height:1.65;">
<p style="margin:0 0 16px;">วันที่สั่งซื้อ :: {{ date("Y-m-d H:i:s", strtotime($data->order->created_at)) }}<br>
ช่องทางการชำระเงิน :: {{ $data->order->payment_type == 1 ? 'โอนผ่านบัญชีธนาคาร' : ($data->order->payment_type == 3 ? 'บัตรเครดิต' : 'พร้อมเพย์') }}</p>
<p style="margin:0 0 16px;">ขอบคุณที่ไว้วางใจใช้บริการของเรา หากมีข้อสงสัยเกี่ยวกับคำสั่งซื้อ ทีมงานยินดีให้คำปรึกษาค่ะ</p>
<p style="margin:0;">ขอแสดงความนับถือ</p>
</td></tr>

<tr><td style="padding:18px 30px;text-align:center;background:#f4f8fd;color:#8292a8;font-size:13px;">{{ $data->setting_nameWeb }} — ใช้งานง่าย · คุ้มค่า · พร้อมช่วยเหลือ</td></tr>

</table>
</td></tr></table>
</body></html>