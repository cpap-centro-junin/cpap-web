@extends('layouts.app')

@section('title', 'Plan de Trabajo 2026 | CPAP Región Centro')

@section('content')

{{-- PAGE HEADER --}}
<section class="page-header">
    <div class="page-header-overlay"></div>
    <div class="container">
        <div class="page-header-content" data-aos="fade-up">
            <h1 class="page-title">
                <i class="fas fa-clipboard-list"></i>
                Plan de Trabajo 2026
            </h1>
            <p class="page-subtitle">
                Colegio Profesional de Antropólogos del Perú – Región Centro
            </p>
            <nav class="breadcrumb">
                <a href="{{ url('/') }}">Inicio</a>
                <span>/</span>
                <a href="{{ url('/#nosotros') }}">Nosotros</a>
                <span>/</span>
                <span>Plan de Trabajo 2026</span>
            </nav>
        </div>
    </div>
</section>

{{-- INTRO BANNER --}}
<section class="plan-intro-bar">
    <div class="container">
        <div class="plan-intro-grid">
            <div class="plan-intro-item" data-aos="fade-up" data-aos-delay="0">
                <div class="plan-intro-icon"><i class="fas fa-bullseye"></i></div>
                <div>
                    <span class="plan-intro-label">Objetivos Generales</span>
                    <span class="plan-intro-val">3</span>
                </div>
            </div>
            <div class="plan-intro-item" data-aos="fade-up" data-aos-delay="80">
                <div class="plan-intro-icon"><i class="fas fa-tasks"></i></div>
                <div>
                    <span class="plan-intro-label">Objetivos Específicos</span>
                    <span class="plan-intro-val">4</span>
                </div>
            </div>
            <div class="plan-intro-item" data-aos="fade-up" data-aos-delay="160">
                <div class="plan-intro-icon"><i class="fas fa-check-circle"></i></div>
                <div>
                    <span class="plan-intro-label">Total de Acciones</span>
                    <span class="plan-intro-val">9</span>
                </div>
            </div>
            <div class="plan-intro-item" data-aos="fade-up" data-aos-delay="240">
                <div class="plan-intro-icon"><i class="fas fa-calendar-alt"></i></div>
                <div>
                    <span class="plan-intro-label">Vigencia</span>
                    <span class="plan-intro-val">Año 2026</span>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- OBJETIVOS GENERALES --}}
<section class="plan-section plan-section--alt">
    <div class="container">
        <div class="plan-section-header" data-aos="fade-up">
            <span class="section-badge">Marco estratégico</span>
            <h2>Objetivos Generales</h2>
            <p>Lineamientos estratégicos que guían el accionar institucional durante el período 2026.</p>
        </div>

        <div class="plan-oe-grid">
            <div class="plan-oe-card" data-aos="fade-up" data-aos-delay="0">
                <div class="plan-oe-num">OE1</div>
                <div class="plan-oe-icon"><i class="fas fa-landmark"></i></div>
                <h3>Incidencia Institucional</h3>
                <p>Incidencia ante el CDN para fortalecer el proceso de legalización del CPAP y posicionamiento institucional a nivel de la Región Centro.</p>
            </div>
            <div class="plan-oe-card" data-aos="fade-up" data-aos-delay="100">
                <div class="plan-oe-num">OE2</div>
                <div class="plan-oe-icon"><i class="fas fa-graduation-cap"></i></div>
                <h3>Desarrollo Académico</h3>
                <p>Desarrollo de actividades académicas y de especialización que fortalezcan el rol antropológico en sus diversos campos de acción.</p>
            </div>
            <div class="plan-oe-card" data-aos="fade-up" data-aos-delay="200">
                <div class="plan-oe-num">OE3</div>
                <div class="plan-oe-icon"><i class="fas fa-hands-helping"></i></div>
                <h3>Confraternidad y Cultura</h3>
                <p>Promover espacios de confraternidad o culturales del CPAP Región Centro que refuercen la identidad gremial.</p>
            </div>
        </div>
    </div>
</section>

{{-- OBJETIVOS ESPECÍFICOS Y ACCIONES --}}
<section class="plan-section">
    <div class="container">
        <div class="plan-section-header" data-aos="fade-up">
            <span class="section-badge">Operativización</span>
            <h2>Objetivos Específicos y Acciones</h2>
            <p>Detalle de las actividades concretas a ejecutar durante el año 2026.</p>
        </div>

        {{-- OBJ 1 --}}
        <div class="plan-obj-block" data-aos="fade-up">
            <div class="plan-obj-header">
                <div class="plan-obj-badge plan-obj-badge--1">01</div>
                <div>
                    <h3>Organizar el Registro de Antropólogos de la Región Centro</h3>
                    <span class="plan-obj-period"><i class="fas fa-clock"></i> Todo el año 2026</span>
                </div>
            </div>
            <div class="plan-actions-table">
                <div class="plan-action-row plan-action-row--header">
                    <span>Acción</span>
                    <span>Período</span>
                </div>
                <div class="plan-action-row">
                    <div class="plan-action-name">
                        <i class="fas fa-circle-dot"></i>
                        Actualizar el Registro del Colegio de Antropólogos de la Región Centro.
                    </div>
                    <div class="plan-action-period">
                        <span class="plan-period-chip plan-period--full">Todo el año</span>
                    </div>
                </div>
                <div class="plan-action-row">
                    <div class="plan-action-name">
                        <i class="fas fa-circle-dot"></i>
                        Elaborar un cuadro de onomásticos de los Agremiados.
                    </div>
                    <div class="plan-action-period">
                        <span class="plan-period-chip">Enero – Febrero</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- OBJ 2 --}}
        <div class="plan-obj-block" data-aos="fade-up">
            <div class="plan-obj-header">
                <div class="plan-obj-badge plan-obj-badge--2">02</div>
                <div>
                    <h3>Ordenar los Datos del Perfil Profesional</h3>
                    <span class="plan-obj-period"><i class="fas fa-clock"></i> Enero – Junio 2026</span>
                </div>
            </div>
            <div class="plan-actions-table">
                <div class="plan-action-row plan-action-row--header">
                    <span>Acción</span>
                    <span>Período</span>
                </div>
                <div class="plan-action-row">
                    <div class="plan-action-name">
                        <i class="fas fa-circle-dot"></i>
                        Procesar los datos de las encuestas y experiencias profesionales.
                    </div>
                    <div class="plan-action-period">
                        <span class="plan-period-chip">Enero – Marzo</span>
                    </div>
                </div>
                <div class="plan-action-row">
                    <div class="plan-action-name">
                        <i class="fas fa-circle-dot"></i>
                        Publicar en la revista antropológica los datos más relevantes.
                    </div>
                    <div class="plan-action-period">
                        <span class="plan-period-chip">Abril – Mayo</span>
                    </div>
                </div>
                <div class="plan-action-row">
                    <div class="plan-action-name">
                        <i class="fas fa-circle-dot"></i>
                        Implementar los perfiles profesionales dentro de la página Web.
                    </div>
                    <div class="plan-action-period">
                        <span class="plan-period-chip plan-period--gold">Junio</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- OBJ 3 --}}
        <div class="plan-obj-block" data-aos="fade-up">
            <div class="plan-obj-header">
                <div class="plan-obj-badge plan-obj-badge--3">03</div>
                <div>
                    <h3>Curso de Asháninka</h3>
                    <span class="plan-obj-period"><i class="fas fa-clock"></i> Enero – Febrero 2026</span>
                </div>
            </div>
            <div class="plan-actions-table">
                <div class="plan-action-row plan-action-row--header">
                    <span>Acción</span>
                    <span>Período</span>
                </div>
                <div class="plan-action-row">
                    <div class="plan-action-name">
                        <i class="fas fa-circle-dot"></i>
                        Coordinar con el docente de Asháninka.
                    </div>
                    <div class="plan-action-period">
                        <span class="plan-period-chip">Enero – Febrero</span>
                    </div>
                </div>
                <div class="plan-action-row">
                    <div class="plan-action-name">
                        <i class="fas fa-circle-dot"></i>
                        Lanzamiento del curso.
                    </div>
                    <div class="plan-action-period">
                        <span class="plan-period-chip plan-period--gold">Febrero</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- OBJ 4 --}}
        <div class="plan-obj-block" data-aos="fade-up">
            <div class="plan-obj-header">
                <div class="plan-obj-badge plan-obj-badge--4">04</div>
                <div>
                    <h3>Elaboración del Reglamento Interno de Habilitaciones CPAP-RC</h3>
                    <span class="plan-obj-period"><i class="fas fa-clock"></i> Febrero – Marzo 2026</span>
                </div>
            </div>
            <div class="plan-actions-table">
                <div class="plan-action-row plan-action-row--header">
                    <span>Acción</span>
                    <span>Período</span>
                </div>
                <div class="plan-action-row">
                    <div class="plan-action-name">
                        <i class="fas fa-circle-dot"></i>
                        Redacción y procesamiento de propuestas.
                    </div>
                    <div class="plan-action-period">
                        <span class="plan-period-chip plan-period--gold">Febrero</span>
                    </div>
                </div>
                <div class="plan-action-row">
                    <div class="plan-action-name">
                        <i class="fas fa-circle-dot"></i>
                        Evaluación del Consejo Directivo.
                    </div>
                    <div class="plan-action-period">
                        <span class="plan-period-chip plan-period--gold">Marzo</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

{{-- CRONOGRAMA 2026 --}}
<section class="plan-section plan-section--alt">
    <div class="container">
        <div class="plan-section-header" data-aos="fade-up">
            <span class="section-badge">Planificación temporal</span>
            <h2>Cronograma de Actividades 2026</h2>
            <p>Distribución mensual de las acciones a ejecutar durante el año.</p>
        </div>

        <div class="plan-gantt-wrap" data-aos="fade-up">
            <div class="plan-gantt-scroll">
                <table class="plan-gantt-table">
                    <thead>
                        <tr>
                            <th class="plan-gantt-action-col">Acción</th>
                            <th>Ene</th>
                            <th>Feb</th>
                            <th>Mar</th>
                            <th>Abr</th>
                            <th>May</th>
                            <th>Jun</th>
                            <th>Jul</th>
                            <th>Ago</th>
                            <th>Set</th>
                            <th>Oct</th>
                            <th>Nov</th>
                            <th>Dic</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $acciones = [
                            [
                                'num'  => 1,
                                'text' => 'Actualizar el Registro del Colegio de Antropólogos de la Región Centro.',
                                'meses'=> [1,2,3,4,5,6,7,8,9,10,11,12],
                            ],
                            [
                                'num'  => 2,
                                'text' => 'Elaborar un cuadro de onomásticos de los Agremiados.',
                                'meses'=> [1,2],
                            ],
                            [
                                'num'  => 3,
                                'text' => 'Procesar los datos de las encuestas y experiencias profesionales.',
                                'meses'=> [1,2,3],
                            ],
                            [
                                'num'  => 4,
                                'text' => 'Publicar en la revista antropológica los datos más relevantes.',
                                'meses'=> [4,5],
                            ],
                            [
                                'num'  => 5,
                                'text' => 'Implementar los perfiles profesionales dentro de la página Web.',
                                'meses'=> [6],
                            ],
                            [
                                'num'  => 6,
                                'text' => 'Coordinar con el docente de Asháninka.',
                                'meses'=> [1,2],
                            ],
                            [
                                'num'  => 7,
                                'text' => 'Lanzamiento del curso de Asháninka.',
                                'meses'=> [2],
                            ],
                            [
                                'num'  => 8,
                                'text' => 'Redacción y procesamiento de propuestas del Reglamento Interno.',
                                'meses'=> [2],
                            ],
                            [
                                'num'  => 9,
                                'text' => 'Evaluación del Consejo Directivo del Reglamento Interno.',
                                'meses'=> [3],
                            ],
                        ];
                        @endphp

                        @foreach($acciones as $accion)
                        <tr class="{{ $loop->odd ? 'plan-gantt-odd' : '' }}">
                            <td class="plan-gantt-action-col">
                                <span class="plan-gantt-num">{{ $accion['num'] }}</span>
                                {{ $accion['text'] }}
                            </td>
                            @for($m = 1; $m <= 12; $m++)
                            <td class="{{ in_array($m, $accion['meses']) ? 'plan-gantt-active' : '' }}">
                                @if(in_array($m, $accion['meses']))
                                <span class="plan-gantt-dot"></span>
                                @endif
                            </td>
                            @endfor
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <p class="plan-gantt-note">
                <i class="fas fa-info-circle"></i>
                Las celdas marcadas indican los meses en que la acción se encuentra activa o en ejecución.
            </p>
        </div>
    </div>
</section>

{{-- CTA FINAL --}}
<section class="plan-cta-section">
    <div class="container">
        <div class="plan-cta-card" data-aos="fade-up">
            <div class="plan-cta-icon"><i class="fas fa-clipboard-check"></i></div>
            <h3>¿Tienes consultas sobre el Plan de Trabajo?</h3>
            <p>Comunícate con el Consejo Directivo o envíanos un mensaje a través de nuestro formulario de contacto.</p>
            <div class="plan-cta-btns">
                <a href="{{ route('contacto.index') }}" class="btn btn-primary">
                    <i class="fas fa-envelope"></i> Contáctanos
                </a>
                <a href="{{ route('nosotros.consejo-directivo') }}" class="btn btn-outline">
                    <i class="fas fa-users-cog"></i> Ver Consejo Directivo
                </a>
            </div>
        </div>
    </div>
</section>

@endsection
