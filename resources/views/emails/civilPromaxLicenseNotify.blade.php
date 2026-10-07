<div bgcolor="#EFEFEF" text="#808080" style="margin:0px;background-color:#eef5fb;font-family:'DB Heavent','Noto Sans Thai',Arial,sans-serif;line-height:100%;font-size:16px;color:#20324a;padding:0px">

<table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background:#eef5fb;padding:26px 10px;">
<tr><td align="center">
<table role="presentation" width="640" cellspacing="0" cellpadding="0" border="0" style="width:100%;max-width:640px;background:#ffffff;border-radius:24px;overflow:hidden;box-shadow:0 18px 50px rgba(50,83,126,.12);">

<tr><td style="padding:34px 32px 26px;text-align:center;background:linear-gradient(135deg,#f7fbff,#e7f2ff);border-bottom:1px solid #dfebf7;">
@if(!empty($data->setting_logoWeb))
<img src="{{ asset('storage/setting/'.$data->setting_logoWeb) }}" width="82" alt="{{ $data->setting_nameWeb }}" style="display:block;margin:0 auto 12px;width:82px;height:auto;">
@endif
<div style="font-size:18px;font-weight:700;color:#295db7;letter-spacing:.2px;">ใช้งานง่าย · คุ้มค่า · พร้อมช่วยเหลือ</div>
</td></tr>

<tr><td style="padding:34px 36px 10px;font-size:18px;line-height:1.68;text-align:center;">
<span style="display:inline-block;background:#e8f7ee;color:#20b26b;font-weight:700;font-size:15px;padding:10px 24px;border-radius:20px;">✓ License พร้อมใช้งานแล้ว</span>
</td></tr>

<tr><td style="padding:10px 36px 10px;font-size:18px;line-height:1.68;">
<p style="margin:0 0 10px;font-weight:700;color:#14243c;">เรียนคุณ {{ $data->customerName }}</p>
<p style="margin:0 0 16px;">ขอบคุณที่เลือกใช้ผลิตภัณฑ์ของ Civil ProMax ค่ะ ทีมงานได้จัดเตรียม License สำหรับท่านเรียบร้อยแล้ว โดยมีรายละเอียดดังต่อไปนี้</p>
</td></tr>

@foreach($data->createdItems as $item)
<tr><td style="padding:6px 36px 4px;">
<table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background:#f4f8fd;border:1px solid #e3edf8;border-radius:18px;">
<tr><td style="padding:22px 22px 8px;font-size:20px;font-weight:700;color:#17396f;">{{ $item['product_name'] }}</td></tr>
<tr><td style="padding:0 22px 22px;">
<table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="font-size:16px;line-height:1.55;color:#3f5169;">
@php
    $licenseTypeLabel = match(true) {
        str_ends_with($item['product_sku'] ?? '', '-3M') => 'Subscription — เช่าใช้ราย 3 เดือน',
        str_ends_with($item['product_sku'] ?? '', '-6M') => 'Subscription — เช่าใช้ราย 6 เดือน',
        str_ends_with($item['product_sku'] ?? '', '-1Y') => 'Subscription — เช่าใช้รายปี',
        default => 'Subscription',
    };
@endphp
<tr><td width="35%" valign="top" style="padding:7px 12px 7px 0;">✓ ประเภท License</td><td valign="top" style="padding:7px 0;">{{ $licenseTypeLabel }}</td></tr>
@foreach($item['keys'] as $key)
<tr><td width="35%" valign="top" style="padding:7px 12px 7px 0;">✓ License Key</td><td valign="top" style="padding:7px 0;font-family:monospace;font-weight:700;color:#295db7;">{{ $key }}</td></tr>
@endforeach
</table>
</td></tr></table>
</td></tr>
@endforeach

<tr><td style="padding:28px 36px 8px;font-size:18px;line-height:1.65;">
<p style="margin:0 0 18px;">คุณสามารถเข้าใช้งาน Civil ProMax ได้ทันทีผ่านลิงก์ด้านล่างนี้</p>
<table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center"><tr>
<td style="padding:5px;"><a href="https://www.civilpromax.com/" style="display:inline-block;background:linear-gradient(135deg,#2454b7,#5895f6);color:#ffffff;text-decoration:none;font-weight:700;padding:13px 22px;border-radius:12px;">เข้าใช้งาน Civil ProMax</a></td>
</tr></table>
</td></tr>

<tr><td style="padding:24px 36px 36px;font-size:18px;line-height:1.65;">
<p style="margin:0 0 16px;">หากท่านมีคำถามเกี่ยวกับการติดตั้งหรือ Activate License ทีม Technical Support ยินดีให้คำปรึกษาและดูแลอย่างเต็มที่ค่ะ</p>
<p style="margin:0;">ขอแสดงความนับถือ</p>
</td></tr>

<tr><td style="padding:18px 30px;text-align:center;background:#f4f8fd;color:#8292a8;font-size:13px;">{{ $data->setting_nameWeb }} — ใช้งานง่าย · คุ้มค่า · พร้อมช่วยเหลือ</td></tr>

</table>
</td></tr></table>

</div>