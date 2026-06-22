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
            url: window.productosDatatableRoute || "/admin/productos-datatable",
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
            $('#filtro_categoria').removeClass('d-none');
            $('.dataTables_filter label').before($('#filtro_categoria'));
        }
    });

    $('#filtro_categoria').change(function () {
        tabla.ajax.reload();
    });

    window.abrirModalEliminar = function(id) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Esta acción eliminará el producto del inventario de forma permanente.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "/admin/productos/" + id,
                    type: 'POST',
                    data: {
                        _method: 'DELETE',
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: '¡Eliminado!',
                                text: 'El producto ha sido removido.',
                                timer: 2000,
                                showConfirmButton: false
                            });
                            tabla.ajax.reload();
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Hubo un error al intentar eliminar el producto.'
                        });
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