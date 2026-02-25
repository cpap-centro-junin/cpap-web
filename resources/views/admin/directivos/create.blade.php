@extends('layouts.admin')

@section('title', 'Agregar Directivo')
@section('page-title', 'Agregar Directivo')

@section('content')

<div style="max-width:800px;">

    <div style="display:flex;align-items:center;gap:14px;margin-bottom:24px;">
        <a href="{{ route('admin.directivos.index') }}"
           style="width:36px;height:36px;border-radius:50%;background:var(--light-gray);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;color:var(--medium-gray);text-decoration:none;">
            <i class="fas fa-arrow-left" style="font-size:13px;"></i>
        </a>
        <div>
            <h1 style="font-size:22px;font-weight:700;color:var(--dark);margin:0 0 2px;">Agregar Directivo</h1>
            <p style="color:var(--medium-gray);font-size:13px;margin:0;">Completa los datos del miembro del consejo directivo</p>
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

    <form action="{{ route('admin.directivos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div style="display:grid;grid-template-columns:1fr 280px;gap:20px;align-items:start;">

            {{-- DATOS PRINCIPALES --}}
            <div class="admin-card">
                <h3 style="font-size:14px;font-weight:700;color:var(--dark);margin:0 0 16px;display:flex;align-items:center;gap:6px;">
                    <i class="fas fa-user-tie" style="color:var(--primary);"></i> Datos del Directivo
                </h3>

                <div style="margin-bottom:14px;">
                    <label style="display:block;font-size:13px;font-weight:600;color:var(--dark);margin-bottom:6px;">Nombre completo <span style="color:var(--danger);">*</span></label>
                    <input type="text" name="nombre" value="{{ old('nombre') }}"
                           placeholder="Ej: Dr. Juan Pérez Huamán"
                           class="admin-input" required>
                </div>

                <div style="margin-bottom:14px;">
                    <label style="display:block;font-size:13px;font-weight:600;color:var(--dark);margin-bottom:6px;">Cargo <span style="color:var(--danger);">*</span></label>
                    <select name="cargo" class="admin-input" required>
                        <option value="">— Selecciona un cargo —</option>
                        @foreach(['Decano','Vice Decano','Secretario General','Secretaria General','Secretario(a) de Actas','Tesorero','Tesorera','Fiscal','Vocal 1','Vocal 2','Vocal 3'] as $c)
                        <option value="{{ $c }}" {{ old('cargo') == $c ? 'selected' : '' }}>{{ $c }}</option>
                        @endforeach
                    </select>
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
                    <div>
                        <label style="display:block;font-size:13px;font-weight:600;color:var(--dark);margin-bottom:6px;">Período de gestión</label>
                        <input type="text" name="periodo" value="{{ old('periodo', '2024-2026') }}"
                               placeholder="2024-2026"
                               class="admin-input">
                    </div>
                    <div>
                        <label style="display:block;font-size:13px;font-weight:600;color:var(--dark);margin-bottom:6px;">
                            Orden <span style="color:var(--medium-gray);font-weight:400;">(menor = primero)</span>
                        </label>
                        <input type="number" name="orden" value="{{ old('orden', 0) }}"
                               min="0" max="99" class="admin-input">
                    </div>
                </div>
            </div>

            {{-- LATERAL --}}
            <div>
                {{-- Estado --}}
                <div class="admin-card" style="margin-bottom:16px;">
                    <h3 style="font-size:14px;font-weight:700;color:var(--dark);margin:0 0 14px;display:flex;align-items:center;gap:6px;">
                        <i class="fas fa-cog" style="color:var(--primary);"></i> Visibilidad
                    </h3>
                    <label style="display:flex;align-items:center;gap:10px;cursor:pointer;padding:10px;background:var(--light-gray);border-radius:var(--radius-sm);">
                        <input type="hidden" name="activo" value="0">
                        <input type="checkbox" name="activo" value="1"
                               {{ old('activo', '1') == '1' ? 'checked' : '' }}
                               style="width:16px;height:16px;accent-color:var(--primary);flex-shrink:0;">
                        <div>
                            <div style="font-size:13px;font-weight:600;color:var(--dark);">Visible en el sitio</div>
                            <div style="font-size:11px;color:var(--medium-gray);">Aparece en Consejo Directivo</div>
                        </div>
                    </label>
                </div>

                {{-- Foto --}}
                <div class="admin-card" style="margin-bottom:16px;">
                    <h3 style="font-size:14px;font-weight:700;color:var(--dark);margin:0 0 14px;display:flex;align-items:center;gap:6px;">
                        <i class="fas fa-image" style="color:var(--primary);"></i> Fotografía
                    </h3>
                    <div id="dropZone" onclick="document.getElementById('fotoInput').click()"
                         style="border:2px dashed var(--border);border-radius:var(--radius-sm);padding:20px;text-align:center;cursor:pointer;transition:all 0.2s;">
                        <div id="dzContent">
                            <i class="fas fa-user-circle" style="font-size:32px;color:var(--border);display:block;margin-bottom:8px;"></i>
                            <p style="font-size:12px;color:var(--medium-gray);margin:0;">Clic o arrastra la foto<br><span style="font-size:11px;">JPG, PNG, WEBP — máx. 2MB</span></p>
                        </div>
                        <img id="preview" src="" alt="" style="display:none;width:100%;height:160px;object-fit:cover;border-radius:6px;">
                    </div>
                    <input type="file" id="fotoInput" name="foto" accept="image/*" style="display:none;" onchange="handleImg(this)">
                    <button type="button" id="removeBtn" onclick="removeImg()"
                            style="display:none;width:100%;margin-top:8px;padding:6px;background:var(--danger-light);color:var(--danger);border:none;border-radius:var(--radius-sm);font-size:12px;font-weight:600;cursor:pointer;">
                        <i class="fas fa-times"></i> Quitar foto
                    </button>
                    <p style="font-size:11px;color:var(--medium-gray);margin:8px 0 0;text-align:center;">Si no hay foto se mostrará un avatar institucional</p>
                </div>

                <button type="submit" class="primary-btn" style="width:100%;justify-content:center;font-size:15px;padding:13px;">
                    <i class="fas fa-save"></i> Guardar Directivo
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
        document.getElementById('dzContent').style.display = 'none';
        document.getElementById('removeBtn').style.display = 'block';
    };
    reader.readAsDataURL(input.files[0]);
}
function removeImg() {
    document.getElementById('fotoInput').value = '';
    document.getElementById('preview').src = '';
    document.getElementById('preview').style.display = 'none';
    document.getElementById('dzContent').style.display = 'block';
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
        const inp = document.getElementById('fotoInput');
        inp.files = dt.files; handleImg(inp);
    }
});
</script>
@endpush

@endsection
