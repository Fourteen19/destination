@extends('frontend.layouts.app')

@section('content')

    <a href="{{ route('frontend.dashboard') }}">Back</a> <br>

    Content page <br>

    {{ $content->title }} <br>

    {{ $content->body }} <br>

@endsection
