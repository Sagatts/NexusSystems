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
                
                <select id="filtro_categoria" class="form-select form-select-sm d-inline-block w-auto me-3 d-none mb-3">
                    <option value="">Todas las categorías</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                    @endforeach
                </select>

                <table id="tablaProductos" class="table table-striped table-hover align-middletext-nowrap" style="width: 100%;">
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

    @stack('scripts')
</x-app-layout>