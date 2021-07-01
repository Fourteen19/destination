<div class="ml-auto mt-3 mt-lg-0" wire.key={{$searchFormKey}} x-data="{ articlesSuggestionsVisible: @entangle('articlesSuggestionsVisible') }">
    <form class="form-inline mt-2 mt-md-0 ml-auto pr-3 position-relative" wire:submit.prevent="submit" @click.away="articlesSuggestionsVisible = false">
        <label class="t15 fw700 mr-3 t-w">Find an article:</label>
        <div class="form-row">
            <div class="col-auto">
            <input class="form-control mr-sm-2"
                type="text"
                name="search"
                id="search"
                placeholder="Search..."
                aria-label="Search"
                wire:model.debounce="search"
                wire.key="keyword_search"
                {{-- wire:loading.attr="disabled" --}}
                @focus="articlesSuggestionsVisible = true"
                @keydown.escape.window="articlesSuggestionsVisible = false"
                @keydown.enter.window="articlesSuggestionsVisible = false"
                @keydown="articlesSuggestionsVisible = true"
                @keydown.shift.tab="articlesSuggestionsVisible = false"
                autocomplete="off">
            </div>
            <div class="col-auto">
            <button class="search-btn t-def rounded-circle" wire.click="submit" type="submit"><i class="fas fa-search fa-lg"></i></button>
            </div>
        </div>



        @if (strlen($search) > 0)

            {{-- @if (count($searchResults) > 0) --}}
                <div class="suggestions position-absolute" x-show="articlesSuggestionsVisible">

                    <h4 class="suggestion-title">Suggestions</h4>
                    <div wire:loading wire:target="search" class="searching">Searching</div>
                    <ul class="suggestion-results list-unstyled mb-0">
                        @foreach($searchResults as $keyword)
                            <li wire.key="keyword_{{$loop->index}}"><a href="{{route('frontend.search', ['clientSubdomain' => session('fe_client.subdomain'), 'searchTerm' => parse_encode_url($keyword['name'][app()->getLocale()]) ] )}}" class="td-no keyword-link">{{$keyword['name'][app()->getLocale()]}}</a></li>
                        @endforeach
                    </ul>
                </div>
            {{-- @else

            @endif --}}
        @endif
    </form>
</div>

{{--
@push('scripts')
<script>

    document.addEventListener("DOMContentLoaded", () => {
        Livewire.hook('message.processed', (message, component) => {
            if (message.updateQueue[0].name == 'search') {
                document.getElementById("search").focus();
            }
        })
    });

</script>
@endpush
 --}}

