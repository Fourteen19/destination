@extends('frontend.layouts.master')

@section('content')

Employers

    <div class="company-letters">
        @foreach( range('A', 'Z') as $element)
            <a href="#{{$element}}">{{$element}}</a>
        @endforeach
    </div>


    <ul>
        @foreach( range('A', 'Z') as $element)
            @if (isset($companies_list[$element]))
                @if (count($companies_list[$element]) > 0)
                    <li>
                        <div id="{{$element}}" class="">{{$element}}</div>
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

@endsection
