@extends('frontend.layouts.master')


@section('content')

    @if (!empty($page->getFirstMediaUrl('banner', 'banner')))
        <div class="row justify-content-center">
            <div class="col-lg-10 r-pad">
                <img src="{{ showRelativePath($page->getFirstMediaUrl('banner', 'banner')) }}">
            </div>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="p-w">
                <h1 class="t36 fw700 mb-4">{{$page->title}}</h1>
                <h2 class="t24 mb-4">{{$page->pageable->lead}}</h2>
                {!! $page->pageable->body !!}
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="border-top def-border pt-3 pl-3">
                <a href="/" class="fw700 td-no">Back to home page</a>
            </div>
        </div>
    </div>

@endsection
