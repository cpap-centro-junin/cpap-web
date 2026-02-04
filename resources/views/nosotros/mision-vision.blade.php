@extends('layouts.app')

@section('title', 'Misión y Visión')

@vite([
    'resources/css/mision-vision.css',
    'resources/js/mision-vision.js'
])

@section('content')

<section class="mv-section">
    <div class="mv-tabs">

        <!-- TAB 1 -->
        <input type="radio" name="mv-tabs" id="tab1" checked>
        <div class="mv-content">
            <div class="mv-grid">
                <div class="mv-text">
                    <span class="mv-tag">
                        <i class="fas fa-bullseye"></i> Misión
                    </span>
                    <h2>Misión Institucional</h2>
                    <p>
                        Velar por el ejercicio y defensa profesional de los antropólogos,
                        promoviendo su capacitación permanente y fortaleciendo el rol de la
                        antropología en el desarrollo social, académico y científico del país.
                    </p>
                </div>
                <div class="mv-image">
                    <img src="{{ asset('images/noticias/ceremonia-juramentacion.png') }}"
                         onerror="this.src='https://images.unsplash.com/photo-1523580846011-d3a5bc25702b?w=900'">
                </div>
            </div>
        </div>

        <!-- TAB 2 -->
        <input type="radio" name="mv-tabs" id="tab2">
        <div class="mv-content">
            <div class="mv-grid">
                <div class="mv-text">
                    <span class="mv-tag">
                        <i class="fas fa-user-shield"></i> Ética
                    </span>
                    <h2>Compromiso Profesional</h2>
                    <p>
                        Defender el ejercicio ético de la profesión, garantizando calidad,
                        responsabilidad social y respeto a la diversidad cultural del Perú.
                    </p>
                </div>
                <div class="mv-image">
                    <img src="{{ asset('images/noticias/ceremonia-juramentacion.png') }}"
                         onerror="this.src='https://images.unsplash.com/photo-1556761175-5973dc0f32e7?w=900'">
                </div>
            </div>
        </div>

        <!-- TAB 3 -->
        <input type="radio" name="mv-tabs" id="tab3">
        <div class="mv-content">
            <div class="mv-grid">
                <div class="mv-text">
                    <span class="mv-tag">
                        <i class="fas fa-eye"></i> Visión
                    </span>
                    <h2>Visión Institucional</h2>
                    <p>
                        Ser una institución moderna, sólida y organizada, con miembros
                        altamente capacitados y proyectos de impacto nacional.
                    </p>
                </div>
                <div class="mv-image">
                    <img src="{{ asset('images/noticias/ceremonia-juramentacion.png') }}"
                         onerror="this.src='https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?w=900'">
                </div>
            </div>
        </div>

        <!-- TAB 4 -->
        <input type="radio" name="mv-tabs" id="tab4">
        <div class="mv-content">
            <div class="mv-grid">
                <div class="mv-text">
                    <span class="mv-tag">
                        <i class="fas fa-globe-americas"></i> Proyección
                    </span>
                    <h2>Proyección Nacional</h2>
                    <p>
                        Consolidarnos como un órgano de jerarquía nacional con presencia
                        activa en todo el territorio peruano.
                    </p>
                </div>
                <div class="mv-image">
                    <img src="{{ asset('images/proyeccion.jpg') }}"
                         onerror="this.src='https://images.unsplash.com/photo-1506784983877-45594efa4cbe?w=900'">
                </div>
            </div>
        </div>

    </div>
</section>

@endsection
