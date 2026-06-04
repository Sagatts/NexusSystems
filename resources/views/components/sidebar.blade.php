<aside class="sidebar-container">
    <div class="sidebar-top">
        <div class="sidebar-logo-wrapper">
            <img src="{{ asset('img/logo-yiyo.png') }}" alt="La Picá del Yiyo" class="sidebar-logo">
        </div>

        <nav class="sidebar-menu">
            <a href="{{ route('dashboard') }}" class="sidebar-link active">
                <img src="{{ asset('img/img_sidebar/dashboard.png') }}" alt="Inicio" class="sidebar-icon">
                <span>Inicio</span>
            </a>
            
            <a href="#" class="sidebar-link">
                <img src="{{ asset('img/img_sidebar/inventario.png') }}" alt="Productos" class="sidebar-icon">
                <span>Gestión Productos</span>
            </a>
            
            <a href="#" class="sidebar-link">
                <img src="{{ asset('img/img_sidebar/reportes.png') }}" alt="Reportes" class="sidebar-icon">
                <span>Gestión de Reportes</span>
            </a>

            <a href="#" class="sidebar-link">
                <img src="{{ asset('img/img_sidebar/usuarios.png') }}" alt="Usuarios" class="sidebar-icon">
                <span>Gestión de Usuarios</span>
            </a>
        </nav>
    </div>

    <div class="sidebar-footer">
        <a href="#" class="sidebar-link logout-link">
            <img src="{{ asset('img/img_sidebar/cerrarsesion.png') }}" alt="Cerrar Sesión" class="sidebar-icon">
            <span>Cerrar Sesión</span>
        </a>
    </div>
</aside>