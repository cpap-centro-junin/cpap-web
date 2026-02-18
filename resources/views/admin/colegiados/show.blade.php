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
            <h1 class="page-title">{{ $colegiado->nombre_completo }}</h1>
            <p class="page-subtitle">{{ $colegiado->codigo_cpap }} &mdash; {{ $colegiado->dni }}</p>
        </div>
        <div class="action-header-buttons">
            <a href="{{ route('admin.colegiados.edit', $colegiado) }}" class="btn btn-lg btn-secondary-outline">
                <i class="fas fa-pencil-alt"></i>
                Editar Información
            </a>
            <a href="{{ route('admin.habilitaciones.create', $colegiado) }}" class="btn btn-lg btn-primary">
                <i class="fas fa-certificate"></i>
                Subir Habilitación
            </a>
        </div>
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
                        <img src="{{ asset($colegiado->foto) }}" alt="{{ $colegiado->nombre_completo }}">
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
                        <label>Email</label>
                        <p><a href="mailto:{{ $colegiado->email }}">{{ $colegiado->email }}</a></p>
                    </div>
                @endif

                @if($colegiado->telefono)
                    <div class="info-group">
                        <label>Teléfono</label>
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
                    <label>Fecha de Colegiatura</label>
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
                @if($colegiado->especialidad)
                    <div class="info-group">
                        <label>Especialidad</label>
                        <p>{{ $colegiado->especialidad }}</p>
                    </div>
                @endif

                @if($colegiado->universidad)
                    <div class="info-group">
                        <label>Universidad</label>
                        <p>{{ $colegiado->universidad }}</p>
                    </div>
                @endif

                @if($colegiado->anio_graduacion)
                    <div class="info-group">
                        <label>Año de Graduación</label>
                        <p>{{ $colegiado->anio_graduacion }}</p>
                    </div>
                @endif

                @if($colegiado->descripcion)
                    <div class="info-group">
                        <label>Descripción Profesional</label>
                        <p>{{ $colegiado->descripcion }}</p>
                    </div>
                @endif

                @if($colegiado->cv_path)
                    <div class="info-group">
                        <label>Curriculum Vitae</label>
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
                                <a href="{{ route('admin.habilitaciones.descargar', $habilitacion) }}"
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
                        Subir Primer Documento
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
