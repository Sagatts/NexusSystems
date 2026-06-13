/**
 * Validador de RUT chileno en tiempo real
 */

function calcularDVRut(numero) {
    let suma = 0;
    let multiplicador = 2;

    for (let i = numero.length - 1; i >= 0; i--) {
        suma += parseInt(numero[i]) * multiplicador;
        multiplicador++;
        if (multiplicador > 7) {
            multiplicador = 2;
        }
    }

    const resto = suma % 11;
    const dv = 11 - resto;

    if (dv === 11) return '0';
    if (dv === 10) return 'K';
    return dv.toString();
}

function validarRut(rut) {
    const rutLimpio = rut.replace(/[\.\s]/g, '');

    if (!rutLimpio.includes('-')) {
        return { valido: false, mensaje: 'El RUT debe incluir el guión' };
    }

    const partes = rutLimpio.split('-');
    if (partes.length !== 2) {
        return { valido: false, mensaje: 'Formato de RUT incorrecto' };
    }

    const numero = partes[0];
    const verificador = partes[1].toUpperCase();

    if (!/^\d{7,8}$/.test(numero)) {
        return { valido: false, mensaje: 'El RUT debe tener 7 u 8 dígitos' };
    }

    const dvCalculado = calcularDVRut(numero);

    if (verificador !== dvCalculado) {
        return { valido: false, mensaje: 'El dígito verificador es inválido' };
    }

    return { valido: true, mensaje: 'RUT válido' };
}

function configurarValidacionRutTiempoReal(rutInputId) {
    const rutInput = document.getElementById(rutInputId);
    
    if (!rutInput) return;

    let feedbackElement = rutInput.nextElementSibling;
    if (!feedbackElement || !feedbackElement.classList.contains('rut-feedback')) {
        feedbackElement = document.createElement('div');
        feedbackElement.classList.add('rut-feedback', 'small', 'mt-2');
        rutInput.parentNode.insertBefore(feedbackElement, rutInput.nextSibling);
    }

    rutInput.addEventListener('input', function() {
        let valor = this.value.trim();
        const rutNormalizado = valor.replace(/[\.\s]/g, '');
        
        if (rutNormalizado !== valor) {
            this.value = rutNormalizado;
            valor = rutNormalizado;
        }

        if (valor === '') {
            this.classList.remove('is-invalid', 'is-valid');
            feedbackElement.textContent = '';
            feedbackElement.style.color = '';
            return;
        }

        const validacion = validarRut(valor);

        if (validacion.valido) {
            this.classList.remove('is-invalid');
            this.classList.add('is-valid');
            feedbackElement.textContent = '✓ ' + validacion.mensaje;
            feedbackElement.style.color = '#28a745';
        } else {
            this.classList.remove('is-valid');
            this.classList.add('is-invalid');
            feedbackElement.textContent = '✗ ' + validacion.mensaje;
            feedbackElement.style.color = '#dc3545';
        }
    });

    rutInput.addEventListener('blur', function() {
        const valor = this.value.trim();
        if (valor === '') {
            this.classList.remove('is-invalid', 'is-valid');
            feedbackElement.textContent = '';
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    configurarValidacionRutTiempoReal('rut');
});
