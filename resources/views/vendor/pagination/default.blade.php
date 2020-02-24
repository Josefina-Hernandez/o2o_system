@if ($paginator->hasPages())
    <nav class="pagenav">
        <p>{{ $paginator->total() }}件（{{ $paginator->perPage() * ($paginator->currentPage() - 1) + 1 }}～{{ $paginator->total() <= $paginator->perPage() * $paginator->currentPage() ? $paginator->total() : $paginator->perPage() * $paginator->currentPage() }}件を表示）</p>
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="disabled"><span>≪</span></li>
            @else
                <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev">≪</a></li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="disabled"><span>{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
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

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li><a href="{{ $paginator->nextPageUrl() }}" rel="next">≫</a></li>
            @else
                <li class="disabled"><span>≫</span></li>
            @endif
        </ul>
    </nav>
@endif
