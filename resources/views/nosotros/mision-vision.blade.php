@extends('layouts.app')

@section('title', 'Misión y Visión - CPAP Región Centro')

@section('content')

<!-- Page Header -->
<section class="page-header">
    <div class="page-header-overlay"></div>
    <div class="container">
        <div class="page-header-content" data-aos="fade-up">
            <h1 class="page-title">
                <i class="fas fa-university"></i>
                Nosotros
            </h1>
            <p class="page-subtitle">
                Conoce los principios que guían al Colegio Profesional de Antropólogos del Perú – Región Centro
            </p>
            <nav class="breadcrumb">
                <a href="{{ url('/') }}">Inicio</a>
                <span>/</span>
                <span>Misión y Visión</span>
            </nav>
        </div>
    </div>
</section>

<!-- Sección Misión + Visión (split blocks) -->
<section class="mv-split-section">

    <!-- MISIÓN -->
    <div class="mv-split-block mv-mision">
        <div class="container">
            <div class="mv-split-inner">
                <div class="mv-split-content" data-aos="fade-right">
                    <span class="mv-eyebrow">
                        <i class="fas fa-bullseye"></i> Misión
                    </span>
                    <h2>Misión Institucional</h2>
                    <p>
                        Velar por el ejercicio y defensa profesional de los antropólogos, promoviendo su
                        capacitación permanente y fortaleciendo el rol de la antropología en el desarrollo
                        social, académico y científico del país.
                    </p>
                    <ul class="mv-checklist">
                        <li>
                            <span class="mv-check-icon"><i class="fas fa-check"></i></span>
                            Defensa y representación del ejercicio profesional
                        </li>
                        <li>
                            <span class="mv-check-icon"><i class="fas fa-check"></i></span>
                            Capacitación continua y actualización académica
                        </li>
                        <li>
                            <span class="mv-check-icon"><i class="fas fa-check"></i></span>
                            Articulación con entidades académicas y del Estado
                        </li>
                        <li>
                            <span class="mv-check-icon"><i class="fas fa-check"></i></span>
                            Fortalecimiento de la identidad profesional del antropólogo
                        </li>
                    </ul>
                </div>
                <div class="mv-split-image" data-aos="fade-left">
                    <div class="mv-split-img-wrap">
                        <img src="{{ asset('images/fotos/' . rawurlencode('WhatsApp Image 2025-10-06 at 6.22.24 PM (1).jpeg')) }}"
                             alt="Misión CPAP – Reunión de colegiados"
                             loading="lazy"
                             onerror="this.src='{{ asset('images/noticias/Ceremonia-juramentacion.png') }}'">
                    </div>
                    <div class="mv-floating-stat">
                        <span class="mv-floating-num">39</span>
                        <span class="mv-floating-label">Años de servicio</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- VISIÓN -->
    <div class="mv-split-block mv-vision">
        <div class="container">
            <div class="mv-split-inner mv-split-inner--reversed">
                <div class="mv-split-image" data-aos="fade-right">
                    <div class="mv-split-img-wrap">
                        <img src="{{ asset('images/fotos/' . rawurlencode('WhatsApp Image 2025-10-06 at 6.25.01 PM.jpeg')) }}"
                             alt="Visión CPAP – Actividad académica regional"
                             loading="lazy"
                             onerror="this.src='{{ asset('images/noticias/39-Aniversario.jpg') }}'">
                    </div>
                    <div class="mv-floating-stat mv-floating-stat--gold">
                        <span class="mv-floating-num">1,250+</span>
                        <span class="mv-floating-label">Colegiados</span>
                    </div>
                </div>
                <div class="mv-split-content" data-aos="fade-left">
                    <span class="mv-eyebrow mv-eyebrow--gold">
                        <i class="fas fa-eye"></i> Visión
                    </span>
                    <h2>Visión Institucional</h2>
                    <p>
                        Ser una institución moderna, sólida y organizada, con miembros altamente capacitados
                        y proyectos de impacto nacional, reconocida como referente de la antropología peruana
                        en los ámbitos académico, social y cultural.
                    </p>
                    <ul class="mv-checklist">
                        <li>
                            <span class="mv-check-icon mv-check-icon--gold"><i class="fas fa-check"></i></span>
                            Institución líder en la región centro del Perú
                        </li>
                        <li>
                            <span class="mv-check-icon mv-check-icon--gold"><i class="fas fa-check"></i></span>
                            Miembros altamente capacitados con proyección nacional
                        </li>
                        <li>
                            <span class="mv-check-icon mv-check-icon--gold"><i class="fas fa-check"></i></span>
                            Referente de la antropología como ciencia transformadora
                        </li>
                        <li>
                            <span class="mv-check-icon mv-check-icon--gold"><i class="fas fa-check"></i></span>
                            Gestión transparente, participativa y moderna
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</section>

<!-- Sección Valores -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="section-header text-center" data-aos="fade-up">
            <span class="section-badge">Nuestros Valores</span>
            <h2 class="section-title">Los Principios que nos Guían</h2>
            <p class="section-subtitle">Fundamentos éticos e institucionales que orientan la actuación del CPAP Región Centro</p>
        </div>

        <div class="mv-valores-grid">

            <div class="mv-valor-card" data-aos="fade-up" data-aos-delay="50">
                <div class="mv-valor-icon mv-valor-icon--primary">
                    <i class="fas fa-user-shield"></i>
                </div>
                <h3>Ética Profesional</h3>
                <p>Actuamos con rectitud y responsabilidad, respetando el código deontológico que regula el ejercicio de la antropología.</p>
            </div>

            <div class="mv-valor-card" data-aos="fade-up" data-aos-delay="100">
                <div class="mv-valor-icon mv-valor-icon--gold">
                    <i class="fas fa-hands-helping"></i>
                </div>
                <h3>Compromiso Social</h3>
                <p>Trabajamos en beneficio de nuestros colegiados y de la sociedad, contribuyendo al desarrollo cultural y científico del Perú.</p>
            </div>

            <div class="mv-valor-card" data-aos="fade-up" data-aos-delay="150">
                <div class="mv-valor-icon mv-valor-icon--primary">
                    <i class="fas fa-lightbulb"></i>
                </div>
                <h3>Innovación Académica</h3>
                <p>Fomentamos la investigación, la producción científica y la actualización permanente de los profesionales antropólogos.</p>
            </div>

            <div class="mv-valor-card" data-aos="fade-up" data-aos-delay="200">
                <div class="mv-valor-icon mv-valor-icon--gold">
                    <i class="fas fa-globe-americas"></i>
                </div>
                <h3>Proyección Nacional</h3>
                <p>Impulsamos la presencia del CPAP en el ámbito nacional, articulando con instituciones públicas, privadas y académicas.</p>
            </div>

            <div class="mv-valor-card" data-aos="fade-up" data-aos-delay="250">
                <div class="mv-valor-icon mv-valor-icon--primary">
                    <i class="fas fa-balance-scale"></i>
                </div>
                <h3>Transparencia</h3>
                <p>Gestionamos los recursos y la información con honestidad, brindando cuentas claras a nuestros miembros y a la sociedad.</p>
            </div>

            <div class="mv-valor-card" data-aos="fade-up" data-aos-delay="300">
                <div class="mv-valor-icon mv-valor-icon--gold">
                    <i class="fas fa-users"></i>
                </div>
                <h3>Solidaridad Gremial</h3>
                <p>Promovemos la unidad, el respeto mutuo y la colaboración entre todos los colegiados como base de nuestra fortaleza institucional.</p>
            </div>

        </div>
    </div>
</section>

<!-- Banner de Proyección e Impacto -->
<section class="mv-impact-section">
    <div class="mv-impact-overlay"></div>
    <div class="container">
        <div class="mv-impact-grid">

            <div class="mv-impact-text" data-aos="fade-right">
                <span class="mv-eyebrow mv-eyebrow--light">
                    <i class="fas fa-flag"></i> Proyección Institucional
                </span>
                <h2>Comprometidos con el Desarrollo Antropológico</h2>
                <p>
                    El CPAP Región Centro trabaja para consolidar un colectivo profesional sólido,
                    con representación activa en todo el territorio nacional. Creemos en la
                    antropología como herramienta de transformación social y científica.
                </p>
                <div class="mv-impact-stats">
                    <div class="mv-impact-stat">
                        <strong>1985</strong>
                        <span>Año de fundación</span>
                    </div>
                    <div class="mv-impact-stat">
                        <strong>39</strong>
                        <span>Años de trayectoria</span>
                    </div>
                    <div class="mv-impact-stat">
                        <strong>+150</strong>
                        <span>Eventos anuales</span>
                    </div>
                </div>
            </div>

            <div class="mv-impact-principles" data-aos="fade-left">
                <h3><i class="fas fa-list-check"></i> Principios Institucionales</h3>
                <ul class="mv-principles-list">
                    <li>
                        <i class="fas fa-check-double"></i>
                        <span>Respeto a la diversidad cultural e intercultural del Perú</span>
                    </li>
                    <li>
                        <i class="fas fa-check-double"></i>
                        <span>Rigor científico en la investigación y la práctica profesional</span>
                    </li>
                    <li>
                        <i class="fas fa-check-double"></i>
                        <span>Autonomía institucional frente a poderes políticos y económicos</span>
                    </li>
                    <li>
                        <i class="fas fa-check-double"></i>
                        <span>Inclusión y participación democrática de todos los colegiados</span>
                    </li>
                    <li>
                        <i class="fas fa-check-double"></i>
                        <span>Actualización permanente ante los cambios sociales y académicos</span>
                    </li>
                    <li>
                        <i class="fas fa-check-double"></i>
                        <span>Articulación con la Junta Nacional del CPAP y regiones hermanas</span>
                    </li>
                </ul>
            </div>

        </div>
    </div>
</section>

<!-- CTA Final -->
<section class="section-padding">
    <div class="container">
        <div class="mv-cta" data-aos="zoom-in">
            <i class="fas fa-handshake mv-cta-icon"></i>
            <h2>¿Quieres ser parte de nuestra comunidad?</h2>
            <p>Forma parte del Colegio Profesional de Antropólogos del Perú – Región Centro y accede a todos los beneficios de estar colegiado.</p>
            <div class="mv-cta-buttons">
                <a href="{{ url('/#colegiatura') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-user-plus"></i>
                    Proceso de Colegiatura
                </a>
                <a href="{{ route('nosotros.consejo-directivo') }}" class="btn btn-outline btn-lg">
                    <i class="fas fa-users"></i>
                    Conocer el Consejo
                </a>
            </div>
        </div>
    </div>
</section>

@endsection
