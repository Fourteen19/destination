@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Edit Subject Tag</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('admin.tags.subjects.index') }}"> Back</a>
        </div>
    </div>
</div>

@include('admin.pages.includes.flash-message')

{!! Form::model($tag, ['method' => 'PATCH','route' => ['admin.tags.subjects.update', $tag->id]]) !!}

    @include('admin.pages.tags.subjects.form')

{!! Form::close() !!}

@endsection