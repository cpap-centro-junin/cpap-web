// Counter Animation for Stats
document.addEventListener('DOMContentLoaded', function() {
    // Stats Counter
    const statNumbers = document.querySelectorAll('.stat-number');
    const observerOptions = {
        threshold: 0.5,
        rootMargin: '0px'
    };

    const counterObserver = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const target = entry.target;
                const finalNumber = parseInt(target.getAttribute('data-count'));
                animateCounter(target, finalNumber);
                counterObserver.unobserve(target);
            }
        });
    }, observerOptions);

    statNumbers.forEach(stat => counterObserver.observe(stat));

    function animateCounter(element, target) {
        let current = 0;
        const increment = target / 50;
        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                element.textContent = target;
                clearInterval(timer);
            } else {
                element.textContent = Math.floor(current);
            }
        }, 30);
    }

    // Navbar Toggle
    const navbarToggle = document.getElementById('navbarToggle');
    const navbarMenu = document.getElementById('navbarMenu');

    if (navbarToggle) {
        navbarToggle.addEventListener('click', function() {
            navbarMenu.classList.toggle('active');
            this.classList.toggle('active');
        });

        // Close menu when clicking outside
        document.addEventListener('click', function(event) {
            const isClickInside = navbarMenu.contains(event.target) || navbarToggle.contains(event.target);
            if (!isClickInside && navbarMenu.classList.contains('active')) {
                navbarMenu.classList.remove('active');
                navbarToggle.classList.remove('active');
            }
        });

        // Close menu when clicking a link
        const navLinks = navbarMenu.querySelectorAll('.nav-link');
        navLinks.forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth <= 768) {
                    navbarMenu.classList.remove('active');
                    navbarToggle.classList.remove('active');
                }
            });
        });
    }

    // Navbar Scroll Effect
    const navbar = document.getElementById('navbar');
    let lastScroll = 0;

    window.addEventListener('scroll', function() {
        const currentScroll = window.pageYOffset;

        if (currentScroll > 100) {
            navbar.style.padding = '10px 0';
            navbar.style.boxShadow = '0 4px 12px rgba(0,0,0,0.15)';
        } else {
            navbar.style.padding = '20px 0';
            navbar.style.boxShadow = '0 4px 8px rgba(0,0,0,0.12)';
        }

        lastScroll = currentScroll;
    });

    // Smooth Scroll for Anchor Links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (href === '#' || href === '') return;
            
            e.preventDefault();
            const target = document.querySelector(href);
            if (target) {
                const offsetTop = target.offsetTop - 80;
                window.scrollTo({
                    top: offsetTop,
                    behavior: 'smooth'
                });
            }
        });
    });

    // Scroll to Top Button
    const scrollToTopBtn = document.getElementById('scrollToTop');

    if (scrollToTopBtn) {
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                scrollToTopBtn.classList.add('visible');
            } else {
                scrollToTopBtn.classList.remove('visible');
            }
        });

        scrollToTopBtn.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    // Active Nav Link on Scroll
    const sections = document.querySelectorAll('section[id]');
    const navLinks = document.querySelectorAll('.nav-link');

    function highlightNavOnScroll() {
        const scrollY = window.pageYOffset;

        sections.forEach(section => {
            const sectionHeight = section.offsetHeight;
            const sectionTop = section.offsetTop - 100;
            const sectionId = section.getAttribute('id');

            if (scrollY > sectionTop && scrollY <= sectionTop + sectionHeight) {
                navLinks.forEach(link => {
                    link.classList.remove('active');
                    if (link.getAttribute('href') === `#${sectionId}`) {
                        link.classList.add('active');
                    }
                });
            }
        });
    }

    window.addEventListener('scroll', highlightNavOnScroll);

    // Contact Form Validation
    const contactForm = document.querySelector('.contact-form');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Simple validation
            const inputs = this.querySelectorAll('input[required], textarea[required]');
            let isValid = true;

            inputs.forEach(input => {
                if (!input.value.trim()) {
                    isValid = false;
                    input.style.borderColor = '#dc3545';
                } else {
                    input.style.borderColor = '#E9ECEF';
                }
            });

            if (isValid) {
                alert('¡Gracias por contactarnos! Pronto te responderemos.');
                this.reset();
            } else {
                alert('Por favor, completa todos los campos requeridos.');
            }
        });
    }
});

// Parallax Effect for Hero
window.addEventListener('scroll', function() {
    const scrolled = window.pageYOffset;
    const hero = document.querySelector('.hero');
    if (hero) {
        hero.style.transform = `translateY(${scrolled * 0.5}px)`;
    }
});

// Banner Slider - Funciones globales
window.currentSlide = 0;
window.slideInterval = null;

window.showSlide = function(index) {
    const slides = document.querySelectorAll('.banner-slide');
    const indicators = document.querySelectorAll('.indicator');
    
    console.log('showSlide llamado con index:', index);
    console.log('Número de slides encontrados:', slides.length);
    
    if (!slides.length) {
        console.log('No hay slides disponibles');
        return;
    }
    
    // Wrap around
    if (index >= slides.length) window.currentSlide = 0;
    else if (index < 0) window.currentSlide = slides.length - 1;
    else window.currentSlide = index;
    
    console.log('Slide actual:', window.currentSlide);
    
    // Update slides
    slides.forEach((slide, i) => {
        slide.classList.toggle('active', i === window.currentSlide);
    });
    
    // Update indicators
    indicators.forEach((indicator, i) => {
        indicator.classList.toggle('active', i === window.currentSlide);
    });
}

window.nextSlide = function() {
    console.log('nextSlide llamado');
    window.showSlide(window.currentSlide + 1);
    window.resetSlideInterval();
}

window.previousSlide = function() {
    console.log('previousSlide llamado');
    window.showSlide(window.currentSlide - 1);
    window.resetSlideInterval();
}

window.goToSlide = function(index) {
    console.log('goToSlide llamado con index:', index);
    window.showSlide(index);
    window.resetSlideInterval();
}

window.resetSlideInterval = function() {
    console.log('resetSlideInterval llamado');
    clearInterval(window.slideInterval);
    window.slideInterval = setInterval(() => {
        console.log('Auto-avance del slider');
        window.showSlide(window.currentSlide + 1);
    }, 5000);
}

// Auto-play slider - Inicialización
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOMContentLoaded - Iniciando slider');
    const bannerSlider = document.querySelector('.banner-slider');
    
    if (bannerSlider) {
        console.log('Banner slider encontrado, inicializando...');
        window.showSlide(0);
        window.resetSlideInterval();
        
        // Pause on hover
        const bannerSliderWrapper = document.querySelector('.banner-slider-wrapper');
        if (bannerSliderWrapper) {
            console.log('Eventos de hover configurados');
            bannerSliderWrapper.addEventListener('mouseenter', () => {
                console.log('Mouse enter - pausando slider');
                clearInterval(window.slideInterval);
            });
            bannerSliderWrapper.addEventListener('mouseleave', () => {
                console.log('Mouse leave - reanudando slider');
                window.resetSlideInterval();
            });
        }
    } else {
        console.log('Banner slider NO encontrado en el DOM');
    }
});
