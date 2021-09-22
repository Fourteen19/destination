@extends('frontend.layouts.master')

@section('content')

<div class="row r-sep align-items-center">
    <div class="col-xl-9 col-lg-8 col-sm-7">
        <div class="p-ws">
            <h1 class="fw700 t36">{{$vacancy->title}}</h1>
            <ul class="list-unstyled t24">
                <li>Location: <span class="fw700">{{$vacancy->region->name}}</span></li>
                <li>Posted: <span class="fw700">{{ Carbon\Carbon::parse($vacancy->created_at)->format('jS F Y')}}</span></li>
                <li>Employer: <span class="fw700">{{$vacancy->employer->name}}</span></li>
                <li>Role type: <span class="fw700">{{$vacancy->role->name}}</span></li>
                @if ($vacancy->entry_requirements)
                    <li>Entry Requirements: <span class="fw700">{!! $vacancy->entry_requirements !!}</span></li>
                @endif
            </ul>
        </div>
    </div>
    <div class="col-xl-3 col-lg-4 col-sm-5">
        <img src="{{parse_encode_url($vacancy->getFirstMediaUrl('vacancy_image', 'banner')) ?? ''}}" onerror="this.style.display='none'" alt="{{$vacancy->getFirstMedia('vacancy_image')->getCustomProperty('alt')}}">
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
                    {!! $vacancy->map !!}
                </div>
            </div>
        @endif
    </div>
    <div class="col-lg-4 col-xl-3 text-center pb-5 pb-lg-0">
        <img src="{{parse_encode_url($vacancy->employerImage->getFirstMediaUrl('logo')) ?? ''}}" onerror="this.style.display='none'" alt="{{$vacancy->employerImage->getFirstMedia('logo')->getCustomProperty('alt')}}">
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
                        <td class="text-left"><a href="https://{{$vacancy->contact_link}}" class="fw700 td-no">Company website</a></td>
                    </tr>
                @endif

                <tr>
                    <td><i class="fas fa-file-pdf fa-lg"></i></td>
                    <td class="text-left"><a href="{{ route('frontend.vacancy', ['vacancy' => $vacancy->slug, 'export' => 'pdf']) }}" class="fw700 td-no">Download & Print PDF</a></td>
                </tr>
            </tbody>
            </table>
        </div>
        @if (!empty($vacancy->online_link))
            <a href="https://{{ $vacancy->online_link }}" class="platform-button pb-lge pb-inv">Apply online</a>
        @endif

        @if (Auth::guard('web')->check())

            @if ($vacancy->employer->article)

                <div class="row vlg-bg r-pad mt-5">

                    <div class="col-lg-12">
                        <div class="heading-no-border w-bg">
                        <h2 class="t24 fw700 mb-lg-0 mb-sm-3"><small>Read more about:</small><br>{{$vacancy->employer->name}}</h2>
                        </div>
                    </div>

                    <div class="col-lg-12 col-sm-6 r-base">
                        <a href="{{ route('frontend.article', ['article' => $vacancy->employer->article->slug]) }}" class="td-no t-def">
                            <div class="square d-flex">
                                <div class="ep-inner">
                                    <div class="ep-logo">
                                        @if (!empty($vacancy->employer->article->getFirstMediaUrl('banner')))
                                            <img src="{{parse_encode_url($vacancy->employer->article->getFirstMediaUrl('banner'))}}" alt="{{$vacancy->employer->article->getFirstMedia('banner')->getCustomProperty('alt')}}">
                                        @endif
                                    </div>
                                    <div class="ep-summary">
                                        <div class="ep-pre t14 t-up fw600 lh0">Employer Profile:</div>
                                        <div class="ep-name t24">{{$vacancy->employer->article->summary_heading}}</div>
                                        <div class="ep-sector lh1 t16">
                                            @foreach($vacancy->employer->article->sectorTags()->get() as $tag)
                                                {{$tag->name}}<br/>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>



                </div>

            @endif

        @endif
    </div>
</div>


@if (count($relatedVacancies) > 0)

    <div class="row mt-w">
        <div class="col">
            <h3 class="fw700 t36 mb-3 mb-lg-5">Related Jobs</h3>
        </div>
    </div>

    @foreach ($relatedVacancies as $relatedVacancy)
        <a href="{{ route('frontend.vacancy', ['vacancy' => $relatedVacancy->slug, 'clientSubdomain' => session('client.subdomain')]) }}" class="td-no article-row">
        <div class="row align-items-center t24">
            <div class="col-4 col-sm-2 col-lg-2 col-xl-1">
                <img src="{{parse_encode_url($relatedVacancy->employerImage->getFirstMediaUrl('logo')) ?? ''}}" onerror="this.style.display='none'" alt="{{$relatedVacancy->employerImage->getFirstMedia('logo')->getCustomProperty('alt')}}">
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

@endif

<div class="row mt-5">
    <div class="col">
        <div class="border-top def-border pt-3 pl-3">
            <a href="{{ route('frontend.vacancies') }}" class="fw700 td-no">Back to Vacancies</a>
        </div>
    </div>
</div>
@endsection
