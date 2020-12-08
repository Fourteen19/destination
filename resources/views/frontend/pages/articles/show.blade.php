@extends('frontend.layouts.app')

@section('content')

    <a href="{{ route('frontend.dashboard') }}">Back</a> <br>

    {{ $content->title }} <br>

    {{ $content->contentable->lead }} <br>

    {!! $content->contentable->body !!} <br>

    {{ $content->contentable->statement }} <br>

    {{ $content->contentable->alt_block_heading }} <br>

    {!! $content->contentable->alt_block_text !!} <br>

    @foreach ($content->videos as $item)
        {{ $item->url }}<br>
    @endforeach

    @foreach ($content->related_links as $item)
        <a href="{{ $item->url }}">{{ $item->title }}</a><br>

    @endforeach

    @foreach ($content->related_downloads as $item)
        <a href="{{ $item->url }}">{{ $item->title }}</a><br>
    @endforeach

@endsection
