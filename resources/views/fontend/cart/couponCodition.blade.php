<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="@if(!empty($setting->setting_iconWeb)){{ asset('storage/setting/'.$setting->setting_iconWeb) }}@endif" type ="image/x-icon">
    <link rel="shortcut icon" href="@if(!empty($setting->setting_iconWeb)){{ asset('storage/setting/'.$setting->setting_iconWeb) }}@endif" type="image/x-icon">
    <title>{{ $page_name }} | @if(!empty($setting->setting_nameWeb)){{$setting->setting_nameWeb}}@endif</title>

    <link rel="stylesheet" href="{{ asset('fonts/stylesheet.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fontend/css/fonts.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/fontend/css/bootstrap.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/fontend/style.min.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/fontend/css/swiper.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/fontend/css/dark.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/fontend/css/font-icons.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/fontend/css/animate.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/fontend/css/magnific-popup.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/fontend/css/colors.css') }}" type="text/css" />

    <link rel="stylesheet" href="{{ asset('assets/fontend/css/responsive.css') }}" type="text/css" />

    <style>
        .voucher{
            width: 100%;
            max-width: 375px;
            margin-left: auto;
            margin-right: auto;
            margin-top: 90px;
            margin-bottom: 20px;
        }
        .voucher b{
            font-size: 1.6rem;
        }
        .voucher{
            font-size: 1.4rem;
        }
        .voucher_b01f{
            background-color: #fff;
            padding: 15px;
        }
        #b_coupon{
            width: 100%;
            height: 100px;
            background-color: #fff;
            position: relative;
        }
        #b_coupon .limit{
            position: absolute;
            left: -0.5rem;
            top: 0.3125rem;
            background: #F78300;
            color: #fff;
            padding: 2px;
            font-size: 10px;
        }
        #b_coupon .limit:after {
            content: "";
            position: absolute;
            width: 9px;
            height: 9px;
            left: 1px;
            top: calc(100% + 1px);
            -webkit-transform: rotate(-45deg) translate(50%,-50%);
            transform: rotate(-45deg) translate(50%,-50%);
            border-left: 0.2rem solid #F78300;
        }
        #b_coupon .b_img{
            width: 100px;
            height: 100px;
        }
        #b_coupon .g_coupon{
            display: grid;
            grid-template-columns: 100px auto;
        }
        #b_coupon .b_dis{
            padding: 10px;
            border: 1px solid #eee;
            position: relative;
        }
        #b_coupon .b_dis .condition{
            position: absolute;
            bottom: 5px;
            right: 5px;
            font-size: 12px;
        }
        #b_coupon .b_dis small {
            font-size: 70%;
        }
        #b_coupon .b_dis .b_dis_sub{
            position: absolute;
            bottom: 5px;
            left: 10px;
        }
        ul{
            margin-left: 30px;
            margin-bottom: 10px;
        }
        .co-F78300{
            color: #F78300;
        }
    </style>
</head>
<body class="stretched" style="background: #f5f5f5">
    <section id="content" style="background: none">
        <div class="voucher">
            <div class="voucher_b01f">
                <div id="b_coupon" style="margin-top: -70px;">
                    @if (!empty($coupon->coupon_limit))
                    <div class="limit">จำกัด</div>
                    @endif
                    <div class="g_coupon">
                        @isset($coupon->coupon_img)
                            <img src="{{ asset('storage/coupon/'.$coupon->coupon_img) }}" alt="{{ $coupon->coupon_img }}" class="b_img" rel="nofollow">
                        @else
                            <img src="{{ asset('images/default-img/default-banner-900-1050.jpg')}}" alt="..." class="b_img" rel="nofollow">
                        @endisset
                        <div class="b_dis">
                            <h5 class="nomargin">{{ $coupon->coupon_name }}</h5>
                            <div class="b_dis_sub">
                                @if(!empty($coupon->min_order_amount))
                                    <small>ขั้นต่ำ {{ number_format($coupon->min_order_amount) }} บาท</small>
                                @endif
                                @if (!empty($coupon->coupon_date_exp))
                                    <br/>
                                    <small class="co-F78300">ใช้ได้ก่อน : {{ $coupon->coupon_date_exp }}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <br/>
                @if(!empty($coupon->min_order_amount))
                    <div class="col-ful pd-bottom-10">
                        <b>ยอดสั่งซื้อขั้นต่ำ</b><br/>
                        {{ number_format($coupon->min_order_amount)}} บาท
                    </div>
                @endif
                @if(!empty($coupon->max_order_amount))
                    <div class="col-full pd-bottom-10">
                        <b>ยอดสั่งซื้อสูงสุด</b><br/>
                        {{ number_format($coupon->max_order_amount)}} บาท
                    </div>
                @endif
                @if(!empty($coupon->participating_products))
                    <div class="col-full">
                        <b>เฉพาะสินค้า</b><br/>
                        <ul>
                            @php
                                $producCover = explode(",",$coupon->participating_products);
                            @endphp
                            @foreach ( $producCover as $key=> $item)
                                @php
                                    $cover = App\Models\TbProduct::select('id','pro_show','pro_name')->where('pro_show',1)->where('id',$item)->first();
                                @endphp
                                <li>{{ $cover->pro_name }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if(!empty($coupon->non_participating_products))
                    <div class="col-full">
                        <b>สินค้าที่ไม่ร่วมรายการ</b><br/>
                        <ul>
                            @php
                                $producCoverNone = explode(",",$coupon->non_participating_products);
                            @endphp
                            @foreach ( $producCoverNone as $key=> $item)
                                @php
                                    $coverNone = App\Models\TbProduct::select('id','pro_show','pro_name')->where('pro_show',1)->where('id',$item)->first();
                                @endphp
                                <li>{{ $coverNone->pro_name }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if(!empty($coupon->participating_categorie))
                    <div class="col-full pd-bottom-10">
                        <strong>เฉพาะหมวดหมู่สินค้า</strong><br/>
                        <ul class="no-mgb mg-left-20">
                            @php
                                $categoryCover = explode(",",$coupon->participating_categorie);
                            @endphp
                            @foreach ( $categoryCover as $key=> $item)
                                @php
                                    if($coupon->participating_categorie_type == 1){
                                        $coverCat = App\Models\TbCategory::select('id','category_show','category_name')->where('category_show',1)->where('id',$item)->first();
                                        $categoryName = $coverCat->category_name;
                                    }else{
                                        $coverCat = App\Models\TbCategorySub::select('id','categorysub_show','categorysub_name')->where('categorysub_show',1)->where('id',$item)->first();
                                        $categoryName = $coverCat->categorysub_name;
                                    }
                                @endphp
                                <li>{{ $categoryName }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if(!empty($coupon->non_participating_categorie))
                    <div class="col-full pd-bottom-10">
                        <strong>หมวดหมู่ที่ไม่ร่วมรายการ</strong><br/>
                        <ul class="no-mgb mg-left-20">
                            @php
                                $categoryCoverNone = explode(",",$coupon->non_participating_categorie);
                            @endphp
                            @foreach ( $categoryCoverNone as $key=> $item)
                                @php
                                    if($coupon->non_participating_categorie_type == 1){
                                        $coverNone_Cat = App\Models\TbCategory::select('id','category_show','category_name')->where('category_show',1)->where('id',$item)->first();
                                        $categoryNone_Name = $coverNone_Cat->category_name;
                                    }else{
                                        $coverNone_Cat = App\Models\TbCategorySub::select('id','categorysub_show','categorysub_name')->where('categorysub_show',1)->where('id',$item)->first();
                                        $categoryNone_Name = $coverNone_Cat->categorysub_name;
                                    }
                                @endphp
                                <li>{{ $categoryNone_Name }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if(!empty($coupon->coupon_des))
                <div class="col-ful pd-bottom-10">
                    <b>รายละเอียดเพิ่มเติม</b><br/>
                    {{ $coupon->coupon_des}}
                </div>
                @endif
                @if($coupon->status_product_not_sale == 1)
                    <div class="col-ful pd-bottom-10">
                        <b>หมายเหตุ</b><br/>ไม่สามารถใช้ร่วมกับสินค้าลดราคาได้
                    </div>
                @endif
                <br/>
                <div class="">
                    <a href="{{ $page }}">
                        <button class="btn btn-block button button-3d button-rounded button-red" type="button">กลับหน้าโค้ดส่วนลดของฉัน</button>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- canvas js -->
    <script type="text/javascript" src="{{ asset('assets/fontend/js/jquery.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/fontend/js/plugins.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/fontend/js/functions.js') }}"></script>
</body>
</html>
