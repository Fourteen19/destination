@extends('frontend.layouts.master')

@section('content')

<div class="row justify-content-center">
        <div class="col-md-10">
            <div class="p-w">
                <h1 class="t36 fw700">Forgotten Password</h1>
                <div class="row">
                    <div class="col-md-8">
                        <p>To reset your password, please enter your email address below (please make sure you use the original or school email address linked to your account)</p>
                    </div>
                </div>

                @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif


                <form method="POST" action="{{ route('frontend.password.email') }}">
                        @csrf

                        <div class="row">
                            <div class="col-lg-6 col-sm-8">
                                <div class="form-group">
                                    <label for="email" class="col-form-label">{{ __('Email address') }}</label>


                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror

                                        <div class="mt-3 t14">If you have added an alternative email address this will be cc'd in your password retrieval email.</div>

                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <button type="submit" class="platform-button border-0">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                        </div>
                    </form>

            </div>
        </div>
    </div>



@endsection
