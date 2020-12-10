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
                <div class="col-lg-10 offset-1">
                    <div class="mb-5">    
                        <div class="car-question t-w">
                            <div class="row no-gutters">
                                <div class="col-lg-1 gg-bg p-3 text-center fw700 t24 q-number">1.</div>
                                <div class="col-lg-11 def-bg p-3 t24 fw700 q-text">I feel confident about my future</div>
                            </div>
                        </div>
                        <div class="car-answer">
                            <div class="row justify-content-between no-gutters">
                                <div class="col-lg-2">
                                <div class="cas-answer d-flex align-items-center"><input type="radio" name="cas-1-1" id="cas-id-1" value="Strongly agree"><label for="cas-id-1"><span class="fw700">Strongly agree</span></label></div>
                                </div>
                                <div class="col-lg-2">
                                <div class="cas-answer d-flex align-items-center"><input type="radio" name="cas-1-1" id="cas-id-2" value="Agree"><label for="cas-id-2"><span class="fw700">Agree</span></label></div>
                                </div>
                                <div class="col-lg-3">
                                <div class="cas-answer d-flex align-items-center"><input type="radio" name="cas-1-1" id="cas-id-3" value="Neither agree or disagree"><label for="cas-id-3"><span class="fw700">Neither agree or disagree</span></label></div>
                                </div>
                                <div class="col-lg-2">
                                <div class="cas-answer d-flex align-items-center"><input type="radio" name="cas-1-1" id="cas-id-4" value="Disagree"><label for="cas-id-4"><span class="fw700">Disagree</span></label></div>
                                </div>
                                <div class="col-lg-2">
                                <div class="cas-answer d-flex align-items-center"><input type="radio" name="cas-1-1" id="cas-id-5" value="Strongly disagree"><label for="cas-id-5"><span class="fw700">Strongly disagree</span></label></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-5">    
                        <div class="car-question t-w">
                            <div class="row no-gutters">
                                <div class="col-lg-1 gg-bg p-3 text-center fw700 t24 q-number">2.</div>
                                <div class="col-lg-11 def-bg p-3 t24 fw700 q-text">I understand the all the different career options and choices</div>
                            </div>
                        </div>
                        <div class="car-answer">
                            <div class="row justify-content-between no-gutters">
                                <div class="col-lg-2">
                                <div class="cas-answer d-flex align-items-center"><input type="radio" name="cas-1-2" id="cas-id-6" value="Strongly agree"><label for="cas-id-6"><span class="fw700">Strongly agree</span></label></div>
                                </div>
                                <div class="col-lg-2">
                                <div class="cas-answer d-flex align-items-center"><input type="radio" name="cas-1-2" id="cas-id-7" value="Agree"><label for="cas-id-7"><span class="fw700">Agree</span></label></div>
                                </div>
                                <div class="col-lg-3">
                                <div class="cas-answer d-flex align-items-center"><input type="radio" name="cas-1-2" id="cas-id-8" value="Neither agree or disagree"><label for="cas-id-8"><span class="fw700">Neither agree or disagree</span></label></div>
                                </div>
                                <div class="col-lg-2">
                                <div class="cas-answer d-flex align-items-center"><input type="radio" name="cas-1-2" id="cas-id-9" value="Disagree"><label for="cas-id-9"><span class="fw700">Disagree</span></label></div>
                                </div>
                                <div class="col-lg-2">
                                <div class="cas-answer d-flex align-items-center"><input type="radio" name="cas-1-2" id="cas-id-10" value="Strongly disagree"><label for="cas-id-10"><span class="fw700">Strongly disagree</span></label></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-5">    
                        <div class="car-question t-w">
                            <div class="row no-gutters">
                                <div class="col-lg-1 gg-bg p-3 text-center fw700 t24 q-number">3.</div>
                                <div class="col-lg-11 def-bg p-3 t24 fw700 q-text">I make good decisions and choices</div>
                            </div>
                        </div>
                        <div class="car-answer">
                            <div class="row justify-content-between no-gutters">
                                <div class="col-lg-2">
                                <div class="cas-answer d-flex align-items-center"><input type="radio" name="cas-1-3" id="cas-id-11" value="Strongly agree"><label for="cas-id-11"><span class="fw700">Strongly agree</span></label></div>
                                </div>
                                <div class="col-lg-2">
                                <div class="cas-answer d-flex align-items-center"><input type="radio" name="cas-1-3" id="cas-id-12" value="Agree"><label for="cas-id-12"><span class="fw700">Agree</span></label></div>
                                </div>
                                <div class="col-lg-3">
                                <div class="cas-answer d-flex align-items-center"><input type="radio" name="cas-1-3" id="cas-id-13" value="Neither agree or disagree"><label for="cas-id-13"><span class="fw700">Neither agree or disagree</span></label></div>
                                </div>
                                <div class="col-lg-2">
                                <div class="cas-answer d-flex align-items-center"><input type="radio" name="cas-1-3" id="cas-id-14" value="Disagree"><label for="cas-id-14"><span class="fw700">Disagree</span></label></div>
                                </div>
                                <div class="col-lg-2">
                                <div class="cas-answer d-flex align-items-center"><input type="radio" name="cas-1-3" id="cas-id-15" value="Strongly disagree"><label for="cas-id-15"><span class="fw700">Strongly disagree</span></label></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-5">
                        <div class="car-question t-w">
                            <div class="row no-gutters">
                                <div class="col-lg-1 gg-bg p-3 text-center fw700 t24 q-number">4.</div>
                                <div class="col-lg-11 def-bg p-3 t24 fw700 q-text">I know what I need to do to achieve my career goals</div>
                            </div>
                        </div>
                        <div class="car-answer">
                            <div class="row justify-content-between no-gutters">
                                <div class="col-lg-2">
                                <div class="cas-answer d-flex align-items-center"><input type="radio" name="cas-1-4" id="cas-id-16" value="Strongly agree"><label for="cas-id-16"><span class="fw700">Strongly agree</span></label></div>
                                </div>
                                <div class="col-lg-2">
                                <div class="cas-answer d-flex align-items-center"><input type="radio" name="cas-1-4" id="cas-id-17" value="Agree"><label for="cas-id-17"><span class="fw700">Agree</span></label></div>
                                </div>
                                <div class="col-lg-3">
                                <div class="cas-answer d-flex align-items-center"><input type="radio" name="cas-1-4" id="cas-id-18" value="Neither agree or disagree"><label for="cas-id-18"><span class="fw700">Neither agree or disagree</span></label></div>
                                </div>
                                <div class="col-lg-2">
                                <div class="cas-answer d-flex align-items-center"><input type="radio" name="cas-1-4" id="cas-id-19" value="Disagree"><label for="cas-id-19"><span class="fw700">Disagree</span></label></div>
                                </div>
                                <div class="col-lg-2">
                                <div class="cas-answer d-flex align-items-center"><input type="radio" name="cas-1-4" id="cas-id-20" value="Strongly disagree"><label for="cas-id-20"><span class="fw700">Strongly disagree</span></label></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-5">
                        <div class="car-question t-w">
                            <div class="row no-gutters">
                                <div class="col-lg-1 gg-bg p-3 text-center fw700 t24 q-number">5.</div>
                                <div class="col-lg-11 def-bg p-3 t24 fw700 q-text">I am worried I won’t be able to achieve my career goals</div>
                            </div>
                        </div>
                        <div class="car-answer">
                            <div class="row justify-content-between no-gutters">
                                <div class="col-lg-2">
                                <div class="cas-answer d-flex align-items-center"><input type="radio" name="cas-1-5" id="cas-id-21" value="Strongly agree"><label for="cas-id-21"><span class="fw700">Strongly agree</span></label></div>
                                </div>
                                <div class="col-lg-2">
                                <div class="cas-answer d-flex align-items-center"><input type="radio" name="cas-1-5" id="cas-id-22" value="Agree"><label for="cas-id-22"><span class="fw700">Agree</span></label></div>
                                </div>
                                <div class="col-lg-3">
                                <div class="cas-answer d-flex align-items-center"><input type="radio" name="cas-1-5" id="cas-id-23" value="Neither agree or disagree"><label for="cas-id-23"><span class="fw700">Neither agree or disagree</span></label></div>
                                </div>
                                <div class="col-lg-2">
                                <div class="cas-answer d-flex align-items-center"><input type="radio" name="cas-1-5" id="cas-id-24" value="Disagree"><label for="cas-id-24"><span class="fw700">Disagree</span></label></div>
                                </div>
                                <div class="col-lg-2">
                                <div class="cas-answer d-flex align-items-center"><input type="radio" name="cas-1-5" id="cas-id-25" value="Strongly disagree"><label for="cas-id-25"><span class="fw700">Strongly disagree</span></label></div>
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
        <button type="submit" name="submit" value="previous" class="platform-button pb-previous mr-3">Previous</button>
        <button type="submit" name="submit" value="next" class="platform-button pb-next">Next</button>
        </div>



                </div>
            </div>
        </div>
    </div>

</div>
</section>


    <a href="{{ route('frontend.self-assessment.subjects.edit') }}">Next</a>

@endsection
