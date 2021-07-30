<div class="row justify-content-center mt-5 r-sep" wire.key={{$searchFormKey}}>

    {{-- new form tag --}}
    {{--<form class="form-inline mt-2 mt-md-0 ml-auto pr-3 border-right w-border position-relative" wire:submit.prevent="submit"> --}}


        <div class="col-xl-7 col-lg-6">
            <div class="pt-4">
                <h1 class="fw700 t36">Events</h1>
                <p>Below you will find all of the current events listed on MyDirections. Click on any event for full details.</p>

                @if (Auth::guard('web')->check())
                    <div class="form-check form-check-inline">
                        <label class="form-check-label mr-3 t20 fw700">Filter all events:</label>
                        <input class="form-check-input" type="radio" name="event_filter" id="event_filter_best_match" value="best_match" wire:model="event_filter">
                        <label class="form-check-label t20 fw700" for="event_filter_best_match">Best Match for me</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="event_filter" id="event_filter_all_events" value="all_events" wire:model="event_filter">
                        <label class="form-check-label t20 fw700" for="event_filter_all_events">All events</label>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-xl-5 col-lg-6">
            <div class="search-container def-border pl-lg-4 pt-lg-4 pb-lg-4" x-data="{ eventSuggestionsVisible: @entangle('eventSuggestionsVisible') }">
                <h2 class="t24 fw700">Search for an event</h2>
                 <form class="form-inline form-row align-items-center position-relative" wire:submit.prevent="submit">
                    <div class="col-6 form-group mr-3 mb-0" @click.away="eventSuggestionsVisible = false">
                        <label for="searchevents" class="sr-only">Search for an event</label>
                        {{-- <input type="field" class="form-control" id="searchevents" placeholder="Enter keywords"> --}}
                        <input class="form-control w-100 mr-sm-2"
                        type="text"
                        name="event_search"
                        id="event_search"
                        placeholder="Search..."
                        aria-label="Search"
                        wire:model.debounce="event_search"
                        wire.key="event_keyword_search"
                        {{-- wire:loading.attr="disabled" --}}
                        @focus="eventSuggestionsVisible = true"
                        @keydown.escape.window="eventSuggestionsVisible = false"
                        @keydown.enter.window="eventSuggestionsVisible = false;"
                        @keydown="eventSuggestionsVisible = true"
                        @keydown.shift.tab="eventSuggestionsVisible = false"
                        autocomplete="off"
                        >
                    </div>
                    <button type="submit" class="platform-button border-0 t-def" wire:click="submit" type="submit">Search</button>

                    @if (strlen($event_search) >= 3)

                        @if (count($searchResults) > 0)
                            <div class="suggestions position-absolute" style="display:none" x-show="eventSuggestionsVisible">

                                <h4 class="suggestion-title">Suggestions</h4>
                                <div wire:loading wire:target="search" x-show.transition.opcatity.duration.1000ms="eventSuggestionsVisible" class="searching">Searching</div>
                                    <ul class="suggestion-results list-unstyled mb-0">
                                        @foreach($searchResults as $keyword)
                                            <li wire.key="keyword_{{$loop->index}}"><a href="{{route('frontend.events-search', ['clientSubdomain' => session('fe_client.subdomain'), 'searchTerm' => $keyword['name'][app()->getLocale()] ] )}}" class="td-no keyword-link">{{$keyword['name'][app()->getLocale()]}}</a></li>
                                        @endforeach
                                    </ul>

                            </div>
                        @else

                        @endif
                    @endif



                 </form>
            </div>
        </div>

  {{--  </form>--}}

</div>



{{--
<div class="ml-auto" wire.key={{$searchFormKey}}>
    <form class="form-inline mt-2 mt-md-0 ml-auto pr-3 border-right w-border position-relative" wire:submit.prevent="submit">
        <label class="t15 fw700 mr-3 t-w">Find an article:</label>
        <input class="form-control mr-sm-2" type="text" name="search" id="search" placeholder="Search..." aria-label="Search" wire:model.debounce.1000ms="search" wire.key="keyword_search" wire:loading.attr="disabled">
        <button class="search-btn t-def rounded-circle my-2 my-sm-0" wire.click="seachKeyword" type="submit"><i class="fas fa-search  fa-lg"></i></button>

    @if (strlen($search) >= 3)

        @if (count($searchResults) > 0)
        <div class="suggestions position-absolute">

            <h4 class="suggestion-title">Suggestions</h4>
            <div wire:loading wire:target="search" class="searching">Searching</div>
                <ul class="suggestion-results list-unstyled mb-0">
                    @foreach($searchResults as $keyword)
                        <li wire.key="keyword_{{$loop->index}}"><a href="{{route('frontend.search', ['clientSubdomain' => session('fe_client.subdomain'), 'searchTerm' => parse_encode_url($keyword['name'][app()->getLocale()]) ] )}}" class="td-no keyword-link">{{$keyword['name'][app()->getLocale()]}}</a></li>
                    @endforeach
                </ul>

        </div>
        @else

        @endif
    @endif
    </form>
</div> --}}

@push('scripts')
<script>

    document.addEventListener("DOMContentLoaded", () => {
        Livewire.hook('message.processed', (message, component) => {
            if (message.updateQueue[0].name == 'event_search') {
                document.getElementById("event_search").focus();
            }
        })
    });


    $('input[name="event_filter"]').on('click', function() {
        if ($(this).val() == "best_match")
        {
            window.location.href = "{{ route('frontend.events-best-match', ['clientSubdomain' => session('fe_client.subdomain')] ) }}";
        } else {
            window.location.href = "{{ route('frontend.events', ['clientSubdomain' => session('fe_client.subdomain')] ) }}";
        }
    });

</script>
@endpush


