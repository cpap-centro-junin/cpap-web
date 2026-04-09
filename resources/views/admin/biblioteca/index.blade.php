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
<x-admin-filters
    :searchPlaceholder="'Buscar por título, autor, editorial...'"
    :searchField="'q'"
    :route="route('admin.biblioteca.index')"
    :clearRoute="route('admin.biblioteca.index')"
    :filters="[
        [
            'field' => 'tipo',
            'label' => 'Tipo',
            'options' => [
                'libro' => 'Libros',
                'articulo' => 'Artículos',
                'tesis' => 'Tesis',
                'documento' => 'Documentos',
                'revista' => 'Revistas',
                'multimedia' => 'Multimedia',
            ]
        ],
        [
            'field' => 'formato',
            'label' => 'Formato',
            'options' => [
                'fisico' => 'Físico',
                'digital' => 'Digital',
            ]
        ],
        [
            'field' => 'estado',
            'label' => 'Estado',
            'options' => [
                'publicado' => 'Publicados',
                'oculto' => 'Ocultos',
            ]
        ],
    ]"
/>

<div class="admin-table" data-table-name="biblioteca">
    <div class="admin-table-wrapper">
        <table>
            <thead>
                <tr>
                    <x-admin-row-number-cell :items="$recursos" loopIteration="header" />
                    <th style="width:50px;">Portada</th>
                    <th>Título / Autor</th>
                <th>Tipo</th>
                <th>Formato</th>
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
                <x-admin-row-number-cell :items="$recursos" :loopIteration="$loop->iteration" :itemId="$recurso->id" />
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
                    <div style="font-weight:600;color:var(--dark);font-size:14px;margin-bottom:3px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;max-width:300px;">
                        {{ $recurso->titulo }}
                    </div>
                    <div style="color:var(--medium-gray);font-size:12px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;max-width:300px;">
                        <i class="fas fa-user" style="margin-right:3px;"></i>{{ $recurso->autor }}
                    </div>
                </td>

                {{-- Tipo --}}
                <td>
                    <span class="badge" style="background:rgba(139,21,56,0.1);color:var(--primary);font-size:12px;">
                        <i class="fas {{ $recurso->tipo_icon }}" style="margin-right:4px;"></i>{{ $recurso->tipo_label }}
                    </span>
                </td>

                {{-- Formato --}}
                <td>
                    @if($recurso->formato === 'fisico')
                        <span class="badge" style="background:rgba(201,169,97,0.15);color:#96792e;font-size:12px;">
                            <i class="fas fa-book" style="margin-right:4px;"></i>Físico
                        </span>
                    @else
                        <span class="badge" style="background:rgba(46,125,50,0.12);color:#2e7d32;font-size:12px;">
                            <i class="fas fa-laptop" style="margin-right:4px;"></i>Virtual
                        </span>
                    @endif
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
                <td colspan="10">
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
</div>

<x-admin-bulk-actions-bar :tableName="'biblioteca'" />

{{-- PAGINACIÓN --}}
{{ $recursos->links('pagination.admin') }}

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
