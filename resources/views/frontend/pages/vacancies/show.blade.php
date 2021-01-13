@extends('frontend.layouts.master')

@section('content')

<div class="row r-sep align-items-center">
    <div class="col-xl-9 col-lg-8 col-sm-7">
        <div class="p-ws">
            <h1 class="fw700 t36">[Job Title]</h1>
            <ul class="list-unstyled t24">
                <li>Location: <span class="fw700">[location]</span></li>
                <li>Posted: <span class="fw700">[Posted]</span></li>
                <li>Employer: <span class="fw700">[Employer]</span></li>
                <li>Role type: <span class="fw700">[Role type]</span></li>
            </ul>
        </div>
    </div>
    <div class="col-xl-3 col-lg-4 col-sm-5">
        <img src="https://via.placeholder.com/1000x800.png?text=Job+Image"> 
    </div>
</div>
<div class="row">
    <div class="col mt-2 mb-5">
        <div class="border-top gg-border"></div>
    </div>
</div>

<div class="row justify-content-between">
    <div class="col-lg-8  mb-5 mb-lg-0">
        <p>Nulla aliqua et esse elit in aute. Eiusmod culpa fugiat excepteur ea eu aute qui eu deserunt sunt velit nostrud enim. Cupidatat excepteur ipsum nulla pariatur quis deserunt ipsum reprehenderit ea dolor consequat. Nulla proident enim consequat amet officia proident est nostrud nisi ullamco occaecat ad deserunt est. Eu anim commodo magna tempor qui nisi elit aliqua excepteur enim. Consectetur ea magna sunt culpa consectetur ea exercitation cupidatat esse mollit reprehenderit aliquip consequat.</p>

        <p>Esse cillum est dolor magna cillum enim mollit id ex. Anim qui sint aliqua voluptate consectetur tempor deserunt sit et voluptate elit. Aliquip est veniam dolor culpa ex minim minim qui consectetur ex deserunt. Consectetur cupidatat reprehenderit veniam anim et eu velit.</p>

        <p>Sint quis labore dolore ullamco. Sit voluptate minim do magna veniam minim velit ullamco nostrud consectetur veniam nulla dolore proident. Tempor fugiat eu dolore quis. Tempor ipsum deserunt labore ipsum.</p>

        <div class="map mt-5">
            <h3 class="t24 fw700 mb-3"><i class="fas fa-map-marked fa-lg mr-3"></i>How to get there</h3>

            <div class="embed-responsive embed-responsive-21by9">
            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d18930.12363078396!2d-1.8947828499999997!3d53.62440494999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2suk!4v1608726575219!5m2!1sen!2suk" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0" class="embed-responsive-item"></iframe>
            </div>

            <a href="#" target="_blank" class="mt-4 d-inline-block td-no fw700">Visit Google maps for detailed directions</a>
        </div>
    </div>
    <div class="col-lg-4 col-xl-3 text-center pb-5 pb-lg-0">
        <img src="https://via.placeholder.com/200x200.png?text=Logo"> 
        <div class="border-top gg-border my-4"></div>
        <div class="table-responsive mb-3">
            <table class="table table-borderless">
            <tbody>
                <tr>
                <td width="5%"><i class="fas fa-user-circle fa-lg"></i></td>
                <td class="text-left">Contact<br><span class="fw700">[Contact Name]</span></td>
                </tr>
                <tr>
                <td><i class="fas fa-at fa-lg"></i></td>
                <td class="text-left"><a href="mailto:name@mail.com" class="fw700 td-no">Email the company</a></td>
                </tr>
                <tr>
                <td><i class="fas fa-phone-square fa-lg"></i></td>
                <td class="text-left"><a href="tel:01234567890" class="fw700 td-no">[Phone number]</a></td>
                </tr>
                <tr>
                <td><i class="fas fa-link fa-lg"></i></td>
                <td class="text-left"><a href="#" class="fw700 td-no">Company website</a></td>
                </tr>
            </tbody>
            </table>
        </div>
        <a href="#" class="platform-button pb-lge pb-inv">Apply online</a>
    </div>
</div>

<div class="row mt-w">
    <div class="col">
        <h3 class="fw700 t36 mb-3 mb-lg-5">Related Jobs</h3>
    </div>
</div>
<a href="#" class="td-no article-row">
<div class="row align-items-center t24">
    <div class="col-4 col-sm-2 col-lg-2 col-xl-1">
        <img src="https://via.placeholder.com/200x200.png?text=Logo">
    </div>
    <div class="col-8 col-sm-10 col-lg-3 col-xl-4">
        <div><h3 class="fw700">[Job name]</h3>[Employer Name]</div>
    </div>
    <div class="col-lg-2 col-8 col-sm-auto offset-4 offset-sm-2 offset-lg-0">
        <i class="fas fa-map-marker mr-2"></i><span class="fw700">[Location]</span>
    </div>
    <div class="col-lg-5 col-8 col-sm-auto offset-4 offset-sm-0 offset-lg-0">
        <div><span class="fw700">[Role type]</span><div class="d-none d-sm-inline-block mx-2"> | </div><div class="d-sm-inline-block d-block">Posted # months ago</div></div>
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
    <div class="col-4 col-sm-2 col-lg-2 col-xl-1">
        <img src="https://via.placeholder.com/200x200.png?text=Logo">
    </div>
    <div class="col-8 col-sm-10 col-lg-3 col-xl-4">
        <div><h3 class="fw700">[Job name]</h3>[Employer Name]</div>
    </div>
    <div class="col-lg-2 col-8 col-sm-auto offset-4 offset-sm-2 offset-lg-0">
        <i class="fas fa-map-marker mr-2"></i><span class="fw700">[Location]</span>
    </div>
    <div class="col-lg-5 col-8 col-sm-auto offset-4 offset-sm-0 offset-lg-0">
        <div><span class="fw700">[Role type]</span><div class="d-none d-sm-inline-block mx-2"> | </div><div class="d-sm-inline-block d-block">Posted # months ago</div></div>
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
    <div class="col-4 col-sm-2 col-lg-2 col-xl-1">
        <img src="https://via.placeholder.com/200x200.png?text=Logo">
    </div>
    <div class="col-8 col-sm-10 col-lg-3 col-xl-4">
        <div><h3 class="fw700">[Job name]</h3>[Employer Name]</div>
    </div>
    <div class="col-lg-2 col-8 col-sm-auto offset-4 offset-sm-2 offset-lg-0">
        <i class="fas fa-map-marker mr-2"></i><span class="fw700">[Location]</span>
    </div>
    <div class="col-lg-5 col-8 col-sm-auto offset-4 offset-sm-0 offset-lg-0">
        <div><span class="fw700">[Role type]</span><div class="d-none d-sm-inline-block mx-2"> | </div><div class="d-sm-inline-block d-block">Posted # months ago</div></div>
    </div>
</div>
</a>

<div class="row mt-5">
    <div class="col">
        <div class="border-top def-border pt-3 pl-3">
            <a href="{{ route('frontend.vacancies') }}" class="fw700 td-no">Back to Vacancies</a>
        </div>
    </div>
</div>
@endsection
