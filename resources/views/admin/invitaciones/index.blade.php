@extends('layouts.admin')

@section('title', 'Invitaciones')
@section('page-title', 'Sistema de Invitaciones')

@section('content')

<div class="admin-container">

    {{-- Mensajes de éxito/error --}}
    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle"></i>
            {{ $errors->first() }}
        </div>
    @endif

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Invitaciones</h1>
            <p class="page-subtitle">Gestiona las invitaciones para nuevos administradores del sistema</p>
        </div>
        <button class="btn btn-primary" onclick="toggleInviteForm()" id="btnNuevaInv">
            <i class="fas fa-plus"></i>
            Nueva Invitación
        </button>
    </div>

    {{-- Formulario colapsable --}}
    <div class="inv-form-panel" id="inviteFormPanel">
        <div class="inv-form-panel__header">
            <h3><i class="fas fa-paper-plane"></i> Enviar Invitación</h3>
            <button type="button" class="inv-form-close" onclick="toggleInviteForm()" title="Cerrar">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="inv-form-panel__body">
            <form action="{{ route('admin.invitaciones.enviar') }}" method="POST" class="inv-send-form">
                @csrf
                <div class="form-group">
                    <label for="email">Correo del invitado <span class="required">*</span></label>
                    <div class="inv-input-row">
                        <input type="email"
                               name="email"
                               id="email"
                               class="form-control"
                               placeholder="ejemplo@correo.com"
                               value="{{ old('email') }}"
                               required>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i>
                            Enviar Invitación
                        </button>
                    </div>
                    <span class="form-text">Se enviará un enlace de registro al correo indicado.</span>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabla de invitaciones --}}
    <div class="table-card">

        {{-- Búsqueda + conteo --}}
        <div class="inv-table-tools">
            <div class="inv-table-tools__search">
                <i class="fas fa-search"></i>
                <input type="text"
                       id="searchInput"
                       class="form-control"
                       placeholder="Buscar por email o token...">
            </div>
            <span class="inv-count text-muted">
                {{ $invitaciones->count() }} invitación{{ $invitaciones->count() !== 1 ? 'es' : '' }}
                &nbsp;·&nbsp;
                {{ $invitaciones->where('usado', false)->count() }} pendiente{{ $invitaciones->where('usado', false)->count() !== 1 ? 's' : '' }}
            </span>
        </div>

        @if($invitaciones->count() > 0)
            <div class="table-responsive">
                <table class="table" id="inviteTable">
                    <thead>
                        <tr>
                            <th>Email</th>
                            <th>Token</th>
                            <th style="width: 120px;">Estado</th>
                            <th style="width: 120px;">Fecha</th>
                            <th class="text-center" style="width: 100px;">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invitaciones as $inv)
                            <tr>
                                <td>
                                    <div class="inv-email-cell">
                                        <div class="inv-avatar">{{ strtoupper(substr($inv->email, 0, 1)) }}</div>
                                        <span>{{ $inv->email }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="inv-token-cell">
                                        <code class="inv-token">{{ Str::limit($inv->token, 16) }}…</code>
                                        <button class="btn-copy"
                                                onclick="copyToken('{{ $inv->token }}')"
                                                title="Copiar token completo">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </div>
                                </td>
                                <td>
                                    @if($inv->usado)
                                        <span class="badge badge-secondary">
                                            <i class="fas fa-check-double"></i> Usado
                                        </span>
                                    @else
                                        <span class="badge badge-success">
                                            <i class="fas fa-clock"></i> Pendiente
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <span class="text-muted">{{ $inv->created_at->format('d/m/Y') }}</span>
                                    <br>
                                    <small class="text-muted" style="font-size:11px;">{{ $inv->created_at->diffForHumans() }}</small>
                                </td>
                                <td class="text-center">
                                    @if(!$inv->usado)
                                        <button class="btn-icon btn-info"
                                                onclick="copyInviteLink('{{ url('/register?token=' . $inv->token) }}')"
                                                title="Copiar enlace de registro">
                                            <i class="fas fa-link"></i>
                                        </button>
                                    @else
                                        <span class="text-muted" style="font-size: 12px;">—</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-envelope-open"></i>
                <h3>No hay invitaciones registradas</h3>
                <p>Envía la primera invitación para que un nuevo usuario pueda registrarse.</p>
                <button class="btn btn-primary" onclick="toggleInviteForm()">
                    <i class="fas fa-plus"></i>
                    Enviar Primera Invitación
                </button>
            </div>
        @endif
    </div>

</div>

@endsection

@push('scripts')
<script>
/* Toggle del panel de nueva invitación */
function toggleInviteForm() {
    const panel = document.getElementById('inviteFormPanel');
    panel.classList.toggle('show');
    const btn = document.getElementById('btnNuevaInv');
    if (panel.classList.contains('show')) {
        btn.innerHTML = '<i class="fas fa-times"></i> Cerrar';
        document.getElementById('email').focus();
    } else {
        btn.innerHTML = '<i class="fas fa-plus"></i> Nueva Invitación';
    }
}

/* Copiar token */
function copyToken(token) {
    navigator.clipboard.writeText(token).then(() => {
        Swal.fire({
            toast: true, position: 'top-end', icon: 'success',
            title: 'Token copiado', showConfirmButton: false, timer: 1800
        });
    });
}

/* Copiar enlace de registro */
function copyInviteLink(url) {
    navigator.clipboard.writeText(url).then(() => {
        Swal.fire({
            toast: true, position: 'top-end', icon: 'success',
            title: 'Enlace copiado', showConfirmButton: false, timer: 1800
        });
    });
}

/* Búsqueda en tabla */
document.getElementById('searchInput').addEventListener('keyup', function () {
    const value = this.value.toLowerCase();
    document.querySelectorAll('#inviteTable tbody tr').forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(value) ? '' : 'none';
    });
});

/* Abrir form automáticamente si hay error de validación */
@if($errors->any())
    document.addEventListener('DOMContentLoaded', () => toggleInviteForm());
@endif
</script>
@endpush
