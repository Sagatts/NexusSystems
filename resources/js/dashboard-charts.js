/**
 * Gráficos del Dashboard
 * Chart.js para ventas mensuales y productos más/menos retirados
 */

document.addEventListener('DOMContentLoaded', function () {

    // ==========================
    // RESUMEN DE VENTAS MENSUALES
    // ==========================

    const ventasCtx = document.getElementById('graficoVentas');

    if (ventasCtx && typeof Chart !== 'undefined') {
        new Chart(ventasCtx, {
            type: 'line',

            data: {
                labels: window.labelsVentas || [],

                datasets: [{
                    label: 'Ventas Mensuales ($)',
                    data: window.totalesVentas || [],

                    borderColor: '#ff3333',
                    backgroundColor: 'rgba(255, 51, 51, 0.15)',

                    borderWidth: 3,
                    tension: 0.4,
                    fill: true,

                    pointRadius: 5,
                    pointHoverRadius: 8
                }]
            },

            options: {
                responsive: true,
                maintainAspectRatio: false,

                plugins: {
                    legend: { display: true },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return '$' + context.raw.toLocaleString('es-CL');
                            }
                        }
                    }
                },

                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '$' + value.toLocaleString('es-CL');
                            }
                        }
                    }
                }
            }
        });
    }


    // ==========================
    // PRODUCTOS MÁS / MENOS RETIRADOS
    // ==========================

    const labelsMas = window.labelsMasRetirados || [];
    const datosMas = window.totalesMasRetirados || [];

    const labelsMenos = window.labelsMenosRetirados || [];
    const datosMenos = window.totalesMenosRetirados || [];

    const ctxProductos = document.getElementById('graficoProductos');

    let graficoProductos = null;

    if (ctxProductos && typeof Chart !== 'undefined') {

        graficoProductos = new Chart(ctxProductos, {

            type: 'bar',

            data: {
                labels: labelsMas,

                datasets: [{
                    label: 'Cantidad Retirada',
                    data: datosMas,
                    backgroundColor: '#ff3333',
                    borderColor: '#e62e2e',
                    borderWidth: 1,
                    borderRadius: 8
                }]
            },

            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,

                plugins: {
                    legend: { display: false }
                },

                scales: {
                    x: { beginAtZero: true }
                }
            }
        });
    }


    // Selector Más / Menos retirados

    const tipoGraficoSelect = document.getElementById('tipoGraficoProductos');

    if (tipoGraficoSelect && graficoProductos) {
        tipoGraficoSelect.addEventListener('change', function () {

            if (this.value === 'mas') {
                graficoProductos.data.labels = labelsMas;
                graficoProductos.data.datasets[0].data = datosMas;
                graficoProductos.data.datasets[0].backgroundColor = '#ff3333';
                graficoProductos.data.datasets[0].borderColor = '#e62e2e';
            } else {
                graficoProductos.data.labels = labelsMenos;
                graficoProductos.data.datasets[0].data = datosMenos;
                graficoProductos.data.datasets[0].backgroundColor = '#374151';
                graficoProductos.data.datasets[0].borderColor = '#1f2937';
            }

            graficoProductos.update();
        });
    }


    // ==========================
    // VENTAS POR CATEGORÍA
    // ==========================

    const ctxCategorias = document.getElementById('graficoCategorias');

    if (ctxCategorias && typeof Chart !== 'undefined') {
        new Chart(ctxCategorias, {
            type: 'bar',
            data: {
                labels: window.labelsCategorias || [],
                datasets: [{
                    label: 'Ventas ($)',
                    data: window.totalesCategorias || [],
                    backgroundColor: '#ff3333',
                    borderColor: '#e62e2e',
                    borderWidth: 1,
                    borderRadius: 8
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return '$' + context.raw.toLocaleString('es-CL');
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '$' + value.toLocaleString('es-CL');
                            }
                        }
                    }
                }
            }
        });
    }
});