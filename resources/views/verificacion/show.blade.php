@extends('layouts.app')

@section('title', 'Verificación de Documento | CPAP')

{{-- Styles en resources/css/pages/verificacion.css --}}

@section('content')

<section class="verificacion-section">
    <div class="verificacion-container">

        {{-- HEADER: Verificación exitosa --}}
        <div class="verificacion-header" data-aos="fade-down">
            <div class="verificacion-icon success">
                <i class="fas fa-check-circle"></i>
            </div>
            <h1>Documento Verificado</h1>
            <p class="subtitle">Este documento de habilitación es auténtico y está vigente</p>
        </div>

        {{-- LAYOUT PRINCIPAL: info + visor PDF --}}
        <div class="verificacion-layout" data-aos="fade-up">

            {{-- COLUMNA IZQUIERDA: datos del colegiado --}}
            <div class="verificacion-sidebar">

                {{-- Foto y nombre --}}
                <div class="sidebar-perfil">
                    @if($colegiado->foto)
                        <img src="{{ Storage::url($colegiado->foto) }}"
                             alt="{{ $colegiado->nombre_completo }}"
                             class="sidebar-avatar">
                    @else
                        <div class="sidebar-avatar-placeholder">
                            {{ strtoupper(substr($colegiado->nombres, 0, 1) . substr($colegiado->apellidos, 0, 1)) }}
                        </div>
                    @endif
                    <h2 class="sidebar-nombre">{{ $colegiado->nombre_completo }}</h2>
                    <p class="sidebar-codigo">{{ $colegiado->codigo_cpap }}</p>

                    @if($colegiado->estado === 'activo')
                        <span class="estado-pill activo">
                            <i class="fas fa-circle" style="font-size:7px;"></i>
                            ACTIVO Y VIGENTE
                        </span>
                    @else
                        <span class="estado-pill inactivo">
                            <i class="fas fa-circle" style="font-size:7px;"></i>
                            INACTIVO
                        </span>
                    @endif
                </div>

                {{-- Info profesional --}}
                <div class="sidebar-info">
                    @if($colegiado->orientacion)
                    <div class="sidebar-field">
                        <i class="fas fa-compass"></i>
                        <div>
                            <label>Orientación</label>
                            <span>{{ $colegiado->orientacion }}</span>
                        </div>
                    </div>
                    @endif

                    @if($colegiado->especialidad)
                    <div class="sidebar-field">
                        <i class="fas fa-briefcase"></i>
                        <div>
                            <label>Especialización</label>
                            <span>{{ $colegiado->especialidad }}</span>
                        </div>
                    </div>
                    @endif

                    @if($colegiado->universidad)
                    <div class="sidebar-field">
                        <i class="fas fa-university"></i>
                        <div>
                            <label>Universidad</label>
                            <span>{{ $colegiado->universidad }}</span>
                        </div>
                    </div>
                    @endif

                    <div class="sidebar-field">
                        <i class="fas fa-fingerprint"></i>
                        <div>
                            <label>DNI</label>
                            <span>{{ substr($colegiado->dni, 0, 4) }}****</span>
                        </div>
                    </div>
                </div>

                {{-- Info del documento --}}
                <div class="sidebar-doc">
                    <div class="sidebar-field">
                        <i class="fas fa-calendar-alt"></i>
                        <div>
                            <label>Fecha de Emisión</label>
                            <span>{{ $habilitacion->fecha_subida->format('d/m/Y') }}</span>
                        </div>
                    </div>
                    <div class="sidebar-field">
                        <i class="fas fa-qrcode"></i>
                        <div>
                            <label>Código de Verificación</label>
                            <code>{{ Str::limit($habilitacion->codigo_verificacion, 28) }}</code>
                        </div>
                    </div>
                    <div class="sidebar-field">
                        <i class="fas fa-clock"></i>
                        <div>
                            <label>Verificado el</label>
                            <span>{{ now()->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>
                </div>

                {{-- Nota de autenticidad --}}
                <div class="sidebar-nota">
                    <i class="fas fa-shield-alt"></i>
                    <p>Verificado contra la base de datos oficial del <strong>Colegio Profesional de Antropólogos del Perú — Región Centro</strong>.</p>
                </div>

            </div>

            {{-- COLUMNA DERECHA: visor PDF --}}
            <div class="pdf-viewer-col">

                {{-- Barra superior del visor (toolbar al estilo Udemy) --}}
                <div class="pdf-toolbar">
                    <div class="pdf-toolbar-left">
                        <i class="fas fa-file-pdf pdf-toolbar-icon"></i>
                        <span class="pdf-toolbar-title">
                            Habilitación — {{ $colegiado->codigo_cpap }}
                        </span>
                    </div>
                    <div class="pdf-toolbar-right">
                        <a href="{{ route('verificacion.descargar', $habilitacion->codigo_verificacion) }}"
                           target="_blank"
                           rel="noopener"
                           class="pdf-toolbar-btn"
                           title="Abrir en pantalla completa">
                            <i class="fas fa-expand-alt"></i>
                            Pantalla completa
                        </a>
                        <a href="{{ route('verificacion.descargar', $habilitacion->codigo_verificacion) }}"
                           target="_blank"
                           rel="noopener"
                           class="pdf-toolbar-btn pdf-toolbar-btn-primary"
                           download>
                            <i class="fas fa-download"></i>
                            Descargar PDF
                        </a>
                    </div>
                </div>

                {{-- Iframe del PDF --}}
                <div class="pdf-frame-wrapper">
                    <iframe
                        src="{{ route('verificacion.descargar', $habilitacion->codigo_verificacion) }}"
                        class="pdf-frame"
                        frameborder="0"
                        allowfullscreen
                        title="Documento de Habilitación {{ $colegiado->codigo_cpap }}"
                    ></iframe>
                </div>

                {{-- Nota inferior --}}
                <div class="pdf-frame-footer">
                    <i class="fas fa-info-circle"></i>
                    Si el documento no carga, haz clic en
                    <a href="{{ route('verificacion.descargar', $habilitacion->codigo_verificacion) }}" target="_blank" rel="noopener">
                        abrir en nueva pestaña
                    </a>.
                </div>

            </div>
        </div>

    </div>
</section>


@endsection
