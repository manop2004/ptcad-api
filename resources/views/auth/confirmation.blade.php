@extends('layouts.temp_user')

@section('title'){{ $og_title }} |@endsection
@section('og_site_name'){{ $og_site_name }}@endsection
@section('og_keywords'){{ $og_keywords }}@endsection
@section('og_title'){{ $og_title }}@endsection
@section('og_description'){{ $og_description }}@endsection
@section('og_url'){{ $og_url }}@endsection
@section('og_image'){{ $og_image }}@endsection

@section('css')
<link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendor/select2-bootstrap4-theme/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/fontend/css/components/radio-checkbox.css') }}" type="text/css" />
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Noto+Sans+Thai:wght@400;500;600;700;800&display=swap');

.conf-wrap{
  --navy:#12358f; --blue:#1765ff; --ink:#0b1f4d; --muted:#667085; --line:#e6edf8;
  --soft:#f6f9ff; --green:#20b26b; --red:#ef4444; --shadow:0 18px 50px rgba(20,53,143,.10);
  font-family:'Poppins','Noto Sans Thai',system-ui,sans-serif; color:var(--ink);
  width:100%; padding:48px 24px;
}
.conf-wrap *{box-sizing:border-box}
.conf-wrap a{text-decoration:none}

.conf-card{
  max-width:520px; margin:0 auto; background:#fff; border:1px solid var(--line); border-radius:24px;
  box-shadow:var(--shadow); padding:48px 40px; text-align:center;
}
.conf-icon{
  width:88px; height:88px; border-radius:50%; display:grid; place-items:center; margin:0 auto 24px;
}
/* แก้ไขจุดนี้: บังคับให้ไอคอนภายในเป็นสีน้ำเงิน (var(--blue)) */
.conf-icon.success{
  background:#eaf2ff; 
  color:var(--blue) !important;
}
.conf-icon.success svg,
.conf-icon.success [data-lucide]{
  color:var(--blue) !important;
  stroke:var(--blue) !important;
}

.conf-icon.fail{background:#fdecec; color:var(--red)}
.conf-card h3{font-size:26px; font-weight:800; margin:0 0 12px; color:var(--navy); letter-spacing:-.4px}
.conf-card p{color:var(--muted); font-size:15px; line-height:1.7; margin:0 0 28px}

.conf-btn{
  display:inline-flex; align-items:center; justify-content:center; gap:8px;
  height:48px; padding:0 32px; border-radius:12px; font-weight:800; font-size:15px;
  width:100%; max-width:340px; transition:.15s ease;
}
.conf-btn.primary{
  background:linear-gradient(135deg,var(--blue),#0d57df); color:#fff; border:none;
  box-shadow:0 12px 24px rgba(23,101,255,.24);
}
.conf-btn.primary:hover{transform:translateY(-2px); box-shadow:0 16px 30px rgba(23,101,255,.30)}
.conf-btn.danger{
  background:#fff; color:var(--red); border:1.5px solid var(--red);
}
.conf-btn.danger:hover{background:#fff5f5}

@media (max-width:640px){
  .conf-wrap{padding:32px 16px}
  .conf-card{padding:36px 24px}
  .conf-card h3{font-size:22px}
}
</style>
@endsection

@section('content')

<section id="content">
    <div class="content-wrap">
        <div class="container">
        @if (!empty($breadcrumb))
            <section id="page-title" class="page-title-mini page-title-right">
                <div class="clearfix">
                    <ol class="breadcrumb">
                        @foreach ($breadcrumb as $index => $item)
                            @if($index !== count($breadcrumb) -1 )
                                <li><a href="{{ $item['route'] }}">{{ $item['name'] }}</a></li>
                            @else
                                <li class="active">{{ $item['name'] }}</li>
                            @endif
                        @endforeach
                    </ol>
                </div>
            </section>
            <div class="clearfux"></div>
        @endif

        <div class="conf-wrap">
            <div class="conf-card">
                @if(!empty($_GET['status']))
                    <div class="conf-icon success">
                        <i data-lucide="check-circle-2" size="44"></i>
                    </div>
                    <h3>สมัครสมาชิกสำเร็จแล้ว!</h3>
                    <p>คุณสามารถเข้าสู่ระบบได้โดยใช้ชื่อผู้ใช้และรหัสผ่านที่ได้ลงทะเบียนไว้</p>
                    <a href="{{ route('login') }}"><span class="conf-btn primary"><i data-lucide="log-in" size="18"></i> เข้าสู่ระบบ</span></a>
                @else
                    <div class="conf-icon fail">
                        <i data-lucide="x-circle" size="44"></i>
                    </div>
                    <h3>สมัครสมาชิกไม่สำเร็จ!</h3>
                    <p>คุณสมัครสมาชิกไม่สำเร็จ กรุณาสมัครสมาชิกใหม่อีกครั้ง</p>
                    <a href="{{ route('register') }}"><span class="conf-btn danger"><i data-lucide="rotate-ccw" size="18"></i> สมัครสมาชิกใหม่</span></a>
                @endif
            </div>
        </div>

        </div>
    </div>
</section>

@endsection

@section('js')
<script src="{{ asset('vendor/select2/select2.min.js') }}"></script>
<script src="{{ asset('vendor/select2-bootstrap4-theme/docs/script.js') }}"></script>
<script>
    $('.select-multiple').select2();
</script>
@endsection