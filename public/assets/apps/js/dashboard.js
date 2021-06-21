$(document).ready(function() {
  $.ajax({
    url: 'dashboard/get-chart',
    type: 'get',
    dataType: 'json',
    success: function(data){
      let label = [];
      let value = [];
      let year = moment().year();

      for (let i in data['bulan']) {
        label.push(data['bulan'][i]);
        value.push(data['total'][i]);
      }
      
      // chart
      const ctx = document.getElementById("myChart").getContext('2d');
      const myChart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: label,
          datasets: [{
            label: 'Statistics Transaction '+year,
            data: value,
            borderWidth: 2,
            backgroundColor: '#1e7b00',
            borderColor: '#1e7b00',
            borderWidth: 2.5,
            pointBackgroundColor: '#ffffff',
            pointRadius: 4
          }]
        },
        options: {
          legend: {
            display: false
          },
          scales: {
            yAxes: [{
              gridLines: {
                drawBorder: false,
                color: '#f2f2f2',
              },
              ticks: {
                beginAtZero: true,
                stepSize: 150
              }
            }],
            xAxes: [{
              ticks: {
                display: false
              },
              gridLines: {
                display: false
              }
            }]
          },
        }
      });
    }
  })
});