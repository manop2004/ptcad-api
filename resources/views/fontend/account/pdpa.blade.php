@extends('layouts.temp_user')

@section('title'){{ $og_title }} | @endsection
@section('og_site_name'){{ $og_site_name }}@endsection
@section('og_keywords'){{ $og_keywords }}@endsection
@section('og_title'){{ $og_title }}@endsection
@section('og_description'){{ $og_description }}@endsection
@section('og_url'){{ $og_url }}@endsection
@section('og_image'){{ $og_image }}@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('assets/fontend/css/components/radio-checkbox.css') }}" type="text/css" />
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Noto+Sans+Thai:wght@400;500;600;700;800&display=swap');
button[type="submit"]{margin:0 !important}

.acct-wrap{
  --navy:#12358f; --blue:#1765ff; --ink:#0b1f4d; --muted:#667085; --line:#e6edf8;
  --soft:#f6f9ff; --red:#ef4444; --shadow:0 18px 50px rgba(20,53,143,.10);
  font-family:'Poppins','Noto Sans Thai',system-ui,sans-serif; color:var(--ink);
  width: 100% !important;
  max-width: 1320px !important;
  margin: 0 auto 60px auto !important;
  padding: 0 16px !important;
  box-sizing: border-box !important;
  overflow-x: hidden !important;
}
.acct-wrap *{box-sizing:border-box}
.acct-wrap a{text-decoration:none;color:inherit}

/* จัดส่วนหัวให้อยู่ตรงกลาง */
.acct-hero{
  padding:48px 24px;
  background:linear-gradient(105deg,#ffffff 0%,#f4f9ff 60%,#e4f3ff 100%);
  border-radius:24px;
  margin-bottom:28px;
  text-align: center !important;
  display: flex !important;
  flex-direction: column !important;
  align-items: center !important;
  justify-content: center !important;
}
.acct-hero .eyebrow{
  display:inline-flex;
  align-items:center;
  justify-content:center;
  gap:8px;
  color:var(--blue);
  font-weight:800;
  font-size:13px;
  margin-bottom:10px;
  width: 100%;
}
.acct-hero h1{
  font-size:34px;
  margin:0 0 8px;
  color:var(--navy);
  letter-spacing:-1px;
  text-align: center !important;
  width: 100%;
}
.acct-hero p{
  margin:0 auto !important;
  color:var(--muted);
  font-size:15px;
  max-width:640px;
  line-height:1.6;
  text-align: center !important;
  width: 100%;
}

/* จัด Breadcrumb ให้อยู่ตรงกลาง */
#page-title.page-title-center-custom {
  text-align: center !important;
  margin-bottom: 15px;
}
#page-title.page-title-center-custom .breadcrumb {
  display: inline-flex !important;
  justify-content: center !important;
  float: none !important;
  margin: 0 auto !important;
  padding: 0 !important;
  background: transparent !important;
}

.acct-portal{display:grid;grid-template-columns:270px 1fr;gap:26px}
.acct-side{position:sticky;top:100px;align-self:start;border:1px solid var(--line);border-radius:22px;background:#fff;box-shadow:0 12px 34px rgba(20,53,143,.055);padding:14px}
.acct-side a{height:46px;border-radius:14px;display:flex;align-items:center;gap:12px;padding:0 14px;color:#344054;font-weight:700;font-size:14px}
.acct-side a img{width:18px;height:18px;object-fit:contain}
.acct-side a:hover,.acct-side a.active{background:#eef6ff;color:var(--blue)}
.acct-side a.signout{color:var(--red)}

/* เปลี่ยนสี checkbox ตอนติ๊ก จากเขียวเดิม เป็นน้ำเงินธีม PTCAD */
.acct-check-item input.checkbox-style:checked,
.acct-check-item input.checkbox-style:checked + label:before,
.acct-check-item input.checkbox-style:checked + label:after,
.acct-check-item .checkbox-style:checked ~ .checkbox-style-3-label:before,
.acct-check-item .checkbox-style:checked ~ .checkbox-style-3-label:after,
.acct-check-item input.checkbox-style:checked + .checkbox-style-3-label:before{
    background-color:#1765ff !important;
    border-color:#1765ff !important;
}
.acct-check-item input.checkbox-style{
    accent-color:#1765ff !important;
}

.acct-main{display:grid;gap:24px;width:100%}
.acct-card{background:#fff;border:1px solid var(--line);border-radius:24px;padding:32px;box-shadow:0 12px 34px rgba(20,53,143,.055)}

/* หัวข้อย่อยของการ์ด */
.acct-subhead{display:flex;align-items:center;gap:10px;margin:0 0 20px;padding-bottom:14px;border-bottom:1px solid var(--line)}
.acct-subhead .ico{width:34px;height:34px;border-radius:10px;background:#eef6ff;color:var(--blue);display:grid;place-items:center;flex:none}
.acct-subhead.danger-subhead .ico{background:#fff1f1;color:var(--red)}
.acct-subhead span{font-weight:800;font-size:15px;color:#102b76}
.acct-subhead.danger-subhead span{color:#851818}

/* ปรับปรุงกล่อง Checkbox */
.acct-check-list{display:grid;gap:14px;margin-bottom:24px}
.acct-check-item{display:flex;align-items:flex-start;gap:10px}
.acct-check-item input[type="checkbox"]{margin-top:4px}
.acct-check-item label{color:#344054;font-size:14px;font-weight:600;cursor:pointer;line-height:1.5}

/* กล่องแจ้งเตือนการยกเลิกบัญชี */
.acct-warning-box{
  background:#fff5f5;border:1px solid #fee2e2;border-radius:16px;padding:20px;
  color:#667085;font-size:14.5px;line-height:1.6;margin-bottom:24px;
}
.acct-warning-box strong{color:#b42318}
.acct-warning-box a{color:var(--blue);font-weight:700;text-decoration:underline}

/* ปุ่มต่าง ๆ */
.acct-card button[type="submit"],
.acct-card input[type="submit"],
.acct-card .btn-save{
  height:46px !important;padding:0 32px !important;border-radius:12px !important;border:none !important;
  background:linear-gradient(135deg,var(--blue),#0d57df) !important;color:#fff !important;
  font-weight:800 !important;font-size:15px !important;cursor:pointer;
  box-shadow:0 12px 24px rgba(23,101,255,.24);transition:.15s ease;
  display:inline-flex;align-items:center;justify-content:center;gap:8px;
}
.acct-card button[type="submit"]:hover,
.acct-card input[type="submit"]:hover,
.acct-card .btn-save:hover{
  transform:translateY(-2px);box-shadow:0 16px 30px rgba(23,101,255,.30);
}

/* ปุ่มลบบัญชีพิเศษสีแดง */
.acct-card .btn-danger-action,
.acct-card button.btn-danger-action{
  background:linear-gradient(135deg,var(--red),#dc2626) !important;
  box-shadow:0 12px 24px rgba(239,68,68,.24) !important;
}
.acct-card .btn-danger-action:hover,
.acct-card button.btn-danger-action:hover{
  box-shadow:0 16px 30px rgba(239,68,68,.34) !important;
}

@media (max-width:1000px){
  .acct-portal{grid-template-columns:1fr}
  .acct-side{position:relative;top:0;display:grid;grid-template-columns:repeat(3,1fr)}
  .acct-card{padding:22px}
}
@media (max-width:640px){
  .acct-side{grid-template-columns:1fr 1fr}
}
</style>
@endsection

@section('content')

<div class="acct-wrap" style="width:100%;padding:0 28px">

    @if (!empty($breadcrumb))
    <section id="page-title" class="page-title-mini page-title-center-custom">
        <div class="clearfix">
            <ol class="breadcrumb">
                @foreach ($breadcrumb as $index => $item)
                    @if($index !== count($breadcrumb) - 1)
                        <li><a href="{{ $item['route'] }}">{{ $item['name'] }}</a></li>
                    @else
                        <li class="active">{{ $item['name'] }}</li>
                    @endif
                @endforeach
            </ol>
        </div>
    </section>
    @endif

    <section class="acct-hero">
        <div class="eyebrow"><i data-lucide="mail" size="16"></i> MY PTCAD</div>
        <h1>รับข้อมูลข่าวสารและบัญชี</h1>
        <p>เลือกประเภทข้อมูลที่ต้องการรับทางอีเมล หรือจัดการการยกเลิกบัญชีผู้ใช้ของคุณ</p>
    </section>

    <div class="acct-portal">
        @include('layouts.fontend.account_sidebar')

        <div class="acct-main">
            
            {{-- ส่วนที่ 1: รับข้อมูลข่าวสาร (PDPA Consents) --}}
            <section class="acct-card">
                {!! Form::model($user, [
                    'novalidate',
                    'route' => ['fronend.account.consent.update', $user->id],
                    'class' => ($errors->any()) ? 'was-validated form-horizontal' : 'needs-validation form-horizontal',
                    'id' => 'user-form',
                    'method' => 'put',
                    'files' => true
                ]) !!}
                
                    <div class="acct-subhead">
                        <span class="ico"><i data-lucide="mail" size="16"></i></span>
                        <span>รับข้อมูลข่าวสาร</span>
                    </div>

                    <div class="acct-check-list">
                        <div class="acct-check-item">
                            <input id="pdpa_news" class="checkbox-style" name="pdpa_news" type="checkbox" value="1" @if(!empty($user->pdpa_news) && $user->pdpa_news == 1) checked @endif>
                            <label for="pdpa_news" class="checkbox-style-3-label">รับข้อมูลข่าวสารและประชาสัมพันธ์ทางอีเมล</label>
                        </div>
                        
                        <div class="acct-check-item">
                            <input id="pdpa_article" class="checkbox-style" name="pdpa_article" type="checkbox" value="1" @if(!empty($user->pdpa_article) && $user->pdpa_article == 1) checked @endif>
                            <label for="pdpa_article" class="checkbox-style-3-label">รับข้อมูลบทความ สาระความรู้จากเราทางอีเมล</label>
                        </div>
                        
                        <div class="acct-check-item">
                            <input id="pdpa_product" class="checkbox-style" name="pdpa_product" type="checkbox" value="1" @if(!empty($user->pdpa_product) && $user->pdpa_product == 1) checked @endif>
                            <label for="pdpa_product" class="checkbox-style-3-label">รับข้อมูลข่าวสารผลิตภัณฑ์ที่เกี่ยวข้องของบริษัท</label>
                        </div>
                    </div>

                    <div style="margin-top: 20px;">
                        @include('layouts.fontend.button.save')
                    </div>

                {!! Form::close() !!}
            </section>

            {{-- ส่วนที่ 2: ยกเลิกบัญชี (Account Termination) --}}
            <section class="acct-card">
                {!! Form::model($user, [
                    'novalidate',
                    'route' => ['fronend.account.consent.removeUser', $user->id],
                    'class' => ($errors->any()) ? 'was-validated form-horizontal' : 'needs-validation form-horizontal',
                    'id' => 'user-remove-form',
                    'method' => 'put',
                    'files' => true
                ]) !!}
                
                    <div class="acct-subhead danger-subhead">
                        <span class="ico"><i data-lucide="user-x" size="16"></i></span>
                        <span>ยกเลิกบัญชีผู้ใช้งาน</span>
                    </div>

                    <div class="acct-warning-box">
                        <i data-lucide="alert-triangle" size="18" style="color:var(--red); margin-right:5px; vertical-align:middle; display:inline-block;"></i>
                        เมื่อคุณ <strong>"ยกเลิกบัญชีผู้ใช้"</strong> แล้ว จะถือว่าเป็นการสิ้นสุดการเป็นสมาชิกของเว็บไซต์ ptcadthailand.com ทันที 
                        <br/>
                        @if(!empty($privacyPolicy))
                            @php
                                $page_parmalink = App\Models\TbPage::where('id', $privacyPolicy->page_privacy_policy)->value('page_parmalink');
                            @endphp
                            คุณสามารถศึกษานโยบายความเป็นส่วนตัวเพิ่มเติมได้ <a href="{{ route('fronend.page.content', $page_parmalink) }}" target="_blank">ที่นี่</a>
                        @endif
                    </div>

                    <div class="btn-danger-wrapper">
                        @include('layouts.fontend.button.removeUser')
                    </div>

                {!! Form::close() !!}
            </section>
        </div>
    </div>

</div>

{{-- ===== Modal ยืนยันการยกเลิกบัญชี ===== --}}
<div id="remove-account-modal" style="display:none;position:fixed;inset:0;background:rgba(11,31,77,.55);z-index:9999;align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:16px;padding:28px;max-width:400px;width:90%;text-align:center;box-shadow:0 20px 60px rgba(0,0,0,.25);">
        <div style="width:56px;height:56px;border-radius:50%;background:#fef2f2;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
            <i data-lucide="alert-triangle" size="26" style="color:#ef4444"></i>
        </div>
        <h4 style="color:#851818;margin:0 0 10px;">ยืนยันการยกเลิกบัญชีผู้ใช้?</h4>
        <p style="color:#667085;font-size:14px;margin:0 0 22px;line-height:1.6;">
            การกระทำนี้ <strong style="color:#b42318;">ไม่สามารถย้อนกลับได้</strong><br>
            ข้อมูลบัญชีของคุณจะถูกลบออกจากระบบทันที
        </p>
        <div style="display:flex;gap:10px;justify-content:center;">
            <button type="button" id="remove-account-cancel" class="btn-cancel" style="height:46px;min-width:130px;border-radius:12px;border:1.5px solid #1765ff;background:#fff;color:#1765ff;font-weight:800;cursor:pointer;">ยกเลิก</button>
            <button type="button" id="remove-account-confirm" style="height:46px;min-width:130px;border-radius:12px;border:0;background:#ef4444;color:#fff;font-weight:800;cursor:pointer;">ยืนยันลบบัญชี</button>
        </div>
    </div>
</div>

<script>
    document.getElementById('btn-open-remove-confirm').addEventListener('click', function(){
        document.getElementById('remove-account-modal').style.display = 'flex';
    });
    document.getElementById('remove-account-cancel').addEventListener('click', function(){
        document.getElementById('remove-account-modal').style.display = 'none';
    });
    document.getElementById('remove-account-confirm').addEventListener('click', function(){
        document.getElementById('user-remove-form').submit();
    });
</script>

@endsection