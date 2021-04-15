<div class="row">

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            {!! Form::label('name', 'Name'); !!}
            {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control', 'maxlength' => 255)) !!}
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group form-check">
            {!! Form::label('work_experience', 'Work Experience'); !!}
            {{ Form::checkbox('work_experience' , 'Y', ($institution->work_experience == "Y" ) ? true : false , array('class' => 'form-check-input' ) ) }}
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <button type="submit" class="btn mydir-button">Submit</button>
    </div>

</div>
