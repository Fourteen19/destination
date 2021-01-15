<header class="bg-1">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-xl-10">
                <div class="row">
                    <div class="col-12">
                        <nav class="navbar navbar-expand-xl">                      
                        @if (Auth::guard('web')->check())
                            @if ((!Route::is('frontend.self-assessment.*')) && (!Route::is('frontend.welcome')))
                            <a class="navbar-brand my-2 td-no fw700" href="{{ route('frontend.dashboard') }}">MyDirections</a>
                            @else
                            <a class="navbar-brand my-2 td-no fw700" href="#">MyDirections</a>
                            @endif
                        @else
                        <a class="navbar-brand my-2 td-no fw700" href="/">MyDirections</a>
                        @endif
                                
                                <button class="navbar-toggler ml-auto collapsed t-w" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                                <i class="fas fa-bars"></i>
                                </button>
                                <div class="navbar-collapse collapse" id="navbarCollapse">

                                @if (Auth::guard('web')->check())
                                    @if ((!Route::is('frontend.self-assessment.*')) && (!Route::is('frontend.welcome')))
                                    <form class="form-inline mt-2 mt-md-0 ml-auto pr-3 border-right w-border">
                                        <label class="t15 fw700 mr-3 t-w">Find an article:</label>
                                        <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
                                        <button class="search-btn t-def rounded-circle my-2 my-sm-0" type="submit"><i class="fas fa-search  fa-lg"></i></button>
                                    </form>
                                    <ul class="navbar-nav mb-0" id="menu">
                                        <li class="nav-item"><a class="px-lg-3 td-no fw700" href="{{ route('frontend.my-account.edit') }}"><i class="fas fa-user-circle mr-2"></i>My Account</a></li>

                                        <li class="nav-item"><a class="px-lg-3 td-no fw700" href="{{ route('frontend.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                                        <form id="logout-form" action="{{ route('frontend.logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form></li>
                                    </ul>
                                    @else
                                    <ul class="navbar-nav mb-0 ml-auto" id="menu">
                                        <li class="nav-item"><a class="px-lg-3 td-no fw700" href="{{ route('frontend.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                                        <form id="logout-form" action="{{ route('frontend.logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form></li>
                                    </ul>
                                    @endif 
                                @else
                                <ul class="navbar-nav ml-auto mb-0" id="menu">
                                    <li class="nav-item my-2 my-sm-0"><a class="px-xl-3 td-no" href="/temp-info">Fixed link 1</a></li>
                                    <li class="nav-item my-2 my-sm-0"><a class="px-xl-3 td-no" href="/temp-info">Fixed link</a></li>
                                    <li class="nav-item my-2 my-sm-0"><a class="px-xl-3 td-no" href="/temp-info">Fixed link</a></li>
                                </ul>
                                @endif
                                </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>