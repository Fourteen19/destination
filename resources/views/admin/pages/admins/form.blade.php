<div class="row">

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
{{--    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
            {!! Form::label('role', 'Role'); !!}
            {!! Form::select('role', $roles, isset($role) ? $role : '', array('class' => 'form-control', 'id' => 'role', 'wire:model' => "client" )) !!}
        </div>
    </div>

    @role('System Administrator', 'admin')
        <div class="col-xs-12 col-sm-12 col-md-12" style="display:none" id="client_container">
            <div class="form-group{{ $errors->has('client') ? ' has-error' : '' }}">
                {!! Form::label('client', 'Client'); !!}
                {!! Form::select('client', $clients = [],[], array('class' => 'form-control', 'id' => 'client')) !!}
            </div>
        </div>
    @endrole

    @role('System Administrator|Client Admin', 'admin')
        <div class="col-xs-12 col-sm-12 col-md-12" style="display:none" id="institution_container">
            <div class="form-group">
                <strong>Institution:</strong>
                {!! Form::select('institution[]', $institutions = [],[], array('class' => 'form-control', 'id' => 'institution', 'size'=>1, 'multiple'=>'multiple')) !!}
            </div>
        </div>
    @endrole

--}}

    <div>livewire component
        <livewire:admin.admin-client-institution :roles="$roles" :client="1"/>
    </div>


    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>

</div>
