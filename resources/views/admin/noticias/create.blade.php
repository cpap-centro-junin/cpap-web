@extends('layouts.admin')

@section('title', 'Nueva Noticia')
@section('page-title', 'Nueva Noticia')

@section('content')

<div style="max-width:960px;">

    {{-- HEADER --}}
    <div style="display:flex;align-items:center;gap:14px;margin-bottom:24px;">
        <a href="{{ route('admin.noticias.index') }}"
           style="width:36px;height:36px;border-radius:50%;background:var(--light-gray);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;color:var(--medium-gray);text-decoration:none;">
            <i class="fas fa-arrow-left" style="font-size:13px;"></i>
        </a>
        <div>
            <h1 style="font-size:22px;font-weight:700;color:var(--dark);margin:0 0 2px;">Nueva Noticia</h1>
            <p style="color:var(--medium-gray);font-size:13px;margin:0;">Completa el formulario para publicar</p>
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

    <form action="{{ route('admin.noticias.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div style="display:grid;grid-template-columns:1fr 300px;gap:20px;align-items:start;">

            {{-- COLUMNA PRINCIPAL --}}
            <div>
                <div class="admin-card" style="margin-bottom:16px;">
                    <h3 style="font-size:14px;font-weight:700;color:var(--dark);margin:0 0 16px;display:flex;align-items:center;gap:6px;">
                        <i class="fas fa-pen" style="color:var(--primary);"></i> Contenido
                    </h3>
                    <div style="margin-bottom:14px;">
                        <label style="display:block;font-size:13px;font-weight:600;color:var(--dark);margin-bottom:6px;">Título <span style="color:var(--danger);">*</span></label>
                        <input type="text" name="titulo" value="{{ old('titulo') }}"
                               placeholder="Escribe el título de la noticia"
                               class="admin-input" required>
                    </div>
                    <div style="margin-bottom:14px;">
                        <label style="display:block;font-size:13px;font-weight:600;color:var(--dark);margin-bottom:6px;">
                            Resumen <span style="color:var(--medium-gray);font-weight:400;">(aparece en el listado)</span>
                        </label>
                        <textarea name="resumen" rows="3" maxlength="300"
                                  placeholder="Breve descripción para el listado (opcional)"
                                  class="admin-input">{{ old('resumen') }}</textarea>
                    </div>
                    <div>
                        <label style="display:block;font-size:13px;font-weight:600;color:var(--dark);margin-bottom:6px;">Contenido completo <span style="color:var(--danger);">*</span></label>
                        <textarea name="contenido" rows="14"
                                  placeholder="Escribe aquí el contenido completo..."
                                  class="admin-input" required>{{ old('contenido') }}</textarea>
                        <p style="color:var(--medium-gray);font-size:11px;margin:6px 0 0;">Puedes usar HTML básico: &lt;b&gt;, &lt;i&gt;, &lt;p&gt;, &lt;ul&gt;, &lt;li&gt;, &lt;h2&gt;, &lt;h3&gt;</p>
                    </div>
                </div>
            </div>

            {{-- COLUMNA LATERAL --}}
            <div>
                {{-- Publicación --}}
                <div class="admin-card" style="margin-bottom:16px;">
                    <h3 style="font-size:14px;font-weight:700;color:var(--dark);margin:0 0 14px;display:flex;align-items:center;gap:6px;">
                        <i class="fas fa-cog" style="color:var(--primary);"></i> Publicación
                    </h3>
                    <div style="margin-bottom:12px;">
                        <label style="display:block;font-size:12px;font-weight:600;color:var(--medium-gray);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:6px;">Estado</label>
                        <select name="activo" class="admin-input">
                            <option value="1" {{ old('activo','1')=='1'?'selected':'' }}>Publicado</option>
                            <option value="0" {{ old('activo')=='0'?'selected':'' }}>Borrador</option>
                        </select>
                    </div>
                    <div style="margin-bottom:12px;">
                        <label style="display:block;font-size:12px;font-weight:600;color:var(--medium-gray);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:6px;">Autor</label>
                        <input type="text" name="autor" value="{{ old('autor','Redacción CPAP') }}" class="admin-input">
                    </div>
                    <div style="margin-bottom:14px;">
                        <label style="display:block;font-size:12px;font-weight:600;color:var(--medium-gray);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:6px;">Categoría</label>
                        <select name="categoria" class="admin-input">
                            @foreach(['Institucional','Académico','Investigación','Gremial','Convocatoria','Internacional','Otro'] as $cat)
                            <option value="{{ $cat }}" {{ old('categoria','Institucional')==$cat?'selected':'' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>
                    <label style="display:flex;align-items:center;gap:10px;cursor:pointer;padding:10px;background:var(--light-gray);border-radius:var(--radius-sm);">
                        <input type="hidden" name="destacado" value="0">
                        <input type="checkbox" name="destacado" value="1" {{ old('destacado')?'checked':'' }}
                               style="width:16px;height:16px;accent-color:var(--primary);flex-shrink:0;">
                        <div>
                            <div style="font-size:13px;font-weight:600;color:var(--dark);"><i class="fas fa-star" style="color:var(--accent);"></i> Destacar noticia</div>
                            <div style="font-size:11px;color:var(--medium-gray);">Aparece en sección destacados</div>
                        </div>
                    </label>
                </div>

                {{-- Imagen --}}
                <div class="admin-card" style="margin-bottom:16px;">
                    <h3 style="font-size:14px;font-weight:700;color:var(--dark);margin:0 0 14px;display:flex;align-items:center;gap:6px;">
                        <i class="fas fa-image" style="color:var(--primary);"></i> Imagen Portada
                    </h3>
                    <div id="dropZone" onclick="document.getElementById('imagenInput').click()"
                         style="border:2px dashed var(--border);border-radius:var(--radius-sm);padding:20px;text-align:center;cursor:pointer;transition:all 0.2s;">
                        <div id="dropZoneContent">
                            <i class="fas fa-cloud-upload-alt" style="font-size:24px;color:var(--border);display:block;margin-bottom:6px;"></i>
                            <p style="font-size:12px;color:var(--medium-gray);margin:0;">Clic o arrastra una imagen<br><span style="font-size:11px;">JPG, PNG, WEBP — máx. 3MB</span></p>
                        </div>
                        <img id="preview" src="" alt="" style="display:none;width:100%;height:140px;object-fit:cover;border-radius:6px;">
                    </div>
                    <input type="file" id="imagenInput" name="imagen" accept="image/*" style="display:none;" onchange="handleImg(this)">
                    <button type="button" id="removeBtn" onclick="removeImg()"
                            style="display:none;width:100%;margin-top:8px;padding:6px;background:var(--danger-light);color:var(--danger);border:none;border-radius:var(--radius-sm);font-size:12px;font-weight:600;cursor:pointer;">
                        <i class="fas fa-times"></i> Quitar imagen
                    </button>
                </div>

                <button type="submit" class="primary-btn" style="width:100%;justify-content:center;font-size:15px;padding:13px;">
                    <i class="fas fa-save"></i> Publicar Noticia
                </button>
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
        document.getElementById('dropZoneContent').style.display = 'none';
        document.getElementById('removeBtn').style.display = 'block';
    };
    reader.readAsDataURL(input.files[0]);
}
function removeImg() {
    document.getElementById('imagenInput').value = '';
    document.getElementById('preview').src = '';
    document.getElementById('preview').style.display = 'none';
    document.getElementById('dropZoneContent').style.display = 'block';
    document.getElementById('removeBtn').style.display = 'none';
}
const dz = document.getElementById('dropZone');
dz.addEventListener('dragover', e => { e.preventDefault(); dz.style.borderColor='var(--primary)'; dz.style.background='rgba(139,21,56,0.03)'; });
dz.addEventListener('dragleave', () => { dz.style.borderColor='var(--border)'; dz.style.background='transparent'; });
dz.addEventListener('drop', e => {
    e.preventDefault(); dz.style.borderColor='var(--border)'; dz.style.background='transparent';
    const f = e.dataTransfer.files[0];
    if (f && f.type.startsWith('image/')) {
        const dt = new DataTransfer(); dt.items.add(f);
        const inp = document.getElementById('imagenInput');
        inp.files = dt.files; handleImg(inp);
    }
});
</script>
@endpush

@endsection
