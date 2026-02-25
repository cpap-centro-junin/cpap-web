@extends('layouts.app')

@section('title', 'Inicio - CPAP Región Centro')

@section('content')
<!-- Hero Section -->
<section class="hero" id="inicio">
    <div class="hero-overlay"></div>
    <div class="container">
        <div class="hero-content" data-aos="fade-up">
            <span class="hero-badge">{{ $config->hero_badge ?? 'Bienvenidos' }}</span>
            <h1 class="hero-title">{!! $config->hero_titulo ?? 'Colegio Profesional de<br><span class="gradient-text">Antropólogos del Perú</span>' !!}</h1>
            <p class="hero-subtitle">{{ $config->hero_subtitulo ?? 'Región Centro - Promoviendo la excelencia profesional y la investigación antropológica desde 1985' }}</p>
            <div class="hero-buttons">
                <a href="{{ $config->hero_btn1_url ?? '#colegiatura' }}" class="btn btn-primary btn-lg">
                    <i class="{{ $config->hero_btn1_icono ?? 'fas fa-user-plus' }}"></i>
                    {{ $config->hero_btn1_texto ?? 'Quiero Colegiarme' }}
                </a>
                <a href="{{ $config->hero_btn2_url ?? '#nosotros' }}" class="btn btn-outline-light btn-lg">
                    <i class="{{ $config->hero_btn2_icono ?? 'fas fa-info-circle' }}"></i>
                    {{ $config->hero_btn2_texto ?? 'Conocer Más' }}
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Banner Slider Section -->
<section class="banner-slider-section">
    <div class="banner-slider-wrapper" id="bannerSliderWrapper">
        <div class="banner-slider" id="bannerSlider">

            @forelse($slides as $slide)
            <!-- Slide: {{ $slide->titulo_final }} -->
            <div class="banner-slide">
                <img class="slide-bg"
                     src="{{ $slide->imagen_final }}"
                     alt="{{ $slide->titulo_final }}"
                     loading="lazy"
                     draggable="false"
                     width="1400" height="620">
                <div class="slide-overlay"></div>
                <div class="slide-content">
                    @if($slide->tag)
                    <span class="slide-tag">{{ $slide->tag }}</span>
                    @endif
                    <h3 class="slide-title">{!! $slide->titulo_final !!}</h3>
                    <div class="slide-divider"></div>
                    @if($slide->descripcion_final)
                    <p class="slide-text">{{ $slide->descripcion_final }}</p>
                    @endif
                    <a href="{{ $slide->boton_url_final }}" class="slide-btn">
                        <i class="fas fa-arrow-right"></i> {{ $slide->boton_texto }}
                    </a>
                </div>
            </div>
            @empty
            <!-- Slide por defecto si no hay slides configurados -->
            <div class="banner-slide">
                <img class="slide-bg"
                     src="{{ asset('images/banners/banner-colegiatura.png') }}"
                     alt="CPAP Región Centro"
                     loading="lazy"
                     draggable="false"
                     width="1400" height="620">
                <div class="slide-overlay"></div>
                <div class="slide-content">
                    <span class="slide-tag">Bienvenidos</span>
                    <h3 class="slide-title">CPAP<br>Región Centro</h3>
                    <div class="slide-divider"></div>
                    <p class="slide-text">Colegio Profesional de Antropólogos del Perú</p>
                    <a href="{{ url('/#nosotros') }}" class="slide-btn">
                        <i class="fas fa-arrow-right"></i> Conocer Más
                    </a>
                </div>
            </div>
            @endforelse

        </div>

        <!-- Controles de Navegación -->
        <button class="slider-control prev"
                id="sliderPrev"
                aria-label="Slide anterior">
            <i class="fas fa-chevron-left"></i>
        </button>
        <button class="slider-control next"
                id="sliderNext"
                aria-label="Siguiente slide">
            <i class="fas fa-chevron-right"></i>
        </button>

        <!-- Indicadores -->
        <div class="slider-indicators"
             id="sliderIndicators"
             role="tablist"
             aria-label="Seleccionar slide"></div>

        <!-- Barra de progreso del autoplay -->
        <div class="slider-progress">
            <div class="slider-progress-bar"></div>
        </div>

    </div>
</section>

<!-- ─── Orientaciones de la Antropología ─── -->
<section class="section-padding" id="orientaciones">
    <div class="container">

        <div class="section-header text-center" data-aos="fade-up">
            <span class="section-badge">Marco Conceptual</span>
            <h2 class="section-title">Orientaciones de la Antropología</h2>
            <p class="section-subtitle">
                Clasificación teórica que organiza el campo antropológico según dos dimensiones fundamentales de estudio
            </p>
        </div>

        <div class="antro-diagram" data-aos="fade-up" data-aos-delay="100">

            {{-- ── Barra superior: Antropología Cultural ── --}}
            <div class="antro-bar antro-bar-top">
                <i class="fas fa-people-group"></i>
                <span>Antropología Cultural</span>
            </div>

            {{-- ── Cuerpo: [label-izq] + [cuadrantes] + [label-der] ── --}}
            <div class="antro-body">

                {{-- Etiqueta izquierda (texto vertical) --}}
                <div class="antro-side-label antro-side-left">
                    <span>Orientación Histórica</span>
                </div>

                {{-- Área del cruce de cuadrantes --}}
                <div class="antro-cross-grid">

                    {{-- ── 4 Cuadrantes ── --}}

                    {{-- Q1: Cultural × Histórica --}}
                    <div class="antro-quad antro-q1" data-aos="zoom-in" data-aos-delay="150">
                        <div class="antro-circle-icon">
                            <img src="{{ asset('images/antropologia/antro-q1-cultural-historica.jpg') }}"
                                 alt="Origen y evolución de la cultura"
                                 onerror="this.parentElement.innerHTML='<i class=\'fas fa-landmark\'></i>'">
                        </div>
                        <div class="antro-qbox">
                            <p>Origen y evolución<br>de la cultura</p>
                        </div>
                    </div>

                    {{-- Q2: Cultural × Científica --}}
                    <div class="antro-quad antro-q2" data-aos="zoom-in" data-aos-delay="200">
                        <div class="antro-circle-icon">
                            <img src="{{ asset('images/antropologia/antro-q2-cultural-cientifica.jpg') }}"
                                 alt="Estructura y funciones de la cultura"
                                 onerror="this.parentElement.innerHTML='<i class=\'fas fa-users\'></i>'">
                        </div>
                        <div class="antro-qbox">
                            <p>Estructura y funciones<br>de la cultura</p>
                        </div>
                    </div>

                    {{-- Q3: Biológica × Histórica --}}
                    <div class="antro-quad antro-q3" data-aos="zoom-in" data-aos-delay="250">
                        <div class="antro-circle-icon">
                            <img src="{{ asset('images/antropologia/antro-q3-biologica-historica.jpg') }}"
                                 alt="Origen y evolución del hombre"
                                 onerror="this.parentElement.innerHTML='<i class=\'fas fa-bone\'></i>'">
                        </div>
                        <div class="antro-qbox">
                            <p>Origen y evolución<br>del hombre</p>
                        </div>
                    </div>

                    {{-- Q4: Biológica × Científica --}}
                    <div class="antro-quad antro-q4" data-aos="zoom-in" data-aos-delay="300">
                        <div class="antro-circle-icon">
                            <img src="{{ asset('images/antropologia/antro-q4-biologica-cientifica.jpg') }}"
                                 alt="Estructura y funciones corporales"
                                 onerror="this.parentElement.innerHTML='<i class=\'fas fa-dna\'></i>'">
                        </div>
                        <div class="antro-qbox">
                            <p>Estructura y funciones<br>corporales</p>
                        </div>
                    </div>

                    {{-- Etiquetas flotantes del eje vertical (en el cruce central) --}}
                    <div class="antro-center-tag antro-center-top">Orientación Cultural</div>
                    <div class="antro-center-tag antro-center-bottom">Orientación Biológica</div>

                </div>{{-- /antro-cross-grid --}}

                {{-- Etiqueta derecha (texto vertical) --}}
                <div class="antro-side-label antro-side-right">
                    <span>Orientación Científica</span>
                </div>

            </div>{{-- /antro-body --}}

            {{-- ── Barra inferior: Antropología Biológica ── --}}
            <div class="antro-bar antro-bar-bottom">
                <i class="fas fa-dna"></i>
                <span>Antropología Biológica</span>
            </div>

            <p class="antro-source">Fuente: <strong>A. Hoebel</strong></p>

        </div>{{-- /antro-diagram --}}
    </div>
</section>

<!-- Stats Section -->
<section class="stats-section">
    <div class="container">
        <div class="stats-grid">
            <div class="stat-card" data-aos="fade-up" data-aos-delay="100">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number" data-count="{{ $config->stat_colegiados ?? 1250 }}">0</h3>
                    <p class="stat-label">Colegiados</p>
                </div>
            </div>
            <div class="stat-card" data-aos="fade-up" data-aos-delay="200">
                <div class="stat-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number" data-count="{{ $config->stat_eventos ?? 150 }}">0</h3>
                    <p class="stat-label">Eventos Anuales</p>
                </div>
            </div>
            <div class="stat-card" data-aos="fade-up" data-aos-delay="300">
                <div class="stat-icon">
                    <i class="fas fa-award"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number" data-count="{{ $config->stat_años ?? 39 }}">0</h3>
                    <p class="stat-label">Años de Servicio</p>
                </div>
            </div>
            <div class="stat-card" data-aos="fade-up" data-aos-delay="400">
                <div class="stat-icon">
                    <i class="fas fa-book"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number" data-count="{{ $config->stat_publicaciones ?? 500 }}">0</h3>
                    <p class="stat-label">Publicaciones</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="section-padding" id="servicios">
    <div class="container">
        <div class="section-header text-center" data-aos="fade-up">
            <span class="section-badge">Nuestros Servicios</span>
            <h2 class="section-title">¿Qué Ofrecemos?</h2>
            <p class="section-subtitle">Servicios profesionales para nuestros colegiados y la comunidad</p>
        </div>

        <div class="services-grid">
            <div class="service-card" data-aos="fade-up" data-aos-delay="100">
                <div class="service-icon">
                    <i class="fas fa-user-tie"></i>
                </div>
                <h3>Colegiatura</h3>
                <p>Proceso de incorporación y actualización de colegiados con requisitos claros y transparentes.</p>
                <a href="#colegiatura" class="btn-text">
                    Ver Proceso <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            <div class="service-card" data-aos="fade-up" data-aos-delay="200">
                <div class="service-icon">
                    <i class="fas fa-certificate"></i>
                </div>
                <h3>Certificaciones</h3>
                <p>Emisión de certificados de habilitación profesional y constancias de colegiatura vigente.</p>
                <a href="{{ url('/#documentos') }}" class="btn-text">
                    Más Información <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            <div class="service-card" data-aos="fade-up" data-aos-delay="300">
                <div class="service-icon">
                    <i class="fas fa-briefcase"></i>
                </div>
                <h3>Bolsa de Trabajo</h3>
                <p>Publicación de oportunidades laborales y conexión con el sector público y privado.</p>
                <a href="{{ route('bolsa-trabajo') }}" class="btn-text">
                    Ver Ofertas <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            <div class="service-card" data-aos="fade-up" data-aos-delay="400">
                <div class="service-icon">
                    <i class="fas fa-book-open"></i>
                </div>
                <h3>Biblioteca Virtual</h3>
                <p>Acceso a recursos bibliográficos, investigaciones y publicaciones especializadas.</p>
                <a href="{{ route('biblioteca') }}" class="btn-text">
                    Explorar <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- News Section -->
<section class="section-padding bg-light" id="noticias">
    <div class="container">
        <div class="section-header text-center" data-aos="fade-up">
            <span class="section-badge">Actualidad</span>
            <h2 class="section-title">Últimas Noticias</h2>
            <p class="section-subtitle">Mantente informado sobre nuestras actividades y logros</p>
        </div>

        <div class="news-grid">
            <article class="news-card" data-aos="fade-up" data-aos-delay="100">
                <div class="news-image">
                    <img src="{{ asset('images/noticias/39-Aniversario.jpg') }}" alt="39 Aniversario CPAP">
                    <div class="news-category">Institucional</div>
                </div>
                <div class="news-content">
                    <div class="news-meta">
                        <span><i class="fas fa-calendar"></i> 15 Ene 2026</span>
                        <span><i class="fas fa-user"></i> CPAP Centro</span>
                    </div>
                    <h3>Celebramos 39 Años de Trayectoria Institucional</h3>
                    <p>Una fecha especial que marca casi cuatro décadas de compromiso con la antropología y el desarrollo profesional en la región centro.</p>
                    <a href="#" class="btn-text">Leer Más <i class="fas fa-arrow-right"></i></a>
                </div>
            </article>

            <article class="news-card" data-aos="fade-up" data-aos-delay="200">
                <div class="news-image">
                    <img src="{{ asset('images/noticias/Ceremonia-juramentacion.png') }}" alt="Ceremonia de Juramentación">
                    <div class="news-category">Colegiatura</div>
                </div>
                <div class="news-content">
                    <div class="news-meta">
                        <span><i class="fas fa-calendar"></i> 10 Ene 2026</span>
                        <span><i class="fas fa-user"></i> CPAP Centro</span>
                    </div>
                    <h3>Ceremonia de Juramentación de Nuevos Colegiados</h3>
                    <p>Con gran orgullo damos la bienvenida a los nuevos profesionales que se incorporan a nuestra institución.</p>
                    <a href="#" class="btn-text">Leer Más <i class="fas fa-arrow-right"></i></a>
                </div>
            </article>

            <article class="news-card" data-aos="fade-up" data-aos-delay="300">
                <div class="news-image">
                    <img src="{{ asset('images/banners/banner-colegiatura.png') }}" alt="Proceso de Colegiatura 2026">
                    <div class="news-category">Proceso</div>
                </div>
                <div class="news-content">
                    <div class="news-meta">
                        <span><i class="fas fa-calendar"></i> 02 Ene 2026</span>
                        <span><i class="fas fa-user"></i> CPAP Centro</span>
                    </div>
                    <h3>Proceso de Colegiatura 2026 Oficialmente Abierto</h3>
                    <p>Invitamos a todos los antropólogos egresados a iniciar su proceso de colegiatura. Requisitos disponibles en nuestra web.</p>
                    <a href="#colegiatura" class="btn-text">Ver Proceso <i class="fas fa-arrow-right"></i></a>
                </div>
            </article>
        </div>

        <div class="text-center" style="margin-top: 50px;" data-aos="fade-up">
            <a href="#" class="btn btn-outline">
                <i class="fas fa-newspaper"></i>
                Ver Todas las Noticias
            </a>
        </div>
    </div>
</section>

<!-- Events Section -->
<section class="section-padding" id="eventos">
    <div class="container">
        <div class="section-header text-center" data-aos="fade-up">
            <span class="section-badge">Agenda</span>
            <h2 class="section-title">Próximos Eventos</h2>
            <p class="section-subtitle">Participa en nuestras actividades académicas y profesionales</p>
        </div>

        <div class="events-timeline">
            <div class="event-item" data-aos="fade-right">
                <div class="event-content">
                    <h3>15 Feb - Taller de Metodología de Investigación Cualitativa</h3>
                    <p>Modalidad virtual. Inscripciones abiertas para colegiados.</p>
                    <div class="event-meta">
                        <span><i class="fas fa-clock"></i> 6:00 PM - 8:00 PM</span>
                        <span><i class="fas fa-map-marker-alt"></i> Zoom</span>
                    </div>
                </div>
            </div>

            <div class="event-item" data-aos="fade-right" data-aos-delay="100">
                <div class="event-content">
                    <h3>20 Feb - Conversatorio: Antropología y Desarrollo Sostenible</h3>
                    <p>Con la participación de destacados antropólogos de la región.</p>
                    <div class="event-meta">
                        <span><i class="fas fa-clock"></i> 7:00 PM - 9:00 PM</span>
                        <span><i class="fas fa-map-marker-alt"></i> Auditorio CPAP</span>
                    </div>
                </div>
            </div>

            <div class="event-item" data-aos="fade-right" data-aos-delay="200">
                <div class="event-content">
                    <h3>28 Feb - Asamblea General Ordinaria 2026</h3>
                    <p>Convocatoria a todos los colegiados hábiles. Agenda e informes disponibles.</p>
                    <div class="event-meta">
                        <span><i class="fas fa-clock"></i> 5:00 PM - 8:00 PM</span>
                        <span><i class="fas fa-map-marker-alt"></i> Local Institucional</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Membership Section -->
<section class="section-padding bg-light" id="colegiatura">
    <div class="container">
        <div class="section-header text-center" data-aos="fade-up">
            <span class="section-badge">Únete a Nosotros</span>
            <h2 class="section-title">Proceso de Colegiatura</h2>
            <p class="section-subtitle">Sigue estos pasos para formar parte de nuestra comunidad profesional</p>
        </div>

        <div class="membership-steps">
            <div class="step-card" data-aos="zoom-in" data-aos-delay="100">
                <div class="step-number">1</div>
                <div class="step-icon">
                    <i class="fas fa-file-alt"></i>
                </div>
                <h3>Requisitos</h3>
                <ul class="step-list">
                    <li>Título profesional de Antropólogo</li>
                    <li>DNI vigente (copia)</li>
                    <li>Certificado de estudios</li>
                    <li>Pago por derecho de inscripción</li>
                </ul>
            </div>

            <div class="step-card" data-aos="zoom-in" data-aos-delay="200">
                <div class="step-number">2</div>
                <div class="step-icon">
                    <i class="fas fa-upload"></i>
                </div>
                <h3>Presentación</h3>
                <ul class="step-list">
                    <li>Llenar formulario de inscripción</li>
                    <li>Adjuntar documentos escaneados</li>
                    <li>Enviar a secretaría</li>
                    <li>Esperar confirmación de recepción</li>
                </ul>
            </div>

            <div class="step-card" data-aos="zoom-in" data-aos-delay="300">
                <div class="step-number">3</div>
                <div class="step-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h3>Aprobación</h3>
                <ul class="step-list">
                    <li>Revisión de documentos</li>
                    <li>Verificación de requisitos</li>
                    <li>Aprobación por consejo directivo</li>
                    <li>Notificación de resultado</li>
                </ul>
            </div>

            <div class="step-card" data-aos="zoom-in" data-aos-delay="400">
                <div class="step-number">4</div>
                <div class="step-icon">
                    <i class="fas fa-gavel"></i>
                </div>
                <h3>Juramentación</h3>
                <ul class="step-list">
                    <li>Ceremonia de juramentación</li>
                    <li>Entrega de certificado</li>
                    <li>Registro en padrón nacional</li>
                    <li>Activación de beneficios</li>
                </ul>
            </div>
        </div>

        <div class="text-center" style="margin-top: 50px;" data-aos="fade-up">
            <a href="{{ url('/#contacto') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-envelope"></i>
                Iniciar Proceso de Colegiatura
            </a>
        </div>
    </div>
</section>


@if(isset($anuncio) && $anuncio)
<div id="popupAnuncio"
     style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.78);z-index:99999;align-items:center;justify-content:center;padding:20px;"
     onclick="if(event.target===this)cerrarPopup()">
    <div style="position:relative;max-width:580px;width:100%;border-radius:14px;overflow:hidden;box-shadow:0 20px 60px rgba(0,0,0,0.5);">
        <button onclick="cerrarPopup()"
                style="position:absolute;top:10px;right:10px;width:36px;height:36px;background:rgba(0,0,0,0.65);color:white;border:none;border-radius:50%;font-size:18px;cursor:pointer;display:flex;align-items:center;justify-content:center;line-height:1;z-index:2;"
                aria-label="Cerrar anuncio">
            &times;
        </button>
        <img src="{{ $anuncio->imagen }}"
             alt="Anuncio"
             style="width:100%;display:block;">
    </div>
</div>
<script>
(function(){
    if (!sessionStorage.getItem('popup_dismissed_{{ $anuncio->id }}')) {
        document.getElementById('popupAnuncio').style.display = 'flex';
    }
})();
function cerrarPopup() {
    document.getElementById('popupAnuncio').style.display = 'none';
    sessionStorage.setItem('popup_dismissed_{{ $anuncio->id }}', '1');
}
</script>
@endif
@endsection

@push('scripts')
<script>
// Contador animado para las estadísticas
document.addEventListener('DOMContentLoaded', function() {
    const stats = document.querySelectorAll('.stat-number');
    const statsSection = document.querySelector('.stats-section');
    let animated = false;

    function animateNumber(element) {
        const target = parseInt(element.getAttribute('data-count'));
        const duration = 2000;
        const increment = target / (duration / 16);
        let current = 0;

        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                element.textContent = target.toLocaleString();
                clearInterval(timer);
            } else {
                element.textContent = Math.floor(current).toLocaleString();
            }
        }, 16);
    }

    // Observer para iniciar la animación cuando la sección sea visible
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting && !animated) {
                animated = true;
                stats.forEach((stat, index) => {
                    setTimeout(() => {
                        animateNumber(stat);
                    }, index * 100);
                });
            }
        });
    }, { threshold: 0.5 });

    if (statsSection) {
        observer.observe(statsSection);
    }
});
</script>
@endpush
