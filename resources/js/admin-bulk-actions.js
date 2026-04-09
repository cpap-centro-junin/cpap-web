/**
 * Sistema de acciones en lote para tablas admin
 * Maneja selección múltiple, eliminar, cambiar estado, etc.
 */
document.addEventListener('DOMContentLoaded', function() {
    initBulkActions();
});

function initBulkActions() {
    const selectAllCheckbox = document.getElementById('select-all-items');
    const itemCheckboxes = document.querySelectorAll('input[name="selected_ids[]"]');
    const bulkActionsBar = document.getElementById('bulk-actions-bar');
    const selectedCountSpan = document.getElementById('selected-count');
    const deselectBtn = document.getElementById('bulk-deselect');
    const table = document.querySelector('[data-table-name]');
    const tableName = table?.dataset.tableName || null;
    
    // Buscar acciones en tablas (tbody) o en cualquier elemento con clase msg-actions (para mensajes)
    const actionsColumns = document.querySelectorAll('tbody td:last-child, .msg-actions');

    if (!selectAllCheckbox || itemCheckboxes.length === 0) return;

    // Evento: "Seleccionar todo"
    selectAllCheckbox.addEventListener('change', function() {
        itemCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateBulkActionsBar();
    });

    // Evento: Cada checkbox individual
    itemCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateSelectAllCheckbox();
            updateBulkActionsBar();
        });
    });

    // Evento: Botón deseleccionar
    if (deselectBtn) {
        deselectBtn.addEventListener('click', function() {
            selectAllCheckbox.checked = false;
            itemCheckboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
            updateBulkActionsBar();
        });
    }

    function updateSelectAllCheckbox() {
        const allChecked = Array.from(itemCheckboxes).every(cb => cb.checked);
        const someChecked = Array.from(itemCheckboxes).some(cb => cb.checked);
        selectAllCheckbox.checked = allChecked;
        selectAllCheckbox.indeterminate = someChecked && !allChecked;
    }

    function updateBulkActionsBar() {
        const checked = Array.from(itemCheckboxes).filter(cb => cb.checked);
        const count = checked.length;

        if (count > 0) {
            bulkActionsBar.style.display = 'flex';
            if (selectedCountSpan) {
                selectedCountSpan.textContent = count === 1 ? '1 elemento seleccionado' : `${count} elementos seleccionados`;
            }
            
            // Bloquear columna ACCIONES
            actionsColumns.forEach(cell => {
                cell.style.pointerEvents = 'none';
                cell.style.opacity = '0.5';
                cell.style.cursor = 'not-allowed';
            });
        } else {
            bulkActionsBar.style.display = 'none';
            
            // Desbloquear columna ACCIONES
            actionsColumns.forEach(cell => {
                cell.style.pointerEvents = 'auto';
                cell.style.opacity = '1';
                cell.style.cursor = 'auto';
            });
        }
    }

    function getSelectedIds() {
        return Array.from(itemCheckboxes)
            .filter(cb => cb.checked)
            .map(cb => cb.value);
    }

    // ============================================================
    // ACCIONES POR TABLA
    // ============================================================

    // ACTIVAR
    const activateBtn = document.getElementById('bulk-activate-btn');
    if (activateBtn) {
        activateBtn.addEventListener('click', () => {
            const ids = getSelectedIds();
            if (ids.length === 0) return;

            Swal.fire({
                title: '¿Activar elementos?',
                html: `Se activarán <strong>${ids.length} elemento${ids.length > 1 ? 's' : ''}</strong>.`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-check-circle"></i> Sí, activar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    bulkAction('activate', ids);
                }
            });
        });
    }

    // DESACTIVAR
    const deactivateBtn = document.getElementById('bulk-deactivate-btn');
    if (deactivateBtn) {
        deactivateBtn.addEventListener('click', () => {
            const ids = getSelectedIds();
            if (ids.length === 0) return;

            Swal.fire({
                title: '¿Desactivar elementos?',
                html: `Se desactivarán <strong>${ids.length} elemento${ids.length > 1 ? 's' : ''}</strong>.`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-times-circle"></i> Sí, desactivar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    bulkAction('deactivate', ids);
                }
            });
        });
    }

    // DESTACAR
    const highlightBtn = document.getElementById('bulk-highlight-btn');
    if (highlightBtn) {
        highlightBtn.addEventListener('click', () => {
            const ids = getSelectedIds();
            if (ids.length === 0) return;

            Swal.fire({
                title: '¿Destacar elementos?',
                html: `Se destacarán <strong>${ids.length} elemento${ids.length > 1 ? 's' : ''}</strong>.`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#ffc107',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-star"></i> Sí, destacar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    bulkAction('highlight', ids);
                }
            });
        });
    }

    // DESDESTACAR
    const unhighlightBtn = document.getElementById('bulk-unhighlight-btn');
    if (unhighlightBtn) {
        unhighlightBtn.addEventListener('click', () => {
            const ids = getSelectedIds();
            if (ids.length === 0) return;

            Swal.fire({
                title: '¿Quitar destaque?',
                html: `Se quitará destaque a <strong>${ids.length} elemento${ids.length > 1 ? 's' : ''}</strong>.`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#6c757d',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-star"></i> Sí, quitar destaque',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    bulkAction('unhighlight', ids);
                }
            });
        });
    }

    // OCULTAR / MOSTRAR
    const hideBtn = document.getElementById('bulk-hide-btn');
    if (hideBtn) {
        hideBtn.addEventListener('click', () => {
            const ids = getSelectedIds();
            if (ids.length === 0) return;

            Swal.fire({
                title: '¿Ocultar elementos?',
                html: `Se ocultarán <strong>${ids.length} elemento${ids.length > 1 ? 's' : ''}</strong>.`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-eye-slash"></i> Sí, ocultar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    bulkAction('hide', ids);
                }
            });
        });
    }

    const showBtn = document.getElementById('bulk-show-btn');
    if (showBtn) {
        showBtn.addEventListener('click', () => {
            const ids = getSelectedIds();
            if (ids.length === 0) return;

            Swal.fire({
                title: '¿Mostrar elementos?',
                html: `Se mostrarán <strong>${ids.length} elemento${ids.length > 1 ? 's' : ''}</strong>.`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-eye"></i> Sí, mostrar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    bulkAction('show', ids);
                }
            });
        });
    }

    // ELIMINAR
    const deleteBtn = document.getElementById('bulk-delete-btn');
    if (deleteBtn) {
        deleteBtn.addEventListener('click', () => {
            const ids = getSelectedIds();
            if (ids.length === 0) return;

            Swal.fire({
                title: '⚠️ ¿Eliminar elementos?',
                html: `Se eliminarán permanentemente <strong>${ids.length} elemento${ids.length > 1 ? 's' : ''}</strong>. <strong>Esta acción no se puede deshacer.</strong>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d32f2f',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-trash"></i> Sí, eliminar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    bulkAction('delete', ids);
                }
            });
        });
    }

    // ============================================================
    // LLAMADA AJAX GENÉRICA
    // ============================================================

    function bulkAction(action, ids) {
        if (!tableName) {
            Swal.fire('Error', 'No se pudo determinar la tabla', 'error');
            return;
        }

        const endpoint = `/admin/bulk-action`;
        const payload = { action, table: tableName, ids };

        fetch(endpoint, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(payload)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: '¡Completado!',
                    text: data.message || 'Operación realizada exitosamente.',
                    timer: 1500,
                    timerProgressBar: true,
                    didClose: () => location.reload()
                });
            } else {
                Swal.fire('Error', data.message || 'Error en la operación', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire('Error', 'Error al procesar la solicitud', 'error');
        });
    }
}

