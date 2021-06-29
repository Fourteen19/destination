@extends('frontend.layouts.master')

@section('content')

<section class="lg-bg p-w-xl r-sep">
    <div class="row">
        <div class="col text-center">
            <h1 class="fw700 t36 mb-4">Find local jobs and apprenticeships</h1>
        </div>
    </div>

    @livewire('frontend.vacancies-search-engine')

</section>

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
            {{-- <a href="#" class="article-block-link"> --}}
            <a href="{{ route('frontend.vacancy', ['vacancy' => $featuredVacancy->slug, 'clientSubdomain' => session('client.subdomain')]) }}" class="article-block-link">
            {{-- <img src="https://via.placeholder.com/1006x670.png?text=Job+Image" class="hp-free-img"> --}}
            <img src="{{parse_encode_url($featuredVacancy->getFirstMediaUrl('vacancy_image')) ?? ''}}" onerror="this.style.display='none'" class="hp-free-img">
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
