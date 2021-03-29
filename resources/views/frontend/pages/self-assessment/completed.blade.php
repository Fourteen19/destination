@extends('frontend.layouts.master')

@section('content')<section class="p-w">
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-xl-10">
            <div class="row r-pad">
                <div class="col-md-10 offset-md-1 col-xl-8 offset-xl-1">
                    <h1 class="t36 fw700">Thanks {{ Auth::user()->first_name }} you're all done</h1>
                    {!! $data['assessment_completed_txt'] !!}
                    <a href="{{ route('frontend.dashboard') }}" class="platform-button mt-4">Launch your personal home page</a>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
<div class="sa-image">
    <div class="over-img">
        <img src="{{ asset('images/completed-screen.png') }}" alt="You are all ready to go">
    </div>
    <div class="bg-image">
        <svg xmlns="http://www.w3.org/2000/svg" width="1920" height="391" viewBox="0 0 3840 782" class="w-100">
        <path class="welcome-swoosh" d="M3870,2092L24,1924v410l3846,372V2092Z" transform="translate(-25 -1924)"/>
        </svg>
    </div>
</div>
@endsection
