@extends('frontend.layouts.master')

@section('content')
<article>

    <div class="row r-sep">

    @foreach($data as $key => $value)

        <div class="col-3">
            <a href="#" class="td-no ac-link">
                <div class="square d-flex align-items-end" style="background-image: url( {{$value->getFirstMediaUrl('banner', 'banner_activity')}} );">
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

</article>
@endsection
