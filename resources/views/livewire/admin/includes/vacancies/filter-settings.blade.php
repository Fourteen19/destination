<div id="filter-settings" class="tab-pane px-0 @if ($activeTab == "filter-settings") active @else fade @endif" wire:key="filter-settings-pane">
    <div class="row">
        <div class="col-lg-3">


            <div class="form-group">
                {!! Form::label('tagsYearGroups', 'Year Groups', ['class' => 'filter-header']); !!}

                <div class="form-check form-select-all">
                    {!! Form::checkbox('all_years', true, false, ['class' => 'form-check-input', 'id' => 'all_years', 'wire:model' => 'allYears' ]) !!}
                    <label class="form-check-label" for="all_years">All years</label>
                </div>

                @foreach($tagsYearGroups as $tag)
                    <div class="form-check">
                    <input class="form-check-input" id="{{$tag['uuid']}}" @if ($allYears) disabled @endif wire:model.defer="vacancyYearGroupsTags" name="tagsYearGroups[]" type="checkbox" value="{{$tag['name'][app()->getLocale()]}}">
                    <label class="form-check-label" for="{{$tag['uuid']}}">
                        {{$tag['name'][app()->getLocale()]}}
                    </label>

                    </div>
                @endforeach

            </div>
            <hr>
            <div class="form-group">
                {!! Form::label('tagsTerms', 'Terms', ['class' => 'filter-header']); !!}

                <div class="form-check form-select-all">
                    {!! Form::checkbox('all_terms', true, false, ['class' => 'form-check-input', 'id' => 'all_terms', 'wire:model' => 'allTerms' ]) !!}
                    <label class="form-check-label" for="all_terms">All terms</label>
                </div>

                @foreach($tagsTerms as $tag)
                    <div class="form-check">
                    <input class="form-check-input" id="{{$tag['uuid']}}" @if ($allTerms) disabled @endif wire:model.defer="vacancyTermsTags" name="tagsTerms[]" type="checkbox" value="{{$tag['name'][app()->getLocale()]}}">
                    <label class="form-check-label" for="{{$tag['uuid']}}">
                        {{$tag['name'][app()->getLocale()]}}
                    </label>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-lg-3">
        <div class="form-group">
            {!! Form::label('tagsLscs', 'Careers Readiness Score', ['class' => 'filter-header']); !!}

            @foreach($tagsLscs as $tag)
                <div class="form-check">
                {!! Form::checkbox('tagsLscs[]', $tag['name'][app()->getLocale()], false, ['class' => 'form-check-input', 'id' => $tag['uuid'], 'wire:model.defer' => 'vacancyLscsTags' ]) !!}
                <label class="form-check-label" for="{{$tag['uuid']}}">
                {{$tag['name'][app()->getLocale()]}}
                </label>
                </div>
            @endforeach
        </div>
        <hr>

        <div class="form-group">
            {!! Form::label('tagsSubjects', 'Subjects', ['class' => 'filter-header']); !!}

            @foreach($tagsSubjects as $tag)
                <div class="form-check">
                {!! Form::checkbox('tagsSubjects[]', $tag['name'][app()->getLocale()], false, ['class' => 'form-check-input', 'id' => $tag['uuid'], 'wire:model.defer' => 'vacancySubjectTags' ]) !!}
                <label class="form-check-label" for="{{$tag['uuid']}}">
                {{$tag['name'][app()->getLocale()]}}
                </label>
                </div>
            @endforeach

        </div>

    </div>
    <div class="col-lg-3">
        <div class="form-group">
            {!! Form::label('tagsRoutes', 'Routes', ['class' => 'filter-header']); !!}

            @foreach($tagsRoutes as $tag)
                <div class="form-check">
                {!! Form::checkbox('tagsRoutes[]', $tag['name'][app()->getLocale()], false, ['class' => 'form-check-input', 'id' => $tag['uuid'], 'wire:model.defer' => 'vacancyRoutesTags' ]) !!}
                <label class="form-check-label" for="{{$tag['uuid']}}">
                {{$tag['name'][app()->getLocale()]}}
                </label>
                </div>
            @endforeach

        </div>
        <hr>
        <div class="form-group">
            {!! Form::label('tagsSectors', 'Sectors', ['class' => 'filter-header']); !!}

            @foreach($tagsSectors as $tag)
                <div class="form-check">
                {!! Form::checkbox('tagsSectors[]', $tag['name'][app()->getLocale()], false, ['class' => 'form-check-input', 'id' => $tag['uuid'], 'wire:model.defer' => 'vacancySectorsTags' ]) !!}
                <label class="form-check-label" for="{{$tag['uuid']}}">
                {{$tag['name'][app()->getLocale()]}}
                </label>
                </div>
            @endforeach

        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            {!! Form::label('tagsNeet', 'NEET', ['class' => 'filter-header']); !!}

            @foreach($tagsNeet as $tag)
                <div class="form-check">
                {!! Form::checkbox('tagsNeet[]', $tag['name'][app()->getLocale()], false, ['class' => 'form-check-input', 'id' => $tag['uuid'], 'wire:model.defer' => 'vacancyNeetTags' ]) !!}
                <label class="form-check-label" for="{{$tag['uuid']}}">
                {{$tag['name'][app()->getLocale()]}}
                </label>
                </div>
            @endforeach
        </div>

        <hr>
        <div class="form-group">
            {!! Form::label('tagsFlags', 'Other Content Flags', ['class' => 'filter-header']); !!}

            @foreach($tagsFlags as $tag)
                <div class="form-check">
                {!! Form::checkbox('tagsFlags[]', $tag['name'][app()->getLocale()], false, ['class' => 'form-check-input', 'id' => $tag['uuid'], 'wire:model.defer' => 'vacancyFlagTags' ]) !!}
                <label class="form-check-label" for="{{$tag['uuid']}}">
                {{$tag['name'][app()->getLocale()]}}
                </label>
                </div>
            @endforeach

        </div>


        </div>
    </div>
    </div>
