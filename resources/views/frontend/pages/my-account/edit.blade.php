@extends('frontend.layouts.master')

@section('content')
<div class="row p-w">
    @include('frontend.pages.includes.account-menu')
    <div class="col-lg-9">
        <div class="account-form ml-lg-4 pl-lg-5 def-border">
            <h1 class="t36 fw700 mb-4">Edit my details</h1>
            <p>You can use the form below to update your details.
                Not all of your details can be edited. If any of the information is incorrect then you can
                @if (!empty($institutionAdvisor))
                    @if ($institutionAdvisor->contact_me == 'Y') <a href="{{ route('frontend.my-account.contact-my-adviser') }}">contact your adviser or</a>
                    @endif
                @else
                    contact
                @endif
                your school to request that they are changed.</p>
            <div class="row">
                <div class="col">
                    <div class="border-top def-border w-100 mb-5"></div>
                </div>
            </div>
            institutionAdvisor
            @livewire('frontend.my-account-user-details')

        </div>
    </div>
</div>

@endsection
