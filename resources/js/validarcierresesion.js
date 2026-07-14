
document.addEventListener('DOMContentLoaded', function () {
    const logoutButtons = document.querySelectorAll('.btn-logout');

    logoutButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault(); 

            Swal.fire({
                title: '¿Estás seguro?',
                text: "¿Deseas cerrar tu sesión actual?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545', 
                cancelButtonColor: '#6c757d', 
                confirmButtonText: 'Sí, salir',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        });
    });
});
