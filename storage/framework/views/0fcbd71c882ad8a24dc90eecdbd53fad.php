<?php $__env->startSection('title', 'Dashboard - Panel Administrativo'); ?>

<?php $__env->startSection('content'); ?>


<div class="dashboard-header">
    <div>
        <h1>¡Bienvenido, <?php echo e(auth()->user()->name); ?>!</h1>
        <p>Panel administrativo del Colegio de Antropólogos del Perú – Región Centro</p>
    </div>
    <div class="dashboard-date">
        <i class="fas fa-calendar-alt"></i>
        <span><?php echo e(\Carbon\Carbon::now()->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY')); ?></span>
    </div>
</div>


<div class="dashboard-section">
    <h2 class="section-title">
        <i class="fas fa-id-card"></i>
        Resumen del Padrón CPAP
    </h2>

    <div class="cpap-summary-grid">
        <div class="cpap-summary-card cpap-summary-total">
            <div class="cpap-summary-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="cpap-summary-body">
                <span class="cpap-summary-label">Padrón total</span>
                <strong class="cpap-summary-num"><?php echo e(\App\Models\Colegiado::count()); ?></strong>
                <span class="cpap-summary-sub">colegiados registrados</span>
            </div>
        </div>

        <div class="cpap-summary-card cpap-summary-activos">
            <div class="cpap-summary-icon">
                <i class="fas fa-user-check"></i>
            </div>
            <div class="cpap-summary-body">
                <span class="cpap-summary-label">Activos</span>
                <strong class="cpap-summary-num"><?php echo e(\App\Models\Colegiado::where('estado', 'activo')->count()); ?></strong>
                <span class="cpap-summary-sub">en ejercicio</span>
            </div>
        </div>

        <div class="cpap-summary-card cpap-summary-inactivos">
            <div class="cpap-summary-icon">
                <i class="fas fa-user-times"></i>
            </div>
            <div class="cpap-summary-body">
                <span class="cpap-summary-label">Inactivos</span>
                <strong class="cpap-summary-num"><?php echo e(\App\Models\Colegiado::where('estado', 'inactivo')->count()); ?></strong>
                <span class="cpap-summary-sub">no habilitados</span>
            </div>
        </div>

        <div class="cpap-summary-card cpap-summary-hab">
            <div class="cpap-summary-icon">
                <i class="fas fa-certificate" style="color: white;"></i>
            </div>
            <div class="cpap-summary-body">
                <span class="cpap-summary-label">Habilitaciones</span>
                <strong class="cpap-summary-num"><?php echo e(\App\Models\Habilitacion::count()); ?></strong>
                <span class="cpap-summary-sub">documentos emitidos</span>
            </div>
        </div>
    </div>
</div>


<div class="dashboard-section">
    <h2 class="section-title">
        <i class="fas fa-grip-horizontal"></i>
        Accesos Rápidos
    </h2>

    <div class="cards">
        <a href="<?php echo e(route('admin.colegiados.index')); ?>" class="card card-featured">
            <div class="card-icon" style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);">
                <i class="fas fa-id-card" style="color: white;"></i>
            </div>
            <div class="card-content">
                <strong>Gestión de Colegiados</strong>
                <p>Administrar el padrón de colegiados y habilitaciones</p>
            </div>
            <div class="card-arrow">
                <i class="fas fa-arrow-right"></i>
            </div>
        </a>

        <a href="<?php echo e(route('admin.noticias.index')); ?>" class="card card-featured">
            <div class="card-icon">
                <i class="fas fa-newspaper" style="color: white;"></i>
            </div>
            <div class="card-content">
                <strong>Gestión de Noticias</strong>
                <p>Crear, editar y publicar noticias institucionales</p>
            </div>
            <div class="card-arrow">
                <i class="fas fa-arrow-right"></i>
            </div>
        </a>

        <a href="<?php echo e(route('admin.invitaciones')); ?>" class="card">
            <div class="card-icon" style="background: linear-gradient(135deg, #e65100 0%, #d84315 100%);">
                <i class="fas fa-envelope-open-text"></i>
            </div>
            <div class="card-content">
                <strong>Invitaciones</strong>
                <p>Enviar invitaciones para nuevos usuarios</p>
            </div>
            <div class="card-arrow">
                <i class="fas fa-arrow-right"></i>
            </div>
        </a>

        <a href="<?php echo e(route('admin.directivos.index')); ?>" class="card">
            <div class="card-icon" style="background: linear-gradient(135deg, #8B1538 0%, #6B0F2A 100%);">
                <i class="fas fa-user-tie"></i>
            </div>
            <div class="card-content">
                <strong>Directivos</strong>
                <p>Gestionar miembros del consejo</p>
            </div>
            <div class="card-arrow">
                <i class="fas fa-arrow-right"></i>
            </div>
        </a>

        <a href="<?php echo e(route('admin.eventos.index')); ?>" class="card">
            <div class="card-icon" style="background: linear-gradient(135deg, #e65100 0%, #d84315 100%);">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="card-content">
                <strong>Eventos</strong>
                <p>Gestionar eventos y actividades</p>
            </div>
            <div class="card-arrow">
                <i class="fas fa-arrow-right"></i>
            </div>
        </a>

        <a href="<?php echo e(route('admin.inicio.anuncios.index')); ?>" class="card">
            <div class="card-icon" style="background: linear-gradient(135deg, #FF9800 0%, #e65100 100%);">
                <i class="fas fa-bullhorn" style="color: white;"></i>
            </div>
            <div class="card-content">
                <strong>Anuncios Emergentes</strong>
                <p>Gestionar popups de la página de inicio</p>
            </div>
            <div class="card-arrow">
                <i class="fas fa-arrow-right"></i>
            </div>
        </a>

        <a href="<?php echo e(route('admin.bolsa.index')); ?>" class="card">
            <div class="card-icon" style="background: linear-gradient(135deg, #00695c 0%, #004d40 100%);">
                <i class="fas fa-briefcase"></i>
            </div>
            <div class="card-content">
                <strong>Bolsa de Trabajo</strong>
                <p>Gestionar ofertas laborales</p>
            </div>
            <div class="card-arrow">
                <i class="fas fa-arrow-right"></i>
            </div>
        </a>
    </div>
</div>


<div class="dashboard-section">
    <h2 class="section-title">
        <i class="fas fa-clock"></i>
        Actividad Reciente
    </h2>

    <div class="dashboard-activity-grid">

        
        <div class="activity-panel">
            <div class="activity-panel-header">
                <span><i class="fas fa-id-card"></i> Últimos Colegiados</span>
                <a href="<?php echo e(route('admin.colegiados.index')); ?>" class="activity-panel-link">
                    Ver todos <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <div class="activity-cards">
                <?php $recentColegiados = \App\Models\Colegiado::latest()->take(3)->get(); ?>
                <?php $__empty_1 = true; $__currentLoopData = $recentColegiados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $colegiado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="activity-card">
                        <div class="activity-icon">
                            <?php if($colegiado->foto): ?>
                                <img src="<?php echo e($colegiado->fotoUrl); ?>" alt="<?php echo e($colegiado->nombre_completo); ?>" class="activity-avatar">
                            <?php else: ?>
                                <span class="activity-initials"><?php echo e(strtoupper(substr($colegiado->nombres, 0, 1) . substr($colegiado->apellidos, 0, 1))); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="activity-info">
                            <h4><?php echo e($colegiado->nombre_completo); ?></h4>
                            <p>
                                <i class="fas fa-hashtag"></i>
                                <?php echo e($colegiado->codigo_cpap); ?>

                                &nbsp;·&nbsp;
                                <i class="fas fa-calendar"></i>
                                <?php echo e($colegiado->created_at->diffForHumans()); ?>

                            </p>
                        </div>
                        <span class="activity-badge <?php echo e($colegiado->estado === 'activo' ? 'activity-badge--activo' : 'activity-badge--inactivo'); ?>">
                            <?php echo e(ucfirst($colegiado->estado)); ?>

                        </span>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="activity-empty">
                        <i class="fas fa-id-card"></i>
                        <p>Sin colegiados aún</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        
        <div class="activity-panel">
            <div class="activity-panel-header">
                <span><i class="fas fa-newspaper"></i> Últimas Noticias</span>
                <a href="<?php echo e(route('admin.noticias.index')); ?>" class="activity-panel-link">
                    Ver todas <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <div class="activity-cards">
                <?php $recentNews = \App\Models\Noticia::latest()->take(3)->get(); ?>
                <?php $__empty_1 = true; $__currentLoopData = $recentNews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $noticia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="activity-card">
                        <div class="activity-icon">
                            <i class="fas fa-newspaper"></i>
                        </div>
                        <div class="activity-info">
                            <h4><?php echo e(Str::limit($noticia->titulo, 50)); ?></h4>
                            <p>
                                <i class="fas fa-calendar"></i>
                                <?php echo e($noticia->created_at->diffForHumans()); ?>

                            </p>
                        </div>
                        <span class="activity-badge <?php echo e($noticia->activo ? 'activity-badge--activo' : 'activity-badge--inactivo'); ?>">
                            <?php echo e($noticia->activo ? 'Activa' : 'Oculta'); ?>

                        </span>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="activity-empty">
                        <i class="fas fa-newspaper"></i>
                        <p>Sin noticias aún</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>


<div class="quick-actions">
    <a href="<?php echo e(route('admin.colegiados.create')); ?>" class="action-btn primary">
        <i class="fas fa-id-card"></i>
        <span>Nuevo Colegiado</span>
    </a>
    <a href="<?php echo e(route('admin.noticias.create')); ?>" class="action-btn secondary">
        <i class="fas fa-plus-circle"></i>
        <span>Nueva Noticia</span>
    </a>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\cpap-web\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>