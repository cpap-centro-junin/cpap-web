@extends('layouts.admin')

@section('title', 'Anuncios Emergentes')
@section('page-title', 'Anuncios Emergentes')

@section('content')

<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;flex-wrap:wrap;gap:12px;">
    <div>
        <h1 style="font-size:22px;font-weight:700;color:var(--dark);margin:0 0 4px;">Anuncios Emergentes</h1>
        <p style="color:var(--medium-gray);font-size:14px;margin:0;">{{ $anuncios->count() }} anuncio{{ $anuncios->count() !== 1 ? 's' : '' }} registrado{{ $anuncios->count() !== 1 ? 's' : '' }}</p>
    </div>
    <div style="display:flex;gap:10px;flex-wrap:wrap;">
        <a href="{{ route('admin.inicio.index') }}" class="secondary-btn">
                <i class="fas fa-arrow-left"></i> Volver a Gestión de Inicio
        </a>
        <a href="{{ route('admin.inicio.anuncios.create') }}" class="primary-btn">
            <i class="fas fa-plus"></i> Nuevo Anuncio
        </a>
    </div>
</div>

@if(session('success'))
<div style="background:var(--success-light);color:var(--success);border:1px solid rgba(46,125,50,0.2);border-radius:var(--radius-sm);padding:14px 18px;margin-bottom:20px;display:flex;align-items:center;gap:10px;font-size:14px;font-weight:500;">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
</div>
@endif

{{-- FILTROS --}}
<x-admin-filters
    :searchPlaceholder="'Buscar por título...'"
    :searchField="'q'"
    :route="route('admin.inicio.anuncios.index')"
    :clearRoute="route('admin.inicio.anuncios.index')"
    :filters="[
        [
            'field' => 'estado',
            'label' => 'Estado',
            'options' => [
                'activo' => 'Activos',
                'inactivo' => 'Inactivos',
            ]
        ],
    ]"
/>

<div style="background:var(--info-light);color:var(--info);border-radius:var(--radius-sm);padding:14px 18px;margin-bottom:20px;font-size:13px;display:flex;align-items:flex-start;gap:10px;">
    <i class="fas fa-info-circle" style="margin-top:2px;flex-shrink:0;"></i>
    <span>Puedes tener <strong>varios anuncios activos</strong> al mismo tiempo. Todos los activos se mostrarán en el popup de la página de inicio con navegación de flechas.</span>
</div>

<div class="admin-table" data-table-name="anuncios">
    <div class="admin-table-wrapper">
        <table>
            <thead>
                <tr>
                    <x-admin-row-number-cell :items="$anuncios" loopIteration="header" />
                    <th style="width:120px;">Vista Previa</th>
                    <th>Título (interno)</th>
                    <th style="text-align:center;">Estado</th>
                <th>Creado</th>
                <th style="text-align:center;width:160px;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($anuncios as $anuncio)
            <tr>
                <x-admin-row-number-cell :items="$anuncios" :loopIteration="$loop->iteration" :itemId="$anuncio->id" />
                <td>
                    <img src="{{ $anuncio->imagen }}" alt="{{ $anuncio->titulo }}"
                         style="width:100px;height:70px;object-fit:cover;border-radius:6px;display:block;">
                </td>
                <td style="font-weight:600;color:var(--dark);font-size:14px;">{{ $anuncio->titulo }}</td>
                <td style="text-align:center;">
                    <span class="badge {{ $anuncio->activo ? 'published' : 'hidden' }}">
                        <i class="fas fa-circle" style="font-size:7px;"></i>
                        {{ $anuncio->activo ? 'Activo' : 'Inactivo' }}
                    </span>
                </td>
                <td style="color:var(--medium-gray);font-size:13px;">{{ $anuncio->created_at->format('d/m/Y') }}</td>
                <td>
                    <div style="display:flex;gap:6px;justify-content:center;">
                        <form action="{{ route('admin.inicio.anuncios.toggle', $anuncio) }}" method="POST" style="display:inline;">
                            @csrf @method('PATCH')
                            <button type="submit" title="{{ $anuncio->activo ? 'Desactivar' : 'Activar' }}"
                                    style="display:inline-flex;align-items:center;padding:6px 10px;background:{{ $anuncio->activo ? 'var(--danger-light)' : 'var(--success-light)' }};color:{{ $anuncio->activo ? 'var(--danger)' : 'var(--success)' }};border-radius:var(--radius-sm);font-size:12px;border:none;cursor:pointer;font-weight:600;gap:4px;">
                                <i class="fas {{ $anuncio->activo ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                                {{ $anuncio->activo ? 'Desactivar' : 'Activar' }}
                            </button>
                        </form>
                        <a href="{{ route('admin.inicio.anuncios.edit', $anuncio) }}"
                           style="display:inline-flex;align-items:center;gap:4px;padding:6px 10px;background:var(--warning-light);color:var(--warning);border-radius:var(--radius-sm);font-size:12px;font-weight:600;text-decoration:none;">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <form action="{{ route('admin.inicio.anuncios.destroy', $anuncio) }}" method="POST" style="display:inline;" class="delete-form" id="form-delete-anuncio-{{ $anuncio->id }}">
                            @csrf @method('DELETE')
                            <button type="button"
                                    onclick="confirmDelete('Anuncio #{{ $anuncio->id }}', 'form-delete-anuncio-{{ $anuncio->id }}')"
                                    style="display:inline-flex;align-items:center;padding:6px 10px;background:var(--danger-light);color:var(--danger);border-radius:var(--radius-sm);font-size:12px;border:none;cursor:pointer;">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5">
                    <div class="empty-state">
                        <i class="fas fa-bullhorn"></i>
                        <p>No hay anuncios creados.<br>Crea uno para que aparezca como popup en la página de inicio.</p>
                        <a href="{{ route('admin.inicio.anuncios.create') }}" class="primary-btn" style="display:inline-flex;">
                            <i class="fas fa-plus"></i> Nuevo Anuncio
                        </a>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    </div>
</div>

<x-admin-bulk-actions-bar :tableName="'anuncios'" />

{{-- Paginación --}}
{{ $anuncios->links('pagination.admin') }}

@endsection

@push('scripts')
<script src="{{ asset('js/admin-bulk-actions.js') }}"></script>
<script>
function confirmDelete(titulo, formId) {
    Swal.fire({
        title: '¿Eliminar anuncio popup?',
        html: `Se eliminará permanentemente <strong>"${titulo}"</strong> junto con su imagen. Esta acción no se puede deshacer.`,
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
