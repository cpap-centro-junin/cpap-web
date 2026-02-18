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
                <img src="{{ asset($colegiado->foto) }}" alt="{{ $colegiado->nombre_completo }}">
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

            {{-- Identificación --}}
            <div class="form-section">
                <h3 class="section-title">Identificación</h3>
                <div class="form-row">
                    <div class="form-group">
                        <label for="codigo_cpap">Código CPAP <span class="required">*</span></label>
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

            {{-- Información Personal --}}
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
                                <img src="{{ asset($colegiado->foto) }}" alt="Foto actual">
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

            {{-- Información Profesional --}}
            <div class="form-section">
                <h3 class="section-title">Información Profesional</h3>
                <div class="form-row">
                    <div class="form-group">
                        <label for="especialidad">Especialidad</label>
                        <input type="text" class="form-control @error('especialidad') is-invalid @enderror"
                               id="especialidad" name="especialidad" value="{{ old('especialidad', $colegiado->especialidad) }}"
                               placeholder="Antropología Social">
                        @error('especialidad')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="universidad">Universidad</label>
                        <input type="text" class="form-control @error('universidad') is-invalid @enderror"
                               id="universidad" name="universidad" value="{{ old('universidad', $colegiado->universidad) }}"
                               placeholder="Universidad Nacional Mayor de San Marcos">
                        @error('universidad')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="anio_graduacion">Año de Graduación</label>
                        <input type="number" class="form-control @error('anio_graduacion') is-invalid @enderror"
                               id="anio_graduacion" name="anio_graduacion" value="{{ old('anio_graduacion', $colegiado->anio_graduacion) }}"
                               min="1950" max="{{ date('Y') }}" placeholder="{{ date('Y') }}">
                        @error('anio_graduacion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="cv">Curriculum Vitae (PDF)</label>
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

            {{-- Estado y Colegiatura --}}
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
