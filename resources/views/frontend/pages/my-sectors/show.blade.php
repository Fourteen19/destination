@extends('frontend.layouts.master')

@section('content')

<div>

    <div class="row mt-5">
        <div class="col-xl-7 col-lg-6 mb-4 mb-xl-0">
            <div class="pt-4">
                <h1 class="fw700 t30 mb-4">My Sectors</h1>
            </div>
        </div>
    </div>

    @livewire('frontend.my-routes-sectors-subjects', ["tagType" => "sector"] )

@endsection
