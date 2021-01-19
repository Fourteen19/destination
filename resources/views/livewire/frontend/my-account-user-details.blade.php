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
            <div class="form-group" wire:ignore>
                <label for="SchoolorCollege">School or College</label>
                <input type="text" class="form-control form-control-lg" id="SchoolorCollege" placeholder="{{ Auth::guard('web')->user()->institution->name }}" readonly>
            </div>
            <div class="form-group" wire:ignore>
                <label for="SchoolYear">School Year</label>
                <input type="text" class="form-control form-control-lg" id="SchoolYear" placeholder="{{ Auth::guard('web')->user()->school_year }}" readonly>
            </div>
            <div class="form-group">
                {!! Form::label('postcode', 'Postcode'); !!}
                {!! Form::text('postcode', null, array('name' => 'postcode', 'id' => 'postcode', 'placeholder' => 'Postcode','class' => 'form-control form-control-lg', 'maxlength' => 255, 'wire:model' => 'postcode')) !!}
                @error('postcode') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group" wire:ignore>
                <label for="Schoolemailaddress">School email address</label>
                <input type="email" class="form-control form-control-lg" id="Schoolemailaddress " placeholder="{{ Auth::guard('web')->user()->email }}" readonly>
            </div>
            <div class="form-group">
                {!! Form::label('personalEmail', 'Personal email address'); !!}
                {!! Form::text('personalEmail', null, array('name' => 'personal_email', 'id' => 'personal_email', 'placeholder' => 'Personal email address','class' => 'form-control form-control-lg', 'maxlength' => 255, 'wire:model' => 'personalEmail')) !!}
                @error('personalEmail') <span class="error">{{ $message }}</span> @enderror
            </div>
            <button type="submit" class="platform-button border-0 t-def mt-5">
                Save
            </button>

            {{ $updateMessage }}

        </form>
    </div>
</div>
