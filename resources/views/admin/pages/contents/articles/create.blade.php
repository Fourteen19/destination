@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Create New Article</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('admin.contents.index') }}">Back</a>
        </div>
    </div>
</div>

@include('admin.pages.includes.flash-message')


{{-- {!! Form::model($content, ['method' => 'POST','route' => ['admin.contents.articles.store'], 'wire:submit.prevent' => 'submit' ]) !!} --}}


<form wire:submit.prevent="submit">
{{--
    @include('admin.pages.contents.articles.form')
--}}
    @livewire('admin.content-article-form', ['action' => 'add', 'content' => $content])

    {{--
{!! Form::close() !!}
--}}
    </form>

@endsection
