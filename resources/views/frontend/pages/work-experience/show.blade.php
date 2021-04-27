@extends('frontend.layouts.master')

@section('content')

    <div class="row r-sep bg-2 t-w justify-content-between align-items-center">
        <div class="col-xl-5">
            <div class="p-w p-offset">
                <h1 class="t30 fw700 t-w">Welcome to the world of work {{ Auth::user()->FullName }}</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.</p>
                <a href="#" class="platform-button alt-button mt-3">Learn how to get started</a>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="row">
                <div class="col-12"><img src="{{ asset('images/wexp-banner.png') }}" alt="The world of work" class="mt-5 mb-4"></div>
                <div class="col-12">
                    <div class="bar-header fw700 t20">Activities you’ve completed so far</div>
                    <div class="bar-holder">
                        <div class="bar-bg"></div>
                        <div class="bar-progress" style="width: 35%"></div>
                    </div>
                    <div class="bar-details">
                        <div class="bar-score-bg" style="left: calc(35% - 24px);">
                            <div class="bar-icon"><svg id="Marker" xmlns="http://www.w3.org/2000/svg" width="43.5" height="51.25" viewBox="0 0 87 102.5"><defs><style>.cls-1 {fill: #307511; stroke: #fff; stroke-width: 5px;}.cls-2 {fill: #fff; fill-rule: evenodd;}</style></defs><circle class="cls-1" cx="43.5" cy="59" r="41"/><path id="Triangle_2" data-name="Triangle 2" class="cls-2" d="M2346.5,2117l10.81,18.75h-21.62Z" transform="translate(-2302.5 -2117)"/></svg></div>
                            <div class="bar-score">3</div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>


    <div class="row r-sep">
    <div class="col-12">
        <div class="heading-no-border d-flex pb-0 pr-0">
        <h3 class="t30 fw700 mb-0">Your suggested activities</h3>
        <a href="{{ route('frontend.suggested-activities') }}" class="platform-button ml-auto">View All</a>
        </div>
    </div>
    </div>
    <div class="row r-sep">

        <div class="col-3">
            <a href="#" class="td-no ac-link">
                <div class="square d-flex align-items-end" style="background-image: url(https://via.placeholder.com/450x450);">
                    <div class="blur-summary">
                        <h4 class="t20 fw700">Activity 1: Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed. Viverra maecenas.</h4>
                        <div class="activity-overlay">
                        <svg id="Activity_completed" data-name="Activity completed" xmlns="http://www.w3.org/2000/svg" width="85.5" height="85" viewBox="0 0 171 170"><defs><style>.ac1 {fill: #307511;}.ac1, .ac2 {fill-rule: evenodd;}.ac2 {fill: #fff;}.ac3 {fill: none;stroke: #fff;stroke-width: 7px;}</style></defs><path id="Triangle_4" data-name="Triangle 4" class="ac1" d="M1115,3138v170H944Z" transform="translate(-944 -3138)"></path><path id="Rounded_Rectangle_5" data-name="Rounded Rectangle 5" class="ac2" d="M1081,3246l3.07,2.87a2,2,0,0,1,0,2.83L1060,3276c-0.78.78-1.22,0.78-2,0l-13-13a2.216,2.216,0,0,1,0-3,21.038,21.038,0,0,0,3-3c1.21-1.31,1.31-1.32,2-1,0.48,0.22,8.64,9.39,9,9,0.44-.47,1.55-1.53,2-2,6.09-6.29,17-17,17-17A2.216,2.216,0,0,1,1081,3246Z" transform="translate(-944 -3138)"></path><circle class="ac3" cx="120" cy="121" r="35"></circle></svg>
                        </div>
                    </div>
                    <div class="summary-extra t-w p-3">
                    <span class="fw700">Activity 3:  Title of the activity.</span>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-3">
            <a href="#" class="td-no ac-link">
                <div class="square d-flex align-items-end" style="background-image: url(https://via.placeholder.com/450x450);">
                    <div class="blur-summary">
                        <h4 class="t20 fw700">Activity 1: Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed. Viverra maecenas.</h4>
                        <div class="activity-overlay">
                        <svg id="Activity_completed" data-name="Activity completed" xmlns="http://www.w3.org/2000/svg" width="85.5" height="85" viewBox="0 0 171 170"><defs><style>.ac1 {fill: #307511;}.ac1, .ac2 {fill-rule: evenodd;}.ac2 {fill: #fff;}.ac3 {fill: none;stroke: #fff;stroke-width: 7px;}</style></defs><path id="Triangle_4" data-name="Triangle 4" class="ac1" d="M1115,3138v170H944Z" transform="translate(-944 -3138)"></path><path id="Rounded_Rectangle_5" data-name="Rounded Rectangle 5" class="ac2" d="M1081,3246l3.07,2.87a2,2,0,0,1,0,2.83L1060,3276c-0.78.78-1.22,0.78-2,0l-13-13a2.216,2.216,0,0,1,0-3,21.038,21.038,0,0,0,3-3c1.21-1.31,1.31-1.32,2-1,0.48,0.22,8.64,9.39,9,9,0.44-.47,1.55-1.53,2-2,6.09-6.29,17-17,17-17A2.216,2.216,0,0,1,1081,3246Z" transform="translate(-944 -3138)"></path><circle class="ac3" cx="120" cy="121" r="35"></circle></svg>
                        </div>
                    </div>
                    <div class="summary-extra t-w p-3">
                    <span class="fw700">Activity 3:  Title of the activity.</span>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-3">
            <a href="#" class="td-no ac-link">
                <div class="square d-flex align-items-end" style="background-image: url(https://via.placeholder.com/450x450);">
                    <div class="blur-summary">
                        <h4 class="t20 fw700">Activity 1: Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed. Viverra maecenas.</h4>
                        <div class="activity-overlay">
                        <svg id="Activity_completed" data-name="Activity completed" xmlns="http://www.w3.org/2000/svg" width="85.5" height="85" viewBox="0 0 171 170"><defs><style>.ac1 {fill: #307511;}.ac1, .ac2 {fill-rule: evenodd;}.ac2 {fill: #fff;}.ac3 {fill: none;stroke: #fff;stroke-width: 7px;}</style></defs><path id="Triangle_4" data-name="Triangle 4" class="ac1" d="M1115,3138v170H944Z" transform="translate(-944 -3138)"></path><path id="Rounded_Rectangle_5" data-name="Rounded Rectangle 5" class="ac2" d="M1081,3246l3.07,2.87a2,2,0,0,1,0,2.83L1060,3276c-0.78.78-1.22,0.78-2,0l-13-13a2.216,2.216,0,0,1,0-3,21.038,21.038,0,0,0,3-3c1.21-1.31,1.31-1.32,2-1,0.48,0.22,8.64,9.39,9,9,0.44-.47,1.55-1.53,2-2,6.09-6.29,17-17,17-17A2.216,2.216,0,0,1,1081,3246Z" transform="translate(-944 -3138)"></path><circle class="ac3" cx="120" cy="121" r="35"></circle></svg>
                        </div>
                    </div>
                    <div class="summary-extra t-w p-3">
                    <span class="fw700">Activity 3:  Title of the activity.</span>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-3">
            <a href="#" class="td-no ac-link">
                <div class="square d-flex align-items-end" style="background-image: url(https://via.placeholder.com/450x450);">
                    <div class="blur-summary">
                        <h4 class="t20 fw700">Activity 1: Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed. Viverra maecenas.</h4>
                        <div class="activity-overlay">
                        <svg id="Activity_completed" data-name="Activity completed" xmlns="http://www.w3.org/2000/svg" width="85.5" height="85" viewBox="0 0 171 170"><defs><style>.ac1 {fill: #307511;}.ac1, .ac2 {fill-rule: evenodd;}.ac2 {fill: #fff;}.ac3 {fill: none;stroke: #fff;stroke-width: 7px;}</style></defs><path id="Triangle_4" data-name="Triangle 4" class="ac1" d="M1115,3138v170H944Z" transform="translate(-944 -3138)"></path><path id="Rounded_Rectangle_5" data-name="Rounded Rectangle 5" class="ac2" d="M1081,3246l3.07,2.87a2,2,0,0,1,0,2.83L1060,3276c-0.78.78-1.22,0.78-2,0l-13-13a2.216,2.216,0,0,1,0-3,21.038,21.038,0,0,0,3-3c1.21-1.31,1.31-1.32,2-1,0.48,0.22,8.64,9.39,9,9,0.44-.47,1.55-1.53,2-2,6.09-6.29,17-17,17-17A2.216,2.216,0,0,1,1081,3246Z" transform="translate(-944 -3138)"></path><circle class="ac3" cx="120" cy="121" r="35"></circle></svg>
                        </div>
                    </div>
                    <div class="summary-extra t-w p-3">
                    <span class="fw700">Activity 3:  Title of the activity.</span>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.</p>
                    </div>
                </div>
            </a>
        </div>

    </div>

    <div class="row r-sep">
    <div class="col-12">
        <div class="heading-no-border d-flex pb-0 pr-0">
        <h3 class="t30 fw700 mb-0">Featured Employers</h3>
        <a href="#" class="platform-button ml-auto">View All</a>
        </div>
    </div>
    </div>
    <div class="row r-sep">

        <div class="col-3">
            <a href="#" class="td-no t-def">
                <div class="square d-flex">
                    <div class="ep-inner">
                        <div class="ep-logo"><img src="https://via.placeholder.com/250x50"></div>
                        <div class="ep-summary">
                            <div class="ep-pre t14 t-up fw600 lh0">Employer Profile:</div>
                            <div class="ep-name t24">ASDA</div>
                            <div class="ep-sector lh1 t16">Retail</div>
                        </div>
                   </div>
                </div>
            </a>
        </div>

        <div class="col-3">
            <a href="#" class="td-no t-def">
                <div class="square d-flex">
                    <div class="ep-inner">
                        <div class="ep-logo"><img src="https://via.placeholder.com/250x50"></div>
                        <div class="ep-summary">
                            <div class="ep-pre t14 t-up fw600 lh0">Employer Profile:</div>
                            <div class="ep-name t24">ASDA</div>
                            <div class="ep-sector lh1 t16">Retail</div>
                        </div>
                   </div>
                </div>
            </a>
        </div>

        <div class="col-3">
            <a href="#" class="td-no t-def">
                <div class="square d-flex">
                    <div class="ep-inner">
                        <div class="ep-logo"><img src="https://via.placeholder.com/250x50"></div>
                        <div class="ep-summary">
                            <div class="ep-pre t14 t-up fw600 lh0">Employer Profile:</div>
                            <div class="ep-name t24">ASDA</div>
                            <div class="ep-sector lh1 t16">Retail</div>
                        </div>
                   </div>
                </div>
            </a>
        </div>

        <div class="col-3">
            <a href="#" class="td-no t-def">
                <div class="square d-flex">
                    <div class="ep-inner">
                        <div class="ep-logo"><img src="https://via.placeholder.com/250x50"></div>
                        <div class="ep-summary">
                            <div class="ep-pre t14 t-up fw600 lh0">Employer Profile:</div>
                            <div class="ep-name t24">ASDA</div>
                            <div class="ep-sector lh1 t16">Retail</div>
                        </div>
                   </div>
                </div>
            </a>
        </div>

    </div>

    <div class="row mt-5">
        <div class="col-12">
            <div class="bg-2 p-4"><a href="{{ route('frontend.dashboard') }}" class="t-w td-no fw700"><span class="mr-3"><svg xmlns="http://www.w3.org/2000/svg" width="15.345" height="17.714" viewBox="0 0 46.5 53.68"><defs><style>.arrow {fill: #fff;fill-rule: evenodd;}</style></defs><path id="Triangle_3" data-name="Back" class="arrow" d="M420.25,5625.75l46.5-26.84v53.68Z" transform="translate(-420.25 -5598.91)"/></svg></span>Back to home page</a></div>
        </div>
    </div>


    {{-- @if ($nbCompletedActivities >= 4) --}}
        <div class="row r-sep">
        <div class="col-12">
            <div class="heading-no-border d-flex pb-0 pr-0">
            <h3 class="t30 fw700 mb-0">Activities you've completed</h3>
            <a href="{{ route('frontend.completed-activities') }}" class="platform-button ml-auto">View All</a>
            </div>
        </div>
        </div>
        <div class="row r-sep">

            <div class="col-3">
                <a href="#" style="position: relative;" class="td-no ac-link">
                    <div class="square d-flex align-items-end" style="background-image: url(https://via.placeholder.com/450x450);">
                        <div class="blur-summary">
                            <h4 class="t20 fw700">Activity 1: Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed. Viverra maecenas.</h4>
                            <div class="activity-overlay">
                            <svg id="Activity_completed" data-name="Activity completed" xmlns="http://www.w3.org/2000/svg" width="85.5" height="85" viewBox="0 0 171 170"><defs><style>.ac1 {fill: #307511;}.ac1, .ac2 {fill-rule: evenodd;}.ac2 {fill: #fff;}.ac3 {fill: none;stroke: #fff;stroke-width: 7px;}</style></defs><path id="Triangle_4" data-name="Triangle 4" class="ac1" d="M1115,3138v170H944Z" transform="translate(-944 -3138)"></path><path id="Rounded_Rectangle_5" data-name="Rounded Rectangle 5" class="ac2" d="M1081,3246l3.07,2.87a2,2,0,0,1,0,2.83L1060,3276c-0.78.78-1.22,0.78-2,0l-13-13a2.216,2.216,0,0,1,0-3,21.038,21.038,0,0,0,3-3c1.21-1.31,1.31-1.32,2-1,0.48,0.22,8.64,9.39,9,9,0.44-.47,1.55-1.53,2-2,6.09-6.29,17-17,17-17A2.216,2.216,0,0,1,1081,3246Z" transform="translate(-944 -3138)"></path><circle class="ac3" cx="120" cy="121" r="35"></circle></svg>
                            </div>
                        </div>
                        <div class="summary-extra t-w p-3">
                        <span class="fw700">Activity 3:  Title of the activity.</span>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-3">
                <a href="#" style="position: relative;" class="td-no ac-link">
                    <div class="square d-flex align-items-end" style="background-image: url(https://via.placeholder.com/450x450);">
                        <div class="blur-summary">
                            <h4 class="t20 fw700">Activity 1: Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed. Viverra maecenas.</h4>
                            <div class="activity-overlay">
                            <svg id="Activity_completed" data-name="Activity completed" xmlns="http://www.w3.org/2000/svg" width="85.5" height="85" viewBox="0 0 171 170"><defs><style>.ac1 {fill: #307511;}.ac1, .ac2 {fill-rule: evenodd;}.ac2 {fill: #fff;}.ac3 {fill: none;stroke: #fff;stroke-width: 7px;}</style></defs><path id="Triangle_4" data-name="Triangle 4" class="ac1" d="M1115,3138v170H944Z" transform="translate(-944 -3138)"></path><path id="Rounded_Rectangle_5" data-name="Rounded Rectangle 5" class="ac2" d="M1081,3246l3.07,2.87a2,2,0,0,1,0,2.83L1060,3276c-0.78.78-1.22,0.78-2,0l-13-13a2.216,2.216,0,0,1,0-3,21.038,21.038,0,0,0,3-3c1.21-1.31,1.31-1.32,2-1,0.48,0.22,8.64,9.39,9,9,0.44-.47,1.55-1.53,2-2,6.09-6.29,17-17,17-17A2.216,2.216,0,0,1,1081,3246Z" transform="translate(-944 -3138)"></path><circle class="ac3" cx="120" cy="121" r="35"></circle></svg>
                            </div>
                        </div>
                        <div class="summary-extra t-w p-3">
                        <span class="fw700">Activity 3:  Title of the activity.</span>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-3">
                <a href="#" style="position: relative;" class="td-no ac-link">
                    <div class="square d-flex align-items-end" style="background-image: url(https://via.placeholder.com/450x450);">
                        <div class="blur-summary">
                            <h4 class="t20 fw700">Activity 1: Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed. Viverra maecenas.</h4>
                            <div class="activity-overlay">
                            <svg id="Activity_completed" data-name="Activity completed" xmlns="http://www.w3.org/2000/svg" width="85.5" height="85" viewBox="0 0 171 170"><defs><style>.ac1 {fill: #307511;}.ac1, .ac2 {fill-rule: evenodd;}.ac2 {fill: #fff;}.ac3 {fill: none;stroke: #fff;stroke-width: 7px;}</style></defs><path id="Triangle_4" data-name="Triangle 4" class="ac1" d="M1115,3138v170H944Z" transform="translate(-944 -3138)"></path><path id="Rounded_Rectangle_5" data-name="Rounded Rectangle 5" class="ac2" d="M1081,3246l3.07,2.87a2,2,0,0,1,0,2.83L1060,3276c-0.78.78-1.22,0.78-2,0l-13-13a2.216,2.216,0,0,1,0-3,21.038,21.038,0,0,0,3-3c1.21-1.31,1.31-1.32,2-1,0.48,0.22,8.64,9.39,9,9,0.44-.47,1.55-1.53,2-2,6.09-6.29,17-17,17-17A2.216,2.216,0,0,1,1081,3246Z" transform="translate(-944 -3138)"></path><circle class="ac3" cx="120" cy="121" r="35"></circle></svg>
                            </div>
                        </div>
                        <div class="summary-extra t-w p-3">
                        <span class="fw700">Activity 3:  Title of the activity.</span>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-3">
                <a href="#" style="position: relative;" class="td-no ac-link">
                    <div class="square d-flex align-items-end" style="background-image: url(https://via.placeholder.com/450x450);">
                        <div class="blur-summary">
                            <h4 class="t20 fw700">Activity 1: Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed. Viverra maecenas.</h4>
                            <div class="activity-overlay">
                            <svg id="Activity_completed" data-name="Activity completed" xmlns="http://www.w3.org/2000/svg" width="85.5" height="85" viewBox="0 0 171 170"><defs><style>.ac1 {fill: #307511;}.ac1, .ac2 {fill-rule: evenodd;}.ac2 {fill: #fff;}.ac3 {fill: none;stroke: #fff;stroke-width: 7px;}</style></defs><path id="Triangle_4" data-name="Triangle 4" class="ac1" d="M1115,3138v170H944Z" transform="translate(-944 -3138)"></path><path id="Rounded_Rectangle_5" data-name="Rounded Rectangle 5" class="ac2" d="M1081,3246l3.07,2.87a2,2,0,0,1,0,2.83L1060,3276c-0.78.78-1.22,0.78-2,0l-13-13a2.216,2.216,0,0,1,0-3,21.038,21.038,0,0,0,3-3c1.21-1.31,1.31-1.32,2-1,0.48,0.22,8.64,9.39,9,9,0.44-.47,1.55-1.53,2-2,6.09-6.29,17-17,17-17A2.216,2.216,0,0,1,1081,3246Z" transform="translate(-944 -3138)"></path><circle class="ac3" cx="120" cy="121" r="35"></circle></svg>
                            </div>
                        </div>
                        <div class="summary-extra t-w p-3">
                        <span class="fw700">Activity 3:  Title of the activity.</span>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.</p>
                        </div>
                    </div>
                </a>
            </div>

        </div>
    {{-- @endif --}}

@endsection
