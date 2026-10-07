$('.loadding').click( function(){
    var element = document.getElementById("btn_dowload");
    element.classList.add("buttonload");
    document.getElementById('btn_dowload').innerHTML = '<i class="fa fa-spinner fa-spin"></i> กำลังดาวน์โหลดเอกสาร ';

});

function loadding() {
    var element = document.getElementById("displayLoagging");
    if(element != null){
        element.classList.remove("display-none");
    }
};


function readURL1(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#blah1').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}
function readURL2(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#blah2').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}
function readURL3(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#blah3').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}
function readURL4(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#blah4').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

// wizard pic
$("#wizard-picture").change(function() {
    readURLwizard(this);
});

function readURLwizard(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        $('#wizardPicturePreview').attr('src', e.target.result).fadeIn('slow');
      }
      reader.readAsDataURL(input.files[0]);
    }
}

//SEO Description Length
function ChkLength(){
    var objTextBox = document.getElementById('remainLength');
    var MaxLength = 170;
    var curLength = objTextBox.value.length;
    document.getElementById('showNumber_ChkLength').innerHTML = 'คงเหลืออีก '+(MaxLength - curLength)+' ตัวอักษร';
}
//กรอกเฉพาะภาษาอังกฤษ
function ChkEng()
{
    var eng = /^([a-zA-Z])+$/;
    var objTextBox = document.getElementById('permalink');
    var valOK = true;

    // for (i=0; i<objTextBox.length & valOK; i++){
    //     valOK = (str.indexOf(objTextBox.charAt(i))!= -1)
    // }

    // if (!valOK) {
    //         alert("ภาษาอังกฤษเท่านั้น !!! ")
    //         obj.focus()
    //         return false
    // } return true

}

$(window).resize(function() {
    $('.card-wizard').each(function() {
      $wizard = $(this);

      index = $wizard.bootstrapWizard('currentIndex');
      refreshAnimation($wizard, index);

      $('.moving-tab').css({
        'transition': 'transform 0s'
      });
    });
});

function checkMainmenu(elem){
    var id = $(elem).attr("id");
    $('#' + id +'.mainMenu').siblings().find(".active").removeClass("active");
    localStorage.setItem("selectedolditem", id);
    localStorage.setItem("selectedolditemMain", 'null');
    localStorage.setItem("selectedolditemSub", 'null');
};


function deleteModal(e){
    var deleteId = $(e).data('id');
    var deleteName = $(e).data('name');

    $('#deleteId').val(deleteId);
    $('#deleteName').html('"'+deleteName+'"');
}

function deleteModal2(e){
    var deleteId = $(e).data('id');
    var deleteName = $(e).data('name');

    $('#deleteId2').val(deleteId);
    $('#deleteName2').html('"'+deleteName+'"');
}

function deleteModal3(e){
    var deleteId = $(e).data('id');
    var deleteName = $(e).data('name');

    $('#deleteId3').val(deleteId);
    $('#deleteName3').html('"'+deleteName+'"');
}

function deleteModal4(e){
    var deleteId = $(e).data('id');
    var deleteName = $(e).data('name');

    $('#deleteId4').val(deleteId);
    $('#deleteName4').html('"'+deleteName+'"');
}

function deleteModal5(e){
    var deleteId = $(e).data('id');
    var deleteName = $(e).data('name');

    $('#deleteId5').val(deleteId);
    $('#deleteName5').html('"'+deleteName+'"');
}

function deleteModal6(e){
    var deleteId = $(e).data('id');
    var deleteName = $(e).data('name');

    $('#deleteId6').val(deleteId);
    $('#deleteName6').html('"'+deleteName+'"');
}
function checkProduct_status(e){

    var id     = e.value;
    var url    = $(e).data('url');

    $.ajax({
        type: "GET",
        url: url,
        data: { id: id },
        cache: false,
        beforeSend: function () {
        },
        success: function (response) {

            if(response != ""){
                $.each(response, function (index, item) {
                    if(item.stu_preorder == 1){
                        document.getElementById("block_hidden").classList.remove("hidden");
                    }else{
                        document.getElementById("block_hidden").classList.add("hidden");
                    }
                });
            }

        },
        failure: function (errMsg) {
            alert(errMsg);
        }
    });

}

function checkBlockToggle(e){

    var block     = $(e).data('block');
    var element = document.getElementById(block);

    element.classList.toggle("hidden");

}

function checkBlockHidden1(e){

    var value     = e.value;
    var block     = $(e).data('block');

    if(value == 1){
        document.getElementById(block).classList.add("hidden");
    }else{
        document.getElementById(block).classList.remove("hidden");
    }
}



function checkBlockHidden2(e){

    var value     = e.value;
    var block     = $(e).data('block');

    if(value == 2){
        document.getElementById(block).classList.add("hidden");
    }else{
        document.getElementById(block).classList.remove("hidden");
    }
}

function setDate(e){

    if(e == 2){
        document.getElementById("setDate").classList.remove("hidden");
    }else{
        document.getElementById("setDate").classList.add("hidden");
    }
}

function typePopup(e){

    if(e == 2){
        document.getElementById("popup_upload").classList.remove("hidden");
        document.getElementById("popup_content").classList.add("hidden");
    }else{
        document.getElementById("popup_content").classList.remove("hidden");
        document.getElementById("popup_upload").classList.add("hidden");
    }
}


if ($(".datepicker").length != 0) {
    $('.datepicker').datetimepicker({
      format: 'DD-MM-YYYY',
      icons: {
        time: "fa fa-clock-o",
        date: "fa fa-calendar",
        up: "fa fa-chevron-up",
        down: "fa fa-chevron-down",
        previous: 'fa fa-chevron-left',
        next: 'fa fa-chevron-right',
        today: 'fa fa-screenshot',
        clear: 'fa fa-trash',
        close: 'fa fa-remove'
      }
    });
}


if ($(".datepicker").length != 0) {
    $('.datepicker').datetimepicker({
      format: 'DD/MM/YYYY',
      icons: {
        time: "fa fa-clock-o",
        date: "fa fa-calendar",
        up: "fa fa-chevron-up",
        down: "fa fa-chevron-down",
        previous: 'fa fa-chevron-left',
        next: 'fa fa-chevron-right',
        today: 'fa fa-screenshot',
        clear: 'fa fa-trash',
        close: 'fa fa-remove'
      }
    });
}

  function getmember_ref_Change(e){
    if(e == 2){
        document.getElementById("b_getmember_ref_coupon").classList.remove("hidden");
        document.getElementById("b_getmember_ref_cashcard").classList.add("hidden");
    }else{
        document.getElementById("b_getmember_ref_cashcard").classList.remove("hidden");
        document.getElementById("b_getmember_ref_coupon").classList.add("hidden");
    }
}

function getmember_recommender_type_Change(e){
    if(e == 2){
        document.getElementById("b_getmember_recommender_coupon").classList.remove("hidden");
        document.getElementById("b_getmember_recommender_cashcard").classList.add("hidden");
    }else{
        document.getElementById("b_getmember_recommender_cashcard").classList.remove("hidden");
        document.getElementById("b_getmember_recommender_coupon").classList.add("hidden");
    }
}

$('#recommendType1').click( function(){
    var recommendType1  = $('#recommendType1').data('value');
    var recommendType2  = '';
    var old_cat         = '';

    $.ajax({
        type: "GET",
        url: '/recommend/category/product/jsonGet',
        data: { catId: recommendType1, subcatId: recommendType2, old_cat:old_cat},
        cache: false,
        beforeSend: function () {},
        success: function (response) {

            $("#categoryId").html('<option value=""></option>');
            $("#recommend_product_category").html('<option value=""></option>');

            if(response != ""){
                $.each(response, function (index, item) {
                    $("#categoryId").append(
                        '<option value="' + item.id + '" ' + item.selected + '>' + item.category_name + "</option>"
                    );
                });

                $('#old_option_type').val(1);

            }else{
                $("#categoryId").append(
                    '<option value="">ไม่มีข้อมูล</option>'
                );
            }

        },
        failure: function (errMsg) {
            alert(errMsg);
        }
    });
});

$('#recommendType2').click( function(){
    var recommendType1  = '';
    var recommendType2  = $('#recommendType2').data('value');
    var old_cat         = '';

    $.ajax({
        type: "GET",
        url: '/recommend/category/product/jsonGet',
        data: { catId: recommendType1, subcatId: recommendType2, old_cat:old_cat},
        cache: false,
        beforeSend: function () {},
        success: function (response) {

            $("#categoryId").html('<option value=""></option>');
            $("#recommend_product_category").html('<option value=""></option>');

            if(response != ""){

                $.each(response, function (index, item) {
                    $("#categoryId").append(
                        '<option value="' + item.id + '" ' + item.selected + '>' + item.category_name + "</option>"
                    );
                });

                $('#old_option_type').val(2);

            }else{
                $("#categoryId").append(
                    '<option value="">ไม่มีข้อมูล</option>'
                );
            }

        },
        failure: function (errMsg) {
            alert(errMsg);
        }
    });
});

function getSubcat(e){

    var categoryId  = e.value;
    var url    = $(e).data('url');

    $.ajax({
        type: "GET",
        url: url,
        data: { categoryId: categoryId },
        cache: false,
        beforeSend: function () {
        },
        success: function (response) {

            $("#pro_catsubId").html('<option></option>');
            if(response != ""){
                $("#pro_catsubId").append('<option></option>');
                $.each(response, function (index, item) {
                    $("#pro_catsubId").append(
                        '<option value="' + item.id + '">' + item.categorysub_name + "</option>"
                    );
                });
            }else{
                $("#pro_catsubId").append(
                    '<option value="">ไม่มีข้อมูล</option>'
                );
            }

        },
        failure: function (errMsg) {
            alert(errMsg);
        }
    });
}

$('#categoryId').change( function(){
    var option_type        = $('#old_option_type').val();
    var categoryId         = $(this).val();

    $.ajax({
        type: "GET",
        url: '/recommend/category/product/jsonproductGet',
        data: { type: option_type, categoryId: categoryId},
        cache: false,
        beforeSend: function () {},
        success: function (response) {

            $("#recommend_product_category").html('<option value=""></option>');

            if(response != ""){
                $.each(response, function (index, item) {
                    $("#recommend_product_category").append(
                        '<option value="' + item.id + '" ' + item.selected + '>' + item.pro_name + "</option>"
                    );
                });
            }else{
                $("#recommend_product_category").append(
                    '<option value="">ไม่มีข้อมูล</option>'
                );
            }

        },
        failure: function (errMsg) {
            alert(errMsg);
        }
    });
});

function getYear(e){

    var url = $(e).data('link');

    $.ajax({
        type: "GET",
        url: url,
        data: {"Year" : e.value},
        cache: false,
        beforeSend: function () { },
        success: function (response) {

            var result_01 = [];
            var result_02 = [];
            var result_03 = [];
            var result_04 = [];
            var result_05 = [];
            var result_06 = [];
            var result_07 = [];
            var result_08 = [];
            var result_09 = [];
            var result_10 = [];
            var result_11 = [];
            var result_12 = [];

            var display_01 = [];
            var display_02 = [];
            var display_03 = [];
            var display_04 = [];
            var display_05 = [];
            var display_06 = [];
            var display_07 = [];
            var display_08 = [];
            var display_09 = [];
            var display_10 = [];
            var display_11 = [];
            var display_12 = [];
            var total = [];

            $.each(response, function (index, item) {
                result_01 = item.result_01;
                result_02 = item.result_02;
                result_03 = item.result_03;
                result_04 = item.result_04;
                result_05 = item.result_05;
                result_06 = item.result_06;
                result_07 = item.result_07;
                result_08 = item.result_08;
                result_09 = item.result_09;
                result_10 = item.result_10;
                result_11 = item.result_11;
                result_12 = item.result_12;

                $('#number-01').html("<div class='wh-15' style='background : #C57C54'></div> มกราคม "+item.result_01+" คน");
                $('#number-02').html("<div class='wh-15' style='background : #B793BF'></div> กุมภาพันธ์ "+item.result_02+" คน");
                $('#number-03').html("<div class='wh-15' style='background : #B8E4DC'></div> มีนาคม "+item.result_03+" คน");
                $('#number-04').html("<div class='wh-15' style='background : #E14851'></div> เมษายน "+item.result_04+" คน");
                $('#number-05').html("<div class='wh-15' style='background : #7AB464'></div> พฤษภาคม "+item.result_05+" คน");
                $('#number-06').html("<div class='wh-15' style='background : #FBD662'></div> มิถุนายน "+item.result_06+" คน");
                $('#number-07').html("<div class='wh-15' style='background : #E7B1B8'></div> กรกฎาคม "+item.result_07+" คน");
                $('#number-08').html("<div class='wh-15' style='background : #F48036'></div> สิงหาคม "+item.result_08+" คน");
                $('#number-09').html("<div class='wh-15' style='background : #5F6CB0'></div> กันยายน "+item.result_09+" คน");
                $('#number-10').html("<div class='wh-15' style='background : #97B4D4'></div> ตุลาคม "+item.result_10+" คน");
                $('#number-11').html("<div class='wh-15' style='background : #C74C61'></div> พฤศจิกายน "+item.result_11+" คน");
                $('#number-12').html("<div class='wh-15' style='background : #27808F'></div> ธันวาคม "+item.result_12+" คน");
                $('#display-total').html("รวมทั้งสิ้น "+item.total+" คน");
            });

            var ctx = document.getElementById("my_month");
            var myPieChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ["มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม"],
                    datasets: [{
                        data: [result_01,result_02,result_03,result_04,result_05,result_06,result_07,result_08,result_09,result_10,result_11,result_12],
                        // fill: 'false',
                        pointBackgroundColor: ['#C57C54', '#B793BF','#B8E4DC','#E14851','#7AB464','#FBD662','#E7B1B8','#F48036','#5F6CB0','#97B4D4','#C74C61','#27808F'],
                        // hoverBackgroundColor: ['#C57C54','#B793BF','#B8E4DC','#E14851','#7AB464','#FBD662','#E7B1B8','#F48036','#5F6CB0','#97B4D4','#C74C61','#27808F'],
                        borderColor: ['#C57C54','#B793BF','#B8E4DC','#E14851','#7AB464','#FBD662','#E7B1B8','#F48036','#5F6CB0','#97B4D4','#C74C61','#27808F'],
                    }],
                },
                options: {
                    scales: {
                        yAxes: [{
                            display: true,
                            ticks: {
                                beginAtZero: true,
                                min: 0
                            }
                        }]
                    },
                    aspectRatio:1,
                    maintainAspectRatio: false,
                    tooltips: {
                        backgroundColor: "#000",
                        bodyFontColor: "#FFF",
                        borderColor: '#000',
                        borderWidth: 0,
                        xPadding: 10,
                        yPadding: 10,
                        displayColors: true,
                        caretPadding: 10,
                    },
                    legend: {
                        display: false
                    },
                    cutoutPercentage: 0,
                },
            });

        },
        failure: function (errMsg) {
            alert(errMsg);
        }
    });

}

function getYearQuotation(e){

    var url = $(e).data('link');
	var year = $('#year').val();
    var month = $('#month').val();

    $.ajax({
        type: "GET",
        url: url,
        data: {
            "Year" : year,
            "Month": month
        },
        cache: false,
        beforeSend: function () { },
        success: function (response) {

            var result_01 = [];
            var result_02 = [];
            var result_03 = [];
            var result_04 = [];
            var result_05 = [];
            var result_06 = [];
            var result_07 = [];
            var result_08 = [];
            var result_09 = [];
            var result_10 = [];
            var result_11 = [];
            var result_12 = [];

            var display_01 = [];
            var display_02 = [];
            var display_03 = [];
            var display_04 = [];
            var display_05 = [];
            var display_06 = [];
            var display_07 = [];
            var display_08 = [];
            var display_09 = [];
            var display_10 = [];
            var display_11 = [];
            var display_12 = [];
            var total = [];
            var Type1 = [];
            var Type2 = [];

            $.each(response, function (index, item) {
                result_01 = item.result_01;
                result_02 = item.result_02;
                result_03 = item.result_03;
                result_04 = item.result_04;
                result_05 = item.result_05;
                result_06 = item.result_06;
                result_07 = item.result_07;
                result_08 = item.result_08;
                result_09 = item.result_09;
                result_10 = item.result_10;
                result_11 = item.result_11;
                result_12 = item.result_12;
                Type1     = item.type1;
                Type2     = item.type2;

                $('#number-01').html(item.result_01);
                $('#number-02').html(item.result_02);
                $('#number-03').html(item.result_03);
                $('#number-04').html(item.result_04);
                $('#number-05').html(item.result_05);
                $('#number-06').html(item.result_06);
                $('#number-07').html(item.result_07);
                $('#number-08').html(item.result_08);
                $('#number-09').html(item.result_09);
                $('#number-10').html(item.result_10);
                $('#number-11').html(item.result_11);
                $('#number-12').html(item.result_12);
                $('#display-total').html("รวมทั้งสิ้น "+item.total+" คน");
                $('#display-year').html(e.value);
                $('#display-total-type').html("รวมทั้งสิ้น "+item.total);
                $('#display-year-type').html(e.value);
                $('#year-contact').html(item.contact);
                $('#year-dowload').html(item.dowload);
                $('#year-totalMonth').html(item.totalMonth);
                $('#display-type1').html(item.type1);
                $('#display-type2').html(item.type2);
                $('#Type1').val(item.type1);
                $('#Type2').val(item.type2);
            });

            getGroupType(Type1,Type2);

            var ctx = document.getElementById("my_month");
            var myPieChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ["มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม"],
                    datasets: [{
                        data: [result_01,result_02,result_03,result_04,result_05,result_06,result_07,result_08,result_09,result_10,result_11,result_12],
                        // fill: 'false',
                        pointBackgroundColor: ['#C57C54', '#B793BF','#B8E4DC','#E14851','#7AB464','#FBD662','#E7B1B8','#F48036','#5F6CB0','#97B4D4','#C74C61','#27808F'],
                        // hoverBackgroundColor: ['#C57C54','#B793BF','#B8E4DC','#E14851','#7AB464','#FBD662','#E7B1B8','#F48036','#5F6CB0','#97B4D4','#C74C61','#27808F'],
                        borderColor: ['#C57C54','#B793BF','#B8E4DC','#E14851','#7AB464','#FBD662','#E7B1B8','#F48036','#5F6CB0','#97B4D4','#C74C61','#27808F'],
                    }],
                },
                options: {
                    scales: {
                        yAxes: [{
                            display: true,
                            ticks: {
                                beginAtZero: true,
                                min: 0
                            }
                        }]
                    },
                    aspectRatio:1,
                    maintainAspectRatio: false,
                    tooltips: {
                        backgroundColor: "#000",
                        bodyFontColor: "#FFF",
                        borderColor: '#000',
                        borderWidth: 0,
                        xPadding: 10,
                        yPadding: 10,
                        displayColors: true,
                        caretPadding: 10,
                    },
                    legend: {
                        display: false
                    },
                    cutoutPercentage: 0,
                },
            });

        },
        failure: function (errMsg) {
            alert(errMsg);
        }
    });


}

function getGroupType(Type1,Type2){

    var Type1 = Type1;
    var Type2 = Type2;

    var memberSex = document.getElementById("groupType");

    new Chart(memberSex, {
      type: 'pie',
      data: {
        labels: ['บุคคลธรรมดา', 'บริษัท/สำนักงาน/องค์กร'],
        datasets: [{
            label: " ประเภท ",
            pointRadius: 0,
            pointHoverRadius: 0,
            backgroundColor: [
                '#058DC7',
                '#50B432',
            ],
            borderWidth: 0,
            data: [Type1, Type2]
        }]
      },
      options: {
        legend: {
            display: false
        },
        tooltips: {
            enabled: true
        },
        scales: {
            yAxes: [{
                ticks: {
                display: false
                },
                gridLines: {
                drawBorder: false,
                zeroLineColor: "transparent",
                color: 'rgba(255,255,255,0.05)'
                }
            }],
            xAxes: [{
                barPercentage: 1.6,
                gridLines: {
                drawBorder: false,
                color: 'rgba(255,255,255,0.1)',
                zeroLineColor: "transparent"
                },
                ticks: {
                display: false,
                }
            }]
        },
      }
    });
}

function generateCodeCoupon(length = 8) {
    var result           = [];
    var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var charactersLength = characters.length;
    for ( var i = 0; i < length; i++ ) {
      result.push(characters.charAt(Math.floor(Math.random() * charactersLength)));
    }

    $("#coupon_code").val('CO'+result.join(''));

}

function participatingCategorie(e){
    var type  = $(e).val();
    var categorie  = $('#hidden_participating_categorie').val();

    $.ajax({
        type: "GET",
        url: '/promotion/coupon/jsoncategorie',
        data: { type: type, categorie: categorie},
        cache: false,
        beforeSend: function () {},
        success: function (response) {

            $("#participating_categorie").html('<option value=""></option>');

            if(response != ""){
                $.each(response, function (index, item) {
                    $("#participating_categorie").append(
                        '<option value="' + item.id + '" ' + item.selected + '>' + item.category_name + "</option>"
                    );
                });
            }else{
                $("#participating_categorie").append(
                    '<option value="">ไม่มีข้อมูล</option>'
                );
            }

        },
        failure: function (errMsg) {
            alert(errMsg);
        }
    });
};

function participatingCategorieNone(e){
    var type  = $(e).val();
    var categorie  = $('#hidden_non_participating_categorie').val();

    $.ajax({
        type: "GET",
        url: '/promotion/coupon/jsoncategorie',
        data: { type: type, categorie: categorie},
        cache: false,
        beforeSend: function () {},
        success: function (response) {

            $("#non_participating_categorie").html('<option value=""></option>');

            if(response != ""){
                $.each(response, function (index, item) {
                    $("#non_participating_categorie").append(
                        '<option value="' + item.id + '" ' + item.selected + '>' + item.category_name + "</option>"
                    );
                });
            }else{
                $("#non_participating_categorie").append(
                    '<option value="">ไม่มีข้อมูล</option>'
                );
            }

        },
        failure: function (errMsg) {
            alert(errMsg);
        }
    });
};

$('.number').keypress( function(){
    var vchar = String.fromCharCode(event.keyCode);
        if (vchar<'0' || vchar>'9') return false;
});

function getCodeCount(e){

    var coupon = $('#coupon_code').val();

    $.ajax({
        type: "GET",
        url: '/promotion/coupon/report/jsondata',
        data: { Year: e, Coupon:coupon},
        cache: false,
        beforeSend: function () {},
        success: function (response) {

            if(response != ""){

                $('#use_01').html(response.month_01);
                $('#use_02').html(response.month_02);
                $('#use_03').html(response.month_03);
                $('#use_04').html(response.month_04);
                $('#use_05').html(response.month_05);
                $('#use_06').html(response.month_06);
                $('#use_07').html(response.month_07);
                $('#use_08').html(response.month_08);
                $('#use_09').html(response.month_09);
                $('#use_10').html(response.month_10);
                $('#use_11').html(response.month_11);
                $('#use_12').html(response.month_12);
                $('#countTotal').html(response.countTotal);

            }

        },
        failure: function (errMsg) {
            alert(errMsg);
        }
    });

}

function deleteChild(e){
    $(e).closest('.child_div').remove();
}
$(".btn-delete-settingForm").click(function() {

    var id = $(this).attr("data-id")
    var obj = document.getElementById("block-"+id);
    obj.remove();

});
$("#addMore_Form").click(function() {

    var msg = '';
    msg = '<div class="row child_div">';
    msg += '<div class="col-md-2">';
    msg += '<div class="form-group has-label">';
    msg += '<label>ฟิลด์สำหรับกรอกฟอร์ม</label>';
    msg += '<select name="field[]" class="form-control select-child ">';
    msg += '<option value="">-- กรุณาเลือกข้อมูล --</option>';
    msg += '<option value="firstname">ชื่อ</option>';
    msg += '<option value="lastname">นามสกุล</option>';
    msg += '<option value="company">บริษัท</option>';
    msg += '<option value="designation">ตำแหน่ง</option>';
    msg += '<option value="department">แผนก</option>';
    msg += '<option value="website">ชื่อเว็บไซต์</option>';
    msg += '<option value="industry">ประเภทอุตสาหกรรม</option>';
    msg += '<option value="email">อีเมล</option>';
    msg += '<option value="phone">เบอร์โทรศัพท์</option>';
    msg += '<option value="mobile">เบอร์มือถือ</option>';
    msg += '<option value="fax">แฟกซ์</option>';
    msg += '<option value="description">ข้อความ</option>';
    msg += '<option value="address">ที่อยู่</option>';
    msg += '<option value="province">จังหวัด</option>';
    msg += '</select>';
    msg += '</div>';
    msg += '</div>';
    msg += '<div class="col-md-3">';
    msg += '<div class="form-group has-label">';
    msg += '<label>คำอธิบาย *</label>';
    msg += '<input type="text" class="form-control no-max-height" name="fieldTH[]" />';
    msg += '</div>';
    msg += '</div>';
    msg += '<div class="col-md-3">';
    msg += '<div class="form-group has-label">';
    msg += '<label>การแสดงผล</label>';
    msg += '<select name="col[]" class="form-control">';
    msg += '<option value="col-md-12">col-md-12</option>';
    msg += '<option value="col-md-6">col-md-6</option>';
    msg += '<option value="col-md-4">col-md-4</option>';
    msg += '</select>';
    msg += '</div>';
    msg += '</div>';
    msg += '<div class="col-md-3 col-10">';
    msg += '<div class="form-group has-label">';
    msg += '<label>ลำดับการแสดงผล *</label>';
    msg += '<input type="number" class="form-control no-max-height" name="sort[]" value="" />';
    msg += '</div>';
    msg += '</div>';
    msg += '<div class="col-md-1 col-2">';
    msg += '<div class="form-group has-label deleteSettingForm">';
    msg += '<button onclick="deleteChild(this)" type="button" class="btn btn-danger btn-icon btn-sm"><i class="fa fa-times"></i></button>';
    msg += '</div>';
    msg += '</div>';
    msg += '</div>';

    $("#settingForm").append(msg)

});

$(function($) {

    if ($("#yearReportCoupon").length != 0) {

        var Year = $('#yearReportCoupon').val();
        var coupon = $('#coupon_code').val();

        $.ajax({
            type: "GET",
            url: '/promotion/coupon/report/jsondata',
            data: { Year: Year, Coupon:coupon},
            cache: false,
            beforeSend: function () {},
            success: function (response) {

                if(response != ""){

                    $('#use_01').html(response.month_01);
                    $('#use_02').html(response.month_02);
                    $('#use_03').html(response.month_03);
                    $('#use_04').html(response.month_04);
                    $('#use_05').html(response.month_05);
                    $('#use_06').html(response.month_06);
                    $('#use_07').html(response.month_07);
                    $('#use_08').html(response.month_08);
                    $('#use_09').html(response.month_09);
                    $('#use_10').html(response.month_10);
                    $('#use_11').html(response.month_11);
                    $('#use_12').html(response.month_12);
                    $('#countTotal').html(response.countTotal);
                }

            },
            failure: function (errMsg) {
                alert(errMsg);
            }
        });
    };

    if ($("#hidden_participating_categorie_type").length != 0) {
        var type  = $('#hidden_participating_categorie_type').val();
        var categorie  = $('#hidden_participating_categorie').val();

        $.ajax({
            type: "GET",
            url: '/promotion/coupon/jsoncategorie',
            data: { type: type, categorie: categorie},
            cache: false,
            beforeSend: function () {},
            success: function (response) {

                $("#participating_categorie").html('<option value="">กรุณาเลือกข้อมูล</option>');

                if(response != ""){
                    $.each(response, function (index, item) {
                        $("#participating_categorie").append(
                            '<option value="' + item.id + '" ' + item.selected + '>' + item.category_name + "</option>"
                        );
                    });
                }else{
                    $("#participating_categorie").append(
                        '<option value="">ไม่มีข้อมูล</option>'
                    );
                }

            },
            failure: function (errMsg) {
                alert(errMsg);
            }
        });
    }

    if ($("#hidden_non_participating_categorie_type").length != 0) {
        var type  = $('#hidden_non_participating_categorie_type').val();
        var categorie  = $('#hidden_non_participating_categorie').val();

        $.ajax({
            type: "GET",
            url: '/promotion/coupon/jsoncategorie',
            data: { type: type, categorie: categorie},
            cache: false,
            beforeSend: function () {},
            success: function (response) {

                $("#non_participating_categorie").html('<option value="">กรุณาเลือกข้อมูล</option>');

                if(response != ""){
                    $.each(response, function (index, item) {
                        $("#non_participating_categorie").append(
                            '<option value="' + item.id + '" ' + item.selected + '>' + item.category_name + "</option>"
                        );
                    });
                }else{
                    $("#non_participating_categorie").append(
                        '<option value="">ไม่มีข้อมูล</option>'
                    );
                }

            },
            failure: function (errMsg) {
                alert(errMsg);
            }
        });
    }

});
