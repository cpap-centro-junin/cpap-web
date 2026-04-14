@extends('layouts.app')

@section('title', 'Política de Privacidad - CPAP Región Centro')
@section('description', 'Política de privacidad y protección de datos del Colegio de Antropólogos del Perú - Región Centro')

@section('content')
<div class="legal-container" style="padding: 60px 20px; background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); min-height: 200px;">
    <div class="container">
        <h1 style="color: var(--dark); text-align: center; font-size: 2.5rem; margin-bottom: 10px;">
            <i class="fas fa-shield-alt" style="color: var(--primary); margin-right: 12px;"></i>Política de Privacidad
        </h1>
        <p style="text-align: center; color: var(--medium-gray); font-size: 1rem;">
            Conoce cómo protegemos tu información personal
        </p>
    </div>
</div>

<div class="container" style="max-width: 900px; padding: 60px 20px;">
    <div class="legal-content">
        <section class="legal-section" style="margin-bottom: 40px;">
            <h2 style="color: var(--primary); font-size: 1.5rem; margin-bottom: 20px; border-bottom: 3px solid var(--primary); padding-bottom: 10px;">
                1. Información que Recopilamos
            </h2>
            <p style="line-height: 1.8; color: var(--dark); margin-bottom: 15px;">
                El Colegio de Antropólogos del Perú - Región Centro (en adelante, "CPAP") recopila información personal que usted voluntariamente proporciona a través de nuestro sitio web, tales como:
            </p>
            <ul style="margin-left: 30px; line-height: 1.8; color: var(--dark);">
                <li>Nombre completo</li>
                <li>Correo electrónico</li>
                <li>Número de teléfono</li>
                <li>Dirección física</li>
                <li>Información profesional y académica</li>
                <li>Datos de colegiación</li>
                <li>Información de pago</li>
            </ul>
        </section>

        <section class="legal-section" style="margin-bottom: 40px;">
            <h2 style="color: var(--primary); font-size: 1.5rem; margin-bottom: 20px; border-bottom: 3px solid var(--primary); padding-bottom: 10px;">
                2. Uso de la Información
            </h2>
            <p style="line-height: 1.8; color: var(--dark); margin-bottom: 15px;">
                Utilizamos la información recopilada para:
            </p>
            <ul style="margin-left: 30px; line-height: 1.8; color: var(--dark);">
                <li>Procesar solicitudes de colegiación y renovación</li>
                <li>Gestionar consultas y solicitudes de información</li>
                <li>Enviar comunicaciones relevantes sobre nuestros servicios</li>
                <li>Mejorar nuestro sitio web y servicios</li>
                <li>Cumplir con obligaciones legales y regulatorias</li>
                <li>Prevenir fraude y actividades ilícitas</li>
            </ul>
        </section>

        <section class="legal-section" style="margin-bottom: 40px;">
            <h2 style="color: var(--primary); font-size: 1.5rem; margin-bottom: 20px; border-bottom: 3px solid var(--primary); padding-bottom: 10px;">
                3. Protección de Datos
            </h2>
            <p style="line-height: 1.8; color: var(--dark); margin-bottom: 15px;">
                Implementamos medidas técnicas, administrativas y físicas para proteger sus datos personales contra acceso no autorizado, alteración, divulgación o destrucción. Nuestras medidas incluyen:
            </p>
            <ul style="margin-left: 30px; line-height: 1.8; color: var(--dark);">
                <li>Encriptación de datos en tránsito (SSL/TLS)</li>
                <li>Acceso restringido a información sensible</li>
                <li>Auditorías de seguridad periódicas</li>
                <li>Capacitación de personal en privacidad de datos</li>
                <li>Políticas de retención de datos</li>
            </ul>
        </section>

        <section class="legal-section" style="margin-bottom: 40px;">
            <h2 style="color: var(--primary); font-size: 1.5rem; margin-bottom: 20px; border-bottom: 3px solid var(--primary); padding-bottom: 10px;">
                4. Compartir Información
            </h2>
            <p style="line-height: 1.8; color: var(--dark); margin-bottom: 15px;">
                No vendemos, alquilamos ni compartimos su información personal con terceros sin su consentimiento, excepto:
            </p>
            <ul style="margin-left: 30px; line-height: 1.8; color: var(--dark);">
                <li>Proveedores de servicios que ayudan con nuestras operaciones</li>
                <li>Autoridades legales cuando sea requerido por ley</li>
                <li>Entidades cooperantes autorizadas según nuestros estatutos</li>
            </ul>
        </section>

        <section class="legal-section" style="margin-bottom: 40px;">
            <h2 style="color: var(--primary); font-size: 1.5rem; margin-bottom: 20px; border-bottom: 3px solid var(--primary); padding-bottom: 10px;">
                5. Cookies y Tecnologías de Rastreo
            </h2>
            <p style="line-height: 1.8; color: var(--dark); margin-bottom: 15px;">
                Nuestro sitio web utiliza cookies para mejorar su experiencia de navegación. Las cookies nos ayudan a:
            </p>
            <ul style="margin-left: 30px; line-height: 1.8; color: var(--dark);">
                <li>Recordar sus preferencias</li>
                <li>Mantener sesiones de usuario</li>
                <li>Analizar el tráfico del sitio web</li>
                <li>Personalizar el contenido</li>
            </ul>
            <p style="line-height: 1.8; color: var(--dark); margin-top: 15px;">
                Puede configurar su navegador para rechazar cookies, aunque esto puede afectar la funcionalidad del sitio.
            </p>
        </section>

        <section class="legal-section" style="margin-bottom: 40px;">
            <h2 style="color: var(--primary); font-size: 1.5rem; margin-bottom: 20px; border-bottom: 3px solid var(--primary); padding-bottom: 10px;">
                6. Derechos del Usuario
            </h2>
            <p style="line-height: 1.8; color: var(--dark); margin-bottom: 15px;">
                Conforme a la legislación vigente, tiene derecho a:
            </p>
            <ul style="margin-left: 30px; line-height: 1.8; color: var(--dark);">
                <li><strong>Acceso:</strong> Solicitar acceso a sus datos personales</li>
                <li><strong>Rectificación:</strong> Corregir información inexacta</li>
                <li><strong>Eliminación:</strong> Solicitar la eliminación de sus datos</li>
                <li><strong>Oposición:</strong> Oponerse al tratamiento de sus datos</li>
                <li><strong>Portabilidad:</strong> Recibir sus datos en formato estructurado</li>
            </ul>
        </section>

        <section class="legal-section" style="margin-bottom: 40px;">
            <h2 style="color: var(--primary); font-size: 1.5rem; margin-bottom: 20px; border-bottom: 3px solid var(--primary); padding-bottom: 10px;">
                7. Contacto
            </h2>
            <p style="line-height: 1.8; color: var(--dark);">
                Para ejercer cualquier derecho relacionado con sus datos personales o si tiene preguntas sobre esta política, contáctenos:
            </p>
            <div style="background: rgba(139, 21, 56, 0.08); padding: 20px; border-radius: 8px; margin-top: 15px;">
                <p style="margin: 5px 0;"><strong><i class="fas fa-envelope"></i> Email:</strong> <a href="mailto:cpap.rc@gmail.com" style="color: var(--primary);">cpap.rc@gmail.com</a></p>
                <p style="margin: 5px 0;"><strong><i class="fas fa-phone"></i> Teléfono:</strong> <a href="tel:+51943667317" style="color: var(--primary);">+51 943 667 317</a></p>
                <p style="margin: 5px 0;"><strong><i class="fas fa-map-marker-alt"></i> Dirección:</strong> Jr. Arequipa 734, Huancayo, Junín - Perú</p>
            </div>
        </section>

        <section class="legal-section" style="margin-bottom: 40px;">
            <h2 style="color: var(--primary); font-size: 1.5rem; margin-bottom: 20px; border-bottom: 3px solid var(--primary); padding-bottom: 10px;">
                8. Cambios en esta Política
            </h2>
            <p style="line-height: 1.8; color: var(--dark);">
                Nos reservamos el derecho de actualizar esta política de privacidad en cualquier momento. Los cambios serán publicados en esta página con una fecha de actualización. Su uso continuo del sitio web constituye su aceptación de los cambios.
            </p>
            <p style="margin-top: 20px; color: var(--medium-gray); font-size: 0.9rem;">
                <strong>Última actualización:</strong> {{ date('d de F de Y', strtotime('2026-04-14')) }}
            </p>
        </section>
    </div>

    <div style="background: rgba(139, 21, 56, 0.08); padding: 25px; border-radius: 8px; border-left: 5px solid var(--primary);">
        <h3 style="color: var(--primary); margin-top: 0;">Nota Importante</h3>
        <p style="margin: 10px 0; color: var(--dark); line-height: 1.6;">
            Esta política de privacidad es parte integral de nuestro compromiso con la protección de sus derechos. Al usar nuestro sitio web, usted acepta las términos descritos en esta política. Si no está de acuerdo con alguno de nuestros términos, le recomendamos no utilizar el sitio.
        </p>
    </div>
</div>

@endsection
