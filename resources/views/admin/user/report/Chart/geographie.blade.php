<script>

    var North = $('#North').val();
    var Central = $('#Central').val();
    var Northeast = $('#Northeast').val();
    var Western = $('#Western').val();
    var Eastern = $('#Eastern').val();
    var South = $('#South').val();

    var chartStock = document.getElementById("chartStock");
    new Chart(chartStock, {
      type: 'bar',
      data: {
        labels: ["", "", "", "",  "",  ""],
        datasets: [
          {
            label: " ",
            borderColor: ['#0abde3','#ff9f43','#833471',  '#8395a7', '#8854d0',  '#359618'],
            fill: true,
            backgroundColor: ['#48dbfb', '#feca57','#B53471','#c8d6e5',  '#a55eea',  '#50B432'],
            hoverBackgroundColor: ['#0abde3','#ff9f43','#833471',  '#8395a7', '#8854d0',  '#359618'],
            borderWidth: 1,
            data: [North, Eastern, Northeast,Central,  Western, South],
          }
        ],
      },
      options: {
        
        tooltips: {
          tooltipFillColor: "rgba(0,0,0,0.5)",
          tooltipFontFamily: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
          tooltipFontSize: 14,
          tooltipFontStyle: "normal",
          tooltipFontColor: "#fff",
          tooltipTitleFontFamily: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
          tooltipTitleFontSize: 14,
          tooltipTitleFontStyle: "bold",
          tooltipTitleFontColor: "#fff",
          tooltipYPadding: 6,
          tooltipXPadding: 6,
          tooltipCaretSize: 8,
          tooltipCornerRadius: 6,
          tooltipXOffset: 10,
        },
        legend: {
          display: false
        },
        scales: {
          yAxes: [{
              ticks: {
                fontColor: "#9f9f9f",
                fontStyle: "bold",
                beginAtZero: true,
                maxTicksLimit: 5,
                padding: 20
              },
              gridLines: {
                zeroLineColor: "transparent",
                display: true,
                drawBorder: true,
                color: '#9f9f9f',
              }
          }],
          xAxes: [{
              barPercentage: 1,
              gridLines: {
                zeroLineColor: "white",
                display: false,
                drawBorder: true,
                color: 'transparent',
              },
              ticks: {
                padding: 20,
                fontColor: "#9f9f9f",
                fontStyle: "bold"
              }
          }],
        },
      }
    });

</script>
