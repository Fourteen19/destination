@extends('frontend.layouts.master')

@section('content')
<div class="row p-w">
    @include('frontend.pages.includes.account-menu')
    <div class="col-lg-9">
        <div class="account-form ml-lg-4 pl-lg-5 def-border">
            <h1 class="t36 fw700 mb-4">My Articles</h1>
            <p>If you are looking for an article you have read before, here's a list of them.</p>
            <div class="row">
                <div class="col">
                    <div class="border-top def-border w-100 mb-5"></div>
                </div>
            </div>

            @if (count($myArticles) > 0)
                <ul class="list-unstyled">
                    @foreach ($myArticles as $myArticle)
                        <li class="mb-3"><a href="{{ route('frontend.article', ['article' => $myArticle->slug]) }}">{{$myArticle->title}}</a></li>
                    @endforeach
                </ul>
            @else
                <div>You have not read any article yet.</div>
            @endif

        </div>
    </div>
</div>
@endsection
