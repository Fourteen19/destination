@if ($other_events->count() > 0)
<div class="heading-border r-base">
    <h2 class="t24 fw700 mb-0">Other Events</h2>
</div>

<div class="row mb-4">

    @foreach($other_events as $item)
        <div class="col-12 r-base">
            <a href="{{ route('frontend.events.event', ['event' => $item->slug]) }}" class="td-no">
                <div class="w-bg">
                    <img src="{{ parse_encode_url($item->getFirstMediaUrl('summary', 'large')) ?? '' }}" onerror="this.style.display='none'">
                    <div class="row no-gutters">
                        <div class="col-8">
                            <div class="article-summary mlg-bg mbh-1">
                            <h4 class="fw700 t20">{{$item->summary_heading}}</h4>
                            <p class="t16 mb-0">{{ Str::limit($item->summary_text, $limit = 100, $end = '...') }}</p>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="event-summary p-3 w-bg t-up text-center fw700">
                                <div class="row">
                                    <div class="col t48">
                                        {{ date('d', strtotime($item->date)) }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col t24">
                                        {{ date('M', strtotime($item->date)) }}
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
                                            {{ str_pad($item->start_time_hour,2,'0',STR_PAD_LEFT) }}:{{ str_pad($item->start_time_min,2,'0',STR_PAD_LEFT) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    @endforeach
    <div class="col mb-5 mt-4">
    <a href="{{ route('frontend.events') }}" class="platform-button pb-lge">View all events</a>
    </div>

</div>
@endif