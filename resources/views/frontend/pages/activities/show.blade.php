@extends('frontend.layouts.master')

@section('content')
<article>
    <div class="row r-pad" id="article-body">

        <div class="col-lg-12">
            @include('frontend.pages.activities.templates.' . $content->contentTemplate->slug)
        </div>

    </div>
</article>
@endsection

