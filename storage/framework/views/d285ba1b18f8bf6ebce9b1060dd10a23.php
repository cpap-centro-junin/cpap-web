<?php $__env->startSection('title', 'Consejo Directivo'); ?>
<?php $__env->startSection('page-title', 'Consejo Directivo'); ?>

<?php $__env->startSection('content'); ?>

<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;flex-wrap:wrap;gap:12px;">
    <div>
        <h1 style="font-size:22px;font-weight:700;color:var(--dark);margin:0 0 4px;">Consejo Directivo</h1>
        <p style="color:var(--medium-gray);font-size:14px;margin:0;"><?php echo e($directivos->count()); ?> miembro<?php echo e($directivos->count() !== 1 ? 's' : ''); ?> registrado<?php echo e($directivos->count() !== 1 ? 's' : ''); ?></p>
    </div>
    <a href="<?php echo e(route('admin.directivos.create')); ?>" class="primary-btn">
        <i class="fas fa-plus"></i> Agregar Directivo
    </a>
</div>

<?php if(session('success')): ?>
<div style="background:var(--success-light);color:var(--success);border:1px solid rgba(46,125,50,0.2);border-radius:var(--radius-sm);padding:14px 18px;margin-bottom:20px;display:flex;align-items:center;gap:10px;font-size:14px;font-weight:500;">
    <i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?>

</div>
<?php endif; ?>


<?php if (isset($component)) { $__componentOriginal692661d59ef467547c37fd97752f8741 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal692661d59ef467547c37fd97752f8741 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin-filters','data' => ['searchPlaceholder' => 'Buscar por nombre o cargo...','searchField' => 'q','route' => route('admin.directivos.index'),'clearRoute' => route('admin.directivos.index'),'filters' => [
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
<?php $component->withAttributes(['searchPlaceholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Buscar por nombre o cargo...'),'searchField' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('q'),'route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.directivos.index')),'clearRoute' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.directivos.index')),'filters' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
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


<?php if($directivos->count() === 0): ?>
<div style="background:var(--warning-light);color:var(--warning);border:1px solid rgba(230,81,0,0.2);border-radius:var(--radius-sm);padding:14px 18px;margin-bottom:20px;display:flex;align-items:flex-start;gap:10px;font-size:14px;">
    <i class="fas fa-info-circle" style="margin-top:2px;flex-shrink:0;"></i>
    <div>
        <strong>El Consejo Directivo no tiene miembros aún.</strong><br>
        La página pública mostrará un mensaje de "sin miembros" hasta que agregues los integrantes aquí.
        El sitio público en <em>Nosotros → Consejo Directivo</em> se actualizará automáticamente.
    </div>
</div>
<?php endif; ?>

<div class="admin-table">
    <div class="admin-table-wrapper">
        <table>
            <thead>
                <tr>
                    <th style="width:60px;">Foto</th>
                    <th>Nombre</th>
                    <th>Cargo</th>
                    <th>Período</th>
                <th>Orden</th>
                <th>Estado</th>
                <th style="text-align:center;width:140px;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $directivos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $directivo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td>
                    <?php if($directivo->foto): ?>
                        <img src="<?php echo e($directivo->foto); ?>" alt="<?php echo e($directivo->nombre); ?>"
                             style="width:44px;height:44px;object-fit:cover;border-radius:50%;display:block;">
                    <?php else: ?>
                        <div style="width:44px;height:44px;background:linear-gradient(135deg,var(--primary),var(--primary-light));border-radius:50%;display:flex;align-items:center;justify-content:center;">
                            <i class="fas fa-user-tie" style="color:white;font-size:18px;"></i>
                        </div>
                    <?php endif; ?>
                </td>
                <td style="font-weight:600;color:var(--dark);font-size:14px;"><?php echo e($directivo->nombre); ?></td>
                <td>
                    <span style="display:inline-flex;align-items:center;gap:6px;background:rgba(139,21,56,0.08);color:var(--primary);padding:4px 12px;border-radius:50px;font-size:12px;font-weight:600;">
                        <i class="fas <?php echo e($directivo->icon); ?>" style="font-size:11px;"></i>
                        <?php echo e($directivo->cargo); ?>

                    </span>
                </td>
                <td style="color:var(--medium-gray);font-size:13px;"><?php echo e($directivo->periodo); ?></td>
                <td style="text-align:center;">
                    <span style="display:inline-block;width:28px;height:28px;background:var(--light-gray);border-radius:6px;text-align:center;line-height:28px;font-size:13px;font-weight:700;color:var(--dark);">
                        <?php echo e($directivo->orden); ?>

                    </span>
                </td>
                <td>
                    <span class="badge <?php echo e($directivo->activo ? 'published' : 'hidden'); ?>">
                        <i class="fas fa-circle" style="font-size:7px;"></i>
                        <?php echo e($directivo->activo ? 'Activo' : 'Inactivo'); ?>

                    </span>
                </td>
                <td>
                    <div style="display:flex;gap:6px;justify-content:center;">
                        <a href="<?php echo e(route('admin.directivos.edit', $directivo)); ?>"
                           style="display:inline-flex;align-items:center;gap:4px;padding:6px 10px;background:var(--warning-light);color:var(--warning);border-radius:var(--radius-sm);font-size:12px;font-weight:600;text-decoration:none;">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <form action="<?php echo e(route('admin.directivos.destroy', $directivo)); ?>" method="POST" style="display:inline;" class="delete-form" id="form-delete-directivo-<?php echo e($directivo->id); ?>">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button type="button"
                                    onclick="confirmDelete('<?php echo e(addslashes($directivo->nombre)); ?>', 'form-delete-directivo-<?php echo e($directivo->id); ?>')"
                                    style="display:inline-flex;align-items:center;padding:6px 10px;background:var(--danger-light);color:var(--danger);border-radius:var(--radius-sm);font-size:12px;border:none;cursor:pointer;">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="8">
                    <div class="empty-state">
                        <i class="fas fa-users-cog"></i>
                        <p>No hay directivos registrados.<br>Agrega los miembros del Consejo Directivo.</p>
                        <a href="<?php echo e(route('admin.directivos.create')); ?>" class="primary-btn" style="display:inline-flex;">
                            <i class="fas fa-plus"></i> Agregar Directivo
                        </a>
                    </div>
                </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
    </div>
</div>


<?php echo e($directivos->links('pagination.admin')); ?>


<div style="margin-top:16px;padding:14px 18px;background:var(--info-light);border-radius:var(--radius-sm);font-size:13px;color:var(--info);display:flex;align-items:center;gap:10px;">
    <i class="fas fa-lightbulb"></i>
    <span>El campo <strong>Orden</strong> controla el orden de aparición en la página pública. Número menor = aparece primero. Ej: Presidente = 1, Vicepresidente = 2, etc.</span>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
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
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\cpap-web\resources\views/admin/directivos/index.blade.php ENDPATH**/ ?>