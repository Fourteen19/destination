@extends('frontend.layouts.master')

@section('content')
<div class="row p-w">
    @include('frontend.pages.includes.account-menu')
    <div class="col-lg-9">
        <div class="account-form ml-lg-4 pl-lg-5 def-border">
            <h1 class="t36 fw700 mb-4">Meet your adviser</h1>
            <p>Your careers {{ str_plural('adviser', $nbAdvisers ) }} at {{ Auth::guard('web')->user()->institution->name }} @if ($nbAdvisers < 2) is @else are @endif {{ $institutionAdvisors->pluck('title_full_name' )->implode(', ') }}</p>
            <div class="row">
                <div class="col">
                    <div class="border-top def-border w-100 mb-5"></div>
                </div>
            </div>

             @foreach ($meetInstitutionAdvisors as $institutionAdvisordetails)

                <div class="row mb-5">
                    <div class="col-sm-2">
                        <img src="{{parse_encode_url($institutionAdvisordetails->getFirstMediaUrl('photo', 'small')) ?? parse_encode_url("https://via.placeholder.com/300x300.jpg") }}" class="rounded-circle"></div>
                    <div class="col-sm-6">
                        <h2 class="t20 fw700">{{$institutionAdvisordetails->title_full_name}}</h2>
                        @if ($institutionAdvisordetails->relatedInstitutionWithData->first()->pivot->introduction)
                            <p>{{$institutionAdvisordetails->relatedInstitutionWithData->first()->pivot->introduction}}</p>
                        @endif
                        @if ($institutionAdvisordetails->relatedInstitutionWithData->first()->pivot->times_location)
                            <h3 class="t18 fw700">Where to find me</h3>
                            <p>{{$institutionAdvisordetails->relatedInstitutionWithData->first()->pivot->times_location}}</p>
                        @endif
                    </div>
                </div>

            @endforeach

        </div>
    </div>
</div>
@endsection
