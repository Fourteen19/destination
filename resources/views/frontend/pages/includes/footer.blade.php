@if (Auth::guard('web')->check())

    @if ((!Route::is('frontend.self-assessment.*')) && (!Route::is('frontend.welcome')))
    <div class="container-fluid mt-5">
        <div class="row justify-content-center">
            <div class="col-xl-10">
                
                <div class="row vlg-bg align-items-center">
                    <div class="col-lg-7 offset-1">
                        <div class="p-w">
                        <h2 class="fw700 t36">Big free area for pointing user in the right direction for getting extra help and support</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis. </p>
                        <a href="/temp-info" class="platform-button mt-3">Click here for more information</a>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="pl-5 border-left def-border">

                        <div class="t18 t-up fw700 mb-4">Your careers adviser</div>

                        <h2 class="t24 fw700">
                            Hey {{ Auth::user()->FullName }},
                            @if (!empty($advisorName))
                                your careers adviser at {{ Auth::user()->institution->name }} is {{$advisorName}}
                            @else
                                You currently do not have a career advisor assigned to you.
                            @endif
                        </h2>

                        @if (!empty($canContactAdvisor))
                            <a href="{{ route('frontend.my-account.contact-my-adviser.edit') }}" class="platform-button mt-4">Contact them</a>
                        @endif

                        </div>
                    </div>

                </div>


            </div>
        </div>
    </div>
    @else
    <div class="container-fluid mt-5">
    <div class="row justify-content-center">
        <div class="col-xl-10">
            
            <div class="row vlg-bg">
                <div class="col-lg-6 offset-lg-1">
                    <div class="p-w">
                    <h2 class="fw700">How to get advice.</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis. </p>
                    <a href="/temp-info" class="platform-button mt-3">Click here for more information</a>
                    </div>
                </div>
            </div>


        </div>
    </div>
    </div>
    @endif
@else
<div class="container-fluid mt-5">
    <div class="row justify-content-center">
        <div class="col-xl-10">
            
            <div class="row vlg-bg">
                <div class="col-lg-6 offset-lg-1">
                    <div class="p-w">
                    <h2 class="fw700">How to get advice.</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis. </p>
                    <a href="/temp-info" class="platform-button mt-3">Click here for more information</a>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>
@endif




@if (Auth::guard('web')->check())

    @if ((!Route::is('frontend.self-assessment.*')) && (!Route::is('frontend.welcome')))
    <div class="container-fluid mt-5">
        <div class="row justify-content-center">
            <div class="col-xl-10">
                
                <div class="row bg-1 align-items-center t-w">
                    <div class="col-lg-7 offset-1">
                        <div class="p-w">
                        <h2 class="fw700 t36 t-w">Are we getting it right?</h2>
                        <h3 class="fw700 t24 t-w">Are you getting the articles you are interested in and that are relevant to your future career choices?</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis. </p>
                        <a href="{{ route('frontend.my-account.update-my-preferences.edit') }}" class="platform-button alt-button mt-3">Click here to update your account settings</a>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
    @endif

<footer class="bg-2 mt-5 t-w pt-5">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-xl-10">

                <div class="row">
                    <div class="col-lg-5">
                    © 2020 [CLIENT NAME]
                    </div>
                </div>


            </div>
        </div>
    </div>
</footer>
@else
<footer class="bg-2 mt-5 t-w pt-5">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-xl-10">

                <div class="row">
                    <div class="col-lg-5 mb-4 mb-lg-0">
                    © 2020 [CLIENT NAME]
                    </div>
                    <div class="col-lg-3 mb-4 mb-lg-0">
                    <ul class="list-unstyled">
                        <li class="mb-3">Call: <a href="tel:01234567890" class="t-w">01234567890</a></li>
                        <li>Email: <a href="mailto:rick@rfmedia.co.uk" class="t-w">rick@rfmedia.co.uk</a></li>
                    </ul>


                    </div>
                    <div class="col-lg-2 mb-4 mb-lg-0 col-sm-6">
                        <ul class="list-unstyled t-up t14">
                            <li class="mb-2"><a href="#" class="t-w">CONTACT US</a></li>
                            <li class="mb-2"><a href="#" class="t-w">FIXED LINK 1</a></li>
                            <li class="mb-2"><a href="#" class="t-w">FIXED LINK 2</a></li>
                            <li class="mb-2"><a href="#" class="t-w">FIXED LINK N</a></li>
                            <li class="mb-2"><a href="#" class="t-w">FAQS</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-2 col-sm-6">
                        <ul class="list-unstyled t14">
                            <li class="mb-2"><a href="#" class="t-w">Privacy policy</a></li>
                            <li class="mb-2"><a href="#" class="t-w">Terms & conditions</a></li>
                            <li class="mb-2"><a href="#" class="t-w">Cookie policy</a></li>
                            <li class="mb-2"><a href="#" class="t-w">Sitemap</a></li>

                        </ul>
                    </div>
                </div>


            </div>
        </div>
    </div>
</footer>
@endif
