@if ($paginator->hasPages())
    <ul class="pagination uk-pagination uk-flex-center" data-uk-margin="" role="navigation" >
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                <span class="page-link" aria-hidden="true" style="@if(app()->getLocale() == 'ar') text-align:center;line-height: 32px; @endif">&lsaquo;</span>
            </li>
        @else
            <li class="page-item">
                <a class="page-link" style="@if(app()->getLocale() == 'ar') text-align:center;line-height: 32px; @endif" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active" aria-current="page"><span class="page-link" style="@if(app()->getLocale() == 'ar') text-align:center;line-height: 35px; @endif">{{ $page }}</span></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $url }}" style="@if(app()->getLocale() == 'ar') text-align:center;line-height: 35px; @endif">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-item">
                <a class="page-link" style="@if(app()->getLocale() == 'ar') text-align:center;line-height: 32px; @endif" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>
            </li>
        @else
            <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                <span class="page-link" aria-hidden="true" style="@if(app()->getLocale() == 'ar') text-align:center;line-height: 32px; @endif">&rsaquo;</span>
            </li>
        @endif
    </ul>
@endif
