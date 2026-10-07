@extends('layouts.temp_user')

@section('title'){{ $og_title }} |@endsection
@section('og_site_name'){{ $og_site_name }}@endsection
@section('og_keywords'){{ $og_keywords }}@endsection
@section('og_title'){{ $og_title }}@endsection
@section('og_description'){{ $og_description }}@endsection
@section('og_url'){{ $og_url }}@endsection
@section('og_image'){{ $og_image }}@endsection

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
            @endif
            <div class="section-nav-account topmargin-sm bottommargin-sm">
                <div class="nav-account hidden-sm hidden-xs">
                    <div class="list-group">
                        <a href="{{ route('fronend.account') }}" class="list-group-item"><img class="icon-left-profile" src="{{ asset('icon/profile/user-1.png') }}" /> ข้อมูลส่วนตัว</a></a>
                        <a href="{{ route('fronend.account.order') }}" class="list-group-item"><img class="icon-left-profile" src="{{ asset('icon/profile/cart-1.png') }}" />คำสั่งซื้อ</a></a>
                        <a href="{{ route('fronend.account.software') }}" class="list-group-item"><img class="icon-left-profile" src="{{ asset('icon/profile/software-2.png') }}" />ซอฟต์แวร์ของฉัน</a></a>
                        <a href="{{ route('fronend.account.coupon') }}" class="list-group-item"><img class="icon-left-profile" src="{{ asset('icon/profile/discount-1.png') }}" />โค้ดส่วนลดของฉัน</a></a>
                        <a href="{{ route('fronend.account.quotation') }}" class="list-group-item"><img class="icon-left-profile" src="/icon/profile/quotation-1.png" />ใบเสนอราคา</a></a>
                        <a href="{{ route('fronend.account.address') }}" class="list-group-item"><img class="icon-left-profile" src="{{ asset('icon/profile/map-1.png') }}" />ที่อยู่จัดส่ง</a></a>
                        <a href="{{ route('fronend.account.changepassword') }}" class="list-group-item"><img class="icon-left-profile" src="{{ asset('icon/profile/password-1.png') }}" />เปลี่ยนรหัสผ่าน</a></a>
                        <a href="{{ route('fronend.account.pdpa') }}" class="list-group-item"><img class="icon-left-profile" src="{{ asset('icon/profile/letter-1.png') }}" />รับข้อมูลข่าวสารและบัญชี</a></a>
                        <a href="{{ route('user.logout') }}" class="list-group-item"><img class="icon-left-profile" src="{{ asset('icon/profile/exit.png') }}" />ออกจากระบบ</a></a>
                    </div>
                </div>
                <div class="account-content">

                    <div class="hidden-lg hidden-md backTomenu_account">
                        <a href="{{ route('fronend.account.menu') }}">
                            <img class="icon-left-profile" src="{{ asset('icon/icon-left-black.png') }}" />
                            กลับเมนูหลัก
                        </a>
                    </div>

                    <div class="col_margin_5">
                        <h3>ซอฟต์แวร์</h3>
                        <div>คุณสามารถเพิ่ม "serial number" ไว้ในระบบ เพื่อรับการแจ้งเตือนหากรายการของคุณกำลังจะหมดอายุ เราจะส่งอีเมลแจ้งเตือนถึงคุณก่อนการหมดอายุ 7 วัน</div>
                        <hr/>
                    </div>
                    @if(empty($software))
                        {{
                            Form::open([
                                'novalidate',
                                'route' => 'fronend.account.software.crate',
                                'id'=>'software-form',
                                'method' => 'post',
                                'files' => true
                            ])
                        }}
                    @else
                        {{
                            Form::model($software, [
                                'novalidate',
                                'route' => ['fronend.account.software.update',[$software->id]],
                                'id'=>'software-form',
                                'method' => 'put',
                                'files' => true
                            ])
                        }}
                    @endif
                        <div class="col_full bottommargin-xs">
                            <div class="row">
                                <div class="col-md-3">
                                    ชื่อโปรแกรม <span class="span-danger">*</span>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" id="name" name="name" placeholder="ชื่อโปรแกรม" class="sm-form-control" value="@if(!empty($software->name)){{ $software->name }}@endif" />
                                    @error('name')<small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>@enderror
                                </div>
                            </div>
                        </div>
                        <div class="col_full bottommargin-xs">
                            <div class="row">
                                <div class="col-md-3">
                                    Serial Number <span class="span-danger">*</span>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" placeholder="Serial Number" id="serial_number" name="serial_number" value="@if(!empty($software->serial_number)){{ $software->serial_number }}@endif" class="sm-form-control">
                                    @error('serial_number')<small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>@enderror
                                </div>
                            </div>
                        </div>
                        <div class="col_full bottommargin-xs">
                            <div class="row">
                                <div class="col-md-3">
                                    วันที่เริ่มต้นใช้งาน <span class="span-danger">*</span>
                                </div>
                                <div class="col-md-4">
                                    <div class="travel-date-group">
                                        <input type="text" placeholder="วันที่เริ่มต้นใช้งาน" id="date_start" name="date_start" value="@if(!empty($software->date_start)){{ date("d-m-Y",strtotime($software->date_start)) }}@endif" class="sm-form-control tleft format" placeholder="DD-MM-YYYY">
                                        @error('date_start')<small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>@enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col_full bottommargin-xs">
                            <div class="row">
                                <div class="col-md-3">
                                    วันที่หมดอายุ <span class="span-danger">*</span>
                                </div>
                                <div class="col-md-4">
                                    <div class="travel-date-group">
                                        <input type="text" placeholder="วันที่หมดอายุ" id="date_exp" name="date_exp" value="@if(!empty($software->date_exp)){{ date("d-m-Y",strtotime($software->date_exp)) }}@endif" class="sm-form-control tleft format" placeholder="DD-MM-YYYY">
                                        @error('date_exp')<small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>@enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col_full bottommargin-xs">
                            <div class="row">
                                <div class="col-md-3"></div>
                                <div class="col-md-4">
                                    <a href="{{ route('fronend.account.software') }}">@include('layouts.fontend.button.back')</a>
                                </div>
                                <div class="col-md-1"></div>
                                <div class="col-md-4">
                                    @include('layouts.fontend.button.save')
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection



