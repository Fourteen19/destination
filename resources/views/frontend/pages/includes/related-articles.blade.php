@if ($relatedArticles->count() > 0)

    <div class="row vlg-bg r-pad">
        <div class="col-lg-12">
            <div class="heading-no-border w-bg">
            <h2 class="t24 fw700 mb-0">Related articles you might like </h2>
            </div>
        </div>

        @foreach ($relatedArticles as $relatedArticle)

            <div class="col-lg-12 r-base">
                <a href="{{ $relatedArticle->slug }}" class="article-block-link">
                <img src="{{ !empty($relatedArticle->getFirstMediaUrl('summary', 'summary_slot4-5-6')) ? $relatedArticle->getFirstMediaUrl('summary', 'summary_slot4-5-6') : config('global.default_summary_images.summary_slot4-5-6')}}">
                    <div class="w-bg article-summary">
                        <h3 class="t20">{{ $relatedArticle->contentable->summary_heading }}</h3>
                        <p class="t16">{{ $relatedArticle->contentable->summary_text }}</p>
                    </div>
                </a>
            </div>

        @endforeach

    </div>

@endif
