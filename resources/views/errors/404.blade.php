@extends('layouts.app')

@section('title', 'Página No Encontrada - CPAP')
@section('seo_title', 'Página No Encontrada | CPAP Región Centro')
@section('seo_description', 'La página que buscas no existe. Descubre más contenido del Colegio de Antropólogos del Perú.')
@section('seo_robots', 'noindex,nofollow')

@section('content')

<style>
    .error-container {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 40px 20px;
        text-align: center;
        background: linear-gradient(135deg, rgba(139, 21, 56, 0.03) 0%, rgba(180, 98, 39, 0.03) 100%);
    }

    .error-content {
        max-width: 600px;
        animation: slideUp 0.6s ease-out;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .error-code {
        font-size: 120px;
        font-weight: 900;
        color: var(--primary, #8B1438);
        margin: 0;
        line-height: 1;
        text-shadow: 2px 2px 4px rgba(139, 21, 56, 0.1);
    }

    .error-title {
        font-size: 32px;
        font-weight: 700;
        color: var(--dark, #1a1a1a);
        margin: 20px 0 16px;
    }

    .error-message {
        font-size: 16px;
        color: var(--medium-gray, #666);
        line-height: 1.6;
        margin-bottom: 30px;
    }

    .error-icon {
        font-size: 80px;
        margin-bottom: 20px;
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% {
            transform: translateY(0px);
        }
        50% {
            transform: translateY(-20px);
        }
    }

    .error-actions {
        display: flex;
        gap: 16px;
        flex-wrap: wrap;
        justify-content: center;
        margin-bottom: 50px;
    }

    .error-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 28px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }

    .error-btn-primary {
        background: var(--primary, #8B1438);
        color: white;
    }

    .error-btn-primary:hover {
        background: var(--primary-dark, #6a0f2a);
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(139, 21, 56, 0.2);
    }

    .error-btn-secondary {
        background: var(--light-gray, #f5f5f5);
        color: var(--dark, #1a1a1a);
        border: 1px solid var(--border, #ddd);
    }

    .error-btn-secondary:hover {
        background: var(--border, #ddd);
        transform: translateY(-2px);
    }

    .error-suggestions {
        background: white;
        border-radius: 12px;
        padding: 30px;
        border: 1px solid var(--border, #ddd);
        text-align: left;
        margin-top: 40px;
    }

    .error-suggestions-title {
        font-size: 16px;
        font-weight: 700;
        color: var(--dark, #1a1a1a);
        margin: 0 0 20px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .suggestion-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .suggestion-item {
        padding: 12px 0;
        border-bottom: 1px solid var(--light-gray, #f5f5f5);
    }

    .suggestion-item:last-child {
        border-bottom: none;
    }

    .suggestion-link {
        color: var(--primary, #8B1438);
        text-decoration: none;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
    }

    .suggestion-link:hover {
        gap: 12px;
    }

    .suggestion-text {
        font-size: 13px;
        color: var(--medium-gray, #666);
        margin-top: 4px;
    }

    @media (max-width: 768px) {
        .error-code {
            font-size: 80px;
        }

        .error-title {
            font-size: 24px;
        }

        .error-icon {
            font-size: 60px;
        }

        .error-actions {
            flex-direction: column;
        }

        .error-btn {
            width: 100%;
            justify-content: center;
        }

        .error-suggestions {
            padding: 20px;
        }
    }
</style>

<div class="error-container">
    <div class="error-content">
        <div class="error-icon">
            <i class="fas fa-compass"></i>
        </div>

        <h1 class="error-code">404</h1>
        <h2 class="error-title">Página No Encontrada</h2>
        <p class="error-message">
            Parece que te has perdido. La página que buscas no existe o ha sido movida a otra ubicación.
        </p>

        <div class="error-actions">
            <a href="{{ url('/') }}" class="error-btn error-btn-primary">
                <i class="fas fa-home"></i>
                Volver a Inicio
            </a>
            <button class="error-btn error-btn-secondary" onclick="window.history.back();">
                <i class="fas fa-arrow-left"></i>
                Página Anterior
            </button>
        </div>

        <div class="error-suggestions">
            <h3 class="error-suggestions-title">
                <i class="fas fa-lightbulb" style="color: var(--accent, #B46227);"></i>
                Explorar el Sitio
            </h3>
            <ul class="suggestion-list">
                <li class="suggestion-item">
                    <a href="{{ route('noticias.index') }}" class="suggestion-link">
                        <i class="fas fa-newspaper"></i>
                        Noticias
                    </a>
                    <div class="suggestion-text">Últimas noticias y actualizaciones del colegio</div>
                </li>
                <li class="suggestion-item">
                    <a href="{{ route('eventos.index') }}" class="suggestion-link">
                        <i class="fas fa-calendar-alt"></i>
                        Eventos
                    </a>
                    <div class="suggestion-text">Actividades académicas y espacios profesionales</div>
                </li>
                <li class="suggestion-item">
                    <a href="{{ route('colegiados.index') }}" class="suggestion-link">
                        <i class="fas fa-users"></i>
                        Directorio de Colegiados
                    </a>
                    <div class="suggestion-text">Encuentra otros profesionales colegiados</div>
                </li>
                <li class="suggestion-item">
                    <a href="{{ route('colegiatura.index') }}" class="suggestion-link">
                        <i class="fas fa-certificate"></i>
                        Proceso de Colegiatura
                    </a>
                    <div class="suggestion-text">Información sobre colegiación y habilitación profesional</div>
                </li>
                <li class="suggestion-item">
                    <a href="{{ route('biblioteca') }}" class="suggestion-link">
                        <i class="fas fa-book"></i>
                        Biblioteca Virtual
                    </a>
                    <div class="suggestion-text">Accede a materiales académicos y recursos</div>
                </li>
                <li class="suggestion-item">
                    <a href="{{ route('bolsa-trabajo') }}" class="suggestion-link">
                        <i class="fas fa-briefcase"></i>
                        Bolsa de Trabajo
                    </a>
                    <div class="suggestion-text">Oportunidades laborales y profesionales</div>
                </li>
            </ul>
        </div>
    </div>
</div>

@endsection
