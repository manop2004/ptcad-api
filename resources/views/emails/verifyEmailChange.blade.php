<!DOCTYPE html>
<html lang="th">
<head><meta charset="utf-8"></head>
<body style="margin:0;padding:0;background:#f4f6fb;font-family:Arial, sans-serif;">
    <div style="max-width:520px;margin:40px auto;background:#ffffff;border-radius:10px;padding:32px;">
        <div style="text-align:center;margin-bottom:24px;">
            <img src="{{ asset('/storage/setting/' . (\App\Models\TbSetting::first()->setting_logoWeb ?? '')) }}" style="max-width:160px;">
        </div>
        @php $isRegister = ($data['context'] ?? 'change') === 'register'; @endphp

<h2 style="color:#12358f;font-size:20px;">{{ $isRegister ? 'ยืนยันการสมัครสมาชิก' : 'ยืนยันการเปลี่ยนอีเมล' }}</h2>
<p style="color:#344054;font-size:14px;line-height:1.6;">
    สวัสดีครับ/ค่ะ {{ $data['displayname'] ?? '' }}<br><br>
    @if($isRegister)
        ขอบคุณที่สมัครสมาชิกกับเรา กรุณากดปุ่มด้านล่างเพื่อยืนยันอีเมล <strong>{{ $data['new_email'] }}</strong> ก่อนเริ่มใช้งาน ลิงก์นี้จะหมดอายุภายใน 24 ชั่วโมง
    @else
        เราได้รับคำขอเปลี่ยนอีเมลบัญชีของคุณเป็น <strong>{{ $data['new_email'] }}</strong><br>
        กรุณากดปุ่มด้านล่างเพื่อยืนยันการเปลี่ยนอีเมลนี้ ลิงก์นี้จะหมดอายุภายใน 24 ชั่วโมง
    @endif
</p>
        <div style="text-align:center;margin:28px 0;">
    <a href="{{ $data['verify_url'] }}" style="background:#1765ff;color:#fff;text-decoration:none;padding:12px 28px;border-radius:8px;font-weight:600;display:inline-block;">{{ $isRegister ? 'ยืนยันอีเมล' : 'ยืนยันการเปลี่ยนอีเมล' }}</a>
</div>
<p style="color:#98a2b3;font-size:12px;">
    @if($isRegister)
        ถ้าคุณไม่ได้เป็นคนสมัครสมาชิกนี้ ไม่ต้องดำเนินการใดๆ
    @else
        ถ้าคุณไม่ได้เป็นคนขอเปลี่ยนอีเมลนี้ ไม่ต้องดำเนินการใดๆ อีเมลเดิมของคุณจะยังใช้งานได้ตามปกติ
    @endif
</p>
    </div>
</body>
</html>