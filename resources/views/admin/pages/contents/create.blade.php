@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 margin-tb">

            <h1 class="mb-4">Create New {{ $contentOwner }} Content - Choose a template</h1>
            <p class="mydir-instructions">Use the form below to select the template type.</p>

        </div>
    </div>
    <div class="row">
        <div class="col-12 border-bottom md-border my-4"></div>
    </div>

<div class="row">
    <div class="col-lg-6">
@include('admin.pages.includes.flash-message')

@if (Route::currentRouteName() == 'admin.global.contents.create')
{!! Form::model($content, ['method' => 'POST','route' => ['admin.global.contents.store']]) !!}
@else
{!! Form::model($content, ['method' => 'POST','route' => ['admin.contents.store']]) !!}
@endif
    @include('admin.pages.contents.form')

{!! Form::close() !!}
</div>
</div>

<div class="row">
    <div class="col">
        <div class="mydir-controls mt-5">
            @if (Route::currentRouteName() == 'admin.global.contents.create')
                <a class="mydir-action" href="{{ route('admin.global.contents.index') }}"><i class="fas fa-caret-left mr-2"></i>Back</a>
            @else
                <a class="mydir-action" href="{{ route('admin.contents.index') }}"><i class="fas fa-caret-left mr-2"></i>Back</a>
            @endif
        </div>
    </div>
</div>
</div>
@endsection
