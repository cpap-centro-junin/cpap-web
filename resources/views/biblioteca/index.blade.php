@extends('layouts.app')

@section('title', 'Biblioteca Virtual - CPAP Región Centro')

@vite(['resources/css/pages/biblioteca.css'])

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
            <form method="GET" action="{{ route('biblioteca') }}">
                <div class="search-boxx">
                    <i class="fas fa-search"></i>
                    <input type="text" name="q" value="{{ request('q') }}"
                           placeholder="Buscar libros, artículos, tesis, investigaciones...">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </div>
                <div class="search-filters">
                    <select name="tipo" class="filter-select" onchange="this.form.submit()">
                        <option value="">Tipo de Documento</option>
                        <option value="libro" {{ request('tipo')=='libro'?'selected':'' }}>Libros</option>
                        <option value="articulo" {{ request('tipo')=='articulo'?'selected':'' }}>Artículos</option>
                        <option value="tesis" {{ request('tipo')=='tesis'?'selected':'' }}>Tesis</option>
                        <option value="documento" {{ request('tipo')=='documento'?'selected':'' }}>Documentos CPAP</option>
                        <option value="revista" {{ request('tipo')=='revista'?'selected':'' }}>Revistas</option>
                        <option value="multimedia" {{ request('tipo')=='multimedia'?'selected':'' }}>Multimedia</option>
                    </select>
                    <select name="area" class="filter-select" onchange="this.form.submit()">
                        <option value="">Área Temática</option>
                        <option value="cultural" {{ request('area')=='cultural'?'selected':'' }}>Antropología Cultural</option>
                        <option value="social" {{ request('area')=='social'?'selected':'' }}>Antropología Social</option>
                        <option value="arqueologia" {{ request('area')=='arqueologia'?'selected':'' }}>Arqueología</option>
                        <option value="linguistica" {{ request('area')=='linguistica'?'selected':'' }}>Lingüística</option>
                        <option value="biologica" {{ request('area')=='biologica'?'selected':'' }}>Antropología Biológica</option>
                    </select>
                    <select name="anio" class="filter-select" onchange="this.form.submit()">
                        <option value="">Año</option>
                        <option value="2024" {{ request('anio')=='2024'?'selected':'' }}>2024-2026</option>
                        <option value="2020" {{ request('anio')=='2020'?'selected':'' }}>2020-2023</option>
                        <option value="2015" {{ request('anio')=='2015'?'selected':'' }}>2015-2019</option>
                        <option value="older" {{ request('anio')=='older'?'selected':'' }}>Anteriores</option>
                    </select>
                </div>
                @if(request()->hasAny(['q','tipo','area','anio']))
                <div style="text-align:center;margin-top:15px;">
                    <a href="{{ route('biblioteca') }}" class="filter-chip">
                        <i class="fas fa-times"></i> Limpiar filtros
                    </a>
                </div>
                @endif
            </form>
        </div>

        {{-- Stats bar --}}
        <div class="library-stats" data-aos="fade-up" data-aos-delay="100">
            <div class="library-stat-item">
                <div class="library-stat-number">{{ $totalRecursos }}</div>
                <div class="library-stat-label">Recursos Totales</div>
            </div>
            <div class="library-stat-item">
                <div class="library-stat-number">{{ $conteos['libro'] + $conteos['revista'] }}</div>
                <div class="library-stat-label">Libros y Revistas</div>
            </div>
            <div class="library-stat-item">
                <div class="library-stat-number">{{ $conteos['articulo'] + $conteos['tesis'] }}</div>
                <div class="library-stat-label">Artículos y Tesis</div>
            </div>
            <div class="library-stat-item">
                <div class="library-stat-number">{{ $conteos['documento'] + $conteos['multimedia'] }}</div>
                <div class="library-stat-label">Docs y Multimedia</div>
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
            <a href="{{ route('biblioteca', ['tipo'=>'libro']) }}" class="category-card {{ request('tipo')=='libro'?'active-cat':'' }}" data-aos="fade-up" data-aos-delay="100">
                <div class="category-icon">
                    <i class="fas fa-book-open"></i>
                </div>
                <h3>Libros Digitales</h3>
                <span class="category-count">{{ $conteos['libro'] }} disponibles</span>
            </a>

            <a href="{{ route('biblioteca', ['tipo'=>'articulo']) }}" class="category-card {{ request('tipo')=='articulo'?'active-cat':'' }}" data-aos="fade-up" data-aos-delay="200">
                <div class="category-icon">
                    <i class="fas fa-newspaper"></i>
                </div>
                <h3>Artículos Académicos</h3>
                <span class="category-count">{{ $conteos['articulo'] }} disponibles</span>
            </a>

            <a href="{{ route('biblioteca', ['tipo'=>'tesis']) }}" class="category-card {{ request('tipo')=='tesis'?'active-cat':'' }}" data-aos="fade-up" data-aos-delay="300">
                <div class="category-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h3>Tesis y Disertaciones</h3>
                <span class="category-count">{{ $conteos['tesis'] }} disponibles</span>
            </a>

            <a href="{{ route('biblioteca', ['tipo'=>'documento']) }}" class="category-card {{ request('tipo')=='documento'?'active-cat':'' }}" data-aos="fade-up" data-aos-delay="400">
                <div class="category-icon">
                    <i class="fas fa-file-pdf"></i>
                </div>
                <h3>Documentos CPAP</h3>
                <span class="category-count">{{ $conteos['documento'] }} disponibles</span>
            </a>

            <a href="{{ route('biblioteca', ['tipo'=>'revista']) }}" class="category-card {{ request('tipo')=='revista'?'active-cat':'' }}" data-aos="fade-up" data-aos-delay="500">
                <div class="category-icon">
                    <i class="fas fa-globe-americas"></i>
                </div>
                <h3>Revistas Especializadas</h3>
                <span class="category-count">{{ $conteos['revista'] }} disponibles</span>
            </a>

            <a href="{{ route('biblioteca', ['tipo'=>'multimedia']) }}" class="category-card {{ request('tipo')=='multimedia'?'active-cat':'' }}" data-aos="fade-up" data-aos-delay="600">
                <div class="category-icon">
                    <i class="fas fa-video"></i>
                </div>
                <h3>Multimedia</h3>
                <span class="category-count">{{ $conteos['multimedia'] }} disponibles</span>
            </a>
        </div>
    </div>
</section>

{{-- Featured Resources (si hay destacados y NO hay filtro activo) --}}
@if($destacados->isNotEmpty() && !request()->hasAny(['q','tipo','area','anio']))
<section class="section-padding">
    <div class="container">
        <div class="section-header text-center" data-aos="fade-up">
            <span class="section-badge">Destacados</span>
            <h2 class="section-title">Recursos Destacados</h2>
        </div>

        <div class="resources-grid">
            @foreach($destacados as $dest)
            <div class="resource-card featured" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 + 100 }}">
                <div class="resource-thumbnail">
                    @if($dest->imagen_portada)
                        <img src="{{ asset('storage/' . $dest->imagen_portada) }}" alt="{{ $dest->titulo }}">
                    @else
                        <i class="fas {{ $dest->tipo_icon }}"></i>
                    @endif
                    <span class="resource-type">{{ $dest->tipo_label }}</span>
                </div>
                <div class="resource-content">
                    <h3>{{ $dest->titulo }}</h3>
                    <p class="resource-author"><i class="fas fa-user"></i> {{ $dest->autor }}</p>
                    @if($dest->anio_publicacion)
                    <p class="resource-year"><i class="fas fa-calendar"></i> {{ $dest->anio_publicacion }}</p>
                    @endif
                    <p class="resource-description">
                        {{ Str::limit($dest->descripcion, 120) }}
                    </p>
                    {{-- Copyright badge --}}
                    <div class="resource-copyright">
                        <i class="fas fa-shield-alt"></i>
                        <span>{{ $dest->licencia_badge }}</span>
                        @if($dest->solo_colegiados)
                            <span class="copyright-lock"><i class="fas fa-lock"></i> Solo colegiados</span>
                        @endif
                    </div>
                    <div class="resource-actions">
                        <a href="{{ route('biblioteca.show', $dest) }}" class="btn btn-outline">
                            <i class="fas fa-eye"></i> Ver detalle
                        </a>
                        @if($dest->puede_descargar)
                        <a href="{{ route('biblioteca.descargar', $dest) }}" class="btn btn-primary">
                            <i class="fas fa-download"></i> Descargar
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- All Resources / Search Results --}}
<section class="section-padding">
    <div class="container">
        @if(request()->hasAny(['q','tipo','area','anio']))
        <div class="section-header text-center" data-aos="fade-up">
            <span class="section-badge">Resultados</span>
            <h2 class="section-title">
                {{ $recursos->total() }} recurso{{ $recursos->total() !== 1 ? 's' : '' }} encontrado{{ $recursos->total() !== 1 ? 's' : '' }}
            </h2>
        </div>
        @else
        <div class="section-header text-center" data-aos="fade-up">
            <span class="section-badge">Catálogo</span>
            <h2 class="section-title">Todos los Recursos</h2>
        </div>
        @endif

        @if($recursos->isNotEmpty())
        <div class="resources-grid">
            @foreach($recursos as $recurso)
            <div class="resource-card" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 3) * 100 + 100 }}">
                <div class="resource-thumbnail">
                    @if($recurso->imagen_portada)
                        <img src="{{ asset('storage/' . $recurso->imagen_portada) }}" alt="{{ $recurso->titulo }}">
                    @else
                        <i class="fas {{ $recurso->tipo_icon }}"></i>
                    @endif
                    <span class="resource-type">{{ $recurso->tipo_label }}</span>
                </div>
                <div class="resource-content">
                    <h3>{{ $recurso->titulo }}</h3>
                    <p class="resource-author"><i class="fas fa-user"></i> {{ $recurso->autor }}</p>
                    @if($recurso->anio_publicacion)
                    <p class="resource-year"><i class="fas fa-calendar"></i> {{ $recurso->anio_publicacion }}</p>
                    @endif
                    <p class="resource-description">
                        {{ Str::limit($recurso->descripcion, 100) }}
                    </p>
                    {{-- Copyright badge --}}
                    <div class="resource-copyright">
                        <i class="fas fa-shield-alt"></i>
                        <span>{{ $recurso->licencia_badge }}</span>
                        @if($recurso->solo_colegiados)
                            <span class="copyright-lock"><i class="fas fa-lock"></i> Solo colegiados</span>
                        @endif
                    </div>
                    <div class="resource-actions">
                        <a href="{{ route('biblioteca.show', $recurso) }}" class="btn btn-outline">
                            <i class="fas fa-eye"></i> Ver
                        </a>
                        @if($recurso->puede_descargar)
                        <a href="{{ route('biblioteca.descargar', $recurso) }}" class="btn btn-primary">
                            <i class="fas fa-download"></i> Descargar
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Paginación --}}
        @if($recursos->hasPages())
        <div style="display:flex;justify-content:center;margin-top:40px;">
            {{ $recursos->links() }}
        </div>
        @endif

        @else
        {{-- Empty state --}}
        <div class="library-empty" data-aos="fade-up">
            <div class="library-empty-icon">
                <i class="fas fa-search"></i>
            </div>
            <h3>No se encontraron recursos</h3>
            <p>Intenta con otros filtros o términos de búsqueda.</p>
            <a href="{{ route('biblioteca') }}" class="btn btn-primary" style="margin-top:10px;">
                <i class="fas fa-book"></i> Ver toda la biblioteca
            </a>
        </div>
        @endif
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
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3>Derechos de Autor</h3>
                <p>Todos los recursos incluyen información de licencia y copyright. Respeta las condiciones de uso de cada publicación.</p>
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
            <a href="{{ route('contacto.index') }}" class="btn btn-light btn-lg">
                <i class="fas fa-envelope"></i>
                Contactar Biblioteca
            </a>
        </div>
    </div>
</section>
@endsection
