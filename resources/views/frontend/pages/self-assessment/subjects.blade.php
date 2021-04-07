@extends('frontend.layouts.master')

@section('content')

@include('frontend.pages.includes.flash-message')

<section class="p-w xl-p">
<div class="container-fluid">
    <div class="row justify-content-center">
    <div class="col-xl-12">
            <div class="row justify-content-sm-end justify-content-lg-start r-pad">
                <div class="col-lg-7 offset-lg-1 order-2 order-lg-1">
                    <h1 class="t36 fw700">Getting to know you: <span class="t-alt">Subjects</span></h1>
                    {!! $data['subjects_intro'] !!}
                </div>
                <div class="col-sm-6 col-lg-3 order-1 mb-5 mb-lg-0 order-lg-2">
                    <div class="self-progress-bar w-100">
                    <svg id="Progress" xmlns="http://www.w3.org/2000/svg" width="100%" height="auto" viewBox="0 0 743.37 61.43">
                    <path class="p-bar" d="M2541.33,1388.99h691.5v14.7h-691.5v-14.7Z" transform="translate(-2507.69 -1364.88)"/>
                    <circle class="p-circ p-comp" cx="30.715" cy="30.715" r="25.715"/>
                    <circle class="p-circ p-comp" cx="257.78" cy="30.715" r="25.72"/>
                    <circle class="p-circ" cx="485.59" cy="30.715" r="25.72"/>
                    <circle class="p-circ" cx="712.65" cy="30.715" r="25.72"/>
                    </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-xl-12">
            <div class="row r-pad">
                <div class="col-lg-8 offset-lg-1">
                    <p class="t24 fw700">Rate each subject using the scale provided. If you don’t currently study that subject then simply mark it as not applicable.</p>
                </div>
            </div>
        </div>
    </div>


    {!! Form::open(array('url' => route('frontend.self-assessment.subjects.update'), 'method' => 'PUT')) !!}
    <div id="subjects-parent">
        <div class="row justify-content-center">
            <div class="col-xl-12">
                <div class="row d-none d-lg-flex sticky-top w-bg">
                    <div class="col-lg-2 offset-lg-1"></div>
                    <div class="col-lg-2 d-flex"><div class="subjects-header mlg-bg text-center fw700">Like it / Enjoy it /<br>I’m good at it</div></div>
                    <div class="col-lg-2 d-flex"><div class="subjects-header vlg-bg text-center fw700">I don’t mind it /<br>50/50 / It’s ok</div></div>
                    <div class="col-lg-2 d-flex"><div class="subjects-header mlg-bg text-center fw700">It’s not for me</div></div>
                    <div class="col-lg-2 d-flex"><div class="subjects-header vlg-bg text-center fw700">Not applicable /<br>I don’t study that</div></div>
                </div>
                <div class="row d-none d-md-flex">
                    <div class="col-lg-10 offset-lg-1"><div class="border-bottom def-border w-100"></div></div>
                </div>
                @foreach($tagsSubjects as $key => $item)
                    <div class="row mt-3 mt-lg-0">
                        <div class="col-lg-2 offset-lg-1">
                            <div class="fw700 t18 py-2">{{ $item->name }}
                                @if (!empty($item->text))
                                    <a data-toggle="collapse" data-target="#collapse-{{$item->slug}}" href="#collapse-{{$item->slug}}" role="button" aria-expanded="false" aria-controls="collapse-{{$item->slug}}" class="self-help">?</a>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-2 d-flex"><div class="subjects-answer mlg-bg text-md-center d-flex justify-content-lg-center align-items-center p-2 p-lg-0">{!! Form::radio("subjects[$item->name]", 'I like it', (isset($userSubjectTags[$item->id])) ? ( ($userSubjectTags[$item->id] == 1) ? true : false) : false, ['id' => "subjects[$item->name]['I like it']"]) !!}<label for="subjects[{{ $item->name }}]['I like it']"></label><label class="mb-label ml-2 d-inline d-lg-none" for="subjects[{{ $item->name }}]['I like it']">Like it / Enjoy it / I’m good at it</label></div></div>
                        <div class="col-lg-2 d-flex"><div class="subjects-answer vlg-bg text-md-center d-flex justify-content-lg-center align-items-center p-2 p-lg-0">{!! Form::radio("subjects[$item->name]", 'I dont mind it', (isset($userSubjectTags[$item->id])) ? ( ($userSubjectTags[$item->id] == 2) ? true : false) : false, ['id' => "subjects[$item->name]['I dont mind it']"]) !!}<label for="subjects[{{ $item->name }}]['I dont mind it']"></label><label class="mb-label ml-2 d-inline d-lg-none" for="subjects[{{ $item->name }}]['I dont mind it']">I don’t mind it / 50/50 / It’s ok</label></div></div>
                        <div class="col-lg-2 d-flex"><div class="subjects-answer mlg-bg text-md-center d-flex justify-content-lg-center align-items-center p-2 p-lg-0">{!! Form::radio("subjects[$item->name]", 'Not for me', (isset($userSubjectTags[$item->id])) ? ( ($userSubjectTags[$item->id] == 3) ? true : false) : false, ['id' => "subjects[$item->name]['Not for me']"]) !!}<label for="subjects[{{ $item->name }}]['Not for me']"></label><label class="mb-label ml-2 d-inline d-lg-none" for="subjects[{{ $item->name }}]['Not for me']">It’s not for me</label></div></div>
                        <div class="col-lg-2 d-flex"><div class="subjects-answer vlg-bg text-md-center d-flex justify-content-lg-center align-items-center p-2 p-lg-0">{!! Form::radio("subjects[$item->name]", 'Not applicable', (isset($userSubjectTags[$item->id])) ? ( ($userSubjectTags[$item->id] == 4) ? true : false) : false, ['id' => "subjects[$item->name]['Not applicable']"]) !!}<label for="subjects[{{ $item->name }}]['Not applicable']"></label><label class="mb-label ml-2 d-inline d-lg-none" for="subjects[{{ $item->name }}]['Not applicable']">Not applicable / I don’t study that</label></div></div>
                    </div>
                    <div class="row collapse" data-parent="#subjects-parent" id="collapse-{{$item->slug}}">
                        <div class="col-lg-10 offset-lg-1">
                        <div class="vlg-bg p-2">{{$item->text}}</div>
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
                <div class="col-xl-12">
                    <div class="row r-pad">
                        <div class="col-lg-6 offset-lg-1">

                            {!! Form::submit('Previous', ["name" => "submit", "value" => "previous", "class" => "platform-button pb-previous mr-3"]) !!}
                            {!! Form::submit('Next', ["name" => "submit", "value" => "next", "class" => "platform-button pb-next"]) !!}

                        </div>
                    </div>
                </div>
            </div>




    {!! Form::close() !!}

</div>
</section>

@endsection
