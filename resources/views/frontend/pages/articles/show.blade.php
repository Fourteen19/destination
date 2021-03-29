@extends('frontend.layouts.master')

@section('content')
<article>
<div class="row r-pad" id="article-body">

    <div class="col-lg-8">
        {{-- loads the article template--}}
        @include('frontend.pages.articles.templates.' . $content->contentTemplate->slug)
    </div>

    <div class="col-lg-4">
        <div class="row justify-content-end">
            <div class="col-lg-10">
                @include('frontend.pages.includes.next-article-to-read')
            </div>

            <div class="col-lg-10">
                @include('frontend.pages.includes.related-articles')
            </div>

            <div class="col-lg-10">
                @include('frontend.pages.includes.featured-articles')
            </div>
        </div>
    </div>

</div>

@if ($displayFeedbackForm)
    @livewire('frontend.article-feedback-form')
@endif

<div class="row r-sep mt-5">
    <div class="col">
        <div class="border-top def-border pt-3 pl-3">
            <a href="javascript:history.back();" class="fw700 td-no d-inline-block mr-3">Back to previous page</a> | <a href="{{ route('frontend.dashboard') }}" class="fw700 td-no d-inline-block ml-3">Back to home page</a>
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

@include('frontend.pages.includes.hot-right-now')

@endsection


