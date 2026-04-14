<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <?php
        $siteName = 'Colegio de Antropólogos del Perú - Región Centro';
        $defaultTitle = 'Colegio de Antropólogos del Perú - Región Centro | CPAP Oficial';
        $defaultDescription = 'Colegio Profesional de Antropólogos del Perú - Región Centro. Colegiatura, habilitación profesional, certificaciones, eventos académicos, bolsa de trabajo y directorio de antropólogos colegiados en Huancayo y Junín.';
        $defaultKeywords = 'colegio de antropólogos, colegio de antropólogos del perú, antropólogos perú, CPAP, colegio profesional antropología, colegiatura antropología, antropólogos huancayo, antropólogos junín, habilitación profesional antropología, certificado de habilitación antropólogo, región centro perú';

        $seoTitle = trim($__env->yieldContent('seo_title')) ?: $defaultTitle;
        $seoDescription = trim($__env->yieldContent('seo_description')) ?: $defaultDescription;
        $seoKeywords = trim($__env->yieldContent('seo_keywords')) ?: $defaultKeywords;
        $seoImage = trim($__env->yieldContent('seo_image')) ?: asset('images/logos/cpap-logo.jpg');
        $seoCanonical = trim($__env->yieldContent('seo_canonical')) ?: url()->current();
        $seoRobots = trim($__env->yieldContent('seo_robots')) ?: 'index,follow,max-image-preview:large,max-snippet:-1,max-video-preview:-1';

        // Schema.org - Organización Profesional Completa
        $organizationSchema = [
            '@context' => 'https://schema.org',
            '@type' => ['Organization', 'ProfessionalService'],
            '@id' => url('/') . '#organization',
            'name' => 'Colegio Profesional de Antropólogos del Perú - Región Centro',
            'alternateName' => ['CPAP Región Centro', 'Colegio de Antropólogos del Perú', 'CPAP RC'],
            'url' => url('/'),
            'logo' => [
                '@type' => 'ImageObject',
                'url' => asset('images/logos/cpap-logo.jpg'),
                'width' => 512,
                'height' => 512
            ],
            'image' => asset('images/logos/cpap-logo.jpg'),
            'description' => 'Institución oficial que agremia a los profesionales antropólogos de la Región Centro del Perú. Brindamos colegiatura, habilitación profesional, certificaciones y desarrollo profesional continuo.',
            'foundingDate' => '1985',
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => 'Jr. Loreto 363',
                'addressLocality' => 'Huancayo',
                'addressRegion' => 'Junín',
                'postalCode' => '12001',
                'addressCountry' => 'PE'
            ],
            'geo' => [
                '@type' => 'GeoCoordinates',
                'latitude' => '-12.0651',
                'longitude' => '-75.2049'
            ],
            'contactPoint' => [
                '@type' => 'ContactPoint',
                'telephone' => '+51-943-667-317',
                'contactType' => 'customer service',
                'email' => 'cpap.rc@gmail.com',
                'availableLanguage' => 'Spanish'
            ],
            'sameAs' => [
                'https://web.facebook.com/AntropologosCentro'
            ],
            'areaServed' => [
                '@type' => 'AdministrativeArea',
                'name' => 'Región Centro del Perú (Junín, Huancavelica, Pasco, Ayacucho)'
            ],
            'serviceType' => ['Colegiatura profesional', 'Habilitación profesional', 'Certificaciones', 'Capacitación', 'Bolsa de trabajo'],
            'priceRange' => 'S/. 700'
        ];

        // Schema.org - WebSite con SearchAction
        $websiteSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            '@id' => url('/') . '#website',
            'name' => 'Colegio de Antropólogos del Perú - Región Centro',
            'alternateName' => 'CPAP Región Centro',
            'url' => url('/'),
            'description' => 'Portal oficial del Colegio Profesional de Antropólogos del Perú - Región Centro',
            'publisher' => [
                '@id' => url('/') . '#organization'
            ],
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => [
                    '@type' => 'EntryPoint',
                    'urlTemplate' => url('/colegiados') . '?q={search_term_string}'
                ],
                'query-input' => 'required name=search_term_string'
            ],
            'inLanguage' => 'es-PE'
        ];

        // Schema.org - Breadcrumb dinámico
        $breadcrumbItems = [];
        $breadcrumbItems[] = ['@type' => 'ListItem', 'position' => 1, 'name' => 'Inicio', 'item' => url('/')];

        $currentRouteName = Route::currentRouteName();
        $breadcrumbMap = [
            'nosotros.mision-vision' => ['Nosotros', 'Misión y Visión'],
            'nosotros.historia' => ['Nosotros', 'Historia'],
            'nosotros.consejo-directivo' => ['Nosotros', 'Consejo Directivo'],
            'nosotros.normativa-legal' => ['Nosotros', 'Normativa Legal'],
            'noticias.index' => ['Noticias'],
            'eventos.index' => ['Eventos'],
            'colegiados.index' => ['Directorio de Colegiados'],
            'colegiatura.index' => ['Proceso de Colegiatura'],
            'biblioteca' => ['Biblioteca Virtual'],
            'bolsa-trabajo' => ['Bolsa de Trabajo'],
            'galeria' => ['Galería Institucional'],
            'contacto.index' => ['Contacto'],
        ];

        if (isset($breadcrumbMap[$currentRouteName])) {
            $pos = 2;
            foreach ($breadcrumbMap[$currentRouteName] as $name) {
                $breadcrumbItems[] = ['@type' => 'ListItem', 'position' => $pos, 'name' => $name];
                $pos++;
            }
        }

        $breadcrumbSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $breadcrumbItems
        ];
    ?>

    <title><?php echo e($seoTitle); ?></title>

    <!-- SEO Básico -->
    <meta name="description" content="<?php echo e($seoDescription); ?>">
    <meta name="keywords" content="<?php echo e($seoKeywords); ?>">
    <meta name="robots" content="<?php echo e($seoRobots); ?>">
    <meta name="author" content="Colegio Profesional de Antropólogos del Perú - Región Centro">
    <meta name="geo.region" content="PE-JUN">
    <meta name="geo.placename" content="Huancayo, Junín, Perú">
    <meta name="geo.position" content="-12.0651;-75.2049">
    <meta name="ICBM" content="-12.0651, -75.2049">
    <link rel="canonical" href="<?php echo e($seoCanonical); ?>">

    <!-- Open Graph -->
    <meta property="og:locale" content="es_PE">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="<?php echo e($siteName); ?>">
    <meta property="og:title" content="<?php echo e($seoTitle); ?>">
    <meta property="og:description" content="<?php echo e($seoDescription); ?>">
    <meta property="og:url" content="<?php echo e($seoCanonical); ?>">
    <meta property="og:image" content="<?php echo e($seoImage); ?>">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo e($seoTitle); ?>">
    <meta name="twitter:description" content="<?php echo e($seoDescription); ?>">
    <meta name="twitter:image" content="<?php echo e($seoImage); ?>">

    <?php if(config('services.google.site_verification')): ?>
    <meta name="google-site-verification" content="<?php echo e(config('services.google.site_verification')); ?>">
    <?php endif; ?>
    
    <!-- Favicon -->
    <link rel="icon" type="image/jpeg" href="<?php echo e(asset('images/logos/cpap-logo.jpg')); ?>">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800;900&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Vite Assets -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

    <?php if(config('services.google.analytics_id')): ?>
    <!-- Google Analytics 4 -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo e(config('services.google.analytics_id')); ?>"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());
        gtag('config', '<?php echo e(config('services.google.analytics_id')); ?>');
    </script>
    <?php endif; ?>

    <!-- Datos estructurados Schema.org -->
    <script type="application/ld+json"><?php echo json_encode($organizationSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT); ?></script>
    <script type="application/ld+json"><?php echo json_encode($websiteSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT); ?></script>
    <script type="application/ld+json"><?php echo json_encode($breadcrumbSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT); ?></script>
    <?php echo $__env->yieldContent('schema'); ?>
    
    
    <?php
        $disenoConfig = \App\Models\ConfiguracionDiseno::obtener();
    ?>
    <style>
        <?php echo $disenoConfig->generarCSSVariables(); ?>

        
        /* ========================================== */
        /* APLICAR COLORES PERSONALIZADOS */
        /* ========================================== */
        
        /* Body */
        body {
            background-color: var(--bg-body);
        }
        
        /* ========================================== */
        /* NAVBAR - Aplicar fondo personalizado */
        /* ========================================== */
        .navbar {
            background: var(--navbar-bg) !important;
        }
        
        /* Enlaces del navbar - Solo color base, NO sobrescribir active/hover */
        .navbar-nav .nav-link:not(.active):not(:hover),
        .navbar-menu .nav-link:not(.active):not(:hover) {
            color: var(--navbar-text) !important;
        }
        
        /* Enlaces de dropdown - Color base */
        .dropdown-menu li a:not(.active):not(:hover) {
            color: var(--navbar-text) !important;
        }
        
        /* Mantener los estados active y hover con color primary (rojo) */
        .navbar-nav .nav-link.active,
        .navbar-nav .nav-link:hover,
        .dropdown-menu li a.active,
        .dropdown-menu li a:hover {
            color: var(--primary) !important;
        }
        
        /* Íconos de los dropdowns también en primary cuando están activos/hover */
        .dropdown-menu li a.active i,
        .dropdown-menu li a:hover i {
            color: var(--primary) !important;
        }
        
        /* Botones CTA del navbar - Mantener texto blanco */
        .navbar-cta .btn,
        .navbar-cta .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark)) !important;
            color: #FFFFFF !important;
            border: none !important;
        }
        
        .navbar-cta .btn:hover,
        .navbar-cta .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-dark), var(--primary)) !important;
            color: #FFFFFF !important;
        }
        
        /* ========================================== */
        /* FOOTER - Colores personalizados */
        /* ========================================== */
        .footer {
            background: var(--footer-bg) !important;
            color: var(--footer-text) !important;
        }
        
        .footer a {
            color: var(--footer-text) !important;
            opacity: 0.9;
        }
        
        .footer a:hover {
            opacity: 1;
        }
        
        /* ========================================== */
        /* BACKGROUNDS GENERALES */
        /* ========================================== */
        .bg-light-gray,
        .section-padding.bg-light {
            background-color: var(--bg-section-alt) !important;
        }
    </style>
    
    <?php echo $__env->yieldContent('styles'); ?>
</head>
<body class="app-layout">
    <!-- Navbar Component -->
    <?php if (isset($component)) { $__componentOriginala591787d01fe92c5706972626cdf7231 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala591787d01fe92c5706972626cdf7231 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.navbar','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('navbar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala591787d01fe92c5706972626cdf7231)): ?>
<?php $attributes = $__attributesOriginala591787d01fe92c5706972626cdf7231; ?>
<?php unset($__attributesOriginala591787d01fe92c5706972626cdf7231); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala591787d01fe92c5706972626cdf7231)): ?>
<?php $component = $__componentOriginala591787d01fe92c5706972626cdf7231; ?>
<?php unset($__componentOriginala591787d01fe92c5706972626cdf7231); ?>
<?php endif; ?>

    <!-- Main Content -->
    <main>
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <!-- Footer Component -->
    <?php if (isset($component)) { $__componentOriginal8a8716efb3c62a45938aca52e78e0322 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8a8716efb3c62a45938aca52e78e0322 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.footer','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('footer'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8a8716efb3c62a45938aca52e78e0322)): ?>
<?php $attributes = $__attributesOriginal8a8716efb3c62a45938aca52e78e0322; ?>
<?php unset($__attributesOriginal8a8716efb3c62a45938aca52e78e0322); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8a8716efb3c62a45938aca52e78e0322)): ?>
<?php $component = $__componentOriginal8a8716efb3c62a45938aca52e78e0322; ?>
<?php unset($__componentOriginal8a8716efb3c62a45938aca52e78e0322); ?>
<?php endif; ?>

    <!-- WhatsApp Flotante -->
    <?php if (isset($component)) { $__componentOriginal52d409fc1fa687ab461fb439e195b906 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal52d409fc1fa687ab461fb439e195b906 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.whatsapp-float','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('whatsapp-float'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal52d409fc1fa687ab461fb439e195b906)): ?>
<?php $attributes = $__attributesOriginal52d409fc1fa687ab461fb439e195b906; ?>
<?php unset($__attributesOriginal52d409fc1fa687ab461fb439e195b906); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal52d409fc1fa687ab461fb439e195b906)): ?>
<?php $component = $__componentOriginal52d409fc1fa687ab461fb439e195b906; ?>
<?php unset($__componentOriginal52d409fc1fa687ab461fb439e195b906); ?>
<?php endif; ?>

    <?php echo $__env->yieldPushContent('styles'); ?>
    <?php echo $__env->yieldPushContent('scripts'); ?>
    
    <!-- AOS Animation Script -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true,
            offset: 100
        });
    </script>
    
    <?php echo $__env->yieldContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\laragon\www\cpap-web\resources\views/layouts/app.blade.php ENDPATH**/ ?>