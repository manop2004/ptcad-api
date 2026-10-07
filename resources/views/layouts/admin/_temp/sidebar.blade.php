@php
    $user_sidebar = App\Models\User::where('id',Auth::user()->id)->first();
    if($user_sidebar->level == 6){
        $newURL = route('user.logout');
        header('Location: '.$newURL);
        exit();
    }
    $UserLevel = App\Models\UsersLevel::where('UserId',Auth::user()->id)->first();
@endphp
<div class="sidebar" data-color="brown" data-active-color="danger">
    <div class="sidebar-wrapper">
        <div class="user">
            <div class="photo">
                @if(!empty($user_sidebar->img))
                    <input type="hidden" class="form-control" id="img_old" name="img_old" value="{{ $user_sidebar->img }}">
                    <img class="picture-src" src="{{ asset('storage/avatar/'.$user_sidebar->img) }}" alt="..."/>
                @else
                    <img class="picture-src" src="{{ asset('images/default-img/default-avatar.png') }}" alt="..."  />
                @endif
            </div>
            <div class="info">
            <a data-toggle="collapse" href="#collapseExample" class="collapsed">
                <span>
                    {{ Auth::user()->displayname }}
                    <b class="caret"></b>
                </span>
            </a>
            <div class="clearfix"></div>
            <div class="collapse" id="collapseExample">
                <ul class="nav">
                    <li>
                        <a href="{{ route('user.profile', ['id' => Auth::user()->id]) }}">
                            <span class="sidebar-mini-icon">MP</span>
                            <span class="sidebar-normal">บัญชีผู้ใช้</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('logout') }}">
                            <span class="sidebar-mini-icon">LG</span>
                            <span class="sidebar-normal">ออกจากระบบ</span>
                        </a>
                    </li>
                </ul>
            </div>
            </div>
        </div>
        <ul class="nav">
            <li id="dashboard" class="mainMenu active">
                <a href="{{ route('home') }}">
                    <i class="nc-icon nc-bank"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            @if($UserLevel->l_artlicle == 1)
            <li id="artlicle" class="mainMenu">
                <a href="{{ route('artlicle.index') }}">
                    <i class="nc-icon nc-book-bookmark"></i>
                    <p>บทความ</p>
                </a>
            </li>
            @if($UserLevel->l_artlicle == 1)
<li id="tutorial" class="mainMenu">
    <a href="{{ route('tutorial.index') }}">
        <i class="nc-icon nc-tv-2"></i>
        <p>Tutorial</p>
    </a>
</li>
<li id="faq" class="mainMenu">
    <a href="{{ route('faq.index') }}">
        <i class="nc-icon nc-support-17"></i>
        <p>FAQ</p>
    </a>
</li>
@endif
@endif
            <li id="chatbot" class="mainMenu">
                <a href="{{ route('chatbot.index') }}">
                    <i class="nc-icon nc-chat-33"></i>
                    <p>Chatbot</p>
                </a>
            </li>
            <li id="document" class="mainMenu">
    <a href="{{ route('document.index') }}">
        <i class="nc-icon nc-single-copy-04"></i>
        <p>Document</p>
    </a>
</li>
            @if($UserLevel->l_setting == 1)
            <li id="herobanner" class="mainMenu">
                <a data-toggle="collapse" href="#HeroBanner">
                    <i class="nc-icon nc-image"></i>
                    <p>
                        Hero Banner หน้าแรก
                    <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse" id="HeroBanner">
                    <ul class="nav">
                        <li class="subMenu">
                            <a href="{{ route('setting.herobanner') }}">
                                <span class="sidebar-mini-icon">HB</span>
                                <span class="sidebar-normal"> ตั้งค่า Hero Banner </span>
                            </a>
                        </li>
                        <li class="subMenu">
                            <a href="{{ route('productcategory.index') }}">
                                <span class="sidebar-mini-icon">PC</span>
                                <span class="sidebar-normal"> การ์ดสินค้าหน้าแรก </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            @endif
            @if($UserLevel->l_page == 1)
                <li id="pages" class="mainMenu" >
                    <a data-toggle="collapse" href="#Pages">
                        <i class="nc-icon nc-align-left-2"></i>
                        <p>
                            จัดการหน้าเพจ
                        <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse" id="Pages">
                        <ul class="nav">
                            <li class="subMenu">
                                <a href="{{ route('page.setting') }}">
                                    <span class="sidebar-mini-icon">SP</span>
                                    <span class="sidebar-normal"> ตั้งค่าหน้าเพจ </span>
                                </a>
                            </li>
                            <li class="subMenu">
                                <a href="{{ route('page.index') }}">
                                    <span class="sidebar-mini-icon">PM</span>
                                    <span class="sidebar-normal"> หน้าเพจ </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            @endif
            @if($UserLevel->l_quotation_setting == 1 || $UserLevel->l_quotation == 1)
            <li id="quotation" class="mainMenu" >
                <a data-toggle="collapse" href="#Quotation">
                    <i class="nc-icon nc-paper"></i>
                    <p>
                        ใบเสนอราคา
                    <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse" id="Quotation">
                    <ul class="nav">
                        @if($UserLevel->l_quotation_setting == 1)
                        <li class="subMenu">
                            <a href="{{ route('quotation.setting') }}">
                                <span class="sidebar-mini-icon">QS</span>
                                <span class="sidebar-normal"> ตั้งค่าใบเสนอราคา </span>
                            </a>
                        </li>
                        @endif
                        @if($UserLevel->l_quotation == 1)
                        <li class="subMenu">
                            <a href="{{ route('quotation.index') }}">
                                <span class="sidebar-mini-icon">QT</span>
                                <span class="sidebar-normal"> ใบเสนอราคา </span>
                            </a>
                        </li>
                        @endif
                        <li class="subMenu">
                            <a href="{{ route('quotation.report') }}">
                                <span class="sidebar-mini-icon">QR</span>
                                <span class="sidebar-normal"> รายงานใบเสนอราคา </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            @endif
            <li id="orders" class="mainMenu" >
                <a data-toggle="collapse" href="#Orders">
                    <i class="nc-icon nc-align-left-2"></i>
                    <p>
                        ออเดอร์
                    <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse" id="Orders">
                    <ul class="nav">
                        <li class="subMenu">
                            <a href="{{ route('order.index') }}">
                                <span class="sidebar-mini-icon">OD</span>
                                <span class="sidebar-normal"> ออเดอร์ </span>
                            </a>
                        </li>
                        <li class="subMenu">
                            <a href="{{ route('order.report') }}">
                                <span class="sidebar-mini-icon">OR</span>
                                <span class="sidebar-normal"> รายงานออเดอร์ </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            @if($UserLevel->l_product == 1)
				<li id="settingProduct" class="mainMenu" >
                    <a href="{{ route('order.review.index') }}">
                        <i class="nc-icon nc-favourite-28"></i>
                        <p>
                            Review จากลูกค้า
                        </p>
                    </a>
                </li>
                <li id="settingProduct" class="mainMenu" >
                    <a data-toggle="collapse" href="#Product">
                        <i class="nc-icon nc-box-2"></i>
                        <p>
                        ตั้งค่ารายการสินค้า
                        <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse" id="Product">
                        <ul class="nav">
                            <li class="subMenu">
                                <a href="{{ route('product.index') }}">
                                    <span class="sidebar-mini-icon">PD</span>
                                    <span class="sidebar-normal"> รายการสินค้า </span>
                                </a>
                            </li>
                            @if($UserLevel->l_product_Action == 1 && $user_sidebar->level != 8)
                            <li class="subMenu">
                                <a href="{{ route('category.index') }}">
                                    <span class="sidebar-mini-icon">PC</span>
                                    <span class="sidebar-normal"> หมวดหมู่สินค้า </span>
                                </a>
                            </li>
                            <li class="subMenu">
                                <a href="{{ route('brand.index') }}">
                                    <span class="sidebar-mini-icon">PB</span>
                                    <span class="sidebar-normal"> แบรนด์สินค้า </span>
                                </a>
                            </li>
                            <li class="subMenu">
                                <a href="{{ route('type.index') }}">
                                <span class="sidebar-mini-icon">PT</span>
                                <span class="sidebar-normal"> ประเภทสินค้า </span>
                                </a>
                            </li>
                            <li class="subMenu">
                                <a href="{{ route('condition.index') }}">
                                <span class="sidebar-mini-icon">PS</span>
                                <span class="sidebar-normal"> เงื่อนไขการบริการ </span>
                                </a>
                            </li>
                            <li class="mainMenu">
                                <a href="{{ route('history.fileupload.product.index') }}">
                                    <span class="sidebar-mini-icon">PF</span>
                                    <span class="sidebar-normal"> ประวัติการอัพโหลดไฟล์สินค้า </span>
                                </a>
                            </li>
                            <li class="subMenu">
                                <a href="{{ route('product.report') }}">
                                    <span class="sidebar-mini-icon">PR</span>
                                    <span class="sidebar-normal"> รายงานสินค้า </span>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </li>
            @else
                <li id="settingProduct" class="mainMenu" >
                    <a href="{{ route('product.report') }}">
                        <i class="nc-icon nc-app"></i>
                        <p>
                            รายงานสินค้า
                        <b class="caret"></b>
                        </p>
                    </a>
                </li>
            @endif
            @if($UserLevel->l_banner == 1)
            <li id="banner" class="mainMenu">
                <a href="{{ route('banner.index') }}">
                    <i class="nc-icon nc-album-2"></i>
                    <p>แบรนเนอร์</p>
                </a>
            </li>
            @endif

            @if($UserLevel->l_promotion == 1)
                <li id="promotion" class="mainMenu" >
                    <a data-toggle="collapse" href="#Promotion">
                        <i class="nc-icon nc-bag-16"></i>
                        <p>
                            โปรโมชั่น
                        <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse" id="Promotion">
                        <ul class="nav">
                            <li class="subMenu">
                                <a href="{{ route('promotion.coupon.index') }}">
                                    <span class="sidebar-mini-icon">CP</span>
                                    <span class="sidebar-normal"> คูปอง </span>
                                </a>
                            </li>
                            <li class="subMenu">
                                <a href="{{ route('promotion.emailtemplate.index') }}">
                                    <span class="sidebar-mini-icon">PE</span>
                                    <span class="sidebar-normal"> Email Template </span>
                                </a>
                            </li>
                            <li class="subMenu">
                                <a href="{{ route('promotion.calendar') }}">
                                    <span class="sidebar-mini-icon">PC</span>
                                    <span class="sidebar-normal"> ปฏิทินโปรโมชั่น </span>
                                </a>
                            </li>
                            {{-- <li class="subMenu">
                                <a href="{{ route('onepage.index') }}">
                                    <span class="sidebar-mini-icon">OP</span>
                                    <span class="sidebar-normal"> One Page Promotion </span>
                                </a>
                            </li> --}}
                            <li class="subMenu">
                                <a href="{{ route('promotion.pdpa') }}">
                                    <span class="sidebar-mini-icon">RP</span>
                                    <span class="sidebar-normal"> รายงาน PDPA </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            @else
                <li id="promotionCalendar" class="mainMenu">
                    <a href="{{ route('promotion.calendar') }}">
                        <i class="nc-icon nc-album-2"></i>
                        <p>ปฏิทินโปรโมชั่น</p>
                    </a>
                </li>
            @endif
            @if($UserLevel->l_software == 1)
            <li id="software" class="mainMenu">
                <a href="{{ route('software.index') }}">
                    <i class="nc-icon nc-book-bookmark"></i>
                    <p>ซอฟต์แวร์</p>
                </a>
            </li>
            @endif
            @if($UserLevel->l_software == 1)
<li id="civilpromax" class="mainMenu">
    <a href="{{ route('admin.civilpromax.stock') }}">
        <i class="nc-icon nc-single-copy-04"></i>
        <p>Civil ProMax Stock</p>
    </a>
</li>
@endif
            @if($UserLevel->l_program == 1)
            <li id="program" class="mainMenu">
                <a href="{{ route('program.index') }}">
                    <i class="nc-icon nc-app"></i>
                    <p>ตัวติดตั้งโปรแกรม</p>
                </a>
            </li>
            @endif
            @if($UserLevel->l_ticket == 1)
            <li id="Users" class="mainMenu" >
                <a data-toggle="collapse" href="#mainTicket">
                    <i class="nc-icon nc-settings"></i>
                    <p>
                        บริการช่วยเหลือ
                    <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse" id="mainTicket">
                    <ul class="nav">
                        <li class="subMenu">
                            <a href="{{ route('ticket.index') }}">
                                <span class="sidebar-mini-icon">TK</span>
                                <span class="sidebar-normal"> Ticket </span>
                            </a>
                        </li>
                        <li class="subMenu">
                            <a href="{{ route('ticket.program.index') }}">
                                <span class="sidebar-mini-icon">TK</span>
                                <span class="sidebar-normal"> Program Support </span>
                            </a>
                        </li>
                        <li class="subMenu">
                            <a href="{{ route('ticket.dashboard') }}">
                                <span class="sidebar-mini-icon">RP</span>
                                <span class="sidebar-normal"> Report Ticket</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            @endif
            @if($UserLevel->l_user == 1)
                <li id="Users" class="mainMenu" >
                    <a data-toggle="collapse" href="#Users_i">
                        <i class="nc-icon nc-circle-10"></i>
                        <p>
                            บัญชีผู้ใช้
                        <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse" id="Users_i">
                        <ul class="nav">
                            @if($UserLevel->l_user_Action == 1 || $UserLevel->l_user_staff_Action == 1)
                            <li class="subMenu">
                                <a href="{{ route('user.index') }}">
                                    <span class="sidebar-mini-icon">US</span>
                                    <span class="sidebar-normal"> บัญชีผู้ใช้ </span>
                                </a>
                            </li>
                            @endif
                            @if($UserLevel->l_user_Action == 1)
                            <li class="subMenu">
                                <a href="{{ route('user.setting') }}">
                                    <span class="sidebar-mini-icon">US</span>
                                    <span class="sidebar-normal"> ตั้งค่าข้อมูลผู้ใช้งาน </span>
                                </a>
                            </li>
                            <li class="subMenu">
                                <a href="{{ route('business.index') }}">
                                    <span class="sidebar-mini-icon">UB</span>
                                    <span class="sidebar-normal"> ประเภทธุรกิจ </span>
                                </a>
                            </li>
                            <li class="subMenu">
                                <a href="{{ route('position.index') }}">
                                    <span class="sidebar-mini-icon">UP</span>
                                    <span class="sidebar-normal"> ตำแหน่ง/อาชีพ </span>
                                </a>
                            </li>
                            <li class="subMenu">
                                <a href="{{ route('user.dashboard') }}">
                                    <span class="sidebar-mini-icon">RP</span>
                                    <span class="sidebar-normal"> รายงานข้อมูลผู้ใช้ </span>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </li>
            @endif
            @if($UserLevel->l_bank == 1)
                <li id="paymentMain" class="mainMenu" >
                    <a data-toggle="collapse" href="#Payment">
                        <i class="nc-icon nc-money-coins"></i>
                        <p>
                        ตั้งค่าการชำระเงิน
                        <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse" id="Payment">
                        <ul class="nav">
                            <li class="subMenu">
                                <a href="{{ route('setting.payment') }}">
                                    <span class="sidebar-mini-icon">SP</span>
                                    <span class="sidebar-normal"> ตั้งค่าช่องทางการชำระเงิน </span>
                                </a>
                            </li>
                            <li class="subMenu">
                                <a href="{{ route('bank.index') }}">
                                <span class="sidebar-mini-icon">BA</span>
                                <span class="sidebar-normal"> ข้อมูลบัญชีธนาคาร </span>
                                </a>
                            </li>
                            <li class="subMenu">
                                <a href="{{ route('installment.index') }}">
                                <span class="sidebar-mini-icon">IN</span>
                                <span class="sidebar-normal"> ข้อมูลการผ่อนชำระ </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            @endif
            @if($UserLevel->l_membergetmember == 1)
                <li id="getMember_" class="mainMenu" >
                    <a data-toggle="collapse" href="#getMember">
                        <i class="nc-icon nc-badge"></i>
                        <p>
                        ระบบแนะนำสมาชิก
                        <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse" id="getMember">
                        <ul class="nav">
                            @if($UserLevel->l_membergetmember_setting == 1)
                            <li class="subMenu">
                                <a href="{{ route('getmember.setting') }}">
                                    <span class="sidebar-mini-icon">SW</span>
                                    <span class="sidebar-normal"> ตั้งค่าระบบแนะนำสมาชิก </span>
                                </a>
                            </li>
                            @endif
                            <li class="subMenu">
                                <a href="{{ route('getmember.index') }}">
                                    <span class="sidebar-mini-icon">SC</span>
                                    <span class="sidebar-normal"> ข้อมูลผู้แนะนำสมาชิก </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            @endif
            @if($UserLevel->l_recommend == 1)
                <li id="Recommend" class="mainMenu" >
                    <a data-toggle="collapse" href="#settingRecommend">
                        <i class="nc-icon nc-tv-2"></i>
                        <p>
                        ตั้งค่ารายการแนะนำ
                        <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse" id="settingRecommend">
                        <ul class="nav">
                            <li class="subMenu">
                                <a href="{{ route('recommend.category.index') }}">
                                    <span class="sidebar-mini-icon">RC</span>
                                    <span class="sidebar-normal"> แนะนำหมวดหมู่ </span>
                                </a>
                            </li>
                            <li class="subMenu">
                                <a href="{{ route('recommend.product.index') }}">
                                <span class="sidebar-mini-icon">RP</span>
                                <span class="sidebar-normal"> แนะนำสินค้า </span>
                                </a>
                            </li>
                            <li class="subMenu">
                                <a href="{{ route('recommend.promotion.index') }}">
                                    <span class="sidebar-mini-icon">RP</span>
                                    <span class="sidebar-normal"> แนะนำโปรโมชั่น </span>
                                </a>
                            </li>
                            <li class="subMenu">
                                <a href="{{ route('recommend.category.product.index') }}">
                                <span class="sidebar-mini-icon">RT</span>
                                <span class="sidebar-normal"> แนะนำหมวดหมู่ & สินค้า </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            @endif
            @if($UserLevel->l_setting == 1)
                <li id="settingMain" class="mainMenu" >
                    <a data-toggle="collapse" href="#Setting">
                        <i class="nc-icon nc-layout-11"></i>
                        <p>
                        ตั้งค่าเว็บไซต์
                        <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse" id="Setting">
                        <ul class="nav">
                            <li class="subMenu">
                                <a href="{{ route('setting.index') }}">
                                    <span class="sidebar-mini-icon">SW</span>
                                    <span class="sidebar-normal"> ข้อมูลเกี่ยวกับเว็บไซต์ </span>
                                </a>
                            </li>
                            <li class="subMenu">
                                <a href="{{ route('setting.contact') }}">
                                    <span class="sidebar-mini-icon">SC</span>
                                    <span class="sidebar-normal"> ข้อมูลติดต่อเรา </span>
                                </a>
                            </li>
                            <li class="subMenu">
                                <a href="{{ route('setting.extensions') }}">
                                <span class="sidebar-mini-icon">SE</span>
                                <span class="sidebar-normal"> ตั้งค่าเพิ่มเติม </span>
                                </a>
                            </li>
                            <li class="subMenu">
                                <a href="{{ route('transport.index') }}">
                                <span class="sidebar-mini-icon">TR</span>
                                <span class="sidebar-normal"> ผู้ให้บริการขนส่ง </span>
                                </a>
                            </li>
                            <li class="mainMenu">
                                <a href="{{ route('redirect.index') }}">
                                    <span class="sidebar-mini-icon">RP</span>
                                    <span class="sidebar-normal"> Redirect Page  </span>
                                </a>
                            </li>
                            <li class="mainMenu">
                                <a href="{{ route('hotsearch.index') }}">
                                    <span class="sidebar-mini-icon">HS</span>
                                    <span class="sidebar-normal"> Hot Search </span>
                                </a>
                            </li>
                            <li class="mainMenu">
                                <a href="{{ route('popup.index') }}">
                                    <span class="sidebar-mini-icon">PU</span>
                                    <span class="sidebar-normal"> POPUP </span>
                                </a>
                            </li>
                            <li class="subMenu">
    <a href="{{ route('levelmenu.index') }}">
        <span class="sidebar-mini-icon">RP</span>
        <span class="sidebar-normal"> จัดการสิทธิ์ตาม Role </span>
    </a>
</li>
                        </ul>
                    </div>
                </li>
            @endif
            @if($UserLevel->l_customcode == 1)
                <li id="customcode" class="mainMenu" >
                    <a data-toggle="collapse" href="#customCode">
                        <i class="nc-icon nc-ruler-pencil"></i>
                        <p>
                        Custom Code
                        <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse " id="customCode">
                        <ul class="nav">
                            <li class="subMenu">
                                <a href="{{ route('custom.index',['code' => 'css']) }}">
                                    <span class="sidebar-mini-icon">CC</span>
                                    <span class="sidebar-normal"> Custom Code Css </span>
                                </a>
                            </li>
                            <li class="subMenu">
                                <a href="{{ route('custom.index',['code' => 'js']) }}">
                                    <span class="sidebar-mini-icon">CJ</span>
                                    <span class="sidebar-normal"> Custom Code JS </span>
                                </a>
                            </li>
                            <li class="subMenu">
                                <a href="{{ route('custom.index',['code' => 'tag']) }}">
                                    <span class="sidebar-mini-icon">CT</span>
                                    <span class="sidebar-normal"> Custom Code Tag </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            @endif
        </ul>
    </div>
</div>