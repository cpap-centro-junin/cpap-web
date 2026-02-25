{{-- resources/views/nosotros/historia.blade.php --}}
@extends('layouts.app')

@section('title', 'Historia - CPAP Región Centro')

@section('content')

<!-- Page Header -->
<section class="page-header">
    <div class="page-header-overlay"></div>
    <div class="container">
        <div class="page-header-content" data-aos="fade-up">
            <h1 class="page-title">
                <i class="fas fa-landmark"></i>
                Historia Institucional
            </h1>
            <p class="page-subtitle">
                Cuatro décadas de compromiso con la antropología peruana y el desarrollo profesional
            </p>
            <nav class="breadcrumb">
                <a href="{{ url('/') }}">Inicio</a>
                <span>/</span>
                <span>Historia</span>
            </nav>
        </div>
    </div>
</section>

<!-- Intro contextual -->
<section class="historia-intro-section">
    <div class="container">
        <div class="historia-intro-grid">
            <div class="historia-intro-text" data-aos="fade-right">
                <span class="section-badge">Nuestra Trayectoria</span>
                <h2>Casi Cuatro Décadas al Servicio de la Antropología Peruana</h2>
                <p>
                    El Colegio Profesional de Antropólogos del Perú nació en 1985 como respuesta
                    a la necesidad de organizar, defender y proyectar la profesión antropológica
                    a nivel nacional. Desde entonces, ha sido el principal referente gremial
                    y académico para los antropólogos del país.
                </p>
                <p>
                    La Región Centro, eje de la actividad profesional en los departamentos de
                    Junín, Huancavelica y Pasco, ha consolidado su rol como pilar institucional
                    en el desarrollo de la antropología aplicada y la investigación social.
                </p>
            </div>
            <div class="historia-stats-grid" data-aos="fade-left">
                <div class="historia-stat">
                    <div class="historia-stat-icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div class="historia-stat-body">
                        <strong>1985</strong>
                        <span>Año de fundación</span>
                    </div>
                </div>
                <div class="historia-stat">
                    <div class="historia-stat-icon historia-stat-icon--gold">
                        <i class="fas fa-award"></i>
                    </div>
                    <div class="historia-stat-body">
                        <strong>39</strong>
                        <span>Años de trayectoria</span>
                    </div>
                </div>
                <div class="historia-stat">
                    <div class="historia-stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="historia-stat-body">
                        <strong>1,250+</strong>
                        <span>Colegiados activos</span>
                    </div>
                </div>
                <div class="historia-stat">
                    <div class="historia-stat-icon historia-stat-icon--gold">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="historia-stat-body">
                        <strong>Región Centro</strong>
                        <span>Junín · Huancavelica · Pasco</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Timeline horizontal interactivo -->
<div class="historia-timeline-label">
    <div class="container">
        <p><i class="fas fa-hand-pointer"></i> Pasa el cursor sobre cada era para conocer su historia</p>
    </div>
</div>

<section id="timeline">

    <!-- Fundación 1985 -->
    <div class="tl-item">
        <div class="tl-bg" style="background-image:url('{{ asset('images/fotos/' . rawurlencode('WhatsApp Image 2025-10-06 at 6.22.24 PM.jpeg')) }}')"></div>
        <div class="tl-year">
            <p>1985</p>
        </div>
        <div class="tl-content">
            <h1>Creación del CPAP</h1>
            <p>
                El Colegio Profesional de Antropólogos del Perú fue creado mediante la
                <strong>Ley Nº 24166</strong>, consolidando la representación y defensa
                profesional de los antropólogos a nivel nacional.
            </p>
            <ul class="tl-list">
                <li><i class="fas fa-check"></i> Promulgación de la Ley Nº 24166</li>
                <li><i class="fas fa-check"></i> Reconocimiento oficial de la profesión</li>
                <li><i class="fas fa-check"></i> Primera directiva nacional constituida</li>
            </ul>
        </div>
    </div>

    <!-- Consolidación 1995 -->
    <div class="tl-item">
        <div class="tl-bg" style="background-image:url('{{ asset('images/noticias/Escuela-profesional-Antropologia.jpg') }}')"></div>
        <div class="tl-year">
            <p>1995</p>
        </div>
        <div class="tl-content">
            <h1>Consolidación Institucional</h1>
            <p>
                El CPAP fortalece su estructura organizativa y amplía su presencia
                académica y social en distintas regiones del país.
            </p>
            <ul class="tl-list">
                <li><i class="fas fa-check"></i> Aprobación del estatuto institucional</li>
                <li><i class="fas fa-check"></i> Creación de consejos regionales</li>
                <li><i class="fas fa-check"></i> Primer código de ética profesional</li>
            </ul>
        </div>
    </div>

    <!-- Región Centro 2008 -->
    <div class="tl-item">
        <div class="tl-bg" style="background-image:url('{{ asset('images/fotos/' . rawurlencode('WhatsApp Image 2025-10-06 at 6.23.33 PM.jpeg')) }}')"></div>
        <div class="tl-year">
            <p>2008</p>
        </div>
        <div class="tl-content">
            <h1>Región Centro</h1>
            <p>
                Se impulsa el fortalecimiento del Colegio en la región centro,
                promoviendo investigación, desarrollo social y formación continua.
            </p>
            <ul class="tl-list">
                <li><i class="fas fa-check"></i> Sede regional en Huancayo consolidada</li>
                <li><i class="fas fa-check"></i> Convenios con universidades regionales</li>
                <li><i class="fas fa-check"></i> Programas de capacitación local</li>
            </ul>
        </div>
    </div>

    <!-- Actualidad -->
    <div class="tl-item">
        <div class="tl-bg" style="background-image:url('{{ asset('images/fotos/' . rawurlencode('WhatsApp Image 2025-10-06 at 6.25.03 PM (1).jpeg')) }}')"></div>
        <div class="tl-year">
            <p>Hoy</p>
        </div>
        <div class="tl-content">
            <h1>Institución Moderna</h1>
            <p>
                El CPAP avanza hacia una gestión moderna, participativa y autosostenible,
                alineada con los desafíos sociales y científicos contemporáneos.
            </p>
            <ul class="tl-list">
                <li><i class="fas fa-check"></i> Plataforma digital para trámites en línea</li>
                <li><i class="fas fa-check"></i> Biblioteca virtual y recursos académicos</li>
                <li><i class="fas fa-check"></i> Bolsa de trabajo especializada</li>
            </ul>
        </div>
    </div>

</section>

<!-- Hitos Institucionales -->
<section class="historia-hitos-section section-padding bg-light">
    <div class="container">
        <div class="section-header text-center" data-aos="fade-up">
            <span class="section-badge">Logros y Hitos</span>
            <h2 class="section-title">Momentos que Definen nuestra Historia</h2>
            <p class="section-subtitle">Eventos clave que marcaron la evolución del CPAP Región Centro</p>
        </div>

        <div class="hitos-grid">

            <div class="hito-card" data-aos="fade-up" data-aos-delay="50">
                <div class="hito-year">1985</div>
                <div class="hito-icon">
                    <i class="fas fa-gavel"></i>
                </div>
                <h3>Fundación Legal</h3>
                <p>Promulgación de la Ley Nº 24166 que crea oficialmente el Colegio Profesional de Antropólogos del Perú.</p>
            </div>

            <div class="hito-card" data-aos="fade-up" data-aos-delay="100">
                <div class="hito-year">1995</div>
                <div class="hito-icon">
                    <i class="fas fa-sitemap"></i>
                </div>
                <h3>Organización Nacional</h3>
                <p>Creación de los consejos regionales y aprobación del primer estatuto que reguló el ejercicio profesional.</p>
            </div>

            <div class="hito-card" data-aos="fade-up" data-aos-delay="150">
                <div class="hito-year">2008</div>
                <div class="hito-icon">
                    <i class="fas fa-map-marked-alt"></i>
                </div>
                <h3>Consolidación Regional</h3>
                <p>Fortalecimiento del CPAP en la región centro, con sede en Huancayo y convenios universitarios activos.</p>
            </div>

            <div class="hito-card" data-aos="fade-up" data-aos-delay="200">
                <div class="hito-year">2026</div>
                <div class="hito-icon hito-icon--gold">
                    <i class="fas fa-rocket"></i>
                </div>
                <h3>Era Digital</h3>
                <p>Transformación digital del colegio: trámites en línea, biblioteca virtual y herramientas para colegiados.</p>
            </div>

        </div>
    </div>
</section>

<!-- CTA -->
<section class="section-padding">
    <div class="container">
        <div class="historia-cta" data-aos="zoom-in">
            <div class="historia-cta-content">
                <i class="fas fa-users historia-cta-icon"></i>
                <div>
                    <h2>Conoce al Equipo que Escribe el Presente</h2>
                    <p>Descubre a los profesionales que lideran el CPAP Región Centro en la gestión 2024–2026.</p>
                </div>
            </div>
            <div class="historia-cta-actions">
                <a href="{{ route('nosotros.consejo-directivo') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-users-cog"></i>
                    Ver Consejo Directivo
                </a>
                <a href="{{ url('/#colegiatura') }}" class="btn btn-outline btn-lg">
                    <i class="fas fa-user-plus"></i>
                    Únete al CPAP
                </a>
            </div>
        </div>
    </div>
</section>

@endsection
