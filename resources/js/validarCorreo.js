/**
 * Validación de Correo Electrónico
 */

function validarCorreo(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}

window.validarCorreo = validarCorreo;

document.addEventListener('DOMContentLoaded', function() {
    const emailInputs = document.querySelectorAll('[data-validar="correo"]');

    emailInputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (input.value && !validarCorreo(input.value)) {
                input.classList.add('is-invalid');
            } else {
                input.classList.remove('is-invalid');
            }
        });
    });
});