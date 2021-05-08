
    <div class="row mb-5">
        <div class="col">
            @if (!empty($content->getFirstMediaUrl('banner')))
                <img src="{{parse_encode_url($content->getFirstMediaUrl('banner'))}}" alt="{{$content->getFirstMedia('banner')->getCustomProperty('alt')}}">
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">

            <h1 class="t36 fw700">{{ $content->title }} </h1>
            <h2 class="t24 fw700 mb-4">{{ $content->contentable->subheading }}</h2>
            <p class="t24 mb-4">{{ $content->contentable->lead }}</p>
            <div class="article-body">{!! $content->contentable->body !!}</div>

            @if (count($content->getMedia('supporting_images')) > 0)
            <div class="sup-img-holder mt-5">
                @foreach ( $content->getMedia('supporting_images') as $key => $value)
                    <div class="sup-img mb-4">
                    <img src="{{ parse_encode_url($value->getUrl()) }}" @if ($value->getCustomProperty('alt'))alt={{ json_encode($value->getCustomProperty('alt')) }} @endif>
                    @if ($value->getCustomProperty('title'))
                        <div class="sup-img-caption vlg-bg p-3 t16 fw700">{{ $value->getCustomProperty('title') }}</div>
                    @endif
                    </div>
                @endforeach
            </div>
            @endif

            @if (count($content->relatedVideos) > 0)
                <div class="vid-block my-5">
                    <h3 class="t24 fw700 mb-3">Watch the video</h3>
                    @foreach ($content->relatedVideos as $item)
                        <div class="embed-responsive embed-responsive-16by9 mb-5">
                        <iframe class="embed-responsive-item" src="{{ $item->url }}" frameborder="0" allowfullscreen></iframe>
                        </div>
                    @endforeach
                </div>
            @endif

            @if ($content->contentable->alt_block_text)
                <div class="alternate-block my-5 mlg-bg p-5">
                    <h2 class="t24 fw700">{{ $content->contentable->alt_block_heading }}</h2>
                    <div class="alt-cols">
                        {!! $content->contentable->alt_block_text !!}
                    </div>
                </div>
            @endif

            @if ($content->contentable->lower_body)
                <div class="lower-text">
                    {!! $content->contentable->lower_body !!}
                </div>
            @endif

        </div>

    </div>

    @include('frontend.pages.includes.things')


