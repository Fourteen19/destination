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
  <link rel="stylesheet" href="https://use.typekit.net/ruw0ofr.css">
  <script src="https://kit.fontawesome.com/f6b3990673.js" crossorigin="anonymous"></script>

</head>
<body>
<header class="lg-bg">
    <div class="container-fluid">
        <div class="row justify-content-center no-gutters">
            <div class="col-10">
                <div class="row no-gutters">
                    <div class="col-12">
                        <nav class="navbar navbar-expand-xl">
                                <span class="navbar-brand my-2 td-no fw700">MyDirections</span>
                                <button class="navbar-toggler ml-auto collapsed" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                                =
                                </button>
                                <div class="navbar-collapse collapse" id="navbarCollapse">
                                <ul class="navbar-nav mb-0 ml-auto" id="menu">
                                    

                                    <li class="nav-item"><a class="px-lg-3 td-no fw700" href="{{ route('frontend.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                                    <form id="logout-form" action="{{ route('frontend.logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form></li>
                                </ul>
                                </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

@yield('content')
        
@include('frontend.pages.includes.publicfooter')

<!-- compiled JS assets -->
<!-- <script src="{{ asset('node_modules/tinymce/tinymce.js') }}"></script> -->
<script src="{{ mix('/js/app.js') }}"></script>
@stack('scripts')



</body>
</html>