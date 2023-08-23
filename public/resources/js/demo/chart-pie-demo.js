// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

// Pie Chart Example

function showHistoricos(id) {
  var serie1 = [];
  var serie2 = [];

  for (x = 0; x < 10; x++) {
    serie1.push((Math.random() + 1).toFixed(2));
    serie2.push((Math.random() + 1).toFixed(2));
  }
  var ctx = document.getElementById(id);
  var myPieChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: ["2016", "2017", "2018", "2019", "2020", "2021", "2022"],
      datasets: [{
        label: "Histórico",
        //data: [1.23, 1.45, 1.89,1.78,1.34,1.23,1.56],
        data: serie1,
        fill: false,
        borderColor: 'rgb(75, 192, 192)',
        tension: 0.1,
        hoverBorderColor: "rgba(234, 236, 244, 1)",
      },      
      ],
    },
    options: {
      maintainAspectRatio: true,
      tooltips: {
        backgroundColor: "rgb(255,255,255)",
        bodyFontColor: "#858796",
        borderColor: '#dddfeb',
        borderWidth: 1,
        xPadding: 15,
        yPadding: 15,
        displayColors: false,
        caretPadding: 10,
      },
      legend: {
        display: true
      },
      cutoutPercentage: 80,
      scales: {
        y: {
          beginAtZero: true
        }
      }
    },
  });
}

function showActuales(id){
  var serie1 = [];
  var serie2 = [];
  var serie3 = [];

  for (x = 0; x < 10; x++) {
    serie1.push((Math.random() + 1).toFixed(2));
    serie2.push((Math.random() + 1).toFixed(2));
    serie3.push((Math.random() + 1).toFixed(2));
  }
  var ctx = document.getElementById(id);
  var myPieChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: ["2016", "2017", "2018", "2019", "2020", "2021", "2022"],
      datasets: [{
        label: "Programado",
        //data: [1.23, 1.45, 1.89,1.78,1.34,1.23,1.56],
        data: serie1,
        fill: false,
        borderColor: 'rgb(75, 192, 192)',
        tension: 0.1,
        hoverBorderColor: "rgba(234, 236, 244, 1)",
      },
      {
        label: "Realizado",
        //data: [1.12, 1.10, 1.00,1.4,1.3,1.6,1.56],
        data: serie2,
        fill: false,
        borderColor: 'rgb(98, 12, 192)',
        tension: 0.1,
        hoverBorderColor: "rgba(234, 236, 244, 1)",
      }
      ],
    },
    options: {
      maintainAspectRatio: true,
      tooltips: {
        backgroundColor: "rgb(255,255,255)",
        bodyFontColor: "#858796",
        borderColor: '#dddfeb',
        borderWidth: 1,
        xPadding: 15,
        yPadding: 15,
        displayColors: false,
        caretPadding: 10,
      },
      legend: {
        display: true
      },
      cutoutPercentage: 80,
      scales: {
        y: {
          beginAtZero: true
        }
      }
    },
  });

}
