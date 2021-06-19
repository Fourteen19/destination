<div id="vacancy-details" class="tab-pane px-0 @if ($activeTab == "vacancy-details") active @else fade @endif" wire:key="vacancy-details-pane">
    <div class="row">
        <div class="col-lg-6">

            <div class="form-group">
                {!! Form::label('vacancy_title', 'Vacancy Title'); !!}
                @error('title') <span class="text-danger error">{{ $message }}</span>@enderror
                {!! Form::text('vacancy_title', $this->title, array('placeholder' => 'Vacancy Title','class' => 'form-control', 'maxlength' => 255, 'wire:model.defer' => 'title' )) !!}
            </div>

            <div class="form-group">
                {!! Form::label('contact_name', 'Contact Name'); !!}
                {!! Form::text('contact_name', $this->title, array('placeholder' => 'Contact Name','class' => 'form-control', 'maxlength' => 255, 'wire:model.defer' => 'contact_name' )) !!}
            </div>

            <div class="form-group">
                {!! Form::label('contact_number', 'Contact Number'); !!}
                {!! Form::text('contact_number', $this->title, array('placeholder' => 'Contact Number','class' => 'form-control', 'maxlength' => 255, 'wire:model.defer' => 'contact_number' )) !!}
            </div>

            <div class="form-group">
                {!! Form::label('contact_email', 'Contact Email'); !!}
                {!! Form::text('contact_email', $this->title, array('placeholder' => 'Contact Email','class' => 'form-control', 'maxlength' => 255, 'wire:model.defer' => 'contact_email' )) !!}
            </div>

            <div class="form-group">
                {!! Form::label('contact_link', 'Contact Link'); !!}
                {!! Form::text('contact_link', $this->title, array('placeholder' => 'Contact Link','class' => 'form-control', 'maxlength' => 255, 'wire:model.defer' => 'contact_link' )) !!}
            </div>

            <div class="form-group">
                {!! Form::label('role_type', 'Role Type'); !!}
                @error('role_type') <span class="text-danger error">{{ $message }}</span>@enderror
                {!! Form::select('role_type', $this->roles, null, ['placeholder' => 'Please select', 'class' => "form-control", 'wire:model.defer' => "role_type", 'id' => "role_type" ]); !!}
            </div>

            <div class="form-group">
                {!! Form::label('region', 'Area'); !!}
                @error('region') <span class="text-danger error">{{ $message }}</span>@enderror
                {!! Form::select('region', $this->regions, null, ['placeholder' => 'Please select', 'class' => "form-control", 'wire:model.defer' => "region", 'id' => "region" ]); !!}
            </div>

            <div class="form-group">
                {!! Form::label('online_link', 'Apply Online Link'); !!}
                {!! Form::text('online_link', $this->title, array('placeholder' => 'Apply Online Link i.e. https://www.link.com','class' => 'form-control', 'maxlength' => 255, 'wire:model.defer' => 'online_link' )) !!}
            </div>

        </div>
    </div>
</div>
