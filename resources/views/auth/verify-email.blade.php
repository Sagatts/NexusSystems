<x-guest-layout>
    <!-- Tarjeta con el fondo amarillo clarito -->
    <div class="card shadow border-0 rounded-4 bg-amarillo-yiyo">
        <div class="card-body p-4 p-md-5">
            
            <!-- Logo principal de la empresa -->
            <div class="text-center mb-4">
                <img src="{{ asset('img/logo-yiyo.png') }}"
                     alt="Logo La Picá de Yiyo"
                     class="img-fluid mx-auto d-block logo-login">
            </div>

            <!-- Mensaje principal alineado a la izquierda -->
            <div class="mb-4 text-muted small text-start">
                {{ __('¡Gracias por registrarte! Antes de comenzar, ¿podrías verificar tu dirección de correo electrónico haciendo clic en el enlace que te acabamos de enviar? Si no recibiste el correo, con gusto te enviaremos otro.') }}
            </div>

            <!-- Alerta de éxito cuando se reenvía el correo -->
            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 alert alert-success text-sm p-2 text-center">
                    {{ __('Se ha enviado un nuevo enlace de verificación a la dirección de correo electrónico que proporcionaste durante el registro.') }}
                </div>
            @endif

            <!-- Botones de Acción -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                
                <!-- Botón de Reenviar (Rojo Corporativo) -->
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="btn text-white fw-bold px-3 btn-rojo-yiyo small">
                        {{ __('Reenviar Correo') }}
                    </button>
                </form>

                <!-- Botón de Cerrar Sesión (Estilo link gris) -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-link link-olvido small p-0 text-decoration-none">
                        {{ __('Cerrar Sesión') }}
                    </button>
                </form>
            </div>
            
        </div>
    </div>
</x-guest-layout>