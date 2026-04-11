@extends('layouts.admin')

@section('title', 'Editar Imágenes Subidas')
@section('page-title', 'Editar Imágenes Subidas')

@section('content')

{{-- HEADER --}}
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;flex-wrap:wrap;gap:12px;">
    <div>
        <h1 style="font-size:22px;font-weight:700;color:var(--dark);margin:0 0 4px;">
            <i class="fas fa-pencil-alt" style="color:var(--primary);margin-right:6px;"></i>
            Editar Imágenes Subidas
        </h1>
        <p style="color:var(--medium-gray);font-size:14px;margin:0;">
            Paso 2 de 2: Configura los detalles de cada imagen antes de finalizar.
            <strong>{{ $imagenes->count() }}</strong> imagen{{ $imagenes->count() !== 1 ? 'es' : '' }} pendiente{{ $imagenes->count() !== 1 ? 's' : '' }}.
        </p>
    </div>
    <div style="display:flex;gap:8px;">
        <a href="{{ route('admin.galeria.index') }}" style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;background:var(--light-gray);border:1px solid var(--border);border-radius:var(--radius-sm);color:var(--medium-gray);text-decoration:none;font-size:13px;font-weight:500;">
            <i class="fas fa-arrow-left"></i> Volver a Galería
        </a>
    </div>
</div>

{{-- FLASH --}}
@if(session('success'))
<div style="background:var(--success-light);color:var(--success);border:1px solid rgba(46,125,50,0.2);border-radius:var(--radius-sm);padding:14px 18px;margin-bottom:20px;display:flex;align-items:center;gap:10px;font-size:14px;font-weight:500;">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
</div>
@endif

{{-- ACCIONES RÁPIDAS GLOBALES --}}
<div class="admin-card" style="padding:16px;margin-bottom:20px;">
    <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
        <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;">
            <span style="font-size:13px;font-weight:600;color:var(--dark);">
                <i class="fas fa-bolt" style="color:var(--secondary);"></i> Aplicar a todas:
            </span>
            <select id="globalCategoria" class="admin-input" style="margin:0;width:160px;font-size:13px;height:36px;" onchange="applyGlobalCategoria(this.value)">
                <option value="">— Categoría —</option>
                @foreach($categorias as $key => $label)
                    <option value="{{ $key }}">{{ $label }}</option>
                @endforeach
            </select>
            <button type="button" onclick="toggleAllCheckbox('destacado', true)" style="padding:5px 12px;border-radius:6px;border:1px solid rgba(212,175,55,0.3);background:rgba(212,175,55,0.08);color:#b8960c;cursor:pointer;font-size:12px;font-weight:600;">
                <i class="fas fa-star"></i> Todas destacadas
            </button>
            <button type="button" onclick="toggleAllCheckbox('activo', true)" style="padding:5px 12px;border-radius:6px;border:1px solid rgba(46,125,50,0.3);background:var(--success-light);color:var(--success);cursor:pointer;font-size:12px;font-weight:600;">
                <i class="fas fa-eye"></i> Todas visibles
            </button>
            <button type="button" onclick="toggleAllCheckbox('activo', false)" style="padding:5px 12px;border-radius:6px;border:1px solid rgba(211,47,47,0.3);background:var(--danger-light);color:var(--danger);cursor:pointer;font-size:12px;font-weight:600;">
                <i class="fas fa-eye-slash"></i> Todas ocultas
            </button>
        </div>
    </div>
</div>

<form action="{{ route('admin.galeria.update-masivo') }}" method="POST" id="formEditMasivo">
    @csrf
    @method('PUT')

    <div style="display:flex;flex-direction:column;gap:16px;margin-bottom:24px;">
        @foreach($imagenes as $i => $img)
        <div class="admin-card" style="padding:0;overflow:hidden;" id="card-{{ $img->id }}">
            <div style="display:flex;gap:0;flex-wrap:wrap;">
                {{-- Imagen Preview --}}
                <div style="width:200px;min-height:180px;flex-shrink:0;background:var(--light-gray);position:relative;overflow:hidden;cursor:pointer;" onclick="window.open('{{ $img->imagen }}','_blank')">
                    <img src="{{ $img->imagen }}" alt="{{ $img->titulo }}"
                         style="width:100%;height:100%;object-fit:cover;display:block;">
                    <div style="position:absolute;bottom:8px;left:8px;background:rgba(0,0,0,0.65);color:white;padding:2px 8px;border-radius:4px;font-size:11px;font-weight:600;">
                        #{{ $i + 1 }}
                    </div>
                </div>

                {{-- Campos de Edición --}}
                <div style="flex:1;min-width:300px;padding:18px;">
                    <input type="hidden" name="imagenes[{{ $i }}][id]" value="{{ $img->id }}">

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:12px;">
                        {{-- Título --}}
                        <div>
                            <label style="display:block;font-size:11px;font-weight:600;color:var(--medium-gray);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:4px;">Título *</label>
                            <input type="text" name="imagenes[{{ $i }}][titulo]" value="{{ $img->titulo }}" required
                                   class="admin-input" style="margin:0;font-size:13px;height:38px;">
                        </div>
                        {{-- Categoría --}}
                        <div>
                            <label style="display:block;font-size:11px;font-weight:600;color:var(--medium-gray);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:4px;">Categoría</label>
                            <select name="imagenes[{{ $i }}][categoria]" class="admin-input categoria-select" style="margin:0;font-size:13px;height:38px;">
                                <option value="">Sin categoría</option>
                                @foreach($categorias as $key => $label)
                                    <option value="{{ $key }}" {{ $img->categoria === $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div style="display:grid;grid-template-columns:1fr 140px;gap:12px;margin-bottom:12px;">
                        {{-- Descripción --}}
                        <div>
                            <label style="display:block;font-size:11px;font-weight:600;color:var(--medium-gray);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:4px;">Descripción</label>
                            <input type="text" name="imagenes[{{ $i }}][descripcion]" value="{{ $img->descripcion }}" placeholder="Breve descripción..."
                                   class="admin-input" style="margin:0;font-size:13px;height:38px;">
                        </div>
                        {{-- Fecha --}}
                        <div>
                            <label style="display:block;font-size:11px;font-weight:600;color:var(--medium-gray);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:4px;">Fecha</label>
                            <input type="date" name="imagenes[{{ $i }}][fecha]" value="{{ $img->fecha?->format('Y-m-d') }}"
                                   class="admin-input" style="margin:0;font-size:13px;height:38px;">
                        </div>
                    </div>

                    {{-- Toggles --}}
                    <div style="display:flex;gap:16px;align-items:center;flex-wrap:wrap;">
                        <label style="display:inline-flex;align-items:center;gap:6px;cursor:pointer;font-size:13px;color:var(--dark);font-weight:500;padding:6px 12px;border-radius:6px;border:1px solid rgba(46,125,50,0.2);background:rgba(46,125,50,0.04);">
                            <input type="checkbox" name="imagenes[{{ $i }}][activo]" value="1" checked class="activo-check"
                                   style="accent-color:var(--success);width:16px;height:16px;">
                            <i class="fas fa-eye" style="color:var(--success);font-size:11px;"></i>
                            Visible
                        </label>
                        <label style="display:inline-flex;align-items:center;gap:6px;cursor:pointer;font-size:13px;color:var(--dark);font-weight:500;padding:6px 12px;border-radius:6px;border:1px solid rgba(212,175,55,0.3);background:rgba(212,175,55,0.04);">
                            <input type="checkbox" name="imagenes[{{ $i }}][destacado]" value="1" class="destacado-check"
                                   style="accent-color:#b8960c;width:16px;height:16px;">
                            <i class="fas fa-star" style="color:#b8960c;font-size:11px;"></i>
                            Mostrar en Home
                        </label>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- BOTONES DE ACCIÓN --}}
    <div class="admin-card" style="padding:16px;position:sticky;bottom:0;z-index:10;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;box-shadow:0 -4px 20px rgba(0,0,0,0.08);">
        <p style="color:var(--medium-gray);font-size:13px;margin:0;">
            <i class="fas fa-info-circle"></i> Revisa los datos y pulsa <strong>Guardar</strong> para confirmar.
        </p>
        <div style="display:flex;gap:10px;">
            <a href="{{ route('admin.galeria.index') }}"
               style="padding:10px 20px;border-radius:var(--radius-sm);border:1px solid var(--border);background:white;color:var(--medium-gray);text-decoration:none;font-size:14px;display:inline-flex;align-items:center;gap:6px;">
                Saltar (ya están guardadas)
            </a>
            <button type="submit" class="primary-btn" id="btnGuardarMasivo">
                <i class="fas fa-save"></i> Guardar Cambios
            </button>
        </div>
    </div>
</form>

@endsection

@push('scripts')
<script>
function applyGlobalCategoria(value) {
    document.querySelectorAll('.categoria-select').forEach(select => {
        select.value = value;
    });
}

function toggleAllCheckbox(type, state) {
    const selector = type === 'destacado' ? '.destacado-check' : '.activo-check';
    document.querySelectorAll(selector).forEach(cb => {
        cb.checked = state;
    });
}

document.getElementById('formEditMasivo').addEventListener('submit', function() {
    const btn = document.getElementById('btnGuardarMasivo');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';
});
</script>
@endpush
