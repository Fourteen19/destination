@extends('frontend.layouts.master')

@section('content')

@include('frontend.pages.includes.flash-message')

<section class="p-w">
<div class="container-fluid">
    <div class="row justify-content-center">
    <div class="col-xl-10">
            <div class="row justify-content-sm-end justify-content-lg-start r-pad">
                <div class="col-lg-7 offset-lg-1 order-2 order-lg-1">
                    <h1 class="t36 fw700">Getting to know you: <span class="t-alt">Sectors</span></h1>
                    {!! $data['sectors_intro'] !!}
                </div>
                <div class="col-sm-6 col-lg-3 order-1 mb-5 mb-lg-0 order-lg-2">
                    <div class="self-progress-bar w-100">
                    <svg id="Progress" xmlns="http://www.w3.org/2000/svg" width="100%" height="auto" viewBox="0 0 743.37 61.43">
                    <path class="p-bar" d="M2541.33,1388.99h691.5v14.7h-691.5v-14.7Z" transform="translate(-2507.69 -1364.88)"/>
                    <circle class="p-circ p-comp" cx="30.715" cy="30.715" r="25.715"/>
                    <circle class="p-circ p-comp" cx="257.78" cy="30.715" r="25.72"/>
                    <circle class="p-circ p-comp" cx="485.59" cy="30.715" r="25.72"/>
                    <circle class="p-circ p-comp" cx="712.65" cy="30.715" r="25.72"/>
                    </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row justify-content-center">
        <div class="col-xl-10">
            <div class="row r-pad">
                <div class="col-lg-8 offset-lg-1">
                    <p class="t24 fw700">Tick as many options as you are interested in or just the one you know that applies to you.</p>
                </div>
            </div>
        </div>
    </div>

    {!! Form::open(array('url' => route('frontend.self-assessment.sectors.update'), 'method' => 'PUT')) !!}

    <div class="row justify-content-center">
        <div class="col-xl-10">

            <div class="row">
                <div class="col-lg-10 offset-lg-1"><div class="border-bottom def-border w-100"></div></div>
            </div>

            <div id="sectors-parent">
            @foreach($sectors as $sector)

                <div class="row">
                    <div class="col-lg-5 offset-lg-1 col-md-6 col-10 pr-0 pr-lg-3 py-2 py-md-0"><div class="fw700 t18 p-md-2 d-inline d-md-inline-block mr-2">{{$sector->name}}</div><a data-toggle="collapse" data-target="#collapse-{{$sector->slug}}" href="#collapse-{{$sector->slug}}" role="button" aria-expanded="false" aria-controls="collapse-{{$sector->slug}}" class="self-help">?</a></div>
                    <div class="col-lg-5 col-2">
                        <div class="routes-answer">{!! Form::checkbox('sectors[]', $sector->name, ($userSectorTags->where("id", $sector->id)->where("type", 'sector'))->count() == 1 ? true : false, ['id' => $sector->name]) !!}<label for="{{$sector->name}}"></label></div>
                    </div>
                </div>
                <div class="row collapse" data-parent="#sectors-parent" id="collapse-{{$sector->slug}}">
                    <div class="col-lg-10 offset-lg-1">
                    <div class="vlg-bg p-2">{{$sector->text}}</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-10 offset-lg-1"><div class="border-bottom gg-border w-100"></div></div>
                </div>

            @endforeach
            </div>
        </div>
    </div>

    <div class="row justify-content-center mt-4">
                <div class="col-xl-10">
                    <div class="row r-pad">
                        <div class="col-lg-6 offset-lg-1">

                    {!! Form::submit('Previous', ["name" => "submit", "value" => "previous", "class" => "platform-button pb-previous mr-3"]) !!}
                    {!! Form::submit('Next', ["name" => "submit", "value" => "next", "class" => "platform-button pb-next"]) !!}

                </div>
            </div>
        </div>
    </div>


</div>
</section>

@endsection
