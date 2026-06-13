<x-app-layout>
    <x-slot name="header">
        <h2 style="font-weight: 600; font-size: 1.25rem; color: #1f2937; margin: 0;">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
           ¡Bienvenido, {{ trim(Auth::user()->nombre) }}!
     </h2>
    <div class="dashboard-wrapper">
        
        <div class="dashboard-top-wrapper">
            <span class="dashboard-box-title">Resumen de ventas mensuales</span>
            
            <div class="dashboard-top-container">
                <canvas id="graficoVentas"></canvas>
            </div>
        </div>

        <div class="dashboard-grid">
            <div class="col-lg-6">
                <div class="card shadow-sm border-0 rounded-4 h-100">
                    <div class="card-header bg-white">
                        <h5 class="fw-bold mb-0">
                            Top 5 Productos Más Retirados
                        </h5>
                    </div>

                    <div class="card-body">
                        <canvas id="graficoProductos"></canvas>
                    </div>
                </div>
            </div>

            <!-- Ventas por categoría -->
            <div class="col-lg-6">
                <div class="card shadow-sm border-0 rounded-4 h-100">
                    <div class="card-header bg-white">
                        <h5 class="fw-bold mb-0">
                            Ventas por Categoría
                        </h5>
                    </div>

                    <div class="card-body">
                        <canvas id="graficoCategorias"></canvas>
                    </div>
                </div>
            </div>
            <div class="dashboard-box-wrapper">
                <span class="dashboard-box-title">
                    Productos Próximos a Vencer
                </span>
                <div class="dashboard-box">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th>Código Barras</th>
                                <th>Nombre</th>
                                <th>Stock</th>
                                <th>Fecha Vencimiento</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($productosPorVencer as $producto)
                                <tr>
                                    <td>{{ $producto->codigo_barras }}</td>

                                    <td>{{ $producto->nombre }}</td>

                                    <td>{{ $producto->stock }}</td>

                                    <td>
                                        {{ \Carbon\Carbon::parse($producto->fecha_vencimiento)->format('d/m/Y') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">
                                        No existen productos registrados.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="dashboard-box-wrapper">
                <span class="dashboard-box-title">
                    Productos con Stock Crítico
                </span>

                <div class="dashboard-box">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th>Código Barras</th>
                                <th>Nombre</th>
                                <th>Stock</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($productosStockMinimo as $producto)
                                <tr>
                                    <td>{{ $producto->codigo_barras }}</td>

                                    <td>{{ $producto->nombre }}</td>

                                    <td>
                                        @if($producto->stock <= 10)
                                            <span class="badge bg-danger">
                                                {{ $producto->stock }}
                                            </span>

                                        @elseif($producto->stock <= 20)
                                            <span class="badge bg-warning text-dark">
                                                {{ $producto->stock }}
                                            </span>

                                        @else
                                            <span class="badge bg-success">
                                                {{ $producto->stock }}
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">
                                        No existen productos registrados
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {

        const ctx = document.getElementById('graficoVentas');

        const labels = @json($labels);
        const datos = @json($totales);

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Ventas Mensuales ($)',
                    data: datos,

                    borderColor: '#dc2626',
                    backgroundColor: 'rgba(220,38,38,0.15)',

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
                    legend: {
                        display: true
                    },

                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return '$' +
                                    context.raw.toLocaleString('es-CL');
                            }
                        }
                    }
                },

                scales: {
                    y: {
                        beginAtZero: true,

                        ticks: {
                            callback: function(value) {
                                return '$' +
                                    value.toLocaleString('es-CL');
                            }
                        }
                    }
                }
            }
        });

    });
    </script>
    <script>
    // ==========================
    // RESUMEN DE VENTAS MENSUALES
    // ==========================

    const ventasCtx =
        document.getElementById('graficoVentas');

    new Chart(ventasCtx, {

        type: 'line',

        data: {

            labels: @json($labels),

            datasets: [{
                label: 'Ventas Mensuales ($)',

                data: @json($totales),

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

                legend: {
                    display: true
                },

                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return '$' +
                                context.raw.toLocaleString('es-CL');
                        }
                    }
                }
            },

            scales: {

                y: {
                    beginAtZero: true,

                    ticks: {
                        callback: function(value) {
                            return '$' +
                                value.toLocaleString('es-CL');
                        }
                    }
                }
            }
        }
    });

</script>
<script>

    // ==========================
    // PRODUCTOS MÁS / MENOS RETIRADOS
    // ==========================

    const labelsMas = @json($labelsMasRetirados);
    const datosMas = @json($totalesMasRetirados);

    const labelsMenos = @json($labelsMenosRetirados);
    const datosMenos = @json($totalesMenosRetirados);

    const ctxProductos =
        document.getElementById('graficoProductos');

    const graficoProductos = new Chart(ctxProductos, {

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

            plugins: {
                legend: {
                    display: false
                }
            },

            scales: {
                x: {
                    beginAtZero: true
                }
            }
        }

    });

    // Selector Más/Menos retirados

    document.getElementById('tipoGraficoProductos')
        ?.addEventListener('change', function () {

            if (this.value === 'mas') {

                graficoProductos.data.labels = labelsMas;

                graficoProductos.data.datasets[0].data = datosMas;

                graficoProductos.data.datasets[0].backgroundColor =
                    '#ff3333';

                graficoProductos.data.datasets[0].borderColor =
                    '#e62e2e';

            } else {

                graficoProductos.data.labels = labelsMenos;

                graficoProductos.data.datasets[0].data = datosMenos;

                graficoProductos.data.datasets[0].backgroundColor =
                    '#374151';

                graficoProductos.data.datasets[0].borderColor =
                    '#1f2937';
            }

            graficoProductos.update();
        });


    // ==========================
    // VENTAS POR CATEGORÍA
    // ==========================

    const ctxCategorias =
        document.getElementById('graficoCategorias');

    new Chart(ctxCategorias, {

        type: 'bar',

        data: {

            labels: @json($labelsCategorias),

            datasets: [{
                label: 'Ventas ($)',

                data: @json($totalesCategorias),

                backgroundColor: '#ff3333',
                borderColor: '#e62e2e',
                borderWidth: 1,
                borderRadius: 8
            }]
        },

        options: {

            indexAxis: 'y',

            responsive: true,

            plugins: {

                legend: {
                    display: false
                },

                tooltip: {
                    callbacks: {
                        label: function(context) {

                            return '$' +
                                context.raw.toLocaleString('es-CL');

                        }
                    }
                }
            },

            scales: {

                x: {

                    beginAtZero: true,

                    ticks: {

                        callback: function(value) {

                            return '$' +
                                value.toLocaleString('es-CL');

                        }
                    }
                }
            }
        }
    });

</script>

</x-app-layout>