@php use Illuminate\Support\Str; @endphp

@extends('layouts.admin')

@section('title', 'Bolsa de Trabajo')
@section('page-title', 'Bolsa de Trabajo')

@section('content')

{{-- HEADER --}}
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;flex-wrap:wrap;gap:12px;">
    <div>
        <h1 style="font-size:22px;font-weight:700;color:var(--dark);margin:0 0 4px;">Bolsa de Trabajo</h1>
        <p style="color:var(--medium-gray);font-size:14px;margin:0;">{{ $ofertas->total() }} oferta{{ $ofertas->total() !== 1 ? 's' : '' }} en total</p>
    </div>
    <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
        @php $pendingSolicitudes = \App\Models\BolsaTrabajo::noRevisadas()->count(); @endphp
        <a href="{{ route('admin.solicitudes.index') }}" 
           style="display:inline-flex;align-items:center;gap:8px;padding:10px 16px;background:{{ $pendingSolicitudes > 0 ? 'rgba(237,108,2,0.1)' : 'rgba(0,0,0,0.04)' }};color:{{ $pendingSolicitudes > 0 ? '#ed6c02' : 'var(--medium-gray)' }};border:1px solid {{ $pendingSolicitudes > 0 ? 'rgba(237,108,2,0.2)' : 'rgba(0,0,0,0.08)' }};border-radius:10px;text-decoration:none;font-size:14px;font-weight:600;transition:all 0.2s;">
            <i class="fas fa-clipboard-list"></i>
            <span>
                @if($pendingSolicitudes > 0)
                    {{ $pendingSolicitudes }} Solicitud{{ $pendingSolicitudes !== 1 ? 'es' : '' }} Pendiente{{ $pendingSolicitudes !== 1 ? 's' : '' }}
                @else
                    Ver Solicitudes
                @endif
            </span>
        </a>
        <a href="{{ route('admin.bolsa.create') }}" class="primary-btn">
            <i class="fas fa-plus"></i> Nueva Oferta
        </a>
    </div>
</div>

{{-- FLASH --}}
@if(session('success'))
<div style="background:var(--success-light);color:var(--success);border:1px solid rgba(46,125,50,0.2);border-radius:var(--radius-sm);padding:14px 18px;margin-bottom:20px;display:flex;align-items:center;gap:10px;font-size:14px;font-weight:500;">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
</div>
@endif

{{-- TABLA --}}
<div class="admin-table">
    <table>
        <thead>
            <tr>
                <th>Título</th>
                <th>Empresa</th>
                <th>Ubicación</th>
                <th>Tipo</th>
                <th>Área</th>
                <th>Salario</th>
                <th>Publicado</th>
                <th>Estado</th>
                <th style="text-align:center;width:160px;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($ofertas as $oferta)
            <tr>
                <td>
                    <div style="font-weight:600;color:var(--dark);font-size:14px;margin-bottom:3px;">
                        {{ Str::limit($oferta->titulo, 50) }}
                    </div>
                    @if($oferta->fecha_vencimiento && $oferta->fecha_vencimiento->isPast())
                    <span style="display:inline-flex;align-items:center;gap:3px;margin-top:4px;background:rgba(198,40,40,0.1);color:var(--danger);padding:2px 8px;border-radius:50px;font-size:11px;font-weight:600;">
                        <i class="fas fa-clock" style="font-size:9px;"></i> Vencida
                    </span>
                    @endif
                </td>
                <td style="color:var(--medium-gray);font-size:13px;">
                    <i class="fas fa-building" style="margin-right:4px;font-size:11px;"></i>{{ $oferta->empresa }}
                </td>
                <td style="color:var(--medium-gray);font-size:13px;">
                    <i class="fas fa-map-marker-alt" style="margin-right:4px;font-size:11px;"></i>{{ $oferta->ubicacion }}
                </td>
                <td>
                    <span style="background:rgba(139,21,56,0.08);color:var(--primary);padding:4px 10px;border-radius:50px;font-size:12px;font-weight:600;">
                        {{ $oferta->tipo_label }}
                    </span>
                </td>
                <td>
                    <span style="background:rgba(21,101,192,0.08);color:#1565c0;padding:4px 10px;border-radius:50px;font-size:12px;font-weight:600;">
                        {{ $oferta->area_label }}
                    </span>
                </td>
                <td style="color:var(--medium-gray);font-size:13px;">{{ $oferta->salario ?? '—' }}</td>
                <td style="color:var(--medium-gray);font-size:13px;">{{ $oferta->fecha_publicacion->format('d/m/Y') }}</td>
                <td>
                    <span class="badge {{ $oferta->activo ? 'published' : 'hidden' }}">
                        <i class="fas fa-circle" style="font-size:7px;"></i>
                        {{ $oferta->activo ? 'Activa' : 'Inactiva' }}
                    </span>
                </td>
                <td>
                    <div style="display:flex;gap:6px;justify-content:center;">
                        <a href="{{ route('admin.bolsa.edit', $oferta) }}"
                           style="display:inline-flex;align-items:center;gap:4px;padding:6px 10px;background:var(--warning-light);color:var(--warning);border-radius:var(--radius-sm);font-size:12px;font-weight:600;text-decoration:none;">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <form action="{{ route('admin.bolsa.destroy', $oferta) }}" method="POST" style="display:inline;" class="delete-form">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    style="display:inline-flex;align-items:center;padding:6px 10px;background:var(--danger-light);color:var(--danger);border-radius:var(--radius-sm);font-size:12px;border:none;cursor:pointer;">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9">
                    <div class="empty-state">
                        <i class="fas fa-briefcase"></i>
                        <p>No hay ofertas de trabajo registradas.<br>Crea tu primera oferta para comenzar.</p>
                        <a href="{{ route('admin.bolsa.create') }}" class="primary-btn" style="display:inline-flex;">
                            <i class="fas fa-plus"></i> Nueva Oferta
                        </a>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($ofertas->hasPages())
<div style="margin-top:20px;display:flex;justify-content:center;">
    {{ $ofertas->links() }}
</div>
@endif

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Confirmación de eliminación con SweetAlert2
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            Swal.fire({
                title: '¿Eliminar esta oferta?',
                text: 'Esta acción no se puede deshacer',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d32f2f',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>
@endpush
