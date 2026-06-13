<x-guest-layout>
    <div class="card shadow border-0 rounded-4">
        <div class="card-body p-4 p-md-5">

            <div class="text-center mb-4">
                <img src="{{ asset('img/logo-yiyo.png') }}"
                     alt="Logo La Picá de Yiyo"
                     class="img-fluid"
                     style="max-height: 160px;">
                <h5 class="text-center mb-4 text-secondary">
                    Registro de Usuario
                </h5>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- RUT -->
                <div class="mb-3 text-start">
                    <label for="rut" class="form-label fw-bold">
                        RUT
                    </label>

                    <input
                        id="rut"
                        type="text"
                        class="form-control @error('rut') is-invalid @enderror"
                        name="rut"
                        value="{{ old('rut') }}"
                        placeholder="12345678-9"
                        required
                        autofocus
                    >

                    @error('rut')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Nombre -->
                <div class="mb-3 text-start">
                    <label for="nombre" class="form-label fw-bold">
                        Nombre
                    </label>

                    <input
                        id="nombre"
                        type="text"
                        class="form-control @error('nombre') is-invalid @enderror"
                        name="nombre"
                        value="{{ old('nombre') }}"
                        required
                    >

                    @error('nombre')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-3 text-start">
                    <label for="email" class="form-label fw-bold">
                        Email
                    </label>

                    <input
                        id="email"
                        type="email"
                        class="form-control @error('email') is-invalid @enderror"
                        name="email"
                        value="{{ old('email') }}"
                        required
                    >

                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Contraseña -->
                <div class="mb-3 text-start">
                    <label for="password" class="form-label fw-bold">
                        Contraseña
                    </label>

                    <input
                        id="password"
                        type="password"
                        class="form-control @error('password') is-invalid @enderror"
                        name="password"
                        required
                        autocomplete="new-password"
                    >

                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Confirmar Contraseña -->
                <div class="mb-3 text-start">
                    <label for="password_confirmation" class="form-label fw-bold">
                        Confirmar Contraseña
                    </label>

                    <input
                        id="password_confirmation"
                        type="password"
                        class="form-control"
                        name="password_confirmation"
                        required
                        autocomplete="new-password"
                    >
                </div>

                <!-- Rol -->
                <div class="mb-3 text-start">
                    <label for="rol" class="form-label fw-bold">
                        Rol
                    </label>

                    <select
                        id="rol"
                        class="form-select @error('rol') is-invalid @enderror"
                        name="rol"
                        required
                    >
                        <option value="">Seleccionar rol...</option>
                        <option value="administrador" {{ old('rol') == 'administrador' ? 'selected' : '' }}>Administrador</option>
                        <option value="garzon" {{ old('rol') == 'garzon' ? 'selected' : '' }}>Mesero</option>
                        <option value="cocina" {{ old('rol') == 'cocina' ? 'selected' : '' }}>Cocina</option>
                    </select>

                    @error('rol')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Botón -->
                <div class="d-grid gap-2 mt-4">
                    <button
                        type="submit"
                        class="btn text-white fw-bold py-2 btn-corporativo">
                        Registrarse
                    </button>
                </div>

                <!-- Link a Login -->
                <div class="text-center mt-3">
                    <span class="small">¿Ya tienes cuenta? 
                        <a href="{{ route('login') }}" class="link-olvido">
                            Inicia sesión aquí
                        </a>
                    </span>
                </div>

            </form>

        </div>
    </div>
</x-guest-layout>
