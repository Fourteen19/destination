<div id="filters" class="tab-pane @if ($activeTab == "filters") active @else fade @endif" wire:key="filters-pane">
    <div class="row">
        <div class="col-lg-4">


        <div class="form-group">
            {!! Form::label('tagsYearGroups', 'Year Groups'); !!}

            @foreach($tagsYearGroups as $tag)
                <div class="form-check">
                {{-- {!! Form::checkbox('tagsYearGroups[]', $tag['name'][app()->getLocale()], false, ['class' => 'form-check-input year-tag', 'id' => $tag['uuid'], 'disabled' => 0, 'wire:model.defer' => 'contentYearGroupsTags' ]) !!}
                <label class="form-check-label" for="{{$tag['uuid']}}">
                {{$tag['name'][app()->getLocale()]}}
                </label> --}}
                <input class="form-check-input year-tag" id="{{$tag['uuid']}}" @if ($allYears) disabled @endif wire:model.defer="contentYearGroupsTags" name="tagsYearGroups[]" type="checkbox" value="{{$tag['name'][app()->getLocale()]}}">
                <label class="form-check-label" for="{{$tag['uuid']}}">
                    {{$tag['name'][app()->getLocale()]}}
                </label>

                </div>
            @endforeach
            <hr>
            <div class="form-check">
                {!! Form::checkbox('all_years', true, false, ['class' => 'form-check-input', 'id' => 'all_years', 'wire:model' => 'allYears' ]) !!}
                <label class="form-check-label" for="all_years">All years</label>
            </div>
        </div>
        <hr>
        <div class="form-group">
            {!! Form::label('tagsTerms', 'Terms'); !!}

            @foreach($tagsTerms as $tag)
                <div class="form-check">
                {!! Form::checkbox('tagsTerms[]', $tag['name'][app()->getLocale()], false, ['class' => 'form-check-input', 'id' => $tag['uuid'], 'wire:model.defer' => 'contentTermsTags' ]) !!}
                <label class="form-check-label" for="{{$tag['uuid']}}">
                {{$tag['name'][app()->getLocale()]}}
                </label>
                </div>
            @endforeach
        </div>
        <hr>
        <div class="form-group">
            {!! Form::label('tagsLscs', 'Careers Readiness Score'); !!}

            @foreach($tagsLscs as $tag)
                <div class="form-check">
                {!! Form::checkbox('tagsLscs[]', $tag['name'][app()->getLocale()], false, ['class' => 'form-check-input', 'id' => $tag['uuid'], 'wire:model.defer' => 'contentLscsTags' ]) !!}
                <label class="form-check-label" for="{{$tag['uuid']}}">
                {{$tag['name'][app()->getLocale()]}}
                </label>
                </div>
            @endforeach
        </div>
        <hr>
        <div class="form-group">
            {!! Form::label('tagsNeet', 'NEET'); !!}

            @foreach($tagsNeet as $tag)
                <div class="form-check">
                {!! Form::checkbox('tagsNeet[]', $tag['name'][app()->getLocale()], false, ['class' => 'form-check-input', 'id' => $tag['uuid'], 'wire:model.defer' => 'contentNeetTags' ]) !!}
                <label class="form-check-label" for="{{$tag['uuid']}}">
                {{$tag['name'][app()->getLocale()]}}
                </label>
                </div>
            @endforeach
        </div>

    </div>
    <div class="col-lg-4">
        <div class="form-group">
            {!! Form::label('tagsRoutes', 'Routes'); !!}

            @foreach($tagsRoutes as $tag)
                <div class="form-check">
                {!! Form::checkbox('tagsRoutes[]', $tag['name'][app()->getLocale()], false, ['class' => 'form-check-input', 'id' => $tag['uuid'], 'wire:model.defer' => 'contentRoutesTags' ]) !!}
                <label class="form-check-label" for="{{$tag['uuid']}}">
                {{$tag['name'][app()->getLocale()]}}
                </label>
                </div>
            @endforeach

        </div>
        <hr>
        <div class="form-group">
            {!! Form::label('tagsSectors', 'Sectors'); !!}

            @foreach($tagsSectors as $tag)
                <div class="form-check">
                {!! Form::checkbox('tagsSectors[]', $tag['name'][app()->getLocale()], false, ['class' => 'form-check-input', 'id' => $tag['uuid'], 'wire:model.defer' => 'contentSectorsTags' ]) !!}
                <label class="form-check-label" for="{{$tag['uuid']}}">
                {{$tag['name'][app()->getLocale()]}}
                </label>
                </div>
            @endforeach

        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-group">
            {!! Form::label('tagsSubjects', 'Subjects'); !!}

            @foreach($tagsSubjects as $tag)
                <div class="form-check">
                {!! Form::checkbox('tagsSubjects[]', $tag['name'][app()->getLocale()], false, ['class' => 'form-check-input', 'id' => $tag['uuid'], 'wire:model.defer' => 'contentSubjectTags' ]) !!}
                <label class="form-check-label" for="{{$tag['uuid']}}">
                {{$tag['name'][app()->getLocale()]}}
                </label>
                </div>
            @endforeach

        </div>
        <hr>
        <div class="form-group">
            {!! Form::label('tagsFlags', 'Other Content Flags'); !!}

            @foreach($tagsFlags as $tag)
                <div class="form-check">
                {!! Form::checkbox('tagsFlags[]', $tag['name'][app()->getLocale()], false, ['class' => 'form-check-input', 'id' => $tag['uuid'], 'wire:model.defer' => 'contentFlagTags' ]) !!}
                <label class="form-check-label" for="{{$tag['uuid']}}">
                {{$tag['name'][app()->getLocale()]}}
                </label>
                </div>
            @endforeach

        </div>


        </div>
    </div>
</div>

@push('scripts')
<script>


    /* document.getElementById('all_years').onclick = function() {

        if ( this.checked ) {
            $(".year-tag").prop("checked", "checked");
            $(".year-tag").prop("disabled", "true");
            Livewire.emit('all_years_on')
        } else {
            $(".year-tag").prop("disabled", "");
            Livewire.emit('all_years_off')
        }
    }; */
    /* alert(2);
    if ($('#all_years').is(":checked"))
    {
        alert(1);
       // $(".year-tag").prop("disabled", "true");
    } */


</script>
@endpush
