@extends('frontend.layouts.master')

@section('content')

<div class="row r-sep align-items-center">
    <div class="col-xl-9 col-lg-8 col-sm-7">
        <div class="p-ws">
            <h1 class="fw700 t36">{{$vacancy->title}}</h1>
            <ul class="list-unstyled t24">
                <li>Location: <span class="fw700">[location]</span></li>
                <li>Posted: <span class="fw700">{{ Carbon\Carbon::parse($vacancy->created_at)->format('jS F Y')}}</span></li>
                <li>Employer: <span class="fw700">{{$vacancy->employer_name}}</span></li>
                <li>Role type: <span class="fw700">{{$vacancy->role->name}}</span></li>
            </ul>
        </div>
    </div>
    <div class="col-xl-3 col-lg-4 col-sm-5">
        <img src="{{parse_encode_url($vacancy->getFirstMediaUrl('vacancy_image')) ?? ''}}" onerror="this.style.display='none'">
    </div>
</div>
<div class="row">
    <div class="col mt-2 mb-5">
        <div class="border-top gg-border"></div>
    </div>
</div>

<div class="row justify-content-between">
    <div class="col-lg-8  mb-5 mb-lg-0">

        <p class="t24 mb-4">{{ $vacancy->lead_para }}</p>

        <div class="article-body">{!! $vacancy->description !!}</div>

        @if (!empty($vacancy->map))
            <div class="map mt-5">
                <h3 class="t24 fw700 mb-3"><i class="fas fa-map-marked fa-lg mr-3"></i>How to get there</h3>

                <div class="embed-responsive embed-responsive-21by9">
                <iframe src="{{$vacancy->map}}" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0" class="embed-responsive-item"></iframe>
                </div>
            </div>
        @endif
    </div>
    <div class="col-lg-4 col-xl-3 text-center pb-5 pb-lg-0">
        <img src="{{parse_encode_url($vacancy->getFirstMediaUrl('employer_logo')) ?? ''}}" onerror="this.style.display='none'">
        <div class="border-top gg-border my-4"></div>
        <div class="table-responsive mb-3">
            <table class="table table-borderless">
            <tbody>

                @if (!empty($vacancy->contact_name))
                    <tr>
                        <td width="5%"><i class="fas fa-user-circle fa-lg"></i></td>
                        <td class="text-left">Contact<br><span class="fw700">{{$vacancy->contact_name}}</span></td>
                    </tr>
                @endif

                @if (!empty($vacancy->contact_email))
                    <tr>
                        <td><i class="fas fa-at fa-lg"></i></td>
                        <td class="text-left"><a href="mailto:{{$vacancy->contact_email}}" class="fw700 td-no">{{$vacancy->contact_email}}</a></td>
                    </tr>
                @endif

                @if (!empty($vacancy->contact_number))
                    <tr>
                        <td><i class="fas fa-phone-square fa-lg"></i></td>
                        <td class="text-left"><a href="tel:{{$vacancy->contact_number}}" class="fw700 td-no">{{$vacancy->contact_number}}</a></td>
                    </tr>
                @endif

                @if (!empty($vacancy->contact_link))
                    <tr>
                        <td><i class="fas fa-link fa-lg"></i></td>
                        <td class="text-left"><a href="{{$vacancy->contact_link}}" class="fw700 td-no">Company website</a></td>
                    </tr>
                @endif
            </tbody>
            </table>
        </div>
        @if (!empty($vacancy->online_link))
            <a href="{{ $vacancy->online_link }}" class="platform-button pb-lge pb-inv">Apply online</a>
        @endif
    </div>
</div>

<div class="row mt-w">
    <div class="col">
        <h3 class="fw700 t36 mb-3 mb-lg-5">Related Jobs</h3>
    </div>
</div>

@foreach ($relatedVacancies as $relatedVacancy)
    <a href="{{ route('frontend.vacancy', ['vacancy' => $relatedVacancy->slug, 'clientSubdomain' => session('client.subdomain')]) }}" class="td-no article-row">
    <div class="row align-items-center t24">
        <div class="col-4 col-sm-2 col-lg-2 col-xl-1">
            <img src="{{parse_encode_url($relatedVacancy->getFirstMediaUrl('vacancy_image')) ?? ''}}" onerror="this.style.display='none'">
        </div>
        <div class="col-8 col-sm-10 col-lg-3 col-xl-4">
            <div><h3 class="fw700">{{$relatedVacancy->title}}</h3>{{$relatedVacancy->employer->name}}</div>
        </div>
        <div class="col-lg-2 col-8 col-sm-auto offset-4 offset-sm-2 offset-lg-0">
            <i class="fas fa-map-marker mr-2"></i><span class="fw700">{{$relatedVacancy->region->name}}</span>
        </div>
        <div class="col-lg-5 col-8 col-sm-auto offset-4 offset-sm-0 offset-lg-0">
            <div><span class="fw700">{{$relatedVacancy->role->name}}</span><div class="d-none d-sm-inline-block mx-2"> | </div><div class="d-sm-inline-block d-block">Posted {{ \Carbon\Carbon::parse($relatedVacancy->created_at)->diffForHumans() }}</div></div>
        </div>
    </div>
    </a>

    <div class="row">
        <div class="col my-4">
            <div class="border-top gg-border"></div>
        </div>
    </div>

@endforeach


<div class="row mt-5">
    <div class="col">
        <div class="border-top def-border pt-3 pl-3">
            <a href="{{ route('frontend.vacancies') }}" class="fw700 td-no">Back to Vacancies</a>
        </div>
    </div>
</div>
@endsection
