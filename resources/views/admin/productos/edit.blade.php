<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Producto
        </h2>
    </x-slot>

    <div class="container-fluid mt-4">

        <div class="card shadow-sm border-0 rounded-4">

            <div class="card-header bg-white">

                <h4 class="fw-bold mb-0">
                    Editar Producto: {{ $producto->nombre }}
                </h4>

            </div>

            <div class="card-body">

                <form action="{{ route('admin.productos.update', $producto->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">

                        <!-- Nombre -->
                        <div class="col-md-12">
                            <label for="nombre" class="form-label fw-bold">
                                Nombre del Producto
                            </label>

                            <input
                                type="text"
                                name="nombre"
                                id="nombre"
                                class="form-control @error('nombre') is-invalid @enderror"
                                value="{{ old('nombre', $producto->nombre) }}"
                                required>

                            @error('nombre')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Código de Barras -->
                        <div class="col-md-6">
                            <label for="codigo_barras" class="form-label fw-bold">
                                Código de Barras
                            </label>

                            <input
                                type="text"
                                name="codigo_barras"
                                id="codigo_barras"
                                class="form-control @error('codigo_barras') is-invalid @enderror"
                                value="{{ old('codigo_barras', $producto->codigo_barras) }}">

                            @error('codigo_barras')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Categoría -->
                        <div class="col-md-6">
                            <label for="id_categoria" class="form-label fw-bold">
                                Categoría
                            </label>

                            <select
                                name="id_categoria"
                                id="id_categoria"
                                class="form-select @error('id_categoria') is-invalid @enderror"
                                required>

                                @foreach($categorias as $categoria)
                                    <option
                                        value="{{ $categoria->id }}"
                                        {{ old('id_categoria', $producto->id_categoria) == $categoria->id ? 'selected' : '' }}>
                                        {{ $categoria->nombre }}
                                    </option>
                                @endforeach

                            </select>

                            @error('id_categoria')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Precio -->
                        <div class="col-md-6">
                            <label for="precio_neto" class="form-label fw-bold">
                                Precio Neto ($)
                            </label>

                            <input
                                type="number"
                                step="0.01"
                                min="0"
                                name="precio_neto"
                                id="precio_neto"
                                class="form-control @error('precio_neto') is-invalid @enderror"
                                value="{{ old('precio_neto', $producto->precio_neto) }}"
                                required>

                            @error('precio_neto')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Stock -->
                        <div class="col-md-6">
                            <label for="stock" class="form-label fw-bold">
                                Stock Disponible
                            </label>

                            <input
                                type="number"
                                min="0"
                                name="stock"
                                id="stock"
                                class="form-control @error('stock') is-invalid @enderror"
                                value="{{ old('stock', $producto->stock) }}"
                                required>

                            @error('stock')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Fecha de Vencimiento -->
                        <div class="col-md-12">
                            <label for="fecha_vencimiento" class="form-label fw-bold">
                                Fecha de Vencimiento
                            </label>

                            <input
                                type="date"
                                name="fecha_vencimiento"
                                id="fecha_vencimiento"
                                class="form-control @error('fecha_vencimiento') is-invalid @enderror"
                                value="{{ old('fecha_vencimiento', optional($producto->fecha_vencimiento)->format('Y-m-d')) }}">

                            @error('fecha_vencimiento')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                    </div>

                    <div class="mt-4 d-flex justify-content-end gap-2">

                        <a href="{{ route('admin.productos.index') }}"
                           class="btn btn-secondary">
                            Cancelar
                        </a>

                        <button type="submit"
                                class="btn btn-primary">
                            Actualizar Producto
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>
</x-app-layout>