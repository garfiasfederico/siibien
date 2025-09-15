// ====== GLOBAL DEFAULTS (Chart.js v2) ======
Chart.defaults.global.defaultFontFamily =
    'Nunito, -apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif';
Chart.defaults.global.defaultFontColor = "#4b5563"; // gris sobrio
Chart.defaults.global.elements.line.borderWidth = 2;
Chart.defaults.global.elements.point.radius = 2.5;
Chart.defaults.global.elements.point.hoverRadius = 5;
Chart.defaults.global.animation.duration = 400;
Chart.defaults.global.animation.easing = "easeOutQuart";
Chart.defaults.global.legend.labels.usePointStyle = true;

// Paleta sobria
const PALETTE = {
    gris: "rgba(90, 102, 122, 1)",
    grisTrans: "rgba(90, 102, 122, 0.15)",
    azul: "rgba(37, 99, 235, 1)",
    azulTrans: "rgba(37, 99, 235, 0.15)",
    verde: "rgba(5, 150, 105, 1)",
    verdeTrans: "rgba(5, 150, 105, 0.15)",
    morado: "rgba(109, 40, 217, 1)",
    moradoTrans: "rgba(109, 40, 217, 0.15)",
};

// Formateador numérico para ejes/tooltips
function fmt(v) {
    if (v == null || isNaN(v)) return "—";
    return Number(v).toLocaleString("es-MX", { maximumFractionDigits: 2 });
}

// Guardar instancias para destruir al redibujar
const CHART_INSTANCES = {};
function destroyIfExists(canvasId) {
    if (CHART_INSTANCES[canvasId]) {
        CHART_INSTANCES[canvasId].destroy();
        delete CHART_INSTANCES[canvasId];
    }
}

// Pie Chart Example
function showHistoricos(id) {
  const canvasId = id;
  const indicadorId = id.replace("chart", "");

  let labels = [];
  let valores = [];

  let tabla_historicos =
    `<div class="table-wrap">
       <table class="table table-sm table-elegant">
         <colgroup>
           <col style="width:28%">
           <col style="width:28%">
           <col style="width:44%">
         </colgroup>
         <thead>
           <tr>
             <th class="th-sticky">Año</th>
             <th class="th-sticky">Ciclo</th>
             <th class="th-sticky text-right">Valor</th>
           </tr>
         </thead>
         <tbody>`;

  $.ajax({
    type: "GET",
    url: "/indicador/historicos",
    data: { idIndicador: indicadorId },
    beforeSend: function () { block(true); },
  })
  .done(function (response) {
    if (response && response.success == "ok" && Array.isArray(response.historicos)) {
      response.historicos.forEach((h) => {
        const anio  = String(h.valoresAnioMedicion || "");
        const ciclo = String(h.valoresCicloMedicion || "");
        const val   = parseFloat(h.valoresValor);
        if (!isNaN(val)) {
          labels.push(anio + " " + ciclo);
          valores.push(val);
        }
        tabla_historicos += `
          <tr>
            <td class="text-nowrap">${anio}</td>
            <td class="text-nowrap">${ciclo}</td>
            <td class="text-right">${fmt(h.valoresValor)}</td>
          </tr>`;
      });
      tabla_historicos += `</tbody></table></div>`;
      $("#historicos_content").html(tabla_historicos);
    }
  })
  .always(function () {
    block(false);

    const ctx = document.getElementById(canvasId);
    if (!ctx) return;

    destroyIfExists(canvasId);

    CHART_INSTANCES[canvasId] = new Chart(ctx, {
      type: "line",
      data: {
        labels: labels,
        datasets: [{
          label: "Histórico",
          data: valores,
          borderColor: PALETTE.gris,
          backgroundColor: "rgba(90,102,122,0.15)",
          fill: true,
          lineTension: 0.3,
          pointRadius: 3,
          pointBackgroundColor: "#fff",
          pointBorderColor: PALETTE.gris,
          pointBorderWidth: 2,
          pointHitRadius: 10,
          spanGaps: true,
        }],
      },
      options: {
        responsive: true,
        maintainAspectRatio: true,
        legend: { display: true, position: "top", labels: { boxWidth: 12, padding: 16, usePointStyle: true } },
        tooltips: {
          mode: "index", intersect: false, backgroundColor: "#fff",
          titleFontColor: "#111827", bodyFontColor: "#374151",
          borderColor: "#e5e7eb", borderWidth: 1, xPadding: 12, yPadding: 12,
          callbacks: { label: (t,d) => `${d.datasets[t.datasetIndex].label}: ${fmt(t.yLabel)}` }
        },
        hover: { mode: "nearest", intersect: true },
        scales: {
          xAxes: [{ gridLines: { color: "rgba(0,0,0,0.06)", zeroLineColor: "rgba(0,0,0,0.06)", drawBorder: false },
                    ticks: { maxRotation: 0, autoSkip: true, autoSkipPadding: 12, padding: 8 } }],
          yAxes: [{ gridLines: { color: "rgba(0,0,0,0.06)", zeroLineColor: "rgba(0,0,0,0.06)", drawBorder: false, tickMarkLength: 3 },
                    ticks: { beginAtZero: true, padding: 8, callback: (v) => fmt(v) } }]
        },
      },
    });
  })
  .fail(function () { block(false); });
}

function showActuales(id) {
  const canvasId = id;
  const indicadorId = id.replace("actuales", "");

  let serieProgramado = [];
  let serieReal = [];
  let labels = [];

  let tabla_programados =
    `<div class="table-wrap">
       <table class="table table-sm table-elegant">
         <colgroup>
           <col style="width:22%">
           <col style="width:22%">
           <col style="width:28%">
           <col style="width:28%">
         </colgroup>
         <thead>
           <tr>
             <th class="th-sticky">Año</th>
             <th class="th-sticky">Ciclo</th>
             <th class="th-sticky text-right">Programado</th>
             <th class="th-sticky text-right">Alcanzado</th>
           </tr>
         </thead>
         <tbody>`;

  $.ajax({
    type: "GET",
    url: "/indicador/valores/programados",
    data: { idIndicador: indicadorId },
    beforeSend: function () { block(true); },
  })
  .done(function (response) {
    if (response && response.success == "ok" && Array.isArray(response.programados)) {
      response.programados.forEach((p) => {
        const anio  = String(p.valoresAnioMedicion || "");
        const ciclo = String(p.valoresCicloMedicion || "");
        const prog  = parseFloat(p.valoresProgramado);
        const real  = parseFloat(p.valoresReal);

        labels.push(anio + " " + ciclo);
        serieProgramado.push(!isNaN(prog) ? prog : null);
        serieReal.push(!isNaN(real) ? real : null);

        tabla_programados += `
          <tr>
            <td class="text-nowrap">${anio}</td>
            <td class="text-nowrap">${ciclo}</td>
            <td class="text-right">${fmt(p.valoresProgramado)}</td>
            <td class="text-right">${fmt(p.valoresReal)}</td>
          </tr>`;
      });
      tabla_programados += `</tbody></table></div>`;
      $("#programados_content").html(tabla_programados);
    }
  })
  .always(function () {
    block(false);

    const ctx = document.getElementById(canvasId);
    if (!ctx) return;

    destroyIfExists(canvasId);

    CHART_INSTANCES[canvasId] = new Chart(ctx, {
      type: "line",
      data: {
        labels: labels,
        datasets: [
          {
            label: "Programado",
            data: serieProgramado,
            borderColor: PALETTE.azul,
            backgroundColor: "rgba(37,99,235,0.15)",   // azul suave
            fill: true,
            lineTension: 0.35,
            borderWidth: 3,
            pointRadius: 3.5,
            pointBackgroundColor: "#fff",
            pointBorderColor: PALETTE.azul,
            pointBorderWidth: 2,
            pointHitRadius: 10,
            spanGaps: true,
          },
          {
            label: "Alcanzado",
            data: serieReal,
            borderColor: PALETTE.verde,
            backgroundColor: "rgba(5,150,105,0.15)",  // verde suave
            fill: true,
            lineTension: 0.35,
            borderWidth: 2,
            pointRadius: 3,
            pointBackgroundColor: "#fff",
            pointBorderColor: PALETTE.verde,
            pointBorderWidth: 2,
            pointHitRadius: 10,
            spanGaps: true,
          },
        ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: true,
        legend: { display: true, position: "top", labels: { boxWidth: 12, padding: 16, usePointStyle: true } },
        tooltips: {
          mode: "index", intersect: false, backgroundColor: "#fff",
          titleFontColor: "#111827", bodyFontColor: "#374151",
          borderColor: "#e5e7eb", borderWidth: 1, xPadding: 12, yPadding: 12,
          callbacks: { label: (t,d) => `${d.datasets[t.datasetIndex].label}: ${fmt(t.yLabel)}` }
        },
        hover: { mode: "nearest", intersect: true },
        scales: {
          xAxes: [{ gridLines: { color: "rgba(0,0,0,0.06)", zeroLineColor: "rgba(0,0,0,0.06)", drawBorder: false },
                    ticks: { maxRotation: 0, autoSkip: true, autoSkipPadding: 12, padding: 8 } }],
          yAxes: [{ gridLines: { color: "rgba(0,0,0,0.06)", zeroLineColor: "rgba(0,0,0,0.06)", drawBorder: false, tickMarkLength: 3 },
                    ticks: { beginAtZero: true, padding: 8, callback: (v) => fmt(v) } }]
        }
      }
    });
  })
  .fail(function () { block(false); });
}
