/**
 * DataTable para Usuarios con eliminación AJAX
 * Usado en: admin/usuarios/index
 */

function initUsuariosDatatable() {
    if (typeof window.jQuery === 'undefined') {
        setTimeout(initUsuariosDatatable, 50);
        return;
    }

    if (!window.jQuery('#tablaUsuarios').length) return;

    const $ = window.jQuery;

    $('#tablaUsuarios').DataTable({
        scrollX: true,
        processing: true,
        serverSide: true,
        ajax: window.usuariosDatatableRoute || "/admin/usuarios/datatable",
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json',
            search: "Buscar por nombre:"
        },
        columns: [
            { data: 'rut', name: 'rut', className: 'fw-semibold' },
            { data: 'nombre', name: 'nombre' },
            { data: 'rol', name: 'rol' },
            { data: 'acciones', name: 'acciones', orderable: false, searchable: false, className: 'text-center' }
        ]
    });

    window.abrirModalEliminar = function(rut) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Esta acción eliminará al usuario con RUT " + rut + " del sistema.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "/admin/usuarios/" + rut,
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
                                text: 'El usuario ha sido removido.',
                                timer: 2000,
                                showConfirmButton: false
                            });
                            $('#tablaUsuarios').DataTable().ajax.reload();
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Hubo un error al intentar eliminar al usuario.'
                        });
                    }
                });
            }
        });
    }
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initUsuariosDatatable);
} else {
    initUsuariosDatatable();
}