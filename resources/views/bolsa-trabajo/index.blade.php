@extends('layouts.app')

@section('title', 'Bolsa de Trabajo - CPAP Región Centro')

@vite(['resources/css/pages/bolsa-trabajo.css'])

@section('content')
<!-- Page Header -->
<section class="page-header">
    <div class="page-header-overlay"></div>
    <div class="container">
        <div class="page-header-content" data-aos="fade-up">
            <h1 class="page-title">
                <i class="fas fa-briefcase"></i>
                Bolsa de Trabajo
            </h1>
            <p class="page-subtitle">Oportunidades laborales para antropólogos colegiados</p>
            <nav class="breadcrumb">
                <a href="{{ url('/') }}">Inicio</a>
                <span>/</span>
                <span>Bolsa de Trabajo</span>
            </nav>
        </div>
    </div>
</section>

<!-- Job Listings -->
<section class="section-padding bg-light">
    <div class="container">

        <!-- Buscador con Filtros -->
        <div class="job-filters" data-aos="fade-up">
            <div class="filter-group">
                <label><i class="fas fa-search"></i> Buscar</label>
                <input type="text" class="filter-input" id="filterBuscar" placeholder="Puesto, empresa o palabra clave..." value="{{ request('q') }}">
            </div>
            <div class="filter-group">
                <label><i class="fas fa-tag"></i> Tipo</label>
                <select class="filter-select" id="filterTipo">
                    <option value="">Todos los tipos</option>
                    <option value="fulltime" {{ request('tipo') == 'fulltime' ? 'selected' : '' }}>Tiempo Completo</option>
                    <option value="parttime" {{ request('tipo') == 'parttime' ? 'selected' : '' }}>Medio Tiempo</option>
                    <option value="freelance" {{ request('tipo') == 'freelance' ? 'selected' : '' }}>Freelance</option>
                    <option value="consultoria" {{ request('tipo') == 'consultoria' ? 'selected' : '' }}>Consultoría</option>
                </select>
            </div>
            <div class="filter-group">
                <label><i class="fas fa-layer-group"></i> Área</label>
                <select class="filter-select" id="filterArea">
                    <option value="">Todas las áreas</option>
                    <option value="investigacion" {{ request('area') == 'investigacion' ? 'selected' : '' }}>Investigación</option>
                    <option value="docencia" {{ request('area') == 'docencia' ? 'selected' : '' }}>Docencia</option>
                    <option value="consultoria" {{ request('area') == 'consultoria' ? 'selected' : '' }}>Consultoría</option>
                    <option value="gestion" {{ request('area') == 'gestion' ? 'selected' : '' }}>Gestión Cultural</option>
                </select>
            </div>
            <button type="button" class="filter-btn" id="btnFiltrar">
                <i class="fas fa-search"></i> Buscar
            </button>
        </div>

        <!-- Filtros rápidos -->
        <div class="quick-filters" data-aos="fade-up" data-aos-delay="100">
            <button class="quick-filter-tag {{ !request('tipo') && !request('area') && !request('q') ? 'active' : '' }}" data-filter="all">Todas</button>
            <button class="quick-filter-tag {{ request('tipo') == 'fulltime' ? 'active' : '' }}" data-filter="fulltime">Tiempo Completo</button>
            <button class="quick-filter-tag {{ request('tipo') == 'parttime' ? 'active' : '' }}" data-filter="parttime">Medio Tiempo</button>
            <button class="quick-filter-tag {{ request('tipo') == 'freelance' ? 'active' : '' }}" data-filter="freelance">Freelance</button>
            <button class="quick-filter-tag {{ request('tipo') == 'consultoria' ? 'active' : '' }}" data-filter="consultoria">Consultoría</button>
        </div>

        <!-- Stats Bar -->
        <div class="jobs-stats" data-aos="fade-up" data-aos-delay="150">
            <div class="jobs-count">
                <strong>{{ $ofertas->total() }}</strong> oferta{{ $ofertas->total() != 1 ? 's' : '' }} encontrada{{ $ofertas->total() != 1 ? 's' : '' }}
                @if(request('q') || request('tipo') || request('area'))
                    <a href="{{ route('bolsa-trabajo') }}" style="margin-left:12px;font-size:0.85rem;color:var(--primary,#8B1538);font-weight:600;text-decoration:none;">
                        <i class="fas fa-times"></i> Limpiar filtros
                    </a>
                @endif
            </div>
        </div>

        @if($ofertas->count())
        <div class="jobs-grid">
            @foreach($ofertas as $oferta)
            <div class="job-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="job-header">
                    <div class="company-logo">
                        <i class="fas fa-building"></i>
                    </div>
                    <div class="job-tags">
                        <span class="tag tag-{{ $oferta->tipo }}">{{ $oferta->tipo_label }}</span>
                        @if($oferta->fecha_publicacion->diffInDays(now()) <= 7)
                        <span class="tag tag-new">Nuevo</span>
                        @endif
                    </div>
                </div>
                <h3 class="job-title">{{ $oferta->titulo }}</h3>
                <p class="company-name"><i class="fas fa-building"></i> {{ $oferta->empresa }}</p>
                <p class="job-location"><i class="fas fa-map-marker-alt"></i> {{ $oferta->ubicacion }}</p>
                <p class="job-description">
                    {{ Str::limit($oferta->descripcion, 200) }}
                </p>
                <div class="job-footer">
                    <div class="job-salary">
                        <i class="fas fa-money-bill-wave"></i>
                        {{ $oferta->salario ?? 'A convenir' }}
                    </div>
                    <div class="job-date">
                        <i class="fas fa-clock"></i>
                        Publicado {{ $oferta->fecha_publicacion->diffForHumans() }}
                    </div>
                </div>
                @if($oferta->enlace_postulacion)
                <a href="{{ $oferta->enlace_postulacion }}" target="_blank" class="btn btn-primary btn-block">
                    <i class="fas fa-paper-plane"></i>
                    Postular Ahora
                </a>
                @endif
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($ofertas->hasPages())
        <div class="pagination-wrapper" data-aos="fade-up">
            {{ $ofertas->links() }}
        </div>
        @endif
        @else
        <div class="jobs-empty" data-aos="fade-up">
            <div class="jobs-empty-icon"><i class="fas fa-briefcase"></i></div>
            <h3>No hay ofertas disponibles</h3>
            <p>
                @if(request('q') || request('tipo') || request('area'))
                    No se encontraron ofertas con los filtros seleccionados.
                @else
                    Vuelve pronto, publicamos nuevas oportunidades constantemente.
                @endif
            </p>
            @if(request('q') || request('tipo') || request('area'))
                <a href="{{ route('bolsa-trabajo') }}" class="filter-btn" style="display:inline-flex;text-decoration:none;">
                    <i class="fas fa-undo"></i> Ver todas las ofertas
                </a>
            @endif
        </div>
        @endif
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="cta-overlay"></div>
    <div class="container">
        <div class="cta-content" data-aos="zoom-in">
            <h2>¿Tienes una oferta laboral?</h2>
            <p>Si tu organización busca contratar antropólogos profesionales, publica tu oferta aquí</p>
            <button type="button" class="btn btn-light btn-lg" id="btnAbrirSolicitud">
                <i class="fas fa-plus-circle"></i>
                Publicar Oferta
            </button>
        </div>
    </div>
</section>

<!-- Modal Solicitud de Oferta Laboral -->
<div class="bolsa-modal-overlay" id="modalSolicitud">
    <div class="bolsa-modal">

        <!-- Header con diseño premium -->
        <div class="bolsa-modal-header">
            <button type="button" class="bolsa-modal-close" id="btnCerrarModal">&times;</button>
            <div class="bolsa-modal-header-inner">
                <div class="bolsa-modal-icon">
                    <i class="fas fa-paper-plane"></i>
                </div>
                <h2>Publica tu Oferta Laboral</h2>
                <p>Completa el formulario y nuestro equipo revisará tu solicitud antes de publicarla en el portal.</p>
            </div>
            <div class="bolsa-modal-header-deco"></div>
        </div>

        <form id="formSolicitudOferta" class="bolsa-modal-form">
            @csrf
            <div class="bolsa-modal-body">

                <!-- Sección Contacto -->
                <div class="bolsa-field-section">
                    <div class="bolsa-section-badge">
                        <span class="bolsa-section-num">1</span>
                        <div>
                            <h4>Datos de contacto</h4>
                            <p class="bolsa-section-hint">¿Quién publica esta oferta?</p>
                        </div>
                    </div>
                    <div class="bolsa-field-row">
                        <div class="bolsa-field">
                            <label for="sol_nombre"><i class="fas fa-user"></i> Nombre completo <span>*</span></label>
                            <input type="text" id="sol_nombre" name="nombre_contacto" placeholder="Tu nombre completo" required>
                        </div>
                        <div class="bolsa-field">
                            <label for="sol_email"><i class="fas fa-envelope"></i> Email de contacto <span>*</span></label>
                            <input type="email" id="sol_email" name="email_contacto" placeholder="correo@ejemplo.com" required>
                        </div>
                    </div>
                </div>

                <!-- Sección Oferta -->
                <div class="bolsa-field-section">
                    <div class="bolsa-section-badge">
                        <span class="bolsa-section-num">2</span>
                        <div>
                            <h4>Información de la oferta</h4>
                            <p class="bolsa-section-hint">Detalles del puesto que ofreces</p>
                        </div>
                    </div>
                    <div class="bolsa-field bolsa-field-full">
                        <label for="sol_titulo"><i class="fas fa-heading"></i> Título del puesto <span>*</span></label>
                        <input type="text" id="sol_titulo" name="titulo" placeholder="Ej: Antropólogo/a para Proyecto de Investigación" required>
                    </div>
                    <div class="bolsa-field-row">
                        <div class="bolsa-field">
                            <label for="sol_empresa"><i class="fas fa-building"></i> Empresa / Organización <span>*</span></label>
                            <input type="text" id="sol_empresa" name="empresa" placeholder="Nombre de la organización" required>
                        </div>
                        <div class="bolsa-field">
                            <label for="sol_ubicacion"><i class="fas fa-map-marker-alt"></i> Ubicación <span>*</span></label>
                            <input type="text" id="sol_ubicacion" name="ubicacion" placeholder="Ej: Huancayo, Junín" required>
                        </div>
                    </div>
                    <div class="bolsa-field-row">
                        <div class="bolsa-field">
                            <label for="sol_tipo"><i class="fas fa-tag"></i> Tipo de trabajo <span>*</span></label>
                            <select id="sol_tipo" name="tipo" required>
                                <option value="" disabled selected>Seleccionar tipo...</option>
                                <option value="fulltime">Tiempo Completo</option>
                                <option value="parttime">Medio Tiempo</option>
                                <option value="freelance">Freelance</option>
                                <option value="consultoria">Consultoría</option>
                            </select>
                        </div>
                        <div class="bolsa-field">
                            <label for="sol_area"><i class="fas fa-layer-group"></i> Área <span>*</span></label>
                            <select id="sol_area" name="area" required>
                                <option value="" disabled selected>Seleccionar área...</option>
                                <option value="investigacion">Investigación</option>
                                <option value="docencia">Docencia</option>
                                <option value="consultoria">Consultoría</option>
                                <option value="gestion">Gestión Cultural</option>
                            </select>
                        </div>
                    </div>
                    <div class="bolsa-field bolsa-field-full">
                        <label for="sol_salario"><i class="fas fa-money-bill-wave"></i> Salario <small>(opcional)</small></label>
                        <input type="text" id="sol_salario" name="salario" placeholder="Ej: S/. 3,500 - 4,500 o 'A convenir'">
                    </div>
                </div>

                <!-- Sección Descripción -->
                <div class="bolsa-field-section">
                    <div class="bolsa-section-badge">
                        <span class="bolsa-section-num">3</span>
                        <div>
                            <h4>Descripción del puesto</h4>
                            <p class="bolsa-section-hint">Requisitos, funciones, beneficios</p>
                        </div>
                    </div>
                    <div class="bolsa-field bolsa-field-full">
                        <textarea id="sol_descripcion" name="descripcion" rows="6" placeholder="Describe detalladamente los requisitos, funciones principales, beneficios y cualquier información relevante del puesto..." required></textarea>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="bolsa-modal-footer">
                <div class="bolsa-modal-note">
                    <i class="fas fa-shield-alt"></i>
                    <span>Tu solicitud será revisada antes de publicarse</span>
                </div>
                <div class="bolsa-modal-actions">
                    <button type="button" class="bolsa-btn-cancel" id="btnCancelarModal">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                    <button type="submit" class="bolsa-btn-submit" id="btnEnviarSolicitud">
                        <i class="fas fa-paper-plane"></i> Enviar Solicitud
                    </button>
                </div>
            </div>
        </form>

        <!-- Estado de carga -->
        <div class="bolsa-modal-loading" id="modalLoading" style="display:none;">
            <div class="bolsa-spinner"></div>
            <p>Enviando tu solicitud...</p>
        </div>

        <!-- Estado de éxito -->
        <div class="bolsa-modal-success" id="modalSuccess" style="display:none;">
            <div class="bolsa-success-check"><i class="fas fa-check"></i></div>
            <h3>¡Solicitud enviada con éxito!</h3>
            <p>Nuestro equipo revisará tu oferta y te notificaremos por correo electrónico cuando sea aprobada.</p>
            <button type="button" class="bolsa-btn-submit" id="btnCerrarExito">
                <i class="fas fa-thumbs-up"></i> Entendido
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
(function() {
    const overlay = document.getElementById('modalSolicitud');
    const modal   = overlay.querySelector('.bolsa-modal');
    const form    = document.getElementById('formSolicitudOferta');
    const loading = document.getElementById('modalLoading');
    const success = document.getElementById('modalSuccess');

    function openModal() {
        overlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
    function closeModal() {
        overlay.classList.remove('active');
        document.body.style.overflow = '';
        // Reset después de animación
        setTimeout(() => {
            form.reset();
            form.style.display = '';
            loading.style.display = 'none';
            success.style.display = 'none';
        }, 300);
    }

    document.getElementById('btnAbrirSolicitud').addEventListener('click', openModal);
    document.getElementById('btnCerrarModal').addEventListener('click', closeModal);
    document.getElementById('btnCancelarModal').addEventListener('click', closeModal);
    document.getElementById('btnCerrarExito').addEventListener('click', closeModal);

    // Cerrar con clic fuera
    overlay.addEventListener('click', function(e) {
        if (e.target === overlay) closeModal();
    });

    // Cerrar con Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && overlay.classList.contains('active')) closeModal();
    });

    // Enviar formulario con AJAX
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const btn = document.getElementById('btnEnviarSolicitud');
        btn.disabled = true;

        // Mostrar loading
        form.style.display = 'none';
        loading.style.display = 'flex';

        fetch('{{ route("bolsa-trabajo.solicitar") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify(Object.fromEntries(new FormData(form)))
        })
        .then(r => r.json())
        .then(data => {
            loading.style.display = 'none';
            if (data.success) {
                success.style.display = 'flex';
            } else {
                // Mostrar errores
                let msg = data.message || 'Error al enviar la solicitud.';
                if (data.errors) {
                    msg = Object.values(data.errors).flat().join('\n');
                }
                alert(msg);
                form.style.display = '';
                btn.disabled = false;
            }
        })
        .catch(() => {
            loading.style.display = 'none';
            form.style.display = '';
            btn.disabled = false;
            alert('Error de conexión. Inténtalo de nuevo.');
        });
    });
})();

// ============ Buscador con filtros ============
(function() {
    const baseUrl = '{{ route("bolsa-trabajo") }}';

    function aplicarFiltros() {
        const q    = document.getElementById('filterBuscar').value.trim();
        const tipo = document.getElementById('filterTipo').value;
        const area = document.getElementById('filterArea').value;

        const params = new URLSearchParams();
        if (q)    params.set('q', q);
        if (tipo) params.set('tipo', tipo);
        if (area) params.set('area', area);

        const qs = params.toString();
        window.location.href = baseUrl + (qs ? '?' + qs : '');
    }

    // Botón buscar
    document.getElementById('btnFiltrar').addEventListener('click', aplicarFiltros);

    // Enter en campo de búsqueda
    document.getElementById('filterBuscar').addEventListener('keydown', function(e) {
        if (e.key === 'Enter') { e.preventDefault(); aplicarFiltros(); }
    });

    // Filtros rápidos por tipo
    document.querySelectorAll('.quick-filter-tag').forEach(btn => {
        btn.addEventListener('click', function() {
            const filter = this.dataset.filter;
            if (filter === 'all') {
                window.location.href = baseUrl;
            } else {
                window.location.href = baseUrl + '?tipo=' + filter;
            }
        });
    });
})();
</script>
@endpush

@endsection
