@extends('layouts.app')

@section('title', $colegiado->nombre_completo . ' | Directorio CPAP')

{{-- Styles en resources/css/pages/colegiado-perfil.css --}}

@section('content')

<div class="perfil-hero">

    {{-- Enlace volver --}}
    <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('colegiados.index') }}"
       class="perfil-back">
        <i class="fas fa-arrow-left"></i>
        Volver al directorio
    </a>

    <div class="perfil-hero-inner" data-aos="fade-up">

        {{-- Avatar --}}
        <div class="perfil-avatar-wrap">
            @if($colegiado->foto && !$colegiado->ocultar_foto)
                <img src="{{ Storage::url($colegiado->foto) }}"
                     alt="{{ $colegiado->nombre_completo }}"
                     class="perfil-avatar">
            @else
                <div class="perfil-avatar-placeholder">
                    {{ strtoupper(substr($colegiado->nombres, 0, 1) . substr($colegiado->apellidos, 0, 1)) }}
                </div>
            @endif
        </div>

        {{-- Info Header --}}
        <div class="perfil-hero-info">
            <div class="perfil-hero-badge">
                <i class="fas fa-id-badge"></i>
                Sección CPAP &mdash; Perfil Oficial
            </div>
            <h1 class="perfil-nombre">{{ $colegiado->nombre_completo }}</h1>
            <p class="perfil-codigo">
                {{ $colegiado->codigo_cpap }}
                @if($colegiado->orientacion && !$colegiado->ocultar_orientacion)
                    &nbsp;&middot;&nbsp; {{ $colegiado->orientacion }}
                    @if($colegiado->especialidad && !$colegiado->ocultar_especialidad)
                        &nbsp;&middot;&nbsp; <span style="opacity:0.8;">{{ $colegiado->especialidad }}</span>
                    @endif
                @elseif($colegiado->especialidad && !$colegiado->ocultar_especialidad)
                    &nbsp;&middot;&nbsp; {{ $colegiado->especialidad }}
                @endif
            </p>
            @if($colegiado->estado === 'activo')
                <span class="perfil-estado-badge activo">
                    <i class="fas fa-check-circle"></i>
                    Habilitado
                </span>
            @else
                <span class="perfil-estado-badge inactivo">
                    <i class="fas fa-times-circle"></i>
                    No Habilitado
                </span>
            @endif
        </div>

    </div>
</div>

{{-- CONTENIDO PRINCIPAL --}}
<section class="perfil-main">
    <div class="perfil-container">

        <div class="perfil-card" data-aos="fade-up" data-aos-delay="100">

            {{-- ---- DATOS PERSONALES ---- --}}
            <div class="perfil-card-section">
                <h2 class="section-title">
                    <i class="fas fa-user"></i>
                    Datos Profesionales
                </h2>
                <div class="info-grid">
                    @if($colegiado->orientacion && !$colegiado->ocultar_orientacion)
                    <div class="info-field">
                        <label>Orientación</label>
                        <span>{{ $colegiado->orientacion }}</span>
                    </div>
                    @endif
                    @if($colegiado->especialidad && !$colegiado->ocultar_especialidad)
                    <div class="info-field">
                        <label>Especialización</label>
                        <span>{{ $colegiado->especialidad }}</span>
                    </div>
                    @endif

                    @if($colegiado->universidad && !$colegiado->ocultar_universidad)
                    <div class="info-field">
                        <label>Universidad</label>
                        <span>{{ $colegiado->universidad }}</span>
                    </div>
                    @endif

                    @if($colegiado->anio_graduacion && !$colegiado->ocultar_anio_graduacion)
                    <div class="info-field">
                        <label>Año de Graduación</label>
                        <span>{{ $colegiado->anio_graduacion }}</span>
                    </div>
                    @endif

                    @if($colegiado->fecha_colegiatura && !$colegiado->ocultar_fecha_colegiatura)
                    <div class="info-field">
                        <label>Fecha de Colegiatura</label>
                        <span>{{ $colegiado->fecha_colegiatura->format('d/m/Y') }}</span>
                    </div>
                    @endif

                    @if($colegiado->email && !$colegiado->ocultar_email)
                    <div class="info-field">
                        <label>Correo Electrónico</label>
                        <span>{{ $colegiado->email }}</span>
                    </div>
                    @endif

                    @if($colegiado->telefono && !$colegiado->ocultar_telefono)
                    <div class="info-field">
                        <label>Teléfono</label>
                        <span>{{ $colegiado->telefono }}</span>
                    </div>
                    @endif

                    <div class="info-field">
                        <label>Número de Colegiatura</label>
                        <span>{{ $colegiado->codigo_cpap }}</span>
                    </div>

                    <div class="info-field">
                        <label>Estado</label>
                        <span>{{ $colegiado->estado === 'activo' ? 'Habilitado' : 'No Habilitado' }}</span>
                    </div>
                </div>
            </div>

            {{-- ---- DESCRIPCIÓN (si existe y no está oculta) ---- --}}
            @if($colegiado->descripcion && !$colegiado->ocultar_descripcion)
            <div class="perfil-card-section">
                <h2 class="section-title">
                    <i class="fas fa-align-left"></i>
                    Acerca del Profesional
                </h2>
                <p class="descripcion-texto">{{ $colegiado->descripcion }}</p>
            </div>
            @endif

            {{-- ---- DOCUMENTO DE HABILITACIÓN ---- --}}
            <div class="perfil-card-section">
                <h2 class="section-title">
                    <i class="fas fa-file-certificate"></i>
                    Documento de Habilitación
                </h2>

                @if($habilitacion)
                    <div class="habilitacion-box">

                        {{-- QR Code --}}
                        @if($habilitacion->qr_path && file_exists(public_path($habilitacion->qr_path)))
                        <div class="habilitacion-qr-col">
                            <img src="{{ asset($habilitacion->qr_path) }}"
                                 alt="QR de verificación"
                                 class="habilitacion-qr-img">
                            <p class="habilitacion-qr-label">Escanea para verificar</p>
                        </div>
                        @endif

                        {{-- Info habilitación --}}
                        <div class="habilitacion-info-col">

                            @if($habilitacion->activo)
                                <div class="hab-estado vigente">
                                    <i class="fas fa-check-circle"></i>
                                    Documento Vigente
                                </div>
                            @else
                                <div class="hab-estado revocado">
                                    <i class="fas fa-ban"></i>
                                    Documento Revocado
                                </div>
                            @endif

                            <div class="habilitacion-fields">
                                <div class="hab-field">
                                    <label>Código de Verificación</label>
                                    <code>{{ $habilitacion->codigo_verificacion }}</code>
                                </div>
                                <div class="hab-field">
                                    <label>Fecha de Emisión</label>
                                    <span>{{ $habilitacion->fecha_subida->format('d \d\e F \d\e Y') }}</span>
                                </div>
                                <div class="hab-field">
                                    <label>URL de Verificación</label>
                                    <code>{{ $habilitacion->url_corta }}</code>
                                </div>
                            </div>

                            <div class="hab-acciones">
                                @if($habilitacion->activo)
                                    <a href="{{ route('verificacion.show', $habilitacion->codigo_verificacion) }}"
                                       class="btn btn-primary"
                                       target="_blank">
                                        <i class="fas fa-shield-alt"></i>
                                        Verificar Documento
                                    </a>
                                    <a href="{{ route('verificacion.descargar', $habilitacion->codigo_verificacion) }}"
                                       class="btn btn-outline"
                                       target="_blank"
                                       rel="noopener">
                                        <i class="fas fa-download"></i>
                                        Descargar PDF
                                    </a>
                                @else
                                    <span class="btn btn-outline" style="cursor:default; opacity:0.6;">
                                        <i class="fas fa-ban"></i>
                                        Documento Revocado
                                    </span>
                                @endif

                                @if($colegiado->cv_path && !$colegiado->ocultar_cv)
                                    <a href="{{ route('colegiados.descargar-cv', $colegiado) }}"
                                       class="btn btn-outline"
                                       target="_blank"
                                       rel="noopener">
                                        <i class="fas fa-file-pdf"></i>
                                        Descargar CV
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                @else
                    <div class="sin-habilitacion">
                        <i class="fas fa-file-times"></i>
                        <div>
                            <h4>Sin documento de habilitación</h4>
                            <p>Este colegiado no cuenta con un documento de habilitación registrado en el sistema.</p>
                        </div>
                    </div>
                @endif
            </div>

            {{-- ---- NOTA INSTITUCIONAL ---- --}}
            <div class="perfil-footer-note">
                <i class="fas fa-shield-alt"></i>
                <p>
                    La información mostrada es oficial y pertenece al registro del
                    <strong>Colegio Profesional de Antropólogos del Perú &mdash; Región Centro</strong>.
                    Para verificar la autenticidad del documento, escanea el código QR o ingresa el código de verificación en nuestra plataforma.
                </p>
            </div>

        </div>

        {{-- Botón de regreso --}}
        <div style="text-align:center; margin-top:32px;">
            <a href="{{ route('colegiados.index') }}" class="btn btn-outline">
                <i class="fas fa-users"></i>
                Ver Directorio Completo
            </a>
        </div>

    </div>
</section>

@endsection
