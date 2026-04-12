
<nav class="navbar" id="navbar">
    <div class="navbar-container">
        <a href="<?php echo e(url('/')); ?>" class="navbar-brand">
            <div class="logo-container">
                <img src="<?php echo e(asset('images/logos/logo-cpap-web-elecciones.png')); ?>" alt="CPAP Logo" class="logo-image-main">
            </div>
        </a>

        <button class="navbar-toggle" id="navbarToggle" aria-label="Toggle navigation">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <div class="navbar-menu" id="navbarMenu">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="<?php echo e(url('/')); ?>" class="nav-link <?php echo e(request()->is('/') ? 'active' : ''); ?>">
                        <i class="fas fa-home"></i>
                        Inicio
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a href="javascript:void(0)" class="nav-link <?php echo e(request()->is('nosotros*') ? 'active' : ''); ?>">
                        <i class="fas fa-users"></i>
                        Nosotros
                        <i class="fas fa-chevron-down dropdown-icon"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo e(route('nosotros.mision-vision')); ?>" class="<?php echo e(request()->routeIs('nosotros.mision-vision') ? 'active' : ''); ?>"><i class="fas fa-bullseye"></i> Misión y Visión</a></li>
                        <li><a href="<?php echo e(route('nosotros.historia')); ?>" class="<?php echo e(request()->routeIs('nosotros.historia') ? 'active' : ''); ?>"><i class="fas fa-history"></i> Historia</a></li>
                        <li><a href="<?php echo e(route('nosotros.consejo-directivo')); ?>" class="<?php echo e(request()->routeIs('nosotros.consejo-directivo') ? 'active' : ''); ?>"><i class="fas fa-users-cog"></i> Consejo Directivo</a></li>
                        <li><a href="<?php echo e(route('nosotros.normativa-legal')); ?>" class="<?php echo e(request()->routeIs('nosotros.normativa-legal') ? 'active' : ''); ?>"><i class="fas fa-gavel"></i> Normativa Legal</a></li>
                        <li><a href="<?php echo e(route('nosotros.plan-2026')); ?>" class="<?php echo e(request()->routeIs('nosotros.plan-2026') ? 'active' : ''); ?>"><i class="fas fa-clipboard-list"></i> Plan de Trabajo 2026</a></li>
                        <li><a href="<?php echo e(route('galeria')); ?>" class="<?php echo e(request()->routeIs('galeria') ? 'active' : ''); ?>"><i class="fas fa-images"></i> Galería Institucional</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a href="javascript:void(0)" class="nav-link <?php echo e(request()->is('noticias*') || request()->is('eventos*') ? 'active' : ''); ?>">
                        <i class="fas fa-newspaper"></i>
                        Actualidad
                        <i class="fas fa-chevron-down dropdown-icon"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo e(route('noticias.index')); ?>" class="<?php echo e(request()->routeIs('noticias.*') || request()->is('noticias*') ? 'active' : ''); ?>"><i class="fas fa-newspaper"></i> Noticias</a></li>
                        <li><a href="<?php echo e(route('eventos.index')); ?>" class="<?php echo e(request()->routeIs('eventos.*') || request()->is('eventos*') ? 'active' : ''); ?>"><i class="fas fa-calendar-alt"></i> Eventos</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="<?php echo e(route('colegiados.index')); ?>" class="nav-link <?php echo e(request()->is('colegiados*') ? 'active' : ''); ?>">
                        <i class="fas fa-id-card"></i>
                        Colegiados
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a href="javascript:void(0)" class="nav-link <?php echo e(request()->is('biblioteca') || request()->is('bolsa-trabajo') || request()->is('colegiatura*') ? 'active' : ''); ?>">
                        <i class="fas fa-briefcase"></i>
                        Servicios
                        <i class="fas fa-chevron-down dropdown-icon"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="<?php echo e(route('biblioteca')); ?>" class="<?php echo e(request()->routeIs('biblioteca') || request()->is('biblioteca') ? 'active' : ''); ?>">
                                <i class="fas fa-book"></i> Biblioteca Virtual
                            </a>
                        </li>

                        <li>
                            <a href="<?php echo e(route('bolsa-trabajo')); ?>" class="<?php echo e(request()->routeIs('bolsa-trabajo') || request()->is('bolsa-trabajo') ? 'active' : ''); ?>">
                                <i class="fas fa-briefcase"></i> Bolsa de Trabajo
                            </a>
                        </li>

                        <li>
                            <a href="<?php echo e(route('colegiatura.index')); ?>" class="<?php echo e(request()->routeIs('colegiatura.*') || request()->is('colegiatura*') ? 'active' : ''); ?>">
                                <i class="fas fa-user-graduate"></i> Colegiarme
                            </a>
                        </li>
                    </ul>

                </li>
                <li class="nav-item">
                    <a href="<?php echo e(route('contacto.index')); ?>" class="nav-link <?php echo e(request()->is('contacto*') ? 'active' : ''); ?>">
                        <i class="fas fa-envelope"></i>
                        Contacto
                    </a>
                </li>
            </ul>

            <div class="navbar-cta">
                <?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-primary">
                        <i class="fas fa-user-shield"></i>
                        Panel Admin
                    </a>
                <?php else: ?>
                    <a href="<?php echo e(url('/#colegiatura')); ?>" class="btn btn-primary">
                        <i class="fas fa-user-plus"></i>
                        Colegiarme
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<div class="navbar-overlay" id="navbarOverlay"></div>

<?php $__env->startPush('scripts'); ?>
<script>
// Navbar Functionality - Moderno con Accordion Responsive
document.addEventListener('DOMContentLoaded', function() {
    const navbar = document.getElementById('navbar');
    const toggle = document.getElementById('navbarToggle');
    const menu = document.getElementById('navbarMenu');
    const overlay = document.getElementById('navbarOverlay');
    const dropdowns = document.querySelectorAll('.dropdown');

    // ============================================
    // 1. INICIALIZAR DROPDOWNS SEGÚN RUTA ACTIVA
    // ============================================
    function initializeDropdownsForCurrentRoute() {
        dropdowns.forEach(dropdown => {
            // OPCIÓN B: Mantener dropdowns cerrados pero indicar ruta activa
            // El nav-link.active muestará visualmente dónde estamos
            // El dropdown NO se abre automáticamente
            dropdown.classList.remove('active');
        });
    }
    
    // Inicializar al cargar
    initializeDropdownsForCurrentRoute();

    // Hamburger toggle
    if (toggle && menu) {
        toggle.addEventListener('click', function(e) {
            e.stopPropagation();
            menu.classList.toggle('active');
            toggle.classList.toggle('active');
            overlay.classList.toggle('active');
            
            // Al cerrar el menú desde el toggle, mantener dropdowns activos por ruta
            if (!menu.classList.contains('active')) {
                initializeDropdownsForCurrentRoute();
            }
        });

        // Close menu when clicking overlay
        overlay.addEventListener('click', function() {
            menu.classList.remove('active');
            toggle.classList.remove('active');
            overlay.classList.remove('active');
            initializeDropdownsForCurrentRoute();
        });
    }

    // ============================================
    // 2. ACCORDION BEHAVIOR EN MOBILE
    // ============================================
    
    // Funciones helper para abrir/cerrar dropdowns explícitamente
    function openDropdown(dropdown) {
        // Cerrar todos los demás (accordion)
        dropdowns.forEach(other => {
            if (other !== dropdown && other.classList.contains('active')) {
                closeDropdown(other);
            }
        });
        dropdown.classList.add('active');
    }
    
    function closeDropdown(dropdown) {
        dropdown.classList.remove('active');
    }
    
    function toggleDropdown(dropdown) {
        if (dropdown.classList.contains('active')) {
            closeDropdown(dropdown);
        } else {
            openDropdown(dropdown);
        }
    }
    
    dropdowns.forEach(dropdown => {
        const link = dropdown.querySelector('.nav-link');
        
        // Evento click en el nav-link (previne click en icono también)
        link.addEventListener('click', function(e) {
            if (window.innerWidth <= 768) {
                e.preventDefault();
                e.stopPropagation();
                toggleDropdown(dropdown);
            }
        });
        
        // Agregar click al dropdown-menu para evitar bugs de propagación
        const menu = dropdown.querySelector('.dropdown-menu');
        if (menu) {
            menu.addEventListener('click', function(e) {
                // Si hace click en un link dentro del menú, cerrar después de navegar
                if (e.target.tagName === 'A') {
                    // Dejar que se navegue, pero cerrar el menú si se va a otra página
                    setTimeout(() => {
                        closeDropdown(dropdown);
                    }, 100);
                }
            });
        }
    });

    // Navbar scroll effect - throttled con requestAnimationFrame para evitar lag
    if (navbar) {
        let ticking = false;
        window.addEventListener('scroll', function() {
            if (!ticking) {
                requestAnimationFrame(function() {
                    if (window.scrollY > 50) {
                        navbar.classList.add('navbar-scrolled');
                    } else {
                        navbar.classList.remove('navbar-scrolled');
                    }
                    ticking = false;
                });
                ticking = true;
            }
        }, { passive: true });
    }

    // Smooth scroll to anchors
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (href !== '#' && href !== 'javascript:void(0)') {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    const offsetTop = target.offsetTop - 100;
                    window.scrollTo({
                        top: offsetTop,
                        behavior: 'smooth'
                    });
                    // Close mobile menu
                    menu.classList.remove('active');
                    toggle.classList.remove('active');
                    overlay.classList.remove('active');
                }
            }
        });
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\laragon\www\cpap-web\resources\views/components/navbar.blade.php ENDPATH**/ ?>