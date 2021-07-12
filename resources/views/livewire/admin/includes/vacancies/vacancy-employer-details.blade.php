<div id="vacancy-employer-details" class="tab-pane px-0 @if ($activeTab == "vacancy-employer-details") active @else fade @endif" wire:key="vacancy-employer-details-pane">
    <div class="row">
        <div class="col-lg-6">

            <div class="form-group">
                {!! Form::label('employer', 'Employer'); !!}
                @error('employer') <span class="text-danger error">{{ $message }}</span>@enderror
                {!! Form::select('employer', $this->employersList, null, ['placeholder' => 'Please select', 'class' => "form-control", 'wire:model.lazy' => "employer", 'id' => "employer" ]); !!}
                <small>If the employer does not exist then <a href="{{ route('admin.employers.create') }}">click here to create them.</a></small>
            </div>

        </div>
    </div>
</div>
