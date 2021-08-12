<div class="row">
    <div class="col-lg-6">
        <form wire:submit.prevent="submit">
            <div class="form-group" wire:ignore>
                <label for="Firstname">First name</label>
                <input type="text" class="form-control form-control-lg" id="Firstname" placeholder="{{ Auth::guard('web')->user()->first_name }}" readonly>
            </div>
            <div class="form-group" wire:ignore>
                <label for="Surname">Surname</label>
                <input type="text" class="form-control form-control-lg" id="Surname" placeholder="{{ Auth::guard('web')->user()->last_name }}" readonly>
            </div>
            <div class="form-group" wire:ignore>
                <label for="Dateofbirth">Date of birth</label>
                <input type="text" class="form-control form-control-lg" id="Dateofbirth" placeholder="{{ Auth::guard('web')->user()->birth_date }}" readonly>
            </div>

            @if (Auth::guard('web')->user()->institution)
                <div class="form-group" wire:ignore>
                    <label for="SchoolorCollege">School or College</label>
                    <input type="text" class="form-control form-control-lg" id="SchoolorCollege" placeholder="{{ Auth::guard('web')->user()->institution->name }}" readonly>
                </div>
            @endif

            <div class="form-group" wire:ignore>
                <label for="SchoolYear">School Year</label>
                <input type="text" class="form-control form-control-lg" id="SchoolYear" placeholder="{{ Auth::guard('web')->user()->school_year }}" readonly>
            </div>
            <div class="form-group">
                {!! Form::label('postcode', 'Postcode'); !!}
                {!! Form::text('postcode', null, array('name' => 'postcode', 'id' => 'postcode', 'placeholder' => 'Postcode','class' => 'form-control form-control-lg', 'maxlength' => 255, 'wire:model.defer' => 'postcode')) !!}
                @error('postcode') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group" wire:ignore>
                <label for="Schoolemailaddress">School email address</label>
                <input type="email" class="form-control form-control-lg" id="Schoolemailaddress " placeholder="{{ Auth::guard('web')->user()->email }}" readonly>
            </div>
            <div class="form-group">
                {!! Form::label('personalEmail', 'Personal email address'); !!}
                {!! Form::text('personalEmail', null, array('name' => 'personal_email', 'id' => 'personal_email', 'placeholder' => 'Personal email address','class' => 'form-control form-control-lg', 'maxlength' => 255, 'wire:model.defer' => 'personalEmail')) !!}
                @error('personalEmail') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                {!! Form::label('password', 'Password'); !!}
                {{-- {!! Form::password('password', null, array('name' => 'password', 'id' => 'password', 'placeholder' => 'Password','class' => 'form-control form-control-lg', 'maxlength' => 255, 'wire:model' => 'password')) !!} --}}
                <input type="password" class="form-control" id="password" class="'form-control form-control-lg" maxlength="255" placeholder="New Password" wire:model.defer="password">
                @error('password') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                {!! Form::label('password_confirmation', 'Confirm Password'); !!}
                {{-- {!! Form::password('password_confirmation', null, array('name' => 'password_confirmation', 'id' => 'password_confirmation', 'placeholder' => 'Confirm Password','class' => 'form-control form-control-lg', 'maxlength' => 255, 'wire:model' => 'password_confirmation')) !!} --}}
                <input type="password" class="form-control" id="password_confirmation" class="'form-control form-control-lg" maxlength="255" placeholder="Confirm New Password" wire:model.defer="password_confirmation">
                @error('password_confirmation') <span class="error">{{ $message }}</span> @enderror
            </div>

            <button type="submit" wire:loading.attr="disabled" class="platform-button border-0 t-def mt-5">
                Save
            </button>

            {{ $updateMessage }}

        </form>
    </div>
</div>
