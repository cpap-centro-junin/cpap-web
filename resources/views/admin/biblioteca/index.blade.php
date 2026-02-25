@php use Illuminate\Support\Str; @endphp

@extends('layouts.admin')

@section('title', 'Biblioteca Virtual')
@section('page-title', 'Biblioteca Virtual')

@section('content')

{{-- HEADER --}}
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;flex-wrap:wrap;gap:12px;">
    <div>
        <h1 style="font-size:22px;font-weight:700;color:var(--dark);margin:0 0 4px;">Biblioteca Virtual</h1>
        <p style="color:var(--medium-gray);font-size:14px;margin:0;">{{ $recursos->total() }} recurso{{ $recursos->total() !== 1 ? 's' : '' }} en total</p>
    </div>
    <a href="{{ route('admin.biblioteca.create') }}" class="primary-btn">
        <i class="fas fa-plus"></i> Nuevo Recurso
    </a>
</div>

{{-- FLASH --}}
@if(session('success'))
<div style="background:var(--success-light);color:var(--success);border:1px solid rgba(46,125,50,0.2);border-radius:var(--radius-sm);padding:14px 18px;margin-bottom:20px;display:flex;align-items:center;gap:10px;font-size:14px;font-weight:500;">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
</div>
@endif

{{-- FILTROS --}}
<div class="admin-card" style="margin-bottom:20px;padding:16px 20px;">
    <form method="GET" action="{{ route('admin.biblioteca.index') }}" style="display:flex;gap:12px;flex-wrap:wrap;align-items:center;">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Buscar por título, autor, editorial..."
               class="admin-input" style="flex:1;min-width:200px;">
        <select name="tipo" class="admin-input" style="width:180px;">
            <option value="">Todos los tipos</option>
            <option value="libro" {{ request('tipo')=='libro'?'selected':'' }}>Libros</option>
            <option value="articulo" {{ request('tipo')=='articulo'?'selected':'' }}>Artículos</option>
            <option value="tesis" {{ request('tipo')=='tesis'?'selected':'' }}>Tesis</option>
            <option value="documento" {{ request('tipo')=='documento'?'selected':'' }}>Documentos CPAP</option>
            <option value="revista" {{ request('tipo')=='revista'?'selected':'' }}>Revistas</option>
            <option value="multimedia" {{ request('tipo')=='multimedia'?'selected':'' }}>Multimedia</option>
        </select>
        <select name="area" class="admin-input" style="width:200px;">
            <option value="">Todas las áreas</option>
            <option value="cultural" {{ request('area')=='cultural'?'selected':'' }}>Antropología Cultural</option>
            <option value="social" {{ request('area')=='social'?'selected':'' }}>Antropología Social</option>
            <option value="arqueologia" {{ request('area')=='arqueologia'?'selected':'' }}>Arqueología</option>
            <option value="linguistica" {{ request('area')=='linguistica'?'selected':'' }}>Lingüística</option>
            <option value="biologica" {{ request('area')=='biologica'?'selected':'' }}>Antropología Biológica</option>
        </select>
        <button type="submit" class="primary-btn" style="padding:10px 18px;">
            <i class="fas fa-search"></i> Filtrar
        </button>
        @if(request()->hasAny(['q','tipo','area']))
            <a href="{{ route('admin.biblioteca.index') }}" style="color:var(--medium-gray);font-size:13px;text-decoration:none;">
                <i class="fas fa-times"></i> Limpiar
            </a>
        @endif
    </form>
</div>

{{-- TABLA --}}
<div class="admin-table">
    <table>
        <thead>
            <tr>
                <th style="width:50px;">Portada</th>
                <th>Título / Autor</th>
                <th>Tipo</th>
                <th>Área</th>
                <th>Año</th>
                <th>Licencia</th>
                <th>Estado</th>
                <th style="text-align:center;width:160px;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recursos as $recurso)
            <tr>
                {{-- Portada --}}
                <td>
                    @if($recurso->imagen_portada)
                        <img src="{{ asset('storage/' . $recurso->imagen_portada) }}" alt=""
                             style="width:44px;height:60px;object-fit:cover;border-radius:6px;border:1px solid var(--border);">
                    @else
                        <div style="width:44px;height:60px;background:var(--light-gray);border-radius:6px;display:flex;align-items:center;justify-content:center;color:var(--medium-gray);font-size:18px;">
                            <i class="fas {{ $recurso->tipo_icon }}"></i>
                        </div>
                    @endif
                </td>

                {{-- Título / Autor --}}
                <td>
                    <div style="font-weight:600;color:var(--dark);font-size:14px;margin-bottom:3px;">
                        {{ Str::limit($recurso->titulo, 50) }}
                    </div>
                    <div style="color:var(--medium-gray);font-size:12px;">
                        <i class="fas fa-user" style="margin-right:3px;"></i>{{ Str::limit($recurso->autor, 40) }}
                    </div>
                </td>

                {{-- Tipo --}}
                <td>
                    <span class="badge" style="background:rgba(139,21,56,0.1);color:var(--primary);font-size:12px;">
                        <i class="fas {{ $recurso->tipo_icon }}" style="margin-right:4px;"></i>{{ $recurso->tipo_label }}
                    </span>
                </td>

                {{-- Área --}}
                <td>
                    <span style="color:var(--dark);font-size:13px;">{{ $recurso->area_label }}</span>
                </td>

                {{-- Año --}}
                <td>
                    <span style="color:var(--medium-gray);font-size:13px;">{{ $recurso->anio_publicacion ?? '—' }}</span>
                </td>

                {{-- Licencia --}}
                <td>
                    <span class="badge" style="background:rgba(201,169,97,0.15);color:#96792e;font-size:11px;">
                        {{ $recurso->licencia_badge }}
                    </span>
                    @if($recurso->solo_colegiados)
                        <span class="badge" style="background:rgba(139,21,56,0.1);color:var(--primary);font-size:10px;margin-left:2px;" title="Solo colegiados">
                            <i class="fas fa-lock"></i>
                        </span>
                    @endif
                </td>

                {{-- Estado --}}
                <td>
                    @if($recurso->activo)
                        <span class="badge published">Publicado</span>
                    @else
                        <span class="badge hidden">Oculto</span>
                    @endif
                    @if($recurso->destacado)
                        <span class="badge" style="background:rgba(212,175,55,0.15);color:#b8941d;font-size:10px;" title="Destacado">
                            <i class="fas fa-star"></i>
                        </span>
                    @endif
                </td>

                {{-- Acciones --}}
                <td style="text-align:center;">
                    <div style="display:flex;gap:6px;justify-content:center;">
                        <a href="{{ route('admin.biblioteca.edit', $recurso) }}"
                           style="width:34px;height:34px;border-radius:8px;background:var(--light-gray);border:1px solid var(--border);display:inline-flex;align-items:center;justify-content:center;color:var(--dark);text-decoration:none;transition:all .2s;"
                           title="Editar">
                            <i class="fas fa-edit" style="font-size:13px;"></i>
                        </a>
                        @if($recurso->archivo_pdf)
                        <a href="{{ asset('storage/' . $recurso->archivo_pdf) }}" target="_blank"
                           style="width:34px;height:34px;border-radius:8px;background:rgba(139,21,56,0.08);border:1px solid rgba(139,21,56,0.15);display:inline-flex;align-items:center;justify-content:center;color:var(--primary);text-decoration:none;transition:all .2s;"
                           title="Ver PDF">
                            <i class="fas fa-file-pdf" style="font-size:13px;"></i>
                        </a>
                        @endif
                        <form action="{{ route('admin.biblioteca.destroy', $recurso) }}" method="POST" class="delete-form" id="form-delete-biblioteca-{{ $recurso->id }}">
                            @csrf @method('DELETE')
                            <button type="button"
                                    onclick="confirmDelete('{{ addslashes($recurso->titulo) }}', 'form-delete-biblioteca-{{ $recurso->id }}')"
                                    style="width:34px;height:34px;border-radius:8px;background:var(--danger-light);border:1px solid rgba(198,40,40,0.15);display:inline-flex;align-items:center;justify-content:center;color:var(--danger);cursor:pointer;transition:all .2s;"
                                    title="Eliminar">
                                <i class="fas fa-trash" style="font-size:13px;"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8">
                    <div class="empty-state">
                        <i class="fas fa-book"></i>
                        <h3>No hay recursos</h3>
                        <p>Agrega el primer recurso a la biblioteca virtual.</p>
                        <a href="{{ route('admin.biblioteca.create') }}" class="primary-btn">
                            <i class="fas fa-plus"></i> Nuevo Recurso
                        </a>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- PAGINACIÓN --}}
@if($recursos->hasPages())
<div style="display:flex;justify-content:center;margin-top:24px;">
    {{ $recursos->links() }}
</div>
@endif

@endsection

@push('scripts')
<script>
function confirmDelete(titulo, formId) {
    Swal.fire({
        title: '¿Eliminar recurso de biblioteca?',
        html: `Se eliminará permanentemente <strong>"${titulo}"</strong> junto con sus archivos adjuntos. Esta acción no se puede deshacer.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d32f2f',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="fas fa-trash"></i> Sí, eliminar',
        cancelButtonText: 'Cancelar',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(formId).submit();
        }
    });
}
</script>
@endpush
