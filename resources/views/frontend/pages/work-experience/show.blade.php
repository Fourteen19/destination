@extends('frontend.layouts.master')

@section('content')

    <div class="row r-sep bg-2 t-w justify-content-between align-items-center">
        <div class="col-xl-5">
            <div class="p-w p-offset">
                <h1 class="t30 fw700 t-w">Welcome to the world of work {{ Auth::user()->FullName }}</h1>
                <p>{{$screenData['we_intro']}}</p>
                @if ($screenData['we_button_link_goto'])
                    <a href="{{route('frontend.page', ['page' => $screenData['we_button_link_goto']])}}" class="platform-button alt-button mt-3">{{$screenData['we_button_text']}}</a>
                @endif
            </div>
        </div>
        <div class="col-xl-6">
            <div class="row">
                <div class="col-12"><img src="{{ asset('images/wexp-banner.png') }}" alt="The world of work" class="mt-5 mb-4"></div>
                <div class="col-12">
                    <div class="bar-header fw700 t20">Activities you’ve completed so far</div>
                    <div class="bar-holder">
                        <div class="bar-bg"></div>
                        <div class="bar-progress" style="width: {{$perentageCompleted}}%"></div>
                    </div>
                    <div class="bar-details">
                        <div class="bar-score-bg" style="left: calc({{$percentageCompleted}}% - 24px);">
                            <div class="bar-icon"><svg id="Marker" xmlns="http://www.w3.org/2000/svg" width="43.5" height="51.25" viewBox="0 0 87 102.5"><defs><style>.cls-1 {fill: #307511; stroke: #fff; stroke-width: 5px;}.cls-2 {fill: #fff; fill-rule: evenodd;}</style></defs><circle class="cls-1" cx="43.5" cy="59" r="41"/><path id="Triangle_2" data-name="Triangle 2" class="cls-2" d="M2346.5,2117l10.81,18.75h-21.62Z" transform="translate(-2302.5 -2117)"/></svg></div>
                            <div class="bar-score">{{$nbCompletedActivities}}</div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

    @include('frontend.pages.includes.activities.suggested-activities')

    @include('frontend.pages.includes.employers.featured-employers')

    <div class="row mt-5">
        <div class="col-12">
            <div class="bg-2 p-4"><a href="{{ route('frontend.dashboard') }}" class="t-w td-no fw700"><span class="mr-3"><svg xmlns="http://www.w3.org/2000/svg" width="15.345" height="17.714" viewBox="0 0 46.5 53.68"><defs><style>.arrow {fill: #fff;fill-rule: evenodd;}</style></defs><path id="Triangle_3" data-name="Back" class="arrow" d="M420.25,5625.75l46.5-26.84v53.68Z" transform="translate(-420.25 -5598.91)"/></svg></span>Back to home page</a></div>
        </div>
    </div>


    @include('frontend.pages.includes.activities.completed-activities')

@endsection
