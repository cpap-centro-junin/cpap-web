@php use Illuminate\Support\Str; @endphp

@extends('layouts.admin')

@section('title', 'Noticias')
@section('page-title', 'Gestión de Noticias')

@section('content')

{{-- HEADER --}}
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;flex-wrap:wrap;gap:12px;">
    <div>
        <h1 style="font-size:22px;font-weight:700;color:var(--dark);margin:0 0 4px;">Noticias</h1>
        <p style="color:var(--medium-gray);font-size:14px;margin:0;">{{ $noticias->total() }} noticia{{ $noticias->total() !== 1 ? 's' : '' }} en total</p>
    </div>
    <a href="{{ route('admin.noticias.create') }}" class="primary-btn">
        <i class="fas fa-plus"></i> Nueva Noticia
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
                <th>Autor</th>
                <th>Estado</th>
                <th>Publicado</th>
                <th style="text-align:center;width:160px;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($noticias as $noticia)
            <tr>
                <td>
                    @if($noticia->imagen)
                        <img src="{{ $noticia->imagen }}" alt=""
                             style="width:52px;height:40px;object-fit:cover;border-radius:6px;display:block;">
                    @else
                        <div style="width:52px;height:40px;background:var(--light-gray);border-radius:6px;display:flex;align-items:center;justify-content:center;">
                            <i class="fas fa-newspaper" style="color:var(--border);font-size:14px;"></i>
                        </div>
                    @endif
                </td>
                <td>
                    <div style="font-weight:600;color:var(--dark);font-size:14px;margin-bottom:3px;">
                        {{ Str::limit($noticia->titulo, 60) }}
                    </div>
                    @if($noticia->resumen)
                    <div style="color:var(--medium-gray);font-size:12px;">{{ Str::limit($noticia->resumen, 80) }}</div>
                    @endif
                    @if($noticia->destacado)
                    <span style="display:inline-flex;align-items:center;gap:3px;margin-top:4px;background:rgba(212,175,55,0.12);color:#b8960c;padding:2px 8px;border-radius:50px;font-size:11px;font-weight:600;">
                        <i class="fas fa-star" style="font-size:9px;"></i> Destacado
                    </span>
                    @endif
                </td>
                <td>
                    <span style="background:rgba(139,21,56,0.08);color:var(--primary);padding:4px 10px;border-radius:50px;font-size:12px;font-weight:600;">
                        {{ $noticia->categoria }}
                    </span>
                </td>
                <td style="color:var(--medium-gray);font-size:13px;">{{ $noticia->autor }}</td>
                <td>
                    <span class="badge {{ $noticia->activo ? 'published' : 'hidden' }}">
                        <i class="fas fa-circle" style="font-size:7px;"></i>
                        {{ $noticia->activo ? 'Publicado' : 'Oculto' }}
                    </span>
                </td>
                <td style="color:var(--medium-gray);font-size:13px;">{{ $noticia->created_at->format('d/m/Y') }}</td>
                <td>
                    <div style="display:flex;gap:6px;justify-content:center;">
                        <a href="{{ route('noticias.show', $noticia) }}" target="_blank"
                           style="display:inline-flex;align-items:center;padding:6px 10px;background:var(--info-light);color:var(--info);border-radius:var(--radius-sm);font-size:12px;text-decoration:none;"
                           title="Ver en sitio">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.noticias.edit', $noticia) }}"
                           style="display:inline-flex;align-items:center;gap:4px;padding:6px 10px;background:var(--warning-light);color:var(--warning);border-radius:var(--radius-sm);font-size:12px;font-weight:600;text-decoration:none;">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <form action="{{ route('admin.noticias.destroy', $noticia) }}" method="POST" style="display:inline;" class="delete-form" id="form-delete-noticia-{{ $noticia->id }}">
                            @csrf @method('DELETE')
                            <button type="button"
                                    onclick="confirmDelete('{{ addslashes($noticia->titulo) }}', 'form-delete-noticia-{{ $noticia->id }}')"
                                    style="display:inline-flex;align-items:center;padding:6px 10px;background:var(--danger-light);color:var(--danger);border-radius:var(--radius-sm);font-size:12px;border:none;cursor:pointer;">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7">
                    <div class="empty-state">
                        <i class="fas fa-newspaper"></i>
                        <p>No hay noticias registradas.<br>Crea tu primera noticia para comenzar.</p>
                        <a href="{{ route('admin.noticias.create') }}" class="primary-btn" style="display:inline-flex;">
                            <i class="fas fa-plus"></i> Crear Noticia
                        </a>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($noticias->hasPages())
<div style="margin-top:20px;display:flex;justify-content:center;">
    {{ $noticias->links() }}
</div>
@endif

@endsection

@push('scripts')
<script>
function confirmDelete(titulo, formId) {
    Swal.fire({
        title: '¿Eliminar esta noticia?',
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
