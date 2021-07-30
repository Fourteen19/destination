@if ($paginator->hasPages())
<div class="row align-items-center">
    <div class="col-12">
        <div class="w-100 border-top def-border my-4"></div>
    </div>


    


    <div class="col-lg-3">
        <p class="t24 fw700 mb-lg-0">Search results {{ $paginator->firstItem() }} - {{ $paginator->lastItem() }} of
            {{ $paginator->total() }}</p>
    </div>
    <div class="col-lg-9">
        <div class="d-inline-block t24 fw700 mr-2">Page:</div>
        @if ($paginator->onFirstPage())
        <div class="d-inline-block paginate" aria-disabled="true" aria-label="@lang('pagination.previous')">
            <span class="page-link" aria-hidden="true">&lsaquo;</span>
        </div>
        @else
        <div class="d-inline-block paginate">
            <button type="button" dusk="previousPage" class="page-link" wire:click="previousPage"
                wire:loading.attr="disabled" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</button>
        </div>
        @endif


        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
        {{-- "Three Dots" Separator --}}
        @if (is_string($element))
        <div class="d-inline-block t24 fw700 mr-2" aria-disabled="true"><span class="page-link">{{ $element }}</span>
        </div>
        @endif

        {{-- Array Of Links --}}
        @if (is_array($element))
        @foreach ($element as $page => $url)
        @if ($page == $paginator->currentPage())
        <div class="d-inline-block paginate" wire:key="paginator-page-{{ $page }}" aria-current="page"><span
                class="page-link">{{ $page }}</span></div>
        @else
        <div class="d-inline-block paginate" wire:key="paginator-page-{{ $page }}"><button type="button"
                class="page-link" wire:click="gotoPage({{ $page }})">{{ $page }}</button></div>
        @endif
        @endforeach
        @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
        <div class="d-inline-block paginate">
            <button type="button" dusk="nextPage" class="page-link" wire:click="nextPage" wire:loading.attr="disabled"
                rel="next" aria-label="@lang('pagination.next')">&rsaquo;</button>
        </div>
        @else
        <div class="d-inline-block paginate disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
            <span class="page-link" aria-hidden="true">&rsaquo;</span>
        </div>
        @endif


    </div>
    

</div>
@endif