<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Gestión de Productos
        </h2>
    </x-slot>

    <div class="container-fluid mt-4">

        <div class="card shadow-sm border-0 rounded-4">

            <div class="card-header bg-white d-flex justify-content-between align-items-center">

                <h4 class="fw-bold mb-0">
                    Inventario de Productos
                </h4>

                <button class="btn btn-success">
                    <i class="bi bi-plus-circle"></i>
                    Nuevo Producto
                </button>

            </div>

            <div class="card-body">

                <table id="tablaProductos" class="table table-striped table-hover align-middle w-100">

                    <thead class="table-dark">

                        <tr>
                            <th>ID</th>
                            <th>Código Barras</th>
                            <th>Nombre</th>
                            <th>Precio Neto</th>
                            <th>Stock</th>
                            <th>Fecha de Vencimiento</th>
                            <th>Categoría</th>
                            <th>Acciones</th>
                        </tr>

                    </thead>

                    <tbody>
                    </tbody>

                </table>

            </div>

        </div>

    </div>

    @push('scripts')

    <script>

        $(document).ready(function () {

            $('#tablaProductos').DataTable({


                processing: true,
                serverSide: true,

                ajax: "{{ route('admin.productos.datatable') }}",

                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json',
                    search: "Buscar por nombre:"
                },

                columns: [

                    { data: 'id', name: 'id' },

                    {
                        data: 'codigo_barras',
                        name: 'codigo_barras'
                    },

                    {
                        data: 'nombre',
                        name: 'nombre'
                    },

                    {
                        data: 'precio_neto',
                        name: 'precio_neto'
                    },

                    {
                        data: 'stock',
                        name: 'stock'
                    },

                    {
                        data: 'fecha_vencimiento',
                        name: 'fecha_vencimiento'
                    },

                    {
                        data: 'categoria',
                        name: 'categoria'
                    },

                    {
                        data: 'acciones',
                        name: 'acciones',
                        orderable: false,
                        searchable: false
                    }

                ]

            });

        });

    </script>

    @endpush

</x-app-layout>