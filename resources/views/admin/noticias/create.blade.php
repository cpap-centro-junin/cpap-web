@extends('layouts.admin')

@section('title', 'Nueva Noticia')
@section('page-title', 'Nueva Noticia')

@section('content')

<div class="admin-container">

    {{-- Breadcrumb --}}
    <div class="breadcrumb">
        <a href="{{ route('admin.noticias.index') }}">
            <i class="fas fa-newspaper"></i> Noticias
        </a>
        <span>/</span>
        <span>Nueva Noticia</span>
    </div>

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Nueva Noticia</h1>
            <p class="page-subtitle">Completa los datos para publicar una noticia institucional</p>
        </div>
        <a href="{{ route('admin.noticias.index') }}" class="btn btn-lg btn-secondary-outline">
            <i class="fas fa-arrow-left"></i>
            Volver
        </a>
    </div>

    {{-- Formulario --}}
    <form action="{{ route('admin.noticias.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

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
                               value="{{ old('titulo') }}"
                               placeholder="Título de la noticia"
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
                                  placeholder="Escribe el contenido completo de la noticia..."
                                  required>{{ old('contenido') }}</textarea>
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
                        <label for="imagen">Imagen de portada</label>
                        <div class="noticia-upload-container">
                            <div class="noticia-upload-box" id="uploadBox" onclick="document.getElementById('imagen').click()">
                                <div id="uploadPlaceholder">
                                    <i class="fas fa-cloud-upload-alt noticia-upload-icon"></i>
                                    <p class="noticia-upload-hint">Haz clic o arrastra una imagen</p>
                                    <p class="noticia-upload-specs">JPG, JPEG, PNG, WEBP · Máx. 2 MB</p>
                                </div>
                                <img id="imagePreview" class="noticia-image-preview" style="display:none;" alt="Preview">
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
                    </div>

                    {{-- Estado --}}
                    <div class="form-group">
                        <label for="activo">Estado de publicación <span class="required">*</span></label>
                        <select name="activo" id="activo" class="form-control">
                            <option value="1" {{ old('activo', '1') == '1' ? 'selected' : '' }}>
                                Publicada (visible al público)
                            </option>
                            <option value="0" {{ old('activo') == '0' ? 'selected' : '' }}>
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
                    Publicar Noticia
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
