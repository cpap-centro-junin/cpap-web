@extends('layouts.app')

@section('title', 'Galería Institucional - CPAP Región Centro')
@section('seo_title', 'Galería Institucional | CPAP Región Centro')
@section('seo_description', 'Explora la galería institucional del CPAP Región Centro con actividades, ceremonias y eventos académicos.')
@section('seo_canonical', route('galeria'))
@section('seo_image', asset('images/logos/cpap-logo.jpg'))

@push('styles')
@vite(['resources/css/pages/galeria.css'])
@endpush

@section('content')

<!-- Page Header -->
<section class="page-header">
    <div class="page-header-overlay"></div>
    <div class="container">
        <div class="page-header-content" data-aos="fade-up">
            <h1 class="page-title">
                <i class="fas fa-images"></i>
                Galería Institucional
            </h1>
            <p class="page-subtitle">Revive los momentos más importantes del Colegio Profesional de Antropólogos del Perú – Región Centro</p>
            <nav class="breadcrumb">
                <a href="{{ url('/') }}">Inicio</a>
                <span>/</span>
                <a href="{{ url('/#nosotros') }}">Nosotros</a>
                <span>/</span>
                <span>Galería</span>
            </nav>
        </div>
    </div>
</section>

<!-- Filtros -->
<section class="galeria-filtros-section">
    <div class="container">
        <div class="galeria-filtros" data-aos="fade-up">
            <button class="galeria-filtro-btn active" data-filter="all">
                <i class="fas fa-th"></i> Todas
            </button>
            @foreach($categorias as $key => $label)
                @if($imagenesPorCategoria->has($key))
                <button class="galeria-filtro-btn" data-filter="{{ Str::slug($key) }}">
                    {{ $label }}
                    <span class="filtro-count">{{ $imagenesPorCategoria[$key] }}</span>
                </button>
                @endif
            @endforeach
        </div>
    </div>
</section>

<!-- Grid de Galería -->
<section class="section-padding galeria-grid-section">
    <div class="container">
        @if($imagenes->count())
        <div class="galeria-grid" id="galeriaGrid">
            @foreach($imagenes as $img)
            <div class="galeria-item" data-category="{{ Str::slug($img->categoria ?? 'otros') }}" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 6) * 50 }}">
                <div class="galeria-item-inner" onclick="openLightbox({{ $loop->index }})">
                    <img src="{{ $img->imagen }}" alt="{{ $img->titulo }}" loading="lazy">
                    <div class="galeria-item-overlay">
                        <div class="galeria-item-share">
                            <button class="share-btn share-fb" onclick="event.stopPropagation();shareImage('facebook',{{ $loop->index }})" title="Compartir en Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </button>
                            <button class="share-btn share-x" onclick="event.stopPropagation();shareImage('twitter',{{ $loop->index }})" title="Compartir en X">
                                <i class="fab fa-twitter"></i>
                            </button>
                            <button class="share-btn share-wa" onclick="event.stopPropagation();shareImage('whatsapp',{{ $loop->index }})" title="Compartir en WhatsApp">
                                <i class="fab fa-whatsapp"></i>
                            </button>
                            <button class="share-btn share-link" onclick="event.stopPropagation();shareImage('copy',{{ $loop->index }})" title="Copiar enlace">
                                <i class="fas fa-link"></i>
                            </button>
                        </div>
                        <div class="galeria-item-info">
                            @if($img->categoria)
                            <span class="galeria-item-cat">{{ $img->categoria }}</span>
                            @endif
                            <h3 class="galeria-item-title">{{ $img->titulo }}</h3>
                            @if($img->fecha)
                            <span class="galeria-item-date">
                                <i class="far fa-calendar-alt"></i> {{ $img->fecha->format('d M Y') }}
                            </span>
                            @endif
                        </div>
                        <div class="galeria-item-zoom">
                            <i class="fas fa-search-plus"></i>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @if($imagenes->hasPages())
        <div style="margin-top:40px;display:flex;justify-content:center;">
            {{ $imagenes->links() }}
        </div>
        @endif

        @else
        <div style="text-align:center;padding:80px 20px;">
            <div style="width:90px;height:90px;margin:0 auto 25px;background:linear-gradient(135deg, #8B1538 0%, #6B0F2A 100%);border-radius:22px;display:flex;align-items:center;justify-content:center;">
                <i class="fas fa-images" style="font-size:2.5rem;color:white;"></i>
            </div>
            <h3 style="color:#2c3e50;font-size:1.5rem;font-weight:700;margin-bottom:10px;">Galería vacía</h3>
            <p style="color:#6c757d;font-size:1.05rem;line-height:1.7;">Próximamente compartiremos fotos de nuestros eventos y actividades.</p>
        </div>
        @endif
    </div>
</section>

<!-- Lightbox -->
<div class="galeria-lightbox" id="galeriaLightbox">
    <button class="lightbox-close" onclick="closeLightbox()" aria-label="Cerrar">
        <i class="fas fa-times"></i>
    </button>
    <button class="lightbox-nav lightbox-prev" onclick="navigateLightbox(-1)" aria-label="Anterior">
        <i class="fas fa-chevron-left"></i>
    </button>
    <button class="lightbox-nav lightbox-next" onclick="navigateLightbox(1)" aria-label="Siguiente">
        <i class="fas fa-chevron-right"></i>
    </button>
    <div class="lightbox-content">
        <img id="lightboxImg" src="" alt="">
        <div class="lightbox-info" id="lightboxInfo">
            <h3 id="lightboxTitle"></h3>
            <p id="lightboxDesc"></p>
        </div>
        <div class="lightbox-share" id="lightboxShare">
            <button class="share-btn share-fb" onclick="shareImage('facebook', currentLightboxIndex)" title="Facebook">
                <i class="fab fa-facebook-f"></i>
            </button>
            <button class="share-btn share-x" onclick="shareImage('twitter', currentLightboxIndex)" title="X">
                <i class="fab fa-twitter"></i>
            </button>
            <button class="share-btn share-wa" onclick="shareImage('whatsapp', currentLightboxIndex)" title="WhatsApp">
                <i class="fab fa-whatsapp"></i>
            </button>
            <button class="share-btn share-link" onclick="shareImage('copy', currentLightboxIndex)" title="Copiar enlace">
                <i class="fas fa-link"></i>
            </button>
        </div>
    </div>
    <div class="lightbox-counter" id="lightboxCounter"></div>
</div>

@endsection

@push('scripts')
@php
    $lightboxJson = json_encode(
        $imagenes->getCollection()->map(function($img) {
            return array(
                'url'   => $img->imagen_url,
                'title' => $img->titulo,
                'desc'  => $img->descripcion ?? '',
            );
        })->values()
    );
@endphp
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ── Filtros ────────────────────────────
    const filterBtns = document.querySelectorAll('.galeria-filtro-btn');
    const items = document.querySelectorAll('.galeria-item');

    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            filterBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            const filter = this.dataset.filter;

            items.forEach(item => {
                if (filter === 'all' || item.dataset.category === filter) {
                    item.style.display = '';
                    item.style.animation = 'fadeInUp 0.4s ease forwards';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
});

// ── Lightbox ────────────────────────────
const galleryData = {!! $lightboxJson !!};

let currentLightboxIndex = 0;
const lightbox = document.getElementById('galeriaLightbox');

function openLightbox(index) {
    currentLightboxIndex = index;
    updateLightbox();
    lightbox.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeLightbox() {
    lightbox.classList.remove('active');
    document.body.style.overflow = '';
}

function navigateLightbox(dir) {
    currentLightboxIndex += dir;
    if (currentLightboxIndex < 0) currentLightboxIndex = galleryData.length - 1;
    if (currentLightboxIndex >= galleryData.length) currentLightboxIndex = 0;
    updateLightbox();
}

function updateLightbox() {
    const data = galleryData[currentLightboxIndex];
    if (!data) return;
    document.getElementById('lightboxImg').src = data.url;
    document.getElementById('lightboxTitle').textContent = data.title;
    document.getElementById('lightboxDesc').textContent = data.desc;
    document.getElementById('lightboxCounter').textContent = `${currentLightboxIndex + 1} / ${galleryData.length}`;
}

// Cerrar con ESC y navegar con flechas
document.addEventListener('keydown', function(e) {
    if (!lightbox.classList.contains('active')) return;
    if (e.key === 'Escape') closeLightbox();
    if (e.key === 'ArrowLeft') navigateLightbox(-1);
    if (e.key === 'ArrowRight') navigateLightbox(1);
});

// Cerrar al click fuera de la imagen
lightbox.addEventListener('click', function(e) {
    if (e.target === lightbox) closeLightbox();
});

// ── Compartir en redes ────────────────────
const pageUrl = window.location.href;

function shareImage(network, index) {
    const data = galleryData[index];
    if (!data) return;

    const imgUrl  = data.url.startsWith('http') ? data.url : window.location.origin + data.url;
    const text    = data.title + ' — Galería CPAP Región Centro';
    const shareUrl = pageUrl;

    let url = '';
    switch (network) {
        case 'facebook':
            url = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(shareUrl)}&quote=${encodeURIComponent(text)}`;
            break;
        case 'twitter':
            url = `https://twitter.com/intent/tweet?text=${encodeURIComponent(text)}&url=${encodeURIComponent(shareUrl)}`;
            break;
        case 'whatsapp':
            url = `https://api.whatsapp.com/send?text=${encodeURIComponent(text + '\n' + shareUrl)}`;
            break;
        case 'copy':
            navigator.clipboard.writeText(shareUrl).then(() => {
                showCopyToast();
            });
            return;
    }

    if (url) window.open(url, '_blank', 'width=600,height=400,noopener');
}

function showCopyToast() {
    let toast = document.getElementById('shareCopyToast');
    if (!toast) {
        toast = document.createElement('div');
        toast.id = 'shareCopyToast';
        toast.className = 'share-copy-toast';
        toast.innerHTML = '<i class="fas fa-check-circle"></i> Enlace copiado';
        document.body.appendChild(toast);
    }
    toast.classList.add('show');
    setTimeout(() => toast.classList.remove('show'), 2200);
}
</script>
@endpush
