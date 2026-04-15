@php use Illuminate\Support\Str; @endphp

@extends('layouts.admin')

@section('title', 'Galería')
@section('page-title', 'Galería Institucional')

@section('content')

{{-- HEADER --}}
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;flex-wrap:wrap;gap:12px;">
    <div>
        <h1 style="font-size:22px;font-weight:700;color:var(--dark);margin:0 0 4px;">Galería Institucional</h1>
        <p style="color:var(--medium-gray);font-size:14px;margin:0;">{{ $imagenes->total() }} imagen{{ $imagenes->total() !== 1 ? 'es' : '' }} en total</p>
    </div>
    <div style="display:flex;gap:8px;flex-wrap:wrap;">
        <button onclick="document.getElementById('modalMasivo').style.display='flex'" class="primary-btn" style="background:var(--secondary);border-color:var(--secondary);">
            <i class="fas fa-images"></i> Subida Masiva
        </button>
        <a href="{{ route('admin.galeria.create') }}" class="primary-btn">
            <i class="fas fa-plus"></i> Nueva Imagen
        </a>
    </div>
</div>

{{-- FILTROS --}}
<x-admin-filters
    :searchPlaceholder="'Buscar por título o descripción...'"
    :searchField="'q'"
    :route="route('admin.galeria.index')"
    :clearRoute="route('admin.galeria.index')"
    :filters="[
        [
            'field' => 'categoria',
            'label' => 'Categoría',
            'options' => $categorias
        ],
        [
            'field' => 'estado',
            'label' => 'Estado',
            'options' => [
                'activo' => 'Activos',
                'inactivo' => 'Ocultos',
            ]
        ],
    ]"
/>

{{-- FLASH --}}
@if(session('success'))
<div style="background:var(--success-light);color:var(--success);border:1px solid rgba(46,125,50,0.2);border-radius:var(--radius-sm);padding:14px 18px;margin-bottom:20px;display:flex;align-items:center;gap:10px;font-size:14px;font-weight:500;">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
</div>
@endif

{{-- SELECT ALL --}}
@if($imagenes->count())
<div style="margin-bottom:16px;padding:12px;background:rgba(139,21,56,0.04);border:1px solid rgba(139,21,56,0.1);border-radius:var(--radius-sm);display:inline-block;">
    <label style="display:flex;align-items:center;gap:10px;cursor:pointer;font-weight:600;color:var(--dark);margin:0;">
        <input type="checkbox" id="selectAllCheckbox">
        <span>Seleccionar todos</span>
    </label>
</div>
@endif

{{-- GRID DE IMÁGENES --}}
@if($imagenes->count())
<div style="display:grid;grid-template-columns:repeat(auto-fill, minmax(220px, 1fr));gap:16px;margin-bottom:24px;">
    @foreach($imagenes as $img)
    <div class="admin-card galeria-card" data-imagen-id="{{ $img->id }}" style="padding:0;overflow:hidden;position:relative;">
        {{-- Checkbox selección --}}
        <div style="position:absolute;top:4px;right:4px;z-index:3;">
            <input type="checkbox" class="imagen-checkbox" value="{{ $img->id }}">
        </div>

        {{-- Badges --}}
        <div style="position:absolute;top:8px;left:8px;z-index:2;display:flex;gap:4px;flex-wrap:wrap;">
            @if($img->destacado)
            <span style="background:rgba(212,175,55,0.92);color:#fff;padding:2px 8px;border-radius:50px;font-size:10px;font-weight:700;backdrop-filter:blur(4px);">
                <i class="fas fa-star" style="font-size:8px;"></i> Destacada
            </span>
            @endif
            @if(!$img->activo)
            <span style="background:rgba(211,47,47,0.88);color:#fff;padding:2px 8px;border-radius:50px;font-size:10px;font-weight:700;backdrop-filter:blur(4px);">
                Oculta
            </span>
            @endif
        </div>

        {{-- Imagen --}}
        <div style="height:170px;overflow:hidden;background:var(--light-gray);cursor:pointer;" onclick="window.open('{{ $img->imagen }}','_blank')">
            <img src="{{ $img->imagen }}" alt="{{ $img->titulo }}"
                 style="width:100%;height:100%;object-fit:cover;display:block;transition:transform 0.3s;"
                 onmouseover="this.style.transform='scale(1.05)'"
                 onmouseout="this.style.transform='scale(1)'">
        </div>

        {{-- Info --}}
        <div style="padding:12px;">
            <h4 style="font-size:13px;font-weight:700;color:var(--dark);margin:0 0 4px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                {{ $img->titulo }}
            </h4>
            @if($img->categoria)
            <span style="background:rgba(139,21,56,0.08);color:var(--primary);padding:2px 8px;border-radius:50px;font-size:11px;font-weight:600;">
                {{ $img->categoria }}
            </span>
            @endif
            @if($img->fecha)
            <span style="color:var(--medium-gray);font-size:11px;margin-left:6px;">
                {{ $img->fecha->format('d/m/Y') }}
            </span>
            @endif

            {{-- Acciones --}}
            <div class="imagen-acciones" style="display:flex;gap:4px;margin-top:10px;flex-wrap:wrap;opacity:1;transition:opacity 0.2s;pointer-events:auto;">
                <form action="{{ route('admin.galeria.toggle-destacado', $img) }}" method="POST" style="display:inline;">
                    @csrf @method('PATCH')
                    <button type="submit" title="{{ $img->destacado ? 'Quitar destacado' : 'Destacar' }}"
                            style="width:30px;height:30px;border-radius:6px;border:none;cursor:pointer;font-size:11px;display:inline-flex;align-items:center;justify-content:center;
                            {{ $img->destacado ? 'background:rgba(212,175,55,0.15);color:#b8960c;' : 'background:var(--light-gray);color:var(--medium-gray);' }}">
                        <i class="fas fa-star"></i>
                    </button>
                </form>
                <form action="{{ route('admin.galeria.toggle-activo', $img) }}" method="POST" style="display:inline;">
                    @csrf @method('PATCH')
                    <button type="submit" title="{{ $img->activo ? 'Ocultar' : 'Activar' }}"
                            style="width:30px;height:30px;border-radius:6px;border:none;cursor:pointer;font-size:11px;display:inline-flex;align-items:center;justify-content:center;
                            {{ $img->activo ? 'background:var(--success-light);color:var(--success);' : 'background:var(--danger-light);color:var(--danger);' }}">
                        <i class="fas {{ $img->activo ? 'fa-eye' : 'fa-eye-slash' }}"></i>
                    </button>
                </form>
                <a href="{{ route('admin.galeria.edit', $img) }}"
                   style="width:30px;height:30px;border-radius:6px;display:inline-flex;align-items:center;justify-content:center;background:var(--warning-light);color:var(--warning);text-decoration:none;font-size:11px;">
                    <i class="fas fa-pencil-alt"></i>
                </a>
                <form action="{{ route('admin.galeria.destroy', $img) }}" method="POST" style="display:inline;" id="form-delete-galeria-{{ $img->id }}">
                    @csrf @method('DELETE')
                    <button type="button"
                            onclick="confirmDelete('{{ addslashes($img->titulo) }}', 'form-delete-galeria-{{ $img->id }}')"
                            style="width:30px;height:30px;border-radius:6px;border:none;cursor:pointer;font-size:11px;display:inline-flex;align-items:center;justify-content:center;background:var(--danger-light);color:var(--danger);">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
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
                Quitar destacado
            </button>
            <button onclick="bulkAction('mostrar')" style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;background:rgba(76,175,80,0.1);color:#4CAF50;border:1px solid rgba(76,175,80,0.3);border-radius:var(--radius-sm);cursor:pointer;font-weight:600;font-size:13px;transition:all 0.2s;"
                    onmouseover="this.style.background='rgba(76,175,80,0.15)';this.style.borderColor='rgba(76,175,80,0.5)'"
                    onmouseout="this.style.background='rgba(76,175,80,0.1)';this.style.borderColor='rgba(76,175,80,0.3)'">
                <i class="fas fa-eye"></i>
                Mostrar
            </button>
            <button onclick="bulkAction('ocultar')" style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;background:rgba(255,152,0,0.1);color:#FF9800;border:1px solid rgba(255,152,0,0.3);border-radius:var(--radius-sm);cursor:pointer;font-weight:600;font-size:13px;transition:all 0.2s;"
                    onmouseover="this.style.background='rgba(255,152,0,0.15)';this.style.borderColor='rgba(255,152,0,0.5)'"
                    onmouseout="this.style.background='rgba(255,152,0,0.1)';this.style.borderColor='rgba(255,152,0,0.3)'">
                <i class="fas fa-eye-slash"></i>
                Ocultar
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
@else
<div class="admin-card" style="text-align:center;padding:60px 24px;">
    <i class="fas fa-images" style="font-size:48px;color:var(--border);margin-bottom:16px;display:block;"></i>
    <p style="color:var(--medium-gray);font-size:15px;margin:0 0 16px;">No hay imágenes en la galería.<br>Agrega la primera imagen para comenzar.</p>
    <a href="{{ route('admin.galeria.create') }}" class="primary-btn" style="display:inline-flex;">
        <i class="fas fa-plus"></i> Agregar Imagen
    </a>
</div>
@endif

{{ $imagenes->links('pagination.admin') }}

{{-- MODAL SUBIDA MASIVA --}}
<div id="modalMasivo" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.6);z-index:9999;align-items:center;justify-content:center;padding:20px;" onclick="if(event.target===this)this.style.display='none'">
    <div class="admin-card" style="max-width:540px;width:100%;padding:28px;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
            <h3 style="font-size:18px;font-weight:700;color:var(--dark);margin:0;">
                <i class="fas fa-images" style="color:var(--primary);margin-right:8px;"></i>
                Subida Masiva
            </h3>
            <button onclick="document.getElementById('modalMasivo').style.display='none'"
                    style="width:32px;height:32px;border-radius:50%;background:var(--light-gray);border:none;cursor:pointer;font-size:14px;color:var(--medium-gray);">
                &times;
            </button>
        </div>

        <p style="color:var(--medium-gray);font-size:13px;margin:0 0 18px;line-height:1.5;">
            <i class="fas fa-info-circle" style="color:var(--primary);"></i>
            Paso 1 de 2: Selecciona las imágenes. En el siguiente paso podrás editar título, categoría, visibilidad y más de cada imagen.
        </p>

        <form action="{{ route('admin.galeria.store-masivo') }}" method="POST" enctype="multipart/form-data" id="formMasivo">
            @csrf
            <div style="margin-bottom:14px;">
                <label style="display:block;font-size:13px;font-weight:600;color:var(--dark);margin-bottom:6px;">
                    Imágenes <span style="color:var(--danger);">*</span>
                    <span style="color:var(--medium-gray);font-weight:400;">(máx. 20 archivos, 5MB c/u)</span>
                </label>
                <div id="dropZone" style="border:2px dashed var(--border);border-radius:var(--radius-sm);padding:30px 20px;text-align:center;cursor:pointer;transition:all 0.3s;background:var(--light-gray);">
                    <i class="fas fa-cloud-upload-alt" style="font-size:32px;color:var(--primary);margin-bottom:10px;display:block;"></i>
                    <p style="color:var(--dark);font-size:14px;font-weight:600;margin:0 0 4px;">Arrastra las imágenes aquí</p>
                    <p style="color:var(--medium-gray);font-size:12px;margin:0;">o haz clic para seleccionar archivos</p>
                    <input type="file" name="imagenes[]" id="inputMasivo" multiple accept="image/jpeg,image/png,image/webp" required
                           style="display:none;">
                </div>
            </div>
            <div id="previewMasivo" style="display:none;margin-bottom:16px;">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;">
                    <span style="font-size:13px;font-weight:600;color:var(--dark);" id="previewCount">0 archivos seleccionados</span>
                    <button type="button" onclick="clearMasivoFiles()" style="font-size:12px;color:var(--danger);background:none;border:none;cursor:pointer;">
                        <i class="fas fa-times"></i> Limpiar
                    </button>
                </div>
                <div id="previewGrid" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(70px,1fr));gap:6px;max-height:180px;overflow-y:auto;padding:4px;"></div>
            </div>
            <div style="display:flex;gap:10px;justify-content:flex-end;">
                <button type="button" onclick="document.getElementById('modalMasivo').style.display='none'"
                        style="padding:10px 20px;border-radius:var(--radius-sm);border:1px solid var(--border);background:white;color:var(--medium-gray);cursor:pointer;font-size:14px;">
                    Cancelar
                </button>
                <button type="submit" class="primary-btn" id="btnSubirMasivo" disabled style="opacity:0.5;">
                    <i class="fas fa-arrow-right"></i> Subir y Editar
                </button>
            </div>
        </form>
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

.imagen-acciones.disabled {
    opacity: 0.5;
    pointer-events: none;
}
</style>
<script>
let selectedImagenes = new Set();
const bulkActionsPanel = document.getElementById('bulkActionsPanel');
const imagenCheckboxes = document.querySelectorAll('.imagen-checkbox');
const accionesColumns = document.querySelectorAll('.imagen-acciones');
const selectAllCheckbox = document.getElementById('selectAllCheckbox');

// Event listener para "Seleccionar todos"
if (selectAllCheckbox) {
    selectAllCheckbox.addEventListener('change', function() {
        imagenCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
            if (this.checked) {
                selectedImagenes.add(checkbox.value);
            } else {
                selectedImagenes.delete(checkbox.value);
            }
        });
        updateBulkUI();
    });
}

// Event listeners para checkboxes individuales
imagenCheckboxes.forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        if (this.checked) {
            selectedImagenes.add(this.value);
        } else {
            selectedImagenes.delete(this.value);
        }
        // Actualizar estado del checkbox "Seleccionar todos"
        const totalCheckboxes = imagenCheckboxes.length;
        const checkedCheckboxes = document.querySelectorAll('.imagen-checkbox:checked').length;
        if (selectAllCheckbox) {
            selectAllCheckbox.checked = totalCheckboxes > 0 && checkedCheckboxes === totalCheckboxes;
        }
        updateBulkUI();
    });
});

function updateBulkUI() {
    const count = selectedImagenes.size;
    const countText = document.getElementById('selectionCountText');
    
    if (count > 0) {
        bulkActionsPanel.style.display = 'block';
        countText.textContent = count === 1 ? '1 elemento seleccionado' : `${count} elementos seleccionados`;
        
        // Deshabilitar botones individuales
        accionesColumns.forEach(col => col.classList.add('disabled'));
    } else {
        bulkActionsPanel.style.display = 'none';
        
        // Habilitar botones individuales
        accionesColumns.forEach(col => col.classList.remove('disabled'));
    }
}

function bulkAction(action) {
    const count = selectedImagenes.size;
    if (count === 0) return;
    
    let title = '';
    let message = '';
    let icon = 'question';
    let confirmButtonText = 'Proceder';
    let confirmButtonColor = '#3b82f6';
    let apiAction = action; // Por defecto usa la misma acción
    
    switch(action) {
        case 'destacar':
            title = 'Destacar imágenes';
            message = `Se destacarán <strong>${count} imagen(es)</strong>. Aparecerán resaltadas en el sitio.`;
            icon = 'success';
            confirmButtonColor = '#b8960c';
            confirmButtonText = '<i class="fas fa-star"></i> Sí, destacar';
            break;
        case 'no-destacar':
            title = 'Remover destaque';
            message = `Se removirá el destaque de <strong>${count} imagen(es)</strong>.`;
            icon = 'info';
            confirmButtonColor = '#9e9e9e';
            confirmButtonText = '<i class="fas fa-star-regular"></i> Sí, remover destaque';
            break;
        case 'mostrar':
            title = 'Mostrar imágenes';
            message = `Se mostrarán <strong>${count} imagen(es)</strong>. Estarán visibles en el sitio web.`;
            icon = 'info';
            confirmButtonColor = '#4CAF50';
            confirmButtonText = '<i class="fas fa-eye"></i> Sí, mostrar';
            break;
        case 'ocultar':
            title = 'Ocultar imágenes';
            message = `Se ocultarán <strong>${count} imagen(es)</strong>. No serán visibles en el sitio web.`;
            icon = 'warning';
            confirmButtonColor = '#FF9800';
            confirmButtonText = '<i class="fas fa-eye-slash"></i> Sí, ocultar';
            break;
        case 'eliminar':
            title = 'Eliminar imágenes';
            message = `Se eliminarán permanentemente <strong>${count} imagen(es)</strong> con sus archivos. Esta acción no se puede deshacer.`;
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
            executeBulkAction(apiAction);
        }
    });
}

function executeBulkAction(action) {
    const ids = Array.from(selectedImagenes);
    
    fetch('{{ route("admin.galeria.bulk-toggle") }}', {
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
    selectedImagenes.clear();
    imagenCheckboxes.forEach(checkbox => checkbox.checked = false);
    if (selectAllCheckbox) {
        selectAllCheckbox.checked = false;
    }
    updateBulkUI();
}

function confirmDelete(titulo, formId) {
    Swal.fire({
        title: '¿Eliminar esta imagen?',
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

// ── Subida masiva: Drag & Drop + Preview ──
const dropZone   = document.getElementById('dropZone');
const inputFile  = document.getElementById('inputMasivo');
const previewDiv = document.getElementById('previewMasivo');
const previewGrid= document.getElementById('previewGrid');
const previewCnt = document.getElementById('previewCount');
const btnSubir   = document.getElementById('btnSubirMasivo');

dropZone.addEventListener('click', () => inputFile.click());

['dragenter','dragover'].forEach(e => {
    dropZone.addEventListener(e, (ev) => {
        ev.preventDefault();
        dropZone.style.borderColor = 'var(--primary)';
        dropZone.style.background = 'rgba(139,21,56,0.04)';
    });
});

['dragleave','drop'].forEach(e => {
    dropZone.addEventListener(e, (ev) => {
        ev.preventDefault();
        dropZone.style.borderColor = 'var(--border)';
        dropZone.style.background = 'var(--light-gray)';
    });
});

dropZone.addEventListener('drop', (ev) => {
    ev.preventDefault();
    inputFile.files = ev.dataTransfer.files;
    updateMasivoPreview();
});

inputFile.addEventListener('change', updateMasivoPreview);

function updateMasivoPreview() {
    const files = inputFile.files;
    previewGrid.innerHTML = '';
    if (files.length === 0) {
        previewDiv.style.display = 'none';
        btnSubir.disabled = true;
        btnSubir.style.opacity = '0.5';
        return;
    }
    previewDiv.style.display = 'block';
    previewCnt.textContent = files.length + ' archivo' + (files.length !== 1 ? 's' : '') + ' seleccionado' + (files.length !== 1 ? 's' : '');
    btnSubir.disabled = false;
    btnSubir.style.opacity = '1';

    Array.from(files).forEach((file, i) => {
        const reader = new FileReader();
        reader.onload = (e) => {
            const div = document.createElement('div');
            div.style.cssText = 'aspect-ratio:1;border-radius:6px;overflow:hidden;border:1px solid var(--border);';
            div.innerHTML = `<img src="${e.target.result}" style="width:100%;height:100%;object-fit:cover;display:block;">`;
            previewGrid.appendChild(div);
        };
        reader.readAsDataURL(file);
    });
}

function clearMasivoFiles() {
    inputFile.value = '';
    previewGrid.innerHTML = '';
    previewDiv.style.display = 'none';
    btnSubir.disabled = true;
    btnSubir.style.opacity = '0.5';
}

// Loading state al enviar
document.getElementById('formMasivo').addEventListener('submit', function() {
    btnSubir.disabled = true;
    btnSubir.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Subiendo...';
});
</script>
@endpush
