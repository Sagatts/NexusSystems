<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'La Picá de Yiyo')</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        
        <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
        <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    </head>
    
    <body class="font-sans antialiased bg-sistema">
    
    <div class="d-flex" style="height: 100vh; overflow: hidden;">
        
        @include('components.sidebar')

        <script>
            if (localStorage.getItem("barra_achicada") === "true") {
                document.getElementById("sidebar").classList.add("collapsed");
            }
        </script>

        <div class="d-flex flex-column flex-grow-1" style="overflow: hidden;">
            
            <nav class="navbar navbar-expand navbar-light bg-white shadow-sm py-2 px-4 border-bottom-0 flex-shrink-0">
                <div class="container-fluid">

                    <div class="d-flex align-items-center">
                        <button id="btnBurger" class="btn border-0 me-3 shadow-sm bg-light" style="width: 40px; height: 40px; display: flex; justify-content: center; align-items: center;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#333" class="bi bi-list" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
                            </svg>
                        </button>

                        <h5 class="mb-0 fw-bold text-dark">
                            {{ $header ?? 'Panel de Control' }}
                        </h5>
                    </div>

                    <ul class="navbar-nav ms-auto align-items-center flex-row">

                        <li class="nav-item me-3">
                            <a class="nav-link position-relative mt-1" href="#" role="button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#6c757d" class="bi bi-bell" viewBox="0 0 16 16">
                                    <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zM8 1.918l-.797.161A4.002 4.002 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4.002 4.002 0 0 0-3.203-3.92L8 1.917zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.252 3 8.188 3 6a5 5 0 0 1 10 0c0 2.188.32 4.252 1.22 6z"/>
                                </svg>
                                <span class="position-absolute top-25 start-75 translate-middle p-1 rounded-circle punto-notificacion">
                                    <span class="visually-hidden">Nuevas alertas</span>
                                </span>
                            </a>
                        </li>

                        <div class="vr mx-2 text-muted separador-header"></div>

                        <li class="nav-item dropdown ms-2">
                            <a class="nav-link dropdown-toggle d-flex align-items-center text-dark text-decoration-none" href="#" id="perfilDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">

                                <div class="avatar-corporativo shadow-sm" title="{{ trim(Auth::user()->nombre) }}">
                                    {{ strtoupper(substr(trim(Auth::user()->nombre), 0, 1)) }}
                                </div>
                                
                                <span class="ms-2 fw-bold text-dark text-capitalize">
                                    {{ trim(Auth::user()->rol ?? 'Usuario') }}
                                </span>
                            </a>
                            
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-3 rounded-3" aria-labelledby="perfilDropdown">
                                <li><a class="dropdown-item py-2" href="{{ route('profile.edit') }}">Mi Perfil</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger fw-bold py-2">
                                            Cerrar Sesión
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>

                </div>
            </nav>

            <main class="p-4" style="flex-grow: 1; overflow-y: auto;">
                {{ $slot }}
            </main>
            
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
    @stack('scripts')

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const btnBurger = document.getElementById("btnBurger");
            const sidebar = document.getElementById("sidebar");

            if(btnBurger && sidebar) {
                // Solo nos encargamos de escuchar el clic del botón
                btnBurger.addEventListener("click", function() {
                    sidebar.classList.toggle("collapsed");
                    
                    // Actualizamos la memoria
                    if (sidebar.classList.contains("collapsed")) {
                        localStorage.setItem("barra_achicada", "true"); 
                    } else {
                        localStorage.setItem("barra_achicada", "false"); 
                    }
                });
            }
        });
    </script>

    @if(session('success'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: 'success',
                    title: '¡Operación Exitosa!',
                    text: "{{ session('success') }}",
                    confirmButtonColor: '#198754', // Verde Bootstrap
                    timer: 2000, // Se cierra solo en 2 segundos
                    timerProgressBar: true,
                    showConfirmButton: false
                });
            });
        </script>
    @endif
</body>
</html>