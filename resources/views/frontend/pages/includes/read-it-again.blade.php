@if ($displayReadItAgainArticles == 'Y')

<div class="col-lg-6">
    <div class="row">
        <div class="col-12">
        <div class="heading-border w-bg w-100 mb-3">
        <h2 class="t36 fw700 mb-0">Read it again</h2>
        <p class="mb-0">Read something interesting but can't remember where? Don't worry we've got it. <a href="/my-account/view-my-articles">Click here to find all the articles you've read previously.</a></p>
        </div>
        </div>
    </div>

    @foreach($readItAgainArticles as $key => $readItAgainArticle)

        @if ($loop->first)

            <div class="row">
                <div class="col-12 mb-sm-3 mb-lg-0">
                    <a href="{{ route('frontend.article', ['article' => $readItAgainArticle->slug]) }}" class="article-block-link">
                    <div class="row w-100 mb-4 no-gutters vlg-bg">
                        <div class="col-lg-4 col-sm-6">
                            <div class="square" style="background-image: url('{{ parse_encode_url($readItAgainArticle->getFirstMediaUrl('summary', 'summary_you_might_like')) ?? '' }}')"></div>
                        </div>
                        <div class="col-lg-8 col-sm-6">
                        <div class="article-summary">
                            <h3 class="t20 fw700">{{ $readItAgainArticle->summary_heading }}</h3>
                            <p class="t16">{{ Str::limit($readItAgainArticle->summary_text, $limit = 140, $end = '...') }}</p>
                        </div>
                        </div>
                    </div>
                    </a>
                </div>
            </div>

            <div class="row">
        @else

            <div class="col-md-6 col-12 mb-sm-3 mb-lg-0">
                <a href="{{ route('frontend.article', ['article' => $readItAgainArticle->slug]) }}" class="article-block-link">
                <div class="row w-100">
                    <div class="col-lg-4 col-sm-6">
                    <div class="square" style="background-image: url('{{ !empty($readItAgainArticle->getFirstMediaUrl('summary', 'summary_you_might_like')) ? parse_encode_url($readItAgainArticle->getFirstMediaUrl('summary', 'summary_you_might_like')) : config('global.default_summary_images.summary_you_might_like')}}')"></div>
                    </div>
                    <div class="col-lg-8 col-sm-6">
                        <div class="p-3 p-md-0">
                            <h3 class="t20 fw700">{{ $readItAgainArticle->summary_heading }}</h3>
                            <p class="t16">{{ Str::limit($readItAgainArticle->summary_text, $limit = 140, $end = '...') }}</p>
                        </div>
                    </div>
                </div>
                </a>
            </div>

        @endif

    @endforeach

    </div>

</div>

{{-- only display the something-different block if we have 3 articles in the "read it again" block --}}
@include('frontend.pages.includes.something-different')


@endif
