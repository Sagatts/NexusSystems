<x-guest-layout>
    <div class="card shadow border-0 rounded-4">
        <div class="card-body p-4 p-md-5">
            
            <div class="text-center mb-4">
                <img src="{{ asset('img/logo-yiyo.png') }}" alt="Logo La Picá de Yiyo" class="img-fluid" style="max-height: 160px;">
            <h5 class="text-center mb-4 text-secondary">Acceso al Sistema</h5>

            <x-auth-session-status class="mb-4 text-success" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3 text-start">
                    <label for="email" class="form-label fw-bold">Usuario</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-2 text-start">
                    <label for="password" class="form-label fw-bold">Contraseña</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4 text-end">
                    @if (Route::has('password.request'))
                        <a class="link-olvido small" href="{{ route('password.request') }}">
                            ¿Olvidaste tu contraseña?
                        </a>
                    @endif
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn text-white fw-bold py-2 btn-corporativo">
                        Ingresar
                    </button>
                </div>
            </form>
            
        </div>
    </div>
</x-guest-layout>