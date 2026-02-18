@extends('layouts.admin')

@section('title', 'Editar Noticia')
@section('page-title', 'Editar Noticia')

@section('content')

<div class="admin-container">

    {{-- Breadcrumb --}}
    <div class="breadcrumb">
        <a href="{{ route('admin.noticias.index') }}">
            <i class="fas fa-newspaper"></i> Noticias
        </a>
        <span>/</span>
        <span>{{ Str::limit($noticia->titulo, 40) }}</span>
    </div>

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Editar Noticia</h1>
            <p class="page-subtitle">Modifica el contenido o estado de esta noticia</p>
        </div>
        <a href="{{ route('admin.noticias.index') }}" class="btn btn-lg btn-secondary-outline">
            <i class="fas fa-arrow-left"></i>
            Volver
        </a>
    </div>

    {{-- Banner de contexto --}}
    <div class="edit-context-banner">
        <div class="edit-context-banner__avatar">
            @if($noticia->imagen)
                <img src="{{ asset('storage/' . $noticia->imagen) }}" alt="{{ $noticia->titulo }}">
            @else
                <div class="edit-context-banner__initials">
                    <i class="fas fa-newspaper" style="font-size:22px;"></i>
                </div>
            @endif
        </div>
        <div class="edit-context-banner__info">
            <div class="edit-context-banner__label">Editando noticia</div>
            <h2>{{ $noticia->titulo }}</h2>
            <div class="edit-context-banner__meta">
                <span>
                    <i class="fas fa-calendar"></i>
                    Creada {{ $noticia->created_at->format('d/m/Y') }}
                </span>
                <span>
                    <i class="fas fa-clock"></i>
                    {{ $noticia->updated_at->diffForHumans() }}
                </span>
                <span>
                    @if($noticia->activo)
                        <i class="fas fa-check-circle" style="color: var(--success);"></i>
                        Publicada
                    @else
                        <i class="fas fa-eye-slash"></i>
                        Oculta
                    @endif
                </span>
            </div>
        </div>
    </div>

    {{-- Formulario --}}
    <form action="{{ route('admin.noticias.update', $noticia) }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-card">

            {{-- Sección: Contenido --}}
            <div class="form-section">
                <h3 class="section-title">Contenido de la Noticia</h3>

                <div class="form-row">
                    <div class="form-group" style="grid-column: 1 / -1;">
                        <label for="titulo">Título <span class="required">*</span></label>
                        <input type="text"
                               name="titulo"
                               id="titulo"
                               class="form-control {{ $errors->has('titulo') ? 'is-invalid' : '' }}"
                               value="{{ old('titulo', $noticia->titulo) }}"
                               required>
                        @error('titulo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group" style="grid-column: 1 / -1;">
                        <label for="contenido">Contenido <span class="required">*</span></label>
                        <textarea name="contenido"
                                  id="contenido"
                                  class="form-control {{ $errors->has('contenido') ? 'is-invalid' : '' }}"
                                  rows="8"
                                  required>{{ old('contenido', $noticia->contenido) }}</textarea>
                        @error('contenido')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Sección: Imagen y Estado --}}
            <div class="form-section">
                <h3 class="section-title">Imagen y Publicación</h3>

                <div class="form-row">

                    {{-- Imagen --}}
                    <div class="form-group">
                        <label for="imagen">Cambiar imagen de portada</label>
                        <div class="noticia-upload-container">
                            <div class="noticia-upload-box" id="uploadBox" onclick="document.getElementById('imagen').click()">
                                <div id="uploadPlaceholder" {{ $noticia->imagen ? 'style=display:none;' : '' }}>
                                    <i class="fas fa-cloud-upload-alt noticia-upload-icon"></i>
                                    <p class="noticia-upload-hint">Haz clic para cambiar la imagen</p>
                                    <p class="noticia-upload-specs">JPG, JPEG, PNG, WEBP · Máx. 2 MB</p>
                                </div>
                                <img id="imagePreview"
                                     class="noticia-image-preview"
                                     src="{{ $noticia->imagen ? asset('storage/' . $noticia->imagen) : '' }}"
                                     style="{{ $noticia->imagen ? '' : 'display:none;' }}"
                                     alt="Imagen actual">
                            </div>
                            <input type="file"
                                   name="imagen"
                                   id="imagen"
                                   class="upload-input {{ $errors->has('imagen') ? 'is-invalid' : '' }}"
                                   accept="image/jpg,image/jpeg,image/png,image/webp"
                                   onchange="previewNoticia(event)">
                        </div>
                        @error('imagen')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @if($noticia->imagen)
                            <span class="form-text"><i class="fas fa-info-circle"></i> Selecciona una nueva imagen para reemplazar la actual.</span>
                        @endif
                    </div>

                    {{-- Estado --}}
                    <div class="form-group">
                        <label for="activo">Estado de publicación <span class="required">*</span></label>
                        <select name="activo" id="activo" class="form-control">
                            <option value="1" {{ old('activo', $noticia->activo ? '1' : '0') == '1' ? 'selected' : '' }}>
                                Publicada (visible al público)
                            </option>
                            <option value="0" {{ old('activo', $noticia->activo ? '1' : '0') == '0' ? 'selected' : '' }}>
                                Oculta (solo admin)
                            </option>
                        </select>
                        <span class="form-text">Define si la noticia será visible en el sitio web.</span>
                    </div>

                </div>
            </div>

            {{-- Footer --}}
            <div class="form-footer">
                <a href="{{ route('admin.noticias.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i>
                    Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    Guardar Cambios
                </button>
            </div>

        </div>
    </form>

</div>

@endsection

@push('scripts')
<script>
function previewNoticia(event) {
    const file = event.target.files[0];
    if (!file) return;
    const preview = document.getElementById('imagePreview');
    const placeholder = document.getElementById('uploadPlaceholder');
    preview.src = URL.createObjectURL(file);
    preview.style.display = 'block';
    placeholder.style.display = 'none';
}

const uploadBox = document.getElementById('uploadBox');
uploadBox.addEventListener('dragover', (e) => { e.preventDefault(); uploadBox.classList.add('drag-over'); });
uploadBox.addEventListener('dragleave', () => { uploadBox.classList.remove('drag-over'); });
uploadBox.addEventListener('drop', (e) => {
    e.preventDefault();
    uploadBox.classList.remove('drag-over');
    const file = e.dataTransfer.files[0];
    if (file && file.type.startsWith('image/')) {
        document.getElementById('imagen').files = e.dataTransfer.files;
        const preview = document.getElementById('imagePreview');
        const placeholder = document.getElementById('uploadPlaceholder');
        preview.src = URL.createObjectURL(file);
        preview.style.display = 'block';
        placeholder.style.display = 'none';
    }
});
</script>
@endpush
