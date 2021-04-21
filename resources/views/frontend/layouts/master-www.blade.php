<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

    @if (env('APP_ENV') == 'local')
        <meta http-equiv="refresh" content="10;url=http://ck.platformbrand.com:8000" />
    @elseif (env('APP_ENV') == 'staging')
        <meta http-equiv="refresh" content="10;url=https://ck.staging-mydirections.co.uk/" />
    @elseif (env('APP_ENV') == 'production')
        <meta http-equiv="refresh" content="10;url=https://ck.mydirections.co.uk/" />
    @endif


  <title>{{ config('app.name', 'MyDirections') }}</title>

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

@yield('content')

@livewireScripts

<!-- compiled JS assets -->
<script src="{{ mix('/js/app.js') }}"></script>
@stack('scripts')

</body>
</html>
