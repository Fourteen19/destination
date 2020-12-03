@extends('frontend.layouts.public')


@section('content')
<div class="row r-sep">
    <div class="col-lg-8">
        <div class="public-intro-banner d-flex align-items-center" style="background-image: url('https://via.placeholder.com/2074x1056/f8c4af/c8a59c?text=Banner')">
            <div class="row justify-content-center">
                    <div class="col-10">    
                        <h1 class="t36 fw700">Welcome to MyDirections</h1>
                        <p class="t20">Paragraph in troducing the concept and talking to teachers and parents about how to get it for your school or child...</p>
                        <a href="#" class="platform-button mt-3 mr-3">Find out more</a><a href="#" class="platform-button mt-3">contact us to get MyDirections for  your school</a>
                    </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 def-bg t-w r-pad">
        <div class="public-login d-flex flex-column h-100">
            <div><img src="https://via.placeholder.com/1006x276.png?text=Article+Image"></div> 
            <div class="login-prompt article-summary d-flex flex-grow-1 align-items-center">
                <div>
                <h3 class="t20">Already have a MyDirections an account?</h3>
                <p class="t16">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida.</p>
                <a href="#" class="platform-button mt-3">Click here to login</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
    <h2 class="t36">Free sample articles</h2>
    </div>
</div>
<div class="row vlg-bg r-pad">
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
@endsection