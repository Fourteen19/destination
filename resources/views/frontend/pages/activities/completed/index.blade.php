@extends('frontend.layouts.master')

@section('content')
<div>
    <div class="row mt-5">
        <div class="col-xl-7 col-lg-6 mb-4 mb-xl-0">
            <div class="pt-4">
                <h1 class="fw700 t30 mb-4">Your completed activities</h1>
            </div>
        </div>
    </div>

    <div class="row r-sep">

    @foreach($data as $key => $value)

        <div class="col-3">
            <a href="{{ route('frontend.activity', ['activity' => $value->slug]) }}" class="td-no ac-link">
                <div class="square d-flex align-items-end" style="background-image: url({{$value->getFirstMediaUrl('banner', 'banner_activity') ?? ''}});">
                    <div class="blur-summary">
                        <h4 class="t20 fw700">{{$value->summary_heading}}</h4>
                        <div class="activity-overlay">
                        <svg id="Activity_completed" data-name="Activity completed" xmlns="http://www.w3.org/2000/svg" width="85.5" height="85" viewBox="0 0 171 170"><defs><style>.ac1 {fill: #307511;}.ac1, .ac2 {fill-rule: evenodd;}.ac2 {fill: #fff;}.ac3 {fill: none;stroke: #fff;stroke-width: 7px;}</style></defs><path id="Triangle_4" data-name="Triangle 4" class="ac1" d="M1115,3138v170H944Z" transform="translate(-944 -3138)"></path><path id="Rounded_Rectangle_5" data-name="Rounded Rectangle 5" class="ac2" d="M1081,3246l3.07,2.87a2,2,0,0,1,0,2.83L1060,3276c-0.78.78-1.22,0.78-2,0l-13-13a2.216,2.216,0,0,1,0-3,21.038,21.038,0,0,0,3-3c1.21-1.31,1.31-1.32,2-1,0.48,0.22,8.64,9.39,9,9,0.44-.47,1.55-1.53,2-2,6.09-6.29,17-17,17-17A2.216,2.216,0,0,1,1081,3246Z" transform="translate(-944 -3138)"></path><circle class="ac3" cx="120" cy="121" r="35"></circle></svg>
                        </div>
                    </div>
                    <div class="summary-extra t-w p-3">
                    <span class="fw700">{{$value->summary_heading}}</span>
                    <p>{{ Str::limit($value->summary_text, $limit = 147, $end = '...') }}</p>
                    </div>
                </div>
            </a>
        </div>


    @endforeach

    </div>

    <div class="row my-5">
        <div class="col-12">
            <div class="bg-2 p-4"><a href="{{ route('frontend.work-experience') }}" class="t-w td-no fw700"><span class="mr-3"><svg xmlns="http://www.w3.org/2000/svg" width="15.345" height="17.714" viewBox="0 0 46.5 53.68"><defs><style>.arrow {fill: #fff;fill-rule: evenodd;}</style></defs><path id="Triangle_3" data-name="Back" class="arrow" d="M420.25,5625.75l46.5-26.84v53.68Z" transform="translate(-420.25 -5598.91)"/></svg></span>Back to Work Experience page</a></div>
        </div>
    </div>

</div>
@endsection
