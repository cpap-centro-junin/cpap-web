

<?php $__env->startSection('title', 'Mapa del Sitio - CPAP Región Centro'); ?>
<?php $__env->startSection('description', 'Navegación completa del sitio web del Colegio de Antropólogos del Perú - Región Centro'); ?>

<?php $__env->startSection('content'); ?>
<div class="legal-container" style="padding: 60px 20px; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); min-height: 200px;">
    <div class="container">
        <h1 style="color: white; text-align: center; font-size: 2.5rem; margin-bottom: 10px;">
            <i class="fas fa-sitemap" style="margin-right: 12px;"></i>Mapa del Sitio
        </h1>
        <p style="text-align: center; color: rgba(255,255,255,0.9); font-size: 1rem;">
            Estructura completa de nuestro sitio web
        </p>
    </div>
</div>

<div class="container" style="max-width: 900px; padding: 60px 20px;">
    <div class="sitemap-content">
        
        <section style="margin-bottom: 40px;">
            <h2 style="color: var(--primary); font-size: 1.3rem; margin-bottom: 15px; padding-bottom: 10px; border-bottom: 2px solid rgba(139,21,56,0.2);">
                <i class="fas fa-home" style="margin-right: 8px;"></i>Páginas Principales
            </h2>
            <ul style="list-style: none; padding: 0; margin: 0;">
                <li style="padding: 8px 0; border-bottom: 1px solid rgba(0,0,0,0.05);">
                    <a href="<?php echo e(url('/')); ?>" style="color: var(--primary); text-decoration: none; font-weight: 500;">
                        <i class="fas fa-chevron-right" style="margin-right: 8px; color: var(--medium-gray);"></i>Inicio
                    </a>
                </li>
                <li style="padding: 8px 0; border-bottom: 1px solid rgba(0,0,0,0.05);">
                    <a href="<?php echo e(route('contacto.index')); ?>" style="color: var(--primary); text-decoration: none; font-weight: 500;">
                        <i class="fas fa-chevron-right" style="margin-right: 8px; color: var(--medium-gray);"></i>Contacto
                    </a>
                </li>
            </ul>
        </section>

        
        <section style="margin-bottom: 40px;">
            <h2 style="color: var(--primary); font-size: 1.3rem; margin-bottom: 15px; padding-bottom: 10px; border-bottom: 2px solid rgba(139,21,56,0.2);">
                <i class="fas fa-info-circle" style="margin-right: 8px;"></i>Sobre Nosotros
            </h2>
            <ul style="list-style: none; padding: 0; margin: 0;">
                <li style="padding: 8px 0; border-bottom: 1px solid rgba(0,0,0,0.05);">
                    <a href="<?php echo e(url('/nosotros/mision-vision')); ?>" style="color: var(--primary); text-decoration: none; font-weight: 500;">
                        <i class="fas fa-chevron-right" style="margin-right: 8px; color: var(--medium-gray);"></i>Misión y Visión
                    </a>
                </li>
                <li style="padding: 8px 0; border-bottom: 1px solid rgba(0,0,0,0.05);">
                    <a href="<?php echo e(url('/nosotros/historia')); ?>" style="color: var(--primary); text-decoration: none; font-weight: 500;">
                        <i class="fas fa-chevron-right" style="margin-right: 8px; color: var(--medium-gray);"></i>Historia
                    </a>
                </li>
                <li style="padding: 8px 0; border-bottom: 1px solid rgba(0,0,0,0.05);">
                    <a href="<?php echo e(url('/nosotros/consejo-directivo')); ?>" style="color: var(--primary); text-decoration: none; font-weight: 500;">
                        <i class="fas fa-chevron-right" style="margin-right: 8px; color: var(--medium-gray);"></i>Consejo Directivo
                    </a>
                </li>
                <li style="padding: 8px 0; border-bottom: 1px solid rgba(0,0,0,0.05);">
                    <a href="<?php echo e(url('/nosotros/normativa-legal')); ?>" style="color: var(--primary); text-decoration: none; font-weight: 500;">
                        <i class="fas fa-chevron-right" style="margin-right: 8px; color: var(--medium-gray);"></i>Normativa Legal
                    </a>
                </li>
                <li style="padding: 8px 0;">
                    <a href="<?php echo e(url('/nosotros/plan-2026')); ?>" style="color: var(--primary); text-decoration: none; font-weight: 500;">
                        <i class="fas fa-chevron-right" style="margin-right: 8px; color: var(--medium-gray);"></i>Plan Operativo 2026
                    </a>
                </li>
            </ul>
        </section>

        
        <section style="margin-bottom: 40px;">
            <h2 style="color: var(--primary); font-size: 1.3rem; margin-bottom: 15px; padding-bottom: 10px; border-bottom: 2px solid rgba(139,21,56,0.2);">
                <i class="fas fa-briefcase" style="margin-right: 8px;"></i>Servicios
            </h2>
            <ul style="list-style: none; padding: 0; margin: 0;">
                <li style="padding: 8px 0; border-bottom: 1px solid rgba(0,0,0,0.05);">
                    <a href="<?php echo e(route('colegiatura.index')); ?>" style="color: var(--primary); text-decoration: none; font-weight: 500;">
                        <i class="fas fa-chevron-right" style="margin-right: 8px; color: var(--medium-gray);"></i>Colegiación
                    </a>
                </li>
                <li style="padding: 8px 0; border-bottom: 1px solid rgba(0,0,0,0.05);">
                    <a href="<?php echo e(route('biblioteca')); ?>" style="color: var(--primary); text-decoration: none; font-weight: 500;">
                        <i class="fas fa-chevron-right" style="margin-right: 8px; color: var(--medium-gray);"></i>Biblioteca Virtual
                    </a>
                </li>
                <li style="padding: 8px 0; border-bottom: 1px solid rgba(0,0,0,0.05);">
                    <a href="<?php echo e(route('bolsa-trabajo')); ?>" style="color: var(--primary); text-decoration: none; font-weight: 500;">
                        <i class="fas fa-chevron-right" style="margin-right: 8px; color: var(--medium-gray);"></i>Bolsa de Trabajo
                    </a>
                </li>
                <li style="padding: 8px 0;">
                    <a href="<?php echo e(url('/colegiados')); ?>" style="color: var(--primary); text-decoration: none; font-weight: 500;">
                        <i class="fas fa-chevron-right" style="margin-right: 8px; color: var(--medium-gray);"></i>Directorio de Colegiados
                    </a>
                </li>
            </ul>
        </section>

        
        <section style="margin-bottom: 40px;">
            <h2 style="color: var(--primary); font-size: 1.3rem; margin-bottom: 15px; padding-bottom: 10px; border-bottom: 2px solid rgba(139,21,56,0.2);">
                <i class="fas fa-newspaper" style="margin-right: 8px;"></i>Información Pública
            </h2>
            <ul style="list-style: none; padding: 0; margin: 0;">
                <li style="padding: 8px 0; border-bottom: 1px solid rgba(0,0,0,0.05);">
                    <a href="<?php echo e(route('noticias.index')); ?>" style="color: var(--primary); text-decoration: none; font-weight: 500;">
                        <i class="fas fa-chevron-right" style="margin-right: 8px; color: var(--medium-gray);"></i>Noticias
                    </a>
                    <span style="margin-left: 30px; color: var(--medium-gray); font-size: 0.85rem;">(<?php echo e($noticias->count()); ?> artículos)</span>
                </li>
                <li style="padding: 8px 0; border-bottom: 1px solid rgba(0,0,0,0.05);">
                    <a href="<?php echo e(url('/#eventos')); ?>" style="color: var(--primary); text-decoration: none; font-weight: 500;">
                        <i class="fas fa-chevron-right" style="margin-right: 8px; color: var(--medium-gray);"></i>Eventos
                    </a>
                    <span style="margin-left: 30px; color: var(--medium-gray); font-size: 0.85rem;">(<?php echo e($eventos->count()); ?> eventos)</span>
                </li>
                <li style="padding: 8px 0;">
                    <a href="<?php echo e(url('/galeria')); ?>" style="color: var(--primary); text-decoration: none; font-weight: 500;">
                        <i class="fas fa-chevron-right" style="margin-right: 8px; color: var(--medium-gray);"></i>Galería Institucional
                    </a>
                </li>
            </ul>
        </section>

        
        <section style="margin-bottom: 40px;">
            <h2 style="color: var(--primary); font-size: 1.3rem; margin-bottom: 15px; padding-bottom: 10px; border-bottom: 2px solid rgba(139,21,56,0.2);">
                <i class="fas fa-book" style="margin-right: 8px;"></i>Biblioteca Virtual
            </h2>
            <p style="color: var(--medium-gray); margin-bottom: 12px; font-size: 0.9rem;">
                Total de recursos disponibles: <strong><?php echo e($recursos->count()); ?> recursos</strong>
            </p>
            <?php if($recursos->count() > 0): ?>
                <ul style="list-style: none; padding: 0; margin: 0; columns: 2; gap: 20px;">
                    <?php $__currentLoopData = $recursos->take(20); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $recurso): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li style="padding: 8px 0; border-bottom: 1px solid rgba(0,0,0,0.05); break-inside: avoid;">
                            <a href="<?php echo e(route('biblioteca.show', $recurso)); ?>" style="color: var(--primary); text-decoration: none; font-size: 0.95rem;">
                                <i class="fas fa-file-pdf" style="margin-right: 6px; color: var(--medium-gray);"></i><?php echo e($recurso->titulo); ?>

                            </a>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
                <?php if($recursos->count() > 20): ?>
                    <div style="margin-top: 15px; text-align: center;">
                        <a href="<?php echo e(route('biblioteca')); ?>" style="color: var(--primary); text-decoration: none; font-weight: 500;">
                            Ver todos los recursos →
                        </a>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <p style="color: var(--medium-gray);">No hay recursos disponibles en este momento.</p>
            <?php endif; ?>
        </section>

        
        <section style="margin-bottom: 40px;">
            <h2 style="color: var(--primary); font-size: 1.3rem; margin-bottom: 15px; padding-bottom: 10px; border-bottom: 2px solid rgba(139,21,56,0.2);">
                <i class="fas fa-users" style="margin-right: 8px;"></i>Directorio de Colegiados
            </h2>
            <p style="color: var(--medium-gray); margin-bottom: 12px; font-size: 0.9rem;">
                Total de colegiados: <strong><?php echo e($colegiados->count()); ?> profesionales</strong>
            </p>
            <a href="<?php echo e(url('/colegiados')); ?>" style="color: var(--primary); text-decoration: none; font-weight: 500; display: inline-block; margin-top: 10px;">
                <i class="fas fa-chevron-right" style="margin-right: 6px;"></i>Ver directorio completo
            </a>
        </section>

        
        <section style="margin-bottom: 40px;">
            <h2 style="color: var(--primary); font-size: 1.3rem; margin-bottom: 15px; padding-bottom: 10px; border-bottom: 2px solid rgba(139,21,56,0.2);">
                <i class="fas fa-gavel" style="margin-right: 8px;"></i>Documentos Legales
            </h2>
            <ul style="list-style: none; padding: 0; margin: 0;">
                <li style="padding: 8px 0; border-bottom: 1px solid rgba(0,0,0,0.05);">
                    <a href="<?php echo e(route('legal.privacidad')); ?>" style="color: var(--primary); text-decoration: none; font-weight: 500;">
                        <i class="fas fa-chevron-right" style="margin-right: 8px; color: var(--medium-gray);"></i>Política de Privacidad
                    </a>
                </li>
                <li style="padding: 8px 0;">
                    <a href="<?php echo e(route('legal.terminos')); ?>" style="color: var(--primary); text-decoration: none; font-weight: 500;">
                        <i class="fas fa-chevron-right" style="margin-right: 8px; color: var(--medium-gray);"></i>Términos y Condiciones
                    </a>
                </li>
            </ul>
        </section>

        
        <section style="margin-bottom: 40px;">
            <h2 style="color: var(--primary); font-size: 1.3rem; margin-bottom: 15px; padding-bottom: 10px; border-bottom: 2px solid rgba(139,21,56,0.2);">
                <i class="fas fa-spider" style="margin-right: 8px;"></i>Archivos SEO
            </h2>
            <ul style="list-style: none; padding: 0; margin: 0;">
                <li style="padding: 8px 0; border-bottom: 1px solid rgba(0,0,0,0.05);">
                    <a href="<?php echo e(route('sitemap')); ?>" style="color: var(--primary); text-decoration: none; font-weight: 500;">
                        <i class="fas fa-chevron-right" style="margin-right: 8px; color: var(--medium-gray);"></i>sitemap.xml
                    </a>
                </li>
                <li style="padding: 8px 0;">
                    <a href="<?php echo e(url('/robots.txt')); ?>" style="color: var(--primary); text-decoration: none; font-weight: 500;">
                        <i class="fas fa-chevron-right" style="margin-right: 8px; color: var(--medium-gray);"></i>robots.txt
                    </a>
                </li>
            </ul>
        </section>

        <div style="background: rgba(139, 21, 56, 0.08); padding: 20px; border-radius: 8px; border-left: 5px solid var(--primary); margin-top: 40px;">
            <h3 style="color: var(--primary); margin-top: 0;">¿No encontraste lo que buscas?</h3>
            <p style="margin: 10px 0; color: var(--dark); line-height: 1.6;">
                Puedes <a href="<?php echo e(route('contacto.index')); ?>" style="color: var(--primary); text-decoration: none; font-weight: 600;">contactarnos directamente</a> para recibir asistencia adicional. Nuestro equipo estará encantado de ayudarte.
            </p>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\cpap-web\resources\views/legal/mapa-sitio.blade.php ENDPATH**/ ?>