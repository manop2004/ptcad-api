<script>
    $.ajax({
        type: "GET",
        url: '{!! route('user.averageYear') !!}',
        cache: false,
        beforeSend: function () { },
        success: function (response2) {

            var year_01 = [];
            var year_02 = [];
            var year_03 = [];
            var year_04 = [];
            var year_05 = [];

            var display_1 = [];
            var display_2 = [];
            var display_3 = [];
            var display_4 = [];
            var display_5 = [];

            year_01 = response2.result_1;
            year_02 = response2.result_2;
            year_03 = response2.result_3;
            year_04 = response2.result_4;
            year_05 = response2.result_5;

            display_1 = response2.display_1;
            display_2 = response2.display_2;
            display_3 = response2.display_3;
            display_4 = response2.display_4;
            display_5 = response2.display_5;


            var ctx = document.getElementById("my_year");
            var myPieChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['ปี '+display_1,'ปี '+display_2,'ปี '+display_3,'ปี '+display_4,'ปี '+display_5],
                    datasets: [{
                        label: " จำนวน/คน ",
                        borderWidth: 2,
                        data: [year_01,year_02,year_03,year_04,year_05],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(255, 159, 64, 0.2)',
                            'rgba(255, 205, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                        ],
                        hoverBackgroundColor: [
                            'rgb(255, 99, 132)',
                            'rgb(255, 159, 64)',
                            'rgb(255, 205, 86)',
                            'rgb(75, 192, 192)',
                            'rgb(54, 162, 235)'
                        ],
                        hoverBorderColor: "rgba(234, 236, 244, 1)",

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
                        xPadding: 20,
                        yPadding: 20,
                        displayColors: true,
                        caretPadding: 10,
                    },
                    legend: {
                        display: false
                    },
                },
            });
        },
        failure: function (errMsg) {
            alert(errMsg);
        }
    });
</script>