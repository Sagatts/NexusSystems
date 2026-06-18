<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Usuario: {{ $usuario->nombre }}
        </h2>
    </x-slot>

    <div class="container-fluid mt-4">

        <div class="card shadow-sm border-0 rounded-4">

            <div class="card-header bg-white">
                <h4 class="fw-bold mb-0">
                    Actualizar Datos del Usuario
                </h4>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.usuarios.update', $usuario->rut) }}" method="POST" novalidate>
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <div class="col-md-12 mb-3">
                            <label for="nombre" class="form-label fw-bold">Nombre Completo</label>
                            <input type="text" name="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre', $usuario->nombre) }}" required>
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="rut" class="form-label fw-bold">RUT</label>
                            <input type="text" name="rut" id="rut" class="form-control bg-light @error('rut') is-invalid @enderror" value="{{ old('rut', $usuario->rut) }}" readonly>
                            <small class="text-muted">El RUT no se puede modificar.</small>
                            @error('rut')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label fw-bold">Correo Electrónico</label>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $usuario->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="rol" class="form-label fw-bold">Rol Asignado</label>
                            <select name="rol" id="rol" class="form-select @error('rol') is-invalid @enderror" required>
                                <option value="administrador" {{ old('rol', $usuario->rol) == 'administrador' ? 'selected' : '' }}>Administrador</option>
                                <option value="garzon" {{ old('rol', $usuario->rol) == 'garzon' ? 'selected' : '' }}>Garzón</option>
                                <option value="cocina" {{ old('rol', $usuario->rol) == 'cocina' ? 'selected' : '' }}>Cocina</option>
                            </select>
                            @error('rol')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="contrasena" class="form-label fw-bold text-primary">Nueva Contraseña (Opcional)</label>
                            <input type="password" name="contrasena" id="contrasena" class="form-control border-primary @error('contrasena') is-invalid @enderror" placeholder="Dejar en blanco para mantener la actual">
                            <small class="text-muted">Solo escribe aquí si necesitas resetear el acceso.</small>

                            <div id="password-strength-container" class="mt-2 mb-3">
                                <div class="progress" style="height: 6px;">
                                    <div id="password-strength-bar" class="progress-bar" style="width: 0%; transition: width 0.3s ease;"></div>
                                </div>
                                <small id="password-strength-text" class="d-block mt-1" style="color: #999;"></small>
                            </div>

                            @error('contrasena')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="contrasena_confirmation" class="form-label fw-bold text-primary">Confirmar Nueva Contraseña</label>
                            <input type="password" name="contrasena_confirmation" id="contrasena_confirmation" class="form-control border-primary @error('contrasena_confirmation') is-invalid @enderror" placeholder="Repite la nueva contraseña">
                            
                            <div id="password-match-text" class="mt-2" style="font-size: 0.875em; display: none;"></div>
                        </div>

                        <div class="col-md-12 mb-3">
                            <div id="password-requirements" class="row g-2">
                                <div class="col-auto"><div class="d-flex align-items-center gap-2"><i id="req-length" class="bi bi-circle" style="color: #999; font-size: 16px;"></i><small>Mín. 8 caracteres</small></div></div>
                                <div class="col-auto"><div class="d-flex align-items-center gap-2"><i id="req-lowercase" class="bi bi-circle" style="color: #999; font-size: 16px;"></i><small>Minúscula</small></div></div>
                                <div class="col-auto"><div class="d-flex align-items-center gap-2"><i id="req-uppercase" class="bi bi-circle" style="color: #999; font-size: 16px;"></i><small>Mayúscula</small></div></div>
                                <div class="col-auto"><div class="d-flex align-items-center gap-2"><i id="req-number" class="bi bi-circle" style="color: #999; font-size: 16px;"></i><small>Número</small></div></div>
                                <div class="col-auto"><div class="d-flex align-items-center gap-2"><i id="req-special" class="bi bi-circle" style="color: #999; font-size: 16px;"></i><small>Carácter especial</small></div></div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 d-flex justify-content-end gap-2 border-top pt-4">
                        <a href="{{ route('admin.usuarios.index') }}" class="btn btn-secondary fw-bold shadow-sm">
                            Cancelar
                        </a>
                        <button type="submit" class="btn btn-success fw-bold shadow-sm">
                            <i class="bi bi-arrow-clockwise me-1"></i> Actualizar Usuario
                        </button>
                    </div>

                </form>
            </div>

        </div>

    </div>

    @push('scripts')
    <script>
        const passwordInput = document.getElementById('contrasena');
        const confirmPasswordInput = document.getElementById('contrasena_confirmation');
        const matchText = document.getElementById('password-match-text');
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

        function checkPasswordsMatch() {
            // Si ambos campos están vacíos, no mostrar nada
            if (passwordInput.value === '' && confirmPasswordInput.value === '') {
                matchText.style.display = 'none';
                confirmPasswordInput.classList.remove('is-valid', 'is-invalid');
                return;
            }

            // Si solo el de confirmación está vacío pero el original tiene algo
            if (confirmPasswordInput.value === '') {
                matchText.style.display = 'none';
                return;
            }
            
            matchText.style.display = 'block';
            if (passwordInput.value === confirmPasswordInput.value) {
                matchText.innerHTML = '<i class="bi bi-check-circle-fill"></i> Las contraseñas coinciden';
                matchText.style.color = '#28a745';
                confirmPasswordInput.classList.remove('is-invalid');
                confirmPasswordInput.classList.add('is-valid');
            } else {
                matchText.innerHTML = '<i class="bi bi-x-circle-fill"></i> Las contraseñas no coinciden';
                matchText.style.color = '#dc3545';
                confirmPasswordInput.classList.remove('is-valid');
                confirmPasswordInput.classList.add('is-invalid');
            }
        }

        passwordInput.addEventListener('input', () => {
            const password = passwordInput.value;
            let strength = 0;
            
            // Si borran la contraseña, reiniciar todo
            if(password.length === 0) {
                strengthBar.style.width = '0%';
                strengthText.textContent = '';
                Object.values(requirements).forEach(req => {
                    req.element.classList.replace('bi-check-circle-fill', 'bi-circle');
                    req.element.style.color = '#999';
                });
                checkPasswordsMatch();
                return;
            }

            Object.entries(requirements).forEach(([key, req]) => {
                if (req.regex.test(password)) {
                    strength += 20;
                    req.element.classList.replace('bi-circle', 'bi-check-circle-fill');
                    req.element.style.color = '#28a745';
                } else {
                    req.element.classList.replace('bi-check-circle-fill', 'bi-circle');
                    req.element.style.color = '#999';
                }
            });

            strengthBar.style.width = strength + '%';
            const level = strengthLevels.find(l => strength >= l.min && strength <= l.max);
            if (level) {
                strengthBar.style.backgroundColor = level.color;
                strengthText.textContent = level.text;
                strengthText.style.color = level.color;
            }
            checkPasswordsMatch();
        });

        confirmPasswordInput.addEventListener('input', checkPasswordsMatch);
    </script>
    @endpush
</x-app-layout>