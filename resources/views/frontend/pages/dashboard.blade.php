@extends('frontend.layouts.master')


@section('content')
{{--
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">{{ __('User Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p>{{ __('You are logged in!') }}</p>

                    <p>Your name is {{ Auth::user()->FullName }}</p>

                    <p>Your institution is: {{ Auth::user()->institution->name }}</p>

                </div>

            </div>

            @include('frontend.pages.includes.flash-message')

            @livewire('frontend.show-my-content')

        </div>
    </div>
</div>
--}}

<div class="row r-sep mlg-bg r-pad">


    <div class="col-lg-7">
        @if ($slot1 == NULL)

        @else
            <a href="{{ route('frontend.article', ['article' => $slot1->slug]) }}" class="article-block-link">
            <div class="lhp-intro-banner d-flex align-items-end" style="background-image: url({{ !empty($slot1->getFirstMediaUrl('summary', 'summary_slot1')) ? $slot1->getFirstMediaUrl('summary', 'summary_slot1') : config('global.default_summary_images.summary_slot1') }})">
                
                <div class="blur-summary">
                <h3 class="t36 fw700">{{ $slot1->summary_heading }}</h3>
                {{ $slot1->summary_text }}
                </div>
                        
            </div>
        @endif
        </a>
    </div>


    <div class="col-lg-5 d-flex flex-column align-items-start">
        @if ($slot2 == NULL)

        @else
            <a href="{{ route('frontend.article', ['article' => $slot2->slug]) }}" class="article-block-link mb-3">
            <div class="row no-gutters">
                <div class="col-lg-7">

                    <img src="{{ !empty($slot2->getFirstMediaUrl('summary', 'summary_slot2-3')) ? $slot2->getFirstMediaUrl('summary', 'summary_slot2-3') : config('global.default_summary_images.summary_slot2-3')}}">

                </div>
                <div class="col-lg-5 w-bg">
                    <div class="article-summary">
                    <h3 class="t20 fw700">{{ $slot2->summary_heading }}</h3>
                    <p class="t16 mb-0">{{ $slot2->summary_text }}</p>
                    </div>
                </div>
            </div>
            </a>
        @endif

        @if ($slot3 == NULL)

        @else
            <a href="{{ route('frontend.article', ['article' => $slot3->slug]) }}" class="article-block-link mt-auto">
            <div class="row no-gutters">
                <div class="col-lg-7">

                <img src="{{ !empty($slot3->getFirstMediaUrl('summary', 'summary_slot2-3')) ? $slot3->getFirstMediaUrl('summary', 'summary_slot2-3') : config('global.default_summary_images.summary_slot2-3')}}">

                </div>
                <div class="col-lg-5 w-bg">
                    <div class="article-summary">
                    <h3 class="t20 fw700">{{ $slot3->summary_heading }}</h3>
                    <p class="t16 mb-0">{{ $slot3->summary_text }}</p>
                    </div>
                </div>
            </div>
            </a>
        @endif
    </div>
</div>

<div class="row vlg-bg r-pad r-sep">
    <div class="col-lg-4">
        @if ($slot4 == NULL)

        @else
           <a href="{{ route('frontend.article', ['article' => $slot4->slug]) }}" class="article-block-link">
            <img src="{{ !empty($slot4->getFirstMediaUrl('summary', 'summary_slot4-5-6')) ? $slot4->getFirstMediaUrl('summary', 'summary_slot4-5-6') : config('global.default_summary_images.summary_slot4-5-6')}}">
                <div class="w-bg article-summary">
                    <h3 class="t20 fw700">{{ $slot4->summary_heading }}</h3>
                    <p class="t16">{{ $slot4->summary_text }}</p>
                </div>
            </a>
        @endif
    </div>
    <div class="col-lg-4">
        @if ($slot5 == NULL)

        @else
            <a href="{{ route('frontend.article', ['article' => $slot5->slug]) }}" class="article-block-link">
                <img src="{{ !empty($slot5->getFirstMediaUrl('summary', 'summary_slot4-5-6')) ? $slot5->getFirstMediaUrl('summary', 'summary_slot4-5-6') : config('global.default_summary_images.summary_slot4-5-6')}}">
                <div class="w-bg article-summary">
                    <h3 class="t20 fw700">{{ $slot5->summary_heading }}</h3>
                    <p class="t16">{{ $slot5->summary_text }}</p>
                </div>
            </a>
        @endif
    </div>
    <div class="col-lg-4">
        @if ($slot6 == NULL)

        @else
            <a href="{{ route('frontend.article', ['article' => $slot6->slug]) }}" class="article-block-link">
                <img src="{{ !empty($slot6->getFirstMediaUrl('summary', 'summary_slot4-5-6')) ? $slot6->getFirstMediaUrl('summary', 'summary_slot4-5-6') : config('global.default_summary_images.summary_slot4-5-6')}}">
                <div class="w-bg article-summary">
                    <h3 class="t20 fw700">{{ $slot6->summary_heading }}</h3>
                    <p class="t16">{{ $slot6->summary_text }}</p>
                </div>
            </a>
        @endif
    </div>
</div>

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
            <a href="#" class="platform-button ml-auto">View all</a>
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

<div class="row r-pad vlg-bg ">
    <div class="col-lg-6">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="article-summary">
                    <div class="t18 t-up fw700 mb-4">CV Builder</div>
                    <h2 class="t36 fw700 lh4">Try building up your CV and downloading it ready to send to employers</h2>
                    <a href="#" class="platform-button mt-4">Get started</a>
                </div>
            </div>
            <div class="col-lg-6">
            <div class="square" style="background-image: url('https://via.placeholder.com/737x737/5379a6/ffffff?text=Thumbnail')"></div>
            </div>
        </div>

    </div>

    <div class="col-lg-6 w-bg">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="article-summary">
                    <div class="t18 t-up fw700 mb-4">3RD PARTY TOOL</div>
                    <h2 class="t36 fw700 lh4">Try the job explorer database to get some ideas about the right career for you.</h2>
                    <a href="#" class="platform-button mt-4">Get started</a>
                </div>
            </div>
            <div class="col-lg-6">
            <div class="square" style="background-image: url('https://via.placeholder.com/737x737/5379a6/ffffff?text=Thumbnail')"></div>
            </div>
        </div>

    </div>
</div>

<div class="row r-pad r-sep">
    <div class="col-lg-6">
        <div class="row">
            <div class="col-12">
            <div class="heading-border w-bg w-100 d-flex">
            <h2 class="t36 fw700 mb-0">Read it again</h2>
            <a href="/events" class="platform-button ml-auto">View all</a>
            </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <a href="#" class="article-block-link">
                <div class="row mb-4 no-gutters vlg-bg">
                    <div class="col-lg-4">
                        <div class="square" style="background-image: url('https://via.placeholder.com/737x737/5379a6/ffffff?text=Thumbnail')"></div>
                    </div>
                    <div class="col-lg-8">
                    <div class="article-summary">
                        <h3 class="t20 fw700">Article slot RIA 1 - headline</h3>
                        <p class="t16">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida.</p>
                    </div>
                    </div>
                </div>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <a href="#" class="article-block-link">
                <div class="row">
                    <div class="col-lg-4">
                    <div class="square" style="background-image: url('https://via.placeholder.com/737x737/5379a6/ffffff?text=Thumbnail')"></div>
                    </div>
                    <div class="col-lg-8">
                    <h3 class="t20 fw700">Article slot RIA 2 - headline</h3>
                    <p class="t16">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida.</p>
                    </div>
                </div>
                </a>
            </div>
            <div class="col-lg-6">
            <a href="#" class="article-block-link">
                <div class="row">
                    <div class="col-lg-4">
                    <div class="square" style="background-image: url('https://via.placeholder.com/737x737/5379a6/ffffff?text=Thumbnail')"></div>
                    </div>
                    <div class="col-lg-8">
                    <h3 class="t20 fw700">Article slot RIA 3 - headline</h3>
                    <p class="t16">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida.</p>
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
            <h2 class="t36 fw700 mb-0">Something different</h2>
            <a href="#" class="platform-button ml-auto">View all</a>
            </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <a href="#" class="article-block-link">
                <div class="row mb-4 no-gutters vlg-bg">
                    <div class="col-lg-4">
                        <div class="square" style="background-image: url('https://via.placeholder.com/737x737/5379a6/ffffff?text=Thumbnail')"></div>
                    </div>
                    <div class="col-lg-8">
                    <div class="article-summary">
                        <h3 class="t20 fw700">Article slot SD 1 - headline</h3>
                        <p class="t16">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida.</p>
                    </div>
                    </div>
                </div>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <a href="#" class="article-block-link">
                <div class="row">
                    <div class="col-lg-4">
                    <div class="square" style="background-image: url('https://via.placeholder.com/737x737/5379a6/ffffff?text=Thumbnail')"></div>
                    </div>
                    <div class="col-lg-8">
                    <h3 class="t20 fw700">Article slot SD 2 - headline</h3>
                    <p class="t16">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida.</p>
                    </div>
                </div>
                </a>
            </div>
            <div class="col-lg-6">
            <a href="#" class="article-block-link">
                <div class="row">
                    <div class="col-lg-4">
                    <div class="square" style="background-image: url('https://via.placeholder.com/737x737/5379a6/ffffff?text=Thumbnail')"></div>
                    </div>
                    <div class="col-lg-8">
                    <h3 class="t20 fw700">Article slot SD 3 - headline</h3>
                    <p class="t16">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida.</p>
                    </div>
                </div>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="heading-no-border">
        <h3 class="t36 fw700 mb-0">#hotrightnow</h3>
        <p class="t18 fw700">Check out the articles that are trending right now on MyDirections.</p>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-3">
        <a href="#" class="td-no">
        <div class="square d-flex align-items-end" style="background-image: url('https://via.placeholder.com/737x737/5379a6/5379a6?text=Banner')">
            <div class="blur-summary"><h4 class="t20 fw700">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do </h4></div>
        </div>
        </a>
    </div>
    <div class="col-3">
    <a href="#" class="td-no">
        <div class="square d-flex align-items-end" style="background-image: url('https://via.placeholder.com/737x737/5379a6/5379a6?text=Banner')">
            <div class="blur-summary"><h4 class="t20 fw700">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do </h4></div>
        </div>
        </a>
    </div>
    <div class="col-3">
    <a href="#" class="td-no">
        <div class="square d-flex align-items-end" style="background-image: url('https://via.placeholder.com/737x737/5379a6/5379a6?text=Banner')">
            <div class="blur-summary"><h4 class="t20 fw700">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do </h4></div>
        </div>
        </a>
    </div>
    <div class="col-3">
    <a href="#" class="td-no">
        <div class="square d-flex align-items-end" style="background-image: url('https://via.placeholder.com/737x737/5379a6/5379a6?text=Banner')">
            <div class="blur-summary"><h4 class="t20 fw700">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do </h4></div>
        </div>
        </a>
    </div>
</div>
@endsection
