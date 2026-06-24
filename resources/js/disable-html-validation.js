document.addEventListener("DOMContentLoaded", function() {
    const formularios = document.querySelectorAll('form');
    formularios.forEach(form => {
        form.setAttribute('novalidate', 'novalidate');
    });
});