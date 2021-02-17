@if (count($fixedLinks) > 0)
    <ul class="navbar-nav ml-auto mb-0" id="menu">
        @foreach($fixedLinks as $key => $link)
            <li class="nav-item my-2 my-sm-0"><a class="px-xl-3 td-no" href="{{route('frontend.page', ['page' => $link->slug])}}">{{$link->title}}</a></li>
        @endforeach
    </ul>
@endif
