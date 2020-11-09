<div class="row">

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            {!! Form::label('name', 'Name'); !!}
            {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control', 'maxlength' => 255)) !!}
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group{{ $errors->has('subdomain') ? ' has-error' : '' }}">
            {!! Form::label('subdomain', 'Subdomain'); !!}
            {!! Form::text('subdomain', null, array('placeholder' => 'Subdomain','class' => 'form-control', 'maxlength' => 255)) !!}
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group{{ $errors->has('subdomain') ? ' has-error' : '' }}">
            {!! Form::label('website', 'Website'); !!}
            {!! Form::text('website', null, array('placeholder' => 'Website','class' => 'form-control', 'maxlength' => 255)) !!}
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group{{ $errors->has('contact') ? ' has-error' : '' }}">
            {!! Form::label('contact', 'Contact'); !!}
            {!! Form::text('contact', null, array('placeholder' => 'Contact','class' => 'form-control', 'maxlength' => 255)) !!}
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>

</div>
