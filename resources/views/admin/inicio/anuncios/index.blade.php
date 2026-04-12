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

<div class="admin-table">
    <div class="admin-table-wrapper">
        <table>
            <thead>
                <tr>
                    <th style="width:45px;text-align:center;">
                        <input type="checkbox" id="selectAll">
                    </th>
                    <th style="width:40px;text-align:center;">#</th>
                    <th style="width:120px;">Vista Previa</th>
                    <th>Título (interno)</th>
                    <th style="text-align:center;">Estado</th>
                    <th>Creado</th>
                    <th style="text-align:center;width:160px;" class="acciones-column">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($anuncios as $index => $anuncio)
                <tr class="anuncio-row" data-anuncio-id="{{ $anuncio->id }}">
                    <td style="text-align:center;">
                        <input type="checkbox" class="anuncio-checkbox" value="{{ $anuncio->id }}">
                    </td>
                    <td style="text-align:center;color:var(--medium-gray);font-weight:600;font-size:13px;">
                        {{ $index + 1 }}
                    </td>
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
                    <td class="acciones-column">
                        <div style="display:flex;gap:6px;justify-content:center;opacity:1;transition:opacity 0.2s;">
                            <a href="{{ route('admin.inicio.anuncios.edit', $anuncio) }}"
                               style="display:inline-flex;align-items:center;padding:6px 10px;background:var(--warning-light);color:var(--warning);border-radius:var(--radius-sm);font-size:12px;font-weight:600;text-decoration:none;">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <form action="{{ route('admin.inicio.anuncios.destroy', $anuncio) }}" method="POST" 
                                  style="display:inline;" 
                                  class="delete-form" 
                                  id="form-delete-anuncio-{{ $anuncio->id }}">
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
                    <td colspan="7">
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
            <button onclick="bulkAction('activar')" style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;background:rgba(76,175,80,0.1);color:#4CAF50;border:1px solid rgba(76,175,80,0.3);border-radius:var(--radius-sm);cursor:pointer;font-weight:600;font-size:13px;transition:all 0.2s;"
                    onmouseover="this.style.background='rgba(76,175,80,0.15)';this.style.borderColor='rgba(76,175,80,0.5)'"
                    onmouseout="this.style.background='rgba(76,175,80,0.1)';this.style.borderColor='rgba(76,175,80,0.3)'">
                <i class="fas fa-check"></i>
                Activar
            </button>
            <button onclick="bulkAction('desactivar')" style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;background:rgba(255,152,0,0.1);color:#FF9800;border:1px solid rgba(255,152,0,0.3);border-radius:var(--radius-sm);cursor:pointer;font-weight:600;font-size:13px;transition:all 0.2s;"
                    onmouseover="this.style.background='rgba(255,152,0,0.15)';this.style.borderColor='rgba(255,152,0,0.5)'"
                    onmouseout="this.style.background='rgba(255,152,0,0.1)';this.style.borderColor='rgba(255,152,0,0.3)'">
                <i class="fas fa-ban"></i>
                Desactivar
            </button>
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

@if($anuncios->count() > 0)
{{-- Paginación --}}
{{ $anuncios->links('pagination.admin') }}
@endif


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
    
    .acciones-column.disabled {
        opacity: 0.5 !important;
        pointer-events: none;
    }
</style>

<script>
// Variables globales
let selectedAnuncios = new Set();

// Elementos del DOM
const selectAllCheckbox = document.getElementById('selectAll');
const bulkActionsPanel = document.getElementById('bulkActionsPanel');
const anuncioCheckboxes = document.querySelectorAll('.anuncio-checkbox');
const accionesColumns = document.querySelectorAll('.acciones-column');

// Event Listeners
selectAllCheckbox?.addEventListener('change', function() {
    anuncioCheckboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
        const anuncioId = checkbox.value;
        if (this.checked) {
            selectedAnuncios.add(parseInt(anuncioId));
        } else {
            selectedAnuncios.delete(parseInt(anuncioId));
        }
    });
    updateBulkUI();
});

anuncioCheckboxes.forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        const anuncioId = parseInt(this.value);
        if (this.checked) {
            selectedAnuncios.add(anuncioId);
        } else {
            selectedAnuncios.delete(anuncioId);
        }
        
        // Actualizar el checkbox "Seleccionar todo"
        const allChecked = Array.from(anuncioCheckboxes).every(cb => cb.checked);
        selectAllCheckbox.checked = allChecked;
        
        updateBulkUI();
    });
});

// Funciones
function updateBulkUI() {
    const count = selectedAnuncios.size;
    
    // Mostrar/ocultar panel de acciones
    if (count > 0) {
        bulkActionsPanel.style.display = 'block';
    } else {
        bulkActionsPanel.style.display = 'none';
    }
    
    // Actualizar texto de selección
    const text = count === 1 ? 'elemento seleccionado' : 'elementos seleccionados';
    document.getElementById('selectionCountText').textContent = `${count} ${text}`;
    
    // Bloquear/desbloquear columna de acciones
    if (count > 0) {
        accionesColumns.forEach(col => col.classList.add('disabled'));
    } else {
        accionesColumns.forEach(col => col.classList.remove('disabled'));
    }
}

function bulkAction(action) {
    if (selectedAnuncios.size === 0) {
        Swal.fire({
            title: 'Sin selección',
            text: 'Debes seleccionar al menos 1 anuncio.',
            icon: 'warning',
            confirmButtonColor: 'var(--primary)',
        });
        return;
    }

    let title, message, confirmText, confirmColor, icon;
    
    switch(action) {
        case 'activar':
            title = '¿Activar Anuncios?';
            message = `Se activarán ${selectedAnuncios.size} anuncio(s).`;
            confirmText = 'Activar';
            confirmColor = '#4CAF50';
            icon = 'question';
            break;
        case 'desactivar':
            title = '¿Desactivar Anuncios?';
            message = `Se desactivarán ${selectedAnuncios.size} anuncio(s).`;
            confirmText = 'Desactivar';
            confirmColor = '#FF9800';
            icon = 'question';
            break;
        case 'eliminar':
            title = '¿Eliminar Anuncios?';
            message = `Se eliminarán permanentemente ${selectedAnuncios.size} anuncio(s). Esta acción no se puede deshacer.`;
            confirmText = 'Eliminar';
            confirmColor = '#d32f2f';
            icon = 'warning';
            break;
    }
    
    Swal.fire({
        title: title,
        html: message,
        icon: icon,
        showCancelButton: true,
        confirmButtonColor: confirmColor,
        cancelButtonColor: '#6c757d',
        confirmButtonText: confirmText,
        cancelButtonText: 'Cancelar',
        reverseButtons: true,
        allowOutsideClick: false,
        allowEscapeKey: false
    }).then((result) => {
        if (result.isConfirmed) {
            executeBulkAction(action);
        }
    });
}

function executeBulkAction(action) {
    const ids = Array.from(selectedAnuncios);
    
    fetch('{{ route("admin.inicio.anuncios.bulk-toggle") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            ids: ids,
            action: action
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                title: '¡Éxito!',
                text: data.message,
                icon: 'success',
                confirmButtonColor: 'var(--primary)',
                timer: 2000,
                timerProgressBar: true
            }).then(() => {
                location.reload();
            });
        } else {
            Swal.fire({
                title: 'Error',
                text: data.message,
                icon: 'error',
                confirmButtonColor: 'var(--primary)',
            });
        }
    })
    .catch(error => {
        Swal.fire({
            title: 'Error',
            text: 'Ocurrió un error al procesar la solicitud.',
            icon: 'error',
            confirmButtonColor: 'var(--primary)',
        });
        console.error(error);
    });
}

function clearSelection() {
    selectedAnuncios.clear();
    anuncioCheckboxes.forEach(checkbox => checkbox.checked = false);
    selectAllCheckbox.checked = false;
    updateBulkUI();
}

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
