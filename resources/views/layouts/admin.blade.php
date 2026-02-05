<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') - Panel Administrativo</title>

    @vite(['resources/css/admin.css'])
</head>

<body>

<div class="admin-wrapper">

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <img src="{{ asset('images/logos/cpap-logo.jpg') }}" class="logo">
            <h3>CPAP</h3>
            <p>Colegio de Antropólogos</p>
        </div>

        <nav class="menu">
            <a href="{{ route('admin.dashboard') }}" class="menu-item">🏠 Dashboard</a>
            <a href="{{ route('admin.directivos') }}" class="menu-item">👥 Directivos</a>
            <a href="{{ route('admin.invitaciones') }}" class="menu-item">✉️ Invitaciones</a>
            <a href="{{ route('admin.usuarios') }}" class="menu-item">🧑‍💼 Usuarios</a>
            <a href="{{ route('admin.contenido') }}" class="menu-item">📰 Contenido</a>
            <a href="{{ route('admin.eventos') }}" class="menu-item">📅 Eventos</a>
            <a href="{{ route('admin.documentos') }}" class="menu-item">📄 Documentos</a>
        </nav>
    </aside>

    <!-- Contenido -->
    <main class="content">

        <header class="topbar">
            <div class="user-info">
                <span>{{ auth()->user()->name }}</span>
                <form action="/logout" method="POST">
                    @csrf
                    <button class="logout-btn">Salir</button>
                </form>
            </div>
        </header>

        <section class="page-content">
            @yield('content')
        </section>

    </main>

</div>

</body>
</html>
