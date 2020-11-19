@extends('frontend.layouts.app')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">{{ __('Welcome Screen') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p>{{ __('You are logged in!') }}</p>

                    <p>Your name is {{ Auth::user()->FullName }}</p>

                    <p>Your institution is: {{ Auth::user()->institution->name }}</p>

                    <p>You need to complete your profile</p>

                    <p><a href="{{ route('frontend.self-assessment.terms.edit') }}">Self Assessment</a></p>

                </div>





            </div>

        </div>
    </div>
</div>
@endsection
