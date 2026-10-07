@extends('layouts.temp_user')

@section('title'){{ $og_title }} |@endsection
@section('og_site_name'){{ $og_site_name }}@endsection
@section('og_keywords'){{ $og_keywords }}@endsection
@section('og_title'){{ $og_title }}@endsection
@section('og_description'){{ $og_description }}@endsection
@section('og_url'){{ $og_url }}@endsection
@section('og_image'){{ $og_image }}@endsection

@section('css')
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Noto+Sans+Thai:wght@400;500;600;700;800&display=swap');
.acct-wrap{
  font-family:'Poppins','Noto Sans Thai',system-ui,sans-serif;
  color:#0b1f4d;
  width: 100% !important;
  max-width: 700px !important;
  margin: 40px auto 60px auto !important;
  padding: 0 16px !important;
  box-sizing: border-box !important;
}
.acct-wrap *{box-sizing:border-box}
.sent-card{
  background:#fff;border:1px solid #e6edf8;border-radius:24px;padding:48px 32px;text-align:center;
  box-shadow:0 12px 34px rgba(20,53,143,.08);
}
.sent-icon{
  width:72px;height:72px;border-radius:50%;background:#eafff3;color:#0f9d58;
  display:flex;align-items:center;justify-content:center;margin:0 auto 20px;
}
.sent-card h1{font-size:24px;margin:0 0 12px;color:#102b76}
.sent-card p{color:#667085;font-size:14.5px;line-height:1.7;margin:0 0 28px}
.sent-card a.sent-btn{
  display:inline-flex;align-items:center;justify-content:center;gap:8px;
  height:48px;padding:0 32px;border-radius:12px;
  background:linear-gradient(135deg,#1765ff,#0d57df);color:#fff;font-weight:800;font-size:15px;
  text-decoration:none;box-shadow:0 12px 24px rgba(23,101,255,.24);
}
</style>
@endsection

@section('content')

<div class="acct-wrap">
    <div class="sent-card">
        <div class="sent-icon">
            <i data-lucide="mail-check" size="34"></i>
        </div>
        <h1>ส่งอีเมลสำเร็จ!</h1>
        <p>
            เราได้ส่งลิงก์สำหรับตั้งรหัสผ่านใหม่ไปที่อีเมลของคุณแล้ว<br>
            กรุณาตรวจสอบกล่องจดหมาย (รวมถึงกล่อง Junk/Spam หากไม่พบในกล่องหลัก)
        </p>
        <a href="{{ route('fronend.account') }}" class="sent-btn">
            <i data-lucide="arrow-left" size="16"></i> กลับไปหน้าบัญชีผู้ใช้
        </a>
    </div>
</div>

@endsection