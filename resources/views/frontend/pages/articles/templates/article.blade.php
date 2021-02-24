
    <div class="row mb-5">
        <div class="col">
        @if (!empty($content->getFirstMediaUrl('banner', 'banner')))
            <img src="{{ $content->getFirstMediaUrl('banner', 'banner') }}">
        @endif
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">

            <h1 class="t36 fw700">{{ $content->title }} </h1>
            <h2 class="t24 fw700 mb-4">{{ $content->subheading }}</h2>
            <p class="t24 mb-4">{{ $content->contentable->lead }}</p>
            <div class="article-body">{!! $content->contentable->body !!}</div>

            <div class="sup-img my-5">
                @foreach ( $content->getMedia('supporting_images') as $key => $value)
                {{-- https://via.placeholder.com/1274x536/f74e77/f74e77?text=Banner --}}
                    <img src="{{ $value->getUrl('supporting_images') }}">
                    <div class="sup-img-caption vlg-bg p-3 t16 fw700">{{ $value->getCustomProperty('title') }}</div>
                @endforeach
            </div>

            @if ($content->videos)
                <div class="vid-block my-5">
                    <h3 class="t24 fw700 mb-3">Watch the video</h3>
                    @foreach ($content->videos as $item)
                        <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" src="{{ $item->url }}" frameborder="0" allowfullscreen></iframe>
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="alternate-block my-5 mlg-bg p-5">
                <h2 class="t24 fw700">{{ $content->contentable->alt_block_heading }}</h2>
                <div class="alt-cols">

                    {!! $content->contentable->alt_block_text !!}

                    {!! $content->contentable->lower_body !!}

                </div>

            </div>



            <div class="lower-text">
                <p>Duis dolore proident dolore consequat aute consequat nisi irure quis. Eiusmod enim dolor aute dolore magna ex ad sunt tempor irure. Qui ex sunt Lorem consectetur laboris deserunt ut adipisicing pariatur ea voluptate deserunt duis quis. Lorem Lorem ipsum irure non occaecat id ullamco eiusmod commodo irure exercitation officia nostrud laborum. Nostrud pariatur occaecat pariatur aliquip officia officia. Tempor ea laboris occaecat laboris ex nisi exercitation.</p>
            </div>

        </div>

    </div>

    @include('frontend.pages.includes.things')


