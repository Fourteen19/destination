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

  <base href="/admin/">

  <link rel="stylesheet" href="{{mix('/admin/css/app.css')}}">
  <!--<link href="public/admin/css/rfadmin.css" rel="stylesheet" type="text/css" >-->

  @stack('styles')

  @livewireStyles()

</head>
<body class="hold-transition sidebar-mini sidebar-collapse">

<div id="app" class="wrapper layout-fixed">

@if (Auth::guard('admin')->check())
<div id="loading" class="loader"><div class="vh-100 d-flex align-items-center justify-content-center"><div><img src="{{ asset('admin/images/loader.svg') }}" alt="Loading" title="Loading"></div></div></div>
@endif

@include('admin.pages.includes.admin-nav')
@include('admin.pages.includes.sidebar-menu')

  <div class="content-wrapper">
  <section class="content">
      @yield('content')
  </section>
  </div>

  <footer class="main-footer"></footer>

</div>



@livewireScripts()

<!-- compiled JS assets -->
<script src="{{ asset('node_modules/tinymce/tinymce.js') }}"></script>
<script src="{{ mix('/admin/js/app.js') }}"></script>
<script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
<script src="//cdn.datatables.net/plug-ins/1.10.21/api/fnFilterOnReturn.js"></script>

@if (Auth::guard('admin')->check())
    @push('scripts')
        <script>
        $(document).ready(function(){

            {{-- hides overlay, when the page has loaded. Used for livewire pages --}}
            document.getElementById("loading").style.display = "none";
        });
        </script>
    @endpush
@endif

@stack('scripts')


</body>
</html>
