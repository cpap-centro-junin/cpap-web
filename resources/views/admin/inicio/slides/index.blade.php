@extends('layouts.admin')

@section('title', 'Banner Slides')
@section('page-title', 'Banner Slides')

@section('content')

<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;flex-wrap:wrap;gap:12px;">
    <div>
        <h1 style="font-size:22px;font-weight:700;color:var(--dark);margin:0 0 8px;">Banner Slides</h1>
        <p style="color:var(--medium-gray);font-size:14px;margin:0;">
            {{ $slides->count() }} slide{{ $slides->count() !== 1 ? 's' : '' }} registrado{{ $slides->count() !== 1 ? 's' : '' }} | 
            {{ $slides->where('activo', true)->count() }} activo{{ $slides->where('activo', true)->count() !== 1 ? 's' : '' }}
        </p>
    </div>
    <div style="display:flex;gap:10px;flex-wrap:wrap;">
        <a href="{{ route('admin.inicio.index') }}" class="secondary-btn">
            <i class="fas fa-arrow-left"></i> Volver a Gestión de Inicio
        </a>
        <a href="{{ route('admin.inicio.slides.create') }}" class="primary-btn">
            <i class="fas fa-plus"></i> Agregar Slide
        </a>
    </div>
</div>

@if(session('success'))
<div style="background:var(--success-light);color:var(--success);border:1px solid rgba(46,125,50,0.2);border-radius:var(--radius-sm);padding:14px 18px;margin-bottom:20px;display:flex;align-items:center;gap:10px;font-size:14px;font-weight:500;">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
</div>
@endif

@if($slides->count() === 0)
<div style="background:var(--warning-light);color:var(--warning);border:1px solid rgba(230,81,0,0.2);border-radius:var(--radius-sm);padding:14px 18px;margin-bottom:20px;display:flex;align-items:flex-start;gap:10px;font-size:14px;">
    <i class="fas fa-info-circle" style="margin-top:2px;flex-shrink:0;"></i>
    <div>
        <strong>No hay slides del banner configurados.</strong><br>
        El banner del home público no se mostrará hasta que agregues al menos un slide activo.
    </div>
</div>
@endif

<div class="admin-table">
    <table>
        <thead>
            <tr>
                <th style="width:80px;">Preview</th>
                <th>Título</th>
                <th>Tipo</th>
                <th>Vinculado</th>
                <th style="text-align:center;">Orden</th>
                <th>Estado</th>
                <th style="text-align:center;width:140px;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($slides as $slide)
            <tr>
                <td>
                    @if($slide->imagen_final)
                        <img src="{{ $slide->imagen_final }}" alt="{{ $slide->titulo }}"
                             style="width:80px;height:45px;object-fit:cover;border-radius:6px;display:block;">
                    @else
                        <div style="width:80px;height:45px;background:linear-gradient(135deg,var(--light-gray),var(--medium-gray));border-radius:6px;display:flex;align-items:center;justify-content:center;">
                            <i class="fas fa-image" style="color:var(--medium-gray);font-size:20px;"></i>
                        </div>
                    @endif
                </td>
                <td>
                    <div style="font-weight:600;color:var(--dark);font-size:14px;margin-bottom:4px;">{{ $slide->titulo }}</div>
                    @if($slide->tag)
                        <span style="display:inline-block;background:rgba(139,21,56,0.08);color:var(--primary);padding:2px 8px;border-radius:50px;font-size:11px;font-weight:600;">
                            {{ $slide->tag }}
                        </span>
                    @endif
                </td>
                <td>
                    @if($slide->tipo === 'noticia')
                        <span style="display:inline-flex;align-items:center;gap:6px;background:rgba(33,150,243,0.08);color:#2196F3;padding:4px 12px;border-radius:50px;font-size:12px;font-weight:600;">
                            <i class="fas fa-newspaper" style="font-size:11px;"></i>
                            Noticia
                        </span>
                    @elseif($slide->tipo === 'evento')
                        <span style="display:inline-flex;align-items:center;gap:6px;background:rgba(156,39,176,0.08);color:#9C27B0;padding:4px 12px;border-radius:50px;font-size:12px;font-weight:600;">
                            <i class="fas fa-calendar-alt" style="font-size:11px;"></i>
                            Evento
                        </span>
                    @else
                        <span style="display:inline-flex;align-items:center;gap:6px;background:rgba(76,175,80,0.08);color:#4CAF50;padding:4px 12px;border-radius:50px;font-size:12px;font-weight:600;">
                            <i class="fas fa-edit" style="font-size:11px;"></i>
                            Personalizado
                        </span>
                    @endif
                </td>
                <td style="color:var(--medium-gray);font-size:13px;">
                    @if($slide->tipo === 'noticia' && $slide->noticia)
                        <i class="fas fa-link" style="color:var(--info);font-size:11px;"></i>
                        {{ Str::limit($slide->noticia->titulo, 30) }}
                    @elseif($slide->tipo === 'evento' && $slide->evento)
                        <i class="fas fa-link" style="color:var(--info);font-size:11px;"></i>
                        {{ Str::limit($slide->evento->titulo, 30) }}
                    @else
                        —
                    @endif
                </td>
                <td style="text-align:center;">
                    <span style="display:inline-block;width:28px;height:28px;background:var(--light-gray);border-radius:6px;text-align:center;line-height:28px;font-size:13px;font-weight:700;color:var(--dark);">
                        {{ $slide->orden }}
                    </span>
                </td>
                <td>
                    <span class="badge {{ $slide->activo ? 'published' : 'draft' }}">
                        <i class="fas fa-circle" style="font-size:7px;"></i>
                        {{ $slide->activo ? 'Activo' : 'Inactivo' }}
                    </span>
                </td>
                <td>
                    <div style="display:flex;gap:6px;justify-content:center;">
                        <a href="{{ route('admin.inicio.slides.edit', $slide) }}"
                           style="display:inline-flex;align-items:center;padding:6px 10px;background:var(--warning-light);color:var(--warning);border-radius:var(--radius-sm);font-size:12px;font-weight:600;text-decoration:none;">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <form action="{{ route('admin.inicio.slides.destroy', $slide) }}" method="POST" 
                              style="display:inline;" 
                              class="delete-form" 
                              id="form-delete-slide-{{ $slide->id }}">
                            @csrf @method('DELETE')
                            <button type="button"
                                    onclick="confirmDeleteSlide('{{ addslashes($slide->titulo) }}', 'form-delete-slide-{{ $slide->id }}')"
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
                        <i class="fas fa-images"></i>
                        <p>No hay slides registrados.<br>Crea el primer slide del banner.</p>
                        <a href="{{ route('admin.inicio.slides.create') }}" class="primary-btn" style="display:inline-flex;">
                            <i class="fas fa-plus"></i> Agregar Slide
                        </a>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div style="margin-top:16px;padding:14px 18px;background:var(--info-light);border-radius:var(--radius-sm);font-size:13px;color:var(--info);display:flex;align-items:center;gap:10px;">
    <i class="fas fa-lightbulb"></i>
    <span>El campo <strong>Orden</strong> controla el orden de aparición en el banner. Número menor = aparece primero. Los slides inactivos no se mostrarán en el home público.</span>
</div>

@endsection

@push('scripts')
<script>
function confirmDeleteSlide(titulo, formId) {
    Swal.fire({
        title: '¿Eliminar Slide?',
        html: `Se eliminará permanentemente el slide <strong>"${titulo}"</strong>...`,
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
