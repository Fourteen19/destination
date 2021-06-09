<div>
    <div class="row justify-content-center my-5">
        <div class="col-xl-7 col-lg-6 mb-4 mb-xl-0">
            <div class="pt-4">
                <h1 class="fw700 t36 mb-4">Find an event</h1>
                @if ($searchedTerm != '')
                    <p class="fw700 t20 mb-4">You searched for “{{$searchedTerm}}”.</p>
                    <p class="fw700 t20">
                    @if ($nbEventsFound == 0)
                        We have not found any events matching your search
                    @else
                        We have found {{$nbEventsFound}} events matching your search
                    @endif
                    </p>
                @endif
            </div>
        </div>
        <div class="col-xl-5 col-lg-6">
            <div class="search-container def-border pl-lg-4 pt-lg-4 pb-lg-4" x-data="{ eventSuggestionsIsVisible: @entangle('eventSuggestionsIsVisible') }">
                <h2 class="t24 fw700">Search for something else</h2>

                <form class="form-inline align-items-center position-relative" wire:submit.prevent="filterEventsWithString" @click.away="eventSuggestionsIsVisible = false">
                    <div class="form-group col-8 p-0 mr-3 mb-0">
                        <label for="searchevents" class="sr-only">Search for something else</label>
                        <input type="field"
                            class="form-control search-form"
                            x-refs="events_search"
                            id="events_search"
                            placeholder="Enter keywords"
                            wire.key="events_keyword_search"
                            wire:loading.attr="disabled"
                            wire:model.debounce.1000ms="search"
                            @focus="eventSuggestionsIsVisible = true"
                            @keydown.escape.window="eventSuggestionsIsVisible = false"
                            @keydown.enter.window="eventSuggestionsIsVisible = false;"
                            @keydown="eventSuggestionsIsVisible = true"
                            @keydown.shift.tab="eventSuggestionsIsVisible = false"
                            autocomplete="off"
                            >
                    </div>
                     <button type="submit" class="platform-button border-0 t-def">Search</button>


                    @if (strlen($search) >= 3)

                        @if (count($searchKeywordsResults) > 0)
                        <div class="suggestions position-absolute" style="display:none" x-show="eventSuggestionsIsVisible">

                        <h4 class="suggestion-title">Suggestions</h4>
                        <div wire:loading wire:target="search" x-show.transition.opcatity.duration.1000ms="eventSuggestionsIsVisible" class="searching">Searching</div>
                            <ul class="suggestion-results list-unstyled mb-0">
                                @foreach($searchKeywordsResults as $keyword)
                                    <li @click.prevent="eventSuggestionsIsVisible = false" wire:click.prevent="filterEventsWithKeyword('{{$keyword['name']}}')"><a href="#" class="td-no keyword-link">{{$keyword['name']}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                        @else

                        @endif
                    @endif

                </form>
            </div>
        </div>
    </div>

    @if ($events)
        <div class="row">
            @foreach($events as $event)

                {{-- <div class="col-xl-3 col-sm-6 col-lg-4 mb-4">

                    <a href="{{ route('frontend.events.event', ['clientSubdomain' => session('fe_client.subdomain'), 'event' => (!empty($event->slug)) ? $event->slug : '1' ])}}" class="td-no">
                        <div class="search-img">
                        <img src="{{parse_encode_url($event->getFirstMediaUrl('summary', 'search')) ?? ''}}" onerror="this.style.display='none'">
                        </div>
                        <div class="row no-gutters">
                            <div class="col-12">
                                <div class="event-summary mlg-bg mbh-1">
                                <h4 class="fw700 t20">{{ $event->summary_heading }}</h4>
                                <p class="t16 mb-0">
                                    @if ($event->template_id == 4)
                                        @foreach($event->sectorTags()->get() as $tag)
                                            {{$tag->name}}<br/>
                                        @endforeach
                                    @else
                                        {{ Str::limit($event->summary_text, $limit = 140, $end = '...') }}
                                    @endif
                                </p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div> --}}


                <div class="col-xl-3 col-sm-6 col-lg-4 mb-4">
                    <a href="{{ route('frontend.events.event', ['clientSubdomain' => session('fe_client.subdomain'), 'event' => (!empty($event->slug)) ? $event->slug : '1' ])}}" class="td-no">
                        <div class="w-bg">
                            <img src="{{ parse_encode_url($event->getFirstMediaUrl('summary', 'large')) ?? '' }}" onerror="this.style.display='none'">
                            <div class="row no-gutters">
                                <div class="col-8">
                                    <div class="article-summary mlg-bg mbh-1">
                                    <h4 class="fw700 t20">{{$event->summary_heading}}</h4>
                                    <p class="t16 mb-0">{{ Str::limit($event->summary_text, $limit = 100, $end = '...') }}</p>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="event-summary p-3 w-bg t-up text-center fw700">
                                        <div class="row">
                                            <div class="col t48">
                                                {{ date('d', strtotime($event->date)) }}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col t24">
                                                {{ date('M', strtotime($event->date)) }}
                                            </div>
                                        </div>
                                        <div class="row my-2">
                                            <div class="col">
                                                <div class="split border-top def-border w-100"></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col t16">
                                                <span>Starts:<br>
                                                    {{ str_pad($event->start_time_hour,2,'0',STR_PAD_LEFT) }}:{{ str_pad($event->start_time_min,2,'0',STR_PAD_LEFT) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

            @endforeach
        </div>

        <div class="row">
            <div class="col">
            {{ $events->links('livewire.frontend.search-pagination', ['clientSubdomain' => session('fe_client.subdomain')] ) }}
            </div>
        </div>

    @endif

</div>

@push('scripts')
<script>

    document.addEventListener("DOMContentLoaded", () => {
        Livewire.hook('message.processed', (message, component) => {
            if (message.updateQueue[0].name == 'events_search') {
                document.getElementById("searchevents").focus();
            }
        })
    });

</script>
@endpush
