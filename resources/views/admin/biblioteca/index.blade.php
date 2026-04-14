@php use Illuminate\Support\Str; @endphp

@extends('layouts.admin')

@section('title', 'Biblioteca Virtual')
@section('page-title', 'Biblioteca Virtual')

@section('content')

{{-- HEADER --}}
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;flex-wrap:wrap;gap:12px;">
    <div>
        <h1 style="font-size:22px;font-weight:700;color:var(--dark);margin:0 0 4px;">Biblioteca Virtual</h1>
        <p style="color:var(--medium-gray);font-size:14px;margin:0;">{{ $recursos->total() }} recurso{{ $recursos->total() !== 1 ? 's' : '' }} en total</p>
    </div>
    <a href="{{ route('admin.biblioteca.create') }}" class="primary-btn">
        <i class="fas fa-plus"></i> Nuevo Recurso
    </a>
</div>

{{-- FLASH --}}
@if(session('success'))
<div style="background:var(--success-light);color:var(--success);border:1px solid rgba(46,125,50,0.2);border-radius:var(--radius-sm);padding:14px 18px;margin-bottom:20px;display:flex;align-items:center;gap:10px;font-size:14px;font-weight:500;">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
</div>
@endif

{{-- FILTROS --}}
<x-admin-filters
    :searchPlaceholder="'Buscar por título, autor, editorial...'"
    :searchField="'q'"
    :route="route('admin.biblioteca.index')"
    :clearRoute="route('admin.biblioteca.index')"
    :filters="[
        [
            'field' => 'tipo',
            'label' => 'Tipo',
            'options' => [
                'libro' => 'Libros',
                'articulo' => 'Artículos',
                'tesis' => 'Tesis',
                'documento' => 'Documentos',
                'revista' => 'Revistas',
                'multimedia' => 'Multimedia',
            ]
        ],
        [
            'field' => 'formato',
            'label' => 'Formato',
            'options' => [
                'fisico' => 'Físico',
                'digital' => 'Digital',
            ]
        ],
        [
            'field' => 'estado',
            'label' => 'Estado',
            'options' => [
                'publicado' => 'Publicados',
                'oculto' => 'Ocultos',
            ]
        ],
    ]"
/>

{{-- TABLA --}}
<div class="admin-table">
    <div class="admin-table-wrapper">
        <table>
            <thead>
                <tr>
                    <th style="width:45px;text-align:center;">
                        <input type="checkbox" id="selectAll">
                    </th>
                    <th style="width:40px;text-align:center;">#</th>
                    <th style="width:50px;">Portada</th>
                    <th>Título / Autor</th>
                    <th>Tipo</th>
                    <th>Formato</th>
                    <th>Área</th>
                    <th>Estado</th>
                    <th style="text-align:center;width:160px;" class="acciones-column">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recursos as $index => $recurso)
                <tr class="recurso-row" data-recurso-id="{{ $recurso->id }}">
                    <td style="text-align:center;">
                        <input type="checkbox" class="recurso-checkbox" value="{{ $recurso->id }}">
                    </td>
                    <td style="text-align:center;color:var(--medium-gray);font-weight:600;font-size:13px;">
                        {{ $index + 1 }}
                    </td>
                    {{-- Portada --}}
                    <td>
                        @if($recurso->imagen_portada)
                            <img src="{{ $recurso->imagen_portada_url }}" alt=""
                                 style="width:44px;height:60px;object-fit:cover;border-radius:6px;border:1px solid var(--border);">
                        @else
                            <div style="width:44px;height:60px;background:var(--light-gray);border-radius:6px;display:flex;align-items:center;justify-content:center;color:var(--medium-gray);font-size:18px;">
                                <i class="fas {{ $recurso->tipo_icon }}"></i>
                            </div>
                        @endif
                    </td>

                    {{-- Título / Autor --}}
                    <td>
                        <div style="font-weight:600;color:var(--dark);font-size:14px;margin-bottom:3px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;max-width:300px;">
                            {{ $recurso->titulo }}
                        </div>
                        <div style="color:var(--medium-gray);font-size:12px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;max-width:300px;">
                            <i class="fas fa-user" style="margin-right:3px;"></i>{{ $recurso->autor }}
                        </div>
                    </td>

                    {{-- Tipo --}}
                    <td>
                        <span class="badge" style="background:rgba(139,21,56,0.1);color:var(--primary);font-size:12px;">
                            <i class="fas {{ $recurso->tipo_icon }}" style="margin-right:4px;"></i>{{ $recurso->tipo_label }}
                        </span>
                    </td>

                    {{-- Formato --}}
                    <td>
                        @if($recurso->formato === 'fisico')
                            <span class="badge" style="background:rgba(201,169,97,0.15);color:#96792e;font-size:12px;">
                                <i class="fas fa-book" style="margin-right:4px;"></i>Físico
                            </span>
                        @else
                            <span class="badge" style="background:rgba(46,125,50,0.12);color:#2e7d32;font-size:12px;">
                                <i class="fas fa-laptop" style="margin-right:4px;"></i>Virtual
                            </span>
                        @endif
                    </td>

                    {{-- Área --}}
                    <td>
                        <span style="color:var(--dark);font-size:13px;">{{ $recurso->area_label }}</span>
                    </td>

                    {{-- Estado --}}
                    <td>
                        @if($recurso->activo)
                            <span class="badge published">Publicado</span>
                        @else
                            <span class="badge hidden">Oculto</span>
                        @endif
                        @if($recurso->destacado)
                            <span class="badge" style="background:rgba(212,175,55,0.15);color:#b8941d;font-size:10px;" title="Destacado">
                                <i class="fas fa-star"></i>
                            </span>
                        @endif
                    </td>

                    {{-- Acciones --}}
                    <td class="acciones-column" style="text-align:center;">
                        <div style="display:flex;gap:6px;justify-content:center;align-items:center;opacity:1;transition:opacity 0.2s;">
                            <a href="{{ route('admin.biblioteca.edit', $recurso) }}"
                               style="display:inline-flex;align-items:center;padding:6px 10px;background:var(--warning-light);color:var(--warning);border-radius:var(--radius-sm);font-size:12px;text-decoration:none;"
                               title="Editar">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            @if($recurso->archivo_pdf)
                            <a href="{{ $recurso->archivo_pdf_url }}" target="_blank"
                               style="display:inline-flex;align-items:center;padding:6px 10px;background:rgba(139,21,56,0.08);color:var(--primary);border-radius:var(--radius-sm);font-size:12px;text-decoration:none;"
                               title="Ver PDF">
                                <i class="fas fa-file-pdf"></i>
                            </a>
                            @endif
                            <form action="{{ route('admin.biblioteca.destroy', $recurso) }}" method="POST" style="display:inline;" class="delete-form" id="form-delete-biblioteca-{{ $recurso->id }}">
                                @csrf @method('DELETE')
                                <button type="button"
                                        onclick="confirmDelete('{{ addslashes($recurso->titulo) }}', 'form-delete-biblioteca-{{ $recurso->id }}')"
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
                            <i class="fas fa-book"></i>
                            <h3>No hay recursos</h3>
                            <p>Agrega el primer recurso a la biblioteca virtual.</p>
                            <a href="{{ route('admin.biblioteca.create') }}" class="primary-btn">
                                <i class="fas fa-plus"></i> Nuevo Recurso
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
            <button onclick="bulkAction('fisico')" style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;background:rgba(201,169,97,0.15);color:#96792e;border:1px solid rgba(201,169,97,0.3);border-radius:var(--radius-sm);cursor:pointer;font-weight:600;font-size:13px;transition:all 0.2s;"
                    onmouseover="this.style.background='rgba(201,169,97,0.2)';this.style.borderColor='rgba(201,169,97,0.5)'"
                    onmouseout="this.style.background='rgba(201,169,97,0.15)';this.style.borderColor='rgba(201,169,97,0.3)'">
                <i class="fas fa-book"></i>
                Físico
            </button>
            <button onclick="bulkAction('virtual')" style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;background:rgba(46,125,50,0.12);color:#2e7d32;border:1px solid rgba(46,125,50,0.3);border-radius:var(--radius-sm);cursor:pointer;font-weight:600;font-size:13px;transition:all 0.2s;"
                    onmouseover="this.style.background='rgba(46,125,50,0.15)';this.style.borderColor='rgba(46,125,50,0.5)'"
                    onmouseout="this.style.background='rgba(46,125,50,0.12)';this.style.borderColor='rgba(46,125,50,0.3)'">
                <i class="fas fa-laptop"></i>
                Virtual
            </button>
            <button onclick="bulkAction('activar')" style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;background:rgba(76,175,80,0.1);color:#4CAF50;border:1px solid rgba(76,175,80,0.3);border-radius:var(--radius-sm);cursor:pointer;font-weight:600;font-size:13px;transition:all 0.2s;"
                    onmouseover="this.style.background='rgba(76,175,80,0.15)';this.style.borderColor='rgba(76,175,80,0.5)'"
                    onmouseout="this.style.background='rgba(76,175,80,0.1)';this.style.borderColor='rgba(76,175,80,0.3)'">
                <i class="fas fa-check"></i>
                Publicar
            </button>
            <button onclick="bulkAction('desactivar')" style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;background:rgba(255,152,0,0.1);color:#FF9800;border:1px solid rgba(255,152,0,0.3);border-radius:var(--radius-sm);cursor:pointer;font-weight:600;font-size:13px;transition:all 0.2s;"
                    onmouseover="this.style.background='rgba(255,152,0,0.15)';this.style.borderColor='rgba(255,152,0,0.5)'"
                    onmouseout="this.style.background='rgba(255,152,0,0.1)';this.style.borderColor='rgba(255,152,0,0.3)'">
                <i class="fas fa-ban"></i>
                Ocultar
            </button>
            <button onclick="bulkAction('destacar')" style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;background:rgba(212,175,55,0.1);color:#b8960c;border:1px solid rgba(212,175,55,0.3);border-radius:var(--radius-sm);cursor:pointer;font-weight:600;font-size:13px;transition:all 0.2s;"
                    onmouseover="this.style.background='rgba(212,175,55,0.15)';this.style.borderColor='rgba(212,175,55,0.5)'"
                    onmouseout="this.style.background='rgba(212,175,55,0.1)';this.style.borderColor='rgba(212,175,55,0.3)'">
                <i class="fas fa-star"></i>
                Destacar
            </button>
            <button onclick="bulkAction('no-destacar')" style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;background:rgba(158,158,158,0.1);color:#9e9e9e;border:1px solid rgba(158,158,158,0.3);border-radius:var(--radius-sm);cursor:pointer;font-weight:600;font-size:13px;transition:all 0.2s;"
                    onmouseover="this.style.background='rgba(158,158,158,0.15)';this.style.borderColor='rgba(158,158,158,0.5)'"
                    onmouseout="this.style.background='rgba(158,158,158,0.1)';this.style.borderColor='rgba(158,158,158,0.3)'">
                <i class="fas fa-star-regular"></i>
                No destacar
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

{{-- PAGINACIÓN --}}
{{ $recursos->links('pagination.admin') }}

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
let selectedRecursos = new Set();
const selectAllCheckbox = document.getElementById('selectAll');
const bulkActionsPanel = document.getElementById('bulkActionsPanel');
const recursoCheckboxes = document.querySelectorAll('.recurso-checkbox');
const accionesColumns = document.querySelectorAll('.acciones-column');

// Event listeners
selectAllCheckbox?.addEventListener('change', function() {
    recursoCheckboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
        if (this.checked) {
            selectedRecursos.add(checkbox.value);
        } else {
            selectedRecursos.delete(checkbox.value);
        }
    });
    updateBulkUI();
});

recursoCheckboxes.forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        if (this.checked) {
            selectedRecursos.add(this.value);
        } else {
            selectedRecursos.delete(this.value);
        }
        
        // Update select all checkbox state
        const allChecked = Array.from(recursoCheckboxes).every(cb => cb.checked);
        const someChecked = Array.from(recursoCheckboxes).some(cb => cb.checked);
        selectAllCheckbox.checked = allChecked;
        selectAllCheckbox.indeterminate = someChecked && !allChecked;
        
        updateBulkUI();
    });
});

function updateBulkUI() {
    const count = selectedRecursos.size;
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
    const count = selectedRecursos.size;
    if (count === 0) return;
    
    let title = '';
    let message = '';
    let icon = 'question';
    let confirmButtonText = 'Proceder';
    let confirmButtonColor = '#3b82f6';
    
    switch(action) {
        case 'fisico':
            title = 'Marcar como Físico';
            message = `Se marcarán <strong>${count} recurso(s)</strong> como formato físico.`;
            icon = 'info';
            confirmButtonColor = '#96792e';
            confirmButtonText = '<i class="fas fa-book"></i> Sí, marcar como físico';
            break;
        case 'virtual':
            title = 'Marcar como Virtual';
            message = `Se marcarán <strong>${count} recurso(s)</strong> como formato virtual`;
            icon = 'info';
            confirmButtonColor = '#2e7d32';
            confirmButtonText = '<i class="fas fa-laptop"></i> Sí, marcar como virtual';
            break;
        case 'activar':
            title = 'Publicar recursos';
            message = `Se publicarán <strong>${count} recurso(s)</strong>. Estarán visibles en el sitio web.`;
            icon = 'info';
            confirmButtonColor = '#4CAF50';
            confirmButtonText = '<i class="fas fa-check"></i> Sí, publicar';
            break;
        case 'desactivar':
            title = 'Ocultar recursos';
            message = `Se ocultarán <strong>${count} recurso(s)</strong>. No serán visibles en el sitio web.`;
            icon = 'warning';
            confirmButtonColor = '#FF9800';
            confirmButtonText = '<i class="fas fa-ban"></i> Sí, ocultar';
            break;
        case 'destacar':
            title = 'Destacar recursos';
            message = `Se destacarán <strong>${count} recurso(s)</strong>. Aparecerán resaltados en el sitio.`;
            icon = 'success';
            confirmButtonColor = '#b8960c';
            confirmButtonText = '<i class="fas fa-star"></i> Sí, destacar';
            break;
        case 'no-destacar':
            title = 'Remover destaque';
            message = `Se removirá el destaque de <strong>${count} recurso(s)</strong>.`;
            icon = 'info';
            confirmButtonColor = '#9e9e9e';
            confirmButtonText = '<i class="fas fa-star-regular"></i> Sí, remover destaque';
            break;
        case 'eliminar':
            title = '⚠️ Eliminar recursos';
            message = `<div style="text-align: left; line-height: 1.8;">
                <p><strong>Se eliminarán permanentemente ${count} recurso(s):</strong></p>
                <ul style="margin: 10px 0; padding-left: 20px;">
                    <li>✓ Registros de la base de datos</li>
                    <li>✓ PDFs almacenados en <code>/pdf/biblioteca/</code></li>
                    <li>✓ Imágenes almacenadas en <code>/images/biblioteca/</code></li>
                </ul>
                <p style="color: #d32f2f; font-weight: 600; margin-top: 15px;">⚠️ Esta acción NO se puede deshacer</p>
            </div>`;
            icon = 'warning';
            confirmButtonColor = '#d32f2f';
            confirmButtonText = '<i class="fas fa-trash"></i> Sí, eliminar todo';
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
    const ids = Array.from(selectedRecursos);
    
    // Mensajes específicos para el loading
    let loadingTitle = '⏳ Procesando...';
    let loadingMessage = 'Se está procesando tu solicitud';
    
    if (action === 'eliminar') {
        loadingTitle = '🗑️ Eliminando recursos...';
        loadingMessage = 'Se están eliminando los recursos y sus archivos adjuntos. Por favor espera...';
    }
    
    // Mostrar dialogo de carga
    Swal.fire({
        title: loadingTitle,
        html: loadingMessage,
        icon: 'info',
        allowOutsideClick: false,
        allowEscapeKey: false,
        didOpen: (modal) => {
            Swal.showLoading();
        }
    });
    
    // Ejecutar la acción
    fetch('{{ route("admin.biblioteca.bulk-toggle") }}', {
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
            // Mensaje de éxito personalizado
            let successTitle = '¡Éxito!';
            let successIcon = 'success';
            let successColor = '#4CAF50';
            
            if (action === 'eliminar') {
                successTitle = '✅ Recursos eliminados';
                successIcon = 'success';
            }
            
            Swal.fire({
                icon: successIcon,
                title: successTitle,
                html: `<div style="text-align: center; line-height: 1.6;">
                    <p style="font-weight: 600; color: #333; margin-bottom: 10px;">${data.message}</p>
                    ${action === 'eliminar' ? '<p style="font-size: 0.9rem; color: #666;">Los PDFs e imágenes también fueron eliminados.</p>' : ''}
                </div>`,
                confirmButtonColor: successColor,
                confirmButtonText: 'OK'
            }).then(() => {
                location.reload();
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                html: `<div style="text-align: center;">
                    <p>${data.message || 'Algo salió mal. Intenta nuevamente.'}</p>
                </div>`,
                confirmButtonColor: '#d32f2f'
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error de Conexión',
            html: `<div style="text-align: center;">
                <p>Hubo un problema procesando tu solicitud. Por favor intenta nuevamente.</p>
            </div>`,
            confirmButtonColor: '#d32f2f'
        });
    });
}

function clearSelection() {
    selectedRecursos.clear();
    recursoCheckboxes.forEach(checkbox => checkbox.checked = false);
    selectAllCheckbox.checked = false;
    selectAllCheckbox.indeterminate = false;
    updateBulkUI();
}

function confirmDelete(titulo, formId) {
    Swal.fire({
        title: '¿Eliminar recurso de biblioteca?',
        html: `Se eliminará permanentemente <strong>"${titulo}"</strong> junto con sus archivos adjuntos. Esta acción no se puede deshacer.`,
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
