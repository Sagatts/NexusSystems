<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Gestión de Productos
        </h2>
    </x-slot>

    <div class="container-fluid mt-4">

        <div class="card shadow-sm border-0 rounded-4">

            <div class="card-header bg-white d-flex justify-content-between align-items-center pt-3 pb-3">

                <h4 class="fw-bold mb-0">
                    Inventario de Productos
                </h4>

                <a href="{{ route('admin.productos.create') }}" class="btn btn-success shadow-sm fw-bold">
                    <i class="bi bi-plus-circle me-1"></i>
                    Nuevo Producto
                </a>

            </div>

            <div class="card-body p-4">

                <select id="filtro_categoria" class="form-select form-select-sm d-inline-block w-auto me-3 d-none shadow-sm">
                    <option value="">Todas las categorías</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                    @endforeach
                </select>

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

    @push('scripts')
    <script>
        $(document).ready(function () {

            let tabla = $('#tablaProductos').DataTable({

                processing: true,
                serverSide: true,
                ajax:{ 
                    url: "{{ route('admin.productos.datatable') }}",
                    data: function (d) {
                        d.categoria = $('#filtro_categoria').val();
                    }
                },
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json',
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
                ],

                initComplete: function() {
                    $('#filtro_categoria').removeClass('d-none');

                    $('.dataTables_filter label').before($('#filtro_categoria'));
                }

            });

            $('#filtro_categoria').change(function () {
                $('#tablaProductos').DataTable().ajax.reload();
            });

            $('#filtro_categoria').change(function(){
                tabla.ajax.reload();
            });

        });
    </script>
    @endpush

</x-app-layout>