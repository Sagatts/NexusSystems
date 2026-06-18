<div class="card shadow-sm border-0 rounded-4">

    <div class="card-header bg-white">
        <h4 class="fw-bold mb-0">
            Cambiar Contraseña
        </h4>
    </div>

    <div class="card-body">

        <form id="updatePasswordForm" method="POST" action="{{ route('password.update') }}">
            @csrf
            @method('PUT')

            <div class="row g-3">

                <div class="col-md-12">
                    <label class="form-label fw-bold">
                        Contraseña Actual
                    </label>

                    <input
                        type="password"
                        name="current_password"
                        id="current_password"
                        class="form-control @error('current_password', 'updatePassword') is-invalid @enderror">

                    @error('current_password', 'updatePassword')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="col-md-12">
                    <label class="form-label fw-bold">
                        Nueva Contraseña
                    </label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-control @error('password', 'updatePassword') is-invalid @enderror">

                    <!-- Barra de fortaleza -->
                    <div id="password-strength-container" class="mt-2 mb-3">
                        <div class="progress" style="height: 6px;">
                            <div id="password-strength-bar"
                                class="progress-bar"
                                style="width: 0%; transition: width 0.3s ease;">
                            </div>
                        </div>

                        <small id="password-strength-text"
                            class="d-block mt-1"
                            style="color: #999;">
                        </small>
                    </div>

                    <!-- Requisitos -->
                    <div id="password-requirements" class="row g-2 mb-3">

                        <div class="col-6">
                            <div class="d-flex align-items-center gap-2">
                                <i id="req-length" class="bi bi-circle"
                                    style="color: #999; font-size: 18px;"></i>
                                <small>Mín. 8 caracteres</small>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="d-flex align-items-center gap-2">
                                <i id="req-lowercase" class="bi bi-circle"
                                    style="color: #999; font-size: 18px;"></i>
                                <small>Minúscula</small>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="d-flex align-items-center gap-2">
                                <i id="req-uppercase" class="bi bi-circle"
                                    style="color: #999; font-size: 18px;"></i>
                                <small>Mayúscula</small>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="d-flex align-items-center gap-2">
                                <i id="req-number" class="bi bi-circle"
                                    style="color: #999; font-size: 18px;"></i>
                                <small>Número</small>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="d-flex align-items-center gap-2">
                                <i id="req-special" class="bi bi-circle"
                                    style="color: #999; font-size: 18px;"></i>
                                <small>Carácter especial</small>
                            </div>
                        </div>

                    </div>

                    @error('password', 'updatePassword')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror

                    <div id="password-error" class="text-danger small mt-2"></div>
                </div>

                <div class="col-md-12">
                    <label class="form-label fw-bold">
                        Confirmar Contraseña
                    </label>

                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        class="form-control">

                    <div id="password-match-message" class="small mt-2"></div>
                </div>

            </div>

            <div class="mt-4 d-flex justify-content-end">
                <button type="submit" class="btn btn-warning">
                    Actualizar Contraseña
                </button>
            </div>

        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('updatePasswordForm');

    const passwordInput = document.getElementById('password');
    const confirmInput = document.getElementById('password_confirmation');

    const strengthBar = document.getElementById('password-strength-bar');
    const strengthText = document.getElementById('password-strength-text');
    const matchMessage = document.getElementById('password-match-message');
    const errorMessage = document.getElementById('password-error');

    const requirements = {
        length: {
            element: document.getElementById('req-length'),
            regex: /.{8,}/
        },
        lowercase: {
            element: document.getElementById('req-lowercase'),
            regex: /[a-z]/
        },
        uppercase: {
            element: document.getElementById('req-uppercase'),
            regex: /[A-Z]/
        },
        number: {
            element: document.getElementById('req-number'),
            regex: /\d/
        },
        special: {
            element: document.getElementById('req-special'),
            regex: /[^a-zA-Z0-9]/
        }
    };

    const strengthLevels = [
        { min: 0, max: 20, text: 'Muy débil', color: '#dc3545' },
        { min: 21, max: 40, text: 'Débil', color: '#fd7e14' },
        { min: 41, max: 60, text: 'Regular', color: '#ffc107' },
        { min: 61, max: 80, text: 'Buena', color: '#17a2b8' },
        { min: 81, max: 100, text: 'Muy fuerte', color: '#28a745' }
    ];

    function validatePassword() {

        const password = passwordInput.value;

        let strength = 0;
        let metRequirements = 0;

        Object.values(requirements).forEach(req => {

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

        strengthBar.style.width = strength + '%';

        const level = strengthLevels.find(
            l => strength >= l.min && strength <= l.max
        );

        if (level) {

            strengthBar.style.backgroundColor = level.color;
            strengthText.textContent = level.text;
            strengthText.style.color = level.color;
        }

        if (confirmInput.value.length > 0) {

            if (password === confirmInput.value) {

                matchMessage.innerHTML =
                    '<span class="text-success">✓ Las contraseñas coinciden</span>';

            } else {

                matchMessage.innerHTML =
                    '<span class="text-danger">✗ Las contraseñas no coinciden</span>';
            }

        } else {

            matchMessage.innerHTML = '';
        }

        return metRequirements === 5;
    }

    passwordInput.addEventListener('input', validatePassword);
    confirmInput.addEventListener('input', validatePassword);

    form.addEventListener('submit', function (e) {

        errorMessage.innerHTML = '';

        const password = passwordInput.value;
        const confirmation = confirmInput.value;

        const passwordValida = validatePassword();

        if (!passwordValida) {

            e.preventDefault();

            errorMessage.innerHTML =
                'La contraseña debe tener al menos 8 caracteres, una mayúscula, una minúscula, un número y un carácter especial.';

            return;
        }

        if (password !== confirmation) {

            e.preventDefault();

            errorMessage.innerHTML =
                'Las contraseñas no coinciden.';

            return;
        }
    });

});
</script>