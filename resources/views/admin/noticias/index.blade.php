@extends('layouts.admin')

@section('title', 'Noticias')
@section('page-title', 'Gestión de Noticias')

@section('content')

<div class="admin-container">

    {{-- Mensajes de éxito --}}
    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- Header con botón crear --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Noticias CPAP</h1>
            <p class="page-subtitle">Gestiona las noticias e información institucional del CPAP Región Centro</p>
        </div>
        <a href="{{ route('admin.noticias.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i>
            Nueva Noticia
        </a>
    </div>

    {{-- Tabla de noticias --}}
    <div class="table-card">
        @if($noticias->count() > 0)
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 80px;">Imagen</th>
                            <th>Título</th>
                            <th style="width: 120px;">Estado</th>
                            <th style="width: 140px;">Fecha</th>
                            <th class="text-center" style="width: 120px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($noticias as $noticia)
                            <tr>
                                <td>
                                    @if($noticia->imagen)
                                        <img src="{{ asset('storage/' . $noticia->imagen) }}"
                                             alt="{{ $noticia->titulo }}"
                                             class="noticia-thumb">
                                    @else
                                        <div class="noticia-thumb-placeholder">
                                            <i class="fas fa-image"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <strong class="noticia-titulo">{{ $noticia->titulo }}</strong>
                                    @if($noticia->contenido)
                                        <p class="noticia-excerpt">{{ Str::limit(strip_tags($noticia->contenido), 80) }}</p>
                                    @endif
                                </td>
                                <td>
                                    @if($noticia->activo)
                                        <span class="badge badge-success">
                                            <i class="fas fa-check-circle"></i> Publicada
                                        </span>
                                    @else
                                        <span class="badge badge-secondary">
                                            <i class="fas fa-eye-slash"></i> Oculta
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <span class="text-muted">{{ $noticia->created_at->format('d/m/Y') }}</span>
                                    <br>
                                    <small class="text-muted" style="font-size: 11px;">{{ $noticia->created_at->diffForHumans() }}</small>
                                </td>
                                <td>
                                    <div class="action-buttons" style="justify-content: center;">
                                        <a href="{{ route('admin.noticias.edit', $noticia) }}"
                                           class="btn-icon btn-warning"
                                           title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.noticias.destroy', $noticia) }}"
                                              method="POST"
                                              class="d-inline"
                                              id="form-del-noticia-{{ $noticia->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                    class="btn-icon btn-danger"
                                                    title="Eliminar"
                                                    onclick="confirmDeleteNoticia('{{ addslashes($noticia->titulo) }}', 'form-del-noticia-{{ $noticia->id }}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-newspaper"></i>
                <h3>No hay noticias registradas</h3>
                <p>Comienza creando la primera noticia institucional del CPAP.</p>
                <a href="{{ route('admin.noticias.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                    Crear Primera Noticia
                </a>
            </div>
        @endif
    </div>

</div>

@endsection

@push('scripts')
<script>
function confirmDeleteNoticia(titulo, formId) {
    Swal.fire({
        title: '¿Eliminar noticia?',
        html: `Se eliminará permanentemente la noticia <strong>"${titulo}"</strong>. Esta acción <strong>no se puede deshacer</strong>.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d32f2f',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="fas fa-trash"></i> Sí, eliminar',
        cancelButtonText: 'Cancelar',
        focusCancel: true,
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(formId).submit();
        }
    });
}
</script>
@endpush
