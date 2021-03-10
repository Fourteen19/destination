@if ($displayReadItAgainArticles == 'Y')

<div class="col-lg-6">
    <div class="row">
        <div class="col-12">
        <div class="heading-border w-bg w-100 d-flex">
        <h2 class="t36 fw700 mb-0">Read it again</h2>
        </div>
        </div>
    </div>

    @foreach($readItAgainArticles as $key => $readItAgainArticle)

        @if ($loop->first)

            <div class="row">
                <div class="col">
                    <a href="{{ route('frontend.article', ['article' => $readItAgainArticle->slug]) }}" class="article-block-link">
                    <div class="row mb-4 no-gutters vlg-bg">
                        <div class="col-lg-4">
                            <div class="square" style="background-image: url('{{ !empty($readItAgainArticle->getFirstMediaUrl('summary', 'summary_you_might_like')) ? $readItAgainArticle->getFirstMediaUrl('summary', 'summary_you_might_like') : config('global.default_summary_images.summary_you_might_like')}}')"></div>
                        </div>
                        <div class="col-lg-8">
                        <div class="article-summary">
                            <h3 class="t20 fw700">{{ $readItAgainArticle->summary_heading }}</h3>
                            <p class="t16">{{ $readItAgainArticle->summary_text }}</p>
                        </div>
                        </div>
                    </div>
                    </a>
                </div>
            </div>

            <div class="row">
        @else

            <div class="col-lg-6">
                <a href="{{ route('frontend.article', ['article' => $readItAgainArticle->slug]) }}" class="article-block-link">
                <div class="row">
                    <div class="col-lg-4">
                    <div class="square" style="background-image: url('{{ !empty($readItAgainArticle->getFirstMediaUrl('summary', 'summary_you_might_like')) ? $readItAgainArticle->getFirstMediaUrl('summary', 'summary_you_might_like') : config('global.default_summary_images.summary_you_might_like')}}')"></div>
                    </div>
                    <div class="col-lg-8">
                    <h3 class="t20 fw700">{{ $readItAgainArticle->summary_heading }}</h3>
                    <p class="t16">{{ $readItAgainArticle->summary_text }}</p>
                    </div>
                </div>
                </a>
            </div>

        @endif

    @endforeach

    </div>

</div>

@endif
