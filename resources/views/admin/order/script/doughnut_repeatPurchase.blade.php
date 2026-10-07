<script>

$(function($) {
    $.ajax({
        type: "GET",
        url: '{!! route('order.report.json.repeatPurchase') !!}',
        cache: false,
        beforeSend: function () { },
        success: function (response) {

            if(response != false){
                var typeName = [];
                var typeValue = [];
                var typeColor = [];

                $.each(response, function (index, item) {

                    $('#Detail_repeatPurchase').append('<div class="display-inline setDispleyFont"><div class="wh-15" style="background : '+item.color+'"></div> '+item.name+' : '+item.display+' รายการ</div><br/>');

                    typeName.push(item.name);
                    typeValue.push(item.value);
                    typeColor.push(item.color);

                });

                var ctx = document.getElementById("repeatPurchase");
                var repeatPurchase = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ["Dowloads", "ติดต่อกลับ"],
                        datasets: [{
                            data: [dowload, contact],
                            backgroundColor: ['#50B432', '#a50505'],
                            hoverBackgroundColor: ['#6bbd52', '#b13a3a'],
                            hoverBorderColor: "rgba(234, 236, 244, 1)",
                        }],
                    },
                    options: {
                        maintainAspectRatio: false,
                        tooltips: {
                            backgroundColor: "#000",
                            bodyFontColor: "#FFF",
                            borderColor: '#dddfeb',
                            borderWidth: 1,
                            xPadding: 15,
                            yPadding: 15,
                            displayColors: false,
                            caretPadding: 10,
                        },
                        legend: {
                            display: false
                        },
                        cutoutPercentage: 0,
                    },
                });
            }

        },
        failure: function (errMsg) {
            alert(errMsg);
        }
    });
});
</script>
