<div class="relative" x-data="{ showDropdown: @entangle('showDropdown') }" @click.away="showDropdown = false">


    {{-- <div class="form-group">
                {!! Form::label('suplink1', 'Free article - slot 1'); !!}
                {!! Form::select('suplink1', $this->contentList, (!empty($freeArticlesSlot1Page)) ? $freeArticlesSlot1Page : '', array('class' => 'form-control', 'wire:model.lazy' => 'freeArticlesSlot1Page')) !!}
                @error('freeArticlesSlot1Page') <div class="text-danger error">{{ $message }}</div>@enderror
            </div> --}}

    {!! Form::label('suplink1', $label); !!}

    <div class="relative" >
        @error('freeArticlesSlot1Page') <div class="text-danger error">{{ $message }}</div>@enderror
        <input
            type="text"
            name="{{ $name }}"
            id="{{ $name }}"
            class="relative w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            placeholder="Search Article..."
            wire:model="query"
            wire:click="reset"
            wire:keydown.escape="hideDropdown"
            wire:keydown.tab="hideDropdown"
            wire:keydown.Arrow-Up="decrementHighlight"
            wire:keydown.Arrow-Down="incrementHighlight"
            wire:keydown.enter.prevent="selectArticle"
        />

   {{--      <input type="hidden" name="{{ $name }}" id="{{ $name }}" wire:model="selectArticleID">
 --}}
        @if ($selectedArticle)
            <a class="absolute cursor-pointer top-2 right-2 text-gray-500" wire:click="reset">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </a>
        @endif
    </div>

    @if(!empty($query) && $selectedArticle == 0 && $showDropdown)
        <div class="absolute z-10 bg-white mt-1 w-full border border-gray-300 rounded-md shadow-lg"   x-show="showDropdown">
            @if (!empty($articles))
                @foreach($articles as $i => $article)
                    <a
                        wire:click="selectArticle('{{ $i }}')"
                        class="d-block py-1 px-2 text-sm cursor-pointer hover:bg-blue-50 {{ $highlightIndex === $i ? 'bg-blue-50' : '' }}"
                    >{{ $article['title'] }}</a>
                @endforeach
            @else
                <span class="block py-1 px-2 text-sm">No results!</span>
            @endif
        </div>
    @endif
</div>
