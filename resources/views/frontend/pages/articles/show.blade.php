@extends('frontend.layouts.master')

@section('content')
<article>
<div class="row r-pad" id="article-body">

    {{-- loads the article template--}}
    @include('frontend.pages.articles.templates.' . $content->contentTemplate->slug)

    <div class="col-lg-4">
        <div class="row justify-content-end">
            <div class="col-lg-10">
                @include('frontend.pages.includes.related-articles')
            </div>
        </div>
    </div>
</div>

@livewire('frontend.article-feedback-form', ['article' => $content])

<div class="row r-sep mt-5">
    <div class="col">
        <div class="border-top def-border pt-3 pl-3">
            <a href="{{ route('frontend.dashboard') }}" class="fw700 td-no d-inline-block mr-3">Back to previous page</a> | <a href="{{ route('frontend.dashboard') }}" class="fw700 td-no d-inline-block ml-3">Back to home page</a>
        </div>
    </div>
</div>
</article>

<div class="row mt-5">
    <div class="col-12">
        <div class="heading-no-border">
        <h3 class="t36 fw700 mb-0">Other pages you might like</h3>
        </div>
    </div>
</div>
<div class="row mb-5">
    @foreach( $articlesYouMightLike as $article)
        <div class="col-3">
            <a href="{{ route('frontend.article', ['article' => $article->slug]) }}" class="td-no">
                <div class="square d-flex align-items-end" style="background-image: url({{ !empty($article->getFirstMediaUrl('summary', 'summary_you_might_like')) ? $article->getFirstMediaUrl('summary', 'summary_you_might_like') : config('global.default_summary_images.summary_you_might_like') }})">
                <div class="blur-summary"><h4 class="t20 fw700">{{$article->summary_heading}}</h4></div>
            </div>
            </a>
        </div>
    @endforeach
</div>

<div class="row mt-5">
    <div class="col-12">
        <div class="heading-no-border">
        <h3 class="t36 fw700 mb-0">#hotrightnow</h3>
        <p class="t18 fw700">Check out the articles that are trending right now on MyDirections.</p>
        </div>
    </div>
</div>
<div class="row mb-5">
    <div class="col-3">
        <a href="#" class="td-no">
        <div class="square d-flex align-items-end" style="background-image: url('https://via.placeholder.com/737x737/5379a6/5379a6?text=Banner')">
            <div class="blur-summary"><h4 class="t20 fw700">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do </h4></div>
        </div>
        </a>
    </div>
    <div class="col-3">
    <a href="#" class="td-no">
        <div class="square d-flex align-items-end" style="background-image: url('https://via.placeholder.com/737x737/5379a6/5379a6?text=Banner')">
            <div class="blur-summary"><h4 class="t20 fw700">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do </h4></div>
        </div>
        </a>
    </div>
    <div class="col-3">
    <a href="#" class="td-no">
        <div class="square d-flex align-items-end" style="background-image: url('https://via.placeholder.com/737x737/5379a6/5379a6?text=Banner')">
            <div class="blur-summary"><h4 class="t20 fw700">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do </h4></div>
        </div>
        </a>
    </div>
    <div class="col-3">
    <a href="#" class="td-no">
        <div class="square d-flex align-items-end" style="background-image: url('https://via.placeholder.com/737x737/5379a6/5379a6?text=Banner')">
            <div class="blur-summary"><h4 class="t20 fw700">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do </h4></div>
        </div>
        </a>
    </div>
</div>
<div id="message"></div>
@endsection

@push('scripts')
<script type="text/javascript">

    var observer = new IntersectionObserver(function(entries) { console.log(entries);
        console.log(entries);
        if(entries[0]['isIntersecting'] === true) {
            if(entries[0]['intersectionRatio'] === 1){
                document.querySelector("#message").textContent = 'Target is fully visible in screen';
                console.log('Target is fully visible in screen');
            } else if(entries[0]['intersectionRatio'] > 0.5){
                document.querySelector("#message").textContent = 'More than 50% of target is visible in screen';
                console.log('More than 50% of target is visible in screen');
            } else {
                document.querySelector("#message").textContent = 'Less than 50% of target is visible in screen';
                console.log('Less than 50% of target is visible in screen');
            }
        }
        else {
            document.querySelector("#message").textContent = 'Target is not visible in screen';
            console.log('Target is not visible in screen');
        }
    }, { threshold: [0, 0.5, 1] });

    observer.observe(document.querySelector("#article-body"));

</script>
@endpush
