<nav>
@php
	/* [PTCAD PATCH] ดึงค่าโลโก้จริงจากหลังบ้าน (ตาราง tb_setting) แทนไฟล์ตายตัวเดิม
	   ยังไม่แน่ใจว่า $setting ถูกแชร์มาจาก layout หลักให้ header ใช้ได้ทุกหน้าหรือไม่
	   เลย query ตรงๆในนี้ไปเลยให้ชัวร์ (เหมือนแพทเทิร์นที่ไฟล์นี้ใช้ query TbCategory อยู่แล้วด้านล่าง) */
	$ptSetting = App\Models\TbSetting::first();
	$ptLogoDesktop = !empty($ptSetting->setting_logoWeb)
		? asset('storage/setting/' . $ptSetting->setting_logoWeb)
		: asset('assets/fontend/hax_theme/images/logo.webp?v=2');
	$ptLogoMobile = !empty($ptSetting->setting_logoWeb_mobile)
		? asset('storage/setting/' . $ptSetting->setting_logoWeb_mobile)
		: $ptLogoDesktop;
@endphp
<style>
	.mobile-search-bar, .mobile-search-placeholder{
    display: none !important;
}	
.pt-nav-actions{align-items:center}
.pt-nav-search{height:42px;display:flex;align-items:center;margin:0}
.pt-nav-search input{height:100%}
.txt-phone,.txt-help,.txt-contact{
    font-family:'Poppins','Noto Sans Thai',system-ui,sans-serif !important;
    color:#fff !important;
}
.txt-phone a,.txt-help a,.txt-contact a{
    color:#fff !important;
}
.d-f-txttel .icon-head{
    filter:brightness(0) invert(1) !important;
}
.pt-acc-dropdown{position:relative}
.pt-acc-trigger{display:flex;align-items:center;gap:8px;border:1px solid #e6edf8;border-radius:999px;background:#fff;height:42px;padding:0 14px 0 6px;cursor:pointer;white-space:nowrap}
.pt-acc-avatar{width:30px;height:30px;border-radius:50%;background:linear-gradient(135deg,#1765ff,#0d57df);color:#fff;font-weight:800;font-size:13px;display:flex;align-items:center;justify-content:center;flex:none}
.pt-acc-name{font-weight:700;font-size:14px;color:#0b1f4d;white-space:nowrap;max-width:120px;overflow:hidden;text-overflow:ellipsis}
.pt-acc-panel{position:absolute;top:52px;right:0;width:260px;background:#fff;border:1px solid #e6edf8;border-radius:16px;box-shadow:0 18px 50px rgba(20,53,143,.14);padding:10px;display:none;z-index:50}
.pt-acc-panel.open{display:block}
.pt-acc-panel-head{padding:10px 12px 14px;border-bottom:1px solid #e6edf8;margin-bottom:8px}
.pt-acc-panel-head b{display:block;color:#0b1f4d;font-size:14px}
.pt-acc-panel-head span{display:block;color:#667085;font-size:12px}
.pt-acc-panel a{display:flex;align-items:center;gap:10px;padding:10px 12px;border-radius:10px;color:#344054;font-weight:700;font-size:14px;text-decoration:none}
.pt-acc-panel a:hover{background:#eef6ff;color:#1765ff}
.pt-acc-panel a.pt-acc-signout{color:#ef4444}

/* ===================================================================
   PTCAD PATCH — Badge ตัวเลขจำนวนสินค้าบนไอคอนตะกร้า (แบบ Shopee)
   วงกลมแดง มีกรอบขาวครอบ ลอยมุมขวาบนของไอคอนตะกร้า
   =================================================================== */
.pt-nav-icon-btn{position:relative}
.pt-cart-badge{
    position:absolute;
    top:-4px;
    right:-6px;
    min-width:18px;
    height:18px;
    padding:0 4px;
    background:#ef4444;
    color:#fff;
    border:2px solid #fff;
    border-radius:999px;
    font-size:10px;
    font-weight:800;
    line-height:1;
    display:none;
    align-items:center;
    justify-content:center;
    font-family:'Poppins','Noto Sans Thai',system-ui,sans-serif;
    pointer-events:none;
}
.pt-mobile-menu-btn{
    display:none;
    background:none;
    border:none;
    cursor:pointer;
    width:36px;
    height:36px;
    align-items:center;
    justify-content:center;
    color:#12358f;
    padding:0;
}
@media (max-width: 900px){
    .wrapper{
        position: relative !important;
        z-index: 9999 !important;
    }
    .pt-nav-wrap{
        position: static !important;
    }
    .pt-mobile-menu-btn{ display:flex !important; }
    .pt-nav-menu{
        display:none !important;
        position:absolute;
        top:100%;
        left:0;
        right:0;
        background:#ffffff !important;
        opacity: 1 !important;
        flex-direction:column;
        gap:4px;
        padding:14px 20px;
        box-shadow:0 12px 34px rgba(20,53,143,.20);
        z-index:9999 !important;
        border-top:1px solid #e6edf8;
        border-radius: 0 0 16px 16px;
    }
    .pt-nav-menu.pt-mobile-open{
        display:flex !important;
    }
}
@media (max-width: 640px){
    .pt-nav-wrap{ flex-wrap: nowrap !important; }
    .pt-nav-actions{ gap: 6px !important; }
    .pt-nav-search{ max-width: 90px !important; min-width: 0 !important; padding: 0 8px !important; }
    .pt-nav-search input{ font-size: 12px !important; }
    .pt-nav-icon-btn{ width: 32px !important; height: 32px !important; }
    .pt-nav-buy-btn{ padding: 0 12px !important; font-size: 12px !important; height: 34px !important; white-space: nowrap; }
    .pt-acc-name{ display: none !important; }
    .pt-acc-trigger{ padding: 0 8px !important; }
    .pt-cart-badge{ top:-3px; right:-5px; min-width:16px; height:16px; font-size:9px; }
}


</style>
	<div class="wrapper">
		<a class="logowrapper" href="{{ route('fronend.home') }}@if(!empty($_GET['ref']))?ref={{ $_GET['ref'] }}@endif"><img class="w-logo-subhead" src="{{ $ptLogoDesktop }}"></a>

				<div class="pt-nav-wrap">
			<button type="button" id="ptMobileMenuBtn" class="pt-mobile-menu-btn" aria-label="เปิดเมนู">
				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
					<line x1="3" y1="6" x2="21" y2="6"></line>
					<line x1="3" y1="12" x2="21" y2="12"></line>
					<line x1="3" y1="18" x2="21" y2="18"></line>
				</svg>
			</button>

			<div class="pt-nav-menu">
    <a href="{{ route('fronend.home') }}" class="pt-nav-link">หน้าแรก</a>
    <a href="{{ route('fronend.category.all') }}" class="pt-nav-link">ผลิตภัณฑ์</a>
    <a href="{{ route('fronend.home') }}#download" class="pt-nav-link">ดาวน์โหลด</a>
    <a href="{{ route('fronend.article.main') }}" class="pt-nav-link">บทความ</a>
@auth
    <a href="{{ route('fronend.tutorial.main') }}" class="pt-nav-link">Tutorials</a>
@endauth
<a href="{{ route('fronend.account.faq') }}" class="pt-nav-link">FAQ</a>
<a href="{{ route('fronend.help.index') }}?ref=Website" class="pt-nav-link">บริการช่วยเหลือ</a>
</div>

			<div class="pt-nav-actions">
				<form class="pt-nav-search" action="{{ route('fronend.search') }}">
					<i data-lucide="search" size="16"></i>
					<input type="text" name="search" placeholder="ค้นหาอะไรก็ได้...">
				</form>

				<a href="{{ route('fronend.cart') }}" class="pt-nav-icon-btn" id="ptCartIconBtn">
					<i data-lucide="shopping-cart" size="20"></i>
					<span class="pt-cart-badge cart_show_quantity" id="ptCartBadge">{{ $cartCount ?? 0 }}</span>
				</a>

				@if (Route::has('login'))
					@auth
						@if (request()->routeIs('fronend.account*'))
						<div class="pt-acc-dropdown">
							<button type="button" class="pt-acc-trigger" onclick="document.getElementById('ptAccPanel').classList.toggle('open')">
								<span class="pt-acc-avatar">{{ strtoupper(substr(Auth::user()->displayname ?? Auth::user()->name,0,1)) }}</span>
								<span class="pt-acc-name">{{ Auth::user()->displayname ?? Auth::user()->name }}</span>
								<i data-lucide="chevron-down" size="16"></i>
							</button>
							<div class="pt-acc-panel" id="ptAccPanel">
								<div class="pt-acc-panel-head">
									<b>{{ Auth::user()->displayname ?? Auth::user()->name }}</b>
									<span>{{ Auth::user()->email }}</span>
								</div>
								<a href="{{ route('fronend.account.menu') }}"><i data-lucide="layout-dashboard" size="18"></i> Dashboard</a>
								<a href="{{ route('fronend.account.software') }}"><i data-lucide="box" size="18"></i> My Products</a>
								<a href="{{ route('fronend.tutorial.main') }}"><i data-lucide="play-circle" size="18"></i> Tutorial</a>
								<a href="{{ route('fronend.account.order') }}"><i data-lucide="receipt" size="18"></i> Orders & Invoices</a>
								<a href="{{ route('fronend.account') }}"><i data-lucide="user" size="18"></i> Profile</a>
								<a href="{{ route('fronend.account.changepassword') }}"><i data-lucide="shield" size="18"></i> Security</a>
								<a href="{{ route('user.logout') }}" class="pt-acc-signout"><i data-lucide="log-out" size="18"></i> Sign Out</a>
							</div>
						</div>
						@else
						<a href="{{ route('fronend.account.menu') }}" class="pt-nav-icon-btn">
							<i data-lucide="user" size="20"></i>
						</a>
						@endif
					@endauth
					@guest
						<a href="/login" class="pt-nav-icon-btn">
							<i data-lucide="user" size="20"></i>
						</a>
					@endguest
				@endif
				<a href="{{ route('fronend.category.all') }}" class="pt-nav-buy-btn">ซื้อเลย</a>
			</div>
		</div>

<!-- ซ่อน mega menu เดิม แต่ไม่ลบ เผื่อใช้ทีหลัง -->
<div style="display:none">

		<input type="radio" name="slider" id="menu-btn">
		<input type="radio" name="slider" id="close-btn">
		<div class="nav-links">
			<label for="close-btn" class="btn close-btn"><img src="/assets/fontend/hax_theme/images/close-menu.webp" alt="" class="img-closemenu"></label>
			
			<div class="menu-mobile-head">
				<div class="logowrapper"><img class="w-logo-subhead" src="{{ $ptLogoMobile }}"></div>
			</div>

			<div class="sup-menu-mobile">
				<div class="sup-menu-mobile-box">
					<div class="sup-menu-mobile-in">
						<img id="iconmenu1" class="size-icondropdown" src="/assets/fontend/hax_theme/images/icon-cat.webp">
						หมวดสินค้าของเรา
					</div>
					<img src="/assets/fontend/hax_theme/images/icon-small-r.webp" alt="" class="arrow-menu-mobile">
				</div>

				<div class="sup-menu-box" id="menu-mobile-main">
					<!--p class="sup-menu-view-all-cat">View All Category 
						<img src="/assets/fontend/hax_theme/images/arrow-green-right.webp" alt="" class="sup-menu-view-all-cat-arrow">
					</p-->
                    <a class="sup-menu-view-all-cat" href="{{ route('fronend.category.all') }}@if(!empty($_GET['ref']))?ref={{ $_GET['ref'] }}@endif">View All Category <img src="./img/arrow-green-right.png" alt="" class="sup-menu-view-all-cat-arrow"></a>
					@php
						$category = App\Models\TbCategory::where('category_show','1')->orderby('category_sort','desc')->get();
					@endphp
					@if (!empty($category))
						@foreach ($category as $index => $item)
							@php
								$counntSubcategory = App\Models\TbCategorySub::where('category_id', $item->id)->where('categorysub_show','1')->count();
							@endphp
							<p class="menu-item" data-submenu="{{ $item->id }}">{{ $item->category_name }}</p>
						@endforeach
					@endif
				</div>
				
				<!-- Submenu ของแต่ละหมวดหมู่ -->
				@php
					$categorys = App\Models\TbCategory::where('category_show',1)->orderBy('category_sort','desc')->get();
				@endphp
				@foreach ($categorys as $category)
				<div class="sup-submenu-mobile" id="submenu-{{ $category->id }}" style="display: none;">
					<div class="back-btn" onclick="showMainMenu()">← ย้อนกลับ</div>
					<p class="submenu-title">
						<a href="{{ route('fronend.category',$category->category_permalink) }}@if(!empty($_GET['ref']))?ref={{ $_GET['ref'] }}@endif">
							{{ $category->category_name }}
						</a>
					</p>
					
					<ul class="submenu-list">
						@php
							$categorySubs = App\Models\TbCategorySub::where('category_id',$category->id )->where('categorysub_show',1)->orderBy('categorysub_sort','desc')->get();
						@endphp
						@if(count($categorySubs) != 0)
							@foreach ( $categorySubs as $categorySub)
						
						<li><a href="{{ route('fronend.category',$categorySub->categorysub_permalink) }}@if(!empty($_GET['ref']))?ref={{ $_GET['ref'] }}@endif">{{ $categorySub->categorysub_name }}</a></li>
						
							@endforeach
						@endif
					</ul>
				</div>
				@endforeach
				
			</div>
			<!--div class="sup-menu-mobile">
				<div class="sup-menu-mobile-box">
					<div class="sup-menu-mobile-in">
						<img id="iconmenu1" class="size-icondropdown" src="/assets/fontend/hax_theme/images/icon-solution.webp">
						โซลูชั่นทางธุรกิจ
					</div>
					<img src="/assets/fontend/hax_theme/images/icon-small-r.webp" alt="" class="arrow-menu-mobile">
				</div>
			</div-->
			<div class="sup-menu-mobile">
				<div class="sup-menu-mobile-box">
				<div class="sup-menu-mobile-in">
					<a href="{{ route('fronend.article.main') }}@if(!empty($_GET['ref']))?ref={{ $_GET['ref'] }}@endif">
						<img id="iconmenu1" class="size-icondropdown" src="/assets/fontend/hax_theme/images/icon-news.webp">
						บทความและข่าวสาร
					</a>
				</div>
				<img src="/assets/fontend/hax_theme/images/icon-small-r.webp" alt="" class="arrow-menu-mobile">
				</div>
			</div>
			<div class="sup-menu-mobile">
				<div class="sup-menu-mobile-box">
					<div class="sup-menu-mobile-in">
						<a href="https://event.8baht.com?ref=web8baht" target="_blank">
							<img id="iconmenu1" class="size-icondropdown" src="/assets/fontend/hax_theme/images/icon-event.webp">
							อีเว้นท์ 
						</a>
					</div>
				</div>
			</div>
			<div class="sup-menu-mobile">
				<div class="sup-menu-mobile-box">
					<div class="sup-menu-mobile-in">
						<a href="{{ route('fronend.quotation') }}@if(!empty($_GET['ref']))?ref={{ $_GET['ref'] }}@endif">
							<img class="size-icon-circle" src="/assets/fontend/hax_theme/images/icon-quote.webp"> ขอใบเสนอราคา
						</a>
					</div>
				</div>
			</div>
			<div class="sup-menu-mobile">
				<div class="sup-menu-mobile-box ">
					<div class="sup-menu-mobile-in">
						<a href="{{ route('fronend.help.index') }}?ref=Website">
							<img class="size-icon-circle" src="/assets/fontend/hax_theme/images/icon-support.webp"> บริการช่วยเหลือ
						</a>
					</div>
				</div>
			</div>
			<!--div class="sup-menu-mobile">
				<div class="sup-menu-mobile-box">
					<div class="sup-menu-mobile-in">
						<img id="iconmenu1" class="size-icondropdown" src="/assets/fontend/hax_theme/images/language-g.webp">
						ภาษาไทย
					</div>
					<img src="/assets/fontend/hax_theme/images/icon-small-r.webp" alt="" class="arrow-menu-mobile">
				</div>
			</div-->
			<div class="sup-menu-mobile">
				<div class="sup-menu-mobile-box ">
					<div class="sup-menu-mobile-in">
						<a href="{{ route('fronend.favorite') }}">
							<img class="size-icon-circle" src="/assets/fontend/hax_theme/images/icon-heart.webp"> สินค้าที่ชื่นชอบ
						</a>
					</div>
				</div>
			</div>
			<div class="sup-menu-mobile">
				<div class="sup-menu-mobile-box ">
					<div class="sup-menu-mobile-in">
						<a href="{{ route('fronend.cart') }}">
							<img class="size-icon-circle" src="/assets/fontend/hax_theme/images/icon-bag.webp"> ตระกร้าสินค้า
						</a>
					</div>
				</div>
			</div>
			
			<label for="close-btn" class=" close-btn" style="margin: 30px;">
				@if (Route::has('login'))
					@auth
				<div style="position: relative;">
					<a class="btn-login" href="{{ route('fronend.account') }}">
						<img class="size-icon-circle" src="/assets/fontend/hax_theme/images/icon-user-white.webp">
						<div class="txt-login">{{ Auth::user()->displayname }}</div>
					</a>
				</div>
					@else
				<!--div style="position: relative;">
					<div class="btn-login ">
						<img class="size-icon-circle" src="/assets/fontend/hax_theme/images/icon-user-white.webp">
						<div  class="txt-login">เข้าสู่ระบบ</div>
					</div>
					 <div class="btn-login bt-loginaline " style="position: absolute;top: 0;left: 0;right: 0;background: unset;"></div>
				</div-->
				<div style="position: relative;">
					<a class="btn-login" href="/login">
						<img class="size-icon-circle" src="/assets/fontend/hax_theme/images/icon-user-white.webp">
						<div class="txt-login">เข้าสู่ระบบ</div>
					</a>
				</div>
					@endauth
				@endif
			
				<!--div class="bt-login bt-loginaline">
					เข้าสู่ระบบ
				</div-->
			</label>
		</div>
	
		<label for="menu-btn" class="btn menu-btn bt-openmenu-mobile">
		<div class="bt-openmenu-mobile">
			<img src="/assets/fontend/hax_theme/images/open-menu.webp" alt="" class="img-openmenu">เมนู
		</div>
		</label>
	</div>
	
	
	<div class="mobile-search-bar">
		<form class="nomargin" action="{{ route('fronend.search') }}">
			<div class="input-search-frame mobile-search-frame">
				<img src="/assets/fontend/hax_theme/images/icon-sreach-green.webp" alt="" class="input-img-search">
				<input
					class="input-main-text-search"
					type="text"
					id="search_mobile"
					name="search"
					placeholder="ค้นหาสินค้า..."
					value="{{ request('search') }}"
				>
			</div>
		</form>
	</div>

	<div class="mobile-search-placeholder"></div>

	<div class="sup-menu-product-category">
		<div class="sup-menu-product-categories-title">
			<a class="categories-title-box text-view-all-category" href="{{ route('fronend.category.all') }}@if(!empty($_GET['ref']))?ref={{ $_GET['ref'] }}@endif">View All Category <img src="/assets/fontend/hax_theme/images/arrow-green-right.webp" alt="" class="img-view-all-category"></a>
			@php
				$category_d1 = App\Models\TbCategory::where('category_show','1')->orderby('category_sort','desc')->get();
			@endphp
			@if (!empty($category_d1))
				@foreach ($category_d1 as $index_d1 => $item_d1)
					@php
						$counntSubcategory_d1 = App\Models\TbCategorySub::where('category_id', $item_d1->id)->where('categorysub_show','1')->count();
					@endphp
			<div class="categories-title-box @if($index_d1 == 0) active @endif" data-category="{{ $item_d1->id }}">{{ $item_d1->category_name }}</div>
				@endforeach
			@endif
		</div>
		
		
		@php
			$categorys_d2 = App\Models\TbCategory::where('category_show',1)->orderBy('category_sort','desc')->get();
		@endphp
		@foreach ($categorys_d2 as $index_d2 => $category_d2)
		<div class="sup-menu-content" id="category-{{ $category_d2->id }}" style="@if($index_d2 == 0) display: block; @endif">
			<div class="sup-menu-product-subcategories">
				<img src="/assets/fontend/hax_theme/images/cross-small-gray-menu.webp" alt="" class="subcategories-cross" onclick="sup_menu(1)">

				<div class="cad-ibm-software-box">
					<img src="/assets/fontend/hax_theme/images/cad-ibm-software.webp" alt="" class="cad-ibm-software-icon">
					<div>
						<p class="menutext-titlesup">{{ $category_d2->category_name }}</p>
						<p class="text-view-all-category"><a href="{{ route('fronend.category',$category_d2->category_permalink) }}@if(!empty($_GET['ref']))?ref={{ $_GET['ref'] }}@endif">View All <img src="/assets/fontend/hax_theme/images/arrow-green-right.webp" alt="" class="img-view-all-category"></a></p>
					</div>
				</div>
				<div class="cad-ibm-software-sup">
					
					<div class="cad-ibm-software-sup-c">
						@php
							$categorySubs_d2 = App\Models\TbCategorySub::where('category_id',$category_d2->id )->where('categorysub_show',1)->orderBy('categorysub_sort','desc')->get();
						@endphp
						@if(count($categorySubs_d2) != 0)
							@foreach ( $categorySubs_d2 as $categorySub_d2)
						<p class="cad-ibm-software-sup-text">
							<a href="{{ route('fronend.category',$categorySub_d2->categorysub_permalink) }}@if(!empty($_GET['ref']))?ref={{ $_GET['ref'] }}@endif">
								{{ $categorySub_d2->categorysub_name }}
							</a>
						</p>
							@endforeach
						@endif
					</div>
						
				</div>
			</div>
		</div>
		@endforeach
	</div>
	</div>
<script>
document.getElementById('ptMobileMenuBtn').addEventListener('click', function(){
    document.querySelector('.pt-nav-menu').classList.toggle('pt-mobile-open');
});
</script>
</nav>

<div id="loginbysosocial">
	<div class="modal-loginbysosocial ">
		<div class="modal-background">
			<div class="modal ">
				<!--1. login by  Social Media -->
				<div id="showilginbysosocial"   >
					<div  class="modalcontentreglogin pulldowe">
						<div class="modal-coverclose ">
							<div class="modal-closereg closereglogin">
								<img src="/assets/fontend/hax_theme/images/cross-small-gray.webp" style="width: 100%;" />
							</div>
						</div>
						<div class="coverlogologin"></div>
						<div class="boxmidreglo00">
							<div class="txtcoverwelcom"> ยินดีต้อนรับ</div>
						</div>
						<div class="boxmidreglo02">               
							<div onclick="$('#showilginbygmail').css('display','block'),$('#showilginbysosocial').css('display','none')" class="coverbtureglogin-bl">
								<div class="modal-iconloginreg">
									<img src="/assets/fontend/hax_theme/images/emailsing.webp" style="width: 100%;" />
								</div>
								<div class="txtbtureglogin-bl">เข้าสู่ระบบด้วย Email</div>
							</div>
							<div class="sub-boxmidreglo0201">
									<div class="txt-boxmidreglo0201">ยังไม่ได้เป็นสมาชิก?</div>
									<div onclick="$('#showRegisterbygmail').css('display','block'),$('#showilginbysosocial').css('display','none')" class="txt-boxmidreglo0202">สมัครสมาชิกเลย</div>
							</div>
							<div class="boxbottreglo00">
								<div class="txt-boxbottreglo00">เมื่อเข้าสู่ระบบ ถือว่าคุณได้ยอมรับและรับทราบ </div>
								<div style="display: flex;"> 
								<div class="sub-boxbottreglo01">นโยบายข้อมูลส่วนบุคคล</div>
									<div class="txt-sub-boxbottreglo01">
										ของ PTCAD แล้ว?
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--2. login by  gmail -->
				<div id="showilginbygmail"  style="display: none;">
					<div class="modalcontentreglogin  pulldowe">
						<div class="modal-coverclose">
							<div  id="closereglogingmail" class="modal-closereg closereglogin">
								<img src="/assets/fontend/hax_theme/images/cross-small-gray.webp" style="width: 100%;" />
							</div>
						</div>
						<div class="coverlogologin"></div>
						<div class="boxmidloginbygmail00">
							<div class="sub-midloginbygmail00"> 
								<div onclick="$('#showilginbysosocial').css('display','block'),$('#showilginbygmail').css('display','none')" class="modal-iconloginreg">
									<img src="/assets/fontend/hax_theme/images/arrowleft-bl.webp" style="width: 100%;" />
								</div>
								<p class="txtmidloginbygmail00">เข้าสู่ระบบด้วย Email</p>
								<div> &nbsp;</div>
							</div>
						</div>
						<div class="boxmidloginbygmail02">               
							<div class="input-box-v1-mo">
								<p class="input-title-text-mo">อีเมล</p>
								<div class="input-frame-mo">
									<input class="input-main-mo" type="text" value="" placeholder="อีเมล">
								</div>
							</div>
							<div class="input-box-v1-mo">
								<p class="input-title-text-mo">รหัสผ่าน</p>
								<div class="input-frame-mo">
									<input class="input-main-mo" id="password_login" type="password" placeholder="รหัสผ่าน">
								</div>
								<p class="input-description-text">ลืมรหัสผ่าน</p>
							</div>
							<div class="flex-center">
								<div class="btu-loginbygmail ">
									เข้าสู่ระบบ
								</div>
							</div>
							<div class="boxbottreglo00">
								<div class="txt-boxbottreglo00">เมื่อเข้าสู่ระบบ ถือว่าคุณได้ยอมรับและรับทราบ </div>
								<div class="flex-center"> 
								<div class="sub-boxbottreglo01">นโยบายข้อมูลส่วนบุคคล</div>
									<div class="txt-sub-boxbottreglo01">
										ของ PTCAD แล้ว?
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--3. Register with gmail -->
				<div id="showRegisterbygmail" style="display: none;" >
					<div  class="modalcontentreglogin sizenopd pulldowe" >
						<div class="modal-coverclose">
							<div  id="closereglogingmail" class="modal-closereg closereglogin">
								<img src="/assets/fontend/hax_theme/images/cross-small-gray.webp" style="width: 100%;" />
							</div>
						</div>
						<div class="boxmidloginbygmail00">
							<div class="sub-midinregbygmail00"> 
								<div onclick="$('#showilginbysosocial').css('display','block'),$('#showilginbygmail').css('display','none'),$('#showRegisterbygmail').css('display','none')" class="modal-iconloginreg">
									<img src="/assets/fontend/hax_theme/images/arrowleft-bl.webp" style="width: 100%;" />
								</div>
								<div class="txtmidloginbygmail00">สมัครสมาชิก</div>
								<div> &nbsp;</div>
							</div>
						</div>
						<div class="boxmidloginbygmail02"> 
							<div class="input-double-box-mo">
								<div class="input-box-v1-mo">
									<p class="input-title-text-mo">ชื่อ<span class="input-require-few-icon">*</span></p>
									<div class="input-frame-mo">
										<input class="input-main-mo" type="text" placeholder="ชื่อ">
									</div>
								</div>
								<div class="input-box-v1-mo">
									<p class="input-title-text-mo">นามสกุล<span class="input-require-few-icon">*</span></p>
									<div class="input-frame-mo">
										<input class="input-main-mo"type="text" placeholder="นามสกุล">
									</div>
								</div>
							</div>              
							<div class="input-box-v1-mo">
								<p class="input-title-text-mo">เบอร์โทรศัพท์มือถือ<span class="input-require-few-icon">*</span></p>
								<div class="input-frame-mo">
									<input class="input-main-mo" type="text" value="" placeholder="เบอร์โทรศัพท์มือถือ">
								</div>
							</div>
							<div class="input-box-v1-mo">
								<p class="input-title-text-mo">รหัสผ่าน<span class="input-require-few-icon">*</span></p>
								<div class="input-frame-mo">
									<input class="input-main-mo" id="password_register" type="password" placeholder="รหัสผ่าน">
									
								</div>
							</div>
							<div class="input-box-v1-mo">
								<p class="input-title-text-mo">ยืนยันรหัสผ่าน<span class="input-require-few-icon">*</span></p>
								<div class="input-frame-mo">
									<input class="input-main-mo" id="passwordconfrm" type="password" placeholder="ยืนยันรหัสผ่าน">
									
								</div>
							</div>
							<div class="boxmidregbyemail002">
								<label class="checkbox-login">
									<input type="checkbox" name="" value="" id="" check>
									<span class="checkmark1-login"></span>
									 <span  class="txtcoloridpermition">
										ข้าพเจ้ายินยอมให้ทางบริษัท ประมวลผลข้อมูลส่วนบุคคลของข้าพเจ้า เพื่อการติดต่อประชาสัมพันธ์หรือนำเสนอข้อมูลข่าวสารเกี่ยวกับบริษัท สินค้าและบริการต่างๆ ของบริษัทได้ ภายใต้เงื่อนไข <span class="text-coverbottreg0300">นโยบายส่วนบุคคล</span> ของบริษัทแปดบาทดอทคอมแล้ว
									 </span>
								</label>
							</div>
							<div class="flex-center">
								<div class="btu-loginbygmail ">
									สมัครสมาชิก
								</div>
							 </div>
						</div>
					</div>
				</div>
				<!-- line out bordering and plz dont delete  -->
				<svg class="modal-svg" xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" z-index="0" preserveAspectRatio="none">
					<rect x="0" y="0" fill="none" width="100%" height="100%" rx="3" ry="3"></rect>
				</svg>
			</div>
		</div>
	</div>
</div>

<script>
/* ===================================================================
   PTCAD PATCH — Badge จำนวนสินค้าในตะกร้า (แบบ Shopee)
   custom.min.js เดิมมีโค้ด $(".cart_show_quantity").html(t.TotalQuantity)
   อยู่แล้วในทุก success callback ของ "เพิ่มลงตะกร้า" (.b-cart-one, .b-carttwo,
   addCartVray) ดังนั้นแค่ตั้งให้ badge ใช้ class "cart_show_quantity" (ทำไว้
   ที่ span ด้านบนแล้ว) ตัวเลขก็จะอัปเดตเป็น 1 ทันทีที่กดเพิ่มตะกร้าโดยอัตโนมัติ
   ไม่ต้องแก้ custom.min.js เพิ่มเลย — สคริปต์นี้มีหน้าที่แค่:
   1) ซ่อน badge ตอนค่าเป็น 0
   2) ตัดให้โชว์ "99+" ถ้าเกิน 99
   =================================================================== */
(function () {
    document.querySelectorAll('.cart_show_quantity').forEach(function (badge) {
        function refresh() {
            var n = parseInt(badge.textContent, 10);
            if (isNaN(n) || n <= 0) {
                badge.style.display = 'none';
                return;
            }
            badge.style.display = 'flex';
            if (n > 99 && badge.textContent !== '99+') badge.textContent = '99+';
        }
        refresh();
        new MutationObserver(refresh).observe(badge, { childList: true, characterData: true, subtree: true });
    });
})();
</script>