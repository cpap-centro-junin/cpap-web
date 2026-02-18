@extends('layouts.admin')

@section('title', 'Subir Documento de Habilitación')
@section('page-title', 'Generar Documento de Habilitación')

@section('content')

<div class="admin-container">

    {{-- Breadcrumb --}}
    <div class="breadcrumb">
        <a href="{{ route('admin.colegiados.index') }}">
            <i class="fas fa-id-card"></i> Colegiados
        </a>
        <span>/</span>
        <a href="{{ route('admin.colegiados.show', $colegiado) }}">
            {{ $colegiado->codigo_cpap }}
        </a>
        <span>/</span>
        <span>Nueva Habilitación</span>
    </div>

    {{-- Banner del colegiado --}}
    <div class="colegiado-banner">
        <div class="colegiado-banner__avatar">
            @if($colegiado->foto)
                <img src="{{ asset($colegiado->foto) }}" alt="{{ $colegiado->nombre_completo }}">
            @else
                <div class="colegiado-banner__avatar-placeholder">
                    {{ strtoupper(substr($colegiado->nombres, 0, 1) . substr($colegiado->apellidos, 0, 1)) }}
                </div>
            @endif
        </div>
        <div class="colegiado-banner__info">
            <h2>{{ $colegiado->nombre_completo }}</h2>
            <div class="colegiado-banner__meta">
                <span class="colegiado-banner__code">
                    <i class="fas fa-id-badge"></i>
                    {{ $colegiado->codigo_cpap }}
                </span>
                @if($colegiado->especialidad)
                    <span class="colegiado-banner__sep">·</span>
                    <span>{{ $colegiado->especialidad }}</span>
                @endif
            </div>
            <div class="colegiado-banner__status">
                @if($colegiado->estado === 'activo')
                    <span class="banner-badge banner-badge--activo">
                        <i class="fas fa-check-circle"></i> ACTIVO
                    </span>
                @else
                    <span class="banner-badge banner-badge--inactivo">
                        <i class="fas fa-times-circle"></i> INACTIVO
                    </span>
                @endif
            </div>
        </div>
    </div>

    {{-- Advertencia: ya existe habilitación --}}
    @if($habilitacionActual)
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle"></i>
            <div>
                <strong>Este colegiado ya tiene un documento de habilitación.</strong>
                Al subir uno nuevo, el anterior será <strong>reemplazado y eliminado permanentemente</strong>
                (documento PDF, código QR y código de verificación).
                <div style="margin-top: 6px; font-size: 13px;">
                    Código actual: <code>{{ $habilitacionActual->codigo_verificacion }}</code>
                </div>
            </div>
        </div>
    @endif

    {{-- Formulario principal --}}
    <div class="form-card">
        <form action="{{ route('admin.habilitaciones.store', $colegiado) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-header">
                <h2><i class="fas fa-certificate"></i> Generar Habilitación con QR</h2>
                <p>Sube un documento PDF y se generarán automáticamente los códigos de verificación.</p>
            </div>

            {{-- Sección: Qué se generará --}}
            <div class="form-section">
                <h3 class="section-title">¿Qué se generará?</h3>
                <div class="generation-grid">
                    <div class="generation-item">
                        <i class="fas fa-fingerprint"></i>
                        <div>
                            <strong>Código UUID único</strong>
                            <span>Irrepetible, embebido en el PDF</span>
                        </div>
                    </div>
                    <div class="generation-item">
                        <i class="fas fa-qrcode"></i>
                        <div>
                            <strong>Código QR</strong>
                            <span>Apunta a la URL de verificación pública</span>
                        </div>
                    </div>
                    <div class="generation-item">
                        <i class="fas fa-link"></i>
                        <div>
                            <strong>URL de verificación</strong>
                            <span>Acceso público para validar el documento</span>
                        </div>
                    </div>
                    <div class="generation-item">
                        <i class="fas fa-user-check"></i>
                        <div>
                            <strong>Estado ACTIVO</strong>
                            <span>El colegiado se activa automáticamente</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sección: Upload del PDF --}}
            <div class="form-section">
                <h3 class="section-title">Documento de habilitación</h3>

                <div class="upload-container">
                    <div class="upload-box">
                        <i class="fas fa-file-pdf upload-icon"></i>
                        <h4>Selecciona el documento PDF</h4>
                        <p class="upload-hint">Haz clic o arrastra el archivo aquí</p>
                        <p class="upload-specs">PDF • Máximo 10 MB</p>
                    </div>

                    <input
                        type="file"
                        name="documento"
                        id="documento"
                        class="upload-input @error('documento') is-invalid @enderror"
                        accept=".pdf"
                        required
                    >

                    <div class="file-info" id="fileInfo" style="display: none;">
                        <i class="fas fa-check-circle"></i>
                        <span id="fileName"></span>
                        <span id="fileSize"></span>
                    </div>

                    @error('documento')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Botones --}}
            <div class="form-footer">
                <a href="{{ route('admin.colegiados.show', $colegiado) }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Volver
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-magic"></i>
                    Generar Habilitación con QR
                </button>
            </div>
        </form>
    </div>

</div>

@push('scripts')
<script>
const inputDoc = document.getElementById('documento');
const uploadBox = document.querySelector('.upload-box');
const fileInfo = document.getElementById('fileInfo');
const fileName = document.getElementById('fileName');
const fileSize = document.getElementById('fileSize');

// Cambio de archivo
inputDoc.addEventListener('change', function () {
    if (this.files.length > 0) {
        const file = this.files[0];
        const sizeMB = (file.size / 1024 / 1024).toFixed(2);

        fileName.textContent = file.name;
        fileSize.textContent = `(${sizeMB} MB)`;
        fileInfo.style.display = 'flex';
        uploadBox.style.opacity = '0.5';
    } else {
        fileInfo.style.display = 'none';
        uploadBox.style.opacity = '1';
    }
});

// Drag and drop
uploadBox.addEventListener('dragover', (e) => {
    e.preventDefault();
    uploadBox.classList.add('drag-over');
});

uploadBox.addEventListener('dragleave', () => {
    uploadBox.classList.remove('drag-over');
});

uploadBox.addEventListener('drop', (e) => {
    e.preventDefault();
    uploadBox.classList.remove('drag-over');

    const files = e.dataTransfer.files;
    if (files.length > 0 && files[0].type === 'application/pdf') {
        inputDoc.files = files;
        // Trigger change event
        inputDoc.dispatchEvent(new Event('change', { bubbles: true }));
    }
});

// Click en la caja abre el input
uploadBox.addEventListener('click', () => {
    inputDoc.click();
});
</script>
@endpush

@endsection
