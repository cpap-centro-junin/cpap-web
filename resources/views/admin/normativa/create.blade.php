@extends('layouts.admin')

@section('title', 'Agregar Documento Normativo')
@section('page-title', 'Agregar Documento')

@section('content')

<div style="width:100%;">

    <div style="display:flex;align-items:center;gap:14px;margin-bottom:24px;">
        <a href="{{ route('admin.normativa.index') }}"
           style="width:36px;height:36px;border-radius:50%;background:var(--light-gray);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;color:var(--medium-gray);text-decoration:none;">
            <i class="fas fa-arrow-left" style="font-size:13px;"></i>
        </a>
        <div>
            <h1 style="font-size:22px;font-weight:700;color:var(--dark);margin:0 0 2px;">Agregar Documento</h1>
            <p style="color:var(--medium-gray);font-size:13px;margin:0;">Sube un documento normativo con su archivo PDF</p>
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

    <form action="{{ route('admin.normativa.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div style="display:grid;grid-template-columns:1fr 280px;gap:20px;align-items:start;">

            {{-- DATOS PRINCIPALES --}}
            <div class="admin-card">
                <h3 style="font-size:14px;font-weight:700;color:var(--dark);margin:0 0 16px;display:flex;align-items:center;gap:6px;">
                    <i class="fas fa-gavel" style="color:var(--primary);"></i> Datos del Documento
                </h3>

                <div style="margin-bottom:14px;">
                    <label style="display:block;font-size:13px;font-weight:600;color:var(--dark);margin-bottom:6px;">Título <span style="color:var(--danger);">*</span></label>
                    <input type="text" name="titulo" value="{{ old('titulo') }}"
                           placeholder="Ej: Estatuto del CPAP"
                           class="admin-input" required>
                </div>

                <div style="margin-bottom:14px;">
                    <label style="display:block;font-size:13px;font-weight:600;color:var(--dark);margin-bottom:6px;">
                        Descripción <span style="color:var(--medium-gray);font-weight:400;">(opcional)</span>
                    </label>
                    <textarea name="descripcion" rows="3" class="admin-input"
                              placeholder="Breve descripción del documento normativo...">{{ old('descripcion') }}</textarea>
                </div>

                <div style="margin-bottom:14px;">
                    <label style="display:block;font-size:13px;font-weight:600;color:var(--dark);margin-bottom:6px;">Ícono <span style="color:var(--danger);">*</span></label>
                    <select name="icono" class="admin-input" required>
                        @foreach($iconos as $clase => $nombre)
                        <option value="{{ $clase }}" {{ old('icono', 'fas fa-file-pdf') == $clase ? 'selected' : '' }}>
                            {{ $nombre }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div style="margin-bottom:14px;">
                    <label style="display:block;font-size:13px;font-weight:600;color:var(--dark);margin-bottom:6px;">
                        Archivo PDF <span style="color:var(--medium-gray);font-weight:400;">(máx. 10MB)</span>
                    </label>
                    <input type="file" name="archivo_pdf" accept=".pdf" class="admin-input">
                    <p style="font-size:11px;color:var(--medium-gray);margin:4px 0 0;">Solo archivos .pdf. Los usuarios podrán descargar este archivo desde la página pública.</p>
                </div>

                <div>
                    <label style="display:block;font-size:13px;font-weight:600;color:var(--dark);margin-bottom:6px;">
                        Orden <span style="color:var(--medium-gray);font-weight:400;">(menor = primero)</span>
                    </label>
                    <input type="number" name="orden" value="{{ old('orden', 0) }}"
                           min="0" max="99" class="admin-input" style="width:120px;">
                </div>
            </div>

            {{-- LATERAL --}}
            <div>
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
                            <div style="font-size:11px;color:var(--medium-gray);">Aparece en Normativa Legal</div>
                        </div>
                    </label>
                </div>

                <button type="submit" class="primary-btn" style="width:100%;justify-content:center;margin-bottom:10px;">
                    <i class="fas fa-save"></i> Guardar Documento
                </button>
                <a href="{{ route('admin.normativa.index') }}"
                   style="display:flex;align-items:center;justify-content:center;gap:6px;padding:10px;border-radius:var(--radius-sm);background:var(--light-gray);color:var(--medium-gray);font-size:13px;font-weight:600;text-decoration:none;text-align:center;">
                    Cancelar
                </a>
            </div>
        </div>
    </form>
</div>

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
}
</style>
@endpush

@endsection
