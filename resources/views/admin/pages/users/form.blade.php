<div class="row">

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            {!! Form::label('system_id', 'System  ID'); !!}
            {{ $user->system_id }}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            {!! Form::label('first_name', 'First Name'); !!}
            {!! Form::text('first_name', null, array('placeholder' => 'First Name','class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            {!! Form::label('last_name', 'Last Name'); !!}
            {!! Form::text('last_name', null, array('placeholder' => 'Last Name','class' => 'form-control')) !!}
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            {!! Form::label('birth_date', 'Date of Birth'); !!}
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
            </div>
            {!! Form::text('birth_date', null, array('class' => 'form-control', 'data-inputmask-alias' => "datetime", 'data-inputmask-inputformat' => "dd/mm/yyyy", 'data-mask' => "", 'im-insert'=>"false")) !!}
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            {!! Form::label('school_year', 'School Year'); !!}
            {!! Form::select('school_year', ['7'=>'7', '8'=>'8', '9'=>'9', '10'=>'10', '11'=>'11', '12'=>'12', '13'=>'13', '14'=>'post'], array('placeholder' => 'School Year','class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            {!! Form::label('postcode', 'Postcode'); !!}
            {!! Form::text('postcode', null, array('placeholder' => 'Postcode','class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            {!! Form::label('email', 'School Email Address'); !!}
            {!! Form::text('email', null, array('placeholder' => 'School Email Address','class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            {!! Form::label('personal_email', 'Personal Email Address'); !!}
            {!! Form::text('personal_email', null, array('placeholder' => 'Personal Email Address','class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            {!! Form::label('password', 'Password'); !!}
            {!! Form::password('password', array('placeholder' => 'Password', 'autocomplete' =>"off", 'class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            {!! Form::label('confirm-password', 'Confirm Password'); !!}
            {!! Form::password('confirm-password', array('placeholder' => 'Confirm Password', 'autocomplete' =>"off", 'class' => 'form-control'))
            !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            {!! Form::label('roni', 'RONI (Risk of NEET indicator)'); !!}
            {!! Form::text('roni', null, array('placeholder' => 'RONI (Risk of NEET indicator)','class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            {!! Form::label('rodi', 'RODI (Risk of Dropping out indicator)'); !!}
            {!! Form::text('rodi', null, array('placeholder' => 'RODI (Risk of Dropping out indicator)','class' => 'form-control')) !!}
        </div>
    </div>


    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            {!! Form::label('institution_id', 'institution id'); !!}
            {!! Form::text('institution_id', 1, array('class' => 'form-control')) !!}
        </div>
    </div>


    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group{{ $errors->has('tagsSubjects') ? ' has-error' : '' }}">
            {!! Form::label('tagsSubjects', 'Subject Tags'); !!}

            @foreach($tagsSubjects as $tag)
                <label>{!! Form::checkbox('tagsSubjects[]', $tag->name, ($userSubjectTags->where("id", $tag->id)->where("type", 'subject'))->count() == 1 ? true : false, ['class' => 'form-control', 'id' => $tag->name]) !!} {{$tag->name}}</label>
            @endforeach

        </div>
    </div>


    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group{{ $errors->has('tagsLscs') ? ' has-error' : '' }}">
            {!! Form::label('tagsLscs', 'Lscs'); !!}

            @foreach($tagsLscs as $tag)
                <label>{!! Form::checkbox('tagsLscs[]', $tag->name, ($userLscsTags->where("id", $tag->id)->where("type", 'lscs'))->count() == 1 ? true : false, ['class' => 'form-control', 'id' => $tag->name]) !!} {{$tag->name}}</label>
            @endforeach

        </div>
    </div>


    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group{{ $errors->has('tagsRoutes') ? ' has-error' : '' }}">
            {!! Form::label('tagsRoutes', 'Routes'); !!}

            @foreach($tagsRoutes as $tag)
                <label>{!! Form::checkbox('tagsRoutes[]', $tag->name, ($userRouteTags->where("id", $tag->id)->where("type", 'route'))->count() == 1 ? true : false, ['class' => 'form-control', 'id' => $tag->name]) !!} {{$tag->name}}</label>
            @endforeach

        </div>
    </div>


    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group{{ $errors->has('tagsYears') ? ' has-error' : '' }}">
            {!! Form::label('tagsYears', 'Years'); !!}

            @foreach($tagsYears as $tag)
                <label>{!! Form::checkbox('tagsYears[]', $tag->name, ($userYearTags->where("id", $tag->id)->where("type", 'year'))->count() == 1 ? true : false, ['class' => 'form-control', 'id' => $tag->name]) !!} {{$tag->name}}</label>
            @endforeach

        </div>
    </div>


    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group{{ $errors->has('tagsSectors') ? ' has-error' : '' }}">
            {!! Form::label('tagsSectors', 'Sector'); !!}

            @foreach($tagsSectors as $tag)
                <label>{!! Form::checkbox('tagsSectors[]', $tag->name, ($userSectorTags->where("id", $tag->id)->where("type", 'sector'))->count() == 1 ? true : false, ['class' => 'form-control', 'id' => $tag->name]) !!} {{$tag->name}}</label>
            @endforeach

        </div>
    </div>


    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>

</div>


@push('scripts')
<script>

    $(function () {
        $('[data-mask]').inputmask();
    });

</script>
@endpush
