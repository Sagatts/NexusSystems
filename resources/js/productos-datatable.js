/**
 * DataTable para Productos con filtro y eliminación
 * Usado en: admin/productos/index
 */

function initProductosDatatable() {
    if (typeof window.jQuery === 'undefined') {
        setTimeout(initProductosDatatable, 50);
        return;
    }

    if (!window.jQuery('#tablaProductos').length) return;

    const $ = window.jQuery;

    let tabla = $('#tablaProductos').DataTable({
        scrollX: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: window.productosDatatableRoute || "admin.productos-datatable",
            data: function (d) {
                d.categoria = $('#filtro_categoria').val();
            }
        },
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json',
            search: "Buscar por nombre:"
        },
        columns: [
            { data: 'codigo_barras', name: 'codigo_barras' },
            { data: 'nombre', name: 'nombre' },
            { data: 'precio_neto', name: 'precio_neto' },
            { data: 'stock', name: 'stock' },
            { data: 'fecha_vencimiento', name: 'fecha_vencimiento' },
            { data: 'categoria', name: 'categoria' },
            { data: 'acciones', name: 'acciones', orderable: false, searchable: false }
        ],
        initComplete: function() {
            // No mover el filtro, ya está en su lugar
        }
    });

    $('#filtro_categoria').change(function () {
        tabla.ajax.reload();
    });

    window.abrirModalEliminar = function(id) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Esta acción no se puede deshacer",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: window.appUrl + `/admin/productos/${id}`,  // ← usa appUrl
                    type: 'POST',
                    data: {
                        _method: 'DELETE',           // ← esto es el "method spoofing" de Laravel
                        _token: $('meta[name="csrf-token"]').attr('content')  // ← CSRF obligatorio
                    },
                    success: function(response) {
                        Swal.fire('Eliminado', 'Producto eliminado correctamente', 'success')
                        .then(function() {
                            location.reload(); // ← agrega esto
                        });
                    },
                    error: function(xhr) {
                        Swal.fire('Error', 'No se pudo eliminar el producto', 'error');
                    }
                });
            }
        });
    }
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initProductosDatatable);
} else {
    initProductosDatatable();
}