<?php $__env->startSection('title', 'Banner Slides'); ?>
<?php $__env->startSection('page-title', 'Banner Slides'); ?>

<?php $__env->startSection('content'); ?>

<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;flex-wrap:wrap;gap:12px;">
    <div>
        <h1 style="font-size:22px;font-weight:700;color:var(--dark);margin:0 0 8px;">Banner Slides</h1>
        <p style="color:var(--medium-gray);font-size:14px;margin:0;">
            <?php echo e($slides->count()); ?> slide<?php echo e($slides->count() !== 1 ? 's' : ''); ?> registrado<?php echo e($slides->count() !== 1 ? 's' : ''); ?> | 
            <?php echo e($slides->where('activo', true)->count()); ?> activo<?php echo e($slides->where('activo', true)->count() !== 1 ? 's' : ''); ?>

        </p>
    </div>
    <div style="display:flex;gap:10px;flex-wrap:wrap;">
        <a href="<?php echo e(route('admin.inicio.index')); ?>" class="secondary-btn">
            <i class="fas fa-arrow-left"></i> Volver a Gestión de Inicio
        </a>
        <a href="<?php echo e(route('admin.inicio.slides.create')); ?>" class="primary-btn">
            <i class="fas fa-plus"></i> Agregar Slide
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin-filters','data' => ['searchPlaceholder' => 'Buscar por título...','searchField' => 'q','route' => route('admin.inicio.slides.index'),'clearRoute' => route('admin.inicio.slides.index'),'filters' => [
        [
            'field' => 'tipo',
            'label' => 'Tipo',
            'options' => [
                'noticia' => 'Noticia',
                'evento' => 'Evento',
            ]
        ],
        [
            'field' => 'estado',
            'label' => 'Estado',
            'options' => [
                'activo' => 'Activos',
                'inactivo' => 'Inactivos',
            ]
        ],
    ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin-filters'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['searchPlaceholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Buscar por título...'),'searchField' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('q'),'route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.inicio.slides.index')),'clearRoute' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.inicio.slides.index')),'filters' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
        [
            'field' => 'tipo',
            'label' => 'Tipo',
            'options' => [
                'noticia' => 'Noticia',
                'evento' => 'Evento',
            ]
        ],
        [
            'field' => 'estado',
            'label' => 'Estado',
            'options' => [
                'activo' => 'Activos',
                'inactivo' => 'Inactivos',
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

<?php if($slides->count() === 0): ?>
<div style="background:var(--warning-light);color:var(--warning);border:1px solid rgba(230,81,0,0.2);border-radius:var(--radius-sm);padding:14px 18px;margin-bottom:20px;display:flex;align-items:flex-start;gap:10px;font-size:14px;">
    <i class="fas fa-info-circle" style="margin-top:2px;flex-shrink:0;"></i>
    <div>
        <strong>No hay slides del banner configurados.</strong><br>
        El banner del home público no se mostrará hasta que agregues al menos un slide activo.
    </div>
</div>
<?php endif; ?>

<div class="admin-table">
    <div class="admin-table-wrapper">
        <table>
            <thead>
                <tr>
                    <th style="width:80px;">Preview</th>
                    <th>Título</th>
                <th>Tipo</th>
                <th>Vinculado</th>
                <th style="text-align:center;">Orden</th>
                <th>Estado</th>
                <th style="text-align:center;width:140px;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $slides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td>
                    <?php if($slide->imagen_final): ?>
                        <img src="<?php echo e($slide->imagen_final); ?>" alt="<?php echo e($slide->titulo); ?>"
                             style="width:80px;height:45px;object-fit:cover;border-radius:6px;display:block;">
                    <?php else: ?>
                        <div style="width:80px;height:45px;background:linear-gradient(135deg,var(--light-gray),var(--medium-gray));border-radius:6px;display:flex;align-items:center;justify-content:center;">
                            <i class="fas fa-image" style="color:var(--medium-gray);font-size:20px;"></i>
                        </div>
                    <?php endif; ?>
                </td>
                <td>
                    <div style="font-weight:600;color:var(--dark);font-size:14px;margin-bottom:4px;"><?php echo e($slide->titulo); ?></div>
                    <?php if($slide->tag): ?>
                        <span style="display:inline-block;background:rgba(139,21,56,0.08);color:var(--primary);padding:2px 8px;border-radius:50px;font-size:11px;font-weight:600;">
                            <?php echo e($slide->tag); ?>

                        </span>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if($slide->tipo === 'noticia'): ?>
                        <span style="display:inline-flex;align-items:center;gap:6px;background:rgba(33,150,243,0.08);color:#2196F3;padding:4px 12px;border-radius:50px;font-size:12px;font-weight:600;">
                            <i class="fas fa-newspaper" style="font-size:11px;"></i>
                            Noticia
                        </span>
                    <?php elseif($slide->tipo === 'evento'): ?>
                        <span style="display:inline-flex;align-items:center;gap:6px;background:rgba(156,39,176,0.08);color:#9C27B0;padding:4px 12px;border-radius:50px;font-size:12px;font-weight:600;">
                            <i class="fas fa-calendar-alt" style="font-size:11px;"></i>
                            Evento
                        </span>
                    <?php else: ?>
                        <span style="display:inline-flex;align-items:center;gap:6px;background:rgba(76,175,80,0.08);color:#4CAF50;padding:4px 12px;border-radius:50px;font-size:12px;font-weight:600;">
                            <i class="fas fa-edit" style="font-size:11px;"></i>
                            Personalizado
                        </span>
                    <?php endif; ?>
                </td>
                <td style="color:var(--medium-gray);font-size:13px;">
                    <?php if($slide->tipo === 'noticia' && $slide->noticia): ?>
                        <i class="fas fa-link" style="color:var(--info);font-size:11px;"></i>
                        <?php echo e(Str::limit($slide->noticia->titulo, 30)); ?>

                    <?php elseif($slide->tipo === 'evento' && $slide->evento): ?>
                        <i class="fas fa-link" style="color:var(--info);font-size:11px;"></i>
                        <?php echo e(Str::limit($slide->evento->titulo, 30)); ?>

                    <?php elseif($slide->tipo === 'personalizado'): ?>
                        <span style="color:var(--medium-gray);font-size:12px;">
                            <i class="fas fa-arrow-right" style="font-size:10px;"></i>
                            <?php echo e($slide->boton_url ?: 'Sin URL'); ?>

                        </span>
                    <?php else: ?>
                        <span style="color:#999;font-style:italic;">Sin vincular</span>
                    <?php endif; ?>
                </td>
                <td style="text-align:center;">
                    <span style="display:inline-block;width:28px;height:28px;background:var(--light-gray);border-radius:6px;text-align:center;line-height:28px;font-size:13px;font-weight:700;color:var(--dark);">
                        <?php echo e($slide->orden); ?>

                    </span>
                </td>
                <td>
                    <span class="badge <?php echo e($slide->activo ? 'published' : 'draft'); ?>">
                        <i class="fas fa-circle" style="font-size:7px;"></i>
                        <?php echo e($slide->activo ? 'Activo' : 'Inactivo'); ?>

                    </span>
                </td>
                <td>
                    <div style="display:flex;gap:6px;justify-content:center;">
                        <a href="<?php echo e(route('admin.inicio.slides.edit', $slide)); ?>"
                           style="display:inline-flex;align-items:center;padding:6px 10px;background:var(--warning-light);color:var(--warning);border-radius:var(--radius-sm);font-size:12px;font-weight:600;text-decoration:none;">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <form action="<?php echo e(route('admin.inicio.slides.destroy', $slide)); ?>" method="POST" 
                              style="display:inline;" 
                              class="delete-form" 
                              id="form-delete-slide-<?php echo e($slide->id); ?>">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button type="button"
                                    onclick="confirmDeleteSlide('<?php echo e(addslashes($slide->titulo)); ?>', 'form-delete-slide-<?php echo e($slide->id); ?>')"
                                    style="display:inline-flex;align-items:center;padding:6px 10px;background:var(--danger-light);color:var(--danger);border-radius:var(--radius-sm);font-size:12px;border:none;cursor:pointer;">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="7">
                    <div class="empty-state">
                        <i class="fas fa-images"></i>
                        <p>No hay slides registrados.<br>Crea el primer slide del banner.</p>
                        <a href="<?php echo e(route('admin.inicio.slides.create')); ?>" class="primary-btn" style="display:inline-flex;">
                            <i class="fas fa-plus"></i> Agregar Slide
                        </a>
                    </div>
                </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
    </div>
</div>


<?php echo e($slides->links('pagination.admin')); ?>


<div style="margin-top:16px;padding:14px 18px;background:var(--info-light);border-radius:var(--radius-sm);font-size:13px;color:var(--info);display:flex;align-items:center;gap:10px;">
    <i class="fas fa-lightbulb"></i>
    <span>El campo <strong>Orden</strong> controla el orden de aparición en el banner. Número menor = aparece primero. Los slides inactivos no se mostrarán en el home público.</span>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function confirmDeleteSlide(titulo, formId) {
    Swal.fire({
        title: '¿Eliminar Slide?',
        html: `Se eliminará permanentemente el slide <strong>"${titulo}"</strong>...`,
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
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\cpap-web\resources\views/admin/inicio/slides/index.blade.php ENDPATH**/ ?>