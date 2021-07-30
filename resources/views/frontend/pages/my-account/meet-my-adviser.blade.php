@extends('frontend.layouts.master')

@section('content')
<div class="row p-w">
    @include('frontend.pages.includes.account-menu')
    <div class="col-lg-9">
        <div class="account-form ml-lg-4 pl-lg-5 def-border">
            <h1 class="t36 fw700 mb-4">Meet your adviser</h1>

            <p>Your careers adviser(s) at [Institution Name] is/are [Adviser Name], [Adviser Name] and [Adviser Name].</p>
            
            <div class="row">
                <div class="col">
                    <div class="border-top def-border w-100 mb-5"></div>
                </div>
            </div>

            <div class="row mb-5">
                <div class="col-sm-2"><img src="https://via.placeholder.com/300x300.jpg" class="rounded-circle"></div>
                <div class="col-sm-6">
                    <h2 class="t20 fw700">[Adviser name]</h2>
                    <p>Introduction Lorem, ipsum dolor sit amet consectetur adipisicing elit. Possimus quasi consectetur illum neque laudantium perferendis magni unde accusantium laboriosam. Facere aliquam voluptates corporis repudiandae perferendis consequuntur, voluptas quae laborum hic.</p>
                    <h3 class="t18 fw700">Where to find me</h3>
                    <p>Location and times nisi cupiditate at modi reprehenderit, et hic veritatis numquam? Doloremque aperiam expedita, reiciendis et maiores iste earum. Odit architecto dolor praesentium accusamus.</p>
                </div>
            </div>

            <div class="row mb-5">
                <div class="col-sm-2"><img src="https://via.placeholder.com/300x300.jpg" class="rounded-circle"></div>
                <div class="col-sm-6">
                    <h2 class="t20 fw700">[Adviser name]</h2>
                    <p>Introduction Lorem, ipsum dolor sit amet consectetur adipisicing elit. Possimus quasi consectetur illum neque laudantium perferendis magni unde accusantium laboriosam. Facere aliquam voluptates corporis repudiandae perferendis consequuntur, voluptas quae laborum hic.</p>
                    <h3 class="t18 fw700">Where to find me</h3>
                    <p>Location and times nisi cupiditate at modi reprehenderit, et hic veritatis numquam? Doloremque aperiam expedita, reiciendis et maiores iste earum. Odit architecto dolor praesentium accusamus.</p>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
