@extends('frontend.layouts.master')

@section('content')

<section class="lg-bg r-sep mt-5 rounded vac-banner-bg" style="background-image: url({{ asset('images/vacancies-bg.jpg') }})">
    <div class="vac-banner p-w-xl rounded">
        <div class="row">
            <div class="col text-center">
                <h1 class="fw700 t36 mb-4 t-w">Find local jobs and apprenticeships</h1>
            </div>
        </div>


        <div class="row justify-content-center">
            <div class="col-xl-9 col-lg-11">
                <div class="p-4 p-lg-0">

                    <form method='get' action="{{ route('frontend.find-a-job') }}">

                        <div class="row justify-content-center">
                            <div class="col-12 col-lg mb-3 mb-lg-0">
                                {!! Form::text('keyword', "", array('id' => 'keyword', 'placeholder' => 'Enter a keyword','class' => 'form-control form-control-lg mr-sm-4', 'autocomplete' => 'off' )) !!}
                            </div>
                            <div class="col-12 col-lg mb-3 mb-lg-0">
                                {!! Form::label('area', 'Choose an Area', ['class' => "sr-only"]) !!}
                                {!! Form::select('area', $areaList, null, ['id' => 'area', 'placeholder' => 'Select an area', 'class' => "form-control form-control-lg mr-sm-4"]) !!}
                            </div>
                            <div class="col-12 col-lg mb-3 mb-lg-0">
                                {!! Form::label('category', 'Choose a category', ['class' => "sr-only"]) !!}
                                {!! Form::select('category', $categoryList, null, ['id' => 'category', 'placeholder' => 'Select an category', 'class' => "form-control form-control-lg mr-sm-2"]) !!}
                            </div>
                            {{--
                            <div class="col-12 col-lg mb-3 mb-lg-0">
                                @foreach($jobRoles as $role)
                                    <div class="form-check">
                                        {!! Form::checkbox('job_type[]', $role['uuid'], false, ['class' => 'form-check-input', 'id' => $role['name'] ]) !!}
                                        <label class="form-check-label" for="{{$role['name']}}">{{$role['name']}}</label>
                                    </div>
                                @endforeach
                            </div>
                            --}}
                            <div class="col-12 col-lg mb-3 mb-lg-0 text-center text-lg-left">
                                <button type="submit" class="btn platform-button pb-inv">Search jobs</button>
                            </div>

                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</section>

@if (count($featuredVacancies) > 0)
<div class="row justify-content-center">
    <div class="col text-center">
        <div class="p-ws">
        <h2 class="fw700 t30">Featured job opportunities</h2>
        </div>
    </div>
</div>

<div class="row mb-5">
    @foreach($featuredVacancies as $featuredVacancy)
        <div class="col-lg-3">
            <a href="{{ route('frontend.vacancy', ['vacancy' => $featuredVacancy->slug, 'clientSubdomain' => session('client.subdomain')]) }}" class="article-block-link">
            {{-- <img src="https://via.placeholder.com/1006x670.png?text=Job+Image" class="hp-free-img"> --}}
            <img src="{{parse_encode_url($featuredVacancy->getFirstMediaUrl('vacancy_image', 'summary')) ?? ''}}" onerror="this.style.display='none'" class="hp-free-img" alt="{{$featuredVacancy->getFirstMedia('vacancy_image')->getCustomProperty('alt')}}">
                <div class="w-bg article-summary">
                    <h3 class="t24 fw700">{{$featuredVacancy->title}}</h3>
                    <ul class="list-unstyled">
                        <li>Employer: <b>{{$featuredVacancy->employer->name}}</b></li>
                        <li>Location: <b>{{$featuredVacancy->region->name}}</b></li>
                        <li>Role Type: <b>{{$featuredVacancy->role->name}}</b></li>
                    </ul>
                </div>
            </a>
        </div>
    @endforeach
</div>
@else
<div class="row justify-content-center">
    <div class="col text-center">
        <div class="p-ws">
        <h2 class="fw700 t30">There are currently no job opportunities available</h2>
        </div>
    </div>
</div>
@endif

@if (count($moreVacancies) > 0)
<div class="row">
    <div class="col">
        <h3 class="fw700 t36 mb-5">Jobs and opportunities from your region</h3>
    </div>
</div>


<div>

    <div id="opportunities_vacancies">
        @include('frontend.pages.includes.vacancies.opportunities-vacancies')
    </div>

    <div class="row">
        <div class="col text-center">  {{-- pb-lge"  --}}
            <a id="load_more_button" href="javascript:void(0);" class="platform-button" @if (count($moreVacancies) < 3) style="display:none" @endif>Load more listings</a>
            <p id="no_more_message" style="display:none">There are no more vacancies to load</p>
        </div>
    </div>

</div>
@endif



<div class="row mt-5">
    <div class="col">
        <div class="border-top def-border pt-3 pl-3">
        @if (Auth::guard('web')->check())
            <a href="{{ route('frontend.dashboard') }}" class="fw700 td-no">
        @else
            <a href="/" class="fw700 td-no">
        @endif
        Back to previous page</a>
        </div>
    </div>
</div>
@endsection


@push('scripts')
    <script>

    $(document).ready(function(){

        var offset = 0;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });



        function load_data(offset)
        {
            console.log(offset);
            $.ajax({
                url:"{{ route('frontend.loadMoreVacancies') }}",
                method:"POST",
                data:{offset:offset},
                success:function(data)
                {

                    $('#opportunities_vacancies').append(data.view);

                    if (data.nb_events == {{config('global.vacancies.opportunities_vacancies.load_more_number')}})
                    {
                        $('#load_more_button').html("Load More");
                    } else {
                        $('#load_more_button').hide();
                        $('#no_more_message').show();
                    }

                }
            });

        }


        $(document).on('click', '#load_more_button', function(){
            $(this).html('<b>Loading...</b>');
            offset = offset + {{config('global.vacancies.opportunities_vacancies.load_more_number')}};
            load_data(offset);
        });

    });
    </script>
@endpush
