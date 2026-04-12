@extends('layouts.admin')

@section('title', 'Colegiados')
@section('page-title', 'Gestión de Colegiados')

@section('content')

<div class="admin-container">

    {{-- Header con botón crear --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Colegiados CPAP</h1>
            <p class="page-subtitle">Gestiona los miembros colegiados del CPAP Región Centro</p>
        </div>
        <a href="{{ route('admin.colegiados.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i>
            Nuevo Colegiado
        </a>
    </div>

    {{-- Filtros y búsqueda --}}
    <x-admin-filters
        :searchPlaceholder="'Buscar por DNI, código o nombre...'"
        :searchField="'q'"
        :route="route('admin.colegiados.index')"
        :clearRoute="route('admin.colegiados.index')"
        :filters="[
            [
                'field' => 'estado',
                'label' => 'Estado',
                'options' => [
                    'activo' => 'Activos',
                    'inactivo' => 'Inactivos',
                ]
            ],
            [
                'field' => 'visibilidad',
                'label' => 'Visibilidad',
                'options' => [
                    'visible' => 'Públicos',
                    'oculto' => 'Ocultos',
                ]
            ],
        ]"
    />

    {{-- Tabla de colegiados --}}
    <div class="admin-table">
        @if($colegiados->count() > 0)
            <div class="admin-table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th style="width:45px;text-align:center;">
                                <input type="checkbox" id="selectAll" style="width:18px;height:18px;cursor:pointer;">
                            </th>
                            <th style="width:40px;text-align:center;">#</th>
                            <th>N° de Colegiatura</th>
                            <th>DNI</th>
                            <th>Nombre Completo</th>
                            <th>Especialización</th>
                            <th>Estado</th>
                            <th>Fecha Colegiatura</th>
                            <th style="text-align:center;width:160px;" class="acciones-column">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($colegiados as $index => $colegiado)
                            <tr class="colegiado-row {{ $colegiado->perfil_oculto ? 'row-perfil-oculto' : '' }}" data-colegiado-id="{{ $colegiado->id }}">
                                <td style="text-align:center;">
                                    <input type="checkbox" class="colegiado-checkbox" value="{{ $colegiado->id }}" style="width:18px;height:18px;cursor:pointer;">
                                </td>
                                <td style="text-align:center;color:var(--medium-gray);font-weight:600;font-size:13px;">
                                    {{ $index + 1 }}
                                </td>
                                <td>
                                    <strong class="text-primary">{{ $colegiado->codigo_cpap }}</strong>
                                </td>
                                <td>{{ $colegiado->dni }}</td>
                                <td>
                                    <div class="user-cell">
                                        @if($colegiado->foto)
                                            <img src="{{ $colegiado->foto_url }}" alt="{{ $colegiado->nombre_completo }}" class="user-avatar-small">
                                        @else
                                            <div class="user-avatar-small">
                                                {{ strtoupper(substr($colegiado->nombres, 0, 1) . substr($colegiado->apellidos, 0, 1)) }}
                                            </div>
                                        @endif
                                        <div>
                                            <span>{{ $colegiado->nombre_completo }}</span>
                                            @if($colegiado->perfil_oculto)
                                                <span class="badge-oculto-sm">
                                                    <i class="fas fa-eye-slash"></i> Oculto
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($colegiado->orientacion)
                                        <span class="text-muted">{{ $colegiado->orientacion }}</span>
                                        @if($colegiado->especialidad)
                                            <br>
                                            <small class="orientacion-sub">
                                                <i class="fas fa-angle-right"></i> {{ $colegiado->especialidad }}
                                            </small>
                                        @endif
                                    @elseif($colegiado->especialidad)
                                        <span class="text-muted">{{ $colegiado->especialidad }}</span>
                                    @else
                                        <span class="text-muted fst-italic">No especificada</span>
                                    @endif
                                </td>
                                <td>
                                    @if($colegiado->estado === 'activo')
                                        <span class="badge badge-success">
                                            <i class="fas fa-check-circle"></i> ACTIVO
                                        </span>
                                    @else
                                        <span class="badge badge-danger">
                                            <i class="fas fa-times-circle"></i> INACTIVO
                                        </span>
                                    @endif
                                </td>
                                <td>{{ $colegiado->fecha_colegiatura->format('d/m/Y') }}</td>
                                <td class="acciones-column" style="text-align:center;">
                                    <div style="display:flex;gap:6px;justify-content:center;align-items:center;opacity:1;transition:opacity 0.2s;">
                                        <a href="{{ route('admin.colegiados.show', $colegiado) }}" 
                                           style="display:inline-flex;align-items:center;padding:6px 10px;background:var(--info-light);color:var(--info);border-radius:var(--radius-sm);font-size:12px;text-decoration:none;"
                                           title="Ver detalle">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.colegiados.edit', $colegiado) }}" class="btn-icon btn-warning" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        {{-- Toggle visibilidad pública --}}
                                        <form action="{{ route('admin.colegiados.toggle-perfil-oculto', $colegiado) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                    class="btn-icon {{ $colegiado->perfil_oculto ? 'btn-orange' : 'btn-teal' }}"
                                                    title="{{ $colegiado->perfil_oculto ? 'Mostrar en directorio público' : 'Ocultar de directorio público' }}">
                                                <i class="fas {{ $colegiado->perfil_oculto ? 'fa-eye' : 'fa-eye-slash' }}"></i>
                                            </button>
                                        </form>
                                        {{-- Toggle estado --}}
                                        <form action="{{ route('admin.colegiados.toggle-estado', $colegiado) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn-icon {{ $colegiado->estado === 'activo' ? 'btn-success' : 'btn-secondary' }}" title="Cambiar estado">
                                                <i class="fas fa-toggle-{{ $colegiado->estado === 'activo' ? 'on' : 'off' }}"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.colegiados.destroy', $colegiado) }}" method="POST" style="display:inline;" class="delete-form" id="form-delete-colegiado-{{ $colegiado->id }}">
                                            @csrf @method('DELETE')
                                            <button type="button"
                                                    onclick="confirmDelete('{{ addslashes($colegiado->nombre_completo) }}', 'form-delete-colegiado-{{ $colegiado->id }}')"
                                                    style="display:inline-flex;align-items:center;padding:6px 10px;background:var(--danger-light);color:var(--danger);border-radius:var(--radius-sm);font-size:12px;border:none;cursor:pointer;">
                                                <i class="fas fa-trash-alt"></i>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
                        <button onclick="bulkAction('ocultar')" style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;background:rgba(211,47,47,0.1);color:#d32f2f;border:1px solid rgba(211,47,47,0.3);border-radius:var(--radius-sm);cursor:pointer;font-weight:600;font-size:13px;transition:all 0.2s;"
                                onmouseover="this.style.background='rgba(211,47,47,0.15)';this.style.borderColor='rgba(211,47,47,0.5)'"
                                onmouseout="this.style.background='rgba(211,47,47,0.1)';this.style.borderColor='rgba(211,47,47,0.3)'">
                            <i class="fas fa-eye-slash"></i>
                            Ocultar
                        </button>
                        <button onclick="bulkAction('mostrar')" style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;background:rgba(33,150,243,0.1);color:#2196F3;border:1px solid rgba(33,150,243,0.3);border-radius:var(--radius-sm);cursor:pointer;font-weight:600;font-size:13px;transition:all 0.2s;"
                                onmouseover="this.style.background='rgba(33,150,243,0.15)';this.style.borderColor='rgba(33,150,243,0.5)'"
                                onmouseout="this.style.background='rgba(33,150,243,0.1)';this.style.borderColor='rgba(33,150,243,0.3)'">
                            <i class="fas fa-eye"></i>
                            Mostrar
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

            {{-- Paginación --}}
            {{ $colegiados->links('pagination.admin') }}
        @else
            <div class="empty-state">
                <i class="fas fa-users"></i>
                <h3>No se encontraron colegiados</h3>
                <p>{{ request('buscar') || request('estado') || request('visibilidad') ? 'Intenta con otros filtros de búsqueda.' : 'Comienza agregando el primer colegiado.' }}</p>
                @if(!request()->anyFilled(['buscar', 'estado', 'visibilidad']))
                    <a href="{{ route('admin.colegiados.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i>
                        Agregar Primer Colegiado
                    </a>
                @endif
            </div>
        @endif
    </div>

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
    opacity: 0.5;
    pointer-events: none;
}
</style>
<script>
let selectedColegiados = new Set();
const selectAllCheckbox = document.getElementById('selectAll');
const bulkActionsPanel = document.getElementById('bulkActionsPanel');
const colegiadoCheckboxes = document.querySelectorAll('.colegiado-checkbox');
const accionesColumns = document.querySelectorAll('.acciones-column');

// Event listeners
selectAllCheckbox?.addEventListener('change', function() {
    colegiadoCheckboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
        if (this.checked) {
            selectedColegiados.add(checkbox.value);
        } else {
            selectedColegiados.delete(checkbox.value);
        }
    });
    updateBulkUI();
});

colegiadoCheckboxes.forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        if (this.checked) {
            selectedColegiados.add(this.value);
        } else {
            selectedColegiados.delete(this.value);
        }
        
        // Update select all checkbox state
        const allChecked = Array.from(colegiadoCheckboxes).every(cb => cb.checked);
        const someChecked = Array.from(colegiadoCheckboxes).some(cb => cb.checked);
        selectAllCheckbox.checked = allChecked;
        selectAllCheckbox.indeterminate = someChecked && !allChecked;
        
        updateBulkUI();
    });
});

function updateBulkUI() {
    const count = selectedColegiados.size;
    const countText = document.getElementById('selectionCountText');
    
    if (count > 0) {
        bulkActionsPanel.style.display = 'block';
        countText.textContent = count === 1 ? '1 elemento seleccionado' : `${count} elementos seleccionados`;
        
        // Disable acciones column
        accionesColumns.forEach(col => col.classList.add('disabled'));
    } else {
        bulkActionsPanel.style.display = 'none';
        
        // Enable acciones column
        accionesColumns.forEach(col => col.classList.remove('disabled'));
    }
}

function bulkAction(action) {
    const count = selectedColegiados.size;
    if (count === 0) return;
    
    let title = '';
    let message = '';
    let icon = 'question';
    let confirmButtonText = 'Proceder';
    let confirmButtonColor = '#3b82f6';
    
    switch(action) {
        case 'activar':
            title = 'Activar colegiados';
            message = `Se activarán <strong>${count} colegiado(s)</strong> junto con todas sus habilitaciones.`;
            icon = 'info';
            confirmButtonColor = '#4CAF50';
            confirmButtonText = '<i class="fas fa-check"></i> Sí, activar';
            break;
        case 'desactivar':
            title = 'Desactivar colegiados';
            message = `Se desactivarán <strong>${count} colegiado(s)</strong> junto con todas sus habilitaciones.`;
            icon = 'warning';
            confirmButtonColor = '#FF9800';
            confirmButtonText = '<i class="fas fa-ban"></i> Sí, desactivar';
            break;
        case 'ocultar':
            title = 'Ocultar perfiles';
            message = `Se ocultarán <strong>${count} colegiado(s)</strong> del directorio público. No serán visibles en el sitio web.`;
            icon = 'info';
            confirmButtonColor = '#d32f2f';
            confirmButtonText = '<i class="fas fa-eye-slash"></i> Sí, ocultar';
            break;
        case 'mostrar':
            title = 'Mostrar perfiles';
            message = `Se mostrarán <strong>${count} colegiado(s)</strong> en el directorio público. Serán visibles en el sitio web.`;
            icon = 'success';
            confirmButtonColor = '#2196F3';
            confirmButtonText = '<i class="fas fa-eye"></i> Sí, mostrar';
            break;
        case 'eliminar':
            title = 'Eliminar colegiados';
            message = `Se eliminarán permanentemente <strong>${count} colegiado(s)</strong> junto con todos sus documentos. Esta acción <strong>no se puede deshacer</strong>.`;
            icon = 'warning';
            confirmButtonColor = '#d32f2f';
            confirmButtonText = '<i class="fas fa-trash"></i> Sí, eliminar';
            break;
    }
    
    Swal.fire({
        title: title,
        html: message,
        icon: icon,
        showCancelButton: true,
        confirmButtonColor: confirmButtonColor,
        cancelButtonColor: '#6c757d',
        confirmButtonText: confirmButtonText,
        cancelButtonText: 'Cancelar',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            executeBulkAction(action);
        }
    });
}

function executeBulkAction(action) {
    const ids = Array.from(selectedColegiados);
    
    fetch('{{ route("admin.colegiados.bulk-toggle") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}'
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
                icon: 'success',
                title: '¡Éxito!',
                text: data.message,
                confirmButtonColor: '#4CAF50'
            }).then(() => {
                location.reload();
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message || 'Algo salió mal. Intenta nuevamente.'
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Hubo un problema procesando tu solicitud.'
        });
    });
}

function clearSelection() {
    selectedColegiados.clear();
    colegiadoCheckboxes.forEach(checkbox => checkbox.checked = false);
    selectAllCheckbox.checked = false;
    selectAllCheckbox.indeterminate = false;
    updateBulkUI();
}

function confirmDelete(nombre, formId) {
    Swal.fire({
        title: '¿Eliminar colegiado?',
        html: `Esta acción eliminará permanentemente a <strong>${nombre}</strong> junto con todos sus documentos de habilitación. Esta acción <strong>no se puede deshacer</strong>.`,
        icon: 'warning',
        showCancelButton: true,
        reverseButtons: true,
        confirmButtonColor: '#d32f2f',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="fas fa-trash"></i> Sí, eliminar',
        cancelButtonText: 'Cancelar',
        focusCancel: true,
        customClass: {
            popup: 'swal-admin-popup',
        }
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(formId).submit();
        }
    });
}
</script>
@endpush
