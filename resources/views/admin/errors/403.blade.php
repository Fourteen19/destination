@extends('admin.layouts.app')


{{--
@section('title', __('Forbidden'))
@section('code', '403')
@section('message', __($exception->getMessage() ?: 'Forbidden'))
--}}

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                
                    <h1 class="fw700 t36">403 - Forbidden</h1>
                    <p>This page is forbidden.</p>
                
            </div>     
        </div>
    </div>
@endsection

