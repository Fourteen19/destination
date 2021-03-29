@if (Auth::guard('web')->check())

    @if ((!Route::is('frontend.self-assessment.*')) && (!Route::is('frontend.welcome')))
        <div class="container-fluid mt-5">
            <div class="row justify-content-center">
                <div class="col-xl-10">

                    <div class="row vlg-bg align-items-start">
                        <div class="col-lg-7 offset-1">
                            <div class="p-w">
                                <h2 class="fw700 t36">{{ $preFooterSupportBlock['support_block_heading'] }}</h2>
                                {!! $preFooterSupportBlock['support_block_body'] !!}
                                <a href="/temp-info" class="platform-button mt-3">{{ $preFooterSupportBlock['support_block_button_text'] }}</a>
                            </div>
                        </div>

                        @if (!empty($institutionAdvisor))
                            <div class="col-lg-3">
                                <div class="pl-5 p-w">

                                <div class="t18 t-up fw700 mb-4">Your careers adviser</div>

                                    <h2 class="t24 fw700">Hey {{ Auth::user()->FullName }}, your careers adviser at {{ Auth::user()->institution->name }} is {{$institutionAdvisor->titleFullName}}</h2>

                                    @if ($institutionAdvisor->contact_me == 'Y')
                                        <a href="{{ route('frontend.my-account.contact-my-adviser') }}" class="platform-button mt-4">Contact them</a>
                                    @endif

                                </div>
                            </div>
                        @endif

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
                        <h2 class="fw700">{{ $preFooterDetails['pre_footer_heading'] }}</h2>
                        {!! $preFooterDetails['pre_footer_body'] !!}
                        @if ($preFooterDetails['pre_footer_link_goto'])
                            <a href="{{ route('frontend.page', $preFooterDetails['pre_footer_link_goto'])}}" class="platform-button mt-3">{{ $preFooterDetails['pre_footer_button_text'] }}</a>
                        @endif
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
                        <h2 class="fw700 t36 t-w">{{ $preFooterDetailsLoggedIn['get_in_right_heading'] }}</h2>
                        {!! $preFooterDetailsLoggedIn['get_in_right_body'] !!}
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
                    © {{ date('Y') }} {{ Session::get('fe_client')->name }}
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
                    © {{ date('Y') }} {{ Session::get('fe_client')->name }}
                    </div>
                    <div class="col-lg-3 mb-4 mb-lg-0">
                        <ul class="list-unstyled">
                            <li class="mb-3">Call: <a href="tel:{{ $footerDetails['tel'] }}" class="t-w">{{ $footerDetails['tel'] }}</a></li>
                            <li>Email: <a href="mailto:{{ $footerDetails['email'] }}" class="t-w">{{ $footerDetails['email'] }}</a></li>
                        </ul>
                    </div>

                    @include('frontend.pages.includes.footer-fixed-links')


                    <div class="col-lg-2 col-sm-6">

                        <ul class="list-unstyled t14">

                            @if ($footerDetails['show_privacy'] == 'Y')
                                <li class="mb-2"><a href="{{ route('frontend.privacy') }}" class="t-w">Privacy policy</a></li>
                            @endif

                            @if ($footerDetails['show_terms'] == 'Y')
                                <li class="mb-2"><a href="{{ route('frontend.terms') }}" class="t-w">Terms & conditions</a></li>
                            @endif

                            @if ($footerDetails['show_cookies'] == 'Y')
                                <li class="mb-2"><a href="{{ route('frontend.cookies') }}" class="t-w">Cookie policy</a></li>
                            @endif

                            <li class="mb-2"><a href="#" class="t-w">Sitemap</a></li>
                        </ul>


                    </div>
                </div>


            </div>
        </div>
    </div>
</footer>
@endif
