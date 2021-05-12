<div id="content_preview" class="tab-pane @if ($activeTab == "content_preview") active @else fade @endif" wire:key="content_preview-pane">
    <div class="row justify-content-center">
        <div class="col-xl-12">

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
                                <h3 class="t30 t-def fw700 mb-3">{{$item['title']}}</h3>
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
