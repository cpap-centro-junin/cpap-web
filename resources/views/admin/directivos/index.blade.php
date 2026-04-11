@extends('layouts.admin')

@section('title', 'Consejo Directivo')
@section('page-title', 'Consejo Directivo')

@section('content')

<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;flex-wrap:wrap;gap:12px;">
    <div>
        <h1 style="font-size:22px;font-weight:700;color:var(--dark);margin:0 0 4px;">Consejo Directivo</h1>
        <p style="color:var(--medium-gray);font-size:14px;margin:0;">{{ $directivos->count() }} miembro{{ $directivos->count() !== 1 ? 's' : '' }} registrado{{ $directivos->count() !== 1 ? 's' : '' }}</p>
    </div>
    <a href="{{ route('admin.directivos.create') }}" class="primary-btn">
        <i class="fas fa-plus"></i> Agregar Directivo
    </a>
</div>

@if(session('success'))
<div style="background:var(--success-light);color:var(--success);border:1px solid rgba(46,125,50,0.2);border-radius:var(--radius-sm);padding:14px 18px;margin-bottom:20px;display:flex;align-items:center;gap:10px;font-size:14px;font-weight:500;">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
</div>
@endif

{{-- FILTROS --}}
<x-admin-filters
    :searchPlaceholder="'Buscar por nombre o cargo...'"
    :searchField="'q'"
    :route="route('admin.directivos.index')"
    :clearRoute="route('admin.directivos.index')"
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

{{-- Aviso datos ejemplo --}}
@if($directivos->count() === 0)
<div style="background:var(--warning-light);color:var(--warning);border:1px solid rgba(230,81,0,0.2);border-radius:var(--radius-sm);padding:14px 18px;margin-bottom:20px;display:flex;align-items:flex-start;gap:10px;font-size:14px;">
    <i class="fas fa-info-circle" style="margin-top:2px;flex-shrink:0;"></i>
    <div>
        <strong>El Consejo Directivo no tiene miembros aún.</strong><br>
        La página pública mostrará un mensaje de "sin miembros" hasta que agregues los integrantes aquí.
        El sitio público en <em>Nosotros → Consejo Directivo</em> se actualizará automáticamente.
    </div>
</div>
@endif

<div class="admin-table">
    <div class="admin-table-wrapper">
        <table>
            <thead>
                <tr>
                    <th style="width:45px;text-align:center;">
                        <input type="checkbox" id="selectAll" style="width:18px;height:18px;cursor:pointer;">
                    </th>
                    <th style="width:40px;text-align:center;">#</th>
                    <th style="width:60px;">Foto</th>
                    <th>Nombre</th>
                    <th>Cargo</th>
                    <th>Período</th>
                    <th>Orden</th>
                    <th>Estado</th>
                    <th style="text-align:center;width:140px;" class="acciones-column">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($directivos as $index => $directivo)
                <tr class="directivo-row" data-directivo-id="{{ $directivo->id }}">
                    <td style="text-align:center;">
                        <input type="checkbox" class="directivo-checkbox" value="{{ $directivo->id }}" style="width:18px;height:18px;cursor:pointer;">
                    </td>
                    <td style="text-align:center;color:var(--medium-gray);font-weight:600;font-size:13px;">
                        {{ $index + 1 }}
                    </td>
                    <td>
                        @if($directivo->foto)
                            <img src="{{ $directivo->foto }}" alt="{{ $directivo->nombre }}"
                                 style="width:44px;height:44px;object-fit:cover;border-radius:50%;display:block;">
                        @else
                            <div style="width:44px;height:44px;background:linear-gradient(135deg,var(--primary),var(--primary-light));border-radius:50%;display:flex;align-items:center;justify-content:center;">
                                <i class="fas fa-user-tie" style="color:white;font-size:18px;"></i>
                            </div>
                        @endif
                    </td>
                    <td style="font-weight:600;color:var(--dark);font-size:14px;">{{ $directivo->nombre }}</td>
                    <td>
                        <span style="display:inline-flex;align-items:center;gap:6px;background:rgba(139,21,56,0.08);color:var(--primary);padding:4px 12px;border-radius:50px;font-size:12px;font-weight:600;">
                            <i class="fas {{ $directivo->icon }}" style="font-size:11px;"></i>
                            {{ $directivo->cargo }}
                        </span>
                    </td>
                    <td style="color:var(--medium-gray);font-size:13px;">{{ $directivo->periodo }}</td>
                    <td style="text-align:center;">
                        <span style="display:inline-block;width:28px;height:28px;background:var(--light-gray);border-radius:6px;text-align:center;line-height:28px;font-size:13px;font-weight:700;color:var(--dark);">
                            {{ $directivo->orden }}
                        </span>
                    </td>
                    <td>
                        <span class="badge {{ $directivo->activo ? 'published' : 'hidden' }}">
                            <i class="fas fa-circle" style="font-size:7px;"></i>
                            {{ $directivo->activo ? 'Activo' : 'Inactivo' }}
                        </span>
                    </td>
                    <td class="acciones-column">
                        <div style="display:flex;gap:6px;justify-content:center;opacity:1;transition:opacity 0.2s;">
                            <a href="{{ route('admin.directivos.edit', $directivo) }}"
                               style="display:inline-flex;align-items:center;padding:6px 10px;background:var(--warning-light);color:var(--warning);border-radius:var(--radius-sm);font-size:12px;font-weight:600;text-decoration:none;">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <form action="{{ route('admin.directivos.destroy', $directivo) }}" method="POST" 
                                  style="display:inline;" 
                                  class="delete-form" 
                                  id="form-delete-directivo-{{ $directivo->id }}">
                                @csrf @method('DELETE')
                                <button type="button"
                                        onclick="confirmDelete('{{ addslashes($directivo->nombre) }}', 'form-delete-directivo-{{ $directivo->id }}')"
                                        style="display:inline-flex;align-items:center;padding:6px 10px;background:var(--danger-light);color:var(--danger);border-radius:var(--radius-sm);font-size:12px;border:none;cursor:pointer;">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9">
                        <div class="empty-state">
                            <i class="fas fa-users-cog"></i>
                            <p>No hay directivos registrados.<br>Agrega los miembros del Consejo Directivo.</p>
                            <a href="{{ route('admin.directivos.create') }}" class="primary-btn" style="display:inline-flex;">
                                <i class="fas fa-plus"></i> Agregar Directivo
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

@if($directivos->count() > 0)
{{-- Paginación --}}
{{ $directivos->links('pagination.admin') }}
@endif

<div style="margin-top:16px;padding:14px 18px;background:var(--info-light);border-radius:var(--radius-sm);font-size:13px;color:var(--info);display:flex;align-items:center;gap:10px;">
    <i class="fas fa-lightbulb"></i>
    <span>El campo <strong>Orden</strong> controla el orden de aparición en la página pública. Número menor = aparece primero. Ej: Presidente = 1, Vicepresidente = 2, etc.</span>
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
    
    .acciones-column.disabled {
        opacity: 0.5 !important;
        pointer-events: none;
    }
</style>

<script>
// Variables globales
let selectedDirectivos = new Set();

// Elementos del DOM
const selectAllCheckbox = document.getElementById('selectAll');
const bulkActionsPanel = document.getElementById('bulkActionsPanel');
const directivoCheckboxes = document.querySelectorAll('.directivo-checkbox');
const accionesColumns = document.querySelectorAll('.acciones-column');

// Event Listeners
selectAllCheckbox?.addEventListener('change', function() {
    directivoCheckboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
        const directivoId = checkbox.value;
        if (this.checked) {
            selectedDirectivos.add(parseInt(directivoId));
        } else {
            selectedDirectivos.delete(parseInt(directivoId));
        }
    });
    updateBulkUI();
});

directivoCheckboxes.forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        const directivoId = parseInt(this.value);
        if (this.checked) {
            selectedDirectivos.add(directivoId);
        } else {
            selectedDirectivos.delete(directivoId);
        }
        
        // Actualizar el checkbox "Seleccionar todo"
        const allChecked = Array.from(directivoCheckboxes).every(cb => cb.checked);
        selectAllCheckbox.checked = allChecked;
        
        updateBulkUI();
    });
});

// Funciones
function updateBulkUI() {
    const count = selectedDirectivos.size;
    
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
    if (selectedDirectivos.size === 0) {
        Swal.fire({
            title: 'Sin selección',
            text: 'Debes seleccionar al menos 1 directivo.',
            icon: 'warning',
            confirmButtonColor: 'var(--primary)',
        });
        return;
    }

    let title, message, confirmText, confirmColor, icon;
    
    switch(action) {
        case 'activar':
            title = '¿Activar Directivos?';
            message = `Se activarán ${selectedDirectivos.size} directivo(s).`;
            confirmText = 'Activar';
            confirmColor = '#4CAF50';
            icon = 'question';
            break;
        case 'desactivar':
            title = '¿Desactivar Directivos?';
            message = `Se desactivarán ${selectedDirectivos.size} directivo(s).`;
            confirmText = 'Desactivar';
            confirmColor = '#FF9800';
            icon = 'question';
            break;
        case 'eliminar':
            title = '¿Eliminar Directivos?';
            message = `Se eliminarán permanentemente ${selectedDirectivos.size} directivo(s). Esta acción no se puede deshacer.`;
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
    const ids = Array.from(selectedDirectivos);
    
    fetch('{{ route("admin.directivos.bulk-toggle") }}', {
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
    selectedDirectivos.clear();
    directivoCheckboxes.forEach(checkbox => checkbox.checked = false);
    selectAllCheckbox.checked = false;
    updateBulkUI();
}

function confirmDelete(nombre, formId) {
    Swal.fire({
        title: '¿Eliminar Directivo?',
        html: `Se eliminará permanentemente a <strong>"${nombre}"</strong> del Consejo Directivo...`,
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
