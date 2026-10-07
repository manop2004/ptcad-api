<header id="header" class="hidden-mobile-md">
	<input type="hidden" id="ref" value="@if(!empty($_GET['ref']))?ref={{ $_GET['ref'] }}@endif">
    <div id="header-wrap">
        <div class="container clearfix">
            <div id="primary-menu-trigger"><i class="icon-reorder"></i></div>
            <div id="logo">
                <a href="{{ route('fronend.home') }}@if(!empty($_GET['ref']))?ref={{ $_GET['ref'] }}@endif" class="standard-logo" data-dark-logo="@if(!empty($setting->setting_logoWeb)){{ asset('storage/setting/'.$setting->setting_logoWeb) }}@endif"><img width="200" height="100" class="lazyload"  src="@if(!empty($setting->setting_logoWeb)){{ asset('storage/setting/'.$setting->setting_logoWeb) }}@endif" alt="@if(!empty($setting->setting_nameWeb)){{ $setting->setting_nameWeb }}@endif"></a>
                <a href="{{ route('fronend.home') }}@if(!empty($_GET['ref']))?ref={{ $_GET['ref'] }}@endif" class="retina-logo" data-dark-logo="@if(!empty($setting->setting_logoWeb)){{ asset('storage/setting/'.$setting->setting_logoWeb) }}@endif"><img width="200" height="100" class="lazyload"  src="@if(!empty($setting->setting_logoWeb)){{ asset('storage/setting/'.$setting->setting_logoWeb) }}@endif" alt="@if(!empty($setting->setting_nameWeb)){{ $setting->setting_nameWeb }}@endif"></a>
            </div>
            <div id="primary-menu-grid" >
                <nav id="primary-menu">
                    <ul>
                        <li class="current"><a href="#" class="primary-menu-click"><div><i class="icon-reorder"></i> หมวดหมู่สินค้า</div><span>Lets Start</span></a></li>
                    </ul>
                </nav>
                <div id="primary-menu-search">
                    <form class="nomargin" action="{{ route('fronend.search') }}">
                        <div class="search-group">
                            <button type="submit" class="searc-icon"></button>
                            <input type="text" class="search-input-group" placeholder="ค้นหาสินค้าทั้งหมดที่นี่.." id="search" name="search">
                            <button type="submit" class="searc-btn"><i class="icon-search"></i></button>
                        </div>
                    </form>
                    @php
                        $hotsearchs = App\Models\TbSettingHotsearch::where('hotsearch_show',1)->get();
                    @endphp
                    <div class="b-hotsearch">
                        @foreach ( $hotsearchs as $hotsearch)
                            <a href="{{ $hotsearch->hotsearch_url }}" class="hotsearch"><small>{{ $hotsearch->hotsearch_name }}</a></small>
                        @endforeach
                    </div>
                </div>
                <div id="primary-menu-right">
                    <div class="grid-primary-menu-right">
                        <a href="{{ route('fronend.favorite') }}" class="relative">
                            <span class="cart_favorite_quantity" ><div id="span-favorite"></div></span>
                            <img width="30" height="30" alt="heart" class="lazyload"  src="{{ asset('icon/ecom/heart2.webp') }}"  />
                        </a>
                        <a href="{{ route('fronend.cart') }}" class="relative">
                            <span class="cart_show_quantity">{{ \Cart::getTotalQuantity() }}</span>
                            <img width="30" height="30" alt="cart" src="{{ asset('icon/ecom/cart.webp') }}"  />
                        </a>
                        @if (Route::has('login'))
                            @auth
                                <div class="ui-user-menu">
                                    <a href="{{ route('fronend.account') }}" class="dropdown-toggle" data-toggle="dropdown">
                                        @if(!empty(Auth::user()->img))
                                            <img width="30" height="30" alt="user" class="img-circle lazyload user-img border"  src="{{ asset('storage/avatar/'.Auth::user()->img) }}"  />
                                        @else
                                            <img width="30" height="30" alt="user" class="lazyload"  src="{{ asset('icon/ecom/user.webp') }}"  />
                                        @endif
                                    </a>
                                    <div class="dropdown-menu" role="menu" >
                                        <a class="dropdown-item" href="{{ route('fronend.account')}}"><div><i class="icon-user4"></i>  บัญชีผู้ใช้ของฉัน</div></a>
                                        <a class="dropdown-item " href="{{ route('fronend.account.order') }}"><div><i class="icon-cart"></i>  คำสั่งซื้อของฉัน</div></a>
                                        @if(Auth::user()->level != 6)
                                            <a class="dropdown-item" href="{{ route('home') }}@if(!empty($_GET['ref']))?ref={{ $_GET['ref'] }}@endif"><div><i class="icon-dashboard"></i>  จัดการหลังบ้าน</div></a>
                                        @endif
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="{{ route('user.logout') }}"><div><i class="icon-line2-logout"></i>  ออกจากระบบ</div></a>
                                    </div>
                                </div>
                            @else
                                <a href="{{ route('login') }}">
                                    <img width="30" height="30" alt="user" class="lazyload"  src="{{ asset('icon/ecom/user.webp') }}"  />
                                </a>
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <div class="container clearfix">
            <div id="myMenuPrimaryMenu">
                <div class="row">
                    <div class="col-md-4">
                        <div class="the-main-menu-list">
							<a class="main-menu" href="https://phpstack-1646968-6541058.cloudwaysapps.com/sale"><div>สินค้าลดราคา </div></a>
                            @php
                                $category = App\Models\TbCategory::where('category_show','1')->orderby('category_sort','desc')->get();
                            @endphp
                            @if (!empty($category))
                                @foreach ($category as $index => $item)
                                    @php
                                        $counntSubcategory = App\Models\TbCategorySub::where('category_id', $item->id)->where('categorysub_show','1')->count();
                                    @endphp
                                    <a class="main-menu" data-id="{{ $item->id }}" href="{{ route('fronend.category',$item->category_permalink) }}@if(!empty($_GET['ref']))?ref={{ $_GET['ref'] }}@endif"><div >{{ $item->category_name }} @if($counntSubcategory != 0)<i class="icon-angle-right"></i>@endif</div></a>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="the-main-menu-list">
                            <div id="sub-menu-primary"></div>
                        </div>
                    </div>
                </div>
                <a id="primary-menu-click-cloase" href="#" class="closebtn">×</a>
            </div>
        </div>
    </div>
</header>
<header id="header" class="full-header hidden-desktop-md dark">
    <div id="header-wrap">
        <div class="container-menu-mobile clearfix">
            <div id="primary-menu-mobile-grid" >
                <a href="#" id="wrapMenu">
                    <div id="primary-menu-trigger-mobile"><i class="icon-reorder"></i></div>
                </a>
                <div id="logo">
                    <a href="{{ route('fronend.home') }}" class="standard-logo" data-dark-logo="@if(!empty($setting->setting_logoWeb_mobile)){{ asset('storage/setting/'.$setting->setting_logoWeb_mobile) }}@endif"><img width="200" height="100" class="lazyload"  src="@if(!empty($setting->setting_logoWeb_mobile)){{ asset('storage/setting/'.$setting->setting_logoWeb_mobile) }}@endif" alt="@if(!empty($setting->setting_nameWeb)){{ $setting->setting_nameWeb }}@endif"></a>
                    <a href="{{ route('fronend.home') }}" class="retina-logo" data-dark-logo="@if(!empty($setting->setting_logoWeb_mobile)){{ asset('storage/setting/'.$setting->setting_logoWeb_mobile) }}@endif"><img width="200" height="100" class="lazyload"  src="@if(!empty($setting->setting_logoWeb_mobile)){{ asset('storage/setting/'.$setting->setting_logoWeb_mobile) }}@endif" alt="@if(!empty($setting->setting_nameWeb)){{ $setting->setting_nameWeb }}@endif"></a>
                </div>
                <div id="primary-menu-right">
                    <div class="grid-primary-menu-right">
                        <div id="top-search">
							<a href="#" id="top-search-trigger"><i class="icon-search3"></i><i class="icon-line-cross"></i></a>
							<form class="nomargin" action="{{ route('fronend.search') }}">
								<input type="text" name="search" class="form-control" placeholder="ค้นหา..">
							</form>
						</div>
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ route('fronend.account') }}">
                                    <img width="20" height="20" alt="user" class="lazyload"  src="{{ asset('icon/ecom/user-circle@2x.webp') }}"  />
                                </a>
                            @else
                                <a href="{{ route('login') }}">
                                    <img width="20" height="20" alt="user" class="lazyload"  src="{{ asset('icon/ecom/user-circle@2x.webp') }}"  />
                                </a>
                            @endauth
                        @endif
                        <a href="{{ route('fronend.cart') }}" class="relative">
                            <span class="cart_show_quantity">{{ \Cart::getTotalQuantity() }}</span>
                            <img width="20" height="20" alt="cart" class="lazyload"  src="{{ asset('icon/ecom/cart@2x.webp') }}"  />
                        </a>
                    </div>
                </div>
            </div>
            <div id="mySidenav" class="sidenav">
                <a id ="wrapMenu-cloase" href="#" class="closebtn">&times;</a>
                <div>
                    <a class="logo" href="{{ route('fronend.home') }}"><img width="140" height="70" class="lazyload"  src="@if(!empty($setting->setting_logoWeb_mobile)){{ asset('storage/setting/'.$setting->setting_logoWeb_mobile) }}@endif" alt="@if(!empty($setting->setting_nameWeb)){{ $setting->setting_nameWeb }}@endif"></a>
                    @php
                        $categorys = App\Models\TbCategory::where('category_show',1)->orderBy('category_sort','desc')->get();
                    @endphp
                    @foreach ($categorys as $category)
                        <div class="m_b_line">
                            <a href="{{ route('fronend.category',$category->category_permalink) }}@if(!empty($_GET['ref']))?ref={{ $_GET['ref'] }}@endif">
                                {{ $category->category_name }}
                            </a>
                            @php
                                $categorySubs = App\Models\TbCategorySub::where('category_id',$category->id )->where('categorysub_show',1)->orderBy('categorysub_sort','desc')->get();
                            @endphp
                            @if(count($categorySubs) != 0)
                                <div class="mc_im_sub" data-id="{{ $category->id }}" ></div>

                                <div id="sub-{{ $category->id }}" class="submenu" >
                                    <a href="#" class="closebtnsub" data-id="{{ $category->id }}">&times;</a>
                                    <a class="logo" href="{{ route('fronend.home') }}"><img width="140" height="70" class="lazyload"  src="@if(!empty($setting->setting_logoWeb_mobile)){{ asset('storage/setting/'.$setting->setting_logoWeb_mobile) }}@endif" alt="@if(!empty($setting->setting_nameWeb)){{ $setting->setting_nameWeb }}@endif"></a>
                                    <div class="submenu-head">
                                        {{ $category->category_name }}
                                        <div class="mc_im_sub closebtnsub" data-id="{{ $category->id }}" ></div>
                                    </div>
                                    @foreach ( $categorySubs as $categorySub)
                                        <div class="m_b_line">
                                            <a href="{{ route('fronend.category',$categorySub->categorysub_permalink) }}@if(!empty($_GET['ref']))?ref={{ $_GET['ref'] }}@endif">
                                                {{ $categorySub->categorysub_name }}
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                    <div class="m_b_line"><a href="{{ route('fronend.help.index') }}@if(!empty($_GET['ref']))?ref={{ $_GET['ref'] }}@endif" > บริการช่วยเหลือ </a></div>
                </div>
            </div>
        </div>
    </div>
</header>


