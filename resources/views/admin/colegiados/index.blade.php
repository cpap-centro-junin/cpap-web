@extends('layouts.admin')

@section('title', 'Colegiados')
@section('page-title', 'Gestión de Colegiados')

@section('content')

<div class="admin-container">

    {{-- Header con botón crear --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Colegiados CPAP</h1>
            <p class="page-subtitle">Gestiona los miembros colegiados del CPAP Región Centro</p>
        </div>
        <a href="{{ route('admin.colegiados.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i>
            Nuevo Colegiado
        </a>
    </div>

    {{-- Filtros y búsqueda --}}
    <div class="filters-card">
        <form action="{{ route('admin.colegiados.index') }}" method="GET" class="filters-form">
            <div class="filter-group">
                <input
                    type="text"
                    name="buscar"
                    class="form-control"
                    placeholder="Buscar por DNI, código o nombre..."
                    value="{{ request('buscar') }}"
                >
            </div>
            <div class="filter-group">
                <select name="estado" class="form-control">
                    <option value="">Todos los estados</option>
                    <option value="activo" {{ request('estado') == 'activo' ? 'selected' : '' }}>Activos</option>
                    <option value="inactivo" {{ request('estado') == 'inactivo' ? 'selected' : '' }}>Inactivos</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i>
                Buscar
            </button>
            @if(request()->anyFilled(['buscar', 'estado']))
                <a href="{{ route('admin.colegiados.index', ['sort' => $sort, 'order' => $order]) }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i>
                    Limpiar
                </a>
            @endif
        </form>
    </div>

    {{-- Tabla de colegiados --}}
    <div class="table-card">
        @if($colegiados->count() > 0)
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>
                                <a href="{{ route('admin.colegiados.index', array_merge(request()->query(), ['sort' => 'codigo_cpap', 'order' => $sort === 'codigo_cpap' && $order === 'asc' ? 'desc' : 'asc'])) }}" class="sortable-header">
                                    Código CPAP
                                    <i class="fas fa-sort{{ $sort === 'codigo_cpap' ? ($order === 'asc' ? '-up' : '-down') : '' }}"></i>
                                </a>
                            </th>
                            <th>
                                <a href="{{ route('admin.colegiados.index', array_merge(request()->query(), ['sort' => 'dni', 'order' => $sort === 'dni' && $order === 'asc' ? 'desc' : 'asc'])) }}" class="sortable-header">
                                    DNI
                                    <i class="fas fa-sort{{ $sort === 'dni' ? ($order === 'asc' ? '-up' : '-down') : '' }}"></i>
                                </a>
                            </th>
                            <th>
                                <a href="{{ route('admin.colegiados.index', array_merge(request()->query(), ['sort' => 'nombres', 'order' => $sort === 'nombres' && $order === 'asc' ? 'desc' : 'asc'])) }}" class="sortable-header">
                                    Nombre Completo
                                    <i class="fas fa-sort{{ $sort === 'nombres' ? ($order === 'asc' ? '-up' : '-down') : '' }}"></i>
                                </a>
                            </th>
                            <th>
                                <a href="{{ route('admin.colegiados.index', array_merge(request()->query(), ['sort' => 'especialidad', 'order' => $sort === 'especialidad' && $order === 'asc' ? 'desc' : 'asc'])) }}" class="sortable-header">
                                    Especialidad
                                    <i class="fas fa-sort{{ $sort === 'especialidad' ? ($order === 'asc' ? '-up' : '-down') : '' }}"></i>
                                </a>
                            </th>
                            <th>
                                <a href="{{ route('admin.colegiados.index', array_merge(request()->query(), ['sort' => 'estado', 'order' => $sort === 'estado' && $order === 'asc' ? 'desc' : 'asc'])) }}" class="sortable-header">
                                    Estado
                                    <i class="fas fa-sort{{ $sort === 'estado' ? ($order === 'asc' ? '-up' : '-down') : '' }}"></i>
                                </a>
                            </th>
                            <th>
                                <a href="{{ route('admin.colegiados.index', array_merge(request()->query(), ['sort' => 'fecha_colegiatura', 'order' => $sort === 'fecha_colegiatura' && $order === 'asc' ? 'desc' : 'asc'])) }}" class="sortable-header">
                                    Fecha Colegiatura
                                    <i class="fas fa-sort{{ $sort === 'fecha_colegiatura' ? ($order === 'asc' ? '-up' : '-down') : '' }}"></i>
                                </a>
                            </th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($colegiados as $colegiado)
                            <tr>
                                <td>
                                    <strong class="text-primary">{{ $colegiado->codigo_cpap }}</strong>
                                </td>
                                <td>{{ $colegiado->dni }}</td>
                                <td>
                                    <div class="user-cell">
                                        @if($colegiado->foto)
                                            <img src="{{ asset($colegiado->foto) }}" alt="{{ $colegiado->nombre_completo }}" class="user-avatar-small">
                                        @else
                                            <div class="user-avatar-small">
                                                {{ strtoupper(substr($colegiado->nombres, 0, 1) . substr($colegiado->apellidos, 0, 1)) }}
                                            </div>
                                        @endif
                                        <span>{{ $colegiado->nombre_completo }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-muted">{{ $colegiado->especialidad ?? 'No especificada' }}</span>
                                </td>
                                <td>
                                    @if($colegiado->estado === 'activo')
                                        <span class="badge badge-success">
                                            <i class="fas fa-check-circle"></i> ACTIVO
                                        </span>
                                    @else
                                        <span class="badge badge-danger">
                                            <i class="fas fa-times-circle"></i> INACTIVO
                                        </span>
                                    @endif
                                </td>
                                <td>{{ $colegiado->fecha_colegiatura->format('d/m/Y') }}</td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.colegiados.show', $colegiado) }}" class="btn-icon btn-info" title="Ver detalle">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.colegiados.edit', $colegiado) }}" class="btn-icon btn-warning" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.colegiados.toggle-estado', $colegiado) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn-icon {{ $colegiado->estado === 'activo' ? 'btn-success' : 'btn-secondary' }}" title="Cambiar estado">
                                                <i class="fas fa-toggle-{{ $colegiado->estado === 'activo' ? 'on' : 'off' }}"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.colegiados.destroy', $colegiado) }}" method="POST" class="d-inline" id="form-delete-{{ $colegiado->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                    class="btn-icon btn-danger"
                                                    title="Eliminar"
                                                    onclick="confirmDeleteColegiado('{{ addslashes($colegiado->nombre_completo) }}', 'form-delete-{{ $colegiado->id }}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Paginación --}}
            {{ $colegiados->render('pagination.custom') }}
        @else
            <div class="empty-state">
                <i class="fas fa-users"></i>
                <h3>No se encontraron colegiados</h3>
                <p>{{ request('buscar') || request('estado') ? 'Intenta con otros filtros de búsqueda.' : 'Comienza agregando el primer colegiado.' }}</p>
                @if(!request()->anyFilled(['buscar', 'estado']))
                    <a href="{{ route('admin.colegiados.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i>
                        Agregar Primer Colegiado
                    </a>
                @endif
            </div>
        @endif
    </div>

</div>

@endsection

@push('scripts')
<script>
function confirmDeleteColegiado(nombre, formId) {
    Swal.fire({
        title: '¿Eliminar colegiado?',
        html: `Esta acción eliminará permanentemente a <strong>${nombre}</strong> junto con todos sus documentos de habilitación. Esta acción <strong>no se puede deshacer</strong>.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d32f2f',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="fas fa-trash"></i> Sí, eliminar',
        cancelButtonText: 'Cancelar',
        focusCancel: true,
        customClass: {
            popup: 'swal-admin-popup',
        }
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(formId).submit();
        }
    });
}
</script>
@endpush
