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
                    Agregar Producto
                </a>

            </div>

            <div class="card-body p-4">
                
                <div class="d-flex flex-wrap align-items-center gap-3 mb-3">
                    <button class="btn btn-success btn-sm shadow-sm fw-bold" id="btnGestionCategorias">
                        <i class="bi bi-gear me-1"></i>Gestión de categorías
                    </button>
                    <select id="filtro_categoria" class="form-select form-select-sm" style="max-width: 250px;">
                        <option value="">Filtrar por categoria</option>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <table id="tablaProductos" class="table table-striped table-hover align-middle text-nowrap" style="width: 100%;">
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

    <script>window.productosDatatableRoute = "{{ route('admin.productos.datatable') }}";</script>
    <script>window.appUrl = "{{ url('/') }}";</script>

    <div class="modal fade" id="modalGestionCategorias" tabindex="-1" data-bs-focus="false" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header bg-success text-white rounded-top-4">
                    <h5 class="modal-title fw-bold">
                        <i class="bi bi-folder-gear me-2"></i>Gestión de Categorías
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="input-group mb-4">
                        <input type="text" id="inputNuevaCategoria" class="form-control" placeholder="Nueva categoría...">
                        <button class="btn btn-success fw-bold" id="btnAgregarCategoria">
                            <i class="bi bi-plus-lg me-1"></i>Agregar
                        </button>
                    </div>
                    <div id="errorNuevaCategoria" class="text-danger small mb-3"></div>

                    <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                        <table class="table table-striped table-hover align-middle mb-0">
                            <thead class="table-success position-sticky top-0">
                                <tr>
                                    <th style="width: 70%;">Nombre</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tablaCategorias">
                                </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary fw-bold" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditarCategoria" tabindex="-1" data-bs-focus="false" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header bg-success text-white rounded-top-4">
                    <h5 class="modal-title fw-bold">
                        <i class="bi bi-pencil me-2"></i>Editar Categoría
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editCategoriaId">
                    <div class="mb-3">
                        <label for="editCategoriaNombre" class="form-label fw-bold">Nombre</label>
                        <input type="text" id="editCategoriaNombre" class="form-control">
                        <div id="errorEditarCategoria" class="text-danger small mt-1"></div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary fw-bold" id="btnCancelarEditarCategoria">Cancelar</button>
                    <button type="button" class="btn btn-success fw-bold" id="btnConfirmarEditar">Guardar cambios</button>
                </div>
            </div>
        </div>
    </div>

    @stack('scripts')

<script>
document.addEventListener('DOMContentLoaded', function() {

    const SwalDefault = Swal.mixin({
        customClass: { container: 'swal-on-modal' },
        didOpen: () => { document.activeElement?.blur(); }
    });

    var modalGestion = new bootstrap.Modal(document.getElementById('modalGestionCategorias'));
    var modalEditar  = new bootstrap.Modal(document.getElementById('modalEditarCategoria'));

    function limpiarFoco() {
        if (document.activeElement) document.activeElement.blur();
    }

    // ── Abrir modal gestión ──────────────────────────────────────────────
    document.getElementById('btnGestionCategorias').addEventListener('click', function() {
        limpiarFoco();
        cargarCategorias();
        modalGestion.show();
    });

    // ── Cerrar modal gestión ─────────────────────────────────────────────
    document.getElementById('modalGestionCategorias').addEventListener('hide.bs.modal', function() {
        limpiarFoco();
    });

    // ── Cerrar modal editar ──────────────────────────────────────────────
    document.getElementById('modalEditarCategoria').addEventListener('hide.bs.modal', function() {
        limpiarFoco();
    });

    // ── Cancelar editar → volver a gestión ──────────────────────────────
    document.getElementById('btnCancelarEditarCategoria').addEventListener('click', function() {
        limpiarFoco();
        modalEditar.hide();
        document.getElementById('modalEditarCategoria').addEventListener('hidden.bs.modal', function volverGestion() {
            cargarCategorias();
            modalGestion.show();
            document.getElementById('modalEditarCategoria').removeEventListener('hidden.bs.modal', volverGestion);
        });
    });

    // ── Cargar categorías ────────────────────────────────────────────────
    function cargarCategorias() {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', window.appUrl + '/admin/productos/categorias', true);
        xhr.onload = function() {
            if (xhr.status !== 200) return;
            var data = JSON.parse(xhr.responseText);
            var tbody = document.getElementById('tablaCategorias');
            if (!data.length) {
                tbody.innerHTML = '<tr><td colspan="2" class="text-center text-muted">Sin categorías</td></tr>';
                return;
            }
            var html = '';
            for (var i = 0; i < data.length; i++) {
                var c = data[i];
                html += '<tr><td class="fw-medium">' + c.nombre + '</td>';
                html += '<td class="text-center">';
                html += '<button class="btn btn-sm btn-warning me-1" onclick="editarCategoria(event,' + c.id + ')"><i class="bi bi-pencil"></i></button>';
                html += '<button class="btn btn-sm btn-danger" onclick="eliminarCategoria(event,' + c.id + ')"><i class="bi bi-trash"></i></button>';
                html += '</td></tr>';
            }
            tbody.innerHTML = html;
        };
        xhr.send();
    }

    // ── Agregar categoría ────────────────────────────────────────────────
    document.getElementById('btnAgregarCategoria').addEventListener('click', function() {
        limpiarFoco();
        var input = document.getElementById('inputNuevaCategoria');
        var error = document.getElementById('errorNuevaCategoria');
        var nombre = input.value.trim();

        error.textContent = '';
        input.classList.remove('is-invalid');

        if (!nombre) {
            error.textContent = 'Ingrese el nombre de la categoría.';
            input.classList.add('is-invalid');
            return;
        }

        this.disabled = true;
        this.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
        var btn = this;

        var xhr = new XMLHttpRequest();
        xhr.open('POST', window.appUrl + '/admin/productos/guardar-categoria', true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
        xhr.onload = function() {
            btn.disabled = false;
            btn.innerHTML = '<i class="bi bi-plus-lg me-1"></i>Agregar';

            if (xhr.status === 200) {
                var data = JSON.parse(xhr.responseText);
                if (data.success) {
                    input.value = '';
                    modalGestion.hide();
                    document.getElementById('modalGestionCategorias').addEventListener('hidden.bs.modal', function onHidden() {
                        document.getElementById('modalGestionCategorias').removeEventListener('hidden.bs.modal', onHidden);
                        Swal.fire({
                            icon: 'success',
                            title: '¡Categoría creada!',
                            text: 'La categoría se ha agregado correctamente.',
                            confirmButtonColor: '#198754',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(function() { location.reload(); });
                    });
                } else {
                    error.textContent = data.message || 'Error al guardar.';
                }
            } else if (xhr.status === 422) {
                var data = JSON.parse(xhr.responseText);
                var errors = data.errors;
                if (errors && errors.nombre) {
                    error.textContent = errors.nombre[0];
                    input.classList.add('is-invalid');
                } else {
                    error.textContent = 'Error de validación.';
                }
            } else {
                error.textContent = 'Error del servidor.';
            }
        };
        xhr.send(JSON.stringify({ nombre: nombre }));
    });

    document.getElementById('inputNuevaCategoria').addEventListener('input', function() {
        this.classList.remove('is-invalid');
        document.getElementById('errorNuevaCategoria').textContent = '';
    });

    // ── Editar categoría ─────────────────────────────────────────────────
    window.editarCategoria = function(event, id) {
        limpiarFoco();
        var row = event.target.closest('tr');
        var nombre = row.cells[0].textContent.trim();

        document.getElementById('editCategoriaId').value = id;
        document.getElementById('editCategoriaNombre').value = nombre;
        document.getElementById('errorEditarCategoria').textContent = '';
        document.getElementById('editCategoriaNombre').classList.remove('is-invalid');

        modalGestion.hide();
        document.getElementById('modalGestionCategorias').addEventListener('hidden.bs.modal', function abrirEditar() {
            modalEditar.show();
            // CORREGIDO: setTimeout extendido para evitar conflictos de renderizado con lectores de pantalla
            setTimeout(() => { document.getElementById('editCategoriaNombre').focus(); }, 200);
            document.getElementById('modalGestionCategorias').removeEventListener('hidden.bs.modal', abrirEditar);
        });
    };

    // ── Guardar edición ──────────────────────────────────────────────────
    document.getElementById('btnConfirmarEditar').addEventListener('click', function() {
        limpiarFoco();
        var id     = document.getElementById('editCategoriaId').value;
        var nombre = document.getElementById('editCategoriaNombre').value.trim();
        var error  = document.getElementById('errorEditarCategoria');

        error.textContent = '';
        document.getElementById('editCategoriaNombre').classList.remove('is-invalid');

        if (!nombre) {
            error.textContent = 'El nombre no puede estar vacío.';
            document.getElementById('editCategoriaNombre').classList.add('is-invalid');
            return;
        }

        this.disabled = true;
        this.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
        var btn = this;

        var xhr = new XMLHttpRequest();
        xhr.open('PUT', window.appUrl + '/admin/productos/categorias/' + id, true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
        xhr.onload = function() {
            btn.disabled = false;
            btn.innerHTML = 'Guardar cambios';
            if (xhr.status === 200) {
                var data = JSON.parse(xhr.responseText);
                if (data.success) {
                    limpiarFoco();
                    modalEditar.hide();
                    SwalDefault.fire({
                        icon: 'success',
                        title: '¡Categoría actualizada!',
                        text: 'Los cambios se han guardado correctamente.',
                        confirmButtonColor: '#198754',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(function() { location.reload(); });
                } else {
                    error.textContent = data.message || 'Error al actualizar.';
                }
            }
        };
        xhr.send(JSON.stringify({ nombre: nombre }));
    });

    document.getElementById('editCategoriaNombre').addEventListener('input', function() {
        this.classList.remove('is-invalid');
        document.getElementById('errorEditarCategoria').textContent = '';
    });

    // ── Eliminar categoría ───────────────────────────────────────────────
    window.eliminarCategoria = function(event, id) {
        limpiarFoco();
        modalGestion.hide();
        
        document.getElementById('modalGestionCategorias').addEventListener('hidden.bs.modal', function onHidden() {
            document.getElementById('modalGestionCategorias').removeEventListener('hidden.bs.modal', onHidden);
            
            setTimeout(function() { 
                Swal.fire({
                    title: '¿Eliminar categoría?',
                    text: 'Los productos asociados serán movidos a "Sin categoría".',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then(function(result) {
                    if (!result.isConfirmed) {
                        cargarCategorias();
                        modalGestion.show();
                        return;
                    }

                    var xhr = new XMLHttpRequest();
                    xhr.open('DELETE', window.appUrl + '/admin/productos/categorias/' + id, true);
                    xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
                    xhr.onload = function() {
                        if (xhr.status === 200) {
                            var data = JSON.parse(xhr.responseText);
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: '¡Categoría eliminada!',
                                    confirmButtonColor: '#198754',
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(function() { location.reload(); });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: data.message || 'No se pudo eliminar.',
                                    confirmButtonColor: '#dc3545'
                                }).then(function() {
                                    cargarCategorias();
                                    modalGestion.show();
                                });
                            }
                        }
                    };
                    xhr.send();
                });
            }, 250); // CORREGIDO: Tiempo extendido para permitir que Bootstrap remueva la capa oscura (backdrop) y limpie aria-hidden
        });
    };
});
</script>
</x-app-layout>