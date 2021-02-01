@extends('frontend.layouts.master')


@section('content')

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="p-w">
                <h1 class="t36 fw700 mb-4">{{ $data['title'] }}</h1>
                {!! $data['body_txt'] !!}
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="border-top def-border pt-3 pl-3">
                <a href="{{ route('frontend.home') }}" class="fw700 td-no">Back to home page</a>
            </div>
        </div>
    </div>

@endsection
