@extends('frontend.layouts.master')

@section('content')<section class="p-w">
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-10">
            <div class="row r-pad">
                <div class="col-lg-8 offset-1">
                    <h1 class="t36 fw700">Thanks {{ Auth::user()->first_name }} you're all done</h1>
                    <p>Aliqua eu est aliqua labore. Ullamco laborum tempor ex cillum culpa id Lorem minim. Id exercitation aliqua pariatur occaecat incididunt esse laborum ea amet. Lorem eu laborum sint incididunt sint occaecat elit dolor proident in nisi laborum. Labore tempor tempor incididunt laboris non amet nostrud culpa commodo. Veniam elit mollit laborum ex dolore et amet ullamco veniam aliquip adipisicing fugiat est. Ad eiusmod nisi nisi cillum ex ex sint voluptate aliquip labore officia incididunt occaecat dolore.</p>
                    <a href="{{ route('frontend.dashboard') }}" class="platform-button mt-4">Launch your personal home page</a>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
<div>
<svg xmlns="http://www.w3.org/2000/svg" width="1920" height="391" viewBox="0 0 3840 782" class="w-100">
  <path class="welcome-swoosh" d="M3870,2092L24,1924v410l3846,372V2092Z" transform="translate(-25 -1924)"/>
</svg>
</div>
@endsection
