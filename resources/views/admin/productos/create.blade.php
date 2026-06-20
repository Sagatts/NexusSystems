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
                    Agregar Productos al Inventario
                </h4>
            </div>

            <div class="card-body">

                <h5 class="fw-bold text-secondary mb-3">
                    <i class="bi bi-file-earmark-excel me-2"></i>Opción 1: Carga Masiva (Excel / CSV)
                </h5>

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <strong>Error de formato:</strong> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @error('archivo_excel')
                    <div class="alert alert-warning alert-dismissible fade show shadow-sm" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <strong>El archivo fue rechazado:</strong> {{ $message }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @enderror

                <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 bg-light p-3 rounded border">
                    <div class="mb-2 mb-md-0">
                        <a href="{{ route('admin.productos.plantilla') }}" class="btn btn-info btn-sm text-white fw-bold shadow-sm">
                            <i class="bi bi-file-earmark-arrow-down me-1"></i> 1. Descargar Plantilla
                        </a>
                    </div>
                    
                    <div>
                        <form action="{{ route('admin.productos.importar') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center flex-wrap gap-2 m-0">
                            @csrf
                            <label class="fw-bold text-secondary mb-0" style="font-size: 0.9rem;">2. Archivo:</label>
                            
                            <input type="file" name="archivo_excel" id="archivo_excel" class="d-none" accept=".xlsx, .xls, .csv, .txt" required>
                            
                            <button type="button" class="btn btn-outline-secondary btn-sm fw-bold shadow-sm" onclick="document.getElementById('archivo_excel').click()">
                                <i class="bi bi-file-earmark-spreadsheet me-1"></i> Seleccionar archivo
                            </button>
                            
                            <span id="nombre_archivo_visual" class="text-muted small mx-2 text-break">Ningún archivo seleccionado</span>
                            
                            <button type="submit" class="btn btn-success btn-sm text-white fw-bold shadow-sm">
                                <i class="bi bi-cloud-arrow-up me-1"></i> Importar
                            </button>
                        </form>
                    </div>
                </div>

                <hr class="my-4 text-muted">

                <h5 class="fw-bold text-secondary mb-4">
                    <i class="bi bi-keyboard me-2"></i>Opción 2: Registro Manual
                </h5>

                <form id="productoForm" action="{{ route('admin.productos.store') }}" method="POST" novalidate>
                    @csrf
                    
                    <div class="row g-3">

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

    // ==========================================
    // LOGICA PARA EL NOMBRE DEL ARCHIVO DINÁMICO
    // ==========================================
    const inputOculto = document.getElementById('archivo_excel');
    const spanVisual = document.getElementById('nombre_archivo_visual');

    if (inputOculto && spanVisual) {
        inputOculto.addEventListener('change', function() {
            if (this.files && this.files.length > 0) {
                // Si seleccionó un archivo, muestra el nombre exacto con estilo destacado
                spanVisual.textContent = this.files[0].name;
                spanVisual.classList.remove('text-muted');
                spanVisual.classList.add('text-dark', 'fw-bold'); 
            } else {
                // Si canceló la selección, vuelve al estado inicial
                spanVisual.textContent = 'Ningún archivo seleccionado';
                spanVisual.classList.remove('text-dark', 'fw-bold');
                spanVisual.classList.add('text-muted');
            }
        });
    }

    // ==========================================
    // VALIDACIÓN DEL FORMULARIO MANUAL
    // ==========================================
    const form = document.getElementById('productoForm');

    const nombre = document.getElementById('nombre');
    const codigo = document.getElementById('codigo_barras');
    const categoria = document.getElementById('id_categoria');
    const precio = document.getElementById('precio_neto');
    const stock = document.getElementById('stock');
    const fecha = document.getElementById('fecha_vencimiento');

    const codigoError = document.getElementById('codigoError');
    const fechaError = document.getElementById('fechaError');

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
            if(codigoError) codigoError.textContent = 'Debe ingresar un código de barras.';
            valido = false;
        } else {
             if(codigoError) codigoError.textContent = '';
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
            if(fechaError) fechaError.textContent = 'Debe ingresar una fecha de vencimiento.';
            valido = false;
        } else {
            const hoy = new Date();
            hoy.setHours(0, 0, 0, 0);

            // Ajuste para evitar problemas de zona horaria con la fecha ingresada
            const partesFecha = fecha.value.split('-');
            const fechaIngresada = new Date(partesFecha[0], partesFecha[1] - 1, partesFecha[2]);

            if (fechaIngresada < hoy) {
                fecha.classList.add('is-invalid');
                if(fechaError) fechaError.textContent = 'La fecha de vencimiento no puede ser anterior a hoy.';
                valido = false;
            } else {
                 if(fechaError) fechaError.textContent = '';
            }
        }

        if (!valido) {
            e.preventDefault();
        }
    });
});
</script>

</x-app-layout>