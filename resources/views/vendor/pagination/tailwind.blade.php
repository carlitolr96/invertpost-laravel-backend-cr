@if ($paginator->hasPages())
    <div class="paginacion-container">
        <div class="info">
            Mostrando 
            @if ($paginator->firstItem())
                <strong>{{ $paginator->firstItem() }}</strong> a <strong>{{ $paginator->lastItem() }}</strong>
            @else
                {{ $paginator->count() }}
            @endif
            de <strong>{{ $paginator->total() }}</strong> resultados
        </div>

        <ul class="pagination">
            {{-- Botón Anterior --}}
            @if ($paginator->onFirstPage())
                <li class="disabled"><span>← Anterior</span></li>
            @else
                <li><a href="{{ $paginator->previousPageUrl() }}">← Anterior</a></li>
            @endif

            {{-- Páginas --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="disabled"><span>{{ $element }}</span></li>
                @endif

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

            {{-- Botón Siguiente --}}
            @if ($paginator->hasMorePages())
                <li><a href="{{ $paginator->nextPageUrl() }}">Siguiente →</a></li>
            @else
                <li class="disabled"><span>Siguiente →</span></li>
            @endif
        </ul>
    </div>
@endif
