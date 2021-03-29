@extends('frontend.layouts.master')

{{--
@section('title', __('Too Many Requests'))
@section('code', '429')
@section('message', __('Too Many Requests'))
--}}

@section('content')

        <div class="row">
            <div class="col-lg-7 offset-1">
                <div class="p-w">
                    <h1 class="fw700 t36">429 - Too many requests</h1>
                    <p>There were too many requests made.</p>
                </div>
            </div>     
        </div>

@endsection


