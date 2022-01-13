<div class="site-outer-pad">
@if (Auth::guard('web')->check())

    @if ((!Route::is('frontend.self-assessment.*')) && (!Route::is('frontend.welcome')))
    <div class="container-fluid mt-5">
            <div class="row justify-content-center">
                <div class="col-xl-12">

                    <div class="row vlg-bg align-items-start">
                        <div class="col-xl-5 offset-xl-1">
                            <div class="p-w">
                                <h2 class="fw700 t36">{{ $preFooterSupportBlock->support_block_heading }}</h2>
                                {!! $preFooterSupportBlock->support_block_body !!}
                                @if ($preFooterSupportBlock->support_block_link_goto)
                                    <a href="{{ route('frontend.page', ['page' => $preFooterSupportBlock->support_block_link_goto ] )}}" class="platform-button mt-3">{{ $preFooterSupportBlock->support_block_button_text }}</a>
                                @endif
                            </div>
                        </div>

                        @if (!empty($institutionAdvisors))
                            <div class="col-xl-4 offset-xl-1">
                                <div class="pl-xl-0 p-w">

                                <div class="t18 t-up fw700 mb-4">Your careers {{ str_plural('adviser', $nbAdvisers ) }}</div>

                                    <ul class="list-inline">
                                        @foreach ($institutionAdvisors as $institutionAdvisor)
                                            @if ($institutionAdvisor->getFirstMediaUrl('photo', 'small'))
                                                <li class="list-inline-item @if (!$loop->first) ml-n4 @endif"><img src="{{parse_encode_url($institutionAdvisor->getFirstMediaUrl('photo', 'small')) ?? ''}}" alt="{{$institutionAdvisor->title_full_name}}" class="rounded-circle" width="60" height="60"></li>
                                            @endif
                                        @endforeach
                                    </ul>

                                    <h2 class="t24 fw700">Hey {{Auth::guard('web')->user()->first_name}}, your careers  {{ str_plural('adviser', $nbAdvisers ) }} at {{ Auth::user()->institution->name }} @if ($nbAdvisers < 2) is @else are @endif {{ lastAnd($institutionAdvisors->pluck('title_full_name' )->implode(', ')) }}</h2>

                                    @if ($advisorsContactThem)
                                        <a href="{{ route('frontend.my-account.contact-my-adviser') }}" class="platform-button mt-4 mr-3">Contact them</a>
                                    @endif
                                    @if ($displayMeetMyAdvisers)
                                        <a href="{{ route('frontend.my-account.meet-your-adviser') }}" class="platform-button mt-4">Meet your {{ str_plural('adviser', $nbAdvisers ) }}</a>
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
        <div class="col-xl-12">
            <div class="row vlg-bg">

                <div class="col-lg-6 offset-lg-1">
                    <div class="p-w">
                        @if ($preFooterDetails)
                            <h2 class="fw700">{{ $preFooterDetails['pre_footer_heading'] }}</h2>
                            {!! $preFooterDetails['pre_footer_body'] !!}
                            @if ($preFooterDetails['pre_footer_link_goto'])
                                <a href="{{ route('frontend.page', $preFooterDetails['pre_footer_link_goto'])}}" class="platform-button mt-3">{{ $preFooterDetails['pre_footer_button_text'] }}</a>
                            @endif
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endif
</div>



@if (Auth::guard('web')->check())

    @if ((!Route::is('frontend.self-assessment.*')) && (!Route::is('frontend.welcome')))
    <div class="site-outer-pad">
        <div class="container-fluid mt-5">
            <div class="row justify-content-center">
                <div class="col-xl-12">

                    <div class="row bg-1 align-items-center t-w">
                        <div class="col-lg-7 offset-lg-1">
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
    </div>
    @endif
    <div class="site-outer-pad bg-2">
    <footer class="mt-5 t-w pt-5">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-xl-11">

                    <div class="row justify-content-between">
                        <div class="col-lg-5 mb-4 mb-lg-0">
                            © {{ date('Y') }} {{ Session::get('fe_client')['name'] }}
                        </div>

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

                            </ul>

                        </div>

                        <div class="col-lg-2 col-6 col-sm-4">
                            <div class="footer-logo mt-3 mt-lg-0 mb-5">@include('frontend.pages.includes.logo', ['logo_class' => 'footer-logo'])</div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </footer>
</div>
@else
<div class="site-outer-pad bg-2">
    <footer class="bg-2 mt-5 t-w pt-5">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-xl-11">

                    <div class="row">
                        <div class="col-lg-3 mb-4 mb-lg-0 col-sm-6">
                            © {{ date('Y') }} @if (isset(Session::get('fe_client')['name'])) {{ Session::get('fe_client')['name'] }} @endif
                        </div>

                        @if ($footerDetails)
                            <div class="col-lg-3 mb-4 mb-lg-0 col-sm-6">
                                <ul class="list-unstyled">
                                    <li class="mb-3">Call: <a href="tel:{{ $footerDetails['tel'] }}" class="t-w">{{ $footerDetails['tel'] }}</a></li>
                                    <li>Email: <a href="mailto:{{ $footerDetails['email'] }}" class="t-w">{{ $footerDetails['email'] }}</a></li>
                                </ul>
                            </div>
                        @endif

                        @include('frontend.pages.includes.footer-fixed-links')


                        <div class="col-lg-2 col-sm-6">
                            @if ($footerDetails)
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

                            </ul>
                            @endif
                        </div>

                        <div class="col-lg-2 col-6 col-sm-4">
                            <div class="footer-logo mt-3 mt-lg-0 mb-5">@include('frontend.pages.includes.logo', ['logo_class' => 'footer-logo'])</div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </footer>
    </div>
@endif
