@if (count($employers) > 0)

<div class="row mt-5">
    <div class="col-12">
        <div class="heading-no-border d-flex pb-0 pr-0">
        <h3 class="t30 fw700 mb-0">Featured Employers</h3>
        <a href="{{ route('frontend.employers') }}" class="platform-button ml-auto">View All</a>
        </div>
    </div>
    </div>
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

@endif
