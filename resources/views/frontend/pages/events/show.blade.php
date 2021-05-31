@extends('frontend.layouts.master')

@section('content')
<article>
<div class="row r-pad">
    <div class="col-lg-8">
        <div class="row mb-5">
            <div class="col">
                <img src="{{parse_encode_url($event->getFirstMediaUrl('banner')) ?? ''}}" onerror="this.style.display='none'">
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">

                <h1 class="t36 fw700">{{$event->title}}</h1>
                <h2 class="t24 fw700 mb-4">{{$event->venue_name}}@if ($event->town), {{$event->town}}@endif</h2>
                <p class="t24 mb-4">{{$event->lead_para}}</p>
                <div class="article-body">
                <h2>About the event</h2>
                {!!$event->description!!}
                </div>
                {{-- <div class="sup-img my-5"> --}}

                    @if (count($event->getMedia('supporting_images')) > 0)
                    <div class="sup-img-holder mt-5">
                        @foreach ( $event->getMedia('supporting_images') as $key => $value)
                            <div class="sup-img mb-4">
                            <img src="{{ parse_encode_url($value->getUrl()) }}" @if ($value->getCustomProperty('alt'))alt={{ json_encode($value->getCustomProperty('alt')) }} @endif>
                            @if ($value->getCustomProperty('title'))
                                <div class="sup-img-caption vlg-bg p-3 t16 fw700">{{ $value->getCustomProperty('title') }}</div>
                            @endif
                            </div>
                        @endforeach
                    </div>
                    @endif



                {{-- <div class="sup-img-caption vlg-bg p-3 t16 fw700">Image caption that goes with the supporting image block</div>
                </div> --}}




                @if (count($event->relatedVideos) > 0)
                    <div class="vid-block my-5">
                        <h3 class="t24 fw700 mb-3">Watch the video</h3>
                        @foreach ($event->relatedVideos as $item)
                            <div class="embed-responsive embed-responsive-16by9 mb-5">
                            <iframe class="embed-responsive-item" src="{{ $item->url }}" frameborder="0" allowfullscreen></iframe>
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- <div class="vid-block my-5">
                    <h3 class="t24 fw700 mb-3">Watch the video</h3>
                    <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/ScMzIvxBSi4" frameborder="0" allowfullscreen></iframe>
                    </div>
                </div> --}}


            </div>
            <div class="col-lg-4">
                <div class="vlg-bg">
                        <table class="table t-def">
                            <tbody>
                                <tr>
                                    <td width="15%"><i class="fas fa-calendar fa-2x"></i></td>
                                    <td class="t20 fw700">{{ Carbon\Carbon::parse($event->event_date)->format('jS F Y')}}</td>
                                </tr>
                                <tr>
                                    <td><i class="fas fa-clock  fa-2x"></i></td>
                                    <td>
                                        <div><span class="t-up">Starts:</span> <span class="t20 fw700">{{$event->start_time_hour}}:{{$event->start_time_min}}</span></div>
                                        <div><span class="t-up">Ends:</span> <span class="t20 fw700">{{$event->end_time_hour}}:{{$event->end_time_min}}</span></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><i class="fas fa-user-circle fa-2x"></i></td>
                                    <td>
                                        <div class="t-up t16">Contact</div>
                                        <div class="fw700">{{$event->contact_name}}</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><i class="fas fa-phone-square fa-2x"></i></td>
                                    <td class="t20 fw700"><a href="tel:{{$event->contact_number}}" target="_blank" class="td-no">{{$event->contact_number}}</a></td>
                                </tr>
                                <tr>
                                    <td><i class="fas fa-at fa-2x"></i></td>
                                    <td class="t20 fw700"><a href="mailto:{{$event->contact_email}}" target="_blank" class="td-no">Email the event organiser</a></td>
                                </tr>
                                <tr>
                                    <td><i class="fas fa-ticket-alt fa-2x"></i></td>
                                    <td class="t20 fw700"><a href="{{$event->online_booking}}" target="_blank" class="td-no">Click here to book</a></td>
                                </tr>
                            </tbody>
                        </table>

                </div>

            </div>
        </div>

        @if ($event->map)
            <div class="row">
                <div class="col-lg-12">
                    <div class="map-block">
                        <h3 class="t24 fw700 mb-3"><i class="fas fa-map-marked mr-3"></i>How to get there</h3>
                        <div class="embed-responsive embed-responsive-21by9 mb-4">
                        {{$event->map}}
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @include('frontend.pages.events.things')

    </div>

</div>
<div class="row r-sep mt-5">
    <div class="col">
        <div class="border-top def-border pt-3 pl-3">
            <a href="{{ route('frontend.events') }}" class="fw700 td-no">Back to previous page</a>
        </div>
    </div>
</div>
</article>
@endsection
