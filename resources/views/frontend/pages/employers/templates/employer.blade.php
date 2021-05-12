<section class="activity-banner bg-2 t-w mb-5">
    <div class="row mb-5 justify-content-between align-items-center">
        <div class="col-xl-5">
        <div class="heading-pre">Employer Profile</div>
        <h1 class="t30 fw700 t-w mb-4">{{ $content->title }}</h1>

        <div class="ac-intro t20">{{ $content->contentable->introduction }}
        </div>

        </div>

        @if (!empty($content->getFirstMediaUrl('banner', 'banner')))
            @foreach ( $content->getMedia('banner') as $key => $value)
                <div class="col-xl-5">
                    <div class="ac-ban-img"><img src="{{ $value->getUrl('banner') }}" alt="{{$value->getCustomProperty('alt')}}" class="img-fluid"></div>
                </div>
            @endforeach
        @endif

    </div>
</section>
<div class="row">
    <div class="col-lg-8">
        <div class="row">
            <div class="col-lg-12">

                <h2 class="t24 fw700 mb-4">{{ $content->contentable->subheading }}</h2>
                <p class="t24 mb-4">{{ $content->contentable->lead }}</p>
                <div class="article-body">{!! $content->contentable->body !!}</div>

            </div>
        </div>


        @if (count($content->getMedia('supporting_images')) > 0)
            <div class="sup-img my-5">
                @foreach ( $content->getMedia('supporting_images') as $key => $value)
                    <img src="{{ $value->getUrl('supporting_images') }}" @if ($value->getCustomProperty('alt'))alt={{ json_encode($value->getCustomProperty('alt')) }} @endif>
                    @if ($value->getCustomProperty('title'))
                    <div class="sup-img-caption vlg-bg p-3 t16 fw700">{{ $value->getCustomProperty('title') }}</div>
                    @endif
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


        @if ($content->contentable->lower_body)
            <div class="lower-text">
                {!! $content->contentable->lower_body !!}
            </div>
        @endif


    </div>
    <div class="col-lg-4">

        @if ($relatedEmployer)

            <div class="row justify-content-end">
                <div class="col-lg-10">
                    <div class="row vlg-bg r-pad">
                        <div class="col-lg-12">
                            <div class="heading-no-border w-bg">
                            <h2 class="t24 fw700 mb-0">Related Employers</h2>
                            </div>
                        </div>
                        <div class="col-lg-12 r-base">
                            <a href="{{ route('frontend.employer', ['employer' => $relatedEmployer->slug]) }}" class="td-no t-def">
                                <div class="square d-flex">
                                    <div class="ep-inner">
                                        <div class="ep-logo"><img src="{{$relatedEmployer->getFirstMediaUrl('banner', 'banner') ?? ''}}"></div>
                                        <div class="ep-summary">
                                            <div class="ep-pre t14 t-up fw600 lh0">Employer Profile:</div>
                                            <div class="ep-name t24">{{$relatedEmployer->title}}</div>
                                            <div class="ep-sector lh1 t16">
                                                @foreach($relatedEmployer->sectorTags()->get() as $tag)
                                                    {{$tag->name}}<br/>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        @endif



        @if ($relatedArticle)

            <div class="row justify-content-end">
                <div class="col-lg-10">
                    <div class="row vlg-bg r-pad">
                        <div class="col-lg-12">
                            <div class="heading-no-border w-bg">
                            <h2 class="t24 fw700 mb-0">An article you might like</h2>
                            </div>
                        </div>
                        <div class="col-lg-12 r-base">
                            <a href="{{ route('frontend.article', ['article' => $relatedArticle->slug]) }}" class="article-block-link">
                                <img src="{{$relatedArticle->getFirstMedia('summary')->getUrl('summary_slot4-5-6') ?? '' }}"
                                     alt="{{$relatedArticle->getFirstMedia('summary')->getCustomProperty('alt')}}" >
                                <div class="w-bg article-summary">
                                    <h3 class="t20">{{$relatedArticle->summary_heading}}</h3>
                                    <p class="t16">{{$relatedArticle->summary_text}}</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        @endif


    </div>
</div>

@include('frontend.pages.includes.things')

