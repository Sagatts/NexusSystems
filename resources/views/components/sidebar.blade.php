<aside class="sidebar-container" id="sidebar">
    <div class="sidebar-top">
        <div class="sidebar-logo-wrapper">
            <img src="{{ asset('img/logo-yiyo.png') }}" alt="La Picá del Yiyo" class="sidebar-logo">
        </div>

        <nav class="sidebar-menu">
            
            <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" title="Inicio">
                <img src="{{ asset('img/img_sidebar/dashboard.png') }}" alt="Inicio" class="sidebar-icon">
                <span>Inicio</span>
            </a>

            <a href="{{ route('admin.productos') }}" class="sidebar-link {{ request()->routeIs('admin.productos') ? 'active' : '' }}" title="Gestión de Productos">
                <img src="{{ asset('img/img_sidebar/inventario.png') }}" alt="Productos" class="sidebar-icon">
                <span>Gestión Productos</span>
            </a>

            <a href="{{ route('admin.reportes') }}" class="sidebar-link {{ request()->routeIs('admin.reportes') ? 'active' : '' }}" title="Gestión de Reportes">
                <img src="{{ asset('img/img_sidebar/reportes.png') }}" alt="Reportes" class="sidebar-icon">
                <span>Gestión de Reportes</span>
            </a>

            <a href="{{ route('admin.usuarios') }}" class="sidebar-link {{ request()->routeIs('admin.usuarios') ? 'active' : '' }}" title="Gestión de Usuarios">
                <img src="{{ asset('img/img_sidebar/usuarios.png') }}" alt="Usuarios" class="sidebar-icon">
                <span>Gestión de Usuarios</span>
            </a>
            
        </nav>
    </div>

    <div class="sidebar-footer">
        <form method="POST" action="{{ route('logout') }}" class="m-0 p-0">
            @csrf
            <a href="{{ route('logout') }}" class="sidebar-link logout-link" title="Cerrar Sesión" onclick="event.preventDefault(); this.closest('form').submit();">
                <img src="{{ asset('img/img_sidebar/cerrarsesion.png') }}" alt="Cerrar Sesión" class="sidebar-icon">
                <span>Cerrar Sesión</span>
            </a>
        </form>
    </div>
</aside>