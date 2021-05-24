@extends('frontend.layouts.master')


@section('content')

    @if (!empty($page->getFirstMediaUrl('banner')))
        <div class="row justify-content-center">
            <div class="col-lg-10 r-pad">
                <img src="{{ parse_encode_url($page->getFirstMediaUrl('banner')) }}">
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
                <a href="@auth('web'){{ route('frontend.dashboard') }}@else{{ route('frontend.home') }}@endauth" class="fw700 td-no">Back to home page</a>
            </div>
        </div>
    </div>

@endsection
