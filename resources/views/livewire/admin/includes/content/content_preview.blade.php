<div id="content_preview" class="tab-pane @if ($activeTab == "content_preview") active @else fade @endif">
    <div class="row">
        <div class="col-lg-6">

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

        </div>
    </div>
</div>
