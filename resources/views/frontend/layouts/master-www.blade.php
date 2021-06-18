<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Cache-Control" content="public" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    {!! SEOMeta::generate() !!}

  {!! SEOMeta::generate() !!}

    @if (env('APP_ENV') == 'local')
        <meta http-equiv="refresh" content="10;url=http://ck.platformbrand.com:8000" />
    @elseif (env('APP_ENV') == 'staging')
        <meta http-equiv="refresh" content="10;url=https://ck.staging-mydirections.co.uk/" />
    @elseif (env('APP_ENV') == 'production')
        <meta http-equiv="refresh" content="10;url=https://ck.mydirections.co.uk/" />
    @endif

    <title>{{ config('app.name', 'MyDirections') }}</title>

    <link rel="preconnect" href="https://use.typekit.net/" crossorigin>
	<link rel="dns-prefetch" href="https://use.typekit.net/">
	<link rel="preconnect" href="https://kit.fontawesome.com" crossorigin>
	<link rel="dns-prefetch" href="https://kit.fontawesome.com">


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
@yield('content')

@livewireScripts

{{-- if NOT logged in--}}
@guest
    @if (session()->has('chat_app'))
        @empty(session()->has('chat_app'))
        @else
            @push('scripts')
            {!! session()->get('chat_app') !!}
            @endpush
        @endempty
    @endif
@endauth

<!-- compiled JS assets -->
<script src="{{ mix('/js/app.js') }}"></script>
@stack('scripts')

</body>
</html>
