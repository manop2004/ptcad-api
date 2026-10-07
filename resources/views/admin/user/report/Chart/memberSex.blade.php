<script>

    var male = $('#male').val();
    var female = $('#female').val();
    var alternativeSex = $('#alternativeSex').val();

    var memberSex = document.getElementById("memberSex");

    new Chart(memberSex, {
      type: 'pie',
      data: {
        labels: ['ชาย', 'หญิง', 'ไม่ระบุ'],
        datasets: [{
            label: " เพศ ",
            pointRadius: 0,
            pointHoverRadius: 0,
            backgroundColor: [
                '#058DC7',
                '#50B432',
                '#B53471'
            ],
            borderWidth: 0,
            data: [male, female, alternativeSex]
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