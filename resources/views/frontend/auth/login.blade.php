@extends('frontend.layouts.master')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="p-w">
                <h1 class="t36 fw700">{{ __('Login') }}</h1>
                {!! $intro_txt !!}

                <form method="POST" action="{{ route('frontend.login', ['clientSubdomain' => session('client.subdomain')]) }}">
                        @csrf

                        <div class="row"><div class="col-lg-6 col-sm-8">
                        <div class="form-group">
                            <label for="email" class="col-form-label">{{ __('E-Mail Address') }}</label>

                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                        </div>
                        </div></div>
                        <div class="row"><div class="col-lg-6 col-sm-8">
                        <div class="form-group">
                            <label for="password" class="col-form-label">{{ __('Password') }}</label>

                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                        </div>
                        </div></div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8">
                                <button type="submit" class="platform-button border-0 t-def">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="platform-button border-0 t-def" href="{{ route('frontend.password.request', ['clientSubdomain' => session('client.subdomain')]) }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>

            </div>
        </div>
    </div>

@endsection
