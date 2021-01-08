@extends('frontend.layouts.master')


@section('content')
<div class="row r-sep">
    <div class="col-lg-8">
        <div class="public-intro-banner d-flex align-items-center" style="background-image: url('https://via.placeholder.com/2074x1056/f8c4af/c8a59c?text=Banner')">
            <div class="row justify-content-center">
                    <div class="col-10">    
                        <h1 class="t36 fw700">Welcome to MyDirections</h1>
                        <p class="t20">Paragraph in troducing the concept and talking to teachers and parents about how to get it for your school or child...</p>
                        <a href="#" class="platform-button mt-3 mr-3">Find out more</a><a href="#" class="platform-button alt-button mt-3">contact us to get MyDirections for  your school</a>
                    </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 bg-3 t-w r-pad">
        <div class="public-login d-flex flex-column h-100">
            <div><img src="https://via.placeholder.com/1006x276.png?text=Article+Image"></div> 
            <div class="login-prompt article-summary d-flex flex-grow-1 align-items-center">
                <div>
                <h3 class="t20 fw700 t-w">Already have a MyDirections an account?</h3>
                <p class="t16">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida.</p>
                <a href="/login" class="platform-button alt-button mt-3">Click here to login</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
    <div class="heading-border">
    <h2 class="t36 fw700 mb-0">Free sample articles</h2>
    <p class="fw700 mb-0">Here are some examples of the great articles and advice that are available when you are logged in to MyDirections</p>
    </div>
    </div>
</div>
<div class="row vlg-bg r-pad r-sep">
    <div class="col-lg-4">
        <a href="#" class="article-block-link">
        <img src="https://via.placeholder.com/1006x670.png?text=Article+Image">
            <div class="w-bg article-summary">
                <h3 class="t20">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h3>
                <p class="t16">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida.</p>
            </div>
        </a>
    </div>
    <div class="col-lg-4">
        <a href="#" class="article-block-link">
        <img src="https://via.placeholder.com/1006x670.png?text=Article+Image">
            <div class="w-bg article-summary">
                <h3 class="t20">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h3>
                <p class="t16">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida.</p>
            </div>
        </a>
    </div>
    <div class="col-lg-4">
        <a href="#" class="article-block-link">
        <img src="https://via.placeholder.com/1006x670.png?text=Article+Image">
            <div class="w-bg article-summary">
                <h3 class="t20">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h3>
                <p class="t16">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida.</p>
            </div>
        </a>
    </div>
</div>

<div class="row vlg-bg r-pad r-sep">
    <div class="col-lg-6">
        <div class="row">
            <div class="col-12">
            <div class="heading-border w-bg w-100 d-flex">
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
    <div class="col-lg-6">
        <div class="row">
            <div class="col-12">
            <div class="heading-border w-bg w-100 d-flex">
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

<div class="row">
    <div class="col-12">
        <div class="heading-no-border">
        <h3 class="t36 fw700 mb-0">#hotrightnow</h3>
        <p class="t18 fw700">Check out the articles that are trending right now on MyDirections - you’ll need to login to access them.</p>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-3">
        
        <div class="square d-flex align-items-end" style="background-image: url('https://via.placeholder.com/737x737/5379a6/5379a6?text=Banner')">
            <div class="blur-summary"><h4 class="t20 fw700">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do </h4></div>
        </div>
        
    </div>
    <div class="col-3">
   
        <div class="square d-flex align-items-end" style="background-image: url('https://via.placeholder.com/737x737/5379a6/5379a6?text=Banner')">
            <div class="blur-summary"><h4 class="t20 fw700">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do </h4></div>
        </div>
        
    </div>
    <div class="col-3">
    
        <div class="square d-flex align-items-end" style="background-image: url('https://via.placeholder.com/737x737/5379a6/5379a6?text=Banner')">
            <div class="blur-summary"><h4 class="t20 fw700">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do </h4></div>
        </div>
      
    </div>
    <div class="col-3">
    
        <div class="square d-flex align-items-end" style="background-image: url('https://via.placeholder.com/737x737/5379a6/5379a6?text=Banner')">
            <div class="blur-summary"><h4 class="t20 fw700">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do </h4></div>
        </div>
       
    </div>
</div>
@endsection