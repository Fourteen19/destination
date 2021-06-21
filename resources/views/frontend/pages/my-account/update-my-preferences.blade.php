@extends('frontend.layouts.master')

@section('content')
<div class="row p-w">
    @include('frontend.pages.includes.account-menu')
    <div class="col-lg-9">
        <div class="account-form ml-lg-4 pl-lg-5 def-border">

            <h1 class="t36 fw700 mb-4">Update my preferences</h1>

            <p>We try to make sure that you only get the articles that you need and that you are interested in. But sometimes you might change your mind or decide you no longer want to follow a certain path. You can update your preferences using the form below.</p>
            <div class="row">
                <div class="col">
                    <div class="border-top def-border w-100 mb-5"></div>
                </div>
            </div>

            @include('frontend.pages.includes.flash-message')

            {!! Form::open(['method' => 'post', 'route' => ['frontend.my-account.update-my-preferences.update']]) !!}

            <h2 class="t24 fw700 mb-4">Subjects you are interested in</h2>

            <div id="subjects-parent" class="row justify-content-center">
                <div class="col-12">
                    <div class="row">
                        <div class="col-lg-4"></div>
                        <div class="col-lg-2 d-flex"><div class="subjects-header mlg-bg text-center fw700 t14">Like it / Enjoy it / I’m good at it</div></div>
                        <div class="col-lg-2 d-flex"><div class="subjects-header vlg-bg text-center fw700 t14">I don’t mind it / 50/50 / It’s ok</div></div>
                        <div class="col-lg-2 d-flex"><div class="subjects-header mlg-bg text-center fw700 t14">It’s not for me</div></div>
                        <div class="col-lg-2 d-flex"><div class="subjects-header vlg-bg text-center fw700 t14">Not applicable / I don’t study that</div></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12"><div class="border-bottom def-border w-100"></div></div>
                    </div>


                    @foreach($tagsSubjects as $key => $item)
                        <div class="row">
                            <div class="col-lg-4 py-2">
                                <div class="fw700 t16 py-2">{{ $item->name }}
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
                            <div class="col-lg-12">
                                <div class="vlg-bg p-2 t16">{{$item->text}}</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12"><div class="border-bottom gg-border w-100"></div></div>
                        </div>
                    @endforeach

                </div>
            </div>





            <div class="row my-5">
                <div class="col">
                    <div class="border-top def-border w-100 mb-5"></div>
                </div>
            </div>
            <h2 class="t24 fw700 mb-4">Sectors you are interested in working in</h2>

            <div id="sectors-parent">
                @foreach($sectors as $sector)

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="fw700 t16 p-2 d-inline-block mr-2">{{$sector->name}}
                                @if ($sector->text)
                                    <a data-toggle="collapse" data-target="#collapse-{{$sector->slug}}" href="#collapse-{{$sector->slug}}" role="button" aria-expanded="false" aria-controls="collapse-{{$sector->slug}}" class="self-help">?</a>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="routes-answer">{!! Form::checkbox('sectors[]', $sector->name, ($userSectorTags->where("id", $sector->id)->where("type", 'sector'))->count() == 1 ? true : false, ['id' => $sector->name]) !!}<label for="{{$sector->name}}"></label></div>
                        </div>
                    </div>
                    @if ($sector->text)
                        <div class="row collapse" data-parent="#sectors-parent" id="collapse-{{$sector->slug}}">
                            <div class="col-lg-12">
                            <div class="vlg-bg p-2 t16">{{$sector->text}}</div>
                            </div>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-lg-12"><div class="border-bottom gg-border w-100"></div></div>
                    </div>

                @endforeach
            </div>

            <div class="row my-5">
                <div class="col">
                    <div class="border-top def-border w-100 mb-5"></div>
                </div>
            </div>



            <h2 class="t24 fw700 mb-4">Your possible future options</h2>

            <div id="routes-parent">
                @foreach($routes as $route)

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="fw700 t16 p-2 d-inline-block mr-2">{{$route->name}}
                                @if ($route->text)
                                    <a data-toggle="collapse" data-target="#collapse-{{$route->slug}}" href="#collapse-{{$route->slug}}" role="button" aria-expanded="false" aria-controls="collapse-{{$route->slug}}" class="self-help">?</a>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6 col-2">
                            <div class="routes-answer">{!! Form::checkbox('routes['.$route->name.']', $route->name, ($userRouteTags->where("id", $route->id)->where("type", 'route'))->count() == 1 ? true : false, ['id' => $route->name]) !!}<label for="{{$route->name}}"></label></div>
                        </div>
                    </div>
                    @if ($route->text)
                        <div class="row collapse" id="collapse-{{$route->slug}}" data-parent="#routes-parent">
                            <div class="col-lg-12">
                            <div class="vlg-bg p-2 t16">{{$route->text}}</div>
                            </div>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-lg-12"><div class="border-bottom gg-border w-100"></div></div>
                    </div>

                @endforeach
            </div>


            <div class="row">
                <div class="col-lg-10"><div class="border-bottom gg-border w-100"></div></div>
            </div>

            <button type="submit" class="platform-button border-0 t-def mt-5">
                Update your preferences
            </button>

            {!! Form::close() !!}

        </div>
    </div>
</div>
@endsection
