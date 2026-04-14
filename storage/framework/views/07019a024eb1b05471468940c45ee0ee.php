
<?php $buscar = trim($buscar ?? ''); ?>

<?php if($colegiados->total() === 0): ?>

    <div class="no-results">
        <div class="no-results-icon">
            <i class="fas fa-user-slash"></i>
        </div>
        <?php if($buscar): ?>
            <h3>No se encontró ningún colegiado<br>para <em>"<?php echo e($buscar); ?>"</em></h3>
            <p>Prueba con el DNI completo, apellidos o número de colegiatura exacto.</p>
        <?php else: ?>
            <h3>No se encontraron colegiados</h3>
            <p>No hay registros que coincidan con los filtros seleccionados.</p>
        <?php endif; ?>
        <a href="<?php echo e(route('colegiados.index')); ?>" class="btn btn-primary">
            <i class="fas fa-list"></i> Ver todos los colegiados
        </a>
    </div>

<?php else: ?>

    <div class="colegiados-grid">
        <?php $__currentLoopData = $colegiados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $colegiado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('colegiados.show', $colegiado)); ?>"
               class="colegiado-card"
               data-aos="fade-up"
               data-aos-delay="<?php echo e(min(($index % 4) * 80, 300)); ?>">

                <div class="card-header-bg">
                    <div class="card-avatar-wrapper">
                        <?php if($colegiado->foto && !$colegiado->ocultar_foto): ?>
                            <img src="<?php echo e($colegiado->foto_url); ?>"
                                 alt="<?php echo e($colegiado->nombre_completo); ?>"
                                 class="card-avatar">
                        <?php else: ?>
                            <div class="card-avatar-placeholder">
                                <?php echo e(strtoupper(substr($colegiado->nombres, 0, 1) . substr($colegiado->apellidos, 0, 1))); ?>

                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="card-body">
                    <div class="card-name"><?php echo e($colegiado->nombre_completo); ?></div>
                    <div class="card-code"><?php echo e($colegiado->codigo_cpap); ?></div>
                    <?php
                        $mostrarOrientacion = $colegiado->orientacion && !$colegiado->ocultar_orientacion;
                        $mostrarEspecialidad = $colegiado->especialidad && !$colegiado->ocultar_especialidad;
                    ?>
                    <div class="card-specialty">
                        <?php if($mostrarOrientacion): ?>
                            <?php echo e($colegiado->orientacion); ?>

                            <?php if($mostrarEspecialidad): ?>
                                <br><small style="opacity:0.75; font-size:11px;"><?php echo e($colegiado->especialidad); ?></small>
                            <?php endif; ?>
                        <?php elseif($mostrarEspecialidad): ?>
                            <?php echo e($colegiado->especialidad); ?>

                        <?php else: ?>
                            Antropólogo Profesional
                        <?php endif; ?>
                    </div>
                    <div>
                        <?php if($colegiado->estado === 'activo'): ?>
                            <span class="estado-badge activo">
                                <i class="fas fa-circle" style="font-size:7px;"></i>
                                HABILITADO
                            </span>
                        <?php else: ?>
                            <span class="estado-badge inactivo">
                                <i class="fas fa-circle" style="font-size:7px;"></i>
                                NO HABILITADO
                            </span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="card-footer-action">
                    <i class="fas fa-eye"></i>
                    Ver Perfil
                </div>
            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <?php if($colegiados->hasPages()): ?>
        <div class="pagination-wrapper">
            <?php echo e($colegiados->links()); ?>

        </div>
    <?php endif; ?>

<?php endif; ?>
<?php /**PATH C:\laragon\www\cpap-web\resources\views/colegiados/_grid.blade.php ENDPATH**/ ?>