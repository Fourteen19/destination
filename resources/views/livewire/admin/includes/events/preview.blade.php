<div id="event-preview" class="tab-pane px-0 @if ($activeTab == "event-preview") active @else fade @endif" wire:key="event-preview-pane">



    <img src="{{$bannerImagePreview}}" class="banner" alt="{{$banner_alt}}">



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
