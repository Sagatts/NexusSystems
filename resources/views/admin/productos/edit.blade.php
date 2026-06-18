<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Producto: {{ $producto->nombre }}
        </h2>
    </x-slot>

    <div class="container-fluid mt-4">

        <div class="card shadow-sm border-0 rounded-4">

            <div class="card-header bg-white">
                <h4 class="fw-bold mb-0">
                    Actualizar Datos del Producto
                </h4>
            </div>

            <div class="card-body">
                <form id="productoForm" action="{{ route('admin.productos.update', $producto->id) }}" method="POST" novalidate>
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-12 mb-3">
                            <label for="nombre" class="form-label fw-bold">
                                Nombre del Producto
                            </label>

                            <input
                                type="text"
                                name="nombre"
                                id="nombre"
                                class="form-control @error('nombre') is-invalid @enderror"
                                value="{{ old('nombre', $producto->nombre) }}">

                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <div id="nombreError" class="text-danger small mt-1"></div>
                        </div>

                        <div class="col-md-6 mb-3">
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
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <div id="codigoError" class="text-danger small mt-1"></div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="id_categoria" class="form-label fw-bold">
                                Categoría
                            </label>

                            <select
                                name="id_categoria"
                                id="id_categoria"
                                class="form-select @error('id_categoria') is-invalid @enderror">

                                <option value="">Seleccione una categoría</option>

                                @foreach($categorias as $categoria)
                                    <option
                                        value="{{ $categoria->id }}"
                                        {{ old('id_categoria', $producto->id_categoria) == $categoria->id ? 'selected' : '' }}>
                                        {{ $categoria->nombre }}
                                    </option>
                                @endforeach

                            </select>

                            @error('id_categoria')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <div id="categoriaError" class="text-danger small mt-1"></div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="precio_neto" class="form-label fw-bold">
                                Precio Neto ($)
                            </label>

                            <input
                                type="number"
                                name="precio_neto"
                                id="precio_neto"
                                class="form-control @error('precio_neto') is-invalid @enderror"
                                value="{{ old('precio_neto', $producto->precio_neto) }}"
                                min="0"
                                step="0.01">

                            @error('precio_neto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <div id="precioError" class="text-danger small mt-1"></div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="stock" class="form-label fw-bold">
                                Stock
                            </label>

                            <input
                                type="number"
                                name="stock"
                                id="stock"
                                class="form-control @error('stock') is-invalid @enderror"
                                value="{{ old('stock', $producto->stock) }}"
                                min="0">

                            @error('stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <div id="stockError" class="text-danger small mt-1"></div>
                        </div>

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
                                value="{{ old('fecha_vencimiento', optional($producto->fecha_vencimiento)->format('Y-m-d')) }}">

                            @error('fecha_vencimiento')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <div id="fechaError" class="text-danger small mt-1"></div>
                        </div>
                    </div>

                    <div class="mt-4 d-flex justify-content-end gap-2 border-top pt-4">
                        <a href="{{ route('admin.productos.index') }}" class="btn btn-secondary fw-bold shadow-sm">
                            Cancelar
                        </a>
                        <button type="submit" class="btn btn-success fw-bold shadow-sm">
                            <i class="bi bi-arrow-clockwise me-1"></i> Actualizar Producto
                        </button>
                    </div>
                </form>
            </div>

        </div>

    </div>

    <script>
document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('productoForm');

    const nombre = document.getElementById('nombre');
    const codigo = document.getElementById('codigo_barras');
    const categoria = document.getElementById('id_categoria');
    const precio = document.getElementById('precio_neto');
    const stock = document.getElementById('stock');
    const fecha = document.getElementById('fecha_vencimiento');

    const nombreError = document.getElementById('nombreError');
    const codigoError = document.getElementById('codigoError');
    const categoriaError = document.getElementById('categoriaError');
    const precioError = document.getElementById('precioError');
    const stockError = document.getElementById('stockError');
    const fechaError = document.getElementById('fechaError');

    function limpiarErrores() {

        document.querySelectorAll('.is-invalid').forEach(campo => {
            campo.classList.remove('is-invalid');
        });

        nombreError.textContent = '';
        codigoError.textContent = '';
        categoriaError.textContent = '';
        precioError.textContent = '';
        stockError.textContent = '';
        fechaError.textContent = '';
    }

    form.addEventListener('submit', function (e) {

        limpiarErrores();

        let valido = true;

        if (nombre.value.trim() === '') {
            nombre.classList.add('is-invalid');
            nombreError.textContent =
                'Debe ingresar el nombre del producto.';
            valido = false;
        }

        if (codigo.value.trim() === '') {
            codigo.classList.add('is-invalid');
            codigoError.textContent =
                'Debe ingresar un código de barras.';
            valido = false;
        }

        if (categoria.value === '') {
            categoria.classList.add('is-invalid');
            categoriaError.textContent =
                'Debe seleccionar una categoría.';
            valido = false;
        }

        if (precio.value === '') {
            precio.classList.add('is-invalid');
            precioError.textContent =
                'Debe ingresar el precio del producto.';
            valido = false;
        } else if (parseFloat(precio.value) < 0) {
            precio.classList.add('is-invalid');
            precioError.textContent =
                'El precio no puede ser negativo.';
            valido = false;
        }

        if (stock.value === '') {
            stock.classList.add('is-invalid');
            stockError.textContent =
                'Debe ingresar el stock.';
            valido = false;
        } else if (parseInt(stock.value) < 0) {
            stock.classList.add('is-invalid');
            stockError.textContent =
                'El stock no puede ser negativo.';
            valido = false;
        }

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