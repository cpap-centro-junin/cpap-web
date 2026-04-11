{{-- resources/views/nosotros/normativa-legal.blade.php --}}
@extends('layouts.app')

@section('title', 'Normativa Legal - CPAP Región Centro')
@section('seo_title', 'Normativa Legal y Documentos | CPAP Región Centro')
@section('seo_description', 'Consulta reglamentos, documentos y normativa legal oficial del Colegio Profesional de Antropólogos del Perú - Región Centro.')
@section('seo_canonical', route('nosotros.normativa-legal'))
@section('seo_image', asset('images/logos/cpap-logo.jpg'))

@section('content')

<!-- Page Header -->
<section class="page-header">
    <div class="page-header-overlay"></div>
    <div class="container">
        <div class="page-header-content" data-aos="fade-up">
            <h1 class="page-title">
                <i class="fas fa-gavel"></i>
                Normativa Legal
            </h1>
            <p class="page-subtitle">
                Documentos legales y normativos del Colegio Profesional de Antropólogos del Perú – Región Centro
            </p>
            <nav class="breadcrumb">
                <a href="{{ url('/') }}">Inicio</a>
                <span>/</span>
                <span>Normativa Legal</span>
            </nav>
        </div>
    </div>
</section>

<!-- Intro -->
<section class="normativa-intro">
    <div class="container">
        <div class="normativa-intro-grid">
            <div class="normativa-intro-text" data-aos="fade-right">
                <span class="section-badge">Marco Legal</span>
                <h2>Transparencia Institucional</h2>
                <p>
                    El Colegio Profesional de Antropólogos del Perú – Región Centro pone a disposición
                    de sus colegiados y la ciudadanía los documentos normativos que rigen su funcionamiento,
                    organización y principios éticos profesionales.
                </p>
                <p>
                    Todos los documentos están disponibles para su consulta y descarga en formato PDF.
                </p>
            </div>
            <div class="normativa-intro-visual" data-aos="fade-left">
                <div class="normativa-stats">
                    <div class="normativa-stat">
                        <i class="fas fa-file-pdf"></i>
                        <strong>{{ $documentos->count() }}</strong>
                        <span>Documentos</span>
                    </div>
                    <div class="normativa-stat">
                        <i class="fas fa-download"></i>
                        <strong>PDF</strong>
                        <span>Descarga libre</span>
                    </div>
                    <div class="normativa-stat">
                        <i class="fas fa-shield-alt"></i>
                        <strong>100%</strong>
                        <span>Transparencia</span>
                    </div>
                    <div class="normativa-stat">
                        <i class="fas fa-university"></i>
                        <strong>CPAP</strong>
                        <span>Oficial</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Documentos -->
<section class="normativa-docs">
    <div class="container">
        <div class="normativa-docs-header" data-aos="fade-up">
            <span class="section-badge">Documentos Oficiales</span>
            <h2>Marco Normativo Institucional</h2>
            <p>Accede y descarga los documentos que rigen el funcionamiento del CPAP Región Centro.</p>
        </div>

        <div class="normativa-grid">

            @forelse($documentos as $doc)
            <div class="normativa-card" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 2 == 0) ? '100' : '200' }}">
                <div class="normativa-card-accent"></div>
                <div class="normativa-card-icon">
                    <i class="{{ $doc->icono }}"></i>
                </div>
                <div class="normativa-card-body">
                    <h3>{{ $doc->titulo }}</h3>
                    @if($doc->descripcion)
                    <p>{{ $doc->descripcion }}</p>
                    @endif
                </div>
                <div class="normativa-card-actions">
                    @if($doc->archivo_pdf)
                    <a href="{{ route('nosotros.normativa.descargar', $doc) }}" class="normativa-btn normativa-btn-download">
                        <i class="fas fa-download"></i> Descargar
                    </a>
                    <a href="{{ $doc->pdfUrl }}" target="_blank" class="normativa-btn normativa-btn-view">
                        <i class="fas fa-eye"></i> Ver
                    </a>
                    @else
                    <span class="normativa-btn normativa-btn-view" style="opacity:.5;cursor:default;">
                        <i class="fas fa-clock"></i> Próximamente
                    </span>
                    @endif
                </div>
            </div>
            @empty
            <div style="grid-column:1/-1;text-align:center;padding:60px 20px;">
                <i class="fas fa-folder-open" style="font-size:48px;color:var(--medium-gray);margin-bottom:16px;display:block;"></i>
                <h3 style="color:var(--dark);margin-bottom:8px;">No hay documentos disponibles</h3>
                <p style="color:var(--medium-gray);">Los documentos normativos serán publicados próximamente.</p>
            </div>
            @endforelse

        </div>
    </div>
</section>

<!-- CTA -->
<section class="normativa-cta">
    <div class="container">
        <div class="normativa-cta-box" data-aos="fade-up">
            <div class="normativa-cta-content">
                <i class="fas fa-question-circle"></i>
                <div>
                    <h3>¿Necesitas más información?</h3>
                    <p>Si tienes consultas sobre la normativa o necesitas algún documento adicional, contáctanos.</p>
                </div>
            </div>
            <a href="{{ route('contacto.index') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-envelope"></i> Contáctanos
            </a>
        </div>
    </div>
</section>

@endsection
