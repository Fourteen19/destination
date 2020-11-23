@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Edit Content</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('admin.contents.index') }}"> Back</a>
        </div>
    </div>
</div>

@include('admin.pages.includes.flash-message')

{!! Form::model($content, ['method' => 'PATCH','route' => ['admin.contents.update', $content->uuid]]) !!}

    @include('admin.pages.contents.form')

{!! Form::close() !!}

@endsection