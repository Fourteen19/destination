@if (count($fixedLinks) > 0)
    <div class="col-lg-2 mb-4 mb-lg-0 col-sm-6">
        <ul class="list-unstyled t-up t14">
            @foreach($fixedLinks as $key => $link)
            <li class="mb-2"><a class="t-w" href="{{route('frontend.page', ['page' => $link->slug])}}">{{$link->title}}</a></li>
            @endforeach
        </ul>
    </div>
@endif
