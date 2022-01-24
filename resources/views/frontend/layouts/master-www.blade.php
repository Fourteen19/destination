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

  {{-- <link rel="stylesheet" href="{{mix('/css/app.css')}}">
  <link rel="stylesheet" href="https://use.typekit.net/ruw0ofr.css"> --}}

  {{-- font url --}}
  {!! isset(request()->get('clientSettings')['font_url']) ? request()->get('clientSettings')['font_url'] : config('global.client_settings.default_font.url') !!}
  <link rel="stylesheet" href="{{mix('/css/app.css')}}">
  <style>
      :root {
      --bg-1: {{ isset(request()->get('clientSettings')['colour_bg1']) ? request()->get('clientSettings')['colour_bg1'] : config('global.client_settings.default_colours.bg1') }};
      --bg-2: {{ isset(request()->get('clientSettings')['colour_bg2']) ? request()->get('clientSettings')['colour_bg2'] : config('global.client_settings.default_colours.bg2') }};
      --bg-3: {{ isset(request()->get('clientSettings')['colour_bg3']) ? request()->get('clientSettings')['colour_bg3'] : config('global.client_settings.default_colours.bg3') }};

      --t-dark: {{ isset(request()->get('clientSettings')['colour_txt1']) ? request()->get('clientSettings')['colour_txt1'] : config('global.client_settings.default_colours.txt1') }};
      --t-def: {{ isset(request()->get('clientSettings')['colour_txt2']) ? request()->get('clientSettings')['colour_txt2'] : config('global.client_settings.default_colours.txt2') }};
      --t-light: {{ isset(request()->get('clientSettings')['colour_txt3']) ? request()->get('clientSettings')['colour_txt3'] : config('global.client_settings.default_colours.txt3') }};
      --t-alt: {{ isset(request()->get('clientSettings')['colour_txt4']) ? request()->get('clientSettings')['colour_txt4'] : config('global.client_settings.default_colours.txt4') }};

      --link-def: {{ isset(request()->get('clientSettings')['colour_link1']) ? request()->get('clientSettings')['colour_link1'] : config('global.client_settings.default_colours.link1') }};
      --link-hf: {{ isset(request()->get('clientSettings')['colour_link2']) ? request()->get('clientSettings')['colour_link2'] : config('global.client_settings.default_colours.link2') }};

      --but-light-1: {{ isset(request()->get('clientSettings')['colour_button1']) ? request()->get('clientSettings')['colour_button1'] : config('global.client_settings.default_colours.button1') }};
      --but-light-2: {{ isset(request()->get('clientSettings')['colour_button2']) ? request()->get('clientSettings')['colour_button2'] : config('global.client_settings.default_colours.button2') }};
      --but-dark-1: {{ isset(request()->get('clientSettings')['colour_button3']) ? request()->get('clientSettings')['colour_button3'] : config('global.client_settings.default_colours.button3') }};
      --but-dark-2: {{ isset(request()->get('clientSettings')['colour_button4']) ? request()->get('clientSettings')['colour_button4'] : config('global.client_settings.default_colours.button4') }};
      }

      body { {{ isset(request()->get('clientSettings')['font_family']) ? request()->get('clientSettings')['font_family'] : config('global.client_settings.default_font.family') }} }
  </style>

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
