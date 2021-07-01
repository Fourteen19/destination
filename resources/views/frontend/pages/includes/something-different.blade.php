@if ($displaySomethingDifferentArticles == 'Y')

<div class="col-lg-6">
    <div class="row">
        <div class="col-12">
        <div class="heading-border w-bg w-100 mb-3">
        <h2 class="t36 fw700 mb-0">Something different</h2>
        <p class="mb-0">Here's a small selection of articles about careers choices you may not have previously considered.</p>
        </div>
        </div>
    </div>

    @foreach($somethingDifferentArticles as $key => $somethingDifferentArticle)

        @if ($loop->first)

            <div class="row">
                <div class="col-12 mb-sm-3 mb-lg-0">
                    <a href="{{ route('frontend.article', ['article' => $somethingDifferentArticle->slug]) }}" class="article-block-link">
                    <div class="row w-100 mb-4 no-gutters vlg-bg">
                        <div class="col-lg-4 col-sm-6">
                            <div class="square" style="background-image: url('{{ parse_encode_url($somethingDifferentArticle->getFirstMediaUrl('summary', 'summary_you_might_like')) ?? '' }}')"></div>
                        </div>
                        <div class="col-lg-8 col-sm-6">
                        <div class="article-summary">
                            <h3 class="t20 fw700">{{ $somethingDifferentArticle->summary_heading }}</h3>
                            <p class="t16">{{ Str::limit($somethingDifferentArticle->summary_text, $limit = 140, $end = '...') }}</p>
                        </div>
                        </div>
                    </div>
                    </a>
                </div>
            </div>

            <div class="row">
        @else

            <div class="col-md-6 col-12 mb-sm-3 mb-lg-0">
                <a href="{{ route('frontend.article', ['article' => $somethingDifferentArticle->slug]) }}" class="article-block-link">
                <div class="row w-100">
                    <div class="col-lg-4 col-sm-6">
                    <div class="square" style="background-image: url('{{ !empty($somethingDifferentArticle->getFirstMediaUrl('summary', 'summary_you_might_like')) ? $somethingDifferentArticle->getFirstMediaUrl('summary', 'summary_you_might_like') : config('global.default_summary_images.summary_you_might_like')}}')"></div>
                    </div>
                    <div class="col-lg-8 col-sm-6">
                        <div class="p-3 p-md-0">
                            <h3 class="t20 fw700">{{ $somethingDifferentArticle->summary_heading }}</h3>
                            <p class="t16">{{ Str::limit($somethingDifferentArticle->summary_text, $limit = 140, $end = '...') }}</p>
                        </div>
                    </div>
                </div>
                </a>
            </div>

        @endif

    @endforeach

    </div>

</div>

@endif
