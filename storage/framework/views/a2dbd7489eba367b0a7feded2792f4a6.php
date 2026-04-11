<?php $__env->startSection('title', 'Detalle del Colegiado'); ?>
<?php $__env->startSection('page-title', 'Detalle del Colegiado'); ?>

<?php $__env->startSection('content'); ?>

<div class="admin-container">

    
    <?php if(session('success')): ?>
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            <div class="alert-body">
                <?php echo e(session('success')); ?>


                <?php if(session('codigo_generado')): ?>
                    <div class="alert-code-block">
                        <div class="alert-code-row">
                            <span class="alert-code-label">Código de verificación:</span>
                            <code><?php echo e(session('codigo_generado')); ?></code>
                        </div>
                        <div class="alert-code-row">
                            <span class="alert-code-label">URL de verificación:</span>
                            <a href="<?php echo e(session('url_verificacion')); ?>" target="_blank"><?php echo e(session('url_verificacion')); ?></a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    
    <div class="breadcrumb">
        <a href="<?php echo e(route('admin.colegiados.index')); ?>">
            <i class="fas fa-id-card"></i> Colegiados
        </a>
        <span>/</span>
        <span><?php echo e($colegiado->codigo_cpap); ?></span>
    </div>

    
    <div class="page-header">
        <div>
            <h1 class="page-title">
                <?php echo e($colegiado->nombre_completo); ?>

                <?php if($colegiado->perfil_oculto): ?>
                    <span class="badge-perfil-oculto">
                        <i class="fas fa-eye-slash"></i> Oculto
                    </span>
                <?php endif; ?>
            </h1>
            <p class="page-subtitle"><?php echo e($colegiado->codigo_cpap); ?> &mdash; <?php echo e($colegiado->dni); ?></p>
        </div>
        <div class="action-header-buttons">
            
            <form action="<?php echo e(route('admin.colegiados.toggle-perfil-oculto', $colegiado)); ?>" method="POST" class="d-inline">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PATCH'); ?>
                <button type="submit"
                        class="btn btn-lg <?php echo e($colegiado->perfil_oculto ? 'btn-outline-warning' : 'btn-outline-secondary'); ?>"
                        title="<?php echo e($colegiado->perfil_oculto ? 'Hacer visible en directorio público' : 'Ocultar del directorio público'); ?>">
                    <i class="fas <?php echo e($colegiado->perfil_oculto ? 'fa-eye' : 'fa-eye-slash'); ?>"></i>
                    <?php echo e($colegiado->perfil_oculto ? 'Mostrar en público' : 'Ocultar de público'); ?>

                </button>
            </form>
            <a href="<?php echo e(route('admin.colegiados.edit', $colegiado)); ?>" class="btn btn-lg btn-secondary-outline">
                <i class="fas fa-pencil-alt"></i>
                Editar
            </a>
            <a href="<?php echo e(route('admin.habilitaciones.create', $colegiado)); ?>" class="btn btn-lg btn-primary">
                <i class="fas fa-certificate"></i>
                Subir Habilitación
            </a>
        </div>
    </div>

    
    <?php if(!$tieneAlgunaHabilitacion): ?>
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle"></i>
            <div class="alert-body">
                <strong>Sin habilitación activa.</strong>
                Este colegiado no tiene ningún documento de habilitación activo.
                No aparecerá en el directorio público hasta que se suba y active un documento.
                <a href="<?php echo e(route('admin.habilitaciones.create', $colegiado)); ?>" class="alert-link">
                    Subir habilitación →
                </a>
            </div>
        </div>
    
    <?php elseif(!$tieneHabilitacionActiva): ?>
        <div class="alert alert-warning">
            <i class="fas fa-ban"></i>
            <div class="alert-body">
                <strong>Habilitación revocada.</strong>
                El documento de habilitación fue revocado. El colegiado aparece en el directorio público como <strong>No Habilitado</strong>.
                Para reactivarlo, usa el botón <em>Reactivar</em> en la sección de habilitaciones, o sube un nuevo documento.
            </div>
        </div>
    <?php endif; ?>

    
    <div class="visibility-summary-panel <?php echo e($colegiado->perfil_oculto ? 'visibility-summary-panel--oculto' : 'visibility-summary-panel--visible'); ?>">
        <div class="visibility-summary-panel__icon">
            <i class="fas <?php echo e($colegiado->perfil_oculto ? 'fa-eye-slash' : 'fa-eye'); ?>"></i>
        </div>
        <div class="visibility-summary-panel__info">
            <strong><?php echo e($colegiado->perfil_oculto ? 'Perfil oculto del directorio público' : 'Perfil visible en el directorio público'); ?></strong>
            <div class="visibility-summary-badges">
                <?php if($colegiado->foto): ?>
                    <span class="vis-badge <?php echo e($colegiado->ocultar_foto ? 'vis-badge--hidden' : 'vis-badge--visible'); ?>">
                        <i class="fas fa-user-circle"></i>
                        Foto <?php echo e($colegiado->ocultar_foto ? 'oculta' : 'visible'); ?>

                    </span>
                <?php endif; ?>
                <?php if($colegiado->email): ?>
                    <span class="vis-badge <?php echo e($colegiado->ocultar_email ? 'vis-badge--hidden' : 'vis-badge--visible'); ?>">
                        <i class="fas fa-envelope"></i>
                        Email <?php echo e($colegiado->ocultar_email ? 'oculto' : 'visible'); ?>

                    </span>
                <?php endif; ?>
                <?php if($colegiado->telefono): ?>
                    <span class="vis-badge <?php echo e($colegiado->ocultar_telefono ? 'vis-badge--hidden' : 'vis-badge--visible'); ?>">
                        <i class="fas fa-phone"></i>
                        Teléfono <?php echo e($colegiado->ocultar_telefono ? 'oculto' : 'visible'); ?>

                    </span>
                <?php endif; ?>
                <?php if($colegiado->grado_academico): ?>
                    <span class="vis-badge <?php echo e($colegiado->ocultar_grado_academico ? 'vis-badge--hidden' : 'vis-badge--visible'); ?>">
                        <i class="fas fa-user-graduate"></i>
                        Grado <?php echo e($colegiado->ocultar_grado_academico ? 'oculto' : 'visible'); ?>

                    </span>
                <?php endif; ?>
                <?php if($colegiado->orientacion): ?>
                    <span class="vis-badge <?php echo e($colegiado->ocultar_orientacion ? 'vis-badge--hidden' : 'vis-badge--visible'); ?>">
                        <i class="fas fa-compass"></i>
                        Orientación <?php echo e($colegiado->ocultar_orientacion ? 'oculta' : 'visible'); ?>

                    </span>
                <?php endif; ?>
                <?php if($colegiado->especialidad): ?>
                    <span class="vis-badge <?php echo e($colegiado->ocultar_especialidad ? 'vis-badge--hidden' : 'vis-badge--visible'); ?>">
                        <i class="fas fa-flask"></i>
                        Especialización <?php echo e($colegiado->ocultar_especialidad ? 'oculta' : 'visible'); ?>

                    </span>
                <?php endif; ?>
                <?php if($colegiado->diplomados): ?>
                    <span class="vis-badge <?php echo e($colegiado->ocultar_diplomados ? 'vis-badge--hidden' : 'vis-badge--visible'); ?>">
                        <i class="fas fa-certificate"></i>
                        Diplomados <?php echo e($colegiado->ocultar_diplomados ? 'ocultos' : 'visibles'); ?>

                    </span>
                <?php endif; ?>
                <?php if($colegiado->experiencia_anos || $colegiado->experiencia_sector): ?>
                    <span class="vis-badge <?php echo e($colegiado->ocultar_experiencia ? 'vis-badge--hidden' : 'vis-badge--visible'); ?>">
                        <i class="fas fa-briefcase"></i>
                        Experiencia <?php echo e($colegiado->ocultar_experiencia ? 'oculta' : 'visible'); ?>

                    </span>
                <?php endif; ?>
                <?php if($colegiado->universidad): ?>
                    <span class="vis-badge <?php echo e($colegiado->ocultar_universidad ? 'vis-badge--hidden' : 'vis-badge--visible'); ?>">
                        <i class="fas fa-university"></i>
                        Universidad <?php echo e($colegiado->ocultar_universidad ? 'oculta' : 'visible'); ?>

                    </span>
                <?php endif; ?>
                <?php if($colegiado->anio_graduacion): ?>
                    <span class="vis-badge <?php echo e($colegiado->ocultar_anio_graduacion ? 'vis-badge--hidden' : 'vis-badge--visible'); ?>">
                        <i class="fas fa-calendar-check"></i>
                        Año grad. <?php echo e($colegiado->ocultar_anio_graduacion ? 'oculto' : 'visible'); ?>

                    </span>
                <?php endif; ?>
                <?php if($colegiado->fecha_colegiatura): ?>
                    <span class="vis-badge <?php echo e($colegiado->ocultar_fecha_colegiatura ? 'vis-badge--hidden' : 'vis-badge--visible'); ?>">
                        <i class="fas fa-id-card"></i>
                        F. colegiatura <?php echo e($colegiado->ocultar_fecha_colegiatura ? 'oculta' : 'visible'); ?>

                    </span>
                <?php endif; ?>
                <?php if($colegiado->descripcion): ?>
                    <span class="vis-badge <?php echo e($colegiado->ocultar_descripcion ? 'vis-badge--hidden' : 'vis-badge--visible'); ?>">
                        <i class="fas fa-align-left"></i>
                        Descripción <?php echo e($colegiado->ocultar_descripcion ? 'oculta' : 'visible'); ?>

                    </span>
                <?php endif; ?>
                <?php if($colegiado->cv_path): ?>
                    <span class="vis-badge <?php echo e($colegiado->ocultar_cv ? 'vis-badge--hidden' : 'vis-badge--visible'); ?>">
                        <i class="fas fa-file-pdf"></i>
                        CV <?php echo e($colegiado->ocultar_cv ? 'oculto' : 'visible'); ?>

                    </span>
                <?php endif; ?>
            </div>
        </div>
        <a href="<?php echo e(route('admin.colegiados.edit', $colegiado)); ?>#visibilidad" class="btn btn-sm btn-outline-secondary">
            <i class="fas fa-sliders-h"></i>
            Cambiar visibilidad
        </a>
    </div>

    
    <div class="detail-grid">

        
        <div class="detail-card">
            <div class="card-header">
                <h3><i class="fas fa-user"></i> Información Personal</h3>
            </div>
            <div class="card-body">
                <?php if($colegiado->foto): ?>
                    <div class="profile-photo">
                        <img src="<?php echo e($colegiado->fotoUrl); ?>" alt="<?php echo e($colegiado->nombre_completo); ?>">
                        <?php if($colegiado->ocultar_foto): ?>
                            <div style="margin-top:6px;">
                                <span class="field-hidden-indicator" title="Foto oculta en perfil público">
                                    <i class="fas fa-eye-slash"></i> Foto oculta en público
                                </span>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <div class="info-group">
                    <label>Nombres completos</label>
                    <p><?php echo e($colegiado->nombres); ?> <?php echo e($colegiado->apellidos); ?></p>
                </div>

                <div class="info-group">
                    <label>DNI</label>
                    <p><?php echo e($colegiado->dni); ?></p>
                </div>

                <?php if($colegiado->email): ?>
                    <div class="info-group">
                        <label>
                            Email
                            <?php if($colegiado->ocultar_email): ?>
                                <span class="field-hidden-indicator" title="Oculto en perfil público">
                                    <i class="fas fa-eye-slash"></i>
                                </span>
                            <?php endif; ?>
                        </label>
                        <p><a href="mailto:<?php echo e($colegiado->email); ?>"><?php echo e($colegiado->email); ?></a></p>
                    </div>
                <?php endif; ?>

                <?php if($colegiado->telefono): ?>
                    <div class="info-group">
                        <label>
                            Teléfono
                            <?php if($colegiado->ocultar_telefono): ?>
                                <span class="field-hidden-indicator" title="Oculto en perfil público">
                                    <i class="fas fa-eye-slash"></i>
                                </span>
                            <?php endif; ?>
                        </label>
                        <p><a href="tel:<?php echo e($colegiado->telefono); ?>"><?php echo e($colegiado->telefono); ?></a></p>
                    </div>
                <?php endif; ?>

                <?php if($colegiado->fecha_nacimiento): ?>
                    <div class="info-group">
                        <label>Fecha de Nacimiento</label>
                        <p><?php echo e($colegiado->fecha_nacimiento->format('d/m/Y')); ?></p>
                    </div>
                <?php endif; ?>

                <div class="info-group">
                    <label>Estado</label>
                    <p>
                        <?php if($colegiado->estado === 'activo'): ?>
                            <span class="badge badge-success">
                                <i class="fas fa-check-circle"></i> ACTIVO
                            </span>
                        <?php else: ?>
                            <span class="badge badge-danger">
                                <i class="fas fa-times-circle"></i> INACTIVO
                            </span>
                        <?php endif; ?>
                    </p>
                </div>

                <div class="info-group">
                    <label>
                        Fecha de Colegiatura
                        <?php if($colegiado->ocultar_fecha_colegiatura): ?>
                            <span class="field-hidden-indicator" title="Oculto en perfil público">
                                <i class="fas fa-eye-slash"></i>
                            </span>
                        <?php endif; ?>
                    </label>
                    <p><?php echo e($colegiado->fecha_colegiatura->format('d/m/Y')); ?></p>
                </div>
            </div>
        </div>

        
        <div class="detail-card">
            <div class="card-header">
                <h3><i class="fas fa-briefcase"></i> Información Profesional</h3>
            </div>
            <div class="card-body">
                <?php if($colegiado->grado_academico): ?>
                    <div class="info-group">
                        <label>
                            Grado Académico
                            <?php if($colegiado->ocultar_grado_academico): ?>
                                <span class="field-hidden-indicator" title="Oculto en perfil público">
                                    <i class="fas fa-eye-slash"></i>
                                </span>
                            <?php endif; ?>
                        </label>
                        <p><?php echo e($colegiado->grado_academico); ?></p>
                    </div>
                <?php endif; ?>

                <?php if($colegiado->orientacion): ?>
                    <div class="info-group">
                        <label>
                            Orientación
                            <?php if($colegiado->ocultar_orientacion): ?>
                                <span class="field-hidden-indicator" title="Oculto en perfil público">
                                    <i class="fas fa-eye-slash"></i>
                                </span>
                            <?php endif; ?>
                        </label>
                        <p><?php echo e($colegiado->orientacion); ?></p>
                    </div>
                <?php endif; ?>

                <?php if($colegiado->especialidad): ?>
                    <div class="info-group">
                        <label>
                            Especialización
                            <?php if($colegiado->ocultar_especialidad): ?>
                                <span class="field-hidden-indicator" title="Oculto en perfil público">
                                    <i class="fas fa-eye-slash"></i>
                                </span>
                            <?php endif; ?>
                        </label>
                        <p><?php echo e($colegiado->especialidad); ?></p>
                    </div>
                <?php endif; ?>

                <?php if($colegiado->especializacion_detalle): ?>
                    <div class="info-group">
                        <label>
                            Detalle de la Especialización
                            <?php if($colegiado->ocultar_especializacion_detalle): ?>
                                <span class="field-hidden-indicator" title="Oculto en perfil público">
                                    <i class="fas fa-eye-slash"></i>
                                </span>
                            <?php endif; ?>
                        </label>
                        <p style="white-space: pre-line;"><?php echo e($colegiado->especializacion_detalle); ?></p>
                    </div>
                <?php endif; ?>

                <?php if($colegiado->diplomados): ?>
                    <div class="info-group">
                        <label>
                            Diplomados
                            <?php if($colegiado->ocultar_diplomados): ?>
                                <span class="field-hidden-indicator" title="Oculto en perfil público">
                                    <i class="fas fa-eye-slash"></i>
                                </span>
                            <?php endif; ?>
                        </label>
                        <p style="white-space: pre-line;"><?php echo e($colegiado->diplomados); ?></p>
                    </div>
                <?php endif; ?>

                <?php if($colegiado->experiencia_anos || $colegiado->experiencia_sector): ?>
                    <div class="info-group">
                        <label>
                            Experiencia Profesional
                            <?php if($colegiado->ocultar_experiencia): ?>
                                <span class="field-hidden-indicator" title="Oculto en perfil público">
                                    <i class="fas fa-eye-slash"></i>
                                </span>
                            <?php endif; ?>
                        </label>
                        <p>
                            <?php if($colegiado->experiencia_anos): ?>
                                <strong><?php echo e($colegiado->experiencia_anos); ?> años</strong>
                            <?php endif; ?>
                            <?php if($colegiado->experiencia_sector): ?>
                                <?php if($colegiado->experiencia_anos): ?> en sector <?php endif; ?>
                                <span class="badge badge-info">
                                    <?php if($colegiado->experiencia_sector === 'publica'): ?>
                                        <i class="fas fa-landmark"></i> Público
                                    <?php elseif($colegiado->experiencia_sector === 'privada'): ?>
                                        <i class="fas fa-building"></i> Privado
                                    <?php else: ?>
                                        <i class="fas fa-briefcase"></i> Mixto
                                    <?php endif; ?>
                                </span>
                            <?php endif; ?>
                        </p>
                    </div>
                <?php endif; ?>

                <?php if($colegiado->universidad): ?>
                    <div class="info-group">
                        <label>
                            Universidad
                            <?php if($colegiado->ocultar_universidad): ?>
                                <span class="field-hidden-indicator" title="Oculto en perfil público">
                                    <i class="fas fa-eye-slash"></i>
                                </span>
                            <?php endif; ?>
                        </label>
                        <p><?php echo e($colegiado->universidad); ?></p>
                    </div>
                <?php endif; ?>

                <?php if($colegiado->anio_graduacion): ?>
                    <div class="info-group">
                        <label>
                            Año de Graduación
                            <?php if($colegiado->ocultar_anio_graduacion): ?>
                                <span class="field-hidden-indicator" title="Oculto en perfil público">
                                    <i class="fas fa-eye-slash"></i>
                                </span>
                            <?php endif; ?>
                        </label>
                        <p><?php echo e($colegiado->anio_graduacion); ?></p>
                    </div>
                <?php endif; ?>

                <?php if($colegiado->descripcion): ?>
                    <div class="info-group">
                        <label>
                            Descripción Profesional
                            <?php if($colegiado->ocultar_descripcion): ?>
                                <span class="field-hidden-indicator" title="Oculto en perfil público">
                                    <i class="fas fa-eye-slash"></i>
                                </span>
                            <?php endif; ?>
                        </label>
                        <p><?php echo e($colegiado->descripcion); ?></p>
                    </div>
                <?php endif; ?>

                <?php if($colegiado->cv_path): ?>
                    <div class="info-group">
                        <label>
                            Curriculum Vitae
                            <?php if($colegiado->ocultar_cv): ?>
                                <span class="field-hidden-indicator" title="Oculto en perfil público">
                                    <i class="fas fa-eye-slash"></i>
                                </span>
                            <?php endif; ?>
                        </label>
                        <p>
                            <a href="<?php echo e(route('admin.colegiados.descargar-cv', $colegiado)); ?>" target="_blank" rel="noopener" class="btn-link">
                                <i class="fas fa-file-pdf text-danger"></i>
                                Descargar CV
                            </a>
                        </p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>

    
    <div class="detail-card detail-card-full">
        <div class="card-header">
            <h3><i class="fas fa-certificate"></i> Documento de Habilitación</h3>
            <a href="<?php echo e(route('admin.habilitaciones.create', $colegiado)); ?>" class="btn btn-sm btn-primary">
                <i class="fas fa-plus"></i>
                Nueva Habilitación
            </a>
        </div>
        <div class="card-body">
            <?php if($colegiado->habilitaciones->count() > 0): ?>
                <div class="habilitaciones-list">
                    <?php $__currentLoopData = $colegiado->habilitaciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $habilitacion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="habilitacion-item <?php echo e($habilitacion->activo ? '' : 'inactive'); ?>">
                            <div class="habilitacion-header">
                                <h4>
                                    <?php if($habilitacion->activo): ?>
                                        <span class="badge badge-success"><i class="fas fa-check-circle"></i> ACTIVO</span>
                                    <?php else: ?>
                                        <span class="badge badge-secondary"><i class="fas fa-ban"></i> REVOCADO</span>
                                    <?php endif; ?>
                                </h4>
                                <span class="habilitacion-date">
                                    <i class="fas fa-calendar"></i>
                                    <?php echo e($habilitacion->fecha_subida->format('d/m/Y H:i')); ?>

                                </span>
                            </div>

                            <div class="habilitacion-code">
                                <strong>Código de Verificación:</strong>
                                <code><?php echo e($habilitacion->codigo_verificacion); ?></code>
                                <button onclick="copiarTexto(this, '<?php echo e($habilitacion->codigo_verificacion); ?>')" class="btn-copy" title="Copiar código">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>

                            <div class="habilitacion-url">
                                <strong>URL de Verificación:</strong>
                                <a href="<?php echo e($habilitacion->url_corta); ?>" target="_blank"><?php echo e($habilitacion->url_corta); ?></a>
                                <button onclick="copiarTexto(this, '<?php echo e($habilitacion->url_corta); ?>')" class="btn-copy" title="Copiar URL">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>

                            <div class="habilitacion-qr">
                                <strong>Código QR:</strong>
                                <img src="<?php echo e(asset($habilitacion->qr_path)); ?>" alt="QR Code">
                            </div>

                            <div class="habilitacion-actions">
                                <a href="<?php echo e(route('admin.habilitaciones.documento', $habilitacion->codigo_verificacion)); ?>"
                                   class="btn btn-sm btn-info"
                                   target="_blank"
                                   rel="noopener">
                                    <i class="fas fa-file-download"></i>
                                    Documento
                                </a>
                                <a href="<?php echo e(route('admin.habilitaciones.descargar-qr', $habilitacion)); ?>" class="btn btn-sm btn-secondary">
                                    <i class="fas fa-qrcode"></i>
                                    QR
                                </a>

                                <?php if($habilitacion->activo): ?>
                                    <form action="<?php echo e(route('admin.habilitaciones.revocar', $habilitacion)); ?>" method="POST" class="d-inline" id="form-revocar-<?php echo e($habilitacion->id); ?>">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PATCH'); ?>
                                        <button type="button" class="btn btn-sm btn-warning"
                                                onclick="confirmRevocar('form-revocar-<?php echo e($habilitacion->id); ?>')">
                                            <i class="fas fa-ban"></i>
                                            Revocar
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <form action="<?php echo e(route('admin.habilitaciones.reactivar', $habilitacion)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PATCH'); ?>
                                        <button type="submit" class="btn btn-sm btn-success">
                                            <i class="fas fa-check"></i>
                                            Reactivar
                                        </button>
                                    </form>
                                <?php endif; ?>

                                <form action="<?php echo e(route('admin.habilitaciones.destroy', $habilitacion)); ?>" method="POST" class="d-inline" id="form-del-hab-<?php echo e($habilitacion->id); ?>">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="button" class="btn btn-sm btn-danger"
                                            onclick="confirmDeleteHabilitacion('form-del-hab-<?php echo e($habilitacion->id); ?>')">
                                        <i class="fas fa-trash"></i>
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <div class="empty-state-small">
                    <i class="fas fa-certificate"></i>
                    <p>No hay documentos de habilitación cargados</p>
                    <a href="<?php echo e(route('admin.habilitaciones.create', $colegiado)); ?>" class="btn btn-primary">
                        <i class="fas fa-plus"></i>
                        Subir Documento de Habilitación
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>

</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function copiarTexto(btn, texto) {
    navigator.clipboard.writeText(texto).then(() => {
        const icon = btn.querySelector('i');
        icon.className = 'fas fa-check';
        btn.classList.add('copied');
        setTimeout(() => {
            icon.className = 'fas fa-copy';
            btn.classList.remove('copied');
        }, 1800);
    });
}

function confirmRevocar(formId) {
    Swal.fire({
        title: '¿Revocar habilitación?',
        html: 'El documento quedará marcado como <strong>REVOCADO</strong> y el colegiado no aparecerá como habilitado en verificaciones públicas.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#f57c00',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="fas fa-ban"></i> Sí, revocar',
        cancelButtonText: 'Cancelar',
        focusCancel: true,
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(formId).submit();
        }
    });
}

function confirmDeleteHabilitacion(formId) {
    Swal.fire({
        title: '¿Eliminar documento?',
        html: 'Se eliminará permanentemente el documento PDF, el código QR y el código de verificación. Esta acción <strong>no se puede deshacer</strong>.',
        icon: 'error',
        showCancelButton: true,
        confirmButtonColor: '#d32f2f',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="fas fa-trash"></i> Sí, eliminar',
        cancelButtonText: 'Cancelar',
        focusCancel: true,
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(formId).submit();
        }
    });
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\cpap-web\resources\views/admin/colegiados/show.blade.php ENDPATH**/ ?>