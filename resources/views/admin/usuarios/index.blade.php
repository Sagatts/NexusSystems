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
    
                <!-- NUEVO: Envolvemos la tabla en este div -->
                <div class="table-responsive">
                    
                    <table id="tablaUsuarios" class="table table-striped table-hover align-middle w-100">
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
                    
                </div> <!-- Cierre del div table-responsive -->

            </div>
            
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function () {
            $('#tablaUsuarios').DataTable({
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