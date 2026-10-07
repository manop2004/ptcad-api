@extends('layouts.temp_user')

@section('title'){{ $og_title }} |@endsection
@section('og_site_name'){{ $og_site_name }}@endsection
@section('og_keywords'){{ $og_keywords }}@endsection
@section('og_title'){{ $og_title }}@endsection
@section('og_description'){{ $og_description }}@endsection
@section('og_url'){{ $og_url }}@endsection
@section('og_image'){{ $og_image }}@endsection

@section('css')
@php
    $countB = App\Models\TbBanner::select('banner_show')->where('banner_show',1)->count();
@endphp
@if($countB == 1)
<style>
    .flex-direction-nav{
        display: none !important;
    }
</style>
@endif

<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Noto+Sans+Thai:wght@400;500;600;700;800&display=swap');

.acct-wrap{
  --navy:#12358f; --blue:#1765ff; --ink:#0b1f4d; --muted:#667085; --line:#e6edf8;
  --soft:#f6f9ff; --red:#ef4444; --shadow:0 18px 50px rgba(20,53,143,.10);
  font-family:'Poppins','Noto Sans Thai',system-ui,sans-serif; color:var(--ink);
}
.acct-wrap *{box-sizing:border-box}
.acct-wrap a{text-decoration:none;color:inherit}

.acct-hero{padding:48px 8px;background:linear-gradient(105deg,#ffffff 0%,#f4f9ff 60%,#e4f3ff 100%);border-radius:24px;margin-bottom:28px}
.acct-hero .eyebrow{display:inline-flex;align-items:center;gap:8px;color:var(--blue);font-weight:800;font-size:13px;margin-bottom:10px}
.acct-hero h1{font-size:34px;margin:0 0 8px;color:var(--navy);letter-spacing:-1px}
.acct-hero p{margin:0;color:var(--muted);font-size:15px;max-width:640px;line-height:1.6}

.acct-portal{display:grid;grid-template-columns:270px 1fr;gap:26px}
.acct-side{position:sticky;top:100px;align-self:start;border:1px solid var(--line);border-radius:22px;background:#fff;box-shadow:0 12px 34px rgba(20,53,143,.055);padding:14px}
.acct-side a{height:46px;border-radius:14px;display:flex;align-items:center;gap:12px;padding:0 14px;color:#344054;font-weight:700;font-size:14px}
.acct-side a img{width:18px;height:18px;object-fit:contain}
.acct-side a:hover,.acct-side a.active{background:#eef6ff;color:var(--blue)}
.acct-side a.signout{color:var(--red)}

.acct-main{display:grid;gap:24px}
.acct-card{background:#fff;border:1px solid var(--line);border-radius:24px;padding:26px;box-shadow:0 12px 34px rgba(20,53,143,.055)}
.acct-quo{border:1px solid var(--line);border-radius:16px;padding:16px 18px;margin-bottom:12px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px}
.acct-quo strong{color:#102b76}
.acct-quo h4{margin:0;color:var(--blue)}
.acct-empty{color:var(--muted);font-size:14px;padding:20px 0}

@media (max-width:1000px){
  .acct-portal{grid-template-columns:1fr}
  .acct-side{position:relative;top:0;display:grid;grid-template-columns:repeat(3,1fr)}
}
@media (max-width:640px){
  .acct-side{grid-template-columns:1fr 1fr}
}
</style>
@endsection

@section('content')

<div class="acct-wrap" style="width:100%;padding:0 28px">

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
    @endif

    <section class="acct-hero">
        <div class="eyebrow"><i data-lucide="file-text" size="16"></i> MY PTCAD</div>
        <h1>ใบเสนอราคา</h1>
        <p>ประวัติการขอใบเสนอราคาทั้งหมดของคุณ</p>
    </section>

    <div class="acct-portal">
        @include('layouts.fontend.account_sidebar')

        <div class="acct-main">
            <section class="acct-card">
                @if(count($data) != 0)
                    @foreach ($data as $quotation )
                        <div class="acct-quo">
                            <div>
                                <a class="text-underline" href="{{ route('fronend.account.quotation.detail',$quotation->id) }}">
                                    <strong>เลขที่ขอใบเสนอราคา : {{ $quotation->quotationNumber }}</strong>
                                </a>
                                @if(!empty($quotation->quotationDate))
                                    <br/>
                                    <small>วันที่สร้างคำขอ :: {{ date("d-m-Y",strtotime($quotation->quotationDate)) }}</small>
                                @endif
                                @if(!empty($quotation->quotationDateExp))
                                    <br/>
                                    <small>วันที่หมดอายุ :: {{ date("d-m-Y",strtotime($quotation->quotationDateExp)) }}</small>
                                @endif
                            </div>
                            <h4>{{ number_format($quotation->productTotal,2) }}</h4>
                        </div>
                    @endforeach
                    <div style="margin-top:18px">{!! $data->links() !!}</div>
                @else
                    <p class="acct-empty">ยังไม่มีข้อมูล</p>
                @endif
            </section>
        </div>
    </div>

</div>

@endsection