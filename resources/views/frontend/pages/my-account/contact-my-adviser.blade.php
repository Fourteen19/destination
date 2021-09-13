@extends('frontend.layouts.master')

@section('content')
<div class="row p-w">
    @include('frontend.pages.includes.account-menu')
    <div class="col-lg-9">
        <div class="account-form ml-lg-4 pl-lg-5 def-border">
            <h1 class="t36 fw700 mb-4">Contact my adviser</h1>
            <p>You can use the form below to contact your adviser or ask them a question.</p>

            <p class="fw700">Your message will be sent to {{ lastAnd($institutionAdvisors->where('contact_me', 'Y')->pluck('title_full_name')->implode(', ')) }}</p>
            <div class="row">
                <div class="col">
                    <div class="border-top def-border w-100 mb-5"></div>
                </div>
            </div>

            @livewire('frontend.my-account-contact-advisor')

        </div>
    </div>
</div>
@endsection
