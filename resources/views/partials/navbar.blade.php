<nav class="navbar" id="navbar">
    <div class="container navbar-container">
        <div class="navbar-brand">
            <a href="{{ url('/') }}" class="logo-container">
                <img src="{{ asset('images/logos/logo-cpap-web-elecciones.png') }}" alt="CPAP Logo" class="logo-image-main">
            </a>
        </div>

        <button class="navbar-toggle" id="navbarToggle">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <div class="navbar-menu" id="navbarMenu">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="{{ url('/') }}" class="nav-link active">
                        <i class="fas fa-home"></i>
                        Inicio
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a href="{{ url('/#nosotros') }}" class="nav-link">
                        <i class="fas fa-users"></i>
                        Nosotros
                        <i class="fas fa-chevron-down dropdown-icon"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li>><a href="{{ route('nosotros.mision-vision') }}">Misión y Visión</a></li>
                        <li><a href="{{ route('nosotros.historia') }}">Historia</a></li>
                        <li><a href="{{ route('nosotros.consejo-directivo') }}">Consejo Directivo</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/#colegiados') }}" class="nav-link">
                        <i class="fas fa-id-card"></i>
                        Colegiados
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/#eventos') }}" class="nav-link">
                        <i class="fas fa-calendar-alt"></i>
                        Eventos
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/#noticias') }}" class="nav-link">
                        <i class="fas fa-newspaper"></i>
                        Noticias
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a href="{{ url('/#servicios') }}" class="nav-link">
                        <i class="fas fa-concierge-bell"></i>
                        Servicios
                        <i class="fas fa-chevron-down dropdown-icon"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('biblioteca') }}">Biblioteca Virtual</a></li>
                        <li><a href="{{ route('bolsa-trabajo') }}">Bolsa de Trabajo</a></li>
                        <li><a href="{{ url('/#colegiatura') }}">Colegiatura</a></li>
                        <li><a href="{{ url('/#certificaciones') }}">Certificaciones</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/#documentos') }}" class="nav-link">
                        <i class="fas fa-file-alt"></i>
                        Documentos
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/#contacto') }}" class="nav-link">
                        <i class="fas fa-envelope"></i>
                        Contacto
                    </a>
                </li>
            </ul>

            <div class="navbar-cta">
                <a href="{{ url('/#colegiatura') }}" class="btn btn-primary">
                    <i class="fas fa-user-plus"></i>
                    Colegiarme
                </a>
            </div>
        </div>
    </div>
</nav>
