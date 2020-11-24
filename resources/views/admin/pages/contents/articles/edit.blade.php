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

{!! Form::model($content, ['method' => 'PATCH', 'route' => ['admin.contents.articles.update', ['article' => $content->uuid] ] ]) !!}

    @include('admin.pages.contents.articles.form')

{!! Form::close() !!}

@endsection
