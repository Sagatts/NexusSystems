/**
 * Validación del formulario de perfil
 * Usado en: profile/partials/update-profile-information-form
 */

document.addEventListener('DOMContentLoaded', function() {

    const form = document.getElementById('profileForm');

    if (!form) return;

    const nombre = document.getElementById('nombre');
    const email = document.getElementById('email');

    form.addEventListener('submit', function(e) {

        let valido = true;

        document.getElementById('nombreError').innerHTML = '';
        document.getElementById('emailError').innerHTML = '';

        nombre.classList.remove('is-invalid');
        email.classList.remove('is-invalid');

        if (nombre.value.trim() === '') {
            document.getElementById('nombreError').innerHTML = 'Debe ingresar un nombre.';
            nombre.classList.add('is-invalid');
            valido = false;
        }

        if (email.value.trim() === '') {
            document.getElementById('emailError').innerHTML = 'Debe ingresar un correo electrónico.';
            email.classList.add('is-invalid');
            valido = false;
        }
        else {
            const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!regex.test(email.value)) {
                document.getElementById('emailError').innerHTML = 'Debe ingresar un correo válido.';
                email.classList.add('is-invalid');
                valido = false;
            }
        }

        if (!valido) {
            e.preventDefault();
        }

    });

});