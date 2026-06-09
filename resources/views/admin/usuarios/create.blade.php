<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Crear Nuevo Usuario
        </h2>
    </x-slot>

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-sm border-0 rounded-4">
                    
                    <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                        <h4 class="fw-bold mb-0 text-dark">Formulario de Registro</h4>
                        <p class="text-muted small">Ingresa los datos del nuevo integrante del equipo.</p>
                    </div>

                    <div class="card-body p-4">
                        <form action="{{ route('admin.usuarios.store') }}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="rut" class="form-label fw-semibold">RUT</label>
                                    <input type="text" name="rut" id="rut" class="form-control" placeholder="Ej: 12345678-9" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="nombre" class="form-label fw-semibold">Nombre Completo</label>
                                    <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ej: Juan Pérez" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label fw-semibold">Correo Electrónico</label>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="correo@ejemplo.com" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="rol" class="form-label fw-semibold">Rol Asignado</label>
                                    <select name="rol" id="rol" class="form-select" required>
                                        <option value="" selected disabled>Seleccione un rol...</option>
                                        <option value="administrador">Administrador</option>
                                        <option value="garzon">Garzón</option>
                                        <option value="cocina">Cocina</option>
                                    </select>
                                </div>

                                <div class="col-12 mb-4">
                                    <label for="contrasena" class="form-label fw-semibold">Contraseña de Acceso</label>
                                    <input type="password" name="contrasena" id="contrasena" class="form-control" placeholder="Crea una contraseña segura" required>
                                    <small class="text-muted">El usuario podrá cambiarla después desde su perfil.</small>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-2 border-top pt-4">
                                <a href="{{ route('admin.usuarios.index') }}" class="btn btn-secondary fw-bold">
                                    Cancelar
                                </a>
                                <button type="submit" class="btn btn-success fw-bold">
                                    <i class="bi bi-save me-1"></i> Guardar Usuario
                                </button>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>