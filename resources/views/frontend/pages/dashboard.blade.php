@extends('frontend.layouts.master')


@section('content')
<div class="row r-sep mlg-bg r-pad">


    <div class="col-xl-7 mb-3 mb-xl-0">
        @if ($slot1 == NULL)

        @else
            <a href="{{ route('frontend.article', ['article' => $slot1->slug]) }}" class="article-block-link">
            <div class="lhp-intro-banner d-flex align-items-end flex-grow-1" style="background-image: url({{ parse_encode_url($slot1->getFirstMediaUrl('summary', 'summary_slot1')) ?? '' }})">

                <div class="blur-summary">
                <h3 class="t36 fw700">{{ $slot1->summary_heading }}</h3>
                <p>{{ Str::limit($slot1->summary_text, $limit = 210, $end = '...') }}</p>
                </div>

            </div>
            </a>
        @endif
    </div>


    <div class="col-xl-5 d-flex flex-column align-items-start">
        <div class="row">
            
        @if ($slot2 == NULL)

        @else
            <div class="col-xl-12 col-md-6 mb-xl-3">
            <a href="{{ route('frontend.article', ['article' => $slot2->slug]) }}" class="article-block-link">
            <div class="row no-gutters flex-grow-1">
                <div class="col-lg-7">
                    <div class="position-relative slot-outer">
                        <div class="slot-2-3-img">
                        <img src="{{parse_encode_url($slot2->getFirstMediaUrl('summary', 'summary_slot2-3')) ?? ''}}" onerror="this.style.display='none'">
                        </div>
                        <div class="summary-over"><p class="t16 mb-0">{{ Str::limit($slot2->summary_text, $limit = 240, $end = '...') }}</p></div>
                    </div>
                </div>
                <div class="col-lg-5 w-bg">
                    <div class="article-summary">
                    <h3 class="t20 fw700">{{ $slot2->summary_heading }}</h3>
                    </div>
                </div>
            </div>
            </a>
            </div>
        @endif

        @if ($slot3 == NULL)

        @else
            <div class="col-xl-12 col-md-6">
            <a href="{{ route('frontend.article', ['article' => $slot3->slug]) }}" class="article-block-link mt-xl-auto">
            <div class="row no-gutters flex-grow-1">
                <div class="col-lg-7">
                    <div class="position-relative slot-outer">
                        <div class="slot-2-3-img">
                            <img src="{{parse_encode_url($slot3->getFirstMediaUrl('summary', 'summary_slot2-3')) ?? ''}}" onerror="this.style.display='none'">
                        </div>
                        <div class="summary-over"><p class="t16 mb-0">{{ Str::limit($slot3->summary_text, $limit = 240, $end = '...') }}</p></div>
                    </div>
                </div>
                <div class="col-lg-5 w-bg">
                    <div class="article-summary">
                    <h3 class="t20 fw700">{{ $slot3->summary_heading }}</h3>
                    {{--<p class="t16 mb-0">{{ Str::limit($slot3->summary_text, $limit = 120, $end = '...') }}</p>--}}
                    </div>
                </div>
            </div>
            </a>
            </div>
        @endif
        </div>
    </div>
</div>

<div class="row vlg-bg r-pad r-sep">
    <div class="col-lg-4 mb-3 mb-md-0">
        @if ($slot4 == NULL)

        @else
            <div class="d-flex flex-column h-100">
            <div class="slot-header d-flex align-items-center">
                <img src="{{ asset('images/md-routes.png') }}" alt="My routes">
                <a href="{{ route('frontend.my-routes') }}" class="platform-button alt-button ml-auto">View all</a>
            </div>
           <a href="{{ route('frontend.article', ['article' => $slot4->slug]) }}" class="article-block-link flex-grow-1 flex-column">

                <div class="slot-4-6-img">
                    <img src="{{parse_encode_url($slot4->getFirstMediaUrl('summary', 'summary_slot4-5-6')) ?? ''}}" onerror="this.style.display='none'">
                </div>
                <div class="w-bg article-summary">
                    <h3 class="t20 fw700">{{ $slot4->summary_heading }}</h3>
                    <p class="t16">{{ Str::limit($slot4->summary_text, $limit = 175, $end = '...') }}</p>
                </div>
            </a>
            </div>
        @endif
    </div>
    <div class="col-lg-4 mb-3 mb-md-0">
        @if ($slot5 == NULL)

        @else
        <div class="d-flex flex-column h-100">
            <div class="slot-header d-flex align-items-center">
                <img src="{{ asset('images/md-sectors.png') }}" alt="My routes">
                <a href="{{ route('frontend.my-sectors') }}" class="platform-button alt-button ml-auto">View all</a>
            </div>
            <a href="{{ route('frontend.article', ['article' => $slot5->slug]) }}" class="article-block-link flex-grow-1 flex-column">
                <div class="slot-4-6-img">
                    <img src="{{parse_encode_url($slot5->getFirstMediaUrl('summary', 'summary_slot4-5-6')) ?? ''}}" onerror="this.style.display='none'">
                </div>
                <div class="w-bg article-summary">
                    <h3 class="t20 fw700">{{ $slot5->summary_heading }}</h3>
                    <p class="t16">{{ Str::limit($slot5->summary_text, $limit = 175, $end = '...') }}</p>
                </div>
            </a>
        </div>
        @endif
    </div>
    <div class="col-lg-4 mb-3 mb-md-0">
        @if ($slot6 == NULL)

        @else
        <div class="d-flex flex-column h-100">
            <div class="slot-header d-flex align-items-center">
                <img src="{{ asset('images/md-subjects.png') }}" alt="My routes">
                <a href="{{ route('frontend.my-subjects') }}" class="platform-button alt-button ml-auto">View all</a>
            </div>
            <a href="{{ route('frontend.article', ['article' => $slot6->slug]) }}" class="article-block-link flex-grow-1 flex-column">
                <div class="slot-4-6-img">
                    <img src="{{parse_encode_url($slot6->getFirstMediaUrl('summary', 'summary_slot4-5-6')) ?? ''}}" onerror="this.style.display='none'">
                </div>
                <div class="w-bg article-summary">
                    <h3 class="t20 fw700">{{ $slot6->summary_heading }}</h3>
                    <p class="t16">{{ Str::limit($slot6->summary_text, $limit = 175, $end = '...') }}</p>
                </div>
            </a>
        </div>
        @endif

    </div>
</div>

{{--
<div class="row vlg-bg r-pad r-sep">
    <div class="col-lg-6">
        <div class="row">
            <div class="col-12">
            <div class="heading-border w-bg w-100 d-flex">
            <h2 class="t36 fw700 mb-0">Events you might like</h2>
            <a href="/events" class="platform-button ml-auto">View all</a>
            </div>
            </div>
        </div>
        <div class="row">
        <div class="col-sm-6 col-md-6 col-lg-6">
           <a href="#" class="td-no">
				<div class="w-bg">
                    <img src="https://via.placeholder.com/740x440.png?text=Event+Image">
                    <div class="row no-gutters">
						<div class="col-8">
							<div class="article-summary mlg-bg mbh-1">
							<h4 class="fw700 t20">Event title</h4>
							<p class="t16 mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt </p>
							</div>
						</div>

						<div class="col-4">
							<div class="event-summary p-3 w-bg t-up text-center fw700">
								<div class="row">
									<div class="col t48">
										29
									</div>
								</div>
								<div class="row">
									<div class="col t24">
										Sept
									</div>
								</div>
								<div class="row my-2">
									<div class="col">
										<div class="split border-top def-border w-100"></div>
									</div>
								</div>
								<div class="row">
									<div class="col t16">
										<span>Starts:<br>
										12:59 PM</span>
									</div>
								</div>

							</div>
						</div>
                    </div>
                </div>
			</a>
           </div>
           <div class="col-sm-6 col-md-6 col-lg-6">
           <a href="#" class="td-no">
				<div class="w-bg">
                    <img src="https://via.placeholder.com/740x440.png?text=Event+Image">
                    <div class="row no-gutters">
						<div class="col-8">
							<div class="article-summary mlg-bg mbh-1">
							<h4 class="fw700 t20">Event title</h4>
							<p class="t16 mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt </p>
							</div>
						</div>

						<div class="col-4">
							<div class="event-summary p-3 w-bg t-up text-center fw700">
								<div class="row">
									<div class="col t48">
										29
									</div>
								</div>
								<div class="row">
									<div class="col t24">
										Sept
									</div>
								</div>
								<div class="row my-2">
									<div class="col">
										<div class="split border-top def-border w-100"></div>
									</div>
								</div>
								<div class="row">
									<div class="col t16">
										<span>Starts:<br>
										12:59 PM</span>
									</div>
								</div>

							</div>
						</div>
                    </div>
                </div>
			</a>
           </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="row">
            <div class="col-12">
            <div class="heading-border w-bg w-100 d-flex">
            <h2 class="t36 fw700 mb-0">Vacancies for you</h2>
            <a href="/vacancies" class="platform-button ml-auto">View all</a>
            </div>
            </div>
        </div>
        <div class="row">
        <div class="col-sm-6 col-md-6 col-lg-6">
           <a href="#" class="td-no">

                    <img src="https://via.placeholder.com/740x440.png?text=Job+Image">
                    <div class="row no-gutters">
						<div class="col-12">
							<div class="article-summary mlg-bg mbh-1">
							<h4 class="fw700 t20">Job title</h4>
							<p class="t16 mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt </p>
							</div>
						</div>
                    </div>

			</a>
           </div>
           <div class="col-sm-6 col-md-6 col-lg-6">
           <a href="#" class="td-no">

                    <img src="https://via.placeholder.com/740x440.png?text=Job+Image">
                    <div class="row no-gutters">
						<div class="col-12">
							<div class="article-summary mlg-bg mbh-1">
							<h4 class="fw700 t20">Job title</h4>
							<p class="t16 mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt </p>
							</div>
						</div>
                    </div>

			</a>
           </div>
        </div>
    </div>
</div>
--}}


@if (Auth::guard('web')->user()->canAccessWorkExperience())
    <div class="row r-sep">
        <div class="col-12">
            <div class="bg-2 rounded p-4 p-xl-0">
                <div class="row t-w justify-content-between align-items-center">
                    <div class="col-xl-5 col-lg-6">
                        <div class="p-w p-offset">
                            <h2 class="t30 fw700 t-w">Visit the world of work {{Auth::guard('web')->user()->first_name}}</h1>
                            <p>{{$screenData['we_dashboard_intro']}}</p>
                            <a href="{{ route('frontend.work-experience') }}" class="platform-button alt-button mt-3">Get started</a>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6">
                        <div class="row">
                            <div class="col-12"><img src="{{ asset('images/wexp-banner.png') }}" alt="The world of work" class="mt-5 mb-4"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endif

<div class="row r-pad r-sep">
    @include('frontend.pages.includes.read-it-again') {{-- This temaplte include `something different` --}}
</div>

@include('frontend.pages.includes.hot-right-now')

@endsection
