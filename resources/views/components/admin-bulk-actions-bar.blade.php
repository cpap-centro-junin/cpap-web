@props(['tableName' => null])

<div id="bulk-actions-bar" class="bulk-actions-bar" style="display: none;">
    <div class="bulk-actions-content">
        <span class="bulk-actions-info">
            <i class="fas fa-check-circle"></i> <span id="selected-count"></span>
        </span>
        
        <div class="bulk-actions-buttons" id="bulk-buttons-container">
            {{-- Renderizar botones dinámicos según la tabla --}}
            @if($tableName)
                <x-admin-bulk-buttons :tableName="$tableName" />
            @endif
        </div>
    </div>
</div>

<style>
.bulk-actions-bar {
    position: sticky;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
    border-top: 3px solid #0d6efd;
    border-bottom: 1px solid #dee2e6;
    padding: 1rem;
    box-shadow: 0 -3px 10px rgba(0, 0, 0, 0.1);
    z-index: 100;
    margin-top: 1rem;
}

.bulk-actions-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    max-width: 1400px;
    margin: 0 auto;
    flex-wrap: wrap;
    gap: 1rem;
}

.bulk-actions-info {
    font-weight: 600;
    color: #495057;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.bulk-actions-info i {
    color: #0d6efd;
    font-size: 1.1rem;
}

.bulk-actions-buttons {
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
}

.bulk-actions-buttons .btn {
    white-space: nowrap;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

@media (max-width: 768px) {
    .bulk-actions-content {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .bulk-actions-buttons {
        width: 100%;
    }
    
    .bulk-actions-buttons .btn {
        flex: 1;
        justify-content: center;
    }
}
</style>
