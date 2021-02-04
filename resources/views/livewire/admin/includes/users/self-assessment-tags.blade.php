<div id="sa-tags" class="tab-pane fade">
    <div class="row">
        <div class="col-lg-4">

            <div class="form-group{{ $errors->has('tagsLscs') ? ' has-error' : '' }}">
                {!! Form::label('tagsLscs', 'Careers Readiness Score'); !!}

                @foreach($tagsLscs as $tag)
                <div class="form-check">
                    {!! Form::checkbox('tagsLscs[]', $tag['name'][app()->getLocale()], false, ['class' => 'form-check-input', 'id' => $tag['uuid'], 'wire:model.defer' => 'usertagsLscs' ]) !!}
                    <label class="form-check-label" for="{{$tag['uuid']}}">{{$tag['name'][app()->getLocale()]}}</label>
                </div>
                @endforeach

            </div>



            <div class="form-group{{ $errors->has('tagsRoutes') ? ' has-error' : '' }}">
                {!! Form::label('tagsRoutes', 'Routes'); !!}

                @foreach($tagsRoutes as $tag)
                <div class="form-check">
                    {!! Form::checkbox('tagsRoutes[]', $tag['name'][app()->getLocale()], false, ['class' => 'form-check-input', 'id' => $tag['uuid'], 'wire:model.defer' => 'usertagsRoutes' ]) !!}
                    <label class="form-check-label" for="{{$tag['uuid']}}">{{$tag['name'][app()->getLocale()]}}</label>
                </div>
                @endforeach

            </div>

        </div>
        <div class="col-lg-4">

            <div class="form-group{{ $errors->has('tagsSubjects') ? ' has-error' : '' }}">
                {!! Form::label('tagsSubjects', 'Subject Tags'); !!}

                @foreach($tagsSubjects as $tag)
                <div class="form-check">
                    {!! Form::checkbox('tagsSubjects[]', $tag['name'][app()->getLocale()], false, ['class' => 'form-check-input', 'id' => $tag['uuid'], 'wire:model.defer' => 'usertagsSectors' ]) !!}
                    <label class="form-check-label" for="{{$tag['uuid']}}">{{$tag['name'][app()->getLocale()]}}</label>
                </div>
                @endforeach

            </div>

        </div>
        <div class="col-lg-4">

            <div class="form-group{{ $errors->has('tagsSectors') ? ' has-error' : '' }}">
                {!! Form::label('tagsSectors', 'Sector'); !!}

                @foreach($tagsSectors as $tag)
                <div class="form-check">
                    {!! Form::checkbox('tagsSectors[]', $tag['name'][app()->getLocale()], false, ['class' => 'form-check-input', 'id' => $tag['uuid'], 'wire:model.defer' => 'usertagsSectors' ]) !!}
                    <label class="form-check-label" for="{{$tag['uuid']}}">{{$tag['name'][app()->getLocale()]}}</label>
                </div>
                @endforeach

            </div>

        </div>
    </div>
</div>
