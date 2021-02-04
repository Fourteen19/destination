<div id="user-details" class="tab-pane active">
    <div class="row">
        <div class="col-lg-6">

            <div class="form-group">
                {!! Form::label('system_id', 'System  ID'); !!}
                {!! Form::text('system_id', null, array('placeholder' => 'System  ID','class' => 'form-control', 'readonly', 'wire:model.defer' => 'first_name' )) !!}
            </div>

            <div class="form-group">
                {!! Form::label('first_name', 'First Name'); !!}
                {!! Form::text('first_name', null, array('placeholder' => 'First Name','class' => 'form-control', 'wire:model.defer' => 'first_name')) !!}
            </div>

            <div class="form-group">
                {!! Form::label('last_name', 'Last Name'); !!}
                {!! Form::text('last_name', null, array('placeholder' => 'Last Name','class' => 'form-control', 'wire:model.defer' => 'last_name')) !!}
            </div>

            <div class="form-group">

                {!! Form::label('birth_date', 'Date of Birth'); !!}
                <div class="input-group">
                {!! Form::text('birth_date', null, array('class' => 'form-control', 'data-inputmask-alias' => "datetime", 'data-inputmask-inputformat' => "dd/mm/yyyy", 'data-mask' => "", 'im-insert'=>"false", 'wire:model.defer' => 'birthDate')) !!}
                <div class="input-group-append">
                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                </div>
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('school_year', 'School Year'); !!}
                {!! Form::select('school_year', ['7'=>'7', '8'=>'8', '9'=>'9', '10'=>'10', '11'=>'11', '12'=>'12', '13'=>'13', '14'=>'post education'], null, ['class' => 'form-control', 'wire:model.defer' => 'schoolYear']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('postcode', 'Postcode'); !!}
                {!! Form::text('postcode', null, array('placeholder' => 'Postcode','class' => 'form-control', 'wire:model.defer' => 'postcode')) !!}
            </div>

            <div class="form-group">
                {!! Form::label('email', 'School Email Address'); !!}
                {!! Form::text('email', null, array('placeholder' => 'School Email Address','class' => 'form-control', 'wire:model.defer' => 'email')) !!}
            </div>

            <div class="form-group">
                {!! Form::label('personal_email', 'Personal Email Address'); !!}
                {!! Form::text('personal_email', $this->personalEmail, array('placeholder' => 'Personal Email Address','class' => 'form-control', 'wire:model.defer' => 'personalEmail')) !!}
            </div>

            <div class="form-group">
                {!! Form::label('password', 'Password'); !!}
                {!! Form::password('password', array('placeholder' => 'Password', 'autocomplete' =>"off", 'class' => 'form-control', 'wire:model.defer' => 'password')) !!}
            </div>

            <div class="form-group">
                {!! Form::label('confirm-password', 'Confirm Password'); !!}
                {!! Form::password('confirm-password', array('placeholder' => 'Confirm Password', 'autocomplete' =>"off", 'class' => 'form-control', 'wire:model.defer' => 'confirmPassword'))
                !!}
            </div>

        </div>
    </div>
</div>
