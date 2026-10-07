<script>

    $.ajax({
        type: "GET",
        url: '{!! route('user.jsonbusiness') !!}',
        cache: false,
        beforeSend: function () {
        },
        success: function (response) {

            if(response != false){
                var typeName = [];
                var typeValue = [];
                var typeColor = [];

                $.each(response, function (index, item) {

                    typeName.push(item.name);
                    typeValue.push(item.value);
                    typeColor.push(item.color);

                });

                var business = document.getElementById("business");

                new Chart(business, {
                    type: 'line',
                    data: {
                        labels: typeName,
                        datasets: [
                        {
                            label: " จำนวน/คน ",
                            fill: true,
                            borderColor: "#7f8c8d",
                            backgroundColor: "#bdc3c7",
                            borderWidth: 1,
                            data: typeValue,
                        }
                        ]
                    },
                    options: {
                        tooltips: {
                            display: true
                        },
                        legend: {
                            display: false
                        },
                        scales: {
                            yAxes: [{
                                ticks: {
                                    fontColor: "#9f9f9f",
                                    beginAtZero: true,
                                    maxTicksLimit: 5,
                                },
                                gridLines: {
                                    drawBorder: false,
                                    borderDash: [8, 5],
                                    zeroLineColor: "transparent",
                                    color: '#9f9f9f'
                                }
                            }],
                            xAxes: [{
                                offset: 10,
                                ticks: {
                                    display: false,
                                },
                                gridLines: {
                                    drawBorder: false,
                                    borderDash: [8, 5],
                                    zeroLineColor: "transparent",
                                    color: '#9f9f9f'
                                }
                            }]
                        }
                    }
                });

            }

        },
        failure: function (errMsg) {
            alert(errMsg);
        }
    });

    
</script>