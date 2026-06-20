<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>La Picá de Yiyo - Operaciones</title>

    <!-- Bootstrap, Iconos y DataTables CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
    <link rel="icon" href="{{ asset('img/logo-yiyo.png') }}" type="image/png">

    <!-- Estilos base -->
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    
    <style>
        /* Muro de contención para DataTables en celulares */
        .dataTables_wrapper { max-width: 100%; overflow-x: hidden; }
        .dataTables_scrollBody { overflow-x: auto !important; width: 100% !important; }

        /* Estilo para que el input del medio no se pueda modificar escribiendo letras */
        .input-cantidad { background-color: white !important; cursor: default; }

        /* Alineación perfecta para los textos inferiores generados por DataTables */
        .dataTables_info { padding-top: 0 !important; margin-bottom: 0 !important; }

        /* Estilos responsivos para el buscador */
        .buscador-responsivo { max-width: 250px; }
        
        @media (max-width: 767px) {
            .buscador-responsivo { 
                max-width: 100% !important; 
                width: 100% !important; 
            }
            .dataTables_filter { 
                width: 100%; 
                margin-bottom: 12px; 
            }
        }
    </style>
</head>
<body class="bg-light" style="font-family: 'Figtree', sans-serif;">

    <!-- ==========================================
         HEADER
    =========================================== -->
    <nav class="navbar navbar-expand navbar-light bg-white shadow-sm py-2 px-4 border-bottom-0 sticky-top">
        <div class="container-fluid">
            
            <div class="d-flex align-items-center">
                <img src="{{ asset('img/logo-yiyo.png') }}" alt="Logo La Picá de Yiyo" style="height: 45px; width: auto;" class="me-3">
                <h4 class="mb-0 fw-bold text-dark d-none d-sm-block">La Picá de Yiyo</h4>
            </div>

            <ul class="navbar-nav ms-auto align-items-center flex-row">
                <li class="nav-item me-3">
                    <a class="nav-link position-relative mt-1" href="#" role="button">
                        <i class="bi bi-bell fs-5 text-secondary"></i>
                        <span class="position-absolute top-25 start-75 translate-middle p-1 bg-danger rounded-circle">
                            <span class="visually-hidden">Nuevas alertas</span>
                        </span>
                    </a>
                </li>

                <div class="vr mx-2 text-muted" style="height: 30px;"></div>

                <li class="nav-item dropdown ms-2">
                    <a class="nav-link dropdown-toggle d-flex align-items-center text-dark text-decoration-none" href="#" id="perfilDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="bg-danger text-white rounded-circle d-flex justify-content-center align-items-center shadow-sm" style="width: 35px; height: 35px; font-weight: bold;">
                            {{ strtoupper(substr(Auth::user()->nombre ?? 'U', 0, 1)) }}
                        </div>
                        <span class="ms-2 fw-bold text-dark text-capitalize d-none d-md-block">
                            {{ Auth::user()->nombre ?? 'Usuario' }}
                        </span>
                    </a>
                    
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-3 rounded-3" aria-labelledby="perfilDropdown">
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger fw-bold py-2">
                                    <i class="bi bi-box-arrow-right me-2"></i> Cerrar Sesión
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

    <!-- ==========================================
         CONTENIDO PRINCIPAL GARZON
    =========================================== -->
    <main class="container-fluid py-4 px-4">
        
        @if($rol == 'garzon')
            
            <div class="card shadow-sm border-0 rounded-4">
                
                <div class="card-header bg-white pt-3">
                    <h4 class="fw-bold mb-0">
                        <i class="bi bi-person-badge text-primary me-2"></i> Pedidos para Garzón
                    </h4>
                </div>

                <div class="card-body p-4">
                    <table id="tablaGarzon" class="table table-striped table-hover align-middle text-nowrap" style="width: 100%;">
                        <thead class="table-dark">
                            <tr>
                                <th class="d-none d-md-table-cell">Código de Barras</th> <!--Se oculta en celular -->
                                <th>Nombre</th>
                                <th>Stock</th>
                                <th class="d-none d-md-table-cell">Fecha de Vencimiento</th> <!--Se oculta en celular -->
                                <th class="text-center">Cantidad a Retirar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($productos as $producto)
                            <tr>
                                <td class="fw-semibold d-none d-md-table-cell">{{ $producto->codigo_barras }}</td> <!--Se oculta en celular -->
                                <td>{{ $producto->nombre }}</td>
                                
                                <td>
                                    @if($producto->stock <= 10)
                                        <span class="badge bg-danger rounded-pill">{{ $producto->stock }}</span>
                                    @elseif($producto->stock <= 20)
                                        <span class="badge bg-warning text-dark rounded-pill">{{ $producto->stock }}</span>
                                    @else
                                        <span class="badge bg-success rounded-pill">{{ $producto->stock }}</span>
                                    @endif
                                </td>
                                
                                <td class="d-none d-md-table-cell">  <!--Se oculta en celular -->
                                    {{ $producto->fecha_vencimiento ? \Carbon\Carbon::parse($producto->fecha_vencimiento)->format('d/m/Y') : 'Sin fecha' }}
                                </td>
                                
                                <td>
                                    <!-- BOTONES + Y - -->
                                    <div class="d-flex justify-content-center">
                                        <div class="input-group input-group-sm shadow-sm rounded" style="width: 120px;">
                                            <button class="btn btn-outline-danger btn-restar" type="button">
                                                <i class="bi bi-dash-lg"></i>
                                            </button>
                                            
                                            <input type="text" class="form-control text-center fw-bold input-cantidad" data-id="{{ $producto->id }}" value="0" readonly>
                                            
                                            <button class="btn btn-outline-success btn-sumar" type="button">
                                                <i class="bi bi-plus-lg"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
            
        @endif

    </main>

    <!-- ==========================================
         CONTENIDO PRINCIPAL COCINA
    =========================================== -->

    <main class="container-fluid py-4 px-4">
        
        @if($rol == 'cocina')
            
            <div class="card shadow-sm border-0 rounded-4">
                
                <div class="card-header bg-white pt-3">
                    <h4 class="fw-bold mb-0">
                        <i class="bi bi-person-badge text-primary me-2"></i> Pedidos para Cocina
                    </h4>
                </div>

                <div class="card-body p-4">
                    <table id="tablaGarzon" class="table table-striped table-hover align-middle text-nowrap" style="width: 100%;">
                        <thead class="table-dark">
                            <tr>
                                <th class="d-none d-md-table-cell">Código de Barras</th> <!--Se oculta en celular -->
                                <th>Nombre</th>
                                <th>Stock</th>
                                <th  class="d-none d-md-table-cell">Fecha de Vencimiento</th>  <!--Se oculta en celular -->
                                <th class="text-center">Cantidad a Retirar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($productos as $producto)
                            <tr>
                                <td class="fw-semibold d-none d-md-table-cell">{{ $producto->codigo_barras }}</td>
                                <td>{{ $producto->nombre }}</td>
                                
                                <td>
                                    @if($producto->stock <= 10)
                                        <span class="badge bg-danger rounded-pill">{{ $producto->stock }}</span>
                                    @elseif($producto->stock <= 20)
                                        <span class="badge bg-warning text-dark rounded-pill">{{ $producto->stock }}</span>
                                    @else
                                        <span class="badge bg-success rounded-pill">{{ $producto->stock }}</span>
                                    @endif
                                </td>
                                
                                <td class="d-none d-md-table-cell"> <!--Se oculta en celular -->
                                    {{ $producto->fecha_vencimiento ? \Carbon\Carbon::parse($producto->fecha_vencimiento)->format('d/m/Y') : 'Sin fecha' }}
                                </td>
                                
                                <td>
                                    <!-- BOTONES + Y - -->
                                    <div class="d-flex justify-content-center">
                                        <div class="input-group input-group-sm shadow-sm rounded" style="width: 120px;">
                                            <button class="btn btn-outline-danger btn-restar" type="button">
                                                <i class="bi bi-dash-lg"></i>
                                            </button>
                                            
                                            <input type="text" class="form-control text-center fw-bold input-cantidad" data-id="{{ $producto->id }}" value="0" readonly>
                                            
                                            <button class="btn btn-outline-success btn-sumar" type="button">
                                                <i class="bi bi-plus-lg"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
            
        @endif

    </main>

    <div class="modal fade" id="modalConfirmarPedido" tabindex="-1" aria-labelledby="modalConfirmarPedidoLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-primary text-white border-0">
                    <h5 class="modal-title fw-bold" id="modalConfirmarPedidoLabel">
                        <i class="bi bi-cart-check me-2"></i> Resumen de Retiro
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="text-muted mb-3">Se descontarán los siguientes productos del inventario:</p>
                    
                    <ul class="list-group list-group-flush mb-0 border rounded-3" id="listaResumenPedido">
                    </ul>
                </div>
                <div class="modal-footer border-0 bg-light">
                    <button type="button" class="btn btn-secondary fw-bold shadow-sm" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-success fw-bold shadow-sm" id="btnEnviarPedidoFinal">
                        Confirmar y Descontar
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            
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
                        <div class="input-group input-group-sm mb-0 ms-md-auto buscador-responsivo">
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

            // 2. Botones de Sumar y Restar
            $('#tablaGarzon tbody').on('click', '.btn-sumar', function() {
                let input = $(this).siblings('.input-cantidad');
                input.val(parseInt(input.val()) + 1);
            });

            $('#tablaGarzon tbody').on('click', '.btn-restar', function() {
                let input = $(this).siblings('.input-cantidad');
                let valorActual = parseInt(input.val());
                if (valorActual > 0) input.val(valorActual - 1);
            });

            // ==========================================
            // LÓGICA DEL PEDIDO (MODAL Y BASE DE DATOS)
            // ==========================================

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

                // Si no seleccionó nada, lanzamos alerta de error
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
                    url: '{{ route("pedidos.procesar") }}', // La ruta en web.php
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}', // Llave de seguridad obligatoria en Laravel
                        productos: arregloProductosFinal 
                    },
                    success: function(response) {
                        $('#modalConfirmarPedido').modal('hide');
                        
                        if(response.success) {
                            // Alerta de éxito y recargamos la página para ver el nuevo stock
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

        });
    </script>
</body>
</html>