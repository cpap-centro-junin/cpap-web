@extends('layouts.admin')

@section('title', 'Nuevo Colegiado')
@section('page-title', 'Registrar Nuevo Colegiado')

@section('content')

<div class="admin-container">

    {{-- Breadcrumb --}}
    <div class="breadcrumb">
        <a href="{{ route('admin.colegiados.index') }}">
            <i class="fas fa-id-card"></i> Colegiados
        </a>
        <span>/</span>
        <span>Nuevo</span>
    </div>

    {{-- Formulario --}}
    <div class="form-card">
        <form action="{{ route('admin.colegiados.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-header">
                <h2><i class="fas fa-user-plus"></i> Datos del Colegiado</h2>
            </div>

            {{-- ── IDENTIFICACIÓN ──────────────────────────────── --}}
            <div class="form-section">
                <h3 class="section-title">Identificación</h3>
                <div class="form-row">
                    <div class="form-group">
                        <label for="codigo_cpap">Número de Colegiatura <span class="required">*</span></label>
                        <input type="text" class="form-control @error('codigo_cpap') is-invalid @enderror"
                               id="codigo_cpap" name="codigo_cpap" value="{{ old('codigo_cpap') }}"
                               placeholder="CPAP-2026-00001" required>
                        @error('codigo_cpap')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="dni">DNI <span class="required">*</span></label>
                        <input type="text" class="form-control @error('dni') is-invalid @enderror"
                               id="dni" name="dni" value="{{ old('dni') }}"
                               placeholder="12345678" maxlength="8" required>
                        @error('dni')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- ── INFORMACIÓN PERSONAL ────────────────────────── --}}
            <div class="form-section">
                <h3 class="section-title">Información Personal</h3>
                <div class="form-row">
                    <div class="form-group">
                        <label for="nombres">Nombres <span class="required">*</span></label>
                        <input type="text" class="form-control @error('nombres') is-invalid @enderror"
                               id="nombres" name="nombres" value="{{ old('nombres') }}" required>
                        @error('nombres')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="apellidos">Apellidos <span class="required">*</span></label>
                        <input type="text" class="form-control @error('apellidos') is-invalid @enderror"
                               id="apellidos" name="apellidos" value="{{ old('apellidos') }}" required>
                        @error('apellidos')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="fecha_nacimiento">Fecha de Nacimiento <span class="text-muted" style="font-size:11px;font-weight:400;">(opcional)</span></label>
                        <input type="date" class="form-control @error('fecha_nacimiento') is-invalid @enderror"
                               id="fecha_nacimiento" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}">
                        @error('fecha_nacimiento')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email <span class="text-muted" style="font-size:11px;font-weight:400;">(opcional)</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                               id="email" name="email" value="{{ old('email') }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="telefono">Teléfono <span class="text-muted" style="font-size:11px;font-weight:400;">(opcional)</span></label>
                        <input type="text" class="form-control @error('telefono') is-invalid @enderror"
                               id="telefono" name="telefono" value="{{ old('telefono') }}"
                               placeholder="987654321">
                        @error('telefono')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="foto">Foto de Perfil <span class="text-muted" style="font-size:11px;font-weight:400;">(opcional)</span></label>
                        <input type="file" class="form-control @error('foto') is-invalid @enderror"
                               id="foto" name="foto" accept="image/*">
                        <small class="form-text">JPG, JPEG o PNG. Máximo 2MB.</small>
                        @error('foto')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- ── INFORMACIÓN PROFESIONAL ─────────────────────── --}}
            <div class="form-section">
                <h3 class="section-title">Información Profesional</h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="grado_academico">Grado Académico <span class="text-muted" style="font-size:11px;font-weight:400;">(opcional)</span></label>
                        <select class="form-control @error('grado_academico') is-invalid @enderror"
                                id="grado_academico" name="grado_academico">
                            <option value="">-- Selecciona --</option>
                            <option value="Bachiller" {{ old('grado_academico') == 'Bachiller' ? 'selected' : '' }}>Bachiller</option>
                            <option value="Licenciado" {{ old('grado_academico') == 'Licenciado' ? 'selected' : '' }}>Licenciado</option>
                            <option value="Magíster" {{ old('grado_academico') == 'Magíster' ? 'selected' : '' }}>Magíster</option>
                            <option value="Doctor" {{ old('grado_academico') == 'Doctor' ? 'selected' : '' }}>Doctor</option>
                        </select>
                        @error('grado_academico')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="orientacion">Orientación <span class="text-muted" style="font-size:11px;font-weight:400;">(opcional)</span></label>
                        <input type="text" class="form-control @error('orientacion') is-invalid @enderror"
                               id="orientacion" name="orientacion" value="{{ old('orientacion') }}"
                               placeholder="Ej: Antropología Cultural">
                        @error('orientacion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="especialidad">Especialización <span class="text-muted" style="font-size:11px;font-weight:400;">(opcional)</span></label>
                        <input type="text" class="form-control @error('especialidad') is-invalid @enderror"
                               id="especialidad" name="especialidad" value="{{ old('especialidad') }}"
                               placeholder="Ej: Antropología Social">
                        @error('especialidad')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="experiencia_anos">Años de Experiencia <span class="text-muted" style="font-size:11px;font-weight:400;">(opcional)</span></label>
                        <input type="number" class="form-control @error('experiencia_anos') is-invalid @enderror"
                               id="experiencia_anos" name="experiencia_anos" value="{{ old('experiencia_anos') }}"
                               min="0" max="50" placeholder="Ej: 5">
                        @error('experiencia_anos')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="experiencia_sector">Experiencia en Sector <span class="text-muted" style="font-size:11px;font-weight:400;">(opcional)</span></label>
                        <select class="form-control @error('experiencia_sector') is-invalid @enderror"
                                id="experiencia_sector" name="experiencia_sector">
                            <option value="">-- Selecciona --</option>
                            <option value="publica" {{ old('experiencia_sector') == 'publica' ? 'selected' : '' }}>Pública</option>
                            <option value="privada" {{ old('experiencia_sector') == 'privada' ? 'selected' : '' }}>Privada</option>
                            <option value="mixta" {{ old('experiencia_sector') == 'mixta' ? 'selected' : '' }}>Mixta (Pública y Privada)</option>
                        </select>
                        @error('experiencia_sector')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        {{-- Espacio reservado --}}
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="especializacion_detalle">Detalle de la Especialización <span class="text-muted" style="font-size:11px;font-weight:400;">(opcional)</span></label>
                    <textarea class="form-control @error('especializacion_detalle') is-invalid @enderror"
                              id="especializacion_detalle" name="especializacion_detalle" rows="3"
                              placeholder="Describe tu área específica de especialización y enfoque profesional...">{{ old('especializacion_detalle') }}</textarea>
                    @error('especializacion_detalle')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="diplomados">Diplomados <span class="text-muted" style="font-size:11px;font-weight:400;">(opcional)</span></label>
                    <textarea class="form-control @error('diplomados') is-invalid @enderror"
                              id="diplomados" name="diplomados" rows="3"
                              placeholder="Lista tus diplomados, cada uno en una línea...">{{ old('diplomados') }}</textarea>
                    @error('diplomados')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="universidad">Universidad <span class="text-muted" style="font-size:11px;font-weight:400;">(opcional)</span></label>
                        <input type="text" class="form-control @error('universidad') is-invalid @enderror"
                               id="universidad" name="universidad" value="{{ old('universidad') }}"
                               placeholder="Universidad Nacional Mayor de San Marcos">
                        @error('universidad')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="anio_graduacion">Año de Graduación <span class="text-muted" style="font-size:11px;font-weight:400;">(opcional)</span></label>
                        <input type="number" class="form-control @error('anio_graduacion') is-invalid @enderror"
                               id="anio_graduacion" name="anio_graduacion" value="{{ old('anio_graduacion') }}"
                               min="1950" max="{{ date('Y') }}" placeholder="{{ date('Y') }}">
                        @error('anio_graduacion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Curriculum Vitae (PDF) <span class="text-muted" style="font-size:11px;font-weight:400;">(opcional)</span></label>
                        <input type="file" class="form-control @error('cv') is-invalid @enderror"
                               id="cv" name="cv" accept=".pdf">
                        <small class="form-text">Archivo PDF. Máximo 5MB.</small>
                        @error('cv')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        {{-- Espacio reservado para mantener el grid --}}
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="descripcion">Descripción Profesional <span class="text-muted" style="font-size:11px;font-weight:400;">(opcional)</span></label>
                    <textarea class="form-control @error('descripcion') is-invalid @enderror"
                              id="descripcion" name="descripcion" rows="4"
                              placeholder="Breve descripción de la experiencia y especialización del colegiado...">{{ old('descripcion') }}</textarea>
                    @error('descripcion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- ── ESTADO Y COLEGIATURA ────────────────────────── --}}
            <div class="form-section">
                <h3 class="section-title">Estado y Colegiatura</h3>
                <div class="form-row">
                    <div class="form-group">
                        <label for="estado">Estado <span class="required">*</span></label>
                        <select class="form-control @error('estado') is-invalid @enderror"
                                id="estado" name="estado" required>
                            <option value="inactivo" {{ old('estado') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                            <option value="activo" {{ old('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
                        </select>
                        @error('estado')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="fecha_colegiatura">Fecha de Colegiatura <span class="required">*</span></label>
                        <input type="date" class="form-control @error('fecha_colegiatura') is-invalid @enderror"
                               id="fecha_colegiatura" name="fecha_colegiatura" value="{{ old('fecha_colegiatura') }}" required>
                        @error('fecha_colegiatura')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- ── VISIBILIDAD DEL PERFIL ──────────────────────── --}}
            <div class="form-section form-section-visibility">
                <h3 class="section-title">
                    <i class="fas fa-eye-slash"></i>
                    Visibilidad del Perfil
                </h3>
                <p class="section-description">
                    Controla qué información es visible en el directorio público.
                    El administrador siempre puede ver todos los datos.
                </p>

                {{-- Ocultar perfil completo --}}
                <div class="visibility-toggle-card visibility-toggle-card--danger">
                    <div class="visibility-toggle-card__icon">
                        <i class="fas fa-user-slash"></i>
                    </div>
                    <div class="visibility-toggle-card__info">
                        <strong>Ocultar perfil del directorio público</strong>
                        <span>El colegiado no aparecerá en la búsqueda ni en el listado público. Solo visible desde el panel de administración.</span>
                    </div>
                    <div class="visibility-toggle-card__control">
                        <label class="toggle-switch">
                            <input type="checkbox" name="perfil_oculto" value="1"
                                   {{ old('perfil_oculto') ? 'checked' : '' }}>
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                </div>

                {{-- Campos individuales agrupados --}}
                <div class="vis-groups-container">

                    {{-- Grupo: Presentación --}}
                    <div class="vis-group">
                        <p class="vis-group-label"><i class="fas fa-image"></i> Presentación visual</p>
                        <div class="visibility-fields-grid">
                            <div class="visibility-field-item">
                                <label class="visibility-field-label">
                                    <div class="visibility-field-label__icon"><i class="fas fa-user-circle"></i></div>
                                    <div class="visibility-field-label__text">
                                        <strong>Foto de perfil</strong>
                                        <span>Ocultar foto en perfil público</span>
                                    </div>
                                    <label class="toggle-switch toggle-switch--sm">
                                        <input type="checkbox" name="ocultar_foto" value="1" {{ old('ocultar_foto') ? 'checked' : '' }}>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Grupo: Contacto --}}
                    <div class="vis-group">
                        <p class="vis-group-label"><i class="fas fa-address-book"></i> Datos de contacto</p>
                        <div class="visibility-fields-grid">
                            <div class="visibility-field-item">
                                <label class="visibility-field-label">
                                    <div class="visibility-field-label__icon"><i class="fas fa-envelope"></i></div>
                                    <div class="visibility-field-label__text">
                                        <strong>Correo electrónico</strong>
                                        <span>Ocultar email en perfil público</span>
                                    </div>
                                    <label class="toggle-switch toggle-switch--sm">
                                        <input type="checkbox" name="ocultar_email" value="1" {{ old('ocultar_email') ? 'checked' : '' }}>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </label>
                            </div>
                            <div class="visibility-field-item">
                                <label class="visibility-field-label">
                                    <div class="visibility-field-label__icon"><i class="fas fa-phone"></i></div>
                                    <div class="visibility-field-label__text">
                                        <strong>Teléfono</strong>
                                        <span>Ocultar teléfono en perfil público</span>
                                    </div>
                                    <label class="toggle-switch toggle-switch--sm">
                                        <input type="checkbox" name="ocultar_telefono" value="1" {{ old('ocultar_telefono') ? 'checked' : '' }}>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Grupo: Información académica --}}
                    <div class="vis-group">
                        <p class="vis-group-label"><i class="fas fa-graduation-cap"></i> Información académica y profesional</p>
                        <div class="visibility-fields-grid">
                            <div class="visibility-field-item">
                                <label class="visibility-field-label">
                                    <div class="visibility-field-label__icon"><i class="fas fa-user-graduate"></i></div>
                                    <div class="visibility-field-label__text">
                                        <strong>Grado académico</strong>
                                        <span>Ocultar grado académico en perfil público</span>
                                    </div>
                                    <label class="toggle-switch toggle-switch--sm">
                                        <input type="checkbox" name="ocultar_grado_academico" value="1" {{ old('ocultar_grado_academico') ? 'checked' : '' }}>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </label>
                            </div>
                            <div class="visibility-field-item">
                                <label class="visibility-field-label">
                                    <div class="visibility-field-label__icon"><i class="fas fa-flask"></i></div>
                                    <div class="visibility-field-label__text">
                                        <strong>Especialización</strong>
                                        <span>Ocultar especialización en perfil público</span>
                                    </div>
                                    <label class="toggle-switch toggle-switch--sm">
                                        <input type="checkbox" name="ocultar_especialidad" value="1" {{ old('ocultar_especialidad') ? 'checked' : '' }}>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </label>
                            </div>
                            <div class="visibility-field-item">
                                <label class="visibility-field-label">
                                    <div class="visibility-field-label__icon"><i class="fas fa-list-ul"></i></div>
                                    <div class="visibility-field-label__text">
                                        <strong>Detalle de especialización</strong>
                                        <span>Ocultar detalle de especialización</span>
                                    </div>
                                    <label class="toggle-switch toggle-switch--sm">
                                        <input type="checkbox" name="ocultar_especializacion_detalle" value="1" {{ old('ocultar_especializacion_detalle') ? 'checked' : '' }}>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </label>
                            </div>
                            <div class="visibility-field-item">
                                <label class="visibility-field-label">
                                    <div class="visibility-field-label__icon"><i class="fas fa-compass"></i></div>
                                    <div class="visibility-field-label__text">
                                        <strong>Orientación</strong>
                                        <span>Ocultar orientación en perfil público</span>
                                    </div>
                                    <label class="toggle-switch toggle-switch--sm">
                                        <input type="checkbox" name="ocultar_orientacion" value="1" {{ old('ocultar_orientacion') ? 'checked' : '' }}>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </label>
                            </div>
                            <div class="visibility-field-item">
                                <label class="visibility-field-label">
                                    <div class="visibility-field-label__icon"><i class="fas fa-certificate"></i></div>
                                    <div class="visibility-field-label__text">
                                        <strong>Diplomados</strong>
                                        <span>Ocultar diplomados en perfil público</span>
                                    </div>
                                    <label class="toggle-switch toggle-switch--sm">
                                        <input type="checkbox" name="ocultar_diplomados" value="1" {{ old('ocultar_diplomados') ? 'checked' : '' }}>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </label>
                            </div>
                            <div class="visibility-field-item">
                                <label class="visibility-field-label">
                                    <div class="visibility-field-label__icon"><i class="fas fa-briefcase"></i></div>
                                    <div class="visibility-field-label__text">
                                        <strong>Experiencia profesional</strong>
                                        <span>Ocultar años y sector de experiencia</span>
                                    </div>
                                    <label class="toggle-switch toggle-switch--sm">
                                        <input type="checkbox" name="ocultar_experiencia" value="1" {{ old('ocultar_experiencia') ? 'checked' : '' }}>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </label>
                            </div>
                            <div class="visibility-field-item">
                                <label class="visibility-field-label">
                                    <div class="visibility-field-label__icon"><i class="fas fa-university"></i></div>
                                    <div class="visibility-field-label__text">
                                        <strong>Universidad</strong>
                                        <span>Ocultar universidad en perfil público</span>
                                    </div>
                                    <label class="toggle-switch toggle-switch--sm">
                                        <input type="checkbox" name="ocultar_universidad" value="1" {{ old('ocultar_universidad') ? 'checked' : '' }}>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </label>
                            </div>
                            <div class="visibility-field-item">
                                <label class="visibility-field-label">
                                    <div class="visibility-field-label__icon"><i class="fas fa-calendar-check"></i></div>
                                    <div class="visibility-field-label__text">
                                        <strong>Año de graduación</strong>
                                        <span>Ocultar año de graduación en perfil público</span>
                                    </div>
                                    <label class="toggle-switch toggle-switch--sm">
                                        <input type="checkbox" name="ocultar_anio_graduacion" value="1" {{ old('ocultar_anio_graduacion') ? 'checked' : '' }}>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </label>
                            </div>
                            <div class="visibility-field-item">
                                <label class="visibility-field-label">
                                    <div class="visibility-field-label__icon"><i class="fas fa-id-card"></i></div>
                                    <div class="visibility-field-label__text">
                                        <strong>Fecha de colegiatura</strong>
                                        <span>Ocultar fecha de colegiatura en perfil público</span>
                                    </div>
                                    <label class="toggle-switch toggle-switch--sm">
                                        <input type="checkbox" name="ocultar_fecha_colegiatura" value="1" {{ old('ocultar_fecha_colegiatura') ? 'checked' : '' }}>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Grupo: Descripción y documentos --}}
                    <div class="vis-group">
                        <p class="vis-group-label"><i class="fas fa-file-alt"></i> Descripción y documentos</p>
                        <div class="visibility-fields-grid">
                            <div class="visibility-field-item">
                                <label class="visibility-field-label">
                                    <div class="visibility-field-label__icon"><i class="fas fa-align-left"></i></div>
                                    <div class="visibility-field-label__text">
                                        <strong>Descripción profesional</strong>
                                        <span>Ocultar descripción en perfil público</span>
                                    </div>
                                    <label class="toggle-switch toggle-switch--sm">
                                        <input type="checkbox" name="ocultar_descripcion" value="1" {{ old('ocultar_descripcion') ? 'checked' : '' }}>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </label>
                            </div>
                            <div class="visibility-field-item">
                                <label class="visibility-field-label">
                                    <div class="visibility-field-label__icon"><i class="fas fa-file-pdf"></i></div>
                                    <div class="visibility-field-label__text">
                                        <strong>Curriculum Vitae</strong>
                                        <span>Ocultar enlace de CV en perfil público</span>
                                    </div>
                                    <label class="toggle-switch toggle-switch--sm">
                                        <input type="checkbox" name="ocultar_cv" value="1" {{ old('ocultar_cv') ? 'checked' : '' }}>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </label>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="visibility-note">
                    <i class="fas fa-info-circle"></i>
                    <span>
                        <strong>Nota:</strong> Para aparecer en el directorio público, el colegiado también
                        debe tener un <strong>documento de habilitación activo</strong>. Sin habilitación,
                        el perfil no se muestra aunque esté visible.
                    </span>
                </div>
            </div>

            {{-- ── DOCUMENTO DE HABILITACIÓN ────────────────────── --}}
            <div class="form-section form-section-habilitacion">
                <h3 class="section-title">
                    <i class="fas fa-certificate"></i>
                    Documento de Habilitación <span class="required">*</span>
                </h3>

                <div class="generation-grid" style="margin-bottom: 20px;">
                    <div class="generation-item">
                        <i class="fas fa-fingerprint"></i>
                        <div>
                            <strong>Código UUID único</strong>
                            <span>Irrepetible, embebido en el PDF</span>
                        </div>
                    </div>
                    <div class="generation-item">
                        <i class="fas fa-qrcode"></i>
                        <div>
                            <strong>Código QR</strong>
                            <span>Apunta a la URL de verificación pública</span>
                        </div>
                    </div>
                    <div class="generation-item">
                        <i class="fas fa-link"></i>
                        <div>
                            <strong>URL de verificación</strong>
                            <span>Acceso público para validar el documento</span>
                        </div>
                    </div>
                    <div class="generation-item">
                        <i class="fas fa-user-check"></i>
                        <div>
                            <strong>Estado ACTIVO</strong>
                            <span>El colegiado se activa automáticamente</span>
                        </div>
                    </div>
                </div>

                <div class="upload-container">
                    <div class="upload-box" id="habUploadBox">
                        <i class="fas fa-file-pdf upload-icon"></i>
                        <h4>Selecciona el documento PDF</h4>
                        <p class="upload-hint">Haz clic o arrastra el archivo aquí</p>
                        <p class="upload-specs">PDF • Máximo 10 MB</p>
                    </div>

                    <input
                        type="file"
                        name="documento"
                        id="documento"
                        class="upload-input @error('documento') is-invalid @enderror"
                        accept=".pdf"
                    >

                    <div class="file-info" id="habFileInfo" style="display: none;">
                        <i class="fas fa-check-circle"></i>
                        <span id="habFileName"></span>
                        <span id="habFileSize"></span>
                    </div>

                    <div class="invalid-feedback" id="docErrorMsg" style="display:none;">Debes adjuntar el documento PDF de habilitación antes de registrar.</div>

                    @error('documento')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Botones --}}
            <div class="form-footer">
                <a href="{{ route('admin.colegiados.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i>
                    Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-magic"></i>
                    Registrar y Generar Habilitación
                </button>
            </div>
        </form>
    </div>

</div>

@push('scripts')
<script>
(function () {
    const input    = document.getElementById('documento');
    const box      = document.getElementById('habUploadBox');
    const info     = document.getElementById('habFileInfo');
    const nameSpan = document.getElementById('habFileName');
    const sizeSpan = document.getElementById('habFileSize');
    const docError = document.getElementById('docErrorMsg');

    // Validación del documento al enviar el formulario
    const form = input.closest('form');
    form.addEventListener('submit', function (e) {
        if (!input.files || input.files.length === 0) {
            e.preventDefault();
            box.classList.add('upload-box--error');
            docError.style.display = 'block';
            box.scrollIntoView({ behavior: 'smooth', block: 'center' });
            return;
        }
        box.classList.remove('upload-box--error');
        docError.style.display = 'none';
    });

    function mostrarArchivo(file) {
        nameSpan.textContent = file.name;
        sizeSpan.textContent = '(' + (file.size / 1024 / 1024).toFixed(2) + ' MB)';
        info.style.display   = 'flex';
        box.style.opacity    = '0.5';
    }

    input.addEventListener('change', function () {
        if (this.files.length > 0) {
            mostrarArchivo(this.files[0]);
            box.classList.remove('upload-box--error');
            docError.style.display = 'none';
        } else {
            info.style.display = 'none';
            box.style.opacity  = '1';
        }
    });

    box.addEventListener('click', () => input.click());

    box.addEventListener('dragover', (e) => { e.preventDefault(); box.classList.add('drag-over'); });
    box.addEventListener('dragleave', () => box.classList.remove('drag-over'));
    box.addEventListener('drop', (e) => {
        e.preventDefault();
        box.classList.remove('drag-over');
        const files = e.dataTransfer.files;
        if (files.length > 0 && files[0].type === 'application/pdf') {
            input.files = files;
            mostrarArchivo(files[0]);
        }
    });
})();
</script>
@endpush

@endsection
