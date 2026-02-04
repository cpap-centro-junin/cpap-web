{{-- resources/views/nosotros/historia.blade.php --}}
@extends('layouts.app')

@section('title', 'Historia')

@vite([
    'resources/css/historia.css',
    'resources/js/historia.js'
])

@section('content')

<section id="timeline">

    <!-- Fundación -->
    <div class="tl-item">
        <div class="tl-bg" style="background-image:url('{{ asset('images/historia/creacion.jpg') }}')"></div>

        <div class="tl-year">
            <p>1985</p>
        </div>

        <div class="tl-content">
            <h1>Creación del CPAP</h1>
            <p>
                El Colegio Profesional de Antropólogos del Perú fue creado mediante la
                <strong>Ley Nº 24166</strong>, consolidando la representación y defensa
                profesional de los antropólogos a nivel nacional.
            </p>
        </div>
    </div>

    <!-- Consolidación -->
    <div class="tl-item">
        <div class="tl-bg" style="background-image:url('{{ asset('images/historia/consolidacion.jpg') }}')"></div>

        <div class="tl-year">
            <p>1995</p>
        </div>

        <div class="tl-content">
            <h1>Consolidación Institucional</h1>
            <p>
                El CPAP fortalece su estructura organizativa y amplía su presencia
                académica y social en distintas regiones del país.
            </p>
        </div>
    </div>

    <!-- Región Centro -->
    <div class="tl-item">
        <div class="tl-bg" style="background-image:url('{{ asset('images/historia/region-centro.jpg') }}')"></div>

        <div class="tl-year">
            <p>2008</p>
        </div>

        <div class="tl-content">
            <h1>Región Centro</h1>
            <p>
                Se impulsa el fortalecimiento del Colegio en la región centro,
                promoviendo investigación, desarrollo social y formación continua.
            </p>
        </div>
    </div>

    <!-- Actualidad -->
    <div class="tl-item">
        <div class="tl-bg" style="background-image:url('{{ asset('images/historia/actualidad.jpg') }}')"></div>

        <div class="tl-year">
            <p>Actualidad</p>
        </div>

        <div class="tl-content">
            <h1>Institución Moderna</h1>
            <p>
                El CPAP avanza hacia una gestión moderna, participativa y autosostenible,
                alineada con los desafíos sociales y científicos contemporáneos.
            </p>
        </div>
    </div>

</section>

@endsection
