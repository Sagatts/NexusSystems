/**
 * Lógica de Pedidos para Garzón/Cocina
 * Usado en: garzon_cocina/pedidos
 */

function initPedidos() {
    // Verificar que jQuery esté cargado
    if (typeof window.jQuery === 'undefined') {
        setTimeout(initPedidos, 50);
        return;
    }

    // Verificar que existe la tabla
    if (!window.jQuery('#tablaGarzon').length) return;

    const $ = window.jQuery;

    let tabla = $('#tablaGarzon').DataTable({
        scrollX: true,
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
        },
        columnDefs: [
            { targets: 4, orderable: false, searchable: false }
        ],

        initComplete: function() {
            let api = this.api();
            let contenedorBuscador = $('.dataTables_filter');
            contenedorBuscador.empty();

            let buscadorHTML = `
                <div class="input-group input-group-sm mb-0 ms-auto" style="max-width: 250px;">
                    <span class="input-group-text bg-white text-muted border-end-0"><i class="bi bi-search"></i></span>
                    <input type="text" id="buscadorSuperior" class="form-control border-start-0 ps-0" placeholder="Buscar producto...">
                </div>
            `;
            contenedorBuscador.append(buscadorHTML);
            $('#buscadorSuperior').on('keyup', function() { api.search(this.value).draw(); });

            let contenedorPaginacion = $('.dataTables_paginate').parent();
            contenedorPaginacion.addClass('d-flex flex-wrap justify-content-md-end align-items-center gap-3 mt-3 mt-md-0');
            let botonConfirmarHTML = `
                <button type="button" class="btn btn-success fw-bold shadow-sm px-4" id="btnAbrirModalConfirmacion">
                    Confirmar <i class="bi bi-check-circle ms-1"></i>
                </button>
            `;
            $('.dataTables_paginate').after(botonConfirmarHTML);
        }
    });

    // Botones de Sumar y Restar
    $('#tablaGarzon tbody').on('click', '.btn-sumar', function() {
        let input = $(this).siblings('.input-cantidad');
        input.val(parseInt(input.val() || 0) + 1);
    });

    $('#tablaGarzon tbody').on('click', '.btn-restar', function() {
        let input = $(this).siblings('.input-cantidad');
        let valorActual = parseInt(input.val() || 0);
        if (valorActual > 0) input.val(valorActual - 1);
    });

    // Lógica del Pedido (Modal y Base de Datos)
    let arregloProductosFinal = [];

    $(document).on('click', '#btnAbrirModalConfirmacion', function() {
        arregloProductosFinal = [];
        $('#listaResumenPedido').empty();

        tabla.$('input.input-cantidad').each(function() {
            let cantidad = parseInt($(this).val());

            if (cantidad > 0) {
                let idProducto = $(this).data('id');
                let nombreProducto = $(this).closest('tr').find('td:eq(1)').text().trim();

                arregloProductosFinal.push({
                    id: idProducto,
                    cantidad: cantidad
                });

                let diseñoLista = `
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        ${nombreProducto}
                        <span class="badge bg-primary rounded-pill px-3 py-2 fs-6 shadow-sm">x ${cantidad}</span>
                    </li>
                `;
                $('#listaResumenPedido').append(diseñoLista);
            }
        });

        if (arregloProductosFinal.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Carrito vacío',
                text: 'Debes sumar al menos 1 producto para poder confirmar el retiro.',
                confirmButtonColor: '#0d6efd'
            });
            return;
        }

        $('#modalConfirmarPedido').modal('show');
    });

    $('#btnEnviarPedidoFinal').click(function() {

        let btn = $(this);
        btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Procesando...');

        $.ajax({
            url: window.pedidosRoute || '/pedidos/procesar',
            type: 'POST',
            data: {
                _token: window.csrfToken || $('meta[name="csrf-token"]').attr('content'),
                productos: arregloProductosFinal
            },
            success: function(response) {
                $('#modalConfirmarPedido').modal('hide');

                if(response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Retiro exitoso!',
                        text: 'Los productos han sido descontados del inventario.',
                        showConfirmButton: false,
                        timer: 2000
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Error', response.message, 'error');
                    btn.prop('disabled', false).text('Confirmar y Descontar');
                }
            },
            error: function() {
                $('#modalConfirmarPedido').modal('hide');
                Swal.fire('Error crítico', 'Hubo un problema de conexión con el servidor.', 'error');
                btn.prop('disabled', false).text('Confirmar y Descontar');
            }
        });
    });
}

// Inicializar cuando el DOM esté listo
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initPedidos);
} else {
    initPedidos();
}