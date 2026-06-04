<x-guest-layout>
    <div class="card shadow border-0 rounded-4">
        <div class="card-body p-4 p-md-5">
            
            <div class="text-center mb-4">
                <img src="{{ asset('img/logo-yiyo.png') }}" alt="Logo La Picá de Yiyo" class="img-fluid" style="max-height: 160px;">
            </div>

            <div class="mb-4 text-muted small text-start">
                <b>¿Olvidaste tu contraseña?</b> No hay problema. Ingresa tu <strong><u>correo electrónico</u></strong> y te enviaremos un enlace para que puedas elegir una nueva.
            </div>

            <x-auth-session-status class="mb-4 alert alert-success text-sm p-2 text-center" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="mb-4 text-start">
                    <label for="email" class="form-label fw-bold">Correo Electrónico</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <a class="link-olvido small" href="{{ route('login') }}">
                        Volver al Inicio de Sesión
                    </a>
                    
                    <button type="submit" class="btn text-white fw-bold px-4 btn-corporativo">
                        Enviar Enlace
                    </button>
                </div>
            </form>
            
        </div>
    </div>
</x-guest-layout>
