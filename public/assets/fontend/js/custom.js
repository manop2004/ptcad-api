if ('loading' in HTMLImageElement.prototype) {
    const images = document.querySelectorAll('img[loading="lazy"]');
    images.forEach(img => {
      img.src = img.dataset.src;
    });
} else {
    /* Dynamically import the LazySizes library*/
    const script = document.createElement('script');
    script.src =
      'https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.1.2/lazysizes.min.js';
    document.body.appendChild(script);
}
function deleteChild(e){
    $(e).closest('.child_div').remove();
}

if ($(".primary-menu-click").length != 0) {
    $(".primary-menu-click").click(function() {
        document.getElementById("myMenuPrimaryMenu").style.display = "block";
    });
}
if ($("#primary-menu-click-cloase").length != 0) {
    $("#primary-menu-click-cloase").click(function() {
        document.getElementById("myMenuPrimaryMenu").style.display = "none";
    });
}

$("#addMoreFile").click(function() {

    var msg = '';
    msg = '<div class="child_div bottommargin-xs">';
    msg += '<div class="row">';
    msg += '<div class="col-xs-11"><input type="file" accept="image/*" class="form-control" id="file" name="file[]"></div>';
    msg += '<div class="col-xs-1"><button onclick="deleteChild(this)" type="button" class="btn btn-danger btn-icon btn-sm"><i class="icon-trash2"></i></button></div>';
    msg += '</div>';

    $("#fileForm").append(msg)

});

$('.travel-date-group .format').datepicker({
    autoclose: true,
    format: "dd-mm-yyyy",
});

if ($("#wrapMenu").length != 0) {
    $("#wrapMenu").click(function() {
        document.getElementById("mySidenav").style.width = "100%";
    });
}
if ($("#wrapMenu-cloase").length != 0) {
    $("#wrapMenu-cloase").click(function() {
        document.getElementById("mySidenav").style.width = "0";
    });
}
$('#change_tab').change(function(){

    var tab = $(this).val();

    var selectTab = document.getElementsByClassName('select-tab');
    for(var i = 0; i < selectTab.length; i++){
        selectTab[i].style.display = "none";
    }

    document.getElementById(tab).style.display = "block";
});

$('.loadding').click(function(){
    var element = document.getElementById("displayLoagging");
    var elementSubmit = document.getElementById("btn-submit");
    if(element != null){
        element.classList.remove("display-none");
        elementSubmit.disabled = true
    }
});

$('.mc_im_sub').click(function(){

    var id = $(this).data('id');
    var x = document.getElementById("sub-"+id);

    if(x != null){
        if (x.style.display === "block") {
            x.style.display = "none";
        } else {
            x.style.display = "block";
        }
    }
});

$('.closebtnsub').click(function(){

    var id = $(this).data('id');
    var x = document.getElementById("sub-"+id);

    if(x != null){
        if (x.style.display === "block") {
            x.style.display = "none";
        } else {
            x.style.display = "block";
        }
    }
});

$('#option_select').change(function(){

    var detailId = $(this).val();

    $.ajax({
        dataType: "json",
        method: "get",
        url: "/api/jsonDetail",
        data: { detailId: detailId },
        cache: false,
        beforeSend: function () {
        },
        success: function (response) {

            $(".mini-head-sku span").html('SKU : '+response.sku);
            $(".mini-head-sub .btn_status_p").html(response.status);
            $(".main-price h1").html(response.price);
            $("#option-product-detailOther").html(response.detail);
            $("#_productSku").val(response.sku);

            var eliment = $(".mini-head-sub .btn_status_p");
            for( var i =0; i< eliment.length; i++){
                eliment[i].style.backgroundColor = response.background;
            }

            if(response.image.length != 0){
                document.getElementById('preview-item').src = response.image;

                var op = 0.1;  /*initial opacity */
                var preview =  document.getElementById('preview-item');
                var timer = setInterval(function () {
                    if (op >= 1){
                        clearInterval(timer);
                    }
                    preview.style.opacity = op;
                    preview.style.filter = 'alpha(opacity=' + op * 100 + ")";
                    op += op * 0.1;
                }, 30);
            }else{

                var old_src = document.getElementById('preview-item').src;
                if(old_src != response.picture){

                    document.getElementById('preview-item').src = response.picture;

                    var op = 0.1;  /* initial opacity */
                    var preview =  document.getElementById('preview-item');
                    var timer = setInterval(function () {
                        if (op >= 1){
                            clearInterval(timer);
                        }
                        preview.style.opacity = op;
                        preview.style.filter = 'alpha(opacity=' + op * 100 + ")";
                        op += op * 0.1;
                    }, 30);
                }

            }

            if(response.display == 1){

                var cart = $("#b-cart");
                for( var i =0; i< cart.length; i++){
                    cart[i].style.display = "none";
                }

            }else{
                var cart = $("#b-cart");
                for( var i =0; i< cart.length; i++){
                    cart[i].style.display = "flex";
                }
            }

        },
        failure: function (errMsg) {
            alert(errMsg);
        }
    });

});

$('.btn-option').click(function(){

    var detailId = $(this).data('id');

    $.ajax({
        dataType: "json",
        method: "get",
        url: "/api/jsonDetail",
        data: { detailId: detailId },
        cache: false,
        beforeSend: function () {
        },
        success: function (response) {

            $(".mini-head-sku span").html('SKU : '+response.sku);
            $(".mini-head-sub .btn_status_p").html(response.status);
            $(".main-price h1").html(response.price);
            $("#option-product-detailOther").html(response.detail);
            $("#p_id_d").val(detailId);
            $("#_productSku").val(response.sku);

            var element = $(".mini-head-sub .btn_status_p");
            for( var i =0; i< element.length; i++){
                element[i].style.backgroundColor = response.background;
            }

            var btn = $(".btn-option");
            for( var i =0; i< btn.length; i++){
                btn[i].style.borderColor = "#707070";
                btn[i].style.color = "#707070";
            }

            var option = $(".option-"+detailId);
            for( var i =0; i< option.length; i++){
                option[i].style.borderColor = "#59BA41";
                option[i].style.color = "#59BA41";
            }

            if(response.image.length != 0){
                document.getElementById('preview-item').src = response.image;

                var op = 0.1;  /* initial opacity */
                var preview =  document.getElementById('preview-item');
                var timer = setInterval(function () {
                    if (op >= 1){
                        clearInterval(timer);
                    }
                    preview.style.opacity = op;
                    preview.style.filter = 'alpha(opacity=' + op * 100 + ")";
                    op += op * 0.1;
                }, 30);
            }else{

                var old_src = document.getElementById('preview-item').src;
                if(old_src != response.picture){

                    document.getElementById('preview-item').src = response.picture;

                    var op = 0.1;  /* initial opacity */
                    var preview =  document.getElementById('preview-item');
                    var timer = setInterval(function () {
                        if (op >= 1){
                            clearInterval(timer);
                        }
                        preview.style.opacity = op;
                        preview.style.filter = 'alpha(opacity=' + op * 100 + ")";
                        op += op * 0.1;
                    }, 30);
                }

            }

            if(response.display == 1){

                var cart = $("#b-cart");
                for( var i =0; i< cart.length; i++){
                    cart[i].style.display = "none";
                }

            }else{
                var cart = $("#b-cart");
                for( var i =0; i< cart.length; i++){
                    cart[i].style.display = "flex";
                }
            }

        },
        failure: function (errMsg) {
            alert(errMsg);
        }
    });

});

$(".minus").click(function() {

    var quantity = $('#quantity').val();

    if(quantity > 1){
        quantity = quantity - 1;
        $("#quantity").val(quantity);
        $("#_productUnit").val(quantity);
    }

});

$(".plus").click(function() {
    var quantity = $('#quantity').val();

	quantity = (quantity*1) + 1;

	$("#quantity").val(quantity);
    $("#_productUnit").val(quantity);
});

$(".cart .minus").click(function() {
    var id = $(this).data('id');
    var quantity = $('#quantity-'+id).val();

    if(quantity > 1){
        quantity = quantity - 1;
        $('#quantity-'+id).val(quantity);
    }

    $.ajax({
        dataType: "json",
        method: "get",
        url: "/cart/update",
        data: {
            rowId: id,
            quantity:quantity,
        },
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        cache: false,
        beforeSend: function () {
        },
        success: function (response) {

        },
        failure: function (errMsg) {
            alert(errMsg);
        }
    });

});

$(".cart .plus").click(function() {
	var id = $(this).data('id');
	var quantity = $('#quantity-'+id).val();

	quantity = (quantity*1) + 1;
	$('#quantity-'+id).val(quantity);

    $.ajax({
        dataType: "json",
        method: "get",
        url: "/cart/update",
        data: {
            rowId: id,
            quantity:quantity,
        },
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        cache: false,
        beforeSend: function () {
        },
        success: function (response) {

        },
        failure: function (errMsg) {
            alert(errMsg);
        }
    });

});

$(".cart .qty").blur(function() {
	var id = $(this).data('id');
	var quantity = $('#quantity-'+id).val();

	$('#quantity-'+id).val(quantity);

    $.ajax({
        dataType: "json",
        method: "get",
        url: "/cart/update",
        data: {
            rowId: id,
            quantity:quantity,
        },
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        cache: false,
        beforeSend: function () {
        },
        success: function (response) {

        },
        failure: function (errMsg) {
            alert(errMsg);
        }
    });

});

$('.b-cart-one').click( function(){

    var proId = $(this).data('id');

    if($('#quantity').val() == null){
        var quantity = 1;
    }else{
        var quantity = $('#quantity').val();
    }
	
	if($('#ref').val() == null){
        var ref = '';
    }else{
        var ref = $('#ref').val();
    }

    $.ajax({
        dataType: "json",
        method: "post",
        url: "/cart/add/one",
        data: {
            proId: proId,
            quantity:quantity,
            ref:ref
        },
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        cache: false,
        beforeSend: function () {
        },
        success: function (response) {

            if(response.length != 0){

                $.each(response, function (index, item) {

                    $('.cart_show_quantity').html(item.TotalQuantity);

                    if(item.detail_name != 'null'){
                        if(item.detail_other != 'null'){
                            var proname = item.detail_name+'<br/>'+item.detail_other;
                        }else{
                            var proname = item.detail_name;
                        }
                    }else{
                        var proname = item.pro_name;
                    }

                    if(item.pricesale != ""){
                        var price = numberWithCommas(item.pricesale);
                        var pricesale = numberWithCommas(item.price);
                    }else{
                        var price = numberWithCommas(item.price);
                        var pricesale = '';
                    }

                    document.getElementById('popup_cart').style.display = 'grid';

                    var popup = '<div class="cart-popup">';
                        popup += '<img src="/icon/others/icon-check-circle.png" class="icon-succress" /> สำเร็จ';
                        popup += '<div onclick="closePopup()" class="btn cart-popup-close">X</div>';
                        popup += '<div class="clearfix"></div>';
                        popup += '<br/>สินค้าได้ถูกเพิ่มใส่ตระกร้า<br/><br/>';
                        popup += '<div class="cart-popup-grid">';
                        popup += '<img class="cart-popup-img" src="'+item.picture_name+'"/>';
                        popup += '<div>';
                        popup += '<div>'+proname+'</div>';
                        popup += '<div class="cart-popup-price">฿ '+price+'</div>';
                        popup += '<div class="cart-popup-pricesale">'+pricesale+'</div>';
                        popup += '</div>';
                        popup += '</div>';
                        popup += '<hr/>';
                        popup += '<div class="cart-popup-btn">';
                        popup += '<a href="/cart" class="btn btn-goto-cart"></a>';
                        popup += '<a href="/category" class="btn btn-goto-product"></a>';
                        popup += '<div/>';
                        popup += '</button>';


                    $('#popup_cart').html(popup);

                });

            }

        },
        failure: function (errMsg) {
            alert(errMsg);
        }
    });

})

$('.b-carttwo').click( function(){

    var proId = $('#p_id').val();
	
	if(proId == 234){
		
		$('#Modal_Body').html('');
		$('#Modal_Body').html('<center>แบบสอบถามเงื่อนไขในการสั่งซื้อ โปรแกรม Chaos V-Ray<hr><img src="/public/ckfinder/userfiles/images/V-Ray.jpg" width="100"><br><br><h2 style="color:#e74c3c;">คุณได้รับแจ้งเกี่ยวกับเงื่อนไข LC หรือไม่ ?</h2><small>License compliance (LC) หมายถึงการใช้ซอฟต์แวร์ตามข้อกำหนดและเงื่อนไขของข้อตกลงสิทธิ์การใช้งานซอฟต์แวร์</small><br><br><button type="button" class="btn btn-primary btn-lg" onClick="VRayLC(\'yes\');">ใช่</button> &nbsp; <button type="button" class="btn btn-default btn-lg" onClick="addCartVray(\'\');" data-dismiss="modal">ไม่ใช่</button></center>');
		$('#ModalPage').modal('show');
		
		return false;
		
	}else{
		
		var quantity = $('#quantity').val();
		var option = $('#p_option').val();

		if(option == 2){
			var detailId = $('#p_id_d').val();
		}else{
			var detailId = $('#option_select').val();
		}
		
		if($('#ref').val() == null){
			var ref = '';
		}else{
			var ref = $('#ref').val();
		}
		
		$.ajax({
			dataType: "json",
			method: "post",
			url: "/cart/add/two",
			data: {
				proId: proId,
				detailId: detailId,
				quantity:quantity,
				ref:ref
			},
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			cache: false,
			beforeSend: function () {
			},
			success: function (response) {

				if(response.length != 0){

					$.each(response, function (index, item) {

						$('.cart_show_quantity').html(item.TotalQuantity);

						if(item.detail_name != null){
							if(item.detail_other != null){
								var proname = item.pro_name+'<br/>'+item.detail_name+'<br/>'+item.detail_other;
							}else{
								var proname = item.pro_name+'<br/>'+item.detail_name;
							}
						}else{
							var proname = item.pro_name;
						}

						if(item.pricesale != ""){
							var price = numberWithCommas(item.pricesale);
							var pricesale = numberWithCommas(item.price);
						}else{
							var price = numberWithCommas(item.price);
							var pricesale = '';
						}

						document.getElementById('popup_cart').style.display = 'grid';

						var popup = '<div class="cart-popup">';
							popup += '<img src="/icon/others/icon-check-circle.png" class="icon-succress" /> สำเร็จ';
							popup += '<div onclick="closePopup()" class="btn cart-popup-close">X</div>';
							popup += '<div class="clearfix"></div>';
							popup += '<br/>สินค้าได้ถูกเพิ่มใส่ตระกร้า<br/><br/>';
							popup += '<div class="cart-popup-grid">';
							popup += '<img class="cart-popup-img" src="'+item.picture_name+'"/>';
							popup += '<div>';
							popup += '<div>'+proname+'</div>';
							popup += '<div class="cart-popup-price">฿ '+price+'</div>';
							popup += '<div class="cart-popup-pricesale">'+pricesale+'</div>';
							popup += '</div>';
							popup += '</div>';
							popup += '<hr/>';
							popup += '<div class="cart-popup-btn">';
							popup += '<a href="/cart" class="btn btn-goto-cart"></a>';
							popup += '<a href="/category" class="btn btn-goto-product"></a>';
							popup += '<div/>';
							popup += '</button>';

						$('#popup_cart').html(popup);

					});

				}


			},
			failure: function (errMsg) {
				alert(errMsg);
			}
		});
		
	}

})

function closePopup(){

    document.getElementById('popup_cart').style.display = 'none';
}

function numberWithCommas(x) {

    let number   = x
    let decimals = 2
    let decpoint = '.' /* Or Number(0.1).toLocaleString().substring(1, 2) */
    let thousand = ',' /* Or Number(10000).toLocaleString().substring(2, 3) */

    let n = Math.abs(number).toFixed(decimals).split('.')
    n[0] = n[0].split('').reverse().map((c, i, a) =>
    i > 0 && i < a.length && i % 3 == 0 ? c + thousand : c
    ).reverse().join('')
    let final = (Math.sign(number) < 0 ? '-' : '') + n.join(decpoint)

    return final;
}

function itemPic(e){

    var url = $(e).data('img');
    document.getElementById('preview-item').src = url;

    var oldClick = $('.item-pic');
    for( var i =0; i< oldClick.length; i++){
        oldClick[i].style.borderColor = "#707070";
    }

    var newClick = $(e);
    for( var i =0; i< newClick.length; i++){
        newClick[i].style.borderColor = "#59BA41";
    }

    var op = 0.1;  /* initial opacity */
    var element =  document.getElementById('preview-item');
    var timer = setInterval(function () {
        if (op >= 1){
            clearInterval(timer);
        }
        element.style.opacity = op;
        element.style.filter = 'alpha(opacity=' + op * 100 + ")";
        op += op * 0.1;
    }, 30);



};

$('.qty').keypress( function(){
    var vchar = String.fromCharCode(event.keyCode);
	if (vchar<'1' || vchar>'9') return false;
});

$('.n_tel').keypress( function(){
    var phone = String.fromCharCode(event.keyCode);
    var RE = /^[\d\.\,\-]+$/;
    if(!RE.test(phone))
    {
        return false;
    }
    return true;
});
$('.c_email').keypress( function(){
    var email = String.fromCharCode(event.keyCode);
    var RE = /^([a-zA-Z@0-9._])+$/;
    if(!RE.test(email))
    {
        return false;
    }
    return true;
});

/* payment */
$('#radio-bank').click( function(){

    var bank = document.getElementById("content-bank");
    var installment = document.getElementById("content-installment");
    var creditcard = document.getElementById("content-creditcard");
    var promptpay = document.getElementById("content-promptpay");
    var mobile_banking = document.getElementById("content-mobile_banking");
    var truemoney = document.getElementById("content-truemoney");

    bank.style.display = "block";
    installment.style.display = "none";
    creditcard.style.display = "none";
    promptpay.style.display = "none";
    mobile_banking.style.display = "none";
    truemoney.style.display = "none";

});
$('#radio-installment').click( function(){

    var bank = document.getElementById("content-bank");
    var installment = document.getElementById("content-installment");
    var creditcard = document.getElementById("content-creditcard");
    var promptpay = document.getElementById("content-promptpay");
    var mobile_banking = document.getElementById("content-mobile_banking");
    var truemoney = document.getElementById("content-truemoney");

    bank.style.display = "none";
    installment.style.display = "block";
    creditcard.style.display = "none";
    promptpay.style.display = "none";
    mobile_banking.style.display = "none";
    truemoney.style.display = "none";

});
$('#radio-creditcard').click( function(){

    var bank = document.getElementById("content-bank");
    var installment = document.getElementById("content-installment");
    var creditcard = document.getElementById("content-creditcard");
	var promptpay = document.getElementById("content-promptpay");
    var mobile_banking = document.getElementById("content-mobile_banking");
    var truemoney = document.getElementById("content-truemoney");

    bank.style.display = "none";
    installment.style.display = "none";
    creditcard.style.display = "block";
	promptpay.style.display = "none";
    mobile_banking.style.display = "none";
    truemoney.style.display = "none";

});
$('#radio-promptpay').click( function(){

    var bank = document.getElementById("content-bank");
    var installment = document.getElementById("content-installment");
    var creditcard = document.getElementById("content-creditcard");
	var promptpay = document.getElementById("content-promptpay");
    var mobile_banking = document.getElementById("content-mobile_banking");
    var truemoney = document.getElementById("content-truemoney");

    bank.style.display = "none";
    installment.style.display = "none";
    creditcard.style.display = "none";
	promptpay.style.display = "block";
    mobile_banking.style.display = "none";
    truemoney.style.display = "none";

});
$('#radio-mobile_banking').click( function(){

    var bank = document.getElementById("content-bank");
    var installment = document.getElementById("content-installment");
    var creditcard = document.getElementById("content-creditcard");
	var promptpay = document.getElementById("content-promptpay");
    var mobile_banking = document.getElementById("content-mobile_banking");
    var truemoney = document.getElementById("content-truemoney");

    bank.style.display = "none";
    installment.style.display = "none";
    creditcard.style.display = "none";
	promptpay.style.display = "none";
    mobile_banking.style.display = "block";
    truemoney.style.display = "none";

});
$('#radio-truemoney').click( function(){

    var bank = document.getElementById("content-bank");
    var installment = document.getElementById("content-installment");
    var creditcard = document.getElementById("content-creditcard");
	var promptpay = document.getElementById("content-promptpay");
    var mobile_banking = document.getElementById("content-mobile_banking");
    var truemoney = document.getElementById("content-truemoney");

    bank.style.display = "none";
    installment.style.display = "none";
    creditcard.style.display = "none";
	promptpay.style.display = "none";
    mobile_banking.style.display = "none";
    truemoney.style.display = "block";
	
});


function OmiseSubmit(){

    /* payment omise */
    var public_key_omise = $('#public_key_omise').val();

    if(public_key_omise != null){

        Omise.setPublicKey(public_key_omise);

        $("#paymentForm").submit(function () {

            $("#token_errors").html('รอสักครู่...');

            var form = $(this);

            /*  Disable the submit button to avoid repeated click. */
            form.find("button[id=btn_creditcard]").prop("disabled", true);
            /* Serialize the form fields into a valid card object. */
            var card = {
                "name": form.find("[data-omise=holder_name]").val(),
                "number": form.find("[data-omise=number]").val(),
                "expiration_month": form.find("[data-omise=expiration_month]").val(),
                "expiration_year": form.find("[data-omise=expiration_year]").val(),
                "security_code": form.find("[data-omise=security_code]").val()
            };

            /* the callback. */
            Omise.createToken("card", card, function (statusCode, response) {

                if (response.object == "error") {
                    /* Display an error message. */
                    $("#token_errors").html(response.message);

                    /* Re-enable the submit button. */
                    form.find("button[id=btn_creditcard]").prop("disabled", false);
                } else {
                    /* Then fill the omise_token. */
                    form.find("[name=omise_token]").val(response.id);
                    form.find("button[id=btn_creditcard]").prop("disabled", true);
                    $("#token_errors").addClass('success').html('กรุณารอสักครู่... กำลังเปลี่ยนเสร็จทางไปยังระบบชำระเงินใน 3 วินาที.');

                    setTimeout(function(){
                        form.get(0).submit();
                    }, 3000);
                    /* And submit the form. */
                };
            });

            return false;
        });

    }

}

$('#chkReceipt').click( function(){

    var receipts = document.getElementById("cart-tabs-receipts");
    if(receipts != null){
        if (receipts.style.display === "block") {
            receipts.style.display = "none";
        } else {
            receipts.style.display = "block";
        }
    }

});

/* register */
$('.getUsercode').click( function(){
    /* Get the text field */
    var copyText = document.getElementById("user_code");

    /* Select the text field */
    copyText.select();
    copyText.setSelectionRange(0, 99999); /* For mobile devices */

    /* Copy the text inside the text field */
    navigator.clipboard.writeText(copyText.value);
})

$('.ckUser').click( function(){

    var user = document.getElementById("show-user");
    var company = document.getElementById("show-company");

    if(user != null){
        if (user.style.display === "block") {
            user.style.display = "none";
            company.style.display = "block";
        } else {
            user.style.display = "block";
            company.style.display = "none";
        }
    }

});

$('.chkUser_account').click( function(){
    var c = document.getElementById('myCompany');
    var d = document.getElementById('head_fullname');
    var e = document.getElementById('head_fullname_contact');
    var g = document.getElementById('myPosition');
    if (c.style.display === 'block') {
        c.style.display = 'none';
        d.style.display = 'block';
        e.style.display = 'none';
        g.style.display = 'block';
    } else {
        c.style.display = 'none';
        d.style.display = 'none';
        e.style.display = 'block';
        g.style.display = 'none';
    }
});

$('.chkCompany_account').click( function(){
    var x = document.getElementById('myCompany');
    var d = document.getElementById('head_fullname');
    var e = document.getElementById('head_fullname_contact');
    var g = document.getElementById('myPosition');
    if (x.style.display === 'none') {
        x.style.display = 'block';
        d.style.display = 'none';
        e.style.display = 'block';
        g.style.display = 'none';
    } else {
        x.style.display = 'block';
        d.style.display = 'none';
        e.style.display = 'block';
        g.style.display = 'block';
    }
});

$('.ckCompany').click( function(){

    var user = document.getElementById("show-user");
    var company = document.getElementById("show-company");

    if(company != null){
        if (company.style.display === "block") {
            company.style.display = "none";
            user.style.display = "block";
        } else {
            company.style.display = "block";
            user.style.display = "none";
        }
    }

});

function readURL1(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#blah1').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

/* select province address */
function amphuresAddress(){

    var province = $('#province').val();
    $.ajax({
        type: "GET",
        url: '/api/amphure',
        data: { id: province},
        cache: false,
        beforeSend: function () {},
        success: function (response) {

            $("#amphures").html('<option></option>');
            $("#district").html('<option></option>');
            $("#zipcode").val('');

            if(response != ""){
                $.each(response, function (index, item) {
                    $("#amphures").append(
                        '<option value="' + item.id + '">' + item.amp_name_th + "</option>"
                    );
                });
            }else{
                $("#amphures").append(
                    '<option value="">ไม่มีข้อมูล</option>'
                );
            }

        },
        failure: function (errMsg) {
            alert(errMsg);
        }
    });
}

function districtAddress(){

    var amphures = $('#amphures').val();

    $.ajax({
        type: "GET",
        url: '/api/district',
        data: { amphureId: amphures},
        cache: false,
        beforeSend: function () {},
        success: function (response) {

            $("#district").html('<option></option>');
            $("#zipcode").val('');

            if(response != ""){
                $.each(response, function (index, item) {
                    $("#district").append(
                        '<option value="' + item.id + '">' + item.dis_name_th + "</option>"
                    );
                });
            }else{
                $("#district").html('<option></option>');
            }

        },
        failure: function (errMsg) {
            alert(errMsg);
        }
    });
}

function zipcodeAddress(){

    var district = $('#district').val();

    $.ajax({
        type: "GET",
        url: '/api/zipcode',
        data: { districtId : district },
        cache: false,
        beforeSend: function () { },
        success: function (response) {

            $.each(response, function (index, item) {
                $('#zipcode').val(item.zipcode);
            });

        },
        failure: function (errMsg) {
            alert(errMsg);
        }
    });

}

/* select province address */
function amphuresReceipt(){

    var province = $('#receipt_province').val();
    $.ajax({
        type: "GET",
        url: '/api/amphure',
        data: { id: province},
        cache: false,
        beforeSend: function () {},
        success: function (response) {

            $("#receipt_amphures").html('<option></option>');
            $("#receipt_district").html('<option></option>');
            $("#receipt_zipcode").val('');

            if(response != ""){
                $.each(response, function (index, item) {
                    $("#receipt_amphures").append(
                        '<option value="' + item.id + '">' + item.amp_name_th + "</option>"
                    );
                });
            }else{
                $("#receipt_amphures").append(
                    '<option value="">ไม่มีข้อมูล</option>'
                );
            }

        },
        failure: function (errMsg) {
            alert(errMsg);
        }
    });
}

function districtReceipt(){

    var amphures = $('#receipt_amphures').val();

    $.ajax({
        type: "GET",
        url: '/api/district',
        data: { amphureId: amphures},
        cache: false,
        beforeSend: function () {},
        success: function (response) {

            $("#receipt_district").html('<option></option>');
            $("#receipt_zipcode").val('');

            if(response != ""){
                $.each(response, function (index, item) {
                    $("#receipt_district").append(
                        '<option value="' + item.id + '">' + item.dis_name_th + "</option>"
                    );
                });
            }else{
                $("#receipt_district").html('<option></option>');
            }

        },
        failure: function (errMsg) {
            alert(errMsg);
        }
    });
}

function zipcodeReceipt(){

    var district = $('#receipt_district').val();

    $.ajax({
        type: "GET",
        url: '/api/zipcode',
        data: { districtId : district },
        cache: false,
        beforeSend: function () { },
        success: function (response) {

            $.each(response, function (index, item) {
                $('#receipt_zipcode').val(item.zipcode);
            });

        },
        failure: function (errMsg) {
            alert(errMsg);
        }
    });

}

/* add localStorage favorites */
$('.add-favorite').click( function(){

    var proId = $(".add-favorite").attr("data-id");
    var proImg = $(".add-favorite").attr("data-img");
    var proParmalink = $(".add-favorite").attr("data-parmalink");
    var proName = $(".add-favorite").attr("data-name");
    var proPrice = $(".add-favorite").attr("data-price");

    data = [ ];

    if(localStorage.getItem('favorites') != null && localStorage.getItem('favorites') != ''){

        var data = {
            id:proId,
            name:proName,
            img:proImg,
            parmalink:proParmalink,
            proPrice:proPrice
        };

        products = JSON.parse(localStorage.getItem('favorites')) /* get old data */
        products.push(data)/* set new data */
        localStorage.setItem('favorites',JSON.stringify(products)) /* add old data & new data */

    }else{


        var data1 = {
            id:proId,
            name:proName,
            img:proImg,
            parmalink:proParmalink,
            proPrice:proPrice
        };

        data.push(data1)
        localStorage.setItem('favorites',JSON.stringify(data))

        /*var elementResult = $('.cart-form-result');
        /*elementResult.attr( 'data-notify-type', 'success' ).attr( 'data-notify-msg', "เพิ่มสินค้าลงในรายการโปรดเรียบร้อยแล้ว." ).attr('data-notify-position','bottom-left').html('');*/
        /*SEMICOLON.widget.notifications( elementResult );*/

    }

    /*check localStorage fav*/
    var jsonchk2 = JSON.parse(localStorage["favorites"]);
    for (i=0;i<jsonchk2.length;i++)
    if (jsonchk2[i].id == proId){

        /*มีรายการโปรด*/
        var element = document.getElementById("n-favorite");
        if(element != null){
            element.classList.remove("hidden");
        }

        var element = document.getElementById("b-favorite");
        if(element != null){
            element.classList.add("hidden");
        }

    }

    /* nav */
    var element = document.getElementById("span-favorite");
    if(element != null){
        element.classList.remove("hidden");
    }

    var countFavorites = JSON.parse(localStorage["favorites"]).length;
    $('#span-favorite').html(countFavorites);


});
/* remove localStorage favorites */
$('.remove-favorite').click( function(){

    var proId = $(".remove-favorite").attr("data-id");

    if(localStorage.getItem('favorites') != null && localStorage.getItem('favorites') != ''){
        products = JSON.parse(localStorage.getItem('favorites'))
    }else{
        products = []
    }

    var json = JSON.parse(localStorage["favorites"]);

    /* delete localStorage item */
    for (i=0;i<json.length;i++)
    if (json[i].id == proId) json.splice(i,1);
    localStorage["favorites"] = JSON.stringify(json);

    /* ไม่มีรายการโปรด */
    var element = document.getElementById("b-favorite");
    if(element != null){
        element.classList.remove("hidden");
    }
    var element = document.getElementById("n-favorite");
    if(element != null){
        element.classList.add("hidden");
    }

    /* nav */
    var countFavorites = JSON.parse(localStorage["favorites"]).length;
    $('#span-favorite').html(countFavorites);

});

function favorite_table(){

    var proId = $(".favorite_table").attr("data-id");
    console.log(proId);

    if(localStorage.getItem('favorites') != null && localStorage.getItem('favorites') != ''){
        products = JSON.parse(localStorage.getItem('favorites'))
    }else{
        products = []
    }

    var json = JSON.parse(localStorage["favorites"]);

    /* delete localStorage item */
    for (i=0;i<json.length;i++)
    if (json[i].id == proId) json.splice(i,1);
    localStorage["favorites"] = JSON.stringify(json);

    /* nav */
    var countFavorites = JSON.parse(localStorage["favorites"]).length;
    $('#span-favorite').html(countFavorites);

    location.reload();

}

$(function($) {

    /* select option input chang border */
    var detailId = $('#p_id_d').val();
    var option = $(".option-"+detailId);
    for( var i =0; i< option.length; i++){
        option[i].style.borderColor = "#59BA41";
        option[i].style.color = "#59BA41";
    }

    /* get province address */
    var address_province = $('#address_province').val();
    var address_amphures = $('#address_amphures').val();
    var address_district = $('#address_district').val();
    var address_zipcode  = $('#address_zipcode').val();

    if ($("#address_province").length != 0) {
        $.ajax({
            type: "GET",
            url: '/api/amphure',
            data: { id: address_province, amphureId: address_amphures},
            cache: false,
            beforeSend: function () {},
            success: function (response) {

                if(response != ""){
                    $.each(response, function (index, item) {
                        $("#amphures").append(
                            '<option value="' + item.id + '" ' + item.selected + '>' + item.amp_name_th + "</option>"
                        );
                    });
                }else{
                    $("#amphures").append(
                        '<option value="">ไม่มีข้อมูล</option>'
                    );
                }

            },
            failure: function (errMsg) {
                alert(errMsg);
            }
        });
    }

    if ($("#address_amphures").length != 0) {
        $.ajax({
            type: "GET",
            url: '/api/district',
            data: { amphureId: address_amphures, districtId:address_district},
            cache: false,
            beforeSend: function () {},
            success: function (response) {

                if(response != ""){
                    $.each(response, function (index, item) {
                        $("#district").append(
                            '<option value="' + item.id + '" ' + item.selected + '>' + item.dis_name_th + "</option>"
                        );
                    });
                }else{
                    $("#district").html('<option></option>');
                }

            },
            failure: function (errMsg) {
                alert(errMsg);
            }
        });
    }

    if ($("#address_district").length != 0) {
        $.ajax({
            type: "GET",
            url: '/api/zipcode',
            data: { districtId : address_district },
            cache: false,
            beforeSend: function () { },
            success: function (response) {

                if(address_zipcode != ''){
                    $('#zipcode').val(address_zipcode);
                }else{
                    $('#zipcode').val(response.zipcode);
                }

            },
            failure: function (errMsg) {
                alert(errMsg);
            }
        });
    }

    /* get province address */
    var receipt_province = $('#receipt_hd_province').val();
    var receipt_amphures = $('#receipt_hd_amphures').val();
    var receipt_district = $('#receipt_hd_district').val();
    var receipt_zipcode  = $('#receipt_hd_zipcode').val();

    if ($("#receipt_hd_province").length != 0) {
        $.ajax({
            type: "GET",
            url: '/api/amphure',
            data: { id: receipt_province, amphureId: receipt_amphures},
            cache: false,
            beforeSend: function () {},
            success: function (response) {

                if(response != ""){
                    $.each(response, function (index, item) {
                        $("#receipt_amphures").append(
                            '<option value="' + item.id + '" ' + item.selected + '>' + item.amp_name_th + "</option>"
                        );
                    });
                }else{
                    $("#receipt_amphures").append(
                        '<option value="">ไม่มีข้อมูล</option>'
                    );
                }

            },
            failure: function (errMsg) {
                alert(errMsg);
            }
        });
    }

    if ($("#receipt_hd_amphures").length != 0) {
        $.ajax({
            type: "GET",
            url: '/api/district',
            data: { amphureId: receipt_amphures, districtId:receipt_district},
            cache: false,
            beforeSend: function () {},
            success: function (response) {

                if(response != ""){
                    $.each(response, function (index, item) {
                        $("#receipt_district").append(
                            '<option value="' + item.id + '" ' + item.selected + '>' + item.dis_name_th + "</option>"
                        );
                    });
                }else{
                    $("#receipt_district").html('<option></option>');
                }

            },
            failure: function (errMsg) {
                alert(errMsg);
            }
        });
    }

    if ($("#receipt_hd_district").length != 0) {
        $.ajax({
            type: "GET",
            url: '/api/zipcode',
            data: { districtId : receipt_district },
            cache: false,
            beforeSend: function () { },
            success: function (response) {

                if(receipt_zipcode != ''){
                    $('#receipt_zipcode').val(receipt_zipcode);
                }else{
                    $('#receipt_zipcode').val(response.zipcode);
                }

            },
            failure: function (errMsg) {
                alert(errMsg);
            }
        });
    }


    if(localStorage.getItem('favorites') != null && localStorage.getItem('favorites') != ''){
        var countFavorites = JSON.parse(localStorage["favorites"]).length;

        if(countFavorites != 0){

            var element = document.getElementById("span-favorite");
            if(element != null){
                element.classList.remove("hidden");
            }

            $('#span-favorite').html(countFavorites);
            var localProId = $('#local-favourite').val();

            var jsonchk = JSON.parse(localStorage["favorites"]);
            for (i=0;i<jsonchk.length;i++)
            if (jsonchk[i].id == localProId){

                var element = document.getElementById("n-favorite");
                if(element != null){
                    element.classList.remove("hidden");
                }
                var element = document.getElementById("b-favorite");
                if(element != null){
                    element.classList.add("hidden");
                }

            }else{
                var element = document.getElementById("b-favorite");
                if(element != null){
                    element.classList.remove("hidden");
                }

                var element = document.getElementById("n-favorite");
                if(element != null){
                    element.classList.add("hidden");
                }

            }

            var fav_show = document.getElementById("favorites-show");
            if(fav_show != null){
                fav_show.classList.remove("hidden");
            }

            var fav_normal = document.getElementById("favorites-normal");
            if(fav_normal != null){
                fav_normal.classList.add("hidden");
            }

            var jsonlist = JSON.parse(localStorage["favorites"]);
            var favorites_table = [];
            $.each(jsonlist, function(key, value){

                favorites_table += '<tr class="cart_item">';
                favorites_table += '<td class="cart-product-remove"><button onclick="favorite_table()" class="remove favorite_table" data-id="'+value.id+'" title="Remove this item"><i class="icon-trash2"></i></button></td>';
                favorites_table += '<td class="cart-product-thumbnail"><a href="'+value.parmalink+'"><img width="64" height="64" src="'+value.img+'" alt="'+value.name+'"></a></td>';
                favorites_table += '<td class="cart-product-name">'+value.name+'</td>';
                favorites_table += '<td class="cart-product-subtotal text-right">'+value.proPrice+'</td>';
                favorites_table += '</tr>';

            });

            $('#favorites_table').append(favorites_table);

        }else{
            $('#span-favorite').html('0');
            var element = document.getElementById("b-favorite");
            if(element != null){
                element.classList.remove("hidden");
            }

            var fav_show = document.getElementById("favorites-show");
            if(fav_show != null){
                fav_show.classList.add("hidden");
            }

            var fav_normal = document.getElementById("favorites-normal");
            if(fav_normal != null){
                fav_normal.classList.remove("hidden");
            }

        }

    }else{
        $('#span-favorite').html('0');

        var element = document.getElementById("b-favorite");
        if(element != null){
            element.classList.remove("hidden");
        }

        var fav_show = document.getElementById("favorites-show");
        if(fav_show != null){
            fav_show.classList.add("hidden");
        }

        var fav_normal = document.getElementById("favorites-normal");
        if(fav_normal != null){
            fav_normal.classList.remove("hidden");
        }

    }


});

function VRayLC(ans){
	
	if(ans == 'yes'){
		
		$('#Modal_Body').html('');
		$('#Modal_Body').html('<center>แบบสอบถามเงื่อนไขในการสั่งซื้อ โปรแกรม V-Ray<hr><img src="/public/ckfinder/userfiles/images/V-Ray.jpg" width="100"><br><br><h2 style="color:#e74c3c;">การซื้อโปรแกรม Chaos V-Ray แบบ License compliance (LC) จะมีการเปลี่ยนแปลงเป็นราคาพิเศษ</h2></center><small>SKU : CEVR6PMa3YLC</small><br><small>ชื่อสินค้า : Chaos V-Ray Premium Floating License 3 years Subscription_OR</small><br><span>ราคา : <b style="color:#e74c3c; text-decoration: underline;">72,908 บาท</b></span><br><br><center><button type="button" class="btn btn-primary btn-lg" onClick="addCartVray(446);" data-dismiss="modal">ตกลง</button> &nbsp; <button type="button" class="btn btn-default btn-lg" data-dismiss="modal">ยกเลิก</button></center>');
		
	}else{
		
		$('#ModalPage').modal('hide');
		addCartVray();
		
	}
	
}

function addCartVray(option_custom){
	
	var proId = $('#p_id').val();
	var quantity = $('#quantity').val();
	var option = $('#p_option').val();

	if(option_custom != ''){
		
		var detailId = option_custom;
		
	}else{
		
		if(option == 2){
			var detailId = $('#p_id_d').val();
		}else{
			var detailId = $('#option_select').val();
		}
		
	}
	
	if($('#ref').val() == null){
		var ref = '';
	}else{
		var ref = $('#ref').val();
	}
	
	$.ajax({
		dataType: "json",
		method: "post",
		url: "/cart/add/two",
		data: {
			proId: proId,
			detailId: detailId,
			quantity:quantity,
			ref:ref
		},
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		cache: false,
		beforeSend: function () {
		},
		success: function (response) {

			if(response.length != 0){

				$.each(response, function (index, item) {

					$('.cart_show_quantity').html(item.TotalQuantity);

					if(item.detail_name != null){
						if(item.detail_other != null){
							var proname = item.pro_name+'<br/>'+item.detail_name+'<br/>'+item.detail_other;
						}else{
							var proname = item.pro_name+'<br/>'+item.detail_name;
						}
					}else{
						var proname = item.pro_name;
					}

					if(item.pricesale != ""){
						var price = numberWithCommas(item.pricesale);
						var pricesale = numberWithCommas(item.price);
					}else{
						var price = numberWithCommas(item.price);
						var pricesale = '';
					}

					document.getElementById('popup_cart').style.display = 'grid';

					var popup = '<div class="cart-popup">';
						popup += '<img src="/icon/others/icon-check-circle.png" class="icon-succress" /> สำเร็จ';
						popup += '<div onclick="closePopup()" class="btn cart-popup-close">X</div>';
						popup += '<div class="clearfix"></div>';
						popup += '<br/>สินค้าได้ถูกเพิ่มใส่ตระกร้า<br/><br/>';
						popup += '<div class="cart-popup-grid">';
						popup += '<img class="cart-popup-img" src="'+item.picture_name+'"/>';
						popup += '<div>';
						popup += '<div>'+proname+'</div>';
						popup += '<div class="cart-popup-price">฿ '+price+'</div>';
						popup += '<div class="cart-popup-pricesale">'+pricesale+'</div>';
						popup += '</div>';
						popup += '</div>';
						popup += '<hr/>';
						popup += '<div class="cart-popup-btn">';
						popup += '<a href="/cart" class="btn btn-goto-cart"></a>';
						popup += '<a href="/category" class="btn btn-goto-product"></a>';
						popup += '<div/>';
						popup += '</button>';

					$('#popup_cart').html(popup);

				});

			}


		},
		failure: function (errMsg) {
			alert(errMsg);
		}
	});
	
}
