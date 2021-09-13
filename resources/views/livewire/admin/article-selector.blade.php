<div class="position-relative mb-4" x-data="{ showDropdown: @entangle('showDropdown') }" @click.away="showDropdown = false">

    {!! Form::label('link', $label); !!}

    <div class="position-relative" wire:key="{{ $name }}">
        @error('query') <div class="text-danger error">{{ $message }}</div>@enderror
        <input
            type="text"
            name="{{ $name }}"
            id="{{ $name }}"
            class="position-relative article-search pl-3 py-2 text-left cursor-default"
            placeholder="Search Article..."
            wire:model.debounce.500ms="query"
            wire:click="reset"
            wire:keydown.escape="hideDropdown"
            wire:keydown.tab="hideDropdown"
            wire:keydown.Arrow-Up="decrementHighlight"
            wire:keydown.Arrow-Down="incrementHighlight"
            wire:keydown.enter.prevent="selectArticle"
            autocomplete="off"
        />


        @if ($selectedArticle)
            <a class="position-absolute cursor-pointer remove-selection" wire:click="reset">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </a>
        @endif
    </div>

    @if(!empty($query) && $selectedArticle == '0' && $showDropdown)
        <div class="position-absolute mt-1 article-results" x-show="showDropdown">
            @if (!empty($articles))
                @foreach($articles as $i => $article)
                    <a
                        wire:click="selectArticle('{{ $i }}')"
                        class="d-block py-1 px-2 cursor-pointer highlight-on {{ $highlightIndex === $i ? 'article-highlight' : '' }}"
                    >{{ $article['title'] }}</a>
                @endforeach
            @else
                <span class="d-block py-1 px-2">No results!</span>
            @endif
        </div>
    @endif
</div>
