<?php $__env->startSection('title', 'Editar Colegiado'); ?>
<?php $__env->startSection('page-title', 'Editar Colegiado'); ?>

<?php $__env->startSection('content'); ?>

<div class="admin-container">

    
    <div class="breadcrumb">
        <a href="<?php echo e(route('admin.colegiados.index')); ?>">
            <i class="fas fa-id-card"></i> Colegiados
        </a>
        <span>/</span>
        <a href="<?php echo e(route('admin.colegiados.show', $colegiado)); ?>"><?php echo e($colegiado->codigo_cpap); ?></a>
        <span>/</span>
        <span>Editar</span>
    </div>

    
    <div class="edit-context-banner">
        <div class="edit-context-banner__avatar">
            <?php if($colegiado->foto): ?>
                <img src="<?php echo e($colegiado->fotoUrl); ?>" alt="<?php echo e($colegiado->nombre_completo); ?>">
            <?php else: ?>
                <div class="edit-context-banner__initials">
                    <?php echo e(strtoupper(substr($colegiado->nombres, 0, 1) . substr($colegiado->apellidos, 0, 1))); ?>

                </div>
            <?php endif; ?>
        </div>
        <div class="edit-context-banner__info">
            <div class="edit-context-banner__label">Editando colegiado</div>
            <h2><?php echo e($colegiado->nombre_completo); ?></h2>
            <div class="edit-context-banner__meta">
                <span><i class="fas fa-id-badge"></i> <?php echo e($colegiado->codigo_cpap); ?></span>
                <span><i class="fas fa-id-card"></i> DNI: <?php echo e($colegiado->dni); ?></span>
                <?php if($colegiado->especialidad): ?>
                    <span><i class="fas fa-graduation-cap"></i> <?php echo e($colegiado->especialidad); ?></span>
                <?php endif; ?>
                <?php if($colegiado->perfil_oculto): ?>
                    <span class="banner-badge-oculto"><i class="fas fa-eye-slash"></i> Perfil oculto</span>
                <?php endif; ?>
            </div>
        </div>
        <div class="edit-context-banner__actions">
            <a href="<?php echo e(route('admin.colegiados.show', $colegiado)); ?>" class="btn btn-sm btn-outline-light">
                <i class="fas fa-eye"></i>
                Ver detalle
            </a>
        </div>
    </div>

    
    <div class="form-card">
        <form action="<?php echo e(route('admin.colegiados.update', $colegiado)); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="form-header">
                <h2><i class="fas fa-edit"></i> Editar Datos del Colegiado</h2>
            </div>

            
            <div class="form-section">
                <h3 class="section-title">Identificación</h3>
                <div class="form-row">
                    <div class="form-group">
                        <label for="codigo_cpap">Número de Colegiatura <span class="required">*</span></label>
                        <input type="text" class="form-control <?php $__errorArgs = ['codigo_cpap'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               id="codigo_cpap" name="codigo_cpap" value="<?php echo e(old('codigo_cpap', $colegiado->codigo_cpap)); ?>"
                               placeholder="CPAP-2026-00001" required>
                        <?php $__errorArgs = ['codigo_cpap'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="form-group">
                        <label for="dni">DNI <span class="required">*</span></label>
                        <input type="text" class="form-control <?php $__errorArgs = ['dni'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               id="dni" name="dni" value="<?php echo e(old('dni', $colegiado->dni)); ?>"
                               placeholder="12345678" maxlength="8" required>
                        <?php $__errorArgs = ['dni'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
            </div>

            
            <div class="form-section">
                <h3 class="section-title">Información Personal</h3>
                <div class="form-row">
                    <div class="form-group">
                        <label for="nombres">Nombres <span class="required">*</span></label>
                        <input type="text" class="form-control <?php $__errorArgs = ['nombres'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               id="nombres" name="nombres" value="<?php echo e(old('nombres', $colegiado->nombres)); ?>" required>
                        <?php $__errorArgs = ['nombres'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="form-group">
                        <label for="apellidos">Apellidos <span class="required">*</span></label>
                        <input type="text" class="form-control <?php $__errorArgs = ['apellidos'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               id="apellidos" name="apellidos" value="<?php echo e(old('apellidos', $colegiado->apellidos)); ?>" required>
                        <?php $__errorArgs = ['apellidos'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               id="email" name="email" value="<?php echo e(old('email', $colegiado->email)); ?>">
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input type="text" class="form-control <?php $__errorArgs = ['telefono'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               id="telefono" name="telefono" value="<?php echo e(old('telefono', $colegiado->telefono)); ?>"
                               placeholder="987654321">
                        <?php $__errorArgs = ['telefono'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                        <input type="date" class="form-control <?php $__errorArgs = ['fecha_nacimiento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               id="fecha_nacimiento" name="fecha_nacimiento"
                               value="<?php echo e(old('fecha_nacimiento', $colegiado->fecha_nacimiento?->format('Y-m-d'))); ?>">
                        <?php $__errorArgs = ['fecha_nacimiento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="form-group">
                        <label for="foto">Foto de Perfil</label>
                        <?php if($colegiado->foto): ?>
                            <div class="current-file-preview">
                                <img src="<?php echo e($colegiado->fotoUrl); ?>" alt="Foto actual">
                                <span class="text-muted">Foto actual</span>
                            </div>
                        <?php endif; ?>
                        <input type="file" class="form-control <?php $__errorArgs = ['foto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               id="foto" name="foto" accept="image/*">
                        <small class="form-text">JPG, JPEG o PNG. Máximo 2MB. Dejar vacío para mantener la actual.</small>
                        <?php $__errorArgs = ['foto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
            </div>

            
            <div class="form-section">
                <h3 class="section-title">Información Profesional</h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="grado_academico">Grado Académico</label>
                        <select class="form-control <?php $__errorArgs = ['grado_academico'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                id="grado_academico" name="grado_academico">
                            <option value="">-- Selecciona --</option>
                            <option value="Bachiller" <?php echo e(old('grado_academico', $colegiado->grado_academico) == 'Bachiller' ? 'selected' : ''); ?>>Bachiller</option>
                            <option value="Licenciado" <?php echo e(old('grado_academico', $colegiado->grado_academico) == 'Licenciado' ? 'selected' : ''); ?>>Licenciado</option>
                            <option value="Magíster" <?php echo e(old('grado_academico', $colegiado->grado_academico) == 'Magíster' ? 'selected' : ''); ?>>Magíster</option>
                            <option value="Doctor" <?php echo e(old('grado_academico', $colegiado->grado_academico) == 'Doctor' ? 'selected' : ''); ?>>Doctor</option>
                        </select>
                        <?php $__errorArgs = ['grado_academico'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="form-group">
                        <label for="orientacion">Orientación</label>
                        <input type="text" class="form-control <?php $__errorArgs = ['orientacion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               id="orientacion" name="orientacion" value="<?php echo e(old('orientacion', $colegiado->orientacion)); ?>"
                               placeholder="Ej: Antropología Cultural">
                        <?php $__errorArgs = ['orientacion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="especialidad">Especialización</label>
                        <input type="text" class="form-control <?php $__errorArgs = ['especialidad'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               id="especialidad" name="especialidad" value="<?php echo e(old('especialidad', $colegiado->especialidad)); ?>"
                               placeholder="Ej: Antropología Social">
                        <?php $__errorArgs = ['especialidad'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="experiencia_anos">Años de Experiencia</label>
                        <input type="number" class="form-control <?php $__errorArgs = ['experiencia_anos'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               id="experiencia_anos" name="experiencia_anos" value="<?php echo e(old('experiencia_anos', $colegiado->experiencia_anos)); ?>"
                               min="0" max="50" placeholder="Ej: 5">
                        <?php $__errorArgs = ['experiencia_anos'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="experiencia_sector">Experiencia en Sector</label>
                        <select class="form-control <?php $__errorArgs = ['experiencia_sector'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                id="experiencia_sector" name="experiencia_sector">
                            <option value="">-- Selecciona --</option>
                            <option value="publica" <?php echo e(old('experiencia_sector', $colegiado->experiencia_sector) == 'publica' ? 'selected' : ''); ?>>Pública</option>
                            <option value="privada" <?php echo e(old('experiencia_sector', $colegiado->experiencia_sector) == 'privada' ? 'selected' : ''); ?>>Privada</option>
                            <option value="mixta" <?php echo e(old('experiencia_sector', $colegiado->experiencia_sector) == 'mixta' ? 'selected' : ''); ?>>Mixta (Pública y Privada)</option>
                        </select>
                        <?php $__errorArgs = ['experiencia_sector'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="form-group">
                        
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="especializacion_detalle">Detalle de la Especialización</label>
                    <textarea class="form-control <?php $__errorArgs = ['especializacion_detalle'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                              id="especializacion_detalle" name="especializacion_detalle" rows="3"
                              placeholder="Describe tu área específica de especialización y enfoque profesional..."><?php echo e(old('especializacion_detalle', $colegiado->especializacion_detalle)); ?></textarea>
                    <?php $__errorArgs = ['especializacion_detalle'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                
                <div class="form-group">
                    <label for="diplomados">Diplomados</label>
                    <textarea class="form-control <?php $__errorArgs = ['diplomados'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                              id="diplomados" name="diplomados" rows="3"
                              placeholder="Lista tus diplomados, cada uno en una línea..."><?php echo e(old('diplomados', $colegiado->diplomados)); ?></textarea>
                    <?php $__errorArgs = ['diplomados'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="universidad">Universidad</label>
                        <input type="text" class="form-control <?php $__errorArgs = ['universidad'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               id="universidad" name="universidad" value="<?php echo e(old('universidad', $colegiado->universidad)); ?>"
                               placeholder="Universidad Nacional Mayor de San Marcos">
                        <?php $__errorArgs = ['universidad'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="form-group">
                        <label for="anio_graduacion">Año de Graduación</label>
                        <input type="number" class="form-control <?php $__errorArgs = ['anio_graduacion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               id="anio_graduacion" name="anio_graduacion" value="<?php echo e(old('anio_graduacion', $colegiado->anio_graduacion)); ?>"
                               min="1950" max="<?php echo e(date('Y')); ?>" placeholder="<?php echo e(date('Y')); ?>">
                        <?php $__errorArgs = ['anio_graduacion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Curriculum Vitae (PDF)</label>
                        <?php if($colegiado->cv_path): ?>
                            <div class="current-file-preview">
                                <i class="fas fa-file-pdf"></i>
                                <span class="text-muted">CV actual cargado</span>
                            </div>
                        <?php endif; ?>
                        <input type="file" class="form-control <?php $__errorArgs = ['cv'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               id="cv" name="cv" accept=".pdf">
                        <small class="form-text">Archivo PDF. Máximo 5MB. Dejar vacío para mantener el actual.</small>
                        <?php $__errorArgs = ['cv'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="form-group">
                        
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="descripcion">Descripción Profesional</label>
                    <textarea class="form-control <?php $__errorArgs = ['descripcion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                              id="descripcion" name="descripcion" rows="4"
                              placeholder="Breve descripción de la experiencia y especialización del colegiado..."><?php echo e(old('descripcion', $colegiado->descripcion)); ?></textarea>
                    <?php $__errorArgs = ['descripcion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            
            <div class="form-section">
                <h3 class="section-title">Estado y Colegiatura</h3>
                <div class="form-row">
                    <div class="form-group">
                        <label for="estado">Estado <span class="required">*</span></label>
                        <select class="form-control <?php $__errorArgs = ['estado'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                id="estado" name="estado" required>
                            <option value="inactivo" <?php echo e(old('estado', $colegiado->estado) == 'inactivo' ? 'selected' : ''); ?>>Inactivo</option>
                            <option value="activo" <?php echo e(old('estado', $colegiado->estado) == 'activo' ? 'selected' : ''); ?>>Activo</option>
                        </select>
                        <?php $__errorArgs = ['estado'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="form-group">
                        <label for="fecha_colegiatura">Fecha de Colegiatura <span class="required">*</span></label>
                        <input type="date" class="form-control <?php $__errorArgs = ['fecha_colegiatura'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               id="fecha_colegiatura" name="fecha_colegiatura"
                               value="<?php echo e(old('fecha_colegiatura', $colegiado->fecha_colegiatura->format('Y-m-d'))); ?>" required>
                        <?php $__errorArgs = ['fecha_colegiatura'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
            </div>

            
            <div class="form-section form-section-visibility">
                <h3 class="section-title">
                    <i class="fas fa-eye-slash"></i>
                    Visibilidad del Perfil
                </h3>
                <p class="section-description">
                    Controla qué información es visible en el directorio público.
                    El administrador siempre puede ver todos los datos.
                </p>

                
                <div class="visibility-toggle-card <?php echo e($colegiado->perfil_oculto ? 'visibility-toggle-card--active' : ''); ?> visibility-toggle-card--danger">
                    <div class="visibility-toggle-card__icon">
                        <i class="fas fa-user-slash"></i>
                    </div>
                    <div class="visibility-toggle-card__info">
                        <strong>Ocultar perfil del directorio público</strong>
                        <span>El colegiado no aparecerá en la búsqueda ni en el listado público. Solo visible desde el panel de administración.</span>
                    </div>
                    <div class="visibility-toggle-card__control">
                        <label class="toggle-switch">
                            <input type="checkbox" name="perfil_oculto" value="1"
                                   <?php echo e(old('perfil_oculto', $colegiado->perfil_oculto) ? 'checked' : ''); ?>>
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                </div>

                
                <div class="vis-groups-container">

                    
                    <div class="vis-group">
                        <p class="vis-group-label"><i class="fas fa-image"></i> Presentación visual</p>
                        <div class="visibility-fields-grid">
                            <div class="visibility-field-item <?php echo e($colegiado->ocultar_foto ? 'visibility-field-item--hidden' : ''); ?>">
                                <label class="visibility-field-label">
                                    <div class="visibility-field-label__icon"><i class="fas fa-user-circle"></i></div>
                                    <div class="visibility-field-label__text">
                                        <strong>Foto de perfil</strong>
                                        <span><?php echo e($colegiado->ocultar_foto ? 'Oculta en perfil público' : 'Visible en perfil público'); ?></span>
                                    </div>
                                    <label class="toggle-switch toggle-switch--sm">
                                        <input type="checkbox" name="ocultar_foto" value="1" <?php echo e(old('ocultar_foto', $colegiado->ocultar_foto) ? 'checked' : ''); ?>>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </label>
                            </div>
                        </div>
                    </div>

                    
                    <div class="vis-group">
                        <p class="vis-group-label"><i class="fas fa-address-book"></i> Datos de contacto</p>
                        <div class="visibility-fields-grid">
                            <div class="visibility-field-item <?php echo e($colegiado->ocultar_email ? 'visibility-field-item--hidden' : ''); ?>">
                                <label class="visibility-field-label">
                                    <div class="visibility-field-label__icon"><i class="fas fa-envelope"></i></div>
                                    <div class="visibility-field-label__text">
                                        <strong>Correo electrónico</strong>
                                        <span><?php echo e($colegiado->ocultar_email ? 'Oculto en perfil público' : 'Visible en perfil público'); ?></span>
                                    </div>
                                    <label class="toggle-switch toggle-switch--sm">
                                        <input type="checkbox" name="ocultar_email" value="1" <?php echo e(old('ocultar_email', $colegiado->ocultar_email) ? 'checked' : ''); ?>>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </label>
                            </div>
                            <div class="visibility-field-item <?php echo e($colegiado->ocultar_telefono ? 'visibility-field-item--hidden' : ''); ?>">
                                <label class="visibility-field-label">
                                    <div class="visibility-field-label__icon"><i class="fas fa-phone"></i></div>
                                    <div class="visibility-field-label__text">
                                        <strong>Teléfono</strong>
                                        <span><?php echo e($colegiado->ocultar_telefono ? 'Oculto en perfil público' : 'Visible en perfil público'); ?></span>
                                    </div>
                                    <label class="toggle-switch toggle-switch--sm">
                                        <input type="checkbox" name="ocultar_telefono" value="1" <?php echo e(old('ocultar_telefono', $colegiado->ocultar_telefono) ? 'checked' : ''); ?>>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </label>
                            </div>
                        </div>
                    </div>

                    
                    <div class="vis-group">
                        <p class="vis-group-label"><i class="fas fa-graduation-cap"></i> Información académica y profesional</p>
                        <div class="visibility-fields-grid">
                            <div class="visibility-field-item <?php echo e($colegiado->ocultar_grado_academico ? 'visibility-field-item--hidden' : ''); ?>">
                                <label class="visibility-field-label">
                                    <div class="visibility-field-label__icon"><i class="fas fa-user-graduate"></i></div>
                                    <div class="visibility-field-label__text">
                                        <strong>Grado académico</strong>
                                        <span><?php echo e($colegiado->ocultar_grado_academico ? 'Oculto en perfil público' : 'Visible en perfil público'); ?></span>
                                    </div>
                                    <label class="toggle-switch toggle-switch--sm">
                                        <input type="checkbox" name="ocultar_grado_academico" value="1" <?php echo e(old('ocultar_grado_academico', $colegiado->ocultar_grado_academico) ? 'checked' : ''); ?>>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </label>
                            </div>
                            <div class="visibility-field-item <?php echo e($colegiado->ocultar_especialidad ? 'visibility-field-item--hidden' : ''); ?>">
                                <label class="visibility-field-label">
                                    <div class="visibility-field-label__icon"><i class="fas fa-flask"></i></div>
                                    <div class="visibility-field-label__text">
                                        <strong>Especialización</strong>
                                        <span><?php echo e($colegiado->ocultar_especialidad ? 'Oculta en perfil público' : 'Visible en perfil público'); ?></span>
                                    </div>
                                    <label class="toggle-switch toggle-switch--sm">
                                        <input type="checkbox" name="ocultar_especialidad" value="1" <?php echo e(old('ocultar_especialidad', $colegiado->ocultar_especialidad) ? 'checked' : ''); ?>>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </label>
                            </div>
                            <div class="visibility-field-item <?php echo e($colegiado->ocultar_especializacion_detalle ? 'visibility-field-item--hidden' : ''); ?>">
                                <label class="visibility-field-label">
                                    <div class="visibility-field-label__icon"><i class="fas fa-list-ul"></i></div>
                                    <div class="visibility-field-label__text">
                                        <strong>Detalle de especialización</strong>
                                        <span><?php echo e($colegiado->ocultar_especializacion_detalle ? 'Oculto en perfil público' : 'Visible en perfil público'); ?></span>
                                    </div>
                                    <label class="toggle-switch toggle-switch--sm">
                                        <input type="checkbox" name="ocultar_especializacion_detalle" value="1" <?php echo e(old('ocultar_especializacion_detalle', $colegiado->ocultar_especializacion_detalle) ? 'checked' : ''); ?>>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </label>
                            </div>
                            <div class="visibility-field-item <?php echo e($colegiado->ocultar_orientacion ? 'visibility-field-item--hidden' : ''); ?>">
                                <label class="visibility-field-label">
                                    <div class="visibility-field-label__icon"><i class="fas fa-compass"></i></div>
                                    <div class="visibility-field-label__text">
                                        <strong>Orientación</strong>
                                        <span><?php echo e($colegiado->ocultar_orientacion ? 'Oculta en perfil público' : 'Visible en perfil público'); ?></span>
                                    </div>
                                    <label class="toggle-switch toggle-switch--sm">
                                        <input type="checkbox" name="ocultar_orientacion" value="1" <?php echo e(old('ocultar_orientacion', $colegiado->ocultar_orientacion) ? 'checked' : ''); ?>>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </label>
                            </div>
                            <div class="visibility-field-item <?php echo e($colegiado->ocultar_diplomados ? 'visibility-field-item--hidden' : ''); ?>">
                                <label class="visibility-field-label">
                                    <div class="visibility-field-label__icon"><i class="fas fa-certificate"></i></div>
                                    <div class="visibility-field-label__text">
                                        <strong>Diplomados</strong>
                                        <span><?php echo e($colegiado->ocultar_diplomados ? 'Ocultos en perfil público' : 'Visibles en perfil público'); ?></span>
                                    </div>
                                    <label class="toggle-switch toggle-switch--sm">
                                        <input type="checkbox" name="ocultar_diplomados" value="1" <?php echo e(old('ocultar_diplomados', $colegiado->ocultar_diplomados) ? 'checked' : ''); ?>>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </label>
                            </div>
                            <div class="visibility-field-item <?php echo e($colegiado->ocultar_experiencia ? 'visibility-field-item--hidden' : ''); ?>">
                                <label class="visibility-field-label">
                                    <div class="visibility-field-label__icon"><i class="fas fa-briefcase"></i></div>
                                    <div class="visibility-field-label__text">
                                        <strong>Experiencia profesional</strong>
                                        <span><?php echo e($colegiado->ocultar_experiencia ? 'Oculta en perfil público' : 'Visible en perfil público'); ?></span>
                                    </div>
                                    <label class="toggle-switch toggle-switch--sm">
                                        <input type="checkbox" name="ocultar_experiencia" value="1" <?php echo e(old('ocultar_experiencia', $colegiado->ocultar_experiencia) ? 'checked' : ''); ?>>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </label>
                            </div>
                            <div class="visibility-field-item <?php echo e($colegiado->ocultar_universidad ? 'visibility-field-item--hidden' : ''); ?>">
                                <label class="visibility-field-label">
                                    <div class="visibility-field-label__icon"><i class="fas fa-university"></i></div>
                                    <div class="visibility-field-label__text">
                                        <strong>Universidad</strong>
                                        <span><?php echo e($colegiado->ocultar_universidad ? 'Oculta en perfil público' : 'Visible en perfil público'); ?></span>
                                    </div>
                                    <label class="toggle-switch toggle-switch--sm">
                                        <input type="checkbox" name="ocultar_universidad" value="1" <?php echo e(old('ocultar_universidad', $colegiado->ocultar_universidad) ? 'checked' : ''); ?>>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </label>
                            </div>
                            <div class="visibility-field-item <?php echo e($colegiado->ocultar_anio_graduacion ? 'visibility-field-item--hidden' : ''); ?>">
                                <label class="visibility-field-label">
                                    <div class="visibility-field-label__icon"><i class="fas fa-calendar-check"></i></div>
                                    <div class="visibility-field-label__text">
                                        <strong>Año de graduación</strong>
                                        <span><?php echo e($colegiado->ocultar_anio_graduacion ? 'Oculto en perfil público' : 'Visible en perfil público'); ?></span>
                                    </div>
                                    <label class="toggle-switch toggle-switch--sm">
                                        <input type="checkbox" name="ocultar_anio_graduacion" value="1" <?php echo e(old('ocultar_anio_graduacion', $colegiado->ocultar_anio_graduacion) ? 'checked' : ''); ?>>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </label>
                            </div>
                            <div class="visibility-field-item <?php echo e($colegiado->ocultar_fecha_colegiatura ? 'visibility-field-item--hidden' : ''); ?>">
                                <label class="visibility-field-label">
                                    <div class="visibility-field-label__icon"><i class="fas fa-id-card"></i></div>
                                    <div class="visibility-field-label__text">
                                        <strong>Fecha de colegiatura</strong>
                                        <span><?php echo e($colegiado->ocultar_fecha_colegiatura ? 'Oculta en perfil público' : 'Visible en perfil público'); ?></span>
                                    </div>
                                    <label class="toggle-switch toggle-switch--sm">
                                        <input type="checkbox" name="ocultar_fecha_colegiatura" value="1" <?php echo e(old('ocultar_fecha_colegiatura', $colegiado->ocultar_fecha_colegiatura) ? 'checked' : ''); ?>>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </label>
                            </div>
                        </div>
                    </div>

                    
                    <div class="vis-group">
                        <p class="vis-group-label"><i class="fas fa-file-alt"></i> Descripción y documentos</p>
                        <div class="visibility-fields-grid">
                            <div class="visibility-field-item <?php echo e($colegiado->ocultar_descripcion ? 'visibility-field-item--hidden' : ''); ?>">
                                <label class="visibility-field-label">
                                    <div class="visibility-field-label__icon"><i class="fas fa-align-left"></i></div>
                                    <div class="visibility-field-label__text">
                                        <strong>Descripción profesional</strong>
                                        <span><?php echo e($colegiado->ocultar_descripcion ? 'Oculta en perfil público' : 'Visible en perfil público'); ?></span>
                                    </div>
                                    <label class="toggle-switch toggle-switch--sm">
                                        <input type="checkbox" name="ocultar_descripcion" value="1" <?php echo e(old('ocultar_descripcion', $colegiado->ocultar_descripcion) ? 'checked' : ''); ?>>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </label>
                            </div>
                            <div class="visibility-field-item <?php echo e($colegiado->ocultar_cv ? 'visibility-field-item--hidden' : ''); ?>">
                                <label class="visibility-field-label">
                                    <div class="visibility-field-label__icon"><i class="fas fa-file-pdf"></i></div>
                                    <div class="visibility-field-label__text">
                                        <strong>Curriculum Vitae</strong>
                                        <span><?php echo e($colegiado->ocultar_cv ? 'Oculto en perfil público' : 'Visible en perfil público'); ?></span>
                                    </div>
                                    <label class="toggle-switch toggle-switch--sm">
                                        <input type="checkbox" name="ocultar_cv" value="1" <?php echo e(old('ocultar_cv', $colegiado->ocultar_cv) ? 'checked' : ''); ?>>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </label>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="visibility-note">
                    <i class="fas fa-info-circle"></i>
                    <span>
                        <strong>Nota:</strong> Para aparecer en el directorio público, el colegiado también
                        debe tener un <strong>documento de habilitación activo</strong>. Sin habilitación,
                        el perfil no se muestra aunque esté visible.
                    </span>
                </div>
            </div>

            
            <div class="form-footer">
                <a href="<?php echo e(route('admin.colegiados.show', $colegiado)); ?>" class="btn btn-secondary">
                    <i class="fas fa-times"></i>
                    Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    Actualizar Colegiado
                </button>
            </div>
        </form>
    </div>

</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\cpap-web\resources\views/admin/colegiados/edit.blade.php ENDPATH**/ ?>