@extends('layouts.admin')

@section('title', 'Mensajes')
@section('page-title', 'Mensajes de Contacto')

@section('content')

<div class="msg-list-card">

    <div class="msg-list-header">
        <div class="msg-list-header-left">
            <div class="msg-list-icon"><i class="fas fa-inbox"></i></div>
            <div>
                <h3>Bandeja de entrada</h3>
                <p>{{ $messages->total() }} mensaje{{ $messages->total() != 1 ? 's' : '' }} recibido{{ $messages->total() != 1 ? 's' : '' }}</p>
            </div>
        </div>
        @php $newCount = $messages->getCollection()->where('leido', false)->count(); @endphp
        @if($newCount > 0)
        <span class="msg-unread-badge">{{ $newCount }} nuevo{{ $newCount != 1 ? 's' : '' }}</span>
        @endif
    </div>

    {{-- FILTROS --}}
    <x-admin-filters
        :searchPlaceholder="'Buscar por asunto o email...'"
        :searchField="'q'"
        :route="route('admin.mensajes.index')"
        :clearRoute="route('admin.mensajes.index')"
        :filters="[
            [
                'field' => 'estado',
                'label' => 'Estado',
                'options' => [
                    'leido' => 'Leídos',
                    'no-leido' => 'No leídos',
                ]
            ],
        ]"
    />

    <div class="msg-list-body" data-table-name="mensajes">
        {{-- ENCABEZADO CON CHECKBOX --}}
        <div class="msg-row msg-row--header">
            <div class="msg-checkbox-col">
                <input type="checkbox" id="select-all-items" class="form-check-input" title="Seleccionar/deseleccionar todo">
            </div>
            <div class="msg-row-main">
                <div style="font-size:12px;color:var(--medium-gray);">De / Asunto</div>
            </div>
            <div class="msg-row-right">
                <div style="font-size:12px;color:var(--medium-gray);">Fecha</div>
            </div>
        </div>

        @forelse($messages as $msg)
        <div class="msg-row {{ !$msg->leido ? 'msg-row--new' : '' }}">

            <div class="msg-checkbox-col">
                <input type="checkbox" name="selected_ids[]" class="form-check-input" value="{{ $msg->id }}">
            </div>

            <div class="msg-avatar">
                {{ strtoupper(substr($msg->nombre, 0, 2)) }}
            </div>

            <div class="msg-row-main">
                <div class="msg-row-top">
                    <span class="msg-sender">{{ $msg->nombre }}</span>
                    @if(!$msg->leido)
                        <span class="msg-badge msg-badge--new"><i class="fas fa-circle"></i> Nuevo</span>
                    @else
                        <span class="msg-badge msg-badge--read"><i class="fas fa-check-double"></i> Leído</span>
                    @endif
                </div>
                <div class="msg-subject">{{ $msg->asunto }}</div>
                <div class="msg-preview">
                    <span class="msg-email"><i class="fas fa-envelope"></i> {{ $msg->email }}</span>
                    @if($msg->telefono)
                    <span class="msg-phone"><i class="fas fa-phone"></i> {{ $msg->telefono }}</span>
                    @endif
                </div>
            </div>

            <div class="msg-row-right">
                <div class="msg-date">
                    <i class="fas fa-clock"></i>
                    {{ $msg->created_at->format('d/m/Y h:i A') }}
                </div>
                <div class="msg-actions">
                    <a href="{{ route('admin.mensajes.show', $msg) }}" class="msg-btn msg-btn--view">
                        <i class="fas fa-eye"></i> Ver
                    </a>
                    <form action="{{ route('admin.mensajes.destroy', $msg) }}" method="POST" class="delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="msg-btn msg-btn--delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>

        </div>
        @empty
        <div class="msg-empty">
            <div class="msg-empty-icon"><i class="fas fa-inbox"></i></div>
            <h4>Sin mensajes</h4>
            <p>Aún no has recibido ningún mensaje de contacto.</p>
        </div>
        @endforelse
    </div>

    <x-admin-bulk-actions-bar :tableName="'mensajes'" />

    {{ $messages->links('pagination.admin') }}

</div>

@endsection

@push('styles')
<style>
/* Estilos para sistema de bulk actions en mensajes */
.msg-row {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
}

.msg-row--header {
    background: var(--light-gray);
    border-bottom: 2px solid var(--border);
    font-weight: 700;
}

.msg-checkbox-col {
    width: 80px;
    min-width: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 12px;
}

.msg-avatar {
    flex-shrink: 0;
    margin-right: 12px;
}

.msg-row-main {
    flex: 1;
    min-width: 250px;
}

.msg-row-right {
    flex-shrink: 0;
    margin-left: 12px;
}



@media (max-width: 768px) {
    .msg-row {
        flex-wrap: wrap;
    }
    
    .msg-row-right {
        width: 100%;
        margin-left: 92px;
        margin-top: 8px;
    }
}
</style>
@endpush

@push('scripts')
<script>
// Confirmación para eliminación individual desde columna acciones
document.querySelectorAll('.delete-form').forEach(form => {
    form.addEventListener('submit', function(e){
        // Solo mostrar confirmación si no hay selección en masa activada
        const bulkActionsBar = document.getElementById('bulk-actions-bar');
        if (bulkActionsBar && bulkActionsBar.style.display !== 'none') {
            return; // Dejar que bulk actions maneje la eliminación
        }
        
        e.preventDefault();
        Swal.fire({
            title: '¿Eliminar mensaje?',
            text: "Esta acción no se puede deshacer.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#7b1e3a',
            cancelButtonColor: '#999',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if(result.isConfirmed) form.submit();
        });
    });
});
</script>
@endpush
