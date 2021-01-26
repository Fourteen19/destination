<div>
    <form class="form-inline mt-2 mt-md-0 ml-auto pr-3 border-right w-border" wire:submit.prevent="submit">
        <label class="t15 fw700 mr-3 t-w">Find an article:</label>
        <input class="form-control mr-sm-2" type="text" placeholder="Search..." aria-label="Search" wire:model.debounce.300ms="search">
        <button class="search-btn t-def rounded-circle my-2 my-sm-0" wire.click="submit" type="submit"><i class="fas fa-search  fa-lg"></i></button>
    </form>

    @if (strlen($search) >= 3)
        <div wire:loading wire:target="search">searching</div>

        <div>
            @if (count($searchResults) > 0)
                <ul>
                    @foreach($searchResults as $keyword)
                        <li><a href="{{route('frontend.search', ['clientSubdomain' => session('client.subdomain'), 'searchTerm' => $keyword['name'][app()->getLocale()] ] )}}">{{$keyword['name'][app()->getLocale()]}}</a></li>
                    @endforeach
                </ul>
            @else
                No results found for {{$search}}
            @endif
        </div>
    @endif

</div>
