
<div class="col-lg-6">
    <div class="w-bg h-100 d-flex flex-column">
        <div class="row">
            <div class="col-12">
            <div class="heading-border w-bg w-100 d-flex">
            <h2 class="t36 fw700 mb-0">Latest Vacancies</h2>
            @if (count($vacancies) > 1)<a href="{{ route('frontend.vacancies', ['clientSubdomain' => session('client.subdomain')]) }}" class="platform-button ml-auto">View all</a>@endif
            </div>
            </div>
        </div>

            @if (count($vacancies) < 2)
                    <div class="row flex-grow-1">
                        <div class="col-sm-12">
                            <div class="p-4"><p class="fw700">There are currently no vacancies listed - please check back later.</p></div>
                            <div class="p-3 d-flex align-items-center justify-content-center"><img src="{{ asset('images/no-vac-bg.jpg') }}" alt="MyDirection Vacancies"></div>
                        </div>
                    </div>
            @else
            <div class="row flex-grow-1">
            @foreach($vacancies as $vacancy)
                <div class="col-sm-6 col-md-6 col-lg-6">
                    <div class="h-100 mlg-bg">
                    <a href="{{ route('frontend.vacancy', ['vacancy' => $vacancy->slug, 'clientSubdomain' => session('client.subdomain')]) }}" class="td-no">
                        <img src="{{parse_encode_url($vacancy->getFirstMediaUrl('vacancy_image', 'summary')) ?? ''}}" onerror="this.style.display='none'">
                        <div class="row no-gutters">
                            <div class="col-12">
                                <div class="article-summary mlg-bg mbh-1">
                                <h4 class="fw700 t20">{{ $vacancy->title }}</h4>
                                <p class="t16 mb-0">{{ Str::limit($vacancy->lead_para, $limit = 100, $end = '...') }}</p>
                                </div>
                            </div>
                        </div>
                    </a>
                    </div>
                </div>
            @endforeach
            </div>
            @endif

    </div>
</div>
