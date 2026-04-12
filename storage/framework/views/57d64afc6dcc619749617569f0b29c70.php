<?php $__env->startSection('title', 'Mensajes'); ?>
<?php $__env->startSection('page-title', 'Mensajes de Contacto'); ?>

<?php $__env->startSection('content'); ?>

<div class="msg-list-card">

    <div class="msg-list-header">
        <div class="msg-list-header-left">
            <div class="msg-list-icon"><i class="fas fa-inbox"></i></div>
            <div>
                <h3>Bandeja de entrada</h3>
                <p><?php echo e($messages->total()); ?> mensaje<?php echo e($messages->total() != 1 ? 's' : ''); ?> recibido<?php echo e($messages->total() != 1 ? 's' : ''); ?></p>
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
        <?php $__empty_1 = true; $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="msg-row <?php echo e(!$msg->leido ? 'msg-row--new' : ''); ?>">

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

<?php echo e($messages->links('pagination.admin')); ?>


</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.querySelectorAll('.delete-form').forEach(form => {
    form.addEventListener('submit', function(e){
        e.preventDefault();
        Swal.fire({
            title: '¿Eliminar mensaje?',
            text: "Esta acción no se puede deshacer.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#7b1e3a',
            cancelButtonColor: '#999',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if(result.isConfirmed) form.submit();
        });
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\cpap-web\resources\views/admin/mensajes/index.blade.php ENDPATH**/ ?>