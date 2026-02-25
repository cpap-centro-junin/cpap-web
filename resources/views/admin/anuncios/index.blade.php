@extends('layouts.admin')

@section('title', 'Anuncios Emergentes')
@section('page-title', 'Anuncios Emergentes')

@section('content')

<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;flex-wrap:wrap;gap:12px;">
    <div>
        <h1 style="font-size:22px;font-weight:700;color:var(--dark);margin:0 0 4px;">Anuncios Emergentes</h1>
        <p style="color:var(--medium-gray);font-size:14px;margin:0;">{{ $anuncios->count() }} anuncio{{ $anuncios->count() !== 1 ? 's' : '' }} registrado{{ $anuncios->count() !== 1 ? 's' : '' }}</p>
    </div>
    <a href="{{ route('admin.anuncios.create') }}" class="primary-btn">
        <i class="fas fa-plus"></i> Nuevo Anuncio
    </a>
</div>

@if(session('success'))
<div style="background:var(--success-light);color:var(--success);border:1px solid rgba(46,125,50,0.2);border-radius:var(--radius-sm);padding:14px 18px;margin-bottom:20px;display:flex;align-items:center;gap:10px;font-size:14px;font-weight:500;">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
</div>
@endif

<div style="background:var(--info-light);color:var(--info);border-radius:var(--radius-sm);padding:14px 18px;margin-bottom:20px;font-size:13px;display:flex;align-items:flex-start;gap:10px;">
    <i class="fas fa-info-circle" style="margin-top:2px;flex-shrink:0;"></i>
    <span>Solo <strong>un anuncio activo</strong> a la vez se muestra en el popup de la página de inicio. Al activar uno, los demás se desactivan automáticamente.</span>
</div>

<div class="admin-table">
    <table>
        <thead>
            <tr>
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
                        <form action="{{ route('admin.anuncios.toggle', $anuncio) }}" method="POST" style="display:inline;">
                            @csrf @method('PATCH')
                            <button type="submit" title="{{ $anuncio->activo ? 'Desactivar' : 'Activar' }}"
                                    style="display:inline-flex;align-items:center;padding:6px 10px;background:{{ $anuncio->activo ? 'var(--danger-light)' : 'var(--success-light)' }};color:{{ $anuncio->activo ? 'var(--danger)' : 'var(--success)' }};border-radius:var(--radius-sm);font-size:12px;border:none;cursor:pointer;font-weight:600;gap:4px;">
                                <i class="fas {{ $anuncio->activo ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                                {{ $anuncio->activo ? 'Desactivar' : 'Activar' }}
                            </button>
                        </form>
                        <a href="{{ route('admin.anuncios.edit', $anuncio) }}"
                           style="display:inline-flex;align-items:center;gap:4px;padding:6px 10px;background:var(--warning-light);color:var(--warning);border-radius:var(--radius-sm);font-size:12px;font-weight:600;text-decoration:none;">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <form action="{{ route('admin.anuncios.destroy', $anuncio) }}" method="POST" style="display:inline;" class="delete-form" id="form-delete-anuncio-{{ $anuncio->id }}">
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
                        <a href="{{ route('admin.anuncios.create') }}" class="primary-btn" style="display:inline-flex;">
                            <i class="fas fa-plus"></i> Nuevo Anuncio
                        </a>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection

@push('scripts')
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
