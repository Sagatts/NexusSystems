<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Crear Nuevo Producto
        </h2>
    </x-slot>

    <div class="container-fluid mt-4">

        <div class="card shadow-sm border-0 rounded-4">

            <div class="card-header bg-white">

                <h4 class="fw-bold mb-0">
                    Detalles del Nuevo Producto
                </h4>

            </div>

            <div class="card-body">
                <form id="productoForm" action="{{ route('admin.productos.store') }}" method="POST" novalidate>
                    @csrf
                    
                    <div class="row g-3">

                        <!-- Nombre -->
                        <div class="col-md-12 mb-3">
                            <label for="nombre" class="form-label fw-bold">Nombre del Producto</label>

                            <input
                                type="text"
                                name="nombre"
                                id="nombre"
                                class="form-control @error('nombre') is-invalid @enderror"
                                value="{{ old('nombre') }}">

                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <div id="nombreError" class="text-danger small mt-1"></div>
                        </div>

                        <!-- Código de Barras -->
                        <div class="col-md-6 mb-3">
                            <label for="codigo_barras" class="form-label fw-bold">Código de Barras</label>

                            <input
                                type="text"
                                name="codigo_barras"
                                id="codigo_barras"
                                class="form-control @error('codigo_barras') is-invalid @enderror"
                                value="{{ old('codigo_barras') }}">

                            @error('codigo_barras')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <div id="codigoError" class="text-danger small mt-1"></div>
                        </div>

                        <!-- Categoría -->
                        <div class="col-md-6 mb-3">
                            <label for="id_categoria" class="form-label fw-bold">Categoría</label>

                            <select
                                name="id_categoria"
                                id="id_categoria"
                                class="form-select @error('id_categoria') is-invalid @enderror">

                                <option value="">Seleccione una categoría</option>

                                @foreach($categorias as $categoria)
                                    <option
                                        value="{{ $categoria->id }}"
                                        {{ old('id_categoria') == $categoria->id ? 'selected' : '' }}>
                                        {{ $categoria->nombre }}
                                    </option>
                                @endforeach

                            </select>

                            @error('id_categoria')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <div id="categoriaError" class="text-danger small mt-1"></div>
                        </div>

                        <!-- Precio Neto -->
                        <div class="col-md-6 mb-3">
                            <label for="precio_neto" class="form-label fw-bold">Precio Neto ($)</label>

                            <input
                                type="number"
                                name="precio_neto"
                                id="precio_neto"
                                class="form-control @error('precio_neto') is-invalid @enderror"
                                value="{{ old('precio_neto') }}"
                                min="0"
                                step="0.01">

                            @error('precio_neto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <div id="precioError" class="text-danger small mt-1"></div>
                        </div>

                        <!-- Stock -->
                        <div class="col-md-6 mb-3">
                            <label for="stock" class="form-label fw-bold">Stock Inicial</label>

                            <input
                                type="number"
                                name="stock"
                                id="stock"
                                class="form-control @error('stock') is-invalid @enderror"
                                value="{{ old('stock', 0) }}"
                                min="0">

                            @error('stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <div id="stockError" class="text-danger small mt-1"></div>
                        </div>

                        <!-- Fecha -->
                        <div class="col-md-12 mb-3">
                            <label for="fecha_vencimiento" class="form-label fw-bold">
                                Fecha de Vencimiento
                            </label>

                            <input
                                type="date"
                                name="fecha_vencimiento"
                                id="fecha_vencimiento"
                                min="{{ date('Y-m-d') }}"
                                class="form-control @error('fecha_vencimiento') is-invalid @enderror"
                                value="{{ old('fecha_vencimiento') }}">

                            @error('fecha_vencimiento')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <div id="fechaError" class="text-danger small mt-1"></div>
                        </div>

                    </div>

                    <div class="mt-4 d-flex justify-content-end gap-2 border-top pt-4">

                        <a href="{{ route('admin.productos.index') }}"
                        class="btn btn-secondary fw-bold shadow-sm">
                            Cancelar
                        </a>

                        <button type="submit" class="btn btn-success fw-bold shadow-sm">
                            <i class="bi bi-save me-1"></i>
                            Guardar Producto
                        </button>

                    </div>

                </form>
            </div>

        </div>

    </div>


<script>
document.addEventListener('DOMContentLoaded', function() {

    const form = document.getElementById('productoForm');

    const nombre = document.getElementById('nombre');
    const codigo = document.getElementById('codigo_barras');
    const categoria = document.getElementById('id_categoria');
    const precio = document.getElementById('precio_neto');
    const stock = document.getElementById('stock');
    const fecha = document.getElementById('fecha_vencimiento');

    form.addEventListener('submit', function(e) {

        let valido = true;

        document.querySelectorAll('.error-js').forEach(el => el.remove());

        function mostrarError(campo, mensaje) {

            valido = false;

            campo.classList.add('is-invalid');

            const div = document.createElement('div');
            div.className = 'invalid-feedback error-js';
            div.innerText = mensaje;

            campo.parentNode.appendChild(div);
        }

        document.querySelectorAll('.is-invalid').forEach(el => {
            el.classList.remove('is-invalid');
        });

        if (nombre.value.trim() === '') {
            mostrarError(nombre, 'Debe ingresar un nombre.');
        }

        if (codigo.value.trim() === '') {

            codigo.classList.add('is-invalid');
            codigoError.textContent =
                'Debe ingresar un código de barras.';
            valido = false;
        }

        if (categoria.value === '') {
            mostrarError(categoria, 'Debe seleccionar una categoría.');
        }

        if (precio.value === '' || parseFloat(precio.value) < 0) {
            mostrarError(precio, 'Ingrese un precio válido.');
        }

        if (stock.value === '' || parseInt(stock.value) < 0) {
            mostrarError(stock, 'Ingrese un stock válido.');
        }

        // Fecha obligatoria
        if (fecha.value === '') {

            fecha.classList.add('is-invalid');
            fechaError.textContent =
                'Debe ingresar una fecha de vencimiento.';
            valido = false;

        } else {

            const hoy = new Date();
            hoy.setHours(0, 0, 0, 0);

            const fechaIngresada = new Date(fecha.value);

            if (fechaIngresada < hoy) {

                fecha.classList.add('is-invalid');
                fechaError.textContent =
                    'La fecha de vencimiento no puede ser anterior a hoy.';
                valido = false;
            }
        }

        if (!valido) {
            e.preventDefault();
        }
    });
});
</script>

</x-app-layout>
