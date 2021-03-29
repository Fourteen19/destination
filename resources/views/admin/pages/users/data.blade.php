@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 margin-tb">

            <h1 class="mb-4">View User Data for {{$data['full_name']}} @ {{$data['institution']}}</h1>
            <p class="mydir-instructions">The page below provides current and historic data about this user.</p>

        </div>
    </div>
    <div class="row">
        <div class="col-12 border-bottom md-border my-4"></div>
    </div>




    <ul class="nav nav-tabs mydir-tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#careers-readiness">Careers Readiness</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#self">Self Assessment</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#tags">Tag Scoring</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#keywords">Keywords history</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#articles">Articles Read</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#stats">Other Statistics</a>
        </li>
    </ul>


    <!-- Tab panes -->
    <div class="tab-content">

        <div id="careers-readiness" class="tab-pane active">
            <div class="row">
                <div class="col-lg-8">

                    <p>The information below shows the careers readiness score for this user for each year they have used the system. Click on the score to see a break down of the users answers in the careers readiness assessment.</p>

                    <div class="accordion" id="cr-stats">

                        <div class="card">

                        @foreach (config('global.school_year') as $key => $value)

                            @if ($data['selfAssessment'][$key])
                                <div class="card-header stat-header" id="y7-heading">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-left stat-button" type="button" data-toggle="collapse" data-target="#y7-stats" aria-expanded="true" aria-controls="y7-stats">
                                        <b>@if ($value == 14) Post @else Year {{$value}} @endif</b> <span class="stat-text">| Average score:</span> <b>{{$data['selfAssessment'][$key]['career_readiness']['average']}}</b>
                                        </button>
                                    </h2>
                                </div>
                                <div id="y7-stats" class="collapse show" aria-labelledby="y7-heading" data-parent="#cr-stats">
                                    <div class="card-body">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                <th scope="col">Question</th>
                                                <th scope="col">Score</th>
                                                <th scope="col">Statement</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                <td>I feel confident about my future</td>
                                                <td>{{$data['selfAssessment'][$key]['career_readiness']['q1']['score']}}</td>
                                                <td>{{$data['selfAssessment'][$key]['career_readiness']['q1']['statement']}}</td>
                                                </tr>

                                                <tr>
                                                <td>I understand the all the different career options and choices</td>
                                                <td>{{$data['selfAssessment'][$key]['career_readiness']['q2']['score']}}</td>
                                                <td>{{$data['selfAssessment'][$key]['career_readiness']['q2']['statement']}}</td>
                                                </tr>

                                                <tr>
                                                <td>I make good decisions and choices</td>
                                                <td>{{$data['selfAssessment'][$key]['career_readiness']['q3']['score']}}</td>
                                                <td>{{$data['selfAssessment'][$key]['career_readiness']['q3']['statement']}}</td>
                                                </tr>

                                                <tr>
                                                <td>I know what I need to do to achieve my career goals</td>
                                                <td>{{$data['selfAssessment'][$key]['career_readiness']['q4']['score']}}</td>
                                                <td>{{$data['selfAssessment'][$key]['career_readiness']['q4']['statement']}}</td>
                                                </tr>

                                                <tr>
                                                <td>I am worried I won’t be able to achieve my career goals</td>
                                                <td>{{$data['selfAssessment'][$key]['career_readiness']['q5']['score']}}</td>
                                                <td>{{$data['selfAssessment'][$key]['career_readiness']['q5']['statement']}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                        @endif

                    @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div id="self" class="tab-pane fade">
            <div class="row">
                <div class="col-lg-8">

                    <p>The data below shows the users selections from their self assessment.</p>

                    <h2 class="border-bottom pb-2 mb-4 mt-4">Selected Routes</h2>

                    <ul class="list-group">
                        @if ($data['currentSelfAssessment']['tags']['routes'])
                            @foreach( $data['currentSelfAssessment']['tags']['routes'] as $key => $value)
                                <li class="list-group-item">{{$value->name}}</li>
                            @endforeach
                        @endif
                    </ul>

                    <h2 class="border-bottom pb-2 mb-4 mt-4">Selected Subects</h2>

                    <ul class="list-group">
                        @if ($data['currentSelfAssessment']['tags']['routes'])
                            @foreach( $data['currentSelfAssessment']['tags']['subjects'] as $key => $value)
                                <li class="list-group-item d-flex align-items-center">{{$value->name}}
                                    @if ($value->pivot->assessment_answer == 1)
                                        <span class="ml-auto"><div class="subject-indicator sub-positive"></div></span>
                                    @elseif ($value->pivot->assessment_answer == 2)
                                    <span class="ml-auto"><div class="subject-indicator sub-middle"></div></span>
                                    @endif
                                </li>
                            @endforeach
                        @endif
                    </ul>

                    <h2 class="border-bottom pb-2 mb-4 mt-4">Selected Sectors</h2>

                    <ul class="list-group">
                        @if ($data['currentSelfAssessment']['tags']['routes'])
                            @foreach( $data['currentSelfAssessment']['tags']['sectors'] as $key => $value)
                                <li class="list-group-item">{{$value->name}}</li>
                            @endforeach
                        @endif
                    </ul>

                </div>
            </div>
        </div>

        <div id="tags" class="tab-pane fade">
            <div class="row">
                <div class="col-lg-6">

                <p>The data below shows the scores accumulated by the user via their interaction with platform articles.</p>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Routes</th>
                            <th scope="col" width="10%">Score</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($data['currentSelfAssessment']['tags']['routes'])
                            @foreach( $data['currentSelfAssessment']['tags']['routes'] as $key => $value)
                                <tr>
                                    <td>{{$value->name}}</td>
                                    <td>{{$value->pivot->score}}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                <div class="form-split"></div>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Subjects</th>
                            <th scope="col" width="10%">Score</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($data['currentSelfAssessment']['tags']['subjects'])
                            @foreach( $data['currentSelfAssessment']['tags']['subjects'] as $key => $value)
                                <tr>
                                    <td>{{$value->name}}</td>
                                    <td>{{$value->pivot->score}}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                <div class="form-split"></div>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Sectors</th>
                            <th scope="col" width="10%">Score</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($data['currentSelfAssessment']['tags']['sectors'])
                            @foreach( $data['currentSelfAssessment']['tags']['sectors'] as $key => $value)
                                <tr>
                                    <td>{{$value->name}}</td>
                                    <td>{{$value->pivot->score}}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>

                </div>
            </div>
        </div>

        <div id="keywords" class="tab-pane fade">
            <div class="row">
                <div class="col-lg-8">

                <p>The data below shows the keywords the user has selected via the suggestions provided in the keyword search, where the user then went on to read an article.</p>

                    <h2 class="border-bottom pb-2 mb-4 mt-4">Selected Keywords</h2>

                    <ul class="list-group">
                    @foreach( $data['keywords'] as $key => $value)
                        <li class="list-group-item">{{$value['name']['en']}}</li>
                    @endforeach
                    </ul>


                </div>
            </div>
        </div>

        <div id="articles" class="tab-pane fade">
            <div class="row">
                <div class="col-lg-4">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Total number of articles viewed:</th>
                            <th scope="col" width="10%">{{count($data['articlesReadThisYear'])}}</th>
                        </tr>
                    </thead>
                </table>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8">
                <div class="form-split"></div>
                <p>The data below shows the articles the user has clicked on the last 12 months.</p>

                    <h2 class="border-bottom pb-2 mb-4 mt-4">Article titles</h2>

                    <ul class="list-group">
                    @foreach( $data['articlesReadThisYear'] as $key => $value)
                        <li class="list-group-item">{{$value['title']}}</li>
                    @endforeach
                    </ul>

                </div>
            </div>
        </div>

        <div id="stats" class="tab-pane fade">
            <div class="row">
                <div class="col-lg-6">
                    <p>The data below shows general statistics for the user.</p>

                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Total number of red flag articles viewed this year:</th>
                                <th scope="col" width="30%">{{$data['nbRedFlagsArticlesRead']}}</th>
                            </tr>
                            <tr>
                                <th scope="col">Total number of times logged in (overall):</th>
                                <th scope="col" width="30%">{{$data['nbLogins']}}</th>
                            </tr>
                            <tr>
                                <th scope="col">Date system was last accessed:</th>
                                <th scope="col" width="30%">{{$data['lastLoginDate']}}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>


    </div>

    <div class="row">
        <div class="col">
            <div class="mydir-controls mt-5">
                <a class="mydir-action" href="{{ route('admin.users.index') }}"><i class="fas fa-caret-left mr-2"></i>Back</a>
            </div>
        </div>
    </div>


</div>
@endsection
