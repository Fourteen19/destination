@extends('frontend.layouts.master')

@section('content')
<article>
<div class="row r-pad" id="article-body">

    <div class="col-lg-8">
        {{-- loads the article template--}}
        @include('frontend.pages.free-articles.templates.' . $content->contentTemplate->slug)
    </div>

</div>

<div class="row r-sep mt-5">
    <div class="col">
        <div class="border-top def-border pt-3 pl-3">
            <a href="{{ route('frontend.home') }}" class="fw700 td-no d-inline-block mr-3">Back to the Homepage</a>
        </div>
    </div>
</div>
</article>

@endsection


