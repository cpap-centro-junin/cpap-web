@extends('layouts.app')

@section('title', 'Mapa del Sitio - CPAP Región Centro')
@section('description', 'Navegación completa del sitio web del Colegio de Antropólogos del Perú - Región Centro')

@section('content')
<div class="legal-container" style="padding: 60px 20px; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); min-height: 200px;">
    <div class="container">
        <h1 style="color: white; text-align: center; font-size: 2.5rem; margin-bottom: 10px;">
            <i class="fas fa-sitemap" style="margin-right: 12px;"></i>Mapa del Sitio
        </h1>
        <p style="text-align: center; color: rgba(255,255,255,0.9); font-size: 1rem;">
            Estructura completa de nuestro sitio web
        </p>
    </div>
</div>

<div class="container" style="max-width: 900px; padding: 60px 20px;">
    <div class="sitemap-content">
        {{-- Sección Principal --}}
        <section style="margin-bottom: 40px;">
            <h2 style="color: var(--primary); font-size: 1.3rem; margin-bottom: 15px; padding-bottom: 10px; border-bottom: 2px solid rgba(139,21,56,0.2);">
                <i class="fas fa-home" style="margin-right: 8px;"></i>Páginas Principales
            </h2>
            <ul style="list-style: none; padding: 0; margin: 0;">
                <li style="padding: 8px 0; border-bottom: 1px solid rgba(0,0,0,0.05);">
                    <a href="{{ url('/') }}" style="color: var(--primary); text-decoration: none; font-weight: 500;">
                        <i class="fas fa-chevron-right" style="margin-right: 8px; color: var(--medium-gray);"></i>Inicio
                    </a>
                </li>
                <li style="padding: 8px 0; border-bottom: 1px solid rgba(0,0,0,0.05);">
                    <a href="{{ route('contacto.index') }}" style="color: var(--primary); text-decoration: none; font-weight: 500;">
                        <i class="fas fa-chevron-right" style="margin-right: 8px; color: var(--medium-gray);"></i>Contacto
                    </a>
                </li>
            </ul>
        </section>

        {{-- Sección Sobre Nosotros --}}
        <section style="margin-bottom: 40px;">
            <h2 style="color: var(--primary); font-size: 1.3rem; margin-bottom: 15px; padding-bottom: 10px; border-bottom: 2px solid rgba(139,21,56,0.2);">
                <i class="fas fa-info-circle" style="margin-right: 8px;"></i>Sobre Nosotros
            </h2>
            <ul style="list-style: none; padding: 0; margin: 0;">
                <li style="padding: 8px 0; border-bottom: 1px solid rgba(0,0,0,0.05);">
                    <a href="{{ url('/nosotros/mision-vision') }}" style="color: var(--primary); text-decoration: none; font-weight: 500;">
                        <i class="fas fa-chevron-right" style="margin-right: 8px; color: var(--medium-gray);"></i>Misión y Visión
                    </a>
                </li>
                <li style="padding: 8px 0; border-bottom: 1px solid rgba(0,0,0,0.05);">
                    <a href="{{ url('/nosotros/historia') }}" style="color: var(--primary); text-decoration: none; font-weight: 500;">
                        <i class="fas fa-chevron-right" style="margin-right: 8px; color: var(--medium-gray);"></i>Historia
                    </a>
                </li>
                <li style="padding: 8px 0; border-bottom: 1px solid rgba(0,0,0,0.05);">
                    <a href="{{ url('/nosotros/consejo-directivo') }}" style="color: var(--primary); text-decoration: none; font-weight: 500;">
                        <i class="fas fa-chevron-right" style="margin-right: 8px; color: var(--medium-gray);"></i>Consejo Directivo
                    </a>
                </li>
                <li style="padding: 8px 0; border-bottom: 1px solid rgba(0,0,0,0.05);">
                    <a href="{{ url('/nosotros/normativa-legal') }}" style="color: var(--primary); text-decoration: none; font-weight: 500;">
                        <i class="fas fa-chevron-right" style="margin-right: 8px; color: var(--medium-gray);"></i>Normativa Legal
                    </a>
                </li>
                <li style="padding: 8px 0;">
                    <a href="{{ url('/nosotros/plan-2026') }}" style="color: var(--primary); text-decoration: none; font-weight: 500;">
                        <i class="fas fa-chevron-right" style="margin-right: 8px; color: var(--medium-gray);"></i>Plan Operativo 2026
                    </a>
                </li>
            </ul>
        </section>

        {{-- Sección Servicios --}}
        <section style="margin-bottom: 40px;">
            <h2 style="color: var(--primary); font-size: 1.3rem; margin-bottom: 15px; padding-bottom: 10px; border-bottom: 2px solid rgba(139,21,56,0.2);">
                <i class="fas fa-briefcase" style="margin-right: 8px;"></i>Servicios
            </h2>
            <ul style="list-style: none; padding: 0; margin: 0;">
                <li style="padding: 8px 0; border-bottom: 1px solid rgba(0,0,0,0.05);">
                    <a href="{{ route('colegiatura.index') }}" style="color: var(--primary); text-decoration: none; font-weight: 500;">
                        <i class="fas fa-chevron-right" style="margin-right: 8px; color: var(--medium-gray);"></i>Colegiación
                    </a>
                </li>
                <li style="padding: 8px 0; border-bottom: 1px solid rgba(0,0,0,0.05);">
                    <a href="{{ route('biblioteca') }}" style="color: var(--primary); text-decoration: none; font-weight: 500;">
                        <i class="fas fa-chevron-right" style="margin-right: 8px; color: var(--medium-gray);"></i>Biblioteca Virtual
                    </a>
                </li>
                <li style="padding: 8px 0; border-bottom: 1px solid rgba(0,0,0,0.05);">
                    <a href="{{ route('bolsa-trabajo') }}" style="color: var(--primary); text-decoration: none; font-weight: 500;">
                        <i class="fas fa-chevron-right" style="margin-right: 8px; color: var(--medium-gray);"></i>Bolsa de Trabajo
                    </a>
                </li>
                <li style="padding: 8px 0;">
                    <a href="{{ url('/colegiados') }}" style="color: var(--primary); text-decoration: none; font-weight: 500;">
                        <i class="fas fa-chevron-right" style="margin-right: 8px; color: var(--medium-gray);"></i>Directorio de Colegiados
                    </a>
                </li>
            </ul>
        </section>

        {{-- Sección Información Pública --}}
        <section style="margin-bottom: 40px;">
            <h2 style="color: var(--primary); font-size: 1.3rem; margin-bottom: 15px; padding-bottom: 10px; border-bottom: 2px solid rgba(139,21,56,0.2);">
                <i class="fas fa-newspaper" style="margin-right: 8px;"></i>Información Pública
            </h2>
            <ul style="list-style: none; padding: 0; margin: 0;">
                <li style="padding: 8px 0; border-bottom: 1px solid rgba(0,0,0,0.05);">
                    <a href="{{ route('noticias.index') }}" style="color: var(--primary); text-decoration: none; font-weight: 500;">
                        <i class="fas fa-chevron-right" style="margin-right: 8px; color: var(--medium-gray);"></i>Noticias
                    </a>
                    <span style="margin-left: 30px; color: var(--medium-gray); font-size: 0.85rem;">({{ $noticias->count() }} artículos)</span>
                </li>
                <li style="padding: 8px 0; border-bottom: 1px solid rgba(0,0,0,0.05);">
                    <a href="{{ url('/#eventos') }}" style="color: var(--primary); text-decoration: none; font-weight: 500;">
                        <i class="fas fa-chevron-right" style="margin-right: 8px; color: var(--medium-gray);"></i>Eventos
                    </a>
                    <span style="margin-left: 30px; color: var(--medium-gray); font-size: 0.85rem;">({{ $eventos->count() }} eventos)</span>
                </li>
                <li style="padding: 8px 0;">
                    <a href="{{ url('/galeria') }}" style="color: var(--primary); text-decoration: none; font-weight: 500;">
                        <i class="fas fa-chevron-right" style="margin-right: 8px; color: var(--medium-gray);"></i>Galería Institucional
                    </a>
                </li>
            </ul>
        </section>

        {{-- Sección Biblioteca --}}
        <section style="margin-bottom: 40px;">
            <h2 style="color: var(--primary); font-size: 1.3rem; margin-bottom: 15px; padding-bottom: 10px; border-bottom: 2px solid rgba(139,21,56,0.2);">
                <i class="fas fa-book" style="margin-right: 8px;"></i>Biblioteca Virtual
            </h2>
            <p style="color: var(--medium-gray); margin-bottom: 12px; font-size: 0.9rem;">
                Total de recursos disponibles: <strong>{{ $recursos->count() }} recursos</strong>
            </p>
            @if($recursos->count() > 0)
                <ul style="list-style: none; padding: 0; margin: 0; columns: 2; gap: 20px;">
                    @foreach($recursos->take(20) as $recurso)
                        <li style="padding: 8px 0; border-bottom: 1px solid rgba(0,0,0,0.05); break-inside: avoid;">
                            <a href="{{ route('biblioteca.show', $recurso) }}" style="color: var(--primary); text-decoration: none; font-size: 0.95rem;">
                                <i class="fas fa-file-pdf" style="margin-right: 6px; color: var(--medium-gray);"></i>{{ $recurso->titulo }}
                            </a>
                        </li>
                    @endforeach
                </ul>
                @if($recursos->count() > 20)
                    <div style="margin-top: 15px; text-align: center;">
                        <a href="{{ route('biblioteca') }}" style="color: var(--primary); text-decoration: none; font-weight: 500;">
                            Ver todos los recursos →
                        </a>
                    </div>
                @endif
            @else
                <p style="color: var(--medium-gray);">No hay recursos disponibles en este momento.</p>
            @endif
        </section>

        {{-- Sección Colegiados --}}
        <section style="margin-bottom: 40px;">
            <h2 style="color: var(--primary); font-size: 1.3rem; margin-bottom: 15px; padding-bottom: 10px; border-bottom: 2px solid rgba(139,21,56,0.2);">
                <i class="fas fa-users" style="margin-right: 8px;"></i>Directorio de Colegiados
            </h2>
            <p style="color: var(--medium-gray); margin-bottom: 12px; font-size: 0.9rem;">
                Total de colegiados: <strong>{{ $colegiados->count() }} profesionales</strong>
            </p>
            <a href="{{ url('/colegiados') }}" style="color: var(--primary); text-decoration: none; font-weight: 500; display: inline-block; margin-top: 10px;">
                <i class="fas fa-chevron-right" style="margin-right: 6px;"></i>Ver directorio completo
            </a>
        </section>

        {{-- Sección Documentos y Políticas --}}
        <section style="margin-bottom: 40px;">
            <h2 style="color: var(--primary); font-size: 1.3rem; margin-bottom: 15px; padding-bottom: 10px; border-bottom: 2px solid rgba(139,21,56,0.2);">
                <i class="fas fa-gavel" style="margin-right: 8px;"></i>Documentos Legales
            </h2>
            <ul style="list-style: none; padding: 0; margin: 0;">
                <li style="padding: 8px 0; border-bottom: 1px solid rgba(0,0,0,0.05);">
                    <a href="{{ route('legal.privacidad') }}" style="color: var(--primary); text-decoration: none; font-weight: 500;">
                        <i class="fas fa-chevron-right" style="margin-right: 8px; color: var(--medium-gray);"></i>Política de Privacidad
                    </a>
                </li>
                <li style="padding: 8px 0;">
                    <a href="{{ route('legal.terminos') }}" style="color: var(--primary); text-decoration: none; font-weight: 500;">
                        <i class="fas fa-chevron-right" style="margin-right: 8px; color: var(--medium-gray);"></i>Términos y Condiciones
                    </a>
                </li>
            </ul>
        </section>

        {{-- Sección SEO --}}
        <section style="margin-bottom: 40px;">
            <h2 style="color: var(--primary); font-size: 1.3rem; margin-bottom: 15px; padding-bottom: 10px; border-bottom: 2px solid rgba(139,21,56,0.2);">
                <i class="fas fa-spider" style="margin-right: 8px;"></i>Archivos SEO
            </h2>
            <ul style="list-style: none; padding: 0; margin: 0;">
                <li style="padding: 8px 0; border-bottom: 1px solid rgba(0,0,0,0.05);">
                    <a href="{{ route('sitemap') }}" style="color: var(--primary); text-decoration: none; font-weight: 500;">
                        <i class="fas fa-chevron-right" style="margin-right: 8px; color: var(--medium-gray);"></i>sitemap.xml
                    </a>
                </li>
                <li style="padding: 8px 0;">
                    <a href="{{ url('/robots.txt') }}" style="color: var(--primary); text-decoration: none; font-weight: 500;">
                        <i class="fas fa-chevron-right" style="margin-right: 8px; color: var(--medium-gray);"></i>robots.txt
                    </a>
                </li>
            </ul>
        </section>

        <div style="background: rgba(139, 21, 56, 0.08); padding: 20px; border-radius: 8px; border-left: 5px solid var(--primary); margin-top: 40px;">
            <h3 style="color: var(--primary); margin-top: 0;">¿No encontraste lo que buscas?</h3>
            <p style="margin: 10px 0; color: var(--dark); line-height: 1.6;">
                Puedes <a href="{{ route('contacto.index') }}" style="color: var(--primary); text-decoration: none; font-weight: 600;">contactarnos directamente</a> para recibir asistencia adicional. Nuestro equipo estará encantado de ayudarte.
            </p>
        </div>
    </div>
</div>

@endsection
