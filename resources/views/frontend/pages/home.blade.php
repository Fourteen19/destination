@extends('frontend.layouts.master')


@section('content')
<div class="row r-sep">
    <div class="col-lg-8">
        <div class="public-intro-banner d-flex align-items-end mb-3 mb-lg-0" style="background-image: url('{{$homepageBannerData['banner_image']}}')">
            <div class="row justify-content-center">
                    <div class="col-12 text-center text-sm-left">
                        <div class="p-5 public-banner-text">
                        <h1 class="t36 fw700">{{$homepageBannerData['banner_title']}}</h1>
                        <p class="t18">{{$homepageBannerData['banner_text']}}</p>
                        @if ( (!empty($homepageBannerData['banner_link1_page']->slug)) && (!empty($homepageBannerData['banner_link1_text'])) )
                            <a href="{{$homepageBannerData['banner_link1_page']->slug}}" class="platform-button mt-3 mr-sm-3">{{$homepageBannerData['banner_link1_text']}}</a>
                        @endif
                        @if ( (!empty($homepageBannerData['banner_link2_page']->slug)) && (!empty($homepageBannerData['banner_link2_text'])) )
                            <a href="{{$homepageBannerData['banner_link2_page']->slug}}" class="platform-button alt-button mt-3">{{$homepageBannerData['banner_link2_text']}}</a>
                        @endif
                        </div>
                    </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 bg-3 t-w r-pad">
        <div class="public-login d-flex flex-column h-100 p-md-5 p-lg-0">
            <div><img src="{{$loginBlock->getFirstMediaUrl('login_block_banner', 'small')}}"></div>
            <div class="login-prompt article-summary d-flex flex-grow-1 align-items-center">
                <div>
                <h3 class="t20 fw700 t-w">{{$loginBlock->login_block_heading}}</h3>
                <p class="t16">{{$loginBlock->login_block_body}}</p>
                <a href="{{ route('frontend.login') }}" class="platform-button alt-button mt-3">Click here to login</a>
                </div>
            </div>
        </div>
    </div>
</div>



@if ( (!empty($freeArticles['free_articles_slots'][0])) || (!empty($freeArticles['free_articles_slots'][1])) || (!empty($freeArticles['free_articles_slots'][2])) )
    <div class="row mt-5 mt-lg-0">
        <div class="col-lg-12">
        <div class="heading-border">
        <h2 class="t36 fw700 mb-0">{{$freeArticles['free_articles_block_heading']}}</h2>
        <p class="fw700 mb-0">{{$freeArticles['free_articles_block_text']}}</p>
        </div>
        </div>
    </div>
    <div class="row vlg-bg r-pad r-sep">
        @foreach($freeArticles['free_articles_slots'] as $key => $value)
            @if ($value)
                <div class="col-lg-4">
                    <a href="{{ route('frontend.free-article', ['article' => $value->slug]) }}" class="article-block-link">
                        <img src="{{ !empty($value->getFirstMediaUrl('summary', 'summary_slot4-5-6')) ? $value->getFirstMediaUrl('summary', 'summary_slot4-5-6') : config('global.default_summary_images.summary_slot4-5-6')}}"  class="hp-free-img">
                        <div class="w-bg article-summary">
                            <h3 class="t20">{{$value->summary_heading}}</h3>
                            <p class="t16">{{$value->summary_text}}</p>
                        </div>
                    </a>
                </div>
            @endif
        @endforeach
    </div>
@endif
{{--
<div class="row vlg-bg r-pad r-sep mb-5 mb-lg-0">
    <div class="col-xl-6 mb-5 mb-xl-0">
        <div class="row">
            <div class="col-12">
            <div class="heading-border w-bg w-100 d-flex align-items-center">
            <h2 class="t36 fw700 mb-0">Events</h2>
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
    <div class="col-xl-6">
        <div class="row">
            <div class="col-12">
            <div class="heading-border w-bg w-100 d-flex align-items-center">
            <h2 class="t36 fw700 mb-0">Vacancies</h2>
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
--}}
@include('frontend.pages.includes.hot-right-now')

@endsection
