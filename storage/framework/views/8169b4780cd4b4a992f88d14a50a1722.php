<?php $__env->startSection('title', 'Colegiados'); ?>
<?php $__env->startSection('page-title', 'Gestión de Colegiados'); ?>

<?php $__env->startSection('content'); ?>

<div class="admin-container">

    
    <div class="page-header">
        <div>
            <h1 class="page-title">Colegiados CPAP</h1>
            <p class="page-subtitle">Gestiona los miembros colegiados del CPAP Región Centro</p>
        </div>
        <a href="<?php echo e(route('admin.colegiados.create')); ?>" class="btn btn-primary">
            <i class="fas fa-plus"></i>
            Nuevo Colegiado
        </a>
    </div>

    
    <?php if (isset($component)) { $__componentOriginal692661d59ef467547c37fd97752f8741 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal692661d59ef467547c37fd97752f8741 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin-filters','data' => ['searchPlaceholder' => 'Buscar por DNI, código o nombre...','searchField' => 'q','route' => route('admin.colegiados.index'),'clearRoute' => route('admin.colegiados.index'),'filters' => [
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
        ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin-filters'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['searchPlaceholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Buscar por DNI, código o nombre...'),'searchField' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('q'),'route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.colegiados.index')),'clearRoute' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.colegiados.index')),'filters' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
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

    
    <div class="table-card">
        <?php if($colegiados->count() > 0): ?>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>
                                <a href="<?php echo e(route('admin.colegiados.index', array_merge(request()->query(), ['sort' => 'codigo_cpap', 'order' => $sort === 'codigo_cpap' && $order === 'asc' ? 'desc' : 'asc']))); ?>" class="sortable-header">
                                    N° de Colegiatura
                                    <i class="fas fa-sort<?php echo e($sort === 'codigo_cpap' ? ($order === 'asc' ? '-up' : '-down') : ''); ?>"></i>
                                </a>
                            </th>
                            <th>
                                <a href="<?php echo e(route('admin.colegiados.index', array_merge(request()->query(), ['sort' => 'dni', 'order' => $sort === 'dni' && $order === 'asc' ? 'desc' : 'asc']))); ?>" class="sortable-header">
                                    DNI
                                    <i class="fas fa-sort<?php echo e($sort === 'dni' ? ($order === 'asc' ? '-up' : '-down') : ''); ?>"></i>
                                </a>
                            </th>
                            <th>
                                <a href="<?php echo e(route('admin.colegiados.index', array_merge(request()->query(), ['sort' => 'nombres', 'order' => $sort === 'nombres' && $order === 'asc' ? 'desc' : 'asc']))); ?>" class="sortable-header">
                                    Nombre Completo
                                    <i class="fas fa-sort<?php echo e($sort === 'nombres' ? ($order === 'asc' ? '-up' : '-down') : ''); ?>"></i>
                                </a>
                            </th>
                            <th>
                                <a href="<?php echo e(route('admin.colegiados.index', array_merge(request()->query(), ['sort' => 'especialidad', 'order' => $sort === 'especialidad' && $order === 'asc' ? 'desc' : 'asc']))); ?>" class="sortable-header">
                                    Especialización / Orientación
                                    <i class="fas fa-sort<?php echo e($sort === 'especialidad' ? ($order === 'asc' ? '-up' : '-down') : ''); ?>"></i>
                                </a>
                            </th>
                            <th>
                                <a href="<?php echo e(route('admin.colegiados.index', array_merge(request()->query(), ['sort' => 'estado', 'order' => $sort === 'estado' && $order === 'asc' ? 'desc' : 'asc']))); ?>" class="sortable-header">
                                    Estado
                                    <i class="fas fa-sort<?php echo e($sort === 'estado' ? ($order === 'asc' ? '-up' : '-down') : ''); ?>"></i>
                                </a>
                            </th>
                            <th>
                                <a href="<?php echo e(route('admin.colegiados.index', array_merge(request()->query(), ['sort' => 'fecha_colegiatura', 'order' => $sort === 'fecha_colegiatura' && $order === 'asc' ? 'desc' : 'asc']))); ?>" class="sortable-header">
                                    Fecha Colegiatura
                                    <i class="fas fa-sort<?php echo e($sort === 'fecha_colegiatura' ? ($order === 'asc' ? '-up' : '-down') : ''); ?>"></i>
                                </a>
                            </th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $colegiados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $colegiado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="<?php echo e($colegiado->perfil_oculto ? 'row-perfil-oculto' : ''); ?>">
                                <td>
                                    <strong class="text-primary"><?php echo e($colegiado->codigo_cpap); ?></strong>
                                </td>
                                <td><?php echo e($colegiado->dni); ?></td>
                                <td>
                                    <div class="user-cell">
                                        <?php if($colegiado->foto): ?>
                                            <img src="<?php echo e($colegiado->fotoUrl); ?>" alt="<?php echo e($colegiado->nombre_completo); ?>" class="user-avatar-small">
                                        <?php else: ?>
                                            <div class="user-avatar-small">
                                                <?php echo e(strtoupper(substr($colegiado->nombres, 0, 1) . substr($colegiado->apellidos, 0, 1))); ?>

                                            </div>
                                        <?php endif; ?>
                                        <div>
                                            <span><?php echo e($colegiado->nombre_completo); ?></span>
                                            <?php if($colegiado->perfil_oculto): ?>
                                                <span class="badge-oculto-sm">
                                                    <i class="fas fa-eye-slash"></i> Oculto
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <?php if($colegiado->orientacion): ?>
                                        <span class="text-muted"><?php echo e($colegiado->orientacion); ?></span>
                                        <?php if($colegiado->especialidad): ?>
                                            <br>
                                            <small class="orientacion-sub">
                                                <i class="fas fa-angle-right"></i> <?php echo e($colegiado->especialidad); ?>

                                            </small>
                                        <?php endif; ?>
                                    <?php elseif($colegiado->especialidad): ?>
                                        <span class="text-muted"><?php echo e($colegiado->especialidad); ?></span>
                                    <?php else: ?>
                                        <span class="text-muted fst-italic">No especificada</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($colegiado->estado === 'activo'): ?>
                                        <span class="badge badge-success">
                                            <i class="fas fa-check-circle"></i> ACTIVO
                                        </span>
                                    <?php else: ?>
                                        <span class="badge badge-danger">
                                            <i class="fas fa-times-circle"></i> INACTIVO
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($colegiado->fecha_colegiatura->format('d/m/Y')); ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="<?php echo e(route('admin.colegiados.show', $colegiado)); ?>" class="btn-icon btn-info" title="Ver detalle">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?php echo e(route('admin.colegiados.edit', $colegiado)); ?>" class="btn-icon btn-warning" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        <form action="<?php echo e(route('admin.colegiados.toggle-perfil-oculto', $colegiado)); ?>" method="POST" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PATCH'); ?>
                                            <button type="submit"
                                                    class="btn-icon <?php echo e($colegiado->perfil_oculto ? 'btn-orange' : 'btn-teal'); ?>"
                                                    title="<?php echo e($colegiado->perfil_oculto ? 'Mostrar en directorio público' : 'Ocultar de directorio público'); ?>">
                                                <i class="fas <?php echo e($colegiado->perfil_oculto ? 'fa-eye' : 'fa-eye-slash'); ?>"></i>
                                            </button>
                                        </form>
                                        
                                        <form action="<?php echo e(route('admin.colegiados.toggle-estado', $colegiado)); ?>" method="POST" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PATCH'); ?>
                                            <button type="submit" class="btn-icon <?php echo e($colegiado->estado === 'activo' ? 'btn-success' : 'btn-secondary'); ?>" title="Cambiar estado">
                                                <i class="fas fa-toggle-<?php echo e($colegiado->estado === 'activo' ? 'on' : 'off'); ?>"></i>
                                            </button>
                                        </form>
                                        <form action="<?php echo e(route('admin.colegiados.destroy', $colegiado)); ?>" method="POST" class="d-inline" id="form-delete-<?php echo e($colegiado->id); ?>">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="button"
                                                    class="btn-icon btn-danger"
                                                    title="Eliminar"
                                                    onclick="confirmDeleteColegiado('<?php echo e(addslashes($colegiado->nombre_completo)); ?>', 'form-delete-<?php echo e($colegiado->id); ?>')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

            
            <?php echo e($colegiados->links('pagination.admin')); ?>

        <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-users"></i>
                <h3>No se encontraron colegiados</h3>
                <p><?php echo e(request('buscar') || request('estado') || request('visibilidad') ? 'Intenta con otros filtros de búsqueda.' : 'Comienza agregando el primer colegiado.'); ?></p>
                <?php if(!request()->anyFilled(['buscar', 'estado', 'visibilidad'])): ?>
                    <a href="<?php echo e(route('admin.colegiados.create')); ?>" class="btn btn-primary">
                        <i class="fas fa-plus"></i>
                        Agregar Primer Colegiado
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function confirmDeleteColegiado(nombre, formId) {
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
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\cpap-web\resources\views/admin/colegiados/index.blade.php ENDPATH**/ ?>