@extends('frontend.layouts.master')

@section('content')



<div class="row mt-5 mb-3">
    <div class="col-xl-7 col-lg-6 mb-4 mb-xl-0">
        <div class="pt-4">
            <h1 class="fw700 t36 mb-4">Jobs at {{$company->name}}</h1>
            <p>Below you will find a list of the current vacancies listed at {{$company->name}}.</p>
        </div>
    </div>
</div>

{{--
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
--}}

<div class="row mb-5">
    @foreach( $company->vacancies_live as $vacancy)
        <div class="col-lg-3">
        <a href="{{route('frontend.vacancy', ['vacancy' => $vacancy->slug])}}" class="article-block-link">
                <img src="{{parse_encode_url($vacancy->getFirstMediaUrl('vacancy_image')) ?? ''}}" onerror="this.style.display='none'" class="hp-free-img">
                <div class="w-bg article-summary">
                    <h3 class="t24 fw700">{{$vacancy->title}}</h3>
                    <ul class="list-unstyled">
                        <li>Employer: <b>{{$company->name}}</b></li>
                        <li>Location: <b>{{$vacancy->region->name}}</b></li>
                        <li>Role Type: <b>{{$vacancy->role->name}}</b></li>
                        <li><small>Posted {{ \Carbon\Carbon::parse($vacancy->created_at)->diffForHumans() }}</small></li>
                    </ul>
                </div>
            </a>
        </div>
    @endforeach
</div>

{{--
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
--}}


<div class="row mt-5">
    <div class="col">
        <div class="border-top def-border pt-3 pl-3">
            <a href="{{ route('frontend.vacancies') }}" class="fw700 td-no">Back to Vacancies</a>
        </div>
    </div>
</div>
@endsection
