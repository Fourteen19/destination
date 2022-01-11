<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Cache-Control" content="public" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    {!! SEOMeta::generate() !!}

    <link rel="preconnect" href="https://use.typekit.net/" crossorigin>
    <link rel="dns-prefetch" href="https://use.typekit.net/">
    <link rel="preconnect" href="https://kit.fontawesome.com" crossorigin>
    <link rel="dns-prefetch" href="https://kit.fontawesome.com">


    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <base href="">

    <style>
        :root {
        --bg-1: {{request()->get('clientSettings')['bg1']}};
        --bg-2: {{request()->get('clientSettings')['bg2']}};
        --bg-3: {{request()->get('clientSettings')['bg3']}};

        --t-dark: {{request()->get('clientSettings')['txt1']}};
        --t-def: {{request()->get('clientSettings')['txt2']}};
        --t-light: {{request()->get('clientSettings')['txt3']}};
        --t-alt: {{request()->get('clientSettings')['txt4']}};

        --link-def: {{request()->get('clientSettings')['link1']}};
        --link-hf: {{request()->get('clientSettings')['link2']}};

        --but-light-1: {{request()->get('clientSettings')['button1']}};
        --but-light-2: {{request()->get('clientSettings')['button2']}};
        --but-dark-1: {{request()->get('clientSettings')['button3']}};
        --but-dark-2: {{request()->get('clientSettings')['button4']}};
    }
    </style>

    <link rel="stylesheet" href="{{mix('/css/app.css')}}">
    <link rel="stylesheet" href="https://use.typekit.net/ruw0ofr.css">
    <script src="https://kit.fontawesome.com/f6b3990673.js" crossorigin="anonymous"></script>
    @livewireStyles

    @if (env('APP_ENV') == 'production')
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-207528223-2"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'UA-207528223-2');
        </script>
    @endif

</head>
<body>
@include('cookieConsent::index')
@include('frontend.pages.includes.nav')

@if ((!Route::is('frontend.self-assessment.*')) && (!Route::is('frontend.welcome'))  && (!Route::is('frontend.get-started')))
<div class="site-outer-pad">
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-xl-12">
@endif
@yield('content')
@if ((!Route::is('frontend.self-assessment.*')) && (!Route::is('frontend.welcome'))  && (!Route::is('frontend.get-started')))
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

            <script type="text/javascript">

                setInterval(function () {
                    $.ajax({
                        url: "{{ route('frontend.refresh-csrf') }}",
                        type: 'get',
                        dataType: 'json',
                        success: function (result) {
                        $('meta[name="csrf-token"]').attr('content', result.token);
                        $('input[name="_token"]').val(result.token)
                            $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': result.token
                                }
                            });
                        },
                        error: function (xhr, status, error) {
                        console.log(xhr);
                        }
                    });
                    }, 15 * (60 * 1000)); {{-- 15 * (60 * 1s)  => 15 minutes  --}}

            </script>
        @endpush

    @endif
@endguest


@auth('web')
    @push('scripts')
        <script>
            $(document).ready(function () {
                const timeout = 900000;  {{-- // 900000 ms = 15 minutes --}}
                var idleTimer = null;
                $('*').bind('mousemove click mouseup mousedown keydown keypress keyup submit change mouseenter scroll resize dblclick', function () {
                    clearTimeout(idleTimer);

                    idleTimer = setTimeout(function () {
                        document.getElementById('inactivity').value = 1;
                        document.getElementById('logout-form').submit();
                    }, timeout);
                });
                $("body").trigger("mousemove");
            });
        </script>
    @endpush
@endauth

@livewireScripts

<!-- compiled JS assets -->
<script src="{{ mix('/js/app.js') }}"></script>
@stack('scripts')

</body>
</html>
