<x-app-layout>

<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Gestión de Reportes
    </h2>
</x-slot>

<div class="container-fluid py-4">
    <div class="container-fluid mt-4">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h4 class="fw-bold mb-0">
                    Historial de Movimientos
                </h4>
                <button class="btn btn-success fw-bold">
                    <i class="bi bi-file-earmark-excel me-1"></i>
                    Generar Reporte
                </button>
            </div>
            <div class="card-body">
                <table id="tablaMovimientos"
                    class="table table-striped table-hover align-middle w-100">
                    <thead class="table-dark">
                        <tr>
                            <th>RUT</th>
                            <th>Código Barras</th>
                            <th>Usuario</th>
                            <th>Producto</th>
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

                            <td>{{ $mov->producto }}</td>

                            <td>{{ $mov->cantidad }}</td>

                            <td>
                                ${{ number_format($mov->precio_neto,0,',','.') }}
                            </td>

                            <td>
                                ${{ number_format($mov->precio_neto * $mov->cantidad,0,',','.') }}
                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($mov->fecha_hora)->format('d/m/Y H:i') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@push('scripts')
<script>
$(document).ready(function () {

    $('#tablaMovimientos').DataTable({

        pageLength: 10,

        lengthMenu: [
            [10, 25, 50, 100, -1],
            [10, 25, 50, 100, "Todos"]
        ],

        order: [[7, "desc"]],

        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json',
            search: "Buscar por RUT, Usuario o Producto:"
        },

        columnDefs: [

            // Centrar columnas numéricas
            {
                targets: [4, 5, 6],
                className: "text-center"
            },

            // Desactivar búsqueda en Cantidad
            {
                targets: 4,
                searchable: false
            },

            // Desactivar búsqueda en Precio
            {
                targets: 5,
                searchable: false
            },

            // Desactivar búsqueda en Total
            {
                targets: 6,
                searchable: false
            },

            // Desactivar búsqueda en Fecha
            {
                targets: 7,
                searchable: false
            }

        ]

    });

});
</script>

@endpush

</x-app-layout>