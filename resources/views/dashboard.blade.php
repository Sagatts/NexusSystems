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
                <span class="dashboard-box-title">Usuarios del Sistema</span>

                <div class="dashboard-box">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th>RUT</th>
                                <th>Nombre</th>
                                <th>Rol</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($usuarios as $usuario)
                                <tr>
                                    <td>{{ $usuario->rut }}</td>
                                    <td>{{ $usuario->nombre }}</td>
                                    <td>
                                        @if($usuario->rol == 'administrador')
                                            <span class="badge active">Administrador</span>
                                        @elseif($usuario->rol == 'garzon')
                                            <span class="badge active">Garzón</span>
                                        @else
                                            <span class="badge inactive">Cocina</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">
                                        No existen usuarios registrados
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
</x-app-layout>