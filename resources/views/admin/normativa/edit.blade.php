@extends('layouts.admin')

@section('title', 'Editar Documento Normativo')
@section('page-title', 'Editar Documento')

@section('content')

<div style="width:100%;">

    <div style="display:flex;align-items:center;gap:14px;margin-bottom:24px;">
        <a href="{{ route('admin.normativa.index') }}"
           style="width:36px;height:36px;border-radius:50%;background:var(--light-gray);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;color:var(--medium-gray);text-decoration:none;">
            <i class="fas fa-arrow-left" style="font-size:13px;"></i>
        </a>
        <div>
            <h1 style="font-size:22px;font-weight:700;color:var(--dark);margin:0 0 2px;">Editar Documento</h1>
            <p style="color:var(--medium-gray);font-size:13px;margin:0;">{{ $normativa->titulo }}</p>
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

    <form action="{{ route('admin.normativa.update', $normativa) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div style="display:grid;grid-template-columns:1fr 280px;gap:20px;align-items:start;">

            {{-- DATOS PRINCIPALES --}}
            <div class="admin-card">
                <h3 style="font-size:14px;font-weight:700;color:var(--dark);margin:0 0 16px;display:flex;align-items:center;gap:6px;">
                    <i class="fas fa-gavel" style="color:var(--primary);"></i> Datos del Documento
                </h3>

                <div style="margin-bottom:14px;">
                    <label style="display:block;font-size:13px;font-weight:600;color:var(--dark);margin-bottom:6px;">Título <span style="color:var(--danger);">*</span></label>
                    <input type="text" name="titulo" value="{{ old('titulo', $normativa->titulo) }}"
                           placeholder="Ej: Estatuto del CPAP"
                           class="admin-input" required>
                </div>

                <div style="margin-bottom:14px;">
                    <label style="display:block;font-size:13px;font-weight:600;color:var(--dark);margin-bottom:6px;">
                        Descripción <span style="color:var(--medium-gray);font-weight:400;">(opcional)</span>
                    </label>
                    <textarea name="descripcion" rows="3" class="admin-input"
                              placeholder="Breve descripción del documento normativo...">{{ old('descripcion', $normativa->descripcion) }}</textarea>
                </div>

                <div style="margin-bottom:14px;">
                    <label style="display:block;font-size:13px;font-weight:600;color:var(--dark);margin-bottom:6px;">Ícono <span style="color:var(--danger);">*</span></label>
                    <select name="icono" class="admin-input" required>
                        @foreach($iconos as $clase => $nombre)
                        <option value="{{ $clase }}" {{ old('icono', $normativa->icono) == $clase ? 'selected' : '' }}>
                            {{ $nombre }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div style="margin-bottom:14px;">
                    <label style="display:block;font-size:13px;font-weight:600;color:var(--dark);margin-bottom:6px;">
                        Archivo PDF <span style="color:var(--medium-gray);font-weight:400;">(máx. 10MB)</span>
                    </label>

                    @if($normativa->archivo_pdf)
                    <div style="display:flex;align-items:center;gap:10px;padding:10px 14px;background:#f0fdf4;border:1px solid #bbf7d0;border-radius:var(--radius-sm);margin-bottom:10px;">
                        <i class="fas fa-file-pdf" style="font-size:20px;color:#dc2626;"></i>
                        <div style="flex:1;min-width:0;">
                            <div style="font-size:13px;font-weight:600;color:var(--dark);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                {{ $normativa->archivo_nombre }}
                            </div>
                            <div style="font-size:11px;color:#16a34a;">Archivo actual</div>
                        </div>
                        <a href="{{ $normativa->pdf_url }}" target="_blank"
                           style="font-size:12px;color:var(--primary);font-weight:600;text-decoration:none;">
                            <i class="fas fa-eye"></i> Ver
                        </a>
                    </div>
                    @endif

                    <input type="file" name="archivo_pdf" accept=".pdf" class="admin-input">
                    <p style="font-size:11px;color:var(--medium-gray);margin:4px 0 0;">
                        @if($normativa->archivo_pdf)
                            Sube un nuevo PDF para reemplazar el actual, o déjalo vacío para mantenerlo.
                        @else
                            Solo archivos .pdf.
                        @endif
                    </p>
                </div>

                <div>
                    <label style="display:block;font-size:13px;font-weight:600;color:var(--dark);margin-bottom:6px;">
                        Orden <span style="color:var(--medium-gray);font-weight:400;">(menor = primero)</span>
                    </label>
                    <input type="number" name="orden" value="{{ old('orden', $normativa->orden) }}"
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
                               {{ old('activo', $normativa->activo) ? 'checked' : '' }}
                               style="width:16px;height:16px;accent-color:var(--primary);flex-shrink:0;">
                        <div>
                            <div style="font-size:13px;font-weight:600;color:var(--dark);">Visible en el sitio</div>
                            <div style="font-size:11px;color:var(--medium-gray);">Aparece en Normativa Legal</div>
                        </div>
                    </label>
                </div>

                <div class="admin-card" style="margin-bottom:16px;">
                    <h3 style="font-size:14px;font-weight:700;color:var(--dark);margin:0 0 10px;display:flex;align-items:center;gap:6px;">
                        <i class="fas fa-info-circle" style="color:var(--primary);"></i> Información
                    </h3>
                    <div style="font-size:12px;color:var(--medium-gray);line-height:1.6;">
                        <div style="display:flex;justify-content:space-between;padding:4px 0;">
                            <span>Creado:</span>
                            <span style="color:var(--dark);font-weight:500;">{{ $normativa->created_at->format('d/m/Y') }}</span>
                        </div>
                        <div style="display:flex;justify-content:space-between;padding:4px 0;">
                            <span>Actualizado:</span>
                            <span style="color:var(--dark);font-weight:500;">{{ $normativa->updated_at->format('d/m/Y') }}</span>
                        </div>
                    </div>
                </div>

                <button type="submit" class="primary-btn" style="width:100%;justify-content:center;margin-bottom:10px;">
                    <i class="fas fa-save"></i> Actualizar Documento
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
