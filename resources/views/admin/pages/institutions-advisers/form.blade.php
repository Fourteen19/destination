<div class="row">

    @forelse ($advisors as $advisor)

        <div class="col-xs-12 col-sm-12 col-md-12">
            <b><p>{{$advisor->TitleFullName}}</p></b>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group{{ $errors->has('introduction') ? ' has-error' : '' }}">
                {!! Form::label('introduction['.$advisor->uuid.']', 'Introduction'); !!}
                {!! Form::textarea('introduction['.$advisor->uuid.']', $advisor->institutions->first()->pivot->introduction, array('placeholder' => 'Introduction', 'rows' => 5, 'cols' => 40, 'class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group{{ $errors->has('times_location') ? ' has-error' : '' }}">
                {!! Form::label('times_location['.$advisor->uuid.']', 'Available times / location'); !!}
                {!! Form::textarea('times_location['.$advisor->uuid.']', $advisor->institutions->first()->pivot->times_location, array('placeholder' => 'Available times / location', 'rows' => 5, 'cols' => 40, 'class' => 'form-control')) !!}
            </div>
        </div>

        <hr>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <button type="submit" class="btn mydir-button">Submit</button>
        </div>

    @empty

        <div class="col-xs-12 col-sm-12 col-md-12">
            <b><p>This institution does not have any allocated adviser</p></b>
        </div>

    @endforelse

</div>
