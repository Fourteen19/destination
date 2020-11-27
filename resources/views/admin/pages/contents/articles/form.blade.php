<div class="row">

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
            {!! Form::label('title', 'Title'); !!}
            {!! Form::text('title', (!isset($content->contentable->title)) ? null : $content->contentable->title, array('placeholder' => 'Title','class' => 'form-control', 'maxlength' => 255)) !!}
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group{{ $errors->has('lead') ? ' has-error' : '' }}">
            {!! Form::label('lead', 'Lead Paragraph'); !!}
            {!! Form::textarea('lead', (!isset($content->contentable->lead)) ? null : $content->contentable->lead, array('placeholder' => 'Lead Paragraph','class' => 'form-control tiny', 'cols' => 40, 'rows' => 5)) !!}
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group{{ $errors->has('body') ? ' has-error' : '' }}">
            {!! Form::label('body', 'Body'); !!}
            {!! Form::text('body', (!isset($content->contentable->body)) ? null : $content->contentable->body, array('placeholder' => 'Body','class' => 'form-control', 'maxlength' => 255)) !!}
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group{{ $errors->has('tagsSubjects') ? ' has-error' : '' }}">
            {!! Form::label('tagsSubjects', 'Subject Tags'); !!}

            @foreach($tagsSubjects as $tagsSubject)
                <label>{!! Form::checkbox('tagsSubjects[]', $tagsSubject->name, ($contentSubjectTags->where("id", $tagsSubject->id)->where("type", 'subject'))->count() == 1 ? true : false, ['class' => 'form-control', 'id' => $tagsSubject->name]) !!} {{$tagsSubject->name}}</label>
            @endforeach

        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>

</div>
