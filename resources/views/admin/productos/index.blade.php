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

                <a href="{{ route('admin.productos.create') }}" class="btn btn-success">
                    <i class="bi bi-plus-circle"></i>
                    Nuevo Producto
                </a>

            </div>

            <div class="card-body">

                <table id="tablaProductos" class="table table-striped table-hover align-middle w-100">

                    <thead class="table-dark">

                        <tr>
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

    <!-- Modal Eliminar -->
    <div class="modal fade" id="modalEliminar" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        Eliminar Producto
                    </h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    ¿Está seguro que desea eliminar el producto?
                    <strong id="nombreProducto"></strong>
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">
                        Cancelar
                    </button>
                    <form id="formEliminar" method="POST">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger">
                            Sí, eliminar
                        </button>
                    </form>
                </div>
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

    <script>

        const rutaEliminarProducto = "{{ url('admin/productos') }}";

        function abrirModalEliminar(id, nombre)
        {
            document.getElementById('nombreProducto').innerText = nombre;

            document.getElementById('formEliminar').action =
                rutaEliminarProducto + '/' + id;

            new bootstrap.Modal(
                document.getElementById('modalEliminar')
            ).show();
        }

    </script>

    @endpush

</x-app-layout>