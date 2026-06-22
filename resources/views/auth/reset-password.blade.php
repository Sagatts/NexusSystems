<x-guest-layout>
    <div class="card shadow border-0 rounded-4 bg-amarillo-yiyo">
        <div class="card-body p-4 p-md-5">
            
            <!-- Logo principal -->
            <div class="text-center mb-4">
                <img src="{{ asset('img/logo-yiyo.png') }}"
                     alt="Logo La Picá de Yiyo"
                     class="img-fluid mx-auto d-block logo-login">
            </div>

            <div class="mb-4 text-muted small text-start">
                Ingresa tu nueva contraseña para recuperar el acceso a tu cuenta.
            </div>

            <form  id="resetPasswordForm" method="POST" action="{{ route('password.store') }}">
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

                    <!-- Barra de fortaleza -->
                    <div id="password-strength-container" class="mt-2 mb-3">
                        <div class="progress" style="height: 6px;">
                            <div id="password-strength-bar" class="progress-bar" style="width: 0%; transition: width 0.3s ease;"></div>
                        </div>
                        <small id="password-strength-text" class="d-block mt-1" style="color: #999;"></small>
                    </div>

                    <!-- Requisitos de contraseña -->
                    <div id="password-requirements" class="row g-2 mb-3">
                        <div class="col-6">
                            <div class="d-flex align-items-center gap-2">
                                <i id="req-length" class="bi bi-circle" style="color: #999; font-size: 18px;"></i>
                                <small>Mín. 8 caracteres</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center gap-2">
                                <i id="req-lowercase" class="bi bi-circle" style="color: #999; font-size: 18px;"></i>
                                <small>Minúscula</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center gap-2">
                                <i id="req-uppercase" class="bi bi-circle" style="color: #999; font-size: 18px;"></i>
                                <small>Mayúscula</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center gap-2">
                                <i id="req-number" class="bi bi-circle" style="color: #999; font-size: 18px;"></i>
                                <small>Número</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center gap-2">
                                <i id="req-special" class="bi bi-circle" style="color: #999; font-size: 18px;"></i>
                                <small>Carácter especial</small>
                            </div>
                        </div>
                    </div>

                    @error('password')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
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
                <div id="password-match-message" class="small mt-1"></div>

                <!-- Botón -->
                <div class="d-grid gap-2">
                    <button type="submit" id="submitBtn" class="btn text-white fw-bold py-2 btn-corporativo">
                    Restablecer Contraseña
                    </button>
                </div>
            </form>
        </div>
    </div>

    @stack('scripts')
</x-guest-layout>
