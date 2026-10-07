<!DOCTYPE html>
<html>
<link rel="icon" href="{{ asset('storage/setting/' . $setting->setting_logoWeb) }}" type ="image/x-icon">
<title>{{ $setting->setting_nameWeb}}</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- template css -->
<link rel="stylesheet" href="{{ asset('assets/fontend/styles/loadding.min.css') }}" type="text/css"/>
<link rel="stylesheet" href="{{ asset('assets/fontend/css/bootstrap.css') }}" type="text/css"/>
<link rel="stylesheet" href="{{ asset('assets/fontend/style.min.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/fontend/css/swiper.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/fontend/css/dark.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/fontend/css/font-icons.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/fontend/css/animate.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/fontend/css/magnific-popup.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/fontend/css/colors.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/fontend/css/responsive.css') }}" type="text/css" />
<!-- font -->
<link rel="stylesheet" href="{{ asset('assets/fonts/stylesheet.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('assets/fontend/css/fonts.css?v=11') }}" type="text/css"/>

<!-- custom css -->
<link rel="stylesheet" href="{{ asset('assets/fontend/styles/styles.min.css') }}" type="text/css"/>
<link rel="stylesheet" href="{{ asset('assets/fontend/css/custom.css?v=24') }}" type="text/css"/>
<link rel="stylesheet" href="{{ asset('assets/fontend/css/ckediter.css') }}" type="text/css"/>

<style>
    .block-crm-detail{
        max-width: 400px;
        padding: 10px;
        background: #fff;
        line-height: 1.8;
        margin: 4rem auto auto auto;
    }
</style>
<body class="stretched" style="background: #f5f5f5">
    <section id="content" style="background: none">
        <div class="block-crm-detail mg-auto">
            <br/>
            <div class="center">
                <img height="70px" loading="lazy" class="lazyload" data-src="{{ asset('storage/setting/'.$setting->setting_iconWeb) }}" alt="Logo Brand">
            </div>
            <hr/>
            <div>
                <h4 class="center">คำขอใบเสนอราคาใหม่!!</h4>
                <div><b>เลขที่:</b> {{ $quotation_notify->quotationNumber}}</div>
                <div><b>ประเภท:</b> @if($quotation_notify->type == 2)บริษัท/สำนักงาน/องค์กร @else บุคคลธรรมดา@endif</div>
                <div><b>บริษัท:</b> {{ $quotation_notify->company}}</div>
                <div><b>เลขประจำตัวผู้เสียภาษี:</b> {{ $quotation_notify->tax }}</div>
                <div><b>ชื่อ-นามสกุล:</b> {{ $quotation_notify->name}} {{$quotation_notify->lastname}}</div>
                <div><b>เบอร์โทรศัพท์:</b> {{ $quotation_notify->tel }}</div>
                <div><b>อีเมล:</b> {{ $quotation_notify->email }}</div>
                <div><b>ที่อยู่:</b> {{ $quotation_notify->address}} {{ $provinces }} {{$amphoes}} {{$district }} {{$quotation_notify->zipcode}}
                <div><b>เพิ่มเติม:</b><br/> {{$quotation_notify->message}}
                <hr/>
                <div><b>แคมเปญ :</b> ขอใบเสนอราคาผ่านเว็บ phpstack-1646968-6541058.cloudwaysapps.com</div>
                <div class="mg-left-10">
                    @if (!empty($historyquotation))
                        <a href="{{ asset('storage/pdfQuotation/'.$historyquotation) }}" download="">- ดาวน์โหลดเอกสารขอใบเสนอราคา</a>
                        <br/>
                    @endif
                    <a href="https://appcrm.applicadthai.com/m.php?module=Leads&action=DetailView&record={{$crm}}">- คลิกเพื่อดูรายละเอียดใน CRM</a>
                </div>
                <br/>
            </h4>
        </div>
    </section>

</body>

<!-- canvas js -->
<script type="text/javascript" src="{{ asset('assets/fontend/js/jquery.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/fontend/js/plugins.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/fontend/js/functions.js') }}"></script>
<!-- custom js -->
<script type="text/javascript" src="{{ asset('assets/fontend/js/custom.js?v=22') }}"></script>

</html>
