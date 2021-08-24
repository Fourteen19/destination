<div id="personal-profile" class="tab-pane @if ($activeTab == "personal-profile") active @else fade @endif">
    <div class="row">
        <div class="col-lg-6">

            {{ $staticContent['cv_personal_profile_instructions'] }}

            <div class="form-group">
                {!! Form::label('personal_profile', 'Personal Profile'); !!}
                {!! Form::textarea('personal_profile', $this->personal_profile, array('placeholder' => 'Personal Profile', 'class' => 'form-control', 'cols' => 40, 'rows' => 5, 'wire:model.defer' => 'personal_profile')) !!}
                @error('personal_profile') <div class="text-danger error">{{ $message }}</div>@enderror
            </div>

            {!! $staticContent['cv_personal_profile_example'] !!}

        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <button type="button" wire:click.prevent="updateTab('personal-details')" wire:loading.attr="disabled" class="btn mydir-button mr-2">Previous</button>
        </div>
        <div class="col-lg-6">
            <button type="button" wire:click.prevent="updateTab('employment')" wire:loading.attr="disabled" class="btn mydir-button mr-2">Next</button>
        </div>
    </div>

</div>
