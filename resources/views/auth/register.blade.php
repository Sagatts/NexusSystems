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
                        <div class="invalid-feedback d-block">
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
