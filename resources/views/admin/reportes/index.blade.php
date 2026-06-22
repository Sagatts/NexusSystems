<x-app-layout>
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Historial de movimientos
    </h2>
</x-slot>
<div class="container-fluid mt-4">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h4 class="fw-bold mb-0">
                Historial de Movimientos
            </h4>
            <a href="{{ route('admin.reportes.create') }}" class="btn btn-success fw-bold">
                <i class="bi bi-file-earmark-plus me-1"></i>
                Configurar Reporte
            </a>
        </div>
        <div class="card-body">
            <table id="tablaMovimientos" class="table table-striped table-hover align-middle w-100">
                <thead class="table-dark">
                    <tr>
                        <th>RUT</th>
                        <th>Código Barras</th>
                        <th>Usuario</th>
                        <th>Tipo</th> <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Total</th>
                        <th>Fecha y Hora</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($movimientos as $mov)
                    <tr>
                        <td>{{ $mov->rut }}</td>
                        <td>{{ $mov->codigo_barras }}</td>
                        <td>{{ $mov->usuario }}</td>
                        <td>
                            @if($mov->tipo_movimiento === 'Entrada')
                                <span class="badge bg-success text-white fw-bold px-2 py-1.5">
                                    <i class="bi bi-arrow-down-left-circle-fill me-1"></i> Entrada
                                </span>
                            @else
                                <span class="badge bg-danger text-white fw-bold px-2 py-1.5">
                                    <i class="bi bi-arrow-up-right-circle-fill me-1"></i> Salida
                                </span>
                            @endif
                        </td>
                        <td>{{ $mov->producto }}</td>
                        <td>{{ $mov->cantidad }}</td>
                        <td>${{ number_format($mov->precio_neto, 0, ',', '.') }}</td>
                        <td>${{ number_format($mov->precio_neto * $mov->cantidad, 0, ',', '.') }}</td>
                        <td>{{ \Carbon\Carbon::parse($mov->fecha_hora)->format('d/m/Y H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@stack('scripts')

</x-app-layout>