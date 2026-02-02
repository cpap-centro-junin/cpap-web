@extends('layouts.app')

@section('title', 'Biblioteca - CPAP Región Centro')

@section('content')
<!-- Page Header -->
<section class="page-header">
    <div class="page-header-overlay"></div>
    <div class="container">
        <div class="page-header-content" data-aos="fade-up">
            <h1 class="page-title">
                <i class="fas fa-book"></i>
                Biblioteca Virtual
            </h1>
            <p class="page-subtitle">Recursos bibliográficos y documentales para la investigación antropológica</p>
            <nav class="breadcrumb">
                <a href="{{ url('/') }}">Inicio</a>
                <span>/</span>
                <span>Biblioteca</span>
            </nav>
        </div>
    </div>
</section>

<!-- Search Section -->
<section class="section-padding">
    <div class="container">
        <div class="library-search" data-aos="fade-up">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Buscar libros, artículos, tesis, investigaciones...">
                <button class="btn btn-primary">Buscar</button>
            </div>
            <div class="search-filters">
                <select class="filter-select">
                    <option value="">Tipo de Documento</option>
                    <option value="libro">Libros</option>
                    <option value="articulo">Artículos</option>
                    <option value="tesis">Tesis</option>
                    <option value="investigacion">Investigaciones</option>
                    <option value="revista">Revistas</option>
                </select>
                <select class="filter-select">
                    <option value="">Área Temática</option>
                    <option value="cultural">Antropología Cultural</option>
                    <option value="social">Antropología Social</option>
                    <option value="arqueologia">Arqueología</option>
                    <option value="linguistica">Lingüística</option>
                    <option value="biologica">Antropología Biológica</option>
                </select>
                <select class="filter-select">
                    <option value="">Año</option>
                    <option value="2024">2024-2026</option>
                    <option value="2020">2020-2023</option>
                    <option value="2015">2015-2019</option>
                    <option value="older">Anteriores</option>
                </select>
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="section-header text-center" data-aos="fade-up">
            <span class="section-badge">Colecciones</span>
            <h2 class="section-title">Categorías Principales</h2>
        </div>
        
        <div class="library-categories">
            <div class="category-card" data-aos="fade-up" data-aos-delay="100">
                <div class="category-icon">
                    <i class="fas fa-book-open"></i>
                </div>
                <h3>Libros Digitales</h3>
                <p>Más de 500 títulos disponibles</p>
                <a href="#" class="btn btn-text">Explorar <i class="fas fa-arrow-right"></i></a>
            </div>

            <div class="category-card" data-aos="fade-up" data-aos-delay="200">
                <div class="category-icon">
                    <i class="fas fa-newspaper"></i>
                </div>
                <h3>Artículos Académicos</h3>
                <p>Publicaciones científicas recientes</p>
                <a href="#" class="btn btn-text">Explorar <i class="fas fa-arrow-right"></i></a>
            </div>

            <div class="category-card" data-aos="fade-up" data-aos-delay="300">
                <div class="category-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h3>Tesis y Disertaciones</h3>
                <p>Trabajos de investigación</p>
                <a href="#" class="btn btn-text">Explorar <i class="fas fa-arrow-right"></i></a>
            </div>

            <div class="category-card" data-aos="fade-up" data-aos-delay="400">
                <div class="category-icon">
                    <i class="fas fa-file-pdf"></i>
                </div>
                <h3>Documentos CPAP</h3>
                <p>Publicaciones institucionales</p>
                <a href="#" class="btn btn-text">Explorar <i class="fas fa-arrow-right"></i></a>
            </div>

            <div class="category-card" data-aos="fade-up" data-aos-delay="500">
                <div class="category-icon">
                    <i class="fas fa-globe-americas"></i>
                </div>
                <h3>Revistas Especializadas</h3>
                <p>Publicaciones periódicas</p>
                <a href="#" class="btn btn-text">Explorar <i class="fas fa-arrow-right"></i></a>
            </div>

            <div class="category-card" data-aos="fade-up" data-aos-delay="600">
                <div class="category-icon">
                    <i class="fas fa-video"></i>
                </div>
                <h3>Multimedia</h3>
                <p>Videos y documentales</p>
                <a href="#" class="btn btn-text">Explorar <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
</section>

<!-- Featured Resources -->
<section class="section-padding">
    <div class="container">
        <div class="section-header text-center" data-aos="fade-up">
            <span class="section-badge">Destacados</span>
            <h2 class="section-title">Recursos Destacados del Mes</h2>
        </div>

        <div class="resources-grid">
            <!-- Resource 1 -->
            <div class="resource-card" data-aos="fade-up" data-aos-delay="100">
                <div class="resource-thumbnail">
                    <i class="fas fa-book"></i>
                    <span class="resource-type">Libro</span>
                </div>
                <div class="resource-content">
                    <h3>Antropología Cultural en los Andes</h3>
                    <p class="resource-author"><i class="fas fa-user"></i> Dr. Carlos Mendoza</p>
                    <p class="resource-year"><i class="fas fa-calendar"></i> 2024</p>
                    <p class="resource-description">
                        Estudio exhaustivo sobre las prácticas culturales en las comunidades andinas del Perú central.
                    </p>
                    <div class="resource-tags">
                        <span class="tag">Antropología Cultural</span>
                        <span class="tag">Andes</span>
                    </div>
                    <div class="resource-actions">
                        <a href="#" class="btn btn-outline">
                            <i class="fas fa-eye"></i> Ver
                        </a>
                        <a href="#" class="btn btn-primary">
                            <i class="fas fa-download"></i> Descargar
                        </a>
                    </div>
                </div>
            </div>

            <!-- Resource 2 -->
            <div class="resource-card" data-aos="fade-up" data-aos-delay="200">
                <div class="resource-thumbnail">
                    <i class="fas fa-file-pdf"></i>
                    <span class="resource-type">Artículo</span>
                </div>
                <div class="resource-content">
                    <h3>Metodología Etnográfica Contemporánea</h3>
                    <p class="resource-author"><i class="fas fa-user"></i> Dra. María Torres</p>
                    <p class="resource-year"><i class="fas fa-calendar"></i> 2025</p>
                    <p class="resource-description">
                        Análisis de las nuevas tendencias metodológicas en la investigación etnográfica.
                    </p>
                    <div class="resource-tags">
                        <span class="tag">Metodología</span>
                        <span class="tag">Etnografía</span>
                    </div>
                    <div class="resource-actions">
                        <a href="#" class="btn btn-outline">
                            <i class="fas fa-eye"></i> Ver
                        </a>
                        <a href="#" class="btn btn-primary">
                            <i class="fas fa-download"></i> Descargar
                        </a>
                    </div>
                </div>
            </div>

            <!-- Resource 3 -->
            <div class="resource-card" data-aos="fade-up" data-aos-delay="300">
                <div class="resource-thumbnail">
                    <i class="fas fa-graduation-cap"></i>
                    <span class="resource-type">Tesis</span>
                </div>
                <div class="resource-content">
                    <h3>Identidad Cultural en Comunidades Urbanas</h3>
                    <p class="resource-author"><i class="fas fa-user"></i> Lic. Juan Pérez</p>
                    <p class="resource-year"><i class="fas fa-calendar"></i> 2025</p>
                    <p class="resource-description">
                        Investigación sobre la construcción de identidad en contextos urbanos migratorios.
                    </p>
                    <div class="resource-tags">
                        <span class="tag">Identidad</span>
                        <span class="tag">Migración</span>
                    </div>
                    <div class="resource-actions">
                        <a href="#" class="btn btn-outline">
                            <i class="fas fa-eye"></i> Ver
                        </a>
                        <a href="#" class="btn btn-primary">
                            <i class="fas fa-download"></i> Descargar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Access Info -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="info-grid">
            <div class="info-card" data-aos="fade-up" data-aos-delay="100">
                <div class="info-icon">
                    <i class="fas fa-user-check"></i>
                </div>
                <h3>Acceso para Colegiados</h3>
                <p>Los colegiados tienen acceso completo a toda la biblioteca digital sin restricciones.</p>
            </div>

            <div class="info-card" data-aos="fade-up" data-aos-delay="200">
                <div class="info-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <h3>24/7 Disponible</h3>
                <p>La biblioteca virtual está disponible las 24 horas del día, los 7 días de la semana.</p>
            </div>

            <div class="info-card" data-aos="fade-up" data-aos-delay="300">
                <div class="info-icon">
                    <i class="fas fa-sync-alt"></i>
                </div>
                <h3>Actualización Constante</h3>
                <p>Nuevos recursos son agregados mensualmente a nuestra colección digital.</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="cta-overlay"></div>
    <div class="container">
        <div class="cta-content" data-aos="zoom-in">
            <h2>¿Necesitas ayuda para encontrar recursos?</h2>
            <p>Nuestro equipo está listo para asistirte en tu búsqueda bibliográfica</p>
            <a href="#contacto" class="btn btn-light btn-lg">
                <i class="fas fa-envelope"></i>
                Contactar Biblioteca
            </a>
        </div>
    </div>
</section>
@endsection
