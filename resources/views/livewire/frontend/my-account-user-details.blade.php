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
{{--
            <div class="form-group" wire:ignore>
                <label for="Schoolemailaddress">School email address</label>
                <input type="email" class="form-control form-control-lg" id="Schoolemailaddress " placeholder="{{ Auth::guard('web')->user()->email }}" readonly>
            </div>
--}}
            <div class="form-group">
                {!! Form::label('primaryEmail', 'School email address'); !!}
                {!! Form::text('primaryEmail', null, array('name' => 'primary_email', 'id' => 'primary_email', 'placeholder' => 'School email address','class' => 'form-control form-control-lg', 'maxlength' => 255, 'wire:model.defer' => 'primaryEmail')) !!}
                @error('primaryEmail') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                {!! Form::label('confirmPrimaryEmail', 'Confirm School email address'); !!}
                {!! Form::text('confirmPrimaryEmail', null, array('name' => 'confirm_primary_email', 'id' => 'confirm_primary_email', 'placeholder' => 'Confirm school email address','class' => 'form-control form-control-lg', 'maxlength' => 255, 'wire:model.defer' => 'confirmPrimaryEmail')) !!}
                @error('confirmPrimaryEmail') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                {!! Form::label('personalEmail', 'Alternate email address'); !!}
                {!! Form::text('personalEmail', null, array('name' => 'personal_email', 'id' => 'personal_email', 'placeholder' => 'Personal email address','class' => 'form-control form-control-lg', 'maxlength' => 255, 'wire:model.defer' => 'personalEmail')) !!}
                @error('personalEmail') <span class="error">{{ $message }}</span> @enderror
                <div class="mt-3 t14">If you have add an alternative email address this will be cc'd in any emails you receive from us (e.g. password reset).</div>
            </div>

            @if (Auth::guard('web')->user()->type == 'user')

                <div class="form-group">
                    {!! Form::label('password', 'Password'); !!}
                    <input type="password" class="form-control" id="password" class="'form-control form-control-lg" maxlength="255" placeholder="New Password" wire:model.defer="password">
                    @error('password') <span class="error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    {!! Form::label('password_confirmation', 'Confirm Password'); !!}
                    <input type="password" class="form-control" id="password_confirmation" class="'form-control form-control-lg" maxlength="255" placeholder="Confirm New Password" wire:model.defer="password_confirmation">
                    @error('password_confirmation') <span class="error">{{ $message }}</span> @enderror
                </div>

            @endif

            <button type="submit" wire:loading.attr="disabled" class="platform-button border-0 t-def mt-5">
                Save
            </button>

            {{ $updateMessage }}

        </form>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function(){
    $('#confirm_primary_email').bind('cut copy paste', function (e) {
        e.preventDefault();
    });
});
</script>
@endpush
