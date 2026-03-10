@extends('layouts.admin')

@section('title', 'Nuevo Recurso Bibliográfico')
@section('page-title', 'Nuevo Recurso Bibliográfico')

@section('content')

<div style="width:100%;">

    {{-- HEADER --}}
    <div style="display:flex;align-items:center;gap:14px;margin-bottom:24px;">
        <a href="{{ route('admin.biblioteca.index') }}"
           style="width:36px;height:36px;border-radius:50%;background:var(--light-gray);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;color:var(--medium-gray);text-decoration:none;">
            <i class="fas fa-arrow-left" style="font-size:13px;"></i>
        </a>
        <div>
            <h1 style="font-size:22px;font-weight:700;color:var(--dark);margin:0 0 2px;">Nuevo Recurso Bibliográfico</h1>
            <p style="color:var(--medium-gray);font-size:13px;margin:0;">Completa el formulario para agregar un recurso a la biblioteca</p>
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

    <form action="{{ route('admin.biblioteca.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div style="display:grid;grid-template-columns:1fr 320px;gap:20px;align-items:start;">

            {{-- ===== COLUMNA PRINCIPAL ===== --}}
            <div>
                {{-- Información básica --}}
                <div class="admin-card" style="margin-bottom:16px;">
                    <h3 style="font-size:14px;font-weight:700;color:var(--dark);margin:0 0 16px;display:flex;align-items:center;gap:6px;">
                        <i class="fas fa-book" style="color:var(--primary);"></i> Información del Recurso
                    </h3>
                    <div style="margin-bottom:14px;">
                        <label style="display:block;font-size:13px;font-weight:600;color:var(--dark);margin-bottom:6px;">Título <span style="color:var(--danger);">*</span></label>
                        <input type="text" name="titulo" value="{{ old('titulo') }}"
                               placeholder="Ej: Antropología Cultural en los Andes"
                               class="admin-input" required>
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:14px;">
                        <div>
                            <label style="display:block;font-size:13px;font-weight:600;color:var(--dark);margin-bottom:6px;">Autor(es) <span style="color:var(--danger);">*</span></label>
                            <input type="text" name="autor" value="{{ old('autor') }}"
                                   placeholder="Ej: Dr. Carlos Mendoza"
                                   class="admin-input" required>
                        </div>
                        <div>
                            <label style="display:block;font-size:13px;font-weight:600;color:var(--dark);margin-bottom:6px;">Editorial <span style="color:var(--medium-gray);font-weight:400;">(opcional)</span></label>
                            <input type="text" name="editorial" value="{{ old('editorial') }}"
                                   placeholder="Nombre de la editorial"
                                   class="admin-input">
                        </div>
                    </div>
                    <div style="margin-bottom:14px;">
                        <label style="display:block;font-size:13px;font-weight:600;color:var(--dark);margin-bottom:6px;">Descripción <span style="color:var(--danger);">*</span></label>
                        <textarea name="descripcion" rows="5"
                                  placeholder="Resumen o sinopsis del recurso bibliográfico..."
                                  class="admin-input" required>{{ old('descripcion') }}</textarea>
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:14px;">
                        <div>
                            <label style="display:block;font-size:13px;font-weight:600;color:var(--dark);margin-bottom:6px;">Año publicación</label>
                            <input type="number" name="anio_publicacion" value="{{ old('anio_publicacion') }}"
                                   placeholder="2024" min="1900" max="{{ date('Y') + 1 }}"
                                   class="admin-input">
                        </div>
                        <div>
                            <label style="display:block;font-size:13px;font-weight:600;color:var(--dark);margin-bottom:6px;">ISBN / ISSN</label>
                            <input type="text" name="isbn_issn" value="{{ old('isbn_issn') }}"
                                   placeholder="978-3-16-148410-0"
                                   class="admin-input">
                        </div>
                        <div>
                            <label style="display:block;font-size:13px;font-weight:600;color:var(--dark);margin-bottom:6px;">Páginas</label>
                            <input type="number" name="paginas" value="{{ old('paginas') }}"
                                   placeholder="350" min="1"
                                   class="admin-input">
                        </div>
                    </div>
                </div>

                {{-- Archivos --}}
                <div class="admin-card" style="margin-bottom:16px;">
                    <h3 style="font-size:14px;font-weight:700;color:var(--dark);margin:0 0 16px;display:flex;align-items:center;gap:6px;">
                        <i class="fas fa-file-upload" style="color:var(--primary);"></i> Archivos y Enlaces
                    </h3>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:14px;">
                        <div>
                            <label style="display:block;font-size:13px;font-weight:600;color:var(--dark);margin-bottom:6px;">Archivo PDF <span style="color:var(--medium-gray);font-weight:400;">(máx 50MB)</span></label>
                            <input type="file" name="archivo_pdf" accept=".pdf"
                                   class="admin-input" style="padding:8px;">
                        </div>
                        <div>
                            <label style="display:block;font-size:13px;font-weight:600;color:var(--dark);margin-bottom:6px;">Imagen de Portada <span style="color:var(--medium-gray);font-weight:400;">(máx 5MB)</span></label>
                            <input type="file" name="imagen_portada" accept="image/*"
                                   class="admin-input" style="padding:8px;">
                        </div>
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
                        <div>
                            <label style="display:block;font-size:13px;font-weight:600;color:var(--dark);margin-bottom:6px;">Enlace externo <span style="color:var(--medium-gray);font-weight:400;">(URL)</span></label>
                            <input type="url" name="enlace_externo" value="{{ old('enlace_externo') }}"
                                   placeholder="https://repositorio.ejemplo.com/..."
                                   class="admin-input">
                        </div>
                        <div>
                            <label style="display:block;font-size:13px;font-weight:600;color:var(--dark);margin-bottom:6px;">Idioma</label>
                            <input type="text" name="idioma" value="{{ old('idioma', 'Español') }}"
                                   placeholder="Español"
                                   class="admin-input">
                        </div>
                    </div>
                </div>

                {{-- COPYRIGHT & LICENCIA --}}
                <div class="admin-card" style="margin-bottom:16px;border-left:4px solid var(--secondary);">
                    <h3 style="font-size:14px;font-weight:700;color:var(--dark);margin:0 0 6px;display:flex;align-items:center;gap:6px;">
                        <i class="fas fa-shield-alt" style="color:var(--secondary);"></i> Copyright y Licencia
                    </h3>
                    <p style="color:var(--medium-gray);font-size:12px;margin:0 0 16px;">Define los derechos de autor y condiciones de uso del recurso.</p>

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:14px;">
                        <div>
                            <label style="display:block;font-size:13px;font-weight:600;color:var(--dark);margin-bottom:6px;">Titular del copyright</label>
                            <input type="text" name="copyright_titular" value="{{ old('copyright_titular') }}"
                                   placeholder="Nombre del titular de derechos"
                                   class="admin-input">
                        </div>
                        <div>
                            <label style="display:block;font-size:13px;font-weight:600;color:var(--dark);margin-bottom:6px;">Año del copyright</label>
                            <input type="number" name="copyright_anio" value="{{ old('copyright_anio') }}"
                                   placeholder="{{ date('Y') }}" min="1900" max="{{ date('Y') + 1 }}"
                                   class="admin-input">
                        </div>
                    </div>

                    <div style="margin-bottom:14px;">
                        <label style="display:block;font-size:13px;font-weight:600;color:var(--dark);margin-bottom:6px;">Tipo de Licencia <span style="color:var(--danger);">*</span></label>
                        <select name="licencia_tipo" class="admin-input" required>
                            <optgroup label="Derechos Reservados">
                                <option value="copyright" {{ old('licencia_tipo','copyright')=='copyright'?'selected':'' }}>© Todos los derechos reservados</option>
                            </optgroup>
                            <optgroup label="Creative Commons">
                                <option value="creative_commons_by" {{ old('licencia_tipo')=='creative_commons_by'?'selected':'' }}>CC BY — Atribución</option>
                                <option value="cc_by_sa" {{ old('licencia_tipo')=='cc_by_sa'?'selected':'' }}>CC BY-SA — Atribución-CompartirIgual</option>
                                <option value="cc_by_nc" {{ old('licencia_tipo')=='cc_by_nc'?'selected':'' }}>CC BY-NC — Atribución-NoComercial</option>
                                <option value="cc_by_nc_sa" {{ old('licencia_tipo')=='cc_by_nc_sa'?'selected':'' }}>CC BY-NC-SA — Atrib-NoCom-CompartirIgual</option>
                                <option value="cc_by_nd" {{ old('licencia_tipo')=='cc_by_nd'?'selected':'' }}>CC BY-ND — Atribución-SinDerivadas</option>
                                <option value="cc_by_nc_nd" {{ old('licencia_tipo')=='cc_by_nc_nd'?'selected':'' }}>CC BY-NC-ND — Atrib-NoCom-SinDerivadas</option>
                            </optgroup>
                            <optgroup label="Otros">
                                <option value="dominio_publico" {{ old('licencia_tipo')=='dominio_publico'?'selected':'' }}>Dominio Público</option>
                                <option value="licencia_cpap" {{ old('licencia_tipo')=='licencia_cpap'?'selected':'' }}>Licencia CPAP — Uso institucional</option>
                            </optgroup>
                        </select>
                    </div>

                    <div>
                        <label style="display:block;font-size:13px;font-weight:600;color:var(--dark);margin-bottom:6px;">Notas legales / Restricciones de uso <span style="color:var(--medium-gray);font-weight:400;">(opcional)</span></label>
                        <textarea name="notas_legales" rows="3"
                                  placeholder="Ej: Prohibida la reproducción total o parcial sin autorización escrita del autor..."
                                  class="admin-input">{{ old('notas_legales') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- ===== COLUMNA LATERAL ===== --}}
            <div>
                {{-- Clasificación --}}
                <div class="admin-card" style="margin-bottom:16px;">
                    <h3 style="font-size:14px;font-weight:700;color:var(--dark);margin:0 0 14px;display:flex;align-items:center;gap:6px;">
                        <i class="fas fa-cog" style="color:var(--primary);"></i> Clasificación
                    </h3>
                    <div style="margin-bottom:12px;">
                        <label style="display:block;font-size:12px;font-weight:600;color:var(--medium-gray);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:6px;">Tipo de recurso <span style="color:var(--danger);">*</span></label>
                        <select name="tipo" class="admin-input" required>
                            <option value="libro" {{ old('tipo')=='libro'?'selected':'' }}>Libro</option>
                            <option value="articulo" {{ old('tipo')=='articulo'?'selected':'' }}>Artículo</option>
                            <option value="tesis" {{ old('tipo')=='tesis'?'selected':'' }}>Tesis</option>
                            <option value="documento" {{ old('tipo')=='documento'?'selected':'' }}>Documento CPAP</option>
                            <option value="revista" {{ old('tipo')=='revista'?'selected':'' }}>Revista</option>
                            <option value="multimedia" {{ old('tipo')=='multimedia'?'selected':'' }}>Multimedia</option>
                        </select>
                    </div>
                    <div style="margin-bottom:12px;">
                        <label style="display:block;font-size:12px;font-weight:600;color:var(--medium-gray);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:6px;">Formato <span style="color:var(--danger);">*</span></label>
                        <select name="formato" class="admin-input" required>
                            <option value="digital" {{ old('formato','digital')=='digital'?'selected':'' }}>💻 Virtual (Digital)</option>
                            <option value="fisico" {{ old('formato')=='fisico'?'selected':'' }}>📚 Físico</option>
                        </select>
                    </div>
                    <div style="margin-bottom:12px;">
                        <label style="display:block;font-size:12px;font-weight:600;color:var(--medium-gray);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:6px;">Área temática <span style="color:var(--danger);">*</span></label>
                        <select name="area_tematica" class="admin-input" required>
                            <option value="cultural" {{ old('area_tematica')=='cultural'?'selected':'' }}>Antropología Cultural</option>
                            <option value="social" {{ old('area_tematica')=='social'?'selected':'' }}>Antropología Social</option>
                            <option value="arqueologia" {{ old('area_tematica')=='arqueologia'?'selected':'' }}>Arqueología</option>
                            <option value="linguistica" {{ old('area_tematica')=='linguistica'?'selected':'' }}>Lingüística</option>
                            <option value="biologica" {{ old('area_tematica')=='biologica'?'selected':'' }}>Antropología Biológica</option>
                        </select>
                    </div>
                </div>

                {{-- Estado y opciones --}}
                <div class="admin-card" style="margin-bottom:16px;">
                    <h3 style="font-size:14px;font-weight:700;color:var(--dark);margin:0 0 14px;display:flex;align-items:center;gap:6px;">
                        <i class="fas fa-sliders-h" style="color:var(--primary);"></i> Estado y Acceso
                    </h3>
                    <div style="margin-bottom:12px;">
                        <label style="display:block;font-size:12px;font-weight:600;color:var(--medium-gray);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:6px;">Estado</label>
                        <select name="activo" class="admin-input">
                            <option value="1" {{ old('activo','1')=='1'?'selected':'' }}>Publicado</option>
                            <option value="0" {{ old('activo')=='0'?'selected':'' }}>Oculto</option>
                        </select>
                    </div>
                    <div style="margin-bottom:14px;">
                        <label style="display:flex;align-items:center;gap:8px;font-size:13px;font-weight:500;color:var(--dark);cursor:pointer;">
                            <input type="hidden" name="destacado" value="0">
                            <input type="checkbox" name="destacado" value="1" {{ old('destacado') ? 'checked' : '' }}
                                   style="width:18px;height:18px;accent-color:var(--secondary);">
                            <span><i class="fas fa-star" style="color:var(--secondary);margin-right:4px;"></i> Recurso destacado</span>
                        </label>
                    </div>
                    <div style="margin-bottom:14px;">
                        <label style="display:flex;align-items:center;gap:8px;font-size:13px;font-weight:500;color:var(--dark);cursor:pointer;">
                            <input type="hidden" name="descarga_permitida" value="0">
                            <input type="checkbox" name="descarga_permitida" value="1" {{ old('descarga_permitida') ? 'checked' : '' }}
                                   style="width:18px;height:18px;accent-color:var(--primary);">
                            <span><i class="fas fa-download" style="color:var(--primary);margin-right:4px;"></i> Permitir descarga</span>
                        </label>
                    </div>
                    <div>
                        <label style="display:flex;align-items:center;gap:8px;font-size:13px;font-weight:500;color:var(--dark);cursor:pointer;">
                            <input type="hidden" name="solo_colegiados" value="0">
                            <input type="checkbox" name="solo_colegiados" value="1" {{ old('solo_colegiados') ? 'checked' : '' }}
                                   style="width:18px;height:18px;accent-color:var(--primary);">
                            <span><i class="fas fa-lock" style="color:var(--primary);margin-right:4px;"></i> Solo colegiados</span>
                        </label>
                        <p style="color:var(--medium-gray);font-size:11px;margin:6px 0 0;padding-left:26px;">Restringe el acceso solo a colegiados habilitados</p>
                    </div>
                </div>

                {{-- Info de copyright resumida --}}
                <div class="admin-card" style="margin-bottom:16px;background:rgba(201,169,97,0.06);border:1px solid rgba(201,169,97,0.2);">
                    <h3 style="font-size:13px;font-weight:700;color:var(--dark);margin:0 0 10px;display:flex;align-items:center;gap:6px;">
                        <i class="fas fa-info-circle" style="color:var(--secondary);"></i> Acerca del Copyright
                    </h3>
                    <ul style="margin:0;padding-left:18px;font-size:12px;color:var(--medium-gray);line-height:1.8;">
                        <li><strong>Copyright ©</strong> — Todos los derechos reservados por el autor/editor.</li>
                        <li><strong>Creative Commons</strong> — Permite compartir con condiciones específicas.</li>
                        <li><strong>Dominio Público</strong> — Sin restricciones de uso.</li>
                        <li><strong>Licencia CPAP</strong> — Uso exclusivo institucional.</li>
                    </ul>
                </div>

                <button type="submit" class="primary-btn" style="width:100%;justify-content:center;font-size:15px;padding:13px;">
                    <i class="fas fa-save"></i> Guardar Recurso
                </button>
            </div>
        </div>
    </form>

</div>

@push('styles')
<style>
@media (max-width: 768px) {
    div[style*="grid-template-columns:1fr 320px"] {
        grid-template-columns: 1fr !important;
    }
    div[style*="grid-template-columns:1fr 1fr"] {
        grid-template-columns: 1fr !important;
    }
    div[style*="grid-template-columns:1fr 1fr 1fr"] {
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
