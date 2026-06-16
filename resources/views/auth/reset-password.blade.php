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

                <!-- Botón -->
                <div class="d-grid gap-2">
                    <button type="submit" class="btn text-white fw-bold py-2 btn-corporativo">
                        Restablecer Contraseña
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const passwordInput = document.getElementById('password');
        const strengthBar = document.getElementById('password-strength-bar');
        const strengthText = document.getElementById('password-strength-text');
        
        const requirements = {
            length: { element: document.getElementById('req-length'), regex: /.{8,}/ },
            lowercase: { element: document.getElementById('req-lowercase'), regex: /[a-z]/ },
            uppercase: { element: document.getElementById('req-uppercase'), regex: /[A-Z]/ },
            number: { element: document.getElementById('req-number'), regex: /\d/ },
            special: { element: document.getElementById('req-special'), regex: /[^a-zA-Z0-9]/ }
        };

        const strengthLevels = [
            { min: 0, max: 20, text: 'Muy débil', color: '#dc3545' },
            { min: 21, max: 40, text: 'Débil', color: '#fd7e14' },
            { min: 41, max: 60, text: 'Regular', color: '#ffc107' },
            { min: 61, max: 80, text: 'Buena', color: '#17a2b8' },
            { min: 81, max: 100, text: 'Muy fuerte', color: '#28a745' }
        ];

        passwordInput.addEventListener('input', () => {
            const password = passwordInput.value;
            let strength = 0;
            let metRequirements = 0;

            // Verificar cada requisito
            Object.entries(requirements).forEach(([key, req]) => {
                const isMet = req.regex.test(password);
                if (isMet) {
                    metRequirements++;
                    strength += 20;
                    req.element.classList.remove('bi-circle');
                    req.element.classList.add('bi-check-circle-fill');
                    req.element.style.color = '#28a745';
                } else {
                    req.element.classList.remove('bi-check-circle-fill');
                    req.element.classList.add('bi-circle');
                    req.element.style.color = '#999';
                }
            });

            // Actualizar barra de fortaleza
            strengthBar.style.width = strength + '%';
            
            // Determinar nivel de fortaleza
            const level = strengthLevels.find(l => strength >= l.min && strength <= l.max);
            if (level) {
                strengthBar.style.backgroundColor = level.color;
                strengthText.textContent = level.text;
                strengthText.style.color = level.color;
            }
        });
    </script>
</x-guest-layout>
