@extends('layouts.admin')

@section('title', 'Detalle del Colegiado')
@section('page-title', 'Detalle del Colegiado')

@section('content')

<div class="admin-container">

    {{-- Mensajes de éxito --}}
    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            <div class="alert-body">
                {{ session('success') }}

                @if(session('codigo_generado'))
                    <div class="alert-code-block">
                        <div class="alert-code-row">
                            <span class="alert-code-label">Código de verificación:</span>
                            <code>{{ session('codigo_generado') }}</code>
                        </div>
                        <div class="alert-code-row">
                            <span class="alert-code-label">URL de verificación:</span>
                            <a href="{{ session('url_verificacion') }}" target="_blank">{{ session('url_verificacion') }}</a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endif

    {{-- Breadcrumb --}}
    <div class="breadcrumb">
        <a href="{{ route('admin.colegiados.index') }}">
            <i class="fas fa-id-card"></i> Colegiados
        </a>
        <span>/</span>
        <span>{{ $colegiado->codigo_cpap }}</span>
    </div>

    {{-- Header con acciones --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">
                {{ $colegiado->nombre_completo }}
                @if($colegiado->perfil_oculto)
                    <span class="badge-perfil-oculto">
                        <i class="fas fa-eye-slash"></i> Oculto
                    </span>
                @endif
            </h1>
            <p class="page-subtitle">{{ $colegiado->codigo_cpap }} &mdash; {{ $colegiado->dni }}</p>
        </div>
        <div class="action-header-buttons">
            {{-- Toggle rápido de visibilidad --}}
            <form action="{{ route('admin.colegiados.toggle-perfil-oculto', $colegiado) }}" method="POST" class="d-inline">
                @csrf
                @method('PATCH')
                <button type="submit"
                        class="btn btn-lg {{ $colegiado->perfil_oculto ? 'btn-outline-warning' : 'btn-outline-secondary' }}"
                        title="{{ $colegiado->perfil_oculto ? 'Hacer visible en directorio público' : 'Ocultar del directorio público' }}">
                    <i class="fas {{ $colegiado->perfil_oculto ? 'fa-eye' : 'fa-eye-slash' }}"></i>
                    {{ $colegiado->perfil_oculto ? 'Mostrar en público' : 'Ocultar de público' }}
                </button>
            </form>
            <a href="{{ route('admin.colegiados.edit', $colegiado) }}" class="btn btn-lg btn-secondary-outline">
                <i class="fas fa-pencil-alt"></i>
                Editar
            </a>
            <a href="{{ route('admin.habilitaciones.create', $colegiado) }}" class="btn btn-lg btn-primary">
                <i class="fas fa-certificate"></i>
                Subir Habilitación
            </a>
        </div>
    </div>

    {{-- Alerta: sin ningún documento (fue eliminado o nunca subido) --}}
    @if(!$tieneAlgunaHabilitacion)
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle"></i>
            <div class="alert-body">
                <strong>Sin habilitación activa.</strong>
                Este colegiado no tiene ningún documento de habilitación activo.
                No aparecerá en el directorio público hasta que se suba y active un documento.
                <a href="{{ route('admin.habilitaciones.create', $colegiado) }}" class="alert-link">
                    Subir habilitación →
                </a>
            </div>
        </div>
    {{-- Alerta: tiene documentos pero todos revocados --}}
    @elseif(!$tieneHabilitacionActiva)
        <div class="alert alert-warning">
            <i class="fas fa-ban"></i>
            <div class="alert-body">
                <strong>Habilitación revocada.</strong>
                El documento de habilitación fue revocado. El colegiado aparece en el directorio público como <strong>No Habilitado</strong>.
                Para reactivarlo, usa el botón <em>Reactivar</em> en la sección de habilitaciones, o sube un nuevo documento.
            </div>
        </div>
    @endif

    {{-- Panel de visibilidad (resumen rápido) --}}
    <div class="visibility-summary-panel {{ $colegiado->perfil_oculto ? 'visibility-summary-panel--oculto' : 'visibility-summary-panel--visible' }}">
        <div class="visibility-summary-panel__icon">
            <i class="fas {{ $colegiado->perfil_oculto ? 'fa-eye-slash' : 'fa-eye' }}"></i>
        </div>
        <div class="visibility-summary-panel__info">
            <strong>{{ $colegiado->perfil_oculto ? 'Perfil oculto del directorio público' : 'Perfil visible en el directorio público' }}</strong>
            <div class="visibility-summary-badges">
                @if($colegiado->foto)
                    <span class="vis-badge {{ $colegiado->ocultar_foto ? 'vis-badge--hidden' : 'vis-badge--visible' }}">
                        <i class="fas fa-user-circle"></i>
                        Foto {{ $colegiado->ocultar_foto ? 'oculta' : 'visible' }}
                    </span>
                @endif
                @if($colegiado->email)
                    <span class="vis-badge {{ $colegiado->ocultar_email ? 'vis-badge--hidden' : 'vis-badge--visible' }}">
                        <i class="fas fa-envelope"></i>
                        Email {{ $colegiado->ocultar_email ? 'oculto' : 'visible' }}
                    </span>
                @endif
                @if($colegiado->telefono)
                    <span class="vis-badge {{ $colegiado->ocultar_telefono ? 'vis-badge--hidden' : 'vis-badge--visible' }}">
                        <i class="fas fa-phone"></i>
                        Teléfono {{ $colegiado->ocultar_telefono ? 'oculto' : 'visible' }}
                    </span>
                @endif
                @if($colegiado->grado_academico)
                    <span class="vis-badge {{ $colegiado->ocultar_grado_academico ? 'vis-badge--hidden' : 'vis-badge--visible' }}">
                        <i class="fas fa-user-graduate"></i>
                        Grado {{ $colegiado->ocultar_grado_academico ? 'oculto' : 'visible' }}
                    </span>
                @endif
                @if($colegiado->orientacion)
                    <span class="vis-badge {{ $colegiado->ocultar_orientacion ? 'vis-badge--hidden' : 'vis-badge--visible' }}">
                        <i class="fas fa-compass"></i>
                        Orientación {{ $colegiado->ocultar_orientacion ? 'oculta' : 'visible' }}
                    </span>
                @endif
                @if($colegiado->especialidad)
                    <span class="vis-badge {{ $colegiado->ocultar_especialidad ? 'vis-badge--hidden' : 'vis-badge--visible' }}">
                        <i class="fas fa-flask"></i>
                        Especialización {{ $colegiado->ocultar_especialidad ? 'oculta' : 'visible' }}
                    </span>
                @endif
                @if($colegiado->diplomados)
                    <span class="vis-badge {{ $colegiado->ocultar_diplomados ? 'vis-badge--hidden' : 'vis-badge--visible' }}">
                        <i class="fas fa-certificate"></i>
                        Diplomados {{ $colegiado->ocultar_diplomados ? 'ocultos' : 'visibles' }}
                    </span>
                @endif
                @if($colegiado->experiencia_anos || $colegiado->experiencia_sector)
                    <span class="vis-badge {{ $colegiado->ocultar_experiencia ? 'vis-badge--hidden' : 'vis-badge--visible' }}">
                        <i class="fas fa-briefcase"></i>
                        Experiencia {{ $colegiado->ocultar_experiencia ? 'oculta' : 'visible' }}
                    </span>
                @endif
                @if($colegiado->universidad)
                    <span class="vis-badge {{ $colegiado->ocultar_universidad ? 'vis-badge--hidden' : 'vis-badge--visible' }}">
                        <i class="fas fa-university"></i>
                        Universidad {{ $colegiado->ocultar_universidad ? 'oculta' : 'visible' }}
                    </span>
                @endif
                @if($colegiado->anio_graduacion)
                    <span class="vis-badge {{ $colegiado->ocultar_anio_graduacion ? 'vis-badge--hidden' : 'vis-badge--visible' }}">
                        <i class="fas fa-calendar-check"></i>
                        Año grad. {{ $colegiado->ocultar_anio_graduacion ? 'oculto' : 'visible' }}
                    </span>
                @endif
                @if($colegiado->fecha_colegiatura)
                    <span class="vis-badge {{ $colegiado->ocultar_fecha_colegiatura ? 'vis-badge--hidden' : 'vis-badge--visible' }}">
                        <i class="fas fa-id-card"></i>
                        F. colegiatura {{ $colegiado->ocultar_fecha_colegiatura ? 'oculta' : 'visible' }}
                    </span>
                @endif
                @if($colegiado->descripcion)
                    <span class="vis-badge {{ $colegiado->ocultar_descripcion ? 'vis-badge--hidden' : 'vis-badge--visible' }}">
                        <i class="fas fa-align-left"></i>
                        Descripción {{ $colegiado->ocultar_descripcion ? 'oculta' : 'visible' }}
                    </span>
                @endif
                @if($colegiado->cv_path)
                    <span class="vis-badge {{ $colegiado->ocultar_cv ? 'vis-badge--hidden' : 'vis-badge--visible' }}">
                        <i class="fas fa-file-pdf"></i>
                        CV {{ $colegiado->ocultar_cv ? 'oculto' : 'visible' }}
                    </span>
                @endif
            </div>
        </div>
        <a href="{{ route('admin.colegiados.edit', $colegiado) }}#visibilidad" class="btn btn-sm btn-outline-secondary">
            <i class="fas fa-sliders-h"></i>
            Cambiar visibilidad
        </a>
    </div>

    {{-- Grid de tarjetas --}}
    <div class="detail-grid">

        {{-- Información Personal --}}
        <div class="detail-card">
            <div class="card-header">
                <h3><i class="fas fa-user"></i> Información Personal</h3>
            </div>
            <div class="card-body">
                @if($colegiado->foto)
                    <div class="profile-photo">
                        <img src="{{ Storage::url($colegiado->foto) }}" alt="{{ $colegiado->nombre_completo }}">
                        @if($colegiado->ocultar_foto)
                            <div style="margin-top:6px;">
                                <span class="field-hidden-indicator" title="Foto oculta en perfil público">
                                    <i class="fas fa-eye-slash"></i> Foto oculta en público
                                </span>
                            </div>
                        @endif
                    </div>
                @endif

                <div class="info-group">
                    <label>Nombres completos</label>
                    <p>{{ $colegiado->nombres }} {{ $colegiado->apellidos }}</p>
                </div>

                <div class="info-group">
                    <label>DNI</label>
                    <p>{{ $colegiado->dni }}</p>
                </div>

                @if($colegiado->email)
                    <div class="info-group">
                        <label>
                            Email
                            @if($colegiado->ocultar_email)
                                <span class="field-hidden-indicator" title="Oculto en perfil público">
                                    <i class="fas fa-eye-slash"></i>
                                </span>
                            @endif
                        </label>
                        <p><a href="mailto:{{ $colegiado->email }}">{{ $colegiado->email }}</a></p>
                    </div>
                @endif

                @if($colegiado->telefono)
                    <div class="info-group">
                        <label>
                            Teléfono
                            @if($colegiado->ocultar_telefono)
                                <span class="field-hidden-indicator" title="Oculto en perfil público">
                                    <i class="fas fa-eye-slash"></i>
                                </span>
                            @endif
                        </label>
                        <p><a href="tel:{{ $colegiado->telefono }}">{{ $colegiado->telefono }}</a></p>
                    </div>
                @endif

                @if($colegiado->fecha_nacimiento)
                    <div class="info-group">
                        <label>Fecha de Nacimiento</label>
                        <p>{{ $colegiado->fecha_nacimiento->format('d/m/Y') }}</p>
                    </div>
                @endif

                <div class="info-group">
                    <label>Estado</label>
                    <p>
                        @if($colegiado->estado === 'activo')
                            <span class="badge badge-success">
                                <i class="fas fa-check-circle"></i> ACTIVO
                            </span>
                        @else
                            <span class="badge badge-danger">
                                <i class="fas fa-times-circle"></i> INACTIVO
                            </span>
                        @endif
                    </p>
                </div>

                <div class="info-group">
                    <label>
                        Fecha de Colegiatura
                        @if($colegiado->ocultar_fecha_colegiatura)
                            <span class="field-hidden-indicator" title="Oculto en perfil público">
                                <i class="fas fa-eye-slash"></i>
                            </span>
                        @endif
                    </label>
                    <p>{{ $colegiado->fecha_colegiatura->format('d/m/Y') }}</p>
                </div>
            </div>
        </div>

        {{-- Información Profesional --}}
        <div class="detail-card">
            <div class="card-header">
                <h3><i class="fas fa-briefcase"></i> Información Profesional</h3>
            </div>
            <div class="card-body">
                @if($colegiado->grado_academico)
                    <div class="info-group">
                        <label>
                            Grado Académico
                            @if($colegiado->ocultar_grado_academico)
                                <span class="field-hidden-indicator" title="Oculto en perfil público">
                                    <i class="fas fa-eye-slash"></i>
                                </span>
                            @endif
                        </label>
                        <p>{{ $colegiado->grado_academico }}</p>
                    </div>
                @endif

                @if($colegiado->orientacion)
                    <div class="info-group">
                        <label>
                            Orientación
                            @if($colegiado->ocultar_orientacion)
                                <span class="field-hidden-indicator" title="Oculto en perfil público">
                                    <i class="fas fa-eye-slash"></i>
                                </span>
                            @endif
                        </label>
                        <p>{{ $colegiado->orientacion }}</p>
                    </div>
                @endif

                @if($colegiado->especialidad)
                    <div class="info-group">
                        <label>
                            Especialización
                            @if($colegiado->ocultar_especialidad)
                                <span class="field-hidden-indicator" title="Oculto en perfil público">
                                    <i class="fas fa-eye-slash"></i>
                                </span>
                            @endif
                        </label>
                        <p>{{ $colegiado->especialidad }}</p>
                    </div>
                @endif

                @if($colegiado->especializacion_detalle)
                    <div class="info-group">
                        <label>
                            Detalle de la Especialización
                            @if($colegiado->ocultar_especializacion_detalle)
                                <span class="field-hidden-indicator" title="Oculto en perfil público">
                                    <i class="fas fa-eye-slash"></i>
                                </span>
                            @endif
                        </label>
                        <p style="white-space: pre-line;">{{ $colegiado->especializacion_detalle }}</p>
                    </div>
                @endif

                @if($colegiado->diplomados)
                    <div class="info-group">
                        <label>
                            Diplomados
                            @if($colegiado->ocultar_diplomados)
                                <span class="field-hidden-indicator" title="Oculto en perfil público">
                                    <i class="fas fa-eye-slash"></i>
                                </span>
                            @endif
                        </label>
                        <p style="white-space: pre-line;">{{ $colegiado->diplomados }}</p>
                    </div>
                @endif

                @if($colegiado->experiencia_anos || $colegiado->experiencia_sector)
                    <div class="info-group">
                        <label>
                            Experiencia Profesional
                            @if($colegiado->ocultar_experiencia)
                                <span class="field-hidden-indicator" title="Oculto en perfil público">
                                    <i class="fas fa-eye-slash"></i>
                                </span>
                            @endif
                        </label>
                        <p>
                            @if($colegiado->experiencia_anos)
                                <strong>{{ $colegiado->experiencia_anos }} años</strong>
                            @endif
                            @if($colegiado->experiencia_sector)
                                @if($colegiado->experiencia_anos) en sector @endif
                                <span class="badge badge-info">
                                    @if($colegiado->experiencia_sector === 'publica')
                                        <i class="fas fa-landmark"></i> Público
                                    @elseif($colegiado->experiencia_sector === 'privada')
                                        <i class="fas fa-building"></i> Privado
                                    @else
                                        <i class="fas fa-briefcase"></i> Mixto
                                    @endif
                                </span>
                            @endif
                        </p>
                    </div>
                @endif

                @if($colegiado->universidad)
                    <div class="info-group">
                        <label>
                            Universidad
                            @if($colegiado->ocultar_universidad)
                                <span class="field-hidden-indicator" title="Oculto en perfil público">
                                    <i class="fas fa-eye-slash"></i>
                                </span>
                            @endif
                        </label>
                        <p>{{ $colegiado->universidad }}</p>
                    </div>
                @endif

                @if($colegiado->anio_graduacion)
                    <div class="info-group">
                        <label>
                            Año de Graduación
                            @if($colegiado->ocultar_anio_graduacion)
                                <span class="field-hidden-indicator" title="Oculto en perfil público">
                                    <i class="fas fa-eye-slash"></i>
                                </span>
                            @endif
                        </label>
                        <p>{{ $colegiado->anio_graduacion }}</p>
                    </div>
                @endif

                @if($colegiado->descripcion)
                    <div class="info-group">
                        <label>
                            Descripción Profesional
                            @if($colegiado->ocultar_descripcion)
                                <span class="field-hidden-indicator" title="Oculto en perfil público">
                                    <i class="fas fa-eye-slash"></i>
                                </span>
                            @endif
                        </label>
                        <p>{{ $colegiado->descripcion }}</p>
                    </div>
                @endif

                @if($colegiado->cv_path)
                    <div class="info-group">
                        <label>
                            Curriculum Vitae
                            @if($colegiado->ocultar_cv)
                                <span class="field-hidden-indicator" title="Oculto en perfil público">
                                    <i class="fas fa-eye-slash"></i>
                                </span>
                            @endif
                        </label>
                        <p>
                            <a href="{{ route('admin.colegiados.descargar-cv', $colegiado) }}" target="_blank" rel="noopener" class="btn-link">
                                <i class="fas fa-file-pdf text-danger"></i>
                                Descargar CV
                            </a>
                        </p>
                    </div>
                @endif
            </div>
        </div>

    </div>

    {{-- Sección de Habilitaciones --}}
    <div class="detail-card detail-card-full">
        <div class="card-header">
            <h3><i class="fas fa-certificate"></i> Documento de Habilitación</h3>
            <a href="{{ route('admin.habilitaciones.create', $colegiado) }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus"></i>
                Nueva Habilitación
            </a>
        </div>
        <div class="card-body">
            @if($colegiado->habilitaciones->count() > 0)
                <div class="habilitaciones-list">
                    @foreach($colegiado->habilitaciones as $habilitacion)
                        <div class="habilitacion-item {{ $habilitacion->activo ? '' : 'inactive' }}">
                            <div class="habilitacion-header">
                                <h4>
                                    @if($habilitacion->activo)
                                        <span class="badge badge-success"><i class="fas fa-check-circle"></i> ACTIVO</span>
                                    @else
                                        <span class="badge badge-secondary"><i class="fas fa-ban"></i> REVOCADO</span>
                                    @endif
                                </h4>
                                <span class="habilitacion-date">
                                    <i class="fas fa-calendar"></i>
                                    {{ $habilitacion->fecha_subida->format('d/m/Y H:i') }}
                                </span>
                            </div>

                            <div class="habilitacion-code">
                                <strong>Código de Verificación:</strong>
                                <code>{{ $habilitacion->codigo_verificacion }}</code>
                                <button onclick="copiarTexto(this, '{{ $habilitacion->codigo_verificacion }}')" class="btn-copy" title="Copiar código">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>

                            <div class="habilitacion-url">
                                <strong>URL de Verificación:</strong>
                                <a href="{{ $habilitacion->url_corta }}" target="_blank">{{ $habilitacion->url_corta }}</a>
                                <button onclick="copiarTexto(this, '{{ $habilitacion->url_corta }}')" class="btn-copy" title="Copiar URL">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>

                            <div class="habilitacion-qr">
                                <strong>Código QR:</strong>
                                <img src="{{ asset($habilitacion->qr_path) }}" alt="QR Code">
                            </div>

                            <div class="habilitacion-actions">
                                <a href="{{ route('admin.habilitaciones.documento', $habilitacion->codigo_verificacion) }}"
                                   class="btn btn-sm btn-info"
                                   target="_blank"
                                   rel="noopener">
                                    <i class="fas fa-file-download"></i>
                                    Documento
                                </a>
                                <a href="{{ route('admin.habilitaciones.descargar-qr', $habilitacion) }}" class="btn btn-sm btn-secondary">
                                    <i class="fas fa-qrcode"></i>
                                    QR
                                </a>

                                @if($habilitacion->activo)
                                    <form action="{{ route('admin.habilitaciones.revocar', $habilitacion) }}" method="POST" class="d-inline" id="form-revocar-{{ $habilitacion->id }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="button" class="btn btn-sm btn-warning"
                                                onclick="confirmRevocar('form-revocar-{{ $habilitacion->id }}')">
                                            <i class="fas fa-ban"></i>
                                            Revocar
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.habilitaciones.reactivar', $habilitacion) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-success">
                                            <i class="fas fa-check"></i>
                                            Reactivar
                                        </button>
                                    </form>
                                @endif

                                <form action="{{ route('admin.habilitaciones.destroy', $habilitacion) }}" method="POST" class="d-inline" id="form-del-hab-{{ $habilitacion->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger"
                                            onclick="confirmDeleteHabilitacion('form-del-hab-{{ $habilitacion->id }}')">
                                        <i class="fas fa-trash"></i>
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state-small">
                    <i class="fas fa-certificate"></i>
                    <p>No hay documentos de habilitación cargados</p>
                    <a href="{{ route('admin.habilitaciones.create', $colegiado) }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i>
                        Subir Documento de Habilitación
                    </a>
                </div>
            @endif
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
function copiarTexto(btn, texto) {
    navigator.clipboard.writeText(texto).then(() => {
        const icon = btn.querySelector('i');
        icon.className = 'fas fa-check';
        btn.classList.add('copied');
        setTimeout(() => {
            icon.className = 'fas fa-copy';
            btn.classList.remove('copied');
        }, 1800);
    });
}

function confirmRevocar(formId) {
    Swal.fire({
        title: '¿Revocar habilitación?',
        html: 'El documento quedará marcado como <strong>REVOCADO</strong> y el colegiado no aparecerá como habilitado en verificaciones públicas.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#f57c00',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="fas fa-ban"></i> Sí, revocar',
        cancelButtonText: 'Cancelar',
        focusCancel: true,
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(formId).submit();
        }
    });
}

function confirmDeleteHabilitacion(formId) {
    Swal.fire({
        title: '¿Eliminar documento?',
        html: 'Se eliminará permanentemente el documento PDF, el código QR y el código de verificación. Esta acción <strong>no se puede deshacer</strong>.',
        icon: 'error',
        showCancelButton: true,
        confirmButtonColor: '#d32f2f',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="fas fa-trash"></i> Sí, eliminar',
        cancelButtonText: 'Cancelar',
        focusCancel: true,
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(formId).submit();
        }
    });
}
</script>
@endpush
