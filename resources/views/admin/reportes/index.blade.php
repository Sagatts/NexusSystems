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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@push('scripts')

<style>
        @media (max-width: 768px) {
            .dataTables_filter {
                text-align: left !important;
                margin-top: 15px;
            }
            .dataTables_filter label {
                display: flex;
                flex-direction: column;
                width: 100%;
            }
            .dataTables_filter input {
                margin-left: 0 !important;
                margin-top: 8px;
                width: 100% !important;
            }
        }

        div.dataTables_wrapper div.dataTables_filter label {
            display: inline-flex;
            flex-wrap: wrap;
            justify-content: flex-end;
            align-items: center;
            white-space: normal !important; /* Permite que el texto baje a la siguiente línea si no cabe */
        }
        
        div.dataTables_wrapper div.dataTables_filter input {
            width: 250px !important; /* Tamaño fijo ideal para el cuadro de texto */
            max-width: 100%; /* Asegura que no rompa la pantalla si se achica más */
            margin-left: 10px !important;
            margin-top: 5px; /* Le da un respiro si se apila debajo del texto */
        }
</style>
<script>

$(document).ready(function () {
    $('#tablaMovimientos').DataTable({
        scrollX: true,
        pageLength: 10,
        lengthMenu: [
            [10, 25, 50, 100, -1],
            [10, 25, 50, 100, "Todos"]
        ],
        order: [[8, "desc"]], // Subió al índice 8 debido a la nueva columna
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json',
            search: "Buscar por RUT, Usuario o Producto:"
        },
        columnDefs: [
            // Centrar Tipo (3) y columnas numéricas (5, 6, 7) debido al desplazamiento
            {
                targets: [3, 5, 6, 7],
                className: "text-center"
            },
            // Desactivar búsqueda en Cantidad
            {
                targets: 5,
                searchable: false
            },
            // Desactivar búsqueda en Precio
            {
                targets: 6,
                searchable: false
            },
            // Desactivar búsqueda en Total
            {
                targets: 7,
                searchable: false
            },
            // Desactivar búsqueda en Fecha
            {
                targets: 8,
                searchable: false
            }
        ]
    });
});
</script>

@endpush

</x-app-layout>