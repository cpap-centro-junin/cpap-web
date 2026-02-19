@extends('layouts.admin')

@section('title', 'Mensajes')
@section('page-title', 'Mensajes de Contacto')

@section('content')

<div class="messages-card">

    <div class="messages-header">
        <h3>Mensajes Recibidos</h3>
        <span class="messages-count">
            {{ $messages->total() }} mensajes
        </span>
    </div>

    <div class="table-responsive">
        <table class="messages-table">
            <thead>
                <tr>
                    <th>Estado</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Asunto</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @forelse($messages as $msg)
                <tr class="{{ !$msg->leido ? 'row-new' : '' }}">

                    <td>
                        @if(!$msg->leido)
                            <span class="badge-new">Nuevo</span>
                        @else
                            <span class="badge-read">Leído</span>
                        @endif
                    </td>

                    <td>{{ $msg->nombre }}</td>
                    <td>{{ $msg->email }}</td>
                    <td class="asunto-col">{{ $msg->asunto }}</td>
                    <td>{{ $msg->created_at->format('d/m/Y') }}</td>

                    <td class="actions">
                        <a href="{{ route('admin.mensajes.show', $msg) }}"
                           class="btn-action view">
                            <i class="fas fa-eye"></i>
                        </a>

                        <form action="{{ route('admin.mensajes.destroy', $msg) }}"
                              method="POST"
                              class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-action delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="6" class="empty-row">
                        No hay mensajes registrados.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-wrapper">
        {{ $messages->links() }}
    </div>

</div>

@endsection


@push('scripts')
<script>
document.querySelectorAll('.delete-form').forEach(form => {
    form.addEventListener('submit', function(e){
        e.preventDefault();

        Swal.fire({
            title: '¿Eliminar mensaje?',
            text: "Esta acción no se puede deshacer.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#7b1e3a',
            cancelButtonColor: '#999',
            confirmButtonText: 'Sí, eliminar'
        }).then((result) => {
            if(result.isConfirmed){
                form.submit();
            }
        });
    });
});
</script>
@endpush
