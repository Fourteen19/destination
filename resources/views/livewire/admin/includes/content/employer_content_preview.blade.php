<div id="content_preview" class="tab-pane @if ($activeTab == "content_preview") active @else fade @endif" wire:key="content_preview-pane">
    <div class="row justify-content-center">
        <div class="col-xl-12">

            <div class="preview-canvas px-5">

                <section class="activity-banner bg-2 t-w mb-5">
                    <div class="row mb-5 justify-content-between align-items-center">
                        <div class="col-xl-5">

                        <h1 class="t30 fw700 t-w">{{ $title }}</h1>

                        <div class="ac-intro t20">
                            {!! $introduction !!}
                        </div>

                        </div>
                        <div class="col-xl-5">
                            <div class="ac-ban-img"><img src="https://via.placeholder.com/1194x800" class="img-fluid"></div>
                            {{--
                            @if (!empty($content->getFirstMediaUrl('banner')))
                                @foreach ( $content->getMedia('banner') as $key => $value)
                                    <div class="ac-ban-img"><img src="{{ $value->getUrl('banner_activity') }}" alt="{{$value->getCustomProperty('alt')}}"  class="img-fluid"></div>
                                @endforeach
                            @endif
                            --}}
                        </div>
                    </div>
                </section>

                {{--
                @if ($bannerImagePreview)
                <div class="row mb-5">
                    <div class="col">
                        <img src="{{$bannerImagePreview}}" class="banner" alt="{{$banner_alt}}">
                    </div>
                </div>
                @endif
                --}}

                <div class="row">
                    <div class="col-lg-12">     

                        <h1 class="t36 fw700">{{ $title }}</h1>
                        @if ($subheading)
                        <h2 class="t24 fw700 mb-4">{{ $subheading }}</h2>
                        @endif
                        @if ($lead)
                        <p class="t24 mb-4">{{ $lead }}</p>
                        @endif
                        @if ($body)
                        <div class="article-body">{!! $body !!}</div>
                        @endif

                        @if ($relatedImages)
                        <div class="sup-img-holder my-5">

                            @foreach($relatedImages as $key => $item)
                            <div class="sup-img mb-4">
                            <img src="{{$item['preview']}}">
                            <div class="sup-img-caption vlg-bg p-3 t16 fw700">{{$item['title']}}</div>
                            </div>
                            @endforeach

                        </div>
                        @endif
                    </div>

                    @if ($think_about)
                        <div class="col-xl-4">
                            <div class="row justify-content-end">
                                <div class="col-xl-11">
                                    <div class="act-things bg-2 t-w" style="background-image: url({{ asset('images/background-balls.png') }})">
                                        <div class="row">
                                            <div class="col-2"><i class="fas fa-lightbulb fa-3x"></i></div>
                                            <div class="col-10">
                                                <h2 class="t24 fw700 t-w">Things to think about</h2>
                                                {{ $think_about }}
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endif

                </div>         

                @if ($relatedVideos)
                <section class="mlg-bg mb-5 rounded-lg">
                <div class="row justify-content-center">
                    <div class="col-xl-7">
                    
                        @foreach($relatedVideos as $key => $item)
                        <div class="my-5 text-center">
                            {{--<h3 class="t30 t-def fw700 mb-3">{{ $item->title }}</h3>--}}
                            <h3 class="t30 t-def fw700 mb-3">[MAKE VIDEO TITLE DYNAMIC]</h3>
                            <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" src="{{$item['url']}}" frameborder="0" allowfullscreen></iframe>
                            </div>
                        </div>
                        @endforeach
                    
                    </div>
                </div>
                </section>
                @endif

                @if ( ($alt_block_heading) || ($alt_block_text) )
                    <div class="alternate-block my-5 mlg-bg p-5">
                        <h2 class="t24 fw700">{!! $alt_block_heading !!}</h2>
                        <div class="alt-cols">
                        {!! $alt_block_text !!}
                        </div>
                    </div>
                @endif

                @if ($lower_body)
                <div class="lower-text my-5">
                {!! $lower_body !!}
                </div>
                @endif


                @if ( ($relatedLinks) || ($relatedDownloads) )
                <div class="row mt-5">
                    <div class="col">
                        <div class="divider def-bg"></div>
                        <h3 class="t30 fw700 mb-4">Additional information and activities</h3>

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

                <section class="activity-banner bg-2 t-w mt-4">
                    <div class="row justify-content-center align-items-center">
                        <div class="col-xl-5">

                        <div class="ac-intro t20 text center">
                           Your activity questions will appear here.
                        </div>

                        </div>
                        
                    </div>
                </section>

            </div>



        </div>
    </div>
</div>
