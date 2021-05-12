<div id="content_preview" class="tab-pane @if ($activeTab == "content_preview") active @else fade @endif" wire:key="content_preview-pane">
    <div class="row justify-content-center">
        <div class="col-xl-12">

            <div class="preview-canvas px-5">

                <section class="activity-banner bg-2 t-w mb-5">
                    <div class="row mb-5 justify-content-between align-items-center">
                        <div class="col-xl-5">
                            <div class="heading-pre">Employer Profile</div>
                            <h1 class="t30 fw700 t-w mb-4">{{ $title }}</h1>
                            <div class="heading-pre">SECTORS:</div>
                            <div class="ep-sectors mb-4 fw300 t16">
                            @foreach($contentSectorsTags as $tag)
                                {{$tag}},
                            @endforeach
                            </div>

                            <div class="ac-intro t20">{!! $introduction !!}</div>
                        </div>

                        <div class="col-xl-5">
                            @if ($bannerImagePreview)
                            <div class="ep-ban-img"><img src="{{$bannerImagePreview}}" class="img-fluid" alt="{{$banner_alt}}"></div>
                            @endif
                        </div>
                    </div>
                </section>

                <div class="row">
                    <div class="col-lg-8">
                        <div class="row">
                            <div class="col-lg-12">

                                @if ($subheading)<h2 class="t24 fw700 mb-4">{{ $subheading }}</h2>@endif
                                @if ($lead)<p class="t24 mb-4">{{ $lead }}</p>@endif
                                @if ($body)<div class="article-body">{!! $body !!}</div>@endif

                            </div>
                        </div>

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


                        @if ($relatedVideos)
                        <div class="vid-block my-5">
                            <h3 class="t24 fw700 mb-3">Watch the video</h3>

                            @foreach ($relatedVideos as $item)
                                <h3 class="t30 t-def fw700 mb-3">{{$item['title']}}</h3>
                                <div class="embed-responsive embed-responsive-16by9 mb-5">
                                <iframe class="embed-responsive-item" src="{{ $item['url'] }}" frameborder="0" allowfullscreen></iframe>
                                </div>
                            @endforeach

                        </div>
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

                    </div>
                    <div class="col-lg-4 text-right">

                        (Related content)




                    </div>
                </div>

                @if ( ($relatedLinks) || ($relatedDownloads) )
                    <div class="row mt-5">
                        <div class="col">
                            <div class="divider def-bg"></div>
                            <h3 class="t30 fw700 mb-4">Further information</h3>

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
