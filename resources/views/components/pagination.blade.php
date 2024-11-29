@if ($paginator->hasPages())


<div class="col-sm-12 col-md-7">
<div class="dataTables_paginate paging_simple_numbers">
    <ul class="pagination pagination-rounded">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage() )
            <li class="paginate_button page-item previous disabled">
                <a href="#" class="page-link">
                    <i class="mdi mdi-chevron-left"></i>
                </a>
            </li>
        @else
            <li class="paginate_button page-item previous">
                <a href="{{ $paginator->previousPageUrl() }}" class="page-link">
                    <i class="mdi mdi-chevron-left"></i>
                </a>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="">{{ $element }}</li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="paginate_button page-item active">
                            <a class="page-link">{{ $page }}</a>
                        </li>
                    @else
                        <li class="paginate_button page-item ">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li>
                <a href="{{ $paginator->nextPageUrl() }}" class="page-link">
                    <i class="mdi mdi-chevron-right"></i>
                </a>
            </li>
        @else
            <li class="paginate_button page-item next disabled">
                <a  class="page-link">
                    <i class="mdi mdi-chevron-right"></i>
                </a>
            </li>
        @endif
    </ul>
</div>
</div>
@endif