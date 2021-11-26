@extends('frontend.layouts.master')

@section('content')

@livewire('frontend.events-search-box')

<div class="row r-pad r-sep">
    <div class="col-12">
        <h2 class="t30 fw700 mb-0">@if ($type == 'best_match') Best Match for me @else Upcoming @endif</h2>
    </div>
</div>

<div class="row mb-4">

    @forelse($upcominEvents as $item)


        <div class="col-sm-6 col-xl-3 mb-3 mb-xl-0">
            <a href="{{ route('frontend.events.event', ['event' => $item->slug]) }}" class="td-no">
                <div class="w-bg h-100 d-flex flex-column">
                    <img src="{{ parse_encode_url($item->getFirstMediaUrl('summary', 'large')) ?? '' }}" onerror="this.style.display='none'">
                    <div class="row no-gutters flex-grow-1">
                        <div class="col-8 mlg-bg">
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

    @empty

        <p>There are no upcoming events available right now.</p>

    @endforelse

</div>

@if (count($futureEvents) > 0)
    <div class="row r-pad r-sep">
        <div class="col-12">
            <h2 class="t30 fw700 mb-0">Future Events</h2>
        </div>
    </div>

    <div id="future_events" class="row">
        @include('frontend.pages.includes.events.future-events')
    </div>

    <div class="row my-5">
        <div class="col">
            <a id="load_more_button" href="javascript:void(0);" class="platform-button pb-lge" @if (count($futureEvents) < 6) style="display:none" @endif>Load more</a>
            <p id="no_more_events_message" style="display:none">There are no more future events to load</p>
        </div>
    </div>
@endif


<div class="row">
    <div class="col">
        <div class="border-top def-border pt-3 pl-3">
            <a href="@auth('web'){{ route('frontend.dashboard') }}@else{{ route('frontend.home') }}@endauth" class="fw700 td-no">Back to home page</a>
        </div>
    </div>
</div>

@endsection

@push('scripts')
    <script>

    $(document).ready(function(){

        var offset = 4;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });



        function load_data(offset)
        {
            console.log(offset);
            $.ajax({
                url:"{{ route('frontend.loadMoreFutureEvents') }}",
                method:"POST",
                data:{offset:offset},
                success:function(data)
                {

                    $('#future_events').append(data.view);

                    if (data.nb_events == {{config('global.events.future_events.load_more_number')}})
                    {
                        $('#load_more_button').html("Load More");
                    } else {
                        $('#load_more_button').hide();
                        $('#no_more_events_message').show();
                    }

                }
            });

        }


        $(document).on('click', '#load_more_button', function(){
            $(this).html('<b>Loading...</b>');
            offset = offset + {{config('global.events.future_events.load_more_number')}};
            load_data(offset);
        });

    });
    </script>
@endpush
