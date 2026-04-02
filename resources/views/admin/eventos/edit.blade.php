@php use Illuminate\Support\Str; @endphp

@extends('layouts.admin')

@section('title', 'Editar Evento')
@section('page-title', 'Editar Evento')

@section('content')

<div style="width:100%;">

    {{-- HEADER --}}
    <div style="display:flex;align-items:center;gap:14px;margin-bottom:24px;">
        <a href="{{ route('admin.eventos.index') }}"
           style="width:36px;height:36px;border-radius:50%;background:var(--light-gray);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;color:var(--medium-gray);text-decoration:none;">
            <i class="fas fa-arrow-left" style="font-size:13px;"></i>
        </a>
        <div>
            <h1 style="font-size:22px;font-weight:700;color:var(--dark);margin:0 0 2px;">Editar Evento</h1>
            <p style="color:var(--medium-gray);font-size:13px;margin:0;">{{ Str::limit($evento->titulo, 70) }}</p>
        </div>
    </div>

    {{-- ERRORES --}}
    @if($errors->any())
    <div style="background:var(--danger-light);color:var(--danger);border-radius:var(--radius-sm);padding:14px 18px;margin-bottom:20px;">
        <strong style="display:flex;align-items:center;gap:8px;margin-bottom:8px;"><i class="fas fa-exclamation-circle"></i> Corrige los errores:</strong>
        <ul style="margin:0;padding-left:20px;font-size:13px;">
            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.eventos.update', $evento) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div style="display:grid;grid-template-columns:1fr 300px;gap:20px;align-items:start;">

            {{-- COLUMNA PRINCIPAL --}}
            <div>
                {{-- Contenido --}}
                <div class="admin-card" style="margin-bottom:16px;">
                    <h3 style="font-size:14px;font-weight:700;color:var(--dark);margin:0 0 16px;display:flex;align-items:center;gap:6px;">
                        <i class="fas fa-pen" style="color:var(--primary);"></i> Información del Evento
                    </h3>
                    <div style="margin-bottom:14px;">
                        <label style="display:block;font-size:13px;font-weight:600;color:var(--dark);margin-bottom:6px;">Título <span style="color:var(--danger);">*</span></label>
                        <input type="text" name="titulo" value="{{ old('titulo', $evento->titulo) }}"
                               class="admin-input" required>
                    </div>
                    <div style="margin-bottom:14px;">
                        <label style="display:block;font-size:13px;font-weight:600;color:var(--dark);margin-bottom:6px;">
                            Resumen <span style="color:var(--medium-gray);font-weight:400;">(aparece en el listado)</span>
                        </label>
                        <textarea name="resumen" rows="3" maxlength="400" class="admin-input">{{ old('resumen', $evento->resumen) }}</textarea>
                    </div>
                    <div>
                        <label style="display:block;font-size:13px;font-weight:600;color:var(--dark);margin-bottom:6px;">Descripción completa <span style="color:var(--danger);">*</span></label>
                        <textarea name="descripcion" rows="12" class="admin-input" required>{{ old('descripcion', $evento->descripcion) }}</textarea>
                        <p style="color:var(--medium-gray);font-size:11px;margin:6px 0 0;">Puedes usar HTML básico: &lt;b&gt;, &lt;i&gt;, &lt;p&gt;, &lt;ul&gt;, &lt;li&gt;, &lt;h2&gt;</p>
                    </div>
                </div>

                {{-- Fechas y Lugar --}}
                <div class="admin-card" style="margin-bottom:16px;">
                    <h3 style="font-size:14px;font-weight:700;color:var(--dark);margin:0 0 16px;display:flex;align-items:center;gap:6px;">
                        <i class="fas fa-calendar-alt" style="color:var(--primary);"></i> Fechas y Lugar
                    </h3>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:14px;">
                        <div>
                            <label style="display:block;font-size:13px;font-weight:600;color:var(--dark);margin-bottom:6px;">Fecha inicio <span style="color:var(--danger);">*</span></label>
                            <input type="date" name="fecha_inicio"
                                   value="{{ old('fecha_inicio', $evento->fecha_inicio->format('Y-m-d')) }}"
                                   class="admin-input" required>
                        </div>
                        <div>
                            <label style="display:block;font-size:13px;font-weight:600;color:var(--dark);margin-bottom:6px;">Fecha fin</label>
                            <input type="date" name="fecha_fin"
                                   value="{{ old('fecha_fin', $evento->fecha_fin?->format('Y-m-d')) }}"
                                   class="admin-input">
                        </div>
                    </div>
                    <div style="margin-bottom:14px;">
                        <label style="display:block;font-size:13px;font-weight:600;color:var(--dark);margin-bottom:6px;">Hora de inicio</label>
                        <input type="time" name="hora_inicio"
                               value="{{ old('hora_inicio', $evento->hora_inicio ? \Carbon\Carbon::parse($evento->hora_inicio)->format('H:i') : '') }}"
                               class="admin-input" style="max-width:200px;">
                    </div>
                    <div>
                        <label style="display:block;font-size:13px;font-weight:600;color:var(--dark);margin-bottom:6px;">Lugar / Dirección</label>
                        <input type="text" name="lugar" value="{{ old('lugar', $evento->lugar) }}" class="admin-input">
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
                            <option value="1" {{ old('activo', $evento->activo ? '1' : '0')=='1'?'selected':'' }}>Publicado</option>
                            <option value="0" {{ old('activo', $evento->activo ? '1' : '0')=='0'?'selected':'' }}>Borrador</option>
                        </select>
                    </div>
                    <div style="margin-bottom:14px;">
                        <label style="display:block;font-size:12px;font-weight:600;color:var(--medium-gray);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:6px;">Categoría</label>
                        <select name="categoria" class="admin-input">
                            @foreach(['Académico','Institucional','Cultural','Gremial','Formación','Internacional','Otro'] as $cat)
                            <option value="{{ $cat }}" {{ old('categoria',$evento->categoria)==$cat?'selected':'' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>
                    <label style="display:flex;align-items:center;gap:10px;cursor:pointer;padding:10px;background:var(--light-gray);border-radius:var(--radius-sm);">
                        <input type="hidden" name="destacado" value="0">
                        <input type="checkbox" name="destacado" value="1"
                               {{ old('destacado', $evento->destacado) ? 'checked' : '' }}
                               style="width:16px;height:16px;accent-color:var(--primary);flex-shrink:0;">
                        <div>
                            <div style="font-size:13px;font-weight:600;color:var(--dark);"><i class="fas fa-star" style="color:var(--accent);"></i> Destacar evento</div>
                            <div style="font-size:11px;color:var(--medium-gray);">Aparece en sección destacados</div>
                        </div>
                    </label>
                </div>

                {{-- Imagen --}}
                <div class="admin-card" style="margin-bottom:16px;">
                    <h3 style="font-size:14px;font-weight:700;color:var(--dark);margin:0 0 14px;display:flex;align-items:center;gap:6px;">
                        <i class="fas fa-image" style="color:var(--primary);"></i> Imagen Portada
                    </h3>

                    @if($evento->imagen_portada)
                    <div style="margin-bottom:10px;">
                        <p style="font-size:12px;color:var(--medium-gray);margin:0 0 6px;">Imagen actual:</p>
                        <img src="{{ $evento->imagen_portada }}" alt=""
                             id="currentImage"
                             style="width:100%;height:120px;object-fit:cover;border-radius:6px;display:block;">
                    </div>
                    @endif

                    <div id="dropZone" onclick="document.getElementById('imgInput').click()"
                         style="border:2px dashed var(--border);border-radius:var(--radius-sm);padding:16px;text-align:center;cursor:pointer;transition:all 0.2s;">
                        <div id="dzContent">
                            <i class="fas fa-cloud-upload-alt" style="font-size:20px;color:var(--border);display:block;margin-bottom:4px;"></i>
                            <p style="font-size:12px;color:var(--medium-gray);margin:0;">{{ $evento->imagen_portada ? 'Clic para cambiar imagen' : 'Clic o arrastra una imagen' }}<br><span style="font-size:11px;">JPG, PNG, WEBP — máx. 3MB</span></p>
                        </div>
                        <img id="preview" src="" alt="" style="display:none;width:100%;height:120px;object-fit:cover;border-radius:6px;">
                    </div>
                    <input type="file" id="imgInput" name="imagen_portada" accept="image/*" style="display:none;" onchange="handleImg(this)">
                    <button type="button" id="removeBtn" onclick="removeImg()"
                            style="display:none;width:100%;margin-top:8px;padding:6px;background:var(--danger-light);color:var(--danger);border:none;border-radius:var(--radius-sm);font-size:12px;font-weight:600;cursor:pointer;">
                        <i class="fas fa-times"></i> Quitar nueva imagen
                    </button>
                </div>

                <div style="display:flex;gap:10px;">
                    <a href="{{ route('admin.eventos.index') }}"
                       style="flex:1;display:inline-flex;align-items:center;justify-content:center;gap:6px;padding:12px;background:var(--light-gray);color:var(--medium-gray);border-radius:var(--radius-sm);font-size:14px;font-weight:600;text-decoration:none;">
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
        const cur = document.getElementById('currentImage');
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
    const cur = document.getElementById('currentImage');
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

@push('styles')
<style>
@media (max-width: 768px) {
    div[style*="grid-template-columns:1fr 300px"] {
        grid-template-columns: 1fr !important;
    }
    div[style*="grid-template-columns:1fr 1fr"] {
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
    div[style*="display:flex;gap:10px"] {
        flex-direction: column !important;
    }
    div[style*="display:flex;gap:10px"] > * {
        width: 100% !important;
        flex: 1 !important;
    }
}
</style>
@endpush

@endsection
