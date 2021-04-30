@extends('frontend.layouts.master')

@section('content')
<article>

    <div class="row r-sep">

        @foreach($employers as $key => $employer)

            <div class="col-3">
                <a href="{{ route('frontend.employer', ['employer' => $employer->slug]) }}" class="td-no t-def">
                    <div class="square d-flex">
                        <div class="ep-inner">
                            <div class="ep-logo"><img src="{{$employer->getFirstMediaUrl('banner', 'banner') ?? ''}}"></div>
                            <div class="ep-summary">
                                <div class="ep-pre t14 t-up fw600 lh0">Employer Profile:</div>
                                <div class="ep-name t24">{{$employer->summary_heading}}</div>
                                <div class="ep-sector lh1 t16">{{$employer->summary_heading}}</div>
                            </div>
                    </div>
                    </div>
                </a>
            </div>

        @endforeach

    </div>

</article>
@endsection
