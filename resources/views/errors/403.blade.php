@extends('layouts.app')

@section('title', 'Acceso Prohibido - CPAP')
@section('seo_title', 'Acceso Prohibido | CPAP Región Centro')
@section('seo_description', 'No tienes permiso para acceder a este recurso.')
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
        color: var(--warning, #f57c00);
        margin: 0;
        line-height: 1;
        text-shadow: 2px 2px 4px rgba(245, 124, 0, 0.1);
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
        animation: shake 0.5s ease-in-out;
        color: var(--warning, #f57c00);
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-10px); }
        75% { transform: translateX(10px); }
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

    .error-info {
        background: var(--warning-light, rgba(245, 124, 0, 0.1));
        border: 1px solid var(--warning, #f57c00);
        border-radius: 12px;
        padding: 30px;
        margin-top: 40px;
    }

    .error-info-title {
        font-size: 16px;
        font-weight: 700;
        color: var(--warning, #f57c00);
        margin: 0 0 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .error-info-text {
        color: var(--medium-gray, #666);
        font-size: 14px;
        line-height: 1.6;
        margin: 0;
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

        .error-info {
            padding: 20px;
        }
    }
</style>

<div class="error-container">
    <div class="error-content">
        <div class="error-icon">
            <i class="fas fa-lock"></i>
        </div>

        <h1 class="error-code">403</h1>
        <h2 class="error-title">Acceso Prohibido</h2>
        <p class="error-message">
            No tienes permiso para acceder a este recurso. Si crees que esto es un error, por favor contacta con nosotros.
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

        <div class="error-info">
            <h3 class="error-info-title">
                <i class="fas fa-shield-alt"></i>
                ¿Necesitas ayuda?
            </h3>
            <p class="error-info-text">
                Si tienes dudas sobre permisos o acceso, puedes <a href="{{ route('contacto.index') }}" style="color: var(--primary, #8B1438); font-weight: 600; text-decoration: none;">contactarnos</a> para obtener más información.
            </p>
        </div>
    </div>
</div>

@endsection
