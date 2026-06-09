<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Usuario: {{ $usuario->nombre }}
        </h2>
    </x-slot>

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-sm border-0 rounded-4">
                    
                    <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                        <h4 class="fw-bold mb-0 text-dark">Actualizar Datos</h4>
                        <p class="text-muted small">Modifica la información del usuario en el sistema.</p>
                    </div>

                    <div class="card-body p-4">
                        <form action="{{ route('admin.usuarios.update', $usuario->rut) }}" method="POST">
                            @csrf
                            @method('PUT') <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="rut" class="form-label fw-semibold">RUT</label>
                                    <input type="text" name="rut" id="rut" class="form-control bg-light" value="{{ $usuario->rut }}" readonly>
                                    <small class="text-muted" style="font-size: 0.75rem;">El RUT no se puede modificar.</small>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="nombre" class="form-label fw-semibold">Nombre Completo</label>
                                    <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $usuario->nombre }}" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label fw-semibold">Correo Electrónico</label>
                                    <input type="email" name="email" id="email" class="form-control" value="{{ $usuario->email }}" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="rol" class="form-label fw-semibold">Rol Asignado</label>
                                    <select name="rol" id="rol" class="form-select" required>
                                        <option value="administrador" {{ $usuario->rol == 'administrador' ? 'selected' : '' }}>Administrador</option>
                                        <option value="garzon" {{ $usuario->rol == 'garzon' ? 'selected' : '' }}>Garzón</option>
                                        <option value="cocina" {{ $usuario->rol == 'cocina' ? 'selected' : '' }}>Cocina</option>
                                    </select>
                                </div>

                                <div class="col-12 mb-4">
                                    <label for="contrasena" class="form-label fw-semibold text-primary">Nueva Contraseña (Opcional)</label>
                                    <input type="password" name="contrasena" id="contrasena" class="form-control border-primary" placeholder="Dejar en blanco para mantener la actual">
                                    <small class="text-muted">Solo escribe aquí si necesitas resetear el acceso del usuario.</small>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-2 border-top pt-4">
                                <a href="{{ route('admin.usuarios.index') }}" class="btn btn-secondary fw-bold">
                                    Cancelar
                                </a>
                                <button type="submit" class="btn btn-success fw-bold">
                                    <i class="bi bi-arrow-clockwise me-1"></i> Actualizar Usuario
                                </button>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>