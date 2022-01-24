<ul class="navbar-nav ml-auto mb-0" id="menu">
    @if (count($fixedLinks) > 0)
        @foreach($fixedLinks as $key => $link)
            <li class="nav-item my-2 my-sm-0"><a class="px-xl-3 td-no" href="{{route('frontend.page', ['page' => $link->slug])}}">{{$link->title}}</a></li>
        @endforeach
    @endif

    @if (Route::currentRouteName() != 'frontend.login')
        <li class="nav-item my-2 my-sm-0 ml-3"><a class="px-xl-3 td-no py-xl-2 login-public" href="{{ route('frontend.login') }}">Login</a></li>
    @endif
</ul>
