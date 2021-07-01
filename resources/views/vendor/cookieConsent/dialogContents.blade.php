<div class="js-cookie-consent cookie-consent bg-2 t-w">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center my-3">
                {!! trans('cookieConsent::texts.message', ['cookies-policy-page' => route('frontend.cookies', ['clientSubdomain' => 'ck']) ] ) !!}<button class="js-cookie-consent-agree cookie-consent__agree cookie-button">{{ trans('cookieConsent::texts.agree') }}</button>
                </div>
                </div>

            </div>
        </div>
    </div>
</div>
