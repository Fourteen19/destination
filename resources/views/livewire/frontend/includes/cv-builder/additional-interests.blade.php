<div id="additional-interests" class="tab-pane @if ($activeTab == "additional-interests") active @else fade @endif">
    <div class="row">
        <div class="col-lg-6">

            <div class="form-group">
                {!! Form::label('additional_interests', 'Additional Interests'); !!}
                {!! Form::textarea('additional_interests', $this->additional_interests, array('placeholder' => 'Additional Interests', 'class' => 'form-control', 'cols' => 40, 'rows' => 5, 'wire:model.defer' => 'additional_interests')) !!}
                @error('additional_interests') <div class="text-danger error">{{ $message }}</div>@enderror
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <button type="button" wire:click.prevent="updateTab('education')" wire:loading.attr="disabled" class="btn mydir-button mr-2">Previous</button>
        </div>
        <div class="col-lg-6">
            <button type="button" wire:click.prevent="updateTab('references')" wire:loading.attr="disabled" class="btn mydir-button mr-2">Next</button>
        </div>
    </div>

</div>
