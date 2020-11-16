@extends('frontend.layouts.app')

@section('content')

    <a href="{{ route('frontend.dashboard') }}">Back</a>

    Conent page

    {{ $content->title }}

    {{ $content->body }}
@endsection
