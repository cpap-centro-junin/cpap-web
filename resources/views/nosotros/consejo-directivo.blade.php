{{-- resources/views/nosotros/consejo-directivo.blade.php --}}
@extends('layouts.app')

@section('title', 'Consejo Directivo')

{{-- CSS y JS con VITE --}}
@vite([
    'resources/css/consejo.css',
    'resources/js/consejo.js'
])

@section('content')
<section class="section-padding bg-light" id="consejo">
    <div class="container">

        <!-- Header -->
        <div class="section-header text-center mb-5" data-aos="fade-up">
            <span class="section-badge"></span>
            <h2 class="section-title">Consejo Directivo</h2>
            <p class="section-subtitle">
                Equipo responsable de la dirección y representación institucional
            </p>
        </div>

        <!-- Cards estilo moderno -->
        <div class="row">

            @php
                $consejo = [
                    ['cargo'=>'Presidente','nombre'=>'Dr. Juan Pérez','imagen'=>'presidente.jpg'],
                    ['cargo'=>'Vicepresidente','nombre'=>'MSc. María López','imagen'=>'vicepresidente.jpg'],
                    ['cargo'=>'Secretario','nombre'=>'Lic. Carlos Ramírez','imagen'=>'secretario.jpg'],
                    ['cargo'=>'Tesorero','nombre'=>'Lic. Ana Torres','imagen'=>'tesorero.jpg'],
                    ['cargo'=>'Vocal','nombre'=>'Lic. Pedro Huamán','imagen'=>'vocal.jpg'],
                ];
            @endphp

            @foreach($consejo as $index => $miembro)
                <div class="example-1 card" data-aos="zoom-in" data-aos-delay="{{ $index * 100 }}">
                    <div class="wrapper">
                        <img src="{{ asset('images/consejo/'.$miembro['imagen']) }}"
                             alt="{{ $miembro['cargo'] }}"
                             onerror="this.src='https://images.unsplash.com/photo-1502685104226-ee32379fefbe?w=400'">

                        <div class="date">
                            <span class="day">{{ now()->day }}</span>
                            <span class="month">{{ now()->format('M') }}</span>
                            <span class="year">{{ now()->year }}</span>
                        </div>

                        <div class="data">
                            <div class="content">
                                <span class="author">{{ $miembro['cargo'] }}</span>
                                <h1 class="title">{{ $miembro['nombre'] }}</h1>
                                <p class="text">Responsable de la gestión y supervisión de la institución.</p>
                                <label for="show-menu-{{ $index }}" class="menu-button"><span></span></label>
                            </div>
                            <input type="checkbox" id="show-menu-{{ $index }}" />
                            <ul class="menu-content">
                                <li><a href="#" class="fa fa-bookmark-o"></a></li>
                                <li><a href="#" class="fa fa-heart-o"><span>{{ rand(10,100) }}</span></a></li>
                                <li><a href="#" class="fa fa-comment-o"><span>{{ rand(0,20) }}</span></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>

        <!-- Botón -->
        <div class="text-center mt-5">
            <a href="{{ route('home') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-arrow-left me-2"></i> Volver al inicio
            </a>
        </div>

    </div>
</section>
@endsection
