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
.acct-card table{border-color:var(--line)}

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
        <h1>เลขที่ใบเสนอราคา {{ $quotation->quotationNumber }}</h1>
    </section>

    <div class="acct-portal">
        @include('layouts.fontend.account_sidebar')

        <div class="acct-main">
            <section class="acct-card">
                <div class="row ba-qu-de">
                    <div class="col-md-12">
                        <table class="table table-striped ">
                            <thead>
                                <tr>
                                    <th>รายการสินค้า</th>
                                    <th style="width: 150px;" class="text-right">ราคาสินค้า</th>
                                    <th style="width:120px;" class="text-right">จำนวนสินค้า</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <b>SKU ::</b> {{ $quotation->productSku }}<br/>
                                        {{ $quotation->productName }}
                                        @if (!empty($quotation->productDetail))
                                            @if ($quotation->productDetail != 'null')
                                                {{ $quotation->productDetail }}
                                            @endif
                                        @endif
                                    </td>
                                    <td class="text-right">{{ $quotation->productUnit }}</td>
                                    <td class="text-right">
                                        @if (!empty($quotation->productPricesale))
                                            {{ number_format($quotation->productPricesale,2) }}
                                        @else
                                            {{ number_format($quotation->productPrice,2) }}
                                        @endif
                                    </td>
                                </tr>
                                @if (!empty($quotation->message))
                                <tr>
                                    <td colspan="3">
                                        <small>Note. {{ $quotation->message }}</small>
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                        <br/>
                        @if(!empty($quotation->history_quotations))
                            @foreach ($quotation->history_quotations as $file)
                            <a href="{{ asset('storage/pdfQuotation/'.$file->name_file) }}" download="">
                                <i class="icon-caret-right" style="top:4px;"></i> ดาวน์โหลดเอกสาร PDF
                            </a>
                            @endforeach
                        @endif
                        <div class="clearfix"></div>
                        <p></p>
                        <div >
                            <b>หมายเหตุ</b>
                            <ul class="quotation">
                                @if(!empty($quotation->quotationDateExp))
                                    <li>หากคุณต้องการสั่งซื้อสินค้าตามรายการในใบเสนอราคา คุณต้องทำการสั่งซื้อภายในวันที่ {{ $quotation->quotationDateExp }} เท่านั้น</li>
                                @endif
                                @if(!empty($quotation->quotationNumber) && !empty($quotation->quotationDateExp))
                                    <li>หลังจากใบเสนอราคาหมดอายุ จะไม่สามารถใช้ใบเสนอราคาเลขที่ {{ $quotation->quotationNumber }} นี้ได้อีก</li>
                                @endif
                                @if(!empty($quotation->quotationNumber))
                                    <li>วันที่ทำการขอใบเสนอราคาเลขที่ {{ $quotation->quotationNumber }} / {{ $quotation->created_at }}</li>
                                @endif
                                @if(empty($quotation->quotationDateExp))
                                    <li>ให้ติดต่อกลับ</li>
                                @endif
                            </ul>
                        </div>
                        <div class="clearfix"></div>
                        <p></p>
                        @if(!empty($quotation->quotationDateExp))
                            @if ($dateExp != 2)
                                <h3 class="text-danger center">ใบเสนอราคาของคุณหมดอายุแล้ว</h3>
                            @endif
                        @endif
                    </div>
                    <div class="col-md-12">
                        <hr/>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('fronend.account.quotation') }}" class="loadding btn btn-block button button-3d button-rounded button-red">
                            <span class="c-white">ย้อนกลับ</span>
                        </a>
                    </div>
                    <div class="col-md-6"></div>
                    <div class="col-md-3"></div>
                </div>
            </section>
        </div>
    </div>

</div>

@endsection