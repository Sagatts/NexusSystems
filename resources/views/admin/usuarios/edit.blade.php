<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Usuario: {{ $usuario->nombre }}
        </h2>
    </x-slot>

    <div class="container-fluid mt-4">

        <div class="card shadow-sm border-0 rounded-4">

            <div class="card-header bg-white">
                <h4 class="fw-bold mb-0">
                    Actualizar Datos del Usuario
                </h4>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.usuarios.update', $usuario->rut) }}" method="POST" novalidate>
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <div class="col-md-12 mb-3">
                            <label for="nombre" class="form-label fw-bold">Nombre Completo</label>
                            <input type="text" name="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre', $usuario->nombre) }}" required>
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="rut" class="form-label fw-bold">RUT</label>
                            <input type="text" name="rut" id="rut" class="form-control bg-light @error('rut') is-invalid @enderror" value="{{ old('rut', $usuario->rut) }}" readonly>
                            <small class="text-muted">El RUT no se puede modificar.</small>
                            @error('rut')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label fw-bold">Correo Electrónico</label>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $usuario->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="rol" class="form-label fw-bold">Rol Asignado</label>
                            <select name="rol" id="rol" class="form-select @error('rol') is-invalid @enderror" required>
                                <option value="administrador" {{ old('rol', $usuario->rol) == 'administrador' ? 'selected' : '' }}>Administrador</option>
                                <option value="garzon" {{ old('rol', $usuario->rol) == 'garzon' ? 'selected' : '' }}>Garzón</option>
                                <option value="cocina" {{ old('rol', $usuario->rol) == 'cocina' ? 'selected' : '' }}>Cocina</option>
                            </select>
                            @error('rol')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="contrasena" class="form-label fw-bold text-primary">Nueva Contraseña (Opcional)</label>
                            <input type="password" name="contrasena" id="contrasena" class="form-control border-primary @error('contrasena') is-invalid @enderror" placeholder="Dejar en blanco para mantener la actual">
                            <small class="text-muted">Solo escribe aquí si necesitas resetear el acceso.</small>

                            <div id="password-strength-container" class="mt-2 mb-3">
                                <div class="progress" style="height: 6px;">
                                    <div id="password-strength-bar" class="progress-bar" style="width: 0%; transition: width 0.3s ease;"></div>
                                </div>
                                <small id="password-strength-text" class="d-block mt-1" style="color: #999;"></small>
                            </div>

                            @error('contrasena')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="contrasena_confirmation" class="form-label fw-bold text-primary">Confirmar Nueva Contraseña</label>
                            <input type="password" name="contrasena_confirmation" id="contrasena_confirmation" class="form-control border-primary @error('contrasena_confirmation') is-invalid @enderror" placeholder="Repite la nueva contraseña">
                            
                            <div id="password-match-text" class="mt-2" style="font-size: 0.875em; display: none;"></div>
                        </div>

                        <div class="col-md-12 mb-3">
                            <div id="password-requirements" class="row g-2">
                                <div class="col-auto"><div class="d-flex align-items-center gap-2"><i id="req-length" class="bi bi-circle" style="color: #999; font-size: 16px;"></i><small>Mín. 8 caracteres</small></div></div>
                                <div class="col-auto"><div class="d-flex align-items-center gap-2"><i id="req-lowercase" class="bi bi-circle" style="color: #999; font-size: 16px;"></i><small>Minúscula</small></div></div>
                                <div class="col-auto"><div class="d-flex align-items-center gap-2"><i id="req-uppercase" class="bi bi-circle" style="color: #999; font-size: 16px;"></i><small>Mayúscula</small></div></div>
                                <div class="col-auto"><div class="d-flex align-items-center gap-2"><i id="req-number" class="bi bi-circle" style="color: #999; font-size: 16px;"></i><small>Número</small></div></div>
                                <div class="col-auto"><div class="d-flex align-items-center gap-2"><i id="req-special" class="bi bi-circle" style="color: #999; font-size: 16px;"></i><small>Carácter especial</small></div></div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 d-flex justify-content-end gap-2 border-top pt-4">
                        <a href="{{ route('admin.usuarios.index') }}" class="btn btn-secondary fw-bold shadow-sm">
                            Cancelar
                        </a>
                        <button type="submit" class="btn btn-success fw-bold shadow-sm">
                            <i class="bi bi-arrow-clockwise me-1"></i> Actualizar Usuario
                        </button>
                    </div>

                </form>
            </div>

        </div>

    </div>

    @stack('scripts')
</x-app-layout>