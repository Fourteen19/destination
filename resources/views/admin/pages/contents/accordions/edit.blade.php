@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Edit an accordion</h2>
        </div>
    </div>
</div>

@include('admin.pages.includes.flash-message')

{!! Form::model($content, ['method' => 'PATCH','route' => ['admin.contents.accordions.update', $content->uuid]]) !!}

    @include('admin.pages.contents.accordions.form')

{!! Form::close() !!}

@endsection
