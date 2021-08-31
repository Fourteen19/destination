<div class="row">

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group{{ $errors->has('introduction') ? ' has-error' : '' }}">
            {!! Form::label('introduction', 'Introduction'); !!}
            {!! Form::textarea('introduction', $advisorData->pivot->introduction, array('placeholder' => 'Introduction', 'rows' => 5, 'cols' => 40, 'class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group{{ $errors->has('times_location') ? ' has-error' : '' }}">
            {!! Form::label('times_location', 'Available times / location'); !!}
            {!! Form::textarea('times_location', $advisorData->pivot->times_location, array('placeholder' => 'Available times / location', 'rows' => 5, 'cols' => 40, 'class' => 'form-control')) !!}
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <button type="submit" class="btn mydir-button">Submit</button>
    </div>

</div>
