@extends('frontend.layouts.master')

@section('content')

<section class="lg-bg p-w-xl r-sep">
    <div class="row">
        <div class="col text-center">
            <h1 class="fw700 t36 mb-4">Find local jobs and apprenticeships</h1>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-9">
            <form>
            <div class="row justify-content-center">
                <div class="col">
                
                    <label class="sr-only" for="keywords">Enter a keyword</label>
                    <input type="text" class="form-control form-control-lg mr-sm-4" id="keywords" placeholder="Enter a keyword">
                </div>
                <div class="col">
                    <label class="sr-only" for="areas">Choose an Area</label>
                    <select class="form-control form-control-lg mr-sm-4" id="areas">
                        <option selected>Select an area</option>
                        <option value="1">Area One</option>
                        <option value="2">Area Two</option>
                        <option value="3">Area Three</option>
                    </select>
                </div>
                <div class="col">
                    <label class="sr-only" for="category">Choose a category</label>
                    <select class="form-control form-control-lg mr-sm-2" id="category">
                        <option selected>Select a category</option>
                        <option value="1">Category One</option>
                        <option value="2">Category Two</option>
                        <option value="3">Category Three</option>
                    </select>
                </div>
                <div class="col">
                <button type="submit" class="btn platform-button pb-inv">Search jobs</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</section>

<div class="row justify-content-center">
    <div class="col text-center">
        <div class="p-ws">
        <h2 class="fw700 t30">Featured opportunities</h2>
        </div>
    </div>
</div>

<div class="row mb-5">
    <div class="col-lg-3">
        <a href="#" class="article-block-link">
        <img src="https://via.placeholder.com/1006x670.png?text=Job+Image">
            <div class="w-bg article-summary">
                <h3 class="t24 fw700">Job Name</h3>
                <ul class="list-unstyled">
                    <li>Employer: <b>Marshalls</b></li>
                    <li>Location: <b>Halifax</b></li>
                    <li>Role Type: <b>Apprenticeship</b></li>
                </ul>
            </div>
        </a>
    </div>
    <div class="col-lg-3">
        <a href="#" class="article-block-link">
        <img src="https://via.placeholder.com/1006x670.png?text=Job+Image">
            <div class="w-bg article-summary">
                <h3 class="t24 fw700">Job Name</h3>
                <ul class="list-unstyled">
                    <li>Employer: <b>Marshalls</b></li>
                    <li>Location: <b>Halifax</b></li>
                    <li>Role Type: <b>Apprenticeship</b></li>
                </ul>
            </div>
        </a>
    </div>
    <div class="col-lg-3">
        <a href="#" class="article-block-link">
        <img src="https://via.placeholder.com/1006x670.png?text=Job+Image">
            <div class="w-bg article-summary">
                <h3 class="t24 fw700">Job Name</h3>
                <ul class="list-unstyled">
                    <li>Employer: <b>Marshalls</b></li>
                    <li>Location: <b>Halifax</b></li>
                    <li>Role Type: <b>Apprenticeship</b></li>
                </ul>
            </div>
        </a>
    </div>
    <div class="col-lg-3">
        <a href="#" class="article-block-link">
        <img src="https://via.placeholder.com/1006x670.png?text=Job+Image">
            <div class="w-bg article-summary">
                <h3 class="t24 fw700">Job Name</h3>
                <ul class="list-unstyled">
                    <li>Employer: <b>Marshalls</b></li>
                    <li>Location: <b>Halifax</b></li>
                    <li>Role Type: <b>Apprenticeship</b></li>
                </ul>
            </div>
        </a>
    </div>
</div>

<div class="row">
    <div class="col">
        <h3 class="fw700 t36 mb-5">Jobs and opportunities from your region</h3>
    </div>
</div>

<a href="#" class="td-no article-row">
<div class="row align-items-center t24">
    <div class="col-lg-1">
        <img src="https://via.placeholder.com/200x200.png?text=Logo">
    </div>
    <div class="col-lg-4">
        <div><h3 class="fw700">[Job name]</h3>[Employer Name]</div>
    </div>
    <div class="col-lg-2">
        <i class="fas fa-map-marker mr-2"></i><span class="fw700">[Location]</span>
    </div>
    <div class="col-lg-5">
        <div><span class="fw700">[Role type]</span> | Posted # months ago</div>
    </div>
</div>
</a>

<div class="row">
    <div class="col my-4">
        <div class="border-top gg-border"></div>
    </div>
</div>

<a href="#" class="td-no article-row">
<div class="row align-items-center t24">
    <div class="col-lg-1">
        <img src="https://via.placeholder.com/200x200.png?text=Logo">
    </div>
    <div class="col-lg-4">
        <div><h3 class="fw700">[Job name]</h3>[Employer Name]</div>
    </div>
    <div class="col-lg-2">
        <i class="fas fa-map-marker mr-2"></i><span class="fw700">[Location]</span>
    </div>
    <div class="col-lg-5">
        <div><span class="fw700">[Role type]</span> | Posted # months ago</div>
    </div>
</div>
</a>

<div class="row">
    <div class="col my-4">
        <div class="border-top gg-border"></div>
    </div>
</div>

<a href="#" class="td-no article-row">
<div class="row align-items-center t24">
    <div class="col-lg-1">
        <img src="https://via.placeholder.com/200x200.png?text=Logo">
    </div>
    <div class="col-lg-4">
        <div><h3 class="fw700">[Job name]</h3>[Employer Name]</div>
    </div>
    <div class="col-lg-2">
        <i class="fas fa-map-marker mr-2"></i><span class="fw700">[Location]</span>
    </div>
    <div class="col-lg-5">
        <div><span class="fw700">[Role type]</span> | Posted # months ago</div>
    </div>
</div>
</a>

<div class="row">
    <div class="col my-4">
        <div class="border-top gg-border"></div>
    </div>
</div>

<div class="row">
    <div class="col text-center">
        <a href="#" class="platform-button">Load more listings</a>
    </div>
</div>

<div class="row mt-5">
    <div class="col">
        <div class="border-top def-border pt-3 pl-3">
        @if (Auth::guard('web')->check())
            <a href="{{ route('frontend.dashboard') }}" class="fw700 td-no">
        @else
            <a href="/" class="fw700 td-no">
        @endif
        Back to previous page</a>
        </div>
    </div>
</div>
@endsection
