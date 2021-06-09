<div id="event-preview" class="tab-pane px-0 @if ($activeTab == "event-preview") active @else fade @endif" wire:key="event-preview-pane">
    <div class="row justify-content-center">
        <div class="col-xl-12">

            <div class="preview-canvas">


                <div class="row mb-5">
                    <div class="col">
                        <img src="{{$bannerImagePreview}}" class="banner" alt="{{$banner_alt}}" onerror="this.style.display='none'">
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-8">

                        <h1 class="t36 fw700">{{$title}}</h1>
                        <h2 class="t24 fw700 mb-4">{{$venue_name}}@if ($town), {{$town}}@endif</h2>
                        <p class="t24 mb-4">{{$lead_para}}</p>
                        <div class="article-body">
                        <h2>About the event</h2>
                        {!!$description!!}
                        </div>
                        {{-- <div class="sup-img my-5"> --}}

                            @if ($relatedImages)
                            <div class="sup-img-holder my-5">

                                @foreach($relatedImages as $key => $item)
                                <div class="sup-img mb-4">
                                <img src="{{$item['preview']}}">
                                @if (!empty($item['title']))
                                    <div class="sup-img-caption vlg-bg p-3 t16 fw700">{{$item['title']}}</div>
                                @endif
                                </div>
                                @endforeach

                            </div>
                        @endif
                        @if ($relatedVideos)
                            <div class="vid-block my-5">
                                <h3 class="t24 fw700 mb-3">Watch the video</h3>
                                @foreach($relatedVideos as $key => $item)
                                    <div class="embed-responsive embed-responsive-16by9">
                                    <iframe class="embed-responsive-item" src="{{$item['url']}}" frameborder="0" allowfullscreen></iframe>
                                    </div>

                                @endforeach
                            </div>
                        @endif

                    </div>
                    <div class="col-lg-4">
                        <div class="vlg-bg">
                                <table class="table t-def">
                                    <tbody>
                                        <tr>
                                            <td width="15%"><i class="fas fa-calendar fa-2x"></i></td>
                                            <td class="t20 fw700">{{ date('jS F Y', strtotime($event_date)) }}</td>
                                        </tr>
                                        <tr>
                                            <td><i class="fas fa-clock  fa-2x"></i></td>
                                            <td>
                                                <div><span class="t-up">Starts:</span> <span class="t20 fw700">{{str_pad($start_time_hour, 2, "0", STR_PAD_LEFT)}}:{{str_pad($start_time_min, 2, "0", STR_PAD_LEFT)}}</span></div>
                                                <div><span class="t-up">Ends:</span> <span class="t20 fw700">{{str_pad($end_time_hour, 2, "0", STR_PAD_LEFT)}}:{{str_pad($end_time_min, 2, "0", STR_PAD_LEFT)}}</span></div>
                                            </td>
                                        </tr>

                                        @if ($contact_name)
                                            <tr>
                                                <td><i class="fas fa-user-circle fa-2x"></i></td>
                                                <td>
                                                    <div class="t-up t16">Contact</div>
                                                    <div class="fw700">{{$contact_name}}</div>
                                                </td>
                                            </tr>
                                        @endif

                                        @if ($contact_number)
                                            <tr>
                                                <td><i class="fas fa-phone-square fa-2x"></i></td>
                                                <td class="t20 fw700"><a href="tel:{{$contact_number}}" target="_blank" class="td-no">{{$contact_number}}</a></td>
                                            </tr>
                                        @endif

                                        @if ($contact_email)
                                            <tr>
                                                <td><i class="fas fa-at fa-2x"></i></td>
                                                <td class="t20 fw700"><a href="mailto:{{$contact_email}}" target="_blank" class="td-no">Email the event organiser</a></td>
                                            </tr>
                                        @endif

                                        @if ($booking_link)
                                            <tr>
                                                <td><i class="fas fa-ticket-alt fa-2x"></i></td>
                                                <td class="t20 fw700"><a href="{{$booking_link}}" target="_blank" class="td-no">Click here to book</a></td>
                                            </tr>
                                        @endif

                                    </tbody>
                                </table>

                        </div>

                    </div>
                </div>

                @if ($map)
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="map-block">
                                <h3 class="t24 fw700 mb-3"><i class="fas fa-map-marked mr-3"></i>How to get there.</h3>
                                <div class="embed-responsive embed-responsive-21by9 mb-4">
                                {!!$map!!}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif



                @if ( ($relatedLinks) || ($relatedDownloads) )
                    <div class="row mt-5">
                        <div class="col">
                            <div class="divider def-bg"></div>
                            <h3 class="t30 fw700 mb-4">Things you'll need</h3>

                            <ul class="list-unstyled">

                                    @foreach($relatedLinks as $key => $item)
                                        <li class="mb-2"><a href="//{{$item['url']}}" class="td-no fw700" target="_blank"><div class="tyn-icon gg-bg t-w"><i class="fas fa-link"></i></div>{{$item['title']}}</a></li>
                                    @endforeach

                                    @foreach($relatedDownloads as $key => $item)
                                    <li class="mb-2"><a href="//{{$item['open_link']}}" class="td-no fw700" target="_blank"><div class="tyn-icon gg-bg t-w"><i class="fas fa-cloud-download-alt"></i></div>{{$item['title']}}</a></li>
                                    @endforeach

                            </ul>
                        </div>
                    </div>
                @endif

            </div>

        </div>
    </div>
</div>
