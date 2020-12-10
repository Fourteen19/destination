@extends('frontend.layouts.self')

@section('content')
<section class="p-w">
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-10">
            <div class="row r-pad">
                <div class="col-lg-6 offset-1">
                    <h1 class="t36 fw700">Getting to know you: <span class="t-alt">Subjects</span></h1>
                    <p>Next we-re going to look at the subjects that you enjoy and are good at, compared to those that you are less interested in or don’t want to study in the future.</p>

                </div>
                <div class="col-lg-3 offset-1">
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
        <div class="col-10">
            <div class="row r-pad">
                <div class="col-lg-8 offset-1">
                    <p class="t24 fw700">Rate each subject using the scale provided. If you don’t currently study that subject then simply mark it as not applicable.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-10">
            <div class="row">
                <div class="col-lg-2 offset-lg-1"></div>
                <div class="col-lg-2 d-flex"><div class="subjects-header mlg-bg text-center fw700">Like it / Enjoy it /<br>I’m good at it</div></div>
                <div class="col-lg-2 d-flex"><div class="subjects-header vlg-bg text-center fw700">I don’t mind it /<br>50/50 / It’s ok</div></div>
                <div class="col-lg-2 d-flex"><div class="subjects-header mlg-bg text-center fw700">It’s not for me</div></div>
                <div class="col-lg-2 d-flex"><div class="subjects-header vlg-bg text-center fw700">Not applicable /<br>I don’t study that</div></div>
            </div>
            <div class="row">
                <div class="col-lg-10 offset-lg-1"><div class="border-bottom def-border w-100"></div></div>
            </div>
            <div class="row">
                <div class="col-lg-2 offset-lg-1"><div class="fw700 t18 py-2">Subject name A</div></div>
                <div class="col-lg-2 d-flex"><div class="subjects-answer mlg-bg text-center d-flex justify-content-center align-items-center"><input type="radio" name="Subject name A" id="inlineRadio1" value="option1"><label for="inlineRadio1"></label></div></div>
                <div class="col-lg-2 d-flex"><div class="subjects-answer vlg-bg text-center d-flex justify-content-center align-items-center"><input type="radio" name="Subject name A" id="inlineRadio2" value="option2"><label for="inlineRadio2"></label></div></div>
                <div class="col-lg-2 d-flex"><div class="subjects-answer mlg-bg text-center d-flex justify-content-center align-items-center"><input type="radio" name="Subject name A" id="inlineRadio3" value="option3"><label for="inlineRadio3"></label></div></div>
                <div class="col-lg-2 d-flex"><div class="subjects-answer vlg-bg text-center d-flex justify-content-center align-items-center"><input type="radio" name="Subject name A" id="inlineRadio4" value="option4"><label for="inlineRadio4"></label></div></div>
            </div>
            <div class="row">
                <div class="col-lg-10 offset-lg-1"><div class="border-bottom gg-border w-100"></div></div>
            </div>
            <div class="row">
                <div class="col-lg-2 offset-lg-1 py-2"><div class="fw700 t18">Subject name B</div></div>
                <div class="col-lg-2 d-flex"><div class="subjects-answer mlg-bg text-center d-flex justify-content-center align-items-center"><input type="radio" name="Subject name B" id="inlineRadio5" value="option1"><label for="inlineRadio5"></label></div></div>
                <div class="col-lg-2 d-flex"><div class="subjects-answer vlg-bg text-center d-flex justify-content-center align-items-center"><input type="radio" name="Subject name B" id="inlineRadio6" value="option2"><label for="inlineRadio6"></label></div></div>
                <div class="col-lg-2 d-flex"><div class="subjects-answer mlg-bg text-center d-flex justify-content-center align-items-center"><input type="radio" name="Subject name B" id="inlineRadio7" value="option3"><label for="inlineRadio7"></label></div></div>
                <div class="col-lg-2 d-flex"><div class="subjects-answer vlg-bg text-center d-flex justify-content-center align-items-center"><input type="radio" name="Subject name B" id="inlineRadio8" value="option4"><label for="inlineRadio8"></label></div></div>
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

{!! Form::model(auth()->user(), ['method' => 'POST','route' => ['frontend.self-assessment.subjects.update', auth()->user()->uuid]]) !!}

    
        <div class="form-group{{ $errors->has('tagsSubjects') ? ' has-error' : '' }}">
            {!! Form::label('tagsSubjects', 'Subject Tags'); !!}<br>

            @foreach($tagsSubjects as $tagsSubject)
                <label>{!! Form::checkbox('tagsSubjects[]', $tagsSubject->name, ($userSubjectTags->where("id", $tagsSubject->id)->where("type", 'subject'))->count() == 1 ? true : false, ['class' => 'form-control', 'id' => $tagsSubject->name]) !!} {{$tagsSubject->name}}</label><br>
            @endforeach

        </div>
    
        <div class="row">
        <button type="submit" name="submit" value="previous" class="platform-button pb-previous mr-3">Previous</button>
        <button type="submit" name="submit" value="next" class="platform-button pb-next">Next</button>
        </div>


{!! Form::close() !!}
{{--

@livewire('frontend.self-assessment-subjects', [])

--}}

                </div>
            </div>
        </div>
    </div>
</div>


    

@endsection
