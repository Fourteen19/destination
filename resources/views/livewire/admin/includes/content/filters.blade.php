<div id="filters" class="tab-pane @if ($activeTab == "filters") active @else fade @endif" wire:key="filters-pane">
    <div class="row">
        <div class="col-lg-4">


        <div class="form-group">
            {!! Form::label('tagsYearGroups', 'Year Groups'); !!}

            @foreach($tagsYearGroups as $tag)
                <div class="form-check">
                {!! Form::checkbox('tagsYearGroups[]', $tag['name'][app()->getLocale()], false, ['class' => 'form-check-input', 'id' => $tag['uuid'], 'wire:model.defer' => 'contentYearGroupsTags', 'onclick' => 'javascript:yearSelected();' ]) !!}
                <label class="form-check-label" for="{{$tag['uuid']}}">
                {{$tag['name'][app()->getLocale()]}}
                </label>
                </div>
            @endforeach
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

function yearSelected()
{
    {{-- compiles the list of years selected --}}
    var tagsYearGroups = [];
    $.each($("input[name='tagsYearGroups[]']:checked"), function(){
        tagsYearGroups.push($(this).val());
    });

    Livewire.emit("yearSelected", tagsYearGroups);

}


document.addEventListener("DOMContentLoaded", function() {
    yearSelected();
});

</script>
@endpush
