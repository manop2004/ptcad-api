$(".main-menu").hover(function () {
    $('.main-menu').removeClass("active");

    $(this).toggleClass("active");
    var id = $(this).data('id');
	var ref = $('#ref').val();
	var ref_url = '';
	if(ref != ''){
		ref_url = ref;
	}

    $.ajax({
        dataType: "json",
        method: "get",
        url: "/api/getSubcategory",
        data: { id: id },
        cache: false,
        beforeSend: function () {
        },
        success: function (response) {

            console.log(response);

            if (response != 0) {

                $("#sub-menu-primary").html('');
                $.each(response, function (index, item) {
                    $("#sub-menu-primary").append(
                        "<a class='sub-menu' href='/category/"+item.categorysub_permalink+""+ref_url+"'><div>"+item.categorysub_name+"</div></a>"
                    );
                });


            }else{
                $("#sub-menu-primary").html('');
            }

        },
        failure: function (errMsg) {
            alert(errMsg);
        }
    });
});

$(".sub-menu").hover(function () {
    $(this).toggleClass("active");
});

$(function($) {

    if ($(".main-menu").length != 0) {
        $('.main-menu:first-child').toggleClass('active');
        var id = $('.main-menu:first-child').data('id');

        $.ajax({
            dataType: "json",
            method: "get",
            url: "/api/getSubcategory",
            data: { id: id },
            cache: false,
            beforeSend: function () {
            },
            success: function (response) {

                $("#sub-menu-primary").html('');

                if (response != 0) {
                    $.each(response, function (index, item) {
                        $("#sub-menu-primary").append(
                            "<a class='sub-menu' href='/category/"+item.categorysub_permalink+"'><div>"+item.categorysub_name+"</div></a>"
                        );
                    });


                }else{
                    $("#sub-menu-primary").html('');
                }

            },
            failure: function (errMsg) {
                alert(errMsg);
            }
        });
    };
});
