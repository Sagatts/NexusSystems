<aside class="sidebar-container" id="sidebar" style="position: relative; overflow: visible !important;">
    
    <button id="btnBurger" class="btn bg-white border shadow-sm rounded-circle d-flex justify-content-center align-items-center" 
            style="position: absolute; right: -16px; top: 45px; transform: translateY(-50%); width: 32px; height: 32px; z-index: 1050; padding: 0;">
        <svg id="iconoBurger" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-left" viewBox="0 0 16 16" style="transition: transform 0.3s ease;">
            <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
        </svg>
    </button>

    
    <div style="overflow: hidden; width: 100%; height: 100%; display: flex; flex-direction: column; justify-content: space-between;">
        
        <div> <!-- Agrupa la parte superior -->
            <div class="sidebar-top">
                <!-- Wrapper del logo -->
                <div class="sidebar-logo-wrapper" style="display: flex; justify-content: center; align-items: center; padding-top: 15px;">
                    <img src="{{ asset('img/logo-yiyo.png') }}" alt="La Picá del Yiyo" class="sidebar-logo">
                </div>

                <nav class="sidebar-menu mt-3">
                    <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" title="Inicio">
                        <img src="{{ asset('img/img_sidebar/dashboard.png') }}" alt="Inicio" class="sidebar-icon">
                        <span>Inicio</span>
                    </a>

                    <a href="{{ route('admin.productos.index') }}" class="sidebar-link {{ request()->routeIs('admin.productos.*') ? 'active' : '' }}" title="Gestión de Productos">
                        <img src="{{ asset('img/img_sidebar/inventario.png') }}" alt="Productos" class="sidebar-icon">
                        <span>Gestión Productos</span>
                    </a>

                    <a href="{{ route('admin.reportes.index') }}" class="sidebar-link {{ request()->routeIs('admin.reportes.*') ? 'active' : '' }}" title="Gestión de Reportes">
                        <img src="{{ asset('img/img_sidebar/reportes.png') }}" alt="Reportes" class="sidebar-icon">
                        <span>Historial de <br>Movimientos</span>
                    </a>

                    <a href="{{ route('admin.usuarios.index') }}" class="sidebar-link {{ request()->routeIs('admin.usuarios.*') ? 'active' : '' }}" title="Gestión de Usuarios">
                        <img src="{{ asset('img/img_sidebar/usuarios.png') }}" alt="Usuarios" class="sidebar-icon">
                        <span>Gestión de Usuarios</span>
                    </a>
                </nav>
            </div>
        </div>
        <div class="sidebar-footer">
            <a href="#" class="sidebar-link logout-link btn-logout" title="Cerrar Sesión">
                <img src="{{ asset('img/img_sidebar/cerrarsesion.png') }}" alt="Cerrar Sesión" class="sidebar-icon">
                <span>Cerrar Sesión</span>
            </a>
        </div>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>

    </div>
</aside>