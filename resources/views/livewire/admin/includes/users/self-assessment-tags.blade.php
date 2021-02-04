<div id="sa-tags" class="tab-pane fade">
    <div class="row">
        <div class="col-lg-4">
{{--
            <div class="form-group{{ $errors->has('tagsLscs') ? ' has-error' : '' }}">
                {!! Form::label('tagsLscs', 'Careers Readiness Score'); !!}

                @foreach($tagsLscs as $tag)
                <div class="form-check">
                {!! Form::checkbox('tagsLscs[]', $tag->name, ($userLscsTags->where("id", $tag->id)->where("type", 'lscs'))->count() == 1 ? true : false, ['class' => 'form-check-input', 'id' => $tag->name]) !!}
                <label class="form-check-label" for="{{$tag->name}}">
                {{$tag->name}}
                </label>
                </div>
                @endforeach

            </div>

            <div class="form-group{{ $errors->has('tagsRoutes') ? ' has-error' : '' }}">
                {!! Form::label('tagsRoutes', 'Routes'); !!}

                @foreach($tagsRoutes as $tag)
                <div class="form-check">
                {!! Form::checkbox('tagsRoutes[]', $tag->name, ($userRouteTags->where("id", $tag->id)->where("type", 'route'))->count() == 1 ? true : false, ['class' => 'form-check-input', 'id' => $tag->name]) !!}
                <label class="form-check-label" for="{{$tag->name}}">
                {{$tag->name}}
                </label>
                </div>
                @endforeach

            </div>

        </div>
        <div class="col-lg-4">

            <div class="form-group{{ $errors->has('tagsSubjects') ? ' has-error' : '' }}">
                {!! Form::label('tagsSubjects', 'Subject Tags'); !!}

                @foreach($tagsSubjects as $tag)
                <div class="form-check">
                {!! Form::checkbox('tagsSubjects[]', $tag->name, ($userSubjectTags->where("id", $tag->id)->where("type", 'subject'))->count() == 1 ? true : false, ['class' => 'form-check-input', 'id' => $tag->name]) !!}
                <label class="form-check-label" for="{{$tag->name}}">
                {{$tag->name}}
                </label>
                </div>
                @endforeach

            </div>

        </div>
        <div class="col-lg-4">

            <div class="form-group{{ $errors->has('tagsSectors') ? ' has-error' : '' }}">
                {!! Form::label('tagsSectors', 'Sector'); !!}

                @foreach($tagsSectors as $tag)
                <div class="form-check">
                {!! Form::checkbox('tagsSectors[]', $tag->name, ($userSectorTags->where("id", $tag->id)->where("type", 'sector'))->count() == 1 ? true : false, ['class' => 'form-check-input', 'id' => $tag->name]) !!}
                <label class="form-check-label" for="{{$tag->name}}">
                {{$tag->name}}
                </label>
                </div>
                @endforeach

            </div>
--}}
        </div>
    </div>
</div>
