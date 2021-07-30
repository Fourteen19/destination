@extends('frontend.layouts.master')

@section('content')

    @livewire('frontend.vacancies-search-engine')

    <div class="row mt-5">
        <div class="col">
            <div class="border-top def-border pt-3 pl-3">
                <a href="{{ route('frontend.vacancies') }}" class="fw700 td-no">Back to vacancies</a>
            </div>
        </div>
    </div>

@endsection
