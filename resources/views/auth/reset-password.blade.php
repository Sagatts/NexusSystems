<x-guest-layout>
    <div class="card shadow border-0 rounded-4 bg-amarillo-yiyo">
        <div class="card-body p-4 p-md-5">
            
            <!-- Logo principal -->
            <div class="text-center mb-4">
                <img src="{{ asset('img/logo-yiyo.png') }}" alt="Logo La Picá de Yiyo" class="img-fluid" style="max-height: 120px;">
            </div>

            <div class="mb-4 text-muted small text-start">
                Ingresa tu nueva contraseña para recuperar el acceso a tu cuenta.
            </div>

            <form method="POST" action="{{ route('password.store') }}">
                @csrf

                <!-- Token de recuperación (Oculto) -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Correo Electrónico -->
                <div class="mb-3 text-start">
                    <label for="email" class="form-label fw-bold">Correo Electrónico</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Nueva Contraseña -->
                <div class="mb-3 text-start">
                    <label for="password" class="form-label fw-bold">Nueva Contraseña</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirmar Contraseña -->
                <div class="mb-4 text-start">
                    <label for="password_confirmation" class="form-label fw-bold">Confirmar Contraseña</label>
                    <input id="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" required autocomplete="new-password">
                    @error('password_confirmation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Botón -->
                <div class="d-grid gap-2">
                    <button type="submit" class="btn text-white fw-bold py-2 btn-corporativo">
                        Restablecer Contraseña
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
