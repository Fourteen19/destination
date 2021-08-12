<div class="row">
    <div class="col-lg-6">
        <form wire:submit.prevent="submit">

            <div class="form-group">
                {!! Form::label('password', 'Enter New Password'); !!}
                <input type="password" class="form-control" id="password" class="'form-control form-control-lg" maxlength="255" placeholder="New Password" wire:model.defer="password">
                @error('password') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                {!! Form::label('password_confirmation', 'Confirm New Password'); !!}
                <input type="password" class="form-control" id="password_confirmation" class="'form-control form-control-lg" maxlength="255" placeholder="Confirm New Password" wire:model.defer="password_confirmation">
                @error('password_confirmation') <span class="error">{{ $message }}</span> @enderror
            </div>

            <button type="submit" wire:loading.attr="disabled" class="platform-button border-0 t-def mt-5">
                Save
            </button>

            {{ $updateMessage }}

            @if ($result == True)
                <button type="submit" wire:click="goToSelfAssessment" wire:loading.attr="disabled" class="platform-button border-0 t-def mt-5">
                    Continue
                </button>
            @endif

        </form>
    </div>
</div>
