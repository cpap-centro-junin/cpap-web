@extends('layouts.admin')

@section('title', 'Agregar Directivo')
@section('page-title', 'Agregar Directivo')

@section('content')

<div style="width:100%;">

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
                    @php
                    $cargosBase = [
                        'decano'      => ['label' => 'Decano/a',                                           'm' => 'Decano',                                             'f' => 'Decana'],
                        'vice'        => ['label' => 'Vice Decano/a',                                      'm' => 'Vice Decano',                                        'f' => 'Vice Decana'],
                        'secretario'  => ['label' => 'Director/a Secretario/a',                            'm' => 'Director Secretario',                                'f' => 'Directora Secretaria'],
                        'economia'    => ['label' => 'Director/a de Economía',                             'm' => 'Director de Economía',                               'f' => 'Directora de Economía'],
                        'rrpp'        => ['label' => 'Director/a de Relaciones Públicas',                  'm' => 'Director de Relaciones Públicas',                    'f' => 'Directora de Relaciones Públicas'],
                        'actividades' => ['label' => 'Director/a de Actividades Científicas y Culturales', 'm' => 'Director de Actividades Científicas y Culturales',   'f' => 'Directora de Actividades Científicas y Culturales'],
                        'seguridad'   => ['label' => 'Director/a de Seguridad Social',                     'm' => 'Director de Seguridad Social',                       'f' => 'Directora de Seguridad Social'],
                        'biblioteca'  => ['label' => 'Director/a de Biblioteca y Archivo',                 'm' => 'Director de Biblioteca y Archivo',                   'f' => 'Directora de Biblioteca y Archivo'],
                        'defensa'     => ['label' => 'Director/a de Relaciones y Defensa Profesional',     'm' => 'Director de Relaciones y Defensa Profesional',       'f' => 'Directora de Relaciones y Defensa Profesional'],
                    ];
                    $oldCargo = old('cargo', '');
                    $selectedKey = ''; $selectedGender = 'm';
                    foreach ($cargosBase as $key => $pair) {
                        if ($oldCargo === $pair['m']) { $selectedKey = $key; $selectedGender = 'm'; break; }
                        if ($oldCargo === $pair['f']) { $selectedKey = $key; $selectedGender = 'f'; break; }
                    }
                    $isOtro = $oldCargo && !$selectedKey;
                    $initialFinal = $isOtro ? $oldCargo : ($selectedKey ? $cargosBase[$selectedKey][$selectedGender] : '');
                    @endphp

                    {{-- Fila: select + botones de género --}}
                    <div style="display:flex;gap:8px;align-items:stretch;">
                        <select id="cargoSelect" class="admin-input" style="flex:1;"
                                onchange="onCargoChange(this.value)">
                            <option value="">— Selecciona un cargo —</option>
                            @foreach($cargosBase as $key => $pair)
                            <option value="{{ $key }}" {{ $selectedKey === $key ? 'selected' : '' }}>{{ $pair['label'] }}</option>
                            @endforeach
                            <option value="__otro__" {{ $isOtro ? 'selected' : '' }}>&#43; Otro cargo personalizado&hellip;</option>
                        </select>

                        {{-- Toggle ♂ / ♀ --}}
                        <div id="genderWrap"
                             style="display:{{ ($selectedKey && !$isOtro) ? 'flex' : 'none' }};align-items:stretch;border:1.5px solid var(--border);border-radius:var(--radius-sm);overflow:hidden;">
                            <button type="button" id="btnM" onclick="setGender('m')" title="Masculino"
                                    style="padding:0 13px;border:none;cursor:pointer;font-size:15px;transition:all .15s;
                                           background:{{ $selectedGender === 'm' ? 'var(--primary)' : 'var(--light-gray)' }};
                                           color:{{ $selectedGender === 'm' ? 'white' : 'var(--medium-gray)' }};">
                                <i class="fas fa-mars"></i>
                            </button>
                            <div style="width:1px;background:var(--border);"></div>
                            <button type="button" id="btnF" onclick="setGender('f')" title="Femenino"
                                    style="padding:0 13px;border:none;cursor:pointer;font-size:15px;transition:all .15s;
                                           background:{{ $selectedGender === 'f' ? 'var(--primary)' : 'var(--light-gray)' }};
                                           color:{{ $selectedGender === 'f' ? 'white' : 'var(--medium-gray)' }};">
                                <i class="fas fa-venus"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Preview del cargo final --}}
                    <div id="cargoPreview"
                         style="display:{{ ($selectedKey && !$isOtro) ? 'flex' : 'none' }};margin-top:6px;align-items:center;gap:6px;
                                padding:6px 10px;background:rgba(139,21,56,0.06);border-radius:6px;font-size:12px;
                                color:var(--primary);font-weight:600;">
                        <i class="fas fa-check-circle"></i>
                        <span id="cargoPreviewText">{{ $initialFinal }}</span>
                    </div>

                    {{-- Input oculto que se envía al servidor --}}
                    <input type="hidden" name="cargo" id="cargoFinal" value="{{ $initialFinal }}">

                    {{-- Campo libre para cargo personalizado --}}
                    <div id="otroCargoCont" style="margin-top:8px;display:{{ $isOtro ? 'block' : 'none' }};">
                        <input type="text" id="cargoCustom" class="admin-input"
                               value="{{ $isOtro ? $oldCargo : '' }}"
                               placeholder="Escribe el cargo exacto"
                               {{ $isOtro ? 'required' : '' }}
                               oninput="document.getElementById('cargoFinal').value = this.value.trim()">
                        <small style="font-size:11px;color:var(--medium-gray);">El icono se asignará automáticamente según el texto.</small>
                    </div>
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
const PARES = {
    decano:      { m: 'Decano',                                             f: 'Decana' },
    vice:        { m: 'Vice Decano',                                        f: 'Vice Decana' },
    secretario:  { m: 'Director Secretario',                                f: 'Directora Secretaria' },
    economia:    { m: 'Director de Econom\u00eda',                          f: 'Directora de Econom\u00eda' },
    rrpp:        { m: 'Director de Relaciones P\u00fablicas',               f: 'Directora de Relaciones P\u00fablicas' },
    actividades: { m: 'Director de Actividades Cient\u00edficas y Culturales', f: 'Directora de Actividades Cient\u00edficas y Culturales' },
    seguridad:   { m: 'Director de Seguridad Social',                       f: 'Directora de Seguridad Social' },
    biblioteca:  { m: 'Director de Biblioteca y Archivo',                   f: 'Directora de Biblioteca y Archivo' },
    defensa:     { m: 'Director de Relaciones y Defensa Profesional',       f: 'Directora de Relaciones y Defensa Profesional' },
};
let currentGender = '{{ $selectedGender }}';

function onCargoChange(val) {
    const genderWrap  = document.getElementById('genderWrap');
    const preview     = document.getElementById('cargoPreview');
    const otroCont    = document.getElementById('otroCargoCont');
    const cargoCustom = document.getElementById('cargoCustom');
    const cargoFinal  = document.getElementById('cargoFinal');
    if (val === '__otro__') {
        genderWrap.style.display  = 'none';
        preview.style.display     = 'none';
        otroCont.style.display    = 'block';
        cargoCustom.required      = true;
        cargoFinal.value          = '';
    } else if (val === '') {
        genderWrap.style.display  = 'none';
        preview.style.display     = 'none';
        otroCont.style.display    = 'none';
        cargoCustom.required      = false;
        cargoFinal.value          = '';
    } else {
        genderWrap.style.display  = 'flex';
        preview.style.display     = 'flex';
        otroCont.style.display    = 'none';
        cargoCustom.required      = false;
        cargoCustom.value         = '';
        _updateFinal(val, currentGender);
    }
}

function setGender(g) {
    currentGender = g;
    const key = document.getElementById('cargoSelect').value;
    _updateFinal(key, g);
    const btnM = document.getElementById('btnM');
    const btnF = document.getElementById('btnF');
    if (g === 'm') {
        btnM.style.background = 'var(--primary)'; btnM.style.color = 'white';
        btnF.style.background = 'var(--light-gray)'; btnF.style.color = 'var(--medium-gray)';
    } else {
        btnF.style.background = 'var(--primary)'; btnF.style.color = 'white';
        btnM.style.background = 'var(--light-gray)'; btnM.style.color = 'var(--medium-gray)';
    }
}

function _updateFinal(key, g) {
    const pair = PARES[key]; if (!pair) return;
    const val = pair[g];
    document.getElementById('cargoFinal').value          = val;
    document.getElementById('cargoPreviewText').textContent = val;
}

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

@push('styles')
<style>
@media (max-width: 768px) {
    div[style*="grid-template-columns:1fr 280px"] {
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
    div[style*="grid-template-columns:1fr 1fr"] {
        grid-template-columns: 1fr !important;
    }
}
</style>
@endpush

@endsection
