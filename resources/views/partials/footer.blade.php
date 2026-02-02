<footer class="footer">
    <div class="footer-main">
        <div class="container">
            <div class="footer-grid">
                <!-- About Section -->
                <div class="footer-col">
                    <div class="footer-logo">
                        <img src="{{ asset('images/logos/logo-cpap-web-elecciones.png') }}" alt="CPAP Logo">
                    </div>
                    <p class="footer-desc">
                        Colegio Profesional de Antropólogos del Perú - Región Centro. 
                        Promoviendo la excelencia profesional desde 1985.
                    </p>
                    <div class="footer-social">
                        <a href="#" class="social-link" aria-label="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="social-link" aria-label="Twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="social-link" aria-label="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="social-link" aria-label="LinkedIn">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="footer-col">
                    <h4 class="footer-title">Enlaces Rápidos</h4>
                    <ul class="footer-links">
                        <li><a href="{{ url('/#nosotros') }}">Sobre Nosotros</a></li>
                        <li><a href="{{ url('/#servicios') }}">Servicios</a></li>
                        <li><a href="{{ url('/#eventos') }}">Eventos</a></li>
                        <li><a href="{{ url('/#noticias') }}">Noticias</a></li>
                        <li><a href="{{ url('/#colegiatura') }}">Colegiatura</a></li>
                    </ul>
                </div>

                <!-- Services -->
                <div class="footer-col">
                    <h4 class="footer-title">Servicios</h4>
                    <ul class="footer-links">
                        <li><a href="{{ route('biblioteca') }}">Biblioteca Virtual</a></li>
                        <li><a href="{{ route('bolsa-trabajo') }}">Bolsa de Trabajo</a></li>
                        <li><a href="{{ url('/#certificaciones') }}">Certificaciones</a></li>
                        <li><a href="{{ url('/#capacitaciones') }}">Capacitaciones</a></li>
                        <li><a href="{{ url('/#documentos') }}">Documentos</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div class="footer-col">
                    <h4 class="footer-title">Contacto</h4>
                    <ul class="footer-contact">
                        <li>
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Jr. Ejemplo 123, Huancayo<br>Junín, Perú</span>
                        </li>
                        <li>
                            <i class="fas fa-phone"></i>
                            <span>(064) 123-4567</span>
                        </li>
                        <li>
                            <i class="fas fa-envelope"></i>
                            <span>contacto@cpapcentro.org.pe</span>
                        </li>
                        <li>
                            <i class="fas fa-clock"></i>
                            <span>Lun - Vie: 9:00 AM - 6:00 PM</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <div class="footer-bottom-content">
                <p class="copyright">
                    &copy; {{ date('Y') }} CPAP Región Centro. Todos los derechos reservados.
                </p>
                <div class="footer-bottom-links">
                    <a href="#">Política de Privacidad</a>
                    <a href="#">Términos de Uso</a>
                    <a href="#">Mapa del Sitio</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Scroll to Top Button -->
    <button class="scroll-top" id="scrollTop" aria-label="Volver arriba">
        <i class="fas fa-arrow-up"></i>
    </button>
</footer>
