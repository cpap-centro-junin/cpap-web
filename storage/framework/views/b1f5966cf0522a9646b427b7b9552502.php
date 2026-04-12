<?php $__env->startSection('title', 'Colegio de Antropólogos del Perú - Región Centro | Inicio'); ?>
<?php $__env->startSection('seo_title', 'Colegio de Antropólogos del Perú - Región Centro | CPAP Oficial Huancayo'); ?>
<?php $__env->startSection('seo_description', 'Colegio Profesional de Antropólogos del Perú - Región Centro. Colegiatura, habilitación profesional, certificaciones, directorio de antropólogos colegiados, eventos académicos y bolsa de trabajo en Huancayo, Junín.'); ?>
<?php $__env->startSection('seo_keywords', 'colegio de antropólogos, colegio de antropólogos del perú, CPAP, antropólogos perú, colegio profesional antropología, colegiatura antropología, antropólogos huancayo, antropólogos junín, habilitación profesional, certificado antropólogo, región centro'); ?>
<?php $__env->startSection('seo_canonical', url('/')); ?>
<?php $__env->startSection('seo_image', asset('images/logos/cpap-logo.jpg')); ?>

<?php $__env->startSection('content'); ?>
<!-- Hero Section -->
<section class="hero hero--home" id="inicio" 
         <?php if($config->hero_imagen): ?>
         style="background-image: url('<?php echo e($config->heroImagenUrl); ?>');"
         <?php endif; ?>>
    <div class="hero-overlay"></div>
    <div class="container">
        <div class="hero-content" data-aos="fade-right">
            <span class="hero-badge"><?php echo e($config->hero_badge ?? 'Bienvenidos'); ?></span>
            <h1 class="hero-title"><?php echo $config->hero_titulo ?? 'Colegio Profesional de<br><span class="gradient-text">Antropólogos del Perú</span>'; ?></h1>
            <p class="hero-subtitle"><?php echo e($config->hero_subtitulo ?? 'Región Centro - Promoviendo la excelencia profesional y la investigación antropológica desde 1985'); ?></p>
            <div class="hero-buttons">
                <a href="<?php echo e($config->hero_btn1_url ?? '#colegiatura'); ?>" class="btn btn-primary btn-lg">
                    <i class="<?php echo e($config->hero_btn1_icono ?? 'fas fa-user-plus'); ?>"></i>
                    <?php echo e($config->hero_btn1_texto ?? 'Quiero Colegiarme'); ?>

                </a>
                <a href="<?php echo e($config->hero_btn2_url ?? '#nosotros'); ?>" class="btn btn-outline-light btn-lg">
                    <i class="<?php echo e($config->hero_btn2_icono ?? 'fas fa-info-circle'); ?>"></i>
                    <?php echo e($config->hero_btn2_texto ?? 'Conocer Más'); ?>

                </a>
            </div>
        </div>
    </div>
</section>

<!-- Banner Slider Section -->
<section class="banner-slider-section">
    <div class="banner-slider-wrapper" id="bannerSliderWrapper">
        <div class="banner-slider" id="bannerSlider">

            <?php $__empty_1 = true; $__currentLoopData = $slides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <!-- Slide: <?php echo e($slide->titulo_final); ?> -->
            <div class="banner-slide">
                <img class="slide-bg"
                     src="<?php echo e($slide->imagen_final); ?>"
                     alt="<?php echo e($slide->titulo_final); ?>"
                     loading="lazy"
                     draggable="false"
                     width="1400" height="620">
                <div class="slide-overlay"></div>
                <div class="slide-content">
                    <?php if($slide->tag): ?>
                    <span class="slide-tag"><?php echo e($slide->tag); ?></span>
                    <?php endif; ?>
                    <h3 class="slide-title"><?php echo $slide->titulo_final; ?></h3>
                    <div class="slide-divider"></div>
                    <?php if($slide->descripcion_final): ?>
                    <p class="slide-text"><?php echo e($slide->descripcion_final); ?></p>
                    <?php endif; ?>
                    <a href="<?php echo e($slide->boton_url_final); ?>" class="slide-btn">
                        <i class="fas fa-arrow-right"></i> <?php echo e($slide->boton_texto); ?>

                    </a>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <!-- Slide por defecto si no hay slides configurados -->
            <div class="banner-slide">
                <img class="slide-bg"
                     src="<?php echo e(asset('images/banners/banner-colegiatura.png')); ?>"
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
                    <a href="<?php echo e(url('/#nosotros')); ?>" class="slide-btn">
                        <i class="fas fa-arrow-right"></i> Conocer Más
                    </a>
                </div>
            </div>
            <?php endif; ?>

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

            
            <div class="antro-bar antro-bar-top">
                <i class="fas fa-people-group"></i>
                <span>Antropología Cultural</span>
            </div>

            
            <div class="antro-body">

                
                <div class="antro-side-label antro-side-left">
                    <span>Orientación Histórica</span>
                </div>

                
                <div class="antro-cross-grid">

                    

                    
                    <div class="antro-quad antro-q1" data-aos="zoom-in" data-aos-delay="150">
                        <div class="antro-circle-icon">
                            <img src="<?php echo e(asset('images/antropologia/antro-q1-cultural-historica.jpg')); ?>"
                                 alt="Origen y evolución de la cultura"
                                 onerror="this.parentElement.innerHTML='<i class=\'fas fa-landmark\'></i>'">
                        </div>
                        <div class="antro-qbox">
                            <p>Origen y evolución<br>de la cultura</p>
                        </div>
                    </div>

                    
                    <div class="antro-quad antro-q2" data-aos="zoom-in" data-aos-delay="200">
                        <div class="antro-circle-icon">
                            <img src="<?php echo e(asset('images/antropologia/antro-q2-cultural-cientifica.jpg')); ?>"
                                 alt="Estructura y funciones de la cultura"
                                 onerror="this.parentElement.innerHTML='<i class=\'fas fa-users\'></i>'">
                        </div>
                        <div class="antro-qbox">
                            <p>Estructura y funciones<br>de la cultura</p>
                        </div>
                    </div>

                    
                    <div class="antro-quad antro-q3" data-aos="zoom-in" data-aos-delay="250">
                        <div class="antro-circle-icon">
                            <img src="<?php echo e(asset('images/antropologia/antro-q3-biologica-historica.jpg')); ?>"
                                 alt="Origen y evolución del hombre"
                                 onerror="this.parentElement.innerHTML='<i class=\'fas fa-bone\'></i>'">
                        </div>
                        <div class="antro-qbox">
                            <p>Origen y evolución<br>del hombre</p>
                        </div>
                    </div>

                    
                    <div class="antro-quad antro-q4" data-aos="zoom-in" data-aos-delay="300">
                        <div class="antro-circle-icon">
                            <img src="<?php echo e(asset('images/antropologia/antro-q4-biologica-cientifica.jpg')); ?>"
                                 alt="Estructura y funciones corporales"
                                 onerror="this.parentElement.innerHTML='<i class=\'fas fa-dna\'></i>'">
                        </div>
                        <div class="antro-qbox">
                            <p>Estructura y funciones<br>corporales</p>
                        </div>
                    </div>

                    
                    <div class="antro-center-tag antro-center-top">Orientación Cultural</div>
                    <div class="antro-center-tag antro-center-bottom">Orientación Biológica</div>

                </div>

                
                <div class="antro-side-label antro-side-right">
                    <span>Orientación Científica</span>
                </div>

            </div>

            
            <div class="antro-bar antro-bar-bottom">
                <i class="fas fa-dna"></i>
                <span>Antropología Biológica</span>
            </div>

            <p class="antro-source">Fuente: <strong>A. Hoebel</strong></p>

        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="stats-section" id="nosotros">
    <div class="container">
        <div class="stats-grid">
            <div class="stat-card" data-aos="fade-up" data-aos-delay="100">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number" data-count="<?php echo e($config->stat_colegiados ?? 1250); ?>">0</h3>
                    <p class="stat-label">Colegiados</p>
                </div>
            </div>
            <div class="stat-card" data-aos="fade-up" data-aos-delay="200">
                <div class="stat-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number" data-count="<?php echo e($config->stat_eventos ?? 150); ?>">0</h3>
                    <p class="stat-label">Eventos Anuales</p>
                </div>
            </div>
            <div class="stat-card" data-aos="fade-up" data-aos-delay="300">
                <div class="stat-icon">
                    <i class="fas fa-award"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number" data-count="<?php echo e($config->stat_años ?? 39); ?>">0</h3>
                    <p class="stat-label">Años de Servicio</p>
                </div>
            </div>
            <div class="stat-card" data-aos="fade-up" data-aos-delay="400">
                <div class="stat-icon">
                    <i class="fas fa-book"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number" data-count="<?php echo e($config->stat_publicaciones ?? 500); ?>">0</h3>
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
                <a href="<?php echo e(url('/colegiatura')); ?>" class="btn-text">
                    Ver Proceso <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            <div class="service-card" data-aos="fade-up" data-aos-delay="200">
                <div class="service-icon">
                    <i class="fas fa-certificate"></i>
                </div>
                <h3>Certificaciones</h3>
                <p>Emisión de certificados de habilitación profesional y constancias de colegiatura vigente.</p>
                <a href="<?php echo e(url('/colegiados')); ?>" class="btn-text">
                    Más Información <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            <div class="service-card" data-aos="fade-up" data-aos-delay="300">
                <div class="service-icon">
                    <i class="fas fa-briefcase"></i>
                </div>
                <h3>Bolsa de Trabajo</h3>
                <p>Publicación de oportunidades laborales y conexión con el sector público y privado.</p>
                <a href="<?php echo e(route('bolsa-trabajo')); ?>" class="btn-text">
                    Ver Ofertas <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            <div class="service-card" data-aos="fade-up" data-aos-delay="400">
                <div class="service-icon">
                    <i class="fas fa-book-open"></i>
                </div>
                <h3>Biblioteca Virtual</h3>
                <p>Acceso a recursos bibliográficos, investigaciones y publicaciones especializadas.</p>
                <a href="<?php echo e(route('biblioteca')); ?>" class="btn-text">
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
            <?php $__empty_1 = true; $__currentLoopData = $noticias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $noticia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <article class="news-card" data-aos="fade-up" data-aos-delay="<?php echo e($loop->index * 100); ?>">
                <div class="news-image">
                    <?php if($noticia->imagen): ?>
                    <img src="<?php echo e($noticia->imagen); ?>" alt="<?php echo e($noticia->titulo); ?>">
                    <?php else: ?>
                    <div style="width:100%;height:100%;background:linear-gradient(135deg,var(--primary),var(--primary-dark,#6b0f2a));display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-newspaper" style="font-size:40px;color:rgba(255,255,255,0.4);"></i>
                    </div>
                    <?php endif; ?>
                    <?php if($noticia->categoria): ?>
                    <div class="news-category"><?php echo e($noticia->categoria); ?></div>
                    <?php endif; ?>
                </div>
                <div class="news-content">
                    <div class="news-meta">
                        <span><i class="fas fa-calendar"></i> <?php echo e($noticia->created_at->format('d M Y')); ?></span>
                        <span><i class="fas fa-user"></i> CPAP Centro</span>
                    </div>
                    <h3><?php echo e($noticia->titulo); ?></h3>
                    <p><?php echo e(Str::limit($noticia->resumen ?? $noticia->contenido ?? '', 120)); ?></p>
                    <a href="<?php echo e(route('noticias.show', $noticia)); ?>" class="btn-text">Leer Más <i class="fas fa-arrow-right"></i></a>
                </div>
            </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="news-card" data-aos="fade-up" style="grid-column:1/-1;text-align:center;padding:48px;">
                <i class="fas fa-newspaper" style="font-size:40px;color:var(--medium-gray);margin-bottom:12px;display:block;"></i>
                <p style="color:var(--medium-gray);">Próximamente publicaremos noticias institucionales.</p>
            </div>
            <?php endif; ?>
        </div>

        <div class="text-center" style="margin-top: 50px;" data-aos="fade-up">
            <a href="<?php echo e(route('noticias.index')); ?>" class="btn btn-outline">
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
            <?php $__empty_1 = true; $__currentLoopData = $eventos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $evento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="event-item" data-aos="fade-right" data-aos-delay="<?php echo e($loop->index * 100); ?>">
                <div class="event-content">
                    <h3><?php echo e(\Carbon\Carbon::parse($evento->fecha_inicio)->format('d M')); ?> - <?php echo e($evento->titulo); ?></h3>
                    <p><?php echo e(Str::limit($evento->resumen ?? $evento->descripcion ?? '', 100)); ?></p>
                    <div class="event-meta">
                        <?php if($evento->hora_inicio): ?>
                        <span><i class="fas fa-clock"></i> <?php echo e(\Carbon\Carbon::createFromTimeString($evento->hora_inicio)->format('g:i A')); ?></span>
                        <?php endif; ?>
                        <?php if($evento->lugar): ?>
                        <span><i class="fas fa-map-marker-alt"></i> <?php echo e($evento->lugar); ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="event-item" data-aos="fade-right">
                <div class="event-content" style="text-align:center;padding:32px;">
                    <i class="fas fa-calendar-alt" style="font-size:36px;color:var(--medium-gray);margin-bottom:10px;display:block;"></i>
                    <p style="color:var(--medium-gray);">No hay eventos próximos programados. Revisa nuevamente pronto.</p>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Galería Institucional Preview -->
<?php if(isset($galeriaDestacadas) && $galeriaDestacadas->count() > 0): ?>
<section class="section-padding" id="galeria-preview">
    <div class="container">
        <div class="section-header text-center" data-aos="fade-up">
            <span class="section-badge">Nuestros Momentos</span>
            <h2 class="section-title">Galería Institucional</h2>
            <p class="section-subtitle">Revive los momentos más importantes de nuestra comunidad profesional</p>
        </div>

        <div class="galeria-preview-grid" data-aos="fade-up" data-aos-delay="100">
            <?php $__currentLoopData = $galeriaDestacadas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="galeria-preview-item" data-aos="zoom-in" data-aos-delay="<?php echo e($loop->index * 80); ?>">
                <img src="<?php echo e($img->imagen); ?>" alt="<?php echo e($img->titulo); ?>" loading="lazy">
                <div class="galeria-preview-overlay">
                    <?php if($img->categoria): ?>
                    <span class="galeria-preview-categoria"><?php echo e($img->categoria); ?></span>
                    <?php endif; ?>
                    <h4><?php echo e($img->titulo); ?></h4>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="text-center" style="margin-top: 50px;" data-aos="fade-up" data-aos-delay="200">
            <a href="<?php echo e(route('galeria')); ?>" class="btn btn-outline">
                <i class="fas fa-images"></i>
                Ver Galería Completa
            </a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Membership Section -->
<section class="section-padding bg-light" id="colegiatura">
    <div class="container">
        <div class="section-header text-center" data-aos="fade-up">
            <span class="section-badge">Únete a Nosotros</span>
            <h2 class="section-title">Proceso de Colegiatura</h2>
            <p class="section-subtitle">12 pasos para formar parte de nuestra comunidad profesional</p>
        </div>

        <!-- Lista de 12 Pasos Compacta -->
        <div class="home-steps-grid" data-aos="fade-up" data-aos-delay="100">

            <!-- Paso 1 -->
            <div class="home-step">
                <div class="home-step-number">01</div>
                <div class="home-step-content">
                    <h4>Descargar formatos de inscripción</h4>
                    <p>Formatos oficiales web Región Centro o Nacional</p>
                </div>
            </div>

            <!-- Paso 2 -->
            <div class="home-step">
                <div class="home-step-number">02</div>
                <div class="home-step-content">
                    <h4>Rellenar y escanear documentos</h4>
                    <p>Solicitud CPAP, ficha y declaración jurada</p>
                </div>
            </div>

            <!-- Paso 3 -->
            <div class="home-step">
                <div class="home-step-number">03</div>
                <div class="home-step-content">
                    <h4>Constancia SUNEDU</h4>
                    <p>Certificado del Título Profesional</p>
                </div>
            </div>

            <!-- Paso 4 -->
            <div class="home-step">
                <div class="home-step-number">04</div>
                <div class="home-step-content">
                    <h4>Título Profesional</h4>
                    <p>Fedateado por universidad o legalizado</p>
                </div>
            </div>

            <!-- Paso 5 -->
            <div class="home-step">
                <div class="home-step-number">05</div>
                <div class="home-step-content">
                    <h4>Copia de DNI</h4>
                    <p>Documento Nacional de Identidad (ambas caras)</p>
                </div>
            </div>

            <!-- Paso 6 - DESTACADO -->
            <div class="home-step home-step--payment">
                <div class="home-step-number home-step-number--gold">06</div>
                <div class="home-step-content">
                    <h4>Depósito Región Centro – S/. 490.00</h4>
                    <p><i class="fas fa-university"></i> <strong>Caja Huancayo:</strong> 1070352110004988965</p>
                </div>
            </div>

            <!-- Paso 7 -->
            <div class="home-step">
                <div class="home-step-number">07</div>
                <div class="home-step-content">
                    <h4>Enviar voucher regional</h4>
                    <p><i class="fab fa-whatsapp"></i> WhatsApp <strong>943 667 317</strong></p>
                </div>
            </div>

            <!-- Paso 8 - DESTACADO -->
            <div class="home-step home-step--payment">
                <div class="home-step-number home-step-number--gold">08</div>
                <div class="home-step-content">
                    <h4>Depósito Nacional – S/. 210.00</h4>
                    <p><i class="fas fa-university"></i> <strong>BCP:</strong> 21508875589036</p>
                </div>
            </div>

            <!-- Paso 9 -->
            <div class="home-step">
                <div class="home-step-number">09</div>
                <div class="home-step-content">
                    <h4>Enviar voucher nacional</h4>
                    <p><i class="fab fa-whatsapp"></i> WhatsApp <strong>943 667 317</strong></p>
                </div>
            </div>

            <!-- Paso 10 -->
            <div class="home-step">
                <div class="home-step-number">10</div>
                <div class="home-step-content">
                    <h4>Fotografía digital</h4>
                    <p>Tamaño pasaporte, vestido formal (JPG)</p>
                </div>
            </div>

            <!-- Paso 11 -->
            <div class="home-step">
                <div class="home-step-number">11</div>
                <div class="home-step-content">
                    <h4>Firma digital</h4>
                    <p>Firma escaneada en formato JPG</p>
                </div>
            </div>

            <!-- Paso 12 - DESTACADO FINAL -->
            <div class="home-step">
                <div class="home-step-number">12</div>
                <div class="home-step-content">
                    <h4>Enviar documentación completa</h4>
                    <p><i class="fas fa-envelope"></i> <strong>cpap.rc@gmail.com</strong> (PDF: pasos 2,3,4,5,7,9 + JPG: 10,11)</p>
                </div>
            </div>

        </div>

        <!-- Total y Botones -->
        <div class="home-colegiatura-footer" data-aos="fade-up" data-aos-delay="200">
            <div class="home-total-box">
                <div class="total-label">Inversión Total</div>
                <div class="total-amount">S/. 700.00</div>
                <div class="total-breakdown">S/. 490 (Regional) + S/. 210 (Nacional)</div>
            </div>

            <div class="home-cta-buttons">
                <a href="<?php echo e(asset('assets/documents/proceso-colegiacion.pdf')); ?>" target="_blank" class="btn-pdf">
                    <i class="fas fa-file-pdf"></i>
                    Descargar Guía Completa
                </a>
                <a href="<?php echo e(route('colegiatura.index')); ?>" class="btn btn-primary btn-lg">
                    <i class="fas fa-list-ol"></i>
                    Ver Detalles Ampliados
                </a>
                <a href="<?php echo e(url('/contacto')); ?>" class="btn btn-outline btn-lg">
                    <i class="fas fa-question-circle"></i>
                    ¿Tienes Dudas?
                </a>
            </div>
        </div>
    </div>
</section>


<?php if(isset($anuncios) && $anuncios->isNotEmpty()): ?>

<div id="anunciosModal" class="anuncios-modal" onclick="if(event.target===this) cerrarAnuncios()">
    <div class="anuncios-container">
        <div class="anuncios-slider-wrapper" id="anunciosSliderWrapper">
            <div class="anuncios-slider" id="anunciosSlider">
                <?php $__currentLoopData = $anuncios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $anuncio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="anuncio-slide" data-index="<?php echo e($index); ?>">
                    <img src="<?php echo e($anuncio->imagen); ?>" 
                         alt="<?php echo e($anuncio->titulo); ?>" 
                         draggable="false"
                         loading="lazy">
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        
        <button class="anuncios-close" onclick="cerrarAnuncios()" aria-label="Cerrar anuncios">
            <i class="fas fa-times"></i>
        </button>

        <?php if($anuncios->count() > 1): ?>
        
        <button class="anuncios-nav anuncios-prev" id="anunciosPrev" aria-label="Anterior">
            <i class="fas fa-chevron-left"></i>
        </button>
        <button class="anuncios-nav anuncios-next" id="anunciosNext" aria-label="Siguiente">
            <i class="fas fa-chevron-right"></i>
        </button>

        
        <div class="anuncios-indicators" id="anunciosIndicators"></div>

        
        <div class="anuncios-counter" id="anunciosCounter">
            <span id="anunciosCurrent">1</span> / <span id="anunciosTotal"><?php echo e($anuncios->count()); ?></span>
        </div>
        <?php endif; ?>
    </div>
</div>

<script>
// Mostrar modal si no se ha cerrado en esta sesión
(function(){
    if (!sessionStorage.getItem('anuncios_dismissed')) {
        document.getElementById('anunciosModal').classList.add('active');
    }
})();

// Función para cerrar anuncios
function cerrarAnuncios() {
    const modal = document.getElementById('anunciosModal');
    modal.classList.remove('active');
    sessionStorage.setItem('anuncios_dismissed', '1');
}
</script>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<?php echo app('Illuminate\Foundation\Vite')(['resources/css/anuncios-slider.css']); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<?php echo app('Illuminate\Foundation\Vite')(['resources/js/anuncios-slider.js']); ?>
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
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\cpap-web\resources\views/home.blade.php ENDPATH**/ ?>