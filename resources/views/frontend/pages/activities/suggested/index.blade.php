@extends('frontend.layouts.master')

@section('content')
<div>

    <div class="row mt-5">
        <div class="col-xl-7 col-lg-6 mb-4 mb-xl-0">
            <div class="pt-4">
                <h1 class="fw700 t30 mb-4">Your suggested activities</h1>
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
                    </div>
                    <div class="summary-extra t-w p-3">
                    <span class="fw700">{{$value->summary_heading}}</span>
                    <p>{{$value->summary_text}}</p>
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
