@if ($relatedArticles->count() > 0)

    <div class="row vlg-bg r-pad">
        <div class="col-lg-12">
            <div class="heading-no-border w-bg">
            <h2 class="t24 fw700 mb-lg-0 mb-3">Other free articles you might like </h2>
            </div>
        </div>

        @foreach ($relatedArticles as $relatedArticle)

            <div class="col-lg-12 col-sm-6 col-md-4 r-base">
                <a href="{{ route('frontend.free-article', ['article' => $relatedArticle->slug]) }}" class="article-block-link flex-column">
                <img src="{{ parse_encode_url($relatedArticle->getFirstMediaUrl('summary', 'summary_slot4-5-6')) ?? '' }}">
                    <div class="w-bg article-summary">
                        <h3 class="t20">{{ $relatedArticle->summary_heading }}</h3>
                        <p class="t16">{{ Str::limit($relatedArticle->summary_text, $limit = 140, $end = '...') }}</p>
                    </div>
                </a>
            </div>

        @endforeach

    </div>

@endif
