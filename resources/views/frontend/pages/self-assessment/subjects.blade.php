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
            <div class="row r-pad">
                <div class="col-lg-8 offset-1">
                    @include('admin.pages.includes.flash-message')
                </div>
            </div>
        </div>
    </div>

    {!! Form::open(array('url' => route('frontend.self-assessment.subjects.update'), 'method' => 'PUT')) !!}

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
            @foreach($tagsSubjects as $key => $item)
                <div class="row">
                    <div class="col-lg-2 offset-lg-1"><div class="fw700 t18 py-2">{{ $item->name }}</div></div>
                    <div class="col-lg-2 d-flex"><div class="subjects-answer mlg-bg text-center d-flex justify-content-center align-items-center">{!! Form::radio("subjects[$item->name]", 'I like it', null, ['id' => "subjects[$item->name]['I like it']"]) !!}<label for="subjects[{{ $item->name }}]['I like it']"></label></div></div>
                    <div class="col-lg-2 d-flex"><div class="subjects-answer mlg-bg text-center d-flex justify-content-center align-items-center">{!! Form::radio("subjects[$item->name]", 'I dont mind it', null, ['id' => "subjects[$item->name]['I dont mind it']"]) !!}<label for="subjects[{{ $item->name }}]['I dont mind it']"></label></div></div>
                    <div class="col-lg-2 d-flex"><div class="subjects-answer mlg-bg text-center d-flex justify-content-center align-items-center">{!! Form::radio("subjects[$item->name]", 'Not for me', null, ['id' => "subjects[$item->name]['Not for me']"]) !!}<label for="subjects[{{ $item->name }}]['Not for me']"></label></div></div>
                    <div class="col-lg-2 d-flex"><div class="subjects-answer mlg-bg text-center d-flex justify-content-center align-items-center">{!! Form::radio("subjects[$item->name]", 'Not applicable', null, ['id' => "subjects[$item->name]['Not applicable']"]) !!}<label for="subjects[{{ $item->name }}]['Not applicable']"></label></div></div>
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
