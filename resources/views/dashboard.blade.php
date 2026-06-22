<x-app-layout>
    <x-slot name="header">
        <h2 style="font-weight: 600; font-size: 1.25rem; color: #1f2937; margin: 0;">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
           ¡Bienvenido, {{ trim(Auth::user()->nombre) }}!
     </h2>

     
    <div class="dashboard-wrapper px-2 px-md-4">
        
        <div class="dashboard-top-wrapper">
            <span class="dashboard-box-title">Resumen de ventas mensuales</span>
            
            <div class="dashboard-top-container">
                <canvas id="graficoVentas"></canvas>
            </div>
        </div>

        <div class="row g-4 mb-4">
            
            <div class="col-12 col-md-6">
                <div class="dashboard-box-wrapper h-100 w-100 d-flex flex-column">
                    <span class="dashboard-box-title">
                        Top 5 Productos Más Retirados
                    </span>
                    <div class="dashboard-box p-3 flex-grow-1">
                        <div style="position: relative; height: 100%; width: 100%;">
                            <canvas id="graficoProductos"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="dashboard-box-wrapper h-100 w-100 d-flex flex-column">
                    <span class="dashboard-box-title">
                        Ventas por Categoría
                    </span>
                    <div class="dashboard-box p-3 flex-grow-1">
                        <div style="position: relative; height: 100%; width: 100%;">
                            <canvas id="graficoCategorias"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-12 col-md-6">
                <div class="dashboard-box-wrapper h-100 w-100 d-flex flex-column">
                    <span class="dashboard-box-title">
                        Productos Próximos a Vencer
                    </span>
                    <div class="dashboard-box flex-grow-1">
                        <div class="table-responsive">
                            <table class="custom-table table table-hover align-middle text-nowrap w-100 mb-0">
                                <thead class="table-light">
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
                                            <td colspan="4" class="text-center py-4">
                                                No existen productos registrados.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="dashboard-box-wrapper h-100 w-100 d-flex flex-column">
                    <span class="dashboard-box-title">
                        Productos con Stock Crítico
                    </span>
                    <div class="dashboard-box flex-grow-1">
                        <div class="table-responsive">
                            <table class="custom-table table table-hover align-middle text-nowrap w-100 mb-0">
                                <thead class="table-light">
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
                                            <td colspan="3" class="text-center py-4">
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

        </div>
    </div>

    <script>
        window.labelsVentas = @json($labels);
        window.totalesVentas = @json($totales);
        window.labelsMasRetirados = @json($labelsMasRetirados);
        window.totalesMasRetirados = @json($totalesMasRetirados);
        window.labelsMenosRetirados = @json($labelsMenosRetirados);
        window.totalesMenosRetirados = @json($totalesMenosRetirados);
        window.labelsCategorias = @json($labelsCategorias);
        window.totalesCategorias = @json($totalesCategorias);
    </script>

    @stack('scripts')

</x-app-layout>