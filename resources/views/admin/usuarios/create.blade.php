<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Crear Nuevo Usuario
        </h2>
    </x-slot>

    <div class="container-fluid mt-4">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-header bg-white">
                <h4 class="fw-bold mb-0">Detalles del Nuevo Usuario</h4>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.usuarios.store') }}" method="POST">
                    @csrf

                    <div class="row g-3">
                        <div class="col-md-12 mb-3">
                            <label for="nombre" class="form-label fw-bold">Nombre Completo</label>
                            <input type="text" name="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}" placeholder="Ej: Juan Pérez" required>
                            @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="rut" class="form-label fw-bold">RUT</label>
                            <input type="text" name="rut" id="rut" class="form-control @error('rut') is-invalid @enderror" value="{{ old('rut') }}" placeholder="Ej: 12345678-9" required>
                            @error('rut') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label fw-bold">Correo Electrónico</label>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="correo@ejemplo.com" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="rol" class="form-label fw-bold">Rol Asignado</label>
                            <select name="rol" id="rol" class="form-select @error('rol') is-invalid @enderror">
                                <option value="" disabled {{ old('rol') ? '' : 'selected' }}>Seleccione un rol...</option>
                                <option value="administrador" {{ old('rol') == 'administrador' ? 'selected' : '' }}>Administrador</option>
                                <option value="garzon" {{ old('rol') == 'garzon' ? 'selected' : '' }}>Garzón</option>
                                <option value="cocina" {{ old('rol') == 'cocina' ? 'selected' : '' }}>Cocina</option>
                            </select>
                            @error('rol') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <!-- Contraseña Principal -->
                        <div class="col-md-6 mb-3">
                            <label for="contrasena" class="form-label fw-bold">Contraseña de Acceso</label>
                            <input type="password" name="contrasena" id="contrasena" class="form-control @error('contrasena') is-invalid @enderror" placeholder="Crea una contraseña segura" required>

                            <!-- Barra de fortaleza -->
                            <div id="password-strength-container" class="mt-2 mb-3">
                                <div class="progress" style="height: 6px;">
                                    <div id="password-strength-bar" class="progress-bar" style="width: 0%; transition: width 0.3s ease;"></div>
                                </div>
                                <small id="password-strength-text" class="d-block mt-1" style="color: #999;"></small>
                            </div>

                            <!-- Requisitos de contraseña -->
                            <div id="password-requirements" class="row g-2 mb-3">
                                <div class="col-12 col-sm-6"><div class="d-flex align-items-center gap-2"><i id="req-length" class="bi bi-circle" style="color: #999; font-size: 18px;"></i><small>Mín. 8 caracteres</small></div></div>
                                <div class="col-12 col-sm-6"><div class="d-flex align-items-center gap-2"><i id="req-lowercase" class="bi bi-circle" style="color: #999; font-size: 18px;"></i><small>Minúscula</small></div></div>
                                <div class="col-12 col-sm-6"><div class="d-flex align-items-center gap-2"><i id="req-uppercase" class="bi bi-circle" style="color: #999; font-size: 18px;"></i><small>Mayúscula</small></div></div>
                                <div class="col-12 col-sm-6"><div class="d-flex align-items-center gap-2"><i id="req-number" class="bi bi-circle" style="color: #999; font-size: 18px;"></i><small>Número</small></div></div>
                                <div class="col-12 col-sm-6"><div class="d-flex align-items-center gap-2"><i id="req-special" class="bi bi-circle" style="color: #999; font-size: 18px;"></i><small>Carácter especial</small></div></div>
                            </div>

                            @error('contrasena') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>

                        <!-- Confirmación de Contraseña -->
                        <div class="col-md-6 mb-3">
                            <label for="contrasena_confirmation" class="form-label fw-bold">Confirmar Contraseña</label>
                            <input type="password" name="contrasena_confirmation" id="contrasena_confirmation" class="form-control @error('contrasena_confirmation') is-invalid @enderror" placeholder="Repite la contraseña" required>
                            
                            <!-- Mensaje visual de coincidencia -->
                            <div id="password-match-text" class="mt-2" style="font-size: 0.875em; display: none;"></div>
                        </div>
                    </div>

                    <div class="mt-4 d-flex justify-content-end gap-2 border-top pt-4">
                        <a href="{{ route('admin.usuarios.index') }}" class="btn btn-secondary fw-bold shadow-sm">Cancelar</a>
                        <button type="submit" class="btn btn-success fw-bold shadow-sm">
                            <i class="bi bi-save me-1"></i> Guardar Usuario
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @stack('scripts')
</x-app-layout>