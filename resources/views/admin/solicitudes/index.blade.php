@extends('layouts.admin')

@section('title', 'Solicitudes de Ofertas')
@section('page-title', 'Solicitudes de Ofertas Laborales')

@section('content')

{{-- Breadcrumb --}}
<div style="margin-bottom:16px;">
    <a href="{{ route('admin.bolsa.index') }}" 
       style="display:inline-flex;align-items:center;gap:6px;color:var(--medium-gray);text-decoration:none;font-size:14px;font-weight:500;transition:color 0.2s;">
        <i class="fas fa-arrow-left"></i>
        <span>Volver a Bolsa de Trabajo</span>
    </a>
</div>

<div class="msg-list-card">

    <div class="msg-list-header">
        <div class="msg-list-header-left">
            <div class="msg-list-icon"><i class="fas fa-clipboard-list"></i></div>
            <div>
                <h3>Bandeja de solicitudes</h3>
                <p>{{ $solicitudes->total() }} solicitud{{ $solicitudes->total() != 1 ? 'es' : '' }} recibida{{ $solicitudes->total() != 1 ? 's' : '' }}</p>
            </div>
        </div>
        @php $newCount = $solicitudes->getCollection()->where('revisado', false)->count(); @endphp
        @if($newCount > 0)
        <span class="msg-unread-badge">{{ $newCount }} nueva{{ $newCount != 1 ? 's' : '' }}</span>
        @endif
    </div>

    <div class="msg-list-body">
        @forelse($solicitudes as $sol)
        <div class="msg-row {{ !$sol->revisado ? 'msg-row--new' : '' }}">

            <div class="msg-avatar">
                {{ strtoupper(substr($sol->nombre_contacto ?? $sol->empresa ?? 'S', 0, 2)) }}
            </div>

            <div class="msg-row-main">
                <div class="msg-row-top">
                    <span class="msg-sender">{{ $sol->nombre_contacto ?? 'Sin nombre' }}</span>
                    @if(!$sol->revisado)
                        <span class="msg-badge msg-badge--new"><i class="fas fa-circle"></i> Nueva</span>
                    @else
                        <span class="msg-badge msg-badge--read"><i class="fas fa-check-double"></i> Revisada</span>
                    @endif
                </div>
                <div class="msg-subject">{{ $sol->titulo }}</div>
                <div class="msg-preview">
                    <span class="msg-email"><i class="fas fa-building"></i> {{ $sol->empresa ?? 'Sin empresa' }}</span>
                    <span class="msg-email"><i class="fas fa-envelope"></i> {{ $sol->email_contacto }}</span>
                    @if($sol->tipo)
                    <span class="msg-phone"><i class="fas fa-tag"></i> {{ $sol->tipo_label }}</span>
                    @endif
                </div>
            </div>

            <div class="msg-row-right">
                <div class="msg-date">
                    <i class="fas fa-clock"></i>
                    {{ $sol->created_at->format('d/m/Y') }}
                </div>
                <div class="msg-actions">
                    <a href="{{ route('admin.solicitudes.show', $sol) }}" class="msg-btn msg-btn--view">
                        <i class="fas fa-eye"></i> Ver
                    </a>
                    <form action="{{ route('admin.solicitudes.rechazar', $sol) }}" method="POST" class="delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="msg-btn msg-btn--delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>

        </div>
        @empty
        <div class="msg-empty">
            <div class="msg-empty-icon"><i class="fas fa-clipboard-list"></i></div>
            <h4>Sin solicitudes</h4>
            <p>Aún no has recibido solicitudes de ofertas laborales.</p>
        </div>
        @endforelse
    </div>

    @if($solicitudes->hasPages())
    <div class="msg-pagination">
        {{ $solicitudes->links() }}
    </div>
    @endif

</div>

@endsection

@push('scripts')
<script>
document.querySelectorAll('.delete-form').forEach(form => {
    form.addEventListener('submit', function(e){
        e.preventDefault();
        Swal.fire({
            title: '¿Rechazar solicitud?',
            text: "Se eliminará la solicitud de oferta. Esta acción no se puede deshacer.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#7b1e3a',
            cancelButtonColor: '#999',
            confirmButtonText: 'Sí, rechazar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if(result.isConfirmed) form.submit();
        });
    });
});
</script>
@endpush
