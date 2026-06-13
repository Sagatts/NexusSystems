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
        });
    </script>
    @endpush
</x-app-layout>