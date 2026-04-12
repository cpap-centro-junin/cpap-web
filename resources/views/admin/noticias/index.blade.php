@php use Illuminate\Support\Str; @endphp

@extends('layouts.admin')

@section('title', 'Noticias')
@section('page-title', 'Gestión de Noticias')

@section('content')

{{-- HEADER --}}
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;flex-wrap:wrap;gap:12px;">
    <div>
        <h1 style="font-size:22px;font-weight:700;color:var(--dark);margin:0 0 4px;">Noticias</h1>
        <p style="color:var(--medium-gray);font-size:14px;margin:0;">{{ $noticias->total() }} noticia{{ $noticias->total() !== 1 ? 's' : '' }} en total</p>
    </div>
    <a href="{{ route('admin.noticias.create') }}" class="primary-btn">
        <i class="fas fa-plus"></i> Nueva Noticia
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
    :searchPlaceholder="'Buscar por título, autor o contenido...'"
    :searchField="'q'"
    :route="route('admin.noticias.index')"
    :clearRoute="route('admin.noticias.index')"
    :filters="[
        [
            'field' => 'categoria',
            'label' => 'Categoría',
            'options' => [
                'tecnologia' => 'Tecnología',
                'investigacion' => 'Investigación',
                'cultura' => 'Cultura',
                'educacion' => 'Educación',
                'eventos' => 'Eventos',
                'otro' => 'Otro',
            ]
        ],
        [
            'field' => 'estado',
            'label' => 'Estado',
            'options' => [
                'activo' => 'Publicado',
                'inactivo' => 'Oculto',
            ]
        ],
        [
            'field' => 'destacado',
            'label' => 'Destacado',
            'options' => [
                'si' => 'Destacados',
                'no' => 'No destacados',
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
                    <th style="width:60px;">Portada</th>
                    <th>Título</th>
                    <th>Categoría</th>
                    <th>Autor</th>
                    <th>Estado</th>
                    <th>Publicado</th>
                    <th style="text-align:center;width:160px;" class="acciones-column">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($noticias as $index => $noticia)
                <tr class="noticia-row" data-noticia-id="{{ $noticia->id }}">
                    <td style="text-align:center;">
                        <input type="checkbox" class="noticia-checkbox" value="{{ $noticia->id }}">
                    </td>
                    <td style="text-align:center;color:var(--medium-gray);font-weight:600;font-size:13px;">
                        {{ $index + 1 }}
                    </td>
                    <td>
                        @if($noticia->imagen)
                            <img src="{{ $noticia->imagen }}" alt=""
                                 style="width:52px;height:40px;object-fit:cover;border-radius:6px;display:block;">
                        @else
                            <div style="width:52px;height:40px;background:var(--light-gray);border-radius:6px;display:flex;align-items:center;justify-content:center;">
                                <i class="fas fa-newspaper" style="color:var(--border);font-size:14px;"></i>
                            </div>
                        @endif
                    </td>
                    <td>
                        <div style="font-weight:600;color:var(--dark);font-size:14px;margin-bottom:3px;">
                            {{ Str::limit($noticia->titulo, 60) }}
                        </div>
                        @if($noticia->resumen)
                        <div style="color:var(--medium-gray);font-size:12px;">{{ Str::limit($noticia->resumen, 80) }}</div>
                        @endif
                        @if($noticia->destacado)
                        <span style="display:inline-flex;align-items:center;gap:3px;margin-top:4px;background:rgba(212,175,55,0.12);color:#b8960c;padding:2px 8px;border-radius:50px;font-size:11px;font-weight:600;">
                            <i class="fas fa-star" style="font-size:9px;"></i> Destacado
                        </span>
                        @endif
                    </td>
                    <td>
                        <span style="background:rgba(139,21,56,0.08);color:var(--primary);padding:4px 10px;border-radius:50px;font-size:12px;font-weight:600;">
                            {{ $noticia->categoria }}
                        </span>
                    </td>
                    <td style="color:var(--medium-gray);font-size:13px;">{{ $noticia->autor }}</td>
                    <td>
                        <span class="badge {{ $noticia->activo ? 'published' : 'hidden' }}">
                            <i class="fas fa-circle" style="font-size:7px;"></i>
                            {{ $noticia->activo ? 'Publicado' : 'Oculto' }}
                        </span>
                    </td>
                    <td style="color:var(--medium-gray);font-size:13px;">{{ $noticia->created_at->format('d/m/Y') }}</td>
                    <td class="acciones-column" style="text-align:center;">
                        <div style="display:flex;gap:6px;justify-content:center;align-items:center;opacity:1;transition:opacity 0.2s;">
                            <a href="{{ route('noticias.show', $noticia) }}" target="_blank"
                               style="display:inline-flex;align-items:center;padding:6px 10px;background:var(--info-light);color:var(--info);border-radius:var(--radius-sm);font-size:12px;text-decoration:none;"
                               title="Ver en sitio">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.noticias.edit', $noticia) }}"
                               style="display:inline-flex;align-items:center;padding:6px 10px;background:var(--warning-light);color:var(--warning);border-radius:var(--radius-sm);font-size:12px;font-weight:600;text-decoration:none;">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <form action="{{ route('admin.noticias.destroy', $noticia) }}" method="POST" style="display:inline;" class="delete-form" id="form-delete-noticia-{{ $noticia->id }}">
                                @csrf @method('DELETE')
                                <button type="button"
                                        onclick="confirmDelete('{{ addslashes($noticia->titulo) }}', 'form-delete-noticia-{{ $noticia->id }}')"
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
                            <i class="fas fa-newspaper"></i>
                            <p>No hay noticias registradas.<br>Crea tu primera noticia para comenzar.</p>
                            <a href="{{ route('admin.noticias.create') }}" class="primary-btn" style="display:inline-flex;">
                                <i class="fas fa-plus"></i> Crear Noticia
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
                Publicar
            </button>
            <button onclick="bulkAction('desactivar')" style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;background:rgba(255,152,0,0.1);color:#FF9800;border:1px solid rgba(255,152,0,0.3);border-radius:var(--radius-sm);cursor:pointer;font-weight:600;font-size:13px;transition:all 0.2s;"
                    onmouseover="this.style.background='rgba(255,152,0,0.15)';this.style.borderColor='rgba(255,152,0,0.5)'"
                    onmouseout="this.style.background='rgba(255,152,0,0.1)';this.style.borderColor='rgba(255,152,0,0.3)'">
                <i class="fas fa-ban"></i>
                Borrador
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

@if($noticias->count() > 0)
{{ $noticias->links('pagination.admin') }}
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
    opacity: 0.5;
    pointer-events: none;
}
</style>
<script>
let selectedNoticias = new Set();
const selectAllCheckbox = document.getElementById('selectAll');
const bulkActionsPanel = document.getElementById('bulkActionsPanel');
const noticiaCheckboxes = document.querySelectorAll('.noticia-checkbox');
const accionesColumns = document.querySelectorAll('.acciones-column');

// Event listeners
selectAllCheckbox?.addEventListener('change', function() {
    noticiaCheckboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
        if (this.checked) {
            selectedNoticias.add(checkbox.value);
        } else {
            selectedNoticias.delete(checkbox.value);
        }
    });
    updateBulkUI();
});

noticiaCheckboxes.forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        if (this.checked) {
            selectedNoticias.add(this.value);
        } else {
            selectedNoticias.delete(this.value);
        }
        
        // Update select all checkbox state
        const allChecked = Array.from(noticiaCheckboxes).every(cb => cb.checked);
        const someChecked = Array.from(noticiaCheckboxes).some(cb => cb.checked);
        selectAllCheckbox.checked = allChecked;
        selectAllCheckbox.indeterminate = someChecked && !allChecked;
        
        updateBulkUI();
    });
});

function updateBulkUI() {
    const count = selectedNoticias.size;
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
    const count = selectedNoticias.size;
    if (count === 0) return;
    
    let title = '';
    let message = '';
    let icon = 'question';
    let confirmButtonText = 'Proceder';
    let confirmButtonColor = '#3b82f6';
    
    switch(action) {
        case 'activar':
            title = 'Publicar noticias';
            message = `Se publicarán <strong>${count} noticia(s)</strong>. Estarán visibles en el sitio web.`;
            icon = 'info';
            confirmButtonColor = '#4CAF50';
            confirmButtonText = '<i class="fas fa-check"></i> Sí, publicar';
            break;
        case 'desactivar':
            title = 'Guardar como borrador';
            message = `Se guardarán como borrador <strong>${count} noticia(s)</strong>. No serán visibles en el sitio web.`;
            icon = 'info';
            confirmButtonColor = '#FF9800';
            confirmButtonText = '<i class="fas fa-ban"></i> Sí, guardar como borrador';
            break;
        case 'destacar':
            title = 'Destacar noticias';
            message = `Se destacarán <strong>${count} noticia(s)</strong>. Aparecerán resaltadas en el sitio.`;
            icon = 'success';
            confirmButtonColor = '#b8960c';
            confirmButtonText = '<i class="fas fa-star"></i> Sí, destacar';
            break;
        case 'no-destacar':
            title = 'Remover destaque';
            message = `Se removirá el destaque de <strong>${count} noticia(s)</strong>.`;
            icon = 'info';
            confirmButtonColor = '#9e9e9e';
            confirmButtonText = '<i class="fas fa-star-regular"></i> Sí, remover destaque';
            break;
        case 'eliminar':
            title = 'Eliminar noticias';
            message = `Se eliminarán permanentemente <strong>${count} noticia(s)</strong>. Esta acción no se puede deshacer.`;
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
    const ids = Array.from(selectedNoticias);
    
    fetch('{{ route("admin.noticias.bulk-toggle") }}', {
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
    selectedNoticias.clear();
    noticiaCheckboxes.forEach(checkbox => checkbox.checked = false);
    selectAllCheckbox.checked = false;
    selectAllCheckbox.indeterminate = false;
    updateBulkUI();
}

function confirmDelete(titulo, formId) {
    Swal.fire({
        title: '¿Eliminar esta noticia?',
        html: `Se eliminará permanentemente <strong>"${titulo}"</strong>. Esta acción no se puede deshacer.`,
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
