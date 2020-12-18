@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 margin-tb">
        
            <h1 class="mb-4">Edit Article</h1>
            <p class="mydir-instructions">Eu laborum ipsum nisi incididunt cupidatat. Aute mollit laboris commodo magna voluptate enim irure non et enim pariatur officia fugiat irure. Sunt velit nostrud qui ullamco velit consequat in eu dolor eu exercitation laboris. Sit dolore quis sunt minim nostrud quis occaecat deserunt culpa dolor qui aliqua labore.</p>
            
        </div>
    </div>
    <div class="row">
        <div class="col-12 border-bottom md-border my-4"></div>
    </div>
@include('admin.pages.includes.flash-message')

{{--
{!! Form::model($content, ['method' => 'PATCH', 'route' => ['admin.contents.articles.update', ['article' => $content->uuid] ] ]) !!}

     @include('admin.pages.contents.articles.form')

--}}
 @livewire('admin.content-article-form', ['action' => 'edit', 'content' => $content])

 {{--
{!! Form::close() !!}



<div style="height: 600px;">
    <div id="fm"></div>
</div>
--}}

@endsection


@push('styles')
<link rel="stylesheet" href="{{ asset('vendor/file-manager/css/file-manager.css') }}">
@endpush


@push('scripts')
<script src="{{ asset('vendor/file-manager/js/file-manager.js') }}"></script>
@endpush
