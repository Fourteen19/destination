<div class="row">

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
            {!! Form::label('title', 'Title'); !!}
            {!! Form::text('title', null, array('placeholder' => 'Title','class' => 'form-control', 'maxlength' => 255)) !!}
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group{{ $errors->has('body') ? ' has-error' : '' }}">
            {!! Form::label('body', 'Body'); !!}
            {!! Form::text('body', null, array('placeholder' => 'Body','class' => 'form-control', 'maxlength' => 255)) !!}
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group{{ $errors->has('tagsSubjects') ? ' has-error' : '' }}">
            {!! Form::label('tagsSubjects', 'Subject Tags'); !!}

            @foreach($tagsSubjects as $tagsSubject)
            {{ $tagsSubject->id }}
                <label>{!! Form::checkbox('tagsSubjects[]', $tagsSubject->name, ($contentSubjectTags->where("id", $tagsSubject->id)->where("type", 'subject'))->count() == 1 ? true : false, ['class' => 'form-control', 'id' => $tagsSubject->name]) !!} {{$tagsSubject->name}}</label>
            @endforeach

        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>

</div>
