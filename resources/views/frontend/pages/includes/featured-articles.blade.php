@if ($featuredArticles->count() > 0)

    <div class="row vlg-bg r-pad">
        <div class="col-lg-12">
            <div class="heading-no-border w-bg">
            <h2 class="t24 fw700 mb-0">Featured article</h2>
            </div>
        </div>

        @foreach ($featuredArticles as $featuredArticle)

            <div class="col-lg-12 r-base">
                <a href="{{ route('frontend.article', ['article' => $featuredArticle->slug]) }}" class="article-block-link">
                <img src="{{ parse_encode_url($featuredArticle->getFirstMediaUrl('summary', 'summary_slot4-5-6')) ?? '' }}">
                    <div class="w-bg article-summary">
                        <h3 class="t20">{{ $featuredArticle->summary_heading }}</h3>
                        <p class="t16">{{ $featuredArticle->summary_text }}</p>
                    </div>
                </a>
            </div>

        @endforeach

    </div>

@endif
