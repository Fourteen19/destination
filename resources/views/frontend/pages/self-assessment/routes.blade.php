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
            
            <div class="row">
                <div class="col-lg-10 offset-lg-1"><div class="border-bottom def-border w-100"></div></div>
            </div>
            <div class="row">
                <div class="col-lg-3 offset-lg-1"><div class="fw700 t18 p-2 d-inline-block mr-2">Apprenticeships</div><a data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample" class="self-help">?</a></div>
                <div class="col-lg-6">
                    <div class="routes-answer"><input type="checkbox" name="Apprenticeships" id="Routes-Apprenticeships" value="Apprenticeships"><label for="Routes-Apprenticeships"></label></div>
                </div>
            </div>
            <div class="row" id="collapseExample">
                <div class="col-lg-10 offset-lg-1">
                <div class="vlg-bg p-2">Working for a company and studying at the same time.</div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-10 offset-lg-1"><div class="border-bottom gg-border w-100"></div></div>
            </div>
            

            <div class="row">
                <div class="col-lg-3 offset-lg-1"><div class="fw700 t18 p-2 d-inline-block mr-2">Employment and self-employment </div><a data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample" class="self-help">?</a></div>
                <div class="col-lg-6">
                    <div class="routes-answer"><input type="checkbox" name="Employment" id="Routes-Employment" value="Employment"><label for="Routes-Employment"></label></div>
                </div>
            </div>
            <div class="row" id="collapseExample">
                <div class="col-lg-10 offset-lg-1">
                <div class="vlg-bg p-2">Working for a company or for yourself.</div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-10 offset-lg-1"><div class="border-bottom gg-border w-100"></div></div>
            </div>
            

            <div class="row">
                <div class="col-lg-3 offset-lg-1"><div class="fw700 t18 p-2 d-inline-block mr-2">Full-time education </div><a data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample" class="self-help">?</a></div>
                <div class="col-lg-6">
                    <div class="routes-answer"><input type="checkbox" name="Full" id="Routes-Full" value="Full"><label for="Routes-Full"></label></div>
                </div>
            </div>
            <div class="row" id="collapseExample">
                <div class="col-lg-10 offset-lg-1">
                <div class="vlg-bg p-2">Studying A levels or vocational courses at a college, sixth form, sixth form college or university technical college.</div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-10 offset-lg-1"><div class="border-bottom gg-border w-100"></div></div>
            </div>


            <div class="row">
                <div class="col-lg-3 offset-lg-1"><div class="fw700 t18 p-2 d-inline-block mr-2">Higher education </div><a data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample" class="self-help">?</a></div>
                <div class="col-lg-6">
                    <div class="routes-answer"><input type="checkbox" name="Higher" id="Routes-Higher" value="Higher"><label for="Routes-Higher"></label></div>
                </div>    
            </div>
            <div class="row" id="collapseExample">
                <div class="col-lg-10 offset-lg-1">
                <div class="vlg-bg p-2">Studying for qualifications, such as a degree, at university or college.</div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-10 offset-lg-1"><div class="border-bottom gg-border w-100"></div></div>
            </div>


            <div class="row">
                <div class="col-lg-3 offset-lg-1"><div class="fw700 t18 p-2 d-inline-block mr-2">Traineeships and training </div><a data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample" class="self-help">?</a></div>
                <div class="col-lg-6">
                    <div class="routes-answer"><input type="checkbox" name="Traineeships" id="Routes-Traineeships" value="Traineeships"><label for="Routes-Traineeships"></label></div>
                </div>    
            </div>
            <div class="row" id="collapseExample">
                <div class="col-lg-10 offset-lg-1">
                <div class="vlg-bg p-2">Studying for the skills you need in a job and getting work experience.</div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-10 offset-lg-1"><div class="border-bottom gg-border w-100"></div></div>
            </div>

            <div class="row">
                <div class="col-lg-3 offset-lg-1"><div class="fw700 t18 p-2 d-inline-block mr-2">Not sure</div></div>
                <div class="col-lg-6">
                    <div class="routes-answer"><input type="checkbox" name="Not sure" id="Routes-Notsure" value="Not sure"><label for="Routes-Notsure"></label></div>
                </div>    
            </div>
            <div class="row">
                <div class="col-lg-10 offset-lg-1"><div class="border-bottom gg-border w-100"></div></div>
            </div>


        </div>
    </div>
</div>
</section>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-10">
            <div class="row r-pad">
                <div class="col-lg-6 offset-1">

    @include('frontend.pages.includes.flash-message')

    {!! Form::model(auth()->user(), ['method' => 'POST','route' => ['frontend.self-assessment.routes.update', auth()->user()->uuid]]) !!}

    
        <div class="form-group{{ $errors->has('tagsRoutes') ? ' has-error' : '' }}">
            {!! Form::label('tagsRoutes', 'Route Tags'); !!}

            @foreach($tagsRoutes as $tagsRoute)
                <label>{!! Form::checkbox('tagsRoutes[]', $tagsRoute->name, ($userRouteTags->where("id", $tagsRoute->id)->where("type", 'route'))->count() == 1 ? true : false, ['class' => 'form-control', 'id' => $tagsRoute->name]) !!} {{$tagsRoute->name}}</label>
            @endforeach

        </div>
   

    <div class="row">
        <button type="submit" name="submit" value="previous" class="platform-button pb-previous mr-3">Previous</button>
        <button type="submit" name="submit" value="next" class="platform-button pb-next">Next</button>
    </div>




{!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
