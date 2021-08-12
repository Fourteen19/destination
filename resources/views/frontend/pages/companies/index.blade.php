@extends('frontend.layouts.master')

@section('content')

<div class="row mt-5 mb-3">
    <div class="col-xl-7 col-lg-6 mb-4 mb-xl-0">
        <div class="pt-4">
            <h1 class="fw700 t36 mb-4">Employers</h1>
            <p>Below you will find a list of employers who currently have vacancies listed on MyDirections.</p>
        </div>
    </div>
</div>

<div class="row company-letters">
    <div class="col-12">
        <ul class="list-inline border-bottom pb-3">
            @foreach( range('A', 'Z') as $element)
            <li class="list-inline-item"><a href="#{{$element}}">{{$element}}</a></li>
            @endforeach
        </ul>
    </div>
</div>


<div class="row">
    <div class="col-12">
        <ul class="list-unstyled list-columns">
            @foreach( range('A', 'Z') as $element)
                @if (isset($companies_list[$element]))
                    @if (count($companies_list[$element]) > 0)
                        <li>
                            <div id="{{$element}}" class="fw700 t20">{{$element}}</div>
                            <ul>
                                @if (isset($companies_list[$element]))
                                    @foreach($companies_list[$element] as $company)
                                        <li><a href="{{ route('frontend.company', ['company' => $company->slug ])}}">{{$company->name}} ({{$company->nb_vacancies}})</a></li>
                                    @endforeach
                                @endif
                            </ul>
                        </li>
                    @endif
                @endif
            @endforeach
        </ul>
    </div>
</div>


<div class="row mt-5">
    <div class="col">
        <div class="border-top def-border pt-3 pl-3">
            <a href="{{ route('frontend.vacancies') }}" class="fw700 td-no">Back to Vacancies</a>
        </div>
    </div>
</div>

@endsection
