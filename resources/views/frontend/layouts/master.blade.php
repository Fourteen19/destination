<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  {!! SEOMeta::generate() !!}

  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <base href="">

  <link rel="stylesheet" href="{{mix('/css/app.css')}}">
  <link rel="stylesheet" href="https://use.typekit.net/ruw0ofr.css">
  <script src="https://kit.fontawesome.com/f6b3990673.js" crossorigin="anonymous"></script>
  @livewireStyles
</head>
<body>
@include('frontend.pages.includes.nav')

@if ((!Route::is('frontend.self-assessment.*')) && (!Route::is('frontend.welcome')))
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-xl-10">
@endif
@yield('content')
@if ((!Route::is('frontend.self-assessment.*')) && (!Route::is('frontend.welcome')))
        </div>
    </div>
</div>
@endif
@include('frontend.pages.includes.footer')

{{-- if logged in--}}
@auth
    @if (session()->has('chat_app'))
        @empty(session()->has('chat_app'))
        @else
            @push('scripts')
            {!! session()->get('chat_app') !!}
            @endpush
        @endempty
    @endif
@endauth

@livewireScripts

<!-- compiled JS assets -->
<script src="{{ mix('/js/app.js') }}"></script>
@stack('scripts')

</body>
</html>
