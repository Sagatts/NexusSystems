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
                                <i class="bi bi-cloud-arrow-up me-1"></i> Cargar Datos
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
                            <div class="input-group">
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
                                <button class="btn btn-outline-secondary" type="button" id="btnNuevaCategoria" title="Crear nueva categoría">
                                    <i class="bi bi-plus-lg"></i>
                                </button>
                            </div>

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

    <!-- Modal para crear nueva categoría -->
    <div class="modal fade" id="modalNuevaCategoria" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title fw-bold">
                        <i class="bi bi-folder-plus me-2"></i>Nueva Categoría
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nombre_categoria" class="form-label fw-bold">Nombre de la Categoría</label>
                        <input type="text" id="nombre_categoria" class="form-control" placeholder="Ej: Bebidas, Snack, Congelados...">
                        <div id="nombreCategoriaError" class="text-danger small mt-1"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary fw-bold" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-success fw-bold" id="btnGuardarCategoria">
                        <i class="bi bi-save me-1"></i>Guardar
                    </button>
                </div>
            </div>
        </div>
    </div>

@stack('scripts')

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const modalElement = document.getElementById('modalNuevaCategoria');
    const modal = new bootstrap.Modal(modalElement);
    
    // Abrir modal al hacer click en el botón +
    document.getElementById('btnNuevaCategoria').addEventListener('click', function() {
        document.getElementById('nombre_categoria').value = '';
        document.getElementById('nombreCategoriaError').textContent = '';
        document.getElementById('nombre_categoria').classList.remove('is-invalid');
        modal.show();
    });

    // Guardar categoría
    document.getElementById('btnGuardarCategoria').addEventListener('click', function() {
        const nombre = document.getElementById('nombre_categoria').value.trim();
        const errorDiv = document.getElementById('nombreCategoriaError');
        const input = document.getElementById('nombre_categoria');

        errorDiv.textContent = '';
        input.classList.remove('is-invalid');

        if (!nombre) {
            errorDiv.textContent = 'Debes ingresar el nombre de la categoría.';
            input.classList.add('is-invalid');
            return;
        }

        const btn = this;
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Guardando...';

        fetch('{{ route("admin.productos.guardarCategoria") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ nombre: nombre })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Agregar la nueva categoría al select
                const select = document.getElementById('id_categoria');
                const option = document.createElement('option');
                option.value = data.categoria.id;
                option.textContent = data.categoria.nombre;
                option.selected = true;
                select.appendChild(option);

                modal.hide();
                btn.disabled = false;
                btn.innerHTML = '<i class="bi bi-save me-1"></i>Guardar';
            } else {
                errorDiv.textContent = data.message || 'Error al guardar.';
                input.classList.add('is-invalid');
                btn.disabled = false;
                btn.innerHTML = '<i class="bi bi-save me-1"></i>Guardar';
            }
        })
        .catch(error => {
            errorDiv.textContent = 'Error de conexión.';
            input.classList.add('is-invalid');
            btn.disabled = false;
            btn.innerHTML = '<i class="bi bi-save me-1"></i>Guardar';
        });
    });

    // Limpiar error al escribir
    document.getElementById('nombre_categoria').addEventListener('input', function() {
        this.classList.remove('is-invalid');
        document.getElementById('nombreCategoriaError').textContent = '';
    });
});
</script>
@endpush

</x-app-layout>