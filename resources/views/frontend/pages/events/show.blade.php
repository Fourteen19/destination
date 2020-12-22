@extends('frontend.layouts.master')

@section('content')
<article>
<div class="row r-pad">
    <div class="col-lg-8">
        <div class="row mb-5">
            <div class="col">
            <img src="https://via.placeholder.com/2074x798/5379a6/5379a6?text=Banner">
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                
                <h1 class="t36 fw700">Event Title Name of Event</h1>
                <h2 class="t24 fw700 mb-4">Venue Name, Town Name</h2>
                <p class="t24 mb-4">Summary description to allow a quick assessment of the event. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque tortor ex, pretium a feugiat eget, interdum id tortor. Nam quis massa lectus. Morbi eget consequat quam. Sed in lacus vitae diam volutpat hendrerit. </p>
                <div class="article-body">
                <h2>About the event</h2>
                <p>Mauris at consectetur nisi. Nunc quis enim ultricies, congue massa in, rhoncus tortor. Nam scelerisque leo sed vulputate mattis. Nulla scelerisque orci sed facilisis venenatis. In fringilla mauris tellus, sit amet congue sem maximus vel. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                <p>Cras tempor tellus nisl, in rutrum lectus ultricies a. Fusce placerat velit quis est convallis, nec vulputate mauris convallis. Praesent rhoncus hendrerit turpis, ac sodales tortor convallis id. Donec euismod, odio vulputate suscipit ornare, massa lorem porttitor neque, vitae dignissim nisl enim et quam. Curabitur semper aliquet lacinia. Nunc a risus non purus convallis laoreet. Vestibulum orci ex, scelerisque venenatis velit eu, molestie bibendum turpis. Vestibulum mattis nisl at orci ornare pharetra sit amet at nisl. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed nec nibh tempus, finibus justo non, ornare est. Vestibulum quis nisl eu nulla sollicitudin imperdiet quis ut urna. Donec in purus et enim lobortis condimentum.</p>
                </div>
                <div class="sup-img my-5">
                <img src="https://via.placeholder.com/1274x536/f74e77/f74e77?text=Banner">
                <div class="sup-img-caption vlg-bg p-3 t16 fw700">Image caption that goes with the supporting image block</div>
                </div>
                <div class="vid-block my-5">
                    <h3 class="t24 fw700 mb-3">Watch the video</h3>
                    <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/ScMzIvxBSi4" frameborder="0" allowfullscreen></iframe>
                    </div>
                </div>
                

            </div>
            <div class="col-lg-4">
                <div class="vlg-bg">
                        <table class="table t-def">
                            <tbody>
                                <tr>
                                    <td width="15%"><i class="fas fa-calendar fa-2x"></i></td>
                                    <td class="t20 fw700">29th September 2020</td>
                                </tr>
                                <tr>
                                    <td><i class="fas fa-clock  fa-2x"></i></td>
                                    <td>
                                        <div><span class="t-up">Starts:</span> <span class="t20 fw700">20:00</span></div>
                                        <div><span class="t-up">Ends:</span> <span class="t20 fw700">22:00</span></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><i class="fas fa-user-circle fa-2x"></i></td>
                                    <td>
                                        <div class="t-up t16">Contact</div>
                                        <div class="fw700">Archibold Longname-Wilsonsmith</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><i class="fas fa-phone-square fa-2x"></i></td>
                                    <td class="t20 fw700"><a href="tel:01234 567 890" target="_blank" class="td-no">01234 567 890</a></td>
                                </tr>
                                <tr>
                                    <td><i class="fas fa-at fa-2x"></i></td>
                                    <td class="t20 fw700"><a href="mailto:email@email.com" target="_blank" class="td-no">Email the event organiser</a></td>
                                </tr>
                                <tr>
                                    <td><i class="fas fa-ticket-alt fa-2x"></i></td>
                                    <td class="t20 fw700"><a href="https://www.bookinglink.com" target="_blank" class="td-no">Click here to book</a></td>
                                </tr>
                            </tbody>
                        </table>

                </div>
                
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="map-block">
                    <h3 class="t24 fw700 mb-3"><i class="fas fa-map-marked mr-3"></i>How to get there</h3>
                    <div class="embed-responsive embed-responsive-21by9 mb-4">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d37835.43942466182!2d-1.8227195397223965!3d53.65205439123771!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x487962132bcdb7bb%3A0x653c3a498c896a17!2sHuddersfield!5e0!3m2!1sen!2suk!4v1607347437171!5m2!1sen!2suk" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                    </div>
                    <a href="#" target="_blank" class="fw700 td-no">Visit Google maps for detailed directions</a>
                </div>
            </div>
        </div>
        
        @include('frontend.pages.includes.things')
    
    </div>
    <div class="col-lg-4">
        <div class="row justify-content-end">
            <div class="col-lg-10">
                @include('frontend.pages.includes.other-events')
                @include('frontend.pages.includes.related-articles')
            </div>
        </div>
    
    </div>
</div>
<div class="row r-sep mt-5">
    <div class="col">
        <div class="border-top def-border pt-3 pl-3">
            <a href="/events" class="fw700 td-no">Back to previous page</a>
        </div>
    </div>
</div>
</article>
@endsection
