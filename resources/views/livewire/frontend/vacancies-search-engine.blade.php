<div>

    <section class="lg-bg p-w-xl r-sep">
        <div class="row">
            <div class="col text-center">
                <h1 class="fw700 t36 mb-4">Find local jobs and apprenticeships</h1>
            </div>
        </div>

        <div class="row justify-content-center">

            <div class="col-xl-9 col-lg-11">
                <div class="p-4 p-lg-0">

                    <form wire:submit.prevent="submit">

                        <div class="row justify-content-center">
                            <div class="col-12 col-lg mb-3 mb-lg-0">
                                {!! Form::text('keyword', $this->keyword, array('id' => 'keyword', 'placeholder' => 'Enter a keyword','class' => 'form-control form-control-lg mr-sm-4','wire:model.defer' => 'keyword', 'autocomplete' => 'off' )) !!}
                            </div>
                            <div class="col-12 col-lg mb-3 mb-lg-0">
                                {!! Form::label('areas', 'Choose an Area', ['class' => "sr-only"]) !!}
                                {!! Form::select('areas', $this->areaList, null, ['id' => 'area', 'placeholder' => 'Select an area', 'class' => "form-control form-control-lg mr-sm-4", 'wire:model.defer' => "area"]) !!}
                            </div>
                            <div class="col-12 col-lg mb-3 mb-lg-0">
                                {!! Form::label('category', 'Choose a category', ['class' => "sr-only"]) !!}
                                {!! Form::select('category', $this->categoryList, null, ['id' => 'category', 'placeholder' => 'Select an category', 'class' => "form-control form-control-lg mr-sm-2", 'wire:model.defer' => "category"]) !!}
                            </div>

                            <div class="col-12 col-lg mb-3 mb-lg-0">
                                @foreach($jobRoles as $role)
                                    <div class="form-check">
                                        {!! Form::checkbox('job_type[]', $role['uuid'], false, ['class' => 'form-check-input', 'id' => $role['name'], 'wire:model.defer' => "job_type" ]) !!}
                                        <label class="form-check-label" for="{{$role['name']}}">{{$role['name']}}</label>
                                    </div>
                                @endforeach
                            </div>

                            <div class="col-12 col-lg mb-3 mb-lg-0 text-center text-lg-left">
                                <button type="button" wire:click="submit" wire:loading.attr="disabled" class="btn platform-button pb-inv">Search jobs</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>



    <p>We found {{$this->nbVacanciesFound}} @if ($this->nbVacanciesFound <2)vacancy @else vacancies @endif matching your search</p>

    @if ($searchVacanciesResults)

        <div>

            @foreach($searchVacanciesResults as $vacancy)

                <a href="{{route('frontend.vacancy', ['clientSubdomain' => Session::get('fe_client')->subdomain,'vacancy' => $vacancy->slug])}}" class="td-no article-row">
                    <div class="row align-items-center t24">
                        <div class="col-4 col-sm-2 col-lg-2 col-xl-1">
                            <img src="{{parse_encode_url($vacancy->employerImage->getFirstMediaUrl('logo')) ?? ''}}" onerror="this.style.display='none'">
                        </div>
                        <div class="col-8 col-sm-10 col-lg-3 col-xl-4">
                            <div><h3 class="fw700">{{$vacancy->title}}</h3>{{$vacancy->employer->name}}</div>
                        </div>
                        <div class="col-lg-2 col-8 col-sm-auto offset-4 offset-sm-2 offset-lg-0">
                            <i class="fas fa-map-marker mr-2"></i><span class="fw700">{{$vacancy->region->name}}</span>
                        </div>
                        <div class="col-lg-5 col-8 col-sm-auto offset-4 offset-sm-0 offset-lg-0">
                            <div><span class="fw700">{{$vacancy->role->name}}</span><div class="d-none d-sm-inline-block mx-2"> | </div><div class="d-sm-inline-block d-block">Posted {{ \Carbon\Carbon::parse($vacancy->created_at)->diffForHumans() }}</div></div>
                        </div>
                    </div>
                </a>

                <div class="row">
                    <div class="col my-4">
                        <div class="border-top gg-border"></div>
                    </div>
                </div>

            @endforeach

        </div>

        <div class="row">
            <div class="col">
            {{ $searchVacanciesResults->links('livewire.frontend.search-pagination', ['clientSubdomain' => session('fe_client.subdomain')] ) }}
            </div>
        </div>

    @endif


</div>




