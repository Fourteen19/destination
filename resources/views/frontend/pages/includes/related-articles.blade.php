@if ($relatedArticles->count() > 0)

    <div class="row vlg-bg r-pad">
        @if (Auth::guard('web')->check())
        <div class="col-lg-12">
            <div class="heading-no-border w-bg">
            <h2 class="t24 fw700 mb-0">{{$relatedArticlesBlockType}} articles you might like</h2>
            </div>
        </div>
        @else
        <div class="col-lg-12">
            <div class="heading-no-border w-bg">
            <h2 class="t24 fw700 mb-0">Free articles from MyDirections</h2>
            </div>
        </div>
        @endif

        @foreach ($relatedArticles as $relatedArticle)

            <div class="col-lg-12 r-base">
                <a href="{{ route('frontend.article', ['article' => $relatedArticle->slug]) }}" class="article-block-link">
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
