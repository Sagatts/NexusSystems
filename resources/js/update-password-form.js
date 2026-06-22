/**
 * Validación del formulario de actualización de contraseña (Profile)
 * Usado en: profile/partials/update-password-form
 */

document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('updatePasswordForm');

    if (!form) return;

    const passwordInput = document.getElementById('password');
    const confirmInput = document.getElementById('password_confirmation');

    const strengthBar = document.getElementById('password-strength-bar');
    const strengthText = document.getElementById('password-strength-text');
    const matchMessage = document.getElementById('password-match-message');
    const errorMessage = document.getElementById('password-error');

    if (!passwordInput || !confirmInput) return;

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

    function validatePassword() {
        const password = passwordInput.value;
        let strength = 0;
        let metRequirements = 0;

        Object.values(requirements).forEach(req => {
            const isMet = req.regex.test(password);
            if (isMet) {
                metRequirements++;
                strength += 20;
                if (req.element) {
                    req.element.classList.remove('bi-circle');
                    req.element.classList.add('bi-check-circle-fill');
                    req.element.style.color = '#28a745';
                }
            } else {
                if (req.element) {
                    req.element.classList.remove('bi-check-circle-fill');
                    req.element.classList.add('bi-circle');
                    req.element.style.color = '#999';
                }
            }
        });

        if (strengthBar) strengthBar.style.width = strength + '%';

        const level = strengthLevels.find(l => strength >= l.min && strength <= l.max);
        if (level) {
            if (strengthBar) strengthBar.style.backgroundColor = level.color;
            if (strengthText) {
                strengthText.textContent = level.text;
                strengthText.style.color = level.color;
            }
        }

        if (confirmInput.value.length > 0) {
            if (password === confirmInput.value) {
                if (matchMessage) {
                    matchMessage.innerHTML = '<span class="text-success">✓ Las contraseñas coinciden</span>';
                }
            } else {
                if (matchMessage) {
                    matchMessage.innerHTML = '<span class="text-danger">✗ Las contraseñas no coinciden</span>';
                }
            }
        } else {
            if (matchMessage) matchMessage.innerHTML = '';
        }

        return metRequirements === 5;
    }

    passwordInput.addEventListener('input', validatePassword);
    confirmInput.addEventListener('input', validatePassword);

    form.addEventListener('submit', function (e) {
        if (errorMessage) errorMessage.innerHTML = '';

        const password = passwordInput.value;
        const confirmation = confirmInput.value;

        const passwordValida = validatePassword();

        if (!passwordValida) {
            e.preventDefault();
            if (errorMessage) {
                errorMessage.innerHTML = 'La contraseña debe tener al menos 8 caracteres, una mayúscula, una minúscula, un número y un carácter especial.';
            }
            return;
        }

        if (password !== confirmation) {
            e.preventDefault();
            if (errorMessage) {
                errorMessage.innerHTML = 'Las contraseñas no coinciden.';
            }
            return;
        }
    });
});