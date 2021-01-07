<div id="filters" class="tab-pane @if ($activeTab == "filters") active @else fade @endif">
    <div class="row">
        <div class="col-lg-6">


        <div class="form-group">
            {!! Form::label('tagsYearGroups', 'Year Groups'); !!}

            @foreach($tagsYearGroups as $tag)
                <div class="form-check">
                {!! Form::checkbox('tagsYearGroups[]', $tag['name'][app()->getLocale()], false, ['class' => 'form-check-input', 'id' => $tag['name'][app()->getLocale()], 'wire:model.lazy' => 'contentYearGroupsTags' ]) !!}
                <label class="form-check-label" for="{{$tag['name'][app()->getLocale()]}}">
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
                {!! Form::checkbox('tagsLscs[]', $tag['name'][app()->getLocale()], false, ['class' => 'form-check-input', 'id' => $tag['name'][app()->getLocale()], 'wire:model.lazy' => 'contentLscsTags' ]) !!}
                <label class="form-check-label" for="{{$tag['name'][app()->getLocale()]}}">
                {{$tag['name'][app()->getLocale()]}}
                </label>
                </div>
            @endforeach
        </div>
        <hr>
        <div class="form-group">
            {!! Form::label('tagsRoutes', 'Routes'); !!}

            @foreach($tagsRoutes as $tag)
                <div class="form-check">
                {!! Form::checkbox('tagsRoutes[]', $tag['name'][app()->getLocale()], false, ['class' => 'form-check-input', 'id' => $tag['name'][app()->getLocale()], 'wire:model.lazy' => 'contentRoutesTags' ]) !!}
                <label class="form-check-label" for="{{$tag['name'][app()->getLocale()]}}">
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
                {!! Form::checkbox('tagsSectors[]', $tag['name'][app()->getLocale()], false, ['class' => 'form-check-input', 'id' => $tag['name'][app()->getLocale()], 'wire:model.lazy' => 'contentSectorsTags' ]) !!}
                <label class="form-check-label" for="{{$tag['name'][app()->getLocale()]}}">
                {{$tag['name'][app()->getLocale()]}}
                </label>
                </div>
            @endforeach

        </div>
        <hr>
        <div class="form-group">
            {!! Form::label('tagsSubjects', 'Subjects'); !!}

            @foreach($tagsSubjects as $tag)
                <div class="form-check">
                {!! Form::checkbox('tagsSubjects[]', $tag['name'][app()->getLocale()], false, ['class' => 'form-check-input', 'id' => $tag['name'][app()->getLocale()], 'wire:model' => 'contentSubjectTags' ]) !!}
                <label class="form-check-label" for="{{$tag['name'][app()->getLocale()]}}">
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
                {!! Form::checkbox('tagsFlags[]', $tag['name'][app()->getLocale()], false, ['class' => 'form-check-input', 'id' => $tag['name'][app()->getLocale()], 'wire:model' => 'contentFlagTags' ]) !!}
                <label class="form-check-label" for="{{$tag['name'][app()->getLocale()]}}">
                {{$tag['name'][app()->getLocale()]}}
                </label>
                </div>
            @endforeach

        </div>


        </div>
    </div>
</div>
