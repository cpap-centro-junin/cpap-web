@extends('layouts.admin')

@section('title', 'Normativa Legal')
@section('page-title', 'Normativa Legal')

@section('content')

<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;flex-wrap:wrap;gap:12px;">
    <div>
        <h1 style="font-size:22px;font-weight:700;color:var(--dark);margin:0 0 4px;">Normativa Legal</h1>
        <p style="color:var(--medium-gray);font-size:14px;margin:0;">{{ $documentos->count() }} documento{{ $documentos->count() !== 1 ? 's' : '' }} registrado{{ $documentos->count() !== 1 ? 's' : '' }}</p>
    </div>
    <a href="{{ route('admin.normativa.create') }}" class="primary-btn">
        <i class="fas fa-plus"></i> Agregar Documento
    </a>
</div>

@if(session('success'))
<div style="background:var(--success-light);color:var(--success);border:1px solid rgba(46,125,50,0.2);border-radius:var(--radius-sm);padding:14px 18px;margin-bottom:20px;display:flex;align-items:center;gap:10px;font-size:14px;font-weight:500;">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
</div>
@endif

{{-- FILTROS --}}
<x-admin-filters
    :searchPlaceholder="'Buscar por título o descripción...'"
    :searchField="'q'"
    :route="route('admin.normativa.index')"
    :clearRoute="route('admin.normativa.index')"
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

@if($documentos->count() === 0)
<div style="background:var(--warning-light);color:var(--warning);border:1px solid rgba(230,81,0,0.2);border-radius:var(--radius-sm);padding:14px 18px;margin-bottom:20px;display:flex;align-items:flex-start;gap:10px;font-size:14px;">
    <i class="fas fa-info-circle" style="margin-top:2px;flex-shrink:0;"></i>
    <div>
        <strong>No hay documentos normativos aún.</strong><br>
        La página pública de <em>Nosotros → Normativa Legal</em> mostrará un mensaje indicando que no hay documentos disponibles.
    </div>
</div>
@endif

<div class="admin-table">
    <div class="admin-table-wrapper">
        <table>
            <thead>
                <tr>
                    <th style="width:45px;text-align:center;">
                        <input type="checkbox" id="selectAll">
                    </th>
                    <th style="width:40px;text-align:center;">#</th>
                    <th style="width:50px;">Ícono</th>
                    <th>Título</th>
                    <th>Archivo PDF</th>
                <th>Orden</th>
                <th>Estado</th>
                <th style="text-align:center;width:160px;" class="acciones-column">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($documentos as $index => $doc)
            <tr class="doc-row" data-doc-id="{{ $doc->id }}">
                <td style="text-align:center;">
                    <input type="checkbox" class="doc-checkbox" value="{{ $doc->id }}">
                </td>
                <td style="text-align:center;color:var(--medium-gray);font-weight:600;font-size:13px;">
                    {{ $index + 1 }}
                </td>
                <td>
                    <div style="width:40px;height:40px;background:linear-gradient(135deg,var(--primary),var(--primary-light));border-radius:10px;display:flex;align-items:center;justify-content:center;">
                        <i class="{{ $doc->icono }}" style="color:white;font-size:16px;"></i>
                    </div>
                </td>
                <td>
                    <div style="font-weight:600;color:var(--dark);font-size:14px;">{{ $doc->titulo }}</div>
                    @if($doc->descripcion)
                    <div style="font-size:12px;color:var(--medium-gray);margin-top:2px;">{{ Str::limit($doc->descripcion, 80) }}</div>
                    @endif
                </td>
                <td>
                    @if($doc->archivo_pdf)
                    <span style="display:inline-flex;align-items:center;gap:6px;background:rgba(46,125,50,0.08);color:var(--success);padding:4px 12px;border-radius:50px;font-size:12px;font-weight:600;">
                        <i class="fas fa-file-pdf" style="font-size:11px;"></i>
                        {{ Str::limit($doc->archivo_nombre, 30) }}
                    </span>
                    @else
                    <span style="color:var(--medium-gray);font-size:13px;font-style:italic;">Sin archivo</span>
                    @endif
                </td>
                <td style="text-align:center;">
                    <span style="display:inline-block;width:28px;height:28px;background:var(--light-gray);border-radius:6px;text-align:center;line-height:28px;font-size:13px;font-weight:700;color:var(--dark);">
                        {{ $doc->orden }}
                    </span>
                </td>
                <td>
                    <span class="badge {{ $doc->activo ? 'published' : 'hidden' }}">
                        <i class="fas fa-circle" style="font-size:7px;"></i>
                        {{ $doc->activo ? 'Activo' : 'Inactivo' }}
                    </span>
                </td>
                <td class="acciones-column" style="text-align:center;">
                    <div style="display:flex;gap:6px;justify-content:center;align-items:center;opacity:1;transition:opacity 0.2s;">
                        <a href="{{ route('admin.normativa.edit', $doc) }}"
                           style="display:inline-flex;align-items:center;gap:4px;padding:6px 10px;background:var(--warning-light);color:var(--warning);border-radius:var(--radius-sm);font-size:12px;font-weight:600;text-decoration:none;">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <form action="{{ route('admin.normativa.destroy', $doc) }}" method="POST" style="display:inline;" class="delete-form" id="form-delete-normativa-{{ $doc->id }}">
                            @csrf @method('DELETE')
                            <button type="button"
                                    onclick="confirmDelete('{{ addslashes($doc->titulo) }}', 'form-delete-normativa-{{ $doc->id }}')"
                                    style="display:inline-flex;align-items:center;padding:6px 10px;background:var(--danger-light);color:var(--danger);border-radius:var(--radius-sm);font-size:12px;border:none;cursor:pointer;">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8">
                    <div class="empty-state">
                        <i class="fas fa-gavel"></i>
                        <p>No hay documentos normativos registrados.<br>Agrega los documentos legales del CPAP.</p>
                        <a href="{{ route('admin.normativa.create') }}" class="primary-btn" style="display:inline-flex;">
                            <i class="fas fa-plus"></i> Agregar Documento
                        </a>
                    </div>
                </td>
            </tr>
            @endforelse
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
</div>

{{-- Paginación --}}
{{ $documentos->links('pagination.admin') }}

<div style="margin-top:16px;padding:14px 18px;background:var(--info-light);border-radius:var(--radius-sm);font-size:13px;color:var(--info);display:flex;align-items:center;gap:10px;">
    <i class="fas fa-lightbulb"></i>
    <span>Los documentos activos se mostrarán en la página pública <strong>Nosotros → Normativa Legal</strong>. Sube archivos PDF de hasta 10 MB.</span>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
let selectedDocs = new Set();
const selectAllCheckbox = document.getElementById('selectAll');
const bulkActionsPanel = document.getElementById('bulkActionsPanel');
const docCheckboxes = document.querySelectorAll('.doc-checkbox');
const accionesColumns = document.querySelectorAll('.acciones-column');

// Event listeners
selectAllCheckbox?.addEventListener('change', function() {
    docCheckboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
        if (this.checked) {
            selectedDocs.add(checkbox.value);
        } else {
            selectedDocs.delete(checkbox.value);
        }
    });
    updateBulkUI();
});

docCheckboxes.forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        if (this.checked) {
            selectedDocs.add(this.value);
        } else {
            selectedDocs.delete(this.value);
        }
        
        // Update select all checkbox state
        const allChecked = Array.from(docCheckboxes).every(cb => cb.checked);
        const someChecked = Array.from(docCheckboxes).some(cb => cb.checked);
        selectAllCheckbox.checked = allChecked;
        selectAllCheckbox.indeterminate = someChecked && !allChecked;
        
        updateBulkUI();
    });
});

function updateBulkUI() {
    const count = selectedDocs.size;
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
    const count = selectedDocs.size;
    if (count === 0) return;
    
    let title = '';
    let message = '';
    let icon = 'question';
    let confirmButtonText = 'Proceder';
    let confirmButtonColor = '#3b82f6';
    
    switch(action) {
        case 'activar':
            title = 'Activar documentos';
            message = `Se activarán ${count} documento(s). Aparecerán en la página pública de Normativa Legal.`;
            icon = 'info';
            confirmButtonText = 'Sí, activar';
            confirmButtonColor = '#4CAF50';
            break;
        case 'desactivar':
            title = 'Desactivar documentos';
            message = `Se desactivarán ${count} documento(s). Dejarán de aparecer en la página pública.`;
            icon = 'warning';
            confirmButtonText = 'Sí, desactivar';
            confirmButtonColor = '#FF9800';
            break;
        case 'eliminar':
            title = 'Eliminar documentos';
            message = `Se eliminarán permanentemente ${count} documento(s). Esta acción no se puede deshacer.`;
            icon = 'error';
            confirmButtonText = 'Sí, eliminar';
            confirmButtonColor = '#d32f2f';
            break;
    }
    
    Swal.fire({
        title: title,
        text: message,
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
    const ids = Array.from(selectedDocs);
    const route = '{{ route("admin.normativa.bulk-toggle") }}';
    
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
    selectedDocs.clear();
    docCheckboxes.forEach(checkbox => checkbox.checked = false);
    selectAllCheckbox.checked = false;
    selectAllCheckbox.indeterminate = false;
    updateBulkUI();
}

// Confirmación de eliminación individual
function confirmDelete(titulo, formId) {
    Swal.fire({
        title: '¿Eliminar este documento?',
        text: `"${titulo}" será eliminado permanentemente.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d32f2f',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, eliminar',
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
