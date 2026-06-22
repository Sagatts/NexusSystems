/**
 * Validación de fortaleza de contraseña
 * Usado en: usuarios/create, usuarios/edit, reset-password
 */

document.addEventListener('DOMContentLoaded', function () {
    const passwordInput = document.getElementById('contrasena') || document.getElementById('password');
    const confirmPasswordInput = document.getElementById('contrasena_confirmation');
    const matchText = document.getElementById('password-match-text');
    const strengthBar = document.getElementById('password-strength-bar');
    const strengthText = document.getElementById('password-strength-text');

    if (!passwordInput) return;

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
        if (!confirmPasswordInput) return;

        if (confirmPasswordInput.value === '' && passwordInput.value === '') {
            if (matchText) matchText.style.display = 'none';
            confirmPasswordInput.classList.remove('is-valid', 'is-invalid');
            return;
        }

        if (confirmPasswordInput.value === '') {
            if (matchText) matchText.style.display = 'none';
            return;
        }

        if (matchText) {
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
    }

    passwordInput.addEventListener('input', () => {
        const password = passwordInput.value;
        let strength = 0;

        if (password.length === 0) {
            if (strengthBar) strengthBar.style.width = '0%';
            if (strengthText) strengthText.textContent = '';
            Object.values(requirements).forEach(req => {
                if (req.element) {
                    req.element.classList.replace('bi-check-circle-fill', 'bi-circle');
                    req.element.style.color = '#999';
                }
            });
            checkPasswordsMatch();
            return;
        }

        Object.entries(requirements).forEach(([key, req]) => {
            if (req.regex.test(password)) {
                strength += 20;
                if (req.element) {
                    req.element.classList.replace('bi-circle', 'bi-check-circle-fill');
                    req.element.style.color = '#28a745';
                }
            } else {
                if (req.element) {
                    req.element.classList.replace('bi-check-circle-fill', 'bi-circle');
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
        checkPasswordsMatch();
    });

    if (confirmPasswordInput) {
        confirmPasswordInput.addEventListener('input', checkPasswordsMatch);
    }
});