@props(['tableName'])

{{-- Renderiza botones dinámicos según la tabla --}}

@switch($tableName)
    {{-- SLIDES: Activar, Desactivar, Eliminar --}}
    @case('slides')
        <button type="button" id="bulk-activate-btn" class="btn btn-sm btn-success">
            <i class="fas fa-eye"></i> Activar
        </button>
        <button type="button" id="bulk-deactivate-btn" class="btn btn-sm btn-warning">
            <i class="fas fa-eye-slash"></i> Desactivar
        </button>
        <button type="button" id="bulk-delete-btn" class="btn btn-sm btn-danger">
            <i class="fas fa-trash"></i> Eliminar
        </button>
        <button type="button" id="bulk-deselect" class="btn btn-sm btn-secondary">
            <i class="fas fa-times"></i> Deseleccionar
        </button>
        @break

    {{-- ANUNCIOS: Activar, Desactivar, Eliminar --}}
    @case('anuncios')
        <button type="button" id="bulk-activate-btn" class="btn btn-sm btn-success">
            <i class="fas fa-eye"></i> Activar
        </button>
        <button type="button" id="bulk-deactivate-btn" class="btn btn-sm btn-warning">
            <i class="fas fa-eye-slash"></i> Desactivar
        </button>
        <button type="button" id="bulk-delete-btn" class="btn btn-sm btn-danger">
            <i class="fas fa-trash"></i> Eliminar
        </button>
        <button type="button" id="bulk-deselect" class="btn btn-sm btn-secondary">
            <i class="fas fa-times"></i> Deseleccionar
        </button>
        @break

    {{-- DIRECTIVOS: Activar, Desactivar, Eliminar --}}
    @case('directivos')
        <button type="button" id="bulk-activate-btn" class="btn btn-sm btn-success">
            <i class="fas fa-eye"></i> Activar
        </button>
        <button type="button" id="bulk-deactivate-btn" class="btn btn-sm btn-warning">
            <i class="fas fa-eye-slash"></i> Desactivar
        </button>
        <button type="button" id="bulk-delete-btn" class="btn btn-sm btn-danger">
            <i class="fas fa-trash"></i> Eliminar
        </button>
        <button type="button" id="bulk-deselect" class="btn btn-sm btn-secondary">
            <i class="fas fa-times"></i> Deseleccionar
        </button>
        @break

    {{-- COLEGIADOS: Activar, Desactivar, Ocultar, Mostrar, Eliminar --}}
    @case('colegiados')
        <button type="button" id="bulk-activate-btn" class="btn btn-sm btn-success">
            <i class="fas fa-eye"></i> Activar
        </button>
        <button type="button" id="bulk-deactivate-btn" class="btn btn-sm btn-warning">
            <i class="fas fa-eye-slash"></i> Desactivar
        </button>
        <button type="button" id="bulk-hide-btn" class="btn btn-sm btn-dark">
            <i class="fas fa-ban"></i> Ocultar
        </button>
        <button type="button" id="bulk-show-btn" class="btn btn-sm btn-info">
            <i class="fas fa-check"></i> Mostrar
        </button>
        <button type="button" id="bulk-delete-btn" class="btn btn-sm btn-danger">
            <i class="fas fa-trash"></i> Eliminar
        </button>
        <button type="button" id="bulk-deselect" class="btn btn-sm btn-secondary">
            <i class="fas fa-times"></i> Deseleccionar
        </button>
        @break

    {{-- NOTICIAS: Activar, Desactivar, Destacar, DesDestacar, Eliminar --}}
    @case('noticias')
        <button type="button" id="bulk-activate-btn" class="btn btn-sm btn-success">
            <i class="fas fa-eye"></i> Publicar
        </button>
        <button type="button" id="bulk-deactivate-btn" class="btn btn-sm btn-warning">
            <i class="fas fa-eye-slash"></i> Borrador
        </button>
        <button type="button" id="bulk-highlight-btn" class="btn btn-sm btn-warning">
            <i class="fas fa-star"></i> Destacar
        </button>
        <button type="button" id="bulk-unhighlight-btn" class="btn btn-sm btn-secondary">
            <i class="fas fa-star"></i> Quitar Destaque
        </button>
        <button type="button" id="bulk-delete-btn" class="btn btn-sm btn-danger">
            <i class="fas fa-trash"></i> Eliminar
        </button>
        <button type="button" id="bulk-deselect" class="btn btn-sm btn-secondary">
            <i class="fas fa-times"></i> Deseleccionar
        </button>
        @break

    {{-- EVENTOS: Activar, Desactivar, Destacar, DesDestacar, Eliminar --}}
    @case('eventos')
        <button type="button" id="bulk-activate-btn" class="btn btn-sm btn-success">
            <i class="fas fa-eye"></i> Publicar
        </button>
        <button type="button" id="bulk-deactivate-btn" class="btn btn-sm btn-warning">
            <i class="fas fa-eye-slash"></i> Borrador
        </button>
        <button type="button" id="bulk-highlight-btn" class="btn btn-sm btn-warning">
            <i class="fas fa-star"></i> Destacar
        </button>
        <button type="button" id="bulk-unhighlight-btn" class="btn btn-sm btn-secondary">
            <i class="fas fa-star"></i> Quitar Destaque
        </button>
        <button type="button" id="bulk-delete-btn" class="btn btn-sm btn-danger">
            <i class="fas fa-trash"></i> Eliminar
        </button>
        <button type="button" id="bulk-deselect" class="btn btn-sm btn-secondary">
            <i class="fas fa-times"></i> Deseleccionar
        </button>
        @break

    {{-- BIBLIOTECA: Publicar, Oculto, Destacar, Quitar Destaque, Eliminar --}}
    @case('biblioteca')
        <button type="button" id="bulk-activate-btn" class="btn btn-sm btn-success">
            <i class="fas fa-eye"></i> Publicar
        </button>
        <button type="button" id="bulk-deactivate-btn" class="btn btn-sm btn-warning">
            <i class="fas fa-eye-slash"></i> Oculto
        </button>
        <button type="button" id="bulk-highlight-btn" class="btn btn-sm btn-warning">
            <i class="fas fa-star"></i> Destacar
        </button>
        <button type="button" id="bulk-unhighlight-btn" class="btn btn-sm btn-secondary">
            <i class="fas fa-star"></i> Quitar Destaque
        </button>
        <button type="button" id="bulk-delete-btn" class="btn btn-sm btn-danger">
            <i class="fas fa-trash"></i> Eliminar
        </button>
        <button type="button" id="bulk-deselect" class="btn btn-sm btn-secondary">
            <i class="fas fa-times"></i> Deseleccionar
        </button>
        @break

    {{-- BOLSA: Activar, Desactivar, Eliminar --}}
    @case('bolsa')
        <button type="button" id="bulk-activate-btn" class="btn btn-sm btn-success">
            <i class="fas fa-eye"></i> Activar
        </button>
        <button type="button" id="bulk-deactivate-btn" class="btn btn-sm btn-warning">
            <i class="fas fa-eye-slash"></i> Desactivar
        </button>
        <button type="button" id="bulk-delete-btn" class="btn btn-sm btn-danger">
            <i class="fas fa-trash"></i> Eliminar
        </button>
        <button type="button" id="bulk-deselect" class="btn btn-sm btn-secondary">
            <i class="fas fa-times"></i> Deseleccionar
        </button>
        @break

    {{-- NORMATIVA: Activar, Desactivar, Eliminar --}}
    @case('normativa')
        <button type="button" id="bulk-activate-btn" class="btn btn-sm btn-success">
            <i class="fas fa-eye"></i> Activar
        </button>
        <button type="button" id="bulk-deactivate-btn" class="btn btn-sm btn-warning">
            <i class="fas fa-eye-slash"></i> Desactivar
        </button>
        <button type="button" id="bulk-delete-btn" class="btn btn-sm btn-danger">
            <i class="fas fa-trash"></i> Eliminar
        </button>
        <button type="button" id="bulk-deselect" class="btn btn-sm btn-secondary">
            <i class="fas fa-times"></i> Deseleccionar
        </button>
        @break

    {{-- MENSAJES: Solo Eliminar --}}
    @case('mensajes')
        <button type="button" id="bulk-delete-btn" class="btn btn-sm btn-danger">
            <i class="fas fa-trash"></i> Eliminar
        </button>
        <button type="button" id="bulk-deselect" class="btn btn-sm btn-secondary">
            <i class="fas fa-times"></i> Deseleccionar
        </button>
        @break

    {{-- SOLICITUDES: Solo Eliminar --}}
    @case('solicitudes')
        <button type="button" id="bulk-delete-btn" class="btn btn-sm btn-danger">
            <i class="fas fa-trash"></i> Eliminar
        </button>
        <button type="button" id="bulk-deselect" class="btn btn-sm btn-secondary">
            <i class="fas fa-times"></i> Deseleccionar
        </button>
        @break

    {{-- DEFAULT --}}
    @default
        <button type="button" id="bulk-delete-btn" class="btn btn-sm btn-danger">
            <i class="fas fa-trash"></i> Eliminar
        </button>
        <button type="button" id="bulk-deselect" class="btn btn-sm btn-secondary">
            <i class="fas fa-times"></i> Deseleccionar
        </button>
@endswitch

<script>
// Renderizar botones dinámicamente en la barra
document.addEventListener('DOMContentLoaded', function() {
    const template = document.currentScript.previousElementSibling;
    if (!template) return;

    const buttonsHtml = template.innerHTML;
    const container = document.getElementById('bulk-buttons-container');
    if (container) {
        container.innerHTML = buttonsHtml;
    }
});
</script>
