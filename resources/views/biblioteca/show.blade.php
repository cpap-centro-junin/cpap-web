@extends('layouts.app')

@section('title', $recurso->titulo . ' - Biblioteca CPAP')

@push('styles')
<link rel="stylesheet" href="{{ asset('resources/css/pages/biblioteca.css') }}">
@endpush

@section('content')
<!-- Page Header -->
<section class="page-header">
    <div class="page-header-overlay"></div>
    <div class="container">
        <div class="page-header-content" data-aos="fade-up">
            <h1 class="page-title">
                <i class="fas {{ $recurso->tipo_icon }}"></i>
                {{ $recurso->tipo_label }}
            </h1>
            <p class="page-subtitle">{{ $recurso->titulo }}</p>
            <nav class="breadcrumb">
                <a href="{{ url('/') }}">Inicio</a>
                <span>/</span>
                <a href="{{ route('biblioteca') }}">Biblioteca</a>
                <span>/</span>
                <span>{{ Str::limit($recurso->titulo, 40) }}</span>
            </nav>
        </div>
    </div>
</section>

<!-- Detalle del recurso -->
<section class="section-padding">
    <div class="container">
        <div class="recurso-detalle" data-aos="fade-up">
            <div class="recurso-detalle-grid">
                {{-- Columna izquierda: Portada --}}
                <div class="recurso-portada-col">
                    <div class="recurso-portada-wrapper">
                        @if($recurso->imagen_portada)
                            <img src="{{ asset('storage/' . $recurso->imagen_portada) }}" alt="{{ $recurso->titulo }}" class="recurso-portada-img">
                        @else
                            <div class="recurso-portada-placeholder">
                                <i class="fas {{ $recurso->tipo_icon }}"></i>
                                <span>{{ $recurso->tipo_label }}</span>
                            </div>
                        @endif
                    </div>

                    {{-- Acciones --}}
                    <div class="recurso-acciones">
                        @if($recurso->puede_descargar)
                        <a href="{{ route('biblioteca.descargar', $recurso) }}" class="btn btn-primary btn-block">
                            <i class="fas fa-download"></i> Descargar PDF
                        </a>
                        @endif
                        @if($recurso->enlace_externo)
                        <a href="{{ $recurso->enlace_externo }}" target="_blank" rel="noopener" class="btn btn-outline btn-block">
                            <i class="fas fa-external-link-alt"></i> Ver fuente externa
                        </a>
                        @endif
                        <a href="{{ route('biblioteca') }}" class="btn btn-text btn-block">
                            <i class="fas fa-arrow-left"></i> Volver a biblioteca
                        </a>
                    </div>

                    {{-- Stats --}}
                    <div class="recurso-mini-stats">
                        <div class="mini-stat">
                            <i class="fas fa-eye"></i>
                            <span>{{ number_format($recurso->vistas_count) }} vistas</span>
                        </div>
                        <div class="mini-stat">
                            <i class="fas fa-download"></i>
                            <span>{{ number_format($recurso->descargas_count) }} descargas</span>
                        </div>
                    </div>
                </div>

                {{-- Columna derecha: Info --}}
                <div class="recurso-info-col">
                    <div class="recurso-badges">
                        <span class="recurso-badge tipo">
                            <i class="fas {{ $recurso->tipo_icon }}"></i> {{ $recurso->tipo_label }}
                        </span>
                        <span class="recurso-badge area">{{ $recurso->area_label }}</span>
                        @if($recurso->destacado)
                        <span class="recurso-badge destacado"><i class="fas fa-star"></i> Destacado</span>
                        @endif
                        @if($recurso->solo_colegiados)
                        <span class="recurso-badge restringido"><i class="fas fa-lock"></i> Solo colegiados</span>
                        @endif
                    </div>

                    <h1 class="recurso-titulo">{{ $recurso->titulo }}</h1>

                    <div class="recurso-meta">
                        <div class="meta-item">
                            <i class="fas fa-user"></i>
                            <div>
                                <span class="meta-label">Autor(es)</span>
                                <span class="meta-value">{{ $recurso->autor }}</span>
                            </div>
                        </div>
                        @if($recurso->editorial)
                        <div class="meta-item">
                            <i class="fas fa-building"></i>
                            <div>
                                <span class="meta-label">Editorial</span>
                                <span class="meta-value">{{ $recurso->editorial }}</span>
                            </div>
                        </div>
                        @endif
                        @if($recurso->anio_publicacion)
                        <div class="meta-item">
                            <i class="fas fa-calendar"></i>
                            <div>
                                <span class="meta-label">Año</span>
                                <span class="meta-value">{{ $recurso->anio_publicacion }}</span>
                            </div>
                        </div>
                        @endif
                        @if($recurso->isbn_issn)
                        <div class="meta-item">
                            <i class="fas fa-barcode"></i>
                            <div>
                                <span class="meta-label">ISBN/ISSN</span>
                                <span class="meta-value">{{ $recurso->isbn_issn }}</span>
                            </div>
                        </div>
                        @endif
                        @if($recurso->paginas)
                        <div class="meta-item">
                            <i class="fas fa-file-alt"></i>
                            <div>
                                <span class="meta-label">Páginas</span>
                                <span class="meta-value">{{ $recurso->paginas }}</span>
                            </div>
                        </div>
                        @endif
                        @if($recurso->idioma)
                        <div class="meta-item">
                            <i class="fas fa-language"></i>
                            <div>
                                <span class="meta-label">Idioma</span>
                                <span class="meta-value">{{ $recurso->idioma }}</span>
                            </div>
                        </div>
                        @endif
                    </div>

                    <div class="recurso-descripcion">
                        <h3>Descripción</h3>
                        <p>{{ $recurso->descripcion }}</p>
                    </div>

                    {{-- Sección de Copyright --}}
                    <div class="recurso-copyright-section">
                        <h3><i class="fas fa-shield-alt"></i> Información de Derechos de Autor</h3>
                        <div class="copyright-card">
                            <div class="copyright-badge-large">
                                {{ $recurso->licencia_badge }}
                            </div>
                            <div class="copyright-details">
                                <p class="copyright-license">{{ $recurso->licencia_label }}</p>
                                @if($recurso->copyright_titular)
                                <p class="copyright-holder">
                                    <strong>Titular:</strong> {{ $recurso->copyright_titular }}
                                    @if($recurso->copyright_anio) ({{ $recurso->copyright_anio }}) @endif
                                </p>
                                @endif
                                @if($recurso->notas_legales)
                                <div class="copyright-notes">
                                    <strong>Condiciones de uso:</strong>
                                    <p>{{ $recurso->notas_legales }}</p>
                                </div>
                                @endif
                                @if(!$recurso->descarga_permitida)
                                <p class="copyright-warning">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    La descarga directa no está disponible para este recurso por restricciones de derechos de autor.
                                </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Recursos Relacionados --}}
@if($relacionados->isNotEmpty())
<section class="section-padding bg-light">
    <div class="container">
        <div class="section-header text-center" data-aos="fade-up">
            <span class="section-badge">Relacionados</span>
            <h2 class="section-title">Recursos Similares</h2>
        </div>

        <div class="resources-grid">
            @foreach($relacionados as $rel)
            <div class="resource-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 + 100 }}">
                <div class="resource-thumbnail">
                    @if($rel->imagen_portada)
                        <img src="{{ asset('storage/' . $rel->imagen_portada) }}" alt="{{ $rel->titulo }}">
                    @else
                        <i class="fas {{ $rel->tipo_icon }}"></i>
                    @endif
                    <span class="resource-type">{{ $rel->tipo_label }}</span>
                </div>
                <div class="resource-content">
                    <h3>{{ $rel->titulo }}</h3>
                    <p class="resource-author"><i class="fas fa-user"></i> {{ $rel->autor }}</p>
                    <p class="resource-description">{{ Str::limit($rel->descripcion, 100) }}</p>
                    <div class="resource-copyright">
                        <i class="fas fa-shield-alt"></i>
                        <span>{{ $rel->licencia_badge }}</span>
                    </div>
                    <div class="resource-actions">
                        <a href="{{ route('biblioteca.show', $rel) }}" class="btn btn-outline">
                            <i class="fas fa-eye"></i> Ver
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
