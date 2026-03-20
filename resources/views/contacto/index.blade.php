@extends('layouts.app')

@section('title', 'Contacto | CPAP Región Centro')

@section('content')

{{-- PAGE HEADER --}}
<section class="page-header">
    <div class="page-header-overlay"></div>
    <div class="container">
        <div class="page-header-content" data-aos="fade-up">
            <h1 class="page-title">
                <i class="fas fa-envelope-open-text"></i>
                Contáctanos
            </h1>
            <p class="page-subtitle">
                Colegio Profesional de Antropólogos del Perú – Región Centro
            </p>
            <nav class="breadcrumb">
                <a href="{{ url('/') }}">Inicio</a>
                <span>/</span>
                <span>Contacto</span>
            </nav>
        </div>
    </div>
</section>

{{-- CANALES RÁPIDOS --}}
<section class="ctc-channels">
    <div class="container">
        <div class="ctc-channels-grid">
            <a href="https://wa.me/51943667317" target="_blank" class="ctc-channel ctc-channel--whatsapp" data-aos="fade-up" data-aos-delay="0">
                <div class="ctc-channel-icon"><i class="fab fa-whatsapp"></i></div>
                <div class="ctc-channel-body">
                    <span class="ctc-channel-label">WhatsApp</span>
                    <span class="ctc-channel-val">(+51) 943 667 317</span>
                </div>
                <i class="fas fa-arrow-right ctc-channel-arrow"></i>
            </a>
            <a href="mailto:cpap.rc@gmail.com" class="ctc-channel ctc-channel--email" data-aos="fade-up" data-aos-delay="80">
                <div class="ctc-channel-icon"><i class="fas fa-envelope"></i></div>
                <div class="ctc-channel-body">
                    <span class="ctc-channel-label">Correo Electrónico</span>
                    <span class="ctc-channel-val">cpap.rc@gmail.com</span>
                </div>
                <i class="fas fa-arrow-right ctc-channel-arrow"></i>
            </a>
            <a href="tel:+51943667317" class="ctc-channel ctc-channel--phone" data-aos="fade-up" data-aos-delay="160">
                <div class="ctc-channel-icon"><i class="fas fa-phone-alt"></i></div>
                <div class="ctc-channel-body">
                    <span class="ctc-channel-label">Celular</span>
                    <span class="ctc-channel-val">(+51) 943 667 317</span>
                </div>
                <i class="fas fa-arrow-right ctc-channel-arrow"></i>
            </a>
        </div>
    </div>
</section>

{{-- MAIN LAYOUT --}}
<section class="ctc-main-section">
    <div class="container">
        {{-- SECTION HEADER --}}
        <div class="ctc-section-header" data-aos="fade-up">
            <span class="section-badge">Escríbenos</span>
            <h2>¿En qué podemos ayudarte?</h2>
            <p>Completa el formulario o utiliza nuestros canales directos. Te responderemos a la brevedad.</p>
        </div>

        <div class="ctc-main-grid">

            {{-- FORMULARIO --}}
            <div class="ctc-form-col" data-aos="fade-right">
                <div class="ctc-form-card">
                    <div class="ctc-form-header">
                        <div class="ctc-form-icon"><i class="fas fa-paper-plane"></i></div>
                        <div>
                            <h2>Envíanos un mensaje</h2>
                            <p>Completa los campos y te contactaremos pronto.</p>
                        </div>
                    </div>

                    <form action="{{ route('contact.send') }}" method="POST" id="contactForm">
                        @csrf
                        {{-- Honeypot: campo invisible para bots --}}
                        <div style="position:absolute;left:-9999px;" aria-hidden="true">
                            <input type="text" name="website" tabindex="-1" autocomplete="off">
                        </div>
                        <input type="hidden" name="_timestamp" id="formTimestamp">

                        @if ($errors->any())
                            <div class="ctc-form-errors">
                                @foreach ($errors->all() as $error)
                                    <p><i class="fas fa-exclamation-circle"></i> {{ $error }}</p>
                                @endforeach
                            </div>
                        @endif

                        <div class="ctc-form-row">
                            <div class="ctc-field">
                                <label for="ctc-nombre"><i class="fas fa-user"></i> Nombre completo</label>
                                <input type="text" name="nombre" id="ctc-nombre" placeholder="Tu nombre completo" required>
                            </div>
                            <div class="ctc-field">
                                <label for="ctc-email"><i class="fas fa-envelope"></i> Correo electrónico</label>
                                <input type="email" name="email" id="ctc-email" placeholder="correo@ejemplo.com" required>
                            </div>
                        </div>

                        <div class="ctc-form-row">
                            <div class="ctc-field">
                                <label for="ctc-asunto"><i class="fas fa-tag"></i> Asunto</label>
                                <input type="text" name="asunto" id="ctc-asunto" placeholder="¿Sobre qué nos escribes?" required>
                            </div>
                            <div class="ctc-field">
                                <label for="ctc-telefono"><i class="fas fa-phone"></i> Teléfono <span class="ctc-optional">(opcional)</span></label>
                                <input type="text" name="telefono" id="ctc-telefono" placeholder="+51 900 000 000">
                            </div>
                        </div>

                        <div class="ctc-field">
                            <label for="ctc-mensaje"><i class="fas fa-comment-alt"></i> Mensaje</label>
                            <textarea name="mensaje" id="ctc-mensaje" rows="6"
                                      placeholder="Escribe tu consulta o comentario aquí..."
                                      required></textarea>
                        </div>

                        <input type="hidden" name="recaptcha_token" id="recaptchaToken">

                        <div class="ctc-recaptcha-wrapper" style="margin-bottom: 20px;">
                            <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                        </div>

                        <button type="submit" class="ctc-submit-btn" id="submitBtn">
                            <span class="btn-text-inner">
                                <i class="fas fa-paper-plane"></i>
                                Enviar Mensaje
                            </span>
                            <span class="btn-loader-inner">
                                <span class="ctc-spinner"></span>
                                Enviando...
                            </span>
                        </button>
                    </form>
                </div>
            </div>

            {{-- INFO + MAPA --}}
            <div class="ctc-info-col" data-aos="fade-left">

                <div class="ctc-info-card">
                    <h3><i class="fas fa-building"></i> Información Institucional</h3>
                    <div class="ctc-info-list">
                        <div class="ctc-info-item">
                            <div class="ctc-info-item-icon ctc-icon--primary"><i class="fas fa-clock"></i></div>
                            <div class="ctc-info-item-body">
                                <strong>Horario de Atención</strong>
                                <span>Lunes a viernes · 09:00 a.m. – 01:00 p.m.</span>
                            </div>
                        </div>
                        <div class="ctc-info-item">
                            <div class="ctc-info-item-icon ctc-icon--gold"><i class="fas fa-map-marker-alt"></i></div>
                            <div class="ctc-info-item-body">
                                <strong>Dirección</strong>
                                <span>Jr. Arequipa 734, Huancayo – Junín – Perú</span>
                            </div>
                        </div>
                        <div class="ctc-info-item">
                            <div class="ctc-info-item-icon ctc-icon--primary"><i class="fas fa-building"></i></div>
                            <div class="ctc-info-item-body">
                                <strong>Razón Social</strong>
                                <span>Colegio Profesional de Antropólogos del Perú – Región Centro</span>
                            </div>
                        </div>
                        <div class="ctc-info-item">
                            <div class="ctc-info-item-icon ctc-icon--gold"><i class="fas fa-id-card"></i></div>
                            <div class="ctc-info-item-body">
                                <strong>RUC</strong>
                                <span>20123456789</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- REDES SOCIALES --}}
                <div class="ctc-social-card">
                    <h3><i class="fas fa-share-alt"></i> Síguenos</h3>
                    <div class="ctc-social-links">
                        <a href="#" class="ctc-social-link ctc-social--fb" title="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="ctc-social-link ctc-social--ig" title="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="ctc-social-link ctc-social--yt" title="YouTube">
                            <i class="fab fa-youtube"></i>
                        </a>
                        <a href="#" class="ctc-social-link ctc-social--tiktok" title="TikTok">
                            <i class="fab fa-tiktok"></i>
                        </a>
                    </div>
                </div>

                <div class="ctc-map-card">
                    <div class="ctc-map-label">
                        <i class="fas fa-map-marked-alt"></i> Nuestra ubicación
                    </div>
                    <div class="ctc-map-frame">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3901.600194787139!2d-75.21245392597189!3d-12.071005942350432!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x910e964e2ce1cb1d%3A0x1d856d73fe8eb871!2sJr.%20Arequipa%20734%2C%20Huancayo%2012001!5e0!3m2!1ses-419!2spe!4v1771480292132!5m2!1ses-419!2spe"
                            width="100%" height="100%"
                            style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                    <a href="https://maps.google.com/?q=Jr+Arequipa+734+Huancayo" target="_blank" class="ctc-map-btn">
                        <i class="fas fa-directions"></i> Cómo llegar
                    </a>
                </div>

            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script>
document.addEventListener("DOMContentLoaded", function(){
    const form = document.getElementById("contactForm");
    const btn  = document.getElementById("submitBtn");

    // Registrar timestamp cuando se carga el formulario
    document.getElementById("formTimestamp").value = Math.floor(Date.now() / 1000);

    form.addEventListener("submit", function(e){
        e.preventDefault();

        // Verificar que el usuario completó el reCAPTCHA
        const recaptchaResponse = grecaptcha.getResponse();
        if (!recaptchaResponse) {
            Swal.fire({ icon: "warning", title: "Verificaci\u00f3n requerida", text: "Por favor, marca la casilla \"No soy un robot\".", confirmButtonColor: "#8B1538" });
            return;
        }

        btn.classList.add("loading");
        btn.disabled = true;

        // Guardar el token en el hidden field
        document.getElementById("recaptchaToken").value = recaptchaResponse;

        fetch(form.action, {
            method: "POST",
            body: new FormData(form),
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json"
            }
        })
        .then(r => {
            if(!r.ok){
                return r.json().then(d => { throw d; });
            }
            return r.json();
        })
        .then(data => {
            btn.classList.remove("loading");
            btn.disabled = false;
            if(data.success){
                form.reset();
                grecaptcha.reset();
                Swal.fire({ icon: "success", title: "Mensaje enviado", text: data.message, confirmButtonColor: "#8B1538" });
            }
        })
        .catch((err) => {
            btn.classList.remove("loading");
            btn.disabled = false;
            grecaptcha.reset();
            const msg = (err && err.message) ? err.message : "Hubo un problema al enviar el mensaje.";
            Swal.fire({ icon: "error", title: "Error", text: msg });
        });
    });
});
</script>

@endsection
