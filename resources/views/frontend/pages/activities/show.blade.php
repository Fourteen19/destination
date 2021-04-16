@extends('frontend.layouts.master')

@section('content')
<article>
    <div class="row r-pad" id="article-body">

        <div class="col-lg-8">
            @include('frontend.pages.activities.templates.' . $content->contentTemplate->slug)
        </div>

        @livewire('frontend.activity-questions-form', ['activity_id' => $content->uuid])

    </div>
</article>
@endsection
