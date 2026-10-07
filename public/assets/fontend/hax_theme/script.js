function tapoursolution(id) {
	$("#tapoursolution-data-1").css("display",'none')
	$("#tapoursolution-data-2").css("display",'none')
	$("#tapoursolution-data-3").css("display",'none')
	$("#tapoursolution-data-4").css("display",'none')
	$("#tapoursolution-data-5").css("display",'none')
 

    if(id == 1){
		$("#tapoursolution-1").addClass('active-tapselect')
		$("#tapoursolution-2").removeClass('active-tapselect')
		$("#tapoursolution-3").removeClass('active-tapselect')
		$("#tapoursolution-4").removeClass('active-tapselect')
		$("#tapoursolution-5").removeClass('active-tapselect')


		$("#tapoursolution-data-1").css("display",'block')
    
    }if(id == 2){
		$("#tapoursolution-1").removeClass('active-tapselect')
		$("#tapoursolution-2").addClass('active-tapselect')
		$("#tapoursolution-3").removeClass('active-tapselect')
		$("#tapoursolution-4").removeClass('active-tapselect')
		$("#tapoursolution-5").removeClass('active-tapselect')


		$("#tapoursolution-data-2").css("display",'block')
    
    }if(id == 3){
		$("#tapoursolution-1").removeClass('active-tapselect')
		$("#tapoursolution-2").removeClass('active-tapselect')
		$("#tapoursolution-3").addClass('active-tapselect')
		$("#tapoursolution-4").removeClass('active-tapselect')
		$("#tapoursolution-5").removeClass('active-tapselect')


		$("#tapoursolution-data-3").css("display",'block')
   
    }if(id == 4){
		$("#tapoursolution-1").removeClass('active-tapselect')
		$("#tapoursolution-2").removeClass('active-tapselect')
		$("#tapoursolution-3").removeClass('active-tapselect')
		$("#tapoursolution-4").addClass('active-tapselect')
		$("#tapoursolution-5").removeClass('active-tapselect')


		$("#tapoursolution-data-4").css("display",'block')
      
    }if(id == 5){
        $("#tapoursolution-1").removeClass('active-tapselect')
        $("#tapoursolution-2").removeClass('active-tapselect')
        $("#tapoursolution-3").removeClass('active-tapselect')
        $("#tapoursolution-4").removeClass('active-tapselect')
        $("#tapoursolution-5").addClass('active-tapselect')


        $("#tapoursolution-data-5").css("display",'block')
    }
}

function tapproductcat(id) {
    $("#tapproductcat-data-1").css("display",'none')
    $("#tapproductcat-data-2").css("display",'none')
    $("#tapproductcat-data-3").css("display",'none')
    $("#tapproductcat-data-4").css("display",'none')
    $("#tapproductcat-data-5").css("display",'none')
 

    if(id == 1){
		$("#tapproductcat-1").addClass('active-tapselect')
		$("#tapproductcat-2").removeClass('active-tapselect')
		$("#tapproductcat-3").removeClass('active-tapselect')
		$("#tapproductcat-4").removeClass('active-tapselect')
		$("#tapproductcat-5").removeClass('active-tapselect')


		$("#tapproductcat-data-1").css("display",'block')
    
    }if(id == 2){
		$("#tapproductcat-1").removeClass('active-tapselect')
		$("#tapproductcat-2").addClass('active-tapselect')
		$("#tapproductcat-3").removeClass('active-tapselect')
		$("#tapproductcat-4").removeClass('active-tapselect')
		$("#tapproductcat-5").removeClass('active-tapselect')


		$("#tapproductcat-data-2").css("display",'block')
    
    }if(id == 3){
		$("#tapproductcat-1").removeClass('active-tapselect')
		$("#tapproductcat-2").removeClass('active-tapselect')
		$("#tapproductcat-3").addClass('active-tapselect')
		$("#tapproductcat-4").removeClass('active-tapselect')
		$("#tapproductcat-5").removeClass('active-tapselect')


		$("#tapproductcat-data-3").css("display",'block')
   
    }if(id == 4){
        $("#tapproductcat-1").removeClass('active-tapselect')
        $("#tapproductcat-2").removeClass('active-tapselect')
        $("#tapproductcat-3").removeClass('active-tapselect')
        $("#tapproductcat-4").addClass('active-tapselect')
        $("#tapproductcat-5").removeClass('active-tapselect')


        $("#tapproductcat-data-4").css("display",'block')
      
    }if(id == 5){
        $("#tapproductcat-1").removeClass('active-tapselect')
        $("#tapproductcat-2").removeClass('active-tapselect')
        $("#tapproductcat-3").removeClass('active-tapselect')
        $("#tapproductcat-4").removeClass('active-tapselect')
        $("#tapproductcat-5").addClass('active-tapselect')


        $("#tapproductcat-data-5").css("display",'block')
    }
}
/*
$(document).ready(function() {
	if($(window).width() < 670) {
		// window.location.reload();
		$(".procat").attr("src", "/assets/fontend/hax_theme/images/adobepack-m.webp");
	} else {
		// window.location.reload();
		$(".procat").attr("src", "/assets/fontend/hax_theme/images/adobepack.webp");
	}
});
*/
var old_size = $( window ).width();

$( window ).resize(function() {
	if(old_size >= 670 && $( window ).width() <= 670){
		window.location.reload();
	}
	else if(old_size <= 671 && $( window ).width() >= 671){
		window.location.reload();
	}
	old_size = $( window ).width();
});

// เปิด modal เมื่อกดปุ่มเข้าสู่ระบบ (ทั้ง desktop/mobile)
$(document).ready(function () {
	// เปิด modal
	$(document).on('click', '.bt-loginaline', function () {
		const $modal = $('.modal-loginbysosocial').first();

		$modal.removeClass('out').addClass('loginbysosocial');
		$('body').addClass('modal-active');
	});

	// ปิด modal
	$(document).on('click', '.closereglogin', function () {
		const $modal = $(this).closest('.modal-loginbysosocial');

		$modal.removeClass('loginbysosocial').addClass('out');
		$('body').removeClass('modal-active');
	});

	// ป้องกันเปิดตอนโหลด
	$('.modal-loginbysosocial').removeClass('loginbysosocial out');
});

//  ป้องกันคลิก modal ด้านในแล้วลามไปพื้นหลัง
$(document).on('click', '.modal', function (e) {
	e.stopPropagation();
});

// icon eye password 
function togglePassword(label) {
	const input = document.getElementById(label.htmlFor);
	const eyeOff = label.querySelector('.eye-off');
	const eyeOn = label.querySelector('.eye-on');

	if (input.type === "password") {
		input.type = "text";
		eyeOff.style.display = "none";
		eyeOn.style.display = "inline";
	} else {
		input.type = "password";
		eyeOff.style.display = "inline";
		eyeOn.style.display = "none";
	}
}

var openornot = false
var openornot2 = false
function sup_menu(id){
	if(id == 1){
		if(!openornot){
			openornot = !openornot
			$('#menu1').addClass('active')
			$('.sup-menu-product-category').css('top','136px')
			$('.bg-filter-menu').css('display','block')
			$('html').css('overflow','hidden')
			document.getElementById("iconmenu1").src = "/assets/fontend/hax_theme/images/icon-cat-w.webp";
			document.getElementById("iconmenuarrow1").src = "/assets/fontend/hax_theme/images/icon-small-up-w.webp";

			// เมนู2
			/*
			openornot2 = false
			$('#menu2').removeClass('active')
			$('.sup-menu-business-solutions').css('top','-880px')
			document.getElementById("iconmenu2").src = "/assets/fontend/hax_theme/images/icon-solution.webp";
			document.getElementById("iconmenuarrow2").src = "/assets/fontend/hax_theme/images/icon-small-dropdown.webp";
			*/
		}
		else{
			openornot = !openornot
			$('#menu1').removeClass('active')
			$('.sup-menu-product-category').css('top','-884px')
			$('.bg-filter-menu').css('display','none')
			$('html').css('overflow','')
			document.getElementById("iconmenu1").src = "/assets/fontend/hax_theme/images/icon-cat.webp";
			document.getElementById("iconmenuarrow1").src = "/assets/fontend/hax_theme/images/icon-small-dropdown.webp";
		}
	}

	if(id == 2){
		if(!openornot2){
			openornot2 = !openornot2
			$('#menu2').addClass('active')
			$('.sup-menu-business-solutions').css('top','136px')
			$('.bg-filter-menu').css('display','block')
			$('html').css('overflow','hidden')
			document.getElementById("iconmenu2").src = "/assets/fontend/hax_theme/images/icon-solution-w.webp";
			document.getElementById("iconmenuarrow2").src = "/assets/fontend/hax_theme/images/icon-small-up-w.webp";

			// เมนู1
			openornot = false
			$('#menu1').removeClass('active')
			$('.sup-menu-product-category').css('top','-884px')
			document.getElementById("iconmenu1").src = "/assets/fontend/hax_theme/images/icon-cat.webp";
			document.getElementById("iconmenuarrow1").src = "/assets/fontend/hax_theme/images/icon-small-dropdown.webp";

		}
		else{
			openornot2 = !openornot2
			$('#menu2').removeClass('active')
			$('.sup-menu-business-solutions').css('top','-880px')
			$('.bg-filter-menu').css('display','none')
			$('html').css('overflow','')
			document.getElementById("iconmenu2").src = "/assets/fontend/hax_theme/images/icon-solution.webp";
			document.getElementById("iconmenuarrow2").src = "/assets/fontend/hax_theme/images/icon-small-dropdown.webp";
		}
	}
}

const tabs = document.querySelectorAll('.categories-title-box');
const contents = document.querySelectorAll('.sup-menu-content');

tabs.forEach(tab => {
	tab.addEventListener('click', () => {
		// 1. ลบ active จากทุกอัน
		tabs.forEach(t => t.classList.remove('active'));

		// 2. ใส่ active ที่ถูกคลิก
		tab.classList.add('active');

		// 3. ดึงชื่อ category จาก data
		const category = tab.getAttribute('data-category');

		// 4. ซ่อนทุกเนื้อหา
		contents.forEach(c => c.style.display = 'none');

		// 5. แสดงเนื้อหาเฉพาะอันที่เลือก
		const contentToShow = document.getElementById('category-' + category);
		if (contentToShow) {
			contentToShow.style.display = 'block';
		}
	});
});

const menuItems = document.querySelectorAll('.menu-item');
const mainMenu = document.getElementById('menu-mobile-main');
const submenus = document.querySelectorAll('.sup-submenu-mobile');

menuItems.forEach(item => {
	item.addEventListener('click', () => {
		const submenuId = 'submenu-' + item.getAttribute('data-submenu');
		mainMenu.style.display = 'none';
		submenus.forEach(sub => sub.style.display = 'none');
		document.getElementById(submenuId).style.display = 'block';
	});
});

function showMainMenu() {
	mainMenu.style.display = 'block';
	submenus.forEach(sub => sub.style.display = 'none');
}

function runCounters() {
  const counters = document.querySelectorAll('.num-txt-l');
  const speed = 120; // เพิ่มจาก 50 เป็น 120 (ค่ามากขึ้น = วิ่งช้าลง)
  counters.forEach(counter => {
    const target = parseInt(counter.getAttribute('data-target'));
    let count = 0;
    clearInterval(counter._interval);

    counter.textContent = '0+';

    counter._interval = setInterval(() => {
      count += Math.ceil(target / speed);
      if (count < target) {
        counter.textContent = count + '+';
      } else {
        counter.textContent = target + '+';
        clearInterval(counter._interval);
      }
    }, 35); // เพิ่ม interval จาก 20 เป็น 35ms
  });
}

document.addEventListener("DOMContentLoaded", function () {
    runCounters();

    const infoLeft = document.querySelector('.info-left');
    if (infoLeft) {
        infoLeft.addEventListener('mouseenter', runCounters);
    }
});

function toggleCategory(header) {
  const subMenu = header.nextElementSibling;

  if (subMenu.classList.contains("hidden")) {
    subMenu.classList.remove("hidden");
    header.classList.remove("active");
  } else {
    subMenu.classList.add("hidden");
    header.classList.add("active");
  }
}
