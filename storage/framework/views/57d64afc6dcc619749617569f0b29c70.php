<?php $__env->startSection('title', 'Mensajes'); ?>
<?php $__env->startSection('page-title', 'Mensajes de Contacto'); ?>

<?php $__env->startSection('content'); ?>

<div class="msg-list-card">

    <div class="msg-list-header">
        <div class="msg-list-header-left" style="display:flex;align-items:center;gap:16px;">
            <input type="checkbox" id="selectAll">
            <div style="display:flex;align-items:center;gap:10px;">
                <div class="msg-list-icon"><i class="fas fa-inbox"></i></div>
                <div>
                    <h3>Bandeja de entrada</h3>
                    <p><?php echo e($messages->total()); ?> mensaje<?php echo e($messages->total() != 1 ? 's' : ''); ?> recibido<?php echo e($messages->total() != 1 ? 's' : ''); ?></p>
                </div>
            </div>
        </div>
        <?php $newCount = $messages->getCollection()->where('leido', false)->count(); ?>
        <?php if($newCount > 0): ?>
        <span class="msg-unread-badge"><?php echo e($newCount); ?> nuevo<?php echo e($newCount != 1 ? 's' : ''); ?></span>
        <?php endif; ?>
    </div>

    
    <?php if (isset($component)) { $__componentOriginal692661d59ef467547c37fd97752f8741 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal692661d59ef467547c37fd97752f8741 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin-filters','data' => ['searchPlaceholder' => 'Buscar por asunto o email...','searchField' => 'q','route' => route('admin.mensajes.index'),'clearRoute' => route('admin.mensajes.index'),'filters' => [
            [
                'field' => 'estado',
                'label' => 'Estado',
                'options' => [
                    'leido' => 'Leídos',
                    'no-leido' => 'No leídos',
                ]
            ],
        ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin-filters'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['searchPlaceholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Buscar por asunto o email...'),'searchField' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('q'),'route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.mensajes.index')),'clearRoute' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.mensajes.index')),'filters' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
            [
                'field' => 'estado',
                'label' => 'Estado',
                'options' => [
                    'leido' => 'Leídos',
                    'no-leido' => 'No leídos',
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

    <div class="msg-list-body">
        <?php $__empty_1 = true; $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="msg-row <?php echo e(!$msg->leido ? 'msg-row--new' : ''); ?>" data-msg-id="<?php echo e($msg->id); ?>">

            <div style="display:flex;align-items:center;padding-right:12px;">
                <input type="checkbox" class="msg-checkbox" value="<?php echo e($msg->id); ?>" style="width:18px;height:18px;cursor:pointer;">
            </div>

            <div class="msg-avatar">
                <?php echo e(strtoupper(substr($msg->nombre, 0, 2))); ?>

            </div>

            <div class="msg-row-main">
                <div class="msg-row-top">
                    <span class="msg-sender"><?php echo e($msg->nombre); ?></span>
                    <?php if(!$msg->leido): ?>
                        <span class="msg-badge msg-badge--new"><i class="fas fa-circle"></i> Nuevo</span>
                    <?php else: ?>
                        <span class="msg-badge msg-badge--read"><i class="fas fa-check-double"></i> Leído</span>
                    <?php endif; ?>
                </div>
                <div class="msg-subject"><?php echo e($msg->asunto); ?></div>
                <div class="msg-preview">
                    <span class="msg-email"><i class="fas fa-envelope"></i> <?php echo e($msg->email); ?></span>
                    <?php if($msg->telefono): ?>
                    <span class="msg-phone"><i class="fas fa-phone"></i> <?php echo e($msg->telefono); ?></span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="msg-row-right">
                <div class="msg-date">
                    <i class="fas fa-clock"></i>
                    <?php echo e($msg->created_at->format('d/m/Y h:i A')); ?>

                </div>
                <div class="msg-actions">
                    <a href="<?php echo e(route('admin.mensajes.show', $msg)); ?>" class="msg-btn msg-btn--view">
                        <i class="fas fa-eye"></i> Ver
                    </a>
                    <form action="<?php echo e(route('admin.mensajes.destroy', $msg)); ?>" method="POST" class="delete-form">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="msg-btn msg-btn--delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>

        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="msg-empty">
            <div class="msg-empty-icon"><i class="fas fa-inbox"></i></div>
            <h4>Sin mensajes</h4>
            <p>Aún no has recibido ningún mensaje de contacto.</p>
        </div>
        <?php endif; ?>
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

<?php echo e($messages->links('pagination.admin')); ?>


</div>

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
</style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
let selectedMessages = new Set();
const bulkActionsPanel = document.getElementById('bulkActionsPanel');
const msgCheckboxes = document.querySelectorAll('.msg-checkbox');
const selectAllCheckbox = document.getElementById('selectAll');

msgCheckboxes.forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        if (this.checked) {
            selectedMessages.add(this.value);
        } else {
            selectedMessages.delete(this.value);
        }
        updateBulkUI();
    });
});

selectAllCheckbox?.addEventListener('change', function() {
    msgCheckboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
        if (this.checked) {
            selectedMessages.add(checkbox.value);
        } else {
            selectedMessages.delete(checkbox.value);
        }
    });
    updateBulkUI();
});

function updateBulkUI() {
    const count = selectedMessages.size;
    const countText = document.getElementById('selectionCountText');
    
    if (count > 0) {
        bulkActionsPanel.style.display = 'block';
        countText.textContent = count === 1 ? '1 elemento seleccionado' : `${count} elementos seleccionados`;
    } else {
        bulkActionsPanel.style.display = 'none';
    }
}

function bulkAction(action) {
    const count = selectedMessages.size;
    if (count === 0) return;
    
    Swal.fire({
        title: 'Eliminar mensajes',
        text: `Se eliminarán permanentemente ${count} mensaje(s). Esta acción no se puede deshacer.`,
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
    const ids = Array.from(selectedMessages);
    const route = '<?php echo e(route("admin.mensajes.bulk-toggle")); ?>';
    
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
    selectedMessages.clear();
    msgCheckboxes.forEach(checkbox => checkbox.checked = false);
    selectAllCheckbox.checked = false;
    updateBulkUI();
}

// Confirmación de eliminación individual
document.querySelectorAll('.delete-form').forEach(form => {
    form.addEventListener('submit', function(e){
        e.preventDefault();
        Swal.fire({
            title: '¿Eliminar mensaje?',
            text: "Esta acción no se puede deshacer.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d32f2f',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then((result) => {
            if(result.isConfirmed) form.submit();
        });
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\cpap-web\resources\views/admin/mensajes/index.blade.php ENDPATH**/ ?>