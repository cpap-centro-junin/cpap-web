@php use Illuminate\Support\Str; @endphp

@extends('layouts.admin')

@section('title', 'Eventos')
@section('page-title', 'Gestión de Eventos')

@section('content')

{{-- HEADER --}}
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;flex-wrap:wrap;gap:12px;">
    <div>
        <h1 style="font-size:22px;font-weight:700;color:var(--dark);margin:0 0 4px;">Eventos</h1>
        <p style="color:var(--medium-gray);font-size:14px;margin:0;">{{ $eventos->total() }} evento{{ $eventos->total() !== 1 ? 's' : '' }} en total</p>
    </div>
    <a href="{{ route('admin.eventos.create') }}" class="primary-btn">
        <i class="fas fa-plus"></i> Nuevo Evento
    </a>
</div>

{{-- FLASH --}}
@if(session('success'))
<div style="background:var(--success-light);color:var(--success);border:1px solid rgba(46,125,50,0.2);border-radius:var(--radius-sm);padding:14px 18px;margin-bottom:20px;display:flex;align-items:center;gap:10px;font-size:14px;font-weight:500;">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
</div>
@endif

{{-- TABLA --}}
<div class="admin-table">
    <table>
        <thead>
            <tr>
                <th style="width:60px;">Portada</th>
                <th>Título</th>
                <th>Categoría</th>
                <th>Fecha</th>
                <th>Estado</th>
                <th style="text-align:center;width:160px;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($eventos as $evento)
            <tr>
                <td>
                    @if($evento->imagen_portada)
                        <img src="{{ $evento->imagen_portada }}" alt=""
                             style="width:52px;height:40px;object-fit:cover;border-radius:6px;display:block;">
                    @else
                        <div style="width:52px;height:40px;background:var(--light-gray);border-radius:6px;display:flex;align-items:center;justify-content:center;">
                            <i class="fas fa-calendar-alt" style="color:var(--border);font-size:14px;"></i>
                        </div>
                    @endif
                </td>
                <td>
                    <div style="font-weight:600;color:var(--dark);font-size:14px;margin-bottom:3px;">
                        {{ Str::limit($evento->titulo, 60) }}
                    </div>
                    @if($evento->lugar)
                    <div style="color:var(--medium-gray);font-size:12px;display:flex;align-items:center;gap:4px;">
                        <i class="fas fa-map-marker-alt" style="color:var(--primary);font-size:10px;"></i>
                        {{ Str::limit($evento->lugar, 50) }}
                    </div>
                    @endif
                    @if($evento->destacado)
                    <span style="display:inline-flex;align-items:center;gap:3px;margin-top:4px;background:rgba(212,175,55,0.12);color:#b8960c;padding:2px 8px;border-radius:50px;font-size:11px;font-weight:600;">
                        <i class="fas fa-star" style="font-size:9px;"></i> Destacado
                    </span>
                    @endif
                </td>
                <td>
                    <span style="background:rgba(139,21,56,0.08);color:var(--primary);padding:4px 10px;border-radius:50px;font-size:12px;font-weight:600;">
                        {{ $evento->categoria }}
                    </span>
                </td>
                <td>
                    <div style="font-size:13px;font-weight:600;color:var(--dark);">{{ $evento->fecha_inicio->format('d/m/Y') }}</div>
                    @if($evento->hora_inicio)
                    <div style="font-size:12px;color:var(--medium-gray);">
                        <i class="fas fa-clock" style="color:var(--primary);font-size:10px;"></i>
                        {{ \Carbon\Carbon::parse($evento->hora_inicio)->format('H:i') }} hrs
                    </div>
                    @endif
                    <span style="font-size:11px;padding:2px 8px;border-radius:50px;font-weight:600;{{ $evento->es_proximo ? 'background:var(--success-light);color:var(--success);' : 'background:var(--light-gray);color:var(--medium-gray);' }}">
                        {{ $evento->es_proximo ? 'Próximo' : 'Realizado' }}
                    </span>
                </td>
                <td>
                    <span class="badge {{ $evento->activo ? 'published' : 'hidden' }}">
                        <i class="fas fa-circle" style="font-size:7px;"></i>
                        {{ $evento->activo ? 'Publicado' : 'Oculto' }}
                    </span>
                </td>
                <td>
                    <div style="display:flex;gap:6px;justify-content:center;">
                        <a href="{{ route('eventos.show', $evento) }}" target="_blank"
                           style="display:inline-flex;align-items:center;padding:6px 10px;background:var(--info-light);color:var(--info);border-radius:var(--radius-sm);font-size:12px;text-decoration:none;"
                           title="Ver en sitio">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.eventos.edit', $evento) }}"
                           style="display:inline-flex;align-items:center;gap:4px;padding:6px 10px;background:var(--warning-light);color:var(--warning);border-radius:var(--radius-sm);font-size:12px;font-weight:600;text-decoration:none;">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <form action="{{ route('admin.eventos.destroy', $evento) }}" method="POST" style="display:inline;" class="delete-form" id="form-delete-evento-{{ $evento->id }}">
                            @csrf @method('DELETE')
                            <button type="button"
                                    onclick="confirmDelete('{{ addslashes($evento->titulo) }}', 'form-delete-evento-{{ $evento->id }}')"
                                    style="display:inline-flex;align-items:center;padding:6px 10px;background:var(--danger-light);color:var(--danger);border-radius:var(--radius-sm);font-size:12px;border:none;cursor:pointer;">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6">
                    <div class="empty-state">
                        <i class="fas fa-calendar-times"></i>
                        <p>No hay eventos registrados.<br>Crea tu primer evento para comenzar.</p>
                        <a href="{{ route('admin.eventos.create') }}" class="primary-btn" style="display:inline-flex;">
                            <i class="fas fa-plus"></i> Crear Evento
                        </a>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($eventos->hasPages())
<div style="margin-top:20px;display:flex;justify-content:center;">
    {{ $eventos->links() }}
</div>
@endif

@endsection

@push('scripts')
<script>
function confirmDelete(titulo, formId) {
    Swal.fire({
        title: '¿Eliminar este evento?',
        html: `Se eliminará permanentemente <strong>"${titulo}"</strong>. Esta acción no se puede deshacer.`,
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
