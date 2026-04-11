@php use Illuminate\Support\Str; @endphp

@extends('layouts.app')

@section('title', $noticia->titulo . ' - CPAP')
@section('seo_title', $noticia->titulo . ' | Noticias CPAP Región Centro')
@section('seo_description', Str::limit(strip_tags($noticia->resumen ?: $noticia->contenido), 160))
@section('seo_canonical', route('noticias.show', $noticia))
@section('seo_image', $noticia->imagen ?: asset('images/logos/cpap-logo.jpg'))

@section('content')

{{-- PAGE HEADER --}}
<header class="page-header">
    <div class="page-header__overlay"></div>
    <div class="container" style="position:relative;z-index:2;max-width:var(--container-max);margin:0 auto;padding:0 var(--spacing-lg);">
        <div class="page-header__content">
            <h1 class="page-title">
                <i class="fas fa-newspaper"></i>
                {{ Str::limit($noticia->titulo, 60) }}
            </h1>
            <nav class="breadcrumb" aria-label="breadcrumb">
                <a href="{{ url('/') }}" class="breadcrumb__item"><i class="fas fa-home"></i> Inicio</a>
                <span class="breadcrumb__separator"><i class="fas fa-chevron-right"></i></span>
                <a href="{{ route('noticias.index') }}" class="breadcrumb__item">Noticias</a>
                <span class="breadcrumb__separator"><i class="fas fa-chevron-right"></i></span>
                <span class="breadcrumb__item breadcrumb__item--active">{{ Str::limit($noticia->titulo, 40) }}</span>
            </nav>
        </div>
    </div>
</header>

{{-- ARTÍCULO --}}
<div class="article-layout">

    {{-- CONTENIDO PRINCIPAL --}}
    <article class="article-main" data-aos="fade-up">

        {{-- Imagen de portada --}}
        @if($noticia->imagen)
            <img
                src="{{ $noticia->imagen }}"
                alt="{{ $noticia->titulo }}"
                class="article-cover"
            >
        @endif

        {{-- Meta bar --}}
        <div class="article-meta-bar">
            <span class="article-badge">
                <i class="fas fa-tag"></i>
                {{ $noticia->categoria }}
            </span>
            <span class="article-meta-item">
                <i class="fas fa-user"></i>
                {{ $noticia->autor }}
            </span>
            <span class="article-meta-item">
                <i class="fas fa-calendar-alt"></i>
                {{ $noticia->created_at->translatedFormat('d \d\e F, Y') }}
            </span>
            <span class="article-meta-item">
                <i class="fas fa-clock"></i>
                {{ $noticia->created_at->format('H:i') }}
            </span>
        </div>

        {{-- Título --}}
        <h1 class="article-title">{{ $noticia->titulo }}</h1>

        {{-- Resumen / Entradilla --}}
        @if($noticia->resumen)
        <div class="article-summary">
            {{ $noticia->resumen }}
        </div>
        @endif

        {{-- Cuerpo --}}
        <div class="article-body">
            {!! $noticia->contenido !!}
        </div>

        <a href="{{ route('noticias.index') }}" class="article-back">
            <i class="fas fa-arrow-left"></i>
            Volver a Noticias
        </a>

    </article>

    {{-- SIDEBAR --}}
    <aside class="article-sidebar">

        {{-- Noticias relacionadas --}}
        @if($relacionadas->count() > 0)
        <div class="sidebar-widget" data-aos="fade-left">
            <div class="sidebar-widget__header">
                <i class="fas fa-layer-group"></i>
                Noticias Relacionadas
            </div>
            <div class="sidebar-widget__body">
                @foreach($relacionadas as $rel)
                <a href="{{ route('noticias.show', $rel) }}" class="mini-card">
                    @if($rel->imagen)
                        <img src="{{ $rel->imagen }}" alt="{{ $rel->titulo }}" class="mini-card__image">
                    @else
                        <div class="mini-card__placeholder">
                            <i class="fas fa-newspaper"></i>
                        </div>
                    @endif
                    <div class="mini-card__content">
                        <div class="mini-card__title">{{ $rel->titulo }}</div>
                        <div class="mini-card__date">
                            <i class="fas fa-calendar-alt"></i>
                            {{ $rel->created_at->format('d M, Y') }}
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Compartir --}}
        <div class="sidebar-widget" data-aos="fade-left" data-aos-delay="100">
            <div class="sidebar-widget__header">
                <i class="fas fa-share-alt"></i>
                Compartir Noticia
            </div>
            <div class="sidebar-widget__body" style="display:flex;gap:10px;flex-wrap:wrap;">
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}"
                   target="_blank" rel="noopener"
                   style="flex:1;display:inline-flex;align-items:center;justify-content:center;gap:6px;padding:10px;background:#1877f2;color:#fff;border-radius:var(--radius-sm);font-size:var(--font-sm);font-weight:600;text-decoration:none;min-width:80px;transition:opacity 0.2s;">
                    <i class="fab fa-facebook-f"></i> Facebook
                </a>
                <a href="https://twitter.com/intent/tweet?text={{ urlencode($noticia->titulo) }}&url={{ urlencode(request()->fullUrl()) }}"
                   target="_blank" rel="noopener"
                   style="flex:1;display:inline-flex;align-items:center;justify-content:center;gap:6px;padding:10px;background:#1da1f2;color:#fff;border-radius:var(--radius-sm);font-size:var(--font-sm);font-weight:600;text-decoration:none;min-width:80px;transition:opacity 0.2s;">
                    <i class="fab fa-twitter"></i> Twitter
                </a>
                <a href="https://api.whatsapp.com/send?text={{ urlencode($noticia->titulo . ' ' . request()->fullUrl()) }}"
                   target="_blank" rel="noopener"
                   style="flex:1;display:inline-flex;align-items:center;justify-content:center;gap:6px;padding:10px;background:#25d366;color:#fff;border-radius:var(--radius-sm);font-size:var(--font-sm);font-weight:600;text-decoration:none;min-width:80px;transition:opacity 0.2s;">
                    <i class="fab fa-whatsapp"></i> WhatsApp
                </a>
            </div>
        </div>

        {{-- Categoría --}}
        <div class="sidebar-widget" data-aos="fade-left" data-aos-delay="150">
            <div class="sidebar-widget__header">
                <i class="fas fa-info-circle"></i>
                Sobre esta Noticia
            </div>
            <div class="sidebar-widget__body">
                <div class="mini-card" style="flex-direction:column;gap:8px;padding:0;">
                    <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 0;border-bottom:1px solid var(--border);">
                        <span style="color:var(--medium-gray);font-size:var(--font-xs);font-weight:600;text-transform:uppercase;letter-spacing:0.5px;">Categoría</span>
                        <span style="background:rgba(139,21,56,0.08);color:var(--primary);padding:2px 10px;border-radius:var(--radius-full);font-size:var(--font-xs);font-weight:600;">{{ $noticia->categoria }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 0;border-bottom:1px solid var(--border);">
                        <span style="color:var(--medium-gray);font-size:var(--font-xs);font-weight:600;text-transform:uppercase;letter-spacing:0.5px;">Autor</span>
                        <span style="font-size:var(--font-sm);font-weight:500;color:var(--dark);">{{ $noticia->autor }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 0;">
                        <span style="color:var(--medium-gray);font-size:var(--font-xs);font-weight:600;text-transform:uppercase;letter-spacing:0.5px;">Publicado</span>
                        <span style="font-size:var(--font-sm);color:var(--dark);">{{ $noticia->created_at->format('d/m/Y') }}</span>
                    </div>
                </div>
            </div>
        </div>

    </aside>

</div>

@endsection
