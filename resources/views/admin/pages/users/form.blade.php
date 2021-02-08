{{--<div>

    <ul class="nav nav-tabs mydir-tabs" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" data-toggle="tab" href="#user-details">User details</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" href="#additional-info">Additional information</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" href="#institution">Institution</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" href="#sa-tags">Self assessment tags</a>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">




        <div id="additional-info" class="tab-pane fade">
            <div class="row">
                <div class="col-lg-6">

                    <div class="form-group">
                        {!! Form::label('roni', 'RONI (Risk of NEET indicator)'); !!}
                        {!! Form::text('roni', null, array('placeholder' => 'RONI (Risk of NEET indicator)','class' => 'form-control')) !!}
                    </div>

                    <div class="form-group mb-3">
                        {!! Form::label('rodi', 'RODI (Risk of Dropping out indicator)'); !!}
                        {!! Form::text('rodi', null, array('placeholder' => 'RODI (Risk of Dropping out indicator)','class' => 'form-control')) !!}
                    </div>

                    <hr>

                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" value="" id="neet-1618">
                        <label class="form-check-label" for="neet-1618">
                            NEET 16-18
                        </label>
                    </div>

                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" value="" id="neet-18plus">
                        <label class="form-check-label" for="neet-18plus">
                            NEET 18+
                        </label>
                    </div>

                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" value="" id="below-level-2">
                        <label class="form-check-label" for="below-level-2">
                            Below Level 2
                        </label>
                    </div>

                </div>
            </div>
        </div>

        <div id="institution" class="tab-pane fade">
            <div class="row">
                <div class="col-lg-6">

                    <div class="form-group">
                        {!! Form::label('institution_id', 'Institution ID'); !!}
                        {!! Form::text('institution_id', 1, array('class' => 'form-control')) !!}
                    </div>

                    <div class="form-group">
                        <label for="client_name">Set client</label>
                        <select class="form-control" wire:model.lazy="client_name" id="client_name" name="client_name">
                            <option value="Please select">Please select</option>
                            <option value="Client name A">Client name A</option>
                            <option value="Client name B">Client name B</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="inst_name">Set institution</label>
                        <select class="form-control" wire:model.lazy="inst_name" id="inst_name" name="inst_name">
                            <option value="Please select">Please select</option>
                            <option value="Institution name A">Institution name A</option>
                            <option value="Institution name B">Institution name B</option>
                        </select>
                    </div>

                    <div class="form-inline">
                            <label class="mr-2">Adviser:</label>[Adviser Name]
                    </div>

                </div>
            </div>
        </div>

        <div id="sa-tags" class="tab-pane fade">
            <div class="row">
                <div class="col-lg-4">

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

                </div>
            </div>
        </div>

    </div>




</div>



        <hr>
        <button type="submit" class="btn mydir-button">Save User Details</button>





@push('scripts')
<script>

    $(function () {
        $('[data-mask]').inputmask();
    });

</script>
@endpush
--}}
