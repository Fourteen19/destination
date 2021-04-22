<div class="row">

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
            {!! Form::label('title', 'Title'); !!}
            {!! Form::select('title', config('global.admin_title'), NULL, array('class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
            {!! Form::label('first_name', 'First Name'); !!}
            {!! Form::text('first_name', null, array('placeholder' => 'First Name','class' => 'form-control', 'maxlength' => 50)) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
            {!! Form::label('last_name', 'Last Name'); !!}
            {!! Form::text('last_name', null, array('placeholder' => 'Last Name','class' => 'form-control', 'maxlength' => 50)) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            {!! Form::label('email', 'Email'); !!}
            {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control')) !!}
        </div>
    </div>


    @hasrole(config('global.admin_user_type.Advisor'))
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group form-check">
                {!! Form::checkbox('contact_me', 'Y', ( (old('contact_me')) || ($admin->contact_me == 'Y') ) ? 'Y' : '', ['class' => 'form-check-input', 'id' => 'contact_me', 'name' => 'contact_me']) !!}
                <label class="form-check-label" for="contact_me">Can be contacted by users</label>
            </div>
        </div>
    @endrole

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            {!! Form::label('password', 'Password'); !!}
            {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group{{ $errors->has('confirm-password') ? ' has-error' : '' }}">
            {!! Form::label('confirm-password', 'Confirm Password'); !!}
            {!! Form::password('confirm-password', array('placeholder' => 'Confirm Password','class' => 'form-control')) !!}
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <button type="submit" class="btn mydir-button">Save</button>
    </div>

</div>
