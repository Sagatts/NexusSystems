<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Gestión de Usuarios
        </h2>
    </x-slot>

    <div class="container-fluid mt-4">

        <div class="card shadow-sm border-0 rounded-4">
            
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                
                <h4 class="fw-bold mb-0">
                    Personal Registrado
                </h4>

                <a href="{{ route('admin.usuarios.create') }}" class="btn btn-success fw-bold">
                    <i class="bi bi-person-plus-fill me-1"></i>
                    Nuevo Usuario
                </a>
            </div>

            <div class="card-body">
                    
                    <table id="tablaUsuarios" class="table table-striped table-hover align-middle text-nowrap" style="width: 100%;">
                        <thead class="table-dark">
                            <tr>
                                <th>RUT</th>
                                <th>Nombre Completo</th>
                                <th>Rol</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

            </div>
            
        </div>
    </div>

    @push('scripts')

    <style>
        /* 1. Muro de contención: evita que el contenedor general rompa la tarjeta blanca */
        .dataTables_wrapper {
            max-width: 100%;
            overflow-x: hidden; 
        }

        /* 2. Permite que SOLO la tabla interna tenga su scroll lateral */
        .dataTables_scrollBody {
            overflow-x: auto !important;
            width: 100% !important;
        }

        /* 3. Estilos responsivos para que el buscador se ordene en celulares */
        @media (max-width: 768px) {
            .dataTables_filter {
                display: flex;
                flex-direction: column;
                align-items: flex-start;
                text-align: left !important;
                margin-top: 10px;
                margin-bottom: 10px;
            }
            .dataTables_filter label {
                display: flex;
                flex-direction: column;
                width: 100%;
            }
            .dataTables_filter input {
                margin-left: 0 !important;
                margin-top: 6px;
                width: 100% !important;
            }
        }
    </style>

    <script>
        $(document).ready(function () {
            $('#tablaUsuarios').DataTable({

                scrollX: true,
                processing: true,
                serverSide: true,
                // Ruta que devolverá el JSON con los usuarios
                ajax: "{{ route('admin.usuarios.datatable') }}",
                
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json',
                    search: "Buscar por nombre:"
                },

                columns: [
                    { 
                        data: 'rut', 
                        name: 'rut',
                        className: 'fw-semibold'
                    },
                    { 
                        data: 'nombre', 
                        name: 'nombre' 
                    },
                    { 
                        data: 'rol', 
                        name: 'rol' 
                    },
                    { 
                        data: 'acciones', 
                        name: 'acciones', 
                        orderable: false, 
                        searchable: false,
                        className: 'text-center'
                    }
                ]
            });

            // Manejar el evento de eliminación
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
                        
                        // Petición silenciosa al servidor
                        $.ajax({
                            url: "{{ url('admin/usuarios') }}/" + rut,
                            type: 'POST',
                            data: {
                                _method: 'DELETE',
                                _token: "{{ csrf_token() }}" // Llave de seguridad de Laravel
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

        });
    </script>
    @endpush
</x-app-layout>