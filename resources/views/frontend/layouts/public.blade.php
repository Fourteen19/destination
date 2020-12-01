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
  <link href="{{ asset('/css/ck.css') }}" rel="stylesheet" type="text/css" >


</head>
<body>

@yield('content')


<!-- compiled JS assets -->
<!-- <script src="{{ asset('node_modules/tinymce/tinymce.js') }}"></script> -->
<script src="{{ mix('/js/app.js') }}"></script>
@stack('scripts')



</body>
</html>