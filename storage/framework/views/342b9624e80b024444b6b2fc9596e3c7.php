<?php use Illuminate\Support\Str; ?>



<?php $__env->startSection('title', 'Bolsa de Trabajo'); ?>
<?php $__env->startSection('page-title', 'Bolsa de Trabajo'); ?>

<?php $__env->startSection('content'); ?>


<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;flex-wrap:wrap;gap:12px;">
    <div>
        <h1 style="font-size:22px;font-weight:700;color:var(--dark);margin:0 0 4px;">Bolsa de Trabajo</h1>
        <p style="color:var(--medium-gray);font-size:14px;margin:0;"><?php echo e($ofertas->total()); ?> oferta<?php echo e($ofertas->total() !== 1 ? 's' : ''); ?> en total</p>
    </div>
    <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
        <?php $pendingSolicitudes = \App\Models\BolsaTrabajo::noRevisadas()->count(); ?>
        <a href="<?php echo e(route('admin.solicitudes.index')); ?>" 
           style="display:inline-flex;align-items:center;gap:8px;padding:10px 16px;background:<?php echo e($pendingSolicitudes > 0 ? 'rgba(237,108,2,0.1)' : 'rgba(0,0,0,0.04)'); ?>;color:<?php echo e($pendingSolicitudes > 0 ? '#ed6c02' : 'var(--medium-gray)'); ?>;border:1px solid <?php echo e($pendingSolicitudes > 0 ? 'rgba(237,108,2,0.2)' : 'rgba(0,0,0,0.08)'); ?>;border-radius:10px;text-decoration:none;font-size:14px;font-weight:600;transition:all 0.2s;">
            <i class="fas fa-clipboard-list"></i>
            <span>
                <?php if($pendingSolicitudes > 0): ?>
                    <?php echo e($pendingSolicitudes); ?> Solicitud<?php echo e($pendingSolicitudes !== 1 ? 'es' : ''); ?> Pendiente<?php echo e($pendingSolicitudes !== 1 ? 's' : ''); ?>

                <?php else: ?>
                    Ver Solicitudes
                <?php endif; ?>
            </span>
        </a>
        <a href="<?php echo e(route('admin.bolsa.create')); ?>" class="primary-btn">
            <i class="fas fa-plus"></i> Nueva Oferta
        </a>
    </div>
</div>


<?php if(session('success')): ?>
<div style="background:var(--success-light);color:var(--success);border:1px solid rgba(46,125,50,0.2);border-radius:var(--radius-sm);padding:14px 18px;margin-bottom:20px;display:flex;align-items:center;gap:10px;font-size:14px;font-weight:500;">
    <i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?>

</div>
<?php endif; ?>


<?php if (isset($component)) { $__componentOriginal692661d59ef467547c37fd97752f8741 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal692661d59ef467547c37fd97752f8741 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin-filters','data' => ['searchPlaceholder' => 'Buscar por título, empresa o descripción...','searchField' => 'q','route' => route('admin.bolsa.index'),'clearRoute' => route('admin.bolsa.index'),'filters' => [
        [
            'field' => 'tipo',
            'label' => 'Tipo de contrato',
            'options' => [
                'fulltime' => 'Tiempo completo',
                'parttime' => 'Medio tiempo',
                'freelance' => 'Freelance',
                'consultoria' => 'Consultoría',
            ]
        ],
        [
            'field' => 'area',
            'label' => 'Área',
            'options' => [
                'investigacion' => 'Investigación',
                'docencia' => 'Docencia',
                'consultoria' => 'Consultoría',
                'gestion' => 'Gestión',
            ]
        ],
        [
            'field' => 'estado',
            'label' => 'Estado',
            'options' => [
                'activo' => 'Activas',
                'inactivo' => 'Inactivas',
            ]
        ],
    ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin-filters'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['searchPlaceholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Buscar por título, empresa o descripción...'),'searchField' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('q'),'route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.bolsa.index')),'clearRoute' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.bolsa.index')),'filters' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
        [
            'field' => 'tipo',
            'label' => 'Tipo de contrato',
            'options' => [
                'fulltime' => 'Tiempo completo',
                'parttime' => 'Medio tiempo',
                'freelance' => 'Freelance',
                'consultoria' => 'Consultoría',
            ]
        ],
        [
            'field' => 'area',
            'label' => 'Área',
            'options' => [
                'investigacion' => 'Investigación',
                'docencia' => 'Docencia',
                'consultoria' => 'Consultoría',
                'gestion' => 'Gestión',
            ]
        ],
        [
            'field' => 'estado',
            'label' => 'Estado',
            'options' => [
                'activo' => 'Activas',
                'inactivo' => 'Inactivas',
            ]
        ],
    ])]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal692661d59ef467547c37fd97752f8741)): ?>
<?php $attributes = $__attributesOriginal692661d59ef467547c37fd97752f8741; ?>
<?php unset($__attributesOriginal692661d59ef467547c37fd97752f8741); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal692661d59ef467547c37fd97752f8741)): ?>
<?php $component = $__componentOriginal692661d59ef467547c37fd97752f8741; ?>
<?php unset($__componentOriginal692661d59ef467547c37fd97752f8741); ?>
<?php endif; ?>


<div class="admin-table">
    <div class="admin-table-wrapper">
        <table>
            <thead>
                <tr>
                    <th style="width:45px;text-align:center;">
                        <input type="checkbox" id="selectAll">
                    </th>
                    <th style="width:40px;text-align:center;">#</th>
                    <th>Título</th>
                    <th>Empresa</th>
                <th>Ubicación</th>
                <th>Tipo</th>
                <th>Área</th>
                <th>Salario</th>
                <th>Publicado</th>
                <th>Estado</th>
                <th style="text-align:center;width:160px;" class="acciones-column">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $ofertas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $oferta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr class="oferta-row" data-oferta-id="<?php echo e($oferta->id); ?>">
                <td style="text-align:center;">
                    <input type="checkbox" class="oferta-checkbox" value="<?php echo e($oferta->id); ?>">
                </td>
                <td style="text-align:center;color:var(--medium-gray);font-weight:600;font-size:13px;">
                    <?php echo e($index + 1); ?>

                </td>
                <td>
                    <div style="font-weight:600;color:var(--dark);font-size:14px;margin-bottom:3px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;max-width:280px;">
                        <?php echo e($oferta->titulo); ?>

                    </div>
                    <?php if($oferta->fecha_vencimiento && $oferta->fecha_vencimiento->isPast()): ?>
                    <span style="display:inline-flex;align-items:center;gap:3px;margin-top:4px;background:rgba(198,40,40,0.1);color:var(--danger);padding:2px 8px;border-radius:50px;font-size:11px;font-weight:600;">
                        <i class="fas fa-clock" style="font-size:9px;"></i> Vencida
                    </span>
                    <?php endif; ?>
                </td>
                <td>
                    <div style="color:var(--medium-gray);font-size:13px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;max-width:220px;">
                        <i class="fas fa-building" style="margin-right:4px;font-size:11px;"></i><?php echo e($oferta->empresa); ?>

                    </div>
                </td>
                <td style="color:var(--medium-gray);font-size:13px;">
                    <i class="fas fa-map-marker-alt" style="margin-right:4px;font-size:11px;"></i><?php echo e($oferta->ubicacion); ?>

                </td>
                <td>
                    <span style="background:rgba(139,21,56,0.08);color:var(--primary);padding:4px 10px;border-radius:50px;font-size:12px;font-weight:600;">
                        <?php echo e($oferta->tipo_label); ?>

                    </span>
                </td>
                <td>
                    <span style="background:rgba(21,101,192,0.08);color:#1565c0;padding:4px 10px;border-radius:50px;font-size:12px;font-weight:600;">
                        <?php echo e($oferta->area_label); ?>

                    </span>
                </td>
                <td style="color:var(--medium-gray);font-size:13px;"><?php echo e($oferta->salario ?? '—'); ?></td>
                <td style="color:var(--medium-gray);font-size:13px;"><?php echo e($oferta->fecha_publicacion->format('d/m/Y')); ?></td>
                <td>
                    <span class="badge <?php echo e($oferta->activo ? 'published' : 'hidden'); ?>">
                        <i class="fas fa-circle" style="font-size:7px;"></i>
                        <?php echo e($oferta->activo ? 'Activa' : 'Inactiva'); ?>

                    </span>
                </td>
                <td class="acciones-column" style="text-align:center;">
                    <div style="display:flex;gap:6px;justify-content:center;align-items:center;opacity:1;transition:opacity 0.2s;">
                        <a href="<?php echo e(route('admin.bolsa.edit', $oferta)); ?>"
                           style="display:inline-flex;align-items:center;gap:4px;padding:6px 10px;background:var(--warning-light);color:var(--warning);border-radius:var(--radius-sm);font-size:12px;font-weight:600;text-decoration:none;">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <form action="<?php echo e(route('admin.bolsa.destroy', $oferta)); ?>" method="POST" style="display:inline;" class="delete-form">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button type="submit"
                                    style="display:inline-flex;align-items:center;padding:6px 10px;background:var(--danger-light);color:var(--danger);border-radius:var(--radius-sm);font-size:12px;border:none;cursor:pointer;">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="11">
                    <div class="empty-state">
                        <i class="fas fa-briefcase"></i>
                        <p>No hay ofertas de trabajo registradas.<br>Crea tu primera oferta para comenzar.</p>
                        <a href="<?php echo e(route('admin.bolsa.create')); ?>" class="primary-btn" style="display:inline-flex;">
                            <i class="fas fa-plus"></i> Nueva Oferta
                        </a>
                    </div>
                </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
    </div>

    
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

<?php echo e($ofertas->links('pagination.admin')); ?>


<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
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
let selectedOfertas = new Set();
const selectAllCheckbox = document.getElementById('selectAll');
const bulkActionsPanel = document.getElementById('bulkActionsPanel');
const ofertaCheckboxes = document.querySelectorAll('.oferta-checkbox');
const accionesColumns = document.querySelectorAll('.acciones-column');

// Event listeners
selectAllCheckbox?.addEventListener('change', function() {
    ofertaCheckboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
        if (this.checked) {
            selectedOfertas.add(checkbox.value);
        } else {
            selectedOfertas.delete(checkbox.value);
        }
    });
    updateBulkUI();
});

ofertaCheckboxes.forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        if (this.checked) {
            selectedOfertas.add(this.value);
        } else {
            selectedOfertas.delete(this.value);
        }
        
        // Update select all checkbox state
        const allChecked = Array.from(ofertaCheckboxes).every(cb => cb.checked);
        const someChecked = Array.from(ofertaCheckboxes).some(cb => cb.checked);
        selectAllCheckbox.checked = allChecked;
        selectAllCheckbox.indeterminate = someChecked && !allChecked;
        
        updateBulkUI();
    });
});

function updateBulkUI() {
    const count = selectedOfertas.size;
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
    const count = selectedOfertas.size;
    if (count === 0) return;
    
    let title = '';
    let message = '';
    let icon = 'question';
    let confirmButtonText = 'Proceder';
    let confirmButtonColor = '#3b82f6';
    
    switch(action) {
        case 'activar':
            title = 'Activar ofertas';
            message = `Se activarán ${count} oferta(s) de trabajo. Aparecerán en la bolsa pública.`;
            icon = 'info';
            confirmButtonText = 'Sí, activar';
            confirmButtonColor = '#4CAF50';
            break;
        case 'desactivar':
            title = 'Desactivar ofertas';
            message = `Se desactivarán ${count} oferta(s). Dejarán de aparecer en la bolsa pública.`;
            icon = 'warning';
            confirmButtonText = 'Sí, desactivar';
            confirmButtonColor = '#FF9800';
            break;
        case 'eliminar':
            title = 'Eliminar ofertas';
            message = `Se eliminarán permanentemente ${count} oferta(s). Esta acción no se puede deshacer.`;
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
    const ids = Array.from(selectedOfertas);
    const route = '<?php echo e(route("admin.bolsa.bulk-toggle")); ?>';
    
    fetch(route, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '<?php echo e(csrf_token()); ?>'
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
    selectedOfertas.clear();
    ofertaCheckboxes.forEach(checkbox => checkbox.checked = false);
    selectAllCheckbox.checked = false;
    selectAllCheckbox.indeterminate = false;
    updateBulkUI();
}

// Confirmación de eliminación individual
function confirmDelete(titulo, formId) {
    Swal.fire({
        title: '¿Eliminar esta oferta?',
        text: `"${titulo}" será eliminada permanentemente.`,
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
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\cpap-web\resources\views/admin/bolsa/index.blade.php ENDPATH**/ ?>