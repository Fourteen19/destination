@extends('frontend.layouts.master')

@section('content')

Jobs at {{$company->name}}



related article
<div class="col-lg-12 col-sm-4 r-base">
    <a href="{{ route('frontend.article', ['article' => $relatedArticle->slug]) }}" class="article-block-link flex-column">
        <img src="{{ parse_encode_url($relatedArticle->getFirstMediaUrl('summary', 'summary_slot4-5-6')) ?? '' }}">
        <div class="w-bg article-summary">
            <h3 class="t20">{{ $relatedArticle->summary_heading }}</h3>
            <p class="t16">{{ Str::limit($relatedArticle->summary_text, $limit = 140, $end = '...') }}</p>
        </div>
    </a>
</div>




List of vacancies
<div>
    <ul>
        @foreach( $company->vacancies_live as $vacancy)
            <li>
                <a href="{{route('frontend.vacancy', ['vacancy' => $vacancy->slug])}}"><h3 class="job_listing-title">{{$company->name}}</h3>
                    <h3 class="job_listing-title">{{$vacancy->title}}</h3>
                    <h3 class="job_listing-title">{{$vacancy->region->name}}</h3>
                    <h3 class="job_listing-title">{{$vacancy->role->name}}</h3>
                    <h3 class="job_listing-title">Posted {{ \Carbon\Carbon::parse($vacancy->created_at)->diffForHumans() }}</h3>
                </a>
            </li>
        @endforeach
    </ul>
</div>

@endsection
