@extends('layouts.app')

@section('title', 'Contacto | CPAP Región Centro')


@section('content')

{{-- HERO --}}
<section class="cpap-hero contacto-hero">
    <div class="cpap-hero-content" data-aos="fade-up">
        <div class="cpap-hero-badge">
            <i class="fas fa-envelope-open-text"></i>
            Información Institucional
        </div>
        <h1>Contáctanos</h1>
        <p>Colegio Profesional de Antropólogos del Perú – Región Centro</p>
    </div>
</section>

{{-- INFORMACIÓN --}}
<section class="contact-info-section">
    <div class="cpap-container">
        <div class="contact-grid">

            <div class="contact-card">
                <i class="fas fa-clock"></i>
                <h4>Horario de Atención</h4>
                <p>Lunes a viernes<br>09:00 a.m. – 06:00 p.m.</p>
            </div>

            <div class="contact-card">
                <i class="fas fa-map-marker-alt"></i>
                <h4>Dirección</h4>
                <p>Av. Ejemplo Nº 123<br>Huancayo – Junín – Perú</p>
            </div>

            <div class="contact-card">
                <i class="fas fa-building"></i>
                <h4>RUC</h4>
                <p>20123456789</p>
            </div>

            <div class="contact-card">
                <i class="fas fa-landmark"></i>
                <h4>Razón Social</h4>
                <p>Colegio Profesional de Antropólogos del Perú – Región Centro</p>
            </div>

            <div class="contact-card">
                <i class="fas fa-envelope"></i>
                <h4>Mesa de Partes</h4>
                <p>mesadepartes@cpaprc.org.pe</p>
            </div>

            <div class="contact-card">
                <i class="fab fa-whatsapp"></i>
                <h4>Atención al Colegiado</h4>
                <p>WhatsApp: (+51) 900 000 000</p>
            </div>

            <div class="contact-card">
                <i class="fas fa-phone-alt"></i>
                <h4>Central Telefónica</h4>
                <p>(+51 64) 123456<br>Anexo 100</p>
            </div>

        </div>
    </div>
</section>

{{-- MAPA --}}
<section class="contact-map">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3901.600194787139!2d-75.21245392597189!3d-12.071005942350432!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x910e964e2ce1cb1d%3A0x1d856d73fe8eb871!2sJr.%20Arequipa%20734%2C%20Huancayo%2012001!5e0!3m2!1ses-419!2spe!4v1771480292132!5m2!1ses-419!2spe" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
</section>

{{-- FORMULARIO --}}
<section class="contact-form-section">
    <div class="cpap-container">
        <div class="contact-form-wrapper" data-aos="fade-up">

            <h3>Envíanos un mensaje</h3>

            <form action="{{ route('contact.send') }}" method="POST">
                @csrf
                @if ($errors->any())
                    <div class="form-error">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="form-row">
                    <input type="text" name="nombre" placeholder="Nombre completo" required>
                    <input type="email" name="email" placeholder="Correo electrónico" required>
                </div>

                <div class="form-row">
                    <input type="text" name="asunto" placeholder="Asunto" required>
                    <input type="text" name="telefono" placeholder="Teléfono (opcional)">
                </div>

                <textarea name="mensaje"
                          rows="5"
                          placeholder="Escribe tu mensaje aquí..."
                          required></textarea>

                <button type="submit" class="btn-contact" id="submitBtn">
                    <span class="btn-text">
                        <i class="fas fa-paper-plane"></i>
                        Enviar Mensaje
                    </span>

                    <span class="btn-loader">
                        <span class="spinner"></span>
                    </span>
                </button>
            </form>

        </div>
    </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener("DOMContentLoaded", function(){

    const form = document.querySelector("form");
    const button = document.getElementById("submitBtn");

    form.addEventListener("submit", function(e){
        e.preventDefault();

        // Activar loader
        button.classList.add("loading");
        button.disabled = true;

        fetch(form.action, {
            method: "POST",
            body: new FormData(form),
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            }
        })
        .then(response => {
            if(!response.ok){
                throw new Error("Respuesta no válida");
            }
            return response.json();
        })
        .then(data => {

            // Desactivar loader
            button.classList.remove("loading");
            button.disabled = false;

            if(data.success){
                form.reset();

                Swal.fire({
                    icon: "success",
                    title: "Mensaje enviado",
                    text: data.message,
                    confirmButtonColor: "#7b1e3a"
                });
            }
        })
        .catch(() => {

            // Desactivar loader
            button.classList.remove("loading");
            button.disabled = false;

            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Hubo un problema al enviar el mensaje."
            });

        });
    });

});
</script>



@endsection
