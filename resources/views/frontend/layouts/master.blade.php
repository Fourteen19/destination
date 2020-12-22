<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title>{{ config('app.name', 'CMS Name') }}</title>

  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <base href="">

  <link rel="stylesheet" href="{{mix('/css/app.css')}}">
  <link rel="stylesheet" href="https://use.typekit.net/ruw0ofr.css">
  <script src="https://kit.fontawesome.com/f6b3990673.js" crossorigin="anonymous"></script>

</head>
<body>
@include('frontend.pages.includes.nav')

@if ((!Route::is('frontend.self-assessment.*')) && (!Route::is('frontend.welcome')))
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-10">
@endif
@yield('content')
@if ((!Route::is('frontend.self-assessment.*')) && (!Route::is('frontend.welcome')))
        </div>
    </div>
</div>
@endif
@include('frontend.pages.includes.footer')

<!-- compiled JS assets -->
<!-- <script src="{{ asset('node_modules/tinymce/tinymce.js') }}"></script> -->
<script src="{{ mix('/js/app.js') }}"></script>
@stack('scripts')



</body>
</html>