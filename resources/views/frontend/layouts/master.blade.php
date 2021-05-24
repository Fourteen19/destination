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
@include('cookieConsent::index')
@include('frontend.pages.includes.nav')

@if ((!Route::is('frontend.self-assessment.*')) && (!Route::is('frontend.welcome')))
<div class="site-outer-pad">
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-xl-12">
@endif
@yield('content')
@if ((!Route::is('frontend.self-assessment.*')) && (!Route::is('frontend.welcome')))
        </div>
    </div>
</div>
</div>
@endif
@include('frontend.pages.includes.footer')

{{-- if NOT logged in, load the facebook chat app--}}
@guest
    @if (!empty($chatApp))
        @push('scripts')
            {!! $chatApp !!}
        @endpush
    @endif
@endguest

@livewireScripts

<!-- compiled JS assets -->
<script src="{{ mix('/js/app.js') }}"></script>
@stack('scripts')

</body>
</html>
