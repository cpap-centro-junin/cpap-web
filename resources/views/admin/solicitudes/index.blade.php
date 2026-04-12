@extends('layouts.admin')

@section('title', 'Solicitudes de Ofertas')
@section('page-title', 'Solicitudes de Ofertas Laborales')

@section('content')

{{-- Breadcrumb --}}
<div style="margin-bottom:16px;">
    <a href="{{ route('admin.bolsa.index') }}" 
       style="display:inline-flex;align-items:center;gap:6px;color:var(--medium-gray);text-decoration:none;font-size:14px;font-weight:500;transition:color 0.2s;">
        <i class="fas fa-arrow-left"></i>
        <span>Volver a Bolsa de Trabajo</span>
    </a>
</div>

<div class="msg-list-card">

    <div class="msg-list-header">
        <div class="msg-list-header-left" style="display:flex;align-items:center;gap:16px;">
            <input type="checkbox" id="selectAll" style="width:18px;height:18px;cursor:pointer;">
            <div style="display:flex;align-items:center;gap:10px;">
                <div class="msg-list-icon"><i class="fas fa-clipboard-list"></i></div>
                <div>
                    <h3>Bandeja de solicitudes</h3>
                    <p>{{ $solicitudes->total() }} solicitud{{ $solicitudes->total() != 1 ? 'es' : '' }} recibida{{ $solicitudes->total() != 1 ? 's' : '' }}</p>
                </div>
            </div>
        </div>
        @php $newCount = $solicitudes->getCollection()->where('revisado', false)->count(); @endphp
        @if($newCount > 0)
        <span class="msg-unread-badge">{{ $newCount }} nueva{{ $newCount != 1 ? 's' : '' }}</span>
        @endif
    </div>

    {{-- FILTROS --}}
    <x-admin-filters
        :searchPlaceholder="'Buscar por nombre o email...'"
        :searchField="'q'"
        :route="route('admin.solicitudes.index')"
        :clearRoute="route('admin.solicitudes.index')"
        :filters="[]"
    />

    <div class="msg-list-body">
        @forelse($solicitudes as $sol)
        <div class="msg-row {{ !$sol->revisado ? 'msg-row--new' : '' }}" data-sol-id="{{ $sol->id }}">

            <div style="display:flex;align-items:center;padding-right:12px;">
                <input type="checkbox" class="sol-checkbox" value="{{ $sol->id }}" style="width:18px;height:18px;cursor:pointer;">
            </div>

            <div class="msg-avatar">
                {{ strtoupper(substr($sol->nombre_contacto ?? $sol->empresa ?? 'S', 0, 2)) }}
            </div>

            <div class="msg-row-main">
                <div class="msg-row-top">
                    <span class="msg-sender">{{ $sol->nombre_contacto ?? 'Sin nombre' }}</span>
                    @if(!$sol->revisado)
                        <span class="msg-badge msg-badge--new"><i class="fas fa-circle"></i> Nueva</span>
                    @else
                        <span class="msg-badge msg-badge--read"><i class="fas fa-check-double"></i> Revisada</span>
                    @endif
                </div>
                <div class="msg-subject">{{ $sol->titulo }}</div>
                <div class="msg-preview">
                    <span class="msg-email"><i class="fas fa-building"></i> {{ $sol->empresa ?? 'Sin empresa' }}</span>
                    <span class="msg-email"><i class="fas fa-envelope"></i> {{ $sol->email_contacto }}</span>
                    @if($sol->tipo)
                    <span class="msg-phone"><i class="fas fa-tag"></i> {{ $sol->tipo_label }}</span>
                    @endif
                </div>
            </div>

            <div class="msg-row-right">
                <div class="msg-date">
                    <i class="fas fa-clock"></i>
                    {{ $sol->created_at->format('d/m/Y') }}
                </div>
                <div class="msg-actions">
                    <a href="{{ route('admin.solicitudes.show', $sol) }}" class="msg-btn msg-btn--view">
                        <i class="fas fa-eye"></i> Ver
                    </a>
                    <form action="{{ route('admin.solicitudes.rechazar', $sol) }}" method="POST" class="delete-form">
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
            <div class="msg-empty-icon"><i class="fas fa-clipboard-list"></i></div>
            <h4>Sin solicitudes</h4>
            <p>Aún no has recibido solicitudes de ofertas laborales.</p>
        </div>
        @endforelse
    </div>

    {{-- Panel de Acciones en Masa --}}
    <div id="bulkActionsPanel" style="display:none;margin-top:20px;padding:16px 18px;background:linear-gradient(135deg,rgba(139,21,56,0.08),rgba(139,21,56,0.04));border:1px solid rgba(139,21,56,0.2);border-radius:var(--radius-sm);animation:slideDown 0.3s ease-out;">
        <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:16px;">
            <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;">
                <i class="fas fa-check-circle" style="color:var(--primary);font-size:18px;"></i>
                <span id="selectionCountText" style="font-weight:600;color:var(--dark);font-size:14px;">
                    0 elementos seleccionados
                </span>
            </div>
            <div style="display:flex;gap:8px;flex-wrap:wrap;">
                <button onclick="bulkAction('eliminar')" style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;background:rgba(211,47,47,0.1);color:#d32f2f;border:1px solid rgba(211,47,47,0.3);border-radius:var(--radius-sm);cursor:pointer;font-weight:600;font-size:13px;transition:all 0.2s;"
                        onmouseover="this.style.background='rgba(211,47,47,0.15)';this.style.borderColor='rgba(211,47,47,0.5)'"
                        onmouseout="this.style.background='rgba(211,47,47,0.1)';this.style.borderColor='rgba(211,47,47,0.3)'">
                    <i class="fas fa-trash"></i>
                    Eliminar
                </button>
                <button onclick="clearSelection()" style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;background:var(--light-gray);color:var(--medium-gray);border:1px solid rgba(0,0,0,0.1);border-radius:var(--radius-sm);cursor:pointer;font-weight:600;font-size:13px;transition:all 0.2s;"
                        onmouseover="this.style.background='#e0e0e0'"
                        onmouseout="this.style.background='var(--light-gray)'">
                    <i class="fas fa-times"></i>
                    Deseleccionar
                </button>
            </div>
        </div>
    </div>

{{ $solicitudes->links('pagination.admin') }}

</div>

@endsection

@push('scripts')
<style>
@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
let selectedSolicitudes = new Set();
const bulkActionsPanel = document.getElementById('bulkActionsPanel');
const solCheckboxes = document.querySelectorAll('.sol-checkbox');
const selectAllCheckbox = document.getElementById('selectAll');

solCheckboxes.forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        if (this.checked) {
            selectedSolicitudes.add(this.value);
        } else {
            selectedSolicitudes.delete(this.value);
        }
        updateBulkUI();
    });
});

selectAllCheckbox?.addEventListener('change', function() {
    solCheckboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
        if (this.checked) {
            selectedSolicitudes.add(checkbox.value);
        } else {
            selectedSolicitudes.delete(checkbox.value);
        }
    });
    updateBulkUI();
});

function updateBulkUI() {
    const count = selectedSolicitudes.size;
    const countText = document.getElementById('selectionCountText');
    
    if (count > 0) {
        bulkActionsPanel.style.display = 'block';
        countText.textContent = count === 1 ? '1 elemento seleccionado' : `${count} elementos seleccionados`;
    } else {
        bulkActionsPanel.style.display = 'none';
    }
}

function bulkAction(action) {
    const count = selectedSolicitudes.size;
    if (count === 0) return;
    
    Swal.fire({
        title: 'Eliminar solicitudes',
        text: `Se eliminarán permanentemente ${count} solicitud(es). Esta acción no se puede deshacer.`,
        icon: 'error',
        showCancelButton: true,
        confirmButtonColor: '#d32f2f',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            executeBulkAction(action);
        }
    });
}

function executeBulkAction(action) {
    const ids = Array.from(selectedSolicitudes);
    const route = '{{ route("admin.solicitudes.bulk-toggle") }}';
    
    fetch(route, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}'
        },
        body: JSON.stringify({ ids, action })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                title: '¡Completado!',
                text: data.message,
                icon: 'success',
                confirmButtonColor: '#4CAF50',
                confirmButtonText: 'Continuar'
            }).then(() => {
                location.reload();
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire('Error', 'Ocurrió un error al procesar la solicitud.', 'error');
    });
}

function clearSelection() {
    selectedSolicitudes.clear();
    solCheckboxes.forEach(checkbox => checkbox.checked = false);
    selectAllCheckbox.checked = false;
    updateBulkUI();
}

// Confirmación de eliminación individual
document.querySelectorAll('.delete-form').forEach(form => {
    form.addEventListener('submit', function(e){
        e.preventDefault();
        Swal.fire({
            title: '¿Rechazar solicitud?',
            text: "Se eliminará la solicitud de oferta. Esta acción no se puede deshacer.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#7b1e3a',
            cancelButtonColor: '#999',
            confirmButtonText: 'Sí, rechazar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if(result.isConfirmed) form.submit();
        });
    });
});
</script>
@endpush
