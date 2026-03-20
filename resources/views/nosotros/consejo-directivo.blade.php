{{-- resources/views/nosotros/consejo-directivo.blade.php --}}
@extends('layouts.app')

@section('title', 'Consejo Directivo - CPAP Región Centro')

@section('content')

<!-- Page Header -->
<section class="page-header">
    <div class="page-header-overlay"></div>
    <div class="container">
        <div class="page-header-content" data-aos="fade-up">
            <h1 class="page-title">
                <i class="fas fa-users"></i>
                Consejo Directivo
            </h1>
            <p class="page-subtitle">
                Equipo responsable de la dirección y representación institucional del CPAP – Región Centro
            </p>
            <nav class="breadcrumb">
                <a href="{{ url('/') }}">Inicio</a>
                <span>/</span>
                <span>Consejo Directivo</span>
            </nav>
        </div>
    </div>
</section>

<!-- Banner de gestión -->
<section class="consejo-banner">
    <div class="consejo-banner-overlay"></div>
    <div class="container">
        <div class="consejo-banner-inner" data-aos="fade-up">
            <div class="consejo-banner-icon">
                <i class="fas fa-users-cog"></i>
            </div>
            <div class="consejo-banner-text">
                <span class="consejo-banner-label">Período en funciones</span>
                <h2>Gestión 2024 – 2026</h2>
                <p>
                    El Consejo Directivo es el órgano de gobierno elegido democráticamente por los colegiados,
                    responsable de la representación, administración y dirección estratégica del CPAP Región Centro.
                </p>
            </div>
            <div class="consejo-banner-stats">
                @php $totalMiembros = $consejo->count(); @endphp
                <div class="consejo-banner-stat">
                    <strong>{{ $totalMiembros ?: '5' }}</strong>
                    <span>Miembros</span>
                </div>
                <div class="consejo-banner-stat">
                    <strong>2</strong>
                    <span>Años de gestión</span>
                </div>
                <div class="consejo-banner-stat">
                    <strong>1,250+</strong>
                    <span>Colegiados representados</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Foto Grupal del Consejo Directivo -->
<section class="consejo-foto-grupal">
    <div class="container">
        <div class="consejo-foto-card" data-aos="zoom-in">
            <div class="consejo-foto-imagen">
                <img src="/images/consejo-directivo/foto-grupal.jpg"
                     alt="Consejo Directivo CPAP Región Centro - Gestión 2024-2026"
                     loading="lazy">
            </div>
            <div class="consejo-foto-caption">
                <span class="consejo-foto-badge">
                    <i class="fas fa-users"></i>
                    Gestión 2024 – 2026
                </span>
                <h3>Consejo Directivo del CPAP Región Centro</h3>
                <p>Comprometidos con el desarrollo profesional y la representación de los antropólogos de la región</p>
            </div>
        </div>
    </div>
</section>

<!-- Imagen institucional adicional -->
<section class="consejo-foto-secundaria">
    <div class="container">
        <div class="consejo-foto-card" data-aos="zoom-in">
            <div class="consejo-foto-imagen">
                <img src="/images/consejo-directivo/header-bg.jpg"
                     alt="Imagen institucional del Consejo Directivo"
                     loading="lazy">
            </div>
            <div class="consejo-foto-caption">
                <span class="consejo-foto-badge">
                    <i class="fas fa-image"></i>
                    Imagen institucional
                </span>
                <h3>Consejo Directivo - CPAP Región Centro</h3>
                <p>Registro visual institucional del equipo de dirección</p>
            </div>
        </div>
    </div>
</section>

<!-- Descripción institucional + funciones -->
<section class="consejo-intro-section">
    <div class="container">
        <div class="consejo-intro-grid">
            <div class="consejo-intro-text" data-aos="fade-right">
                <span class="section-badge">Gobierno Institucional</span>
                <h2>Equipo de Gobierno del CPAP Región Centro</h2>
                <p>
                    El Consejo Directivo ejerce sus funciones conforme al Estatuto del Colegio Profesional
                    de Antropólogos del Perú, velando por los intereses de todos los colegiados y
                    manteniendo una gestión transparente, participativa y orientada al desarrollo profesional.
                </p>
                <ul class="consejo-funciones-list">
                    <li>
                        <i class="fas fa-gavel"></i>
                        <span>Representación legal del CPAP ante entidades públicas y privadas</span>
                    </li>
                    <li>
                        <i class="fas fa-clipboard-list"></i>
                        <span>Elaboración y ejecución del plan de trabajo institucional</span>
                    </li>
                    <li>
                        <i class="fas fa-hand-holding-usd"></i>
                        <span>Administración transparente de los recursos del colegio</span>
                    </li>
                    <li>
                        <i class="fas fa-graduation-cap"></i>
                        <span>Organización de capacitaciones, eventos y actividades académicas</span>
                    </li>
                </ul>
            </div>
            <div class="consejo-intro-visual" data-aos="fade-left">
                <div class="consejo-estructura">
                    <h3><i class="fas fa-sitemap"></i> Estructura del Consejo</h3>
                    <div class="consejo-estructura-list">
                        <div class="consejo-estructura-item consejo-estructura-item--main">
                            <i class="fas fa-star"></i>
                            <span>Decano / Decana</span>
                        </div>
                        <div class="consejo-estructura-item">
                            <i class="fas fa-award"></i>
                            <span>Vice Decano / Vice Decana</span>
                        </div>
                        <div class="consejo-estructura-item">
                            <i class="fas fa-pen-nib"></i>
                            <span>Director/a Secretario/a</span>
                        </div>
                        <div class="consejo-estructura-item">
                            <i class="fas fa-coins"></i>
                            <span>Director/a de Economía</span>
                        </div>
                        <div class="consejo-estructura-item">
                            <i class="fas fa-bullhorn"></i>
                            <span>Director/a de Relaciones Públicas</span>
                        </div>
                        <div class="consejo-estructura-item">
                            <i class="fas fa-flask"></i>
                            <span>Director/a de Actividades Científicas y Culturales</span>
                        </div>
                        <div class="consejo-estructura-item">
                            <i class="fas fa-shield-alt"></i>
                            <span>Director/a de Seguridad Social</span>
                        </div>
                        <div class="consejo-estructura-item">
                            <i class="fas fa-book"></i>
                            <span>Director/a de Biblioteca y Archivo</span>
                        </div>
                        <div class="consejo-estructura-item">
                            <i class="fas fa-handshake"></i>
                            <span>Director/a de Relaciones y Defensa Profesional</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Grid de Cards -->
<section class="section-padding bg-light" id="consejo">
    <div class="container">

        <div class="section-header text-center" data-aos="fade-up">
            <span class="section-badge">Gestión 2024 – 2026</span>
            <h2 class="section-title">Nuestros Directivos</h2>
            <p class="section-subtitle">
                Conoce a los profesionales que lideran el Colegio Profesional de Antropólogos del Perú – Región Centro
            </p>
        </div>

        @php $periodo = $consejo->first()?->periodo ?? '2024 – 2026'; @endphp

        @if($consejo->isEmpty())
        <div class="consejo-empty-state" data-aos="fade-up">
            <i class="fas fa-users"></i>
            <h3>Información en preparación</h3>
            <p>El Consejo Directivo se publicará próximamente. Para más información, contáctanos.</p>
            <a href="{{ url('/#contacto') }}" class="btn btn-primary">
                <i class="fas fa-envelope"></i>
                Contáctanos
            </a>
        </div>
        @else
        <div class="consejo-grid">
            @foreach($consejo as $miembro)
            <div class="consejo-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 80 }}">

                <!-- Foto -->
                <div class="consejo-card__photo" id="photo-{{ $loop->index }}">
                    <div class="consejo-card__photo-fallback">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    @if($miembro->foto)
                    <img src="{{ $miembro->foto }}"
                         alt="{{ $miembro->nombre }}"
                         loading="lazy"
                         onerror="document.getElementById('photo-{{ $loop->index }}').classList.add('no-photo')">
                    @endif
                </div>

                <!-- Cargo badge -->
                <div class="consejo-card__cargo">
                    <i class="fas {{ $miembro->icon }}"></i>
                    {{ $miembro->cargo }}
                </div>

                <!-- Cuerpo -->
                <div class="consejo-card__body">
                    <h3 class="consejo-card__nombre">{{ $miembro->nombre }}</h3>
                </div>

                <!-- Footer -->
                <div class="consejo-card__footer">
                    <span class="consejo-card__periodo">
                        <i class="fas fa-calendar-alt"></i>
                        Gestión {{ $miembro->periodo }}
                    </span>
                </div>

            </div>
            @endforeach
        </div>
        @endif

    </div>
</section>

<!-- CTA final -->
<section class="section-padding">
    <div class="container">
        <div class="consejo-cta" data-aos="zoom-in">
            <div class="consejo-cta-left">
                <i class="fas fa-handshake consejo-cta-icon"></i>
                <div>
                    <h2>¿Quieres formar parte de la comunidad?</h2>
                    <p>Únete al Colegio Profesional de Antropólogos del Perú – Región Centro y accede a todos los beneficios de estar colegiado.</p>
                </div>
            </div>
            <div class="consejo-cta-right">
                <a href="{{ url('/#colegiatura') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-user-plus"></i>
                    Proceso de Colegiatura
                </a>
                <a href="{{ url('/#contacto') }}" class="btn btn-outline btn-lg">
                    <i class="fas fa-envelope"></i>
                    Contáctanos
                </a>
            </div>
        </div>
    </div>
</section>

@endsection
