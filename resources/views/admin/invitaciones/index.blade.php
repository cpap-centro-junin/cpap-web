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

    {{-- FILTROS --}}
    <x-admin-filters
        :searchPlaceholder="'Buscar por email...'"
        :searchField="'q'"
        :route="route('admin.invitaciones.index')"
        :clearRoute="route('admin.invitaciones.index')"
        :filters="[
            [
                'field' => 'estado',
                'label' => 'Estado',
                'options' => [
                    'usado' => 'Usadas',
                    'no-usado' => 'Pendientes',
                ]
            ],
        ]"
    />

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
                            <th style="width:40px;">
                                <input type="checkbox" id="selectAll" title="Seleccionar todo">
                            </th>
                            <th>Email</th>
                            <th>Token</th>
                            <th style="width: 120px;">Estado</th>
                            <th style="width: 120px;">Fecha</th>
                            <th class="text-center" style="width: 160px;">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invitaciones as $inv)
                            <tr>
                                <td class="text-center">
                                    @if(!$inv->usado)
                                        <input type="checkbox"
                                               class="invite-checkbox"
                                               value="{{ $inv->id }}"
                                               title="Seleccionar invitación">
                                    @else
                                        <span class="text-muted" style="font-size:12px;" title="Invitación usada: protegida">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                    @endif
                                </td>
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
                                        <div class="inv-actions inv-row-actions">
                                            <button class="btn-icon btn-info"
                                                    onclick="copyInviteLink('{{ url('/register?token=' . $inv->token) }}')"
                                                    title="Copiar enlace de registro">
                                                <i class="fas fa-link"></i>
                                            </button>

                                            <form action="{{ route('admin.invitaciones.destroy', $inv) }}"
                                                  method="POST"
                                                  style="display:inline;"
                                                  id="form-delete-invitacion-{{ $inv->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                        class="btn-icon btn-danger"
                                                        onclick="confirmDeleteInvitation('{{ addslashes($inv->email) }}', 'form-delete-invitacion-{{ $inv->id }}')"
                                                        title="Eliminar invitación pendiente">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="text-muted" style="font-size: 12px;" title="Las invitaciones usadas se mantienen para trazabilidad">
                                            <i class="fas fa-shield-alt"></i> Protegida
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Panel de Acciones en Masa --}}
            <div id="bulkActionsPanel" style="display:none;margin-top:20px;padding:16px 18px;background:linear-gradient(135deg,rgba(139,21,56,0.08),rgba(139,21,56,0.04));border:1px solid rgba(139,21,56,0.2);border-radius:var(--radius-sm);animation:slideDown 0.3s ease-out;">
                <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:16px;">
                    <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;">
                        <i class="fas fa-check-circle" style="color:var(--primary);font-size:18px;"></i>
                        <span id="selectionCountText" style="font-weight:600;color:var(--dark);font-size:14px;">
                            0 elementos seleccionados
                        </span>
                    </div>
                    <div style="display:flex;gap:8px;flex-wrap:wrap;">
                        <button onclick="bulkAction('eliminar')" style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;background:rgba(211,47,47,0.1);color:#d32f2f;border:1px solid rgba(211,47,47,0.3);border-radius:var(--radius-sm);cursor:pointer;font-weight:600;font-size:13px;transition:all 0.2s;"
                                onmouseover="this.style.background='rgba(211,47,47,0.15)';this.style.borderColor='rgba(211,47,47,0.5)'"
                                onmouseout="this.style.background='rgba(211,47,47,0.1)';this.style.borderColor='rgba(211,47,47,0.3)'">
                            <i class="fas fa-trash"></i>
                            Eliminar
                        </button>
                        <button onclick="clearSelection()" style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;background:var(--light-gray);color:var(--medium-gray);border:1px solid rgba(0,0,0,0.1);border-radius:var(--radius-sm);cursor:pointer;font-weight:600;font-size:13px;transition:all 0.2s;"
                                onmouseover="this.style.background='#e0e0e0'"
                                onmouseout="this.style.background='var(--light-gray)'">
                            <i class="fas fa-times"></i>
                            Deseleccionar
                        </button>
                    </div>
                </div>
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

        {{-- Paginación --}}
        @if($invitaciones->count() > 0)
            {{ $invitaciones->links('pagination.admin') }}
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

let selectedInvitaciones = new Set();
const bulkActionsPanel = document.getElementById('bulkActionsPanel');
const inviteCheckboxes = document.querySelectorAll('.invite-checkbox');
const inviteRowActions = document.querySelectorAll('.inv-row-actions');
const selectAllCheckbox = document.getElementById('selectAll');

inviteCheckboxes.forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        if (this.checked) {
            selectedInvitaciones.add(this.value);
        } else {
            selectedInvitaciones.delete(this.value);
        }
        updateBulkUI();
    });
});

selectAllCheckbox?.addEventListener('change', function() {
    inviteCheckboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
        if (this.checked) {
            selectedInvitaciones.add(checkbox.value);
        } else {
            selectedInvitaciones.delete(checkbox.value);
        }
    });
    updateBulkUI();
});

function updateBulkUI() {
    const count = selectedInvitaciones.size;
    const countText = document.getElementById('selectionCountText');

    if (count > 0) {
        bulkActionsPanel.style.display = 'block';
        countText.textContent = count === 1 ? '1 elemento seleccionado' : `${count} elementos seleccionados`;

        inviteRowActions.forEach(actions => actions.classList.add('disabled'));
    } else {
        bulkActionsPanel.style.display = 'none';
        inviteRowActions.forEach(actions => actions.classList.remove('disabled'));
    }
}

function bulkAction(action) {
    const count = selectedInvitaciones.size;
    if (count === 0) return;

    Swal.fire({
        title: 'Eliminar invitaciones',
        text: `Se eliminarán permanentemente ${count} invitación(es) pendiente(s). Esta acción no se puede deshacer.`,
        icon: 'error',
        showCancelButton: true,
        confirmButtonColor: '#d32f2f',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            executeBulkAction(action);
        }
    });
}

function executeBulkAction(action) {
    const ids = Array.from(selectedInvitaciones);
    const route = '{{ route("admin.invitaciones.bulk-toggle") }}';

    fetch(route, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}'
        },
        body: JSON.stringify({ ids, action })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                title: '¡Completado!',
                text: data.message,
                icon: 'success',
                confirmButtonColor: '#4CAF50',
                confirmButtonText: 'Continuar'
            }).then(() => {
                location.reload();
            });
        } else {
            Swal.fire({
                title: 'Error',
                text: data.message || 'Ocurrió un error al procesar la acción.',
                icon: 'error',
                confirmButtonColor: '#d32f2f'
            });
        }
    })
    .catch(() => {
        Swal.fire('Error', 'Ocurrió un error al procesar la acción.', 'error');
    });
}

function clearSelection() {
    selectedInvitaciones.clear();
    inviteCheckboxes.forEach(checkbox => checkbox.checked = false);
    if (selectAllCheckbox) selectAllCheckbox.checked = false;
    updateBulkUI();
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

/* Confirmar eliminación de invitación pendiente */
function confirmDeleteInvitation(email, formId) {
    Swal.fire({
        title: '¿Eliminar invitación?',
        html: `Se revocará la invitación de <b>${email}</b>.<br>El token quedará inválido inmediatamente.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d32f2f',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="fas fa-trash-alt"></i> Sí, eliminar',
        cancelButtonText: 'Cancelar',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(formId).submit();
        }
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
