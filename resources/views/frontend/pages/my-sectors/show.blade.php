@extends('frontend.layouts.master')

@section('content')
    <div class="slot-header d-flex mt-5 mb-3">
        <img src="{{ asset('images/md-sectors.png') }}" alt="My Sectors">
    </div>
    <div class="p-3">
    <p>Below you will find all the articles relevant to the sectors you are interested in learning more about.</p>
    <p>You can sort the articles by those that are most relevant to you or in alphabetical order.</p>
    </div>
    

    @livewire('frontend.my-routes-sectors-subjects', ["tagType" => "sector"] )

    <div class="row r-sep mt-5">
        <div class="col">
            <div class="pt-3 pl-3">
                <a href="javascript:history.back();" class="fw700 td-no d-block d-lg-inline-block mr-3 mb-4 mb-lg-0"><i class="fas fa-caret-left mr-2"></i> Back to previous page</a> <span class="d-none d-lg-inline">|</span> <a href="{{ route('frontend.dashboard') }}" class="fw700 td-no d-block d-lg-inline-block ml-lg-3"><i class="fas fa-caret-left mr-2"></i> Back to home page</a>
            </div>
        </div>
    </div>
@endsection
