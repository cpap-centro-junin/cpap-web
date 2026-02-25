<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Panel Administrativo CPAP</title>

    <!-- Favicon -->
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logos/cpap-logo.jpg') }}">

    <!-- Fonts (mismas que el sitio público) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @vite(['resources/css/admin.css'])
    @stack('styles')

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>

<body class="admin-layout">

<div class="admin-wrapper">

    <!-- SIDEBAR MEJORADO -->
    <aside class="sidebar" id="adminSidebar">

        <div class="sidebar-header">
            <div class="logo-box">
                <img src="{{ asset('images/logos/cpap-logo.jpg') }}" alt="CPAP Logo" class="logo">
            </div>
            <div class="logo-text">
                <h3>CPAP Centro</h3>
                <p>Panel Administrativo</p>
            </div>
        </div>

        <nav class="menu">
            {{-- Dashboard --}}
            <a href="{{ route('admin.dashboard') }}" class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i>
                <span class="menu-text">Dashboard</span>
            </a>

            {{-- GESTIÓN DE INICIO --}}
            <div class="menu-separator">
                <span>Gestión de Inicio</span>
            </div>
            <a href="{{ route('admin.inicio.index') }}" class="menu-item {{ request()->routeIs('admin.inicio*') ? 'active' : '' }}">
                <i class="fas fa-sliders-h"></i>
                <span class="menu-text">Configurar Home</span>
            </a>

            {{-- GESTIÓN CPAP --}}
            <div class="menu-separator">
                <span>Gestión CPAP</span>
            </div>
            <a href="{{ route('admin.directivos.index') }}" class="menu-item {{ request()->routeIs('admin.directivos*') ? 'active' : '' }}">
                <i class="fas fa-user-tie"></i>
                <span class="menu-text">Directivos</span>
            </a>
            <a href="{{ route('admin.colegiados.index') }}" class="menu-item {{ request()->routeIs('admin.colegiados*') || request()->routeIs('admin.habilitaciones*') ? 'active' : '' }}">
                <i class="fas fa-id-card"></i>
                <span class="menu-text">Colegiados</span>
            </a>

            {{-- CONTENIDO --}}
            <div class="menu-separator">
                <span>Contenido</span>
            </div>
            <a href="{{ route('admin.noticias.index') }}" class="menu-item {{ request()->routeIs('admin.noticias*') ? 'active' : '' }}">
                <i class="fas fa-newspaper"></i>
                <span class="menu-text">Noticias</span>
            </a>
            <a href="{{ route('admin.eventos.index') }}" class="menu-item {{ request()->routeIs('admin.eventos*') ? 'active' : '' }}">
                <i class="fas fa-calendar-alt"></i>
                <span class="menu-text">Eventos</span>
            </a>

            {{-- RECURSOS --}}
            <div class="menu-separator">
                <span>Recursos</span>
            </div>
            <a href="{{ route('admin.biblioteca.index') }}" class="menu-item {{ request()->routeIs('admin.biblioteca*') ? 'active' : '' }}">
                <i class="fas fa-book"></i>
                <span class="menu-text">Biblioteca</span>
            </a>
            @php
                $unreadMessages = \App\Models\ContactMessage::where('leido', false)->count();
                $pendingSolicitudes = \App\Models\BolsaTrabajo::noRevisadas()->count();
            @endphp
            <a href="{{ route('admin.bolsa.index') }}" class="menu-item {{ request()->routeIs('admin.bolsa*') || request()->routeIs('admin.solicitudes*') ? 'active' : '' }}">
                <i class="fas fa-briefcase"></i>
                <span class="menu-text">
                    Bolsa de Trabajo
                    @if($pendingSolicitudes > 0)
                        <span class="badge-mensajes">
                            {{ $pendingSolicitudes }}
                        </span>
                    @endif
                </span>
            </a>
            <a href="{{ route('admin.normativa.index') }}" class="menu-item {{ request()->routeIs('admin.normativa*') ? 'active' : '' }}">
                <i class="fas fa-gavel"></i>
                <span class="menu-text">Normativa</span>
            </a>

            {{-- COMUNICACIÓN --}}
            <div class="menu-separator">
                <span>Comunicación</span>
            </div>
            <a href="{{ route('admin.mensajes.index') }}" class="menu-item {{ request()->routeIs('admin.mensajes*') ? 'active' : '' }}">
                <i class="fas fa-envelope"></i>
                <span class="menu-text">
                    Mensajes
                    @if($unreadMessages > 0)
                        <span class="badge-mensajes">
                            {{ $unreadMessages }}
                        </span>
                    @endif
                </span>
            </a>

            {{-- CONFIGURACIÓN --}}
            <div class="menu-separator">
                <span>Configuración</span>
            </div>
            <a href="{{ route('admin.invitaciones') }}" class="menu-item {{ request()->routeIs('admin.invitaciones') ? 'active' : '' }}">
                <i class="fas fa-user-plus"></i>
                <span class="menu-text">Invitaciones</span>
            </a>

        </nav>

        <div class="sidebar-footer">
            <a href="{{ url('/') }}" class="menu-item">
                <i class="fas fa-globe"></i>
                <span class="menu-text">Ver Sitio Web</span>
            </a>
        </div>

    </aside>

    <div class="overlay" id="overlay"></div>

    <!-- CONTENIDO PRINCIPAL -->
    <main class="content">

        <!-- TOPBAR MEJORADO -->
        <header class="topbar">
            <button class="toggle-sidebar" id="toggleSidebar">
                <i class="fas fa-bars"></i>
            </button>

            <div class="topbar-center">
                <span class="page-title">@yield('page-title', 'Dashboard')</span>
            </div>

            <div class="user-info">
                <div class="topbar-messages">

                    <a href="{{ route('admin.mensajes.index') }}" class="messages-icon">
                        <i class="fas fa-envelope"></i>

                        @if($unreadMessages > 0)
                            <span class="topbar-badge">
                                {{ $unreadMessages }}
                            </span>
                        @endif
                    </a>

                </div>

                <div class="user-avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>
                <span class="user-name">{{ auth()->user()->name }}</span>

                <form action="/logout" method="POST" style="display: inline;">
                    @csrf
                    <button class="logout-btn" type="submit">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Salir</span>
                    </button>
                </form>
            </div>
        </header>

        <!-- CONTENIDO DE LA PÁGINA -->
        <section class="page-content">
            @yield('content')
        </section>

    </main>

</div>

<script>
const toggleBtn  = document.getElementById('toggleSidebar');
const hamburger  = document.getElementById('hamburger');
const sidebar    = document.getElementById('adminSidebar');
const overlay    = document.getElementById('overlay');

// Desktop: colapsa/expande sidebar
// Mobile:  abre/cierra el drawer
function toggleSidebar() {
    if (window.innerWidth > 900) {
        // ── DESKTOP: colapsar / expandir ──
        sidebar.classList.toggle('collapsed');
        // Guardar preferencia en localStorage
        const isCollapsed = sidebar.classList.contains('collapsed');
        localStorage.setItem('sidebar-collapsed', isCollapsed);
    } else {
        // ── MOBILE: drawer ──
        sidebar.classList.toggle('show');
        overlay.classList.toggle('show');
    }
}

function closeMobileSidebar() {
    sidebar.classList.remove('show');
    overlay.classList.remove('show');
}

// Restaurar estado guardado al cargar (solo desktop)
if (window.innerWidth > 900) {
    const savedCollapsed = localStorage.getItem('sidebar-collapsed');
    if (savedCollapsed === 'true') {
        sidebar.classList.add('collapsed');
    }
}

if (toggleBtn) toggleBtn.addEventListener('click', toggleSidebar);
if (hamburger) hamburger.addEventListener('click', toggleSidebar);
if (overlay)   overlay.addEventListener('click', closeMobileSidebar);

// Cerrar mobile drawer al hacer click en un item
document.querySelectorAll('.menu-item').forEach(item => {
    item.addEventListener('click', function() {
        if (window.innerWidth <= 900) closeMobileSidebar();
    });
});

// Limpiar estado mobile al redimensionar a desktop
window.addEventListener('resize', function() {
    if (window.innerWidth > 900) closeMobileSidebar();
});
</script>

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

@if(session('success'))
<script>
Swal.fire({
    toast: true,
    position: 'top-end',
    icon: 'success',
    title: @json(session('success')),
    showConfirmButton: false,
    timer: 4000,
    timerProgressBar: true,
    customClass: { popup: 'swal-toast-cpap' }
});
</script>
@endif

@if(session('error'))
<script>
Swal.fire({
    toast: true,
    position: 'top-end',
    icon: 'error',
    title: @json(session('error')),
    showConfirmButton: false,
    timer: 5000,
    timerProgressBar: true,
});
</script>
@endif

@stack('scripts')
</body>
</html>
