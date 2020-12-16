@extends('frontend.layouts.self')

@section('content')
<section class="p-w">
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-10">
            <div class="row r-pad">
                <div class="col-lg-6 offset-1">
                    <h1 class="t36 fw700">Getting to know you: <span class="t-alt">Your future path</span></h1>
                    <p>Next were going to look at the route you are going take, from where you are now to your career in the future.</p>

                </div>
                <div class="col-lg-3 offset-1">
                    <div class="self-progress-bar w-100">
                    <svg id="Progress" xmlns="http://www.w3.org/2000/svg" width="100%" height="auto" viewBox="0 0 743.37 61.43">
                    <path class="p-bar" d="M2541.33,1388.99h691.5v14.7h-691.5v-14.7Z" transform="translate(-2507.69 -1364.88)"/>
                    <circle class="p-circ p-comp" cx="30.715" cy="30.715" r="25.715"/>
                    <circle class="p-circ p-comp" cx="257.78" cy="30.715" r="25.72"/>
                    <circle class="p-circ p-comp" cx="485.59" cy="30.715" r="25.72"/>
                    <circle class="p-circ" cx="712.65" cy="30.715" r="25.72"/>
                    </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row justify-content-center">
        <div class="col-10">
            <div class="row r-pad">
                <div class="col-lg-8 offset-1">
                    <p class="t24 fw700">Tick as many options as you are interested in or just the one you know that applies to you.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-10">
            <div class="row r-pad">
                <div class="col-lg-8 offset-1">
                    @include('admin.pages.includes.flash-message')
                </div>
            </div>
        </div>
    </div>

    {!! Form::open(array('url' => route('frontend.self-assessment.routes.update'), 'method' => 'PUT')) !!}

    <div class="row justify-content-center">
        <div class="col-10">

            <div class="row">
                <div class="col-lg-10 offset-lg-1"><div class="border-bottom def-border w-100"></div></div>
            </div>

            @foreach($routes as $route)

                <div class="row">
                    <div class="col-lg-3 offset-lg-1"><div class="fw700 t18 p-2 d-inline-block mr-2">{{$route->name}}</div><a data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample" class="self-help">?</a></div>
                    <div class="col-lg-6">
                        <div class="routes-answer">{!! Form::checkbox('routes['.$route->name.']', $route->name, ($userRouteTags->where("id", $route->id)->where("type", 'route'))->count() == 1 ? true : false, ['id' => $route->name]) !!}<label for="{{$route->name}}"></label></div>
                    </div>
                </div>
                <div class="row" id="collapseExample">
                    <div class="col-lg-10 offset-lg-1">
                    <div class="vlg-bg p-2">{{$route->text}}</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-10 offset-lg-1"><div class="border-bottom gg-border w-100"></div></div>
                </div>

            @endforeach



            <div class="row justify-content-center">
                <div class="col-10">
                    <div class="row r-pad">
                        <div class="col-lg-6 offset-1">
                            <div class="row">
                            {!! Form::submit('Previous', ["name" => "submit", "value" => "previous", "class" => "platform-button pb-previous mr-3"]) !!}
                            {!! Form::submit('Next', ["name" => "submit", "value" => "next", "class" => "platform-button pb-next"]) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {!! Form::close() !!}

</div>
</section>

@endsection
