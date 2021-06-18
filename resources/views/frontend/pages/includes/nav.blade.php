<header class="bg-1 site-outer-pad">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-xl-12">
                <div class="row">
                    <div class="col-12">
                        <nav class="navbar navbar-expand-xl">
                        @if (Auth::guard('web')->check())
                            @if ((!Route::is('frontend.self-assessment.*')) && (!Route::is('frontend.welcome')))
                            <a class="navbar-brand my-2 td-no fw700" href="{{ route('frontend.dashboard') }}"><img src="{{ asset('images/md-logo.png') }}" alt="MyDirections Powered by C+K Careers" class="md-logo"></a>
                            @else
                            <a class="navbar-brand my-2 td-no fw700" href="#"><img src="{{ asset('images/md-logo.png') }}" alt="MyDirections Powered by C+K Careers" class="md-logo"></a>
                            @endif
                        @else
                            <a class="navbar-brand my-2 td-no fw700" href="/"><img src="{{ asset('images/md-logo.png') }}" alt="MyDirections Powered by C+K Careers" class="md-logo"></a>
                        @endif

                                <button class="navbar-toggler ml-auto collapsed t-w" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                                <i class="fas fa-bars"></i>
                                </button>
                                <div class="navbar-collapse collapse" id="navbarCollapse">

                                @if (Auth::guard('web')->check())
                                    @if ((!Route::is('frontend.self-assessment.*')) && (!Route::is('frontend.welcome')))

                                        @if (!Route::is('frontend.search'))
                                            @livewire('frontend.search-box-navbar')
                                        @endif

                                        @if (!Route::is('frontend.search'))
                                        <ul class="navbar-nav mb-0" id="menu">
                                        @else
                                        <ul class="navbar-nav mb-0 ml-auto" id="menu">
                                        @endif
                                            <li class="nav-item"><a class="px-lg-3 td-no fw700" href="{{ route('frontend.my-account') }}"><i class="fas fa-user-circle mr-2"></i>My Account</a></li>

                                            <li class="nav-item"><a class="pl-lg-3 td-no fw700" href="{{ route('frontend.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                                            <form id="logout-form" action="{{ route('frontend.logout') }}" method="POST" class="d-none">
                                                @csrf
                                                <input type="hidden" id="inactivity" name="inactivity" value="0">
                                            </form></li>
                                        </ul>
                                    @else
                                        <ul class="navbar-nav mb-0 ml-auto" id="menu">
                                            <li class="nav-item"><a class="px-lg-3 td-no fw700" href="{{ route('frontend.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                                            <form id="logout-form" action="{{ route('frontend.logout') }}" method="POST" class="d-none">
                                                @csrf
                                                <input type="hidden" id="inactivity" name="inactivity" value="0">
                                            </form></li>
                                        </ul>
                                    @endif
                                @else
                                    @include('frontend.pages.includes.header-fixed-links')
                                @endif
                                </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
