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

                
                <div class="vid-block my-5">
                    <h3 class="t24 fw700 mb-3">Watch the video</h3>
                    @foreach ($content->videos as $item)
                    <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" src="{{ $item->url }}" frameborder="0" allowfullscreen></iframe>
                    </div>
                    @endforeach
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
<div class="row r-sep mt-5">
    <div class="col">
        <div class="border-top def-border pt-3 pl-3">
            <a href="{{ route('frontend.dashboard') }}" class="fw700 td-no">Back to previous page</a>
        </div>
    </div>
</div>
</article>


    {{ $content->contentable->statement }} <br>

    {{ $content->contentable->alt_block_heading }} <br>

    {!! $content->contentable->alt_block_text !!} <br>


@endsection
