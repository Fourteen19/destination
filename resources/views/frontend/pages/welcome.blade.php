@extends('frontend.layouts.self')


@section('content')
<section class="p-w">
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-10">
            <div class="row r-pad">
                <div class="col-lg-8 offset-1">
                    <h1 class="t36 fw700">Welcome {{ Auth::user()->first_name }}</h1>
                    <p>Aliqua eu est aliqua labore. Ullamco laborum tempor ex cillum culpa id Lorem minim. Id exercitation aliqua pariatur occaecat incididunt esse laborum ea amet. Lorem eu laborum sint incididunt sint occaecat elit dolor proident in nisi laborum. Labore tempor tempor incididunt laboris non amet nostrud culpa commodo. Veniam elit mollit laborum ex dolore et amet ullamco veniam aliquip adipisicing fugiat est. Ad eiusmod nisi nisi cillum ex ex sint voluptate aliquip labore officia incididunt occaecat dolore.</p>
                    <a href="{{ route('frontend.self-assessment.careers-readiness.edit') }}" class="platform-button mt-4">Get started</a>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
<div>
<svg xmlns="http://www.w3.org/2000/svg" width="1920" height="391" viewBox="0 0 3840 782" class="w-100">
  <path class="welcome-swoosh" d="M24,2092l3846-168v410L24,2706V2092Z" transform="translate(-25 -1924)"/>
</svg>
</div>

{{--
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">{{ __('Welcome Screen') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p>{{ __('You are logged in!') }}</p>

                    <p>Your name is {{ Auth::user()->FullName }}</p>

                    <p>Your institution is: {{ Auth::user()->institution->name }}</p>

                    <p>You need to complete your profile</p>

                    <p><a href="{{ route('frontend.self-assessment.terms.edit') }}">Self Assessment</a></p>

                </div>





            </div>

        </div>
    </div>
</div>
--}}
@endsection
