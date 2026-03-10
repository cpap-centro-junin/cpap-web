@php use Illuminate\Support\Str; @endphp

@extends('layouts.admin')

@section('title', 'Editar Oferta de Trabajo')
@section('page-title', 'Editar Oferta de Trabajo')

@section('content')

<div style="width:100%;">

    {{-- HEADER --}}
    <div style="display:flex;align-items:center;gap:14px;margin-bottom:24px;">
        <a href="{{ route('admin.bolsa.index') }}"
           style="width:36px;height:36px;border-radius:50%;background:var(--light-gray);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;color:var(--medium-gray);text-decoration:none;">
            <i class="fas fa-arrow-left" style="font-size:13px;"></i>
        </a>
        <div>
            <h1 style="font-size:22px;font-weight:700;color:var(--dark);margin:0 0 2px;">Editar Oferta de Trabajo</h1>
            <p style="color:var(--medium-gray);font-size:13px;margin:0;">{{ Str::limit($oferta->titulo, 70) }}</p>
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

    <form action="{{ route('admin.bolsa.update', $oferta) }}" method="POST">
        @csrf @method('PUT')

        <div style="display:grid;grid-template-columns:1fr 300px;gap:20px;align-items:start;">

            {{-- COLUMNA PRINCIPAL --}}
            <div>
                <div class="admin-card" style="margin-bottom:16px;">
                    <h3 style="font-size:14px;font-weight:700;color:var(--dark);margin:0 0 16px;display:flex;align-items:center;gap:6px;">
                        <i class="fas fa-briefcase" style="color:var(--primary);"></i> Información de la Oferta
                    </h3>
                    <div style="margin-bottom:14px;">
                        <label style="display:block;font-size:13px;font-weight:600;color:var(--dark);margin-bottom:6px;">Título del puesto <span style="color:var(--danger);">*</span></label>
                        <input type="text" name="titulo" value="{{ old('titulo', $oferta->titulo) }}"
                               class="admin-input" required>
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:14px;">
                        <div>
                            <label style="display:block;font-size:13px;font-weight:600;color:var(--dark);margin-bottom:6px;">Empresa / Organización <span style="color:var(--danger);">*</span></label>
                            <input type="text" name="empresa" value="{{ old('empresa', $oferta->empresa) }}"
                                   class="admin-input" required>
                        </div>
                        <div>
                            <label style="display:block;font-size:13px;font-weight:600;color:var(--dark);margin-bottom:6px;">Ubicación <span style="color:var(--danger);">*</span></label>
                            <input type="text" name="ubicacion" value="{{ old('ubicacion', $oferta->ubicacion) }}"
                                   class="admin-input" required>
                        </div>
                    </div>
                    <div style="margin-bottom:14px;">
                        <label style="display:block;font-size:13px;font-weight:600;color:var(--dark);margin-bottom:6px;">Descripción <span style="color:var(--danger);">*</span></label>
                        <textarea name="descripcion" rows="6"
                                  class="admin-input" required>{{ old('descripcion', $oferta->descripcion) }}</textarea>
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
                        <div>
                            <label style="display:block;font-size:13px;font-weight:600;color:var(--dark);margin-bottom:6px;">Salario <span style="color:var(--medium-gray);font-weight:400;">(opcional)</span></label>
                            <input type="text" name="salario" value="{{ old('salario', $oferta->salario) }}"
                                   class="admin-input">
                        </div>
                        <div>
                            <label style="display:block;font-size:13px;font-weight:600;color:var(--dark);margin-bottom:6px;">Enlace de postulación <span style="color:var(--medium-gray);font-weight:400;">(opcional)</span></label>
                            <input type="url" name="enlace_postulacion" value="{{ old('enlace_postulacion', $oferta->enlace_postulacion) }}"
                                   class="admin-input">
                        </div>
                    </div>
                </div>
            </div>

            {{-- COLUMNA LATERAL --}}
            <div>
                {{-- Clasificación --}}
                <div class="admin-card" style="margin-bottom:16px;">
                    <h3 style="font-size:14px;font-weight:700;color:var(--dark);margin:0 0 14px;display:flex;align-items:center;gap:6px;">
                        <i class="fas fa-cog" style="color:var(--primary);"></i> Clasificación
                    </h3>
                    <div style="margin-bottom:12px;">
                        <label style="display:block;font-size:12px;font-weight:600;color:var(--medium-gray);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:6px;">Estado</label>
                        <select name="activo" class="admin-input">
                            <option value="1" {{ old('activo', $oferta->activo ? '1' : '0')=='1'?'selected':'' }}>Activa</option>
                            <option value="0" {{ old('activo', $oferta->activo ? '1' : '0')=='0'?'selected':'' }}>Inactiva</option>
                        </select>
                    </div>
                    <div style="margin-bottom:12px;">
                        <label style="display:block;font-size:12px;font-weight:600;color:var(--medium-gray);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:6px;">Tipo de trabajo <span style="color:var(--danger);">*</span></label>
                        <select name="tipo" class="admin-input" required>
                            @foreach(['fulltime'=>'Tiempo Completo','parttime'=>'Medio Tiempo','freelance'=>'Freelance','consultoria'=>'Consultoría'] as $val => $label)
                            <option value="{{ $val }}" {{ old('tipo', $oferta->tipo)==$val?'selected':'' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div style="margin-bottom:12px;">
                        <label style="display:block;font-size:12px;font-weight:600;color:var(--medium-gray);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:6px;">Área <span style="color:var(--danger);">*</span></label>
                        <select name="area" class="admin-input" required>
                            @foreach(['investigacion'=>'Investigación','docencia'=>'Docencia','consultoria'=>'Consultoría','gestion'=>'Gestión Cultural'] as $val => $label)
                            <option value="{{ $val }}" {{ old('area', $oferta->area)==$val?'selected':'' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Fechas --}}
                <div class="admin-card" style="margin-bottom:16px;">
                    <h3 style="font-size:14px;font-weight:700;color:var(--dark);margin:0 0 14px;display:flex;align-items:center;gap:6px;">
                        <i class="fas fa-calendar-alt" style="color:var(--primary);"></i> Fechas
                    </h3>
                    <div style="margin-bottom:12px;">
                        <label style="display:block;font-size:12px;font-weight:600;color:var(--medium-gray);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:6px;">Fecha de publicación <span style="color:var(--danger);">*</span></label>
                        <input type="date" name="fecha_publicacion"
                               value="{{ old('fecha_publicacion', $oferta->fecha_publicacion->format('Y-m-d')) }}"
                               class="admin-input" required>
                    </div>
                    <div>
                        <label style="display:block;font-size:12px;font-weight:600;color:var(--medium-gray);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:6px;">Fecha de vencimiento <span style="color:var(--medium-gray);font-weight:400;">(opcional)</span></label>
                        <input type="date" name="fecha_vencimiento"
                               value="{{ old('fecha_vencimiento', $oferta->fecha_vencimiento?->format('Y-m-d')) }}"
                               class="admin-input">
                        <p style="color:var(--medium-gray);font-size:11px;margin:6px 0 0;">La oferta se ocultará automáticamente después de esta fecha</p>
                    </div>
                </div>

                <div style="display:flex;gap:10px;">
                    <a href="{{ route('admin.bolsa.index') }}"
                       style="flex:1;display:flex;align-items:center;justify-content:center;gap:6px;padding:13px;background:var(--light-gray);color:var(--medium-gray);border-radius:var(--radius-sm);font-size:14px;font-weight:600;text-decoration:none;border:1px solid var(--border);">
                        Cancelar
                    </a>
                    <button type="submit" class="primary-btn" style="flex:2;justify-content:center;font-size:15px;padding:13px;">
                        <i class="fas fa-save"></i> Guardar Cambios
                    </button>
                </div>
            </div>
        </div>
    </form>

</div>

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
