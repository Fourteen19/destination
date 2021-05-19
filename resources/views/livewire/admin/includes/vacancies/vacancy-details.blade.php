<div id="vacancy-details" class="tab-pane px-0 @if ($activeTab == "vacancy-details") active @else fade @endif" wire:key="vacancy-details-pane">
    <div class="row">
        <div class="col-lg-6">

            <div class="form-group">
                {!! Form::label('vacancy_title', 'Vacancy Title'); !!}
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
                {!! Form::label('employer_name', 'Employer Name'); !!}
                {!! Form::text('employer_name', $this->title, array('placeholder' => 'Employer Name','class' => 'form-control', 'maxlength' => 255, 'wire:model.defer' => 'employer_name' )) !!}
            </div>

            <div class="form-group">
                @error('employer_logo') <span class="text-danger error">{{ $message }}</span>@enderror
                {!! Form::label('employer_logo', 'Employer Logo'); !!}
                <div class="input-group">
                {!! Form::text('employer_logo', null, array('placeholder' => 'Employer Logo','class' => 'form-control', 'maxlength' => 255, 'id' => "employer_logo", 'wire:model' => 'employerLogo' )) !!}
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button" id="button-employer-logo">Select</button>
                </div>
                </div>
                <div class="article-image-preview">
                    <img src="{{ $employerLogoOriginal }}">
                </div>
            </div>

            <div class="form-group">
            <label for="role_type">Role Type</label>
            <select class="form-control" wire:model.lazy="role_type" id="role_type" name="role_type">
                <option value="Please select">Please select</option>
                <option value="Full Time">Full Time</option>
                <option value="Part Time">Part Time</option>
                <option value="Apprenticeship">Apprenticeship</option>
            </select>
            </div>

            <div class="form-group">
            <label for="area">Area</label>
            <select class="form-control" wire:model.lazy="area" id="area" name="area">
                <option value="Please select">Please select</option>
                <option value="Area 1">Area 1</option>
                <option value="Area 2">Area 2</option>
                <option value="Area 3">Area 3</option>
            </select>
            </div>

            <div class="form-group">
            <label for="category">Category</label>
            <select class="form-control" wire:model.lazy="category" id="category" name="category">
                <option value="Please select">Please select</option>
                <option value="Category 1">Category 1</option>
                <option value="Category 2">Category 2</option>
                <option value="Category 3">Category 3</option>
            </select>
            </div>

            <div class="form-group">
                {!! Form::label('apply_link', 'Apply Online Link'); !!}
                {!! Form::text('apply_link', $this->title, array('placeholder' => 'Apply Online Link i.e. https://www.link.com','class' => 'form-control', 'maxlength' => 255, 'wire:model.defer' => 'apply_link' )) !!}
            </div>


        </div>
    </div>
</div>
