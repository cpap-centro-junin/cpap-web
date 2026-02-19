/**
 * Banner Slider - Solución Robusta con Transform
 * Sistema de slides con translateX para transiciones suaves y confiables
 */

document.addEventListener('DOMContentLoaded', function() {
    const slider = document.getElementById('bannerSlider');
    const slides = document.querySelectorAll('.banner-slide');
    const prevBtn = document.getElementById('sliderPrev');
    const nextBtn = document.getElementById('sliderNext');
    const indicatorsContainer = document.getElementById('sliderIndicators');
    
    if (!slider || slides.length === 0) {
        
        return;
    }

    // Variables de estado
    let currentIndex = 0;
    let isTransitioning = false;
    let autoplayTimer = null;
    let touchStartX = 0;
    let touchEndX = 0;
    
    const AUTOPLAY_DELAY = 5000;
    const TRANSITION_DURATION = 600;
    const SWIPE_THRESHOLD = 50;

    // Inicializar slides
    function initSlides() {
        slides.forEach((slide, index) => {
            slide.style.transform = `translateX(${index * 100}%)`;
            slide.style.opacity = index === 0 ? '1' : '0';
        });
    }

    // Crear indicadores
    function createIndicators() {
        if (!indicatorsContainer) return;
        
        indicatorsContainer.innerHTML = '';
        slides.forEach((_, index) => {
            const dot = document.createElement('button');
            dot.className = 'slider-indicator';
            dot.setAttribute('aria-label', `Slide ${index + 1}`);
            if (index === 0) dot.classList.add('active');
            
            dot.addEventListener('click', () => goToSlide(index));
            indicatorsContainer.appendChild(dot);
        });
    }

    // Ir a un slide específico
    function goToSlide(index) {
        if (isTransitioning) return;
        if (index === currentIndex) return;
        
        isTransitioning = true;
        
        // Normalizar índice
        if (index >= slides.length) index = 0;
        if (index < 0) index = slides.length - 1;
        
        const direction = index > currentIndex ? -1 : 1;
        
        // Animar slides
        slides.forEach((slide, i) => {
            const offset = (i - index) * 100;
            slide.style.transform = `translateX(${offset}%)`;
            slide.style.opacity = i === index ? '1' : '0';
        });
        
        currentIndex = index;
        updateIndicators();
        
        setTimeout(() => {
            isTransitioning = false;
        }, TRANSITION_DURATION);
    }

    // Actualizar indicadores
    function updateIndicators() {
        if (!indicatorsContainer) return;
        
        const dots = indicatorsContainer.querySelectorAll('.slider-indicator');
        dots.forEach((dot, index) => {
            dot.classList.toggle('active', index === currentIndex);
        });
    }

    // Siguiente slide
    function nextSlide() {
        goToSlide(currentIndex + 1);
    }

    // Slide anterior
    function prevSlide() {
        goToSlide(currentIndex - 1);
    }

    // Auto-play
    function startAutoplay() {
        stopAutoplay();
        autoplayTimer = setInterval(nextSlide, AUTOPLAY_DELAY);
    }

    function stopAutoplay() {
        if (autoplayTimer) {
            clearInterval(autoplayTimer);
            autoplayTimer = null;
        }
    }

    function resetAutoplay() {
        stopAutoplay();
        startAutoplay();
    }

    // Event listeners
    if (prevBtn) {
        prevBtn.addEventListener('click', () => {
            prevSlide();
            resetAutoplay();
        });
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', () => {
            nextSlide();
            resetAutoplay();
        });
    }

    // Touch/Swipe
    slider.addEventListener('touchstart', (e) => {
        touchStartX = e.touches[0].clientX;
    }, { passive: true });

    slider.addEventListener('touchend', (e) => {
        touchEndX = e.changedTouches[0].clientX;
        const diff = touchStartX - touchEndX;
        
        if (Math.abs(diff) > SWIPE_THRESHOLD) {
            if (diff > 0) {
                nextSlide();
            } else {
                prevSlide();
            }
            resetAutoplay();
        }
    }, { passive: true });

    // Mouse drag - Mejorado para funcionar en imágenes también
    let isDragging = false;
    let dragStartX = 0;
    const sliderWrapper = document.getElementById('bannerSliderWrapper');

    // Prevenir drag nativo de imágenes
    const images = slider.querySelectorAll('img');
    images.forEach(img => {
        img.addEventListener('dragstart', (e) => e.preventDefault());
        img.style.userSelect = 'none';
        img.style.pointerEvents = 'none'; // Las imágenes no bloquean el drag
    });

    sliderWrapper.addEventListener('mousedown', (e) => {
        isDragging = true;
        dragStartX = e.clientX;
        sliderWrapper.style.cursor = 'grabbing';
        e.preventDefault(); // Prevenir selección de texto
    });

    sliderWrapper.addEventListener('mousemove', (e) => {
        if (!isDragging) return;
        e.preventDefault();
    });

    sliderWrapper.addEventListener('mouseup', (e) => {
        if (!isDragging) return;
        
        const diff = dragStartX - e.clientX;
        if (Math.abs(diff) > SWIPE_THRESHOLD) {
            if (diff > 0) {
                nextSlide();
            } else {
                prevSlide();
            }
            resetAutoplay();
        }
        
        isDragging = false;
        sliderWrapper.style.cursor = 'grab';
    });

    sliderWrapper.addEventListener('mouseleave', () => {
        if (isDragging) {
            isDragging = false;
            sliderWrapper.style.cursor = 'grab';
        }
    });

    // Pausar en hover
    const wrapper = document.getElementById('bannerSliderWrapper');
    if (wrapper) {
        wrapper.addEventListener('mouseenter', stopAutoplay);
        wrapper.addEventListener('mouseleave', startAutoplay);
    }

    // Pausar cuando no está visible
    document.addEventListener('visibilitychange', () => {
        if (document.hidden) {
            stopAutoplay();
        } else {
            startAutoplay();
        }
    });

    // Teclado
    document.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowLeft') {
            prevSlide();
            resetAutoplay();
        } else if (e.key === 'ArrowRight') {
            nextSlide();
            resetAutoplay();
        }
    });

    // Inicializar
    initSlides();
    createIndicators();
    startAutoplay();
    
    console.log('✅ Slider inicializado:', slides.length, 'slides');

    // Exponer controles
    window.sliderControls = {
        next: nextSlide,
        prev: prevSlide,
        goto: goToSlide,
        current: () => currentIndex
    };
});