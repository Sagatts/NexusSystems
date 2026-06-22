/**
 * Validación de RUT chileno
 */

function formatearRut(rut) {
    rut = rut.replace(/[^\dKk]/g, '');
    if (rut.length < 2) return rut;
    const dv = rut.slice(-1);
    const numero = rut.slice(0, -1);
    let formatted = '';
    for (let i = numero.length - 1, j = 0; i >= 0; i--, j++) {
        formatted = numero[i] + formatted;
        if (j % 3 === 2 && i !== 0) formatted = '.' + formatted;
    }
    return formatted + '-' + dv;
}

function validarRut(rut) {
    rut = rut.replace(/[^\dKk]/g, '');
    if (rut.length < 2) return false;
    const dv = rut.slice(-1).toUpperCase();
    const numero = rut.slice(0, -1);
    let suma = 0;
    let multiplicador = 2;
    for (let i = numero.length - 1; i >= 0; i--) {
        suma += parseInt(numero[i]) * multiplicador;
        multiplicador = multiplicador === 7 ? 2 : multiplicador + 1;
    }
    const resto = suma % 11;
    const dvCalculado = resto === 0 ? '0' : resto === 1 ? 'K' : (11 - resto).toString();
    return dv === dvCalculado;
}

window.formatearRut = formatearRut;
window.validarRut = validarRut;

document.addEventListener('DOMContentLoaded', function() {
    const rutInputs = document.querySelectorAll('[data-validar="rut"]');

    rutInputs.forEach(input => {
        input.addEventListener('input', function(e) {
            const cursorPos = e.target.selectionStart;
            const oldLength = e.target.value.length;
            e.target.value = formatearRut(e.target.value);
            const newLength = e.target.value.length;
            const newCursorPos = cursorPos + (newLength - oldLength);
            e.target.setSelectionRange(newCursorPos, newCursorPos);
        });

        input.addEventListener('blur', function() {
            if (input.value && !validarRut(input.value)) {
                input.classList.add('is-invalid');
            } else {
                input.classList.remove('is-invalid');
            }
        });
    });
});