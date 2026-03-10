@extends('layouts.admin')

@section('title', 'Editar Anuncio Emergente')
@section('page-title', 'Editar Anuncio Emergente')

@push('styles')
<style>
@media (max-width: 768px) {
    div[style*="grid-template-columns:1fr 280px"] {
        grid-template-columns: 1fr !important;
    }
    
    .admin-card {
        margin-bottom: 20px !important;
    }
    
    #dropZone {
        padding: 40px 20px !important;
    }
    
    .admin-input {
        font-size: 14px !important;
        min-height: 44px;
    }
    
    div[style*="display:flex;gap:10px"] {
        flex-direction: column !important;
        gap: 10px !important;
    }
    
    div[style*="display:flex;gap:10px"] button,
    div[style*="display:flex;gap:10px"] a {
        width: 100% !important;
    }
}
</style>
@endpush

@section('content')

<div style="width:100%;">

    <div style="display:flex;align-items:center;gap:14px;margin-bottom:24px;">
        <a href="{{ route('admin.inicio.anuncios.index') }}"
           style="width:36px;height:36px;border-radius:50%;background:var(--light-gray);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;color:var(--medium-gray);text-decoration:none;">
            <i class="fas fa-arrow-left" style="font-size:13px;"></i>
        </a>
        <div>
            <h1 style="font-size:22px;font-weight:700;color:var(--dark);margin:0 0 2px;">Editar Anuncio</h1>
            <p style="color:var(--medium-gray);font-size:13px;margin:0;">{{ $anuncio->titulo }}</p>
        </div>
    </div>

    @if($errors->any())
    <div style="background:var(--danger-light);color:var(--danger);border-radius:var(--radius-sm);padding:14px 18px;margin-bottom:20px;">
        <strong style="display:flex;align-items:center;gap:8px;margin-bottom:8px;"><i class="fas fa-exclamation-circle"></i> Corrige los errores:</strong>
        <ul style="margin:0;padding-left:20px;font-size:13px;">
            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.inicio.anuncios.update', $anuncio) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div style="display:grid;grid-template-columns:1fr 280px;gap:20px;align-items:start;">

            {{-- IMAGEN --}}
            <div class="admin-card">
                <h3 style="font-size:14px;font-weight:700;color:var(--dark);margin:0 0 16px;display:flex;align-items:center;gap:6px;">
                    <i class="fas fa-image" style="color:var(--primary);"></i> Imagen del Anuncio
                </h3>

                <div style="margin-bottom:12px;">
                    <p style="font-size:12px;color:var(--medium-gray);margin:0 0 8px;">Imagen actual:</p>
                    <img src="{{ $anuncio->imagen }}" alt="{{ $anuncio->titulo }}"
                         id="currentImg"
                         style="max-width:100%;max-height:300px;object-fit:contain;border-radius:6px;display:block;">
                </div>

                <div id="dropZone" onclick="document.getElementById('imgInput').click()"
                     style="border:2px dashed var(--border);border-radius:var(--radius-sm);padding:20px;text-align:center;cursor:pointer;transition:all 0.2s;">
                    <div id="dzContent">
                        <i class="fas fa-cloud-upload-alt" style="font-size:24px;color:var(--border);display:block;margin-bottom:6px;"></i>
                        <p style="font-size:12px;color:var(--medium-gray);margin:0;">Clic para cambiar imagen<br>
                        <span style="font-size:11px;">JPG, PNG, GIF, WEBP — máx. 4MB</span></p>
                    </div>
                    <img id="preview" src="" alt="" style="display:none;max-width:100%;max-height:300px;object-fit:contain;border-radius:6px;">
                </div>
                <input type="file" id="imgInput" name="imagen" accept="image/*" style="display:none;" onchange="handleImg(this)">
                <button type="button" id="removeBtn" onclick="removeImg()"
                        style="display:none;width:100%;margin-top:8px;padding:6px;background:var(--danger-light);color:var(--danger);border:none;border-radius:var(--radius-sm);font-size:12px;font-weight:600;cursor:pointer;">
                    <i class="fas fa-times"></i> Quitar nueva imagen
                </button>
            </div>

            {{-- LATERAL --}}
            <div>
                {{-- Título interno --}}
                <div class="admin-card" style="margin-bottom:16px;">
                    <h3 style="font-size:14px;font-weight:700;color:var(--dark);margin:0 0 14px;display:flex;align-items:center;gap:6px;">
                        <i class="fas fa-tag" style="color:var(--primary);"></i> Identificación
                    </h3>
                    <label style="display:block;font-size:13px;font-weight:600;color:var(--dark);margin-bottom:6px;">Título interno <span style="color:var(--danger);">*</span></label>
                    <input type="text" name="titulo" value="{{ old('titulo', $anuncio->titulo) }}"
                           class="admin-input" required>
                </div>

                {{-- Estado --}}
                <div class="admin-card" style="margin-bottom:16px;">
                    <h3 style="font-size:14px;font-weight:700;color:var(--dark);margin:0 0 14px;display:flex;align-items:center;gap:6px;">
                        <i class="fas fa-cog" style="color:var(--primary);"></i> Visibilidad
                    </h3>
                    <label style="display:flex;align-items:center;gap:10px;cursor:pointer;padding:10px;background:var(--light-gray);border-radius:var(--radius-sm);">
                        <input type="hidden" name="activo" value="0">
                        <input type="checkbox" name="activo" value="1"
                               {{ old('activo', $anuncio->activo) ? 'checked' : '' }}
                               style="width:16px;height:16px;accent-color:var(--primary);flex-shrink:0;">
                        <div>
                            <div style="font-size:13px;font-weight:600;color:var(--dark);">Mostrar en el sitio</div>
                            <div style="font-size:11px;color:var(--medium-gray);">Aparece como popup en la página de inicio</div>
                        </div>
                    </label>
                    <p style="font-size:11px;color:var(--medium-gray);margin:8px 0 0;display:flex;align-items:center;gap:4px;">
                        <i class="fas fa-info-circle"></i>
                        Puedes tener varios anuncios activos al mismo tiempo.
                    </p>
                </div>

                <div style="display:flex;gap:10px;">
                    <a href="{{ route('admin.inicio.anuncios.index') }}"
                       style="flex:1;display:inline-flex;align-items:center;justify-content:center;padding:12px;background:var(--light-gray);color:var(--medium-gray);border-radius:var(--radius-sm);font-size:14px;font-weight:600;text-decoration:none;">
                        Cancelar
                    </a>
                    <button type="submit" class="primary-btn" style="flex:2;justify-content:center;font-size:14px;padding:12px;">
                        <i class="fas fa-save"></i> Guardar Cambios
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
function handleImg(input) {
    if (!input.files[0]) return;
    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('preview').src = e.target.result;
        document.getElementById('preview').style.display = 'block';
        document.getElementById('dzContent').style.display = 'none';
        document.getElementById('removeBtn').style.display = 'block';
        const cur = document.getElementById('currentImg');
        if (cur) cur.style.opacity = '0.4';
    };
    reader.readAsDataURL(input.files[0]);
}
function removeImg() {
    document.getElementById('imgInput').value = '';
    document.getElementById('preview').src = '';
    document.getElementById('preview').style.display = 'none';
    document.getElementById('dzContent').style.display = 'block';
    document.getElementById('removeBtn').style.display = 'none';
    const cur = document.getElementById('currentImg');
    if (cur) cur.style.opacity = '1';
}
const dz = document.getElementById('dropZone');
dz.addEventListener('dragover', e => { e.preventDefault(); dz.style.borderColor='var(--primary)'; dz.style.background='rgba(139,21,56,0.03)'; });
dz.addEventListener('dragleave', () => { dz.style.borderColor='var(--border)'; dz.style.background='transparent'; });
dz.addEventListener('drop', e => {
    e.preventDefault(); dz.style.borderColor='var(--border)'; dz.style.background='transparent';
    const f = e.dataTransfer.files[0];
    if (f && f.type.startsWith('image/')) {
        const dt = new DataTransfer(); dt.items.add(f);
        const inp = document.getElementById('imgInput');
        inp.files = dt.files; handleImg(inp);
    }
});
</script>
@endpush

@endsection
