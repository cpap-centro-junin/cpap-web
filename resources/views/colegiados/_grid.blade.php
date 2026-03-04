{{--
    Partial: grid de colegiados + paginación
    Variables requeridas:
      $colegiados — LengthAwarePaginator
      $buscar     — string (término buscado; '' si no hay)
--}}
@php $buscar = trim($buscar ?? ''); @endphp

@if($colegiados->total() === 0)

    <div class="no-results">
        <div class="no-results-icon">
            <i class="fas fa-user-slash"></i>
        </div>
        @if($buscar)
            <h3>No se encontró ningún colegiado<br>para <em>"{{ $buscar }}"</em></h3>
            <p>Prueba con el DNI completo, apellidos o número de colegiatura exacto.</p>
        @else
            <h3>No se encontraron colegiados</h3>
            <p>No hay registros que coincidan con los filtros seleccionados.</p>
        @endif
        <a href="{{ route('colegiados.index') }}" class="btn btn-primary">
            <i class="fas fa-list"></i> Ver todos los colegiados
        </a>
    </div>

@else

    <div class="colegiados-grid">
        @foreach($colegiados as $index => $colegiado)
            <a href="{{ route('colegiados.show', $colegiado) }}"
               class="colegiado-card"
               data-aos="fade-up"
               data-aos-delay="{{ min(($index % 4) * 80, 300) }}">

                <div class="card-header-bg">
                    <div class="card-avatar-wrapper">
                        @if($colegiado->foto)
                            <img src="{{ Storage::url($colegiado->foto) }}"
                                 alt="{{ $colegiado->nombre_completo }}"
                                 class="card-avatar">
                        @else
                            <div class="card-avatar-placeholder">
                                {{ strtoupper(substr($colegiado->nombres, 0, 1) . substr($colegiado->apellidos, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                </div>

                <div class="card-body">
                    <div class="card-name">{{ $colegiado->nombre_completo }}</div>
                    <div class="card-code">{{ $colegiado->codigo_cpap }}</div>
                    <div class="card-specialty">
                        @if($colegiado->orientacion)
                            {{ $colegiado->orientacion }}
                            @if($colegiado->especialidad)
                                <br><small style="opacity:0.75; font-size:11px;">{{ $colegiado->especialidad }}</small>
                            @endif
                        @elseif($colegiado->especialidad)
                            {{ $colegiado->especialidad }}
                        @else
                            Antropólogo Profesional
                        @endif
                    </div>
                    <div>
                        @if($colegiado->estado === 'activo')
                            <span class="estado-badge activo">
                                <i class="fas fa-circle" style="font-size:7px;"></i>
                                HABILITADO
                            </span>
                        @else
                            <span class="estado-badge inactivo">
                                <i class="fas fa-circle" style="font-size:7px;"></i>
                                NO HABILITADO
                            </span>
                        @endif
                    </div>
                </div>

                <div class="card-footer-action">
                    <i class="fas fa-eye"></i>
                    Ver Perfil
                </div>
            </a>
        @endforeach
    </div>

    @if($colegiados->hasPages())
        <div class="pagination-wrapper">
            {{ $colegiados->links() }}
        </div>
    @endif

@endif
