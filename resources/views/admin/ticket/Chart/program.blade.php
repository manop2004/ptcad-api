<script>

    var Type1 = $('#Type1').val();
    var Type2 = $('#Type2').val();

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
</script>