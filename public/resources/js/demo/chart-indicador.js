// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

// Pie Chart Example

function showHistoricos(id) {

  //Obtenermos los valores historicos registrados
  labels = [];
  valores = [];
  tabla_historicos = "<table class='table' style='width:100%'><tr><th>Año de Medición</th><th>Ciclo de Medición</th><th>Valor</th></tr>";

  $.ajax({
    type: 'GET',
    url: "/indicador/historicos",
    data: {
      idIndicador: id.replace("chart", ""),
    },
    beforeSend: function () {
      block(true)
    },
    success: function (response) {
      if (response.success = "ok") {
        for (i = 0; i < response.historicos.length; i++) {
          labels.push(response.historicos[i].valoresAnioMedicion + " " + response.historicos[i].valoresCicloMedicion);
          valores.push(response.historicos[i].valoresValor);
          tabla_historicos += "<tr><td>"+response.historicos[i].valoresAnioMedicion+"</td><td>"+response.historicos[i].valoresCicloMedicion+"</td><td>"+response.historicos[i].valoresValor+"</td></tr>"
        }
       tabla_historicos+="</table>"
       $("#historicos_content").html(tabla_historicos);
      }
    }
  }).done(function (response) {
    block(false);
  }).fail(function (data) {
    block(false);
  })


  /*
    var serie1 = [];
    var serie2 = [];

    for (x = 0; x < 10; x++) {
      serie1.push((Math.random() + 1).toFixed(2));
      serie2.push((Math.random() + 1).toFixed(2));
    }*/
  var ctx = document.getElementById(id);
  var myPieChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: labels,//["2016", "2017", "2018", "2019", "2020", "2021", "2022"],
      datasets: [{
        label: "Histórico",
        //data: [1.23, 1.45, 1.89,1.78,1.34,1.23,1.56],
        data: valores,
        fill: false,
        borderColor: 'rgb(140, 140, 140)',
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

function showActuales(id) {
  var serie1 = [];
  var serie2 = [];
  var labels = [];

  tabla_programados = "<table class='table' style='width:100%'><tr><th>Año de Medición</th><th>Ciclo de Medición</th><th>Valor Programado</th><th>Valor Alcanzado</th></tr>";

  //for (x = 0; x < 10; x++) {
  //  serie1.push((Math.random() + 1).toFixed(2));
  //  serie2.push((Math.random() + 1).toFixed(2));
  //  serie3.push((Math.random() + 1).toFixed(2));
  // }

  $.ajax({
    type: 'GET',
    url: "/indicador/valores/programados",
    data: {
      idIndicador: id.replace("actuales", ""),
    },
    beforeSend: function () {
      block(true)
    },
    success: function (response) {
      if (response.success = "ok") {
        for (i = 0; i < response.programados.length; i++) {
          labels.push(response.programados[i].valoresAnioMedicion + " " + response.programados[i].valoresCicloMedicion);
          serie1.push(response.programados[i].valoresProgramado);
          if(!parseFloat(response.programados[i].valoresReal)==0)
            serie2.push(response.programados[i].valoresReal);
          tabla_programados += "<tr><td>"+response.programados[i].valoresAnioMedicion+"</td><td>"+response.programados[i].valoresCicloMedicion+"</td><td>"+response.programados[i].valoresProgramado+"</td><td>"+response.programados[i].valoresReal+"</td></tr>"
        }
        tabla_programados+="</table>"
        $("#programados_content").html(tabla_programados);
      }
    }
  }).done(function (response) {
    block(false);
  }).fail(function (data) {
    block(false);
  })



  var ctx = document.getElementById(id);
  var myPieChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: labels,
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
