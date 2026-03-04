@extends('layouts.admin')

@section('title', 'Editar Colegiado')
@section('page-title', 'Editar Colegiado')

@section('content')

<div class="admin-container">

    {{-- Breadcrumb --}}
    <div class="breadcrumb">
        <a href="{{ route('admin.colegiados.index') }}">
            <i class="fas fa-id-card"></i> Colegiados
        </a>
        <span>/</span>
        <a href="{{ route('admin.colegiados.show', $colegiado) }}">{{ $colegiado->codigo_cpap }}</a>
        <span>/</span>
        <span>Editar</span>
    </div>

    {{-- Banner contextual del colegiado siendo editado --}}
    <div class="edit-context-banner">
        <div class="edit-context-banner__avatar">
            @if($colegiado->foto)
                <img src="{{ Storage::url($colegiado->foto) }}" alt="{{ $colegiado->nombre_completo }}">
            @else
                <div class="edit-context-banner__initials">
                    {{ strtoupper(substr($colegiado->nombres, 0, 1) . substr($colegiado->apellidos, 0, 1)) }}
                </div>
            @endif
        </div>
        <div class="edit-context-banner__info">
            <div class="edit-context-banner__label">Editando colegiado</div>
            <h2>{{ $colegiado->nombre_completo }}</h2>
            <div class="edit-context-banner__meta">
                <span><i class="fas fa-id-badge"></i> {{ $colegiado->codigo_cpap }}</span>
                <span><i class="fas fa-id-card"></i> DNI: {{ $colegiado->dni }}</span>
                @if($colegiado->especialidad)
                    <span><i class="fas fa-graduation-cap"></i> {{ $colegiado->especialidad }}</span>
                @endif
                @if($colegiado->perfil_oculto)
                    <span class="banner-badge-oculto"><i class="fas fa-eye-slash"></i> Perfil oculto</span>
                @endif
            </div>
        </div>
        <div class="edit-context-banner__actions">
            <a href="{{ route('admin.colegiados.show', $colegiado) }}" class="btn btn-sm btn-outline-light">
                <i class="fas fa-eye"></i>
                Ver detalle
            </a>
        </div>
    </div>

    {{-- Formulario --}}
    <div class="form-card">
        <form action="{{ route('admin.colegiados.update', $colegiado) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-header">
                <h2><i class="fas fa-edit"></i> Editar Datos del Colegiado</h2>
            </div>

            {{-- ── IDENTIFICACIÓN ──────────────────────────────── --}}
            <div class="form-section">
                <h3 class="section-title">Identificación</h3>
                <div class="form-row">
                    <div class="form-group">
                        <label for="codigo_cpap">Número de Colegiatura <span class="required">*</span></label>
                        <input type="text" class="form-control @error('codigo_cpap') is-invalid @enderror"
                               id="codigo_cpap" name="codigo_cpap" value="{{ old('codigo_cpap', $colegiado->codigo_cpap) }}"
                               placeholder="CPAP-2026-00001" required>
                        @error('codigo_cpap')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="dni">DNI <span class="required">*</span></label>
                        <input type="text" class="form-control @error('dni') is-invalid @enderror"
                               id="dni" name="dni" value="{{ old('dni', $colegiado->dni) }}"
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
                               id="nombres" name="nombres" value="{{ old('nombres', $colegiado->nombres) }}" required>
                        @error('nombres')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="apellidos">Apellidos <span class="required">*</span></label>
                        <input type="text" class="form-control @error('apellidos') is-invalid @enderror"
                               id="apellidos" name="apellidos" value="{{ old('apellidos', $colegiado->apellidos) }}" required>
                        @error('apellidos')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                               id="email" name="email" value="{{ old('email', $colegiado->email) }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input type="text" class="form-control @error('telefono') is-invalid @enderror"
                               id="telefono" name="telefono" value="{{ old('telefono', $colegiado->telefono) }}"
                               placeholder="987654321">
                        @error('telefono')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                        <input type="date" class="form-control @error('fecha_nacimiento') is-invalid @enderror"
                               id="fecha_nacimiento" name="fecha_nacimiento"
                               value="{{ old('fecha_nacimiento', $colegiado->fecha_nacimiento?->format('Y-m-d')) }}">
                        @error('fecha_nacimiento')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="foto">Foto de Perfil</label>
                        @if($colegiado->foto)
                            <div class="current-file-preview">
                                <img src="{{ Storage::url($colegiado->foto) }}" alt="Foto actual">
                                <span class="text-muted">Foto actual</span>
                            </div>
                        @endif
                        <input type="file" class="form-control @error('foto') is-invalid @enderror"
                               id="foto" name="foto" accept="image/*">
                        <small class="form-text">JPG, JPEG o PNG. Máximo 2MB. Dejar vacío para mantener la actual.</small>
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
                        <label for="grado_academico">Grado Académico</label>
                        <select class="form-control @error('grado_academico') is-invalid @enderror"
                                id="grado_academico" name="grado_academico">
                            <option value="">-- Selecciona --</option>
                            <option value="Bachiller" {{ old('grado_academico', $colegiado->grado_academico) == 'Bachiller' ? 'selected' : '' }}>Bachiller</option>
                            <option value="Licenciado" {{ old('grado_academico', $colegiado->grado_academico) == 'Licenciado' ? 'selected' : '' }}>Licenciado</option>
                            <option value="Magíster" {{ old('grado_academico', $colegiado->grado_academico) == 'Magíster' ? 'selected' : '' }}>Magíster</option>
                            <option value="Doctor" {{ old('grado_academico', $colegiado->grado_academico) == 'Doctor' ? 'selected' : '' }}>Doctor</option>
                        </select>
                        @error('grado_academico')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="orientacion">Orientación</label>
                        <input type="text" class="form-control @error('orientacion') is-invalid @enderror"
                               id="orientacion" name="orientacion" value="{{ old('orientacion', $colegiado->orientacion) }}"
                               placeholder="Ej: Antropología Cultural">
                        @error('orientacion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="especialidad">Especialización</label>
                        <input type="text" class="form-control @error('especialidad') is-invalid @enderror"
                               id="especialidad" name="especialidad" value="{{ old('especialidad', $colegiado->especialidad) }}"
                               placeholder="Ej: Antropología Social">
                        @error('especialidad')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="experiencia_anos">Años de Experiencia</label>
                        <input type="number" class="form-control @error('experiencia_anos') is-invalid @enderror"
                               id="experiencia_anos" name="experiencia_anos" value="{{ old('experiencia_anos', $colegiado->experiencia_anos) }}"
                               min="0" max="50" placeholder="Ej: 5">
                        @error('experiencia_anos')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="experiencia_sector">Experiencia en Sector</label>
                        <select class="form-control @error('experiencia_sector') is-invalid @enderror"
                                id="experiencia_sector" name="experiencia_sector">
                            <option value="">-- Selecciona --</option>
                            <option value="publica" {{ old('experiencia_sector', $colegiado->experiencia_sector) == 'publica' ? 'selected' : '' }}>Pública</option>
                            <option value="privada" {{ old('experiencia_sector', $colegiado->experiencia_sector) == 'privada' ? 'selected' : '' }}>Privada</option>
                            <option value="mixta" {{ old('experiencia_sector', $colegiado->experiencia_sector) == 'mixta' ? 'selected' : '' }}>Mixta (Pública y Privada)</option>
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
                    <label for="especializacion_detalle">Detalle de la Especialización</label>
                    <textarea class="form-control @error('especializacion_detalle') is-invalid @enderror"
                              id="especializacion_detalle" name="especializacion_detalle" rows="3"
                              placeholder="Describe tu área específica de especialización y enfoque profesional...">{{ old('especializacion_detalle', $colegiado->especializacion_detalle) }}</textarea>
                    @error('especializacion_detalle')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="diplomados">Diplomados</label>
                    <textarea class="form-control @error('diplomados') is-invalid @enderror"
                              id="diplomados" name="diplomados" rows="3"
                              placeholder="Lista tus diplomados, cada uno en una línea...">{{ old('diplomados', $colegiado->diplomados) }}</textarea>
                    @error('diplomados')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="universidad">Universidad</label>
                        <input type="text" class="form-control @error('universidad') is-invalid @enderror"
                               id="universidad" name="universidad" value="{{ old('universidad', $colegiado->universidad) }}"
                               placeholder="Universidad Nacional Mayor de San Marcos">
                        @error('universidad')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="anio_graduacion">Año de Graduación</label>
                        <input type="number" class="form-control @error('anio_graduacion') is-invalid @enderror"
                               id="anio_graduacion" name="anio_graduacion" value="{{ old('anio_graduacion', $colegiado->anio_graduacion) }}"
                               min="1950" max="{{ date('Y') }}" placeholder="{{ date('Y') }}">
                        @error('anio_graduacion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Curriculum Vitae (PDF)</label>
                        @if($colegiado->cv_path)
                            <div class="current-file-preview">
                                <i class="fas fa-file-pdf"></i>
                                <span class="text-muted">CV actual cargado</span>
                            </div>
                        @endif
                        <input type="file" class="form-control @error('cv') is-invalid @enderror"
                               id="cv" name="cv" accept=".pdf">
                        <small class="form-text">Archivo PDF. Máximo 5MB. Dejar vacío para mantener el actual.</small>
                        @error('cv')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        {{-- Espacio reservado para mantener el grid --}}
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="descripcion">Descripción Profesional</label>
                    <textarea class="form-control @error('descripcion') is-invalid @enderror"
                              id="descripcion" name="descripcion" rows="4"
                              placeholder="Breve descripción de la experiencia y especialización del colegiado...">{{ old('descripcion', $colegiado->descripcion) }}</textarea>
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
                            <option value="inactivo" {{ old('estado', $colegiado->estado) == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                            <option value="activo" {{ old('estado', $colegiado->estado) == 'activo' ? 'selected' : '' }}>Activo</option>
                        </select>
                        @error('estado')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="fecha_colegiatura">Fecha de Colegiatura <span class="required">*</span></label>
                        <input type="date" class="form-control @error('fecha_colegiatura') is-invalid @enderror"
                               id="fecha_colegiatura" name="fecha_colegiatura"
                               value="{{ old('fecha_colegiatura', $colegiado->fecha_colegiatura->format('Y-m-d')) }}" required>
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
                <div class="visibility-toggle-card {{ $colegiado->perfil_oculto ? 'visibility-toggle-card--active' : '' }} visibility-toggle-card--danger">
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
                                   {{ old('perfil_oculto', $colegiado->perfil_oculto) ? 'checked' : '' }}>
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
                            <div class="visibility-field-item {{ $colegiado->ocultar_foto ? 'visibility-field-item--hidden' : '' }}">
                                <label class="visibility-field-label">
                                    <div class="visibility-field-label__icon"><i class="fas fa-user-circle"></i></div>
                                    <div class="visibility-field-label__text">
                                        <strong>Foto de perfil</strong>
                                        <span>{{ $colegiado->ocultar_foto ? 'Oculta en perfil público' : 'Visible en perfil público' }}</span>
                                    </div>
                                    <label class="toggle-switch toggle-switch--sm">
                                        <input type="checkbox" name="ocultar_foto" value="1" {{ old('ocultar_foto', $colegiado->ocultar_foto) ? 'checked' : '' }}>
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
                            <div class="visibility-field-item {{ $colegiado->ocultar_email ? 'visibility-field-item--hidden' : '' }}">
                                <label class="visibility-field-label">
                                    <div class="visibility-field-label__icon"><i class="fas fa-envelope"></i></div>
                                    <div class="visibility-field-label__text">
                                        <strong>Correo electrónico</strong>
                                        <span>{{ $colegiado->ocultar_email ? 'Oculto en perfil público' : 'Visible en perfil público' }}</span>
                                    </div>
                                    <label class="toggle-switch toggle-switch--sm">
                                        <input type="checkbox" name="ocultar_email" value="1" {{ old('ocultar_email', $colegiado->ocultar_email) ? 'checked' : '' }}>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </label>
                            </div>
                            <div class="visibility-field-item {{ $colegiado->ocultar_telefono ? 'visibility-field-item--hidden' : '' }}">
                                <label class="visibility-field-label">
                                    <div class="visibility-field-label__icon"><i class="fas fa-phone"></i></div>
                                    <div class="visibility-field-label__text">
                                        <strong>Teléfono</strong>
                                        <span>{{ $colegiado->ocultar_telefono ? 'Oculto en perfil público' : 'Visible en perfil público' }}</span>
                                    </div>
                                    <label class="toggle-switch toggle-switch--sm">
                                        <input type="checkbox" name="ocultar_telefono" value="1" {{ old('ocultar_telefono', $colegiado->ocultar_telefono) ? 'checked' : '' }}>
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
                            <div class="visibility-field-item {{ $colegiado->ocultar_grado_academico ? 'visibility-field-item--hidden' : '' }}">
                                <label class="visibility-field-label">
                                    <div class="visibility-field-label__icon"><i class="fas fa-user-graduate"></i></div>
                                    <div class="visibility-field-label__text">
                                        <strong>Grado académico</strong>
                                        <span>{{ $colegiado->ocultar_grado_academico ? 'Oculto en perfil público' : 'Visible en perfil público' }}</span>
                                    </div>
                                    <label class="toggle-switch toggle-switch--sm">
                                        <input type="checkbox" name="ocultar_grado_academico" value="1" {{ old('ocultar_grado_academico', $colegiado->ocultar_grado_academico) ? 'checked' : '' }}>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </label>
                            </div>
                            <div class="visibility-field-item {{ $colegiado->ocultar_especialidad ? 'visibility-field-item--hidden' : '' }}">
                                <label class="visibility-field-label">
                                    <div class="visibility-field-label__icon"><i class="fas fa-flask"></i></div>
                                    <div class="visibility-field-label__text">
                                        <strong>Especialización</strong>
                                        <span>{{ $colegiado->ocultar_especialidad ? 'Oculta en perfil público' : 'Visible en perfil público' }}</span>
                                    </div>
                                    <label class="toggle-switch toggle-switch--sm">
                                        <input type="checkbox" name="ocultar_especialidad" value="1" {{ old('ocultar_especialidad', $colegiado->ocultar_especialidad) ? 'checked' : '' }}>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </label>
                            </div>
                            <div class="visibility-field-item {{ $colegiado->ocultar_especializacion_detalle ? 'visibility-field-item--hidden' : '' }}">
                                <label class="visibility-field-label">
                                    <div class="visibility-field-label__icon"><i class="fas fa-list-ul"></i></div>
                                    <div class="visibility-field-label__text">
                                        <strong>Detalle de especialización</strong>
                                        <span>{{ $colegiado->ocultar_especializacion_detalle ? 'Oculto en perfil público' : 'Visible en perfil público' }}</span>
                                    </div>
                                    <label class="toggle-switch toggle-switch--sm">
                                        <input type="checkbox" name="ocultar_especializacion_detalle" value="1" {{ old('ocultar_especializacion_detalle', $colegiado->ocultar_especializacion_detalle) ? 'checked' : '' }}>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </label>
                            </div>
                            <div class="visibility-field-item {{ $colegiado->ocultar_orientacion ? 'visibility-field-item--hidden' : '' }}">
                                <label class="visibility-field-label">
                                    <div class="visibility-field-label__icon"><i class="fas fa-compass"></i></div>
                                    <div class="visibility-field-label__text">
                                        <strong>Orientación</strong>
                                        <span>{{ $colegiado->ocultar_orientacion ? 'Oculta en perfil público' : 'Visible en perfil público' }}</span>
                                    </div>
                                    <label class="toggle-switch toggle-switch--sm">
                                        <input type="checkbox" name="ocultar_orientacion" value="1" {{ old('ocultar_orientacion', $colegiado->ocultar_orientacion) ? 'checked' : '' }}>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </label>
                            </div>
                            <div class="visibility-field-item {{ $colegiado->ocultar_diplomados ? 'visibility-field-item--hidden' : '' }}">
                                <label class="visibility-field-label">
                                    <div class="visibility-field-label__icon"><i class="fas fa-certificate"></i></div>
                                    <div class="visibility-field-label__text">
                                        <strong>Diplomados</strong>
                                        <span>{{ $colegiado->ocultar_diplomados ? 'Ocultos en perfil público' : 'Visibles en perfil público' }}</span>
                                    </div>
                                    <label class="toggle-switch toggle-switch--sm">
                                        <input type="checkbox" name="ocultar_diplomados" value="1" {{ old('ocultar_diplomados', $colegiado->ocultar_diplomados) ? 'checked' : '' }}>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </label>
                            </div>
                            <div class="visibility-field-item {{ $colegiado->ocultar_experiencia ? 'visibility-field-item--hidden' : '' }}">
                                <label class="visibility-field-label">
                                    <div class="visibility-field-label__icon"><i class="fas fa-briefcase"></i></div>
                                    <div class="visibility-field-label__text">
                                        <strong>Experiencia profesional</strong>
                                        <span>{{ $colegiado->ocultar_experiencia ? 'Oculta en perfil público' : 'Visible en perfil público' }}</span>
                                    </div>
                                    <label class="toggle-switch toggle-switch--sm">
                                        <input type="checkbox" name="ocultar_experiencia" value="1" {{ old('ocultar_experiencia', $colegiado->ocultar_experiencia) ? 'checked' : '' }}>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </label>
                            </div>
                            <div class="visibility-field-item {{ $colegiado->ocultar_universidad ? 'visibility-field-item--hidden' : '' }}">
                                <label class="visibility-field-label">
                                    <div class="visibility-field-label__icon"><i class="fas fa-university"></i></div>
                                    <div class="visibility-field-label__text">
                                        <strong>Universidad</strong>
                                        <span>{{ $colegiado->ocultar_universidad ? 'Oculta en perfil público' : 'Visible en perfil público' }}</span>
                                    </div>
                                    <label class="toggle-switch toggle-switch--sm">
                                        <input type="checkbox" name="ocultar_universidad" value="1" {{ old('ocultar_universidad', $colegiado->ocultar_universidad) ? 'checked' : '' }}>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </label>
                            </div>
                            <div class="visibility-field-item {{ $colegiado->ocultar_anio_graduacion ? 'visibility-field-item--hidden' : '' }}">
                                <label class="visibility-field-label">
                                    <div class="visibility-field-label__icon"><i class="fas fa-calendar-check"></i></div>
                                    <div class="visibility-field-label__text">
                                        <strong>Año de graduación</strong>
                                        <span>{{ $colegiado->ocultar_anio_graduacion ? 'Oculto en perfil público' : 'Visible en perfil público' }}</span>
                                    </div>
                                    <label class="toggle-switch toggle-switch--sm">
                                        <input type="checkbox" name="ocultar_anio_graduacion" value="1" {{ old('ocultar_anio_graduacion', $colegiado->ocultar_anio_graduacion) ? 'checked' : '' }}>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </label>
                            </div>
                            <div class="visibility-field-item {{ $colegiado->ocultar_fecha_colegiatura ? 'visibility-field-item--hidden' : '' }}">
                                <label class="visibility-field-label">
                                    <div class="visibility-field-label__icon"><i class="fas fa-id-card"></i></div>
                                    <div class="visibility-field-label__text">
                                        <strong>Fecha de colegiatura</strong>
                                        <span>{{ $colegiado->ocultar_fecha_colegiatura ? 'Oculta en perfil público' : 'Visible en perfil público' }}</span>
                                    </div>
                                    <label class="toggle-switch toggle-switch--sm">
                                        <input type="checkbox" name="ocultar_fecha_colegiatura" value="1" {{ old('ocultar_fecha_colegiatura', $colegiado->ocultar_fecha_colegiatura) ? 'checked' : '' }}>
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
                            <div class="visibility-field-item {{ $colegiado->ocultar_descripcion ? 'visibility-field-item--hidden' : '' }}">
                                <label class="visibility-field-label">
                                    <div class="visibility-field-label__icon"><i class="fas fa-align-left"></i></div>
                                    <div class="visibility-field-label__text">
                                        <strong>Descripción profesional</strong>
                                        <span>{{ $colegiado->ocultar_descripcion ? 'Oculta en perfil público' : 'Visible en perfil público' }}</span>
                                    </div>
                                    <label class="toggle-switch toggle-switch--sm">
                                        <input type="checkbox" name="ocultar_descripcion" value="1" {{ old('ocultar_descripcion', $colegiado->ocultar_descripcion) ? 'checked' : '' }}>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </label>
                            </div>
                            <div class="visibility-field-item {{ $colegiado->ocultar_cv ? 'visibility-field-item--hidden' : '' }}">
                                <label class="visibility-field-label">
                                    <div class="visibility-field-label__icon"><i class="fas fa-file-pdf"></i></div>
                                    <div class="visibility-field-label__text">
                                        <strong>Curriculum Vitae</strong>
                                        <span>{{ $colegiado->ocultar_cv ? 'Oculto en perfil público' : 'Visible en perfil público' }}</span>
                                    </div>
                                    <label class="toggle-switch toggle-switch--sm">
                                        <input type="checkbox" name="ocultar_cv" value="1" {{ old('ocultar_cv', $colegiado->ocultar_cv) ? 'checked' : '' }}>
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

            {{-- Botones --}}
            <div class="form-footer">
                <a href="{{ route('admin.colegiados.show', $colegiado) }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i>
                    Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    Actualizar Colegiado
                </button>
            </div>
        </form>
    </div>

</div>

@endsection
