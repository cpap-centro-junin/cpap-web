@extends('layouts.admin')

@section('title', 'Editar Imagen')
@section('page-title', 'Editar Imagen de Galería')

@section('content')

<div style="width:100%;">

    {{-- HEADER --}}
    <div style="display:flex;align-items:center;gap:14px;margin-bottom:24px;">
        <a href="{{ route('admin.galeria.index') }}"
           style="width:36px;height:36px;border-radius:50%;background:var(--light-gray);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;color:var(--medium-gray);text-decoration:none;">
            <i class="fas fa-arrow-left" style="font-size:13px;"></i>
        </a>
        <div>
            <h1 style="font-size:22px;font-weight:700;color:var(--dark);margin:0 0 2px;">Editar Imagen</h1>
            <p style="color:var(--medium-gray);font-size:13px;margin:0;">{{ $galeria->titulo }}</p>
        </div>
    </div>

    {{-- ERRORES --}}
    @if($errors->any())
    <div style="background:var(--danger-light);color:var(--danger);border-radius:var(--radius-sm);padding:14px 18px;margin-bottom:20px;">
        <strong style="display:flex;align-items:center;gap:8px;margin-bottom:8px;"><i class="fas fa-exclamation-circle"></i> Corrige los siguientes errores:</strong>
        <ul style="margin:0;padding-left:20px;font-size:13px;">
            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.galeria.update', $galeria) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div style="display:grid;grid-template-columns:1fr 260px;gap:20px;align-items:start;">

            {{-- COLUMNA PRINCIPAL --}}
            <div>
                <div class="admin-card" style="margin-bottom:16px;">
                    <h3 style="font-size:14px;font-weight:700;color:var(--dark);margin:0 0 16px;display:flex;align-items:center;gap:6px;">
                        <i class="fas fa-image" style="color:var(--primary);"></i> Datos de la Imagen
                    </h3>
                    <div style="margin-bottom:14px;">
                        <label style="display:block;font-size:13px;font-weight:600;color:var(--dark);margin-bottom:6px;">
                            Título <span style="color:var(--danger);">*</span>
                        </label>
                        <input type="text" name="titulo" value="{{ old('titulo', $galeria->titulo) }}"
                               class="admin-input" required>
                    </div>
                    <div style="margin-bottom:14px;">
                        <label style="display:block;font-size:13px;font-weight:600;color:var(--dark);margin-bottom:6px;">
                            Descripción <span style="color:var(--medium-gray);font-weight:400;">(opcional)</span>
                        </label>
                        <textarea name="descripcion" rows="3" maxlength="1000"
                                  class="admin-input">{{ old('descripcion', $galeria->descripcion) }}</textarea>
                    </div>
                    <div>
                        <label style="display:block;font-size:13px;font-weight:600;color:var(--dark);margin-bottom:6px;">
                            Imagen actual
                        </label>
                        <div style="margin-bottom:12px;border-radius:var(--radius-sm);overflow:hidden;border:1px solid var(--border);max-width:400px;">
                            <img src="{{ $galeria->imagen_url }}" alt="{{ $galeria->titulo }}"
                                 style="width:100%;display:block;">
                        </div>
                        <label style="display:block;font-size:13px;font-weight:600;color:var(--dark);margin-bottom:6px;">
                            Reemplazar imagen <span style="color:var(--medium-gray);font-weight:400;">(dejar vacío para mantener la actual)</span>
                        </label>
                        <input type="file" name="imagen" accept="image/jpeg,image/png,image/webp"
                               class="admin-input" style="padding:10px;" id="inputImagen">
                        <p style="color:var(--medium-gray);font-size:11px;margin:6px 0 0;">JPG, PNG o WebP. Máximo 5 MB.</p>
                        <div id="previewContainer" style="margin-top:12px;display:none;">
                            <p style="font-size:12px;color:var(--success);font-weight:600;margin-bottom:6px;">
                                <i class="fas fa-check-circle"></i> Nueva imagen:
                            </p>
                            <img id="previewImg" style="max-width:100%;max-height:300px;border-radius:var(--radius-sm);border:1px solid var(--border);">
                        </div>
                    </div>
                </div>
            </div>

            {{-- COLUMNA LATERAL --}}
            <div>
                <div class="admin-card" style="margin-bottom:16px;">
                    <h3 style="font-size:14px;font-weight:700;color:var(--dark);margin:0 0 14px;display:flex;align-items:center;gap:6px;">
                        <i class="fas fa-cog" style="color:var(--primary);"></i> Opciones
                    </h3>
                    <div style="margin-bottom:12px;">
                        <label style="display:block;font-size:12px;font-weight:600;color:var(--medium-gray);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:6px;">Categoría</label>
                        <select name="categoria" class="admin-input">
                            <option value="">Sin categoría</option>
                            @foreach($categorias as $key => $label)
                                <option value="{{ $key }}" {{ old('categoria', $galeria->categoria) === $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div style="margin-bottom:12px;">
                        <label style="display:block;font-size:12px;font-weight:600;color:var(--medium-gray);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:6px;">
                            Fecha de la foto
                        </label>
                        <input type="date" name="fecha" value="{{ old('fecha', $galeria->fecha?->format('Y-m-d')) }}" class="admin-input">
                    </div>
                    <div style="margin-bottom:12px;">
                        <label style="display:block;font-size:12px;font-weight:600;color:var(--medium-gray);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:6px;">Estado</label>
                        <select name="activo" class="admin-input">
                            <option value="1" {{ old('activo', $galeria->activo) ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ !old('activo', $galeria->activo) ? 'selected' : '' }}>Oculto</option>
                        </select>
                    </div>
                    <div style="margin-bottom:12px;">
                        <label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:13px;font-weight:500;color:var(--dark);">
                            <input type="checkbox" name="destacado" value="1"
                                   {{ old('destacado', $galeria->destacado) ? 'checked' : '' }}
                                   style="width:16px;height:16px;accent-color:var(--primary);">
                            <i class="fas fa-star" style="color:#D4AF37;font-size:12px;"></i>
                            Mostrar en Home
                        </label>
                    </div>
                </div>

                {{-- BOTONES --}}
                <div class="admin-card">
                    <button type="submit" class="primary-btn" style="width:100%;justify-content:center;">
                        <i class="fas fa-save"></i> Guardar Cambios
                    </button>
                    <a href="{{ route('admin.galeria.index') }}"
                       style="display:flex;align-items:center;justify-content:center;gap:6px;margin-top:10px;padding:10px;border:1px solid var(--border);border-radius:var(--radius-sm);color:var(--medium-gray);text-decoration:none;font-size:14px;background:white;">
                        Cancelar
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
document.getElementById('inputImagen').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const container = document.getElementById('previewContainer');
    const img = document.getElementById('previewImg');
    if (file) {
        const reader = new FileReader();
        reader.onload = function(ev) {
            img.src = ev.target.result;
            container.style.display = 'block';
        };
        reader.readAsDataURL(file);
    } else {
        container.style.display = 'none';
    }
});
</script>
@endpush

@push('styles')
<style>
@media (max-width: 768px) {
    div[style*="grid-template-columns:1fr 260px"] {
        grid-template-columns: 1fr !important;
    }
    .admin-input,
    input.admin-input,
    select.admin-input,
    textarea.admin-input {
        min-height: 44px !important;
    }
    .primary-btn {
        width: 100% !important;
        justify-content: center !important;
    }
}
</style>
@endpush

