

<div class="admin-pagination-wrapper">
    <div class="admin-pagination-container">
        
        
        <div class="pagination-single-row">
            
            
            <div class="pagination-stats">
                <span class="stat-label">Mostrando</span>
                <span class="stat-value"><?php echo e($paginator->firstItem()); ?>-<?php echo e($paginator->lastItem()); ?></span>
                <span class="stat-label">de</span>
                <span class="stat-total"><?php echo e($paginator->total()); ?></span>
                <span class="stat-label">resultados</span>
            </div>

            
            <div class="pagination-perpage-selector-inline">
                <form id="perpage-form" method="GET" class="inline-form">
                    <?php $__currentLoopData = request()->query(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($key !== 'perpage'): ?>
                            <input type="hidden" name="<?php echo e($key); ?>" value="<?php echo e($value); ?>">
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                    <select name="perpage" class="perpage-select-inline" onchange="document.getElementById('perpage-form').submit();" aria-label="Items por página">
                        <?php
                            $currentPerPage = (int) (request('perpage') ?? session('pagination_perpage') ?? $paginator->perPage());
                            $options = [10, 20, 50, 100];
                        ?>
                        
                        <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($option); ?>" <?php if($currentPerPage == $option): echo 'selected'; endif; ?>><?php echo e($option); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </form>
            </div>

            
            <div class="pagination-page-info-inline">
                Página <?php echo e($paginator->currentPage()); ?>/<?php echo e($paginator->lastPage()); ?>

            </div>

            
            <div class="pagination-controls-inline">
                
                
                <?php if($paginator->onFirstPage()): ?>
                    <button class="pagination-btn-inline pagination-btn-prev disabled" disabled aria-label="Página anterior deshabilitada">
                        <i class="fas fa-chevron-left"></i><span>Anterior</span>
                    </button>
                <?php else: ?>
                    <a href="<?php echo e($paginator->previousPageUrl()); ?>" class="pagination-btn-inline pagination-btn-prev" aria-label="Página anterior">
                        <i class="fas fa-chevron-left"></i><span>Anterior</span>
                    </a>
                <?php endif; ?>

                
                <div class="pagination-numbers-inline" role="navigation" aria-label="Paginación">
                    <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(is_string($element)): ?>
                            <span class="page-ellipsis-inline">…</span>
                        <?php endif; ?>
                        <?php if(is_array($element)): ?>
                            <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($page == $paginator->currentPage()): ?>
                                    <span class="page-number-inline active" aria-current="page"><?php echo e($page); ?></span>
                                <?php else: ?>
                                    <a href="<?php echo e($url); ?>" class="page-number-inline"><?php echo e($page); ?></a>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                
                <?php if($paginator->hasMorePages()): ?>
                    <a href="<?php echo e($paginator->nextPageUrl()); ?>" class="pagination-btn-inline pagination-btn-next" aria-label="Página siguiente">
                        <span>Siguiente</span><i class="fas fa-chevron-right"></i>
                    </a>
                <?php else: ?>
                    <button class="pagination-btn-inline pagination-btn-next disabled" disabled aria-label="Siguiente deshabilitado">
                        <span>Siguiente</span><i class="fas fa-chevron-right"></i>
                    </button>
                <?php endif; ?>
            </div>

        </div>
    </div>
</div><?php /**PATH C:\laragon\www\cpap-web\resources\views/pagination/admin.blade.php ENDPATH**/ ?>