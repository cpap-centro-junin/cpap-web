@extends('layouts.app')

@section('title', 'Bolsa de Trabajo - CPAP Región Centro')

@section('content')
<!-- Page Header -->
<section class="page-header">
    <div class="page-header-overlay"></div>
    <div class="container">
        <div class="page-header-content" data-aos="fade-up">
            <h1 class="page-title">
                <i class="fas fa-briefcase"></i>
                Bolsa de Trabajo
            </h1>
            <p class="page-subtitle">Oportunidades laborales para antropólogos colegiados</p>
            <nav class="breadcrumb">
                <a href="{{ url('/') }}">Inicio</a>
                <span>/</span>
                <span>Bolsa de Trabajo</span>
            </nav>
        </div>
    </div>
</section>

<!-- Filters Section -->
<section class="section-padding">
    <div class="container">
        <div class="job-filters" data-aos="fade-up">
            <div class="filter-group">
                <label for="jobType">Tipo de Trabajo:</label>
                <select id="jobType" class="filter-select">
                    <option value="">Todos</option>
                    <option value="fulltime">Tiempo Completo</option>
                    <option value="parttime">Medio Tiempo</option>
                    <option value="freelance">Freelance</option>
                    <option value="consultoria">Consultoría</option>
                </select>
            </div>
            <div class="filter-group">
                <label for="location">Ubicación:</label>
                <select id="location" class="filter-select">
                    <option value="">Todas</option>
                    <option value="huancayo">Huancayo</option>
                    <option value="lima">Lima</option>
                    <option value="cusco">Cusco</option>
                    <option value="remote">Remoto</option>
                </select>
            </div>
            <div class="filter-group">
                <label for="area">Área:</label>
                <select id="area" class="filter-select">
                    <option value="">Todas</option>
                    <option value="investigacion">Investigación</option>
                    <option value="docencia">Docencia</option>
                    <option value="consultoria">Consultoría</option>
                    <option value="gestion">Gestión Cultural</option>
                </select>
            </div>
            <button class="btn btn-primary">
                <i class="fas fa-search"></i>
                Buscar
            </button>
        </div>
    </div>
</section>

<!-- Job Listings -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="jobs-grid">
            <!-- Job Card 1 -->
            <div class="job-card" data-aos="fade-up" data-aos-delay="100">
                <div class="job-header">
                    <div class="company-logo">
                        <i class="fas fa-building"></i>
                    </div>
                    <div class="job-tags">
                        <span class="tag tag-fulltime">Tiempo Completo</span>
                        <span class="tag tag-new">Nuevo</span>
                    </div>
                </div>
                <h3 class="job-title">Antropólogo/a para Proyecto de Investigación Social</h3>
                <p class="company-name"><i class="fas fa-building"></i> ONG Desarrollo Social</p>
                <p class="job-location"><i class="fas fa-map-marker-alt"></i> Huancayo, Junín</p>
                <p class="job-description">
                    Se busca antropólogo/a con experiencia en investigación cualitativa para proyecto de desarrollo comunitario en zonas rurales de Junín.
                </p>
                <div class="job-footer">
                    <div class="job-salary">
                        <i class="fas fa-money-bill-wave"></i>
                        S/. 3,500 - 4,500
                    </div>
                    <div class="job-date">
                        <i class="fas fa-clock"></i>
                        Publicado hace 2 días
                    </div>
                </div>
                <a href="#" class="btn btn-primary btn-block">
                    <i class="fas fa-paper-plane"></i>
                    Postular Ahora
                </a>
            </div>

            <!-- Job Card 2 -->
            <div class="job-card" data-aos="fade-up" data-aos-delay="200">
                <div class="job-header">
                    <div class="company-logo">
                        <i class="fas fa-university"></i>
                    </div>
                    <div class="job-tags">
                        <span class="tag tag-parttime">Medio Tiempo</span>
                    </div>
                </div>
                <h3 class="job-title">Docente de Antropología Cultural</h3>
                <p class="company-name"><i class="fas fa-university"></i> Universidad Nacional del Centro del Perú</p>
                <p class="job-location"><i class="fas fa-map-marker-alt"></i> Huancayo, Junín</p>
                <p class="job-description">
                    Se requiere antropólogo/a con grado de maestría para dictar cursos de antropología cultural y métodos etnográficos.
                </p>
                <div class="job-footer">
                    <div class="job-salary">
                        <i class="fas fa-money-bill-wave"></i>
                        Por horas
                    </div>
                    <div class="job-date">
                        <i class="fas fa-clock"></i>
                        Publicado hace 5 días
                    </div>
                </div>
                <a href="#" class="btn btn-primary btn-block">
                    <i class="fas fa-paper-plane"></i>
                    Postular Ahora
                </a>
            </div>

            <!-- Job Card 3 -->
            <div class="job-card" data-aos="fade-up" data-aos-delay="300">
                <div class="job-header">
                    <div class="company-logo">
                        <i class="fas fa-globe"></i>
                    </div>
                    <div class="job-tags">
                        <span class="tag tag-consultoria">Consultoría</span>
                        <span class="tag tag-remote">Remoto</span>
                    </div>
                </div>
                <h3 class="job-title">Consultor/a en Gestión Cultural y Patrimonio</h3>
                <p class="company-name"><i class="fas fa-globe"></i> Consultora Internacional</p>
                <p class="job-location"><i class="fas fa-map-marker-alt"></i> Remoto</p>
                <p class="job-description">
                    Buscamos consultor/a con experiencia en gestión cultural y patrimonio para proyecto de conservación de sitios arqueológicos.
                </p>
                <div class="job-footer">
                    <div class="job-salary">
                        <i class="fas fa-money-bill-wave"></i>
                        Por proyecto
                    </div>
                    <div class="job-date">
                        <i class="fas fa-clock"></i>
                        Publicado hace 1 semana
                    </div>
                </div>
                <a href="#" class="btn btn-primary btn-block">
                    <i class="fas fa-paper-plane"></i>
                    Postular Ahora
                </a>
            </div>
        </div>

        <!-- Pagination -->
        <div class="pagination-wrapper" data-aos="fade-up">
            <ul class="pagination">
                <li class="page-item disabled">
                    <a class="page-link" href="#"><i class="fas fa-chevron-left"></i></a>
                </li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a>
                </li>
            </ul>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="cta-overlay"></div>
    <div class="container">
        <div class="cta-content" data-aos="zoom-in">
            <h2>¿Tienes una oferta laboral?</h2>
            <p>Si tu organización busca contratar antropólogos profesionales, publica tu oferta aquí</p>
            <a href="#contacto" class="btn btn-light btn-lg">
                <i class="fas fa-plus-circle"></i>
                Publicar Oferta
            </a>
        </div>
    </div>
</section>
@endsection
