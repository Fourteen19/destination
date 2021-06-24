@if ($nextArticletoRead)

    <div class="row vlg-bg r-pad">
        <div class="col-lg-12">
            <div class="heading-no-border w-bg">
            <h2 class="t24 fw700 mb-lg-0 mb-sm-3">Next, you should read</h2>
            </div>
        </div>

        <div class="col-lg-12 col-sm-6 r-base">
            <a href="{{ route('frontend.article', ['article' => $nextArticletoRead->slug]) }}" class="article-block-link">
            <img src="{{ !empty($nextArticletoRead->getFirstMediaUrl('summary', 'summary_slot4-5-6')) ? $nextArticletoRead->getFirstMediaUrl('summary', 'summary_slot4-5-6') : config('global.default_summary_images.summary_slot4-5-6')}}">
                <div class="w-bg article-summary">
                    <h3 class="t20">{{ $nextArticletoRead->summary_heading }}</h3>
                    <p class="t16">{{ Str::limit($nextArticletoRead->summary_text, $limit = 140, $end = '...') }}</p>
                </div>
            </a>
        </div>

    </div>

@endif
