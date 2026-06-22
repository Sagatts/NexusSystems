/**
 * Validación de formulario de producto
 * Usado en: admin/productos/create, admin/productos/edit
 */

document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('productoForm');

    if (!form) return;

    const nombre = document.getElementById('nombre');
    const codigo = document.getElementById('codigo_barras');
    const categoria = document.getElementById('id_categoria');
    const precio = document.getElementById('precio_neto');
    const stock = document.getElementById('stock');
    const fecha = document.getElementById('fecha_vencimiento');

    function mostrarError(campo, mensaje) {
        if (!campo) return;
        campo.classList.add('is-invalid');

        const existingError = campo.parentNode.querySelector('.error-js');
        if (existingError) existingError.remove();

        const div = document.createElement('div');
        div.className = 'invalid-feedback error-js';
        div.innerText = mensaje;
        campo.parentNode.appendChild(div);
    }

    function limpiarErrores() {
        document.querySelectorAll('.is-invalid').forEach(campo => {
            campo.classList.remove('is-invalid');
        });

        document.querySelectorAll('.error-js').forEach(el => el.remove());
    }

    form.addEventListener('submit', function (e) {
        limpiarErrores();

        let valido = true;

        if (!nombre.value.trim()) {
            mostrarError(nombre, 'Debe ingresar un nombre.');
            valido = false;
        }

        if (!codigo.value.trim()) {
            mostrarError(codigo, 'Debe ingresar un código de barras.');
            valido = false;
        }

        if (!categoria.value) {
            mostrarError(categoria, 'Debe seleccionar una categoría.');
            valido = false;
        }

        if (precio.value === '' || parseFloat(precio.value) < 0) {
            mostrarError(precio, 'Ingrese un precio válido.');
            valido = false;
        }

        if (stock.value === '' || parseInt(stock.value) < 0) {
            mostrarError(stock, 'Ingrese un stock válido.');
            valido = false;
        }

        if (!fecha.value) {
            mostrarError(fecha, 'Debe ingresar una fecha de vencimiento.');
            valido = false;
        } else {
            const hoy = new Date();
            hoy.setHours(0, 0, 0, 0);
            const fechaIngresada = new Date(fecha.value);

            if (fechaIngresada < hoy) {
                mostrarError(fecha, 'La fecha de vencimiento no puede ser anterior a hoy.');
                valido = false;
            }
        }

        if (!valido) {
            e.preventDefault();
        }
    });
});