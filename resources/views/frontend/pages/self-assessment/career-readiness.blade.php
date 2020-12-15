@extends('frontend.layouts.self')

@section('content')
<section class="p-w">
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-10">
            <div class="row r-pad">
                <div class="col-lg-7 offset-1">
                    <h1 class="t36 fw700">Getting to know you: <span class="t-alt">Thinking about your career</span></h1>
                    <p>To make sure we give you the right level of support and the sort of content that will help you make good decisions in the future, we’d like to know a bit more about what stage you are at when thinking about your career.</p>

                </div>
                <div class="col-lg-3">
                    <div class="self-progress-bar w-100">
                    <svg id="Progress" xmlns="http://www.w3.org/2000/svg" width="100%" height="auto" viewBox="0 0 743.37 61.43">
                    <path class="p-bar" d="M2541.33,1388.99h691.5v14.7h-691.5v-14.7Z" transform="translate(-2507.69 -1364.88)"/>
                    <circle class="p-circ p-comp" cx="30.715" cy="30.715" r="25.715"/>
                    <circle class="p-circ" cx="257.78" cy="30.715" r="25.72"/>
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
                    <p class="t24 fw700">Read each statement and then set where you are on the scale of answers - remember there are no wrong answers.</p>
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


    {!! Form::open(array('url' => route('frontend.self-assessment.career-readiness.update'), 'method' => 'PUT')) !!}

    <div class="row justify-content-center">
        <div class="col-10">
            <div class="row r-pad">
                <div class="col-lg-10 offset-1">
                    <div class="mb-5">
                        <div class="car-question t-w">
                            <div class="row no-gutters">
                                <div class="col-lg-1 gg-bg p-3 text-center fw700 t24 q-number">1.</div>
                                <div class="{{ $errors->has('cas-1') ? ' has-error' : '' }} col-lg-11 def-bg p-3 t24 fw700 q-text">I feel confident about my future</div>
                            </div>
                        </div>
                        <div class="car-answer">
                            <div class="row justify-content-between no-gutters">
                                <div class="col-lg-2">
                                <div class="cas-answer d-flex align-items-center">{!! Form::radio('cas-1', 'Strongly agree', ($selfAssessment->career_readiness_score_1 == 5) ? true : false, ['id' => 'cas-1-1']) !!}<label for="cas-1-1"><span class="fw700">Strongly agree</span></label></div>
                                </div>
                                <div class="col-lg-2">
                                <div class="cas-answer d-flex align-items-center">{!! Form::radio('cas-1', 'Agree', ($selfAssessment->career_readiness_score_1 == 4) ? true : false, ['id' => 'cas-1-2']) !!}<label for="cas-1-2"><span class="fw700">Agree</span></label></div>
                                </div>
                                <div class="col-lg-3">
                                <div class="cas-answer d-flex align-items-center">{!! Form::radio('cas-1', 'Neither agree or disagree', ($selfAssessment->career_readiness_score_1 == 3) ? true : false, ['id' => 'cas-1-3']) !!}<label for="cas-1-3"><span class="fw700">Neither agree or disagree</span></label></div>
                                </div>
                                <div class="col-lg-2">
                                <div class="cas-answer d-flex align-items-center">{!! Form::radio('cas-1', 'Disagree', ($selfAssessment->career_readiness_score_1 == 2) ? true : false, ['id' => 'cas-1-4']) !!}<label for="cas-1-4"><span class="fw700">Disagree</span></label></div>
                                </div>
                                <div class="col-lg-2">
                                <div class="cas-answer d-flex align-items-center">{!! Form::radio('cas-1', 'Strongly disagree', ($selfAssessment->career_readiness_score_1 == 1) ? true : false, ['id' => 'cas-1-5']) !!}<label for="cas-1-5"><span class="fw700">Strongly disagree</span></label></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-5">
                        <div class="car-question t-w">
                            <div class="row no-gutters">
                                <div class="col-lg-1 gg-bg p-3 text-center fw700 t24 q-number">2.</div>
                                <div class="{{ $errors->has('cas-2') ? ' has-error' : '' }} col-lg-11 def-bg p-3 t24 fw700 q-text">I understand the all the different career options and choices</div>
                            </div>
                        </div>
                        <div class="car-answer">
                            <div class="row justify-content-between no-gutters">
                                <div class="col-lg-2">
                                <div class="cas-answer d-flex align-items-center">{!! Form::radio('cas-2', 'Strongly agree', ($selfAssessment->career_readiness_score_2 == 5) ? true : false, ['id' => 'cas-2-1']) !!}<label for="cas-2-1"><span class="fw700">Strongly agree</span></label></div>
                                </div>
                                <div class="col-lg-2">
                                <div class="cas-answer d-flex align-items-center">{!! Form::radio('cas-2', 'Agree', ($selfAssessment->career_readiness_score_2 == 4) ? true : false, ['id' => 'cas-2-2']) !!}<label for="cas-2-2"><span class="fw700">Agree</span></label></div>
                                </div>
                                <div class="col-lg-3">
                                <div class="cas-answer d-flex align-items-center">{!! Form::radio('cas-2', 'Neither agree or disagree', ($selfAssessment->career_readiness_score_2 == 3) ? true : false, ['id' => 'cas-2-3']) !!}<label for="cas-2-3"><span class="fw700">Neither agree or disagree</span></label></div>
                                </div>
                                <div class="col-lg-2">
                                <div class="cas-answer d-flex align-items-center">{!! Form::radio('cas-2', 'Disagree', ($selfAssessment->career_readiness_score_2 == 2) ? true : false, ['id' => 'cas-2-4']) !!}<label for="cas-2-4"><span class="fw700">Disagree</span></label></div>
                                </div>
                                <div class="col-lg-2">
                                <div class="cas-answer d-flex align-items-center">{!! Form::radio('cas-2', 'Strongly disagree', ($selfAssessment->career_readiness_score_2 == 1) ? true : false, ['id' => 'cas-2-5']) !!}<label for="cas-2-5"><span class="fw700">Strongly disagree</span></label></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-5">
                        <div class="car-question t-w">
                            <div class="row no-gutters">
                                <div class="col-lg-1 gg-bg p-3 text-center fw700 t24 q-number">3.</div>
                                <div class="{{ $errors->has('cas-3') ? ' has-error' : '' }} col-lg-11 def-bg p-3 t24 fw700 q-text">I make good decisions and choices</div>
                            </div>
                        </div>
                        <div class="car-answer">
                            <div class="row justify-content-between no-gutters">
                                <div class="col-lg-2">
                                <div class="cas-answer d-flex align-items-center">{!! Form::radio('cas-3', 'Strongly agree', ($selfAssessment->career_readiness_score_3 == 5) ? true : false, ['id' => 'cas-3-1']) !!}<label for="cas-3-1"><span class="fw700">Strongly agree</span></label></div>
                                </div>
                                <div class="col-lg-2">
                                <div class="cas-answer d-flex align-items-center">{!! Form::radio('cas-3', 'Agree', ($selfAssessment->career_readiness_score_3 == 4) ? true : false, ['id' => 'cas-3-2']) !!}<label for="cas-3-2"><span class="fw700">Agree</span></label></div>
                                </div>
                                <div class="col-lg-3">
                                <div class="cas-answer d-flex align-items-center">{!! Form::radio('cas-3', 'Neither agree or disagree', ($selfAssessment->career_readiness_score_3 == 3) ? true : false, ['id' => 'cas-3-3']) !!}<label for="cas-3-3"><span class="fw700">Neither agree or disagree</span></label></div>
                                </div>
                                <div class="col-lg-2">
                                <div class="cas-answer d-flex align-items-center">{!! Form::radio('cas-3', 'Disagree', ($selfAssessment->career_readiness_score_3 == 2) ? true : false, ['id' => 'cas-3-4']) !!}<label for="cas-3-4"><span class="fw700">Disagree</span></label></div>
                                </div>
                                <div class="col-lg-2">
                                <div class="cas-answer d-flex align-items-center">{!! Form::radio('cas-3', 'Strongly disagree', ($selfAssessment->career_readiness_score_3 == 1) ? true : false, ['id' => 'cas-3-5']) !!}<label for="cas-3-5"><span class="fw700">Strongly disagree</span></label></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-5">
                        <div class="car-question t-w">
                            <div class="row no-gutters">
                                <div class="col-lg-1 gg-bg p-3 text-center fw700 t24 q-number">4.</div>
                                <div class="{{ $errors->has('cas-4') ? ' has-error' : '' }} col-lg-11 def-bg p-3 t24 fw700 q-text">I know what I need to do to achieve my career goals</div>
                            </div>
                        </div>
                        <div class="car-answer">
                            <div class="row justify-content-between no-gutters">
                                <div class="col-lg-2">
                                <div class="cas-answer d-flex align-items-center">{!! Form::radio('cas-4', 'Strongly agree', ($selfAssessment->career_readiness_score_4 == 5) ? true : false, ['id' => 'cas-4-1']) !!}<label for="cas-4-1"><span class="fw700">Strongly agree</span></label></div>
                                </div>
                                <div class="col-lg-2">
                                <div class="cas-answer d-flex align-items-center">{!! Form::radio('cas-4', 'Agree', ($selfAssessment->career_readiness_score_4 == 4) ? true : false, ['id' => 'cas-4-2']) !!}<label for="cas-4-2"><span class="fw700">Agree</span></label></div>
                                </div>
                                <div class="col-lg-3">
                                <div class="cas-answer d-flex align-items-center">{!! Form::radio('cas-4', 'Neither agree or disagree', ($selfAssessment->career_readiness_score_4 == 3) ? true : false, ['id' => 'cas-4-3']) !!}<label for="cas-4-3"><span class="fw700">Neither agree or disagree</span></label></div>
                                </div>
                                <div class="col-lg-2">
                                <div class="cas-answer d-flex align-items-center">{!! Form::radio('cas-4', 'Disagree', ($selfAssessment->career_readiness_score_4 == 2) ? true : false, ['id' => 'cas-4-4']) !!}<label for="cas-4-4"><span class="fw700">Disagree</span></label></div>
                                </div>
                                <div class="col-lg-2">
                                <div class="cas-answer d-flex align-items-center">{!! Form::radio('cas-4', 'Strongly disagree', ($selfAssessment->career_readiness_score_4 == 1) ? true : false, ['id' => 'cas-4-5']) !!}<label for="cas-4-5"><span class="fw700">Strongly disagree</span></label></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-5">
                        <div class="car-question t-w">
                            <div class="row no-gutters">
                                <div class="col-lg-1 gg-bg p-3 text-center fw700 t24 q-number">5.</div>
                                <div class="{{ $errors->has('cas-5') ? ' has-error' : '' }} col-lg-11 def-bg p-3 t24 fw700 q-text">I am worried I won’t be able to achieve my career goals</div>
                            </div>
                        </div>
                        <div class="car-answer">
                            <div class="row justify-content-between no-gutters">
                                <div class="col-lg-2">
                                <div class="cas-answer d-flex align-items-center">{!! Form::radio('cas-5', 'Strongly agree', ($selfAssessment->career_readiness_score_5 == 1) ? true : false, ['id' => 'cas-5-1']) !!}<label for="cas-5-1"><span class="fw700">Strongly agree</span></label></div>
                                </div>
                                <div class="col-lg-2">
                                <div class="cas-answer d-flex align-items-center">{!! Form::radio('cas-5', 'Agree', ($selfAssessment->career_readiness_score_5 == 2) ? true : false, ['id' => 'cas-5-2']) !!}<label for="cas-5-2"><span class="fw700">Agree</span></label></div>
                                </div>
                                <div class="col-lg-3">
                                <div class="cas-answer d-flex align-items-center">{!! Form::radio('cas-5', 'Neither agree or disagree', ($selfAssessment->career_readiness_score_5 == 3) ? true : false, ['id' => 'cas-5-3']) !!}<label for="cas-5-3"><span class="fw700">Neither agree or disagree</span></label></div>
                                </div>
                                <div class="col-lg-2">
                                <div class="cas-answer d-flex align-items-center">{!! Form::radio('cas-5', 'Disagree', ($selfAssessment->career_readiness_score_5 == 4) ? true : false, ['id' => 'cas-5-4']) !!}<label for="cas-5-4"><span class="fw700">Disagree</span></label></div>
                                </div>
                                <div class="col-lg-2">
                                <div class="cas-answer d-flex align-items-center">{!! Form::radio('cas-5', 'Strongly disagree', ($selfAssessment->career_readiness_score_5 == 5) ? true : false, ['id' => 'cas-5-5']) !!}<label for="cas-5-5"><span class="fw700">Strongly disagree</span></label></div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-10">
            <div class="row r-pad">
                <div class="col-lg-6 offset-1">
                    <div class="row">
                    {!! Form::submit('Next', ["name" => "submit", "value" => "next", "class" => "platform-button pb-next"]) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {!! Form::close() !!}

</div>
</section>

@endsection
