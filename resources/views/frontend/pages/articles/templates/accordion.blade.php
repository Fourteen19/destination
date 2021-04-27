
    <div class="row mb-5">
        <div class="col">
        @if (!empty($content->getFirstMediaUrl('banner', 'banner')))
            @foreach ( $content->getMedia('banner') as $key => $value)
                <img src="{{ $value->getUrl('banner') }}" alt="{{$value->getCustomProperty('alt')}}">
            @endforeach
        @endif
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">

            <h1 class="t36 fw700">{{ $content->title }} </h1>
            <h2 class="t24 fw700 mb-4">{{ $content->contentable->subheading }}</h2>
            <p class="t24 mb-4">{{ $content->contentable->lead }}</p>
            <div class="article-body">{!! $content->contentable->body !!}</div>

            <div id="accordianId" role="tablist" aria-multiselectable="true" class="accordion my-5">

                @foreach($content->relatedQuestions as $key => $question)

                    <div class="card">
                        <div class="card-header bg-2" role="tab" id="section{{$key}}HeaderId">
                            <h5 class="mb-0">
                                <a class="t-w td-no fw700" data-toggle="collapse" href="#section{{$key}}ContentId" aria-expanded="true" aria-controls="section{{$key}}ContentId">
                                    {!! $question->title !!}
                                </a>
                            </h5>
                        </div>
                        <div id="section{{$key}}ContentId" class="collapse in" role="tabpanel" aria-labelledby="section{{$key}}HeaderId" data-parent="#accordianId">
                            <div class="card-body vlg-bg">
                                {!! $question->text !!}
                            </div>
                        </div>
                    </div>

                @endforeach

            </div>


        </div>

    </div>

    @include('frontend.pages.includes.things')


