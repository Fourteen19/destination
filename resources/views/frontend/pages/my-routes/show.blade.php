@extends('frontend.layouts.master')

@section('content')
    <div class="slot-header d-flex mt-5 mb-3">
        <img src="{{ asset('images/md-routes.png') }}" alt="My routes">
    </div>
    <div class="p-3">
    <p>Below you will find all the articles relevant to the routes you are interested in for your potential career path.</p>
    <p>You can sort the articles by those that are most relevant to you or in alphabetical order.</p>
    </div>


    @livewire('frontend.my-routes-sectors-subjects', ["tagType" => "route"] )


    <div class="row r-sep mt-5">
        <div class="col">
            <div class="pt-3 pl-3">
                <a href="javascript:history.back();" class="fw700 td-no d-inline-block mr-3">Back to previous page</a> | <a href="{{ route('frontend.dashboard') }}" class="fw700 td-no d-inline-block ml-3">Back to home page</a>
            </div>
        </div>
    </div>
@endsection