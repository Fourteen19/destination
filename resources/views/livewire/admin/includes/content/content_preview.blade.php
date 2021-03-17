<div id="content_preview" class="tab-pane @if ($activeTab == "content_preview") active @else fade @endif" wire:key="content_preview-pane">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            <div class="preview-canvas">
                @if ($bannerImagePreview)
                <div class="row mb-5">
                    <div class="col">
                        <img src="{{$bannerImagePreview}}" class="banner" alt="{{$banner_alt}}">
                    </div>
                </div>
                @endif
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
                        <div class="sup-img my-5">
                            @foreach($relatedImages as $key => $item)
                            <img src="{{$item['preview']}}">
                            <div class="sup-img-caption vlg-bg p-3 t16 fw700">{{$item['title']}}</div>
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

                        @if ( ($alt_block_heading) || ($alt_block_text) )
                        <div class="alternate-block my-5 mlg-bg p-5">
                            <h2 class="t24 fw700">{!! $alt_block_heading !!}</h2>
                            <div class="alt-cols">
                            {!! $alt_block_text !!}
                            </div>
                        </div>
                        @endif


                        @if ($lower_body)
                        <div class="lower-text">
                        {!! $lower_body !!}
                        </div>
                        @endif
                    </div>

                </div>

                @if ( ($relatedLinks) || ($relatedDownloads) )
                <div class="row mt-5">
                    <div class="col">
                        <div class="divider def-bg"></div>
                        <h3 class="t30 fw700 mb-4">Things you'll need</h3>

                        <ul class="list-unstyled">

                                @foreach($relatedLinks as $key => $item)
                                    <li class="mb-2"><a href="{{$item['url']}}" class="td-no fw700" target="_blank"><div class="tyn-icon gg-bg t-w"><i class="fas fa-link"></i></div>{{$item['title']}}</a></li>
                                @endforeach

                                @foreach($relatedDownloads as $key => $item)
                                <li class="mb-2"><a href="{{$item['open_link']}}" class="td-no fw700" target="_blank"><div class="tyn-icon gg-bg t-w"><i class="fas fa-cloud-download-alt"></i></div>{{$item['title']}}</a></li>
                                @endforeach

                        </ul>
                    </div>
                </div>
                @endif



            </div>

{{--
            <div>
                @if ($bannerImagePreview)
                    <div>banner: <img src="{{$bannerImagePreview}}"></div>
                @endif

                @if ($title)
                <div>title: {{ $title }}</div>@endif
                <div>subheading: {{ $subheading }}</div>
                <div>lead paragraph: {{ $lead }}</div>
                <div>Body: {!! $body !!}</div>
                <div>Alternate text block heading: {!! $alt_block_heading !!}</div>
                <div>Alternate text block content: {!! $alt_block_text !!}</div>
                <div>Lower body: {!! $lower_body !!}</div>

                <div>Related videos</div>
                @foreach($relatedVideos as $key => $item)
                    <div>{{$item['url']}}</div>
                @endforeach

                <div>Related Links</div>
                @if ($relatedLinks)
                    @foreach($relatedLinks as $key => $item)
                        <div><a href="{{$item['url']}}" target="_blank">{{$item['title']}}</a></div>
                    @endforeach
                @endif

                <div>Related Downloads</div>
                @foreach($relatedDownloads as $key => $item)
                    <div><a href="{{$item['open_link']}}" target="_blank">{{$item['title']}}</a></div>
                @endforeach

                <div>Supporting Images</div>
                @foreach($relatedImages as $key => $item)
                    <div><img src="{{$item['preview']}}"></div>
                    <div>{{$item['title']}}</div>
                @endforeach

            </div>
            --}}

        </div>
    </div>
</div>
