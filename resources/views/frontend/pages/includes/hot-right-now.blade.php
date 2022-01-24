@if(Auth::guard('web')->check())

    @if ($displayHotRightNowArticles == 'Y')

        <div class="row">
            <div class="col-12">
                <div class="heading-no-border">
                <h3 class="t36 fw700 mb-0">#hotrightnow</h3>
                <p class="t18 fw700">Check out the articles that are trending right now on MyDirections.</p>
                </div>
            </div>
        </div>
        <div class="row">

            @foreach ($hotRightNowArticles as $hotRightNowArticle)
                <div class="col-xl-3 col-sm-6">
                    <a href="{{ route('frontend.article', ['article' => $hotRightNowArticle->slug]) }}" class="td-no">
                    <div class="square d-flex align-items-end" style="background-image: url('{{ parse_encode_url($hotRightNowArticle->getFirstMediaUrl('summary', 'summary_you_might_like')) ?? '' }}')">
                        <div class="blur-summary"><h4 class="t20 fw700">{{ $hotRightNowArticle->summary_heading }}</h4></div>
                    </div>
                    </a>
                </div>
            @endforeach

        </div>

    @endif


@else

    @if ($displayHotRightNowArticles == 'Y')

        <div class="row">
            <div class="col-12">
                <div class="heading-no-border">
                <h3 class="t36 fw700 mb-0">#hotrightnow</h3>
                <p class="t18 fw700">Check out the articles that are trending right now on MyDirections - you’ll need to login to access them.</p>
                </div>
            </div>
        </div>
        <div class="row">

            @foreach ($hotRightNowArticles as $hotRightNowArticle)
                <div class="col-xl-3 col-sm-6 col-lg-3 mb-3 mb-xl-0">
                    <div class="square d-flex align-items-end" style="background-image: url('{{ !empty($hotRightNowArticle->getFirstMediaUrl('summary', 'summary_you_might_like')) ? parse_encode_url($hotRightNowArticle->getFirstMediaUrl('summary', 'summary_you_might_like')) : config('global.default_summary_images.summary_you_might_like')}}')">
                        <div class="blur-summary"><h4 class="t20 fw700">{{ $hotRightNowArticle->summary_heading }}</h4></div>
                    </div>
                </div>
            @endforeach

        </div>

    @endif

@endif
