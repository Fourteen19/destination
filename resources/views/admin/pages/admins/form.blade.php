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

    @livewire('admin.allocate-role-to-admin', ['roleParam' => (!empty(old('role'))) ? old('role') : $admin->getRoleNames()->first(),
                                                'clientParam' => (!empty(old('client'))) ? old('client') : ( (isset($admin->client->uuid)) ? $admin->client->uuid : ''),
                                                'institutionsParam' => (!empty(old('institutions'))) ? old('institutions') : $admin->institutions,
                                                'contactMeParam' => (!empty(old('first_name'))) ? old('first_name') : $admin->contact_me,
                                                'adminUuid' => $admin->uuid,
                                                'employerParam' => (!empty(old('employer'))) ? old('employer') : ( (isset($admin->employer_id)) ? $admin->employer_id : ''),
                                                  ])

    <div class="col-xs-12 col-sm-12 col-md-12">
        <button type="submit" class="btn mydir-button">Save</button>
    </div>

</div>
