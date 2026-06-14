/**
 * Validador de correo electrónico en tiempo real
 */

function validarCorreo(correo) {
    const correoLimpio = correo.trim();

    if (correoLimpio === '') {
        return { valido: false, mensaje: 'El correo electrónico es requerido' };
    }

    if (correoLimpio.length > 255) {
        return { valido: false, mensaje: 'El correo no puede exceder 255 caracteres' };
    }

    // Validar formato básico
    const patronBasico = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!patronBasico.test(correoLimpio)) {
        return { valido: false, mensaje: 'Formato de correo incorrecto' };
    }

    // Dividir en usuario y dominio
    const partes = correoLimpio.split('@');
    if (partes.length !== 2) {
        return { valido: false, mensaje: 'El correo debe contener exactamente un @' };
    }

    const usuario = partes[0];
    const dominio = partes[1];

    // Validar parte del usuario
    if (!/^[a-zA-Z0-9._%-]+$/.test(usuario)) {
        return { valido: false, mensaje: 'El usuario contiene caracteres no permitidos' };
    }

    // Validar que no empiece o termine con punto
    if (usuario[0] === '.' || usuario[usuario.length - 1] === '.') {
        return { valido: false, mensaje: 'El usuario no puede empezar o terminar con punto' };
    }

    // Validar puntos consecutivos
    if (usuario.includes('..')) {
        return { valido: false, mensaje: 'El usuario no puede contener puntos consecutivos' };
    }

    // Validar dominio
    if (!/^[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(dominio)) {
        return { valido: false, mensaje: 'El dominio debe tener un formato válido' };
    }

    // Validar puntos consecutivos en dominio
    if (dominio.includes('..')) {
        return { valido: false, mensaje: 'El dominio no puede contener puntos consecutivos' };
    }

    // Validar que no empiece con punto
    if (dominio[0] === '.') {
        return { valido: false, mensaje: 'El dominio no puede empezar con punto' };
    }

    // Validar extensión
    const extensionDominio = dominio.substring(dominio.lastIndexOf('.') + 1);
    if (extensionDominio.length < 2) {
        return { valido: false, mensaje: 'La extensión del dominio es muy corta' };
    }

    return { valido: true, mensaje: 'Correo válido' };
}

function configurarValidacionCorreoTiempoReal(correoInputId) {
    const correoInput = document.getElementById(correoInputId);
    
    if (!correoInput) return;

    let feedbackElement = correoInput.nextElementSibling;
    if (!feedbackElement || !feedbackElement.classList.contains('correo-feedback')) {
        feedbackElement = document.createElement('div');
        feedbackElement.classList.add('correo-feedback', 'small', 'mt-2');
        correoInput.parentNode.insertBefore(feedbackElement, correoInput.nextSibling);
    }

    correoInput.addEventListener('input', function() {
        let valor = this.value.trim();

        if (valor === '') {
            this.classList.remove('is-invalid', 'is-valid');
            feedbackElement.textContent = '';
            feedbackElement.style.color = '';
            return;
        }

        const validacion = validarCorreo(valor);

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

    correoInput.addEventListener('blur', function() {
        const valor = this.value.trim();
        if (valor === '') {
            this.classList.remove('is-invalid', 'is-valid');
            feedbackElement.textContent = '';
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    // Configurar validación para todos los campos de correo
    const camposCorreo = ['email'];
    
    camposCorreo.forEach(function(campoId) {
        configurarValidacionCorreoTiempoReal(campoId);
    });
});
