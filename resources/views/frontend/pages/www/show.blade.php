@extends('frontend.layouts.master-www')


@section('content')
<div class="vh-100 d-flex align-items-center w-100">
<div class="container">
    <div class="row">
        <div class="col-lg-10 text-center">
            <h1 class="fw600">MyDirections</h1>
            <p>This page will automatically redirect you to the main site home page provided by C+K Careers.</p>
            <p>If you are not redirected automatically within 10 seconds -
                @if (env('APP_ENV') == 'local')
                    <a href="http://ck.platformbrand.com:8000/">please click here</a>
                @elseif (env('APP_ENV') == 'staging')
                    <a href="https://ck.staging-mydirections.co.uk/">please click here</a>
                @elseif (env('APP_ENV') == 'production')
                    <a href="https://ck.mydirections.co.uk/">please click here</a>
                @endif
            </p>
        </div>
    </div>
</div>
</div>

@endsection
