<div class="row">

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            {!! Form::label('name', 'Name'); !!}
            {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control', 'maxlength' => 255)) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-split"></div>
        <h2 class="border-bottom pb-2 mt-4 mb-4">Work Experience Module</h2>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group form-check">
            {{ Form::checkbox('work_experience' , 'Y', ($institution->work_experience == "Y" ) ? true : false , ['class' => 'form-check-input', 'id' => 'work_experience'] ) }}
            {!! Form::label('work_experience', 'This institution can access work experience content', ['for' => 'workexp']) !!}
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <button type="submit" class="btn mydir-button">Submit</button>
    </div>

</div>
