@extends('layouts.app')

@section('title','Proceso de Colegiatura | CPAP Región Centro')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/pages/colegiatura.css') }}">
@endpush

@section('content')

<section class="cpap-hero colegiatura-hero">
    <div class="cpap-hero-content">
        <div class="cpap-hero-badge">
            <i class="fas fa-user-graduate"></i>
            Servicios CPAP – Colegiatura
        </div>
        <h1>Proceso de <span>Colegiatura</span></h1>
        <p>Conoce paso a paso cómo incorporarte oficialmente al Colegio Profesional de Antropólogos del Perú – Región Centro.</p>
    </div>
</section>

<section class="colegiatura-flow-section">
    <div class="cpap-container">

        <div class="flow-wrapper">

            <!-- INICIO -->
            <div class="flow-start">INICIO</div>

            <!-- PASOS -->
            @php
                $steps = [
                    [
                        'title' => 'Revisión de Requisitos',
                        'content' => 'Verifica que cumplas con los requisitos mínimos establecidos.',
                        'docs' => ['Ficha de inscripción', 'Formato declaración jurada'],
                        'recommend' => 'Revisa cuidadosamente que tu título esté registrado en SUNEDU.'
                    ],
                    [
                        'title' => 'Preparación del Expediente',
                        'content' => 'Reúne todos los documentos requeridos en físico y digital.',
                        'docs' => ['Copia DNI', 'Título legalizado', 'Foto carnet'],
                        'recommend' => 'Presentar copias legibles y actualizadas.'
                    ],
                    [
                        'title' => 'Presentación en Mesa de Partes',
                        'content' => 'Entrega formal del expediente completo.',
                        'docs' => [],
                        'recommend' => 'Solicita tu cargo de recepción.'
                    ],
                    [
                        'title' => 'Evaluación Técnica',
                        'content' => 'Revisión por parte del Consejo Directivo Regional.',
                        'docs' => [],
                        'recommend' => 'El proceso puede tomar hasta 10 días hábiles.'
                    ],
                    [
                        'title' => 'Aprobación Institucional',
                        'content' => 'Emisión de resolución de colegiatura.',
                        'docs' => [],
                        'recommend' => 'Recibirás notificación por correo.'
                    ],
                    [
                        'title' => 'Pago de Derechos',
                        'content' => 'Realizar pago correspondiente a inscripción y cuota anual.',
                        'docs' => ['Cuenta bancaria oficial'],
                        'recommend' => 'Conservar comprobante de pago.'
                    ],
                    [
                        'title' => 'Registro Oficial y Número de Colegiatura',
                        'content' => 'Asignación de número profesional y habilitación.',
                        'docs' => [],
                        'recommend' => 'Puedes verificar tu estado en el directorio.'
                    ],
                ];
            @endphp

            @foreach($steps as $index => $step)
                <div class="flow-step {{ $index % 2 == 0 ? 'left' : 'right' }}">
                    <div class="flow-card">
                        <div class="step-number">{{ str_pad($index+1, 2, '0', STR_PAD_LEFT) }}</div>
                        <h3>{{ $step['title'] }}</h3>
                        <p>{{ $step['content'] }}</p>

                        @if(count($step['docs']) > 0)
                        <div class="flow-docs">
                            <strong>Documentos:</strong>
                            <ul>
                                @foreach($step['docs'] as $doc)
                                    <li>
                                        <i class="fas fa-file-pdf"></i>
                                        <a href="#">{{ $doc }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <div class="flow-recommend">
                            <i class="fas fa-lightbulb"></i>
                            {{ $step['recommend'] }}
                        </div>
                    </div>
                </div>
            @endforeach

            <!-- FIN -->
            <div class="flow-end">FIN</div>

        </div>

    </div>
</section>

@endsection
