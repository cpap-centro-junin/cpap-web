@extends('layouts.admin')

@section('title', 'Dashboard - Panel Administrativo')

@section('content')

{{-- Header de bienvenida --}}
<div class="dashboard-header">
    <div>
        <h1>¡Bienvenido, {{ auth()->user()->name }}!</h1>
        <p>Panel administrativo del Colegio de Antropólogos del Perú – Región Centro</p>
    </div>
    <div class="dashboard-date">
        <i class="fas fa-calendar-alt"></i>
        <span>{{ \Carbon\Carbon::now()->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}</span>
    </div>
</div>

{{-- Stats Overview principal --}}
<div class="stats-overview">
    <div class="stat-box">
        <div class="stat-icon" style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);">
            <i class="fas fa-id-card"></i>
        </div>
        <div class="stat-info">
            <h3>{{ \App\Models\Colegiado::count() }}</h3>
            <p>Total Colegiados</p>
        </div>
    </div>

    <div class="stat-box">
        <div class="stat-icon" style="background: linear-gradient(135deg, #2e7d32 0%, #1b5e20 100%);">
            <i class="fas fa-user-check"></i>
        </div>
        <div class="stat-info">
            <h3>{{ \App\Models\Colegiado::where('estado', 'activo')->count() }}</h3>
            <p>Colegiados Activos</p>
        </div>
    </div>

    <div class="stat-box">
        <div class="stat-icon" style="background: linear-gradient(135deg, var(--secondary) 0%, var(--accent) 100%);">
            <i class="fas fa-certificate"></i>
        </div>
        <div class="stat-info">
            <h3>{{ \App\Models\Habilitacion::where('activo', true)->count() }}</h3>
            <p>Habilitaciones Vigentes</p>
        </div>
    </div>

    <div class="stat-box">
        <div class="stat-icon" style="background: linear-gradient(135deg, #2e7d32 0%, #1b5e20 100%);">
            <i class="fas fa-newspaper"></i>
        </div>
        <div class="stat-info">
            <h3>{{ \App\Models\Noticia::where('activo', true)->count() }}</h3>
            <p>Noticias Publicadas</p>
        </div>
    </div>
</div>

{{-- Sección CPAP: resumen detallado de colegiados --}}
<div class="dashboard-section">
    <h2 class="section-title">
        <i class="fas fa-id-card"></i>
        Resumen del Padrón CPAP
    </h2>

    <div class="cpap-summary-grid">
        <div class="cpap-summary-card cpap-summary-total">
            <div class="cpap-summary-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="cpap-summary-body">
                <span class="cpap-summary-label">Padrón total</span>
                <strong class="cpap-summary-num">{{ \App\Models\Colegiado::count() }}</strong>
                <span class="cpap-summary-sub">colegiados registrados</span>
            </div>
        </div>

        <div class="cpap-summary-card cpap-summary-activos">
            <div class="cpap-summary-icon">
                <i class="fas fa-user-check"></i>
            </div>
            <div class="cpap-summary-body">
                <span class="cpap-summary-label">Activos</span>
                <strong class="cpap-summary-num">{{ \App\Models\Colegiado::where('estado', 'activo')->count() }}</strong>
                <span class="cpap-summary-sub">en ejercicio</span>
            </div>
        </div>

        <div class="cpap-summary-card cpap-summary-inactivos">
            <div class="cpap-summary-icon">
                <i class="fas fa-user-times"></i>
            </div>
            <div class="cpap-summary-body">
                <span class="cpap-summary-label">Inactivos</span>
                <strong class="cpap-summary-num">{{ \App\Models\Colegiado::where('estado', 'inactivo')->count() }}</strong>
                <span class="cpap-summary-sub">no habilitados</span>
            </div>
        </div>

        <div class="cpap-summary-card cpap-summary-hab">
            <div class="cpap-summary-icon">
                <i class="fas fa-certificate"></i>
            </div>
            <div class="cpap-summary-body">
                <span class="cpap-summary-label">Habilitaciones</span>
                <strong class="cpap-summary-num">{{ \App\Models\Habilitacion::count() }}</strong>
                <span class="cpap-summary-sub">documentos emitidos</span>
            </div>
        </div>
    </div>
</div>

{{-- Accesos rápidos --}}
<div class="dashboard-section">
    <h2 class="section-title">
        <i class="fas fa-grip-horizontal"></i>
        Accesos Rápidos
    </h2>

    <div class="cards">
        <a href="{{ route('admin.colegiados.index') }}" class="card card-featured">
            <div class="card-icon" style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);">
                <i class="fas fa-id-card"></i>
            </div>
            <div class="card-content">
                <strong>Gestión de Colegiados</strong>
                <p>Administrar el padrón de colegiados y habilitaciones</p>
            </div>
            <div class="card-arrow">
                <i class="fas fa-arrow-right"></i>
            </div>
        </a>

        <a href="{{ route('admin.noticias.index') }}" class="card card-featured">
            <div class="card-icon">
                <i class="fas fa-newspaper"></i>
            </div>
            <div class="card-content">
                <strong>Gestión de Noticias</strong>
                <p>Crear, editar y publicar noticias institucionales</p>
            </div>
            <div class="card-arrow">
                <i class="fas fa-arrow-right"></i>
            </div>
        </a>

        <a href="{{ route('admin.invitaciones') }}" class="card">
            <div class="card-icon" style="background: linear-gradient(135deg, #e65100 0%, #d84315 100%);">
                <i class="fas fa-envelope-open-text"></i>
            </div>
            <div class="card-content">
                <strong>Invitaciones</strong>
                <p>Enviar invitaciones para nuevos usuarios</p>
            </div>
            <div class="card-arrow">
                <i class="fas fa-arrow-right"></i>
            </div>
        </a>

        <a href="{{ route('admin.directivos') }}" class="card">
            <div class="card-icon" style="background: linear-gradient(135deg, #8B1538 0%, #6B0F2A 100%);">
                <i class="fas fa-user-tie"></i>
            </div>
            <div class="card-content">
                <strong>Directivos</strong>
                <p>Gestionar miembros del consejo</p>
            </div>
            <div class="card-arrow">
                <i class="fas fa-arrow-right"></i>
            </div>
        </a>

        <a href="{{ route('admin.usuarios') }}" class="card">
            <div class="card-icon" style="background: linear-gradient(135deg, #1565c0 0%, #0d47a1 100%);">
                <i class="fas fa-users-cog"></i>
            </div>
            <div class="card-content">
                <strong>Usuarios</strong>
                <p>Administrar cuentas de usuario</p>
            </div>
            <div class="card-arrow">
                <i class="fas fa-arrow-right"></i>
            </div>
        </a>

        <a href="{{ route('admin.documentos') }}" class="card">
            <div class="card-icon" style="background: linear-gradient(135deg, #2e7d32 0%, #1b5e20 100%);">
                <i class="fas fa-file-pdf"></i>
            </div>
            <div class="card-content">
                <strong>Documentos</strong>
                <p>Gestionar documentación oficial</p>
            </div>
            <div class="card-arrow">
                <i class="fas fa-arrow-right"></i>
            </div>
        </a>
    </div>
</div>

{{-- Actividad Reciente --}}
<div class="dashboard-section">
    <h2 class="section-title">
        <i class="fas fa-clock"></i>
        Actividad Reciente
    </h2>

    <div class="dashboard-activity-grid">

        {{-- Últimos colegiados --}}
        <div class="activity-panel">
            <div class="activity-panel-header">
                <span><i class="fas fa-id-card"></i> Últimos Colegiados</span>
                <a href="{{ route('admin.colegiados.index') }}" class="activity-panel-link">
                    Ver todos <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <div class="activity-cards">
                @php $recentColegiados = \App\Models\Colegiado::latest()->take(3)->get(); @endphp
                @forelse($recentColegiados as $colegiado)
                    <div class="activity-card">
                        <div class="activity-icon">
                            @if($colegiado->foto)
                                <img src="{{ asset($colegiado->foto) }}" alt="{{ $colegiado->nombre_completo }}" class="activity-avatar">
                            @else
                                <span class="activity-initials">{{ strtoupper(substr($colegiado->nombres, 0, 1) . substr($colegiado->apellidos, 0, 1)) }}</span>
                            @endif
                        </div>
                        <div class="activity-info">
                            <h4>{{ $colegiado->nombre_completo }}</h4>
                            <p>
                                <i class="fas fa-hashtag"></i>
                                {{ $colegiado->codigo_cpap }}
                                &nbsp;·&nbsp;
                                <i class="fas fa-calendar"></i>
                                {{ $colegiado->created_at->diffForHumans() }}
                            </p>
                        </div>
                        <span class="activity-badge {{ $colegiado->estado === 'activo' ? 'activity-badge--activo' : 'activity-badge--inactivo' }}">
                            {{ ucfirst($colegiado->estado) }}
                        </span>
                    </div>
                @empty
                    <div class="activity-empty">
                        <i class="fas fa-id-card"></i>
                        <p>Sin colegiados aún</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Últimas noticias --}}
        <div class="activity-panel">
            <div class="activity-panel-header">
                <span><i class="fas fa-newspaper"></i> Últimas Noticias</span>
                <a href="{{ route('admin.noticias.index') }}" class="activity-panel-link">
                    Ver todas <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <div class="activity-cards">
                @php $recentNews = \App\Models\Noticia::latest()->take(3)->get(); @endphp
                @forelse($recentNews as $noticia)
                    <div class="activity-card">
                        <div class="activity-icon">
                            <i class="fas fa-newspaper"></i>
                        </div>
                        <div class="activity-info">
                            <h4>{{ Str::limit($noticia->titulo, 50) }}</h4>
                            <p>
                                <i class="fas fa-calendar"></i>
                                {{ $noticia->created_at->diffForHumans() }}
                            </p>
                        </div>
                        <span class="activity-badge {{ $noticia->activo ? 'activity-badge--activo' : 'activity-badge--inactivo' }}">
                            {{ $noticia->activo ? 'Activa' : 'Oculta' }}
                        </span>
                    </div>
                @empty
                    <div class="activity-empty">
                        <i class="fas fa-newspaper"></i>
                        <p>Sin noticias aún</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</div>

{{-- Acciones rápidas flotantes --}}
<div class="quick-actions">
    <a href="{{ route('admin.colegiados.create') }}" class="action-btn primary">
        <i class="fas fa-id-card"></i>
        <span>Nuevo Colegiado</span>
    </a>
    <a href="{{ route('admin.noticias.create') }}" class="action-btn secondary">
        <i class="fas fa-plus-circle"></i>
        <span>Nueva Noticia</span>
    </a>
</div>

@endsection
