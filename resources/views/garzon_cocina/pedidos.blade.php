<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>La Picá de Yiyo - Operaciones</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
    <link rel="icon" href="{{ asset('img/logo-yiyo.png') }}" type="image/png">

    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    
    <style>
        .dataTables_wrapper { max-width: 100%; overflow-x: hidden; }
        .dataTables_scrollBody { overflow-x: auto !important; width: 100% !important; }
        .input-cantidad { background-color: white !important; cursor: default; }
        .dataTables_info { padding-top: 0 !important; margin-bottom: 0 !important; }
        .buscador-responsivo { max-width: 250px; }
        
        @media (max-width: 767px) {
            .buscador-responsivo { max-width: 100% !important; width: 100% !important; }
            .dataTables_filter { width: 100%; margin-bottom: 12px; }
        }
    </style>
</head>
<body class="bg-light" style="font-family: 'Figtree', sans-serif;">

    <nav class="navbar navbar-expand navbar-light bg-white shadow-sm py-2 px-4 sticky-top">
        <div class="container-fluid">
            <div class="d-flex align-items-center">
                <img src="{{ asset('img/logo-yiyo.png') }}" alt="Logo La Picá de Yiyo" style="height: 45px; width: auto;" class="me-3">
                <h4 class="mb-0 fw-bold text-dark d-none d-sm-block">La Picá de Yiyo</h4>
            </div>

            <ul class="navbar-nav ms-auto align-items-center flex-row">
                <div class="bg-danger text-white rounded-circle d-flex justify-content-center align-items-center shadow-sm" style="width: 35px; height: 35px; font-weight: bold;">
                    {{ strtoupper(substr(Auth::user()->nombre ?? 'U', 0, 1)) }}
                </div>
                <span class="ms-2 fw-bold text-dark text-capitalize d-none d-md-block me-3">
                    {{ Auth::user()->nombre ?? 'Usuario' }} ({{ ucfirst($rol) }})
                </span>
                <div class="vr mx-2 text-muted" style="height: 30px;"></div>
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-link text-danger fw-bold text-decoration-none py-1"><i class="bi bi-box-arrow-right"></i> Salir</button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>

    @if($rol == 'garzon')
    <main class="container-fluid py-4 px-4">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-header bg-white pt-3">
                <h4 class="fw-bold mb-0"><i class="bi bi-person-badge text-primary me-2"></i> Pedidos para Garzón</h4>
            </div>
            <div class="card-body p-4">
                <table id="tablaGarzon" class="table table-striped table-hover align-middle text-nowrap" style="width: 100%;">
                    <thead class="table-dark">
                        <tr>
                            <th class="d-none d-md-table-cell">Código de Barras</th>
                            <th>Nombre</th>
                            <th>Stock</th>
                            <th class="d-none d-md-table-cell">Fecha de Vencimiento</th>
                            <th class="text-center">Cantidad a Retirar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($productos as $producto)
                        <tr>
                            <td class="fw-semibold d-none d-md-table-cell">{{ $producto->codigo_barras }}</td>
                            <td class="col-nombre">{{ $producto->nombre }}</td>
                            <td>
                                <span class="badge {{ $producto->stock <= 10 ? 'bg-danger' : ($producto->stock <= 20 ? 'bg-warning text-dark' : 'bg-success') }} rounded-pill col-stock" data-stock-max="{{ $producto->stock }}">
                                    {{ $producto->stock }}
                                </span>
                            </td>
                            <td class="d-none d-md-table-cell">{{ $producto->fecha_vencimiento ? \Carbon\Carbon::parse($producto->fecha_vencimiento)->format('d/m/Y') : 'Sin fecha' }}</td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    <div class="input-group input-group-sm shadow-sm rounded" style="width: 120px;">
                                        <button class="btn btn-outline-danger btn-restar" type="button"><i class="bi bi-dash-lg"></i></button>
                                        <input type="text" class="form-control text-center fw-bold input-cantidad" data-id="{{ $producto->id }}" value="0" readonly>
                                        <button class="btn btn-outline-success btn-sumar" type="button"><i class="bi bi-plus-lg"></i></button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    @endif

    @if($rol == 'cocina')
    <main class="container-fluid py-4 px-4">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-header bg-white pt-3">
                <h4 class="fw-bold mb-0"><i class="bi bi-fire text-danger me-2"></i> Pedidos para Cocina</h4>
            </div>
            <div class="card-body p-4">
                <table id="tablaCocina" class="table table-striped table-hover align-middle text-nowrap" style="width: 100%;">
                    <thead class="table-dark">
                        <tr>
                            <th class="d-none d-md-table-cell">Código de Barras</th>
                            <th>Nombre</th>
                            <th>Stock</th>
                            <th class="d-none d-md-table-cell">Fecha de Vencimiento</th>
                            <th class="text-center">Cantidad a Retirar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($productos as $producto)
                        <tr>
                            <td class="fw-semibold d-none d-md-table-cell">{{ $producto->codigo_barras }}</td>
                            <td class="col-nombre">{{ $producto->nombre }}</td>
                            <td>
                                <span class="badge {{ $producto->stock <= 10 ? 'bg-danger' : ($producto->stock <= 20 ? 'bg-warning text-dark' : 'bg-success') }} rounded-pill col-stock" data-stock-max="{{ $producto->stock }}">
                                    {{ $producto->stock }}
                                </span>
                            </td>
                            <td class="d-none d-md-table-cell">{{ $producto->fecha_vencimiento ? \Carbon\Carbon::parse($producto->fecha_vencimiento)->format('d/m/Y') : 'Sin fecha' }}</td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    <div class="input-group input-group-sm shadow-sm rounded" style="width: 120px;">
                                        <button class="btn btn-outline-danger btn-restar" type="button"><i class="bi bi-dash-lg"></i></button>
                                        <input type="text" class="form-control text-center fw-bold input-cantidad" data-id="{{ $producto->id }}" value="0" readonly>
                                        <button class="btn btn-outline-success btn-sumar" type="button"><i class="bi bi-plus-lg"></i></button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    @endif

    <div class="modal fade" id="modalConfirmarPedido" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-primary text-white border-0">
                    <h5 class="modal-title fw-bold"><i class="bi bi-cart-check me-2"></i> Resumen de Retiro</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="text-muted mb-3">Se descontarán los siguientes productos del inventario:</p>
                    <ul class="list-group list-group-flush border rounded-3" id="listaResumenPedido"></ul>
                </div>
                <div class="modal-footer border-0 bg-light">
                    <button type="button" class="btn btn-secondary fw-bold" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-success fw-bold" id="btnEnviarPedidoFinal">Confirmar y Descontar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            // Detectar cuál es la tabla activa según el rol cargado
            let selectorTabla = $('#tablaGarzon').length ? '#tablaGarzon' : '#tablaCocina';
            
            let tabla = $(selectorTabla).DataTable({
                scrollX: true,
                language: { url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json' },
                columnDefs: [ { targets: 4, orderable: false, searchable: false } ],
                initComplete: function() {
                    let api = this.api(); 
                    let contenedorBuscador = $('.dataTables_filter').empty(); 
                    let buscadorHTML = `
                        <div class="input-group input-group-sm mb-0 ms-md-auto buscador-responsivo">
                            <span class="input-group-text bg-white text-muted border-end-0"><i class="bi bi-search"></i></span>
                            <input type="text" id="buscadorSuperior" class="form-control border-start-0 ps-0" placeholder="Buscar producto...">
                        </div>`;
                    contenedorBuscador.append(buscadorHTML);
                    $('#buscadorSuperior').on('keyup', function() { api.search(this.value).draw(); });

                    let contenedorPaginacion = $('.dataTables_paginate').parent();
                    contenedorPaginacion.addClass('d-flex flex-wrap justify-content-md-end align-items-center gap-3 mt-3 mt-md-0');
                    let botonConfirmarHTML = `
                        <button type="button" class="btn btn-success fw-bold shadow-sm px-4" id="btnAbrirModalConfirmacion">
                            Confirmar Retiro <i class="bi bi-check-circle ms-1"></i>
                        </button>`;
                    $('.dataTables_paginate').after(botonConfirmarHTML);
                }
            });

            // Botones de Sumar con tope máximo de stock preventivo
            $(selectorTabla + ' tbody').on('click', '.btn-sumar', function() {
                let input = $(this).siblings('.input-cantidad');
                let stockMaximo = parseInt($(this).closest('tr').find('.col-stock').data('stock-max'));
                let valorActual = parseInt(input.val());

                if (valorActual < stockMaximo) {
                    input.val(valorActual + 1);
                } else {
                    Swal.fire({ icon: 'warning', title: 'Stock insuficiente', text: 'No puedes retirar más de las unidades disponibles.', timer: 1500, showConfirmButton: false });
                }
            });

            // Botones de Restar
            $(selectorTabla + ' tbody').on('click', '.btn-restar', function() {
                let input = $(this).siblings('.input-cantidad');
                let valorActual = parseInt(input.val());
                if (valorActual > 0) input.val(valorActual - 1);
            });

            let arregloProductosFinal = [];

            // Abrir Modal de Resumen
            $(document).on('click', '#btnAbrirModalConfirmacion', function() {
                arregloProductosFinal = [];
                $('#listaResumenPedido').empty();

                // Recorrer todas las filas de la tabla (incluso las paginadas u ocultas)
                tabla.$('input.input-cantidad').each(function() {
                    let cantidad = parseInt($(this).val());
                    
                    if (cantidad > 0) {
                        let idProducto = $(this).data('id');
                        let nombreProducto = $(this).closest('tr').find('.col-nombre').text().trim();

                        arregloProductosFinal.push({ id: idProducto, cantidad: cantidad });

                        let diseñoLista = `
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                ${nombreProducto}
                                <span class="badge bg-primary rounded-pill px-3 py-2 fs-6 shadow-sm">x ${cantidad}</span>
                            </li>`;
                        $('#listaResumenPedido').append(diseñoLista);
                    }
                });

                if (arregloProductosFinal.length === 0) {
                    Swal.fire({ icon: 'warning', title: 'Selección vacía', text: 'Debes añadir al menos un producto para confirmar el retiro.', confirmButtonColor: '#0d6efd' });
                    return;
                }

                $('#modalConfirmarPedido').modal('show');
            });

            // Enviar Datos al Servidor mediante AJAX
            $('#btnEnviarPedidoFinal').click(function() {
                let btn = $(this);
                btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span> Procesando...');

                $.ajax({
                    url: '{{ route("pedidos.procesar") }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        productos: arregloProductosFinal 
                    },
                    success: function(response) {
                        $('#modalConfirmarPedido').modal('hide');
                        if(response.success) {
                            Swal.fire({ icon: 'success', title: '¡Retiro exitoso!', text: response.message, showConfirmButton: false, timer: 2000 })
                            .then(() => { location.reload(); });
                        } else {
                            Swal.fire('Error en transacción', response.message, 'error');
                            btn.prop('disabled', false).text('Confirmar y Descontar');
                        }
                    },
                    error: function() {
                        $('#modalConfirmarPedido').modal('hide');
                        Swal.fire('Error crítico', 'Hubo un problema de comunicación con el servidor.', 'error');
                        btn.prop('disabled', false).text('Confirmar y Descontar');
                    }
                });
            });
        });
    </script>
</body>
</html>