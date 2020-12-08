@extends('frontend.layouts.loggedin')

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
            <div class="col-lg-12">
                
                <h1 class="t36 fw700">{{ $content->title }} </h1>
                <h2 class="t24 fw700 mb-4">[*** Sub Heading ***]</h2>
                <p class="t24 mb-4">{{ $content->contentable->lead }}</p>
                <div class="article-body">
                {!! $content->contentable->body !!}
                <h2>Article text from RTE</h2>
                <p>Mauris at consectetur nisi. Nunc quis enim ultricies, congue massa in, rhoncus tortor. Nam scelerisque leo sed vulputate mattis. Nulla scelerisque orci sed facilisis venenatis. In fringilla mauris tellus, sit amet congue sem maximus vel. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                <p>Cras tempor tellus nisl, in rutrum lectus ultricies a. Fusce placerat velit quis est convallis, nec vulputate mauris convallis. Praesent rhoncus hendrerit turpis, ac sodales tortor convallis id. Donec euismod, odio vulputate suscipit ornare, massa lorem porttitor neque, vitae dignissim nisl enim et quam. Curabitur semper aliquet lacinia. Nunc a risus non purus convallis laoreet. Vestibulum orci ex, scelerisque venenatis velit eu, molestie bibendum turpis. Vestibulum mattis nisl at orci ornare pharetra sit amet at nisl. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed nec nibh tempus, finibus justo non, ornare est. Vestibulum quis nisl eu nulla sollicitudin imperdiet quis ut urna. Donec in purus et enim lobortis condimentum.</p>
                </div>

                <div class="sup-img my-5">
                <img src="https://via.placeholder.com/1274x536/f74e77/f74e77?text=Banner">
                <div class="sup-img-caption vlg-bg p-3 t16 fw700">Image caption that goes with the supporting image block</div>
                </div>

                <div class="alternate-block my-5 mlg-bg p-5">
                    <h2 class="t24 fw700">{{ $content->contentable->alt_block_heading }}</h2>
                    <div class="alt-cols">

                    {!! $content->contentable->alt_block_text !!}
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut sed aut, exercitationem sunt, asperiores beatae voluptatibus eveniet temporibus quisquam quos ad quae quis odit facilis aspernatur alias dicta, saepe rerum. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Omnis, consequatur tenetur minima magnam necessitatibus illum corporis, excepturi quaerat molestiae aperiam officiis ab ut reiciendis, nulla optio accusantium in? In, veniam. Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic maiores ut sequi temporibus a odit accusantium aliquam recusandae explicabo? Iure excepturi corrupti beatae at ipsam error magni quam aliquid necessitatibus! Pariatur aliquip tempor nisi labore amet in incididunt non ipsum irure incididunt qui duis anim. Elit fugiat do exercitation tempor sunt sint velit. Nisi minim laboris labore ipsum do occaecat qui consectetur aute eiusmod consectetur in. Fugiat nostrud proident id ipsum ex cupidatat in quis cupidatat sit culpa irure do pariatur. Sit do aliquip do duis officia.</p>
                    <ul>
                        <li>Id excepteur ea irure quis velit aute.</li>
                        <li>Id excepteur ea irure quis velit aute.</li>
                        <li>Id excepteur ea irure quis velit aute.</li>
                    </ul>
                    </div>

                </div>

                
                <div class="vid-block my-5">
                    <h3 class="t24 fw700 mb-3">Watch the video</h3>
                    @foreach ($content->videos as $item)
                    <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" src="{{ $item->url }}" frameborder="0" allowfullscreen></iframe>
                    </div>
                    @endforeach
                </div>
                

                <div class="lower-text">
                    <p>Duis dolore proident dolore consequat aute consequat nisi irure quis. Eiusmod enim dolor aute dolore magna ex ad sunt tempor irure. Qui ex sunt Lorem consectetur laboris deserunt ut adipisicing pariatur ea voluptate deserunt duis quis. Lorem Lorem ipsum irure non occaecat id ullamco eiusmod commodo irure exercitation officia nostrud laborum. Nostrud pariatur occaecat pariatur aliquip officia officia. Tempor ea laboris occaecat laboris ex nisi exercitation.</p>
                </div>

            </div>
            
        </div>
        
        
        @include('frontend.pages.includes.things')
    
    </div>
    <div class="col-lg-4">
        <div class="row justify-content-end">
            <div class="col-lg-10">
                @include('frontend.pages.includes.related-articles')
            </div>
        </div>
    
    </div>
</div>
<div class="row r-base mt-5">
    <div class="col-12">
        <div class="mlg-bg p-5">
            <h3 class="fw700 t36 mb-4">Was this page relevant?</h3>
            <div class="form-check mb-3">
            <input class="form-check-input position-relative mr-2" type="radio" name="exampleRadios" id="exampleRadios1" value="option1">
            <label class="form-check-label t20 fw700" for="exampleRadios1">
               Yes - It was relevant to me and helpful
            </label>
            </div>
            <div class="form-check mb-3">
            <input class="form-check-input position-relative mr-2" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
            <label class="form-check-label t20 fw700" for="exampleRadios2">
                Not at all - it's not what I was after
            </label>
            </div>
            <button type="submit" class="platform-button border-0 t-def">
               Improve your profile
            </button>
        </div>

    </div>

</div>


<div class="row r-sep mt-5">
    <div class="col">
        <div class="border-top def-border pt-3 pl-3">
            <a href="{{ route('frontend.dashboard') }}" class="fw700 td-no d-inline-block mr-3">Back to previous page</a> | <a href="{{ route('frontend.dashboard') }}" class="fw700 td-no d-inline-block ml-3">Back to home page</a>
        </div>
    </div>
</div>
</article>

<div class="row mt-5">
    <div class="col-12">
        <div class="heading-no-border">
        <h3 class="t36 fw700 mb-0">Other pages you might like</h3>
        </div>
    </div>
</div>
<div class="row mb-5">
    <div class="col-3">
        <a href="#" class="td-no">
        <div class="square d-flex align-items-end" style="background-image: url('https://via.placeholder.com/737x737/5379a6/5379a6?text=Banner')">
            <div class="blur-summary"><h4 class="t20 fw700">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do </h4></div>
        </div>
        </a>
    </div>
    <div class="col-3">
    <a href="#" class="td-no">
        <div class="square d-flex align-items-end" style="background-image: url('https://via.placeholder.com/737x737/5379a6/5379a6?text=Banner')">
            <div class="blur-summary"><h4 class="t20 fw700">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do </h4></div>
        </div>
        </a>
    </div>
    <div class="col-3">
    <a href="#" class="td-no">
        <div class="square d-flex align-items-end" style="background-image: url('https://via.placeholder.com/737x737/5379a6/5379a6?text=Banner')">
            <div class="blur-summary"><h4 class="t20 fw700">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do </h4></div>
        </div>
        </a>
    </div>
    <div class="col-3">
    <a href="#" class="td-no">
        <div class="square d-flex align-items-end" style="background-image: url('https://via.placeholder.com/737x737/5379a6/5379a6?text=Banner')">
            <div class="blur-summary"><h4 class="t20 fw700">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do </h4></div>
        </div>
        </a>
    </div>
</div>

<div class="row mt-5">
    <div class="col-12">
        <div class="heading-no-border">
        <h3 class="t36 fw700 mb-0">#hotrightnow</h3>
        <p class="t18 fw700">Check out the articles that are trending right now on MyDirections.</p>
        </div>
    </div>
</div>
<div class="row mb-5">
    <div class="col-3">
        <a href="#" class="td-no">
        <div class="square d-flex align-items-end" style="background-image: url('https://via.placeholder.com/737x737/5379a6/5379a6?text=Banner')">
            <div class="blur-summary"><h4 class="t20 fw700">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do </h4></div>
        </div>
        </a>
    </div>
    <div class="col-3">
    <a href="#" class="td-no">
        <div class="square d-flex align-items-end" style="background-image: url('https://via.placeholder.com/737x737/5379a6/5379a6?text=Banner')">
            <div class="blur-summary"><h4 class="t20 fw700">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do </h4></div>
        </div>
        </a>
    </div>
    <div class="col-3">
    <a href="#" class="td-no">
        <div class="square d-flex align-items-end" style="background-image: url('https://via.placeholder.com/737x737/5379a6/5379a6?text=Banner')">
            <div class="blur-summary"><h4 class="t20 fw700">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do </h4></div>
        </div>
        </a>
    </div>
    <div class="col-3">
    <a href="#" class="td-no">
        <div class="square d-flex align-items-end" style="background-image: url('https://via.placeholder.com/737x737/5379a6/5379a6?text=Banner')">
            <div class="blur-summary"><h4 class="t20 fw700">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do </h4></div>
        </div>
        </a>
    </div>
</div>
@endsection
