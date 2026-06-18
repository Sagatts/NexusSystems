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

    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    
    <style>
        /* Muro de contención para DataTables en celulares */
        .dataTables_wrapper { max-width: 100%; overflow-x: hidden; }
        .dataTables_scrollBody { overflow-x: auto !important; width: 100% !important; }
        
        /* Ocultar el buscador por defecto de DataTables porque usaremos el nuestro en la cabecera */
        .dataTables_filter { display: none !important; }

        /* Estilo para que el input del medio no se pueda modificar escribiendo letras */
        .input-cantidad { background-color: white !important; cursor: default; }
    </style>
</head>
<body class="bg-light" style="font-family: 'Figtree', sans-serif;">

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

    <main class="container-fluid py-4 px-4">
        
        @if($rol == 'garzon')
            
            <div class="card shadow-sm border-0 rounded-4">
                
                <div class="card-header bg-white d-flex flex-column flex-md-row justify-content-between align-items-md-center pt-3 pb-3">
                    <h4 class="fw-bold mb-3 mb-md-0">
                        <i class="bi bi-person-badge text-primary me-2"></i> Pedidos para Garzón
                    </h4>
                    
                    <div class="input-group" style="max-width: 300px;">
                        <span class="input-group-text bg-white text-muted border-end-0">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" id="buscadorGarzon" class="form-control border-start-0 ps-0" placeholder="Buscar producto...">
                    </div>
                </div>

                <div class="card-body p-4">
                    <table id="tablaGarzon" class="table table-striped table-hover align-middle text-nowrap" style="width: 100%;">
                        <thead class="table-dark">
                            <tr>
                                <th>Código de Barras</th>
                                <th>Nombre</th>
                                <th>Stock</th>
                                <th>Fecha de Vencimiento</th>
                                <th class="text-center">Cantidad a Retirar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($productos as $producto)
                            <tr>
                                <td class="fw-semibold">{{ $producto->codigo_barras }}</td>
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
                                
                                <td>
                                    {{ $producto->fecha_vencimiento ? \Carbon\Carbon::parse($producto->fecha_vencimiento)->format('d/m/Y') : 'Sin fecha' }}
                                </td>
                                
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <div class="input-group input-group-sm shadow-sm rounded" style="width: 120px;">
                                            <button class="btn btn-outline-danger btn-restar" type="button">
                                                <i class="bi bi-dash-lg"></i>
                                            </button>
                                            
                                            <input type="text" class="form-control text-center fw-bold input-cantidad" value="0" readonly>
                                            
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

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            
            // 1. Inicializamos DataTables
            let tabla = $('#tablaGarzon').DataTable({
                scrollX: true,
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
                },
                columnDefs: [
                    // Evita que se pueda ordenar la tabla usando la columna de los botones
                    { targets: 4, orderable: false, searchable: false } 
                ]
            });

            // 2. Conectamos nuestro buscador personalizado con DataTables
            $('#buscadorGarzon').on('keyup', function() {
                tabla.search(this.value).draw();
            });

            // 3. Lógica para los botones de Sumar (+)
            $('#tablaGarzon tbody').on('click', '.btn-sumar', function() {
                let input = $(this).siblings('.input-cantidad');
                let valorActual = parseInt(input.val());
                // Puedes agregar lógica aquí para no superar el "Stock" máximo si lo deseas
                input.val(valorActual + 1);
            });

            // 4. Lógica para los botones de Restar (-)
            $('#tablaGarzon tbody').on('click', '.btn-restar', function() {
                let input = $(this).siblings('.input-cantidad');
                let valorActual = parseInt(input.val());
                if (valorActual > 0) { // Evita números negativos
                    input.val(valorActual - 1);
                }
            });

        });
    </script>
</body>
</html>