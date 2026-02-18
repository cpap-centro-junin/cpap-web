{{-- Paginación personalizada --}}
<div class="pagination-wrapper">
    @if ($paginator->hasPages())
        {{-- Información de paginación --}}
        <div class="pagination-info">
            Mostrando {{ $paginator->firstItem() }}–{{ $paginator->lastItem() }} de {{ $paginator->total() }} registros
            <span class="pagination-separator">·</span>
            Página {{ $paginator->currentPage() }} de {{ $paginator->lastPage() }}
        </div>

        {{-- Links de paginación --}}
        <ul class="pagination">
            {{-- Botón anterior --}}
            @if ($paginator->onFirstPage())
                <li class="disabled"><span>&laquo;</span></li>
            @else
                <li><a href="{{ $paginator->previousPageUrl() }}">&laquo;</a></li>
            @endif

            {{-- Links numerados --}}
            @foreach ($elements as $element)
                {{-- Separador "..." --}}
                @if (is_string($element))
                    <li class="disabled"><span>{{ $element }}</span></li>
                @endif

                {{-- Array de links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="active"><span>{{ $page }}</span></li>
                        @else
                            <li><a href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Botón siguiente --}}
            @if ($paginator->hasMorePages())
                <li><a href="{{ $paginator->nextPageUrl() }}">&raquo;</a></li>
            @else
                <li class="disabled"><span>&raquo;</span></li>
            @endif
        </ul>
    @endif
</div>
