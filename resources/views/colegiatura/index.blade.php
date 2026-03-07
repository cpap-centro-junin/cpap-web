@extends('layouts.app')

@section('title','Colegiatura y Habilitación | CPAP Región Centro')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/pages/colegiatura.css') }}">
@endpush

@section('content')

{{-- HERO --}}
<section class="cpap-hero colegiatura-hero">
    <div class="cpap-hero-content">
        <div class="cpap-hero-badge">
            <i class="fas fa-user-graduate"></i>
            Servicios CPAP – Región Centro
        </div>
        <h1>Colegiatura y <span>Habilitación</span></h1>
        <p>Conoce los procesos, requisitos y tarifas para colegiarte y mantenerte habilitado como antropólogo profesional.</p>
        <div class="hero-nav-pills">
            <a href="#colegiacion" class="hero-pill"><i class="fas fa-id-card"></i> Colegiación</a>
            <a href="#habilitacion" class="hero-pill"><i class="fas fa-certificate"></i> Habilitación</a>
            <a href="#reglamento" class="hero-pill hero-pill--outline"><i class="fas fa-book"></i> Reglamento</a>
        </div>
    </div>
</section>

{{-- ===== SECCIÓN 1: PROCESO DE COLEGIACIÓN ===== --}}
<section class="col-section" id="colegiacion">
    <div class="cpap-container">
        <div class="col-section-header" data-aos="fade-up">
            <span class="col-badge"><i class="fas fa-id-card"></i> Trámite Inicial</span>
            <h2>Proceso de Colegiación</h2>
            <p>Sigue estos pasos para incorporarte oficialmente al Colegio Profesional de Antropólogos del Perú – Región Centro.</p>
        </div>

        <div class="col-steps-timeline" data-aos="fade-up" data-aos-delay="100">

            <div class="col-step">
                <div class="col-step-icon"><span>01</span></div>
                <div class="col-step-body">
                    <h3>Descargar formato de inscripción</h3>
                    <p>Ingresa a la web institucional y descarga el formato oficial de inscripción para colegiatura.</p>
                </div>
            </div>

            <div class="col-step">
                <div class="col-step-icon"><span>02</span></div>
                <div class="col-step-body">
                    <h3>Depositar S/. 490.00 – Región Centro</h3>
                    <p>Realiza el depósito en la cuenta del CDD Región Centro en <strong>Caja Huancayo</strong>.</p>
                    <div class="col-step-note">
                        <i class="fas fa-university"></i> Cuenta CDD Región Centro – Caja Huancayo
                    </div>
                </div>
            </div>

            <div class="col-step">
                <div class="col-step-icon"><span>03</span></div>
                <div class="col-step-body">
                    <h3>Enviar baucher de pago regional</h3>
                    <p>Escanea o captura el baucher y envíalo en formato <strong>PDF</strong> al correo institucional.</p>
                </div>
            </div>

            <div class="col-step">
                <div class="col-step-icon"><span>04</span></div>
                <div class="col-step-body">
                    <h3>Adjuntar requisitos documentarios</h3>
                    <p>Prepara y envía todos los requisitos en PDF al correo institucional: título, DNI, foto carnet, declaración jurada, entre otros.</p>
                </div>
            </div>

            <div class="col-step">
                <div class="col-step-icon"><span>05</span></div>
                <div class="col-step-body">
                    <h3>Depositar S/. 210.00 – Consejo Nacional</h3>
                    <p>Realiza el depósito en la cuenta del Consejo Directivo Nacional en <strong>BCP</strong>.</p>
                    <div class="col-step-note">
                        <i class="fas fa-university"></i> Cuenta Consejo Directivo Nacional – BCP
                    </div>
                </div>
            </div>

            <div class="col-step">
                <div class="col-step-icon"><span>06</span></div>
                <div class="col-step-body">
                    <h3>Enviar baucher de pago nacional</h3>
                    <p>Escanea o captura el baucher nacional y envíalo en formato <strong>PDF</strong>.</p>
                </div>
            </div>

        </div>

        {{-- Resumen de pagos --}}
        <div class="col-payment-summary" data-aos="fade-up" data-aos-delay="200">
            <h3><i class="fas fa-receipt"></i> Resumen de Pagos – Colegiación</h3>
            <div class="col-payment-grid">
                <div class="col-payment-card">
                    <div class="col-payment-amount">S/. 490</div>
                    <div class="col-payment-label">CDD Región Centro</div>
                    <div class="col-payment-bank"><i class="fas fa-university"></i> Caja Huancayo</div>
                </div>
                <div class="col-payment-plus"><i class="fas fa-plus"></i></div>
                <div class="col-payment-card">
                    <div class="col-payment-amount">S/. 210</div>
                    <div class="col-payment-label">Consejo Directivo Nacional</div>
                    <div class="col-payment-bank"><i class="fas fa-university"></i> BCP</div>
                </div>
                <div class="col-payment-plus"><i class="fas fa-equals"></i></div>
                <div class="col-payment-card col-payment-card--total">
                    <div class="col-payment-amount">S/. 700</div>
                    <div class="col-payment-label">Total Colegiatura</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== SECCIÓN 2: PROCESO DE HABILITACIÓN ===== --}}
<section class="col-section col-section--alt" id="habilitacion">
    <div class="cpap-container">
        <div class="col-section-header" data-aos="fade-up">
            <span class="col-badge col-badge--gold"><i class="fas fa-certificate"></i> Renovación Periódica</span>
            <h2>Proceso de Habilitación</h2>
            <p>Mantén tu condición de habilitado para ejercer plenamente la profesión de antropólogo.</p>
        </div>

        <div class="col-steps-timeline col-steps-timeline--gold" data-aos="fade-up" data-aos-delay="100">

            <div class="col-step">
                <div class="col-step-icon col-step-icon--gold"><span>01</span></div>
                <div class="col-step-body">
                    <h3>Realizar depósito</h3>
                    <p>Deposita el monto correspondiente en la cuenta del CDD Región Centro en <strong>Caja Huancayo</strong>.</p>
                </div>
            </div>

            <div class="col-step">
                <div class="col-step-icon col-step-icon--gold"><span>02</span></div>
                <div class="col-step-body">
                    <h3>Enviar comprobante</h3>
                    <p>Envía el baucher por <strong>WhatsApp</strong> al <strong>943 667 317</strong> o preséntalo directamente en la oficina.</p>
                </div>
            </div>

            <div class="col-step">
                <div class="col-step-icon col-step-icon--gold"><span>03</span></div>
                <div class="col-step-body">
                    <h3>Confirmación del depósito</h3>
                    <p>El equipo administrativo verificará y confirmará la recepción de tu pago.</p>
                </div>
            </div>

            <div class="col-step">
                <div class="col-step-icon col-step-icon--gold"><span>04</span></div>
                <div class="col-step-body">
                    <h3>Verificación y actualización de datos</h3>
                    <p>Se revisan y actualizan tus datos en el sistema del colegio profesional.</p>
                </div>
            </div>

            <div class="col-step">
                <div class="col-step-icon col-step-icon--gold"><span>05</span></div>
                <div class="col-step-body">
                    <h3>Entrega del certificado de habilitación</h3>
                    <p>Recibirás tu certificado de habilidad en formato <strong>físico o virtual</strong>, según tu preferencia.</p>
                    <div class="col-step-note col-step-note--gold">
                        <i class="fas fa-info-circle"></i> Vigencia: trimestral o semestral según el Consejo Directivo.
                    </div>
                </div>
            </div>

        </div>

        {{-- Tarifas de habilitación --}}
        <div class="col-tariff-grid" data-aos="fade-up" data-aos-delay="200">
            <h3><i class="fas fa-tags"></i> Tasas de Pago – Habilitación</h3>
            <div class="col-tariff-cards">
                <div class="col-tariff-card">
                    <div class="col-tariff-header">Cuota Ordinaria</div>
                    <div class="col-tariff-price">S/. 10 <small>/mes</small></div>
                    <div class="col-tariff-alt">o S/. 120 al año</div>
                </div>
                <div class="col-tariff-card col-tariff-card--featured">
                    <div class="col-tariff-tag">Más elegido</div>
                    <div class="col-tariff-header">Campaña Anual</div>
                    <div class="col-tariff-price">S/. 100 <small>/año</small></div>
                    <div class="col-tariff-alt">Ahorra S/. 20 sobre la cuota regular</div>
                </div>
                <div class="col-tariff-card">
                    <div class="col-tariff-header">Tarifa Rebajada</div>
                    <div class="col-tariff-price">S/. 20 <small>/año</small></div>
                    <div class="col-tariff-alt">Casos especiales aprobados</div>
                </div>
            </div>
            <div class="col-tariff-notes">
                <p><i class="fas fa-star"></i> <strong>Exoneración:</strong> ex decanos y profesionales destacados de la tercera edad.</p>
                <p><i class="fas fa-heart"></i> <strong>Descuento 30%:</strong> por enfermedad o maternidad prematura, previa solicitud y evaluación.</p>
            </div>
        </div>
    </div>
</section>

{{-- ===== SECCIÓN 3: REGLAMENTO INTERNO ===== --}}
<section class="col-section" id="reglamento">
    <div class="cpap-container">
        <div class="col-section-header" data-aos="fade-up">
            <span class="col-badge"><i class="fas fa-book"></i> Normativa</span>
            <h2>Reglamento Interno de Habilitaciones</h2>
            <p>Conoce tus derechos, obligaciones y las condiciones para mantenerte como antropólogo habilitado.</p>
        </div>

        <div class="col-reglamento-grid" data-aos="fade-up" data-aos-delay="100">

            {{-- Requisitos --}}
            <div class="col-reg-card">
                <div class="col-reg-icon"><i class="fas fa-clipboard-check"></i></div>
                <h3>Requisitos</h3>
                <ul>
                    <li>Ser miembro colegiado activo</li>
                    <li>Estar al día en cuotas ordinarias y extraordinarias</li>
                    <li>No tener sanciones vigentes</li>
                    <li>Cumplir programas de actualización profesional</li>
                </ul>
            </div>

            {{-- Derechos --}}
            <div class="col-reg-card col-reg-card--accent">
                <div class="col-reg-icon"><i class="fas fa-balance-scale"></i></div>
                <h3>Derechos del Habilitado</h3>
                <ul>
                    <li>Ejercer la profesión legalmente</li>
                    <li>Participar en asambleas institucionales</li>
                    <li>Postular a cargos directivos</li>
                    <li>Obtener certificado de habilidad vigente</li>
                </ul>
            </div>

            {{-- Obligaciones --}}
            <div class="col-reg-card">
                <div class="col-reg-icon"><i class="fas fa-tasks"></i></div>
                <h3>Obligaciones</h3>
                <ul>
                    <li>Mantener datos personales actualizados</li>
                    <li>Pagar cuotas puntualmente</li>
                    <li>Cumplir con el código de ética profesional</li>
                </ul>
            </div>

            {{-- Sanciones --}}
            <div class="col-reg-card col-reg-card--warning">
                <div class="col-reg-icon"><i class="fas fa-exclamation-triangle"></i></div>
                <h3>Sanciones e Inhabilitación</h3>
                <ul>
                    <li>Falta de pago de una cuota consecutiva → inhabilitación automática</li>
                    <li>Sentencia judicial firme o sanción ética</li>
                    <li>Ejercicio ilegal sin habilitación será sancionado</li>
                </ul>
            </div>

        </div>

        {{-- Certificado de habilidad --}}
        <div class="col-cert-banner" data-aos="fade-up" data-aos-delay="200">
            <div class="col-cert-content">
                <div class="col-cert-icon"><i class="fas fa-award"></i></div>
                <div class="col-cert-text">
                    <h3>Certificado de Habilidad</h3>
                    <p>Documento oficial que acredita tu capacidad profesional como antropólogo habilitado. Vigencia trimestral o semestral según disposición del Consejo Directivo.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== CONTACTO CTA ===== --}}
<section class="col-cta-section">
    <div class="cpap-container">
        <div class="col-cta" data-aos="fade-up">
            <div class="col-cta-content">
                <h2>¿Tienes dudas sobre el proceso?</h2>
                <p>Contáctanos y te ayudaremos con tu trámite de colegiatura o habilitación.</p>
            </div>
            <div class="col-cta-info">
                <a href="https://wa.me/51943667317" target="_blank" class="col-cta-btn col-cta-btn--wa">
                    <i class="fab fa-whatsapp"></i> 943 667 317
                </a>
                <a href="mailto:cpap.rc@gmail.com" class="col-cta-btn">
                    <i class="fas fa-envelope"></i> cpap.rc@gmail.com
                </a>
                <div class="col-cta-address">
                    <i class="fas fa-map-marker-alt"></i> Jr. Arequipa N° 734, Huancayo
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
