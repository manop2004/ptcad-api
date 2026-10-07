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
<div style="font-size:18px;font-weight:700;color:#295db7;letter-spacing:.2px;">ทดลองใช้ฟรี 30 วัน · ไม่ยุ่งยาก · พร้อมช่วยเหลือ</div>
</td></tr>

<tr><td style="padding:34px 36px 10px;font-size:18px;line-height:1.68;">
<p style="margin:0 0 10px;font-weight:700;color:#14243c;">เรียน คุณ{{ $data->firstname }} {{ $data->lastname }}</p>
<p style="margin:0 0 16px;">ขอบคุณที่สนใจทดลองใช้งาน {{ $data->editionLabel }} ฟรี 30 วัน ทางเราได้เตรียมลิงก์ดาวน์โหลดโปรแกรมให้ท่านเรียบร้อยแล้ว ตามรายละเอียดด้านล่างนี้</p>
</td></tr>

<tr><td style="padding:6px 36px 4px;">
<table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background:#f4f8fd;border:1px solid #e3edf8;border-radius:18px;">
<tr><td style="padding:22px 22px 18px;">
<div style="font-size:20px;font-weight:700;color:#17396f;margin-bottom:6px;">{{ $data->editionLabel }}</div>
<div style="font-size:15px;color:#52647c;">สิทธิ์ทดลองใช้งานจะหมดอายุวันที่ :: <strong style="color:#3f5169;">{{ $data->trialExpireAt }}</strong></div>
</td></tr>
</table>
</td></tr>

<tr><td style="padding:28px 36px 8px;font-size:18px;line-height:1.65;">
<table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center"><tr>
<td style="padding:5px;"><a href="{{ $data->downloadLink }}" style="display:inline-block;background:linear-gradient(135deg,#2454b7,#5895f6);color:#ffffff;text-decoration:none;font-weight:700;padding:14px 28px;border-radius:12px;font-size:17px;">ดาวน์โหลดโปรแกรม</a></td>
</tr></table>
</td></tr>

<tr><td style="padding:24px 36px 36px;font-size:18px;line-height:1.65;">
<p style="margin:0 0 16px;">หากพบปัญหาในการดาวน์โหลดหรือติดตั้ง หรือมีข้อสงสัยเกี่ยวกับการใช้งาน ทีมงานยินดีให้คำปรึกษาค่ะ</p>
<p style="margin:0;">ขอแสดงความนับถือ</p>
</td></tr>

<tr><td style="padding:18px 30px;text-align:center;background:#f4f8fd;color:#8292a8;font-size:13px;">{{ $data->setting_nameWeb }} — ใช้งานง่าย · คุ้มค่า · พร้อมช่วยเหลือ</td></tr>

</table>
</td></tr></table>
</body></html>