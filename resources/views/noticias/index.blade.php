@php use Illuminate\Support\Str; @endphp

@extends('layouts.app')

@section('title', 'Noticias - CPAP')
@section('seo_title', 'Noticias Institucionales | CPAP Región Centro')
@section('seo_description', 'Consulta noticias, comunicados y novedades del Colegio Profesional de Antropólogos del Perú - Región Centro.')
@section('seo_canonical', route('noticias.index'))
@section('seo_image', asset('images/logos/cpap-logo.jpg'))

@section('content')

{{-- PAGE HEADER --}}
<header class="page-header">
    <div class="page-header__overlay"></div>
    <div class="container" style="position:relative;z-index:2;max-width:var(--container-max);margin:0 auto;padding:0 var(--spacing-lg);">
        <div class="page-header__content">
            <h1 class="page-title">
                <i class="fas fa-newspaper"></i>
                Noticias
            </h1>
            <nav class="breadcrumb" aria-label="breadcrumb">
                <a href="{{ url('/') }}" class="breadcrumb__item">
                    <i class="fas fa-home"></i> Inicio
                </a>
                <span class="breadcrumb__separator"><i class="fas fa-chevron-right"></i></span>
                <span class="breadcrumb__item breadcrumb__item--active">Noticias</span>
            </nav>
        </div>
    </div>
</header>

{{-- DESTACADAS --}}
@if($destacadas->count() > 0)
<section class="actualidad-featured">
    <div class="container" style="max-width:var(--container-max);margin:0 auto;padding:0 var(--spacing-lg);">
        <h2 class="featured-section-title" data-aos="fade-up">
            <i class="fas fa-star"></i>
            Noticias Destacadas
        </h2>
        <div class="featured-grid" data-aos="fade-up" data-aos-delay="100">
            {{-- Noticia principal --}}
            @php $main = $destacadas->first(); @endphp
            <a href="{{ route('noticias.show', $main) }}" class="featured-card featured-card--main">
                @if($main->imagen)
                    <img src="{{ $main->imagen }}" alt="{{ $main->titulo }}" class="featured-card__image">
                @else
                    <div class="featured-card__placeholder">
                        <i class="fas fa-newspaper"></i>
                    </div>
                @endif
                <div class="featured-card__overlay"></div>
                <div class="featured-card__body">
                    <span class="featured-card__badge">{{ $main->categoria }}</span>
                    <h3 class="featured-card__title">{{ $main->titulo }}</h3>
                    <div class="featured-card__meta">
                        <span><i class="fas fa-user"></i> {{ $main->autor }}</span>
                        <span><i class="fas fa-calendar-alt"></i> {{ $main->created_at->format('d M, Y') }}</span>
                    </div>
                </div>
            </a>

            {{-- Secundarias --}}
            @foreach($destacadas->skip(1) as $noticia)
            <a href="{{ route('noticias.show', $noticia) }}" class="featured-card featured-card--side">
                @if($noticia->imagen)
                    <img src="{{ $noticia->imagen }}" alt="{{ $noticia->titulo }}" class="featured-card__image">
                @else
                    <div class="featured-card__placeholder">
                        <i class="fas fa-newspaper"></i>
                    </div>
                @endif
                <div class="featured-card__overlay"></div>
                <div class="featured-card__body">
                    <span class="featured-card__badge">{{ $noticia->categoria }}</span>
                    <h3 class="featured-card__title">{{ $noticia->titulo }}</h3>
                    <div class="featured-card__meta">
                        <span><i class="fas fa-calendar-alt"></i> {{ $noticia->created_at->format('d M, Y') }}</span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- LISTADO PRINCIPAL --}}
<section class="actualidad-main">
    <div class="container" style="max-width:var(--container-max);margin:0 auto;padding:0 var(--spacing-lg);">

        <div class="section-header" data-aos="fade-up">
            <h2 class="section-title">
                <i class="fas fa-clock"></i>
                Últimas Noticias
            </h2>
            <span style="color:var(--medium-gray);font-size:var(--font-sm);">
                {{ $noticias->total() }} noticia{{ $noticias->total() !== 1 ? 's' : '' }} publicada{{ $noticias->total() !== 1 ? 's' : '' }}
            </span>
        </div>

        <div class="news-grid">
            @forelse($noticias as $noticia)
            <a href="{{ route('noticias.show', $noticia) }}" class="news-card" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 3) * 100 }}">
                <div class="news-card__image-wrap">
                    @if($noticia->imagen)
                        <img src="{{ $noticia->imagen }}" alt="{{ $noticia->titulo }}" class="news-card__image">
                    @else
                        <div class="news-card__image-placeholder">
                            <i class="fas fa-newspaper"></i>
                        </div>
                    @endif
                    <span class="news-card__category">{{ $noticia->categoria }}</span>
                </div>
                <div class="news-card__body">
                    <h3 class="news-card__title">{{ $noticia->titulo }}</h3>
                    <p class="news-card__excerpt">
                        {{ $noticia->resumen ?: Str::limit(strip_tags($noticia->contenido), 120) }}
                    </p>
                    <div class="news-card__footer">
                        <div>
                            <div class="news-card__meta">
                                <i class="fas fa-user"></i>
                                {{ $noticia->autor }}
                            </div>
                            <div class="news-card__meta" style="margin-top:4px;">
                                <i class="fas fa-calendar-alt"></i>
                                {{ $noticia->created_at->format('d M, Y') }}
                            </div>
                        </div>
                        <span class="news-card__link">
                            Leer más <i class="fas fa-arrow-right"></i>
                        </span>
                    </div>
                </div>
            </a>
            @empty
            <div class="actualidad-empty">
                <i class="fas fa-newspaper"></i>
                <h3>Sin noticias publicadas</h3>
                <p>Pronto tendremos novedades institucionales para ti.</p>
            </div>
            @endforelse
        </div>

        {{-- Paginación --}}
        @if($noticias->hasPages())
        <div class="actualidad-pagination" data-aos="fade-up">
            {{ $noticias->links() }}
        </div>
        @endif

    </div>
</section>

@endsection
