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

    <script>window.usuariosDatatableRoute = "{{ route('admin.usuarios.datatable') }}";</script>
    @stack('scripts')
</x-app-layout>