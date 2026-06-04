<x-guest-layout>
    <div class="card shadow border-0 rounded-4">
        <div class="card-body p-4 p-md-5">

            <div class="text-center mb-4">
                <img src="{{ asset('img/logo-yiyo.png') }}"
                     alt="Logo La Picá de Yiyo"
                     class="img-fluid"
                     style="max-height: 160px;">
                <h5 class="text-center mb-4 text-secondary">
                    Acceso al Sistema
                </h5>
            </div>

            <x-auth-session-status
                class="mb-4 text-success"
                :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
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
                        required
                        autofocus
                    >

                    @error('rut')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Contraseña -->
                <div class="mb-2 text-start">
                    <label for="password" class="form-label fw-bold">
                        Contraseña
                    </label>

                    <input
                        id="password"
                        type="password"
                        class="form-control @error('password') is-invalid @enderror"
                        name="password"
                        required
                        autocomplete="current-password"
                    >

                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Recordarme -->
                <div class="form-check mb-3 text-start">
                    <input
                        class="form-check-input"
                        type="checkbox"
                        name="remember"
                        id="remember_me">

                    <label class="form-check-label" for="remember_me">
                        Recordarme
                    </label>
                </div>

                <!-- Recuperar contraseña -->
                <div class="mb-4 text-end">
                    @if (Route::has('password.request'))
                        <a class="link-olvido small"
                           href="{{ route('password.request') }}">
                            ¿Olvidaste tu contraseña?
                        </a>
                    @endif
                </div>

                <!-- Botón -->
                <div class="d-grid gap-2">
                    <button
                        type="submit"
                        class="btn text-white fw-bold py-2 btn-corporativo">
                        Ingresar
                    </button>
                </div>

            </form>

        </div>
    </div>
</x-guest-layout>