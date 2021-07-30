@extends('frontend.layouts.master')

@section('content')
<div class="row p-w">
    @include('frontend.pages.includes.account-menu')
    <div class="col-lg-9">
        <div class="account-form ml-lg-4 pl-lg-5 def-border">
            <h1 class="t36 fw700 mb-4">Meet my adviser</h1>

            <p>You can use the form below to contact your adviser or ask them a question.</p>
            <div class="row">
                <div class="col">
                    <div class="border-top def-border w-100 mb-5"></div>
                </div>
            </div>


        </div>
    </div>
</div>
@endsection
