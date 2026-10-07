<script>
    $.ajax({
        type: "GET",
        url: '{!! route('user.jsonaverage') !!}',
        data: {"Year" : $('#year').val()},
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

                $('#display-01').html("<div class='wh-15' style='background : #C57C54'></div> มกราคม");
                $('#display-02').html("<div class='wh-15' style='background : #B793BF'></div> กุมภาพันธ์");
                $('#display-03').html("<div class='wh-15' style='background : #B8E4DC'></div> มีนาคม");
                $('#display-04').html("<div class='wh-15' style='background : #E14851'></div> เมษายน");
                $('#display-05').html("<div class='wh-15' style='background : #7AB464'></div> พฤษภาคม");
                $('#display-06').html("<div class='wh-15' style='background : #FBD662'></div> มิถุนายน");
                $('#display-07').html("<div class='wh-15' style='background : #E7B1B8'></div> กรกฎาคม");
                $('#display-08').html("<div class='wh-15' style='background : #F48036'></div> สิงหาคม");
                $('#display-09').html("<div class='wh-15' style='background : #5F6CB0'></div> กันยายน");
                $('#display-10').html("<div class='wh-15' style='background : #97B4D4'></div> ตุลาคม");
                $('#display-11').html("<div class='wh-15' style='background : #C74C61'></div> พฤศจิกายน");
                $('#display-12').html("<div class='wh-15' style='background : #27808F'></div> ธันวาคม");
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
                        }],
                        xAxes: [{
                            ticks: {
                                autoSkip: false
                            },
                        }]
                    },
                    aspectRatio:1,
                    maintainAspectRatio: false,
                    tooltips: {
                        backgroundColor: "#000",
                        bodyFontColor: "#FFF",
                        borderColor: '#000',
                        borderWidth: 0,
                        xPadding: 5,
                        yPadding: 5,
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
</script>