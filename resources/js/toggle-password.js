/**
 * Mostrar/Ocultar contraseña
 * Usado en: auth/login
 */

document.addEventListener('DOMContentLoaded', function () {
    const btnToggle = document.getElementById('btnTogglePassword');
    const inputPassword = document.getElementById('password');

    if (btnToggle && inputPassword) {
        btnToggle.addEventListener('click', function () {
            if (inputPassword.type === 'password') {
                inputPassword.type = 'text';
                btnToggle.classList.remove('bi-eye-slash');
                btnToggle.classList.add('bi-eye');
                btnToggle.setAttribute('title', 'Ocultar contraseña');
            } else {
                inputPassword.type = 'password';
                btnToggle.classList.remove('bi-eye');
                btnToggle.classList.add('bi-eye-slash');
                btnToggle.setAttribute('title', 'Mostrar contraseña');
            }
        });
    }
});