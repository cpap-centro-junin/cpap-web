

<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'searchPlaceholder' => 'Buscar...',
    'searchField' => 'q',
    'filters' => [], // Array de filtros: ['nombre' => 'field_name', 'label' => 'Label', 'options' => []]
    'route' => null, // Ruta para el formulario
    'clearRoute' => null, // Ruta para limpiar filtros
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'searchPlaceholder' => 'Buscar...',
    'searchField' => 'q',
    'filters' => [], // Array de filtros: ['nombre' => 'field_name', 'label' => 'Label', 'options' => []]
    'route' => null, // Ruta para el formulario
    'clearRoute' => null, // Ruta para limpiar filtros
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div class="admin-filters-card">
    <form method="GET" action="<?php echo e($route); ?>" class="admin-filters-form">
        
        
        <div class="filter-item filter-search">
            <input
                type="text"
                name="<?php echo e($searchField); ?>"
                class="admin-input"
                placeholder="<?php echo e($searchPlaceholder); ?>"
                value="<?php echo e(request($searchField)); ?>"
                aria-label="Campo de búsqueda"
            >
            <span class="search-icon">
                <i class="fas fa-search"></i>
            </span>
        </div>

        
        <?php $__currentLoopData = $filters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $filter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="filter-item">
                <select 
                    name="<?php echo e($filter['field']); ?>" 
                    class="admin-input"
                    aria-label="<?php echo e($filter['label']); ?>"
                >
                    <option value=""><?php echo e($filter['label']); ?></option>
                    <?php $__currentLoopData = $filter['options']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option 
                            value="<?php echo e($value); ?>"
                            <?php if(request($filter['field']) == $value): echo 'selected'; endif; ?>
                        >
                            <?php echo e($label); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        
        <div class="filter-actions">
            <button type="submit" class="btn btn-primary btn-sm">
                <i class="fas fa-filter"></i>
                Filtrar
            </button>
            
            <?php if(request()->anyFilled(array_merge([$searchField], collect($filters)->pluck('field')->toArray()))): ?>
                <a href="<?php echo e($clearRoute); ?>" class="btn btn-secondary btn-sm">
                    <i class="fas fa-times"></i>
                    Limpiar
                </a>
            <?php endif; ?>
        </div>

    </form>
</div>

<style>
.admin-filters-card {
    background: #ffffff;
    border: 1px solid #e5eef7;
    border-radius: 12px;
    padding: 18px 20px;
    margin-bottom: 24px;
    box-shadow: 0 2px 8px rgba(139, 21, 56, 0.05);
}

.admin-filters-form {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
    align-items: center;
}

.filter-item {
    flex: 1;
    min-width: 180px;
    position: relative;
}

.filter-search {
    position: relative;
    min-width: 240px;
}

.filter-search .search-icon {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #9ca3af;
    pointer-events: none;
    font-size: 14px;
}

.filter-search .admin-input {
    padding-right: 36px;
}

.admin-input {
    width: 100%;
    padding: 10px 14px;
    border: 1.5px solid #e5eef7;
    border-radius: 8px;
    background: #ffffff;
    color: #2c3e50;
    font-size: 13px;
    font-weight: 500;
    transition: all 0.2s ease;
}

.admin-input:hover {
    border-color: #d8e5f3;
    box-shadow: 0 2px 4px rgba(139, 21, 56, 0.05);
}

.admin-input:focus {
    outline: none;
    border-color: #8B1538;
    box-shadow: 0 0 0 3px rgba(139, 21, 56, 0.1);
    background: #ffffff;
}

.filter-actions {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 10px 16px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    border: none;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.2s ease;
    white-space: nowrap;
}

.btn-primary {
    background: linear-gradient(135deg, #8B1538 0%, #6B0F2A 100%);
    color: #ffffff;
    border: none;
}

.btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(139, 21, 56, 0.3);
}

.btn-secondary {
    background: #f0f3f8;
    color: #7a8896;
    border: 1px solid #e5eef7;
}

.btn-secondary:hover {
    background: #e0e5f0;
    color: #4a5568;
}

.btn-sm {
    padding: 8px 12px;
    font-size: 12px;
}

/* Responsive */
@media (max-width: 1024px) {
    .filter-item {
        min-width: 160px;
    }
}

@media (max-width: 768px) {
    .admin-filters-card {
        padding: 14px 16px;
    }

    .admin-filters-form {
        gap: 8px;
    }

    .filter-item {
        min-width: 140px;
        flex: 1;
    }

    .filter-search {
        min-width: 100%;
        order: -1;
    }

    .filter-actions {
        width: 100%;
    }
}

@media (max-width: 576px) {
    .filter-item,
    .filter-search,
    .filter-actions {
        width: 100%;
    }

    .admin-input {
        font-size: 12px;
        padding: 8px 12px;
    }

    .btn {
        padding: 8px 12px;
        font-size: 11px;
        flex: 1;
    }
}
</style>
<?php /**PATH C:\laragon\www\cpap-web\resources\views/components/admin-filters.blade.php ENDPATH**/ ?>