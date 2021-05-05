    <section class="activity-banner bg-2 t-w mb-5">
        <div class="row mb-5 justify-content-between align-items-center">
            <div class="col-xl-5">

            <h1 class="t30 fw700 t-w">{{ $content->title }}</h1>

            <div class="ac-intro t20">
                {!! $content->contentable->introduction !!}
            </div>

            </div>
            <div class="col-xl-5">
                @if (!empty($content->getFirstMediaUrl('banner')))
                    @foreach ( $content->getMedia('banner') as $key => $value)
                        <div class="ac-ban-img"><img src="{{ $value->getUrl('banner_activity') }}" alt="{{$value->getCustomProperty('alt')}}"  class="img-fluid"></div>
                    @endforeach
                @endif

            </div>
        </div>
    </section>

    <div class="row r-sep">
        <div class="col-xl-8">
            <h2 class="t24 fw700 mb-3">{{ $content->contentable->subheading }}</h2>
            <p class="t24 mb-4">{{ $content->contentable->lead }}</p>
            <div class="article-body">{!! $content->contentable->body !!}</div>
        </div>

        @if ($content->contentable->think_about)
            <div class="col-xl-4">
                <div class="row justify-content-end">
                    <div class="col-xl-11">
                        <div class="act-things bg-2 t-w" style="background-image: url({{ asset('images/background-balls.png') }})">
                            <div class="row">
                                <div class="col-2"><i class="fas fa-lightbulb fa-3x"></i></div>
                                <div class="col-10">
                                    <h2 class="t24 fw700 t-w">Things to think about</h2>
                                    {{ $content->contentable->think_about }}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        @endif

    </div>

    <section class="mlg-bg mb-5 rounded-lg">
    <div class="row justify-content-center">
        <div class="col-xl-7">
            @if (count($content->relatedVideos) > 0)

                    @foreach ($content->relatedVideos as $item)
                        <div class="my-5 text-center">
                            <h3 class="t30 t-def fw700 mb-3">{{ $item->title }}</h3>
                            <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" src="{{ $item->url }}" frameborder="0" allowfullscreen></iframe>
                            </div>
                        </div>
                    @endforeach

            @endif
        </div>
    </div>
    </section>

    @if ($content->contentable->alt_block_text)
        <div class="alternate-block my-5 mlg-bg p-5">
            <h2 class="t24 fw700">{{ $content->contentable->alt_block_heading }}</h2>
            <div class="alt-cols">
                {!! $content->contentable->alt_block_text !!}
            </div>
        </div>
    @endif

    <div class="lower-text my-5">
        {!! $content->contentable->lower_body !!}
    </div>

    @include('frontend.pages.includes.things')

    @livewire('frontend.activity-feedback-form', ['uuid' => $content->uuid])

    <div class="row my-5">
        <div class="col-12">
            <div class="bg-2 p-4"><a href="{{ route('frontend.work-experience') }}" class="t-w td-no fw700"><span class="mr-3"><svg xmlns="http://www.w3.org/2000/svg" width="15.345" height="17.714" viewBox="0 0 46.5 53.68"><defs><style>.arrow {fill: #fff;fill-rule: evenodd;}</style></defs><path id="Triangle_3" data-name="Back" class="arrow" d="M420.25,5625.75l46.5-26.84v53.68Z" transform="translate(-420.25 -5598.91)"/></svg></span>Back to Work Experience page</a></div>
        </div>
    </div>

    @include('frontend.pages.includes.activities.suggested-activities')

    @include('frontend.pages.includes.employers.featured-employers')
