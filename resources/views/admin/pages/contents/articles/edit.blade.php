@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Edit an article</h2>
        </div>
    </div>
</div>

@include('admin.pages.includes.flash-message')

{{--
{!! Form::model($content, ['method' => 'PATCH', 'route' => ['admin.contents.articles.update', ['article' => $content->uuid] ] ]) !!}

     @include('admin.pages.contents.articles.form')

--}}
 @livewire('admin.content-article-form', ['action' => 'edit', 'content' => $content])

 {{--
{!! Form::close() !!}
--}}


<div style="height: 600px;">
    <div id="fm"></div>
</div>


@endsection


@push('styles')
<link rel="stylesheet" href="{{ asset('vendor/file-manager/css/file-manager.css') }}">
@endpush


@push('scripts')
<script src="{{ asset('vendor/file-manager/js/file-manager.js') }}"></script>
@endpush
