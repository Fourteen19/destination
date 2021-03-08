<div class="ml-auto">
    <form class="form-inline mt-2 mt-md-0 ml-auto pr-3 border-right w-border position-relative" wire:submit.prevent="submit">
        <label class="t15 fw700 mr-3 t-w">Find an article:</label>
        <input class="form-control mr-sm-2" type="text" placeholder="Search..." aria-label="Search" wire:model.debounce.500ms="search">
        <button class="search-btn t-def rounded-circle my-2 my-sm-0" wire.click="submit" type="submit"><i class="fas fa-search  fa-lg"></i></button>


    @if (strlen($search) >= 3)

        @if (count($searchResults) > 0)
        <div class="suggestions position-absolute">

            <h4 class="suggestion-title">Suggestions</h4>
            <div wire:loading wire:target="search" class="searching">Searching</div>
                <ul class="suggestion-results list-unstyled mb-0">
                    @foreach($searchResults as $keyword)
                        <li><a href="{{route('frontend.search', ['clientSubdomain' => session('fe_client.subdomain'), 'searchTerm' => $keyword['name'][app()->getLocale()] ] )}}" class="td-no keyword-link">{{$keyword['name'][app()->getLocale()]}}</a></li>
                        {{-- <li class="td-no keyword-link" wire:click="seachKeyword('{{$keyword['name'][app()->getLocale()]}}')">{{$keyword['name'][app()->getLocale()]}}</li> --}}
                    @endforeach
                </ul>

        </div>
        @else

        @endif
    @endif
    </form>
</div>
