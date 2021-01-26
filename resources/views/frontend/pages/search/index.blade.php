@extends('frontend.layouts.master')

@section('content')
    @livewire('frontend.articles-search-engine', ['articlesSearchService' => $articlesSearchService])
@endsection
