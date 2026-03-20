{{-- Footer Component - Global Footer --}}
<footer class="footer">
    <div class="footer-main">
        <div class="container">
            <div class="footer-grid">
                <!-- About Section -->
                <div class="footer-col">
                    <div class="footer-logo">
                        <div class="footer-logo-box">
                            <img src="{{ asset('images/logos/logo-cpap-web-elecciones.png') }}" alt="CPAP Logo">
                        </div>
                    </div>
                    <p class="footer-desc">
                        Colegio Profesional de Antropólogos del Perú - Región Centro.
                        Promoviendo la excelencia profesional desde 1985.
                    </p>
                    <div class="footer-social">
                        <a href="https://www.facebook.com" target="_blank" rel="noopener noreferrer" class="social-link" aria-label="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://www.twitter.com" target="_blank" rel="noopener noreferrer" class="social-link" aria-label="Twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="https://www.instagram.com" target="_blank" rel="noopener noreferrer" class="social-link" aria-label="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="https://www.linkedin.com" target="_blank" rel="noopener noreferrer" class="social-link" aria-label="LinkedIn">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="footer-col">
                    <h4 class="footer-title">Enlaces Rápidos</h4>
                    <ul class="footer-links">
                        <li><a href="{{ url('/nosotros/mision-vision') }}"><i class="fas fa-chevron-right"></i> Sobre Nosotros</a></li>
                        <li><a href="{{ url('/#eventos') }}"><i class="fas fa-chevron-right"></i> Eventos</a></li>
                        <li><a href="{{ route('noticias.index') }}"><i class="fas fa-chevron-right"></i> Noticias</a></li>
                        <li><a href="{{ url('/#colegiatura') }}"><i class="fas fa-chevron-right"></i> Colegiatura</a></li>
                    </ul>
                </div>

                <!-- Services -->
                <div class="footer-col">
                    <h4 class="footer-title">Servicios</h4>
                    <ul class="footer-links">
                        <li><a href="{{ route('biblioteca') }}"><i class="fas fa-chevron-right"></i> Biblioteca Virtual</a></li>
                        <li><a href="{{ route('bolsa-trabajo') }}"><i class="fas fa-chevron-right"></i> Bolsa de Trabajo</a></li>
                        <li><a href="{{ route('colegiatura.index') }}"><i class="fas fa-chevron-right"></i> Colegiarme</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div class="footer-col">
                    <h4 class="footer-title">Contacto</h4>
                    <ul class="footer-contact">
                        <li>
                            <i class="fas fa-map-marker-alt"></i>
                            <div class="footer-contact-info">
                                Jr. Arequipa 734, Huancayo<br>Junín, Perú
                            </div>
                        </li>
                        <li>
                            <i class="fas fa-mobile-alt"></i>
                            <div class="footer-contact-info">
                                <a href="tel:+51943667317">(+51) 943 667 317</a>
                            </div>
                        </li>
                        <li>
                            <i class="fab fa-whatsapp"></i>
                            <div class="footer-contact-info">
                                <a href="https://wa.me/51943667317" target="_blank">WhatsApp</a>
                            </div>
                        </li>
                        <li>
                            <i class="fas fa-envelope"></i>
                            <div class="footer-contact-info">
                                <a href="mailto:cpap.rc@gmail.com">cpap.rc@gmail.com</a>
                            </div>
                        </li>
                        <li>
                            <i class="fas fa-clock"></i>
                            <div class="footer-contact-info">
                                Lun - Vie: 9:00 AM - 1:00 PM
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Bottom -->
    <div class="footer-bottom">
        <div class="container">
            <div class="footer-bottom-content">
                <p class="copyright">
                    &copy; {{ date('Y') }} <strong>CPAP Región Centro</strong>. Todos los derechos reservados.
                </p>
                <div class="footer-bottom-links">
                    <a href="{{ route('contacto.index') }}">Política de Privacidad</a>
                    <a href="{{ route('contacto.index') }}">Términos de Uso</a>
                    <a href="{{ url('/') }}">Mapa del Sitio</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Scroll to Top Button -->
    <button class="scroll-top" id="scrollTop" aria-label="Volver arriba">
        <i class="fas fa-arrow-up"></i>
    </button>
</footer>

@push('scripts')
<script>
// Scroll to top functionality
document.addEventListener('DOMContentLoaded', function() {
    const scrollTop = document.getElementById('scrollTop');

    if (scrollTop) {
        // Show/hide button based on scroll position
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                scrollTop.classList.add('visible');
            } else {
                scrollTop.classList.remove('visible');
            }
        });

        // Smooth scroll to top on click
        scrollTop.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
});
</script>
@endpush
