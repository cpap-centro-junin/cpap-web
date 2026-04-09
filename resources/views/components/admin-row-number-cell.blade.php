@props(['items', 'loopIteration' => null, 'itemId' => null])

<td class="admin-row-number-cell">
    @if ($loopIteration === 'header')
        <div class="checkbox-header">
            <input type="checkbox" id="select-all-items" class="form-check-input" title="Seleccionar/deseleccionar todo">
            <span class="row-number-header">#</span>
        </div>
    @else
        <div class="checkbox-row">
            <input type="checkbox" name="selected_ids[]" class="form-check-input" value="{{ $itemId }}">
            <span class="row-number">{{ ($items->currentPage() - 1) * $items->perPage() + $loopIteration }}</span>
        </div>
    @endif
</td>

<style>
.admin-row-number-cell {
    width: 80px;
    min-width: 80px;
    padding: 0.5rem 0.75rem !important;
    text-align: center;
    vertical-align: middle;
}

.checkbox-header,
.checkbox-row {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.checkbox-header {
    font-weight: 700;
    color: #495057;
}

.row-number-header {
    font-size: 0.85rem;
    color: #ffffff;
    font-weight: 500;
    min-width: 25px;
}

.row-number {
    font-size: 0.85rem;
    color: #6c757d;
    font-weight: 500;
    min-width: 25px;
}

@media (max-width: 768px) {
    .admin-row-number-cell {
        width: 70px;
        min-width: 70px;
        padding: 0.4rem 0.5rem !important;
    }

    .row-number-header,
    .row-number {
        font-size: 0.75rem;
    }
}
</style>
