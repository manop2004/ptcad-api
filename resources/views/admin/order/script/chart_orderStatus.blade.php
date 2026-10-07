<script>

    $(function($) {
        $.ajax({
            type: "GET",
            url: '{!! route('order.report.json.statusOrder') !!}',
            cache: false,
            beforeSend: function () { },
            success: function (response) {

                if(response != false){
                    var typeName = [];
                    var typeValue = [];
                    var typeColor = [];

                    $.each(response, function (index, item) {

                        $('#showDetail').append('<div class="display-inline setDispleyFont"><div class="wh-15" style="background : '+item.color+'"></div> '+item.name+' : '+item.display+' รายการ</div><br/>');

                        typeName.push(item.name);
                        typeValue.push(item.value);
                        typeColor.push(item.color);

                    });

                    var ctx = document.getElementById("productType");
                    var myPieChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: typeName,
                            datasets: [{
                                data: typeValue,
                                backgroundColor: typeColor,
                                // hoverBackgroundColor: typeColor,
                                hoverBorderColor: "#000",
                                barPercentage: 0.6,
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
