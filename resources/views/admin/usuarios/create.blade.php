<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Crear Nuevo Usuario
        </h2>
    </x-slot>

    <div class="container-fluid mt-4">

        <div class="card shadow-sm border-0 rounded-4">

            <div class="card-header bg-white">

                <h4 class="fw-bold mb-0">
                    Detalles del Nuevo Usuario
                </h4>

            </div>

            <div class="card-body">
                <form action="{{ route('admin.usuarios.store') }}" method="POST">
                    @csrf

                    <div class="row g-3">
                        <div class="col-md-12 mb-3">
                            <label for="nombre" class="form-label fw-bold">Nombre Completo</label>
                            <input type="text" name="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}" placeholder="Ej: Juan Pérez" required>
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="rut" class="form-label fw-bold">RUT</label>
                            <input type="text" name="rut" id="rut" class="form-control @error('rut') is-invalid @enderror" value="{{ old('rut') }}" placeholder="Ej: 12345678-9" required>
                            @error('rut')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label fw-bold">Correo Electrónico</label>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="correo@ejemplo.com" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="rol" class="form-label fw-bold">Rol Asignado</label>
                            <select name="rol" id="rol" class="form-select @error('rol') is-invalid @enderror" required>
                                <option value="" disabled {{ old('rol') ? '' : 'selected' }}>Seleccione un rol...</option>
                                <option value="administrador" {{ old('rol') == 'administrador' ? 'selected' : '' }}>Administrador</option>
                                <option value="garzon" {{ old('rol') == 'garzon' ? 'selected' : '' }}>Garzón</option>
                                <option value="cocina" {{ old('rol') == 'cocina' ? 'selected' : '' }}>Cocina</option>
                            </select>
                            @error('rol')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="contrasena" class="form-label fw-bold">Contraseña de Acceso</label>
                            <input type="password" name="contrasena" id="contrasena" class="form-control @error('contrasena') is-invalid @enderror" placeholder="Crea una contraseña segura" required>
                            @error('contrasena')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-4 d-flex justify-content-end gap-2 border-top pt-4">
                        <a href="{{ route('admin.usuarios.index') }}" class="btn btn-secondary fw-bold shadow-sm">
                            Cancelar
                        </a>
                        <button type="submit" class="btn btn-success fw-bold shadow-sm">
                            <i class="bi bi-save me-1"></i> Guardar Usuario
                        </button>
                    </div>
                    
                </form>
            </div>

        </div>

    </div>
</x-app-layout>