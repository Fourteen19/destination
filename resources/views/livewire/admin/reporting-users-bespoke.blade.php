<div>

    <div class="form-group mb-4" wire:ignore>
        <label for="institution">Filter by Institution</label>
        <select class="form-control" id="institution" name="institution" wire:model="institution">
            <option value="">Please Select</option>
            @if (  adminHasRole(Auth::guard('admin')->user(), config('global.admin_user_type.Advisor')) )
                <option value="all">All My Institutions</option>
            @endif
            @foreach($institutionsList as $key => $institution)
                <option value="{{$institution->uuid}}">{{$institution->name}}</option>
            @endforeach
        </select>
    </div>



    <div class="form-group">
        {!! Form::label('tagsYearGroups', 'Year Groups', ['class' => 'filter-header']); !!}

        <div class="form-check form-select-all">
            {!! Form::checkbox('all_years', true, false, ['class' => 'form-check-input', 'id' => 'all_years', 'wire:model' => 'allYears' ]) !!}
            <label class="form-check-label" for="all_years">All years</label>
        </div>

        @foreach($tagsYearGroups as $tag)
            <div class="form-check">
            <input class="form-check-input" id="{{$tag['uuid']}}" @if ($allYears) disabled @endif wire:model.defer="tagsYearGroupsSelected" name="tagsYearGroups[]" type="checkbox" value="{{$tag['name'][app()->getLocale()]}}">
            <label class="form-check-label" for="{{$tag['uuid']}}">
                @if ($tag['name'][app()->getLocale()] != 14) {{$tag['name'][app()->getLocale()]}} @else Post @endif
            </label>

            </div>
        @endforeach

    </div>



    <div class="form-group">
        {!! Form::label('tagsLscs', 'Careers Readiness Score', ['class' => 'filter-header']); !!}

        <div class="form-check form-select-all">
            {!! Form::checkbox('all_crs_years', true, false, ['class' => 'form-check-input', 'id' => 'all_crs_years', 'wire:model' => 'allCrsYears' ]) !!}
            <label class="form-check-label" for="all_crs_years">All CRS scrores</label>
        </div>

        @foreach($tagsLscs as $tag)
            <div class="form-check">
                <input class="form-check-input" id="{{$tag['uuid']}}" @if ($allCrsYears) disabled @endif wire:model.defer="tagsLscsSelected" name="tagsLscs[]" type="checkbox" value="{{$tag['name'][app()->getLocale()]}}">
                <label class="form-check-label" for="{{$tag['uuid']}}">{{$tag['name'][app()->getLocale()]}}</label>
            </div>
        @endforeach
    </div>






    <div class="form-group">
        {!! Form::label('tagsSubjects', 'Subjects', ['class' => 'filter-header']); !!}

        @foreach($tagsSubjects as $tag)
            <div class="form-check">
                {!! Form::checkbox('tagsSubjects[]', $tag['name'][app()->getLocale()], false, ['class' => 'form-check-input', 'id' => $tag['uuid'], 'wire:model' => 'tagsSubjectsSelected' ]) !!}
                <label class="form-check-label" for="{{$tag['uuid']}}">{{$tag['name'][app()->getLocale()]}}</label>
            </div>
        @endforeach

    </div>



    <div class="form-group">
        {!! Form::label('tagsRoutes', 'Routes', ['class' => 'filter-header']); !!}

        @foreach($tagsRoutes as $tag)
            <div class="form-check">
                {!! Form::checkbox('tagsRoutes[]', $tag['name'][app()->getLocale()], false, ['class' => 'form-check-input', 'id' => $tag['uuid'], 'wire:model' => 'tagsRoutesSelected' ]) !!}
                <label class="form-check-label" for="{{$tag['uuid']}}">{{$tag['name'][app()->getLocale()]}}</label>
            </div>
        @endforeach

    </div>



    <div class="form-group">
        {!! Form::label('tagsSectors', 'Sectors', ['class' => 'filter-header']); !!}

        @foreach($tagsSectors as $tag)
            <div class="form-check">
                {!! Form::checkbox('tagsSectors[]', $tag['name'][app()->getLocale()], false, ['class' => 'form-check-input', 'id' => $tag['uuid'], 'wire:model' => 'tagsSectorsSelected' ]) !!}
                <label class="form-check-label" for="{{$tag['uuid']}}">{{$tag['name'][app()->getLocale()]}}</label>
            </div>
        @endforeach

    </div>




    <div class="form-group">
        {!! Form::label('cvCompleted', 'CV Builder Completed', ['class' => 'filter-header']); !!}
        <select class="form-control" id="cv_completed" name="cv_completed" wire:model="cvCompleted">
            @foreach($yesNoOptions as $optionValue => $optionLabel)
                <option value="{{$optionValue}}">{{$optionLabel}}</option>
            @endforeach
        </select>

    </div>




    <div class="form-group">
        {!! Form::label('red_flag', 'Red Flag', ['class' => 'filter-header']); !!}
        <select class="form-control" id="red_flag" name="red_flag" wire:model="redFlag">
            @foreach($yesNoOptions as $optionValue => $optionLabel)
                <option value="{{$optionValue}}">{{$optionLabel}}</option>
            @endforeach
        </select>

    </div>

    @if ($displayExportButtons == 1)

        <button type="button" class="btn mydir-button" wire:click="checkResults" wire:loading.attr="disabled">Check results</button>

        <h3 class="mt-4 border-top pt-4">
            <span wire:loading.delay wire:target="checkResults">Processing...Please wait</span>
            <span wire:loading.remove wire:target="checkResults">{{$resultsPreviewMessage}}</span>
        </h3>

        <button type="button" class="btn mydir-button"  wire:click="generate" wire:loading.attr="disabled">Generate and send report</button>

        <h3 class="mt-4 border-top pt-4">
            <span wire:loading.delay wire:target="generate">Processing...Please wait</span>
            <span wire:loading.remove wire:target="generate">{{$message}}</span>
        </h3>

    @endif

</div>
