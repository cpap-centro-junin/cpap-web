<?php $__env->startSection('title', 'Directorio de Antropólogos Colegiados | CPAP Perú'); ?>
<?php $__env->startSection('seo_title', 'Directorio de Antropólogos Colegiados del Perú | Verificar Habilitación - CPAP Región Centro'); ?>
<?php $__env->startSection('seo_description', 'Directorio oficial de antropólogos colegiados en Perú. Verifica la habilitación profesional de antropólogos por nombre, DNI o código CPAP. Colegio de Antropólogos del Perú - Región Centro.'); ?>
<?php $__env->startSection('seo_keywords', 'directorio antropólogos colegiados, verificar antropólogo habilitado, antropólogos colegiados perú, consultar habilitación antropólogo, colegio de antropólogos, CPAP región centro, antropólogos huancayo junín'); ?>
<?php $__env->startSection('seo_canonical', route('colegiados.index')); ?>
<?php $__env->startSection('seo_image', asset('images/logos/cpap-logo.jpg')); ?>



<?php $__env->startSection('content'); ?>


<section class="cpap-hero">
    <div class="cpap-hero-content" data-aos="fade-up">
        <div class="cpap-hero-badge">
            <i class="fas fa-id-badge"></i>
            Sección CPAP &mdash; Directorio Oficial
        </div>
        <h1>Directorio de <span>Colegiados</span></h1>
        <p>Consulta el estado de habilitación de los miembros del Colegio Profesional de Antropólogos del Perú &mdash; Región Centro</p>

        
        <form id="search-form" action="<?php echo e(route('colegiados.index')); ?>" method="GET" autocomplete="off">
            <?php if(request('estado')): ?>
                <input type="hidden" name="estado" value="<?php echo e(request('estado')); ?>">
            <?php endif; ?>
            <div class="search-box">
                <i class="fas fa-search" style="color: var(--medium-gray);"></i>
                <input
                    id="search-input"
                    type="text"
                    name="buscar"
                    value="<?php echo e($buscar); ?>"
                    placeholder="Buscar por nombre, DNI o código CPAP..."
                    autocomplete="off"
                    spellcheck="false"
                    data-url="<?php echo e(route('colegiados.index')); ?>"
                >
                <button type="submit" class="btn-search">
                    <i class="fas fa-search"></i>
                    Buscar
                </button>
            </div>
        </form>
    </div>
</section>


<div class="filters-section">
    <div class="filters-inner">
        <span class="filter-label">Filtrar:</span>
        <div class="filter-chips">
            <a href="<?php echo e(route('colegiados.index', array_filter(['buscar' => $buscar]))); ?>"
               class="filter-chip <?php echo e(!$estado ? 'active' : ''); ?>">
                <i class="fas fa-users"></i> Todos
            </a>
            <a href="<?php echo e(route('colegiados.index', array_filter(['buscar' => $buscar, 'estado' => 'activo']))); ?>"
               class="filter-chip <?php echo e($estado === 'activo' ? 'active-success' : ''); ?>">
                <i class="fas fa-check-circle"></i> Habilitados
            </a>
            <a href="<?php echo e(route('colegiados.index', array_filter(['buscar' => $buscar, 'estado' => 'inactivo']))); ?>"
               class="filter-chip <?php echo e($estado === 'inactivo' ? 'active-danger' : ''); ?>">
                <i class="fas fa-times-circle"></i> No Habilitados
            </a>
        </div>

        <span id="results-count" class="results-count">
            <?php echo e($colegiados->total()); ?> resultado<?php echo e($colegiados->total() !== 1 ? 's' : ''); ?>

        </span>
    </div>
</div>


<section class="cpap-main">
    <div class="cpap-container">

        
        <div id="search-spinner" hidden class="search-spinner-wrap">
            <i class="fas fa-circle-notch fa-spin"></i>
            <span>Buscando...</span>
        </div>

        
        <div id="colegiados-grid-container">
            <?php echo $__env->make('colegiados._grid', ['colegiados' => $colegiados, 'buscar' => $buscar], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>

    </div>
</section>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
(function () {
    'use strict';

    var input   = document.getElementById('search-input');
    var form    = document.getElementById('search-form');
    var grid    = document.getElementById('colegiados-grid-container');
    var counter = document.getElementById('results-count');
    var spinner = document.getElementById('search-spinner');

    if (!input || !grid) { return; }

    var BASE_URL  = input.dataset.url;
    var timer     = null;
    var activeXHR = null;

    // ─── Estado de carga ───────────────────────────────────────────────────
    function startLoading() {
        spinner.hidden            = false;
        grid.style.opacity        = '0.35';
        grid.style.pointerEvents  = 'none';
        grid.style.transition     = 'opacity 0.15s';
    }

    function stopLoading() {
        spinner.hidden            = true;
        grid.style.opacity        = '';
        grid.style.pointerEvents  = '';
        grid.style.transition     = '';
    }

    // ─── URL con los parámetros actuales ───────────────────────────────────
    function buildUrl() {
        var params = new URLSearchParams(window.location.search);
        var q = input.value.trim();
        if (q) { params.set('buscar', q); }
        else   { params.delete('buscar'); }
        params.delete('page'); // siempre volver a página 1 en búsqueda nueva
        var qs = params.toString();
        return BASE_URL + (qs ? '?' + qs : '');
    }

    // ─── Petición AJAX ─────────────────────────────────────────────────────
    function doSearch() {
        // Cancelar cualquier petición en vuelo
        if (activeXHR) {
            activeXHR.abort();
            activeXHR = null;
        }

        var url = buildUrl();
        window.history.replaceState(null, '', url);
        startLoading();

        var xhr = new XMLHttpRequest();
        activeXHR = xhr;

        xhr.open('GET', url, true);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.setRequestHeader('Accept', 'application/json');

        xhr.onreadystatechange = function () {
            if (xhr.readyState !== 4) { return; }
            // Ignorar si ya fue reemplazado por otra petición
            if (xhr !== activeXHR) { return; }

            activeXHR = null;
            stopLoading();

            if (xhr.status === 200) {
                try {
                    var data = JSON.parse(xhr.responseText);

                    // Insertar HTML quitando atributos data-aos:
                    // AOS pone los elementos en estado invisible antes de animarlos.
                    // En contenido inyectado por AJAX eso causa que las cards queden
                    // permanentemente invisibles si el layout no está listo al llamar
                    // AOS.refresh(). Las cards del directorio no necesitan animación en
                    // búsqueda en tiempo real; aparecen directamente.
                    var tmp = document.createElement('div');
                    tmp.innerHTML = data.html;
                    tmp.querySelectorAll('[data-aos]').forEach(function (el) {
                        el.removeAttribute('data-aos');
                        el.removeAttribute('data-aos-delay');
                    });
                    grid.innerHTML = tmp.innerHTML;

                    if (counter) {
                        var n = Number(data.total);
                        counter.textContent = n + ' resultado' + (n !== 1 ? 's' : '');
                    }
                } catch (parseErr) {
                    // Servidor devolvió HTML de error (500, 419, etc.)
                    // Solo ocultamos el spinner; el grid conserva su contenido anterior
                    console.error('[CPAP] Respuesta de búsqueda no válida:', parseErr);
                }
            }
            // Cualquier otro status (red, timeout, abort): stopLoading() ya fue llamado
        };

        xhr.send();
    }

    // ─── Eventos ───────────────────────────────────────────────────────────
    input.addEventListener('input', function () {
        clearTimeout(timer);
        // Al borrar el campo: respuesta casi inmediata
        // Al escribir: espera 400 ms para no saturar el servidor
        var delay = (input.value.trim() === '') ? 80 : 400;
        timer = setTimeout(doSearch, delay);
    });

    if (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            clearTimeout(timer);
            doSearch();
        });
    }

}());
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\cpap-web\resources\views/colegiados/index.blade.php ENDPATH**/ ?>