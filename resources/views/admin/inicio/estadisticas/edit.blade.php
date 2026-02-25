@extends('layouts.admin')

@section('title', 'Editar Estadísticas')
@section('page-title', 'Estadísticas')

@section('content')

<div style="margin-bottom:24px;">
    <a href="{{ route('admin.inicio.index') }}" class="secondary-btn">
        <i class="fas fa-arrow-left"></i> Volver a Gestión de Inicio
    </a>
</div>

<form action="{{ route('admin.inicio.estadisticas.update') }}" method="POST">
    @csrf
    @method('PUT')

    <div class="admin-form-card">
        <h2 style="font-size:18px;font-weight:700;color:var(--dark);margin:0 0 20px;padding-bottom:12px;border-bottom:2px solid var(--light-gray);">
            <i class="fas fa-chart-line"></i> Editar Estadísticas del Home
        </h2>

        <p style="color:var(--medium-gray);font-size:14px;margin:0 0 24px;">
            Actualiza los números que se muestran en la sección de estadísticas del home público. Los íconos y etiquetas son fijos y no se pueden editar desde aquí.
        </p>

        {{-- Grid 2x2 --}}
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
            
            {{-- Colegiados --}}
            <div class="form-group">
                <label for="stat_colegiados" style="display:flex;align-items:center;gap:8px;font-weight:600;color:var(--dark);margin-bottom:8px;">
                    <div style="width:36px;height:36px;background:rgba(139,21,56,0.1);border-radius:8px;display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-users" style="color:var(--primary);font-size:16px;"></i>
                    </div>
                    Número de Colegiados
                </label>
                <input type="number" id="stat_colegiados" name="stat_colegiados" value="{{ old('stat_colegiados', $config->stat_colegiados) }}" 
                       required min="0" class="form-control" style="font-size:18px;font-weight:700;">
                <small style="color:var(--medium-gray);font-size:12px;display:block;margin-top:6px;">
                    Total de antropólogos colegiados activos
                </small>
                @error('stat_colegiados')
                    <p style="color:var(--danger);font-size:13px;margin:6px 0 0;">{{ $message }}</p>
                @enderror
            </div>

            {{-- Eventos --}}
            <div class="form-group">
                <label for="stat_eventos" style="display:flex;align-items:center;gap:8px;font-weight:600;color:var(--dark);margin-bottom:8px;">
                    <div style="width:36px;height:36px;background:rgba(76,175,80,0.1);border-radius:8px;display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-calendar-check" style="color:#4CAF50;font-size:16px;"></i>
                    </div>
                    Eventos Anuales
                </label>
                <input type="number" id="stat_eventos" name="stat_eventos" value="{{ old('stat_eventos', $config->stat_eventos) }}" 
                       required min="0" class="form-control" style="font-size:18px;font-weight:700;">
                <small style="color:var(--medium-gray);font-size:12px;display:block;margin-top:6px;">
                    Promedio de eventos realizados por año
                </small>
                @error('stat_eventos')
                    <p style="color:var(--danger);font-size:13px;margin:6px 0 0;">{{ $message }}</p>
                @enderror
            </div>

            {{-- Años de Servicio --}}
            <div class="form-group">
                <label for="stat_años" style="display:flex;align-items:center;gap:8px;font-weight:600;color:var(--dark);margin-bottom:8px;">
                    <div style="width:36px;height:36px;background:rgba(255,152,0,0.1);border-radius:8px;display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-award" style="color:#FF9800;font-size:16px;"></i>
                    </div>
                    Años de Servicio
                </label>
                <input type="number" id="stat_años" name="stat_años" value="{{ old('stat_años', $config->stat_años) }}" 
                       required min="0" class="form-control" style="font-size:18px;font-weight:700;">
                <small style="color:var(--medium-gray);font-size:12px;display:block;margin-top:6px;">
                    Años desde la fundación del CPAP Región Centro
                </small>
                @error('stat_años')
                    <p style="color:var(--danger);font-size:13px;margin:6px 0 0;">{{ $message }}</p>
                @enderror
            </div>

            {{-- Publicaciones --}}
            <div class="form-group">
                <label for="stat_publicaciones" style="display:flex;align-items:center;gap:8px;font-weight:600;color:var(--dark);margin-bottom:8px;">
                    <div style="width:36px;height:36px;background:rgba(33,150,243,0.1);border-radius:8px;display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-book" style="color:#2196F3;font-size:16px;"></i>
                    </div>
                    Publicaciones
                </label>
                <input type="number" id="stat_publicaciones" name="stat_publicaciones" value="{{ old('stat_publicaciones', $config->stat_publicaciones) }}" 
                       required min="0" class="form-control" style="font-size:18px;font-weight:700;">
                <small style="color:var(--medium-gray);font-size:12px;display:block;margin-top:6px;">
                    Total de publicaciones, investigaciones y recursos
                </small>
                @error('stat_publicaciones')
                    <p style="color:var(--danger);font-size:13px;margin:6px 0 0;">{{ $message }}</p>
                @enderror
            </div>

        </div>

        {{-- Botones --}}
        <div style="display:flex;gap:12px;justify-content:flex-end;margin-top:32px;padding-top:24px;border-top:1px solid var(--light-gray);">
            <a href="{{ route('admin.inicio.index') }}" class="secondary-btn">
                <i class="fas fa-times"></i> Cancelar
            </a>
            <button type="submit" class="primary-btn">
                <i class="fas fa-save"></i> Guardar Estadísticas
            </button>
        </div>
    </div>
</form>

<div style="background:var(--info-light);border-left:4px solid var(--info);padding:16px 20px;border-radius:var(--radius-sm);margin-top:24px;">
    <div style="display:flex;align-items:flex-start;gap:12px;">
        <i class="fas fa-info-circle" style="color:var(--info);font-size:18px;margin-top:2px;"></i>
        <div style="color:var(--info);font-size:14px;">
            <strong style="display:block;margin-bottom:6px;">Animación Automática</strong>
            <p style="margin:0;">Los números se animan automáticamente desde 0 hasta el valor configurado cuando el usuario visualiza la sección en el home público. Esta animación mejora el impacto visual de las estadísticas.</p>
        </div>
    </div>
</div>

@endsection
