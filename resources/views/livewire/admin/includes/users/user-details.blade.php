<div id="user-details" class="tab-pane @if ($activeTab == "user-details") active @else fade @endif">
    <div class="row">
        <div class="col-lg-6">

            <div class="form-group">
                {!! Form::label('system_id', 'System  ID'); !!}
                {!! Form::text('system_id', $this->system_id, array('placeholder' => 'System  ID','class' => 'form-control', 'maxlength' => 255, 'readonly', 'wire:model.defer' => 'system_id' )) !!}
            </div>

            <div class="form-group">
                {!! Form::label('first_name', 'First Name'); !!}
                {!! Form::text('first_name', $this->first_name, array('placeholder' => 'First Name','class' => 'form-control', 'maxlength' => 255, 'wire:model.defer' => 'first_name')) !!}
                @error('first_name') <div class="text-danger error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                {!! Form::label('last_name', 'Last Name'); !!}
                {!! Form::text('last_name', $this->last_name, array('placeholder' => 'Last Name','class' => 'form-control', 'maxlength' => 255, 'wire:model.defer' => 'last_name')) !!}
                @error('last_name') <div class="text-danger error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">

                {!! Form::label('birth_date', 'Date of Birth'); !!}
                <div class="input-group">
                {!! Form::text('birth_date', $this->birth_date, array('class' => 'form-control', 'data-inputmask-alias' => "datetime", 'data-inputmask-inputformat' => "dd/mm/yyyy", 'data-mask' => "", 'im-insert'=>"false", 'wire:model.defer' => 'birth_date')) !!}
                <div class="input-group-append">
                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                </div>
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('school_year', 'School Year'); !!}
                {!! Form::select('school_year', ['' => 'Please select'] + config('global.school_year'), $this->school_year, ['class' => 'form-control', 'wire:model.defer' => 'school_year']) !!}
                @error('school_year') <div class="text-danger error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                {!! Form::label('postcode', 'Postcode'); !!}
                {!! Form::text('postcode', $this->postcode, array('placeholder' => 'Postcode','class' => 'form-control', 'maxlength' => 10, 'wire:model.defer' => 'postcode')) !!}
                @error('postcode') <div class="text-danger error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                {!! Form::label('email', 'School Email Address'); !!}
                {!! Form::text('email', $this->email, array('placeholder' => 'School Email Address','class' => 'form-control', 'maxlength' => 255, 'wire:model.defer' => 'email')) !!}
                @error('email') <div class="text-danger error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                {!! Form::label('personal_email', 'Personal Email Address'); !!}
                {!! Form::text('personal_email', $this->personal_email, array('placeholder' => 'Personal Email Address','class' => 'form-control', 'maxlength' => 255, 'wire:model.defer' => 'personal_email')) !!}
                @error('personal_email') <div class="text-danger error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                {!! Form::label('password', 'Password'); !!}
                {!! Form::password('password', array('placeholder' => 'Password', 'autocomplete' =>"off", 'class' => 'form-control', 'maxlength' => 255, 'wire:model.defer' => 'password')) !!}
                @error('password') <div class="text-danger error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                {!! Form::label('confirm-password', 'Confirm Password'); !!}
                {!! Form::password('confirm-password', array('placeholder' => 'Confirm Password', 'autocomplete' =>"off", 'class' => 'form-control', 'maxlength' => 255, 'wire:model.defer' => 'confirmPassword'))
                !!}
            </div>

        </div>
    </div>
</div>

@push('scripts')
<script>

    $(function () {
        $('[data-mask]').inputmask();
    });

</script>
@endpush
